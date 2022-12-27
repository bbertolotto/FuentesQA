<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
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
    $this->load->model(array("Parameters_model"=>"parameters", "Users_model"=>"users"));

    $this->load->library(array("session", "form_validation", "Mailer.php", "Chat.php"));
    $this->load->helper(array("funciones_helper", "teknodatasystems_helper"));
    $this->data['errores'] = array();

    $site_lang = $this->session->userdata('site_lang');
    if ($site_lang) {$this->lang->load('header',$this->session->userdata('site_lang'));} else {$this->lang->load('header','spanish');}

    date_default_timezone_set('America/Santiago');
}

/*
Begin Admin ta_users
*/
public function users(){

    $result = check_session("5.2.1.1");

    $this->data["roles"] = $this->users->getall_roles();
    $this->data["office"] = $this->parameters->getall_office();
    $this->data["channel"] = $this->parameters->getall_channel();
    $this->data["boss"] = $this->parameters->getall_boss();
    $this->data["parameters"] = $this->parameters->get_generalParameters();

    $this->load->view('users/users',$this->data);
}


public function activity(){
  if($this->session->userdata('lock') === NULL){redirect(base_url());}
  if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
  $this->session->set_userdata('selector', '5.2.1.2');


  $this->load->view('users/activity',$this->data);
}

public function users_list(){

    $result = check_session("");
    $data = array();

    $users = $this->users->getall_users();
    if($users){

        foreach ($users as $key) {
            $accion =  "<a href='#' data-id='".$key->id_user."' class='edit btn btn-danger btn-xs'>Editar</a>&nbsp;<a href='#' data-id='".$key->id_user."' class='deletes btn btn-danger btn-xs'>Eliminar</a>&nbsp;<a href='#' data-id='".$key->id_user."' class='btn btn-success btn-xs unlock'>Desbloquear</a>&nbsp;<a href='#' data-id='".$key->id_user."' class='btn btn-success lock btn-xs'>Bloquear</a>";
            $data[] = array($key->id_user,$key->rut_user,$key->username,$key->name_user,$key->name_office, $key->name_channel, $accion);
        }

    }

    $datos = array("data"=>$data);
    echo json_encode($datos);
}

public function eventlog(){

    $result = check_session("5.2.1.3");

    $this->data["users"] = $this->users->getall_users();
    $this->data["result"] = '<option value="">[TODOS]</option><option value="OK">OK</option><option value="ERROR">ERROR</option>';
    $this->data["roles"] = $this->users->getall_roles();
    $this->data["office"] = $this->parameters->getall_office();
    $this->data["date_begin"] = date("d-m-Y");
    $this->data["date_end"] = date("d-m-Y");
    $this->data["parameters"] = $this->parameters->get_generalParameters();

    $this->load->view('users/eventlog',$this->data);
}

public function list_log(){

    $this->form_validation->set_rules('dateBegin', 'Fecha termino busqueda', 'required|trim');
    $this->form_validation->set_rules('dateEnd', 'Fecha inicio busqueda', 'required|trim');
    $this->form_validation->set_rules('username', 'Usuario Transacción', 'trim');
    $this->form_validation->set_rules('result', 'Resultado Transacción', 'trim');

    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('max_length','El atributo %s excede máximo permitido');
    if($this->form_validation->run()==false){
        $value['retorno'] = COD_ERROR_INIT;
        $value['descRetorno'] = validation_errors();
        $value['action'] = "";
        $this->data["dataResult"] = $value;
        echo json_encode($this->data);
        exit(0);
    }

    ini_set("memory_limit","4096M");
    $dateBegin = explode("-", $this->input->post("dateBegin"));
    $dateEnd = explode("-", $this->input->post("dateEnd"));

    $dataInput = array(
        "dateBegin" => $dateBegin[2] . "-" . $dateBegin[1] . "-" . $dateBegin[0],
        "dateEnd" => $dateEnd[2] . "-" . $dateEnd[1] . "-" . $dateEnd[0],
        "username" => $this->input->post("username"),
        "result" => $this->input->post("result"),
    );

    $events = $this->users->getall_log($dataInput);

    $data = array(); $response = array();
    if($events!=false){

        foreach ($events as $key) {

            $code["dateBegin"] = date("d-m-Y H:i", strtotime($key->date_begin));
            $code["dateEnd"] = date("d-m-Y H:i", strtotime($key->date_end));
            $code["begin"] = date("d-m-Y", strtotime($key->date_begin));
            $code["username"] = $key->username;
            $code["time"] = $key->time;
            $code["endPoint"] = "<textarea class='form-control endPoint' readonly cols='20'>".substr($key->endPoint,28)."</textarea>";
            $code["action"] = $key->action;
            $code["request"] = "<textarea class='form-control request' readonly cols='20'>".$key->request."</textarea>";
            $code["response"] = "<textarea class='form-control response' readonly>".$key->response."></textarea>";
            $code["result"] = $key->result;
            $data[] = $code;
        }

        $result["retorno"] = 0;
        $result["descRetorno"] = "Transacción Aceptada..!";

    }else{

        $result["retorno"] = 1;
        $result["descRetorno"] = "No hay transacciones para filtro seleccionado..!";
    }


    $value["retorno"] = $result["retorno"];
    $value["descRetorno"] = $result["descRetorno"];

    $this->data["dataResult"] = $value;
    $this->data["dataResponse"] = $data;
 
    echo json_encode($this->data);

}

public function users_delete(){

    $result = check_session("");

    $this->form_validation->set_rules('id', 'Identificación Usuario', 'required|trim');

    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('max_length','El atributo %s excede máximo permitido');
    if($this->form_validation->run()==false){
        $this->cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $result = $this->users->delete($this->input->post("id"));
    echo json_encode($result);
}

public function users_locked(){

    $result = check_session("");

    $this->form_validation->set_rules('id', 'Identificación Usuario', 'required|trim');

    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('max_length','El atributo %s excede máximo permitido');
    if($this->form_validation->run()==false){
        $this->cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $result = $this->users->locked($this->input->post("id"));
    echo json_encode($result);
}


public function users_unlock(){

    $result = check_session("");

    $this->form_validation->set_rules('id', 'Identificación Usuario', 'required|trim');

    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('max_length','El atributo %s excede máximo permitido');
    if($this->form_validation->run()==false){
        $this->cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $result = $this->users->unlock($this->input->post("id"));
    echo json_encode($result);
}


public function users_search(){

    $result = check_session("");

    $this->form_validation->set_rules('id', 'Identificación Usuario', 'required|trim');

    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('max_length','El atributo %s excede máximo permitido');
    if($this->form_validation->run()==false){
        $this->cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $result = $this->users->get_usersById($this->input->post("id"));
    if(!$result){

        $data["retorno"] = EXIT_ERROR;
        $data["descRetorno"] = "No existe registro usuario..!";

    }else{

        $data["retorno"] = EXIT_SUCCESS;
        $data["descRetorno"] = "Transacción Aceptada";
        $data["id_user"] = $result->id_user;
        $data["rut_user"] = $result->rut_user;
        $data["name"] = $result->name;
        $data["last_name"] = $result->last_name;
        $data["email"] = $result->email;
        $data["username"] = $result->username;
        $data["id_office"] = $result->id_office;
        $data["id_rol"] = $result->id_rol;
        $data["id_boss"] = $result->id_boss;
        $data["id_user_boss"] = $result->id_user_boss;
        $data["id_manager"] = $result->id_manager;
        $data["number_phone"] = $result->number_phone;
        $data["name_channel"] = $result->name_channel;
        $data["attention_mode"] = $result->attention_mode;
    }

    echo json_encode(array($data));
}

public function users_edit(){
    $id = $_POST["id_item"];
    $name_item = $_POST["name_iteme"];
    $value_min = $_POST["value_mine"];
    $value_max = $_POST["value_maxe"];

    $this->deferred->edit($name_item,$value_min,$value_max,$id);
    echo json_encode(array($name_item,$value_min,$value_max));
}

public function users_add(){

    $name_item = $_POST["name_item"];
    $value_min = $_POST["value_min"];
    $value_max = $_POST["value_max"];
    $name_root = "Cuotas Diferidas Producto";
    $this->deferred->add($name_root,$name_item,$value_min,$value_max);
   // echo json_encode(array($name_item,$value_min,$value_max));
    redirect(base_url("users/users"));
}


public function add_users(){

    $nroRut = str_replace('.', '', $_POST["masked_rut_users"]);
    $validadorrut = explode("-", $nroRut);
    $contar = count($validadorrut);
    if($contar == 2){
       $validador = $validadorrut[1];
    }else{
       $validador = "";
    }
    $nroRut = str_replace('-', '', $nroRut);
    $nroRut = substr($nroRut, 0, -1);

    $this->db->where('email',$_POST["emailUsers"]);
    $querycontar  =   $this->db->get('ta_users');
    
 //echo json_encode(count($querycontar->result()));
 //exit;

    $data = array(
      'rut_number'=>$nroRut,
      'rut_validation'=>$validador,
      'name'=>$_POST["nameUsers"],
      'last_name' => $_POST["lastnameUsers"],
      'email'=>$_POST["emailUsers"],
      'username' => $_POST["usernameUsers"],
      'id_office' => $_POST["officeUsers"],
      'id_rol' => $_POST["rolUsers"],
      'id_manager'=>$_POST["ismanagerUsers"],
      'id_boss'=>$_POST["isbossUsers"],
      'number_phone'=>$_POST["phoneUsers"],
      'password'=>md5($_POST["passwordUsers"]),
      'id_user_boss'=>$_POST["bossUsers"],
      'attention_mode'=>$_POST["attention_mode"]
    );

    $channelUsers       = $_POST["channelUsers"];

    if(count($querycontar->result()) == 0){
        $this->users->insertar($data,$channelUsers);
        echo json_encode(array("retorno"=>1,"descRetorno"=>"Usuario agregado"));
    }else{
        echo json_encode(array("retorno"=>0,"descRetorno"=>"Este Correo ya se encuentra registrado"));
    }
}

private function cancel_function ($retorno, $descRetorno, $action) {
    $value['retorno'] = $retorno;
    $value['descRetorno'] = $descRetorno;
    $value['action'] = $action;
    $data = $value;
    echo json_encode($data);
    exit(0);
}

public function edit_users(){

    $this->form_validation->set_rules('masked_rut_users', 'Rut Usuario', 'required|max_length[12]|trim');
    $this->form_validation->set_rules('nameUsers', 'Nombre Usuario', 'required|trim');
    $this->form_validation->set_rules('lastnameUsers', 'Apellidos Usuario', 'required|trim');
    $this->form_validation->set_rules('emailUsers', 'Email Acceso Sistema', 'required|valid_email|trim');
    $this->form_validation->set_rules('usernameUsers', 'Identificación Usuario', 'required|trim');
    $this->form_validation->set_rules('officeUsers', 'Oficina Usuario', 'required|trim');
    $this->form_validation->set_rules('rolUsers', 'Rol del Usuario', 'required|trim');
    $this->form_validation->set_rules('attention_mode', 'Modo de Atención', 'required|trim');
    $this->form_validation->set_rules('id_user', 'Identificación Usuario', 'required|trim');
    $this->form_validation->set_rules('bossUsers', 'Jefe del Usuario', 'required|trim');

    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('max_length','El atributo %s excede máximo permitido');
    if($this->form_validation->run()==false){
        $this->cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = str_replace('.', '', $_POST["masked_rut_users"]);
    $nroRut = str_replace('-', '', $nroRut);
    $dgvRut = substr($nroRut, -1); $nroRut = substr($nroRut, 0, -1);

    $data = array(
      'id_user'=>$_POST["id_user"],
      'rut_number'=>$nroRut,
      'rut_validation'=>$dgvRut,
      'name'=>$_POST["nameUsers"],
      'last_name' => $_POST["lastnameUsers"],
      'email'=>$_POST["emailUsers"],
      'username' => $_POST["usernameUsers"],
      'id_office' => $_POST["officeUsers"],
      'id_rol' => $_POST["rolUsers"],
      'id_manager'=>$_POST["ismanagerUsers"],
      'id_boss'=>$_POST["isbossUsers"],
      'number_phone'=>$_POST["phoneUsers"],
      'password'=>$_POST["passwordUsers"],
      'id_user_boss'=>$_POST["bossUsers"],
      'attention_mode'=>$_POST["attention_mode"]
    );

    $channelUsers       = $_POST["channelUsers"];
    $this->users->editar($data, $channelUsers);

    $data["retorno"] = 0;
    $data["descRetorno"] = "Registro Modificado Correctamente...!";

    echo json_encode($data);
}

public function unlock_password(){

    $result = check_session("");
    $idusuario    = $this->input->post("id");
    $this->users->unlock($idusuario);
    echo json_encode("Reset Clave aceptado..!");
}

/*
End Admin ta_users
*/


public function index(){

	$this->load->view('users/users');
}


public function list(){

    $usuarios = $this->user->listado_user();
    $roles = $this->user->getAllroles();

    $data = array();
    foreach ($usuarios as $key) {
    	$myrol = $roles[$key["id_rol"]]["descripcion"];
        $accion =  "<a href='#' class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModaledit' data-id='".$key["id_user"]."'>Editar</a><a href='#'  data-id='".$key["id_user"]."' class='deletes btn btn-danger btn-xs'>Eliminar</a>";
        $data[] = array($key["name"],$key["last_name"],$key["email"],$myrol,$accion);
    }
    $datos = array("data"=>$data);
    echo json_encode($datos);

}

public function add() {

	$this->form_validation->set_rules('email', 'Correo', 'required|valid_email');
	$this->form_validation->set_rules('password', 'Clave', 'required');

	$this->form_validation->set_rules('nombre', 'Primer nombre', 'required');
	$this->form_validation->set_rules('apellido', 'Segundo nombre', 'required');

  $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');
  $this->form_validation->set_message('trimming', 'Ingrese %s sin espacios');
  $this->form_validation->set_message('matches', 'La Clave no coincide');

  if ($this->form_validation->run() == FALSE)
  {
      echo json_encode(array('error' => true,'mensaje' => validation_errors()));
      exit();
  }


      $email = $_POST["email"];
    	$clave = md5($_POST["password"]);
    	$nombre = $_POST["nombre"];
    	$apellido = $_POST["apellido"];
    	$rol = $_POST["rolesadd"];

    	$datos = array("name"=>$nombre,'last_name'=>$apellido,'password'=>md5($clave),'email'=>$email,'id_rol'=>$rol);
    	$valor = $this->user->add_user($email,$datos);


    	if($valor == true){
    		$idusername =  $this->db->insert_id();

          /*  $chatgeneral = $this->chat->load($this->config->item('instancia'),$this->config->item('keysecuritychat'));
            $usuariokit = $chatgeneral->createUser([
                'id' => $idusername,
                'name' => $nombre." ".$apellido
            ]);
            $saladd = $this->config->item('salaconectar');
            $chatgeneral->addUsersToRoom([
                    'user_ids' => [$idusername],
                    'room_id' => $saladd
            ]);

            $usernamebuscar = $this->user->verusername($email);

             //$chatgeneral = $this->chat->load();
            if(count($usernamebuscar)>0){
            foreach ($usernamebuscar as $key) {

                $chatgeneral = $this->chat->load($this->config->item('instancia'),$this->config->item('keysecuritychat'));
                $valores2 = $chatgeneral->createRoom([
                    'creator_id' => $idusername,
                    'name' => $idusername." - ".$key->id_user,
                    'private' => true,
                    'user_ids' => [$idusername,$key->id_user]
                ]);

                $nsala2 =  $valores2["body"]["id"];



                $this->user->sp_salas_insert($idusername,$key->id_user,$nsala2);

            }
        }*/


 			echo json_encode(array('error' => false,'mensaje' => 'Usuario almacenado',$idusername));

 		}else{
 			echo json_encode(array('error' => true,'mensaje' => 'Este email ya se encuentra registrado'));
 		}

    }


public function edit() {
	$this->form_validation->set_rules('emailedit', 'Correo', 'required|valid_email');
	$this->form_validation->set_rules('passwordedit', 'Clave', 'required');

	$this->form_validation->set_rules('nombreedit', 'Primer nombre', 'required');
	$this->form_validation->set_rules('apellidoedit', 'Segundo nombre', 'required');

  $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');
  $this->form_validation->set_message('trimming', 'Ingrese %s sin espacios');
  $this->form_validation->set_message('matches', 'La Clave no coincide');

  if ($this->form_validation->run() == FALSE)
  {
      echo json_encode(array('error' => true,'mensaje' => validation_errors()));
      exit();
  }


      $email = $_POST["emailedit"];
    	$clave = md5($_POST["passwordedit"]);
    	$nombre = $_POST["nombreedit"];
    	$apellido = $_POST["apellidoedit"];
    	$rol = $_POST["rolesaddedit"];
$iditems = $_POST["iditems"];
    	$datos = array("name"=>$nombre,'last_name'=>$apellido,'password'=>md5($clave),'email'=>$email,'id_rol'=>$rol);
    	$valor = $this->user->edit_user($iditems,$email,$datos);
    	if($valor == true){
 			echo json_encode(array('error' => false,'mensaje' => 'Usuario modificado'));
 		}else{
 			echo json_encode(array('error' => true,'mensaje' => 'Este email ya se encuentra registrado'));
 		}

    }


    public function delete(){
   $this->user->delete_users($_GET["id"]);
   echo  json_encode("eliminado");
}


}
