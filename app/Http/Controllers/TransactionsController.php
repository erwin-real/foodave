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
        return view('pages.transactions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('pages.transactions.create')
            ->with('products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo json_encode($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
    
    public function get(Request $request) {
        // $data = array(
        //     'total' => $request->get('total')
        // );
        // echo json_encode($data);
        if ($request->ajax()) {

            $transaction = new Transaction;
            $transaction->total = $request->get('total');
            $transaction->money_received = $request->get('money');
            $transaction->change = $request->get('change');
            $transaction->save();

            foreach ($request->get('transactions') as $transac) {
                $singleTransaction = new SingleTransaction;
                $singleTransaction->transaction_id = $transaction->id;
                $singleTransaction->product_id = $transac['product_id'];
                $singleTransaction->quantity = $transac['quantity'];
                $singleTransaction->subtotal = $transac['subtotal'];
                $singleTransaction->save();
            }

        }
        $returnHTML = view('pages.transactions')->with('success', 'Transaction Finished')->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
}
