<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->view('welcome_message');
    }
    
    public function messageServices() {
        $this->load->model('crud_model');
        $data['ms'] = $this->crud_model->getActivationMessageServices();
        $this->load->view('messageServices', $data);
    }

    public function calenderView() {
        $this->load->view('calenderView');
    }

    public function ajax_getDefaultDetails() {
        $event_date = $this->input->post('event_date');
        $this->load->model('crud_model');
        $response = $this->crud_model->getDefaultDetails($event_date);
        echo json_encode($response);
    }
    
    public function test(){
         $this->load->model('crud_model');
        //  $response = $this->crud_model->suplierMessageDetails('1','17');
        // $this->crud_model->sendSupplierFlowerPrices();
        $response = $this->crud_model->start();
        // $data = $this->crud_model->getSupplierFlowers('5');
        // $array1 = array_values(array_intersect_key($data['a1'], $data['a2']));
        // echo json_encode($array1);
        echo json_encode($response->ind_message);
        
    }
    
    
    public function ajax_updateActionMessageServices() {
        $this->load->model('crud_model');
        $data = [
            
            'ind_message' => $this->input->post('ind_message'),
            'group_message' => $this->input->post('group_message')
            
            ];
        $response =  $this->crud_model->updateActionMessageServices($data);
        echo $response;
    }
  
      public function api_exe_cronjob() {
        $this->load->model('crud_model');
        $response = $this->crud_model->exe_cronjob();
            // echo json_encode($response);
    }

}
