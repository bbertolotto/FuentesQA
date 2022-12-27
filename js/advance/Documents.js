/**
 *  Document   : Documents.js
 *  Author     : TeknodataSystems
**/
/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {

    $('.btn-modal-request').on('click', function () {

        Client.processShow();
        if($(this).data('target')=="accept"){

          if($("#btn-accept-request").val()=="accept") { $tipoEstado = "PA"; redirect="/advance/search"; }
          if($("#btn-accept-request").val()=="deny") { $tipoEstado = "PE"; redirect="/advance/assignRequest"; }

          $data = "idDocument="+$("#idDocument").val()+"&tipoEstado="+$tipoEstado+"&nroRut="+$("#nroRut").val()+"&reasonDeny=&typeDeny=";
          $.ajax({ url: "/advance/updateEstadoSAV", type: "POST", dataType: "json", data : $data, success: function(response, status, xhr) { if(response.retorno==0) { $.redirect(redirect, { idDocument: $("#idDocument").val(), idEstado: "PE",  nroRut: $("#nroRut").val() } ); } else { Alert.showToastrWarning(response); } Client.processHide(); }, error: function(jqXHR, textStatus, errorThrown) { Alert.showToastrErrorXHR(jqXHR, textStatus); } });

        }    

        Client.processHide();

    });

    $('.btn-action').on('click', function () {
        var theForm = document.getElementById("form-valid");

        if($(this).data('target')=="accept"){

          $("#btn-accept-request").val("accept");
          Alert.showRequest("<h3><strong>ACEPTAR S&#218;PER AVANCE<strong></h3>","<strong><h4>Presione Aceptar para confirmar</h4></strong><br><br>");
          return(false);

        }
        if($(this).data('target')=="deny"){

          $("#btn-accept-request").val("deny");
          Alert.showRequest("<h3><strong>MARCAR PENDIENTE S&#218;PER AVANCE<strong></h3>","<strong><h4>Presione Aceptar para marcar</h4></strong><br><br>");
          return(false);

        }
        if($(this).data('target')=="return"){

          $.redirect("/advance/assignRequest", { idDocument: $("#idDocument").val(), idEstado: "PE",  nroRut: $("#nroRut").val() } ); 

        }
    });

});

var Client = function() {
    return {

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        }
    };
}();

