<?php
$login_error = $this->session->flashdata('Login_error');
if (isset($login_error) and !empty($login_error)) {
    ?>     
    <div class="notify notify-error">
        <a class="close" href="javascript:;">×</a>
        <h3>Error Notifty</h3>
        <p>Incorrect User Name and Password Combination.</p>
    </div>
<?php
}
$sucmsg = $this->session->flashdata('success');
if (isset($sucmsg)  &&  !empty($sucmsg)) {
    ?>
    <div class="notify notify-success">
        <a class="close" href="javascript:;">×</a>
        <h3>Success</h3>
        <p><?php echo $sucmsg; ?></p>
    </div>
<?php
}
$failmsg = $this->session->flashdata('fail');
if (isset($failmsg) && !empty($failmsg)) {
    ?>
    <div class="notify notify-error">
        <a class="close" href="javascript:;">×</a>
        <h3>Failed</h3>
        <p><?php echo $failmsg; ?></p>
    </div>
<?php } ?>


