<div class="container white padding_30">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu"> <a headerindex="0h" class="menuitem submenuheader about_header" href="">Manage Shipping Address</a><br><br>
                <div class="row">
                    <?php
                   
                    
                    $attributes = array('class' => 'form-horizontal');
                    if (empty($shipping)) {
                        echo form_open('manageaddress/addshipping', $attributes);
                    } else {
                        echo form_open('manageaddress/updateshipping', $attributes);
                    }
                    ?>
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger fade in">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <strong>Error:</strong> <?php echo validation_errors(); ?>
                        </div>
                        <?php
                    }
                    $this->load->view('include/flash');
                    ?>
                    <div class="col-lg-6 border_right pad_30 col-sm-6 col-xs-6">


                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">First Name :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control contact_text" id="inputEmail3" value="<?php
                                if (!empty($shipping)) {
                                    echo $shipping['0']['fname'];
                                }
                                ?>" name="fname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Address :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control contact_text" id="inputEmail3" name="address1" value="<?php
                                if (!empty($shipping)) {
                                    echo $shipping['0']['address'];
                                }
                                ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">City :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control contact_text" id="inputEmail3" value="<?php
                                if (!empty($shipping)) {
                                    echo $shipping['0']['city'];
                                }
                                ?>" name="city">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Zip Code :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control contact_text" id="inputEmail3" value="<?php
                                if (!empty($shipping)) {
                                    echo $shipping['0']['zip'];
                                }
                                ?>" name="zip">
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-6 pad_30 col-sm-6 col-xs-6">

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Last Name :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control contact_text" id="inputEmail3" name="lname"value="<?php
                                if (!empty($shipping)) {
                                    echo $shipping['0']['lname'];
                                }
                                ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Address 2 :<small class="help-block" >(Optional)</small></label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control contact_text" id="inputEmail3" name="address2" value="<?php if (!empty($shipping)) {echo $shipping['0']['address2'];}?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">State/Province :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <div id="states">
                                    <?php if (!empty($states)) { ?>
                                        <select class="form-control shop_select wdth_100" name="state"><option>Please select region, state or province </option>
                                            <?php foreach ($states as $state) { ?>
                                                <option value= "<?php echo $state['name'].'-'.$state['iso']; ?>" <?php
                                                  if (!empty($shipping)) {
                                                      $st =  explode('-', $shipping['0']['state']); 
                                                if ($state['name'] == $st['0']) {
                                                    echo 'selected="selected"';
                                                  } }
                                                ?> > <?php echo $state['name']; ?></option>
                                            <?php }
                                            ?>
                                        </select> 
                                                <?php } else { ?>
                                        <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php
                                        if (!empty($shipping)) {
                                            echo $shipping['0']['state'];
                                        }
                                        ?>" name="state">
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
                                        if (!empty($shipping)) {
                                            $ct =  explode('-', $shipping['0']['country']); 
                                            if ($cntry['country'] == $ct['0']) {
                                                echo 'selected="selected"';
                                            }
                                        }
                                            else {
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
                            <label for="inputEmail3" class="col-sm-4 col-sm-4 col-xs-4 control-label contact_label">Phone :</label>
                            <div class="col-sm-8 col-sm-8 col-xs-8">
                                <input type="text" class="form-control contact_text" id="inputEmail3" name="phone" value="<?php
                                if (!empty($shipping)) {
                                    echo $shipping['0']['phone'];
                                }
                                ?>">
                            </div>
                        </div>
                        <button class="btn submit_btn pull-right margin_top_15" type="submit">Save</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>

            </div>
        </div>
        <?php $this->load->view('include/profilesidebar'); ?>
    </div>
</div>