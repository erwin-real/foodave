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

            {{$transactions->links()}}
            <div class="lists-table table-responsive mt-3">
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Show</th>
                            <th scope="col">Total</th>
                            <th scope="col">Money Received</th>
                            <th scope="col">Change</th>
                            <th scope="col">Date</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($transactions) > 0)
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="icons" onclick="window.location.href = '/transactions/{{$transaction->id}}'" style="cursor:pointer;">
                                        {{-- <a href="/transactions/{{$transaction->id}}"> --}}
                                            <i class="fas fa-eye"></i>
                                        {{-- </a> --}}
                                    </td>
                                    <td>{{$transaction->total}}</td>
                                    <td>{{$transaction->money_received}}</td>
                                    <td>{{$transaction->change}}</td>
                                    <td>{{date('D M d,Y H:i', strtotime($transaction->created_at))}}</td>
                                    <td class="icons">
                                        {!!Form::open(['action' => ['TransactionsController@destroy', $transaction->id], 'method' => 'POST'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {!! Form::button('<i class="fa fa-trash"></i>', ['class'=>'del-btn', 'type'=>'submit']) !!}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="6">No transactions found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
