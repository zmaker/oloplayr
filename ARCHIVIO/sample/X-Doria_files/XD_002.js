var XD = XD || {};

XD.Menu = function(){
	
	var menu = {};
	
	
	var	$dropdown
	,	$droplink	=			$('.dd-link')
	,	ddVis		=			false
	,	dur			=			200;
	
	$droplink.hover(openMenu, closeMenu);
	
	function openMenu() {
		$dropdown	=	$(this).find('.dd-menu');
		
		if(ddVis === false){
		
			$dropdown
				.stop()
				.show()
				.animate({
					'top': '100%',
					'opacity': 1
				}, dur*.8);
			
			ddVis = true;
		}
		
	}
	
	function closeMenu() {
		if(ddVis === true){
			
			$dropdown
				.stop()
				.animate({
					'top': '50%',
					'opacity': 0
				}, dur*.8,function() {
					$(this).hide();
				});
			
			ddVis = false;
		}
		
	}
	
	
	
	return menu;
}

