/**
 *  Document   : Search.js
 *  Author     : TeknodataSystems
**/

/**
 *  Atrapa acciones por botones atención clientes
**/

$(function () {

    $('.btn-deny').on('click', function () {

        if($("#label_nameClient").val()==""){ toastr.warning("<h4><strong>Debe ingresar RUT y Buscar Cliente</strong></h4>","<strong>Preste Atenci&#243;n</strong>"); return(false);}

        Alert.showDeny("SELECCIONE MOTIVO CARTA RECHAZO");
        return(true);
    });

    $('.btn-print').on('click', function () {

        $data = "id=0&type=CRC&nroRut="+$("#masked_rut_client").val()+"&nameClient="+$("#label_nameClient").val()+"&reasonDeny="+$("#reasonDeny").val();

        $.ajax( { url: "/advance/generaPDF", type: "POST", dataType: "json", data : $data, beforeSend: function() { }, success: function(response, status, xhr) {

                Client.processHide();
                if(response.retorno==0){

                    window.open("/advance/readPDF", '_blank');

                }else {

                    toastr.warning(response.descRetorno, "Preste Atenci#243;n !");

                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Alert.showToastrErrorXHR(jqXHR, textStatus);
            }

        });

        return(true);

    });

    $('.btn-search').on('click', function () {

        if($("#masked_rut_client").val()==""){ toastr.warning("<h4><strong>Debe ingresar RUT para buscar informaci&#243;n</strong></h4>","<strong>Preste Atenci&#243;n</strong>"); return(false);}

        $(".btn-search").prop('disabled', true);
        Client.processShow();

        $.ajax( {
            url: "/advance/get_documentsByRut", type: "POST", dataType: "json",
            data : { id : $("#masked_rut_client").val() },
            beforeSend: function() {
            },
            success: function(response, status, xhr){

                if(response["dataCliente"].retorno==0) {

                    $("#label_nameClient").val(response["dataCliente"].nameClient);
                    $("#nombrecliente").html(response["dataCliente"].nameClient);

                    console.log(response["dataDoctos"]);

                    if(response["dataDoctos"].length>0) {
                        var t = $('#example').DataTable();
                        t .clear() .draw();
                        for(i=0;i<response["dataDoctos"].length;i++){
                            var datos = "";
                            console.log(response["dataDoctos"][i].correl);
//                            if(response["dataDoctos"][i].name == "CONTRATO SÚPER AVANCE"){
                            datos = response["dataDoctos"][i].id_image;
                            if(datos != ""){
                                datos = "<a href='/advance/get_IMAGE/"+datos+"' target='_blank'>Abrir&nbsp;<i class='fa fa-file-image-o'></a>";
                            }else{
                                datos = "&nbsp;";
                            }
//                          }
                            t.row.add( [
                                response["dataDoctos"][i].name,
                                response["dataDoctos"][i].stamp,
                                response["dataDoctos"][i].username,
                                response["dataDoctos"][i].nameOffice,
                                response["dataDoctos"][i].stamp_last_print,
                                response["dataDoctos"][i].id_user_last_print,
                                response["dataDoctos"][i].status,
                                "<a href='/advance/get_PDF/"+response["dataDoctos"][i].idDocument+"/"+response["dataDoctos"][i].typeDocument+"' target='_blank'>Abrir&nbsp;<i class='fi fi-pdf'></i></a>",
                                datos,
                                response["dataDoctos"][i].idDocument,
                            ] ).draw( false );
                        }
                    }
                    Client.restore();
                    Client.processHide();

                } else {

                    Alert.showToastrWarning(response["dataCliente"]);
                    Client.processHide();
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Alert.showToastrErrorXHR(jqXHR, textStatus);
            }

        });
        $(".btn-search").prop('disabled', false);

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
        search: function() {

            Client.processShow();
            $data = "nroRut="+$('#masked_rut_client').val();
            $.ajax( {
                url: "/advance/get_lightClient", type: "POST", dataType: "json",
                data : $data,
                success: function(response, status, xhr){
                    if(response.retorno==0) {
                        $("#label_nameClient").val(response.nameClient);
                    }else{
                        $("#label_nameClient").val("");
                        toastr.warning("<h4><strong>RUT ingresado no registra informaci&#243;n!</strong></h4>","<strong>Preste Atenci&#243;n</strong>");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#label_nameClient").val("");
                    toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]");
                }

            });

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
$(function(){ Client.prepare(); });

$(document).ready(function() {
    var table = $('#example').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );
