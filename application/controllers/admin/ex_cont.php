<?php  
if ( ! defined('BASEPATH'))  exit('No direct script access allowed');  
?>
<?php class Ex_cont extends CI_Controller
{
     public function elfinder_init()
{
  $this->load->helper('path');
  $opts = array(
    // 'debug' => true, 
    'roots' => array(
      array( 
        'driver' => 'LocalFileSystem', 
        'path'   => set_realpath('assets/uploads'), 
        'URL'    => site_url('assets/uploads') . '/'
        // more elFinder options here
      ) 
    )
  );
  $this->load->library('elfinder_lib', $opts);
}
}
?>