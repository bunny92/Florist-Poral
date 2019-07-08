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
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">contacts</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Message Services</h4>
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form id="message-form" name="message_form" role="form" style="display: block;" method="post">
                                    <div class="row">
                                            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12">
                                                <div class="form-group">
                                                <label class="control-label">Individual Message <small style="color: red;">*</small></label>
                                                    <select class="selectpicker" id="ind_message" name="ind_message" data-style="btn btn-primary btn-round" title="Single Select" data-size="7">
                                                        <option disabled="" value="">Select Suppliers</option>
                                                        <option value="1" <?= $ms->ind_message == 1 ? 'selected' : '' ?>>Enable</option>
                                                        <option value="0" <?= $ms->ind_message == 0 ? 'selected' : '' ?>>Disable</option>
                                                    </select>
                                                </div>
                                            </div>
                                       
                                            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12">
                                                <div class="form-group">
                                                <label class="control-label">Group Message <small style="color: red;">*</small></label>
                                                    <select class="selectpicker" id="group_message" name="group_message" data-style="btn btn-warning btn-round" title="Single Select" data-size="7">
                                                        <option disabled="" value="">Select Suppliers</option>
                                                        <option value="1" <?= $ms->group_message == 1 ? 'selected' : '' ?>>Enable</option>
                                                        <option value="0" <?= $ms->group_message == 0 ? 'selected' : '' ?>>Disable</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <center>
                                        <hr/>
                                        <button type="submit" name="finish" id="message-submit" class="btn btn-finish btn-fill btn-success btn-wd">
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

    $(".Password").addClass('active');
    $(".messageService").addClass('active');
    $(".navbar-brand").append("Message Settings");
  
    $("#message-form").validate({

        rules: {
            ind_message: {
                required: true
            },
            group_message: {
                required: true
            }
        },
        messages: {
            supplier_advance: {
                required: "Please choose action"
            },
            group_message: "Please choose action"
        },
        submitHandler: actionMessageForm
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

    function actionMessageForm() {

        var data = $("#message-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "welcome/ajax_updateActionMessageServices",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#message-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Updating ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if (response > 0) {
                    console.log("Advance updated..!");
                    document.getElementById("message-form").reset();
                    setTimeout(' window.location.href = ""; ', 2000);
                    $("#message-submit").html("Updating ...");
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Service Updating..!"

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
</script>
</html>