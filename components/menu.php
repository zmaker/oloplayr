<?php 
function menuselect($menuvoice){
    $page = $_SERVER['REQUEST_URI'];
    if (strpos($page, $menuvoice) > 0) { 
        echo "style='background-color: #333333;'";
    } 
}

function hasRole($role){
    $ret = False;
    $str = $_SESSION["login"];
    if (strcmp($str, $role) == 0) { 
        $ret = True;
    } 
    return $ret;
}
?>
<div id="logout-badge">Hello, <?php echo $login; ?>! / <a href="action/logout.php" class="logout">logout</a></div>
    <div id="menu">
        <div class="pure-menu">
			<a class="pure-menu-heading" href="index.php"><img id="logo" src="imgs/logo-play-120.png"/></a>
            
            <ul class="pure-menu-list">

<?php
if ($LOGGED) {
?>
                <li class="pure-menu-item" <?php menuselect('gallery'); ?>>
                    <a href="gallery.php" class="pure-menu-link" >
                        <span class="glyphicon glyphicon-camera" aria-hidden="true" style="text-align: center;">
                        </span>                    
                    <br>Gallery</a>
                </li>

                <li class="pure-menu-item" <?php menuselect('import'); ?>>
                    <a href="import.php" class="pure-menu-link">
                        <span class="glyphicon glyphicon-import" aria-hidden="true" style="text-align: center;">
                        </span>                    
                    <br>Import</a>
                </li>

                <li class="pure-menu-item" <?php menuselect('palinsesto'); ?>>
                    <a href="palinsesto.php" class="pure-menu-link">
                        <span class="glyphicon glyphicon-random" aria-hidden="true" style="text-align: center;">
                        </span>                    
                    <br>Palinsesto</a>
                </li>

                <li class="pure-menu-item">
                    <a href="settings.php" class="pure-menu-link">
                        <span class="glyphicon glyphicon-wrench" aria-hidden="true" style="text-align: center;">
                        </span>                    
                    <br>Settings</a>
                </li>
<?php
}
?>
                <li class="pure-menu-item">
                    <a href="http://www.fabbsrl.it/" class="pure-menu-link">
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="text-align: center;">
                        </span>                    
                    <br>Website</a>
                </li>
                
                <li class="pure-menu-item" <?php menuselect('help'); ?>>
                    <a href="help.php" class="pure-menu-link">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true" style="text-align: center;">
                        </span>
                        <br>Help
                    </a>
                </li>

            </ul>
        </div>
    </div>
