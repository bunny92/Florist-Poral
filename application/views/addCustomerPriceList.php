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
                    <div class="col-md-6 col-md-offset-3">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Flowers price for <b class="text-warning">Supplier</b><br/>
                                    <small><b>Note:<b/> Add price for every flower in the list then submit</small></h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    <hr/>
                                </div>
                                <div class="material-datatables">
                                    <form onsubmit="Javascript: addPayListForm(); return false"  id="price-form" name="price_form" role="form" style="display: block;" method="post">
                                        <table class=" table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Sno.</th>
                                                    <th>Flower Name</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach ($flowers as $value) {
                                                    ?>
                                                    <tr class="table_details">
                                                        <td><?= $value->id ?></td>
                                                        <td><?= $value->flower_name ?></td>
                                                        <td class="text-left">
                                                            <input type="hidden" name="flower_name[]" value='<?= $value->flower_name ?>'>
                                                            <input type="hidden" name="flower_id[]" value='<?= $value->id ?>'>
                                                            <input type="number" value="0" class="form-control flower_price text-warning" name="flower_price[]" id="flower_price_<?= $value->id ?>">
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <center>
                                            <hr/>
                                            <button type="submit" name="finish" id="price-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                                <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Submit
                                            </button>
                                        </center>
                                    </form>
                                </div>
                            </div>
                            <!-- end content-->
                        </div>
                        <!--  end card  -->
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

                                        $(".rate").addClass('active');
                                        $(".caddExpenses").addClass('active');
                                        $(".navbar-brand").append("Add Price to Flowers for Customer");
                                        $(document).ready(function () {
                                            $('.flower_price').bind('keypress', function (event) {
                                                var regex = new RegExp("^[0-9]+$");
                                                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                                                if (!regex.test(key)) {
                                                    event.preventDefault();
                                                    return false;
                                                }
                                            });
                                            $('.card .material-datatables label').addClass('form-group');
                                        });



                                        function addPayListForm() {
                                            var data = $("#price-form").serialize();
                                            $.ajax({
                                                type: "POST",
                                                url: baseurl + "customer/ajax_addPriceList",
                                                data: data,
                                                beforeSend: function () {
                                                    $("#error").fadeOut();
                                                    $("#price-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Adding ...');
                                                },
                                                success: function (response) {
                                                    console.log(response);
                                                    if ($.trim(response) === "success") {
                                                        console.log("Price got added..!");
                                                        setTimeout(' window.location.href = ""; ', 1000);
                                                        $("#price-submit").html('Submit');
                                                        notifications('Success', 'Price got added to flowers', 'success');
                                                    } else if ($.trim(response) === "empty") {
                                                        $("#price-submit").html("Submit");
                                                        notifications('Opps..!', 'Please enter price for every flower!', 'danger');
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

</script>
</html>