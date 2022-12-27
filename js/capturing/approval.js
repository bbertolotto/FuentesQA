 /**
 *  Document   : js\client\information.js
 *  Author     : TeknodataSystems
**/

$(function () {

    $('.btn-action').on('click', function () {

        if($(this).data('target')=="accept"){

          var requireOK = 0;
          var yes = document.getElementById("yesCI");
          if(yes.checked) { requireOK += 1; }

          var yes = document.getElementById("yesSecure");
          if(yes.checked) { requireOK += 1; }

          var yes = document.getElementById("yesEECC");
          if(yes.checked) { requireOK += 1; }

          if(requireOK<3){
              toastr.warning("Respuestas Requeridas, no son suficientes ..","Preste Atenci&#243;n.");
              return(false);
          }

          $("#btn-accept-request").val("accept");
          Alert.showRequest("<h3><strong>ACEPTAR CAPTACI&#211;N CLIENTE PRE APROBADO<strong></h3>","<strong><h4>Presione Aceptar para confirmar<br></h4></strong><br>");
          return(false);

        }

        if($(this).data('target')=="deny"){

          $("#btn-accept-request").val("deny");
          Alert.showRequest("<h3><strong>RECHAZAR CAPTACI&#211;N CLIENTE PRE APROBADO<strong></h3>","<strong><h4>Presione Aceptar para confirmar<br></h4></strong><br>");
          return(false);

        }

    });


    $('.btn-modal-request').on('click', function () {

          if($("#btn-accept-request").val()=="deny") {

            if($(this).data("target")=="accept") {

                  var dataCard = "numberCapturing="+$("#numberCapturing").val()+"&statusCapturing=RE";
                  $.ajax({
                      url: "/capturing/deny_capturing", type: "POST", dataType: "json", data : dataCard,
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

          if($("#btn-accept-request").val()=="accept") {

            if($(this).data("target")=="accept") {

              $("#nameClient").val($("#nombres").val()+" "+$("#apellidos").val());
              $("#masked_rut_transfer").val($("#rut").val());
              $("#numeroCuenta").val($("#nrotcv").val());
              $("#montoCupo").val($("#cupo").val());

              $(".modal-transfer").modal( {show:true,backdrop:'static'} );

            }

            if($(this).data("target")=="reprint") {

                var dataCard = "numberCapturing="+$("#numberCapturing").val();
                $.ajax({
                    url: "/capturing/reprint_capturing", type: "POST", dataType: "json", data : dataCard,
                    beforeSend: function(){ Contact.processShow(); $(".btn-modal-request").prop('disabled', true); }, complete: function(){ Contact.processHide(); },
                    success: function(response, status, xhr){

                        if(response.retorno == 0){

                             $("#exitTransfer").prop('disabled', false); $(".btn-action").prop('disabled', true);

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


            if($(this).data("target")=="transfer") {

                $("#trackingTransfer tbody").empty();
                var dataCard = "numberCapturing="+$("#numberCapturing").val()+"&statusCapturing=AC";
                $.ajax({
                    url: "/capturing/accept_capturing", type: "POST", dataType: "json", data : dataCard,
                    beforeSend: function(){ Contact.processShow(); $(".btn-modal-request").prop('disabled', true); }, complete: function(){ Contact.processHide(); },
                    success: function(response, status, xhr){

                        if(response.retorno == 0){

                            $("#exitTransfer").prop('disabled', false); $(".btn-action").prop('disabled', true);

                            if(response.retorno2!=8){

                              $("#saveTransfer").html("<i class='fa fa-refresh'></i> Reemprimir Tarjeta");
                              $(".btn-modal-request").prop('disabled', false);
                              $("#saveTransfer").data("target", "reprint");  

                            }
  
                        } else {

                            $(".btn-modal-request").prop('disabled', false);
                        }

                        $('#trackingTransfer tbody').empty(); $('#trackingTransfer tbody').append(response.htmlTags);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      nameStep1 = "Captación"; statusStep1="Terminado ..."; resultStep1 = textStatus;
                      $('#trackingTransfer tbody').empty(); htmlTags = '<tr><td class="text-center">'+nameStep1+'</td><td class="text-center">'+statusStep1+'</td><td class="text-center">'+resultStep1+'</td>'; $('#trackingTransfer tbody').append(htmlTags); $(".btn-modal-request").prop('disabled', false);
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
