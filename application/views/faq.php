<div class="container white padding_30">

    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu">
<?php foreach($content as $faq)  { ?>
                <a class="menuitem submenuheader active faq_questions" href=""><span class="plus">+</span><span class="minus">-</span><?php echo $faq['question'];?> </a>
                <div class="submenu faq_answers">
                    <p><?php echo $faq['answer'];?></p>
                    <div class="clearfix"></div>
                </div>
<?php } ?>
            </div>
        </div>
        <?php $this->load->view('include/sidebar');?>
        
    </div>


</div>
