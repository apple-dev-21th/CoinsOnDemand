<div id="contentHeader">
    <h1>Change Password</h1>
    <div id="contentHeaderBevel"></div></div>
<div class="container">
    <div class="grid-24">
        <div class="widget">
            <div class="widget-content">
                <br>
                <?php if (validation_errors()) { ?>
            <div class="notify notify-error">
                <a href="javascript:;" class="close">×</a>
                <h3>Error Notifty</h3>
               <?php echo validation_errors(); ?>
            </div>
<?php     
} 
$this->load->view('admin/include/flash');
?>
                <?php echo form_open('admin/changepassword/updatepassword',array('class' => 'form uniformForm')); ?>
                    <div class="field-group">
                        <label for="email">Old Password:</label>
                        <div class="field">
                            <input type="password"  name="old_password" id="old_password" size="32">	
                        </div>
                    </div>
                   
                    <div class="field-group">
                        <label for="email">New Password:</label>
                        <div class="field">
                            <input type="password" name="new_password" id="new_password" size="32">	
                        </div>
                    </div>
                    <div class="field-group">
                        <label for="email">Confirm New Password:</label>
                        <div class="field">
                            <input type="password"  name="conf_password" id="conf_password" size="32">	
                        </div>
                    </div>
                   
                    <div class="actions">
                        <button class="btn btn-primary" type="submit" >Submit</button>
                    </div>
              <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>


