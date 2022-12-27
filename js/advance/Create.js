    /**
/**
 *  Document   : advance/Create.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/

var response = "";

$(function () {

    $('.btn-modal-request').on('click', function () {

        var target = $(this).data('target');

        if(target=="accept"){

            var tab = document.getElementById('tabRequest');
            for (var i=1;i < tab.rows.length; i++){
                /* Selecciona CheckBox con Opción Cliente*/
                sel = document.getElementById("sel"+tab.rows[i].cells[1].innerHTML);
                if(sel.checked){

                    var formData = new FormData();
                    formData.append("id",tab.rows[i].cells[1].innerHTML);

                    var response = Teknodata.call_ajax("/advance/get_requestById", formData, false, true, false);

                    if(response!=false){

                        if(response.retorno == 0){

                                Client.loadRequest(response);
                        }else{
                                Alert.showWarning(response.descRetorno,"");
                        }

                    }
                    return(true);
                }
            }

            toastr.warning("Debe Seleccionar una COTIZACI&#211;N para continuar..","Preste Atenci&#243;n.");
            return(false);
        }

        if(target=="cancel"){

            var response = JSON.parse($("#datajson").val());
            Client.loadOffers(response); $("#approbation").collapse('show');
            return(true);
        }

    });


    $('.btn-reset').on('click', function () { $("#dataload").val('{ "source": "evaluation" }'); Client.prepare(); });

    $('.btn-linked').on('click', function () { if($('#masked_rut_client').val()==""){toastr.warning("Debe ingresar RUT Cliente y simular, antes de Grabar Cotización..","Presta Mucha Atención ..!"); return(false); } if($('#formPayOne').is(":checked")) {toastr.warning("Enlace Sucursal disponible solo para pago en EFECTIVO","Presta Mucha Atención ..!"); return(false); } Client.processHide();Alert.showLinked();return(false); });

    $('.btn-accept-link').on('click', function () {

        todayDate = moment().format('YYYYMMDD'); today = $("#dateLinked").val().split("-"); dateLinked = today[2].toString()+today[1].toString()+today[0].toString();

        if($("#dateLinked").val()=="") { toastr.warning("Debe seleccionar fecha Compromiso ","Preste Atenci&#243;n.."); return(false); }
        if($("#officeLinked").val()=="") { toastr.warning("Debe seleccionar una Sucursal ","Preste Atenci&#243;n.."); return(false); }
        // Validación Constante no puede enlazar a Sucursal Telemarketing
        if($("#officeLinked").val()=="00002") { toastr.warning("No puede solicitar enlazar con Sucursal Ventas Telemarketing","Preste Atenci&#243;n.."); return(false); }
        // Validación no puede enlazar a misma Sucursal Ejecutivo
        if($("#officeLinked").val()==$("#id_office").val()) { toastr.warning("No puede solicitar enlazar con misma Sucursal Origen","Preste Atenci&#243;n.."); return(false); }
        // Fecha Compromiso Enlace
        if(dateLinked<todayDate){ toastr.warning("Fecha Compromiso no puede ser menor a fecha en solicitud","Preste Atenci&#243;n.."); return(false); }
        if($("#emailCuenta").val()=="" && $('#formPay').is(":checked")) { toastr.warning("Debe solicitar un correo Electrónico al cliente","Preste Atención"); return false; }

        var result = Client.saveRequest();
        alert(result);
        if(result) { Client.initAuthorization(); }

    });

    $(".btn-save").on("click", function () {

        $("#dateLinked").val(""); $("#officeLinked").val("");
        //if($("#emailCuenta").val()=="" && $('#formPay').is(":checked")) { toastr.warning("Debe solicitar un correo Electrónico al cliente","Preste Atención"); return false; }

        var result = Client.saveRequest();
        if(result) { Client.initAuthorization(); }

    });


    $('.btn-confirm').on('click', function () {

        $(".btn-confirm").prop('disabled', true); $data = "idDocument="+$("#idDocument").val()+"&nroRut="+$("#masked_rut_client").val();
        $.redirect("/advance/confirmRequest", { idDocument: $("#idDocument").val(), nroRut: $("#masked_rut_client").val() } );

    });

    $('.btn-simulate').on('click', function () {

        var formData = new FormData();
        formData.append("nroRut",$("#masked_rut_client").val());
        formData.append("offerRequest",$("#offerRequest").val());
        formData.append("offerAmount",$("#offerAmount").val());
        formData.append("offerType",$("#offerType").val());
        formData.append("numberQuotas",$("#numberQuotas").val());
        formData.append("deferredQuotas",$("#deferredQuotas").val());

        if($("#secureOne").is(":checked")){
            formData.append("secureOne",$("#secureOne").val());
        }else{
            formData.append("secureOne","");
        }

        if($("#secureTwo").is(":checked")){
            formData.append("secureTwo",$("#secureTwo").val());
        }else{
            formData.append("secureTwo","");
        }

        $("#simulate").html("");
        var response = Teknodata.call_ajax("/advance/get_simulate", formData, false, true,  ".btn-simulate");

        if(response!=false){

            if(response.retorno == 0){

                    Client.initSimulate(response);

            }else{

                    Alert.showWarning("",response.descRetorno);
            }
        }
        return(false);
    });


    $('.btn-send').on('click', function () {

        if($("#flg_print").val()!="print") { toastr.warning("Debe Imprimir Cotización Antes de Enviar Por Mail","Preste Atención"); return(false); }

        var formData = new FormData();
        formData.append("idDocument",$("#idDocument").val());
        formData.append("emailCuenta",$("#emailClient").val());
        formData.append("nombreCliente",$("#label_nameClient").val());
        formData.append("estadoTEF", "cotiza");

        var response = Teknodata.call_ajax("/advance/send_Simulate", formData, false, true,  ".btn-send");

        if(response!=false){

            if(response.retorno==0 ){

                    toastr.success("Cotización Enviada por correo con éxito","Preste Atención");
            }else{
                    Alert.showToastrWarning(response);
            }
        }

    });


    $('.btn-print').on('click', function () {

        var formData = new FormData();
        formData.append("id",$("#idDocument").val());
        formData.append("type","COT");

        var response = Teknodata.call_ajax("/advance/generaPDF", formData, false, true,  ".btn-print");

        if(response!=false){

                if(response.retorno==0){

                    $("#flg_print").val("print");
                    toastr.success("Cotizaci&#243;n marcada como "+response.glosaEstado, "Preste Atenci#243;n !");
                    window.open("/advance/readPDF", '_blank');

                }else{

                    Alert.showToastrError(response);

                }
        }
        Client.initSend();
        return(false);

    });

    $('#offerSelector').on('click', function () {
            Client.selectOffer($(this).val());
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
        saveRequest: function() {

            var formData = new FormData();

            if($('#masked_rut_client').val()==""){toastr.warning("Debe ingresar RUT Cliente y simular, antes de Grabar Cotización..","Presta Mucha Atención ..!"); return(false); }

            var secureOne = document.getElementById('secureOne');
            var secureTwo = document.getElementById('secureTwo');

            var tab = document.getElementById('tabSimulate');
            var $flagSave = false;

            if(!$("#tabSimulate").length){ toastr.warning("No hay detalle de Oferta ..!", "Preste Atención"); return(false); }

            for (var i=1;i < tab.rows.length; i++) {

            /* Selecciona CheckBox con Opción Cliente*/
            sel = document.getElementById("sel"+tab.rows[i].cells[1].innerHTML);
            if(sel.checked){

                $data = "";
                $flagSave = true;

                formData.append("numeroCuotas",tab.rows[i].cells[1].innerHTML);
                formData.append("tipoSolicitud","C");
                formData.append("mesesDiferido",tab.rows[i].cells[2].innerHTML);
                formData.append("valorCuota",tab.rows[i].cells[3].innerHTML);
                formData.append("montoSolicitado",tab.rows[i].cells[5].innerHTML);
                formData.append("costoTotal",tab.rows[i].cells[6].innerHTML);
                formData.append("tasaInteres",tab.rows[i].cells[7].innerHTML);
                formData.append("impuestos",tab.rows[i].cells[8].innerHTML);
                formData.append("comision",tab.rows[i].cells[9].innerHTML);
                formData.append("cae",tab.rows[i].cells[10].innerHTML);
                formData.append("montoBruto",tab.rows[i].cells[4].innerHTML);
                formData.append("costoTotalSeguro1",tab.rows[i].cells[11].innerHTML);
                formData.append("costoTotalSeguro2",tab.rows[i].cells[12].innerHTML);
                formData.append("nroRut",$('#masked_rut_client').val());
                formData.append("vencimientoCuota",$('#dateFirstExpiration').val());

                if(secureOne.checked){
                    formData.append("codSeguro1",$(secureOne).data("cod"));
                    formData.append("idPolizaSeguro1",$(secureOne).data("pol"));

                    if( (!$('#yesEmailSecureOne').is(":checked"))&&(!$('#noEmailSecureOne').is(":checked")) ) {
                        toastr.warning("Seguro "+$(secureOne).data('descrip')+"</br>Requiere completar autorizaci&#243;n Email!","Preste Atenci&#243;n");
                        return(false);
                    }
                    if( ((!$('#yesdps-1-secure-one').is(":checked"))&&(!$('#nodps-1-secure-one').is(":checked")))||
                        ((!$('#yesdps-2-secure-one').is(":checked"))&&(!$('#nodps-2-secure-one').is(":checked")))||
                        ((!$('#yesdps-3-secure-one').is(":checked"))&&(!$('#nodps-3-secure-one').is(":checked"))) ) {
                        toastr.warning("Seguro "+$(secureOne).data('descrip')+"</br>Requiere completar DPS!","Preste Atenci&#243;n");
                        return(false);
                    }
                    if($('#yesdps-1-secure-one').is(":checked")||$('#yesdps-2-secure-one').is(":checked")||$('#yesdps-3-secure-one').is(":checked")){
                        toastr.warning("No puede vender seguro "+$("#secureOne").data("descrip")+"</br>Por declaración de Salud cliente</br>Desactive el seguro.","Presta Atenci&#243;n");
                        return(false);
                    }

                    formData.append("useEmail1","1");
                    if($('#yesdpsSecureOne').is(":checked")) { formData.append("declareDps","1"); } else { formData.append("declareDps","0");  }

                }
                if(secureTwo.checked){

                    formData.append("codSeguro2",$(secureTwo).data('cod'));
                    formData.append("idPolizaSeguro2",$(secureTwo).data('pol'));

                    if( (!$('#yesEmailSecureTwo').is(":checked")) &&
                        (!$('#noEmailSecureTwo').is(":checked")) ) {
                        toastr.warning("Debe atender informaci&#243;n Desgravamen!","Requiere completar Informaci&#243;n Autorizaci&#243;n Email");
                        return(false);
                    }

                    if($('#yesEmailSecureTwo').is(":checked")) { formData.append("useEmail2","1"); } else { formData.append("useEmail2","0"); }
                    formData.append("typeBeneficiaries", "legal");

                }

                if($("#formPay").is(":checked")){

                    if($('#bank').val()==""||$('#typeAccount').val()==""||$('#numberAccount').val()=="") {
                        toastr.warning("Debe Completar Datos Bancarios cliente para transferencia","Preste Atenci&#243;n......");
                        return(false);
                    }
                    formData.append("bank",$('#bank').val());
                    formData.append("typeAccount",$('#typeAccount').val());
                    formData.append("numberAccount",$('#numberAccount').val());

                }else{

                    formData.append("bank","");
                    formData.append("typeAccount","");
                    formData.append("numberAccount","");
                }

                /*Valid Datos para Pago enlazado a otra sucursal*/
                if($("#dateLinked").val()=="") { formData.append("estadoEnlace",""); formData.append("sucursalDestino",""); formData.append("fechaCompromisoEnlace",""); } else {  formData.append("estadoEnlace","ENL"); formData.append("sucursalDestino",$("#officeLinked").val()); formData.append("fechaCompromisoEnlace",$("#dateLinked").val()); }

                formData.append("offerType",$("#offerType").val());
                formData.append("emailCuenta",$("#emailClient").val());
                formData.append("telefonoCuenta",$("#phoneClient").val());
                formData.append("emailClientNew",$("#emailClientNew").val());

                if($("#formPay").is(":checked")){

                    if($("#emailClient").val()==""&&$("#emailClientNew").val()=="") {
                        Alert.showWarning("Preste Atenci&oacute;n..", "Debe ingresar Email del Cliente...");
                        return(false);
                    }
                }

                var response = Teknodata.call_ajax("/advance/put_simulate", formData, false, true,  ".btn-ok");

                if(response!=false){

                    if(response.retorno==0) {

                        $('#idDocument').val(response.idDocument);
                        toastr.success(response.descRetorno, "Preste Atención..");
                        Client.initAuthorization();

                    }else{

                        Alert.showWarning("Preste Atención..", response.descRetorno, "");
                        return(false);
                    }

                }

            } //End checked
            } //End for

            if(!$flagSave){
                toastr.warning("Revise negociación Antes de Grabar ..", "Preste Atención"); return(false);
            }

            return (true);
        },
        selectOffer: function(obj) {
            $("#numberQuotas").prop('disabled', false);
            $("#deferredQuotas").prop('disabled', false);

                var response = JSON.parse($("#datajson").val());
                for(i=0;i<response.offerDetail.length;i++){

                    if(response.offerDetail[i].offerCode==obj.value){

                        $("#offerType").val(obj.value);
                        $("#offerAmount").val(Teknodata.maskMoney(response.offerDetail[i].offerAmount));
                        $("#offerRequest").val(Teknodata.maskMoney(response.offerDetail[i].offerAmount));
                        $("#numberQuotas").val(response.offerDetail[i].offerQuotas)
                        $("#deferredQuotas").val(response.offerDetail[i].offerDeferred)

                        if(response.offerDetail[i].flagQuotas){
                            $("#numberQuotas").prop('disabled', true);
                        }
                        if(response.offerDetail[i].flagDeferred){
                            $("#deferredQuotas").prop('disabled', true);
                        }

                    }
                }

            return(true);
        },
        loadOffers: function(response) {
            /*Datos de Contacto Cliente*/
            $("#label_nameClient").val(response.completeNameClient);
            $("#emailClient").val(response.email);
            $("#phoneClient").val(response.phone);
            $("#nameClient").val(response.nameClient);
            $("#sexoClient").val(response.sexoClient);

            /*Datos Negociación con Cliente*/
            $("#id_rol").val(response.id_rol);
            $("#flg_client").val(1);
            o = document.getElementById('offerSelector');
            o.innerHTML = response.offerSelector;
            $("#negotiation").collapse('show');

            if(response.montoOferta!="0"){ $("#offerRequest").val(response.montoOferta); 
                        $("#offer-inline-radio1").click();}
            if(response.montoPreaprobado!="0"){ $("#offerRequest").val(response.montoPreaprobado);
                            $("#offer-inline-radio2").click(); }

        },
        loadRequest: function(response) {

            var rut = $('#masked_rut_client').val();

            var tasaMaxima = String(response.tasaMaxima);
            var tasaRequest = String(response.tasaRequest);

            if(Number(tasaMaxima) < Number(tasaRequest)) {
                $("#message").val("Cotización vigente excede Tasa Máxima..<br>Crear nueva Cotización!!");
                return(false);
            }
            var datajson = JSON.parse($("#datajson").val()); Client.loadOffers(datajson);

            $(".btn-simulate").prop('disabled', true);
            $("#amountApproved").prop('disabled', true);

            if(response.tipoOferta=="AP"){

                $("#offer-inline-radio1").attr("checked", true);

            }else{

                $("#offer-inline-radio2").attr("checked", true);
            }

            $("#offer-inline-radio1").prop("disabled", true);
            $('#offer-inline-radio2').prop('disabled', true);

            $("#offerRequest").val(Teknodata.maskMoney(response.montoLiquido));
            $("#offerRequest").prop('disabled', true);

            $('#amountApproved').val(response.montoLiquido);
            $('#numberQuotas').val(response.plazoDeCuota);
            $('#numberQuotas').prop('disabled', true);
            $('#deferredQuotas').prop('disabled', true);
            $('#interesRate').val(response.tasaDeInteresMensual);
            $('#dateFirstExpiration').val(response.fechaPrimerVencimiento);
            $("#emailClient").val(response.email);
            if(response.fonoMovil!=""){ $("#phoneClient").val(response.fonoMovil); } else { $("#phoneClient").val(response.fonoFijo); }

            $("#yesdpsSecureOne").prop("disabled", true);
            $("#nodpsSecureOne").prop("disabled", true);

            $("#legalBeneficiary").prop("disabled", true);
            $("#otherBeneficiary").prop("disabled", true);

            if(response.modoEntrega=="TEF"){
                $("#formPay").attr("checked", true);
                $('#formPay').prop('disabled', true);
                $('#bank').val(response.banco);
                $('#bank').prop('disabled', true);
                $('#typeAccount').val(response.tipoCuenta);
                $('#typeAccount').prop('disabled', true);
                $('#numberAccount').val(response.numeroCuenta);
                $('#numberAccount').prop('disabled', true);
            }else {
                $("#formPay").attr("checked", false);
                $('#formPay').prop('disabled', true);
                $('#bank').val("");
                $('#bank').prop('disabled', true);
                $('#typeAccount').val("");
                $('#typeAccount').prop('disabled', true);
                $('#numberAccount').val("");
                $('#numberAccount').prop('disabled', true);
            }

            if(response.flagSeguro1=="CON SEGURO"){

                var obj = document.getElementById("label"+response.htmlName1);
                obj.innerHTML=" [ACEPTADO]";
                obj = document.getElementById(response.htmlName1);
                obj.checked=true;
                obj.disabled=true;

            }else{

                var obj = document.getElementById("label"+response.htmlName1);
                obj.innerHTML=" [RECHAZADO]";
                obj = document.getElementById(response.htmlName1);
                obj.checked=false;
                obj.disabled=true;
            }

            if(response.flagSeguro2=="CON SEGURO"){

                var obj = document.getElementById("label"+response.htmlName2);
                obj.innerHTML=" [ACEPTADO]";
                obj = document.getElementById(response.htmlName2);
                obj.checked=true;
                obj.disabled=true;

            }else{

                var obj = document.getElementById("label"+response.htmlName2);
                obj.innerHTML="[RECHAZADO]";
                obj = document.getElementById(response.htmlName2);
                obj.checked=false;
                obj.disabled=true;
            }

            o = document.getElementById('simulate');
            o.innerHTML = response.htmlSimulate; $('#simulate').click();

            if(response.estado=="I"||response.estado=="PE"||response.estado=="CO"){
                $('#idDocument').val(response.idDocument);
                $('#idEstado').val(response.estado);
                Client.initAuthorization();
            }
            if(response.estado=="PA"||response.estado=="AU"){
                $('#idDocument').val(response.idDocument);
                $('#idEstado').val(response.estado);
                Client.initExecutive();
            }

            if(response.montoOferta>0){ $("#offerRequest").val(Teknodata.formatMoneda(response.montoOferta)); }
            if(response.montoPreaprobado>0){ $("#offerRequest").val(Teknodata.formatMoneda(response.montoPreaprobado)); }

            $("#approbation").collapse('show');
            $("#negotiation").collapse('hide');
            $("#payment").collapse('hide');
            return(true);

        },
        prepare: function() {

            Client.clearForm("form-client");
            Client.clearForm("form-negotiation");

            $("#masked_rut_client").prop('disabled', false); $("#emailClient").prop('disabled', true); $("#phoneClient").prop('disabled', true); $("#approbation").click();

            /*clear datos forma de pago*/
            $("#bank").val(""); $("#typeAccount").val(""); $("#numberAccount").val("");
            $("#bank").prop("disabled", false); $("#typeAccount").prop("disabled", false); $("#numberAccount").prop("disabled", false);
            $("#emailClientNew").val("");

            /*clear datos negociacion y seguros*/
            document.getElementById('simulate').innerHTML = "";
            document.getElementById('offerSelector').innerHTML = "";
            $("#dataBeneficiary tbody").empty();
            $("#tabSimulate tbody").empty();
            $(".btn-simulate").prop('disabled', false);
            $(".btn-save").prop('disabled', false);
            $(".btn-confirm").prop('disabled', true);
            $(".btn-print").prop('disabled', true);
            $(".btn-send").prop('disabled', true);
            $("#numberQuotas").prop("disabled", false);
            $("#deferredQuotas").prop("disabled", false);

            $("#offerSelector").prop('disabled', false);
            $("#offerRequest").prop('disabled', false);

            $("#yesdpsSecureOne").attr("checked", false);
            $("#nodpsSecureOne").attr("checked", false);
            $("#legalBeneficiary").attr("checked", false);
            $("#otherBeneficiary").attr("checked", false);

            $("#yesdpsSecureOne").prop("disabled", false);
            $("#nodpsSecureOne").prop("disabled", false);
            $("#legalBeneficiary").prop("disabled", false);
            $("#otherBeneficiary").prop("disabled", false);

            $("#deferredQuotas").val("0");
            $("#numberQuotas").val("0");

          /*close ventanas opcionales*/
          $("#approbation").collapse('hide');
          $("#negotiation").collapse('hide');
          $("#secure1").collapse('hide');
          $("#secure2").collapse('hide');
          $("#lblformPay").html("Efectivo");
          $("#payment").collapse('hide');
          $("#formPay").prop("checked", false);

          var response = JSON.parse($("#dataload").val());
          if(response.source=="valid") { Client.search(); $("masked_rut_client").prop("readonly", true); } else { Client.processHide(); }

          $("#flg_client").val(0);
          $("#masked_rut_client").focus();

        },
        clearForm: function(nameForm) {
            var form  = document.getElementById(nameForm);
            for (var i=0;i<form.elements.length;i++) {
                if(form.elements[i].type == "text") form.elements[i].value = "";
            }
        },
        initSimulate: function(response) {
            o = document.getElementById('simulate');
            o.innerHTML = response.htmlSimulate;
            $('#simulate').click();
            $("#dateFirstExpiration").val(response.dateFirstExpiration);
            $("#interesRate").val(response.interesRate+"%");
            $("#secureOne").prop("disabled", false);$("#secureTwo").prop("disabled", false);
            $("#formPay").prop("disabled", false);
        },


        initOffers: function(response) {
            $("#label_nameClient").val(response.nameClient);
            $("#label_birthDate").val(response.birthDate);
            $("#label_diffYear").val(response.diffYear);

            $("#amountApproved").val(Teknodata.maskMoney(0));
            $("#amountPreApproved").val(Teknodata.maskMoney(0));

            $("#amountApproved").prop('disabled', false);
            $("#amountPreApproved").prop('disabled', true);

        },
        loadBeneficiary: function(obj) {

            Alert.showBeneficiary("Beneficiarios Seguro Vida y Desgravamen");
            return(false);

        },

        formPay: function(val){

            if(val.checked){
                $("#paymentType").val("transfer");
                $("#lblformPay").html("Transferencia");
                $("#payment").collapse("show");

            }else{

                $("#paymentType").val("cash");
                $("#lblformPay").html("Efectivo");
                $("#payment").collapse("hide");
            }

        },

        checkSecure: function(obj) {
            if($('#masked_rut_client').val()==""){
                let result = obj.checked ? obj.checked = false : obj.checked = true;
                return(false);
            }
            var label = "label"+obj.id;
            if(obj.checked){ document.getElementById(label).innerHTML = "[ACEPTADO]";
                $("#yesdpsSecureOne").attr("checked", false);
                $("#nodpsSecureOne").attr("checked", false);
                }
            else{ document.getElementById(label).innerHTML = "[RECHAZADO]";
                Alert.showWarning('Advertencia',$(obj).data('target'),"md"); }
            $('.btn-simulate').click();
        },
        showScriptSecure: function(secure) {

            if($("#flg_client").val()==1){

            var obj = document.getElementById(secure); var script = $(obj).data('script');
            if($("#sexoClient").val()=="FEM"){
              attention = "Sra./Srta.: "+$("#nameClient").val();
            }else{
              attention = "Don: "+$("#nameClient").val();
            }
            if(secure=="secureOne"){ $("#secure1").collapse("hide"); } else { $("#secure2").collapse("hide"); }

            var re = /#attention/g; script = script.replace(re, attention);
            Alert.showWarning("",script,"lg");

            }

        },
        cancelSecureOne: function(obj) {
            if($('#masked_rut_client').val()==""){
                let result = obj.checked ? obj.checked = false : obj.checked = true;
                return(false);
            }
            if(obj.id=="yesdpsSecureOne"&&obj.checked){
                $("#secureOne").attr("checked", false);
                var label = "labelsecureOne";
                document.getElementById(label).innerHTML = "[DESACTIVADO POR DPS]";
                $('.btn-simulate').click();
            }
            if(obj.id=="nodpsSecureOne"&&obj.checked){
                $("#secureOne").attr("checked", true);
                var label = "labelsecureOne";
                document.getElementById(label).innerHTML = "[ACEPTADO]";
                $('.btn-simulate').click();
            }
        },
        yesDPS: function() {
          $("#yesdpsSecureOne").prop("checked", true);
          $("#nodpsSecureOne").prop("checked", false);
          $("#secureOne").prop("checked", false);
          var label = "labelsecureOne";
          document.getElementById(label).innerHTML = "[DESACTIVADO POR DPS]";
          $(".btn-simulate").click();
        },
        noDPS: function() {
          $("#yesdpsSecureOne").prop("checked", false);
          $("#nodpsSecureOne").prop("checked", true);
          $("#secureOne").prop("checked", true);
          var label = "labelsecureOne";
          document.getElementById(label).innerHTML = "[ACEPTADO]";
          $(".btn-simulate").click();
        },
        yesVIDA: function() {
          $("#secureTwo").prop("checked", true);
          var label = "labelsecureTwo";
          document.getElementById(label).innerHTML = "[ACEPTADO]";
          $(".btn-simulate").click();
        },
        noVIDA: function() {
          $("#secureTwo").prop("checked", false);
          var label = "labelsecureTwo";
          document.getElementById(label).innerHTML = "[RECHAZADO]";
          $(".btn-simulate").click();
        },
        selectRequest: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idRequest = tabTD[1].innerText;
            var idCheck = "sel"+idRequest;
            document.getElementById(idCheck).checked = true;
        },
        selectOffers: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idRequest = tabTD[1].innerText;
            var idCheck = "sel1";
            document.getElementById(idCheck).checked = true;
        },
        get_ClientByRut: function() {
            Client.search();
        },
        search: function() {

            var rut = $("#masked_rut_client").val();

            var evaluation = JSON.parse($("#dataload").val());
            if(evaluation.source=="valid") { rut = evaluation.nroRut; } else { Client.prepare(); }

            $("#masked_rut_client").val(rut); $("#masked_rut_client").prop('disabled', true); $("#flg_client").val(0);

            var formData = new FormData();
            formData.append("nroRut", rut);

            var response = Teknodata.call_ajax("/advance/evaluation_client", formData, false, true,  false);
            if(response!=false){

                $("#datajson").val(JSON.stringify(response));
                switch (response.retorno) {
                case 0:

                    if(evaluation.source=="valid") {

                            var formData = new FormData();
                            formData.append("id", evaluation.idDocument);

                            var response = Teknodata.call_ajax("/advance/get_requestById", formData, false, true,  false);
                            if(response!=false){

                                if(response.retorno == 0 ) {

                                    if(!Client.loadRequest(response)){

                                        $.confirm({
                                            title: 'Preste Atención!',
                                            content: $("#message").val(),
                                            buttons: {
                                                search: {
                                                    text: 'Volver a buscar',
                                                    btnClass: 'btn-blue',
                                                    keys: ['enter', 'shift'],
                                                    action: function(){
                                                        $.redirect("/advance/search");
                                                    }
                                                },
                                                create: {
                                                    text: 'Crear',
                                                    btnClass: 'btn-green',
                                                    keys: ['enter', 'shift'],
                                                    action: function(){
                                                        $.redirect("/advance/create");
                                                    }
                                                }
                                            }
                                        });

                                    }

                                } else {

                                    Alert.showWarning(response.descRetorno, "");
                                }
                            }

                    } else {

                        Client.loadOffers(response);
                    }
                    $("#approbation").collapse('show');
                    break;

                case 9:

                    Alert.showWarning("Preste Atención","Cliente no registra Oferta","sm");
                    Client.prepare();
                    $("#masked_rut_client").prop('disabled', false);
                    break;

                case 10:

                    Alert.init();Alert.showSearch("",response.descRetorno);
                    $("#masked_rut_client").prop('disabled', false);
                    break;

                case 11:

                    if(evaluation.source=="valid") {

                        var formData = new FormData();
                        formData.append("id", evaluation.idDocument);

                        var response = Teknodata.call_ajax("/advance/get_requestById", formData, false, true,  false);
                        if(response!=false){

                            if(response.retorno == 0 ) {

                                if(!Client.loadRequest(response)){

                                    $.confirm({
                                        title: 'Preste Atención!',
                                        content: $("#message").val(),
                                        buttons: {
                                            search: {
                                                text: 'Volver a buscar',
                                                btnClass: 'btn-blue',
                                                keys: ['enter', 'shift'],
                                                action: function(){
                                                    $.redirect("/advance/search");
                                                }
                                            },
                                            create: {
                                                text: 'Crear',
                                                btnClass: 'btn-green',
                                                keys: ['enter', 'shift'],
                                                action: function(){
                                                    $.redirect("/advance/create");
                                                }
                                            }
                                        }
                                    });

                                }

                            } else {

                                Alert.showWarning(response.descRetorno, "");
                            }
                        }
                        $("#approbation").collapse('show');

                    }else{

                        Alert.init();Alert.showRequest(response.titleRequest,response.htmlRequest);
                    }
                    break;

                default:

                    /*Error Controlado*/
                    Alert.showToastrError(response);
                    $("#masked_rut_client").prop('disabled', false);
                    break;
                }
            }

        },

        initAuthorization: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPay").prop("disabled", true);
        },
        initExecutive: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', true);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', true);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPay").prop("disabled", true);
        },
        initPrint: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPay").prop("disabled", true);
        },
        initSend: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-linked").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPay").prop("disabled", true);
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
