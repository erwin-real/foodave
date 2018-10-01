@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Products</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Procurement</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">SRP</th>
                            <th scope="col">Source</th>
                            <th scope="col">Contact #</th>
                            <th scope="col">Expiration Date</th>
                            <th scope="col">Stocks</th>
                            <th scope="col">Procurement</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($products) > 0)
                            @foreach($products as $product)
                                @if($product->stocks <= $product->procurement)
                                    <tr>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->type}}</td>
                                        <td>{{$product->desc}}</td>
                                        <td>{{$product->price}}</td>
                                        <td>{{$product->srp}}</td>
                                        <td>{{$product->source}}</td>
                                        <td>{{$product->contact}}</td>
                                        <td>{{date('m-d-Y', strtotime($product->expired_at))}}</td>
                                        <td>{{$product->stocks}}</td>
                                        <td>{{$product->procurement}}</td>
                                        <td>{{date('m-d-Y H:i', strtotime($product->created_at))}}</td>
                                        <td>{{date('m-d-Y H:i', strtotime($product->updated_at))}}</td>
                                        <td class="icons">
                                            <a href="/products/{{$product->id}}/edit">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                        <td class="icons">
                                            <a href="/products/destroy/{{$product->id}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="13">No products found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection