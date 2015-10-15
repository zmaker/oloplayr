<?php
session_start();

require("../components/commons.php"); 

$login = $_POST["login"];
$pwd = $_POST["pwd"];

$LOGGED = False;
$dest = "login.php";
//$userId = -1;

if (!empty($login) && !empty($pwd)) {
	$db = new PDO('sqlite:../data/database.db');
	$pwd = md5($pwd);

	$sql = "select count(*) from users where login='".$login."' and pwd = '".$pwd."'";

	$result = $db->prepare($sql); 
	$result->execute(); 
	$number_of_rows = $result->fetchColumn(); 

    $userId = -1;
	if ($number_of_rows = 1) {
		$LOGGED = True;
		foreach ($result as $m) {
 			$userId = $m["uid"];	
		}
		$_SESSION["userId"] = $userId;
		$_SESSION["login"] = $login;
        
        //carico i parametri dal DB in sessione
        loadParametersFromDB();
        
		$dest = "index.php";
	}
}
$_SESSION["logged"] = $LOGGED;

header("Location: ../".$dest);
die();
?>