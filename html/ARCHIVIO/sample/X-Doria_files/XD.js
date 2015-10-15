var XD = XD || {};

XD.Colorpicker = function(){
	
	var colorpicker = {};
	
	
	var thumbSrc
	,	pickrItem	=		$('.thumb-color-picker li')
	,	pickr		=		$('.thumb-color-picker')
	,	baseColor	=		$('.p-thumb', this).attr('src');
	
	$(window).bind('load', update);
	pickrItem.bind('click', colorSwitch);
	
	
	function colorSwitch() {
		
		
		var colorData	=	$(this).find('img').attr('data-colpic')
		,   newURL		=	$(this).find('img').attr('data-colpic-url')
		,	pThumb		=	$(this).parents('li').find('.p-thumb');
		
		
		$(this).parents('li').find('a').attr('href' , newURL)
		
		
		pThumb.attr('src', colorData );
		
		$(this).parents('li').find('.thumb-color-picker li').removeClass('active-color');
		$(this).addClass('active-color');
		
		return false;
	}
	
	
	function update() {
		$('.product-thumb').each(function() {
			$('.thumb-color-picker li:first-child').addClass('active-color');	
		})
		
		
	}
	
	
	return colorpicker;
}
