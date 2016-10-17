<div id="contentHeader">
    <h1>Manage Gift Box Price</h1>
    <div id="contentHeaderBevel"></div></div>
<div class="container">
    <div class="grid-24">
        <div class="widget">
            <div class="widget-content">
                <br>
                <?php if (validation_errors()) { ?>
            <div class="notify notify-error">
                <a href="javascript:;" class="close">×</a>
                <h3>Error Notifty</h3>
               <?php echo validation_errors(); ?>
            </div>
<?php     
} 
$this->load->view('admin/include/flash');
?>
                <?php echo form_open('admin/category/managegiftboxprice',array('class' => 'form uniformForm form-inline')); ?>
                <!-- <form class="form uniformForm" action="" enctype="multipart/form-data" method="post"> -->
                 <div class="field-group">
                        <label for="email"> Box Type</label>
                        <div class="field">
                            <label for="email"> <b>Price </b></label>
                        </div>
                    </div>
             
                <?php 
               // print_r($price_list); die;
             ?>
                    <div class="field-group">
                        <label for="email">Single Coin Box</label>
                        <div class="field">
                           <input type="text" value="<?php echo $box_price->single_coin_box ;?>" name="single_coin_box" id="question" size="80" required="required">	 
                        </div>
                    </div>
                   <div class="field-group">
                        <label for="email">Two Coin Box</label>
                        <div class="field">
                           <input type="text" value="<?php echo $box_price->two_coin_box;?>" name="two_coin_box" id="question" size="80" required="required">	 
                        </div>
                    </div>
                 <div class="field-group">
                        <label for="email">Three Coin Box</label>
                        <div class="field">
                           <input type="text" value="<?php echo $box_price->three_coin_box; ?>" name="three_coin_box" id="question" size="80" required="required">	 
                        </div>
                    </div>
 <div class="field-group">
                        <label for="email">Eight Coin Box</label>
                        <div class="field">
                           <input type="text" value="<?php echo $box_price->eight_coin_box; ?>" name="eight_coin_box" id="question" size="80" required="required">	 
                        </div>
                    </div>
 <div class="field-group">
                        <label for="email">Fifteen Coin Box</label>
                        <div class="field">
                           <input type="text" value="<?php echo $box_price->fifteen_coin_box;?>" name="fifteen_coin_box" id="question" size="80" required="required">	 
                        </div>
                    </div>
                    <div class="actions">
                        <input type='hidden' value='<?php echo $box_price->id;?>' name='id' >
                        <button class="btn btn-primary" type="submit" >Update</button>
                    </div>
              <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>

