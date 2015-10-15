	function Link (src, dest) {
		this.src = src;
		this.dest = dest;	
		this.toRemove = 0;
		this.oid = -1;
        this.did = -1;
        this.sx = 0;
        this.sy = 0;
        this.dx = 0;
        this.dy = 0;
        
        
		this.getLine = function() {			
			this.sx = src.offset().left + src.width() + 5 - parentOffset.left;
            this.sy = src.offset().top - parentOffset.top;
			this.dx = dest.offset().left - parentOffset.left;
			this.dy = dest.offset().top - parentOffset.top;
			var str = "M"+this.sx+","+this.sy+" L"+this.dx+","+this.dy;	
		    this.line = str;
			return this.line;
		};	
        
        this.toJson = function() {	
            var sini = this.oid;
            var send = this.did;
            
            var str = '{ "event":"end", '+
            '"fromState":"S'+sini+'", ' + 
            '"toState":"S'+send+'", '+
            this.jsp('sx', this.sx) + ', ' +
            this.jsp('sy', this.sy) + ', ' +
            this.jsp('dx', this.dx) + ', ' +
            this.jsp('dy', this.dy) + ' }';
            return str;
		};
        
        this.jsp = function(prop) {
			return ' "'+prop+'" : "'+eval('this.'+prop)+'" ';
		}
        this.jsp = function(prop, val) {
			return ' "'+prop+'" : "'+val+'" ';
		}
        
		this.getSource = function() {	
			return this.src;
		};
		this.getDestination = function() {	
			return this.dest;
		};
		this.setToRemove = function() {	
			this.toRemove = 1;
		};
		this.getToRemove = function() {	
			return this.toRemove;
		};
        this.setOriginId = function(id){
            this.oid = id;
        };
        this.setDestinationId = function(id){
            this.did = id;
        };
        this.getSX = function() {
            return this.sx;
        };
        this.getSY = function() {            
            return this.sy;
        };
        this.getDX = function() {            
            return this.dx;
        };
        this.getDY = function() {            
            return this.dy;
        };
        
	}
