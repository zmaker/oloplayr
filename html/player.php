<!doctype html>
<?php 
$id = 0;
if (!empty($_GET["program"])) {
  $id = $_GET["program"];
}
$addr = 'localhost:8000';
if (!empty($_GET["webaddr"])) {
  $addr = $_GET["webaddr"];
}
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Play.R | Web Player</title>    
	<?php @include("components/meta.php"); ?>
</head>
<body>

<div id="display" style="width:150px; height: 300px; border: 1px solid red;">
    Player
    <div id="txt"></div>
</div>

<script>
var addr = '<?php echo $addr; ?>';
var id = '<?php echo $id; ?>';

var statelist = new Array();
var actionlist = new Array();
var medialist = new Array();

$(document).ready(function(){ 
    loadProgram();
});
    
function loadProgram() {
    $.ajax({
       url: 'http://'+addr+'/rest/index.php/palinsesto/'+id,
       type: 'GET',       
       error: function() {
          //$('#info').html('<p>An error has occurred</p>');
       },
       dataType: 'json',
       success: function(data) {           
           decodeProgram(data);
           play();
       }
    });
}
    
function decodeProgram(str){
    //riceve un json dai WS e ricostruisce la scena
    var id = str.id;
    var name = str.name;
    var media_dir = str.media_dir;
    
    //elenco media
    var states = str.state;
    for (var i = 0; i < states.length; i++){
        var st = states[i];
        var id = st.idmedia;        
        s = new State(id);        
        s.name = st.name;
        s.title = st.title;
        s.media_type = st.media_type;
        s.media_subtype = st.media_subtype;
        s.elapsed = st.elapsed;
        s.loop = st.loop;
        s.audio = st.audio;
        s.canc = st.canc;                
        statelist.push(s);
        
    }
    var actions = str.action;
    for (var i = 0; i < actions.length; i++){
        var act = actions[i];
        var id = act.id;        
        a = new Action(id);        
        a.from = act.from_state;
        a.to = act.to_state;        
        actionlist.push(a); 
        //console.log(a.toString());
    }
}
    
var c = 0;
    
function play(){
    //trova il link iniziale
    link = findStart();
    console.log(link.toString());
    
    
    setTimeout( function(){
        execute(link.from);
    }, 1000);
    
    /*
    while (c < 10) {
        //esegue lo stato corrente
        execute(link.from);     
        //trova il prossimo stato
        link = nextAction(link.to);
        console.log('next:'+link.toString());
        c++;
    }
    */
}
    
function findStart(){
    for (var i = 0; i < actionlist.length; i++) {
        a = actionlist[i];
        if (a.isFirst()) return a;
    }
}    
function execute(st){
    console.log('EXE: '+st);
    $('#txt').html(st);
    link = nextAction(link.to);
    console.log('next:'+link.toString());
    c++;
    if (c < 100) {
        setTimeout( function(){
            execute(link.from);
        }, 1000);
    }
}
function nextAction(state){
    if (state == 'S999') state = 'S0';
    for (var i = 0; i < actionlist.length; i++) {
        a = actionlist[i];
        if (a.from == state) return a;
    }
}
    
/* Definizione Classi */
function State (id) {	
    this.id = id
    this.name = '';
    this.title = '';         
    this.media_type;
    this.media_subtype;
    this.elapsed;
    this.loop;
    this.audio;
    this.canc;
    
    this.toString = function() {
        return 'State (' + this.id + ') n:'+this.name+' t:'+this.title;
    };
}
function Media (id) {	
    this.id = id
}
function Action (id) {	
    this.id = id
    this.from;
    this.to;
    
    this.toString = function() {
        return 'Action (' + this.id + ') f:'+this.from+' t:'+this.to;
    };
    
    this.isFirst = function() {
        var ret = false;
        if (this.from == 'S0') ret = true;
        return ret;
    };
}

</script>

</body>
</html>
