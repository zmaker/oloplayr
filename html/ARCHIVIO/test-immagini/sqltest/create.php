<?php
try {
    // Create file "scandio_test.db" as database
    $db = new PDO('sqlite:scandio_test.db');
    // Throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS posts (
    id INTEGER PRIMARY KEY,
    message TEXT,
    created_at INTEGER
)
SQL;
    $db->exec($sql);
 
    $data = array(
        'Test '.rand(0, 10),
        'Data: '.uniqid(),
        'Date: '.date('d.m.Y H:i:s')
    );
 
    $sql = <<<SQL
INSERT INTO posts (message, created_at)
VALUES (:message, :created_at)
SQL;
 

    $stmt = $db->prepare($sql);
    foreach ($data as $message) {
        $stmt->bindParam(':message', $message, SQLITE3_TEXT);
        $stmt->bindParam(':created_at', time());
 
        $stmt->execute();
    }
 /*
    $result = $db->query('SELECT * FROM posts');
 
    foreach($result as $row) {
        list($id, $message, $createdAt) = $row;
        $output  = "Id: $id\n";
        $output .= "Message: $message\n";
        $output .= "Created at: ".date('d.m.Y H:i:s', $createdAt)."\n";
 
        echo $output;
    }
 
    $db->exec("DROP TABLE posts");
*/
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}
?>
