<?php
               //extendemos CI_Model
class Regiones_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

public function vistaregiones(){
    
      
        $query = $this->db->get('vi__regiones'); 
        
        if($query->num_rows()>0){
           return $query->result_array();
        }else{
            return false;
        }
}


public function vistaciudades($id){
    
      	$this->db->where('CODIGO_REGION',$id);
        $query = $this->db->get('vi__ciudades'); 
        
        if($query->num_rows()>0){
           return $query->result_array();
        }else{
            return false;
        }
}


public function comunasvistas($idciudad,$idregion){
    
      	$this->db->where('CODIGO_CIUDAD',$idciudad);
      	$this->db->where('CODIGO_REGION',$idregion);
        $query = $this->db->get('ta_comunas'); 
        
        if($query->num_rows()>0){
           return $query->result_array();
        }else{
            return false;
        }
}


}
?>
