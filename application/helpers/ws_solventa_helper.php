<?php

/** Begin::CC033 **/

function ws_PUT_SeguroDesgravamen($fieldRequest){

    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut);

    $companiaseg = "001";                    // Codigo compañia seguro 
    $numpoliza = "2540634";                 // Número poliza aseguradora

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
    <req:tipo>' . $fieldRequest["tipo"] . '</req:tipo>
    <req:rut>' . $nroRut . '</req:rut>
    <req:companiaseg>' . $companiaseg . '</req:companiaseg>
    <req:cuenta>' . $fieldRequest["contrato"] . '</req:cuenta>
    <req:feccontra>' . date("dmY") . '</req:feccontra>
    <req:numpoliza>' . $numpoliza . '</req:numpoliza>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_CreacionSeguros;
    $soap = get_SOAP($EndPoint, WS_Action_CreacionSeguros, WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_CreacionSeguros);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["xmlDocument"] = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    $data = $value;
    return ($data);
}
/** End::CC033 **/

/** Begin::CC029 **/
function ws_GET_ConsultaDeudaFacturacion($dataInput){

    $CI = get_instance();

    $nroRut = str_replace('.', '', $dataInput["nroRut"]); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaDeudaFacturacion]";
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Header xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    </soap:Header>
    <soapenv:Body>
      <req:DATA xmlns:req="http://xsd.solventachile.cl/ConsultaDeudaFacturacion/Req">
        <req:rutSinDv>' . $nroRut . '</req:rutSinDv>
        <req:contrato>' . $dataInput["contrato"] . '</req:contrato>
        <req:fechaDesde>' . $dataInput["fechaDesde"] . '</req:fechaDesde>
        <req:fechaHasta>' . $dataInput["fechaHasta"] . '</req:fechaHasta>
        <req:diaPago>05</req:diaPago>
        <req:flgFlujo >' . $dataInput["flg_flujo"] . '</req:flgFlujo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDeudaFacturacion;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDeudaFacturacion, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaDeudaFacturacion);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    if($dataInput["flg_flujo"]=="001"){

        $dataRequest = array(
            "nroRut" => "",
            "contrato" => $dataInput["contrato"],
            "fechaVencimiento" => "",
            "estadoEecc" => "",
            "pan" => $dataInput["nroTcv"],
            "flg_flujo" => $dataInput["flg_flujo"]
        );

    }else{

        $dataRequest = array(
            "nroRut" => $nroRut,
            "contrato" => $dataInput["contrato"],
            "fechaVencimiento" => "",
            "estadoEecc" => "",
            "pan" => "",
            "flg_flujo" => $dataInput["flg_flujo"]
        );
    }

    $result = ws_GET_ConsultaDatosEECCTC($dataRequest);

    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    $fechaFacturacion = 0; $montoDeuda = 0; 
    $fechaDesde = substr($dataInput["fechaDesde"],6,4) . substr($dataInput["fechaDesde"],3,2);
    $dataResumen = array();

    if($retorno==0){

        foreach ($xml->Body->DATA as $row) {

            foreach ($row as $nodo) {

            if((string)$nodo->fecha_facturacion!=""){

                $strfechaFacturacion = str_replace('/', '', str_replace('-', '', $nodo->fecha_facturacion));
                if((int)$strfechaFacturacion<(int)$fechaFacturacion OR $fechaFacturacion==0){

                    if(substr($strfechaFacturacion,0,6)==$fechaDesde){

                        $fechaFacturacion = (int)$strfechaFacturacion;
                        $montoDeuda = (string)$nodo->monto_deuda;

                    }
                }

                $datanew["fechaFacturacion"] = (string)$strfechaFacturacion;
                $datanew["montoDeuda"] = (string)$nodo->monto_deuda;
                $datanew["pagoMinimo"] = 0;
                $datanew["pagoDelMes"] = 0;

                if($result["retorno"]==0){

                    $xml_eecc = $result["xmlDocument"]; 

                    foreach ($xml_eecc->Body->DATA as $row_eecc) {
                        foreach ($row_eecc as $nodo_eecc) {

                            if(strlen($nodo_eecc->fechaDeCorte)>1){

                                $strfechaFacturacion_eecc = str_replace('/', '', str_replace('-', '', substr($nodo_eecc->fechaDeCorte,0,10)));

                                if($strfechaFacturacion_eecc==$strfechaFacturacion){
                                    $datanew["pagoMinimo"] = (float)$nodo_eecc->pagoMinimo;
                                    $datanew["pagoDelMes"] = (float)$nodo_eecc->pagoDelMes;
                                }
                            }
                        }
                    }
                }

                $dataResumen[] = $datanew;
            }

            }
        }
    }else{

        $datanew["fechaFacturacion"] = substr($dataInput["fechaDesde"],6,4) . substr($dataInput["fechaDesde"],3,2) . substr($dataInput["fechaDesde"],0,2);
        $datanew["montoDeuda"] = 0;
        $datanew["pagoMinimo"] = 0;
        $datanew["pagoDelMes"] = 0;

        $dataResumen[] = $datanew;

        $monto_deuda = 0;
        $fechaFacturacion = substr($dataInput["fechaDesde"],6,4) . substr($dataInput["fechaDesde"],3,2) . substr($dataInput["fechaDesde"],0,2);

    }

    $data["dataResumen"] = $dataResumen;
    $data["monto_deuda"] = $montoDeuda;
    $data["fecha_deuda"] = $fechaFacturacion;
 
    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;

    return($data);

}
/** End::CC029 **/


function ws_GET_pinHSM($dataInput){

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaApiHSM]"; $dataResponse = array();
    $Request='<soapenv:Envelope     xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Header    xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    </soap:Header>
    <soapenv:Body>
    <req:DATA   xmlns:req="http://www.solventa.cl/request">
        <req:pinBlockPinera>' . $dataInput["pinBlockPinera"] . '</req:pinBlockPinera>
        <req:panPinera>' . $dataInput["panPinera"] . '</req:panPinera>
        <req:keySerialNumber>' . $dataInput["keySerialNumber"] . '</req:keySerialNumber>
        <req:canal>' . $dataInput["canal"] . '</req:canal>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaApiHSM;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaApiHSM, WS_Timeout, $Request, WS_ToXml, $dataInput["username"]);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_ConsultaApiHSM);
    $eval = ws_EVAL_SOAP($Request);
    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;

    if($retorno==0){
        $data["pinBlockMinsait"] = (string)$xml->Body->DATA->response->pinBlockMinsait;
    }

    return($data);
}

function ws_GET_pinpadTA($dataInput){

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaApiHSM]"; $dataResponse = array();
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/PINPADTA/Req">
    <soapenv:Header/>
    <soapenv:Body>
              <req:DATA>
                 <req:TIPACC>' . $dataInput["tipacc"] . '</req:TIPACC>
                 <req:PAN>' . $dataInput["pan"] . '</req:PAN>
                 <req:TIPSOL>' . $dataInput["tipsol"] . '</req:TIPSOL>
                 <req:PINBLK>' . $dataInput["pinblk"] . '</req:PINBLK>
                 <req:ESTAD1>' . $dataInput["estad1"] . '</req:ESTAD1>
                 <req:ESTAD2>' . $dataInput["estad2"] . '</req:ESTAD2>
              </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_PinpadTA;
    $soap = get_SOAP($EndPoint, WS_Action_PinpadTA, WS_Timeout, $Request, WS_ToXml, $dataInput["username"]);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_PinpadTA);
    $eval = ws_EVAL_SOAP($Request);
    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    if($retorno==0){

        $data["tipacc"] = (string)$xml->Body->DATA->TIPACC;
        $data["pan"] = (string)$xml->Body->DATA->PAN;
        $data["pinblk"] = (string)$xml->Body->DATA->PINBLK;
        $data["estad1"] = (string)$xml->Body->DATA->ESTAD1;
        $data["estad2"] = (string)$xml->Body->DATA->ESTAD2;
    }

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;

    return($data);
}



function ws_GET_ConsultaEstadoTransferenciaSAV($dataInput){

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaEstadoTransferenciaSAV]"; $dataResponse = array();
    $nroRut = str_replace('.', '', $dataInput["nroRut"]); $nroRut = str_replace('-', '', $nroRut);
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
      <req:Nro_rut>'.$nroRut.'</req:Nro_rut>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaEstadoTransfer;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaEstadoTransfer, WS_Timeout30, $Request, WS_ToXml, $dataInput["username"]);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_ConsultaEstadoTransfer);
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

        $data["codAut"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->codAut;
        $data["ctaDestinoEmail"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->ctaDestinoEmail;
        $data["ctaDestinoNombreTitular"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->ctaDestinoNombreTitular;
        $data["ctaDestinoRutTitular"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->ctaDestinoRutTitular;
        $data["ctaDestinoTipoCuenta"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->ctaDestinoTipoCuenta;
        $data["cuotas"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->cuotas;
        $data["fechaTrans"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->fechaTrans;
        $data["glosa"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->glosa;
        $data["horaTrans"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->horaTrans;
        $data["monto"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->monto;
        $data["tipTrans"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->tipTrans;
        $data["trxNombre"] = (string)$xml->Body->DATA->response->listaEstadoTransferenciaTC->trxNombre;

    }else{

        $data["glosa"] = $descRetorno;
    }

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;

    return($data);
}


function ws_GET_ConsultaPagosRene($dataInput){

    $nroRut = str_replace('.', '', $dataInput["nroRut"]); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $htmlPayment = '<table class="table table-striped table-bordered" id="tabPayment">
        <thead>
        <tr>
            <th class="text-center"><strong>Fecha Pago</strong></th>
            <th class="text-center"><strong>Monto Pago</strong></th>
            <th class="text-center"><strong>Tipo de Pago</strong></th>
        </tr>
        </thead>';

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaUltimosPagosRene/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:nro_rut>'.$nroRut.'</req:nro_rut>
         <req:contrato>'.$dataInput["contrato"].'</req:contrato>
         <req:flag_flujo>'.$dataInput["flg_flujo"].'</req:flag_flujo>
         <req:cantidad_pagos>'.$dataInput["cantidad_pagos"].'</req:cantidad_pagos>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaUltimosPagosRene;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaUltimosPagosRene, WS_Timeout, $Request, WS_ToXml, $dataInput["username"]);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaUltimosPagosRene);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        $htmlPayment.= '<tbody>';
        $htmlPayment.= '<tr><td scope="col" colspan="3">ERROR, '.$eval["descRetorno"].'</td></tr>';
        $htmlPayment.= '</tbody></table>';
        $data["htmlPayment"] = $htmlPayment;
        return ($data);
    }

    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno;
    $descRetorno = (string)$xml->Body->DATA->descRetorno;

    /* Begin Consulta Últimos Pagos del cliente */

    if($retorno==0){

        $htmlPayment.= '<tbody>';
        foreach ($xml->Body->DATA as $record) {
          foreach ($record as $nodo) {

            if((int)$nodo->nro_rut > 0){

              $fecha_pago = substr($nodo->fecha_pago,0,10);
              $monto = "$".number_format((float)$nodo->monto,0,',','.');
              $htmlPayment.= '<tr>';
              $htmlPayment.= '<td align="center">'.$fecha_pago.'</td>';
              $htmlPayment.= '<td align="center">'.$monto.'</td>';
              $htmlPayment.= '<td align="center">'.$nodo->descripcion_tx.'</td>';
              $htmlPayment.= '</tr>';
            }
          }
        }
        $htmlPayment.= '</tbody>';

    }else{

        $htmlPayment.= '<tbody>';
        $htmlPayment.= '<tr>';
        $htmlPayment.= '<td scope="col" colspan="3">NO REGISTRA PAGOS</td>';
        $htmlPayment.= '</tbody>';

    }
    $htmlPayment.= '</table>';
    /* End Consulta Últimos Pagos del cliente */

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["xmlDocument"] = $xml;
    $value["htmlPayment"] = $htmlPayment;

    $data = $value;
    return ($data);

}


function ws_GET_CuposTC($dataInput){

    $CI = get_instance();
    $retorno = COD_ERROR_INIT; $dataResponse = array();

    $htmlCupos = '<table class="table table-striped table-bordered" id="tabCupos">
    <thead>
    <tr>
      <th class="text-center"><strong>Tipo</strong></th>
      <th class="text-center"><strong>Cupo</strong></th>
      <th class="text-center"><strong>Utilizado</strong></th>
      <th class="text-center"><strong>Disponible</strong></th>
    </tr>
    </thead><tbody>';

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaCuposTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:PAN>' . $dataInput["nroTcv"] . '</req:PAN>
          <req:CONTRATO>' . $dataInput["contrato"] . '</req:CONTRATO>
          <req:CLIENTE_COMERCIO>' . $dataInput["id_commerce"] . '</req:CLIENTE_COMERCIO>
          <req:PRODUCTO>' . $dataInput["id_product"] . '</req:PRODUCTO>
          <req:FLAG_FLUJO>' . $dataInput["id_channel"] . '</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaCuposTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaCuposTC, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_ConsultaCuposTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $htmlCupos .= "<tr><td colspan='4'>Error Lectura de Cupos</td></tr>";
        $htmlCupos .= "</tbody></table>";

        $value["htmlCupos"] = $htmlCupos;
        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        return ($data);
    }

    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno==0){
        foreach ($xml->Body->DATA as $record) {
            foreach ($record as $nodo) {
                if((int)$nodo->codigolinea<>0){

                    $nameProduct = "";
                    if((int)$nodo->codigolinea==1){$nameProduct = "COMPRA";}
                    if((int)$nodo->codigolinea==2){$nameProduct = "AVANCE";}
                    if((int)$nodo->codigolinea==3){$nameProduct = "S&#218;PER AVANCE";}

                    if((int)$nodo->codigolinea!=3):

                        $display_quota = true;

                    else:

                        if($CI->session->userdata("offerSAV")):
                            $display_quota = true;
                        else:

                            if((int)$nodo->utilizado>0):
                                $display_quota = true;
                            else:
                                $display_quota = false;
                            endif;
                            
                        endif;

                    endif;

                    if($display_quota):
                        $htmlCupos .= '<tr><td>'.$nameProduct.'</td>';
                        $htmlCupos .= '<td>$'.number_format((float)$nodo->cupo,0,",",".").'</td>';
                        $htmlCupos .= '<td>$'.number_format((float)$nodo->utilizado,0,",",".").'</td>';
                        $htmlCupos .= '<td>$'.number_format((float)$nodo->disponible,0,",",".").'</td>';
                        $htmlCupos .= '</tr>';

                        $datanew["codigolinea"] = (string)$nodo->codigolinea;
                        $datanew["descCodigolinea"] = $nameProduct;
                        $datanew["cupo"] = (string)$nodo->cupo;
                        $datanew["disponible"] = (string)$nodo->disponible;
                        $datanew["utilizado"] = (string)$nodo->utilizado;
                        $dataResponse[] = $datanew;
                    endif;

                }
            }
        }
    }else{

          $htmlCupos .= '<tr><td colspan="4">NO REGISTRA CUPOS</td></tr>';
    }
    $htmlCupos .= "</tbody></table>";

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;
    $data["htmlCupos"] = $htmlCupos;
    $data["dataResponse"] = $dataResponse;
    return($data);
}


function ws_GET_ConsultaCuposTC($nroTcv, $contrato, $flg_flujo, $username){

    $CI = get_instance();
    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaCuposTC]"; $dataResponse = array();

    $htmlCupos = '<table class="table table-striped table-bordered" id="tabCupos">
    <thead>
    <tr>
      <th class="text-center"><strong>Tipo</strong></th>
      <th class="text-center"><strong>Cupo</strong></th>
      <th class="text-center"><strong>Utilizado</strong></th>
      <th class="text-center"><strong>Disponible</strong></th>
    </tr>
    </thead><tbody>';

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaCuposTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:PAN>'.$nroTcv.'</req:PAN>
          <req:CONTRATO>'.$contrato.'</req:CONTRATO>
          <req:CLIENTE_COMERCIO>27</req:CLIENTE_COMERCIO>
          <req:PRODUCTO>T</req:PRODUCTO>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaCuposTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaCuposTC, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_ConsultaCuposTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $htmlCupos .= "<tr><td colspan='4'>Error Lectura de Cupos</td></tr>";
        $htmlCupos .= "</tbody></table>";

        $value["htmlCupos"] = $htmlCupos;
        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        $data = $value;

        return ($data);
    }

    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno==0){
        foreach ($xml->Body->DATA as $record) {
            foreach ($record as $nodo) {
                if((int)$nodo->codigolinea<>0){

                    $nameProduct = "";
                    if((int)$nodo->codigolinea==1){$nameProduct = "COMPRA";}
                    if((int)$nodo->codigolinea==2){$nameProduct = "AVANCE";}
                    if((int)$nodo->codigolinea==3){$nameProduct = "S&#218;PER AVANCE";}

                    if((int)$nodo->codigolinea!=3):

                        $display_quota = true;

                    else:

                        if($CI->session->userdata("offerSAV")):
                            $display_quota = true;
                        else:

                            if((int)$nodo->utilizado>0):
                                $display_quota = true;
                            else:
                                $display_quota = false;
                            endif;
                            
                        endif;

                    endif;

                    if($display_quota):
                        $htmlCupos .= '<tr><td>'.$nameProduct.'</td>';
                        $htmlCupos .= '<td>$'.number_format((float)$nodo->cupo,0,",",".").'</td>';
                        $htmlCupos .= '<td>$'.number_format((float)$nodo->utilizado,0,",",".").'</td>';
                        $htmlCupos .= '<td>$'.number_format((float)$nodo->disponible,0,",",".").'</td>';
                        $htmlCupos .= '</tr>';

                        $datanew["codigolinea"] = (string)$nodo->codigolinea;
                        $datanew["descCodigolinea"] = $nameProduct;
                        $datanew["cupo"] = (string)$nodo->cupo;
                        $datanew["disponible"] = (string)$nodo->disponible;
                        $datanew["utilizado"] = (string)$nodo->utilizado;
                        $dataResponse[] = $datanew;
                    endif;

                }
            }
        }
    }else{

          $htmlCupos .= '<tr><td colspan="4">NO REGISTRA CUPOS</td></tr>';
    }
    $htmlCupos .= "</tbody></table>";

    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;
    $data["htmlCupos"] = $htmlCupos;
    $data["dataResponse"] = $dataResponse;

    return($data);
}


function ws_GET_OfertasClienteTC($nroRut, $idCampagna, $descCampagna){

    $CI = get_instance();
    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:rut>'.$nroRut.'</req:rut>
          <req:tipoCampagna>'.$idCampagna.'</req:tipoCampagna>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_DatosOfertaTC;
    $soap = get_SOAP($EndPoint, WS_Action_DatosOfertaTC, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

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

        $estado = ((int)$xml->Body->DATA->response->estadoCampagna == 1 ? DESCRIP_VIGENTE : DESCRIP_NO_VIGENTE);
        $data['retorno'] = $retorno;
        $data['descRetorno'] = $descRetorno;
        $data['nombreCampagna'] = $descCampagna;
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
        $data['nombreCampagna'] = $descCampagna;
    }

    return ($data);
}


function ws_GET_ConsultaMoraVirtual($fieldRequest){

    $CI = get_instance();
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut);
    $dgvRut = substr($nroRut, -1); $nroRut = substr($nroRut, 0, -1);

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:rut>'.$nroRut.'</req:rut>
          <req:dv>'.$dgvRut.'</req:dv>
          <req:fecha>'.$fieldRequest["today"].'</req:fecha>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaMoraVirtual;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaMoraVirtual, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaMoraVirtual);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    if($retorno==0){

        $today = (string)$xml->Body->DATA->listaRenegociaciones->fechaFinVigencia;
        $data["fechaFinVigencia"] = substr($today,8,2)."-".substr($today,5,2)."-".substr($today,0,4);
        $data["dateEnd"] = substr($today,0,4).substr($today,5,2).substr($today,8,2);

        $today = (string)$xml->Body->DATA->listaRenegociaciones->fechaInicioVigencia;
        $data["fechaInicioVigencia"] = substr($today,8,2)."-".substr($today,5,2)."-".substr($today,0,4);

        $data["ejecutivo"] = (string)$xml->Body->DATA->listaRenegociaciones->ejecutivo;
        $data["motivo"] = (string)$xml->Body->DATA->listaRenegociaciones->motivo;
    }

    $data['retorno'] = $retorno;
    $data['descRetorno'] = $descRetorno;

    return ($data);
}

function ws_GET_ConsultaTotalPagosRene($fieldRequest){

    $CI = get_instance();
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut);
    $dgvRut = substr($nroRut, -1); $nroRut = substr($nroRut, 0, -1);

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaControlPagosRene/Req-v2021.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:nro_rut>'.$nroRut.'</req:nro_rut>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaPagosRene;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaPagosRene, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaMoraVirtual);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];
        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;
    if($retorno==0 OR $retorno==210){
        if($retorno==0){
            $data["monto"] = (string)$xml->Body->DATA->Registro->monto;
            $data["nroRut"] = (string)$xml->Body->DATA->Registro->nro_rut;
        }else{
            $retorno = 0;
            $data["monto"] = "0";
            $data["nroRut"] = $nroRut;
        }
    }
    $data['retorno'] = $retorno;
    $data['descRetorno'] = $descRetorno;

    return ($data);
}

function ws_GET_ConsultaDeudaDiaUno($fieldRequest){

    $CI = get_instance();
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut);
    $dgvRut = substr($nroRut, -1); $nroRut = substr($nroRut, 0, -1);

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Header xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    </soap:Header>
    <soapenv:Body>
       <req:DATA xmlns:req="http://www.solventa.cl/request">
          <req:nroRutSinDv>'.$nroRut.'</req:nroRutSinDv>
          <req:contrato>'.$fieldRequest["contrato"].'</req:contrato>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDeudaDiaUno;
    $soap = get_SOAP($EndPoint, WS_Action_WS_ConsultaDeudaDiaUno, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaDeudaDiaUno);
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

        $data["fechaDeuda"] = (string)$xml->Body->DATA->response->valSalidaOut->fechaDeuda;
        $data["montoDeuda"] = (string)$xml->Body->DATA->response->valSalidaOut->montoDeuda;
    }
    $data['retorno'] = $retorno;
    $data['descRetorno'] = $descRetorno;

    return ($data);
}


function ws_GET_Payment_Alternatives_REN($fieldRequest){

    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:pan>'.$fieldRequest["nroTcv"].'</req:pan>
         <req:nroRut>'.$nroRut.'</req:nroRut>
         <req:idTx>'.$fieldRequest["idTrx"].'</req:idTx>
         <req:monto>'.$fieldRequest["amount"].'</req:monto>
         <req:numeroDeCuota>'.$fieldRequest["numberQuotas"].'</req:numeroDeCuota>
         <req:mesesDiferidos>'.$fieldRequest["deferredQuotas"].'</req:mesesDiferidos>
         <req:flagCriterio>'.$fieldRequest["flagCriterio"].'</req:flagCriterio>
      </req:DATA>
       </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_SimulacionTrxTC;
    $soap = get_SOAP($EndPoint, WS_Action_SimulacionTrxTC, WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_SimulacionTrxTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    if(!isset($xml->Body->DATA->response->cabeceraSalida->retorno)){

        $value['retorno'] = COD_ERROR_INIT;
        $value['descRetorno'] = MSG_ERROR_SERVICE_NOOK;
        $data = $value;

        put_logevent($soap, SOAP_ERROR);
        return($data);
    }

    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    $lastQuota = 0; $firstQuota = 0;

    $fechaPrimerVencimiento = ""; $interesRate = ""; $htmlSimulate = ""; $dateFirstExpiration = ""; $statusLOG = "OK"; $ite = 0;

    switch ($fieldRequest["idTrx"]) {
        case COD_TRX_REN_SIN_DIFERIDO_001:
            $product = CODIGO_RENEGOCIACION;
            $product_name = DESCRIP_RENEGOCIACION;
            break;
        case COD_TRX_REN_SIN_DIFERIDO_002:
            $product = CODIGO_RENEGOCIACION;
            $product_name = DESCRIP_RENEGOCIACION;
            break;

        case COD_TRX_REN_CON_DIFERIDO_001:
            $product = CODIGO_RENEGOCIACION;
            $product_name = DESCRIP_RENEGOCIACION;
            break;
        case COD_TRX_REN_CON_DIFERIDO_002:
            $product = CODIGO_RENEGOCIACION;
            $product_name = DESCRIP_RENEGOCIACION;
            break;

        case COD_TRX_REF_CON_DIFERIDO:
            $product = CODIGO_REFINANCIAMIENTO;
            $product_name = DESCRIP_REFINANCIAMIENTO;
            break;
        case COD_TRX_REF_SIN_DIFERIDO:
            $product = CODIGO_REFINANCIAMIENTO;
            $product_name = DESCRIP_REFINANCIAMIENTO;
            break;

        default:

            cancel_function(COD_ERROR_INIT,"Código Producto no definido para Simulación..!","");
            break;
    }

    switch ($product) {

        case CODIGO_RENEGOCIACION:

            $htmlSimulate = '<table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
                <thead>
                  <tr><th class="text-center">Selecci&#243;n</th>
                    <th class="text-center">Cuotas</th>
                    <th class="text-right">Valor Cuota</th>
                    <th class="text-right">Impuesto</th>
                    <th class="text-center">Tasa</th>
                    <th class="text-center">CAE</th>
                    <th class="text-right">Costo Total de la Renegociación</th>
                  </tr>
                </thead><tbody>';

            $number_column = 7;
            break;

        case CODIGO_REFINANCIAMIENTO:

            $htmlSimulate = '<table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
                <thead>
                  <tr><th class="text-center">Selecci&#243;n</th>
                    <th class="text-center">Cuotas</th>
                    <th class="text-center">Meses Gracia</th>
                    <th class="text-right">Valor Cuota</th>
                    <th class="text-right">Monto Bruto</th>
                    <th class="text-right">Monto Líquido</th>
                    <th class="text-right">Costo Total</th>
                    <th class="text-center">Tasa</th>
                    <th class="text-right">Impuesto</th>
                    <th class="text-right">Comisión</th>
                    <th class="text-center">CAE</th>
                  </tr>
                </thead><tbody>';

            $number_column = 11;
            $montoLiquido = $fieldRequest["amount"];

            break;
    }

    if($retorno==0){

        $numberQuotas = $fieldRequest["numberQuotas"];

        foreach ($xml->Body->DATA->response as $recordTRX) {
            foreach ($recordTRX as $nodo) {

                if((int)$nodo->numeroDeCuota > 0){

                    $dateFirstExpiration = (string)$nodo->fechaPrimerVencimiento;

                    if($firstQuota==0){
                        $firstQuota = (int)$nodo->numeroDeCuota;
                    }

                    if($firstQuota>(int)$nodo->numeroDeCuota){
                        $firstQuota = (int)$nodo->numeroDeCuota;
                    }

                    $lastQuota = (int)$nodo->numeroDeCuota;

                    $interesRate = (string)$nodo->tasa;
                    $interesRate = str_replace(',', '.', $interesRate);

                    $comision = (float)$fieldRequest["cobroAdministracionMensual"] * $lastQuota;
                    $seguro = (int)$fieldRequest["montoPrimaCL"] * $lastQuota;

                    $ite = (string)$nodo->ite;

                    $valorCuota = substr((string)$nodo->valorCuota, 0, -2);

                    $amount = $valorCuota * $lastQuota;

                    $montoBruto = round( (float)$amount + (float)$ite + (float)$comision );

                    $costoTotalDelCredito = round( (float)$amount + (float)$comision + (float)$seguro );

                    /***
                    $comision = $nodo->comision;
                    $comision = str_replace('.', '', $comision);
                    $comision = str_replace(',', '.', $comision);

                    $amount = (string)$nodo->costoTotalDelCredito;
                    $ite = (string)$nodo->ite;

                    $montoBruto = round( (float)$amount + (float)$ite + (float)$comision );
                    $valorCuota = substr((string)$nodo->valorCuota, 0, -2);
                    $costoTotalDelCredito = substr((string)$nodo->costoTotalDelCredito, 0, -2);
                    ****/


                    $checkSelect = "";
                    if((int)$nodo->numeroDeCuota==(int)$numberQuotas) { $checkSelect = "checked"; }

                    switch ($product) {

                        case CODIGO_RENEGOCIACION:

                            $htmlSimulate .= '<tr onclick="Client.selectRequest(this);">
                                  <td scope="col" class="text-center"><input type="radio" name="checkSimulate" value="'.$nodo->numeroDeCuotas.'" id="sel'.$nodo->numeroDeCuota.'" '.$checkSelect.'></td>
                                  <td scope="col" class="text-center">'.$nodo->numeroDeCuota.'</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$valorCuota, 0, ',', '.').'</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$ite, 0, ',', '.').'</td>
                                  <td scope="col" class="text-center">'.$nodo->tasa.'%</td>
                                  <td scope="col" class="text-center">'.$nodo->cae.'%</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$costoTotalDelCredito, 0, ',', '.').'</td>
                                </tr>';

                            break;

                        case CODIGO_REFINANCIAMIENTO:

                              $htmlSimulate .= '<tr onclick="Client.selectRequest(this);">
                                  <td scope="col" class="text-center"><input type="radio" name="checkSimulate" value="'.$nodo->numeroDeCuotas.'" id="sel'.$nodo->numeroDeCuota.'" '.$checkSelect.'></td>
                                  <td scope="col" class="text-center">'.$nodo->numeroDeCuota.'</td>
                                  <td scope="col" class="text-center">'.$fieldRequest["deferredQuotas"].'</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$valorCuota, 0, ',', '.').'</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$montoBruto, 0, ',', '.').'</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$montoLiquido , 0, ',', '.').'</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$costoTotalDelCredito , 0, ',', '.').'</td>
                                  <td scope="col" class="text-center">'.$nodo->tasa.'%</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$ite, 0, ',', '.').'</td>
                                  <td scope="col" class="text-right">$'.number_format((float)$comision, 0, ',', '.').'</td>
                                  <td scope="col" class="text-center">'.$nodo->cae.'%</td>
                                </tr>';

                            break;
                    }
                }
            }
        }

    }else{

        $htmlSimulate .= '<tr>
            <td scope="col" class="text-center" nowrap colspan="'.$number_column.'">'.$descRetorno.'</td>
        </tr>';
    }

    if($lastQuota==0){

        $descRetorno = "No fue posible Generar cuadro de pago para ".$product_name;
    }

    $htmlSimulate .= '</tbody></table>';

    $value['retorno'] = $retorno;
    $value['descRetorno'] = $descRetorno;
    $value['dateFirstExpiration'] = $dateFirstExpiration;
    $value['interesRate'] = $interesRate;
    $value['htmlSimulate'] = $htmlSimulate;
    $value['lastLine'] = "sel".$lastQuota;
    $value['lastQuota'] = $firstQuota;
    $data = $value;

    return($data);
}


function ws_GET_ConsultaParametrosTasaTC($contrato){

    $CI = get_instance();
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
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaParametrosTasaTC, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaParametrosTasaTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->DATA->response->return->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->return->cabeceraSalida->descRetorno;

    if($retorno==0) {

        $data = array('retorno' => 0, 'tasaAvanceMayor90' => (float)$xml->Body->DATA->response->return->tasaAvanceMayor90,'tasaAvanceMenor90' => (float)$xml->Body->DATA->response->return->tasaAvanceMenor90,'tasaCompraMayor90' => (float)$xml->Body->DATA->response->return->tasaCompraMayor90,'tasaCompraMenor90' => (float)$xml->Body->DATA->response->return->tasaCompraMenor90,'tasaInteresMora' => (float)$xml->Body->DATA->response->return->tasaInteresMora,'impuestos' => (float)$xml->Body->DATA->response->return->impuestos,'mantencionMensual' => (float)$xml->Body->DATA->response->return->mantencionMensual);

    }else{

        $data = array('retorno' => $retorno, 'tasaAvanceMayor90' => '0.00','tasaAvanceMenor90' => '0.00', 'tasaCompraMayor90' => '0.00', 'tasaCompraMenor90' => '0.00', 'tasaInteresMora' => '0.00', 'impuestos' => '0.00', 'mantencionMensual' => '0.00');
    }

    return($data);
}


function ws_GET_ConsultaDetalleRene($fieldRequest){

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Header xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    </soap:Header>
    <soapenv:Body>
        <req:DATA xmlns:req="http://www.solventa.cl/request">
        <req:idRefinanciamiento>'.$fieldRequest["idRefinanciamiento"].'</req:idRefinanciamiento>
        <req:tipoRef>'.$fieldRequest["tipoRef"].'</req:tipoRef>
        <req:flagFlujo>'.$fieldRequest["flg_flujo"].'</req:flagFlujo>
        </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';


    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDetalleRene;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDetalleRene, WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_GrabarRazonVisitaTC);
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

        $value["rut"] = (string)$xml->Body->DATA->response->listaRenegociaciones->rut;
        $value["dv"] = (string)$xml->Body->DATA->response->listaRenegociaciones->dv;
        $value["apellidos"] = (string)$xml->Body->DATA->response->listaRenegociaciones->apellidos;
        $value["nombres"] = (string)$xml->Body->DATA->response->listaRenegociaciones->nombres;
        $value["telefono"] = (string)$xml->Body->DATA->response->listaRenegociaciones->telefono;
        $value["email"] = (string)$xml->Body->DATA->response->listaRenegociaciones->email;
        $value["idRefinanciamiento"] = (string)$xml->Body->DATA->response->listaRenegociaciones->idRefinanciamiento;
        $value["idContrato"] = (string)$xml->Body->DATA->response->listaRenegociaciones->idContrato;

        $value["nroCuotas"] = (string)$xml->Body->DATA->response->listaRenegociaciones->nroCuotas;
        $value["mesesDiferidos"] = (string)$xml->Body->DATA->response->listaRenegociaciones->mesesDiferidos;
        $value["montoCreditoRef"] = (string)$xml->Body->DATA->response->listaRenegociaciones->montoCreditoRef;
        $value["deudaRef"] = (string)$xml->Body->DATA->response->listaRenegociaciones->deudaRef;
        $value["montoRef"] = (string)$xml->Body->DATA->response->listaRenegociaciones->montoRef;
        $value["montoCuota"] = (string)$xml->Body->DATA->response->listaRenegociaciones->montoCuota;
        $value["tipoRef"] = (string)$xml->Body->DATA->response->listaRenegociaciones->tipoRef;
        $value["fecha1erVencimiento"] = (string)$xml->Body->DATA->response->listaRenegociaciones->fecha1erVencimiento;
        $value["montoImpuestoMes"] = (string)$xml->Body->DATA->response->listaRenegociaciones->montoImpuestoMes;
        $value["seguroDesgravamen"] = (string)$xml->Body->DATA->response->listaRenegociaciones->seguroDesgravamen;
        $value["fechaRef"] = (string)$xml->Body->DATA->response->listaRenegociaciones->fechaRef;

        $value["tasaAplicada"] = (string)$xml->Body->DATA->response->listaRenegociaciones->tasaAplicada;
        $value["cae"] = (string)$xml->Body->DATA->response->listaRenegociaciones->cae;
        $value["estado"] = (string)$xml->Body->DATA->response->listaRenegociaciones->estado;
        $value["estadoVisacion"] = (string)$xml->Body->DATA->response->listaRenegociaciones->estadoVisacion;
        $value["estadoExcepcion"] = (string)$xml->Body->DATA->response->listaRenegociaciones->estadoExcepcion;
        $value["comisionAdmin"] = (string)$xml->Body->DATA->response->listaRenegociaciones->comisionAdmin;

        $value["vigente"] = (string)$xml->Body->DATA->response->listaRenegociaciones->vigente;
        $value["pan"] = (string)$xml->Body->DATA->response->listaRenegociaciones->pan;

        $value["cupoCompras"] = (string)$xml->Body->DATA->response->listaRenegociaciones->cupoCompras;
        $value["cupoAvance"] = (string)$xml->Body->DATA->response->listaRenegociaciones->cupoAvance;

        $value["ca_status"] = ""; $value["ca_username"] = ""; $value["ca_date"] = "";
        $value["co_status"] = ""; $value["co_username"] = ""; $value["co_date"] = "";
        $value["ex_status"] = ""; $value["ex_username"] = ""; $value["ex_date"] = "";
        $value["au_status"] = ""; $value["au_username"] = ""; $value["au_date"] = "";

        $username = (string)$xml->Body->DATA->response->listaRenegociaciones->ejecutivo;
        if($username!=""){

            $value["ca_status"] = "CREADA";
            $value["ca_username"] = (string)$xml->Body->DATA->response->listaRenegociaciones->ejecutivo;
            $date_stamp =  (string)$xml->Body->DATA->response->listaRenegociaciones->fechaRef;
            $value["ca_date"] = substr($date_stamp,8,2)."-".substr($date_stamp,5,2)."-".substr($date_stamp,0,4)." ".substr($date_stamp,11,8);
        }

        $username = (string)$xml->Body->DATA->response->listaRenegociaciones->usuarioVisador;
        if($username!=""){

            $value["co_status"] = "CONFIRMADA";
            $value["co_username"] = (string)$xml->Body->DATA->response->listaRenegociaciones->usuarioVisador;
            $date_stamp =  (string)$xml->Body->DATA->response->listaRenegociaciones->fechaVisacion;
            $value["co_date"] = substr($date_stamp,8,2)."-".substr($date_stamp,5,2)."-".substr($date_stamp,0,4)." ".substr($date_stamp,11,8);
        }

        $username = (string)$xml->Body->DATA->response->listaRenegociaciones->usuarioExcepcion;
        if($username!=""){

            $value["ex_status"] = "EXCEPCION";
            $value["ex_username"] = (string)$xml->Body->DATA->response->listaRenegociaciones->usuarioExcepcion;
            $date_stamp =  (string)$xml->Body->DATA->response->listaRenegociaciones->fechaExcepcion;
            $value["ex_date"] = substr($date_stamp,8,2)."-".substr($date_stamp,5,2)."-".substr($date_stamp,0,4)." ".substr($date_stamp,11,8);
        }

        $username = (string)$xml->Body->DATA->response->listaRenegociaciones->usuarioAceptacion;
        if($username!=""){

            $value["au_status"] = "SUPERVISOR";
            $value["au_username"] = (string)$xml->Body->DATA->response->listaRenegociaciones->usuarioAceptacion;
            $date_stamp =  (string)$xml->Body->DATA->response->listaRenegociaciones->fechaAceptacion;
            $value["au_date"] = substr($date_stamp,8,2)."-".substr($date_stamp,5,2)."-".substr($date_stamp,0,4)." ".substr($date_stamp,11,8);
        }

    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $data = $value;
    return($data);
}

function ws_GET_Lista_Operaciones_REN($fieldRequest){

    $CI = get_instance();
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Header   xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        </soap:Header>
        <soapenv:Body>
        <req:DATA xmlns:req="http://www.solventa.cl/request">
        <req:rut>'.$nroRut.'</req:rut>
        <req:fechaDesde>'.$fieldRequest["dateBegin"].'</req:fechaDesde>
        <req:fechaHasta>'.$fieldRequest["dateEnd"].'</req:fechaHasta>
        <req:estado></req:estado>
        <req:telefono>'.$fieldRequest["number_phone"].'</req:telefono>
        <req:usuarioCreador>'.$fieldRequest["usernameCreate"].'</req:usuarioCreador>
        <req:estadoVisacion>'.$fieldRequest["status"].'</req:estadoVisacion>
        <req:tipoRef>'.$fieldRequest["tipoRef"].'</req:tipoRef>
        <req:estadoExcepcion></req:estadoExcepcion>
        </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ListaOperxEstadoRene;
    $soap = get_SOAP($EndPoint, WS_Action_ListaOperxEstadoRene, WS_Timeout90, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ListaOperxEstadoRene);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $htmlRenegotiation = '<table class="table table-striped table-bordered" id="tabRenegotiation"><thead><tr>
            <td scope="col" class="text-center">'.$eval["descRetorno"].'</td></tr></thead></table>';

      $value["retorno"] = $eval["retorno"];
      $value["descRetorno"] = $eval["descRetorno"];
      $value['htmlRenegotiation'] = $htmlRenegotiation;

      $data = $value;
      return($data);
    }

    if($fieldRequest["id_rol"]==USER_ROL_JEFE_COBRANZA 
            OR $fieldRequest["id_rol"]==USER_ROL_SUPERVISOR_CALIDAD
            OR $fieldRequest["id_rol"]==USER_ROL_SUPERVISOR_EXCEPCIONES
            OR $fieldRequest["id_rol"]==USER_ROL_EJECUTIVO_COBRANZA){

        $htmlRenegotiation = '<table class="table table-striped table-bordered" id="tabRenegotiation">
            <thead>
            <tr>
                <th class="text-center"><strong>ID</strong></th>
                <th class="text-center"><strong>N&uacute;mero Rut</strong></th>
                <th class="text-center"><strong>Cliente</strong></th>
                <th class="text-center"><strong>Monto</strong></th>
                <th class="text-center"><strong>Fecha Creación</strong></th>
                <th class="text-center"><strong>Estado</strong></th>
                <th class="text-center"><strong>Situación</strong></th>
                <th class="text-center"><strong>Usuario Creación</strong></th>
                <th class="text-center"><strong>Glosa Excepción</strong></th>
                <th class="text-center"><strong>Glosa Script</strong></th>
                <th class="text-center"><strong>VB Script</strong></th>
                <th class="text-center"><strong>Script</strong></th>
                <th class="text-center"><strong>Acciones</strong></th>
            </tr>
            </thead>';
            $colspan=12;

    }else{


        $htmlRenegotiation = '<table class="table table-striped table-bordered" id="tabRenegotiation">
            <thead>
            <tr>
                <th class="text-center"><strong>ID</strong></th>
                <th class="text-center"><strong>N&uacute;mero Rut</strong></th>
                <th class="text-center"><strong>Cliente</strong></th>
                <th class="text-center"><strong>Monto</strong></th>
                <th class="text-center"><strong>Sucursal</strong></th>
                <th class="text-center"><strong>Fecha Creación</strong></th>
                <th class="text-center"><strong>Estado</strong></th>
                <th class="text-center"><strong>Situación</strong></th>
                <th class="text-center"><strong>Acciones</strong></th>
            </tr>
            </thead>';
            $colspan=9;
    }

    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0){

        $checkSelect = 1;
        foreach ($xml->Body->DATA->response as $recordTRX) {
            foreach ($recordTRX as $nodo) {

                if((int)$nodo->deudaRene > 0){

                  $result = $CI->parameters->get_officeById($nodo->codLocal);
                  $name_office = ($result!=false ? $result->name : $nodo->codLocal);

                  $journal = $CI->journal->get_renegotiationById($nodo->idRefinanciamiento);
                  if($journal):

                      $result = $CI->parameters->get_renegotiationStatusById($journal->status);
                      $name_status = ($result!=false ? $result->NAME : $journal->status_name);
                  else:

                      $name_status = $nodo->estadoVisacion;
                  endif;

                  $result = $CI->parameters->get_renegotiationSituationById($nodo->estadoExcepcion);
                  if($result!=false){
                      $name_situation = $result->NAME;
                      $view_script = $result->VIEW_SCRIPT;
                      $view_author = $result->VIEW_AUTHOR;
                  }else{
                      $name_situation = $nodo->estadoExcepcion;
                      $view_script = 0;
                      $view_author = 0;
                  }

                  $result = digitoRUTCL($nodo->rut);
                  $dgvRut = ($result["retorno"]==0 ? $result["dgvRut"] : "");

                  $date_stamp = substr($nodo->fecha,8,2)."-".substr($nodo->fecha,5,2)."-".substr($nodo->fecha,0,4)." ".substr($nodo->fecha,11,8);

                  if($view_script){

                        $script = '<a href="javascript:Client.showScript('.$nodo->idRefinanciamiento.');" class="btn btn-success btn-xs"><i class="fa fa-check" title="Revisar Script"></i></a></td>';

                  }else {

                        if($fieldRequest["id_rol"]==USER_ROL_EJECUTIVO_COBRANZA){

                            if($nodo->estadoExcepcion=="PTE" OR $nodo->estadoExcepcion=="PVE"
                                OR $nodo->estadoExcepcion=="PTN" OR $nodo->estadoExcepcion=="PVN"){
                                $script = '<a href="javascript:Client.confirmScript('.$nodo->idRefinanciamiento.');" class="btn btn-warning btn-xs"><i class="fa fa-check" title="Aprobar Script"></i></a></td>';
                            }else{
                                $script = '<a href="javascript:Client.showScript('.$nodo->idRefinanciamiento.');" class="btn btn-success btn-xs"><i class="fa fa-check" title="Revisar Script"></i></a></td>';
                            }

                        }else{

                            $script = '<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-check" title="Script no disponible"></i></a></td>';
                        }
                  }

                $view_author = false;
                if(($fieldRequest["id_rol"]==USER_ROL_SUPERVISOR_EXCEPCIONES) AND $nodo->estadoVisacion=="P" AND ($nodo->estadoExcepcion=="CVE" OR $nodo->estadoExcepcion=="CTE")){

                    $view_author = true;
                }

                switch ($nodo->estadoScript) {
                  case 'A':
                    $estadoScript = "APROBADO";
                    break;
                  case 'R':
                    $estadoScript = "RECHAZADO";
                    break;
                  default:
                    $estadoScript = "";
                    break;
                }

              if($nodo->estadoVisacion=="P"){

                  $pass = '<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-check" title="No Puede Aprobar Renegociación"></i></a>';
                  $deny = '<a href="javascript:Client.denyScript('.$nodo->idRefinanciamiento.');" class="btn btn-success btn-xs"><i class="fa fa-close" title="Rechazar Renegociación"></i></a>';
              }

              if($view_author){

                  $pass = '<a href="javascript:Client.passException('.$nodo->idRefinanciamiento.');" class="btn btn-success btn-xs"><i class="fa fa-check" title="Aprobar Excepción"></i></a>';
                  $deny = '<a href="javascript:Client.denyException('.$nodo->idRefinanciamiento.');" class="btn btn-success btn-xs"><i class="fa fa-close" title="Rechazar Excepción"></i></a>';

              }else{

                  $pass = '<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-check" title="No Puede Aprobar Renegociación"></i></a>';
                  $deny = '<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-close" title="No Puede Rechazar Renegociación"></i></a>';
              }

            if($fieldRequest["id_rol"]==USER_ROL_JEFE_COBRANZA 
                    OR $fieldRequest["id_rol"]==USER_ROL_SUPERVISOR_CALIDAD
                    OR $fieldRequest["id_rol"]==USER_ROL_SUPERVISOR_EXCEPCIONES
                    OR $fieldRequest["id_rol"]==USER_ROL_EJECUTIVO_COBRANZA){


                    $htmlRenegotiation .= '<tr onclick="Client.selectRequest(this);">
                          <td scope="col" class="text-center">'.$nodo->idRefinanciamiento.'</td>
                          <td scope="col" class="text-center">'.$nodo->rut.'-'.$dgvRut.'</td>
                          <td scope="col" class="text-center">'.$nodo->nombres." ".$nodo->apellidos.'</td>
                          <td scope="col" class="text-right">$'.number_format((float)$nodo->deudaRene, 0, ',', '.').'</td>
                          <td scope="col" class="text-center">'.$date_stamp.'</td>
                          <td scope="col" class="text-center">'.$name_status.'</td>
                          <td scope="col" class="text-center">'.$name_situation.'</td>
                          <td scope="col" class="text-center">'.$nodo->usuarioCreador.'</td>
                          <td scope="col" class="text-center">'.$nodo->excepcion.'</td>
                          <td scope="col" class="text-center">'.$nodo->motivoScript.'</td>
                          <td scope="col" class="text-center">'.$estadoScript.'</td>
                          <td scope="col" class="text-center" nowrap>'.$script.
                          '<td class="text-center" nowrap><a href="javascript:Client.editRenegotiation('.$nodo->idRefinanciamiento.','.$nodo->rut.');" class="btn btn-success btn-xs"><i class="hi hi-search" title="Consultar"></i></a>'.
                          $pass.$deny.'</td></tr>';

                }else{

                      $htmlRenegotiation .= '<tr onclick="Client.selectRequest(this);">
                          <td scope="col" class="text-center">'.$nodo->idRefinanciamiento.'</td>
                          <td scope="col" class="text-center">'.$nodo->rut.'-'.$dgvRut.'</td>
                          <td scope="col" class="text-center">'.$nodo->nombres." ".$nodo->apellidos.'</td>
                          <td scope="col" class="text-right">$'.number_format((float)$nodo->deudaRene, 0, ',', '.').'</td>
                          <td scope="col" class="text-center">'.$name_office.'</td>
                          <td scope="col" class="text-center">'.$date_stamp.'</td>
                          <td scope="col" class="text-center">'.$name_status.'</td>
                          <td scope="col" class="text-center">'.$name_situation.'</td>
                          <td class="text-center" nowrap ><a href="javascript:Client.editRenegotiation('.$nodo->idRefinanciamiento.','.$nodo->rut.');" class="btn btn-success btn-xs"><i class="hi hi-search" title="Consultar"></i></a>'.
                          $script.'</tr>';
                }

                  }
              }
          }

      }else{

            $htmlRenegotiation .= '<tr>
                <td scope="col" class="text-center" nowrap colspan="'.$colspan.'">'.$descRetorno.'</td>
            </tr>';

      }
      $htmlRenegotiation .= '</tbody></table>';

      $value['retorno'] = $retorno;
      $value['descRetorno'] = $descRetorno;
      $value['htmlRenegotiation'] = $htmlRenegotiation;

      $data = $value;
      return($data);
}

function ws_EVAL_SOAP($request){

    if($request["soap"]["codErrorSOAP"]!=0){

        put_logevent($request["soap"], SOAP_ERROR);

        $data["retorno"] = $request["soap"]["codErrorSOAP"];
        $data["descRetorno"] = $request["soap"]["msgErrorSOAP"];
        return ($data);
    }

    $eval = eval_response_SOAP($request["soap"]["xmlString"], $request["tagName"], $request["serviceName"]);
    if($eval["retorno"]==0){

        put_logevent($request["soap"], SOAP_OK);
        $data["xmlDocument"] = $eval["xmlDocument"];

    }else{

        put_logevent($request["soap"], SOAP_ERROR);
    }

    $data["retorno"] = $eval["retorno"];
    $data["descRetorno"] = $eval["descRetorno"];
    return ($data);
}



function ws_GET_Lista_MorasVirtuales($fieldRequest){

    $CI = get_instance();
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut);
    $dgvRut = substr($nroRut, -1); $nroRut = substr($nroRut, 0, -1);

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Header   xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        </soap:Header>
        <soapenv:Body>
        <req:DATA xmlns:req="http://www.solventa.cl/request">
        <req:rut>'.$nroRut.'</req:rut>
        <req:dv>'.$dgvRut.'</req:dv>
        <req:fecha>'.$fieldRequest["dateEnd"].'</req:fecha>
        <req:motivo>'.$fieldRequest["reason"].'</req:motivo>
        </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaMoraVirtual;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaMoraVirtual, WS_Timeout90, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaMoraVirtual);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }

    $htmlCollection = '<table class="table table-striped table-bordered" id="tabRenegotiation">
        <thead>
        <tr>
            <th class="text-center"><strong>Cliente</strong></th>
            <th class="text-center"><strong>Usuario</strong></th>
            <th class="text-center"><strong>Fecha Inicio</strong></th>
            <th class="text-center"><strong>Fecha Termino</strong></th>
            <th class="text-center"><strong>Motivo</strong></th>
        </tr>
        </thead>';

    if($eval["retorno"]==0){

        $xml = $eval["xmlDocument"];
        $retorno = (int)$xml->Body->DATA->cabeceraSalida->retorno;
        $descRetorno = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

        if($retorno==0){

            foreach ($xml->Body->DATA as $recordTRX) {

                foreach ($recordTRX as $nodo) {

                    if($nodo->nroRut>0){

                      $htmlCollection .= '<tr">
                            <td scope="col" class="text-center">'.$nodo->nroRut."-".$nodo->dvRut.'</td>
                            <td scope="col" class="text-center">'.$nodo->ejecutivo.'</td>
                            <td scope="col" class="text-center">'.substr($nodo->fechaInicioVigencia,8,2)."-".substr($nodo->fechaInicioVigencia,5,2)."-".substr($nodo->fechaInicioVigencia,0,4).'</td>
                            <td scope="col" class="text-center">'.substr($nodo->fechaFinVigencia,8,2)."-".substr($nodo->fechaFinVigencia,5,2)."-".substr($nodo->fechaFinVigencia,0,4).'</td>
                            <td scope="col" class="text-center">'.$nodo->motivo.'</td></tr>';
                    }

                }
            }

        }else{

            $htmlCollection .= '<tr>
                <td scope="col" class="text-center" nowrap colspan="5">'.$descRetorno.'</td>
            </tr>';

        }

    }else{

        $htmlCollection .= '<tr>
          <td scope="col" class="text-center" nowrap colspan="5">'.$eval["descRetorno"].'</td>
        </tr>';

        $retorno = $eval["retorno"];
        $descRetorno = $eval["descRetorno"];
    }
    $htmlCollection .= '</tbody></table>';

    $value['retorno'] = $retorno;
    $value['descRetorno'] = $descRetorno;
    $value['htmlCollection'] = $htmlCollection;

    $data = $value;
    return($data);

}

function ws_PUT_GrabarRazonVisitaTC($nroRut, $reasonSkill, $reasonDetail, $username, $id_office){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:rut>'.$nroRut.'</req:rut>
          <req:comercio>27</req:comercio>
          <req:fecha>'.date('d-m-Y H:i:s').'</req:fecha>
          <req:codCanal>001</req:codCanal>
          <req:codVisita>'.substr($reasonSkill, -3).'</req:codVisita>
          <req:ejecutivo>'.$username.'</req:ejecutivo>';

    if($reasonSkill==115999){
        $Request.= '<req:descripcionOtro>'.$reasonDetail.'</req:descripcionOtro>';
    }else{
        $Request.= '<req:descripcionOtro></req:descripcionOtro>';
    }
    $Request.= '<req:codLocal>'.$id_office.'</req:codLocal>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_GrabarRazonVisitaTC;
    $soap = get_SOAP($EndPoint, WS_Action_GrabarRazonVisitaTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_GrabarRazonVisitaTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["xmlString"] = $soap["xmlString"];

    $data = $value;
    return($data);
}

function ws_GET_DataSecureClient($fieldRequest){

    $CI = get_instance(); $username = $CI->session->userdata("username");
    $dataInput = array(
        "nroRut" => $fieldRequest["nroRut"],
        "contrato" => $fieldRequest["contrato"],
        "comercio" => $fieldRequest["comercio"],
        "username" => $username
    );

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

    $montoPrimaUF = 0; $montoPrimaCL = 0;
    $result = json_decode(ws_GET_ConsultaSegurosContratados($dataInput));
    if($result->retorno==0){

        $dataSecure.= '<tbody>';
        foreach ($result->seguros as $field) {

            if(substr($field->codigoSeguro,0,4)=="DESG"){
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

    $value["dataSecure"] = $dataSecure;
    $value["montoPrimaCL"] = $montoPrimaCL;
    $value["montoPrimaUF"] = $montoPrimaUF;
    return $value;
}

function ws_GET_ParamsContract($fieldRequest){

    $CI = get_instance(); $username = $CI->session->userdata("username");
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaParametrosContrato/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
      <req:rut>'.$nroRut.'</req:rut>
      <req:cuenta>'.$fieldRequest["contrato"].'</req:cuenta>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ParamsContract;
    $soap = get_SOAP($EndPoint, WS_Action_ParamsContract , WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "Registro", "serviceName" => WS_ParamsContract);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    if($value["retorno"]==0){

            $tipoMonedaCobroAdministracion = (string)$xml->Body->DATA->Registro->tipoMonedaCobroAdministracion;
            $tipoMonedaCobroComisionAvance = (string)$xml->Body->DATA->Registro->tipoMonedaCobroComisionAvance;
            $tipoMonedaDesgravamen = (string)$xml->Body->DATA->Registro->tipoMonedaDesgravamen;

            $cobroAdministracionMensualCL = 0; $comisionAvanceCL = 0;
            $dataInput = array(
                'fechaConsulta' => date('d-m-Y'),
                'username' => $username
            );
            $result = json_decode(ws_GET_ConsultaValorUF($dataInput));

            if($result->retorno!=0 AND ($tipoMonedaCobroAdministracion=="UF" OR $tipoMonedaDesgravamen=="UF")){

                $value["retorno"] = $result->retorno;
                $value["descRetorno"] = $result->descRetorno;
                $data = $value;
                return ($data);
            }

            if($tipoMonedaCobroAdministracion=="UF"){

                $montoUF = (string)$xml->Body->DATA->Registro->cobroAdministracionMensual;
                $montoCL = (float)$montoUF * (float)$result->valorUF;
                $cobroAdministracionMensual = (int)$montoCL;

            }else{

                $cobroAdministracionMensual = (string)$xml->Body->DATA->Registro->cobroAdministracionMensual;
            }

            if($tipoMonedaCobroComisionAvance=="UF"){

                $montoUF = (string)$xml->Body->DATA->Registro->comisionAvance;
                $montoCL = (float)$montoUF * (float)$result->valorUF;
                $comisionAvance = (int)$montoCL;

            }else{

                $comisionAvance = (string)$xml->Body->DATA->Registro->comisionAvance;
            }

            if($tipoMonedaDesgravamen=="UF"){

                $montoUF = (string)$xml->Body->DATA->Registro->valorDesgravamen;
                $montoCL = (float)$montoUF * (float)$result->valorUF;
                $valorDesgravamen = (int)$montoCL;
            }else{

                $valorDesgravamen = (string)$xml->Body->DATA->Registro->valorDesgravamen;
            }

            $value["cobroAdministracionMensual"] = $cobroAdministracionMensual;
            $value["comisionAvance"] = $comisionAvance;
            $value["valorDesgravamen"] = $valorDesgravamen;

    }

    $data = $value;
    return($data);
}

function ws_GET_CountRenegotiation($fieldRequest){

    $CI = get_instance();
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut);
    $nroRut = substr($nroRut, 0, -1);

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
      <req:rut>'.$nroRut.'</req:rut>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_CountRenegotiation;
    $soap = get_SOAP($EndPoint, WS_Action_CountRenegotiation , WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_CountRenegotiation);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($value["retorno"]==0){
            $value["nroReneg"] = (int)$xml->Body->DATA->response->nroReneg;
    }

    $data = $value;
    return($data);
}

function ws_GET_DataContactClient($fieldRequest){

    $CI = get_instance(); $username = $CI->session->userdata("username");

    $value["email"] = ""; $value["phone"] = ""; $value["address"] = "";

    $result = ws_GET_DatosContactos($fieldRequest["nroRut"], $fieldRequest["contrato"], $fieldRequest["flg_flujo"], $username);
    if($result["retorno"]==0){

          if($result["emailHome"]!="") { $value["email"] = (string)$result["emailHome"]; }
          else { $value["email"] = (string)$result["emailWork"]; }

          if($result["phoneMobile"]!="") { $value["phone"] = (string)$result["phoneMobile"]; }
          else { $value["phone"] = (string)$result["phoneWork"]; }
    }

    $result = json_decode(ws_GET_ConsultaDatosDireccion($fieldRequest["nroRut"], $fieldRequest["contrato"], $fieldRequest["flg_flujo"], $username));
    if($result->retorno==0) {

        foreach ($result->direcciones as $field) {

            if($field->tipoDireccion=="WORK"){

                $value["address"] = $field->calle." N. ".$field->numeroCalle." ".$field->comuna.", ".$field->ciudad.", ".$field->region;
            }
        }

        foreach ($result->direcciones as $field) {

            if($field->tipoDireccion=="HOME"){

                $value["address"] = $field->calle." N. ".$field->numeroCalle." ".$field->comuna.", ".$field->ciudad.", ".$field->region;
            }
        }
    }

    return($value);
}


/* Servicios Renegociación*/

function ws_PUT_Renegotiation($fieldRequest) {

    if($fieldRequest["tipoRef"]=="RM"){

            if($fieldRequest["flg_flujo"]=="001"){

                    if($fieldRequest["deferred_quotes"]==0){
                        $idTx = COD_TRX_REN_SIN_DIFERIDO_001;
                    }else{
                        $idTx = COD_TRX_REN_CON_DIFERIDO_001;
                    }

                    if($fieldRequest["flg_type"]=="N" ){

                      $estado = "PTN";

                    }else{

                      if($fieldRequest["approver"]==1){

                          $estado = "PTN";

                      }else{

                          $estado = "PTE";
                      }

                    }

            }else{

                    if($fieldRequest["deferred_quotes"]==0){
                      $idTx = COD_TRX_REN_SIN_DIFERIDO_002;
                    }else{
                      $idTx = COD_TRX_REN_CON_DIFERIDO_002;
                    }

                    if($fieldRequest["flg_type"]=="N" ){
                      $estado = "PVN";
                    }else{
                      $estado = "PVE";
                    }

            }
    }else{

            if($fieldRequest["flg_flujo"]=="001"){

                    if($fieldRequest["flg_type"]=="N" ){

                      $estado = "PTN";

                    }else{

                      if($fieldRequest["approver"]==1){

                          $estado = "PTN";

                      }else{

                          $estado = "PTE";
                      }

                    }

            }else{

                if($fieldRequest["flg_type"]=="N" ){

                    $estado = "PVN";

                }else{

                    $estado = "PVE";
                }

            }

            if($fieldRequest["deferred_quotes"]==0){
                $idTx = COD_TRX_REF_SIN_DIFERIDO;
            }else{
                $idTx = COD_TRX_REF_CON_DIFERIDO;
            }

    }

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
      <req:tipoTrx>RENE</req:tipoTrx>
      <req:tipoRef>'.$fieldRequest["tipoRef"].'</req:tipoRef>
      <req:comercio>27</req:comercio>
      <req:idTx>'.$idTx.'</req:idTx>
      <req:estadoVisacion>P</req:estadoVisacion>
      <req:nombres>'.$fieldRequest["nameClient"].'</req:nombres>
      <req:apellidos>'.$fieldRequest["lastnameClient"].'</req:apellidos>
      <req:nroRut>'.$fieldRequest["number_rut_client"].'</req:nroRut>
      <req:dvRut>'.$fieldRequest["digit_rut_client"].'</req:dvRut>
      <req:mesesDiferidos>'.$fieldRequest["deferred_quotes"].'</req:mesesDiferidos>
      <req:fecha>'.$fieldRequest["date_stamp"].'</req:fecha>
      <req:deudaAntesDeRene>'.$fieldRequest["amount_renegotiate"].'</req:deudaAntesDeRene>
      <req:montoLiquido>'.$fieldRequest["amount_renegotiate"].'</req:montoLiquido>
      <req:montoCredito>'.$fieldRequest["amount_total_renegotiate"].'</req:montoCredito>
      <req:costoTotalCredito>'.$fieldRequest["amount_total_renegotiate"].'</req:costoTotalCredito>
      <req:plazo>'.$fieldRequest["number_quotes"].'</req:plazo>
      <req:interesDiario>0</req:interesDiario>
      <req:interesMensual>0</req:interesMensual>
      <req:valorDeCuota>'.$fieldRequest["amount_quotes_value"].'</req:valorDeCuota>
      <req:cupoCompraPostRene>'.$fieldRequest["amount_purchase"].'</req:cupoCompraPostRene>
      <req:cupoAvancePostRene>'.$fieldRequest["amount_advance"].'</req:cupoAvancePostRene>
      <req:tasaInteresMensual>'.$fieldRequest["amount_interest"].'</req:tasaInteresMensual>
      <req:comisionDeAdministracionMensual>'.$fieldRequest["cobroAdministracionMensual"].'</req:comisionDeAdministracionMensual>
      <req:comisionMantencionMensual>0</req:comisionMantencionMensual>
      <req:seguroDesgravamen>'.$fieldRequest["amount_quotes_secure"].'</req:seguroDesgravamen>
      <req:fechaPrimerVencimiento>'.$fieldRequest["first_date_expires_quotes"].'</req:fechaPrimerVencimiento>
      <req:cargaAnualEquivalente>'.$fieldRequest["amount_cae_rate"].'</req:cargaAnualEquivalente>
      <req:ITE>'.$fieldRequest["amount_quotes_taxes"].'</req:ITE>
      <req:sucursal>'.$fieldRequest["id_office"].'</req:sucursal>
      <req:pan>'.$fieldRequest["nroTcv"].'</req:pan>
      <req:domicilio>'.$fieldRequest["lblDireccion"].'</req:domicilio>
      <req:email>'.$fieldRequest["email"].'</req:email>
      <req:ejecutivo>'.$fieldRequest["username"].'</req:ejecutivo>
      <req:flagTecnocom>'.$fieldRequest["flg_flujo"].'</req:flagTecnocom>
      <req:idContrato>'.$fieldRequest["contrato"].'</req:idContrato>
      <req:telefono>'.$fieldRequest["number_phone"].'</req:telefono>
      <req:usuarioAceptacion></req:usuarioAceptacion>
      <req:fechaAceptacion></req:fechaAceptacion>
      <req:usuarioLiquidacion></req:usuarioLiquidacion>
      <req:fechaLiquidacion></req:fechaLiquidacion>
      <req:usuarioExcepcion></req:usuarioExcepcion>
      <req:fechaExcepcion></req:fechaExcepcion>
      <req:estadoExcepcion>'.$estado.'</req:estadoExcepcion>
      <req:moraVirtual>'.$fieldRequest["approver"].'</req:moraVirtual>
      <req:aprobadoConRevision>'.$fieldRequest["collection"].'</req:aprobadoConRevision>
      <req:motivo>'.$fieldRequest["reason"].'</req:motivo>
      <req:diasMora>'.$fieldRequest["diasMora"].'</req:diasMora>
      <req:RenesVigentes>'.$fieldRequest["renesVigentes"].'</req:RenesVigentes>
      <req:cupoCompraAnterior>'.$fieldRequest["cupoCompraAnterior"].'</req:cupoCompraAnterior>
      <req:cupoAvanceAnterior>'.$fieldRequest["cupoAvanceAnterior"].'</req:cupoAvanceAnterior>
      <req:abonoMinimo>'.$fieldRequest["amount_minimum"].'</req:abonoMinimo>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_GrabaReneTC;
    $soap = get_SOAP($EndPoint, WS_Action_GrabaReneTC , WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_GrabaReneTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["xmlDocument"] = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($value["retorno"]==0){

        $value["codAutorizacion"] = (string)$xml->Body->DATA->response->codAutorizacion;
        $value["deudaAntesDeRene"] = (string)$xml->Body->DATA->response->deudaAntesDeRene;
        $value["fecha1erVencimiento"] = (string)$xml->Body->DATA->response->fecha1erVencimiento;
        $value["idRefinanciamiento"] = (string)$xml->Body->DATA->response->idRefinanciamiento;
        $value["idUnicoDeTrx"] = (string)$xml->Body->DATA->response->idUnicoDeTrx;
        $value["mesesDiferidos"] = (string)$xml->Body->DATA->response->mesesDiferidos;
        $value["plazo"] = (string)$xml->Body->DATA->response->plazo;
        $value["valorDeCuota"] = (string)$xml->Body->DATA->response->valorDeCuota;
    }
    $data = $value;

    return ($data);
}

function ws_PUT_Collection($fieldRequest) {

    $CI = get_instance();
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut);
    $dgvRut = substr($nroRut, -1); $nroRut = substr($nroRut, 0, -1);

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
      <req:nroRut>'.$nroRut.'</req:nroRut>
      <req:dvRut>'.$dgvRut.'</req:dvRut>
      <req:fechaFinVigencia>'.$fieldRequest["dateEnd"].'</req:fechaFinVigencia>
      <req:motivo>'.$fieldRequest["reason"].'</req:motivo>
      <req:ejecutivo>'.$CI->session->userdata("username").'</req:ejecutivo>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_InsertarMoraVirtual;
    $soap = get_SOAP($EndPoint, WS_Action_InsertarMoraVirtual , WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_InsertarMoraVirtual);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $data = $value;
    return ($data);
}

function ws_PUT_ReversaPagoRenegociacion($fieldRequest){

    $CI = get_instance();
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ReversaPagoRenegociacion/Req-v2021.12">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:rut>'.$fieldRequest["rut"].'</req:rut>
         <req:contrato>'.$fieldRequest["contrato"].'</req:contrato>
         <req:fechaFacturacion>'.$fieldRequest["fechaFacturacion"].'</req:fechaFacturacion>
         <req:tipoFacturacion>'.$fieldRequest["tipoFacturacion"].'</req:tipoFacturacion>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ReversaPagoRenegociacion;
    $soap = get_SOAP($EndPoint, WS_Action_ReversaPagoRenegociacion , WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_ReversaPagoRenegociacion);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    $data = $value;
    return ($data);
}

function ws_PUT_PagoOnlineRenegotiation($fieldRequest) {

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Header xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        </soap:Header>
        <soapenv:Body>
        <req:DATA xmlns:req="http://www.solventa.cl/request">
        <req:rut>'.$fieldRequest["rut"].'</req:rut>
        <req:cuenta>'.$fieldRequest["contrato"].'</req:cuenta>
        <req:fecfac>
           <req:valueDate>'.date("d-m-Y").'</req:valueDate>
        </req:fecfac>
        <req:impfac>'.$fieldRequest["deudaRef"].'</req:impfac>
        <req:linref>0</req:linref>
        <req:tipdocpag>05</req:tipdocpag>
        <req:tipofac>615</req:tipofac>
        </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_PagoOnlineTecnocom;
    $soap = get_SOAP($EndPoint, WS_Action_PagoOnlineTecnocom , WS_Timeout30, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_PagoOnlineTecnocom);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["xmlDocument"] = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($value["retorno"]==0){

        $value["clamon"] = (string)$xml->Body->DATA->response->PagoOnlineTecnocom->clamon;
    }

    $data = $value;
    return ($data);
}

function ws_PUT_AltaRenegotiation($fieldRequest) {

    switch ($fieldRequest["mesesDiferidos"]) {
        case 0: $codtipcav = 610;
            break;
        case 1: $codtipcav = 611;
            break;
        case 2: $codtipcav = 671;
            break;
        default: $codtipcav = 611;
            break;
    }

    $tipolin = "LREV";
    if($fieldRequest["producto"]=="01" and $fieldRequest["subproducto"]=="0001"){
          $tipolin = "LNCC";}
    if($fieldRequest["producto"]=="01" and $fieldRequest["subproducto"]=="0004"){
          $tipolin = "LREV";}

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Header xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        </soap:Header>
        <soapenv:Body>
        <req:DATA xmlns:req="http://www.solventa.cl/request">
        <req:rut>'.$fieldRequest["rut"].'</req:rut>
        <req:codcom>000000900000910</req:codcom>
        <req:codtipcav>'.$codtipcav.'</req:codtipcav>
        <req:cuenta>'.$fieldRequest["contrato"].'</req:cuenta>
        <req:impfacav>'.$fieldRequest["monto"].'</req:impfacav>
        <req:indporint>N</req:indporint>
        <req:indproaje>P</req:indproaje>
        <req:indsimconf>C</req:indsimconf>
        <req:nompob>PROVIDENCIA</req:nompob>
        <req:numbencta>1</req:numbencta>
        <req:nummesfin>SSSSSSSSSSSS</req:nummesfin>
        <req:tipolin>'.$tipolin.'</req:tipolin>
        <req:totcuotasav>'.$fieldRequest["nroCuotas"].'</req:totcuotasav>
        </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_AltaCompCuoTecnocom;
    $soap = get_SOAP($EndPoint, WS_Action_AltaCompCuoTecnocom , WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_AltaCompCuoTecnocom);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["xmlDocument"] = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($value["retorno"]==0){

        $value["centalta"] = (string)$xml->Body->DATA->response->AltaCompCuoTecnocom->centalta;
    }
    $data = $value;

    return ($data);
}

function ws_PUT_GrabaEstadosCuenta($fieldRequest) {

    $CI = get_instance();
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/GrabaEstadosCuenta/Req-v2019.12">
       <soapenv:Header/>
       <soapenv:Body>
          <req:DATA>
             <req:CONTRATO>'.$fieldRequest["contrato"].'</req:CONTRATO>
             <req:CODIGO_BLOQUEO>'.$fieldRequest["codigo_bloqueo"].'</req:CODIGO_BLOQUEO>
             <req:FECHA_ESTADO>'.$fieldRequest["fecha_estado"].'</req:FECHA_ESTADO>
             <req:RUT>'.$fieldRequest["rut"].'</req:RUT>
             <req:INDICADOR_BLOQUEO>'.$fieldRequest["indicador_bloqueo"].'</req:INDICADOR_BLOQUEO>
             <req:PAN>'.$fieldRequest["pan"].'</req:PAN>
             <req:TEXTO_BLOQUEO>'.$fieldRequest["texto_bloqueo"].'</req:TEXTO_BLOQUEO>
             <req:FLAG_FLUJO>'.$fieldRequest["flag_flujo"].'</req:FLAG_FLUJO>
          </req:DATA>
       </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_GrabaEstadosCuenta;
    $soap = get_SOAP($EndPoint, WS_Action_GrabaEstadosCuenta , WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_GrabaEstadosCuenta);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    $data = $value;
    return ($data);
}

function ws_PUT_AltaCuposRenegotiation($fieldRequest) {

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Header xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        </soap:Header>
        <soapenv:Body>
        <req:DATA xmlns:req="http://xsd.solventachile.cl/ActualizaCuposTC/Req-v2019.12">
        <req:CONTRATO>'.$fieldRequest["contrato"].'</req:CONTRATO>
        <req:RUT>'.$fieldRequest["idClient"].'</req:RUT>
        <req:CUPO>'.$fieldRequest["cupo"].'</req:CUPO>
        <req:INDPORLIM>I</req:INDPORLIM>
        <req:PORLIM>0</req:PORLIM>
        <req:TIPOLIN>'.$fieldRequest["tipolin"].'</req:TIPOLIN>
        <req:FLAG_FLUJO>'.$fieldRequest["flg_flujo"].'</req:FLAG_FLUJO>
        </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaCuposTC;
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaCuposTC , WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ActualizaCuposTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["xmlDocument"] = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    $data = $value;
    return ($data);
}

function ws_PUT_ActualizaEstadoRenegotiation($fieldRequest) {

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Header xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        </soap:Header>
        <soapenv:Body>
        <req:DATA xmlns:req="http://www.solventa.cl/request">
        <req:flagTecnocom>'.$fieldRequest["flg_flujo"].'</req:flagTecnocom>
        <req:idUnicoDeTrx>'.$fieldRequest["idUnicoDeTrx"].'</req:idUnicoDeTrx>
        <req:usuarioVisador>'.$fieldRequest["username_visa"].'</req:usuarioVisador>
        <req:estadoVisacion>'.$fieldRequest["status_visa"].'</req:estadoVisacion>
        <req:fechaVisacion>'.$fieldRequest["date_stamp_visa"].'</req:fechaVisacion>
        <req:usuarioAceptacion>'.$fieldRequest["username_accept"].'</req:usuarioAceptacion>
        <req:fechaAceptacion>'.$fieldRequest["date_stamp_accept"].'</req:fechaAceptacion>
        <req:usuarioLquidacion>'.$fieldRequest["username_liquidation"].'</req:usuarioLquidacion>
        <req:fechaLiquidacion>'.$fieldRequest["date_stamp_liquidation"].'</req:fechaLiquidacion>
        <req:usuarioExcepcion>'.$fieldRequest["username_exception"].'</req:usuarioExcepcion>
        <req:fechaExcepcion>'.$fieldRequest["date_stamp_exception"].'</req:fechaExcepcion>
        <req:estadoExcepcion>'.$fieldRequest["status_exception"].'</req:estadoExcepcion>
        <req:aprobadoConRevision>'.$fieldRequest["aprobadoConRevision"].'</req:aprobadoConRevision>
        <req:motivoRechazo>'.$fieldRequest["motivoRechazo"].'</req:motivoRechazo>
        <req:estadoScript>'.$fieldRequest["estadoScript"].'</req:estadoScript>
        <req:motivoScript>'.$fieldRequest["motivoScript"].'</req:motivoScript>
        </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaEstadoRene;
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaEstadoRene , WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ActualizaEstadoRene);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["xmlDocument"] = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;
    $data = $value;
    return ($data);
}


function ws_PUT_ActualizaRenesANoVigentes($fieldRequest) {

    $CI = get_instance();
    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut);
    $nroRut = substr($nroRut, 0, -1);

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:req="http://www.solventa.cl/request">
        <soapenv:Header/>
        <soapenv:Body>
        <req:DATA>
        <req:rutSinDv>'.$nroRut.'</req:rutSinDv>
        </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaRenesANoVigentes;
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaRenesANoVigentes , WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ActualizaRenesANoVigentes);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $value["xmlDocument"] = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $data = $value;
    return ($data);
}

function ws_GET_TasaMaxima($fieldPlazo, $fieldMontoPesos, $username) {

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:montoPesos>'.$fieldMontoPesos.'</req:montoPesos>
         <req:plazo>'.$fieldPlazo.'</req:plazo>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaTasaMaxima;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaTasaMaxima , WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaTasaMaxima);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    if($retorno==0) {

        $value["tasaMaxima"] = (float)$xml->Body->DATA->response->tasaMaxima;
    }
    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $data = $value;
    return ($data);
}

function get_ValidatePhoneMobile($numberPhone){

    if(!is_numeric($numberPhone)){
        $data = array('retorno' => 100,
            'descRetorno' => 'Error, Número Celular debe contener solo números..');
    }else{
        if(substr($numberPhone,0,1)!="9") {
            $data = array('retorno' => 109,
                'descRetorno' => 'Error, Número Celular debe comenzar con 9');
        }else{
            if(strlen($numberPhone)!=9){
                $data = array('retorno' => 109,
                    'descRetorno' => 'Error, Número Celular debe contener 9 digitos');
            }else{
                $data = array('retorno' => 0,
                    'descRetorno' => 'Número Celular es correcto ');
            }
        }
    }
    return ($data);
}

function get_ValidatePhonePermanent($numberPhone){

    $zonesPhone = array('Provincias de Arica y Parinacota' => 58,
        'Provincias de Iquique y Tamarugal' => 57,
        'Provincias de Antofagasta, El Loa y Tocopilla' => 55,
        'Provincia de Huasco y Elqui' => 51,
        'Provincias de Chañaral y Copiapó' => 52,
        'Provincias de Choapa y Limarí' => 53,
        'Provincias Valparaíso' => 32,
        'Provincias de Los Andes y San Felipe de Aconcagua' => 34,
        'Provincia de San Antonio' => 35,
        'Provincia de Isla de Pascua1' => 39,
        'Provincias de Petorca y Quillota' => 33,
        'Provincias de Cachapoal, Cardenal Caro y Colchagua' => 72,
        'Provincia de Talca' => 71,
        'Provincias de Cauquenes y Linares' => 73,
        'Provincia de Curicó' => 75,
        'Provincias de Arauco y Concepción' => 41,
        'Provincia de Ñuble' => 42,
        'Provincia de Biobío' => 43,
        'Provincias de Cautín y Malleco' => 45,
        'Provincias de Ranco y Valdivia' => 63,
        'Provincia de Osorno' => 64,
        'Provincias de Chiloé, Llanquihue y Palena' => 65,
        'Provincias de Aisén, Capitán Prat, Coihaique y General Carrera' => 67,
        'Provincias de Antártica Chilena, Magallanes, Tierra del Fuego y Última Esperanza' => 61);

    if(!is_numeric($numberPhone)){
        $data = array('retorno' => 100,
            'descRetorno' => 'Error, Número Teléfono debe contener solo números..');
    }else{
        if(substr($numberPhone,0,1)=="2") {
            if(substr($numberPhone,1,1)!="2"){
                $data = array('retorno' => 109,
                    'descRetorno' => 'Teléfono Fijo código área {'.substr($numberPhone,0,2).'} no es valido');
            }else{
                if(strlen($numberPhone)!=9){
                    $data = array('retorno' => 109,
                        'descRetorno' => 'Error, Número Teléfono debe contener 9 digitos.');
                }else{
                    $data = array('retorno' => 0,
                        'descRetorno' => 'Datos Contacto Personal actualizada correctamente!');
                }
            }
        }else{
          $is_validZoneCode = false;
          foreach($zonesPhone as $nameCode=>$numberCode)
          {
              if($numberCode==substr($numberPhone,0,2)){ $is_validZoneCode = true; }
          }
          if(!$is_validZoneCode){
              $data = array('retorno' => 100,
                  'descRetorno' => 'Teléfono Fijo código área {'.substr($numberPhone,0,2).'} no es valido');
          }else{
              if(strlen($numberPhone)!=9){
                  $data = array('retorno' => 109,
                      'descRetorno' => 'Error, Número Teléfono debe contener 9 digitos.');
              }else{
                  $data = array('retorno' => 0,
                      'descRetorno' => 'Teléfono Fijo {'.$numberPhone.'} es valido!');
              }
          }
      }
  }
  return ($data);
}

function ws_GET_DatosClienteTC($nroRut, $flg_flujo, $username){

    $rut = $nroRut; $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $serviceName = "<br>[Servicio->ConsultaDatosCliente]";
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosClienteTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:NRO_RUT>'.$nroRut.'</req:NRO_RUT>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosClienteTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosClienteTC , WS_Timeout30, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosClienteTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno;  $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno!=0) {

        $value['retorno'] = $retorno;
        $value['descRetorno'] = $descRetorno.$serviceName;
        $data = $value;
        return ($data);
    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $value["nroRut"] = $rut;
    $value["apellidoPaterno"] = (string)$xml->Body->DATA->Registro->apellidoPaterno;
    $value["apellidoMaterno"] = (string)$xml->Body->DATA->Registro->apellidoMaterno;
    $value["nombres"] = (string)$xml->Body->DATA->Registro->nombres;
    $value["nombreCliente"] = $value["nombres"]." ".$value["apellidoPaterno"]." ".$value["apellidoMaterno"];
    $value["sexo"] = (string)$xml->Body->DATA->Registro->sexo;
    $value["nroserie"] = (string)$xml->Body->DATA->Registro->nroserie;
    $value["fechaNacimiento"] = substr((string)$xml->Body->DATA->Registro->fechaNacimiento,0,10);

    $data = $value;
    return ($data);
}

function ws_GET_HomologadorByTcv($nroTarjeta, $username){

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sol="http://www.solventa.cl">
       <soapenv:Header/>
       <soapenv:Body>
        <sol:busquedaPorTarjeta>
             <tarjetaCliente>'.$nroTarjeta.'</tarjetaCliente>
        </sol:busquedaPorTarjeta>
       </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_Homologador_BusquedaPorTarjeta;
    $soap = get_SOAP($EndPoint, WS_Action_Homologador, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "busquedaPorTarjetaResponse", "serviceName" => WS_Homologador_BusquedaPorTarjeta);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];

    $retorno = (int)$xml->Body->busquedaPorTarjetaResponse->return->codigo_respuesta;
    if($retorno!=0) {
        $value["retorno"] = $retorno;
        $value["descRetorno"] = MSG_ERROR_SERVICE_NOOK;

        $data = $value;
        return ($data);
    }
    $flg_tecnocom = (string)$xml->Body->busquedaPorTarjetaResponse->return->flg_tecnocom;
    $cod_producto = (string)$xml->Body->busquedaPorTarjetaResponse->return->cod_producto;

    if($flg_tecnocom=="S"){

            $flg_flujo="001";
            $origen="TECNOCOM";
            $nroTcv=(string)$xml->Body->busquedaPorTarjetaResponse->return->pan_tecnocom;
            $flg_cvencida = (string)$xml->Body->busquedaPorTarjetaResponse->return->flg_cvencida;
    }

    if($flg_tecnocom=="N"){
            $flg_flujo="002";
            $origen="VISSAT";
            $nroTcv=(string)$xml->Body->busquedaPorTarjetaResponse->return->pan_solventa;
            $flg_cvencida = "N";
    }

    $nroRut = (string)$xml->Body->busquedaPorTarjetaResponse->return->rut;
    $r = new Rut();
    $r->number($nroRut);
    $dgvRut = $r->calculateVerificationNumber();

    $value["nroRut"] = $nroRut ."-". $dgvRut;
    $value["retorno"] = $retorno;
    $value["descRetorno"] = "Transacción Aceptada";
    $value["flg_flujo"] = $flg_flujo;
    $value["nroTcv"] = $nroTcv;
    $value["origen"] = $origen;
    $value["flg_cvencida"] = $flg_cvencida;
    $value["flg_tecnocom"] = $flg_tecnocom;
    $value["cod_producto"] = $cod_producto;

    $data = $value;
    return ($data);
}

function ws_GET_ConsultaUltimasTransaccionesTC($contrato, $flg_flujo, $username){

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaUltimasTransaccionesTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:PAN></req:PAN>
         <req:CONTRATO>'.$contrato.'</req:CONTRATO>
         <req:COD_TX>'.COD_TRX_VENTA.'</req:COD_TX>
         <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaUltimasTransaccionesTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaUltimasTransaccionesTC , WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaUltimasTransaccionesTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];

        return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno; $data = array();

    $montoUltimaVenta = 0; $fechaUltimaVenta ="-"; $montoUltimoAvance = 0; $fechaUltimoAvance ="-"; $montoUltimoPago = 0; $fechaUltimoPago ="-"; $montoUltimoCargo = 0; $fechaUltimoCargo ="-";

    if($retorno==0){
        foreach ($xml->Body->DATA->Registro as $field) {

            if($field->codTx==COD_TRX_VENTA) { $montoUltimaVenta = $field->montoLiquido; $fechaUltimaVenta = substr((string)$field->fechaProceso,0,10); }
            if($field->codTx==COD_TRX_AVANCE) { $montoUltimoAvance = $field->montoLiquido; $fechaUltimoAvance = substr((string)$field->fechaProceso,0,10); }
            if($field->codTx==COD_TRX_PAGO) { $montoUltimoPago = $field->montoLiquido; $fechaUltimoPago = substr((string)$field->fechaProceso,0,10); }
            if($field->codTx==COD_TRX_CARGO) { $montoUltimoCargo = $field->montoLiquido; $fechaUltimoCargo = substr((string)$field->fechaProceso,0,10); }

        }
    }

    $data = array(
        "retorno" => $retorno,
        "descRetorno" => $descRetorno,
        "montoUltimaVenta" => $montoUltimaVenta,
        "fechaUltimaVenta" => $fechaUltimaVenta,
        "montoUltimoAvance" => $montoUltimoAvance,
        "fechaUltimoAvance" => $fechaUltimoAvance,
        "montoUltimoPago" => $montoUltimoPago,
        "fechaUltimoPago" => $fechaUltimoPago,
        "montoUltimoCargo" => $montoUltimoCargo,
        "fechaUltimoCargo" => $fechaUltimoCargo
        );

    return($data);
}

function ws_PUT_ActualizaEmail($nroRut, $contrato, $flg_flujo, $email, $typeEmail, $username) {

    if($typeEmail=="HOME") {
        $fieldtypeEmail = "HOME"; $fielduseEmail = "HOM";
    } else {
        $fieldtypeEmail = "HOME"; $fielduseEmail = "ASS";
    }

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $retorno = COD_ERROR_INIT;

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ActualizaDatosContactoTC/Req-v2019.12">
       <soapenv:Header/>
       <soapenv:Body>
          <req:DATA>
             <req:NRO_RUT>'.$nroRut.'</req:NRO_RUT>
             <req:CONTRATO>'.$contrato.'</req:CONTRATO>
             <req:TIPO_CONTACTO>EMA</req:TIPO_CONTACTO>
             <req:USO>'.$fielduseEmail.'</req:USO>
             <req:PUNTO_CONTACTO>'.$email.'</req:PUNTO_CONTACTO>
             <req:TIPO_FONO>'.$fieldtypeEmail.'</req:TIPO_FONO>
             <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
          </req:DATA>
       </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ActualizaDatosContactoTC;
    $soap = get_SOAP($EndPoint, WS_Action_ActualizaDatosContactoTC , WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ActualizaDatosContactoTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data["retorno"] = $eval["retorno"];
        $data["descRetorno"] = $eval["descRetorno"];
        return ($data);
    }
    $xml = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->retorno; $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    $data = $value;
    return ($data);
}

/** Begin::CC028:: **/ 
function ws_GET_ConsultaEstadosBloqueo($dataInput){
    $CI = get_instance();

    $nroRut = str_replace('.', '', $dataInput["nroRut"]); 
    $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $codigoRenegociacion = "NO"; $estadoBloqueo = ""; $diasMora = 0; $prioridad = 999; 
    $retorno = COD_ERROR_INIT; $descRetorno = MSG_ERROR_INIT; 
    $data = array();

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaEstadosBloqueo/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:CONTRATO>' . $dataInput["contrato"] . '</req:CONTRATO>
          <req:RUT>' . $nroRut . '</req:RUT>
          <req:FLAG_FLUJO>' . $dataInput["id_channel"] . '</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaEstadosBloqueo;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaEstadosBloqueo , WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_Action_ConsultaEstadosBloqueo);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];
      return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $codigoRenegociacion = "NO"; $diasMora = 0; $estadoBloqueo = ""; $allow_sale = ""; $allow_pay = "";
    if($retorno==0){
        $prioridad = 999;
        foreach ($xml->Body->DATA as $record) {

            foreach ($record as $nodo) {

                $codigoDeBloqueo = substr((string)$nodo->codigoDeBloqueo,0 ,2);
                if($codigoDeBloqueo!=""){

                    $dataInput["id_status"] = $codigoDeBloqueo;
                    $eval = $CI->parameters->get_parameters_eval_product($dataInput);
                    if($eval!=false){

                        if($eval->allow_sale=="N"){
                            $allow_sale .= $eval->name_status . "</br>";
                        }

                        if($eval->allow_pay=="N"){
                            $allow_pay .= $eval->name_status . "</br>";
                        }

                    }else{
                        $allow_sale .= "[" . $codigoDeBloqueo . "]" . " No definido</br>";
                        $allow_pay .= "[" . $codigoDeBloqueo . "]" . " No definido</br>";
                    }

                    if($codigoDeBloqueo==30 OR $codigoDeBloqueo==15 OR $codigoDeBloqueo==16){
                        $diasMora = (int)$nodo->diasEstado;
                    }

                    if((int)$codigoDeBloqueo==81 OR (int)$codigoDeBloqueo==17){
                        $codigoRenegociacion = "SI";
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

    }else{


        if($retorno==1){

            $retorno = 0;
            $descRetorno = "Transacción Aceptada";
            $estadoBloqueo = "ACTIVA";

        }else{

            $estadoBloqueo = "NO FUE POSIBLE VALIDAR BLOQUEO";

        }

    }

    $data = [
        'retorno' => $retorno,
        'descRetorno' => $descRetorno,
        'diasMora' => $diasMora,
        'estadoBloqueo' => $estadoBloqueo,
        "allow_sale" => $allow_sale,
        "allow_pay" => $allow_pay,
        "codigoRenegociacion" => $codigoRenegociacion,
    ];
    return($data);
}
/** End::CC028:: **/ 

function ws_GET_ConsultaDeudaClienteTC($fieldRequest){

    $nroRut = str_replace('.', '', $fieldRequest["nroRut"]); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaDeudaClienteTC]";

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDeudaClienteTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
        <req:PAN>'.$fieldRequest["nroTcv"].'</req:PAN>
        <req:CONTRATO>'.$fieldRequest["contrato"].'</req:CONTRATO>
        <req:RUT>'.$nroRut.'</req:RUT>
        <req:CLIENTE_COMERCIO>27</req:CLIENTE_COMERCIO>
        <req:PRODUCTO>T</req:PRODUCTO>
        <req:FLAG_FLUJO>'.$fieldRequest["flg_flujo"].'</req:FLAG_FLUJO>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDeudaClienteTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDeudaClienteTC, WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_Action_ConsultaDeudaClienteTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];
      return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno==0){

        $data = array('retorno' => $retorno,
            'descRetorno' => $descRetorno,
            'deudaActual' => (string)$xml->Body->DATA->Registro->deudaActual,
            'interesesCorrientes' => (string)$xml->Body->DATA->Registro->interesesCorrientes,
            'interesesMora' => (string)$xml->Body->DATA->Registro->interesesMora,
            'montoEnMora' => (string)$xml->Body->DATA->Registro->montoEnMora,
            'montoPagado' => (string)$xml->Body->DATA->Registro->montoPagado,
            'pagoDelMesFacturado' => (string)$xml->Body->DATA->Registro->pagoDelMesFacturado,
            'pagoMinimo' => (string)$xml->Body->DATA->Registro->pagoMinimo,
            'producto' => (string)$xml->Body->DATA->Registro->producto,
            'subproducto' => (string)$xml->Body->DATA->Registro->subproducto);

    }else{

        $data = array('retorno' => $retorno,
            'descRetorno' => $descRetorno);
    }

    return ($data);
}

function ws_GET_ConsultaSegurosContratados($input) {

    $input["nroRut"] = str_replace('.', '', $input["nroRut"]);
    $input["nroRut"] = str_replace('-', '', $input["nroRut"]); $input["nroRut"] = substr($input["nroRut"], 0, -1);

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaSegurosContratados]"; $dataResponse = array();
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:nroRut>'.$input["nroRut"].'</req:nroRut>
         <req:comercio>'.$input["comercio"].'</req:comercio>
         <req:contrato></req:contrato>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaSegurosContratados;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaSegurosContratados, WS_Timeout30, $Request, WS_ToXml, $input["username"]);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaSegurosContratados);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data = '{
          "retorno": "'.$eval["retorno"].'",
          "descRetorno": "'.$eval["descRetorno"].'"}';

      return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data = '{
        "retorno": "'.$retorno.'",
        "descRetorno": "'.$descRetorno.'",
        "seguros": [';

    if($retorno==0){

        foreach ($xml->Body->DATA->response as $recordSEG) {
            foreach ($recordSEG as $nodo) {

                if($nodo->estadoSeguro=="A"){
                    if($nodo->estadoSeguro=="A"){
                        $estadoSeguro = "ALTA";
                    }
                    if($nodo->estadoSeguro=="B"){
                        $estadoSeguro = "BAJA";
                    }
                    $data.= '{
                    "codigoSeguro": "'.(string)$nodo->codigoSeguro.'",
                    "empresaAseguradora": "'.(string)$nodo->empresaAseguradora.'",
                    "estadoSeguro": "'.$estadoSeguro.'",
                    "fechaAltaBaja": "'.(string)$nodo->fechaAltaBaja.'",
                    "nombreSeguro": "'.(string)$nodo->nombreSeguro.'",
                    "valorPrima": "'.(float)$nodo->valorPrima.'"},';
                }
            }
        }

    }

    $data.= ']}';
    $data = str_replace("},]}", "} ] }", $data);

    return ($data);
}

function ws_GET_ConsultaSegurosNoContratados($input) {

    $input["nroRut"] = str_replace('.', '', $input["nroRut"]);
    $input["nroRut"] = str_replace('-', '', $input["nroRut"]); $input["nroRut"] = substr($input["nroRut"], 0, -1);

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaSegurosNoContratados]"; $dataResponse = array();
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:nroRut>'.$input["nroRut"].'</req:nroRut>
         <req:comercio>'.$input["comercio"].'</req:comercio>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';
    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaSegurosNoContratados;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaSegurosNoContratados, WS_Timeout30, $Request, WS_ToXml, $input["username"]);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaSegurosNoContratados);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data = '{
          "retorno": "'.$eval["retorno"].'",
          "descRetorno": "'.$eval["descRetorno"].'"}';

      return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data = '{
        "retorno": "'.$retorno.'",
        "descRetorno": "'.$descRetorno.'",
        "seguros": [';

    if($retorno==0){

      foreach ($xml->Body->DATA->response->segNoContratados as $recordSEG) {
          foreach ($recordSEG as $nodo) {

              if(strlen($nodo->codigoSeguro)>1){

                  $data.= '{
                      "codigoSeguro": "'.(string)$nodo->codigoSeguro.'",
                      "empresaAseguradora": "'.(string)$nodo->empresaAseguradora.'",
                      "idPoliza": "'.(string)$nodo->idPoliza.'",
                      "montoMaximo": "'.(string)$nodo->montoMaximo.'",
                      "montoMinimo": "'.(string)$nodo->montoMinimo.'",
                      "nombreSeguro": "'.(string)$nodo->nombreSeguro.'",
                      "montoPrima": "'.$nodo->montoPrima.'"},';
              }
          }
      }
    }
    $data.= ']}';
    $data = str_replace("},]}", "} ] }", $data);

    return ($data);
}


function ws_GET_ConsultaValorUF($input) {

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaValorUF]"; $dataResponse = array();

    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:fechaConsulta>'.$input["fechaConsulta"].'</req:fechaConsulta>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaValorUF;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaValorUF, WS_Timeout30, $Request, WS_ToXml, $input["username"]);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaValorUF);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data = '{
          "retorno": "'.$eval["retorno"].'",
          "descRetorno": "'.$eval["descRetorno"].'"}';

      return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;
    $descRetorno = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $data = '{
        "retorno": "'.$retorno.'",
        "descRetorno": "'.$descRetorno.'"';

    if($retorno==0){

      if(isset($xml->Body->DATA->response->valorUF)){
          $valorUF = (string)$xml->Body->DATA->response->valorUF;
          $valorUF = str_replace(".", "", $valorUF);
          $valorUF = str_replace(",", ".", $valorUF);

          $data.= ', "valorUF": "'.$valorUF.'"';
      }

    }else{

        cancel_function(COD_ERROR_INIT,"Atención, UF fecha " . $input["fechaConsulta"] . " " . $descRetorno,"Preste Atención..!");
    }
    $data.= '}';

    return ($data);
}

function ws_GET_ConsultaTransaccionesTC($nroTcv, $contrato, $flg_flujo, $dateBegin, $dateEnd, $typeSkill){

    $CI = get_instance();
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
    $soap = get_SOAP($EndPoint, WS_ConsultaTransaccionesTC, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosTarjetaTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data = '{
          "retorno": "'.$eval["retorno"].'",
          "descRetorno": "'.$eval["descRetorno"].'",
          "pagos": [ ] }';

      return ($data);
    }
    $xml = $eval["xmlDocument"];
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data = '{
        "retorno": "'.$retorno.'",
        "descRetorno": "'.$descRetorno.'",
        "pagos": [';

      if($retorno==0){

        foreach ($xml->Body->DATA as $recordTRX) {
            foreach ($recordTRX as $nodo) {

              $fechaHora = substr($nodo->fechaHora,0,10);
              $fechaVencimiento = substr($nodo->fechaVencimiento,0,10);
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

                $data.= '{
                    "estadoConciliacion": "'.$descEstadoConciliacion.'",
                    "estadoTx": "'.$descEstadoTx.'",
                    "descTH": "'.$descDescTH.'",
                    "fechaHora": "'.$fechaHora.'",
                    "fechaVencimiento": "'.$fechaVencimiento.'",
                    "fechaProceso": "'.$fechaProceso.'",
                    "montoLiquido": "'.number_format((float)$nodo->montoLiquido,0,',','.').'"},';

              }
            }
          }
      }
      $data.= ']}';
      $data = str_replace("},]}", "} ] }", $data);

      return($data);
}


function ws_GET_ConsultaDatosTarjetaTC($nroTcv, $contrato, $flg_flujo, $username) {

      $CI = get_instance();

      if($flg_flujo=="001"){
          $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosTarjetaTC/Req-v2019.12">
          <soapenv:Header/>
          <soapenv:Body>
             <req:DATA>
                <req:PAN>'.$nroTcv.'</req:PAN>
                <req:CONTRATO>'.$contrato.'</req:CONTRATO>
                <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
             </req:DATA>
          </soapenv:Body>
          </soapenv:Envelope>';

      }else{

          $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosTarjetaTC/Req-v2019.12">
          <soapenv:Header/>
          <soapenv:Body>
             <req:DATA>
                <req:PAN></req:PAN>
                <req:CONTRATO>'.$contrato.'</req:CONTRATO>
                <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
             </req:DATA>
          </soapenv:Body>
          </soapenv:Envelope>';
      }
      $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosTarjetaTC;
      $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosTarjetaTC, WS_Timeout, $Request, WS_ToXml, $username);

      $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosTarjetaTC);
      $eval = ws_EVAL_SOAP($Request);

      if($eval["retorno"]!=0){

        $data = '{
            "retorno": "'.$eval["retorno"].'",
            "descRetorno": "'.$eval["descRetorno"].'",
            "tarjetas": [ ] }';

        return ($data);
      }
      $xml = $eval["xmlDocument"];
      $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

      $data = '{
          "retorno": "'.$retorno.'",
          "descRetorno": "'.$descRetorno.'",
          "tarjetas": [';

      if($retorno==0) {

        if($flg_flujo=="002"){

          $datosAdicionales = json_decode(ws_GET_ConsultaDatosAdicionales($contrato, $nroTcv, $flg_flujo, $username));

        }



        foreach($xml->Body->DATA->children() as $state)
        {
            if((string)$state->codigoDeBloqueo!="") {

              $relacion = ((string)$state->relacion=="TI" ? "TITULAR" : "ADICIONAL");
              $nroRut = (string)$state->nroRut;
              if($flg_flujo=="001") {

                $dgvRut = substr($nroRut, -1);
                $nroRut = substr($nroRut, 0, -1);
                $nroRut = $nroRut."-".$dgvRut;

              } else {

                $result = digitoRUTCL($nroRut);
                $nroRut = $nroRut."-".$result["dgvRut"];
              }

              $client_name = ""; $sexoAdi = ""; $fechaNacimientoAdi = ""; $nombresAdi = ""; $apellidoPaternoAdi = ""; $apellidoMaternoAdi = ""; $descSexoAdi = ""; $descRelacion = ""; $relacionAdi = "";
              if($state->relacion=="TI") {

                $client_name = $CI->session->userdata("nombre_cliente")." ".$CI->session->userdata("apellido_cliente");

              } else {

                  if($flg_flujo=="001"){

                      $datosAdicionales = json_decode(ws_GET_ConsultaDatosAdicionales($contrato, (string)$state->pan, $flg_flujo, $username));

                      if($datosAdicionales->retorno==0) {
                          foreach ($datosAdicionales->adicionales as $nodo) {
                              $client_name = $nodo->nombresAdi." ".$nodo->apellidoPaternoAdi." ".$nodo->apellidoMaternoAdi;
                              $nombresAdi = $nodo->nombresAdi;
                              $apellidoPaternoAdi = $nodo->apellidoPaternoAdi;
                              $apellidoMaternoAdi = $nodo->apellidoMaternoAdi;
                              $sexoAdi = $nodo->sexoAdi;
                              $relacionAdi = $nodo->relacion;
                              $descSexoAdi = $nodo->descSexoAdi;
                              $descRelacion = $nodo->descRelacion;
                              $fechaNacimientoAdi = $nodo->fechaNacimientoAdi;
                          }
                      }

                  } else {

                    if($datosAdicionales->retorno==0) {

                      foreach ($datosAdicionales->adicionales as $nodo) {
                          if($nroRut==$nodo->nroRutAdi){
                              $client_name = $nodo->nombresAdi." ".$nodo->apellidoPaternoAdi." ".$nodo->apellidoMaternoAdi;
                              $nombresAdi = $nodo->nombresAdi;
                              $apellidoPaternoAdi = $nodo->apellidoPaternoAdi;
                              $apellidoMaternoAdi = $nodo->apellidoMaternoAdi;
                              $sexoAdi = $nodo->sexoAdi;
                              $relacionAdi = $nodo->relacion;
                              $descSexoAdi = $nodo->descSexoAdi;
                              $descRelacion = $nodo->descRelacion;
                              $fechaNacimientoAdi = $nodo->fechaNacimientoAdi;
                          }
                      }
                    }
                  }
              }

              $data .= '{
                  "codigoDeBloqueo": "'.(string)$state->codigoDeBloqueo.'",
                  "fechaActivacion": "'.(string)$state->fechaActivacion.'",
                  "fechaCreacion": "'.(string)$state->fechaCreacion.'",
                  "fechaDeBloqueo": "'.(string)$state->fechaDeBloqueo.'",
                  "fechaExpiracion": "'.(string)$state->fechaExpiracion.'",
                  "nroRut": "'.$nroRut.'",
                  "pan": "'.(string)$state->pan.'",
                  "relacion": "'.$relacion.'",
                  "descripcion": "'.(string)$state->descripcion.'",
                  "cliente": "'.$client_name.'",
                  "nroRutAdi": "'.$nroRut.'",
                  "sexoAdi": "'.$sexoAdi.'",
                  "fechaNacimientoAdi": "'.$fechaNacimientoAdi.'",
                  "nombresAdi": "'.$nombresAdi.'",
                  "apellidoPaternoAdi": "'.$apellidoPaternoAdi.'",
                  "apellidoMaternoAdi": "'.$apellidoMaternoAdi.'",
                  "descSexoAdi": "'.$descSexoAdi.'",
                  "relacionAdi": "'.$relacionAdi.'",
                  "descRelacion": "'.$descRelacion.'",
                  "desmarca": "'.(string)$state->desmarca.'" },';
            }
        }

      }
      $data .= '] }';
      $data = str_replace("},] }", "} ] }", $data);

      return($data);
}

function ws1_GET_ConsultaDatosTarjetaTC($nroTcv, $contrato, $flg_flujo, $username){

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosTarjetaTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:PAN>'.$nroTcv.'</req:PAN>
          <req:CONTRATO>'.$contrato.'</req:CONTRATO>
          <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosTarjetaTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosTarjetaTC, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosTarjetaTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return ($data);
    }
    $xml = $eval["xmlDocument"]; $arrDataTarjeta = array();
    $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno==0) {

      /* Rescata Datos de Adicionales */
      $arrDataADDI = ws_GET_ConsultaDatosAdicionales($contrato, $flg_flujo, $username, "array");

      foreach ($xml->Body->DATA as $recordPAN) {

          foreach ($recordPAN as $nodo) {

              if((int)$nodo->codigoDeBloqueo > 0){

                $datanew["codigoDeBloqueo"] = $nodo->codigoDeBloqueo;
                $datanew["fechaActivacion"] = substr($nodo->fechaActivacion,0,10);
                $datanew["fechaCreacion"] = substr($nodo->fechaCreacion,0,10);
                $datanew["fechaDeBloqueo"] = substr($nodo->fechaDeBloqueo,0,10);
                $datanew["fechaExpiracion"] = substr($nodo->fechaExpiracion,0,10);

                $pan = $nodo->pan;
/*
                if($pan==$nroTcv){
                    $descripcionTarjeta = ((string)$nodo->descripcion=="TARJETA ACTIVA" ? "TARJETA" : $nodo->descripcion);
                    $descripcionMarca = $nodo->desmarca;
                }
*/
                $pan = substr($pan,0,4).'-'.substr($pan,4,4).'-'.substr($pan,8,4).'-'.substr($pan,12,4);
                $datanew["pan"] = $pan;
                $datanew["relacion"] = ((string)$nodo->relacion=="TI" ? "TITULAR" : "ADICIONAL");

                $nombreAdicional = "";
                if((string)$nodo->relacion!="TI"){

                    foreach($arrDataADDI as $record) {

                        if($record["nroRut"]==$nodo->nroRut) {

                           $nombreAdicional = $record["nombresAdi"]." ".$record["apellidoPaternoAdi"]." ".$record["apellidoMaternoAdi"];

                        }
                    }
                }
                $datanew["nombreAdicional"] = $nombreAdicional;

                $arrDataTarjeta[] = $datanew;
              }
          }
      }

    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["dataTarjeta"] = $arrDataTarjeta;
    $data = $value;

    return ($data);

}

function ws_GET_DatosProductoTC($nroRut, $nroTcv, $flg_flujo, $username) {

    $data = array(); $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
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
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno==0){
        foreach ($xml->Body->DATA as $record) {
            foreach ($record as $nodo) {
                if(strlen($nodo->producto) > 0){
                    $datanew["producto"] = $nodo->producto;
                    $datanew["fechaContratacion"] = $nodo->fechaContratacion;
                    $datanew["montoContratado"] = $nodo->montoContratado;
                    $datanew["cuotasContratadas"] = $nodo->cuotasContratadas;
                    $datanew["cuotasFacturadas"] = $nodo->cuotasFacturadas;
                    $data[] = $datanew;
                }
            }
        }
    }

    return ($data);
}


function ws_GET_ConsultaDatosCuenta($nroRut, $flg_flujo, $username){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $data = array(); $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaDatosCuenta]";

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
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosCuenta, WS_Timeout20, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosCuenta);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if ($retorno==0){
        if((int)$xml->Body->DATA->Registro->suscripcionEeccXMail==1){
            $tipoDespacho = "EMAIL";
            $glosaDespacho = "Su correo electr&#243;nico de envío de su estado de cuenta es ";
        }else{
            $tipoDespacho = "F&#205;SICO";
            $glosaDespacho = "Su direcci&#243;n de envío de su estado de cuenta es ";
        }
        $data = array('retorno' => $retorno,
            'descRetorno' => (string)$xml->Body->DATA->descRetorno,
            'contrato' => (string)$xml->Body->DATA->Registro->contrato,
            'fechaCreacion' => (string)$xml->Body->DATA->Registro->fechaCreacion,
            'fechaActivacion' => (string)$xml->Body->DATA->Registro->fechaActivacion,
            'suscripcionEeccXMail' => (string)$xml->Body->DATA->Registro->suscripcionEeccXMail,
            'tipoDespacho' => $tipoDespacho,
            'glosaDespacho' => $glosaDespacho
            );

    } else {

        $data = array('retorno' => $retorno,
            'descRetorno' => $xml->Body->DATA->descRetorno."</br>".$serviceName);
    }

    return ($data);
}

function ws_GET_ConsultaDatosClienteTC($nroRut, $flg_flujo, $username){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosClienteTC/Req-v2019.12">
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

      return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["xmlDocument"] = $xml;
    $data = $value;

    return ($data);
}

function ws_GET_ConsultaDatosEECCTC($fieldRequest){

    $CI = get_instance();

    if($fieldRequest["flg_flujo"]=="001"){

        $nroRut = $fieldRequest["nroRut"];

    }else{
        $nroRut = str_replace('.', '', $fieldRequest["nroRut"]);
        $nroRut = str_replace('-', '', $nroRut);
        $nroRut = substr($nroRut, 0, -1);
    }

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaDatosEECCTC]";
    $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosEECCTC/Req-v2019.12">
    <soapenv:Header/>
    <soapenv:Body>
       <req:DATA>
          <req:rut>'.$nroRut.'</req:rut>
          <req:contrato>'.$fieldRequest["contrato"].'</req:contrato>
          <req:fechaVencimiento>'.$fieldRequest["fechaVencimiento"].'</req:fechaVencimiento>
          <req:estadoEecc>'.$fieldRequest["estadoEecc"].'</req:estadoEecc>
          <req:pan>'.$fieldRequest["pan"].'</req:pan>
          <req:FLAG_FLUJO>'.$fieldRequest["flg_flujo"].'</req:FLAG_FLUJO>
       </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosEECCTC;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosEECCTC, WS_Timeout40, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosEECCTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $fechaVencimiento = ""; $fechaProximoVencimiento= ""; $pagoDelMes = ""; $pagoMinimo = ""; $estadoEECC = "";
    if($retorno==0){
        foreach ($xml->Body->DATA as $recordEECC) {
            foreach ($recordEECC as $nodo) {
                if(strlen($nodo->fechaDeCorte)>1){
                    if($nodo->estadoEECC=="A"){
                        if($nodo->fechaVencimiento != NULL){
                            $fechaVencimiento = substr($nodo->fechaVencimiento,8,2).'-'.substr($nodo->fechaVencimiento,5,2).'-'.substr($nodo->fechaVencimiento,0,4);

                        if($nodo->fechaProximoVencimiento != NULL){
                            $fechaProximoVencimiento = substr($nodo->fechaProximoVencimiento,8,2).'-'.substr($nodo->fechaProximoVencimiento,5,2).'-'.substr($nodo->fechaProximoVencimiento,0,4);
                        }
                        $pagoDelMes = (string)$nodo->pagoDelMes;
                        $pagoMinimo = (string)$nodo->pagoMinimo;
                        $estadoEECC = $nodo->estadoEECC;

                        }
                    }
                }
            }
        }
    }

    $data["xmlDocument"] = $eval["xmlDocument"];
    $data["fechaVencimiento"] = $fechaVencimiento;
    $data["estadoEECC"] = $estadoEECC;
    $data["fechaProximoVencimiento"] = $fechaProximoVencimiento;
    $data["pagoDelMes"] = $pagoDelMes;
    $data["pagoMinimo"] = $pagoMinimo;
    $data["retorno"] = $retorno;
    $data["descRetorno"] = $descRetorno;

    return ($data);
}

function ws_GET_ConsultaDatosAdicionales($contrato, $nroTcv, $flg_flujo, $username){

    $retorno = COD_ERROR_INIT; $serviceName = "<br>[Servicio->ConsultaDatosAdicionales]"; $dataResponse = array();

    if($flg_flujo=="001") {

        $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosAdicionales/Req-v2019.12">
        <soapenv:Header/>
        <soapenv:Body>
           <req:DATA>
              <req:CONTRATO></req:CONTRATO>
              <req:PAN>'.$nroTcv.'</req:PAN>
              <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
           </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

    } else {

        $Request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/ConsultaDatosAdicionales/Req-v2019.12">
        <soapenv:Header/>
        <soapenv:Body>
           <req:DATA>
              <req:CONTRATO>'.$contrato.'</req:CONTRATO>
              <req:PAN>'.$nroTcv.'</req:PAN>
              <req:FLAG_FLUJO>'.$flg_flujo.'</req:FLAG_FLUJO>
           </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';
    }

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosAdicionales;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosAdicionales, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "Registro", "serviceName" => WS_ConsultaDatosAdicionales);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data = '{
            "retorno": "'.$eval["retorno"].'",
            "descRetorno": "'.$eval["descRetorno"].'",
            "numeroAdicionales": "0"}';
        return ($data);

    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $data = '{
        "retorno": "'.$retorno.'",
        "descRetorno": "'.$descRetorno.'",
        "adicionales": [';

    $numAdicionales = 0;
    if($retorno==0){

        foreach ($xml->Body->DATA->Registro as $nodo) {

            $nroRut = (string)$nodo->nroRutAdi;
            $result = digitoRUTCL($nodo->nroRutAdi);
            $nroRut = $nroRut."-".$result["dgvRut"];

            switch (substr($nodo->sexoAdi,0,1)) {
                case "F": $descSexoAdi = "FEMENINO";
                    break;
                case "M": $descSexoAdi = "MASCULINO";
                    break;
                default: $descSexoAdi = "NO INFORMADO";
                    break;
            }

            switch ($nodo->relacion) {
                case "CO": $descRelacion = "CONYUGE";
                    break;
                case "HE": $descRelacion = "HERMANO(A)";
                    break;
                case "HI": $descRelacion = "HIJO(A)";
                    break;
                case "OT": $descRelacion = "OTRO";
                    break;
                default: $descRelacion = "NO INFORMADO";
                    break;
            }

            $data.= '{
                "nroRutAdi": "'.$nroRut.'",
                "sexoAdi": "'.ltrim(rtrim($nodo->sexoAdi)).'",
                "fechaNacimientoAdi": "'.substr($nodo->fechaNacimientoAdi,0,10).'",
                "nombresAdi": "'.(string)$nodo->nombresAdi.'",
                "apellidoPaternoAdi": "'.(string)$nodo->apellidoPaternoAdi.'",
                "apellidoMaternoAdi": "'.(string)$nodo->apellidoMaternoAdi.'",
                "relacion": "'.(string)$nodo->relacion.'",
                "descSexoAdi": "'.$descSexoAdi.'",
                "descRelacion": "'.$descRelacion.'"},';

            $numAdicionales = $numAdicionales + 1;
        }

    }
    $data.= ']}';
    $data = str_replace("},]}", "} ],", $data);
    $data.= '"numeroAdicionales": "'.$numAdicionales.'"}';

    return ($data);
}

function ws_GET_DatosContactos($nroRut, $contrato, $flg_flujo, $username) {

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $value["emailWork"] = ""; $value["emailHome"] = ""; $value["phoneMobile"] = ""; $value["phoneWork"] = "";

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

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosContactoTC);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

      $data["retorno"] = $eval["retorno"];
      $data["descRetorno"] = $eval["descRetorno"];

      return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno!=0) {

        $value["retorno"] = $retorno;
        $value["descRetorno"] = $descRetorno;
        $data = $value;

        return ($data);
    }
    $arrDataTelefonos = array(); $arrDataEmails = array(); $arrDireccionHome = array(); $arrDireccionWork = array();

    foreach ($xml->Body->DATA as $recordDIR) {

        foreach ($recordDIR as $nodo) {

            if(strlen($nodo->puntoContacto)>3){

                $tipoFono = (string)$nodo->tipoFono;
                $usoFono = (string)$nodo->uso;

                if($flg_flujo=="001"){

                    if($nodo->tipo=="MOVIL" AND $nodo->vigencia=="S"){

                        if($tipoFono=="1"){
                            $value["phoneMobile"] = $nodo->puntoContacto;
                        }else{
                            $value["phoneWork"] = $nodo->puntoContacto;
                        }
                    }

                    if($nodo->tipo=="E-MAIL" AND $nodo->vigencia=="S"){

                        if($tipoFono=="2" AND $usoFono=="EM"){
                            $value["emailHome"] = $nodo->puntoContacto;
                        }else{

                            $value["emailWork"] = $nodo->puntoContacto;
                        }

                    }

                }else{

                    if($nodo->tipo=="EMA" AND $nodo->vigencia=="S"){

                        if($tipoFono=="HOME" AND $usoFono=="ASS"){
                            $value["emailWork"] = $nodo->puntoContacto;
                        }
                        if($tipoFono=="HOME" AND $usoFono=="HOM"){
                            $value["emailHome"] = $nodo->puntoContacto;
                        }
                    }

                    if($nodo->tipo=="FON" AND $nodo->vigencia=="S"){

                        if(substr($tipoFono,0,6) == "MOBILE") {
                            $value["phoneMobile"] = $nodo->puntoContacto;
                        }else{
                            $value["phoneWork"] = $nodo->puntoContacto;
                        }

                    }

                    if($nodo->tipo=="EMA"){
                        $datanew["puntoContacto"] = $nodo->puntoContacto;
                        $datanew["tipoFono"] = (string)$nodo->tipoFono;
                        $datanew["uso"] = (string)$nodo->uso;

                        $descTipoFono = $tipoFono."/".$usoFono;
                        if($tipoFono=="HOME" AND $usoFono=="ASS"){
                            $descTipoFono = "LABORAL";
                        }
                        if($tipoFono=="HOME" AND $usoFono=="HOM"){
                            $descTipoFono = "PARTICULAR";
                        }
                        $datanew["descTipoFono"] = $descTipoFono;

                        if($nodo->vigencia=="S"){$datanew["vigencia"] = "VIGENTE";}
                        else{$datanew["vigencia"] = "NO VIGENTE";}
                        $arrDataEmails[] = $datanew;
                    }
                    if($nodo->tipo=="FON"){
                        $datanew["puntoContacto"] = $nodo->puntoContacto;

                        if(substr($tipoFono,0,6) == "MOBILE") {
                            $descTipoFono = "MOVIL";
                        }else{
                            $descTipoFono = "FIJO";
                        }
                        $datanew["descTipoFono"] = $descTipoFono;

                        $descUso = "";
                        if($usoFono == "CLB" AND $tipoFono == "MOBILE") { $descUso = "CLUB"; }
                        if($usoFono == "CMC" AND substr($tipoFono,0,6) == "MOBILE") { $descUso = "CMC"; }
                        if($usoFono == "COB" AND $tipoFono == "HOME") { $descUso = "COBRANZA"; }
                        if($usoFono == "COB" AND $tipoFono == "OFFICE") { $descUso = "COBRANZA"; }
                        if($usoFono == "COB" AND substr($tipoFono,0,8) == "ASSISTAN") { $descUso = "COBRANZA"; }
                        if($usoFono == "COB" AND substr($tipoFono,0,6) == "MOBILE") { $descUso = "COBRANZA"; }
                        if($usoFono == "BUS" AND $tipoFono == "OFFICE") { $descUso = "LABORAL"; }
                        if($usoFono == "PER" AND $tipoFono == "HOME") { $descUso = "PARTICULAR"; }
                        if($usoFono == "HOM" AND $tipoFono == "HOME") { $descUso = "PARTICULAR"; }
                        if($usoFono == "PER" AND $tipoFono == "OFFICE") { $descUso = "PARTICULAR"; }
                        if($usoFono == "HOM" AND $tipoFono == "OFFICE") { $descUso = "PARTICULAR"; }
                        if($usoFono == "PER" AND substr($tipoFono,0,8) == "ASSISTAN") { $descUso = "PARTICULAR"; }
                        if($usoFono == "PER" AND substr($tipoFono,0,6) == "MOBILE") { $descUso = "PARTICULAR"; }
                        if($usoFono == "HOM" AND substr($tipoFono,0,6) == "MOBILE") { $descUso = "PARTICULAR"; }
                        if($usoFono == "ASS" AND substr($tipoFono,0,8) == "ASSISTAN") { $descUso = "RECADO"; }
                        if($usoFono == "ASS" AND $tipoFono == "OFFICE") { $descUso = "RECADO"; }

                        $datanew["descUso"] = $descUso;
                        $datanew["tipo"] = $nodo->tipo;
                        $datanew["uso"] = $nodo->uso;
                        $datanew["tipoFono"] = $nodo->tipoFono;
                        if($nodo->vigencia=="S"){$datanew["vigencia"] = "VIGENTE";}
                        else{$datanew["vigencia"] = "NO VIGENTE";}
                        $arrDataTelefonos[] = $datanew;
                    }

                }

            }
        }
    }

    $value["arrTelefonos"] = $arrDataTelefonos;
    $value["arrEmails"] = $arrDataEmails;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $data = $value;

    return($data);

}

function ws_GET_ConsultaDatosDireccion($nroRut, $contrato, $flg_flujo, $username){

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
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

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaDatosDireccion;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaDatosDireccion, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaDatosDireccion);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $data = '{
            "retorno": "'.$eval["retorno"].'",
            "descRetorno": "'.$eval["descRetorno"].'"}';
        return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    $calleHome = ""; $numeroCalleHome = ""; $blockHome = ""; $deptoHome = ""; $poblacionHome = ""; $comunaHome = ""; $ciudadHome = ""; $regionHome = "";
    $calleWork = ""; $numeroCalleWork = ""; $blockWork = ""; $deptoWork = ""; $poblacionWork = ""; $comunaWork = ""; $ciudadWork = ""; $regionWork = "";

    $data = '{
          "retorno": "'.$retorno.'",
          "descRetorno": "'.$descRetorno.'",
          "direcciones": [ ';

    if($retorno==0){

        foreach ($xml->Body->DATA as $recordDIR) {
            foreach ($recordDIR as $nodo) {

              if($nodo->calle!="") {

                $tipoDireccion = ""; $descTipoDireccion = "";
                if($nodo->vigencia=="S"){ $vigencia = "VIGENTE"; } else { $vigencia = "NO VIGENTE"; }

                if($nodo->tipoDireccion=="HOME") { $descTipoDireccion = "PARTICULAR"; $tipoDireccion = "HOME"; }
                if($nodo->tipoDireccion=="DH") { $descTipoDireccion = "PARTICULAR"; $tipoDireccion = "HOME"; }
                if($nodo->tipoDireccion=="WORKS_AT" ) { $descTipoDireccion = "LABORAL"; $tipoDireccion = "WORK"; }

                $data .= '{
                    "calle": "'.(string)$nodo->calle.'",
                    "block": "'.(string)$nodo->block.'",
                    "ciudad": "'.(string)$nodo->ciudad.'",
                    "codCiudad": "'.(string)$nodo->codCiudad.'",
                    "comuna": "'.(string)$nodo->comuna.'",
                    "codComuna": "'.(string)$nodo->codComuna.'",
                    "numeroCalle": "'.(string)$nodo->numeroCalle.'",
                    "depto": "'.(string)$nodo->depto.'",
                    "poblacion": "'.(string)$nodo->poblacion.'",
                    "pais": "'.(string)$nodo->pais.'",
                    "region": "'.(string)$nodo->region.'",
                    "codRegion": "'.(string)$nodo->codRegion.'",
                    "tipoDireccion": "'.$tipoDireccion.'",
                    "descTipoDireccion": "'.$descTipoDireccion.'",
                    "vigencia": "'.$vigencia.'"},';
/*
                if($tipoDireccion=="HOME"){
                    $calleHome  = (string)$nodo->calle;
                    $numeroCalleHome = (string)$nodo->numeroCalle;
                    $blockHome = (string)$nodo->block;
                    $deptoHome = (string)$nodo->depto;
                    $poblacionHome = (string)$nodo->poblacion;
                    $comunaHome = (string)$nodo->comuna;
                    $ciudadHome = (string)$nodo->ciudad;
                    $regionHome = (string)$nodo->region;
                }
                if($tipoDireccion=="WORK"){
                    $calleWork = (string)$nodo->calle;
                    $numeroCalleWork = (string)$nodo->numeroCalle;
                    $blockWork = (string)$nodo->block;
                    $deptoWork = (string)$nodo->depto;
                    $poblacionWork = (string)$nodo->poblacion;
                    $comunaWork = (string)$nodo->comuna;
                    $ciudadWork = (string)$nodo->ciudad;
                    $regionWork = (string)$nodo->region;
                }
*/
              }


            }
         }
    }

    $data .= ']}';
    $data = str_replace("},]}", "} ] }", $data);

/*

    $data["direccionWork"] = $direccionWork;
    $data["direccionHome"] = $direccionHome;

    $arrDireccionHome = array(
        "calle" => $calleHome,
        "numeroCalle" => $numeroCalleHome,
        "block" => $blockHome,
        "depto" => $deptoHome,
        "poblacion" => $poblacionHome,
        "comuna" => $comunaHome,
        "ciudad" => $ciudadHome,
        "region" => $regionHome);

    $arrDireccionWork = array(
        "calle" => $calleWork,
        "numeroCalle" => $numeroCalleWork,
        "block" => $blockWork,
        "depto" => $deptoWork,
        "poblacion" => $poblacionWork,
        "comuna" => $comunaWork,
        "ciudad" => $ciudadWork,
        "region" => $regionWork);

    $data["arrDireccionHome"] = $arrDireccionHome;
    $data["arrDireccionWork"] = $arrDireccionWork;
*/
    return($data);
}



function ws_GET_ConsultaRenes30Dias($nroRut, $username) {

    $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
    $retorno=COD_ERROR_INIT; $tagName = "cabeceraSalida";
    $serviceName = "<br>[ConsultaRenes30Dias]";

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
      <req:DATA>
         <req:rutSinDv>'.$nroRut.'</req:rutSinDv>
      </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaRenes30Dias;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaRenes30Dias, WS_Timeout, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "cabeceraSalida", "serviceName" => WS_ConsultaRenes30Dias);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        return ($value);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->response->cabeceraSalida->retorno;

    if($retorno!=0) {

        $value['retorno'] = $retorno;
        $value['descRetorno'] = $descRetorno;
        $data = $value;
        return ($data);
    }

    $existe = (string)$xml->Body->DATA->response->existe;

    $value["retorno"] = $retorno;
    $value["descRetorno"] = "Transacción Aceptada";
    $value["existe"] = $existe;

    $data = $value;
    return ($data);
}


function ws_GET_HomologadorByRut($nroRut, $username) {

    $CI = get_instance();

    $nroRut = str_replace('.', '', $nroRut); 
    $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);

    $result = $CI->journal->getall_products();
    if(!$result){

      $data["retorno"] = 401;
      $data["descRetorno"] = "Error de configuracion, revisar datos archivo ta_journal_products..";
      return ($data);
    }

    $serviceName = "</br>[Servicio->HomologadorByRut]"; $continue = true;

    foreach ($result as $nodo) {

        if ($continue) {

            $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sol="http://www.solventa.cl">
               <soapenv:Header/>
               <soapenv:Body>
                <sol:busquedaPorRutComercioProducto>
                     <rutCliente>'.$nroRut.'</rutCliente>
                     <clienteComercio>'.$nodo->id_commerce.'</clienteComercio>
                     <codProducto>'.$nodo->id_product.'</codProducto>
                </sol:busquedaPorRutComercioProducto>
               </soapenv:Body>
            </soapenv:Envelope>';

            $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_Homologador_BusquedaPorRutComercio;
            $soap = get_SOAP($EndPoint, WS_Action_Homologador, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

            $Request = array( "soap" => $soap, "tagName" => "busquedaPorRutComercioProductoResponse", "serviceName" => WS_Homologador_BusquedaPorRutComercio);
            $eval = ws_EVAL_SOAP($Request);

            if($eval["retorno"]!=0){

              $data["retorno"] = $eval["retorno"];
              $data["descRetorno"] = $eval["descRetorno"];
              return ($data);
            }
            $xml = $eval["xmlDocument"];

            $retorno = (int)$xml->Body->busquedaPorRutComercioProductoResponse->return->codigo_respuesta;
            if($retorno!=0) {

                if($retorno==$nodo->return_not_exist){
                    $descRetorno  = "<strong>Rut Consultado no es cliente Cruz Verde..</strong>";
                } else {
                    $descRetorno  = $eval["descRetorno"].$serviceName;
                }

            }else{

                $descRetorno  = "Transacción Aceptada";
                $flg_tecnocom = (string)$xml->Body->busquedaPorRutComercioProductoResponse->return->flg_tecnocom;
                $cod_producto = (string)$xml->Body->busquedaPorRutComercioProductoResponse->return->cod_producto;

                if($flg_tecnocom=="S"){

                        $flg_flujo="001";
                        $origen="TECNOCOM";
                        $nroTcv=(string)$xml->Body->busquedaPorRutComercioProductoResponse->return->pan_tecnocom;
                        $flg_cvencida = (string)$xml->Body->busquedaPorRutComercioProductoResponse->return->flg_cvencida;
                }
                if($flg_tecnocom=="N"){

                        $flg_flujo="002";
                        $origen="VISSAT";
                        $nroTcv=(string)$xml->Body->busquedaPorRutComercioProductoResponse->return->pan_solventa;
                        $flg_cvencida = "N";
                }

                $continue = false;

            }

            $id_commerce  = $nodo->id_commerce;
            $id_product = $nodo->id_product;
            $name_product = $nodo->name_product;
            $brand_product = $nodo->brand_product;
            $short_name_product = $nodo->short_name_product;

        }

    }


    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    if($retorno!=0){

        $data = $value;
        return ($data);
    }

    $value["flg_flujo"] = $flg_flujo;
    $value["nroTcv"] = $nroTcv;
    $value["origen"] = $origen;
    $value["flg_cvencida"] = $flg_cvencida;
    $value["flg_tecnocom"] = $flg_tecnocom;
    $value["id_product"] = $id_product;
    $value["id_commerce"] = $id_commerce;
    $value["name_product"] = $name_product;
    $value["brand_product"] = $brand_product;
    $value["short_name_product"] = $brand_product;

    $data = $value;
    return ($data);
}

function ws_PUT_ReprintCapturing($capta, $data){

    $Request = '<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
         <req:centro>'.$data["centro"].'</req:centro>
         <req:feccadtar>'.$data["feccadtar"].'</req:feccadtar>
         <req:indaccion>'.$data["indaccion"].'</req:indaccion>
         <req:indesttarol>'.$data["indesttarol"].'</req:indesttarol>
         <req:pan>'.$capta->nrotcv.'</req:pan>
         <req:panant></req:panant>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_Reprint_Credit_Card;
    $soap = get_SOAP($EndPoint, WS_Action_Reprint_Credit_Card, 360, $Request, WS_ToXml, $data["username"]);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_Reprint_Credit_Card);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        return ($value);
    }
    $xml = $eval["xmlDocument"]; 
    $value["retorno"] = (int)$xml->Body->DATA->retorno; 
    $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    if($value["retorno"]==0) {

        $value["retorno1"] = (int)$xml->Body->DATA->response->mensBajaFCV->codigo;
        $value["descRetorno1"] = (string)$xml->Body->DATA->response->mensBajaFCV->mensaje;

        $value["retorno2"] = 0;
        $value["descRetorno2"] = (string)$xml->Body->DATA->response->dessittar;

        $value["retorno3"] = (int)$xml->Body->DATA->response->estadoEmbozado->codigo_status;
        $value["descRetorno3"] = (string)$xml->Body->DATA->response->estadoEmbozado->status;

        $value["pantar"] = (string)$xml->Body->DATA->response->pan;

    }

    $data = $value;
    return ($data);
}


function ws_PUT_LockCreditCard($capta, $data, $username){

    $Request = '<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
         <req:centro>1000</req:centro>
         <req:feccadtar>0</req:feccadtar>
         <req:indaccion>0</req:indaccion>
         <req:indesttarol>S</req:indesttarol>
         <req:pan>'.$capta->nrotcv.'</req:pan>
         <req:panant></req:panant>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_Reprint_Credit_Card;
    $soap = get_SOAP($EndPoint, WS_Action_Reprint_Credit_Card, 120, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "retorno", "serviceName" => WS_Reprint_Credit_Card);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        return ($value);
    }
    $xml = $eval["xmlDocument"]; $value["retorno"] = (int)$xml->Body->DATA->retorno; $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    if($value["retorno"]==0) {

        $value["retorno1"] = (int)$xml->Body->DATA->response->mensBajaFCV->respuesta->codigo;
        $value["descRetorno1"] = (int)$xml->Body->DATA->response->mensBajaFCV->respuesta->mensaje;

        $value["retorno2"] = 0;
        $value["descRetorno2"] = (int)$xml->Body->DATA->dessittar;

        $value["retorno3"] = (int)$xml->Body->DATA->estadoEmbozado->status;
        $value["descRetorno3"] = (int)$xml->Body->DATA->estadoEmbozado->codigo_status;

    }

    $data = $value;
    return ($data);
}

function ws_PUT_CapturingById($capta, $data, $username) {

    $fecha = str_replace("-","",$capta->fecha);
    $fecha = substr($fecha, 6,2).substr($fecha,4,2).substr($fecha, 0,4);

    $Request = '<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
         <req:autorizador>'.$capta->autorizador.'</req:autorizador>
         <req:calparttar>'.$capta->calparttar.'</req:calparttar>
         <req:centalta>'.$capta->centalta.'</req:centalta>
         <req:clamon1>'.$capta->clamon1.'</req:clamon1>
         <req:codaptcor>'.$capta->codaptco.'</req:codaptcor>
         <req:codpaisdir>'.$capta->codpaisdir.'</req:codpaisdir>
         <req:codpaisnac>'.$capta->codpaisnac.'</req:codpaisnac>
         <req:codpaisnct>'.$capta->codpaisnct.'</req:codpaisnct>
         <req:codpaisres>'.$capta->codpaisres.'</req:codpaisres>
         <req:codpostal>'.$capta->codpostal.'</req:codpostal>
         <req:codprov>'.$capta->codprov.'</req:codprov>
         <req:codregimen>'.$capta->codregimen.'</req:codregimen>
         <req:desclave1>'.$capta->desclave1.'</req:desclave1>
         <req:desclave2>'.$capta->desclave2.'</req:desclave2>
         <req:desclave3>'.$capta->desclave3.'</req:desclave3>
         <req:desclave4>'.$capta->desclave4.'</req:desclave4>
         <req:desclave5>'.$capta->desclave5.'</req:desclave5>
         <req:desclave6>'.$capta->desclave6.'</req:desclave6>
         <req:digitov>'.$capta->digitov.'</req:digitov>
         <req:edificio>'.$capta->edificio.'</req:edificio>
         <req:eeccemail>'.$capta->eeccemail.'</req:eeccemail>
         <req:escalera>'.$capta->escalera.'</req:escalera>
         <req:fecha>'.$fecha.'</req:fecha>
         <req:fechanac>'.$capta->fechanac.'</req:fechanac>
         <req:forpago>03</req:forpago>
         <req:grupocuo>'.$capta->grupocuo.'</req:grupocuo>
         <req:grupoliq>'.$capta->grupocuo.'</req:grupoliq>
         <req:hora>'.$capta->hora.'</req:hora>
         <req:hordespliegue>'.$capta->hordespliegue.'</req:hordespliegue>
         <req:indenvcor>'.$capta->indenvcor.'</req:indenvcor>
         <req:indestciv>'.$capta->indestciv.'</req:indestciv>
         <req:indexecuo>'.$capta->indexecuo.'</req:indexecuo>
         <req:indsegdes>'.$capta->indsegdes.'</req:indsegdes>
         <req:inssaludprev>01</req:inssaludprev>
         <req:local>'.$capta->local.'</req:local>
         <req:modtransac>1</req:modtransac>
         <req:nombrevend>'.$capta->nombrevend.'</req:nombrevend>
         <req:nomqf>'.$data['nomqf'].'</req:nomqf>
         <req:nomvia>'.$capta->nomvia.'</req:nomvia>
         <req:nrocampagna>'.$capta->nrocampagna.'</req:nrocampagna>
         <req:numcontrato>'.$capta->numcontrato.'</req:numcontrato>
         <req:numvia>'.$capta->numvia.'</req:numvia>
         <req:observacion>'.$capta->observacion.'</req:observacion>
         <req:opcion>'.$capta->opcion.'</req:opcion>
         <req:piso></req:piso>
         <req:poblacion>'.$capta->poblacion.'</req:poblacion>
         <req:puerta></req:puerta>
         <req:restodir>'.$capta->restodir.'</req:restodir>
         <req:rut>'.$capta->rut.'</req:rut>
         <req:rutqf>'.str_replace("-","",$data['rutqf']).'</req:rutqf>
         <req:rutvend>'.str_replace("-","",$capta->rutvend).'</req:rutvend>
         <req:serienumdocci>'.$capta->serienumdocci.'</req:serienumdocci>
         <req:sexo>'.$capta->sexo.'</req:sexo>
         <req:solicitud>'.$capta->solicitud.'</req:solicitud>
         <req:subtipcli>'.$capta->subtipcli.'</req:subtipcli>
         <req:tipclien>'.$capta->tipclien.'</req:tipclien>
         <req:tipdoc>'.$capta->tipdoc.'</req:tipdoc>
         <req:tiplocal>'.$capta->tiplocal.'</req:tiplocal>
         <req:tipmedio1>'.$capta->tipmedio1.'</req:tipmedio1>
         <req:tipmedio2>'.$capta->tipmedio2.'</req:tipmedio2>
         <req:tipmedio3>'.$capta->tipmedio3.'</req:tipmedio3>
         <req:tipmedio4>'.$capta->tipmedio4.'</req:tipmedio4>
         <req:tipmedio5>'.$capta->tipmedio5.'</req:tipmedio5>
         <req:tipmedio6>'.$capta->tipmedio6.'</req:tipmedio6>
         <req:tipvia>'.$capta->tipvia.'</req:tipvia>
         <req:vbqf>SI</req:vbqf>
         <req:codproducto>'.$capta->cod_producto.'</req:codproducto>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_GrabaPreAprobados;
    $soap = get_SOAP($EndPoint, WS_Action_GrabaPreAprobados, 360, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_GrabaPreAprobados);
    $eval = ws_EVAL_SOAP($Request);
    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];

        $data = $value;
        return ($data);
    }

    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->descRetorno;

    if($value["retorno"]==0){

        $value["cuenta"] = (string)$xml->Body->DATA->response->cuenta;
        $value["pantar"] = (string)$xml->Body->DATA->response->pantar;
        $value["nombre"] = (string)$xml->Body->DATA->response->nombre;
        $value["apaterno"] = (string)$xml->Body->DATA->response->apaterno;
        $value["amaterno"] = (string)$xml->Body->DATA->response->amaterno;
        $value["rut"] = (string)$xml->Body->DATA->response->rut;
        $value["digitov"] = (string)$xml->Body->DATA->response->digitov;
        $value["autorizador"] = (string)$xml->Body->DATA->response->autorizador;
    }

    $data = $value;
    return ($data);
}

function ws_PUT_BlockingCreditCard($fieldRequest) {

    $tagName = "descRetorno";
    $Request = '<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>
         <req:codblq>'.$fieldRequest["code_bloq_credit_card"].'</req:codblq>
         <req:pan>'.$fieldRequest["number_credit_card"].'</req:pan>
         <req:texblq></req:texblq>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_Blocking_Credit_Card;
    $soap = get_SOAP($EndPoint, WS_Action_Blocking_Credit_Card, WS_Timeout, $Request, WS_ToXml, $fieldRequest["username"]);

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_Blocking_Credit_Card);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        return ($value);
    }
    $xml = $eval["xmlDocument"];
    $value["retorno"] = (int)$xml->Body->DATA->response->cabeceraSalida->retorno; $value["descRetorno"] = (string)$xml->Body->DATA->response->cabeceraSalida->descRetorno;

    $data = $value;
    return ($data);
}


function put_logevent($soap, $status){
    $CI = get_instance();

    $data = array("date_begin"=>$soap["date_begin"],
                "date_end"=> $soap["date_end"],
                "time"=>$soap["time"],
                "username"=>$soap["username"],
                "endPoint"=>$soap["endPoint"],
                "action"=>$soap["action"],
                "request"=> $soap["request"],
                "response"=> $soap["response"],
                "result"=> $status
    );
    $CI->db->insert('ta_journal_log_event', $data);

}

function ws_GET_CapturingByRut($dataRequest) {

    $CI = get_instance();
    $numdoc = str_replace('.', '', $dataRequest["numdoc"]); $numdoc = str_replace('-', '', $numdoc);

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://www.solventa.cl/request">
    <soapenv:Header/>
    <soapenv:Body>
        <req:DATA>
        <req:numdoc>'.$numdoc.'</req:numdoc>
        <req:tipdoc>'.$dataRequest["tipdoc"].'</req:tipdoc>
        <req:cod_producto>'.$dataRequest["codProducto"].'</req:cod_producto>
        </req:DATA>
        </soapenv:Body>
        </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_ConsultaPreAprobadosPorRut;
    $soap = get_SOAP($EndPoint, WS_Action_ConsultaPreAprobadosPorRut, WS_Timeout, $Request, WS_ToXml, $CI->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "descRetorno", "serviceName" => WS_ConsultaPreAprobadosPorRut);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=0){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];

        $data = $value;
        return ($data);
    }
    $xml = $eval["xmlDocument"]; $retorno = (int)$xml->Body->DATA->retorno; $descRetorno = (string)$xml->Body->DATA->descRetorno;

    if($retorno!=0) {

        $value["retorno"] = $retorno;
        $value["descRetorno"] = $descRetorno;

        $data = $value;
        return ($data);
    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;
    $value["amaterno"] = (string)$xml->Body->DATA->response->amaterno;
    $value["apaterno"] = (string)$xml->Body->DATA->response->apaterno;
    $value["nombres"] = (string)$xml->Body->DATA->response->nombres;
    $value["codbaja"] = (int)$xml->Body->DATA->response->codbaja;
    $value["codent"] = (int)$xml->Body->DATA->response->codent;
    $value["codmar"] = (int)$xml->Body->DATA->response->codmar;
    $value["conprod"] = (int)$xml->Body->DATA->response->conprod;
    $value["cupo"] = "$".number_format((float)$xml->Body->DATA->response->cupo, 0, ",", ".");
    $value["descam"] = (string)$xml->Body->DATA->response->descam;
    $value["desconprod"] = (string)$xml->Body->DATA->response->desconprod;
    $value["desmarred"] = (string)$xml->Body->DATA->response->desmarred;
    $value["desprod"] = (string)$xml->Body->DATA->response->desprod;
    $value["destiptred"] = (string)$xml->Body->DATA->response->destiptred;
    $value["fecalta"] = (string)$xml->Body->DATA->response->fecalta;
    $value["fecbaja"] = (string)$xml->Body->DATA->response->fecbaja;
    $value["fechanac"] = (string)$xml->Body->DATA->response->fechanac;
    $value["indtipt"] = (int)$xml->Body->DATA->response->indtipt;
    $value["motbaja"] = (string)$xml->Body->DATA->response->motbaja;
    $value["numcam"] = (int)$xml->Body->DATA->response->numcam;
    $value["numdoc"] = (string)$xml->Body->DATA->response->numdoc;
    $value["pan"] = (string)$xml->Body->DATA->response->pan;
    $value["producto"] = (string)$xml->Body->DATA->response->producto;
    $value["score"] = (int)$xml->Body->DATA->response->score;
    $value["sexo"] = (string)$xml->Body->DATA->response->sexo;
    $value["subprodu"] = (string)$xml->Body->DATA->response->subprodu;
    $value["tipcam"] = (string)$xml->Body->DATA->response->tipcam;
    $value["tipdoc"] = (string)$xml->Body->DATA->response->tipdoc;
    $value["tiporeg"] = (int)$xml->Body->DATA->response->tiporeg;

    if($value["subprodu"]=="0003"){
        $value["tipopan"] = "COLABORADOR";
    } else {
        $value["tipopan"] = "NORMAL";
    }
    $value["cod_producto"] = $dataRequest["codProducto"];

    if($value["codbaja"]==1){
        $value["retorno"] = -1;
        $value["descRetorno"] = "Cliente no registra pre aprobación Tarjeta Cruz Verde";
    }

    $data = $value;
    return ($data);
}

function eval_response_SOAP($xmlString, $tagName, $serviceName) {

    $xmlString = str_replace("ns3:", "", $xmlString);
    $xmlString = str_replace("ns4:", "", $xmlString);
    $xmlString = str_replace("ns5:", "", $xmlString);
    $xmlString = str_replace("soapenv1:", "", $xmlString);
    $xmlString = str_replace("resp:", "", $xmlString);
    $xmlString = str_replace("<![CDATA[<respuesta>", "", $xmlString);
    $xmlString = str_replace("</respuesta>]]>", "", $xmlString);

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
        $value['descRetorno'] = MSG_RESPUESTA_CORE_INVALIDA."</br> Service: ".$serviceName;
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


function eval_response_core($xmlString, $tagName, $serviceName) {

    $xmlString = str_replace("ns3:", "", $xmlString);
    $xmlString = str_replace("ns4:", "", $xmlString);
    $xmlString = str_replace("ns5:", "", $xmlString);
    $xmlString = str_replace("soapenv1:", "", $xmlString);
    $xmlString = str_replace("resp:", "", $xmlString);
    $xmlString = str_replace("<![CDATA[<respuesta>", "", $xmlString);
    $xmlString = str_replace("</respuesta>]]>", "", $xmlString);

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
        $value['descRetorno'] = MSG_RESPUESTA_CORE_INVALIDA."</br> Service: ".$serviceName;
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

function sendEmail($bodyMessage, $titleMessage, $fileAdjuntos, $fileNameAdjuntos, $emailCuenta, $username) {

    $Request = '<soapenv:Envelope xmlns:req="http://www.solventa.cl/request" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Header/>
    <soapenv:Body>
    <req:DATA>';

    if($fileAdjuntos!=""){ $Request .= '<adjuntos>'.$fileAdjuntos.'</adjuntos>'; }

    $Request .= '<asunto>'.$titleMessage.'</asunto>
    <cuerpoHtml>'.$bodyMessage.'</cuerpoHtml>
    <from>webmail@solventa.cl</from>';

    if($fileNameAdjuntos!=""){ $Request .= '<nombre_adjuntos>'.$fileNameAdjuntos.'</nombre_adjuntos>'; }

    $Request .= '<password>wsemailpassword</password>
    <to>'.$emailCuenta.'</to>
    <usuario>wsemailuser</usuario>
    </req:DATA>
    </soapenv:Body>
    </soapenv:Envelope>';

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.WS_SendEmail;
    $soap = get_SOAP($EndPoint, WS_Action_SendEmail, WS_Timeout20, $Request, WS_ToXml, $username);

    $Request = array( "soap" => $soap, "tagName" => "errorCode", "serviceName" => WS_SendEmail);
    $eval = ws_EVAL_SOAP($Request);

    if($eval["retorno"]!=EXIT_SUCCESS){

        $value["retorno"] = $eval["retorno"];
        $value["descRetorno"] = $eval["descRetorno"];
        return ($value);
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->response->errorInfo->errorCode;
    $value["descRetorno"] = (string)$xml->Body->DATA->response->errorInfo->errorMsg;

    $data = $value;
    return ($data);
}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function get_SOAP($setEndPoint, $setAction, $setTimeOut, $soap, $setTypeReturn, $username)
{
    $CI = get_instance();

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

        if($s->toXML()==MSG_ERROR_HTTP_ERROR_URL){

            $value["codErrorSOAP"] = EXIT_ERROR;
            $value["msgErrorSOAP"] = MSG_ERROR_HTTP_ERROR_URL;

        } else {

            $value["codErrorSOAP"] = EXIT_SUCCESS;
            $value["msgErrorSOAP"] = "Transacción Aceptada";

            switch($setTypeReturn){
                case "XML": $value["xmlString"] = $s->toXML();
                    break;
                case "JSON": $value["xmlString"] = $s->toJSON();
                    break;
                case "ARRAY": $value["xmlString"] = $s->toARRAY();
                    break;
                default: $value["xmlString"] = $s->toXML();
                    break;
            }

        }

        $value["date_begin"] = $date_start;
        $value["date_end"] = $date_end;
        $value["time"] = $time;
        $value["username"] = $username;
        $value["endPoint"] = $setEndPoint;
        $value["action"] = $setAction;
        $value["request"] = $soap;
        $value["response"] = $s->toXML();

        $data = $value;
        return $data;


    } catch (Exception $e){

        $time_end = microtime_float();
        $time = $time_end - $time_start;
        $date_end = date("Y-m-d H:i:s");

        $value["date_begin"] = $date_start;
        $value["date_end"] = $date_end;
        $value["time"] = $time;
        $value["username"] = $username;
        $value["endPoint"] = $setEndPoint;
        $value["action"] = $setAction;
        $value["request"] = $soap;
        $value["response"] = $e->getMessage();

        $value["codErrorSOAP"] = EXIT_ERROR;
        $value["msgErrorSOAP"] = $e->getMessage();

        $data = $value;
        return $data;

    }


}
/*
 * End Function get_SOAP()
 */


function print_eventlog($data) {

$fp = fopen(SHOW_NAME_LOGFILE.date('Y-m-d').'.log', 'a');
$data = ">>>>>> " . $data ." <<<<<<<" . PHP_EOL;
fwrite($fp, $data);
fclose($fp);

}
