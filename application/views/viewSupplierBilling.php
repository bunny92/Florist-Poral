<?php $this->load->view('header') ?>
<div class="wrapper">
    <?php $this->load->view('navbar') ?>
    <div class="main-panel">
        <?php $this->load->view('topnav') ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="green">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Orders List</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>

                                                <th>#</th>
                                                <th>Supplier</th> 
                                                <th>Address</th>
                                                <th>Order Price</th>
                                                <!--<th>Advance</th>-->
                                                <th>Commission</th>
                                                <th>Created at</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($supplier as $value) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-warning btn-raised btn-round view_model" id="<?php echo $value->record_id ?>">
                                                            Orders
                                                        </a>
                                                        <a href="#" class="btn btn-sm btn-info btn-raised btn-round edit_model" id="<?php echo $value->record_id ?>">
                                                            Edit
                                                        </a>
                                                    </td>
                                                    <td><?= $value->supplier_name ?></td>
                                                    <td><?= $value->supplier_place ?></td>
                                                    <td><?= $value->product_price ?></td>
                                                    <!--<td <?= $value->supplier_advance > 0 ? 'class=danger' : 'class=success' ?>><?= $value->supplier_advance ?></td>-->
                                                    <td <?= $value->commission < 50 ? 'class=danger' : 'class=success' ?>><?= $value->commission ?></td>
                                                    <td><?= date("d-m-Y",strtotime($value->suplier_date)) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--Start Model-->
                        <div class="modal fade" id="edit_orders_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <i class="material-icons">clear</i>
                                        </button>
                                        <h4 class="modal-title text-center text-infp">Edit Order</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="material-datatables">
                                            <form action="<?php echo base_url()?>supplier/ajax_updateSupplierOrderQunatity" method="POST">
                                                <table class="table table-no-bordered" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr class="text-warning">
                                                            <th>Id</th>
                                                            <th>Flower Name</th> 
                                                            <th>Flower Price</th>
                                                            <th>Quantity</th>
                                                            <th>Total Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="edit_order_detail">

                                                    </tbody>
                                                </table>
                                                <center>
                                                 <button type="submit" id="updateGroup-submit" class="btn btn-finish btn-fill btn-danger">Modify</button>
                                             </center>
                                         </form>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     
                     <div class="modal fade" id="orders_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        <i class="material-icons">clear</i>
                                    </button>
                                    <h4 class="modal-title text-center text-infp">Ordered Flowers</h4>
                                </div>
                                <div class="modal-body" id="order_detail">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="pay_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        <i class="material-icons">clear</i>
                                    </button>
                                    <h4 class="modal-title text-center text-warning text-uppercase">Supplier Orders</h4>
                                </div>
                                <div class="modal-body" id="pay_detail">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Model-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<?php $this->load->view('footer') ?>
<script type="text/javascript">

    $(".suppliers").addClass('active');
    $(".viewSupplierBilling").addClass('active');
    $(".navbar-brand").append("View Supplier Billing");
    $(document).ready(function () {

        $('#datatables').DataTable({
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
        $('#datatables tbody').on('click', '.view_model', function () {
            var record_id = $(this).attr("id");
            $.ajax({
                url: baseurl + "supplier/ajax_viewSupplierBillingById",
                method: "post",
                data: {record_id: record_id},
                success: function (data) {
                    $('#order_detail').html(data);
                    $('#orders_model').modal("show");
                }
            });
        });
        
        $('#datatables tbody').on('click', '.edit_model', function () {
            var record_id = $(this).attr("id");
            if ($(".editOrder").length) {
               $(".editOrder").remove();
           }
           $.ajax({
            url: baseurl + "supplier/ajax_viewSupplierOrdersBillingById",
            method: "post",
            data: {record_id: record_id},
            success: function (data) {
                
              var jsonobj = JSON.parse(data);
              console.log(jsonobj);
              $('#edit_orders_model').modal("show");
              
              var htmlText = '';
              var index = 1;
              
              for (var key in jsonobj) {
                for(var jsondata in jsonobj[key]){
                  var order_id = jsonobj[key][jsondata]['id'];
                  var supplier_id =  jsonobj[key][jsondata]['supplier_id'];
                  var flower_id =    jsonobj[key][jsondata]['flower_id'];
                  var flower_name =  jsonobj[key][jsondata]['flower_name'];
                  var flower_price = jsonobj[key][jsondata]['flower_price'];
                  var quantity =     jsonobj[key][jsondata]['quantity'];
                  var total =        jsonobj[key][jsondata]['total_price'];
                  htmlText += '<tr class="editOrder"><td>' + index++ + '</td><td>' + flower_name + '</td><td><input type="text" name="flower_price[]" onblur="Javascript: changeQuantity('+ flower_id +');" value="'+ flower_price+'" id="edit_flower_price_'+flower_id+'"  class="form-control"></td>';
                  htmlText += '<td><input type="hidden" name="record_id" value="'+ record_id +'"><input type="hidden" name="supplier_id" value="'+ supplier_id +'"><input type="hidden" name="order_id[]" value="'+ order_id +'"><input type="text" name="quantity[]" value="'+ quantity+'" id="edit_quantity_'+flower_id+'" onblur="Javascript: changeQuantity('+flower_id+');"  class="form-control"></td>';
                  htmlText += '<td id="totalprice_'+flower_id+'">'+total+'</td></tr>';
                  
              }
              
          }
          
          $('#edit_order_detail').append(htmlText);
      }
  });
       });
    
    
        window.switchModal = function (record_id) {
            $('#orders_model').modal('hide');
            setTimeout(function () {
                $.ajax({
                    url: baseurl + "product/ajax_updatePayment",
                    method: "post",
                    data: {record_id: record_id},
                    success: function (data) {
                        $('#pay_detail').html(data);
                        $('#pay_model').modal("show");
                    }
                });
            }, 500);
            // the setTimeout avoid all problems with scrollbars
        };
    });
    
    function changeQuantity(flowerId) {
   var quantity =  $('#edit_quantity_' + flowerId).val();
   var flower_price =  $('#edit_flower_price_' + flowerId).val();
   var product  = (quantity * flower_price);
  document.getElementById('totalprice_' + flowerId).innerHTML = product;
}
</script>
</html>