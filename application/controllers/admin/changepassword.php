<?php

class Changepassword extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->model('admin_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function index() {
        $data['title'] = "Change Password";
        $data['main_content'] = 'admin/changepassword';
        $this->load->view('admin/include/template', $data);
    }

    public function updatepassword() {
        $user_id = $this->session->userdata('admin_id'); 
        $data = array(
            array(
                'field' => 'old_password',
                'label' => 'Old Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'conf_password',
                'label' => 'Confirm New Password',
                'rules' => 'required|matches[new_password]'
            )
        );
        $this->form_validation->set_rules($data);
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Change Password";
            $data['main_content'] = 'admin/changepassword';
            $this->load->view('admin/include/template', $data);
        } else {
             $old_password = $this->__encrip_password($this->input->post('old_password'));
             $oldy = $this->admin_model->getoldpassword($user_id);
               if($old_password == $oldy['0']['password']){
               $data = array(
               'password' => $this->__encrip_password($this->input->post('new_password')));
            $this->admin_model->updatepassword($user_id, $old_password,$data);
             //$this->session->sess_destroy();
             $this->session->set_flashdata('success', 'Your password changed succesfully. Please login with new password.');
             redirect('admin/login');
             } else {
            $this->session->set_flashdata('fail', 'Old password not match. Please enter correct password');
             redirect('admin/changepassword');
             }
        }
    }
    function __encrip_password($password) {
        return md5($password);
    }

}

?>