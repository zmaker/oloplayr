var XD = XD || {};

XD.Normalizr = function(){
	
	var normalizr = {};
	
	
	var manifest = ['.tooltip-info','.dd-menu', '.product-overlay'];
	
	var hasOpacity	=	$.support.opacity
	,	len			=	manifest.length
	,	i			=	0;
	
	
	if( !hasOpacity ){
		
		for(i; i<len; i++){
	
		var item = $(manifest[i]);
			
			item.css({opacity:0});	
					
		}
		
	}
	
		

	return normalizr;
};
