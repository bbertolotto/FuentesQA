/**
 *  Document   : js\client\replacecard.js
 *  Author     : TeknodataSystems
**/

$(function () {

    $('.btn-accept-lock').on('click', function () {

        $data = "number_credit_card="+$("#number_credit_card").val()+"&name_bloq_credit_card="+$("#name_bloq_credit_card").val()+"&code_bloq_credit_card="+$("#code_bloq_credit_card").val();

        $.ajax({
                url: "/client/put_BlockingCreditCard", type: "POST", dataType: "json", data : $data,
                beforeSend: function () { Client.processShow(); }, complete: function () { Client.processHide(); },
                success: function(response, status, xhr){

                    Alert.showWarning("",response.descRetorno);

                },
        });
        Client.processHide();
        return(false);
    });


    $('.btn-accept-save').on('click', function () {

        $data = "number_credit_card="+$("#number_credit_card").val()+"&name_bloq_credit_card="+$("#name_bloq_credit_card").val()+"&code_bloq_credit_card="+$("#code_bloq_credit_card").val();
        $data+= "&relation_credit_card="+$("#relation_credit_card").val()+"&status_credit_card="+$("#status_credit_card").val();

        $.ajax({
                url: "/client/put_RequestReprintCreditCard", type: "POST", dataType: "json", data : $data,
                beforeSend: function () { Client.processShow(); }, complete: function () { Client.processHide(); },
                success: function(response, status, xhr){

                    Alert.showWarning("",response.descRetorno);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Alert.showToastrErrorXHR(jqXHR, textStatus);
                }

        });
        Client.processHide();
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

        selectLockType: function(e) {

            if($("#datajson").val()=="") {

                toastr.warning("Antes de Seleccionar un Tipo de bloque debe seleccionar una Tarjeta","Preste Atención");
                return(false);
            }
            if(e.value==""){
              $(".btn-accept-lock").prop("disabled", true);
              $(".btn-accept-save").prop("disabled", true);
              return(false);
            }
            var response = JSON.parse(e.value);

            if(response.flgbloqsat==0) {
                $(".btn-accept-lock").prop("disabled", false);
                $(".btn-accept-save").prop("disabled", false);
            } else {
                $(".btn-accept-lock").prop("disabled", false);
                $(".btn-accept-save").prop("disabled", true);
            }

            $("#name_bloq_credit_card").val(response.namebloqsat);
            $("#code_bloq_credit_card").val(response.codbloqsat);

            return(false);
        },
        selectReplaceCard: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idPan = tabTD[2].innerText;
            idPan += tabTD[6].innerText;
            var idCheck = "sel"+idPan;
            document.getElementById(idCheck).checked = true;
            $("#lockType").prop("disabled", false);
            $("#number_credit_card").val(tabTD[2].innerText);
            $("#relation_credit_card").val(tabTD[6].innerText);
            $("#status_credit_card").val(tabTD[3].innerText);

        },
        init: function() {
            $("#lockType").prop("disabled", true);
            $(".btn-accept-lock").prop("disabled", true);
            $(".btn-accept-save").prop("disabled", true);
        }

    };

}();
$(function(){ Client.init(); });
