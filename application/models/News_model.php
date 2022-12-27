<?php

class News_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}


public function sp_select_task_new(){
    $this->db->reconnect();
    $sqlcall = $this->db->query("CALL `sp_select_task_new`(@p0);");
    return $sqlcall->result();
}

   public function sp_selectcorrel_news($id){
        $this->db->reconnect();
          $sqlcall = $this->db->query("CALL `sp_selectcorrel_news`('$id');");
         
          return $sqlcall->row();
    }

    public function sp_select_coment_news(){
    	 $this->db->reconnect();
    	$sqlcall = $this->db->query("CALL `sp_select_coment_news`(@p0);");
    	return $sqlcall->result();
    }

    public function sp_secomentarios($id_user,$comentarios,$idpublicacion,$tipopublicacion){
				$data = array(
				        'id_user' => $id_user,
				        'comments' => $comentarios,
				        'comments_correl' => $idpublicacion,
				        'type'=>$tipopublicacion
				);

			$this->db->insert('ta_news_comments', $data);
    }

     public function sp_task($id_user,$value){

                $data = array(
                        'id_user' => $id_user,
                        'detail'  => $value,
                        'stamp_begin' => date('Y-m-d h:i:s')                       
                );

            $this->db->insert('ta_news', $data);
    }

}


