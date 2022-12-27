<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Collection  extends CI_Controller {


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

    $this->load->model("Parameters_model","parameters");
    $this->load->model("Glossary_model","glossary");
    $this->load->model("Journal_model","journal");
    $this->load->model("Users_model","users");
    $this->load->model("Documents_model","documents");
    $this->load->model("Motivosrechazo_model","motivos");

    $this->load->library(array('Rut', 'Soap', 'form_validation', 'Pdf'));
    $this->load->helper(array('funciones_helper', 'teknodatasystems_helper', 'ws_solventa_helper'));

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}

    date_default_timezone_set('America/Santiago');
}

public function index() {
  if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
  if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }
  $this->session->set_userdata('selector', '4.2.3.1');

  $id_rol = $this->session->userdata("id_rol");

  $todayDate = date("d-m-Y");

  $dataLoad['environment'] = array(
          'id_rol' => $id_rol ,
          'dateBegin' => $todayDate,
          'dateEnd' => $todayDate
      );
  $dataLoad["status"] = $this->parameters->getall_renegotiationStatus();

  $this->load->view('collection/search', $dataLoad);

}

public function search() {

    $return = check_session("4.2.3.1");

    $id_rol = $this->session->userdata("id_rol");
    $todayDate = date("d-m-Y");
    $result = $this->users->motivos->getall_reasonCollection();

    $reasonSelector = "<option value=''>TODOS</option>";
    foreach ($result as $key) {
            $reasonSelector .= "<option value='".$key->KEY."'>".$key->NAME."</option>";
    }

    $value['environment'] = array(
            'reasonSelector' => $reasonSelector,
            'id_rol' => $id_rol ,
            'dateBegin' => "01".substr($todayDate,2),
            'dateEnd' => $todayDate
        );

    $data = $value;
    $this->load->view('collection/search', $data);
}

public function create() {
    if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
    if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }
    $this->session->set_userdata('selector', '4.2.3.2');

    $id_rol = $this->session->userdata("id_rol");
    $id_office = $this->session->userdata("id_office");

    $todayDate = date("d-m-Y");
    $this->session->set_userdata("number_authorizing", NULL);

    $cuotas = $this->glossary->get_REN_cuotas();
    $diferidos = $this->glossary->get_REN_diferidos();

    if(!$cuotas){
      cancel_function(10, "Problema al leer parametros Cuotas Renegociación..!</br></br>Comuniquese con mesa de Ayuda", "");
    }
    if(!$diferidos){
      cancel_function(10, "Problema al leer parametros Cuotas Diferidos..!</br></br>Comuniquese con mesa de Ayuda", "");
    }

    $result = $this->users->motivos->getall_reasonCollection(); $reasonSelector = "";
    foreach ($result as $key) {
            $reasonSelector .= "<option value='".$key->KEY."'>".$key->NAME."</option>";
    }
    $dataLoad['environment'] = array(
            'reasonSelector' => $reasonSelector,
            'id_rol' => $id_rol ,
            'dateCreate' => $todayDate,
            'MINIMO_CUOTAS_REN' => (int)$cuotas->MINIMO,
            'MAXIMO_CUOTAS_REN' => (int)$cuotas->MAXIMO,
            'MINIMO_DIFERIDOS_REN' => (int)$diferidos->MINIMO,
            'MAXIMO_DIFERIDOS_REN' => (int)$diferidos->MAXIMO
        );
    $dataLoad["requestStatus"] = $this->parameters->getall_requestStatus();

    $this->load->view('collection/create', $dataLoad);
}

public function get_collection() {
    if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
    if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }

    $this->form_validation->set_rules('masked_rut_client', 'Número RUT Cliente', 'trim');
    $this->form_validation->set_rules('reasonSelector', 'Motivo Mora ', 'trim');
    $this->form_validation->set_rules('dateBegin', 'Fecha Desde ', 'required|trim');
    $this->form_validation->set_rules('dateEnd', 'Fecha Hasta ', 'required|trim');

    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric','El atributo %s debe ser numerico..');
    if($this->form_validation->run()==false){

        $value["retorno"] = COD_ERROR_INIT;
        $value["descRetorno"] = validation_errors();

        $response["dataResult"] = $value;
        echo json_encode($response);
        exit (0);
    }

    $response = array(); $retorno = COD_ERROR_INIT; $descRetorno = ""; $data = array();

    $result = $this->users->motivos->get_reasonCollectionById($_POST["reasonSelector"]);
    if($result){
        $reason = $result->NAME;
    }else{
        $reason = "";
    }

    $request = array(
        "nroRut" => $_POST["masked_rut_client"],
        "dateBegin" => $_POST["dateBegin"],
        "dateEnd" => $_POST["dateEnd"],
        "reason" => $reason
    );
    $result = ws_GET_Lista_MorasVirtuales($request);

    $dataResponse = $result["htmlCollection"];

    if($result["retorno"]==0){

        $dataResponse = $result["htmlCollection"];

    }else{

        $dataResponse.= '<tbody><tr><td class="text-center" colspan="9"><strong>'.$result["descRetorno"].'</strong></th></tr></tbody>';

    }
    $dataResponse.= '</table>';

    $value["retorno"] = $result["retorno"];
    $value["descRetorno"] = $result["descRetorno"];

    $response["dataResult"] = $value;
    $response["dataResponse"] = $dataResponse;

    echo json_encode($response);
}


public function evaluation_client() {
    if($this->session->userdata("lock")===NULL) { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url(); echo json_encode($data); exit(0); } else { redirect(base_url()); } }
    if($this->session->userdata("lock") == "0") { if( $this->input->is_ajax_request() ) { $data["retorno"] = -1; $data["base_url"] = base_url("dashboard/lock"); echo json_encode($data); exit(0); } else { redirect(base_url("dashboard/lock")); } }

    $nroRut = $_POST["nroRut"]; $username = $this->session->userdata("username");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $eval = validaRUTCL($nroRut);
    if($eval["retorno"]!=0){
        cancel_function(COD_ERROR_INIT, $eval["descRetorno"], "Preste Atención");
    }
    $retorno=COD_ERROR_INIT;

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if($dataHomologador["retorno"]!=0){

        $descRetorno  = $dataHomologador["descRetorno"];
        cancel_function(10, $descRetorno, "");
    }
    $flg_flujo = $dataHomologador["flg_flujo"]; $nroTcv = $dataHomologador["nroTcv"];

    $dataClient = ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username);
    if($dataClient["retorno"]!=0){

      $descRetorno  = $dataClient["descRetorno"];
      cancel_function(10, $descRetorno, "");
    }

    /* Begin Consulta datos cuenta */
    $dataCuenta = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
    if($dataCuenta["retorno"]!=0){

      $descRetorno  = $dataCuenta["descRetorno"];
      cancel_function(10, $descRetorno, "");
    }
    $contrato = (string)$dataCuenta["contrato"];

    $dataInput = array(
        'nroRut' => $nroRut,
        'nroTcv' => $nroTcv,
        'contrato' => $contrato,
        'flg_flujo' => $flg_flujo,
        'username' => $username);

    $result = ws_GET_ConsultaDeudaClienteTC($dataInput);
    if($result["retorno"]==0){

          $montoEnMora = $result["montoEnMora"];
          $value['deudaEnMora'] = "$".number_format((float)$result["montoEnMora"],0,",",".");
          $value["pagoMinimo"] = "$".number_format((float)$result["pagoMinimo"],0,",",".");
          $value["deudaActual"] = "$".number_format((float)$result["deudaActual"],0,",",".");
          $value["pagoDelMesFacturado"] = "$".number_format((float)$result["pagoDelMesFacturado"],0,",",".");
          $amount_deudaActual = (float)$result["deudaActual"];

    } else {

          $montoEnMora = 0;
          $value['deudaEnMora'] = 0;
          $value["pagoMinimo"] = 0;
          $value["deudaActual"] = 0;
          $value["pagoDelMesFacturado"] = 0;
          $amount_deudaActual = 0;
    }

    $htmlCupos = '<table class="table table-striped table-bordered" id="tabCupos">
        <thead>
        <tr>
            <th class="text-center"><strong>Tipo</strong></th>
            <th class="text-center"><strong>Cupo</strong></th>
            <th class="text-center"><strong>Utilizado</strong></th>
            <th class="text-center"><strong>Disponible</strong></th>
        </tr>
        </thead><tbody>';

    $result = ws_GET_ConsultaCuposTC($nroTcv, $contrato, $flg_flujo, $username);
    if($result["retorno"]==0){

        foreach ($result["dataResponse"] as $key) {
              $htmlCupos .= "<tr><td>".$key["descCodigolinea"]."</td>";
              $htmlCupos .= "<td>$".number_format((float)$key["cupo"],0,",",".")."</td>";
              $htmlCupos .= "<td>$".number_format((float)$key["utilizado"],0,",",".")."</td>";
              $htmlCupos .= "<td>$".number_format((float)$key["disponible"],0,",",".")."</td>";
              $htmlCupos .= "</tr>";
        }

    }else{

        $htmlCupos .= "<tr><td colspan='4'>NO REGISTRA CUPOS</td></tr>";
    }
    $htmlCupos .= "</tbody></table>";

/** Begin::CC028:: **/ 
    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $dataCuenta["contrato"],
        "id_channel" => $dataHomologador["flg_flujo"],
        "id_type" => TYPE__PRODUCT_SAV,
        "id_product" => $dataHomologador["id_product"]);

    $result = ws_GET_ConsultaEstadosBloqueo($dataInput);
    if($result["retorno"]==0){

          $value["estadoBloqueo"] = $result["estadoBloqueo"];
          $value["diasMora"] = (int)$result["diasMora"];

    } else {

          $value["estadoBloqueo"] = "";
          $value["diasMora"] = 0;
    }
/** End::CC028:: **/ 

    /* Begin Consulta EECC */
    $fechaProximoVencimiento = "-"; $pagoDelMes = 0; $pagoMinimo = 0;

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

          $fechaProximoVencimiento = $result["fechaProximoVencimiento"];
    }
    /* End Consulta EECC */

    $descripcionTarjeta = ""; $descripcionMarca = "";
    $result = ws_GET_ConsultaDatosTarjetaTC($nroTcv, $contrato, $flg_flujo, $username);
    $datosTarjeta = json_decode($result);

    if($datosTarjeta->retorno==0) {

        foreach ($datosTarjeta->tarjetas as $field) {
            $descripcionTarjeta = $field->descripcion;
            $descripcionMarca = $field->desmarca;
        }

    }

    /*********
      Checking Número Renegociaciones
    **********/
        $dataInput = array(
           "nroRut" => $nroRut,
           "username" => $this->session->userdata("username"),
        );
        $result = ws_GET_CountRenegotiation($dataInput);
        if($result["retorno"]==0){

              $nroReneg = $result["nroReneg"];

        } else {

              $nroReneg = 0;
        }


    $value["comercio"] = "CRUZ VERDE";
    $dataAccount = '<table class="table table-striped table-bordered" id="tabAccount">
        <thead>
        <tr>
            <th class="text-center"><strong>Comercio</strong></th>
            <th class="text-center"><strong>Marca</strong></th>
            <th class="text-center"><strong>Cuenta</strong></th>
            <th class="text-center"><strong>Estado de Cuenta</strong></th>
            <th class="text-center"><strong>Monto Mora</strong></th>
            <th class="text-center"><strong>D&#237;as Mora</strong></th>
            <th class="text-center"><strong>Pr&#243;ximo Vencimiento</strong></th>
            <th class="text-center"><strong>Pago Mes</strong></th>
            <th class="text-center"><strong>Monto M&#237;nimo</strong></th>
            <th class="text-center"><strong>Deuda Actual</strong></th>
            <th class="text-center"><strong>N° Reneg</strong></th>
            <th class="text-center"><strong>Cupos</strong></th>
        </tr>
        </thead><tbody>
        <tr>
        <td class="text-center"><strong>'.$value["comercio"].'</strong></td>
        <td class="text-center"><strong>'.$descripcionMarca.'</strong></td>
        <td class="text-center"><strong>'.$contrato.'</strong></td>
        <td class="text-center"><strong>'.$value["estadoBloqueo"].'</strong></td>
        <td class="text-center"><strong>'.$value["deudaEnMora"].'</strong></td>
        <td class="text-center"><strong>'.$value["diasMora"].'</strong></td>
        <td class="text-center"><strong>'.$fechaProximoVencimiento.'</strong></td>
        <td class="text-center"><strong>'.$value["pagoDelMesFacturado"].'</strong></td>
        <td class="text-center"><strong>'.$value["pagoMinimo"].'</strong></td>
        <td class="text-center"><strong>'.$value["deudaActual"].'</strong></td>
        <td class="text-center"><strong>'.$nroReneg.'</strong></td>
        <td class="text-center"><strong><button type="button" class="btn btn-xs btn-success" onclick="Client.showQuota();"
              <i class="gi gi-zoom_in" title="Ver Detalle"></i>Ver Cupos</button></strong></td>
              </tr></tbody></table>';
    /* End Consulta datos cuenta */



    /*********
      Consulta Datos Contacto del Cliente / Teléfono, Dirección y Correo Electrónico
    **********/

        $dataInput = array(
            "nroRut"=> $nroRut,
            "contrato"=> $contrato,
            "flg_flujo"=> $flg_flujo);
        $result = ws_GET_DataContactClient($dataInput);

        $value["email"] = $result["email"];
        $value["lblDireccion"] = $result["address"];
        $value["phone"] = $result["phone"];


/*****

    $dataContact = ws_GET_DatosContactos($nroRut, $contrato, $flg_flujo, $username);
    if($dataContact["retorno"]==0){

          if($dataContact["emailHome"]!="") { $value["email"] = (string)$dataContact["emailHome"]; }
          else { $value["email"] = (string)$dataContact["emailWork"]; }

          if($dataContact["phoneMobile"]!="") { $value["phone"] = (string)$dataContact["phoneMobile"]; }
          else { $value["phone"] = (string)$dataContact["phoneWork"]; }

    }else{

          $value["email"] = ""; $value["phone"] = "";

    }

    $dataDirecciones = json_decode(ws_GET_ConsultaDatosDireccion($nroRut, $contrato, $flg_flujo, $username));
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

****/


    /* Begin Prepara Retorno Datos Cliente */
    $value["completeNameClient"] = $dataClient["nombreCliente"];
    $value["nameClient"] = $dataClient["nombres"];
    $value["lastnameClient"] = $dataClient["apellidoPaterno"]." ".$dataClient["apellidoMaterno"];

    $value["sexoClient"] = $dataClient["sexo"];
    $value["fechaNacimiento"] = $dataClient["fechaNacimiento"];
    $value["nroserie"] = $dataClient["nroserie"];
    $value["nroTcv"] = $dataHomologador["nroTcv"];
    $value["id_rol"] = $this->session->userdata("id_rol");
    $value["htmlCupos"] = $htmlCupos;

    /* Begin Consulta Seguros Contratados */
    $dataSecure = '<table class="table table-striped table-bordered" id="tabSecure">
        <thead>
        <tr>
            <th class="text-center"><strong>Compa&#241;ia</strong></th>
            <th class="text-center"><strong>Nombre Seguro</strong></th>
            <th class="text-center"><strong>Estado</strong></th>
            <th class="text-center"><strong>Fecha Contrataci&#243;n</strong></th>
            <th class="text-center"><strong>Monto Prima UF</strong></th>
            <th class="text-center"><strong>Monto Prima PESOS</strong></th>
        </tr>
        </thead>';

    $dataInput = array(
      "nroRut" => $nroRut,
      "contrato" => $contrato,
      "comercio" => $comercio,
      "username" => $this->session->userdata("username")
    );

    $montoPrimaUF = 0;
    $result = json_decode(ws_GET_ConsultaSegurosContratados($dataInput));
    if($result->retorno==0){

        $dataSecure.= '<tbody>';
        foreach ($result->seguros as $field) {

            if($field->codigoSeguro=="DESG"){
                $montoPrimaUF = $field->valorPrima;
            }
            $dataSecure.= '<tr>';
            $dataSecure.= '<td align="center">'.$field->empresaAseguradora.'</td>';
            $dataSecure.= '<td align="center">'.$field->nombreSeguro.'</td>';
            $dataSecure.= '<td align="center">'.$field->estadoSeguro.'</td>';
            $dataSecure.= '<td align="center">'.substr($field->fechaAltaBaja,0,10).'</td>';
            $dataSecure.= '<td align="center">'.$field->valorPrima.' '.MASCARA_MONEDA_UF.'</td>';

            $dataInput = array(
                'fechaConsulta' => date('d-m-Y'),
                'username' => $username
            );

            $result = json_decode(ws_GET_ConsultaValorUF($dataInput));
            if($result->retorno==0){

              $montoPrimaCL = (float)$field->valorPrima * (float)$result->valorUF;

            }else{

              $montoPrimaCL = 0;
            }
            $montoPrimaCL = (int)$montoPrimaCL;
            $dataSecure.= '<td align="center">$'.number_format((float)$montoPrimaCL,0,",",".").'</td>';
            $dataSecure.= '</tr>';
        }
        $dataSecure.= '</tbody>';

    } else {

        $dataSecure.= '<tbody>';
        $dataSecure.= '<tr>';
        $dataSecure.= '<td scope="col" colspan="6">NO REGISTRA SEGUROS</td>';
        $dataSecure.= '</tbody>';

    }
    $dataSecure.= '</table>';
    /* End Consulta Seguros Contratados */

    if($montoPrimaUF>0){

        $dataInput = array(
            'fechaConsulta' => date('d-m-Y'),
            'username' => $username
        );
        $montoPrimaCL = 0;
        $result = json_decode(ws_GET_ConsultaValorUF($dataInput));
        if($result->retorno==0){

          $montoPrimaCL = (float)$montoPrimaUF * (float)$result->valorUF;

        }else{

          $descRetorno  = "Atención, Valor UF no esta disponible..";
          cancel_function(10, $descRetorno, "");
        }
        $montoPrimaCL = (int)$montoPrimaCL;

        if((int)$montoPrimaCL<=0){

          $descRetorno  = "Atención, Valor Prima Seguro Desgravamen y Valor UF no puede ser cero..";
          cancel_function(10, $descRetorno, "");
        }

    }else{

        $montoPrimaCL = 0;
    }

    $dateBegin = ""; $dateEnd = ""; $typeSkill = "005";
    /* Begin consulta últimos pagos del cliente */
    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $contrato,
        "flg_flujo" => $flg_flujo,
        "cantidad_pagos" => 3,
        "username" => $username
      );

    $result = ws_GET_ConsultaPagosRene($dataInput);
    $dataPayment = $result["htmlPayment"];
/* End consulta últimos pagos del cliente */

    $result = $this->parameters->getall_renegotiationMontoMora();
    if(!$result){

        $descRetorno = "Parámetro Monto Mora Mínimo y/o Máximo, no definidos<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    }else{

        $amount_is_over_begin = (float)$result->MINIMO;
        $amount_is_over_end = (float)$result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationDiasMora();
    if(!$result){

        $descRetorno = "Parámetro Días Mora Mínimo y/o Máximo, no definidos<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    }else{

        $days_is_over_begin = (int)$result->MINIMO;
        $days_is_over_end = (int)$result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationMontoCuota();
    if(!$result){

        $descRetorno = "Parámetro Monto Cuotas Mínimo y/o Máximo, no definidos<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    }else{
        $amount_quotes_begin = (float)$result->MINIMO;
        $amount_quotes_end = (float)$result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationOpers();
    if(!$result){

        $descRetorno = "Parámetro Número Renegociaciones Mínimo y/o Máximo, no definido<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    }else{
        $number_opers_begin = (int)$result->MINIMO;
        $number_opers_end = (int)$result->MAXIMO;
    }

    $result = $this->parameters->get_quotasByProduct(CODIGO_RENEGOCIACION);
    if(!$result){

        $descRetorno = "Parámetro Número Cuotas Renegociaciones Mínimo y/o Máximo, no definido<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    }else{
        $number_quotes_begin = (int)$result->CUOTAS_MINIMO;
        $number_quotes_end = (int)$result->CUOTAS_MAXIMO;
    }

    $result = $this->parameters->get_deferredByProduct(CODIGO_RENEGOCIACION);
    if(!$result){

        $descRetorno = "Parámetro Número Cuotas Diferidas Renegociaciones Mínimo y/o Máximo, no definido<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    }else{
        $deferred_quotes_begin = (int)$result->CUOTAS_MINIMO;
        $deferred_quotes_end = (int)$result->CUOTAS_MAXIMO;
    }


    $value["dataAccount"] = $dataAccount;
    $value["dataSecure"] = $dataSecure;
    $value["dataPayment"] = $dataPayment;

    $value["flg_flujo"] = $dataHomologador["flg_flujo"];
    $value["retorno"] = $dataClient["retorno"];
    $value["descRetorno"] = $dataClient["descRetorno"];





    /*******
      Checking Collection
    ********/
        $value["warning_message"] = ""; $value["warning_title"] = ""; $value["warning_days"] = 0;
        $value["warning_amount"] = 0; $value["warning_renegotiation"] = 0; $value["warning_reason"] = "";

        $request = array(
            "nroRut" => $nroRut,
            "today" => date("d-m-Y")
        );
        $result = ws_GET_ConsultaMoraVirtual($request);

        if($result["retorno"]==0){

            $today = date("Ymd");
            if($result["dateEnd"]>=$today){

                $value["warning_title"] = "<h2><strong>Aviso Cobranza</strong></h2>";
                $value["warning_message"] = "<h4>Cliente autorizado por ".$result["ejecutivo"]." hasta el ".$result["fechaFinVigencia"]." ";
                $value["warning_message"].= "con motivo: ".$result["motivo"]."</h4>";
                $value["warning_type"] = "N";

                $value["warning_reason"] = $result["motivo"];
                $value["warning_approver"] = $result["retorno"];
                $value["warning_collection"] = $result["retorno"];

            }

        }

        if($value["warning_title"]==""){

            if((float)$amount_deudaActual < $amount_is_over_begin OR (float)$amount_deudaActual > $amount_is_over_end){

                  $value["warning_amount"] = 1;
            }

            if($value["diasMora"] < $days_is_over_begin OR $value["diasMora"] > $days_is_over_end){

                  $value["warning_days"] = 1;
            }

            if($nroReneg >= 2 ){

                  $value["warning_renegotiation"] = 1;
            }

            if($value["warning_days"]==0 AND $value["warning_amount"]==0 AND $value["warning_renegotiation"]==1){

                  $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                  $value["warning_message"] = "<h4>Cliente no cumple politica en Variable: Número Renegociaciones Vigentes <strong>".$nroReneg."</strong>.</h4></br></br>";
                  $value["warning_reason"] = "Cliente no cumple politica en Variable: Número Renegociaciones Vigentes ".$nroReneg;

            }

            if($value["warning_days"]==0 AND $value["warning_amount"]==1 AND $value["warning_renegotiation"]==0){

                  $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                  $value["warning_message"] = "<h4>Cliente no cumple politica en Variable: Deuda <strong>".number_format((float)$amount_deudaActual,0,',','.')."</strong>.</h4></br></br>";
                  $value["warning_reason"] = "Cliente no cumple politica en Variable: Deuda ".number_format((float)$amount_deudaActual,0,',','.');
            }

            if($value["warning_days"]==1 AND $value["warning_amount"]==1 AND $value["warning_renegotiation"]==1){

                  $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                  $value["warning_message"] = "<h4>Cliente no cumple politica en Variable: Días Mora <strong>".$value["diasMora"]."</strong>, Deuda <strong>".number_format((float)$amount_deudaActual,0,',','.')."</strong>, N° Renegociaciones Vigentes <strong>".$nroReneg."</strong></h4></br></br>";
                  $value["warning_reason"] = "Cliente no cumple politica en Variable: Días Mora ".$value["diasMora"].", Deuda ".number_format((float)$amount_deudaActual,0,',','.').", N° Renegociaciones Vigentes ".$nroReneg;
            }

            if($value["warning_days"]==1 AND $value["warning_amount"]==0 AND $value["warning_renegotiation"]==0){

                  $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                  $value["warning_message"] = "<h4>Cliente no cumple politica en Variable: Días Mora <strong>".$value["diasMora"]."</strong>.</h4></br></br>";
                  $value["warning_reason"] = "Cliente no cumple politica en Variable: Días Mora ".$value["diasMora"];
            }

            if($value["warning_days"]==1 AND $value["warning_amount"]==0 AND $value["warning_renegotiation"]==1){

                  $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                  $value["warning_message"] = "<h4>Cliente no cumple politica en Variable: Días Mora <strong>".$value["diasMora"]."</strong>, N° Renegociaciones Vigentes <strong>".$nroReneg."</strong></h4></br></br>";
                  $value["warning_reason"] = "Cliente no cumple politica en Variable: Días Mora ".$value["diasMora"].", N° Renegociaciones Vigentes ".$nroReneg;
            }

            if($value["warning_days"]==1 AND $value["warning_amount"]==1 AND $value["warning_renegotiation"]==0){

                  $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                  $value["warning_message"] = "<h4>Cliente no cumple politica en Variable: Días Mora <strong>".$value["diasMora"]."</strong>, Deuda <strong>".number_format((float)$amount_deudaActual,0,',','.')."</strong></h4></br></br>";
                  $value["warning_reason"] = "Cliente no cumple politica en Variable: Días Mora ".$value["diasMora"].", Deuda <strong>".number_format((float)$amount_deudaActual,0,',','.');
            }

            if($value["warning_days"]==0 AND $value["warning_amount"]==1 AND $value["warning_renegotiation"]==1){

                  $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                  $value["warning_message"] = "<h4>Cliente no cumple politica en Variable: Deuda <strong>".number_format((float)$amount_deudaActual,0,',','.')."</strong>, N° Renegociaciones Vigentes <strong>".$nroReneg."</strong></h4></br></br>";
                  $value["warning_reason"] = "Cliente no cumple politica en Variable: Deuda ".number_format((float)$amount_deudaActual,0,',','.').", N° Renegociaciones Vigentes ".$nroReneg;
            }

            $value["warning_type"] = "E";

        }


    $data = $value;
    echo json_encode($data);

}


public function validate_save_collection() {
    if($this->session->userdata('lock') === NULL) { redirect(base_url()); }
    if($this->session->userdata('lock') == "0"){ redirect(base_url("Dashboard/lock")); }

/* Datos Personales Cliente */
    $this->form_validation->set_rules('number_rut_client', 'Rut Cliente', 'required|trim');
    $this->form_validation->set_rules('dateEnd', 'Fecha Termino', 'required|trim');
    $this->form_validation->set_rules('reason', 'Motivo Mora', 'required|trim');

    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    $result = $this->users->motivos->get_reasonCollectionById($_POST["reason"]);
    if($result){
        $reason = $result->NAME;
    }else{
        $reason = "";
    }

    $data = array(
      'nroRut'=> $_POST["number_rut_client"],
      'dateEnd'=> $_POST["dateEnd"],
      'reason' => $reason
    );

    $result = ws_PUT_Collection($data);
    $data = $result;
    echo json_encode($data);

}



function get_mysqli() { $db = (array)get_instance()->db;
    return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}

}
