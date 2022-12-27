<?php

function check_session($selector){

    $CI = get_instance();

    if($CI->session->userdata("lock")===NULL) {

        if( $CI->input->is_ajax_request() ) {
            $data["retorno"] = -1;
            $data["base_url"] = base_url();
            echo json_encode($data);
            exit(0);

        }else{

            redirect(base_url());

        }
    }

    if($CI->session->userdata("lock") == "0") {

        if( $CI->input->is_ajax_request() ) {
            $data["retorno"] = -1;
            $data["base_url"] = base_url("dashboard/lock");
            echo json_encode($data);
            exit(0);

        }else{

            redirect(base_url("dashboard/lock"));

        }
    }

    if($selector!=""){
        $CI->session->set_userdata('selector', $selector);
    }

    return (TRUE);
}


function set_cookie($name_cookie, $value_cookie) {

    $CI = get_instance();
    $CI->load->helper('cookie');

    $cookie= array(
      'name'   => $name_cookie,
      'value'  => $value_cookie,
      'expire' => '3600',
      'secure' => TRUE
    );

    $CI->input->set_cookie($cookie);

    return (TRUE);
}

function validate_phone($number_phone){

    if(strlen($number_phone)>9){ $number_phone = substr($number_phone, -9);}
    if($number_phone!=""){
        if(substr($number_phone,0,1)=="9"){
            $result = get_ValidatePhoneMobile($number_phone);
        }else{
            $result = get_ValidatePhonePermanent($number_phone);
        }
        if($result["retorno"]!=0){

            return (false);

        }else{

            return (true);
        }
    }else{

        return (false);
    }

}

function get_cookie($name_cookie) {
  $CI = get_instance();
  $CI->load->helper('cookie');

  $result = $CI->input->cookie($name_cookie, TRUE);

  return ($result);
}

function cancel_function ($retorno, $descRetorno, $action) {

    $CI = get_instance();
    if($CI->input->is_ajax_request()){

        $value['retorno'] = $retorno;
        $value['descRetorno'] = $descRetorno;
        $value['action'] = $action;
        $data = $value;
        echo json_encode($data);
        exit(0);

    }else{

       $CI->session->set_flashdata('warning_message', $descRetorno);
       redirect(base_url('dashboard/noaccess'));

    }

}

function validaRUTCL($nroRut) {

  $dgvRut = substr($nroRut, -1);
  $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut); $nroRut = substr($nroRut, 0, -1);
  $r = new Rut(); $r->number($nroRut);
  $dgv = $r->calculateVerificationNumber();
  if($dgvRut!=$dgv){
      $value["retorno"] = -1;
      $value["descRetorno"] = "Validación RUT Cliente, No es valida!";
  } else {
    $value["retorno"] = 0;
    $value["descRetorno"] = "Validación RUT Cliente, Es Correcta..";
  }

  $data = $value;
  return $data;

}

function digitoRUTCL($nroRut) {

  $nroRut = str_replace('.', '', $nroRut); $nroRut = str_replace('-', '', $nroRut);

  $r = new Rut(); $r->number($nroRut);
  $dgv = $r->calculateVerificationNumber();
  $value["retorno"] = 0;
  $value["descRetorno"] = "Digito Verificador RUT ".$nroRut." es [". $dgv."]";
  $value["dgvRut"] = $dgv;

  $data = $value;
  return $data;

}
