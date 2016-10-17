<div id="contentHeader">
    <h1>Manage Box</h1>
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
                <h3 class="icon chart">List of Boxes</h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Box Name</th>
                            <th>Box Image</th>
                            <th>Show on Home</th>
                             <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($category as $catg) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td> <?php echo $catg['box_name']; ?> </td>
                                <td>
                                    <img src="<?php echo base_url(); ?>assets/uploads/<?php echo $catg['box_image']; ?>" style="width: 100px;"  />
                                </td>
                                <td><?php if ($catg['show_home'] == '1') { ?> <a href="<?php echo base_url(); ?>admin/box/deact_box/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/yes.png" title="Deactivate" /> </a><?php } else { ?><a href="<?php echo base_url(); ?>admin/box/activate_box/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Activate" /> </a> <?php } ?>
                                </td>
                                <td><?php echo $catg['position']; ?> </td>
                                <td >
                                    <a  onclick="return confirm('Are you sure! You want  to delete this Box ?');" href="<?php echo base_url(); ?>admin/box/delete_box/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Box" /> </a> &nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/box/edit_box/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/edit.png" title="Edit Box" /> </a>
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