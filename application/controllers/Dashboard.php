<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

public function __construct() {

    parent::__construct();

    $this->load->model(array("Usuario_model"=>"user", "Users_model"=>"users", "News_model"=>"news", "Journal_model"=>"journal", 
        "Parameters_model"=>"parameters"));
    $this->load->library(array( "session", "form_validation"));
    $this->load->helper( array('teknodatasystems_helper') );

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang) {$this->lang->load('header',$this->session->userdata('site_lang'));
    } else {$this->lang->load('header','spanish'); }

}

public function noaccess() {

    $result = check_session("2.0.1");

    $data_journal = array(); $field_iduser = $this->session->userdata("id"); $field_type = 1;

    if($this->session->userdata('id_manager')==1) {

        $field_idoffice = $this->session->userdata('id_office');
        $ta_journal = $this->journal->get_attentionByManager($field_iduser, $field_type, $field_idoffice);

    }else {


        $ta_journal = $this->journal->get_attentionByIdUser($field_iduser, $field_type);

    }

    if($ta_journal!=false) {
        foreach ($ta_journal as $key) {
            $valor["rut"] = number_format((float)$key->number_rut_client, 0, ',', '.')."-".$key->digit_rut_client;
            $valor["name_client"] = $key->name_client;
            $valor["stamp"] = $key->stamp;
            $valor["office"] = $key->name_office;
            $valor["username"] =  $key->username;
            $valor["reasonDetail"] =  $key->detail;
            $data_journal[] = $valor;
        }
    }

    $datos["journal"] = $data_journal;
    $datos['office'] = $this->user->sp_office($this->session->userdata('id'));
    $datos['dataError'] = array('session_empty' => TRUE);
    $datos["parameters"] = $this->parameters->get_generalParameters();

    $this->load->view('dashboard/noaccess', $datos);

}

public function index() {
    if($this->session->userdata('lock') === NULL) { redirect(base_url()); }
    if($this->session->userdata('lock') == "0"){ redirect(base_url("dashboard/lock")); }
    $this->session->set_userdata('selector', '1.0.1');

    $data_journal = array(); $field_iduser = $this->session->userdata("id_user"); $field_type = 1;

    if($this->session->userdata('id_manager')==1) {

        $field_idoffice = $this->session->userdata('id_office');
        $ta_journal = $this->journal->get_attentionByManager($field_iduser, $field_type, $field_idoffice);

    }else {


        $ta_journal = $this->journal->get_attentionByIdUser($field_iduser, $field_type);

    }

    if($ta_journal!=false) {
        foreach ($ta_journal as $key) {
            $valor["rut"] = number_format((float)$key->number_rut_client, 0, ',', '.')."-".$key->digit_rut_client;
            $valor["name_client"] = $key->name_client;
            $valor["stamp"] = $key->stamp;
            $valor["office"] = $key->name_office;
            $valor["reasonDetail"] =  $key->detail;
            $valor["username"] =  $key->username;
            $data_journal[] = $valor;
        }
    }
    $datos["journal"] = $data_journal;
    $datos['office'] = $this->user->sp_office($this->session->userdata('id'));
    $datos["parameters"] = $this->parameters->get_generalParameters();

    $this->load->view('dashboard/mydashboard',$datos);
}

public function mydashboard() {
 
    $result = check_session("2.0.1");

    $data_journal = array(); $field_iduser = $this->session->userdata("id"); $field_type = 1;

    if($this->session->userdata('id_manager')==1) {

        $field_idoffice = $this->session->userdata('id_office');
        $ta_journal = $this->journal->get_attentionByManager($field_iduser, $field_type, $field_idoffice);

    }else {


        $ta_journal = $this->journal->get_attentionByIdUser($field_iduser, $field_type);

    }

    if($ta_journal!=false) {
        foreach ($ta_journal as $key) {
            $valor["rut"] = number_format((float)$key->number_rut_client, 0, ',', '.')."-".$key->digit_rut_client;
            $valor["name_client"] = $key->name_client;
            $valor["stamp"] = $key->stamp;
            $valor["office"] = $key->name_office;
            $valor["username"] =  $key->username;
            $valor["reasonDetail"] =  $key->detail;
            $data_journal[] = $valor;
        }
    }

    $datos["journal"] = $data_journal;
    $datos['office'] = $this->user->sp_office($this->session->userdata('id'));
    $datos["parameters"] = $this->parameters->get_generalParameters();

    $this->load->view('dashboard/mydashboard',$datos);
}

public function lock()
{

    $result = check_session("");

    $data["parameters"] = $this->parameters->get_generalParameters();

    $fecha         = date("Y-m-d");
    $status        = "2";
    $idusuario     = $this->session->userdata("id_user");

    $this->session->set_userdata('login', 'valid');
    $this->session->set_userdata('lock', 0);
    $this->users->lock_desktop($fecha,$status,$idusuario);
    $this->load->view('dashboard/lock', $data);
}

public function perfilgeneral(){

    $result = check_session("");

    $this->form_validation->set_rules('id', 'Identificador', 'required');
    $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');

    if($this->form_validation->run() == FALSE){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(),"");
    }

    if($this->session->userdata("id_user")!=$this->input->post("id")){

        cancel_function(COD_ERROR_VALID_FORM, MESSAGE_EXIT_INVALID_CREDENTIAL,"");
    }

    $result = $this->user->sp_user($this->input->post('id'));
    if(!$result){

        cancel_function(COD_ERROR_VALID_FORM, "Identificador de usuario no existe..!","");
    }

    echo json_encode(array('retorno' => 0, 'descRetorno' => 'descRetorno', 'email' => $result->email, 'notificacion' => $result->email_notifications) );

}

public function put_perfil(){

    $this->form_validation->set_rules('username', 'Usuario', 'required');
    $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');
    if($this->form_validation->run() == FALSE){

        if($this->input->is_ajax_request()) {

            echo json_encode(array('error' => true,'mensaje' => validation_errors()));
            exit();

        }else{

            redirect(base_url());
        }

    }


        $username = $this->input->post("username");
        $idoffice = $this->input->post("company");
        $email_system = $this->input->post("email_system");
        $rut_number = $this->input->post("rut_number");
        $rut_validation = $this->input->post("rut_validation");
        $idboss = $this->input->post("idboss");
        $number_whatsapp = $this->input->post("number_whatsapp");
        $number_phone = $this->input->post("number_phone");

        if ( !isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0){
               $update =  $this->user->sp_user_update_no_file($username,$idoffice,$email_system,$rut_number,$rut_validation,$idboss,$number_whatsapp,$number_phone,$this->session->userdata('id'));
                echo json_encode(array('mensaje' => $update->lv_Mensaje,'imagen'=>'no imagen'));
                exit;
        } else {

        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
        $limite_kb = 16384;
        if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024){

                // Este es el archivo temporal:
                $imagen_temporal = $_FILES['imagen']['tmp_name'];
                // Este es el tipo de archivo:
                $tipo = $_FILES['imagen']['type'];
                // Leer el archivo temporal en binario.
                $fp = fopen($imagen_temporal, 'r+b');
                $data = fread($fp, filesize($imagen_temporal));
                fclose($fp);

                // Escapar los caracteres.
                // $data = mysql_escape_string($this->get_mysqli(),$data);
                $data = mysqli_real_escape_string($this->get_mysqli(),$data);



               $update =  $this->user->sp_user_update_file($username,$idoffice,$email_system,$rut_number,$rut_validation,$idboss,$number_whatsapp,$number_phone,$this->session->userdata('id'),$data,$tipo);




            $consultarusername = $this->user->sp_user($this->session->userdata('id'));
          $this->session->set_userdata('avatar', $consultarusername->avatar);


             echo json_encode(array('error' => true,'mensaje' => $update->lv_Mensaje,'imagen'=>'si imagen'));
        }
    }
        }


public function perfil(){

        $username = $this->input->post("username");
        $idoffice = $this->input->post("company");
        $email_system = $this->input->post("email_system");
        $rut_number = $this->input->post("rut_number");
        $rut_validation = $this->input->post("rut_validation");
        $idboss = $this->input->post("idboss");
        $number_whatsapp = $this->input->post("number_whatsapp");
        $number_phone = $this->input->post("number_phone");


        if ( !isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0){
               $update =  $this->user->sp_user_update_no_file($username,$idoffice,$email_system,$rut_number,$rut_validation,$idboss,$number_whatsapp,$number_phone,$this->session->userdata('id'));
                echo json_encode(array('mensaje' => $update->lv_Mensaje,'imagen'=>'no imagen'));
                exit;
        } else {

        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
        $limite_kb = 16384;
        if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024){

                // Este es el archivo temporal:
                $imagen_temporal = $_FILES['imagen']['tmp_name'];
                // Este es el tipo de archivo:
                $tipo = $_FILES['imagen']['type'];
                // Leer el archivo temporal en binario.
                $fp = fopen($imagen_temporal, 'r+b');
                $data = fread($fp, filesize($imagen_temporal));
                fclose($fp);

                // Escapar los caracteres.
                // $data = mysql_escape_string($this->get_mysqli(),$data);
                $data = mysqli_real_escape_string($this->get_mysqli(),$data);



               $update =  $this->user->sp_user_update_file($username,$idoffice,$email_system,$rut_number,$rut_validation,$idboss,$number_whatsapp,$number_phone,$this->session->userdata('id'),$data,$tipo);




            $consultarusername = $this->user->sp_user($this->session->userdata('id'));
          $this->session->set_userdata('avatar', $consultarusername->avatar);


             echo json_encode(array('error' => true,'mensaje' => $update->lv_Mensaje,'imagen'=>'si imagen'));
        }
    }
        }


   function get_mysqli() {
$db = (array)get_instance()->db;
return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}





}
