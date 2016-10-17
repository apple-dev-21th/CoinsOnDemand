<div class="container">
    <div class="row">
        <div id="banner-fade">
            <ul class="bjqs">
                <!-- Wrapper for slides -->
                <?php $j =0;
                foreach($slider as $slides) { ?>
                    <li>
                        <a href="<?php echo base_url('personalizedcoin/step1/')?>"><img src="<?php echo base_url() ?>assets/uploads/<?php echo $slides['slider_image'];?>" alt=""> </a>
                    </li>
                    <?php $j++;  } ?>
            </ul>
        </div>
        <!-- Controls -->
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
      $('#banner-fade').bjqs({
        height      : 380,
        width       : 1260,
        responsive  : true
      });
    });
</script>