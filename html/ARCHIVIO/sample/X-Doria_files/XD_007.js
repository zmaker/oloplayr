var XD = XD || {};

XD.SocialModule = function(){
	
	if( $('.twitter-tab').length > 0 ){
	
	var exports = {};
	
	var	xd			=	XD
	,	config		=	XD.util.getUserConfig()
	,	fbOpen		=	false
	,	twOpen		=	false
	,	animTime	=	150
	,	cur			=	0;
	

	
	
	$(document).bind( config.clickTrigger , function( evt ){
		
		if( isIconClick(evt) ){
			if( fbOpen && cur == 0 ){
				closeTabs();
			}else if( twOpen && cur == 1){
				closeTabs();
			}else{
				openATab();	
			}
		}else{
			closeTabs();
		}
				
	});
	
	
	function closeTabs(){
		$('.twitter-feed').fadeOut(animTime);
		$('.facebook-feed').fadeOut(animTime);
		fbOpen = twOpen = false;
	}
	
	function openATab(){
		if( cur === 0 ){
			$('.twitter-feed').fadeOut(animTime);
			$('.facebook-feed').fadeIn(animTime);
			fbOpen = true;
			twOpen = false;
		}else{
			$('.twitter-feed').fadeIn(animTime);
			$('.facebook-feed').fadeOut(animTime);
			fbOpen = false;
			twOpen = true;
		}
	}

	function isIconClick(evt){
		
		var px		=	evt.pageX
		,	py		=	evt.pageY
		,	tw		=	$('.twitter-tab').offset()
		,	fb		=	$('.facebook-tab').offset()
		, 	minX	=	tw.left
		,	maxX	=	minX+24
		, 	minTY	=	tw.top
		,	maxTY	=	minTY + 24
		,	minFY	=	fb.top
		,	maxFY	=	minFY + 24;
		
		
		if( px > minX && px < maxX && py > minTY && py < maxFY ){
			py < minFY ? cur = 1 : cur = 0;
			return true;
		}
		
		return false;
	}

	
	return exports;
	
	}
	
	
	
}