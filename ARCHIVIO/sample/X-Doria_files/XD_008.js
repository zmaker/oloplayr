var XD = XD || {};

XD.Carousel = function() {

	//Carousel
	var exports = {};
	
	var	xd				=	XD
	,	config			=	xd.util.getUserConfig()
	,	$win			=	$(window)
	,	$main			=	$('#main')
	,	$ulWidth		=	960
	,	$carousel		=	$('.xd-carousel')
	,	$ul				=	$('.xd-carousel').find('ul')
	,	$slides			=	$('.xd-carousel ul > li')
	,	$sImg			=	$slides.find('img')
	,	$indic			=	[]
	,	len				=	$slides.length
	,	moveSlide		=	$slides.width() * current
	,	current			=	0
	,	indicTmpl		=	'<li></li>'
	,	classString		=	'current-indic'
	
	, 	flipClass		=	'l-flipped'
	,	triForce		=	$('.tri-teal')
	, 	firstRun			=	true
	,	fromResize		=	false
	,	timer;
	
	$sImg.css({'opacity': 0 });
	
	$win.bind('load',  function() {	init(); });
	
	
	// ()s	
	generateIndicators = function() {
	
		//var classString = 'current-indic';
	
		//make indicators based on # of slides
		$slides.each(function() {
			$(indicTmpl).appendTo('.carousel-indicator');
		});
		
		// Cache indic var
		$indic = $('.carousel-indicator').find('li'); 
		
		$indic.eq(current).addClass(classString);
		
		$indic.live(config.clickTrigger , function(){
			var $el = $(this);
			current = $el.index();
			fromResize = false;
			exports.updateSlider();
			
			console.log( timer );
			
			if( timer ){
				
				clearInterval(timer);
				timer = null;
				
			}
			
			
		});
	}
	
	
	init = function() {
		triForce.find('h2 a').html( $slides.eq(current).attr('data-copy') );
		triForce.find('h2 a').attr( 'href' , $slides.eq(current).attr('data-pro-url') );
		generateIndicators();
		exports.resize();
		exports.initTimer();
		
		$sImg.animate({'opacity':1});
	}
	
	
	exports.updateSlider = function( $el ){
		
		if( firstRun ){
			
			this.flipTriangles()
			firstRun = false;
		}else{
			if( !fromResize ){
				this.flipTriangles()
			}
		}
		
		//firstRun ? firstRun = false : if(!fromResize)this.flipTriangles();
		
		try{ 
			$indic.removeClass(classString).eq(current).addClass(classString);
		
		
			var calc = -($ulWidth*current);
		
			$ul.css({marginLeft:calc});
	
		}catch(err){
			
		
		}
	}
	
	
	exports.flipTriangles = function(){
		
		var animTime = 300;
		var isFlipped =  $slides.eq(current).attr('data-flipped');
		
		if(firstRun){
			animTime = 0
		}
		
		if( isFlipped == 'yes' ){
			//anim left
			
			var ll = $(this).attr('data-maxLeft')
			triForce.animate({
				
				opacity:0
				
			},animTime, function(){ 
				triForce.find('h2 a').html( $slides.eq(current).attr('data-copy') );
				triForce.find('h2 a').attr( 'href' , $slides.eq(current).attr('data-pro-url') );
				triForce.addClass('l-flipped').animate({opacity:1},200)
			});
			
		}else{
		
			var rr = $(this).attr('data-maxRight')
			triForce.animate({
				
				opacity:0
				
			},animTime, function(){ 
				triForce.find('h2 a').html( $slides.eq(current).attr('data-copy') );
				triForce.find('h2 a').attr( 'href' , $slides.eq(current).attr('data-pro-url') );
				
				triForce.removeClass('l-flipped').animate({opacity:1},200)
			});
		
		}
		
		
	}
	
	
	// Respond to resize
	exports.resize = function(){
		
		$ulWidth = $win.width();
		$slides.each(function(){ $(this).css({width:$ulWidth}) });
		
		var imgHeight = $slides.eq(0).find('img').height()
		,	moveHeight = imgHeight < 650 ? 0 : (650 - imgHeight)/2;
			
		$ul.css({width:$ulWidth*len});//, marginTop:moveHeight+'px'});
		
		$sImg.css({ marginTop:moveHeight });
		
		//$ulWidth = $main.width();
		//$slides.each(function(){ $(this).css({width:$ulWidth}) });
		//$ul.css({width:$ulWidth*len});
		fromResize = true;
		exports.updateSlider();
		
	}
	
	
	//Setup timer
	exports.initTimer = function() {
		timer = setInterval( function(){
			
			current++;
			if( current > len-1 ) current = 0;
			fromResize = false;
			exports.updateSlider();
			
		} , 7000 );
	}
	
	
		
	return exports;
	
}