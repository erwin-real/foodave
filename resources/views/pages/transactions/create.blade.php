@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>New Transaction</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="/transactions">Transactions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New</li>
                </ol>
            </nav>

            @include('includes.messages')

            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card mb-2">
                            <h5 class="card-title lists-title">Transaction Summary <a class="float-right" href="/transactions"><i class="fas fa-ellipsis-v"></i></a></h5>
                            <!-- <div class="card-body text-center h-100 d-table"> -->
                                <div class="lists-table table-responsive mt-3">
                                    <table class="table table-hover table-striped py-3 text-center" id="transactionTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total</th>
                                                <!-- <th scope="col">Remove</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="transactionsBody">

                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <p><b>Total: 0</b></p>
                                        <button type="button" class="btn btn-primary" name="button">SAVE</button>
                                    </div>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>

                    <div class="col-12 col-xl-6 mt-xl-0 mt-4">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Products <a class="float-right" href="/statistics"><i class="fas fa-ellipsis-v"></i></a></h5>
                            <!-- <div class="card-body text-center h-100 d-table"> -->
                                <div class="lists-table table-responsive mt-3">
                                    <table id="productsTable" class="table table-hover table-striped py-3 text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Stocks Remaining</th>
                                                <th scope="col">Add</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productsTBody">
                                            @if(count($products) > 0)
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{$product->name}}</td>
                                                        <td>{{$product->price}}</td>
                                                        <td>{{$product->stocks_remaining}}</td>
                                                        <td class="icons" style="cursor: pointer;" onclick="deleteRow(this,{{$product}})">
                                                            <i class="fa fa-plus"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr class="text-center">
                                                <th colspan="6">No products found</th>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->

    <script type="text/javascript">

    function changeTotal(index) {
        var i = index.parentNode.parentNode.rowIndex;

    var x = document.getElementById("myInput").value;
    document.getElementById("demo").innerHTML = "You wrote: " + x;
    }

        function deleteRow(r, product) {
            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("productsTBody").deleteRow(i);


            var values = new Array(3);
              values[0] = [123.45, "apple", true];

              var mixed = document.getElementById("transactionTable");

              // IE7 only supports appending rows to tbody
              var tbody = document.getElementById("transactionsBody");

              // for each outer array row
                 var tr = document.createElement("tr");

                 // for each inner array cell
                 // create td then text, append
                 var td = document.createElement("td");
                 var name = document.createTextNode(product.name);
                 td.appendChild(name);
                 tr.appendChild(td);

                 var td = document.createElement("td");
                 var price = document.createTextNode(product.price);
                 td.appendChild(price);
                 tr.appendChild(td);

                 var td = document.createElement("td");
                 var quantity = document.createElement("input");
                 quantity.type = 'number';
                 quantity.name = 'quantity';
                 quantity.style = 'width: 100%';
                 td.appendChild(quantity);
                 tr.appendChild(td);

                 var td = document.createElement("td");
                 var price = document.createTextNode("0");
                 td.appendChild(price);
                 tr.appendChild(td);


                  // var td = document.createElement("td");
                  // var i = document.createElement("i");
                  // i.className = "fa fa-trash";
                  // td.appendChild(i);
                  // tr.appendChild(td);

                 // append row to table
                 // IE7 requires append row to tbody, append tbody to table
                 tbody.appendChild(tr);
                 mixed.appendChild(tbody);


        }
    </script>

@endsection
