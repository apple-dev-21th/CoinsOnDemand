<div id="contentHeader">
    <h1>Manage Categories</h1>
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
                <h3 class="icon chart">List of Categories</h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            <th>Featured</th>
                            <th>Active</th>
                            <th>Design Library</th>
                             <th>Art Frame</th>
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
                                <td> <?php echo $catg['category_name']; ?> </td>
                                <td>
                             <?php if(!empty($catg['category_image'])){ ?>
                                    <img src="<?php echo base_url(); ?>assets/uploads/<?php echo $catg['category_image']; ?>" style="width: 100px;"  />
                             <?php } else { ?>
                                      <img src="<?php echo base_url(); ?>assets/uploads/<?php echo $catg['template_img']; ?>" style="width: 100px;"  />
                             <?php } ?>
                                </td>
                                <td><?php if ($catg['featured_catg'] == '1') { ?> <a href="<?php echo base_url(); ?>admin/category/deact_catg/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/yes.png" title="Deactivate" /> </a><?php } else { ?><a href="<?php echo base_url(); ?>admin/category/activate_catg/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Activate" /> </a> <?php } ?>
                                </td>
                                <td><?php if ($catg['status'] == '1') { ?> <a href="<?php echo base_url(); ?>admin/category/inact_cat/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/yes.png" title="Deactivate" /> </a><?php } else { ?><a href="<?php echo base_url(); ?>admin/category/act_cat/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Activate" /> </a> <?php } ?>
                                </td>
                                <td> <?php if($catg['design_temp'] == '1') { echo 'Yes'; } else {echo 'No'; }  ?></td> 
                                <td> <?php if($catg['art_frame'] == '1') { echo 'Yes'; } else {echo 'No'; }  ?></td>
                                <td >
                                    <a onclick="return confirm('WARNING: You are asking to delete the category! The category will be removed from site. Please confirm if this is what you want to do.');" href="<?php echo base_url(); ?>admin/category/delete_catg/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Category" /> </a> &nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/category/edit_catg/<?php echo $catg['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/edit.png" title="Edit Category" /> </a>
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