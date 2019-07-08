<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>V-Florist Invoice</title>
        <link href="<?= base_url() ?>assets/css/invoice.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
                <img width="15%" src='<?= base_url() ?>assets/img/vflorist.png' alt='Logo'>
            </div>
            <h1>INVOICE</h1>
        </header>
        <main>
            <?php if ($invoice_type == 'customer') { ?>
                <div>
                    <div id="project" class="clearfix" style="width: 50%">
                        <div><h4><span class="text-primary">Bill: </span> Customer Bill</h4></div>
                        <div><h4><span class="text-primary">Customer Name: </span>  <?= $customer->first_name ?>&nbsp;<?= $customer->last_name ?></h4></div>
                        <div><h4><span class="text-primary">Place: </span> <?= (isset($customer->customer_address) && !empty($customer->customer_address)) ? $customer->customer_address : 'No address'; ?></h4></div>
                    </div>
                    <div id="company">
                        <div><h4><span class="text-primary">Invoice: </span>Order_#_vflorist_<?= $customer->id ?></h4></div>
                        <div><h4><span class="text-primary">Date: </span><?= date('Y-m-d'); ?></h4></div>
                    </div>
                    <br/><br/>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="service">DATE</th>
                            <th class="desc">ITEM</th>
                            <th class="desc">QUANTITY</th>
                            <th class="desc">RATE</th>
                            <th class="desc">TOTAL</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($orders as $flowers) {
                            foreach ($flowers as $flower) {
                                ?>
                                <tr>
                                    <td><?= date("Y-m-d",strtotime($flower->created_at)) ?></td>
                                    <td><?= $flower->flower_name ?></td>
                                    <td><?= $flower->quantity ?></td>
                                    <td><?= $flower->flower_price ?></td>
                                    <td><?= $flower->total_price ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td class="thick-line" style="border: none;"></td>
                            <td class="thick-line" style="border: none;"></td>
                            <td class="thick-line" style="border: none;"></td>
                            <td class="thick-line text-right text-primary"><strong>Luggage Expenses</strong></td>
                            <td class="thick-line text-right"><?= $customer->luggage_expenses ?></td>
                        </tr>
                        <tr>
                            <td class="thick-line" style="border: none;"></td>
                            <td class="thick-line" style="border: none;"></td>
                            <td class="thick-line" style="border: none;"></td>
                            <td class="thick-line text-right text-primary"><strong>Subtotal</strong></td>
                            <td class="thick-line text-right"><?= $customer->product_price ?></td>
                        </tr>
                        <tr>
                            <td class="no-line" style="border: none;"></td>
                            <td class="no-line" style="border: none;"></td>
                            <td class="no-line" style="border: none;"></td>
                            <td class="no-line text-right text-primary"><strong>Paid amount</strong></td>
                            <td class="no-line text-right"><?= $customer->paid_amount ?></td>
                        </tr>
                        <tr>
                            <td class="no-line" style="border: none;"></td>
                            <td class="no-line" style="border: none;"></td>
                            <td class="no-line" style="border: none;"></td>
                            <td class="no-line text-right text-danger"><strong>Balance</strong></td>
                            <td class="no-line text-right"><?= $customer->balance_amount ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php } elseif ($invoice_type == 'supplier') { ?>
                <div>
                    <div id="project" class="clearfix" style="width: 50%">
                        <div><h4><span class="text-primary">Bill: </span> Supplier Bill</h4></div>
                        <div><h4><span class="text-primary">Supplier Name: </span>  <?= $supplier->supplier_name ?> </h4></div>
                        <div><h4><span class="text-primary">Place: </span> <?= (isset($supplier->supplier_place) && !empty($customer->supplier_place)) ? $customer->supplier_place : 'No address'; ?></h4></div>
                    </div>
                    <div id="company">
                        <div><h4><span class="text-primary">Invoice: </span>Order_#_vflorist_<?= $supplier->id ?></h4></div>
                        <div><h4><span class="text-primary">Date: </span><?= date('Y-m-d'); ?></h4></div>
                    </div>
                    <br/><br/>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="service">DATE</th>
                            <th class="desc">ITEM</th>
                            <th class="desc">QUANTITY</th>
                            <th class="desc">RATE</th>
                            <th class="desc">TOTAL</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sum = 0;
                        $comm = 0;
                        foreach ($orders as $flowers) {
                            foreach ($flowers as $flower) {
                                $sum += $flower->total_price;
                                 $comm += $flower->commission;
                                ?>
                                <tr>
                                    <td><?= date("Y-m-d",strtotime($flower->created_at)) ?></td>
                                    <td><?= $flower->flower_name ?></td>
                                    <td><?= $flower->quantity ?></td>
                                    <td><?= $flower->flower_price ?></td>
                                    <td><?= $flower->total_price ?></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                         
                         <tr><td></td><td></td><td></td><td class="text-primary">Total Price</td><td><b><?= $sum ?></b></td></tr>
                         <tr><td></td><td></td><td></td><td class="text-primary">Commission</td><td><b><?= $supplier->commission  ?></b></td></tr>
                         <tr><td></td><td></td><td></td><td class="text-success">Final Price</td><td><b><?= ($sum - $supplier->commission) ?></b></td></tr>
                         <tr><td></td><td></td><td></td><td class="text-info">Supplier Advance</td><td><b><?= $supplier->supplier_advance ?></b></td></tr>
                    </tbody>
                </table>
            <?php } elseif ($invoice_type == 'date_wise') { ?>
                <?php if ($type == 'customer') { ?>
                    <div>
                        <div id="project" class="clearfix" style="width: 50%">
                            <div><h4><span class="text-primary">Bill: </span> Customer Bill</h4></div>
                            <div><h4><span class="text-primary">Customer Name: </span>  <?= $details['customer_details']->first_name ?>&nbsp;<?= $details['customer_details']->last_name ?></h4></div>
                            <div><h4><span class="text-primary">Place: </span> <?= (isset($details['customer_details']->customer_address) && !empty($details['customer_details']->customer_address)) ? $details['customer_details']->customer_address : 'No address'; ?></h4></div>
                        </div>
                        <div id="company">
                            <div><h4><span class="text-primary">Invoice: </span>Order_#_vflorist_<?= $details['customer_details']->customer_id ?></h4></div>
                            <div><h4><span class="text-primary">Date: </span><?= date('Y-m-d'); ?></h4></div>
                        </div>
                        <br/><br/>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th class="service">DATE</th>
                                <th class="desc">ITEM</th>
                                <th class="desc">QUANTITY</th>
                                <th class="desc">RATE</th>
                                <th class="desc">TOTAL</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum_lag = 0;
                            $prod_price = 0;
                            $paid_amt = 0;
                            $bal_amt = 0;
                            foreach ($details['order_details'] as $flowers) {
                                foreach ($flowers as $flower) {
                                    ?>
                                    <tr>
                                        <td><?= date("Y-m-d",strtotime($flower->created_at)) ?></td>
                                        <td><?= $flower->flower_name ?></td>
                                        <td><?= $flower->quantity ?></td>
                                        <td><?= $flower->flower_price ?></td>
                                        <td><?= $flower->total_price ?></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            foreach ($details['customer_order'] as $value) {
                                $sum_lag += $value->luggage_expenses;
                                $prod_price += $value->product_price;
                                $paid_amt += $value->paid_amount;
                                // $bal_amt = $value->customer_balance;
                                $balance = ( $prod_price < $paid_amt ) ? 0 : ( $prod_price - $paid_amt );
                                // $prev_bal = ($value->customer_balance - $balance) < 0 ? 0 :($value->customer_balance - $balance) ; 
                            }
                            ?>
                            <tr>
                                <td class="thick-line" style="border: none;"></td>
                                <td class="thick-line" style="border: none;"></td>
                                <td class="thick-line" style="border: none;"></td>
                                <td class="thick-line text-right text-primary"><strong>Luggage Expenses</strong></td>
                                <td class="thick-line text-right"><?= $sum_lag ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="thick-line" style="border: none;"></td>
                                <td class="thick-line" style="border: none;"></td>
                                <td class="thick-line" style="border: none;"></td>
                                <td class="thick-line text-right text-primary"><strong>Subtotal</strong></td>
                                <td class="thick-line text-right"><?= ( $prod_price +  $sum_lag ) ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="no-line" style="border: none;"></td>
                                <td class="no-line" style="border: none;"></td>
                                <td class="no-line" style="border: none;"></td>
                                <td class="no-line text-right text-primary"><strong>Paid amount</strong></td>
                                <td class="no-line text-right"><?= $paid_amt ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="no-line" style="border: none;"></td>
                                <td class="no-line" style="border: none;"></td>
                                <td class="no-line" style="border: none;"></td>
                                <td class="no-line text-right text-danger"><strong>Balance</strong></td>
                                <td class="no-line text-right"><?= $balance ?></td>
                                <td></td>
                            </tr>
                            <!--<tr>-->
                            <!--    <td class="no-line" style="border: none;"></td>-->
                            <!--    <td class="no-line" style="border: none;"></td>-->
                            <!--    <td class="no-line" style="border: none;"></td>-->
                            <!--    <td class="no-line text-right text-warning">Previous Balance</td>-->
                            <!--    <td class="no-line text-right"><?= $prev_bal ?></td>-->
                            <!--    <td></td>-->
                            <!--</tr>-->
                        </tbody>
                    </table>
                <?php } elseif ($type == 'supplier') { ?>

                    <div>
                        <div id="project" class="clearfix" style="width: 50%">
                            <div><h4><span class="text-primary">Bill: </span> Supplier Bill</h4></div>
                            <div><h4><span class="text-primary">Supplier Name: <?= $details['supplier_details']->supplier_name ?></h4></div>
                            <div><h4><span class="text-primary">Place: </span> <?= (isset($details['supplier_details']->supplier_place) && !empty($details['supplier_details']->supplier_place)) ? $details['supplier_details']->supplier_place : 'No address'; ?></h4></div>
                        </div>
                        <div id="company">
                            <div><h4><span class="text-primary">Invoice: </span>Order_#_vflorist_<?= $details['supplier_details']->id ?></h4></div>
                            <div><h4><span class="text-primary">Date: </span><?= date('Y-m-d'); ?></h4></div>
                        </div>
                        <br/><br/>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th class="service">DATE</th>
                                <th class="desc">ITEM</th>
                                <th class="desc">QUANTITY</th>
                                <th class="desc">RATE</th>
                                <th class="desc">TOTAL</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum = 0;
                            $comm = 0;
                            foreach ($details['order_details'] as $flowers) {
                                foreach ($flowers as $flower) {
                                    $sum += $flower->total_price;
                                    ?>
                                    <tr>
                                        <td><?= date("Y-m-d",strtotime($flower->created_at)) ?></td>
                                        <td><?= $flower->flower_name ?></td>
                                        <td><?= $flower->quantity ?></td>
                                        <td><?= $flower->flower_price ?></td>
                                        <td><?= $flower->total_price ?></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                            }
                            
                            foreach ($details['supplier_order'] as $commi) {
                             $comm += $commi->commission;
                            }
                            ?>
                            
                            <tr><td></td><td></td><td></td><td class="text-primary">Total Price</td><td><b><?= $sum ?></b></td></tr>
                            <tr><td></td><td></td><td></td><td class="text-success">Commission</td><td><b><?= $comm ?></b></td></tr>
                            <tr><td></td><td></td><td></td><td class="text-success">Final Price</td><td><b><?= ($sum - $comm) ?></b></td></tr>
                            <tr><td></td><td></td><td></td><td class="text-primary">Supplier Advance </td><td><b><?= $details['supplier_details']->supplier_advance ?></b></td></tr>
                        </tbody>
                    </table>
                <?php } ?>
            <?php } ?>
        </main>
        <footer>
            Invoice was created on a computer and is valid without the signature and seal.
        </footer>
    </body>
</html>