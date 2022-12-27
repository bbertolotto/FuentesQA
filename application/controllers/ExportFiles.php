<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportFiles extends CI_Controller {
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
    $this->load->library("session");
    $this->load->library("PHPExcel");

    $site_lang = $this->session->userdata('site_lang');
    if ($site_lang) {$this->lang->load('header',$this->session->userdata('site_lang'));
    }else{$this->lang->load('header','spanish');}

}

public function index(){
    $this->load->view('feriado/feriado');
}

public function excel(){

    if(PHP_SAPI != "cli")
        die('Solo se puede ejecutar desde un navegador');
   

$objPHPExcel = new PHPExcel();
// Propiedades del documento
$objPHPExcel->getProperties()->setCreator("Obed Alvarado")
            ->setLastModifiedBy("Obed Alvarado")
            ->setTitle("Office 2010 XLSX Documento de prueba")
            ->setSubject("Office 2010 XLSX Documento de prueba")
            ->setDescription("Documento de prueba para Office 2010 XLSX, generado usando clases de PHP.")
            ->setKeywords("office 2010 openxml php")
            ->setCategory("Archivo con resultado de prueba");
 

    echo "saludos";
    exit(0);
}

	
}
