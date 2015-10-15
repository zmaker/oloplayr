<?php require("components/secure.php"); ?> 
<?php
//impostazione tab
$tab = 0;
if (!empty($_GET["tab"])) {
  $tab = $_GET["tab"];
}

//codice per gestione utenti
$msg = "";
if (!empty($_GET["msg"])) {
  $i = $_GET["msg"];

  if ($i == 1) {
    $msg = "Utente inserito!";
  } else if ($i == -1) {
    $msg = "Le password non corrispondono!";
  } else if ($i == -2) {
    $msg = "Inserire tutti i parametri.";
  }
}

?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Play.R | Management</title>    
	<?php @include("components/meta.php"); ?>
    <style>
        #userlist{ width: 40%; margin-top: 50px; }
        #useradd{ width: 50%; float: right; }
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
            <h1>Settings</h1>
            <h2>SetUp your Play.R</h2>
        </div>

        <div class="content">
            
            <!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" style="margin-top: 20px;">
    <li <?php if ($tab == 0) { ?>class="active"<?php } ?>><a href="#home" role="tab" data-toggle="tab">General</a>
    <?php if (hasRole('admin')) { ?> 
    <li <?php if ($tab == 1) { ?>class="active"<?php } ?>><a href="#users" role="tab" data-toggle="tab">Users</a></li>
    <?php } ?>
    <li <?php if ($tab == 2) { ?>class="active"<?php } ?>><a href="#processes" role="tab" data-toggle="tab">Processes</a></li>
    <li <?php if ($tab == 3) { ?>class="active"<?php } ?>><a href="#path" role="tab" data-toggle="tab">Path</a></li>
    <li <?php if ($tab == 4) { ?>class="active"<?php } ?>><a href="#license" role="tab" data-toggle="tab">License</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane <?php if ($tab == 0) { ?>active<?php } ?>" id="home">
        <!-- Device type-->
        <div class="form-group row" style="margin-top: 20px;">
          <label class="col-md-4 control-label" for="textinput">Device Type</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo DEVICE_TYPE; ?>">
          </div>
        </div>
        <!-- Dimensioni-->
        <div class="form-group row ">
          <label class="col-md-4 control-label" for="textinput">Screen Size</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo RESOLUTION; ?>">
          </div>
        </div>
        <!-- Facce-->        
        <div class="form-group row">
          <label class="col-md-4 control-label" for="textinput">Faces</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo FACES; ?>">
          </div>
        </div>
        <!-- orientamento -->
        <div class="form-group row">
          <label class="col-md-4 control-label" for="textinput">Orientation</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo ORIENTATION; ?>">
          </div>
        </div>
        <!-- debug -->
        <div class="form-group row">
          <label class="col-md-4 control-label" for="textinput">Debug</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo DEBUG; ?>">
          </div>
        </div>
    </div>
    
    <?php if (hasRole('admin')) { ?>                 
    <!-- utenti -->
    <div class="tab-pane <?php if ($tab == 1) { ?>active<?php } ?>" id="users">        
        <div>
        <?php include 'components/settings-users.php';?>
        </div>
    </div>
    <?php } ?>
    
    <!-- processi -->
    <div class="tab-pane <?php if ($tab == 2) { ?>active<?php } ?>" id="processes">        
        <div>

            <fieldset>                
            <div class="form-group row" style="margin-top: 20px;">
                <label class="col-md-4 control-label" for="button1id">Service status</label>
                <div class="col-md-8">
                    <img align="middle" id="engine_icon" height="16px" alt="service status" src="/imgs/service_off.png"></li>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-md-4 control-label" for="button1id">Action:</label>
                <div class="col-md-8">
                    <button id="button1id" name="button1id" onclick="moduleOp('Player','stop')" class="btn btn-danger">Stop</button>
                    <button id="button2id" name="button2id" onclick="moduleOp('Player','start')" class="btn btn-success">Start</button>
                </div>
            </div>
            
            </fieldset>
        
            <script src="js/ui.js"></script>
            <script>
            $(document).ready(function() {
                monitor("engine");
            });

            var myVar=setInterval(function () {
                monitor("engine");
            }, 5000);
            </script>
            
        </div>
    </div>
    
    <!-- path e indirizzi -->
    <div class="tab-pane <?php if ($tab == 3) { ?>active<?php } ?>" id="path">        
        <div>
        
        <!-- orientamento -->
        <div class="form-group row" style="margin-top: 20px;">
          <label class="col-md-4 control-label" for="textinput">Ip Address</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo IPADDR; ?>">
          </div>
        </div>
            
        <div class="form-group row">
          <label class="col-md-4 control-label" for="textinput">Upload directory</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo UPLOAD_DIR; ?>">
          </div>
        </div>
            
    UPLOAD_DIR : /opt/player/repository/ <br>
            ora usa: $_SERVER['DOCUMENT_ROOT']."/repository/" 
            usata in gallery.php, upload e import.php
        </div>
    </div>
    
    <div class="tab-pane <?php if ($tab == 4) { ?>active<?php } ?>" id="license">
         <!-- licenza -->
        <div class="form-group row" style="margin-top: 20px;">
          <label class="col-md-4 control-label" for="textinput">License</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo LICENSE; ?>">
          </div>
        </div>
        <!-- serial -->    
        <div class="form-group row">
          <label class="col-md-4 control-label" for="textinput">Serial number</label>  
          <div class="col-md-4">
          <input id="textinput" name="textinput" placeholder="placeholder" class="form-control input-md" type="text" value="<?php echo SERIAL_NUMBER; ?>">
          </div>
        </div>
        
    </div>  
    
</div>
            
            
        </div>
    </div>
</div>

<script src="js/ui.js"></script>


</body>
</html>
