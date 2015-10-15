var XD = XD || {};

XD.Tooltips = function(){
	
	var tooltips = {};
	
	var $tooltips	=	$('.tooltip-container')
	,	$toolindic	=	$('.tooltip-indic')
	,	$toolinfo
	,	tipVis		=	false
	,	dur			=	200;
	
	$toolindic.hover( initTooltip );
	
	function initTooltip() {
		$toolinfo = $(this).prev($toolinfo);
		
		if( tipVis	=== false){
			$toolinfo
				.stop()
				.animate({
					'opacity': 1, 
					'left': 40 
					}, dur*.8);
			
			tipVis = true;
		}else if( tipVis === true){
			$toolinfo
				.stop()
				.animate({ 
					'opacity': 0, 
					'left': 20
					}, dur);
			
			tipVis = false;
		}
		
	}
	
	return tooltips;
};
