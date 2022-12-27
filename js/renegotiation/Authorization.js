/**
/**
 *  Document   : renegotiation/Negotiation.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/

$(function () {

  
    $('.btn-return').on('click', function () {

        Client.processShow();
        $.redirect("/renegotiation/auditnegotiation", { id: $("#authorizing").val(), nroRut: $("#number_rut_client").val() } );

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

    };

}();
$(function(){ Client.processHide(); });
