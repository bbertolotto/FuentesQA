/**
 *  Document   : Search.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones por botones atención clientes
**/

$(function () {

    $('.btn-reset').on('click', function () {

        $('#masked_rut_client').val("");
        $("#label_nameClient").val("");
        $("#dataTransfer").html("");
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
        evaluate: function() {
          var e = document.getElementById('masked_rut_client');
          if(e.value==""){
              Alert.showAlert("Ingrese N&#250;mero RUT ");return(false);}
          else{return(true);}
        },
        prepare: function() {
          e = document.getElementById("client-details");e.style.display = "none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display = "";
        },
        get_ClientByRut: function() {

            var formData = new FormData();
            Client.processShow();

            formData.append("nroRut",$('#masked_rut_client').val());
            var response = Teknodata.call_ajax("/advance/get_statustransfer", formData, false, true,  "");

            if(response!=false){


                if(response.retorno == 0){

                    $("#label_nameClient").val(response.completeNameClient);
                    $("#dataTransfer").html(response.htmlTransfer);

               }else{

                    $("#label_nameClient").val("");
                    $("#dataTransfer").html("");
                    Alert.showWarning("",response.descRetorno);

               }
            }

            Client.processHide();
            return(false);
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
                  if(Client.evaluate()){Client.search();}
                  else{return(false);}
                },
                rules: {
                    masked_credit_card: {required: false, number: false}
                },
                messages: {
                    masked_credit_card: {required:'Ingrese número Tarjeta Crédito', number:'Ingrese NUMERO TARJETA valido!'}
                }
            });
            $('#masked_credit_card').mask('9999-9999-9999-9999');
        }
    };
}();
$(function(){ Client.init(); });

