<div class="container white padding_30">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php
            $attributes = 'class="form-horizontal"';
            echo form_open('guest_checkout/register', $attributes);
            ?>
            <div class="glossymenu">
                <div class="shop_header">Guest Checkout Step 1  <span style="float: right; margin-right: 200px"> Billing Address</span></div>
                <div class="shop_container">
                    <div class="row">

                        <?php if (validation_errors()) { ?>
                            <div class="alert alert-danger fade in">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Error:</strong> <?php echo validation_errors(); ?>
                            </div>
                        <?php }
                        ?>
                        <div class="col-lg-6 border_right pad_30 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">First Name :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_fname" name="guest_fname" value="<?php echo set_value('guest_fname'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Last Name :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_lname" name="guest_lname" value="<?php echo set_value('guest_lname'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" id="label_email">Email :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="email" onKeyUp="emailValidator(this.value)" onBlur="emailValidator(this.value)" class="form-control contact_text" id="guest_email" name="guest_email" value="<?php echo set_value('guest_email'); ?>">
                                </div>
                            </div>
                            <script>
                              function emailValidator(email)
                              	{
                                  var pattern = /^[-\w.]+@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,4}$/;


                                 if(!pattern.test(email))
                                     {
                                         $("#guest_email").css('color','red');
                                         $("#label_email").text('Email :').css('color','red');
                                     }
                                  else
                                      {
                                      	$("#guest_email").css('color','green');
                                      	$("#label_email").text('Email :').css('color','green');
                                      	$("#group_guest_email_re").show();
                                      }
                              	}
                            </script>
                            <div class="form-group" id="group_guest_email_re" style="display: none;">
                                <label for="inputEmail4" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label" id="label_email_re">Email Confirm:</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="email" onKeyUp="emailCompare()" onBlur="emailCompare()" class="form-control contact_text" id="guest_email_re" name="guest_email_re" value="<?php echo set_value('guest_email'); ?>">
                                </div>
                            </div>
                            <script>
                              function emailCompare(email_re)
                              	{
                                  var email    = $("#guest_email").val();
                                  var email_re = $("#guest_email_re").val();

                                 if(email == email_re)
                                     {
                                     	$("#group_guest_email_re").hide();
                                     	$("#submit").get(0).type = 'submit';
                                     }
                                  else
                                      {
                                      	$("#guest_email_re").css('color','red');
                                      	$("#submit").get(0).type = 'button';
                                      }

                              	}
                            </script>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Phone :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_phone" name="guest_phone" value="<?php echo set_value('guest_phone'); ?>">
                                </div>
                            </div>
<!--                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Fax :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_fax" name="guest_fax" value="<?php //echo set_value('guest_fax'); ?>">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Company :<small class="help-block" >(Optional)</small></label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_company" name="guest_company" value="<?php echo set_value('guest_company'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 pad_30 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Address 1 :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_adrs1" name="guest_adrs1" value="<?php echo set_value('guest_adrs1'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Address 2 : <small class="help-block" >(Optional)</small></label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_adrs2" name="guest_adrs2" value="<?php echo set_value('guest_adrs2'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">City :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_city" name="guest_city" value="<?php echo set_value('guest_city'); ?>">
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">State/Province :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                               <div id="states">      
 <select class="form-control shop_select wdth_100" name="state"><option value="" >Please select region, state or province </option>
                                    <?php foreach ($states as $state) { ?>
                                        <option value= "<?php echo $state['name'].'-'.$state['iso']; ?>" <?php
                                            if ($state['name'] == set_value('state')) {
                                                echo 'selected="selected"';
                                            }
                                        ?> > <?php echo $state['name']; ?></option>
<?php }
?>
                                </select>
                               </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="col-sm-4 control-label contact_label" for="inputEmail3">Country :</label>
                            <div class="col-sm-8">
                                <select class="form-control shop_select wdth_100" name="country" onchange="getstates_guest(this.value);" >
                                    <option value="">Country</option>
                                    <?php foreach ($country as $cntry): ?>
                                        <option value= "<?php echo $cntry['country'].'-'.$cntry['iso']; ?>" <?php
                                           if ($cntry['iso3'] == 'USA') {
                                                echo 'selected="selected"';
                                        }
                                        ?> > <?php echo $cntry['country']; ?></option>

<?php endforeach;
?>
                                </select> 

                            </div>
                        </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Postal Code :</label>
                                <div class="col-sm-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control contact_text" id="guest_postcode" name="guest_postcode" value="<?php echo set_value('guest_postcode'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="shippingaddress"> </div>
                    <div class="checkbox col-md-offset-4 pull-right">
                        <label>
                            <input type="checkbox" name="guest_shippingadrs" id="guest_shippingadrs" <?php if (isset($guest_shipping) && $guest_shipping == '1') {
                            echo 'checked';
                        } ?>> Check if you have separate Shipping Address
                        </label>
                    </div>
                    <!-- Row ends here-->
                    <div class="clearfix"></div>
                </div>
                <a href="<?php echo base_url(); ?>shipping/login" class="btn submit_btn pull-left margin_top_15" type="submit">Back</a>
                <button class="btn submit_btn pull-right margin_top_15" type="submit" id="submit">Continue</button>
<?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $('#guest_shippingadrs').click(function() {
        if ($(this).is(':checked')) {
            addhtml();
        } else {
            $("#guestform").remove();
        }
    });
    function addhtml() {
        $("#shippingaddress").html('<div class="col-md-12 col-sm-12 col-xs-12" id="guestform"><div class="glossymenu"><div  class=" shop_header" headerindex="0h">Guest Shipping Address</div><br><br><div class="form-horizontal"><div class="col-lg-6 border_right pad_30 col-sm-6 col-xs-6"><div class="form-group"><label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">First Name :</label><div class="col-sm-8 col-sm-8 col-xs-8"><input type="text" class="form-control contact_text" id="inputEmail3" value="<?php echo set_value('fname'); ?>"  name="fname"></div></div><div class="form-group"><label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Last Name :</label><div class="col-sm-8 col-sm-8 col-xs-8"><input type="text" class="form-control contact_text" id="inputEmail3" name="lname" value="<?php echo set_value('lname'); ?>" ></div></div><div class="form-group"><label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Phone :</label><div class="col-sm-8 col-sm-8 col-xs-8"><input type="text" class="form-control contact_text" id="inputEmail3" name="phone" value="<?php echo set_value('phone'); ?>"></div> </div></div><div class="col-lg-6 pad_30 col-sm-6 col-xs-6"><div class="form-group"><label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Address 1 :</label><div class="col-sm-8 col-sm-8 col-xs-8"><input type="text" class="form-control contact_text" id="inputEmail3" name="address1" value="<?php echo set_value('address1'); ?>" ></div></div><div class="form-group"><label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Address 2 :<small class="help-block" >(Optional)</small></label><div class="col-sm-8 col-sm-8 col-xs-8"><input type="text" class="form-control contact_text" id="inputEmail3" name="address2" value="<?php echo set_value('address2'); ?>"></div></div><div class="form-group"><label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">City :</label><div class="col-sm-8 col-sm-8 col-xs-8"><input type="text" class="form-control contact_text" id="inputEmail3" value="<?php echo set_value('city'); ?>" name="city"></div></div><div class="form-group"><label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">State/Province :</label><div class="col-sm-8 col-sm-8 col-xs-8"><div id="states1"><select class="form-control shop_select wdth_100" name="state_shipping"><option value ="" >Please select region, state or province</option><?php foreach ($states as $state) { ?><option value= "<?php echo $state['name'].'-'.$state['iso']; ?>" <?php if ($state['name'] == set_value('state_shipping')) { echo 'selected="selected"';}?> > <?php echo $state['name']; ?></option><?php }?></select></div></div></div><div class="form-group"><label class="col-sm-4 control-label contact_label" for="inputEmail3">Country :</label><div class="col-sm-8"><select class="form-control shop_select wdth_100" name="country_shipping" onchange="getstates_guest_shipping(this.value);" ><option value="">Country</option><?php foreach ($country as $cntry): ?><option value= "<?php echo $cntry['country'].'-'.$cntry['iso']; ?>" <?php if ($cntry['iso3'] == 'USA') {echo 'selected="selected"';}?>> <?php echo $cntry['country']; ?></option><?php endforeach;?></select></div></div><div class="form-group"><label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Postal Code :</label><div class="col-sm-8 col-sm-8 col-xs-8"><input type="text" class="form-control contact_text" id="inputEmail3" value="<?php echo set_value('zip'); ?>" name="zip"></div></div></div></div>');
    }
    if ($("#guest_shippingadrs").is(':checked')) {
        addhtml();
    }
</script>
 <script type="text/javascript">
                                        function getstates_guest(id) {
                                            var parameter = "regionid=" + id;
                                            //alert(parameter);
                                            $.ajax({
                                                type: "POST",
                                                url: '<?php echo base_url(); ?>/guest_checkout/getstates',
                                                data: parameter,
                                                success: function(data) {
                                                    $("#states").html(data);
                                                }
                                            });
                                        }
                                        function getstates_guest_shipping(id) {
                                            var parameter = "regionid=" + id;
                                            //alert(parameter);
                                            $.ajax({
                                                type: "POST",
                                                url: '<?php echo base_url(); ?>/guest_checkout/getstates_guest_shipping',
                                                data: parameter,
                                                success: function(data) {
                                                    $("#states1").html(data);
                                                }
                                            });
                                        }
</script>