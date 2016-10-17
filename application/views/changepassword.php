
<div class="container white padding_30">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu"> <a headerindex="0h" class="menuitem submenuheader about_header" href="">Change Password</a><br><br>
                <div class="row">
                    <div class="col-md-12 col-sm-12 xol-xs-12">
                        <?php
                        $attributes = array('class' => 'form-horizontal');
                      /*  if($location == 'forgotpassword') {
                             echo form_open('myprofile/updatepassword', $attributes);
                        }else {
                       
                        }*/
                         echo form_open('myprofile/updatepassword', $attributes);
                        ?>
                        <?php if (validation_errors()) { ?>
                            <div class="alert alert-danger fade in">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Error:</strong> <?php echo validation_errors(); ?>
                            </div>
                        <?php }
                        $this->load->view('include/flash');
                        ?>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label contact_label">Password</label>
                            <div class="col-sm-6">
                         <input type="password" class="form-control contact_text" id="password"   name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label contact_label">Confirm Password</label>
                            <div class="col-sm-6">
                         <input type="password" class="form-control contact_text" id="cpassword"   name="cpassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-2">
                                <button type="submit" class="btn submit_btn">Update Password</button>
                            </div>
                        </div>  

<?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
<?php $this->load->view('include/profilesidebar'); ?>
    </div>
</div>