  /**
/**
 *  Document   : Search.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {

    $('.btn-modal-action').on('click', function () {



        if($(this).attr('data-target')=="accept_client"){


            if($("#expired_customer").val()=="S"){
                $.redirect("/client/lastaccount", { nroRut: $("#masked_rut_client").val(), expired_customer: $("#expired_customer").val() } );
                return(false);
            }

            if($("#preaprobada").val()=="1") {
                Client.set_session();
                $.redirect("/capturing/approved", { nroRut: $("#masked_rut_client").val() } );
                return(false);
            }

            if($("#reasonSkill").val()==115999 && $("#reasonDetail").val()==""){
                toastr.success('Al seleccionar Otro Motivo, Debe ingresar detalle para el motivo de Atención!', 'Transacción Rechazada');
                return(false);
            }

            Client.processShow();
            $.ajax( {
                url: "/CallWSSolventa/get_client", type: "post", dataType: "json", data: {reasonSkill : $("#reasonSkill").val(), reasonDetail : $("#reasonDetail").val(), nroRut: $("#nroRut").val() },
                success: function(response, status, xhr){

                    Client.processHide();
                    if(response.retorno==0) {
                      e = document.getElementById('client_offers');
                      e.innerHTML = response['htmlOffers'];
                      e = document.getElementById('product_client');
                      e.innerHTML = response['htmlProduct'];
                      Client.restore();
                    } else {
                      Alert.showWarning("",response.descRetorno,modal_size_md);

                    }
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    Client.processHide(); Alert.showToastrErrorXHR(jqXHR, textStatus);
                },
            });

        }


        if($(this).attr('data-target')=="cancel_client"){
            Client.set_session();
        }

        return(true);
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
          if($("#masked_rut_client").val()=="" && $("#masked_credit_card").val()=="") { Alert.showAlert("Ingrese N&#250;mero RUT o N&#250;mero Tarjeta Cr&#233;dito"); return(false); } else { return(true); }
        },
        prepare: function() {
          e = document.getElementById("client-details");e.style.display="none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display="";
        },
        search: function() {

            Client.prepare();

            if($("#masked_rut_client").val()!="") { var ourl="/CallWSSolventa/search_client_by_rut"; } else {if($("#masked_credit_card").val()!="") { var ourl="/CallWSSolventa/search_client_by_target"; } }

            $.ajax({
                url: ourl, type: "post", dataType: "json", data: {nroRut : $("#masked_rut_client").val(), nroTcv : $("#masked_credit_card").val() },
                beforeSend: function () { Client.processShow(); }, complete: function () { //Client.processHide(); 
                },
                success: function(response, status, xhr){

                    if(response.retorno==0){

                        $("#preaprobada").val(response.preaprobada);
                        $("#id_office").val(response.id_office);
                        $("#nroRut").val(response.nroRut);
                        $("#expired_customer").val(response.expired_customer);

                         Alert.initaccept_client();Alert.showSearch("",response.html);

                    }else{

                        Alert.init();Alert.showSearch("",response.html);Client.set_session();

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    Alert.init();Alert.showToastrErrorXHR(jqXHR, textStatus);

                },
            });
            Client.processHide();

        },
        get_session: function() {

            Client.processShow();
            $.ajax({
                url: "/CallWSSolventa/get_session_client", type: "post", dataType: "json",
                success: function(response, status, xhr){
                    e = document.getElementById('client_offers');
                    e.innerHTML = response['htmlOffers'];
                    e = document.getElementById('product_client');
                    e.innerHTML = response['htmlProduct'];
                    Client.restore();
                },
            });
            Client.processHide();

        },
        set_session: function(){

            Client.processShow();
            $.ajax({
                url: "/CallWSSolventa/set_session_client", type: "post", dataType: "json",
                success: function(response, status, xhr) {
                    Client.processHide(); Client.prepare();
                    return(true);
                },
            });
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
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.set_session(); if(Client.evaluate()) { Client.search(); } else { return(false); }
                },
                rules: {
                    masked_rut_client: {required: false, evalrut: true, minlength: 5, maxlength: 12},
                    masked_credit_card: {required: false, number: false}
                },
                messages: {
                    masked_rut_client: {required:'Ingrese número RUT', evalrut:'Ingrese RUT valido!'},
                    masked_credit_card: {required:'Ingrese número Tarjeta Crédito', number:'Ingrese NUMERO TARJETA valido!'}
                }
            });
            // Initialize Masked Inputs
            // a - Represents an alpha character (A-Z,a-z)
            // 9 - Represents a numeric character (0-9)
            // * - Represents an alphanumeric character (A-Z,a-z,0-9)
            $('#masked_credit_card').mask('9999-9999-9999-9999');
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
$(function(){ Client.get_session(); });
