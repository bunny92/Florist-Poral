<?php $this->load->view('header') ?>
<style>
    #group_name-error,#group_id-error{
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
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Customers 
                                    <br><small class="category text-warning text-right" > (Atleast Check 2 or more customers to create group)</small>
                                </h4>
                                <div class="toolbar">
                                </div>
                                <div class="table-responsive">

                                    <table id="datatables" class="table table-striped" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Mobile Number</th>
                                                <th>Address</th>
                                                <th>Pin code</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($customers as $value) { ?>
                                                <tr>
                                                    <td><?= $value->first_name ?> <?= $value->last_name ?></td>
                                                    <td><?= $value->customer_phone ?></td>
                                                    <td><?= $value->customer_address ?></td>
                                                    <td><?= $value->customer_pincode ?></td>
                                                    <td>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onclick="customerCheckBox()" name="customer_id" value="<?= $value->customer_id ?>">
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end content-->
                        </div>
                    </div>
                    <div class="col-md-5">

                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">add_circle_outline</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Create Group</h4>
                                <form id="group-form" name="group_form" role="form" style="display: block;" method="post">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">supervised_user_circle</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Group Name
                                                <small>(required)</small>
                                            </label>
                                            <input name="group_name" id="group_name" type="text" class="form-control text-val">
                                        </div>
                                    </div>
                                    <input type="hidden" id="customer_ids" name="customer_id">

                                    <center>
                                        <button type="submit" name="group-submit" id="group-submit" class="btn btn-round btn-raised btn-success">
                                            <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Create Group</button>
                                    </center>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">offline_bolt</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Update Group</h4>
                                <div class="alert alert-danger" role="alert" id="error1" style="display: none;">Loading..!</div>
                                <form id="updateGroup-form" name="updateGroup_form" role="form" style="display: block;" method="post">
                                    <input type="hidden" id="updateCustomer_ids" name="customer_id">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-12">
                                            <select class="selectpicker" onchange="getCreatedCustomer(this)" id="group_id" name="group_id" data-style="btn btn-info btn-round" title="Single Select" data-size="7">
                                                <option disabled selected>Choose Group name</option>
                                                <?php
                                                foreach ($group as $value) {
                                                    ?>
                                                    <option value="<?= $value->id ?>"><?= $value->group_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="customerData">
                                    </div>
                                    <center>
                                        <button type="submit" name="finish" id="updateGroup-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                            <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Update Group</button>

                                    </center>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Created Customer</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table id="datatables1" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Group Name</th>
                                                <th>Customers</th>
                                                <th>Created at</th>
                                                <th class="disabled-sorting text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        </tfoot>
                                        <tbody>

                                            <?php
                                            $index = 1;
                                            foreach ($groupCustomer as $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $index++ ?></td>
                                                    <td><?= $value->group_name ?></td>
                                                    <?php if (empty($value->customer_id)) { ?>
                                                        <td>0</td>
                                                    <?php } else { ?>
                                                        <td> <a href="<?= base_url() ?>customer/getGroupCustomerById/<?= $value->id ?>" ><?= empty($value->customer_id) ? 0 : $value->count_customers ?></a></td>
                                                    <?php } ?>
                                                    <td><?= date("d-m-Y", strtotime($value->created_at)) ?></td>
                                                    <td class="text-right">
                                                        <!--<a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>-->
                                                        <a href="#" class="btn btn-simple btn-danger btn-icon remove"  id='del_<?= $value->id ?>' data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="material-icons">delete</i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
                                                $(".customer").addClass('active');
                                                $(".groupingCustomer").addClass('active');
                                                $(".navbar-brand").append("Grouping Customer");
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
                                                    $('#datatables1').DataTable({
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
                                                    var table = $('#datatables1').DataTable();
                                                    // Delete a record
                                                    table.on('click', '.remove', function (e) {
                                                        $tr = $(this).closest('tr');
                                                        table.row($tr).remove().draw();
                                                        var id = this.id;
                                                        var splitid = id.split("_");
                                                        var deleteid = splitid[1];
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: baseurl + "customer/ajax_deleteGroup",
                                                            data: {id: deleteid}
                                                        }).done(function (result) {
                                                            console.log(result);
                                                            if (result == "success") {
                                                                $.notify({
                                                                    icon: "notifications",
                                                                    title: "Success",
                                                                    message: "Customer Group Deleted Successfully..!"

                                                                }, {
                                                                    type: 'success',
                                                                    timer: 1000,
                                                                    placement: {
                                                                        from: 'top',
                                                                        align: 'center'
                                                                    }
                                                                });

                                                            } else {
                                                                $.notify({
                                                                    icon: "notifications",
                                                                    title: "OOPS..!",
                                                                    message: "Somthing went wrong..!"

                                                                }, {
                                                                    type: 'danger',
                                                                    timer: 2000,
                                                                    placement: {
                                                                        from: 'bottom',
                                                                        align: 'center'
                                                                    }
                                                                });
                                                            }
                                                        });
                                                        e.preventDefault();
                                                    });
                                                    $('.card .material-datatables label').addClass('form-group');
                                                });
                                                document.getElementById("group-submit").disabled = true;
                                                document.getElementById("updateGroup-submit").disabled = true;
                                                function customerCheckBox() {
                                                    var selected = new Array();
                                                    $("input:checkbox[name = customer_id]:checked").each(function () {
                                                        selected.push($(this).val());
                                                    });
                                                    document.getElementById("customer_ids").value = selected;
                                                    document.getElementById("updateCustomer_ids").value = selected;
                                                    if (selected.length > 1) {
                                                        document.getElementById("customer_ids").value = selected;
                                                        document.getElementById("updateCustomer_ids").value = selected;

                                                        document.getElementById("group-submit").disabled = false;
                                                        document.getElementById("updateGroup-submit").disabled = false;
                                                    } else {
                                                        document.getElementById("group-submit").disabled = true;
                                                        document.getElementById("updateGroup-submit").disabled = false;

                                                    }

                                                    if (selected.length < 1) {
                                                        document.getElementById("updateGroup-submit").disabled = true;
                                                    }
                                                }
                                                $("#group_name").bind('keypress', function (event) {
                                                    var regex = new RegExp("^[a-zA-Z ]+$");
                                                    var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                                                    if (!regex.test(str)) {
                                                        event.preventDefault();
                                                        return false;
                                                    }
                                                });

                                                function getCreatedCustomer(sel) {
                                                    var group_id = $(sel).val();
                                                    if ($(".table-data_details").length) {
                                                        $(".table-data_details").remove();
                                                    }
                                                    $.ajax({
                                                        url: baseurl + "customer/ajax_getGroupCustomerById",
                                                        method: "post",
                                                        data: {group_id: group_id},
                                                        success: function (data) {
                                                            var jsonobj = JSON.parse(data);
                                                            if (jsonobj == false) {
                                                                $.notify({
                                                                    icon: "notifications",
                                                                    title: "OOPS..!",
                                                                    message: "No Customers are added.."

                                                                }, {
                                                                    type: 'warning',
                                                                    timer: 2000,
                                                                    placement: {
                                                                        from: 'bottom',
                                                                        align: 'center'
                                                                    }
                                                                });
                                                            } else {
                                                                var htmlText = '<div class="col-md-10 col-md-offset-1 table-data_details"><h4 class="text-danger text-center">Created Customers</h4><table class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                                                        '<thead><tr><td>#</td><td>Name</td><td>Mobile</td><td>Pincode</td></tr></thead><tbody>';
                                                                var index = 1;
                                                                for (var key in jsonobj) {
                                                                    var customer_name = jsonobj[key]['first_name'];
                                                                    var phone = jsonobj[key]['customer_phone'];
                                                                    var pincode = jsonobj[key]['customer_pincode'];
                                                                    htmlText += '<tr><td>' + index++ + '</td><td>' + customer_name + '</td><td>' + phone + '</td><td>' + pincode + '</td></tr>';
                                                                }
                                                                htmlText += '</tbody></table>';
                                                            }
                                                            $('.customerData').append(htmlText);
                                                        }
                                                    });

                                                }



</script>

</html>