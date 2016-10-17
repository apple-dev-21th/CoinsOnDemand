<?php  
if ( ! defined('BASEPATH'))  exit('No direct script access allowed');  
?>
<?php class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();   
        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        }
    }
    
    public function index()
   {       
        $data['main_content'] = 'admin/content';
       $this->load->view('admin/include/template', $data);
      
    } 
    
}
?>