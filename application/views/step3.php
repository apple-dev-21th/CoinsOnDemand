

<style>
    .front {
        <?php if ($coin_type != 'eagle') {?>
            background: url('<?php echo base_url(); ?>outer_new_1.png') no-repeat scroll 0 0 rgba(0, 0, 0, 0);
        <?php }else { ?>
            background: url('<?php echo base_url(); ?>/assets/img/silver-eagle-rim-larger-1.png') no-repeat scroll 0 0 rgba(0, 0, 0, 0);
            background-position: -10px;
        <?php }?>
        height:372px; top: -1px;
    }
    #goldencoin { display: none;}
    .back img { width:376px; height:376px; }
    
    
    .dblarrow {
		position:absolute;
		margin-top:-32px;
		margin-left:218px;
	}
	
	.dblarrow b {
		width: 0; 
		height: 0; 
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-bottom: 5px solid black;
	  display: block;
	  margin-bottom: 3px;
	}
	
	.dblarrow i {
		width: 0; 
		height: 0; 
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-top: 5px solid black;
	  display: block;
	}
    
    <?php if ($coin_type == 'eagle') {?>
    
    .front.inpreview > img {
        margin-top: 6px !important;
        margin-left: 4px;
        width: 356px;
        height: 356px;
    }
    <?php }?>
</style>
<?php
if(isset($_GET['qty']) && $_GET['qty'] == '0' ){
    ?>
<script> alert('Total quantity in your cart cross the 990, Please enter the less quantity to proceed'); </script>
<?php
}
?>

<div class="container white">
    <ul class="steps">
        <li class="second active"><a  class="fonts_color">step1</a></li>
        <li class="second active"><a  class="fonts_color">step2</a></li>
        <li class="active"><a >step3</a><span></span></li>
    </ul>
    <div class="clearfix"></div>
    <div class="leftcont">
        <div class="glossymenu">
             <a  class="menuitem submenuheader  font_color" style="display:none"></a>
            <a  class="menuitem submenuheader  font_color" headerindex="0h">Step 1: Upload your photo</a>
            <a  class="menuitem submenuheader font_color" headerindex="1h">Step 2: Design your coin</a>
        <a  class="menuitem submenuheader active" headerindex="2h">Step 3: Approve your design</a>            <div class="submenu third1 open" contentindex="2c" style="display: none;">
                <form action=" <?php  echo base_url();?>personalizedcoin/addtocart/" method="post" onsubmit="return validateForm()" name="myform">
                <div class="addtext">
                   <h4>Coin Quantity</h4>
<div class="incdec">
                                    <input type="text" value="1" name="coinquantity"  id="coinquantity"  readonly>
                                    <a onclick="doIt(1,'coinquantity'); return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                    <a onclick="doIt(-1,'coinquantity'); return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                </div>

                </div>
                <?php if($coin_type != "eagle") { ?>
                <div class="twocol text-center">
                    <img src="<?php echo base_url(); ?>assets/img/goldplate.png">
                </div>
                <label class="chklbl">
                    <input type="checkbox" name="goldplated"  id="goldplated"> <p class="sp">
                        Add <span> Genuine 24KT Gold </span> Plating  @ $<?php echo $Gold_price->gold_price; ?> per coin
                    </p>
                </label>
                <?php } ?>
                <input type="hidden" name="coin_type" id="coin_type" value="<?php echo $coin_type; ?>" />
                <div class="text-center  created"><h4><em>Coin will be created as shown.</em></h4></div>
                <label class="chklbl">
                    <input type="checkbox" name="tandc" id="tandc"> <p>I have read and accept the <a href="<?php echo base_url(); ?>terms-conditions">Terms &amp; Conditions.</a> </p>
                </label>
                <label class="chklbl">
                    <input type="checkbox" name="designapprove" id="designapprove"> <p style="text-decoration: underline;">I approve my design. I own the copyright for these photo(s) or I am authorized by the owner to make a photo-to-coin reproduction.</p>
                </label>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog model_top">
    <div class="modal-content model_2">
      <div class="modal-header">
           <h2 class="modal-title" id="myModalLabel">Add a High Quality Premium Display Box to your Order </h2>
        <p>These premium coin boxes are made out of metal and wrapped in soft plush felt. </p>
        <p>It is a terrific way to display your personalized coin,protect your coin, or to give the coin as a gift.   </p>
        <h4 style="color: #868686;">3 Different Size Available for your Half Dollar or Silver Eagle :<h4>
      </div>
      <div class="modal-body boxes">
      		<div class="row col-md-1">
      		
      		</div>
          <div class="row col-md-4 text-center">
              <div class="box1" style="border: 0px; background-color: #fff;">
                   <img src='<?php echo base_url();?>assets/img/box1.jpg' style="width: 183px;">
              </div>
              <h5>Single Coin Box</h5>
              $<?php echo $box_price->single_coin_box; ?> each</p>
             <div class="incdec" style="margin-left: 67px;">
                                    <input type="text" name="single-coin-box" value="0" readonly id="single-coin-box" >
                                    <a onclick="doIt(1, 'single-coin-box'); return false; "  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                    <a onclick="doIt(-1, 'single-coin-box'); return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                </div>
          </div>
                 <div class="row col-md-4">
              <div class="box1" style="border: 0px; background-color: #fff;">
                   <img src='<?php echo base_url();?>assets/img/box2.jpg' style="width: 183px;">
              </div>
              <h5>Two Coin Box</h5>
              $<?php echo $box_price->two_coin_box; ?> each</p>
              <div class="incdec" style="margin-left: 67px;">
                                    <input type="text" name="two-coin-box" value="0" readonly id="two-coin-box" >
                                    <a onclick="doIt(1, 'two-coin-box'); return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                    <a onclick="doIt(-1, 'two-coin-box'); return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                </div>
          </div>
                 <div class="row col-md-4">
              <div class="box1" style="border: 0px; background-color: #fff;">
                   <img src='<?php echo base_url();?>assets/img/box3.jpg' style="width: 183px;">
              </div>
              <h5>Three Coin Box</h5>
              $<?php echo $box_price->three_coin_box; ?> each</p>
       <div class="incdec" style="margin-left: 67px;">
                                    <input type="text" name="three-coin-box" value="0" readonly id="three-coin-box" >
                                    <a onclick="doIt(1, 'three-coin-box'); return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                    <a onclick="doIt(-1, 'three-coin-box'); return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                </div>
          </div>
          
          <!-- 
                 <div class="row col-md-2">
              <div class="box1">
                   <img src='<?php echo base_url();?>assets/img/four_box.png' >


              </div>

              <h5>Eight Coin Box</h5>
              $<?php echo $box_price->eight_coin_box; ?> each</p>
             <div class="incdec">
                                    <input type="text" name="four-coin-box" value="0" readonly id="four-coin-box" >
                                    <a onclick="doIt(1, 'four-coin-box'); return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                    <a onclick="doIt(-1, 'four-coin-box'); return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                </div>
          </div>
           <div class="row col-md-2">
              <div class="box1">
                   <img src='<?php echo base_url();?>assets/img/five_box.png' >
              </div>
              <h5>Fifteen Coin Box</h5>
              $<?php echo $box_price->fifteen_coin_box; ?> each</p>
             <div class="incdec">
                                    <input type="text" name="five-coin-box" value="0" readonly id="five-coin-box" >
                                    <a onclick="doIt(1, 'five-coin-box'); return false;"  class="inc" href="#"><img src="<?php echo base_url(); ?>assets/img/increment.png"></a>
                                    <a onclick="doIt(-1, 'five-coin-box'); return false;" class="dec" href="#"><img src="<?php echo base_url(); ?>assets/img/decrement.png"></a>
                                </div>
          </div>
           -->
      </div>
        <div class='clearfix'></div>

	  <div class="modal-body text-center" style="padding-bottom: 0px;">
	  		<div class="form-group">
		  		<span style="font-size:19px; font-weight: bold; color: #E2863D;">Select type of coin box</span>
		  		<div class="row">
		  			<div class="col-md-4">
		  			</div>
		  			<div class="col-md-4">
				  		<select class="form-control" name="box_coin_type" style="" id="box_coin_type">
				  			<option value="" disabled selected>Select Coin Box</option>
			          		<option value="American Eagle Coin Box">American Eagle Coin Box</option>
			          		<option value="JFK Half Dollar Coin Box">JFK Half Dollar Coin Box</option>
			            </select>
			            <?php if ((isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) || (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false))) {?>
			            <?php }else{?>
			            	<div class="dblarrow"><b></b><i></i></div>
			            <?php }?>			  			
		  			</div>
		  		</div>  		
	  		</div>
	  </div>
      <div class="modal-footer text-center" style="padding-top: 0px;">
          <div class="add2">
          <input type="submit" class="addtocart" value='' onclick="return checkValidation();"/>
      </div>
          <div class="clearboth"></div>
          <br/>

      <i class="grey_1 text-center"><a href="javascript:;" onclick="document.myform.submit();" style="float: none; ">No thanks continue to checkout</a></i>
      </div>
    </div>
  </div>
</div>



<input type="button" class="addtocart" value="" class="btn btn-primary btn-lg" id="addtocart"   data-toggle="modal" data-target="#myModal">
                <!--  -->
                <div class="clearfix"></div>
            </form>
            </div>


        </div>



    </div>




    <div class="rightcont">


        <div class="wrapper">
            
            <div class="row">
                <div class="col-md-6 rightnext text-left">
                    <a class="backstep" href="javascript:;"> <img src="<?php echo base_url(); ?>assets/img/BackButton.jpg" class="img-responsive" > </a> 

                </div>
            </div>
            
            <div class="row">

                <div class="realtive setheight">

                    <div class="front inpreview" <?php if ($coin_type == 'eagle') { ?> style="width: 374px; <?php }?>">
                        <img alt="" src="<?php echo $this->session->userdata('finalcoin'); ?>">
                    </div>


                    <div class="back inpreview">
                        
                        <?php if($coin_type == "eagle") { ?>
                            <img alt="" src="<?php echo base_url(); ?>assets/img/eagle-back.png" style="height: 372px;width: 374px;" id="coinback">
                        <?php }else { ?>
                            <img alt="" src="<?php echo base_url(); ?>assets/img/back.jpg" style="height: 370px;width: 370px;" id="coinback">
                        <?php } ?> 
                    </div>

                </div>

            </div>
 <div class="row" id="goldencoin">

                <div class="col-md-12 inpreview atbottom">


                    <p> Note: Clicking this option, all coins will be gold. </p>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12 inpreview atbottom">

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
     $('#addtocart').click(function()
    {
if($("#tandc").prop('checked') == false){
    alert("Kindly read the and accept Term and conditions");
    return false;
}
if($("#designapprove").prop('checked') == false){
    alert("Kindly approve your design ");
    return false;
}
    });
    $('#goldplated').click(function() {
        if ($(this).is(':checked')) {
           var data = '<?php echo base_url(); ?>back_gold.jpg';
           var data_front= '<?php echo base_url();?>con_front_gold.png';
            $('.inpreview img').css( "margin-left", "1px" );
           $('.inpreview img').css( "margin-top", "-4px" );
           $('#goldencoin').css( "display", "none" );

        }else {
            var data_front= '<?php echo base_url();?>outer_new_1.png';
        var data= '<?php echo base_url(); ?>assets/img/back.jpg';
        $('.inpreview img').css( "margin-left", "-1px" );
           $('.inpreview img').css( "margin-top", "-2px" );
           $('#goldencoin').css( "display", "none" );
        }
        $('.front').css("background", "url(" + data_front + ")");
        $('.front').css( "background-repeat", "no-repeat" );
        $("#coinback").attr('src', data);
    });
 function doIt(toAdd, textbox) {
        var textBox = document.getElementById(textbox);
        var number = parseInt(textBox.value);
        if (number + toAdd == -1 || number + toAdd > 990)
        {
            return false;
        } else {
            textBox.value = number + toAdd;
        }
    }
     $('.backstep').click(function() {
         var oldURL = document.referrer;
         window.location.href=oldURL;
     });


function checkValidation() {
	if ($('#box_coin_type').val() == '') {
			alert ('Please select coin type.');
			return false;
		}
	return true;
} 
    </script>
