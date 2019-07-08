<?php $this->load->view('header.php') ?>
<!-- This is needed when you send requests via Ajax -->
<style>
    #username-error, #password-error{
        color:red;
    }
</style>
<script type="text/javascript">
    var baseurl = '<?php echo base_url(); ?>/';
</script>
<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img class="hidden-xs" style="margin-top: -6px;" src="assets/img/vflorist.png" width="15%">
                <center>
                    <img class="visible-xs" style="margin-top: -6px;" src="assets/img/vflorist.png" width="35%">
                </center>
            </a>
        </div>
    </div>
</nav>
<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" filter-color="black" data-image="assets/img/login.png">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                        <form id="login-form" name="login_form" role="form" style="display: block;" method="post">

                            <div class="card card-login card-hidden">
                                <div class="card-header text-center" data-background-color="green">
                                    <h4 class="card-title">Administrator Login</h4>
                                </div>
                                <p class="category text-center">
                                    It's Admins Login
                                </p>
                                <div class="card-content">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">face</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Username</label>
                                            <input type="text" id="username" name="username" class="form-control">
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Password</label>
                                            <input type="password" id="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="footer text-center">
                                    <button type="submit" name="login-submit" id="login-submit" class="btn btn-success">
                                        <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Let's go</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?php $this->load->view('footer.php') ?>
<script src="assets/common.js"></script>