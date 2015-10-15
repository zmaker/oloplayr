var XD = XD || {};

XD.Modal = function(){
	
	var modal = {};
	
	
	var	$win 		=	$(window)
	,	$modal		=	$('.modal-wrap')
	,	$close		=	$('.modal-close')
	,	$activate	=	$('.shopping-from a');
	
	
	$activate.on('click', initModal)
	$close.on('click', killModal)
	$('.modal-overlay').live('click', killModal)
	
	function initModal(){
		$modal.fadeIn(150);
		$('<div class="modal-overlay"></div>').prependTo('#page').fadeTo(200, 1);
		
		console.log($('.modal-overlay'));
		
		return false;
	};
	
	function killModal(){
		$modal.fadeOut(200);
		$('.modal-overlay').fadeOut(200, function() {
			$(this).remove();
		});
		
	};
	
	return modal;
};

