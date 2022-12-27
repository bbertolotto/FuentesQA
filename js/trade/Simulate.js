/**
 *  Document   : Simulate.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {
    $('.btn-search-client').on('click', function () {
        var target = $(this).data('target');
        var ourl="https://desarrollo.solventa.maximoerp.com/CallWSSolventa/get_client";
        if(target=="accept_client"){
          $.ajax(
            {url: ourl, type: 'post', dataType: 'json'
              }).done( function () {
                  Client.restore();
              }).fail(function (jqXHR, textStatus, errorThrown) {
                  Alert.showAlert(errorThrown);console.error(errorThrown);
              }
              );
        }//End if accept_client
    });
/*
    $('.btn-print').on('click', function () {
        var action = $(this).data('action');
        theForm = document.getElementById("form-action");
        e = Client.validate();
        if(e===true){
          theForm.action=action;
          theForm.submit();
        }else{e.focus();}
    });
    $('.btn-email').on('click', function () {
        var action = $(this).data('action');
        Alert.showAlert("Email Enviado con Exito!");
    });
*/
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
        evaluate: function() {
          var a = document.getElementById('masked_rut_client');
          if(a.value==""){
              Alert.showAlert("Debe Ingresar N&#250;mero RUT para Simular");return(false);}
          else{return(true);}
        },
        prepare: function() {
          e = document.getElementById("label_name_client");e.value="";e.disabled = false;
          e = document.getElementById("sel_secure_1");e.checked=false;e.disabled = true;
          e = document.getElementById("sel_secure_2");e.checked=false;e.disabled = true;
          e = document.getElementById("val_interest_rate");e.value="";
          e = document.getElementById("val_first_expiration_day");e.value="";
        },
        restore: function() {
          e = document.getElementById("sel_secure_1");e.checked=true;e.disabled = false;
          e = document.getElementById("sel_secure_2");e.checked=true;e.disabled = false;
          e = document.getElementById("val_interest_rate");e.value="2,95%";
          e = document.getElementById("val_first_expiration_day");e.value="10-01-2020";
        },
        search: function() {
          Client.prepare();e = document.getElementById('masked_rut_client');
          var ourl="https://desarrollo.solventa.maximoerp.com/CallWSSolventa/get_advances?nroRut="+Teknodata.clear2(e.value);
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
            $.validator.addMethod("evalmonto", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRange(value,250000,2500000);
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
            $('#form-action').validate({
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
                    btn = document.getElementById("btn-action");
                    theForm = document.getElementById("form-action");
                    if(btn.value=="print"){
                      theForm.action=btn.name;
                      theForm.submit();
                    };
                    if(btn.value=="email"){
                      Alert.showAlert("Simulaci&#243;n enviada por Email");
                    }
                },
                rules: {
                    val_offer_amount: {required: true, evalmonto: true},
                },
                messages: {
                    val_offer_amount: {required:'Ingrese Monto Oferta', evalmonto: 'Monto m&#237;nimo $250.000 m&#225;ximo $2.500.000'},
                }
            });
            // Initialize Masked Inputs
            // a - Represents an alpha character (A-Z,a-z)
            // 9 - Represents a numeric character (0-9)
            // * - Represents an alphanumeric character (A-Z,a-z,0-9)
            $('#masked_rut_client').mask('99.999.999-*');
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
