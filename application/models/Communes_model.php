<?php

class Communes_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

//public function vistaregiones(){
public function ViewRegions(){
    
    $query = $this->db->get('vi__regiones'); 

    if($query->num_rows()>0){
       return $query->result_array();
    }else{
        return false;
    }
}


public function ViewCities($id){
    
    $this->db->where('CODIGO_REGION',$id);
    $query = $this->db->get('vi__ciudades'); 

    if($query->num_rows()>0){
       return $query->result_array();
    }else{
        return false;
    }
}

public function ViewCommunes($idCity,$idRegion){
    
    $this->db->where('CODIGO_CIUDAD',$idCity);
    $this->db->where('CODIGO_REGION',$idRegion);
    $query = $this->db->get('ta_comunas'); 
    if($query->num_rows()>0){
       return $query->result_array();
    }else{
        return false;
    }
}

}
?>
