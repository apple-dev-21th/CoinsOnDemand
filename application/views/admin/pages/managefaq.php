<div id="contentHeader">
    <h1>Manage FAQ</h1>
</div> <!-- #contentHeader -->	
<div class="container">
    <div class="grid-24">	
        <?php $this->load->view('admin/include/flash'); ?>
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Manage FAQ</h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($faq as $faqs) {
                            $string= $faqs['answer'];
                            $string1 = character_limiter($string, 150);
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td><?php echo character_limiter($faqs['question'],50); ?></td>
                                <td><?php echo $string1; ?></td>
                                <td><?php if ($faqs['status'] == '1') { ?> <a href="<?php echo base_url(); ?>admin/page/deact_faq/<?php echo $faqs['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/yes.png" title="Deactivate" /> </a><?php } else { ?><a href="<?php echo base_url(); ?>admin/page/activate_faq/<?php echo $faqs['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Activate" /> </a> <?php } ?>
                                </td>
                                <td >
                                    <a onclick="return confirm('Are you sure! You want  to delete this FAQ ?');" href="<?php echo base_url(); ?>admin/page/delete_faq/<?php echo $faqs['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Page" /> </a> &nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/page/edit_faq/<?php echo $faqs['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/edit.png" title="Edit Page" /> </a>
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