<div style="display: none">
    <img src="<?php echo base_url(); ?>assets/images/paypal.gif">
    <img src="<?php echo base_url(); ?>assets/images/purchase.png">
</div>
<style>
    #auth_net {
        margin-top: 10px;
    }
    .wdth_70{
        width: 183px;
        line-height: 20px;
    }
    .review_text1{
        margin-bottom:15px;
        line-height: 20px;
    }
    .no_btnstyles {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: 0 none;
    }
    .newstyle {
        /*        border: 2px solid #666666;*/
        border-radius: 4px;
        float: left;
        margin-top: 15px;
        padding: 5px 16px;
        width: 400px;
        margin-bottom: 20px;
    }
    .newstyle span {
        margin: 0 10px;
    }
    #auth_form_add{ display: none;}
    #paypal_form_add{ display: none;}
    .pricingstyle p{
        margin-bottom: 0px;
        color: #666666;
    }
    .pricingstyle p:last-child{
        margin-top: 20px;
        color: #E2863D;
    }
    .pricingstyle span{
        float: right;
        text-align: left;
        width: 75px;
        margin-left: 10px;
    }
    .twoselectdiv select {
        width: 47% !important;
    }
    .twoselectdiv select:last-child {
        margin-left: 6px;
    }
</style>
<?php
$shippingprice = '0';
$boxprice = 0;
$boxquantity = 0;
$goldplatedprice = 0;
@$singlegoldplatedprice = 0;
$subtotal = 0;
$goldplatedprice = 0;
$jfk_count = 0;
//$subtotal = $this->session->userdata("SubTotal");
/* $giftboxtotal = 0;
  for ($i = 1; $i <= 5; $i++) {
  $boxprice = $this->session->userdata("price_box$i") * $this->session->userdata("coinbox$i");
  $giftboxtotal = $giftboxtotal + $boxprice;
  } */
?>


<div class="container ">
    <div class="white padding_30">
        
    <div class="btn-group btn-group-lg cartcategories">
        <a href="<?php echo base_url(); ?>personalizedcoin/shoppingcart">Shopping Cart</a>
        <a href="<?php echo base_url(); ?>checkout">Billing</a>
        <a href="<?php echo base_url(); ?>shipping">Shipping</a>
        <a class="active" href="javascript:;">Review Order</a>
        <!--        <a href="javascript:;">Payment</a>-->
        <a href="javascript:;">Checkout Complete</a>
    </div>
    <br><br>
    <div class="glossymenu">
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger fade in">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Error:</strong> <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php $this->load->view('include/flash'); ?>
        <div class="shop_header">Review Order</div>
        <div class="shop_container">
            <!--            <div class="review">You're almost done! if every thing looks good, click "pay using credit card or pay using PayPal""</div>-->
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="review_text ">Email :</span> <?php echo $this->session->userdata('emailid'); ?> &nbsp;<a href="<?php echo base_url(); ?>myprofile" class="text_1">(Edit)</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="review_text">Billing Address : </div>
                    <div class="review_text1">
                        <?php
                        $user_id = $this->session->userdata('user_id');
                        echo $this->session->userdata('user');
                        echo "&nbsp" . $this->session->userdata('last_name');
                        if (!empty($address['0']['address'])) {
                            $ct = explode('-', $address['0']['country']);
                            $st = explode('-', $address['0']['state']);
                            ?>
                            <br> <?php echo $address['0']['address']; ?>
                            <br><?php echo $address['0']['city']; ?>, <?php echo $st['0']; ?>,<?php echo $address['0']['post_code']; ?>
                            <br><?php echo $ct['0']; ?>
                            <br> Phone : <?php
                            echo $address['0']['phone'];
                        } else {
                            echo '<br>' . 'Update your billing address';
                        }
                        ?>
                        <a href="<?php echo base_url(); ?>checkout/">(Edit)</a></div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="review_text">Shipping Address : </div>
                    <div class="review_text1">
                        <?php
                        if (!empty($shipping['0']['fname'])) {
                            $ct_s = explode('-', $shipping['0']['country']);
                            $st_s = explode('-', $shipping['0']['state']);
                            ?>
                            <?php echo $shipping['0']['fname'] . ' ' . $shipping['0']['lname'] ?> <br>
                            <?php echo $shipping['0']['address'] . ' ' . $shipping['0']['address2'] ?><br>
                            <?php
                            echo $shipping['0']['city'];
                            echo ", " . $st_s['0'];
                            echo "," . $shipping['0']['zip'];
                            echo '<br>' . $ct_s['0'];
                            echo "<br> Phone : " . $shipping['0']['phone'];
                        } else {
                            echo '<br>' . 'Update Shipping Address';
                        }
                        ?>
                        <a href="<?php echo base_url(); ?>shipping">(Edit)</a></div>
                </div>
                <div class="col-md-4 colsm-4 col-xs-4">
                </div>
            </div>
            </br>
            <div class="row">
                <div class="table-responsive">
                    <table class="table shop">
                        <tbody>
                        </tbody><tbody>
                            <tr>
                                <th width="30%">Description </th><th width="20%"></th><th width="14%">Price</th><th width="15%">Quantity</th><th width="12%">Total</th>
                            </tr>
                            <?php
                            $coins = 0;
                            foreach ($this->cart->contents() as $items):
                                ?>
                                <tr>
                                    <td width="">
                                        <div style="position:relative; height:150px; width:150px;">
                                            <img src="<?php echo $items['options']['finalcoin']; ?>" style="width:98%;height:98%;float:left;z-index:1;position:absolute; <?php if($items['type_coin'] == 'eagle') { ?> margin-top: 6px; margin-left: 4px; width: 91%; height: 91%;<?php }?>">
                                            <?php if ($items['options']['Gold Plated'] == 'yes') { ?> <!-- If coin is Gold-->
                                                <img src="<?php echo base_url(); ?>con_front_gold.png" style="width:144px;float:left;position:absolute;left:0px;z-index:1;top: 2px;">
                                                <img src="<?php echo base_url(); ?>back_gold.jpg" style="width:137px;float:left;position:absolute;left:119px;z-index:0;top:3px;">
                                            </div>
                                        </td>
                                        <td><p>24KT Gold Plated  <br/>JFK Personalized Coin <br><small>Item# <?php echo $items['id']; ?></small></p></td>
                                        <td>$<?php
                                        $gold_price = $Gold_price->gold_price;
                                            echo $this->cart->format_number($items['price'] + $gold_price);
                                            $thiscoinprice = $items['qty'] * ($items['price'] + $gold_price );
                                            $jfk_count = $jfk_count + $items['qty'];
                                            ?></td>
                                    <?php } else { ?>  <!-- If coin is Silver-->
                                <img src="<?php echo base_url(); ?>outer_new_1.png" style="width:144px;float:left;position:absolute;left:0px;z-index:1;top: 2px;">
                                <?php if($items['type_coin'] == 'eagle') {?>
                                <img src="<?php echo base_url(); ?>assets/img/eagle-back-cart.png" style="width:144px;float:left;position:absolute;left:119px;z-index:0;top:3px;">
                                <?php }else {?>
                                <img src="<?php echo base_url(); ?>assets/img/back.jpg" style="width:137px;float:left;position:absolute;left:119px;z-index:0;top:3px;">
                                <?php }?>
                                </td>
                                
                                <?php if($items['type_coin'] == 'eagle') {?>
                                	<td><p>Silver Eagle <br> <small>Item# <?php echo $items['id']; ?></small></p></td>
                                <?php }else { $jfk_count = $jfk_count + $items['qty']; ?>
                                	<td><p>Standard   <br/>JFK Personalized Coin <br> <small>Item# <?php echo $items['id']; ?></small></p></td>
                                <?php }?>
                                <td>$<?php
                                    //2015.02.25 changed by frank
                                    if ($items['options']['Gold Plated'] == 'yes') {
                                        $totalprice =  $this->cart->format_number($thiscoinprice);
                                    } else {
                                        $totalprice = $this->cart->format_number($items['subtotal']);
                                    }

                                    if ($items['type_coin'] == 'eagle') {
                                        echo number_format((float)$totalprice/$items['qty'], 2, '.', '');
                                    }else {
                                        echo $items['price'];
                                    }

                                    ?></td>
                            <?php } ?>
                            <td><?php
                                echo $items['qty'];
                                $coins = $coins + $items['qty'];
                                ?></td>
                            <td>$<b><?php
                                    if ($items['options']['Gold Plated'] == 'yes') {
                                        echo $this->cart->format_number($thiscoinprice);
                                        $subtotal = $subtotal + $thiscoinprice;
                                    } else {
                                        echo $this->cart->format_number($items['subtotal']);
                                        $subtotal = $subtotal + $items['subtotal'];
                                    }
                                    ?>
                                </b></td>
                            </tr>
                        <?php endforeach; ?>

                <?php
                $giftboxtotal = 0;
                for ($i = 1; $i <= 5; $i++) {
                    if ($this->session->userdata("eagle_coinbox$i") != 0) {
                        if ($i == 1) {
                            $cointype = "Single";
                        } elseif ($i == 2) {
                            $cointype = "Two";
                        } elseif ($i == 3) {
                            $cointype = "Three";
                        } elseif ($i == 4) {
                            $cointype = "Eight";
                        } else {
                            $cointype = "Fifteen";
                        }
                        ?>
                        <tr> <!-- eagle coin box  display start here-->
                            <td width="">
                                <img src="<?php echo base_url(); ?>assets/img/coinbox<?php echo $i; ?>.png
                                              " style="width:150px;float:left;z-index:999;position:relative">
                            </td>
                            <td>
                                <p>
                                    <?php echo $cointype; ?> Coin Box<?php echo ' : American Eagle Coin Box'; ?> <br><small>Item# 998563</small>
                                </p>
                            </td>
                            
                            <td>$<?php echo $this->session->userdata("eagle_price_box$i"); ?></td>
                            <td><?php echo $this->session->userdata("eagle_coinbox$i"); ?></td>
                            <td><b><?php
                                    $boxprice = $this->session->userdata("eagle_price_box$i") * $this->session->userdata("eagle_coinbox$i");
                                    echo '$'.$this->cart->format_number($boxprice);
                                    $giftboxtotal = $giftboxtotal + $boxprice;
                                    ?></b></td>
                        </tr>
                        <?php
                    }
                }
                
                for ($i = 1; $i <= 5; $i++) {
                    if ($this->session->userdata("jfk_coinbox$i") != 0) {
                        if ($i == 1) {
                            $cointype = "Single";
                        } elseif ($i == 2) {
                            $cointype = "Two";
                        } elseif ($i == 3) {
                            $cointype = "Three";
                        } elseif ($i == 4) {
                            $cointype = "Eight";
                        } else {
                            $cointype = "Fifteen";
                        }
                        ?>
                                        <tr> <!-- jfk coin box  display start here-->
                                            <td width="">
                                                <img src="<?php echo base_url(); ?>assets/img/coinbox<?php echo $i; ?>.png
                                                              " style="width:150px;float:left;z-index:999;position:relative">
                                            </td>
                                            <td>
                                                <p>
                                                    <?php echo $cointype; ?> Coin Box<?php echo ' : JFK Half Dollar Coin Box'; ?> <br><small>Item# 998563</small>
                                                </p>
                                            </td>
                                            
                                            <td>$<?php echo $this->session->userdata("jfk_price_box$i"); ?></td>
                                            <td><?php echo $this->session->userdata("jfk_coinbox$i"); ?></td>
                                            <td><b><?php
                                                    $boxprice = $this->session->userdata("jfk_price_box$i") * $this->session->userdata("jfk_coinbox$i");
                                                    echo '$'.$this->cart->format_number($boxprice);
                                                    $giftboxtotal = $giftboxtotal + $boxprice;
                                                    ?></b></td>
                                        </tr>
                                        <?php
                                    }
                                }
                ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <hr>
                <?php
                $totalprice = $subtotal + $giftboxtotal;
                ?><?php
                if (isset($st_s['1']) && $st_s['1'] == 'NY') {
                    $tax = $totalprice * 8.625 / 100;
                    if ($this->session->userdata('discount_type')) {
                        if ($this->session->userdata('discount_type') == 'jfk') {
                            if ($jfk_count == 1) $tax = '0.00';
                        }
                    }
                } else {
                    $tax = '0.00';
                } // Shipping calculation
                if ($ct_s['1'] == 'US' || $ct_s['1'] == 'PR') {
                    $shipping = '0.00';
                } elseif ($ct_s['1'] == 'CA') {
                    $shipping = '9.95';
                } else {
                    $shipping = '24.95';
                }
                $taxdata = array('tax' => $tax, 'shipping' => $shipping);
                $this->session->set_userdata($taxdata);
                $gtotal = $totalprice + $tax + $shipping;
                $disc = '0.00';
                if ($this->session->userdata('discount_type')) {
                    if ($this->session->userdata('discount_type') == '%') {
                        $disc = $totalprice * $this->session->userdata('discount_value') / 100;
                        $grand_total = $gtotal - $disc;
                    }else if ($this->session->userdata('discount_type') == 'jfk'){
                        $disc = $this->session->userdata('discount_value');
                        $grand_total = $gtotal - $this->session->userdata('discount_value');
                    } else {
                        $disc = $this->session->userdata('discount_value');
                        $grand_total = $gtotal - $this->session->userdata('discount_value');
                    }
                } else {
                    $grand_total = $gtotal;
                }
                $disc_amount = array(
                    'disc_amount' => $disc,
                    'sub_total' => $totalprice,
                    'g_total' => $grand_total
                );
                $this->session->set_userdata($disc_amount);
                ?>
                <div class="col-md-4 colsm-4 col-xs-4 col-md-offset-8 pricingstyle text-right">

                    <p><b>Subtotal : </b><span>$ <?php echo $this->cart->format_number($totalprice); ?></span></p>
                    <p><b>Shipping : </b><span>$ <?php echo $this->cart->format_number($shipping); ?></span></p>
                    <p><b>Tax :</b> <span>$ <?php echo $this->cart->format_number($tax); ?></span></p>
                    <p><b>  Discount  :</b>$ <span> <?php
                            echo $this->cart->format_number($disc);
                            ?></span></p>
                    <p class="review_text3">Total to be paid : <span><?php
                            //echo $this->cart->format_number($grand_total);
                            $isPaymentshow = true;

                            if ($grand_total <= 0) {
                                echo "Free";
                                $isPaymentshow = false;
                            } else {
                                echo "$ " . $this->cart->format_number($grand_total);
                            }
                            ?></span></p></div>
            </div>
        </div>
        <div class="clearfix"> </div>

        <?php
        if ($isPaymentshow) {
            ?>

            <div class="shop_header">Payment</div>
            <div class="shop_container" >
                <div class="newstyle clearfix">
                    <span>   <input type="radio" name="auth_net" id="paypal">  PayPal <img src="<?php echo base_url(); ?>assets/images/small_paypal.gif" /></span>
                    <br>
                    <span> <input type="radio" name="auth_net" id="auth_net">  Credit Card <img src="<?php echo base_url(); ?>assets/img/credit_card_logo.jpg" /></span>
                </div>
                <div class="clearfix"></div>
                <div id="auth_form">
                    <div id="auth_form_add">  <!-- Authorize.net form start here-->
                        <div class="shop_container" style="border:none;">
                            <div class="row">
                                <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>review_order/authorizenet_pay" id="auth_payment">
                                    <div class="col-lg-8 pad_30 col-md-6 col-xs-8">
                                        <div class="form-group ">
                                            <label for="inputEmail3" class="col-sm-4 control-label contact_label">Credit Card Type :</label>
                                            <div class="col-sm-7 card_type">
                                                <select class="form-control shop_select2"  required="required" name="card_type" id="card_type">
                                                    <option value="">Select Credit Card Type</option>
                                                    <option value="Visa" <?php
        if (set_value('card_type') == 'Visa') {
            echo 'selected="selected"';
        }
            ?>>Visa</option>
                                                    <option value="Mastercard" <?php
                                                if (set_value('card_type') == 'Mastercard') {
                                                    echo 'selected="selected"';
                                                }
            ?>> Mastercard </option>
                                                    <option value="American Express" <?php
                                                if (set_value('card_type') == 'American Express') {
                                                    echo 'selected="selected"';
                                                }
            ?>>American Express</option>
                                                    <option value="Discover" <?php
                                                if (set_value('card_type') == 'Discover') {
                                                    echo 'selected="selected"';
                                                }
            ?>>Discover</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label for="inputEmail3" class="col-sm-4 control-label contact_label">Card Number :</label>
                                            <div class="col-sm-7 card_number">
                                                <input type="text" class="form-control contact_text" id="card_number" name="card_number" required="required" value="<?php echo set_value('card_number'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label contact_label">
                                                Card Expiration :</label>
                                            <div class="col-sm-7 twoselectdiv">
                                                <select class="form-control shop_select"  required="required" name="exp_month">                                                <option value="">Month</option>
                                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php
                                                if (set_value('exp_month') == $i) {
                                                    echo 'selected = "selected"';
                                                }
                                                        ?>><?php echo $i; ?></option>
                                                            <?php } ?>
                                                </select>
                                                <select class="form-control shop_select shop_select1" name="exp_year" required="required">
                                                    <option value=""> Year</option>
                                                    <?php
                                                    $year = date("Y");
                                                    for ($j = $year; $j <= $year + 20; $j++) {
                                                        ?>
                                                        <option value="<?php echo $j; ?>" <?php
                                                if (set_value('exp_year') == $j) {
                                                    echo 'selected = "selected"';
                                                }
                                                        ?>><?php echo $j; ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label contact_label">CVV :</label>
                                            <div class="col-sm-8">
                                                <input type="text" required="required" class="form-control contact_text wdth_125" id="cvv" name="cvv" value="<?php echo set_value('cvv'); ?>">
                                                <a  data-toggle="modal" data-target="#cvv1" id="cvvtoggle1" href='javascript:;' class="whatthislink" > (What is this) </a>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?php echo $this->cart->format_number($grand_total); ?>" name="amount">
                                    </div>
                                    <button type="button" class="btn submit_btn pull-right margin_top_20 " style="margin-top: 50px;" id="auth_payment_submit" >Place Order</button>
                                </form>
                            </div>
                        </div> <!--Authorize.net form ends here -->
                        <!--  -->
                        <!-- Pay Pal form Start here-->
                        <div id="paypal_form_add">
        <form action="https://www.paypal.com/cgi-bin/webscr" name="paypal_form" method="post">
                                <input type="hidden" value="2" name="rm">
                                <input type="hidden" value="_xclick" name="cmd">
                                <input type="hidden" name="currency_code" value="USD" />
                                <input type="hidden" value="info@personalizedcoins.com" name="business">
                                <input type="hidden" value="<?php echo base_url(); ?>checkout_complete/success" name="return">
                                <input type="hidden" value="<?php echo base_url('checkout_complete/index1'); ?>?OrderId=<?php echo $this->session->userdata('order_id'); ?>" name="notify_url">
                                <input type="hidden" value="<?php echo base_url('review_order'); ?>" name="cancel_return">
                                <input type="hidden" value="<?php echo $this->session->userdata('user'); ?>" name="first_name" id="first_name">
                                <input type="hidden" value="<?php echo $this->session->userdata('last_name'); ?>" name="last_name" id="last_name">
                                <input type="hidden" value="<?php echo $coins; ?> Coin" name="item_number" id="item_number">
                                <input type="hidden" value="<?php echo $shipping; ?>" name="shipping" id="shipping">
                                <input type="hidden" value="Personalized Coins " name="item_name" id="item_name">
                                <input type="hidden" value="<?php echo $this->cart->format_number($grand_total - $shipping); ?>" name="amount">

                                <button class="btn submit_btn pull-right margin_top_20 ">Place Order</button>
                            </form>
                        </div>
                        <!-- Pay Pal form Ends here-->
                    </div>
                </div>
           

            <?php
        } else {
            ?>
   
        <div class="shop_container" >
            <div class="row">
                <button class="btn placeFreeOrder submit_btn  pull-right margin_top_20 " onclick="window.location.href = '<?php echo base_url(); ?>review_order/free_pay'">Place Order</button>
            </div>
        </div>
    <?php
}
?>
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

        $('#auth_payment_submit').click(function() {
            var cc = document.getElementById('card_number').value;
            var card_type = document.getElementById('card_type').value;
            var check = 0;
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>review_order/getcardtype/',
                data: {creditcard_number: cc, type: card_type},
                success: function(data) {
                    if (data == 1)
                    {
                        $("#auth_payment").submit();
                        //return true;
                    } else {
                        jQuery('.card_type').append("<p class='text-danger'>Card type does not match credit card number.</p>");
                        jQuery('.card_number').append("<p class='text-danger'>Please enter a valid credit card number.</p>");
                        return false;
                    }
                }
            });
        });
</script>

<div class="modal fade" id="cvv1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">What is CVV ? </h4>
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