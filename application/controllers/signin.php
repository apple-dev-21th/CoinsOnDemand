<?php

Class Signin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->model('signup_model');
        $this->load->model('user_model');
    }

    function __encrip_password($password) {
        return md5($password);
    }

    public function index() {
        $data['title'] = 'Sign in';
        $data['main_content'] = 'signin';
        $this->load->view('include/template', $data);
    }

    public function login() {
        $data = array(
            array(
                'field' => 'username',
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
        ));
        $this->form_validation->set_rules($data);
        if ($this->form_validation->run() == FALSE) {
            if ($this->session->userdata('checkoutpage')) {  // Redirect to checkout login page
                $data['title'] = 'Account Login';
                $data['main_content'] = 'accountlogin';
                $this->load->view('include/template', $data);
            } else {

                $data['title'] = 'Sign in';
                $data['main_content'] = 'signin';
                $this->load->view('include/template', $data);
            }
        } else {
            $email_id = $this->input->post('username');
            $password = $this->__encrip_password($this->input->post('password'));
            $is_valid = $this->signup_model->validate($email_id, $password);
            if ($is_valid) {
                if ($this->input->post('rember')) { // Set cookies
                    $pswd = $this->encrypt->encode($this->input->post('password'));
                    $cookie = array(
                        'name' => 'password',
                        'value' => $pswd,
                        'expire' => '86500'
                    );
                    $cookie1 = array(
                        'name' => 'username',
                        'value' => $email_id,
                        'expire' => '86500'
                    );
                    $this->input->set_cookie($cookie);
                    $this->input->set_cookie($cookie1);
                }
                $data = array(
                    'user' => $is_valid['0']['first_name'],
                    'last_name' => $is_valid['0']['last_name'],
                    'user_id' => $is_valid['0']['user_id'],
                    'emailid' => $is_valid['0']['email_id'],
                    'is_logged_in' => true
                );
                $this->session->set_userdata($data);
                if ($this->session->userdata('checkoutpage')) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $pending_cart = array(
                        'user_id' => $is_valid['0']['user_id'],
                    );
                    $this->user_model->update_user_pendingcart($ip, $pending_cart);
                    redirect('checkout');
                } else {
                    // Update Cart for Login User
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $user_id = $this->session->userdata('user_id');
                    $pending_cart = $this->user_model->pending_cartitems($user_id);
                    // echo '<pre>';  
                    //print_r($pending_cart); 
                    $checkout = $this->session->userdata('checkoutpage');
                    if (empty($checkout)) {
                        if(!empty($pending_cart)){
                        foreach ($pending_cart as $cart):
                            $da = array(
                                'id' => $cart['item_id'],
                                'qty' => $cart['coin_qty'],
                                'price' => $cart['coin_price'],
                                'name' => $cart['coin_name'],
                                'options' => array('finalcoin' => $cart['coin_image'], 'Gold Plated' => $cart['gold']));
                            $this->cart->insert($da);
                        endforeach;
                        $data = array(
                            'checkoutpage' => true
                        );
                        $this->session->set_userdata($data);
                        }
                    }


                    redirect('viewmyorder');
                }
            }
            else { // incorrect username or password
                $this->session->set_flashdata('Login_error', 'Try Again.');
                if ($this->session->userdata('checkoutpage')) {
                    redirect('shipping/login'); // Redirect to checkout login page
                } else {
                    redirect('signin');
                }
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

}

?>
