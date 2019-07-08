<?php $this->load->view('header') ?>
<style>
    #supplier_id-error, #supplier_advance-error{
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
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">contacts</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Billing Info</h4>
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form id="billing-form" name="billing_form" role="form" style="display: block;" method="post">
                                    <input type="hidden" id="final_price" name="final_price">
                                    <input type="hidden" id="sup_advance" name="sup_advance">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Choose Supplier <small style="color: red;">*</small></label>
                                                    <select class="selectpicker" onchange="getFlowerData(this)" id="supplier_id" name="supplier_id" data-style="btn btn-success btn-round" title="Single Select" data-size="7">
                                                        <option disabled="" value="0">Select Supplier</option>
                                                        <?php foreach ($supplier as $value) { ?>
                                                            <option value="<?= $value->id ?>"> <?= $value->supplier_name ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12">
                                            <div class="dateandtime">
                                            <input type="text" name="event_date" onclick="eventDate()" id="event_date" value="<?= date('Y-m-d'); ?>" class="form-control datepicker">
                                                
                                            </div>
                                            <div class="table-data"></div>
                                            <div class="checkbox pull-right"><label><input type="checkbox" id="pay_later" name="pay_later"><span class="checkbox-material"></span><b class="text-primary"> Want to Pay Total Cost Later ?</b></label></div>
                                        </div>
                                    </div>
                                    <center>
                                        <hr/>
                                        <button type="submit" name="finish" id="billing-submit" class="btn btn-finish btn-fill btn-success btn-wd">
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
<?php $this->load->view('footer') ?>
<script type="text/javascript">

    $(".suppliers").addClass('active');
    $(".supplierBilling").addClass('active');
    $(".navbar-brand").append("Supplier Billing");
    document.getElementById("billing-submit").disabled = true;
    $('.checkbox').hide();
    $('.dateandtime').hide()
     function getFlowerData(sel) {
        $('.dateandtime').show(); 
        $('#pay_later').prop("disabled", false);
        $("#pay_later").prop("checked", false);
        var supplier_id = $(sel).val();
        if ($(".table-data_details").length) {
            $(".table-data_details").remove();
        }

        $.ajax({
            url: baseurl + "supplier/ajax_getSupplierFlowers",
            method: "post",
            data: {supplier_id: supplier_id},
            success: function (data) {
                var jsonobj = JSON.parse(data);
                var baseurl = '<?php echo base_url(); ?>/';
                var htmlText = '<div class="col-md-12 table-data_details"><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                        '<thead><tr class="text-warning"><td>Flower</td><td>Rate</td><td>Quantity</td><td>Total</td></tr></thead><tbody>';
                for (var key in jsonobj) {
                    var flower_name = jsonobj[key]['flower_name'];
                    var flower_price = jsonobj[key]['flower_price'];
                    var flower_id = jsonobj[key]['flower_id'];
                    htmlText += '<tr><td>' + flower_name + '</td><td><input type="hidden" name="flower_id[]" value="' + flower_id + '"><input type="number" name="flower_price[]" id="flower_price_' + flower_id + '" class="form-control num_val text-primary" onblur="getValue(' + flower_id + ')" value="' + flower_price + '"></td><td><input type="number" onblur="getValue(' + flower_id + ')" placeholder="Quantity" id="quantity_' + flower_id + '" name="quantity[]" class="form-control num_val"></td><td class="total" id="total_price_' + flower_id + '">0</td></tr>';
                }
                htmlText += '<tr><td></td><td></td><td class="text-primary">Total Cost</td><td class="total-cost"><b>0</b></td></tr>';
                htmlText += '<tr><td></td><td></td><td class="text-info">Commission % <br/><small class="text-danger">( On Total Cost )</small></td><td><b><input type="number" placeholder="0" onblur="calCommission()" class="form-control num_val text-info" id="cal_commission"><input type="text" readonly="" placeholder="commission price" name="commission" width="50px" class="form-control text-info" id="commission"></b></td></tr>';
                htmlText += '<tr><td></td><td></td><td class="text-warning">Grand Total</td><td class="grand-total font-weight-bold text-success"><b>0</b></td></tr>';
                htmlText += '<tr><td></td><td></td><td class="text-primary">Advance amount <br/><small class="text-danger"><a href="' + baseurl + 'Supplier/payAdvance">( add advance )</a></small> </td><td><b><input type="number" name="supplier_advance" onblur="Javascript: getUserAdvance(); return false;" class="form-control num_val text-primary" id="supplier_advance"></b></td></tr>';
                htmlText += '<tr><td></td><td></td><td class="text-success">Final Cost</td><td class="total-data text-danger"><b>0</b></td></tr></tbody></table>';
                $('.table-data').append(htmlText);
                document.getElementById("billing-submit").disabled = false;
                getAdvance(supplier_id);
                //  var event_date = $('#event_date').val();
                // eventDate(supplier_id,event_date)
            }
        });

    }
    
    function eventDate(){
         $('#pay_later').prop("disabled", false);
         $("#pay_later").prop("checked", false);
        if ($(".table-data_details").length) {
            $(".table-data_details").remove();
        }
      var supplier_id = $('#supplier_id').val();    
      var event_date = $('#event_date').val(); 
          $.ajax({
                    url: baseurl + "supplier/ajax_getSupplierDefaultPrices",
                    method: "post",
                    data: {event_date: event_date, supplier_id: supplier_id},
                    success: function (data) {
                        var jsonobj = JSON.parse(data);
                        var baseurl = '<?php echo base_url(); ?>/';
                var htmlText = '<div class="col-md-12 table-data_details"><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                        '<thead><tr class="text-warning"><td>Flower</td><td>Rate</td><td>Quantity</td><td>Total</td></tr></thead><tbody>';
                for (var key in jsonobj) {
                    var flower_name = jsonobj[key]['flower_name'];
                    var flower_price = jsonobj[key]['flower_price'];
                    var flower_id = jsonobj[key]['flower_id'];
                    htmlText += '<tr><td>' + flower_name + '</td><td><input type="hidden" name="flower_id[]" value="' + flower_id + '"><input type="number" name="flower_price[]" id="flower_price_' + flower_id + '" class="form-control num_val text-primary" onblur="getValue(' + flower_id + ')" value="' + flower_price + '"></td><td><input type="number" onblur="getValue(' + flower_id + ')" placeholder="Quantity" id="quantity_' + flower_id + '" name="quantity[]" class="form-control num_val"></td><td class="total" id="total_price_' + flower_id + '">0</td></tr>';
                }
                htmlText += '<tr><td></td><td></td><td class="text-primary">Total Cost</td><td class="total-cost"><b>0</b></td></tr>';
                htmlText += '<tr><td></td><td></td><td class="text-info">Commission % <br/><small class="text-danger">( On Total Cost )</small></td><td><b><input type="number" placeholder="0" onblur="calCommission()" class="form-control num_val text-info" id="cal_commission"><input type="text" readonly="" placeholder="commission price" name="commission" width="50px" class="form-control text-info" id="commission"></b></td></tr>';
                htmlText += '<tr><td></td><td></td><td class="text-warning">Grand Total</td><td class="grand-total font-weight-bold text-success"><b>0</b></td></tr>';
                htmlText += '<tr><td></td><td></td><td class="text-primary">Advance amount <br/><small class="text-danger"><a href="' + baseurl + 'Supplier/payAdvance">( add advance )</a></small> </td><td><b><input type="number" name="supplier_advance" onblur="Javascript: getUserAdvance(); return false;" class="form-control num_val text-primary" id="supplier_advance"></b></td></tr>';
                htmlText += '<tr><td></td><td></td><td class="text-success">Final Cost</td><td class="total-data text-danger"><b>0</b></td></tr></tbody></table>';
                $('.table-data').append(htmlText);
                document.getElementById("billing-submit").disabled = false;
                getAdvance(supplier_id);
                    }
          });
    }


    $("#billing-form").validate({

        rules: {
            supplier_advance: {
                required: true
            },
            supplier_id: {
                required: true
            }
        },
        messages: {
            supplier_advance: {
                required: "Required minimum advance"
            },
            supplier_id: "Please choose Supplier"
        },
        submitHandler: payAdvanceForm
    });
    function getValue($id) {

        var flower = $('#flower_price_' + $id).val();
        var qunatity = $('#quantity_' + $id).val();
        var result = (flower * qunatity);
        $('#total_price_' + $id).html(result);
        var sum = 0;
// iterate through each td based on class and add the values
        $(".total").each(function () {

            var value = $(this).text();
            // add only if the value is number
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });

        $('.total-cost').html(sum);
        $('#final_price').val(sum);
        calCommission();
    }

    function calCommission() {

        $('.checkbox').show();
        var cal_commission = $('#cal_commission').val();
        var supplier_advance = $('#supplier_advance').val();
        var sum = 0;
// iterate through each td based on class and add the values
        $(".total").each(function () {

            var value = $(this).text();
            // add only if the value is number
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });

        var commission = ((cal_commission / 100) * sum);
        $('#commission').val(commission);
        var final_sum = (Number(sum) - Number(commission));
         $('.grand-total').html(final_sum);
        var advance = (Number(supplier_advance) - Number(final_sum));
        if (advance <= 0 || supplier_advance == 0) {
            var rev_advance = (Number(final_sum) - Number(supplier_advance));
            $('.total-data').html(rev_advance);
            $('#sup_advance').val(0);
        } else {
            $('.total-data').html(advance);
            $('#sup_advance').val(advance);
        }
    }

    var checkbox = $("#pay_later");
    checkbox.on("click", function () {
        var quantity = document.getElementsByName('quantity[]');
        for (var i = 0; i < quantity.length; i++)
        {
            if (quantity[i].value == "")
            {
                notifications('Please', 'Complete all the fields', 'danger');
                return false;
            }
        }
        var flower_price = document.getElementsByName('flower_price[]');
        for (var i = 0; i < flower_price.length; i++)
        {
            if (flower_price[i].value == "")
            {
                notifications('Please', 'Complete all the fields', 'danger');
                return false;
            }
        }
        $('input[name="quantity[]"]').prop("readonly", true);
        $('input[name="flower_price[]"]').prop("readonly", true);
        // $('#pay_later').prop("disabled", true);
        $('#supplier_advance').prop("disabled", true);
        $('#cal_commission').prop("disabled", true);
        var supplier_advance = $('#supplier_advance').val();
        var total_price = $('.grand-total').html();

        if ($(this).prop("checked")) {
            var sum = (Number(supplier_advance) + Number(total_price));
            $('#final_price').val(0);
            $('.total-cost').html(0);
            $('.total-data').html(sum);
            $('#supplier_advance').val(sum);
            $('#sup_advance').val(sum);
        }else if(!$(this).prop("checked")){
        $('#supplier_advance').prop("disabled", false);
        $('#cal_commission').prop("disabled", false);
            var sub = (Number(supplier_advance) - Number(total_price));
            var sum = 0;
// iterate through each td based on class and add the values
        $(".total").each(function () {

            var value = $(this).text();
            // add only if the value is number
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });

        $('.total-cost').html(sum);
        $('#final_price').val(sum);
            $('.total-data').html(sub);
            $('#supplier_advance').val(sub);
            $('#sup_advance').val(sub);
            calCommission();
        }
    })
    function getAdvance(supplier_id) {
        $.ajax({
            url: baseurl + "supplier/ajax_getSupplierAdvance",
            method: "post",
            data: {supplier_id: supplier_id},
            success: function (advance) {
                $('#supplier_advance').val(advance);
            }
        });

    }

    function getUserAdvance() {
        var supplier_advance = $('#supplier_advance').val();
        // var sum = 0;
        // $(".total").each(function () {

        //     var value = $(this).text();
        //     // add only if the value is number
        //     if (!isNaN(value) && value.length != 0) {
        //         sum += parseFloat(value);
        //     }
        // });
         var sum = $('.grand-total').html();
        var advance = (Number(supplier_advance) - Number(sum));
        if (advance <= 0 || supplier_advance == 0) {
            var rev_advance = (Number(sum) - Number(supplier_advance));
            $('.total-data').html(rev_advance);
            $('#sup_advance').val(0);
        } else {
            $('.total-data').html(advance);
            $('#sup_advance').val(advance);
        }
    }
    function payAdvanceForm() {
        var commission = $('#cal_commission').val();
        var quantity = document.getElementsByName('quantity[]');
        for (var i = 0; i < quantity.length; i++)
        {
            if (quantity[i].value == "")
            {
                notifications('Please', 'Complete all the fields', 'danger');
                return false;
            }
        }
        var flower_price = document.getElementsByName('flower_price[]');
        for (var i = 0; i < flower_price.length; i++)
        {
            if (flower_price[i].value == "")
            {
                notifications('Please', 'Complete all the fields', 'danger');
                return false;
            }
        }
        if (commission > 100) {
            notifications('opps..!', 'Commision shouldn`t be above 100%', 'danger');
            return false;
        }
        if (commission < 1) {
            notifications('opps..!', 'Commision shouldn`t be less than 1%', 'danger');
            return false;
        }
        var data = $("#billing-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "supplier/ajax_addSupplierBilling",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                 document.getElementById("billing-submit").disabled = true;
                $("#billing-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Adding ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if ($.trim(response) > 0) {
                    console.log("Supplier Billing added..!");
                    document.getElementById("billing-form").reset();
                    $("#billing-submit").html("Adding ...");
                    swal({
                        title: "Success",
                        text: "Created Order Successfully..!",
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success",
                        type: "success",
                    }).then(function () {
                        location.reload();
                    }
                    );
                } else {
                    $("#error").html(response).show();
                }
            }
        });
        return false;
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
    $('.num_val').bind('keypress', function (event) {
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
</script>
</body>
</html>