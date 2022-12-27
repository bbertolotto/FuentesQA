<?php
               //extendemos CI_Model
class Feriado_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

public function addferiado($name,$periodo,$fecha,$dia_habil_anterior,$dia_habil_siguiente){



        $this->db->where('id_root','112');    
        $query = $this->db->get('ta_glossary'); 
        
        if($query->num_rows()==0){
            $numero = "001";
        }else{
            $siguiente = $query->num_rows() + 1;
            $numero = str_pad($siguiente, 3, "0", STR_PAD_LEFT);
        }


            
    $data=array("name_root"=>"Feriados",'id_item'=>'112'.$numero,'id_root'=>'112','name_item'=>$name,'id_root_parent'=>$periodo,'value_date'=>$fecha,'value_min'=>$dia_habil_anterior,'value_max'=>$dia_habil_siguiente);

      $this->db->insert('ta_glossary', $data);

}


public function editferiado($name,$periodo,$fecha,$dia_habil_anterior,$dia_habil_siguiente,$id){



     

            
    $data=array('name_item'=>$name,'id_root_parent'=>$periodo,'value_date'=>$fecha,'value_min'=>$dia_habil_anterior,'value_max'=>$dia_habil_siguiente);

 $this->db->where(array("id_item" => $id));
      $this->db->update('ta_glossary', $data);

}


public function buscar($id){



        $this->db->where('id_item',$id);    
        $query = $this->db->get('ta_glossary'); 
        
        if($query->num_rows()==0){
           return false;
        }else{
            return $query->row();
        }


            
   

}

public function delete($id){

    $this->db->where('id_item', $id);
$this->db->delete('ta_glossary');

}


public function listadoferiado(){

        $query = $this->db->get('vi__feriados'); 
        
        if($query->num_rows()==0){
            return false;
        }else{
            return $query->result();
        }
}

}
?>
