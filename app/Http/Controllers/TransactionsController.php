<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SingleTransaction;
use App\Transaction;

class TransactionsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.transactions')
            ->with('transactions', Transaction::orderBy('created_at', 'desc')->paginate(15));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.transactions.create')
            ->with('products', Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $capital = 0;
        $income = 0;

        $transaction = new Transaction;
        $transaction->total = $request->get('total');
        $transaction->money_received = $request->get('money');
        $transaction->change = $request->get('change');
        $transaction->capital = $capital;
        $transaction->income = $income;
        $transaction->save();

        foreach ($request->get('transactions') as $transac) {
            $singleTransaction = new SingleTransaction;
            $singleTransaction->transaction_id = $transaction->id;
            $singleTransaction->product_id = $transac['product_id'];
            $singleTransaction->quantity = $transac['quantity'];
            $singleTransaction->total = $transac['subtotal'];
            $singleTransaction->capital = $transac['quantity'] * $singleTransaction->product->price;
            $singleTransaction->income = $transac['subtotal'] - $singleTransaction->capital;
            $singleTransaction->save();

            $product = Product::find($singleTransaction->product_id);
            $product->stocks -= $singleTransaction->quantity;
            $product->save();

            $capital += $singleTransaction->capital;
            $income += $singleTransaction->income;
        }

        $transaction = Transaction::find($transaction->id);
        $transaction->capital = $capital;
        $transaction->income = $income;
        $transaction->save();

        return "success";

        // $returnHTML = view('pages.transactions')->with('success', 'Transaction Finished')->render();
        // return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('pages.transactions.single')
            ->with('transaction', Transaction::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        
        return redirect('/transactions')->with('success', 'Transaction Deleted');
    }
    
    public function get(Request $request) {
        if ($request->ajax()) return $this->store($request);
    }
}
