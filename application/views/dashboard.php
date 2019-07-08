<?php $this->load->view('header') ?>
<?php $this->load->view('navbar') ?>
<div class="wrapper">

    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <h3>Users Report</h3>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="orange">
                                <i class="material-icons">weekend</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Active Customers</p>
                                <h3 class="card-title"><?= $customer->customer_count ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <a href="#pablo">Still adding more..!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="rose">
                                <i class="material-icons">equalizer</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Flowers</p>
                                <h3 class="card-title"><?= $flower ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">local_offer</i> We have the best orders
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">supervised_user_circle</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Suppliers</p>
                                <h3 class="card-title"><?= $supplier->supplier_count ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                     <a href="#pablo">Still adding more..!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3>Financial report</h3>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">credit_card</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Total amount</p>
                                <h3 class="card-title"><i class="fa fa-inr"></i> <?= $stock->total_price ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Just Updated
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="blue">
                                <i class="fa fa-inr"></i>
                            </div>
                            <div class="card-content">
                                <p class="category">Total paid</p>
                                <h3 class="card-title"><i class="fa fa-inr"></i> <?= $stock->paid_amount ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Just Updated
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="rose">
                                <i class="fa fa-money"></i>
                            </div>
                            <div class="card-content">
                                <p class="category">Due amount</p>
                                <h3 class="card-title"><i class="fa fa-inr"></i> <?= $stock->balance_amount ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Just Updated
                                </div>
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
    $(".dashboard").addClass('active');
    $(".navbar-brand").append("Dashboard");
</script>

</html>