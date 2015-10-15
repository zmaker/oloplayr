var XD = XD || {};

XD.Overlay = function(){
	
	var overlay = {};
	
	var $hovLink	=	$('.product-thumb > a')
	,	$hovOverlay
	,	dur			=	150
	,	overlayVis	=	false;
	
	
	
	if ( !Modernizr.touch ){ 
		$hovLink.hover( initOverlay, killOverlay ) 
	}
	
	function initOverlay() {
		$hovOverlay	= $(this).find('.product-overlay');
		$hovOverlay.stop().fadeTo(dur, 1);
		
	};
	
	function killOverlay() {
	
		$hovOverlay	= $(this).find('.product-overlay');
		
		$hovOverlay.stop().fadeTo(dur, 0);
		
	}
	
	return overlay;
}
