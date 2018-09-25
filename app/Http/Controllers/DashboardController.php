<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

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
        return view('dashboard');
    }

    public function procurement() {
        $products = Product::orderBy('updated_at','desc')->get();

        return view('pages.procurement')
            ->with('products', $products);
    }
}
