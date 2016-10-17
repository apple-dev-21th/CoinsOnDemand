<div id="contentHeader">
    <h1>Edit <?php echo $detail['0']['category_name']; ?>  category</h1>
    <div id="contentHeaderBevel"></div></div>
<div class="container">
    <div class="grid-24">
        <div class="widget">
            <div class="widget-content">
                <?php
                echo form_open_multipart('admin/category/updatecateg', array('class' => 'form uniformForm'));
                ?>
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

                <!-- <form class="form uniformForm" action="" enctype="multipart/form-data" method="post"> -->

                <div class="field-group">

                    <label for="file_upload">Upload Category Image:</label>

                    <div class="field">
                        <div class="uploader" id="uniform-file_upload">
                            <input type="file" id="front_image" name="front_image" size="19" style="opacity: 0;" ><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div>

                    </div> <!-- .field -->

                </div>
                <?php if(!empty($detail['0']['category_image'])) { ?>
                        <div class="widget-content">
                            <img src="<?php echo base_url(); ?>assets/uploads/<?php echo $detail['0']['category_image']; ?>">		
                        </div> <!-- .widget-content -->
                <?php } ?>

                    <div class="field-group">

                    <label for="file_upload">Upload Design Library Image:</label>

                    <div class="field">
                        <div class="uploader" id="uniform-file_upload">
                            <input type="file" id="design_lib_img" name="design_lib_img" size="19" style="opacity: 0;" ><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div>

                    </div> <!-- .field -->

                </div>
                        <?php if(!empty($detail['0']['template_img'])) { ?>
                        <div class="widget-content">
                            <img src="<?php echo base_url(); ?>assets/uploads/<?php echo $detail['0']['template_img']; ?>">		
                        </div>
                        <?php } ?>
               
                
                
                <div class="clear"> </div>
               
                <div class="field-group">

                    <label for="file_name">Category Name:</label>

                    <div class="field">
                        <input type="text" id="categ_name" name="categ_name" value="<?php echo $detail['0']['category_name']; ?>">

                    </div> <!-- .field -->

                </div>
                
                <div class="field-group control-group">	
                    <label>Featured:</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1">
                    <span class="">
            <input type="checkbox" value="1" id="featuredcatg" name="featuredcatg" style="opacity: 0;" <?php if( $detail['0']['featured_catg'] == '1' ) echo 'checked="checked"';?>>
                    </span></div>
                        <label for="checkbox1">Yes</label>
                    </div>
                </div>
                 <div class="field-group control-group">	
                    <label>ART FRAME :</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1"><span class=""><input type="checkbox" value="1" id="art_frame" name="art_frame" style="opacity: 0;" <?php if( $detail['0']['art_frame'] == '1' ) echo 'checked="checked"';?>></span></div>
                        <label for="checkbox1">Yes</label>
                    </div>
                </div>
                     <div class="field-group control-group">	
                    <label>Design Library:</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1">
                    <span class="">
            <input type="checkbox" value="1" id="design_lib" name="design_lib" style="opacity: 0;" <?php if( $detail['0']['design_temp'] == '1' ) echo 'checked="checked"';?>>
                    </span></div>
                        <label for="checkbox1">Yes</label>
                    </div>
                </div>
                
                 <div class="field-group control-group">	
                    <label>Status:</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1">
                    <span class="">
            <input type="radio" value="1" id="categ_status" name="categ_status" style="opacity: 0;" <?php if( $detail['0']['status'] == '1' ){ echo 'checked="checked"';} ?>>
                    </span></div>
                        <label for="checkbox1">Active</label>
                        <div class="checker" id="uniform-checkbox1">
                    <span class="">
            <input type="radio" value="0" id="categ_status" name="categ_status" style="opacity: 0;" <?php if( $detail['0']['status'] == '0' ){ echo 'checked="checked"';} ?>>
                    </span></div>
                        <label for="checkbox1">Deactive</label>
                    </div>

                </div>
                
                <div class="actions">
                    <input type="hidden" name="cate_id" value="<?php echo $detail['0']['id']; ?>" >
                    <button class="btn btn-primary" type="submit" >Update Category</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>