<?php
 echo '<ul id="carousel" class="elastislide-list" >';
 foreach ($templatename as $templatename) {
echo '<li> <img src="'.base_url().'assets/uploads/'.$templatename['coin_image'].'" onclick="changetemplate('.$templatename['coin_id'].')" style="border-radius:50%" ></li>';
        }
       echo '</ul>';
?>
<script src="<?php echo base_url();?>assets/j/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/j/jquerypp.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/j/jquery.elastislide.js"></script>
<script type="text/javascript">
        $( '#carousel' ).elastislide();
</script>