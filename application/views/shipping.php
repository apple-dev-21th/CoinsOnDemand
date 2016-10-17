<div class="container">
    <div class="white padding_30">
    <div class="btn-group btn-group-lg cartcategories">
        <a href="<?php echo base_url(); ?>personalizedcoin/shoppingcart">Shopping Cart</a>
        <a   href="<?php echo base_url(); ?>checkout">Billing</a>
        <a class="active" href="<?php echo base_url(); ?>shipping">Shipping</a>
        <a href="<?php echo base_url(); ?>review_order">Review Order</a>
        <!--        <a href="javascript:;">Payment</a>-->
        <a href="javascript:;">Checkout Complete</a>
    </div>
    <br><br>
    <div class="glossymenu">
        <div class="shop_header">Shipping Address </div>
        <div class="shop_container">
            <div class="row">
                <?php
                $attributes = array('class' => 'form-horizontal');
                if (empty($shipping)) {
                    echo form_open('shipping/addshipping', $attributes);
                } else {
                    echo form_open('shipping/updateshipping', $attributes);
                }
                ?>
                <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger fade in">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>                        <strong>Error:</strong> <?php echo validation_errors(); ?>
                    </div>
                <?php
                }
                $this->load->view('include/flash');
                ?>
                <div class="col-lg-6 border_right pad_30 col-sm-6 col-xs-6">


                    <div class="form-group">
                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" for="inputEmail3">First Name :</label>
                        <div class="col-sm-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control contact_text" id="inputEmail3" value="<?php if (!empty($shipping)) {  echo $shipping['0']['fname'];  } else {echo set_value('fname'); } ?>" name="fname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" for="inputEmail3">Last Name :</label>
                        <div class="col-sm-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control contact_text" id="inputEmail3"  name="lname"  value="<?php if (!empty($shipping)) {echo $shipping['0']['lname']; } else {echo set_value('lname'); } ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" for="inputEmail3">Phone :</label>
                        <div class="col-sm-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control contact_text" id="inputEmail3" name="phone" value="<?php if (!empty($shipping)) {  echo $shipping['0']['phone']; } else {echo set_value('phone'); } ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pad_30 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" for="inputEmail3">Address :</label>
                        <div class="col-sm-8 col-sm-8 col-xs-8">


                            <input type="text" class="form-control contact_text" id="inputEmail3" name="address1" value="<?php if (!empty($shipping)) { echo $shipping['0']['address']; }else {echo set_value('address1'); } ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" for="inputEmail3">Address 2 : <small class="help-block" >(Optional)</small></label>
                        <div class="col-sm-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control contact_text" id="inputEmail3" name="address2" value="<?php if (!empty($shipping)) {  echo $shipping['0']['address2']; }else {echo set_value('address2'); } ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" for="inputEmail3">City :</label>
                        <div class="col-sm-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control contact_text" id="inputEmail3" value="<?php if (!empty($shipping)) { echo $shipping['0']['city']; }else { echo set_value('city'); } ?>" name="city">
                        </div>
                    </div>
                    <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">State/Province :</label>
                            <div class="col-sm-8">
                                <div id="states">
                                    
                                    <?php
                                    if (!empty($states)) { ?>
                                        <select class="form-control shop_select wdth_100" name="state"><option value="">Please select region, state or province</option>
                                            <?php foreach ($states as $state) { ?>
                                                <option value= "<?php echo $state['name'].'-'.$state['iso']; ?>" <?php
                                                  if (!empty($shipping)) {
                                                        $st =  explode('-', $shipping['0']['state']); 
                                                if ($state['name'] == $st['0']) {
                                                    echo 'selected="selected"';
                                                  } }else { 
                                                       $st1 =  explode('-', set_value('state')); 
                                                    if ($state['name'] == $st1['0']) {
                                                        echo 'selected="selected"';
                                                    } 
                                                  }
                                                ?> > <?php echo $state['name']; ?></option>
                                            <?php }
                                            ?>
                                        </select> 
                                                <?php } else { ?>
                                        <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php
                                        if (!empty($shipping)) { echo $shipping['0']['state']; } else { echo set_value('state'); } ?>" name="state">
                                           <?php } ?>
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-md-4 col-xs-4 control-label contact_label">Country :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                              
                                <select class="form-control shop_select wdth_100" name="country" onchange="getstates(this.value);" >
                                    <option value="">Country</option>
                                    <?php foreach ($country as $cntry): ?>
                                        <option value= "<?php echo $cntry['country'].'-'.$cntry['iso']; ?>" <?php
                                      //  echo $shipping['0']['country']; die;
                                        if (!empty($shipping['0']['country'])) {
                                              $ct =  explode('-', $shipping['0']['country']); 
                                            if ($cntry['country'] == $ct['0']) {
                                                echo 'selected="selected"';
                                            }
                                        }else {
                                            if ($cntry['iso3'] == 'USA') {
                                                echo 'selected="selected"';
                                            }
                                            }
                                        ?> > <?php echo $cntry['country']; ?></option>
                                            <?php endforeach; ?>
                                </select> 
                            </div>
                        </div>

                    <div class="form-group">
                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" for="inputEmail3">Postal Code :</label>
                        <div class="col-sm-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control contact_text" id="inputEmail3" value="<?php if (!empty($shipping)) {  echo $shipping['0']['zip']; } else { echo set_value('zip');} ?>" name="zip">
                        </div>
                    </div>
                   

                </div>
                <button type="submit" class="btn submit_btn pull-right margin_top_15">Next</button>
<?php echo form_close(); ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


</div>
</div>