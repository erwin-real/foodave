@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Dashboard</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <div class="top-dashboard">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="campaign-summary">
                            <div class="card camp-card mb-3">
                                <div class="card-body text-center">
                                    <h1>123</h1>
                                    <p>TOTAL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="list-summary">
                            <div class="card list-card mb-3">
                                <div class="card-body text-center">
                                    <h1>123</h1>
                                    <p>TOTAL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="subs-summary">
                            <div class="card subs-card mb-3">
                                <div class="card-body text-center">
                                    <h1>123</h1>
                                    <p>TOTAL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bottom-dashboard">
                <div class="row">

                    <div class="col-sm-12 mb-2">
                        <div class="card mb-2">
                            <h5 class="card-title campaign-title">Inventory Summary <a class="float-right" href="/campaign"><i class="fas fa-ellipsis-v"></i></a></h5>
                            <div class="card-body table-responsive-sm">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Stocks Remaining</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Date Updated</th>
                                            <th scope="col">Report</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr class="text-center">
                                                <th colspan="7">No results found</th>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-2">
                            <h5 class="card-title lists-title">Products <a class="float-right" href="/contacts"><i class="fas fa-ellipsis-v"></i></a></h5>
                            <div class="card-body table-responsive-sm">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Stocks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr class="text-center">
                                                <th colspan="2">No lists found</th>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Report Summary <a class="float-right" href="/statistics"><i class="fas fa-ellipsis-v"></i></a></h5>
                            <div class="card-body text-center h-100 d-table">
                                <div class="v-align h-100 d-table-cell align-middle">
                                    <div class="row h-100 align-items-center">
                                        <div class="col-sm-6 px-0">
                                            <h1>report</h1>
                                            <p><i class="far fa-check-circle"></i> Report</p>
                                        </div>
                                        <div class="col-sm-6 px-0 pb-4">
                                            <h1>report</h1>
                                            <p><i class="fas fa-undo"></i> Report</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
