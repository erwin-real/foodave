<?php

namespace App\Http\Controllers;

use App\Loss;
use Illuminate\Http\Request;
use App\Product;

class LossController extends Controller
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
        return view('pages.loss')
            ->with('losses', Loss::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.losses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required',
            'reason' => 'required'
        ]);
        
        $loss = new Loss;
        $loss->product_id = $request->input('product_id');
        $loss->quantity = $request->input('quantity');
        $loss->reason = $request->input('reason');
        $loss->save();

        $product = Product::find($loss->product_id);
        $product->stocks = $product->stocks - $loss->quantity;
        $product->save();

        return redirect('/loss')->with('success', 'Loss Product Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function show(Loss $loss)
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
        return view('pages.losses.edit')->with('loss', Loss::find($id));
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
        $this->validate($request, [
            'quantity' => 'required',
            'reason' => 'required'
        ]);
        
        $loss = Loss::find($id);
        $loss->reason = $request->input('reason');

        $quantity = $request->input('quantity');        
        $product = Product::find($loss->product_id);

        if($quantity > $loss->quantity) {
            $quantity -= $loss->quantity;
            $product->stocks -= $quantity;            
        } else if($quantity < $loss->quantity) {
            $quantity = $loss->quantity - $quantity;
            $product->stocks += $quantity;        
        }

        $loss->quantity = $request->input('quantity');
        $loss->save();
        $product->save();

        return redirect('/loss')->with('success', 'Loss Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loss $loss)
    {
        //
    }
}
