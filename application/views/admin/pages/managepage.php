<div id="contentHeader">
    <h1>Manage Pages</h1>
</div> <!-- #contentHeader -->	
<div class="container">
    <div class="grid-24">	
        <?php $this->load->view('admin/include/flash'); ?>
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Manage Pages</h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Page Title</th>
                            <th>Page Description</th>
                            <th>URL</th>
                             <th>Menu Name</th>
                            <th>Menu Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($pages as $page) {
                            $string= strip_tags($page['page_desc']);
                            $string1 = character_limiter($string, 150);
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $page['page_title']; ?></td>
                                <td><?php echo $string1 ?></td>
                          <td><a href="<?php echo base_url().$page['slug']; ?>" target="_new" ><?php echo base_url().$page['slug']; ?></a></td>
                                <td><?php echo $page['menu']; ?></td>
                                <td><?php echo $page['menu_position']; ?></td>

                                <td > <a onclick="return confirm('WARNING: You are asking to delete the page! The Page will be removed from site. Please confirm if this is what you want to do.');" href="<?php echo base_url(); ?>admin/page/delete_page/<?php echo $page['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Page" /> </a>&nbsp;<a href="<?php echo base_url(); ?>admin/page/edit_page/<?php echo $page['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/edit.png" title="Edit Page" /> </a>
                                </td>
                            </tr>
                            <?php $i++;
                        }
                        ?>
                    </tbody>
                    </tbody>
                </table>
            </div> <!-- .widget-content -->
        </div> 
    </div>
</div>