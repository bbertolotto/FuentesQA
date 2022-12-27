<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client  extends CI_Controller {

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

    $this->load->model("Users_model","user");
    $this->load->model("Communes_model","communes");
    $this->load->model("Parameters_model","parameters");
    $this->load->model("Glossary_model","glossary");
    $this->load->model("Journal_model","journal");

    $this->load->library(array('Rut', 'Soap', 'form_validation', 'Pdf'));
    $this->load->helper(array('funciones_helper', 'ws_solventa_helper', 'teknodatasystems_helper'));

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}

    date_default_timezone_set('America/Santiago');
}

public function clientpdf()
{

$pdf = new Pdf('L', 'Legal');
//$pdf->SetFont('Arial','B',12);
$pdf->SetTitle('Teknodata');
$pdf->SetHeaderMargin(5);
$pdf->SetTopMargin(5);
$pdf->setFooterMargin(5);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Autor');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage('L', 'Legal');

$html = $this->input->post("html");

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output(FCPATH.'generarpdf2.pdf', 'F');
$input = FCPATH.'generarpdf2.pdf'; //temporary name that PHP gave to the uploaded file

echo json_encode("ok");

}

public function abrirpdf(){
    if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
    if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }

    $input = FCPATH.'generarpdf2.pdf'; //temporary name that PHP gave to the uploaded file

    header('Content-type:application/pdf');
    header('Content-disposition: inline; filename="rechazo.pdf"');
    header('content-Transfer-Encoding:binary');
    header('Accept-Ranges:bytes');
    readfile($input);

}

public function index(){
    $return = check_session("3.0.1");

    $this->load->library('session');
    $this->session->unset_userdata('nroRut');
    $this->session->unset_userdata('nroTcv');
    $this->session->unset_userdata('nombre_cliente');
    $this->session->unset_userdata('apellido_cliente');

    $this->load->view('client/search');
}

public function search(){
    $return = check_session("3.0.1");
    $this->load->view('client/search');
}

public function information(){
    $return = check_session("3.1.1");
    if($this->session->userdata("nroRut")===NULL) { redirect(base_url("client")); }

    $nroRut = $this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');
    $nroTcv = $this->session->userdata('nroTcv');
    $username = $this->session->userdata("username");
    $expired_customer = $this->session->userdata("expired_customer");
    $comercio = $this->session->userdata("id_commerce");
    $producto = $this->session->userdata("id_product");

    if($expired_customer=="S"){
        redirect(base_url("client/lastaccount"));
    }

    $dataLoad['dataError'] = array('session_empty' => TRUE);
    $dataLoad['dataCuenta'] = array();
    $dataLoad['dataCliente'] = array();
    $dataLoad['dataAcreditaciones'] = array();
    $dataLoad['dataParamTasa'] = array();
    $dataLoad['dataAdicionales'] = array();
    $dataLoad['dataParamAdquiriente'] = array();
    $dataLoad['dataUltimasTransacciones'] = array();
    $dataLoad['dataActivity'] = array();

    $contrato = 0; $data = array();

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
            $suscripcionEeccXMail = $result["suscripcionEeccXMail"];
            $envioCorrespondencia = $result["tipoDespacho"];

        $dataLoad['dataCuenta'] = $result;
    /* End Consulta desde Session CallWSSolventa.get_client() */

    /* Begin Consulta EECC */
    $fechaVencimiento = "";

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
            "flg_flujo" => $flg_flujo
        );
    }

    $result = ws_GET_ConsultaDatosEECCTC($dataInput);
    if($result["retorno"]==0){

      $xml = $result["xmlDocument"];
      foreach ($xml->Body->DATA as $recordEECC) {
          foreach ($recordEECC as $nodo) {
              if(strlen($nodo->fechaDeCorte)>1){
                  if($nodo->estadoEECC=="A"){
                      $fechaVencimiento = substr($nodo->fechaVencimiento,8,2).'-'.substr($nodo->fechaVencimiento,5,2).'-'.substr($nodo->fechaVencimiento,0,4);
                      $this->session->set_userdata('fechaProximoVencimiento', substr($nodo->fechaProximoVencimiento,0,10));
                  }
              }
          }
      }
    }
    /* End Consulta EECC*/


    /* Begin últimas transacciones TC*/
    $ultimaTRXVenta = 0; $ultimaTRXAvance = 0; $ultimaTRXPago = 0; $ultimaTRXCargo = 0; $fechaProximoVencimiento = "";
    $result = $this->get_ConsultaUltimasTransaccionesTC($nroTcv, $contrato, $flg_flujo, $username);
    if($result["retorno"]==0){

      $xml = $result["xmlDocument"];
      foreach ($xml->Body->DATA as $recordULTTRX) {
          foreach ($recordULTTRX as $nodo) {
              if($nodo->codTx==COD_TRX_VENTA){ $ultimaTRXVenta = $nodo->montoLiquido; }
              if($nodo->codTx==COD_TRX_AVANCE){ $ultimaTRXAvance = $nodo->montoLiquido; }
              if($nodo->codTx==COD_TRX_PAGO){ $ultimaTRXPago = $nodo->montoLiquido; }
              if($nodo->codTx==COD_TRX_CARGO){ $ultimaTRXCargo = $nodo->montoLiquido; }
          }
      }
    }

    $dataLoad['dataUltimasTransacciones'] = array(
            'ultimaTRXVenta' => $ultimaTRXVenta,
            'ultimaTRXAvance' => $ultimaTRXAvance,
            'ultimaTRXPago' => $ultimaTRXPago,
            'ultimaTRXCargo' => $ultimaTRXCargo,
            'fechaVencimiento' => $fechaVencimiento
        );

    $this->session->set_userdata('fechaProximoVencimiento', '');

    /* End últimas transacciones TC*/

    $result = ws_GET_ConsultaDatosClienteTC($nroRut, $flg_flujo, $username);
    if($result["retorno"]==0){

      $xml = $result["xmlDocument"];
      $dataLoad["dataCliente"] = array(
              'retorno' => $result["retorno"],
              'descRetorno' => $result["descRetorno"],
              'apellido_cliente' => $this->session->userdata('apellido_cliente'),
              'nombre_cliente' => $this->session->userdata('nombre_cliente'),
              'apellidoPaterno' => (string)$xml->Body->DATA->Registro->apellidoPaterno,
              'apellidoMaterno' => (string)$xml->Body->DATA->Registro->apellidoMaterno,
              'nombres' => (string)$xml->Body->DATA->Registro->nombres,
              'fechaNacimiento' => substr((string)$xml->Body->DATA->Registro->fechaNacimiento,0,10),
              'sexo' => (string)$xml->Body->DATA->Registro->sexo,
              'nroRut' => $this->session->userdata('nroRut'),
          );
    }

    $dataInput = [
        "contrato" => $contrato,
        "comercio" => $comercio,
    ];
    $dataLoad['dataParamTasa'] = $this->get_ConsultaParametrosTasaTC($dataInput);
    $dataLoad['dataParamSobregiro'] = $this->get_ConsultaParametrosSobregiroTC($contrato);


      /* Begin rescata desde Session CallWSSolventa.get_client() */

        $datosTarjeta = json_decode($this->session->userdata("sessDatosTarjeta"));

      /* Begin rescata desde Session CallWSSolventa.get_client() */
        $arrAdicionales = array();

        foreach ($datosTarjeta->tarjetas as $field) {

            if($field->relacion=="ADICIONAL") {

                $datanew["nroRutAdi"] = (string)$field->nroRut;
                $datanew["sexoAdi"] = substr($field->sexoAdi,0,1);
                $datanew["fechaNacimientoAdi"] = (string)$field->fechaNacimientoAdi;
                $datanew["nombresAdi"] = (string)$field->nombresAdi;
                $datanew["apellidoPaternoAdi"] = (string)$field->apellidoPaternoAdi;
                $datanew["apellidoMaternoAdi"] = (string)$field->apellidoMaternoAdi;
                $datanew["relacion"] = (string)$field->relacionAdi;
                $datanew["descSexoAdi"] = (string)$field->descSexoAdi;
                $datanew["descRelacion"] = (string)$field->descRelacion;

                $arrAdicionales[] = $datanew;
            }


        }
        $dataLoad['dataAdicionales'] = $arrAdicionales;

    /* End Rescata Adicionales */

    $dataInput = [
      "nroRut" => $nroRut,
      "username" => $username,
      "comercio" => $this->session->userdata("id_commerce"),
    ];
    $result = $this->get_ConsultaAcreditacionesTC($dataInput);
    if($result["retorno"]==0){

        $dataLoad['dataAcreditaciones'] = $result["dataResponse"];
    } else {

        $dataLoad['dataAcreditaciones'] = array();
    }
    $dataLoad['dataParamAdquiriente'] = $this->get_ConsultaParametrosAdquirenteTC($contrato);
    $dataLoad['dataActivity'] = $this->parameters->getall_activity();
    $dataLoad['dataError'] = array('session_empty' => FALSE);

    $this->load->view('client/information', $dataLoad);
}

public function contact(){

    $return = check_session("3.1.2");

    if($this->session->userdata("nroRut")===NULL) { redirect(base_url("client")); }

    $nroRut = $this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');
    $nroTcv = $this->session->userdata('nroTcv');
    $username = $this->session->userdata('username');
    $expired_customer = $this->session->userdata("expired_customer");

    if($expired_customer=="S"){
        redirect(base_url("client/lastaccount"));
    }

    $dataLoad['dataError'] = array('session_empty' => TRUE);
    $dataLoad['dataDirecciones'] = array();
    $dataLoad['dataTelefonos'] = array();
    $dataLoad['dataEmails'] = array();
    $dataLoad['dataCliente'] = array();

    $contrato = 0; $suscripcionEeccXMail = 0; $arrDataDirecciones = array(); $arrDataCliente = array(); $arrDataTelefonos = array(); $arrDataEmails = array();

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
            $suscripcionEeccXMail = $result["suscripcionEeccXMail"];
            $envioCorrespondencia = $result["tipoDespacho"];
        $dataLoad['dataCuenta'] = $result;
    /* End Consulta desde Session CallWSSolventa.get_client() */

    $result = json_decode(ws_GET_ConsultaDatosDireccion($nroRut, $contrato, $flg_flujo, $username));
    $dataLoad['dataDirecciones'] = $result->direcciones;

    $arrDataCliente = array();
    $arrDataCliente['last_name_client'] = $this->session->userdata("apellido_cliente");
    $arrDataCliente['name_client'] = $this->session->userdata("nombre_cliente");
    $arrDataTelefonos = array(); $arrDataEmails = array();

    $result = $this->get_ConsultaDatosContactoTC($nroRut, $contrato, $flg_flujo, $username);
    if($result["retorno"]==0){

          $xml = $result["xmlDocument"];
          foreach ($xml->Body->DATA as $recordDIR) {
              foreach ($recordDIR as $nodo) {

                  if(strlen($nodo->puntoContacto)>3){

                      $descTipoFono = ""; $descUso = "";
                      if($flg_flujo=="001"){

                          if($nodo->tipo=="TELEFONO") { $descTipoFono = "FIJO"; }
                          if($nodo->tipo=="MOVIL") { $descTipoFono = "MOVIL"; }
                          if($nodo->tipo=="E-MAIL") { $descTipoFono = "PARTICULAR"; }

                          if($nodo->uso=="TE") { $descUso = "TELEFONO"; } else { $descUso = "MOVIL"; }

                          $usoFono = (string)$nodo->uso;
                          $datanew["puntoContacto"] = (string)$nodo->puntoContacto;
                          $datanew["descUso"] = $descUso;
                          $datanew["descTipoFono"] = $descTipoFono;
                          if($nodo->vigencia=="S"){ $datanew["vigencia"] = "VIGENTE"; } else { $datanew["vigencia"] = "NO VIGENTE"; }
                          $datanew["eecc"] = $envioCorrespondencia;

                          $datanew["tipo"] = (string)$nodo->tipo;
                          $datanew["uso"] = (string)$nodo->uso;
                          $datanew["tipoFono"] = (string)$nodo->tipoFono;

                          if($nodo->tipo=="TELEFONO" OR $nodo->tipo=="MOVIL") { $arrDataTelefonos[] = $datanew; } else { $arrDataEmails[] = $datanew; }

                      } else {

                          $tipo_contacto = "";
                          if($nodo->tipo=="FON") {

                              if(substr($nodo->tipoFono,0,6) == "MOBILE") {
                                  $descTipoFono = "MOVIL";
                              }else{
                                  $descTipoFono = "FIJO";
                              }
                              $tipo_contacto = "TELEFONO";
                          }

                          if($nodo->tipo=="EMA"){

                              $descTipoFono = "";
                              if($nodo->tipoFono=="HOME" AND $nodo->uso=="ASS"){
                                  $descTipoFono = "LABORAL";
                              }
                              if($nodo->tipoFono=="HOME" AND $nodo->uso=="HOM"){
                                  $descTipoFono = "PARTICULAR";
                              }
                              $tipo_contacto = "EMAIL";
                          }

                          $Request = array(
                              "tipo_contacto" => $tipo_contacto,
                              "tipo_fono" => substr($nodo->tipoFono,0,6),
                              "tipo_uso" => $nodo->uso
                          );

                          $eval = $this->glossary->get_typeContactClient($Request);

                          if($eval!=false) {

                              $usoFono = (string)$nodo->uso; $descUso = "";
                              $datanew["puntoContacto"] = (string)$nodo->puntoContacto;
                              $datanew["descUso"] = (string)$eval->USO_CONTACTO;
                              $datanew["descTipoFono"] = $descTipoFono;
                              if($nodo->vigencia=="S"){ $datanew["vigencia"] = "VIGENTE"; } else { $datanew["vigencia"] = "NO VIGENTE"; }
                              $datanew["eecc"] = $envioCorrespondencia;

                          } else {

                              $datanew["puntoContacto"] = (string)$nodo->puntoContacto;
                              $datanew["descUso"] = (string)$nodo->uso;
                              $datanew["descTipoFono"] = $descTipoFono;
                              if($nodo->vigencia=="S"){ $datanew["vigencia"] = "VIGENTE"; } else { $datanew["vigencia"] = "NO VIGENTE"; }
                              $datanew["eecc"] = $envioCorrespondencia;
                          }

                          $datanew["tipo"] = (string)$nodo->tipo;
                          $datanew["uso"] = (string)$nodo->uso;
                          $datanew["tipoFono"] = (string)$nodo->tipoFono;

                          if($nodo->tipo=="FON") { $arrDataTelefonos[] = $datanew; } else { $arrDataEmails[] = $datanew; }
                      }
                  }
              }
          }

      }

    $arrDataCliente = array();
    $arrDataCliente['last_name_client'] =  $this->session->userdata("apellido_cliente");
    $arrDataCliente['name_client'] = $this->session->userdata("nombre_cliente");

    $dataLoad['regions'] = $this->communes->ViewRegions();
    $dataLoad['dataCliente'] = $arrDataCliente;
    $dataLoad['dataTelefonos'] = $arrDataTelefonos;
    $dataLoad['dataEmails'] = $arrDataEmails;
    $dataLoad['dataError'] = array('session_empty' => FALSE);

    $this->load->view('client/contact', $dataLoad);
}

public function consolidate(){
    $return = check_session("3.2.1");
    if($this->session->userdata("nroRut")===NULL) { redirect(base_url("client")); }

    $nroRut = $this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');
    $nroTcv = $this->session->userdata('nroTcv');
    $username = $this->session->userdata("username");
    $expired_customer = $this->session->userdata("expired_customer");
    $comercio = $this->session->userdata("id_commerce");
    $producto = $this->session->userdata("id_product");


    if($expired_customer=="S"){
        redirect(base_url("client/lastaccount"));
    }


    /* Init variables locales */
        $dataLoad = array(); $contrato = 0; $diasMora = 0; $suscripcionEeccXMail = 0; $envioCorrespondecia = ""; $comercio = 27;
        $descripcionTarjeta = ""; $descripcionMarca = "";

        $dataLoad['dataError'] = array('session_empty' => TRUE);
        $dataLoad['dataCuenta'] = array();
        $dataLoad['dataTarjeta'] = array();
        $dataLoad['dataSegmentos'] = array();
        $dataLoad['dataCupos'] = array();
        $dataLoad['dataCarteraVencida'] = array();
        $dataLoad['dataEECC'] = array();
        $dataLoad['dataDeudaCliente'] = array();
        $dataLoad['dataEstadoBloqueos'] = array();
        $dataLoad['dataDatosCuenta'] = array();

    /* Init variables Locales */

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
            $suscripcionEeccXMail = $result["suscripcionEeccXMail"];
            $envioCorrespondencia = $result["tipoDespacho"];

        $dataLoad['dataDatosCuenta'] = $result;
    /* End Consulta desde Session CallWSSolventa.get_client() */


    /* Begin rescata desde Session CallWSSolventa.get_client() */
        $arrDataPAN = array(); $descripcionTarjeta = ""; $descripcionMarca = "";
        $datosTarjeta = json_decode($this->session->userdata("sessDatosTarjeta"));

        foreach ($datosTarjeta->tarjetas as $field) {

            /***
            Begin -> CC012 -> Tarjeta Abierta Release 3
            ***/
            $result = $this->glossary->get_masterProductById($field->desmarca);
            if(!$result){

                $datanew["descripcionTarjeta"] = $field->desmarca . " no existe parámetro..";
                $datanew["descripcionComercio"] = "";
                $datanew["descripcionMarca"] = "";
                $datanew["productoTarjeta"] = "";
                $datanew["descripcionbloqueo"] = "";

            }else{

                $datanew["descripcionTarjeta"] = (string)$result->PRODUCT_DESCRIP;
                $datanew["descripcionComercio"] = $result->PRODUCT_COMMERCE;
                $datanew["descripcionMarca"] = $result->PRODUCT_BRAND;
                $datanew["productoTarjeta"] = $result->PRODUCT_NAME;

                if($field->relacion=="TITULAR" AND $field->codigoDeBloqueo==0){
                    $descripcionTarjeta = (string)$result->PRODUCT_DESCRIP;
                    $descripcionMarca = (string)$result->PRODUCT_BRAND;
                }

                $result = $this->parameters->get_motivo_bloqueo($field->codigoDeBloqueo);
                $datanew["descripcionbloqueo"] = ($result!=false ? $result->NAME : "");

            }
            /***
            End -> CC012 -> Tarjeta Abierta Release 3
            ***/

            $datanew["codigoDeBloqueo"] = (string)$field->codigoDeBloqueo;
            $datanew["fechaActivacion"] = substr($field->fechaActivacion,0,10);
            $datanew["fechaCreacion"] = substr($field->fechaCreacion,0,10);
            $datanew["fechaDeBloqueo"] = substr($field->fechaDeBloqueo,0,10);
            $datanew["fechaExpiracion"] = substr($field->fechaExpiracion,0,10);

            $datanew["nroRut"] = (string)$field->nroRut;
            $datanew["pan"] = (string)$field->pan;
            $datanew["relacion"] = (string)$field->relacion;
            $datanew["descripcion"] = (string)$field->descripcion;
            $datanew["desmarca"] = (string)$field->desmarca;
            $datanew["cliente"] = (string)$field->cliente;
            $arrDataPAN[] = $datanew;

        }
        $dataLoad['dataTarjeta'] = $arrDataPAN;

        $dataLoad['dataCuenta'] = array(
                'envioCorrespondecia' => $envioCorrespondencia,
                'apellido_cliente' => $this->session->userdata('apellido_cliente'),
                'nombre_cliente' => $this->session->userdata('nombre_cliente'),
                'descripcionTarjeta' => $descripcionTarjeta,
                'descripcionMarca' => $descripcionMarca);

    /* End rescata desde Session CallWSSolventa.get_client() */

        $dataInput = array(
            "nroTcv" => $nroTcv,
            "contrato" => $contrato,
            "id_channel" => $this->session->userdata("flg_flujo"),
            "id_product" => $this->session->userdata("id_product"),
            "id_commerce" => $this->session->userdata("id_commerce"),
        );
        $result = ws_GET_CuposTC($dataInput);
        if($result["retorno"]==0){

            $dataLoad['dataCupos'] = $result["dataResponse"];
        }

        if($flg_flujo=="002"){

            $result = $this->get_ConsultaSegmentosTC($nroRut, $username);
            $dataLoad['dataSegmentos'] = $result;

        } else {

            $dataLoad["dataSegmentos"]["descSegmento"] = "SIN SEGMENTO";
            $dataLoad["dataSegmentos"]["descActividad"] = "SIN ACTIVIDAD";
        }


        $result = $this->get_ConsultaCarteraVencidaTC($nroRut, $comercio, $username);
        $dataLoad['dataCarteraVencida'] = $result;

        $dataInput = [
            "nroRut" => $nroRut,
            "nroTcv" => $nroTcv,
            "contrato" => $contrato,
            "flg_flujo" => $flg_flujo,
            "username" => $username,
            "comercio" => $comercio,
            "producto" => $producto,
          ];

        $result = $this->get_ConsultaDeudaClienteTC($dataInput);
        $dataLoad['dataDeudaCliente'] = $result;

/** Begin::CC028:: **/
        $dataInput = array(
            "nroRut" => $nroRut,
            "contrato" => $contrato,
            "id_channel" => $flg_flujo,
            "id_type" => TYPE__PRODUCT_SAV,
            "id_product" => $producto
        );
        $result = ws_GET_ConsultaEstadosBloqueo($dataInput);
        $dataLoad['dataEstadoBloqueos'] = $result;
/** End::CC028:: **/

      /* Begin Consulta EECC */
        if($flg_flujo=="001"){

            $dataInput = array(
                "nroRut" => $nroRut,
                "contrato" => $contrato,
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
                "flg_flujo" => $flg_flujo
            );
        }

      $result = ws_GET_ConsultaDatosEECCTC($dataInput);
      if($result["retorno"]==0){

            $dataLoad['dataEECC'] = array(
                'fechaVencimiento' => $result["fechaVencimiento"],
                'fechaProximoVencimiento' => $result["fechaProximoVencimiento"],
                'pagoDelMes' => $result["pagoDelMes"],
                'pagoMinimo' => $result["pagoMinimo"],
                'deudaActual' => $result["pagoMinimo"],
                'numAvancesDelDia' => 2
            );

      }
      /* End Consulta EECC*/

      $dataLoad['dataError'] = array('session_empty' => FALSE);

      $this->load->view('client/consolidate', $dataLoad);
}

/***
Begin CC0011
***/

public function replacecard(){

    $return = check_session("3.4.1");
    if($this->session->userdata("nroRut")===NULL) { redirect(base_url("client")); }

    $nroRut = $this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');
    $nroTcv = $this->session->userdata('nroTcv');
    $expired_customer = $this->session->userdata("expired_customer");

    if($expired_customer=="S"){
        redirect(base_url("client/lastaccount"));
    }

    $dataLoad = array();

    if($this->session->userdata("flg_flujo")=="002"){

        $dataLoad["dataError"] = array(
            "session_empty" => FALSE,
            "load_error" => TRUE,
            "descRetorno" => "<h4><strong>Cliente creado en VISSAT, favor realizar Reimpresi&oacute;n y/o Reposici&oacute;n en VISSAT");
        $dataLoad["htmlTarjetas"] = "";

    }else{

        if($nroRut == NULL){
            $dataLoad['dataError'] = array('session_empty' => TRUE);
            $dataLoad['dataCuenta'] = array();
            $dataLoad['dataTarjeta'] = array();
        }else{

            $dataLoad = $this->dataLoad_replacecard($nroRut, $flg_flujo, $nroTcv);
        }

    }

    $this->load->view('client/replacecard', $dataLoad);
}


private function dataLoad_replacecard($nroRut, $flg_flujo, $nroTcv) {

    $contrato = 0; $diasMora = 0; $suscripcionEeccXMail = 0; $username = $this->session->userdata("username"); $envioCorrespondecia = "";
    $data["dataCuenta"] = array(); $data["dataTarjeta"] = array(); $arrDataPAN = array(); $descripcionTarjeta=""; $descripcionMarca = "";

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
            $suscripcionEeccXMail = $result["suscripcionEeccXMail"];
            $envioCorrespondencia = $result["tipoDespacho"];

    /* End Consulta desde Session CallWSSolventa.get_client() */

    /* Begin rescata desde Session CallWSSolventa.get_client() */

        $datosTarjeta = json_decode($this->session->userdata("sessDatosTarjeta"));

        foreach ($datosTarjeta->tarjetas as $field) {
            $descripcionTarjeta = $field->descripcion;
            $descripcionMarca = $field->desmarca;
        }

    /* Begin rescata desde Session CallWSSolventa.get_client() */

    $data["dataCuenta"] = array(
          "envioCorrespondecia" => $envioCorrespondencia,
          "apellido_cliente" => $this->session->userdata("apellido_cliente"),
          "nombre_cliente" => $this->session->userdata("nombre_cliente"),
          "descripcionTarjeta" => $descripcionTarjeta,
          "descripcionMarca" => $descripcionMarca);

    $htmlTarjetas = '<thead>
        <tr><th class="text-center"><strong>Comercio</strong></th>
            <th class="text-center"><strong>Producto</strong></th>
            <th class="text-center"><strong>Nº Tarjeta</strong></th >
            <th class="text-center"><strong>Situaci&#243;n</strong></th>
            <th class="text-center"><strong>Fecha Expiraci&#243;n</strong></th>
            <th ><strong>Cliente</strong></th>
            <th class="text-center"><strong>Descripci&#243;n</strong></th>
            <th class="text-center"><strong>Seleccionar</strong></th>
        </tr>
        </thead>
        <tbody>';

        $line = 0;
        foreach ($datosTarjeta->tarjetas as $field) {

            $line = $line + 1;

            $descripcionTarjeta = $field->descripcion;
            $descripcionMarca = $field->desmarca;

            $offpan = "****-****-****-".substr($field->pan,12,4);
            $pan = substr($field->pan,12,4);

            if($field->codigoDeBloqueo==0):
                $onclick = 'onclick="Client.selectReplaceCard(this);"';
                $disabled = "";
            else:
                $onclick = "";
                $disabled = "disabled";
            endif;

            $htmlTarjetas.= '
                <tr '.$onclick.'>
                    <td class="text-center">'.$field->desmarca.'</td>
                    <td class="text-center">'.$field->descripcion.'</td>
                    <td class="text-center">'.$offpan.'</td>
                    <td class="text-center">'.$field->descripcion.'</td>
                    <td class="text-center">'.substr($field->fechaExpiracion,0,10).'</td>
                    <td class="text-center">'.$field->cliente.'</td>
                    <td class="text-center">'.$field->relacion.'</td>
                    <td class="text-center"><input type="radio" name="sel'.$pan.$field->relacion.'" value="'.$field->pan.'" id="sel'.$pan.$field->relacion.'"'.$disabled.'></td>
                </tr>';
        }

        if($line>0){

            $htmlTarjetas.= '</tbody>';
        }else{

            $htmlTarjetas = '<thead>
                <tr>
                    <th class="text-left"><strong>'.MSG_SIN_TARJETAS.'</strong></th>
                </tr>
            </thead>';

        }


    $data["htmlTarjetas"] = $htmlTarjetas;
    $data["lockTypes"] = $this->glossary->getall_lockTypes();
    $data["dataError"] = array(
          "session_empty" => FALSE ,
          "load_error" => FALSE);

    return($data);

} //End Function dataLoad_replacecard()

/***
End CC0011
***/



public function lasttransaction(){

    $return = check_session("3.2.2");

    $nroRut = $this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');
    $nroTcv = $this->session->userdata('nroTcv');
    $username = $this->session->userdata('username');
    $expired_customer = $this->session->userdata("expired_customer");
    $comercio = $this->session->userdata("id_commerce");
    $producto = $this->session->userdata("id_product");


    if($expired_customer=="S"){
        redirect(base_url("client/lastaccount"));
    }

    $dataLoad['dataError'] = array('session_empty' => TRUE);
    $dataLoad['dataAUT'] = array();
    $dataLoad['dataCuenta'] = array();
    $dataLoad['dataRange'] = array();

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
            $suscripcionEeccXMail = $result["suscripcionEeccXMail"];
            $envioCorrespondencia = $result["tipoDespacho"];

        $dataLoad['dataDatosCuenta'] = $result;
    /* End Consulta desde Session CallWSSolventa.get_client() */

    $dateEnd = date("d-m-Y"); $dateBegin = date("d-m-Y",strtotime($dateEnd."- 5 days")); 
    $arrDataAUT = array();

    $dataInput = [
        "nroTcv" => $nroTcv,
        "contrato" => $contrato,
        "flg_flujo" => $flg_flujo,
        "dateBegin" => $dateBegin,
        "dateEnd" => $dateEnd,
        "username" => $username,
        "comercio" => $comercio,
        "producto" => $producto,
      ];
    $result = $this->get_ConsultaAutorizacionesTC($dataInput);
    if($result["retorno"]==0){

      $xml = $result["xmlDocument"];
      foreach ($xml->Body->DATA as $recordTRX) {
          foreach ($recordTRX as $nodo) {

              $fechaHora = substr($nodo->fechaTrx,6,4)."-".substr($nodo->fechaTrx,3,2)."-".substr($nodo->fechaTrx,0,2)." ".substr($nodo->fechaTrx,11,5);
              if($nodo->comercio!=""){
                      $datanew["comercio"] = $nodo->comercio;
                      $datanew["local"] = $nodo->local;
                      $datanew["fechahora"] = $fechaHora;
                      $datanew["descripcion"] = $nodo->descripcionTrx;
                      $datanew["codigoautorizacion"] = $nodo->codigoDeAutorizacion;
                      $datanew["cantidadDeCuotas"] = $nodo->cantidadDeCuotas;
                      $datanew["Monto_Contado"] = $nodo->montoContado;
                      $datanew["Monto_Credito"] = $nodo->montoCredito;
                      $datanew["terminal"] = $nodo->terminal;
                      $datanew["estadoTrx"] = $nodo->estadoTrx;
                      $arrDataAUT[] = $datanew;
                }
            }
        }

    }

    $dataLoad['dataAUT'] = $arrDataAUT;
    $dataLoad['dataError'] = array('session_empty' => FALSE);

    $todayDate = date("d-m-Y");
    $dataLoad['dataRange'] = array(
          'dateEnd' => date('d').'-'.date('m').'-'.date('Y'),
          'dateBegin' => date("d-m-Y",strtotime($todayDate."- 3 month")) );

    $this->load->view('client/lasttransaction', $dataLoad);
}

public function lastaccount(){

    $return = check_session("3.2.3");

    $nroRut = $this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');
    $nroTcv = $this->session->userdata('nroTcv');
    $username = $this->session->userdata('username');

    //$nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $dataLoad['dataError'] = array('session_empty' => TRUE);
    $dataLoad['dataEECC'] = array();
    $dataLoad['dataAccount'] = array();

    $contrato = 0; $montoEnMora = 0; $diasMora = 0; $suscripcionEeccXMail = 0;$retorno = COD_ERROR_INIT;$arrDataEECC = array();
    $arrDataAccount = array();

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
            $suscripcionEeccXMail = $result["suscripcionEeccXMail"];
            $envioCorrespondencia = $result["tipoDespacho"];

        $arrDatosCuenta = $result;
    /* End Consulta desde Session CallWSSolventa.get_client() */


    $arrDataAccount["nroRut"] = $nroRut; $arrDataAccount["nroTcv"] = $nroTcv;


    if($flg_flujo=="001"){

        $dataInput = array(
            "nroRut" => "",
            "contrato" => $contrato,
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
            "flg_flujo" => $flg_flujo
        );
    }

    $result = ws_GET_ConsultaDatosEECCTC($dataInput);
    if($result["retorno"]==0){

      $xml = $result["xmlDocument"]; $indice=1;
      foreach ($xml->Body->DATA as $recordEECC) {
          foreach ($recordEECC as $nodo) {

              if(strlen($nodo->fechaDeCorte)>1){

                if($nodo->estadoEECC=="A"){
                    $datanew["estadoEECC"] = "ACTUAL";
                }else{
                    $datanew["estadoEECC"] = "HISTORICO";
                }
                if(strlen($nodo->fechaVencimiento) > 0){
                    $fechaVencimiento = substr($nodo->fechaVencimiento,0,4)."-".substr($nodo->fechaVencimiento,5,2)."-".substr($nodo->fechaVencimiento,8,2);
                }else{
                    $fechaVencimiento = "";
                }
                if(strlen($nodo->fechaDeCorte) > 0){
                    $fechaDeCorte = substr($nodo->fechaDeCorte,0,4)."-".substr($nodo->fechaDeCorte,5,2)."-".substr($nodo->fechaDeCorte,8,2);
                }else{
                    $fechaDeCorte = "";
                }
                if(strlen($nodo->fechaProximoVencimiento) > 0){
                    $fechaProximoVencimiento = substr($nodo->fechaProximoVencimiento,0,4)."-".substr($nodo->fechaProximoVencimiento,8,2)."-".substr($nodo->fechaProximoVencimiento,5,2);
                }else{
                    $fechaProximoVencimiento = "";
                }

                $datanew['envioCorrespondecia'] = $envioCorrespondencia;
                $datanew["fechaDeCorte"] = $fechaDeCorte;
                $datanew["fechaVencimiento"] = $fechaVencimiento;
                $datanew["gastosDeCobranza"] = (float)$nodo->gastosDeCobranza;
                $datanew["montoPagadoEECC"] = (float)$nodo->montoPagadoEECC;
                //$datanew["montoTotalFacturado"] = (float)$nodo->montoTotalFacturado;
                $datanew["montoTotalFacturado"] = (float)$nodo->deudaUltimoEECC;
                $datanew["pagoDelMes"] = (float)$nodo->pagoDelMes;
                $datanew["pagoMinimo"] = (float)$nodo->pagoMinimo;
                $datanew["saldoAnterior"] = (float)$nodo->saldoAnterior;
                $datanew["saldoInsoluto"] = (float)$nodo->saldoInsoluto;
                $datanew["montoCuota"] = (float)$nodo->montoCuota;
                $datanew["tasaInteresCorriente"] = $nodo->tasaInteresCorriente;
                $datanew["tasaInteresMoratorio"] = $nodo->tasaInteresMoratorio;
                $datanew["montoVenta"] = (float)$nodo->montoVenta;
                $datanew["montoAvance"] = (float)$nodo->montoAvance;
                $datanew["montoRevolving"] = (float)$nodo->montoRevolving;
                $datanew["gastosyCargos"] = (float)$nodo->gastosyCargos;
                $datanew["totalImpuesto"] = (float)$nodo->totalImpuesto;
                $datanew["fechaProximoVencimiento"] = $fechaProximoVencimiento;
                $datanew["indice"] = $indice;$indice=$indice+1;
                $arrDataEECC[] = $datanew;

              }
          }
      }
    }

    $dataLoad['dataError'] = array('session_empty' => FALSE);
    $dataLoad['dataEECC'] = $arrDataEECC;
    $dataLoad["dataAccount"] = $arrDataAccount;

    $this->load->view('client/lastaccount', $dataLoad);
}

public function secure(){
    $return = check_session("3.3.1");

    $nroRut = $this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');
    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
    /* End Consulta desde Session CallWSSolventa.get_client() */
    $username = $this->session->userdata('username');
    $expired_customer = $this->session->userdata("expired_customer");

    if($expired_customer=="S"){
        redirect(base_url("client/lastaccount"));
    }

    $dataLoad['dataError'] = array('session_empty' => TRUE);
    $dataLoad['dataNOSEG'] = array();
    $dataLoad['dataSEG'] = array();

    $comercio = 27; $retorno = COD_ERROR_INIT; $arrDataSEG = array(); $arrDataNOSEG = array();
    $result = $this->get_ConsultaSegurosContratados($nroRut, $contrato, $comercio, $username);

    if($result["retorno"]==0){

        $xml = $result["xmlDocument"];

        foreach ($xml->Body->DATA->response as $recordSEG) {
            foreach ($recordSEG as $nodo) {

                if($nodo->estadoSeguro=="A"){
                    $datanew["codigoSeguro"] = $nodo->codigoSeguro;
                    $datanew["empresaAseguradora"] = $nodo->empresaAseguradora;
                    if($nodo->estadoSeguro=="A"){
                        $datanew["estadoSeguro"] = "ALTA";
                    }
                    if($nodo->estadoSeguro=="B"){
                        $datanew["estadoSeguro"] = "BAJA";
                    }
                    $datanew["fechaAltaBaja"] = $nodo->fechaAltaBaja;
                    $datanew["nombreSeguro"] = $nodo->nombreSeguro;
                    $datanew["valorPrima"] = (float)$nodo->valorPrima;
                    $arrDataSEG[] = $datanew;
                }
            }
        }
    }

    $result = $this->get_ConsultaSegurosNoContratados($nroRut, $comercio, $username);
    if($result["retorno"]==0){

        $xml = $result["xmlDocument"];
        foreach ($xml->Body->DATA->response as $recordNOSEG) {
            foreach ($recordNOSEG as $nodo) {

                if(strlen($nodo->codigoSeguro)>1){
                    $datanew["codigoSeguro"] = $nodo->codigoSeguro;
                    $datanew["empresaAseguradora"] = $nodo->empresaAseguradora;
                    $datanew["idPoliza"] = $nodo->idPoliza;
                    $datanew["montoMaximo"] = $nodo->montoMaximo;
                    $datanew["montoMinimo"] = $nodo->montoMinimo;
                    $datanew["montoPrima"] = $nodo->montoPrima;
                    $datanew["nombreSeguro"] = $nodo->nombreSeguro;
                    $arrDataNOSEG[] = $datanew;
                }
            }
        }
    }

    $dataLoad['dataError'] = array('session_empty' => FALSE);
    $dataLoad['dataSEG'] = $arrDataSEG;
    $dataLoad['dataNOSEG'] = $arrDataNOSEG;

    $this->load->view('client/secure', $dataLoad);
}


public function documents(){

    $return = check_session("4.1.7");

    $data["dataFilters"] = "CON,DES,PRO,CON,SIM,CRC";
    $this->load->view('client/documents', $data);
}

public function debtcertificates(){

    $return = check_session("3.4.2");
    $this->load->view('client/debtcertificates');
}

private function get_ConsultaUltimasTransaccionesTC($nroTcv, $contrato, $flg_flujo, $username){

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaUltimasTransaccionesTC]";
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaUltimasTransaccionesTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:PAN></req:PAN>
         <req:CONTRATO>'.$contrato.'</req:CONTRATO>
         <req:COD_TX></req:COD_TX>
         <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaUltimasTransaccionesTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaUltimasTransaccionesTC, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);

    }

    $eval = eval_response_core($soap["xmlString"], "descRetorno", WS_ConsultaUltimasTransaccionesTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data["xmlDocument"] = $eval["xmlDocument"];
    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;

    put_logevent($soap, SOAP_OK);

    return ($data);
}

private function get_ConsultaParametrosAdquirenteTC($contrato){

        $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
        <soapenv:Header/>
        <soapenv:Body>
           <req:DATA>
              <req:idCuenta>'.$contrato.'</req:idCuenta>
           </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

        $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaParametrosAdquirenteTC;
        $xmlString = $this->get_core($EndPoint, WS_Action_ConsultaParametrosAdquirenteTC, WS_Timeout, $Request, WS_ToXml);
        $xml = simplexml_load_string($xmlString);
        $xml_valid = ($xml ? true : false);
        $data = array();$retorno=COD_ERROR_INIT;$descRetorno=MSG_ERROR_INIT;
        if($xml_valid){
            $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;
        }
        if($retorno==0){
            foreach ($xml->Body->DATA->response as $recordEECC) {
                foreach ($recordEECC as $nodo) {
                    if(strlen($nodo->codModalidad)>1){
                        $datanew["codModalidad"] = $nodo->codModalidad;
                        $datanew["desModalidad"] = $nodo->desModalidad;
                        $data[] = $datanew;
                    }
             }
            }
        }
        return($data);
    }

private function get_ConsultaAcreditacionesTC($dataInput){

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaAcreditacionesTC]"; $dataResponse = array();
    $nroRut = str_replace('.', '', $dataInput["nroRut"]); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:nroRut>'.$nroRut.'</req:nroRut>
          <req:comercio>'. $dataInput["comercio"] .'</req:comercio>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaAcreditacionesTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaAcreditacionesTC, WS_Timeout, $Request, WS_ToXml, $dataInput["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaAcreditacionesTC);
    $eval = ws_EVAL_SOAP($Request);
    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];
        return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0){

      $dataResponse = array(
          'actividad' => (string)$xml->Body->DATA->response->actividad,
          'renta' => (float)$xml->Body->DATA->response->renta,
          'empresa' => (string)$xml->Body->DATA->response->empresa,
          'codActividad' => (string)$xml->Body->DATA->response->codActividad
      );
    }

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;
    $data["dataResponse"] = $dataResponse;

    put_logevent($soap, SOAP_OK);

    return($data);
}

private function get_ConsultaParametrosTasaTC($dataInput){

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:idCuenta>'. $dataInput["contrato"]. '</req:idCuenta>
          <req:comercio>'. $dataInput["comercio"]. '</req:comercio>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaParametrosTasaTC;
    $xmlString = $this->get_core($EndPoint, WS_Action_ConsultaParametrosTasaTC, WS_Timeout, $Request, WS_ToXml);

        $data = array(); $retorno = COD_ERROR_INIT;
        if(strpos($xmlString,"cabeceraSalida")!=FALSE){
            $xml = simplexml_load_string($xmlString);
            $xml_valid = ($xml ? true : false);
            $data = array();$retorno=COD_ERROR_INIT;
            if($xml_valid){
                $retorno = (int)$xml->Body->DATA->response->return->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->return->cabeceraSalida->descRetorno;
            }
            if ($retorno==0){
                $data = array(
                'tasaAvanceMayor90' => (float)$xml->Body->DATA->response->return->tasaAvanceMayor90,
                'tasaAvanceMenor90' => (float)$xml->Body->DATA->response->return->tasaAvanceMenor90,
                'tasaCompraMayor90' => (float)$xml->Body->DATA->response->return->tasaCompraMayor90,
                'tasaCompraMenor90' => (float)$xml->Body->DATA->response->return->tasaCompraMenor90,
                'tasaInteresMora' => (float)$xml->Body->DATA->response->return->tasaInteresMora,
                'impuestos' => (float)$xml->Body->DATA->response->return->impuestos,
                'mantencionMensual' => (float)$xml->Body->DATA->response->return->mantencionMensual
                    );
            }
        }
        return($data);
}

private function get_ConsultaParametrosSobregiroTC($contrato){
        $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
        <soapenv:Header/>
        <soapenv:Body>
           <req:DATA>
              <req:idCuenta>'.$contrato.'</req:idCuenta>
              <req:comercio>27</req:comercio>
           </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';
        $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaParametrosSobregiroTC;
        $xmlString = $this->get_core($EndPoint, WS_Action_ConsultaParametrosSobregiroTC, WS_Timeout, $Request, WS_ToXml);
        $data = array(); $retorno = COD_ERROR_INIT;
        if(strpos($xmlString,"cabeceraSalida")!=FALSE){
            $xml = simplexml_load_string($xmlString);
            $xml_valid = ($xml ? true : false);
            $data = array();$retorno=COD_ERROR_INIT;
            if($xml_valid){
                $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
            }
            if ($retorno==0){
                $data = array(
                            'lineaSobregiroCompra' => (float)$xml->Body->DATA->response->lineaSobregiroCompra,
                    );
            }
        }
        return($data);
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
    if(strpos($xmlString,"Fault")!=FALSE){
        $data = array('retorno' => COD_ERROR_INIT,
            'descRetorno' => $xmlString
            );
    }
    $xml = simplexml_load_string($xmlString);
    $xml_valid = ($xml ? true : false);
    if($xml_valid){
        $retorno = (int)$xml->Body->DATA->retorno;
    }
    if ($retorno==0){
        $data = array('retorno' => $retorno,
            'descRetorno' => $xml->Body->DATA->descRetorno,
            'contrato' => $xml->Body->DATA->Registro->contrato,
            'fechaCreacion' => $xml->Body->DATA->Registro->fechaCreacion,
            'fechaActivacion' => $xml->Body->DATA->Registro->fechaActivacion,
            'suscripcionEeccXMail' => $xml->Body->DATA->Registro->suscripcionEeccXMail
            );
    }else{

        $data = array('retorno' => $retorno,
                'descRetorno' => MSG_ERROR_SERVICE);
    }
    return ($data);
}

private function get_ConsultaSegmentosTC($nroRut, $username){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaSegmentosTC]";
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
        <req:DATA>
        <req:nroRut>'.$nroRut.'</req:nroRut>
        </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaSegmentosTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaSegmentosTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaSegmentosTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0){

      $data = array(
          'retorno' => $retorno,
          'descRetorno' => $descRetorno,
          'descActividad' => (string)$xml->Body->DATA->response->segmentoCliente->descripcionActividad,
          'nameActividad' => (string)$xml->Body->DATA->response->segmentoCliente->nombreActividad,
          'descSegmento' => (string)$xml->Body->DATA->response->segmentoCliente->descripcionSegmento,
          'nameSegmento' => (string)$xml->Body->DATA->response->segmentoCliente->nombreSegmento
      );

    } else {

      $data["retorno"] = $retorno;
      $data["descRetorno"] = $descRetorno;

    }

    return($data);
}

private function print_eventlog($data) {

$fp = fopen(SHOW_NAME_LOGFILE.date('Y-m-d').'.log', 'a');
$data = ">>>>>> " . $data ." <<<<<<<" . PHP_EOL;
fwrite($fp, $data);
fclose($fp);

}

private function get_ConsultaDatosContactoTC($nroRut, $contrato, $flg_flujo, $username){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaDatosContactoTC]"; $dataResponse = array();
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosContactoTC/Req-v2019.12">
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

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosContactoTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosContactoTC, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);

    }

    $eval = eval_response_core($soap["xmlString"], "retorno", WS_ConsultaCuposTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);
    }

    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;
    $data["xmlDocument"] = $eval["xmlDocument"];

    put_logevent($soap, SOAP_OK);

    return($data);

}

private function get_ConsultaTransaccionesTC($nroTcv, $contrato, $flg_flujo, $dateBegin, $dateEnd, $typeSkill){

    $username = $this->session->userdata("username"); $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaTransaccionesTC]";
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaTransaccionesTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:PAN>'.$nroTcv.'</req:PAN>
          <req:CONTRATO>'.$contrato.'</req:CONTRATO>
          <req:FECHA_DESDE>'.$dateBegin.'</req:FECHA_DESDE>
          <req:FECHA_HASTA>'.$dateEnd.'</req:FECHA_HASTA>
          <req:COD_TX>'.$typeSkill.'</req:COD_TX>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaTransaccionesTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaTransaccionesTC, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);

    }

    $eval = eval_response_core($soap["xmlString"], "DATA", WS_ConsultaTransaccionesTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);
    }

    $data["retorno"] = $eval["retorno"];
    $data["descRetorno"] = $eval["descRetorno"];
    $data["xmlDocument"] = $eval["xmlDocument"];

    put_logevent($soap, SOAP_OK);

    return ($data);

}

private function get_ConsultaSegurosContratados($nroRut, $contrato, $comercio, $username){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaSegurosContratados]"; $dataResponse = array();
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:nroRut>'.$nroRut.'</req:nroRut>
         <req:comercio>'.$comercio.'</req:comercio>
         <req:contrato>'.$contrato.'</req:contrato>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaSegurosContratados;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaSegurosContratados, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);

    }

    $eval = eval_response_core($soap["xmlString"], "cabeceraSalida", WS_ConsultaSegurosContratados);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);
    }

    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;
    $data["xmlDocument"] = $eval["xmlDocument"];

    put_logevent($soap, SOAP_OK);

    return ($data);
}


private function get_ConsultaSegurosNoContratados($nroRut, $comercio, $username){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaSegurosContratados]"; $dataResponse = array();
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:nroRut>'.$nroRut.'</req:nroRut>
          <req:comercio>'.$comercio.'</req:comercio>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaSegurosNoContratados;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaSegurosNoContratados, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);

    }

    $eval = eval_response_core($soap["xmlString"], "retorno", WS_ConsultaCuposTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);
    }

    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;
    $data["xmlDocument"] = $eval["xmlDocument"];

    put_logevent($soap, SOAP_OK);

    return ($data);

}


private function get_ConsultaAutorizacionesTC($dataInput){

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaAutorizacionesTC]";
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaAutorizacionesTC/Req-v2020.01">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:pan>'. $dataInput["nroTcv"] .'</req:pan>
          <req:contrato>'. $dataInput["contrato"] .'</req:contrato>
          <req:fechaDesde>'. $dataInput["dateBegin"] .'</req:fechaDesde>
          <req:fechaHasta>'. $dataInput["dateEnd"] .'</req:fechaHasta>
          <req:comercio>'. $dataInput["comercio"]. '</req:comercio>
          <req:producto>'. $dataInput["producto"]. '</req:producto>
          <req:FLAG_FLUJO>'. $dataInput["flg_flujo"] .'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaAutorizacionesTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaAutorizacionesTC, WS_Timeout, $Request, WS_ToXml, $dataInput["username"]);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);

    }

    $eval = eval_response_core($soap["xmlString"], "DATA", WS_ConsultaAutorizacionesTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;
    $data["xmlDocument"] = $eval["xmlDocument"];

    put_logevent($soap, SOAP_OK);
    return ($data);

}

private function get_ConsultaCarteraVencidaTC($nroRut, $comercio, $username){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaCarteraVencidaTC]";

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:rut>'.$nroRut.'</req:rut>
          <req:comercio>'.$comercio.'</req:comercio>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaCarteraVencidaTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaCarteraVencidaTC, WS_Timeout, $Request, WS_ToXml, $username);

    if($soap["codErrorSOAP"]!=0) {

        $value["retorno"] = $soap["codErrorSOAP"];
        $value["descRetorno"] = $soap["msgErrorSOAP"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);

    }

    $eval = eval_response_core($soap["xmlString"], "cabeceraSalida", WS_ConsultaCarteraVencidaTC);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"].$serviceName;
        put_logevent($soap, SOAP_ERROR);

        $data = $value;
        return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0){

        $data = array('retorno' => $retorno,
            'descRetorno' => $descRetorno,
            'capitalVencido' => (string)$xml->Body->DATA->response->capitalVencido,
            'capitalVigente' => (string)$xml->Body->DATA->response->capitalVigente,
            'cargosCobranzaExterna' => (string)$xml->Body->DATA->response->cargosCobranzaExterna,
            'costasJudiciales' => (string)$xml->Body->DATA->response->costasJudiciales,
            'empresaCobranzaJudicial' => (string)$xml->Body->DATA->response->empresaCobranzaJudicial,
            'fechaIngresoCartVenc' => (string)$xml->Body->DATA->response->fechaIngresoCartVenc,
            'fechaEliminacionDicom' => (string)$xml->Body->DATA->response->fechaEliminacionDicom,
            'fechaMora' => (string)$xml->Body->DATA->response->fechaMora,
            'fechaUltimoAbono' => (string)$xml->Body->DATA->response->fechaUltimoAbono,
            'gastosIngresosCartVenc' => (string)$xml->Body->DATA->response->gastosIngresosCartVenc,
            'idCuenta' => (string)$xml->Body->DATA->response->idCuenta,
            'interesDevengadoALaFecha' => (string)$xml->Body->DATA->response->interesDevengadoALaFecha,
            'interesVencidoCapitalizado' => (string)$xml->Body->DATA->response->interesVencidoCapitalizado,
            'montoIngresadoACartVenc' => (string)$xml->Body->DATA->response->montoIngresadoACartVenc,
            'montoUltimoAbono' => (string)$xml->Body->DATA->response->montoUltimoAbono,
            'totalMontoAbonado' => (string)$xml->Body->DATA->response->totalMontoAbonado,
            'deudaVencidaALaFecha' => (string)$xml->Body->DATA->response->deudaVencidaALaFecha);
    } else {

          $data = array('retorno' => $retorno,
                'descRetorno' => $descRetorno);
    }

    put_logevent($soap, SOAP_OK);

    return ($data);
}

private function get_ConsultaDeudaClienteTC($dataInput){

    $nroRut = str_replace(' ', '', $dataInput["nroRut"]); $nroRut = str_replace('.', '', $nroRut); 
    $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $data = array(); $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaDeudaClienteTC]";
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDeudaClienteTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
        <req:PAN>'. $dataInput["nroTcv"] .'</req:PAN>
        <req:CONTRATO>'. $dataInput["contrato"] .'</req:CONTRATO>
        <req:RUT>'. $nroRut .'</req:RUT>
        <req:CLIENTE_COMERCIO>'. $dataInput["comercio"] .'</req:CLIENTE_COMERCIO>
        <req:PRODUCTO>'. $dataInput["producto"] .'</req:PRODUCTO>
        <req:FLAG_FLUJO>'.$dataInput["flg_flujo"].'</req:FLAG_FLUJO>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDeudaClienteTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDeudaClienteTC, WS_Timeout, $Request, WS_ToXml, $dataInput["username"]);

    $Request = array( "soap" => $soap, "tagName" => "Registro", "serviceName" => WS_ConsultaDeudaClienteTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return($data);
    }

    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno==0){

        $data = array('retorno' => $retorno,
            'descRetorno' => $descRetorno,
            'deudaActual' => (string)$xml->Body->DATA->Registro->deudaActual,
            'interesesCorrientes' => (string)$xml->Body->DATA->Registro->interesesCorrientes,
            'interesesMora' => (string)$xml->Body->DATA->Registro->interesesMora,
            'montoEnMora' => (string)$xml->Body->DATA->Registro->montoEnMora,
            'montoPagado' => (string)$xml->Body->DATA->Registro->montoPagado,
            'pagoDelMesFacturado' => (string)$xml->Body->DATA->Registro->pagoDelMesFacturado,
            'pagoMinimo' => (string)$xml->Body->DATA->Registro->pagoMinimo);

    }else{

        $data = array('retorno' => $retorno,
            'descRetorno' => $descRetorno);
    }

    return ($data);
}

public function get_TransaccionesTC() {

    $return = check_session("");

    $data = array(); $indice=0;
    $nroTcv = $this->session->userdata('nroTcv');
    $flg_flujo = $this->session->userdata('flg_flujo');
    $contrato = $this->session->userdata('contrato');

    $typeSkill=$this->input->post("typeSkill");
    $dateBegin=$this->input->post("dateBegin");
    $dateEnd=$this->input->post("dateEnd");

    $retorno=COD_ERROR_INIT; $descRetorno=MSG_ERROR_INIT;

    if($flg_flujo == NULL or $nroTcv == NULL){
        $data['dataError'] = array('session_empty' => TRUE);
        $data['dataTRX'] = array();
        $data['dataCuenta'] = array();
    }else{
        $session_empty = FALSE;
        $nroTcv = str_replace('-', '', $nroTcv);
        $dateBegin = str_replace('/', '-', $dateBegin);
        $dateEnd = str_replace('/', '-', $dateEnd);

        if(strlen($dateBegin)>0){$dateBegin = $dateBegin.' 00:00:00';}
        if(strlen($dateEnd)>0){$dateEnd = $dateEnd.' 00:00:00';}

        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
        $contrato = $result["contrato"];

        $htmlCuotas = ""; $htmlPagos = ""; $htmlVentas = ""; $htmlCargos = ""; $htmlDevolucion = "";
        $result = $this->get_ConsultaTransaccionesTC($nroTcv, $contrato, $flg_flujo, $dateBegin, $dateEnd, $typeSkill);

        if($result["retorno"]==0){

            $xml = $result["xmlDocument"];
            if($typeSkill=="777" OR $typeSkill=="000"){
                $htmlCuotas = '<table class="table table-striped table-bordered" border="0" id="tabCuotas">
                        <thead>
                        <tr data-toggle="tooltip" data-placement="top" title="Posiciona el Mouse sobre la columna que desea orderar y CLICK para ordenar">
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,4)"><strong>Origen TX</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(1,4)"><strong>Comercio</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(2,4)><strong>Local</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(3,4)><strong>Fecha</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(4,4)><strong>Descripci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(5,4)><strong>N&#250;mero Operaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(6,4)><strong>C&#243;digo Autorizaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(7,4)><strong>Monto Contado</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(8,4)><strong>Monto Cr&#233;dito</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(9,4)><strong>Nº Cuotas</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(10,4)><strong>Monto Neto</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(11,4)><strong>Monto Inter&#233;s</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(12,4)><strong>Monto Impuesto</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(13,4)><strong>Monto Cuota</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(14,4)><strong>Fecha Venc.</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(15,4)><strong>Tipo TX</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(16,4)><strong>Meses Dif.</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(17,4)><strong>Fecha Proceso</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(18,4)><strong>Estado TX</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(19,4)><strong>Estado Concil.</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(20,4)><strong>Desc. T-H</strong></td>
                        </tr>
                    </thead><tbody>';

                foreach ($xml->Body->DATA as $recordTRX) {
                    foreach ($recordTRX as $nodo) {

    $fechaHora = substr($nodo->fechaHora,6,4)."-".substr($nodo->fechaHora,3,2)."-".substr($nodo->fechaHora,0,2)." ".substr($nodo->fechaHora,11,5);
    $fechaVencimiento = substr($nodo->fechaVencimiento,6,4)."-".substr($nodo->fechaVencimiento,3,2)."-".substr($nodo->fechaVencimiento,0,2);
    $fechaProceso = substr($nodo->fechaProceso,6,4)."-".substr($nodo->fechaProceso,3,2)."-".substr($nodo->fechaProceso,0,2);

                        if($nodo->comercio!="" AND (string)$nodo->codTx=="777"){
                            if($nodo->tipoTx=="D"){
                                $descTipoTx = "NORMAL";
                            }else{
                                $descTipoTx = "REVERSA";
                            }
                            if($nodo->estadoConciliacion=="C"){
                                $descEstadoConciliacion = "CONCILIADA";
                            }else{
                                $descEstadoConciliacion = "";
                            }
                            if($nodo->estadoTx=="S"){
                                $descEstadoTx = "FACTURADO";
                            }else{
                                $descEstadoTx = "NO FACTURADO";
                            }
                            if($nodo->descTH=="TI"){
                                $descDescTH = "TITULAR";
                            }else{
                                $descDescTH = "";
                            }
                            $htmlCuotas = $htmlCuotas.'
                                <tr>
                                    <td scope="col" class="text-center">'.$nodo->origenTx.'</td>
                                    <td scope="col" class="text-center">'.$nodo->nombreComercioOp.'</td>
                                    <td scope="col" class="text-center">'.$nodo->codLocal.'</td>
                                    <td scope="col" class="text-center" nowrap>'.$fechaHora.'</td>
                                    <td scope="col" class="text-center">'.$nodo->descripcion.'</td>
                                    <td scope="col" class="text-center">'.$nodo->numOperacion.'</td>
                                    <td scope="col" class="text-center">'.$nodo->codigoDeAutorizacion.'</td>
                                    <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoContado,0,',','.').'</strong></td>
                                    <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoCredito,0,',','.').'</strong></td>
                                    <td scope="col" class="text-center">'.$nodo->numCuotas.'</td>
                                    <td scope="col" class="text-center">'.MSG_ATRIBUTO_PENDIENTE.'</td>
                                    <td scope="col" class="text-center">'.MSG_ATRIBUTO_PENDIENTE.'</td>
                                    <td scope="col" class="text-center">'.MSG_ATRIBUTO_PENDIENTE.'</td>
                                    <td scope="col" class="text-center">'.MSG_ATRIBUTO_PENDIENTE.'</td>
                                    <td scope="col" class="text-center" nowrap>'.$fechaVencimiento.'</td>
                                    <td scope="col" class="text-center">'.$descTipoTx.'</td>
                                    <td scope="col" class="text-center">'.$nodo->mesDiferido.'</td>
                                    <td scope="col" class="text-center" nowrap>'.$fechaProceso.'</td>
                                    <td scope="col" class="text-center">'.$descEstadoTx.'</td>
                                    <td scope="col" class="text-center">'.$descEstadoConciliacion.'</td>
                                    <td scope="col" class="text-center">'.$descDescTH.'</td>
                                </tr>';
                        }
                    }
                }
                $htmlCuotas = $htmlCuotas.'</tbody></table>';
            }

            if($typeSkill=="888" OR $typeSkill=="000"){

                $htmlDevolucion = '<table class="table table-striped table-bordered" border="0" id="tabDevolucion">
                    <thead>
                        <tr data-toggle="tooltip" data-placement="top" title="Posiciona el Mouse sobre la columna que desea orderar y CLICK para ordenar">
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,3)"><strong>Fecha</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(1,3)"><strong>Hora</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(2,3)"><strong>N&#250;mero Operaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(3,3)"><strong>C&#243;digo Autorizaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(4,3)"><strong>Descripci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(5,3)"><strong>Monto Transacci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(6,3)"><strong>Nº Local</strong></td>
                        </tr>
                    </thead><tbody>';

                foreach ($xml->Body->DATA as $recordTRX) {
                    foreach ($recordTRX as $nodo) {

    $fechaHora = substr($nodo->fechaHora,6,4)."-".substr($nodo->fechaHora,3,2)."-".substr($nodo->fechaHora,0,2)." ".substr($nodo->fechaHora,11,5);

                        if($nodo->comercio!="" AND (string)$nodo->codTx=="888"){
                            $htmlDevolucion = $htmlDevolucion.'
                                <tr>
                                    <td scope="col" class="text-center" nowrap>'.$fechaHora.'</td>
                                    <td scope="col" class="text-center" nowrap>'.substr($nodo->fechaHora,11,8).'</td>
                                    <td scope="col" class="text-center">'.$nodo->numOperacion.'</td>
                                    <td scope="col" class="text-center">'.$nodo->codigoDeAutorizacion.'</td>
                                    <td scope="col" class="text-center">'.$nodo->descripcion.'</td>
                                    <td scope="col" class="text-center"><strong>$'.number_format((float)$nodo->montoLiquido,0,',','.').'</strong></td>
                                    <td scope="col" class="text-center">'.$nodo->local.'</td>
                                </tr>';
                        }
                    }
                }
                $htmlDevolucion = $htmlDevolucion . '</tbody></table>';
            }

            if($typeSkill=="005" OR $typeSkill=="000"){
                $htmlPagos = '<table class="table table-striped table-bordered" border="0" id="tabPagos">
                    <thead>
                        <tr data-toggle="tooltip" data-placement="top" title="Posiciona el Mouse sobre la columna que desea orderar y CLICK para ordenar">
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,2)"><strong>Cartera</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(1,2)"><strong>Origen TX</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(2,2)"><strong>Comercio</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(3,2)"><strong>Nº Local</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(4,2)"><strong>Fecha</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(5,2)"><strong>Descripci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(6,2)"><strong>N&#250;mero Operaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(7,2)"><strong>C&#243;digo Autorizaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(8,2)"><strong>Monto Pago</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(9,2)"><strong>Fecha Proceso</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,2)"><strong>Fecha Venc</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,2)"><strong>Estado TX</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,2)"><strong>Estado Concil.</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,2)"><strong>Desc. T-H</strong></td>
                        </tr>
                    </thead><tbody>';

                foreach ($xml->Body->DATA as $recordTRX) {
                    foreach ($recordTRX as $nodo) {

    $fechaHora = substr($nodo->fechaHora,6,4)."-".substr($nodo->fechaHora,3,2)."-".substr($nodo->fechaHora,0,2)." ".substr($nodo->fechaHora,11,5);
    $fechaVencimiento = substr($nodo->fechaVencimiento,6,4)."-".substr($nodo->fechaVencimiento,3,2)."-".substr($nodo->fechaVencimiento,0,2);
    $fechaProceso = substr($nodo->fechaProceso,6,4)."-".substr($nodo->fechaProceso,3,2)."-".substr($nodo->fechaProceso,0,2);

                        if($nodo->comercio!="" AND (string)$nodo->codTx=="005"){
                            if($nodo->estadoConciliacion=="C"){
                                $descEstadoConciliacion = "CONCILIADA";
                            }else{
                                $descEstadoConciliacion = "";
                            }
                            if($nodo->estadoTx=="S"){
                                $descEstadoTx = "FACTURADO";
                            }else{
                                $descEstadoTx = "NO FACTURADO";
                            }
                            if($nodo->descTH=="TI"){
                                $descDescTH = "TITULAR";
                            }else{
                                $descDescTH = "";
                            }
                            $htmlPagos = $htmlPagos.'
                                <tr>
                                    <td scope="col" class="text-center">'.$nodo->cartera.'</td>
                                    <td scope="col" class="text-center">'.$nodo->origenTx.'</td>
                                    <td scope="col" class="text-center">'.$nodo->nombreComercioOp.'</td>
                                    <td scope="col" class="text-center">'.$nodo->codLocal.'</td>
                                    <td scope="col" class="text-center" nowrap>'.$fechaHora.'</td>
                                    <td scope="col" class="text-center">'.$nodo->descripcion.'</td>
                                    <td scope="col" class="text-center">'.$nodo->numOperacion.'</td>
                                    <td scope="col" class="text-center">'.$nodo->codigoDeAutorizacion.'</td>
                                    <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoLiquido,0,',','.').'</strong></td>
                                    <td scope="col" class="text-center"`nowrap>'.$fechaProceso.'</td>
                                    <td scope="col" class="text-center" nowrap>'.$fechaVencimiento.'</td>
                                    <td scope="col" class="text-center">'.$descEstadoTx.'</td>
                                    <td scope="col" class="text-center">'.$descEstadoConciliacion.'</td>
                                    <td scope="col" class="text-center">'.$descDescTH.'</td>
                                </tr>';
                        }
                    }
                }
                $htmlPagos = $htmlPagos.'</tbody></table>';
           }

           if($typeSkill=="999" OR $typeSkill=="000"){
                $htmlCargos = '<table class="table table-striped table-bordered" border="0" id="tabCargos">
                    <thead>
                        <tr data-toggle="tooltip" data-placement="top" title="Posiciona el Mouse sobre la columna que desea orderar y CLICK para ordenar">
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,5)"><strong>Fecha</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(1,5)"><strong>N&#250;mero Operaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(2,5)"><strong>C&#243;digo Autorizaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(3,5)"><strong>Glosa</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(4,5)"><strong>Monto</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(5,5)"><strong>Vencimiento</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(6,5)"><strong>Fecha Proceso</strong></td>
                        </tr>
                    </thead><tbody>';

                foreach ($xml->Body->DATA as $recordTRX) {
                    foreach ($recordTRX as $nodo) {

    $fechaHora = substr($nodo->fechaHora,6,4)."-".substr($nodo->fechaHora,3,2)."-".substr($nodo->fechaHora,0,2)." ".substr($nodo->fechaHora,11,5);
    $fechaVencimiento = substr($nodo->fechaVencimiento,6,4)."-".substr($nodo->fechaVencimiento,3,2)."-".substr($nodo->fechaVencimiento,0,2);
    $fechaProceso = substr($nodo->fechaProceso,6,4)."-".substr($nodo->fechaProceso,3,2)."-".substr($nodo->fechaProceso,0,2);

                        if($nodo->comercio!="" AND (string)$nodo->codTx=="999"){
                            $htmlCargos = $htmlCargos.'
                                <tr>
                                    <td scope="col" class="text-center">'.$fechaHora.'</td>
                                    <td scope="col" class="text-center">'.$nodo->numOperacion.'</td>
                                    <td scope="col" class="text-center">'.$nodo->codigoDeAutorizacion.'</td>
                                    <td scope="col" class="text-center">'.$nodo->descripcion.'</td>
                                    <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoLiquido,0,',','.').'</strong></td>
                                    <td scope="col" class="text-center" nowrap>'.$fechaVencimiento.'</td>
                                    <td scope="col" class="text-center" nowrap>'.$fechaProceso.'</td>
                                </tr>';
                        }
                    }
                }
                $htmlCargos = $htmlCargos.'</tbody></table>';
            }

            if($typeSkill=="001" OR $typeSkill=="009" OR $typeSkill=="014" OR $typeSkill=="102" OR $typeSkill=="000"){
                $htmlVentas = '<table class="table table-striped table-bordered " border="0" id="tabVentas">
                    <thead>
                        <tr data-toggle="tooltip" data-placement="top" title="Posiciona el Mouse sobre la columna que desea orderar y CLICK para ordenar">
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,6)"><strong>Tarjeta</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(1,6)"><strong>Comercio</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(2,6)"><strong>Local</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(3,6)"><strong>Fecha</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(4,6)"><strong>Tasa</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(5,6)"><strong>Descripci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(6,6)"><strong>N&#250;mero Operaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(7,6)"><strong>C&#243;digo Autorizaci&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(8,6)"><strong>Monto L&#237;quido</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(9,6)"><strong>Monto Seguro Vida</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(10,6)"><strong>Monto Seguro Enfer Graves</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(11,6)"><strong>Monto Contado</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(12,6)"><strong>Monto Cr&#233;dito</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(13,6)"><strong>Monto Comisi&#243;n</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(14,6)"><strong>Nº Cuotas</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(16,6)"><strong>Estado TX</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(17,6)"><strong>Fecha Venc.</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(18,6)"><strong>Origen TX</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(19,6)"><strong>Meses Dif.</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(20,6)"><strong>Tipo TX</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(21,6)"><strong>Fecha Proceso</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(22,6)"><strong>Estado Concil.</strong></td>
                            <td scope="col" class="text-center" onclick="Teknodata.sortTable(23,6)"><strong>Desc. T-H</strong></td>
                        </tr>
                    </thead><tbody>';
                foreach ($xml->Body->DATA as $recordTRX) {
                    foreach ($recordTRX as $nodo) {

                    $flg_print = false;
                    if($nodo->comercio!="" AND ( (string)$nodo->codTx=="001" OR (string)$nodo->codTx=="009" OR (string)$nodo->codTx=="014" OR (string)$nodo->codTx=="102")) { $flg_print = true; }

                    if($flg_print){

                        if($flg_flujo=="001"){

                            $fechaHora = substr($nodo->fechaHora,6,4)."-";
                            $fechaHora.= substr($nodo->fechaHora,3,2)."-";
                            $fechaHora.= substr($nodo->fechaHora,0,2)." ".substr($nodo->fechaHora,11,5);
                            $fechaVencimiento = substr($nodo->fechaVencimiento,6,4)."-";
                            $fechaVencimiento.= substr($nodo->fechaVencimiento,3,2)."-";
                            $fechaVencimiento.= substr($nodo->fechaVencimiento,0,2);
                            $fechaProceso = "";

                            $descTipoTx = "NORMAL";
                            $descEstadoConciliacion = "CONCILIADA";
                            if($nodo->estadoTx=="S"){ $descEstadoTx = "FACTURADO"; }else{ $descEstadoTx = "NO FACTURADO"; }
                            $descDescTH = "TITULAR";

                        }else{

                            $fechaHora = substr($nodo->fechaHora,6,4)."-";
                            $fechaHora.= substr($nodo->fechaHora,3,2)."-";
                            $fechaHora.= substr($nodo->fechaHora,0,2)." ".substr($nodo->fechaHora,11,5);
                            $fechaVencimiento = substr($nodo->fechaVencimiento,6,4)."-";
                            $fechaVencimiento.= substr($nodo->fechaVencimiento,3,2)."-";
                            $fechaVencimiento.= substr($nodo->fechaVencimiento,0,2);
                            $fechaProceso = substr($nodo->fechaProceso,6,4)."-".substr($nodo->fechaProceso,3,2)."-".substr($nodo->fechaProceso,0,2);

                            if($nodo->tipoTx=="D"){ $descTipoTx = "NORMAL"; }else{ $descTipoTx = "REVERSA"; }
                            if($nodo->estadoConciliacion=="C"){ $descEstadoConciliacion = "CONCILIADA"; }else{ $descEstadoConciliacion = ""; }
                            if($nodo->estadoTx=="S"){ $descEstadoTx = "FACTURADO"; }else{ $descEstadoTx = "NO FACTURADO"; }
                            if($nodo->descTH=="TI"){ $descDescTH = "TITULAR"; }else{ $descDescTH = ""; }
                        }

                        $htmlVentas = $htmlVentas.'
                            <tr>
                                <td scope="col" class="text-center">'. '****-****-****-' . substr($nodo->pan,12,4) . '</td>
                                <td scope="col" class="text-center">'.$nodo->nombreComercioOp.'</td>
                                <td scope="col" class="text-center">'.$nodo->codLocal.'</td>
                                <td scope="col" class="text-center" nowrap>'.$fechaHora.'</td>
                                <td scope="col" class="text-center">'.$nodo->tasa.'%</td>
                                <td scope="col" class="text-center">'.$nodo->descripcion.'</td>
                                <td scope="col" class="text-center">'.$nodo->numOperacion.'</td>
                                <td scope="col" class="text-center">'.$nodo->codigoDeAutorizacion.'</td>
                                <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoLiquido,0,',','.').'</strong></td>
                                <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoSeguroVida,0,',','.').'</strong></td>
                                <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoSeguroEnfermedadesGraves,0,',','.').'</strong></td>
                                <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoContado,0,',','.').'</strong></td>
                                <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoCredito,0,',','.').'</strong></td>
                                <td scope="col" class="text-right"><strong>$'.number_format((float)$nodo->montoComision,0,',','.').'</strong></td>
                                <td scope="col" class="text-center">'.$nodo->numCuotas.'</td>
                                <td scope="col" class="text-center">'.$descEstadoTx.'</td>
                                <td scope="col" class="text-center" nowrap>'.$fechaVencimiento.'</td>
                                <td scope="col" class="text-center">'.$nodo->origenTx.'</td>
                                <td scope="col" class="text-center">'.$nodo->mesDiferido.'</td>
                                <td scope="col" class="text-center">'.$descTipoTx.'</td>
                                <td scope="col" class="text-center" nowrap>'.$fechaProceso.'</td>
                                <td scope="col" class="text-center">'.$descEstadoConciliacion.'</td>
                                <td scope="col" class="text-center">'.$descDescTH.' </td>
                            </tr>';

                        } // end -> $flg_print
                    } // end -> foreach
                    } // end -> foreach
            }
            $htmlVentas = $htmlVentas.'</tbody></table>';
        }

        $data['dataError'] = array('session_empty' => FALSE);

    }
    $data['htmlCuotas'] = $htmlCuotas;
    $data['htmlPagos'] = $htmlPagos;
    $data['htmlVentas'] = $htmlVentas;
    $data['htmlDevolucion'] = $htmlDevolucion;
    $data['htmlCargos'] = $htmlCargos;
    $data['retorno'] = $result["retorno"];
    $data['descRetorno'] = $result["descRetorno"];
    echo json_encode($data);
}

public function put_ActualizaDatosContactoPhone(){

    $return = check_session("");

    $data = array();
    $nroRut=$this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');

    $typePhoneSkill=$this->input->post("typePhoneSkill");
    $usePhoneSkill=$this->input->post("usePhoneSkill");
    $numberPhone=$this->input->post("numberPhone");
    $typePhone=$this->input->post("typePhone");
    $usePhone=$this->input->post("usePhone");

    $nroRut = str_replace(' ', '', $nroRut); $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut);
    $nroRut = substr($nroRut, 0, -1); $valPhone = array();

    if($typePhoneSkill=="MOVIL"){
        $valPhone = get_ValidatePhoneMobile($numberPhone);
    }else{
        $valPhone = get_ValidatePhonePermanent($numberPhone);
    }

    if($typePhone==""){

        if($typePhoneSkill=="FIJO"){ $typePhone = "HOME"; }
        if($typePhoneSkill=="MOVIL"){ $typePhone = "MOBILE"; }

    }

    if($usePhone==""){

        if($usePhoneSkill=="COBRANZA"){ $usePhone = "COB"; }
        if($usePhoneSkill=="LABORAL"){ $usePhone = "BUS"; }
        if($usePhoneSkill=="PARTICULAR"){ $usePhone = "HOM"; }
        if($usePhoneSkill=="RECADO"){ $usePhone = "ASS"; }
        if($usePhoneSkill=="CLUB"){ $usePhone = "CLB"; }
        if($usePhoneSkill=="CMC"){ $usePhone = "CMC"; }
    }

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
    /* End Consulta desde Session CallWSSolventa.get_client() */


    if($valPhone['retorno']==0){

        $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ActualizaDatosContactoTC/Req-v2019.12">
           <soapenv:Header/>
           <soapenv:Body>
              <req:DATA>
                 <req:NRO_RUT>'.$nroRut.'</req:NRO_RUT>
                 <req:CONTRATO>'.$contrato.'</req:CONTRATO>
                 <req:TIPO_CONTACTO>FON</req:TIPO_CONTACTO>
                 <req:USO>'.$usePhone.'</req:USO>
                 <req:PUNTO_CONTACTO>'.$numberPhone.'</req:PUNTO_CONTACTO>
                 <req:TIPO_FONO>'.$typePhone.'</req:TIPO_FONO>
                 <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
              </req:DATA>
           </soapenv:Body>
        </soapenv:Envelope>';

        $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaDatosContactoTC;
        $soap = get_SOAP($EndPoint, WS_Action_ActualizaDatosContactoTC, WS_Timeout, $Request, WS_ToXml, $this->session->userdata("username"));

        $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ActualizaDatosContactoTC);
        $eval = ws_EVAL_SOAP($Request);

        if($eval["retorno"]!=0){

            $data["retorno"] = $eval["retorno"];
            $data["descRetorno"] = $eval["descRetorno"];

        }else{

            $xml = $eval["xmlDocument"];

            $data['retorno'] = (int)$xml->Body->DATA->retorno;
            $data['descRetorno'] = (string)$xml->Body->DATA->descRetorno;
        }

    }else{

        $data['retorno'] = $valPhone['retorno'];
        $data['descRetorno'] = $valPhone['descRetorno'];
    }

    $data['typePhone'] = $typePhone;
    $data['usePhone'] = $usePhone;
    echo json_encode($data);
}

public function put_ActualizaDatosContactoEmail(){

    $return = check_session("");

    $this->form_validation->set_rules('mailbox', 'Correo Electrónico', 'required|min_length[3]|valid_email|trim');
    $this->form_validation->set_rules('sendMailboxSkill', 'Tipo Despacho', 'required');
    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $data = array();
    $nroRut=$this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');

    $typeEmailSkill=$this->input->post("typeEmailSkill");
    $mailbox=$this->input->post("mailbox");
    $typeEmail=$this->input->post("typeEmail");
    $useEmail=$this->input->post("useEmail");
    $sendMailboxSkill=$this->input->post("sendMailboxSkill");

    if($typeEmail==""){
        if($typeEmailSkill=="LABORAL") {
            $typeEmail = "HOME";
            $useEmail = "ASS";
        }else{
            $typeEmail = "HOME";
            $useEmail = "HOM";
        }
    }

    $nroRut = str_replace(' ', '', $nroRut); $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut);
    $nroRut = substr($nroRut, 0, -1); $retorno = COD_ERROR_INIT;

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
            $contrato = $result["contrato"];
    /* End Consulta desde Session CallWSSolventa.get_client() */

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ActualizaDatosContactoTC/Req-v2019.12">
       <soapenv:Header/>
       <soapenv:Body>
          <req:DATA>
             <req:NRO_RUT>'.$nroRut.'</req:NRO_RUT>
             <req:CONTRATO>'.$contrato.'</req:CONTRATO>
             <req:TIPO_CONTACTO>EMA</req:TIPO_CONTACTO>
             <req:USO>'.$useEmail.'</req:USO>
             <req:PUNTO_CONTACTO>'.strtolower($mailbox).'</req:PUNTO_CONTACTO>
             <req:TIPO_FONO>'.$typeEmail.'</req:TIPO_FONO>
             <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
          </req:DATA>
       </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaDatosContactoTC;
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaDatosContactoTC, WS_Timeout, $Request, WS_ToXml, $this->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ActualizaDatosContactoTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

    }else{

      $xml = $eval["xmlDocument"];

      $data["retorno"] = (int)$xml->Body->DATA->retorno;
      $data["descRetorno"] = (string)$xml->Body->DATA->descRetorno;
    }

    echo json_encode($data);
}

public function put_BlockingCreditCard(){

    $return = check_session("");

    $this->form_validation->set_rules('number_credit_card', 'Número Tarjeta de Crédito', 'required|trim');
    $this->form_validation->set_rules('name_bloq_credit_card', 'Descripción Bloqueo', 'required|trim');
    $this->form_validation->set_rules('code_bloq_credit_card', 'Código Bloqueo', 'required|trim');
    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $username = $this->session->userdata("username");
    $fieldRequest = array(
      "number_credit_card" => $this->input->post("number_credit_card"),
      "code_bloq_credit_card" => $this->input->post("code_bloq_credit_card"),
      "name_bloq_credit_card" => $this->input->post("name_bloq_credit_card"),
      "username" => $username);

    $result = ws_PUT_BlockingCreditCard($fieldRequest);
    echo json_encode($result);
}

public function put_RequestReprintCreditCard(){

    $return = check_session("");

    $username = $this->session->userdata("username");

    $this->form_validation->set_rules('number_credit_card', 'Número Tarjeta de Crédito', 'required|trim');
    $this->form_validation->set_rules('name_bloq_credit_card', 'Descripción Bloqueo', 'required|trim');
    $this->form_validation->set_rules('code_bloq_credit_card', 'Código Bloqueo', 'required|trim');
    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = $this->session->userdata("nroRut");
    $dgvRut = substr($nroRut, -1);
    $nroRut = str_replace(' ', '', $nroRut); $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $local = (string)$this->session->userdata("id_office");
    $nombrevend = $this->session->userdata("username");
    $rutvend = $this->session->userdata("rut_number"); $dgvvend = $this->session->userdata["rut_validation"];

    if($this->input->post("code_bloq_credit_card")=="13"){
        $indaccion = "0";
        $origen = "REPOSICION";
        $cod_producto = "T";
    }else{
        $indaccion = "0";
        $origen = "REIMPRESION";
        $cod_producto = "T";
    }

    $data = array(
      'digitov'=>$dgvRut,
      'fecha'=>date("Y-m-d"),
      'hora'=>date("His"),
      'local'=>$local,
      'nombrevend'=>$nombrevend,
      'rut'=>$nroRut,
      'rutvend'=>$rutvend."-".$dgvvend,
      'modtransac'=>"SOLICITUD " . $origen . " PLASTICO",
      'nombres'=>$this->session->userdata("nombre_cliente"),
      'apellidos'=>$this->session->userdata("apellido_cliente"),
      'nrotcv'=>$this->input->post("number_credit_card"),
      'desclave1'=>$this->input->post("relation_credit_card"),
      "desclave2"=>$this->input->post("status_credit_card"),
      "desclave3"=>$this->input->post("name_bloq_credit_card"),
      "desclave4"=>$this->input->post("code_bloq_credit_card"),
      'vbqf'=>'PE',
      'origen'=>$origen,
      'flgnewclient'=>"N",
      'indaccion'=>$indaccion,
      'cod_producto'=>$cod_producto,
    );

    $result = $this->journal->add_ReprintCreditCard($data);

    $data = $result;
    echo json_encode($data);

}


public function put_ActualizaDatosCuenta(){

    $return = check_session("");

    $this->form_validation->set_rules('mailbox', 'Correo Electrónico', 'required|valid_email|trim');
    $this->form_validation->set_rules('sendMailboxSkill', 'Tipo Despacho', 'required');
    $this->form_validation->set_message('valid_email','El atributo %s no es valido!');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $data = array();
    $contrato=$this->session->userdata('contrato');

    $typeEmailSkill=$this->input->post("typeEmailSkill");
    $mailbox=$this->input->post("mailbox");
    $sendMailboxSkill=$this->input->post("sendMailboxSkill");

    if($sendMailboxSkill=="EMAIL"){
        $suscripcionEeccXEmail=1;
    }else{
        $suscripcionEeccXEmail=0;
    }
    $todayDate = date('d').'-'.date('m').'-'.date('Y');
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
     <req:contrato>'.$contrato.'</req:contrato>
     <req:condicionEconomica></req:condicionEconomica>
     <req:diaPago></req:diaPago>
     <req:suscripcionEeccXEmail>'.$suscripcionEeccXEmail.'</req:suscripcionEeccXEmail>
     <req:fechaSuscripcionEeccXEmail>'.$todayDate.' 00:00:00</req:fechaSuscripcionEeccXEmail>
     <req:envioCorrespondencia></req:envioCorrespondencia>
     <req:estadoDeDireccion></req:estadoDeDireccion>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_GrabarDatosCuenta;
    $xmlString = $this->get_core($EndPoint,WS_Action_GrabarDatosCuenta, WS_Timeout, $Request, WS_ToXml);
    if(strpos($xmlString,"Fault")!=FALSE){
        $data['retorno'] = 100;
        $data['descRetorno'] = $xmlString; echo json_encode($data); exit(0);
    }
    $xml = simplexml_load_string($xmlString);
    $xml_valid = ($xml ? true : false);
    if($xml_valid){
        $retorno = (int)$xml->Body->DATA->retorno;
        $descRetorno = (string)$xml->Body->DATA->descRetorno;
    }else{
        $retorno = 100;
        $descRetorno = MSG_ERROR_XML_INVALIDO;
    }

    $data['retorno'] = $retorno;
    $data['descRetorno'] = $descRetorno;

    echo json_encode($data);
}


public function put_ActualizaDatosClienteTC(){

    $return = check_session("");

    $data = array();
    $nroRut=$this->input->post("rutClient");
    $nameClient=$this->input->post("nameClient");
    $lastFatherClient=$this->input->post("lastFatherClient");
    $lastMotherClient=$this->input->post("lastMotherClient");
    $birthDateClient=$this->input->post("birthDateClient");
    $genderSkill=$this->input->post("genderSkill");
    $activityClientSkill=rtrim(ltrim($this->input->post("activityClientSkill")));
    $salaryClient=$this->input->post("salaryClient");
    $companyClient=rtrim(ltrim($this->input->post("companyClient")));
    $flg_flujo = $this->session->userdata('flg_flujo');
    $salaryClient = str_replace(' ', '', $salaryClient); $salaryClient = str_replace('.', '', $salaryClient);
    $nroRut = str_replace(' ', '', $nroRut); $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    if(!$this->solo_letras($nameClient)){
        $data['retorno'] = 10;
        $data['descRetorno'] = "Nombre debe contener solo Letras";
        echo json_encode($data);
        exit(0);
    }
    if(!$this->solo_letras($lastFatherClient)){
        $data['retorno'] = 10;
        $data['descRetorno'] = "Apellido Paterno debe contener solo Letras";
        echo json_encode($data);
        exit(0);
    }
    if(!$this->solo_letras($lastMotherClient)){
        $data['retorno'] = 100;
        $data['descRetorno'] = "Apellido Materno debe contener solo Letras";
        echo json_encode($data);
        exit(0);
    }
    if(!$this->solo_letras($companyClient)){
        $data['retorno'] = 10;
        $data['descRetorno'] = "Empresa debe contener solo Letras";
        echo json_encode($data);
        exit(0);
    }

    $this->form_validation->set_rules('nameClient', 'Nombre Cliente', 'required|min_length[5]|max_length[50]|trim');
    $this->form_validation->set_rules('lastFatherClient', 'Apellido Paterno', 'required|min_length[1]|max_length[30]|trim');
    $this->form_validation->set_rules('lastMotherClient', 'Apellido Materno', 'required|min_length[1]|max_length[30]|trim');
    $this->form_validation->set_rules('birthDateClient','Fecha Nacimiento','required');
    $this->form_validation->set_rules('companyClient','Empresa ','min_length[1]|max_length[50]|trim');
    $this->form_validation->set_message('required','%s es obligatorio');
    $this->form_validation->set_message('numeric','%s debe contener solo números');
    $this->form_validation->set_message('alpha','%s debe estar compuesto solo por letras');
    $this->form_validation->set_message('min_length[1]','%s debe tener más de 1 caracteres');
    $this->form_validation->set_message('max_length[30]','%s debe tener máximo 30 caracteres');
    $this->form_validation->set_message('max_length[50]','%s debe tener máximo 50 caracteres');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ActualizaDatosClienteTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
        <req:NRO_RUT>'.$nroRut.'</req:NRO_RUT>
        <req:NOMBRES>'.ltrim(rtrim($nameClient)).'</req:NOMBRES>
        <req:APELLIDO_PATERNO>'.ltrim(rtrim($lastFatherClient)).'</req:APELLIDO_PATERNO>
        <req:APELLIDO_MATERNO>'.ltrim(rtrim($lastMotherClient)).'</req:APELLIDO_MATERNO>
        <req:FECHA_NACIMIENTO>'.ltrim(rtrim($birthDateClient)).' 00:00:00</req:FECHA_NACIMIENTO>
        <req:SEXO>'.ltrim(rtrim($genderSkill)).'</req:SEXO>
        <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaDatosClienteTC;
    $xmlString = $this->get_core($EndPoint,WS_Action_ActualizaDatosClienteTC, WS_Timeout, $Request, WS_ToXml);
    if(strpos($xmlString,"faultcode")!=FALSE){
        $data['retorno'] = 100; $data['descRetorno'] = $xmlString; echo json_encode($data); exit(0);
    }
    $xml = simplexml_load_string($xmlString);
    $data['retorno'] = (int)$xml->Body->DATA->retorno;$data['descRetorno'] = (string)$xml->Body->DATA->descRetorno;

    if((int)$xml->Body->DATA->retorno==0){
        $this->session->set_userdata('nombre_cliente', ltrim(rtrim($nameClient)));
        $this->session->set_userdata('apellido_cliente', ltrim(rtrim($lastFatherClient)).' '.ltrim(rtrim($lastMotherClient)));
    }

    if(strlen($companyClient)>0 OR (int)$activityClientSkill > 0 OR (float)$salaryClient > 0 ){
        $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
        <soapenv:Header/>
        <soapenv:Body>
           <req:DATA>
              <req:rut>'.$nroRut.'</req:rut>
              <req:comercio>27</req:comercio>
              <req:empresa>'.$companyClient.'</req:empresa>
              <req:renta>'.$salaryClient.'</req:renta>
              <req:actividad>'.$activityClientSkill.'</req:actividad>
           </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

        $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_GrabaDatosAcreditacionTC;
        $xmlString = $this->get_core($EndPoint,WS_Action_GrabaDatosAcreditacionTC, WS_Timeout, $Request, WS_ToXml);
        if(strpos($xmlString,"faultcode")!=FALSE){
            $data['retornoB'] = 100; $data['descRetornoB'] = $xmlString; echo json_encode($data); exit(0);
        }
        $xml = simplexml_load_string($xmlString);
        $data['retornoB'] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;$data['descRetornoB'] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    }else{
        $data['retornoB'] = 0;$data['descRetornoB'] = "No hay cambios en acreditación Cliente!";
    }

    $data['nameClient']  = ltrim(rtrim($nameClient));
    $data['lastNameClient'] = ltrim(rtrim($lastFatherClient)).' '.ltrim(rtrim($lastMotherClient));

    echo json_encode($data);
}

private function solo_letras($cadena)
{
    return preg_match( '/^[a-z ,.]*$/i', $cadena );
}

public function put_ActualizaDatosAdicionalesTC(){

    $return = check_session("");

    $flg_flujo = $this->session->userdata('flg_flujo');
    $contrato = $this->session->userdata('contrato');

    $data = array();
    $nroRut=$this->input->post("masked_rut_additional");
    $nameAddi=$this->input->post("nameAddi");
    $lastFatherAddi=$this->input->post("lastFatherAddi");
    $lastMotherAddi=$this->input->post("lastMotherAddi");
    $birthDateAddi=$this->input->post("birthDateAddi");
    $genderSkillAddi=$this->input->post("genderSkillAddi");
    $relationSkillAddi=$this->input->post("relationSkillAddi");

    $nroRut = str_replace(' ', '', $nroRut); $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    if(!$this->solo_letras($nameAddi)){
        $data['retorno'] = 100;
        $data['descRetorno'] = "Nombre Adicional debe contener solo Letras";
        echo json_encode($data);
        exit(0);
    }
    if(!$this->solo_letras($lastFatherAddi)){
        $data['retorno'] = 100;
        $data['descRetorno'] = "Apellido Paterno Adicional debe contener solo Letras";
        echo json_encode($data);
        exit(0);
    }
    if(!$this->solo_letras($lastMotherAddi)){
        $data['retorno'] = 100;
        $data['descRetorno'] = "Apellido Materno Adicional debe contener solo Letras";
        echo json_encode($data);
        exit(0);
    }
    $this->form_validation->set_rules('nameAddi', 'Nombre Cliente Adicional', 'required|min_length[1]|max_length[50]');
    $this->form_validation->set_rules('lastFatherAddi', 'Apellido Paterno Adicional', 'required|min_length[1]|max_length[30]|trim');
    $this->form_validation->set_rules('lastMotherAddi', 'Apellido Materno Adicional', 'min_length[1]|max_length[30]');
    $this->form_validation->set_rules('birthDateAddi','Fecha Nacimiento Adicional','required');
    $this->form_validation->set_rules('genderSkillAddi','Genero es Requerido','required');
    $this->form_validation->set_message('required','%s es obligatorio');
    $this->form_validation->set_message('alpha','%s debe estar compuesto solo por letras');
    $this->form_validation->set_message('min_length[1]','%s debe tener más de 1 caracteres');
    $this->form_validation->set_message('max_length[30]','%s debe tener máximo 30 caracteres');
    $this->form_validation->set_message('max_length[50]','%s debe tener máximo 50 caracteres');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/GrbDatosAdicionalesCT/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:CONTRATO>'.$contrato.'</req:CONTRATO>
          <req:NRO_RUT_ADI>'.$nroRut.'</req:NRO_RUT_ADI>
          <req:NOMBRES_ADI>'.$nameAddi.'</req:NOMBRES_ADI>
          <req:APELLIDO_PATERNO_ADI>'.$lastFatherAddi.'</req:APELLIDO_PATERNO_ADI>
          <req:APELLIDO_MATERNO_ADI>'.$lastMotherAddi.'</req:APELLIDO_MATERNO_ADI>
          <req:FECHA_NACIMIENTO_ADI>'.$birthDateAddi.' 00:00:00</req:FECHA_NACIMIENTO_ADI>
          <req:SEXO_ADI>'.substr($genderSkillAddi,0,1).'</req:SEXO_ADI>
          <req:RELACION>'.$relationSkillAddi.'</req:RELACION>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaDatosAdicionalesTC;
    $xmlString = $this->get_core($EndPoint,WS_Action_ActualizaDatosAdicionalesTC, WS_Timeout, $Request, WS_ToXml);
    if(strpos($xmlString,"faultcode")!=FALSE){
        $data['retorno'] = 100; $data['descRetorno'] = $xmlString; echo json_encode($data); exit(0);
    }
    $xml = simplexml_load_string($xmlString);
    if(strpos($xmlString,"DATA")!=FALSE){
        $data['retorno'] = (int)$xml->Body->DATA->retorno; $data['descRetorno'] = (string)$xml->Body->DATA->descRetorno;
    }
    echo json_encode($data);
}

public function put_CrearDatosDireccionTC(){

    $return = check_session("");

    $this->form_validation->set_rules('address', 'Nombre Calle dirección cliente', 'required|min_length[5]|max_length[50]|trim');
    $this->form_validation->set_rules('numberAddress', 'Número detalle Calle', 'required|min_length[1]|max_length[5]|trim');
    $this->form_validation->set_rules('numberDepart', 'Número Departamento', 'numeric|min_length[1]|max_length[5]');
    $this->form_validation->set_rules('numberBlock','Número de Block','numeric|min_length[1]|max_length[5]');
    $this->form_validation->set_rules('complement','Complemento ','min_length[5]|max_length[50]');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = $this->session->userdata('nroRut');
    $contrato = $this->session->userdata('contrato');
    $flg_flujo = $this->session->userdata('flg_flujo');

    $data = array();
    $typeAddressSkill=$this->input->post("typeAddressSkill");
    $typeRegionSkill=$this->input->post("typeRegionSkill");
    $typeCitySkill=$this->input->post("typeCitySkill");
    $typeCommuneSkill=$this->input->post("typeCommuneSkill");
    $address=$this->input->post("address");
    $numberAddress=$this->input->post("numberAddress");
    $numberDepart=$this->input->post("numberDepart");
    $numberBlock=$this->input->post("numberBlock");
    $complement=$this->input->post("complement");
    $nroRut = str_replace(' ', '', $nroRut); $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);



    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ActualizaDatosDireccionTC/Req-v2019.12">
       <soapenv:Header/>
       <soapenv:Body>
          <req:DATA>
             <req:RUT>'.$nroRut.'</req:RUT>
             <req:CONTRATO>'.$contrato.'</req:CONTRATO>
             <req:TIPO_DIRECCION>'.$typeAddressSkill.'</req:TIPO_DIRECCION>
             <req:CALLE>'.$address.'</req:CALLE>
             <req:NUMERO_CALLE>'.$numberAddress.'</req:NUMERO_CALLE>
             <req:DEPTO>'.$numberDepart.'</req:DEPTO>
             <req:BLOCK>'.$numberBlock.'</req:BLOCK>
             <req:POBLACION>'.$complement.'</req:POBLACION>
             <req:CIUDAD>'.$typeCitySkill.'</req:CIUDAD>
             <req:COMUNA>'.$typeCommuneSkill.'</req:COMUNA>
             <req:REGION>'.$typeRegionSkill.'</req:REGION>
             <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
          </req:DATA>
       </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaDatosDireccionTC;
    $xmlString = $this->get_core($EndPoint,WS_Action_ActualizaDatosDireccionTC, WS_Timeout, $Request, WS_ToXml);
    if(strpos($xmlString,"faultcode")!=FALSE){
        $data['retorno'] = 100; $data['descRetorno'] = $xmlString; echo json_encode($data); exit(0);
    }
    $xml = simplexml_load_string($xmlString);
    if(strpos($xmlString,"DATA")!=FALSE){
        $data['retorno'] = (int)$xml->Body->DATA->retorno; $data['descRetorno'] = (string)$xml->Body->DATA->descRetorno;
    }
    echo json_encode($data);
}

public function put_ActualizaDatosDireccionTC(){

    $return = check_session("");

    $this->form_validation->set_rules('address', 'Nombre Calle dirección cliente', 'required|min_length[5]|max_length[50]|trim');
    $this->form_validation->set_rules('numberAddress', 'Número detalle Calle', 'required|min_length[1]|max_length[5]|trim');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    $this->form_validation->set_message('min_length','El atributo %s es largo min');
    $this->form_validation->set_message('max_length','El atributo %s es largo max');
    $this->form_validation->set_message('numeric','El atributo %s no es numérico');
    if($this->form_validation->run()==false){
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = $this->session->userdata('nroRut');
    $flg_flujo = $this->session->userdata('flg_flujo');

    /* Begin Consulta desde Session CallWSSolventa.get_client() */
        $result = json_decode( $this->session->userdata("sessDatosCuenta"), true );
        $contrato = $result["contrato"];
    /* End Consulta desde Session CallWSSolventa.get_client() */

    $data = array();
    $typeAddressSkill=$this->input->post("typeAddressSkill");
    $typeRegionSkill=$this->input->post("typeRegionSkill");
    $typeCitySkill=$this->input->post("typeCitySkill");
    $typeCommuneSkill=$this->input->post("typeCommuneSkill");
    $address=$this->input->post("address");
    $numberAddress=$this->input->post("numberAddress");
    $numberDepart=$this->input->post("numberDepart");
    $numberBlock=$this->input->post("numberBlock");
    $complement=$this->input->post("complement");
    $nroRut = str_replace(' ', '', $nroRut); $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    if($flg_flujo=="001"){

      $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ActualizaDatosDireccionTC/Req-v2019.12">
         <soapenv:Header/>
         <soapenv:Body>
            <req:DATA>
               <req:RUT>'.$nroRut.'</req:RUT>
               <req:CONTRATO>'.$contrato.'</req:CONTRATO>
               <req:TIPO_DIRECCION>'.$typeAddressSkill.'</req:TIPO_DIRECCION>
               <req:CALLE>'.$address.'</req:CALLE>
               <req:NUMERO_CALLE>'.$numberAddress.'</req:NUMERO_CALLE>
               <req:DEPTO>'.$numberDepart.'</req:DEPTO>
               <req:BLOCK>'.$numberBlock.'</req:BLOCK>
               <req:POBLACION>'.$complement.'</req:POBLACION>
               <req:CIUDAD>'.$typeCitySkill.'</req:CIUDAD>
               <req:COMUNA>'.$typeCommuneSkill.'</req:COMUNA>
               <req:REGION>'.$typeRegionSkill.'</req:REGION>
               <req:PAIS>152</req:PAIS>
               <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
            </req:DATA>
         </soapenv:Body>
      </soapenv:Envelope>';

    } else {

        $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ActualizaDatosDireccionTC/Req-v2019.12">
           <soapenv:Header/>
           <soapenv:Body>
              <req:DATA>
                 <req:RUT>'.$nroRut.'</req:RUT>
                 <req:CONTRATO>'.$contrato.'</req:CONTRATO>
                 <req:TIPO_DIRECCION>'.$typeAddressSkill.'</req:TIPO_DIRECCION>
                 <req:CALLE>'.$address.'</req:CALLE>
                 <req:NUMERO_CALLE>'.$numberAddress.'</req:NUMERO_CALLE>
                 <req:DEPTO>'.$numberDepart.'</req:DEPTO>
                 <req:BLOCK>'.$numberBlock.'</req:BLOCK>
                 <req:POBLACION>'.$complement.'</req:POBLACION>
                 <req:CIUDAD>'.$typeCitySkill.'</req:CIUDAD>
                 <req:COMUNA>'.$typeCommuneSkill.'</req:COMUNA>
                 <req:REGION>'.$typeRegionSkill.'</req:REGION>
                 <req:PAIS></req:PAIS>
                 <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
              </req:DATA>
           </soapenv:Body>
        </soapenv:Envelope>';
    }

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaDatosDireccionTC;
    $xmlString = $this->get_core($EndPoint,WS_Action_ActualizaDatosDireccionTC, WS_Timeout, $Request, WS_ToXml);
    if(strpos($xmlString,"faultcode")!=FALSE){
        $data['retorno'] = 100; $data['descRetorno'] = $xmlString; echo json_encode($data); exit(0);
    }
    $xml = simplexml_load_string($xmlString);
    if(strpos($xmlString,"DATA")!=FALSE){
        $data['retorno'] = (int)$xml->Body->DATA->retorno; $data['descRetorno'] = (string)$xml->Body->DATA->descRetorno;
    }
    echo json_encode($data);
}

public function get_cities(){

    $return = check_session("");

    $id = $this->input->post("id");
    $data = array();
    $datos = $this->communes->ViewCities($id);
    foreach ($datos as $key) {
        $localidad["id"] = $key["CODIGO_CIUDAD"];
        $localidad["nombre"] = $key["NOMBRE_CIUDAD"];
        $data[] = $localidad;
    }
    echo json_encode($data);
}

public function get_communes(){

    $return = check_session("");

    $idciudad = $this->input->post("idciudad");
    $idregion = $this->input->post("idregion");
    $data = array();
    $datos = $this->communes->ViewCommunes($idciudad,$idregion);
    foreach ($datos as $key) {
        $localidad["id"] = $key["CODIGO_COMUNA"];
        $localidad["nombre"] = $key["NOMBRE_COMUNA"];
        $data[] = $localidad;
    }
    echo json_encode($data);
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

private function get_core($setEndPoint, $setAction, $setTimeOut, $soap, $setTypeReturn)
{
    if($this->session->userdata("username")==""){$username = "session_expired";}else{$username=$this->session->userdata("username");}
    try{

        $time_start = microtime_float();
        $date_start = date("Y-m-d H:i:s");

        $s = new SOAP();
        $s->setEndPoint($setEndPoint); $s->setAction($setAction); $s->setTimeOut($setTimeOut);
        $s->setRequest($soap);
        $s->addCAInfo('/tmp/difarma.crt');
        $s->call();

        $time_end = microtime_float();
        $time = $time_end - $time_start;
        $date_end = date("Y-m-d H:i:s");

        $data = array("date_begin"=>$date_start,
                    "date_end"=> $date_end,
                    "time"=>$time,
                    "username"=>$username,
                    "endPoint"=>$setEndPoint,
                    "action"=>$setAction,
                    "request"=> $soap,
                    "response"=> $s->toXML(),
                    "result"=> "OK"
        );
        $this->db->insert('ta_journal_log_event', $data);

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

        $time_end = microtime_float();
        $time = $time_end - $time_start;
        $date_end = date("Y-m-d H:i:s");

        $data = array("date_begin"=>$date_start,
                    "date_end"=> $date_end,
                    "time"=>$time,
                    "username"=>$username,
                    "endPoint"=>$setEndPoint,
                    "action"=>$setAction,
                    "request"=> $soap,
                    "response"=> $e->getMessage(),
                    "result"=> "OK"
        );
        $this->db->insert('ta_journal_log_event', $data);

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

}
