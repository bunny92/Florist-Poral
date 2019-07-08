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
                <form id="invoice-form" name="invoice_form" role="form" style="display: block;" method="post" action="<?= base_url() ?>product/printInvoiceByDate">
                    <div class="row" style="padding-top:90px;">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-12">
                                    <select class="selectpicker" name="customer_id" id="customer_id" data-style="btn btn-success btn-round" title="Single Select" data-size="7">
                                        <option disabled selected value="0">Choose Customer</option>
                                        <?php
                                        foreach ($customers as $value) {
                                            ?>
                                            <option value="<?= $value->customer_id ?>"><?= $value->first_name . ' ' . $value->last_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                            <div class="row">
                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">From Date</label>
                                        <input type="text" name="from_date" id="from_date" value="<?= date('Y-m-d', strtotime("-1 days")); ?>"  class="form-control datepicker text-info">
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6  col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">To Date</label>
                                        <input type="text" name="to_date" id="to_date" value="<?= date('Y-m-d'); ?>"  class="form-control datepicker  text-primary">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <br/>
                                <input type="hidden" name="user_type" value="customer">
                                <button id="invoice" name="invoice" class="btn btn-round btn-md btn-warning" type="submit"><i class="fa fa-download"></i><span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span>&nbsp; Invoice</button> &nbsp;
                                <button id="invoice_print" name="invoice_print" class="btn btn-round btn-md btn-info" type="submit"><i class="fa fa-print"></i><span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span>&nbsp; Print Invoice</button> &nbsp;
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<?php $this->load->view('footer') ?>
<?php if ($this->session->flashdata('empty')) {?>
     <script>
     $.notify({message: 'No orders on this date'},{type: 'danger'});
     </script>
<?php } ?>
<script type="text/javascript">

    $(".Billing").addClass('active');
    $(".ViewBilling").addClass('active');
    $(".navbar-brand").append("Check Billing for Customer");
    $("#invoice").click(function () {
        var customer_id = document.getElementById("customer_id").value;
        var from_date = document.getElementById("from_date").value;
        var to_date = document.getElementById("to_date").value;
        if (customer_id == 0) {
            notifications('oops..!', 'Please select customer', 'danger');
            return false;
        }
        if (to_date < from_date) {
            notifications('oops..!', 'Choose from date less than to date', 'danger');
            return false;
        }
    });
    $("#invoice_print").click(function () {
        var customer_id = document.getElementById("customer_id").value;
        var from_date = document.getElementById("from_date").value;
        var to_date = document.getElementById("to_date").value;
        if (customer_id == 0) {
            notifications('oops..!', 'Please select customer', 'danger');
            return false;
        }
        if (to_date < from_date) {
            notifications('oops..!', 'Choose from date less than to date', 'danger');
            return false;
        }
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
</script>
</html>