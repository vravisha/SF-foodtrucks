function getLocation() {
		if (navigator.geolocation) {
		        navigator.geolocation.getCurrentPosition(showPosition);	
		        x.innerHTML = latlon[0];	        
		    } else {
		        x.innerHTML = "Geolocation is not supported by this browser.";
		}			
	}
		    		
	function showPosition(position) {	    
		lat = position.coords.latitude;
	    lon = position.coords.longitude;
	    var loc = lat + ":" + lon;
	    generateMap(loc); 
	}
	
