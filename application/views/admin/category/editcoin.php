<script type="text/javascript" src="<?php echo base_url() ?>assets/javascripts/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/javascripts/jquery-ui-1.8.13.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/javascripts/ui.dropdownchecklist.js"></script>

        <script type="text/javascript">
            $( window ).load(function() {
                $("#chkveg").dropdownchecklist("refresh");
                   $("#chkveg").dropdownchecklist({
                });

                //$('select option').removeProp('selected');
                //for jquery < 1.6
                //$('select option').removeAttr('selected');
            });
        </script>
<div id="contentHeader">
    <h1>Edit Coin</h1>
    <div id="contentHeaderBevel"></div></div>
<div class="container">
    <div class="grid-24">
        <div class="widget" style="overflow: visible;">
            <div class="widget-content">
                <br>
                <?php if (validation_errors()) { ?>
                    <div class="notify notify-error">
                        <a href="javascript:;" class="close">×</a>
                        <h3>Error Notifty</h3>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php
                }
                $this->load->view('admin/include/flash');
                ?>
                <?php
                echo form_open_multipart('admin/category/updatecoin', array('class' => 'form uniformForm'));
                ?>

<!--                <div class="field-group">		
                    <label>Select Category:</label>

                    <div class="field">
                        
                            <select  name="categoryid" >
                                <option value="">Select category</option>
                                <?php foreach($category as $cat ){ ?>
                                <option value="<?php echo $cat['id']; ?>" <?php if( $coin_detail[0]['category_id'] == $cat['id']) echo 'selected="selected"'; ?> ><?php echo $cat['category_name']; ?></option>
                                <?php } ?>
                               
                            </select>
                        
                    </div>		
                </div>-->
<?php
 $coinid = explode(",", $coin_detail[0]['category_id']);                                    
?>
<div class="">		
                    <label>Select Category:</label>
                    <div class="">
                        <select multiple="multiple" name="categoryid[]" id="chkveg" >
                            <?php 
                            foreach ($category as $cat) { ?>
                                <option value="<?php echo $cat['id']; ?>" <?php if (in_array($cat['id'], $coinid)) echo 'selected="selected"'; ?> ><?php echo $cat['category_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>		
                </div>


                <div class="field-group">

                    <label for="file_name">Coin Name:</label>

                    <div class="field">
                        <input type="text" id="coin_name" name="coin_name" value="<?php echo $coin_detail['0']['coin_name']; ?>">

                    </div> 

                </div>
<!--                <div class="field-group">

                    <label for="file_name">Coin Price:</label>

                    <div class="field">
                        <input type="text" id="coin_price" name="coin_price" value="<?php //echo $coin_detail['0']['coin_price']; ?>">

                    </div> 

                </div>-->
                <div class="field-group">

                    <label for="file_name">KeyWord:</label>

                    <div class="field">
<!--                        <input type="text" id="key_word" name="key_word" value="<?php echo $coin_detail['0']['keyword']; ?>">-->
                        <textarea name="key_word"> <?php echo $coin_detail['0']['keyword']; ?></textarea>

                    </div> 

                </div>
                <div class="field-group">

                    <label for="file_upload">Coin Image:</label>

                    <div class="field">
                        <input type="file" id="coin_image" name="coin_image" size="19" >
                    </div> <!-- .field -->

                </div>
                <div class="widget-content">
           <img src="<?php echo base_url(); ?>assets/uploads/<?php echo $coin_detail['0']['coin_image']; ?>">		
                        </div>
 <div class="field-group control-group">	
                    <label>Design Library:</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1"><span class=""><input type="checkbox" value="1" id="design_lib" name="design_lib" style="opacity: 1;" <?php if($coin_detail['0']['design_lib'] == '1'){echo 'checked="checked"'; }?>></span></div>
                        <label for="checkbox1">Yes</label>
                    </div>
 </div>
<div class="field-group control-group">	
                    <label>Status:</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1"><span class=""><input type="checkbox" value="1" id="status" name="status" style="opacity: 1;" <?php if($coin_detail['0']['status'] == '1'){echo 'checked="checked"'; }?>></span></div>
                        <label for="checkbox1">Active</label>
                    </div>
 </div>
 <div class="field-group">
                        <label for="email">Order</label>
                        <div class="field">
                        <select name="coin_order" >
                                                        <option value="">Select Order</option>
                            <?php for($i=1;$i<=$total_coin;$i++){  ?>
                                <option value="<?php echo $i; ?>" <?php if($coin_detail['0']['position'] == $i) { echo 'selected="selected"';}?>><?php echo $i; ?></option>
                            <?php  } ?>
                        </select>
                    </div>
                    </div>
                <div class="actions">
                    <input type="hidden" name="coin_id" value='<?php echo $coin_detail['0']['id']; ?>' >
                    <button class="btn btn-primary" type="submit" >Update Coin</button>
                    <a href="<?php echo base_url('admin/category/managecoins');?>" class="btn btn-primary" type="submit" >Cancel Update</a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>

