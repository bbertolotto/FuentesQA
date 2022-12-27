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

    $('.btn-cancel').on('click', function () { Contact.set_session(); $.redirect("/client/search") } );

    $('.btn-save').on('click', function () {

        $("#countryByOrigin").prop('disabled', false);
        $("#countryResidence").prop('disabled', false);

        dataCard = $("#form-client, #form-address, #form-phones, #form-card").serialize();

        $("#countryByOrigin").prop('disabled', true);
        $("#countryResidence").prop('disabled', true);

        var response = Teknodata.call_ajax("/capturing/validate_save_capturing", dataCard, false, false, ".btn-save");
        if(response!=false){

            if(response.retorno == 0){

                Alert.showAlert(response.descRetorno);

            }else{

                Alert.showMessage("Preste Atención..!", "fa fa-warning", "orange", response.descRetorno);

            }

        }

        return(false);
    });


});

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
        checkNationality: function() {

            if($("#nationality").val()=="OT") {

                $("#countryByOrigin").val("");
                $("#countryByOrigin").prop("disabled", false);

            } else {

                $("#countryByOrigin").val("152");
                $("#countryByOrigin").prop("disabled", false);

            }

        },
        deleteAddress: function(row) {
            var d = row.parentNode.parentNode.rowIndex;
            document.getElementById('dataAddress').deleteRow(d);
        },
        deletePhones: function(row) {
            var d = row.parentNode.parentNode.rowIndex;
            document.getElementById('dataPhone').deleteRow(d);
        },
        deleteEmails: function(row) {
            var d = row.parentNode.parentNode.rowIndex;
            document.getElementById('dataEmail').deleteRow(d);
        },


        initAddress: function() {

            $("#cityCode").empty(); $("#communeCode").empty();

        },

        init: function() {
            $('#number_credit_card').mask('****-****-****-9999');
            $('#postalCode').mask('999 9999');
            $("#nationality").val("CL");
            $("#countryByOrigin").val("152");
            $("#countryResidence").val("152");
            $("#countryByOrigin").prop("disabled", true);
            $("#countryResidence").prop("disabled", true);
            $("#rutClientSerie").focus();
        }

    };
}();
$(function(){ Contact.init(); });
$(function(){ Teknodata.masked_nroRut(document.getElementById("rutClient")); });
