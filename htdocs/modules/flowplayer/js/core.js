// JavaScript Document

function flowplayerdisplayplayer(data){
	$.each(data, function(i, n){
		switch(i){
		case 'innerhtml':
			$.each(n, function(y, k){
			  var tmp = document.getElementById(y);
			  if (tmp)
			  	tmp.innerHTML = k;
			  var tmp = false;
			});
			break;
		case 'disable':
			$.each(n, function(y, k){
				switch(k){
				case '':
				case 'false':
				  var tmp = document.getElementById(y);
				  if (tmp)
				  	tmp.disabled = false;
				  var tmp = '';
				  break;
				default:
				  var tmp = document.getElementById(y);
				  if (tmp)
				  	tmp.disabled = true;
				  var tmp = '';
				  break;
				}
			});
			break;			
		case 'checked':
			$.each(n, function(y, k){
				switch(k){
				case 'false':
				  var tmp = document.getElementById(y);
				  if (tmp) 
				  	tmp.checked  = false;
				  var tmp ='';
				  break;
				default:
				  var tmp = document.getElementById(y);
				  if (tmp) 
				  	tmp.checked  = true;
				  var tmp ='';
				  break;
				}
			});
			break;						
		case 'index':
			$.each(n, function(y, k){
				  var tmp = document.getElementById(y)
				  if (tmp) 
				  	tmp.selectedIndex  = false;
				  var tmp ='';
			});
			break;						
		case 'flowplayerfile':
			$.each(n, function(y, k){
				flowplayer(y, {src: k[0], wmode: 'opaque', width: k[20], height: k[21]}, {
	                clip: {
	                    url: k[3],
	            	    autoPlay: k[1],
	            	    onBegin: function () {
	            	        this.setVolume(k[2]);
	            	    }
	                },
	                plugins: {
	                	controls: {
	                        url: k[5], 
	                        play:k[6],
		                	volume:k[7],
		                	mute:k[8],
		                	time:k[9],
		                	stop:k[10],
		                	playlist:false,
		                	fullscreen:k[11],
		                 	scrubber: k[12]
		                }
	                }
	            });
			});
			break;
		case 'videojsfile':
		case 'videojsstream':
			$.each(n, function(y, k){
				var myPlayer = VideoJS.setup(y, {
					controlsBelow: true, // Display control bar below video instead of in front of
					controlsHiding: k[0], // Hide controls when mouse is not over the video
					defaultVolume: k[1], // Will be overridden by user's last volume if available
					flashVersion: 9, // Required flash version for fallback
					linksHiding: true // Hide download links when video is supported
				});
				if (k[2])
					myPlayer.play();
			});
			break;
		case 'flowplayerrtmp':
			$.each(n, function(y, k){
				flowplayer(y, {src: k[0], wmode: 'opaque', width: k[20], height: k[21]}, {
	                clip: {
	                    url: k[3],
	                    provider: 'rtmp',
	            	    autoPlay: k[1],
	            	    onBegin: function () {
	            	        this.setVolume(k[2]);
	            	    }
	                },
	                plugins: {
	                	controls: {
	                        url: k[5], 
	                        play:k[6],
		                	volume:k[7],
		                	mute:k[8],
		                	time:k[9],
		                	stop:k[10],
		                	playlist:false,
		                	fullscreen:k[11],
		                 	scrubber: k[12]
		                },
	                	rtmp: {
	                		url: k[13],
	                		netConnectionUrl: k[4]
	                	}
	                }
	            });
			});
			break;				
		case 'otherfile':
			$.each(n, function(y, k){
			});
			break;						
		case 'otherstream':
			$.each(n, function(y, k){
			});
			break;				

		}
	});
}

function setvalue(data){
	$.each(data, function(i, n){
		switch(i){
		default:
		case 'val':
			$.each(n, function(y, k){
			  $("#"+y).val(k);
			});
			break;		
		case 'text':
			$.each(n, function(y, k){
			  $("#"+y).text(k);
			});
			break;		
		case 'html':
			$.each(n, function(y, k){
			  $("#"+y).html(k);
			});
			break;		
		}
	});
}
