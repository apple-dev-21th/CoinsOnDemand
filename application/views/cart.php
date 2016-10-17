<?php
$error = 0;
if (isset($_GET['qty']) && $_GET['qty'] == '0') {
    $error = 1;
    ?>
    <script> alert('Total quantity in your cart cross the 990 limit, Please enter the quantity below 990');</script>
    <?php
}
if (isset($_GET['qty']) && $_GET['qty'] == '1') {
    if ($this->session->userdata('popup') != '1') {
        $this->session->set_userdata('popup', 1);
        ?>
        <style type="text/css">
            .fade.in {
                opacity: 1;
            }
            .model_1
            {
                border-bottom: none !important;
            }

            .continue
            {
                color:#555 !important;
                text-decoration: underline;
                text-align: center;
                font-size: 14px;
            }
            #myModal { display: block !important;}

        </style>
        <?php
    }
}
?>


<!--[if IE]>
	<style>
		.dblarrow {
			display:none;
		}
	</style>
<![endif]-->

        <style>
            .inc{ height: 14px !important;top: -1px !important;}
            .dec { bottom: 9px !important;height: 14px !important;left: 66% !important;}
            
    
    .dblarrow {
		position:absolute;
		margin-top:-32px;
		margin-left:218px;
	}
	
	.dblarrow b {
		width: 0; 
		height: 0; 
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-bottom: 5px solid black;
	  display: block;
	  margin-bottom: 3px;
	}
	
	.dblarrow i {
		width: 0; 
		height: 0; 
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-top: 5px solid black;
	  display: block;
	}
	
        </style>
<div class="container ">
    <div class="white padding_30">
    <div class="btn-group btn-group-lg cartcategories">
        <a class="active" href="<?php echo base_url(); ?>personalizedcoin/shoppingcart">Shopping Cart</a>
        <a href="<?php echo base_url(); ?>checkout">Billing</a>
        <a href="<?php echo base_url(); ?>shipping" <?php
        if ($error == '1') {
            echo 'onclick="return false;"';
        }
        ?>>Shipping</a>
        <a href="<?php echo base_url(); ?>review_order" <?php
        if ($error == '1') {
            echo 'onclick="return false;"';
        }
        ?> > Review Order</a>
        <!--                  <a href="javascript:;">Payment</a>-->
        <a href="javascript:;">Checkout Complete</a>
    </div>
    <br><br>
    <div class="glossymenu">
        <div class="shop_header">Shopping Cart </div>
        <div class="shop_container">
            <table class="table shop">
                <tbody>
                    <?php
                    $jfk_count = 0;
                    $subtotal = 0;
                    $boxprice = 0;
                    $boxquantity = 0;
                    @$singlegoldplatedprice = 0;
                    //  echo '<pre>';
                    //    print_r($this->cart->contents());
                    // print_r($this->session->userdata);

                    $goldplatedprice = 0;
                    foreach ($this->cart->contents() as $items):
                        @$goldplatedprice = $goldplatedprice + $items['options']['Gold Plating Price'];
                    endforeach;
                    ?>
                <tbody>
                    <tr>
                        <th width="30%">Description </th><th width="34%"></th><th width="15%">Quantity</th><th width="12%">Total</th><th width="15%"></th>

                    </tr>
                    <?php foreach ($this->cart->contents() as $items): ?>

                        <tr>
                            <td width="">
                                <div style="position:relative; height:150px; width:150px;">
                                	<img src="<?php echo $items['options']['finalcoin']; ?>" style="width:98%;height:98%;float:left;z-index:100;position:absolute; <?php if($items['type_coin'] == 'eagle') { ?> margin-top: 5px; margin-left: 3px; width: 91%; height: 89%;<?php }?>">
                                    <?php if ($items['options']['Gold Plated'] == 'yes') { $jfk_count = $jfk_count + $items['qty']; ?> <!-- If coin is Gold-->
                                        	<img src="<?php echo base_url(); ?>con_front_gold.png" style="width:144px;float:left;position:absolute;left:0px;z-index:1;top: 2px;">
                                        	<img src="<?php echo base_url(); ?>back_gold.jpg" style="width:144px;float:left;position:absolute;left:117px;z-index:0;top: 3px;">
                                		</div>
                            			</td>
                            			<td><p>24KT Gold Plated  <br/>JFK Personalized Coin <br><small>Item# <?php echo $items['id']; ?></small></p></td>
                            		<?php } else { ?>  <!-- If coin is Silver-->
                        					<?php if($items['type_coin'] == 'eagle') { ?>
                                                <img src="<?php echo base_url(); ?>assets/img/eagle-back-cart.png" style="width:auto;float:left;position:absolute;left:117px;z-index:0;top: 3px;">
                                                <img src="<?php echo base_url(); ?>assets/img/eagle-back-rim.png" style="width:144px;float:left;position:absolute;left:0px;z-index:1;top: 2px;">
                        						
                        					<?php } else { ?>
                                                <img src="<?php echo base_url(); ?>outer_new_1.png" style="width:144px;float:left;position:absolute;left:0px;z-index:1;top: 2px;">
                        						<img src="<?php echo base_url(); ?>assets/img/back.jpg" style="width:144px;float:left;position:absolute;left:117px;z-index:0;top: 3px;">
                        					<?php } ?>
                        					</div>

                        				</td>
                                        
                                        <?php if($items['type_coin'] == 'eagle') { ?>
                                            <td><p>Silver Eagle <br/> <small>Item# <?php echo $items['id']; ?></small></p></td>
                                        <?php } else { $jfk_count = $jfk_count + $items['qty'];?>

                                            <td><p>Standard   <br/>JFK Personalized Coin <br> <small>Item# <?php echo $items['id']; ?></small></p></td>
                                        <?php } ?>
                    				<?php } ?>
                    		<td>
                    			<div class="incdec">
                            		<input type="text" value="<?php echo $items['qty']; ?>" id="txtBox<?php echo $items['id'] ?>" readonly onchange="updatecoinquanity('<?php echo $items['rowid'] ?>', 'txtBox<?php echo $items['id'] ?>',<?php echo $items['id'] ?>,'<?php echo $items['type_coin'] ?>')" >
                            		<a onclick="doIt(1, 'txtBox<?php echo $items['id'] ?>'), updatecoinquanity('<?php echo $items['rowid'] ?>', 'txtBox<?php echo $items['id'] ?>',<?php echo $items['id'] ?>,'<?php echo $items['type_coin'] ?>');
            return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                            <a onclick="doIt(-1, 'txtBox<?php echo $items['id'] ?>'), updatecoinquanity('<?php echo $items['rowid'] ?>', 'txtBox<?php echo $items['id'] ?>',<?php echo $items['id'] ?>,'<?php echo $items['type_coin'] ?>');
            return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                        </div></td>
                    <td><b>
                            <?php
                            if ($items['options']['Gold Plated'] == 'yes') {  
                                $gold_price = $Gold_price->gold_price;
                                $thiscoinprice = $items['qty'] * ($items['price'] + $gold_price);
                                echo $this->cart->format_number($thiscoinprice);
                                $subtotal = $subtotal + $thiscoinprice;
                            } else {
                                echo $this->cart->format_number($items['subtotal']);
                                $subtotal = $subtotal + $items['subtotal'];
                            }
                            ?>

                        </b></td>
                    <td align="center"><a href="javascript:;" onclick="removeitem('<?php echo $items['rowid'] ?>',<?php echo $items['id'] ?>,'<?php echo $items['type_coin'] ?>')"><img src="<?php echo base_url(); ?>assets/img/cross.png"></a></td>
                    </tr>
                    <?php
                endforeach;
                $this->session->set_userdata('SubTotal', $subtotal);
                ?>

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
                            
                            <td><div class="incdec">
                                    <input type="text" readonly onchange="updateboxquanity('eagle_coinbox<?php echo $i; ?>')" id="eagle_coinbox<?php echo $i; ?>" value="<?php echo $this->session->userdata("eagle_coinbox$i"); ?>">
                                    <a href="#" class="inc" onclick="doIt(1, 'eagle_coinbox<?php echo $i; ?>'), updateboxquanity('eagle_coinbox<?php echo $i; ?>');
                return false;"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                    <a href="#" class="dec" onclick="doIt(-1, 'eagle_coinbox<?php echo $i; ?>'), updateboxquanity('eagle_coinbox<?php echo $i; ?>');
                return false;"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                </div></td>
                            <td><b><?php
                                    $boxprice = $this->session->userdata("eagle_price_box$i") * $this->session->userdata("eagle_coinbox$i");
                                    echo $this->cart->format_number($boxprice);
                                    $giftboxtotal = $giftboxtotal + $boxprice;
                                    ?></b></td>
                            <td align="center"><a href="javascript:;" onclick="removegiftbox('eagle_coinbox<?php echo $i; ?>')"><img src="<?php echo base_url(); ?>assets/img/cross.png"></a></td>
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
                                            <td><div class="incdec">
                                                    <input type="text" readonly onchange="updateboxquanity('jfk_coinbox<?php echo $i; ?>')" id="jfk_coinbox<?php echo $i; ?>" value="<?php echo $this->session->userdata("jfk_coinbox$i"); ?>">
                                                    <a href="#" class="inc" onclick="doIt(1, 'jfk_coinbox<?php echo $i; ?>'), updateboxquanity('jfk_coinbox<?php echo $i; ?>');
                                return false;"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                                    <a href="#" class="dec" onclick="doIt(-1, 'jfk_coinbox<?php echo $i; ?>'), updateboxquanity('jfk_coinbox<?php echo $i; ?>');
                                return false;"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                                </div></td>
                                            <td><b><?php
                                                    $boxprice = $this->session->userdata("jfk_price_box$i") * $this->session->userdata("jfk_coinbox$i");
                                                    echo $this->cart->format_number($boxprice);
                                                    $giftboxtotal = $giftboxtotal + $boxprice;
                                                    ?></b></td>
                                            <td align="center"><a href="javascript:;" onclick="removegiftbox('jfk_coinbox<?php echo $i; ?>')"><img src="<?php echo base_url(); ?>assets/img/cross.png"></a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                ?>
                <tr> <!--  Bottom Part start here-->
                    <td colspan="2">
                        <div class="box_adv">
                            <a href="javascript:;" data-toggle="modal" data-target="#mybox" ><img src="<?php echo base_url(); ?>assets/img/coin_box.jpg" >
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <a class="btn submit_btn pull-left margin_top_15 box_below_grybtn" href="<?php echo base_url(); ?>personalizedcoin/step1" onclick="resetfunction();">Add another Coin</a>

                    </td>
                    <td colspan="2"></td>
                    <td colspan="2" class="promo">
                        <h3>Coupon Code</h3>
                        <form>
                            <input type="text" class="promorcode" id="promorcode">
                            <a class="btn submit_btn pull-left margin_top_15 coupon_code" id="addcoupon" href="javascript:;">Add Coupon</a>
                            <p class="pull-left"><small>Please enter your code, then Click on the "Add Coupon" box to apply.</small></p>
                            <div class="clearfix"></div>
                            <p>Sub Total: <span>$<?php
                                    $totalprice = $this->cart->format_number($subtotal + $giftboxtotal);
                                    echo $this->cart->format_number($totalprice);
                                    ?></span></p>

                            <p>Sales Tax:<span>0.00</span><br> <small>(NY Residents 8.265%)</small> </p>
                            <p>Shipping : <span><b>FREE</b></span></p>
<?php
$disc = '0.00';
if ($this->session->userdata('discount_type')) {
    if ($this->session->userdata('discount_type') == '%') {
        $disc = $totalprice * $this->session->userdata('discount_value') / 100;
        $gtotal = $totalprice - $disc;
    } else {
        $disc = $this->session->userdata('discount_value');
    $gtotal = $totalprice - $this->session->userdata('discount_value');
    }
} else {
    $gtotal = $totalprice;
}
$total = array(
    'giftboxtotal' => $giftboxtotal,
    'coins_total' => $subtotal,
    'sub_total' => $totalprice,
    'disc_amount' => $disc
);
$this->session->set_userdata($total);
?>
                            <p>Discount : <span id="disc"><b>$<?php echo $this->cart->format_number($disc); ?></b></span></p>
                            <p class="text-right" id="remove_disc" <?php
                            if ($disc > 0) {
                                echo "style='display:block'";
                            } else {
                                echo "style='display:none'";
                            }
?>><medium><a href="<?php echo base_url('updatecart/removediscount') ?>">Remove Discount</a></medium></p>

                            <p class="specp">Order Total : <span id="gtotal">$<?php  if($gtotal > 0) { echo $this->cart->format_number($gtotal); }?></span></p>
                            <a class="btn submit_btn pull-left margin_top_15 completeorder" href="<?php echo base_url(); ?>checkout"  <?php
                            if ($error == '1') {
                                echo 'disabled';
                            }
                            ?>>Complete Order</a>
                        </form>


                    </td>
                </tr>
                </tbody>

                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
        
</div>
    </div>


<script type="text/javascript">
    function doIt(toAdd, textbox) {
        var textBox = document.getElementById(textbox);
        var number = parseInt(textBox.value);
        if (number + toAdd == -1 || number + toAdd > 990)
        {
            return false;
        } else {
            textBox.value = number + toAdd;
        }
    }
    function updateboxquanity(boxid) {
        var boxqty = document.getElementById(boxid);
        var number = parseInt(boxqty.value);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>updatecart/updatecoinbox/',
            data: {session: boxid, quantity: number},
            success: function(data) {
                if (data === '1') {
                    window.location.reload();
                }
            }
        });
    }
    function removegiftbox(boxid) {
        if (confirm("Are you sure to remove this giftbox from cart?")) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>updatecart/removegiftbox/',
                data: {sessionid: boxid},
                success: function(data) {
                    if (data === '1') {
                        window.location.reload();
                    }
                }
            });
        }
        return false;
    }
    function updatecoinquanity(id, textbox, rowid,coin_type) {
        var quantitty = document.getElementById(textbox);
        var number = parseInt(quantitty.value);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>updatecart/updateitem/',
            data: {cart: id, quantity: number, rowid: rowid, coin_type : coin_type},
            success: function(data) {
                if (data === '0') {
                    window.location.href = '<?php echo base_url() . "personalizedcoin/shoppingcart/?qty=0"; ?>';
                } else if (data === '2') {
                    window.location.href = '<?php echo base_url() . "personalizedcoin/shoppingcart/?qty=1"; ?>';
                } else {
                    window.location.href = '<?php echo base_url() . "personalizedcoin/shoppingcart"; ?>';
                }
            }
        });
    }
    function removeitem(id, rowid, coin_type) {
        if (confirm("Are you sure to want to delete this coin from cart?")) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>updatecart/removeitem/',
                data: {cart: id, id: rowid, coin_type : coin_type},
                success: function(data) {
                    if (data === '1') {
                        window.location.href = '<?php echo base_url() . "personalizedcoin/shoppingcart"; ?>';
                    }
                }
            });
        }
        return false;
    }
    $('#addcoupon').click(function() {
        var code = document.getElementById('promorcode').value;
        var code = code.replace(/ /g, '');
        if (code.length !== 0) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>updatecart/add_dsicount/',
                data: {coupon_code: code, total: '<?php echo $totalprice; ?>', jfk_count:'<?php echo $jfk_count;?>'},
                success: function(data) {
                    //  alert(data);
                    if (data === '1') {
                        alert('Coupon is Inactive');
                    } else if (data === '2') {
                        alert('Invalid Coupon');
                    } else if (data === '3') {
                        alert('You have already used the coupon for this cart');
                    } else if (data === '4') {
                        alert('Coupon already used');
                    } else if (data==='10'){
                        alert ('This Coupon is only for JFK coin');
                    } else {
                        list = data.split("&");
                        $("#disc").html('$' + list[0]);
                        $("#gtotal").html('$' + list[1]);

                        $grandTotal = $("#gtotal").html();
                        if (list[0] >= $grandTotal) {
                            $("#gtotal").html('Free');
                        }

                        $("#remove_disc").css('display', 'block');
                        window.location.reload();
                    }
                }
            });
        }
    });


    $("#gtotal").change(function(){

        if ($("#gtotal").html() === "$")
        {
            $("#gtotal").html('0.00')
        }
    });
$(document).ready(function(){
    if ($("#gtotal").html() === "$")
        {
            $("#gtotal").html('0.00')
        }
});

</script>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade in" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header model_1">
                <!--        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>-->
                <h2 id="myModalLabel" class="modal-title" style="color:#E2863D; font-weight: bold;">
                    You Now Quality for Special Pricing: </h2>
            </div>
            <div class="modal-body">

                <?php
                $this->db->select('*');
                $this->db->from('coin_pricing');
                $this->db->order_by('min', 'ASC');
                $query = $this->db->get();
                $result = $query->result_array();
                for ($i = 5; $i <= 10; $i++) {
                    echo $result[$i]['min'] . '-' . $result[$i]['max'] . ":              " . $result[$i]['price'] . ' each<br><br>';
                    if ($i == '7') {
                        echo '<br/><div class="clearfix"></div>';
                    }
                }
                ?>
                <i> For pricing on larger quantities please email: <a href="mailto:pricing@ecoins.com">pricing@ecoins.com </a></i>
                <div class="clearfix"></div>
                <br/><br/><br/>
                <i><a href="javascript:;" class="continue closep">Continue Shopping</a></i>
            </div>

        </div>
    </div>
</div>
<script type='text/javascript'>
    jQuery(".closep").click(function() {
        $("#myModal").remove();
        //  $(".modal").remove();
        $('#myModal').css('display', 'none !important');
        //$('.modal').css('display', 'none !important');
        $('.fade.in').css('opacity', '0');
    });
</script>

<div class="modal fade" id="mybox" tabindex="-1" role="dialog" aria-labelledby="myboxLabel" aria-hidden="true">
    <form method="post" action ="<?php echo base_url('updatecart/addgiftbox'); ?>" >
        <div class="modal-dialog model_top">
            <div class="modal-content model_2">
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">Add a High Quality Premium Display Box to your Order </h2>
                    <p>These premium coin boxes are made out of metal and wrapped in soft plush felt. </p>
                    <p>It is a terrific way to display your personalized coin,protect your coin, or to give the coin as a gift.   </p>
                    <h4 style="color: #868686;">3 Different Size Available for your Half Dollar or Silver Eagle :<h4>
                            </div>
                            <div class="modal-body boxes">
                            	<div class="row col-md-1">
                            	</div>
                                <div class="row col-md-4">
						              <div class="box1" style="border: 0px; background-color: #fff;">
						                   <img src='<?php echo base_url();?>assets/img/box1.jpg' style="width: 183px;">
						              </div>
                                    <h5>Single Coin Box</h5>
                                    <p>Box Hold 1JFK
                                        <br/>
                                        Half Dollar
                                        <br/>
                                        $<?php echo $box_price->single_coin_box; ?> each</p>
                                    <div class="incdec" style="margin-left: 67px;">
                                        <input type="text" name="single-coin-box" value="0" readonly id="single-coin-box" >
                                        <a onclick="doIt(1, 'single-coin-box');
        return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                        <a onclick="doIt(-1, 'single-coin-box');
        return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                    </div>
                                </div>
                                <div class="row col-md-4">
						              <div class="box1" style="border: 0px; background-color: #fff;">
						                   <img src='<?php echo base_url();?>assets/img/box2.jpg' style="width: 183px;">
						              </div>
                                    <h5>Two Coin Box</h5>
                                    <p>Box Hold 2JFK
                                        <br/>
                                        Half Dollar
                                        <br/>
                                        $<?php echo $box_price->two_coin_box; ?> each</p>
                                    <div class="incdec" style="margin-left: 67px;">
                                        <input type="text" name="two-coin-box" value="0" readonly id="two-coin-box" >
                                        <a onclick="doIt(1, 'two-coin-box');
        return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                        <a onclick="doIt(-1, 'two-coin-box');
        return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                    </div>
                                </div>
                                <div class="row col-md-4">
						              <div class="box1" style="border: 0px; background-color: #fff;">
						                   <img src='<?php echo base_url();?>assets/img/box3.jpg' style="width: 183px;">
						              </div>
                                    <h5>Three Coin Box</h5>
                                    <p>Box Hold 3JFK
                                        <br/>
                                        Half Dollar
                                        <br/>
                                        $<?php echo $box_price->three_coin_box; ?> each</p>
                                    <div class="incdec" style="margin-left: 67px;">
                                        <input type="text" name="three-coin-box" value="0" readonly id="three-coin-box" >
                                        <a onclick="doIt(1, 'three-coin-box');
        return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                        <a onclick="doIt(-1, 'three-coin-box');
        return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                    </div>
                                </div>
                                <!-- 
                                <div class="row col-md-2">
                                    <div class="box1">
                                        <img src='<?php echo base_url(); ?>assets/img/four_box.png' >


                                    </div>

                                    <h5>Eight Coin Box</h5>
                                    <p>Box Hold 8JFK
                                        <br/>
                                        Half Dollar
                                        <br/>
                                        $<?php echo $box_price->eight_coin_box; ?> each</p>
                                    <div class="incdec">
                                        <input type="text" name="four-coin-box" value="0" readonly id="four-coin-box" >
                                        <a onclick="doIt(1, 'four-coin-box');
        return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                        <a onclick="doIt(-1, 'four-coin-box');
        return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                    </div>
                                </div>
                                <div class="row col-md-2">
                                    <div class="box1">
                                        <img src='<?php echo base_url(); ?>assets/img/five_box.png' >
                                    </div>
                                    <h5>Fifteen Coin Box</h5>
                                    <p>Box Hold 15JFK
                                        <br/>
                                        Half Dollar
                                        <br/>
                                        $<?php echo $box_price->fifteen_coin_box; ?> each</p>
                                    <div class="incdec">
                                        <input type="text" name="five-coin-box" value="0" readonly id="five-coin-box" >
                                        <a onclick="doIt(1, 'five-coin-box');
        return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                        <a onclick="doIt(-1, 'five-coin-box');
        return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                    </div>
                                </div>
                                 -->
                            </div>
                            <div class='clearfix'></div>
	  <div class="modal-body text-center" style="padding-bottom: 0px;">
	  		<div class="form-group">
		  		<span style="font-size:19px; font-weight: bold; color: #E2863D;">Select type of coin box</span>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
				  		<select class="form-control" name="box_coin_type" style="" id="box_coin_type">
				  			<option value="" disabled selected>Select Coin Box</option>
			          		<option value="American Eagle Coin Box">American Eagle Coin Box</option>
			          		<option value="JFK Half Dollar Coin Box">JFK Half Dollar Coin Box</option>
			            </select>	
			            <?php if ((isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) || (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false))) {?>
			            <?php }else{?>
			            	<div class="dblarrow"><b></b><i></i></div>
			            <?php }?>
					</div>
				</div>  		
	  		</div>
	  </div>

                            <div class="modal-footer text-center" style="padding-top: 0px;">
                                <div class="add2">
                                    <input type="submit" class="addtocart" value='' onclick="return checkValidation();"/>
                                </div>
                                <div class="clearboth"></div>
                                <br/>

                                <i class="grey_1 text-center"><a href="javascript:;"  data-dismiss="modal" style="float: none; ">No thanks continue to checkout</a></i>
                            </div>
                            </div>
                            </div>
                            </div>
                            </form>
                            </div>
                            <script>

                            function checkValidation() {
                            	if ($('#box_coin_type').val() == '') {
                            			alert ('Please select coin type.');
                            			return false;
                            		}
                            	return true;
                            } 
                            
    function resetfunction() {

        resetCookie("imgstyle", '', 0);
        resetCookie("toptxt", '', 0);
        resetCookie("bottomtxt", '', 0);
    }
    function resetCookie(cname, cvalue, exdays)
    {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ';domain=personalizedcoins.com;path=/';
    }
                            </script>
                            <?php
                            $newdata = array(
                                'templatimg' => '',
                                'coin_name' => '',
                                'templateid' => ''
                            );
                            $this->session->set_userdata($newdata);
                            ?>