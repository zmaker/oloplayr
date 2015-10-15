var XD = XD ||{};


$(function() {
	
	XD.util				=	new XD.Util();
	
	XD.carousel			=	new XD.Carousel();
	XD.prodviewer		=	new XD.Prodviewer();
	XD.tabs				=	new XD.Tabs();
	XD.scrollManager	= 	new XD.ScrollManager();
	XD.menu				= 	new XD.Menu();
	XD.socialModule		= 	new XD.SocialModule();
	XD.tooltips			= 	new XD.Tooltips();
	XD.colorpicker		= 	new XD.Colorpicker();
	XD.overlay			= 	new XD.Overlay();
	XD.scrollto			= 	new XD.Scrollto();
	XD.modal			= 	new XD.Modal();
	XD.Normalizr		= 	new XD.Normalizr();
	XD.colorchooser 	= 	new XD.Colorchooser();
	
	
	// Only if on correct page
	XD.scrollto.init();
	
	  $(window).load(function() {
    setTimeout(function() {
      XD.scrollManager.init()
    },167);
  });
	
	
});
