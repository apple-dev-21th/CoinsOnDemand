<?php  /*phpinfo();*/  ?>
<div style="display: none">
    <img src="<?php echo base_url(); ?>assets/images/Processing_animate.gif" >
</div>


<!--[if lt IE 9]>
<script src="dist/html5shiv.js"></script>
<![endif]-->


<script src="<?php echo base_url(); ?>assets/j/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/j/jquerypp.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/j/jquery.elastislide.js"></script>
<script type="text/javascript" src="<?php echo base_url(''); ?>assets/j/circletype.js"></script>
<!--<script type="text/javascript">
        $( '#carousel' ).elastislide();
</script>-->
<style>
    #loader { display: none !important;}
    #floatCurveText p {
        margin-left: -13px;
        position: relative;
        text-align: center;
        top: 18px;
    }
    #floatCurveText,#floatCurveTextBottom{
        left:2px;
        width: 100%;
        position: absolute !important;
        z-index: 99999;
        color:  #939598 ;
        font-family: "Cabin";
    }
    #floatCurveTextBottom{

        height: 376px;
    }
    #topCurvedText {
        margin-top: -1px;


    }
    #bottomCurvedText {
        margin-left: -2px;
        position: absolute!important;
        bottom:10px;
        left:184px;

    }

    #cointext {
        text-transform: uppercase;
    }


    .backpreview{
        left: 9px!important;
    }
    .coincorner
    {
        height: 350px !important;
        left: 9px !important;
        top: 16px !important;
        width: 350px !important;
        border-radius: 173px !important;
    }

    #dyn_img{
        height: 350px !important;
        left: 9px !important;
        top: 16px;
        width: 350px !important;
        border-radius: 173px !important;
    }

    .coincorner1{
        left: 0px!important;
    }

    .activeBtn{
        background: #F47920!important;
        color:#FFF!important;
    }

    .mydivnew_processing{
        background: url("/assets/images/Processing_animate.gif") no-repeat scroll center center rgba(0, 0, 0, 0) !important;
        height: 100%;
        position: absolute;
        width: 100%;
        z-index: 100;
    }


    .n7_img_preload {
        width: 0px;
        height: 0px;
        display: inline;
        background-image: url("/assets/images/coinout_processing.png");
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

@$template_img = $this->session->userdata('templatimg');
$browser = get_user_browser();
?>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/canvas2image.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/base64.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/html2canvas-new.js"></script>
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
    console.log('ready');
    $(document).ready(function() {
        //reset display of text if coming back with text saved
        var interval = setInterval(function() {
            console.log('timeout');
            var topTextCookie = getCookie("toptxt");
            var bottomTextCookie = getCookie("bottomtxt");
            console.log("bottomLength: " + bottomTextCookie.length);
            console.log("length: " + bottomTextCookie.length);
            var temp_text = null; //hold text while resetting
            if (topTextCookie.length > 0) {
                // alert('here');
                // removetop();
                //$("#topCurvedText").remove();
                //writetop();
                //writetop();

                //$("#cointext").val(temp_text);
                //writetop();
                temp_text = topTextCookie;
                //$("#topCurvedText").remove();
                $("#cointext").val(temp_text);
                $('#topCurvedText').remove();
                $('#upTextBtn').removeClass("activeBtn");
                curveHandler.handleCoinTextTop(-1);
                $('#upTextBtn').addClass("activeBtn");
                temp_text = null;


            }

            if (bottomTextCookie.length > 0) {
                console.log('bottomCookie');
                temp_text = bottomTextCookie;
                //$("#bottomCurvedText").remove();
                $("#cointext").empty().val(temp_text);
                $('#downTextBtn').removeClass("activeBtn");
                $('#bottomCurvedText').remove();
                curveHandler.handleCoinTextBottom(-1);
                $('#downTextBtn').addClass("activeBtn");

                //writebottom();

                temp_text = null;

            }


        }, 500);

        setTimeout(function() {
            clearInterval(interval);
        }, 5000);



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
        if (outline !== '') {
            var color = '-1px 0' + outline + ', 0 1px' + outline + ', 1px 0' + outline + ', 0 -1px' + outline;
            $('#floatCurveTextBottom').css('text-shadow', color);
            $('#floatCurveText').css('text-shadow', color);
        } else {
            //var color = '0px 0' + outline + ', 0 0px' + outline + ', 0px 0' + outline + ', 0 0px' + outline;
            $('#floatCurveTextBottom').css('text-shadow', 'none');
            $('#floatCurveText').css('text-shadow', 'none');
        }
    }

    //Change Font color
    function fontcolor() {
        var color = document.getElementById('fontcolor').value;
        $('#floatCurveTextBottom').css('color', color);
        $('#floatCurveText').css('color', color);
    }

    //Change font style for COIN Text like "Mono, Arial etc"
    function changefont() {
        var font_size = $.trim(getCookie('fontsize'));
        var font = document.getElementById('changefont').value;
        //$('#curvebottom').css('font-family', font);
        //$('#floatCurveText').css('font-family', font);
        if (font != "Fonts")
        {
            $('#coinTextFontStyle').val(font);
        }
        else {
            font = "inherit";
            $('#coinTextFontStyle').val(font);
        }


//        $('#topCurvedText').remove();
//        $('#bottomCurvedText').remove();
//
        //check for direction if top then will call topTextControll Otherwise will bottom to call

        if ($('#upTextBtn').hasClass('activeBtn')) {
            toptext(1);
//            console.log('worling top');
//            $('#upTextBtn').removeClass('activeBtn');
//            $("#upTextBtn").click();
        }

        if ($('#downTextBtn').hasClass('activeBtn')) {
            updateBottomtxt(-1);
            //    console.log('worling bottom');
            //$('#downTextBtn').removeClass('activeBtn');
            // $("#downTextBtn").click();
        }

        //curveHandler.handleCoinTextTop(1);
        //curveHandler.handleCoinTextBottom(-1);
    }

    //Function is not using ny more (Font size is staic yet )
    function changefontsize(size) {

    }

    //Method for first time call when "Top of circle" Button will be clicked
    function writetop() {
        if ($('#upTextBtn').hasClass('activeBtn')) {
            $('#topCurvedText').remove();
            $(".one").removeClass('activeBtn');
        } else {
            $(".one").addClass('activeBtn');
            $('#coinTextDirection').val(1);
            //Call updte function with drection to 1 (Means from the "Top")
            curveHandler.handleCoinTextTop(1);
        }
    }

    //Method for first time call when "Bottom of circle" Button will be clicked
    function writebottom() {
        if ($('#downTextBtn').hasClass('activeBtn')) {
            $('#bottomCurvedText').remove();
            $(".second").removeClass('activeBtn');
        } else {
            $(".second").addClass('activeBtn');
            //Call updte function with drection to 1 (Means from the "Top")
            $('#coinTextDirection').val(-1);
//            console.log('value down '+$('#coinTextDirection').val());
            curveHandler.handleCoinTextBottom(-1);
        }
    }

</script>


<div class="container white">
    <ul class="steps">
        <li class="  active" style=""><a  class="fonts_color">step1</a></li>
        <li class="second active"><a >step2</a><span></span></li>
        <li><a  class="font_color">step3</a></li>
    </ul>
    <div class="clearfix"></div>
    <div class="leftcont">
        <div class="glossymenu">
             <a  class="menuitem submenuheader  font_color" style="display:none"></a>
            <a  id="step2" class="menuitem submenuheader font_color " headerindex="0h">Step 1: Upload your photo</a>
            <a  class="menuitem submenuheader active" headerindex="1h">Step 2: Design your coin</a>
            <div class="submenu second1 open" contentindex="1c" style="display: none;">
                <select  name="category" class="theme" id="category" onchange="gettemplate(this.value)">
                    <option>Choose Art Theme from Categories</option>
                    <?php foreach ($category as $catg) { ?>
                        <option data-toggle="modal" data-target="#myModal" value="<?php echo $catg ['cat_id']; ?>"><?php echo $catg ['category_name']; ?></option>
                    <?php } ?>
                </select>
                <div id="template_name" style="diplay:none" > </div>
                <select class="theme" name="coinbgcolor" id="coinbgcolor" onchange="changecolor()">
                    <option value="#B2B2AF">Background Color (optional)</option>
                    <option value="#000">Black </option>
                    <option value="#32CD32">Lime Green </option>
                    <option value="#800000">Maroon </option>
                    <option value="#FF00FF">Magenta </option>
                    <option value="#00008B">Navy </option>
                    <option value="#FFDEAD">Off White </option>
                    <option value="#FF0000">Red </option>
                    <option value="#87CEEB">Sky Blue </option>
                    <option value="#FFFFFF">White </option>
                    <option value="#FFFF00">Yellow </option>

                </select>
                <div class="clearfix"></div>
                <div class="zoom"> <a id="out" href="javascript:void(0)"></a> <span>Zoom</span> <a href="javascript:void(0)" id="in"></a> </div>
                &nbsp;
                <div class="zoom" style="float:right"> <a id="rin" href="javascript:void(0)"></a> <span>Rotate</span> <a href="javascript:void(0)" id="rout"></a> </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <div class="addtext">
                    <h4><font>Add Text</font>  <span style="font-size:12px;">(Text will appear in uppercase)</span></h4>
                    <textarea id="cointext"  maxlength="30" data-limit-input="30"></textarea>
                    <span>0 of 30 characters used</span> </div>
                <div class="forcolm">
                    <input type="button" id="upTextBtn" class="one" value="Top of Circle" onclick="writetop()">
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
                        <option value="#000">Black </option>
                        <option value="#939598">Gray </option>
                        <option value="#32CD32">Lime Green </option>
                        <option value="#800000">Maroon </option>
                        <option value="#FF00FF">Magenta </option>
                        <option value="#00008B">Navy </option>
                        <option value="#FFDEAD">Off White </option>
                        <option value="#FF0000">Red </option>
                        <option value="#87CEEB">Sky Blue </option>
                        <option value="#FFFFFF">White </option>
                        <option value="#FFFF00">Yellow </option>
                    </select>
                    <select class="choosefont" name="outlinecolor" id="outlinecolor" onchange="outlinecolor()">
                        <option>Font Outline</option>
                        <option value="">None </option>
                        <option value="#000">Black </option>
                         <option value="#939598">Gray </option>
                        <option value="#32CD32">Lime Green </option>
                        <option value="#800000">Maroon </option>
                        <option value="#FF00FF">Magenta </option>
                        <option value="#00008B">Navy </option>
                        <option value="#FFDEAD">Off White </option>
                        <option value="#FF0000">Red </option>
                        <option value="#87CEEB">Sky Blue </option>
                        <option value="#FFFFFF">White </option>
                        <option value="#FFFF00">Yellow </option>
                    </select>
                    <!--Hidden fields so that we can manage direction to every key up and down event-->
                    <input type="hidden" name="coinTextDirection" id="coinTextDirection" value="1">
                    <input type="hidden" name="coinTextFontStyle" id="coinTextFontStyle" value="">
                    <div class="loadsAllFontForFirstTime" style="opacity: 0;width: 0px;height: 0px;">
                        <p style="font-family: Montaga;">Test</p>
                        <p style="font-family: Varela Round;">Test</p>
                        <p style="font-family: Crete Round;">Test</p>
                        <p style="font-family: Cabin;">Test</p>
                    </div>
                </div>
                <!--        <div class="fontsize">
                          <h4>Font size</h4>
                          <a class="big" onclick="changefontsize(15);" href="javascript:;"></a> <a class="bigger" onclick="changefontsize(16);"  href="javascript:;"> </a> <a class="biggest" onclick="changefontsize(17);"   href="javascript:;"></a> </div>-->
                <div class="clearfix"></div>
            </div>
            <a  class="menuitem submenuheader font_color" headerindex="2h">Step 3: Approve your design</a> </div>
    </div>
    <div class="rightcont">
        <div class="wrapper fullsizeofimagesave" style="position:relative;">
            <div class="inpreview" style="position: relative; height:430px; text-align: center;" id="mydiv">
                <div class="mydivnew" name="mydivnew"></div>
                <div id="bgcolor" >
                    <div id="dyn_img"> </div>
                    <!--                        Coin corner with Template-->
                    <div class="backpreview"></div>
                    <div class="coincorner"  style=" <?php
                    if (!empty($template_img)) {
                        echo 'background: url(' . base_url() . 'assets/uploads/' . $template_img . ') no-repeat;"';
                    }
                    ?>" > </div>
                    <!--<div class="coincorner1" style="background: url(<?php //echo base_url();  ?>outer_new_1.png)  no-repeat;"> </div>-->
                    <div id="floatCurveText"><p id="topCurvedText"></p></div>
                    <div id="floatCurveTextBottom"><p id="bottomCurvedText"></p></div>
                </div>
            </div>
            <div class="row">
                <div id ="templateslider"  style="display:none"> </div>
            </div>

            <div class="row" style="position: absolute; z-index:1000; top:0px; left:0px; width:203px !important;">
                <div class="col-md-12 pull-left "> <a class="replace" href="<?php echo base_url(); ?>personalizedcoin/step1" onclick="saveimgstyle()"></a> <a class="startover" href="javascript:;" onclick="restfunction()"></a>
                    <a class="removearttheme" href="javascript:;" onclick="removetemplate()" style="display:none"></a>
                </div>

            </div>

            <div class="row" style="position: absolute; z-index:1000; top: 0px; right:0px; width: 203px;">

                <div class="col-md-12 pull-right rightnext"> <a class="nextstep" href="javascript:;" onclick="saveimage()"></a>

                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>


<div class="n7_img_preload"></div>


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
        var viewPortW = "351px";
        var viewPortH = "351px";
        var style = $("#test").attr('style');
        var selectorW = "351";
        var selectorH = "351";

<?php
$img = $this->session->userdata('templatimg');
?>
        $("[name=mydivnew]").addClass('mydivnew_processing');
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

                //$("#mydiv .mydivnew").css('background-image','url("/assets/images/coinout_processing.png") no-repeat scroll center center rgba(0, 0, 0, 0) !important');


                // alert(data); return false;
                $("#test").attr('style', '');
                $("#test").attr('src', data);
                //$(".coincorner").css('top', 11);
                //$("#dyn_img").css('top', 11);

                // $("#bgcolor").css('left', 41);
                $(".coincorner1").css('left', 0);
                $(".coincorner").css('margin-top', '-4px');
                $("#floatCurveText").css('margin-top', '-5px');
                $("#floatCurveTextBottom").css('margin-top', '-4px').css('margin-left', '-1px');
                $("#bottomCurvedText").css('margin-left', '-2px');
                // $("#floatCurveText p"      ).css('top', '16px', 'important').css('left','0px', 'important');
                //$("#floatCurveTextBottom p").css('bottom', '10px', 'important');
                //  $(".coincorner1").css('padding-left', 40);
                $("#dyn_img").css('margin-left', 1);
                $("#dyn_img").css('top', 10);
                // $(".coincorner1").css('left', 10);

                $(".coincorner").css('z-index', '99999');
                $(".coincorner1").css('z-index', '99999');
                $(".coincorner1").css('padding-left', '-10px');
                $(".coincorner1").css('display', 'none');
                //$(".coincorner1").attr('style', '');
                // $(".backpreview").css('top', 12);
                if (stemplate !== 1) {
                    // $(".coincorner").attr('style', '');
                }

//return false;
                html2canvas([document.getElementById('bgcolor')], {
                    letterRendering: true,
//                    logging:true,
                    allowTaint: true,
                    imageSmoothingEnabled: true,
                    onrendered: function(canvas) {
                        var img = canvas.toDataURL("image/png");
                        var output = img.replace('data:image/png;base64,', '');
                        var output = encodeURIComponent(img);
                        var Parameters = "image=" + output + '&template=' + '<?php echo $this->session->userdata('templatimg'); ?>';
                        img.webkitImageSmoothingEnabled = false;
                        img.mozImageSmoothingEnabled = false;
                        img.imageSmoothingEnabled = false;
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

                                        //  $("#floatCurveText p"      ).css('top',    '18px');
                                        //$("#floatCurveTextBottom p").css('bottom', '10px');

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
    $(".mydivnew").mousedown(function(event) {
        $("#test").trigger(event);
    });

</script>



<!--Code for saving IMAGE AND Setting up cookies These are the core function for the file-->
<script>
    function setCookie(cname, cvalue, exdays)
    {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ';domain=<?php echo COOKIE_URL; ?>;path=/';
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

            //save P Tag style
            var styletopPTag = $("#floatCurveText").find('p').attr('style');
            var parameterPTagTop = encodeURIComponent(styletopPTag);
            setCookie("ptagstyle", parameterPTagTop, 1);
        } else {
            setCookie("toptxt", '', 0);
        }
        var bottomtext = document.getElementById('floatCurveTextBottom');
        if (bottomtext !== null) {
            htmlContent = bottomtext.innerHTML,
                    bottomtxt = bottomtext.textContent;
        }
        if (bottomtxt !== null) {
            setCookie("bottomtxt", bottomtxt, 1);
            var styletop = $("#floatCurveTextBottom").attr('style');
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
    function checkstring(str) {
        return str.toUpperCase();
    }
    function removetemplate() {
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

    function getRotationDegrees(obj) {
        var matrix = obj.css("-webkit-transform") ||
                obj.css("-moz-transform") ||
                obj.css("-ms-transform") ||
                obj.css("-o-transform") ||
                obj.css("transform");
        console.log(matrix);
        if (matrix !== 'none') {

            var values = matrix.split('(')[1].split(')')[0].split(',');
            var a = values[0];
            var b = values[1];
            var angle = Math.round(Math.atan2(b, a) * (180 / Math.PI));
        } else {
            var angle = 0;
        }
        return (angle < 0) ? angle += 360 : angle;
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
    var curveHandler = {
        /*
         * @param:  Update coin text Like That is Selected for Top or Bottom
         dir value 1 means text shown from TOP
         dir value to -1 means text shown from bottom
         */
        update: function(dir) {

            //If direction is not being passed then it will fetch rom hidden field
            var text = '',
                    size = 22,
                    toptextstyle = decodeURIComponent(getCookie('toptxtstyle')),
                    font1 = $('#coinTextFontStyle').val(),
                    radius = 105;
            if (toptextstyle !== '') {
                var res = toptextstyle.split(";");
                 for (i = 0; i < res.length; i++) {
                    if (res[i].match(/font-family:*/)) {
                        var fontfamily = res[i];
                        var res1 = fontfamily.split(":");
                        var font = res1[1];
                    }
                }
            } else {
                font = font1;
            }

            console.log('With Font Style: ' + font);
            //Find Capital and small letters and then set radious

            //Find CAPITALS AND SMALL TEXT LENGTH
            var cointext = document.getElementById('cointext').value.toUpperCase();
            var toptextnew = cointext.replace(/\s/g, '');
            toptextnew = jQuery.trim(toptextnew);

            var cap = 0;
            for (var i = 0; i <= toptextnew.length; i++) {
                if (checkstring(toptextnew.charAt(i)) == toptextnew.charAt(i)) {
                    //cap++;
                }
            }

            $('#topCurvedText').remove();
            //Check for caps
            if (cap > 10) { // For capital letters Top text
                //check for charecter length
                var marginTop = '1px';
                radius = 195;
                size = 25.5;

                var spacing = curveHandler.spaceCount($('#cointext').val());
                var ltrCount = curveHandler.stringLength($('#cointext').val());
                var ltrSpacing = '-5px';

                if (font == 'Montaga') {
                    if (ltrCount <= 30 && ltrCount > 22) {
                        marginTop = '0px';
                        ltrSpacing = '-2.0px';
                    }
                    else if (ltrCount <= 22 && ltrCount > 20) {
                        marginTop = '0px';
                        ltrSpacing = '0px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        ltrSpacing = '2px';
                        marginTop = '0px';
                    }

                    else if (ltrCount <= 10) {
                        ltrSpacing = '2px';
                        marginTop = '0px';
                    }
                    else {
                        ltrSpacing = '-4.5px';
                    }
                }
                else if (font == 'Varela Round') {
                    size = 25.3;
                    if (ltrCount <= 25 && ltrCount > 22) {
                        ltrSpacing = '-2.5px';
                        marginTop = '0px';
                    }
                    else if (ltrCount <= 22 && ltrCount > 20) {
                        ltrSpacing = '-0.4px';
                        marginTop = '0px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        ltrSpacing = '-0.6px';
                        marginTop = '0px';
                    }

                    else if (ltrCount <= 10) {
                        marginTop = '-1px';
                        ltrSpacing = '0.6px';
                    }
                    else {
                        ltrSpacing = '-4px';
                    }
                }
                else if (font == 'Cabin') {

                    if (ltrCount <= 30 && ltrCount > 22) {
                        ltrSpacing = '-0.5px';
                        marginTop = '-1px';
                    }
                    else if (ltrCount <= 22 && ltrCount > 20) {
                        ltrSpacing = '1px';
                        marginTop = '-1px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        ltrSpacing = '1px';
                        marginTop = '-1px';
                    }
                    else if (ltrCount <= 10) {
                        ltrSpacing = '2.5px';
                        marginTop = '-1px';
                    }
                    else {
                        ltrSpacing = '-1.9px';
                        marginTop = '-1px';
                    }
                }
                else if (font == 'Crete Round') {

                    if (ltrCount <= 25 && ltrCount > 23) {
                        ltrSpacing = '-0.5px';
                        marginTop = '-1px';
                    }
                    else if (ltrCount <= 23 && ltrCount > 20) {
                        ltrSpacing = '1px';
                        marginTop = '-1px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        ltrSpacing = '1px';
                        marginTop = '-1px';
                    }
                    else if (ltrCount <= 10) {
                        ltrSpacing = '1px';
                        marginTop = '-1px';
                    }
                    else {
                        ltrSpacing = '3px';
                        marginTop = '-1px';
                    }

                } else {
                    if (ltrCount <= 26 && ltrCount > 22) {
                        marginTop = '-1px';
                        ltrSpacing = '-1.2px';
                    }
                    else if (ltrCount <= 22 && ltrCount > 20) {
                        marginTop = '-1px';
                        ltrSpacing = '-0.6px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        marginTop = '-1px';
                        ltrSpacing = '-0.5px';

                    }
                    else if (ltrCount <= 10) {
                        marginTop = '-1px';
                        ltrSpacing = '2px';
                    }
                    else {
                        marginTop = '-1px';
                        ltrSpacing = '-2.5px';
                    }

                    text = '<p id="topCurvedText" style="margin-top:' + marginTop + ';letter-spacing:' + ltrSpacing + '">' + $('#cointext').val() + '</p>';
                }
            } else {
                //check in accorance with font type
                var fontIs = $('#coinTextFontStyle').val();
                console.log('font is' + fontIs);
                var spacing = curveHandler.spaceCount($('#cointext').val());
                var ltrCount = curveHandler.stringLength($('#cointext').val());

                //check for charecter length
                var marginTop = '-7px';
                if (ltrCount <= 15) {
                    marginTop = '-0px';
                } else {
                    marginTop = '-0px';
                }

                var ltrSpacing = '-1.5px';

                if (fontIs == 'Crete Round') {
                    radius = 175;
                    ltrSpacing = '0.5px';

                }
                else if (fontIs == 'Varela Round') {
                    radius = 173.5;
                    ltrSpacing = '-.5px';


                }
                else if (fontIs == 'Cabin') {
                    radius = 174;
                    ltrSpacing = '-0px';

                }
                else if (fontIs == "Montaga") {
                    radius = 173.5;
                    ltrSpacing = '-0px';

                }
                else {
                    radius = 174;
                    ltrSpacing = '-0px';

                }
                size = 26;
                text = '<p id="topCurvedText" style="margin-top:' + marginTop + ';letter-spacing:' + ltrSpacing + '">' + $('#cointext').val().toUpperCase() + '</p>';
            }
            console.log('radius: ' + radius);
            /*Check for font a get radious then */

            $('#floatCurveText').css({
                fontFamily: font,
                fontSize: size + 'px'
            }).html(text)

            $('#topCurvedText').circleType({
                radius: radius,
                dir: 1
            });

            //Setting up cokkies here
            setCookie("curvetop", radius, 1);
            setCookie("fontsize", size, 1);
        },
        updateBottom: function(dir) {

            //If direction is not being passed then it will fetch rom hidden field
            console.log('direction for the text' + dir);
            if (dir == undefined || dir == '' || dir == 0) {
                var _temp_dir = parseInt($('#coinTextDirection').val());
                dir = _temp_dir;
            }
            console.log("direction = " + dir + "   --  " + _temp_dir);

            var text = '',
                    size = 26,
                    font1 = $('#coinTextFontStyle').val(),
                    bottomtextstyle = decodeURIComponent(getCookie('bottomtxtstyle')),
                    radius = 20;
            if (bottomtextstyle !== '') {
                var res = bottomtextstyle.split(";");
                for (i = 0; i < res.length; i++) {
                    if (res[i].match(/font-family:*/)) {
                        var fontfamily = res[i];
                        var res1 = fontfamily.split(":");
                        var font = res1[1];
                    }
                }

            } else {
                font = font1;
            }
            console.log('With Font Style: ' + font);

            //Find Capital and small letters and then set radious

            //Find CAPITALS AND SMALL TEXT LENGTH
            var cointext = document.getElementById('cointext').value;
            cointext.toUpperCase();
            var toptextnew = cointext.replace(/\s/g, '');
            toptextnew = jQuery.trim(toptextnew);

            console.log('Text: ' + toptextnew);
            var cap = 0;
            for (var i = 0; i <= toptextnew.length; i++) {
                if (checkstring(toptextnew.charAt(i)) == toptextnew.charAt(i)) {
                    //cap++;
                }
            }
            console.log('Text: ' + cap);

            $('#bottomCurvedText').remove();
            //Check for caps
            if (false) { // For capital letters Top text
                radius = 120;
                size = 26;
                var spacing = curveHandler.spaceCount($('#cointext').val());
                var ltrCount = curveHandler.stringLength($('#cointext').val());

                var marginTop = '330px';
                if (ltrCount <= 5) {
                    marginTop = '328px';
                }

                else if (ltrCount <= 7) {
                    marginTop = '322px';
                }
                else if (ltrCount <= 10) {
                    marginTop = '308px';
                }
                else if (ltrCount <= 15) {
                    marginTop = '320px';
                }
                else if (ltrCount <= 20) {
                    marginTop = '315px';
                }
                else if (ltrCount <= 15) {
                    marginTop = '310px';
                }
                else {
                    marginTop = '330px';
                }

                var ltrSpacing = '-1.5px';
                if (font == 'Montaga') {
                    if (ltrCount <= 26 && ltrCount > 22) {
                        ltrSpacing = '-2.8px';
                    }
                    else if (ltrCount <= 22 && ltrCount > 20) {
                        ltrSpacing = '-1px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        ltrSpacing = '-1px';
                    }

                    else if (ltrCount <= 10) {
                        ltrSpacing = '2px';
                    }
                    else {
                        ltrSpacing = '-4.5px';
                    }
                }
                else if (font == 'Varela Round') {
                    size = 26;
                    if (ltrCount <= 25 && ltrCount > 22) {
                        ltrSpacing = '-3.5px';
                    }
                    else if (ltrCount <= 22 && ltrCount > 20) {
                        ltrSpacing = '-1.2px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        ltrSpacing = '-1.2px';
                    }

                    else if (ltrCount <= 10) {
                        ltrSpacing = '1.2px';
                    }
                    else {
                        ltrSpacing = '-5px';
                    }
                }
                else if (font == 'Cabin') {

                    if (ltrCount <= 25 && ltrCount > 22) {
                        ltrSpacing = '-1.5px';
                    }
                    else if (ltrCount <= 22 && ltrCount > 20) {
                        ltrSpacing = '0px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        ltrSpacing = '0px';
                    }
                    else if (ltrCount <= 10) {
                        ltrSpacing = '1.5px';
                    }
                    else {
                        ltrSpacing = '-3px';
                    }
                }
                else if (font == 'Crete Round') {
                    if (ltrCount <= 25 && ltrCount > 23) {
                        ltrSpacing = '-1.5px';
                    }
                    else if (ltrCount <= 23 && ltrCount > 20) {
                        ltrSpacing = '0px';
                    }
                    else if (ltrCount <= 20 && ltrCount > 10) {
                        ltrSpacing = '0px';
                    }
                    else if (ltrCount <= 10) {
                        ltrSpacing = '3px';
                    }
                    else {
                        ltrSpacing = '-2.9px';
                    }
                }

                text = '<p id="bottomCurvedText" style=" bottom:0; position:initial!important; letter-spacing:' + ltrSpacing + '">' + $('#cointext').val().toUpperCase() + '</p>';
                console.log('now text capital' + text);
            } else {
                //check in accorance with font type
                var fontIs = $('#coinTextFontStyle').val();
                console.log('font is' + fontIs);
                var spacing = curveHandler.spaceCount($('#cointext').val());
                var ltrCount = curveHandler.stringLength($('#cointext').val());
                var marginTop = 'auto';
                var marginBottom = '0px';
                /**if(ltrCount<=15){
                 marginTop = '322px';
                 }
                 else if (ltrCount<= 17){
                 marginTop = '290px';
                 }
                 else if (ltrCount<= 20){
                 marginTop = '274px';
                 }
                 else if (ltrCount<= 23){
                 marginTop = '274px';
                 }
                 else if (ltrCount<= 25){
                 marginTop = '266px';
                 }
                 else if (ltrCount<= 28){
                 marginTop = '261px';
                 }
                 else if (ltrCount<= 29){
                 marginTop = '258px';
                 }
                 else if (ltrCount === 30){
                 marginTop = '255px';
                 }

                 **/
                var ltrSpacing = '-1.5px';
                if (fontIs == 'Varela Round') {
                    radius = 174;
                    ltrSpacing = '-.5px';
                } else if (fontIs == 'Crete Round') {
                    radius = 174;
                    ltrSpacing = '.5px';
                    marginBottom = '1px';
                }
                else if (fontIs == 'Cabin') {
                    radius = 175;
                    ltrSpacing = '0px';

                }
                else if (fontIs == 'Montaga') {
                    radius = 174;
                    ltrSpacing = '0px';



                }
                else {
                    radius = 175;
                    ltrSpacing = '0px';
                }

                size = 26;
                text = '<p id="bottomCurvedText" style="margin-bottom:' + marginBottom + '; margin-top:' + marginTop + ';letter-spacing:' + ltrSpacing + '">' + $('#cointext').val().toUpperCase() + '</p>';
                console.log('now text capital' + text);
            }
            console.log('radius: ' + radius);
            /*Check for font a get radious then */

            $('#floatCurveTextBottom').css({
                fontFamily: font,
                fontSize: size + 'px'
            }).html(text).find('p').circleType({
                radius: radius,
                dir: -1
            });


            //Setting up cokkies here
            setCookie("curvebottom", radius, 1);
            setCookie("fontsize", size, 1);
        },
        handleCoinTextTop: function(dir) {
            console.warn("handleCoinTextTop")
            $('#cointext').keyup(curveHandler.update(1));
        },
        handleCoinTextBottom: function(dir) {
            $('#cointext').keyup(curveHandler.updateBottom(-1));
        },
        spaceCount: function(str) {
            var string = str.split(' ');
            return (string.length);
        },
        stringLength: function(str) {
            return (str.length);
        }
    }

    function toptext(dir) {

        var toptext;
        var toptextnew;
        var toptextnew1;
        var toptextnew2;
        //If direction is not being passed then it will fetch rom hidden field
        var text = '',
                size = 22,
                font = $('#coinTextFontStyle').val(),
                radius = 105;

        console.log('With Font Style: ' + font);
        //Find Capital and small letters and then set radious
        var cointext = document.getElementById('topCurvedText');
        htmlContent = cointext.innerHTML,
                toptext = cointext.textContent;
        toptextnew = jQuery.trim(toptext);
        // alert(toptextnew);
        toptextnew1 = toptextnew.toUpperCase();
        // alert(toptextnew1);
        var toptextnew1 = toptextnew1.replace(/\s/g, '');
        toptextnew1 = jQuery.trim(toptextnew1);
        //Find CAPITALS AND SMALL TEXT LENGTH
        //  var cointext = document.getElementById('cointext').value.toUpperCase();
        //  var toptextnew =cointext.replace(/\s/g, '');
        toptextnew2 = jQuery.trim(toptextnew1);
        $('#topCurvedText').remove();
        //Check for caps
        //check in accorance with font type
        var fontIs = $('#coinTextFontStyle').val();
        console.log('font is' + fontIs);
        var spacing = curveHandler.spaceCount(toptextnew);
        var ltrCount = curveHandler.stringLength(toptextnew);

        //check for charecter length
        var marginTop = '-7px';
        if (ltrCount <= 15) {
            marginTop = '0px';
        } else {
            marginTop = '0px';
        }

        var ltrSpacing = '-1.5px';

        if (fontIs == 'Crete Round') {
            radius = 175;
            ltrSpacing = '0.5px';
        }
        else if (fontIs == 'Varela Round') {
            radius = 173.5;
            ltrSpacing = '-.5px';

        }
        else if (fontIs == 'Cabin') {
            radius = 174;
            ltrSpacing = '-0px';
        }
        else if (fontIs == "Montaga") {
            radius = 173.5;
            ltrSpacing = '-0px';
        }
        else {
            radius = 174;
            ltrSpacing = '-0px';
        }
        size = 26;
        text = '<p id="topCurvedText" style="margin-top:' + marginTop + ';letter-spacing:' + ltrSpacing + '">' + toptextnew + '</p>';

        console.log('radius: ' + radius);
        /*Check for font a get radious then */

        $('#floatCurveText').css({
            fontFamily: font,
            fontSize: size + 'px'
        }).html(text)

        $('#topCurvedText').circleType({
            radius: radius,
            dir: 1
        });

        //Setting up cokkies here
        setCookie("curvetop", radius, 1);
        setCookie("fontsize", size, 1);
    }
    function updateBottomtxt(dir) {
        //   alert('bottom');
        //If direction is not being passed then it will fetch rom hidden field
        console.log('direction for the text' + dir);
        if (dir == undefined || dir == '' || dir == 0) {
            var _temp_dir = parseInt($('#coinTextDirection').val());
            dir = _temp_dir;
        }
        console.log("direction = " + dir + "   --  " + _temp_dir);
        var text = '',
                size = 26,
                font = $('#coinTextFontStyle').val(),
                radius = 20;
        console.log('With Font Style: ' + font);
        //Find Capital and small letters and then set radious
        var cointext = document.getElementById('bottomCurvedText');
        htmlContent = cointext.innerHTML,
                bottomtext = cointext.textContent;
        bottomtextnew = jQuery.trim(bottomtext);
        //  alert(bottomtextnew);
        bottomtextnew1 = bottomtextnew.toUpperCase();

        //Find CAPITALS AND SMALL TEXT LENGTH
        //var cointext = document.getElementById('cointext').value;
        // cointext.toUpperCase();
        //  var toptextnew =cointext.replace(/\s/g, '');
        // toptextnew =jQuery.trim(toptextnew);

        //  console.log('Text: '+toptextnew);


        $('#bottomCurvedText').remove();
        //Check for caps
        if (false) { // For capital letters Top text
            radius = 120;
            size = 26;
            var spacing = curveHandler.spaceCount(bottomtextnew1);
            var ltrCount = curveHandler.stringLength(bottomtextnew1);

            var marginTop = '330px';
            if (ltrCount <= 5) {
                marginTop = '328px';
            }

            else if (ltrCount <= 7) {
                marginTop = '322px';
            }
            else if (ltrCount <= 10) {
                marginTop = '308px';
            }
            else if (ltrCount <= 15) {
                marginTop = '320px';
            }
            else if (ltrCount <= 20) {
                marginTop = '315px';
            }
            else if (ltrCount <= 15) {
                marginTop = '310px';
            }
            else {
                marginTop = '330px';
            }

            var ltrSpacing = '-1.5px';
            if (font == 'Montaga') {
                if (ltrCount <= 26 && ltrCount > 22) {
                    ltrSpacing = '-2.8px';
                }
                else if (ltrCount <= 22 && ltrCount > 20) {
                    ltrSpacing = '-1px';
                }
                else if (ltrCount <= 20 && ltrCount > 10) {
                    ltrSpacing = '-1px';
                }

                else if (ltrCount <= 10) {
                    ltrSpacing = '2px';
                }
                else {
                    ltrSpacing = '-4.5px';
                }
            }
            else if (font == 'Varela Round') {
                size = 26;
                if (ltrCount <= 25 && ltrCount > 22) {
                    ltrSpacing = '-3.5px';
                }
                else if (ltrCount <= 22 && ltrCount > 20) {
                    ltrSpacing = '-1.2px';
                }
                else if (ltrCount <= 20 && ltrCount > 10) {
                    ltrSpacing = '-1.2px';
                }

                else if (ltrCount <= 10) {
                    ltrSpacing = '1.2px';
                }
                else {
                    ltrSpacing = '-5px';
                }
            }
            else if (font == 'Cabin') {

                if (ltrCount <= 25 && ltrCount > 22) {
                    ltrSpacing = '-1.5px';
                }
                else if (ltrCount <= 22 && ltrCount > 20) {
                    ltrSpacing = '0px';
                }
                else if (ltrCount <= 20 && ltrCount > 10) {
                    ltrSpacing = '0px';
                }
                else if (ltrCount <= 10) {
                    ltrSpacing = '1.5px';
                }
                else {
                    ltrSpacing = '-3px';
                }
            }
            else if (font == 'Crete Round') {
                if (ltrCount <= 25 && ltrCount > 23) {
                    ltrSpacing = '-1.5px';
                }
                else if (ltrCount <= 23 && ltrCount > 20) {
                    ltrSpacing = '0px';
                }
                else if (ltrCount <= 20 && ltrCount > 10) {
                    ltrSpacing = '0px';
                }
                else if (ltrCount <= 10) {
                    ltrSpacing = '3px';
                }
                else {
                    ltrSpacing = '-2.9px';
                }
            }

            text = '<p id="bottomCurvedText" style=" bottom:0; position:initial!important; letter-spacing:' + ltrSpacing + '">' + bottomtextnew.toUpperCase() + '</p>';
            console.log('now text capital' + text);
        } else {
            //check in accorance with font type
            var fontIs = $('#coinTextFontStyle').val();
            console.log('font is' + fontIs);
            var spacing = curveHandler.spaceCount(bottomtextnew1);
            var ltrCount = curveHandler.stringLength(bottomtextnew1);
            var marginTop = 'auto';
            var marginBottom = '0px';
            /**if(ltrCount<=15){
             marginTop = '322px';
             }
             else if (ltrCount<= 17){
             marginTop = '290px';
             }
             else if (ltrCount<= 20){
             marginTop = '274px';
             }
             else if (ltrCount<= 23){
             marginTop = '274px';
             }
             else if (ltrCount<= 25){
             marginTop = '266px';
             }
             else if (ltrCount<= 28){
             marginTop = '261px';
             }
             else if (ltrCount<= 29){
             marginTop = '258px';
             }
             else if (ltrCount === 30){
             marginTop = '255px';
             }

             **/
            var ltrSpacing = '-1.5px';
            if (fontIs == 'Varela Round') {
                radius = 176;
                ltrSpacing = '-.5px';
            } else if (fontIs == 'Crete Round') {
                radius = 174;
                ltrSpacing = '.5px';
                marginBottom = '1px';
            }
            else if (fontIs == 'Cabin') {
                radius = 174;
                ltrSpacing = '0px';
            }
            else if (fontIs == 'Montaga') {
                radius = 174.5;
                ltrSpacing = '0px';
            }
            else {
                radius = 174;
                ltrSpacing = '0px';
            }

            size = 26;
            text = '<p id="bottomCurvedText" style="margin-bottom: ' + marginBottom + '; margin-top:' + marginTop + ';letter-spacing:' + ltrSpacing + '">' + bottomtextnew1.toUpperCase() + '</p>';
            console.log('now text capital' + text);
        }
        console.log('radius: ' + radius);
        /*Check for font a get radious then */

        $('#floatCurveTextBottom').css({
            fontFamily: font,
            fontSize: size + 'px'
        }).html(text).find('p').circleType({
            radius: radius,
            dir: -1
        });


        //Setting up cokkies here
        setCookie("curvebottom", radius, 1);
        setCookie("fontsize", size, 1);
    }

</script>