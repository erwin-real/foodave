<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\MyChart;

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
        $chart->labels(['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5']);
        $chart->dataset('report 1', 'line', [1, 2, 3, 4, 3.4]);
        $chart->dataset('report 2', 'line', [2, 3, 2.5, 4, 4.6]);
        $chart->dataset('report 3', 'line', [1.5, 2.3, 4.2, 3.2, 4]);
        $chart->dataset('report 4', 'line', [3, 2, 4, 3, 5]);

        return view('pages.reports')
            ->with('chart', $chart);
    }
}
