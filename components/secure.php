<?php
session_start();

require("components/commons.php"); 
require("components/parameters.php"); 

$LOGGED = False;

$userId = "";
$login = "";

if (!empty($_SESSION["logged"]) && $_SESSION["logged"]) {
    $userId = $_SESSION["userId"];
    $login = $_SESSION["login"];
    $LOGGED = $_SESSION["logged"];
} else {
    header("Location: login.php");
    die();
}
?>