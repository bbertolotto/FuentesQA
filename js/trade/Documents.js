/**
 *  Document   : Documents.js
 *  Author     : TeknodataSystems
**/
/**
 *  Atrapa acciones por botones atención clientes
**/
$(function () {

    $('.btn-valid').on('click', function () {
        var theForm = document.getElementById("form-valid");
        theForm.action=$(this).data('action');
        theForm.target="_blank";
        if($(this).data('target')=="accept"){

           $("#form-deny").attr("target","_blank");

$("#form-deny").submit();
         // theForm.submit();
          /*theForm.action=$(this).data('deny')+"trade/create";
          theForm.target="";
          theForm.submit();*/
         
        }
    });

    $('.btn-print').on('click', function () {
      
        var theForm = document.getElementById("form-valid");theForm.action=$(this).data('action');theForm.target="_blank";
        if($(this).data('target')=="deny"){
          Alert.showDeny("Detalle Motivo del Rechazo");
        }else{
          theForm.submit();
        }

     
     
      

        


    });

     $('.btn-printnew').on('click', function () {
     
       

     
      
       $data2 = { iddoc : $(this).data('id'), type : $(this).data('type')  }
      $.ajax( {
            url: "/Controlpdf/buscardoc", type: "POST", dataType: "json", 
            data : $data2,
            success: function(response, status, xhr){
               console.log(response[0]);
               if(response[0] == 1){
                window.open("/Controlpdf/doc/"+response[1]+"/"+response[2]);
                //pdf(response[1],response[2]);
                return false;
               }else{
                pdf(response[1],response[2]);
               }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]"); 
            }

        });




       


    });


     function pdf(id,type){
       $data =  "id="+id+"&type="+type;
       if(type == "REC"){
        var idmotivo = $("#val_reason_deny").val();
          $data =  "id="+id+"&type="+type+"&motivo="+idmotivo;
       }else{
          $data =  "id="+id+"&type="+type;
       }
       console.log($data);
      
      $.ajax( {
            url: "/Controlpdf/generaPDF", type: "POST", dataType: "json", 
            data : $data,
            success: function(response, status, xhr){

               
                if(response.retorno==0){
                    window.open("/Controlpdf/readPDF", '_blank');

                    $data = "id="+id+"&type="+type+"&status=I";
                    //Actualiza Estado Simulación Impreso
                    $.ajax( {
                        url: "/Controlpdf/put_modifystatus", type: "POST", dataType: "json", data : $data,
                        success: function(response, status, xhr){

                          //  Client.processHide();
                            if(response.retorno==0){
                                toastr.success("Cotizaci&#243;n marcada como Impresa ..", "Preste Atenci&#243;n !"); 
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]"); 
                        }
                    });

                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]"); 
            }

        });
     }

    $('.btn-action').on('click', function () {
        var theForm = document.getElementById("form-valid");
        var target = $(this).data('target');
        if(target=="accept"){
          if(confirm("Súper Avance aceptado\nNotificación Jefe de Sucursal!")){
          theForm.action=$(this).data('action');
          theForm.submit();}
        }
        if(target=="deny"){
          if(confirm("Súper Avance rechazado\nVolver a negociar!")){
          theForm.action=$(this).data('action');
          theForm.submit();}
        }
        if(target=="return"){
          if(confirm("Volver a negociar")){
          theForm.action=$(this).data('action');
          theForm.submit();}
        }
    });

});

function sleep(milliseconds) {
 var start = new Date().getTime();
 for (var i = 0; i < 1e7; i++) {
  if ((new Date().getTime() - start) > milliseconds) {
   break;
  }
 }
}
