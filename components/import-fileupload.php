<div style="margin: 20px;">Use only images (png, gif, jpg, jpeg), 3D model (obj, olo) or movie (mp4).</div>

            
            <?php if ($id > 0) { ?>
        <div class="alert alert-success fade in" id="alert1">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> File has been imported (<?php echo $id ?>).
            </div>
            <?php } ?>
            <?php if ($id < 0) { ?>
        <div class="alert alert-danger fade in" id="alert1">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> File has not been imported!
            </div>
            <?php } ?>

            
            <div class="form-group" style="margin-top: 50px;" >        
            <form method="post" action="upload.php" enctype="multipart/form-data" class="form-horizontal" id="uploadform">
                <input type="hidden" name="action" value="upload" />

<fieldset>      

    <!-- File Button --> 
<div class="form-group">
  <label class="col-md-2 control-label" for="filebutton" style="padding-top: 0px;">Select File</label>
  <div class="col-md-6">
    <input id="filebutton" name="user_file" class="input-file" type="file">
  </div>
</div>
    
<div id="imageform">    
<div class="form-group" >
  <label class="col-md-2 control-label" for="faces">Faces</label>
  <div class="col-md-6"> 
    <label class="radio-inline" for="faces-0">
      <input name="type" id="faces-0" value="4" checked="checked" type="radio">
      4
    </label> 
    <label class="radio-inline" for="faces-1">
      <input name="type" id="faces-1" value="3" type="radio">
      3
    </label> 
    <label class="radio-inline" for="faces-2">
      <input name="type" id="faces-2" value="2" type="radio">
      2
    </label> 
    <label class="radio-inline" for="faces-3">
      <input name="type" id="faces-3" value="1" type="radio">
      zed
    </label> 
    <label class="radio-inline" for="faces-4">
      <input name="type" id="faces-4" value="0" type="radio">
      omni
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-2 control-label" for="flipped">Type</label>
  <div class="col-md-6"> 
    <label class="radio-inline" for="flipped-0">
      <input name="flipped" id="flipped-0" value="0" checked="checked" type="radio">
      regular
    </label> 
    <label class="radio-inline" for="flipped-1">
      <input name="flipped" id="flipped-1" value="1" type="radio">
      flipped
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-2 control-label" for="radios">Image Crop</label>
  <div class="col-md-6"> 
    <label class="radio-inline" for="radios-0">
      <input name="shape" id="radios-0" value="0" checked="checked" type="radio">
      rectangular
    </label> 
    <label class="radio-inline" for="radios-1">
      <input name="shape" id="radios-1" value="1" type="radio">
      triangular
    </label>
  </div>
</div>
</div>
    
<!-- Button -->
<div class="form-group" style="margin-top: 20px;">
  <label class="col-md-2 control-label" for="singlebutton"></label>
  <div class="col-md-6">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Import</button>
  </div>
</div>

    <?php if (!empty($image)) { ?>
<div class="form-group" >
    <label class="col-md-2 control-label" for="upimg">Image</label>
    <div class="col-md-6"><?php echo $image; ?></div>
</div>
    <?php } ?>
    
</fieldset>
</form>
                
        </div>