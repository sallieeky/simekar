<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
      #map {
        height: 100%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>

  </head>
  <body>
      
    <div class="form-group">
      <label>Location:</label>
      <input type="text" class="form-control" id="search_input" style="width:300px"/>
      <input type="hidden" id="latitude_inp"/>
      <input type="hidden" id="longitude_inp"/>
	  
	  <input type="hidden" id="distance"/>
	  <input type="hidden" id="duration"/>
	  <input type="hidden" id="durationval"/>
	  
	  <input type="hidden" id="empid" value="DO174714"/>
      <input type="hidden" id="costcenter_new" value="00180000000000"/>
      <input type="hidden" id="costcenter_name_new" value="Kantor Cabang Kalimantan Timur"/>
    </div>
	
    <p id="dataTemp"></p>
    <button id="check">Get Distance</button>
	<button id="Done" onclick="ProcesMap();">Done </button>
    <div id="map"></div>

    <script>
      //const center = {lat: -6.283948, lng: 106.725908};
      const center = {lat: -1.273819, lng:  116.873741};
      var des = {lat: -6.272694, lng: 106.726010};
      var map;
      var searchInput= "";

      function autoMaps(){
        document.getElementById('latitude_inp').value = '';
        document.getElementById('longitude_inp').value = '';
        console.log('')
      }


      function initMap() {
        
        var dService = new google.maps.DirectionsService;
        var dDisplay = new google.maps.DirectionsRenderer;
        var geocoder = new google.maps.Geocoder();
        
        map = new google.maps.Map(document.getElementById('map'), {
           zoom: 15,
          center: center
        });
        dDisplay.setMap(map);
        
        var marker = new google.maps.Marker({
        position: center,
        map: map,
        draggable:true,
        title:"Destination"
        });
        
        marker.setMap(map);
        
        google.maps.event.addListener(marker, 'dragend', function() 
        {
            var newlat = marker.getPosition().lat();
            var newlng = marker.getPosition().lng();
            des = {lat: newlat, lng:newlng };
            geocoder.geocode({'location': des}, function(results, status) {
              if (status === 'OK') {
                if (results[0]) {
                  document.getElementById('search_input').value = results[0].formatted_address;
                  document.getElementById('latitude_inp').value = newlat;
                  document.getElementById('longitude_inp').value = newlng;
                  document.getElementById('distance').value = '';
                } else {
                  window.alert('No results found');
                }
              } else {
                window.alert('Geocoder failed due to: ' + status);
              }
            });
        });
        
        var autoComplete = new google.maps.places.Autocomplete((document.getElementById('search_input')),
        {types: []}
        );
        autoComplete.setComponentRestrictions(
            {'country': ['id']});
        google.maps.event.addListener(autoComplete, 'place_changed', function(){
          var near_place = autoComplete.getPlace();
          document.getElementById('latitude_inp').value = near_place.geometry.location.lat();
          document.getElementById('longitude_inp').value = near_place.geometry.location.lng();
          document.getElementById('distance').value = '';
          marker.setVisible(false);
          if (near_place.geometry.viewport) {
            map.fitBounds(near_place.geometry.viewport);
          } else {
            map.setCenter(near_place.geometry.location);
            map.setZoom(17); 
          };
          marker.setPosition(near_place.geometry.location);
          marker.setVisible(true);

          des = {lat: near_place.geometry.location.lat(), lng:near_place.geometry.location.lng() }
        })
       
        var onChangeHandler = function(){
            DisplayRoute(dService, dDisplay);
        };
         document.getElementById('check').addEventListener('click', onChangeHandler);
      }
      function DisplayRoute(x,y){
          x.route({
              origin: center,
              destination: des,
              travelMode: 'DRIVING'
          }, function(response, status){
              if(status === 'OK'){
                  y.setDirections(response);
                  console.log(response.routes[0].legs[0].distance.text);
                document.getElementById('dataTemp').innerHTML = 'DISTANCE: '+ parseInt(response.routes[0].legs[0].distance.value)/1000 + ' KM<br/>DURATION: '+ response.routes[0].legs[0].duration.text;
				
				document.getElementById('distance').value = response.routes[0].legs[0].distance.value;
				document.getElementById('duration').value = response.routes[0].legs[0].duration.text;
				document.getElementById('durationval').value = response.routes[0].legs[0].duration.minutes;
              }else{
                  windows.alert('Nope');
              }
          });
		  
		  
      }
	  
	function secondsToHms(d) {
		d = Number(d);
		var h = Math.floor(d / 3600);
		var m = Math.floor(d % 3600 / 60);
		var s = Math.floor(d % 3600 % 60);

		var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
		var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
		var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
		return hDisplay + mDisplay + sDisplay; 
	}
	  
	  function ProcesMap(){
		/*
		alert("aaa");
		var empid = document.getElementById('empid').value;
		alert("456");
		getAJAXContent("?ofid=CL_SPPD.LSMaps&amp;empid="+empid,'spAjax');
		this.close();*/
		if(document.getElementById('distance').value.length == 0)
		{
		    alert("Please Click Get Distance First");
		    return false;
		}
		opener.getDistance(document.getElementById('distance').value,document.getElementById('search_input').value,document.getElementById('costcenter_new').value,document.getElementById('costcenter_name_new').value);
		window.close();
	  }
    </script>
 
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAhTc3UDPSZeKoxGUDYPuoyhud69LB-co&libraries=places&callback=initMap">
    </script>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>