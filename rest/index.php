<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/*
http://www.ibm.com/developerworks/library/x-slim-rest/
*/

$db = new PDO('sqlite:../data/database.db');

$app->get(
    '/',
    function () use ($app, $db) {
        $template = <<<EOT
<!DOCTYPE html>
    <html><body>
    <h1>Rest services here!</h1>
    <ul>
    <li>GET: /rest/index.php/media
    <li>GET: /rest/index.php/media/:id
    <li>GET: /rest/index.php/media/:skip/:count
    <li>GET: /rest/index.php/setting
    <li>GET: /rest/index.php/setting/:name
     </body>
    </html>
EOT;
       echo $template;
    }
);

// call this first to gain access to protected API methods
$app->get('/demo', function () use ($app) {    
  try {
    $app->setEncryptedCookie('uid', 'demo', '5 minutes');
    $app->setEncryptedCookie('key', 'demo', '5 minutes');
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});


// route middleware for simple API authentication
function authenticate(\Slim\Route $route) {
    $app = \Slim\Slim::getInstance();
    $uid = $app->getEncryptedCookie('uid');
    $key = $app->getEncryptedCookie('key');
    if (validateUserKey($uid, $key) === false) {
      $app->halt(401);
    }
}

function validateUserKey($uid, $key) {
  if ($uid == 'demo' && $key == 'demo') {
    return true;
  } else {
    return false;
  }
}

class media {
    var $id;
    var $filename;
    var $hashname;
    var $fileType;
    var $fileExtension;
    var $uploadDateTime;
    var $canc;
}

class palinsesto {
    var $id;
    var $name;
    var $creation_date;
    var $canc;
    var $media_dir;
    
    var $media = array();
    var $state = array();
    var $action = array();
        
    public function addMedia($m) {
        array_push($this->media, $m);        
    }
    public function addState($s) {
        array_push($this->state, $s);        
    }
    public function addAction($a) {
        array_push($this->action, $a);        
    }
}

class palinsesto_media {
    var $idpalinsesto;
    var $idmedia;
    var $name;
    var $media_type;
    var $media_subtype;
    var $elapsed;
    var $loop;
    var $x;
    var $y;
    var $canc;
    
    public function fromDb($rw){        
        $this->idpalinsesto = $rw['idpalinsesto'];
        $this->idmedia = $rw['idmedia'];
        $this->name = $rw['name'];
        $this->media_type = $rw['media_type'];
        $this->media_subtype = $rw['media_subtype'];
        $this->elapsed = $rw['elapsed'];
        $this->loop = $rw['loop'];
        $this->x = $rw['x'];
        $this->y = $rw['y'];
        $this->canc = $rw['canc'];
    }
}

class palinsesto_state {
    var $id;
    var $idpalinsesto;
    var $name;
    var $title;
    var $start_media;
    var $stop_media;
    var $active_button;
    var $audio;
    var $colore;
    var $x;
    var $y;
    var $canc;
    
    public function fromDb($rw){        
        $this->id = $rw['idps'];
        $this->idpalinsesto = $rw['idpalinsesto'];
        $this->name = $rw['name'];
        $this->title = $rw['title'];
        $this->start_media = $rw['start_media'];
        $this->stop_media = $rw['stop_media'];
        $this->active_button = $rw['active_button'];
        $this->audio = $rw['audio'];
        $this->colore = $rw['colore'];
        $this->x = $rw['x'];
        $this->y = $rw['y'];
        $this->canc = $rw['canc'];
    }
}

class palinsesto_action {
    var $id; 
    var $idpalinsesto; 
    var $event;
    var $from_state;
    var $to_state;
    var $sx;
    var $sy;
    var $dx;
    var $dy;
    var $canc;
    
    public function fromDb($rw){        
        $this->id = $rw['idpa'];
        $this->idpalinsesto = $rw['idpalinsesto'];
        $this->event = $rw['event'];
        $this->from_state = $rw['from_state'];
        $this->to_state = $rw['to_state'];
        $this->sx = $rw['sx'];
        $this->sy = $rw['sy'];
        $this->dx = $rw['dx'];
        $this->dy = $rw['dy'];
        $this->canc = $rw['canc'];  
    }
}

// GET route
$app->get('/media', /*'authenticate',*/
    function () use ($app, $db) {
        $list = array();
        $sql = "select * from mediarepo where canc = 0 order by mid desc";
	    $result = $db->query($sql);
        foreach($result as $row) {
            $obj = new media();
            $obj->id = $row[0];
            $obj->filename = $row[1];
            $obj->hashname = $row[2];
            $obj->fileType = $row[3];
            $obj->fileExtension = $row[4];
            $obj->uploadDateTime = $row[5];
            $obj->canc = $row[6];
            array_push($list, $obj);
        }
        $app->response()->header('Content-Type', 'application/json');    
        echo json_encode($list);
    }
);

$app->get('/media/:skip/:count',
    function ($skip, $count) use ($app, $db) {
        $list = array();
        if ($skip < 0) $skip = 0;
        if ($count < 0) $count = 0;
        $sql = "select * from mediarepo where canc = 0 order by mid desc LIMIT $skip, $count";
	    $result = $db->query($sql);
        foreach($result as $row) {
            $obj = new media();
            $obj->id = $row[0];
            $obj->filename = $row[1];
            $obj->hashname = $row[2];
            $obj->fileType = $row[3];
            $obj->fileExtension = $row[4];
            $obj->uploadDateTime = $row[5];
            $obj->canc = $row[6];
            array_push($list, $obj);
        }
        $app->response()->header('Content-Type', 'application/json');    
        echo json_encode($list);
    }
);


$app->get('/media/:id',
    function ($id) use ($app, $db) {
        $list = array();
        $sql = "select * from mediarepo where mid = $id";
	    $result = $db->query($sql);
        foreach($result as $row) {
            $obj = new media();
            $obj->id = $row[0];
            $obj->filename = $row[1];
            $obj->hashname = $row[2];
            $obj->fileType = $row[3];
            $obj->fileExtension = $row[4];
            $obj->uploadDateTime = $row[5];
            $obj->canc = $row[6];
            array_push($list, $obj);
            break;
        }
        $app->response()->header('Content-Type', 'application/json');    
        echo json_encode($list);
    }
);

$app->get('/media.search/:src',
    function ($src) use ($app, $db) {
        $list = array();
        $sql = "select * from mediarepo where filename like '$src%' and canc = 0 ";
	    $result = $db->query($sql);
        foreach($result as $row) {
            $obj = new media();
            $obj->id = $row[0];
            $obj->filename = $row[1];
            $obj->hashname = $row[2];
            $obj->fileType = $row[3];
            $obj->fileExtension = $row[4];
            $obj->uploadDateTime = $row[5];
            $obj->canc = $row[6];
            array_push($list, $obj);
        }
        $app->response()->header('Content-Type', 'application/json');    
        echo json_encode($list);
    }
);

class setting {
    var $id;
    var $name;
    var $value;
    var $description;
}

$app->get('/setting',
    function () use ($app, $db) {
        $list = array();
        $sql = "select * from settings";
	    $result = $db->query($sql);
        foreach($result as $row) {
            $obj = new setting();
            $obj->id = $row[0];
            $obj->name = $row[1];
            $obj->value = $row[2];
            $obj->description = $row[3];
            array_push($list, $obj);
        }
        $app->response()->header('Content-Type', 'application/json');    
        echo json_encode($list);
    }
);

$app->get('/setting/:name',
    function ($name) use ($app, $db) {
        $list = array();
        $sql = "select * from settings where pname = '$name'";
	    $result = $db->query($sql);
        foreach($result as $row) {
            $obj = new setting();
            $obj->id = $row[0];
            $obj->name = $row[1];
            $obj->value = $row[2];
            $obj->description = $row[3];
            array_push($list, $obj);
            break;
        }
        $app->response()->header('Content-Type', 'application/json');    
        echo json_encode($list);
    }
);

//palinsesto
$app->get('/palinsesto',
    function () use ($app, $db) {
        $list = array();
        $sql = "select * from palinsesto where canc = 0 order by creation_date desc";
        $result = $db->query($sql);	    
        foreach($result as $row) {            
            $obj = new palinsesto();
            $obj->id = $row[0];            
            $obj->name = $row[1];
            $obj->creation_date = $row[2];
            $obj->media_dir = $row[3];    
            array_push($list, $obj);
        }
        $app->response()->header('Content-Type', 'application/json');            
        echo json_encode($list);
    }
);
$app->get('/palinsesto/:skip/:count',
    function ($skip, $count) use ($app, $db) {
        $list = array();
        $sql = "select * from palinsesto where canc = 0 order by creation_date desc LIMIT $skip, $count";
        $result = $db->query($sql);	    
        foreach($result as $row) {            
            $obj = new palinsesto();
            $obj->id = $row[0];            
            $obj->name = $row[1];
            $obj->creation_date = $row[2];
            $obj->media_dir = $row[3];    
            array_push($list, $obj);
        }
        $app->response()->header('Content-Type', 'application/json');            
        echo json_encode($list);
    }
);
$app->get('/palinsesto/:id',
    function ($id) use ($app, $db) {
        $list = array();
        $sql = "select * from palinsesto where idp = $id order by creation_date desc";                
        $pal = new palinsesto();
        $result = $db->query($sql);	    
        foreach($result as $row) {            
            $pal->id = $row[0];            
            $pal->name = $row[1];
            $pal->creation_date = $row[2];
            $pal->media_dir = $row[3];    
            break;
        }
        
        $sqlm = "SELECT * FROM palinsesto_media where canc = 0 and idpalinsesto = $id ";        
        $rs = $db->query($sqlm);	    
        foreach($rs as $row) {            
            $mm = new palinsesto_media();
            $mm->fromDb($row);
            $pal->addMedia($mm);
        }
        
        $sqls = "SELECT * FROM palinsesto_state where canc = 0 and idpalinsesto = $id ";
        $rs = $db->query($sqls);	    
        foreach($rs as $row) {            
            $ss = new palinsesto_state();
            $ss->fromDb($row);
            $pal->addState($ss);
        }
        
        $sqla = "SELECT * FROM palinsesto_action where canc = 0 and idpalinsesto = $id ";
        $rs = $db->query($sqla);	    
        foreach($rs as $row) {            
            $aa = new palinsesto_action();
            $aa->fromDb($row);
            $pal->addAction($aa);
        }
        
        //array_push($list, $pal);            
        $app->response()->header('Content-Type', 'application/json');            
        echo json_encode($pal);
    }
);

//palinsesto - Create
$app->post('/palinsesto', 
    function () use ($app, $db) {
        $req = $app->request();
        $body = json_decode($req->getBody());
        
        $idpalinsesto = -1;
        $p1 = $body->name;
        $p2 = $body->media_dir;    
        $sql = "INSERT INTO palinsesto (name, media_dir) VALUES (:name,:media_dir)";
        $sqlm = "INSERT INTO palinsesto_media (idpalinsesto,idmedia,name,media_type,media_subtype,elapsed,loop,x,y) VALUES (:idpalinsesto,:idmedia,:name,:media_type,:media_subtype,:elapsed,:loop,:x,:y)";
        $sqls = "INSERT INTO palinsesto_state (idpalinsesto, name, title, start_media, stop_media, active_button, audio, colore, x, y) VALUES (:idpalinsesto, :name, :title, :start_media, :stop_media, :active_button, :audio, :colore, :x, :y)";
        $sqla = "INSERT INTO palinsesto_action (idpalinsesto, event, from_state, to_state, sx,sy,dx,dy) VALUES (:idpalinsesto, :event, :from_state, :to_state, :sx,:sy,:dx,:dy)";
              
        $media = $body->media;
        $stati = $body->state;
        $action = $body->action_event;
        try {            
            $st = $db->prepare($sql);    
            $st->bindParam(':name', $p1);
            $st->bindParam(':media_dir', $p2);
            $st->execute();
            
            $idpalinsesto = $db->lastInsertId();
            
            $stm = $db->prepare($sqlm);
            foreach($media as $mm) {
                $stm->bindParam(':idpalinsesto', $idpalinsesto);
                $stm->bindParam(':idmedia', $mm->id);
                $stm->bindParam(':name', $mm->name);
                $stm->bindParam(':media_type', $mm->type);
                $stm->bindParam(':media_subtype', $mm->subtype);
                $stm->bindParam(':elapsed', $mm->elapsed);
                $stm->bindParam(':loop', $mm->loop);
                $stm->bindParam(':x', $mm->x);
                $stm->bindParam(':y', $mm->y);
                $stm->execute();                
            }
            
            $sts = $db->prepare($sqls);
            foreach($stati as $ss) {
                $sts->bindParam(':idpalinsesto', $idpalinsesto);
                $sts->bindParam(':name', $ss->name);
                $sts->bindParam(':title', $ss->title);
                
                $str = "";
                foreach($ss->start_media as $el) {
                    $str = $str . $el . ",";
                }                
                $sts->bindParam(':start_media', $str);
                $str1 = "";
                foreach($ss->stop_media as $el) {
                    $str1 = $str1 . $el . ",";
                }
                $sts->bindParam(':stop_media', $str1); 
                $str2 = "";
                foreach($ss->active_button as $el) {
                    $str2 = $str2 . $el . ",";
                }
                $sts->bindParam(':active_button', $str2); 
                
                $sts->bindParam(':audio', $ss->audio);
                $sts->bindParam(':colore', $ss->colore);
                $sts->bindParam(':x', $ss->x);
                $sts->bindParam(':y', $ss->y);
                $sts->execute();                
            }
            
            $sta = $db->prepare($sqla);
            foreach($action as $aa) {
                $sta->bindParam(':idpalinsesto', $idpalinsesto);
                $sta->bindParam(':event', $aa->event);
                $sta->bindParam(':from_state', $aa->fromState);
                $sta->bindParam(':to_state', $aa->toState);
                $sta->bindParam(':sx', $aa->sx);
                $sta->bindParam(':sy', $aa->sy);
                $sta->bindParam(':dx', $aa->dx);
                $sta->bindParam(':dy', $aa->dy);
                $sta->execute();                
            }
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
        echo "ok $idpalinsesto";
    }
);


/*
// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);
*/

$app->run();
