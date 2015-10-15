    /*
    Pagina per gestione e funzionamento del palinsesto (palinsesto.php)
    */
	var paper;
	var colors = ['#FE9A2E', '#FACC2E', '#BFFF00', '#40FF00', '#00FFBF', '#2E9AFE', '#0040FF', '#BF00FF', '#FF0080', '#FF0000', '#A4A4A4'];
	var colorId = 0;	
	var clist = [];
    
    var id = 1;
	var sx=0;
  	var sy= 0;
  	var ex = 0;
  	var ey = 0;
	var parentOffset;
    
    //var links = [];
    //var xi = 50;
	//var yi = 50;

var links = [];
    var xi = 50;
	var yi = 50;
  

  $(document).ready(function(){ 
	//disable context menu
	//document.oncontextmenu = function() {return false;};

	paper = new Raphael(document.getElementById('container'), 800, 600);
    
	parentOffset = $("#container").offset();

	$("#savebutton").click(function () {		
        //exportFile(clist, links);
        alert('Da implementare: fnz UPDATE');
	});

	$("#cr_btn_clip").click(function () {
		$('#gallery_picker').modal('show');
	});
	$("#ed_btn_clip").click(function () {
		$('#gallery_picker').modal('show');
	});

	$("#addbutton").click(function () {
        resetClipDialog();
		$('#create_modal').modal('show');
	});
    
    $("#newbutton").click(function() {
        links = [];
        clist = [];    
        xi = 50;
        yi = 50;
        id = 1;
        $(".mclip").remove();
        updatePaper();
    });
      
    $("#btsv1").click(function() {
        var name = $("#saveas-name").val();
        exportFile(clist, links, name);
        $('#saveas-modal').modal('toggle');
    });

    $("#btn_create_save").click(function () {
		$('#create_modal').modal('hide');
        
        var clipid = $('#clip_id').val();
        if (clipid > 0) {
            editClip(clipid);
        } else {
            newClip();            
        }		
	});
      
    addDefaultClips();
    
 });
      
function loadprogram(id) {
    //carica il programma dato l'id.
    $.ajax({
        url: "http://localhost:8000/rest/index.php/palinsesto/"+id,
        dataType: "json",        
        success: function( response ) {
            //console.log( response );
            showPalinsesto(response);
            $('[href=#profile]').tab('show');
        }
    });
}

function addDefaultClips(){
    var clip = new MediaClip(0);
    clip.titolo = 'start';
    clip.clip = 'S0';
    clip.durata = 0;
    clip.loop = 0;
    clip.audio = 0;		
    var box1 = $("#clip-start");
    clip.setElement(box1);
    clip.x = 25;
    clip.y = 20;
    clip.mediaId = 0;
    clip.uiElementId = box1.attr('id');
    clist.push(clip);		
        
    var clip2 = new MediaClip(999);
    clip2.titolo = 'end';
    clip2.clip = 'S999';
    clip2.durata = 0;
    clip2.loop = 0;
    clip2.audio = 0;		
    var box2 = $("#clip-end");
    clip2.setElement(box2);
    clip2.x = 725;
    clip2.y = 20;
    clip.mediaId = 0;
    clip2.uiElementId = box2.attr('id');
    clist.push(clip2);		

    $("#clip-start").draggable({ containment: 'parent', cursor: 'move', cancel : 'div.pinplus',
        start: function (e, ui) {
            paper.clear();
        },
        stop: function (e, ui) {
            updatePaper();
            var dest = $(this);
            var dx = dest.offset().left - parentOffset.left;
            var dy = dest.offset().top - parentOffset.top;

            for (var i = 0; i < clist.length; i++){
                var el = clist[i];
                if (el.getUIElementId() == dest.attr('id')) {
                    el.x = dx;
                    el.y = dy;
                    break;
                }
            }            
        }
    });

    $('#clip-start div.pinplus').draggable( { cursor: 'move', containment: 'document',	helper: myHelper,
        start: function (e, ui) {               
            sx = e.pageX - parentOffset.left;
            sy = e.pageY - parentOffset.top;                
        },
        drag: function (e, ui) {
            ex = e.pageX - parentOffset.left;
            ey = e.pageY - parentOffset.top;

        },
        stop: function (e, ui) {            	
            ex = e.pageX - parentOffset.left;
            ey = e.pageY - parentOffset.top;				
        }
    });

    $("#clip-end").draggable({ containment: 'parent', cursor: 'move', 
        start: function (e, ui) {
            paper.clear();
        },
        stop: function (e, ui) {
            updatePaper();
        }
    });
    $("#clip-end").droppable({ drop: function(e, ui){
        var dest = $(this);
        createLink(ui, dest);
        } 
    });
}

function editClip(id) {
    var clip = getClipById(id);
    var titolo = $('#create_modal #cr_titolo').val();
    var clipname = $('#create_modal #cr_clip').val();
    var durata = $('#create_modal #cr_durata').val();
    var loop = $('#create_modal #cr_loop').val();
    var audio = $('#create_modal input[name=audio]:checked').val()
    clip.titolo = titolo;
    clip.clip = clipname;
    clip.durata = durata;
    clip.loop = loop;
    clip.audio = audio;
    //update elemento grafico
    $("#title-"+id).text(clip.titolo);
    var t = formatTime(clip.durata);
    $("#time-"+id).text(t);
    updatePaper();
}

function newClip() {
    var titolo = $('#create_modal #cr_titolo').val();
    var clipname = $('#create_modal #cr_clip').val();
    var clipid = $('#create_modal #cr_clipid').val(); //id del media clip
    var durata = $('#create_modal #cr_durata').val();
    var loop = $('#create_modal #cr_loop').val();
    var audio = $('#create_modal input[name=audio]:checked').val()
    addClip(titolo, clipname, clipid, durata, loop, audio);
}
      
function addClip(titolo, clipname, clipid, durata, loop, audio) {
    x = xi;
    y = yi;
    addClip(titolo, clipname, durata, loop, audio, x, y);
}

function addClip(titolo, clipname, clipid, durata, loop, audio, x, y) {
        
        var clip = new MediaClip(id);
		clip.titolo = titolo;
		clip.clip = clipname;
		clip.durata = durata;
		clip.loop = loop;
        clip.audio = audio;
        clip.mediaId = clipid;
    console.log('clip id='+id+' mediaid='+clipid);
		clist.push(clip);

		addBox(clip);	

		var box = $( "#clip-"+id );
		clip.setElement(clip);
		clip.x = x;
		clip.y = y;
		clip.uiElementId = box.attr('id');

		box.css({top: y, left: x, position:'absolute'});
		box.on('click', 'div.pinedit', function(){
			box_edit(clip);
		});
		box.on('click', 'div.pindelete', function(){
			box_delete(clip);
		});
		box.on('click', 'div.pinunlink', function(){
			box_unlink(clip);
		});
		box.draggable({ containment: 'parent', cursor: 'move', cancel : 'div.pinplus div.pinedit div.pinunlink div.pindelete', 
			start: function (e, ui) {
 				paper.clear();
			},
			stop: function (e, ui) {
 				updatePaper();

 				var dest = $(this);
 				var dx = dest.offset().left - parentOffset.left;
			  	var dy = dest.offset().top - parentOffset.top;

			  	for (var i = 0; i < clist.length; i++){
			  		var el = clist[i];
			  		if (el.getUIElementId() == dest.attr('id')) {
			  			el.x = dx;
			  			el.y = dy;
			  			break;
			  		}
			  	}
 				//console.log('index: '+id+' '+dest.attr('id')+' '+dx + ' : ' + dy);
			}
		});
		box.droppable({ drop: function(e, ui){
                var dest = $(this);
            createLink(ui, dest);            
			} 
		});

		var handleOffset = $("#clip-"+id+' mclip-handle');

		$("#clip-"+id+' div.pinplus').draggable( { cursor: 'move', containment: 'document',	helper: myHelper,
			start: function (e, ui) {               
 				sx = e.pageX - parentOffset.left;
                sy = e.pageY - parentOffset.top;
                //$("#start").html(" x: " + sx + ", y: " + sy); 
            },
			drag: function (e, ui) {
				ex = e.pageX - parentOffset.left;
                ey = e.pageY - parentOffset.top;
                
			},
            stop: function (e, ui) {
            	
				ex = e.pageX - parentOffset.left;
                ey = e.pageY - parentOffset.top;
				//$("#end").html(" x: " + ex + ", y: " + ey);
				
            }
		});

		id++;
		xi = xi + 10;
		yi = yi + 10;
    }
    
function loadLink(oid, did, cx, cy, dx, dy){
    var c1 = getClipByName(oid);
    var origin = $('#'+c1.uiElementId);
    var c2 = getClipByName(did);
    var dest = $('#'+c2.uiElementId);    
    var link = new Link(origin, dest);
    links.push(link);
    updatePaper();    
}
            
function createLink(ui, dest){
        var origin = ui.draggable.parent();
        var oid = origin.attr('id');
        var did = dest.attr('id');

        var cx = $("#container").left;
        var cy = $("#container").top;
        var px = parentOffset.left;
        var py = parentOffset.top;
        
        var dx = dest.offset().left - px;
        var dy = dest.offset().top - py;
        var dw = dest.width();
        var dh = dest.height();

        if (((ex > dx) && (ex < (dx+dw))) && ( (ey > dy) && ( ey < (dy + dh)) ) && isNewLink(origin, dest)) {
            var link = new Link(origin, dest);
            var clip1 = getClip(oid);
            link.setOriginId(clip1.id);
            var clip2 = getClip(did);                    
            link.setDestinationId(clip2.id);
            links.push(link);
            updatePaper();
        }
    }
      
function getClip(clipUiName) {
    var ret = "";
    for (i = 0; i < clist.length; i++) { 
        var clip = clist[i];
        var clipname = clip.getUIElementId();
        if (clipname == clipUiName) {
            ret = clip;
            break;
        }
    }
    return ret;
}
function getClipById(id) {
    var ret = "";
    for (i = 0; i < clist.length; i++) { 
        var clip = clist[i];
        var cid = clip.id;
        if (cid == id) {
            ret = clip;
            break;
        }
    }
    return ret;
}

function getClipByName(clipname) {
        var ret = "";
        for (i = 0; i < clist.length; i++) { 
        	var clip = clist[i];
            var cname = clip.clip;
  			if (cname == clipname) {
                ret = clip;
                break;
            }
		}
        return ret;
    }
      
	function updatePaper() {
		paper.clear();
		for (var i in links) {
  			var link = links[i];
  			paper.path( link.getLine() );
		}
	}

	function isNewLink(orig, dest) {
		var ret = true;
		if (links.length == 0) return ret;
		for (i = 0; i < links.length; i++) { 
  			var link = links[i];
			var oid1 = link.src.attr('id');
			var oid2 = orig.attr('id');
			var did1 = link.dest.attr('id');
			var did2 = dest.attr('id');
			if ((oid1 == oid2) && (did1 == did2)) {
				ret = false;
				break;			
			}
		}
		return ret;
	}

	function box_edit(clip){
        //apre la dialog di modifica del clip
		var win = $('#create_modal');
        resetClipDialog();
        //carica i valori nella dialog
        $('#clip_id').val(clip.id);
        $('#cr_titolo').val(clip.titolo);
        $('#cr_durata').val(clip.durata);
        $('#cr_clip').val(clip.clip);
        $('#cr_loop').val(clip.loop);
        
        var $radios = $('input:radio[name=audio]');
        $radios.filter('[value='+clip.audio+']').prop('checked', true);     
        //visualizza la dialog
		win.modal('show');
	}
      
    function resetClipDialog(){
        $('#clip_id').val("");
        $('#cr_titolo').val("");
        $('#cr_durata').val("");
        $('#cr_clip').val("");
        $('#cr_loop').val("0");
        var $radios = $('input:radio[name=audio]');
        $radios.filter('[value=0]').prop('checked', true);     
    }

	function box_unlink(clip){
        //var el = clip.getUIElementId();
		//var clip_id = el.attr('id'); //clip-2
        var clip_id = clip.getUIElementId();
		//console.log('curent id='+clip_id+' - links('+links.length+')');

		var i = 0;
		while (i < links.length) {
			var link = links[i];
			var src_id = link.getSource().attr('id');
			var dst_id = link.getDestination().attr('id');
			//console.log('link: '+src_id+' '+dst_id);
			if ((src_id.localeCompare(clip_id) == 0) || (dst_id.localeCompare(clip_id) == 0)) {
				links.splice(i, 1);
				//console.log('rimosso');
			} else {
				i++;
			}
		}	
		//console.log('links('+links.length+')');
		updatePaper();

	}
	function box_delete(clip){
		box_unlink(clip);
		//console.log('delete');
		var cid = clip.getId();
		//console.log("remove: "+cid);
		var id_to_remove = -1;
		var el_to_remove;
		for (var i = 0; i < clist.length; i++) { 
			var el = clist[i];
			var elid = el.getId(); 
			if (elid == cid) {
				//console.log("remove: "+cid);
				id_to_remove = i;
				el_to_remove = el;
				break;
			}
		}

		if (id_to_remove >= 0) {
            $("#clip-"+cid).remove();
			clist.splice(id_to_remove, 1);
			//el_to_remove.getElement().remove();
		}	
		updatePaper();
	}

 //});	
	
	function myHelper( event ) {
	  return '<div id="draggableHelper" class="icon crosshair"></div>';
	}

    function formatTime(tm) {
        var ms = parseInt(tm)*1000;
		return moment.utc(ms).format("HH:mm:ss");
         
    }  
      
	function addBox(clip) {
		//var ms = parseInt(clip.durata)*1000;
		//var t = moment.utc(ms).format("HH:mm:ss");
        var t = formatTime(clip.durata);
		var id = clip.id;
		var box = $('<div id="clip-'+id+'" class="mclip draggable"><div class="mclip-title"><span id="title-'+id+'">'+clip.titolo+'</span></div>'+
		'<div class="mclip-time"><span id="time-'+id+'">'+t+'</span></div>'+
		'<div class="mclip-handle pinplus"></div>'+
		'<div class="icon delete mclip-icon-delete pindelete"></div>'+
		'<div class="icon edit mclip-icon-edit pinedit"></div>'+
		'<div class="icon unlink mclip-icon-unlink pinunlink"></div>'+
		'</div>');
		
		var cid = colorId % colors.length;
		box.css({'background-color': colors[cid]});
        clip.colore = colors[cid];
		colorId++;

		$("#container").append(box);
	}

function showPalinsesto(str){
    //riceve un json dai WS e ricostruisce la scena
    var id = str.id;
    var name = str.name;
    var media_dir = str.media_dir;
    
    //elenco media
    var states = str.state;
    for (var i = 0; i < states.length; i++){
        var st = states[i];
        var clipid = st.idmedia;
        var name = st.name;
        var title = st.title;
        var media_type = st.media_type;
        var media_subtype = st.media_subtype;
        var elapsed = st.elapsed;
        var loop = st.loop;
        var x = parseInt(st.x, 10);
        var y = parseInt(st.y, 10);
        var audio = st.audio;
        var canc = st.canc;
        if ((name != "S0") && (name != "S999")) {        
            addClip(title, name, clipid, elapsed, loop, audio, x, y);     
        }
    }
    var actions = str.action;
    for (var i = 0; i < actions.length; i++){
        var act = actions[i];
        var fr = act.from_state;
        var to = act.to_state;
        var sx = act.sx;
        var sy = act.sy;
        var dx = act.dx;
        var dy = act.dy;
        console.log(fr+' '+to);
        loadLink(fr, to, sx,sy, dx, dy);
    }
}

function savePalinsesto(txt) {
     $.ajax({
        url: "http://localhost:8000/rest/index.php/palinsesto",
        dataType: "json",     
        type: "POST",
        data: txt,
        success: function( response ) {
            alert(response['name']);                        
        }
    });
}

function exportFile(clips, links, name){
    var expfile = '{ "name":"'+name+'", '+expParms()+', "media":['+expClips(clips)+'], "state":['+expStates(clips)+'], "action_event":['+expLinks(links)+']}'; 
    //console.log(expfile);
    savePalinsesto(expfile);
}
function expParms() {
    return ' "update" : false, "in_line" : [], "out_line" : [], "media_dir" : "fabb_repo" ';
}
function expClips(clist) {
    var str = "";
    for (var i = 0; i < clist.length; i++) {
        str += clist[i].toJson();
        if (i < (clist.length - 1)) {
            str += ",";
        }
    }
    return str;
}
function expStates(clist) {
    var str = "";
    for (var i = 0; i < clist.length; i++) {
        str += clist[i].toJsonState();
        if (i < (clist.length - 1)) {
            str += ",";
        }
    }
    return str;
}
function expLinks(list) {
    var str = "";
    for (var i = 0; i < list.length; i++) {
        str += list[i].toJson();
        if (i < (list.length - 1)) {
            str += ",";
        }
    }
    return str;
}

