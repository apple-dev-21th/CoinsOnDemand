<div id="contentHeader">
    <h1>Manage Coin Price</h1>
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
                <h1>JFK Coin Price</h1>
                <?php echo form_open('admin/category/updatecoinprice',array('class' => 'form uniformForm form-inline')); ?>
                <!-- <form class="form uniformForm" action="" enctype="multipart/form-data" method="post"> -->
                 <div class="field-group">
                        <label for="email"> Coin Range</label>
                        <div class="field">
                            <label for="email"> <b>Price </b></label>
                        </div>
                    </div>
                <?php 
                foreach ($price_list as $price): ?>
                    <div class="field-group">
                        <label for="email"><?php echo $price['min'].'-'.$price['max']; ?></label>
                        <div class="field">
                           <input type="text" value="<?php echo $price['price'] ;?>" name="range<?php echo $price['id'];?>" id="question" size="80" required="required">	 
                        </div>
                    </div>
                <?php endforeach; ?>
                
                    <div class="actions">
                        <button class="btn btn-primary" type="submit" >Update</button>
                    </div>
              <?php echo form_close(); ?>
            </div>
            
            <div class="widget-content">
                
                 <h1>American Eagle Coin Price</h1>
                 <?php echo form_open('admin/category/updateamericancoinprice',array('class' => 'form uniformForm form-inline')); ?>
                 <div class="field-group">
                        <label for="email"> Coin Range</label>
                        <div class="field">
                            <label for="email"> <b>Price </b></label>
                        </div>
                 </div>
                 
                  <?php 
                foreach ($american_eagle_price_list as $american_price): ?>
                    <div class="field-group">
                        <label for="email"><?php echo $american_price['min'].'-'.$american_price['max']; ?></label>
                        <div class="field">
                           <input type="text" value="<?php echo $american_price['price'] ;?>" name="range<?php echo $american_price['id'];?>" id="question" size="80" required="required">	 
                        </div>
                    </div>
                <?php endforeach; ?>
                
                    <div class="actions">
                        <button class="btn btn-primary" type="submit" >Update</button>
                    </div>
              <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- .grid -->
</div>

