<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Supplier extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['flowers'] = $this->crud_model->getFlowers();
            $this->load->view('addSupplier', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function ajax_addSupplier() {
        $details['supplier_name'] = ($this->input->post('first_name') . ' ' . $this->input->post('last_name'));
        $details['supplier_place'] = $this->input->post('supplier_place');
        $details['supplier_father'] = $this->input->post('supplier_father');
        $details['supplier_phone'] = $this->input->post('mobile_number');
        $details['supplier_email'] = $this->input->post('email');
        $details['supplier_advance'] = $this->input->post('advance_amount');
        $details['supplier_flowers'] = $this->input->post('flower_id');
        $response = $this->crud_model->addSupplier($details);
        echo $response;
    }

    public function viewSupplier() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['supplier'] = $this->crud_model->getSupplier();
            $this->load->view('viewSupplier', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function viewSupplierBilling() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['supplier'] = $this->crud_model->getSupplierOrders();
            $this->load->view('viewSupplierBilling', $data);
        } else {
            echo "404 Error..!";
        }
    }
    
     public function ajax_viewSupplierOrdersBillingById() {
        $record_id = $this->input->post('record_id');
        $response = $this->crud_model->viewSupplierBillingById($record_id);
        echo json_encode($response);
     }

    public function ajax_viewSupplierBillingById() {
        $record_id = $this->input->post('record_id');
        $response = $this->crud_model->viewSupplierBillingById($record_id);
        $advance = $this->crud_model->getOrderSupplierById($record_id);
        $output = '';
        $sum = 0;
        //  <a class="btn btn-sm btn-info pull-right" href=' . base_url() . '/supplier/printInvoice/' . $record_id . '><i class="fa fa-download"></i>&nbsp; Invoice</a> 
       
        $output .= ' 
        <a class="btn btn-sm btn-warning pull-right" href=' . base_url() . 'supplier/autoPrintInvoice/' . $record_id . '><i class="fa fa-print"></i>&nbsp; Print Invoice</a>
        <div class="material-datatables">
                                    <table class="table table-no-bordered" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr class="text-warning">
                                                <th>Flower Name</th> 
                                                <th>Rate</th>
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

        $output .= '<tr><td></td><td></td><td class="text-primary"><b>Final Price</b></td><td class="text-success"><b>' . $sum . '</b></td></tr>';
        $output .= '<tr><td></td><td></td><td class="text-primary"><b>Paid Price</b></td><td class="text-success"><b>' . $advance->product_price . '</b></td></tr>';
        $output .= '<tr><td></td><td></td><td class="text-primary"><b>Supplier Advance</b></td><td class="text-info"><b>' . $advance->supplier_advance . '</b></td></tr></tbody></table></div>';
        echo $output;
    }

    public function ajax_updateSupplier() {
        $supplier_id = $this->input->post('id');
        $details['supplier_name'] = $this->input->post('supplier_name');
        $details['supplier_place'] = $this->input->post('supplier_place');
        $details['supplier_father'] = $this->input->post('supplier_father');
        $details['supplier_phone'] = $this->input->post('supplier_phone');
        $details['supplier_email'] = $this->input->post('supplier_email');
        $response = $this->crud_model->updateSupplier($supplier_id, $details);
        echo $response;
    }

    public function ajax_deleteSupplier() {
        $deleteId = $this->input->post('id');
        $response = $this->crud_model->deleteSupplier($deleteId);
        echo $response;
    }

    public function payAdvance() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['supplier'] = $this->crud_model->getSupplier();
            $this->load->view('payAdvance', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function ajax_getSupplierFlowers() {
        $supplierId = $this->input->post('supplier_id');
        $data = $this->crud_model->getSupplierFlowers($supplierId);
        $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
        echo json_encode($array1);
    }
    
    public function ajax_getSupplierDefaultPrices() {
        $supplierId = $this->input->post('supplier_id');
        $event_date = $this->input->post('event_date');
        $data = $this->crud_model->getSupplierDefaultPrices($event_date,$supplierId);
        $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
        echo json_encode($array1);
    }

    public function ajax_getSupplierAdvance() {
        $supplierId = $this->input->post('supplier_id');
        $data = $this->crud_model->getSupplierAdvance($supplierId);
        echo $data;
    }

    public function ajax_payAdvance() {
        $supplier_id = $this->input->post('supplier_id');
        $supplier_advance = $this->input->post('supplier_advance');
        $response = $this->crud_model->updateAdvance($supplier_id, $supplier_advance);
        echo $response;
    }

    public function ajax_getSupplierById() {
        $supplier_id = $this->input->post('supplier_id');
        $response = $this->crud_model->getSupplierById($supplier_id);
        echo json_encode($response);
    }

    public function addPriceList() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['flowers'] = $this->crud_model->getFlowers();
            $this->load->view('addPriceToFlower', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function viewPriceList() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['supplier'] = $this->crud_model->getSupplier();
            $this->load->view('viewPriceList', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function modifyPriceList() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['supplier'] = $this->crud_model->getSupplier();
            $this->load->view('modifyPriceList', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function supplierBilling() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['supplier'] = $this->crud_model->getSupplier();
            $this->load->view('supplierBilling', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function ajax_addSupplierBilling() {
        $flower_id = $this->input->post('flower_id');
        $flower_price = $this->input->post('flower_price');
        $supplier_id = $this->input->post('supplier_id');
        $quantity = $this->input->post('quantity');
        $final_price = $this->input->post('final_price');
        $commission = $this->input->post('commission');
        $supplier_advance = $this->input->post('sup_advance');
        $created_at = $this->input->post('event_date');
        $orderArray = array();
        $i = 0;
        foreach ($flower_id as $key => $value) {
            $orderArray['orders'][$i]['flower_id'] = $flower_id[$key];
            $orderArray['orders'][$i]['flower_price'] = $flower_price[$key];
            $orderArray['orders'][$i]['quantity'] = $quantity[$key];
            $i++;
        }
        $response = $this->crud_model->insertSupplierBilling($orderArray, $supplier_id, $final_price, $commission, $supplier_advance,$created_at);
        echo $response;
    }
    
    public function ajax_updateSupplierOrderQunatity() {
        $flower_price = $this->input->post('flower_price');
        $quantity = $this->input->post('quantity');
        $supplier_id = $this->input->post('supplier_id');
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
        $response = $this->crud_model->updateSupplierOrderQunatity($orderArray, $supplier_id, $sum,$record_id);
        redirect('/supplier/viewSupplierBilling', 'refresh');
        }

    public function printInvoice($record_id) {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['supplier'] = $this->crud_model->viewSupplierBillingById($record_id);
            $data['orders'] = $this->crud_model->getOrderSupplierById($record_id);
            $data['invoice_type'] = 'supplier';
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('invoice', $data, TRUE);
            $mpdf->WriteHTML($html);
            $mpdf->Output('invoice_' . $record_id . '.pdf', 'D');
        } else {
            echo "404 Error..!";
        }
    }

    public function autoPrintInvoice($record_id) {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['orders'] = $this->crud_model->viewSupplierBillingById($record_id);
            $data['supplier'] = $this->crud_model->getOrderSupplierById($record_id);
            $data['invoice_type'] = 'supplier';
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('invoice', $data, TRUE);
            $mpdf->SetJS('this.print();');
            $mpdf->WriteHTML($html);
            $mpdf->Output('invoice_' . $record_id . '.pdf', 'I');
        } else {
            echo "404 Error..!";
        }
    }

    public function priceEventList() {
        if (isset($_POST['data'])) {
            $events = $this->crud_model->getSupplierPricelist();
            echo json_encode($events);
        }
    }

    public function ajax_recentPriceEventList() {
        if (isset($_POST['data'])) {
            $events = $this->crud_model->getRecentSupplierPricelist();
            echo json_encode($events);
        }
    }

    public function ajax_addPriceList() {
        $flower_id = $this->input->post('flower_id');
        $flower_name = $this->input->post('flower_name');
        $flower_price = $this->input->post('flower_price');
        $flowerArray = array();
        $i = 0;
        foreach ($flower_id as $key => $value) {
            $flowerArray['flowers_details'][$i]['flower_id'] = $flower_id[$key];
            $flowerArray['flowers_details'][$i]['flower_name'] = $flower_name[$key];
            $flowerArray['flowers_details'][$i]['flower_price'] = $flower_price[$key];
            $i++;
        }
        $response = $this->crud_model->insertSupplierPrice($flowerArray);
        echo $response;
    }

    public function ajax_updatePriceList() {
        $flower_id = $this->input->post('flower_id');
        $flower_name = $this->input->post('flower_name');
        $flower_price = $this->input->post('flower_price');
        $event_id = $this->input->post('event_id');
        $flowerArray = array();
        $i = 0;
        foreach ($flower_id as $key => $value) {
            $flowerArray['flowers_details'][$i]['flower_id'] = $flower_id[$key];
            $flowerArray['flowers_details'][$i]['flower_name'] = $flower_name[$key];
            $flowerArray['flowers_details'][$i]['flower_price'] = $flower_price[$key];
            $i++;
        }
        $response = $this->crud_model->updateSupplierPrice($flowerArray, $event_id);
        echo $response;
    }

    public function groupingSupplier() {
        $result['supplier'] = $this->crud_model->getSupplier();
        $result['groupSupplier'] = $this->crud_model->getGroupSupplier();
        $result['group'] = $this->crud_model->getSupplierCreatedGroup();
        $this->load->view('groupingSupplier', $result);
    }

    public function getGroupSupplierById($groupId) {
        $data['supplier'] = $this->crud_model->getGroupSupplierById($groupId);
        $this->load->view('viewGroupingSupplier', $data);
    }

    public function ajax_getGroupSupplierById() {
        $groupId = $this->input->post('group_id');
        $data = $this->crud_model->getGroupSupplierById($groupId);
        echo json_encode($data);
    }

    public function ajax_addGroupSupplier() {
        $basic['group_name'] = $this->input->post('group_name');
        $basic['supplier_id'] = $this->input->post('supplier_id');

        $response = $this->crud_model->addGroupSupplier($basic);
        echo $response;
    }

    public function ajax_deleteGroup() {
        $deleteId = $this->input->post('id');
        $response = $this->crud_model->deleteGroupSupplier($deleteId);
        echo $response;
    }

    public function ajax_deleteSupplierInGroup() {
        $deleteId = $this->input->post('supplier_id');
        $group_id = $this->input->post('group_id');
        $response = $this->crud_model->deleteSupplierGroup($deleteId, $group_id);
        echo $response;
    }

    public function ajax_updateSupplierInGroup() {
        $supplierId = $this->input->post('supplier_id');
        $groupId = $this->input->post('group_id');
        $response = $this->crud_model->updateSupplierGroup($supplierId, $groupId);
        echo $response;
    }

}
