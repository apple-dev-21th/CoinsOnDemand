<?php


$login_error = $this->session->flashdata('Login_error');
if (isset($login_error) && !empty($login_error)) {
    ?>     
   <div class="alert alert-danger fade in">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h3>Error Notifty</h3>
        <p>Incorrect User Name and Password Combination.</p>
    </div>
<?php
}
$succ = $this->session->flashdata('success');
if (isset($succ) &&  !empty($succ)) {
?>
<div class="alert alert-success fade in">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <strong>Success</strong> <br/><?php echo $succ; ?>
      </div>
<?php } 
$error = $this->session->flashdata('error');
if (isset($error) && !empty($error)) {
    ?>     
   <div class="alert alert-danger fade in">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h3>Error Notifty</h3>
        <p><?php echo $error ; ?></p>
    </div>
<?php
}


