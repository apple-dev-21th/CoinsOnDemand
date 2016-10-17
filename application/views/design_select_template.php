<?php
if ($this->uri->segment(3)) {
    @$id = $this->uri->segment(3);
} else {
    @$id = $category_name['0']['id'];
}
?>
<div class="container white padding_30">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">

            <div class="glossymenu">
                  <div class="row">
                    <div class="col-md-3 pad_top_9">
                <a headerindex="0h" class="menuitem submenuheader about_header" href=""><?php if(!empty($category_name['0']['category_name'])) {echo $category_name['0']['category_name'];} else {if(!empty($search)){echo $search;} }?> Coins</a>
                    </div>

                          <div class="col-md-6">
    <img src="<?php echo base_url();?>assets/images/frame_work.jpg"  class="width610">
</div>
                    <div class="col-md-2 text-right pad_top_13">
                        <a href="<?php echo base_url();?>more_themes/"  class="pull-right"><img src="<?php echo base_url();?>assets/images/clickme.png" class="img-responsive"> </a>
                          
                    </div>
                </div>
                <br>
                <div class="clearfix"></div>


                <div class="row searchpanel">
                    <form accept-charset="utf-8" method="post" action="<?php echo base_url(); ?>select_template/search"> 
                        <div class="col-md-5">
                            <p><b>Choose another category</b></p>

                            <select name="catg_id" class="form-control" onchange="getcoins(this.value)">
                                <?php foreach ($category as $catg) { ?>
                                    <option value='<?php echo $catg['cat_id']; ?>'  <?php if ($id == $catg['cat_id']) echo 'selected="selected"'; ?>><?php echo $catg['category_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-7 col-sm-6 col-xs-6 text-right">
                            <button class="btn submit_btn mar_top_0" type="submit">Go </button>
                            <input type="text" name="searchkey" class="form-control" id="inputEmail3" placeholder="Enter Search Keyword" value="<?php if(!empty($search)){echo $search;}?>">
                        </div>
                    </form>
                </div>
                <div class="row">
                    
                    <?php
                   // echo '<pre>'; print_r($template);
                    if(!empty($template)){ $i = 1;
                    foreach ($template as $coin) {
                        ?>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-center coins_cat">
                            <div class="coin_img">
                                <a href="javascript:void(0)" type="submit" onclick="createsessiontemplate(<?php echo $coin['coin_id']; ?>)"> <img src="<?php echo base_url() ?>assets/uploads/<?php echo $coin['coin_image']; ?>" alt=""> </a></div>
<!--                            <p class="review_text"><?php echo $coin['coin_name']; ?><br><span class="coin_price">$<?php echo $coin['coin_price']; ?></span></p>-->
                            <a href="javascript:void(0)"class="btn submit_btn mar_top_0 p_coin" type="submit" onclick="createsessiontemplate(<?php echo $coin['coin_id']; ?>)">Personalize this coin </a>
                        </div>
                         <?php if ($i % 4 == 0) {
                            echo ' </div>
                   <div class="row margin_top_15">';
                        }
                        $i++;
                         } ?>
                        <?php 
                    }else {echo '<div class="col-lg-12 col-md-12 col-xs-12"><div class="menuitem submenuheader about_header" style="color:#fff">Nothing found please change the category/keyword.</div></div> '; }?>
                </div>
                <div class="clearfix"></div>
<?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
<script>
function getcoins(id){
    window.location.href="<?php echo base_url().'select_template/design_template/';?>"+id;
}
function createsessiontemplate(id) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url();?>select_template/createsession/',
                    data: {cointemplate: id},
                    success: function(data) {
                        if (data == '1') {
                           window.location.href = '<?php echo base_url();?>personalizedcoin/select_coin/designtemplate';
                        }
                    }
                });
            }
</script>

