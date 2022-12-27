/**
 *  Document   : approbation.js
 *  Author     : TeknodataSystems
**/
/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {

    $('.btn-action').on('click', function () {
        var theForm = document.getElementById("form-valid");
        var target = $(this).data('target');
        if(target=="accept"){
          if(confirm("Autorización aceptado\nActivar Liquidación")){
          theForm.action=$(this).data('action');
          theForm.submit();}
        }
        if(target=="return"){
          if(confirm("Volver a SAV")){
          theForm.action=$(this).data('action');
          theForm.submit();}
        }
    });

});

function onoffSerieRut(id) {
  var a = document.getElementById("sel_serierut"+id);
    alert(a.checked);

}
