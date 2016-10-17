<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contactus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->model('front_model');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        
        $data['title'] = 'Contact Us';
        $data['main_content'] = 'contactus';
        $this->load->view('include/template', $data);
    }

    public function sendmail() {
        $data = 'Name: '.$this->input->post('name')."\r\n\r\r\n\r";
        $data  .= 'Email: '.$this->input->post('email')."\r\n\r\r\n\r";
        $data  .= 'Phone Number: '.$this->input->post('number')."\r\n\r\r\n\r";
        $data  .= 'Message: '.$this->input->post('message')."\r\n\r\r\n\r";
        $this->email->from($this->input->post('email'), $this->input->post('name'));
        $this->email->to('personalizedcoins@ecoins.com, MerrickMint@aol.com, alexadagostino@gmail.com');
        $this->email->subject('Personalized Coins - Contact Us Form ');
        $this->email->message($data);
        if($this->email->send())
        {
        $now = date("Y-m-d H:i:s");
                $data_to_save = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'number' => $this->input->post('number'),
                    'message' => $this->input->post('message'),
                    'date' => $now
                );
                $this->front_model->contactquery($data_to_save);
                 $this->session->set_flashdata('success', 'Your email has been sent succesfully. ');
                redirect('contactus');
        }
    }

}

?>