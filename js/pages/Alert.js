/*
 *  Document   : Alert.js
 *  Author     : TeknodataSystems
 */


var modal_size_xs = "xs";
var modal_size_sm = "sm";
var modal_size_md = "md";
var modal_size_lg = "lg";


var errors = [
  10,
  100,
  101,
  102,
  103,
  20,
  200,
  201,
  202,
  203,
  30,
  300,
  301,
  302,
  303,
  401,
  500
  ];
var messages = [
  "Debe Ingresar un RUT Valido.",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Debe Ingresar un RUT Valido.",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Rut ingresado no es cliente Cruz Verde",
  "Rut ingresado no es cliente Cruz Verde",
  "Rut ingresado no es cliente Cruz Verde",
  "Rut ingresado no es cliente Cruz Verde",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "Consulta no pudo ser procesada contactese con Mesa de Ayuda",
  "El registro que intenta guardar ya existe!",
  ];
var titles = [
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada",
  "Transacci&#243;n Rechazada"
  ];

var Alert = function() {
    return {

        showMessage: function (tt, ti, ty, tm) {

            Teknodata.swal_title_message(tt, tm, "info");
        },
        showToastrWarning: function(response) {

            if(response.retorno==600){

                $('.modal-access').modal({show:true,backdrop:'static'});

            }else{


              toastr.error('<br><strong>'+response.descRetorno+'</strong>','Preste Atenci&#243;n');

            }

        },

        getMessageError: function(codError){

            var message = "";
            errors.forEach(function (eError, iError, aError) {
              if(eError==codError) {
                messages.forEach(function (eMessage, iMessage, aMessage) {
                  if(iError==iMessage) { message=eMessage; console.log(eMessage, iMessage); }
                });
              }
            });
            return(message);
        },

        getTitleError: function(codError){

            var message = "";
            errors.forEach(function (eError, iError, aError) {
              if(eError==codError) {
                titles.forEach(function (eMessage, iMessage, aMessage) {
                  if(iError==iMessage) { message=eMessage; console.log(eMessage, iMessage); }
                });
              }
            });
            return(message);
        },

        showToastrError: function(response) {

          if(response.retorno==600){

              $('.modal-access').modal({show:true,backdrop:'static'});

          }else{

              toastr.error('<br><strong>'+response.descRetorno+'</strong>','Preste Atenci&#243;n');

          }

        },

        showToastrErrorXHR: function(jqXHR, textStatus) {

            if (jqXHR.status === 0) {

            var descRetorno = "Sin conexión, verificar la Red";

            } else if (jqXHR.status == 404) {

            var descRetorno = "Solicitud, no existe en servidor [404]";

            } else if (jqXHR.status == 500) {

            var descRetorno = "Error interno al procesar solicitud [500]" + "\n" + jqXHR.responseText;

            } else if (textStatus === 'parsererror') {

            var descRetorno = "Problema al procesar Solicitud.." + "\n" + jqXHR.responseText;

            } else if (textStatus === 'timeout') {

            var descRetorno = "Solicitud excede tiempo de espera..";

            } else if (textStatus === 'abort') {

            var descRetorno = "Solicitud fue abortada..";

            } else {

            var descRetorno = "Solicitud no procesada, [" + jqXHR.responseText + "]";

            }

            Teknodata.swal_title_message("Error!", descRetorno, "error");
        },

        showToastrSuccess: function(response, title) {
            toastr.success(response.descRetorno, title);
        },
        showBeneficiary: function(message) {

          $('.modal-beneficiary .modal-dialog').addClass("modal-md");
          $('.modal-beneficiary').modal({show:true,backdrop:'static'});

        },
        showDeny: function(message) {
          var e = document.getElementById('body-modal-deny');
          e.innerHTML="<h5><strong>"+message+"</strong></h5>";
          $('.modal-deny').modal({show:true});
        },
        showAlert: function(message) {
          var e = document.getElementById('body-modal-alert');
          if(message=="1") { message="No puede visualizar detalle cotización por no estar vigente!"; }
          e.innerHTML="<h4><strong>"+message+"</strong></h4>";
          $('.modal-alert').modal({show:true});
        },
        showWarning: function(title,message,size) {
          var e = document.getElementById('body-modal-alert');
          e.innerHTML="<h2><strong>"+title+"</strong></h2>";
          e.innerHTML+="<h4>"+message+"</h4>";

          if(size=="xs"){ $('.modal-alert .modal-dialog').addClass("modal-xs"); }
          if(size=="sm"){ $('.modal-alert .modal-dialog').addClass("modal-sm"); }
          if(size=="md"){ $('.modal-alert .modal-dialog').addClass("modal-md"); }
          if(size=="lg"){ $('.modal-alert .modal-dialog').addClass("modal-lg"); }

          $('.modal-alert').modal({show:true});
        },
        init: function() {
          e = document.getElementById("btn-modal-error");e.style.display = "";
          e = document.getElementById("btn-modal-accept_client");e.style.display = "none";
          e = document.getElementById("btn-modal-cancel_client");e.style.display = "none";
          e = document.getElementById("btn-modal-accept_noclient");e.style.display = "none";
          e = document.getElementById("btn-modal-cancel_noclient");e.style.display = "none";
        },
        initaccept_client: function() {
          e = document.getElementById("btn-modal-error");e.style.display = "none";
          e = document.getElementById("btn-modal-accept_noclient");e.style.display = "none";
          e = document.getElementById("btn-modal-cancel_noclient");e.style.display = "none";
          e = document.getElementById("btn-modal-accept_client");e.style.display = "";
          e = document.getElementById("btn-modal-cancel_client");e.style.display = "";
        },
        initaccept_noclient: function() {
          e = document.getElementById("btn-modal-error");e.style.display = "none";
          e = document.getElementById("btn-modal-accept_noclient");e.style.display = "";
          e = document.getElementById("btn-modal-cancel_noclient");e.style.display = "";
          e = document.getElementById("btn-modal-accept_client");e.style.display = "none";
          e = document.getElementById("btn-modal-cancel_client");e.style.display = "none";
        },
        showReason: function(){
          e = document.getElementById("reasonSkill");
          if(e.value==115999){
              e = document.getElementById("reasonDetail"); e.value=""; e.style.display = "";
          }else{
              e = document.getElementById("reasonDetail"); e.style.display = "none";e.value="";
          }
        },
        showLinked: function(title,html) {
          //var e = document.getElementById("htmlRequest");
          //e.innerHTML=html;
          //e = document.getElementById("title");
          //e.innerHTML=title;
          $('.modal-link').modal({show:true,backdrop:'static'});
        },
        showRequest: function(titleRequest,htmlRequest) {
          var e = document.getElementById("htmlRequest");
          e.innerHTML=htmlRequest; e = document.getElementById("titleRequest"); e.innerHTML=titleRequest;
          $('.modal-request').modal({show:true,backdrop:'static'});
        },
        showSearch: function(title,html) {
          var e = document.getElementById("body-modal-search");
          e.innerHTML=html;
          $('.modal-search').modal({show:true});
        },
        showAdvance: function(title,html) {
          var e = document.getElementById("body-modal-advance");
          e.innerHTML=html;
          $('.modal-advance').modal({show:true,backdrop:'static'});
        },
        showLink: function() {
          var e = document.getElementById("body-modal-link");
          $('.modal-link').modal({show:true,backdrop:'static'});
        },
        showError: function(m) {
          var e = document.getElementById("body-modal-search");
          e.innerHTML="<h2><strong>Servicios No Disponibles</strong></h2></br>";
          e.innerHTML+="<h3><strong>Comuniquese con Mesa de Ayuda</strong></h3></br>";
          e.innerHTML+="<strong>"+m+"</strong>";
          $('.modal-search').modal({show:true,backdrop:'static'});
        },

        showAcceptRenegotiation: function(id) {

          $("#idRefinanciamiento").val(id);
          $('#trackingRenegotiation tbody').empty();
          $('.accept-renegotiation').modal({show:true,backdrop:'static'});

        }

    }
}();
$(function(){ Alert.init(); });
