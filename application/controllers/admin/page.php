<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('page_model');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('text');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function add() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('page_id');
            if (empty($_REQUEST['page_description'])) {
                $this->form_validation->set_rules('page_description', 'Page Description', 'required');
            }
            $this->form_validation->set_rules('page_title', 'Page Title', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['main_content'] = 'admin/pages/addpage';
                $this->load->view('admin/include/template', $data);
            } else {
                    $slug= $this->create_unique_slug($this->input->post('page_title'), 'pages');
                    $now = date("Y-m-d H:i:s");
                    $data_to_save = array(
                    'page_title' => $this->input->post('page_title'),
                    'page_desc' => $_REQUEST['page_description'],
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_key' => $this->input->post('meta_keyword'),
                    'meta_desc' => $this->input->post('meta_description'),
                    'menu' => $this->input->post('menuname'),
                    'menu_position' => $this->input->post('menu_position'),
                    'slug' => $slug,
                    'page_status' => '1',
                    'date' => $now
                );
                if ($this->page_model->add_page($data_to_save)) {
                    $this->session->set_flashdata('success', 'Page Inserted Succesfully.');
                    redirect('admin/page/add');
                } else {
                    $this->session->set_flashdata('fail', 'Page not inserted due to some problem please try again later.');
                    redirect('admin/page/add');
                }
            }
        } else {
            $data['main_content'] = 'admin/pages/addpage';
            $this->load->view('admin/include/template', $data);
        }
    }

    public function manage() {
        $data['pages'] = $this->page_model->pages();
        $data['main_content'] = 'admin/pages/managepage';
        $this->load->view('admin/include/template', $data);
    }

    public function activate_page() {
        $id = $this->uri->segment(4);
        if ($this->page_model->activepage($id)) {
            $this->session->set_flashdata('success', 'Page Status Updated Succesfully.');
          redirect('admin/page/manage');
        }
    }

    public function deact_page() {
        $id = $this->uri->segment(4);
        if ($this->page_model->deavtivatepage($id)) {
            $this->session->set_flashdata('success', 'Page Status Updated Succesfully.');
         redirect('admin/page/manage');
        }
    }

    public function edit_page() {
        $id = $this->uri->segment(4);
        $data['page'] = $this->page_model->getpagedata($id);
        $data['main_content'] = 'admin/pages/editpage';
        $this->load->view('admin/include/template', $data);
    }

    public function updatepage() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
//echo $_REQUEST['page_description']; 
//$_POST['page_description']=$_REQUEST['page_description'];
    //        echo $this->input->post('page_description',TRUE); die;
            $id = $this->input->post('page_id');
            if (empty($_REQUEST['page_description'])) {
                $this->form_validation->set_rules('page_description', 'Page Description', 'required');
            }
            $this->form_validation->set_rules('page_title', 'Page Title', 'required');
            if ($this->form_validation->run() == FALSE) {
                 $data['page'] = $this->page_model->getpagedata($id);
                $data['main_content'] = 'admin/pages/editpage';
                $this->load->view('admin/include/template', $data);
            } else {
                $now = date("Y-m-d H:i:s");
                 $slug= $this->create_unique_slug($this->input->post('page_title'), 'pages');
                $data_to_save = array(
                    'page_title' => $this->input->post('page_title'),
                    'page_desc' => $_REQUEST['page_description'],
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_key' => $this->input->post('meta_keyword'),
                    'meta_desc' => $this->input->post('meta_description'),
                    'menu' => $this->input->post('menuname'),
                    'menu_position' => $this->input->post('menu_position'),
                    'slug' => $slug,
                    'date' => $now
                );
                if ($this->page_model->updatepage($id, $data_to_save)) {
                    $this->session->set_flashdata('success', 'Page Updated Succesfully.');
                    redirect('admin/page/manage');
                } else {
                    $this->session->set_flashdata('fail', 'Page Not updated please try again later');
                    redirect('admin/page/manage');
                }
            }
        }
    }

    public function delete_page() {
        $id = $this->uri->segment(4);
        if ($this->page_model->deltepages($id)) {
            $this->session->set_flashdata('success', 'Page Deleted Succesfully');
            redirect('admin/page/manage');
        }
    }

    public function addfaq() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if (empty($_REQUEST['answer'])) {
                $this->form_validation->set_rules('answer', 'Answer', 'required');
            }
            $this->form_validation->set_rules('question', 'Question', 'required');
                 if ($this->form_validation->run() == FALSE) {
                $data['faq_order'] = $this->page_model->countfaq();
                $data['main_content'] = 'admin/pages/addfaq';
                $this->load->view('admin/include/template', $data);
            } else {
                $now = date("Y-m-d H:i:s");
                $data_to_save = array(
                    'question' => $this->input->post('question'),
                    'answer' => $_REQUEST['answer'],
                    'status'=>'1',
                    'order'=>$this->input->post('faq_order'),
                    'date'=>$now
                );
                if($this->page_model->addfaq($data_to_save))
                {
                    $this->session->set_flashdata('success','Question Inserted succesfully');
                    redirect('admin/page/addfaq');
                }
            }
        } else {
            $data['faq_order'] = $this->page_model->countfaq();
            $data['main_content'] = 'admin/pages/addfaq';
            $this->load->view('admin/include/template', $data);
        }
    }
   public function managefaq()  {
       $data['faq'] = $this->page_model->faqs();
        $data['main_content'] = 'admin/pages/managefaq';
        $this->load->view('admin/include/template', $data);
   }
 public function edit_faq(){
     $id = $this->uri->segment(4);
        $data['faq_order'] = $this->page_model->countfaq();
        $data['faq'] = $this->page_model->getfaqdata($id);
        $data['main_content'] = 'admin/pages/editfaq';
        $this->load->view('admin/include/template', $data);
     
 }
 public function deact_faq(){
      $id = $this->uri->segment(4);
        if ($this->page_model->deactfaq($id)) {
            $this->session->set_flashdata('success', 'FAQ Status Updated Succesfully.');
          redirect('admin/page/managefaq');
        }
     
 }
  public function activate_faq(){
      $id = $this->uri->segment(4);
        if ($this->page_model->activefaq($id)) {
            $this->session->set_flashdata('success', 'FAQ Status Updated Succesfully.');
          redirect('admin/page/managefaq');
        }
     
 }
 public function delete_faq(){
     $id = $this->uri->segment(4);
        if ($this->page_model->deltefaq($id)) {
            $this->session->set_flashdata('success', 'FAQ Deleted Succesfully');
            redirect('admin/page/managefaq');
        }
     
 }
 public function updatefaq()
 {
  if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('faqid');
            if (empty($_REQUEST['answer'])) {
                $this->form_validation->set_rules('answer', 'Answer', 'required');
            }
            $this->form_validation->set_rules('question', 'Question', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                 $data['faq_order'] = $this->page_model->countfaq();
                 $data['faq'] = $this->page_model->getfaqdata($id);
                $data['main_content'] = 'admin/pages/editfaq';
                $this->load->view('admin/include/template', $data);
            } else {
                $now = date("Y-m-d H:i:s");
                $data_to_save = array(
                    'question' => $this->input->post('question'),
                    'answer' => $_REQUEST['answer'],
                    'order'=>$this->input->post('faq_order'),
                    'date' => $now
                );
                if ($this->page_model->updatefaq($id, $data_to_save)) {
                    $this->session->set_flashdata('success', 'FAQ Updated Succesfully.');
                    redirect('admin/page/managefaq');
                } else {
                    $this->session->set_flashdata('fail', 'FAQ Not updated please try again later');
                    redirect('admin/page/managefaq');
                }
            }
        }
     
 }
  public function create_unique_slug($string, $table)
{
    $slug = url_title($string);
    $slug = strtolower($slug);
    $i = 0;
    $params = array ();
    $params['slug'] = $slug;
    if ($this->input->post('page_id')) {
        $params['id !='] = $this->input->post('page_id');
    }
    
    while ($this->db->where($params)->get($table)->num_rows()) {
        if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
            $slug .= '-' . ++$i;
        } else {
            $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
        }
        $params ['slug'] = $slug;
        }
    return $slug;
}
}

?>
