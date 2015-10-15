<?php
/*
 * //cropper on-line : http://odyniec.net/projects/imgareaselect/
 * //triangle: http://stackoverflow.com/questions/17049547/php-gd-triangle-image-crop
 * 
 * */

require "images.php";

//$filename = "../test/nano.jpg";
$filename = "../test/ant.jpg";

$flipped = false;
$faces = array(
    1 => true,
    2 => true,
    3 => true,
    4 => true
);
$is_triangular = false;
$scale = 0.3;

$pic = null;
if ($is_triangular) {
	$pic = cropTriangle($filename, $flipped);
	$scale = 0.5;
} else {
	$pic = imagecreatefromjpeg($filename);
	if ($flipped == true) $pic = imagerotate($pic, 180, 0);
	$scale = 0.3;
}
//echo imagesx($tri);

$image = faces4($pic, 1200, 1200, $faces, $scale);

header('Content-Type: image/png');
imagepng($image);

imagedestroy ($pic);
imagedestroy ($image);

?>
