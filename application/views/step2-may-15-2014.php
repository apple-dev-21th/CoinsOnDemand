<script src="<?php echo base_url(); ?>assets/j/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/j/jquerypp.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/j/jquery.elastislide.js"></script>
<!--<script type="text/javascript">
        $( '#carousel' ).elastislide();
</script>-->
<?php

function get_user_browser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if (preg_match('/MSIE/', $u_agent)) {
        $ub = "ie";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $ub = "firefox";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $ub = "safari";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $ub = "chrome";
    } elseif (preg_match('/Flock/i', $u_agent)) {
        $ub = "flock";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $ub = "opera";
    }
    return $ub;
}
$template_img = $this->session->userdata('templatimg');
$browser = get_user_browser();
?>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/canvas2image.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/base64.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/html2canvas.js"></script>
<style type="text/css">
<?php 
if (!empty($template_img)) {
    ?>  .coincorner {
            display:block;
        }
        .removearttheme {
            display:block;
        }
    <?php
}
?>
</style>
<script type="text/javascript">
    var $ = jQuery;
    var fbimg = getCookie('fbimg');
    $(document).ready(function() {
        var iv1 = $("#dyn_img").iviewer({
            src: fbimg,
            update_on_resize: true,
            zoom_animation: true,
            mousewheel: true,
            onMouseMove: function(ev, coords) {
            },
            onStartDrag: function(ev, coords) {
                return false;
            }, //this image will not be dragged
            onDrag: function(ev, coords) {
            }
        });
        $("#in").click(function() {
            iv1.iviewer('zoom_by', 1);
        });
        $("#out").click(function() {
            iv1.iviewer('zoom_by', -1);
        });
        $("#rin").click(function() {
            iv1.iviewer('angle', -10);
        });
        $("#rout").click(function() {
            iv1.iviewer('angle', 10);
        });

    });
    function changecolor() {
        var color = document.getElementById('coinbgcolor').value;
        $('.backpreview').css('background-color', color);
    }
    function outlinecolor() {
        var outline = document.getElementById('outlinecolor').value;
        var color = '-1px 0' + outline + ', 0 1px' + outline + ', 1px 0' + outline + ', 0 -1px' + outline;
        $('#curvebottom').css('text-shadow', color);
        $('#curvetops').css('text-shadow', color);
    }
    function fontcolor() {
        var color = document.getElementById('fontcolor').value;
        $('#curvebottom').css('color', color);
        $('#curvetops').css('color', color);
    }
    function changefont() {
        var font_size = $.trim(getCookie('fontsize'));
        var font = document.getElementById('changefont').value;
        $('#curvebottom').css('font-family', font);
        $('#curvetops').css('font-family', font);
        changefontsize(font_size);
    }
    function changefontsize(size) {
        setCookie("fontsize", size, 1);
        var font = $.trim(document.getElementById('changefont').value);
        var bottomtext = null;
        var toptext = null;
        var toptextnew = null;
        var bottomtextnew = null;
        var text = document.getElementById('cointext').value;
        var node = document.getElementById('curvetops');
        if (node !== null) {
            htmlContent = node.innerHTML,
                    toptext = node.textContent;
            toptextnew =toptext.replace(/\s/g, '');
            toptextnew =jQuery.trim(toptextnew);
        }
        var bottom = document.getElementById('curvebottom');
        if (bottom !== null) {
            htmlContent = bottom.innerHTML,
                    bottomtext = bottom.textContent;
             bottomtextnew =bottomtext.replace(/\s/g, '');
            bottomtextnew =jQuery.trim(bottomtextnew);
            var len = bottomtext.length;
        }
        if (size === '22' || size === 22) {
            if (toptext !== null) {
                var i=0; // Top Text 
                var cap=0;
                while (i <= toptextnew.length)
                    {
                        if(checkstring(toptextnew.charAt(i)) == toptextnew.charAt(i))
                            {
                                cap++;
                            }
                            i++;
                    }
                $("#curvetops").remove();
                $("#bgcolor").append("<div id='curvetops'>" + toptext + "</div>");
                if(cap > 10){ // For capital letters Top text
                    
                     if (font == 'Montaga') {
                    $('#curvetops').arctext({radius: 70});
                     $('#curvetops').css('font-size', 18);
                    setCookie("curvetop", 70, 1);
                }
                else if (font == 'Varela Round') {
                    $('#curvetops').arctext({radius: 110});
                    $('#curvetops').css('font-size', 18);
                    setCookie("curvetop", 110, 1);
                }
                 else if (font == 'Cabin') {
                    $('#curvetops').arctext({radius: 160});
                    setCookie("curvetop", 160, 1);
                }
                else {
                    $('#curvetops').arctext({radius: 150});
                    setCookie("curvetop", 150, 1);
                }
                }else { // For lower letters top text
                if (font == 'Montaga') {
                    $('#curvetops').arctext({radius: 150});
                     $('#curvetops').css('right', 4);
                    setCookie("curvetop", 150, 1);
                }
                else if (font == 'Varela Round') {
                    $('#curvetops').arctext({radius: 140});
                    $('#curvetops').css('font-size', 19);
                    setCookie("curvetop", 140, 1);
                }
                 else if (font == 'Cabin') {
                    $('#curvetops').arctext({radius: 165});
                    setCookie("curvetop", 165, 1);
                }
                else {
                    $('#curvetops').arctext({radius: 150});
                    setCookie("curvetop", 150, 1);
                }
                }
            }
            if (bottomtext !== null) {
                var j=0;   // Bottom caps
                    var bcap =0; 
                    while (j <= bottomtextnew.length)
                    {
                        
                        if(checkstring(bottomtextnew.charAt(j)) == bottomtextnew.charAt(j))
                            {
                                bcap++;
                            }
                            j++;
                    }
                $("#curvebottom").remove();
                $("#bgcolor").append("<div id='curvebottom'>" + bottomtext + "</div>");
                if(bcap >  10) {  // For capital letters bottom text
                     if (font == 'Varela Round') {
                    $('#curvebottom').arctext({radius: 140, dir: -1});
                    $('#curvebottom').css('font-size', 18);
                    setCookie("curvebottom", 140, 1);
                }
                else if (font == 'Cabin') {
                    $('#curvebottom').arctext({radius: 160, dir: -1});
                    setCookie("curvebottom", 160, 1);
                } 
                 else if (font == 'Montaga') {
                    $('#curvebottom').arctext({radius: 110, dir: -1});
                    setCookie("curvebottom", 110, 1);
                    $('#curvebottom').css('font-size', 18);
                }else {
                    $('#curvebottom').arctext({radius: 150, dir: -1});
                    setCookie("curvebottom", 150, 1);
                }                    
                }else {  // For lower letters bottom text
                if (font == 'Varela Round') {
                    $('#curvebottom').arctext({radius: 150, dir: -1});
                    $('#curvebottom').css('font-size', 18);
                    setCookie("curvebottom", 150, 1);
                }
                else if (font == 'Cabin') {
                    $('#curvebottom').arctext({radius: 170, dir: -1});
                    setCookie("curvebottom", 170, 1);
                } 
                 else if (font == 'Montaga') {
                    $('#curvebottom').arctext({radius: 160, dir: -1});
                    setCookie("curvebottom", 160, 1);
                    $('#curvebottom').css('font-size', 18);
                }else {
                    $('#curvebottom').arctext({radius: 155, dir: -1});
                    setCookie("curvebottom", 155, 1);
                }
            }
         }
        }
        $('#curvebottom').css('font-family', font);
        $('#curvetops').css('font-family', font);
//        $('#curvebottom').css('font-size', size);
//        $('#curvetops').css('font-size', size);
        fontcolor();
        changecolor();
        outlinecolor();
    }
</script>
<script>
    $(document).ready(function() {
        $("#dyn_img img").attr("id", "test");
        $("#dyn_img img").attr("class", "rout");
    });
    function writetop() {
        var text = document.getElementById('cointext').value;
        var character = text.split("");
        var length = character.length;
        $("#curvetops").remove();
        $("#bgcolor").append("<div id='curvetops'>" + text + "</div>");
        $('#curvetops').arctext({radius: 150});
        $(".one").attr("onclick", "removetop()");
        $(".one").attr("id", "active1");
        setCookie("fontsize", 22, 1);
        setCookie("curvetop", 150, 1);
        fontcolor();
        changecolor();
        changefont();
        outlinecolor();
    }
    function writebottom() {
        var text = document.getElementById('cointext').value;
        $("#curvebottom").remove();
        $("#bgcolor").append("<div id='curvebottom'>" + text + "</div>");
        $('#curvebottom').arctext({radius: 150, dir: -1});
        $(".second").attr("onclick", "removebottom()");
        $(".second").attr("id", "active1");
        setCookie("fontsize", 22, 1);
        setCookie("curvebottom", 150, 1);
       fontcolor();
        changecolor();
        changefont();
        outlinecolor();
    }
    function removetop() {
        $("#curvetops").remove();
        $(".one").attr("onclick", "writetop()");
        $(".one").attr("id", "");
    }
    function removebottom() {
        $("#curvebottom").remove();
        $(".second").attr("onclick", "writebottom()");
        $(".second").attr("id", "");
    }
</script>
<div class="container white">
    <ul class="steps">
        <li ><a href="javascript:;">step1</a><span></span></li>
        <li class="second active"><a href="javascript:;">step2</a><span></span></li>
        <li><a href="javascript:;">step3</a><span></span></li>
    </ul>
    <div class="clearfix"></div>
    <div class="leftcont">
        <div class="glossymenu"> <a  id="step2" class="menuitem submenuheader " headerindex="0h">Step 1: Upload your photo</a> <a  class="menuitem submenuheader active" headerindex="1h">Step 2: Design your coin</a>
            <div class="submenu second1 open" contentindex="1c" style="display: none;">
                <select  name="category" class="theme" id="category" onchange="gettemplate(this.value)">
                    <option>Choose Art Theme from Categories</option>
                    <?php foreach ($category as $catg) { ?>
                        <option data-toggle="modal" data-target="#myModal" value="<?php echo $catg ['id']; ?>"><?php echo $catg ['category_name']; ?></option>
<?php } ?>
                </select>
                <div id="template_name" style="diplay:none" > </div>
                <select class="theme" name="coinbgcolor" id="coinbgcolor" onchange="changecolor()">
                    <option value="#B2B2AF">Background Color (optional)</option>
                    <option value="#FFFFFF">White </option>
                    <option value="#00008B">Navy </option>
                    <option value="#FF0000">Red </option>
                    <option value="#FFFF00">Yellow </option>
                    <option value="#FFDEAD">Off White </option>
                    <option value="#800000">Maroon </option>
                    <option value="#FF00FF">Magenta </option>
                    <option value="#32CD32">Lime Green </option>
                    <option value="#87CEEB">Sky Blue </option>
                    <option value="#000">Black </option>
                </select>
                <div class="clearfix"></div>
                <div class="zoom"> <a id="out" href="javascript:void(0)"></a> <span>Zoom</span> <a href="javascript:void(0)" id="in"></a> </div>
                &nbsp;
                <div class="zoom" style="float:right"> <a id="rin" href="javascript:void(0)"></a> <span>Rotate</span> <a href="javascript:void(0)" id="rout"></a> </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <div class="addtext">
                    <h4>Add Text</h4>
                    <textarea id="cointext"  maxlength="30" data-limit-input="30"></textarea>
                    <span>0 of 30 characters used</span> </div>
                <div class="forcolm">
                    <input type="button" class="one" value="Top of Circle" onclick="writetop()">
                    <input type="button" class="second" value="Bottom of Circle" onclick="writebottom()">
                    <select class="choosefont" name="changefont" id="changefont" onchange="changefont()">
                        <option>Fonts</option>
                        <option value="Montaga">Montaga</option>
                        <option value="Varela Round">Varela Round</option>
                        <option value="Crete Round">Crete Round</option>
                        <option value="Cabin">Cabin</option>
                    </select>
                    <select class="fontcolor" name="fontcolor" id="fontcolor" onchange="fontcolor()">
                        <option>Font Color</option>
                        <option value="#FFFFFF">White </option>
                        <option value="#00008B">Navy </option>
                        <option value="#FF0000">Red </option>
                        <option value="#FFFF00">Yellow </option>
                        <option value="#FFDEAD">Off White </option>
                        <option value="#800000">Maroon </option>
                        <option value="#FF00FF">Magenta </option>
                        <option value="#32CD32">Lime Green </option>
                        <option value="#87CEEB">Sky Blue </option>
                        <option value="#000">Black </option>
                    </select>
                    <select class="choosefont" name="outlinecolor" id="outlinecolor" onchange="outlinecolor()">
                        <option>Font Outline</option>
                        <option value="#FFFFFF">White </option>
                        <option value="#00008B">Navy </option>
                        <option value="#FF0000">Red </option>
                        <option value="#FFFF00">Yellow </option>
                        <option value="#FFDEAD">Off White </option>
                        <option value="#800000">Maroon </option>
                        <option value="#FF00FF">Magenta </option>
                        <option value="#32CD32">Lime Green </option>
                        <option value="#87CEEB">Sky Blue </option>
                    </select>
                </div>
                <!--        <div class="fontsize">
                          <h4>Font size</h4>
                          <a class="big" onclick="changefontsize(15);" href="javascript:;"></a> <a class="bigger" onclick="changefontsize(16);"  href="javascript:;"> </a> <a class="biggest" onclick="changefontsize(17);"   href="javascript:;"></a> </div>-->
                <div class="clearfix"></div>
            </div>
            <a href="" class="menuitem submenuheader" headerindex="2h">Step 3: Approve your design</a> </div>
    </div>
    <div class="rightcont">
        <div class="wrapper fullsizeofimagesave">
            <div class="inpreview" style="position: relative; height:430px; text-align: center;" id="mydiv">
                <div id="bgcolor" >
                    <div id="dyn_img"> </div>
                    <!--                        Coin corner with Template-->
                    <div class="backpreview"></div>
                    <div class="coincorner"  style="<?php
                    if (!empty($template_img)) {
                        echo 'background: url(' . base_url() . 'assets/uploads/' . $template_img . ') no-repeat;"';
                    }
                    ?>" > </div>
                    <div class="coincorner1" style="background: url(<?php echo base_url(); ?>outer_new_1.png)  no-repeat;"> </div>
                </div>
            </div>
            <div class="row">
                <div id ="templateslider"  style="display:none"> </div>
            </div>
            <div class="row" style="margin-top:50px;margin-top: 50px;position: absolute;top: 194px;width: 733px;">
                <div class="col-md-4 pull-left "> <a class="replace" href="<?php echo base_url(); ?>personalizedcoin/step1" onclick="saveimgstyle()"></a> <a class="startover" href="javascript:;" onclick="restfunction()"></a> 
                <a class="removearttheme" href="javascript:;" onclick="removetemplate()" style="display:none"></a>
                </div>
                <div class="col-md-6	 pull-right rightnext"> <a class="nextstep" href="javascript:;" onclick="saveimage()"></a>
                    <h3>Next Step</h3>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
    $("textarea[data-limit-input]").keyup(function() {
        var charLength = $(this).val().length;
        var charLimit = $(this).attr("data-limit-input");
        $(this).next("span").html(charLength + " of " + charLimit + " characters used");
    });
    function saveimage() {
        saveimgstyle(); // function to save image ,top text and bottom text style 
        transaformImageSize = getRotationDegrees($("#test"));
        $("#test").removeAttr("max-width");
        $("#test").css('transform', 'none');
        var images = $("#test").attr('src');
        var viewPortW = "350px";
        var viewPortH = "350px";
        var style = $("#test").attr('style');
        var selectorW = "350";
        var selectorH = "350";

<?php
$img = $this->session->userdata('templatimg');
?>
        var imageX = $("#test").attr('left');
        var imageY = $("#test").attr('top');
        var imageRotate = transaformImageSize;
        var imageSource = $("#test").attr('src');
        var color = document.getElementById('coinbgcolor').value;
        var Parameters = "viewPortW=" + viewPortW + "&viewPortH=" + viewPortH + "&style=" + style + "&selectorW=" + selectorW + "&selectorH=" + selectorH + "&imageX=" + imageX + "&imageY=" + imageY + "&imageRotate=" + imageRotate + "&imageSource=" + imageSource + "&bgcolor=" + color;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>resize_and_crop_imagick.php",
            data: Parameters,
            success: function(data) {
           // alert(data); return false;
                $("#test").attr('style', '');
                $("#test").attr('src', data);
                $(".coincorner").css('top', 13);
                $("#dyn_img").css('top', 12);
                $(".coincorner").css('z-index', '99999');
                $(".coincorner1").css('z-index', '99999');
                $(".coincorner1").attr('style', '');
                $(".backpreview").css('top', 12);
                if (stemplate !== 1) {
                    $(".coincorner").attr('style', '');
                }
                //return false;
                html2canvas([document.getElementById('bgcolor')], {
                    onrendered: function(canvas) {
                        var img = canvas.toDataURL("image/png");
                        var output = img.replace('data:image/png;base64,', '');
                        var output = encodeURIComponent(img);
                        var Parameters = "image=" + output + '&template=' + '<?php echo $this->session->userdata('templatimg'); ?>';
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>createcoin.php",
                            data: Parameters,
                            success: function(data) {  // Store final image to session  
          
                                $.ajax({
                                    type: "POST",
                                    url: '<?php echo base_url(); ?>select_template/finalcoin/',
                                    data: {finalcoin: data},
                                    success: function(data) {
                                     window.location.href = "<?php echo base_url(); ?>" + 'personalizedcoin/step3';
                                    }
                                }); // Store final image to session ends here        
                            }
                        }).done(function() {
                        });
                    }
                });
            }
        });
    }
    function gettemplate(id) {
        saveimgstyle();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>select_template/gettemplatename/',
            data: {categoryid: id},
            success: function(data) {
                $('#templateslider').css('display', 'block');
                $("#templateslider").html(data);
            }
        });
    }
    function changetemplate(img) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>select_template/templatesession/',
            data: {templatename: img},
            success: function(data) {
                var link = '<?php echo base_url(); ?>' + 'assets/uploads/' + data;
                $('.coincorner').css("display", "block");
                $('.coincorner').css("background", "url(" + link + ")");
                $('.coincorner').css("height", "350px");
                $('.coincorner').css("width", "350px");
                 $('.removearttheme').css("display", "block");
                
                stemplate = 1;
            }
        });
    }
    $("#bgcolor").mousedown(function(event) {
        $("#test").trigger(event);
    });
    $("#bgcolor").click(function() {
    });
</script> 
<script>
    function setCookie(cname, cvalue, exdays)
    {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ';domain=personalizedcoins.com;path=/';
    }
    function saveimgstyle() {
        var toptxt = null;
        var bottomtxt = null;
        var style = $("#test").attr('style');
        var parameter = encodeURIComponent(style);
        setCookie("imgstyle", parameter, 1);
        var toptext = document.getElementById('curvetops');
        if (toptext !== null) {
            htmlContent = toptext.innerHTML,
                    toptxt = toptext.textContent;
        }
        if (toptxt !== null) {
            setCookie("toptxt", toptxt, 1);
            var styletop = $("#curvetops").attr('style');
            var parametertop = encodeURIComponent(styletop);
            setCookie("toptxtstyle", parametertop, 1);
        } else {
            setCookie("toptxt", '', 0);
        }
        var bottomtext = document.getElementById('curvebottom');
        if (bottomtext !== null) {
            htmlContent = bottomtext.innerHTML,
                    bottomtxt = bottomtext.textContent;
        }
        if (bottomtxt !== null) {
            setCookie("bottomtxt", bottomtxt, 1);
            var styletop = $("#curvebottom").attr('style');
            var parameterbottom = encodeURIComponent(styletop);
            setCookie("bottomtxtstyle", parameterbottom, 1);
        } else {
            setCookie("bottomtxt", '', 0);
        }
    }
    function restfunction() {
        setCookie("imgstyle", '', 0);
        setCookie("toptxt", '', 0);
        setCookie("bottomtxt", '', 0);
        window.location.href = "<?php echo base_url() ?>";
    }
    function checkstring(str){
         return str.toUpperCase();
    }
    function removetemplate(){
         $(".coincorner").attr('style', '');
          $('.removearttheme').css("display", "none");
    }
</script>
<script>
<?php if (!empty($template_img)) { ?>
    $('.removearttheme').css("display", "block");
    $('.coincorner').css("display", "block");
            var stemplate = 1;
<?php } else { ?>
        var stemplate = '';
<?php } ?>
</script>