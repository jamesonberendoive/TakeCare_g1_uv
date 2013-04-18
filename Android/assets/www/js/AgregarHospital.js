//webservices para agregar los hospitales y decir quien esta mas cerca
function leerGET(){ 
  var cadGET = location.search.substr(1,location.search.length); 
  var arrGET = cadGET.split("$"); 
  var variable = ""; 
  for(i=1;i<arrGET.length;i++){ 
    var aux = arrGET[i].split("$"); 
    variable = aux[0];
	} 
  return variable; 
} 

  /*if(navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
			  var pos = new google.maps.LatLng(position.coords.latitude,
                                             position.coords.longitude);
		alert("Dimas");
		var lat1 = position.coords.latitude;
		var lon1 = position.coords.longitude;
		alert(position.coords.latitude);
		 });
		}
		
		 else
	{var lat1 = 18.450033;
	var lon1 = -69.957431;
     		};*/
	 
	 
	 //lat1 = pos.coords.latitude;
	// lon1 = pos.coords.longitude;
	
	
			
		$.getJSON("http://restfultakecare.uphero.com/index.php/rest/get_seguroHospital/" + leerGET(), {format: "json"}, function(data) {
       
		var distancia = 0;
        var id;
        var t = 0;
        $.each(data, function(i, item) {
            var myLatlng = new google.maps.LatLng(data[t].Geolocalizacion_x, data[t].Geolocalizacion_y);
            var mapOptions = {
                zoom: 4,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
			
			// variables que llevan la latitud y longitud de nuestra posicion

            // funcion para calcular quien esta mas cerca (calculado en km) y obtengo el valor del id de ese hospital
            var R = 6371; // km
            var dLat = toRad(data[t].Geolocalizacion_x - lat1);
            var dLon = toRad(data[t].Geolocalizacion_y - lon1);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(toRad(lat1)) * Math.cos(toRad(data[t].Geolocalizacion_y)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            if ((distancia == 0) || (distancia > (R * c)))
            {
                distancia = (R * c);
                id = t;
            }

            //var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
            var marker = new google.maps.Marker({
                position: myLatlng,
                animation: google.maps.Animation.DROP,
                icon: "js/images/hospital.png",
                map: map,
                title: data[t].Hospital
            }
            );
         //   var row2 = results.rows.item(id);
            var start = new google.maps.LatLng(lat1, lon1);
            var end = new google.maps.LatLng(data[t].Geolocalizacion_x, data[t].Geolocalizacion_y);
            var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                }
            });

            function toRad(Value) {
                /** Converts numeric degrees to radians */
                return Value * Math.PI / 180;
            }
            ;

            //document.getElementById('nombre_seguro').appendChild(VL_opcion1);

            t++

        });
    });
