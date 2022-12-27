<?php
               //extendemos CI_Model
class Rejection_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

public function add($shortname,$longname){

    $this->db->where('id_root','116');    
    $query = $this->db->get('ta_glossary'); 
    if($query->num_rows()==0){
        $numero = "001";
    }else{
        $siguiente = $query->num_rows() + 1;
        $numero = str_pad($siguiente, 3, "0", STR_PAD_LEFT);
    }
    $data=array("name_root"=>$shortname,'id_item'=>'116'.$numero,'id_root'=>'116','name_item'=>$longname);
    $this->db->insert('ta_glossary', $data);
}


public function edit($shortname,$longname,$id){
    $data=array('name_root'=>$shortname,'name_item'=>$longname);
    $this->db->where(array("id_item" => $id));
    $this->db->update('ta_glossary', $data);
}

public function search($id){
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

public function flist(){
    $query = $this->db->get('vi__motivo_rechazo'); 
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }
}
}
?>
