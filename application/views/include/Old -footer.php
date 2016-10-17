<?php 
$this->db->where('menu', 'header');
        $this->db->order_by('menu_position', 'ASC');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('pages');
        $result = $query->result_array();
        
          $this->db->where('menu', 'footer');
        $this->db->order_by('menu_position', 'ASC');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('pages');
        $footer = $query->result_array();
      

?>
<footer>
    <div class="container">
        <div class="col-lg-4">
            <div class="footer_logo">
                <img src="<?php echo base_url() ?>assets/img/footer_logo1.png" alt=""/>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="nav  nav-pills smtp" >
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <?php foreach($result as $menu) {?>
                            <li><a href="<?php echo base_url().$menu['slug']; ?>"><?php echo $menu['page_title']; ?></a></li>
                <?php } ?>
<!--                <li><a href="<?php //echo base_url(); ?>about">About</a></li>
                <li><a href="<?php //echo base_url(); ?>coins">Coins</a></li>
                <li><a href="<?php// echo base_url(); ?>goldcards">Gold Cards </a></li>
                <li><a href="<?php// echo base_url(); ?>pricing">Pricing</a></li>
                <li><a href="<?php //echo base_url(); ?>faq">FAQ</a></li>
                <li><a href="<?php //echo base_url(); ?>contactus"> Contact Us</a></li>-->
            </ul>
            <ul class="nav  nav-pills">
                <?php foreach($footer as $fot):?>
                <li><a href="<?php echo base_url().$fot['slug']; ?>"><?php echo $fot['page_title']; ?></a></li>
                <?php endforeach; ?>
<!--                <li><a href="<?php echo base_url(); ?>privacypolicy">Privacy Policy </a></li>
                <li><a href="<?php echo base_url(); ?>shippingpolicy">Shipping Policy</a></li>
                <li><a href="<?php echo base_url(); ?>termandcondition">Terms & Conditions </a></li>-->
            </ul>

        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12">
                <small> &copy;ecoins.com Inc. eCoins is not affiliated with the U.S.Mint or any government agency.
                <span style="float: right;" ><b><i>The Platform and Combination of Personalized Images on Genuine Coins is a Trademark of eCoins.com </span>
</i></b> </small>
            </div>
        </div>
    </div>

</footer>
<script src="<?php echo base_url() ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        if ($(".item:last-child").hasClass('active')) {
            $('.carousel').carousel(1);
        }
    });
</script>
<script type="text/javascript">
    $.noConflict();
    $(document).ready(function(e) {
    });
    $(document).ready(function() {
        $(document).ajaxStart(function() {
            $(" #loader").show();
        }).ajaxStop(function() {
            $(" #loader").hide();
        });
    });

</script>
</body>
</html>
<script>
$(window).bind("load", function() {
    var imgstyle  = decodeURIComponent(getCookie('imgstyle'));
    if(imgstyle !== ''){
        
          $("#test").attr('style', imgstyle);
}
var toptext  = getCookie('toptxt');
var bottomtext  = getCookie('bottomtxt');
var curvetop  = getCookie('curvetop');
var curvebottom  = getCookie('curvebottom');
 if(toptext !== ''){
      var toptextstyle  = decodeURIComponent(getCookie('toptxtstyle'));
       $("#bgcolor").append("<div id='curvetops'>" + toptext + "</div>");
       $("#curvetops").attr('style', toptextstyle);
       $('#curvetops').arctext({radius: curvetop});
         $(".one").attr("onclick", "removetop()");
        $(".one").attr("id", "active1");
        $('#cointext').val(toptext);
}
if(bottomtext !== ''){
      var bottomtextstyle  = decodeURIComponent(getCookie('bottomtxtstyle'));
       $("#bgcolor").append("<div id='curvebottom'>" + bottomtext + "</div>");
       $("#curvebottom").attr('style', bottomtextstyle);
      $('#curvebottom').arctext({radius: curvebottom, dir: -1});
       $(".second").attr("onclick", "removebottom()");
        $(".second").attr("id", "active1");
        $('#cointext').val(bottomtext);
}
    });
</script>
<script>
            window.fbAsyncInit = function() {
             FB.init({appId: '1459172494304874', cookie: true, status: true, xfbml: true, oauth: true});
                FB.getLoginStatus(function(response) {
                    if (response.authResponse) {
                        $("#login-status").html("Logged in");
                    } else {
                        $("#login-status").html("Not logged in");
                    }
                });
            };
            (function(d) {
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement('script');
                js.id = id;
                js.async = true;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&status=0";
                ref.parentNode.insertBefore(js, ref);
            }(document));
        </script>