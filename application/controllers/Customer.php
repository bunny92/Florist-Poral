<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Customer extends CI_Controller {

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
            $this->load->view('addCustomer', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function ajax_addcustomer() {

        $basic['first_name'] = $this->input->post('firstname');
        $basic['last_name'] = $this->input->post('lastname');
        $basic['father_name'] = $this->input->post('father_name');

        $details['customer_phone'] = $this->input->post('phone');
        $details['customer_email'] = $this->input->post('customer_email');
        $details['customer_address'] = $this->input->post('address');
        $details['customer_pincode'] = $this->input->post('pincode');
        $details['customer_city'] = $this->input->post('street_name');

        $response = $this->crud_model->addCustomer($basic, $details);
        echo $response;
    }

    public function ajax_checkPhoneNumber() {
        $phoneNumber = $this->input->post('customer_phone');
        $response = $this->crud_model->checkExistingUser('customer_details', $phoneNumber, 'customer_phone');
        if (is_null($response)) {
            echo 'failed';
        } else {
            echo 'success';
        }
    }

    public function ajax_checkEmail() {
        $email = $this->input->post('customer_email');
        $response = $this->crud_model->checkExistingUser('customer_details', $email, 'customer_email');
        if (is_null($response)) {
            echo 'failed';
        } else {
            echo 'success';
        }
    }

    public function ajax_checkBillingName() {
        $billName = $this->input->post('billing_name');
        $response = $this->crud_model->checkExistingUser('customer_account_records', $billName, 'billing_name');
        if (is_null($response)) {
            echo 'failed';
        } else {
            echo 'success';
        }
    }

    public function ajax_getCustomerBalance() {
        $customerId = $this->input->post('customer_id');
        $response = $this->crud_model->getCustomerBalance($customerId);
        if (isset($response)) {
            echo $response;
        } else {
            echo 0;
        }
    }

    public function viewCustomers() {
          if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
        $result['customers'] = $this->crud_model->getCustomers();
        $this->load->view('viewCustomer', $result);
        } else {
            echo "404 Error..!";
        }
    }

    public function viewCustomersById($customerId) {
          if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
        $data['customer'] = $this->crud_model->getCustomersById($customerId);
        $this->load->view('modifyCustomer', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function ajax_updateCustomer() {
        $customerId = $this->input->post('customer_id');
        $basic['first_name'] = $this->input->post('firstname');
        $basic['last_name'] = $this->input->post('lastname');
        $basic['father_name'] = $this->input->post('father_name');

        $details['customer_phone'] = $this->input->post('phone');
        $details['customer_email'] = $this->input->post('customer_email');
        $details['customer_address'] = $this->input->post('address');
        $details['customer_pincode'] = $this->input->post('pincode');
        $details['customer_city'] = $this->input->post('street_name');

        $response = $this->crud_model->updateCustomer($basic, $details, $customerId);
        echo $response;
    }

    public function ajax_deleteCustomer() {
        $customerId = $this->input->post('customer_id');
        $response = $this->crud_model->deleteCustomer($customerId);
        echo $response;
    }

    public function groupingCustomer() {
         if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
        $result['customers'] = $this->crud_model->getCustomers();
        $result['groupCustomer'] = $this->crud_model->getGroupCustomer();
        $result['group'] = $this->crud_model->getCreatedGroup();
        $this->load->view('groupingCustomer', $result);
        } else {
            echo "404 Error..!";
        }
    }

    public function getGroupCustomerById($groupId) {
          if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
        $data['customers'] = $this->crud_model->getGroupCustomerById($groupId);
        $this->load->view('viewGroupingCustomer', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function ajax_getGroupCustomerById() {
        $groupId = $this->input->post('group_id');
        $data = $this->crud_model->getGroupCustomerById($groupId);
        echo json_encode($data);
    }

    public function ajax_addGroupCustomer() {
        $basic['group_name'] = $this->input->post('group_name');
        $basic['customer_id'] = $this->input->post('customer_id');

        $response = $this->crud_model->addGroupCustomer($basic);
        echo $response;
    }

    public function ajax_deleteGroup() {
        $deleteId = $this->input->post('id');
        $response = $this->crud_model->deleteGroup($deleteId);
        echo $response;
    }

    public function ajax_deleteCustomerInGroup() {
        $deleteId = $this->input->post('customer_id');
        $groupId = $this->input->post('group_id');
        $response = $this->crud_model->deleteCustomerGroup($deleteId, $groupId);
        echo $response;
    }

    public function ajax_updateCustomerInGroup() {
        $customerId = $this->input->post('customer_id');
        $groupId = $this->input->post('group_id');
        $response = $this->crud_model->updateCustomerGroup($customerId, $groupId);
        echo $response;
    }

    public function ajax_getEmailIdById() {
        $customerId = $this->input->post('customer_id');
        $response = $this->crud_model->getCustomerEmail($customerId);
        echo $response;
    }

    public function addPriceList() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $data['flowers'] = $this->crud_model->getFlowers();

            $this->load->view('addCustomerPriceList', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function viewPriceList() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $this->load->view('viewCustomerPriceList');
        } else {
            echo "404 Error..!";
        }
    }

    public function modifyPriceList() {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        } elseif ($this->session->userdata('admin_login') == 1) {
            $this->load->view('modifyCustomerPriceList');
        } else {
            echo "404 Error..!";
        }
    }

    public function priceEventList() {
        if (isset($_POST['data'])) {
            $events = $this->crud_model->getCustomerPricelist();
            echo json_encode($events);
        }
    }

    public function ajax_recentPriceEventList() {
        if (isset($_POST['data'])) {
            $events = $this->crud_model->getRecentCustomerPricelist();
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
        $response = $this->crud_model->insertCustomerPrice($flowerArray);
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
        $response = $this->crud_model->updateCustomerPrice($flowerArray, $event_id);
        echo $response;
    }

}
