<?php

class Myprofile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->model('user_model');
        if (!$this->session->userdata('user_id')) {
            redirect('signin');
        }
    }
    function __encrip_password($password) {
        return md5($password);
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['myprofile'] = $this->user_model->user_profile($user_id);
         $data['title'] = 'My Profile';
        $data['main_content'] = 'myprofile';
        $this->load->view('include/template', $data);
    }

    public function updateprofile() {
        $user_id = $this->session->userdata('user_id');
        $emailid = $this->input->post('emailid');
        $mail_unq = $this->user_model->checkmail($user_id, $emailid);
        if ($mail_unq == 1) {
            $this->form_validation->set_rules('emailid', 'Email ID', 'required|valid_email|is_unique[user.email_id]');
        } else {
            $this->form_validation->set_rules('emailid', 'Email ID', 'required|valid_email');
        }
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_message('is_unique', '%s already exists, Kindly provide another email');
        if ($this->form_validation->run() == FALSE) {

            $data['myprofile'] = $this->user_model->user_profile($user_id);
            $data['title'] = 'My Profile';
            $data['main_content'] = 'myprofile';
            $this->load->view('include/template', $data);
        } else {
            $now = date("Y-m-d H:i:s");
            $data_to_update = array(
                'first_name' => $this->input->post('fname'),
                'last_name' => $this->input->post('lname'),
                'email_id' => $this->input->post('emailid'),
                'date' => $now
            );
            if($this->user_model->updateprofile($user_id,$data_to_update)){
                  $this->session->set_flashdata('success', 'Profile updated succesfully.');
                redirect('myprofile');
            }
        }
    }
    public function changepassword() {
        
        $data['title'] = "Change Password";
        $data['main_content'] = "changepassword";
        $this->load->view('include/template', $data);
    }
    public function updatepassword() {
   $user_id = $this->session->userdata('user_id');
   $this->form_validation->set_rules('password', 'Password', 'required');
   $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
    if ($this->form_validation->run() == FALSE) {
        $data['title'] = "Change Password";
        $data['main_content'] = "changepassword";
        $this->load->view('include/template', $data);
    }else {
        $data = array(
            'password' => $this->__encrip_password($this->input->post('password'))
        );
        if($this->user_model->updatepassword($user_id,$data)){
       $this->session->set_flashdata('success', 'Password updated succesfully.');
        redirect('myprofile');
                
            }
    }
        
    }

}

?>
