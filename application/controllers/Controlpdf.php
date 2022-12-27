<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlpdf  extends CI_Controller {

	/**
	 * Index Page for this controller.ou
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
    $this->load->model("Parameters_model","parameters");
    $this->load->library('Rut');
    $this->load->library('Soap');
    $this->load->library('form_validation');
    $this->load->library('Pdf');
    $this->load->model("Motivosrechazo_model","rechazo");

    $this->load->model("Documents_model","documents");

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}

}


public function doc($iddoc,$type){

    $usuario  = $this->rechazo->leerdocumentos($iddoc,$type);
    $type =  'application/pdf';

    $imagen =  $usuario->image;
    //  header("Content-type:". $type);
    // header ("Pragma: no-cache");

    $this->output
        ->set_content_type($type)
        ->set_output($imagen);


}

   public function buscardoc(){

    $iddoc = $_POST["iddoc"];
    $type  = $_POST["type"];

    $usuario  = $this->rechazo->buscardocumentos($iddoc,$type);

    echo json_encode(array($usuario,$iddoc,$type));



}

public function get_requestById() {

    $id = $_POST["id"];
    $data = $this->getp_requestById($id, "json");
    echo ($data);

}

private function get_ConsultaDatosClienteTC($nroRut, $flg_flujo){
    $Request='
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosClienteTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:NRO_RUT>'.$nroRut.'</req:NRO_RUT>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosClienteTC;
    $xmlString = $this->get_core($EndPoint, WS_Action_ConsultaDatosClienteTC, WS_Timeout, $Request, WS_ToXml);
    return($xmlString);
}


private function get_Homologador_BusquedaPorRutComercio($nroRut, $comercio, $codProducto){
    $Request='
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sol="http://www.solventa.cl">
       <soapenv:Header/>
       <soapenv:Body>
        <sol:busquedaPorRutComercioProducto>
             <rutCliente>'.$nroRut.'</rutCliente>
             <clienteComercio>'.$comercio.'</clienteComercio>
             <codProducto>'.$codProducto.'</codProducto>
        </sol:busquedaPorRutComercioProducto>
       </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_Homologador_BusquedaPorRutComercio;
    $xmlString = $this->get_core($EndPoint, WS_Action_Homologador, WS_Timeout, $Request, WS_ToXml);
    return($xmlString);
}

public function changeStatus() {

    $id = $_POST["id"];
    $todayDay = date("d-m-Y");
    $status = $_POST["status"];

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$id.'</req:numeroDeDocumento>
         <req:tipoTrx>'.CODIGO_SUPER_AVANCE.'</req:tipoTrx>
         <req:estado>'.$status.'</req:estado>
         <req:fechaEstado>'.$todayDay.' 00:00:00</req:fechaEstado>
         <req:ejecutivo>'.$this->session->userdata('email').'</req:ejecutivo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActEstadoSavYRefTC;
    $xmlString = $this->get_core($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml);
    $xml = $this->eval_xml_response($xmlString, "cabeceraSalida", WS_ActEstadoSavYRefTC);
    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $data = $value;
    echo json_encode($data);
}

public function changeLinked() {

    $id = $_POST["id"];
    $todayDay = date("d-m-Y");
    $status = $_POST["status"];

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$id.'</req:numeroDeDocumento>
         <req:tipoTrx>'.CODIGO_SUPER_AVANCE.'</req:tipoTrx>
         <req:estado>'.$status.'</req:estado>
         <req:fechaEstado>'.$todayDay.' 00:00:00</req:fechaEstado>
         <req:ejecutivo>'.$this->session->userdata('email').'</req:ejecutivo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaEnlaceTC;
    $xmlString = $this->get_core($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml);
    $xml = $this->eval_xml_response($xmlString, "cabeceraSalida", WS_ActualizaEnlaceTC);
    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $data = $value;
    echo json_encode($data);
}



public function put_modifystatus() {

    $id = $_POST["id"];
    $todayDay = date("d-m-Y");
    $status = $_POST["status"];

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$id.'</req:numeroDeDocumento>
         <req:tipoTrx>'.CODIGO_SUPER_AVANCE.'</req:tipoTrx>
         <req:estado>'.$status.'</req:estado>
         <req:fechaEstado>'.$todayDay.' 00:00:00</req:fechaEstado>
         <req:ejecutivo>'.$this->session->userdata('email').'</req:ejecutivo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActEstadoSavYRefTC;
    $xmlString = $this->get_core($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml);
    $xml = $this->eval_xml_response($xmlString, "cabeceraSalida", WS_ActEstadoSavYRefTC);

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $data = $value;
    echo json_encode($data);
}


private function print_eventlog($data) {

$fp = fopen(SHOW_NAME_LOGFILE.date('Y-m-d').'.log', 'a');
$data = ">>>>>> " . $data ." <<<<<<<" . PHP_EOL;
fwrite($fp, $data);
fclose($fp);

}

public function comprobante(){




    $fontname = TCPDF_FONTS::addTTFfont(FCPATH.'fuente/arial_narrow_7.ttf', 'narrow','',30);
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('Solventa');
    $pdf->SetFont($fontname,'',9,'',false);


        $pdf->SetTitle('Template');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 8, 15);
        $pdf->AddPage();
        $fecha = date('d-m-Y');


    $html =  $this->load->view('pdf/template','',true);
    $pdf->writeHTML($html, true, false, true, false, false);

    $pdf->AddPage();
    $html =  $this->load->view('pdf/template','',true);
    $pdf->writeHTML($html, true, false, true, false,false);

    $pdf->Output("NAME.PDF","I");









}
public function generaPDF() {

$this->data["id"] = $_POST["id"];
$type = $_POST["type"];
$fecha = date('d-m-Y');

$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetProtection(array('print', 'copy','modify'), "123456", "123456master", 0, null);

switch ($type) {
    case "SIM":
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->getp_requestById($this->data["id"],"array");
    break;
    case "COT":
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->getp_requestById($this->data["id"],"array");
    break;
     case "PRO":
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->getp_requestById($this->data["id"],"array");
    break;
    case "DES":
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->getp_requestById($this->data["id"],"array");
    break;
    case "REC":
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->getp_requestById($this->data["id"],"array");
    break;
    case "CON":
//        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
//        $this->data['datos'] = $this->getp_requestById($this->data["id"],"array");

    $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
    $this->data['datos'] = $this->get_simulateById($this->data["id"],"C","array");

    break;
    default:
    break;
}



switch ($type) {
    case "SIM":
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(60);
        $pdf->SetAutoPageBreak(true,70);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $html =  $this->load->view('pdf/simulacion',$this->data,true);

    break;
    case "COT":
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(60);
        $pdf->SetAutoPageBreak(true,70);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $html =  $this->load->view('pdf/resumen',$this->data,true);

    break;
    case "PRO":
        $fontname = TCPDF_FONTS::addTTFfont(FCPATH.'fuente/arial_narrow_7.ttf', 'narrow','',14);
        $pdf->SetFont($fontname,'',9,'',false);
        $pdf->SetTitle('Proteccion de vida');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 8, 15);
        $pdf->AddPage();
        $fecha = date('d-m-Y');
        $html =  $this->load->view('pdf/proteccion',$this->data,true);

      break;
    case "DES":
        $fontname = TCPDF_FONTS::addTTFfont(FCPATH.'fuente/arial_narrow_7.ttf', 'narrow','',14);

        $pdf->SetFont($fontname,'',9,'',false);

        $pdf->SetTitle('Proteccion de vida');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 8, 15);
        $pdf->AddPage();
        $fecha = date('d-m-Y');

       $html =  $this->load->view('pdf/desgravamen',$this->data,true);

    break;
    case "REC":
        $this->data["idmotivo"] = $this->rechazo->getall_motivo($_POST["motivo"]);

        $pdf->SetTitle('Carta de rechazo');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html =  $this->load->view('pdf/rechazo',$this->data,true);
    break;
    case "CON":
        $pdf->SetTitle('Contrato super avance');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $html =  $this->load->view('pdf/contrato',$this->data,true);

    break;
    default:
    break;
}

$pdf->writeHTML($html, true, false, true, false, '');

switch ($type) {
    case "SIM":
        $pdf->Output(FCPATH.'simulacion.pdf', 'F');
        $value['descRetorno'] = "Simulación creada con Éxito..";
           $input = FCPATH.'simulacion.pdf';
           $decripciondocumento = "SIMULACION";
    break;
    case "COT":
        $pdf->Output(FCPATH.'cotizador.pdf', 'F');
        $value['descRetorno'] = "Resumen creado con Éxito..";
           $input = FCPATH.'cotizador.pdf';
$decripciondocumento = "COTIZADOR";
    break;
    case "PRO":
        $pdf->Output(FCPATH.'proteccion.pdf', 'F');
        $value['descRetorno'] = "Solicitud de incorporacion creado con Éxito..";
           $input = FCPATH.'resumen.pdf';
$decripciondocumento = "RESUMEN";
    break;
    case "DES":
        $pdf->Output(FCPATH.'desgravamen.pdf', 'F');
        $value['descRetorno'] = "Solicitud de SEGURO DE VIDA Y DESGRAVAMEN creado con Éxito..";
           $input = FCPATH.'desgravamen.pdf';
$decripciondocumento = "DESGRAVAMEN";
    break;
     case "REC":
     $pdf->Output(FCPATH.'rechazo.pdf', 'F');
    $value['descRetorno'] = "Carta de rechazo creado con Éxito..";
    $input = FCPATH.'rechazo.pdf';
    $decripciondocumento = "CARTA DE RECHAZO";
     break;
     case "CON":
     $pdf->Output(FCPATH.'contrato.pdf', 'F');
    $value['descRetorno'] = "Contrato creado con Éxito..";
    $input = FCPATH.'contrato.pdf';
    $decripciondocumento = "CONTRATO";
     break;
    default:
    break;



}

 $fp = fopen($input, 'r+b');
        $data = fread($fp, filesize($input));
        fclose($fp);
        $data = mysqli_real_escape_string($this->get_mysqli(),$data);
        $fecha = date("Y-m-d H:i:s");
        $sqlcall = $this->db->query("INSERT INTO  ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,name_client,iddocumento,typedoc) VALUES ('".$fecha."',1,1,2,'".$decripciondocumento."','".$data."','". $this->data['datos']['nroRut']."','". $this->data['datos']['nombreCliente']."','".$this->data["id"]."','".$type."');");

$this->session->set_userdata("typeDocument", $type);

$value['retorno'] = 0;
$data = $value;
echo json_encode($data);

}
   function get_mysqli() {
$db = (array)get_instance()->db;
return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}


public function readPDF(){

$type = $this->session->userdata("typeDocument");

switch ($type) {
    case 'SIM':
        $input = FCPATH.'simulacion.pdf'; //temporary name that PHP gave to the uploaded file
    break;
    case 'COT':
        $input = FCPATH.'cotizador.pdf'; //temporary name that PHP gave to the uploaded file
    break;
    case 'PRO':
        $input = FCPATH.'proteccion.pdf'; //temporary name that PHP gave to the uploaded file
    break;
     case 'DES':
        $input = FCPATH.'desgravamen.pdf'; //temporary name that PHP gave to the uploaded file
    case 'REC':
        $input = FCPATH.'rechazo.pdf'; //temporary name that PHP gave to the
    break;
    case 'CON':
        $input = FCPATH.'contrato.pdf'; //temporary name that PHP gave to the
    break;

    default:
    break;
}

header('Content-type:application/pdf');
header('Content-disposition: inline; filename="resumen.pdf"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
readfile($input);
}

private function get_ConsultaDatosCuenta($nroRut, $flg_flujo){
    $data = array(); $retorno = COD_ERROR_INIT;
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosCuenta/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:COMERCIO>27</req:COMERCIO>
          <req:RUT>'.$nroRut.'</req:RUT>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosCuenta;
    $xmlString = $this->get_core($EndPoint, WS_Action_ConsultaDatosCuenta, WS_Timeout, $Request, WS_ToXml);
    $xml = $this->eval_xml_response($xmlString,"Registro",WS_ConsultaDatosCuenta);
    $retorno = (int)$xml->Body->DATA->retorno;

    if ($retorno==0){
        if((int)$xml->Body->DATA->Registro->suscripcionEeccXMail==1){
            $tipoDespacho = "EMAIL";
            $glosaDespacho = "Su correo electr&#243;nico de envío de su estado de cuenta es ";
        }else{
            $tipoDespacho = "TRADICIONAL";
            $glosaDespacho = "Su direcci&#243;n de envío de su estado de cuenta es ";
        }
        $data = array('retorno' => $retorno,
            'descRetorno' => $xml->Body->DATA->descRetorno,
            'contrato' => $xml->Body->DATA->Registro->contrato,
            'fechaCreacion' => $xml->Body->DATA->Registro->fechaCreacion,
            'fechaActivacion' => $xml->Body->DATA->Registro->fechaActivacion,
            'suscripcionEeccXMail' => $xml->Body->DATA->Registro->suscripcionEeccXMail,
            'tipoDespacho' => $tipoDespacho,
            'glosaDespacho' => $glosaDespacho
            );
    }
    return ($data);
}

private function cancel_function ($retorno, $descRetorno, $action) {
    $value['retorno'] = $retorno;
    $value['descRetorno'] = $descRetorno;
    $value['action'] = $action;
    $data = $value;
    echo json_encode($data);
    exit(0);
}
private function eval_xml_response($xmlString, $tagName, $serviceName) {

    $eval = strpos($xmlString, "faultstring");

    if($eval > 0){
        $ini = strpos($xmlString, "<faultstring>");
        $fin = strpos($xmlString, "</faultstring>");
        $descRetorno = substr($xmlString, $ini, $fin - $ini);
        $this->cancel_function(401,"<b>".$descRetorno."</b><br><strong>Sin Respuesta desde el CORE</strong><br><strong>Servicio ".$serviceName."</strong>","");
    }

    if(strpos($xmlString, $tagName)==FALSE){
        $value['retorno'] = COD_ERROR_INIT;
        $value['descRetorno'] = MSG_ERROR_SERVICE."</br> Service: ".$serviceName;
        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    $xml = simplexml_load_string($xmlString);
    $xml_valid = ($xml ? true : false);
    if(!$xml_valid){
        $value['retorno'] = COD_ERROR_XML_INVALIDO;
        $value['descRetorno'] = MSG_ERROR_XML_INVALIDO."</br> Servicio: ".$serviceName;
        $data = $value;
        echo json_encode($data);
        exit(0);
    }
    return($xml);
}

/*
FUNCIONES FINALES
*/
private function get_simulateById($nroSimulacion, $tipoDocumento, $format) {
    if($this->session->userdata('lock') === NULL) {redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }

    if($nroSimulacion=="" || $nroSimulacion==0) {
        $this->cancel_function(eval_cod_response, "Error, número simulación debe ser distinto de cero..","");
    }
    if($tipoDocumento=="S") { $tipoDocumento = "SIMULACION"; }
    else{ $tipoDocumento = "COTIZACION"; }

    $Request = '<?xml version="1.0" encoding="UTF-8"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$nroSimulacion.'</req:numeroDeDocumento>
         <req:tipoDocumento>'.$tipoDocumento.'</req:tipoDocumento>
         <req:tipoTrx>SAV</req:tipoTrx>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_DatosOpComercialTC;
    $xmlString = $this->get_core($EndPoint, WS_Action_DatosOpComercialTC, WS_Timeout, $Request, WS_ToXml);
    $xml = $this->eval_xml_response($xmlString, "cabeceraSalida",WS_DatosOpComercialTC);

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    if($retorno==0) {


        $value['nroRut'] = number_format((float)$xml->Body->DATA->response->nroRut,0,',','.');
        $value['dgvRut'] = $xml->Body->DATA->response->dvRut;

        $nroRut = (float)$xml->Body->DATA->response->nroRut;
        $comercio = 27; $codProducto = "T";$retorno=COD_ERROR_INIT;
/*

        $dataHomologador = $this->readHomologador($nroRut, $comercio, $codProducto);
        $flg_flujo = $dataHomologador["flg_flujo"];
        $nroTcv = $dataHomologador["nroTcv"];

        $dataCuenta = $this->get_ConsultaDatosCuenta($nroRut, $flg_flujo);
        if($dataCuenta["retorno"]==0){
            $contrato = (int)$dataCuenta["contrato"];
        }else{
            $contrato = 0;
        }
        //Set session "direccionWork" , "direccioHome"
        $dataDireccion = $this->get_ConsultaDatosDireccion($nroRut, $contrato, $flg_flujo);
        $value["direccionHome"] = $dataDireccion["direccionHome"];
*/

        if($tipoDocumento=="C"){
            $arrDataLink = $this->readRequestLinked($nroSimulacion);

            $value["estadoEnlace"] = $arrDataLink["estadoEnlace"];
            $value["tipoEstado"] = $arrDataLink["tipoEstado"];
            $value["glosaEstado"] = $arrDataLink["glosaEstado"];
            $value["glosaEnlace"] = $arrDataLink["glosaEnlace"];
            $value["sucursalOrigen"] = $arrDataLink["sucursalOrigen"];
            $value["sucursalDestino"] = $arrDataLink["sucursalDestino"];
            $value["sucursalCurse"] = $arrDataLink["sucursalCurse"];
        }

        $value['estado'] = (string)$xml->Body->DATA->response->estado;
        $value['idDocument'] = $nroSimulacion;
        $value['nameClient'] = $xml->Body->DATA->response->nombres." ".$xml->Body->DATA->response->apellidoPaterno." ".$xml->Body->DATA->response->apellidoMaterno;
        $value['birthDate'] = $this->session->userdata("birthDate");
        $value['diffYear'] = $this->session->userdata("diffYear");
        $value['fecha'] = substr($xml->Body->DATA->response->fecha,0,10);
        $value['tasaInteresMoratorio'] = $xml->Body->DATA->response->tasaInteresMoratorio;
        $value['diasDeVigenciaCotizacion'] = (int)$xml->Body->DATA->response->diasDeVigenciaCotizacion;
        $value['pan'] = $xml->Body->DATA->response->pan;
        $value['tasaDeInteresMensual'] = $xml->Body->DATA->response->tasaDeInteresMensual ." %";
        $value['cargaAnualEquivalente'] = $xml->Body->DATA->response->cargaAnualEquivalente ." %";

        $value['montoBruto'] = number_format((float)$xml->Body->DATA->response->montoBruto,0,',', '.');
        $value['montoLiquido'] = number_format((float)$xml->Body->DATA->response->montoLiquido,0,',', '.');
        $value['plazoDeCuota'] = (int)$xml->Body->DATA->response->plazo;
        $value['valorDeCuota'] = number_format((float)$xml->Body->DATA->response->valorDeCuota,0,',', '.');
        $value['fechaPrimerVencimiento'] = substr($xml->Body->DATA->response->fechaPrimerVencimiento,0,10);
        $value['costoTotalDelCredito'] = number_format((float)$xml->Body->DATA->response->costoTotalDelCredito,0,',', '.');
        $value['impuestos'] = number_format((float)$xml->Body->DATA->response->ite,0, ',', '.');
        $value['gastosNotariales'] = number_format((float)$xml->Body->DATA->response->gastosNotariales,0, ',', '.');
        $value['comision'] = number_format((float)$xml->Body->DATA->response->comision,0, ',', '.');
        $value['modoEntrega'] = (string)$xml->Body->DATA->response->modoEntrega;
        $value['mesesDiferidos'] = (int)$xml->Body->DATA->response->mesesDiferidos;
        if((string)$xml->Body->DATA->response->modoEntrega=="TEF"){
            $value['glosaModoEntrega'] = "TRANSFERENCIA";
        }else{
            $value['glosaModoEntrega'] = "EFECTIVO";
        }

        $ind = 1;

        $value['flagSeguro1'] = "SIN SEGURO";
        $value['htmlName1'] = "secureOne";
        $value['nameSeguro1'] = "";
        $value['costoMensualSeguro1'] = "-";
        $value['costoTotalSeguro1'] = "0";
        $value['coberturaSeguro1'] = "Sin Seguro";
        $value['nameCompany1'] = "-";

        $value['flagSeguro2'] = "SIN SEGURO";
        $value['htmlName2'] = "secureTwo";
        $value['nameSeguro2'] = "";
        $value['costoMensualSeguro2'] = "-";
        $value['costoTotalSeguro2'] = "0";
        $value['coberturaSeguro2'] = "Sin Seguro";
        $value['nameCompany2'] = "-";

        foreach ($xml->Body->DATA->response->listaSeguros as $record) {

            foreach ($record as $field) {

                $codSeguro = $field->codSeguro;
                $idPoliza = $field->idPoliza;
                $costoTotalSeguro = $field->costoTotalSeguro;

                $descrip = ""; $nameCompany = "";
                $dataSecure = $this->parameters->get_secureById($codSeguro);
                foreach ($dataSecure as $field) {
                    $nameCompany = $field->nameCompany;
                    $descrip = $field->descrip;
                    $nroPoliza = $field->nroPoliza;
                    $htmlName = $field->htmlName;
                }

                if($codSeguro=="03" OR $codSeguro=="05"){
                    $value['flagSeguro1'] = "CON SEGURO";
                    $value['htmlName1'] = $htmlName;
                    $value['nameSeguro1'] = $descrip;
                    $value['costoMensualSeguro1'] = "-";
                    $value['costoTotalSeguro1'] = number_format((float)$costoTotalSeguro,0, ",", ".");
                    $value['coberturaSeguro1'] = "P&#243;liza ".$nroPoliza;
                    $value['nameCompany1'] = $nameCompany;
                }else{
                    $value['flagSeguro2'] = "CON SEGURO";
                    $value['htmlName2'] = $htmlName;
                    $value['nameSeguro2'] = $descrip;
                    $value['costoMensualSeguro2'] = "-";
                    $value['costoTotalSeguro2'] = number_format((float)$costoTotalSeguro,0, ",", ".");
                    $value['coberturaSeguro2'] = "P&#243;liza ".$nroPoliza;
                    $value['nameCompany2'] = $nameCompany;
                }
                $ind = $ind + 1;
            }

        }

        $value['gastosCobranza1'] = trim((string)$xml->Body->DATA->response->gastosCobranza1);
        $value['gastosCobranza2'] = trim((string)$xml->Body->DATA->response->gastosCobranza2);
        $value['gastosCobranza3'] = trim((string)$xml->Body->DATA->response->gastosCobranza3);

        $value['garantiasAsociadas'] = "NO";
        $value['cargoPrepago'] = $xml->Body->DATA->response->cargoPrepago;
        $value['plazoAvisoPrepago'] = $xml->Body->DATA->response->plazoAvisoPrepago;
        $value['banco'] = (string)$xml->Body->DATA->response->banco;
        $value['tipoCuenta'] = (string)$xml->Body->DATA->response->tipoCuenta;
        $value['numeroCuenta'] = (string)$xml->Body->DATA->response->numeroCuenta;

        $value['htmlSimulate'] = '<table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
        <thead>
          <tr>
            <th class="text-center">Cuotas</th>
            <th class="text-center">Meses Gracia</th>
            <th class="text-right">Valor Cuota</th>
            <th class="text-right">Monto Bruto</th>
            <th class="text-right">Monto L&#237;quido</th>
            <th class="text-right">Costo Total</th>
            <th class="text-center">Tasa</th>
            <th class="text-right">Impuesto</th>
            <th class="text-right">Comisi&#243;n</th>
            <th class="text-right">CAE</th>
            <th class="text-center">Hospitalización</th>
            <th class="text-center">Desgravamen</th>
          </tr>
        </thead><tbody>
            <tr>
              <td scope="col" class="text-center">'.(int)$xml->Body->DATA->response->plazo.'</td>
              <td scope="col" class="text-center">0</td>
              <td scope="col" class="text-right">$'.number_format((float)$xml->Body->DATA->response->valorDeCuota, 0, ',', '.').'</td>
              <td scope="col" class="text-right">$'.number_format((float)$xml->Body->DATA->response->montoBruto, 0, ',', '.').'</td>
              <td scope="col" class="text-right">$'.number_format((float)$xml->Body->DATA->response->montoLiquido, 0, ',', '.').'</td>
              <td scope="col" class="text-right">$'.number_format((float)$xml->Body->DATA->response->costoTotalDelCredito, 0, ',', '.').'</td>
              <td scope="col" class="text-center">'.$xml->Body->DATA->response->tasaDeInteresMensual.'%</td>
              <td scope="col" class="text-right">$'.number_format((float)$xml->Body->DATA->response->ite, 0, ',', '.').'</td>
              <td scope="col" class="text-right">$'.number_format((float)$xml->Body->DATA->response->comision, 0, ',', '.').'</td>
              <td scope="col" class="text-right">'.$xml->Body->DATA->response->cargaAnualEquivalente.'%</td>
              <td scope="col" class="text-center">$'.$value['costoTotalSeguro1'].'</i></td>
              <td scope="col" class="text-center">$'.$value['costoTotalSeguro2'].'</i></td>
            </tr>';

    }
    $value['retorno'] = $retorno;
    $value['descRetorno'] = $descRetorno;
    $value['id_rol'] = $this->session->userdata("id_rol");

    $data = $value;
    if($format=="array"){ return $data; }
    else { return json_encode($data); }
}

private function readRequestLinked($idDocument) {
    if($this->session->userdata('lock') === NULL) {redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:sucursalOrigen></req:sucursalOrigen>
         <req:sucursalDestino></req:sucursalDestino>
         <req:nroRut></req:nroRut>
         <req:tipoEstado></req:tipoEstado>
         <req:idSolicitud>'.$idDocument.'</req:idSolicitud>
         <req:fechaDesde></req:fechaDesde>
         <req:fechaHasta></req:fechaHasta>
      </req:DATA>
      </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaCotizacionesSAV;
    $xmlString = $this->get_core($EndPoint, WS_Action_ConsultaCotizacionesSAV, WS_Timeout, $Request, WS_ToXml);
    $xml = $this->eval_xml_response($xmlString, "cabeceraSalida",WS_ConsultaCotizacionesSAV);
    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    $data = array();
    if($retorno==0){

        $id_estado = (string)$xml->Body->DATA->response->tipoEstado;
        $record = $this->user->parameters->get_requestStatus($id_estado);
        $glosaEstado = $record->NAME;
        $glosaEnlace = "";

        $data = array(
            "estadoEnlace" => $xml->Body->DATA->estadoEnlace,
            "tipoEstado" => (string)$xml->Body->DATA->response->tipoEstado,
            "glosaEstado" => $glosaEstado,
            "glosaEnlace" => $glosaEnlace,
            "sucursalOrigen" => (int)$xml->Body->DATA->sucursalOrigen,
            "sucursalDestino" => (int)$xml->Body->DATA->sucursalDestino,
            "sucursalCurse" => (int)$xml->Body->DATA->sucursalCurse
            );

    }
    return($data);
}

private function readHomologador($nroRut, $comercio, $codProducto) {

    $xmlString = $this->get_Homologador_BusquedaPorRutComercio($nroRut, $comercio, $codProducto);
    $xml = $this->eval_xml_response($xmlString, "busquedaPorRutComercioProductoResponse","HomologadorRutComercio");

    $retorno = (int)$xml->Body->busquedaPorRutComercioProductoResponse->return->codigo_respuesta;
    $this->eval_cod_response($retorno, MSG_ERROR_SERVICE_NOOK);

    $flg_cvencida = (string)$xml->Body->busquedaPorRutComercioProductoResponse->return->flg_cvencida;
    $flg_tecnocom = (string)$xml->Body->busquedaPorRutComercioProductoResponse->return->flg_tecnocom;
    if($flg_tecnocom=="S"){$flg_flujo="001";$origen="TECNOCOM";$nroTcv=(string)$xml->Body->busquedaPorRutComercioProductoResponse->return->pan_tecnocom;}
    if($flg_tecnocom=="N"){$flg_flujo="002";$origen="VISSAT";$nroTcv=(string)$xml->Body->busquedaPorRutComercioProductoResponse->return->pan_solventa;}
    if($flg_cvencida=="S"){$flg_flujo="000";$origen="";$nroTcv="0";
        $descRetorno  = MSG_ERROR_CARTERA_VENCIDA;
        $this->cancel_function(COD_ERROR_INIT, $descRetorno, "");
    }

    $data = array(
        "nroTcv" => $nroTcv,
        "flg_flujo" => $flg_flujo,
        "origen" => $origen,
        "retorno" => $retorno,
        "descRetorno" => "readHomologador OK!"
        );

    return($data);
}

private function get_ConsultaDatosDireccion($nroRut, $contrato, $flg_flujo){
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosDireccion/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:RUT>'.$nroRut.'</req:RUT>
          <req:CONTRATO>'.$contrato.'</req:CONTRATO>
          <req:VIGENTE>S</req:VIGENTE>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $data= array();$retorno=COD_ERROR_INIT;
    $direccionHome = ""; $direccionWork = "";
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosDireccion;
    $xmlString = $this->get_core($EndPoint, WS_Action_ConsultaDatosDireccion, WS_Timeout, $Request, WS_ToXml);
    $xml = $this->eval_xml_response($xmlString,"descRetorno", WS_ConsultaDatosDireccion);
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;
    if($retorno==0){
        foreach ($xml->Body->DATA as $recordDIR) {
            foreach ($recordDIR as $nodo) {

                if($nodo->tipoDireccion=="HOME"){
                    $direccionHome  = $nodo->calle ." ";
                    $direccionHome .= $nodo->numeroCalle ." ";
                    $direccionHome .= $nodo->block ." ";
                    $direccionHome .= $nodo->depto ." ";
                    $direccionHome .= $nodo->poblacion ." ";
                    $direccionHome .= $nodo->ciudad ." ";
                    $direccionHome .= $nodo->region ." ";
                }
                if($nodo->tipoDireccion=="WORKS_AT"){
                    $direccionWork  = $nodo->calle ." ";
                    $direccionWork .= $nodo->numeroCalle ." ";
                    $direccionWork .= $nodo->block ." ";
                    $direccionWork .= $nodo->depto ." ";
                    $direccionWork .= $nodo->poblacion ." ";
                    $direccionWork .= $nodo->ciudad ." ";
                    $direccionWork .= $nodo->region ." ";
                }
            }
         }
    }
    $this->session->set_userdata("direccionWork", $direccionWork);
    $this->session->set_userdata("direccionHome", $direccionHome);

    $data = array(
        "direccionWork" => $direccionWork,
        "direccionHome" => $direccionHome
        );

    return($data);
}



private function get_core($setEndPoint, $setAction, $setTimeOut, $soap, $setTypeReturn)
{
    try{

        if (SHOW_DEBUG_LOGFILE){
            $fp = fopen(SHOW_NAME_LOGFILE.date('Y-m-d').'.log', 'a');
            $data = '>>>BEGIN>>> '.date('Ymd h:i:s.'). gettimeofday()['usec'] .PHP_EOL;
            fwrite($fp, $data);
            $data = 'EndPoint:'.$setEndPoint.' Action:'.$setAction.' TimeOut:'.$setTimeOut.PHP_EOL;
            fwrite($fp, $data);
            $data = 'Request:'.$soap.PHP_EOL;
            fwrite($fp, $data);
        }

            $s = new SOAP();
            $s->setEndPoint($setEndPoint); $s->setAction($setAction); $s->setTimeOut($setTimeOut);
            $s->setRequest($soap);
            $s->addCAInfo('/tmp/difarma.crt');
            $s->call();

        if (SHOW_DEBUG_LOGFILE){
            $data = 'Response:'.$s->toXML().PHP_EOL;
            fwrite($fp, $data);
            $data = '>>>END>>> '.date('Ymd h:i:s.'). gettimeofday()['usec'] .PHP_EOL;
            fwrite($fp, $data);
            fclose($fp);
        }

        if($s->toXML()==MSG_ERROR_HTTP_ERROR_URL){
            $xmlerror = '<?xml version="1.0" encoding="utf-8"?>
            <Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
            <Body><DATA xmlns="http://www.teknodata.cl/">
            <errorSOAP>TRUE</errorSOAP><retorno>500</retorno>
            <descRetorno>'.MSG_ERROR_HTTP_ERROR_URL.'</descRetorno>
            </DATA></Body></Envelope>';
            return $xmlerror;
        }

        switch($setTypeReturn){
            case "XML": return $s->toXML();
                break;
            case "JSON": return $s->toJSON();
                break;
            case "ARRAY": return $s->toARRAY();
                break;
            default: return $s->toXML();
                break;
        }

    } catch (Exception $e){
        $fp = fopen(SHOW_NAME_ERRORFILE.date('Y-m-d').'.log', 'a');
        $data = '>>>BEGIN>>> '.date('d - m - Y h:i:s.u').PHP_EOL;
        fwrite($fp, $data);
        $data = 'EndPoint:'.$setEndPoint.' Action:'.$setAction.' TimeOut:'.$setTimeOut.PHP_EOL;
        fwrite($fp, $data);
        $data = 'Request:'.$soap.PHP_EOL;
        fwrite($fp, $data);
        $data = 'Error:'.$e->getMessage().PHP_EOL;
        fwrite($fp, $data);
        $data = '>>>END>>> '.date('d - m - Y h:i:s.u').PHP_EOL;
        fwrite($fp, $data);
        fclose($fp);
        $xmlerror = '<?xml version="1.0" encoding="utf-8"?>
        <Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
        <Body><DATA xmlns="http://www.teknodata.cl/">
        <errorSOAP>TRUE</errorSOAP><retorno>100</retorno>
        <descRetorno>'.$e->getMessage().'</descRetorno>
        </DATA></Body></Envelope>';
        return $xmlerror;
    }
}


public function get_lightClient(){

    $nroRut = str_replace('.', '', $_POST["id"]);
    $nroRut = str_replace('-', '', $nroRut);
    $nroRut = substr($nroRut, 0, -1);
    $valor = $this->documents->get_documentsByRut($nroRut);
    $data = array();
    foreach ($valor as $key) {
        $code["correl"] = $key->correl;
        $code["name"] = $key->name;
        $code["idDocument"] = $key->idDocument;
        $code["typeDocument"] = $key->typeDocument;
        $code["id_user_last_print"] = $key->id_user_last_print;

        $code["id_user"] = $key->id_user;
        $result = $this->user->get_usersById($key->id_user);
        if($result){
            $code["username"] = $result->username;
        }else{
            $code["username"] = "No Existe";
        }
        $code["stamp_last_print"] = $key->stamp_last_print;
        $code["stamp"] = $key->stamp;

        $code["id_office"] = $key->id_office;
        $result = $this->parameters->get_officeById($key->id_office);
        if($result){
            $code["nameOffice"] = $result->name;
        }else{

            $code["nameOffice"] = "No Existe";
        }
        $code["id_office_last_print"] = $key->id_office_last_print;
        if($key->status==1){ $code["status"] = "VIGENTE"; }
        else{ $code["status"] = "HISTORICO"; }
        $data[] = $code;
    }

    echo json_encode($data);
}

/*
 * End Function get_core()
 */




}
