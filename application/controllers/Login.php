<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    public function index() {
        $this->load->view('welcome_message');
    }

    //Ajax login function
    public function ajax_login() {
        //Recieving post input of email, password from ajax request
        $email = $this->input->post('username');
        $password = $this->input->post('password');

        //Validating login
        $login_status = $this->validate_login($email, md5($password));

        if ($login_status == 'success') {
            $this->session->set_userdata('admin_login', '1');
            $this->session->set_userdata('login_type', 'admin');
        }

        //Replying ajax request with validation response
        echo $login_status;
    }

    //Validating login from ajax request
    public function validate_login($email = '', $password = '') {
        $credential = array('username' => $email, 'password' => $password);
        $result = $this->crud_model->admin_authenticate($credential);
        return $result;
    }

    function changePassword() {
        $this->load->view('changePassword');
    }

    function ajax_updatePassword() {
        $oldPassword = $this->input->post('old_password');
        $newPassword = $this->input->post('new_password');
        $result = $this->crud_model->updatePassword($oldPassword, $newPassword);
        echo $result;
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */

    public function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    /*     * *****LOGOUT FUNCTION ****** */

    public function logout() {
        $result = $this->session->sess_destroy();
        if ($result == null) {
            $data['status'] = 0;
            $this->crud_model->update_user_data($data);
        }
        redirect(base_url());
    }

}
