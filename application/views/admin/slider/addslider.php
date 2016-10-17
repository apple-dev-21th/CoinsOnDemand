<div id="contentHeader">
    <h1>Add Slider</h1>
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
                <?php //echo form_open('admin/slider/add', array('class' => 'form uniformForm')); 
                echo form_open_multipart('admin/slider/add', array('class' => 'form uniformForm'));
                ?>
                
                <!-- <form class="form uniformForm" action="" enctype="multipart/form-data" method="post"> -->

                <div class="field-group">

                    <label for="file_upload">Upload:</label>

                    <div class="field">
                        <div class="uploader" id="uniform-file_upload">
                <input type="file" id="slider_image" name="slider_image" size="19" style="opacity: 0;" ><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div>

                    </div> <!-- .field -->

                </div>
                 <div class="field-group">
                        <label for="email">Order</label>
                        <div class="field">
                        <select name="slider_order" >
                                                        <option value="">Select Order</option>
                            <?php for($i=1;$i<=$total_slider+1;$i++){  ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php  } ?>
                        </select>
                    </div>
                    </div>



                <div class="actions">
                    <button class="btn btn-primary" type="submit" >Add Slider</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>

