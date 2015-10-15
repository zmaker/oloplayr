<?php
try {
    // Create file "scandio_test.db" as database
    $db = new PDO('sqlite:database.db');
    // Throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
   $sql = <<<SQL
CREATE TABLE IF NOT EXISTS mediarepo (
    mid INTEGER PRIMARY KEY, filename TEXT, hashname TEXT, filetype TEXT, file_ext INTEGER,
	upload_datetime TEXT, canc INTEGER
)
SQL;

    $db->exec($sql);
 
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}
?>
