//webservices para listar los seguros
function leerGET(){ 
  var cadGET = location.search.substr(1,location.search.length); 
  var arrGET = cadGET.split("$"); 
  var variable = ""; 
  for(i=1;i<arrGET.length;i++){ 
    var aux = arrGET[i].split("$"); 
    variable = aux[0];
	} 
	
	for(i=1;i<variable.length;i++){
	variable = variable.replace ("%20", " ");
	}
  
  return variable; 
};

function mandar_id(P_ID){
                window.location = "mapHospital.html?hospital$" + P_ID;
            }

var url = "http://restfultakecare.uphero.com/index.php/rest/get_HospitalLike/" + leerGET()
	$.getJSON( url  , {format: "json"}, function(data) { 
	$.each(data, function(t, item) {
		document.getElementById("ListaDoctor").innerHTML = document.getElementById("ListaDoctor").innerHTML + ' <b>Dr. ' + data[t].Nombre + ' </b>' + '-' + data[t].Descripcion + " " + '<a style = "color:blue;" Onclick = "mandar_id(' + data[t].ID_hospital + ')"><u>Como llegar </a></b></u><br />' + "\n";	
		});
		
		
		});
		  
		
