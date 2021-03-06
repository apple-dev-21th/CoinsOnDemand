<script src="<?php echo base_url(); ?>assets/j/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/j/jquerypp.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/j/jquery.elastislide.js"></script>
<!--<script type="text/javascript">
        $( '#carousel' ).elastislide();
</script>-->
<style>
    #floatCurveText p {
        position: relative;
        text-align: center;
        top: 19px;
    }
    #floatCurveText{
        width: 100%;
        position: absolute;
        z-index: 99999;
        color: #fff;
    }
    .backpreview{
        left: 13px!important;
    }
    .coincorner{
        left:13px!important;
    }
    #dyn_img{
        left: 13px!important;
    }
    .coincorner1{
        left: 3px!important;
    }

    .activeBtn{
        background: #F47920!important;
        color:#FFF!important;
    }

</style>
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

<!-- Block 1 : jQuery code for handling common action like Zoom , Button style, Finding labels etx.  -->
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
        
        //Image Implementation with Coin Image
        $("#dyn_img img").attr("id", "test");
        $("#dyn_img img").attr("class", "rout");
        
    });
    
    //Change color for background of coin
    function changecolor() {
        var color = document.getElementById('coinbgcolor').value;
        $('.backpreview').css('background-color', color);
    }
    
    //Change COIN Outline Color
    function outlinecolor() {
        var outline = document.getElementById('outlinecolor').value;
        var color = '-1px 0' + outline + ', 0 1px' + outline + ', 1px 0' + outline + ', 0 -1px' + outline;
        $('#curvebottom').css('text-shadow', color);
        $('#floatCurveText').css('text-shadow', color);
    }
    
    //Change Font color
    function fontcolor() {
        var color = document.getElementById('fontcolor').value;
        $('#curvebottom').css('color', color);
        $('#floatCurveText').css('color', color);
    }
    
    //Change font style for COIN Text like "Mono, Arial etc"
    function changefont() {
        var font_size = $.trim(getCookie('fontsize'));
        var font = document.getElementById('changefont').value;
        //$('#curvebottom').css('font-family', font);
        //$('#floatCurveText').css('font-family', font);
        $('#coinTextFontStyle').val(font);
        $('#topCurvedText').remove();
        //call update function without direction will detect automatically
//        curveHandler.update();
//        curveHandler.handleCoinTextTop(1);
        
        //check for direction if top then will call topTextControll Otherwise will bottom to call
        
        console.log('current direction: '+$('#coinTextDirection').val());
        if($('#coinTextDirection').val()== 1){
            $("#upTextBtn").click();
            setTimeout(function(){
                $("#upTextBtn").click();
                console.log("calling write top second time")
            },1000);
        }else{
            $("#downTextBtn").click();
            setTimeout(function(){
                $("#downTextBtn").click();
                console.log("calling write bottom second time")
            },1000);
        }
    }
    
    //Function is not using ny more (Font size is staic yet )
    function changefontsize(size) {
        
    }
    
    //Method for first time call when "Top of circle" Button will be clicked
    function writetop() {
        $(".one").addClass('activeBtn');
        $(".second").removeClass('activeBtn');
        //setCookie("fontsize", 18, 1);
        //setCookie("curvetop", 160, 1);
        //Call updte function with drection to 1 (Means from the "Top")
        $('#coinTextDirection').val(1);
        curveHandler.handleCoinTextTop(1);
    }
    
    //Method for first time call when "Bottom of circle" Button will be clicked
    function writebottom() {
        $(".one").removeClass('activeBtn');
        $(".second").addClass('activeBtn');
        //setCookie("fontsize", 18, 1);
        // setCookie("curvetop", 160, 1);
        //Call updte function with drection to 1 (Means from the "Top")
        $('#coinTextDirection').val(-1);
        console.log('value down '+$('#coinTextDirection').val());
        curveHandler.handleCoinTextBottom(-1);
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
                    <input type="button" id="upTextBtn" class="one activeBtn" value="Top of Circle" onclick="writetop()">
                    <input type="button"  id="downTextBtn" class="second" value="Bottom of Circle" onclick="writebottom()">
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
                    <!--Hidden fields so that we can manage direction to every key up and down event-->
                    <input type="hidden" name="coinTextDirection" id="coinTextDirection" value="1">
                    <input type="hidden" name="coinTextFontStyle" id="coinTextFontStyle" value="">

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
                    <div id="floatCurveText"><p id="topCurvedText"></p></div>
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



<!--Change Template and get templete and save Image coordinate as well -->
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



<!--Code for saving IMAGE AND Setting up cookies These are the core function for the file-->
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
        var toptext = document.getElementById('floatCurveText');
        if (toptext !== null) {
            htmlContent = toptext.innerHTML,
            toptxt = toptext.textContent;
        }
        if (toptxt !== null) {
            setCookie("toptxt", toptxt, 1);
            var styletop = $("#floatCurveText").attr('style');
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
    
    function removetop() {
        $("#curvetops").remove();
        $(".one").attr("onclick", "writetop()");
        //$(".one").attr("id", "");
    }
    function removebottom() {
        $("#curvebottom").remove();
        $(".second").attr("onclick", "writebottom()");
        //$(".second").attr("id", "");
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


<!-- Description: For Updating Coin Text -->

<script>
    console.log('updating corniates');
    var curveHandler = {
        /*
         * @param:  Update coin text Like That is Selected for Top or Bottom
                       dir value 1 means text shown from TOP
                       dir value to -1 means text shown from bottom
         */
        update: function (dir) {
                
            //If direction is not being passed then it will fetch rom hidden field
            console.log('direction for the text'+dir);
            if(dir==undefined || dir=='' || dir==0){
                var _temp_dir=parseInt($('#coinTextDirection').val());
                dir = _temp_dir;
            }
            console.log("direction = " +   dir + "   --  " + _temp_dir);
            
            var text = '',
            size = 22,
            font = $('#coinTextFontStyle').val(),
            radius = 158;
            
//            console.log('With direction: '+dir);
            console.log('With Font Style: '+font);
            
            //Find Capital and small letters and then set radious
            
            //Find CAPITALS AND SMALL TEXT LENGTH
            var cointext = document.getElementById('cointext').value;
            var toptextnew =cointext.replace(/\s/g, '');
            toptextnew =jQuery.trim(toptextnew);
            
            console.log('Text: '+toptextnew);
            var cap=0;
            for (var i=0 ; i <= toptextnew.length; i++){
                if(checkstring(toptextnew.charAt(i)) == toptextnew.charAt(i)){
                    cap++;
                }
            }
            console.log('Text: '+cap);
            
            $('#topCurvedText').remove();
            //Check for caps
            if(cap > 10){ // For capital letters Top text
                radius = 156;
                size = 20;
                var spacing = curveHandler.spaceCount($('#cointext').val());
                var ltrCount = curveHandler.stringLength($('#cointext').val());
                var ltrSpacing = '-1px';
                
                if (font == 'Montaga') {
                    ltrSpacing = '-1.8px';
                }
                else if (font == 'Varela Round') {
                    ltrSpacing = '-1.7px';
                }
                else if (font == 'Cabin') {
                    ltrSpacing = '-0.9px';
                }
                else if (font == 'Crete Round'){
                    ltrSpacing = '-0.8px';
                }
                
                if(spacing<=4 && ltrCount>25){
                    ltrSpacing = '-2px';
                }
                text = '<p id="topCurvedText" style="letter-spacing:'+ltrSpacing+'">' + $('#cointext').val() + '</p>';
                console.log('now text capital'+text);
            }else{
                //check in accorance with font type
                var fontIs = $('#coinTextFontStyle').val();
                console.log('font is'+fontIs);
                var spacing = curveHandler.spaceCount($('#cointext').val());
                var ltrCount = curveHandler.stringLength($('#cointext').val());
                var ltrSpacing = '-1.5px';
                
                if(fontIs=='Varela Round' || fontIs=='Crete Round'){
                    radius = 153;
                    ltrSpacing = '-2px';
                }else{
                    radius = 160;
                    ltrSpacing = '-1px';
                }
                size = 26;
                text = '<p id="topCurvedText" style="margin-top:-7px;letter-spacing:'+ltrSpacing+'">' + $('#cointext').val() + '</p>';
                console.log('now text capital'+text);
            }
            console.log('radius: '+radius);     
            /*Check for font a get radious then */
            
            $('#floatCurveText').css({
                fontFamily: font,
                fontSize: size + 'px'
            }).html(text).find('p').arctext({
                radius: radius,
                dir:dir
            });
            
            if(dir==-1){
                $('#floatCurveText').find('p').css({
                    'margin-top':305
                })
            }
            
            //Setting up cokkies here
            setCookie("curvetop", radius, 1);
            setCookie("fontsize", fontSize, 1);
            
            /* call relevent functions */
            //                fontcolor();
            //                changecolor();
            //                changefont();
            //                outlinecolor();
        },
        handleCoinTextTop:function(dir){
        console. warn("handleCoinTextTop")
            $('#cointext').keyup( curveHandler.update(1) );
        },
        handleCoinTextBottom:function(dir){
            $('#cointext').keyup( curveHandler.update(-1) );
        },
        spaceCount:function(str){
            var string  = str.split(' ');
            return (string.length);
        },
        stringLength:function(str){
            return (str.length);
        }
    }
</script>