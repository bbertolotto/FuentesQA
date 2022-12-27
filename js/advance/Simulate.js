/**
/**
 *  Document   : advance/Simulate.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones busqueda clientes SAV
**/
$(function () {

    $('.btn-simulate').on('click', function () {
        var o = document.getElementById("masked_rut_client");
        if(o.value==""){
            toastr.warning("Antes de Simular, debe ingresar RUT Cliente ..","Presta Mucha Atención ..!");
            return(false);
        }

        Client.processShow();

        $data = "nroRut="+$("#masked_rut_client").val();$data += "&offerRequest="+$("#amountSimulate").val(); $data += "&offerAmount="+$("#amountSimulate").val(); $data += "&numberQuotas="+$("#numberQuotas").val();$data += "&deferredQuotas="+$("#deferredQuotas").val();$data += "&amountLimit=0";$data += "&amountType=0"; $data += "&offerType=AP";
        if(document.getElementById('secureOne').checked){$data += "&secureOne="+document.getElementById('secureOne').value;}else{$data += "&secureOne=";}
        if(document.getElementById('secureTwo').checked){$data += "&secureTwo="+document.getElementById('secureTwo').value;}else{$data += "&secureTwo=";}

        o = document.getElementById('simulate');o.innerHTML = "";
        console.log($data);

        $.ajax( {
            url: "/advance/get_simulate", type: "POST", dataType: "json",
            data : $data,
            success: function(response, status, xhr){

                    switch (response.retorno) {

                    /* Cliente con Oferta Vigente*/
                    case 0:

                        o = document.getElementById('simulate');
                        o.innerHTML = response.htmlSimulate;
                        $("#simulate").click();
                        $("#dateFirstExpiration").val(response.dateFirstExpiration);
                        $("#interesRate").val(response.interesRate+"%");
                        Client.processHide();
                    break;

                    case 11:
                        Client.processHide();
                        Alert.init();Alert.showWarning("",response.descRetorno);
                    break;

                    default:
                        Client.processHide();
                        Alert.showToastrWarning(response);
                    break;
                    }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Alert.showToastrErrorXHR(jqXHR, textStatus);
            }

        });

    return(false);
    });

    $('.btn-reset').on('click', function () {

        Client.prepare();
    });


    $('.btn-send').on('click', function () {

        if($("#flg_print").val()!="print") { toastr.warning("Debe Imprimir Cotización Antes de Enviar Por Mail","Preste Atención"); return(false); }
        $data = "idDocument="+$("#idDocument").val()+"&emailCuenta="+$("#emailCuenta").val()+"&nombreCliente="+$("#label_nameClient").val()+"&estadoTEF=simula";
        $.ajax( { url: "/advance/send_Simulate", type: "POST", dataType: "json", data : $data ,
          beforeSend: function(){ Client.processShow(); $(".btn-send").prop('disabled', true); }, complete: function(){ Client.processHide(); },
          success: function(response, status, xhr) {

            if(response.retorno==0 ) { toastr.success("Simulación Enviado por correo con éxito","Preste Atención"); } else { Alert.showToastrWarning(response); $(".btn-send").prop('disabled', false);  }

          },

          error: function(jqXHR, textStatus, errorThrown) {

            Alert.showToastrErrorXHR(jqXHR, textStatus);
            $(".btn-send").prop('disabled', false);

          }


        });



    });


    $('.btn-print').on('click', function () {

        Client.processShow();
        $(".btn-print").prop('disabled', true);
        console.log($('#idDocument').val());
        $data = "id="+$('#idDocument').val();$data+= "&type=SIM";$data+= "&status=I";

        $.ajax( {
            url: "/advance/generaPDF", type: "POST", dataType: "json",
            data : $data,
            beforeSend: function() {

            },
            success: function(response, status, xhr){

                Client.processHide();
                if(response.retorno==0){

                    $("#flg_print").val("print");
                    toastr.success("Simulaci&#243;n marcada como "+response.glosaEstado, "Preste Atenci#243;n !");

                    window.open("/advance/readPDF", '_blank');
                }else {

                    toastr.warning(response.descRetorno, "Preste Atenci#243;n !");

                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Alert.showToastrErrorXHR(jqXHR, textStatus);
            }

        });

        return(false);

    });


    $('.btn-save').on('click', function () {

        if($('#masked_rut_client').val()==""){
            toastr.warning("Debe ingresar RUT Cliente y simular, antes de Grabar Simulación..","Presta Mucha Atención ..!");
            return(false);
        }

        var secureOne = document.getElementById('secureOne');
        var secureTwo = document.getElementById('secureTwo');

        var tab = document.getElementById('tabSimulate');
        for (var i=1;i < tab.rows.length; i++){

        /* Selecciona CheckBox con Opción Cliente*/
        sel = document.getElementById("sel"+tab.rows[i].cells[1].innerHTML);
        if(sel.checked){

            $data ="numeroCuotas="+tab.rows[i].cells[1].innerHTML;$data+="&tipoSolicitud=S";$data+="&mesesDiferido="+tab.rows[i].cells[2].innerHTML;$data+="&valorCuota="+tab.rows[i].cells[3].innerHTML;$data+="&montoBruto="+tab.rows[i].cells[4].innerHTML;$data+="&montoSolicitado="+tab.rows[i].cells[5].innerHTML;$data+="&costoTotal="+tab.rows[i].cells[6].innerHTML;$data+="&tasaInteres="+tab.rows[i].cells[7].innerHTML;$data+="&impuestos="+tab.rows[i].cells[8].innerHTML;$data+="&comision="+tab.rows[i].cells[9].innerHTML;$data+="&cae="+tab.rows[i].cells[10].innerHTML;$data+="&costoTotalSeguro1="+tab.rows[i].cells[11].innerHTML;$data+="&costoTotalSeguro2="+tab.rows[i].cells[12].innerHTML;$data+="&nroRut="+$('#masked_rut_client').val();$data+="&vencimientoCuota="+$('#dateFirstExpiration').val();
            if(secureOne.checked){
                $data+="&codSeguro1="+$(secureOne).data('cod');
                $data+="&idPolizaSeguro1="+$(secureOne).data('pol');
            }
            if(secureTwo.checked){
                $data+="&codSeguro2="+$(secureTwo).data('cod');
                $data+="&idPolizaSeguro2="+$(secureTwo).data('pol');
            }

            $data+="&bank=&typeAccount=&numberAccount=&estadoEnlace=&sucursalDestino&offerType=&fechaCompromisoEnlace=&emailClientNew=";

            $.ajax( {
                url: "/advance/put_simulate", type: "POST", dataType: "json",
                data : $data,
                success: function(response, status, xhr){

                    if(response.retorno==0) {

                        $("#idDocument").val(response.idDocument);
                        Client.processHide();
                        toastr.success(response.descRetorno, "Preste Atención ..");
                        Client.initPrint();

                    }else{

                        Client.processHide();
                        Alert.showToastrWarning(response);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Alert.showToastrErrorXHR(jqXHR, textStatus);
                }

            });

        } //End checked
        } //End for

    Client.processHide();
    return(false);
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
        prepare: function() {
            var o = document.getElementById("amountSimulate"); Teknodata.formatMoneda(o);
            o = document.getElementById('simulate');
            o.innerHTML = ""; $('#simulate').click();
            Client.clearForm("form-client");
            Client.clearForm("form-simulate");
            $(".btn-save").prop('disabled', false);
            $(".btn-print").prop('disabled', true);
            $(".btn-send").prop('disabled', true);
            $(".btn-simulate").prop('disabled', false);
            $("#secureOne").prop('disabled', false);
            $("#secureTwo").prop('disabled', false);
        },
        clearForm: function(nameForm) {
            var form  = document.getElementById(nameForm);
            for (var i=0;i<form.elements.length;i++) {
                if(form.elements[i].type === "text") form.elements[i].value = "";
            }
        },
        checkSecure: function(obj) {

            if(document.getElementById('masked_rut_client').value==""){
                let result = obj.checked ? obj.checked = false : obj.checked = true;
                return(false);
            }
            if(!obj.checked){ Alert.showWarning('Advertencia',$(obj).data('target')); }
            $('.btn-simulate').click();
        },

        initPrint: function () {

            $("#secureOne").prop('disabled', true);
            $("#secureTwo").prop('disabled', true);
            $(".btn-simulate").prop('disabled', true);
            $(".btn-save").prop('disabled', true);
            $(".btn-print").prop('disabled', false);
            $(".btn-send").prop('disabled', false);

        },
        changeColor: function (e) {

            var tabTD = e.getElementsByTagName("td");
            var numberQuota = tabTD[1].innerText;
            var idCheck = "sel"+numberQuota;
            document.getElementById(idCheck).checked = true;
            document.getElementById("interesRate").value = tabTD[7].innerText;

        },
        get_ClientByRut: function() {
            Client.search();
        },
        search: function() {

            var formData = new FormData();
            formData.append("nroRut", $("#masked_rut_client").val());
            var response = Teknodata.call_ajax("/advance/get_client", formData, false, true, ".btn-success");

            if(response!=false){

                $("#label_nameClient").val(response.nameClient+" "+response.last_nameClient);
                $("#emailCuenta").val(response.email);
                $("#telefonoCuenta").val(response.phone);

                switch (response.retorno) {

                /* Cliente con Oferta Vigente*/
                case 10:
                    Client.initConOferta(response);
                    $('.btn-simulate').click();
                    Client.processHide();
                break;

                /* No es Cliente */
                case 11:
                    Client.processHide();
                    Alert.init();Alert.showSearch("",response.descRetorno);
                break;

                /* Cliente sin Oferta Vigente*/
                case 12:
                    Client.processHide();
                    Client.initSinOferta(response);
                    Alert.init();Alert.showWarning(response.descTitle,response.descRetorno);
                break;

                default:
                    Client.processHide();
                    Alert.showToastrError(response);
                break;
                }

            }

/***

            Client.processShow();

            $data = "nroRut="+$('#masked_rut_client').val();

            $.ajax( {
                url: "/advance/get_client", type: "POST", dataType: "json",
                data : $data,
                success: function(response, status, xhr){




                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Alert.showToastrErrorXHR(jqXHR, textStatus);
                }

            });
****/
        },
        initConOferta: function(response) {
            document.getElementById('amountSimulate').value = Teknodata.maskMoney(response.amountSimulate);
            document.getElementById('numberQuotas').value = response.numberQuotas;
            var o = document.getElementById('deferredQuotas');
            o.value = $(o).data('target');
        },
        initSinOferta: function(response) {
            document.getElementById('label_nameClient').value = response.nameClient + ' ' + response.last_nameClient;
            var o = document.getElementById('amountSimulate');
            o.value = Teknodata.maskMoney(0);
            var o = document.getElementById('numberQuotas');
            o.value = $(o).data('target');
            var o = document.getElementById('deferredQuotas');
            o.value = $(o).data('target');

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
