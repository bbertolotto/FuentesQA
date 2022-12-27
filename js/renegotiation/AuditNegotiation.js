/**
/**
 *  Document   : renegotiation/AuditNegotiation.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/

$(function () {

    $('.btn-return').on('click', function () {

        Client.processShow();
        $.redirect("/renegotiation");

    });

    $('.btn-reset').on('click', function () {

        Client.processShow();
        $.redirect("/renegotiation/negotiation");

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
        showQuota: function() {
            var title = "Cupos Disponibles"; var messages = $('#htmlCupos').val(); var window_size = "xs";
            Alert.showWarning( title, messages, window_size);
        },
        showDetails: function() {
          var script = $("#htmlDetalle").val();
          Alert.showWarning("Detalle Renegociación",script,"md");
        }
    };
}();
$(function(){ Client.processHide(); });
$("#formpay").collapse("show");
