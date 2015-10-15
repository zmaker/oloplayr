<?php
/*
 * //cropper on-line : http://odyniec.net/projects/imgareaselect/
 * //triangle: http://stackoverflow.com/questions/17049547/php-gd-triangle-image-crop
 * 
 * */

require "tri.php";

$filename = "nano.jpg";

$tri = cropTriangle($filename);



//immagine quadrata finale
$fw = 1200;
$fh = 1200;
$img = imagecreatetruecolor ( 1200, 1200);

$nero = imagecolorallocate($img, 0, 0, 0);
imagefilledrectangle($img, 0, 0, $fw, $fh, $red);

// Get image width/height
$src = imagecreatefromjpeg($filename);
$width   = imagesx ($src);
$height  = imagesy ($src);

// Get new sizes
//list($width, $height) = getimagesize($tri);
$newwidth = $fw/3;
$newheight = $fh/3;

//echo "W = $width new w = $newwidth";

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$black = imagecolorallocate($thumb, 0, 0, 0);
// Make the background transparent
imagecolortransparent($thumb, $black);


// Resize
imagecopyresized($thumb, $tri, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

imagecopymerge($img, $thumb, ($fw-$newwidth)/2, $fh-$newheight, 0,0, $newwidth, $newheight,100);
$thumb_b = imagerotate($thumb, 180, 0);
imagecopymerge($img, $thumb_b, ($fw-$newwidth)/2, $newheight, 0,0, $newwidth, $newheight,100);

$thumb_r = imagerotate($thumb, 90, 0);
imagecopymerge($img, $thumb_r, ($fw)/2, ($fh)/2, 0,0, $newwidth, $newheight,100);

$thumb_l = imagerotate($thumb, 270, 0);
imagecopymerge($img, $thumb_l, ($fw/2) - $newwidth, ($fh)/2, 0,0, $newwidth, $newheight,100);


header('Content-Type: image/png');
imagepng($img);

//header ('Content-Type: image/png');
//imagepng ($tri);
imagedestroy ($tri);
imagedestroy($thumb);
imagedestroy($source);

?>

