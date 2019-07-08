<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Flowers extends CI_Controller {

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
            $this->load->view('flowerslist', $data);
        } else {
            echo "404 Error..!";
        }
    }

    public function ajax_addFlower() {
        $data['flower_name'] = $this->input->post('flower_name');
        $response = $this->crud_model->addFlower($data);
        echo $response;
    }

    public function ajax_deleteFlower() {
        $flowerId = $this->input->post('flower_id');
        $response = $this->crud_model->deleteFlower($flowerId);
        echo $response;
    }

    public function ajax_updateFlower() {
        $flowerId = $this->input->post('flower_id');
        $flowerName = $this->input->post('flower_name');
        $response = $this->crud_model->updateFlower($flowerId, $flowerName);
        echo $response;
    }

}
