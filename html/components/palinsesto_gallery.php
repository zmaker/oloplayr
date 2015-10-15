<!-- GALLERY -->            
<script>
var master_addr = 'http://localhost:8000';
var repository = '/repository/';
var cols = 3;
var from = 0;
var skip = 6;

$(document).ready(function() {  
    gallery(from, skip);
    
    $("#glsrcbt1").click(function() {
        var src = $("#glsrctxt").val();
        //console.log(src);
        glsearch(src);
    });
    $("#glsrctxt").keypress(function(e) {
        if(e.which == 13) {
            var src = $("#glsrctxt").val();
            glsearch(src);            
        }
    });
});   
 
function glsearch(txt){
    $("#container-fluid .row").remove();
    from = 0;
    var srcurl = "";
    if (txt) {
        srcurl = "http://localhost:8000/rest/index.php/media.search/"+txt;
    } else {
        srcurl = "http://localhost:8000/rest/index.php/media/0/6";
    }
    $.ajax({
        url: srcurl,
        dataType: "json",        
        success: function( response ) {
            console.log( response ); 
            var row = "";
            var rowid = 1;
            for (var i = 0; i < response.length; i++) {
                row = 'row'+rowid;
                //console.log('i='+i+' row='+row);
                if ((i%cols) == 0) {                    
                    $("#container-fluid").append('<div class="row" id="'+row+'">');                                        
                }
                if ((i%cols) == 2) { 
                    rowid++;
                }
                var oo = response[i];
                addThumb(oo, row);                
            }            
        }
    }); 
}    
    
function gallery(fr, sk) {
    $.ajax({
        url: "http://localhost:8000/rest/index.php/media/"+fr+'/'+sk,
        dataType: "json",        
        success: function( response ) {
            //console.log( response ); 
            var row = "";
            var rowid = 1;
            for (var i = 0; i < response.length; i++) {
                row = 'row'+rowid;
                //console.log('i='+i+' row='+row);
                if ((i%cols) == 0) {                    
                    $("#container-fluid").append('<div class="row" id="'+row+'">');                                        
                }
                if ((i%cols) == 2) { 
                    rowid++;
                }
                var oo = response[i];
                addThumb(oo, row);                
            }            
        }
    });
}
    
function addThumb (oo, row){
    var mid = oo['id'];
    var name = oo['filename'];
    var ext = oo['fileExtension'];
    var src = oo['hashname']+'.'+ext;
    //console.log('file='+mid+' '+name);
    if (!src) {
        src = 'data:image/png;base64, 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';
    } else {
        if (ext.toLowerCase() === 'obj') {
            src = 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAABmJLR0QA9AD0APRM6qDrAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3wkKDB0Fyw3nuAAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAEyElEQVR42u3dXU7iUBiA4a+jlwQtJCwBSmALRlbgYl0BJizBSZEVGBIkEm5N54pkJiP+ID8tfd7LIl6c08e2Ec5JiqIoQtK7/TIEEiASIBIgEiBSObrc9sJ6vTY6qk2NRuN7QCIikiQxcjr7PvpPh1ssyTOIBIgEiASIBIgEiASIBIgEiCRAJEAkQCRAJEAkQCRAJEAkQCRAJAEiASIBIgEiASIBIgEiASLVrUtDcNpeXl4iz/NYLBb/HG+329Hv96PVahmkE5Zs28RzvV5b3f3AMH7//h3L5fLDn0vTNAaDASgHrCiKrdsfAFJSGKAAAsYOgQIIGKAAAgYogIBxtEABBAxQAAEDFEDAAAUQMEABBIyKBQoglYXR7/cjIiLPc1AAAWNTt9uNLMtiMxVJksR0Oo3ZbAYKIGAURfHfWG+OgQIIGJ9MHiiAgPGFSQQFEDBAAQSM/UwqKICAAQogYIACCBigAAJGmSYdFEDAAAUQMEABBAxQAAEDlBYgYIBSJSiVBzIej2O1WoFxRlCazWaMRiNAqoCjzjBOCaUsSCoJpCiKeHp6OugkgXF6KN1uN3q93snPtUpeQe7v78GoAZS7u7vSXkFqtT/Ie19t1cdtxqjX60WWZUd7RilLtdlhqtPpRKfTAeOHUP4exzpUmyvIfD6P+XxukYIdO5dljwD5pOVyGZPJBBQwAAEFDEBAAQMQUMAABBQwAAEFDEBAAQMQUMAApDL1+/1ot9sHPwmqBuWYMDZjslgsjrKFAyDf6O3tLVqtVtzc3BzlpCg7lFPA2IzBfD53BSlzdYZyShhusUApLRQwAAEFDEBAAQMQUMAABJR9QgEDEFDAAASUr0EBAxBQ3oESEWAAAso2KMcIDEAqCwUMQEABAxBQwAAElFJCAQMQUMAABBQwAAEFDEBA2ScUMAABBQxA6grl9fU1Hh4evvXe29vbuLq6MohH7pchOH67nOhwACIBIgEiASIBIgEiCRAJEAkQCRAJEAkQCRAJEAkQSYBIgEiASIBIgEiASIBIgEiASIBUvouLC7NpLvbe2Sw9mud5PD8/W7v2hFV9D8ezBhLx+d7jAqPWQEABAxBQwAAEFDAA+bQ0Tfc6GaCUD0aapoDs2mAwiMlk4opyxleMwWAAyK61Wq1oNpuxWq3cep3hrVSz2Sz9mJf+GWQ0GsV0Oo3ZbOYZ5YyeMbrdbmRZ5hlkH/V6vciyDJQzglEUhYf0fZUkCShnBmMzp4CAAkYFYVQSCChgAAIKGICAAgYgoIABCCjlgQIGIKCAAQgoYAACChiAgPI3lGazGaPR6Ee/azweH+zDm2C8c64UWz4Us16vazMoRVFEkiQHh7JpOBzG4+Pjwd/zUxh1mv9GowHIV6Ec6690maojDEAqcp9/ytI0jeFwGNfX17Wdb0BAeReGL4kBAgoYgIACBiCggAEIKGAAAgoYgICyBAMQnRoKGICAAgYgoIABiHaGAgYgoIABiP6Hkud5LBaLf4632+3o9/tgACKVF4h90qUPAkQCRAJEAkQCRAJEAkQCRAJEAkQSIBIgEiASIBIgEiASIBIgEiASIJIAkQCRAJEAkQCRAJEAkc6yy49e3LKutVSbtq7uLsktlgSIBIgEiASIVJr+AAubOo32QuaWAAAAAElFTkSuQmCC';
        } else {
            src = master_addr + repository + src;
        }            
    }

    var thumb = '<div class="col-sm-4 col-md-4" id="glcell">'+
                '<input type="hidden" name="glid" value="'+mid+'">'+
                '<input type="hidden" name="glname" value="'+name+'">'+
                '<div class="thumbnail">'+        
                    '<img src="'+src+'" alt="">' +     
                '</div>'+
                '<div class="caption">'+
                    '<p>('+mid+') '+name+'</p>'+
                '</div>'+
            '</div>';            
    var box = $(thumb);
    
    box.on('click', function() {
        var id = box.find("input[name=glid]").val();
        var name = box.find("input[name=glname]").val();
        $("#cr_clip").val(name); 
        $("#cr_clipid").val(id); 
        $("#cr_clipname").val(name); 
        $('#gallery_picker').modal('toggle');
    });

    $("#"+row).append(box);
}
    
function gl_next() {
    $("#container-fluid .row").remove();
    from = from + skip;
    gallery(from, skip);    
}    
function gl_prev() {
    $("#container-fluid .row").remove();
    from = from - skip;
    if (from < 0) from = 0;
    gallery(from, skip);
}    

</script>
 
<div class="modal fade" id="gallery_picker">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Media Gallery</h4>
      </div>

      <div class="modal-header">

<div class="input-group">
      <input type="text" class="form-control" placeholder="Search for..." id="glsrctxt">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button" id="glsrcbt1">Go!</button>
      </span>
    </div>
		<div class="btn-group" role="group" aria-label="...">
    </div>
	</div>
        
      <div class="modal-body">
 <nav>
  <ul class="pager">
    <li><a href="#" onclick="gl_prev()">Previous</a></li>
    <li><a href="#" onclick="gl_next()">Next</a></li>
  </ul>
</nav>
          
              <div class="content" id="container-fluid">    
              </div>              

      </div>
      <div class="modal-footer">
        <button type="button" id="btn_create_dismiss" class="btn btn-default" data-dismiss="modal">Chiudi</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
