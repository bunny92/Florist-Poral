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
                                <h4 class="card-title">Customers</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Pin code</th>
                                                <th>Created at</th>
                                                <th class="disabled-sorting text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Pin code</th>
                                                <th>Created at</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php foreach ($customers as $value) { ?>
                                                <tr>
                                                    <td><?= $value->first_name ?> <?= $value->last_name ?></td>
                                                    <td><?= $value->customer_phone ?></td>
                                                    <td><?= $value->customer_email ?></td>
                                                    <td><?= $value->customer_address ?></td>
                                                    <td><?= $value->customer_pincode ?></td>
                                                    <td><?= date("d-m-Y",strtotime($value->created_at)) ?></td>
                                                    <td class="text-right">
                                                        <a href="<?= base_url() ?>customer/viewCustomersById/<?= $value->customer_id ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <a href="#" class="btn btn-simple btn-danger btn-icon remove"  id='del_<?= $value->customer_id ?>' data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="material-icons">delete</i></a>
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
        </div>
    </div>
</div>
</body>
<?php $this->load->view('footer') ?>

<script type="text/javascript">
    $(".customer").addClass('active');
    $(".modifyCustomer").addClass('active');
    $(".navbar-brand").append("Customer Details");
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


        var table = $('#datatables').DataTable();

        // Edit record
//        table.on('click', '.edit', function () {
//            $tr = $(this).closest('tr');
//
//            var data = table.row($tr).data();
//            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
//        });

        // Delete a record
        table.on('click', '.remove', function (e) {
            $tr = $(this).closest('tr');
            var id = this.id;
            var row;
            var splitid = id.split("_");
            var deleteid = splitid[1];

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
                    url: baseurl + "customer/ajax_deleteCustomer",
                    data: {customer_id: deleteid}
                }).done(function (result) {
                    console.log(result);
                    if (result == "success") {
                        $.notify({
                            icon: "notifications",
                            title: "Success",
                            message: "Customer Deleted Successfully..!"

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
</script>

</html>