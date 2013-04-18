//webservices para listar los seguros

$.getJSON( 'http://restfultakecare.uphero.com/index.php/rest/get_seguros' , {format: "json"}, function(data)  { 					
					
					$.each(data, function(t, item) {
    								
           			var VL_opcion1 = document.createElement("option");
       				VL_opcion1.setAttribute("value", data[t].ID_seguro);
        			VL_opcion1.innerHTML = data[t].Nombre;
        			document.getElementById('nombre_seguro').appendChild(VL_opcion1);
					
  
	});
        });
