<style>
      #auth_form_add{ display: none;}
    #paypal_form_add{ display: none;}
</style>
<div class="container white padding_30">
    <div class="btn-group btn-group-lg cartcategories">
        <a href="<?php echo base_url(); ?>personalizedcoin/shoppingcart">Shopping Cart</a>
       <a href="<?php echo base_url(); ?>checkout">Billing</a>
        <a href="<?php echo base_url(); ?>shipping">Shipping</a>
        <a  href="<?php echo base_url(); ?>review_order">Review Order</a>
        <a class="active"  href="javascript:;">Payment</a>
        <a href="javascript:;">Checkout Complete</a>
    </div>
    <br><br>
    <div class="glossymenu">
        <?php  $this->load->view('include/flash'); ?>
        <div class="shop_header"> Payment Info</div>


        <div class="newstyle clearfix">
            <span> <input type="radio" name="auth_net" id="auth_net">  Pay Using Credit Card</span>

            <span>   <input type="radio" name="auth_net" id="paypal">  Pay Using Pay Pal</span>

        </div>
        <div class="clearfix"></div>
        <div id="auth_form">
            <div id="auth_form_add">  <!-- Authorize.net form start here-->
                <div class="shop_container">
                    <div class="row">
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>review_order/authorizenet_pay">
                            <div class="col-lg-6 pad_30 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label contact_label">Card Number :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control contact_text" id="card_number" name="card_number" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label contact_label">
                                        Card Expiration :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control shop_select" required="required" name="exp_month">
                                            <option>Month</option>
                                            <?php for ($i = 1; $i <= 12; $i++) { ?> 
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option> 
                                            <?php } ?>
                                        </select>
                                        <select class="form-control shop_select shop_select1" name="exp_year" required="required">
                                            <option>Year</option>
                                            <?php
                                            $year = date("Y");
                                            for ($j = $year; $j <= $year + 20; $j++) {
                                                ?>
                                                <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
<?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label contact_label">CVV :</label>
                                    <div class="col-sm-8">
                                        <input type="text" required="required" class="form-control contact_text wdth_125" id="cvv" name="cvv">
                                        <a  data-toggle="modal" data-target="#cvv" href="javascript:;" class="whatthislink" > (What is this) </a>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="<?php echo $this->cart->format_number($this->session->userdata('grand_total')); ?>" name="amount">
                            <button type="submit" class=" pull-right no_btnstyles margin_top_15 marg_btm20">
                                <img src="<?php echo base_url(); ?>assets/images/purchase.png"/>
                            </button>
                        </form>
                    </div>
                    <div class="clearfix">
                    </div>
                </div>
            </div> <!--Authorize.net form ends here -->
            <!-- Pay Pal form Start here-->
            <div id="paypal_form_add">
                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" name="paypal_form" method="post">
                    <input type="hidden" value="2" name="rm">
                    <input type="hidden" value="_xclick" name="cmd">
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="hidden" value="thakurdinesh@gmaial.com" name="business">
                    <input type="hidden" value="<?php echo base_url(); ?>checkout_complete" name="return">
                    <input type="hidden" value="<?php echo base_url('review_order'); ?>" name="cancel_return">
                    <input type="hidden" value="<?php echo $this->session->userdata('user'); ?>" name="first_name" id="first_name">
                    <input type="hidden" value="<?php echo $this->session->userdata('last_name'); ?>" name="last_name" id="last_name">
                    <input type="hidden" value="<?php echo $this->session->userdata('coins'); ?> Coin" name="item_number" id="item_number">
                    <input type="hidden" value="0.00" name="shipping" id="shipping">
                    <input type="hidden" value="Personalized Coins " name="item_name" id="item_name">
                    <input type="hidden" value="<?php echo $this->cart->format_number($this->session->userdata('grand_total')); ?>" name="amount">
                    <button type="submit" class=" pull-right no_btnstyles margin_top_15 marg_btm20"><img src="<?php echo base_url(); ?>assets/images/paypal.gif"/>
                    </button>
                </form>
            </div>
            <!-- Pay Pal form Ends here-->
        </div>
    </div>
</div>
<script>
    $('#auth_net').click(function() {
        if ($('#auth_net').is(':checked')) {
             $("#auth_form_add").show(); 
             $("#paypal_form_add").hide(); 
            
        }

    });
    $('#paypal').click(function() {
        if ($('#paypal').is(':checked')) {
            $("#auth_form_add").hide(); 
             $("#paypal_form_add").show(); 
        }
    });
</script>

<div class="modal fade" id="cvv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">   
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">What is CVV ?</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo base_url(); ?>assets/img/csc_1.gif" >
                <br><br>
                <b> Visa®, Mastercard®, and Discover® cardholders: </b><br><br>
                Turn your card over and look at the signature box. You should see either the entire 16-digit credit card number or
                just the last four digits followed by a special 3-digit code. This 3-digit code is your CVV number / Card Security Code. <br><br>
                <b>American Express® cardholders: </b><br><br>
                Look for the 4-digit code printed on the front of your card just above and to the right of your main credit card number. This 4-digit code is your Card Identification Number (CID). The CID is the four-digit code printed just above the Account Number. <br><br>
                <img src="<?php echo base_url() ?>assets/img/csc_2.gif" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>