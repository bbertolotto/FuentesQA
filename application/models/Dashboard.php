<?php
defined('BASEPATH') OR exit('No direct script access allowed');


include_once (dirname(__FILE__) . "/CallWSSolventa.php");

class Dashboard extends CallWSSolventa {

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
    //llamamos al constructor de la clase padre
    parent::__construct();
    $this->load->model("Usuario_model","user");
    $this->load->model("Users_model","users");
    $this->load->model("News_model","news");
    $this->load->model("Journal_model","journal");
    $this->load->library("session");
    $this->load->library('form_validation');
    $site_lang = $this->session->userdata('site_lang');
    if($site_lang) {$this->lang->load('header',$this->session->userdata('site_lang'));
    } else {$this->lang->load('header','spanish'); }
}

public function noaccess() {
    if($this->session->userdata('lock') === NULL) { redirect(base_url()); }
    if($this->session->userdata('lock') == "0"){ redirect(base_url("dashboard/lock")); }

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
    $this->session->set_userdata('selector', '2.0.1');
    $datos['office'] = $this->user->sp_office($this->session->userdata('id'));

    $datos['dataError'] = array('session_empty' => TRUE);
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
    $this->load->view('dashboard/mydashboard',$datos);
}

public function mydashboard() {
    if($this->session->userdata('lock') === NULL) { redirect(base_url()); }
    if($this->session->userdata('lock') == "0"){ redirect(base_url("dashboard/lock")); }

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
    $this->session->set_userdata('selector', '2.0.1');
    $datos['office'] = $this->user->sp_office($this->session->userdata('id'));
    $this->load->view('dashboard/mydashboard',$datos);
}

public function lock()
{

    $result = check_session("");

    $fecha         = date("Y-m-d");
    $status        = "2";
    $idusuario     = $this->session->userdata("id_user");

    $this->session->set_userdata('lock', 0);
    $this->users->lock_desktop($fecha,$status,$idusuario);
    $this->load->view('dashboard/lock');
}

/*********
public function profile(){
//  if ($this->session->userdata('lock') === NULL) {
//bila session user kosong balik ke 'Login'
//             redirect(base_url());
//        }
//        if( $this->session->userdata('lock') == "0"){
//
//             redirect(base_url("Dashboard/lock"));
//      }
// $datos['selectnews'] = $this->news->sp_select_task_new();

         $datos['usuario'] = $this->user->sp_user($this->session->userdata('id'));
         $datos['office'] = $this->user->sp_office($this->session->userdata('id'));
         $datos['selectoffice'] = $this->user->sp_select_officce();
         $datos['amigos'] = $this->user->verusername($this->session->userdata('email'));

		$this->load->view('dashboard/profile',$datos);
	}

public function boss()
    {

        $this->form_validation->set_rules('id', 'Identificador', 'required');
        $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');
        if($this->form_validation->run() == FALSE){

            if($this->input->is_ajax_request()) {

                echo json_encode(array('error' => true,'mensaje' => validation_errors()));
                exit();

            }else{

                redirect(base_url());
            }

        }


        $id = $this->input->post("id");
        $usuarios  = $this->user->spi_jefe($this->session->userdata('email'),$id);
        $data = array();

        if(count($usuarios)==0){
              echo json_encode(array("error"=>true,"mensaje"=>"No hay registro en esta oficina"));
              exit;
        }

        foreach ($usuarios as $key) {
            $value["id"] = $key->id_user;
            $value["name"] = $key->name." ".$key->last_name;
            $data[] = $value;
        }
       echo json_encode($data);
    }
***********/

public function perfilgeneral(){

      $this->form_validation->set_rules('id', 'Identificador', 'required');
      $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');
      if($this->form_validation->run() == FALSE){

            if($this->input->is_ajax_request()) {

                echo json_encode(array('error' => true,'mensaje' => validation_errors()));
                exit();

            }else{

                redirect(base_url());
            }

        }



        $usuario  = $this->user->sp_user($this->input->post('id'));
        echo json_encode(array('email'=>$usuario->email,'notificacion'=>$usuario->email_notifications));
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
