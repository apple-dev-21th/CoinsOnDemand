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
                            <th class="text-center">Multi Use </th>
                            <th class="text-center">Status </th>
                            <th class="text-center">Used By </th>
                            <th class="text-center">Used Date</th>
                            <?php if ($parent_detail['0']['unique_name'] == 'yes') {
                                $check = 1;
                                ?>
                                <th class="text-center">Distributed</th>
<?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        //echo '<pre>';             print_r($parent_detail); die;
                        foreach ($coupon_detail as $coupon) {
                            ?>
                            <tr class="gradeA">
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-center"> <?php echo $coupon['coupon_code']; ?></td>
                                <td class="text-center" style="text-transform: capitalize;"><?php echo $coupon['multi_use']; ?></td>
                                <td class="text-center"> <?php if ($coupon['u_status'] == '1') {
                                echo 'Available';
                            } else {
                                echo 'Used';
                            } ?> </td>

                                <td class="text-center"> <?php echo $coupon['used_by']; ?> </td>
                                <td class="text-center"> <?php echo $coupon['used_date']; ?> </td>
                                <?php if ($check == 1) { ?>
                                    <td class="text-center"> <div class="field">
                                           <div class="field">
                                   <input type="checkbox" name="checkbox" id="<?php echo  $coupon['id'];?>" value="1" class="validate[minCheckbox[2]]"  onchange="chnagestatus(<?php echo  $coupon['id'];?>);" <?php if($coupon['coupon_status'] == '1') { echo 'checked'; }?>/>
                                           
                                        </div>	
                                    </div> </td>
                            <?php } ?>
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
<script>
    function chnagestatus(id){
        var value = null;
        var coupinId = id;
          if ($('#'+coupinId).is(':checked')) {
               value = 1
          }else{ 
              value =0;
          }
          $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/category/updatedistributed',
                data: {id: coupinId, value: value},
                success: function(data) {
//                    if (data === '1') {
//                        window.location.reload();
//                    }
                }
            });
    }
    </script>