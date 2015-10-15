<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Play.R | Setup</title>
    
	<?php @include("components/meta.php"); ?>
</head>
<body>

<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">

        <div class="pure-menu">
            <a class="pure-menu-heading" href="index.php"><img id="logo" src="imgs/logo-play-120.png"></a>
            
            <ul class="pure-menu-list">
                <li class="pure-menu-item">
                    <a href="http://www.fabbsrl.it/" class="pure-menu-link">
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="text-align: center;">
                        </span>                    
                    <br>Website</a>
                </li>
                
                <li class="pure-menu-item" >
                    <a href="help.php" class="pure-menu-link">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true" style="text-align: center;">
                        </span>
                        <br>Help
                    </a>
                </li>
        
                 </li>
            </ul>
        </div>
    
    </div>

    <div id="main">
        <div class="header">
            <h1>Play.R</h1>
            <h2>Olographic Media Player</h2>
        </div>

        <div class="content">
        
            <div class="row">
                <h2 class="col-md-12 form-signin-heading" style="text-align: center; margin-top: 50px; margin-bottom: 20px;">Web Player Setup</h2>
            </div>
            <div class="row">                
                <form id="playform" method="GET" action="player.php" class="form-horizontal">
                <fieldset>

                <!-- Form Name -->
                <!-- Text input-->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="webaddr">Holobox Address</label>  
                  <div class="col-md-6">
                  <input id="webaddr" name="webaddr" placeholder="holobox.local" class="form-control input-md" type="text">

                  </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="program">Program</label>
                  <div class="col-md-6">
                    <select id="program" name="program" class="form-control">                  
                    </select>
                  </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="playbutton"></label>
                  <div class="col-md-4">
                    <button id="playbutton" name="playbutton" class="btn btn-success">Play</button>
                  </div>
                </div>

                </fieldset>
                </form>
            </div>
            
        </div>
    </div>
</div>

<script src="js/ui.js"></script>
<script>
$(document).ready(function(){ 
    $('#webaddr')
    .on('input', function() {
        var str = $('#webaddr').val();
        if (str.length == 0) {
            resetForm();
        }     
    })
    .focusout(function() {
        fillForm();
    });
    
    $('#playform').submit(function( event ) {
        submitForm(event);        
    });
});
    
function submitForm(evt) {
    var addr = $('#webaddr').val();
    if (addr.length == 0) {
        alert( "Please specify an address (es.: holobox.local or localhost:8080" );
        evt.preventDefault();
        return;
    }
    var programid = $('#program').find(":selected").val();
    if (programid == null) {
        alert( "Please select a program." );
        evt.preventDefault();
        return;
    }
    $('#playform').submit();
}

function resetForm() {
    console.log("reset");
    
    $('#program')
        .find('option')
        .remove()
        .end();
}
 
function fillForm() {
    var addr = $('#webaddr').val();
    $.ajax({
       url: 'http://'+addr+'/rest/index.php/palinsesto/0/100',
       type: 'GET',       
       error: function() {
          //$('#info').html('<p>An error has occurred</p>');
       },
       dataType: 'json',
       success: function(data) {           
           for(i = 0; i < data.length; i++) {
               var id = data[i].id;
               var name = data[i].name;               
               $('#program').append($("<option value='"+id+"'>"+name+"</option>")); 
           }        
       }
    });
}
</script>

</body>
</html>
