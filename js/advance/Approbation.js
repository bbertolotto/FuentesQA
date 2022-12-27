/**
/**
 *  Document   : advance/Approbation.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones SAV
**/
$(function () {
    
    $('.btn-accept').on('click', function () {

        Client.processShow();
        $("#btn-accept-request").val("accept");
        Client.checkSave();
        Client.processHide();
    });
    $('.btn-reset').on('click', function () { $.redirect("/advance/search", { idDocument: $("#idDocument").val(), nroRut: $("#nroRut").val(), idEstado: $("#tipoEstado").val() } ) } );


    $('.btn-deny').on('click', function () {

        $("#btn-accept-request").val("deny");
        Alert.showRequest("<h3><strong>MARCAR PENDIENTE S&#218;PER AVANCE<strong></h3>","<strong><h4>Presione Aceptar para marcar</h4></strong><br><br>");
        return(false);

    });


    $('.btn-modal-request').on('click', function () {


        Client.processShow();
        if($(this).data('target')=="accept"){

          if($("#btn-accept-request").val()=="accept") { $tipoEstado = "AU"; redirect="/advance/valid"; }
          if($("#btn-accept-request").val()=="deny") { $tipoEstado = "PE"; redirect="/advance/assignRequest"; }

          $data = "idDocument="+$("#idDocument").val()+"&tipoEstado="+$tipoEstado+"&nroRut="+$("#nroRut").val()+"&reasonDeny=&typeDeny=";
          $.ajax({ url: "/advance/updateEstadoSAV", type: "POST", dataType: "json", data : $data, success: function(response, status, xhr) { if(response.retorno==0) { $.redirect(redirect, { idDocument: $("#idDocument").val(), idEstado: "PE",  nroRut: $("#nroRut").val() } ); } else { Alert.showToastrWarning(response); } Client.processHide(); }, error: function(jqXHR, textStatus, errorThrown) { Alert.showToastrErrorXHR(jqXHR, textStatus); } });

        }    

        Client.processHide();


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

        checkTasa: function() {

            if(Number($("#tasaMaxima").val()) < Number($("#tasaRequest").val())) {

                Alert.showWarning("Cotización vigente excede Tasa Máxima..<br>Crear nueva Cotización!!",""); 


            }


        },


        checkSave: function () {

            var requireOK = 0;
            var yes = document.getElementById("yesSerie");
            if(yes.checked) { requireOK += 1; }

            var yes = document.getElementById("yesNameClient");
            if(yes.checked) { requireOK += 1; }

            var yes = document.getElementById("yesFechaNacimiento");
            if(yes.checked) { requireOK += 1; }

            var yes = document.getElementById("yesTarjetaAdic");
            if(yes.checked) { requireOK += 1; }

            if(requireOK<4){
                toastr.warning("Respuestas Requeridas, no son suficientes ..","Preste Atenci&#243;n.");
                return(false);
            }            

            var yes = document.getElementById("yesDispatch");
            if(!yes.checked) { 
                var requireNOOK = 0;
                var yes = document.getElementById("yesFechaUltCompra");
                if(yes.checked) { requireNOOK += 1; }

                var yes = document.getElementById("yesDiaVencimiento");
                if(yes.checked) { requireNOOK += 1; }

                if(requireOK=4&&requireNOOK<1){
                    toastr.warning("Respuestas Requeridas, no son suficientes ..","Preste Atenci&#243;n.");
                    return(false);
                }
            }

        Alert.showRequest("","<strong><h4>Confirmar Autorizaci&#243;n S&#250;per Avance ?</h4></strong><br><br>");
        return(false);

        },
        prepare: function() {

            $("#yesSerie").attr("checked", false);
            $("#noSerie").attr("checked", true);
            $("#yesNameClient").attr("checked", false);
            $("#noNameClient").attr("checked", true);
            $("#yesFechaNacimiento").attr("checked", false);
            $("#noFechaNacimiento").attr("checked", true);
            $("#yesTarjetaAdic").attr("checked", false);
            $("#noTarjetaAdic").attr("checked", true);
            $("#yesDispatch").attr("checked", false);
            $("#noDispatch").attr("checked", true);

//            $(".btn-print").prop('disabled', true); 

        },
        init: function() {
            $.validator.addMethod("evalrut", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRut( value );
            });
            $('#form-client').validate({
                errorClass: 'help-block animation-slideDown', 
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
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.search();
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
$(function(){ Client.checkTasa(); });
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });

