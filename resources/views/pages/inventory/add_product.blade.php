@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">

            <h1>Add Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                </ol>
            </nav>
            
            {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST']) !!}

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('name', 'Product Name')}} <span class="text-danger">*</span>
                    {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Name'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('price', 'Price')}} <span class="text-danger">*</span>
                    {{Form::number('price', '', ['class' => 'form-control', 'placeholder' => 'Enter Price per piece', 'step' => '0.0001'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('stocks', 'Stocks')}} <span class="text-danger">*</span>
                    {{Form::number('stocks', '', ['class' => 'form-control', 'placeholder' => 'Enter No. of Stocks'])}}

                    <div class="text-center mt-4">
                        {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                    </div>

                </div>

            {!! Form::close() !!}
            
        </div>
    </div>



@endsection