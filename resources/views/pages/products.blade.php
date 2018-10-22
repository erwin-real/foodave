@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Products</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/products/create" class="btn btn-primary mt-1"><i class="fas fa-plus"></i> Add</a>
                <a href="/products/search" class="btn btn-primary mt-1"><i class="fas fa-search"></i> Search</a>
                <a href="/products/import" class="btn btn-primary mt-1"><i class="fas fa-file-alt"></i> Import CSV File</a>
            </div>

            <div class="lists-table table-responsive mt-3">
            <h4>Total: {{count($products)}}</h4>
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">@sortablelink('name', 'Name',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('type', 'Type',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('desc', 'Description',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            
                            @if(Auth::user()->type == 'admin')
                                <th scope="col">@sortablelink('price', 'Price',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            @endif

                            <th scope="col">@sortablelink('srp', 'SRP',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('sold_by', 'Sold by',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('source', 'Source',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('contact', 'Contact',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('expired_at', 'Expiration Date',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('stocks', 'Stocks',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('procurement', 'Procurement',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('created_at', 'Date Created',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">@sortablelink('updated_at', 'Date Updated',[],['style' => 'text-decoration: none;', 'rel' => 'nofollow'])</th>
                            <th scope="col">Loss</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($products) > 0)
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->type}}</td>
                                    <td>{{$product->desc}}</td>
                                    
                                    @if(Auth::user()->type == 'admin')
                                        <td>{{$product->price}}</td>
                                    @endif
                                    
                                    <td>{{$product->srp}}</td>
                                    <td>{{$product->sold_by}}</td>
                                    <td>{{$product->source}}</td>
                                    <td>{{$product->contact}}</td>
                                    <td>{{date('D M d,Y', strtotime($product->expired_at))}}</td>
                                    <td>{{$product->stocks}}</td>
                                    <td>{{$product->procurement}}</td>
                                    <td>{{date('D M d,Y H:i', strtotime($product->created_at))}}</td>
                                    <td>{{date('D M d,Y H:i', strtotime($product->updated_at))}}</td>
                                    <td class="icons">
                                        <a href="/loss/{{$product->id}}/edit">
                                            <i class="fa fa-exclamation-triangle"></i>
                                        </a>
                                    </td>
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
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="15">No products found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
                {!! $products->appends(\Request::except('page'))->render() !!}
            </div>

        </div>
    </div>

@endsection