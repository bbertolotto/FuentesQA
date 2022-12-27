/**
/**
 *  Document   : renegotiation/Script.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/

$(function () {

    $('.btn-modal-renegotiation').on('click', function () {

        if($(this).data('target')!="cancel") {

        }

    $(".close").click();
    });


    $('.btn-return').on('click', function () {

        Client.processShow();
        $.redirect("/renegotiation/auditnegotiation", { id: $("#authorizing").val(), nroRut: $("#number_rut_client").val() } );

    });

    $(".btn-modal-request").on("click", function () {

        if($(this).data('target')=="accept") {

            var formData = new FormData();
            formData.append("id", $("#authorizing").val());
            formData.append("id_client", $("#id_client").val());
            formData.append("reasonDeny", $("#reasonDeny").val());
            var response = Teknodata.call_ajax("/renegotiation/denyScriptRenegotiation", formData, false, true, ".btn-script");
            if(response!=false){
                $(".close").click();
                Alert.showWarning("", response.descRetorno, "md");
            }
        }else{
            $(".close").click();
        }
        return(false);
    });

    $('.btn-script').on('click', function () {

        if($(this).data('target')=="cancel"){
          $htmlDeny = '<fieldset><center>';
          $htmlDeny+= '<h4><strong>Rechazar Script para Renegociación N°'+$("#authorizing").val()+'</strong></h4></br>';
          $htmlDeny+= '<label for="status">Motivo Rechazo</label>';
          $htmlDeny+= '<select id="reasonDeny" name="reasonDeny" class="form-control text-center" style="width:300px;">';
          $htmlDeny+= '    <option value="No cumplimiento de script">No cumplimiento de script</option>';
          $htmlDeny+= '    <option value="Audio con problemas">Audio con problemas</option>';
          $htmlDeny+= '    <option value="No Cumple Abono">No Cumple Abono</option>';
          $htmlDeny+= '</select></fieldset></center></br>';
          Alert.showRequest($htmlDeny,"");
        }
        if($(this).data('target')=="accept"){
          var formData = new FormData();
          formData.append("id", $("#authorizing").val());
          formData.append("id_client", $("#id_client").val());
          var response = Teknodata.call_ajax("/renegotiation/passScriptRenegotiation", formData, false, true, ".btn-script");
          if(response!=false){
              Alert.showWarning("", response.descRetorno, "md");
          }
        }
        return(false);

    });

    $(".btn-save").on("click", function () {

        if(!Client.validScript("form-client")){
              Alert.showWarning("", "Antes de Aceptar debe confirmar todas las preguntas del Script","md");
              return(false);
        };

        var formData = new FormData();
        formData.append("id", $("#authorizing").val());
        formData.append("script", $("#script").html());

        var response = Teknodata.call_ajax("/renegotiation/confirmRenegotiation", formData, false, true, "");

        if(response!=false){

            if(response.retorno==0){

                $.redirect("/renegotiation/authorization", { id: $("#authorizing").val() } );

            }else{

                $.alert({
                     title: 'Error!',
                     icon: 'fa fa-warning',
                     type: 'orange',
                     content: 'Al intentar validar Script Renegociaci&oacute;n.<br><br>' + response.descRetorno,
                });
            }

        }
        return(false);

    });


});

var Client = function() {
    return {

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },

        prepare: function() {

          Client.clearForm("form-client");
        },

        clearForm: function(nameForm) {
            var form  = document.getElementById(nameForm);
            for (var i=0;i<form.elements.length;i++) {
                if(form.elements[i].type == "text") form.elements[i].value = "";
            }
        },
        validScript: function(nameForm) {
            var form  = document.getElementById(nameForm);
            for (var i=0;i<form.elements.length;i++) {
                if(form.elements[i].type == "checkbox") {
                    if(!form.elements[i].checked){ return(false); };
                }
            }
            return(true);
        }

    };
}();
$(function(){ Client.processHide(); });
