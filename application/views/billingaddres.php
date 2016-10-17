<div class="container white padding_30">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu"> <a href="" class="menuitem submenuheader about_header" headerindex="0h">Manage Billing Address</a><br><br>
                <div class="row">
                    <?php
                    $attributes = array('class' => 'form-horizontal');
                    if (empty($address)) {
                        echo form_open('manageaddress/addaddress', $attributes);
                    } else {
                        echo form_open('manageaddress/updateaddress', $attributes);
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
                    <div class="col-lg-6 border_right pad_30 col-md-6 col-xs-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label contact_label" for="inputEmail3">Billing Address :</label>
                            <div class="col-sm-8">
                                <input type="text" id="billingadd" class="form-control contact_text" name="billingadd" value="<?php
                                if (!empty($address)) {
                                    echo $address['0']['address'];
                                }
                                ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label contact_label" for="inputEmail3">Phone :</label>
                            <div class="col-sm-8">
                                <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php
                                if (!empty($address)) {
                                    echo $address['0']['phone'];
                                }
                                ?>" name="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label contact_label" for="inputEmail3">Postal Code :</label>
                            <div class="col-sm-8">
                                <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php
                                if (!empty($address)) {
                                    echo $address['0']['post_code'];
                                }
                                ?>" name="post_code">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 pad_30 col-md-6 col-xs-6">

                        <div class="form-group">
                            <label class="col-sm-4 control-label contact_label" for="inputEmail3">City </label>
                            <div class="col-sm-8">
                                <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php
                                if (!empty($address)) {
                                    echo $address['0']['city'];
                                }
                                ?>" name="city">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label contact_label" for="inputEmail3">State/Province :</label>
                            <div class="col-sm-8">
                                <div id="states">
                                    <?php if (!empty($states)) { ?>
                                        <select class="form-control shop_select wdth_100" name="state">
                                            <option value=""> Please select region, state or province</option>
                                            <?php foreach ($states as $state) { ?>
                                                <option value= "<?php echo $state['name'].'-'.$state['iso']; ?>" <?php
                                                if (!empty($address)) {
                                                     $st =  explode('-', $address['0']['state']); 
                                                    if ($state['name'] == $st['0']) {
                                                        echo 'selected="selected"';
                                                    }
                                                }
                                                ?> > <?php echo $state['name']; ?></option>
                                                    <?php }
                                                    ?>
                                        </select> 
                                    <?php } else { ?>
                                        <input type="text" id="inputEmail3" class="form-control contact_text" value="<?php
                                        if (!empty($address)) {
                                            echo $address['0']['state'];
                                        }
                                        ?>" name="state">
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
                        <button type="submit" class="btn submit_btn pull-right margin_top_15">Save</button>
                    </div>

<?php echo form_close(); ?>
                </div>

            </div>
        </div>
<?php $this->load->view('include/profilesidebar'); ?>
        
    </div>
</div>
