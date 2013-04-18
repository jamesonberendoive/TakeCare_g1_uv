<?php

header('Access-Control-Allow-Origin: *');
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class rest extends CI_Controller {

    /**
     * Class Constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @link /rest/get_doctor/$ID
     * @access public
     * @return void
     */
public function get_HospitalLike($id = " ") {

        $SQL = "SELECT * FROM dbo_t_hospital	
                        WHERE Nombre LIKE '%" . $id . "%'";

        $result = array(
            'success' => false,
            'data' => null
        );

        if (!$id || !is_string($id)) {
            $this->json_output($result);

            return;
        }

        // Query, this is only example and doesn't work
        //$SQL = "SELECT * FROM my_table_here WHERE id = " . $id;
        //$SQL = "SELECT * FROM `db_t_doctor` where `ID_doctor`= " . $id;

        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            echo 'Query vacio';
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }
//
    public function get_doctorHospital($id = null) {

        $SQL = 'SELECT * FROM v_doctor_hospitales	
                        WHERE     (ID_doctor =' . $id . ')
    			ORDER BY hospital';

        $result = array(
            'success' => false,
            'data' => null
        );

        if (!$id || !is_numeric($id)) {
            $this->json_output($result);

            return;
        }

        // Query, this is only example and doesn't work
        //$SQL = "SELECT * FROM my_table_here WHERE id = " . $id;
        //$SQL = "SELECT * FROM `db_t_doctor` where `ID_doctor`= " . $id;

        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            echo 'Query vacio';
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

    //-------------------------------------------------------------------------------------------
	//Manejo de informacion de doctores
    //-------------------------------------------------------------------------------------------

     public function get_doctor($id = null) {
    	 
    	$SQL = "SELECT * FROM `dbo_t_doctor` where `ID_doctor`= " . $id;
    	$result = array(
    			'success' => false,
    			'data' => null
    	);
    
    	if(!$id || !is_numeric($id)) {
    		//$this->json_output($result);
    		$SQL = "SELECT * FROM `dbo_t_doctor`";
    		//return;
    	}
    
    //if statement start
    /*, dbo_t_especialidad.nombre */
    	
    if (!is_numeric($id) && is_string($id))
        {	
        		
        		
        	/* $SQL="SELECT     dbo_t_doctor.ID_doctor, dbo_t_doctor.nombre, dbo_t_doctor.apellido  
    			  FROM         dbo_t_doctor
    			  INNER JOIN
                      dbo_t_doctor_especialidad ON dbo_t_doctor.ID_doctor = dbo_t_doctor_especialidad.ID_doctor
    			  INNER JOIN
                      		dbo_t_especialidad ON dbo_t_doctor_especialidad.ID_especialidad = dbo_t_especialidad.ID_especialidad
				  WHERE dbo_t_doctor.nombre LIKE  '%".$id."%' OR dbo_t_doctor.apellido LIKE  '%".$id."%' ORDER BY  dbo_t_especialidad.nombre";
        	 */	
        		//cambiado aqui
        		$SQL="SELECT ID_doctor, Nombre, Apellido, Descripcion FROM dbo_t_doctor WHERE Nombre LIKE  '%".$id."%' OR Apellido LIKE  '%".$id."%' ORDER BY  Apellido";
        		
        	        		        			
        			$query = $this->db->query($SQL);
        			
        			if (is_array($query)){
        				foreach ($query as $row) {
        					if(($queryResult->num_rows() == 0)&& ($queryCount<count($query))) {
        						$this->json_output($result);
        						return;
        					}
        				}
        			}
        			 
        			elseif(!$query) {
        				$this->json_output($result);
        				return; }
        				else
        					$result['data'] = $query->result();
        				 
        				 
        				// record found
        				foreach ($result as $resultrow){
        					$this->json_output($resultrow);
        				}

        						
        }
    	
    //if statement end
    		
    	$query = $this->db->query($SQL);
    
    
    	if($query->num_rows() == 0) {
    		$this->json_output($result);
    		return;
    	}
    	else if (is_array($query))
    	{
    		$result = array();
    		foreach ($query as $row)
    			$result['data'] = $row['name'];
    	}
    	else
    		$result['data'] = $query->result();
    
    
    	// record found
    	foreach ($result as $resultrow){
    		$this->json_output($resultrow);
    		
    	}
    
    
    
    }
    
	
	public function get_doctorInfo($id = null){

		$SQL="SELECT dbo_t_doctor.ID_doctor, dbo_t_doctor.Nombre, dbo_t_doctor.Apellido, dbo_t_doctor.descripcion AS Detalles, dbo_t_consultorio.Numero, dbo_t_consultorio.Piso, dbo_t_horario_disponible.horario, dbo_t_hospital.Nombre AS hospital,dbo_t_hospital.descripcion, dbo_t_hospital.Geolocalizacion_x,dbo_t_hospital.Geolocalizacion_y, 
					 dbo_t_doctor_consultorio.ID_consultorio, dbo_t_doctor_consultorio.ID_horario, dbo_t_doctor_consultorio.ID_hospital
			  FROM   dbo_t_doctor 
			  INNER JOIN
					 dbo_t_doctor_consultorio ON dbo_t_doctor.ID_doctor = dbo_t_doctor_consultorio.ID_doctor INNER JOIN
					 dbo_t_consultorio ON dbo_t_doctor_consultorio.ID_consultorio = dbo_t_consultorio.ID_consultorio INNER JOIN 
					 dbo_t_horario_disponible ON dbo_t_doctor_consultorio.ID_horario = dbo_t_horario_disponible.ID_horario INNER JOIN
					 dbo_t_hospital ON dbo_t_doctor_consultorio.ID_hospital = dbo_t_hospital.ID_hospital
			  WHERE dbo_t_doctor.ID_doctor = ".$id;
	
		$result = array(
            'success' => false,
            'data' => null
        );

        if (!$id || !is_numeric($id)) {
            $this->json_output($result);

            return;
        }

        
        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
	
	}

    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------


    public function get_seguroHospital($id = null) {

        $SQL = 'SELECT     dbo_t_seguros.ID_seguro, dbo_t_hospital.ID_hospital, dbo_t_hospital.Nombre AS Hospital, dbo_t_hospital.Direccion, dbo_t_hospital.Descripcion ,  dbo_t_hospital.Geolocalizacion_x, dbo_t_hospital.Geolocalizacion_y
    			FROM       dbo_t_seguros
    			INNER JOIN dbo_t_seguro_acepta ON dbo_t_seguros.ID_seguro = dbo_t_seguro_acepta.ID_seguro 
    			INNER JOIN dbo_t_hospital ON dbo_t_seguro_acepta.ID_hospital = dbo_t_hospital.ID_hospital
    			WHERE     (dbo_t_seguros.ID_seguro =' . $id . ')
    			ORDER BY dbo_t_seguros.Nombre';

        $result = array(
            'success' => false,
            'data' => null
        );

        if (!$id || !is_numeric($id)) {
            $this->json_output($result);

            return;
        }

        // Query, this is only example and doesn't work
        //$SQL = "SELECT * FROM my_table_here WHERE id = " . $id;
        //$SQL = "SELECT * FROM `db_t_doctor` where `ID_doctor`= " . $id;

        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            echo 'Query vacio';
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------


    public function get_hospitalInfo($id = null) {

        $SQL = "SELECT  *  FROM dbo_t_hospital where `ID_hospital`= " . $id;
        $result = array(
            'success' => false,
            'data' => null
        );

        if (!$id || !is_numeric($id)) {
            //$this->json_output($result);
            $SQL = "SELECT * FROM `dbo_t_hospital`";
            //return;
        }

        //if statement start


        if (!is_numeric($id) && is_string($id)) {

            $SQL = "SELECT ID_hospital, nombre,Geolocalizacion_x, Geolocalizacion_y FROM dbo_t_hospital WHERE Nombre LIKE  '%" . $id . "%'  ORDER BY  nombre";


            $query = $this->db->query($SQL);

            if (is_array($query)) {
                foreach ($query as $row) {
                    if (($queryResult->num_rows() == 0) && ($queryCount < count($query))) {
                        $this->json_output($result);
                        return;
                    }
                }
            } elseif (!$query) {
                $this->json_output($result);
                return;
            }
            else
                $result['data'] = $query->result();


            // record found
            foreach ($result as $resultrow) {
                $this->json_output($resultrow);
            }
        }

        //if statement end

        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    /**
     * Set JSON headers and echo results
     * @param type $result
     */
    private function json_output($result) {
        //set_json_headers();
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
        //$this->output->set_output(json_encode($result));   
    }

//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
//Lista un(o los) Hospital(es) y los seguros que accepta(n) 
    public function get_hospseguros($id = null) {

        $SQL = "SELECT     dbo_t_hospital.ID_hospital, dbo_t_hospital.Nombre, dbo_t_seguros.ID_seguro, dbo_t_seguros.Nombre
				FROM       dbo_t_hospital 
    			INNER JOIN dbo_t_seguro_acepta ON dbo_t_hospital.ID_hospital = dbo_t_seguro_acepta.ID_hospital 
    			INNER JOIN dbo_t_seguros ON dbo_t_seguro_acepta.ID_seguro = dbo_t_seguros.ID_seguro WHERE dbo_t_hospital.ID_hospital = " . $id;
        $result = array(
            'success' => false,
            'data' => null
        );

        /* Si no se especifica nigun valor se delvolvera todos los hospitales registrados con 
         * con los respectivos seguro que acceptan
         * @param: id del hospital
         * */

        if (!$id || !is_numeric($id)) {
            //$this->json_output($result);
            $SQL = "SELECT     dbo_t_hospital.ID_hospital, dbo_t_hospital.Nombre, dbo_t_seguros.ID_seguro, dbo_t_seguros.Nombre
				FROM       dbo_t_hospital
    			INNER JOIN dbo_t_seguro_acepta ON dbo_t_hospital.ID_hospital = dbo_t_seguro_acepta.ID_hospital
    			INNER JOIN dbo_t_seguros ON dbo_t_seguro_acepta.ID_seguro = dbo_t_seguros.ID_seguro ";
            return;
        }


        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {

            $this->json_output($result);
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
    //Lista los hospitales en los que se acceptan un seguro especifico
    public function get_seguroHospitales($id = null) {

        $SQL = "SELECT     dbo_t_seguros.Nombre, dbo_t_hospital.ID_hospital, dbo_t_hospital.Nombre AS Hospital
    		    FROM       dbo_t_seguros INNER JOIN
    					   dbo_t_seguro_acepta ON dbo_t_seguros.ID_seguro = dbo_t_seguro_acepta.ID_seguro INNER JOIN
    					   dbo_t_hospital ON dbo_t_seguro_acepta.ID_hospital = dbo_t_hospital.ID_hospital
    			WHERE     dbo_t_seguros.ID_seguro ='.$id.'";
        $result = array(
            'success' => false,
            'data' => null
        );

        /*
         * Debera especificarse el id del seguro en cuestion
         * @param: id del hospital
         * */

        if (!$id || !is_numeric($id)) {
            //$this->json_output($result);

            return;
        }


        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {

            $this->json_output($result);
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

    //Lista todos los doctores de un hospital 
    public function get_doctoresHospital($id = null) {


        $result = array(
            'success' => false,
            'data' => null
        );

        if (!$id || !is_numeric($id)) {
            $this->json_output($result);
            return;
        }
        //Corregir query
        $SQL = 'SELECT dbo_t_doctor.ID_doctor, dbo_t_doctor.Nombre, dbo_t_doctor.Apellido, dbo_t_especialidad.ID_especialidad, dbo_t_especialidad.Nombre, dbo_t_hospital.ID_hospital, dbo_t_hospital.Nombre AS  Hospital
    	FROM dbo_t_doctor
    	INNER JOIN dbo_t_doctor_especialidad ON dbo_t_doctor.ID_doctor = dbo_t_doctor_especialidad.ID_doctor
    	INNER JOIN dbo_t_especialidad ON dbo_t_doctor_especialidad.ID_especialidad = dbo_t_especialidad.ID_especialidad
    	INNER JOIN dbo_t_doctor_consultorio ON dbo_t_doctor.ID_doctor = dbo_t_doctor_consultorio.ID_doctor
    	INNER JOIN dbo_t_hospital ON dbo_t_doctor_consultorio.ID_hospital = dbo_t_hospital.ID_hospital
    	WHERE     (dbo_t_hospital.ID_hospital = ' . $id . ')
    	ORDER BY dbo_t_especialidad.Nombre';



        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

    //Devuelve horario de un doctor en base a su consultorio
    public function get_doctorHorario($id = null) {


        $result = array(
            'success' => false,
            'data' => null
        );

        $SQL = 'SELECT     dbo_t_doctor.ID_doctor, dbo_t_doctor.Nombre, dbo_t_doctor.Apellido, dbo_t_especialidad.Nombre, dbo_t_consultorio.Numero, dbo_t_horario_disponible.horario, dbo_t_hospital.ID_hospital,
    			dbo_t_hospital.Nombre AS Hospital, dbo_t_horario_disponible.horario AS Expr1, dbo_t_consultorio.Piso, dbo_t_hospital.Direccion
    			FROM         dbo_t_doctor INNER JOIN
    			dbo_t_doctor_especialidad ON dbo_t_doctor.ID_doctor = dbo_t_doctor_especialidad.ID_doctor INNER JOIN
    			dbo_t_especialidad ON dbo_t_doctor_especialidad.ID_especialidad = dbo_t_especialidad.ID_especialidad INNER JOIN
    			dbo_t_doctor_consultorio ON dbo_t_doctor.ID_doctor = dbo_t_doctor_consultorio.ID_doctor INNER JOIN
    			dbo_t_consultorio ON dbo_t_doctor_consultorio.ID_consultorio = dbo_t_consultorio.ID_consultorio INNER JOIN
    			dbo_t_hospital ON dbo_t_doctor_consultorio.ID_hospital = dbo_t_hospital.ID_hospital INNER JOIN
    			dbo_t_horario_disponible ON dbo_t_doctor_consultorio.ID_horario = dbo_t_horario_disponible.ID_horario
    			WHERE     (dbo_t_doctor.ID_doctor = ' . $id . ')';



        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------

    public function get_seguros($id = null) {

        $SQL = "SELECT * FROM `dbo_t_seguros` where `ID_seguro`= " . $id;
        $result = array(
            'success' => false,
            'data' => null
        );

        if (!$id || !is_numeric($id)) {
            //$this->json_output($result);
            $SQL = "SELECT * FROM `dbo_t_seguros`";
            //return;
        }

        //if statement start


        if (!is_numeric($id) && is_string($id)) {
           /* $SQL = "SELECT     dbo_t_doctor.ID_doctor, dbo_t_doctor.nombre, dbo_t_doctor.Apellido, dbo_t_especialidad.nombre 
    			  FROM         dbo_t_doctor 
    			  INNER JOIN
                      dbo_t_doctor_especialidad ON dbo_t_doctor.ID_doctor = dbo_t_doctor_especialidad.ID_doctor 
    			  INNER JOIN
                      		dbo_t_especialidad ON dbo_t_doctor_especialidad.ID_especialidad = dbo_t_especialidad.ID_especialidad
				  WHERE dbo_t_doctor.ID_doctor = 1                      
ORDER BY dbo_t_especialidad.nombre";*/
            
            $SQL = "SELECT ID_seguro, nombre FROM dbo_t_seguros WHERE nombre LIKE  '%" . $id . "%' ORDER BY  nombre";


            $query = $this->db->query($SQL);

            if (is_array($query)) {
                foreach ($query as $row) {
                    if (($queryResult->num_rows() == 0) && ($queryCount < count($query))) {
                        $this->json_output($result);
                        return;
                    }
                }
            } elseif (!$query) {
                $this->json_output($result);
                return;
            }
            else
                $result['data'] = $query->result();


            // record found
            foreach ($result as $resultrow) {
                $this->json_output($resultrow);
            }
        }

        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    /*
     * funcion get_keyword
     * */

    public function get_keyword($id = null) {

        $SQL = "SELECT * FROM `dbo_t_seguros` where `ID_seguro`= " . $id;
        $result = array(
            'success' => false,
            'data' => null
        );

        if (!$id || !is_numeric($id)) {
            //$this->json_output($result);
            $SQL = "SELECT * FROM  `dbo_t_seguros`";
            //return;
        }

        // Query, this is only example and doesn't work
        //$SQL = "SELECT * FROM my_table_here WHERE id = " . $id;
        //$SQL = "SELECT * FROM `db_t_doctor` where `ID_doctor`= " . $id;

        $query = $this->db->query($SQL);


        if ($query->num_rows() == 0) {
            $this->json_output($result);
            return;
        } else if (is_array($query)) {
            $result = array();
            foreach ($query as $row)
                $result['data'] = $row['name'];
        }
        else
            $result['data'] = $query->result();


        // record found
        foreach ($result as $resultrow) {
            $this->json_output($resultrow);
        }
    }

}

?>