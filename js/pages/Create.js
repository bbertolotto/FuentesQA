/**
 *  Document   : Create.js
 *  Author     : TeknodataSystems
**/
/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {

    $('.btn-search-client').on('click', function () {
        var target = $(this).data('target');
        var action = $(this).data('action');
        var ourl="http://localhost/desarrollo.solventa.maximoerp.com/CallWSSolventa/get_client";

        if(target=="accept_offer"){
            var theForm = document.getElementById("form-client");
            theForm.action=action;
            theForm.submit();
        }
        if(target=="new_offer"){
            Client.new_offer();
        }
        if(target=="accept_client"){
          $.ajax(
            {url: ourl, type: 'post', dataType: 'json'
              }).done( function () {
                  Client.restore();
              }).fail(function (jqXHR, textStatus, errorThrown) {
                  Alert.showAlert(errorThrown);console.error(errorThrown);
              }
              );
        }
    });

/*Botones creación SAV*/

    $('.btn-create').on('click', function () {
        var e = document.getElementById("btn-onclick");e.value = $(this).data('target1');e.action=$(this).data('action');
        if(e.value=="link-ok"){
            Alert.showAlert("Enlace OK");
        }
        if(e.value=="cancel"){
            Alert.showAlert("Enlace cancelado");
        }
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
        optionButton: function(button) {
          var a = document.getElementById("btn-link");
          var b = document.getElementById("btn-print");
          var c = document.getElementById("btn-email");
          var d = document.getElementById("btn-save");
          if(a.id=button){a.value=1;b.value=0;c.value=0;d.value=0;}
          if(b.id=button){a.value=0;b.value=1;c.value=0;d.value=0;}
          if(c.id=button){a.value=0;b.value=0;c.value=1;d.value=0;}
          if(d.id=button){a.value=0;b.value=0;c.value=0;d.value=1;}
          return(true);
        },
        approve1: function() {
          var a = document.getElementById('opt_approve1');var b = document.getElementById('opt_approve2');var c = document.getElementById('val_approve1_amount');
          if(a.checked){a.checked=true;b.checked=false;c.disabled=false;}
          else{a.checked=false;b.checked=true;c.disabled=true;}
        },
        approve2: function() {
          var a = document.getElementById('opt_approve1');var b = document.getElementById('opt_approve2');var c = document.getElementById('val_approve1_amount');
          if(b.checked){b.checked=true;a.checked=false;c.disabled=true;}
          else{b.checked=false;a.checked=true;c.disabled=false;}
        },
        topay1: function() {
          var a = document.getElementById('sel_topay1');var b = document.getElementById('sel_topay2');
          if(a.checked){a.checked=true;b.checked=false;}
          else{a.checked=false;b.checked=true;}
        },
        topay2: function() {
          var a = document.getElementById('sel_topay1');var b = document.getElementById('sel_topay2');
          if(b.checked){b.checked=true;a.checked=false;}
          else{b.checked=false;a.checked=true;}
        },
        evaluate: function() {
          var a = document.getElementById('masked_rut_client');
          if(a.value==""){
              Alert.showAlert("Debe Ingresar N&#250;mero RUT para Simular");return(false);}
          else{return(true);}
        },
        evaluate_create: function() {
          var a = document.getElementById('masked_rut_client');
          if(a.value==""){
              Alert.showAlert("Primero debe seleccionar un cliente para cotizar");return(false);}
          e = document.getElementById("val_approve1_amount");
          b = document.getElementById("opt_approve1");
          if(b.checked&&e.value==""){
              Alert.showAlert("Debe ingresar monto aprobado de oferta!");return(false);}
          e = document.getElementById("val_approve2_amount");
          b = document.getElementById("opt_approve2");
          if(b.checked&&e.value==""){
              Alert.showAlert("Debe ingresar monto pre-aprobado de oferta!");return(false);}
          e = document.getElementById("val_number_quotas");
          if(e.value==""){
              Alert.showAlert("Debe ingresar número de cuotas!");return(false);}
          e = document.getElementById("val_deferred_quotas");
          if(e.value==""){
              Alert.showAlert("Debe ingresar cuotas a diferir!");return(false);}
          e = document.getElementById("val_interest_rate");
          if(e.value==""){
              Alert.showAlert("Debe ingresar tasa de interes!");return(false);}
          return(true);

          e = document.getElementById("masked_rut_client");e.disabled = true;
          e = document.getElementById("label_name_client");e.disabled = true;
          e = document.getElementById("opt_approve1");e.checked = true;e.disabled = false;
          e = document.getElementById("opt_approve2");e.checked = false;e.disabled = false;
          e = document.getElementById("val_number_quotas");e.value="";e.disabled = false;
          e = document.getElementById("val_deferred_quotas");e.value="";e.disabled = false;
          e = document.getElementById("val_interest_rate");e.value="";e.disabled = false;
//          e = document.getElementById("sel_secure_1");e.checked=true;e.disabled = false;
//          e = document.getElementById("sel_secure_2");e.checked=true;e.disabled = false;
          e = document.getElementById("sel_topay1");e.checked=true;e.disabled = false;
          e = document.getElementById("sel_topay2");e.checked=false;e.disabled = false;
//          e = document.getElementById("btn_link");e.disabled = false;
//          e = document.getElementById("btn_simulate");e.disabled = false;
//          e = document.getElementById("btn_accept_offer");e.disabled = false;
        },
        accept_offer: function() {
          e = document.getElementById("masked_rut_client");e.disabled = true;
          e = document.getElementById("label_name_client");e.disabled = true;
          e = document.getElementById("opt_approve1");e.checked = true;e.disabled = true;
          e = document.getElementById("val_approve1_amount");e.value="$1.750.000";e.disabled = true;
          e = document.getElementById("val_number_quotas");e.value="24";e.disabled = true;
          e = document.getElementById("val_deferred_quotas");e.value="1";e.disabled = true;
          e = document.getElementById("val_interest_rate");e.value="4.2%";e.disabled = true;
//          e = document.getElementById("sel_secure_1");e.checked=true;e.disabled = true;
//          e = document.getElementById("sel_secure_2");e.checked=true;e.disabled = true;
          e = document.getElementById("sel_topay1");e.checked=true;e.disabled = false;
          e = document.getElementById("sel_topay2");e.checked=false;e.disabled = false;
//          e = document.getElementById("btn_link");e.disabled = false;
//          e = document.getElementById("btn_simulate");e.disabled = false;
//          e = document.getElementById("btn_accept_offer");e.disabled = false;
        },
        prepare: function() {
          e = document.getElementById("masked_rut_client");e.disabled = false;
          e = document.getElementById("label_name_client");e.value="";e.disabled = false;
          e = document.getElementById("opt_approve1");e.checked = true;
          e = document.getElementById("opt_approve2");e.checked = false;
          e = document.getElementById("val_approve1_amount");e.value="";e.disabled = true;
          e = document.getElementById("val_approve2_amount");e.disabled = true;
          e = document.getElementById("val_number_quotas");e.value="";e.disabled = true;
          e = document.getElementById("val_deferred_quotas");e.value="";e.disabled = true;
          e = document.getElementById("val_interest_rate");e.value="";e.disabled = true;
          e = document.getElementById("sel_topay1");e.checked=true;e.disabled = true;
          e = document.getElementById("sel_topay2");e.checked=false;e.disabled = true;
//          e = document.getElementById("btn_link");e.disabled = true;1
//          e = document.getElementById("btn_simulate");e.disabled = true;
//          e = document.getElementById("btn_accept_offer");e.disabled = true;

        },
        restore: function() {
          e = document.getElementById("val_approve1_amount");e.value="";e.disabled = false;
          e = document.getElementById("val_number_quotas");e.value="";e.disabled = false;
          e = document.getElementById("val_deferred_quotas");e.value="";e.disabled = false;
          e = document.getElementById("val_interest_rate");e.value="";e.disabled = false;
//          e = document.getElementById("sel_secure_1");e.checked=true;e.disabled = false;
//          e = document.getElementById("sel_secure_2");e.checked=true;e.disabled = false;
          e = document.getElementById("sel_topay1");e.checked=true;e.disabled = false;
          e = document.getElementById("sel_topay2");e.checked=false;e.disabled = false;
//          e = document.getElementById("btn_link");e.disabled = false;
//          e = document.getElementById("btn_simulate");e.disabled = false;
//          e = document.getElementById("btn_accept_offer");e.disabled = false;
        },
        search: function() {
          Client.prepare();e = document.getElementById('masked_rut_client');
          var ourl="http://localhost/desarrollo.solventa.maximoerp.com/CallWSSolventa/get_advances?nroRut="+Rutcl.clear2(e.value);
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
            return this.optional( element ) || Rutcl.validate( value );
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
            $('#form-create').validate({
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
                  if(Client.evaluate()){Client.search();}
                  else{return(false);}
                  var e = document.getElementById("btn-onclick");
                  if(e.value=="link"){Alert.showLink();}
                  if(e.value=="print"){
                      form.action=e.action;
                      form.submit();
                  }
                },
                rules: {
                    val_approve1_amount: {required: true, number: true, range: [250000, 2500000]},
                    val_approve2_amount: {required: true, number: true, range: [1500000, 5000000]},
                    val_number_quotas: {required: true, number: true, range: [6, 48]},
                    val_deferred_quotas: {required: true, number: true, range: [0, 3]},
                    val_interest_rate: {required: true, number: true, range: [1.5, 4.5]},
                },
                messages: {
                    val_approve1_amount: {required:'Ingrese Monto Oferta', number:'Ingrese solo N&#250;meros..', range:'Monto fuera de rango permitido..'},
                    val_approve2_amount: {required:'Ingrese Monto Oferta', number:'Ingrese solo N&#250;meros..', range:'Monto fuera de rango permitido..'},
                    val_number_quotas: {required:'Ingrese N&#250;mero de cuotas', number:'Ingrese solo N&#250;meros..', range:'Cuotas fuera de rango permitido..'},
                    val_deferred_quotas: {required:'Ingrese N&#250;mero de cuotas a diferir', number:'Ingrese solo N&#250;meros..', range:'Cuotas fuera de rango permitido..'},
                    val_interest_rate: {required:'Ingrese Tasa interes', number:'Ingrese solo N&#250;meros..', range:'Tasa interes fuera de rango permitido..'},
                }
            });
            // Initialize Masked Inputs
            // a - Represents an alpha character (A-Z,a-z)
            // 9 - Represents a numeric character (0-9)
            // * - Represents an alphanumeric character (A-Z,a-z,0-9)
            $('#masked_rut_client').mask('99.999.999-*');
            //$('#val_offer_amount').mask('9.999.999');
            //$('#val_interest_rate').mask('9.99%');
  //          $('#masked_amount_sav').mask('99.999.999');
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
