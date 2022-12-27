/**
/**
 *  Document   : manager/Approbation.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones SAV
**/
$(function () {

    $(".btn-valid").on("click", function () {

        if($(this).data('target')!="cancel") { 

            idDocument = $("#idDocument").val(); nroRut = $("#nroRut").val(); reasonDeny = $("#reasonDeny").val(); tipoEstado = "PE"; typeDeny = "approbation";
            Client.actualizaEstado(idDocument, tipoEstado, nroRut, reasonDeny, typeDeny); 

        }


    $(".close").click();    

    });


    $('.btn-action').on('click', function () {
        var theForm = document.getElementById("form-valid");
        var target = $(this).data('target');

        if(target=="save"){ Client.processShow(); if(Client.checkSave()){ Alert.showRequest("","<strong><h4>Confirmar Autorizaci&#243;n S&#250;per Avance ?</h4></strong><br><br>"); return(false); } Client.processHide(); }
        if(target=="linked"){ Client.processShow(); Client.checkLink(); Client.processHide(); }

        if(target=="deny"){

            $("#typeAction").val("deny");
            Alert.showDeny("<h3><strong>RECHAZAR APROBACI&#211;N S&#218;PER AVANCE<strong></h3>");
            return(true);

        }

        if(target=="print"){

          if(Client.checkSave()) {
            var btn = document.getElementById("buttonHide");
            btn.style.display="none";
            var areaPrint = document.getElementById("areaPrint");
            Client.processShow();

            var ventana = window.open('', 'PRINT', 'height=600,width=1300');
            ventana.document.write('<html><head><title></title>');
            ventana.document.write('<link rel="stylesheet" href="/css/bootstrap.min.css">');
            ventana.document.write('<link rel="stylesheet" href="/css/plugins.css">');
            ventana.document.write('<link rel="stylesheet" href="/css/main.css">');
            ventana.document.write('<link rel="stylesheet" href="/css/jquery.dataTables.min.css">');
            ventana.document.write('</head><body >');
            ventana.document.write(areaPrint.innerHTML);
            ventana.document.write('</body></html>');
            ventana.document.close();
            ventana.focus();
            ventana.onload = function() {
            ventana.print();
            ventana.close();
            };
            btn.style.display="";


        return(false);
        }

        }
        
        if(target=="cancel"){

            $.redirect("/advance/search");

        }

    });

    $('.btn-modal-request').on('click', function () {

        var target = $(this).data('target');
        Client.processShow();

        if(target=="accept"){

            if($("#typeAction").val()=="save") { $tipoEstado = "AU"; }
            if($("#typeAction").val()=="link") { $tipoEstado = "AUT"; }

            $data = "idDocument="+$('#idDocument').val()+"&nroRut="+$("#nroRut").val()+"&tipoEstado="+$tipoEstado+"&reasonDeny=&typeDeny=";
            $.ajax({ url: "/advance/updateEstadoSAV", type: "POST", dataType: "json", data : $data, success: function(response, status, xhr) { if(response.retorno==0) { if($tipoEstado == "AU") { $.redirect("/advance/valid", { idDocument: $("#idDocument").val(), nroRut: $("#nroRut").val() } ); } else { $.redirect("/advance/search"); } } else { Alert.showToastrWarning(response); } Client.processHide(); }, error: function(jqXHR, textStatus, errorThrown) { Alert.showToastrErrorXHR(jqXHR, textStatus); } });

        }    
        Client.processHide();

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

        checkSave: function () {

            var requireOK = 0; $("#typeAction").val("save");

            var yesno = document.getElementById("yesnoRut");
            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoContract");
            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoResum");
            if(yesno.checked) { requireOK += 1; }
//            var yesno = document.getElementById("yesnoAddres");
//            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoSecure1");
            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoFirma");
            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoAutentia");
            if(yesno.checked) { requireOK += 1; }

            var yesno = document.getElementById("yesnoDirect1");
            if(yesno.checked) { requireOK += 1; }
//            var yesno = document.getElementById("yesnoDirect2");
//            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoDirect3");
            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoEmail");
            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoTasa");
            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoDiferido");
            if(yesno.checked) { requireOK += 1; }
            var yesno = document.getElementById("yesnoSecure2");
            if(yesno.checked) { requireOK += 1; }

            if(requireOK<12){
                toastr.warning("Respuestas Requeridas, no son suficientes ..","Preste Atenci&#243;n.");
                return(false);
            }            

            if($("#tipoOferta").val()=="PA") { var yesno = document.getElementById("yesnoEmpleo"); if(!yesno.checked) { toastr.error("Tipo Oferta PRE APROBADO, requiere verificación de Empleabilidad !","Preste Atenci&#243;n."); return(false);  } }

            var yesno = document.getElementById("yesnoEmpleo");
            if(yesno.checked) { requireOK += 1; }

            return(true);

        },

        checkLink: function () {

        $("#typeAction").val("link"); 
        if( $("#estadoEnlace").val()!="ENL"){
          toastr.warning("Cotizaci&#243;n no puede ser enlazada..","Preste Atenci&#243;n");
          return(false);
        }

        Alert.showRequest("","<strong><h4>Confirmar Autorizaci&#243;n Enlazar S&#250;per Avance ?</h4></strong><br><br>");
        return(false);

        },

        actualizaEstado: function(idDocument, tipoEstado, nroRut, reasonDeny, typeDeny) {

          $.ajax({ url: "/advance/updateEstadoSAV", type: "POST", dataType: "json", data : { idDocument: idDocument, tipoEstado: tipoEstado, nroRut: nroRut, reasonDeny: reasonDeny, typeDeny: typeDeny }, 
            beforeSend: function(){ Client.processShow(); }, complete:function(){ Client.processHide(); },
            success: function(response, status, xhr) { if(response.retorno==0) { $.redirect("/advance/search"); } else { Alert.showToastrWarning(response); }  }, error: function(jqXHR, textStatus, errorThrown) { Alert.showToastrErrorXHR(jqXHR, textStatus); } });

          return(true);
        },

        prepare: function() {

            $("#yesSerie").attr("checked", false);
            $("#noSerie").attr("checked", true);
            $("#yesNameClient").attr("checked", false);
            $("#noNameClient").attr("checked", true);
            $("#yesFechaNacimiento").attr("checked", false);
            $("#noFechaNacimiento").attr("checked", true);
            $("#yesTarjetaAdic").attr("checked", false);
            $("#noTarjetaAdic").attr("checked", true);
            $("#yesDispatch").attr("checked", false);
            $("#noDispatch").attr("checked", true);

//            $(".btn-print").prop('disabled', true); 

        },
        init: function() {
            $.validator.addMethod("evalrut", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRut( value );
            });
            $('#form-client').validate({
                errorClass: 'help-block animation-slideDown', 
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                unhighlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.search();
                },
                rules: {
                    masked_rut_client: {required: false, evalrut: true, minlength: 5, maxlength: 12},
                },
                messages: {
                    masked_rut_client: {required:'Ingrese número RUT', evalrut:'Ingrese RUT valido!'},
                }
            });
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });

