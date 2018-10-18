@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Loss</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Loss</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="lists-table table-responsive mt-3">
                <h4>Total Loss: {{count($losses)}}</h4>
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Reason</th>
                            <th scope="col">SRP</th>
                            <th scope="col">Source</th>
                            <th scope="col">Contact #</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($losses) > 0)
                            @foreach($losses as $loss)
                                <tr>
                                    <td>{{$loss->product->name}}</td>
                                    <td>{{$loss->product->type}}</td>
                                    <td>{{$loss->product->desc}}</td>
                                    <td>{{$loss->quantity}}</td>
                                    <td>{{$loss->reason}}</td>
                                    <td>{{$loss->product->srp}}</td>
                                    <td>{{$loss->product->source}}</td>
                                    <td>{{$loss->product->contact}}</td>
                                    <td>{{date('m-d-Y H:i', strtotime($loss->created_at))}}</td>
                                    <td>{{date('m-d-Y H:i', strtotime($loss->updated_at))}}</td>
                                    <td class="icons">
                                        <a href="/loss/{{$loss->id}}/edit">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td class="icons">
                                        <a href="/loss/destroy/{{$loss->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="12">No loss products found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection