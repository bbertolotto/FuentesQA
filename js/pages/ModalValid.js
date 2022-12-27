/*
 *  Document   : ModalValid.js
 *  Author     : TeknodataSystems
 */

var Alert = function() {
    return {
        showDeny: function() {
          var e = document.getElementById('body-modal-deny');
          e.innerHTML="<h2><strong>S&#250;per Avance</strong></h2>";
          e.innerHTML+="<h4>Esta a punto de Confirmar rechazo de operación SAV</h4>";
          $('.modal-deny').modal({show:true,backdrop:'static'});
        },
        showLiquidateOK: function() {
          var e = document.getElementById('body-modal-valid');
          e.innerHTML="<h2><strong>S&#250;per Avance</strong></h2>";
          e.innerHTML+="<h4>Transferencia realizada con &#201;xito!</h4>";
          $('.modal-valid').modal({show:true,backdrop:'static'});
        },
        showLiquidateNOOK: function() {
          var e = document.getElementById('body-modal-valid');
          e.innerHTML="<h2><strong>S&#250;per Avance</strong></h2>";
          e.innerHTML+="<h4>Transferencia fue rechazada.</h4>";
          $('.modal-valid').modal({show:true,backdrop:'static'});
        },
        init: function() {
//          e = document.getElementById("btn-modal-error");e.style.display = "";
        },
        showError: function(m) {
          var e = document.getElementById("body-modal-valid");
          e.innerHTML="<h2><strong>Servicios No Disponibles</strong></h2></br>";
          e.innerHTML+="<h3><strong>Comuniquese con Mesa de Ayuda</strong></h3></br>";
          e.innerHTML+="<strong>"+m+"</strong>";
          $('.modal-valid').modal({show:true,backdrop:'static'});
        }
    }
}();
$(function(){ Alert.init(); });
