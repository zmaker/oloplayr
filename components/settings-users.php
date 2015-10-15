<div class="content">

            <div id="useradd">
            <form class="form-horizontal" method="POST" action="action/adduser.php">
            <fieldset>

            <!-- Form Name -->
            <legend>Add User</legend>

            <?php echo $msg; ?>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="login">Login</label>  
              <div class="col-md-5">
              <input id="login" name="login" placeholder="..." class="form-control input-md" required="" type="text">
                
              </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="pwd">Password</label>
              <div class="col-md-5">
                <input id="pwd" name="pwd" placeholder="..." class="form-control input-md" required="" type="password">
                
              </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="pwd2">Password</label>
              <div class="col-md-5">
                <input id="pwd2" name="pwd2" placeholder="repeat password" class="form-control input-md" required="" type="password">
                
              </div>
            </div>

            <!-- Button -->
            <div class="form-group">
              <label class="col-md-4 control-label" for="addbutton"></label>
              <div class="col-md-4">
                <button id="addbutton" name="addbutton" class="btn btn-primary">Add</button>
              </div>
            </div>

            </fieldset>
            </form>  
        </div>
        
        <div id="userlist">
            <fieldset>
            <legend>Users</legend>
            <ul class="list-group">
<?php
try {
    $db = new PDO('sqlite:data/database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "select uid,login,canc from users where canc = 0";
    $result = $db->query($sql);
    $i = 0;
    foreach($result as $row) {
        list($uid, $login, $pwd) = $row;
?>
        <li class="list-group-item"><?php echo "($uid) $login";?> </li>          
<?php
    }
} catch(PDOException $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
}            
?>
</ul>
                </fieldset>
        </div><!-- userlist -->
                </div>