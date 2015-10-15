<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Play.R | Management</title>
    
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
            <form class="form-signin" method="POST" action="action/login.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input id="inputEmail" name="login" class="form-control" placeholder="Login" required="" autofocus="" type="text">
        <label for="inputPassword" class="sr-only">Password</label>
        <input id="inputPassword" name="pwd" class="form-control" placeholder="Password" required="" type="password">
        <div class="checkbox">
          <label>
            <input value="remember-me" type="checkbox"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>


</body>
</html>
