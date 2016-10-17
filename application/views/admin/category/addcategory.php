<div id="contentHeader">
    <h1>Add Category</h1>
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
                <?php
                //echo form_open('admin/slider/add', array('class' => 'form uniformForm')); 
                echo form_open_multipart('admin/category/addcateg', array('class' => 'form uniformForm'));
                ?>

                <!-- <form class="form uniformForm" action="" enctype="multipart/form-data" method="post"> -->
                <div class="field-group">

                    <label for="file_name">Category Name:</label>

                    <div class="field">
                        <input type="text" id="categ_name" name="categ_name">

                    </div> <!-- .field -->

                </div>
                 <div class="field-group control-group">	
                    <label>ART FRAME :</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1"><span class=""><input type="checkbox" value="1" id="art_frame" name="art_frame" style="opacity: 0;"></span></div>
                        <label for="checkbox1">Yes</label>
                    </div>
                </div>
                <div class="field-group">
                <div id="frame_lib">
                    
                </div>
                </div>
                                 <div class="field-group control-group">	
                    <label>Design Library:</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1"><span class=""><input type="checkbox" value="1" id="design_lib" name="design_lib" style="opacity: 0;"></span></div>
                        <label for="checkbox1">Yes</label>
                    </div>
                </div>
                <div class="field-group">
                <div id="des_lib">
                    
                </div>
                </div>
                  
                <div class="field-group control-group">	
                    <label>Featured:</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1"><span class=""><input type="checkbox" value="1" id="featuredcatg" name="featuredcatg" style="opacity: 0;"></span></div>
                        <label for="checkbox1">Yes</label>
                    </div>
                </div>
                 <div class="field-group control-group">	
                    <label>Status:</label>
                <div class="field">
                <div class="checker" id="uniform-checkbox1">
                    <span class="radio">
            <input type="radio" value="1" id="categ_status" name="categ_status" style="opacity: 0;" checked="checked">
                    </span></div>
                        <label for="checkbox1">Active</label>
                        <div class="checker" id="uniform-checkbox1">
                    <span class="">
            <input type="radio" value="0" id="categ_status" name="categ_status" style="opacity: 0;" >
                    </span></div>
                        <label for="checkbox1">Deactive</label>
                    </div>
                </div>



                <div class="actions">
                    <button class="btn btn-primary" type="submit" >Add Category</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>
<script>
    $('#design_lib').click(function() {
     if($('#design_lib').is(':checked')){
    $('#des_lib').append('<div id="lib_upload"><label for="file_upload">Upload Design LIbrary Category Image:</label><input type="file" id="design_lib_img" name="design_lib_img" size="19" style="opacity: 1;" ></div>');}
else {
    $('#lib_upload').remove();
    }
});
$('#art_frame').click(function() {
     if($('#art_frame').is(':checked')){
    $('#frame_lib').append('<div id="frame_upload"><label for="file_upload">Upload Art Frame Category Image:</label><input type="file" id="front_image" name="front_image" size="19" style="opacity: 1;" ></div>');}
else {
    $('#frame_upload').remove();
    }
});
    </script>
    