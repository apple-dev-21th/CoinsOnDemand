
<div class="container white padding_30">    
    <?php //print_r($order); ?>
    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu"> <a headerindex="0h" class="menuitem submenuheader about_header" href="">Order Details</a>
                <div class="col-md-12 col-xs-12 col-sm-12"> <br>
                    <div class="row review_text1">
                        <div class="col-lg-4 col-xs-4 col-sm-4">
                            <p><span class="review_text">Order ID</span> : <?php echo $order[0]['order_id']; ?></p>
                            <p><span class="review_text">Purchase date</span> : <?php echo date('Y-m-d', strtotime($order[0]['date'])); ?></p>
                            <p></p>
                        </div>
                        <div class="col-lg-4 col-xs-4 col-sm-4">
                            <p><span class="review_text">Shipping Address</span> :</p>
                            <p><?php echo $shipping['0']['fname'] . '&nbsp' . $shipping['0']['lname']; ?>
                            <br><?php echo $shipping['0']['address'] . ' ' . $shipping['0']['address2']; ?>
                            <br> <?php echo $shipping['0']['city'] . ',' . $shipping['0']['state']. ' ' . $shipping['0']['zip']; ?>
                            <br> <?php echo $shipping['0']['country']  ?>
                            <br> <?php echo $shipping['0']['phone']; ?></p>
                            <p></p>
                        </div>
                        <div class="col-lg-4 col-xs-4 col-sm-4">
                            <p><span class="review_text">Billing Address</span> :</p>
                            <p><?php
                                echo $this->session->userdata('user');
                                echo "&nbsp" . $this->session->userdata('last_name'); 
                                ?>
                            <?php if(!empty($address['0']['address'])){?>
                                <br> <?php echo $address['0']['address']; ?>
                          <br><?php echo $address['0']['city']. "," .$address['0']['state']. "&nbsp" . $address['0']['post_code']; ?>
                           <br><?php echo $address['0']['country'];  ?>
                            <br><?php echo $address['0']['phone']; ?></p>
                            <?php  }?>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="col-md-12 col-sm-12 col-xs-12 review_text1">
                    <span class="review_text"> Order List</span><br><br>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="table shop">
                                <tbody>
                                </tbody><tbody>
                                    <tr>
                                        <th width="30%">Description </th><th width="20%"></th><th width="14%">Price</th><th width="15%">Quantity</th><th width="12%">Total</th>
                                    </tr>

                                    <?php foreach($order as $ord): ?>
                                    <tr> 
                                        <td width="">
                                            <div style="position:relative; height:150px; width:150px;">
<img style="width:150px;float:left;z-index:1;position:absolute; <?php if($ord['coin_selected'] == 'eagle') { ?> margin-top: 5px; margin-left: 4px; width: 141px;<?php }?>" src="<?php echo $ord['img_name']; ?>">
                                                <!-- If coin is Gold-->
                                                <?php if ($ord['coin_type'] == '24KT Gold Plated Personalized Coin' || $ord['coin_type'] == 'Gold'  || $ord['coin_type']  == 'Standard w/24KT Gold Plating'  ) {?>
                                                <img style="width:147px;float:left;position:absolute;left:0px;z-index:1;top: 2px;" src="<?php echo base_url();?>con_front_gold.png">
                                                <img style="width:137px;float:left;position:absolute;left:104px;z-index:0;top:3px;" src="<?php echo base_url();?>back_gold.jpg">
                                                <?php
                                                $coin_price = $ord['coin_cost']+2.95;
                                                } else {
                                                    $coin_price = $ord['coin_cost'];
                                                    ?>
                                                <img style="width:147px;float:left;position:absolute;left:0px;z-index:1;top: 2px;" src="<?php echo base_url();?>outer_new_1.png">
                                                <img style="width:137px;float:left;position:absolute;left:104px;z-index:0;top:3px;" src="<?php echo base_url();?>assets/img/back.jpg">
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td><p><?php echo $ord['coin_type']; ?> </p></td>
                                        <td><?php 
                                            if (strpos($ord['coin_type'], 'eagle')) {
                                                echo number_format((float)($eagle_coin_price + ($ord['coin_quantity'] - 1)*$coin_price) / $ord['coin_quantity'], 2, '.', '');
                                            }else{
                                                echo number_format((float)$coin_price, 2, '.', '');
                                            }
                                            ?>    
                                             
                                            
                                        </td>
                                        <td><?php echo $ord['coin_quantity']; ?></td>
                                        <td>$<b><?php 
                                        if (strpos($ord['coin_type'], 'eagle')) {
                                            $sub = $eagle_coin_price + ($ord['coin_quantity'] - 1)*$coin_price;
                                        }else{
                                            $sub = $ord['coin_quantity']*$coin_price;     
                                        }
                                        
//                                        echo "<pre>";
//                                        print_r($ord);
//                                        exit;
//                                        if($sub>=$ord['disc']){
//                                            echo  "Free";
//                                        }else{
                                            echo number_format((float)$sub, 2, '.', '');
                                      //  }
                                        ?> </b></td>
                                    </tr>
                                    
<?php endforeach;


?>
                                   <?php if($giftbox['0']['single_coin_box'] > 0) {?> 
                                    <tr> <!-- coin box  display start here-->
                                        <td width=""><img style="width:150px;float:left;z-index:999;position:relative" src="<?php echo base_url();?>assets/img/coinbox1.png
                                                          "></td>
                                        <td><p>Single Coin Box <br></p></td>
                                        <td>$3.95</td>
                                        <td> <?php echo $giftbox['0']['single_coin_box']; ?></td>
                                        <td>$<b><?php $total = $giftbox['0']['single_coin_box']*3.95;
                                          echo number_format((float)$total, 2, '.', '');
                                        ?></b></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($giftbox['0']['two_coin_box'] > 0) { ?> 
                                    <tr> <!-- coin box  display start here-->
                                        <td width=""><img style="width:150px;float:left;z-index:999;position:relative" src="<?php echo base_url();?>assets/img/coinbox2.png
                                                          "></td>
                                        <td><p>Two Coin Box <br></p></td>
                                        <td>$5.95</td>
                                        <td> <?php echo $giftbox['0']['two_coin_box']; ?></td>
                                        <td>$<b><?php $total = $giftbox['0']['two_coin_box']*5.95;
                                          echo number_format((float)$total, 2, '.', '');
                                        ?></b></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($giftbox['0']['three_coin_box'] > 0) {?> 
                                    <tr> <!-- coin box  display start here-->
                                        <td width=""><img style="width:150px;float:left;z-index:999;position:relative" src="<?php echo base_url();?>assets/img/coinbox3.png
                                                          "></td>
                                        <td><p>Two Coin Box <br></p></td>
                                        <td>$7.95</td>
                                        <td> <?php echo $giftbox['0']['three_coin_box']; ?></td>
                                        <td>$<b><?php $total = $giftbox['0']['three_coin_box']*7.95;
                                          echo number_format((float)$total, 2, '.', '');
                                        ?></b></td>
                                    </tr>
                                    <?php } ?>
                                        <?php if($giftbox['0']['eight_coin_box'] > 0) {?> 
                                    <tr> <!-- coin box  display start here-->
                                        <td width=""><img style="width:150px;float:left;z-index:999;position:relative" src="<?php echo base_url();?>assets/img/coinbox4.png
                                                          "></td>
                                        <td><p>Eight Coin Box<br></p></td>
                                        <td>$19.95</td>
                                        <td> <?php echo $giftbox['0']['eight_coin_box']; ?></td>
                                        <td>$<b><?php $total = $giftbox['0']['eight_coin_box']*19.95;
                                          echo number_format((float)$total, 2, '.', '');
                                        ?></b></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($giftbox['0']['fifteen_coin_box'] > 0) {?> 
                                    <tr> <!-- coin box  display start here-->
                                        <td width=""><img style="width:150px;float:left;z-index:999;position:relative" src="<?php echo base_url();?>assets/img/coinbox5.png
                                                          "></td>
                                        <td><p>Eight Coin Box<br></p></td>
                                        <td>$22.95</td>
                                        <td> <?php echo $giftbox['0']['fifteen_coin_box']; ?></td>
                                        <td>$<b><?php $total = $giftbox['0']['fifteen_coin_box']*22.95;
                                          echo number_format((float)$total, 2, '.', '');
                                        ?></b></td>
                                    </tr>
                                    <?php } ?>
                            
                                   
                                  
                                   
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <p><span class="review_text"><b>Order Status :</span><?php echo $order[0]['status']; ?></b> </p>
                        </div>
                        <div class="settwidth">
                            <p style="padding-left:10px;" class="">
                                 <span class="review_text">Tax  : </span>$<?php echo number_format($order[0]['tax'], 2); ?><br>
                                 <span class="review_text">Discount  : </span>$<?php echo number_format($order[0]['disc'], 2); ?><br>
       <span class="review_text">Shipping  : </span>$<?php echo number_format($order[0]['shpamt'], 2); ?><br>
                                <span class="review_text">Total paid: </span><?php 
                               
                                if($order[0]['disc']>=$order[0]['tpaid']){
                                    echo "Free";
                                }else{
                                     echo "$ ".$order[0]['tpaid']; 
                                }
                                ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php $this->load->view('include/profilesidebar'); ?>
    </div>
</div>