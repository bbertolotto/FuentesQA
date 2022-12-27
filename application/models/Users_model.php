<?php

class Users_model extends CI_Model{

public function __construct() {
    parent::__construct();
    $this->load->database();
}

/***
 * Begin::CC0022 
 * Visor Registro eventos plataforma
 */ 
public function getall_log($dataInput){

    $query = "SELECT * FROM ta_journal_log_event WHERE DATE(date_begin) BETWEEN  '".$dataInput["dateBegin"]."' and '".$dataInput["dateEnd"] . "'";
    if($dataInput["username"]!=""){

        $query .= " AND username = '" . $dataInput["username"] . "'";
    }

    if($dataInput["result"]!=""){

        $query .= " AND result = '" . $dataInput["result"] . "'";
    }


    if($dataInput["username"]==""){

        $query .= " ORDER BY date_begin DESC LIMIT 1000;";

    }else{

        $query .= " ORDER BY date_begin DESC;";
    }

    $eval = $this->db->query($query);

    if($eval->num_rows()==0){ return false; } else { return $eval->result(); }

}
/***
 * Begin::CC0022 
 * Visor Registro eventos plataforma
 */ 


/*
Begin Admin ta_users
*/

public function insertar($data,$channelUsers){

$this->db->insert('ta_users', $data);
$ultimoId = $this->db->insert_id();

$datachannel = array('id_user'=>$ultimoId,'channel'=>$channelUsers);
$this->db->insert('ta_users_channel', $datachannel);

}

public function editar($data, $channelUsers){

$id_user = $data["id_user"];

if($data["password"]!="") {

    $data = array('rut_number'=>$data["rut_number"],'rut_validation'=>$data["rut_validation"],'name'=>$data["name"],'last_name' => $data["last_name"],'email'=>$data["email"],'username' => $data["username"],
    'id_office' => $data["id_office"],'id_rol' => $data["id_rol"],'id_manager'=>$data["id_manager"],'id_boss'=>$data["id_boss"],'number_phone'=>$data["number_phone"],'password'=>md5($data["password"]),'id_user_boss'=>$data["id_user_boss"],'attention_mode'=>$data["attention_mode"]);

} else {

    $data = array('rut_number'=>$data["rut_number"],'rut_validation'=>$data["rut_validation"],'name'=>$data["name"],'last_name' => $data["last_name"],'email'=>$data["email"],'username' => $data["username"],'id_office' => $data["id_office"],'id_rol' => $data["id_rol"],'id_manager'=>$data["id_manager"],'id_boss'=>$data["id_boss"],'number_phone'=>$data["number_phone"],
    'id_user_boss'=>$data["id_user_boss"],'attention_mode'=>$data["attention_mode"]);
}
$this->db->where('id_user', $id_user);
$this->db->update('ta_users', $data);

$datachannel = array('channel'=>$channelUsers);
$this->db->where('id_user', $id_user);
$this->db->update('ta_users_channel', $datachannel);

}

public function delete($idusuario){

    if ( ! $this->db->simple_query('UPDATE ta_users SET is_delete = 1 WHERE id_user = ' . $idusuario . ';'))
    {
            $value["retorno"] = $this->db->error()["code"]; 
            $value["descRetorno"] = $this->db->error()["message"];
    }else{
            $value["retorno"] = EXIT_SUCCESS; 
            $value["descRetorno"] = "Transacción Aceptada";
    }
    return $value;
}

public function locked($idusuario){

    $query = 'UPDATE ta_users SET lock_date = NULL, is_locked = 1 WHERE id_user = ' . $idusuario . ';';
    if ( ! $this->db->simple_query($query))
    {
            $value["retorno"] = $this->db->error()["code"]; 
            $value["descRetorno"] = $this->db->error()["message"];
    }else{
            $value["retorno"] = EXIT_SUCCESS; 
            $value["descRetorno"] = "Transacción Aceptada";
    }
    return $value;

}

public function unlock($idusuario){

    $query = 'UPDATE ta_users SET lock_date = NULL, is_locked = 0 WHERE id_user = ' . $idusuario . ';';
    if ( ! $this->db->simple_query($query))
    {
            $value["retorno"] = $this->db->error()["code"]; 
            $value["descRetorno"] = $this->db->error()["message"];
            return $value;

    }else{

        $query = 'DELETE FROM ta_users_records WHERE state = 9 AND id_user = ' . $idusuario . ';';
        if ( ! $this->db->simple_query($query))
        {
            $value["retorno"] = $this->db->error()["code"]; 
            $value["descRetorno"] = $this->db->error()["message"];

        }else{

            $value["retorno"] = EXIT_SUCCESS; 
            $value["descRetorno"] = "Transacción Aceptada";
        }
    }
    return $value;
}

public function lock_desktop($fecha,$status,$idusuario){

    $data = array(
       'lock_date'=>$fecha,
       'status'=>$status,
    );
    $this->db->where('id_user', $idusuario);
    $this->db->update('ta_users', $data);

    $data = array(
        'id_user'=>$idusuario,
        'state'=> 3);
    $this->db->insert('ta_users_records', $data);
}

public function signout($data){

    $this->db->insert('ta_users_records', $data);

}

/*
End Admin ta_users
*/

public function spi_login_successful_entry($email,$clave){
    $this->db->reconnect();
    $this->db->query("CALL `spi_login_successful_entry`('$email', @p1, @p2, @p3,'$clave',@p5);");
    $sqlcall = $this->db->query("SELECT @p1 AS `lv_ID`, @p2 AS `lv_Resultado`, @p3 AS `lv_Mensaje` , @p5 AS `lv_email`");
    return $sqlcall->row();
}

public function loginUsers($email,$clave,$type_access){

    $query=$this->db->query("SELECT id_user, email, status FROM ta_users WHERE email = '$email'");
    if($query->num_rows()==0){

        $value["descRetorno"] = "Usuario no esta registrado !";
        $value["retorno"] = -1;

        $data = $value;
        return $data;
    }
    $field = $query->row();

    $query=$this->db->query("SELECT id_user, email, status FROM ta_users WHERE email = '$email' AND password = md5('$clave')");

    if($query->num_rows()==0){

        $value["descRetorno"] = "Clave Usuario no corresponde !";
        $value["retorno"] = -1; $type_access = 2;

        $query = $this->db->query("INSERT INTO ta_users_records (id_user, type) VALUES ($field->id_user , $type_access)");

        $data = $value;
        return $data;
    }


    if($field->status==1){

        $value["descRetorno"] = "Usuario no esta vigente !";
        $value["retorno"] = -1;

        $data = $value;
        return $data;
    }

    $type_access = 1;
    $query = $this->db->query("INSERT INTO ta_users_records (id_user, type) VALUES ($field->id_user , $type_access)");

    $value["id_user"] = $field->id_user;
    $value["email"] = $field->email;
    $value["descRetorno"] = "Usuario vigente acceso OK !";
    $value["retorno"] = 0;

    $data = $value;
    return $data;
}


public function getall_roles() {

    $query = $this->db->query("SELECT * FROM ta_users_roles WHERE id_rol > 1;");

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }
}

public function getall_users(){

    $query = $this->db->query("SELECT a.*, concat(a.rut_number,'-',a.rut_validation) as rut_user , concat(a.name, ' ', a.last_name) as name_user, b.name as name_office, c.channel as name_channel FROM ta_users a
        INNER JOIN ta_office b ON a.id_office = b.id_office
        INNER JOIN ta_users_channel c ON a.id_user = c.id_user
        WHERE a.id_rol>1 AND a.is_delete=0 ORDER BY a.email;");

    if($query->num_rows()==0){
        return false;
    }else{
        return $query->result();
    }


}

public function get_usersById($id){

    $this->db->where("a.id_user", $id);
    $this->db->select("a.*, concat(a.rut_number,'-',a.rut_validation) as rut_user , concat(a.name, ' ', a.last_name) as name_user, b.name as name_office, c.channel as name_channel");
    $this->db->from("ta_users a");
    $this->db->join("ta_office b", "b.id_office=a.id_office", "inner");
    $this->db->join("ta_users_channel c", "c.id_user=a.id_user", "inner");
    $query = $this->db->get();

    if($query->num_rows()>0){
        return $query->row();
    }
    else{
        return false;
    }

}


public function sp_chanel($id){
    $this->db->reconnect();
    $datos = $this->db->query("CALL sp_channel ('$id');");
    return $datos->row();
}

public function sp_office($id){
    $this->db->reconnect();
    $sqlcall = $this->db->query("CALL `sp_office`('$id');");
    return $sqlcall->row();
}

public function sp_office2($id){
    $this->db->reconnect();
    $sqlcall = $this->db->query("CALL `sp_office2`('$id');");
    return $sqlcall->row();
}
public function sp_select_officce(){
    $this->db->reconnect();
    $sqlcall = $this->db->query("CALL `sp_select_officce`(@p0);");
    return $sqlcall->result();
}
public function spi_jefe($email,$id){
    $this->db->reconnect();
    $sqlcall = $this->db->query("CALL `spi_jefe`('$email','$id');");
    return $sqlcall->result();
}
public function sp_user($id){
    $this->db->reconnect();
    $sqlcall = $this->db->query("CALL `sp_user`('$id');");
    return $sqlcall->row();
}

public function spi_login_key_error($email){
    $this->db->query("CALL `spi_login_key_error`('$email', @p1, @p2, @p3);");
    $sqlcall = $this->db->query("SELECT @p1 AS `lv_ID`, @p2 AS `lv_Resultado`, @p3 AS `lv_Mensaje`");
    return $sqlcall->row();
}
public function spi_login_clave_update($clave,$email){
    $valor =  $this->db->query("CALL `spi_login_clave_update`('$clave','$email');");
    return $valor;
}
public function sp_salas_insert($creado,$unido,$salas){
    $this->db->reconnect();
    $this->db->query("CALL `sp_salas_insert`('$creado','$unido','$salas',@p4,@p5);");
    $sqlcall = $this->db->query("SELECT @p4 AS `lv_Resultado`, @p5 AS `lv_Mensaje`");
    return $sqlcall->row();
}
public function sp_login_register2($nombre,$apellido,$email,$clave){
    $this->db->reconnect();
    $this->db->query("CALL sp_login_register ('$nombre','$apellido','$email','$clave', @p4, @p5, @p6);");
    $sqlcall = $this->db->query("SELECT @p4 AS `lv_Resultado`, @p5 AS `lv_Mensaje`,  @p6 AS `lv_id_insert`");
    return $sqlcall->row();
}
public function sp_email($email){
    $this->db->reconnect();
    $datos = $this->db->query("CALL sp_email ('$email');");
    return $datos->row();
}
public function sp_lastlogin($fecha,$id){
    $this->db->reconnect();
    $this->db->query("CALL sp_lastlogin ('$fecha','$id');");
    return true;
}
public function sp_setting($email,$activado,$clave,$id,$lockTime,$attention){
        $this->db->reconnect();
        $this->db->query("CALL sp_setting ('$email','$activado','$clave','$id', @p4, @p5,'$lockTime', '$attention');");

        $sqlcall = $this->db->query("SELECT @p4 AS `lv_Resultado`, @p5 AS `lv_Mensaje`");
        return $sqlcall->row();
}

public function verusername($username){
    $this->db->reconnect();
        //Hacemos una consulta
    $consulta=$this->db->query("CALL `spi_listadoemail`('$username');");
    return $consulta->result();
}
public function sp_user_update_no_file($username,$idoffice,$email_system,$rut_number,$rut_validation,$idboss,$number_whatsapp,$number_phone,$iduser){
    $this->db->reconnect();
    $this->db->query("CALL `sp_user_update_no_file`('$username','$idoffice','$email_system','$rut_number','$rut_validation','$idboss','$number_whatsapp','$number_phone','$iduser', @p10,@p11);");
    $sqlcall = $this->db->query("SELECT @p10 AS `lv_Resultado`, @p11 AS `lv_Mensaje`");
    return $sqlcall->row();
}
public function sp_user_update_file($username,$idoffice,$email_system,$rut_number,$rut_validation,$idboss,$number_whatsapp,$number_phone,$iduser,$data,$type){
    $this->db->reconnect();
    $this->db->query("CALL `sp_user_update_file`('$username','$idoffice','$email_system','$rut_number','$rut_validation','$idboss','$number_whatsapp','$number_phone','$iduser','$data','$type', @p12,@p13);");
    $sqlcall = $this->db->query("SELECT @p12 AS `lv_Resultado`, @p13 AS `lv_Mensaje`");
    return $sqlcall->row();
}
 public function sp_news($utype_name,$ustamp,$uid_user,$udetail){
        $this->db->reconnect();
         $this->db->query("CALL `sp_news`(@p0,@p1,'$utype_name','$ustamp','$uid_user','$udetail');");
          $sqlcall = $this->db->query("SELECT @p0 AS `lv_Resultado`, @p1 AS `lv_Mensaje`");
          return $sqlcall->row();

    }

 public function sp_newsubicacion($utype_name,$ustamp,$uid_user,$location){
        $this->db->reconnect();
         $this->db->query("CALL `sp_news_ubicacion`(@p0,@p1,'$utype_name','$ustamp','$uid_user','$location');");
          $sqlcall = $this->db->query("SELECT @p0 AS `lv_Resultado`, @p1 AS `lv_Mensaje`");
          return $sqlcall->row();

    }
public function ver($id){
    $consulta=$this->db->query("SELECT * FROM  ta_users where id_user <> $id;");
    return $consulta->result();
}
public function versalas($idunido){
    $this->db->reconnect();
    $consulta=$this->db->query("CALL `sp_ver_salas`('$idunido');");
    return $consulta->result();
}
public function consultaremail($email){
    $consulta=$this->db->query("SELECT * FROM  ta_users WHERE email = '$email';");
    if($consulta->num_rows()==0){
      return false;
    }else{
      return true;}
}
public function consultarusername($username){
    $consulta=$this->db->query("SELECT * FROM  ta_users WHERE username = '$username';");
    if($consulta->num_rows()==0){
        return false;
    }else{
        return true;}
}
public function buscar($username,$clave){
    $password = md5($clave);
    $consulta=$this->db->query("SELECT * FROM ta_users WHERE username = '$username' and password = '$password';");
    if($consulta->num_rows()==0){
        return false;
    }else{return $consulta->row();}
}

public function add($email,$nombre,$apellido,$clave,$username){
    $consulta=$this->db->query("SELECT * FROM ta_users WHERE email = '$email'");
    if($consulta->num_rows()==0){
        $consulta=$this->db->query("INSERT INTO ta_users (email,name,last_name,password,username,status) VALUES('$email','$nombre','$apellido','$clave','$username','1');");
        if($consulta==true){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

public function mod($id,$email="NULL",$nombre="NULL",$apellido="NULL",$clave="NULL",$rol="NULL"){
    if($email=="NULL"){
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('usuario');
        $query = $this->db->get();
        return $query->row();
    }else{
        $consulta=$this->db->query("
        UPDATE usuario SET email='$email', nombre='$nombre',
        apellido='$apellido', clave='$clave',rol='$rol' WHERE id=$id;");
        if($consulta==true){
            return true;
        }else{
            return false;
        }
    }
}
public function getid() {
    $this->db->reconnect();
    $this->db->select('*');
    $res = $this->db->get('ta_users');
    if ($res) {
      if ($res->num_rows()) {
        $rows=$res->result_array();
        $tipos=array();
        foreach($rows as $r){
          $tipos[$r['id_user']]=$r;
        }
        return $tipos;
      } else {
        return array();
      }
    }else{
        $mensaje = 'ta_users->getid ' . $this->db->_error_message();
        $numero = $this->db->_error_number();
        throw new Exception($mensaje, $numero);
    }
}

 public function consultareas($id){

        //Hacemos una consulta
        $consulta=$this->db->query("SELECT * FROM  ta_news WHERE correl = '$id';");

        //Devolvemos el resultado de la consulta
        if($consulta->num_rows()==0){
              return false;
            }else{
                return $consulta->row();
            }

}



}
?>
