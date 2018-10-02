@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Transactions</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/transactions/create" class="btn btn-primary mt-1"><i class="fas fa-plus"></i> New Transaction</a>
                <!-- <a href="/products/import" class="btn btn-primary mt-1"><i class="fas fa-file-alt"></i> Import CSV File</a> -->
            </div>

            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Total</th>
                            <th scope="col">Money Received</th>
                            <th scope="col">Change</th>
                            <th scope="col">Date</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <th colspan="6">No transactions found</th>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
