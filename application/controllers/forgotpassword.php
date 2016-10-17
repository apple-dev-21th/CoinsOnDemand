<?php

class Forgotpassword extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('string');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->helper(array('form', 'url'));
        $this->load->model('user_model');
    }

    public function index() {
        $data['title'] = 'Reset Password';
        $data['main_content'] = 'forgotpassword';
        $this->load->view('include/template', $data);
    }

    public function validate() {
        $email = $this->input->post('useremail');
        $data['user'] = $this->user_model->user_detail($email);
        if ($data['user'] == '') {
            $this->session->set_flashdata('error', 'The Given Email ID doesn\'t exists in our data base.');
            redirect("forgotpassword");
        } else {

            $radnum = random_string('alnum', 16);
            $link = base_url() . 'forgotpassword/changepassword/' . $radnum;
            $this->email->set_mailtype("html");
            $message = " Dear " . $data['user']['0']['first_name'] .'<br><br>' ;
            $message .=  'You have requested to reset your password. If this is was not you please contact us immediately.'.'<br><br>';
    $message .= " <a href=" . base_url() . 'forgotpassword/changepassword/' . $radnum . ">Click here</a> to reset your password or copy and paste the link into the browser. <br><br> Link : " . $link . "<br><br> ";
    
       $message .= "Thank you, <br><br>Personalized Coins Team";
            $this->email->from('info@personalizedcoins.com');
            $this->email->to($email);
            $this->email->subject('Forgot Password');
            $this->email->message($message);
            // print_r($data['user']);
            if ($this->email->send()) {
                $data_to_save = array(
                    'user_id' => $data['user']['0']['user_id'],
                    'randomnumber' => $radnum,
                    'status' => '1'
                );
              //  echo '<pre>';
             //   print_r($data_to_save);

                $this->user_model->insertforgotpwd($data_to_save);
                $this->session->set_flashdata('success', 'Please check your mail Id to change password.');
                redirect("forgotpassword");
            }
        }
    }

    public function changepassword() {
        $randomnum = $this->uri->segment(3);
        echo $randomnum;
        $data['validrandom'] = $this->user_model->checknumvalid("$randomnum");
      // print_r($data['validrandom']); die;
        if ($data['validrandom'] == '') {
            $this->session->set_flashdata('error', 'Sorry your token has expired. Please rest password again.');
            redirect("forgotpassword");
        } else {
            $id = $data['validrandom']['0']['user_id'];
       //$this->session->set_userdata('user_id',$id);
            $data['user_id'] = $id;
            $data['location'] = 'forgotpassword';
            $data['title'] = 'Change Password';
            $data['main_content'] = 'updatepassword';
            $this->load->view('include/template', $data);
        }
    }

    public function updatepassword() {
        $user_id = $this->uri->segment(3);
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "Change Password";
            $data['main_content'] = "updatepassword";
            $this->load->view('include/template', $data);
        } else {
            $data = array(
                'password' => $this->__encrip_password($this->input->post('password'))
            );
            if ($this->user_model->updatepassword($user_id, $data)) {
                $this->user_model->updateforgotpwd($user_id);
                $this->session->set_flashdata('success', 'Your password updated succesfully. Please login with new password.');
                           redirect('signin');
            }
        }
    }

    function __encrip_password($password) {
        return md5($password);
    }

}

?>
