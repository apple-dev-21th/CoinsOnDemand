<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slider extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('slider_model');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function add() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $baseurl = base_url();
            $config['upload_path'] = './assets/uploads';
            // print_r($config['upload_path']); die;
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('slider_image')) {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
                $now = date("Y-m-d H:i:s");
                $slidertosave = array(
                    'slider_image' => $file_name,
                    'order'=>  $this->input->post('slider_order'),
                    'status' => '1',
                    'date' => $now
                );
                if ($this->slider_model->addslider($slidertosave)) {
                    $this->session->set_flashdata('success', 'Slider Added Succesfully.');
                  redirect('admin/slider/add');
                }
            }
        } else {
            $data['total_slider']= $this->slider_model->count_slider();
            $data['main_content'] = 'admin/slider/addslider';
            $this->load->view('admin/include/template', $data);
        }
    }
   public function manageslider() {
       $data['total_slider']= $this->slider_model->count_slider();
        $data['slider'] = $this->slider_model->slides();
        $data['main_content'] = 'admin/slider/manageslider';
        $this->load->view('admin/include/template', $data);
    } 
    public function delete_Slider() {
        $id = $this->uri->segment(4);
        if($this->slider_model->delete_slider($id))
        {
         $this->session->set_flashdata('success', 'Slider Deleted Succesfully.');
          redirect('admin/slider/manageslider');
        }
    } 
public function deact_slider()
{
     $id = $this->uri->segment(4);
     if($this->slider_model->deact_slider($id))
        {
         $this->session->set_flashdata('success', 'Slider status changed Succesfully.');
          redirect('admin/slider/manageslider');
        }
}
public function activate_slider(){
    $id = $this->uri->segment(4);
     if($this->slider_model->active_slider($id))
        {
         $this->session->set_flashdata('success', 'Slider status changed Succesfully.');
         redirect('admin/slider/manageslider');
        }
}
public function chagesliderorder(){
    //print_r($_POST);
  //  echo $_POST['sliderid'].$_POST['order'];
    $slidertosave = array(
                                      'order'=>  $_POST['order']
                      );
     if ($this->slider_model->updateslider($_POST['sliderid'],$slidertosave)) {
         echo 'Order changed succesfully';
     }
}
}
?>
