<?php $this->load->view('header') ?>
<style>
    #firstname-error, #lastname-error, #phone-error{
        color:red;
    }
</style>
<?php $this->load->view('navbar') ?>
<div class="wrapper">
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="col-md-10 col-md-offset-1 col-sm-12">
                    <div class="card">
                        <div class="card-header card-header-text" data-background-color="green">
                            <h4 class="card-title">Update customer</h4>
                        </div>
                        <div class="card-content">

                            <div class="tab-content">
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form id="update_customer-form" name="update_customer_form" role="form" style="display: block;" method="post">
                                    <input type="hidden" value="<?= $customer->customer_id ?>" name="customer_id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">face</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">First Name
                                                        <small>(required)</small>
                                                    </label>
                                                    <input name="firstname" value="<?= $customer->first_name ?>" id="firstname" type="text" class="form-control text_val">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">record_voice_over</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Last Name
                                                        <small>(required)</small>
                                                    </label>
                                                    <input name="lastname" value="<?= $customer->last_name ?>" id="lastname" type="text" class="form-control text_val">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_box</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Father Name
                                                    </label>
                                                    <input name="father_name" value="<?= $customer->father_name ?>" id="father_name" type="text" class="form-control text_val">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-lg-10 col-lg-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Address</label>
                                                    <input name="address" value="<?= $customer->customer_address ?>" id="customer_address" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-7 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Street Name</label>
                                                    <input type="text" name="street_name" value="<?= $customer->customer_city ?>" id="street_name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Pincode</label>
                                                    <input type="text" name="pincode" value="<?= $customer->customer_pincode ?>" maxlength="6" id="pincode" class="form-control num_val">
                                                </div>
                                            </div>

                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Phone Number
                                                        <small>(required)</small>
                                                    </label>
                                                    <input name="phone" id="phone" value="<?= $customer->customer_phone ?>" maxlength="10" type="text" class="form-control num_val">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Email Address
                                                    </label>
                                                    <input name="customer_email"  value="<?= $customer->customer_email ?>"  id="customer_email" type="email" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <center>
                                                <button type="submit" name="finish" id="update_customer-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                                    <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Update</button>
                                            </center>
                                        </div>
                                    </div>

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
<script>
    $(".customer").addClass('active');
    $(".modifyCustomer").addClass('active');
    $(".navbar-brand").append("Modify Customer Details");

    function checkEmail() {
        var customer_email = document.getElementById("customer_email").value;
        $.ajax({
            type: "POST",
            url: baseurl + "customer/ajax_checkEmail",
            data: {customer_email: customer_email},

            success: function (response) {
                if ($.trim(response) === "success") {
                    document.getElementById("customer-submit").disabled = true;
                    $.notify({
                        icon: "notifications",
                        title: "Alert..!",
                        message: "Email is already taken"

                    }, {
                        type: 'danger',
                        timer: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'center'
                        }
                    });
                } else {
                    document.getElementById("customer-submit").disabled = false;
                }
            }
        });
        return false;
    }
    function checkPhoneNumber() {
        var phone = document.getElementById("phone").value;
        $.ajax({
            type: "POST",
            url: baseurl + "customer/ajax_checkPhoneNumber",
            data: {customer_phone: phone},

            success: function (response) {
                if ($.trim(response) === "success") {
                    document.getElementById("customer-submit").disabled = true;
                    $.notify({
                        icon: "notifications",
                        title: "OPPS..!",
                        message: "Phone number is already taken"

                    }, {
                        type: 'danger',
                        timer: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'center'
                        }
                    });
                } else {
                    document.getElementById("customer-submit").disabled = false;
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