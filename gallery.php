<?php require("components/secure.php"); ?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Play.R | Management | Media Gallery</title>

	<?php @include("components/meta.php"); ?>
    <style>
    .company-image-overlay
{
width: 120px;
height: 55px;
background-color: #FFFFFF;
z-index: 1;
opacity: 0.7;
    position: absolute;
    top: 0.7em; left: 1.7em;
    display:none;
    padding: 10px; 
}
.thumbnail .glyphicon {
    font-size: 30px;
}
.black {
    color: #000000;
}
    
    </style>
    <script type="text/javascript">
		$(document).ready(function() {
            
            $('.thumbnail').mouseover(function () {
                $(this).find('.company-image-overlay').show();
            }).mouseout(function () {
                $(this).find('.company-image-overlay').hide();
            });
                        
            //$('.btn-play').click(function() {
            //    console.log("play");
            //});
            $('.btn-edit').click(function() {
                console.log("edit");
            });
            
            /*$('.btn-delete').click(function() {
                $('#confirm-dialog').modal('show');
            });
            */
            $('#confirm-dialog').find('#confirm-button').click(function() {                
                var link = "/gallery.php?cmd=del&id=" + currid;
                window.location.href = link;
            });
            
			$.urlParam = function(name){
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	           return results[1] || 0; 
            }
		});
        
        var currid = -1;
        function deleteItem(id) {
            currid = id;
            $('#confirm-dialog').modal('show');
        }
	</script>
</head>
<body>

<div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
        <span></span>
    </a>

     <?php @include("components/menu.php"); ?>

    <div id="main">
        <div class="header">
            <h1>Media Gallery</h1>
            <h2>Your media files</h2>
        </div>

        <div class="content" id="container-fluid">
<?php
$MAX_PAGE_RESULTS = 12;
$COLS = 4;

$currpage = getParameter("page", 1);
$pages = ceil(getCount() / $MAX_PAGE_RESULTS);

$prevpage = getPrevPage($currpage, $pages);
$nextpage = getNextPage($currpage, $pages);
?>
            
<div class="row">
    <div class="col-md-4">
<nav>
    <ul class="pager">
        <?php if (hasPrev($currpage)) { ?>
        <li class="previous"><a href="gallery.php?page=<?php echo $prevpage; ?>">&larr; Previous</a></li>
        <?php } else { ?>
        <li class="previous disabled"><a href="#">&larr; Previous</a></li>
        <?php } ?>
        <?php if (hasNext($currpage, $pages)) { ?>
        <li class="next"><a href="gallery.php?page=<?php echo $nextpage; ?>">Next &rarr;</a></li>
        <?php } else { ?>
        <li class="next disabled"><a href="#">Next &rarr;</a></li>
        <?php } ?>
    </ul>
</nav>
    </div>

    <div class="col-md-4">&nbsp;</div>
    
    <div class="col-md-4">
        <nav>
    <div class="input-group pager">
        <form action="gallery.php" method="POST">
      <input type="text" name="src" class="form-control" placeholder="Search for...">
            <input type="hidden" name="page" value="1">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit">Go!</button>
      </span>
        </form>
    </div><!-- /input-group -->
            </nav>
  </div>         
</div>
            
<?php
try {
    $db = new PDO('sqlite:data/database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_GET['cmd'])) {	
		$cmd = $_GET['cmd'];
		if ($cmd == 'del') {
			$id = -1;
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				$db->exec('UPDATE mediarepo set canc = 1 WHERE mid ='.$id);
			}
		}
	}
  
    $skip = ($currpage - 1) * $MAX_PAGE_RESULTS;
    
    $sql = 'SELECT mid, filename, hashname, file_ext FROM mediarepo WHERE CANC = 0 order by upload_datetime desc LIMIT '.$skip.','.$MAX_PAGE_RESULTS;
    if (isset($_POST['src'])){
        $src = $_POST['src'];
        $sql = 'SELECT mid, filename, hashname, file_ext FROM mediarepo WHERE CANC = 0 '.
            'AND filename like \''.$src.'%\' '.
            'order by upload_datetime desc LIMIT '.$skip.','.$MAX_PAGE_RESULTS;
    } 
    
    $result = $db->query($sql);
    $i = 0;
    foreach($result as $row) {
        list($mid, $file, $hashname, $file_ext) = $row;
        $image = "";
        $imagelink = "";
	    $imagelink = $hashname.".".$file_ext;
        
        if (strcasecmp($file_ext, "obj") == 0) {
			$image = "./imgs/object200.png";
        } else if (strcasecmp($file_ext, "olo") == 0) {
			$image = "./imgs/object200.png";
		} else {
            if (!file_exists('./repository/'.$imagelink)) {
                $image = "./imgs/image200.png";
            } else {
                $image = "./repository/".$imagelink;
            }
		}        
        $output = $file;
        
        $row = $i % $COLS;
        $colclass = "col-md-".($MAX_PAGE_RESULTS / $COLS);
        if ($row == 0) echo "<div class=\"row\">";         
       ?>
            <div class="<?php echo $colclass; ?>">
                <div class="thumbnail">                    
                    <img src="<?php echo $image; ?>" alt="<?php echo $hashname; ?>">
                    <div class="company-image-overlay">
                        <a class="btn-play" href="javascript:play('<?php echo $imagelink; ?>')"><span class="glyphicon glyphicon-play black" aria-hidden="true"></span></a>
                        <a class="btn-edit" href="#"><span class="glyphicon glyphicon-wrench black" aria-hidden="true"></span></a>
                        <a class="btn-delete" href="javascript:deleteItem(<?php echo $mid; ?>);"><span class="glyphicon glyphicon-remove-sign black" aria-hidden="true"></span></a>
                    </div>                    
                </div>    
                <div class="caption">
                    <p><?php echo $file; ?></p>  
                </div>
            </div>            
                     <!--
	<div class="pure-u-1-4">		
		 <figure  id="media-<?php echo $mid; ?>" onclick="play('<?php echo $imagelink; ?>')"> 
		<img class="pure-img-responsive" src="<?php echo $image; ?>" alt="Peyto Lake">
		</figure>
		<a href="gallery.php?cmd=del&id=<?php echo $mid; ?>">Del</a> | <a href="javascript:play('<?php echo $imagelink; ?>')">Olo</a> | <?php echo $file; ?>
    </div>
-->
<?php
        if ($row == ($COLS -1)) echo "</div><!-- endrow -->";        
        $i++;        
    }   
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}
?>

            
            
        <hr>    
<?php
try {
	$db = new PDO('sqlite:data/database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
	if (isset($_GET['cmd'])) {
		
		$cmd = $_GET['cmd'];
		if ($cmd == 'del') {
			$id = -1;
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				$db->exec('UPDATE mediarepo set canc = 1 WHERE mid ='.$id);
			}
		}
	}
  
    $result = $db->query('SELECT mid, filename, hashname, file_ext FROM mediarepo WHERE CANC = 0 order by upload_datetime desc');
 
    foreach($result as $row) {
        list($mid, $file, $hashname, $file_ext) = $row;
        $image = "";
        $imagelink = "";
	    $imagelink = $hashname.".".$file_ext;
        if ((strcasecmp($file_ext, "obj") == 0) || (strcasecmp($file_ext, "olo") == 0)) {
			$image = "./imgs/model.png";
		} else {
			$image = "repository/".$hashname.".".$file_ext;
			//$imagelink = $hashname.".".$file_ext;
			
		}
        
        //$output  = "Id: $mid ";
        $output = $file;
        //$output .= "Created at: ".date('d.m.Y H:i:s', $createdAt)."<br>";
       ?>

                     <!--
	<div class="pure-u-1-4">		
		 <figure  id="media-<?php echo $mid; ?>" onclick="play('<?php echo $imagelink; ?>')"> 
		<img class="pure-img-responsive" src="<?php echo $image; ?>" alt="Peyto Lake">
		</figure>
		<a href="gallery.php?cmd=del&id=<?php echo $mid; ?>">Del</a> | <a href="javascript:play('<?php echo $imagelink; ?>')">Olo</a> | <?php echo $file; ?>
    </div>
-->
<?php
    }   
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}

?>

        </div>
    </div>
</div>

<script src="js/ui.js"></script>
<script>

function fs(mid) {
	
	// full-screen available?
	if (
		document.fullscreenEnabled || 
		document.webkitFullscreenEnabled || 
		document.mozFullScreenEnabled ||
		document.msFullscreenEnabled
	) {

		// image container
		var i = document.getElementById(mid);
		
		// click event handler
		//i.onclick = function() {
		
			// in full-screen?
			if (
				document.fullscreenElement ||
				document.webkitFullscreenElement ||
				document.mozFullScreenElement ||
				document.msFullscreenElement
			) {

				// exit full-screen
				if (document.exitFullscreen) {
					document.exitFullscreen();
				} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen();
				} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				}
			
			}
			else {
			
				// go full-screen
				if (i.requestFullscreen) {
					this.requestFullscreen();
				} else if (i.webkitRequestFullscreen) {
					i.webkitRequestFullscreen();
				} else if (i.mozRequestFullScreen) {
					i.mozRequestFullScreen();
				} else if (i.msRequestFullscreen) {
					i.msRequestFullscreen();
				}
			
			}
		
		//}

	}
}
</script>

<!-- dialog -->
<div id="confirm-dialog" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Conferma eliminazione</h4>
      </div>
      <div class="modal-body">
        <p>Sei sicuro di voler eliminare il file?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
        <button id="confirm-button" type="button" class="btn btn-primary">Procedi</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
</body>
</html>

<?php
function getParameter($name, $defval) {
    $ret = $defval;
    if (!empty($_GET[$name])) $ret = $_GET[$name];
    return $ret;
}

function hasPrev($currpage) {
    if ($currpage > 1) return true;
    else return false;
}

function hasNext($currpage, $maxpage) {
    if ($currpage < $maxpage) return true;
    else return false;
}

function getPrevPage($currpage, $maxpage) {
    $n = $currpage - 1;
    if ($n < 0) {
        $n = 0;
    }
    return $n;
}

function getNextPage($currpage, $maxpage) {
    $n = $currpage + 1;
    if ($n >= $maxpage) {
        $n = $maxpage;
    }
    return $n;
}

function getCount() {
    $count = 1;
    try {
        $db = new PDO('sqlite:data/database.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $result = $db->query('SELECT count(*) FROM mediarepo WHERE CANC = 0');
    
        foreach($result as $row) {
            list($rows) = $row;
            break;
		}        
        $count = $rows;
    } catch(PDOException $e) {
        $count = 0;
        echo $e->getMessage();
        echo $e->getTraceAsString();
    }
    return $count;
}
?>