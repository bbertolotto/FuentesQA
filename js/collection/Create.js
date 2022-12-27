/**
/**
 *  Document   : renegotiation/Negotiation.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/

$(function () {

    $('#btn-cancel-request').on('click', function () {

          Client.prepare();
    });


    $('.btn-save').on('click', function () {

        Client.saveCollection();
    });

    $('.btn-return').on('click', function () {

        $.redirect("/collection");

    });

    $('.btn-reset').on('click', function () { Client.prepare(); });


});

var Client = function() {
    return {

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },

        showQuota: function() {

            var title = "Cupos Disponibles"; var messages = $('#htmlCupos').val(); var window_size = "xs";
            Alert.showWarning( title, messages, window_size);
            return(false);

        },
        saveCollection: function() {
            var formData = new FormData();
            var title = "Preste Atención"; var messages = ""; var window_size = "md";

            if($('#masked_rut_client').val()==""){ 
                    messages = "Debe ingresar RUT Cliente, antes de Grabar Mora Virtual..";
                    Alert.showWarning(title, messages, window_size); return(false); 
            }

            formData.append("number_rut_client",$("#masked_rut_client").val());
            formData.append("dateEnd",$("#dateEnd").val());
            formData.append("reason",$("#reasonSelector").val());

            var response = Teknodata.call_ajax("/collection/validate_save_collection", formData, false, true, ".btn-save");
            if(response!=false){

                var title = "Preste Atención"; var messages = response.descRetorno; var window_size = "md";
                Alert.showWarning(title, messages, window_size);
                Client.prepare();

            }
            return (true);
        },

        loadOffers: function(response) {

            $("#datajson").val(JSON.stringify(response));

            /*Datos de Contacto Cliente*/
            $("#label_nameClient").val(response.completeNameClient);
            $("#email").val(response.email);
            $("#number_phone").val(response.phone);
            $("#nameClient").val(response.nameClient);
            $("#lastnameClient").val(response.lastnameClient);
            $("#sexoClient").val(response.sexoClient);
            $("#number_pan").val(response.nroTcv);
            $("#nroTcv").val(response.nroTcv);
            $("#days_over").val(response.diasMora);
            $("#lblDireccion").val(response.lblDireccion);
            $("#address").val(response.lblDireccion);
            $("#flg_flujo").val(response.flg_flujo);

            /*Datos productos del cliente*/
            $('#tabAccount').html(response.dataAccount);
            $('#tabSecure').html(response.dataSecure);
            $('#tabPayment').html(response.dataPayment);
            $("#htmlCupos").val(response.htmlCupos);
            $("#htmlDetalle").val(response.htmlDetalle)

            /*Activa botones de acción*/
            $(".btn-save").prop('disabled', false);
            $(".btn-return").prop('disabled', false);

            /*Inicializa Ventanas Datos Cliente*/
            $("#situation").collapse("show");
            $("#client").collapse("show");
            $("#payment").collapse("show");
            $("#secure").collapse("show");

            $("#flg_client").val(1);
            $("#flg_type").val("N");

            if(response.warning_message!=""){
                $("#flg_type").val(response.warning_type);
                Alert.showRequest(response.warning_title, response.warning_message);
            }

        },
        prepare: function() {

          Client.clearForm("form-client"); Client.clearForm("form-virtual");

          $("#masked_rut_client").prop('disabled', false); $("#emailClient").prop('disabled', true); $("#phoneClient").prop('disabled', true); $("#approbation").click();

          $("#label_1").html(""); $("#label_2").html(""); $("#label_3").html(""); $("#label_4").html("");

          /*Desactiva botones de acción*/
          $(".btn-save").prop('disabled', false);
          $(".btn-return").prop('disabled', false);

          /*Inicializa Ventanas Datos Cliente*/
          $("#situation").collapse("hide");
          $("#client").collapse("hide");
          $("#payment").collapse("hide");
          $("#secure").collapse("hide");

          $("#flg_client").val(0);
          $("#masked_rut_client").focus();
            
        },
        clearForm: function(nameForm) {
            var form  = document.getElementById(nameForm);
            for (var i=0;i<form.elements.length;i++) {
                if(form.elements[i].type == "text") form.elements[i].value = "";
            }
        },
        selectRequest: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idRequest = tabTD[1].innerText;
            var idCheck = "sel"+idRequest;
            document.getElementById(idCheck).checked = true;
        },
        get_ClientByRut: function() {
            Client.search();
        },
        search: function() {

            var formData = new FormData();
            var rut = $("#masked_rut_client").val(); Client.prepare(); $("#masked_rut_client").val(rut); $("#masked_rut_client").prop('disabled', true);

            formData.append("nroRut", rut);
            var response = Teknodata.call_ajax("/collection/evaluation_client", formData, false, true, "#masked_rut_client");

            if(response!=false){

                if(response.retorno==0) {

                    Client.loadOffers(response);
                    $("#masked_rut_client").prop('disabled', true);

                } else {

                  Alert.showWarning("Preste Atención",response.descRetorno,"md");
                  $("#masked_rut_client").prop('disabled', false); $("#masked_rut_client").val("");
                  $("#htmlCupos").val("");

                }

            }

        },

        initAuthorization: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPayOne").prop("disabled", true); $("#formPayTwo").prop("disabled", true);
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
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
$(function(){ Client.processHide(); });
