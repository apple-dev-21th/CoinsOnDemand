<?php 
$page = $this->uri->segment(1); 
$css= 'class="active"';
?>
<div class="col-lg-3 col-md-3 col-xs-3">
            <ul style="max-width: 300px;" class="nav nav-pills nav-stacked faq">
        <li <?php if ($page == 'about') echo $css; ?>><a href="<?php echo base_url(); ?>about">About</a></li>
        <li <?php if ($page == 'privacy-policy') echo $css; ?>><a href="<?php echo base_url(); ?>privacy-policy">Privacy Policy</a></li>
       <li <?php if ($page == 'shippingpolicy') echo $css; ?>><a href="<?php echo base_url(); ?>shipping-policy">Shipping Policy</a></li>
       <li <?php if ($page == 'terms-conditions') echo $css; ?>><a href="<?php echo base_url(); ?>terms-conditions">Terms & Conditions</a></li>
       <li <?php if ($page == 'returnpolicy') echo $css; ?>><a href="<?php echo base_url(); ?>return-policy">Return Policy</a></li>
          <li <?php if ($page == 'faq') echo $css; ?>><a href="<?php echo base_url(); ?>faq">FAQ</a></li>
         <li <?php if ($page == 'contactus') echo $css; ?>><a href="<?php echo base_url(); ?>contact-us">Contact Us</a></li>
          
         
            </ul>
        </div>