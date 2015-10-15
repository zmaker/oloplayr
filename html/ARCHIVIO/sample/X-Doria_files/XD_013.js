var XD = XD || {};

XD.Tabs = function( obj ){

	var self 		= 	{}
	
	var tabs = $('dl.tabs');
		tabsContent = $('ul.tabs-content')
	
	tabs.each(function(i) {
		//Get all tabs
		var tab = $(this).children('dd').children('a');
		tab.click(function(e) {
			
			//Get Location of tab's content
			var contentLocation = $(this).attr("href")
			contentLocation = contentLocation + "Tab";
			
			//Let go if not a hashed one
			if(contentLocation.charAt(0)=="#") {
			
				e.preventDefault();
			
				//Make Tab Active
				tab.removeClass('active');
				$(this).addClass('active');
				
				//Show Tab Content
				$(contentLocation).parent('.tabs-content').children('li').css({"display":"none"});
				$(contentLocation).css({"display":"block"});
				
			} 
		});
	});
	
return self;

}