@if(Auth::user()->type == 'admin' || Auth::user()->type == 'seller')
    @extends('layouts.app')

    @section('content')
        @include('includes.sidenav')

        {{-- Right Content --}}
        <div class="body-right">
            <div class="container-fluid">
                <h1>{{$product->name}}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @if(Auth::user()->type == 'admin')
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$product->id}}</li>
                    </ol>
                </nav>

                @include('includes.messages')

                <div class="button-holder text-right">
                    <a href="/products/{{$product->id}}/edit" class="btn btn-outline-primary mt-1"><i class="fas fa-pencil-alt"></i> Edit</a>
                    <a href="/products/destroy/{{$product->id}}" class="btn btn-outline-danger mt-1"><i class="fas fa-trash"></i> Delete</a>
                    <a href="/loss/create/{{$product->id}}" class="btn btn-outline-warning mt-1"><i class="fas fa-exclamation-triangle"></i> Loss</a>
                </div>

                <div class="row">
                    <div class="col-2 mt-4 panel-body">
                        <p>Name: {{$product->name}}</p>
                        <p>Type: {{$product->type}}</p>
                        <p>Desc: {{$product->desc}}</p>
                        <p>Price: {{$product->price}}</p>
                        <p>SRP: {{$product->srp}}</p>
                        <p>Sold by: {{$product->sold_by}}</p>
                        <p>Source: {{$product->source}}</p>
                        <p>Contact: {{$product->contact}}</p>
                        <p>Expiration Date: {{date('D M d,Y', strtotime($product->expired_at))}}</p>
                        <p>Stocks: {{$product->stocks}}</p>
                        <p>Procurement: {{$product->procurement}}</p>
                        <p>Name: {{date('D M d,Y', strtotime($product->created_at))}}</p>
                        <p>Name: {{date('D M d,Y', strtotime($product->updated_at))}}</p>
                    </div>

                    <div class="col-10 mt-4 panel-body">
                        <img src="/storage/cover_images/{{$product->cover_image}}" alt="" style="width: 100%;
">
                    </div>
                </div>

                <a href="/products" class="btn btn-outline-primary m-3"><i class="fas fa-chevron-left"></i> Back</a>

            </div>
        </div>

    @endsection
@else
    <h1>PERMISSION DENIED</h1>
@endif