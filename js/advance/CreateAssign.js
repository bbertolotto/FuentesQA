/**
/**
 *  Document   : advance/Create.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/
$(function () {

    $('.btn-confirm').on('click', function () {

        $.redirect("/advance/confirmRequest", { idDocument: $("#idDocument").val(), nroRut: $("#masked_rut_client").val() } );
    });


    $('.btn-print').on('click', function () {

        Client.processShow();
        $data = "id="+$("#idDocument").val()+"&type=COT";

        $.ajax( {
            url: "/advance/generaPDF", type: "POST", dataType: "json",
            data : $data,
            success: function(response, status, xhr){

                Client.processHide();

                if(response.retorno==0){

                    window.open("/advance/readPDF", '_blank');

                }else{

                    Alert.showToastrError(response);

                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Alert.showToastrErrorXHR(jqXHR, textStatus);
            }

        });
        return(true);

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
    };
}();
Client.init();
