<?php

class Shipping extends CI_Controller {

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
        $data['title'] = 'Shipping Address';
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['country'] = $this->user_model->getcountries();
         if (!empty($data['shipping'])) {
        $ctry_id =  $data['shipping']['0']['country'];
        $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
          } else {
              $data['states'] = $this->user_model->getstatesbycountry('United States-US');
          }
        $data['main_content'] = 'shipping';
        $this->load->view('include/template', $data);
         }else {
      $data['title'] = 'Account Login';
      $data['main_content'] = 'accountlogin';
      $this->load->view('include/template', $data);
         }
    }

    public function updateshipping() {
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('address1', 'Address', 'required');
        $this->form_validation->set_rules('address2', 'Address2', '');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
          if($this->input->post('country') == 'Canada-CA' || $this->input->post('country') == 'United Kingdom-GB' ){
        $this->form_validation->set_rules('zip', 'Postal Code', 'required');
          }else {
              $this->form_validation->set_rules('zip', 'Postal Code', 'required');
          }
        
        $this->form_validation->set_rules('city', 'City Name', 'required');
        $this->form_validation->set_rules('state', 'State Name', 'required');
        $this->form_validation->set_rules('country', 'Country Name', 'required');
//        $data = array(
//            array('field' => 'fname',
//                'label' => 'First Name',
//                'rules' => 'required'
//            ),
//            array('field' => 'lname',
//                'label' => 'Last Name',
//                'rules' => 'required'
//            ),
//            array('field' => 'address1',
//                'label' => 'Address',
//                'rules' => 'required'
//            ),
//            array('field' => 'address2',
//                'label' => 'Address2',
//                'rules' => ''
//            ),
//            array('field' => 'phone',
//                'label' => 'Phone Number',
//                'rules' => 'required'
//            ),
//            array('field' => 'zip',
//                'label' => 'Postal Code',
//                'rules' => 'required'
//            ),
//            array('field' => 'city',
//                'label' => 'City Name',
//                'rules' => 'required'
//            ),
//            array('field' => 'state',
//                'label' => 'State Name',
//                'rules' => 'required'
//            ),
//            array('field' => 'country',
//                'label' => 'Country Name',
//                'rules' => 'required'
//            )
//        );
//        $this->form_validation->set_rules($data);
        if ($this->form_validation->run() == FALSE) {
        $data['title'] = 'Shipping Address';
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['country'] = $this->user_model->getcountries();
         if (!empty($data['shipping'])) {
        $ctry_id =  $data['shipping']['0']['country'];
        $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
         }else { 
            $data['states'] = $this->user_model->getstatesbycountry('United States-US');
        }
            $data['main_content'] = 'shipping';
            $this->load->view('include/template', $data);
        } else {

            $now = date("Y-m-d H:i:s");
            $data_to_save = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'address' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'phone' => $this->input->post('phone'),
                'zip' => $this->input->post('zip'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'date' => $now
            );
            
            if ($this->user_model->updateshipping($user_id, $data_to_save)) {
               redirect('review_order');
            }
        }
    }

    public function addshipping() {
        $user_id = $this->session->userdata('user_id');
        $data = array(
            array('field' => 'fname',
                'label' => 'First Name',
                'rules' => 'required'
            ),
            array('field' => 'lname',
                'label' => 'Last Name',
                'rules' => 'required'
            ),
            array('field' => 'address1',
                'label' => 'Address',
                'rules' => 'required'
            ),
            array('field' => 'address2',
                'label' => 'Address2',
                'rules' => ''
            ),
            array('field' => 'phone',
                'label' => 'Phone Number',
                'rules' => 'required'
            ),
            array('field' => 'zip',
                'label' => 'Postal Code',
                'rules' => 'required'
            ),
            array('field' => 'city',
                'label' => 'City Name',
                'rules' => 'required'
            ),
            array('field' => 'state',
                'label' => 'State Name',
                'rules' => 'required'
            ),
            array('field' => 'country',
                'label' => 'Country Name',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($data);
        if ($this->form_validation->run() == FALSE) {
          $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Shipping Address';
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['country'] = $this->user_model->getcountries();
         if (!empty($data['shipping'])) {
        $ctry_id =  $data['shipping']['0']['country'];
        $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
         }else { 
            $data['states'] = $this->user_model->getstatesbycountry('United States-US');
        }
            $data['main_content'] = 'shipping';
            $this->load->view('include/template', $data);
        } else {
            $now = date("Y-m-d H:i:s");
            $data_to_save = array(
                'user_id' => $user_id,
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'address' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'phone' => $this->input->post('phone'),
                'zip' => $this->input->post('zip'),
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
    
    public function login(){
    
      $data['title'] = 'Account Login';
      $data['main_content'] = 'accountlogin';
      $this->load->view('include/template', $data);
    }
    public function guestuser(){
        if($this->input->post('guestuser') == 'register')
        {
            redirect('signup');
        } else { 
            redirect('guest_checkout');
        }
        
    }
}

?>