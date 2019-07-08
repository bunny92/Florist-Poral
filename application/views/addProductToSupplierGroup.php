<?php $this->load->view('header') ?>
<style>
    #luggage_expenses-error, #stock_out_date-error, #paid_amount-error{
        color:red;
    }

    div.sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
    }
</style>
<div class="wrapper">
    <?php $this->load->view('navbar') ?>
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="sticky_1">
                        <div class="col-md-6">
                            <?php if (!isset($flowers)) { ?>
                                <div class="empty-text" style="padding-top: 5em;">
                                    <div class="header text-center">
                                        <h3 class="title">Please add prices for flowers here <a href="<?= base_url() ?>Supplier/addPriceList" class="btn btn-md btn-warning">Add</a></h3>
                                        <p class="category">Right now..!We dint find any flowers list</p>
                                    </div>                            
                                </div>
                            <?php } ?>
                             <form action="<?= base_url() ?>product/getProductToSupplierGroupEventDate" method="post">
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
                                 
                            <div class="col-lg-8 col-md-8 col-md-offset-2 col-lg-offset-2 col-sm-12 group_drp">
                                <select class="selectpicker" name="group_id" onchange="getSuppliers()" id="group_id" data-style="btn btn-success btn-round" title="Single Select" data-size="7">
                                    <option disabled selected value="0">Choose Group</option>
                                    <?php
                                    foreach ($group as $value) {
                                        ?>
                                        <option value="<?= $value->id ?>"><?= $value->group_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="green">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Flowers</h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Sno.</th>
                                                    <th>Name</th>
                                                    <th>Rate</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                if (isset($flowers)) {
                                                    $flower = json_decode($flowers);
                                                    foreach ($flower as $value) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $value->flower_id ?></td>
                                                            <td><?= $value->flower_name ?></td>
                                                            <td class="text-left">
                                                                <input type="number" value="<?= $value->flower_price ?>" class="form-control flower_price text-primary" name="flower_price" id="flower_price_<?= $value->flower_id ?>">
                                                            </td>
                                                            <td>
                                                                <input type="button" class="hidden-xs btn btn-warning btn-raised btn-sm edit" name="flower_id" value="Add" id="flower_id_<?= $value->flower_id ?>">
                                                                <input type="button" class="visible-xs btn btn-warning btn-sm edit" name="flower_id" value="+" id="<?= $value->flower_id ?>_flower_id">
                                                                <a href="#" class="btn btn-simple btn-danger btn-icon del" id="rem_<?= $value->flower_id ?>" onclick="removeTr(<?= $value->flower_id ?>); return false;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Remove"><i class="material-icons">delete</i><div class="ripple-container"></div></a>
                                                            </td>
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
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-md-offset-1 col-sm-12">
                                <div class="customerDetails">

                                </div>
                                <div class="emptyRefresh" style="padding-top:90px;">
                                    <center>
                                        <h4> Done with order <br/> Then <a href="<?= base_url() ?>product/addProductToSupplierGroup" class="btn btn-info btn-sm">Refresh</a> to create few more orders</h4>
                                    </center>
                                </div>
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
     
    $(".suppliers").addClass('active');
    $(".supplierGroupBilling").addClass('active');
    $(".navbar-brand").append("Add Flowers to Supplier Group");
    $(".emptyRefresh").hide();
    $(document).ready(function () {

        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            lengthMenu: [[2, 4, 8, -1], [2, 4, 8, "All"]],
            pageLength: 5,
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });

        $(".del").hide();
        var table = $('#datatables').DataTable();
        table.on('click', '.edit', function (e) {
            var $tr = $(this).closest('tr');
            var group_id = document.getElementById('group_id').value;
            if (group_id == 0) {
                notifications('Choose Group Name', 'Please Choose Group', 'danger');
            } else {
                var data = table.row($tr).data();
                var flower_id = data[0];
                var flower_name = data[1];
                var flower_price = $('#flower_price_' + flower_id).val();
                if (flower_price.length == 0) {
                    notifications('OOPS..!', 'Required Flower Price', 'danger');
                } else {
                   
                    $(".flower_details").append('<tr class=' + flower_id + '><td>' + flower_name + '</td> <td>' + flower_price + '</td><td class="text-left"><input type ="hidden" name="flower_id[]" value=' + flower_id + '><input type ="hidden" name="flower_price[]" id="flower_price_' + flower_id + '" value=' + flower_price + '><input type="number" class="form-control" id="quantity_' + flower_id + '" name="quantity[]"></td></tr>'); //add input box
                    $('#flower_id_' + flower_id).prop('disabled', true);
                    $('#' + flower_id + '_flower_id').prop('disabled', true);
                    $('#flower_price_' + flower_id).prop('disabled', true);
                    $('.group_drp').hide();
                    $(".submit-btn").show();
                    $(".commission").show();
                    $('#rem_' + flower_id).show();
//                                                    notifications('Added', flower_name + ' flower added to cart ', 'warning');
                    e.preventDefault();
                }
            }

        });
        $('.card .material-datatables label').addClass('form-group');
    });
    function getSuppliers() {
        var group_id = document.getElementById("group_id").value;

        if ($(".table_div").length) {
            $(".table_div").hide();
        }
        $.ajax({
            url: baseurl + "supplier/ajax_getGroupSupplierById",
            method: "post",
            data: {group_id: group_id},
            success: function (data) {
                var jsonobj = JSON.parse(data);
                var index = 1;
                var htmlText = '';

                for (var key in jsonobj) {
                    var supplier_id = jsonobj[key]['supplier_id'];

                    htmlText += '<div class="table_div" id="table_' + supplier_id + '"><br/><h4><b>' + index++ + '. Supplier:</b> <b class="text-primary text-capitalize">' + jsonobj[key]['supplier_name'] + '</b><h4>';
                    htmlText += '<form onsubmit="addGroupOrderForm(' + supplier_id + '); return false" id="grouporder-form_' + supplier_id + '" name="grouporder_form" role="form" style="display: block;" method="post">' +
                            '<input type ="hidden" name="supplier_id" id="customer_' + supplier_id + '" value=' + supplier_id + '>' +
                            '<table class="table table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                            '<thead><tr class="text-warning"><td>Flower name</td><td>Rate</td><td>Quantity</td></tr></thead><tbody class="flower_details">' +
                            '</tbody></table>' +
                            '<div class="row commission">' +
                            '<div class="col-md-6 col-lg-6 col-sm-12"><div class="form-group label-floating has-info"><label class="control-label">Commission</label>' +
                            '<input type="text" name="commission" id="commission_' + supplier_id + '" class="form-control"></div></div></div>' +
                            '<input type="hidden" name="created_at" value="<?php  if($this->session->userdata('last_date')){echo $this->session->userdata('last_date');}else{ echo date('Y-m-d'); } ?>">'+
                            '<center><button type="submit" id="grouporder-submit_' + supplier_id + '" name="finish" class="btn btn-success btn-sm submit-btn"><span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Submit</button></center></form></div>';
                }

                $('.customerDetails').append(htmlText);
                $(".commission").hide();
                $(".submit-btn").hide();
            }
        });
    }

    function getTotal(id) {
        var flower_price = $('#flower_price_' + id).val();
        var qunatity = $('#quantity_' + id).val();
        var total = parseFloat(flower_price) * Number(qunatity);
        var sum = 0;
// iterate through each td based on class and add the values
        $(".total").each(function () {

            var value = $(this).text();
            // add only if the value is number
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        document.getElementById('total_' + id).innerHTML = total;
        console.log(total);
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
    function addGroupOrderForm(supplier_id) {
        var commission = $('#commission_' + supplier_id).val();
       if (commission > 100) {
            notifications('opps..!', 'Commision shouldn`t be above 100%', 'danger');
            return false;
        }
        if (commission < 1) {
            notifications('opps..!', 'Commision shouldn`t be less than 1%', 'danger');
            return false;
        }
        var data = $("#grouporder-form_" + supplier_id).serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "product/ajax_addOrderToSupplierGroup",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#grouporder-submit_" + supplier_id).html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Creating ...');
            },
            success: function (response) {
                console.log(response);
                if ($.trim(response) > 0) {
                    $("#table_" + supplier_id).hide();
                    swal({
                        title: "Success",
                        text: "Created Order Successfully..!",
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success",
                        type: "success",
                    })
                    var len = $(".table_div").length;
                    if (len == 0) {
                        $(".emptyRefresh").show();
                    }
                } else if ($.trim(response) === "empty") {
                    notifications('OPPS..!', 'We required Quantity, Please enter', 'danger');
                    $("#grouporder-submit_" + supplier_id).html('Submit');
                }

            }
        });
        return false;
    }

    function removeTr($flower_id) {
        $('.' + $flower_id).remove();
        $('#flower_price_' + $flower_id).prop('disabled', false);
        $('#flower_id_' + $flower_id).prop('disabled', false);
        $('#' + $flower_id + '_flower_id').prop('disabled', false);
        $('#rem_' + $flower_id).hide();

    }

</script>
</html>