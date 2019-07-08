$calendar = $('#fullCalendar');

today = new Date();
y = today.getFullYear();
m = today.getMonth();
d = today.getDate();

$calendar.fullCalendar({
    viewRender: function (view, element) {
        // We make sure that we activate the perfect scrollbar when the view isn't on Month
        if (view.name != 'month') {
            $(element).find('.fc-scroller').perfectScrollbar();
        }
    },
    header: {
        left: 'title',
        right: 'prev,next,today'
    },
    defaultDate: today,
    selectable: true,
    selectHelper: true,

    editable: true,
    eventLimit: true, // allow "more" link when too many events
    dayClick: function (date, jsEvent, view) {
        if ($(".table-data_details").length) {
            if (($(".table-data_details").length > 1)) {
                $(".table-data_details").remove();
            }
        }


        var event_date = date.format();
       
        $.ajax({
            url: baseurl + "welcome/ajax_getDefaultDetails",
            method: "post",
            data: {event_date: event_date},
            success: function (data) {
                var jsonobj = JSON.parse(data);
                var json1 = jsonobj['customer_event'];
                var json2 = jsonobj['supplier_event'];
                var flowers = jsonobj['flowers'];
                if (json1 == null && json2 == null) {
                    $('#customerModal').modal('show');
                    var htmlText = '<div class="col-md-12 table-data_details"><br/><center><b class="text-warning">Customer Default Prices</b></center><br/><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                            '<thead><tr class="text-warning"><td>Id</td><td>Flower</td><td>Rate</td></tr></thead><tbody>';
                    var index = 1;
                    for (var key in flowers) {
                        var flower_name = flowers[key]['flower_name'];
                        var flower_id = flowers[key]['id'];
                        htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td><td>0</td></tr>';
                    }
                    htmlText += '</tbody></table>';
                    $('.table-data').append(htmlText);

                    var htmlText = '<div class="col-md-12 table-data_details"><br/><center><b class="text-warning">Supplier Default Prices</b></center><br/><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                            '<thead><tr class="text-warning"><td>Id</td><td>Flower</td><td>Rate</td></tr></thead><tbody>';
                    var index = 1;
                    for (var key in flowers) {
                        var flower_name = flowers[key]['flower_name'];
                        var flower_id = flowers[key]['id'];
                        htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td><td>0</td></tr>';
                    }
                    htmlText += '</tbody></table>';
                    $('.supp-table-data').append(htmlText);
                } else {
                    $('#customerModal').modal('show');
                    if (json2 == null) {
                        var htmlText = '<div class="col-md-12 table-data_details"><br/><center><b class="text-warning">Customer Default Prices</b></center><br/><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                '<thead><tr class="text-warning"><td>Id</td><td>Flower</td><td>Rate</td></tr></thead><tbody>';

                        var json = jsonobj['customer_event']['flower_price'];
                        var jsonobjk = JSON.parse(json);
                        var flowers = jsonobjk['flowers_details'];
                        var index = 1;
                        for (var key in flowers) {
                            var flower_name = flowers[key]['flower_name'];
                            var flower_price = flowers[key]['flower_price'];
                            var flower_id = flowers[key]['flower_id'];
                            htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td><td>' + flower_price + '</td></tr>';
                        }
                        htmlText += '</tbody></table>';
                        $('.table-data').append(htmlText);

                        var htmlText = '<div class="col-md-12 table-data_details"><br/><center><b class="text-warning">Supplier Default Prices</b></center><br/><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                '<thead><tr class="text-warning"><td>Id</td><td>Flower</td><td>Rate</td></tr></thead><tbody>';
                        var index = 1;
                        for (var key in flowers) {
                            var flower_name = flowers[key]['flower_name'];
                            var flower_id = flowers[key]['id'];
                            htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td><td>0</td></tr>';
                        }
                        htmlText += '</tbody></table>';
                        $('.supp-table-data').append(htmlText);
                    } else if (json1 == null) {
                        var htmlText = '<div class="col-md-12 table-data_details"><br/><center><b class="text-warning">Supplier Default Prices</b></center><br/><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                '<thead><tr class="text-warning"><td>Id</td><td>Flower</td><td>Rate</td></tr></thead><tbody>';

                        var json = jsonobj['supplier_event']['flower_price'];
                        var jsonobjk = JSON.parse(json);
                        var flowers = jsonobjk['flowers_details'];
                        var index = 1;
                        for (var key in flowers) {
                            var flower_name = flowers[key]['flower_name'];
                            var flower_price = flowers[key]['flower_price'];
                            var flower_id = flowers[key]['flower_id'];
                            htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td><td>' + flower_price + '</td></tr>';
                        }
                        htmlText += '</tbody></table>';
                        $('.supp-table-data').append(htmlText);

                        var htmlText = '<div class="col-md-12 table-data_details"><br/><center><b class="text-warning">Customer Default Prices</b></center><br/><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                '<thead><tr class="text-warning"><td>Id</td><td>Flower</td><td>Rate</td></tr></thead><tbody>';
                        var index = 1;
                        for (var key in flowers) {
                            var flower_name = flowers[key]['flower_name'];
                            var flower_id = flowers[key]['id'];
                            htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td><td>0</td></tr>';
                        }
                        htmlText += '</tbody></table>';
                        $('.table-data').append(htmlText);

                    } else {
                        var htmlText = '<div class="col-md-12 table-data_details"><br/><center><b class="text-warning">Customer Default Prices</b></center><br/><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                '<thead><tr class="text-warning"><td>Id</td><td>Flower</td><td>Rate</td></tr></thead><tbody>';

                        var json = jsonobj['customer_event']['flower_price'];
                        var jsonobjk = JSON.parse(json);
                        var flowers = jsonobjk['flowers_details'];
                        var index = 1;
                        for (var key in flowers) {
                            var flower_name = flowers[key]['flower_name'];
                            var flower_price = flowers[key]['flower_price'];
                            var flower_id = flowers[key]['flower_id'];
                            htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td><td>' + flower_price + '</td></tr>';
                        }
                        htmlText += '</tbody></table>';
                        $('.table-data').append(htmlText);


                        var htmlText = '<div class="col-md-12 table-data_details"><br/><center><b class="text-warning">Supplier Default Prices</b></center><br/><br/><table id="datatable" class="table table-striped table-no-bordered" cellspacing="0" width="100%" style="width:100%">' +
                                '<thead><tr class="text-warning"><td>Id</td><td>Flower</td><td>Rate</td></tr></thead><tbody>';

                        var json = jsonobj['supplier_event']['flower_price'];
                        var jsonobjk = JSON.parse(json);
                        var flowers = jsonobjk['flowers_details'];
                        var index = 1;
                        for (var key in flowers) {
                            var flower_name = flowers[key]['flower_name'];
                            var flower_price = flowers[key]['flower_price'];
                            var flower_id = flowers[key]['flower_id'];
                            htmlText += '<tr><td>' + index++ + '</td><td>' + flower_name + '</td><td>' + flower_price + '</td></tr>';
                        }
                        htmlText += '</tbody></table>';
                        $('.supp-table-data').append(htmlText);
                    }
                }
            }
        });
    },
});