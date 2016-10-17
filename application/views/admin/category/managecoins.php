<div id="contentHeader">
    <h1>Manage Coins</h1>
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
                <h3 class="icon chart">List of coins </h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                  <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Category Name</th>
                            <th>Coin Name </th>
                            <th>Coin Image</th>
                            <th>Key Words</th>
                            <th> Design library</th>
                            <th>Status</th>
                            <th>Position </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                               <tbody>
                        <?php
                        $i = 1;
// echo '<pre>';             print_r($coins); die;
                        foreach ($coins as $catg) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td>
                                    <?php
                                    $coinid = explode(",", $catg['category_id']);
                                    //print_r($coinid);
                                    $vals = '';
                                    $total = count($coinid);
                                    $y=1;
                                    foreach ($category as $catn) {
                                        if (in_array($catn['id'], $coinid)) {
                                            if($y == '1')
                                                $vals .= $catn['category_name'];
                                            else
                                                $vals .= ','.$catn['category_name'];
                                                $y++;
                                        }
                                  }
                                    echo $vals;
                                    ?>
                                    <?php // echo $catg['category_id']; ?>
                                </td>
                                <td><?php echo $catg['coin_name']; ?></td>
                                <td><img src="<?php echo base_url(); ?>assets/uploads/<?php echo $catg['coin_image']; ?>" style="width: 100px;"  /> </td>
                                <td>
                                    <?php echo $catg['keyword']; ?>
                                </td>
                                   <td>
                                    <?php if($catg['design_lib'] == '1') { echo 'Yes'; }else {echo 'No'; } ?>
                                </td>
                                                                <td><?php if ($catg['status'] == '1') { ?> <a href="<?php echo base_url(); ?>admin/category/deact_coin/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/yes.png" title="Deactivate Coin" /> </a><?php } else { ?><a href="<?php echo base_url(); ?>admin/category/activate_coin/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Activate" /> </a> <?php } ?>
                                </td>
                                <td> <?php if ( $catg['position'] == '9999'){ echo '-'; }else{ echo $catg['position']; }?></td>
                                <td >
                                    <a  onclick="return confirm('WARNING: You are asking to delete the coin! The coin will be removed from site. Please confirm if this is what you want to do.');" href="<?php echo base_url(); ?>admin/category/delete_coin/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Coin" /> </a> &nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/category/edit_coin/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/edit.png" title="Edit Coin" /> </a>
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