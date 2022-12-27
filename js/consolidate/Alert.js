/*
 *  Document   : Alert.js
 *  Author     : TeknodataSystems
 */

var Alert = function() {
    return {
        init: function() {
          e = document.getElementById("btn-modal-error");e.style.display = "";
          e = document.getElementById("btn-modal-accept_client");e.style.display = "none";
          e = document.getElementById("btn-modal-cancel_client");e.style.display = "none";
          e = document.getElementById("btn-modal-accept_noclient");e.style.display = "none";
          e = document.getElementById("btn-modal-cancel_noclient");e.style.display = "none";
        },
        showDeny: function(message) {
          var e = document.getElementById('body-modal-deny');
          e.innerHTML="<h5><strong>"+message+"</strong></h5>";
          $('.modal-deny').modal({show:true});
        },
        showAlert: function(message) {
          var e = document.getElementById('body-modal-alert');
          e.innerHTML="<h5><strong>"+message+"</strong></h5>";
          $('.modal-alert').modal({show:true});
        },
        showWarning: function(title,message) {
          var e = document.getElementById('body-modal-alert');
          e.innerHTML="<h2><strong>"+title+"</strong></h2>";
          e.innerHTML+="<h4>"+message+"</h4>";
          $('.modal-alert').modal({show:true});
        },
        showSearch: function(title,html) {
          var e = document.getElementById("body-modal-search");
          e.innerHTML=html;
          $('.modal-search').modal({show:true,backdrop:'static'});
        },
        showAdvance: function(title,html) {
          var e = document.getElementById("body-modal-advance");
          e.innerHTML=html;
          $('.modal-advance').modal({show:true,backdrop:'static'});
        },
        showLink: function() {
          var e = document.getElementById("body-modal-link");
          $('.modal-link').modal({show:true,backdrop:'static'});
        },
        showError: function(m) {
          var e = document.getElementById("body-modal-search");
          e.innerHTML="<h2><strong>Servicios No Disponibles</strong></h2></br>";
          e.innerHTML+="<h3><strong>Comuniquese con Mesa de Ayuda</strong></h3></br>";
          e.innerHTML+="<strong>"+m+"</strong>";
          $('.modal-search').modal({show:true,backdrop:'static'});
        }
    }
}();
Alert.init();
