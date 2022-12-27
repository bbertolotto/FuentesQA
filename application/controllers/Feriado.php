<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feriado extends CI_Controller {
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
  $this->load->model("Usuario_model","user");
    $this->load->model("Feriado_model","feriados");

  $this->load->library("session");
  $this->load->library('form_validation');
  $this->load->library('Mailer.php');
  $this->load->library('Chat.php');
  $site_lang = $this->session->userdata('site_lang');
  if ($site_lang) {
	$this->lang->load('header',$this->session->userdata('site_lang'));
  }else{$this->lang->load('header','spanish');}

}


public function index(){
	$this->load->view('feriado/feriado');

}

public function addferiado(){
  $nombre = $_POST["name"];
  $fecha = $_POST["fecha"];
$fechanew = date("Y-m-d", strtotime($fecha));

$anno = date("Y", strtotime($fecha));

$diamas = strtotime ( '+1 day' , strtotime ( $fechanew ) ) ;
$diamas1 = date ( 'Ymd' , $diamas );
$diamenos = strtotime ( '-1 day' , strtotime ( $fechanew ) ) ;
$diamenos1 = date ( 'Ymd' , $diamenos );
$this->feriados->addferiado($nombre,$anno,$fechanew,$diamenos1,$diamas1);


$diamas1 =  $_POST["fechasiguiente"];
$diamenos1 =  $_POST["fechaanterior"];

echo json_encode(array($fechanew,$diamas1,$diamenos1));


}


public function editferiado(){
   $id = $_POST["iditems"];
    $nombre = $_POST["nameedit"];
  $fecha = $_POST["fechaedit"];
$fechanew = date("Y-m-d", strtotime($fecha));

$anno = date("Y", strtotime($fecha));

$diamas = strtotime ( '+1 day' , strtotime ( $fechanew ) ) ;
$diamas1 = date ( 'Ymd' , $diamas );
$diamenos = strtotime ( '-1 day' , strtotime ( $fechanew ) ) ;
$diamenos1 = date ( 'Ymd' , $diamenos );


$diamas1 =  date ( 'Ymd' , strtotime($_POST["fechasiguienteedit"]) ); 
$diamenos1 =  date ( 'Ymd' , strtotime($_POST["fechaanterioredit"]) ); 


$this->feriados->editferiado($nombre,$anno,$fechanew,$diamenos1,$diamas1,$id);




echo json_encode(array($fechanew,$diamas1,$diamenos1));
}

public function buscar(){
  $id = $_POST["id"];
  
$valor = $this->feriados->buscar($id);

$data["id_item"] = $valor->id_item;
$data["nombre"] = $valor->name_item;
$data["fechanterior"] =  $rest = substr($valor->value_min, 4, 2)."/".$rest = substr($valor->value_min, 6, 2)."/".$rest = substr($valor->value_min, 0, 4);
$data["fechasiguiente"] = $rest = substr($valor->value_max, 4, 2)."/".$rest = substr($valor->value_max, 6, 2)."/".$rest = substr($valor->value_max, 0, 4);



$data["fecha"] = date("m/d/Y", strtotime($valor->value_date));


echo json_encode(array($data));


}



public function listado(){
  $feriados = $this->feriados->listadoferiado();
  $data = array();

  foreach ($feriados as $key) {




$accion =  "<a href='#' class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModaledit' data-id='".$key->KEY."'>Editar</a><a href='#'  data-id='".$key->KEY."' class='deletes btn btn-danger btn-xs'>Eliminar</a>";


      $data[] = array($key->NAME,$key->PERIODO,$key->FECHA,$key->DIA_HABIL_ANTERIOR,$key->DIA_HABIL_SIGUIENTE,$accion);
  }


    $datos = array("data"=>$data);
        echo json_encode($datos);

}


public function delete(){
   $this->feriados->delete($_GET["id"]);

           echo  json_encode("eliminado");
}


	
}
