<div id="contentHeader">
    <h1>Manage Slider</h1>
</div> <!-- #contentHeader -->	
<div class="container">
    <div class="grid-24">	
        <?php $this->load->view('admin/include/flash'); ?>
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">Manage Slider</h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Slider Image</th>
                            <th>Slider order</th>
                            <th>Slide Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($slider as $slides) {
                            ?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td>
                                    <img src="<?php echo base_url(); ?>assets/uploads/<?php echo $slides['slider_image']; ?>" style="width: 300px;"  />
                                    <div class="actions">	
                                        <a href="<?php echo base_url(); ?>assets/uploads/<?php echo $slides['slider_image']; ?>" class="btn btn-primary btn-small lightbox">View</a>
                                    </div>
                                </td>
                                <td>
                                      <select onchange="getval(this, <?php echo $slides['id']; ?>);" id="slider_<?php echo $i;?>" >
                                                        <option value="">Select Order</option>
                            <?php for($j=1;$j<=$total_slider;$j++){  ?>
                                <option value="<?php echo $j; ?>" <?php if($j == $slides['order'])  { echo 'selected="selected"';}?>><?php echo $j; ?></option>
                            <?php  } ?>
                        </select>                                   
                                    
                                </td> 
                                <td><?php if ($slides['status'] == '1') { ?> <a href="<?php echo base_url(); ?>admin/slider/deact_slider/<?php echo $slides['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/yes.png" title="Deactivate" /> </a><?php } else { ?><a href="<?php echo base_url(); ?>admin/slider/activate_slider/<?php echo $slides['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Activate" /> </a> <?php } ?>
                                </td>
                                <td >
                                    <a onclick="return confirm('Are you sure! You want  to delete this Slider ?');" href="<?php echo base_url(); ?>admin/slider/delete_Slider/<?php echo $slides['id']; ?>" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Slider" /> </a> 
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

   <script type="text/javascript">
    function getval(sel,id) {
       
       var parameter =  "sliderid=" + id + '&order=' + sel.value;
$.ajax({
                             type: "POST",
                             url: '<?php echo base_url(); ?>/admin/slider/chagesliderorder/',
                             data:  parameter,
                             success: function(data) {
                                 alert(data);
                                 window.location.href='<?php echo base_url();?>admin/slider/manageslider';
                             }
                         }); // Store final image to session ends here     
    }

</script>