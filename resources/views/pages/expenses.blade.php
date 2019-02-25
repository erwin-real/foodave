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
                <a href="/expenses/create" class="btn btn-outline-info mt-1 mb-3"><i class="fas fa-plus"></i> Create</a>
                <a href="/guide/expenses" target="_blank" class="btn btn-outline-dark mt-1 mb-3"><i class="fas fa-info-circle"></i> Guide</a>
            </div>

            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Monthly Expenses Chart</h5>
                            <div class="panel-body pt-4">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Monthly Expenses Table</h5>
                            <div class="panel-body pt-4">

                                <div class="lists-table table-responsive mt-3">
                                    <table class="table table-hover table-striped py-3 text-center">
                                        <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Sales Clerk Fee</th>
                                            <th scope="col">Rental Fee</th>
                                            <th scope="col">Water Fee</th>
                                            <th scope="col">Electric Fee</th>
                                            <th scope="col">Service Fee</th>
                                            <th scope="col">Others Fee</th>
                                            <th scope="col">Capital</th>
                                            <th scope="col">Gross Income</th>
                                            <th scope="col">Income Fee</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($expenses) > 0)
                                                @foreach ($expenses as $expense)
                                                    <tr>
                                                        @for ($i = 0; $i < count($data['dates']) ; $i++)
                                                            @if (date('M Y', strtotime($expense->month)) == $data['dates'][$i])
                                                                <td><a href="/expenses/{{$expense->id}}">{{date('M Y', strtotime($expense->month))}}</a></td>
                                                                <td>{{$expense->clerk}}</td>
                                                                <td>{{$expense->rental}}</td>
                                                                <td>{{$expense->water}}</td>
                                                                <td>{{$expense->electric}}</td>
                                                                <td>{{$expense->service}}</td>
                                                                <td>{{$expense->others}}</td>
                                                                <td>{{$data['capitals'][$i]}}</td>
                                                                <td>{{$data['grosss'][$i]}}</td>
                                                                <td>{{$data['incomes'][$i]}}</td>
                                                                @break
                                                            @endif
                                                        @endfor

                                                    </tr>
                                                @endforeach
                                            @else
                                                {{--@if (count($data['dates']) > 0)--}}
                                                    {{--@for ($i = 0; $i < count($data['dates']) ; $i++)--}}
                                                        {{--<tr>--}}
                                                            {{--@foreach($expenses as $expense)--}}
                                                                {{--@if (date('M Y', strtotime($expense->month)) == $data['dates'][$i])--}}
                                                                    {{--<td><a href="/expenses/{{$expense->id}}">{{date('M Y', strtotime($expense->month))}}</a></td>--}}
                                                                    {{--<td>{{$expense->clerk}}</td>--}}
                                                                    {{--<td>{{$expense->rental}}</td>--}}
                                                                    {{--<td>{{$expense->water}}</td>--}}
                                                                    {{--<td>{{$expense->electric}}</td>--}}
                                                                    {{--<td>{{$expense->service}}</td>--}}
                                                                    {{--<td>{{$expense->others}}</td>--}}
                                                                    {{--@break--}}
                                                                {{--@endif--}}
                                                            {{--@endforeach--}}
    {{----}}
                                                        {{--</tr>--}}
                                                    {{--@endfor--}}
                                                {{--@else--}}
                                                <tr class="text-center">
                                                    <th colspan="7">No expenses found</th>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


<script src="/js/vue.js"></script>
<script src="/js/echarts-en.min.js"></script>
{!! $chart->script() !!}

<script src="/js/highcharts.js"></script>
@endsection