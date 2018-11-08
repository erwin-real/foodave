<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\MyChart;
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
            ->with('procurements', Product::orderBy('updated_at','desc')->whereRaw('products.stocks <= products.procurement')->get())
            ->with('chart', $this->createChart());
    }

    public function procurement() {
        return view('pages.procurement')
            ->with('procurements', Product::orderBy('updated_at','desc')->whereRaw('products.stocks <= products.procurement')->get());
    }
    
    public function createChart() {
        $data = app('App\Http\Controllers\ReportsController')->organizeDailyTransactions();

        $chart = new MyChart;
        $chart->labels(array_slice($data['dates']->toArray(), -7));
        $chart->dataset('Total', 'line', array_slice($data['totals']->toArray(), -7))->options(['color' => '#f0f',]);
        $chart->dataset('Capital', 'line', array_slice($data['capitals']->toArray(), -7))->options(['color' => '#6c757d',]);
        $chart->dataset('Income', 'line', array_slice($data['incomes']->toArray(), -7))->options(['color' => '#3490dc',]);

        return $chart;       
    }

}
