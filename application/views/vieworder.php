<div class="container white padding_30">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-xs-9">
            <div class="glossymenu">
                <a headerindex="0h" class="menuitem submenuheader about_header" href="">View my Orders</a>
                <?php echo $this->pagination->create_links(); ?>
                <table class="table review_text1">
                    <tbody><tr>
                            <th width="129">Order ID</th>
                            <th width="220"> Transaction ID</th>
                            <th width="142"> Purchase date</th>
                            <th width="162">Total price</th>
                            <th width="115">Details </th>
                        </tr>
                   <?php foreach ($order as $orders) :
//                       echo "<pre>";
//                       print_r($orders);
//                   exit;
                       ?>     
                   
                        <tr>
                            <td><?php echo $orders['order_id']?></td>
                            <td><?php echo $orders['transaction_id']?></td>
                            <td><?php echo  date('m-d-Y', strtotime($orders['order_date'])) ; ?></td>
                            <td><?php 
                            if($orders['discount']>=$orders['total_paid']){
                                echo "Free";
                            }else{
                                echo $orders['total_paid'];
                            }
                            ?></td>
                            <td><a class="review_text" href="<?php  echo base_url();?>order_detail/index/<?php echo $orders['order_id']?>">View Order</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody></table>
            </div>
        </div>
        <?php $this->load->view('include/profilesidebar'); ?>
    </div>
</div>