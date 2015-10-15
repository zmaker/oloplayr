var XD = XD || {};


XD.ScrollManager = function(){
	
	// Vars
	var self		=	this
	,	$win		=	$(window)
	,	$winHeight	=	$win.height()
	,	$diagrams	=	$('.diagram')
	,	$shifters	=	$('.diagram-shifter')
	,	$bgs		=	$('.bg-image')
	,	$tris		=	$('.ani-tri');
	
	
	// ()s
	this.init = function(){
		
		setTimeout(function(){
			
			viewportScroll();
					
		},50);
		
		$win.scroll( viewportScroll );			
	}
	
	
	
	function viewportScroll(){
		
		$diagrams.each( function(i){
			
			var $self		=	$(this)
			,	intensity	=	$self.data('intensity')
			,	sy			=	$win.scrollTop()
			,	wh			=	$win.height()
			,	halfWin		=	(wh/2) + sy
			,	top			=	$self.offset().top
			,	l1			=	$('.l-1', $self)
			,	l2			=	$('.l-2', $self)
			,	l3			=	$('.l-3', $self)
			,	l4			=	$('.l-4', $self)
			,	dHeight		=	$self.height()
			,	factor		=	(((top+dHeight/2)-halfWin)/(wh/2+dHeight/2))
			,	val			=	Math.max( factor * intensity, 0 );

			l1.css({ top: val+'%' });
			l2.css({ top:-val*.8+'%' });
			l3.css({ top:val*.5+'%' });
			l4.css({ top:-val*.5+'%' });
			
		});
		
		
		
		
		
		
	}
	
	
	function isInViewport( el ){
	
		var	top	= el.offset().top;
		
		if( ($win.scrollTop()+$win.height()) > top && (top+el.height()) > $win.scrollTop() ){
			return true;
		}
		return false;
	}
	
	
	// init + return
	this.init();
	
	return this;
		
}