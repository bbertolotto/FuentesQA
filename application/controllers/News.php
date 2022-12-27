<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

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

        $this->load->library("session");
        $this->load->library('form_validation');
        $this->load->model("News_model","news");
           $this->load->helper('funciones');


          //  $this->lang->load('header',$this->session->userdata('site_lang'));    
  $site_lang = $this->session->userdata('site_lang');

        if ($site_lang) {
            $this->lang->load('header',$this->session->userdata('site_lang'));
        } else {
            $this->lang->load('header','english');
        }


    }
	public function newsnew()
	{

		$type = "Noticias";
		$fechapublicacion = date("Y-m-d H:i:s");
		$udtails = $_POST["default-textarea"];
		$uid_user = $this->session->userdata('id');
		$usuarios  = $this->user->sp_news($type,$fechapublicacion,$uid_user,$udtails);

		if($usuarios->lv_Resultado == "Error"){
					echo json_encode(array('error' => true,'mensaje' => $usuarios->lv_Mensaje));
          exit();
        }else{
        	echo json_encode(array('mensaje'=>$usuarios->lv_Mensaje));
        }

	}


	public function newsnewubicacion()
	{

		$type = "Noticias";
		$fechapublicacion = date("Y-m-d H:i:s");
		$location = $_POST["latitud"]."|".$_POST["longitud"];
		$uid_user = $this->session->userdata('id');
		$usuarios  = $this->user->sp_newsubicacion($type,$fechapublicacion,$uid_user,$location);

		if($usuarios->lv_Resultado == "Error"){
					echo json_encode(array('error' => true,'mensaje' => $usuarios->lv_Mensaje));
          exit();
        }else{
        	echo json_encode(array('mensaje'=>$usuarios->lv_Mensaje));
        }

	}

	public function notadevoz(){
		print_r($_FILES); //this will print out the received name, temp name, type, size, etc.


$size = $_FILES['audio_data']['size']; //the size in bytes
$input = $_FILES['audio_data']['tmp_name']; //temporary name that PHP gave to the uploaded file
$output = $_FILES['audio_data']['name'].".wav"; //letting the client control the filename is a rather bad idea
   $tipo = $_FILES['audio_data']['type'];

	$fp = fopen($input, 'r+b');
	$data = fread($fp, filesize($input));
	fclose($fp);
    $data = mysqli_real_escape_string($this->get_mysqli(),$data);

      $sqlcall = $this->db->query("INSERT INTO  ta_news (voice,id_user,type_name) VALUES ('".$data."',".$this->session->userdata('id').",'Noticias');");
//move the file from temp name to local folder using $output name
move_uploaded_file($input, $output);
	}

	function compartirfile(){
		  if ( !isset($_FILES["filemodal"]) || $_FILES["filemodal"]["error"] > 0){
                echo json_encode(array('mensaje' => "No tiene imagen cargada",'error'=>false));
                exit;
        } else {

        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
        $limite_kb = 16384;
        if (in_array($_FILES['filemodal']['type'], $permitidos) && $_FILES['filemodal']['size'] <= $limite_kb * 1024){

                // Este es el archivo temporal:
                $imagen_temporal = $_FILES['filemodal']['tmp_name'];
                // Este es el tipo de archivo:
                $tipo = $_FILES['filemodal']['type'];
                // Leer el archivo temporal en binario.
                $fp = fopen($imagen_temporal, 'r+b');
                $data = fread($fp, filesize($imagen_temporal));
                fclose($fp);

                // Escapar los caracteres.
                     $data = mysqli_real_escape_string($this->get_mysqli(),$data);

            
    $sqlcall = $this->db->query("INSERT INTO  ta_news (file,id_user,type_file,type_name) VALUES ('".$data."',".$this->session->userdata('id').",'".$tipo."','Noticias');");
                


             echo json_encode(array('error' => true,'mensaje' => "guardado",'imagen'=>'si imagen'));
        }
    }

	}

	

	function formmodalarchivo(){
		  if ( !isset($_FILES["archivomodaltext"]) || $_FILES["archivomodaltext"]["error"] > 0){
                echo json_encode(array('mensaje' => "No tiene archivo cargado",'error'=>false));
                exit;
        } else {

//        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
        $limite_kb = 16384;
     //   if (in_array($_FILES['filemodal']['type'], $permitidos) && $_FILES['filemodal']['size'] <= $limite_kb * 1024){

                // Este es el archivo temporal:
                $imagen_temporal = $_FILES['archivomodaltext']['tmp_name'];
                // Este es el tipo de archivo:
                $tipo = $_FILES['archivomodaltext']['type'];
                // Leer el archivo temporal en binario.
                $fp = fopen($imagen_temporal, 'r+b');
                $data = fread($fp, filesize($imagen_temporal));
                fclose($fp);

                // Escapar los caracteres.
                     $data = mysqli_real_escape_string($this->get_mysqli(),$data);

            
    $sqlcall = $this->db->query("INSERT INTO  ta_news (file,id_user,type_file,type_name) VALUES ('".$data."',".$this->session->userdata('id').",'".$tipo."','Noticias');");
                


             echo json_encode(array('error' => true,'mensaje' => "guardado",'imagen'=>'si imagen'));
      //  }
    }

	}

   function get_mysqli() { 
$db = (array)get_instance()->db;
return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}


public function imagen_prev($id){
    $this->load->library('image_lib');

    
          $usuario  = $this->news->sp_selectcorrel_news($id);
          $type =  $usuario->type_file;
        $imagen =  $usuario->file;
  //  header("Content-type:". $type);
   // header ("Pragma: no-cache");

        $this->output
        ->set_content_type($type)
         ->set_output($imagen);

      

}

public function comentarios(){
	$id_user = $this->session->userdata('id');
	$comentario = $_POST["profile-newsfeed-comment"];
	$idpublicacion = $_POST["keyid"];
	$tipopublicacion = $_POST["typepublicacion"];
	$consultar = $this->news->sp_secomentarios($id_user,$comentario,$idpublicacion,$tipopublicacion);

$nombreusuario = usuariobuscar($id_user);
	echo json_encode(array("error"=>true,"mensaje"=>"Comentario agregado",'texto'=>$comentario,'usuario'=>$nombreusuario));
}
	
               
	
}
