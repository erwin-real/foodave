<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\MyChart;
use App\Transaction;
use DateTime;
use DB;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $chart = new MyChart;
        $data = $this->organizeDailyTransactions();
        $chart->labels($data['dates']);
        $chart->dataset('Total', 'line', $data['totals']);
        $chart->dataset('Capital', 'line', $data['capitals']);
        $chart->dataset('Income', 'line', $data['incomes']);

        return view('pages.reports')
            ->with('chart', $chart)
            ->with('transactions', $data['transactions']);        
    }

    public function organizeDailyTransactions() {
        $transactions = Transaction::all();
        $date = new DateTime('tomorrow -1 month');        
        $days = Transaction::select(array(
            DB::raw('DATE(`created_at`) as `date`'),
            DB::raw('COUNT(*) as `count`')
        ))
        ->where('created_at', '>', $date)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->pluck('count', 'date');
        
        $incomes = collect();
        $totals = collect();
        $capitals = collect();
        $dates = collect();

        foreach($days as $date=>$count) {
            $income = 0;
            $capital = 0;
            $total = 0;
            foreach($transactions as $transaction) {
                if($date === $transaction->created_at->format('Y-m-d')) {
                    $income += $transaction->income;
                    $capital += $transaction->capital;
                    $total += $transaction->total;
                }
            }
            $dates->push(\Carbon\Carbon::parse($date)->format('D M d,Y'));
            $incomes->push($income);
            $totals->push($total);
            $capitals->push($capital);
        }

        return array(
            'transactions' => $transactions,
            'dates' => $dates,
            'incomes' => $incomes,
            'totals' => $totals,
            'capitals' => $capitals,
        );
    }
}
