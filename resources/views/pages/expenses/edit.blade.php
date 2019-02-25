@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">

            <h1>Edit Monthly Expenses</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/expenses">Expenses</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{date('F Y', strtotime($expense->month))}}</li>
                </ol>
            </nav>

            @include('includes.messages')

            <span class="text-danger">* required</span>

            {!! Form::open(['action' => ['ExpenseController@update', $expense->id], 'method' => 'POST', 'class' => 'mt-4']) !!}

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('month', 'Month')}} <span class="text-danger">*</span>
                    <input id="month" type="month" value="{{date('Y-m', strtotime($expense->month))}}" name="month" class="form-control" onchange="updateMonth(this)" required>
{{--                    {{Form::month('month', date('Y-m', strtotime($expense->month)), ['class' => 'form-control', 'required' => 'required', 'onchange' => 'updateMonth(this)'])}}--}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('clerk', 'Sales Clerk Fee')}} <span class="text-danger">*</span>
                    {{Form::number('clerk', $expense->clerk, ['class' => 'form-control', 'placeholder' => 'Enter Sales Clerk Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('rental', 'Rental Fee')}} <span class="text-danger">*</span>
                    {{Form::number('rental', $expense->rental, ['class' => 'form-control', 'placeholder' => 'Enter Rental Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('water', 'Water Fee')}} <span class="text-danger">*</span>
                    {{Form::number('water', $expense->water, ['class' => 'form-control', 'placeholder' => 'Enter Water Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('electric', 'Electric Fee')}} <span class="text-danger">*</span>
                    {{Form::number('electric', $expense->electric, ['class' => 'form-control', 'placeholder' => 'Enter Electric Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('service', 'Service Fee')}} <span class="text-danger">*</span>
                    {{Form::number('service', $expense->service, ['class' => 'form-control', 'placeholder' => 'Enter Service Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('others', 'Others Fee')}} <span class="text-danger">*</span>
                    {{Form::number('others', $expense->others, ['class' => 'form-control', 'placeholder' => 'Enter Others Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    <div class="text-center mt-4">
                        {{Form::hidden('_method', 'PUT')}}
                        <button id="submit" type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i> Save</button>
                    </div>
                </div>

            {!! Form::close() !!}

            <a href="/expenses" class="btn btn-outline-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

    <script>
        var dates = [];

        @foreach($expenses as $item)
            @if ($expense->month != $item->month)
                dates.push('{{date('Y-m', strtotime($item->month))}}');
            @endif
        @endforeach

        for (let i = 0; i < dates.length; i++) {
            if (dates[i] === document.getElementById('month').value && ('{{$expense->month}}' !== document.getElementById('month').value)) {
                document.getElementById('submit').disabled = true;
            }
        }

        function updateMonth(r) {
            document.getElementById('submit').disabled = false;
            for (let i = 0; i < dates.length; i++) {
                if (dates[i] === r.value && ('{{date('Y-m', strtotime($expense->month))}}' !== r.value)) document.getElementById('submit').disabled = true;
            }
        }
    </script>

@endsection