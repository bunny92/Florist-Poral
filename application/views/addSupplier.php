<?php $this->load->view('header') ?>
<style>
    #first_name-error, #last_name-error, #supplier_place-error,#flower_id-error,#advance_amount-error,#Lsflower_id-error{
        color:red;
    }
</style>
<?php $this->load->view('navbar') ?>

<div class="wrapper">
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">add_circle_outline</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Supplier</h4>
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form id="supplier-form" name="supplier_form" role="form" style="display: block;" method="post">
                                    <div class="row">
                                        <div class="col-lg-6  col-md-6 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">First name <small style="color: red;">*</small></label>
                                                <input type="text" name="first_name" id="first_name" class="form-control text_val">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6  col-md-6 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Last name <small style="color: red;">*</small></label>
                                                <input type="text" name="last_name" id="last_name"  class="form-control text_val">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Father Name</label>
                                                <input type="text" name="supplier_father" id="supplier_father" class="form-control text_val">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Supplier Place <small style="color: red;">*</small></label>
                                                <textarea type="text" name="supplier_place" id="supplier_place" class="form-control"></textarea>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6  col-md-6 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Email</label>
                                                <input type="text" name="email" id="email" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6  col-md-6 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Mobile Number</label>
                                                <input type="text" name="mobile_number" id="mobile_number" maxlength="10" class="form-control num_val">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Choose Flowers <small style="color: red;">*</small></label>
                                                    <select multiple="multiple" class="selectpicker" name="Lsflower_id" id="Lsflower_id" data-style="btn btn-warning btn-round" title="Multiple Select" data-size="7">
                                                        <option disabled="" value="0"></option>
                                                        <?php foreach ($flowers as $value) { ?>
                                                            <option value="<?= $value->id ?>"> <?= $value->flower_name ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="hidden" name="flower_id" id="flower_id" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Advance amount <small style="color: red;">*</small></label>
                                                <input type="text" name="advance_amount" id="advance_amount" class="form-control num_val">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>

                                    </div>
                                    <center>
                                        <hr/>
                                        <button type="submit" name="finish" id="supplier-submit" class="btn btn-finish btn-fill btn-success btn-wd">
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
    $(".addSuppliers").addClass('active');
    $(".navbar-brand").append("Add Suppliers");
    function getValue() {
        var selected = $("#Lsflower_id option:selected");
        var message = "";
        selected.each(function () {
            message += $(this).val() + ",";
        });
        $("#flower_id").val(message.slice(0, -1));
    }

    $("#supplier-form").validate({

        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            advance_amount: {
                required: true
            },
            supplier_place: {
                required: true
            },
            Lsflower_id: {
                required: true
            }
        },
        messages: {
            first_name: {
                required: "Required First name"
            },
            last_name: "Last name is required",
            supplier_place: "Required place",
            advance_amount: "Minimum advance should be paid",
            Lsflower_id: "Choose atleast one flowers"
        },
        submitHandler: addSupplierForm
    });

    function addSupplierForm() {
        getValue();
        var data = $("#supplier-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "supplier/ajax_addSupplier",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#supplier-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Creating ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if (response = 'created') {
                    console.log("Supplier added Success..!");
                    document.getElementById("supplier-form").reset();
                    setTimeout(' window.location.href = "Supplier"; ', 2000);
                    $("#supplier-submit").html("Creating ...");
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Supplier got added..!"

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

    $(".text_val").bind('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(str)) {
            event.preventDefault();
            return false;
        }
    });


</script>
</html>