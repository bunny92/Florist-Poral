<?php $this->load->view('header') ?>
<div class="wrapper">
    <?php $this->load->view('navbar') ?>
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="col-md-10 col-md-offset-1 col-sm-12">
                    <div class="row">

                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12">
                            <div class="row flower_details"></div>
                            <div class="empty-text" style="padding-top: 15em;">
                                <div class="header text-center">
                                    <h3 class="title">Please add prices for flowers here <a href="<?= base_url() ?>supplier/addPriceList" class="btn btn-md btn-warning">Add</a></h3>
                                    <p class="category">Right now..!We dint find any flowers list</p>
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
<script>
    $(".rate").addClass('active');
    $(".viewExpenses").addClass('active');
    $(".navbar-brand").append("View Supplier Price List");

    $(document).ready(function () {
        $('.datatables').DataTable({
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
    });
    $.ajax({
        url: baseurl + "supplier/priceEventList",
        method: "post",
        data: {"data": "check"},
        success: function (data) {
            var jsonobj = JSON.parse(data);

            var htmlText = '';
            if (data == '[]') {
                $('.empty-text').show();
                return false;
            } else {
                for (var key in jsonobj) {
                    var startDate = new Date(jsonobj[key]['start_date']);
                    var format = "AM";
                    var hour = startDate.getHours();
                    var min = startDate.getMinutes();
                    if (hour > 11) {
                        format = "PM";
                    }
                    if (hour > 12) {
                        hour = hour - 12;
                    }
                    if (hour == 0) {
                        hour = 12;
                    }
                    if (min < 10) {
                        min = "0" + min;
                    }
                    var startedDate = (startDate.getMonth() + 1 + "-" + startDate.getDate() + "-" + startDate.getFullYear() + " " + hour + ":" + min + " " + format);

                    var endDate = new Date(jsonobj[key]['end_date']);
                    var format = "AM";
                    var hour = endDate.getHours();
                    var min = endDate.getMinutes();
                    if (hour > 11) {
                        format = "PM";
                    }
                    if (hour > 12) {
                        hour = hour - 12;
                    }
                    if (hour == 0) {
                        hour = 12;
                    }
                    if (min < 10) {
                        min = "0" + min;
                    }
                    var endedDates = endDate.getMonth() + 1 + "-" + endDate.getDate() + "-" + endDate.getFullYear() + " " + hour + ":" + min + " " + format;
                    if (isNaN(endDate.getDate())) {
                        var endedDate = 'Till date';
                    } else {
                        endedDate = endedDates;
                    }

                    var flowerPrice = jsonobj[key]['flower_price'];
                    var jsonobjs = JSON.parse(flowerPrice);
                    var htmlText = '';
                    var index = 1;
                    for (var keys in jsonobjs) {
                        var jsonobjss = jsonobjs['flowers_details'];
                        htmlText += '<div class="col-md-6 table-data"><div class="card">';
                        htmlText += '<div class="card-content table-responsive"><span class="label label-success">Start Date</span> &nbsp; <b>' + startedDate + '</b> <br/><br/> <span class="label label-danger">End Date</span> &nbsp; <b>' + endedDate + '</b><br/><br/><table class="datatables" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                '<thead><tr class="text-warning"><td>#</td><td>Flower name</td><td>Price</td></tr></thead><tbody>';
                        for (var keyss in jsonobjss) {
                            htmlText += '<tr><td>' + index++ + '</td><td>' + jsonobjss[keyss]['flower_name'] + '</td><td class="text-primary"><b>' + jsonobjss[keyss]['flower_price'] + '</b></td></tr>';
                        }
                        htmlText += '</tbody></table></div></div></div></div>';

                    }

                    $('.flower_details').append(htmlText);
                }
                $('.empty-text').hide();
            }

        }
    });

</script>