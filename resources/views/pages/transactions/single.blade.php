@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Contact Lists</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="/transactions">Transactions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$transaction->id}}</li>
                </ol>
            </nav>
            
            <p>Date of Transaction: {{date('D M d,Y H:i', strtotime($transaction->created_at))}}</p>
            <p>Total: {{$transaction->total}}</p>

            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">SRP</th>
                            <th scope="col">Sold</th>
                            <th scope="col">Total</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Income</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->singleTransactions as $singleTransaction)
                            <tr>
                                <td>{{$singleTransaction->product->name}}</td>
                                <td>{{$singleTransaction->product->type}}</td>
                                <td>{{$singleTransaction->product->desc}}</td>
                                <td>{{$singleTransaction->product->price}}</td>
                                <td>{{$singleTransaction->product->srp}}</td>
                                <td>{{$singleTransaction->quantity}}</td>
                                <td>{{$singleTransaction->total}}</td>
                                <td>{{$singleTransaction->capital}}</td>
                                <td>{{$singleTransaction->income}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="/transactions" class="btn btn-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

@endsection