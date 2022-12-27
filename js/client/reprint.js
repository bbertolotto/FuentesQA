/**
 *  Document   : js\client\information.js
 *  Author     : TeknodataSystems
**/

$(function () {

    $('.btn-action').on('click', function () {

        if($(this).data('target')=="deny"){

          $("#btn-accept-request").val("deny");
          Alert.showRequest("<h3><strong>RECHAZAR REIMPRESI&#211;N TARJETA DE CREDITO<strong></h3>","<strong><h4>Presione Aceptar para confirmar<br></h4></strong><br>");
          return(false);

        }

        if($(this).data('target')=="reprint"){

            $("#nameClient_reprint").val($("#nombres").val()+" "+$("#apellidos").val());
            $("#rut_reprint").val($("#rut").val());
            $("#numeroCuenta_reprint").val($("#nrotcv").val());
            $("#motivo_reprint").val($("#motivo").val());

            $("#btn-accept-request").val("reprint");
            $(".modal-reprint").modal( {show:true,backdrop:'static'} );

        }



    });


    $('.btn-modal-request').on('click', function () {

          if($("#btn-accept-request").val()=="deny") {

            if($(this).data("target")=="accept") {

                  var $data = "numberCapturing="+$("#numberCapturing").val()+"&statusCapturing=RE";

                  $.ajax({
                      url: "/capturing/deny_capturing", type: "POST", dataType: "json", data : $data,
                      beforeSend: function () { $(".btn-accept").prop('disabled', true); Contact.processShow(); }, complete: function ()  {  $(".btn-accept").prop('disabled', false); Contact.processHide(); },
                      success: function(response, status, xhr){

                          if(response.retorno == 0){

                              $.redirect("/capturing/search");

                          }else{

                              Alert.showToastrError(response);
                          }

                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                          Alert.showToastrErrorXHR(jqXHR, textStatus);
                      },
                  });
                  Contact.processHide();

            }

            return(true);

          }

          if($("#btn-accept-request").val()=="reprint") {

            if($(this).data("target")=="reprint") {

                var dataCard = "numberCapturing="+$("#numberCapturing").val();
                $.ajax({
                    url: "/capturing/reprint_credit_card", type: "POST", dataType: "json", data : dataCard,
                    beforeSend: function(){ Contact.processShow(); $(".btn-modal-request").prop('disabled', true); }, complete: function(){ Contact.processHide(); },
                    success: function(response, status, xhr){

                        if(response.retorno == 0){

                            $(".btn-exit-reprint").prop('disabled', false); $(".btn-action").prop('disabled', true); $(".btn-cancel").prop("disabled", false); $(".btn-print").prop("disabled", false);

                        } else {

                             $(".btn-modal-request").prop('disabled', false);
                        }

                        $('#trackingTransfer tbody').append(response.htmlTags);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      nameStep1 = "Reimpresión"; statusStep1="Terminado ..."; resultStep1 = textStatus;
                      htmlTags = '<tr><td class="text-center">'+nameStep1+'</td><td class="text-center">'+statusStep1+'</td><td class="text-center">'+resultStep1+'</td>'; $('#trackingTransfer tbody').append(htmlTags); $(".btn-modal-request").prop('disabled', false);
                    },
                });
                Contact.processHide();

            }


          }

    });

    $('.btn-cancel').on('click', function () { $.redirect("/capturing/search") } );

});

var Contact = function() {
    return {
        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },

        init: function() {

            return true;
        }

    };
}();
$(function(){ Contact.init(); });
