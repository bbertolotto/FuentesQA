<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once __DIR__.'/fpdi/vendor/autoload.php';

class Advance  extends CI_Controller {

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

    $this->load->model(array( "Users_model"=>"users", "Communes_model"=>"communes", "Parameters_model"=>"parameters","Motivosrechazo_model"=>"rechazo", "Documents_model"=>"documents", "Glossary_model"=>"glossary", "Journal_model"=>"journal"));

    $this->load->library(array('Rut', 'Soap', 'form_validation', 'Pdf'));
    $this->load->helper(array('funciones_helper','ws_solventa_helper', 'teknodatasystems_helper'));

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}

    date_default_timezone_set('America/Santiago');
}


/**
 * Begin:: CC033
 **/

private function generaPDFSAV($nroRut, $idDocument, $type, $datos) {

$this->data["datos"] = $datos;
$this->data["id"] = $idDocument;
$fecha = date('d-m-Y');

$dgvRut = substr($nroRut, -1);
$nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

if($this->documents->get_documentsExists($idDocument, $type)) {
    $value['retorno'] = 100;
    $value['descRetorno'] = "Documento ya fue Generado, consulte imprimir documentos";
    $data = $value;
    return ($data);
}

switch ($type) {
    case "COT":
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $pdf->SetHeaderMargin(0);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');

        $html =  $this->load->view('pdf/templateHojaResumen',$this->data,true);
    break;

    case "CON":
        $pdf = new Pdf('P', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->SetTitle('Contrato S&#250;per Avance');
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        $html =  $this->load->view('pdf/templateContrato',$this->data,true);
    break;
    case "PRO":

        $pdf = new Pdf('P', 'mm', "A6", true, 'UTF-8', false);
        $pdf->SetTitle('Hospitalización por accidentes graves');
        $pdf->SetHeaderMargin(0);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 8, 15);
        $pdf->AddPage();
        $fecha = date('d-m-Y');

        $certificadoVigente = $this->data['datos']['certificadoVigente1'];

        $html =  $this->load->view($certificadoVigente,$this->data,true);
//        $html =  $this->load->view('pdf/CertificadoSuperAvance-RentaAcc+ITP2',$this->data,true);
    break;
    case "DES":
        $pdf = new Pdf('P', 'mm', 'A6', true, 'UTF-8', false);
        $pdf->SetTitle('Proteccion de vida');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(5);
        $pdf->setFooterMargin(5);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 8, 15);
        $pdf->AddPage();
        $fecha = date('d-m-Y');

        $certificadoVigente =  $this->data['datos']['certificadoVigente2'];;
        $html =  $this->load->view($certificadoVigente,$this->data,true);
//        $html =  $this->load->view('pdf/CertificadoSuperAvance-Desgravamen',$this->data,true);
    break;

    default:
    break;
}

$pdf->writeHTML($html, true, false, true, false, '');

switch ($type) {
    case "COT":
    $pdf->Output("/tmp/".'resumen.pdf', 'F');
    $value['descRetorno'] = "Resumen creado con Éxito..";
    $filename = "/tmp/".'resumen.pdf';
    $filedesc = "HOJA RESUMEN";
    break;

    case "CON":
    $pdf->Output("/tmp/".'contrato.pdf', 'F');
    $value['descRetorno'] = "Contrato creado con Éxito..";
    $filename = "/tmp/".'contrato.pdf';
    $filedesc = "CONTRATO SÚPER AVANCE";
    break;

    case "PRO":
    $pdf->Output("/tmp/".'proteccion.pdf', 'F');
    $value['descRetorno'] = "Solicitud de incorporacion creado con Éxito..";
    $filename = "/tmp/".'proteccion.pdf';
    $filedesc = "PROPUESTA HOSPITALIZACION";
    break;
    case "DES":
    $pdf->Output("/tmp/".'desgravamen.pdf', 'F');
    $value['descRetorno'] = "Solicitud de DESGRAVAMEN creado con Éxito..";
    $filename = "/tmp/".'desgravamen.pdf';
    $filedesc = "PROPUESTA DESGRAVAMEN";
    break;

    default:
    break;
}

$fp = fopen($filename, 'r+b');
      $data = fread($fp, filesize($filename));
      fclose($fp);

$data = mysqli_real_escape_string($this->get_mysqli(),$data);
$fecha = date("Y-m-d H:i:s");

$nameUser = $this->session->userdata("username");
$office = $this->session->userdata("id_office");
$id_user = $this->session->userdata("id");

$sqlcall = $this->db->query("INSERT INTO ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,digit_rut_client,name_client,idDocument,typeDocument,id_user_last_print, id_office_last_print) VALUES ('".$fecha."',".$id_user.",'".$office."',2,'".$filedesc."','".$data."',". $nroRut.",'".$dgvRut."','".$this->data['datos']['nameClient']."','".$this->data["id"]."','".$type."','".$nameUser."','".$office."');");

$value['retorno'] = 0;
$data = $value;
return ($data);

}

private function get_simulateById($nroSimulacion, $tipoDocumento, $format) {

    $result = check_session("");

    $username = $this->session->userdata("username");

    if($nroSimulacion=="" || $nroSimulacion==0) {
        cancel_function(COD_ERROR_INIT, "Error, número simulación debe ser distinto de cero..","");
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
    $soap = get_SOAP($EndPoint, WS_Action_DatosOpComercialTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_DatosOpComercialTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      if($format=="array"){ return $data; }
      else { return json_encode($data); exit(0);}
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0) {

        $value['nroRut'] = number_format((float)$xml->Body->DATA->response->nroRut,0,',','.');
        $value['dgvRut'] = $xml->Body->DATA->response->dvRut;

        $nroRut = $value['nroRut']."-".$value['dgvRut'];
        $result = ws_GET_HomologadorByRut($nroRut, $username);
        if($result["retorno"]!=0){

            $value["retorno"] = $result["retorno"];
            $value["descRetorno"] = $result["descRetorno"];
            $data = $value;

            if($format=="array"){ return $data; }
            else { return json_encode($data); exit(0);}

        }else{
            $value["flg_flujo"] = $result["flg_flujo"];
        }

        if(substr($tipoDocumento,0,1)=="C"){

            $arrDataLink = $this->readRequestLinked($nroSimulacion);
            if($arrDataLink["retorno"]!=0){
                $value["retorno"] = $arrDataLink["retorno"];
                $value["descRetorno"] = $arrDataLink["descRetorno"];
                $data = $value;

                if($format=="array"){ return $data; }
                else { return json_encode($data); exit(0);}
            }
            $value["estadoEnlace"] = $arrDataLink["estadoEnlace"];
            $value["tipoEstado"] = $arrDataLink["tipoEstado"];
            $value["glosaEstado"] = $arrDataLink["glosaEstado"];
            $value["glosaEnlace"] = $arrDataLink["glosaEnlace"];

            $result = $this->parameters->get_officeById($arrDataLink["sucursalOrigen"]);
            if($result!=false) { $value["sucursalOrigen"] = $result->name; } else { $value["sucursalOrigen"] = "-"; }

            $result = $this->parameters->get_officeById($arrDataLink["sucursalDestino"]);
            if($result!=false) { $value["sucursalDestino"] = $result->name; } else { $value["sucursalDestino"] = "-"; }

            $result = $this->parameters->get_officeById($arrDataLink["sucursalCurse"]);
            if($result!=false) { $value["sucursalCurse"] = $result->name; } else { $value["sucursalCurse"] = "-"; }

        }

        $value["domicilio"] = (string)$xml->Body->DATA->response->domicilio;
        $value["calle"] = (string)$xml->Body->DATA->response->calle;
        $value["numCalle"] = (string)$xml->Body->DATA->response->numCalle;
        $value["numDepto"] = (string)$xml->Body->DATA->response->numDepto;
        $value["block"] = (string)$xml->Body->DATA->response->block;
        $value["poblacion"] = (string)$xml->Body->DATA->response->poblacion;
        $value["comuna"] = (string)$xml->Body->DATA->response->comuna;
        $value["ciudad"] = (string)$xml->Body->DATA->response->ciudad;
        $value["region"] = (string)$xml->Body->DATA->response->region;
        $value["fonoFijo"] = (string)$xml->Body->DATA->response->telefonoFijo;
        $value["fonoMovil"] = (string)$xml->Body->DATA->response->telefonoMovil;
        $value["email"] = (string)$xml->Body->DATA->response->email;
        $value["modalidadVenta"] = (string)$xml->Body->DATA->response->modalidadVenta;
        if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING) {
            $value["canalVenta"] = "por Telemarketing";
        }else{
            $value["canalVenta"] = "";
        }

        $value['estado'] = (string)$xml->Body->DATA->response->estado;
        $value['idDocument'] = $nroSimulacion;
        $value['nameClient'] = $xml->Body->DATA->response->nombres." ".$xml->Body->DATA->response->apellidoPaterno." ".$xml->Body->DATA->response->apellidoMaterno;
        $value['birthDate'] = $this->session->userdata("fechaNacimiento");
        $value['nroRut'] = number_format((float)$xml->Body->DATA->response->nroRut,0,',','.');
        $value['dgvRut'] = (string)$xml->Body->DATA->response->dvRut;
        $value['fecha'] = substr($xml->Body->DATA->response->fecha,0,10);
        $value['fechahora'] = substr($xml->Body->DATA->response->fecha,0,16);
        $value['tasaInteresMoratorio'] = $xml->Body->DATA->response->tasaInteresMoratorio;
        $value['diasDeVigenciaCotizacion'] = (int)$xml->Body->DATA->response->diasDeVigenciaCotizacion;
        $value['sexo'] = (string)$xml->Body->DATA->response->sexo;
        $value['tasaDeInteresMensual'] = $xml->Body->DATA->response->tasaDeInteresMensual ." %";
        $value['cargaAnualEquivalente'] = $xml->Body->DATA->response->cargaAnualEquivalente ." %";

        $value["tasaRequest"] = (float)$xml->Body->DATA->response->tasaDeInteresMensual;
        $fieldPlazo = 1; // plazo = 0 menor a 90 días / plazo = 1 mayor a 90 días
        $fieldMontoPesos = (float)$xml->Body->DATA->response->montoLiquido;

        $result = ws_GET_TasaMaxima(1,$fieldMontoPesos, $username);
/*provisorio*/
//        if($result["retorno"]==0) { $value["tasaMaxima"] = $result["tasaMaxima"]; } else { $value["tasaMaxima"] = 0;}
        if($result["retorno"]==0) { $value["tasaMaxima"] = $result["tasaMaxima"]; } else { $value["tasaMaxima"] = $value["tasaRequest"]; }
/*provisorio*/
        $value['pan'] = substr($xml->Body->DATA->response->pan,0,4)."-".substr($xml->Body->DATA->response->pan,4,4)."-".substr($xml->Body->DATA->response->pan,8,4)."-".substr($xml->Body->DATA->response->pan,12,4);
        $value['montoBruto'] = number_format((float)$xml->Body->DATA->response->montoBruto,0,',', '.');
        $value['montoLiquido'] = number_format((float)$xml->Body->DATA->response->montoLiquido,0,',', '.');
        $value['plazoDeCuota'] = (int)$xml->Body->DATA->response->plazo;
        $value['valorDeCuota'] = number_format((float)$xml->Body->DATA->response->valorDeCuota,0,',', '.');
        $value['fechaPrimerVencimiento'] = substr($xml->Body->DATA->response->fechaPrimerVencimiento,0,10);
        $value['fechaUltimoVencimiento'] = substr($xml->Body->DATA->response->fechaUltimoVencimiento,0,10);
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
        $value["tipoOferta"] = (string)$xml->Body->DATA->response->tipoOferta;
        $value['glosatipoOferta'] = "";
        if((string)$xml->Body->DATA->response->tipoOferta=="PA"){
            $value['glosatipoOferta'] = "PREAPROBADO";
        }
        if((string)$xml->Body->DATA->response->tipoOferta=="AP"){
            $value['glosatipoOferta'] = "APROBADO";
        }

        $id_office = (string)$xml->Body->DATA->response->codLocal;
        if($id_office!=""){
            $office = $this->parameters->get_officeById($id_office);
            if(isset($office->name)) { $value["glosaCodLocal"] = $office->name; }
            else { $value["glosaCodLocal"] = "-"; }
        }else{
            $value["glosaCodLocal"] = "-";
        }

        $ind = 1;
        $value['flagSeguro1'] = "SIN SEGURO";
        $value['htmlName1'] = "secureOne";
        $value['nameSeguro1'] = "";
        $value['costoMensualSeguro1'] = "-";
        $value['costoTotalSeguro1'] = "0";
        $value['coberturaSeguro1'] = "Sin Seguro";
        $value['nameCompany1'] = "-";
        $value['nroRutCompany1'] = "-";

        $value['flagSeguro2'] = "SIN SEGURO";
        $value['htmlName2'] = "secureTwo";
        $value['nameSeguro2'] = "";
        $value['costoMensualSeguro2'] = "-";
        $value['costoTotalSeguro2'] = "0";
        $value['coberturaSeguro2'] = "Sin Seguro";
        $value['nameCompany2'] = "-";
        $value['nroRutCompany2'] = "-";
        $value["useEmail1"] = 0;
        $value["useEmail2"] = 0;
        $value["declareDps"] = 0;
        $value["typeBeneficiaries"] = "";

        foreach ($xml->Body->DATA->response->listaSeguros as $record) {

            foreach ($record as $field) {

                $codSeguro = (string)$field->codSeguro;
                $idPoliza = $field->idPoliza;
                $costoTotalSeguro = $field->costoTotalSeguro;

                $descrip = ""; $nameCompany = ""; $nroPoliza = ""; $htmlName = "";
                $nroRutCompany = "";
                $secure = $this->parameters->get_secureById($codSeguro);

                $nameCompany = $secure->nameCompany;
                $descrip = $secure->descrip;
                $nroPoliza = $secure->nroPoliza;
                $htmlName = $secure->htmlName;
                $nroRutCompany = $secure->nroRut ."-".$secure->dgvRut;
                $certificadoVigente=$secure->certificadoVigente;

                if($codSeguro=="03" OR $codSeguro=="05"){
                    $value['flagSeguro1'] = "CON SEGURO";
                    $value['htmlName1'] = $htmlName;
                    $value['nameSeguro1'] = $descrip;
                    $value['costoMensualSeguro1'] = "-";
                    $value['costoTotalSeguro1'] = number_format((float)$costoTotalSeguro,0, ",", ".");
                    $value['coberturaSeguro1'] = "P&#243;liza ".$nroPoliza;
                    $value['nameCompany1'] = $nameCompany;
                    $value['nroRutCompany1'] = $nroRutCompany;
                    $value['nroPoliza1'] = $nroPoliza;
                    $value['certificadoVigente1'] = $certificadoVigente;
                    $result = $this->documents->get_journalSecureByID($nroSimulacion, $codSeguro);
                    if($result!=false) {
                        $value['useEmail1'] = $result->email;
                        $value['declareDps'] = $result->declareDps;
                    }else{
                        $value['useEmail1'] = 0;
                        $value['declareDps'] = 0;
                    }

                }else{

                    $value['flagSeguro2'] = "CON SEGURO";
                    $value['htmlName2'] = $htmlName;
                    $value['nameSeguro2'] = $descrip;
                    $value['costoMensualSeguro2'] = "-";
                    $value['costoTotalSeguro2'] = number_format((float)$costoTotalSeguro,0, ",", ".");
                    $value['coberturaSeguro2'] = "P&#243;liza ".$nroPoliza;
                    $value['nameCompany2'] = $nameCompany;
                    $value['nroPoliza2'] = $nroPoliza;
                    $value['nroRutCompany2'] = $nroRutCompany;
                    $value['certificadoVigente2'] = $certificadoVigente;

                    $result = $this->documents->get_journalSecureByID($nroSimulacion, $codSeguro);
                    if($result!=false) {
                        $value['useEmail2'] = $result->email;
                        $value['typeBeneficiaries'] = $result->typeBeneficiaries;
                    }else{
                        $value['useEmail2'] = 0;
                        $value['typeBeneficiaries'] = "legal";
                    }

                    if($value['typeBeneficiaries']=="other") {

                        $dataBeneficiarios = $this->get_beneficiarios($nroSimulacion, $codSeguro);

                        if($dataBeneficiarios["retorno"]==0) {

                            $value["apellidoMaterno1"] = $dataBeneficiarios["apellidoMaterno1"];
                            $value["apellidoPaterno1"] = $dataBeneficiarios["apellidoPaterno1"];
                            $value["nombres1"] = $dataBeneficiarios["nombres1"];
                            $value["parentesco1"] = $dataBeneficiarios["parentesco1"];
                            $value["dv1"] = $dataBeneficiarios["dv1"];
                            $value["rut1"] = $dataBeneficiarios["rut1"];
                            $value["porcDistribucion1"] = $dataBeneficiarios["porcDistribucion1"];
                            $value["contacto1"] = $dataBeneficiarios["contacto1"];

                            $value["apellidoMaterno2"] = $dataBeneficiarios["apellidoMaterno2"];
                            $value["apellidoPaterno2"] = $dataBeneficiarios["apellidoPaterno2"];
                            $value["nombres2"] = $dataBeneficiarios["nombres2"];
                            $value["parentesco2"] = $dataBeneficiarios["parentesco2"];
                            $value["dv2"] = $dataBeneficiarios["dv2"];
                            $value["rut2"] = $dataBeneficiarios["rut2"];
                            $value["porcDistribucion2"] = $dataBeneficiarios["porcDistribucion2"];
                            $value["contacto2"] = $dataBeneficiarios["contacto2"];

                            $value["apellidoMaterno3"] = $dataBeneficiarios["apellidoMaterno3"];
                            $value["apellidoPaterno3"] = $dataBeneficiarios["apellidoPaterno3"];
                            $value["nombres3"] = $dataBeneficiarios["nombres3"];
                            $value["parentesco3"] = $dataBeneficiarios["parentesco3"];
                            $value["dv3"] = $dataBeneficiarios["dv3"];
                            $value["rut3"] = $dataBeneficiarios["rut3"];
                            $value["porcDistribucion3"] = $dataBeneficiarios["porcDistribucion3"];
                            $value["contacto3"] = $dataBeneficiarios["contacto3"];

                            $value["apellidoMaterno4"] = $dataBeneficiarios["apellidoMaterno4"];
                            $value["apellidoPaterno4"] = $dataBeneficiarios["apellidoPaterno4"];
                            $value["nombres4"] = $dataBeneficiarios["nombres4"];
                            $value["parentesco4"] = $dataBeneficiarios["parentesco4"];
                            $value["dv4"] = $dataBeneficiarios["dv4"];
                            $value["rut4"] = $dataBeneficiarios["rut4"];
                            $value["porcDistribucion4"] = $dataBeneficiarios["porcDistribucion4"];
                            $value["contacto4"] = $dataBeneficiarios["contacto4"];
                        }

                    }

                }
                $ind = $ind + 1;
            }
        }

        $value['gastosCobranza1'] = trim((string)$xml->Body->DATA->response->gastosCobranza1);
        $value['gastosCobranza2'] = trim((string)$xml->Body->DATA->response->gastosCobranza2);
        $value['gastosCobranza3'] = trim((string)$xml->Body->DATA->response->gastosCobranza3);

        $value["garantiasAsociadas"] = "NO";
        $value["cargoPrepago"] = $xml->Body->DATA->response->cargoPrepago;
        $value["plazoAvisoPrepago"] = $xml->Body->DATA->response->plazoAvisoPrepago;
        $value["banco"] = (string)$xml->Body->DATA->response->banco;
        $value["tipoCuenta"] = (string)$xml->Body->DATA->response->tipoCuenta;
        $value["numeroCuenta"] = (string)$xml->Body->DATA->response->numeroCuenta;

        $costoTotalSeguro1 = str_replace(".", "", $value["costoTotalSeguro1"]);
        $costoTotalSeguro2 = str_replace(".", "", $value["costoTotalSeguro2"]);

        $fieldMontoaFinanciar = (float)$xml->Body->DATA->response->montoLiquido +
                              (float)$costoTotalSeguro1 + (float)$costoTotalSeguro2;

        $value["montoaFinanciar"] = number_format((float)$fieldMontoaFinanciar,0,',', '.');

        $result = $this->glossary->get_BancosById($value["banco"]);
        if($result!=false) { $value["glosaBanco"] = $result->NAME; }
        else { $value["glosaBanco"] = ""; }

        $result = $this->glossary->get_tipoCuentasById($value["tipoCuenta"]);
        if($result!=false) { $value["glosaCuenta"] = $result->NAME; }
        else { $value["glosaCuenta"] = ""; }

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

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["id_rol"] = $this->session->userdata("id_rol");
    $data = $value;

    if($format=="array"){ return $data; }
    else { return json_encode($data); }
}

/**
 * End:: CC033
 **/

public function index() {

    $return = check_session("4.1.1");

    $id_rol = $this->session->userdata("id_rol");
    $id_office = $this->session->userdata("id_office");
    $dataOffice = $this->parameters->getall_office();

    $todayDate = date("d-m-Y");
    $dataLoad['dataRange'] = array('dateEnd' => "",
            'dateBegin' => "" );

    $dataLoad['dataRequestStatus'] = $this->users->parameters->getall_requestStatus();
    $dataLoad['environment'] = array(
            'id_rol' => $id_rol
    );

    $optionOffice["optionOffice"] = "";
    foreach ($dataOffice as $nodo) {
        if($id_office==$nodo->id_office) {

        $optionOffice["optionOffice"] .= "<option selected value='".$nodo->id_office."'>".$nodo->name."</option>";

        } else {

        $optionOffice["optionOffice"] .= "<option value='".$nodo->id_office."'>".$nodo->name."</option>";

        }
    }
    $dataLoad["dataOffice"] = $optionOffice;

    $this->load->view('advance/search', $dataLoad);
}

public function search() {

    $return = check_session("4.1.1");
    $id_rol = $this->session->userdata("id_rol");
    $id_office = $this->session->userdata("id_office");
    $dataOffice = $this->parameters->getall_office();

    $todayDate = date("d-m-Y");
    $dataLoad['dataRange'] = array('dateEnd' => "",
            'dateBegin' => "" );
    $dataLoad['environment'] = array(
        'id_rol' => $id_rol
        );

    $optionOffice["optionOffice"] = "";
    foreach ($dataOffice as $nodo) {
        if($id_office==$nodo->id_office) {

        $optionOffice["optionOffice"] .= "<option selected value='".$nodo->id_office."'>".$nodo->name."</option>";

        } else {

        $optionOffice["optionOffice"] .= "<option value='".$nodo->id_office."'>".$nodo->name."</option>";

        }
    }

    $dataLoad["dataRequestStatus"] = $this->users->parameters->getall_requestStatus();
    $dataLoad["dataOffice"] = $optionOffice;
    $this->load->view('advance/search', $dataLoad);
}

public function simulate() {

    $return = check_session("4.1.2");

    $id_rol = $this->session->userdata("id_rol");

    $minQuotas=0; $maxQuotas=0; $minDeferred=0; $maxDeferred=0;
    $result = $this->parameters->get_quotasByProduct(CODIGO_SUPER_AVANCE);
    $minQuotas = (int)$result->CUOTAS_MINIMO;
    $maxQuotas = (int)$result->CUOTAS_MAXIMO;

    $result = $this->parameters->get_quotasDeferredByProduct(CODIGO_SUPER_AVANCE);
    $minDeferred = (int)$result->CUOTAS_MINIMO;
    $maxDeferred = (int)$result->CUOTAS_MAXIMO;

    $result = $this->parameters->get_amountByProduct(CODIGO_SUPER_AVANCE);
    $minAmount = (int)$result->MONTO_MINIMO;
    $maxAmount = (int)$result->MONTO_MAXIMO;

    $arrDataLoad = array(
        'titleAmountSimulate' => "Monto m&#237;nimo $".number_format($minAmount,0,",",".")." m&#225;ximo $".number_format($maxAmount,0,",","."),
        'titleNumberQuotas' => "M&#237;nimo ".$minQuotas." Cuotas m&#225;ximo ".$maxQuotas." cuotas",
        'titleDeferredQuotas' => "M&#237;nimo ".$minDeferred." m&#225;ximo ".$maxDeferred,
        'titleInteresRate' => "Tasa M&#225;xima 3,95%",
        'titleDateFirstExpiration' => "Fecha Vencimiento Tarjeta Cruz Verde",
        'minNumberQuotas' => $minQuotas,
        'maxNumberQuotas' => $maxQuotas,
        'minDeferredQuotas' => $minDeferred,
        'maxDeferredQuotas' => $maxDeferred,
        'interesRate' => "",
        'dateFirstExpiration' => "",
        'minAmount' => $minAmount,
        'maxAmount' => $maxAmount

        );
    $data['dataLoad'] = $arrDataLoad;
    $data['dataSecure'] = $this->parameters->get_secureByRol($id_rol, CODIGO_SUPER_AVANCE);

    $this->load->view('advance/simulate', $data);
}


public function create(){
    $return = check_session("4.1.4");

    $id_rol =$this->session->userdata("id_rol");

    $minQuotas=0; $maxQuotas=0; $minDeferred=0; $maxDeferred=0;
    $result = $this->parameters->get_quotasByProduct(CODIGO_SUPER_AVANCE);
    $minQuotas = (int)$result->CUOTAS_MINIMO;
    $maxQuotas = (int)$result->CUOTAS_MAXIMO;

    $result = $this->parameters->get_quotasDeferredByProduct(CODIGO_SUPER_AVANCE);
    $minDeferred = (int)$result->CUOTAS_MINIMO;
    $maxDeferred = (int)$result->CUOTAS_MAXIMO;

    $arrDataLoad = array(
        'minNumberQuotas' => $minQuotas,
        'maxNumberQuotas' => $maxQuotas,
        'minDeferredQuotas' => $minDeferred,
        'maxDeferredQuotas' => $maxDeferred,
        'interesRate' => "",
        'dateFirstExpiration' => "",
        'amountApproved' => 250000,
        'amountPreAproved' => 300000,
        'emailClient' => "",
        'dataload' => '{ "source": "evaluation" } '
      );
    $dataSecure = $this->parameters->get_secureByRol($id_rol, CODIGO_SUPER_AVANCE);
    $dataOffice = $this->parameters->getall_office();

    $valueOffice["optionOfficeLinked"] = "";
    foreach ($dataOffice as $nodo) {
        $valueOffice["optionOfficeLinked"] .= "<option value='".$nodo->id_office."'>".$nodo->name."</option>";
    }

    $ind = 1; $valueOne = array(); $valueTwo = array();
    foreach($dataSecure as $nodo) {

        if($ind==1){
            $valueOne["htmlName"] = $nodo->htmlName;
            $valueOne["htmlModal"] = $nodo->htmlModal;
            $valueOne["htmlDescrip"] = $nodo->descrip;
            $valueOne["htmlValue"] = $nodo->codSecure;
            $valueOne["codSecure"] = $nodo->codSecure;
            $valueOne["idPoliza"] = $nodo->idPoliza;
            $valueOne["htmlScript"] = $nodo->htmlScript;
        }

        if($ind==2){
            $valueTwo["htmlName"] = $nodo->htmlName;
            $valueTwo["htmlModal"] = $nodo->htmlModal;
            $valueTwo["htmlDescrip"] = $nodo->descrip;
            $valueTwo["htmlValue"] = $nodo->codSecure;
            $valueTwo["codSecure"] = $nodo->codSecure;
            $valueTwo["idPoliza"] = $nodo->idPoliza;
            $valueTwo["htmlScript"] = $nodo->htmlScript;
        }
        $ind = $ind + 1;
    }

    $data["dataLoad"] = $arrDataLoad;
    $data["secureOne"] = $valueOne;
    $data["secureTwo"] = $valueTwo;
    $data["officeLinked"] = $valueOffice;


    $this->load->view('advance/create', $data);
}


public function create_back() {

    $return = check_session("4.1.4");

    $id_rol = $this->session->userdata("id_rol");

    $minQuotas=0; $maxQuotas=0; $minDeferred=0; $maxDeferred=0;
    $result = $this->parameters->get_quotasByProduct(CODIGO_SUPER_AVANCE);
    $minQuotas = (int)$result->CUOTAS_MINIMO;
    $maxQuotas = (int)$result->CUOTAS_MAXIMO;

  $result = $this->parameters->get_quotasDeferredByProduct(CODIGO_SUPER_AVANCE);
  $minDeferred = (int)$result->CUOTAS_MINIMO;
  $maxDeferred = (int)$result->CUOTAS_MAXIMO;

  $arrDataLoad = array(
      'minNumberQuotas' => $minQuotas,
      'maxNumberQuotas' => $maxQuotas,
      'minDeferredQuotas' => $minDeferred,
      'maxDeferredQuotas' => $maxDeferred,
      'interesRate' => "",
      'dateFirstExpiration' => "",
      'amountApproved' => 250000,
      'amountPreAproved' => 300000,
      'emailClient' => ""
      );
  $dataSecure = $this->parameters->get_secureByRol($id_rol, CODIGO_SUPER_AVANCE);
  $dataOffice = $this->parameters->getall_office();

  $valueOffice["optionOfficeLinked"] = "";
  foreach ($dataOffice as $nodo) {
      $valueOffice["optionOfficeLinked"] .= "<option value='".$nodo->id_office."'>".$nodo->name."</option>";
  }

  $ind = 1; $valueOne = array(); $valueTwo = array();
  foreach($dataSecure as $nodo) {

      if($ind==1){
          $valueOne["htmlName"] = $nodo->htmlName;
          $valueOne["htmlModal"] = $nodo->htmlModal;
          $valueOne["htmlDescrip"] = $nodo->descrip;
          $valueOne["htmlValue"] = $nodo->codSecure;
          $valueOne["codSecure"] = $nodo->codSecure;
          $valueOne["idPoliza"] = $nodo->idPoliza;
          $valueOne["htmlScript"] = $nodo->htmlScript;
      }

      if($ind==2){
          $valueTwo["htmlName"] = $nodo->htmlName;
          $valueTwo["htmlModal"] = $nodo->htmlModal;
          $valueTwo["htmlDescrip"] = $nodo->descrip;
          $valueTwo["htmlValue"] = $nodo->codSecure;
          $valueTwo["codSecure"] = $nodo->codSecure;
          $valueTwo["idPoliza"] = $nodo->idPoliza;
          $valueTwo["htmlScript"] = $nodo->htmlScript;
      }
      $ind = $ind + 1;
  }

  $data["dataLoad"] = $arrDataLoad;
  $data["secureOne"] = $valueOne;
  $data["secureTwo"] = $valueTwo;
  $data["officeLinked"] = $valueOffice;

  $this->load->view('advance/create', $data);
}

public function remote() {

    $return = check_session("4.1.4");

    $id_rol =$this->session->userdata("id_rol");

    $minQuotas=0; $maxQuotas=0; $minDeferred=0; $maxDeferred=0;
    $result = $this->parameters->get_quotasByProduct(CODIGO_SUPER_AVANCE);
    $minQuotas = (int)$result->CUOTAS_MINIMO;
    $maxQuotas = (int)$result->CUOTAS_MAXIMO;

    $result = $this->parameters->get_quotasDeferredByProduct(CODIGO_SUPER_AVANCE);
    $minDeferred = (int)$result->CUOTAS_MINIMO;
    $maxDeferred = (int)$result->CUOTAS_MAXIMO;

    $arrDataLoad = array(
        'minNumberQuotas' => $minQuotas,
        'maxNumberQuotas' => $maxQuotas,
        'minDeferredQuotas' => $minDeferred,
        'maxDeferredQuotas' => $maxDeferred,
        'interesRate' => "",
        'dateFirstExpiration' => "",
        'amountApproved' => 250000,
        'amountPreAproved' => 300000,
        'emailClient' => "",
        'dataload' => '{ "source": "evaluation" } '
      );
    $dataSecure = $this->parameters->get_secureByRol($id_rol, CODIGO_SUPER_AVANCE);
    $dataOffice = $this->parameters->getall_office();

    $valueOffice["optionOfficeLinked"] = "";
    foreach ($dataOffice as $nodo) {
        $valueOffice["optionOfficeLinked"] .= "<option value='".$nodo->id_office."'>".$nodo->name."</option>";
    }

    $ind = 1; $valueOne = array(); $valueTwo = array();
    foreach($dataSecure as $nodo) {

        if($ind==1){
            $valueOne["htmlName"] = $nodo->htmlName;
            $valueOne["htmlModal"] = $nodo->htmlModal;
            $valueOne["htmlDescrip"] = $nodo->descrip;
            $valueOne["htmlValue"] = $nodo->codSecure;
            $valueOne["codSecure"] = $nodo->codSecure;
            $valueOne["idPoliza"] = $nodo->idPoliza;
            $valueOne["htmlScript"] = $nodo->htmlScript;
        }

        if($ind==2){
            $valueTwo["htmlName"] = $nodo->htmlName;
            $valueTwo["htmlModal"] = $nodo->htmlModal;
            $valueTwo["htmlDescrip"] = $nodo->descrip;
            $valueTwo["htmlValue"] = $nodo->codSecure;
            $valueTwo["codSecure"] = $nodo->codSecure;
            $valueTwo["idPoliza"] = $nodo->idPoliza;
            $valueTwo["htmlScript"] = $nodo->htmlScript;
        }
        $ind = $ind + 1;
    }

    $data["dataLoad"] = $arrDataLoad;
    $data["secureOne"] = $valueOne;
    $data["secureTwo"] = $valueTwo;
    $data["officeLinked"] = $valueOffice;

    $this->load->view('advance/remote', $data);
}

public function get_documentsByRut(){

    $return = check_session("");

    $nroRut = $this->input->post("id"); $doctos = array();
    $filters = $this->input->post("filters");

    $result = $this->get_lightClient($nroRut);
    $retorno = $result["retorno"]; $descRetorno = $result["descRetorno"];

    if($retorno==0) {

        $value["nameClient"] = $result["nameClient"];
        $rut = str_replace('.', '', $nroRut); $rut = str_replace('-', '', $rut); $rut = substr($rut, 0, -1);

        $dataInput = array(
            "nroRut" => $rut,
            "filters" => $filters
        );
        $valor = $this->documents->get_documentsByRut($dataInput);

        if($valor!=false) {

            foreach ($valor as $key) {

                if (searchdocument($key->idDocument)){

                    $eval = searchdocument($key->idDocument);
                    $id_image = $eval->id;

                }else{
                    $id_image = false;
                }
                $code["id_image"] = $id_image;

                $code["correl"] = $key->correl;
                $code["name"] = $key->name;
                $code["idDocument"] = $key->idDocument;
                $code["typeDocument"] = $key->typeDocument;
                $code["id_user_last_print"] = $key->id_user_last_print;

                $code["id_user"] = $key->id_user;
                $result = $this->users->get_usersById($key->id_user);
                if($result!=false){ $code["username"] = $result->username; }else { $code["username"] = "No Existe"; }

                $code["stamp_last_print"] = $key->stamp_last_print;
                $code["stamp"] = $key->stamp;

                $code["id_office"] = $key->id_office;
                $result = $this->parameters->get_officeById($key->id_office);
                if($result!=false) { $code["nameOffice"] = $result->name; } else { $code["nameOffice"] = "No Existe"; }
                $code["id_office_last_print"] = $key->id_office_last_print;
                if($key->status==1){ $code["status"] = "VIGENTE"; } else { $code["status"] = "HISTORICO"; }

                $doctos[] = $code;
            }

        }
    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $data["dataCliente"] = $value;
    $data["dataDoctos"] = $doctos;

    echo json_encode($data);
}

private function get_lightClient($nroRut) {

    $return = check_session("");

    $username = $this->session->userdata("username");

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if($dataHomologador["retorno"]==0){

        $value["retorno"] = $dataHomologador["retorno"];
        $value["descRetorno"] = $dataHomologador["descRetorno"];
        $flg_flujo = $dataHomologador["flg_flujo"];
        $origen = $dataHomologador["origen"];
        $nroTcv = $dataHomologador["nroTcv"];

    }else{

        $value["retorno"] = $dataHomologador["retorno"];
        $value["descRetorno"] = $dataHomologador["descRetorno"];
        $data = $value;
        return($data);
    }

    $result = ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username);
    if($result["retorno"]==0){

      $value["retorno"] = $result["retorno"];
      $value["descRetorno"] = $result["descRetorno"];
      $value["nombres"] = $result["nombres"];
      $value["apellidoPaterno"] = $result["apellidoPaterno"];
      $value["apellidoMaterno"] = $result["apellidoMaterno"];
      $value["nameClient"] = $result["nombres"]." ".$result["apellidoPaterno"]." ".$result["apellidoMaterno"];
      $value["nroTcv"] = $nroTcv;

    }else{

      $value["retorno"] = $result["retorno"];
      $value['descRetorno'] = $result["descRetorno"];
      $value["nameClient"] = "";

    }

    $data = $value;
    return($data);

}

private function validaCliente($nroRut, $flg_flujo){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1); $username = $this->session->userdata("username");

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
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosClienteTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosClienteTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;
    if($retorno==0) {
        $value["nombres"] = (string)$xml->Body->DATA->Registro->nombres;
        $value["apellidoPaterno"] = (string)$xml->Body->DATA->Registro->apellidoPaterno;
        $value["apellidoMaterno"] = (string)$xml->Body->DATA->Registro->apellidoMaterno;
    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $data = $value;

    return($data);
}

public function put_Beneficiary() {

    $return = check_session("");

    $this->form_validation->set_rules('lastMotherBeneficiary', 'Apellido Materno', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('lastFatherBeneficiary', 'Apellido Paterno', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('nameBeneficiary', 'Nombre', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('masked_rut_beneficiary', 'N&#250;mero Rut', 'required');
    $this->form_validation->set_rules('relationBeneficiary', 'Parentesco', 'required');
    $this->form_validation->set_rules('percentBeneficiary', 'Porcentaje', 'required|integer|less_than_equal_to[100]|greater_than[0]');
    $this->form_validation->set_rules('contactBeneficiary', 'Contacto', 'required|numeric');
    $this->form_validation->set_message('required','El atributo %s Beneficiario es obligatorio');
    $this->form_validation->set_message('integer','El atributo %s Beneficiario debe ser numerico');
    $this->form_validation->set_message('numeric','El atributo %s Beneficiario debe ser numerico');
    $this->form_validation->set_message('alpha_numeric_spaces','El atributo %s Beneficiario debe ser Albabetico');
    $this->form_validation->set_message('greater_than','El atributo %s Beneficiario debe ser mayor que 1');
    $this->form_validation->set_message('less_than_equal_to','El atributo %s Beneficiario debe ser menor o igual a 100');
    if(!$this->form_validation->run()){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = $this->input->post("masked_rut_beneficiary");
    $nameBeneficiary = $this->input->post("nameBeneficiary");
    $lastMotherBeneficiary = $this->input->post("lastMotherBeneficiary");
    $lastFatherBeneficiary = $this->input->post("lastFatherBeneficiary");
    $relationBeneficiary = $this->input->post("relationBeneficiary");
    $percentBeneficiary = $this->input->post("percentBeneficiary");
    $contactBeneficiary = $this->input->post("contactBeneficiary");

    $dgvRut = substr($nroRut, -1);
    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $r = new Rut();
    $r->number($nroRut);
    $digRut = $r->calculateVerificationNumber();

    if($dgvRut!=$digRut) {
        cancel_function(COD_ERROR_INIT, "Error, Rut ingresado no es Valido".$dgvRut." ".$digRut." ".$nroRut, "");
    }

    $value["retorno"] = 0;
    $value["descRetorno"] = "Trancción Aceptada";

    $data = $value;
    echo json_encode($data);
}

public function get_client() {

    $return = check_session("");
    $this->form_validation->set_rules('masked_rut_client', 'N&#250;mero Rut', 'required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = $this->input->post("masked_rut_client"); $username = $this->session->userdata("username");

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if($dataHomologador["retorno"]!=0){
        cancel_function($dataHomologador["retorno"],$dataHomologador["descRetorno"],"");
    }

    $flg_flujo = $dataHomologador["flg_flujo"];
    $origen = $dataHomologador["origen"];
    $nroTcv = $dataHomologador["nroTcv"];

    $dataCliente = $this->validaCliente($nroRut, $flg_flujo);
    if($dataCliente["retorno"]!=0){
        cancel_function($dataCliente["retorno"],$dataCliente["descRetorno"],"");
    }

    $nombres = $dataCliente["nombres"];
    $apellidoPaterno = $dataCliente["apellidoPaterno"];
    $apellidoMaterno = $dataCliente["apellidoMaterno"];

    $nameClient = $nombres;
    $last_nameClient = $apellidoPaterno .' '. $apellidoMaterno;

    $dataCuenta = $this->validaDatosCuenta($nroRut, $flg_flujo);
    if($dataCuenta["retorno"]!=0){
        cancel_function($dataCuenta["retorno"],$dataCuenta["descRetorno"],"");
    }


    $contrato = (string)$dataCuenta["contrato"];

    $this->session->set_userdata("nroTcv", $nroTcv);
    $this->session->set_userdata("flg_flujo", $flg_flujo);
    $this->session->set_userdata("contrato", $contrato);
    $this->session->set_userdata("nombres", $nombres);
    $this->session->set_userdata("apellidoPaterno", $apellidoPaterno);
    $this->session->set_userdata("apellidoMaterno", $apellidoMaterno);

    $dataContact = ws_GET_DatosContactos($nroRut, $contrato, $flg_flujo, $username);
    if($dataContact["retorno"]==0){

      if($dataContact["emailHome"]!="") { $value["email"] = (string)$dataContact["emailHome"]; }
      else { $value["email"] = (string)$dataContact["emailWork"]; }

      if($dataContact["phoneMobile"]!="") { $value["phone"] = (string)$dataContact["phoneMobile"]; }
      else { $value["phone"] = (string)$dataContact["phoneWork"]; }

    }else{

      $value["email"] = ""; $value["phone"] = "";
    }

    $dataOferta = $this->get_DatosOfertaTC($nroRut);
    if($dataOferta['retorno']==0) {

        $value['retorno'] = 10; //Con Oferta Vigente
        $value['nameCampagna'] = (string)$dataOferta['nombreCampagna'];
        $value['estadoCampagna'] = (int)$dataOferta['estadoCampagna'];
        $value['estadoOferta'] = (int)$dataOferta['estadoOferta'];
        $value['dateFirstExpiration'] = substr($dataOferta['fechaVigencia'],0,10);
        $value['amountSimulate'] = (float)$dataOferta['montoOferta'];
        $value['numberQuotas'] = (int)$dataOferta['plazoMaximoOferta'];
        $value['descRetorno'] = DESCRIP_VIGENTE;
        $value['descTitle'] = DESCRIP_SUPER_AVANCE;

    }else{

        $value['retorno'] = 12;
        $value['descTitle'] = MSG_SIN_OFERTAS;
        $value['descRetorno'] = "A continuación puede simular ".DESCRIP_SUPER_AVANCE;

    }

    $value['flg_flujo'] = $flg_flujo;
    $value['nameClient'] = $nameClient;
    $value['last_nameClient'] = $last_nameClient;
    $value['nroTcv'] = $nroTcv;
    $value['origen'] = $origen;

    $data = $value;
    echo json_encode($data);
}

private function loadDataToRemote($nroRut, $idDocument, $idEstado) {

  $return = check_session("4.1.4");

  $id_rol =$this->session->userdata("id_rol");

  $minQuotas=0; $maxQuotas=0; $minDeferred=0; $maxDeferred=0;
  $result = $this->parameters->get_quotasByProduct(CODIGO_SUPER_AVANCE);
  $minQuotas = (int)$result->CUOTAS_MINIMO;
  $maxQuotas = (int)$result->CUOTAS_MAXIMO;

  $result = $this->parameters->get_quotasDeferredByProduct(CODIGO_SUPER_AVANCE);
  $minDeferred = (int)$result->CUOTAS_MINIMO;
  $maxDeferred = (int)$result->CUOTAS_MAXIMO;

  $arrDataLoad = array(
      'minNumberQuotas' => $minQuotas,
      'maxNumberQuotas' => $maxQuotas,
      'minDeferredQuotas' => $minDeferred,
      'maxDeferredQuotas' => $maxDeferred,
      'interesRate' => '',
      'dateFirstExpiration' => '',
      'amountApproved' => 250000,
      'amountPreAproved' => 300000,
      'emailClient' => '',
      'dataload' => '{ "source": "valid", "idDocument": "'.$idDocument.'", "nroRut": "'.$nroRut.'" , "idEstado": "'.$idEstado.'" } '
    );
  $dataSecure = $this->parameters->get_secureByRol($id_rol, CODIGO_SUPER_AVANCE);
  $dataOffice = $this->parameters->getall_office();

  $valueOffice["optionOfficeLinked"] = "";
  foreach ($dataOffice as $nodo) {
      $valueOffice["optionOfficeLinked"] .= "<option value='".$nodo->id_office."'>".$nodo->name."</option>";
  }

  $ind = 1; $valueOne = array(); $valueTwo = array();
  foreach($dataSecure as $nodo) {

      if($ind==1){
          $valueOne["htmlName"] = $nodo->htmlName;
          $valueOne["htmlModal"] = $nodo->htmlModal;
          $valueOne["htmlDescrip"] = $nodo->descrip;
          $valueOne["htmlValue"] = $nodo->codSecure;
          $valueOne["codSecure"] = $nodo->codSecure;
          $valueOne["idPoliza"] = $nodo->idPoliza;
          $valueOne["htmlScript"] = $nodo->htmlScript;
      }

      if($ind==2){
          $valueTwo["htmlName"] = $nodo->htmlName;
          $valueTwo["htmlModal"] = $nodo->htmlModal;
          $valueTwo["htmlDescrip"] = $nodo->descrip;
          $valueTwo["htmlValue"] = $nodo->codSecure;
          $valueTwo["codSecure"] = $nodo->codSecure;
          $valueTwo["idPoliza"] = $nodo->idPoliza;
          $valueTwo["htmlScript"] = $nodo->htmlScript;
      }
      $ind = $ind + 1;
  }

  $data["dataLoad"] = $arrDataLoad;
  $data["secureOne"] = $valueOne;
  $data["secureTwo"] = $valueTwo;
  $data["officeLinked"] = $valueOffice;

  $this->load->view('advance/remote', $data);

}

 public function evaluation_client() {

    $return = check_session("");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(10, validation_errors(), "");
    }

    /*
    Begin -> Inicializa variables evaluacion Clientes*/
        $value["email"] = ""; $value["phone"] = "";
        $nroRut = $this->input->post("nroRut"); $username = $this->session->userdata("username"); $typeResult = "label";
        $retorno=COD_ERROR_INIT; $credit_card_status = ""; $numeroAdicionales = 0;
    /*
    End*/

    $eval = validaRUTCL($nroRut);
    if($eval["retorno"]!=0){
        cancel_function(10, $eval["descRetorno"], "Preste Atención");
    }
    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if($dataHomologador["retorno"]!=0){ cancel_function(10, $dataHomologador["descRetorno"], ""); }
    $flg_flujo = $dataHomologador["flg_flujo"]; $nroTcv = $dataHomologador["nroTcv"];

    $dataCuenta = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
    if($dataCuenta["retorno"]!=0){ cancel_function(10, $dataCuenta["descRetorno"], ""); }
    $contrato = $dataCuenta["contrato"];

    /*
    Begin Revisa situación tarjeta de crédito*/
        $datosTarjeta = json_decode(ws_GET_ConsultaDatosTarjetaTC($nroTcv, $contrato, $flg_flujo, $username));
        if($datosTarjeta->retorno==0) {

          foreach ($datosTarjeta->tarjetas as $field) {
              if($field->pan==$nroTcv) {
/** Begin::CC028:: **/ 
                    if($flg_flujo=="001"){
                            if(substr($field->relacion,0,2)!="TI" OR $field->codigoDeBloqueo!=0){
                                $eval = $this->parameters->get_card_lock_descriptions($field->codigoDeBloqueo);
                                if(!$eval){
                                    $descrip = $field->codigoDeBloqueo . " NO DEFINIDO";
                                }else{
                                    $descrip = $eval->name_status;
                                }

                              cancel_function(10, "<strong>Estado " . $dataHomologador["name_product"] . ", Impide curse ". NAME__PRODUCT_SAV . "<strong></br>Bloqueo : " . $descrip, "");                              
                            }

                    }
/** End::CC028:: **/ 
                    $credit_card_status = $field->descripcion;
              }
              if($field->relacion!="TITULAR") {
                  $numeroAdicionales = $numeroAdicionales + 1;
              }
          }
        }
    /*
    End*/

/** Begin::CC028:: **/ 
    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $dataCuenta["contrato"],
        "id_channel" => $dataHomologador["flg_flujo"],
        "id_type" => TYPE__PRODUCT_SAV,
        "id_product" => $dataHomologador["id_product"]);

    $result = ws_GET_ConsultaEstadosBloqueo($dataInput);
    if($result["retorno"]!=0){ cancel_function(10, "<strong>No fue posible validar si " . $dataHomologador["name_product"] . ", registra alg&uacute;n bloqueo.</br>Impide curse ". NAME__PRODUCT_SAV . "<strong>", ""); }
    if($result["diasMora"]>0){ cancel_function(10, "<strong>" . $dataHomologador["name_product"] . ", registra morosidad de ".$result["diasMora"]." días<br>Impide curse " . NAME__PRODUCT_SAV . "</strong>",""); }
    if($result["allow_sale"]!=""){ cancel_function(10, "<strong>Estado " . $dataHomologador["name_product"] . ", Impide curse ". NAME__PRODUCT_SAV . "<strong></br>" . $result["allow_sale"], ""); }
/** End::CC028:: **/ 

    $dataClient = ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username);
    if($dataClient["retorno"]!=0){ cancel_function(10, $dataClient["descRetorno"], ""); }

    $dataContact = ws_GET_DatosContactos($nroRut, $contrato, $flg_flujo, $username);
    if($dataContact["retorno"]==0){

      $value["email"] = ($dataContact["emailHome"]!="" ? (string)$dataContact["emailHome"] : (string)$dataContact["emailWork"]);
      $value["phone"] = ($dataContact["phoneMobile"]!="" ? (string)$dataContact["phoneMobile"] : (string)$dataContact["phoneWork"]);
    }

    $arrDataOffers = $this->get_offersByRut($nroRut);
    if($arrDataOffers["retorno"]!=0){ cancel_function(10, $arrDataOffers["descRetorno"], ""); }

    $arrDataProduct = $this->checkProductValid($nroRut, $nroTcv, $flg_flujo);
    if($arrDataProduct["retorno"]==0){
        $descRetorno  = "<strong>Cliente con fecha ".substr($arrDataProduct["fechaContratacion"],0,10)." curso ".CODIGO_SUPER_AVANCE." de la campaña actual. El ";
        $descRetorno .= CODIGO_SUPER_AVANCE." fue generado por monto de $".number_format((float)$arrDataProduct["montoContratado"],0 ,',', '.')." en ";
        $descRetorno.= (int)$arrDataProduct["cuotasContratadas"]." cuotas..!</strong>";

        cancel_function(10, $descRetorno, "");
    }

    $arrDataConsumo = $this->checkConsumoValid($nroRut);
    if((int)$arrDataConsumo["retorno"]==0){
        $descRetorno  = "<strong>Cliente con fecha ".substr($arrDataConsumo["fechaActivacion"],0,10).",";
        $descRetorno .= " curs&#243; un Cr&#233;dito de Consumo de la campa&#241;a actual. El Cr&#233;dito";
        $descRetorno .= " de Consumo fue generado por un monto de $". $arrDataConsumo["montoLiquido"] .", en ".(int)$arrDataConsumo["cuotasTotal"]." cuotas";

        cancel_function(10, $descRetorno, "");
    }

    $value["flagOffers"] = true;
    $value["aprobado"] = $arrDataOffers["aprobado"];

    $value["offerSelector"] = "<div class='form-group col-xs-12 col-sm-6 col-lg-4'>";
    $value["offerSelector"].= "<label class='offerSelector'>Ofertas</label>&nbsp;&nbsp;";
    $checked_AP = false;

    if($arrDataOffers["codestatusCampagna"]==1){

        if($arrDataOffers["montoOferta"]>0):
                $checked = "checked";
                $checked_AP = true;
        else:
                $checked = "";
        endif;
        $value["offerSelector"].= "<label id='label-inline-radio1' class='radio-inline' for='inline-radio1'>";
        $value["offerSelector"].= "<input type='radio' id='offer-inline-radio1' name='offer-inline-radio' value='AP' " . $checked . " onclick='Client.selectOffer(this);'>APROBADO</label>";

        $datanew["offerName"] = "APROBADO";
        $datanew["offerCode"] = "AP";
        $datanew["offerAmount"] = $arrDataOffers["montoOferta"];
        $datanew["offerQuotas"] = $arrDataOffers["plazoMaximoOferta"];
        $datanew["flagQuotas"] = 0;
        $datanew["offerDeferred"] = 0;
        $datanew["flagDeferred"] = 0;
        $dataDetail[] = $datanew;
    }

    if($arrDataOffers["montoPreaprobado"]!=0){

        $checked_PA = "";
        if(!$checked_AP): $checked_PA = "checked"; endif;

        $value["offerSelector"].= "<label class='radio-inline' for='inline-radio1'>";
        if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING){

            $value["offerSelector"].= "<input type='radio' id='offer-inline-radio2' name='offer-inline-radio' value='UP' " . $checked_PA . " onclick='Client.selectOffer(this);'>PRE APROBADO</label>";

        }else{

            $value["offerSelector"].= "<input type='radio' id='offer-inline-radio2' name='offer-inline-radio' value='PA' " . $checked_PA . " onclick='Client.selectOffer(this);'>PRE APROBADO</label>";
        }

        $datanew["offerName"] = "PRE APROBADO";
        $datanew["offerCode"] = "PA";
        $datanew["offerAmount"] = $arrDataOffers["montoPreaprobado"];
        $datanew["offerQuotas"] = $arrDataOffers["plazoMaximoOferta"];
        $datanew["flagQuotas"] = 0;
        $datanew["offerDeferred"] = 0;
        $datanew["flagDeferred"] = 0;
        $dataDetail[] = $datanew;
    }
    $value["offerSelector"].= "</div>";

    if($arrDataOffers["codestatusCampagna"]==1){

        $value["offerSelector"].= "<div class='form-group col-xs-12 col-sm-6 col-lg-2'>";
        $value["offerSelector"].= "<label for='offerRequest'>Monto Aprobado</label>";
        $value["offerSelector"].= "<input type='text' class='form-control text-center' readonly value='$".number_format((float)$arrDataOffers["montoOferta"],0 ,',', '.')."'>";
        $value["offerSelector"].= "</div>";
    }

    if($arrDataOffers["montoPreaprobado"]!=0){

        $value["offerSelector"].= "<div class='form-group col-xs-12 col-sm-6 col-lg-2'>";
        $value["offerSelector"].= "<label for='offerRequest'>Monto Pre Aprobado</label>";
        $value["offerSelector"].= "<input type='text' class='form-control text-center' readonly value='$".number_format((float)$arrDataOffers["montoPreaprobado"],0 ,',', '.')."'>";
        $value["offerSelector"].= "</div>";
    }
    $value["offerDetail"] = $dataDetail;

    $arrDataRequest  = $this->get_requestByRut($nroRut);

    $value["titleRequest"] = $arrDataRequest["titleRequest"];
    $value["htmlRequest"] = $arrDataRequest["htmlRequest"];
    $value["completeNameClient"] = $dataClient["nombres"] .' '. $dataClient["apellidoPaterno"] .' '. $dataClient["apellidoMaterno"];
    $value["nameClient"] = $dataClient["nombres"];
    $value["sexoClient"] = $dataClient["sexo"];
    $value["fechaNacimiento"] = $dataClient["fechaNacimiento"];
    $value["nroserie"] = $dataClient["nroserie"];
    $value["nroTcv"] = substr_replace($dataHomologador["nroTcv"], "************", 0, 12 );
    $value["id_rol"] = $this->session->userdata("id_rol");

    if($arrDataOffers["retorno"]==0) {

        if($arrDataOffers["derivarCentroDeServicio"] == 1) {

            cancel_function(10, $arrDataOffers["popupOffers"], "");

        }else{

            $value["estadoCampagna"] = $arrDataOffers["namestatusCampagna"];
            $value["estadoOferta"] = $arrDataOffers["estadoOferta"];
            $value["fechaVigencia"] = $arrDataOffers["fechaVigencia"];
            $value["montoOferta"] = $arrDataOffers["montoOferta"];
            $value["montoPreaprobado"] = $arrDataOffers["montoPreaprobado"];
            $value["plazoMaximoOferta"] = $arrDataOffers["plazoMaximoOferta"];

            /*Datos para verificar cliente*/
            $dataUltTRX = ws_GET_ConsultaUltimasTransaccionesTC($contrato, $flg_flujo, $username);

            if($flg_flujo=="001"){

                $dataInput = array(
                    "nroRut" => "",
                    "contrato" => "",
                    "fechaVencimiento" => "",
                    "estadoEecc" => "",
                    "pan" => $nroTcv,
                    "flg_flujo" => $flg_flujo
                );

            }else{

                $dataInput = array(
                    "nroRut" => $nroRut,
                    "contrato" => $contrato,
                    "fechaVencimiento" => "",
                    "estadoEecc" => "",
                    "pan" => "",
                    "flg_flujo" => $flg_flujo,
                );
            }

            $dataEECC = ws_GET_ConsultaDatosEECCTC($dataInput);
            $dataDirecciones = json_decode(ws_GET_ConsultaDatosDireccion($nroRut, $contrato, $flg_flujo, $username));

            $value["lblAdicionales"] = "Registra ".$numeroAdicionales." adicionales";
            $value["lblglosaDespacho"] = $dataCuenta["glosaDespacho"];
            $value["lbltipoDespacho"] = $dataCuenta["tipoDespacho"];

            $value["lblfechaUltCompra"] = ($dataUltTRX["retorno"]==0 ? $dataUltTRX["fechaUltimaVenta"] : "Atención: ". $dataUltTRX["descRetorno"]);
            $value["lbldiaVencimiento"] = ($dataEECC["retorno"]==0 ? substr($dataEECC["fechaVencimiento"],0,2) : "Atención: ". $dataEECC["descRetorno"]);
            $value["lblDireccion"] = "No Registra Dirección";

            if($dataDirecciones->retorno==0) {

                foreach ($dataDirecciones->direcciones as $field) {

                    if($field->tipoDireccion=="WORK"){

                        $value["lblDireccion"] = $field->calle." N. ".$field->numeroCalle." ".$field->comuna.", ".$field->ciudad.", ".$field->region;
                    }
                }

                foreach ($dataDirecciones->direcciones as $field) {

                    if($field->tipoDireccion=="HOME"){

                        $value["lblDireccion"] = $field->calle." N. ".$field->numeroCalle." ".$field->comuna.", ".$field->ciudad.", ".$field->region;
                    }
                }

            }

            if($arrDataRequest["retorno"]==0){

                  $value["retorno"] = 11; // Cliente con cotizaciones Vigentes
            }else{

                  $value["retorno"] = 0; // Con Ofertas Vigentes
            }

        }

    } else {

            $value["retorno"] = 9; // Cliente sin Ofertas

    }

    $this->session->set_userdata("contrato", $contrato);
    $this->session->set_userdata("nameClient", $value["completeNameClient"]);
    $this->session->set_userdata("nroClient", $nroRut);
    $this->session->set_userdata("fechaNacimiento", $dataClient["fechaNacimiento"]);

    $this->session->set_userdata('nroTcv', $nroTcv);
    $this->session->set_userdata('flg_flujo', $flg_flujo);

    $this->session->set_userdata("nombres", $dataClient["nombres"]);
    $this->session->set_userdata("apellidoPaterno", $dataClient["apellidoPaterno"]);
    $this->session->set_userdata("apellidoMaterno", $dataClient["apellidoMaterno"]);

    $data = $value;
    echo json_encode($data);

}

public function search_RequestClient() {

    $return = check_session("");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $username = $this->session->userdata("username");

    $nroRut = $this->input->post("nroRut");
    $nroClient = $nroRut; $value["email"] = ""; $value["phone"] = "";

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"]!=0){ cancel_function(10, $dataHomologador["descRetorno"],""); }
    $flg_flujo = $dataHomologador["flg_flujo"]; $nroTcv = $dataHomologador["nroTcv"];

    $dataCuenta = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
    $contrato = ($dataCuenta["retorno"]==0 ? $dataCuenta["contrato"] : 0);
    $this->session->set_userdata("contrato", $contrato);

    $result = ws_GET_ConsultaDatosClienteTC($nroRut, $flg_flujo, $username);
    if($result["retorno"]==0) {

        $xml = $result["xmlDocument"];

        $nameClient = (string)$xml->Body->DATA->Registro->nombres .' '. (string)$xml->Body->DATA->Registro->apellidoPaterno .' '. (string)$xml->Body->DATA->Registro->apellidoMaterno;
        $fechaNacimiento = (string)$xml->Body->DATA->Registro->fechaNacimiento;

    } else {
        $nameClient = ""; $fechaNacimiento = "";
    }

    /* Begin Revisa situación tarjeta de crédito */

        $credit_card_status = "";
        $datosTarjeta = json_decode(ws_GET_ConsultaDatosTarjetaTC($nroTcv, $contrato, $flg_flujo, $username));
        if($datosTarjeta->retorno==0) {

          foreach ($datosTarjeta->tarjetas as $field) {
              if($field->pan==$nroTcv) {
                  $credit_card_status = $field->descripcion;
              }
          }
        }
        if($credit_card_status==""){ cancel_function(10, "No fue posible validar Estado Tarjeta de Crédito del cliente..",""); }
        if($credit_card_status=="TARJETA INACTIVA"){ cancel_function(10, "Tarjeta Cliente no esta Activa, no puede cursar SAV", ""); }

    /* End Revisa situación tarjeta de crédito */


/** Begin::CC028:: **/ 
        $diasMora = 0;
        $dataInput = array(
            "nroRut" => $nroRut,
            "contrato" => $dataCuenta["contrato"],
            "id_channel" => $dataHomologador["flg_flujo"],
            "id_type" => TYPE__PRODUCT_SAV,
            "id_product" => $dataHomologador["id_product"]);

        $result = ws_GET_ConsultaEstadosBloqueo($dataInput);
        if($result["retorno"]!=0){ cancel_function(10, "<strong>No fue posible validar si " . $dataHomologador["name_product"] . ", registra alg&uacute;n bloqueo.</br>Impide curse ". NAME__PRODUCT_SAV . "<strong>", ""); }
        if($result["diasMora"]>0){ cancel_function(10, "<strong>" . $dataHomologador["name_product"] . ", registra morosidad de ".$result["diasMora"]." días<br>Impide curse " . NAME__PRODUCT_SAV . "</strong>",""); }
        if($result["allow_sale"]!=""){ cancel_function(10, "<strong>Estado " . $dataHomologador["name_product"] . ", Impide curse ". NAME__PRODUCT_SAV . "<strong></br>" . $result["allow_sale"], ""); }
/** End::CC028:: **/ 

    $dataContact = ws_GET_DatosContactos($nroRut, $contrato, $flg_flujo, $username);
    if($dataContact["retorno"]==0){

        $value["email"] = ($dataContact["emailHome"]!="" ? (string)$dataContact["emailHome"] : (string)$dataContact["emailWork"]);
        $value["phone"] = ($dataContact["phoneMobile"]!="" ? (string)$dataContact["phoneMobile"] : (string)$dataContact["phoneWork"]);
    }

    $birthDay = (int)substr($fechaNacimiento,0,2);
    $birthMonth = (int)substr($fechaNacimiento,3,2);
    $birthYear = (int)substr($fechaNacimiento,6,4);

    $diffYear = date("Y") - $birthYear;
    $diffMonth = date("m") - $birthMonth;
    $diffDay = date("d") - $birthDay;
    if ($diffDay < 0 || $diffMonth < 0) { $diffYear--; }
    if ($diffDay < 0) { $diffDay = $diffDay * -1; }
    if ($diffMonth < 0) { $diffMonth = 12 - ($diffMonth * - 1); }
    else{ $diffMonth = 12 - $diffMonth; }

    $this->session->set_userdata("nameClient", $nameClient);
    $this->session->set_userdata("nroClient", $nroClient);

    $this->session->set_userdata('nroTcv', $nroTcv);
    $this->session->set_userdata('flg_flujo', $flg_flujo);
    $this->session->set_userdata("birthDate", $birthDay."-".$birthMonth."-".$birthYear);

    $this->session->set_userdata("nombres", (string)$xml->Body->DATA->Registro->nombres);
    $this->session->set_userdata("apellidoPaterno", (string)$xml->Body->DATA->Registro->apellidoPaterno);
    $this->session->set_userdata("apellidoMaterno", (string)$xml->Body->DATA->Registro->apellidoMaterno);

//    $this->session->set_userdata("diffYear", $diffYear." años con ".$diffMonth." Meses y ".$diffDay." Días.");
    $this->session->set_userdata("diffYear", $diffYear);

/*
    $arrDataProduct = $this->checkProductValid($nroRut, $nroTcv, $flg_flujo);
    if($arrDataProduct["retorno"]==0){
        $descRetorno  = "<h3><strong>Cliente con fecha ".substr($arrDataProduct["fechaContratacion"],0,10)." curso ".CODIGO_SUPER_AVANCE." de la campaña actual. El ";
        $descRetorno .= CODIGO_SUPER_AVANCE." fue generado por monto de $".number_format((float)$arrDataProduct["montoContratado"],0 ,',', '.')." en ";
        $descRetorno.= (int)$arrDataProduct["cuotasContratadas"]." cuotas..!</strong></h3>";
        cancel_function(10, $descRetorno, "");
    }
*/

    $arrDataConsumo = $this->checkConsumoValid($nroRut);
    if((int)$arrDataConsumo["retorno"]==0){
        $descRetorno  = "<h3><strong>Cliente con fecha ".substr($arrDataConsumo["fechaActivacion"],0,10).",";
        $descRetorno .= " curs&#243; un Cr&#233;dito de Consumo de la campa&#241;a actual. El Cr&#233;dito";
        $descRetorno .= " de Consumo fue generado por un monto de $". $arrDataConsumo["montoLiquido"] .", en ".(int)$arrDataConsumo["cuotasTotal"]." cuotas</h3>";
        cancel_function(10, $descRetorno, "");
    }

    $arrDataOffers = $this->get_offersByRut($nroRut);
    if($arrDataOffers["retorno"]!=0) {
        $descRetorno  = "<h3><strong>Cliente no tiene Ofertas Vigente ..</h3>";
        cancel_function(10, $descRetorno, "");
    }

    $value["flagOffers"] = true;
    $value["aprobado"] = $arrDataOffers["aprobado"];

    $arrDataRequest  = $this->get_requestByRut($nroRut);

    $value["titleRequest"] = $arrDataRequest["titleRequest"];
    $value["htmlRequest"] = $arrDataRequest["htmlRequest"];
    $value["nameClient"] = $nameClient;
    $value["birthDate"] = $birthDay."-".$birthMonth."-".$birthYear;
    $value["diffYear"] = $diffYear;
    $value["id_rol"] = $this->session->userdata("id_rol");

    if($arrDataRequest["retorno"]==0){
        $value["retorno"] = 11; // Cliente con cotizaciones Vigentes
    }else{
        if($arrDataOffers["retorno"]==0) {

            if($arrDataOffers["derivarCentroDeServicio"] == 1) {
                $descRetorno  = $arrDataOffers["popupOffers"];
                cancel_function(10, $descRetorno, "");
            }else{

                $value["estadoCampagna"] = $arrDataOffers["estadoCampagna"];
                $value["estadoOferta"] = $arrDataOffers["estadoOferta"];
                $value["fechaVigencia"] = $arrDataOffers["fechaVigencia"];
                $value["montoOferta"] = $arrDataOffers["montoOferta"];
                $value["montoPreaprobado"] = $arrDataOffers["montoPreaprobado"];
                $value["plazoMaximoOferta"] = $arrDataOffers["plazoMaximoOferta"];
                $value["retorno"] = 0; // Con Ofertas Vigentes
            }
        }else{

            $value["retorno"] = 9; // Cliente sin Ofertas

        }
    }

    $data = $value;

    echo json_encode($data);

}

public function get_simulate() {

    $return = check_session("");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero de Rut', 'required|trim');
    $this->form_validation->set_rules('offerAmount', 'Monto de Oferta', 'required');
    $this->form_validation->set_rules('offerRequest', 'Monto Solicitado', 'required');
    $this->form_validation->set_rules('offerType', 'Identificador de Oferta', 'required');
    $this->form_validation->set_rules('numberQuotas', 'N&#250;mero de Cuotas', 'required');
    $this->form_validation->set_rules('deferredQuotas', 'N&#250;mero de Cuotas Diferir', 'required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('numeric','El atributo %s debe ser numérico');
    $this->form_validation->set_message('greater_than','El atributo %s debe ser mayor que cero');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "" );
    }

    $nroRut = $this->input->post("nroRut");
    $offerRequest = $this->input->post("offerRequest");
    $offerAmount = $this->input->post("offerAmount");
    $offerType = $this->input->post("offerType");
    $numberQuotas = $this->input->post("numberQuotas");
    $deferredQuotas = $this->input->post("deferredQuotas");

    $username = $this->session->userdata("username");
    $nroTcv = $this->session->userdata("nroTcv");
    $flg_flujo = $this->session->userdata("flg_flujo");

    if($deferredQuotas>0){
        $idTrx = 300;
    }else{
        $idTrx = 301;
    }

    $secureOne = $this->input->post("secureOne"); $secureTwo = $this->input->post("secureTwo");
    $offerRequest = str_replace('.', '', $offerRequest); $offerRequest = str_replace('$', '', $offerRequest);
    $offerAmount = str_replace('.', '', $offerAmount); $offerAmount = str_replace('$', '', $offerAmount);

    $offerRequest = (int)$offerRequest; $offerAmount = (int)$offerAmount; $minAmount=0; $maxAmount=0;
    $amountByHand = $offerRequest;

    $result = $this->parameters->get_amountByProduct(CODIGO_SUPER_AVANCE);
    $minAmount = (int)$result->MONTO_MINIMO;
    $maxAmount = (int)$result->MONTO_MAXIMO;

    // Type = 0 recibido desde simulacion / 1 y 2 desde cotizaciones
    if((int)$offerType!="") {

        if( (int)$maxAmount > (int)$offerAmount) { $maxAmount = $offerAmount; }
    }

    if((int)$minAmount>(int)$offerRequest){
        cancel_function(COD_ERROR_INIT, "Atención, Monto es menor a los $".number_format((float)$minAmount, 0, ',', '.')." definidos para el producto..", "" );
    }
    if((int)$maxAmount<(int)$offerRequest){
        cancel_function(COD_ERROR_INIT, "Atención, Monto excede los $".number_format((float)$maxAmount, 0, ',', '.')." definidos para el producto..", "" );
    }
    if($offerRequest > $offerAmount){
        cancel_function(COD_ERROR_INIT, "Atención, Monto solicitado excede monto Oferta..!", "" );
    }

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $amountSecureOne = 0; $amountSecureTwo = 0;
    $amountTotal = $offerRequest;

    if($secureOne!=""){

        $dataSecure = $this->parameters->get_secureById($secureOne);

        $tasaPrima = (float)$dataSecure->tasaPrima;
        $tasaIVA = (float)$dataSecure->tasaIVA;
        $minPrima = (float)$dataSecure->minPrima;
        $maxPrima = (float)$dataSecure->maxPrima;

        if($tasaIVA>0){
            $totalPrima = ($tasaPrima * $tasaIVA / 100) + $tasaPrima;
        }else{
            $totalPrima = $tasaPrima;
        }

        $amountSecureOne = round ( $offerRequest * $totalPrima / 100 );
        if($amountSecureOne<$minPrima){
            $amountSecureOne = $minPrima;
        }
        if($amountSecureOne>$maxPrima){
            $amountSecureOne = $maxPrima;
        }
        $amountTotal = $offerRequest + $amountSecureOne;
    }

    if($secureTwo!=""){

        $dataSecure = $this->parameters->get_secureById($secureTwo);

        $tasaPrima = (float)$dataSecure->tasaPrima;
        $tasaIVA = (float)$dataSecure->tasaIVA;
        $minPrima = (float)$dataSecure->minPrima;
        $maxPrima = (float)$dataSecure->maxPrima;

        if($tasaIVA>0){
            $totalPrima = ($tasaPrima * $tasaIVA / 100) + $tasaPrima;
        }else{
            $totalPrima = $tasaPrima;
        }

        $amountSecureTwo = round ( ($offerRequest + $amountSecureOne) * $totalPrima / 100 );
        if($amountSecureTwo<$minPrima){
            $amountSecureTwo = $minPrima;
        }
        if($amountSecureTwo>$maxPrima){
            $amountSecureTwo = $maxPrima;
        }
        $amountTotal = $amountTotal + $amountSecureTwo;
    }

    $fechaPrimerVencimiento = ""; $interesRate = ""; $htmlSimulate = ""; $dateFirstExpiration = ""; $lastQuota=0;

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:pan>'.$nroTcv.'</req:pan>
         <req:nroRut>'.$nroRut.'</req:nroRut>
         <req:idTx>'.$idTrx.'</req:idTx>
         <req:monto>'.$amountTotal.'</req:monto>
         <req:numeroDeCuota>'.$numberQuotas.'</req:numeroDeCuota>
         <req:mesesDiferidos>'.$deferredQuotas.'</req:mesesDiferidos>
         <req:flagCriterio>'.COD_CRITERIO_CUOTAS.'</req:flagCriterio>
      </req:DATA>
       </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_SimulacionTrxTC;
    $soap = get_SOAP($EndPoint, WS_Action_SimulacionTrxTC, WS_Timeout60, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]==0) {

        $xmlString = $soap["xmlString"];
        $eval = eval_response_SOAP($xmlString, "descRetorno", WS_SimulacionTrxTC);

        if($eval["retorno"]!=0){

            $value["retorno"] = $eval["retorno"];
            $value["descRetorno"] = $eval["descRetorno"];

            put_logevent($soap, SOAP_ERROR);

            $data = $value;
            echo json_encode($data);
            exit(0);
        }

        $xml = $eval["xmlDocument"];
        $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
        $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

        $htmlSimulate = '<table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
            <thead>
              <tr><th class="text-center">Selecci&#243;n</th>
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
            </thead><tbody>';

        if($retorno==0){

            foreach ($xml->Body->DATA->response as $recordTRX) {
                foreach ($recordTRX as $nodo) {

                    if((int)$nodo->numeroDeCuota > 0){
                        $comision = $nodo->comision;
                        $comision = str_replace('.', '', $comision);
                        $comision = str_replace(',', '.', $comision);
                        $dateFirstExpiration = (string)$nodo->fechaPrimerVencimiento;
                        $interesRate = (string)$nodo->tasa;
                        $interesRate = str_replace(',', '.', $interesRate);
                        $lastQuota = (string)$nodo->numeroDeCuota;

                        $ite = substr((string)$nodo->ite, 0, -2);

                        $montoBruto = round( (float)$amountTotal + (float)$ite + (float)$comision );

                        $valorCuota = substr((string)$nodo->valorCuota, 0, -2);

                        $costoTotalDelCredito = substr((string)$nodo->costoTotalDelCredito, 0, -2);

                        $total = (float) $nodo->costoTotalDelCredito + (float) $nodo->ite;
                        $costoTotalDelCredito = (int) $total;

                        $checkSelect = "";
                        if((int)$nodo->numeroDeCuota==(int)$numberQuotas) { $checkSelect = "checked"; }

                        $htmlSimulate = $htmlSimulate.'
                            <tr onclick="Client.selectRequest(this);">
                              <td scope="col" class="text-center"><input type="radio" name="checkSimulate" value="'.$nodo->numeroDeCuotas.'" id="sel'.$nodo->numeroDeCuota.'" '.$checkSelect.'></td>
                              <td scope="col" class="text-center">'.$nodo->numeroDeCuota.'</td>
                              <td scope="col" class="text-center">'.$nodo->mesesDiferidos.'</td>
                              <td scope="col" class="text-right">$'.number_format((float)$valorCuota, 0, ',', '.').'</td>
                              <td scope="col" class="text-right">$'.number_format((float)$montoBruto, 0, ',', '.').'</td>
                              <td scope="col" class="text-right">$'.number_format((float)$amountByHand, 0, ',', '.').'</td>
                              <td scope="col" class="text-right">$'.number_format((float)$costoTotalDelCredito, 0, ',', '.').'</td>
                              <td scope="col" class="text-center">'.$nodo->tasa.'%</td>
                              <td scope="col" class="text-right">$'.number_format((float)$ite, 0, ',', '.').'</td>
                              <td scope="col" class="text-right">$'.number_format((float)$comision, 0, ',', '.').'</td>
                              <td scope="col" class="text-right">'.$nodo->cae.'%</td>
                              <td scope="col" class="text-center">$'.number_format((float)$amountSecureOne, 0, ',', '.').'</i></td>
                              <td scope="col" class="text-center">$'.number_format((float)$amountSecureTwo, 0, ',', '.').'</i></td>
                            </tr>';

                    }
                }
            }

        }else{

            $htmlSimulate = $htmlSimulate.'
            <tr>
                <td scope="col" class="text-center" nowrap colspan="13">'.$descRetorno.'</td>
            </tr>';

        }


    } else {

        $htmlSimulate = $htmlSimulate.'
        <tr>
            <td scope="col" class="text-center" nowrap colspan="13">'.$soap["msgErrorSOAP"].'</td>
        </tr>';

        $retorno = $soap["codErrorSOAP"];
        $descRetorno = $soap["msgErrorSOAP"];

    }
    $htmlSimulate = $htmlSimulate.'</tbody></table>';

    $value['retorno'] = $retorno;
    $value['descRetorno'] = $descRetorno;
    $value['dateFirstExpiration'] = $dateFirstExpiration;
    $value['interesRate'] = $interesRate;
    $value['htmlSimulate'] = $htmlSimulate;
    $value['lastLine'] = "sel".$lastQuota;

    put_logevent($soap, SOAP_OK);

    $data = $value;
    echo json_encode($data);

}

public function get_offersByRutTC() {

    $return = check_session("");

    $nroRut = $this->input->post("nroRut");
    $data = $this->get_offersByRut($nroRut);

    echo json_encode($data);
}

private function get_DatosOfertaTC($nroRut){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $username = $this->session->userdata("username");
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:rut>'.$nroRut.'</req:rut>
          <req:tipoCampagna>'.CODIGO_SUPER_AVANCE.'</req:tipoCampagna>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_DatosOfertaTC;
    $soap = get_SOAP($EndPoint, WS_Action_DatosOfertaTC, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "cabeceraSalida", WS_DatosOfertaTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0){
        $estado = ((int)$xml->Body->DATA->response->estadoCampagna == 1 ? DESCRIP_VIGENTE : DESCRIP_NO_VIGENTE);
        $data['retorno'] = $retorno;
        $data['descRetorno'] = $descRetorno;
        $data['nombreCampagna'] = DESCRIP_SUPER_AVANCE;
        $data['estadoCampagna'] = $estado;
        $data['estadoOferta'] = (int)$xml->Body->DATA->response->estadoOferta;
        $data['fechaVigencia'] = (string)$xml->Body->DATA->response->fechaVigencia;
        $data['montoOferta'] = (float)$xml->Body->DATA->response->montoOferta;
        $data['montoPreaprobado'] = (float)$xml->Body->DATA->response->montoPreaprobado;
        $data['plazoMaximoOferta'] = (int)$xml->Body->DATA->response->plazoMaximoOferta;
        $data['aprobado'] = (int)$xml->Body->DATA->response->aprobado;

    }else{
        $data['retorno'] = $retorno;
        $data['descRetorno'] = "<span class='label label-warning'>NO REGISTRA OFERTA PARA ESTE PRODUCTO</span>";
        $data['nombreCampagna'] = DESCRIP_SUPER_AVANCE;
    }

    put_logevent($soap, SOAP_OK);
    return ($data);
}

public function get_request_for_quote() {

    $return = check_session("");

    $nroRut = $this->input->post("nroRut");
    $numberRequest = $this->input->post("numberRequest");
    $typeRequestSkill = $this->input->post("typeRequestSkill");
    $dateBegin = $this->input->post("dateBegin");
    $dateEnd = $this->input->post("dateEnd");
    $codLocal = $this->input->post("officeSkill");

    if ($nroRut != ""){

        $eval = validaRUTCL($nroRut);
        if($eval["retorno"]!=0){
              cancel_function(10, $eval["descRetorno"], "Preste Atención");
        }

        $dataHomologador = ws_GET_HomologadorByRut($nroRut, $this->session->userdata("username"));
        if($dataHomologador["retorno"]!=0){
              cancel_function(10, $dataHomologador["descRetorno"], "");
        }
    }

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    if ($dateBegin != ""){
        $dateBegin = str_replace('/', '-', $dateBegin);
        $dateBegin = $dateBegin . ' 00:00:00';
    }
    if ($dateEnd != ""){
        $dateEnd = str_replace('/', '-', $dateEnd);
        $dateEnd = $dateEnd . ' 00:00:00';
    }
    $usuarioSolicitud = ""; $glosaEstado = ""; $glosaEnlace = ""; $todayDay = date("Ymd"); $username = $this->session->userdata("username");

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:sucursalOrigen></req:sucursalOrigen>
         <req:sucursalDestino></req:sucursalDestino>
         <req:nroRut>'.$nroRut.'</req:nroRut>
         <req:tipoEstado>'.$typeRequestSkill.'</req:tipoEstado>
         <req:idSolicitud>'.$numberRequest.'</req:idSolicitud>
         <req:fechaDesde>'.$dateBegin.'</req:fechaDesde>
         <req:fechaHasta>'.$dateEnd.'</req:fechaHasta>
         <req:usuarioSolicitud>'.$usuarioSolicitud.'</req:usuarioSolicitud>
         <req:codLocal>'.$codLocal.'</req:codLocal>
      </req:DATA>
      </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaCotizacionesSAV;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaCotizacionesSAV, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaCotizacionesSAV);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      echo json_encode($data);
      exit(0);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    $id_rol = $this->session->userdata("id_rol");
    $id_username = $this->session->userdata("username");
    $id_office = $this->session->userdata("id_office");
    $id_channel = $this->session->userdata("id_channel");

    $htmlRequest = '<table class="table table-striped table-bordered" border="0">
        <thead>
            <tr >
                <td scope="col" class="text-center"><strong>C&#243;digo</strong></td>
                <td scope="col" class="text-center"><strong>N&#250;mero Rut</strong></td>
                <td scope="col" class="text-center"><strong>Cliente</strong></td>
                <td scope="col" class="text-center"><strong>Monto</strong></td>
                <td scope="col" class="text-center"><strong>Atenci&oacute;n</strong></td>
                <td scope="col" class="text-center"><strong>Fecha Creaci&#243;n</strong></td>
                <td scope="col" class="text-center"><strong>Estado Enlace</strong></td>
                <td scope="col" class="text-center"><strong>Estado</strong></td>
                <td scope="col" class="text-center"><strong>Sucursal</strong></td>
                <td scope="col" class="text-center"><strong>Rechazo</strong></td>
                <td scope="col" class="text-center"><strong>Acciones</strong></td>
            </tr>
        </thead><tbody>';

    $ind = 0;

    if($retorno==0){

        foreach ($xml->Body->DATA as $recordTRX) {
            foreach ($recordTRX as $nodo) {
                if($nodo->idSolicitud>0){

        $id = (string)$nodo->tipoEstado;
        $result = $this->glossary->get_estado_cotizaById($id);
        if($result!=false) { $glosaEstado = $result->NAME; } else { $glosaEstado = ""; }

        $id = (string)$nodo->estadoEnlace;
        $result = $this->glossary->get_EstadoEnlaceById($id);
        if($result!=false) { $glosaEnlace = $result->NAME; } else { $glosaEnlace = "";}

        $result = $this->parameters->get_officeById((string)$nodo->codLocal);
        if($result!=false) { $nameSucursal = $result->name; } else { $nameSucursal = ""; }

        $r = new Rut();
        $r->number($nodo->nroRut);
        $dgvRut = $r->calculateVerificationNumber();

        //ROL de usuario para filtrar solicitudes comerciales
        $flg_print = false;
        switch ($id_rol) {
            case USER_ROL_EJECUTIVO_COMERCIAL:
                if($id_username==$nodo->usuarioSolicitud) { $flg_print = true; }
            break;
            case USER_ROL_EJECUTIVO_TELEMARKETING:
                if( $id_username==$nodo->usuarioSolicitud) { $flg_print = true; }
            break;
            case USER_ROL_JEFE_DE_OFICINA:
                if($id_channel==$nodo->canal) { $flg_print = true; }
            break;

            default:
            break;
        }

        if($flg_print) {
            $htmlRequest.= '
                <tr >
                <td scope="col" class="text-center" nowrap>'.$nodo->idSolicitud.'</td>
                <td scope="col" class="text-center" nowrap>'.number_format((float)$nodo->nroRut, 0, ',','.').'-'.$dgvRut.'</td>
                <td scope="col" class="text-left">'.$nodo->nombres.' '.$nodo->apellidoPaterno.' '.$nodo->apellidoMaterno.'</td>
                <td scope="col" class="text-center"><strong>$'.number_format((float)$nodo->montoSolicitado,0,',','.').'</strong></td>
                <td scope="col" class="text-center"><strong>'.$nodo->modalidadVenta.'</strong></td>
                <td scope="col" class="text-center"><strong>'.substr($nodo->fechaSolicitud,0,10).'</strong></td>
                <td scope="col" class="text-center"><strong>'.$glosaEnlace.'</strong></td>
                <td scope="col" class="text-center"><strong>'.$glosaEstado.'</strong></td>
                <td scope="col" class="text-center"><strong>'.$nameSucursal.'</strong></td>
                <td scope="col" class="text-center"><strong>'.(string)$nodo->rechazoAut." ".(string)$nodo->rechazoLiq.'</strong></td>';

    if($this->session->userdata("id_rol")==USER_ROL_JEFE_DE_OFICINA&&$glosaEnlace!="") {

        $htmlRequest.= '<td scope="col" class="text-center"><button type="button" class="btn-xs btn-success" onclick="Client.showLinked('.$nodo->idSolicitud.');" data-status="'.$id.'"><i class="hi hi-link" title="ENLAZAR"></i></button>';

    }else{

        $htmlRequest.= '
            <td scope="col" class="text-center"><button type="button" class="btn-xs btn-success" disabled><i class="hi hi-link" title="NO DISPONIBLE"></i></button>';
    }

        $fechaVigencia = strtotime('+7 day', strtotime($nodo->fechaSolicitud));
        $fechaVigencia = date("Ymd" , $fechaVigencia);

        if($todayDay<=$fechaVigencia) {

        $htmlRequest.= '
            <button type="button" class="btn-xs btn-success" onclick="Client.showAssign('.$nodo->idSolicitud.','.$nodo->nroRut.'9);" data-status="'.$id.'"><i class="hi hi-search" title="CONTINUAR"></i></button></td></tr>';

        } else {

        $htmlRequest.= '
            <button type="button" class="btn-xs btn-success" onclick="Client.showAssign('.$nodo->idSolicitud.','.$nodo->nroRut.'9);" data-status="'.$id.'"><i class="hi hi-search" title="CONTINUAR"></i></button></td></tr>';
        }

            $ind = $ind + 1;
        }

                }
            }
        }

    }

    if($ind==0){
        $htmlRequest = $htmlRequest.'
        <tr>
            <td scope="col" class="text-center" nowrap colspan="11">SIN INFORMACI&#211;N DISPONIBLE</td>
        </tr>';
    }
    $htmlRequest = $htmlRequest.'</tbody></table>';

    $value['retorno'] = 0;
    $value['descRetorno'] = $descRetorno;
    $value['htmlRequest'] = $htmlRequest;

    $data = $value;
    echo json_encode($data);
}

private function validRequestOwner($idDocument) {

    $return = check_session("");

    $username = $this->session->userdata("username");

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
         <req:usuarioSolicitud></req:usuarioSolicitud>
         <req:codLocal></req:codLocal>
      </req:DATA>
      </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaCotizacionesSAV;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaCotizacionesSAV, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaCotizacionesSAV);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $value["retorno"] = $eval["retorno"];
      $value["descRetorno"] = $eval["descRetorno"];

      $data = $value;
      return($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    $id_rol = $this->session->userdata("id_rol");
    $id_username = $this->session->userdata("username");
    $id_channel = $this->session->userdata("id_channel");
    $id_owner = 0; $id_estado = ""; $glosaEstado ="";

    if($retorno==0){

        switch ($id_rol) {
            case USER_ROL_EJECUTIVO_COMERCIAL:
                if($xml->Body->DATA->response->tipoEstado=="PE" AND $id_username==$xml->Body->DATA->response->usuarioSolicitud) { $id_owner = 1; }
                if($xml->Body->DATA->response->tipoEstado=="CO" AND $id_username==$xml->Body->DATA->response->usuarioSolicitud) { $id_owner = 1; }
            break;
            case USER_ROL_EJECUTIVO_TELEMARKETING:
                if($xml->Body->DATA->response->tipoEstado=="PE" AND $id_username==$xml->Body->DATA->response->usuarioSolicitud) { $id_owner = 1; }
                if($xml->Body->DATA->response->tipoEstado=="CO" AND $id_username==$xml->Body->DATA->response->usuarioSolicitud) { $id_owner = 1; }
            break;
            case USER_ROL_JEFE_DE_OFICINA:
                if($xml->Body->DATA->response->tipoEstado=="PA" AND $id_username==$xml->Body->DATA->response->canal) { $id_owner = 1; }
                if($xml->Body->DATA->response->tipoEstado=="AU" AND $id_username==$xml->Body->DATA->response->canal) { $id_owner = 1; }
            break;
            default:
            break;
        }

        $id_estado = (string)$xml->Body->DATA->response->tipoEstado;
        $result = $this->glossary->get_estado_cotizaById($id_estado);
        $glosaEstado = ($result!=false ? $result->NAME : "");
    }

    // SET SESSION OWNER DOCUMENT REQUEST
    $this->session->set_userdata("owner", $id_owner);
    $this->session->set_userdata("code_status", $id_estado);
    $this->session->set_userdata("name_status", $glosaEstado);

}

public function getRequestLinked() {

    $return = check_session("");
    $idDocument = $this->input->post("idDocument");
    $result = $this->readRequestLinked($idDocument);
    $data = $result;
    echo json_encode($data);

}
private function readRequestLinked($idDocument) {

    $return = check_session("");
    $username = $this->session->userdata("username");

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
         <req:usuarioSolicitud></req:usuarioSolicitud>
         <req:codLocal></req:codLocal>
      </req:DATA>
      </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaCotizacionesSAV;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaCotizacionesSAV, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaCotizacionesSAV);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $value["retorno"] = $eval["retorno"];
      $value["descRetorno"] = $eval["descRetorno"];

      $data = $value;
      return($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    $data = array();
    if($retorno==0) {

        $id = (string)$xml->Body->DATA->response->tipoEstado;
        $result = $this->glossary->get_estado_cotizaById($id);
        if($result!=false) { $glosaEstado = $result->NAME; } else { $glosaEstado = "-"; }

        $glosaEnlace = "-";
        $id = (string)$xml->Body->DATA->response->estadoEnlace;
        $result = $this->glossary->get_EstadoEnlaceById($id);
        if($result!=false) { $glosaEnlace = $result->NAME; } else { $glosaEnlace = "-"; }

        $value["estadoEnlace"] = (string)$xml->Body->DATA->response->estadoEnlace;
        $value["tipoEstado"] = (string)$xml->Body->DATA->response->tipoEstado;
        $value["glosaEstado"] = $glosaEstado;
        $value["glosaEnlace"] = $glosaEnlace;
        $value["codLocal"] = (string)$xml->Body->DATA->response->codLocal;
        $value["sucursalOrigen"] = (string)$xml->Body->DATA->response->sucursalOrigen;
        $value["sucursalDestino"] = (string)$xml->Body->DATA->response->sucursalDestino;
        $value["sucursalCurse"] = (string)$xml->Body->DATA->response->sucursalCurse;

        $id = (string)$xml->Body->DATA->response->sucursalOrigen;
        $result = $this->parameters->get_officeById($id);
        if($result!=false) { $value["nameSucursalOrigen"] = $result->name; } else { $value["nameSucursalOrigen"] = "-"; }

        $id = (string)$xml->Body->DATA->response->sucursalDestino;
        $result = $this->parameters->get_officeById((string)$xml->Body->DATA->response->sucursalDestino);
        if($result!=false) { $value["nameSucursalDestino"] = $result->name; } else { $value["nameSucursalDestino"] = "-"; }

        $id = (string)$xml->Body->DATA->response->sucursalDestino;
        $result = $this->parameters->get_officeById($id);
        if($result!=false) { $value["nameSucursalCurse"] = $result->name; } else { $value["nameSucursalCurse"] = "-"; }

        $value["usuarioSolicitud"] = (string)$xml->Body->DATA->response->usuarioSolicitud;
        $value["nombres"] = (string)$xml->Body->DATA->response->nombres;
        $value["apellidoPaterno"] = (string)$xml->Body->DATA->response->apellidoPaterno;
        $value["apellidoMaterno"] = (string)$xml->Body->DATA->response->apellidoMaterno;
        $value["fechaSolicitud"] = substr((string)$xml->Body->DATA->response->fechaSolicitud,0,10);
        $value["fechaVigencia"] = substr((string)$xml->Body->DATA->response->fechaVigencia,0,10);
        $value["montoBruto"] = number_format((float)$xml->Body->DATA->response->montoBruto,0,',','.');
        $value["montoSolicitado"] = number_format((float)$xml->Body->DATA->response->montoSolicitado,0,',','.');
        $value["canal"] = (string)$xml->Body->DATA->response->canal;
        $value["nroRut"] = (string)$xml->Body->DATA->response->nroRut;

    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $data = $value;

    return($data);
}

private function get_offersByRut($nroRut){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $username = $this->session->userdata("username");
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:rut>'.$nroRut.'</req:rut>
          <req:tipoCampagna>'.CODIGO_SUPER_AVANCE.'</req:tipoCampagna>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_DatosOfertaTC;
    $soap = get_SOAP($EndPoint, WS_Action_DatosOfertaTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_DatosOfertaTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $value["retorno"] = $eval["retorno"];
      $value["descRetorno"] = $eval["descRetorno"];

      $data = $value;
      return($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno; $flg_aprobado = 0;

    $htmlOffers = '<table class="table table-striped table-bordered" border="0" id="tabOffers">
        <thead>
            <tr >
                <td scope="col" class="text-center"><strong>Selecci&#243;n</td>
                <td scope="col" class="text-center"><strong>Campa&#241;a</strong></td>
                <td scope="col" class="text-center"><strong>Estado</strong></td>
                <td scope="col" class="text-center"><strong>Fecha Vigencia</strong></td>
                <td scope="col" class="text-center"><strong>Monto Aprobado</strong></td>
                <td scope="col" class="text-center"><strong>Monto Pre Aprobado</strong></td>
                <td scope="col" class="text-center"><strong>Plazo Maximo</strong></td>
            </tr>
        </thead><tbody>';

    if($retorno==0){

        $estado = ((int)$xml->Body->DATA->response->estadoCampagna == 1 ? DESCRIP_VIGENTE : DESCRIP_NO_VIGENTE);
        $htmlOffers = $htmlOffers .'
            <tr onclick="Client.selectOffers(this);">
            <td scope="col" class="text-center"><input type="radio" name="checkRequest" value="sel1" id="sel1"></td>
            <td scope="col" class="text-center"><strong>'.DESCRIP_SUPER_AVANCE.'</strong></td>
            <td scope="col" class="text-center"><strong>'.substr((string)$xml->Body->DATA->response->fechaVigencia,0,10).'</strong></td>
            <td scope="col" class="text-center"><strong>'.$estado.'</strong></td>
            <td scope="col" class="text-center"><strong>$'.number_format((float)$xml->Body->DATA->response->montoOferta,0, ",", ".").'</strong></td>
            <td scope="col" class="text-center"><strong>$'.number_format((float)$xml->Body->DATA->response->montoPreaprobado,0, ",", ".").'</strong></td>
            <td scope="col" class="text-center"><strong>'.(int)$xml->Body->DATA->response->plazoMaximoOferta.'</strong></td>
            </tr>';

            $data['codestatusCampagna'] = (int)$xml->Body->DATA->response->estadoCampagna;
            $data['namestatusCampagna'] = $estado;
            $data['estadoOferta'] = (int)$xml->Body->DATA->response->estadoOferta;
            $data['fechaVigencia'] = (string)$xml->Body->DATA->response->fechaVigencia;
            $data['montoOferta'] = (float)$xml->Body->DATA->response->montoOferta;
            $data['montoPreaprobado'] = (float)$xml->Body->DATA->response->montoPreaprobado;
            $data['plazoMaximoOferta'] = (int)$xml->Body->DATA->response->plazoMaximoOferta;
            $data['aprobado'] = (int)$xml->Body->DATA->response->aprobado;

            $popupOffers = "<h3><strong>Cliente con oferta de ".DESCRIP_SUPER_AVANCE." aprobado por $". number_format((float)$xml->Body->DATA->response->montoOferta,0 ,',', '.');
            $popupOffers.= " oferta vigente al ".substr((string)$xml->Body->DATA->response->fechaVigencia,0,10);

            if((int)$xml->Body->DATA->response->aprobado==0 AND $this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING) {
                $popupOffers.= " derivar a un CENTRO DE SERVICIO";
                $data['derivarCentroDeServicio'] = 1;
            }else{
                $data['derivarCentroDeServicio'] = 0;
            }

            $data['popupOffers'] = $popupOffers;

    }else{
        $htmlOffers = $htmlOffers .'
            <tr ">
            <td scope="col" class="text-center" colspan=6>CLIENTE NO REGISTRA OFERTAS</td>
            </tr>';

        $descRetorno  = "<strong>Cliente no tiene Ofertas Vigente ..</strong>";
    }

    $data['nameClient'] = $this->session->userdata("nombres")." ".$this->session->userdata("apellidoPaterno")." ".$this->session->userdata("apellidoMaterno");
    $data['birthDate'] = $this->session->userdata("birthDate");
    $data['diffYear'] = $this->session->userdata("diffYear");
    $data['titleOffers'] = "<h4><strong>OFERTAS VIGENTES</strong></h4>";
    $data['htmlOffers'] = $htmlOffers;
    $data['retorno'] = $retorno;
    $data['descRetorno'] = $descRetorno;
    $data['nombreCampagna'] = DESCRIP_SUPER_AVANCE;

    put_logevent($soap, SOAP_OK);
    return ($data);
}


private function get_requestByRut($nroRut) {

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $username = $this->session->userdata("username");
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:sucursalOrigen></req:sucursalOrigen>
         <req:sucursalDestino></req:sucursalDestino>
         <req:nroRut>'.$nroRut.'</req:nroRut>
         <req:tipoEstado></req:tipoEstado>
         <req:idSolicitud></req:idSolicitud>
         <req:fechaDesde></req:fechaDesde>
         <req:fechaHasta></req:fechaHasta>
         <req:usuarioSolicitud></req:usuarioSolicitud>
         <req:codLocal></req:codLocal>
      </req:DATA>
      </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaCotizacionesSAV;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaCotizacionesSAV, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "cabeceraSalida", WS_ConsultaCotizacionesSAV);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    $htmlRequest = '<table class="table table-striped table-bordered" border="0" id="tabRequest">
        <thead>
            <tr >
                <td scope="col" class="text-center"><strong>Selecci&#243;n</td>
                <td scope="col" class="text-center"><strong>C&#243;digo</strong></td>
                <td scope="col" class="text-center"><strong>Fecha Emisión</strong></td>
                <td scope="col" class="text-center"><strong>Fecha Vigencia</strong></td>
                <td scope="col" class="text-center"><strong>Monto</strong></td>
                <td scope="col" class="text-center"><strong>Plazo</strong></td>
                <td scope="col" class="text-center"><strong>Estado</strong></td>
            </tr>
        </thead><tbody>';

    $todayDay = strtotime(date("d-m-Y H:i:00",time())); $flg_print = false;

    if($retorno==0){

        foreach ($xml->Body->DATA as $recordTRX) {
            foreach ($recordTRX as $nodo) {

            $fechaSolicitud = (string)$nodo->fechaSolicitud;
            $fechaVigencia = strtotime('+7 day', strtotime($nodo->fechaSolicitud));

            if(((string)$nodo->tipoEstado=="CO" OR
                (string)$nodo->tipoEstado=="AU" OR
                (string)$nodo->tipoEstado=="I" OR
                (string)$nodo->tipoEstado=="PE" OR
                (string)$nodo->tipoEstado=="PA" ) AND $todayDay<=$fechaVigencia) {

                $id = (string)$nodo->tipoEstado;
                $result = $this->glossary->get_estado_cotizaById($id);
                if($result!=false) { $glosaEstado = $result->NAME; }

                $flg_print = true;
                $htmlRequest = $htmlRequest .'
                    <tr onclick="Client.selectRequest(this);">
                    <td scope="col" class="text-center"><input type="radio" name="checkRequest" value="'.$nodo->idSolicitud.'" id="sel'.$nodo->idSolicitud.'"></td>
                    <td scope="col" class="text-center" nowrap>'.$nodo->idSolicitud.'</td>
                    <td scope="col" class="text-center"><strong>'.substr($nodo->fechaSolicitud,0,10).'</strong></td>
                    <td scope="col" class="text-center"><strong>'.substr($nodo->fechaVigencia,0,10).'</strong></td>
                    <td scope="col" class="text-center"><strong>$'.number_format((float)$nodo->montoSolicitado,0,',','.').'</strong></td>
                    <td scope="col" class="text-center"><strong>'.$nodo->numeroCuotas.'</strong></td>
                    <td scope="col" class="text-center"><strong>'.$glosaEstado.'</strong></td>
                    </tr>';
            }
            }
        }

    }else{

        $htmlRequest = $htmlRequest .'
            <tr>
                <td scope="col" class="text-center" nowrap colspan="6">'.$descRetorno.'</td>
            </tr>';
    }
    $htmlRequest = $htmlRequest . '</tbody></table>';
    $value['titleRequest'] = "<h4><strong>COTIZACIONES VIGENTES</strong></h4>";

    if(!$flg_print) { $retorno = 101; $htmlRequest = "";}
    $value['retorno'] = $retorno;
    $value['htmlRequest'] = $htmlRequest;
    $data = $value;

    put_logevent($soap, SOAP_OK);
    return($data);
}

public function get_requestById() {

    $return = check_session("");
    $id = $this->input->post("id");
    $data = $this->get_simulateById($id, "C", "json");
    echo ($data);
}

private function get_Homologador_BusquedaPorRutComercio($nroRut, $comercio, $codProducto){

    $username = $this->session->userdata("username");
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
    $soap = get_SOAP($EndPoint, WS_Action_Homologador, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "cabeceraSalida", WS_ConsultaCotizacionesSAV);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    put_logevent($soap, SOAP_OK);
    return($soap["xmlString"]);
}

private function checkProductValid($nroRut, $nroTcv, $flg_flujo) {

    $nroRut = str_replace('.', '', $nroRut); 
    $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $username = $this->session->userdata("username");

    $data = array();
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/DatosProductoTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:RUT>'.$nroRut.'</req:RUT>
          <req:COMERCIO>27</req:COMERCIO>
          <req:PAN>'.$nroTcv.'</req:PAN>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_DatosProductoTC;
    $soap = get_SOAP($EndPoint, WS_Action_DatosProductoTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_DatosProductoTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];
      return ($data);
    }
    $xml = $eval["xmlDocument"];

    $parameters = $this->parameters->get_generalParameters();
    if( ! $parameters ){

      $data["retorno"] = COD_ERROR_INIT;
      $data["descRetorno"] = "Error, parámetros generales no definidos";
      return ($data);
    }

    $_valid_product_sale =  explode(",", $parameters->valid_product_sale);

    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;
    if($retorno==0) {

        $data["retorno"] = COD_ERROR_INIT;
        $data["descRetorno"] = "Cliente no tiene ".CODIGO_SUPER_AVANCE." vigente";

        foreach ($xml->Body->DATA as $record) {
            foreach ($record->Registro as $nodo) {

                $result = in_array((string)$nodo->producto, $_valid_product_sale);

                if($result){
                    $data["retorno"] = 0;
                    $data["descRetorno"] = "Cliente con ".CODIGO_SUPER_AVANCE." vigente..!";
                    $data["producto"] = (string)$nodo->producto;
                    $data["fechaContratacion"] = (string)$nodo->fechaContratacion;
                    $data["montoContratado"] = (float)$nodo->montoContratado;
                    $data["montoCuota"] = (int)$nodo->montoCuota;
                    $data["cuotasContratadas"] = (int)$nodo->cuotasContratadas;
                    $data["cuotasFacturadas"] = (int)$nodo->cuotasFacturadas;
                }
            }
        }

    } else {

        $data["retorno"] = COD_ERROR_INIT;
        $data["descRetorno"] = "Cliente no tiene ".CODIGO_SUPER_AVANCE." vigente";

    }

    return ($data);
}

public function changeStatus() {

    $return = check_session("");

    $id = $this->input->post("id");
    $todayDay = date("d-m-Y");
    $status = $this->input->post("status");
    $type = $this->input->post("type");

    $username = $this->session->userdata("username");
    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$id.'</req:numeroDeDocumento>
         <req:tipoTrx>'.CODIGO_SUPER_AVANCE.'</req:tipoTrx>
         <req:estado>'.$status.'</req:estado>
         <req:fechaEstado>'.$todayDay.' 00:00:00</req:fechaEstado>
         <req:ejecutivo>'.$this->session->userdata('username').'</req:ejecutivo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    switch ($type) {
        case 'SIM':
            $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActEstadoSavYRefTC;
            $soap = get_SOAP($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml, $username);
            if($soap["codErrorSOAP"]!=0) {

                $value["retorno"] = $soap["codErrorSOAP"];
                $value["descRetorno"] = $soap["msgErrorSOAP"];
                $data = $value;

                put_logevent($soap, SOAP_ERROR);

                echo json_encode($data);
                exit(0);
            }
            $eval = eval_response_SOAP($soap["xmlString"], "cabeceraSalida", WS_ActEstadoSavYRefTC);
            if($eval["retorno"]!=0){

                $value["retorno"] = $eval["retorno"];
                $value["descRetorno"] = $eval["descRetorno"];
                $data = $value;

                put_logevent($soap, SOAP_ERROR);

                echo json_encode($data);
                exit(0);
            }
            $xml = $eval["xmlDocument"];
            $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

            $value["retorno"] = $retorno;
            $value["descRetorno"] = "Simulaci&#243;n SAV marcada como Impresa ..";
        break;

        case 'COT':
            $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActEstadoSavYRefTC;
            $soap = get_SOAP($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml, $username);
            if($soap["codErrorSOAP"]!=0) {

                $value["retorno"] = $soap["codErrorSOAP"];
                $value["descRetorno"] = $soap["msgErrorSOAP"];
                $data = $value;

                put_logevent($soap, SOAP_ERROR);

                echo json_encode($data);
                exit(0);
            }
            $eval = eval_response_SOAP($soap["xmlString"], "cabeceraSalida", WS_ActEstadoSavYRefTC);
            if($eval["retorno"]!=0){

                $value["retorno"] = $eval["retorno"];
                $value["descRetorno"] = $eval["descRetorno"];
                $data = $value;

                put_logevent($soap, SOAP_ERROR);

                echo json_encode($data);
                exit(0);
            }
            $xml = $eval["xmlDocument"];

            $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

            $value["retorno"] = $retorno;
            $value["descRetorno"] = "Cotizaci&#243;n SAV marcada como Impresa ..";
        break;
        default:
            $value["retorno"] = 10;
            $value["descRetorno"] = "Marca de impresi&#243;n, no procesada";
        break;
    }

    $data = $value;
    echo json_encode($data);
}

public function changeLinked() {

    $return = check_session("");

    $timestamp = date("d-m-Y H:i:s");
    $idDocument = $this->input->post("idDocument");
    $idStatus = $this->input->post("idStatus");
    $username = $this->session->userdata("username");

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:id_solicitud>'.$idDocument.'</req:id_solicitud>
         <req:estado_enlace>'.$idStatus.'</req:estado_enlace>
         <req:fecha_rechazo>'.$timestamp.'</req:fecha_rechazo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaEnlaceTC;
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaEnlaceTC, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);

        echo json_encode($data);
        exit(0);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "cabeceraSalida", WS_ActualizaEnlaceTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);

        echo json_encode($data);
        exit(0);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $data = $value;

    put_logevent($soap, SOAP_OK);
    echo json_encode($data);
}

public function put_modifystatus() {

    $return = check_session("");

    $id = $this->input->post("id");
    $todayDay = date("d-m-Y");
    $status = $this->input->post("status");
    $username = $this->session->userdata("username");

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$id.'</req:numeroDeDocumento>
         <req:tipoTrx>'.CODIGO_SUPER_AVANCE.'</req:tipoTrx>
         <req:estado>'.$status.'</req:estado>
         <req:fechaEstado>'.$todayDay.' 00:00:00</req:fechaEstado>
         <req:ejecutivo>'.$this->session->userdata('username').'</req:ejecutivo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActEstadoSavYRefTC;
    $soap = get_SOAP($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);

        echo json_encode($data);
        exit(0);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "cabeceraSalida", WS_ActEstadoSavYRefTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);

        echo json_encode($data);
        exit(0);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $data = $value;
    echo json_encode($data);
}


public function valid() {

    $return = check_session("4.1.6");

    $idDocument = $this->input->post("idDocument");
    $nroRut = $this->input->post("nroRut");

    $this->validRequestOwner($idDocument); // SET OWNER AND STATUS DOCUMENT
    $this->session->set_userdata("showDeny", "valid");

    if($this->session->userdata("id_rol")==USER_ROL_JEFE_DE_OFICINA){

            $dataLoad = $this->readRequestById($idDocument, $nroRut);
            $this->load->view('manager/valid', $dataLoad);
    }else{

        if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING){

            $dataLoad = $this->loadDataToValid($idDocument, $nroRut);
            $this->load->view('advance/valid', $dataLoad);

        }else{

            $this->search();
        }
    }


}


public function approbation() {

    $return = check_session("4.1.5");

    $id_rol = $this->session->userdata("id_rol");
    $idDocument = $this->session->userdata("idDocument");
    $nroRut = $this->session->userdata("idClient");
    $this->session->set_userdata("showDeny", "approbation");

    $this->validRequestOwner($idDocument); // SET OWNER DOCUMENT
    $dataLoad = $this->readRequestById($idDocument, $nroRut);

    if($this->session->userdata("id_rol")==USER_ROL_JEFE_DE_OFICINA){

            $this->load->view('manager/approbation', $dataLoad);
    }else{

        if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING){

            $this->load->view('advance/approbation', $dataLoad);

        }else{

            $this->search();
        }
    }

}


public function statustransfer() {
    if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
    if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }
    $this->session->set_userdata('selector', '4.1.8');

    $this->load->view("advance/statustransfer");
}

public function get_statustransfer(){

    $return = check_session("");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = $this->input->post("nroRut");
    $eval = validaRUTCL($nroRut);
    if($eval["retorno"]!=0){
      cancel_function(COD_ERROR_INIT, $eval["descRetorno"], "Preste Atención");
    }

    $comercio = 27; $codProducto = "T"; $retorno=COD_ERROR_INIT; $username = $this->session->userdata("username");

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if($dataHomologador["retorno"]!=0){ cancel_function(10, $dataHomologador["descRetorno"], ""); }
    $flg_flujo = $dataHomologador["flg_flujo"]; $nroTcv = $dataHomologador["nroTcv"];

    $dataClient = ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username);
    if($dataClient["retorno"]!=0){ cancel_function(10, $dataClient["descRetorno"], ""); }
    $value["completeNameClient"] = $dataClient["nombres"] .' '. $dataClient["apellidoPaterno"] .' '. $dataClient["apellidoMaterno"];

    $dataInput = array(
        "nroRut" => $nroRut,
        "username" => $this->session->userdata("username")
      );

    $result = ws_GET_ConsultaEstadoTransferenciaSAV($dataInput);

    $value['htmlTransfer'] = '<table class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
              <th class="text-center">Cod.Autorización</th>
              <th class="text-center">Tipo Trans.</th>
              <th class="text-center">Nombre Trans.</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Rut</th>
              <th class="text-center">Monto</th>
              <th class="text-center">Cuotas</th>
              <th class="text-center" width="50px">Fecha</th>
              <th class="text-center" width="50px">Hora</th>
              <th class="text-center">Tipo Cuenta</th>
              <th class="text-center">Email</th>
              <th class="text-center">Glosa</th>
            </tr>
        </thead>
        <tbody>';

    if($result["retorno"]==0){

        $value["htmlTransfer"].='
            <tr>
              <td scope="col" class="text-center">'.$result["codAut"].'</td>
              <td scope="col" class="text-center">'.$result["tipTrans"].'</td>
              <td scope="col" class="text-center">'.$result["trxNombre"].'</td>
              <td scope="col" class="text-center">'.$result["ctaDestinoNombreTitular"].'</td>
              <td scope="col" class="text-center">'.$result["ctaDestinoRutTitular"].'</td>
              <td scope="col" class="text-right">$'.number_format((float)$result["monto"], 0, ',', '.').'</td>
              <td scope="col" class="text-center">'.$result["cuotas"].'</td>
              <td scope="col" class="text-center">'.$result["fechaTrans"].'</td>
              <td scope="col" class="text-center">'.$result["horaTrans"].'</td>
              <td scope="col" class="text-center">'.$result["ctaDestinoTipoCuenta"].'</td>
              <td scope="col" class="text-center">'.$result["ctaDestinoEmail"].'</td>
              <td scope="col" class="text-center">'.$result["glosa"].'</td>
            </tr>
            </tbody>
            </table>';

    }else{

        $value['htmlTransfer'].= '
            <tr>
              <td class="text-center" colspan="12">'.$result["descRetorno"].'</td>
            </tr>
            </tbody>
            </table>';
    }

    $value["retorno"] = $result["retorno"];
    $value["descRetorno"] = $result["descRetorno"];

    $data = $value;
    echo json_encode($data);

}


public function documents() {
    $return = check_session("4.1.4");

    $idDocument = $this->session->userdata("idDocument");
    $nroRut = $this->session->userdata("idClient");
    if($idDocument=="" OR $idDocument===NULL) {
        $this->search();
    }else{

        $this->validRequestOwner($idDocument);

        if($this->session->userdata("code_status")!="CO"){

            $this->search();

        }else{

            $dataLoad["dataRequest"] = $this->get_simulateById($idDocument, "C", "array");
            $this->load->view("advance/documents", $dataLoad);

        }

    }

}

private function loadDataToApprobation($id, $nroRut) {

    if($this->session->userdata('lock') === NULL) {redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
    $username = $this->session->userdata("username");

    $result = ws_GET_HomologadorByRut($nroRut, $username);
    if($result["retorno"]!=0) {

        cancel_function($result["retorno"], $result["descRetorno"], "frontend");
    }
    $flg_flujo = $result["flg_flujo"]; $nroTcv = $result["nroTcv"];

    $result = ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username);
    if($result["retorno"]!=0) {

        cancel_function($result["retorno"], $result["descRetorno"], "frontend");
    }
    $data["dataCliente"] = $result; // Guarda Datos del Cliente
    $data["dataRequest"] = $this->get_simulateById($id, "C", "array");

    $result = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
    if($result["retorno"]!=0){

        cancel_function($result["retorno"],$result["descRetorno"],"frontend");
    }
    $contrato = $result["contrato"];
    $data["dataCuenta"] = $result; // Guarda Datos Cuenta
    $data["dataCuenta"]["nroTcv"] = $nroTcv;

    return($data);

}

private function loadDataToValid($id, $nroRut) {
    $username = $this->session->userdata("username");
    $result = ws_GET_HomologadorByRut($nroRut, $username);
    if($result["retorno"]!=0) {

        cancel_function($result["retorno"], $result["descRetorno"], "frontend");
    }
    $flg_flujo = $result["flg_flujo"]; $nroTcv = $result["nroTcv"];

    $result = ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username);
    if($result["retorno"]!=0) {

        cancel_function($result["retorno"], $result["descRetorno"], "frontend");
    }
    $data["dataCliente"] = $result; // Guarda Datos del Cliente
    $data["dataRequest"] = $this->get_simulateById($id, "C", "array");

    if($data["dataRequest"]["costoTotalSeguro1"]!="0" AND $data["dataRequest"]["costoTotalSeguro2"]!="0") {

          $result = $this->glossary->get_script_confirmacion_venta_sav(13304, $flg_flujo);
          if($result!=false) { $script = $result->SCRIPT; } else { $script = ""; }

    } elseif($data["dataRequest"]["costoTotalSeguro1"]!="0" AND $data["dataRequest"]["costoTotalSeguro2"]=="0") {

          $result = $this->glossary->get_script_confirmacion_venta_sav(13302, $flg_flujo);
          if($result!=false) { $script = $result->SCRIPT; } else { $script = ""; }

    } elseif($data["dataRequest"]["costoTotalSeguro1"]=="0" AND $data["dataRequest"]["costoTotalSeguro2"]!="0") {

          $result = $this->glossary->get_script_confirmacion_venta_sav(13303, $flg_flujo);
          if($result!=false) { $script = $result->SCRIPT; } else { $script = ""; }

    } elseif($data["dataRequest"]["costoTotalSeguro1"]=="0" AND $data["dataRequest"]["costoTotalSeguro2"]=="0") {

          $result = $this->glossary->get_script_confirmacion_venta_sav(13301, $flg_flujo);
          if($result!=false) { $script = $result->SCRIPT; } else { $script = ""; }

    }
    $script = str_replace("&fecha_del_dia&", date("d-m-Y"), $script);
    $script = str_replace("&numero_rut_cliente&", $nroRut, $script);
    $script = str_replace("&monto_liquido_sav&", $data["dataRequest"]["montoLiquido"], $script);
    $script = str_replace("&numero_cuenta_banco_cliente&", $data["dataRequest"]['numeroCuenta'], $script);
    $script = str_replace("&nombre_banco_cliente&", $data["dataRequest"]['glosaBanco'], $script);
    $script = str_replace("&monto_total_sav&", $data["dataRequest"]["montoaFinanciar"], $script);
    $script = str_replace("&costo_total_seguro1&", $data["dataRequest"]["costoTotalSeguro1"], $script);
    $script = str_replace("&costo_total_seguro2&", $data["dataRequest"]["costoTotalSeguro2"], $script);

    $data["dataRequest"]["cargaAnualEquivalente"] = str_replace(".", ",", $data["dataRequest"]["cargaAnualEquivalente"]);
    $data["dataRequest"]["tasaDeInteresMensual"] = str_replace(".", ",", $data["dataRequest"]["tasaDeInteresMensual"]);

    $script = str_replace("&nombre_completo_cliente&", $data["dataCliente"]["nombreCliente"], $script);
    $script = str_replace("&tasa_interes_mensual_sav&", $data["dataRequest"]["tasaDeInteresMensual"], $script);
    $script = str_replace("&numero_cuotas_sav&", $data["dataRequest"]["plazoDeCuota"], $script);
    $script = str_replace("&valor_cuotas_sav&", $data["dataRequest"]["valorDeCuota"], $script);
    $script = str_replace("&monto_impuestos_sav&", $data["dataRequest"]["impuestos"], $script);
    $script = str_replace("&fecha_primer_vencimiento&", $data["dataRequest"]["fechaPrimerVencimiento"], $script);
    $script = str_replace("&tasa_cae_sav&", $data["dataRequest"]["cargaAnualEquivalente"], $script);
    $script = str_replace("&costo_total_sav&", $data["dataRequest"]["costoTotalDelCredito"], $script);
    $script = str_replace("&email_cliente&", $data["dataRequest"]["email"], $script);

    if($data["dataCliente"]["sexo"]=="FEM") {

        $script = str_replace("&atencion_cliente&", "Sra/Srta:", $script);
    } else {

        $script = str_replace("&atencion_cliente&", "Don:", $script);
    }
    if(date("H") > 12) {

      $script = str_replace("&despedida_ampm&", "una excelente Tarde !!", $script);
    } else {

      $script = str_replace("&despedida_ampm&", "un excelente Día !!", $script);
    }

    $data["dataScript"] = $script;

    return($data);

}

private function readRequestById($id, $nroRut) {

    $username = $this->session->userdata("username");
    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"]!=0){ cancel_function(100, $dataHomologador["descRetorno"],""); }
    $flg_flujo = $dataHomologador["flg_flujo"]; $nroTcv = $dataHomologador["nroTcv"];

    $dataCliente = ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username);
    if($dataCliente["retorno"]!=0){
      cancel_function(100,"RUT no registra datos Cliente ..","");
    }

    $dataCuenta = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
    if($dataCuenta["retorno"]!=0){
      cancel_function(100,"RUT no registra datos Cuenta ..","");
    }
    $contrato = $dataCuenta["contrato"]; $dataCuenta["nroTcv"] = $nroTcv;

    $dataUltTRX = ws_GET_ConsultaUltimasTransaccionesTC($contrato, $flg_flujo, $username);
    $dataDireccion = ws_GET_DatosContactos($nroRut, $contrato, $flg_flujo,$username);

    if($flg_flujo=="001"){

        $dataInput = array(
            "nroRut" => "",
            "contrato" => "",
            "fechaVencimiento" => "",
            "estadoEecc" => "",
            "pan" => $nroTcv,
            "flg_flujo" => $flg_flujo,
            "username" => $this->session->userdata("username")
        );

    }else{

        $dataInput = array(
            "nroRut" => $nroRut,
            "contrato" => $contrato,
            "fechaVencimiento" => "",
            "estadoEecc" => "",
            "pan" => "",
            "flg_flujo" => $flg_flujo,
            "username" => $this->session->userdata("username")
        );
    }

    $dataEECC = ws_GET_ConsultaDatosEECCTC($dataInput);
    $dataADI = array(); //$this->get_ConsultaDatosAdicionales($contrato, $flg_flujo);

    $dataRequest = $this->get_simulateById($id, "C", "array");

    $data["dataDireccion"] = $dataDireccion;
    $data["dataRequest"] = $dataRequest;
    $data["dataCliente"] = $dataCliente;
    $data["dataCuenta"] = $dataCuenta;
    $data["dataUltTRX"] = $dataUltTRX;
    $data["dataEECC"] = $dataEECC;
    $data["dataADI"] = $dataADI;
    return($data);

}

private function get_ConsultaDatosAdicionales($contrato, $flg_flujo){

    $username = $this->session->userdata("username");
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosAdicionales/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:CONTRATO>'.$contrato.'</req:CONTRATO>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosAdicionales;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosAdicionales, WS_Timeout, $Request, WS_ToXml, $username);


    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "descRetorno", WS_ConsultaDatosAdicionales);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;
    $ind = 0; $nombresAdi = "";
    foreach ($xml->Body->DATA->Registro as $nodo) {

        $nombresAdi .= (string)$nodo->nombresAdi ."/";
/*
        $datanew["nroRutAdi"] = (string)$nodo->nroRutAdi.'-'.$dgvRut;
        $datanew["sexoAdi"] = ltrim(rtrim($nodo->sexoAdi));
        $datanew["fechaNacimientoAdi"] = substr($nodo->fechaNacimientoAdi,0,10);
        $datanew["nombresAdi"] = (string)$nodo->nombresAdi;
        $datanew["apellidoPaternoAdi"] = (string)$nodo->apellidoPaternoAdi;
        $datanew["apellidoMaternoAdi"] = (string)$nodo->apellidoMaternoAdi;
        $datanew["relacion"] = (string)$nodo->relacion;
*/
        $ind = $ind + 1;
    }

    $data = array(
        "numeroAdi" => $ind,
        "nombresAdi" => $nombresAdi
        );

    put_logevent($soap, SOAP_OK);
    return($data);
}




public function updateEstadoSAV() {

    $return = check_session("4.1.4");

    $this->form_validation->set_rules('idDocument', 'N&#250;mero Documento', 'required');
    $this->form_validation->set_rules('nroRut', 'N&#250;mero de Rut', 'required');
    $this->form_validation->set_rules('tipoEstado', 'Tipo Estado', 'required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $retorno = COD_ERROR_INIT; $descRetorno="";
    $idDocument = $this->input->post("idDocument");
    $tipoEstado = $this->input->post("tipoEstado");
    $nroRut = $this->input->post("nroRut");
    $tipoRechazo = $this->input->post("typeDeny");
    $razonRechazo = $this->input->post("reasonDeny");

    $todayDay = date("d-m-Y"); $dataLoad = array();

    if($tipoRechazo=="valid" OR $tipoRechazo=="approbation") {

        $result = $this->actualizaGlosaSAV($idDocument, $razonRechazo, $tipoRechazo);
        $value["descRetornoRechazo"] = $result["descRetorno"];
    }

    $result = $this->actualizaEstadoSAV($idDocument, $tipoEstado);
    if($result["retorno"]!=0) {
        $value["descRetorno"] = $result["descRetorno"];
    }

    /********************
    Estado = "C" => Bajar oferta del cliente
    ********************/
    IF($tipoEstado=="C") {

        $eval = $this->ws_SAV_update_Ofert($nroRut);

        if($eval["retorno"]==0) {
            $value["descRetorno"] = $eval["descRetorno"];
        }

    }


    $value["retorno"] = $result["retorno"];
    $value["descRetorno"] = $result["descRetorno"];
    $value["tipoEstado"] = $tipoEstado;
    $value["fechaEstado"] = $result["timestamp"];

    // SET session by Aprobation / Liquidation / Etc.
    $this->session->set_userdata("idDocument", $idDocument);
    $this->session->set_userdata("idEstado", $tipoEstado);
    $this->session->set_userdata("idClient", $nroRut);

    $data = $value;
    echo json_encode($data);

}

private function ws_SAV_update_Contract($field_id, $field_rut) {

    $this->documents->db_documentsById_delete($field_id, "CON");
    $arrDatos = $this->get_simulateById($field_id,"C","array");
    $result = $this->generaPDFSAV($field_rut, $field_id, "CON", $arrDatos);

    if($result["retorno"]==0) { return true; } else { return false; }

}

public function confirmRequest() {

    $return = check_session("4.1.4");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'required|trim');
    $this->form_validation->set_rules('idDocument', 'Número Cotización', 'required|trim');
    $this->form_validation->set_message('required','El atributo %s es obligatorio.');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $idDocument = $this->input->post("idDocument"); $nroRut = $this->input->post("nroRut"); $todayDay = date("d-m-Y");

    if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING){

      $tipoEstado = "AU"; $dataLoad = array();
      $value["glosaEstado"] = "COTIZACION AUTORIZADA";

    } else {

      $tipoEstado = "CO"; $dataLoad = array();
      $value["glosaEstado"] = "COTIZACION CONFIRMADA";

    }

    $value["tipoEstado"] = $tipoEstado;
    $result = $this->actualizaEstadoSAV($idDocument, $tipoEstado);
    if($result["retorno"]!=0) {
        cancel_function($result["retorno"],$result["descRetorno"],"");
    }
    $value["fechaEstado"] = $result["timestamp"];

    // SET session by Aprobation / Liquidation / Etc.
    $this->session->set_userdata("idDocument", $idDocument);
    $this->session->set_userdata("idEstado", $tipoEstado);
    $this->session->set_userdata("idClient", $nroRut);

    $arrDatos = $this->get_simulateById($idDocument,"C","array");

    if(!$this->documents->get_documentsExists($idDocument, "COT")) {
        $retorno = $this->generaPDFSAV($nroRut, $idDocument, "COT", $arrDatos);
    }
    if(!$this->documents->get_documentsExists($idDocument, "CON")) {
        $retorno = $this->generaPDFSAV($nroRut, $idDocument, "CON", $arrDatos);
    }

    if($arrDatos["flagSeguro1"]=="CON SEGURO") {

        if(!$this->documents->get_documentsExists($idDocument, "PRO")) {
            $retorno = $this->generaPDFSAV($nroRut, $idDocument, "PRO", $arrDatos);
        }
    }

    if($arrDatos["flagSeguro2"]=="CON SEGURO") {

        if(!$this->documents->get_documentsExists($idDocument, "DES")) {
            $retorno = $this->generaPDFSAV($nroRut, $idDocument, "DES", $arrDatos);
        }
    }

    switch ($this->session->userdata("id_rol")) {
        case USER_ROL_EJECUTIVO_TELEMARKETING:
            $this->valid();
        break;
        case USER_ROL_EJECUTIVO_COMERCIAL:
            $this->documents();
        break;

        default:
            $this->search();
        break;
    }

}

public function assignRequest() {

    $return = check_session("4.1.5");

    $idDocument = $this->input->post("idDocument");
    $idEstado = $this->input->post("idEstado");
    $nroRut = $this->input->post("nroRut");

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $r = new Rut();
    $r->number($nroRut);
    $dgvRut = $r->calculateVerificationNumber();
    $nroRut = $nroRut.$dgvRut;

    $todayDay = date("d-m-Y");
    $id_rol = $this->session->userdata("id_rol");

    // SET session by Aprobation / Liquidation / Etc.
    $this->session->set_userdata("idDocument", $idDocument);
    $this->session->set_userdata("idClient", $nroRut);
    $this->session->set_userdata("nroRut", $nroRut);
    $this->session->set_userdata("showDeny", "");

    $this->validRequestOwner($idDocument);

    $minQuotas=0; $maxQuotas=0; $minDeferred=0; $maxDeferred=0;
    $result = $this->parameters->get_quotasByProduct(CODIGO_SUPER_AVANCE);
    $minQuotas = (int)$result->CUOTAS_MINIMO;
    $maxQuotas = (int)$result->CUOTAS_MAXIMO;

    $result = $this->parameters->get_quotasDeferredByProduct(CODIGO_SUPER_AVANCE);
    $minDeferred = (int)$result->CUOTAS_MINIMO;
    $maxDeferred = (int)$result->CUOTAS_MAXIMO;

    $arrDataLoad = array(
        'minNumberQuotas' => $minQuotas,
        'maxNumberQuotas' => $maxQuotas,
        'minDeferredQuotas' => $minDeferred,
        'maxDeferredQuotas' => $maxDeferred,
        'nroRut' => $nroRut,
        'idDocument' => $idDocument,
        'interesRate' => "",
        'dateFirstExpiration' => "",
        'amountApproved' => 0,
        'amountPreAproved' => 0,
        'emailClient' => "",
        'dataload' => '{ "source": "search" } '
      );

    $dataSecure = $this->parameters->get_secureByRol($id_rol, CODIGO_SUPER_AVANCE);

    $ind = 1; $valueOne = array(); $valueTwo = array();
    foreach($dataSecure as $nodo) {

        if($ind==1){
            $valueOne["htmlName"] = $nodo->htmlName;
            $valueOne["htmlModal"] = $nodo->htmlModal;
            $valueOne["htmlDescrip"] = $nodo->descrip;
            $valueOne["htmlValue"] = $nodo->codSecure;
            $valueOne["codSecure"] = $nodo->codSecure;
            $valueOne["idPoliza"] = $nodo->idPoliza;
            $valueOne["htmlScript"] = $nodo->htmlScript;
        }

        if($ind==2){
            $valueTwo["htmlName"] = $nodo->htmlName;
            $valueTwo["htmlModal"] = $nodo->htmlModal;
            $valueTwo["htmlDescrip"] = $nodo->descrip;
            $valueTwo["htmlValue"] = $nodo->codSecure;
            $valueTwo["codSecure"] = $nodo->codSecure;
            $valueTwo["idPoliza"] = $nodo->idPoliza;
            $valueTwo["htmlScript"] = $nodo->htmlScript;
        }
        $ind = $ind + 1;
    }

    if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL) {

        switch ($idEstado) {
            case 'CO':
                $this->session->set_userdata('selector', '4.1.4');
                $dataLoad = $this->readRequestById($idDocument, $nroRut);
                $this->load->view("advance/documents", $dataLoad);
            break;
            default:
                $this->session->set_userdata('selector', '4.1.3');
                $this->data["dataLoad"] = $arrDataLoad;
                $this->data["secureOne"] = $valueOne;
                $this->data["secureTwo"] = $valueTwo;
                $this->load->view("advance/review", $this->data);
            break;
        }

    }

    if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING) {

        switch ($idEstado) {

            case 'PA':
                $this->session->set_userdata('selector', '4.1.5');
                $this->session->set_userdata('showDeny', 'approbation');
                $dataLoad = $this->readRequestById($idDocument, $nroRut);
                $this->load->view('advance/approbation', $dataLoad);
            break;
            case 'CO':
                $this->session->set_userdata('selector', '4.1.4');
                $this->session->set_userdata('showDeny', 'approbation');
                $this->loadDataToRemote($nroRut, $idDocument, $idEstado);
            break;
            case 'AU':
                $this->session->set_userdata('selector', '4.1.6');
                $this->session->set_userdata('showDeny', 'valid');
                $this->loadDataToRemote($nroRut, $idDocument, $idEstado);
            break;
            case 'I':
                $this->session->set_userdata('selector', '4.1.6');
                $this->session->set_userdata('showDeny', 'valid');
                $this->loadDataToRemote($nroRut, $idDocument, $idEstado);
            break;

            default:
                $this->session->set_userdata('selector', '4.1.3');
                $this->data["dataLoad"] = $arrDataLoad;
                $this->data["secureOne"] = $valueOne;
                $this->data["secureTwo"] = $valueTwo;
                $this->load->view("advance/review", $this->data);
            break;
        }

    }

    if($this->session->userdata("id_rol")==USER_ROL_JEFE_DE_OFICINA) {

        switch ($idEstado) {
            case 'AU':
                $this->session->set_userdata('selector', '4.1.5');
                $this->session->set_userdata('showDeny', 'valid');
                $dataLoad = $this->readRequestById($idDocument, $nroRut);
                $this->load->view('manager/valid', $dataLoad);
            break;
            case 'PA':
                $this->session->set_userdata('selector', '4.1.5');
                $this->session->set_userdata('showDeny', 'approbation');
                $dataLoad = $this->readRequestById($idDocument, $nroRut);
                $this->load->view('manager/approbation', $dataLoad);
            break;
            default:
                $this->session->set_userdata('selector', '4.1.3');
                $this->data["dataLoad"] = $arrDataLoad;
                $this->data["secureOne"] = $valueOne;
                $this->data["secureTwo"] = $valueTwo;
                $this->load->view("advance/review", $this->data);
            break;
        }

    }

}

private function checkConsumoValid($nroRut) {

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $username = $this->session->userdata("username");
    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
       <soapenv:Header/>
       <soapenv:Body>
          <req:DATA>
             <req:nroRut>'.$nroRut.'</req:nroRut>
          </req:DATA>
       </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsumoVigenteTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsumoVigenteTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsumoVigenteTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];
      return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0) {
        $data["retorno"] = 0;
        $data["descRetorno"] = "Cliente con ".DESCRIP_CONSUMO_VIGENTE;
        $data["cuotasPendientes"] = (int)$xml->Body->DATA->response->cuotasPendientes;
        $data["cuotasTotal"] = (int)$xml->Body->DATA->response->cuotasTotal;
        $data["fechaActivacion"] = (string)$xml->Body->DATA->response->fechaActivacion;
        $data["montoCuota"] = (float)$xml->Body->DATA->response->montoCuota;
        $data["montoLiquido"] = number_format((float)$xml->Body->DATA->response->montoLiquido,0, ",", ".");
        $data["numeroCredito"] = (float)$xml->Body->DATA->response->numeroCredito;
        return($data);
    }
    $data["retorno"] = COD_ERROR_INIT;
    $data["descRetorno"] = "Cliente no tiene ".DESCRIP_CONSUMO_VIGENTE;

    return ($data);
}

private function eval_cod_response($retorno, $descRetorno) {

    if($retorno!=0){
        $value['retorno'] = $retorno;
        $value['descRetorno'] = $descRetorno;
        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    return(true);
}

public function put_simulate() {

    $return = check_session("");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'required|trim');
    $this->form_validation->set_rules('emailClientNew', 'Email Cliente', 'valid_email|trim');
    $this->form_validation->set_message('required','El atributo %s es obligatorio.');
    $this->form_validation->set_message('valid_email','El atributo %s no es valido.');

    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $account_office = $this->session->userdata["id_office"]; $account_pos = ""; $account_transfer = "";
    $result = $this->parameters->get_officeById($account_office);
    if($result!=false){ $account_pos = $result->account_pos; $account_transfer = $result->account_transfer; }

    if($account_pos=="" or $account_transfer=="") {

        cancel_function(COD_ERROR_INIT, "Sucursal usuario, sin cuenta contable..", "");
    }

    $nroRut = $this->input->post("nroRut"); $username = $this->session->userdata("username");
    $flg_flujo = $this->session->userdata("flg_flujo");
    $contrato = $this->session->userdata("contrato");

    $email = $this->input->post("emailClientNew");

    if($email!="") {
        $result = ws_PUT_ActualizaEmail($nroRut, $contrato, $flg_flujo, $email, "HOME", $username );
    }

    $numeroRut = $nroRut; $dgvRut = substr($numeroRut, -1);
    $numeroRut = str_replace('.', '', $numeroRut); $numeroRut = str_replace('-', '', $numeroRut); $numeroRut = substr($numeroRut, 0, -1);

    $numeroCuotas = $this->input->post("numeroCuotas");
    $mesesDiferido = $this->input->post("mesesDiferido");
    $valorCuota = $this->input->post("valorCuota");
    $montoSolicitado = $this->input->post("montoSolicitado");
    $costoTotal = $this->input->post("costoTotal");
    $tasaInteres = $this->input->post("tasaInteres");
    $impuestos = $this->input->post("impuestos");
    $montoBruto = $this->input->post("montoBruto");
    $comision = $this->input->post("comision");
    $cae = $this->input->post("cae");
    $costoTotalSeguro1 = $this->input->post("costoTotalSeguro1");
    $costoTotalSeguro2 = $this->input->post("costoTotalSeguro2");
    $vencimientoCuota= $this->input->post("vencimientoCuota");
    $tipoSolicitud = $this->input->post("tipoSolicitud");
    $bank = $this->input->post("bank");
    $typeAccount = $this->input->post("typeAccount");
    $numberAccount = $this->input->post("numberAccount");
    $estadoEnlace = $this->input->post("estadoEnlace");
    $sucursalDestino = $this->input->post("sucursalDestino");
    if($estadoEnlace==""){
        $sucursalOrigen="";
    }else{
        $sucursalOrigen=$this->session->userdata["id_office"];
    }

    $offerType = $this->input->post("offerType");
    $fechaCompromisoEnlace = $this->input->post("fechaCompromisoEnlace");
    if($fechaCompromisoEnlace!="") {
        $fechaCompromisoEnlace = str_replace("/", "-", $fechaCompromisoEnlace);
        $fechaCompromisoEnlace = $fechaCompromisoEnlace . " 00:00:00";
    }

    $valorCuota = str_replace('$', '', $valorCuota); $valorCuota = str_replace('.', '', $valorCuota);
    $montoSolicitado = str_replace('$', '', $montoSolicitado); $montoSolicitado = str_replace('.', '', $montoSolicitado);
    $montoBruto = str_replace('$', '', $montoBruto); $montoBruto = str_replace('.', '', $montoBruto);
    $costoTotal = str_replace('$', '', $costoTotal); $costoTotal = str_replace('.', '', $costoTotal);
    $tasaInteres = str_replace('%', '', $tasaInteres); $tasaInteres = str_replace(',', '.', $tasaInteres);
    $impuestos = str_replace('$', '', $impuestos); $impuestos = str_replace('.', '', $impuestos);
    $comision = str_replace('$', '', $comision); $comision = str_replace('.', '.', $comision);
    $cae = str_replace('%', '', $cae); $cae = str_replace(',', '.', $cae);
    $costoTotalSeguro1 = str_replace('$', '', $costoTotalSeguro1); $costoTotalSeguro1 = str_replace('.', '', $costoTotalSeguro1);
    $costoTotalSeguro2 = str_replace('$', '', $costoTotalSeguro2); $costoTotalSeguro2 = str_replace('.', '', $costoTotalSeguro2);
    $vencimientoCuota = $this->input->post("vencimientoCuota")." 00:00:00";

    $nombres = $this->session->userdata('nombres');
    $apellidoPaterno = $this->session->userdata('apellidoPaterno');
    $apellidoMaterno = $this->session->userdata('apellidoMaterno');
    $nroTcv = $this->session->userdata('nroTcv');
    $contrato = $this->session->userdata('contrato');
    $flg_flujo = $this->session->userdata('flg_flujo');

    $domicilio = "-"; $calle = "-"; $numeroCalle = "-"; $block = "-"; $depto = "-"; $poblacion = "-"; $comuna = "-"; $ciudad = "-"; $region = "-";
    $dataDirecciones = json_decode(ws_GET_ConsultaDatosDireccion($nroRut, $contrato, $flg_flujo, $username));

    if($dataDirecciones->retorno==0) {

        foreach ($dataDirecciones->direcciones as $field) {

            if($field->tipoDireccion=="WORK"){

                $calle = $field->calle;
                $numeroCalle = $field->numeroCalle;
                $block = $field->block;
                $depto = $field->depto;
                $poblacion = $field->poblacion;
                $comuna = $field->comuna;
                $ciudad = $field->ciudad;
                $region = $field->region;
                $domicilio = $calle;
                if($numeroCalle!="") { $domicilio .= " Nº ".$numeroCalle; }
                $domicilio .= " ".$poblacion." ".$comuna.", ".$ciudad.", ".$region;

            }
        }

        foreach ($dataDirecciones->direcciones as $field) {

            if($field->tipoDireccion=="HOME"){

                $calle = $field->calle;
                $numeroCalle = $field->numeroCalle;
                $block = $field->block;
                $depto = $field->depto;
                $poblacion = $field->poblacion;
                $comuna = $field->comuna;
                $ciudad = $field->ciudad;
                $region = $field->region;
                $domicilio = $calle;
                if($numeroCalle!="") { $domicilio .= " Nº ".$numeroCalle; }
                $domicilio .= " ".$poblacion." ".$comuna.", ".$ciudad.", ".$region;

            }
        }

    }

    $dataContactos = ws_GET_DatosContactos($nroRut, $contrato, $flg_flujo, $username);
    $phoneMobile = ""; $phoneWork = "";

    if($tipoSolicitud=="C") {

        if($email=="") {
            $email = $this->input->post("emailCuenta");
        }
        $phoneMobile = $this->input->post("telefonoCuenta");

        if($email=="") {

            if($dataContactos["retorno"]==0) {

                if($email=="") {

                    if(isset($dataContactos["emailHome"])) {
                       $email = $dataContactos["emailHome"];
                    }else{
                        if(isset($dataContactos["emailWork"])) {
                           $email = $dataContactos["emailWork"];
                        }
                    }

                }

                if($phoneMobile=="") {

                    if(isset($dataContactos["phoneMobile"])) {
                        $phoneMobile = $dataContactos["phoneMobile"];
                    }
                }

                if(isset($dataContactos["phoneWork"])) {
                    $phoneWork = $dataContactos["phoneWork"];
                }

            }

        }

    }

    if($tipoSolicitud=="S") {
        $fechaCompromisoEnlace = "";
        $offerType = "AP";
    }

    $tasas = $this->get_ConsultaParametrosTasaTC($contrato);
    $interesMoratorio = $tasas["tasaInteresMora"];
    $gastosNotariales = 0;
    $comision = 0;
    if($bank==""){
        $tipoLiquidacion = "E";
        $modoEntrega = "EFE";
    }else{
        $tipoLiquidacion = "T";
        $modoEntrega = "TEF";
    }

    $Request = '<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
        <req:idCuenta>'.$contrato.'</req:idCuenta>
        <req:tipoSolicitud>'.$tipoSolicitud.'</req:tipoSolicitud>
        <req:usuarioSolicitud>'.$this->session->userdata("username").'</req:usuarioSolicitud>
        <req:canal>'.$this->session->userdata("id_channel").'</req:canal>
        <req:montoSolicitado>'.$montoSolicitado.'</req:montoSolicitado>
        <req:costoTotal>'.$costoTotal.'</req:costoTotal>
        <req:valorCuota>'.$valorCuota.'</req:valorCuota>
        <req:vencimientoCuota>'.$vencimientoCuota.'</req:vencimientoCuota>
        <req:numeroCuotas>'.$numeroCuotas.'</req:numeroCuotas>
        <req:mesesDiferido>'.$mesesDiferido.'</req:mesesDiferido>
        <req:tasaInteres>'.$tasaInteres.'</req:tasaInteres>
        <req:cae>'.$cae.'</req:cae>
        <req:comision>'.$comision.'</req:comision>
        <req:impuestos>'.$impuestos.'</req:impuestos>
        <req:gastosNotariales>'.$gastosNotariales.'</req:gastosNotariales>
        <req:codBanco>'.$bank.'</req:codBanco>
        <req:cuentaTipo>'.$typeAccount.'</req:cuentaTipo>
        <req:cuentaNumero>'.$numberAccount.'</req:cuentaNumero>
        <req:interesMoratorio>'.$interesMoratorio.'</req:interesMoratorio>
        <req:estadoEnlace>'.$estadoEnlace.'</req:estadoEnlace>
        <req:sucursalOrigen>'.$sucursalOrigen.'</req:sucursalOrigen>
        <req:sucursalDestino>'.$sucursalDestino.'</req:sucursalDestino>
        <req:nombres>'.$nombres.'</req:nombres>
        <req:apellidoPaterno>'.$apellidoPaterno.'</req:apellidoPaterno>
        <req:apellidoMaterno>'.$apellidoMaterno.'</req:apellidoMaterno>
        <req:nroRut>'.$numeroRut.'</req:nroRut>
        <req:nroRutDV>'.$dgvRut.'</req:nroRutDV>
        <req:diasVigenciaCotizacion>'.DIAS_VIGENCIA_COTIZACIONES.'</req:diasVigenciaCotizacion>
        <req:montoBruto>'.$montoBruto.'</req:montoBruto>
        <req:pan>'.$nroTcv.'</req:pan>
        <req:domicilio>'.$domicilio.'</req:domicilio>
        <req:email>'.$email.'</req:email>';

        if((int)$costoTotalSeguro1>0){

            if($this->input->post("codSeguro1")===NULL) {
                cancel_function(COD_ERROR_INIT, "Atención, Código Hospitalización no es valido!", "");
            }
            $codSecure = (string)$this->input->post("codSeguro1");

            if($this->input->post("idPolizaSeguro1")===NULL) {
              cancel_function(COD_ERROR_INIT, "Atención, Poliza Hospitalización no es valido!", "");
            }
            $polSecure = (string)$this->input->post("idPolizaSeguro1");

            $Request.='
        <req:codSeguro1>'.$codSecure.'</req:codSeguro1>
        <req:costoTotalSeguro1>'.$costoTotalSeguro1.'</req:costoTotalSeguro1>
        <req:idPolizaSeguro1>'.$polSecure.'</req:idPolizaSeguro1>';

        }else{

        $Request.='
        <req:codSeguro1/>
        <req:costoTotalSeguro1/>
        <req:idPolizaSeguro1/>';
        }

        if((int)$costoTotalSeguro2>0){

            if($this->input->post("codSeguro2")===NULL) {
            cancel_function(COD_ERROR_INIT, "Atención, Código Seguro Vida y Desgravamen no es valido!", "");
            }
            $codSecure = (string)$this->input->post("codSeguro2");

            if($this->input->post("idPolizaSeguro2")===NULL) {
            cancel_function(COD_ERROR_INIT, "Atención, Poliza Seguro Vida y Desgravamen no es valido!", "");
            }
            $polSecure = (string)$this->input->post("idPolizaSeguro2");

            $Request.='
        <req:codSeguro2>'.$codSecure.'</req:codSeguro2>
        <req:costoTotalSeguro2>'.$costoTotalSeguro2.'</req:costoTotalSeguro2>
        <req:idPolizaSeguro2>'.$polSecure.'</req:idPolizaSeguro2>';

        }else{

            $Request.='
        <req:codSeguro2/>
        <req:costoTotalSeguro2/>
        <req:idPolizaSeguro2/>';
       }

        $Request.='
        <req:codSeguro3/>
        <req:costoTotalSeguro3/>
        <req:idPolizaSeguro3/>
        <req:codSeguro4/>
        <req:costoTotalSeguro4/>
        <req:idPolizaSeguro4/>
        <req:codSeguro5/>
        <req:costoTotalSeguro5/>
        <req:idPolizaSeguro5/>
        <req:fechaCompromisoEnl>'.$fechaCompromisoEnlace.'</req:fechaCompromisoEnl>
        <req:tipoOferta>'.$offerType.'</req:tipoOferta>
        <req:region>'.$region.'</req:region>
        <req:ciudad>'.$ciudad.'</req:ciudad>
        <req:comuna>'.$comuna.'</req:comuna>
        <req:poblacion>'.$poblacion.'</req:poblacion>
        <req:numDepto>'.$depto.'</req:numDepto>
        <req:block>'.$block.'</req:block>
        <req:numCalle>'.$numeroCalle.'</req:numCalle>
        <req:calle>'.$calle.'</req:calle>
        <req:fonoFijo>'.$phoneWork.'</req:fonoFijo>
        <req:fonoMovil>'.$phoneMobile.'</req:fonoMovil>
        <req:modalidadVenta>'.$this->session->userdata('attention_mode').'</req:modalidadVenta>
        <req:tipoLiquidacion>'.$tipoLiquidacion.'</req:tipoLiquidacion>
        <req:modoEntrega>'.$modoEntrega.'</req:modoEntrega>
        <req:codLocal>'.$account_transfer.'</req:codLocal>
        <req:gastosCobranzas1>9.00</req:gastosCobranzas1>
        <req:gastosCobranzas2>6.00</req:gastosCobranzas2>
        <req:gastosCobranzas3>3.00</req:gastosCobranzas3>
        <req:cargoPrepago>1 mes de interés calculado sobre capital de prepago</req:cargoPrepago>
        <req:plazoAvisoPrepago>No aplica</req:plazoAvisoPrepago>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_CreaSimuCotiSavTC;
    $soap = get_SOAP($EndPoint, WS_Action_CreaSimuCotiSavTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_CreaSimuCotiSavTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      echo json_encode($data);
      exit(0);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno; $value["retornoBeneficiarios"] = 0; $value["descBeneficarios"] = "";

    if ($retorno==0){
        $idDocument = (int)$xml->Body->DATA->idSolicitud;
        $this->session->set_userdata("idDocument", $idDocument);
        $this->session->set_userdata("nameClient", $nombres." ".$apellidoPaterno." ".$apellidoMaterno);
        $this->session->set_userdata("flag_document", true);

        if((int)$costoTotalSeguro1>0 AND $tipoSolicitud=="C") {

            $codSecure = (string)$this->input->post("codSeguro1");
            $typeDocument = "DES";
            $useEmail = (string)$this->input->post("useEmail1");
            $declareDps = (string)$this->input->post("declareDps");
            $typeBeneficiaries = "";
            $result = $this->documents->add_journalSecure($idDocument, $typeDocument, $codSecure, $declareDps, $useEmail, $typeBeneficiaries );
        }

        if((int)$costoTotalSeguro2>0 AND $tipoSolicitud=="C") {

            $codSecure = (string)$this->input->post("codSeguro2");
            $typeDocument = "PRO";
            $useEmail = (string)$this->input->post("useEmail2");
            $typeBeneficiaries = (string)$this->input->post("typeBeneficiaries");
            $declareDps = 0;
            $result = $this->documents->add_journalSecure($idDocument, $typeDocument, $codSecure, $declareDps, $useEmail, $typeBeneficiaries );

            if($typeBeneficiaries=="other") {
                $listaBeneficiarios = $this->input->post("listaBeneficiarios");
                $result = $this->add_beneficiarios($idDocument, $codSecure, $listaBeneficiarios);
                $value["retornoBeneficiarios"] = $result["retorno"];
                $value["descBeneficarios"] = $result["descRetorno"];
            }
       }

       if(isset($_FILES['fileCI']['tmp_name'])){
         $filenameCI = $_FILES['fileCI']['tmp_name'];
       }else{
         $filenameCI = "";
       }
       if($filenameCI != ""){
                       $filenamepath = $_FILES['fileCI']['tmp_name'];
                       $filenametype = $_FILES['fileCI']['type'];
                       $fp = fopen($filenamepath, 'r+b');
                       $filedata = fread($fp, filesize($filenamepath));
                       fclose($fp);
                       $filedata = mysqli_real_escape_string($this->get_mysqli(),$filedata);

            $this->db->query("INSERT INTO ta_documents_images (number_rut_client,digit_rut_client,type_image,name_image,imagen,idDocument) VALUES ('".$numeroRut."','".$dgvRut."','".$filenametype."','".$filenamepath."','".$filedata."','".$idDocument."');");

       }

    }else{
        $idDocument = 0;
    }

    $value['retorno'] = $retorno;
    $value['idDocument'] = $idDocument;
    $value['descRetorno'] = $descRetorno;
    $data = $value;

    echo json_encode($data);
}

private function print_eventlog($data) {

$fp = fopen(SHOW_NAME_LOGFILE.date('Y-m-d').'.log', 'a');
$data = ">>>>>> " . $data ." <<<<<<<" . PHP_EOL;
fwrite($fp, $data);
fclose($fp);

}

private function get_beneficiarios($idDocument, $codSecure) {

    $retorno = COD_ERROR_INIT; $descRetorno = ""; $username = $this->session->userdata("username");
    $Request = '<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
        <req:codigoSeguro>'.$codSecure.'</req:codigoSeguro>
        <req:idSolicitud>'.$idDocument.'</req:idSolicitud>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ListarBeneficiarios;
    $soap = get_SOAP($EndPoint, WS_Action_ListarBeneficiarios, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ListarBeneficiarios);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return $data;
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0) {

      $value["apellidoMaterno1"] = "";
      $value["apellidoPaterno1"] = "";
      $value["nombres1"] = "";
      $value["parentesco1"] = "";
      $value["dv1"] = "";
      $value["rut1"] = "";
      $value["contacto1"] = "";
      $value["porcDistribucion1"] = "";
      $value["apellidoMaterno2"] = "";
      $value["apellidoPaterno2"] = "";
      $value["nombres2"] = "";
      $value["parentesco2"] = "";
      $value["dv2"] = "";
      $value["rut2"] = "";
      $value["contacto2"] = "";
      $value["porcDistribucion2"] = "";
      $value["apellidoMaterno3"] = "";
      $value["apellidoPaterno3"] = "";
      $value["nombres3"] = "";
      $value["parentesco3"] = "";
      $value["dv3"] = "";
      $value["rut3"] = "";
      $value["contacto3"] = "";
      $value["porcDistribucion3"] = "";
      $value["apellidoMaterno4"] = "";
      $value["apellidoPaterno4"] = "";
      $value["nombres4"] = "";
      $value["parentesco4"] = "";
      $value["dv4"] = "";
      $value["rut4"] = "";
      $value["contacto4"] = "";
      $value["porcDistribucion4"] = "";

      $ind = 1;

      foreach ($xml->Body->DATA->response->listaBeneficiario as $field) {

          if($ind==1) {
              $value["apellidoMaterno1"] = (string)$field->apellidoMaterno;
              $value["apellidoPaterno1"] = (string)$field->apellidoPaterno;
              $value["nombres1"] = (string)$field->nombres;
              $value["parentesco1"] = (string)$field->parentesco;
              $value["dv1"] = (string)$field->dv;
              $value["rut1"] = (string)$field->rut;
              $value["contacto1"] = (string)$field->contacto;
              $value["porcDistribucion1"] = (string)$field->porcDistribucion;
          }

          if($ind==2) {
              $value["apellidoMaterno2"] = (string)$field->apellidoMaterno;
              $value["apellidoPaterno2"] = (string)$field->apellidoPaterno;
              $value["nombres2"] = (string)$field->nombres;
              $value["parentesco2"] = (string)$field->parentesco;
              $value["dv2"] = (string)$field->dv;
              $value["rut2"] = (string)$field->rut;
              $value["contacto2"] = (string)$field->contacto;
              $value["porcDistribucion2"] = (string)$field->porcDistribucion;
          }

          if($ind==3) {
              $value["apellidoMaterno3"] = (string)$field->apellidoMaterno;
              $value["apellidoPaterno3"] = (string)$field->apellidoPaterno;
              $value["nombres3"] = (string)$field->nombres;
              $value["parentesco3"] = (string)$field->parentesco;
              $value["dv3"] = (string)$field->dv;
              $value["rut3"] = (string)$field->rut;
              $value["contacto3"] = (string)$field->contacto;
              $value["porcDistribucion3"] = (string)$field->porcDistribucion;
          }

          if($ind==4) {
              $value["apellidoMaterno4"] = (string)$field->apellidoMaterno;
              $value["apellidoPaterno4"] = (string)$field->apellidoPaterno;
              $value["nombres4"] = (string)$field->nombres;
              $value["parentesco4"] = (string)$field->parentesco;
              $value["dv4"] = (string)$field->dv;
              $value["rut4"] = (string)$field->rut;
              $value["contacto4"] = (string)$field->contacto;
              $value["porcDistribucion4"] = (string)$field->porcDistribucion;
          }

          $ind = $ind + 1;

      }

    }
    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $data = $value;

    return ($data);
}

private function add_beneficiarios($idDocument, $codSecure, $listaBeneficiarios) {

    $listaBeneficiarios = str_replace('&lt;', '<', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@LB', 'req:listaBeneficiario', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@AM', 'req:apellidoMaterno', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@AP', 'req:apellidoPaterno', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@CT', 'req:contacto', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@DV', 'req:dv', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@ID', 'req:id', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@NOM', 'req:nombres', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@PAR', 'req:parentesco', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@POR', 'req:porcDistribucion', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@RUT', 'req:rut', $listaBeneficiarios);
    $listaBeneficiarios = str_replace('@TC', 'req:tipoContacto', $listaBeneficiarios);

    $username = $this->session->userdata("username");
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    	<soap:Header xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    	</soap:Header>
    	<soapenv:Body>
    	<req:DATA xmlns:req="http://www.solventa.cl/request">
        <req:codigoSeguro>'.$codSecure.'</req:codigoSeguro>
        <req:idSolicitud>'.$idDocument.'</req:idSolicitud>'
        .$listaBeneficiarios.'
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_GrabarBeneficiarios;
    $soap = get_SOAP($EndPoint, WS_Action_GrabarBeneficiarios, WS_Timeout90, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "response", "serviceName" => WS_GrabarBeneficiarios);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return $data;
    }
    $xml = $eval["xmlDocument"];

    $data["retorno"] = (int)$xml->Body->DATA->response->codSalida;
    $data["descRetorno"] = (string)$xml->Body->DATA->response->descSalida;

    return ($data);
}

public function generaPDF() {

  if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
  if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }

$this->data["id"] = $this->input->post("id");
$type = $this->input->post("type");
$fecha = date('d-m-Y');
$saveLocal = true;

if($type=="CRC") {
    $this->data["id"] = mt_rand(1,999999999);
}

if($this->documents->get_documentsExists($this->data["id"], $type)) {
    $value['retorno'] = 100;
    $value['descRetorno'] = "Documento ya fue Generado, consulte imprimir documentos";
    $data = $value;
    echo json_encode($data);
    exit(0);
}

switch ($type) {

    case "CON":
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->get_simulateById($this->data["id"],"C","array");
    break;
    case "PRO":
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->get_simulateById($this->data["id"],"C","array");
    break;
    case "DES":
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->get_simulateById($this->data["id"],"C","array");
    break;

    case "CRC":
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
    break;

    case "AUT":
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
    break;

    default:
    break;
}

switch ($type) {
    case "SIM":

        $this->data['datos'] = $this->get_simulateById($this->data["id"],"S","array");

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetAutoPageBreak(true,20);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $html =  $this->load->view('pdf/templateSimulacion',$this->data,true);

    break;

    case "COT":

        $this->data['datos'] = $this->get_simulateById($this->data["id"],"C","array");

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAutoPageBreak(true,70);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');
        $this->data['datos'] = $this->get_simulateById($this->data["id"],"C","array");
        $html =  $this->load->view('pdf/templateHojaResumen',$this->data,true);
    break;

    case "CON":
        $pdf->SetTitle('Contrato S&#250;per Avance');
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $this->data['datos'] = $this->get_simulateById($this->data["id"],"C","array");
        $html =  $this->load->view('pdf/templateContrato',$this->data,true);
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

    case "CRC":
        $this->data["reasonDeny"] = $this->rechazo->getall_motivo($this->input->post("reasonDeny"));
        $nroRut = $this->input->post("nroRut"); $nroRut = substr($nroRut, 0, -1);

        $this->data["datos"] = array(
            "nameClient" => $this->input->post("nameClient"),
            "nroRut" => $this->input->post("nroRut")
            );

        $pdf->SetTitle('Carta de rechazo');
        $pdf->SetHeaderMargin(20);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html =  $this->load->view('pdf/templateCartaRechazo',$this->data,true);
        $this->data["datos"]["nroRut"] = $nroRut;

    break;

    case "AUT":

        $pdf->SetTitle('Print Autorización');
        $pdf->SetHeaderMargin(20);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = $this->input->post("html");

    break;


    default:
    break;
}

$pdf->writeHTML($html, true, false, true, false, '');

switch ($type) {
    case "SIM":
    $pdf->Output("/tmp/".'simulacion.pdf', 'F');
    $value['descRetorno'] = "Simulación creada con Éxito..";
    $filename = "/tmp/".'simulacion.pdf';
    $filedesc = "SIMULACION COTIZACION";
    break;

    case "COT":
    $pdf->Output("/tmp/".'resumen.pdf', 'F');
    $value['descRetorno'] = "Resumen creado con Éxito..";
    $filename = "/tmp/".'resumen.pdf';
    $filedesc = "HOJA RESUMEN";
    break;

    case "CON":
    $pdf->Output("/tmp/".'contrato.pdf', 'F');
    $value['descRetorno'] = "Contrato creado con Éxito..";
    $filename = "/tmp/".'contrato.pdf';
    $filedesc = "CONTRATO SÚPER AVANCE";
    break;

    case "PRO":
        $pdf->Output("/tmp/".'proteccion.pdf', 'F');
        $value['descRetorno'] = "Solicitud de incorporacion creado con Éxito..";
    $filename = "/tmp/".'proteccion.pdf';
    $filedesc = "PROPUESTA SEGURO VIDA";
    break;
    case "DES":
        $pdf->Output("/tmp/".'desgravamen.pdf', 'F');
        $value['descRetorno'] = "Solicitud de SEGURO DE VIDA Y DESGRAVAMEN creado con Éxito..";
    $filename = "/tmp/".'desgravamen.pdf';
    $filedesc = "PROPUESTA SEGURO DESGRAVAMEN";
    break;

    case "CRC":
        $pdf->Output("/tmp/".'rechazo.pdf', 'F');
        $value['descRetorno'] = "Carta Rechazo creada ..";
        $filename = "/tmp/".'rechazo.pdf';
        $filedesc = "CARTA RECHAZO";
    break;

    case "AUT":
        $pdf->Output("/tmp/".'autoriza.pdf', 'F');
        $value['descRetorno'] = "Print Autorización Cliente ..";
        $saveLocal = false;
    break;

    default:
    break;
}


$value["tipoEstado"] = ""; $value["glosaEstado"] = ""; $value["fechaEstado"] = "";

if($saveLocal) {

    $fp = fopen($filename, 'r+b');
          $data = fread($fp, filesize($filename));
          fclose($fp);

    $nroRut = $this->data['datos']['nroRut'];
    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut);
    $r = new Rut();
    $r->number($nroRut);
    $dgvRut = $r->calculateVerificationNumber();

    $data = mysqli_real_escape_string($this->get_mysqli(),$data);
    $fecha = date("Y-m-d H:i:s");

    $nameUser = $this->session->userdata("username");
    $office = $this->session->userdata("id_office");
    $id_user = $this->session->userdata("id");
    $sqlcall = $this->db->query("INSERT INTO ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,digit_rut_client,name_client,idDocument,typeDocument,id_user_last_print, id_office_last_print) VALUES ('".$fecha."',".$id_user.",'".$office."',2,'".$filedesc."','".$data."',". $nroRut.",'".$dgvRut."','".$this->data['datos']['nameClient']."','".$this->data["id"]."','".$type."','".$nameUser."','".$office."');");

    switch ($type) {
        case "SIM":

            $result = $this->actualizaEstadoSAV($this->data["id"], "I");
            if($result["retorno"]==0) {

                $value["tipoEstado"] = "I";
                $value["glosaEstado"] = "SIMULACION IMPRESA";
                $value["fechaEstado"] = $result["timestamp"];
            }

        break;

        case "COT":

            $result = $this->actualizaEstadoSAV($this->data["id"], "I");
            if($result["retorno"]==0) {

                $value["tipoEstado"] = "I";
                $value["glosaEstado"] = "COTIZACION IMPRESA";
                $value["fechaEstado"] = $result["timestamp"];
            }

        break;


        default:
        break;
    }

}
$this->session->set_userdata("typeDocument", $type);
$this->print_eventlog("End.pdf-> Documento Nº ".$this->data["id"]." Tipo:".$type);

$value['retorno'] = 0;
$data = $value;
echo json_encode($data);

}


    function get_mysqli() { $db = (array)get_instance()->db;
        return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}


public function get_IMAGE($id){
    if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
    if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }

    $result = $this->documents->get_DocumentsImagesById($id);

    if($result!=false){

        $type =  $result->type_image;
        $imagen =  $result->imagen;

        $this->output
            ->set_content_type($type)
            ->set_output($imagen);

    }


}

public function get_PDF($idDocument, $typeDocument) {
    if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
    if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }

    $result = $this->documents->get_documentsById($idDocument, $typeDocument);
    if($result!=false){

        $typePDF = "application/pdf";
        $image = $result->image;
        $this->output
            ->set_content_type($typePDF)
            ->set_output($image);

    }

}


public function readPDF(){
    if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
    if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }

$type = $this->session->userdata("typeDocument");

switch ($type) {
    case 'SIM':
        $input = "/tmp/".'simulacion.pdf'; //temporary name that PHP gave to the uploaded file
    break;
    case 'COT':
        $input = "/tmp/".'resumen.pdf'; //temporary name that PHP gave to the uploaded file
    break;
    case 'CON':
        $input = "/tmp/".'contrato.pdf'; //temporary name that PHP gave to the uploaded file
    break;
    case 'PRO':
        $input = "/tmp/".'proteccion.pdf'; //temporary name that PHP gave to the uploaded file
    break;
    case 'DES':
        $input = "/tmp/".'desgravamen.pdf'; //temporary name that PHP gave to the uploaded file
    break;
    case 'CRC':
        $input = "/tmp/".'rechazo.pdf'; //temporary name that PHP gave to the uploaded file
    break;
    case 'AUT':
        $input = "/tmp/".'autoriza.pdf'; //temporary name that PHP gave to the uploaded file
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

private function get_ConsultaParametrosTasaTC($contrato){
    $data = array(); $retorno = COD_ERROR_INIT; $username=$this->session->userdata("username");
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:idCuenta>'.$contrato.'</req:idCuenta>
          <req:comercio>27</req:comercio>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaParametrosTasaTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaParametrosTasaTC, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "cabeceraSalida", WS_ConsultaParametrosTasaTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->return->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->return->cabeceraSalida->descRetorno;

    if($retorno==0) {
        $data = array('tasaAvanceMayor90' => (float)$xml->Body->DATA->response->return->tasaAvanceMayor90,'tasaAvanceMenor90' => (float)$xml->Body->DATA->response->return->tasaAvanceMenor90,'tasaCompraMayor90' => (float)$xml->Body->DATA->response->return->tasaCompraMayor90,'tasaCompraMenor90' => (float)$xml->Body->DATA->response->return->tasaCompraMenor90,'tasaInteresMora' => (float)$xml->Body->DATA->response->return->tasaInteresMora,'impuestos' => (float)$xml->Body->DATA->response->return->impuestos,'mantencionMensual' => (float)$xml->Body->DATA->response->return->mantencionMensual);
    }else{
        $data = array('tasaAvanceMayor90' => '0.00','tasaAvanceMenor90' => '0.00', 'tasaCompraMayor90' => '0.00', 'tasaCompraMenor90' => '0.00', 'tasaInteresMora' => '0.00', 'impuestos' => '0.00', 'mantencionMensual' => '0.00');
    }

    put_logevent($soap, SOAP_OK);
    return($data);
}

private function eval_xml_response($xmlString, $tagName, $serviceName) {

    $eval = strpos($xmlString, "faultstring");

    if($eval > 0){
        $ini = strpos($xmlString, "<faultstring>");
        $fin = strpos($xmlString, "</faultstring>");
        $descRetorno = substr($xmlString, $ini, $fin - $ini);
        cancel_function(401,"<b>".$descRetorno."</b><br><strong>Sin Respuesta desde el CORE</strong><br><strong>Servicio ".$serviceName."</strong>","");
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

private function validaDatosCuenta($nroRut, $flg_flujo){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $retorno = COD_ERROR_INIT; $username = $this->session->userdata("username");
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
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosCuenta, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosCuenta);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $soap["codErrorSOAP"];
        $data["descRetorno"] = $soap["msgErrorSOAP"];
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->retorno;
    $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno==0){

      if((int)$xml->Body->DATA->Registro->suscripcionEeccXMail==1){
          $value["tipoDespacho"] = "EMAIL";
          $value["glosaDespacho"] = "Su correo electr&#243;nico de envío de su estado de cuenta es ";
      }else{
          $value["tipoDespacho"] = "TRADICIONAL";
          $value["glosaDespacho"] = "Su direcci&#243;n de envío de su estado de cuenta es ";
      }

      $value["retorno"] = $retorno;
      $value["descRetorno"] = $descRetorno;
      $value["contrato"] = $xml->Body->DATA->Registro->contrato;
      $value["fechaCreacion"] = $xml->Body->DATA->Registro->fechaCreacion;
      $value["fechaActivacion"] = $xml->Body->DATA->Registro->fechaActivacion;
      $value["suscripcionEeccXMail"] = $xml->Body->DATA->Registro->suscripcionEeccXMail;

    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $data = $value;
    return ($data);
}

private function actualizaGlosaSAV($id, $glosaRechazo, $tipoRechazo) {

    $rechazoLiq = ""; $rechazoAut = ""; $username = $this->session->userdata("username");
    if($tipoRechazo=="valid") { $rechazoLiq = $glosaRechazo; }
    else { $rechazoAut = $glosaRechazo; }

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:idSolicitud>'.$id.'</req:idSolicitud>
         <req:rechazoLiq>'.$rechazoLiq.'</req:rechazoLiq>
         <req:rechazoAut>'.$rechazoAut.'</req:rechazoAut>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaRechazoTC;
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaRechazoTC, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "descRetorno", WS_ActualizaRechazoTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    $data = $value;

    put_logevent($soap, SOAP_OK);
    return ($data);
}

private function actualizaEstadoSAV($id, $estado) {

    $timestamp = date("d-m-Y H:i:s"); $username = $this->session->userdata("username");
    $usuarioAutoriza = ""; $usuarioLiquida = ""; $usuarioAceptacion = ""; $fechaAutoriza = ""; $fechaLiquida = "";$fechaAceptacion = "";

    if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL) {

        switch ($estado) {
            case 'PA':
                $usuarioAceptacion = $username;
                $fechaAceptacion = $timestamp;
            break;
            case 'PE':
                $usuarioAceptacion = $username;
                $fechaAceptacion = $timestamp;
            break;

        }
    }

    if($this->session->userdata("id_rol")==USER_ROL_JEFE_DE_OFICINA) {

        switch ($estado) {
            case 'AU':
                $usuarioAutoriza = $username;
                $fechaAutoriza = $timestamp;
            break;
            case 'PE':
                $usuarioAutoriza = $username;
                $fechaAutoriza = $timestamp;
            break;
            case 'C':
                $usuarioLiquida = $username;
                $fechaLiquida = $timestamp;
            break;
            case 'L':
                $usuarioLiquida = $username;
                $fechaLiquida = $timestamp;
            break;
            case 'RO':
                $usuarioLiquida = $username;
                $fechaLiquida = $timestamp;
            break;
        }
    }

    if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING) {

        switch ($estado) {
            case 'CO':
                $usuarioAceptacion = $username;
                $fechaAceptacion = $timestamp;
            break;
            case 'AU':
                $usuarioAutoriza = $username;
                $usuarioAceptacion = $username;
                $fechaAutoriza = $timestamp;
                $fechaAceptacion = $timestamp;
            break;
            case 'PE':
                $usuarioAutoriza = $username;
                $fechaAutoriza = $timestamp;
            break;
            case 'L':
                $usuarioLiquida = $username;
                $fechaLiquida = $timestamp;
            break;
            case 'RR':
                $usuarioLiquida = $username;
            $fechaLiquida = $timestamp;
            break;
        }
    }

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$id.'</req:numeroDeDocumento>
         <req:tipoTrx>'.CODIGO_SUPER_AVANCE.'</req:tipoTrx>
         <req:estado>'.$estado.'</req:estado>
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
    $soap = get_SOAP($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "descRetorno", WS_ActEstadoSavYRefTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    $value["timestamp"] = $timestamp;
    $data = $value;

    put_logevent($soap, SOAP_OK);
    return ($data);
}


/**********************

 Utils Funciones Transferencia Electrónica de Fondos

***********************/


public function put_Transferencia() {

    $return = check_session("");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'required');
    $this->form_validation->set_rules('idDocument', 'N&#250;mero Documento', 'required');
    $this->form_validation->set_rules('emailCuenta', 'Correo Electrónico', 'required');
    $this->form_validation->set_rules('nombreCliente', 'Nombre Cliente', 'required');
    $this->form_validation->set_rules('telefonoCuenta', 'Teléfono Cliente', 'required');
    $this->form_validation->set_rules('montoLiquido', 'Monto Líquido', 'required');
    $this->form_validation->set_rules('plazoDeCuota', 'Plazo', 'required');
    $this->form_validation->set_rules('numeroCuenta', 'N&#250;mero Cuenta', 'required');
    $this->form_validation->set_rules('tipoCuenta', 'Tipo Cuenta', 'required');
    $this->form_validation->set_rules('codigoBanco', 'Código Banco', 'required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        $data["htmlTags"] = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">'.validation_errors().'</td>';
        echo json_encode($data);
        exit (0);
    }

    $idDocument = $this->input->post("idDocument");
    $emailCuenta = $this->input->post("emailCuenta");
    $nombreCliente = $this->input->post("nombreCliente");
    $telefonoCuenta = $this->input->post("telefonoCuenta");
    $montoLiquido = $this->input->post("montoLiquido");
    $nroRut = $this->input->post("nroRut");
    $plazoDeCuota = $this->input->post("plazoDeCuota");

    $numeroCuenta = $this->input->post("numeroCuenta");
    $tipoCuenta = $this->input->post("tipoCuenta");
    $codigoBanco = $this->input->post("codigoBanco");

    $result = $this->glossary->get_BancosById($codigoBanco);
    if($result!=false) { $descBanco = $result->NAME; } else { $descBanco = "-"; }

    $result = $this->glossary->get_tipoCuentasById($tipoCuenta);
    if($result!=false) { $descCuenta = $result->NAME; } else { $descCuenta = "-"; }

    $fechaActual = date("d-m-Y"); $horaActual = date("H:i"); $mesesDiferidos = 0;
    $eval = $this->ws_getCotizacionById($idDocument);

    if($eval["retorno"]==0) {

        $mesesDiferidos = $eval["mesesDiferidos"];
        if($eval["estado"]=="L") {

          $data["htmlTags"] = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">SAV esta Liquidada..</td>';
          echo json_encode($data);
          exit (0);
        }

        $account_office = $eval["codLocal"]; $account_pos = "";
        $result = $this->parameters->get_officeById($account_office);
        if($result!=false){ $account_pos = $result->account_pos; }

        if($account_pos=="") {

            $data["htmlTags"] = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">Sucursal sin cuenta contable..</td>';
            echo json_encode($data);
            exit (0);
        }

    } else {

        $data["htmlTags"] = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">No fue posible validar Estado SAV</td>';
        echo json_encode($data);
        exit (0);
    }

    if($eval["banco"]!=$codigoBanco OR $eval["tipoCuenta"]!=$tipoCuenta OR $eval["numeroCuenta"]!=$numeroCuenta)
        { $flg_change_transfer = true; } else { $flg_change_transfer = false; }

    $rutTitular = $nroRut; $field_rut = $nroRut;
    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut);
    $rutTitular = str_replace('.', '', $rutTitular);

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
        <tran:Email>'.strtolower($emailCuenta).'</tran:Email>
        <tran:VissAvanceParams>
            <tran:CodigoAutorizador>1</tran:CodigoAutorizador>
            <tran:HeaderTrx>1</tran:HeaderTrx>
            <tran:NumeroTarjeta>'.$eval["pan"].'</tran:NumeroTarjeta>
            <tran:Pos>'.$account_pos.'</tran:Pos>
            <tran:Sucursal>'.$account_office.'</tran:Sucursal>
            <tran:Terminal>1</tran:Terminal>
            <tran:TipoLectura>3</tran:TipoLectura>
            <tran:Usuario>27107</tran:Usuario>
            <tran:NumeroCuotas>'.$plazoDeCuota.'</tran:NumeroCuotas>
            <tran:MesGracia>'.$mesesDiferidos.'</tran:MesGracia>
         </tran:VissAvanceParams>
    </tran:TransferenciaSAVRequest>
    </soapenv:Body>
    </soapenv:Envelope>';

/** Begin::CC028:: **/ 
    $param = $this->parameters->get_generalParameters();
    if(!$param){
        $data["htmlTags"] = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">Error, al intentar leer configuración general del sistema</br>' . ATENTION_HELPDESK . '</td>';
        echo json_encode($data);
        exit (0);
    }
    $dataInput = array(
        "username" => $username,
        "request" => $Request,
        "date_request" => date("Ymd"),
        "rut_client" => $rutTitular,
    );
    $result = $this->parameters->get_parameters_log_transfer($dataInput);
    if($result->count_transfer==$param->number_max_transfer_by_day){
        $data["htmlTags"] = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">Intentos de transferencia, excede máximo de ' . $param->number_max_transfer_by_day . ' intentos diarios.</td>';
        echo json_encode($data);
        exit (0);
    }
    $result = $this->parameters->put_parameters_log_transfer($dataInput);
/** End::CC028:: **/ 

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_PS_Transferencia_SAV;
    $soap = get_SOAP($EndPoint, WS_Action_PS_Transferencia_SAV, WS_Timeout90, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "TransferenciaSAVResponse", "serviceName" => WS_PS_Transferencia_SAV);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $value["htmlTags"] = '<tr><td class="text-center">Transferencia</td><td class="text-center">Rechazada ..</td><td class="text-center">'.$eval["descRetorno"].'</td>';
      $data = $value;
      echo json_encode($data);
      exit (0);
    }
    $xml = $eval["xmlDocument"];

    $value["codigoRetorno"] = (int)$xml->Body->TransferenciaSAVResponse->Estado->Codigo;
    $value["glosaRetorno"] = (string)$xml->Body->TransferenciaSAVResponse->Estado->Glosa;
    $value["estadoTEF"] = (int)$xml->Body->TransferenciaSAVResponse->EstadoTef;
    $value["numeroTEF"] = (int)$xml->Body->TransferenciaSAVResponse->NumOperProg;
    $value["fechaContable"] = (string)$xml->Body->TransferenciaSAVResponse->FechaContable;
    $value["FechaInstruccion"] = (string)$xml->Body->TransferenciaSAVResponse->FechaInstruccion;

    if($value["codigoRetorno"]==0 AND $value["estadoTEF"]==1) {

        $estadoTEF = "accept";
        $htmlTags = '<tr><td class="text-center">Transferencia</td><td class="text-center">Terminado ..</td><td class="text-center">Transferencia Cursada con éxito</td>';

        $eval = $this->ws_SAV_update_EstadoTransferencia($idDocument, "A");

        $htmlTags.= '<tr><td class="text-center">Actualiza Aprobación Transferencia</td><td class="text-center">Terminado ..</td><td class="text-center">';
        $htmlTags.= ($eval["retorno"]==0 ? 'Transacción Aceptada</td>' : 'Transacción Rechazada</td>');

        $messageSms = $nombreCliente.", Tarjeta Cruz Verde informa que hoy ".$fechaActual." a las ".$horaActual." realizo transferencia de Super Avance por $".number_format((float)$montoLiquido,0, ',', '.')." a Banco ".$descBanco;

        $field_estado = "L"; // Asigna estado L <= Liquidado
        $eval = $this->ws_SAV_update_Estado($idDocument, $field_estado);

        $htmlTags.= '<tr><td class="text-center">Liquidación SAV</td><td class="text-center">Terminado ..</td><td class="text-center">';
        $htmlTags.= ($eval["retorno"]==0 ? 'Liquidación con éxito</td>' : 'Liquidación con Error</td>');

        $eval = $this->ws_SAV_update_Ofert($field_rut);

        $htmlTags.= '<tr><td class="text-center">Actualizar Estado Oferta</td><td class="text-center">Terminado ..</td><td class="text-center">';
        $htmlTags.= ($eval["retorno"]==0 ? 'Transacción Aceptada</td>' : 'Transacción Rechazada</td>');

        if($flg_change_transfer) {

            $eval = $this->ws_SAV_update_Transfer($idDocument, $codigoBanco, $tipoCuenta, $numeroCuenta);

            $htmlTags.= '<tr><td class="text-center">Actualizar Datos Banco</td><td class="text-center">Terminado ..</td><td class="text-center">';
            $htmlTags.= ($eval["retorno"]==0 ? 'Transacción Aceptada</td>' : 'Transacción Rechazada</td>');

            $result = $this->ws_SAV_update_Contract($idDocument, $field_rut);

            $htmlTags.= '<tr><td class="text-center">Actualizar Documento Contrato</td><td class="text-center">Terminado ..</td><td class="text-center">';
            $htmlTags.= ($result==TRUE ? 'Transacción Aceptada</td>' : 'Transacción Rechazada</td>');
        }

    } else {

        $estadoTEF = "deny";
        $htmlTags = '<tr><td class="text-center">Transferencia</td><td class="text-center">Terminado ..</td><td class="text-center">Transferencia Fallida</td>';

        $eval = $this->ws_SAV_update_EstadoTransferencia($idDocument, "R");

        $htmlTags.= '<tr><td class="text-center">Actualiza Rechazo Transferencia</td><td class="text-center">Terminado ..</td><td class="text-center">';
        $htmlTags.= ($eval["retorno"]==0 ? 'Transacción Aceptada</td>' : 'Transacción Rechazada</td>');
        $messageSms = $nombreCliente.", Tarjeta Cruz Verde informa que abono de Super Avance por $".number_format((float)$montoLiquido,0, ',', '.')." ha sido rechazada";
    }

    /*Begin Consulta Resultado Transferencia*/
    $dataInput = array(
        "nroRut" => $field_rut,
        "username" => $this->session->userdata("username")
    );
    $eval = ws_GET_ConsultaEstadoTransferenciaSAV($dataInput);

    $htmlTags.= '<tr><td class="text-center">Estado Transferencia</td><td class="text-center">Terminado ..</td><td class="text-center">';
    $htmlTags.= ($eval["retorno"]==0 ? $eval["glosa"].'</td>' : $eval["glosa"].'</td>');
    /*End Consulta Resultado Transferencia*/

    $eval = $this->sendSmsTEF($telefonoCuenta, $messageSms);
    $htmlTags.= '<tr><td class="text-center">Envio SMS</td><td class="text-center">Terminado ..</td><td class="text-center">';
    $htmlTags.= ($eval["retorno"]==0 ? 'Enviado con éxito</td>': 'Envio Fallido</td>');

    $eval = $this->sendEmailTEF($estadoTEF, $nombreCliente, $fechaActual, $horaActual, $descCuenta, $descBanco, $emailCuenta, $idDocument);
    $htmlTags.= '<tr><td class="text-center">Envio Email</td><td class="text-center">Terminado ..</td><td class="text-center">';
    $htmlTags.= ($eval["retorno"]==0 ? 'Enviado con éxito</td>': 'Envio Fallido</td>');

    $value["htmlTags"] = $htmlTags;
    $data = $value;
    echo json_encode($data);
}


public function send_Simulate() {

    $return = check_session("");

    $this->form_validation->set_rules('flg_print', 'Indicador de impresion', 'required|trim');
    $this->form_validation->set_rules('emailCuenta', 'Email cliente', 'required|valid_email|trim');
    $this->form_validation->set_rules('label_nameClient', 'Nombre Cliente', 'required|trim');
    $this->form_validation->set_rules('idDocument', 'Número Documentos', 'required|trim');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('valid_email','El atributo %s no es valido.');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    if($this->input->post("flg_print")==""){
        cancel_function(COD_ERROR_INIT, "Debe Imprimir cotización antes de enviar por email", "");
    }

    $idDocument = $this->input->post("idDocument");
    $emailCuenta = $this->input->post("emailCuenta");
    $nombreCliente = $this->input->post("label_nameClient");
    $estadoTEF = $this->input->post("estadoTEF");

    $fechaActual = date("d-m-Y");
    $horaActual = date("H:i");

    $tipoCuenta = "";
    $descBanco = "";

    $value = $this->sendEmailTEF($estadoTEF, $nombreCliente, $fechaActual, $horaActual, $tipoCuenta, $descBanco, $emailCuenta, $idDocument);

    $data = $value;
    echo json_encode($data);

}



private function sendEmailTEF($estadoTEF, $nombreCliente, $fechaActual, $horaActual, $descCuenta, $descBanco, $emailCuenta, $idDocument) {

  $username = $this->session->userdata("username");

    if($estadoTEF=="accept" or $estadoTEF=="simula" or $estadoTEF == "cotiza") {

        $adjuntos = $this->documents->get_documentsByEmail($idDocument);
         if($adjuntos!=false) {

            foreach ($adjuntos as $nodo) {

                $result = $this->glossary->get_htmlEmailsById($estadoTEF, $nodo->typeDocument);
                if($result== false) {
                    $value["retorno"] = COD_ERROR_INIT;
                    $value["descRetorno"] = "Error, al leer cuerpo Email TEF";

                    $data = $value;
                    return ($data);
                }

                $bodyMessage = $result->CUERPOHTML;
                $bodyMessage = str_replace("&nombreCliente&", $nombreCliente, $bodyMessage);
                $bodyMessage = str_replace("&fechaActual&", $fechaActual, $bodyMessage);
                $bodyMessage = str_replace("&horaActual&", $horaActual, $bodyMessage);
                $bodyMessage = str_replace("&motivoRechazo&", "Transferencia Fallida", $bodyMessage);
                $bodyMessage = str_replace("&tipoCuenta&", $descCuenta, $bodyMessage);
                $bodyMessage = str_replace("&descBanco&", $descBanco, $bodyMessage);

                $titleMessage = $result->ASUNTO;

                $fileAdjuntos = base64_encode($nodo->image);

                $fileNameAdjuntos = "archivo.pdf";
                if($nodo->typeDocument=="CON") {

                    //aqui aplicar clave de 4 digitos
                    $fileAdjuntos = $this->pdfEncrypt($fileAdjuntos, substr($nodo->number_rut_client, -4));
                    $fileNameAdjuntos = "Contrato.pdf";


                }
                if($nodo->typeDocument=="COT") {

                    //aqui aplicar clave de 4 digitos
                    $fileAdjuntos = $this->pdfEncrypt($fileAdjuntos, substr($nodo->number_rut_client, -4));
                    $fileNameAdjuntos = "Hoja-Resumen.pdf";


                }
                if($nodo->typeDocument=="SIM") { $fileNameAdjuntos = "Simulacion.pdf"; }

                if($nodo->typeDocument=="DES") {

                    $fileAdjuntos = $this->pdfEncrypt($fileAdjuntos, substr($nodo->number_rut_client, -4));
                    $fileNameAdjuntos = "Seguro-Vida.pdf";
                }

                if($nodo->typeDocument=="PRO") {

                    $fileAdjuntos = $this->pdfEncrypt($fileAdjuntos, substr($nodo->number_rut_client, -4));
                    $fileNameAdjuntos = "Seguro-Enfermedades-Graves.pdf";
                }

                $email = sendEmail($bodyMessage, $titleMessage, $fileAdjuntos, $fileNameAdjuntos, $emailCuenta, $username);

            }

        }

    }

    if($estadoTEF=="deny") {

        $result = $this->glossary->get_htmlEmailsById($estadoTEF, "");
        if($result== false) {
            $value["retorno"] = COD_ERROR_INIT;
            $value["descRetorno"] = "Error, al leer cuerpo Email TEF";

            $data = $value;
            return ($data);
        }

        $bodyMessage = $result->CUERPOHTML;
        $bodyMessage = str_replace("&nombreCliente&", $nombreCliente, $bodyMessage);
        $bodyMessage = str_replace("&fechaActual&", $fechaActual, $bodyMessage);
        $bodyMessage = str_replace("&horaActual&", $horaActual, $bodyMessage);
        $bodyMessage = str_replace("&motivoRechazo&", "Transferencia Fallida", $bodyMessage);
        $bodyMessage = str_replace("&tipoCuenta&", $descCuenta, $bodyMessage);
        $bodyMessage = str_replace("&descBanco&", $descBanco, $bodyMessage);

        $titleMessage = $result->ASUNTO;

        $fileAdjuntos = ""; $fileNameAdjuntos = "";
        $email = sendEmail($bodyMessage, $titleMessage, $fileAdjuntos, $fileNameAdjuntos, $emailCuenta, $username);

    }

    $value["retorno"] = $email["retorno"];
    $value["descRetorno"] = $email["descRetorno"];

    $data = $value;
    return ($data);
}


private function pdfEncrypt ($origFile, $password){

    $fOri = sys_get_temp_dir() . '/'. uniqid();
    $fDest = sys_get_temp_dir() . '/'. uniqid();

    $file = fopen($fOri, 'w');
    fwrite($file, base64_decode($origFile));
    fseek($file, 0);

    $pdf = new \setasign\FpdiProtection\FpdiProtection();
    // set the format of the destinaton file, in our case 6×9 inch
//    $pdf->FPDF('P', 'in', array('6','9'));

    //calculate the number of pages from the original document
    $pagecount = $pdf->setSourceFile($fOri);

    // copy all pages from the old unprotected pdf in the new one
    for ($loop = 1; $loop <= $pagecount; $loop++) {
        $tplidx = $pdf->importPage($loop);
        $pdf->addPage();
        $pdf->useTemplate($tplidx);
    }

    // protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
    $pdf->SetProtection(array(),$password);
    $pdf->Output($fDest, 'F');

    $c = file_get_contents($fDest);

    unlink($fOri);
    unlink($fDest);

    return base64_encode($c);
}

private function sendSmsTEF($telefonoCuenta, $message) {
    if($this->session->userdata('lock') === NULL) { redirect(base_url()); }
    if($this->session->userdata('lock') == "0"){ redirect(base_url("Dashboard/lock")); }
    $username = $this->session->userdata("username");

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

//    $telefonoCuenta = "56945967314";

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
    $soap = get_SOAP($EndPoint, WS_Action_EnvioSMS, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], $tagName, WS_EnvioSMS);

    if($eval["retorno"]==0){
        $value["retorno"] = 0;
        $value["descRetorno"] = "Mensaje SMS, enviado Correctamente..";

    }else{

        $value["retorno"] = 1;
        $value["descRetorno"] = "Mensaje SMS, no fue posible enviar..";
    }
    $data = $value;

    put_logevent($soap, SOAP_OK);
    return ($data);
}


private function ws_SAV_update_Ofert($field_rut) {

    $field_rut = str_replace('.', '', $field_rut); $field_rut = str_replace('-', '', $field_rut); $field_rut = substr($field_rut, 0, -1); $username = $this->session->userdata("username");

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:rut>'.$field_rut.'</req:rut>
         <req:tipoCampagna>SAV</req:tipoCampagna>
         <req:estadoOferta>0</req:estadoOferta>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaOfertaTC;
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaOfertaTC, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "descRetorno", WS_ActualizaCotizacion);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    $data = $value;

    put_logevent($soap, SOAP_OK);
    return ($data);
}


private function ws_SAV_ConsultaEstadoTransfer($field_rut) {

    $field_rut = str_replace('.', '', $field_rut); $field_rut = str_replace('-', '', $field_rut);
    $username = $this->session->userdata("username");

    $Request='<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:rut>'.$field_rut.'</req:rut>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaEstadoTransfer;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaEstadoTransfer, WS_Timeout, $Request, WS_ToXml, $username);
    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["retorno"];
        $value["descRetorno"] = $soap["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $xmlString = $soap["xmlString"];
    $eval = eval_response_SOAP($xmlString, "descRetorno", WS_ConsultaEstadoTransfer);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];

        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;


    put_logevent($soap, SOAP_OK);

    $data = $value;
    return ($data);

}


private function ws_SAV_update_EstadoTransferencia($field_id, $field_estado) {

  $username = $this->session->userdata("username");

  $Request='<?xml version="1.0" encoding="UTF-8"?>
  <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
  <soapenv:Header/>
  <soapenv:Body>
    <req:DATA>
       <req:idSolicitud>'.$field_id.'</req:idSolicitud>
       <req:estadoTransferencia>'.$field_estado.'</req:estadoTransferencia>
    </req:DATA>
  </soapenv:Body>
  </soapenv:Envelope>';

  $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaEstadoTransferencia;
  $soap = get_SOAP($EndPoint, WS_Action_ActualizaEstadoTransferencia, WS_Timeout, $Request, WS_ToXml, $username);

  if($soap["codErrorSOAP"]!=0) {

      $value["retorno"] = $soap["retorno"];
      $value["descRetorno"] = $soap["descRetorno"];

      put_logevent($soap, SOAP_ERROR);

      $data = $value;
      return ($data);

  }
  $xmlString = $soap["xmlString"];

  $eval = eval_response_SOAP($xmlString, "descRetorno", WS_ActualizaEstadoTransferencia);
  if($eval["retorno"]!=0){
      $value["retorno"] = $eval["retorno"];
      $value["descRetorno"] = $eval["descRetorno"];

      put_logevent($soap, SOAP_ERROR);

      $data = $value;
      return ($data);
  }
  $xml = $eval["xmlDocument"];

  $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

  $value["retorno"] = $retorno;
  $value["descRetorno"] = $descRetorno;

  put_logevent($soap, SOAP_OK);

  $data = $value;
  return ($data);

}

private function ws_SAV_update_Transfer($field_id, $field_banco, $field_tipoCuenta, $field_numeroCuenta) {

    $username = $this->session->userdata("username");

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
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaCotizacion, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "descRetorno", WS_ActualizaCotizacion);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    $data = $value;

    put_logevent($soap, SOAP_OK);
    return ($data);
}

private function ws_SAV_update_Estado($field_id, $field_estado) {

    $usuarioAutoriza = ""; $usuarioLiquida = ""; $usuarioAceptacion = ""; $fechaAutoriza = ""; $fechaLiquida = "";$fechaAceptacion = "";
    $username = $this->session->userdata("username");

    $timestamp = date("d-m-Y H:i:s"); $usuarioLiquida = $this->session->userdata("username"); $fechaLiquida = $timestamp;

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
    $soap = get_SOAP($EndPoint, WS_Action_ActEstadoSavYRefTC, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "descRetorno", WS_ActEstadoSavYRefTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    $value["timestamp"] = $timestamp;
    $data = $value;

    put_logevent($soap, SOAP_OK);
    return ($data);
}


private function ws_getCotizacionById($field_id) {
    if($this->session->userdata('lock') === NULL) {redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
    $username = $this->session->userdata("username");

    if($field_id=="" || $field_id==0) {

        $value["retorno"] = COD_ERROR_INIT;
        $value["descRetorno"] = "Error, número simulación debe ser distinto de cero..";

        $data = $value;
        return ($data);
    }

    $Request = '<?xml version="1.0" encoding="UTF-8"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:numeroDeDocumento>'.$field_id.'</req:numeroDeDocumento>
         <req:tipoDocumento>COTIZACION</req:tipoDocumento>
         <req:tipoTrx>SAV</req:tipoTrx>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_DatosOpComercialTC;
    $soap = get_SOAP($EndPoint, WS_Action_DatosOpComercialTC, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return ($data);
    }
    $eval = eval_response_SOAP($soap["xmlString"], "descRetorno", WS_DatosOpComercialTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($value["retorno"]==0) {

        $value["pan"] = (string)$xml->Body->DATA->response->pan;
        $value["banco"] = (string)$xml->Body->DATA->response->banco;
        $value["tipoCuenta"] = (string)$xml->Body->DATA->response->tipoCuenta;
        $value["numeroCuenta"] = (string)$xml->Body->DATA->response->numeroCuenta;
        $value["estado"] = (string)$xml->Body->DATA->response->estado;
        $value["nroRut"] = (string)$xml->Body->DATA->response->nroRut;
        $value["dgvRut"] = (string)$xml->Body->DATA->response->dvRut;
        $value["codLocal"] = (string)$xml->Body->DATA->response->codLocal;
        $value["mesesDiferidos"] = (int)$xml->Body->DATA->response->mesesDiferidos;
    }
    $data = $value;


    put_logevent($soap, SOAP_OK);
    return ($data);
}




}
