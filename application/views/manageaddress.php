<div class="container white padding_30">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu"> <a headerindex="0h" class="menuitem submenuheader about_header" href="">Manage Addresses</a>
                <div class="col-md-6 col-sm-6 cl-xs-6 review_text1">
                    <br>
                    <span class="review_text"> Manage  Billing Address</span>            
                    <hr>
                    <p><?php
                        echo $this->session->userdata('user');
                        echo "&nbsp" . $this->session->userdata('last_name');
                        ?> <br>
                        <?php
                        if (!empty($address)) {
                              $ct =  explode('-', $address['0']['country']); 
                              $st =  explode('-', $address['0']['state']); 
                            echo $address['0']['address'];
                           echo '<br>';
                            echo $address['0']['city'] . ',';
                            echo "&nbsp" . $st['0'];
                            echo "&nbsp" . $address['0']['post_code'];
                            echo "<br>" . $ct['0'];
                            echo '</p> <p>';
                            echo "Phone: " . $address['0']['phone'];
                        }
                        ?></p>
                    <p><a href="<?php echo base_url(); ?>manageaddress/billingaddress" class="seeall">Edit</a></p>
                </div>
                <div class="col-md-6 col-sm-6 cl-xs-6 review_text1">
                    <br>
                    <span class="review_text"> Manage  Shipping Address</span>            
                    <hr>
                    <p><?php
                        if (!empty($shipping)) {
                             $ct_s =  explode('-', $shipping['0']['country']); 
                              $st_s =  explode('-', $shipping['0']['state']); 
                            echo $shipping['0']['fname'] . ' ' . $shipping['0']['lname'];
                            echo '<br>';
                            echo $shipping['0']['address'] . ' ' . $shipping['0']['address2'];
                            echo '<br>';
                            echo $shipping['0']['city'] . ',';
                            echo "&nbsp" . $st_s['0'];
                            echo "&nbsp" . $shipping['0']['zip'];
                            echo "<br>" . $ct_s['0'];
                            echo '</p><p>' . "Phone: " . $shipping['0']['phone'];
                        }
                        ?></p>
                    <p><a href="<?php echo base_url(); ?>manageaddress/shipingaddress" class="seeall">Edit</a></p>
                </div>
            </div>
        </div>
<?php $this->load->view('include/profilesidebar'); ?>
    </div>
</div>