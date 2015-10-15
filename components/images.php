<?php
/*
 * Crea immagine su filke sistem a partire dai parametri e dall'immagine temp caricata via web
 * type: 4face: 4 - 3face: 3 - Bifaccia: 2 - ZED: 1 - omni360: 0
 * flipped: capovolge l'immagine: 0 diritta, 1 capovolta
 * shape: 0 rettangolare - 1 triangolare
 * */
function createOloImage($filename, $ext, $type, $flip, $shape) { 
    
    //echo "RXPAR: file: $filename, ext: $ext, typ: $type, flip: $flip, sha: $shape <br>";
    
	$faces = array(
		1 => true,
		2 => true,
		3 => true,
		4 => true
	);
    
	switch ((int)$type) {
    case 4:
        break;
    case 3:
        $faces[1] = false;
        break;
    case 2:
        $faces[1] = false;
        $faces[3] = false;
        break;
    case 1:
		//non dovrebbe arrivare qui....
        break;
    case 0:
		//da creare ancora!
        break;
    default:
    
	}
	
	$flipped = false;
	if ((int)$flip == 1) $flipped = true;

	$is_triangular = false;
	if ((int)$shape == 1) $is_triangular = true;

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

	// save thumbnail into a file
    if ((strcasecmp($ext, "JPG") == 0) || (strcasecmp($ext, "JPEG") == 0)){
         imagejpeg( $image, $filename );
    } else if (strcasecmp($ext, "PNG") == 0) {
        imagepng($image , $filename);
    } else if (strcasecmp($ext, "GIF") == 0) {
        imagegif($image, $filename);
    }
    
    //header('Content-Type: image/png');
    //imagepng($image);
    	
	//imagedestroy ($pic);
	imagedestroy ($image);
}

/*
$tri = cropTriangle('nano.jpg');
header ('Content-Type: image/png');
imagepng ($tri);
imagedestroy ($tri);
*/
function cropTriangle($name, $flipped) {

	$src = imagecreatefromjpeg($name);

	if ($flipped == true) $src = imagerotate($src, 180, 0);

	// Get image width/height

	$srcWidth   = imagesx ($src);
	$srcHeight  = imagesy ($src);

	// Get centre position

	$centreX    = floor ($srcWidth / 2);
	$centreY    = floor ($srcHeight / 2);

	// Calculate triangle length (base) and points

	if ( $srcWidth >= $srcHeight ) {
		$base = (2 * $srcHeight) / sqrt(3);
		$points = array( 'a' => array( 'x' => $centreX - ( $base / 2 ),
									   'y' => $srcHeight ),
						 'b' => array( 'x' => $centreX + ( $base / 2 ),
									   'y' => $srcHeight ),
						 'c' => array( 'x' => $centreX,
									   'y' => 0 ) );
	} else {
		$base = $srcWidth;
		$height = $base * sqrt(3) / 2;
		$points = array( 'a' => array( 'x' => 0,
									   'y' => $centreY + ( $height / 2 ) ),
						 'b' => array( 'x' => $srcWidth,
									   'y' => $centreY + ( $height / 2 ) ),
						 'c' => array( 'x' => $centreX,
									   'y' => $centreY - ( $height / 2 ) ) ); 
	}

	// Create destination, same size as source

	$dest = imagecreatetruecolor ($srcWidth, $srcHeight);

	// Setup full alpha handling for pngs (8-bit)
	imagealphablending ($dest, false);
	imagesavealpha ($dest, true);

	// Define a transparent colour

	$colTrans  = imagecolorallocatealpha ($dest, 255, 255, 255, 127);

	// If old png transparency was used, setting the transparency colour
	// would be needed, with 8-bit it is not
	// imagecolortransparent ($dest, $colTrans);

	// Make the image transparent

	imagefill ($dest, 0, 0, $colTrans);

	// Copy from source just the rectangle flush with the triangle

	imagecopy ($dest, $src, // Images
			   $points['a']['x'], $points['c']['y'], // Destination x,y
			   $points['a']['x'], $points['c']['y'], // Source x,y
			   $points['b']['x'] - $points['a']['x'], // Width
			   $points['a']['y'] - $points['c']['y']); // Height

	// Fill out the triangles within that area not wanted with transparent

	// Left side

	imagefilledpolygon ($dest, array( $points['a']['x'], $points['a']['y'],
									  $points['c']['x'], $points['c']['y'],
									  $points['a']['x'], $points['c']['y'] ),
						3, $colTrans);

	// Right side

	imagefilledpolygon ($dest, array( $points['b']['x'], $points['b']['y'],
									  $points['c']['x'], $points['c']['y'],
									  $points['b']['x'], $points['c']['y'] ),
						3, $colTrans);
						
	imagedestroy ($src);
	return $dest;
}

/* 
 * compone un'immagine per ologramma a quattro facce ripetendo $tri
 */

function faces4($tri, $fw, $fh, $faces, $scale) {
	
	//immagine quadrata finale
	$img = imagecreatetruecolor ( 1200, 1200);

	//colora di nero l'immagine finale
	$nero = imagecolorallocate($img, 0, 0, 0);
	imagefilledrectangle($img, 0, 0, $fw, $fh, $nero);

	// dimensioni del triangolino
	$src = $tri;
	$width   = imagesx ($src);
	$height  = imagesy ($src);
	// triangolo ridimensionato
	$newwidth = $fw * $scale;
	$newheight = $fh * $scale;
	//creazione thumb
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$black = imagecolorallocate($thumb, 0, 0, 0);
	// Make the background transparent
	imagecolortransparent($thumb, $black);
	// Resize
	imagecopyresized($thumb, $tri, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	//composizione immagine
	// 1. settore inferiore
	$x1 = ($fw-$newwidth)/2;
	$y1 = $fh-$newheight;
	if ($faces[1] ) {	
		imagecopymerge($img, $thumb, $x1, $y1, 0,0, $newwidth, $newheight,100);
	}
	// 2. settore superiore
	$y2 = 0;
	if ($faces[3] ) {
		$thumb_b = imagerotate($thumb, 180, 0);
		imagecopymerge($img, $thumb_b, $x1, $y2, 0,0, $newwidth, $newheight,100);
	}
	// 3. settore destro
	$x3 = $fw - $newheight;
	$y3 = ($fh - $newwidth)/2;
	if ($faces[2]) {
		$thumb_r = imagerotate($thumb, 90, 0);
		imagecopymerge($img, $thumb_r, $x3, $y3, 0,0, $newwidth, $newheight,100);
	}
	// 4. settore sinistro
	if ($faces[4]) {
		$thumb_l = imagerotate($thumb, 270, 0);
		imagecopymerge($img, $thumb_l, 0, $y3, 0,0, $newwidth, $newheight,100);
	}
	imagedestroy($thumb);
	imagedestroy($src);

	return $img;
}


?>
