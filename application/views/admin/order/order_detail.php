<div id="contentHeader">
    <h1> Order Detail

        <?php if (!empty($order_status['0']['pdf_name'])) { ?>
            <a style="float: right; margin-right: 53px;" class="btn btn-primary" href="<?php echo base_url(); ?>downloadpdf.php?file=<?php echo $order_status['0']['pdf_name']; ?>" >Download PDF</a> <?php } ?>

<!--            <img src="<?php echo base_url(); ?>assets/images/arrow_down.png" title="Download PDF" /> -->

    </h1>



</div> <!-- #contentHeader -->	
<div class="container">
    <div class="grid-24">	

        <?php
        $login_error1 = $this->session->flashdata('Login_error1');
        if (isset($login_error1) && !empty($login_error1)) {
            ?>     
            <div class="alert alert-danger fade in notify notify-error ">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h3>Error Notifty</h3>
                <p>Incorrect User Name and Password Combination.</p>
            </div>
            <?php
        } else {
            $this->load->view('admin/include/flash');
        }

        if (validation_errors()) {
            ?>
            <div class="notify notify-error">
                <a href="javascript:;" class="close">×</a>
                <h3>Error Notifty</h3>
                <?php echo validation_errors(); ?>
            </div>
            <?php
        }
        ?>            
        <?php
//            echo "<pre>";
//            print_r($shipping);
//            print_r($billing);
        ?>

        <!--  New look start from here --->
        <div class="grid-12">
            <div class="widget widget-table">

                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart">Order # <?php echo $order_status['0']['order_id']; ?> (Order confirmation email was sent)</h3>		
                </div>
                <div class="widget-content">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr class="odd gradeX">
                                <td  class="text-center">Order Date</td>
                                <td class="text-center">
                                    <?php echo date('M d, Y h:i:s A', strtotime($order_status['0']['order_date'])); ?>
                                </td>
                            </tr>
                            <tr class="odd gradeX">
                                <td  class="text-center">Order Status</td>
                                <td class="text-center">
                                    <?php
                                    if (empty($order_status['0']['transaction_id'])) {
                                        echo "Payment Pending";
                                    } else {
                                        echo $order_status['0']['order_status'];
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>

        <div class="grid-12">
            <div class="widget widget-table">
                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart">Account Information</h3>
                    <h4 class="icon chart"> Order Status:</h4>
                    <form name="order" action="<?php echo base_url(); ?>admin/order/changestatus/<?php echo $order_status['0']['order_id']; ?>" method="post">

                        <select name="orderstatus" onchange="document.order.submit();" >
                            <option value="Completed" <?php
                            if ($order_status['0']['order_status'] == 'Completed') {
                                echo 'selected="selected"';
                            }
                            ?>>Completed</option>
                            <option value="Pending" <?php
                            if ($order_status['0']['order_status'] == 'Pending') {
                                echo 'selected="selected"';
                            }
                            ?>>Pending</option>
                            <option value="Under Progress" <?php
                            if ($order_status['0']['order_status'] == 'Under Progress') {
                                echo 'selected="selected"';
                            }
                            ?>> Under Progress</option>
                        </select>
                    </form>
                </div>
                <div class="widget-content">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr class="odd gradeX">
                                <td  class="text-center">Customer name</td>
                                <td class="text-center"><?php echo $userdetail[0]['first_name'] . " " . $userdetail[0]['last_name']; ?></td>
                            </tr>
                            <tr class="odd gradeX">
                                <td  class="text-center">Email</td>
                                <td class="text-center"><?php echo $userdetail[0]['email_id']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- address here --->

        <div class="grid-12">
            <div class="widget widget-table">

                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart">Billing Address</h3>		
                </div>
                <div class="widget-content">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr class="odd gradeX">
                                <td class="text-center">
                                   
                                    <?php 
                                    if(!empty($billing)) {
                                    echo $billing['0']['address']; ?>
                                    <br>
                                    <?php echo $billing['0']['city']; ?> ,
                                    <?php echo $billing['0']['state']; ?> , 
                                    <?php echo $billing['0']['post_code']; ?> <br>
                                    <?php echo $billing['0']['country']; ?> <br>
                                    T : <?php echo $billing['0']['phone'];  }?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div> 
            </div>
        </div>

        <div class="grid-12">
            <div class="widget widget-table">
                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart">Shipping Address</h3>		
                </div>
                <div class="widget-content">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr class="odd gradeX">
                                <td class="text-center">

                                    <?php 
                                    if(!empty($shipping)) {
                                    echo $shipping['0']['address']; ?>
                                    <br>
                                    <?php echo $shipping['0']['city']; ?> ,
                                    <?php echo $shipping['0']['state']; ?> , 
                                    <?php echo $shipping['0']['zip']; ?> <br>
                                    <?php echo $shipping['0']['country']; ?> <br>
                                    T : <?php echo $shipping['0']['phone']; }?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--  Payment information here --->

        <div class="grid-12">
            <div class="widget widget-table">

                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart">Payment Information</h3>		
                </div>
                <div class="widget-content">
                    <table class="table table-bordered table-striped">
                        <tbody>

                            <?php
                           
                            if ( $order_status[0]['total_paid'] == '0.00') {
                                ?>
                                <tr class="odd gradeX">
                                    <td  class="text-center">Payment</td>
                                    <td class="text-center">
                                        Free
                                    </td>
                                </tr>
                                <?php
                            } else {
                                if (!empty($order_status[0]['transaction_id']) and !is_numeric($order_status[0]['transaction_id'])) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td  class="text-center">Payment By</td>
                                        <td class="text-center">Paypal</td>
                                    </tr>
                                    <?php
                                } elseif (!empty($order_status[0]['transaction_id'])) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td colspan="2" class="text-center">Credit Card (Authorize.net)</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td  class="text-center">Credit Card Type</td>
                                        <td class="text-center"><?php echo $order_status[0]['card_type']; ?></td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td  class="text-center">Credit Card Number</td>
                                        <td class="text-center">xxxx-<?php
                                            if ($order_status[0]['card_digit']) {
                                                echo $order_status[0]['card_digit'];
                                            } else {
                                                echo "xxxx";
                                            }
                                            ?></td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td  class="text-center">Status</td>
                                        <td class="text-center">
                                            Payment Pending
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                     <tr class="odd gradeX">
                                <td  class="text-center">Processed Amount</td>
                                <td class="text-center">$<?php echo $order_status['0']['total_paid']; ?></td>
                            </tr>
                                    <?php
                            }
                            ?>

                           

                        </tbody>
                    </table>
                </div> 
            </div>


        </div>

        <div class="grid-12">
            <div class="widget widget-table">
                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart">Shipping and handling information</h3>		
                </div>
                <div class="widget-table">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr><td class="text-center">Shipping Charged: $<?php echo $order_status['0']['shipping_amount']; ?></td></tr>           
                        </tbody> 
                    </table>
                </div>
                <div style="width: 45%; float: left">
                    <div class="widget-content">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr><td class="text-center">Stamps.com</td></tr>
                                <tr>
                                    <td>
                                        <?php if (empty($order_status['0']['stamp_link']) and empty($order_status[0]['shipping_number'])) {   if(!empty($shipping)) {?>

                                            <div class="widget-content" style="margin: 15px;">
                                                <form class="form uniformForm" enctype="multipart/form-data" accept-charset="utf-8" method="post"   id="data">
                                                    <input type="hidden" id="id" name="id" value="<?php echo $order_status['0']['order_id']; ?>">
                                                    <input type="hidden" id="id" name="tozip" value="<?php echo $shipping['0']['zip']; ?>">
                                                    <?php $ctry_shipping = explode('-', $shipping['0']['country']); ?>
                                                    <input type="hidden" id="tocountry" name="tocountry" value="<?php echo $ctry_shipping['1']; ?>">
                                                    <div class="field-group">
                                                        <label for="services" style="float:left;width: 90px;">Package Type:</label>
                                                        <div class="field">    
                                                            <select name="package" id="package">
                                                                <option value="" > --Select--</option>
                                                                <option value="Letter">Letter</option>
                                                                <option value="Postcard">Postcard</option>
                                                                <option value="Large Envelopes/Flates">Large Envelopes/Flates</option>                                                    <option value="Thick Envelope">Thick Envelope</option>
                                                                <option value="Package">Package</option>
                                                                <option value="Flat Rate Envelope">Flat Rate Envelope</option>
                                                                <option value="Legal Flat Rate Envelope">Legal Flat Rate Envelope</option>
                                                                <option value="Padded Flat Rate  Envelope">Padded Flat Rate  Envelope</option>
                                                                <option value="Small Flat Rate Box ">Small Flat Rate Box </option>
                                                                <option value="Medium Flat Rate Box ">Medium Flat Rate Box</option>
                                                                <option value="Large Flat Rate Box">Large Flat Rate Box</option>
                                                                <option value="Regional Rate Box A">Regional Rate Box A</option>
                                                                <option value="Regional Rate Box B">Regional Rate Box B</option>
                                                                <option value="Regional Rate Box C">Regional Rate Box C</option>
                                                                <option value="Large Package">Large Package </option>
                                                                <option value="Oversized Package">Oversized Package</option>
                                                            </select>
                                                        </div> <!-- .field -->
                                                    </div>

                                                    <div class="field-group">
                                                        <label for="services" style="float:left;width: 90px;">Services:</label>
                                                        <div class="field" id="servicetype">    
                                                            <select name="services" id="services">
                                                                <option value="">--- Select Package First--</option>


                                                            </select>
                                                        </div> <!-- .field -->
                                                    </div>

                                                    <div class="field-group">
                                                        <label for="weight" style="float:left;width: 90px;">WeightLb:</label>
                                                        <div class="field">
                                                            <input type="text" id="weightlb" name="weightlb" value="">
                                                        </div> 
                                                    </div>
                                                    <div class="field-group">
                                                        <label for="weight" style="float:left;width: 90px;">WeightOz:</label>
                                                        <div class="field">
                                                            <input type="text" id="weightoz" name="weightoz" value="">
                                                        </div> 
                                                    </div>
                                                    <div class="field-group">
                                                        <label for="weight" style="float:left;width: 90px;">Insured?:</label>
                                                        <div class="field">
                                                            <div class="checker" id="uniform-checkbox1"><span><input type="checkbox" class="validate[minCheckbox[2]]" value="1" id="insurance" name="insurance" style="opacity: 0;"></span></div>
                                                        </div>
                                                    </div>
                                                    <div id="ins_amt"></div>



                                                    <div class="actions">
                                                        <button class="btn btn-primary" name="generate" value="generate" type="submit">GetRate</button>
                                                    </div>
                                                    <?php echo form_close(); ?>
                                            </div> 


                                            <?php
                                        }  } else {
                                            if (!empty($order_status['0']['stamp_link'])) {
                                                ?>
                                                <a class="btn btn-primary" href="<?php echo $order_status['0']['stamp_link']; ?>" target="_blank">Print Stamp</a>
                                            <?php }
                                        }
                                        ?>

                                    </td>
                                <tr>
                                    <td>
                                        <div id="responce"></div>
                                    </td>
                                </tr>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="width: 45%; float: left">
                    <div class="widget-content">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr><td class="text-center">Manual</td></tr>
                            </tbody>
                        </table>  <?php if (empty($order_status[0]['shipping_number'])) { ?>
                            <div style="margin: 15px;" class="widget-content">
                                <form id="data1" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="form uniformForm"  action="<?php echo base_url() . 'admin/order/manualupdate/' . $order_status['0']['order_id']; ?>">

                                    <div class="field-group">
                                        <label style="float:left;width: 90px;" for="weight">Tracking #:</label>
                                        <div class="field">
                                            <input type="text"  name="trachingnumber" id="track" required>
                                        </div> 
                                    </div>
                                    <div class="actions">
                                        <button class="btn btn-primary" name="update" value="update" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <div class="field-group">
                                <label style="float:left;width: 90px;" for="weight">Tracking #:</label>
                                <div class="field">
                                    <p><?php echo $order_status[0]['shipping_number'] ?></p>
                                </div> 
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
        <!-- Order Detail here start --->
        <div class="grid-24">
            <div class="widget widget-table">
                <div class="widget-header">
                    <span class="icon-list"></span>
                    <h3 class="icon chart"> Order Detail</h3>

                </div>

                <div class="widget-content">
                    <table class="table table-bordered table-striped data-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th> Order ID</th>
                                <th> Coin Name</th>
                                <th> Coin Type</th>
                                <th> Coin Quantity</th>
                                <th> Coin Image</th>



<!--                            <th> Download PDF </th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
//echo '<pre>'; print_r($order_detail);
                            $i = 1;
                            foreach ($order_detail as $key => $order) {
                                ?>
                                <tr class="gradeA">
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="text-center"> <?php echo $order['order_id']; ?> </td>
                                    <td>  <?php echo $order['coin_name']; ?></td>
                                    <td class="text-center"> <?php echo $order['coin_type']; ?> </td>
                                    <td class="text-center"> <?php echo $order['coin_quantity']; ?></td>
                                    <td class="text-center"> 
                                        <img src="<?php echo $order['img_name']; ?>" width="50px"  >
                                        <div class="actions">	
                                            <a href="<?php echo $order['img_name']; ?>" class="btn btn-primary btn-small lightbox">View</a>
                                        </div>
                                    </td>

                                </tr>
                                <?php
                                $i++;
                            }
                            ?>

                            <?php
                            if (isset($giftbox[0]['single_coin_box'])) {
                            if ($giftbox[0]['single_coin_box']) {
                                ?>
                                <tr class="gradeA">
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="text-center">Item# 998563</td>
                                    <td>Single Coin Box</td>
                                    <td></td>
                                    <td class="text-center"> 
                                        <?php echo $giftbox[0]['single_coin_box']; ?>
                                    </td>
                                    <td class="text-center">
                                        <img style="width:60px;z-index:999;position:relative" src="https://personalizedcoins.com/assets/img/coinbox1.png">
                                    </td>
                                </tr>
                                <?php
                            }
                            }
                            ?>


                            <?php
                            if (isset($giftbox[0]['two_coin_box'])){
                            if ($giftbox[0]['two_coin_box']) {
                                ?>
                                <tr class="gradeA">
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="text-center">Item# 998563</td>
                                    <td>Two Coin Box</td>
                                    <td></td>
                                    <td class="text-center"> 
                                        <?php echo $giftbox[0]['two_coin_box']; ?>
                                    </td>
                                    <td class="text-center">
                                        <img style="width:60px;z-index:999;position:relative" src="https://personalizedcoins.com/assets/img/coinbox2.png">
                                    </td>
                                </tr>
                                <?php
                            }
                            }
                            ?>

                            <?php
                            if (isset($giftbox[0]['three_coin_box'])){
                            if ($giftbox[0]['three_coin_box']) {
                                ?>
                                <tr class="gradeA">
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="text-center">Item# 998563</td>
                                    <td>Three Coin Box</td>
                                    <td></td>
                                    <td class="text-center"> 
                                        <?php echo $giftbox[0]['three_coin_box']; ?>
                                    </td>
                                    <td class="text-center">
                                        <img style="width:60px;z-index:999;position:relative" src="https://personalizedcoins.com/assets/img/coinbox3.png">
                                    </td>
                                </tr>
                                <?php
                            }
                            }
                            ?>

                            <?php
                            if (isset($giftbox[0]['eight_coin_box'])) {
                            if ($giftbox[0]['eight_coin_box']) {
                                ?>
                                <tr class="gradeA">
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="text-center">Item# 998563</td>
                                    <td>Eight Coin Box</td>
                                    <td></td>
                                    <td class="text-center"> 
                                        <?php echo $giftbox[0]['eight_coin_box']; ?>
                                    </td>
                                    <td class="text-center">
                                        <img style="width:60px;z-index:999;position:relative" src="https://personalizedcoins.com/assets/img/coinbox4.png">
                                    </td>
                                </tr>
                                <?php
                            }
                            }
                            ?>

                            <?php
                            if (isset($giftbox[0]['fifteen_coin_box'])) {
                            if ($giftbox[0]['fifteen_coin_box']) {
                                ?>
                                <tr class="gradeA">
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="text-center">Item# 998563</td>
                                    <td>Fifteen Coin Box</td>
                                    <td></td>
                                    <td class="text-center"> 
                                        <?php echo $giftbox[0]['fifteen_coin_box']; ?>
                                    </td>
                                    <td class="text-center">
                                        <img style="width:60px;z-index:999;position:relative" src="https://personalizedcoins.com/assets/img/coinbox5.png">
                                    </td>
                                </tr>
                                <?php
                            }
                            }
                            ?>

                        </tbody>
                        </tbody>
                    </table>
                </div> <!-- .widget-content -->

            </div> 
        </div>
    </div>
</div>

<script>
                            $('#insurance').click(function() {
                                if ($(this).is(':checked')) {
                                    var content = '<div class="field-group"><label for="weight" style="float:left;width: 90px;">InsuredValue:</label><div class="field"><input type="text" id="ins_amt" name="ins_amt" value="<?php echo $order_status['0']['total_paid']; ?>"></div></div>';
                                    $("#ins_amt").html(content);
                                } else {
                                    var content = '';
                                    $("#ins_amt").html(content);
                                }
                            });
                            $("form#data").submit(function(event) {
                                event.preventDefault();
                                var $form = $(this);
                                var $inputs = $form.find("input, select, button, textarea");
                                var serializedData = $form.serialize();

                                $.ajax({
                                    type: "POST",
                                    url: '<?php echo base_url(); ?>admin/order/getrates/',
                                    data: serializedData,
                                    success: function(data) {
                                        $("#responce").html(data);
                                    }
                                });
                            });

                            $("#package").change(function() {
                                var dropdown = '';
                                var multipleValues = $("#package").val();
                                switch (multipleValues) {
                                    case 'Postcard':
                                        dropdown = '  <select name="services" id="services"><option value="US-FC">First Mail Class</option></select>';
                                        break;
                                    case 'Letter':
                                        dropdown = '<select name="services" id="services"><option value="US-FC">First Mail Class</option><option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option><option value="US-FCI">First Class Mail International</option></select>';
                                        break;
                                    case 'Large Envelopes/Flates':
                                        dropdown = '<select name="services" id="services"><option value="US-FC">First Mail Class</option> <option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option><option value="US-MM">Media Mail</option><option value="US-EMI">Priority Mail Express International</option> <option value="US-PMI">Priority Mail International</option> <option value="US-FCI">First Class Mail International</option></select>';
                                        break;
                                    case 'Thick Envelope':
                                        dropdown = '<select name="services" id="services"><option value="US-FC">First Mail Class</option> <option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option><option value="US-MM">Media Mail</option><option value="US-EMI">Priority Mail Express International</option> <option value="US-PMI">Priority Mail International</option> <option value="US-FCI">First Class Mail International</option></select>';
                                        break;
                                    case 'Package':
                                        dropdown = '<select name="services" id="services"><option value="US-FC">First Mail Class</option> <option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option><option value="US-MM">Media Mail</option><option value="US-EMI">Priority Mail Express International</option> <option value="US-PMI">Priority Mail International</option> <option value="US-FCI">First Class Mail International</option></select>';
                                        break;
                                    case 'Flat Rate Envelope':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option><option value="US-EMI">Priority Mail Express International</option><option value="US-PMI">Priority Mail International</option></select>';
                                        break;
                                    case 'Legal Flat Rate Envelope':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option><option value="US-EMI">Priority Mail Express International</option><option value="US-PMI">Priority Mail International</option></select>';
                                        break;
                                    case 'Padded Flat Rate  Envelope':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option></select>';
                                        break;
                                    case 'Small Flat Rate Box':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option><option value="US-PMI">Priority Mail International</option></select>';
                                        break;
                                    case 'Medium Flat Rate Box':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option><option value="US-PMI">Priority Mail International</option></select>';
                                        break;
                                    case 'Large Flat Rate Box':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option><option value="US-PMI">Priority Mail International</option></select>';
                                        break;
                                    case 'Regional Rate Box A':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option></select>';
                                        break;
                                    case 'Regional Rate Box B':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option></select>';
                                        break;
                                    case 'Regional Rate Box C':
                                        dropdown = '  <select name="services" id="services"> <option value="US-PM">Priority Mail</option></select>';
                                        break;
                                    case 'Large Package':
                                        dropdown = '<select name="services" id="services"><option value="US-FC">First Mail Class</option> <option value="US-PM">Priority Mail</option><option value="US-XM">Priority Mail Express</option><option value="US-MM">Media Mail</option></select>';
                                        break;
                                    case 'Oversized Package':
                                        dropdown = '  <select name="services" id="services"><option value="US-PS">Parcel Select</option></select>';
                                        break;
                                }
                                $("#servicetype").html(dropdown);
                            });

</script>



<!--  <select name="services" id="services">
                                                        <option value="US-FC">First Mail Class</option>
                                                        <option value="US-MM">Media Mail</option>
                                                        <option value="US-PS">Parcel Post</option>
                                                        <option value="US-PM">Priority Mail</option>
                                                        <option value="US-XM">Priority Mail Express</option>
                                                        <option value="US-EMI">Priority Mail Express International</option>
                                                        <option value="US-PMI">Priority Mail International</option>
                                                        <option value="US-FCI">First Class Mail International</option>
                                                        <option value="US-CM">Critical Mail</option>
                                                        <option value="US-PS">Parcel Select</option>
                                                        <option value="US-LM">Library Mail</option>
                                                        <option value="US-PMI">Flat Rate Envelope</option>
                                                    </select>-->