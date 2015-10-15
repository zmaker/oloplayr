<div id="palinsestolist" style="margin-top: 20px;">
    <fieldset>
        <ul class="list-group">
<?php
try {
    $db = new PDO('sqlite:data/database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "select * from palinsesto where canc = 0 order by creation_date desc";
    $result = $db->query($sql);
    $i = 0;
    foreach($result as $row) {
        list($idp, $name, $creation_date) = $row;
?>
            <li class="list-group-item"><?php echo "($idp) - $name - [$creation_date]";?> - <a href="palinsesto.php?id=<?php echo $idp; ?>">Load</a> </li>          
<?php
    }
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}            
?>
        </ul>
    </fieldset>
</div><!-- userlist -->