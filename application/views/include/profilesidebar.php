<?php
$page = $this->uri->segment(1);
$css = 'class="active"';
?>
<div class="col-lg-3 col-md-3 col-xs-3">
    <div class="panel panel-default">
        <div class="panel-heading">My Account</div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked faq" style="max-width: 300px;">
                <li <?php if($page == 'viewmyorder') echo $css; ?>><a href="<?php echo base_url(); ?>viewmyorder">View my Orders</a></li>
                <li <?php if($page == 'myprofile') echo $css; ?> ><a href="<?php echo base_url(); ?>myprofile">My Profile</a></li>
                <li <?php if($page == 'manageaddress') echo $css; ?>><a href="<?php echo base_url(); ?>manageaddress">Manage Addresses</a></li>
            </ul>
        </div>
    </div>
</div>