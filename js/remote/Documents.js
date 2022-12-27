/**
 *  Document   : Documents.js
 *  Author     : TeknodataSystems
**/
/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {

    $('.btn-valid').on('click', function () {
        var theForm = document.getElementById("form-valid");theForm.action=$(this).data('action');theForm.target="_blank";
        if($(this).data('target')=="accept"){
          theForm.submit();
          theForm.action=$(this).data('deny')+"remote/create";theForm.target="";
          theForm.submit();
        }
    });

    $('.btn-print').on('click', function () {
        var theForm = document.getElementById("form-valid");theForm.action=$(this).data('action');theForm.target="_blank";
        if($(this).data('target')=="deny"){
          Alert.showDeny("Detalle Motivo del Rechazo");
        }else{
          theForm.submit();
        }
    });

    $('.btn-action').on('click', function () {
        var theForm = document.getElementById("form-valid");
        var target = $(this).data('target');
        if(target=="accept"){
          if(confirm("Súper Avance aceptado\nNotificación Jefe de Sucursal!")){
          theForm.action=$(this).data('action');
          theForm.submit();}
        }
        if(target=="deny"){
          if(confirm("Súper Avance rechazado\nVolver a negociar!")){
          theForm.action=$(this).data('action');
          theForm.submit();}
        }
        if(target=="return"){
          if(confirm("Volver a negociar")){
          theForm.action=$(this).data('action');
          theForm.submit();}
        }
    });

});

function sleep(milliseconds) {
 var start = new Date().getTime();
 for (var i = 0; i < 1e7; i++) {
  if ((new Date().getTime() - start) > milliseconds) {
   break;
  }
 }
}
