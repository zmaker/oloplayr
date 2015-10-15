<?php require("components/secure.php"); ?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Play.R | Management</title>
    
	<?php @include("components/meta.php"); ?>
    
    <script src="js/raphael-min.js"></script>
    <script src="js/moment.js"></script>  
    <script src="js/clip.js"></script>
    <script src="js/link.js"></script> 
    <script src="js/palinsesto.js"></script> 
    
    <style>
        .draggable { }
        #container {width: 750px; height: 500px; border: 1px solid gray; position: relative;}
        #draggableHelper { /*width: 30px; height: 30px; background: yellow;*/ z-index: 100; }
        #myCanvas { width: 800px; height: 600px; border: 1px solid gray;  }

        .mclip {position: absolute; top: 10px; left: 10px; width: 170px; height: 40px; background-color: #3366FF; border-bottom: 5px solid black; font-family: "Trebuchet MS", Helvetica, sans-serif;}
        .icon { height:16px; width:16px; background-image:url('imgs/sprites.png');}
        .delete {background-position:0px 0px;}
        .unlink {background-position:0px -16px;}
        .edit {background-position:0px -48px;}
        .crosshair {background-position:0px -32px; position: absolute; bottom: 0px; right: 0px; }
        .mclip-title { position: absolute; top: 4px; left: 8px; font-size: 12px; }
        .mclip-time { position: absolute; top: 20px; left: 8px; font-size: 12px; }
        .mclip-handle { position: absolute; top: 0px; right: -10px; width: 10px; height: 10px; background-color: black; }
        .mclip-icon-delete { position: absolute; bottom: 4px; right: 6px;  }
        .mclip-icon-edit { position: absolute; bottom: 4px; right: 26px;  }
        .mclip-icon-unlink { position: absolute; bottom: 4px; right: 46px;  }
        .clip-start { background-color: rgb(255,255,255); top: 20px; left: 50px; position: absolute; width:26px; height:26px; }
        .clip-end { background-color: rgb(255,255,255); top: 20px; left: 650px; position: absolute; width:26px; height:26px; }
    </style>    
</head>
<body>
    
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

     <?php @include("components/menu.php"); ?>

    <div id="main">
        <div class="header">
            <h1>Palinsesto</h1>
            <h2>SetUp your Play.R</h2>
        </div>
    
        <div class="content">
            

                    
<!-- COMPOSER - BEGIN -->
                    <div style="margin-top: 20px; margin-bottom: 20px;">
                        <!-- http://www.elated.com/articles/drag-and-drop-with-jquery-your-essential-guide/ -->
                        <button type="button" class="btn btn-primary" id="newbutton">New Program</button>
                        <button type="button" class="btn btn-primary" id="addbutton">Add Clip</button>
                        <button type="button" class="btn btn-primary" id="savebutton">Save Program</button>
                        
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#saveas-modal">
                            Save As...
                        </button>
                        <button type="button" class="btn btn-primary" onclick="location.href='palinsesto-mgm.php';">Manage Programs</button>
                        <!-- input type='text' id='loadtxt' -->                        
                    </div>
                    
                    <div id="container"> 
                        
                        <div id="clip-start" class="clip-start"><div class="mclip-handle pinplus"></div>
                        <img src="./imgs/last24.png"></div>

                        <div id="clip-end" class="clip-end">
                        <img src="./imgs/record24.png"></div>
                        
                    </div>            

<!-- COMPOSER - END -->            
             
            
        </div>
    </div>
</div>

<!-- SAVE AS - DIALOG -->
<div class="modal fade" id="saveas-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Save Program As...</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal">
              <fieldset>
        <div class="form-group">
          <label class="col-md-4 control-label" for="name">Name:</label>  
          <div class="col-md-4">
          <input id="saveas-name" name="name" placeholder="..." class="form-control input-md" type="text">
          </div>
        </div>
              </fieldset></form>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btsv1">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- END DIALOG -->
    
<script src="js/ui.js"></script>

<?php include 'components/palinsesto_create_dialog.php'; ?>
<?php include 'components/palinsesto_gallery.php'; ?>

<?php 
$id = -1;
if (!empty($_GET["id"])) {
  $id = $_GET["id"];
?>
<script>
     $(document).ready(function(){ 
        loadprogram(<?php echo $id; ?>);
     });
</script>  
<?php
}

?>
</body>    
</html>
