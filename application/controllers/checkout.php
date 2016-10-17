<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Checkout extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->helper('date');
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        $this->load->helper(array('form', 'url'));
        $this->load->model('user_model');
    }
    public function index() {
        if ($this->session->userdata('user')) {
            $user_id = $this->session->userdata('user_id');
            $data['address'] = $this->user_model->billingaddress($user_id);
            $data['country'] = $this->user_model->getcountries();
             if (!empty($data['address'])) {
                $ctry_id =  $data['address']['0']['country'];
                $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
               }else { 
              $data['states'] = $this->user_model->getstatesbycountry('United States-US');
            }
            $data['title'] = "Billing Address";
            $data['main_content'] = 'checkout';
            $this->load->view('include/template', $data);
        } else {
      $data['title'] = 'Account Login';
      $data['main_content'] = 'accountlogin';
      $this->load->view('include/template', $data);
        }
    }
    public function updateaddress() {
        $user_id = $this->session->userdata('user_id');
        $emailid = $this->input->post('email');
        $mail_unq = $this->user_model->checkmail($user_id, $emailid);
        $this->form_validation->set_rules('billingadd', 'Billing Address', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        if($this->input->post('country') == 'Canada-CA' || $this->input->post('country') == 'United Kingdom-GB' ){
            $this->form_validation->set_rules('post_code', 'Postal Code', 'required');
        }else {
        $this->form_validation->set_rules('post_code', 'Postal Code', 'required');
        }
        
        $this->form_validation->set_rules('city', 'City Name', 'required');
        $this->form_validation->set_rules('state', 'State Name', 'required');
        $this->form_validation->set_rules('country', 'Country Name', 'required');
        $this->form_validation->set_message('is_unique', '%s already exists, Kindly provide another email');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Billing Address';
            $data['address'] = $this->user_model->billingaddress($user_id);
            $data['country'] = $this->user_model->getcountries();
            $ctry_id =  $data['address']['0']['country'];
            $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
            $data['title'] = "Billing Address";
            $data['main_content'] = 'checkout';
            $this->load->view('include/template', $data);
        } else {
            $now = date("Y-m-d H:i:s");
            $data_to_save = array(
                'address' => $this->input->post('billingadd'),
                'phone' => $this->input->post('phone'),
                'post_code' => $this->input->post('post_code'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'date' => $now
            );
            if ($this->user_model->updateadd($user_id, $data_to_save)) {
                if ($this->input->post('diff_shippingadrs') == 'on') {
                    $shipping = $this->user_model->checkshippingadrees($user_id);
                   if($shipping > 0){
                   $now = date("Y-m-d H:i:s");
                  $data_to_save = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'address' => $this->input->post('billingadd'),
                'phone' => $this->input->post('phone'),
                'zip' => $this->input->post('post_code'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'date' => $now
            );
            if ($this->user_model->updateshipping($user_id, $data_to_save)) {
                               redirect('review_order');
            } 
                   }else {
                       $now = date("Y-m-d H:i:s");
                  $data_to_save = array(
                'user_id' => $user_id,
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'address' => $this->input->post('billingadd'),
                'phone' => $this->input->post('phone'),
                'zip' => $this->input->post('post_code'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'date' => $now
            );

            if ($this->user_model->add_shipping($data_to_save)) {
                redirect('review_order');
            }
                   }
                }
                else {
                redirect('shipping');
                }
            }
        }
    }

    public function addaddress() {
        $user_id = $this->session->userdata('user_id');
        $emailid = $this->input->post('email');
        $this->form_validation->set_rules('billingadd', 'Billing Address', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        if($this->input->post('country') == 'Canada-CA' || $this->input->post('country') == 'United Kingdom-GB' ){
            $this->form_validation->set_rules('post_code', 'Postal Code', 'required');
        }else {
        $this->form_validation->set_rules('post_code', 'Postal Code', 'required|numeric');
        }
        
        $this->form_validation->set_rules('city', 'City Name', 'required');
        $this->form_validation->set_rules('state', 'State Name', 'required');
        $this->form_validation->set_rules('country', 'Country Name', '');
//        $this->form_validation->set_rules($data);
        $this->form_validation->set_message('is_unique', '%s already exists, Kindly provide another email');
        if ($this->form_validation->run() == FALSE) {
            $user_id = $this->session->userdata('user_id');
         $data['title'] = 'Billing Address';
        $data['country'] = $this->user_model->getcountries();
        $data['address'] = $this->user_model->billingaddress($user_id);
         if (!empty($data['address'])) {
                $ctry_id =  $data['address']['0']['country'];
        $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
        }else { 
            $data['states'] = $this->user_model->getstatesbycountry('United States-US');
        }
            $data['title'] = "Billing Address";
            $data['main_content'] = 'checkout';
            $this->load->view('include/template', $data);
        } else {
            $now = date("Y-m-d H:i:s");
            $data_to_save = array(
                'user_id' => $user_id,
                'address' => $this->input->post('billingadd'),
                'phone' => $this->input->post('phone'),
                'post_code' => $this->input->post('post_code'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'date' => $now
            );
            if ($this->user_model->add_address($data_to_save)) {
                 if ($this->input->post('diff_shippingadrs') == 'on') {
                    $shipping = $this->user_model->checkshippingadrees($user_id);
                   if($shipping > 0){
                   $now = date("Y-m-d H:i:s");
                  $data_to_save = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'address' => $this->input->post('billingadd'),
                'phone' => $this->input->post('phone'),
                'zip' => $this->input->post('post_code'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'date' => $now
            );
            if ($this->user_model->updateshipping($user_id, $data_to_save)) {
                               redirect('review_order');
            } 
                   }else {
                       $now = date("Y-m-d H:i:s");
                  $data_to_save = array(
                'user_id' => $user_id,
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'address' => $this->input->post('billingadd'),
                'phone' => $this->input->post('phone'),
                'zip' => $this->input->post('post_code'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'date' => $now
            );

            if ($this->user_model->add_shipping($data_to_save)) {
                redirect('review_order');
            }
                   }
                }else {
                redirect('shipping');
                }
            }
        }
    }

}

?>