<?php $this->load->view('header') ?>
<div class="wrapper">
    <?php $this->load->view('navbar') ?>
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="header text-center">
                    <h3 class="title">Date wise Flower details</h3>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="card card-calendar">
                            <div class="card-content" class="ps-child">
                                <div id="fullCalendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="customerModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>-->
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">
                <div class="col-md-6">
                    <div class="table-data"></div>
                </div>
                <div class="col-md-6">
                    <div class="supp-table-data"></div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-warning btn-md" data-dismiss="modal">Close</button>
                </center>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer') ?>

<script src="<?= base_url() ?>assets/common.js"></script>
<script src="<?= base_url() ?>assets/calenderView.js"></script>
<script>
    $(".rate").addClass('active');
    $(".addedPrices").addClass('active');
    $(".navbar-brand").append("Date wise details");

</script>
</body>
</html>