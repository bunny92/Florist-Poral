  <div class="card-content">
                                <h4 class="card-title">Add Stock to Customer</h4>
                                <div class="alert alert-danger" role="alert" id="error1" style="display: none;">Loading..!</div>
                                <form id="order-form" name="order_form" role="form" style="display: block;" method="post">
                                    <div class="row">
                                        <div class="col-lg-6  col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Luggage Expenses</label>
                                                <input type="text" name="luggage_expenses" onblur="luggage()" id="luggage_expenses" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6  col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Stock Out Date</label>
                                                <input type="text" name="stock_out_date" id="stock_out_date"  class="form-control datepicker">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Final Price</label>
                                                <input type="text" name="final_price" readonly="" id="stock_final_price" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" name="finish" id="order-submit" class="btn btn-finish btn-fill btn-success btn-wd">
                                            <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span> Submit
                                        </button>
                                    </center>
                                </form>
                            </div>

<script>
    
    $("#order-form").validate({
        rules: {
            luggage_expenses: {
                required: true
            },
            stock_out_date: {
                required: true
            }
        },
        messages: {
            luggage_expenses: {
                required: "add atleaset expenses for luggage"
            },
            stock_out_date: "Date is required"
        },
        submitHandler: addOrderForm
    });

    function addOrderForm() {
        var data = $("#order-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "customer/ajax_addOrder",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#order-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Creating ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if ($.trim(response) === "success") {
                    console.log("Order added Success..!");
                    document.getElementById("addStock-form").reset();
                    $("#order-submit").html("Creating ...");
                    setTimeout(' window.location.href = ""; ', 1000);
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Order got added..!"

                    }, {
                        type: 'success',
                        timer: 2000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                } else if ($.trim(response) === "failed") {
                    $("#error").html(response).show();
                } else {
                    $.notify({
                        icon: "notifications",
                        title: "Duplicates",
                        message: response

                    }, {
                        type: 'danger',
                        timer: 2000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                }
            }
        });
        return false;
    }
    </script>