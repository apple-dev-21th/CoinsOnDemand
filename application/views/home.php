
<script src="<?php echo base_url();?>assets/js/light-box-lib.js" type="text/javascript"> </script>
<link href="<?php echo base_url();?>assets/css/light-box-style.css" type="text/css" rel="stylesheet">

<script>
    function resetCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ';domain=<?php echo  COOKIE_URL; ?>;path=/';
    }
        
    resetCookie("imgstyle", '', 0);
    resetCookie("design_template", '', 0);
    resetCookie("toptxt", '', 0);
    resetCookie("bottomtxt", '', 0);
    resetCookie("fbimg", '', 0);
    resetCookie("fontsize", '', 0);
    resetCookie("curvetop", '', 0);
    resetCookie("curvebottom", '', 0);
    resetCookie("toptxtstyle", '', 0);
    resetCookie("bottomtxtstyle", '', 0);
</script>
    
<div class="outer_border2">
    <div class="patrn">
        <div class="container">
            <div class="row">
                <div class="text-center navigation middle-menu">
                    <ul class="nav  nav-pills smtp">
                        <?php
                        $i=1;
                        foreach($category as $catg ){
                            if($i<=9) {?>
                                <li>
                                    <a href="<?php echo base_url(); ?>select_template/index/<?php echo $catg ['id']; ?>"><?php echo $catg ['category_name']; ?></a>
                                </li>
                            <?php } $i++; } ?>
                        <li><a href="<?php echo base_url();?>more_themes">More Themes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container first-child">
    <div class="row">
        <div class="united_text padding-top-xs-15"><img src="<?php echo base_url() ?>assets/img/full_color.png" alt="" style="width: 66%;"/></div>
        <!--<div class="silver_coin"><img src="<?php /*echo base_url() */?>assets/img/mock.gif" alt="" class="img-responsive"/></div>
        <div class="descrip" > Put your photos, designs, logo and/or text on a Genuine
            U.S. Coin in <span class="ctext"><b>FULL COLOR!</b></span><br>
            <span class="ctext"><b>&middot; Kennedy Half Dollar &middot;</b></span><br>
            <span class="ctext"><b>&middot; American Eagle 1oz. .999 Fine Silver Coin &middot;</b></span><br>
            These uncirculated coins are the largest coins currently minted and are not available in any bank or general circulation</div>

        <div class="personalize" href="<?php /*echo base_url(); */?>personalizedcoin/select_coin/">
            <img src="<?php /*echo base_url() */?>assets/img/eagle-for-home.gif" alt="" style="width:318px; height: 270px;"/>
        </div>-->
    </div>

    <div class="row  padding-top-xs-20">
        <div class="col-xs-6">
            <img src="<?php echo base_url() ?>assets/img/choose_from.png" alt=""/>

            <a href="<?php echo base_url(); ?>personalizedcoin/select_coin/">
                <img src="<?php echo base_url() ?>assets/img/demand_coins_now.png" alt="" style="display: inline-block; margin-top: 15px;"/>
            </a>
        </div>
        <div class="col-xs-6">
            <img src="<?php echo base_url() ?>assets/img/coin1.png" alt=""/>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10">
            <img src="<?php echo base_url() ?>assets/img/easily_upload.png" alt="" style="margin-top: 22px; margin-left: 20px;"/>
            <img src="<?php echo base_url() ?>assets/img/computer.png" alt="" style="margin-left: 20px;"/>
            <img src="<?php echo base_url() ?>assets/img/phone.png" alt="" style="margin-left: 20px;"/>
            <img src="<?php echo base_url() ?>assets/img/facebook.png" alt="" style="margin-left: 20px; margin-top: 12px;"/>
            <img src="<?php echo base_url() ?>assets/img/instagram.png" alt="" style="margin-left: 20px; margin-top: 12px;"/>
        </div>

        <div class="col-lg-2">

        </div>
    </div>
</div>

<div class="container second-child">
    <div class="row text-center">
        <img src="<?php echo base_url() ?>assets/img/easy_to_create.png" alt=""/>
    </div>

    <div class="row margin-top-xs-15">
        <div class="col-xs-6" style="padding-left: 0px;">
            <a href="http://coinsondemand.com/more_themes">
                <img src="<?php echo base_url() ?>assets/img/enhance_design.png" alt="" style="width: 100%;" />
            </a>
        </div>

        <div class="col-xs-15">
            <div class="col-xs-6 text-right" style="padding-right: 0px;">
                <a href="http://coinsondemand.com/more_themes/design_library">
                    <img src="<?php echo base_url() ?>assets/img/no_have_photo.png" alt="" style="width: 100%;"/>
                </a>
            </div>
        </div>
    </div>

   <!-- <div class="row margin-top-xs-20">
        <div class="col-xs-4 text-center" style="padding-right: 0px;">
            <img src="<?php /*echo base_url() */?>assets/img/gold_plating.png" alt=""/>
        </div>

        <div class="col-xs-4 text-center" style="padding-right: 0px;">
            <img src="<?php /*echo base_url() */?>assets/img/deluxe_felt.png" alt=""/>
        </div>

        <div class="col-xs-4 text-center" style="padding-right: 0px;">
            <img src="<?php /*echo base_url() */?>assets/img/best_value.png" alt=""/>
        </div>
    </div>-->

    <div class="row margin-top-xs-20">
        <?php
        $j=1;
        foreach($home as $catg ){
            ?>
            <div class="col-xs-4 text-center">
                <?php if(!empty($catg['box_url'])) { ?>
                <a href="<?php echo $catg ['box_url']; ?>" <?php if(preg_match("/www.youtube.com/", $catg ['box_url'])) { echo ' rel="prettyPhoto"'; } ?>>
                    <?php } ?><div class="img_box">
                        <img src="<?php echo base_url() ?>assets/uploads/<?php echo $catg ['box_image']; ?>" alt="" class="img-responsive" id="img_blog"/>
                    </div> <?php if(!empty($catg['box_url'])) { ?>
                </a>
            <?php } ?>
                <?php if(!empty($catg ['box_name'])) {
                    if(!empty($catg['box_url'])) { ?>
                        <a href="<?php echo $catg ['box_url']; ?>" <?php if(preg_match("/www.youtube.com/", $catg ['box_url'])) { echo ' rel="prettyPhoto"'; } ?>>
                    <?php } ?>  <h3 class="minion_font"><?php echo $catg ['box_name']; ?></h3>
                    <?php if(!empty($catg['box_url'])) { ?> </a> <?php }
                } ?>
            </div>
            <?php if($j%3 == '0') { echo '</div><div class="row">'; }?>
            <?php $j++;  }?>

    </div>

</div>

<script type="text/javascript">
$(document).ready(function() {
    $("a[rel='prettyPhoto']").prettyPhoto({
         allow_resize: true, /* Resize the photos bigger than viewport. true/false */
        default_width: 700,
        default_height: 500,
        horizontal_padding: 20
    });
});
</script>