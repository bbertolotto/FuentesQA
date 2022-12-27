<?php
               //extendemos CI_Model
class Motivosrechazo_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

public function getall(){

        $query = $this->db->get('vi__motivo_rechazo'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->result();
        }
}


public function getallvi__activity(){

        $query = $this->db->get('vi__activity'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->result();
        }
}


public function getall_visita(){

        $query = $this->db->get('vi__motivo_visita'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->result();
        }
}


public function obtenervisita($id){
        $this->db->where('KEY', $id);
        $query = $this->db->get('vi__motivo_visita');
        if($query->num_rows()>0){
            return $query->row();
        }
        else{
            return false;
        }
    }


public function getall_reasonCollection(){

        $query = $this->db->get('vi__motivo_mora'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->result();
        }
    }


public function get_reasonCollectionById($id){
        $this->db->where('KEY', $id);
        $query = $this->db->get('vi__motivo_mora');
        if($query->num_rows()>0){
            return $query->row();
        }
        else{
            return false;
        }
    }


public function getall_journal(){
    $this->db->select('a.*, b.name as name_office');
    $this->db->from('ta_journal a');
    $this->db->join('ta_office b', 'b.id_office=a.id_office', 'left');
    $this->db->order_by('a.stamp', 'desc');
    $this->db->limit(5);  
    $query = $this->db->get(); 

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }
}

public function getall_documentos(){
        $query = $this->db->get('ta_documents'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->result();
        }
}



public function getall_motivo($id){

        $this->db->where('id_item',$id);    

        $query = $this->db->get('ta_glossary'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->row();
        }
}

public function documentos($id){

        $this->db->where('id',$id);    

        $query = $this->db->get('documento'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->row();
        }
}


public function leerdocumentos($iddoc,$typedoc){

        $this->db->where('idDocument',$iddoc);    
        $this->db->where('typeDocument',$typedoc);    

        $query = $this->db->get('ta_documents'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->row();
        }
}


public function buscardocumentos($iddoc,$typedoc){

        $this->db->where('iddocumento',$iddoc);    
        $this->db->where('typedoc',$typedoc);    

        $query = $this->db->get('ta_documents'); 
        
        if($query->num_rows()==0){
            return 0;
        }else{
            return 1;
        }
}

}
?>
