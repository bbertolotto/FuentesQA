<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parameters extends CI_Controller {

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
    $this->load->model("Holidays_model","holidays");
    $this->load->model("Rejection_model","rejection");
    $this->load->model("Deferred_model","deferred");
    $this->load->library('form_validation');

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}
}

public function index(){
    if($this->session->userdata('lock') === NULL){redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
    $this->session->set_userdata('selector', '5.1.2.1');
    $this->load->view('parameters/holidays');
}
public function holidays(){
    if($this->session->userdata('lock') === NULL){redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
    $this->session->set_userdata('selector', '5.1.2.1');
    $this->load->view('parameters/holidays');
}

public function holidays_list(){
    $feriados = $this->holidays->flist();
    $data = array();
    foreach ($feriados as $key) {
        $accion =  "<a href='#' class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModaledit' data-id='".$key->KEY."'>Editar</a><a href='#'  data-id='".$key->KEY."' class='deletes btn btn-danger btn-xs'>Eliminar</a>";
        $data[] = array($key->NAME,$key->PERIODO,$key->FECHA,$key->DIA_HABIL_ANTERIOR,$key->DIA_HABIL_SIGUIENTE,$accion);
    }
    $datos = array("data"=>$data);
    echo json_encode($datos);
}

public function holidays_delete(){
   $this->holidays->delete($_GET["id"]);
   echo  json_encode("eliminado");
}

public function holidays_search(){
    $id = $_POST["id"];
    $valor = $this->holidays->search($id);

    $data["id_item"] = $valor->id_item;
    $data["nombre"] = $valor->name_item;
    $data["fechanterior"] =  $rest = substr($valor->value_min, 4, 2)."/".$rest = substr($valor->value_min, 6, 2)."/".$rest = substr($valor->value_min, 0, 4);
    $data["fechasiguiente"] = $rest = substr($valor->value_max, 4, 2)."/".$rest = substr($valor->value_max, 6, 2)."/".$rest = substr($valor->value_max, 0, 4);
    $data["fecha"] = date("m/d/Y", strtotime($valor->value_date));
    echo json_encode(array($data));
}

public function holidays_edit(){
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

    $this->holidays->edit($nombre,$anno,$fechanew,$diamenos1,$diamas1,$id);
    echo json_encode(array($fechanew,$diamas1,$diamenos1));
}

public function holidays_add(){
    $nombre = $_POST["name"];
    $fecha = $_POST["fecha"];
    $fechanew = date("Y-m-d", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    
    $diamas = strtotime ( '+1 day' , strtotime ( $fechanew ) ) ;
    $diamas1 = date ( 'Ymd' , $diamas );
    $diamenos = strtotime ( '-1 day' , strtotime ( $fechanew ) ) ;
    $diamenos1 = date ( 'Ymd' , $diamenos );
    $this->holidays->add($nombre,$anno,$fechanew,$diamenos1,$diamas1);

    $diamas1 =  $_POST["fechasiguiente"];
    $diamenos1 =  $_POST["fechaanterior"];

    echo json_encode(array($fechanew,$diamas1,$diamenos1));
}

/*
 * Administración Tabla Glosas Motivos de Rechazo 
 * TA_GLOSSARY
 * VI__REJECTION 
 */
public function rejection(){
    if($this->session->userdata('lock') === NULL){redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
    $this->session->set_userdata('selector', '5.1.2.2');
    $this->load->view('parameters/rejection');
}

public function rejection_list(){
    $rejection = $this->rejection->flist();
    $data = array();
    foreach ($rejection as $key) {
        $accion =  "<a href='#' class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModaledit' data-id='".$key->KEY."'>Editar</a><a href='#'  data-id='".$key->KEY."' class='deletes btn btn-danger btn-xs'>Eliminar</a>";
        $data[] = array($key->TABLA,$key->NAME,$accion);
    }
    $datos = array("data"=>$data);
    echo json_encode($datos);
}

public function rejection_delete(){
   $this->rejection->delete($_GET["id"]);
   echo  json_encode("Registro Eliminado");
}

public function rejection_search(){
    $id = $_POST["id"];
    $valor = $this->rejection->search($id);

    $data["id_item"] = $valor->id_item;
    $data["shortname"] = $valor->name_root;
    $data["longname"] = $valor->name_item;
    echo json_encode(array($data));
}

public function rejection_edit(){
    $id = $_POST["iditems"];
    $shortname = $_POST["shortnameedit"];
    $longname = $_POST["longnameedit"];

    $this->rejection->edit($shortname,$longname,$id);
    echo json_encode(array($shortname,$longname));
}

public function rejection_add(){
    $shortname = $_POST["shortname"];
    $longname = $_POST["longname"];
    $this->rejection->add($shortname,$longname);
    echo json_encode(array($shortname,$longname));
}


/*
 * Administración Tabla Glosas Cuotas Diferir x Productos
 * TA_GLOSSARY
 * VI__CUOTADIFERIRPRODUCTOS
 */
public function deferred(){

    if($this->session->userdata('lock') === NULL){redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
    $this->session->set_userdata('selector', '5.1.1.3');
    $this->data["deferred"] = $this->deferred->tipoProductos();
    $this->load->view('parameters/deferred',$this->data);
}

public function deferred_list(){
    $deferred = $this->deferred->flist();
    $data = array();
    foreach ($deferred as $key) {
        $accion =  "<a href='#' class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModaledit' data-id='".$key->KEY."'>Editar</a><a href='#'  data-id='".$key->KEY."' class='deletes btn btn-danger btn-xs'>Eliminar</a>";
        $data[] = array($key->NAME,$key->CUOTAS_MINIMO,$key->CUOTAS_MAXIMO,$accion);
    }
    $datos = array("data"=>$data);
    echo json_encode($datos);
}

public function deferred_delete(){
   $this->deferred->delete($_GET["id"]);
   echo  json_encode("Registro Eliminado");
}

public function deferred_search(){
    $id = $_POST["id"];
    $valor = $this->deferred->search($id);

    $data["id_item"] = $valor->id_item;
    $data["name_root"] = $valor->name_root;
    $data["value_min"] = $valor->value_min;
    $data["value_max"] = $valor->value_max;
     $data["name_item"] = $valor->name_item;
    echo json_encode(array($data));
}

public function deferred_edit(){
    $id = $_POST["id_item"];
    $name_item = $_POST["name_iteme"];
    $value_min = $_POST["value_mine"];
    $value_max = $_POST["value_maxe"];

    $this->deferred->edit($name_item,$value_min,$value_max,$id);
    echo json_encode(array($name_item,$value_min,$value_max));
}

public function deferred_add(){
    $name_item = $_POST["name_item"];
    $value_min = $_POST["value_min"];
    $value_max = $_POST["value_max"];
    $name_root = "Cuotas Diferidas Producto";
    $this->deferred->add($name_root,$name_item,$value_min,$value_max);
   // echo json_encode(array($name_item,$value_min,$value_max));
    redirect(base_url("parameters/deferred"));
}


}
