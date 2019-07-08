<?php $this->load->view('header') ?>

<div class="wrapper">
    <?php $this->load->view('navbar') ?>
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Suppliers</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr style="font-size: smaller;">
                                                <th>Name</th>
                                                <th>Father</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Advance</th>
                                                <th>Created at</th>
                                                <th class="disabled-sorting text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($supplier as $value) { ?>
                                                <tr>
                                                    <td><?= $value->supplier_name ?></td>
                                                    <td><?= $value->supplier_father ?></td>
                                                    <td><?= $value->supplier_phone ?></td>
                                                    <td><?= $value->supplier_email ?></td>
                                                    <td><?= $value->supplier_place ?></td>
                                                    <td class="<?= $value->supplier_advance > 0 ? 'text-danger' : 'text-success' ?>"><?= $value->supplier_advance ?></td>
                                                    <td><?= date("d-m-Y", strtotime($value->created_at)) ?></td>
                                                    <td class="text-right">
                                                        <a href="#" class="btn btn-simple btn-warning btn-icon edit"   id='edit_<?= $value->id ?>'  data-toggle="tooltip"  data-placement="top" title="Edit"><i class="material-icons">edit</i></a>
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
                    <!-- end col-md-12 -->
                </div>
                <!-- end row -->
            </div>
            <!--Start Model-->
            <div class="modal fade" id="supplier_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <i class="material-icons">clear</i>
                            </button>
                            <h4 class="modal-title text-center text-warning text-uppercase">Update Supplier Details</h4>
                        </div>
                        <div class="modal-body" id="supplier_detail">

                        </div>
                    </div>
                </div>
            </div>
            <!--End Model-->
        </div>
    </div>
</div>
</body>
<?php $this->load->view('footer') ?>

<script type="text/javascript">
    $(".suppliers").addClass('active');
    $(".viewSuppliers").addClass('active');
    $(".navbar-brand").append("Suppliers Details");
    $(document).ready(function () {
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
        var table = $('#datatables').DataTable();
        // Edit record
        table.on('click', '.edit', function () {
            if ($(".model-data").length) {
                $(".model-data").remove();
            }
            $tr = $(this).closest('tr');
            var id = this.id;
            var splitid = id.split("_");
            var editid = splitid[1];
            var data = table.row($tr).data();
            if (data == undefined) {

                var selected_row = $(this).parents('tr');
                if (selected_row.hasClass('child')) {
                    selected_row = selected_row.prev();
                }
                var rowData = table.row(selected_row).data();
                var supplier_name = rowData[0];
                var supplier_father = rowData[1];
                var supplier_email = rowData[3];
                var supplier_place = rowData[4];
                var supplier_phone = rowData[2];
            } else {
                supplier_name = data[0];
                supplier_father = data[1];
                supplier_email = data[3];
                supplier_place = data[4];
                supplier_phone = data[2];
            }
//            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
            var htmlText = '<div class="container model-data"><form onsubmit="Javascript: updateSupplierForm(' + editid + '); return false" id="updateSupplier-form_' + editid + '" name="updateSupplier_form" role="form" style="display: block;" method="post">' +
                    '<input type ="hidden" name="id" id="customer_' + editid + '" value=' + editid + '>' +
                    '<div class="row">' +
                    '<div class="col-lg-3  col-md-3 col-sm-12">' +
                    '<div class="form-group"><label class="control-label">Supplier Name <small style="color: red;">*</small></label>' +
                    '<input type="text" name="supplier_name" id="supplier_name" value="' + supplier_name + '" class="form-control text_val">' +
                    '<span class="material-input"></span></div> </div>' +
                    '<div class="col-lg-3  col-md-3 col-sm-12">' +
                    '<div class="form-group"><label class="control-label">Supplier Father</label>' +
                    '<input type="text" name="supplier_father" id="supplier_father" value="' + supplier_father + '"  class="form-control text_val">' +
                    '<span class="material-input"></span></div> </div></div>' +
                    '<div class="row">' +
                    '<div class="col-lg-3  col-md-3 col-sm-12">' +
                    '<div class="form-group"><label class="control-label">Supplier Email</label>' +
                    '<input type="text" name="supplier_email" id="supplier_email" value="' + supplier_email + '"  class="form-control">' +
                    '<span class="material-input"></span></div> </div>' +
                    '<div class="col-lg-3  col-md-3 col-sm-12">' +
                    '<div class="form-group"><label class="control-label">Supplier Mobile</label>' +
                    '<input type="text" name="supplier_phone" id="supplier_phone" maxlength="10" value="' + supplier_phone + '"  class="form-control num_val">' +
                    '<span class="material-input"></span></div> </div></div>' +
                    '<div class="col-sm-12 col-lg-6  col-md-6 ">' +
                    '<div class="form-group"><label class="control-label">Supplier Place <small style="color: red;">*</small></label>' +
                    '<input type="text" name="supplier_place" id="supplier_place" value="' + supplier_place + '"  class="form-control">' +
                    '<span class="material-input"></span></div></div>' +
                    '<div class="row">' +
                    '<div class="col-lg-12  col-md-12 col-sm-12">' +
                    '<button type="submit" name="finish" id="updateSupplier-submit_' + editid + '" class="btn btn-md btn-finish btn-fill btn-success btn-wd"><span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Update</button>' +
                    '</div></div></form></div>'
            $('#supplier_detail').append(htmlText);
            $('#supplier_model').modal("show");
        });
        // Delete a record
        table.on('click', '.remove', function (e) {
            $tr = $(this).closest('tr');

            var id = this.id;
            var splitid = id.split("_");
            var deleteid = splitid[1];
            var row;
            var choice = confirm('Do you really want to delete this record?');
            if (choice === true) {
                if ($(this).closest('table').hasClass("collapsed")) {
                    var child = $(this).parents("tr.child");
                    row = $(child).prevAll(".parent");
                } else {
                    row = $(this).parents('tr');
                }

                table.row(row).remove().draw();
                jQuery.ajax({
                    type: "POST",
                    url: baseurl + "supplier/ajax_deleteSupplier",
                    data: {id: deleteid}
                }).done(function (result) {
                    console.log(result);
                    if (result == "success") {
                        $.notify({
                            icon: "notifications",
                            title: "Success",
                            message: "Supplier Deleted Successfully..!"

                        }, {
                            type: 'danger',
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
                            type: 'warning',
                            timer: 2000,
                            placement: {
                                from: 'bottom',
                                align: 'center'
                            }
                        });
                    }
                });
            }
            e.preventDefault();
        });
        $('.card .material-datatables label').addClass('form-group');
    });

    function updateSupplierForm(supplier_id) {

        var data = $("#updateSupplier-form_" + supplier_id).serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "supplier/ajax_updateSupplier",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#updateSupplier-submit_" + supplier_id).html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Updating ...');
            },
            success: function (response) {
                console.log(response);
                if (response = 'updated') {
                    document.getElementById("updateSupplier-form_" + supplier_id).reset();
                    setTimeout(' window.location.href = ""; ', 1000);
                    $('#supplier_model').modal('hide');
                    notifications('Updated', 'Supplier got updated', 'success');
                } else {
                    $("#updateSupplier-submit_" + supplier_id).html('Update');
                    notifications('Opps..!', 'Somthing went wrong', 'warning');
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