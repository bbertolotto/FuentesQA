<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Renegotiation extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

public function __construct()
{
      parent::__construct();

      $models = array(
          'Parameters_model' => 'parameters',
          'Glossary_model' => 'glossary',
          'Journal_model' => 'journal',
          'Users_model' => 'users',
          'Documents_model' => 'documents',
      );
      $library = array('Rut', 'Soap', 'form_validation', 'Pdf');
      $helper = array('funciones_helper', 'teknodatasystems_helper', 'ws_solventa_helper');

      $this->load->model($models);
      $this->load->library($library);
      $this->load->helper($helper);

      $site_lang = $this->session->userdata('site_lang');
      if ($site_lang) {$this->lang->load('header', $this->session->userdata('site_lang'));} else { $this->lang->load('header', 'spanish');}

      date_default_timezone_set('America/Santiago');
}

private function ws_REN_ConsultaEstadosBloqueo($nroRut, $contrato, $flg_flujo){
    $CI = get_instance();

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaEstadosBloqueo]";

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaEstadosBloqueo/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:CONTRATO>'.$contrato.'</req:CONTRATO>
          <req:RUT>'.$nroRut.'</req:RUT>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $codigoRenegociacion = "NO"; $estadoBloqueo = ""; $diasMora = 0; $prioridad = 999; $retorno = COD_ERROR_INIT; $descRetorno = MSG_ERROR_INIT;
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaEstadosBloqueo;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaEstadosBloqueo , WS_Timeout, $Request, WS_ToXml, $this->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_Action_ConsultaEstadosBloqueo);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];
      return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $codigoRenegociacion = "NO"; $diasMora = 0; $estadoBloqueo = ""; $name_block_SAV = "";
    if($retorno==0){
        $prioridad = 999;
        foreach ($xml->Body->DATA as $record) {
            foreach ($record as $nodo) {

                $codigoDeBloqueo = substr((string)$nodo->codigoDeBloqueo,0 ,2);

                if($name_block_SAV==""){

                    if($codigoDeBloqueo=="26"){
                        $eval = $CI->parameters->get_card_lock_descriptions($codigoDeBloqueo);
                        $name_block_SAV = ($eval!=false ? $eval->name_status : "");
                    }
                }

                if((int)$codigoDeBloqueo==81 OR (int)$codigoDeBloqueo==17){
                    $codigoRenegociacion = "SI";
                }
                if($codigoDeBloqueo==30 OR $codigoDeBloqueo==15 OR $codigoDeBloqueo==16){
                    $diasMora = (int)$nodo->diasEstado;
                }

                if((int)$codigoDeBloqueo > 0){
                    if((int)$prioridad > (int)$nodo->prioridad){
                        $estadoBloqueo = $nodo->descripcionBloqueo;
                        $prioridad = (int)$nodo->prioridad;
                    }
                }
            }
        }

    }

    $data = [
        'codigoRenegociacion' => $codigoRenegociacion,
        'diasMora' => $diasMora,
        'estadoBloqueo' => $estadoBloqueo,
        'retorno' => $retorno,
        'descRetorno' => $descRetorno,
        "name_block_SAV" => $name_block_SAV,
    ];
    return($data);
}


public function index()
{

    $eval = check_session("4.2.1");
    $id_rol = $this->session->userdata("id_rol");

    $todayDate = date("d-m-Y");
    $dataLoad['environment'] = array(
        'id_rol' => $id_rol,
        'dateBegin' => $todayDate,
        'dateEnd' => $todayDate,
    );
    $dataLoad["status"] = $this->parameters->getall_renegotiationStatus();

    $this->load->view('renegotiation/search', $dataLoad);
}

public function monitor()
{

    $eval = check_session("4.2.4.1");

    $id_rol = $this->session->userdata("id_rol");

    $value['environment'] = array(
        'id_rol' => $id_rol,
        'dateBegin' => date("d-m-Y"),
        'dateEnd' => date("d-m-Y"),
    );
    $value["status"] = $this->parameters->getall_renegotiationStatus();

    $data = $value;
    $this->load->view('renegotiation/monitor', $data);

}


public function passRenegotiation(){

    $return = check_session("");
    $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run() == false) {
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }
    $number_authorizing = $this->input->post("id");

    $dataJou = $this->journal->get_renegotiationById($this->input->post("id"));
    if(!$dataJou):

        cancel_function(COD_ERROR_INIT, "No fue posible leer Renegociación en base LOCAL..!", "");
    endif;
    $nroRut = $dataJou->number_rut_client . "-" . $dataJou->digit_rut_client;

    $username = $this->session->userdata("username");

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"] != 0) {

        cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
    }
    $flg_flujo = $dataHomologador["flg_flujo"];
    $nroTcv = $dataHomologador["nroTcv"];

    $dataInput = array(
        "idRefinanciamiento" => $number_authorizing,
        "username" => $username,
        "flg_flujo" => $flg_flujo,
        "tipoRef" => "RM",
    );

    $result = ws_GET_ConsultaDetalleRene($dataInput);
    if ($result["retorno"] != 0) {
        cancel_function(COD_ERROR_INIT, $result["descRetorno"],"");
    }

    $status_exception = "";
    switch ($result["estadoExcepcion"]) {
        case 'CVE':
            $status_exception = "AVE";
            break;
        case 'CTE':
            $status_exception = "ATE";
            break;
        default:
            cancel_function(COD_ERROR_INIT, "Estado Renegociación no permite aprobar Excepción", "");
            break;
    }

    $dataInput = array(
        "flg_flujo" => $flg_flujo,
        "idUnicoDeTrx" => $result["idRefinanciamiento"],
        "username" => $username,
        "username_visa" => "",
        "status_visa" => "P",
        "date_stamp_visa" => "",
        "username_accept" => "",
        "date_stamp_accept" => "",
        "username_liquidation" => "",
        "date_stamp_liquidation" => "",
        "username_exception" => $username,
        "date_stamp_exception" => date("d-m-Y"),
        "status_exception" => $status_exception,
        "codeDeny" => "",
        "aprobadoConRevision" => $dataJou->status_check,
        "motivoRechazo" => "",
        "estadoScript" => "",
        "motivoScript" => "",
    );

    $eval = ws_PUT_ActualizaEstadoRenegotiation($dataInput);
    if ($eval["retorno"] != 0) {
        cancel_function($eval["retorno"], $eval["descRetorno"], "");
    }

    $data = array(
        "status" => 3,
        "status_name" => "CONFIRMADO AUTORIZADA EXCEPCION",
    );
    $result = $this->journal->upd_RenegotiationById($result["idRefinanciamiento"], $data);

    $data = $eval;
    echo json_encode($data);
}

public function schedule(){

    $eval = check_session("4.2.4.2");
    $value['environment'] = array(
        'id_rol' => $this->session->userdata("id_rol"),
        'dateBegin' => date("d-m-Y"),
        'dateEnd' => date("d-m-Y"),
    );
    $value["status"] = $this->parameters->getall_renegotiationStatus();

    $data = $value;
    $this->load->view('renegotiation/schedule', $data);
}

public function search()
{

    $return = check_session("4.2.1");

    $id_rol = $this->session->userdata("id_rol");

    $value['environment'] = array(
        'id_rol' => $id_rol,
        'dateBegin' => "01-" . date("m-Y"),
        'dateEnd' => date("d-m-Y"),
    );
    $value["status"] = $this->parameters->getall_renegotiationStatus();

    $data = $value;
    $this->load->view('renegotiation/search', $data);
}

    public function negotiation()
    {

        $return = check_session("4.2.2");

        $id_rol = $this->session->userdata("id_rol");
        $id_office = $this->session->userdata("id_office");

        $todayDate = date("d-m-Y");
        $this->session->set_userdata("number_authorizing", null);

        $cuotas = $this->glossary->get_REN_cuotas();
        $diferidos = $this->glossary->get_REN_diferidos();

        if (!$cuotas) {
            cancel_function(10, "Problema al leer parametros Cuotas Renegociación..!</br></br>Comuniquese con mesa de Ayuda", "");
        }
        if (!$diferidos) {
            cancel_function(10, "Problema al leer parametros Cuotas Diferidos..!</br></br>Comuniquese con mesa de Ayuda", "");
        }

        $dataLoad['environment'] = array(
            'id_rol' => $id_rol,
            'dateCreate' => $todayDate,
            'MINIMO_CUOTAS_REN' => (int) $cuotas->MINIMO,
            'MAXIMO_CUOTAS_REN' => (int) $cuotas->MAXIMO,
            'MINIMO_DIFERIDOS_REN' => (int) $diferidos->MINIMO,
            'MAXIMO_DIFERIDOS_REN' => (int) $diferidos->MAXIMO,
        );
        $dataLoad["requestStatus"] = $this->parameters->getall_requestStatus();

        $this->load->view('renegotiation/negotiation', $dataLoad);
    }

    public function auditnegotiation()
    {

        $return = check_session("4.2.2");

        $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
        $this->form_validation->set_rules('nroRut', 'Número de Rut', 'required|numeric|trim');

        $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
        $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');

        $retorno = COD_ERROR_INIT;
        $descRetorno = "";
        if ($this->form_validation->run() == false) {

            $this->load->view('renegotiation/negotiation');

        } else {

            $number_authorizing = $this->input->post("id");
            $this->session->set_userdata("number_authorizing", $number_authorizing);

            $evalRUT = digitoRUTCL($this->input->post("nroRut"));

            $nroRut = $this->input->post("nroRut") . "-" . $evalRUT["dgvRut"];
            $username = $this->session->userdata("username");

            $comercio = 27;
            $codProducto = "T";
            $retorno = COD_ERROR_INIT;
            $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
            if ($dataHomologador["retorno"] != 0) {

                cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
            }
            $flg_flujo = $dataHomologador["flg_flujo"];
            $nroTcv = $dataHomologador["nroTcv"];

            $dataInput = array(
                "idRefinanciamiento" => $number_authorizing,
                "username" => $this->session->userdata("username"),
                "flg_flujo" => $flg_flujo,
                "tipoRef" => "RM",
            );

            $eval = ws_GET_ConsultaDetalleRene($dataInput);
            if ($eval["retorno"] != 0) {

                $this->session->set_flashdata('warning_message', $eval["descRetorno"]);
                redirect(base_url("dashboard/traperror"));
            }

            $value["nroTcv"] = $nroTcv;
            $value["ca_status"] = $eval["ca_status"];
            $value["ca_username"] = $eval["ca_username"];
            $value["ca_date"] = $eval["ca_date"];

            $value["co_status"] = $eval["co_status"];
            $value["co_username"] = $eval["co_username"];
            $value["co_date"] = $eval["co_date"];

            $value["ex_status"] = $eval["ex_status"];
            $value["ex_username"] = $eval["ex_username"];
            $value["ex_date"] = $eval["ex_date"];

            $value["au_status"] = $eval["au_status"];
            $value["au_username"] = $eval["au_username"];
            $value["au_date"] = $eval["au_date"];

            $arrDataClient = array(
                "masked_rut_client" => $nroRut,
                "name_client" => $eval["nombres"] . " " . $eval["apellidos"],
                "number_phone" => $eval["telefono"],
            );

            /* Begin Consulta datos cuenta */
            $dataCuenta = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
            if ($dataCuenta["retorno"] != 0) {

                $descRetorno = $dataCuenta["descRetorno"];
                cancel_function(10, $descRetorno, "");
            }
            $contrato = (string) $dataCuenta["contrato"];

            $dataInput = array(
                "nroRut" => $nroRut,
                "nroTcv" => $nroTcv,
                "contrato" => $contrato,
                "flg_flujo" => $flg_flujo,
                "username" => $username);

            $result = ws_GET_ConsultaDeudaClienteTC($dataInput);
            if ($result["retorno"] == 0) {

                $montoEnMora = $result["montoEnMora"];
                $value['deudaEnMora'] = "$" . number_format((float) $result["montoEnMora"], 0, ",", ".");
                $value["pagoMinimo"] = "$" . number_format((float) $result["pagoMinimo"], 0, ",", ".");
                $value["deudaActual"] = "$" . number_format((float) $result["deudaActual"], 0, ",", ".");
                $value["pagoDelMesFacturado"] = "$" . number_format((float) $result["pagoDelMesFacturado"], 0, ",", ".");

            } else {

                $value['deudaEnMora'] = "0";
                $value["pagoMinimo"] = "0";
                $value["deudaActual"] = "0";
                $value["pagoDelMesFacturado"] = "0";
            }

            $cupoCompraAnterior = 0;
            $cupoAvanceAnterior = 0;
            $result = ws_GET_ConsultaCuposTC($nroTcv, $contrato, $flg_flujo, $username);
            if ($result["retorno"] == 0) {
                foreach ($result["dataResponse"] as $key) {

                    if ($key["codigolinea"] == 1) {$cupoCompraAnterior = $key["cupo"];}
                    if ($key["codigolinea"] == 2) {$cupoAvanceAnterior = $key["cupo"];}
                }
            }
            $htmlCupos = $result["htmlCupos"];

            $result = $this->ws_REN_ConsultaEstadosBloqueo($nroRut, $contrato, $flg_flujo);
            if ($result["retorno"] == 0) {

                $value["estadoBloqueo"] = $result["estadoBloqueo"];
                $value["diasMora"] = (int) $result["diasMora"];

            } else {

                $value["estadoBloqueo"] = $result["descRetorno"];
                $value["diasMora"] = (int) $result["diasMora"];
            }

            /* Begin Consulta EECC */
            $fechaVencimiento = "-";
            $fechaProximoVencimiento = "-";
            $pagoDelMes = 0;
            $pagoMinimo = 0;

            if ($flg_flujo == "001") {

                $dataInput = array(
                    "nroRut" => "",
                    "contrato" => $contrato,
                    "fechaVencimiento" => "",
                    "estadoEecc" => "",
                    "pan" => $nroTcv,
                    "flg_flujo" => $flg_flujo,
                );

            } else {

                $dataInput = array(
                    "nroRut" => $nroRut,
                    "contrato" => $contrato,
                    "fechaVencimiento" => "",
                    "estadoEecc" => "",
                    "pan" => "",
                    "flg_flujo" => $flg_flujo,
                );
            }

            $result = ws_GET_ConsultaDatosEECCTC($dataInput);
            if ($result["retorno"] == 0) {

                $fechaProximoVencimiento = $result["fechaProximoVencimiento"];
            }
            /* End Consulta EECC */

            $descripcionTarjeta = "";
            $descripcionMarca = "";
            $result = ws_GET_ConsultaDatosTarjetaTC($nroTcv, $contrato, $flg_flujo, $username);
            $datosTarjeta = json_decode($result);

            if ($datosTarjeta->retorno == 0) {

                foreach ($datosTarjeta->tarjetas as $field) {
                    $descripcionTarjeta = $field->descripcion;
                    $descripcionMarca = $field->desmarca;
                }

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
              <th class="text-center"><strong>Cupos</strong></th>
          </tr>
          </thead><tbody>
          <tr>
          <td class="text-center"><strong>' . $value["comercio"] . '</strong></td>
          <td class="text-center"><strong>' . $descripcionMarca . '</strong></td>
          <td class="text-center"><strong>' . $contrato . '</strong></td>
          <td class="text-center"><strong>' . $value["estadoBloqueo"] . '</strong></td>
          <td class="text-center"><strong>' . $value["deudaEnMora"] . '</strong></td>
          <td class="text-center"><strong>' . $value["diasMora"] . '</strong></td>
          <td class="text-center"><strong>' . $fechaProximoVencimiento . '</strong></td>
          <td class="text-center"><strong>' . $value["pagoDelMesFacturado"] . '</strong></td>
          <td class="text-center"><strong>' . $value["pagoMinimo"] . '</strong></td>
          <td class="text-center"><strong>' . $value["deudaActual"] . '</strong></td>
          <td class="text-center"><strong><button type="button" class="btn btn-xs btn-success" onclick="Client.showQuota();"
                <i class="gi gi-zoom_in" title="Ver Detalle"></i>Ver Cupos</button></strong></td>
                </tr></tbody></table>';
            /* End Consulta datos cuenta */

            /*********
            Consulta Datos Contacto del Cliente / Teléfono, Dirección y Correo Electrónico
             **********/

            $dataInput = array(
                "nroRut" => $nroRut,
                "contrato" => $contrato,
                "flg_flujo" => $flg_flujo);
            $result = ws_GET_DataContactClient($dataInput);

            $value["email"] = $result["email"];
            $value["lblDireccion"] = $result["address"];
            $value["phone"] = $result["phone"];

            /*******
            Consulta Seguros Contratados del Cliente
             ********/

            $dataInput = array(
                "nroRut" => $nroRut,
                "contrato" => $contrato,
                "comercio" => $comercio,
            );
            $result = ws_GET_DataSecureClient($dataInput);

            $dataSecure = $result["dataSecure"];

            /* Begin Prepara Retorno Datos Cliente */
            $value["nroTcv"] = $dataHomologador["nroTcv"];
            $value["id_rol"] = $this->session->userdata("id_rol");
            $value["htmlCupos"] = $htmlCupos;

            /******
            Consulta últimos Pagos registrados del cliente
             *******/

            $dateBegin = "";
            $dateEnd = "";
            $typeSkill = "005";

            $dataInput = array(
                "nroRut" => $nroRut,
                "contrato" => $contrato,
                "flg_flujo" => $flg_flujo,
                "cantidad_pagos" => 3,
                "username" => $username,
            );

            $result = ws_GET_ConsultaPagosRene($dataInput);
            $dataPayment = $result["htmlPayment"];

            /* Begin Detalle Cuadro Pago Acordado con cliente */
            $value["amount"] = "$" . number_format((float) $eval["montoRef"], 0, ",", ".");
            $value["amount_quotes_secure"] = "$" . number_format((float) $eval["seguroDesgravamen"], 0, ",", ".");
            if ((int) $eval["mesesDiferidos"] == 0) {
                $value["payment_type"] = "NORMAL";
            } else {
                $value["payment_type"] = "DIFERIDOS";
            }
            $value["number_quotes"] = $eval["nroCuotas"];
            $value["deferred_quotes"] = $eval["mesesDiferidos"];

            $date_expired = $eval["fecha1erVencimiento"];
            $date_expired = substr($date_expired, 8, 2) . "-" . substr($date_expired, 5, 2) . "-" . substr($date_expired, 0, 4);
            $value["first_date_expires_quotes"] = $date_expired;

            $value["tabSimulate"] = '<table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
          <thead>
            <tr>
              <th class="text-center">Cuotas</th>
              <th class="text-right">Valor Cuota</th>
              <th class="text-right">Impuesto</th>
              <th class="text-center">Tasa</th>
              <th class="text-right">Costo total de Renegociaci&oacute;n</th>
            </tr>
          </thead><tbody>
          <tr>
            <td scope="col" class="text-center">' . $eval["nroCuotas"] . '</td>
            <td scope="col" class="text-right">$' . number_format((float) $eval["montoCuota"], 0, ",", ".") . '</td>
            <td scope="col" class="text-right">$' . $eval["montoImpuestoMes"] . '</td>
            <td scope="col" class="text-center">' . $eval["tasaAplicada"] . '%</td>
            <td scope="col" class="text-right">$' . number_format((float) $eval["montoCreditoRef"], 0, ",", ".") . '</td>
          </tr>';

            $dataInput = array(
                "nroRut" => $nroRut,
                "contrato" => $contrato,
                "flg_flujo" => $flg_flujo,
                "username" => $this->session->userdata("username"),
            );
            $amount_interest = 0;
            $amount_taxes = 0;
            $amount_expenses = 0;
            $amount_renegotiate = 0;
            $amount_debit = 0;
            $amount_secure = 0;
            $amount_notary = 0;
            $amount_collections = 0;
            $amount_condone = 0;

            $result = $this->ws_GET_Concepts_REN($dataInput);
            if ($result["retorno"] == 0) {

                $amount_interest = (string) $result["interes"];
                $amount_taxes = (string) $result["impuesto"];
                $amount_expenses = (string) $result["honorarios_cobranza"];
                $amount_debit = (string) $result["deuda_a_renegociar"];
                $amount_condone = $amount_expenses + $amount_collections + $amount_secure + $amount_notary + $amount_taxes + $amount_interest;
            }

            $value["htmlDetalle"] = "<table class='table table-striped table-bordered'>
            <tbody>
            <tr><td class='text-left'>Deuda Actual</td>
            <td class='text-center'>" . $value["deudaActual"] . "</td></tr>
            <tr><td class='text-left'>Saldo Honorario Cobranza (-)</td>
            <td class='text-center'>$" . number_format((float) $amount_expenses, 0, ",", ".") . "</td></tr>
            <tr><td class='text-left'>Intereses (-)</td>
            <td class='text-center'>$" . number_format((float) $amount_interest, 0, ",", ".") . "</td></tr>
            <tr><td class='text-left'>Gastos (-)</td>
            <td class='text-center'>$" . number_format((float) $amount_expenses, 0, ",", ".") . "</td></tr>
            <tr><td class='text-left'>Seguros (-)</td>
            <td class='text-center'>$" . number_format((float) $amount_secure, 0, ",", ".") . "</td></tr>
            <tr><td class='text-left'>Valor Notaria (-)</td>
            <td class='text-center'>$" . number_format((float) $amount_notary, 0, ",", ".") . "</td></tr>
            <tr><td class='text-left'>Impuesto (-)</td>
            <td class='text-center'>$" . number_format((float) $amount_taxes, 0, ",", ".") . "</td></tr>
            <tr><td class='text-left'>Total Monto a Condonar (-)</td>
            <td class='text-center'>$" . number_format((float) $amount_condone, 0, ",", ".") . "</td></tr>
            <tr><td class='text-left'><b>Total Monto a Renegociar</b></td>
            <td class='text-center'><b>$" . number_format((float) $eval["montoRef"], 0, ",", ".") . "</b></td></tr>
            </tbody></table>";

            /* End Genera alternativas pago renegociación */

            $value["dataAccount"] = $dataAccount;
            $value["dataSecure"] = $dataSecure;
            $value["dataPayment"] = $dataPayment;
            $value["dataClient"] = $arrDataClient;

            $session_empty = false;
            $retorno = 0;
            $descRetorno = "Transacción Aceptada";

            $value["retorno"] = $retorno;
            $value["descRetorno"] = $descRetorno;
            $value["session_empty"] = $session_empty;
            $data = $value;
            $this->load->view('renegotiation/auditnegotiation', $data);

        }
    }

public function showSCRenegotiation()
{
    $return = check_session("");
    $number_authorizing = $this->input->post("id");

    $dataJou = $this->journal->get_renegotiationById($number_authorizing);
    if(!$dataJou):

        cancel_function(COD_ERROR_INIT, "No fue posible leer Renegociación en base LOCAL..!", "");
    endif;
    $nroRut = $dataJou->number_rut_client . "-" . $dataJou->digit_rut_client;

    $username = $this->session->userdata("username");
    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"] != 0) {

        cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
    }
    $flg_flujo = $dataHomologador["flg_flujo"];
    $nroTcv = $dataHomologador["nroTcv"];

    $dataInput = array(
        "idRefinanciamiento" => $number_authorizing,
        "username" => $username,
        "flg_flujo" => $flg_flujo,
        "tipoRef" => "RM",
    );

    $eval = ws_GET_ConsultaDetalleRene($dataInput);
    if ($eval["retorno"] != 0) {
        $descRetorno = $eval["descRetorno"];
        cancel_function(10, $descRetorno, "");
    }

    if ($eval["vigente"] == "P") {

        $checked = '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>';

    } else {

        $checked = '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>';

        if ($this->session->userdata("id_rol") == USER_ROL_SUPERVISOR_CALIDAD) {

            $data = array(
                "status_check" => 1,
                "date_check" => date("Y-m-d H:i:s"),
            );
            $result = $this->journal->upd_RenegotiationById($number_authorizing, $data);

        }

    }

    $script="";
    $result = $this->journal->get_renegotiationById($number_authorizing);
    if ($result) {

        $script = $result->script;
        $script = str_replace('&lt;', '<', $script);
        $script = str_replace('&gt;', '>', $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript1" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript2" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript3" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript4" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript5" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript6" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript7" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript8" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript9" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript10" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript11" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript12" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript13" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript14" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript15" name="chkscript">', $checked, $script);
        $script = str_replace('<input class="form-check-input" type="checkbox" value="" id="chkscript16" name="chkscript">', $checked, $script);

        if($this->session->userdata("id_rol")==13 AND $script!=""):
            $script .= '
            <div class="form-group text-center">
              <button type="button" style="width:150px" onclick="Script.accept(' . $number_authorizing . ')" class="btn-script btn btn-success" data-target="accept"><i class="gi gi-ok_2"></i> Script OK </button>
              <button type="button" style="width:150px" onclick="Script.cancel(' . $number_authorizing . ');" class="btn-script btn btn-danger" data-target="cancel"><i class="gi gi-remove_2"></i> Script No OK </button>
            </div>';
        endif;

    }else{
        cancel_function(COD_ERROR_INIT, "Renegociación no encontrada en ambiente LOCAL</br>Comuniquese con Mesa de Ayuda", "");
    }
    if($script==""){$script = "Script no ha sido confirmado !!";}

    $value["htmlScript"] = $script;
    $value["retorno"] = 0;
    $value["descRetorno"] = "Transacción Aceptada";

    $data = $value;
    echo json_encode($data);
}

public function denyRenegotiation(){

    $return = check_session("");

    $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
    $this->form_validation->set_rules('codeDeny', 'Motivo Rechazo', 'required|trim');

    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run() == false) {

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $dataJou = $this->journal->get_renegotiationById($this->input->post("id"));
    if(!$dataJou):

        cancel_function(COD_ERROR_INIT, "No fue posible leer Renegociación en base LOCAL..!", "");
    endif;
    $nroRut = $dataJou->number_rut_client . "-" . $dataJou->digit_rut_client;

    $username = $this->session->userdata("username");

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"] != 0) {

        cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
    }
    $flg_flujo = $dataHomologador["flg_flujo"];
    $nroTcv = $dataHomologador["nroTcv"];

    $dataInput = array(
        "idRefinanciamiento" => $this->input->post("id"),
        "username" => $username,
        "flg_flujo" => $flg_flujo,
        "tipoRef" => "RM",
    );

    $result = ws_GET_ConsultaDetalleRene($dataInput);
    if ($result["retorno"] != 0) {

        cancel_function($result["retorno"], $result["descRetorno"], "");
    }

    if ($this->session->userdata("id_rol") == USER_ROL_SUPERVISOR_EXCEPCIONES) {

        switch ($result["estadoExcepcion"]) {

            case 'CVE':
                $status_exception = "RVE";
                break;

            case 'CTE':
                $status_exception = "RTE";
                break;

            default:

                cancel_function(COD_ERROR_INIT, "Estado Renegociación no es valido, para realizar rechazo!!", "");
                break;
        }

        $dataInput = array(
            "flg_flujo" => $flg_flujo,
            "idUnicoDeTrx" => $result["idRefinanciamiento"],
            "username" => $username,
            "username_visa" => "",
            "status_visa" => "R",
            "date_stamp_visa" => "",
            "username_accept" => "",
            "date_stamp_accept" => "",
            "username_liquidation" => "",
            "date_stamp_liquidation" => "",
            "username_exception" => substr($username,0,20),
            "date_stamp_exception" => date("d-m-Y"),
            "codeDeny" => $this->input->post("codeDeny"),
            "aprobadoConRevision" => 0,
            "status_exception" => $status_exception,
            "motivoRechazo" => "",
            "estadoScript" => "",
            "motivoScript" => "",
        );

    } else {

        if ($this->session->userdata("id_rol") == USER_ROL_SUPERVISOR_EXCEPCIONES) {

            switch ($result["estadoExcepcion"]) {

                case 'AVE':
                    $status_exception = "RVES";
                    break;

                case 'ATE':
                    $status_exception = "RTES";
                    break;

                case 'CVN':
                    $status_exception = "RVNS";
                    break;

                case 'CTN':
                    $status_exception = "RTNS";
                    break;

                default:

                    cancel_function(COD_ERROR_INIT, "Estado Renegociación no es valido, para realizar rechazo!!", "");
                    break;
            }

            $dataInput = array(
                "flg_flujo" => $flg_flujo,
                "idUnicoDeTrx" => $result["idRefinanciamiento"],
                "username" => $username,
                "username_visa" => "",
                "status_visa" => "R",
                "date_stamp_visa" => "",
                "username_accept" => substr($username,0,20),
                "date_stamp_accept" => date("d-m-Y"),
                "username_liquidation" => substr($username,0,20),
                "date_stamp_liquidation" => date("d-m-Y"),
                "username_exception" => "",
                "date_stamp_exception" => "",
                "status_exception" => $status_exception,
                "codeDeny" => $this->input->post("codeDeny"),
                "aprobadoConRevision" => 0,
                "motivoRechazo" => "",
                "estadoScript" => "",
                "motivoScript" => "",
            );

        } else {

            cancel_function(COD_ERROR_INIT, "Rol de Usuario no es apropiado para realizar rechazo Renegociación!!", "");

        }

    }

    $eval = ws_PUT_ActualizaEstadoRenegotiation($dataInput);
    if ($eval["retorno"] != 0) {

        cancel_function($eval["retorno"], $eval["descRetorno"], "");
    }

    $data = array(
        "status" => 2,
        "status_name" => "RECHAZADA EXCEPCION",
        "date_authorizes" => date("Y-m-d H:i:s"),
        "id_user_authorizes" => $this->session->userdata("id_user"),
    );
    $result = $this->journal->upd_RenegotiationById($this->input->post("id"), $data);

    $data = $result;
    echo json_encode($data);
}


public function readRenegotiation(){

    $return = check_session("");

    $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run() == false) {

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $number_authorizing = $this->input->post("id");

    $eval = $this->journal->get_renegotiationById($number_authorizing);
    if ($eval != false) {

        $nroRut = $eval->number_rut_client . "-" . $eval->digit_rut_client;
        $username = $this->session->userdata("username");

        $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
        if ($dataHomologador["retorno"] != 0) {

            cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
        }
        $flg_flujo = $dataHomologador["flg_flujo"];
        $nroTcv = $dataHomologador["nroTcv"];

    } else {

        redirect(base_url("dashboard/traperror/" . $eval["descRetorno"]));
    }

    $dataInput = array(
        "idRefinanciamiento" => $number_authorizing,
        "username" => $username,
        "flg_flujo" => $flg_flujo,
        "tipoRef" => "RM",
    );

    $eval = ws_GET_ConsultaDetalleRene($dataInput);

    $data = $eval;
    echo json_encode($data);
}

public function confirmRenegotiation()
{

    $return = check_session("");
    $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
    $this->form_validation->set_rules('script', 'Script Renegociación', 'required|trim');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run() == false) {

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }
    $number_authorizing = $this->input->post("id");
    $eval = $this->journal->get_renegotiationById($number_authorizing);
    if ($eval != false) {

        $nroRut = $eval->number_rut_client . "-" . $eval->digit_rut_client;
        $username = $this->session->userdata("username");

        $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
        if ($dataHomologador["retorno"] != 0) {

            cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
        }
        $flg_flujo = $dataHomologador["flg_flujo"];
        $nroTcv = $dataHomologador["nroTcv"];

    } else {

        redirect(base_url("dashboard/traperror/" . $eval["descRetorno"]));
    }

    $dataInput = array(
        "idRefinanciamiento" => $number_authorizing,
        "username" => $username,
        "flg_flujo" => $flg_flujo,
        "tipoRef" => "RM",
    );
    $eval = ws_GET_ConsultaDetalleRene($dataInput);
    if ($eval["retorno"] != 0) {

        cancel_function($eval["retorno"], $eval["descRetorno"], "");
    }

    if ($eval["estado"] == "P") {

        $fecha = date('d-m-Y');
        if ($this->documents->get_documentsExists($number_authorizing, "REN")) {
            $this->documents->db_documentsById_delete($number_authorizing, "REN");
        }
        $date_expired = $eval["fecha1erVencimiento"];
        $date_expired = substr($date_expired, 8, 2) . "-" . substr($date_expired, 5, 2) . "-" . substr($date_expired, 0, 4);

        $this->data["type"] = "REN";
        $this->data["id"] = $number_authorizing;
        $this->data["name_client"] = $eval["nombres"] . " " . $eval["apellidos"];
        $this->data["number_rut_client"] = $eval["rut"];
        $this->data["digit_rut_client"] = $eval["dv"];
        $this->data["date_stamp"] = $fecha;
        $this->data["number_phone"] = $eval["telefono"];
        $this->data["number_credit_card"] = $eval["pan"];
        $this->data["data_contacto"] = $eval["email"];
        $this->data["type_mode"] = $eval["tipoRef"];
        $this->data["nroCuotas"] = $eval["nroCuotas"];
        $this->data["montoCuota"] = "$" . number_format((float) $eval["montoCuota"], 0, ",", ".");

        $this->data["amount"] = "$" . number_format((float) $eval["montoCreditoRef"], 0, ",", ".");
        $this->data["minimum_payment"] = "$" . number_format((float) $eval["montoRef"], 0, ",", ".");
        $this->data["first_expiration_date"] = $date_expired;
        $this->data["interest_rate"] = $eval["tasaAplicada"] . "%";
        $this->data["maintenance_cost"] = "$" . number_format((float) $eval["comisionAdmin"], 0, ",", ".");
        $this->data["amount_quotes_secure"] = "$" . number_format((float) $eval["seguroDesgravamen"], 0, ",", ".");
        $this->data["cae"] = $eval["cae"] . "%";
        $this->data["total_cost"] = "$" . number_format((float) $eval["montoCreditoRef"], 0, ",", ".");

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP.com - PDF Documents');
        $pdf->SetHeaderMargin(0);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetTitle('Solventa - MáximoERP.com - PDF Documents');
        $html = $this->load->view('pdf/templateRenegociacion', $this->data, true);

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("/tmp/" . 'renegociacion.pdf', 'F');
        $filename = "/tmp/" . 'renegociacion.pdf';
        $filedesc = "RENEGOCIACION - CONVENIO DE PAGO DE DEUDA";

        $fp = fopen($filename, 'r+b');
        $data = fread($fp, filesize($filename));
        fclose($fp);

        $data = mysqli_real_escape_string($this->get_mysqli(), $data);
        $fecha = date("Y-m-d H:i:s");

        $nameUser = $this->session->userdata("username");
        $office = $this->session->userdata("id_office");
        $id_user = $this->session->userdata("id");

        $sqlcall = $this->db->query("INSERT INTO ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,digit_rut_client,name_client,idDocument,typeDocument,id_user_last_print, id_office_last_print) VALUES ('" . $fecha . "'," . $id_user . ",'" . $office . "',2,'" . $filedesc . "','" . $data . "'," . $this->data['number_rut_client'] . ",'" . $this->data['digit_rut_client'] . "','" . $this->data['name_client'] . "','" . $this->data["id"] . "','" . $this->data['type'] . "','" . $nameUser . "','" . $office . "');");

        switch ($eval["estadoExcepcion"]) {

            case 'PVN':
                $status_exception = "CVN";
                $status_local = 3;
                $status_name = "CONFIRMADO";
                break;

            case 'PVE':
                $status_exception = "CVE";
                $status_local = 1;
                $status_name = "CONFIRMADO PENDIENTE EXCEPCION";
                break;

            case 'PTN':
                $status_exception = "CTN";
                $status_local = 3;
                $status_name = "CONFIRMADO";
                break;

            case 'PTE':
                $status_exception = "CTE";
                $status_local = 1;
                $status_name = "CONFIRMADO PENDIENTE EXCEPCION";
                break;

            default:

                cancel_function(COD_ERROR_INIT, "Estado Renegociación no es valido !!", "");
                break;
        }

        $dataInput = array(
            "flg_flujo" => $flg_flujo,
            "idUnicoDeTrx" => $eval["idRefinanciamiento"],
            "username" => $username,
            "username_visa" => $username,
            "status_visa" => "P",
            "date_stamp_visa" => date("d-m-Y"),
            "username_accept" => "",
            "date_stamp_accept" => "",
            "username_liquidation" => "",
            "date_stamp_liquidation" => "",
            "username_exception" => "",
            "date_stamp_exception" => "",
            "status_exception" => $status_exception,
            "codeDeny" => "",
            "aprobadoConRevision" => 0,
            "motivoRechazo" => "",
            "estadoScript" => "",
            "motivoScript" => "",
        );

        $eval = ws_PUT_ActualizaEstadoRenegotiation($dataInput);
        if ($eval["retorno"] != 0) {

            cancel_function($eval["retorno"], $eval["descRetorno"], "");
        }

        $data = array(
            "status" => $status_local,
            "status_name" => $status_name,
            "date_authorizes" => date("Y-m-d H:i:s"),
            "id_user_authorizes" => $this->session->userdata("id_user"),
            "script" => $this->input->post("script"),
            "status_script" => SCRIPT_CONFIRMADO,
        );
        $result = $this->journal->upd_RenegotiationById($number_authorizing, $data);

    } else {

        cancel_function(COD_ERROR_INIT, "Renegociación no esta pendiente de aprobar SCRIPT..!", "");
    }

    $data = $result;
    echo json_encode($data);
}

public function denyScriptRenegotiation()
{
    $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
    $this->form_validation->set_rules('reasonDeny', 'Motivo Rechazo', 'required|trim');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run() == false) {
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $dataJou = $this->journal->get_renegotiationById($this->input->post("id"));
    if(!$dataJou):

        cancel_function(COD_ERROR_INIT, "No fue posible leer Renegociación en base LOCAL..!", "");
    endif;
    $nroRut = $dataJou->number_rut_client . "-" . $dataJou->digit_rut_client;
    $username = $this->session->userdata("username");

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"] != 0) {

        cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
    }
    $flg_flujo = $dataHomologador["flg_flujo"];

    $dataInput = array(
        "flg_flujo" => $flg_flujo,
        "idUnicoDeTrx" => $this->input->post("id"),
        "username" => $username,
        "username_visa" => $username,
        "status_visa" => "",
        "date_stamp_visa" => date("d-m-Y"),
        "username_accept" => "",
        "date_stamp_accept" => "",
        "username_liquidation" => "",
        "date_stamp_liquidation" => "",
        "username_exception" => "",
        "date_stamp_exception" => "",
        "status_exception" => "",
        "codeDeny" => "",
        "aprobadoConRevision" => "",
        "motivoRechazo" => "",
        "estadoScript" => "R",
        "motivoScript" => $this->input->post("reasonDeny")
    );

    $eval = ws_PUT_ActualizaEstadoRenegotiation($dataInput);
    if ($eval["retorno"] != 0) {
        cancel_function($eval["retorno"], $eval["descRetorno"], "");
    }

    $data = array(
        "status_deny_script" => 1,
        "reason_deny_script" => $this->input->post("reasonDeny"),
    );
    $result = $this->journal->upd_RenegotiationById($this->input->post("id"), $data);

    if($result){
        $value["retorno"] = 0;
        $value["descRetorno"] = "Transacción Aceptada";
    }else{
        $value["retorno"] = COD_ERROR_INIT;
        $value["descRetorno"] = "Transacción Rechazada";
    }

    echo json_encode($value);
}

public function passScriptRenegotiation()
{
    $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run() == false) {
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $dataJou = $this->journal->get_renegotiationById($this->input->post("id"));
    if(!$dataJou):

        cancel_function(COD_ERROR_INIT, "No fue posible leer Renegociación en base LOCAL..!", "");
    endif;

    $nroRut = $dataJou->number_rut_client . "-" . $dataJou->digit_rut_client;
    $username = $this->session->userdata("username");

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"] != 0) {

        cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
    }
    $flg_flujo = $dataHomologador["flg_flujo"];

    $dataInput = array(
        "flg_flujo" => $flg_flujo,
        "idUnicoDeTrx" => $this->input->post("id"),
        "username" => $username,
        "username_visa" => $username,
        "status_visa" => "",
        "date_stamp_visa" => date("d-m-Y"),
        "username_accept" => "",
        "date_stamp_accept" => "",
        "username_liquidation" => "",
        "date_stamp_liquidation" => "",
        "username_exception" => "",
        "date_stamp_exception" => "",
        "status_exception" => "",
        "codeDeny" => "",
        "aprobadoConRevision" => "",
        "motivoRechazo" => "",
        "estadoScript" => "A",
        "motivoScript" => ""
    );

    $eval = ws_PUT_ActualizaEstadoRenegotiation($dataInput);
    if ($eval["retorno"] != 0) {
        cancel_function($eval["retorno"], $eval["descRetorno"], "");
    }

    $data = array(
        "status_deny_script" => 0,
        "reason_deny_script" => "Script validado OK",
    );
    $result = $this->journal->upd_RenegotiationById($this->input->post("id"), $data);

    if($result){
        $value["retorno"] = 0;
        $value["descRetorno"] = "Transacción Aceptada";
    }else{
        $value["retorno"] = COD_ERROR_INIT;
        $value["descRetorno"] = "Transacción Rechazada";
    }

    echo json_encode($value);
}

public function script()
{
    $return = check_session("4.2.3");
    $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');

    $retorno = COD_ERROR_INIT;
    $descRetorno = "";
    if ($this->form_validation->run() == false) {

        $number_authorizing = $this->session->userdata("number_authorizing");

        if ($number_authorizing === null or $number_authorizing == 0) {

            $session_empty = true;

        } else {

            $session_empty = false;
        }

    } else {

        $number_authorizing = $this->input->post("id");

        if ($number_authorizing === null or $number_authorizing == 0) {

            $session_empty = true;

        } else {

            $session_empty = false;
        }

    }

    $value["viewhtml"] = "noready";
    $htmlScript = "";
    if (!$session_empty) {

        $dataJou = $this->journal->get_renegotiationById($number_authorizing);
        if ($dataJou != false) {

            if ($dataJou->status_script == SCRIPT_CONFIRMADO) {

                $htmlScript = $dataJou->script;
                $value["viewhtml"] = "ready";

                $value['environment'] = array(
                    'idClient' => $dataJou->number_rut_client . "-" . $dataJou->digit_rut_client,
                    'nameClient' => $dataJou->name_client,
                    'emailClient' => "",
                    'phoneClient' => $dataJou->number_phone,
                    'number_authorizing' => $number_authorizing,
                    'number_rut_client' => $dataJou->number_rut_client."-".$dataJou->digit_rut_client,
                );

                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript1" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript2" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript3" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript4" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript5" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript6" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript7" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript8" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript9" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript10" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript11" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript12" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript13" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript14" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);
                $htmlScript = str_replace('&lt;input class="form-check-input" type="checkbox" value="" id="chkscript15" name="chkscript"&gt;', '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i', $htmlScript);

            }
        }

        if ($htmlScript == "") {

            $nroRut = $dataJou->number_rut_client . "-" . $dataJou->digit_rut_client;
            $username = $this->session->userdata("username");

            $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
            if ($dataHomologador["retorno"] != 0) {

                cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
            }
            $flg_flujo = $dataHomologador["flg_flujo"];
            $nroTcv = $dataHomologador["nroTcv"];

            $dataInput = array(
                "idRefinanciamiento" => $number_authorizing,
                "username" => $username,
                "flg_flujo" => $flg_flujo,
                "tipoRef" => "RM",
            );

            $eval = ws_GET_ConsultaDetalleRene($dataInput);
            if ($eval["retorno"] == 0) {

                $value["status_approval"] = $eval["vigente"];
                $value["payment_type"] = $eval["tipoRef"];

                if ($eval["tipoRef"] == "RM") {

                    $script = $this->glossary->get_scriptById(132);

                } else {

                    $script = $this->glossary->get_scriptById(132);
                }

                if ($script) {

                    $value["dataClient"] = array(
                        "name_client" => $eval["nombres"] . " " . $eval["apellidos"],
                        "number_authorizing" => $eval["idRefinanciamiento"],
                    );

                    if ($dataJou->sex_client == "FEM") {
                        $courtesy = "Sra(Srta). ";
                    } else {
                        $courtesy = "Don. ";
                    }
                    if (date("H") > 12) {
                        $ampm = "una Buena Tarde";
                    } else {
                        $ampm = "un buen día";
                    }

                    $date_expired = $eval["fecha1erVencimiento"];
                    $date_expired = substr($date_expired, 8, 2) . "-" . substr($date_expired, 5, 2) . "-" . substr($date_expired, 0, 4);

                    $ind = 1;
                    foreach ($script as $nodo) {

                        $request = $nodo->REQUEST;
                        $response = $nodo->RESPONSE;

                        if ($nodo->CHANGE == 1) {

                            $request = str_replace("&nombre_cliente&", $eval["nombres"] . " " . $eval["apellidos"], $request);
                            $request = str_replace("&numero_rut_cliente&", $eval["rut"] . "-" . $eval["dv"], $request);
                            $request = str_replace("&deuda_actual&", "$" . number_format((float) $eval["montoRef"], 0, ",", "."), $request);
                            $request = str_replace("&valor_cuota&", "$" . number_format((float) $eval["montoCuota"], 0, ",", "."), $request);
                            $request = str_replace("&valor_seguro_desgravamen&", "$" . number_format((float) $eval["seguroDesgravamen"], 0, ",", "."), $request);
                            $request = str_replace("&numero_cuotas&", $eval["nroCuotas"], $request);
                            $request = str_replace("&cortesia_cliente&", $courtesy, $request);
                            $request = str_replace("&valor_comision&", "$" . number_format((float) $eval["comisionAdmin"], 0, ",", "."), $request);
                            $request = str_replace("&primer_vencimiento&", $date_expired, $request);
                            $request = str_replace("&costo_total_credito&", "$" . number_format((float) $eval["montoCreditoRef"], 0, ",", "."), $request);
                            $request = str_replace("&cupo_avance&", "$" . number_format((float) $eval["cupoAvance"], 0, ",", "."), $request);
                            $request = str_replace("&cupo_compras&", "$" . number_format((float) $eval["cupoCompras"], 0, ",", "."), $request);
                            $request = str_replace("&tasa_mensual&", $eval["tasaAplicada"], $request);

                            $response = str_replace("&nombre_cliente&", $eval["nombres"] . " " . $eval["apellidos"], $response);
                            $response = str_replace("&numero_rut_cliente&", $eval["rut"] . "-" . $eval["dv"], $response);
                            $response = str_replace("&cortesia_cliente&", $courtesy, $response);
                            $response = str_replace("&cae&", $eval["cae"] . "%", $response);
                            $response = str_replace("&ampm&", $ampm, $response);

                        }

                        $checked = "";
                        if ($nodo->CHECKED == 1) {

                            if ($eval["estado"] != "P") {

                                $checked = '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>';

                            } else {

                                $checked = '<input class="form-check-input" type="checkbox" value="" id="chkscript' . $ind . '" name="chkscript">';

                            }

                        }

                        if ($nodo->CHANGE == 2) {

                            $htmlScript .= '<tr>
                  <td class="text-center" colspan="4"><strong>FINALIZACIÓN<strong></td></tr>';

                        } else {

                            if ($response == "") {

                                $htmlScript .= '<tr>
                        <td class="text-center">' . $ind . '</td>
                        <td class="text-left" colspan="2">' . $request . '</td>
                        <td class="text-center">' . $checked . '</td>
                      </tr>';
                                $ind = $ind + 1;

                            } else {

                                if ($request == "") {

                                    $htmlScript .= '<tr>
                        <td class="text-center">' . $ind . '</td>
                        <td class="text-left" colspan="2">' . $response . '</td>
                        <td class="text-center">' . $checked . '</td>
                      </tr>';
                                    $ind = $ind + 1;

                                } else {

                                    $htmlScript .= '<tr>
                        <td class="text-center">' . $ind . '</td>
                        <td class="text-left">' . $request . '</td>
                        <td class="text-left">' . $response . '</td>
                        <td class="text-center">' . $checked . '</td>
                      </tr>';
                                    $ind = $ind + 1;

                                }
                            }
                        }
                    }

                } else {

                    $htmlScript .= '<tr>
                <td scope="col" class="text-center" colspan="4">SIN INFORMACIÓN</td>
              </tr>';

                }

                $evalRUT = digitoRUTCL($eval["rut"]);
                $value['environment'] = array(
                    'idClient' => $eval["rut"] . $evalRUT["dgvRut"],
                    'nameClient' => $eval["nombres"] . " " . $eval["apellidos"],
                    'emailClient' => "",
                    'phoneClient' => $eval["telefono"],
                    'number_authorizing' => $number_authorizing,
                    'number_rut_client' => $eval["rut"],
                );

            } else {

                $htmlScript .= '<tr>
            <td scope="col" class="text-center" colspan="4">ERROR LEER RENEGOCIACION</td>
          </tr>';
                $session_empty = true;

            }

            $retorno = $eval["retorno"];
            $descRetorno = $eval["descRetorno"];

        }

    }

    $value["html"] = $htmlScript;
    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["session_empty"] = $session_empty;

    $data = $value;
    $this->load->view('renegotiation/script', $data);
}

    public function authorization()
    {

        $return = check_session("4.2.4");

        $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
        $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
        $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');

        $retorno = COD_ERROR_INIT;
        $descRetorno = "";
        if ($this->form_validation->run() == false) {

            $number_authorizing = $this->session->userdata("number_authorizing");

            if ($number_authorizing === null or $number_authorizing == 0) {

                $session_empty = true;

            } else {

                $session_empty = false;
            }

        } else {

            $number_authorizing = $this->input->post("id");

            if ($number_authorizing === null or $number_authorizing == 0) {

                $session_empty = true;

            } else {

                $session_empty = false;
            }

        }

        if (!$session_empty) {

            $eval = $this->journal->get_renegotiationById($number_authorizing);
            if ($eval != false) {

                $nroRut = $eval->number_rut_client . "-" . $eval->digit_rut_client;
                $username = $this->session->userdata("username");

                $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
                if ($dataHomologador["retorno"] != 0) {

                    cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
                }
                $flg_flujo = $dataHomologador["flg_flujo"];
                $nroTcv = $dataHomologador["nroTcv"];

            } else {

                redirect(base_url("dashboard/traperror/" . $eval["descRetorno"]));
            }

            $dataInput = array(
                "idRefinanciamiento" => $number_authorizing,
                "username" => $username,
                "flg_flujo" => $flg_flujo,
                "tipoRef" => "RM",
            );

            $eval = ws_GET_ConsultaDetalleRene($dataInput);
            if ($eval["retorno"] == 0) {

                $value["number_approval"] = $eval["idRefinanciamiento"];
                $value["amount"] = "$" . number_format((float) $eval["montoCreditoRef"], 0, ",", ".");
                $value["amount_quotes_value"] = "$" . number_format((float) $eval["montoCuota"], 0, ",", ".");
                $value["number_quotes"] = $eval["nroCuotas"];
                $value["deferred_quotes"] = $eval["mesesDiferidos"];
                $value["first_date_expires_quotes"] = $eval["fecha1erVencimiento"];
                $value["number_quotes_end"] = $eval["nroCuotas"];
                $value["message"] = "Renegociación grabada con Éxito..!";

                $value["dataClient"] = array(
                    "name_client" => $eval["nombres"] . " " . $eval["apellidos"],
                    "number_authorizing" => $eval["idRefinanciamiento"],
                );

                $session_empty = false;
                $retorno = 0;
                $descRetorno = "Transacción Aceptada";

            } else {

                $session_empty = true;
                $retorno = 0;
                $descRetorno = "Preste Atención, Renegociación no registrada..";

            }

        }

        $value["retorno"] = $retorno;
        $value["descRetorno"] = $descRetorno;
        $value["number_authorizing"] = $number_authorizing;
        $value["number_rut_client"] = $eval["rut"];
        $value["session_empty"] = $session_empty;

        $data = $value;
        $this->load->view('renegotiation/authorization', $data);

    }

public function get_renegotiation()
{

    $return = check_session("");

    $this->form_validation->set_rules('masked_rut_client', 'Número RUT Cliente', 'trim');
    $this->form_validation->set_rules('status', 'Estado Renegociación ', 'trim');
    $this->form_validation->set_rules('number_phone', 'Número Teléfono ', 'trim');
    $this->form_validation->set_rules('username', 'Usuario', 'trim');
    $this->form_validation->set_rules('dateBegin', 'Fecha Desde ', 'required|trim');
    $this->form_validation->set_rules('dateEnd', 'Fecha Hasta ', 'required|trim');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run()==false) {
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $response = array();
    $retorno = COD_ERROR_INIT;
    $descRetorno = "";
    $data = array();
    $status = $this->input->post("status");

    $request = array(
        "nroRut" => $this->input->post("masked_rut_client"),
        "dateBegin" => $this->input->post("dateBegin"),
        "dateEnd" => $this->input->post("dateEnd"),
        "status" => $status,
        "number_phone" => $this->input->post("number_phone"),
        "usernameCreate" => $this->input->post("username"),
        "username" => $this->session->userdata("username"),
        "id_rol" => $this->session->userdata("id_rol"),
        "tipoRef" => "RM",
    );
    $result = ws_GET_Lista_Operaciones_REN($request);

    $value["retorno"] = $result["retorno"];
    $value["descRetorno"] = $result["descRetorno"];

    $response["dataResult"] = $value;
    $response["dataResponse"] = $result["htmlRenegotiation"];

    echo json_encode($response);
}

public function get_simulate() {

    $return = check_session("");

    $this->form_validation->set_rules('number_rut_client', 'Número RUT Cliente', 'required|trim');
    $this->form_validation->set_rules('number_quotes', 'Número de Cuotas', 'required|trim');
    $this->form_validation->set_rules('deferred_quotes', 'Número de Cuotas Diferidas', 'required|trim');
    $this->form_validation->set_rules('amount', 'Monto simulación', 'required|trim');
    $this->form_validation->set_rules('nroTcv', 'Número Tarjeta de Crédito', 'trim');
    $this->form_validation->set_rules('amount_admin', 'Monto administración', 'required|trim');

    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run() == false) {

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = str_replace('.', '', $this->input->post("number_rut_client"));
    $nroRut = str_replace('-', '', $nroRut);
    $dgvRut = substr($nroRut, -1);
    $nroRut = substr($nroRut, 0, -1);
    $nroTcv = $this->input->post("nroTcv");
    $number_quotes = $this->input->post("number_quotes");
    $deferred_quotes = $this->input->post("deferred_quotes");

    $amount = str_replace('.', '', str_replace('$', '', $this->input->post("amount")));
    $amount_secure = str_replace('.', '', str_replace('$', '', $this->input->post("amount_secure")));
    $amount_admin = str_replace('.', '', str_replace('$', '', $this->input->post("amount_admin")));

    if ($this->input->post("flg_flujo") == "001") {

        if ($deferred_quotes > 0) {

            $idTrx = COD_TRX_REN_CON_DIFERIDO_001;
        } else {
            $idTrx = COD_TRX_REN_SIN_DIFERIDO_001;
        }

    } else {

        if ($deferred_quotes > 0) {

            $idTrx = COD_TRX_REN_CON_DIFERIDO_002;
        } else {
            $idTrx = COD_TRX_REN_SIN_DIFERIDO_002;
        }

    }

    $request = array(
        "nroTcv" => $nroTcv,
        "nroRut" => $this->input->post("number_rut_client"),
        "idTrx" => $idTrx,
        "amount" => $amount,
        "numberQuotas" => (int) $number_quotes,
        "deferredQuotas" => (int) $deferred_quotes,
        "flagCriterio" => COD_CRITERIO_CUOTAS,
        "username" => $this->session->userdata("username"),
        "montoPrimaCL" => $amount_secure,
        "cobroAdministracionMensual" => $amount_admin,
    );
    $result = ws_GET_Payment_Alternatives_REN($request);

    if ($result["retorno"] == 0) {

        $value["dataSimulate"] = $result["htmlSimulate"];
        $value["lastLine"] = $result["lastLine"];
        $value["lastQuota"] = $result["lastQuota"];
        $value["interesRate"] = $result["interesRate"];
        $value["dateFirstExpiration"] = $result["dateFirstExpiration"];

        $value['dateEndNormal'] = $result["dateFirstExpiration"];
        $value['dateEndDifer'] = $result["dateFirstExpiration"];
    }

    $value["retorno"] = $result["retorno"];
    $value["descRetorno"] = $result["descRetorno"];

    $data = $value;
    echo json_encode($data);
}

public function documents()
{
    $return = check_session("4.2.5");
    $data["dataFilters"] = "REN";
    $this->load->view('client/documents', $data);
}

public function evaluation_client()
{
    $return = check_session("");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'required');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio');
    if ($this->form_validation->run() == false) {
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $result = $this->parameters->getall_renegotiationMontoMora();
    if (!$result) {

        $descRetorno = "Parámetro Monto Mora Mínimo y/o Máximo, no definidos<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    } else {

        $amount_is_over_begin = (float) $result->MINIMO;
        $amount_is_over_end = (float) $result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationDiasMora();
    if (!$result) {

        $descRetorno = "Parámetro Días Mora Mínimo y/o Máximo, no definidos<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    } else {

        $days_is_over_begin = (int) $result->MINIMO;
        $days_is_over_end = (int) $result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationMontoCuota();
    if (!$result) {

        $descRetorno = "Parámetro Monto Cuotas Mínimo y/o Máximo, no definidos<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    } else {
        $amount_quotes_begin = (float) $result->MINIMO;
        $amount_quotes_end = (float) $result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationOpers();
    if (!$result) {

        $descRetorno = "Parámetro Número Renegociaciones Mínimo y/o Máximo, no definido<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    } else {
        $number_opers_begin = (int) $result->MINIMO;
        $number_opers_end = (int) $result->MAXIMO;
    }

    $result = $this->parameters->get_quotasByProduct(CODIGO_RENEGOCIACION);
    if (!$result) {

        $descRetorno = "Parámetro Número Cuotas Renegociaciones Mínimo y/o Máximo, no definido<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    } else {
        $number_quotes_begin = (int) $result->CUOTAS_MINIMO;
        $number_quotes_end = (int) $result->CUOTAS_MAXIMO;
    }

    $result = $this->parameters->get_deferredByProduct(CODIGO_RENEGOCIACION);
    if (!$result) {

        $descRetorno = "Parámetro Número Cuotas Diferidas Renegociaciones Mínimo y/o Máximo, no definido<br><br>Comuniquese con Mesa de Ayuda";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");

    } else {
        $deferred_quotes_begin = (int) $result->CUOTAS_MINIMO;
        $deferred_quotes_end = (int) $result->CUOTAS_MAXIMO;
    }
    /*******
    Valida Número RUT Cliente
     ********/
    $nroRut = $this->input->post("nroRut");
    $username = $this->session->userdata("username");

    $eval = validaRUTCL($nroRut);
    if ($eval["retorno"] != 0) {
        cancel_function(COD_ERROR_INIT, $eval["descRetorno"], "Preste Atención");
    }

    /*********
    Checking Número Renegociaciones
     **********/
    $dataInput = array(
       "nroRut" => $nroRut,
       "username" => $this->session->userdata("username"),
    );
    $result = ws_GET_CountRenegotiation($dataInput);
    if ($result["retorno"] == 0) {

        $nroReneg = $result["nroReneg"];

    } else {

        $nroReneg = 0;
    }

    if($nroReneg>$number_opers_end){
      cancel_function(COD_ERROR_INIT, "Cliente registra " . $nroReneg . " renegociaciones, no puede cursar nueva renegociación.", "Preste Atención");
    }

    $comercio = 27;
    $codProducto = "T";
    $retorno = COD_ERROR_INIT;

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"] != 0) {
        cancel_function(COD_ERROR_INIT, $dataHomologador["descRetorno"], "Preste Atención");
    }
    $flg_flujo = $dataHomologador["flg_flujo"];
    $nroTcv = $dataHomologador["nroTcv"];

    /********
    Datos del Cliente
     *********/
    $dataClient = ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username);
    if ($dataClient["retorno"] != 0) {
        cancel_function(COD_ERROR_INIT, $dataClient["descRetorno"], "");
    }

    /*********
    Datos Cuenta Cliente / Número de Contrato
     **********/
    $dataCuenta = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
    if ($dataCuenta["retorno"] != 0) {
        cancel_function(COD_ERROR_INIT, $dataCuenta["descRetorno"], "");
    }
    $contrato = (string) $dataCuenta["contrato"];

    /********
    Evaluación Cliente Castigado
     *********/
    if ($dataHomologador["flg_cvencida"] == "S") {

        $descRetorno = "<h4>El cliente <strong>" . $dataClient["nombreCliente"] . "</strong> se encuentra Castigado porque cumplió sus 180 días de mora";
        $descRetorno .= ", solo puede ver sus EECC Históricos para ver detalle de administración de su deuda y pagos debe dirigirse a Plataforma Emerix.</h4>";
        $descRetorno .= "<div class='col-sm-12'>&nbsp;</div>";
        $descRetorno .= "<div class='col-sm-12'><h4><strong>URL https://emerix.solventa.cl</strong></h4></div>";
        $descRetorno .= "<div class='col-sm-12'>&nbsp;</div>";
        $descRetorno .= "</div>";
        cancel_function(COD_ERROR_INIT, $descRetorno, "");
    }

    /********
    Evaluación Cliente Vissat
     *********/
    if ($dataHomologador["flg_tecnocom"] == "N") {

        $descRetorno = "<h4>El cliente <strong>" . $dataClient["nombreCliente"] . "</strong> es cliente " . $dataHomologador["origen"] . " debe cursar Renegociación en esa Plataforma</h4>";
        $descRetorno .= "<div class='col-sm-12'>&nbsp;</div>";
        $descRetorno .= "<div class='col-sm-12'>&nbsp;</div>";
        $descRetorno .= "</div>";
        cancel_function(COD_ERROR_INIT, $descRetorno, "");
    }

    /********
    Evaluación Renegociaciones últimos 30 días
     *********/
    $eval = ws_GET_ConsultaRenes30Dias($nroRut, $username);
    if ($eval["retorno"] != 0) {

        cancel_function(COD_ERROR_INIT, $eval["descRetorno"], "Preste Atención");
    }
    if ($eval["existe"] == 1) {
        $descRetorno = "<h4>El cliente <strong>" . $dataClient["nombreCliente"] . "</strong> fue renegociado hace menos de 30 días</h4>";
        $descRetorno .= "<div class='col-sm-12'>&nbsp;</div>";
        $descRetorno .= "<div class='col-sm-12'>&nbsp;</div>";
        $descRetorno .= "</div>";
        cancel_function(COD_ERROR_INIT, $descRetorno, "Preste Atención");
    }

    /*********
    Consulta Deuda Cliente
     **********/
    $dataInput = array(
        'nroRut' => $nroRut,
        'nroTcv' => $nroTcv,
        'contrato' => $contrato,
        'flg_flujo' => $flg_flujo,
        'username' => $username);

    $result = ws_GET_ConsultaDeudaClienteTC($dataInput);
    if ($result["retorno"] == 0) {

        $montoEnMora = $result["montoEnMora"];
        $value['deudaEnMora'] = "$" . number_format((float) $result["montoEnMora"], 0, ",", ".");
        $value["pagoMinimo"] = "$" . number_format((float) $result["pagoMinimo"], 0, ",", ".");
        $value["deudaActual"] = "$" . number_format((float) $result["deudaActual"], 0, ",", ".");
        $value["pagoDelMesFacturado"] = "$" . number_format((float) $result["pagoDelMesFacturado"], 0, ",", ".");
        $amount_deudaActual = (float) $result["deudaActual"];

    } else {

        $descRetorno = "Error al leer Deuda Cliente ".$dataClient["nombreCliente"]."</br>".$result["descRetorno"];
        cancel_function(COD_ERROR_INIT, $descRetorno, "");

    }

    /*********
    Consulta Cupos Tarjeta
     **********/
    $cupoCompraAnterior = 0;
    $cupoAvanceAnterior = 0;
    $result = ws_GET_ConsultaCuposTC($nroTcv, $contrato, $flg_flujo, $username);
    if ($result["retorno"] == 0) {
        foreach ($result["dataResponse"] as $key) {

            if ($key["codigolinea"] == 1) {$value["cupoCompraAnterior"] = $key["cupo"];}
            if ($key["codigolinea"] == 2) {$value["cupoAvanceAnterior"] = $key["cupo"];}
        }
    }
    $htmlCupos = $result["htmlCupos"];

    /*********
    Consulta Bloqueos del Producto
     **********/
    $result = $this->ws_REN_ConsultaEstadosBloqueo($nroRut, $contrato, $flg_flujo);
    if ($result["retorno"] == 0) {

        $value["estadoBloqueo"] = $result["estadoBloqueo"];
        $value["diasMora"] = (int) $result["diasMora"];

        if($result["name_block_SAV"]!=""){

        $descRetorno = "Cliente " . $result["name_block_SAV"] . ", impedido continuar..!";
        cancel_function(COD_ERROR_INIT, $descRetorno, "");

        }
    } else {

        $value["estadoBloqueo"] = $result["descRetorno"];
        $value["diasMora"] = 0;
    }

    /*********
    Consulta EECC Cliente / Rescata Proximo Vencimiento último estado cuenta ACTIVO
     **********/
    $fechaProximoVencimiento = "-";
    $pagoDelMes = 0;
    $pagoMinimo = 0;

    if ($flg_flujo == "001") {

        $dataInput = array(
            "nroRut" => "",
            "contrato" => $contrato,
            "fechaVencimiento" => "",
            "estadoEecc" => "",
            "pan" => $nroTcv,
            "flg_flujo" => $flg_flujo,
        );

    } else {

        $dataInput = array(
            "nroRut" => $nroRut,
            "contrato" => $contrato,
            "fechaVencimiento" => "",
            "estadoEecc" => "",
            "pan" => "",
            "flg_flujo" => $flg_flujo,
        );
    }


    $result = ws_GET_ConsultaDatosEECCTC($dataInput);
    if ($result["retorno"] == 0) {

        $fechaProximoVencimiento = $result["fechaProximoVencimiento"];
    }

    /*********
    Consulta Datos Tarjeta / Marca y descripción Tarjetas
     **********/
    $descripcionTarjeta = "";
    $descripcionMarca = "";
    $result = ws_GET_ConsultaDatosTarjetaTC($nroTcv, $contrato, $flg_flujo, $username);
    $datosTarjeta = json_decode($result);

    if ($datosTarjeta->retorno == 0) {

        foreach ($datosTarjeta->tarjetas as $field) {
            $descripcionTarjeta = $field->descripcion;
            $descripcionMarca = $field->desmarca;
        }

    }

    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $contrato,
        "flg_flujo" => $flg_flujo,
        "username" => $username,
    );
    $amount_interest = 0;
    $amount_taxes = 0;
    $amount_expenses = 0;
    $amount_renegotiate = 0;
    $amount_debit = 0;
    $amount_secure = 0;
    $amount_notary = 0;
    $amount_collections = 0;
    $amount_condone = 0;

    $result = $this->ws_GET_Concepts_REN($dataInput);
    if ($result["retorno"] == 0) {

        $amount_interest = (float) $result["interes"];
        $amount_taxes = (int) $result["impuesto"];
        $amount_expenses = (int) $result["honorarios_cobranza"];
        $amount_debit = (int) $result["deuda_a_renegociar"];

        $amount_condone = $amount_expenses + $amount_collections + $amount_secure + $amount_notary + $amount_taxes + $amount_interest;
        $amount_renegotiate = $amount_debit - $amount_condone;
        $amount_renegotiate = round($result["deuda_a_renegociar"]);

    }else{

        $descRetorno = "No fue posible obtener deuda a renegociar..!</br>" . $result["descRetorno"];
        cancel_function(COD_ERROR_INIT, $descRetorno, "");

    }

    if ((int) $amount_renegotiate <= 0) {

        $descRetorno = "Cliente no registra deuda que renegociar..!</br>Monto Deuda: $" . number_format((float) $amount_renegotiate, 0, ",", ".");
        cancel_function(COD_ERROR_INIT, $descRetorno, "");
    }

    /*******
    Checking Porcentaje Pago Minimo
     ********/
    $dataSession["pagoMinimo"] = 0;
    $value["warning_payment"] = 0;
    $amount_pago_minimo = 0;

    $dataInput = array(
        "nroRut" => $nroRut,
    );
    $dataPagos = ws_GET_ConsultaTotalPagosRene($dataInput);
    if($dataPagos["retorno"] != 0) {

        $descRetorno = "Problemas al leer pagos del cliente..!</br>" . $dataPagos["descRetorno"];
        cancel_function(COD_ERROR_INIT, $descRetorno, "");
    }

    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $contrato
    );
    $dataDeudaDiaUno = ws_GET_ConsultaDeudaDiaUno($dataInput);
    if($dataDeudaDiaUno["retorno"] != 0) {
        $descRetorno = "Problemas al leer deuda inicial del mes..!</br>" . $result["descRetorno"];
        cancel_function(COD_ERROR_INIT, $descRetorno, "");
    }

    $dataParameters = $this->parameters->get_generalParameters();
    if(!$dataParameters){

        $descRetorno = "Problemas al leer parámetros Generales del sistema..!";
        cancel_function(COD_ERROR_INIT, $descRetorno, "");
    }


    $dataSession["pagoMinimo"] = (int) $dataDeudaDiaUno["montoDeuda"];
    if((float)$dataDeudaDiaUno["montoDeuda"]>0){

          $amount_pago_minimo = (float) $dataDeudaDiaUno["montoDeuda"] * (float) $dataParameters->min_payment_porcentage_value / 100;
    }else{
          $amount_pago_minimo = 0;
    }
    if ((int) $dataPagos["monto"] > (int) $amount_pago_minimo) {
        $value["warning_payment"] = 0;
    } else {
        $value["warning_payment"] = 1;
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
            <th class="text-center"><strong>Deuda Inicio Mes</strong></th>
            <th class="text-center"><strong>Cupos</strong></th>
        </tr>
        </thead><tbody>
        <tr>
        <td class="text-center"><strong>' . $value["comercio"] . '</strong></td>
        <td class="text-center"><strong>' . $descripcionMarca . '</strong></td>
        <td class="text-center"><strong>' . $contrato . '</strong></td>
        <td class="text-center"><strong>' . $value["estadoBloqueo"] . '</strong></td>
        <td class="text-center"><strong>' . $value["deudaEnMora"] . '</strong></td>
        <td class="text-center"><strong>' . $value["diasMora"] . '</strong></td>
        <td class="text-center"><strong>' . $fechaProximoVencimiento . '</strong></td>
        <td class="text-center"><strong>' . $value["pagoDelMesFacturado"] . '</strong></td>
        <td class="text-center"><strong>' . $value["pagoMinimo"] . '</strong></td>
        <td class="text-center"><strong>' . $value["deudaActual"] . '</strong></td>
        <td class="text-center"><strong>' . $nroReneg . '</strong></td>
        <td class="text-center"><strong>$' . number_format((float) $dataDeudaDiaUno["montoDeuda"],0, ",", ".") . '</strong></td>
        <td class="text-center"><strong><button type="button" class="btn btn-xs btn-success" onclick="Client.showQuota();"
              <i class="gi gi-zoom_in" title="Ver Detalle"></i>Ver Cupos</button></strong></td>
              </tr></tbody></table>';

    /*********
    Consulta Datos Contacto del Cliente / Teléfono, Dirección y Correo Electrónico
     **********/
    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $contrato,
        "flg_flujo" => $flg_flujo,
    );
    $result = ws_GET_DataContactClient($dataInput);

    $value["email"] = $result["email"];
    $value["lblDireccion"] = $result["address"];
    $value["phone"] = $result["phone"];

    /*******
    Consulta Seguros Contratados del Cliente
     ********/
    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $contrato,
        "comercio" => $comercio,
    );
    $result = ws_GET_DataSecureClient($dataInput);

    $dataSecure = $result["dataSecure"];
    $montoPrimaCL = $result["montoPrimaCL"];
    $montoPrimaUF = $result["montoPrimaUF"];

    if ($montoPrimaUF > 0) {

        $dataInput = array(
            'fechaConsulta' => date('d-m-Y'),
            'username' => $username,
        );
        $montoPrimaCL = 0;
        $result = json_decode(ws_GET_ConsultaValorUF($dataInput));
        if ($result->retorno == 0) {

            $montoPrimaCL = (float) $montoPrimaUF * (float) $result->valorUF;

        } else {

            $descRetorno = "Atención, Valor UF no esta disponible..";
            cancel_function(10, $descRetorno, "");
        }
        $montoPrimaCL = (int) $montoPrimaCL;

        if ((int) $montoPrimaCL <= 0) {

            $descRetorno = "Atención, Valor Prima Seguro Desgravamen y Valor UF no puede ser cero..";
            cancel_function(10, $descRetorno, "");
        }

    } else {

        $montoPrimaCL = 0;
    }

    /*********
    Checking Params Contract
     **********/
    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $contrato,
    );
    $result = ws_GET_ParamsContract($dataInput);

    if ($result["retorno"] == 0) {
        $cobroAdministracionMensual = $result["cobroAdministracionMensual"];
        $comisionAvance = $result["comisionAvance"];
        $valorDesgravamen = $result["valorDesgravamen"];
    } else {
        $cobroAdministracionMensual = 0;
        $comisionAvance = 0;
        $valorDesgravamen = 0;
    }



        /******
        Consulta últimos Pagos registrados del cliente
         *******/

        $dateBegin = "";
        $dateEnd = "";
        $typeSkill = "005";

        $dataInput = array(
            "nroRut" => $nroRut,
            "contrato" => $contrato,
            "flg_flujo" => $flg_flujo,
            "cantidad_pagos" => 3,
            "username" => $username,
        );

        $result = ws_GET_ConsultaPagosRene($dataInput);
        $dataPayment = $result["htmlPayment"];

        $value["htmlDetalle"] = "<table class='table table-striped table-bordered'>
          <tbody>
          <tr><td class='text-left'>Deuda Actual</td>
          <td class='text-center'>" . $value["deudaActual"] . "</td></tr>
          <tr><td class='text-left'>Saldo Honorario Cobranza (-)</td>
          <td class='text-center'>$" . number_format((float) $amount_expenses, 0, ",", ".") . "</td></tr>
          <tr><td class='text-left'>Intereses (-)</td>
          <td class='text-center'>$" . number_format((float) $amount_interest, 0, ",", ".") . "</td></tr>
          <tr><td class='text-left'>Gastos (-)</td>
          <td class='text-center'>$" . number_format((float) $amount_expenses, 0, ",", ".") . "</td></tr>
          <tr><td class='text-left'>Seguros (-)</td>
          <td class='text-center'>$" . number_format((float) $amount_secure, 0, ",", ".") . "</td></tr>
          <tr><td class='text-left'>Valor Notaria (-)</td>
          <td class='text-center'>$" . number_format((float) $amount_notary, 0, ",", ".") . "</td></tr>
          <tr><td class='text-left'>Impuesto (-)</td>
          <td class='text-center'>$" . number_format((float) $amount_taxes, 0, ",", ".") . "</td></tr>
          <tr><td class='text-left'>Total Monto a Condonar (-)</td>
          <td class='text-center'>$" . number_format((float) $amount_condone, 0, ",", ".") . "</td></tr>
          <tr><td class='text-left'><b>Total Monto a Renegociar</b></td>
          <td class='text-center'><b>$" . number_format((float) $amount_renegotiate, 0, ",", ".") . "</b></td></tr>
          </tbody></table>";

        if ($flg_flujo == "001") {

            $idTrx = COD_TRX_REN_SIN_DIFERIDO_001;

        } else {

            $idTrx = COD_TRX_REN_SIN_DIFERIDO_002;
        }

        /* Begin Genera alternativas pago renegociación */
        $dataInput = array(
            "nroTcv" => $dataHomologador["nroTcv"],
            "nroRut" => $nroRut,
            "idTrx" => $idTrx,
            "amount" => $amount_renegotiate,
            "numberQuotas" => $number_quotes_begin,
            "deferredQuotas" => $deferred_quotes_begin,
            "flagCriterio" => COD_CRITERIO_CUOTAS,
            "username" => $username,
            "montoPrimaCL" => $montoPrimaCL,
            "cobroAdministracionMensual" => $cobroAdministracionMensual,
        );
        $result = ws_GET_Payment_Alternatives_REN($dataInput);
        if ($result["retorno"] == 0) {

            $value["dataSimulate"] = $result["htmlSimulate"];
            $value["lastLine"] = $result["lastLine"];
            $value["lastQuota"] = $result["lastQuota"];
            $value["interesRate"] = $result["interesRate"];
            $value["dateFirstExpiration"] = $result["dateFirstExpiration"];

            $value['amountSecureNormal'] = $montoPrimaCL;
            $value['dateEndNormal'] = $result["dateFirstExpiration"];

            $value['amountSecureDifer'] = $montoPrimaCL;
            $value['dateEndDifer'] = $result["dateFirstExpiration"];

            $value['amount_renegotiate'] = $amount_renegotiate;
            $value['amount_admin'] = $cobroAdministracionMensual;

        } else {

            $value['amountSecureNormal'] = $montoPrimaCL;
            $value['amountSecureDifer'] = $montoPrimaCL;
            $value['amount_renegotiate'] = $amount_renegotiate;
            $value['amount_admin'] = $cobroAdministracionMensual;
        }

        $detail_renegotiation["amount_debit"] = $amount_debit;
        $detail_renegotiation["amount_collections"] = $amount_collections;
        $detail_renegotiation["amount_interest"] = $amount_interest;
        $detail_renegotiation["amount_expenses"] = $amount_expenses;
        $detail_renegotiation["amount_secure"] = $amount_secure;
        $detail_renegotiation["amount_notary"] = $amount_notary;
        $detail_renegotiation["amount_taxes"] = $amount_taxes;
        $detail_renegotiation["amount_condone"] = $amount_condone;
        $detail_renegotiation["amount_renegotiate"] = $amount_renegotiate;
        $detail_renegotiation["contrato"] = $contrato;
        $detail_renegotiation["nroTcv"] = $nroTcv;
        $this->session->set_userdata("detail_renegotiation", $detail_renegotiation);

        if($value["diasMora"]>$days_is_over_end){

            $descRetorno = "Cliente con " . $value["diasMora"] . " Días Mora, Excede máximo permitido de " . $days_is_over_end . " Días.";
            cancel_function(10, $descRetorno, "");
        }


        /*******
        Checking Collection
         ********/
        $value["warning_message"] = "";
        $value["warning_title"] = "";
        $value["warning_days"] = 0;
        $value["warning_amount"] = 0;
        $value["warning_renegotiation"] = 0;
        $value["warning_reason"] = "";
        $value["warning_type"] = "N";

        $dataInput = array(
            "nroRut" => $nroRut,
            "today" => date("d-m-Y"),
        );
        $result = ws_GET_ConsultaMoraVirtual($dataInput);
        if ($result["retorno"] == 0) {

            $today = date("Ymd");
            if ($result["dateEnd"] >= $today) {

                $value["warning_title"] = "<h2><strong>Aviso Cobranza</strong></h2>";
                $value["warning_message"] = "<h4>Cliente autorizado por " . $result["ejecutivo"] . " hasta el " . $result["fechaFinVigencia"] . " ";
                $value["warning_message"] .= "con motivo: " . $result["motivo"] . "</h4>";

                $value["warning_reason"] = $result["motivo"];
                $value["warning_approver"] = $result["retorno"];
                $value["warning_collection"] = $result["retorno"];
            }
        }


        if ($value["warning_title"] == "") {

            if ((float) $amount_deudaActual < $amount_is_over_begin or (float) $amount_deudaActual > $amount_is_over_end):
                $value["warning_amount"] = 1; endif;

            if ($value["diasMora"] < $days_is_over_begin):
                $value["warning_days"] = 1; endif;

            if ($nroReneg >= $number_opers_end):
                $value["warning_renegotiation"] = 1; endif;

            $value["warning_message"] .= "<h4>Cliente no cumple politica en Variable: ";
            $value["warning_reason"] .= "Cliente no cumple politica en Variable: ";
            $flg_concat = false;

            if ($value["warning_payment"] == 1) {
                $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                $value["warning_message"] .= "Abono Mínimo <strong>$" . number_format((float) $amount_pago_minimo, 0, ',', '.') . "</strong>";
                $value["warning_reason"] .= "Abono Mínimo $" . number_format((float) $amount_pago_minimo, 0, ',', '.');
                $flg_concat = true;
            }

            if ($value["warning_days"] == 1) {
                $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                if($flg_concat){

                  $value["warning_message"] .=  ", Días Mora <strong>" . $value["diasMora"] . "</strong>";
                  $value["warning_reason"] .=   ", Días Mora " . $value["diasMora"];
                }else{

                  $value["warning_message"] .=  "Días Mora <strong>" . $value["diasMora"] . "</strong>";
                  $value["warning_reason"] .=   "Días Mora " . $value["diasMora"];
                  $flg_concat = true;
                }
            }

            if ($value["warning_amount"] == 1) {
                $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                if($flg_concat){

                  $value["warning_message"] .= ", Deuda <strong>" . number_format((float) $amount_deudaActual, 0, ',', '.') . "</strong>";
                  $value["warning_reason"] .= ", Deuda " . number_format((float) $amount_deudaActual, 0, ',', '.');
                }else{

                  $value["warning_message"] .= "Deuda <strong>" . number_format((float) $amount_deudaActual, 0, ',', '.') . "</strong>";
                  $value["warning_reason"] .= "Deuda " . number_format((float) $amount_deudaActual, 0, ',', '.');
                  $flg_concat = true;
                }
            }

            if ($value["warning_renegotiation"] == 1) {
                $value["warning_title"] = "<h2><strong>Preste Atención</strong></h2>";
                if($flg_concat){

                  $value["warning_message"] .= ", N° Renegociaciones Vigentes <strong>" . $nroReneg . "</strong>";
                  $value["warning_reason"] .= ", N° Renegociaciones Vigentes " . $nroReneg;
                }else{

                  $value["warning_message"] .= "N° Renegociaciones Vigentes <strong>" . $nroReneg . "</strong>";
                  $value["warning_reason"] .= "N° Renegociaciones Vigentes " . $nroReneg;
                  $flg_concat = true;
                }
            }
            $value["warning_message"] .= "</h4></br></br>";

        }

        if ($value["warning_title"] == "") {

            $value["warning_message"] = "";
            $value["warning_reason"] = "";
            $value["warning_type"] = "N";

        } else {

            $value["warning_type"] = "E";
        }

        /********
        Datos para retorno / Checking Collection Client
         *********/

        $value["completeNameClient"] = $dataClient["nombreCliente"];
        $value["nameClient"] = $dataClient["nombres"];
        $value["lastnameClient"] = $dataClient["apellidoPaterno"] . " " . $dataClient["apellidoMaterno"];

        $value["sexoClient"] = $dataClient["sexo"];
        $value["fechaNacimiento"] = $dataClient["fechaNacimiento"];
        $value["nroserie"] = $dataClient["nroserie"];
        $value["nroTcv"] = $dataHomologador["nroTcv"];
        $value["offTcv"] = "****-****-****-" . substr($dataHomologador["nroTcv"], 12, 4);
        $value["id_rol"] = $this->session->userdata("id_rol");
        $value["htmlCupos"] = $htmlCupos;
        $value["nroReneg"] = $nroReneg;

        $value["dataAccount"] = $dataAccount;
        $value["dataSecure"] = $dataSecure;
        $value["dataPayment"] = $dataPayment;

        $value["flg_flujo"] = $dataHomologador["flg_flujo"];
        $value["retorno"] = $dataClient["retorno"];
        $value["descRetorno"] = $dataClient["descRetorno"];

        $dataSession["flg_flujo"] = $dataHomologador["flg_flujo"];
        $dataSession["nroTcv"] = $dataHomologador["nroTcv"];
        $this->session->set_userdata("dataSession", $dataSession);

        $data = $value;
        echo json_encode($data);
    }

private function ws_GET_Concepts_REN($dataInput)
{

    $nroRut = str_replace('.', '', $dataInput["nroRut"]);
    $nroRut = str_replace('-', '', $nroRut);
    $nroRut = substr($nroRut, 0, -1);

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaConceptosRene/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
           <req:nro_rut>' . $nroRut . '</req:nro_rut>
           <req:contrato>' . $dataInput["contrato"] . '</req:contrato>
           <req:flag_flujo>' . $dataInput["flg_flujo"] . '</req:flag_flujo>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaConceptosRene;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaConceptosRene, WS_Timeout30, $Request, WS_ToXml, $dataInput["username"]);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaConceptosRene);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int) $xml->Body->DATA->retorno;
    $descRetorno = (string) $xml->Body->DATA->descRetorno;

    if ($retorno == 0) {

        $value["interes"] = (string) $xml->Body->DATA->Registro->interes;
        $value["honorarios_cobranza"] = (string) $xml->Body->DATA->Registro->honorarios_cobranza;
        $value["deuda_a_renegociar"] = (string) $xml->Body->DATA->Registro->deuda_a_renegociar;
        $value["impuesto"] = (string) $xml->Body->DATA->Registro->impuesto;
    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["xmlDocument"] = $xml;

    $data = $value;
    return ($data);
}

public function validate_save_renegotiation(){

    $return = check_session("");
/* Datos Personales Cliente */
    $this->form_validation->set_rules('number_rut_client', 'Rut Cliente', 'required|trim');
    $this->form_validation->set_rules('nameClient', 'Nombre Cliente', 'required|trim');
    $this->form_validation->set_rules('lastnameClient', 'Apellidos Cliente', 'required|trim');
    $this->form_validation->set_rules('payment_type', 'Tipo Renegociación', 'required|trim');
    $this->form_validation->set_rules('days_over', 'Días Mora', 'required|trim');
    $this->form_validation->set_rules('flg_flujo', 'Canal Origen Cliente', 'required|trim');
    $this->form_validation->set_rules('nroReneg', 'Número Renegociaciones', 'required|trim');
/* Telefonos del Cliente */
    $this->form_validation->set_rules('number_phone', 'Número Teléfono Móvil', 'numeric|trim');
    $this->form_validation->set_rules('email', 'Email Cliente', 'valid_email|trim');

/* Datos Operación Renegociación */
    $this->form_validation->set_rules('number_quotes', 'Número de Cuotas', 'required|numeric|trim');
    $this->form_validation->set_rules('deferred_quotes', 'Número de Diferidas', 'required|numeric|trim');
    $this->form_validation->set_rules('first_date_expires_quotes', 'Fecha Primer Vencimiento', 'required|trim');
    $this->form_validation->set_rules('amount_quotes_secure', 'Monto Seguro Desgravamen', 'required|trim');

    $this->form_validation->set_rules('amount_quotes_value', 'Valor Cuota', 'required|trim');
    $this->form_validation->set_rules('amount_quotes_taxes', 'Impuestos', 'required|trim');
    $this->form_validation->set_rules('amount_quotes_rate', 'Tasa de Interes', 'required|trim');
    $this->form_validation->set_rules('amount_cae_rate', 'CAE ', 'required|trim');
    $this->form_validation->set_rules('amount_renegotiate', 'Monto Renegociación', 'required|trim');
    $this->form_validation->set_rules('amount_total_renegotiate', 'Monto Total Crédito', 'required|trim');

    $this->form_validation->set_message('valid_email', 'El atributo %s no es valido..');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('alpha', 'El atributo %s debe ser alfabetico..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    $this->form_validation->set_message('alpha_numeric', 'El atributo %s debe ser alfanumerico sin espacios..');
    $this->form_validation->set_message('max_length', 'El atributo %s excede largo máximo..');
    if ($this->form_validation->run() == false) {
        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    $result = $this->parameters->getall_renegotiationMontoMora();
    if (!$result) {
        cancel_function(COD_ERROR_VALID_FORM, "Parámetro Mínimo y Máximo Montos Mora, no definidos<br><br>Comuniquese con Mesa de Ayuda", "");
    } else {
        $amount_is_over_begin = (float) $result->MINIMO;
        $amount_is_over_end = (float) $result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationDiasMora();
    if (!$result) {
        cancel_function(COD_ERROR_VALID_FORM, "Parámetro Mínimo y Máximo Días Mora, no definidos<br><br>Comuniquese con Mesa de Ayuda", "");
    } else {
        $days_is_over_begin = (int) $result->MINIMO;
        $days_is_over_end = (int) $result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationMontoCuota();
    if (!$result) {
        cancel_function(COD_ERROR_VALID_FORM, "Parámetro Mínimo y Máximo Montos Cuota, no definidos<br><br>Comuniquese con Mesa de Ayuda", "");
    } else {
        $amount_quotes_begin = (float) $result->MINIMO;
        $amount_quotes_end = (float) $result->MAXIMO;
    }

    $result = $this->parameters->getall_renegotiationOpers();
    if (!$result) {
        cancel_function(COD_ERROR_VALID_FORM, "Parámetro Número Renegociaciones, no definido<br><br>Comuniquese con Mesa de Ayuda", "");
    } else {
        $number_opers_begin = (int) $result->MINIMO;
        $number_opers_end = (int) $result->MAXIMO;
    }

    $result = $this->parameters->get_quotasByProduct(CODIGO_RENEGOCIACION);
    if (!$result) {
        cancel_function(COD_ERROR_VALID_FORM, "Parámetro Número Mínimo y Máximo Cuotas Renegociaciones, no definido<br><br>Comuniquese con Mesa de Ayuda", "");
    } else {
        $number_quotes_begin = (int) $result->CUOTAS_MINIMO;
        $number_quotes_end = (int) $result->CUOTAS_MAXIMO;
    }

    $result = $this->parameters->get_deferredByProduct(CODIGO_RENEGOCIACION);
    if (!$result) {
        cancel_function(COD_ERROR_VALID_FORM, "Parámetro Número Mínimo y Máximo Cuotas Diferidas Renegociaciones, no definido<br><br>Comuniquese con Mesa de Ayuda", "");
    } else {
        $deferred_quotes_begin = (int) $result->CUOTAS_MINIMO;
        $deferred_quotes_end = (int) $result->CUOTAS_MAXIMO;
    }

    $number_phone = $this->input->post("number_phone");
    if (strlen($number_phone) > 9) {$number_phone = substr($number_phone, -9);}
    if ($number_phone != "") {
        if (substr($number_phone, 0, 1) == "9") {
            $result = get_ValidatePhoneMobile($number_phone);
        } else {
            $result = get_ValidatePhonePermanent($number_phone);
        }
        if ($result["retorno"] != 0) {

            cancel_function($result["retorno"], $result["descRetorno"], "");
        }
    } else {
        $number_phone = "999999999";
    }

    $nroRut = $this->input->post("number_rut_client");
    $flg_flujo = $this->input->post("flg_flujo");
    $username = $this->session->userdata("username");

    $amount_renegotiate = str_replace(".", "", $this->input->post("amount_renegotiate"));
    $amount_renegotiate = str_replace("$", "", $amount_renegotiate);
    $amount_total_renegotiate = str_replace(".", "", $this->input->post("amount_total_renegotiate"));
    $amount_total_renegotiate = str_replace("$", "", $amount_total_renegotiate);
    $amount_quotes_secure = str_replace(".", "", $this->input->post("amount_quotes_secure"));
    $amount_quotes_secure = str_replace("$", "", $amount_quotes_secure);
    $amount_quotes_value = str_replace(".", "", $this->input->post("amount_quotes_value"));
    $amount_quotes_value = str_replace("$", "", $amount_quotes_value);
    $amount_quotes_taxes = str_replace(".", "", $this->input->post("amount_quotes_taxes"));
    $amount_quotes_taxes = str_replace("$", "", $amount_quotes_taxes);
    $amount_quotes_rate = str_replace(",", ".", $this->input->post("amount_quotes_rate"));
    $amount_quotes_rate = str_replace("%", "", $amount_quotes_rate);
    $amount_cae_rate = str_replace(",", ".", $this->input->post("amount_cae_rate"));
    $amount_cae_rate = str_replace("%", "", $amount_cae_rate);
    $first_date_expired_quotes = str_replace("/", "-", $this->input->post("first_date_expires_quotes")) . " 09:00:00";

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"] != 0) {
        cancel_function(10, $dataHomologador["descRetorno"], "");
    }
    $flg_flujo = $dataHomologador["flg_flujo"];
    $nroTcv = $dataHomologador["nroTcv"];

    /*********
    Datos Cuenta Cliente / Número de Contrato
     **********/
    $dataCuenta = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
    if ($dataCuenta["retorno"] != 0) {
        cancel_function(COD_ERROR_INIT, $dataCuenta["descRetorno"], "");
    }
    $contrato = (string) $dataCuenta["contrato"];

    /*********
    Checking Params Contract
     **********/
    $dataInput = array(
        "nroRut" => $nroRut,
        "contrato" => $contrato,
    );
    $result = ws_GET_ParamsContract($dataInput);

    if ($result["retorno"] == 0) {
        $cobroAdministracionMensual = $result["cobroAdministracionMensual"];
        $comisionAvance = $result["comisionAvance"];
        $valorDesgravamen = $result["valorDesgravamen"];
    } else {
        $cobroAdministracionMensual = 0;
        $comisionAvance = 0;
        $valorDesgravamen = 0;
    }

    $dataInput = array(
        'nroRut' => $nroRut,
        'nroTcv' => $nroTcv,
        'contrato' => $contrato,
        'flg_flujo' => $flg_flujo,
        'username' => $username,
    );
    $dataDeuda = ws_GET_ConsultaDeudaClienteTC($dataInput);

    /*********
    Cupos Vigentes antes Renegociacion
     **********/
    $cupoCompraAnterior = 0;
    $cupoAvanceAnterior = 0;
    $result = ws_GET_ConsultaCuposTC($nroTcv, $contrato, $flg_flujo, $username);
    if ($result["retorno"] == 0) {
        foreach ($result["dataResponse"] as $key) {
            if ($key["codigolinea"] == 1) {$cupoCompraAnterior = $key["cupo"];}
            if ($key["codigolinea"] == 2) {$cupoAvanceAnterior = $key["cupo"];}
        }
    }

    if ((float) $amount_quotes_value < (float) $amount_quotes_begin) {
        cancel_function(COD_ERROR_VALID_FORM, "Valor Cuota es menor al permitido de $" . number_format((float) $amount_quotes_begin, 0, ',', '.') . " para Renegociaciones..", "");
    }

    if ((float) $amount_quotes_value > (float) $amount_quotes_end) {
        cancel_function(COD_ERROR_VALID_FORM, "Valor Cuota excede el permitido de $" . number_format((float) $amount_quotes_end, 0, ',', '.') . " para Renegociaciones..", "");
    }

    $days_over = $this->input->post("days_over");
    $number_quotes = $this->input->post("number_quotes");
    if ((int) $number_quotes < (int) $number_quotes_begin) {
        cancel_function(COD_ERROR_VALID_FORM, "Número de Cuotas es menor al permitido para Renegociaciones..", "");
    }
    if ((int) $number_quotes > (int) $number_quotes_end) {
        cancel_function(COD_ERROR_VALID_FORM, "Número de Cuotas excede el permitido para Renegociaciones..", "");
    }
    $deferred_quotes = $this->input->post("deferred_quotes");
    if ((int) $deferred_quotes < (int) $deferred_quotes_begin) {
        cancel_function(COD_ERROR_VALID_FORM, "Número Diferidos es menor al permitido para Renegociaciones..", "");
    }
    if ((int) $deferred_quotes > (int) $deferred_quotes_end) {
        cancel_function(COD_ERROR_VALID_FORM, "Número Diferidos excede el permitido para Renegociaciones..", "");
    }

    if($dataDeuda["retorno"]==0){

        if(($dataDeuda["producto"]=="01" and $dataDeuda["subproducto"]=="0001") OR
           ($dataDeuda["producto"]=="01" and $dataDeuda["subproducto"]=="0002")){
            if($amount_renegotiate > MONTO_DEUDA_MAX_RENEGOCIACION_COMPRAS){

                cancel_function(COD_ERROR_VALID_FORM, "Monto Excede máximo cupo permitido para Renegociaciones..", "");
            }
        }
        if(($dataDeuda["producto"]=="01" and $dataDeuda["subproducto"]=="0004") OR
           ($dataDeuda["producto"]=="02" and $dataDeuda["subproducto"]=="0001")){
            if($amount_renegotiate > MONTO_DEUDA_MAX_RENEGOCIACION_REVOLVING){

                cancel_function(COD_ERROR_VALID_FORM, "Monto Excede máximo cupo permitido para Renegociaciones..", "");
            }
        }
    }else{

          cancel_function(COD_ERROR_VALID_FORM, "Problemas al intentar leer Deuda del Cliente..", "");
    }

    /* Datos Detalle Renegociación
    registramos valores en funcion [evaluation_client]
     */
    $detail = $this->session->userdata("detail_renegotiation");
    $detail["amount_interest"] = $amount_quotes_rate;
    if ((float) $amount_renegotiate >= (float) MONTO_DEUDA_RENEGOCIACION) {

        $amount_purchase = 100000;
        $amount_advance = 0;

     } else {

        $amount_purchase = 50000;
        $amount_advance = 0;
    }

    if ($this->input->post("virtualApprover") == "") {
        $approver = 0;
    } else {
        $approver = 1;
    }

    $collection = 0;
    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut);
    $dataSession = $this->session->userdata("dataSession");

    $data = array(
        'tipoRef' => "RM",
        'date_stamp' => date('d-m-Y H:i:s'),
        'number_rut_client' => substr($nroRut, 0, -1),
        'digit_rut_client' => substr($nroRut, -1),
        'flg_flujo' => $flg_flujo,
        'flg_type' => $this->input->post("flg_type"),
        'nameClient' => $this->input->post("nameClient"),
        'lastnameClient' => $this->input->post("lastnameClient"),
        'lblDireccion' => $this->input->post("lblDireccion"),
        'id_user' => $this->session->userdata("id_user"),
        'id_office' => $this->session->userdata("id_office"),
        'email' => $this->input->post("email"),
        'amount_renegotiate' => $amount_renegotiate,
        'amount_total_renegotiate' => $amount_total_renegotiate,
        'number_phone' => $number_phone,
        'payment_type' => $this->input->post("payment_type"),
        'deferred_quotes' => $this->input->post("deferred_quotes"),
        'number_quotes' => $this->input->post("number_quotes"),
        'first_date_expires_quotes' => $first_date_expired_quotes,
        'amount_quotes_secure' => $amount_quotes_secure,
        'amount_quotes_taxes' => $amount_quotes_taxes,
        'amount_quotes_rate' => $amount_quotes_rate,
        'amount_cae_rate' => $amount_cae_rate,
        'amount_quotes_value' => $amount_quotes_value,
        'contrato' => $contrato,
        'nroTcv' => $nroTcv,
        'amount_purchase' => $amount_purchase,
        'amount_advance' => $amount_advance,
        'amount_minimum' => $dataSession["pagoMinimo"],

        'cobroAdministracionMensual' => $cobroAdministracionMensual,
        'comisionAvance' => $comisionAvance,
        'valorDesgravamen' => $valorDesgravamen,
        'diasMora' => $this->input->post("days_over"),
        'renesVigentes' => $this->input->post("nroReneg"),

        'reason' => $this->input->post("reason"),
        'approver' => $approver,
        'collection' => $collection,

        'amount_debit' => $detail["amount_debit"],
        'amount_collections' => $detail["amount_collections"],
        'amount_interest' => $detail["amount_interest"],
        'amount_expenses' => $detail["amount_expenses"],
        'amount_secure' => $detail["amount_secure"],
        'amount_notary' => $detail["amount_notary"],
        'amount_taxes' => $detail["amount_taxes"],
        'amount_condone' => $detail["amount_condone"],
        'amount_detail_renegotiate' => $detail["amount_renegotiate"],

        'cupoCompraAnterior' => $cupoCompraAnterior,
        'cupoAvanceAnterior' => $cupoAvanceAnterior,
        'username' => $username,
    );
    $result = ws_PUT_Renegotiation($data);
    if ($result["retorno"] != 0) {
        $data = $result;
        echo json_encode($data);
        exit(0);
    }
    $this->session->set_userdata("number_authorizing", $result["idRefinanciamiento"]);

    $first_date_expired_quotes = substr($result["fecha1erVencimiento"], 6, 4) . "-";
    $first_date_expired_quotes .= substr($result["fecha1erVencimiento"], 3, 2) . "-";
    $first_date_expired_quotes .= substr($result["fecha1erVencimiento"], 0, 2);

    $data = array(
        'autorizador' => $result["idRefinanciamiento"],
        'number_rut_client' => substr($nroRut, 0, -1),
        'digit_rut_client' => substr($nroRut, -1),
        'name_client' => $this->input->post("nameClient") . " " . $this->input->post("lastnameClient"),
        'id_user' => $this->session->userdata("id_user"),
        'id_office' => $this->session->userdata("id_office"),
        'amount' => $amount_renegotiate,
        'number_phone' => $number_phone,
        'payment_type' => $this->input->post("payment_type"),
        'deferred_quotes' => $this->input->post("deferred_quotes"),
        'number_quotes' => $this->input->post("number_quotes"),
        'first_date_expires_quotes' => $first_date_expired_quotes,
        'amount_quotes_secure' => $amount_quotes_secure,
        'amount_quotes_taxes' => $amount_quotes_taxes,
        'amount_quotes_rate' => $amount_quotes_rate,
        'amount_quotes_value' => $amount_quotes_value,

        'amount_debit' => $detail["amount_debit"],
        'amount_collections' => $detail["amount_collections"],
        'amount_interest' => $detail["amount_interest"],
        'amount_expenses' => $detail["amount_expenses"],
        'amount_secure' => $detail["amount_secure"],
        'amount_notary' => $detail["amount_notary"],
        'amount_taxes' => $detail["amount_taxes"],
        'amount_condone' => $detail["amount_condone"],
        'amount_renegotiate' => $detail["amount_renegotiate"],
        'number_approval' => $result["codAutorizacion"],
    );

    $journal = $this->journal->add_Renegotiation($data);
    if ($journal["retorno"] != 0) {
        $data = $journal;
        echo json_encode($data);
        exit(0);
    }

    $data = $result;
    echo json_encode($data);
}


public function list_process_renegotiation()
{

    $return = check_session("");

    $this->form_validation->set_rules('masked_rut_client', 'Rut Cliente', 'trim');
    $this->form_validation->set_rules('status', 'Estado Renegociación', 'required|trim');
    $this->form_validation->set_rules('username', 'Usuario Identificador', 'trim');
    $this->form_validation->set_rules('dateBegin', 'Fecha Inicio', 'required|trim');
    $this->form_validation->set_rules('dateEnd', 'Fecha Termino', 'required|trim');

    $this->form_validation->set_message('valid_email', 'El atributo %s no es valido..');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('alpha', 'El atributo %s debe ser alfabetico..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    $this->form_validation->set_message('alpha_numeric', 'El atributo %s debe ser alfanumerico sin espacios..');
    $this->form_validation->set_message('max_length', 'El atributo %s excede largo máximo..');
    if ($this->form_validation->run() == false) {
        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    $nroRut = str_replace('.', '', $this->input->post("masked_rut_client"));
    $nroRut = str_replace('-', '', $nroRut);
    $nroRut = substr($nroRut, 0, -1);
    $dateBegin = substr($this->input->post("dateBegin"), 6, 4) . "-" . substr($this->input->post("dateBegin"), 3, 2) . "-" . substr($this->input->post("dateBegin"), 0, 2);
    $dateEnd = substr($this->input->post("dateEnd"), 6, 4) . "-" . substr($this->input->post("dateEnd"), 3, 2) . "-" . substr($this->input->post("dateEnd"), 0, 2);

    $input = array(
        "nroRut" => $nroRut,
        "status" => $this->input->post("status"),
        "dateBegin" => $dateBegin,
        "dateEnd" => $dateEnd,
    );

    $result = $this->journal->list_process_renegotiation($input);

    $record = 0;

    foreach ($result as $key) {

        $eval = $this->parameters->get_renegotiationStatusById($key->status);
        if(!$eval):
            $estado = "estado: " . $key->status . " no definido ";
        else:
            $estado = $eval->NAME;
        endif;
        if($this->session->userdata("id_rol")==USER_ROL_JEFE_COBRANZA):

            if($key->status==1 OR $key->status==3):
                $accion = '<a href="javascript:Client.cancelRenegotiation('.$key->autorizador.');" class="btn btn-success btn-xs"><i class="fa fa-times" title="Cancelar"></i></a>';
            else:
                $accion = '<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-times" title="Cancelar"></i></a>';
            endif;
            $dataviews[] = array(
                $key->autorizador,
                number_format($key->number_rut_client, 0, ".", ".") . "-" . $key->digit_rut_client,
                $key->name_client,
                date("d-m-Y", strtotime($key->date_create)),
                $key->detail,
                $status1 = ($key->status_payment1 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" title="' . $key->response_payment1 . '"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true" title="' . $key->response_payment1 . '"></i>',
                $status2 = ($key->status_payment2 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" title="' . $key->response_payment2 . '"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true" title="' . $key->response_payment2 . '"></i>',
                $status3 = ($key->status_payment3 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" title="' . $key->response_payment3 . '"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true" title="' . $key->response_payment3 . '"></i>',
                $status4 = ($key->status_payment4 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" title="' . $key->response_payment4 . '"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true" title="' . $key->response_payment4 . '"></i>',
                $status5 = ($key->status_payment5 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" title="' . $key->response_payment5 . '"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true" title="' . $key->response_payment5 . '"></i>',
                $status6 = ($key->status_payment6 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" title="' . $key->response_payment6 . '"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true" title="' . $key->response_payment6 . '"></i>',
                $status7 = ($key->status_payment7 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" title="' . $key->response_payment7 . '"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true" title="' . $key->response_payment7 . '"></i>',
                $status8 = ($key->status_payment8 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true" title="' . $key->response_payment8 . '"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true" title="' . $key->response_payment8 . '"></i>',
                $accion,
                $estado,
            );

        else:    

            $dataviews[] = array(
                $key->autorizador,
                number_format($key->number_rut_client, 0, ".", ".") . "-" . $key->digit_rut_client,
                $key->name_client,
                date("d-m-Y", strtotime($key->date_create)),
                $key->detail,
                $status1 = ($key->status_payment1 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>',
                $status2 = ($key->status_payment2 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>',
                $status3 = ($key->status_payment3 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>',
                $status4 = ($key->status_payment4 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>',
                $status5 = ($key->status_payment5 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>',
                $status6 = ($key->status_payment6 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>',
                $status7 = ($key->status_payment7 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>',
                $status8 = ($key->status_payment8 == 1) ? '<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>' : '<i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i>',
                $estado,
            );
        endif;

        $record = $record + 1;
    }

    if ($record == 0):
        $data["data"] = array();
    else:
        $data["data"] = $dataviews;
    endif;

    echo json_encode($data);

}


public function cancelRenegotiation(){

    $return = check_session("");
    $this->form_validation->set_rules('id', 'Número Identificador', 'required|numeric|trim');
    $this->form_validation->set_message('required', 'El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric', 'El atributo %s debe ser numerico..');
    if ($this->form_validation->run() == false) {
        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }
    $number_authorizing = $this->input->post("id");

    $dataJou = $this->journal->get_renegotiationById($number_authorizing);
    if (!$dataJou):

        cancel_function(COD_ERROR_INIT, "No fue posible leer Renegociación en base LOCAL..!", "");
    endif;
    $nroRut = $dataJou->number_rut_client . "-" . $dataJou->digit_rut_client;

    $username = $this->session->userdata("username");

    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $username);
    if ($dataHomologador["retorno"] != 0) {

        cancel_function($dataHomologador["retorno"], $dataHomologador["descRetorno"], "");
    }
    $flg_flujo = $dataHomologador["flg_flujo"];
    $nroTcv = $dataHomologador["nroTcv"];

    $dataInput = array(
        "idRefinanciamiento" => $number_authorizing,
        "username" => $username,
        "flg_flujo" => $flg_flujo,
        "tipoRef" => "RM",
    );

    $result = ws_GET_ConsultaDetalleRene($dataInput);
    if ($result["retorno"] != 0) {
        cancel_function(COD_ERROR_INIT, $result["descRetorno"], "");
    }

    $status_exception = $result["estadoExcepcion"];

    $dataInput = array(
        "flg_flujo" => $flg_flujo,
        "idUnicoDeTrx" => $result["idRefinanciamiento"],
        "username" => $username,
        "username_visa" => "",
        "status_visa" => "U",
        "date_stamp_visa" => "",
        "username_accept" => "",
        "date_stamp_accept" => "",
        "username_liquidation" => "",
        "date_stamp_liquidation" => "",
        "username_exception" => $username,
        "date_stamp_exception" => date("d-m-Y"),
        "status_exception" => $result["estadoExcepcion"],
        "codeDeny" => "",
        "aprobadoConRevision" => $dataJou->status_check,
        "motivoRechazo" => "",
        "estadoScript" => "",
        "motivoScript" => "",
    );

    $eval = ws_PUT_ActualizaEstadoRenegotiation($dataInput);
    if ($eval["retorno"] != 0) {
        cancel_function($eval["retorno"], $eval["descRetorno"], "");
    }

    $data = array(
        "status" => 7,
        "status_name" => "ANULADA",
        "date_authorizes" => date("Y-m-d H:i:s"),
        "id_user_authorizes" => $this->session->userdata("id_user"),
    );
    $result = $this->journal->upd_RenegotiationById($number_authorizing, $data);

    $data = $result;
    echo json_encode($data);

}


public function list_schedule()
{
    $dataArrays = array();
    $task = $this->parameters->get_task();
    foreach ($task as $nodo) {
        $dataArrays[] = array(
            $nodo->correl,
            $nodo->username,
            $nodo->name_office,
            $nodo->detail,
            date("d-m-Y", strtotime($nodo->stamp)),
            date("H:i:s", strtotime($nodo->stamp_begin)),
            date("H:i:s", strtotime($nodo->stamp_end)),
            $nodo->status,
            $nodo->type_status,
        );
    }
    $data["data"] = $dataArrays;
    echo json_encode($data);
}

  public function get_mysqli(){
      $db = (array) get_instance()->db;
      return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);
  }

}
