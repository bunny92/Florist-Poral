$(document).ready(function () {
    /* handling form validation */
    $("#login-form").validate({
        rules: {
            password: {
                required: true
            },
            username: {
                required: true
            }
        },
        messages: {
            password: {
                required: "Please enter your password"
            },
            username: "Please enter your username"
        },
        submitHandler: submitForm
    });

    function submitForm() {
        var data = $("#login-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "login/ajax_login",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#login_button").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...'
                        );
            },
            success: function (response) {
                if ($.trim(response) === "success") {
                    console.log("Login Success..!");
                    $("#login-submit").html("Signing In ...");
                    setTimeout(' window.location.href = "dashboard"; ', 1000);
                } else {
                    $("#error").html(response).show();
                }
            }
        });
        return false;
    }

    $("#customer-form").validate({
        rules: {
            firstname: {
                required: true,
                minlength: 3
            },
            lastname: {
                required: true
            },
            phone: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            firstname: {
                required: "First Name required"
            },
            lastname: "Last Name required",
            phone: "Phone Number required",
        },
        submitHandler: submitCustomerForm
    });

    $("#update_customer-form").validate({
        rules: {
            firstname: {
                required: true,
                minlength: 3
            },
            lastname: {
                required: true,
                minlength: 3
            },
            phone: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            firstname: {
                required: "First Name required"
            },
            lastname: "Last Name required",
            phone: "Phone Number required",
        },
        submitHandler: updateCustomerForm
    });

    function submitCustomerForm() {
        var data = $("#customer-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "customer/ajax_addcustomer",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                document.getElementById("customer-submit").disabled = true;
                $("#customer-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Creating ...'
                        );
            },
            success: function (response) {
                if ($.trim(response) === "created") {
                    console.log("Customer Created Success..!");
                    document.getElementById("customer-form").reset();
                    document.getElementById("customer-submit").disabled = false;
                    $("#customer-submit").html("Create");
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Customer created successfully..!"

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

    function updateCustomerForm() {
        var data = $("#update_customer-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "customer/ajax_updateCustomer",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#customer-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; updating ...'
                        );
            },
            success: function (response) {
                if ($.trim(response) === "updated") {
                    console.log("Customer updated Success..!");
                    document.getElementById("update_customer-form").reset();
                    $("#update_customer-submit").html("Updating ...");
                    setTimeout(' window.location.href = "' + baseurl + 'customer/viewCustomers"; ', 1000);
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Customer Updated successfully..!"

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

    $("#flower-form").validate({
        rules: {
            flower_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            flower_name: {
                required: "Flower Name required"
            }
        },
        submitHandler: FlowerForm
    });

    function FlowerForm() {
        var data = $("#flower-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "flowers/ajax_addFlower",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#flower-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; adding ...'
                        );
            },
            success: function (response) {
                if ($.trim(response) === "success") {
                    console.log("Flower added Success..!");
                    document.getElementById("flower-form").reset();
                    $("#flower-submit").html("Creating ...");
                    setTimeout(' window.location.href = ""; ', 1000);
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Flower got added..!"

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

    $("#updateFlower-form").validate({
        rules: {
            flower_name: {
                required: true,
                minlength: 3
            },
            flower_id: {
                required: true
            }
        },
        messages: {
            flower_name: {
                required: "Flower Name required"
            },
            flower_id: "Choose Flower to update"
        },
        submitHandler: updateFlowerForm
    });

    function updateFlowerForm() {
        var data = $("#updateFlower-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "flowers/ajax_updateFlower",
            data: data,
            beforeSend: function () {
                $("#error1").fadeOut();
                $("#updateFlower-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; updating ...'
                        );
            },
            success: function (response) {
                if ($.trim(response) === "success") {
                    console.log("Flower updated Success..!");
                    document.getElementById("updateFlower-form").reset();
                    document.getElementById("updateFlower-submit").disabled = true;
                    $("#updateFlower-submit").html("Updating ...");
                    setTimeout(' window.location.href = ""; ', 1000);
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Flower got updated..!"

                    }, {
                        type: 'success',
                        timer: 2000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                } else {
                    $("#error1").html(response).show();
                }
            }
        });
        return false;
    }

    $("#group-form").validate({
        rules: {
            group_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            group_name: {
                required: "Group name required"
            }
        },
        submitHandler: groupForm
    });

    function groupForm() {
        var data = $("#group-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "customer/ajax_addGroupCustomer",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#group-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; adding ...'
                        );
            },
            success: function (response) {
                if ($.trim(response) === "success") {
                    console.log("Customer Group added Success..!");
                    document.getElementById("group-form").reset();
                    document.getElementById("group-submit").disabled = true;
                    $("#group-submit").html("Creating ...");
                    setTimeout(' window.location.href = ""; ', 2000);
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Customer group got created..!"

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


    $("#updateGroup-form").validate({
        rules: {
            group_id: {
                required: true
            }
        },
        messages: {
            group_id: {
                required: "Choose Group Name"
            }
        },
        submitHandler: updateGroupForm
    });

    function updateGroupForm() {
        var data = $("#updateGroup-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "customer/ajax_updateCustomerInGroup",
            data: data,
            beforeSend: function () {
                $("#error1").fadeOut();
                $("#flower-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Updating ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if ($.trim(response) === "success") {
                    console.log("Customer added Success..!");
                    document.getElementById("updateGroup-form").reset();
                    document.getElementById("updateGroup-submit").disabled = true;
                    $("#updateGroup-submit").html("Updating ...");
                    setTimeout(' window.location.href = ""; ', 1000);
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Customer got added..!"

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




    $("#order-form").validate({
        rules: {
            luggage_expenses: {
                required: true
            },
            stock_out_date: {
                required: true
            },
            paid_amount: {
                required: true
            }
        },
        messages: {
            luggage_expenses: {
                required: "Required luggage expenses"
            },
            stock_out_date: "Date is required",
            paid_amount: "Minimum amount should be paid"
        },
        submitHandler: addOrderForm
    });

    function addOrderForm() {
        var data = $("#order-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "product/ajax_addOrder",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                document.getElementById("order-submit").disabled = true;
                $("#order-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Creating ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if ($.trim(response) > 0) {
                    console.log("Order added Success..!");
                    $("#order-submit").html("Creating ...");
                     $("#order-submit").html("Creating ...");
                    swal({
                        title: "Success",
                        text: "Created Order Successfully..!",
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success",
                        type: "success",
                    }).then(function () {
                        location.reload();
                    }
                    );
                } else {
                    $("#error").html(response).show();
                }
            }
        });
        return false;
    }

    $("#updateSupplierGroup-form").validate({
        rules: {
            group_id: {
                required: true
            }
        },
        messages: {
            group_id: {
                required: "Choose Group Name"
            }
        },
        submitHandler: updateSupplierGroupForm
    });

    function updateSupplierGroupForm() {
        var data = $("#updateSupplierGroup-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "supplier/ajax_updateSupplierInGroup",
            data: data,
            beforeSend: function () {
                $("#error1").fadeOut();
                document.getElementById("flower-submit").disabled = true;
                $("#flower-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; Updating ...'
                        );
            },
            success: function (response) {
                console.log(response);
                if ($.trim(response) === "success") {
                    console.log("Supplier added Success..!");
                    document.getElementById("updateSupplierGroup-form").reset();
                    document.getElementById("updateGroup-submit").disabled = true;
                    $("#updateGroup-submit").html("Updating ...");
                    setTimeout(' window.location.href = ""; ', 1000);
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Supplier got added..!"

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

    $("#suppliergroup-form").validate({
        rules: {
            group_name: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            group_name: {
                required: "Group name required"
            }
        },
        submitHandler: suppliergroupForm
    });

    function suppliergroupForm() {
        var data = $("#suppliergroup-form").serialize();
        $.ajax({
            type: "POST",
            url: baseurl + "supplier/ajax_addGroupSupplier",
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                 document.getElementById("group-submit").disabled = true;
                $("#group-submit").html(
                        '<span class="glyphicon glyphicon-transfer"></span> &nbsp; adding ...'
                        );
            },
            success: function (response) {
                if ($.trim(response) === "success") {
                    console.log("Supplier Group added Success..!");
                    document.getElementById("suppliergroup-form").reset();
                    $("#group-submit").html("Creating ...");
                    setTimeout(' window.location.href = ""; ', 2000);
                    $.notify({
                        icon: "notifications",
                        title: "Success",
                        message: "Supplier group got created..!"

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
});
