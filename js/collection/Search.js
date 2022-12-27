/**
/**
 *  Document   : renegotiation/Search.js
 *  Author     : TeknodataSystems
**/

$(function () {



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
          if($("#masked_rut_client").val().value==""&&$("#dateBegin").val().value==""){
              toastr.warning("Para realizar una busqueda debe ingresar al menos un atributo ..","Preste Atencíón..");
          }else{return(true);}
        },
        prepare: function() {
          document.getElementById("client-details").style.display = "none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display = "";
        },
        createRenegotiation: function() {

          Client.processShow();
          $.redirect("/collection/create");

        },
        clearInput: function () {
            $("#masked_rut_client").val(""); $("#dateBegin").val(""); $("#dateEnd").val(""); $("#status").val("");
            $("#tabCollection").html("");
        },
        search: function() {
            $data = $("#form-client").serialize(); Client.prepare();

            var response = Teknodata.call_ajax("/collection/get_collection", $data, false, false, "");
            if(response!=false){

                if(response.dataResult["retorno"] == 0){

                     Client.restore();
                     $("#tabCollection").html(response.dataResponse);

                }else{
                    var title = ""; var message = response.dataResult["descRetorno"]; var window_size = "md";
                    Alert.showWarning(title, message, window_size);
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

        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
