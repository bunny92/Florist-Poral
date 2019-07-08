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
                                <h4 class="card-title">Update Rate to flowers</h4>
                                <div class="alert alert-danger" role="alert" id="error" style="display: none;">Loading..!</div>
                                <form onsubmit="Javascript: updatePayListForm(); return false" id="advance-form" name="advance_form" role="form" style="display: block;" method="post">
                                   
                                    <div class="row">
                                        <div class="table-data">

                                        </div>
                                    </div>
                                    <center>
                                        <br/>
                                        <button type="submit" name="finish" id="advance-submit" class="btn btn-finish btn-fill btn-success btn-wd">
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

    $(".rate").addClass('active');
    $(".ceditExpenses").addClass('active');
    $(".navbar-brand").append("Modify Customer Price to Flowers");

    $.ajax({
        url: baseurl + "customer/ajax_recentPriceEventList",
        method: "post",
        data: {"data": "check"},
        success: function (data) {
            if (data) {
                var jsonobj = JSON.parse(data);
                var jsonobjs = jsonobj['flower_price'];
                var event_id = jsonobj['event_id'];
                var htmlText = '';
                var index = 1;
                var jsonobjss = JSON.parse(jsonobjs);
                var jsonobjsss = jsonobjss['flowers_details'];
                htmlText += '<div class="table-data_details"><table class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                        '<thead><tr class="text-warning"><td>#</td><td>Flower name</td><td>Price</td></tr></thead><tbody>';
                for (var keyss in jsonobjsss) {
                    htmlText += '<tr><td>' + index++ + '</td><td>' + jsonobjsss[keyss]['flower_name'] + '</td><td><input type="hidden" name="event_id" value="' + event_id + '"><input type="hidden" name="flower_id[]" value="' + jsonobjsss[keyss]['flower_id'] + '"><input type="hidden" name="flower_name[]" value="' + jsonobjsss[keyss]['flower_name'] + '"><input type="text" class="form-control" name="flower_price[]" value="' + jsonobjsss[keyss]['flower_price'] + '"></td></tr>';
                }
                htmlText += '</tbody></table></div>';
                $('.table-data').append(htmlText);
            } else {
                notifications('Opps..!', 'No Record Found, Please be patient', 'danger');
                return false;
            }
        }
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

    function updatePayListForm() {
        var data = $("#advance-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "customer/ajax_updatePriceList",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#advance-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Updating ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if ($.trim(response) === "success") {
                    console.log("Price got updated..!");
                    $("#advance-submit").html('Submit');
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Price got updated to customer flowers"

                    }, {
                        type: 'success',
                        timer: 1000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                } else if ($.trim(response) === "empty") {
                    $("#advance-submit").html("Submit");
                    $.notify({
                        icon: "notifications",
                        title: "Opps..!",
                        message: "Please enter price for every flower!"

                    }, {
                        type: 'danger',
                        timer: 1000,
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