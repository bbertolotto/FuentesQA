/**
 *  Document   : approbation.js
 *  Author     : TeknodataSystems
**/
/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {


  $(".btn-valid").on("click", function () {

      if($(this).data('target')!="cancel") {

            idDocument = $("#idDocument").val(); nroRut = $("#nroRut").val(); reasonDeny = $("#reasonDeny").val(); tipoEstado = "RR"; typeDeny = "valid";
            Client.actualizaEstado(idDocument, tipoEstado, nroRut, reasonDeny, typeDeny); return(true);

      }

  $(".close").click();
  });


  $('.btn-modal-request').on('click', function () {

        idDocument = $("#idDocument").val(); nroRut = $("#nroRut").val(); reasonDeny = ""; typeDeny = "";

        if($("#btn-accept-request").val()=="liquid" && $("#formaDePago").val()=="EFECTIVO") {

            if($(this).data('target')=="accept") { tipoEstado = "C"; Client.actualizaEstado(idDocument, tipoEstado, nroRut, reasonDeny, typeDeny); }

            return(true);
        }

        if($("#btn-accept-request").val()=="liquid" && $("#formaDePago").val()=="TRANSFERENCIA" && $(this).data('target')=="accept") {

            $.ajax( { url: "/advance/get_requestById", type: "POST", dataType: "json", data : { id : idDocument }, beforeSend: function() { Client.processShow(); }, complete: function() { Client.processHide(); },
              success: function(response, status, xhr) {

                if(response.retorno == 0) {

                    $("#nameClient").val(response.nameClient);
                    $("#masked_rut_transfer").val(response.nroRut+"-"+response.dgvRut);
                    $("#numeroCuenta").val(response.numeroCuenta);
                    $("#montoLiquido").val("$"+response.montoLiquido);
                    $("#emailCuenta").val(response.email);
                    $("#telefonoCuenta").val(response.fonoMovil);
                    $("#plazoDeCuota").val(response.plazoDeCuota);
                    $("#bank").val(response.banco);
                    $("#typeAccount").val(response.tipoCuenta);
                    $("#tipoCuenta").val(response.tipoCuenta);
                    $("#codigoBanco").val(response.banco);

                    $('.modal-transfer .modal-dialog').addClass("modal-lg");
                    $(".modal-transfer").modal( {show:true,backdrop:'static'} );

                } else {

                    Alert.showToastrWarning(response);

                }

              },
              error: function(jqXHR, textStatus, errorThrown) {

                  Alert.showToastrErrorXHR(jqXHR, textStatus);

              }


            });

            return(true);
        }


        if($(this).data("target")=="transfer") {

            $("#trackingTransfer tbody").empty();
            $data = "idDocument="+$("#idDocument").val()+"&emailCuenta="+$("#emailCuenta").val()+"&nombreCliente="+$("#nameClient").val()+"&descBanco="+$("#nameBanco").val()+"&tipoCuenta="+$("#typeAccount").val()+"&telefonoCuenta="+$("#telefonoCuenta").val()+"&montoLiquido="+$("#montoLiquido").val()+"&nroRut="+$("#masked_rut_transfer").val()+"&codigoBanco="+$("#bank").val()+"&plazoDeCuota="+$("#plazoDeCuota").val()+"&numeroCuenta="+$("#numeroCuenta").val();
            $.ajax( { url: "/advance/put_Transferencia", type: "POST", dataType: "json", data : $data ,
              beforeSend: function(){ Client.processShow(); $(".btn-modal-request").prop('disabled', true); }, complete: function(){ Client.processHide(); },
              success: function(response, status, xhr) {

                if(response.codigoRetorno==0 && response.estadoTEF==1) { $("#exitTransfer").prop('disabled', false); $(".btn-action").prop('disabled', true); } else { $(".btn-modal-request").prop('disabled', false); }
                $('#trackingTransfer tbody').empty(); $('#trackingTransfer tbody').append(response.htmlTags);

              },

              error: function(jqXHR, textStatus, errorThrown) {
                nameStep1 = "Transferencia"; statusStep1="Terminado ..."; resultStep1 = textStatus;
                $('#trackingTransfer tbody').empty(); htmlTags = '<tr><td class="text-center">'+nameStep1+'</td><td class="text-center">'+statusStep1+'</td><td class="text-center">'+resultStep1+'</td>'; $('#trackingTransfer tbody').append(htmlTags); $(".btn-modal-request").prop('disabled', false);
              }


            });

            return(false);

        }

        return(true);
  });


  $('.btn-action').on('click', function () {

        if($(this).data('target')=="liquid"){

          idDocument = $("#idDocument").val(); nroRut = $("#nroRut").val(); reasonDeny = ""; typeDeny = "";

          $.ajax( { url: "/advance/get_requestById", type: "POST", dataType: "json", data : { id : idDocument }, beforeSend: function() { Client.processShow(); }, complete: function() { Client.processHide(); },
                success: function(response, status, xhr) {

                  if(response.retorno == 0) {

                      $("#nameClient").val(response.nameClient);
                      $("#masked_rut_transfer").val(response.nroRut+"-"+response.dgvRut);
                      $("#numeroCuenta").val(response.numeroCuenta);
                      $("#montoLiquido").val("$"+response.montoLiquido);
                      $("#emailCuenta").val(response.email);
                      $("#telefonoCuenta").val(response.fonoMovil);
                      $("#plazoDeCuota").val(response.plazoDeCuota);
                      $("#bank").val(response.banco);
                      $("#typeAccount").val(response.tipoCuenta);
                      $("#tipoCuenta").val(response.tipoCuenta);
                      $("#codigoBanco").val(response.banco);

                      $('.modal-transfer .modal-dialog').addClass("modal-lg");
                      $(".modal-transfer").modal( {show:true,backdrop:'static'} );

                  } else {

                      Alert.showToastrWarning(response);

                  }

                },
                error: function(jqXHR, textStatus, errorThrown) {

                    Alert.showToastrErrorXHR(jqXHR, textStatus);

                }
          });

          return(true);
      }

      if($(this).data("target")=="transfer") {

          $("#trackingTransfer tbody").empty();
          $data = "idDocument="+$("#idDocument").val()+"&emailCuenta="+$("#emailCuenta").val()+"&nombreCliente="+$("#nameClient").val()+"&descBanco="+$("#nameBanco").val()+"&tipoCuenta="+$("#typeAccount").val()+"&telefonoCuenta="+$("#telefonoCuenta").val()+"&montoLiquido="+$("#montoLiquido").val()+"&nroRut="+$("#masked_rut_transfer").val()+"&codigoBanco="+$("#bank").val()+"&plazoDeCuota="+$("#plazoDeCuota").val()+"&numeroCuenta="+$("#numeroCuenta").val();
          $.ajax( { url: "/advance/put_Transferencia", type: "POST", dataType: "json", data : $data ,
            beforeSend: function(){ Client.processShow(); $(".btn-modal-request").prop('disabled', true); }, complete: function(){ Client.processHide(); },
            success: function(response, status, xhr) {

              if(response.codigoRetorno==0 && response.estadoTEF==1) { $("#exitTransfer").prop('disabled', false); $(".btn-action").prop('disabled', true); } else { $(".btn-modal-request").prop('disabled', false); }
              $('#trackingTransfer tbody').empty(); $('#trackingTransfer tbody').append(response.htmlTags);

            },

            error: function(jqXHR, textStatus, errorThrown) {
              nameStep1 = "Transferencia"; statusStep1="Terminado ..."; resultStep1 = textStatus;
              $('#trackingTransfer tbody').empty(); htmlTags = '<tr><td class="text-center">'+nameStep1+'</td><td class="text-center">'+statusStep1+'</td><td class="text-center">'+resultStep1+'</td>'; $('#trackingTransfer tbody').append(htmlTags); $(".btn-modal-request").prop('disabled', false);
            }


          });

          return(false);

      }


      if($(this).data('target')=="deny"){

        $("#btn-accept-request").val("deny");
        Alert.showDeny("<h3><strong>RECHAZAR LIQUIDACI&#211;N S&#218;PER AVANCE<strong></h3>");
        return(false);

      }



    });


  $('.btn-cancel').on('click', function () {

    $.redirect("/advance/search");

  });


});

var Client = function() {
    return {
        init: function() {

            if(Number($("#tasaMaxima").val()) < Number($("#tasaRequest").val())) {

                Alert.showWarning("Cotización vigente excede Tasa Máxima..<br>Crear nueva Cotización!!","");

                $(".btn-confirm").prop('disabled', true);
                $(".btn-print").prop('disabled', true);

            }


        },

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },
        actualizaEstado: function(idDocument, tipoEstado, nroRut, reasonDeny, typeDeny) {

          $.ajax({ url: "/advance/updateEstadoSAV", type: "POST", dataType: "json", data : { idDocument: idDocument, tipoEstado: tipoEstado, nroRut: nroRut, reasonDeny: reasonDeny, typeDeny: typeDeny },
            beforeSend: function(){ Client.processShow(); }, complete:function(){ Client.processHide(); },
            success: function(response, status, xhr) { if(response.retorno==0) { $.redirect("/advance/search"); } else { Alert.showToastrWarning(response); }  }, error: function(jqXHR, textStatus, errorThrown) { Alert.showToastrErrorXHR(jqXHR, textStatus); } });

          return(true);
        }

    };
}();
$(function(){ Client.init(); });
