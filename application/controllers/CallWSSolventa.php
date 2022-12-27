<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class CallWSSolventa extends CI_Controller {

    public function __construct() {
    parent::__construct();

    $this->load->model("Users_model","user");
    $this->load->model("Motivosrechazo_model","motivos");
    $this->load->model("Journal_model","journal");

    $this->load->library( array('Soap', 'Rut', 'form_validation') );
    $this->load->helper( array('funciones_helper', 'ws_solventa_helper', 'teknodatasystems_helper') );

    $site_lang = $this->session->userdata('site_lang');
    if ($site_lang) {$this->lang->load('header',$this->session->userdata('site_lang')); }
    else {$this->lang->load('header','spanish');}

    date_default_timezone_set('America/Santiago');
}

public function get_client() {

    $return = check_session("");

/* Datos Session Cliente */
    $nombrecliente = $this->session->userdata('nombre_cliente')." ".$this->session->userdata('apellido_cliente');
    $id_office = $this->session->userdata("id_office");
    $username = $this->session->userdata("username");
    $nroTcv = $this->session->userdata('nroTcv'); $nroTcv = str_replace('-', '', $nroTcv);
    $flg_flujo = $this->session->userdata('flg_flujo');
    $expired_customer = $this->session->userdata('expired_customer');
    $id_product = $this->session->userdata("id_product");

/*
 * Graba Motivo Atención Visita En CORE
 */

    $nroRut = $this->input->post("nroRut");
    if($expired_customer=="N"){

        $reasonSkill = $this->input->post("reasonSkill"); $reasonDetail = $this->input->post("reasonDetail");
        $visitasquery = $this->user->motivos->obtenervisita($reasonSkill);
        $descReason = $visitasquery->NAME;
        if($reasonSkill==COD_OTRO_MOTIVO_ATENCION){
            $descReason = $reasonDetail;
        }

    }else{

        $reasonSkill = "115020";
        $descReason = "Cliente Castigado se informa que debe dirigirse a plataforma Emerix";

    }

    $result = ws_PUT_GrabarRazonVisitaTC($nroRut, $reasonSkill, $descReason, $username, $id_office);
    $result = ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username);
    if($result["retorno"]==0) {

        $contrato = $result["contrato"];
        $this->session->set_userdata("sessDatosCuenta", json_encode($result) );

    } else {

      $data = $result;
      echo json_encode($data); exit(0);

    }

    $result = ws_GET_ConsultaDatosTarjetaTC($nroTcv, $contrato, $flg_flujo, $username);
    $datosTarjeta = json_decode($result);

    if($datosTarjeta->retorno==0) {

        $this->session->set_userdata("sessDatosTarjeta", $result );

        foreach ($datosTarjeta->tarjetas as $field) {
            $descripcionTarjeta = $field->descripcion;
            $descripcionMarca = $field->desmarca;
        }

    } else {

      $data = $datosTarjeta;
      echo json_encode($data); exit(0);

    }

    $arrDataProductos = array();

    $result = $this->get_DatosProductoTC($nroRut, $nroTcv, $flg_flujo, $username);
    if($result["retorno"]==0) {

        $this->session->set_userdata("sessDatosProducto", $result["product_client"]);
        $arrDataProductos = json_decode($result["product_client"], true);
    }

    $rut_client = explode("-", str_replace('.', '', $nroRut)); 

    /*
     * Asigna nroRut cliente para uso en Session
     */

    $this->session->set_userdata("nroRut", $nroRut);

    /*
     * Graba Tabla local TA_JOURNAL con atención del cliente
     */
        $data = array("id_user"=>$this->session->userdata('id'),
                    "number_rut_client"=> $rut_client[0],
                    "digit_rut_client"=>$rut_client[1],
                    "name_client"=>$nombrecliente,
                    "attention_client"=>$reasonSkill,
                    "detail"=>$descReason,
                    "id_office"=> $id_office
        );
        $this->db->insert('ta_journal', $data);
    /*
     * End
     */

    $data = array();

    $result = $this->ws_GET_ProductByRut($datosTarjeta, $arrDataProductos);
    $data["htmlProduct"] = $result["htmlProduct"];
    $this->session->set_userdata("htmlProduct", $result["htmlProduct"]);

    $result = $this->ws_GET_OffertByRut($nroRut);
    $data['htmlOffers'] = $result["htmlOffers"];
    $data['htmlOffersPopup'] = $result["htmlOffersPopup"];

    $data["retorno"] = 0;
    $data["descRetorno"] = "Transacción Aceptada";

    $this->session->set_userdata("htmlOffers", $result["htmlOffers"]);
    $this->session->set_userdata("htmlOffersPopup", $result["htmlOffersPopup"]);

    echo json_encode($data);

}


private function ws_GET_ProductByRut($datosTarjeta, $arrDataProductos){

    $htmlProduct = '<table class="table table-sm table-striped table-bordered ">
               <thead>
                    <tr>
                         <th class="text-center"><strong>Rut</strong></th>
                         <th class="text-center"><strong>Tipo Producto</strong></th>
                         <th class="text-center"><strong>N&#250;mero TCV</strong></th>
                         <th class="text-center"><strong>Estado Cuenta</strong></th>
                         <th class="text-center"><strong>Relaci&oacute;n</strong></th>
                         <th class="text-center"><strong>Origen</strong></th>
                     </tr>
                  </thead>
                  <tbody>';

    foreach ($datosTarjeta->tarjetas as $field) {
    $htmlProduct .= '<tr>
        <td class="text-center">'.$field->nroRut.'</div></td>
        <td class="text-center">'.$field->desmarca.'</td>
        <td class="text-center">****-****-****'.'-'.substr($field->pan,12,4).'</td>
        <td class="text-center"><span class="label label-success">'.$field->descripcion.'</span></td>
        <td class="text-center"><span class="label label-success">'.$field->relacion.'</span></td>
        <td class="text-center"><span class="label label-success">'.$this->session->userdata('origen').'</span></td>
    </tr>';
    }
    $htmlProduct .= '</tbody> </table>';

    $htmlProduct = $htmlProduct . '<table class="table table-sm table-striped table-bordered ">
               <thead>
                    <tr>
                         <th class="text-center"><strong>Producto</strong></th>
                         <th class="text-center"><strong>Fecha Contrataci&#243;n</strong></th>
                         <th class="text-center"><strong>Monto Contratado</strong></th>
                         <th class="text-center"><strong>Cuotas Contratadas</strong></th>
                         <th class="text-center"><strong>Cuotas Facturadas</strong></th>
                     </tr>
                  </thead>
                  <tbody>';
    foreach ($arrDataProductos as $record) {
        $htmlProduct = $htmlProduct . '<tr>';
        $htmlProduct = $htmlProduct . '<td class="text-center">'.$record["producto"].'</td>';
        $htmlProduct = $htmlProduct . '<td class="text-center">'.substr($record["fechaContratacion"],0,10).'</td>';
        $htmlProduct = $htmlProduct . '<td class="text-center">$'.number_format((float)$record["montoContratado"], 0, ',', '.').'</td>';
        $htmlProduct = $htmlProduct . '<td class="text-center">'.$record["cuotasContratadas"].'</td>';
        $htmlProduct = $htmlProduct . '<td class="text-center">'.$record["cuotasFacturadas"].'</td>';
        $htmlProduct = $htmlProduct . '</tr>';
    }
    $htmlProduct = $htmlProduct . '</tbody></table>';


    $data["htmlProduct"] = $htmlProduct;
    return ($data);

}
private function ws_GET_OffertByRut($nroRut){

    $data = array();
    $htmlOffers = '<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th class="text-center"><strong>Producto</strong></th>
        <th class="text-center"><strong>Campa&#241;a</strong></th>
        <th class="text-center"><strong>Estado</strong></th>
        <th class="text-center"><strong>Vigente Hasta</strong></th>
        <th class="text-center"><strong>Monto</strong></th>
        <th class="text-center"><strong>Acci&#243;n</strong></th>
    </tr>
    </thead><tbody>';

    $result = $this->ws_GET_OffertById($nroRut, CODIGO_SUPER_AVANCE, DESCRIP_SUPER_AVANCE);
    $htmlOffers .= $result["htmlOffers"];

    $result = $this->ws_GET_OffertById($nroRut, CODIGO_REFINANCIAMIENTO, DESCRIP_REFINANCIAMIENTO);
    $htmlOffers .= $result["htmlOffers"];

    $htmlOffersPopup = "";
    $this->session->set_flashdata('offersPopup', false);

    if($this->session->userdata("id_product")=="T"){

        if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL) {

            $dataInput = [ 
                "numdoc" => $nroRut,
                "tipdoc" => "RUT",
                "codProducto" => $this->session->userdata("id_product"),
                ];
            $capta = ws_GET_CapturingByRut($dataInput);
            if($capta["retorno"]==0) {

                if($capta["pan"]==""):

                    $htmlOffers .= '<tr >
                    <td class="text-center">'.DESCRIP_TARJETA_ABIERTA.'</td>
                    <td class="text-center">Cambio Producto a SPIN VISA</td>
                    <td class="text-center"><i class="fa fa-thumbs-up fa-2x"></i></td>
                    <td class="text-center">' . $capta["fecalta"] . '</td>
                    <td class="text-center">' . $capta["cupo"] . '</td>
                    <td class="text-center"><a href="javascript:Client.set_offer(1)" class="btn btn-xs btn-success"><i class="fa fa-thumbs-up"></i> Acepta Oferta </a></td>
                    </tr>';

                    $htmlOffersPopup = "<h3>Cliente " .$capta["nombres"]. " ". $capta["apaterno"] ." ". $capta["amaterno"]." <br>posee una oferta de <strong>CAMBIO DE PRODUCTO A SPIN VISA</strong> pre aprobada por un monto de <strong>" . $capta["cupo"] . "</strong></h3>";

                    $this->session->set_flashdata('offersPopup', true);
                    $this->session->set_flashdata('source', SOURCE_PRODUCT_CHANGE_NAME);
                    $this->session->set_flashdata('capturing_type'. SOURCE_PRODUCT_CHANGE_TYPE); 

                endif;

            }
        }
    }

    $htmlOffers .= '</tbody></table>';

    $data["htmlOffers"] = $htmlOffers;
    $data["htmlOffersPopup"] = $htmlOffersPopup;

    return ($data);

}


private function ws_GET_OffertById($nroRut, $id_campaign, $name_campaign){

        $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
        $data = array();
        $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
        <soapenv:Header/>
        <soapenv:Body>
           <req:DATA>
              <req:rut>'.$nroRut.'</req:rut>
              <req:tipoCampagna>'.$id_campaign.'</req:tipoCampagna>
           </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';
        $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_DatosOfertaTC;
        $soap = get_SOAP($EndPoint, WS_Action_DatosOfertaTC, WS_Timeout, $Request, WS_ToXml, $this->session->userdata("username"));

        $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_DatosOfertaTC);
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

            if((int)$xml->Body->DATA->response->estadoCampagna = 1){

                $estado = '<i class="fa fa-thumbs-up fa-2x"></i>';
                $htmlOffers_tr = '<tr style="background-color: yellow;" > ';

            }else{

                $estado = '<i class="fa fa-thumbs-down fa-2x"></i>';
                $htmlOffers_tr = ' <tr > ';
            }

            if(CODIGO_SUPER_AVANCE==$id_campaign){

                $htmlOffers = $htmlOffers_tr . '
                    <td class="text-center" style="font-weight: bold;">'.$name_campaign.'</td>
                    <td class="text-center" style="font-weight: bold;">APROBADO</td>
                    <td class="text-center" style="font-weight: bold;">'.$estado.'</td>
                    <td class="text-center" style="font-weight: bold;">'.substr($xml->Body->DATA->response->fechaVigencia,0,10).'</td>
                    <td class="text-center" style="font-weight: bold;">$'.number_format((float)$xml->Body->DATA->response->montoOferta, 0, ",", ".").'</td>
                    </tr>';

                $htmlOffers .= $htmlOffers_tr . '
                    <td class="text-center" style="font-weight: bold;">'.$name_campaign.'</td>
                    <td class="text-center" style="font-weight: bold;">PRE APROBADO</td>
                    <td class="text-center" style="font-weight: bold;">'.$estado.'</td>
                    <td class="text-center" style="font-weight: bold;">'.substr($xml->Body->DATA->response->fechaVigencia,0,10).'</td>
                    <td class="text-center" style="font-weight: bold;">$'.number_format((float)$xml->Body->DATA->response->montoPreaprobado, 0, ",", ".").'</td>
                    </tr>';

            }else{


                $htmlOffers .= '
                        <td class="text-center">'.$name_campaign.'</td>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center">'.$estado.'</td>
                        <td class="text-center">'.substr($xml->Body->DATA->response->fechaVigencia,0,10).'</td>
                        <td class="text-center">$'.number_format((float)$xml->Body->DATA->response->montoOferta, 0, ",", ".").'</td>
                        </tr>';
            }
 

        }else{

            $htmlOffers = '
            <td class="text-center" style="font-weight: bold;">'.$name_campaign.'</td>
            <td class="text-center" style="font-weight: bold;"></td>
            <td class="text-center" style="font-weight: bold;"><i class="gi gi-hand_up fa-2x"></i></td>
            <td class="text-center" style="font-weight: bold;"></td>
            <td class="text-center" style="font-weight: bold;"></td>
            <td class="text-center" style="font-weight: bold;"></td>
            </tr>';

        }

        $data["retorno"] = $retorno;
        $data["descRetorno"] = $descRetorno;
        $data["htmlOffers"] = $htmlOffers;

        return ($data);
}


public function search_client_by_rut() {

    $return = check_session("");

    $nroRut = $this->input->post("nroRut"); $username = $this->session->userdata("username");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'trim|required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){
        $value["html"] = "<h3><strong>" .validation_errors()."</strong></h3>";
        $data = $value;
        echo json_encode($data);
        exit(0);
    }
    $eval = validaRUTCL($nroRut);
    if($eval["retorno"]!=0){
        $value["html"] = "<h3><strong>" .$eval["descRetorno"]."</strong></h3>";
        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    $eval = ws_GET_HomologadorByRut($nroRut, $username);
    if($eval["retorno"]==401){
        $value["html"] = "<h3><strong>" .$eval["descRetorno"]."</strong></h3>";
        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    if($eval["retorno"]!=0) {

        if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL) {

            $dataInput["numdoc"] = $nroRut; $dataInput["tipdoc"] = "RUT";
            $dataInput["codProducto"] = "";
            $capta = ws_GET_CapturingByRut($dataInput);

            if($capta["retorno"]==0) {

                if($capta["pan"]==""):

                    $value["preaprobada"] = 1;
                    $value["retorno"] = $capta["retorno"];
                    $value["id_office"] = $this->session->userdata("id_office");
                    $value["html"] = "<h3>Cliente " .$capta["nombres"]. " ". $capta["apaterno"] ." ". $capta["amaterno"]." <br>tiene una oferta de <strong>TARJETA SPIN VISA</strong> pre aprobada por un monto de <strong>" . $capta["cupo"] . "</strong></h3>";

                else:

                    $value["preaprobada"] = 1;
                    $value["retorno"] = $capta["retorno"];
                    $value["id_office"] = $this->session->userdata("id_office");
                    $value["html"] = "<h3>Cliente " .$capta["nombres"]. " ". $capta["apaterno"] ." ". $capta["amaterno"]." <br>posee una oferta de <strong>TARJETA CRUZ VERDE CERRADA</strong> pre aprobada por un monto de <strong>" . $capta["cupo"] . "</strong></h3>";

                endif;

            }else{

                $value["retorno"] = $capta["retorno"];
                $value["id_office"] = $this->session->userdata("id_office");
                $value["html"] = "<h3><strong>" . $capta["descRetorno"] . "</strong></h3>";

            }

        }else{

            if($eval["retorno"]==301){

                $value["retorno"] = $eval["retorno"];
                $value["descRetorno"] = $eval["descRetorno"];
                $value["html"] = "<h3><strong>Rut no es cliente Cruz Verde</h3></strong><h4>Con perfil Ejectivo Comercial, puede revisar ofertas..!</h4>";

            }else{

                $value["retorno"] = $eval["retorno"];
                $value["descRetorno"] = $eval["descRetorno"];
                $value["html"] = "<h3><strong>" . $eval["descRetorno"] ."</strong></h3>";
            }

        }

        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    $this->session->set_userdata("nroRut", $nroRut);
    $this->session->set_userdata("flg_flujo", $eval["flg_flujo"]);
    $this->session->set_userdata("nroTcv", $eval["nroTcv"]);
    $this->session->set_userdata("offTcv", "****-****-****-".substr($eval["nroTcv"],12,4));
    $this->session->set_userdata("origen", $eval["origen"]);
    $this->session->set_userdata("expired_customer", $eval["flg_cvencida"]);
    $this->session->set_userdata("flg_tecnocom", $eval["flg_tecnocom"]);
    $this->session->set_userdata("id_product", $eval["id_product"]);
    $this->session->set_userdata("id_commerce", $eval["id_commerce"]);

    $client = ws_GET_DatosClienteTC($nroRut, $eval["flg_flujo"], $username);

    if($client["retorno"]!=0) {

        $value["retorno"] = $client["retorno"];
        $value["html"] = "<h3><strong>".MSG_ERROR_SERVICE."</strong></h3>"
             ."<h5><strong>".$client["descRetorno"]."</strong></h5></br>";

        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    $this->session->set_userdata("apellido_cliente", $client["apellidoPaterno"].' '.$client["apellidoMaterno"]);
    $this->session->set_userdata("nombre_cliente", $client["nombres"]);

    $value = array();$client_name = $client["nombres"].' '.$client["apellidoPaterno"].' '.$client["apellidoMaterno"];

    $value["expired_customer"] = $eval["flg_cvencida"];
    $value['nroRut'] = $nroRut;
    $value['pan_solventa'] = $eval["nroTcv"];
    $value['retorno'] = $client["retorno"];
    $value['descRetorno'] = $client["descRetorno"];

    if($eval["flg_cvencida"]=="N"){

        $visitas = $this->user->motivos->getall_visita();

        $value['html'] = "<h3><strong>".$client_name."</strong></h3>"
            ."<div class='form-group'><div class='col-sm-12'>"
            ."<div class='col-sm-5'><label for='reasonSelect'><strong>Motivo de Visita</strong><span class='text-danger'>*</span></label></div>"
            ."<div class='input-group col-xs-5'>"
            ."<select id='reasonSkill' name='reasonSkill' class='select-select' style='width: 100%;' data-placeholder='Elegir Motivo de Visita' onchange='Alert.showReason();'>";
        foreach ($visitas as $key) {
                $value['html'] .= "<option value='".$key->KEY."'>".$key->NAME."</option>";
        }
        $value['html'] .= "</select></div></div>";
        $value['html'] .= "<div class='col-sm-12'>&nbsp;</div>";
        $value['html'] .= "<div class='col-sm-12'>
                <div class='input-group col-xs-12'>
                        <input type='text' name='reasonDetail' id='reasonDetail' size='14' maxlength='200' onKeyUp='this.value=this.value.toUpperCase();' class='form-control' placeholder='Escriba motivo atención Cliente..(máximo 200 carácteres)' style='display: none'>
                </div>";
        $value['html'] .= "<div class='col-sm-12'>&nbsp;</div>";
        $value['html'] .= "</div>";


    }else{


        $value['html'] = "<h4>El cliente <strong>".$client_name."</strong> se encuentra Castigado porque cumplió sus 180 días de mora";
        $value['html'] .= ", solo puede ver sus EECC Históricos para ver detalle de administración de su deuda y pagos debe dirigirse a Plataforma Emerix.</h4>";
        $value['html'] .= "<div class='col-sm-12'>&nbsp;</div>";
        $value['html'] .= "<div class='col-sm-12'><h4><strong>URL https://10.0.7.5:450/Solventa/login/login.aspx</strong></h4></div>";
        $value['html'] .= "<div class='col-sm-12'>&nbsp;</div>";
        $value['html'] .= "</div>";

    }
    $data = $value;
    echo json_encode($data);

}

public function search_client_by_target() {

    $return = check_session("");

    $this->form_validation->set_rules('nroTcv', 'N&#250;mero Tarjeta', 'trim|required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroTcv = $this->input->post("nroTcv"); $nroTcv = str_replace('-', '', $nroTcv); 
    $username = $this->session->userdata("username");

    /*
     * Homologador busqueda por Tarjeta
     */

    $eval = ws_GET_HomologadorByTcv($nroTcv, $username);

    if($eval["retorno"]!=0) {

        $value["retorno"] = $eval["retorno"];
        $value["html"] = "<h3><strong>".MSG_ERROR_SERVICE."</strong></h3>"
             ."<h5><strong>".$eval["descRetorno"]."</strong></h5></br>";

        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    $this->session->set_userdata("nroRut", $eval["nroRut"]);
    $this->session->set_userdata("flg_flujo", $eval["flg_flujo"]);
    $this->session->set_userdata("nroTcv", $eval["nroTcv"]);
    $this->session->set_userdata("origen", $eval["origen"]);
    $this->session->set_userdata("expired_customer", $eval["flg_cvencida"]);
    $this->session->set_userdata("id_product", $eval["id_product"]);

    $client = ws_GET_DatosClienteTC($eval["nroRut"], $eval["flg_flujo"], $username);

    if($client["retorno"]!=0) {

        $value["retorno"] = $client["retorno"];
        $value["html"] = "<h3><strong>".MSG_ERROR_SERVICE."</strong></h3>"
             ."<h5><strong>".$client["descRetorno"]."</strong></h5></br>";

        $data = $value;
        echo json_encode($data);
        exit(0);
    }

    $this->session->set_userdata("apellido_cliente", $client["apellidoPaterno"].' '.$client["apellidoMaterno"]);
    $this->session->set_userdata("nombre_cliente", $client["nombres"]);

    $value = array();$client_name = $client["nombres"].' '.$client["apellidoPaterno"].' '.$client["apellidoMaterno"];

    $value["id_office"] = $this->session->userdata("id_office");
    $value["preaprobada"] = 0;
    $value["expired_customer"] = $eval["flg_cvencida"];
    $value['nroRut'] = $eval["nroRut"];
    $value['pan_solventa'] = $eval["nroTcv"];
    $value['retorno'] = $client["retorno"];
    $value['descRetorno'] = $client["descRetorno"];

    if($eval["flg_cvencida"]=="N"){

        $visitas = $this->user->motivos->getall_visita();

        $value['html'] = "<h3><strong>".$client_name."</strong></h3>"
            ."<div class='form-group'><div class='col-sm-12'>"
            ."<div class='col-sm-5'><label for='reasonSelect'><strong>Motivo de Visita</strong><span class='text-danger'>*</span></label></div>"
            ."<div class='input-group col-xs-5'>"
            ."<select id='reasonSkill' name='reasonSkill' class='select-select' style='width: 100%;' data-placeholder='Elegir Motivo de Visita' onchange='Alert.showReason();'>";
        foreach ($visitas as $key) {
                $value['html'] .= "<option value='".$key->KEY."'>".$key->NAME."</option>";
        }
        $value['html'] .= "</select></div></div>";
        $value['html'] .= "<div class='col-sm-12'>&nbsp;</div>";
        $value['html'] .= "<div class='col-sm-12'>
                <div class='input-group col-xs-12'>
                        <input type='text' name='reasonDetail' id='reasonDetail' size='14' maxlength='200' onKeyUp='this.value=this.value.toUpperCase();' class='form-control' placeholder='Escriba motivo atención Cliente..(máximo 200 carácteres)' style='display: none'>
                </div>";
        $value['html'] .= "<div class='col-sm-12'>&nbsp;</div>";
        $value['html'] .= "</div>";


    }else{


        $value['html'] = "<h4>El cliente <strong>".$client_name."</strong> se encuentra Castigado porque cumplió sus 180 días de mora";
        $value['html'] .= ", solo puede ver sus EECC Históricos para ver detalle de administración de su deuda y pagos debe dirigirse a Plataforma Emerix.</h4>";
        $value['html'] .= "<div class='col-sm-12'>&nbsp;</div>";
        $value['html'] .= "<div class='col-sm-12'><h4><strong>URL https://10.0.7.5:450/Solventa/login/login.aspx</strong></h4></div>";
        $value['html'] .= "<div class='col-sm-12'>&nbsp;</div>";
        $value['html'] .= "</div>";

    }
    $data = $value;
    echo json_encode($data);

}


public function set_session_client() {

    $this->load->library('session');
    $this->session->unset_userdata('nroRut');
    $this->session->unset_userdata('nroTcv');
    $this->session->unset_userdata('nombre_cliente');
    $this->session->unset_userdata('apellido_cliente');

    $data = array();
    $data['retorno'] = 0;
    $data['descRetorno'] = "Transacción Aceptada";
    echo json_encode($data);
}


public function get_session_client() {

    $username = $this->session->userdata("username");

    if($this->session->userdata("nroRut") === NULL){

        redirect(base_url());
    }

    $nroRut = $this->session->userdata('nroRut');

    $result = $this->ws_GET_OffertByRut($nroRut);
    $htmlOffers = $result["htmlOffers"];
    $htmlOffersPopup = $result["htmlOffersPopup"];

    $data = array();

    $data['retorno'] = 0;
    $data['descRetorno'] = "Transacción Aceptada";
    $data['htmlOffers'] = $htmlOffers;
    $data['htmlOffersPopup'] = $htmlOffersPopup;
    $data['htmlProduct'] = $this->session->userdata('htmlProduct');
    echo json_encode($data);
}

private function get_DatosProductoTC($nroRut, $nroTcv, $flg_flujo, $username){

    $nroRut = str_replace('.', '', $nroRut); 
    $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

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

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_Action_DatosProductoTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->retorno; 
    $descRetorno = (string)$xml->Body->DATA->descRetorno; $states = array();

    if($retorno==0) {

      foreach($xml->Body->DATA->children() as $state)
      {
          if(strlen($state->producto)>0) {

            $states[] = array(
                "producto" => (string)$state->producto,
                "fechaContratacion" => (string)$state->fechaContratacion,
                "montoContratado" => (string)$state->montoContratado,
                "cuotasContratadas" => (string)$state->cuotasContratadas,
                "cuotasFacturadas" => (string)$state->cuotasFacturadas
            );

          }
      }

    }

    $value["product_client"] = json_encode($states);
    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $data = $value;
    return ($data);
}

private function get_DatosOfertaTC($nroRut, $campagna){

        $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
        $data = array();
        $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
        <soapenv:Header/>
        <soapenv:Body>
           <req:DATA>
              <req:rut>'.$nroRut.'</req:rut>
              <req:tipoCampagna>'.$campagna.'</req:tipoCampagna>
           </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';
        $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_DatosOfertaTC;
        $soap = get_SOAP($EndPoint, WS_Action_DatosOfertaTC, WS_Timeout, $Request, WS_ToXml, $this->session->userdata("username"));

        $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_DatosOfertaTC);
        $eval = ws_EVAL_SOAP($Request);

        if($eval["retorno"]!=0){

          $data["retorno"] = $eval["retorno"];
          $data["descRetorno"] = $eval["descRetorno"];

          return ($data);
        }
        $xml = $eval["xmlDocument"];

        $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
        $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;


        $descripcion = "";$estado = "VIGENTE";

        if($campagna=="SAV"):$descripcion = "SUPER AVANCE";endif;
        if($campagna=="REN"):$descripcion = "RENEGOCIACION";endif;
        if($campagna=="REF"):$descripcion = "REFINANCIAMIENTO";endif;

        if($retorno==0){

            if((int)$xml->Body->DATA->response->estadoCampagna = 1){
                $estado = "VIGENTE";
            }else{
                $estado = "NO VIGENTE";
            }

            $data = array(
                'retorno'=>$retorno,
                'descRetorno'=>$descRetorno,
                'nameProduct'=>$nameProduct,
                'nameCampaign'=>$nameCampaign,
                'statusCampaign'=>$statusCampaign,
                'namestatusCampaign'=>$namestatusCampaign,
                'statusOffert'=>$xml->Body->DATA->response->estadoOferta,
                'dateValidity' => $xml->Body->DATA->response->fechaVigencia,
                'amountApproved' => $xml->Body->DATA->response->montoOferta,
                'amountPreAproved' => $xml->Body->DATA->response->montoPreaprobado
            );

            if((int)$xml->Body->DATA->response->estadoCampagna = 1){
                    $data = array('retorno' => $retorno,
                        'descRetorno' => $descRetorno,
                        'nombreCampagna' => $descripcion,
                        'estadoCampagna' => $estado,
                        'estadoOferta' => $xml->Body->DATA->response->estadoOferta,
                        'fechaVigencia' => $xml->Body->DATA->response->fechaVigencia,
                        'montoOferta' => $xml->Body->DATA->response->montoOferta,
                        'montoPreaprobado' => $xml->Body->DATA->response->montoPreaprobado
                    );
            }else{
                $data = array('retorno' => $retorno,
                    'descRetorno' => '<span class="label label-warning">NO REGISTRA OFERTA PARA ESTE PRODUCTO</strong>',
                    'nombreCampagna' => $descripcion
                );
            }
        }
        return ($data);
}


function get_mysqli() {
$db = (array)get_instance()->db;
return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);
}


} // End class CI_Controller
