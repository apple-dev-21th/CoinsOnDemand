<div class="container white padding_30">

  <div class="row">
    	<div class="col-lg-9 col-md-9 col-xs-9">
        <div class="glossymenu">
        <a class="menuitem submenuheader active about_header" href=""><?php echo $title;?></a>
        <div class="about_content">
            <?php echo $content[0]['page_desc']; ?>
        <div class="clearfix"></div>
        </div>
       
        </div>
        </div>
        <?php $this->load->view('include/sidebar');?>
  </div>
    

</div>