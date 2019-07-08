<?php $this->load->view('header') ?>
<style>
    #firstname-error, #lastname-error, #phone-error{
        color:red;
    }
</style>
<div class="wrapper">
    <?php $this->load->view('navbar') ?>
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="col-md-10 col-md-offset-1 col-sm-12">
                    <div class="card">
                        <div class="card-header card-header-text" data-background-color="green">
                            <h4 class="card-title">Add customer</h4>
                        </div>
                        <div class="card-content">

                            <div class="tab-content">
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form id="customer-form" name="customer_form" role="form" style="display: block;" method="post">
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
                                                    <input name="firstname" onkeyup="billingName()" id="firstname" type="text" class="form-control text_val">
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
                                                    <input name="lastname" id="lastname" onkeyup="billingName()" type="text" class="form-control text_val">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_box</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Father Name
                                                    </label>
                                                    <input name="father_name" id="father_name" type="text" class="form-control text_val">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-lg-10 col-lg-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Address</label>
                                                    <input name="address" id="customer_address" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-7 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Street Name</label>
                                                    <input type="text" name="street_name" id="street_name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Pincode</label>
                                                    <input type="text" name="pincode" id="pincode" maxlength="6" class="form-control num_val">
                                                </div>
                                            </div>

                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Phone Number
                                                        <small>(required)</small>
                                                    </label>
                                                    <input name="phone" onblur="checkPhoneNumber()" id="phone" maxlength="10"  type="text" class="form-control num_val">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Email Address
                                                    </label>
                                                    <input name="customer_email" onblur="checkEmail()" id="customer_email" type="email" class="form-control">
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-sm-4 col-sm-offset-4">
                                            <div class="form-group label-floating is-focused">
                                                <label class="control-label">Billing name</label>
                                                <input type="text" disabled="" id="billing_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <center>
                                                <button type="submit" name="finish" id="customer-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                                    <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Create</button>
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
                                                        $(".addCustomer").addClass('active');
                                                        $(".navbar-brand").append("Customer Details");

                                                        function billingName() {
                                                            var firstName = document.getElementById("firstname").value;
                                                            var lastName = document.getElementById("lastname").value;
                                                            document.getElementById("billing_name").value = firstName + ' ' + lastName;
                                                        }
                                                        function totalPrice() {
                                                            var quantity = document.getElementById("quantity").value;
                                                            var flower_price = document.getElementById("flower_price").value;
                                                            var total = (quantity * flower_price);
                                                            document.getElementById("total_price").value = total;
                                                        }

                                                        function checkPaidAmount() {
                                                            var total_price = document.getElementById("total_price").value;
                                                            var paid_price = document.getElementById("paid_amount").value;
                                                            if (paid_price > total_price) {
                                                                document.getElementById("customer-submit").disabled = true;
                                                                $.notify({
                                                                    icon: "notifications",
                                                                    title: "Alert..!",
                                                                    message: "Paid amount should'nt be greater than Total price"

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

                                                        function checkEmail() {
                                                            var customer_email = document.getElementById("customer_email").value;
                                                            $.ajax({
                                                                type: "POST",
                                                                url: baseurl + "customer/ajax_checkEmail",
                                                                data: {customer_email: customer_email},

                                                                success: function (response) {
                                                                    if ($.trim(response) === "success") {
                                                                        document.getElementById("customer-submit").disabled = true;
                                                                        document.getElementById("customer_email").value = "";
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
                                                                        document.getElementById("phone").value = "";
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
//                                                        function checkBillingName() {
//                                                            var billing_name = document.getElementById("billing_name").value;
//                                                            $.ajax({
//                                                                type: "POST",
//                                                                url: baseurl + "customer/ajax_checkBillingName",
//                                                                data: {billing_name: billing_name},
//
//                                                                success: function (response) {
//                                                                    if ($.trim(response) === "success") {
//                                                                        document.getElementById("customer-submit").disabled = true;
//                                                                        $.notify({
//                                                                            icon: "notifications",
//                                                                            title: "OOPS..!",
//                                                                            message: "Billing name is already taken"
//
//                                                                        }, {
//                                                                            type: 'danger',
//                                                                            timer: 2000,
//                                                                            placement: {
//                                                                                from: 'bottom',
//                                                                                align: 'center'
//                                                                            }
//                                                                        });
//                                                                    } else {
//                                                                        document.getElementById("customer-submit").disabled = false;
//                                                                    }
//                                                                }
//                                                            });
//                                                            return false;
//                                                        }
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