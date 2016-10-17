<div id="contentHeader">
    <h1>Manage Coupons</h1>
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
                <h3 class="icon chart">List of Coupons </h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th class="text-center">S.No.</th>
                            <th class="text-center">Coupon Code</th>
                            <th class="text-center">Discount </th>
                           <th class="text-center">Maximum Uses </th>
                            <th class="text-center">Multi Use </th>
                             <th class="text-center">Unique Names</th>
                               <th class="text-center">Action</th>
                               <th class="text-center">Status</th>
                               <th class="text-center">CSV</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
// echo '<pre>';             print_r($coins); die;
                        foreach ($coupons as $coupon) {
                            ?>
                            <tr class="gradeA">
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-center"> <?php  echo $coupon['code'];  ?></td>
                                <td class="text-center">
                                    <?php
                                        if($coupon['discount_type'] == '%') {
                                            echo $coupon['discount_value'].'%';
                                        }elseif($coupon['discount_type'] == 'jfk'){
                                            echo 'FREE JFK';
                                        } else {
                                            echo '$'.$coupon['discount_value'];
                                        }
                                    ?>
                                </td>
                                <td class="text-center"> <?php echo $coupon['max_usage']; ?> </td>
                                <td class="text-center" style="text-transform: capitalize;"> <?php echo $coupon['multi_use']; ?> </td>
                                <td class="text-center">
                          <?php if($coupon['unique_name'] == 'yes') { ?>
                                    <a href="<?php echo base_url('admin/category/coupondetail').'/'.$coupon['id'];?>">Yes</a>
                          <?php } else { echo '-'; }?>
                                </td>
                                 <td  class="text-center">
                                    <a  onclick="return confirm('WARNING: You are asking to delete the coupon! The coupon will be removed from site. Please confirm if this is what you want to do.');" href="<?php echo base_url(); ?>admin/category/delete_coupon/<?php echo $coupon['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Coupon" /> </a> &nbsp;&nbsp;

                                </td>
                                <td class="text-center"><?php if ($coupon['status'] == '1') { ?> <a href="<?php echo base_url(); ?>admin/category/deact_coupon/<?php echo $coupon['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/yes.png" title="Deactivate" /> </a><?php } else { ?><a href="<?php echo base_url(); ?>admin/category/activate_coupon/<?php echo $coupon['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Activate" /> </a> <?php } ?>
                                </td>
                                 <td class="text-center">
                          <?php if($coupon['unique_name'] == 'yes') { ?>
                                    <a href="<?php echo base_url('admin/category/export_csv').'/'.$coupon['id'].'/'.$coupon['code'];?>">Export to CSV</a>
                          <?php } else { echo '-'; }?>
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