<?php $this->load->view('header') ?>
<style>
#luggage_expenses-error, #stock_out_date-error, #paid_amount-error{
    color:red;
}
</style>
<div class="wrapper">
    <?php $this->load->view('navbar') ?>
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <?php if (!isset($flowers)) { ?>
                            <div class="empty-text" style="padding-top: 5em;">
                                <div class="header text-center">
                                    <h3 class="title">Please add prices for flowers here <a href="<?= base_url() ?>customer/addPriceList" class="btn btn-md btn-warning">Add</a></h3>
                                    <p class="category">Right now..!We dint find any flowers list</p>
                                </div>                            
                            </div>
                        <?php } ?>
                        <form action="<?= base_url() ?>product/getCustomerEventDate" method="post">
                            <div class="row">
                                <div class="col-lg-8  col-md-8 col-md-offset-2 col-lg-offset-2 col-sm-12">
                                    <div class="input-group">
                                     <input type="text" name="event_date" id="event_date" value="<?php  if($this->session->userdata('last_date')){echo $this->session->userdata('last_date');}else{ echo date('Y-m-d'); } ?>" class="form-control datepicker">
                                     <span class="input-group-btn">
                                      <button type="submit" class="btn btn-danger btn-sm">Change</button>
                                  </span>
                              </div>
                              <small class="text-left text-primary">Note: You can change default price to previous date price</small>

                              
                          </div>
                      </div>
                  </form>
                  <div class="card">
                    <div class="card-header card-header-icon" data-background-color="green">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Flowers</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        
                        <div class="row" id="cust_div">
                            <div class="col-lg-6 col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-12">
                                <select class="selectpicker" name="customer_id" id="customer_id" data-style="btn btn-success btn-round" title="Single Select" data-size="7">
                                    <option disabled selected value="0">Choose Customer</option>
                                    <?php
                                    foreach ($customer as $value) {
                                        ?>
                                        <option value="<?= $value->customer_id ?>"><?= $value->first_name . ' ' . $value->last_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sno.</th>
                                        <th></th>
                                        <th>Flower Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                
                                <tbody class="table-data_php">

                                    <?php
                                    if (isset($flowers)) {
                                        $flower = json_decode($flowers);
                                        foreach ($flower as $value) {
                                            ?>
                                            <tr>
                                                <td><?= $value->flower_id ?></td>
                                                <td>
                                                    <input type="button" class="hidden-xs btn btn-warning btn-raised btn-sm edit" name="flower_id" value="Add" id="flower_id_<?= $value->flower_id ?>">
                                                    <input type="button" class="visible-xs btn btn-warning btn-sm edit" name="flower_id" value="+" id="<?= $value->flower_id ?>_flower_id">
                                                </td>
                                                <td><?= $value->flower_name ?></td>

                                                <td class="text-left">
                                                    <input type="number" onblur="getValue('<?= $value->flower_id ?>')" value="<?= $value->flower_price ?>" class="form-control flower_price text-primary" name="flower_price" id="flower_price_<?= $value->flower_id ?>">
                                                </td>
                                                <td class="text-left">
                                                    <input type="number" onblur="getValue('<?= $value->flower_id ?>')" placeholder="Quantity" class="form-control quantity" name="quantity" id="quantity_<?= $value->flower_id ?>">
                                                </td>
                                                <td id="total_price_<?= $value->flower_id ?>">0</td>

                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->


            </div>
            <div class="col-md-5">
                <center>
                    <h3 class="title">Added Flowers to cart</h3>
                    <hr/>
                </center>
                <table class="table table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>Flower</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody class ="order">

                    </tbody>
                </table>
                <hr/>
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="green">
                        <i class="material-icons">add_circle_outline</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Add Order to Customer</h4>
                        <div class="alert alert-danger" role="alert" id="error1" style="display: none;">Loading..!</div>
                        <form id="order-form" name="order_form" role="form" style="display: block;" method="post">
                            <input type="hidden" name="created_date" value="<?php  if($this->session->userdata('last_date')){echo $this->session->userdata('last_date');}else{ echo date('Y-m-d'); } ?>" class="form-control datepicker">
                            
                            <div class="hidden_values"></div>
                            <div class="row">
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Luggage Expenses</label>
                                        <input type="number" name="luggage_expenses" value="0" id="luggage_expenses" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Stock Out Date</label>
                                        <input type="text" name="stock_out_date" id="stock_out_date" value="<?php  if($this->session->userdata('last_date')){echo $this->session->userdata('last_date');}else{ echo date('Y-m-d'); } ?>" class="form-control datepicker">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Final Price</label>
                                        <input type="number" name="final_price" readonly="" id="stock_final_price" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Previous Balance</label>
                                        <input type="number" name="previous_balance" disabled="" id="previous_balance" class="form-control text-warning">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Paid Amount</label>
                                        <input type="number" name="paid_amount" onblur="balanceAmount()" id="paid_amount" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Balance amount <small><b>( Included with previous balance and luggage expenses )</b></small></label>
                                        <input type="number" name="balance_amount" readonly="" id="balance_amount"  class="form-control text-danger">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <button type="submit" name="finish" id="order-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                    <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Submit
                                </button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>
</body>
<?php $this->load->view('footer') ?>
<script src="<?= base_url() ?>assets/common.js"></script>
<script type="text/javascript">

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 

    today = yyyy + '-' + mm + '-' + dd;

    //  var event_date = $("#event_date").val();
    //  if(event_date == today){
    //     $(".flower_price").attr('readonly', false);
    //  }else{
    //     $(".flower_price").attr('readonly', true);
    //     notifications('You can`t edit Prices', 'Those are previous dated Prices', 'warning');
    //  }
//   $(".table-data").hide();
//   function eventDate() {
//       $(".table-data_php").hide();
//       $(".table-data").show();
//       var event_date = $("#event_date").val()
//           $.ajax({
//                     url: baseurl + "welcome/ajax_getDefaultDetails",
//                     method: "post",
//                     data: {event_date: event_date},
//                     success: function (data) {
//                         var jsonobj = JSON.parse(data);
//                         var htmlText = '';
//                         var json = jsonobj['customer_event']['flower_price'];
//                         var jsonobjk = JSON.parse(json);
//                         var flowers = jsonobjk['flowers_details'];
//                         var index = 1;
//                         for (var key in flowers) {
//                             var flower_name = flowers[key]['flower_name'];
//                             var flower_price = flowers[key]['flower_price'];
//                             var flower_id = flowers[key]['flower_id'];
//                             htmlText += '<tr><td>' + flower_id + '</td><td>' + flower_name + '</td>';
//                             htmlText += '<td><input type="button" class="hidden-xs btn btn-warning btn-raised btn-sm edit" name="flower_id" value="Add" id="flower_id_' + flower_id + '">';
//                             htmlText += '<input type="button" class="visible-xs btn btn-warning btn-sm edit" name="flower_id" value="+" id="' + flower_id + '_flower_id"></td>';
//                             htmlText += '<td class="text-left"> <input type="number" onblur="getValue(' + flower_id + ')" value="' + flower_price + '" class="form-control flower_price text-primary" name="flower_price" id="flower_price_' + flower_id + '"></td>';
//                             htmlText += '<td class="text-left"><input type="number" onblur="getValue(' + flower_id + ')" placeholder="Quantity" class="form-control quantity" name="quantity" id="quantity_' + flower_id + '"></td>';
//                             htmlText += '<td id="total_price_' + flower_id + '">0</td></tr>';
//                         }
//                         $('.table-data').append(htmlText); 
//                     }
//           });
//   }

$(".product").addClass('active');
$(".addProduct").addClass('active');
$(".navbar-brand").append("Add Flowers to customer");
$(document).ready(function () {

    $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }

    });
    var table = $('#datatables').DataTable();
    document.getElementById("order-submit").disabled = true;
    document.getElementById('previous_balance').value = 0;
   
    table.on('click', '.edit', function (e) {
        var $tr = $(this).closest('tr');
        var customer_id = document.getElementById('customer_id').value;
        if (customer_id == 0) {
            notifications('Choose Customer Id', 'Please Choose Customer Id', 'danger');
        } else {
            var data = table.row($tr).data();
            if (data == undefined) {

                var selected_row = $(this).parents('tr');
                if (selected_row.hasClass('child')) {
                    selected_row = selected_row.prev();
                }
                var rowData = table.row(selected_row).data();
                var flower_id = rowData[0];
                var flower_name = rowData[2];
            } else {
                var flower_id = data[0];
                var flower_name = data[2];
            }
            var flower_price = $('#flower_price_' + flower_id).val();
            var quantity = $('#quantity_' + flower_id).val();
            var total_price = (flower_price * quantity);
            if (flower_price.length == 0 || quantity.length == 0) {
                notifications('OOPS..!', 'Required FLower Price and Quantity', 'danger');
            } else {
                var stock_number = document.getElementById("stock_final_price").value;

                var sum = Number(total_price) + Number(stock_number);
                $("#stock_final_price").val(sum);
                                                                    $(".order").append('<tr class="remove_tr"><td>' + flower_name + '</td> <td>' + flower_price + '</td><td>' + quantity + '</td><td>' + total_price + '</td><td class="text-right">' + '<a href="#" class="btn btn-simple btn-danger btn-icon" onclick="deleteRow(this,' + flower_id + ')"><i class="material-icons">delete</i></a></td></tr>'); //add input box
                                                                    $(".hidden_values").append('<div id="hidden_tag_' + flower_id + '"><input type="hidden" name="total_price[]" value=' + total_price + '><input type="hidden" name="quantity[]" value=' + quantity + '><input type="hidden" name="flower_price[]" value=' + flower_price + '><input type="hidden" name="customer_id" value=' + customer_id + '><input type="hidden" name="flower_id[]" value=' + flower_id + '></div>'); //add input box
                                                                    $('#flower_id_' + flower_id).prop('disabled', true);
                                                                    $('#' + flower_id + '_flower_id').prop('disabled', true);

                                                                    $('#flower_price_' + flower_id).prop('disabled', true);
                                                                    $('#quantity_' + flower_id).prop('disabled', true);

                                                                    notifications('Added', flower_name + ' flower added to cart ', 'warning')
                                                                    document.getElementById("order-submit").disabled = false;
                                                                    e.preventDefault();
                                                                }
                                                            }

                                                        });
    $('.card .material-datatables label').addClass('form-group');
});

function deleteRow(btn, flower_id) {
    var stock_number = document.getElementById("stock_final_price").value;
    var total_price = $('#total_price_' + flower_id).html();
    var sub = stock_number - total_price;
    $("#stock_final_price").val(sub);
    $('#flower_id_' + flower_id).prop('disabled', false);
    $('#' + flower_id + '_flower_id').prop('disabled', false);

    $('#flower_price_' + flower_id).prop('disabled', false);
    $('#quantity_' + flower_id).prop('disabled', false);
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    $('#hidden_tag_' + flower_id).remove();
}
function getValue($id) {
    var flower = $('#flower_price_' + $id).val();
    var qunatity = $('#quantity_' + $id).val();
    var result = (flower * qunatity);
    $('#total_price_' + $id).html(result);
}

function balanceAmount() {
    var stock_price = document.getElementById("stock_final_price").value;
    if(stock_price.length < 1){
         document.getElementById("order-submit").disabled = true;
         return false;
    }
   
    var paid_amount = document.getElementById("paid_amount").value;
    var prev_balance = document.getElementById('previous_balance').value;
    var luggage_expenses = document.getElementById('luggage_expenses').value;
    var balance_amount = Number(stock_price) + Number(prev_balance) + Number(luggage_expenses);
    var bal_amt = Number(balance_amount) - Number(paid_amount);
    if (paid_amount > balance_amount) {
        document.getElementById("order-submit").disabled = true;
        notifications('Alert..!', 'Paid amount should not be greater than Total price', 'danger');
    } else {
        document.getElementById("order-submit").disabled = false;
    }
    document.getElementById('balance_amount').value = bal_amt;
}

function notifications(title, message, type) {
    $.notify({
        icon: "notifications",
        title: title,
        message: message

    }, {
        type: type,
        timer: 1000,
        placement: {
            from: 'bottom',
            align: 'center'
        }
    });
}

$('#customer_id').on('change', function () {
    var customer_id = document.getElementById('customer_id').value;
    $.ajax({
        url: baseurl + "customer/ajax_getCustomerBalance",
        method: "post",
        data: {customer_id: customer_id},
        success: function (data) {
            document.getElementById('previous_balance').value = Math.abs(data);
            balanceAmount();
        }
    });
});

</script>
</html>