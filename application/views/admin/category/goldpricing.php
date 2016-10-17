<div id="contentHeader">
    <h1>Manage Gold Coin Price</h1>
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
                <?php echo form_open('admin/category/managegoldprice',array('class' => 'form uniformForm form-inline')); ?>
                <!-- <form class="form uniformForm" action="" enctype="multipart/form-data" method="post"> -->
                 <div class="field-group">
                        <label for="email"> Coin Type</label>
                        <div class="field">
                            <label for="email"> <b>Price </b></label>
                        </div>
                    </div>
                
             
                    <div class="field-group">
                        <label for="email">Genuine 24KT Gold Plating</label>
                        <div class="field">
                           <input type="text" value="<?php echo $Gold_price->gold_price ;?>" name="gold_plated" id="question" size="80" required="required">	 
                        </div>
                    </div>
                <input type='hidden' value='<?php echo $Gold_price->id ;?>' name='id' >
                    <div class="actions">
                        <button class="btn btn-primary" type="submit" >Update</button>
                    </div>
              <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>

