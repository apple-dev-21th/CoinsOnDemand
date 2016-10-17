<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Viewmyorder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->library('pagination');
        if (!$this->session->userdata('user_id')) {
            redirect('signin');
        }
    }

    public function index() {
        // ******* Pagination start here  ******* 
        $config['per_page'] = 10;
        $config['base_url'] = base_url() . 'viewmyorder/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 5;
        $config['full_tag_open'] = '<ul class="pagination pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['prev_link'] = '«';
         $config['first_link'] = '»&rsaquo;';
        $config['last_link'] = '«&lsaquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
         $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['uri_segment'] = 3;
        $page = $this->uri->segment(3);
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $user_id = $this->session->userdata('user_id') ;
        $data['count_products'] = $this->order_model->count_order($user_id);
        $config['total_rows'] = $data['count_products'];
        $this->pagination->initialize($config);
        $data['order'] = $this->order_model->getuserorderdetail($user_id,$config['per_page'], $limit_end);
        $data['main_content'] = 'vieworder';
        $data['title'] = "View Orders";
        $this->load->view('include/template', $data);
    }

}

?>
