	function MediaClip (id) {
		this.element;
		this.id = id;
		this.titolo = "";
		this.clip = "";
		this.durata = "0"; 
		this.loop = 1;
        this.colore = "#CCCCCC";
        this.audio = "2"; //1 analogico, 2 hdmi
        this.mediaId;

		this.x = 0;
		this.y = 0;

		this.uiElementId;

		this.getInfo = function() {
		    return this.id + ' ' + this.titolo + ' ';
		};
		this.getId = function() {
			return this.id;
		};
		this.getName = function() {
			return 'clip-'+this.id;
		};
		this.getUIElementId = function() {
			return this.uiElementId;
		};
		this.setElement = function(el) {
			this.element = el;
		};
		this.getElement = function() {
			return this.element;
		};
		this.jsp = function(prop) {
			return ' "'+prop+'" : "'+eval('this.'+prop)+'" ';
		}
        this.jsp = function(prop, val) {
			return ' "'+prop+'" : "'+val+'" ';
		}
		this.toJson = function() {
            var subtype = this.clip;
            subtype = subtype.substring(this.clip.lastIndexOf('.')+1);
            var type = "";
            if ($.inArray(subtype, ['mp4']) >= 0) {
                type = 'video';
            } else if ($.inArray(subtype, ['mp3', 'wav']) >= 0) {
                type = 'audio';
            } else if ($.inArray(subtype, ['obj']) >= 0) {
                type = '3d';
            } else if ($.inArray(subtype, ['jpg','jpeg','gif','png']) >= 0) {
                type = 'image';
            }
             
            var mid = this.mediaId;
            if (this.id == 0) mid = 0;
            if (this.id == 999) mid = 0;
            
			var str = '{ ' +
            this.jsp('id', mid) + ', ' + //qui prima c'era l'id 
            this.jsp('name',this.clip) + ', ' +
            this.jsp('type',type) + ', ' +
            this.jsp('subtype',subtype) + ', ' +
            this.jsp('elapsed', this.durata) + ', ' +
            this.jsp('loop', this.loop) + ', ' +
            this.jsp('x', this.x) + ', ' +
            this.jsp('y', this.y) + 
            '}';
			return str;
		}
        
        this.toJsonState = function() {
            var mid = this.mediaId;
            if (this.id == 0) mid = 0;
            if (this.id == 999) mid = 0;
			var str = '{ ' +
            this.jsp('name', 'S'+this.id) + ', ' +
            this.jsp('title', this.titolo) + ', ' +
            '"start_media" : [ "'+mid+'" ], ' +
            '"stop_media" : [], ' +
            '"active_button" : [], ' +
            this.jsp('audio', this.audio) + ', ' +
            this.jsp('colore', this.colore) + ', ' +
            this.jsp('x', this.x) + ', ' +
            this.jsp('y', this.y) + 
            '}';
			return str;
		}
	}
