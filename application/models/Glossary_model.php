<?php
               //extendemos CI_Model
class Glossary_model extends CI_Model{



public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

public function getall_diaspagoTecnocom(){

    $this->db->select('a.*');
    $this->db->from('ta_parameters_payday_tecnocom a');
    $this->db->order_by('a.order', 'asc');
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_masterProductById($id){
    $this->db->where('KEY', $id);
    $query = $this->db->get('vi__master_products');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}



public function get_statusCapturingById($id){
    $this->db->where('KEY', $id);
    $query = $this->db->get('vi__status_capturing');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}


public function get_REN_cuotas(){

    $query = $this->db->get('vi__REN_cuotas');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function get_REN_diferidos(){

    $query = $this->db->get('vi__REN_diferidos');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function getall(){

    $query = $this->db->get('vi__motivo_rechazo');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }
}

public function get_typeContactClient($Request){
    $this->db->where('TIPO_CONTACTO', $Request["tipo_contacto"]);
    $this->db->where('KEY_ALTER_1', $Request["tipo_fono"]);
    $this->db->where('KEY_ALTER_2', $Request["tipo_uso"]);
    $query = $this->db->get('vi__tiposContactos');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}


public function get_scriptById($id){
    $this->db->where('KEY', $id);
    $query = $this->db->get('vi__script');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_script_confirmacion_venta_sav($id, $flg_flujo){

    $this->db->where('KEY', $id);
    $this->db->where('FLG_FLUJO', $flg_flujo);
    $query = $this->db->get('vi__script_confirmacion_venta_sav');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
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

public function getall_lockTypes(){

        $query = $this->db->get('vi__motivo_bloqueos');

        if($query->num_rows()==0){
            return false;
        }else{
            return $query->result();
        }
}

public function get_lockTypeById($id){
    $this->db->where('KEY', $id);
    $query = $this->db->get('vi__motivo_bloqueos');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}


function obtenervisita($id){
        $this->db->where('KEY', $id);
        $query = $this->db->get('vi__motivo_visita');
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

public function getall_estado_cotiza() {

    $query = $this->db->get('vi__estado_cotizaciones');

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_estado_cotizaById($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('vi__estado_cotizaciones');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function listBeneficiaries() {
    $query = $this->db->get('vi__parentescos');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function getall_EstadoEnlaces() {
    $query = $this->db->get('vi__estado_enlaces');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_EstadoEnlaceById($id) {

    $this->db->where('id', $id);
    $query = $this->db->get('vi__estado_enlaces');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function getall_Bancos() {
    $query = $this->db->get('vi__bancos');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_BancosById($id) {

    $this->db->where('id', $id);
    $query = $this->db->get('vi__bancos');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function getall_tipoCuentas() {
    $query = $this->db->get('vi__tipoCuentas');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_tipoCuentasById($id) {

    $this->db->where('id', $id);
    $query = $this->db->get('vi__tipoCuentas');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}


public function get_htmlEmailsById($id, $id_alter) {

    $this->db->where('id', $id);
    $this->db->where('id_alter', $id_alter);
    $query = $this->db->get('vi__htmlEmails');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function get_segurosSavRemotoById($id) {

    $this->db->where('KEY', $id);
    $query = $this->db->get('vi__segurosSavRemoto');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}


public function getall_rechazaLiquida() {
//    $this->db->where('id_rol', $id);
    $query = $this->db->get('vi__rechazaLiquida');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function getall_rechazaAutoriza() {
//    $this->db->where('id_rol', $id);
    $query = $this->db->get('vi__rechazaAutoriza');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function getall_paisesTecnocom() {
    $query = $this->db->get('vi__paises_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_paisesTecnocomById($id) {
    $this->db->where('KEY', $id);
    $query = $this->db->get('vi__paises_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}


public function getall_comunasTecnocom() {
    $this->db->order_by('name', 'ASC');
    $query = $this->db->get('vi__comunas_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function getall_tipoCallesTecnocom() {
    $query = $this->db->get('vi__tipoCalles_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_tipoCallesTecnocomByName($name) {
    $this->db->where('NAME', $name);
    $query = $this->db->get('vi__tipoCalles_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function get_comunasTecnocomByName($name) {
    $this->db->where('NAME', $name);
    $query = $this->db->get('vi__comunas_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function get_comunasTecnocomById($id) {
    $this->db->where('KEY_ALTER1', $id);
    $query = $this->db->get('vi__comunas_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}


public function getall_institucionesSaludTecnocom() {
    $query = $this->db->get('vi__institucionesSalud_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_institucionesSaludTecnocomById($id) {
    $this->db->where('KEY', $id);
    $query = $this->db->get('vi__institucionesSalud_tecnocom');
    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}


}

?>
