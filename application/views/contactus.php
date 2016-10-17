<div class="container white padding_30">

    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu">

                <a headerindex="0h" class="menuitem submenuheader about_header" href="">Contact Us</a>
                <br>
                <!--  <form role="form" class="form-horizontal"> -->
                <?php
                $this->load->view('include/flash');
                echo $this->session->flashdata('captcha_validation');
                if (isset($captcha_validation) && $captcha_validation == 'failed') {
                    echo '<div class="alert alert-danger fade in">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h3>Error Notifty</h3>
        <p>Verification code mismatch please eneter again</p>
    </div>';
                }
                if (validation_errors()) {
                    ?>
                    <div class="alert alert-danger fade in">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Error:</strong> <?php echo validation_errors(); ?>
                    </div>
                <?php
                }
                $attributes = array('class' => 'form-horizontal');
                echo form_open('contactus/sendmail', $attributes);
                ?>
                <div class="form-group">
                    <label class="col-md-offset-2 col-sm-2 control-label contact_label" for="inputEmail3">Name :</label>
                    <div class="col-sm-6">
                        <input type="text" id="inputEmail3" class="form-control contact_text" name="name" required value="<?php echo set_value('name'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-2 col-sm-2 control-label contact_label" for="inputEmail3">Email :</label>
                    <div class="col-sm-6">
                        <input type="email" id="inputEmail3" class="form-control contact_text" name="email" required value="<?php echo set_value('email'); ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-2 col-sm-2 control-label contact_label" for="inputEmail3">Phone :</label>
                    <div class="col-sm-6">
                        <input type="text" id="inputEmail3" class="form-control contact_text" name="number" value="<?php echo set_value('number'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-2 col-sm-2 control-label contact_label" for="inputEmail3">Message :</label>
                    <div class="col-sm-6">
                        <textarea rows="6" class="contact_textarea" name="message"><?php echo set_value('message'); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-2 col-sm-2 control-label contact_label" for="inputEmail3">Verification Code: </label>
             <div class="col-sm-6"> <span style="font-size: 18px;"> <?php echo $captcha; ?></span>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-2 col-sm-2 control-label contact_label" for="inputEmail3">&nbsp;</label>
                    <div class="col-sm-6">
                        <input type="text" id="inputEmail3" class="form-control contact_text" name="captcha" placeholder="Please enter the verification code to securely send your email">        
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-4">
                        <button class="btn submit_btn" type="submit">Submit</button>
                    </div>
                </div>  

<?php echo form_close(); ?>


            </div>
        </div>
<?php $this->load->view('include/sidebar'); ?>






    </div>


</div>
