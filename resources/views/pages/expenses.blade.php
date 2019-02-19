@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Expenses</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Expenses</li>
                </ol>
            </nav>

            @include('includes.messages')
            <div class="button-holder text-right">
                <a href="/expenses/create" class="btn btn-outline-info mt-1"><i class="fas fa-map-marker-alt"></i> Create</a>
            </div>

            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Monthly Expenses Summary</h5>
                            <div class="panel-body pt-4">
                                {{--{!! $chart->container() !!}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


<script src="/js/vue.js"></script>
<script src="/js/echarts-en.min.js"></script>
{{--{!! $chart->script() !!}--}}

<script src="/js/highcharts.js"></script>
@endsection