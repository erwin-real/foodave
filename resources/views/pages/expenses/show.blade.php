@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>{{date('M Y', strtotime($expense->month))}}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/expenses">Expenses</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{date('M Y', strtotime($expense->month))}}</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/expenses/{{$expense->id}}/edit" class="btn btn-outline-primary mt-1"><i class="fas fa-pencil-alt"></i> Edit</a>

                @if(Auth::user()->type == 'admin')
                    <form id="delete" method="POST" action="{{ action('ProductsController@destroy', $expense->id) }}" class="float-right mt-1 ml-1">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                @endif
            </div>

            <div class="row">
                <div class="col-sm-12 mt-4 panel-body">
                    <p><b>Month</b>: {{date('M Y', strtotime($expense->month))}}</p>
                    <p><b>Capital</b>: P {{$capital}}</p>
                    <p><b>Gross Income</b>: P {{$gross}}</p>
                    <p><b>Sales Clerk</b>: P {{$expense->clerk}}</p>
                    <p><b>Rental Fee</b>: P {{$expense->rental}}</p>
                    <p><b>Water Fee</b>: P {{$expense->water}}</p>
                    <p><b>Electric Fee</b>: P {{$expense->electric}}</p>
                    <p><b>Service Fee</b>: P {{$expense->service}}</p>
                    <p><b>Others Fee</b>: P {{$expense->others}}</p>
                    <p><b>Net Income</b>: P {{$income}}</p>
                    <p><b>Created at</b>: {{date('D M d, Y h:i A', strtotime($expense->created_at))}}</p>
                    <p><b>Updated at</b>: {{date('D M d, Y h:i A', strtotime($expense->updated_at))}}</p>
                </div>
            </div>

            <a href="/expenses" class="btn btn-outline-primary m-3"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#delete").on("submit", function () {
                return confirm("Are you sure you want to delete this product?");
            });
        });
    </script>

@endsection