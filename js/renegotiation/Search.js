/**
/**
 *  Document   : renegotiation/Search.js
 *  Author     : TeknodataSystems
**/
var id = 0;
$(function () {

    $(".btn-modal-renegotiation").on("click", function () {


        if($(this).data('target')=="accept") {

            $('#trackingRenegotiation tbody').empty();
            var formData = new FormData();
            formData.append("id", $("#idRefinanciamiento").val());
            var response = Teknodata.call_ajax("/renegotiation/passRenegotiation", formData, false, true, ".btn-modal-renegotiation");

            if(response!=false){

                $('#trackingRenegotiation tbody').empty();
                $('#trackingRenegotiation tbody').append(response.htmlTags);
            }

        }else{

            $(".close").click();
            Client.search();
        }

        return(false);
    });


    $(".btn-modal-request").on("click", function () {

        if($("#id_upd").val()=="pass"){

            if($(this).data('target')=="accept") {

                var formData = new FormData();
                formData.append("id", $("#idRefinanciamiento").val());
                var response = Teknodata.call_ajax("/renegotiation/passRenegotiation", formData, false, true, ".btn-modal-request");

                if(response!=false){

                    Alert.showWarning("", response.descRetorno, "md");
                    if(response.retorno==0){ $(".btn-success").click(); }
                }
            }
        }

        if($("#id_upd").val()=="deny"){

            if($(this).data('target')=="accept") {

                var formData = new FormData();
                formData.append("id", $("#idRefinanciamiento").val());
                formData.append("codeDeny", $("#codeDeny").val());
                var response = Teknodata.call_ajax("/renegotiation/denyRenegotiation", formData, false, true, ".btn-modal-request");

                if(response!=false){

                    Alert.showWarning("", response.descRetorno, "md");
                    if(response.retorno==0){ $(".btn-success").click(); }
                }
            }
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
        },
        evaluate: function() {
          if($("#masked_rut_client").val().value==""&&$("#status").val()==""&&$("#dateBegin").val().value==""){
              toastr.warning("Para realizar una busqueda debe ingresar al menos un atributo ..","Preste Atencíón..");
          }else{return(true);}
        },
        prepare: function() {
          document.getElementById("client-details").style.display = "none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display = "";
        },
        editRenegotiation: function($id, $nroRut){

          Client.processShow();
          $.redirect("/renegotiation/auditnegotiation", { id: $id, nroRut: $nroRut } );

        },
        createRenegotiation: function() {

          Client.processShow();
          $.redirect("/renegotiation/negotiation");

        },
        denyException: function($id) {

              $("#idRefinanciamiento").val($id);
              $("#id_upd").val("deny");

              $htmlDeny = '<fieldset><center>';
              $htmlDeny+= '<h4><strong>Rechazar Excepción para Renegociación N° '+$id+'</strong></h4></br>';
              $htmlDeny+= '<label for="status">Motivo Rechazo</label>';
              $htmlDeny+= '<select id="codeDeny" name="codeDeny" class="form-control text-center" style="width:300px;">';
              $htmlDeny+= '    <option value="No cumple abono">No cumple abono</option>';
              $htmlDeny+= '    <option value="No cumple dias mora">No cumple días mora</option>';
              $htmlDeny+= '    <option value="Nro. de Renegociaciones">Nro. de Renegociaciones</option>';
              $htmlDeny+= '    <option value="No Cumple Monto Deuda">No Cumple Monto Deuda</option>';
              $htmlDeny+= '</select></fieldset></center></br>';
              Alert.showRequest($htmlDeny,"");
        },

        confirmScript: function($id) {

            Client.processShow();
            $.redirect("/renegotiation/script", { id: $id } );

        },
        selectRequest: function() {

            return(false);
        },
        passException: function($id) {

              $("#idRefinanciamiento").val($id);
              $("#id_upd").val("pass");
              Alert.showRequest("<h4><strong>Aprobar Excepción para Renegociación N° "+$id+"</strong></h4>","");

        },
        showScript: function($id) {
            var formData = new FormData();
            formData.append("id", $id);
            var response = Teknodata.call_ajax("/renegotiation/showSCRenegotiation", formData, false, true, "");

            if(response!=false){

                if(response.retorno==0){

                    Alert.showWarning("", response.htmlScript, "lg");

                }else{

                    Alert.showWarning("", response.descRetorno, "md");
                }
            }

        },
        clearInput: function () {
            $("#masked_rut_client").val(""); $("#dateBegin").val(""); $("#dateEnd").val(""); $("#status").val("");
            $("#tabRenegotiation").html("");
        },
        search: function() {
            $data = $("#form-client").serialize(); Client.prepare();
            var response = Teknodata.call_ajax("/renegotiation/get_renegotiation", $data, false, false, ".btn");
            if(response!=false){

                  Client.restore();
                  $("#tabRenegotiation").html(response.dataResponse);

            }else{

                  $("#tabRenegotiation").html("");
            }

        },
        init: function() {
            $.validator.addMethod("evalrut", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRut( value );
            });
            $('#form-client').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                unhighlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.prepare();Client.search();
                },
                rules: {
                    masked_rut_client: {required: false, evalrut: true, minlength: 5, maxlength: 12},
                },
                messages: {
                    masked_rut_client: {required:'Ingrese número RUT', evalrut:'Ingrese RUT valido!'},
                }
            });

        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
