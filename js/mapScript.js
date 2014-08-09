var loc = [];
function generateMap(latlong) {		
	loc = latlong.split(":");
		if(markers.length > 0) {
			jQuery(function($) {
			    // Asynchronously Load the map API 
			    var script = document.createElement('script');
			    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
			    document.body.appendChild(script);
			});
		}
	}
	
	// function to calculate distance between two points
	function getDistance(lat1, lon1, lat2, lon2){		
	    var R = 6371; // km
		var dLat = (lat2-lat1) * (Math.PI / 180);
		var dLon = (lon2-lon1) * (Math.PI / 180);
		var lat1 = lat1 * (Math.PI / 180);
		var lat2 = lat2 * (Math.PI / 180);
		
		var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
		        Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
		var d = (R * c*0.62137).toFixed(3);
		return d;
	}	
	
	function initialize() {
	    var map;
	    var bounds = new google.maps.LatLngBounds();
	    var mapOptions = {
	        mapTypeId: 'roadmap'
	    };
	                    
	    // Display a map on the page
	    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	    map.setTilt(45);	    	    
	                        
	    // Info Window Content
	    var infoWindowContent = [];
	    var len = markers.length;
	    
	    //generate info window content by looping through data to display name and address
	    for( i = 0; i < markers.length-1; i++ ) {
		    var tmp = markers[i].split(";");
		    var location = tmp[0];
		    var addr = tmp[3];		    
	    	var dist = getDistance(37.765106476986, -122.389679487281,tmp[1],tmp[2]);
		    var ele = '<div class="info_content">' + "<h3>" + location + "</h3>" + "<p>" + addr + "</p>" + "<h4>" + dist + " miles away</h4>" + "</div>";
	    	infoWindowContent[i] = ele;
    	}
    	var tmp = markers[len-1].split(";");
	    var dist = getDistance(37.765106476986, -122.389679487281,tmp[1],tmp[2]);
	    infoWindowContent[i] = '<div class="info_content">' + "<h3>" + tmp[0] + "</h3>" + "<p>" + tmp[3] + "</p>" + "<h4>" + dist + " miles away</h4>" + "</div>";
	    
	    // Display multiple markers on a map
	    var infoWindow = new google.maps.InfoWindow(), marker, i;
	    
	    // Loop through our array of markers & place each one on the map  
	    for( i = 0; i < markers.length; i++ ) {
		    var tmp = markers[i].split(";");
	        var position = new google.maps.LatLng(tmp[1], tmp[2]);
	        bounds.extend(position);
	        marker = new google.maps.Marker({
	            position: position,
	            map: map,
	            title: tmp[0]
	        });
	        
	        // Allow each marker to have an info window    
	        google.maps.event.addListener(marker, 'click', (function(marker, i) {
	            return function() {
	                infoWindow.setContent(infoWindowContent[i]);
	                infoWindow.open(map, marker);
	            }
	        })(marker, i));
	
	        // Automatically center the map fitting all markers on the screen
	        map.fitBounds(bounds);
	    }
	
	    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
	    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
	        this.setZoom(15);
	        google.maps.event.removeListener(boundsListener);
	    });
	    
	}
