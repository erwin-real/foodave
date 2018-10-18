@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">

            <h1>Edit Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                </ol>
            </nav>
            {!! Form::open(['action' => ['ProductsController@update', $product->id], 'method' => 'POST']) !!}

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('name', 'Product Name')}} <span class="text-danger">*</span>
                    {{Form::text('name', $product->name, ['class' => 'form-control', 'placeholder' => 'Enter Product Name', 'required' => 'required'])}}
                </div>
                
                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('type', 'Product Type')}} <span class="text-danger">*</span>
                    {{Form::text('type', $product->type, ['class' => 'form-control', 'placeholder' => 'Enter Product Type', 'required' => 'required'])}}
                </div>
                
                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('desc', 'Product Description')}}
                    {{Form::text('desc', $product->desc, ['class' => 'form-control', 'placeholder' => 'Enter Product Description'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('price', 'Price')}} <span class="text-danger">*</span>
                    {{Form::number('price', $product->price, ['class' => 'form-control', 'placeholder' => 'Enter Price per piece', 'step' => '0.0001', 'required' => 'required'])}}
                </div>
                
                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('srp', 'SRP')}} <span class="text-danger">*</span>
                    {{Form::number('srp', $product->srp, ['class' => 'form-control', 'placeholder' => 'Enter SRP', 'step' => '0.0001', 'required' => 'required'])}}
                </div>
                
                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('src', 'Source of Supply')}}
                    {{Form::text('src', $product->source, ['class' => 'form-control', 'placeholder' => 'Enter Product\'s Source of Supply'])}}
                </div>
                
                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('contact', 'Contact Number')}}
                    {{Form::number('contact', $product->contact, ['class' => 'form-control', 'placeholder' => 'Enter Contact Number'])}}
                </div>
                
                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('exp', 'Expiration Date')}}
                    {{Form::date('exp', date('Y-m-d', strtotime($product->expired_at)), ['class' => 'form-control', 'placeholder' => 'Enter Expiration Date'])}}
                </div>
                
                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('stocks', 'Stocks')}} <span class="text-danger">*</span>
                    {{Form::number('stocks', $product->stocks, ['class' => 'form-control', 'placeholder' => 'Enter No. of Stocks', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('pro', 'Procurement Level')}} <span class="text-danger">*</span>
                    {{Form::number('pro', $product->procurement, ['class' => 'form-control', 'placeholder' => 'Enter Procurement Level', 'required' => 'required'])}}

                    <div class="text-center mt-4">
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                    </div>

                </div>

            {!! Form::close() !!}
            
            <a href="/products" class="btn btn-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>
            
        </div>
    </div>



@endsection