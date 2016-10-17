<?php
session_start();
ini_set('display_errors', 1);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

function logToFile($filename, $msg)
{
    // open file
    $fd = fopen($filename, "a");
    // append date/time to message
    $str =  $msg;
    // write string
    fwrite($fd, $str . "\n");
    // close file
    fclose($fd);
}

$url= 'http://www.coinsondemand.com/';
//Obtains parameters from POST request
$colorHEX=$_POST["bgcolor"];
$source = $_POST["imageSource"];
$viewPortW = $_POST["viewPortW"];
$viewPortH = $_POST["viewPortH"];
$selectorX = $_POST["selectorX"];
$selectorY = $_POST["selectorY"];
$temp = explode("." , $_POST["imageSource"]);
// print_r($temp);
logToFile("check-temp.log",$temp);
$ext = $temp['3'];
logToFile("check.log",$ext);
$sty = explode(';' , $_POST['style']);
//echo '<pre>'; print_r($sty);
$size = count($sty);
$size++;
//echo $size; die;
for ($i= 0; $i<=$size; $i++) {
    if(preg_match("/top:/", $sty[$i])) {
        $Y= explode(':' , $sty[$i]);  // top
    } else if(preg_match("/left:/", $sty[$i])) {
        $X = explode(':' , $sty[$i]); // left
    } else if(preg_match("/width:/", $sty[$i]) && !preg_match("/max-/", $sty[$i]) ) {
        $W = explode(':' , $sty[$i]);
    } else if(preg_match("/height:/", $sty[$i])) {
        $H = explode(':' , $sty[$i]);
    }
}

$_POST["imageY"]  = substr($Y['1'],0, -2);
$_POST["imageX"]  = substr($X['1'] ,0 ,-2);
$pWidth = substr($W['1'], 0,-2);
$pHeight = substr($H['1'], 0,-2);
//echo $_POST["imageY"].$_POST["imageX"].$pWidth.$pHeight; die;
//$browser = get_user_browser();
//echo $browser; die;
//echo '<pre>'; print_r($sty); die;
//if($browser == 'ie') {
//	$W = explode(':' , $sty['2']);
//$H = explode(':' , $sty['3']);
//$X = explode(':' , $sty['0']);
//$Y= explode(':' , $sty['1']);
//$_POST["imageY"]  = substr($Y['1'],0, -2);
//$_POST["imageX"]  = substr($X['1'] ,0 ,-2);
//$pWidth = substr($W['1'], 0,-2);
//$pHeight = substr($H['1'], 0,-2);
//}elseif($browser == 'safari')
// {
//	 $W = explode(':' , $sty['4']);
//$H = explode(':' , $sty['5']);
//$X = explode(':' , $sty['6']);
//$Y= explode(':' , $sty['7']);
//$_POST["imageY"]  = substr($Y['1'],0, -2);
//$_POST["imageX"]  = substr($X['1'] ,0 ,-2);
//$pWidth = substr($W['1'], 0,-2);
//$pHeight = substr($H['1'], 0,-2);
//} else {
//$W = explode(':' , $sty['4']);
//$H = explode(':' , $sty['5']);
//$X = explode(':' , $sty['2']); // left
//$Y= explode(':' , $sty['1']);  // top
//$_POST["imageY"]  = substr($Y['1'],0, -2);
//$_POST["imageX"]  = substr($X['1'] ,0 ,-2);
//$pWidth = substr($W['1'], 0,-2);
//$pHeight = substr($H['1'], 0,-2);
//}
//Create the image from the image sent
$img = new Imagick($source);
//Obtain width and height from the original source.
$width = $img->getImageWidth();
$height = $img->getImageHeight();

//resize the image if the width and height doesn't match
if($pWidth != $width && $pHeight != $height){
    //$img->resizeImage($pWidth, $pHeight, imagick::FILTER_HERMITE, 0.25, false);
    $img->resizeImage($pWidth, $pHeight, imagick::FILTER_UNDEFINED, 1, false);
    //$img->sharpenImage (3,1);
    //$img->resizeImage($pWidth, $pHeight, imagick::FILTER_LANCZOS, 1, false);
    $width = $img->getImageWidth();
    $height = $img->getImageHeight();
}

//Check if we have to rotate the image
if($_POST["imageRotate"]){
    $angle = $_POST["imageRotate"];
    //rotate the image and set 'transparent' as background of rotation
    $img->rotateImage(new ImagickPixel($colorHEX), $angle);
    $rotated_width = $img->getImageWidth();
    $rotated_height = $img->getImageHeight();

    //obtain the difference between sizes so we can move the x,y points.
    $diffW = (abs($rotated_width  - $width) / 2);
    $diffH = (abs($rotated_height - $height) / 2);

    $_POST["imageX"] = ($rotated_width > $width ? $_POST["imageX"] - $diffW : $_POST["imageX"] + $diffW);
    $_POST["imageY"] = ($rotated_height > $height ? $_POST["imageY"] - $diffH : $_POST["imageY"] + $diffH);

}

//calculate the position from the source image if we need to crop and where
//we need to put into the target image.

$dst_x = $src_x = $dst_y = $src_y = 0;

if($_POST["imageX"] > 0){
    $dst_x = abs($_POST["imageX"]);
}else{
    $src_x = abs($_POST["imageX"]);
}
if($_POST["imageY"] > 0){
    $dst_y = abs($_POST["imageY"]);
}else{
    $src_y = abs($_POST["imageY"]);
}

//This fix the page of the image so it crops fine!
$img->setimagepage(0, 0, 0, 0);
//crop the image with the viewed into the viewport
$img->cropImage($viewPortW, $viewPortH, $src_x, $src_y);

//create the viewport to put the cropped image
$viewport = new Imagick();
$viewport->newImage($viewPortW, $viewPortH, $colorHEX);
$viewport->setImageFormat("png");
$viewport->setImageColorspace($img->getImageColorspace());
//$viewport->setImageCompression(Imagick::COMPRESSION_UNDEFINED);
//$viewport->setImageCompressionQuality(100);
$viewport->compositeImage($img, $img->getImageCompose(), $dst_x, $dst_y);
//crop the selection from the viewport
$viewport->setImagePage(0, 0, 0, 0);
$viewport->cropImage($_POST["selectorW"],$_POST["selectorH"], $selectorX, ($selectorY));
//$draw = new ImagickDraw();

$targetFile = 'coins/r_'.time().".".$ext;
logToFile("checkTargetFile.log",$targetFile);

//$path = 'sonusindhu/sonu_'.time().'.jpg';
//save the image into the disk
//imagepng($rotate, $path, 90);
$viewport->sharpenImage (0,1);
$viewport->writeImage($targetFile);
//$white = imagecolorallocate($img, 255, 255, 255);
//$img = "http://personalizedcoins.com/".$targetFile;
//imagearc($img, 100, 100, 380, 380,  0, 360, $white);

echo $url.$targetFile;
//$cover = 'http://personalizedcoins.com/developer/assets/images/coin_back.png';
//$mask = 'http://personalizedcoins.com/sonusindhu/coin_back.png';
//$source ="http://personalizedcoins.com/".$targetFile;
//
//$base = new Imagick($source);
//$mask = new Imagick($mask);
//$over = new Imagick($cover);
//
//$base->resizeImage(387, 389, Imagick::FILTER_LANCZOS, 1);
//$base->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
//$base->compositeImage($over, Imagick::COMPOSITE_DEFAULT, 0, 0);
//
//$path = 'sonusindhu/'.time().'.png';
//
//$base->writeImage('sonusindhu/'.time().'.png');

//echo "http://personalizedcoins.com/".$path;

function get_user_browser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];

    $ub = '';
    if(preg_match('/MSIE/',$u_agent))
    {
        $ub = "ie";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $ub = "firefox";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $ub = "safari";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $ub = "chrome";
    }
    elseif(preg_match('/Flock/i',$u_agent))
    {
        $ub = "flock";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $ub = "opera";
    }

    return $ub;
}
?>



