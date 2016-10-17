<?php
$password = $this->input->cookie('password');
$uname = $this->input->cookie('username');
$pwd = $this->encrypt->decode($password);
?>
<div class="container white padding_30">
    <div class="glossymenu">
        <div class="shop_header">Login</div>
        <div class="shop_container">
            <div class="row">
                <!--    <form role="form" class="form-horizontal">  -->
                <?php
                $attributes = 'class="form-horizontal"';
                echo form_open('signin/login', $attributes);
                ?>
                <div class="col-lg-6  pad_30 col-md-6 col-xs-6 col-md-offset-3">
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger fade in">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <strong>Error:</strong> <?php echo validation_errors(); ?>
                        </div>
                    <?php
                    }
                    $this->load->view('include/flash');
                    ?>
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
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="rember" <?php if (!empty($pwd) && !empty($uname)) {
                        echo 'checked';
                    } ?>> Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <a class="whatthislink1" href="<?php echo base_url('forgotpassword');?>">Forgot password?</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-md-offset-4">
                            <button type="submit" class="btn submit_btn margin_top_15">Login</button>
                        </div>
                    </div>
                </div>        
<?php echo form_close(); ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>