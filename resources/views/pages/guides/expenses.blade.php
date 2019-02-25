@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Monthly Expenses' Guide</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/expenses">Expenses</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Guide</li>
                </ol>
            </nav>

            <div class="container-fluid">
                <div class="row">

                    <div class=" col-md-5">

                        <h3>♦ Create new monthly expenses</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/expenses">Expenses Page</a>.</li>
                                <li>Click the "Create" button.</li>
                                <li>Fill all the fields needed, especially those who has red asterisk (<span class="text-danger">*</span>).</li>
                                <li>Click the "Save" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        <h3>♦ View a specific month's expenses</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/expenses">Expenses Page</a>.</li>
                                <li>Simply click the "Month" of a specific month's expenses in the table.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                        <h3>♦ Edit a specific month's expenses</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/expenses">Expenses Page</a>.</li>
                                <li>Simply click the "Month" of a specific month's expenses in the table.</li>
                                <li>Click the "Edit" button.</li>
                                <li>Edit all desired fields.</li>
                                <li>Click the "Save" button.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                    </div>

                    <div class="col-md-5 offset-md-1">

                        <h3>♦ Delete a specific month's expenses</h3>
                        <div class="mx-2">
                            <ol>
                                <li>Go to <a href="/expenses">Expenses Page</a>.</li>
                                <li>Simply click the "Month" of a specific month's expenses in the table.</li>
                                <li>Click the "Delete" button.</li>
                                <li>Click "OK" in the alertbox that will show up.</li>
                                <li>Finish!</li>
                            </ol>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection