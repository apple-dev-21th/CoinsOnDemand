<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url() ?>assets/stylesheets/jsDatePick_ltr.min.css" />
        <script src="<?php echo base_url(); ?>assets/javascripts/jsDatePick.min.1.3.js"></script>
<div id="contentHeader">
    <h1>Add Coupon</h1>
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
                echo form_open_multipart('admin/category/addcoupon', array('class' => 'form uniformForm'));
                ?>
                <div class="field-group">
                    <label for="file_name">Coupon Code:</label>
                    <div class="field">
                        <input type="text" id="c_code" name="c_code" value="<?php echo set_value('c_code'); ?>">
                    </div> 
                </div>
                <div class="field-group">
                    <label for="file_name">Coupon Type :</label>
                    <div class="field">
                        <select id="cardtype" name="disc_type" style="opacity: 0;" onchange="changeField(this);">
                            <option>Select Coupon type</option>
                            <option value="%" <?php if(set_value('disc_type') == '%') { echo 'selected="selected"'; }?>>  %   </option>
                            <option value="fixed" <?php if(set_value('disc_type') == 'fixed') { echo 'selected="selected"'; }?>>   $  </option>
                            <option value="jfk" <?php if(set_value('disc_type') == 'jfk') { echo 'selected="selected"'; }?>>   FREE JFK  </option>
                        </select>
                    </div> 
                </div>
                <div class="field-group" id="div-coupon-amount">
                    <label for="file_name">Coupon amount:</label>
                    <div class="field">
          <input type="text" id="disc_value" name="disc_value" value="<?php echo set_value('disc_value'); ?>">
                    </div> 
                </div>
                <div class="field-group">
                    <label for="file_name">Coupon usage:</label>
                    <div class="field">
  <input type="text" id="max_uses" name="max_uses" value="<?php echo set_value('max_uses'); ?>" placeholder="Enter 0 for unlimited usage">
                    </div> 
                </div>
                <div class="field-group">
                    <label for="file_name">Coupon Multi Use :</label>
                    <div class="field">
                        <select id="cardtype" name="multi_use" style="opacity: 0;">		
                            <option>Select  Multi Use</option>
                            <option value="no" <?php if(set_value('multi_use') == 'no') { echo 'selected="selected"'; }?>>No </option>
                            <option value="yes" <?php if(set_value('multi_use') == 'yes') { echo 'selected="selected"'; }?>>Yes</option>
                        </select>
                    </div> 
                </div>
                  <div class="field-group">
                    <label for="file_name">Coupon unique names :</label>
                    <div class="field">
                        <select id="cardtype" name="unique_name" style="opacity: 0;">		
                            <option>Select  unique names</option>
                            <option value="no" <?php if(set_value('unique_name') == 'no') { echo 'selected="selected"'; }?>>No </option>
                            <option value="yes" <?php if(set_value('unique_name') == 'yes') { echo 'selected="selected"'; }?>>Yes</option>
                        </select>
                    </div> 
                </div>
                  


                <div class="actions">
                    <button class="btn btn-primary" type="submit" >Add Coupon</button>
                </div>
                <?php echo form_close(); ?>
                
            </div>
        </div>
    </div><!-- .grid -->
</div>


<script type="text/javascript">

    function changeField(obj) {
        if (obj.value == 'jfk') {
            $('div#div-coupon-amount').css('display', 'none');
        }else {
            $('div#div-coupon-amount').css('display', 'block');
        }
    }

</script>