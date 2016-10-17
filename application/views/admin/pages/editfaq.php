<div id="contentHeader">
    <h1>Edit FAQ</h1>
    <div id="contentHeaderBevel"></div></div>
<div class="container">
    <div class="grid-24">
        <div class="widget">
            <div class="widget-content">
                <br>
                <?php if (validation_errors()) { ?>
            <div class="notify notify-error">
                <a href="javascript:;" class="close">×</a>
                <h3>Error Notifty</h3>
               <?php echo validation_errors(); ?>
            </div>
<?php     
} 
$this->load->view('admin/include/flash');
?>
                <?php echo form_open('admin/page/updatefaq',array('class' => 'form uniformForm')); ?>
                <!-- <form class="form uniformForm" action="" enctype="multipart/form-data" method="post"> -->
                    <div class="field-group">
                        <label for="email">Question</label>
                        <div class="field">
                            
                            <input type="text" value="<?php echo $faq[0]['question']; ?>" name="question" id="question" size="80">	
                        </div>
                    </div>
                    <div class="field-group">
                        <label for="file_name">Answer</label>
                        <div class="field">
                            <textarea name="answer" id="editor1"  class="ckeditor" ><?php echo $faq[0]['answer']; ?> </textarea>	
                        </div> <!-- .field -->
                    </div>
                  <div class="field-group">
                        <label for="email">Order</label>
                        <div class="field">
                        <select name="faq_order" >
                                                        <option value="">Select Order</option>
                            <?php for($i=1;$i<=$faq_order;$i++){  ?>
                                <option value="<?php echo $i; ?>" <?php if ($faq[0]['order'] == $i) {echo 'selected="selected"'; }  ?>><?php echo $i; ?></option>
                            <?php  } ?>
                        </select>
                    </div>
                    </div>
                    <div class="actions">
                        <input type="hidden" name="faqid" value="<?php echo $faq[0]['id']; ?>" >
                        <button class="btn btn-primary" type="submit" >Update FAQ</button>
                    </div>
              <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>

