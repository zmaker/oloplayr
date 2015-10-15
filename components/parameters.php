<?php
//parametri comuni
$DEBUG = $_SESSION["DEBUG"];
//indirizzo ip del server
$IPADDR = $_SESSION["IPADDR"];
//nome della folder di upload
$UPLOAD_DIR = $_SESSION["UPLOAD_DIR"];
//tipo di device (1 olo, 2 totem)
$DEVICE_TYPE = $_SESSION["DEVICE_TYPE"];
//numero di facce del device
$FACES = $_SESSION["FACES"];
//risoluzione display
$RESOLUTION = $_SESSION["RESOLUTION"];
//orientamento display
$ORIENTATION = $_SESSION["ORIENTATION"];

//licenza e seriale
$SERIAL_NUMBER = $_SESSION["SERIAL_NUMBER"];
$LICENSE = $_SESSION["LICENSE"];

define("DEBUG", $DEBUG);
define("IPADDR", $IPADDR);
define("FACES", $FACES);
define("RESOLUTION", $RESOLUTION);
define("UPLOAD_DIR", $UPLOAD_DIR);
define("DEVICE_TYPE", $DEVICE_TYPE);
define("SERIAL_NUMBER", $SERIAL_NUMBER);
define("LICENSE", $LICENSE);
define("ORIENTATION", $ORIENTATION);
?>
