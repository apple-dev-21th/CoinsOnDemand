<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php

class More_themes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('front_model');
        $this->load->model('personlised_model');
        $this->load->library('pagination');
        $this->load->library('session');
    }
     public function index() {
         // Pagination start here
        $config['per_page'] = 8;
        $config['base_url'] = base_url() . 'more_themes/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul class="pagination pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['prev_link'] = '«';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
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
        $data['count_products'] = $this->front_model->countcoincategory();
        $config['total_rows'] = $data['count_products'];
        $this->pagination->initialize($config);
// Pagination ends here 
        
         $data['title'] = "More Themes";
         $data['category'] = $this->front_model->coincategory($config['per_page'], $limit_end);
         $data['main_content'] = 'categories';
        $this->load->view('include/template', $data);
     }
     public function design_library(){
         $config['per_page'] = 8;
        $config['base_url'] = base_url() . 'more_themes/design_library';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul class="pagination pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['prev_link'] = '«';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
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
        $data['count_products'] = $this->front_model->countdesigncategory();
         $config['total_rows'] = $data['count_products'];
        $this->pagination->initialize($config);
// Pagination ends here 
        
         $data['title'] = "Design Templates";
         $data['category'] = $this->front_model->designcategory($config['per_page'], $limit_end);
         $data['main_content'] = 'design_template';
        $this->load->view('include/template', $data);
     }

}
?>