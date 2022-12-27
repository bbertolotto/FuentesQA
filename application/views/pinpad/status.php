<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<meta http-equiv="Access-Control-Allow-Origin" content="*">
<?php $this->load->view('head'); ?>
<div id="page-content">


    <ul class="breadcrumb breadcrumb-top">
        <li><strong><?= $this->lang->line('Capturing Flows');?></strong></li>
        <li><a href="/capturing/search"><strong><?= $this->lang->line('Search');?></strong></a></li>
        <li><a href="/capturing/preapproved"><strong><?= $this->lang->line('Capturing');?></strong></a></li>
        <li><a href="/capturing/documents"><strong><?= $this->lang->line('Documents');?></strong></a></li>
        <li><strong>Activar Tarjeta</strong></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">

      <div id="alertPlaceholder"></div>

      <!-- Typeahead Block -->
      <div class="block">
          <!-- Typeahead Title -->
          <div class="block-title">
              <div class="block-options pull-right">
                  <h2>Modo: <strong><?= $this->session->userdata('attention_mode');?></strong></h2>
              </div>
              <h2><strong>Activación Tarjeta Crédito VISA</strong></h2>
          </div>
          <!-- END Typeahead Title -->

          <!-- Typeahead Content -->
          <form id="form-client" method="post" class="form-horizontal form-bordered" onsubmit="return false;">

              <div class="form-group">
                  <div class="col-md-9 col-md-offset-3">
                      <button type="button" class="btn-get-card btn btn-lg btn-warning"><i class="gi gi-credit_card"></i> Deslizar Tarjeta</button>
                      <button type="button" class="btn-get-pin btn btn-lg btn-warning"><i class="gi gi-keys"></i> Ingresar Clave Seguridad</button>
                      <button type="button" class="btn-get-hsm btn btn-lg btn-warning"><i class="fa fa-lock"></i> Activar Tarjeta</button>
                      <button type="button" class="btn-cancel btn btn-lg btn-success"><i class="fa fa-times"></i> Cancelar</button>
                  </div>
              </div>

              <input type="hidden" id="CardNumber" name="CardNumber" value="">
              <input type="hidden" id="CardNumber12" name="CardNumber12" value="">
              <input type="hidden" id="canal" name="canal" value="FLU">
              <input type="hidden" id="pinBlockPinera" name="pinBlockPinera" value="">
              <input type="hidden" id="pinKSN" name="pinKSN" value="">

          </form>
          <!-- END Typeahead Content -->
      </div>
      <!-- END Typeahead Block -->
    </div>


</div>
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalValid'); ?>

<!-- End page-content-->
<!-- Javascript exclusivos para esta página -->

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>

<script language="javascript">

var PlaceHolder = function () {
  return {

      Alert: function(type, button, message) {
        var wrapper = document.getElementById('alertPlaceholder');
        wrapper.innerHTML = '<div class="alert alert-'+type+'"><h4><i class="'+button+'"></i> '+message+'</h4></div>';
      }
  }

}();

$(function () {

    $('.btn-get-card').on('click', function () {

        PlaceHolder.Alert('info', 'fa fa-asterisk fa-spin', '<strong>Atenci&#243;n</strong>, deslice tarjeta por lector PINERA...');

        var formData = new FormData();
        formData.append('data', '{"Store":0,"Amount":123400,"Currency":"CL","CardType":"CR"}');

        var response = Teknodata.call_ajax("http://localhost:8123/PinpadBridge/LecturaTarjeta", formData, false, true, ".btn");
        if(response!=false){

          if(response.ResponseCode==0){

/****{
"ResponseCode":0,
"ResponseDescription":"OK",
"CaptureType":"...",
"CardHolderName":"...",
"CardNumber":"...",
"CardTypeAbbreviation":"..",
"CardTypeName":"...",
"Track1":"...",
"Track2":"..."}
***/

              let Track2 = response.Track2;
              let CardNumber = Track2.substring(1, 17);
              let CardNumber12 = Track2.substring(4,16);

              PlaceHolder.Alert('success', 'fa fa-check', '<strong>Atenci&#243;n,</strong> Banda leida correctamente!! <strong><i class="fa fa-play"></i> a continuaci&#243;n solicite ingresar clave secreta para activaci&#243;n de la tarjeta!</strong>');

              $("#CardNumber").val(CardNumber);
              $("#CardNumber12").val(CardNumber12);

          }else{


              var message = "<strong>Error,</strong> " + response.ResponseDescription + "</br></br><h6><strong><?php echo ATENTION_HELPDESK ?></strong></h6>" ;
              PlaceHolder.Alert('warning', 'fa fa-times', message);
          }

        }else{


          PlaceHolder.Alert('danger', 'fa fa-times', '<strong>Error</strong>, Programa Controlador Pinera no responde o no instalado en este equipo... </br></br><h6><strong><?php echo ATENTION_HELPDESK ?></strong></h6>');

        }

    return(true);

    });

    $('.btn-cancel').on('click', function () {

      location.reload(true);

    });

    $('.btn-get-pin').on('click', function () {

        PlaceHolder.Alert('info', 'fa fa-asterisk fa-spin', '<strong>Atenci&#243;n</strong>, Solicite a cliente ingresar clave secreta de 4 digitos y presionar bot&#243;n verde..');

        var formData = new FormData();
        formData.append('data', '{"PinLength":4,"PinBlockType":2,"Message":["<----LINE 1---->","<----LINE 1---->"]}');

        var response = Teknodata.call_ajax("http://localhost:8123/PinpadBridge/LecturaPin", formData, false, true, ".btn");

        if(response!=false){

          if(response.ResponseCode==0){

            PlaceHolder.Alert('info', 'fa fa-asterisk fa-spin', '<strong>Atenci&#243;n,</strong> Clave secreta leida correctamente <strong><i class="fa fa-play"></i> a continuación, active tarjeta..');
/**
            alert("Code: " + response.ResponseCode);
            alert("Description: " + response.ResponseDescription);
            alert("PinBlock: " + response.PinBlock);
            alert("KSN: " + response.KSN);
            alert("Other: " + response.Other);
***/
            $("#pinBlockPinera").val(response.PinBlock);
            $("#pinKSN").val(response.KSN);

          }else{

              var message = "<strong>Error,</strong> " + response.ResponseDescription + "</br></br><h6><strong><?php echo ATENTION_HELPDESK ?></strong></h6>" ;
              PlaceHolder.Alert('warning', 'fa fa-times', message);
          }

        }else{

          PlaceHolder.Alert('danger', 'fa fa-times', '<strong>Error</strong>, Programa Controlador Pinera no responde o no instalado en este equipo... </br></br><h6><strong><?php echo ATENTION_HELPDESK ?></strong></h6>');

        }

    return(true);

    });


    $('.btn-get-hsm').on('click', function () {

        PlaceHolder.Alert('info', 'fa fa-asterisk fa-spin', '<strong>Atenci&#243;n,</strong> Clave secreta leida correctamente <strong><i class="fa fa-play"></i> espere, estamos validando la tarjeta, paso 1 de 2..');

        var formData = new FormData();
        formData.append('pinBlockPinera', $("#pinBlockPinera").val());
        formData.append('panPinera', $("#CardNumber12").val());
        formData.append('keySerialNumber', $("#pinKSN").val());
        formData.append('canal', $("#canal").val());

//        alert("panPinera: " + $("#CardNumber12").val() + " pinBlockPinera: " + $("#pinBlockPinera").val() + " KSN: " + $("#pinKSN").val() );

        var response = Teknodata.call_ajax("/capturing/apiHSM", formData, false, true, ".btn");

        if(response!=false){

          if(response.retorno==0){

            PlaceHolder.Alert('info', 'fa fa-asterisk fa-spin', '<strong>Atenci&#243;n,</strong> Clave secreta leida correctamente <strong><i class="fa fa-play"></i> espere, estamos activando la tarjeta, paso 2 de 2..');

            var formData = new FormData();
            formData.append('panPinera', $("#CardNumber").val());
            formData.append('pinBlockMinsait', response.pinBlockMinsait);

     //       alert("panPinera: " + $("#CardNumber").val() + " pinBlockMinsait: " + response.pinBlockMinsait );

            var response = Teknodata.call_ajax("/capturing/pinpadTA", formData, false, true, ".btn");

            if(response!=false){

              if(response.retorno==0){

                PlaceHolder.Alert('success', 'fa fa-check', '<strong>Atenci&#243;n,</strong> Tarjeta activada con éxito..');

              }else{

                var message = "<strong>Error,</strong> " + response.descRetorno + "</br></br><h6><strong><?php echo ATENTION_HELPDESK ?></strong></h6>" ;
                PlaceHolder.Alert('warning', 'fa fa-times', message);

                return (false);

              }

            }

          }else{

              var message = "<strong>Error,</strong> " + response.descRetorno + "</br></br><h6><strong><?php echo ATENTION_HELPDESK ?></strong></h6>" ;
              PlaceHolder.Alert('warning', 'fa fa-times', message);

              return (false);
          }

        }

    return (true);
    });




});


$(document).ready(function(){

    var formData = new FormData();
    formData.append("data", "{}");

    PlaceHolder.Alert('info', 'fa fa-asterisk fa-spin', '<strong>Atenci&#243;n</strong>, verificando estado PINERA... espere....</h4>');

    var response = Teknodata.call_ajax("http://localhost:8123/PinpadBridge/ConsultaEstado", formData, false, true, ".btn");
    if(response!=false){

      if(response.ResponseCode==0){

          PlaceHolder.Alert('success', 'fa fa-check', '<strong>Atenci&#243;n</strong> Pinera esta encendida y lista!!');

      }else{

          var message = "<strong>Error,</strong> " + response.ResponseDescription + "</br></br><h6><strong><?php echo ATENTION_HELPDESK ?></strong></h6>" ;
          PlaceHolder.Alert('warning', 'fa fa-times', message);
          $('.btn-warning').prop('disabled', true);
      }

    }else{

      PlaceHolder.Alert('danger', 'fa fa-times', '<strong>Error</strong>, Programa Controlador Pinera no responde o no instalado en este equipo... </br></br><h6><strong><?php echo ATENTION_HELPDESK ?></strong></h6>');
      $('.btn-warning').prop('disabled', true);

    }
  
});
</script>


</body>
</html>
