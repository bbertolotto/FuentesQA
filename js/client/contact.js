/**
 *  Document   : js\client\information.js
 *  Author     : TeknodataSystems
**/

$(function () {

    $(".btn-sel-phones").click(function(){

        var phones = new Array(); i = 0;
        $(this).parents("tr").find("td").each(function(){
            phones[i] =$(this).html();
            i++;
        });

        e = document.getElementById('numberPhone');
        e.value = phones[2];
        e = document.getElementById('hnumberPhone');
        e.value = phones[2];

        document.getElementById("typePhoneSkill").disabled = false;
        document.getElementById("usePhoneSkill").disabled = false;
        document.getElementById("typePhoneSkill").value = phones[0];
        document.getElementById("usePhoneSkill").value = phones[1];
        document.getElementById("usePhone").value = $(this).attr('data-use');
        document.getElementById("typePhone").value = $(this).attr('data-type');
        document.getElementById("typePhoneSkill").disabled = true;
        document.getElementById("usePhoneSkill").disabled = true;

    });

    $('#typeRegionSkill').on('change', function (){

        $("#typeCitySkill").empty();
        $("#typeCommuneSkill").empty();
        var jCity ="";

            $.ajax({
                url: "/client/get_cities",
                type: 'post',
                dataType: 'json',
                data: {id : $(this).val() },
                success: function(json) {
                        for(i=0; i<json.length;i++){
                             $("#typeCitySkill").append("<option value='"+json[i]["id"]+"'>"+json[i]["nombre"]+"</option>");
                             if(jCity==""){ jCity = json[i]["id"]; }
                        }

                        $.ajax({
                            url: "/client/get_communes",
                            type: 'post',
                            dataType: 'json',
                            data: {idciudad : jCity, idregion : $('#typeRegionSkill').val() },
                            success: function(json) {
                                    for(i=0; i<json.length;i++){
                                         $("#typeCommuneSkill").append("<option value='"+json[i]["id"]+"'>"+json[i]["nombre"]+"</option>");
                                    }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]");
                            }
                         });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]");
                }

             });

    });

    $('#typeCitySkill').on('change', function (){
        $("#typeCommuneSkill").empty();

            $.ajax({
                url: "/client/get_communes",
                type: 'post',
                dataType: 'json',
                data: {idciudad : $(this).val(), idregion : $('#typeRegionSkill').val() },
                success: function(json) {
                        for(i=0; i<json.length;i++){
                             $("#typeCommuneSkill").append("<option value='"+json[i]["id"]+"'>"+json[i]["nombre"]+"</option>");
                        }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]");
                }

             });

    });


    $('.btn-update-phones').on('click', function () {
        if(document.getElementById('numberPhone').value==""){
            toastr.error('Error, Debes Ingresar número de teléfono','Transacción Rechazada');
            return(false);
        }

        if(!document.getElementById('typePhoneSkill').disabled){

            for (var i=1;i < document.getElementById('dataPhone').rows.length; i++){
                for (var j=0; j<3; j++){
                    if(document.getElementById('dataPhone').rows[i].cells[0].innerHTML==document.getElementById('typePhoneSkill').value&&
                        document.getElementById('dataPhone').rows[i].cells[1].innerHTML==document.getElementById('usePhoneSkill').value){
                        toastr.error('Error, Intentas Agregar Registro Tipo Teléfono ya Existe, debes Modificar !','Transacción Rechazada');
                        return(false);
                    }
                }
            }
//            document.getElementById('usePhone').value="PER";
        }

        $data = "typePhoneSkill="+document.getElementById('typePhoneSkill').value;
        $data+= "&usePhoneSkill="+document.getElementById('usePhoneSkill').value;
        $data+= "&usePhone="+document.getElementById('usePhone').value;
        $data+= "&typePhone="+document.getElementById('typePhone').value;
        $data+= "&numberPhone="+document.getElementById('numberPhone').value;

        Contact.processShow();

        $.ajax(
            {
                url: "/client/put_ActualizaDatosContactoPhone", type: "POST", dataType: "json", data : $data,
                success: function(response, status, xhr){

                    if(response.retorno == 0){

                        toastr.success('Mensaje: '+response.descRetorno, 'Transacción Aceptada');
                        Contact.modifyPhone(response);
                        Contact.processHide();

                    }else{

                        Alert.showWarning("",response.descRetorno);

                   }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Contact.processHide(); Alert.showToastrErrorXHR(jqXHR, textStatus);
                }

            });
        Contact.processHide();
        return(false);
    });

    $('.btn-update-emails').on('click', function () {


        if(!document.getElementById('typeEmailSkill').disabled){

            for (var i=1;i < document.getElementById('dataEmail').rows.length; i++){
                for (var j=0; j<3; j++){
                    if(document.getElementById('dataEmail').rows[i].cells[0].innerHTML==$('#typeEmailSkill').val() ){
                        toastr.error('Error, Intentas Agregar Registro Tipo Email que ya Existe, debes Modificar !','Transacción Rechazada');
                        return(false);
                    }
                }
            }
        }

        Contact.processShow();
        var controlChange = false;

        if( $('#mailbox').val()!=$('#hmailbox').val() ||
            $('#hsendMailboxSkill').val()!=$('#sendMailboxSkill').val() ) {

            controlChange = true;

            $data = "typeEmailSkill="+document.getElementById('typeEmailSkill').value;
            $data+= "&useEmail="+document.getElementById('useEmail').value;
            $data+= "&typeEmail="+document.getElementById('typeEmail').value;
            $data+= "&mailbox="+document.getElementById('mailbox').value.toLowerCase();;
            $data+= "&sendMailboxSkill="+document.getElementById('sendMailboxSkill').value;

            $.ajax(
                {
                url: "/client/put_ActualizaDatosContactoEmail", type: "POST", dataType: "json",
                data : $data,
                success: function(response, status, xhr){
                    if(response.retorno == 0){

                        toastr.success('Mensaje: '+response.descRetorno, 'Transacción Aceptada');
                        Contact.modifyEmail(response);

                   }else{

                        Alert.showToastrWarning(response);

                   }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]");
                }
            });
        }

        if(document.getElementById('sendMailboxSkill').value!=document.getElementById('hsendMailboxSkill').value){

            controlChange = true;

            $data = "typeEmailSkill="+document.getElementById('typeEmailSkill').value;
            $data+= "&mailbox="+document.getElementById('mailbox').value;
            $data+= "&sendMailboxSkill="+document.getElementById('sendMailboxSkill').value;

            $.ajax(
                {
                    url: "/client/put_ActualizaDatosCuenta", type: "POST", dataType: "json",
                    data : $data,
                    success: function(response, status, xhr){
                        if(response.retorno == 0){

                            toastr.success('Mensaje: '+response.descRetorno, 'Transacción Aceptada');

                            Contact.modifyEmailEECC();
                            document.getElementById('mailbox').value="";
                            document.getElementById('sendMailboxSkill').value="";

                        }else{

                                Alert.showToastrWarning(response);

                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]");
                    }
                });
        }
        Contact.processHide();
        if(!controlChange){
            toastr.warning('Sin cambios que aplicar ..', 'Presta Mucha Atención ..!');
        }

        return(false);

    });


    $('.btn-reset-address').on('click', function () {
        $("#typeCitySkill").empty();
        $("#typeCommuneSkill").empty();
    });

    $('.btn-update-address').on('click', function () {

        p = document.getElementById("processing"); p.style.display="";

        $data = "typeAddressSkill="+$("#typeAddressSkill").val();
        $data+= "&typeRegionSkill="+document.getElementById('typeRegionSkill').value;
        $data+= "&typeCitySkill="+document.getElementById('typeCitySkill').value;
        $data+= "&typeCommuneSkill="+document.getElementById('typeCommuneSkill').value;
        $data+= "&address="+document.getElementById('address').value;
        $data+= "&numberAddress="+document.getElementById('numberAddress').value;
        $data+= "&numberDepart="+document.getElementById('numberDepart').value;
        $data+= "&numberBlock="+document.getElementById('numberBlock').value;
        $data+= "&complement="+document.getElementById('complement').value;

        $.ajax({
            url: "/client/put_ActualizaDatosDireccionTC", type: "POST", dataType: "json", data : $data,
            beforeSend: function () { $(".btn-update-address").prop('disabled', true); }, complete: function ()  {  $(".btn-update-address").prop('disabled', false); },
            success: function(response, status, xhr){
                if(response.retorno == 0){

                    toastr.success('Mensaje: '+response.descRetorno, 'Transacción Aceptada');

                    Contact.modifyAddress();

                }else{

                    Alert.showToastrWarning(response);

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error("Error Number: [" + jqXHR.status +"] Error Message: [" + textStatus + "] Detail: [" + errorThrown + "]");
            },
        });
        p.style.display="none";
        return(false);
    });

});

$(document).ready(function(){
        $(".btn-sel-emails").click(function(){

            var emails = new Array(); i = 0;
            $(this).parents("tr").find("td").each(function(){
                emails[i] =$(this).html();
                i++;
            });
            e = document.getElementById('mailbox');
            e.value = emails[1];
            e = document.getElementById('hmailbox');
            e.value = emails[1];
            e = document.getElementById('hsendMailboxSkill');
            e.value = emails[2];

            document.getElementById("typeEmailSkill").value = emails[0];
            document.getElementById("typeEmailSkill").disabled = true;
            document.getElementById("sendMailboxSkill").value = $(this).attr('data-eecc');
            document.getElementById("typeEmail").value = $(this).attr('data-type');
            document.getElementById("useEmail").value = $(this).attr('data-use');
        });

        $(".btn-sel-address").click(function(){

            var address = new Array(); i = 0;
            $(this).parents("tr").find("td").each(function(){
                address[i] =$(this).html();
                i++;
            });
            e = document.getElementById('typeAddressSkill');
            e.value = $(this).attr('data-type-address');
            e = document.getElementById('typeRegionSkill');
            e.value = $(this).attr('data-type-region');

            var region = $(this).attr('data-type-region');
            var city = $(this).attr('data-type-ciudad');
            var commune = $(this).attr('data-type-comuna');

            $("#typeCitySkill").empty();
            $.ajax({
                url: "/client/get_cities", type: 'post', dataType: 'json', data: {id : $(this).attr('data-type-region') },
                success: function(json) {
                    for(i=0; i<json.length;i++){
                        if(json[i]["id"]==city){
                            $("#typeCitySkill").append("<option value='"+json[i]["id"]+"' selected>"+json[i]["nombre"]+"</option>");
                        }else{
                            $("#typeCitySkill").append("<option value='"+json[i]["id"]+"'>"+json[i]["nombre"]+"</option>");
                        }

                    }
                }
             });

            $("#typeCommuneSkill").empty();
            $.ajax({
                    url: "/client/get_communes", type: 'post', dataType: 'json', data: {idciudad : $(this).attr('data-type-ciudad'), idregion : $(this).attr('data-type-region') },
                    success: function(json) {
                            for(i=0; i<json.length;i++){
                                if(json[i]["id"]==commune){
                                    $("#typeCommuneSkill").append("<option value='"+json[i]["id"]+"' selected>"+json[i]["nombre"]+"</option>");
                                }else{
                                    $("#typeCommuneSkill").append("<option value='"+json[i]["id"]+"'>"+json[i]["nombre"]+"</option>");
                                }
                            }
                    }
                 });

            document.getElementById("address").value = address[1];
            document.getElementById("numberAddress").value = address[2];
            document.getElementById("numberDepart").value = address[3];
            document.getElementById("numberBlock").value = address[4];
            document.getElementById("complement").value = address[5];
        });

});

var Contact = function() {
    return {

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },

        initEmails: function () {
            document.getElementById("typeEmailSkill").disabled = false;
            document.getElementById("typeEmail").disabled = "";
            document.getElementById("useEmail").disabled = "";
            document.getElementById("mailbox").value = "";
        },
        modifyAddress: function(){

            var newAddress = true;
            e = document.getElementById('typeAddressSkill');

            var tab = document.getElementById("dataAddress");
            var tabTR = tab.getElementsByTagName("tr");
            for (var i=0; i<tabTR.length; i++){

                var tabTD = tabTR[i].getElementsByTagName("td");

                for (var j=0; j<tabTD.length; j++){

                    if(tabTD[j].innerText==e.options[e.selectedIndex].innerText){

                        tabTD[1].innerText = document.getElementById("address").value;
                        tabTD[2].innerText = document.getElementById("numberAddress").value;
                        tabTD[3].innerText = document.getElementById("numberDepart").value;
                        tabTD[4].innerText = document.getElementById("numberBlock").value;
                        tabTD[5].innerText = document.getElementById("complement").value;

                        o = document.getElementById("typeCommuneSkill");
                        tabTD[6].innerText = o.options[o.selectedIndex].innerText;
                        o = document.getElementById("typeCitySkill");
                        tabTD[7].innerText = o.options[o.selectedIndex].innerText;
                        o = document.getElementById("typeRegionSkill");
                        tabTD[8].innerText = o.options[o.selectedIndex].innerText;
                        newAddress = false;

                    }
                }
            }
            if(newAddress){
                var htmlTags = '<tr>';
                htmlTags += '<td scope="col">'+e.options[e.selectedIndex].innerText+'</td>';
                htmlTags += '<td scope="col">'+document.getElementById('address').value+'</td>';
                htmlTags += '<td scope="col">'+document.getElementById('numberAddress').value+'</td>';
                htmlTags += '<td scope="col">'+document.getElementById('numberDepart').value+'</td>';
                htmlTags += '<td scope="col">'+document.getElementById('numberBlock').value+'</td>';
                htmlTags += '<td scope="col">'+document.getElementById('complement').value+'</td>';

                o = document.getElementById("typeCommuneSkill");
                htmlTags += '<td scope="col">'+o.options[o.selectedIndex].innerText+'</td>';
                o = document.getElementById("typeCitySkill");
                htmlTags += '<td scope="col">'+o.options[o.selectedIndex].innerText+'</td>';
                o = document.getElementById("typeRegionSkill");
                htmlTags += '<td scope="col">'+o.options[o.selectedIndex].innerText+'</td>';
                htmlTags += '<td scope="col"><button type="button" class="btn-sel-address btn-xs btn-warning"><i class="gi gi-upload" title="Modificar"></i></button></td></tr>';
                $('#dataAddress tbody').append(htmlTags);
            }
            location.reload();
        },
        modifyEmail: function(response){

            var newEmail = true;
            var p = document.getElementById('typeEmailSkill');
            var s = document.getElementById('sendMailboxSkill');

            for (var i=1;i < document.getElementById('dataEmail').rows.length; i++){
                for (var j=0; j<=4; j++){
                    if(document.getElementById('dataEmail').rows[i].cells[0].innerHTML==$("#typeEmailSkill").val() &&
                       document.getElementById('dataEmail').rows[i].cells[1].innerHTML==$("#hmailbox").val()  ){
                        document.getElementById('dataEmail').rows[i].cells[1].innerHTML=document.getElementById('mailbox').value;
                        newEmail = false;
                    }
                }
            }

            if(newEmail){
                var htmlTags = '<tr>';
                htmlTags += '<td class="text-center">'+$("#typeEmailSkill").val()+'</td>';
                htmlTags += '<td class="text-left">'+document.getElementById('mailbox').value+'</td>';
                htmlTags += '<td class="text-center">'+s.options[s.selectedIndex].innerText+'</td>';
                htmlTags += '<td class="text-center">VIGENTE</td>';
                htmlTags += '<td class="text-center"><button type="button" class="btn-sel-phones btn-xs btn-warning" ><i class="gi gi-upload" title="Modificar"></i></button></td></tr>';
                $('#dataEmail tbody').append(htmlTags);
            }

        },
        modifyEmailEECC: function() {

            for (var i=1;i < document.getElementById('dataEmail').rows.length; i++){
                for (var j=0; j<=4; j++){
                    document.getElementById('dataEmail').rows[i].cells[2].innerHTML=$('#sendMailboxSkill').val();
                }
            }

        },

        addPhone: function() {
            document.getElementById('typePhoneSkill').disabled = false;
            document.getElementById('usePhoneSkill').disabled = false;
            document.getElementById('usePhone').value = "";
            document.getElementById('typePhone').value = "";
        },

        modifyPhone: function(response){

            var newPhone = true;

            for (var i=1;i < document.getElementById('dataPhone').rows.length; i++){
                for (var j=0; j<3; j++){
                    if(document.getElementById('dataPhone').rows[i].cells[0].innerHTML==document.getElementById('typePhoneSkill').value&&
                        document.getElementById('dataPhone').rows[i].cells[1].innerHTML==document.getElementById('usePhoneSkill').value&&
                        document.getElementById('dataPhone').rows[i].cells[2].innerHTML==document.getElementById('hnumberPhone').value){

                        document.getElementById('dataPhone').rows[i].cells[2].innerHTML=document.getElementById('numberPhone').value;
                        newPhone = false;
                    }
                }
            }
            if(newPhone){
                var htmlTags = '<tr>';
                htmlTags += '<td class="text-left">'+document.getElementById('typePhoneSkill').value+'</td>';
                htmlTags += '<td class="text-left">'+document.getElementById('usePhoneSkill').value+'</td>';
                htmlTags += '<td class="text-left">'+document.getElementById('numberPhone').value+'</td>';
                htmlTags += '<td class="text-center">VIGENTE</td>';
                htmlTags += '<td class="text-center"><button type="button" class="btn-sel-phones btn-xs btn-warning" data-type="'+response.typePhone+'" data-use="'+response.usePhone+'"><i class="gi gi-upload" title="Modificar"></i></button></td></tr>';
                $('#dataPhone tbody').append(htmlTags);
            }
        },
        validTypeAddress: function() {

            var e = document.getElementById('typeAddressSkill');
            var tab = document.getElementById("dataAddress");
            var tabTD = tab.getElementsByTagName("td");
            for (var i=0; i<tabTD.length; i++){
                if(tabTD[i].innerText==e.options[e.selectedIndex].innerText){
                    toastr.warning("Intentas crear dirección con tipo Dirección ya registrado, Debes modificar !!", "Presta Mucha Atención ..!");
                    return(false);
                }
            }
            return(true);
        }
    };
}();
