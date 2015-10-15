<?php require("components/secure.php"); ?> <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Play.R | Management</title>

	<?php @include("components/meta.php"); ?>
</head>
    <script>
        $(document).ready(function() {
            $("#imageform").hide();
            
            setTimeout(function() { 
                $(".alert").fadeOut( "slow" ); 
                }, 2000
            );
            
            $("input#filebutton").change(function () {
                var ext = $('#filebutton').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['gif','png','jpg','jpeg']) >= 0) {
                    $("#imageform").show();
                }
                if ($.inArray(ext, ['gif','png','jpg','jpeg', 'obj', 'olo', 'mp4']) == -1) {
                        alert('invalid extension!');
                }
            });
            
            $("#uploadform").submit( function(submitEvent) {
                var ext = $('#filebutton').val().split('.').pop().toLowerCase();
                
                if ($.inArray(ext, ['gif','png','jpg','jpeg', 'obj', 'olo', 'mp4']) == -1) {
                        alert('invalid extension!');
                        submitEvent.preventDefault();
                }
                
                
            });
            
            
        });       
    </script>
<body>
    
<?php
$id = 0;
$image = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
		// Create file "scandio_test.db" as database
		$db = new PDO('sqlite:data/database.db');
		// Throw exceptions on error
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT mid, filename, hashname, file_ext FROM mediarepo where mid = $id";
		
		$result = $db->query($sql);
	 
		foreach($result as $row) {
			list($mid, $file, $hashname, $file_ext) = $row;
			if (strcasecmp($file_ext, "obj") == 0) {
				$image = "<img id='upimg' src ='imgs/model.png' height='150px'>";	
			} else {
				$image = "<img id='upimg' src ='repository/$hashname.$file_ext' height='150px'>";	
			}
		}		
    } catch(PDOException $e) {
		echo $e->getMessage();
		echo $e->getTraceAsString();
	}
}
?>

<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

      <?php @include("components/menu.php"); ?>

    <div id="main">
        <div class="header">
            <h1>Media Upload</h1>
            <h2>Upload your media files</h2>
        </div>

        <div class="content">
            <ul class="nav nav-tabs" role="tablist" style="margin-top: 20px;">
                <li class="active"><a href="#upload" role="tab" data-toggle="tab">File upload</a>
                <li><a href="#usb" role="tab" data-toggle="tab">USB</a></li>        
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="upload">
                    <?php @include("components/import-fileupload.php"); ?>
                </div>
                <div class="tab-pane" id="usb">
                    usb 
                </div>
            </div>
        </div>
    </div>
</div>    

<script src="js/ui.js"></script>

</body>
</html>
