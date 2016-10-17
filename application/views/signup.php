<div class="container white padding_30">

    <div class="glossymenu">
        <div class="shop_header">Register</div>
        <div class="shop_container">
            <div class="row">
                <?php
                $attributes = array('class' => 'form-horizontal');
                echo form_open('signup/register', $attributes);
                ?>

                <div class="col-lg-6  pad_30 col-md-6 col-xs-6 col-md-offset-3">
                    <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger fade in">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Error:</strong> <?php echo validation_errors(); ?>
                    </div>
                    <?php }
                ?>

                    <div class="form-group">
                        <label class="col-sm-4 control-label contact_label" for="inputEmail3">First Name :</label>
                        <div class="col-sm-8">
    <input type="text" id="fistname" class="form-control contact_text" name="fistname" value="<?php echo set_value('fistname'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label contact_label" for="inputEmail3">Last Name :</label>
                        <div class="col-sm-8">
<input type="text" id="lastname" class="form-control contact_text" name="lastname" value="<?php echo set_value('lastname'); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label contact_label" for="inputEmail3">Email :</label>
                        <div class="col-sm-8">
                            <input type="text" id="email" class="form-control contact_text" name="email" value="<?php echo set_value('email'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label contact_label" for="inputEmail3">Password :</label>
                        <div class="col-sm-8">
                            <input type="password" id="password" class="form-control contact_text" name="password" value="<?php echo set_value('password'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
   <label class="col-sm-4 control-label contact_label" for="inputEmail3"> Confirm Password :</label>
                        <div class="col-sm-8">
                            <input type="password" id="conpassword" class="form-control contact_text" name="conpassword" value="<?php echo set_value('conpassword'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-md-offset-4">
                            <button type="submit" class="btn submit_btn margin_top_15">Register</button>
                        </div>
                    </div>
                </div>        
<?php echo form_close(); ?>
            </div>
            <div class="clearfix"></div>
        </div>


    </div>


</div>