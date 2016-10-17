 <script type="text/javascript" src="<?php echo base_url() ?>assets/javascripts/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/javascripts/jquery-ui-1.8.13.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/javascripts/ui.dropdownchecklist.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#chkveg").dropdownchecklist({
                });
               // $('select option').removeProp('selected');
                //for jquery < 1.6
                //$('select option').removeAttr('selected');
            });
        </script>
<div id="contentHeader">
    <h1>Add Coin</h1>
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
                echo form_open_multipart('admin/category/insertcoin', array('class' => 'form uniformForm'));
                ?>
                <div class="">		
                    <label>Select Category:</label>
                    <div class="" style="position: relative;">
                        <select multiple="multiple" name="categoryid[]" id="chkveg" >
                            <?php 
                            if(isset($_POST['categoryid'])){
                         $count = count($_POST['categoryid']);
                            }else {
                                $count =0;
                            }
                            $i=0;
                            foreach ($category as $cat) { 
                                // echo $i;
                               // echo set_value("categoryid[$i]");
                              //  echo set_value("categoryid");
                                ?>
                                <option value="<?php echo $cat['id']; ?>" <?php 
                                for($j=0; $j<$count;$j++){
                                if ($_POST['categoryid'][$j] == $cat['id']) echo 'selected="selected"';  }?> >
                                    <?php echo $cat['category_name']; ?>
                                </option>
                            <?php $i++;  } ?>
                        </select>
                    </div>		
                </div>
                <div class="field-group">
                    <label for="file_name">Coin Name:</label>
                    <div class="field">
                <input type="text" id="coin_name" name="coin_name" value="<?php echo set_value('coin_name'); ?>">
                    </div> 
                </div>
<!--                <div class="field-group">
                    <label for="file_name">Coin Price:</label>

                    <div class="field">
                        <input type="text" id="coin_price" name="coin_price" value="<?php //echo set_value('coin_price'); ?>">

                    </div> 

                </div>-->
                <div class="field-group">

                    <label for="file_upload">Coin Image:</label>

                    <div class="field">    
                        <input type="file" id="coin_image" name="coin_image" size="19"  >
                       
                    </div> <!-- .field -->

                </div>
                  <div class="field-group">

                    <label for="file_name">KeyWord:</label>

                    <div class="field">
<!--                        <input type="text" id="coin_price" name="key_word" value="<?php echo set_value('key_word'); ?>">-->
                        <textarea name="key_word"><?php echo set_value('key_word'); ?></textarea>
                    </div> 

                </div>
 <div class="field-group control-group">	
                    <label>Design Library:</label>

                    <div class="field">
                <div class="checker" id="uniform-checkbox1">
                    <span class="">
 <input type="checkbox" value="1" id="design_lib" name="design_lib" style="opacity: 1;" <?php if(set_value('design_lib') == '1' ) { echo 'checked="checked"'; }?>>
                    </span></div>
                        <label for="checkbox1">Yes</label>
                    </div>
                </div>
<div class="field-group">
                        <label for="email">Order</label>
                        <div class="field">
                        <select name="coin_order" >
                                                        <option value="">Select Order</option>
                            <?php for($i=1;$i<=$total_coin+1;$i++){  ?>
                                <option value="<?php echo $i; ?>" <?php if(set_value('coin_order') == $i ){ echo 'selected="selected"'; } ?>><?php echo $i; ?></option>
                            <?php  } ?>
                        </select>
                    </div>
                    </div>
                <div class="actions">
                    <button class="btn btn-primary" type="submit" >Add Coin</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>
