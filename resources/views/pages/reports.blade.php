@if(Auth::user()->type == 'admin')

    @extends('layouts.app')

    @section('content')
        @include('includes.sidenav')

        {{-- Right Content --}}
        <div class="body-right">
            <div class="container-fluid">
                <h1>Reports</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reports</li>
                    </ol>
                </nav>

                <div class="top-dashboard">
                    <div class="row">
                        <div class="col-6 col-sm-4 col-xl-2">
                            <div class="campaign-summary" style="cursor: pointer;" onclick="window.location = '/reports'">
                                <div class="card bg-secondary mb-3">
                                    <div class="card-body text-center">
                                        <h2>{{count($transactions)}}</h2>
                                        <p>Transactions</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-xl-2">
                            <div class="campaign-summary" style="cursor: pointer;" onclick="window.location = '/reports'">
                                <div class="card bg-info mb-3">
                                    <div class="card-body text-center">
                                        <h2>{{$transactions->sum('capital')}}</h2>
                                        <p>Capital</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-xl-2">
                            <div class="campaign-summary" style="cursor: pointer;" onclick="window.location = '/reports'">
                                <div class="card bg-primary mb-3">
                                    <div class="card-body text-center">
                                        <h2>{{$transactions->sum('income')}}</h2>
                                        <p>Income</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-sm-4 col-xl-2">
                            <div class="campaign-summary" style="cursor: pointer;" onclick="window.location = '/reports'">
                                <div class="card bg-success mb-3">
                                    <div class="card-body text-center">
                                        <h2>{{$transactions->sum('total')}}</h2>
                                        <p>Total</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-xl-2">
                            <div class="campaign-summary" style="cursor: pointer;" onclick="window.location = '/reports'">
                                <div class="card orange mb-3">
                                    <div class="card-body text-center">
                                        <h2>?</h2>
                                        <p>Loss Products</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-xl-2">
                            <div class="campaign-summary" style="cursor: pointer;" onclick="window.location = '/reports'">
                                <div class="card bg-danger mb-3">
                                    <div class="card-body text-center">
                                        <h2>?</h2>
                                        <p>Loss Money</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    {!! $chart->container() !!}
                </div>

            </div>
        </div>
    @endsection


    {{-- <script src="https://unpkg.com/vue"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js" charset=utf-8></script> --}}
    <script src="/js/vue.js"></script>
    <script src="/js/echarts-en.min.js"></script>
    {!! $chart->script() !!}

    <script src="/js/highcharts.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script> --}}

@else
    <h1>PERMISSION DENIED</h1>

@endif