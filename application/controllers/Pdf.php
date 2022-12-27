<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf  extends CI_Controller {

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
    $this->load->model("Communes_model","communes");
    $this->load->library('Rut');
    $this->load->library('Soap');
    $this->load->library('form_validation');
    $this->load->library('Pdf');

    
    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}
}



public function clientpdf()
{
    

        $pdf = new Pdf('L', 'A4');
        $pdf->SetProtection(array('print', 'copy','modify'), "123456", "123456master", 0, null);

$pdf->SetTitle('Pdf');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage('L', 'A4');




$html = $_POST["html"];

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output(FCPATH.'generarpdf2.pdf', 'F');
//$pdf->Output(FCPATH.'prueba.pdf', 'I');

$input = FCPATH.'generarpdf2.pdf'; //temporary name that PHP gave to the uploaded file




echo json_encode("ok");

}


public function abrirpdf(){

$input = FCPATH.'generarpdf2.pdf'; //temporary name that PHP gave to the uploaded file


header('Content-type:application/pdf');
header('Content-disposition: inline; filename="rechazo.pdf"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
readfile($input);
}



}
