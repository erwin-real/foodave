<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Product;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { $this->middleware('auth'); }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.products')->with('products', Product::sortable()->paginate(20));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.products.create');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            $this->validate($request, [
                'name' => 'required',
                'type' => 'required',
                'price' => 'required',
                'srp' => 'required',
                'stocks' => 'required',
                'pro' => 'required',
                'sold_by' => 'required',
                'cover_image' => 'image|nullable|max:1999'
            ]);

            //Handle File Upload
            if ($request->hasFile('cover_image')) {
                $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                $fileNameToStore = $filename .'_'.time().'.'.$extension;
                $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            } else $fileNameToStore = 'noimage.jpg';

            $product = new Product;
            $product->name = $request->input('name');
            $product->type = $request->input('type');
            $product->desc = $request->input('desc');
            $product->price = $request->input('price');
            $product->srp = $request->input('srp');
            $product->sold_by = $request->input('sold_by');
            $product->source = $request->input('src');
            $product->contact = $request->input('contact');
            $product->expired_at = ($request->input('exp') == null ? null : $request->input('exp'));
            $product->procurement = $request->input('pro');
            $product->stocks = $request->input('stocks');
            $product->cover_image = $fileNameToStore;
            $product->save();

            return redirect('/products')->with('success', 'Product Added');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.products.show')->with('product', Product::find($id));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.products.edit')->with('product', Product::find($id));

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if ($this->isUserType('admin') || $this->isUserType('seller')) {
            $this->validate($request, [
                'name' => 'required',
                'type' => 'required',
                'srp' => 'required',
                'stocks' => 'required',
                'pro' => 'required',
                'sold_by' => 'required'
            ]);

            $product = Product::find($id);
            $product->name = $request->input('name');
            $product->type = $request->input('type');
            $product->desc = $request->input('desc');

            if (Auth::user()->type == 'admin') $product->price = $request->input('price');

            $product->srp = $request->input('srp');
            $product->sold_by = $request->input('sold_by');
            $product->source = $request->input('src');
            $product->contact = $request->input('contact');
            $product->expired_at = ($request->input('exp') == null ? null : $request->input('exp'));
            $product->procurement = $request->input('pro');
            $product->stocks = $request->input('stocks');

            //Handle File Upload
            if ($request->hasFile('cover_image')) {
                $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                $fileNameToStore = $filename .'_'.time().'.'.$extension;
                $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
                $product->cover_image = $fileNameToStore;
            }

            $product->save();

            return redirect('/products')->with('success', 'Product Updated');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminatsade\Http\Response
     */
    public function destroy($id) {
        if ($this->isUserType('admin')) {
            $product = Product::find($id);

            if ($product->cover_image != 'noimage.jpg')
                Storage::delete('public/cover_images/'.$product->cover_image);

            foreach ($product->losses as $loss) $loss->delete();

            $product->delete();
            return redirect('/products')->with('success', 'Product Deleted');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
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
                        <td style="cursor:pointer;" onclick="window.location = \'/products/'. $row->id .'\'">'. $row->name .'</td>
                        <td>'. $row->type .'</td>
                        <td>'. $row->desc .'</td>
                        <td>'. $row->srp .'</td>
                        <td>'. $row->sold_by .'</td>
                        <td>'. $row->source .'</td>
                        <td>'. $row->contact .'</td>
                        <td>'
                    ;
                    
                    $output .= ($row->expired_at != null) ? date('D m-d-Y', strtotime($row->expired_at)) : 'N/A';
                    
                    $output .= '</td>
                        <td>'. $row->stocks .'</td>
                        <td>'. $row->procurement .'</td>
                    <tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="15">No Data Found</td>
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
                            <td class="icons" onclick="
                                    addTransaction('.$row->id.', \''
                        .strval($row->name).'\', \''
                        .strval($row->desc).'\', \''
                        .strval($row->sold_by).'\', \''
                        .$row->srp.'\',  '
                        .$row->stocks.')
                                " style="cursor: pointer;">'. $row->name .'</td>
                            <td>'. $row->desc .'</td>
                            <td>'. $row->srp .'</td>
                            <td>'. $row->sold_by .'</td>
                            <td>'. $row->stocks .'</td>
                        <tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="6">No Product Found</td>
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

    public function import() {
        if ($this->isUserType('admin'))
            return view('pages.products.import_csv');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function uploadCSVFile(Request $request) {
        if ($this->isUserType('admin')) {
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
                $product->type = $data['type'];
                $product->desc = $data['description'];
                $product->price = $data['price'];
                $product->srp = $data['srp'];
                $product->sold_by = $data['soldby'];
                $product->source = $data['source'];
                $product->contact = $data['contact'];
                $product->expired_at = ($data['expiredat'] == '') ? null : $data['expiredat'];
                $product->stocks += $data['stocks'];
                $product->procurement = $data['procurement'];
                $product->cover_image = "noimage.jpg";
                $product->save();
            }

            return redirect('/products')
                ->with('success', 'File Imported Successfully');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for searching a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search() {
        if ($this->isUserType('admin') || $this->isUserType('seller'))
            return view('pages.products.search');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        return (User::find(auth()->user()->id)->type == $type) ? true : false;
    }
}
