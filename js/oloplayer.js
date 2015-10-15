                             
var oloAPI = "/services/Player/load/image/";
var monitorServices = {"engine": "/services/Player/status"};

function test(){
        alert("ok");
}

function play(hashname){
        $.getJSON( oloAPI+hashname+'/true/false' );
}

function monitor(module) {
        //alert(module + "-" +monitorServices[module]);
        $.getJSON(monitorServices[module], function(data){
                if(data["isAlive"] == "True"){
                        $("#"+module+"_icon").prop('src','/imgs/service_on.png?$
                } else {
                        $("#"+module+"_icon").prop('src','/imgs/service_off.png$
                }
        })
}

function moduleOp(module,op) {
        $.getJSON( 'services/'+module+'/'+op );
}


$(document).ready(function() {
        //alert("oaaa");
        //$.getJSON( oloAPI );

});

