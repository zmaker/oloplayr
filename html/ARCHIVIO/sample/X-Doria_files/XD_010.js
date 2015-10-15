var XD = XD || {};

XD.Colorchooser = function(){
	
	var colorchooser = {};
	var oldImg = null;
	var oldSrc = null;
	var oldId = null;
	var oldMargin;
	
	var variantItem	=		$('#color-chooser li')
	
	$(window).bind('load', update);
	
	//variantItem.bind('click', colorSwitch);
	//variantItem.bind('mouseover',showImage);
	//variantItem.bind('mouseout',hideImage);
	//variantItem.bind('load',update);
	
	function colorSwitch() {
		
		var variantId = $(this).find('img').attr('data-variant-id');
		
		$('#color-chooser li img').removeClass('selected');
		$(this).find('img').addClass('selected');
		//alert(variantId);
		
		$('#variant-id').val(variantId);
		
		
		/*
		var colorData	=	$(this).find('img').attr('data-colpic')
		,   newURL		=	$(this).find('img').attr('data-colpic-url')
		,	pThumb		=	$(this).parents('li').find('.p-thumb');
		
		
		$(this).parents('li').find('a').attr('href' , newURL)
		
		
		pThumb.attr('src', colorData );
		
		$(this).parents('li').find('.thumb-color-picker li').removeClass('active-color');
		$(this).addClass('active-color');
		*/
		return false;
	}
	
	
	function update() {
		
		var url = $(location).attr('href');
		
		var uri = url.split('/', 8);
		var last = uri[uri.length - 1];
		last = last.replace('#','');
		
		var variantId = $('#color-'+last).attr('data-variant-id');
		var variantStock = $('#color-'+last).attr('data-variant-stock');
		
		$('#variant-id').val(variantId);
		$('#variant-stock').val(variantStock);
		$('#color-'+last).addClass('selected');
		
		//alert()
		
		$(variantItem).each(function(index) {
    		//alert(index + ': ' + $(this).text());
    		
    		stock = $(this).find('img').attr('data-variant-stock');
    		if(stock == '0'){
    			//alert('out of stock');
    			$(this).css({'opacity':.5});
    		}
    		
    	});
		
	}
	
	function showImage(){
		
		
		
		//alert(oldMargin+':'+newMargin);
		
		var newImg = $(this).find('img').attr('data-img-src');
		
		if(newImg){ 
		
			oldImg = $('.view-controls').find('.current-indic'); // OLD IMAGE 
			oldSrc = $(oldImg).find('img').attr('src'); // GET SRC OF OLD IMAGE 
			oldId = oldImg.find('img').attr('data-index'); // GET THE IMAGE ID SO WE KNOW WHICH ONE TO CHANG IN THE SLIDER
		
				
			$('#img-'+oldId).attr('src',newImg); // SET SRC OF IMAGE
			//$('#img-'+oldId).attr('style','padding-left:150px');
		
		}
		
		
	}
	
	function hideImage(){
		
		if(oldImg){ 
			$('#img-'+oldId).attr('src',oldSrc); // SET SRC OF IMAGE BACK TO THE OLD SRC
			//$('#img-'+oldId).attr('style','padding-left:0px');
			oldImg = null;
			oldSrc = null;
			oldId = null;
		}
		
		
	}
	
	
	return colorchooser;
}
