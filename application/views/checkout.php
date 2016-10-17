<?php 
if(set_value('cardnumber') != ''){
$cradnumber= set_value('cardnumber');
} else {$cradnumber = $this->session->userdata('card_number'); }
if(set_value('cardholdname') != ''){
$cradholder= set_value('cardholdname');
} else {$cradholder = $this->session->userdata('card_holder_name'); }
if(set_value('month') != ''){
$expmonth= set_value('month');
} else {$expmonth = $this->session->userdata('expiry_month'); }
if(set_value('year') != ''){
$expyear= set_value('year');
} else {$expyear = $this->session->userdata('expiry_year'); }
if(set_value('cvv') != ''){
$cvv= set_value('cvv');
} else {$cvv = $this->session->userdata('cvv'); }

?>
<div class="container ">
    <div class=" white padding_30">
	 <div class="btn-group btn-group-lg cartcategories">
        <a  href="<?php echo base_url(); ?>personalizedcoin/shoppingcart">Shopping Cart</a>
        <a  class="active" href="<?php echo base_url(); ?>checkout">Billing</a>
        <a href="<?php echo base_url(); ?>shipping"> Shipping</a>
        <a href="<?php echo base_url(); ?>review_order" >
         Review Order</a>
<!--                  <a href="javascript:;">Payment</a>-->
        <a href="javascript:;">Checkout Complete</a>
    </div>
  <br><br>
    <div class="glossymenu">
    <div class="shop_header">Billing Information </div>
    <div class="shop_container">
    <div class="row">
       <?php
                    $attributes = array('class' => 'form-horizontal');
                    if (empty($address)) {
                        echo form_open('checkout/addaddress', $attributes);
                    } else {
                        echo form_open('checkout/updateaddress', $attributes);
                    }
                    ?> 
                    <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger fade in">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Error:</strong> <?php echo validation_errors(); ?>
                    </div>
                    <?php }
                    $this->load->view('include/flash'); 
                ?>  
    	<div class="col-lg-6 border_right pad_30 col-md-6 col-xs-6">
          
          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">First Name :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" name="fname" value="<?php  echo $this->session->userdata('user'); ?>" id="inputEmail3" class="form-control contact_text">
                            </div>
                        </div>
            <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Last Name :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" name="lname" value="<?php echo $this->session->userdata('last_name'); ?>" id="inputEmail3" class="form-control contact_text">
                            </div>
                        </div>
        
             <div class="form-group">
            <label class="col-sm-4 control-label contact_label" for="inputEmail3">Phone :</label>
            <div class="col-sm-8">
              <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php  if(!empty($address)){ echo $address['0']['phone']; }else { echo set_value('phone'); }?>" name="phone">
            </div>
          </div>
       
        </div>
        <div class="col-lg-6 pad_30 col-md-6 col-xs-6">
        	<div class="form-group">
            <label class="col-sm-4 control-label contact_label" for="inputEmail3"> Address :</label>
            <div class="col-sm-8">
              <input type="text" id="inputEmail3" class="form-control contact_text" name="billingadd" value="<?php  if(!empty($address)){ echo $address['0']['address']; } else { echo set_value('billingadd'); }?>" >
              
            </div>
          </div>
              <div class="form-group">
            <label class="col-sm-4 control-label contact_label" for="inputEmail3">City :</label>
            <div class="col-sm-8">
              <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php  if(!empty($address)){ echo $address['0']['city']; } else { echo set_value('city'); } ?> " name="city">
            </div>
          </div>
         
             <div class="form-group">
                            <label class="col-sm-4 control-label contact_label" for="inputEmail3">State/Province :</label>
                            <div class="col-sm-8">
                                <div id="states">
                                    <?php if (!empty($states)) {
                                        if(!empty($address)) {
                                       $st =  explode('-', $address['0']['state']); 
                                        }
                                        ?>
                                        <select class="form-control shop_select wdth_100" name="state">
                                            <option value="">Please select region, state or province</option>
                                            <?php foreach ($states as $state) { ?>
                                                <option value= "<?php echo $state['name'].'-'.$state['iso']; ?>" <?php
                                                if (!empty($address)) {
                                                    if ($state['name'] == $st['0']) {
                                                        echo 'selected="selected"';
                                                    }
                                                }else {
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
                                        <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php if (!empty($address)) {  echo $address['0']['state']; }else {echo set_value('state'); } ?>" name="state">
<?php } ?>
                                </div>
                            </div>
                        </div>
            <div class="form-group">
                            <label class="col-sm-4 control-label contact_label" for="inputEmail3">Country :</label>
                            <div class="col-sm-8">
                                <select class="form-control shop_select wdth_100" name="country" onchange="getstates(this.value);" >
                                    <option value="">Country</option>
                                    <?php foreach ($country as $cntry): ?>
                                        <option value= "<?php echo $cntry['country'].'-'.$cntry['iso']; ?>" <?php
                                        if (!empty($address)) {
                                             $ct =  explode('-', $address['0']['country']); 
                                            if ($cntry['country'] == $ct['0']) {
                                                echo 'selected="selected"';
                                            }
                                        } else {
                                            if ($cntry['iso3'] == 'USA') {
                                                echo 'selected="selected"';
                                            }
                                        }
                                        ?> > <?php echo $cntry['country']; ?></option>

<?php endforeach;
?>
                                </select> 

                            </div>
                        </div>
            
                      <div class="form-group">
            <label class="col-sm-4 control-label contact_label" for="inputEmail3">Postal Code :</label>
            <div class="col-sm-8">
              <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php  if(!empty($address)){ echo $address['0']['post_code']; } else { echo set_value('post_code'); } ?>" name="post_code">
            </div>
          </div>
         <div class="checkbox col-md-offset-4 pull-right">
                        <label>
                            <input type="checkbox" name="diff_shippingadrs" id="guest_shippingadrs"> Ship to same address
                        </label>
                    </div>
        </div>
            <button type="submit" class="btn submit_btn pull-right margin_top_15">Next</button>
        </form>
    </div>
    <div class="clearfix"></div>
    </div>
    
    </div>
</div>
</div>