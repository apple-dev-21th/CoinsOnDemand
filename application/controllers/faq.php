<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faq extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('front_model');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
         
        $data['title'] = 'FAQ';
        $data['content'] = $this->front_model->getfaq();
        $data['main_content'] = 'faq';
        $this->load->view('include/template', $data);
    }

}