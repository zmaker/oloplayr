<?php
try {
    // Create file "scandio_test.db" as database
    $db = new PDO('sqlite:scandio_test.db');
    // Throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
  
    $result = $db->query('SELECT * FROM posts');
 
    foreach($result as $row) {
        list($id, $message, $createdAt) = $row;
        $output  = "Id: $id\n";
        $output .= "Message: $message\n";
        $output .= "Created at: ".date('d.m.Y H:i:s', $createdAt)."<br>";
 
        echo $output;
    }
 
   
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}
?>
