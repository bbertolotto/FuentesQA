<?php
               //extendemos CI_Model
class Deferred_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

public function add($name_root,$name_item,$value_min,$value_max){

    $this->db->where('id_root',CUOTAS_DIFERIR_PRODUCTOS);    
    $query = $this->db->get('ta_glossary'); 
    if($query->num_rows()==0){
        $correl_item = "001";
    }else{
        $correl_next = $query->num_rows() + 1;
        $correl_item = str_pad($correl_next, 3, "0", STR_PAD_LEFT);
    }
    $data=array('name_root'=>$name_root,'id_item'=>CUOTAS_DIFERIR_PRODUCTOS.$correl_item,'id_root'=>CUOTAS_DIFERIR_PRODUCTOS,'name_item'=>$name_item,'value_min'=>$value_min,'value_max'=>$value_max);
    $this->db->insert('ta_glossary', $data);
}

public function edit($name_item,$value_min,$value_max,$id_item){
    $data=array('name_item'=>$name_item,'value_min'=>$value_min,'value_max'=>$value_max);
    $this->db->where(array("id_item" => $id_item));
    $this->db->update('ta_glossary', $data);
}

public function search($id_item){
    $this->db->where('id_item',$id_item);    
    $query = $this->db->get('ta_glossary'); 
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }
}

public function delete($id_item){
    $this->db->where('id_item', $id_item);
    $this->db->delete('ta_glossary');
}

public function flist(){
    $query = $this->db->get('vi__cuotaDiferirProductos'); 
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }
}

public function tipoProductos(){
    $query = $this->db->get('vi__tipoProductos'); 
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }
}

}
?>
