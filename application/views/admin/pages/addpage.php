	<div id="elfinder"></div>
<div id="contentHeader">
    <h1>Add Page</h1>
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
                <?php echo form_open('admin/page/add',array('class' => 'form uniformForm')); ?>
                <!-- <form class="form uniformForm" action="" enctype="multipart/form-data" method="post"> -->
                    <div class="field-group">
                        <label for="email">Page Title:</label>
                        <div class="field">
                            <input type="text" value="<?php echo set_value('page_title');?>" name="page_title" id="page_title" size="32">	
                        </div>
                    </div>
                    <div class="field-group">
                        <label for="file_name">Page Description</label>
                        <div class="field">
                            <textarea name="page_description" id="editor1"  class="ckeditor" ><?php echo set_value('page_description')?> </textarea>	
                        </div> <!-- .field -->
                    </div>
                    <div class="field-group">
                        <label for="email">Meta Title:</label>
                        <div class="field">
                            <input type="text" value="<?php echo set_value('meta_title'); ?>" name="meta_title" id="meta_title" size="32">	
                        </div>
                    </div>
                    <div class="field-group">
                        <label for="email">Meta Keywords:</label>
                        <div class="field">
                            <input type="text" value="<?php echo set_value('meta_keyword');  ?>" name="meta_keyword" id="meta_keyword" size="32">	
                        </div>
                    </div>
                    <div class="field-group">
                        <label for="email">Meta Description:</label>
                        <div class="field">
                            <textarea name="meta_description" style="width: 277px; height: 75px;"><?php echo set_value('meta_description'); ?></textarea>	
                        </div>
                    </div>
                  <div class="field-group">		
                    <label>Show in Menu:</label>
                    <div class="field">
                        <select name="menuname" >
                            <option value="">Select Menu</option>
                                <option value="header" >Header </option>
                                 <option value="footer" >Footer </option>
                        </select>
                    </div>		
                </div>
                  <div class="field-group">		
                    <label>Menu Position</label>

                    <div class="field">

                        <select name="menu_position" >
                            <option value="">Select Menu Position</option>
                            <?php for ($m=1;$m<=6;$m++) { ?>
                                <option value="<?php echo $m; ?>"  ><?php echo $m; ?></option>
                            <?php } ?>

                        </select>

                    </div>		
                </div>
                    <div class="actions">
                        <button class="btn btn-primary" type="submit" >Add Page</button>
                    </div>
              <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>


