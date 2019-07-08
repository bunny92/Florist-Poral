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
                                <h4 class="card-title">Suppliers 
                                    <br><small class="category text-warning text-right" > (Atleast Check 2 or more suppliers to create or update group)</small>
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
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($supplier as $value) { ?>
                                                <tr>
                                                    <td><?= $value->supplier_name ?></td>
                                                    <td><?= $value->supplier_phone ?></td>
                                                    <td><?= $value->supplier_place ?></td>
                                                    <td>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" onclick="supplierCheckBox()" name="supplier_id" value="<?= $value->id ?>">
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
                                <form id="suppliergroup-form" name="group_form" role="form" style="display: block;" method="post">
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
                                    <input type="hidden" id="supplier_ids" name="supplier_id">

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
                                <form id="updateSupplierGroup-form" name="updateGroup_form" role="form" style="display: block;" method="post">
                                    <input type="hidden" id="updateSupplier_ids" name="supplier_id">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-12">
                                            <select class="selectpicker" onchange="getCreatedSupplier(this)" name="group_id" data-style="btn btn-info btn-round" title="Single Select" data-size="7">
                                                <option disabled selected>Choose Group name</option>
                                                <?php
                                                foreach ($group as $value) {
                                                    ?>
                                                    <option value="<?= $value->id ?>"><?= $value->group_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="supplierrData">
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
                                <h4 class="card-title">Created Suppliers</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table id="datatables1" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Group Name</th>
                                                <th>Supplier</th>
                                                <th>Created at</th>
                                                <th class="disabled-sorting text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        </tfoot>
                                        <tbody>

                                            <?php
                                            $index = 1;
                                            foreach ($groupSupplier as $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $index++ ?></td>
                                                    <td><?= $value->group_name ?></td>
                                                    <?php if (empty($value->supplier_id)) { ?>
                                                        <td>0</td>
                                                    <?php } else { ?>
                                                        <td> <a href="<?= base_url() ?>supplier/getGroupSupplierById/<?= $value->id ?>" ><?= empty($value->supplier_id) ? 0 : $value->count_supplier ?></a></td>
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
                                                $(".suppliers").addClass('active');
                                                $(".groupingSupplier").addClass('active');
                                                $(".navbar-brand").append("Grouping Suppliers");
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
                                                            url: baseurl + "supplier/ajax_deleteGroup",
                                                            data: {id: deleteid}
                                                        }).done(function (result) {
                                                            console.log(result);
                                                            if (result == "success") {
                                                                $.notify({
                                                                    icon: "notifications",
                                                                    title: "Success",
                                                                    message: "Supplier Group Deleted Successfully..!"

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
                                                function supplierCheckBox() {
                                                    var selected = new Array();
                                                    $("input:checkbox[name = supplier_id]:checked").each(function () {
                                                        selected.push($(this).val());
                                                    });
                                                    document.getElementById("supplier_ids").value = selected;
                                                    document.getElementById("updateSupplier_ids").value = selected;
                                                    if (selected.length > 1) {
                                                        document.getElementById("group-submit").disabled = false;
                                                        document.getElementById("updateGroup-submit").disabled = false;

                                                        document.getElementById("supplier_ids").value = selected;
                                                        document.getElementById("updateSupplier_ids").value = selected;
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

                                                function getCreatedSupplier(sel) {
                                                    var group_id = $(sel).val();
                                                    if ($(".table-data_details").length) {
                                                        $(".table-data_details").remove();
                                                    }
                                                    $.ajax({
                                                        url: baseurl + "supplier/ajax_getGroupSupplierById",
                                                        method: "post",
                                                        data: {group_id: group_id},
                                                        success: function (data) {
                                                            var jsonobj = JSON.parse(data);
                                                            if (jsonobj == false) {
                                                                $.notify({
                                                                    icon: "notifications",
                                                                    title: "OOPS..!",
                                                                    message: "No Suppliers are added.."

                                                                }, {
                                                                    type: 'warning',
                                                                    timer: 2000,
                                                                    placement: {
                                                                        from: 'bottom',
                                                                        align: 'center'
                                                                    }
                                                                });
                                                            } else {
                                                                var htmlText = '<div class="col-md-10 col-md-offset-1 table-data_details"><h4 class="text-danger text-center">Created Suppliers</h4><table class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                                                        '<thead><tr><td>#</td><td>Name</td><td>Mobile</td><td>Email</td></tr></thead><tbody>';
                                                                var index = 1;
                                                                for (var key in jsonobj) {
                                                                    var customer_name = jsonobj[key]['supplier_name'];
                                                                    var phone = jsonobj[key]['supplier_phone'];
                                                                    var pincode = jsonobj[key]['supplier_email'];
                                                                    htmlText += '<tr><td>' + index++ + '</td><td>' + customer_name + '</td><td>' + phone + '</td><td>' + pincode + '</td></tr>';
                                                                }
                                                                htmlText += '</tbody></table>';
                                                            }
                                                            $('.supplierrData').append(htmlText);
                                                        }
                                                    });

                                                }




</script>

</html>