<div id="contentHeader">
    <h1>Manage Customer</h1>
</div> <!-- #contentHeader -->	
<div class="container">
    <div class="grid-24">	
        <?php $this->load->view('admin/include/flash'); ?>
        <?php if (validation_errors()) { ?>
            <div class="notify notify-error">
                <a href="javascript:;" class="close">×</a>
                <h3>Error Notify</h3>
               <?php echo validation_errors(); ?>
            </div>
<?php     
} 
?>
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">List of Customer's</h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th> Name</th>
                            <th> Email</th>
                            <th> Phone</th>
                            <th> Address</th>
                         <th> Registration Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($user as $usr) {
                            if($usr['user_type'] !== 'guest') {
                            ?>
                            <tr class="gradeA">
                                <td class="text-center"><?php echo $i; ?></td>
                                <td> <a href="<?php echo base_url(); ?>admin/order/manageorder/<?php echo $usr['user_id']; ?>" ><?php echo $usr['first_name']."&nbsp".$usr['last_name']; ?></a> </td>
                                <td>  <?php echo $usr['email_id']; ?></td>
                                <td> <?php if (!empty($usr['ph'])){echo $usr['ph'];} else {echo '-'; } ?> </td>
                                <td> <?php if(!empty($usr['adr'])) {
                                    $ct =  explode('-', $usr['ctry']); 
                              $st =  explode('-', $usr['st']); 
                                    echo $usr['adr']."<br/>".$usr['ct'].','.$st['0']."</br>".$ct['0'].','.$usr['zip'] ; } else echo '-'?> </td>
                              <td>  <?php echo $usr['date']; ?></td>
                                <td >
 <a  onclick="return confirm('Are you sure! You want  to delete this user ?');" href="<?php echo base_url(); ?>admin/user/deleteuser/<?php echo $usr['user_id']; ?>" onClick="return confirm('Delete This account?')" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Customer" /> </a> 
                                </td>
                            </tr>
                            <?php
                            $i++;
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