<?php

$login = $_POST["login"];
$pwd = $_POST["pwd"];
$pwd2 = $_POST["pwd2"];

$param = "";
if (!empty($login) && !empty($pwd) && !empty($pwd2)) {

	if (strcmp($pwd, $pwd2) <> 0) {
		//le password non corrispondono
		$param = "msg=-1";
		//EXIT...
	} else {

		$db = new PDO('sqlite:../data/database.db');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		 		  			 
	
		$pwd = md5($pwd);
		$sql = "insert into users (login, pwd, canc) values ('".$login."', '".$pwd."', 0)";

		$stmt = $db->prepare($sql);
		$stmt->execute();
		$inserted_id  = $db->lastInsertId();
		
		$param = "msg=1";
	}
} else {
	$param = "msg=-2";
}

header("Location: ../settings.php?tab=1&".$param);
die();
?>