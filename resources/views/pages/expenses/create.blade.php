@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">

            <h1>Calculate Monthly Expenses</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/expenses">Expenses</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Calculate Monthly Expenses</li>
                </ol>
            </nav>

            @include('includes.messages')

            <span class="text-danger">* required</span>

            {!! Form::open(['action' => 'ExpenseController@store', 'method' => 'POST', 'class' => 'mt-4']) !!}

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('month', 'Month')}} <span class="text-danger">*</span>
                    {{Form::month('month', '', ['class' => 'form-control', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('clerk', 'Sales Clerk Fee')}} <span class="text-danger">*</span>
                    {{Form::number('clerk', '', ['class' => 'form-control', 'placeholder' => 'Enter Sales Clerk Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('rental', 'Rental Fee')}} <span class="text-danger">*</span>
                    {{Form::number('rental', '', ['class' => 'form-control', 'placeholder' => 'Enter Rental Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('water', 'Water Fee')}} <span class="text-danger">*</span>
                    {{Form::number('water', '', ['class' => 'form-control', 'placeholder' => 'Enter Water Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('electric', 'Electric Fee')}} <span class="text-danger">*</span>
                    {{Form::number('electric', '', ['class' => 'form-control', 'placeholder' => 'Enter Electric Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('service', 'Service Fee')}} <span class="text-danger">*</span>
                    {{Form::number('service', '', ['class' => 'form-control', 'placeholder' => 'Enter Service Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    {{Form::label('others', 'Others Fee')}} <span class="text-danger">*</span>
                    {{Form::number('others', '', ['class' => 'form-control', 'placeholder' => 'Enter Others Fee', 'required' => 'required'])}}
                </div>

                <div class="form-group col-12 col-md-5 col-sm-8">
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i> Save</button>
                    </div>
                </div>

            {!! Form::close() !!}

            <a href="/products" class="btn btn-outline-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>

        </div>
    </div>

@endsection