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
        <div class="row text-center" style="color: #65635c;">
            <ul class="nav  nav-pills smtp" style="margin-top: 0px; display: inline-block;">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <?php foreach($result as $menu) {?>
                    <li><a href="<?php echo base_url().$menu['slug']; ?>"><?php echo $menu['page_title']; ?></a></li>
                <?php } ?>

                <?php foreach($footer as $fot):?>
                    <li><a href="<?php echo base_url().$fot['slug']; ?>"><?php echo $fot['page_title']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12">
                <small style="color: #65635c; font-size: 15px;">
                    The Platform and Combination of Personalized Images on Genuine Coins is a Trademark of eCoins.
                    The Platform combination is used with permission of eCoins,
                    Inc. &copy;All Rights Reserved
                </small>
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
           //$("#floatCurveText").remove();
           // $("#bgcolor").append("<div id='floatCurveText'></div>");
            //$("#floatCurveText").append("<p id='topCurvedText'></p>");

           var toptextstyle  = decodeURIComponent(getCookie('toptxtstyle'));
           //alert(toptextstyle)
           var pTagStyle  = decodeURIComponent(getCookie('ptagstyle'));
           //var res = toptextstyle.split(";");
           //var fontfamily = res[3];
           //var res1 = fontfamily.split(":");
           //var font = res1[1];
           //alert(font);
          //alert(toptextstyle);
           //alert(pTagStyle);

           //$("#bgcolor").append("<div id='floatCurveText'></div>");
           var text = '<p id="topCurvedText">' + toptext + '</p>';

           //$('#floatCurveText').arctext({radius: curvetop});
           $('#floatCurveText').html(text).find('p').arctext({
                radius: curvetop,
                dir:1
           });
           $("#floatCurveText").find('p').attr('style', pTagStyle);
          $("#floatCurveText").attr('style', toptextstyle);
          //   $("#floatCurveText").css('font-family',font);
           $(".one").attr("onclick", "removetop()");
           //$(".one").attr("id", "active1");
           $('#cointext').val(toptext);

           console.log('my curve text after cookies:'+curvetop);
           console.log('my style for the curve:'+toptextstyle);
           console.log('P Tag style:'+pTagStyle);

    }
    if(bottomtext !== ''){
          var bottomtextstyle  = decodeURIComponent(getCookie('bottomtxtstyle'));
          var pTagStyle  = decodeURIComponent(getCookie('ptagstyle'));
          var text = '<p id="bottomCurvedText">' + bottomtext + '</p>';
          //$("#bgcolor").append("<div id='curvebottom'>" + bottomtext + "</div>");
         $("#floatCurveTextBottom").attr('style', bottomtextstyle);
          //$('#curvebottom').arctext({radius: curvebottom, dir: -1});
          $('#floatCurveTextBottom').html(text).find('p').arctext({
                radius: curvebottom,
                dir:-1
          });
          $("#floatCurveTextBottom").find('p').attr('style', pTagStyle);

          $(".second").attr("onclick", "removebottom()");
         //$(".second").attr("id", "active1");
          $('#cointext').val(bottomtext);
    }
});
</script>

<script>
    window.fbAsyncInit = function() {
     FB.init({appId: '745325645500119', cookie: true, status: true, xfbml: true, oauth: true});
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

<script type="text/javascript">
    function getstates(id) {
        var parameter = "regionid=" + id;
        //alert(parameter);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>/manageaddress/getstates',
            data: parameter,
            success: function(data) {
                $("#states").html(data);
            }
        });
    }
</script>

<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 962270502;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>

<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/962270502/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('6038-830-10-8587');/*]]>*/</script><noscript><a href="https://www.olark.com/site/6038-830-10-8587/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->