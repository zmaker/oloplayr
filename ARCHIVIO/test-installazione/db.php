<?php
  
$db = new PDO('sqlite:database.db');

$sql = "select * FROM coffee";

$result = $db->query($sql);
 
foreach ($result as $m) {
  print "(". $m["Id"]. ") " . $m["name"] . "<br>";
}
?>