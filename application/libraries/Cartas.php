<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cartas 
{
   

    function soap_rechazo($num){
    		$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <consultaDatosCliente xmlns="http://www.solventa.cl">
      <nroRut>'.$num.'</nroRut>
      <flagFlujo>ABC</flagFlujo>
    </consultaDatosCliente>
  </soap12:Body>
</soap12:Envelope>';


                $soapUrl = "http://200.73.112.250/solventa.maximoerp.com/consultaclientesTC.asmx?WSDL"; // asmx URL of WSDL
                $headers = array(
                    "Content-Type: text/xml;charset=UTF-8",
                    "Accept-Encoding: gzip,deflate",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction:http://www.solventa.cl/consultaDatosCliente",
                    "Content-length: " . strlen($xml_post_string),
                );
   $url = $soapUrl;


                $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);               
                    curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    // converting

             
                    $response = curl_exec($ch);

                    curl_close($ch);

                    // convertingc to XML

                    $response = str_replace('env:', '', $response);
                    $response = str_replace('ns1:', '', $response);
                    $response = str_replace('ns0:', '', $response);

                    $xmlString = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
                    $xml = simplexml_load_string($xmlString)->asXML();

                    $xmlparse = new SimpleXMLElement($xml);

                    
                    return array("nombre"=>$xmlparse->soapBody->consultaDatosClienteResponse->consultaDatosClienteResult->SEnvelope->SBody->ns2consultaDatosClienteResponse->return->nombres,"apellidop"=>$xmlparse->soapBody->consultaDatosClienteResponse->consultaDatosClienteResult->SEnvelope->SBody->ns2consultaDatosClienteResponse->return->apellidopaterno,"apellidom"=>$xmlparse->soapBody->consultaDatosClienteResponse->consultaDatosClienteResult->SEnvelope->SBody->ns2consultaDatosClienteResponse->return->apellidomaterno);
    }
}