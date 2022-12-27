<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
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

  $this->load->model(array("Usuario_model"=>"user", "Channel_model"=>"chanel", "Parameters_model"=>"parameters"));
  $this->load->library(array('session', 'form_validation', 'Mailer.php', 'Chat.php'));
  $this->load->helper( array('teknodatasystems_helper') );

  $site_lang = $this->session->userdata('site_lang');
  if ($site_lang) {
	$this->lang->load('header',$this->session->userdata('site_lang'));
  }else{$this->lang->load('header','spanish');}

  date_default_timezone_set('America/Santiago');

}

public function index(){

    $this->session->set_userdata('login', 'init');
    $data["parameters"] = $this->parameters->get_generalParameters();
	$this->load->view('login/login', $data);

}

public function validar(){

    $this->form_validation->set_rules('login-username', 'Email', 'required');
    $this->form_validation->set_rules('login-password', 'Clave', 'required');

    $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');
    $this->form_validation->set_message('integer', 'El atributo %s debe contener solo n&#250;meros enteros');
    $this->form_validation->set_message('max_length', 'El atributo %s debe tener un M&#225;ximo de %d Car&#225;cteres');

    if($this->form_validation->run()!=FALSE){

        $clean = strtr( $this->input->post('login-password'), ' ', '+');
        $login_password = base64_decode( $clean );

        $datos = $this->user->spi_login_successful_entry($this->input->post("login-username"),$login_password);

        if($datos->lv_Resultado != "Error"){

            $usuarios = $this->user->versalas($datos->lv_ID); 
            $users = $this->user->sp_email($datos->lv_email);
            $channel = $this->user->sp_chanel($users->id_user);

            $this->session->set_userdata('id_user', $users->id_user);
            $this->session->set_userdata('id', $users->id_user);
            $this->session->set_userdata('email', $users->email);
            $this->session->set_userdata('nombre', $users->name." ".$users->last_name);
            $this->session->set_userdata('id_office', $users->id_office);
            $this->session->set_userdata('email_system', $users->email_system);
            $this->session->set_userdata('email_notifications', $users->email_notifications);
            $this->session->set_userdata('number_whatsapp', $users->number_whatsapp);
            $this->session->set_userdata('rut_number', $users->rut_number);
            $this->session->set_userdata('rut_validation', $users->rut_validation);
            $this->session->set_userdata('number_phone', $users->number_phone);
            $this->session->set_userdata('avatar', $users->avatar);
            $this->session->set_userdata('usernamelistado', $usuarios);
            $this->session->set_userdata('id_rol', $users->id_rol);
            $this->session->set_userdata('username', $users->username);
            $this->session->set_userdata('lock', $users->numberlock);
            $this->session->set_userdata('id_manager', $users->id_manager);
            $this->session->set_userdata('attention_mode', $users->attention_mode);
            $this->session->set_userdata('id_channel', $channel->channel);

            $usuariosusername = $this->user->getid();
            $this->session->set_userdata('usuariosusername', $usuariosusername);
            $fechahoy = date("d-m-Y H:i:s");
            $this->user->sp_lastlogin($fechahoy,$users->id_user);
            $oficina = $this->parameters->get_officeById($users->id_office);
            $roles   = $this->parameters->get_rolById($users->id_rol);

            $this->session->set_userdata('nombreoficina',$oficina->name);
            $this->session->set_userdata('nombreroles',$roles->descripcion);
               
            $currentUser = array(
                'id' => $users->id_user,
                'email' => $users->email,
                'nombre' => $users->name." ".$users->last_name,
                'id_rol' => $users->id_rol
            );

            $this->session->set_userdata('current_user', $currentUser);

            redirect( base_url() . "access"); 

        }

        $login_error_message = $datos->lv_Mensaje;

    }else{

        $login_error_message =  'Email y Clave son obligatorios..!';
    }

    $this->session->set_userdata('login', 'invalid');
    $this->session->set_userdata('login-error-title', 'Error de Seguridad');
    $this->session->set_userdata('login-error-message', $login_error_message);

    $data["parameters"] = $this->parameters->get_generalParameters();
    $this->load->view('login/login', $data);
}

public function signout() {

    $this->load->library('session');

    $datos = $this->user->spi_login_signout($this->session->userdata("id"));

    $this->session->unset_userdata('id');
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('nombre');
    $this->session->unset_userdata('id_rol');
    $this->session->sess_destroy();

    header('Location: ' . base_url());
}

public function unlock() {

    $this->form_validation->set_rules('lock-password', 'Clave', 'required');
    $this->form_validation->set_rules('email', 'Username', 'required');
    $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');

    $continue = true;

    if ($this->form_validation->run()!=FALSE){

        if($this->input->post("email")!=$this->session->userdata("email")){

            $login_error_message = MESSAGE_EXIT_INVALID_CREDENTIAL;
            $continue = false;
        }

        if($continue){

            $clean = strtr( $this->input->post('lock-password'), ' ', '+');
            $login_password = base64_decode( $clean );

            $datos = $this->user->spi_login_successful_entry($this->input->post("email"),$login_password);

            if($datos->lv_Resultado != "Error"){

                $usuarios = $this->user->versalas($datos->lv_ID); 
                $users = $this->user->sp_email($datos->lv_email);
                $channel = $this->user->sp_chanel($users->id_user);

                $this->session->set_userdata('id_user', $users->id_user);
                $this->session->set_userdata('id', $users->id_user);
                $this->session->set_userdata('email', $users->email);
                $this->session->set_userdata('nombre', $users->name." ".$users->last_name);
                $this->session->set_userdata('id_office', $users->id_office);
                $this->session->set_userdata('email_system', $users->email_system);
                $this->session->set_userdata('email_notifications', $users->email_notifications);
                $this->session->set_userdata('number_whatsapp', $users->number_whatsapp);
                $this->session->set_userdata('rut_number', $users->rut_number);
                $this->session->set_userdata('rut_validation', $users->rut_validation);
                $this->session->set_userdata('number_phone', $users->number_phone);
                $this->session->set_userdata('avatar', $users->avatar);
                $this->session->set_userdata('usernamelistado', $usuarios);
                $this->session->set_userdata('id_rol', $users->id_rol);
                $this->session->set_userdata('username', $users->username);
                $this->session->set_userdata('lock', $users->numberlock);
                $this->session->set_userdata('id_manager', $users->id_manager);
                $this->session->set_userdata('attention_mode', $users->attention_mode);
                $this->session->set_userdata('id_channel', $channel->channel);

                $usuariosusername = $this->user->getid();
                $this->session->set_userdata('usuariosusername', $usuariosusername);
                $fechahoy = date("d-m-Y H:i:s");
                $this->user->sp_lastlogin($fechahoy,$users->id_user);
                $oficina = $this->parameters->get_officeById($users->id_office);
                $roles   = $this->parameters->get_rolById($users->id_rol);

                $this->session->set_userdata('nombreoficina',$oficina->name);
                $this->session->set_userdata('nombreroles',$roles->descripcion);
                   
                $currentUser = array(
                    'id' => $users->id_user,
                    'email' => $users->email,
                    'nombre' => $users->name." ".$users->last_name,
                    'id_rol' => $users->id_rol
                );

                $this->session->set_userdata('current_user', $currentUser);

                redirect( base_url() . "access"); 

            }    

            $login_error_message = $datos->lv_Mensaje;

        }

    }else{

        $login_error_message = 'Clave son obligatorios..!';
    }

    $data["parameters"] = $this->parameters->get_generalParameters();

    $this->session->set_userdata('login', 'invalid');
    $this->session->set_userdata('login-error-title', 'Error de Seguridad');
    $this->session->set_userdata('login-error-message', $login_error_message);
    $this->load->view('dashboard/lock', $data);

}

public function register() {

	$this->form_validation->set_rules('register-email', 'Correo', 'required|valid_email');
	$this->form_validation->set_rules('register-password', 'Clave', 'required');
	$this->form_validation->set_rules('register-password-verify', 'Verificar Clave', 'required|matches[register-password]');
	$this->form_validation->set_rules('register-firstname', 'Primer nombre', 'required');
	$this->form_validation->set_rules('register-lastname', 'Segundo nombre', 'required');

    $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');
    $this->form_validation->set_message('trimming', 'Ingrese %s sin espacios');
    $this->form_validation->set_message('matches', 'La Clave no coincide');
    $this->form_validation->set_message('valid_email','El atributo %s no es valido.');

    if($this->form_validation->run()==false){

      if($this->input->is_ajax_request()) { 

            echo json_encode(array('error' => true,'mensaje' => validation_errors()));
            exit();

      }else{

            redirect(base_url()); 
      }

    }

      $email = $_POST["register-email"];
    	$clave = md5($_POST["register-password"]);
    	$nombre = $_POST["register-firstname"];
    	$apellido = $_POST["register-lastname"];

    	$consultar = $this->user->spi_login_key_error($email);

    	if($consultar->lv_Resultado == "OK"){
    		echo json_encode(array('error' => true,'mensaje' => 'Email ya registrado..!'));
    		exit;
    	}
        $datos = $this->user->sp_login_register2($nombre,$apellido,$email,$clave);
        $idusername =  $datos->lv_id_insert;

            $chatgeneral = $this->chat->load($this->config->item('instancia'),$this->config->item('keysecuritychat'));
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
            }

			//$datos = $this->user->sp_login_register2($nombre,$apellido,$email,$clave);
			if($datos->lv_Resultado == "Error"){
        		echo json_encode(array('error' => true,'mensaje' => 'Este registro no se encuentra'));
    		}else{
    			echo json_encode(array('mensaje' => $datos->lv_Mensaje));
    		}
    }


public function email(){

    $this->form_validation->set_rules('reminder-email', 'Correo', 'required|valid_email');

    $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');
    $this->form_validation->set_message('valid_email','El atributo %s no es valido.');

    if($this->form_validation->run()==false){

      if($this->input->is_ajax_request()) { 

            echo json_encode(array('error' => true,'mensaje' => validation_errors()));
            exit();

      }else{

            redirect(base_url()); 
      }

    }


	$email = $_POST["reminder-email"];

	$consultar = $this->user->spi_login_key_error($email);
	if($consultar->lv_Resultado == "Error"){
		echo json_encode(array('error' => true,'mensaje' => $consultar->lv_Mensaje));
		exit;
	}else{
		$newclave = rand(1000000, 9999999);
	  $clave = md5($newclave);
		$this->user->spi_login_clave_update($clave,$email);
		$mail = $this->mailer->load();

		// SMTP configuration
		$mail->isMail();
		$mail->Host = 'mail.smstd.cl';
		$mail->SMTPAuth = true;
		$mail->Username = 'patricio@smstd.cl';
		$mail->Password = 'patricio2019';
		$mail->SMTPSecure = 'tls';
		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true)
		);
		$mail->Port = 465;
		$mail->Priority = 1;
	  $mail->setFrom($email, 'smstd.cl');
	  $mail->addAddress($email);

		// Email subject
	  $mail->Subject = 'Recuperacion de clave';
		// Set email format to HTML
	  $mail->isHTML(true);
	  // Email body content
	  $mailContent = "<p>Tu nueva clave es: ".$newclave." </p>";
	  $mail->Body = $mailContent;
	  if(!$mail->send()){
	      echo json_encode(array('error' => true,'mensaje' => "Error, enviando email, ".$mailContent));
	  }else{
	    	echo json_encode(array('error' => true,'mensaje' => "Nueva clave enviada a su cuenta email..!"));
	  }
  	exit;
	}
}

public function perfil(){

    $result = check_session("");

    $this->form_validation->set_rules('id', 'Identificador', 'required');
    $this->form_validation->set_rules('user-settings-password', 'Nueva Clave', 'trim');
    $this->form_validation->set_rules('user-settings-repassword', 'Confirma Nueva Clave', 'trim');
    $this->form_validation->set_rules('user-settings-locktime', 'Tiempo espera bloqueo escritorio', 'required');

    $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');

    if($this->form_validation->run() == FALSE){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(),"");
    }

    if($this->session->userdata("id_user")!=$this->input->post("id")){

        cancel_function(COD_ERROR_VALID_FORM, MESSAGE_EXIT_INVALID_CREDENTIAL,"");
    }

    if($this->input->post("user-settings-password")!=$this->input->post("user-settings-repassword")){

        cancel_function(COD_ERROR_VALID_FORM, "Nueva Clave y Clave confirmación son distintas..!","");
    }

    if(isset($_POST['user-settings-notifications-type'])) { $activado= 1; } else { $activado = 0; }

    $datos = $this->user->sp_setting(
                                    $this->input->post('user-settings-email'), 
                                    "",
                                    $this->input->post('user-settings-password'),
                                    $this->input->post('id'), 
                                    $this->input->post('user-settings-locktime'),
                                    $this->input->post('user-settings-attention') );


    if($datos->lv_Resultado != "Error"){

        $this->session->set_userdata('email_system', "");
        $this->session->set_userdata('lock', $this->input->post('user-settings-locktime'));
        $this->session->set_userdata('email_notifications', "");
        $this->session->set_userdata('attention_mode', $this->input->post('user-settings-attention'));

        if(isset($_FILES["imagen"]) OR $_FILES["imagen"]["error"] == 0){

            $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
            $limite_kb = 16384;
            if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024){

                $imagen_temporal = $_FILES['imagen']['tmp_name'];
                $tipo = $_FILES['imagen']['type'];
                $fp = fopen($imagen_temporal, 'r+b');
                $data = fread($fp, filesize($imagen_temporal));
                fclose($fp);
                $data = mysqli_real_escape_string($this->get_mysqli(),$data);

                $consulta=$this->db->query("UPDATE ta_users  set avatar = '".$data."',type_imagen = '".$tipo."'  WHERE id_user = ".$this->session->userdata('id'));

                $consultarusername = $this->user->sp_user($this->session->userdata('id'));
                $this->session->set_userdata('avatar', $consultarusername->avatar);
                
            }
        }

    }else{

        cancel_function(EXIT_ERROR, $datos->lv_Mensaje,"");

    }

    cancel_function(EXIT_SUCCESS, "Configuración datos perfil actualizada..!","");

}

function get_mysqli() { $db = (array)get_instance()->db; return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}

public function imagen_prev($id=0){

    if($id==0){

      if($this->input->is_ajax_request()) { 

        echo json_encode(array('error' => true,'mensaje' => validation_errors()));
        exit();

      }else{

            redirect(base_url()); 
      }

    }


    $this->load->library('image_lib');
    $usuario  = $this->user->sp_user($id);
    $type =  $usuario->type_imagen;
    $imagen =  $usuario->avatar;

        $this->output
        ->set_content_type($type)
         ->set_output($imagen);

}


public function autenticar(){

    $this->form_validation->set_rules('user_id', 'Correo', 'required');
    $this->form_validation->set_message('required', 'Ingrese %s es obligatorio');

    if($this->form_validation->run()==false){

      if($this->input->is_ajax_request()) { 

            echo json_encode(array('error' => true,'mensaje' => validation_errors()));
            exit();

      }else{

            redirect(base_url()); 
      }

    }


    $chatgeneral = $this->chat->load($this->config->item('instancia'),$this->config->item('keysecuritychat'));
    $valores = $chatgeneral->authenticate([ 'user_id' => $_GET["user_id"] ]);
    //$valores = $chatgeneral->authenticate([ 'user_id' => $this->session->userdata('username') ]);


/*    $valores["instance"] = 'v1:us1:34cd9703-3127-4406-97ea-ea92c6054830';
    $valores["iss"] = "2210481e-1566-4ac8-9a7e-acce64af6a7f:dBy0Xcj3RCGTnh9GvnfEjTlAj2R37BpzgpG6FovhTDM=";
    $valores["iat"] = 1508752709;
    $valores["exp"] = 1508839109;
    $valores["sub"] =  "elgranjm";*/

//dump($valores);

//var_dump($valores['status']);
echo  json_encode($valores["body"]);


    }

}
