<?php
ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php
class Login extends CI_Controller {
    function __encrip_password($password) {
        return md5($password);
    }
    public function index() {
        $this->load->library('form_validation');
        $this->load->library('session');
        // $data=array();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array(
                array(
                    'field' => 'username',
                    'label' => 'User Name',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required'
            ));
            $this->form_validation->set_rules($data);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/login');
            } else {
                $this->load->model('admin_model');
                $user_name = $this->input->post('username');
                $password = $this->__encrip_password($this->input->post('password'));
                $is_valid = $this->admin_model->validate($user_name, $password);
                if ($is_valid) {
                    $data = array(
                        'user_name' => $user_name,
                        'is_logged_in' => true,
                        'admin_id' => $is_valid[0]['id']
                    );
                    $this->session->set_userdata($data);
                    redirect('admin/dashboard');
                } else { // incorrect username or password
                    $this->session->set_flashdata('Login_error', 'Try Again.');
                    redirect('admin/login');
                }
            }
        } else {
            $this->load->view('admin/login');
        }
    }
    function logout() {
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
?>
