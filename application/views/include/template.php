<?php 
$this->load->view('include/header'); 
if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/home' || $_SERVER['REQUEST_URI'] == '/coins/') {
    $this->load->view('include/slider');
}

 $this->load->view($main_content); 
 $this->load->view('include/footer'); 
 ?>   

