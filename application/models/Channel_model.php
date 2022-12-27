<?php

class Channel_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

//public function vistaregiones(){
public function sp_chanel($id){
      //$this->db->reconnect();
    $this->db->order_by('datestamp', 'DESC');
    $this->db->where('id_user', $id);
    $query = $this->db->get('ta_users_channel'); 

    if($query->num_rows()>0){
       return $query->row();
    }else{
        return false;
    }
}




}
?>
