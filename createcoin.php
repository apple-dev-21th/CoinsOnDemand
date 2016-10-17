<?php
$docroot= $_SERVER['DOCUMENT_ROOT'];
$url= 'http://www.coinsondemand.com/';

//if(empty($_POST['template'])){
//$image = $_POST['image'];
//$filedir = "coins";
//$name = "a".time();
//$image = str_replace('data:image/png;base64,', '', $image);
//$decoded = base64_decode($image);
//file_put_contents($filedir . "/" . $name . ".png", $decoded, LOCK_EX);
////$cover = 'http://ecoins.pnf-sites.info/developer/assets/images/coin_back.png';
//
//$mask = $url.'last.png';
//
//$source = $url.'coins/' . $name . '.png';
////echo $source;
////echo $source;
//$base = new Imagick($source);
//$mask = new Imagick($mask);
////$over = new Imagick($cover);
////Imagick::resizeImage ( 350, 350,  imagick::FILTER_LANCZOS, 1, TRUE);
//$base->resizeImage(300, 300, Imagick::FILTER_LANCZOS, 1);
//$base->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
////$base->compositeImage($over, Imagick::COMPOSITE_DEFAULT, 0, 0);
//$path = 'coins/' . time() . '.png';
//$base->writeImage('coins/' . time() . '.png');
//$img = $url.$path;
//echo $img;
//}else {
// ***************** New Code ******************
$image = $_POST['image'];
$coin_type = $_POST['coin_type'];
$filedir = "coins";
$name = "a".time();  // 1st image
$image = str_replace('data:image/png;base64,', '', $image);
file_put_contents($filedir . "/" . $name . ".png", $decoded,LOCK_EX);


error_log($filedir . "/" . $name . ".png",0);

$cover = 'http://www.coinsondemand.com/outer_new.png';

if ($coin_type == 'eagle') {
    $mask = $url.'/mask_eagle_1.png';    
}else {
    $mask = $url.'/mask_72.png';
}

$source = $url.'coins/' . $name . '.png';
//echo $source;
//echo $source;

$base = new Imagick($source);

//adjust levels
//solution from stackoverflow, check http://stackoverflow.com/questions/10707738/photoshops-rgb-levels-with-imagemagick for more detail
 //$base->levelImage(2500, 1, 64180); //240 = 61680
 //$base->levelImage(2500, 1.0, 65535 + (65535 - 64180)); //on this system, levels are 0-65535 instead of 0-255, this may change if hosting is migrated
     $base->levelImage(0*256, 1, 240*256); // input level
     $base->levelImage(0*256, 1, 256*256 + (256*256 - 240*256)); // output level



$mask = new Imagick($mask);
$over = new Imagick($cover);
//Imagick::resizeImage ( 350, 350,  imagick::FILTER_LANCZOS, 1, TRUE);
//$base->resizeImage(376, 376, Imagick::FILTER_HERMITE, 0.25,false);

if ($coin_type == 'eagle') {
    $base->resizeImage(349, 349, Imagick::FILTER_UNDEFINED, 0.8,false);    
}else {
    $base->resizeImage(376, 376, Imagick::FILTER_UNDEFINED, 0.8,false);
}

//$base->sharpenImage (0,1);
$base->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
//$base->compositeImage($over, Imagick::COMPOSITE_DEFAULT, 0, 0);




$path = 'coins/' . time() . '.png';
$base->writeImage('coins/' . time() . '.png');
$img = $url.$path; // 2nd image
echo $img;
////$img="http://ecoins.pnf-sites.info/sonusindhu/1393854402.png";
//$user_img = imagecreatefrompng("$source");
//// create new image and fill with background colour
//$new_img = imagecreatetruecolor(350, 350);
//$bgcolor = imagecolorallocate($new_img); // red
//imagecolortransparent($new_img, $bgcolor);
////imagefill($new_img, 0, 0, $bgcolor); // fill background colour
//// copy and resize original image into center of new image
//imagecopyresampled($new_img, $user_img, 24, 23,0, 0, 300, 300, 300, 300);
//// Make the background transparent
//
////save it
//imagepng($new_img,'coins/file.png');
//header('Content-Type: image/png');
//$user_img = imagecreatefrompng($url.'coins/file.png'); ///in the background
//$template_img = imagecreatefrompng($url.'/assets/uploads/'.$_POST['template']);
//imagecopyresampled($user_img, $template_img, 2, 0, 2, 2, 350, 350, 350, 350);
//$tname = 'coins/t'.time().'.png';
//imagepng($user_img,"$tname");
//$file1= $docroot.'coins/file.png';
//$file2=$docroot.'coins/'.$name.'.png';
//$file3=$docroot.$path;
//$file4= $docroot.'coins/r_.*';
////echo $file1;
////echo $file2;
//echo $file3;
//unlink("$file1");
//unlink("$file2");
//unlink("$file3");
//unlink("$file4");
//}
?>

