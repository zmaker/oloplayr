var XD = XD || {};

XD.Util = function(){
	
	var util = {};
	
	var $win = $(window)
	,	xd	=	XD;
	
	// Private ()s
	
	// Broadcasts
	function broadcastResize(){
		if( xd.carousel ) xd.carousel.resize();
	}
	
	
	// Public ()s
	
	
	// Feature Detection on current user
	util.getUserConfig = function(){
		
		var userCon = {}
		,	_ua		=	navigator.userAgent;
				
		userCon.clickTrigger	=	'ontouchstart' in window ? 'touchstart' : 'click';
		userCon.resizeTrigger	=	'onorientationchange' in window ? 'orientationchange' : 'resize';
		userCon.touchStart		= 	'touchstart',
		userCon.touchMove		=	'touchmove',
		userCon.touchEnd		=	'touchend',
		userCon.touch			=	Modernizr.touch;
		userCon.iOS				=	RegExp("iPhone").test(_ua) || RegExp("iPad").test(_ua) || RegExp("iPod").test(_ua);
		userCon.mozilla			=	$.browser.mozilla
		userCon.ie				=	$.browser.msie
		userCon.handheld		=	$(window).width() < 480 || RegExp("iPhone").test(_ua) || RegExp("iPod").test(_ua);
		
		
		return userCon;
		
	}
	
	
	// Evts
	$win.bind( util.getUserConfig().resizeTrigger , broadcastResize);
	
	
	return util;
}
