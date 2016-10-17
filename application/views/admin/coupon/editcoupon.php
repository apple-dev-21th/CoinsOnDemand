<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url() ?>assets/stylesheets/jsDatePick_ltr.min.css" />
        <script src="<?php echo base_url(); ?>assets/javascripts/jsDatePick.min.1.3.js"></script>
<div id="contentHeader">
    <h1>Edit Coupon</h1>
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
                echo form_open_multipart('admin/category/updatecoupon', array('class' => 'form uniformForm'));
                ?>
                <div class="field-group">
                    <label for="file_name">Coupon Code:</label>
                    <div class="field">
                        <input type="text" id="c_code" name="c_code" value="<?php echo $coupon_detail['0']['code']; ?>">
                    </div> 
                </div>
                <div class="field-group">
                    <label for="file_name">Discount Type :</label>
                    <div class="field">
                        <select id="cardtype" name="disc_type" style="opacity: 0;">		
                            <option>Select discount type</option>
                            <option value="%" <?php if($coupon_detail['0']['discount_type'] == '%') { echo 'selected="selected"'; }?>>  %   </option>
                            <option value="fixed" <?php if($coupon_detail['0']['discount_type'] == 'fixed') { echo 'selected="selected"'; }?>>   Fixed  </option>
                        </select>
                    </div> 
                </div>
                <div class="field-group">
                    <label for="file_name">Discount Value:</label>
                    <div class="field">
          <input type="text" id="disc_value" name="disc_value" value="<?php echo $coupon_detail['0']['discount_value']; ?>"  placeholder="Enter 0 for unlimited usage">
                    </div> 
                </div>
                <div class="field-group">
                    <label for="file_name">Maximum Users:</label>

                    <div class="field">
  <input type="text" id="max_uses" name="max_uses" value="<?php echo $coupon_detail['0']['max_usage']; ?>">
                    </div> 
                </div>
                  <div class="field-group">
                    <label for="file_name">Start Date:</label>

                    <div class="field">
<input type="text" size="20" id="inputField" name="start_date" value="<?php echo $coupon_detail['0']['start_date']; ?>" />
                    </div> 
                </div>
<div class="field-group">
                    <label for="file_name">End Date:</label>

                    <div class="field">
<input type="text" size="20" id="inputField1" name="end_date" value="<?php echo $coupon_detail['0']['end_date']; ?>"  />
                    </div> 
                </div>

                <div class="actions">
                    <input type="hidden" value="<?php echo $coupon_detail['0']['id']; ?>" name="coupon_id" />
                    <button class="btn btn-primary" type="submit" >Update Coupon</button>
                </div>
                <?php echo form_close(); ?>
                
            </div>
        </div>
    </div><!-- .grid -->
</div>
