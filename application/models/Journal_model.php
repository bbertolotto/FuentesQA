<?php
               //extendemos CI_Model
class Journal_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

public function getall_products(){

    $this->db->order_by('a.priority', 'asc');
    $this->db->from('ta_journal_products a');
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}


public function getall_journal(){
    $this->db->order_by('a.stamp', 'desc');
    $this->db->from('ta_journal a');
    $this->db->limit(5);
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_attentionByIdUser($field_iduser, $field_type){
    $this->db->select('a.*, b.name as name_office, c.username, c.name, c.last_name');
    $this->db->from('ta_journal a');
    $this->db->where('a.id_user', $field_iduser);
    $this->db->where('a.type', $field_type);
    $this->db->join('ta_office b', 'b.id_office=a.id_office', 'left');
    $this->db->join('ta_users c', 'c.id_user=a.id_user');
    $this->db->order_by('a.stamp', 'desc');
    $this->db->limit(5);
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }
}

public function get_attentionByManager($field_iduser, $field_type, $field_idoffice){
    $this->db->select('a.*, b.name as name_office, c.username, c.name, c.last_name');
    $this->db->from('ta_journal a');
    $this->db->or_where('a.id_user', $field_iduser);
    $this->db->or_where('a.id_office', $field_idoffice);
    $this->db->where('a.type', $field_type);
    $this->db->join('ta_office b', 'b.id_office=a.id_office', 'left');
    $this->db->join('ta_users c', 'c.id_user=a.id_user');
    $this->db->order_by('a.stamp', 'desc');
    $this->db->limit(10);
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }
}

public function ins_Task($data){

    $record = [
        "id_user" => ID_USER_MAXBOT,
        "id_office" => ID_OFFICE_MAXBOT,
        "id_department" => TASK_RED,
        "type_environment" => $data["type_environment"],
        "stamp" => $data["stamp_begin"],
        "stamp_begin" => $data["stamp_begin"],
        "stamp_end" => date("Y-m-d H:i:s"),
        "detail_issues" => $data["detail_issues"],
        "detail" => $data["detail"],
        "type_status" => $data["type_status"],
        "status" => $data["status"]
    ];

    $this->db->insert('ta_tasks', $record);

}


public function upd_CapturingById($id, $data, $embozado){

    if($embozado["autorizador"]!=0){

        $this->db->insert('ta_journal_capturing_credit_card', $embozado);
    }

    $this->db->where('autorizador', $id);
    if($this->db->update('ta_journal_capturing', $data)){

        $result = array('retorno'=> 0, 'descRetorno'=> "Transacción Aceptada");

    } else {

        $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);

    }


    return $result;
}

public function add_Refinance($data){

    if($this->db->insert('ta_journal_refinance', $data))
    {
        $result = array('retorno'=> 0, 'descRetorno'=> "Solicitud Refinanciamiento registrada correctamente ..!<br><br>Número asignado " . $data["autorizador"], 'autorizador'=> $data["autorizador"]);

    }else{

        $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);
    }

    return $result;

}


public function add_Renegotiation($data){
/*
    $this->db->where('number_rut_client', $data["number_rut_client"]);
    $this->db->where('status', 1);
    $this->db->from("ta_journal_renegotiation");
    $result = $this->db->get();
    if($result->num_rows()==0){
*/
        if($this->db->insert('ta_journal_renegotiation', $data))
        {
            $result = array('retorno'=> 0, 'descRetorno'=> "Solicitud Renegociación registrada correctamente ..!<br><br>Número asignado " . $data["autorizador"], 'autorizador'=> $data["autorizador"]);

        }else{

            $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);
        }
/*
    }else{

        $result = array('retorno'=> -1, 'descRetorno'=> "Cliente Registra Solicitud Renegociación en Proceso de Aprobación ..!");
    }
*/
    return $result;

}


public function add_Capturing($data){
    $this->db->where('rut', $data["rut"]);
    $this->db->where('vbqf', "PE");
    $this->db->from("ta_journal_capturing");
    $result = $this->db->get();
    if($result->num_rows()==0){

        if($this->db->insert('ta_journal_capturing', $data))
        {

            $result = array('retorno'=> 0, 'descRetorno'=> "Cliente Pre Aprobado registrado correctamente ..!<br><br>Número asignado " . $this->db->insert_id(), 'autorizador'=> $this->db->insert_id());

        }else{

            $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);

        }

    }else{

        $result = array('retorno'=> -1, 'descRetorno'=> "Cliente Registra Captación en Proceso de Aprobación ..!");

    }

    return $result;

}

public function add_ReprintCreditCard($data){
    $this->db->where('rut', $data["rut"]);
    $this->db->where('vbqf', "PE");
    $this->db->from("ta_journal_capturing");
    $result = $this->db->get();
    if($result->num_rows()==0){

        if($this->db->insert('ta_journal_capturing', $data))
        {

            $result = array('retorno'=> 0, 'descRetorno'=> "Solicitud de Reimpresión registrada correctamente ..!<br><br>Número asignado " . $this->db->insert_id(), 'autorizador'=> $this->db->insert_id());

        }else{

            $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);

        }

    }else{

        $result = array('retorno'=> -1, 'descRetorno'=> "Cliente Registra Solicitud Reimpresión Pendiente ..!");

    }

    return $result;

}

public function getall_capturing(){
    $this->db->order_by('a.autorizador', 'asc');
    $this->db->from('ta_journal_capturing a');
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}


public function get_refinanceById($id){

    $this->db->where('a.autorizador', $id);
    $this->db->from('ta_journal_refinance a');
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function upd_RefinanceById($id, $data){

    $this->db->where('autorizador', $id);
    $this->db->from('ta_journal_refinance a');
    $query = $this->db->get();

    if($query->num_rows()==0){

        $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);
        return $result;
    }

    $this->db->where('autorizador', $id);
    if($this->db->update('ta_journal_refinance', $data)){

          $result = array('retorno'=> 0, 'descRetorno'=> "Transacción Aceptada");

    } else {

          $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);
    }
    return $result;
}


public function get_renegotiationById($id){

    $this->db->where('a.autorizador', $id);
    $this->db->from('ta_journal_renegotiation a');
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function upd_RenegotiationById($id, $data){

    $this->db->where('autorizador', $id);
    $this->db->from('ta_journal_renegotiation a');
    $query = $this->db->get();

    if($query->num_rows()==0){

        $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);
        return $result;
    }

    $this->db->where('autorizador', $id);
    if($this->db->update('ta_journal_renegotiation', $data)){

          $result = array('retorno'=> 0, 'descRetorno'=> "Transacción Aceptada");

    } else {

          $result = array('retorno'=> $this->db->error()['code'], 'descRetorno'=> $this->db->error()['message']);
    }
    return $result;
}


public function get_capturingByReport($data){

    if($data["nroRut"]!=""){
        $rutClient = str_replace(".","",$data["nroRut"]); $rutClient = substr($rutClient, 0, -2);
        $this->db->where('a.rut', $rutClient);
    }
    if($data["numberRequest"]!=""){
        $this->db->where('a.autorizador', $data["numberRequest"]);
    }
    if($data["officeSkill"]!=""){
        $this->db->where('a.local', $data["officeSkill"]);
    }
    if($data["typeRequestSkill"]!=""){
        $this->db->where('a.vbqf', $data["typeRequestSkill"]);
    }
    if($data["dateBegin"]!=""){
        $this->db->where('CONCAT(substr(a.fecha,1,4),substr(a.fecha,6,2),substr(a.fecha,9,2)) >= ', $data["dateBegin"]);
    }
    if($data["dateEnd"]!=""){
        $this->db->where('CONCAT(substr(a.fecha,1,4),substr(a.fecha,6,2),substr(a.fecha,9,2)) <= ', $data["dateEnd"]);
    }

    $this->db->order_by('a.autorizador', 'asc');
    $this->db->from('ta_journal_capturing a');
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }

}

public function get_capturingById($id){
    $this->db->where('a.autorizador', $id);
    $this->db->from('ta_journal_capturing a');
    $query = $this->db->get();

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->row();
    }

}

public function list_process_renegotiation($input)
{

    $this->db->select("*");

    if ($input["status"] != "T"):
        $this->db->where("status = " . $input["status"]);
    endif;
    if ($input["nroRut"] != ""):
        $this->db->where("number_rut_client = " . $input["nroRut"]);
    endif;

    $this->db->where("STR_TO_DATE(date_create, '%Y-%m-%d') BETWEEN  '" . $input["dateBegin"] . "' AND '" . $input["dateEnd"] . "'");

    $query = $this->db->get('ta_journal_renegotiation');

    return $query->result();

}


}
?>
