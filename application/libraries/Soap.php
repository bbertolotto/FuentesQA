<?php

define('SOAP_MSG_ERROR_NOENDPOINT', 'No se ha establecido el EndPoint');
define('SOAP_MSG_ERROR_NOREQUEST', 'No se ha establecido el Request');

/**
 * Permite consumir servicios soap, enviando un xml
 */
class SOAP {

    /**
     * URL del servicio
     * @var string
     */
    protected $endPoint;

    /**
     * Action del servicio
     * @var string
     */
    protected $action = '';

    /**
     * Request del servicio
     * @var string
     */
    protected $request;

    /**
     * Response del servicio
     * @var type
     */
    protected $response;

    /**
     * Usuario del servicio
     * @var string
     */
    protected $user;

    /**
     * Contraseña del servicio
     * @var string
     */
    protected $passwd;

    /**
     * TimeOut de Conexión
     * @var int
     */
    protected $connectTimeOut = 10;

    /**
     * TimeOut de ejecución
     * @var int
     */
    protected $timeOut = 30;

    /**
     * Ruta del certificado PEM
     * @var string
     */
    protected $certPem = null;

    /**
     * Contraseña del certificado PEM
     * @var string
     */
    protected $certPemPasswd = null;

    /**
     * Ruta del certificado que contiene la llave privada
     * @var string
     */
    protected $certKey = null;

     /**
     * Contraseña del certificado que contiene la llave privada
     * @var string
     */
    protected $certKeyPasswd = null;

    /**
     * Ruta del archivo CRT
     * @var string
     */
    protected $pathCA = null;

    /**
     * Constructor de la clase
     *
     * @param string $endPoint URL del webservice
     * @param string $request xml de la petición
     * @param string $user - Usuario, si requiere autenticación
     * @param string $passwd - Contraseña, si requiere autenticación
     * @param int $timeOut - Timeout en segundos
     * @param int $connectTimeOut - Timeout de conexión, es distinto al timeout de ejecución, este es solo estableciendo conexión
     * @param string $action Acción soap a ejecutar - opcional
     */
    public function __construct($endPoint = '', $request = '', $user = '', $passwd = '', $timeOut = 30, $connectTimeOut = 10, $action = '') {

        $this->endPoint = $endPoint;
        $this->request = $request;
        $this->action = $action;
        $this->user = $user;
        $this->passwd = $passwd;
        $this->timeOut = $timeOut;
        $this->connectTimeOut = $connectTimeOut;
    }

    /**
     * Hace el llamado al servicio soap
     */
    public function call() {

        if(!$this->getEndPoint()){
            throw new Exception(SOAP_MSG_ERROR_NOENDPOINT);
        }

        if(!$this->getRequest()){
            throw new Exception(SOAP_MSG_ERROR_NOREQUEST);
        }

        //cabeceras de la petición
        $header = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            // "SOAPAction: \"" . $this->getAction() . "\"",
            "Content-length: " . strlen($this->getRequest())
        );

        //Si se establece acción se envia en al cabeceras
        if($this->getAction()){
            $header[] = "SOAPAction: \"" . $this->getAction() . "\"";
        }

        //Configuración del cliente
        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, $this->getEndPoint());
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, $this->getConnectTimeOut());
        curl_setopt($soap_do, CURLOPT_TIMEOUT, $this->getTimeOut());
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $this->getRequest());
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);

        //Si necesita usuario y contraseña
        if ($this->getUser()) {
            curl_setopt($soap_do, CURLOPT_USERPWD, $this->getUser() . ":" . $this->getPasswd());
        }

        //CRT - CAInfo
        if($this->pathCA !== null){
            curl_setopt($soap_do, CURLOPT_CAINFO, $this->pathCA);
            curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        }else{
            curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        }

        //Certificados
        if($this->certPem !== null){
            curl_setopt($soap_do, CURLOPT_SSLCERT, $this->certPem);
        }

        if($this->certPemPasswd !== null){
            curl_setopt($soap_do, CURLOPT_SSLCERTPASSWD, $this->certPemPasswd);
        }

        if($this->certKey !== null){
            curl_setopt($soap_do, CURLOPT_SSLKEY, $this->certKey);
        }

        if($this->certKeyPasswd !== null){
            curl_setopt($soap_do, CURLOPT_SSLKEYPASSWD, $this->certKeyPasswd);
        }

        //Se ejecuta la petición
        $result = curl_exec($soap_do);

        //Si hay un error en la petición, se genera una excepción
        if(curl_errno($soap_do)){
            $this->setResponse(false);
            throw new Exception(curl_error($soap_do));
        }

        //Se almacena la respuesta
        $this->setResponse($result);
        //Si hay Fault se genera uan excepción
        if($result){
            $object = $this->toObject();
            if(is_object($object) && property_exists($object, 'Fault')){
                throw new Exception($object->Fault->faultstring);

            }
        }
    }

    /**
     * Retorna la respuesta en JSON
     *
     * @return string
     */
    public function toJSON() {
        $array = $this->toArray();
        $json = json_encode($array);
        return $json;
    }

    /**
     * Retorna la respuesta en xml
     *
     * @return string
     */
    public function toXML() {
        $xml = str_ireplace(['S:','NS2:', 'SOAP-ENV:', 'SOAP:', 'ns1:', 'soapenv:','xsi:nil="true"'], '', $this->getResponse());
     
        return $xml;
    }

    /**
     * Retorna la respuesta en array
     *
     * @return array
     */
    public function toArray() {
        $sXML = $this->toObject();
        $array = json_decode(json_encode($sXML), true);
        return $array;
    }

    /**
     * Retorna el resultado en un objeto
     * @return SimpleXMLElement
     */
    public function toObject() {
        $xml = $this->toXML();
        //$sXML = simplexml_load_string($xml);
        //return $sXML->Body;
    }

    /**
     * Retorna el endPoint
     * @return string
     */
    public function getEndPoint() {
        return $this->endPoint;
    }

    /**
     * Retorna el request
     * @return string
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * Retorna el response
     * @return string
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * Retorna el usuario
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Retorna la constraseña
     * @return string
     */
    public function getPasswd() {
        return $this->passwd;
    }

    /**
     * Retorna el timeOut
     * @return int
     */
    public function getTimeOut() {
        return $this->timeOut;
    }

    /**
     * Establece el endpoint
     * @param string $endPoint
     */
    public function setEndPoint($endPoint) {
        $this->endPoint = $endPoint;
    }

    /**
     * Establece el request
     * @param string $request
     */
    public function setRequest($request) {
        $this->request = $request;
    }

    /**
     * Establece el response
     * @param string $response
     */
    public function setResponse($response) {
        $this->response = $response;
    }

    /**
     * Establece el usuario
     * @param string $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * Establece la contraseña
     * @param string $passwd
     */
    public function setPasswd($passwd) {
        $this->passwd = $passwd;
    }

    /**
     * Establece el timeout
     * @param int $timeOut
     */
    public function setTimeOut($timeOut) {
        $this->timeOut = $timeOut;
    }

    /**
     * Retorna el connect timeout
     * @return int
     */
    public function getConnectTimeOut() {
        return $this->connectTimeOut;
    }

    /**
     * Establece el timeout de conexión
     * @param string $connectTimeOut
     */
    public function setConnectTimeOut($connectTimeOut) {
        $this->connectTimeOut = $connectTimeOut;
    }

    /**
     * Retorna el action del servicio
     * @return string
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Establece el action
     * @param string $action
     */
    public function setAction($action) {
        $this->action = $action;
    }

    /**
     * Añade certificado para el consumo del servicio
     *
     * @param string $pathPEM
     * @param string $pathPEMPasswd
     * @param string $certKey
     * @param string $certKeyPasswd
     */
    public function addCertPEM($pathPEM, $pathPEMPasswd = null, $certKey = null, $certKeyPasswd = null){
        $this->certPem = $pathPEM;
        $this->certPemPasswd = $pathPEMPasswd;
        $this->certKey = $certKey;
        $this->certKeyPasswd = $certKeyPasswd;
    }

    /**
     * Ruta del CRT o CAInfo
     * @param string $path
     */
    public function addCAInfo($path){
        $this->pathCA = $path;
    }
}
