<div class="container white padding_30">
  <div class="box_complete_checkout">
  <p> Please wait for 10 second while we process your order. Please don't refresh the page. Thanks! </p>
    </div>
</div>
<script >
     setTimeout(function(){
         window.location.href='<?php echo base_url(); ?>checkout_complete';
     }, 10000);
    </script>