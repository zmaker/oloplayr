<?php require("components/secure.php"); ?> 
<?php
require "components/images.php";

try 
{
    //generated filename
    $new_name = "";
    $original_name = "";
    $upload_datetime = date('Y-m-d h:i:s');
    $ext = "";

    $inserted_id = -1;

    //parametri per creazione immagine
    $type = 4;
    $flipped = 0;
    $shape = 0;
    if (isset($_POST['type'])) $type = $_POST['type'];
    if (isset($_POST['flipped'])) $flipped = $_POST['flipped'];
    if (isset($_POST['shape'])) $shape = $_POST['shape'];

    if ($DEBUG) echo "t: $type f: $flipped s: $shape <br>";

    if(isset($_POST['action']) and $_POST['action'] == 'upload')
    {
    
        if ($DEBUG) echo "action: upload<br>"; 

        if(isset($_FILES['user_file']))
        {

            $file = $_FILES['user_file'];                
            if ($DEBUG) echo "user_file: presente<br>";
            if($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name']))
            {                
                $original_name = $file['name'];
                $new_name = hash('md5', $file['name']+time());
                $ext = pathinfo($original_name, PATHINFO_EXTENSION);			
                move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].UPLOAD_DIR.$new_name.".".$ext);

                $mediatype = -1;
                
                switch ($ext) {
                    case "olo":
                        $mediatype = 1;
                        if (uploadOloFile(UPLOAD_DIR.$new_name.".".$ext, UPLOAD_DIR)) $ext = 'obj';
                        break;
                    case "mp4":
                        $mediatype = 2;
                        break;
                    case "obj":
                        $mediatype = 3;
                        break;
                    case "png":
                    case "gif":
                    case "jpg":
                    case "jpeg":
                        $mediatype = 4;
                        createOloImage(UPLOAD_DIR.$new_name.".".$ext, $ext, $type, $flipped, $shape, $DEBUG);                            
                        break;
                    default:
                }                
                insertMedia($original_name, $new_name, $ext, $mediatype, $upload_datetime);                  
            }
        }
    } 	
    if (! $DEBUG) header("location: import.php?id=$inserted_id ");   
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}
?>
