<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use DB;

class ProductsController extends Controller
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
        $products = Product::orderBy('updated_at','desc')->get();

        return view('pages.products')
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.inventory.add_product');
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
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'srp' => 'required',
            'stocks' => 'required',
            'pro' => 'required'
        ]);
        
        $product = new Product;
        $product->name = $request->input('name');
        $product->type = $request->input('type');
        $product->desc = $request->input('desc');
        $product->price = $request->input('price');
        $product->srp = $request->input('srp');
        $product->source = $request->input('src');
        $product->contact = $request->input('contact');
        $product->expired_at = $request->input('exp');
        $product->procurement = $request->input('pro');
        $product->stocks = $request->input('stocks');
        $product->save();

        return redirect('/products')->with('success', 'Product Added');
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
        return view('pages.inventory.edit_product')->with('product', Product::find($id));
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
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'srp' => 'required',
            'stocks' => 'required',
            'pro' => 'required'
        ]);
        
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->type = $request->input('type');
        $product->desc = $request->input('desc');
        $product->price = $request->input('price');
        $product->srp = $request->input('srp');
        $product->source = $request->input('src');
        $product->contact = $request->input('contact');
        $product->expired_at = $request->input('exp');
        $product->procurement = $request->input('pro');
        $product->stocks = $request->input('stocks');
        $product->save();

        return redirect('/products')->with('success', 'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminatsade\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        
        return redirect('/product')->with('success', 'Product Deleted');
    }

    public function action(Request $request) {
        if ($request->ajax()) {
            $output='';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('products')
                        ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('type', 'like', '%'.$query.'%')
                        ->orWhere('desc', 'like', '%'.$query.'%')
                        ->orWhere('source', 'like', '%'.$query.'%')
                        ->orderBy('id', 'desc')
                        ->get();
            } else {
                $data = DB::table('products')
                        ->orderBy('id', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $output .= '
                    <tr>
                        <td>'. $row->name .'</td>
                        <td>'. $row->type .'</td>
                        <td>'. $row->desc .'</td>
                        <td>'. $row->price .'</td>
                        <td>'. $row->srp .'</td>
                        <td>'. $row->source .'</td>
                        <td>'. $row->contact .'</td>
                        <td>'. date('m-d-Y', strtotime($row->expired_at)) .'</td>
                        <td>'. $row->stocks .'</td>
                        <td>'. date('m-d-Y H:i', strtotime($row->created_at)) .'</td>
                        <td>'. date('m-d-Y H:i', strtotime($row->updated_at)) .'</td>
                    <tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="7">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }
}
