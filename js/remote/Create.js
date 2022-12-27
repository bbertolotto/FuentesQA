/**
 *  Document   : Create.js
 *  Author     : TeknodataSystems
**/
/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {
    $('.btn-accept-offer').on('click', function () {
      Client.accept_offer();
    });
    $('.btn-new-offer').on('click', function () {
        Client.new_offer();
    });
});

var Jsonn = function() {
    return {
      evalXML: function(response) {
        try {
            JSON.parse(response);
        } catch (e) {
            Alert.showAlert(e);console.error(e);return(false);
        }
        return(true);
      },
      parse: function(response) {
        return(JSON.parse(response));
      }
    };
}();

var Client = function() {
    return {
      onclickDps1: function() {
        var slider = document.getElementById("sel_secure_1");
        var output = document.getElementById("msg_secure_1");
        slider.checked=false;slider.name="cancel";slider.disabled=true;
        output.innerHTML = "[INHABILIDATO]";
      },
      onclickDps2: function() {
        var slider = document.getElementById("sel_secure_1");
        var output = document.getElementById("msg_secure_1");
        slider.checked=true;slider.name="success";slider.disabled=false;
        output.innerHTML = "[ACEPTADO]";
      },
      onclickSecure1: function() {
        var slider = document.getElementById("sel_secure_1");
        var output = document.getElementById("msg_secure_1");
        if(slider.name=="success"){
            slider.name="cancel";
            output.innerHTML = "[RECHAZADO]";
            Alert.showWarning('Advertencia','Recuerde que al renunciar a este seguro, en caso de enfermedad grave del asegurado, no tendr&#225; la cobertura que le permite cancelar el saldo insoluto de la deuda y tampoco tendr&#225; la indemnizaci&#243;n correspondiente a la diferencia restante entre saldo insoluto y monto inicial del S&#250;per avance para el asegurado titular.');
        }else{
            slider.name="success";
            output.innerHTML = "[ACEPTADO]";
        }
      },
      onclickSecure2: function() {
        var slider = document.getElementById("sel_secure_2");
        var output = document.getElementById("msg_secure_2");
        if(slider.name=="success"){
            slider.name="cancel";
            output.innerHTML = "[RECHAZADO]";
            Alert.showWarning('Advertencia','Recuerde que al renunciar a este seguro, en caso de fallecimiento del asegurado no tendr&#225; la cobertura que le permite cancelar el saldo insoluto de la deuda y tampoco tendr&#225; la indemnizaci&#243;n del 80% del monto inicial del S&#250;per avance para sus beneficiarios designados, o en su defecto, herederos legales.');
        }else{
            slider.name="success";
            output.innerHTML = "[ACEPTADO]";
        }
      },
      approve1: function() {
        var a = document.getElementById('opt_approve1');var b = document.getElementById('opt_approve2');var c = document.getElementById('val_approve1_amount');var d = document.getElementById('val_approve2_amount');
        if(a.checked){a.checked=true;b.checked=false;c.disabled=false;d.disabled=true;d.value="";}
        else{a.checked=false;b.checked=true;c.disabled=true;d.disabled=false;c.value="";}
      },
      approve2: function() {
        var a = document.getElementById('opt_approve1');var b = document.getElementById('opt_approve2');var c = document.getElementById('val_approve1_amount');var d = document.getElementById('val_approve2_amount');
        if(b.checked){b.checked=true;a.checked=false;c.disabled=true;d.disabled=false;c.value="";}
        else{b.checked=false;a.checked=true;c.disabled=false;d.disabled=true;d.value="";}
      },
      topay1: function() {
        var a = document.getElementById("transfer");
        var b = document.getElementById("sel_topay1");var c = document.getElementById("sel_topay2");
        if(b.checked){b.checked=true;c.checked=false;a.style.display="";}
        else{b.checked=false;c.checked=true;a.style.display="none";}
      },
      topay2: function() {
        var a = document.getElementById("transfer");
        var b = document.getElementById("sel_topay1");var c = document.getElementById("sel_topay2");
        if(c.checked){c.checked=true;b.checked=false;a.style.display="none";}
        else{c.checked=false;b.checked=true;a.style.display="";}
      },
      beneficiary: function() {
        var a = document.getElementById("sel_beneficiary");
        var b = document.getElementById("beneficiary");
        if(a.checked){b.style.display="none";}
        else{b.style.display="";}
      },
      evaluate: function() {
        var a = document.getElementById('masked_rut_client');
        if(a.value==""){
            Alert.showAlert("Debe Ingresar N&#250;mero RUT para Simular");return(false);}
        else{return(true);}
      },
      accept_offer: function() {
        e = document.getElementById("masked_rut_client");e.disabled = true;
        e = document.getElementById("label_name_client");e.disabled = true;
        e = document.getElementById("opt_approve1");e.checked = true;e.disabled = true;
        e = document.getElementById("val_approve1_amount");e.value="$1.750.000";e.disabled = true;
        e = document.getElementById("val_number_quotas");e.value="24";e.disabled = true;
        e = document.getElementById("val_deferred_quotas");e.value="0";e.disabled = true;
        e = document.getElementById("val_interest_rate");e.value="4.2%";e.disabled = true;
      },
      prepare: function() {
        e = document.getElementById("label_name_client");e.value="";e.disabled = false;
        e = document.getElementById("val_approve1_amount");e.value="";e.disabled = true;
        e = document.getElementById("val_approve2_amount");e.value="";e.disabled = true;
        e = document.getElementById("opt_approve1");e.disabled = true;
        e = document.getElementById("opt_approve2");e.disabled = true;
        e = document.getElementById("val_number_quotas");e.value="";e.disabled = true;
        e = document.getElementById("val_interest_rate");e.value="";e.disabled = true;
        e = document.getElementById("val_first_expiration_day");e.value="";e.disabled = true;
      },
      restore: function() {
        e = document.getElementById("val_deferred_quotas");e.value=0;e.disabled = false;
        e = document.getElementById("val_approve1_amount");e.value="";e.disabled = false;
        e = document.getElementById("val_approve2_amount");e.value="";e.disabled = true;
        e = document.getElementById("val_number_quotas");e.value=48;e.disabled = false;
        e = document.getElementById("val_interest_rate");e.value="2,95%";e.disabled = true;
        e = document.getElementById("val_first_expiration_day");e.value="10-01-2020";e.disabled = true;
        e = document.getElementById("opt_approve1");e.disabled = false;
        e = document.getElementById("opt_approve2");e.disabled = false;
      },
      search: function() {
        e = document.getElementById('masked_rut_client');
        var ourl="https://desarrollo.solventa.maximoerp.com/CallWSSolventa/get_advances?nroRut="+Teknodata.clear2(e.value);
        Client.prepare();
        $('#body-modal-search').load(ourl,function(response, status, xhr){
            if(status === "success") {
                  if(Jsonn.evalXML(response)){
                      response = Jsonn.parse(response);
                      if(response['retorno']!="000"){
                        Alert.initaccept_noclient();Alert.showSearch("",response['html']);
                        Client.restore();
                      } else {
                        e = document.getElementById("label_name_client");
                        e.value=response['name_client'];e.disabled = true;
                        if(response['eval']=="remoto"){
                            Alert.initaccept_noclient();Alert.showAlert(response['html']);
                        }
                        if(response['eval']=="consumo_vigente"){
                            Alert.initaccept_client();Alert.showWarning("S&#250;per Avance",response['html']);
                        }
                        if(response['eval']=="sav_vigente"){
                            Alert.initaccept_client();Alert.showWarning("S&#250;per Avance",response['html']);
                        }
                        if(response['eval']=="sin_campana"){
                            Alert.initaccept_client();Alert.showWarning("S&#250;per Avance",response['html']);
                        }
                        if(response['eval']=="cotiza_vigente"){
                            Alert.initaccept_client();Alert.showAdvance("S&#250;per Avance",response['html']);
                        }
                        Client.restore();
                      }
                  }
              }else{
                  Alert.init();Alert.showError(response);
              }
              return(true);
          });
        },
        init: function() {
            $.validator.addMethod("evalrut", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRut( value );
            });
            $.validator.addMethod("evalamount", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRange(value,250000,2500000);
            });
            $.validator.addMethod("evalamountoffer", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRange(value,1250000,5000000);
            });
            $('#form-client').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').addClass('has-success has-error');
                    $(e).closest('.help-block').remove();
                },
                unhighlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  if(Client.evaluate()){Client.search();}
                  else{return(false);}
                },
                rules: {
                    masked_rut_client: {required: false, evalrut: true, minlength: 5, maxlength: 12},
                },
                messages: {
                    masked_rut_client: {required:'Ingrese número RUT', evalrut:'Ingrese RUT valido!'},
                }
            });
            $('#form-action').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').addClass('has-succes has-error');
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
                submitHandler: function(e) {
                  if(!Client.evaluate()){return(false);}
                  btn = document.getElementById("btn-action");
                  theForm = document.getElementById("form-action");
                  if(btn.value=="print"){
                    theForm.action=btn.name;theForm.target="_blank";
                    theForm.submit();
                  };
                  if(btn.value=="send"){
                    Alert.showAlert("Correo enviado!");
                  }
                  if(btn.value=="save"){
                    Alert.showAlert("Datos grabados!");
                  }
                  if(btn.value=="link"){
                    Alert.showAlert("Enlace correcto!");
                  }
                },
                rules: {
                    val_approve1_amount: {required: true, evalamount: true},
                    val_approve2_amount: {required: true, evalamountoffer: true},
                },
                messages: {
                    val_approve1_amount: {required:'Ingrese Monto Oferta', evalamount:'Monto debe ser mayor a $250.000 y menor a $2.500.000'},
                    val_approve2_amount: {required:'Ingrese Monto Pre Aprobado', evalamountoffer:'Monto debe ser mayor a $1.250.000 y menor a $5.000.000'},
                }
            });
            // Initialize Masked Inputs
            // a - Represents an alpha character (A-Z,a-z)
            // 9 - Represents a numeric character (0-9)
            // * - Represents an alphanumeric character (A-Z,a-z,0-9)
            $('#masked_rut_client').mask('99.999.999-*');
            //$('#val_offer_amount').mask('9.999.999');
            //$('#val_interest_rate').mask('9.99%');
            //$('#masked_amount_sav').mask('99.999.999');
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
