<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Capturing extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

public function __construct() {
    parent::__construct();

    $this->load->model(array( "Communes_model"=>"communes", "Glossary_model"=>"glossary", "Journal_model","journal", 
            "Parameters_model"=>"parameters", "Documents_model","documents") );
    $this->load->library(array('Rut', 'Soap', 'form_validation', 'Pdf'));
    $this->load->helper(array('funciones_helper', 'ws_solventa_helper', 'teknodatasystems_helper'));

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}

    date_default_timezone_set('America/Santiago');
}

public function index() {

    $return = check_session("6.1.2");

    $username = $this->session->userdata("username");

    $dataLoad = array();
    $dataLoad['regions'] = $this->communes->ViewRegions();
    $dataLoad['countries'] = $this->glossary->getall_paisesTecnocom();
    $dataLoad['communes'] = $this->glossary->getall_comunasTecnocom();
    $dataLoad['viaAddress'] = $this->glossary->getall_tipoCallesTecnocom();
    $dataLoad['isapres'] = $this->glossary->getall_institucionesSaludTecnocom();
    $dataLoad['diaspago'] = $this->glossary->getall_diaspagoTecnocom();

    $this->load->view('capturing/preapproved', $dataLoad);

}

public function dashboard() {

    $return = check_session("6.1.5");

    $data_journal = array(); $field_iduser = $this->session->userdata("id_user"); $field_type = 1;

    if($this->session->userdata('id_manager')==1) {

        $field_idoffice = $this->session->userdata('id_office');
        //$ta_journal = $this->journal->get_attentionByManager($field_iduser, $field_type, $field_idoffice);

    }else {


//        $ta_journal = $this->journal->get_attentionByIdUser($field_iduser, $field_type);

    }

  /****
    if($ta_journal!=false) {
        foreach ($ta_journal as $key) {
            $valor["rut"] = number_format((float)$key->number_rut_client, 0, ',', '.')."-".$key->digit_rut_client;
            $valor["name_client"] = $key->name_client;
            $valor["stamp"] = $key->stamp;
            $valor["office"] = $key->name_office;
            $valor["reasonDetail"] =  $key->detail;
            $valor["username"] =  $key->username;
            $data_journal[] = $valor;
        }
    }
    *****/
    $datos["journal"] = $data_journal;
    //$datos['office'] = $this->user->sp_office($this->session->userdata('id'));
    $this->load->view('capturing/dashboard',$datos);
}

public function search() {

    $return = check_session("6.1.1");

    $id_rol = $this->session->userdata("id_rol");
    $id_office = $this->session->userdata("id_office");
    $username = $this->session->userdata("username");

    $dataOffice = $this->parameters->getall_office();
    $optionOffice["optionOffice"] = "";
    foreach ($dataOffice as $nodo) {
        if($id_office==$nodo->id_office) {

        $optionOffice["optionOffice"] .= "<option selected value='".$nodo->id_office."'>".$nodo->name."</option>";

        } else {

        $optionOffice["optionOffice"] .= "<option value='".$nodo->id_office."'>".$nodo->name."</option>";

        }
    }
    $optionOffice["todayDate"] = date("d-m-Y");
    $optionOffice["todayTime"] = date("H:i:s");

    $dataLoad = array();
    $dataLoad["dataOffice"] = $optionOffice;

    $this->load->view('capturing/search', $dataLoad);

}

public function preapproved() {

    $return = check_session("6.1.2");

    $username = $this->session->userdata("username");

    $dataLoad = array();
    $dataLoad['regions'] = $this->communes->ViewRegions();
    $dataLoad['countries'] = $this->glossary->getall_paisesTecnocom();
    $dataLoad['communes'] = $this->glossary->getall_comunasTecnocom();
    $dataLoad['viaAddress'] = $this->glossary->getall_tipoCallesTecnocom();
    $dataLoad['isapres'] = $this->glossary->getall_institucionesSaludTecnocom();
    $dataLoad['diaspago'] = $this->glossary->getall_diaspagoTecnocom();

    $this->load->view('capturing/preapproved', $dataLoad);

}


public function apiHSM() {

    $return = check_session("");

    $this->form_validation->set_rules('pinBlockPinera', 'Pin Block Pinpad', 'trim|required');
    $this->form_validation->set_rules('panPinera', 'Pan Pindpad', 'trim|required');
    $this->form_validation->set_rules('keySerialNumber', 'Key Serial Number', 'trim|required');
    $this->form_validation->set_rules('canal', 'Canal', 'trim|required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $username = $this->session->userdata("username");

    $dataInput = array(
        "pinBlockPinera" => $this->input->post("pinBlockPinera"),
        "panPinera" => $this->input->post("panPinera"),
        "keySerialNumber" => $this->input->post("keySerialNumber"),
        "canal" => $this->input->post("canal"),
        "username" => $username
        );

    $result = ws_GET_pinHSM($dataInput);

    $data = $result;
    echo json_encode($data);

}


public function pinpadTA() {

    $return = check_session("");

    $this->form_validation->set_rules('panPinera', 'Número PAN', 'trim|required');
    $this->form_validation->set_rules('pinBlockMinsait', 'pinBlockMinsait', 'trim|required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $username = $this->session->userdata("username");
/***
 * Begin::CC0025-Release activación tarjeta SPIN se cambia tipacc=2 por tipacc=1 
 ***/ 
    $tipacc = 1;            // activación
/***
 * End::CC0025
 ***/ 
    $tipsol = "2";          // tipo solicitud
    $estad1 = "3";          // estado 1
    $estad2 = "3";          // estado 2    

    $dataInput = array(
        "tipacc" => $tipacc,
        "pan" => $this->input->post("panPinera"),
        "tipsol" => $tipsol,
        "pinblk" => $this->input->post("pinBlockMinsait"),
        "estad1" => $estad1,
        "estad2" => $estad2,
        "username" => $username
        );

    $result = ws_GET_pinpadTA($dataInput);

    $data = $result;
    echo json_encode($data);

}


public function approved() {

    $return = check_session("6.1.2");

    $this->form_validation->set_rules('nroRut', 'N&#250;mero Rut', 'trim|required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $nroRut = $this->input->post("nroRut");

    $eval = validaRUTCL($nroRut);
    if($eval["retorno"]!=0){
        cancel_function(COD_ERROR_INIT, $eval["descRetorno"], "Preste Atención");
    }
    $username = $this->session->userdata("username");

    $dataInput = [ 
        "numdoc" => $nroRut,
        "tipdoc" => "RUT",
        "codProducto" => $this->session->userdata("id_product"),
        ];
    $capturing = ws_GET_CapturingByrut($dataInput);

    if($capturing["retorno"]==0){

        $dataLoad["dataClient"] = $capturing;

    }else {

        $dataLoad["dataClient"] = array();
    }

    $dataLoad['regions'] = $this->communes->ViewRegions();
    $dataLoad['countries'] = $this->glossary->getall_paisesTecnocom();
    $dataLoad['communes'] = $this->glossary->getall_comunasTecnocom();
    $dataLoad['viaAddress'] = $this->glossary->getall_tipoCallesTecnocom();
    $dataLoad['isapres'] = $this->glossary->getall_institucionesSaludTecnocom();
    $dataLoad['diaspago'] = $this->glossary->getall_diaspagoTecnocom();

    $dataLoad["dataDirecciones"] = array();
    $dataLoad["dataTelefonos"] = array();
    $dataLoad["dataEmails"] = array();

    $this->load->view('capturing/approved', $dataLoad);

}

public function factory() {

    $return = check_session("6.1.2");

    $this->form_validation->set_rules('id', 'N&#250;mero Captación', 'trim|required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $eval = $this->journal->get_capturingById($this->input->post("id"));
    if($eval){

        $value["origen"] = $eval->origen;
        $value["cupo"] = "$".number_format($eval->cupo,0,",",".");
        $value["nombres"] = $eval->nombres;
        $value["apellidos"] = $eval->apellidos;
        $value["rut"] = $eval->rut."-".$eval->digitov;
        $value["autorizador"] = $eval->autorizador;
        $value["grupocuo"] = $eval->grupocuo;

        $value["source_description"] = ($eval->origen==SOURCE_CAPTURING_NAME ? "Orden Embozado Tarjeta " . PRODUCT_BRAND_PRIV : "Orden Embozado Tarjeta " . PRODUCT_BRAND_SPIN);

        if(substr($eval->serienumdocci,0,1)=="A"){

            $value["serienumdocci"] = $eval->serienumdocci;

        } else {

            $value["serienumdocci"] = substr($eval->serienumdocci, 0,3).".".substr($eval->serienumdocci, 3,3).".".substr($eval->serienumdocci, 6,3);
        }
        $value["fechanac"] = $eval->fechanac;
        $value["indestciv"] = "";
        switch ($eval->indestciv) {
            case 1:
                $value["indestciv"] = "SOLTERO(A)"; break;
            case 2:
                $value["indestciv"] = "CASADO(A)"; break;
            case 3:
                $value["indestciv"] = "VIUDO(A)"; break;
            case 4:
                $value["indestciv"] = "DIVORCIADO(A)"; break;
            case 5:
                $value["indestciv"] = "SEPARADO(A)"; break;
            case 6:
                $value["indestciv"] = "CONVIVENCIA"; break;
        }
        $result = $this->glossary->get_paisesTecnocomById($eval->codpaisnac);
        $value["codpaisnac"] = ($result ? $result->NAME : "NO DEFINIDA");

        $result = $this->glossary->get_paisesTecnocomById($eval->codpaisres);
        $value["codpaisres"] = ($result ? $result->NAME : "NO DEFINIDA");

        $result = $this->glossary->get_comunasTecnocomById($eval->codprov);
        $value["codprov"] = ($result ? $result->NAME : "NO DEFINIDA");

        $value["direccion"] = $eval->nomvia." ".$eval->numvia;
        $value["telefono1"] = $eval->desclave1;
        $value["telefono2"] = $eval->desclave2;
        $value["telefono3"] = $eval->desclave3;
        $value["telefono4"] = $eval->desclave4;
        $value["email1"] = $eval->desclave5;
        $value["email2"] = $eval->desclave6;

        $value["nrotcv"] = substr($eval->nrotcv,0,4)."-".substr($eval->nrotcv,4,4)."-".substr($eval->nrotcv,8,4)."-".substr($eval->nrotcv,12,4);

        $value["masknrotcv"] = "****-****-****-" . substr($eval->nrotcv,12,4);

        $value["indsegdes"] = ($eval->indsegdes=="S" ? "SI": "NO");

        $result = $this->glossary->get_institucionesSaludTecnocomById($eval->inssaludprev);
        $value["inssaludprev"] = ($result ? $result->NAME : "NO DEFINIDA");

        $value["autorizador"] = $eval->autorizador;
        $value["eeccemail"] = ($eval->eeccemail=="S" ? "SI" : "NO");

        $dataLoad = array();
        $dataLoad["dataClient"] = $value;

        $this->load->view('capturing/factory', $dataLoad);

    }else{

        cancel_function(COD_ERROR_INIT, "Error, al leer datos captación cliente..!", "");

    }


}

public function active() {

    $return = check_session("6.1.2");

    $this->form_validation->set_rules('id', 'N&#250;mero Captación', 'trim|required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $eval = $this->journal->get_capturingById($this->input->post("id"));
    if($eval){

        $value["origen"] = $eval->origen;
        $value["cupo"] = "$".number_format($eval->cupo,0,",",".");
        $value["nombres"] = $eval->nombres;
        $value["apellidos"] = $eval->apellidos;
        $value["rut"] = $eval->rut."-".$eval->digitov;
        $value["autorizador"] = $eval->autorizador;

        if($eval->origen==SOURCE_CAPTURING_NAME OR $eval->origen==SOURCE_PRODUCT_CHANGE_NAME){

            $value["source_description"] = ($eval->origen==SOURCE_CAPTURING_NAME ? "Orden Activación Tarjeta " . PRODUCT_BRAND_PRIV : "Orden Activación Tarjeta" . PRODUCT_BRAND_SPIN);

            if(substr($eval->serienumdocci,0,1)=="A"){

                $value["serienumdocci"] = $eval->serienumdocci;

            } else {

                $value["serienumdocci"] = substr($eval->serienumdocci, 0,3).".".substr($eval->serienumdocci, 3,3).".".substr($eval->serienumdocci, 6,3);
            }
            $value["fechanac"] = $eval->fechanac;
            switch ($eval->indestciv) {
                case 1:
                    $value["indestciv"] = "SOLTERO(A)"; break;
                case 2:
                    $value["indestciv"] = "CASADO(A)"; break;
                case 3:
                    $value["indestciv"] = "VIUDO(A)"; break;
                case 4:
                    $value["indestciv"] = "DIVORCIADO(A)"; break;
                case 5:
                    $value["indestciv"] = "SEPARADO(A)"; break;
                case 6:
                    $value["indestciv"] = "CONVIVENCIA"; break;
            }
            $result = $this->glossary->get_paisesTecnocomById($eval->codpaisnac);
            $value["codpaisnac"] = ($result ? $result->NAME : "NO DEFINIDA");

            $result = $this->glossary->get_paisesTecnocomById($eval->codpaisres);
            $value["codpaisres"] = ($result ? $result->NAME : "NO DEFINIDA");


            $result = $this->glossary->get_comunasTecnocomById($eval->codprov);
            $value["codprov"] = ($result ? $result->NAME : "NO DEFINIDA");

            $value["direccion"] = $eval->nomvia." ".$eval->numvia;
            $value["telefono1"] = $eval->desclave1;
            $value["telefono2"] = $eval->desclave2;
            $value["telefono3"] = $eval->desclave3;
            $value["telefono4"] = $eval->desclave4;
            $value["email1"] = $eval->desclave5;
            $value["email2"] = $eval->desclave6;

            $value["nrotcv"] = substr($eval->nrotcv,0,4)."-".substr($eval->nrotcv,4,4)."-".substr($eval->nrotcv,8,4)."-".substr($eval->nrotcv,12,4);

            $value["masknrotcv"] = "****-****-****-" . substr($eval->nrotcv,12,4);

            $value["indsegdes"] = ($eval->indsegdes=="S" ? "SI": "NO");

            $result = $this->glossary->get_institucionesSaludTecnocomById($eval->inssaludprev);
            $value["inssaludprev"] = ($result ? $result->NAME : "NO DEFINIDA");

            $value["autorizador"] = $eval->autorizador;
            $value["eeccemail"] = ($eval->eeccemail=="S" ? "SI" : "NO");

            $dataLoad = array();
            $dataLoad["dataClient"] = $value;

            $this->load->view('capturing/active', $dataLoad);

        }

    }


}

public function approval() {

    $return = check_session("6.1.2");

    $this->form_validation->set_rules('id', 'N&#250;mero Captación', 'trim|required');
    $this->form_validation->set_message('required','El atributo %s es obligatorio');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $eval = $this->journal->get_capturingById($this->input->post("id"));
    if($eval){

        $value["origen"] = $eval->origen;
        $value["cupo"] = "$".number_format($eval->cupo,0,",",".");
        $value["nombres"] = $eval->nombres;
        $value["apellidos"] = $eval->apellidos;
        $value["rut"] = $eval->rut."-".$eval->digitov;
        $value["autorizador"] = $eval->autorizador;
        $value["grupocuo"] = $eval->grupocuo;

        if($eval->origen==SOURCE_CAPTURING_NAME OR $eval->origen==SOURCE_PRODUCT_CHANGE_NAME){

            $value["source_description"] = ($eval->origen==SOURCE_CAPTURING_NAME ? "Validar Solicitud impresi&#243;n Pl&#225;sticos" : "Validar Documentos UPGRADE Tarjeta");

            if(substr($eval->serienumdocci,0,1)=="A"){

                $value["serienumdocci"] = $eval->serienumdocci;

            } else {

                $value["serienumdocci"] = substr($eval->serienumdocci, 0,3).".".substr($eval->serienumdocci, 3,3).".".substr($eval->serienumdocci, 6,3);
            }
            $value["fechanac"] = $eval->fechanac;
            switch ($eval->indestciv) {
                case 1:
                    $value["indestciv"] = "SOLTERO(A)"; break;
                case 2:
                    $value["indestciv"] = "CASADO(A)"; break;
                case 3:
                    $value["indestciv"] = "VIUDO(A)"; break;
                case 4:
                    $value["indestciv"] = "DIVORCIADO(A)"; break;
                case 5:
                    $value["indestciv"] = "SEPARADO(A)"; break;
                case 6:
                    $value["indestciv"] = "CONVIVENCIA"; break;
            }
            $result = $this->glossary->get_paisesTecnocomById($eval->codpaisnac);
            $value["codpaisnac"] = ($result ? $result->NAME : "NO DEFINIDA");

            $result = $this->glossary->get_paisesTecnocomById($eval->codpaisres);
            $value["codpaisres"] = ($result ? $result->NAME : "NO DEFINIDA");


            $result = $this->glossary->get_comunasTecnocomById($eval->codprov);
            $value["codprov"] = ($result ? $result->NAME : "NO DEFINIDA");

            $value["direccion"] = $eval->nomvia." ".$eval->numvia;
            $value["telefono1"] = $eval->desclave1;
            $value["telefono2"] = $eval->desclave2;
            $value["telefono3"] = $eval->desclave3;
            $value["telefono4"] = $eval->desclave4;
            $value["email1"] = $eval->desclave5;
            $value["email2"] = $eval->desclave6;

            $value["nrotcv"] = substr($eval->nrotcv,0,4)."-".substr($eval->nrotcv,4,4)."-".substr($eval->nrotcv,8,4)."-".substr($eval->nrotcv,12,4);

            $value["masknrotcv"] = "****-****-****-" . substr($eval->nrotcv,12,4);

            $value["indsegdes"] = ($eval->indsegdes=="S" ? "SI": "NO");

            $result = $this->glossary->get_institucionesSaludTecnocomById($eval->inssaludprev);
            $value["inssaludprev"] = ($result ? $result->NAME : "NO DEFINIDA");

            $value["autorizador"] = $eval->autorizador;
            $value["eeccemail"] = ($eval->eeccemail=="S" ? "SI" : "NO");

            $dataLoad = array();
            $dataLoad["dataClient"] = $value;

            $this->load->view('capturing/approval', $dataLoad);


        }else{

            $value["nombres"] = $eval->nombres;
            $value["apellidos"] = $eval->apellidos;
            $value["rut"] = $eval->rut."-".$eval->digitov;
            $value["nrotcv"] = substr($eval->nrotcv,0,4)."-".substr($eval->nrotcv,4,4)."-".substr($eval->nrotcv,8,4)."-".substr($eval->nrotcv,12,4);
            $value["desclave1"] = $eval->desclave1;
            $value["desclave2"] = $eval->desclave2;
            $value["desclave3"] = $eval->desclave3;

            $dataLoad = array();
            $dataLoad["dataClient"] = $value;

            $this->load->view('client/reprint', $dataLoad);

        }

    }

}

public function validate_address_capturing() {

    $return = check_session("");

    $this->form_validation->set_rules('viaAddress', 'Vía Dirección', 'required|trim');
    $this->form_validation->set_rules('address', 'Detalle Dirección ', 'required|trim');
    $this->form_validation->set_rules('numberDepart', 'Número Departamento ', 'numeric');
    $this->form_validation->set_rules('numberBlock', 'Número Edificio ', 'numeric');
    $this->form_validation->set_rules('postalCode', 'Código Postal ', 'required');
    $this->form_validation->set_rules('regionCode', 'Región ', 'trim');
    $this->form_validation->set_rules('cityCode', 'Ciudad', 'trim');
    $this->form_validation->set_rules('communeCode', 'Comuna ', 'required|trim');

    $this->form_validation->set_message('valid_email','El atributo %s no es valido..');
    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    $this->form_validation->set_message('alpha','El atributo %s debe ser alfabetico..');
    $this->form_validation->set_message('numeric','El atributo %s debe ser numerico..');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_INIT, validation_errors(), "");
    }

    $value["retorno"] = 0;
    $value["descRetorno"] = "Validación Datos es Correcta!";

    $data = $value;
    echo json_encode($data);

}

public function validate_save_capturing() {
    
    $return = check_session("");

/* Datos Personales Cliente */
    $this->form_validation->set_rules('rutClient', 'Rut Cliente', 'required|trim');
    $this->form_validation->set_rules('nameClient', 'Nombre Cliente', 'required|trim');
    $this->form_validation->set_rules('lastFatherClient', 'Apellido Paterno Cliente', 'required|trim');
    $this->form_validation->set_rules('lastMotherClient', 'Apellido Materno Cliente', 'trim');
    $this->form_validation->set_rules('rutClientSerie', 'Número de Serie Cedula Cliente', 'required|max_length[11]|trim');
    $this->form_validation->set_rules('birthDateClient', 'Fecha Nacimiento Cliente', 'required|trim');
    $this->form_validation->set_rules('sexClient', 'Sexo Cliente', 'required|trim');
    $this->form_validation->set_rules('civilClient', 'Estado Civil Cliente', 'required|trim');
    $this->form_validation->set_rules('nationality', 'Nacionalidad Cliente', 'required|trim');
    $this->form_validation->set_rules('countryByOrigin', 'País Origen Cliente', 'required|trim');
    $this->form_validation->set_rules('countryResidence', 'País Residencia Cliente', 'required|trim');
    $this->form_validation->set_rules('typeClient', 'Tipo Cliente', 'required|trim');
    $this->form_validation->set_rules('scoreClient', 'Score Cliente', 'required|numeric|trim');

/* Dirección del Cliente */
    $this->form_validation->set_rules('viaAddress', 'Vía Dirección', 'required|trim');
    $this->form_validation->set_rules('address', 'Detalle Dirección ', 'required|trim');
    $this->form_validation->set_rules('numberDepart', 'Número Departamento ', 'trim');
    $this->form_validation->set_rules('numberFloor', 'Número Piso', 'trim');
    $this->form_validation->set_rules('numberBlock', 'Número Block ', 'trim');
    $this->form_validation->set_rules('postalCode', 'Código Postal ', 'trim');
    $this->form_validation->set_rules('communeCode', 'Comuna ', 'required|trim');
    $this->form_validation->set_rules('complement', 'Villa / Población / Condominio', 'required|max_length[30]|trim');

/* Telefonos del Cliente */
    $this->form_validation->set_rules('numberPhone1', 'Número Teléfono Móvil 1', 'required|numeric|trim');
    $this->form_validation->set_rules('numberPhone2', 'Número Teléfono Móvil 2', 'numeric|trim');
    $this->form_validation->set_rules('numberPhone3', 'Número Teléfono Particular 1', 'numeric|trim');
    $this->form_validation->set_rules('numberPhone4', 'Número Teléfono Particular 2', 'numeric|trim');

/* Emails del Cliente */
    $this->form_validation->set_rules('clientEmail1', 'Email Cliente 1', 'required|valid_email|trim');
    $this->form_validation->set_rules('clientEmail2', 'Email Cliente 2', 'valid_email|trim');

/* Datos Tarjeta Pre Aprobada */
    $this->form_validation->set_rules('number_credit_card', 'Número Tarjeta de Crédito', 'trim');
    $this->form_validation->set_rules('amount_credit_card', 'Cupo Asignado Tarjeta de Crédito', 'required|trim');
    $this->form_validation->set_rules('payment_form_credit_card', 'Forma de Pago Tarjeta de Crédito', 'required|trim');
    $this->form_validation->set_rules('eeccEmail', 'Suscribe estado de Cuenta por Email', 'required|trim');
    $this->form_validation->set_rules('secure_credit_card', 'Seguro Tarjeta de Crédito', 'required|trim');
    $this->form_validation->set_rules('payment_day_credit_card', 'Día Pago Tarjeta de Crédito', 'required|trim');
    $this->form_validation->set_rules('health_credit_card', 'Institución Salud', 'required|trim');
    $this->form_validation->set_rules('contract_number_credit_card', 'Número Contrato Tarjeta de Crédito', 'required|max_length[20]|alpha_numeric|trim');
    $this->form_validation->set_rules('remarks_credit_card', 'Observación Datos Tarjeta', 'trim');
    $this->form_validation->set_rules('type_credit_card', 'Tipo Tarjeta Crédito Oferta', 'max_length[2]|trim');

    $this->form_validation->set_message('valid_email','El atributo %s no es valido..');
    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    $this->form_validation->set_message('alpha','El atributo %s debe ser alfabetico..');
    $this->form_validation->set_message('numeric','El atributo %s debe ser numerico..');
    $this->form_validation->set_message('alpha_numeric','El atributo %s debe ser alfanumerico sin espacios..');
    $this->form_validation->set_message('max_length','El atributo %s excede largo máximo..');
    $this->form_validation->set_message('min_length','El atributo %s menor largo mínimo..');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    $rutClientSerie = $_POST["rutClientSerie"];
    if(substr($rutClientSerie,0,1)=="A"){

        $numberSerie = substr($rutClientSerie, 1, strlen($rutClientSerie) - 1);
        $maxSerie = 10;
        $descRetorno = "Validación Serie Cédula Antigua : A999999999 [Letra A + 9 digitos]..!";

    }else if(substr($rutClientSerie,3,1)=="." AND substr($rutClientSerie,7,1)==".") {

            $numberSerie = str_replace(".", "", $rutClientSerie);
            $maxSerie = 11;
            $descRetorno = "Validación Serie Nueva Cédula : 999.999.999 [11 digitos]";

    } else {

            $numberSerie = $rutClientSerie;
            $maxSerie = 9;
            $descRetorno = "Validación Serie Cédula Antigua : 999999999 [9 digitos]";
    }

    if(!is_numeric($numberSerie) OR strlen($rutClientSerie) != $maxSerie) {

        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");
    }

    $numberPhone = $this->input->post("numberPhone1");

    if($this->input->post("numberPhone1")!=""){
        $valPhone = get_ValidatePhoneMobile($this->input->post("numberPhone1"));
        if($valPhone["retorno"]!=0){

            cancel_function($valPhone["retorno"], $valPhone["descRetorno"]." [Móvil 1]", "");
        }
        $typePhone1 = "MO";
    }else{
        $typePhone1 = "";
    }

    if($this->input->post("numberPhone2")!=""){
        $valPhone = get_ValidatePhoneMobile($this->input->post("numberPhone2"));
        if($valPhone["retorno"]!=0){

            cancel_function($valPhone["retorno"], $valPhone["descRetorno"]." [Móvil 2]", "");
        }
        $typePhone2 = "MO";
    }else{
        $typePhone2 = "";
    }

    if($this->input->post("numberPhone3")!=""){
        $valPhone = get_ValidatePhonePermanent($this->input->post("numberPhone3"));
        if($valPhone["retorno"]!=0){

            cancel_function($valPhone["retorno"], $valPhone["descRetorno"]." [Teléfono 1]", "");
        }
        $typePhone3 = "TE";
    }else{
        $typePhone3 = "";
    }

    if($this->input->post("numberPhone4")!=""){
        $valPhone = get_ValidatePhonePermanent($this->input->post("numberPhone4"));
        if($valPhone["retorno"]!=0){

            cancel_function($valPhone["retorno"], $valPhone["descRetorno"]." [Teléfono 2]", "");
        }
        $typePhone4 = "TE";
    }else{
        $typePhone4 = "";
    }

    if($this->input->post("clientEmail1")!=""){
        $typeEmail1 = "EM";
    }else{
        $typeEmail1 = "";
    }

    if($this->input->post("clientEmail2")!=""){
        $typeEmail2 = "EM";
    }else{
        $typeEmail2 = "";
    }

    $nroRut = str_replace('.', '', $this->input->post("rutClient")); 
    $nroRut = str_replace('-', '', $nroRut); $dgvRut = substr($nroRut, -1); $nroRut = substr($nroRut, 0, -1);

    $local = (string)$this->session->userdata("id_office");
    $fechanac = substr($this->input->post("birthDateClient"),6,4)."-".substr($this->input->post("birthDateClient"),3,2)."-".substr($this->input->post("birthDateClient"),0,2);
    $hora = date("His"); $nombrevend = $this->session->userdata("username");
    $rutvend = $this->session->userdata("rut_number"); $dgvvend = $this->session->userdata["rut_validation"];
    $result = $this->glossary->get_tipoCallesTecnocomByName($this->input->post("viaAddress"));
    if($result != FALSE) {
        $tipvia = $result->KEY;
    } else {
        $tipvia = "AV";
    }
    $result = $this->glossary->get_comunasTecnocomByName($this->input->post("communeCode"));
    if($result != FALSE) {
        $codprov = $result->KEY_ALTER1;
    } else {
        $codprov = "ER";
    }
    
    $serienumdocci = str_replace(".", "", $this->input->post("rutClientSerie"));
    $number_credit_card = str_replace("-", "", $this->input->post("number_credit_card"));
    $amount_credit_card = str_replace(".", "", $this->input->post("amount_credit_card"));
    $amount_credit_card = str_replace("$", "", $amount_credit_card);

    $postalCode = str_replace(" ","",$this->input->post("postalCode"));
    $postalCode = str_replace("_","",$postalCode);
    $postalCode = str_replace(".","",$postalCode);

    $sexo = $this->input->post("sexClient");

    $restodir = "D.".$this->input->post("numberFloor").$this->input->post("numberDepart");

    if( $this->input->post("descam")=="CP" OR $this->input->post("descam")=="TA" ):

        if( $this->input->post("descam")=="CP" ):
            $origen = SOURCE_PRODUCT_CHANGE_NAME;
            $flgnewclient = "N";
            $cod_producto = "T";
        else:
            $origen = SOURCE_CAPTURING_NAME;
            $flgnewclient = "S";
            $cod_producto = "";
        endif;

        if($number_credit_card==""):

            $fechanac = substr($fechanac, 8,2) . "-" . substr($fechanac,5,2) . "-" . substr($fechanac, 0,4);

            if($sexo=="MAS"):
                $sexo = "V";
            else:
                $sexo = "M";
            endif;

        else:

            $fechanac = substr($fechanac, 0,4) . substr($fechanac,5,2) . substr($fechanac, 8,2);
            $fechanac = str_replace("-", "", $fechanac);

        endif;

    else:

        if($number_credit_card==""):

            $fechanac = substr($fechanac, 8,2) . "-" . substr($fechanac,5,2) . "-" . substr($fechanac, 0,4);
            $fechanac = str_replace("-", "", $fechanac);

            if($sexo=="MAS"):
                $sexo = "V";
            else:
                $sexo = "M";
            endif;
            $cod_producto = "";

        else:

            $fechanac = substr($fechanac, 0,4) . substr($fechanac,5,2) . substr($fechanac, 8,2);
            $fechanac = str_replace("-", "", $fechanac);
            $cod_producto ="T";

        endif;

        $origen = SOURCE_CAPTURING_NAME;
        $flgnewclient = "S";

    endif;

    $data = array(
      'centalta'=>substr($local,1,4),
      'codpaisdir'=>$this->input->post("countryByOrigin"),
      'codpaisnac'=>$this->input->post("countryByOrigin"),
      'codpaisnct'=>$this->input->post("countryResidence"),
      'codpaisres'=>$this->input->post("countryResidence"),
      'codpostal'=>$postalCode,
      'codprov'=>$codprov,
      'desclave1'=>$this->input->post("numberPhone3"),
      'desclave2'=>$this->input->post("numberPhone4"),
      'desclave3'=>$this->input->post("numberPhone1"),
      'desclave4'=>$this->input->post("numberPhone2"),
      'desclave5'=>$this->input->post("clientEmail1"),
      'desclave6'=>$this->input->post("clientEmail2"),
      'digitov'=>$dgvRut,
      'edificio'=>$this->input->post("numberBlock"),
      'eeccemail'=>$this->input->post("eeccEmail"),
      'fecha'=>date("Y-m-d"),
      'fechanac'=>$fechanac,
      'grupocuo'=>$this->input->post("payment_day_credit_card"),
      'hora'=>$hora,
      'hordespliegue'=>$hora,
      'indenvcor'=>$this->input->post("eeccEmail"),
      'indestciv'=>$this->input->post("civilClient"),
      'indsegdes'=>$this->input->post("secure_credit_card"),
      'inssaludprev'=>$this->input->post("health_credit_card"),
      'local'=>$local,
      'nombrevend'=>$nombrevend,
      'nomvia'=>$this->input->post("address"),
      'nrocampagna'=>$this->input->post("campaign_number"),
      'numcontrato'=>$this->input->post("contract_number_credit_card"),
      'numvia'=>$this->input->post("numberAddress"),
      'observacion'=>$this->input->post("remarks_credit_card"),
      'piso'=>$this->input->post("numberFloor"),
      'poblacion'=>$this->input->post("complement"),
      'puerta'=>$this->input->post("numberDepart"),
      'restodir'=>$restodir,
      'rut'=>$nroRut,
      'rutvend'=>$rutvend."-".$dgvvend,
      'serienumdocci'=>$serienumdocci,
      'sexo'=>$sexo,
      'solicitud'=>0,
      'tipmedio1'=>$typePhone3, // TE O VACIO ** OPCIONAL
      'tipmedio2'=>$typePhone4, // TE O VACIO ** OPCIONAL
      'tipmedio3'=>$typePhone1, // MO ** OBLIGATORIO
      'tipmedio4'=>$typePhone2, // MO O VACIO ** OPCIONAL
      'tipmedio5'=>$typeEmail1, // EM ** OBLIGATORIO
      'tipmedio6'=>$typeEmail2, // VACIO ** NO UTILIZADO
      'tipvia'=>$tipvia,
      'nombres'=>$this->input->post("nameClient"),
      'apellidos'=>$this->input->post("lastFatherClient")." ".$this->input->post("lastMotherClient"),
      'nrotcv'=>$number_credit_card,
      'cupo'=>$amount_credit_card,
      'origen'=>$origen,
      'flgnewclient'=>$flgnewclient,
      'vbqf'=>'PE',
      'cod_producto'=>$cod_producto
    );

    $result = $this->journal->add_Capturing($data);

    $data = $result;
    echo json_encode($data);

}


public function capturing_list(){

    $return = check_session("");

    $this->form_validation->set_rules('nroRut', 'Número Rut Cliente', 'trim');
    $this->form_validation->set_rules('numberRequest', 'Número Captación', 'numeric|trim');
    $this->form_validation->set_rules('officeSkill', 'Sucursal Captación', 'required|trim');
    $this->form_validation->set_rules('typeRequestSkill', 'Estado Captación', 'trim');
    $this->form_validation->set_rules('dateBegin', 'Fecha Desde', 'required|trim');
    $this->form_validation->set_rules('dateEnd', 'Fecha Hasta', 'required|trim');

    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric','El atributo %s debe ser numerico..');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    $request["nroRut"] = $this->input->post("nroRut");
    $request["numberRequest"] = $this->input->post("numberRequest");
    $request["officeSkill"] = $this->input->post("officeSkill");
    $request["typeRequestSkill"] = $this->input->post("typeRequestSkill");
    $request["dateBegin"] = substr($this->input->post("dateBegin"),6,4).substr($this->input->post("dateBegin"),3,2).substr($this->input->post("dateBegin"),0,2);
    $request["dateEnd"] = substr($this->input->post("dateEnd"),6,4).substr($this->input->post("dateEnd"),3,2).substr($this->input->post("dateEnd"),0,2);

    if($request["dateBegin"]>$request["dateEnd"]){

        $descRetorno = "Fecha Inicio debe ser menor o igual a Fecha Termino..";
        cancel_function(COD_ERROR_VALID_FORM, $descRetorno, "");
    }

    $response = array(); $retorno = COD_ERROR_INIT; $descRetorno = ""; $data = array();
    $journal = $this->journal->get_capturingByReport($request);
    if($journal!=false){

        foreach ($journal as $key) {
            $code["autorizador"] = $key->autorizador;
            $code["origen"] = $key->origen;
            $code["rut"] = $key->rut."-".$key->digitov;
            $code["nombres"] = $key->nombres." ".$key->apellidos;
            $code["nombrevend"] = $key->nombrevend;
            $code["fecha"] = substr($key->fecha,8,2)."-"
            .substr($key->fecha,5,2)."-"
            .substr($key->fecha,0,4)." "
            .substr($key->hora,0,2).":"
            .substr($key->hora,2,2);

            $result = $this->parameters->get_officeById($key->local);
            if($result!=false) { $code["local"] = $result->name; } else { $code["local"] = "No Existe"; }

            $result = $this->get_statusCapturing($key->vbqf);

            $code["estado"] = $result["status"];
            $code["situation"] = $result["situation"];

            if($result["active"]==""):
                $code["accion"] = "<a href='#' " . $result["active"] . " data-id='".$key->autorizador."' data-status='".$key->vbqf."' class='approval btn btn-danger btn-xs'>" . $result["action"] . "</a>";
            else:
                $code["accion"] = "<a href='#' " . $result["active"] . " class='btn btn-danger btn-xs'>" . $result["action"] . "</a>";
            endif;

            $code["result"] = "";

            if($key->result_code!=""):
                $code["result"] .= "Solicitud: (" . $key->result_code . ") " . $key->result_descrip;
            endif;

            if($key->emboza_code!=""):
                $code["result"] .= "</br>Impresión: (" . $key->emboza_code . ") " . $key->emboza_descrip;
            endif;

            if($key->baja_seguro_code!=""):
                $code["result"] .= "</br>BajaSeguro: (" . $key->baja_seguro_code . ") " . $key->baja_seguro_result;
            endif;

            if($key->alta_seguro_code!=""):
                $code["result"] .= "</br>AltaSeguro: (" . $key->alta_seguro_code . ") " . $key->alta_seguro_result;
            endif;

            if($key->block_credit_card_code!=""):
                $code["result"] .= "</br>Bloqueo: (" . $key->block_credit_card_code . ") " . $key->block_credit_card_result;
            endif;

            $data[] = $code;
        }
        $retorno = 0;

    }else{

        $retorno = -1; $descRetorno = "Sin Información...";
    }

    $value["retorno"] = $retorno;
    $value["descRetorno"] = $descRetorno;

    $response["dataResult"] = $value;
    $response["dataResponse"] = $data;

    echo json_encode($response);
}


function get_mysqli() { $db = (array)get_instance()->db;
    return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}


public function documents(){

    $return = check_session("6.1.3");

    $data["dataFilters"] = "CAP";
    $this->load->view('client/documents', $data);
}


public function pinpadBridgeStatus(){

    $return = check_session("6.1.4");

    $this->load->view('pinpad/status');
}


public function pinblk(){

    $return = check_session("6.1.5");

    $this->form_validation->set_rules('tipact', 'Tipo Activación', 'required|trim');
    $this->form_validation->set_rules('pan', 'PAN', 'required|trim');
    $this->form_validation->set_rules('tipsol', 'Tipo Solicitud', 'trim');
    $this->form_validation->set_rules('pinblk', 'Pinblk', 'trim');
    $this->form_validation->set_rules('estad1', 'Estado 1', 'required|numeric|trim');
    $this->form_validation->set_rules('estad2', 'Estado 2', 'required|numeric|trim');
    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric','El atributo %s debe ser numerico..');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    $Request='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:req="http://xsd.solventachile.cl/PINPADTA/Req">
        <soapenv:Header/>
        <soapenv:Body>
            <req:DATA>
                <req:TIPACC>' . $this->input->post("tipact") . '</req:TIPACC>
                <req:PAN>' . $this->input->post("pan") . '</req:PAN>
                <req:TIPSOL>' . $this->input->post("tipsol") . '</req:TIPSOL>
                <req:PINBLK>' . $this->input->post("pinblk") . '</req:PINBLK>
                <req:ESTAD1>' . $this->input->post("estad1") . '</req:ESTAD1>
                <req:ESTAD2>' . $this->input->post("estad2") . '</req:ESTAD2>
            </req:DATA>
        </soapenv:Body>
    </soapenv:Envelope>';

    $ws_service = "/OSB/WSPinpadTA";
    $ws_metodo = "urn:pinpadta_bindQSService";

    $EndPoint = WS_https.WS_Ip.':'.WS_Ip_Port.$ws_service;
    $soap = get_SOAP($EndPoint, $ws_metodo, WS_Timeout30, $Request, WS_ToXml, $this->session->userdata("username"));

    $Request = array( "soap" => $soap, "tagName" => "TIPACC", "serviceName" => $ws_service);
    $eval = ws_EVAL_SOAP($Request);
    if($eval["retorno"]!=0){

        cancel_function(COD_ERROR_VALID_FORM, $eval["descRetorno"], "");
    }
    $xml = $eval["xmlDocument"];

    $value["retorno"] = (int)$xml->Body->DATA->cabeceraSalida->retorno;
    $value["descRetorno"] = (string)$xml->Body->DATA->cabeceraSalida->descRetorno;

    if($value["retorno"]==0):

        $value["pan"] = (string)$xml->Body->DATA->PAN;
        $value["tipacc"] = (string)$xml->Body->DATA->TIPACC;
        $value["tipsol"] = (string)$xml->Body->DATA->TIPSOL;
        $value["estad1"] = (string)$xml->Body->DATA->ESTAD1;
        $value["estad2"] = (string)$xml->Body->DATA->ESTAD2;

    endif;

    $data = $value;

    echo json_encode($data);
 
}


private function generaPDFEntrega($Request){

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Solventa - MáximoERP-FI - PDF Documents');

        $product = $this->parameters->get_productById($Request["datos"]["id_product"]);

        $pdf->SetTitle('Comprobante Entrega ' . $product->name_product);

        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('TeknodataSystems');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $html =  $this->load->view($product->name_template_delivery,$Request,true);

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("/tmp/".'delivery_credit_card.pdf', 'F');
        $filename = "/tmp/".'delivery_credit_card.pdf';

        $fp = fopen($filename, 'r+b');
              $data = fread($fp, filesize($filename));
              fclose($fp);

        $data = mysqli_real_escape_string($this->get_mysqli(),$data);
        $fecha = date("Y-m-d H:i:s");

        $nameUser = $this->session->userdata("username");
        $office = $this->session->userdata("id_office");
        $id_user = $this->session->userdata("id");
        $sqlcall = $this->db->query("INSERT INTO ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,digit_rut_client,name_client,idDocument,typeDocument,id_user_last_print, id_office_last_print) VALUES ('".$fecha."',".$id_user.",'".$office."',".$Request["datos"]["type"].",'".$Request["datos"]["fileDescrip"]."','".$data."',". $Request["datos"]["nroRut"].",'".$Request["datos"]["dgvRut"]."','".$Request["datos"]["nameClient"]."','".$Request["datos"]["autorizador"]."','CAP','".$nameUser."','".$office."');");

}

public function formalize() {

    $return = check_session("");

    $this->form_validation->set_rules('numberCapturing', 'Número Captación', 'required|numeric|trim');
    $this->form_validation->set_rules('statusCapturing', 'Estado Captación', 'required|trim');

    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric','El atributo %s debe ser numerico..');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    $id = $this->input->post("numberCapturing");

    $nomqf = $this->session->userdata["username"];
    $rutqf = $this->session->userdata["rut_number"]; $dgvqf = $this->session->userdata["rut_validation"];

    switch ($this->session->userdata("id_rol")) {

        case USER_ROL_JEFE_DE_OFICINA:

            if($this->input->post("statusCapturing")=="accept"):
                $status = "AP";
            else:
                $status = "RE";
            endif;
            break;

        case USER_ROL_EJECUTIVO_COMERCIAL:

            if($this->input->post("statusCapturing")=="accept"):
                $status = "EM";
            else:
                $status = "RB";
            endif;
            break;

        default:

            cancel_function(COD_ERROR_VALID_FORM, "Usuario sin atribuciones para esta transacción..", "");
            break;
    }


    $data["vbqf"] = $status;
    $data["nomqf"] = $nomqf;
    $data["rutqf"] = $rutqf.'-'.$dgvqf;

    $embozado["autorizador"] = 0;

    if($status=="EM"){

        $eval = $this->journal->get_capturingById($id);

        switch ($eval->origen) {

            case SOURCE_CAPTURING_NAME:

                $result = ws_PUT_CapturingById($eval, $data, $nomqf);

                $data["result_code"] = $result["retorno"];
                $data["result_descrip"] = $result["descRetorno"];

                if($result["retorno"]==0) {

                    $nroRut = $eval->rut . "-" . $eval->digitov; 
                    $continue = true;
                    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $nomqf);
                    if ($dataHomologador["retorno"] != 0) {

                        $data["alta_seguro_code"] = $dataHomologador["retorno"];
                        $data["alta_seguro_result"] = $dataHomologador["descRetorno"];
                        $continue = false;
                    }

                    if($continue) {

                        $datos["nameClient"] = $result["nombre"] . " " . $result["apaterno"] . " " . $result["amaterno"];
                        $datos["nroRut"] = $result["rut"];
                        $datos["dgvRut"] = $result["digitov"];
                        $datos["numero_tarjeta"] = $result["pantar"];
                        $datos["type"] = 4;
                        $datos["autorizador"] = $id;
                        $datos["fileDescrip"] = "CAPTACION TARJETA DE CREDITO";
                        $datos["id_product"] = $dataHomologador["id_product"];

                        $contrato = $result["cuenta"];

                        if($eval->indsegdes=="S"){

                            $nroRut = $eval->rut . "-" . $eval->digitov; 

                            $dataInput = array(
                              "tipo" => TIPO_ALTA_SEGURO_DESG,
                              "nroRut" => $nroRut,
                              "username" => $nomqf,
                              "contrato" => $contrato,
                            );

                            $result = ws_PUT_SeguroDesgravamen($dataInput);

                            $data["alta_seguro_code"] = $result["retorno"];
                            $data["alta_seguro_result"] = $result["descRetorno"];

                        }

                        if($datos["numero_tarjeta"]!=""){

                            $result = $this->documents->db_documentsById_delete($datos["autorizador"], "CAP");

                            $dataInput["datos"] = $datos;
                            $result = $this->generaPDFEntrega($dataInput);
                        }

                    }

                }else{

                    $data["vbqf"] = "ER";

                }

            break;

            case SOURCE_PRODUCT_CHANGE_NAME:

                $nroRut = $eval->rut . "-" . $eval->digitov; 
                $dataHomologador = ws_GET_HomologadorByRut($nroRut, $nomqf);
                if ($dataHomologador["retorno"] == 0) {
                    $nroTcv = $dataHomologador["nroTcv"];
                }

                $result = ws_PUT_CapturingById($eval, $data, $nomqf);

                $data["result_code"] = $result["retorno"];
                $data["result_descrip"] = $result["descRetorno"];

                if($result["retorno"]==0) {

                    $nroRut = $eval->rut . "-" . $eval->digitov; 
                    $continue = true;
                    $dataHomologador = ws_GET_HomologadorByRut($nroRut, $nomqf);
                    if ($dataHomologador["retorno"] != 0) {

                        $data["alta_seguro_code"] = $dataHomologador["retorno"];
                        $data["alta_seguro_result"] = $dataHomologador["descRetorno"];
                        $continue = false;
                    }

                    $contrato = $result["cuenta"];
 
                    $datos["nameClient"] = $result["nombre"] . " " . $result["apaterno"] . " " . $result["amaterno"];
                    $datos["nroRut"] = $result["rut"];
                    $datos["dgvRut"] = $result["digitov"];
                    $datos["numero_tarjeta"] = $result["pantar"];
                    $datos["id_product"] = $dataHomologador["id_product"];
                    $datos["type"] = 4;
                    $datos["autorizador"] = $id;
                    $datos["fileDescrip"] = "CAPTACION TARJETA DE CREDITO";

                    if($continue){

                        $flg_flujo = $dataHomologador["flg_flujo"];
                    }

                    if($continue){

                        $dataInput = array(
                            "nroRut" => $nroRut,
                            "contrato" => $contrato,
                            "comercio" => $dataHomologador["id_commerce"],
                            "username" => $nomqf,
                        );

                        $flg_seguro = false;
                        $result = json_decode(ws_GET_ConsultaSegurosContratados($dataInput));
                        if($result->retorno==0){

                            foreach ($result->seguros as $field) {

                                if(substr($field->codigoSeguro,0,4)=="DESG"){
                                    $flg_seguro = true;
                                }
                            }
                        }

                        if(!$flg_seguro AND $eval->indsegdes=="S"){

                            $dataInput["tipo"] = TIPO_ALTA_SEGURO_DESG; 

                            $result = ws_PUT_SeguroDesgravamen($dataInput);

                            $data["alta_seguro_code"] = $result["retorno"];
                            $data["alta_seguro_result"] = $result["descRetorno"];
                        }

                        if($flg_seguro AND $eval->indsegdes=="S"){

                            $dataInput["tipo"] = TIPO_BAJA_Y_ALTA_SEGURO_DESG;

                            $result = ws_PUT_SeguroDesgravamen($dataInput);

                            $data["baja_seguro_code"] = $result["retorno"];
                            $data["baja_seguro_result"] = $result["descRetorno"];

                            $data["alta_seguro_code"] = $result["retorno"];
                            $data["alta_seguro_result"] = $result["descRetorno"];
                        }

                        if($flg_seguro AND $eval->indsegdes=="N"){

                            $dataInput["tipo"] = TIPO_BAJA_SEGURO_DESG;

                            $result = ws_PUT_SeguroDesgravamen($dataInput);

                            $data["baja_seguro_code"] = $result["retorno"];
                            $data["baja_seguro_result"] = $result["descRetorno"];
                        }

                    }

                    if($datos["numero_tarjeta"]!=""){

                        $result = $this->documents->db_documentsById_delete($datos["autorizador"], "CAP");

                        $dataInput["datos"] = $datos;
                        $result = $this->generaPDFEntrega($dataInput);
                    }

                    /*****
                    Bloquea Tarjeta por cambio producto. 
                    ***/
                    if($continue){

                        $dataInput = array(
                          "number_credit_card" => $nroTcv,
                          "code_bloq_credit_card" => CODIGO_BLOQUEO_TARJETA_INACTIVA,
                          "name_bloq_credit_card" => "",
                          "username" => $nomqf);

                        $result = ws_PUT_BlockingCreditCard($dataInput);

                        $data["block_credit_card_code"] = $result["retorno"];
                        $data["block_credit_card_result"] = $result["descRetorno"];
                    }


                }else{

                    $data["vbqf"] = "ER";

                }

            break;

            default:

                $data = array(
                    'centro'=>substr($this->session->userdata('id_office'),-4),
                    'feccadtar'=>0,
                    'indaccion'=>$eval->indaccion,
                    'indesttarol'=>"S",
                    'username'=>$nomqf
                );

                $result = ws_PUT_ReprintCapturing($eval, $data);

                $data = array(
                    'vbqf' => $status,
                    'nomqf'=> $nomqf,
                    'rutqf'=> $rutqf.'-'.$dgvqf,
                    'result_code' => $result["retorno"],
                    'result_descrip' => $result["descRetorno"],
                );

                if($result["retorno"]==0) {

                    $datos["nameClient"] = $eval->nombres . " " . $eval->apellidos;
                    $datos["nroRut"] = $eval->rut;
                    $datos["dgvRut"] = $eval->digitov;
                    $datos["numero_tarjeta"] = $result["pantar"];
                    $datos["type"] = 4;
                    $datos["autorizador"] = $id;
                    $datos["fileDescrip"] = "REIMPRESION TARJETA DE CREDITO";

                    if($datos["numero_tarjeta"]!=""){

                        $nroRut = $eval->rut . $eval->digitov; 
                        $product = ws_GET_HomologadorByRut($nroRut, $this->session->userdata("username"));

                        if($product["retorno"]==0){

                            $datos["id_product"] = $product["id_product"];

                            $result = $this->documents->db_documentsById_delete($datos["autorizador"], "CAP");

                            $dataInput["datos"] = $datos;
                            $result = $this->generaPDFEntrega($dataInput);
                        }

                    }

                }else{

                    $data["vbqf"] = "ER";

                }

            break;
        }

    }


    $result = $this->journal->upd_CapturingById($id, $data, $embozado);
    $data = $result;

    echo json_encode($result);

}

public function valid_reprint_credit_card() {

    $return = check_session("");

    $this->form_validation->set_rules('numberCapturing', 'Número Captación', 'required|numeric|trim');
    $this->form_validation->set_rules('requestCapturing', 'Estado Captación', 'required|trim');

    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    $this->form_validation->set_message('numeric','El atributo %s debe ser numerico..');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    if($this->input->post("requestCapturing")=="reprint"){
        $vbqf = "AP";
    }else{
        $vbqf = "RE";
    }

    $data = array(
        'vbqf'=> $vbqf
    );

    $embozado = array(
        'autorizador' => 0
    );

    $result = $this->journal->upd_CapturingById($this->input->post("numberCapturing"), $data, $embozado);

    $data = $result;

    echo json_encode($data);

}

public function get_preapprovedByRut() {
    
    $return = check_session("");

    $this->form_validation->set_rules('rutClient', 'Número Rut Cliente', 'required|trim');

    $this->form_validation->set_message('required','El atributo %s es obligatorio..');
    if($this->form_validation->run()==false){

        cancel_function(COD_ERROR_VALID_FORM, validation_errors(), "");
    }

    $nroRut = $this->input->post("rutClient"); $username = $this->session->userdata("username");
    $eval = ws_GET_HomologadorByRut($nroRut, $username);

    if($eval["retorno"]!=0){

        cancel_function(COD_ERROR_VALID_FORM, "<h3><strong>Rut ingresado no es cliente Cruz Verde</strong></h3>", "");
    }


    $dataInput = [ 
        "numdoc" => $this->input->post("rutClient"),
        "tipdoc" => "RUT",
        "codProducto" => $eval["id_product"],
        ];
    $capta = ws_GET_CapturingByRut($dataInput);

    if($capta["retorno"]==0) {

        $result = $capta;
        $this->session->userdata("capturing_type", $capta["descam"]);

    } else {

        $result["retorno"] = -1;
        $result["descRetorno"] = "Cliente no registra pre aprobación Tarjeta Cruz Verde ";

    }

    $data = $result;
    echo json_encode($data);

}

private function get_statusCapturing($status){

    $data = [
        "status"=>"NO DISPONIBLE",
        "action"=>"No disponible",
        "situation" => "No Disponible",
        "active"=>"disabled"    ];

    $result = $this->glossary->get_statusCapturingById($status);

    $data["status"] = $result->status;
    $data["situation"] = $result->situation;
    $data["action"] = $result->action;

    if($status=="PE" AND $this->session->userdata("id_rol")==USER_ROL_JEFE_DE_OFICINA):
        $data["active"] = "";
    endif;

    if($status=="AP" AND $this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):
        $data["active"] = "";
    endif;

    if($status=="ER" AND $this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):
        $data["active"] = "";
    endif;

    if($status=="AC" AND $this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):
        $data["active"] = "";
    endif;

    return $data;
}




}
