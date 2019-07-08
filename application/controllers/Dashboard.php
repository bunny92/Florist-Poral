<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('crud_model');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    public function index()
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url() . 'login');
        }elseif($this->session->userdata('admin_login') == 1) {
            
            $data['flower'] = $this->crud_model->getCount('flowers');
            $data['customer'] = $this->crud_model->getCustomerCount();
            $data['supplier'] = $this->crud_model->getSupplierCount();
            $data['stock'] = $this->crud_model->getStockCount();
            $this->load->view('dashboard',$data);
        }else{
            echo "404 Error..!";
        }       
    }
}
