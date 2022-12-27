/**
 *  Document   : SeacrhAdvances.js
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


//End atrapa botones por atención a cliente
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
        evaluate: function() {
          var a = document.getElementById('masked_rut_client');
          var b = document.getElementById('masked_num_sav');
          var c = document.getElementById('sel_estado_sav');
          var d = document.getElementById('val_date_stamp');
          if(a.value==""&&b.value==""&&c.value==""&&d.value==""){
              Alert.showAlert("Ingrese N&#250;mero RUT o N&#250;mero SAV o Estado SAV o Fecha Creación SAV");return(false);}
          else{return(true);}
        },
        prepare: function() {
          e = document.getElementById("client-details");e.style.display = "none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display = "";
        },
        search: function() {
          Client.prepare();e = document.getElementById('masked_rut_client');o = document.getElementById('masked_num_sav');
          var ourl="https://desarrollo.solventa.maximoerp.com/CallWSSolventa/check_advances?nroRut="+Rutcl.clear2(e.value)+"&nroTcv="+o.value;
          $('#body-modal-search').load(ourl,function(response, status, xhr){
              if(status === "success") {
                  if(Jsonn.evalXML(response)){
                      response = Jsonn.parse(response);
                      if(response['retorno']!="000"){
                        Alert.initaccept_noclient();Alert.showSearch("",response['html']);
                      } else {
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
                    masked_credit_card: {required: false, number: false}
                },
                messages: {
                    masked_rut_client: {required:'Ingrese número RUT', evalrut:'Ingrese RUT valido!'},
                    masked_credit_card: {required:'Ingrese número Tarjeta Crédito', number:'Ingrese NUMERO TARJETA valido!'}
                }
            });
            // Initialize Masked Inputs
            // a - Represents an alpha character (A-Z,a-z)
            // 9 - Represents a numeric character (0-9)
            // * - Represents an alphanumeric character (A-Z,a-z,0-9)
            $('#masked_rut_client').mask('99.999.999-*');
            $('#masked_num_sav').mask('9999-9999');
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
