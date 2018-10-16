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

            <div class="bottom-dashboard">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card mb-2">
                            <h5 class="card-title lists-title">Transaction Summary</h5>
                            <!-- <div class="card-body text-center h-100 d-table"> -->
                                <div class="lists-table table-responsive mt-3">
                                    <table class="table table-hover table-striped py-3 text-center" id="transactionTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Stocks</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody id="transactionsTBody">
                                        </tbody>
                                    </table>
                                    <div class="ml-2">
                                        <p><b>Total : <span id="total"></span></b></p>
                                        <p>
                                            <b class="float-left m-auto">Money : </b>
                                            <input class="ml-2" id="money" onkeyup="updateChange()" type="number">
                                        </p>
                                        <p><b>Change: <span id="change"></span></b></p>
                                    </div>
                                    <div class="text-center mb-3">
                                        <button id="save" type="button" class="btn btn-primary" name="button">SAVE</button>
                                    </div>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>

                    <div class="col-12 col-xl-6 mt-xl-0 mt-4">
                        <div class="card mb-2">
                            <h5 class="card-title report-title">Products</h5>
                            <div class="form-group mt-4" align="center">
                                <label for="search">Search here :</label>
                                <input type="text" name="search" id="search" class="w-50 form-control" placeholder="Search Product">
                            </div>
                            <div class="lists-table table-responsive mt-3">    
                            <h4 align="center">Total Product: <span id="total_records"></span></h4>
                                <table id="productsTable" class="table table-hover table-striped py-3 text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Stocks Remaining</th>
                                            <th scope="col">Add</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productsTBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() { 

            fetch_product_data_transact();

             function fetch_product_data_transact(query = '')
            {
                $.ajax({
                url:"{{ route('products.transact') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data) {
                    $('#productsTBody').html(data.table_data);
                    $('#total_records').text(data.total_data);
                },
                error:function(data) {
                    console.log(data);
                }
                })
            }

            $(document).on('keyup', '#search', function() {
                var query = $(this).val();
                fetch_product_data_transact(query);
            });

            $( "#save" ).click(function() {
                if (confirm("Confirm Transaction")) {

                    var tBodyChildren = document.getElementById('transactionsTBody').children;
                    var transactions = {};
                    
                    for (var i = 0; i < tBodyChildren.length; i++) {
                        transactions[i] = {
                            'product_id': tBodyChildren[i].children[7].children[0].value,
                            'quantity': tBodyChildren[i].children[4].children[0].value,
                            'subtotal': tBodyChildren[i].children[5].innerText
                        };
                    }
                    
                    $.ajax({
                    url:"{{ route('transactions.get') }}",
                    method:'GET',
                    data:{
                        transactions: transactions,
                        total: $('#total').text(),
                        money: $('#money').val(),
                        change: $('#change').text()
                    },
                    dataType:'json',
                    success:function(data) {
                        window.location.href = "/transactions";
                    },
                    error:function(data) {
                        if (data.status == 200 && data.responseText === "success")
                            window.location.href = "/transactions";
                    }
                    })

                }
            });
            
        });

        function addTransaction(id, name, desc, srp, stocks) {
            var td, tr;            
            var tbody = document.getElementById("transactionsTBody");

            // for each outer array row
            tr = document.createElement("tr");

            // for each inner array cell
            // create td then text, append
            td = document.createElement("td");
            var node_name = document.createTextNode(name);
            td.appendChild(node_name);
            tr.appendChild(td);

            td = document.createElement("td");
            var node_desc = document.createTextNode(desc);
            td.appendChild(node_desc);
            tr.appendChild(td);
            
            td = document.createElement("td");
            var node_stocks = document.createTextNode(stocks);
            td.appendChild(node_stocks);
            tr.appendChild(td);

            td = document.createElement("td");
            var node_srp = document.createTextNode(srp);
            td.appendChild(node_srp);
            tr.appendChild(td);

            td = document.createElement("td");
            var node_quantity = document.createElement("input");
            node_quantity.type = 'number';
            node_quantity.name = 'quantity';
            node_quantity.style = 'width: 50%';
            node_quantity.setAttribute("onkeypress","checkStocks(this, event, "+ stocks +")");
            node_quantity.setAttribute("onkeyup","updateSubtotal(this, " + stocks + ")");
            td.appendChild(node_quantity);
            tr.appendChild(td);

            td = document.createElement("td");
            var node_total = document.createTextNode("0");
            td.appendChild(node_total);
            tr.appendChild(td);


            td = document.createElement("td");
            td.style = "cursor: pointer";
            td.setAttribute("onclick","deleteRow(this)");
            // var i = document.createTextNode("del");
            var i = document.createElement("i");
            i.className = "fa fa-trash";
            // td.setAttribute("onclick","deleteRow(this)");
            td.appendChild(i);
            tr.appendChild(td);

            td = document.createElement("td");
            td.style = 'display: none';
            var node_id = document.createElement("input");
            node_id.type = 'hidden';
            node_id.value = id;
            td.appendChild(node_id);
            tr.appendChild(td);

            // append row to table
            // IE7 requires append row to tbody, append tbody to table
            tbody.appendChild(tr);
        }

        function setTotal() {
            var temp = 0;
            var tBodyChildren = document.getElementById('transactionsTBody').children;
            for(var i = 0; i < tBodyChildren.length; i++) 
                temp += parseFloat(tBodyChildren[i].children[5].innerText);
            
            document.getElementById("total").innerText = temp;
            updateChange();
        }

        
        function deleteRow(r) {
            var i = (r.parentNode.parentNode.rowIndex - 1);
            document.getElementById('transactionsTBody').deleteRow(i);
            setTotal();
            updateChange();
        }
        
        function updateSubtotal(r, stocks) {
            if (r.value > stocks) r.value = stocks;
            var temp = 0;
            var node = r.parentNode.parentNode.children;
            var price = node[3].innerText;
            var quantity = node[4].children[0].value;
            node[5].innerText = price * quantity;
            setTotal();
        }

        function updateChange() {
            var total = document.getElementById("total");

            if(total.innerText.length > 0) {
                var change = document.getElementById("change");
                var money = document.getElementById("money");
                if(money.value.length > 0)
                    change.innerText = parseFloat(money.value) - parseFloat(total.innerText);
                else change.innerText = 0;
            }

        }

        function checkStocks(r, evt, stocks){
            var charCode = (evt.which) ? evt.which : event.keyCode;

            if (
                //0~9
                charCode >= 48 && charCode <= 57 ||
                //number pad 0~9
                charCode >= 96 && charCode <= 105 ||
                    //backspace
                charCode == 8 ||
                //tab
                charCode == 9 ||
                //enter
                charCode == 13 || 
                //left, right, delete..
                charCode >= 35 && charCode <= 46
            ) {
                //make sure the new value below the STOCKS
                if(
                    (parseInt(r.value+String.fromCharCode(charCode), 10) <= stocks) ||
                    (parseInt(String.fromCharCode(charCode)+r.value, 10) <= stocks)    
                ) return true;
            }

            // evt.preventDefault();
            // evt.stopPropagation();

            updateSubtotal(r, stocks);

            return false;
        }

    </script>

@endsection
