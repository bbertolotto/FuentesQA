<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Utils extends CI_Controller {

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
    $this->load->model("Glossary_model","glossary");
    $this->load->model("Documents_model","documents");
    $this->load->library("session");
    $this->load->library('form_validation');
    $this->load->library('Soap');
    $this->load->library('Pdf');
    $this->load->helper("ws_solventa_helper");

    //  $this->lang->load('header',$this->session->userdata('site_lang'));
    $site_lang = $this->session->userdata('site_lang');
    if ($site_lang) { $this->lang->load('header',$this->session->userdata('site_lang')); } else { $this->lang->load('header','english'); }

}


public function send_Simulate() {

    $idDocument = $_POST["idDocument"];
    $emailCuenta = $_POST["emailCuenta"];
    $nombreCliente = $_POST["nombreCliente"];
    $estadoTEF = $_POST["estadoTEF"];

    $this->print_eventlog("Begin->Simulacion Nº:".$idDocument);

    $fechaActual = date("d-m-Y");
    $horaActual = date("H:i");

    $tipoCuenta = "";
    $descBanco = "";

    $value = $this->sendEmailTEF($estadoTEF, $nombreCliente, $fechaActual, $horaActual, $tipoCuenta, $descBanco, $emailCuenta, $idDocument);

    $data = $value;
    echo json_encode($data);

}


public function put_Transferencia() {

    $idDocument = $_POST["idDocument"];
    $emailCuenta = $_POST["emailCuenta"];
    $nombreCliente = $_POST["nombreCliente"];
    $telefonoCuenta = $_POST["telefonoCuenta"];
    $montoLiquido = $_POST["montoLiquido"];
    $nroRut = $_POST["nroRut"];
    $plazoDeCuota = $_POST["plazoDeCuota"];

    $numeroCuenta = $_POST["numeroCuenta"];
    $tipoCuenta = $_POST["tipoCuenta"];
    $codigoBanco = $_POST["codigoBanco"];

    $result = $this->glossary->get_BancosById($codigoBanco);
    if($result!=false) { $descBanco = $result->NAME; }
    else { $descBanco = "-"; }

    $result = $this->glossary->get_tipoCuentasById($tipoCuenta);
    if($result!=false) { $descCuenta = $result->NAME; }
    else { $descCuenta = "-"; }

    $fechaActual = date("d-m-Y"); $horaActual = date("H:i");

    $this->print_eventlog("Begin->Transferencia->Cotización Nº:".$idDocument);
    $eval = $this->get_simulateById($idDocument,"C");

    if($eval["retorno"]==0) {

        if($eval["estado"]=="L") {

    $htmlTags = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">SAV esta Liquidada..</td>';

        $value["htmlTags"] = $htmlTags;

        $data = $value;
        echo json_encode($data);
        exit (0);


        }


    } else {

    $htmlTags = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">No fue posible validar Estado SAV</td>';

        $value["htmlTags"] = $htmlTags;

        $data = $value;
        echo json_encode($data);
        exit (0);

    }

    if($eval["banco"]!=$codigoBanco OR $eval["tipoCuenta"]!=$tipoCuenta OR $eval["numeroCuenta"]!=$numeroCuenta)
        { $flg_change_transfer = true; } else { $flg_change_transfer = false; }

    $field_rut = $nroRut; $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut);
    $rutTitular = $nroRut;
    $nombreTitular = $nombreCliente;
    $montoLiquido = str_replace('.', '', $montoLiquido); $montoLiquido = str_replace('$', '', $montoLiquido);
    $username = $this->session->userdata("username");

    if($tipoCuenta=="01") { $tipoCuentaTEF = "CUENTA_CORRIENTE"; } else { $tipoCuentaTEF = "CUENTA_VISTA"; }

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tran="http://www.solventa.cl/schema/TransferenciaSAV">
    <soapenv:Header/>
    <soapenv:Body>
    <tran:TransferenciaSAVRequest>
        <tran:Usuario>'.$username.'</tran:Usuario>
        <tran:RutOrdenante>967760005</tran:RutOrdenante>
        <tran:IdentificadorOperacion>3000000000</tran:IdentificadorOperacion>
        <tran:CanalCliente>INTERNET</tran:CanalCliente>
        <tran:Monto>'.$montoLiquido.'</tran:Monto>
        <tran:Firma>rtXSwoSciYsMrq3c</tran:Firma>
        <tran:TipoCuentaOrdenante>CUENTA_CORRIENTE</tran:TipoCuentaOrdenante>
        <tran:NumeroCuentaOrdenante>1334298</tran:NumeroCuentaOrdenante>
        <tran:RutTitular>'.$rutTitular.'</tran:RutTitular>
        <tran:NombreTitular>'.$nombreTitular.'</tran:NombreTitular>
        <tran:CodigoBanco>'.$codigoBanco.'</tran:CodigoBanco>
        <tran:TipoCuentaBeneficiario>'.$tipoCuentaTEF.'</tran:TipoCuentaBeneficiario>
        <tran:NumeroBeneficiario>'.$numeroCuenta.'</tran:NumeroBeneficiario>
        <tran:Email>'.$emailCuenta.'</tran:Email>
        <tran:VissAvanceParams>
            <tran:CodigoAutorizador>1</tran:CodigoAutorizador>
            <tran:HeaderTrx>1</tran:HeaderTrx>
            <tran:NumeroTarjeta>'.$eval["pan"].'</tran:NumeroTarjeta>
            <tran:Pos>10000</tran:Pos>
            <tran:Sucursal>00002</tran:Sucursal>
            <tran:Terminal>1</tran:Terminal>
            <tran:TipoLectura>3</tran:TipoLectura>
            <tran:Usuario>27107</tran:Usuario>
            <tran:NumeroCuotas>'.$plazoDeCuota.'</tran:NumeroCuotas>
            <tran:MesGracia>0</tran:MesGracia>
         </tran:VissAvanceParams>
    </tran:TransferenciaSAVRequest>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_PS_Transferencia_SAV;
    $xmlString = $this->get_core($EndPoint, WS_Action_PS_Transferencia_SAV, WS_Timeout30, $Request, WS_ToXml);

    $eval = $this->eval_response_core($xmlString, "TransferenciaSAVResponse", WS_PS_Transferencia_SAV);
    $xml = $eval["xmlDocument"];

    $value["codigoRetorno"] = (int)$xml->Body->TransferenciaSAVResponse->Estado->Codigo;
    $value["glosaRetorno"] = (string)$xml->Body->TransferenciaSAVResponse->Estado->Glosa;
    $value["numeroTEF"] = (int)$xml->Body->TransferenciaSAVResponse->NumOperProg;
    $value["fechaContable"] = (string)$xml->Body->TransferenciaSAVResponse->FechaContable;
    $value["FechaInstruccion"] = (string)$xml->Body->TransferenciaSAVResponse->FechaInstruccion;
    $value["estadoTEF"] = (string)$xml->Body->TransferenciaSAVResponse->EstadoTef;

    if($value["codigoRetorno"]==1) {

        $estadoTEF = "accept";
    $htmlTags = '<tr><td class="text-center">Transferencia</td><td class="text-center">Terminado ..</td><td class="text-center">Transferencia Cursada con éxito</td>';

        $messageSms = $nombreCliente.", Tarjeta Cruz Verde informa que hoy ".$fechaActual." a las ".$horaActual." realizo transferencia de Super Avance por $".number_format((float)$montoLiquido,0, ',', '.')." a Banco ".$descBanco;

        $eval["retorno"]=0;

        if($eval["retorno"]==0) {

        $htmlTags.= '<tr><td class="text-center">Liquidación SAV</td><td class="text-center">Terminado ..</td><td class="text-center">Liquidación con éxito</td>';

        } else {

        $htmlTags.= '<tr><td class="text-center">Liquidación SAV</td><td class="text-center">Terminado ..</td><td class="text-center">Liquidación con Error</td>';

        }

        if($flg_change_transfer) {

            $result = $this->db_SAV_update_Transfer($idDocument, $codigoBanco, $tipoCuenta, $numeroCuenta);

            if($result["retorno"]==0) {

            $htmlTags.= '<tr><td class="text-center">Actualizar Datos Banco</td><td class="text-center">Terminado ..</td><td class="text-center">Transacción Aceptada</td>';

            } else {

            $htmlTags.= '<tr><td class="text-center">Actualizar Datos Banco</td><td class="text-center">Terminado ..</td><td class="text-center">Transacción Rechazada</td>';

            }

            $result = $this->db_SAV_update_Contract($idDocument, $field_rut);

            $this->print_eventlog("black");

            if($result) {

            $htmlTags.= '<tr><td class="text-center">Actualizar Datos Banco</td><td class="text-center">Terminado ..</td><td class="text-center">Transacción Aceptada</td>';

            } else {

            $htmlTags.= '<tr><td class="text-center">Actualizar Datos Banco</td><td class="text-center">Terminado ..</td><td class="text-center">Transacción Rechazada</td>';

            }

        }


    }else{

        $estadoTEF = "deny";
    $htmlTags = '<tr><td class="text-center">Transferencia</td><td class="text-center">Terminado ..</td><td class="text-center">Transferencia Fallida</td>';

        $messageSms = $nombreCliente.", Tarjeta Cruz Verde informa que abono de Super Avance por $".number_format((float)$montoLiquido,0, ',', '.')." ha sido rechazada";

    }

    $eval = $this->sendSmsTEF($telefonoCuenta, $messageSms);

    if($eval["retorno"]==0) {

        $htmlTags.= '<tr><td class="text-center">Envio SMS</td><td class="text-center">Terminado ..</td><td class="text-center">Enviado con éxito</td>';

    }else {

        $htmlTags.= '<tr><td class="text-center">Envio SMS</td><td class="text-center">Terminado ..</td><td class="text-center">Envio Fallido</td>';

    }

    $eval = $this->sendEmailTEF($estadoTEF, $nombreCliente, $fechaActual, $horaActual, $descCuenta, $descBanco, $emailCuenta, $idDocument);

    if($eval["retorno"]==0) {

        $htmlTags.= '<tr><td class="text-center">Envio Email</td><td class="text-center">Terminado ..</td><td class="text-center">Enviado con éxito</td>';

    }else {

        $htmlTags.= '<tr><td class="text-center">Envio Email</td><td class="text-center">Terminado ..</td><td class="text-center">Envio Fallido</td>';

    }

    $value["htmlTags"] = $htmlTags;

    $data = $value;
    echo json_encode($data);

}


private function db_SAV_update_Contract($field_id, $field_rut) {

    require dirname(__FILE__) . '/Advance.php';

    $Advance = New Advance();
    $result = $Advance->db_SAV_update_Contract($field_id, $field_rut);

    if($result) { return true; } else { return false; }

}


private function sendEmailTEF($estadoTEF, $nombreCliente, $fechaActual, $horaActual, $descCuenta, $descBanco, $emailCuenta, $idDocument) {

    $result = $this->glossary->get_htmlEmailsById($estadoTEF,"");
    if($result== false) {
        $value["retorno"] = COD_ERROR_INIT;
        $value["descRetorno"] = "Error, al leer cuerpo Email TEF";

        $data = $value;
        return ($data);
    }

    $mensaje = $result->CUERPOHTML;
    $mensaje = str_replace("&nombreCliente&", $nombreCliente, $mensaje);
    $mensaje = str_replace("&fechaActual&", $fechaActual, $mensaje);
    $mensaje = str_replace("&horaActual&", $horaActual, $mensaje);
    $mensaje = str_replace("&motivoRechazo&", "Transferencia Fallida", $mensaje);
    $mensaje = str_replace("&tipoCuenta&", $descCuenta, $mensaje);
    $mensaje = str_replace("&descBanco&", $descBanco, $mensaje);


    $Request = '<soapenv:Envelope xmlns:req="http://www.solventa.cl/request" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>';

    if($estadoTEF=="accept" or $estadoTEF=="simula" or $estadoTEF=="cotiza") {

        $adjuntos = $this->documents->get_documentsByEmail($idDocument);
        if($adjuntos!=false) {


            $datafile_array = array();
            foreach ($adjuntos as $nodo) {

                array_push($datafile_array,base64_encode($nodo->image));

            }

        $Request.='<adjuntos>'.implode(",", $datafile_array).'</adjuntos>';


        }

    }

    $Request.='
    <asunto>'.$result->ASUNTO.'</asunto>
    <cuerpoHtml>'.$mensaje.'</cuerpoHtml>
    <from>webmail@solventa.cl</from>';

    if($estadoTEF=="accept" or $estadoTEF=="simula" or $estadoTEF=="cotiza") {

        if($adjuntos!=false) {

            $filename_array = array(); $fileName = "archivo.pdf";
            foreach ($adjuntos as $nodo) {

                if($nodo->typeDocument=="CON") { $fileName = "contrato.pdf"; }
                if($nodo->typeDocument=="COT") { $fileName = "hojaresumen.pdf"; }
                if($nodo->typeDocument=="DES") { $fileName = "desgravamen.pdf"; }
                if($nodo->typeDocument=="PRO") { $fileName = "enfermedades.pdf"; }
                if($nodo->typeDocument=="SIM") { $fileName = "simulacion.pdf"; }

                array_push($filename_array, $fileName);

            }

            $Request.='<nombre_adjuntos>'.implode(";", $filename_array).'</nombre_adjuntos>';


        }

    }

    $Request.='
    <password>wsemailpassword</password>
    <to>'.$emailCuenta.'</to>
    <usuario>wsemailuser</usuario>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $tagName = "errorCode";
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_SendEmail;
    $xmlString = $this->get_core($EndPoint, WS_Action_SendEmail, WS_Timeout, $Request, WS_ToXml);

    $eval = $this->eval_response_core($xmlString, $tagName, WS_SendEmail);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->errorInfo->errorCode;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->errorInfo->errorMsg;
    $data = $value;

    return ($data);

}


private function sendSmsTEF($telefonoCuenta, $message) {
    if($this->session->userdata('lock') === NULL) { redirect(base_url()); }
    if($this->session->userdata('lock') == "0"){ redirect(base_url("Dashboard/lock")); }


    if(strlen($telefonoCuenta)==8) { $telefonoCuenta = "569".$telefonoCuenta; }
    if(strlen($telefonoCuenta)==9) { $telefonoCuenta = "56".$telefonoCuenta; }

    if(strlen($telefonoCuenta)!=11) {

        $value["retorno"] = 300;
        $value["descRetorno"] = "Error, Formato Nº Teléfono..";

        $data = $value;
        return ($data);
    }

    if(strlen($message)>250) {

        $value["retorno"] = 300;
        $value["descRetorno"] = "Error, Largo Mensaje Excede el Permitido (250)";

        $data = $value;
        return ($data);
    }

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:url>http://ws.redvoiss.net:8080/Solventa_WS/bulksmswsdl?wsdl</req:url>
         <req:user>solventasms</req:user>
         <req:pass>123456789</req:pass>
         <req:xmlsms><![CDATA[<sms originator="SOLVENTA" phone="'.$telefonoCuenta.'">'.$message.'</sms>]]></req:xmlsms>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $tagName = "DATA";
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_EnvioSMS;
    $xmlString = $this->get_core($EndPoint, WS_Action_EnvioSMS, WS_Timeout, $Request, WS_ToXml);

    $eval = $this->eval_response_core($xmlString, $tagName, WS_EnvioSMS);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];

        $data = $value;
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    if($eval["retorno"]==0){
        $value["retorno"] = 0;
        $value["descRetorno"] = "Mensaje Enviado Correctamente..";

    }else{

        $value["retorno"] = 1;
        $value["descRetorno"] = "Error, al enviar SMS..";
    }

    $data = $value;
    return ($data);

}

public function showEECC() {
    if($this->session->userdata('lock') === NULL) { redirect(base_url()); }
    if($this->session->userdata('lock') == "0"){ redirect(base_url("Dashboard/lock")); }

    $fechaEmision = $this->input->post("fechaEmision");
    $numTarjeta = $this->input->post("numTarjeta"); $username = $this->session->userdata("username");

    $numTarjeta = str_replace('-', '', $numTarjeta); $fechaEmision = str_replace('-', '/', $fechaEmision);
    $numTarjeta = substr($numTarjeta, 0, 3) ."-". substr($numTarjeta, 3, 6) . "-". substr($numTarjeta, 9, 6) ."-". substr($numTarjeta, 15, 1);

    if($this->session->userdata("id_product")=="T"){

        $Request = "<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:sol='http://www.solventa.cl'>
        <soapenv:Header/>
        <soapenv:Body>
        <sol:DoctoEECCRequest>
            <NUM_TARJETA>".$numTarjeta."</NUM_TARJETA>
            <FECHA_VENCIMIENTO>'". $fechaEmision ."'</FECHA_VENCIMIENTO>
            <RUT></RUT>
        </sol:DoctoEECCRequest>
        </soapenv:Body>
        </soapenv:Envelope>";

    }else{


        $nroRut = str_replace('.', '', $this->session->userdata("nroRut"));
        $nroRut = str_replace('-', '', $nroRut);
        $nroRut = substr($nroRut, 0, -1);

        $Request = "<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:sol='http://www.solventa.cl'>
        <soapenv:Header/>
        <soapenv:Body>
        <sol:DoctoEECCRequest>
            <NUM_TARJETA></NUM_TARJETA>
            <FECHA_VENCIMIENTO>". $fechaEmision ."</FECHA_VENCIMIENTO>
            <RUT>". $nroRut. "</RUT>
        </sol:DoctoEECCRequest>
        </soapenv:Body>
        </soapenv:Envelope>";
    }

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDoctoEECC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDoctoEECC, WS_Timeout30, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "DoctoEECCResponse", "serviceName" => WS_ConsultaDoctoEECC);
    $eval = ws_EVAL_SOAP($Request);
    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];
        echo json_encode($data);
        exit();
    }
    $xml = $eval["xmlDocument"];

    $value["PDF"] = (string)$xml->Body->DoctoEECCResponse->return->PDF;
    $value["retorno"] = 0;
    $value["descRetorno"] = "Transacción Aceptada";
    $value["title"] = $this->lang->line('text_title_header');
    $data = $value;

    echo json_encode($data);
}

private function db_SAV_update_Transfer($field_id, $field_banco, $field_tipoCuenta, $field_numeroCuenta) {

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:idSolicitud>'.$field_id.'</req:idSolicitud>
         <req:codBanco>'.$field_banco.'</req:codBanco>
         <req:cuentaNumero>'.$field_numeroCuenta.'</req:cuentaNumero>
         <req:cuentaTipo>'.$field_tipoCuenta.'</req:cuentaTipo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaCotizacion;
    $xmlString = $this->get_core($EndPoint, WS_Action_ActualizaCotizacion, WS_Timeout, $Request, WS_ToXml);

    $eval = $this->eval_response_core($xmlString, "cabeceraSalida", WS_ActualizaCotizacion);
    if($eval["retorno"]!=0){
        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];

        $data = $value;
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $data = $value;
    return ($data);

}


private function db_SAV_update_Estado($field_id, $field_estado) {

    $usuarioAutoriza = ""; $usuarioLiquida = ""; $usuarioAceptacion = ""; $fechaAutoriza = ""; $fechaLiquida = "";$fechaAceptacion = "";

    $timestamp = date("d-m-Y h:i:s"); $usuarioLiquida = $this->session->userdata("email"); $fechaLiquida = $timestamp;

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$field_id.'</req:numeroDeDocumento>
         <req:tipoTrx>'.CODIGO_SUPER_AVANCE.'</req:tipoTrx>
         <req:estado>'.$field_estado.'</req:estado>
         <req:usuarioAutoriza>'.$usuarioAutoriza.'</req:usuarioAutoriza>
         <req:fechaAutoriza>'.$fechaAutoriza.'</req:fechaAutoriza>
         <req:usuarioLiquida>'.$usuarioLiquida.'</req:usuarioLiquida>
         <req:fechaLiquida>'.$fechaLiquida.'</req:fechaLiquida>
         <req:usuarioAceptacion>'.$usuarioAceptacion.'</req:usuarioAceptacion>
         <req:fechaAceptacion>'.$fechaAceptacion.'</req:fechaAceptacion>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActEstadoSavYRefTC;
    $xmlString = $this->get_core($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml);

    $eval = $this->eval_response_core($xmlString, "cabeceraSalida", WS_ActEstadoSavYRefTC);
    if($eval["retorno"]!=0){
        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];

        $data = $value;
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["timestamp"] = $timestamp;

    $data = $value;
    return ($data);
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
/*
 * End Function get_core()
 */

private function eval_response_core($xmlString, $tagName, $serviceName) {

    $eval = strpos($xmlString, "faultstring");
    if($eval > 0){
        $ini = strpos($xmlString, "<faultstring>");
        $fin = strpos($xmlString, "</faultstring>");
        $descRetorno = substr($xmlString, $ini, $fin - $ini);
        $value["retorno"] = 401;
        $value["descRetorno"] = $descRetorno;
        $data = $value;
        return ($data);
    }

    if(strpos($xmlString, $tagName)==FALSE){
        $value['retorno'] = COD_ERROR_INIT;
        $value['descRetorno'] = MSG_ERROR_SERVICE."</br> Service: ".$serviceName;
        $data = $value;
        return ($data);
    }

    $xml = simplexml_load_string($xmlString);
    $xml_valid = ($xml ? true : false);
    if(!$xml_valid){
        $value['retorno'] = COD_ERROR_XML_INVALIDO;
        $value['descRetorno'] = MSG_ERROR_XML_INVALIDO."</br> Servicio: ".$serviceName;
        $data = $value;
        return ($data);
    }

    $value["retorno"] = 0;
    $value["descRetorno"] = "Transacción Aceptada";
    $value["xmlDocument"] = $xml;
    $data = $value;
    return ($data);
}


private function get_simulateById($nroSimulacion, $tipoDocumento) {
    if($this->session->userdata('lock') === NULL) {redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }

    if($nroSimulacion=="" || $nroSimulacion==0) {

        $value["retorno"] = COD_ERROR_INIT;
        $value["descRetorno"] = "Error, número simulación debe ser distinto de cero..";

        $data = $value;
        return ($data);
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
    $eval = $this->eval_response_core($xmlString, "cabeceraSalida", WS_DatosOpComercialTC);
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($value["retorno"]==0) {

        $value["pan"] = (string)$xml->Body->DATA->response->pan;
        $value["banco"] = (string)$xml->Body->DATA->response->banco;
        $value["tipoCuenta"] = (string)$xml->Body->DATA->response->tipoCuenta;
        $value["numeroCuenta"] = (string)$xml->Body->DATA->response->numeroCuenta;
        $value["estado"] = (string)$xml->Body->DATA->response->estado;
        $value["nroRut"] = (string)$xml->Body->DATA->response->nroRut;
        $value["dgvRut"] = (string)$xml->Body->DATA->response->dvRut;

    }


    $data = $value;
    return ($data);

}



private function print_eventlog($data) {

$fp = fopen(SHOW_NAME_LOGFILE.date('Y-m-d').'.log', 'a');
$data = ">>>>>> " . $data ." <<<<<<<" . PHP_EOL;
fwrite($fp, $data);
fclose($fp);

}



}
