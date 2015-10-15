<!-- dialog -->
<!-- create -->
<div class="modal fade" id="create_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Clip Editor</h4>
      </div>
        <input type="hidden" name="clip_id" id="clip_id">
      <div class="modal-body">          
      	<div class="form-group">
		  <label for="cr_titolo">Nome:</label>
		  <input type="text" name="cr_titolo" class="form-control" id="cr_titolo" placeholder="titolo del clip">
		</div>
        <div class="input-group">
	      <span class="input-group-btn">
	        <button class="btn btn-default" type="button" id="cr_btn_clip">Clip</button>
	      </span>
	      <input type="text" class="form-control" placeholder="..." id="cr_clip" name="cr_clip">
          <input type="hidden" id="cr_clipid" name="cr_clipid">
            <!--input type="hidden" id="cr_clipid" name="cr_clipname" -->
	    </div>
	    <div class="form-group">
		  <label for="cr_durata">Durata:</label>
		  <input type="text" class="form-control" id="cr_durata" name="cr_durata" placeholder="00:00:00">
		</div>
		<div class="form-group">
		  <label for="cr_loop">Ripetizioni:</label>
		  <input type="text" class="form-control" id="cr_loop" name="cr_loop" placeholder="1">
		</div>
        
        <div class="form-group">
		  <label>Audio:</label>
		  <label class="radio-inline" for="radios-0">
            <input name="audio" id="audio-0" value="1" checked="checked" type="radio">
              analogic
            </label> 
          <label class="radio-inline" for="radios-1">
            <input name="audio" id="audio-1" value="2" type="radio">
                hdmi
          </label>
          <label class="radio-inline" for="radios-2">
            <input name="audio" id="audio-2" value="0" type="radio">
                off
          </label>
		</div>
          
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_create_dismiss" class="btn btn-default" data-dismiss="modal">Annulla</button>
        <button type="button" id="btn_create_save" class="btn btn-primary">Salva</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
