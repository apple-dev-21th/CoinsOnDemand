<?php //echo '<pre>'; print_r($category);  ?>
<div class="container white padding_30">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">

            <div class="glossymenu">
                <div class="row">
                    <div class="col-md-3 pad_top_9">
<a href="" class="menuitem submenuheader about_header" headerindex="0h">Design Library</a>
</div>

<div class="col-md-6">
    <img src="<?php echo base_url();?>assets/images/frame_work.jpg"  class="width610">
</div>
                    <div class="col-md-2 text-right pad_top_13">
                        <a href="<?php echo base_url();?>more_themes/"  class="pull-right"><img src="<?php echo base_url();?>assets/images/clickme.png" class="img-responsive"> </a>
                          
                    </div>           

</div><br>
                <div class="clearfix"></div>
                <div class="row">
                    <?php $i = 1;
                  foreach ($category as $catg) : ?>
                        <div class="col-md-3 col-sm-3 col-xs-3 text-center coins_cat">
                            <div class="coin_img">
                                <a  href="<?php echo base_url('select_template/design_template') . '/' . $catg['cat_id']; ?>"> <img alt="" src="<?php echo base_url() . 'assets/uploads/' . $catg['template_img']; ?>"> </a></div>
                            <a  class="btn submit_btn mar_top_0 p_coin" href="<?php echo base_url('select_template/design_template') . '/' . $catg['cat_id']; ?>"><?php echo $catg['category_name']; ?></a>
                        </div>
                        <?php
                        if ($i % 4 == 0) {
                            echo ' </div>
                   <div class="row margin_top_15">';
                        }
                        ?>

    <?php $i++;
endforeach; ?>
                </div>
                <div class="row margin_top_15">                                            
                </div>

                <div class="clearfix"></div>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>

    </div>
</div>
