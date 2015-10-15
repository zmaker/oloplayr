<?php

try {
    // Create file "scandio_test.db" as database
    $db = new PDO('sqlite:data/database.db');
    // Throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
  
    $result = $db->query('SELECT * FROM media');
 
    foreach($result as $row) {
        list($mid, $file) = $row;
        $output  = "Id: $mid ";
        $output .= "File: $file <br>";
        //$output .= "Created at: ".date('d.m.Y H:i:s', $createdAt)."<br>";
 
        echo $output;
    }
    echo "ok";
 
   
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}

?>
