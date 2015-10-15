<?php

/*
$tri = cropTriangle('nano.jpg');
header ('Content-Type: image/png');
imagepng ($tri);
imagedestroy ($tri);
*/

function cropTriangle($name) {

	$src = imagecreatefromjpeg($name);

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


?>
