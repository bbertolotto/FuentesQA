/**
 *  Document   : js\client\lasttransaction.js
 *  Author     : TeknodataSystems
**/


 $('.exporpdfdataAUT').on('click', function () {
    $.ajax({
        type: "post",
        url: "/client/clientpdf",
        data: { html: $("#dataAUT").html() },
        dataType: "json",
        beforeSend: function() {

        },
        success: function (data) {
            console.log(data);
            window.open("/client/abrirpdf", '_blank');
        },
        complete: function() {
        }
        });
})

$('.exporpdfdataVentas').on('click', function () {
    $.ajax({
        type: "post",
        url: "/client/clientpdf",
        data: { html: $("#dataVentas").html() },
        dataType: "json",
        beforeSend: function() {

        },
        success: function (data) {
            console.log(data);
            window.open("/client/abrirpdf", '_blank');
        },
        complete: function() {
        }
        });
})

$('.exporpdfdataPagos').on('click', function () {
    $.ajax({
        type: "post",
        url: "/client/clientpdf",
        data: { html: $("#dataPagos").html() },
        dataType: "json",
        beforeSend: function() {

        },
        success: function (data) {
            console.log(data);
            window.open("/client/abrirpdf", '_blank');
        },
        complete: function() {
        }
        });
})

$('.exporpdfdataDevolucion').on('click', function () {
    $.ajax({
        type: "post",
        url: "/client/clientpdf",
        data: { html: $("#dataDevolucion").html() },
        dataType: "json",
        beforeSend: function() {

        },
        success: function (data) {
            console.log(data);
            window.open("/client/abrirpdf", '_blank');
        },
        complete: function() {
        }
        });
})

$('.exporpdfdataCuotas').on('click', function () {
    $.ajax({
        type: "post",
        url: "/client/clientpdf",
        data: { html: $("#dataCuotas").html() },
        dataType: "json",
        beforeSend: function() {

        },
        success: function (data) {
            console.log(data);
            window.open("/client/abrirpdf", '_blank');
        },
        complete: function() {
        }
        });
})



$('.exporpdf').on('click', function () {
    $.ajax({
        type: "post",
        url: "/client/clientpdf",
        data: { html: $("#dataCargos").html() },
        dataType: "json",
        beforeSend: function() {

        },
        success: function (data) {
            console.log(data);
            window.open("/client/abrirpdf", '_blank');
        },
        complete: function() {
        }
        });
})


$(function () {


       $('.exporxlsdataAUT').on('click', function () {
            var elementos = document.getElementById('dataAUT');
            console.log(elementos);
            xlsproceso(elementos);

        });

        $('.exporxlsdataCargos').on('click', function () {
            var elementos = document.getElementById('dataCargos');
            console.log(elementos);
            xlsproceso(elementos);
        });

        $('.exporxlsdataPagos').on('click', function () {
            var elementos = document.getElementById('dataPagos');
            console.log(elementos);
            xlsproceso(elementos);
        });

        $('.exporxlsdataDevolucion').on('click', function () {
            var elementos = document.getElementById('dataDevolucion');
            console.log(elementos);
            xlsproceso(elementos);
        });

         $('.exporxlsdataCuotas').on('click', function () {
            var elementos = document.getElementById('dataCuotas');
            console.log(elementos);
            xlsproceso(elementos);
        });

        $('.exporxlsdataVentas').on('click', function () {
            var elementos = document.getElementById('dataVentas');
            console.log(elementos);
            xlsproceso(elementos);
        });



       function xlsproceso(elementos){
         var html = elementos.outerHTML;
                  while (html.indexOf('??') != -1) html = html.replace('??', '&aacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&Aacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&eacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&Eacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&iacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&Iacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&oacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&Oacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&uacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&Uacute;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&ordm;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&ntilde;');
                  while (html.indexOf('??') != -1) html = html.replace('??', '&Ntilde;');
                window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
       }

    $('.btn-get-action').on('click', function () {
        Client.init();

//        alert("get_TransaccionesTC");

        p = document.getElementById("processing"); p.style.display="";
        $.ajax(
            {
                url: "/client/get_TransaccionesTC",
                type: "POST",
                dataType: "json",
                data : $("#form-client").serialize(),
                success: function(response, status, xhr){
/*
                    if(response.htmlCuotas.length>0){
                        e = document.getElementById('dataCuotas');
                        e.innerHTML = response.htmlCuotas;
                        e = document.getElementById("viewCuotas");e.style.display = "";
                    }
*/
                    if(response.htmlPagos.length>0){
                        e = document.getElementById('dataPagos');
                        e.innerHTML = response.htmlPagos;
                        e = document.getElementById("viewPagos");e.style.display = "";
                    }
                    if(response.htmlCargos.length>0){
                        e = document.getElementById('dataCargos');
                        e.innerHTML = response.htmlCargos;
                        e = document.getElementById("viewCargos");e.style.display = "";
                    }
                    if(response.htmlVentas.length>0){
                        e = document.getElementById('dataVentas');
                        e.innerHTML = response.htmlVentas;
                        e = document.getElementById("viewVentas");e.style.display = "";
                    }

                    if(response.htmlDevolucion.length>0){
                        e = document.getElementById('dataDevolucion');
                        e.innerHTML = response.htmlDevolucion;
                        e = document.getElementById("viewDevolucion");e.style.display = "";
                    }

                    if(response.retorno == 0){
                        toastr.success('Datos Recuperados Correctamente!', 'Transacci??n Aceptada');
                    }else{
                        toastr.error('Error, ['+response.descRetorno+']','Transacci??n Rechazada');
                   }
                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status === 0) {
                         msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    toastr.error('Error, ['+msg+']','Transacci??n Rechazada');
                },
            });
    p.style.display="none";
    return false;
    });
});

var Client = function() {
    return {
        init: function() {
          e = document.getElementById("viewVentas");e.style.display = "none";
          e = document.getElementById("viewCargos");e.style.display = "none";
          e = document.getElementById("viewPagos");e.style.display = "none";
          e = document.getElementById("viewDevolucion");e.style.display = "none";
          //e = document.getElementById("viewCuotas");e.style.display = "none";
        },
    };
}();
$(function(){ Client.init(); });
