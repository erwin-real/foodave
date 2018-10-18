<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\Transaction;

class DashboardController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard')
            ->with('transactions', Transaction::all())
            ->with('procurements', Product::orderBy('updated_at','desc')->whereRaw('products.stocks <= products.procurement')->get());
    }

    public function procurement() {
        return view('pages.procurement')
            ->with('procurements', Product::orderBy('updated_at','desc')->whereRaw('products.stocks <= products.procurement')->get());
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
            $dates->push($date);
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
            $incomes->push($income);
            $totals->push($total);
            $capitals->push($capital);
        }

        return array(
            'dates' => $dates,
            'incomes' => $incomes,
            'totals' => $totals,
            'capitals' => $capitals,
        );
    }
}
