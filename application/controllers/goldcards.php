<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Goldcards extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('front_model');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
         
        $data['content']=$this->front_model->getpagedata(10);
        $data['title'] = 'Gold Cards';
        $data['main_content'] = 'about';
        $this->load->view('include/template',$data);
        
    }

}
?>
