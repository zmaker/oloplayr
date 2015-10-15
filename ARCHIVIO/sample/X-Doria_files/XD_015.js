var XD = XD || {};

XD.Prodviewer = function( obj ){

	var self 		= 	{}
	
	,	controlWrap	=	$('.view-controls')
	,	controls	=	$('.view-controls li')
	,	contheight	=	controls.outerHeight(true) * controls.length
	,	cur			=	0
	,	len			=	$('.image-wrapper > ul li').length
	,	viewport	=	$('.image-wrapper')
	,	viewer		=	$('.image-wrapper ul')
	,	viewerItem	=	$('.image-wrapper li')
	,	len			=	viewerItem.length
	,	viwidth
	,	cp;
	
	controls.bind('click', swapImg )
	
	$(window).bind('load', function() {
		
		self.update();
		
	})
	
	// Private Methods
	function swapImg(){		
		cur = $(this).index();
		
		if( Modernizr.csstransitions ){
			
			viewer.css({
				'marginLeft': (-viwidth*cur) + cp
			});
			
			
			viewerItem.eq(cur).css({'opacity':1})
			viewerItem.eq(cur-1).css({'opacity':0.3})	
			viewerItem.eq(cur+1).css({'opacity':0.3})	
			
		}else if( !Modernizr.csstransitions ){
			
			viewer.stop().animate({
				'marginLeft': (-viwidth*cur) + cp
			}, 250);
			
			viewerItem.eq(cur).stop().animate({'opacity':1}, 200)
			viewerItem.eq(cur-1).stop().animate({'opacity':0.3}, 200)	
			viewerItem.eq(cur+1).stop().animate({'opacity':0.3}, 200)	
		
		}
		
		controls.removeClass('current-indic');
		$(this).addClass('current-indic');
		
	}
	
	function getId(){
		
		var url = $(location).attr('href');
		
		var uri = url.split('/', 8);
		var last = uri[uri.length - 1];
		last = last.replace('#','');
		
		if(uri[uri.length - 2] == 'products'){
			
			last = $('#color-chooser').find('img').attr('data-variant-sku');
		}
		
		return(last);
	
	}
		
	//Public Methods Exposed
	self.update = function(){
		
		
		var id = getId();
		var imgData;
		//alert(id);
		
		
		// LOOP THROUGH IMAGES CONTROLS
		$(controls).each(function(index) {
    		//alert(index + ': ' + $(this).text());
    		imgData = $(this).find('img').attr('data-alt-data');
    		
    		if(imgData){ 
    			if(imgData.indexOf(id, 0) > 0 || imgData.indexOf('all', 0) > 0){
    				$(this).find('img').css({'display':'block'});
    			}else{
    				$(this).remove();
    			}
    		}
    		
    		
		});
		
		// LOOP THROUGH IMAGES
		$(viewerItem).each(function(index) {
    		//alert(index + ': ' + $(this).text());
    		imgData = $(this).find('img').attr('data-alt-data');
    		
    		if(imgData){ 
    		
    		if(imgData.indexOf(id, 0) > 0 || imgData.indexOf('all', 0) > 0 ){
    			$(this).find('img').css({'display':'block'});
    		}else{
    			$(this).remove();
    		}
    		
    		}
    		
    		
		});
		
		var hasSpin = 'false';
		
		if($('#product-extra')){
			
			var hasSpin = $('#product-extra').attr('data-has-spin');
			var spinID = $('#product-extra').attr('data-spin-id');
			
			$('#spin-frame-content').attr('src','http://x-doria.com/spins/'+spinID+'/index.html');
			
		}
		
		if(!hasSpin){
			$('#spin-frame').remove();
			$('#spin-control').remove();
		}
		
		
		len = viewerItem.length;
		viewerItem	=	$('.image-wrapper li');
		controls = $('.view-controls li');
		cur = 0;
		
		viwidth		=	510 + 300;//viewerItem.eq(0).width(); imgsize + spacing
		
		cp			=	((viewport.width()/2) - viwidth/2);// + 15;
		
		controls.eq(0).addClass('current-indic');
		viewerItem.eq(cur).css({'opacity':1})
		contheight = controls.outerHeight(true) * controls.length;

		controls.eq(cur).addClass('current-indic');
		viewerItem.eq(cur).css({'opacity':1})

		controlWrap.css({
			'height': contheight,
			'marginTop': -contheight/2
		})
		

		viewer.css({
			'width': (viwidth*len)+'px',
			'marginLeft': cp,
			'opacity':1
		});
	}
	
	
	
return self;

}