@if(Auth::user()->type == 'admin' || Auth::user()->type == 'seller')
    @extends('layouts.app')

    @section('content')
        @include('includes.sidenav')

        {{-- Right Content --}}
        <div class="body-right">
            <div class="container-fluid">
                <h1>Import File</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @if(Auth::user()->type == 'admin')
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Import CSV File</li>
                    </ol>
                </nav>
                
                {!! Form::open(['action' => 'ProductsController@uploadCSVFile', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        <label for="csv_file" class="col-md-4 control-label">Upload File <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            {{Form::file('csv_file', ['class' => 'form-control'])}}
                        </div>

                        <div class="text-center mt-4">
                            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                        </div>
                    </div>

                {!! Form::close() !!}
                
                <a href="/products" class="btn btn-primary mb-3 mx-2"><i class="fas fa-chevron-left"></i> Back</a>

            </div>
        </div>

    @endsection
@else
    <h1>PERMISSION DENIED</h1>
@endif