<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php

class Select_template extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('front_model');
        $this->load->model('personlised_model');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    public function index() {
        $search = $this->input->post('searchkey');
       if ($page = $this->uri->segment(3)) {
            $id = $this->uri->segment(3);
        } else {
            $id = $this->input->post('catg_id');
        }
        if(empty($id)){
        //    redirect('home');
        }

        // Pagination start here
        $config['per_page'] = 8;
        $config['base_url'] = base_url() . 'select_template/index/' . $id;
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
        $config['uri_segment'] = 4;
        $page = $this->uri->segment(4);
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['count_products'] = $this->front_model->count_products($id, $search); 
        $config['total_rows'] = $data['count_products'];
        $this->pagination->initialize($config);
// Pagination ends here 
        $data['title'] = 'Select template';
        $data['category_name'] = $this->front_model->categoryname($id);
        $data['category'] = $this->front_model->homecategorycoins();
        $data['template'] = $this->front_model->templates($id, $config['per_page'], $limit_end, $search);
      //  echo '<pre>'; print_r($data['template']); die;
        $data['main_content'] = 'selecttemplate';
        $this->load->view('include/template', $data);
    }

    function createsession() {
        $newdata = array(
            'templateid' => $_POST['cointemplate']
        );
        $this->session->set_userdata($newdata);
        echo '1';
    }

    function createimage() {
        $imagename = $_POST['image'];
        $staert = strrpos($imagename, "/") + 1;
        $length = strlen($imagename);
        $name1 = substr($imagename, $staert, $length);
        $name2 =  explode("?",$name1);
        $name =$name2['0'];
        $imgname = 'assets/temp/' . $name;
        $url = base_url() . 'assets/temp/' . $name;
         $this->session->set_userdata('fbimg', $url);
        file_put_contents($imgname, file_get_contents($imagename));
        echo $url;
    }

    public function gettemplatenames() {
        $id = $_POST['categoryid'];
        $data['templatename'] = $this->front_model->templatesname($id);
      
        $dataname = '<select  name="template" class="theme"  id="template" onchange="changetemplate(this.value)"><option>Choose Template from this Categories</option>';
        foreach ($data['templatename'] as $templatename) {
            $dataname .= "<option value='" . $templatename['id'] . "'>" . $templatename["coin_name"] . "</option>";
        }
        $dataname .='</select>';
        echo $dataname;
    }
public function getdesigntemplatename(){
         $id = $_POST['categoryid'];
        $data['templatename'] = $this->front_model->designtemplatesname($id);
        $this->load->view('templateslider', $data);
    }
    public function gettemplatename() {
        $id = $_POST['categoryid'];
        $data['templatename'] = $this->front_model->templatesname($id);
        
        $this->load->view('templateslider', $data);
    }

    public function templatesession() {

        $data['template_detail'] = $this->personlised_model->get_template($_POST['templatename']);
        $templateimg = $data['template_detail'][0]['coin_image'];
        $templatename = $data['template_detail'][0]['coin_name'];
        $templateprice = $data['template_detail'][0]['coin_price'];
        $newdata = array(
            'design_templatimg' => $templateimg,
            'coin_name' => $templatename,
            'templateid' => $_POST['templatename'],
            'coin_price' => $templateprice
        );
        $this->session->set_userdata($newdata);
        echo $templateimg;
    }

    public function finalcoin() {
        $newdata = array(
            'finalcoin' => $_POST['finalcoin']
        );
        $this->session->set_userdata($newdata);
        echo '1';
    }
    
    public function search() {
        $search = $this->input->post('searchkey');
        $id=NULL;
       if ($page = $this->uri->segment(3)) {
           $search = $this->uri->segment(3);
       } 
       //else {
//            $id = $this->input->post('catg_id');
//        }
        if(empty($search)){
           redirect(base_url());
        }
        // Pagination start here
        $config['per_page'] = 8;
        $config['base_url'] = base_url() . 'select_template/search/'.$search;
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
        $config['uri_segment'] = 4;
        $page = $this->uri->segment(4);
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['count_products'] = $this->front_model->count_products($id, $search);
        $config['total_rows'] = $data['count_products'];
        $this->pagination->initialize($config);
// Pagination ends here 
        $data['title'] = 'Select template';
        $data['search']=$search;
       $data['category'] = $this->front_model->homecategorycoins();
        $data['template'] = $this->front_model->templates( $id,$config['per_page'], $limit_end, $search);        $data['main_content'] = 'selecttemplate';
        $this->load->view('include/template', $data);
    }
    public function design_template() {
               if ($page = $this->uri->segment(3)) {
            $id = $this->uri->segment(3);
        } else {
            $id = $this->input->post('catg_id');
        }
        if(empty($id)){
        //    redirect('home');
        }

        // Pagination start here
        $config['per_page'] = 8;
        $config['base_url'] = base_url() . 'select_template/design_template/' . $id;
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
        $config['uri_segment'] = 4;
        $page = $this->uri->segment(4);
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        $data['count_products'] = $this->front_model->count_designproducts($id); 
        $config['total_rows'] = $data['count_products'];
        $this->pagination->initialize($config);
// Pagination ends here 
        $data['title'] = 'Select design template';
        $data['category_name'] = $this->front_model->categoryname($id);
        $data['category'] = $this->front_model->designcategory();
        $data['template'] = $this->front_model->designtemplates($id, $config['per_page'], $limit_end);
        $data['main_content'] = 'design_select_template';
        $this->load->view('include/template', $data);
    }
}

?>
