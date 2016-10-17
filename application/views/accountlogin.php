<?php
$password = $this->input->cookie('password');
$uname = $this->input->cookie('username');
$pwd = $this->encrypt->decode($password);
?>
<div class="container white padding_30">
    <div class="glossymenu">
        <a href="" class="menuitem submenuheader about_header" headerindex="0h">Account Login</a>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="glossymenu">
                <div class="shop_header">New Customer</div>
                <div class="shop_container">
                    <div class="row">
                        <?php
                        $attributes = 'class="form-horizontal"';
                        echo form_open('shipping/guestuser', $attributes);
                        ?>
                            <div class="col-lg-12  pad_30 col-md-12 col-xs-12">
                                Select Checkout option
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="guestuser" value="register"> Create an Account
                                    </label>
                                </div>  
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="guestuser" value="guest"> Guest Checkout
                                    </label>
                                </div> <br> 
                                <p> <span style="color: red" >Create an Account </span> to take advantage of the features and benefits that make shopping easier and more personalized: <b>Faster checkout, Tracking status, Personalized offers, Order history, and much more.</b></p>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn submit_btn mar_top_0">Continue</button>
                                    </div>

                                </div>
                            </div>        
                       <?php echo form_close(); ?>
                    </div>
                    <div class="clearfix"></div>
                </div> 
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="glossymenu">
                <div class="shop_header">Returning Customer</div>
                <div class="shop_container">
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger fade in">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <strong>Error:</strong> <?php echo validation_errors(); ?>
                        </div>
                        <?php
                    }
                    $this->load->view('include/flash');
                    ?>
                    <div class="row">
                        <?php
                        $attributes = 'class="form-horizontal"';
                        echo form_open('signin/login', $attributes);
                        ?>
                        <div class="col-lg-12  pad_30 col-md-12 col-xs-12">

                            <div class="form-group">
                                <label class="col-sm-4 control-label contact_label" for="inputEmail3">Email :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="inputEmail3" class="form-control contact_text" name="username" value="<?php echo $uname; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label contact_label" for="inputEmail3">Password :</label>
                                <div class="col-sm-8">
                                    <input type="password" id="inputEmail3" class="form-control contact_text" name="password" value="<?php echo $pwd; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-md-offset-4">
                                    <button type="submit" class="btn submit_btn margin_top_15">Login</button>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a class="whatthislink1" href="<?php echo base_url('forgotpassword'); ?>">Forgot password?</a>
                                </div>
                            </div>
                        </div>        
                        <?php echo form_close(); ?>
                    </div>
                    <div class="clearfix"></div>
                </div> 
            </div>
        </div>
    </div>



</div>