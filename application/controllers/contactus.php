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
        $captcha = $this->generateRandomString();
        $data['captcha'] = $captcha;
        $this->session->set_userdata('captcha', $captcha);
        $data['title'] = 'Contact Us';
        $data['main_content'] = 'contactus';
        $this->load->view('include/template', $data);
    }

    public function sendmail() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email ID', 'required|valid_email');
        $this->form_validation->set_rules('number', 'Number', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $this->form_validation->set_rules('captcha', 'Verification Code', 'required');
        if ($this->form_validation->run() == false) {
            $captcha = $this->generateRandomString();
            $data['captcha'] = $captcha;
            $this->session->set_userdata('captcha', $captcha);
            $data['title'] = 'Contact Us';
            $data['main_content'] = 'contactus';
            $this->load->view('include/template', $data);
        } else {
            if ($this->session->userdata('captcha') != $this->input->post('captcha')) {
             $captcha = $this->generateRandomString();
            $data['captcha'] = $captcha;
            $this->session->set_userdata('captcha', $captcha);
              $data['captcha_validation'] = 'failed';
            $data['title'] = 'Contact Us';
            $data['main_content'] = 'contactus';
            $this->load->view('include/template', $data);
                
            } else {
                $data = 'Name: ' . $this->input->post('name') . "\r\n\r\r\n\r";
                $data .= 'Email: ' . $this->input->post('email') . "\r\n\r\r\n\r";
                $data .= 'Phone Number: ' . $this->input->post('number') . "\r\n\r\r\n\r";
                $data .= 'Message: ' . $this->input->post('message') . "\r\n\r\r\n\r";
                //$this->email->from($this->input->post('email'), $this->input->post('name'));
                $this->email->from('info@personalizedcoins.com');
                $this->email->reply_to('info@personalizedcoins.com');
                //$this->email->to('alexadagostino@gmail.com', 'info@personalizedcoins.com');
         $list = array('alexadagostino@gmail.com', 'ggoldong@gmail.com', 'info@personalizedcoins.com');
                $this->email->to($list);
                $this->email->subject('Personalized Coins - Contact Us Form ');
                $this->email->message($data);
                if ($this->email->send()) {
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
    }

    public function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ987654310';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
//        header('Content-type: image/png');
//        $im = imagecreatetruecolor(400, 30);
//        $white = imagecolorallocate($im, 255, 255, 255);
//$grey = imagecolorallocate($im, 128, 128, 128);
//$black = imagecolorallocate($im, 0, 0, 0);
//imagefilledrectangle($im, 0, 0, 399, 29, $white);
//        $font = 'arial.ttf';
//        imagettftext($im, 20, 0, 11, 21, $grey, $font, $randomString);
//        imagettftext($im, 20, 0, 10, 20, $black, $font, $randomString);
        //imagepng($im);
        return $randomString;
    }

}

?>