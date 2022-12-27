/**
/**
 *  Document   : advance/Review.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/

var response = "";

$(function () {

    $('.btn-confirm').on('click', function () {

        $.redirect("/advance/confirmRequest", { idDocument: $("#idDocument").val(), nroRut: $("#masked_rut_client").val() } );
    });

    $('.btn-send').on('click', function () {

        if($("#flg_print").val()!="print") {
              Alert.showWarning("Debe Imprimir Cotización Antes de Enviar Por Mail","Preste Atención");
              return(false);
        }

        var formData = new FormData();
        formData.append("id", $("#idDocument").val());
        formData.append("emailCuenta", $("#emailClient").val());
        formData.append("nombreCliente", $("#label_nameClient").val());
        formData.append("id", $("#idDocument").val());
        formData.append("estadoTEF", "cotiza");

        var response = Teknodata.call_ajax("/advance/generaPDF", formData, false, true, ".btn-send");
        if(response!=false){

              if(response.retorno==0 ){

                  Alert.showAlert("Cotización Enviada por correo con éxito");

              }else{

                  Alert.showAlert(response.descRetorno);
              }
        }

    });


    $('.btn-print').on('click', function () {

        var formData = new FormData();
        formData.append("id", $("#idDocument").val());
        formData.append("type", "COT");

        var response = Teknodata.call_ajax("/advance/generaPDF", formData, false, true, ".btn-print");
        if(response!=false){

          if(response.retorno==0){

              $("#flg_print").val("print");
              toastr.success("Cotizaci&#243;n marcada como "+response.glosaEstado, "Preste Atenci#243;n !");
              window.open("/advance/readPDF", '_blank');

          }else{

              Alert.showAlert(response.descRetorno);
          }
        }

        Client.initSend();
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

        loadRequest: function(response) {

            var rut = $('#masked_rut_client').val();

            var tasaMaxima = String(response.tasaMaxima);
            var tasaRequest = String(response.tasaRequest);

            if(Number(tasaMaxima) < Number(tasaRequest)) {
                $("#message").val("Cotización excede Tasa Máxima, debe crear nueva Cotización!!");
                return(false);
            }

            $("#masked_rut_client").val($("#nroRut").val());
            $("#label_nameClient").val(response.nameClient);
            $("#emailClient").val(response.email);
            $("#phoneClient").val(response.phone);

            $(".btn-simulate").prop('disabled', true);
            $("#amountApproved").prop('disabled', true);

            if(response.tipoOferta=="AP"){

                $("#offer-inline-radio1").attr("checked", true);

            }else{

                $("#offer-inline-radio2").attr("checked", true);
            }

            $("#offer-inline-radio1").prop("disabled", true);
            $('#offer-inline-radio2').prop('disabled', true);

            $("#offerRequest").val(Teknodata.maskMoney(response.montoLiquido));
            $("#offerRequest").prop('disabled', true);

            $('#amountApproved').val(response.montoLiquido);
            $('#numberQuotas').val(response.plazoDeCuota);
            $('#numberQuotas').prop('disabled', true);
            $('#deferredQuotas').prop('disabled', true);
            $('#interesRate').val(response.tasaDeInteresMensual);
            $('#dateFirstExpiration').val(response.fechaPrimerVencimiento);
            if(response.fonoMovil!=""){ $("#phoneClient").val(response.fonoMovil); } else { $("#phoneClient").val(response.fonoFijo); }

            $("#yesdpsSecureOne").prop("disabled", true);
            $("#nodpsSecureOne").prop("disabled", true);
            $("#legalBeneficiary").prop("disabled", true);
            $("#otherBeneficiary").prop("disabled", true);

            if(response.modoEntrega=="TEF"){
                $("#formPay").attr("checked", true);
                $('#formPay').prop('disabled', true);
                $("#paymentType").val("transfer");
                $("#lblformPay").html("Transferencia");
                $("#payment").collapse("show");

                $('#bank').val(response.banco);
                $('#bank').prop('disabled', true);
                $('#typeAccount').val(response.tipoCuenta);
                $('#typeAccount').prop('disabled', true);
                $('#numberAccount').val(response.numeroCuenta);
                $('#numberAccount').prop('disabled', true);
            }else {
                $("#paymentType").val("cash");
                $("#lblformPay").html("Efectivo");
                $("#payment").collapse("hide");
                $("#formPay").attr("checked", false);
                $('#formPay').prop('disabled', true);
                $('#bank').val("");
                $('#bank').prop('disabled', true);
                $('#typeAccount').val("");
                $('#typeAccount').prop('disabled', true);
                $('#numberAccount').val("");
                $('#numberAccount').prop('disabled', true);
            }

            if(response.flagSeguro1=="CON SEGURO"){

                var obj = document.getElementById("label"+response.htmlName1);
                obj.innerHTML=" [ACEPTADO]";
                obj = document.getElementById(response.htmlName1);
                obj.checked=true;
                obj.disabled=true;

            }else{

                var obj = document.getElementById("label"+response.htmlName1);
                obj.innerHTML=" [RECHAZADO]";
                obj = document.getElementById(response.htmlName1);
                obj.checked=false;
                obj.disabled=true;
            }

            if(response.flagSeguro2=="CON SEGURO"){

                var obj = document.getElementById("label"+response.htmlName2);
                obj.innerHTML=" [ACEPTADO]";
                obj = document.getElementById(response.htmlName2);
                obj.checked=true;
                obj.disabled=true;

            }else{

                var obj = document.getElementById("label"+response.htmlName2);
                obj.innerHTML="[RECHAZADO]";
                obj = document.getElementById(response.htmlName2);
                obj.checked=false;
                obj.disabled=true;
            }

            o = document.getElementById('simulate');
            o.innerHTML = response.htmlSimulate; $('#simulate').click();

            if(response.estado=="I"||response.estado=="PE"||response.estado=="CO"){
                $('#idDocument').val(response.idDocument);
                $('#idEstado').val(response.estado);
                Client.initAuthorization();
            }
            if(response.estado=="PA"||response.estado=="AU"||response.estado=="L"){
                $('#idDocument').val(response.idDocument);
                $('#idEstado').val(response.estado);
                Client.initExecutive();
            }
            if(response.estado=="L"){
                $('#idDocument').val(response.idDocument);
                $('#idEstado').val(response.estado);
                Client.initLiquidation();
            }
            $("#approbation").collapse('show');
            $("#negotiation").collapse('show');

            if(response.glosatipoOferta!=""){
                $("#lblTipoOferta").html("Monto " + response.glosatipoOferta + " Solicitado");
            }

            var response = JSON.parse($("#datajson").val());

            Teknodata.masked_nroRut(document.getElementById("masked_rut_client"));
            $("#masked_rut_client").prop("readonly", true);

            if(response.retorno==10){

                $("#message").val(response.descRetorno);
                return(false);

            }else{

                o = document.getElementById('offerSelector');
                o.innerHTML = response.offerSelector;
                return(true);
            }

        },
        initLiquidation: function () {
          $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', true);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true);$("#formPay").prop("disabled", true);
        },
        initAuthorization: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPay").prop("disabled", true);
        },
        initExecutive: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', true);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', true);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPay").prop("disabled", true);
        },
        initPrint: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPay").prop("disabled", true);
        },
        initSend: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPay").prop("disabled", true);
        }
    };
}();

$(function(){

        var formData = new FormData();
        formData.append("nroRut", $("#nroRut").val());

        var response = Teknodata.call_ajax("/advance/evaluation_client", formData, false, true,  false);
        if(response!=false){

            $("#datajson").val(JSON.stringify(response));

            var formData = new FormData();
            formData.append("id", $("#idDocument").val());

            var response = Teknodata.call_ajax("/advance/get_requestById", formData, false, true,  false);
            if(response!=false){

                if(response.retorno == 0 ) {

                    if(!Client.loadRequest(response)){

                        Alert.showWarning("", $("#message").val(), "");

/****
                        $.confirm({
                            title: 'Preste Atención!',
                            content: $("#message").val(),
                            buttons: {
                                search: {
                                    text: 'Volver a buscar',
                                    btnClass: 'btn-blue',
                                    keys: ['enter', 'shift'],
                                    action: function(){
                                        $.redirect("/advance/search");
                                    }
                                },
                                create: {
                                    text: 'Crear',
                                    btnClass: 'btn-green',
                                    keys: ['enter', 'shift'],
                                    action: function(){
                                        $.redirect("/advance/create");
                                    }
                                }
                            }
                        });

************/                        
                    }

                } else {

                    $.confirm({
                        title: 'Preste Atención!',
                        content: response.descRetorno,
                        buttons: {
                            search: {
                                text: 'Volver a buscar',
                                btnClass: 'btn-blue',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    $.redirect("/advance/search");
                                }
                            }
                        }
                    });

                }
            }

        }else{

            $.confirm({
                title: 'Preste Atención!',
                content: response.descRetorno,
                buttons: {
                    search: {
                        text: 'Volver a buscar',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $.redirect("/advance/search");
                        }
                    }
                }
            });

        }

});
