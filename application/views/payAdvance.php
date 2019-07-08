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
                    <div class="col-md-6 col-md-offset-3">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">contacts</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Update Advance</h4>
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form id="advance-form" name="advance_form" role="form" style="display: block;" method="post">

                                    <div class="row">
                                        <div class="row">
                                            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Choose Supplier <small style="color: red;">*</small></label>
                                                    <select class="selectpicker" onchange="getFlowerData(this)" id="supplier_id" name="supplier_id" data-style="btn btn-success btn-round" title="Single Select" data-size="7">
                                                        <option disabled="" value="0">Select Suppliers</option>
                                                        <?php foreach ($supplier as $value) { ?>
                                                            <option value="<?= $value->id ?>"> <?= $value->supplier_name ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                                            <div class="table-data">

                                            </div>
                                            
                                            
                                        </div>
                                        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                                            <br/><br/>
                                                <center><b>Supplier Advance :</b> <span id="supplier_adv" class="text-primary">0</span></center>
                                            <div class="form-group label-floating is-empty has-warning is-focused">
                                                <label class="control-label">Add Advance amount <small style="color: red;">*</small></label>
                                                <input type="text" name="supplier_advance" id="supplier_advance" class="form-control num_val">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <hr/>
                                        <button type="submit" name="finish" id="advance-submit" class="btn btn-finish btn-fill btn-success btn-wd">
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

<script type="text/javascript">

    $(".suppliers").addClass('active');
    $(".payAdvance").addClass('active');
    $(".navbar-brand").append("Update Advance");
    function getFlowerData(sel) {
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
                var htmlText = '<div class="col-md-8 col-md-offset-2 table-data_details"><h4 class="text-danger text-center">Supplier Flowers</h4><table class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                        '<thead><tr><td>#</td><td>Flower name</td></tr></thead><tbody>';
                var index = 1;
                for (var key in jsonobj) {
                    var flower_name = jsonobj[key]['flower_name'];
                    htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td></tr>';
                }
                htmlText += '</tbody></table>';
                $('.table-data').append(htmlText);
            }
        });
        $.ajax({
            url: baseurl + "supplier/ajax_getSupplierById",
            method: "post",
            data: {supplier_id: supplier_id},
            success: function (data) {
                console.log(data);
                var jsonobj = JSON.parse(data);
                var supplier_advance = jsonobj['supplier_advance'];
                $('#supplier_advance').val(0);
                $('#supplier_adv').html(supplier_advance);
            }
        });
    }
    $("#advance-form").validate({

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

    function payAdvanceForm() {

        var data = $("#advance-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "supplier/ajax_payAdvance",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#advance-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Updating ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if (response = 'updated') {
                    console.log("Advance updated..!");
                    document.getElementById("advance-form").reset();
                    setTimeout(' window.location.href = ""; ', 2000);
                    $("#advance-submit").html("Updating ...");
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Advance added..!"

                    }, {
                        type: 'success',
                        timer: 2000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });

                } else {
                    $("#error").html(response).show();
                }
            }
        });
        return false;
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
</html>