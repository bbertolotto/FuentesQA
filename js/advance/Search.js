/**
/**
 *  Document   : advance/Search.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/


$(function () {


    $('.btn-action').on('click', function () {

        if($(this).data("target")=="simulate") { $.redirect( $(this).data("action") ); }
        if($(this).data("target")=="create") { $.redirect( $(this).data("action") ); }

    });

    $('.btn-action-link').on('click', function () {

        if($(this).data("action")=="cancel") { return(true); }
        if($(this).data("action")=="accept") { idStatus = $("#yesidStatus").val(); }
        if($(this).data("action")=="deny") { idStatus = $("#noidStatus").val(); }

        $.ajax( { url: "/advance/changeLinked", type: "POST", dataType: "json", data : { idDocument: $("#idDocument").val(), idStatus: idStatus },
        beforeSend: function(){ Client.processShow(); $(".btn-action-link").attr("disabled","disabled"); }, complete:function(){ Client.processHide(); $(".btn-action-link").removeAttr("disabled"); },
        success: function(response, status, xhr){

            if(response.retorno == 0){

                $(".btn-action-link").attr("disabled","disabled");
                toastr.warning("Estado Enlace actualizado!", "Preste Atenci&#243;n");
                $(".close").click();

            }else{

                Alert.showToastrWarning(response);

               }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Alert.showToastrErrorXHR(jqXHR, textStatus);
            }

        });

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

        evaluate: function() {
            var aa = document.getElementById('masked_rut_client');
            var ae = document.getElementById('numberRequest');
            var ai  = document.getElementById('typeRequestSkill');
            var ao  = document.getElementById('dateBegin');
            var au  = document.getElementById('dateEnd');
            if(aa.value==""&&ae.value==""&&ao.value==""&&au.value==""){
                toastr.warning("Para realizar una busqueda debe ingresar al menos un dato ..","Preste Atencíón..");
            }else{return(true);}
        },

        showAssign: function(idDocument, nroRut) {

            nroRut = nroRut;
            var formData = new FormData();
            formData.append("idDocument", idDocument);

            var response = Teknodata.call_ajax("/advance/getRequestLinked", formData, false, true, "");
            if(response!=false){

                if(response.retorno!=0){
                    Alert.showToastrWarning(response);
                    return(false); }

                $.redirect("/advance/assignRequest", { idDocument: idDocument, idEstado: response.tipoEstado, nroRut: nroRut } );
            }
            return(false);
        },
        showLinked: function(idDocument) {

            var formData = new FormData();
            formData.append("idDocument", idDocument);

            var response = Teknodata.call_ajax("/advance/getRequestLinked", formData, false, true, "");
            if(response!=false){

                if(response.retorno!=0){
                    Alert.showToastrWarning(response);
                    return(false); }
                if(response.estadoEnlace=="") {
                    Alert.showWarning("Preste Atenci&#243;n","Cotizaci&#243;n no registra solicitud de Enlace !","md");
                    return (false);}
                if(response.sucursalOrigen==""||response.sucursalDestino==""||response.sucursalOrigen=="-"||response.sucursalDestino=="-"){
                      Alert.showWarning("Preste Atenci&#243;n","Solicitud de Enlace no registra Sucursal Origen->Destino ","md");
                      return(false); }
                if(id_office==response.sucursalOrigen&&response.estadoEnlace!="ENL") {
                    Alert.showWarning("Preste Atenci&#243;n","Autorización Oficina Origen no esta disponible !","md");
                    return(false);
                }else{
                    if(id_office==response.sucursalDestino&&response.estadoEnlace!="AUO") {
                        Alert.showWarning("Preste Atenci&#243;n","Autorización Oficina Destino no disponible !","md");
                        return(false);
                    }
                }

                Client.restore();
                $("#idDocument").val(idDocument);
                $("#fechaSolicitud").val(response.fechaSolicitud);
                $("#fechaVigencia").val(response.fechaVigencia);
                $("#nameSucursalOrigen").val(response.nameSucursalOrigen);
                $("#nameSucursalDestino").val(response.nameSucursalDestino);
                if(id_office==response.sucursalOrigen) { $("#yesidStatus").val("AUO"); $("#noidStatus").val("REO"); }
                if(id_office==response.sucursalDestino) { $("#yesidStatus").val("AUD"); $("#noidStatus").val("RED"); }
                if($("#yesidStatus").val()==""||$("#noidStatus").val()==""){
                    Alert.showWarning("Preste Atenci&#243;n..","No puede modificar, no hay asignaci&#243;n de Estado !","md");
                    return(false); }

                $('.modal-link-approbation').modal({show:true,backdrop:'static'});
            }
            return(false);
        },
        prepare: function() {
          document.getElementById("client-details").style.display = "none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display = "";
        },
        clearInput: function () {
            document.getElementById("masked_rut_client").value="";
            document.getElementById("numberRequest").value="";
            document.getElementById("dateBegin").value="";
            document.getElementById("dateEnd").value="";
            document.getElementById('typeRequestSkill').value="";
        },
        search: function() {

            if($("#dateBegin").val()!="" && $("#dateEnd").val()=="") { $("#dateEnd").val($("#dateBegin").val() ); }
            if($("#dateEnd").val()!="" && $("#dateBegin").val()=="") { $("#dateBegin").val($("#dateEnd").val() ); }

            var formData = new FormData();
            formData.append("nroRut", $("#masked_rut_client").val());
            formData.append("numberRequest", $("#numberRequest").val());
            formData.append("typeRequestSkill", $("#typeRequestSkill").val());
            formData.append("dateBegin", $("#dateBegin").val());
            formData.append("dateEnd", $("#dateEnd").val());
            formData.append("officeSkill", $("#officeSkill").val());

            var response = Teknodata.call_ajax("/advance/get_request_for_quote", formData, false, true, "");
            if(response!=false){

                if(response.retorno == 0){

                    e = document.getElementById('client-request');
                    e.innerHTML = response['htmlRequest'];
                    Client.restore();

                }else{

                    Alert.showWarning("Preste Atención", response.descRetorno);
                }
            }

        },
        init: function() {
            $.validator.addMethod("evalrut", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRut( value );
            });
            $('#form-client').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
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
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.prepare();Client.search();
                },
                rules: {
                    masked_rut_client: {required: false, evalrut: true, minlength: 5, maxlength: 12},
                },
                messages: {
                    masked_rut_client: {required:'Ingrese número RUT', evalrut:'Ingrese RUT valido!'},
                }
            });

            $('#dateBegin').mask('99-99-9999');
            $('#dateEnd').mask('99-99-9999');
            //$("#numberRequest").mask("99999");

        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
