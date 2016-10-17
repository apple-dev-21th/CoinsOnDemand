<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url(); ?>/web_favicon.png" type="image/gif">
        <link href="<?php echo base_url() ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/csphotoselector.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo base_url() ?>assets/j/jquery.js" ></script> <!-- jQuery v1.7.1 jquery.com -->
        <script src="<?php echo base_url() ?>assets/js/bjqs-1.3.min.js"></script>
        <script>
            console.log("<?php echo base_url(); ?>");
        </script>

        <!-- for round shape text -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.arctext.js"></script>
        <script src="<?php echo base_url() ?>assets/j/html2canvas.js"></script>
        <script>
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toGMTString();
                document.cookie = cname + "=" + cvalue + "; " + expires + ';domain=personalizedcoins.com;path=/';
            }

            function createsession(id) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>select_template/createsession/',
                    data: {cointemplate: id},
                    success: function(data) {
                        if (data == '1') {
                           window.location.href = '<?php echo base_url(); ?>personalizedcoin/select_coin';
                        }
                    }
                });
            }

            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++)
                {
                    var c = ca[i].trim();
                    if (c.indexOf(name) == 0)
                        return c.substring(name.length, c.length);
                }
                return "";
            }

			var fbimg = '<?php echo $this->session->userdata('fbimg');?>';

        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/accordian.js"></script>
        <script type="text/javascript">
            ddaccordion.init({
                headerclass: "submenuheader", //Shared CSS class name of headers group
                contentclass: "submenu", //Shared CSS class name of contents group
                revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
                mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
                collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
                defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
                onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
                animatedefault: false, //Should contents open by default be animated into view?
                persiststate: true, //persist state of opened contents within browser session?
                toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
                //	togglehtml: ["suffix", "<img src='plus.gif' class='statusicon' />", "<img src='minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
                animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
                oninit: function(headers, expandedindices) { //custom code to run when headers have initalized
                    //do nothing

                },
                onopenclose: function(header, index, state, isuseractivated) { //custom code to run whenever a header is opened or closed
                    //do nothing
                }
            })

            $(".submenu.active").show();
        </script>

        <!--<script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-filestyle.js"></script>-->
        <script type="text/javascript" src="//markusslima.github.io/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>assets/j/jqueryui.js" ></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/j/jquery.mousewheel.min.js" ></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/j/jquery.iviewer.js" ></script>

        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.iviewer.css" />
        <script src="<?php echo base_url(); ?>assets/js/csphotoselector.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/example.js"></script>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-53376416-3', 'auto');
          ga('send', 'pageview');

        </script>
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

    <body >
    <?php
        //print_r($this->input->cookie());
        $this->db->where('menu', 'header');
        $this->db->order_by('menu_position', 'ASC');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('pages');
        $result = $query->result_array();

        //print_r($result);
    ?>
        <header>
            <?php if(isset($img)){
                echo $img;
            }
            ?>

            <div id="loader">
                <img src="<?php echo base_url(); ?>assets/images/10.gif" />
            </div>

            <div id="fb-root"></div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-5 padding-xs-0"><div class="logo_outer"><h1 class="logo"> <a href="<?php echo base_url(); ?>" ><img src="<?php echo base_url() ?>assets/img/logo.png" alt="" class="img-responsive"/> </a></h1></div></div>
                    <div class="col-lg-7 pull-right padding-xs-0">
                        <div class="col-lg-5 pull-right">
                             <form accept-charset="utf-8" method="post" action="<?php echo base_url(); ?>select_template/search" class="srch">
                                <input type="text" name="searchkey" >
                                <input type="submit" value="" >
                            </form>
                        </div>

                        <div class="dropdown col-lg-6 pull-right">
                            <div class="pull-right realtive">
                                <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" class="grey_btn text-right">
                                    <img src="<?php echo base_url() ?>assets/img/shopping.png" alt=""/> Cart <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <?php
                                    $cartdata = $this->cart->contents();
                                    if (!empty($cartdata)) {
                                        foreach ($cartdata as $item) {
                                            ?>
                                            <li><a href="<?php echo base_url(); ?>personalizedcoin/shoppingcart"><?php echo $item['name']; ?></a></li>
                                        <?php }
                                    } else { ?>
                                        <li> 0 Item in Cart</li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="pull-right realtive">
                                <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="javascript:;" class=" grey_btn">
                                    My Account <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <?php if ($this->session->userdata('user') &&  $this->session->userdata('user_type') !== 'guest') { ?>
                                    <li><a href="<?php echo base_url(); ?>viewmyorder">View my Orders</a></li>
                                    <li><a href="<?php echo base_url(); ?>myprofile">My Profile</a></li>
                                    <li><a href="<?php echo base_url(); ?>manageaddress">Manage Addresses</a></li>
                                    <li><a href="<?php echo base_url(); ?>signin/logout">Sign out</a></li>
                                    <?php } else { ?>
                                    <li><a href="<?php echo base_url(); ?>signin">Sign In</a></li>
                                    <li><a href="<?php echo base_url(); ?>signup">Register</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-8 padding-xs-0">
                        <?php //print_r($header_menu); print_r($footer_menu);?>
                        <ul class="nav nav-pills custom_nav">
                            <li><a href="<?php echo base_url(); ?>">Home</a></li>
                            <?php foreach($result as $menu) {?>
                            <li><a href="<?php echo base_url().$menu['slug']; ?>"><?php echo $menu['page_title']; ?></a></li>
                            <!-- <li><a href="<?php echo base_url(); ?>about">About</a></li>
                            <li><a href="<?php echo base_url(); ?>pricing">Pricing</a></li>
                            <li><a href="<?php echo base_url(); ?>faq">FAQ</a></li>
                            <li><a href="<?php echo base_url(); ?>contactus">Contact Us</a></li>-->
                           <?php }?>
                        </ul>
                    </div>
                </div>

            </div>
        </header>

        <div class="outer_border"><div class="multi_color_bg"></div></div>

    <?php
    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $ub='';

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'IE';
            $ub = "MSIE";
        } elseif(preg_match('/Firefox/i',$u_agent)) {
            $bname = 'Firefox';
            $ub = "Firefox";
        } elseif(preg_match('/Chrome/i',$u_agent)) {
            $bname = 'Chrome';
            $ub = "Chrome";
        } elseif(preg_match('/Safari/i',$u_agent)) {
            $bname = 'Safari';
            $ub = "Safari";
        } elseif(preg_match('/Opera/i',$u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif(preg_match('/Netscape/i',$u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        } else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    // now try it
    $ua=getBrowser();
    $yourbrowser= $ua['name'] ;
    $version= $ua['version'];
    if($yourbrowser == 'Firefox'  &&  $version < 16.0 || $yourbrowser == 'Chrome' &&  $version < 14 || $yourbrowser == 'Safari' &&  $version < 5 || $yourbrowser == 'IE' &&  $version < 9 ) {
    ?>

<style type="text/css">
    .fade.in {
        opacity: 1;
    }
    .model_1 {
        border-bottom: none !important;
    }

    .continue {
        color:#555 !important;
        text-decoration: underline;
        text-align: center;
        font-size: 14px;
    }

    #myModal1{ display: block !important;}

    .modal-body {
        padding: 0px !important;
        position: relative;
    }

    .modal-content{
        border: medium none !important;;
        border-radius: 0 !important;;
        box-shadow: none !important;;
        outline: medium none !important;;
        position: relative;
    }

</style>
    <?php
        }
    ?>
  <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal1" class="modal fade in" style="display: none; z-index: 9999; opacity: 0.93; background: none repeat scroll 0 0 #999999;">
    <div class="modal-dialog" style=" width: 758px;">
        <div class="modal-content text-center" style="background:none">

            <div class="modal-body"  style="padding-top: 0px 0px 0px 0px !important">
                <div class="clearfix"></div>

               <img src="<?php echo base_url(); ?>assets/img/rsz_browser_box.png" usemap="#planetmap"  >
               <map  name="planetmap">
                <area shape="rect" alt="" title="" coords="692,15,743,53" href="javascript:;" target=""  id="close1" />

                <area shape="rect" alt="" title="" coords="61,213,193,314" href="https://www.mozilla.org/en-US/firefox/new/" target="_new" />

                <area shape="rect" alt="" title="" coords="234,214,348,314" href="http://support.apple.com/kb/dl1531" target="_new" />

                <area shape="rect" alt="" title="" coords="388,219,520,315" href="https://www.google.com/intl/en_in/chrome/browser/" target="_new" />

                <area shape="rect" alt="" title="" coords="554,218,684,314" href="http://windows.microsoft.com/en-IN/internet-explorer/download-ie" target="_new" />
                </map>
            </div>

        </div>
    </div>
</div>

<script type='text/javascript'>
    jQuery("#close1").click(function() {
        $("#myModal1").remove();
      //  $(".modal").remove();
        $('#myModal1').css('display', 'none !important');
        //$('.modal').css('display', 'none !important');
        $('.fade.in').css('opacity', '0');
    });
    //$(":file").filestyle({input: false});
</script>