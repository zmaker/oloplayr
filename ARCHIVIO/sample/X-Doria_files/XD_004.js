var XD = XD || {};

XD.Scrollto = function(){
	
	var scrollto = {};
	
	var config			=	XD.util.getUserConfig()
	,	ios				=	config.iOS
	,	$nav  			= 	$('.s-nav')
	,	$fnav			=	$('.f-nav')
	,	$section		=	$('.section')
	,	buffer			=	100
	,	hsh				=	window.location.hash
	,	offsetScrollAmt	=	0;
	
	if( config.mozilla ) $(window).bind('hashchange',respond);
	
	
	if( ios ) $('.secondary-nav').css({position:'absolute', top:0});
	
	$nav.live( config.clickTrigger, function( evt ){
		evt.preventDefault();
		evt.stopPropagation();
		
		var $self	= 	$(this)
		,	idx		= 	$self.parent().index();
		
		$('.current-indic').removeClass('current-indic');
		$self.addClass('current-indic');
		
		hsh		=	$self.attr('href');
		scrollto.scrollIt(idx);
		
		
		
		return false;
	});
	
	
	
	$fnav.bind( config.clickTrigger, function( evt ){
		
		
		var $self	 =	$(this)
		,	stripped =  strippedUrl($self.attr('href'));
		
		
		if( stripped.path === window.location.pathname ){
			
			evt.preventDefault();
			evt.stopPropagation();
		
			var $self	= 	$(this)
			,	idx		= 	stripped.path === '/about' ? $self.parent().index() : $self.parent().index()-1;
		
		
			console.log('~~ '+stripped.path);
		
			$('.current-indic').removeClass('current-indic');
		
			$nav.eq(idx).addClass('current-indic');
		
			hsh		=	stripped.hash;
			scrollto.scrollIt(idx);
			return false;
			
		}
		
	});
	
	
	
	scrollto.scrollIt = function(idx){
		
		offsetScrollAmt = $section.eq(idx).offset().top - buffer;
		
		if(ios){
		//	$('.secondary-nav').delay(500).animate({top:offsetScrollAmt+'px'},350);
		}
		
		if( !config.mozilla ){
			$('html, body').animate({scrollTop: offsetScrollAmt}, 300, function(){
				
				if( window.location.hash != hsh ) setHash();
				
			});//, setHash);
		}else{
			
			if( window.location.hash == hsh ){
				$('html').stop().animate({scrollTop: offsetScrollAmt}, 300);
			}else{
				setHash();	
			}
		
		}
		
		
	
	}
	
	scrollto.init = function(){
		
		$nav.each( function(i){
			
			var $self = $(this);
			
			if( $self.attr('href') == window.location.hash ){
				$self.addClass('current-indic');
				scrollto.scrollIt(i);
			} 
		});
		
	}
	
	return scrollto;

	
	
	function setHash(){
		window.location.hash = hsh;
	}
	
	function respond(evt){
		$('html').stop().animate({scrollTop: offsetScrollAmt}, 300);
	}
	
	
	function strippedUrl( str ){
		
		var hh 	= '#/'
		,	spl	= str.split(hh);
		
		return {
			path : spl[0],
			hash : spl[1]
		}
		
	}


}



