<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('rat');
        $this->load->model('crud_model');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $json_data['customer'] = $this->crud_model->getCustomers();
            $data = $this->crud_model->getCustomerFlowers();
            if (isset($data)) {
                $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
                $json_data['flowers'] = json_encode($array1);
            } else {
                $json_data = NULL;
            }
            $this->load->view('addProductToCustomer', $json_data);
        } else {
            echo "404 Error..!";
        }
    }

    public function viewProduct() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['orders'] = $this->crud_model->getOrderCustomer();
            $this->load->view('viewProduct', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function addProductToGroup() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $json_data['group'] = $this->crud_model->getCreatedGroup();
            $data = $this->crud_model->getCustomerFlowers();
            if (isset($data)) {
                $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
                $json_data['flowers'] = json_encode($array1);
            } else {
                $json_data = NULL;
            }
            $this->load->view('addProductToGroup', $json_data);
        } else {
            echo "404 Error..!";
        }
    }

    public function addProductToSupplierGroup() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $json_data['group'] = $this->crud_model->getSupplierCreatedGroup();
            $data = $this->crud_model->getDefaultGroupFlowers();
            if (isset($data)) {
                $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
                $json_data['flowers'] = json_encode($array1);
            } else {
                $json_data = NULL;
            }
            $this->load->view('addProductToSupplierGroup', $json_data);
        } else {
            echo "404 Error..!";
        }
    }

    public function ajax_addOrder() {
        $customer_id = $this->input->post('customer_id');
        $final_price = $this->input->post('final_price');
        $paid_amount = $this->input->post('paid_amount');
        $balance_amount = $this->input->post('balance_amount');
        $flower_id = $this->input->post('flower_id');
        $customer_email = $this->input->post('customer_email');
        foreach ($flower_id as $key => $fname) {
            $order_data[] = array(
                'flower_id' => $_POST['flower_id'][$key],
                'flower_price' => $_POST['flower_price'][$key],
                'quantity' => $_POST['quantity'][$key],
                'total_price' => $_POST['total_price'][$key],
                'created_at' => $this->input->post('created_date')
            );
        }
        $expenses = array(
            'luggage_expenses' => $this->input->post('luggage_expenses'),
            'stock_out_date' => $this->input->post('stock_out_date'),
            'balance_amount' => $balance_amount,
            'product_price' => $final_price + $this->input->post('luggage_expenses'),
            'paid_amount' => $this->input->post('paid_amount'),
            'paid_date' => $this->input->post('created_date')
        );
        $record_id = $this->crud_model->insertOrder($order_data, $customer_id, $expenses);
        $this->rat->rat_log(json_encode(array($order_data, $expenses)),$customer_id);
        if ($record_id > 0) {
//            $this->sendInvoiceEmailByGet($customer_email, $record_id);
            echo $record_id;
        } else {
            echo 'failed';
        }
    }

    public function ajax_addOrderToGroup() {

        $flower_id = $this->input->post('flower_id');
        $flower_price = $this->input->post('flower_price');
        $customer_id = $this->input->post('customer_id');
        $quantity = $this->input->post('quantity');
        $laguage_expenses = $this->input->post('laguage_expenses');
        $created_at = $this->input->post('created_at');
        $orderArray = array();

        $i = 0;
        $sum = 0;
        foreach ($flower_id as $key => $value) {
            if ($quantity[$key] == null) {
                echo 'empty';
                exit;
            } else {
                $sum += $flower_price[$key] * $quantity[$key];
                $orderArray['orders'][$i]['flower_id'] = $flower_id[$key];
                $orderArray['orders'][$i]['flower_price'] = $flower_price[$key];
                $orderArray['orders'][$i]['quantity'] = $quantity[$key];
                $i++;
            }
        }
        $response = $this->crud_model->insertGroupOrder($orderArray, $customer_id, $sum,$laguage_expenses,$created_at);
        echo $response;
    }

    public function ajax_addOrderToSupplierGroup() {

        $flower_id = $this->input->post('flower_id');
        $flower_price = $this->input->post('flower_price');
        $supplier_id = $this->input->post('supplier_id');
        $quantity = $this->input->post('quantity');
        $commission = $this->input->post('commission');
        $created_at = $this->input->post('created_at');

        $orderArray = array();
        $i = 0;
        $sum = 0;
        foreach ($flower_id as $key => $value) {
            if (!isset($quantity[$key]) || empty($quantity[$key])) {
                echo 'empty';
                exit;
            } else {
                $sum += $flower_price[$key] * $quantity[$key];
                $orderArray['orders'][$i]['flower_id'] = $flower_id[$key];
                $orderArray['orders'][$i]['flower_price'] = $flower_price[$key];
                $orderArray['orders'][$i]['quantity'] = $quantity[$key];
                $i++;
            }
        }
        $response = $this->crud_model->insertSupplierGroupOrder($orderArray, $supplier_id, $sum, $commission,$created_at);
        echo $response;
    }
    public function ajax_viewOrdersdataById(){
       $record_id = $this->input->post('record_id');
       $response = $this->crud_model->viewOrdersById($record_id);
    //    echo json_encode($response);
    }
    
    public function ajax_viewOrdersById() {
        $record_id = $this->input->post('record_id');
        $response = $this->crud_model->viewOrdersById($record_id);
        $orders = $this->crud_model->viewCustomerOrders($record_id);
        $output = '';
        $sum = 0;
        $output .= ' 
        <a class="btn btn-sm btn-info pull-right" href=' . base_url() . '/product/printInvoice/' . $record_id . '><i class="fa fa-download"></i>&nbsp; Invoice</a> 
        <a class="btn btn-sm btn-warning pull-right" href=' . base_url() . 'product/autoPrintInvoice/' . $record_id . '><i class="fa fa-print"></i>&nbsp; Print Invoice</a>
        <div class="material-datatables">
                                    <table class="table table-no-bordered" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Flower Name</th> 
                                                <th>Flower Price</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
        foreach ($response as $flowers) {
            foreach ($flowers as $flower) {
                $sum += $flower->total_price;
                $output .= '<tr>
                             <td>' . $flower->flower_name . '</td>
                             <td>' . $flower->flower_price . '</td>
                             <td>' . $flower->quantity . '</td>
                             <td>' . $flower->total_price . '</td>
                            </tr>';
            }
        }
        $output .= '<tr><td></td><td></td><td class="text-primary">Luggage Expenses</td><td><b>' . $orders->luggage_expenses . '</b></td></tr>';
        $output .= '<tr><td style="border: none;"></td><td style="border: none;"></td><td class="text-warining">Total Price</td><td><b>' . $orders->product_price . '</b></td></tr>';
        $output .= '<tr><td style="border: none;"></td><td style="border: none;" ></td><td class="text-info">Paid amount <small>(Included Previous Balance )</small></td><td><b>' . $orders->paid_amount . '</b></td></tr>';
        $output .= '<tr><td style="border: none;"></td><td style="border: none;"></td><td class="text-success">Remain Balance</td><td><b>' . $orders->balance_amount . '</b></td></tr>';
        if ($orders->balance_amount > 0) {
            $output .= '<tr><td style="border: none;"></td><td style="border: none;"></td><td></td><td><a href="Javascript: switchModal(' . $record_id . ');" class ="btn btn-sm btn-danger">Pay</a></td></tr>';
        }
        $output .= "</tbody></table></div>";
        echo $output;
    }
    
    public function ajax_editOrdersById() {
        $record_id = $this->input->post('record_id');
        $response = $this->crud_model->viewOrdersById($record_id);
        $orders = $this->crud_model->viewCustomerOrders($record_id);
        $output = '';
        $sum = 0;
        $output .= ' 
         <div class="material-datatables">
                                    <table class="table table-no-bordered" id="table_del" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Flower Name</th> 
                                                <th>Flower Price</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                         $output .= '<form action="'.base_url(). 'product/updateOrderQunatity()">';
        foreach ($response as $flowers) {
            foreach ($flowers as $flower) {
                $sum += $flower->total_price;
                $output .= '<tr>
                             <td>' . $flower->flower_name . '</td>
                             <td><input type="hidden" value="'. $record_id .'" name="record_id"><input type="text" name="flower_price[]" id="price_'.$flower->flower_id.'" class="form-control" value="' . $flower->flower_price . '"></td>
                             <td><input type="text" name="qunatity[]"  id="qunatity_'.$flower->flower_id.'" onblur="Javascript: changeQuantity('.$flower->flower_id.');" class="form-control" value="' . $flower->quantity . '" ></td>
                             <td id="totalprice_'.$flower->flower_id.'">' . $flower->total_price . '</td>
                            </tr>';
            }
        }
        // $output .= '<tr><td style="border: none;"></td><td style="border: none;"></td><td class="text-warining">Total Price</td><td id="total_price"><b>' . $orders->product_price . '</b></td></tr>';
        $output .= '<tr><td style="border: none;"></td><td style="border: none;"></td><td></td><td><buttom type="submit" class ="btn btn-sm btn-success">Edit</button></td></tr>';
        $output .= '</form>';
        $output .= "</tbody></table></div>";
        echo $output;
    }
    
    public function ajax_updateOrderQunatity() {
        $flower_price = $this->input->post('flower_price');
        $quantity = $this->input->post('quantity');
        $customer_id = $this->input->post('customer_id');
        $order_id = $this->input->post('order_id');
        $record_id = $this->input->post('record_id');
        $orderArray = array();

        $i = 0;
        $sum = 0;
        foreach ($flower_price as $key => $value) {
            if ($quantity[$key] == null || $flower_price[$key] == null) {
                echo 'empty';
                exit;
            } else {
                $sum += $flower_price[$key] * $quantity[$key];
                $orderArray['orders'][$i]['flower_price'] = $flower_price[$key];
                $orderArray['orders'][$i]['quantity'] = $quantity[$key];
                $orderArray['orders'][$i]['order_id'] = $order_id[$key];
                $i++;
            }
        }
        $response = $this->crud_model->updateOrderQunatity($orderArray, $customer_id, $sum,$record_id);
        redirect('/product/viewProduct', 'refresh');
        }

    public function ajax_updatePayment() {
        $record_id = $this->input->post('record_id');
        $orders = $this->crud_model->viewCustomerOrders($record_id);
        $output = '';
        $output .= '<div class="material-datatables"><table class="table table-no-bordered" cellspacing="0" width="100%" style="width:100%"> <tbody>';
        $output .= '<tr><td style="border: none;"></td><td style="border: none;"></td><td style="border: none;" class="text-warining">Total Price</td><td style="border: none;"><b>' . $orders->product_price . '</b></td></tr>';
        $output .= '<tr><td style="border: none;"></td><td style="border: none;" ></td><td class="text-info">Paid amount</td><td><b>' . $orders->paid_amount . '</b></td></tr>';
        $output .= '<tr><td style="border: none;"></td><td style="border: none;"></td><td class="text-success">Balance amount</td><td><b>' . $orders->balance_amount . '</b></td></tr>';
        $output .= '</tbody></table></div>';
        $output .= ' <form onsubmit="javascript: updatePaymentForm(); return false" id="pay-form" name="pay_form" role="form" style="display: block;" method="post">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Balance Payment</label>
                                            <input type="text" id="balance_payment" onblur="Javascript: checkPaidAmount()" name="balance_payment" class="form-control">
                                            <input type="hidden" disabled id="balance_amount" name="balance_amount" value="' . $orders->balance_amount . '">
                                            <input type="hidden" readonly id="product_price" name="product_price" value="' . $orders->product_price . '">
                                            <input type="hidden" readonly id="paid_amount" name="paid_amount" value="' . $orders->paid_amount . '">
                                            <input type="hidden" name="record_id" value="' . $record_id . '">
                                        <span class="material-input"></span></div>
                                        <center>
                                        <button type="submit" name="pay-submit" id="pay-submit" class="btn btn-round btn-raised btn-success">
                                            <span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span>Pay</button>
                                        </center>
                                    </form>';
        echo $output;
    }

    public function ajax_updateOrderPayment() {
        $record_id = $this->input->post('record_id');
        $balance_payment = $this->input->post('balance_payment');
        $product_price = $this->input->post('product_price');
        $paid_amount = $this->input->post('paid_amount');
        if (!empty($balance_payment) && isset($balance_payment)) {
            $response = $this->crud_model->updatePayment($record_id, $balance_payment, $product_price, $paid_amount);
            echo $response;
        } else {
            echo 'required';
        }
    }

    public function viewCustomerBillingReport() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $result['customers'] = $this->crud_model->getCustomers();
            $this->load->view('viewCustomerBillingByDate', $result);
        } else {
            echo "404 Error..!";
        }
    }

    public function viewSupplierBillingReport() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $result['supplier'] = $this->crud_model->getSupplier();
            $this->load->view('viewSupplierBillingByDate', $result);
        } else {
            echo "404 Error..!";
        }
    }

    public function printInvoice($record_id) {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['customer'] = $this->crud_model->getOrderCustomerById($record_id);
            $data['orders'] = $this->crud_model->viewOrdersById($record_id);
            $data['invoice_type'] = 'customer';
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('invoice', $data, TRUE);
            $mpdf->WriteHTML($html);
            $mpdf->Output('invoice_' . $record_id . '.pdf', 'D');
        } else {
            echo "404 Error..!";
        }
    }

    public function printInvoiceByDate() {

        $fromDate = $this->input->post('from_date');
        $toDate = $this->input->post('to_date');
        $userType = $this->input->post('user_type');
        if ($userType == 'customer') {
            $userId = $this->input->post('customer_id');
        } elseif ($userType == 'supplier') {
            $userId = $this->input->post('supplier_id');
        }
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['invoice_type'] = 'date_wise';
            if ($userType == 'customer') {
                $data['details'] = $this->crud_model->viewCustomerBillingReport($fromDate, $toDate, $userId);
                $data['type'] = 'customer';
                $order = $data['details']['customer_order'];
                if (empty($order)) {
                    $this->session->set_flashdata('empty', 'There is no orders');
                   redirect('product/viewCustomerBillingReport');
                   die;
                }
            } elseif ($userType == 'supplier') {
                $data['details'] = $this->crud_model->viewSupplierBillingReport($fromDate, $toDate, $userId);
                $data['type'] = 'supplier';
                $order = $data['details']['supplier_order'];
                // echo json_encode($data);
                // die;
                if (empty($order)) {
                    $this->session->set_flashdata('empty', 'There is no orders');
                   redirect('product/viewSupplierBillingReport');
                   die;
                }
            }
            
            
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('invoice', $data, TRUE);
            $mpdf->WriteHTML($html);
            if (isset($_POST['invoice'])) {
                $mpdf->Output('invoice_' . $userId . '.pdf', 'D');
            } else if (isset($_POST['invoice_print'])) {
                $mpdf->SetJS('this.print();');
                $mpdf->Output('invoice_' . $userId . '.pdf', 'I');
            }
        } else {
            echo "404 Error..!";
        }
    }

    public function viewInvoice() {
        $data['customer'] = $this->crud_model->getOrderCustomerById($record_id);
        $data['orders'] = $this->crud_model->viewOrdersById($record_id);
        $this->load->view('invoice', $data);
    }

    public function autoPrintInvoice($record_id) {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {

            $data['customer'] = $this->crud_model->getOrderCustomerById($record_id);
            $data['orders'] = $this->crud_model->viewOrdersById($record_id);
            $data['invoice_type'] = 'customer';
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('invoice', $data, TRUE);
            $mpdf->SetJS('this.print();');
            $mpdf->WriteHTML($html);
            $mpdf->Output('invoice_' . $record_id . '.pdf', 'I');
        } else {
            echo "404 Error..!";
        }
    }

    public function sendInvoiceEmail() {
        $mailTo = $this->input->post('customer_email');
        $record_id = $this->input->post('record_id');
        $fromMail = "sales@vflorist.com";
        $fromName = "V-Florist";
        $data['customer'] = $this->crud_model->getOrderCustomerById($record_id);
        $data['orders'] = $this->crud_model->viewOrdersById($record_id);
        $data['invoice_type'] = 'customer';
//        $html = $this->load->view('invoice', $data);
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('invoice', $data, TRUE);

        $mpdf->WriteHTML(utf8_encode($html));
        $content = chunk_split(base64_encode($mpdf->Output('', 'S')));
        $filename = "invoice.pdf";
        $subject = "Invoice from V-Florist";
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($fromMail, $fromName);
        $this->email->to($mailTo);
        $this->email->subject($subject);
        $this->email->attach($content, 'attachment', $filename, 'application/pdf');
        $result = $this->email->send();
        echo $result == true ? 'success' : 'failed';
    }

    public function sendInvoiceEmailByGet($mailTo, $record_id) {
        $fromMail = "sales@vflorist.com";
        $fromName = "V-Florist";
        $data['customer'] = $this->crud_model->getOrderCustomerById($record_id);
        $data['orders'] = $this->crud_model->viewOrdersById($record_id);
//        $html = $this->load->view('invoice', $data);
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('invoice', $data, TRUE);

        $mpdf->WriteHTML(utf8_encode($html));
        $content = chunk_split(base64_encode($mpdf->Output('', 'S')));
        $filename = "invoice.pdf";
        $subject = "Invoice from V-Florist";
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($fromMail, $fromName);
        $this->email->to($mailTo);
        $this->email->subject($subject);
        $this->email->attach($content, 'attachment', $filename, 'application/pdf');
        $this->email->send();
    }
    
    public function getCustomerEventDate() {
        $event_date = $this->input->post('event_date');
        $this->session->set_userdata('last_date',$event_date);
       if(isset($event_date)){
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $json_data['customer'] = $this->crud_model->getCustomers();
            $data = $this->crud_model->getDatePriceFlowers($event_date);
            if (isset($data)) {
                $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
                $json_data['flowers'] = json_encode($array1);
            } else {
                $json_data = NULL;
            }
            $this->load->view('addProductToCustomer', $json_data);
        } else {
            echo "404 Error..!";
        }
       }else{
             redirect(base_url() . 'product');
       }
    }
    
     public function getCustomerGroupEventDate(){
        $event_date = $this->input->post('event_date');
        $this->session->set_userdata('last_date',$event_date);
       if(isset($event_date)){
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
             $json_data['group'] = $this->crud_model->getCreatedGroup();
            $data = $this->crud_model->getDatePriceFlowers($event_date);
            if (isset($data)) {
                $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
                $json_data['flowers'] = json_encode($array1);
            } else {
                $json_data = NULL;
            }
            $this->load->view('addProductToGroup', $json_data);
         
        } else {
            echo "404 Error..!";
        }
       }else{
             redirect(base_url() . 'product/addProductToGroup');
       }
    }
    
    public function getProductToSupplierGroupEventDate() {
        $event_date = $this->input->post('event_date');
        $this->session->set_userdata('last_date',$event_date);
       if(isset($event_date)){
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $json_data['group'] = $this->crud_model->getSupplierCreatedGroup();
            $data = $this->crud_model->getSupplierDateGroupFlowers($event_date);
            if (isset($data)) {
                $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
                $json_data['flowers'] = json_encode($array1);
            } else {
                $json_data = NULL;
            }
            $this->load->view('addProductToSupplierGroup', $json_data);
        } else {
            echo "404 Error..!";
        }
       }else{
             redirect(base_url() . 'product/addProductToSupplierGroup');
       }
    }

}
