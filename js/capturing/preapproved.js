/**
 *  Document   : js\client\information.js
 *  Author     : TeknodataSystems
**/

$(function () {

    $('#regionCode').on('change', function (){

        $("#cityCode").empty(); $("#communeCode").empty(); var jCity ="";

            $.ajax({
                url: "/client/get_cities", type: 'post', dataType: 'json', data: { id : $(this).val() },
                success: function(json) {
                        for(i=0; i<json.length;i++){
                             $("#cityCode").append("<option value='"+json[i]["id"]+"'>"+json[i]["nombre"]+"</option>");
                             if(jCity==""){ jCity = json[i]["id"]; }
                        }

                        $.ajax({
                            url: "/client/get_communes", type: 'post', dataType: 'json', data: {idciudad : jCity, idregion : $('#regionCode').val() },
                            success: function(json) {
                                    for(i=0; i<json.length;i++){
                                         $("#communeCode").append("<option value='"+json[i]["id"]+"'>"+json[i]["nombre"]+"</option>");
                                    }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {

                                Alert.showToastrErrorXHR(jqXHR, textStatus);
                            }
                         });
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    Alert.showToastrErrorXHR(jqXHR, textStatus);
                }

             });

    });

    $('#cityCode').on('change', function (){
        $("#communeCode").empty();

            $.ajax({
                url: "/client/get_communes", type: 'post', dataType: 'json', data: {idciudad : $(this).val(), idregion : $('#regionCode').val() },
                success: function(json) {
                        for(i=0; i<json.length;i++){
                             $("#communeCode").append("<option value='"+json[i]["id"]+"'>"+json[i]["nombre"]+"</option>");
                        }
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    Alert.showToastrErrorXHR(jqXHR, textStatus);
                }

             });

    });

    $('.btn-cancel').on('click', function () { Contact.set_session(); $.redirect("/capturing/preapproved") } );

    $('.btn-save').on('click', function () {

        Contact.processShow();
        /*Datos Cliente Pre aprobado*/
        dataCard = "rutClient="+$("#rutClient").val()+"&nameClient="+$("#nameClient").val()+"&lastFatherClient="+$("#lastFatherClient").val()+"&lastMotherClient="+$("#lastMotherClient").val()+"&rutClientSerie="+$("#rutClientSerie").val()+"&birthDateClient="+$("#birthDateClient").val()+"&sexClient="+$("#sexClient").val()+"&civilClient="+$("#civilClient").val()+"&nationality="+$("#nationality").val()+"&countryByOrigin="+$("#countryByOrigin").val()+"&countryResidence="+$("#countryResidence").val()+"&typeClient="+$("#typeClient").val()+"&scoreClient="+$("#scoreClient").val();
        /*Datos Tarjeta Pre aprobado*/
        dataCard+= "&number_credit_card="+$("#number_credit_card").val()+"&amount_credit_card="+$("#amount_credit_card").val()+"&expired_credit_card="+$("#expired_credit_card").val()+"&payment_form_credit_card="+$("#payment_form_credit_card").val()+"&secure_credit_card="+$("#secure_credit_card").val()+"&payment_day_credit_card="+$("#payment_day_credit_card").val()+"&health_credit_card="+$("#health_credit_card").val()+"&contract_number_credit_card="+$("#contract_number_credit_card").val()+"&remarks_credit_card="+$("#remarks_credit_card").val()+"&campaign_number="+$("#campaign_number").val()+"&eeccEmail="+$("#eeccEmail").val();
        /*Dirección Cliente*/
        dataCard+= "&viaAddress="+$("#viaAddress").val()+"&address="+$("#address").val()+"&numberAddress="+$("#numberAddress").val()+"&numberDepart="+$("#numberDepart").val()+"&numberBlock="+$("#numberBlock").val()+"&communeCode="+$("#communeCode").val()+"&postalCode="+$("#postalCode").val()+"&complement="+$("#complement").val()+"&numberFloor="+$("#numberFloor").val();
        /*Teléfonos Cliente*/
        dataCard+= "&numberPhone1="+$("#numberPhone1").val()+"&numberPhone2="+$("#numberPhone2").val()+"&numberPhone3="+$("#numberPhone3").val()+"&numberPhone4="+$("#numberPhone4").val();
        /*Emails Cliente*/
        dataCard+= "&clientEmail1="+$("#clientEmail1").val()+"&clientEmail2="+$("#clientEmail2").val()+"&descam="+$("#descam").val();

        $.ajax({
            url: "/capturing/validate_save_capturing", type: "POST", dataType: "json", data : dataCard ,
            beforeSend: function () { $(".btn-save").prop('disabled', true); }, complete: function ()  {  $(".btn-save").prop('disabled', false); },
            success: function(response, status, xhr){

                if(response.retorno == 0){

                    Alert.showAlert(response.descRetorno);

                }else{

                    Alert.showAlert(response.descRetorno);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Alert.showToastrErrorXHR(jqXHR, textStatus);
            },
        });
        Contact.processHide();

        return(true);
    });


});

var Client = function() {
    return {

        get_ClientByRut: function() {

            Contact.get_CapturingByRut();

        }

    }
}();

var Contact = function() {
    return {

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },
        set_session: function(){
            Contact.processShow();
            $.ajax({
                url: "/CallWSSolventa/set_session_client", type: "post", dataType: "json",
                success: function(response, status, xhr) {
                    Contact.processHide();
                    return(true);
                },
            });
        },
        get_CapturingByRut: function() {

            dataCard = "rutClient="+$("#rutClient").val();
            $.ajax({
                url: "/capturing/get_preapprovedByRut", type: "POST", dataType: "json", data : dataCard ,
                beforeSend: function () { Contact.processShow(); }, complete: function ()  {  Contact.processHide(); },
                success: function(response, status, xhr){

                    if(response.retorno == 0){

                        Contact.initCapturing(response);

                    }else{

                        Alert.showAlert(response.descRetorno);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Alert.showToastrErrorXHR(jqXHR, textStatus);
                },
            });

            return false;
        },
        checkNationality: function() {

            if($("#nationality").val()=="OT") {

                $("#countryByOrigin").val("");
                $("#countryByOrigin").prop("disabled", false);

            } else {

                $("#countryByOrigin").val("152");
                $("#countryByOrigin").prop("disabled", false);

            }

        },
        initCapturing: function($capta) {

            $("#nameClient").val($capta.nombres);
            $("#lastFatherClient").val($capta.apaterno);
            $("#lastMotherClient").val($capta.amaterno);
            $("#birthDateClient").val($capta.fechanac);
            $("#sexClient").val($capta.sexo);
            $("#typeClient").val($capta.tipopan);
            $("#scoreClient").val($capta.score);
            $("#number_credit_card").val($capta.pan);
            $("#amount_credit_card").val($capta.cupo);
            $("#name_credit_card").val($capta.desprod);

            var pan = $capta.pan; pan = pan.substr(pan.length - 4);
            $("#masked_credit_card").val("****-****-****-"+pan);

            $("#campaign_number").val($capta.numcam);
            $("#type_credit_card").val($capta.cod_producto);
            $("#descam").val($capta.descam);
            $("#tipcam").val($capta.tipcam);

        },
        initAddress: function() {

            $("#cityCode").empty(); $("#communeCode").empty();

        },

        init: function() {
            $('#number_credit_card').mask('9999-9999-9999-9999');
            $('#postalCode').mask('999 9999');

            $("#nationality").val("CL");
            $("#countryByOrigin").val("152");
            $("#countryResidence").val("152");
            $("#countryByOrigin").prop("disabled", true);
            $("#countryResidence").prop("disabled", true);
            $("#rutClient").focus();

        }

    };
}();
$(function(){ Contact.init(); });
