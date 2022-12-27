/**
/**
 *  Document   : Search.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {

    $('.table tbody').on('click', '.approval', function () {

        $tr = $(this).closest('tr');
        var $id =  $tr.find("td:eq(9)").find(".approval").attr("data-id");
        var $status =  $tr.find("td:eq(9)").find(".approval").attr("data-status");

        switch($status) {
            case "PE":
                $.redirect("/capturing/approval", { id: $id } )
            break;
    
            case "AP":
                $.redirect("/capturing/factory", { id: $id } )
            break;

            case "ER":
                $.redirect("/capturing/factory", { id: $id } )
            break;

            case "EO":
                $.redirect("/capturing/active", { id: $id } )
            break;

            default:
            Alert.showAlert("Estado Solicitud de Impresión no es Pendiente ..!");

        };

        return(false);
    });


    $('.btn-search').on('click', function () {

        if($("#officeSkill").prop("disabled") == true) {

            $("#officeSkill").prop("disabled", false);
            dataCard = $("#form-client").serialize();
            $("#officeSkill").prop("disabled", true);

        } else {

            dataCard = $("#form-client").serialize();

        }

        var response = Teknodata.call_ajax("/capturing/capturing_list", dataCard, false, false, ".btn-search");
        if(response!=false){

            var t = $('#response').DataTable();
            t .clear() .draw();

            if(response["dataResult"].retorno==0) {

                if(response["dataResponse"].length>0) {
                    for(i=0;i<response["dataResponse"].length;i++){
                        t.row.add( [
                            response["dataResponse"][i].autorizador,
                            response["dataResponse"][i].origen,
                            response["dataResponse"][i].rut,
                            response["dataResponse"][i].nombres,
                            response["dataResponse"][i].nombrevend,
                            response["dataResponse"][i].fecha,
                            response["dataResponse"][i].local,
                            response["dataResponse"][i].estado,
                            response["dataResponse"][i].situation,
                            response["dataResponse"][i].accion,
                            response["dataResponse"][i].result,
                        ] ).draw( false );
                    }
                }
                Client.restore();

            } else {

                Alert.showAlert(response["dataResult"].descRetorno);
            }


        }

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
          e = document.getElementById("client-details");e.style.display="none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display="";
        },
        clearInput: function() {
            $("#nroRut").val("");
            $("#numberRequest").val("");
            $("#typeRequestSkill").val("");
            $("#dateBegin").val("");
            $("#dateEnd").val("");
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
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.set_session(); if(Client.evaluate()) { Client.search(); } else { return(false); }
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
            $('#masked_credit_card').mask('9999-9999-9999-9999');
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });

$(document).ready(function() {
    var table = $('#response').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );
