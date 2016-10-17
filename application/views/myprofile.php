
<div class="container white padding_30">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu"> <a headerindex="0h" class="menuitem submenuheader about_header" href="">Personal Information</a><br><br>
                <div class="row">
                    <div class="col-md-12 col-sm-12 xol-xs-12">
                        <?php
                        $attributes = array('class' => 'form-horizontal');
                        echo form_open('myprofile/updateprofile', $attributes);
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
                            <label for="inputEmail3" class="col-sm-2 control-label contact_label">First Name :</label>
                            <div class="col-sm-6">
                                <input type="test" class="form-control contact_text" id="fname"  value="<?php echo $myprofile['0']['first_name']; ?>" name="fname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label contact_label">Last Name :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control contact_text" id="lname" value="<?php echo $myprofile['0']['last_name']; ?>" name="lname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label contact_label">Email :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control contact_text" id="emailid" value="<?php echo $myprofile['0']['email_id']; ?>" name="emailid"><br>
                                <a href="<?php echo base_url(); ?>myprofile/changepassword" class="whatthislink">Change Password</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-2">
                                <button type="submit" class="btn submit_btn">Save</button>
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