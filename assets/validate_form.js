$().ready(function () {
    validates = {
        initMaterialWizard: function () {
            // Code for the Validator
            $("#customer-form").validate({
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
                submitHandler: submitCustomerForm
            });

            function submitCustomerForm() {
                var data = $("#customer-form").serialize();
                $.ajax({
                    type: "POST",
                    url: baseurl + "customer/ajax_addcustomer",
                    data: data,
                    beforeSend: function () {
                        $("#error").fadeOut();
                        $("#customer-submit").html(
                                '<span class="glyphicon glyphicon-transfer"></span> &nbsp; creating ...'
                                );
                    },
                    success: function (response) {
                        if ($.trim(response) === "created") {
                            console.log("Customer Created Success..!");
                            document.getElementById("customer-form").reset();
                            $("#customer-submit").html("Creating ...");
                            $.notify({
                                icon: "notifications",
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

        }
    };
});
