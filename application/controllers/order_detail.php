<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order_detail extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('user_model');
        $this->load->model('personlised_model');
        $this->load->helper(array('form', 'url'));
        if (!$this->session->userdata('user_id')) {
            redirect('signin');
        }
    }
    public function index() {
       
        $order_id = $this->uri->segment(3);
        $user_id = $this->session->userdata('user_id');
        $data['giftbox'] = $this->order_model->giftbox($order_id); 
        $data['address'] = $this->user_model->billingaddress($user_id);
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['order'] = $this->order_model->userorderdetail($order_id);
        $data['main_content'] = 'orderdetail';
        $data['title'] = "Order Detail";
        $data['eagle_coin_price'] = $this->personlised_model->american_eagle_price(1);
        $this->load->view('include/template', $data);
    }

}

?>