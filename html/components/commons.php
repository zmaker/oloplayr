<?php 

/* carica i parametri dal db e li mette in sessione */
function loadParametersFromDB(){

    $db = new PDO('sqlite:../data/database.db');
	$sql = "select * from settings";
	$result = $db->query($sql);
    foreach($result as $row) {
        list($sid, $pname, $pvalue) = $row;   
		$_SESSION[$pname] = $pvalue;
        
        echo $pname.": ".$pvalue."<br>";
    }
}

function getSetting($pname) {
    $pvalue = "";
    $db = new PDO('sqlite:data/database.db');
	$sql = "select * from settings where pname = '$pname'";
    $result = $db->query($sql);
    foreach($result as $row) {
        $pvalue = $row['pvalue'];
    }
    return $pvalue;    
}

function saveSetting($pname, $pvalue) {
    $pvalue = "";
    $db = new PDO('sqlite:data/database.db');        
	$sql = "update settings set pvalue = '$pvalue' where pname = '$pname'";
    $db->exec($sql);        
}

//registra un media nel database
function insertMedia($original_name, $new_name, $ext, $mediatype, $upload_datetime) {
    $db = new PDO('sqlite:data/database.db');
    // Throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		 		  			 
    $sql = "INSERT INTO mediarepo (filename, hashname, file_ext, filetype, upload_datetime, canc) VALUES ('$original_name', '$new_name', '$ext', 4, '$upload_datetime', 0);";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $inserted_id  = $db->lastInsertId();    
    return $inserted_id;
}

//unzip olo file - obj + texture
function uploadOloFile($zipfile, $outdir) { 
	$DEBUG = true  
    $ret = false;
    $filename = "";
    if ($DEBUG) echo "try open olo container: ".UPLOAD_DIR.$new_name.".".$ext."<br>";
    $zip = new ZipArchive;
    $res = $zip->open(UPLOAD_DIR.$new_name.".".$ext);
    $res = $zip->open($zipfile);
    if ($res === TRUE) {
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            if ($DEBUG) echo $filename."<br>";
            $name = explode(".", $filename);
			if(strcasecmp($name[1],'obj') == 0) {
                $zip->renameName($filename,$new_name.".obj");
				break;
            }	
        }
        $zip->close();
        if ($DEBUG) echo 'rename correctly!'."<br>";
                } else {
                        if ($DEBUG) echo 'doh!'."<br>";
                }
        $res = $zip->open($zipfile);
        if ($res === TRUE) {
			$zip->extractTo($outdir);
			$zip->close();
  			if ($DEBUG) echo 'woot!'."<br>";
			$ret = true;
		} else {
            $ret = false;
  			if ($DEBUG) echo 'doh!'."<br>";
        }
    }
    return $ret;
}
?>