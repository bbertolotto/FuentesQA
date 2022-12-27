<?php
               //extendemos CI_Model
class Documents_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

public function get_DocumentsImagesById($id){

    $this->db->where('id', $id);
    $query = $this->db->get('ta_documents_images');

    if($query->num_rows()>0) { return $query->row(); } else { return false; }

}


public function getall_documents(){

    $query = $this->db->get('ta_documents');

    if($query->num_rows()==0) { return false; } else { return $query->result(); }

}

public function add_journalSecure($idDocument,$typeDocument,$codSecure, $declareDps, $useEmail, $typeBeneficiaries) {

    $this->db->where('idDocument', $idDocument);
    $this->db->where('typeDocument', $typeDocument);
    $query = $this->db->get('ta_journal_secure');

    if($query->num_rows()>0) { return false; }

    $data=array('idDocument'=>$idDocument,'typeDocument'=>$typeDocument, 'codSecure' => $codSecure,
        'declareDps'=> $declareDps,'email'=> $useEmail,'typeBeneficiaries'=> $typeBeneficiaries);
    $this->db->insert('ta_journal_secure', $data);
}

public function get_journalSecureByID($idDocument, $codSecure) {

    $this->db->where('idDocument', $idDocument);
    $this->db->where('codSecure', $codSecure);
    $query = $this->db->get('ta_journal_secure');

    if($query->num_rows()>0) { return $query->row(); } else { return false; }

}

public function get_documentsById($id, $type){
    $this->db->where('idDocument', $id);
    $this->db->where('typeDocument', $type);
    $query = $this->db->get('ta_documents');

    if($query->num_rows()>0) { return $query->row(); } else { return false; }

}

public function get_documentsByEmail($id){
    $this->db->where('idDocument', $id);
    $query = $this->db->get('ta_documents');

    if($query->num_rows()>0) { return $query->result(); } else { return false; }

}

public function get_documentsExists($id, $type){
    $this->db->where('idDocument', $id);
    $this->db->where('typeDocument', $type);
    $query = $this->db->get('ta_documents');

    if($query->num_rows()>0) { return true; } else { return false; }

}

public function get_documentsByRut($nroRut){
    $this->db->where('number_rut_client', $nroRut);
    $query = $this->db->get('ta_documents');

    if($query->num_rows()>0) { return $query->result(); } else { return false; }

}

public function db_documentsById_delete($field_id, $field_type) {
    $this->db->where("idDocument", $field_id);
    $this->db->where("typeDocument", $field_type);
    $query = $this->db->delete("ta_documents");


}


} //End Class

?>
