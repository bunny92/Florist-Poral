<?php $this->load->view('header') ?>
<style>
    #old_password-error, #new_password-error{
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
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Update Password
                                </h4>
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form id="password-form" name="password_form" role="form" style="display: block;" method="post">

                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Old Password</label>
                                                <input type="password" name="old_password" id="old_password" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">New Password</label>
                                                <input type="password" name="new_password" id="new_password" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" name="finish" id="password-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                            <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Update
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
    $(".changePassword").addClass('active');
    $(".navbar-brand").append("Change Password");
    $("#password-form").validate({

        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true
            }
        },
        messages: {
            new_password: {
                required: "Required password to change"
            },
            old_password: "Required Old password"
        },
        submitHandler: changePasswordForm
    });
    function changePasswordForm() {
        var data = $("#password-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "login/ajax_updatePassword",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#password-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Updating ...'
                        );
            },
            success: function (response) {
                console.log(response);

                if ($.trim(response) > 0) {
                    console.log("Change password..!");
                    document.getElementById("password-form").reset();
                    $("#password-submit").html("Update");
                    notifications('Success', 'Password changed', 'success');
                    return false;
                }
                if (response = 'mismatch') {
                    $("#password-submit").html("Update");
                    notifications('Oops..!', 'Password may not the same as existing', 'danger');
                    return false;
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