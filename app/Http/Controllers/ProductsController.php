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
        $products = Product::sortable()->paginate(20);

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
        return view('pages.products.add_product');
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
        $product->expired_at = ($request->input('exp') == null ? null : $request->input('exp'));
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
        return view('pages.products.edit_product')->with('product', Product::find($id));
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
        $product->expired_at = ($request->input('exp') == null ? null : $request->input('exp'));
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
        
        return redirect('/products')->with('success', 'Product Deleted');
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
                        ->orderBy('expired_at', 'desc')
                        ->get();
            } else {
                $data = DB::table('products')
                        ->orderBy('expired_at', 'desc')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $output .= '
                    <tr id="product'. $row->id .'">
                        <td>'. $row->name .'</td>
                        <td>'. $row->type .'</td>
                        <td>'. $row->desc .'</td>
                        <td>'. $row->price .'</td>
                        <td>'. $row->srp .'</td>
                        <td>'. $row->source .'</td>
                        <td>'. $row->contact .'</td>
                        <td>'
                    ;
                    
                    $output .= ($row->expired_at != null) ? date('D m-d-Y', strtotime($row->expired_at)) : 'N/A';
                    
                    $output .= '</td>
                        <td>'. $row->stocks .'</td>
                        <td>'. $row->procurement .'</td>
                        <td>'. date('D m-d-Y H:i', strtotime($row->created_at)) .'</td>
                        <td>'. date('D m-d-Y H:i', strtotime($row->updated_at)) .'</td>
                        <td class="icons">
                            <a href="/products/'. $row->id .'/edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                        <td class="icons">
                            <a onclick="deleteProduct('. $row->id .')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    <tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="14">No Data Found</td>
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

    public function transact(Request $request) {
        if ($request->ajax()) {
            $output='';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('products')
                        ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('desc', 'like', '%'.$query.'%')
                        ->orderBy('updated_at', 'desc')
                        ->get();
            } else {
                $data = DB::table('products')
                        ->orderBy('updated_at', 'desc')
                        ->get();
            }
            $data = $data->where('stocks', '>' , 0);
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $output .= '
                        <tr>
                            <td>'. $row->name .'</td>
                            <td>'. $row->desc .'</td>
                            <td>'. $row->srp .'</td>
                            <td>'. $row->stocks .'</td>
                            <td class="icons" onclick="
                                    addTransaction('.$row->id.', \''
                                        .strval($row->name).'\', \''
                                        .strval($row->desc).'\', \''
                                        .$row->srp.'\',  '
                                        .$row->stocks.')
                                " style="cursor: pointer;">
                                <i class="fa fa-plus"></i>
                            </td>
                        <tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Product Found</td>
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

    public function del($product_id) {
        $product = Product::find($product_id);
        $product->delete();
        
        return redirect('/products')->with('success', 'Product Deleted');
    }
    
    public function import()
    {
        return view('pages.products.import_csv');
    }

    public function uploadCSVFile(Request $request)
    {        
        $this->validate($request, ['csv_file' => 'required']);

        $upload = $request->file('csv_file');
        $filePath = $upload->getRealPath();
        $file=fopen($filePath, 'r');
        $header=fgetcsv($file);

        $escapedHeader=[];

        foreach($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }

        while($columns=fgetcsv($file)) {
            if($columns[0]=="") continue;
            foreach($columns as $key => $value) $value=preg_replace('/\D/','',$value);
            $data = array_combine($escapedHeader, $columns);

            $product = Product::firstOrNew(['name'=>$data['name'], 'type'=>$data['type'], 'desc'=>$data['description']]);
            $product->name = $data['name'];
            $product->type =$data['type'];
            $product->desc =$data['description'];
            $product->price =$data['price'];
            $product->srp =$data['srp'];
            $product->source =$data['source'];
            $product->contact =$data['contact'];
            $product->expired_at =$data['expiredat'];
            $product->stocks =$data['stocks'];
            $product->procurement =$data['procurement'];
            $product->save();
        }

        return redirect('/products')
        ->with('success', 'File Imported Successfully');
    }

    /**
     * Show the form for searching a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        return view('pages.products.search');
    }
}
