<?php

class User extends CI_Controller {
public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->model('user_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }
     public function manageuser()
   {       
         $data['user'] = $this->user_model->getuser();
        $data['main_content'] = 'admin/user/user';
       $this->load->view('admin/include/template', $data);
      
    } 
    public function deleteuser(){
        $id = $this->uri->segment(4);
        if ($this->user_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User deleted succesfully.');
            redirect('admin/user/manageuser');
        }
    }
}
?>
