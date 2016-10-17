<?php
ob_start();
class Box extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->model('category_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function addbox() {
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $baseurl = base_url();
            $path = './assets/uploads';
            $config['upload_path'] = './assets/uploads';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            if (empty($_FILES['box_image']['name'])) {
                $this->form_validation->set_rules('box_image', 'Box Image Image', 'required');
            }
            $this->form_validation->set_rules('box_name', 'Box Name ', '');
              if ($this->form_validation->run() == FALSE) {
                $data['main_content'] = 'admin/box/addbox';
                $this->load->view('admin/include/template', $data);
            } else {
                $name = $this->uploadimages($_FILES, $path);
                $now = date("Y-m-d H:i:s");
                    $boxdetail = array(
                    'box_image' => $name,
                    'box_name' => $this->input->post('box_name'),
                    'show_home' => $this->input->post('showhome'),
                    'box_url'=>$this->input->post('box_url'),
                    'position'=>$this->input->post('box_order'),
                    'date' => $now
                );
                    
                if ($this->category_model->addbox($boxdetail)) {
                    $this->session->set_flashdata('success', 'Box Inserted Succesfully');
                    redirect('admin/box/addbox');
                }
            }
        } else {
            $data['total_box'] =  $this->category_model->countboxes();
            $data['main_content'] = 'admin/box/addbox';
            $this->load->view('admin/include/template', $data);
        }
    }

    public function managebox() {
        $data['category'] = $this->category_model->getboxes();
        $data['main_content'] = 'admin/box/managebox';
        $this->load->view('admin/include/template', $data);
    }

    public function uploadimages($files, $folder) {
        $allfiles = "";
        $uploadefiles = $files;
        $this->load->helper('date');
        foreach ($uploadefiles as $file => $value) {
            $config['upload_path'] = $folder;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file)) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();
                $allfiles .= $data['file_name'] . ";";
            }
        }
        return substr($allfiles, 0, -1);
    }

    public function deact_box() {
        $id = $this->uri->segment(4);
        if ($this->category_model->deactbox($id)) {
            $this->session->set_flashdata('success', 'Box status changed succesfully.');
            redirect('admin/box/managebox');
        }
    }

    public function activate_box() {
        $id = $this->uri->segment(4);
        if ($this->category_model->actbox($id)) {
            $this->session->set_flashdata('success', 'Box status changed succesfully.');
            redirect('admin/box/managebox');
        }
    }

    public function delete_box() {
        $id = $this->uri->segment(4);
        $data['detail'] = $this->category_model->box_detail($id);
               if ($this->category_model->deletebox($id)) {
            unlink('./assets/uploads/' . $data['detail'][0]['box_image']);
            $this->session->set_flashdata('success', 'Box deleted succesfully.');
            redirect('admin/box/managebox');
        }
    }

    public function edit_box() {
        $id = $this->uri->segment(4);
        $data['total_box'] =  $this->category_model->countboxes();
        $data['detail'] = $this->category_model->box_detail($id);
        $data['main_content'] = 'admin/box/editbox.php';
        $this->load->view('admin/include/template', $data);
    }

    public function updatebox() {
        $id = $this->input->post('box_id');
        $this->form_validation->set_rules('box_name', 'Box  Name ', '');
        if ($this->form_validation->run() == FALSE) {
            $data['detail'] = $this->category_model->category_detail($id);
            $data['main_content'] = 'admin/box/managebox';
            $this->load->view('admin/include/template', $data);
        } else {
            if (empty($_FILES['box_image']['name'])) {
                $now = date("Y-m-d H:i:s");
                $condetail = array(
                    'box_name' => $this->input->post('box_name'),
                    'show_home' => $this->input->post('showhome'),
                    'box_url' => $this->input->post('box_url'),
                    'position'=>$this->input->post('box_order'),
                    'date' => $now
                );
            }
            if (!empty($_FILES['box_image']['name'])) {
                $path = './assets/uploads';
                $name = $this->uploadimages($_FILES, $path);
                $now = date("Y-m-d H:i:s");
                $condetail = array(
                    'box_image' => $name,
                    'box_name' => $this->input->post('box_name'),
                    'show_home' => $this->input->post('showhome'),
                    'position'=>$this->input->post('box_order'),
                    'box_url' => $this->input->post('box_url'),
                    'date' => $now
                );
            }
            if ($this->category_model->updatebox($id, $condetail)) {
                $this->session->set_flashdata('success', 'Box detail updated succesfully.');
                redirect('admin/box/managebox');
            }
        }
    }
}

?>
