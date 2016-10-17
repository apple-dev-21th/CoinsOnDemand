<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>




<?php $this->load->view('admin/include/header'); ?>
	
	<?php $this->load->view('admin/include/sidebar'); ?>
	<div id="content">	
	
	<?php $this->load->view($main_content); ?>
        </div>
	
	
<?php $this->load->view('admin/include/topbar'); ?>
	
	


  <?php $this->load->view('admin/include/footer'); ?>