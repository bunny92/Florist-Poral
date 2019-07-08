<?php $this->load->view('header') ?>
<style>
    #flower_name-error, #flower_id-error{
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
                    <div class="col-md-4 col-md-offset-1">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Flowers</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Flower Name</th>
                                                <th class="disabled-sorting text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Flower Name</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            <?php
                                            $index = 1;
                                            foreach ($flowers as $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $index++ ?></td>
                                                    <td><?= $value->flower_name ?></td>
                                                    <td class="text-right">
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

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">add_circle_outline</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Flowers</h4>
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form id="flower-form" name="flower_form" role="form" style="display: block;" method="post">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Flower Name</label>
                                                <input type="text" name="flower_name" id="flower_name" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" name="finish" id="flower-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                            <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Add Flower</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">offline_bolt</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Update Flowers</h4>
                                <div class="alert alert-danger" role="alert" id="error1" style="display: none;">Loading..!</div>
                                <form id="updateFlower-form" name="updateFlower_form" role="form" style="display: block;" method="post">

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-12">
                                            <select class="selectpicker" name="flower_id" data-style="btn btn-success btn-round" title="Single Select" data-size="7">
                                                <option disabled selected>Choose flower</option>
                                                <?php
                                                foreach ($flowers as $value) {
                                                    ?>
                                                    <option value="<?= $value->id ?>"><?= $value->flower_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Flower Name</label>
                                                <input type="text" name="flower_name" id="flower_name" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" name="finish" id="updateFlower-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                            <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Update Flower</button>

                                    </center>
                                </form>
                            </div>
                        </div>
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
<script src="<?= base_url() ?>assets/common.js"></script>
<script type="text/javascript">
    $(".customer").addClass('active');
    $(".modifyCustomer").addClass('active');
    $(".navbar-brand").append("Flowers List");
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
        // Delete a record
        table.on('click', '.remove', function (e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            var id = this.id;
            var splitid = id.split("_");
            var deleteid = splitid[1];
            jQuery.ajax({
                type: "POST",
                url: baseurl + "flowers/ajax_deleteFlower",
                data: {flower_id: deleteid}
            }).done(function (result) {
                console.log(result);
                if (result == "success") {
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "You droped a flower"

                    }, {
                        type: 'success',
                        timer: 1000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });

                } 
                if(result == "existing"){
                    $.notify({
                        icon: "notifications",
                        title: "OOPS..!",
                        message: "This Flower is using in orders..!, We can`t remove this flower"

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
            e.preventDefault();
        });


        $('.card .material-datatables label').addClass('form-group');
    });
</script>
</html>