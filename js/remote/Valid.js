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
        if(target=="liquid"){
          Alert.showAlert("Liquidaci&#243;n Aceptada !");
        }
        if(target=="denied"){
          Alert.showAlert("Liquidaci&#243;n Rechazada !");
        }
    });

});
