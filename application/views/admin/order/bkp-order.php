<div id="contentHeader">
    <h1>Manage Order</h1>
</div> <!-- #contentHeader -->	
<div class="container">
    <div class="grid-24">	
        <?php $this->load->view('admin/include/flash'); ?>
        <?php if (validation_errors()) { ?>
            <div class="notify notify-error">
                <a href="javascript:;" class="close">×</a>
                <h3>Error Notifty</h3>
               <?php echo validation_errors(); ?>
            </div>
<?php     
} 
?>
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">List of Orders's</h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th> Customer Name</th>
                            <th> Transaction ID</th>
<!--       <th> Payment Status</th>-->
                            <th> Amount Paid</th>
                         <th> Order Status</th>
                         <th> Order Date</th>
                         <th> View Order </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($order as $orders) {
                            
                            ?>
                            <tr class="gradeA">
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-center"> <?php echo $orders['fn'].'&nbsp'.$orders['ln']; ?> </td>
                                <td>  <?php echo $orders['transaction_id']; ?></td>
                              
                                <td class="text-center"> <?php echo $orders['total_paid']; ?></td>
                              <td class="text-center "> 
 <?php if($orders['checkout_status'] == 'pending'){
     echo 'Payment Pending';
 }else {
 echo $orders['order_status'];  }?></td>

                              <td> <?php echo date('m/d/Y g:i a', strtotime($orders['order_date'])); ?></td>
                              <td class="text-center"> <a href="<?php echo base_url(); ?>admin/order/orderdetail/<?php echo $orders['order_id'];?>" > View Order  </a></td>
                                <td  class="text-center">
 <a onclick="return confirm('Are you sure! You want  to delete this Order ?');"  href="<?php echo base_url(); ?>admin/order/deleteorder/<?php echo $orders['order_id'];?>" onClick="return confirm('Delete this order?')" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Customer" /> </a> 
                                </td>
                                
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                    </tbody>
                </table>
            </div> <!-- .widget-content -->
        </div> 
    </div>
</div>
