@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Products</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="button-holder text-right">
                <a href="/products/create" class="btn btn-primary mt-1"><i class="fas fa-plus"></i> Add Product</a>
                <!-- <a href="/products/import" class="btn btn-primary mt-1"><i class="fas fa-file-alt"></i> Import CSV File</a> -->
            </div>
            <div class="mt-4 panel-body">
                <div class="form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Product Data">
                </div>

                <div class="lists-table table-responsive mt-3">
                <h4 align="center">Total Product: <span id="total_records"></span></h4>
                    <table class="table table-hover table-striped py-3 text-center">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">SRP</th>
                                <th scope="col">Source</th>
                                <th scope="col">Contact #</th>
                                <th scope="col">Expiration Date</th>
                                <th scope="col">Stocks</th>
                                <th scope="col">Procurement</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Date Updated</th>
                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() { 

            fetch_product_data();

             function fetch_product_data(query = '')
            {
                $.ajax({
                url:"{{ route('products.action') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                    {
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    },error:function(data) {
                    console.log(data);
                }
                })
            }

            $(document).on('keyup', '#search', function() {
                var query = $(this).val();
                fetch_product_data(query);
            });
            
        });

    </script>

@endsection