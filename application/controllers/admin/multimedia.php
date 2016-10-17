<?php
class Multimedia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
  
    public function media_ajax()
    {
        $this->load->helper('path');
        $opts = array('roots' => array(array(
                    'driver' => 'LocalFileSystem',
                    'path' => set_realpath('assets/uploads/'),
                    'URL' => base_url('assets/uploads/'))));
        $this->load->library('elfinder_lib', $opts);
    }
 
    public function archivos()
    {
        $this->load->view('admin/tinymce/archivo');
    }
}