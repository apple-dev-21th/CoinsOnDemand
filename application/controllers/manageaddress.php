<?php

class Manageaddress extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->model('user_model');
        if (!$this->session->userdata('user')) {
            redirect('signin');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Manage Address';
        $data['address'] = $this->user_model->billingaddress($user_id);
        //print_r($data['address']); die;
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['main_content'] = 'manageaddress';
        $this->load->view('include/template', $data);
    }

    public function billingaddress() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Billing Address';
        $data['country'] = $this->user_model->getcountries();
        $data['address'] = $this->user_model->billingaddress($user_id);
        if (!empty($data['address'])) {
            $ctry_id = $data['address']['0']['country'];
            $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
        } else {
            $data['states'] = $this->user_model->getstatesbycountry('United States-US');
        }
        $data['main_content'] = 'billingaddres';
        $this->load->view('include/template', $data);
    }

    public function shipingaddress() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Shipping Address';
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['country'] = $this->user_model->getcountries();
        if (!empty($data['shipping'])) {
            $ctry_id = $data['shipping']['0']['country'];
            $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
        } else {
            $data['states'] = $this->user_model->getstatesbycountry('United States-US');
        }
        $data['main_content'] = 'shippingaddress';
        $this->load->view('include/template', $data);
    }

    public function updateaddress() {
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('billingadd', 'Billing Address', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        if ($this->input->post('country') == 'Canada-CA' || $this->input->post('country') == 'United Kingdom-GB') {
            $this->form_validation->set_rules('post_code', 'Postal Code', 'required');
        } else {
            $this->form_validation->set_rules('post_code', 'Postal Code', 'required|numeric');
        }

        $this->form_validation->set_rules('city', 'City Name', 'required');
        $this->form_validation->set_rules('state', 'State Name', 'required');
        $this->form_validation->set_rules('country', 'Country Name', 'required');
//        $data = array(
//            array('field' => 'billingadd',
//                'label' => 'Billing Address',
//                'rules' => 'required'
//            ),
//            array('field' => 'phone',
//                'label' => 'Phone Number',
//                'rules' => 'required'
//            ),
//            array('field' => 'post_code',
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

            $data['title'] = 'Billing Address';
            $data['address'] = $this->user_model->billingaddress($user_id);
            $data['country'] = $this->user_model->getcountries();
            $ctry_id = $data['address']['0']['country'];
            $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
            $data['main_content'] = 'billingaddres';
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
                $this->session->set_flashdata('success', 'Billing address updated succesfully.');
                redirect('manageaddress');
            }
        }
    }

    public function addaddress() {
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('billingadd', 'Billing Address', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        if ($this->input->post('country') == 'Canada-CA' || $this->input->post('country') == 'United Kingdom-GB') {
            $this->form_validation->set_rules('post_code', 'Postal Code', 'required');
        } else {
            $this->form_validation->set_rules('post_code', 'Postal Code', 'required|numeric');
        }

        $this->form_validation->set_rules('city', 'City Name', 'required');
        $this->form_validation->set_rules('state', 'State Name', 'required');
        $this->form_validation->set_rules('country', 'Country Name', 'required');


//        $data = array(
//            array('field' => 'billingadd',
//                'label' => 'Billing Address',
//                'rules' => 'required'
//            ),
//            array('field' => 'phone',
//                'label' => 'Phone Number',
//                'rules' => 'required'
//            ),
//            array('field' => 'post_code',
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

            $data['title'] = 'Billing Address';
            $data['country'] = $this->user_model->getcountries();
            $data['address'] = $this->user_model->billingaddress($user_id);
            if (!empty($data['address'])) {
                $ctry_id = $data['address']['0']['country'];
                $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
            } else {
                $data['states'] = $this->user_model->getstatesbycountry('United States-US');
            }
            $data['main_content'] = 'billingaddres';
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
                $this->session->set_flashdata('success', 'Billing address updated succesfully.');
                redirect('manageaddress');
            }
        }
    }

    public function updateshipping() {
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('address1', 'Address', 'required');
        $this->form_validation->set_rules('address2', 'Address2', '');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        if ($this->input->post('country') == 'Canada-CA' || $this->input->post('country') == 'United Kingdom-GB') {
            $this->form_validation->set_rules('zip', 'Postal Code', 'required');
        } else {
            $this->form_validation->set_rules('zip', 'Postal Code', 'required|numeric');
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
            $ctry_id = $data['shipping']['0']['country'];
            $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
            $data['main_content'] = 'shippingaddress';
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
                $this->session->set_flashdata('success', 'Shipping address updated succesfully.');
                redirect('manageaddress');
            }
        }
    }

    public function addshipping() {
        $user_id = $this->session->userdata('user_id');
          $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('address1', 'Address', 'required');
        $this->form_validation->set_rules('address2', 'Address2', '');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
          if($this->input->post('country') == 'Canada-CA' || $this->input->post('country') == 'United Kingdom-GB' ){
        $this->form_validation->set_rules('zip', 'Postal Code', 'required');
          }else {
              $this->form_validation->set_rules('zip', 'Postal Code', 'required|numeric');
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
            if (!empty($data['shipping'])) {
                $ctry_id = $data['shipping']['0']['country'];
                $data['states'] = $this->user_model->getstatesbycountry($ctry_id);
            } else {
                $data['states'] = $this->user_model->getstatesbycountry('United States-US');
            }
            $data['country'] = $this->user_model->getcountries();
            $data['main_content'] = 'shippingaddress';
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
                $this->session->set_flashdata('success', 'Billing address updated succesfully.');
                redirect('manageaddress');
            }
        }
    }

    public function getstates() {

        $states = $this->user_model->getstatesbycountry($_POST['regionid']);
        if (!empty($states)) {
            $data = '<select  required class="form-control shop_select wdth_100" name="state"><option value="">Please select region, state or province</option>';
            foreach ($states as $state) :
                $data .= '<option value="' . $state['name'] . '-' . $state['iso'] . '"> ' . $state['name'] . '</option>';
            endforeach;
            $data .= '</select>';
        }else {
            $data = '<input type="text" name="state" value="" class="form-control contact_text" id="inputEmail3">';
        }
        echo $data;
    }

}

?>
