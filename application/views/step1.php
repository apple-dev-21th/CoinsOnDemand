<style>
    .front {left: 0px !important; }
    .CSPhotoSelector_footer.CSPhotoSelector_clearfix > a {
  color: #000000 !important;
  padding: 4px;
  text-indent: 0 !important;
}
.glyphicon-folder-open:before{
    content:none !important;
}
.badge{ display: none !important }
</style>

<?php
//phpinfo();
//echo '<pre>'; print_r($_SERVER);
$root = $_SERVER['DOCUMENT_ROOT'];
include $root . "/application/libraries/instagram.php";
$instagram = new Instagram(array(
    'apiKey' => '32277bd0059b44b99ac8af6b00d5ab1d',
    'apiSecret' => 'e7f7145be5224a8286248bd9b0e0cc2c',
    'apiCallback' => base_url().'personalizedcoin/step1' // must point to success.php
        ));
// create login URL
$loginUrl = $instagram->getLoginUrl();
if(isset($_GET['code'])) {
    $code = $_GET['code'];
    ?>
<style>
    #CSPhotoSelector{
        overflow: scroll;
    }
    .CSPhotoSelector_form {
    background: none repeat scroll 0 0 #FFFFFF;
}
.CSPhotoSelector_form > a  img {
    margin: 14px 7px;
}
#CSPhotoSelector .CSPhotoSelector_dialog {
    background: none repeat scroll 0 0 rgba(82, 82, 82, 0.698);
    border-radius: 8px;
    height: auto;
    margin:0 auto 100px;
    padding: 10px;
    position: relative;
    top: -81px;
    width: 687px;
    margin-bottom: 100px;
    max-height: 550px;
    overflow: scroll;
}
</style>
<?php
if (true === isset($code)) {

// Receive OAuth token object
    $data = $instagram->getOAuthToken($code);
//echo 'Your username is: ' . $data->user->username;
// Store user access token
    $instagram->setAccessToken($data);

// Now you can call all authenticated user methods
// Get the most recent media published by a user
    $media = $instagram->getUserMedia(); 
    //$photos = $instagram->getTagMedia('kitten');

   // $result = $instagram->pagination($photos);
//echo '<pre>';  print_r($media);
//die;
    ?>
    <div id="CSPhotoSelector" style="display: block;">
        <div class="CSPhotoSelector_dialog">
            <a id="CSPhotoSelector_buttonClose" href="javascript:;" onclick="closepopup()">x</a>
            <div class="CSPhotoSelector_form">
                <div class="CSPhotoSelector_header">
                    <p>Choose from Photos</p>
                </div>
<?php 
 foreach ($media->data as $entry) {
     $url= $entry->images->standard_resolution->url;
     $thum=$entry->images->thumbnail->url;
     ?>
<a href='javascript:;' onclick="saveimage('<?php echo $url; ?>')" ><img src=" <?php echo $thum; ?>"/></a>
<?php } 
//echo "<br><a href='".$media->pagination->next_url."' >Load more ...</a>";
?>   

                <div id="CSPhotoSelector_loader" style="display: none;"></div>
            </div>
        </div>
    </div>
<?php 
}
    ?>
   <?php 
    }
    ?>
<div id="fb-root"></div>
<div id="results" style="display:none">
  
</div>

<div id="CSPhotoSelector">
    <div class="CSPhotoSelector_dialog">
        <a href="#" id="CSPhotoSelector_buttonClose">x</a>
        <div class="CSPhotoSelector_form">
            <div class="CSPhotoSelector_header">
                <p>Choose from Photos</p>
            </div>

            <div class="CSPhotoSelector_content CSAlbumSelector_wrapper">
                <p>Browse your albums until you find a picture you want to use</p>
                <div class="CSPhotoSelector_searchContainer CSPhotoSelector_clearfix">
                    <div class="CSPhotoSelector_selectedCountContainer">Select an album</div>
                </div>
                <div class="CSPhotoSelector_photosContainer CSAlbum_container"></div>
            </div>

            <div class="CSPhotoSelector_content CSPhotoSelector_wrapper">
                <p>Select a new photo</p>
                <div class="CSPhotoSelector_searchContainer CSPhotoSelector_clearfix">
                    <div class="CSPhotoSelector_selectedCountContainer"><span class="CSPhotoSelector_selectedPhotoCount">0</span> / <span class="CSPhotoSelector_selectedPhotoCountMax">0</span> photos selected</div>
                    <a href="#" id="CSPhotoSelector_backToAlbums">Back to albums</a>
                </div>
                <div class="CSPhotoSelector_photosContainer CSPhoto_container"></div>
            </div>

            <div id="CSPhotoSelector_loader"></div>


            <div class="CSPhotoSelector_footer CSPhotoSelector_clearfix">
                <a href="#" id="CSPhotoSelector_pagePrev" class="CSPhotoSelector_disabled">Prev</a>
                <a href="#" id="CSPhotoSelector_pageNext">Next</a>
                <div class="CSPhotoSelector_pageNumberContainer">
                    Page <span id="CSPhotoSelector_pageNumber">1</span> / <span id="CSPhotoSelector_pageNumberTotal">1</span>
                </div>
                <a href="#" id="CSPhotoSelector_buttonOK">OK</a>
                <a href="#" id="CSPhotoSelector_buttonCancel">Cancel</a>
            </div>
        </div>
    </div>
</div>
<!-- Facebook popup ends here -->

<div class="container white">
    <ul class="steps">
        <li class="active"><a >step1</a><span></span></li>
        <li class="second"><a  class="font_color">step2</a></li>
        <li><a class="font_color">step3</a></li>
    </ul>
    <div class="clearfix"></div>
    <div class="leftcont newleft">
    
    
    <div class="glossymenu">
  <a  class="menuitem submenuheader  font_color" style="display:none"></a>
<a  class="menuitem submenuheader active" headerindex="0h">Step 1: Upload your photo</a>
<div class="submenu first1 open" contentindex="0c" style="display: none;">
		
        <h4><span>Option 1 : </span>Upload Photo</h4>
        <p>Accepted formats: JPG,GIF or PNG</p>
        <form method="post"  action="<?php echo base_url('personalizedcoin/step2/'.$coin_type); ?>" enctype= multipart/form-data>
            <div style="width:30%; float: left">
            <input type="hidden" name="coinid" value="<?php echo $this->uri->segment(3); ?>" >
     <input type="file" accept="image/*" data-buttontext="" data-input="false" data-classbutton="btn btn-primary" class="filestyle" id="filestyle-0" style="position: fixed; left: -9999px;" tabindex="-1" onchange="this.form.submit()" name="upimg" alt="example" >
            </div><div style="width:70%; float: left">
<!--     <div style="display: inline;" class="bootstrap-filestyle" tabindex="0"><label class="btn btn-primary" for="filestyle-0"><i class=" icon-white icon-folder-open"></i> <span></span></label>-->
        <a class="fb" href="javascript:;" id="btnLogin" ></a>
        <a class="insta" href=" <?php  echo $loginUrl ?>"></a>
            </div>
        </form>
          </div>
        <div class="clearfix"></div>
        
        
        <p class="context">Upload  your photo from your computer <br> or import a photo
from Facebook or Instagram.</p>
        
        <hr>
        
        <div class="grey_box">
            <h4><span>Option 2 : </span>Don't Have a Photo ?</h4>
        <p>Choose from our Design Library of Images</p>
       <img src="<?php echo base_url(); ?>assets/images/template_des.png">
       <a  href="<?php echo base_url();?>personalizedcoin/step2/designtemplate/step1/<?php echo $coin_type;?>/" class="menuitem  active" ></a>
        </div>
    
    <div class="clearfix"></div>


<a  class="menuitem submenuheader font_color" headerindex="1h">Step 2: Design your coin</a>



<a  class="menuitem submenuheader font_color" headerindex="2h">Step 3: Approve your design</a>
</div>
</div>








    <div class="rightcont">
        <div class="wrapper">
            <div class="row">

                <div class="realtive setheights1"> 	

                    <div class="front inpreview">

                        <div class="coin_img_rishu">
                            
                            <?php if($coin_type == "eagle") { ?>
                                <img alt="" src="<?php echo base_url(); ?>assets/img/Half_layer_Step1_Eagle.png" style="width:700px">
                            <?php }else { ?>
                                <img alt="" src="<?php echo base_url(); ?>assets/img/Half_layer_Step1_new.png" style="width:700px">
                                
                            <?php } ?>    
                        </div>
                        <div class="clearfix"></div>
<div class="cion_font">
                        <h3>Front</h3>
</div>
                        
                        <div class="cion_font">
                        <h3>Back</h3>
</div>
                    </div>


<!--                    <div class="back inpreview">

                        <img alt="" src="<?php echo base_url(); ?>assets/img/back.png">

                        <h3>Back</h3>

                    </div>-->

                </div>

            </div>


            <div class="row">

                <div class="col-md-12 inpreview">
                    
                    <?php if($coin_type == "eagle") { ?>
                        <h4>Design will appear on front of American Eagle</h4>
                        <p> Coin Diameter: 1.20 in. (30.6 mm) </p>
                    <?php }else { ?>
                        <h4>Design will appear on front of JFK Half Dollar</h4>
                        <p> Coin Diameter: 1.20 in. (30.6 mm) </p>
                    <?php } ?>
                </div>

            </div>

        </div>


    </div>


</div>

<script type="text/javascript">
    var id;
$('#btnLogin').on('click', function(){
    id = '<?php echo $this->uri->segment(3); ?>';
    return true;    
});

function closepopup(){
   $("#CSPhotoSelector").css("display","none");
}
function setCookie(cname,cvalue,exdays)
{ //alert(cname);
  //  alert(cvalue);
    //alert(exdays);
var d = new Date();
d.setTime(d.getTime()+(exdays*24*60*60*1000));
var expires = "expires="+d.toGMTString();
document.cookie = cname + "=" + cvalue + "; " + expires+';domain=personalizedcoins.com ;path=/';
window.location.href = '<?php echo base_url();?>personalizedcoin/step2/<?php echo $coin_type; ?>';
} 
function saveimage(fbimg){
     $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>select_template/createimage/',
                    data: {image: fbimg},
                    success: function(data) {
                      setCookie("fbimg",data,1);
                    }
                });
    
}

</script>
