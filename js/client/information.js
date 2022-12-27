/**
 *  Document   : js\client\information.js
 *  Author     : TeknodataSystems
 *
  ***/

$(function () {

    $('.btn-update-client').on('click', function () {
        $.ajax({
            url: "/client/put_ActualizaDatosClienteTC", type: "POST", dataType: "json",
            data : $("#form-client").serialize(),
            beforeSend: function() { Client.processShow(); $(".btn-update-client").prop("disabled", true); }, complete: function () { Client.processHide(); $(".btn-update-client").prop("disabled", false);  },
            success: function(response, status, xhr){
                if(response.retorno == 10){
                    toastr.error('Error, ['+response.descRetorno+']','Transacción Datos Personales Rechazada');
                    $(".btn-update-client").prop('disabled', false);
                }else{
                    if(response.retorno == 0){
                       toastr.success(response.descRetorno,'Transacción Aceptada');
                       document.getElementById("divNameClient").innerHTML = "<h2><strong>Cliente </strong>"+response.nameClient+" "+response.lastNameClient+"</td></h2>";

                    }else{
                        Alert.showToastrWarning(response);
                        $(".btn-update-client").prop('disabled', false);
                    }
                    if(response.retornoB == 0){
                        toastr.success(response.descRetornoB,'Transacción Aceptada');
                        Client.init();
                    }else{

                        Alert.showToastrWarning(response);
                        $(".btn-update-client").prop('disabled', false);

                    }
                }
            },
        });
    return false;
    });

    $('.btn-update-addi').on('click', function () {

        Client.processShow();
        $.ajax(
            {
                url: "/client/put_ActualizaDatosAdicionalesTC",
                type: "POST", dataType: "json",
                data : $("#form-additional").serialize(),
                beforeSend: function() { Client.processShow(); $(".btn-update-addi").prop("disabled", true); }, complete: function () { Client.processHide(); $(".btn-update-addi").prop("disabled", false);  },
                success: function(response, status, xhr){

                    Client.processHide();

                    if(response.retorno == 0){
                        toastr.success(response.descRetorno,'Transacción Aceptada');
                        e = document.getElementById('masked_rut_additional');
                        for (var i=1;i < document.getElementById('dataAdditional').rows.length; i++){
                            for (var j=0; j<3; j++){
                                if(document.getElementById('dataAdditional').rows[i].cells[j].innerHTML==e.value){
                                    document.getElementById('dataAdditional').rows[i].cells[1].innerHTML=document.getElementById('nameAddi').value;
                                    document.getElementById('dataAdditional').rows[i].cells[2].innerHTML=document.getElementById('lastFatherAddi').value;
                                    document.getElementById('dataAdditional').rows[i].cells[3].innerHTML=document.getElementById('lastMotherAddi').value;
                                    document.getElementById('dataAdditional').rows[i].cells[4].innerHTML=document.getElementById('birthDateAddi').value;
                                    s = document.getElementById("genderSkillAddi");
                                    document.getElementById('dataAdditional').rows[i].cells[5].innerHTML=s.options[s.selectedIndex].text;
                                    s = document.getElementById("relationSkillAddi");
                                    document.getElementById('dataAdditional').rows[i].cells[6].innerHTML=s.options[s.selectedIndex].text;
                                }
                            }
                        }
                        document.getElementById('nameAddi').value="";
                        document.getElementById('lastFatherAddi').value="";
                        document.getElementById('lastMotherAddi').value="";
                        document.getElementById('birthDateAddi').value="";

                   }else{
                        Client.processHide();
                        $(".btn-update-addi").prop('disabled', false);
                        Alert.showWarning(response.descRetorno,'Transacción Rechazada');
                   }
                },
            });
    return false;
    });


});

$(document).ready(function(){

        $(".btn-sel-addi").click(function(){

            var addi = new Array(); i = 0;
            $(this).parents("tr").find("td").each(function(){
                addi[i] =$(this).html();
                i++;
            });
            document.getElementById('masked_rut_additional').value = addi[0];
            document.getElementById("nameAddi").value = addi[1];
            document.getElementById("lastFatherAddi").value = addi[2];
            document.getElementById("lastMotherAddi").value = addi[3];

            document.getElementById("birthDateAddi").value = addi[4];
            e = document.getElementById('relationSkillAddi');
            e.value = $(this).attr('data-relation');
            e = document.getElementById('genderSkillAddi');
            e.value = $(this).attr('data-gender');
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
        init: function() {
          var e = document.getElementById('nameClient'); var o = document.getElementById('nameClientH'); o.value = e.value;
          e = document.getElementById('lastFatherClient'); o = document.getElementById('lastFatherClientH'); o.value = e.value;
          e = document.getElementById('lastMotherClient'); o = document.getElementById('lastMotherClientH'); o.value = e.value;
          e = document.getElementById('birthDateClient'); o = document.getElementById('birthDateClientH'); o.value = e.value;
        },
        reset: function() {
          var e = document.getElementById('nameClientH'); var o = document.getElementById('nameClient'); o.value = e.value;
          e = document.getElementById('lastFatherClienHt'); o = document.getElementById('lastFatherClient'); o.value = e.value;
          e = document.getElementById('lastMotherClientH'); o = document.getElementById('lastMotherClient'); o.value = e.value;
          e = document.getElementById('birthDateClientH'); o = document.getElementById('birthDateClient'); o.value = e.value;
        }
    };
}();
$(function(){ Client.init(); });

function masked_renta(renta) {
    renta.value=renta.value.replace(/[.-]/g, '').replace( /^(\d{1,2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4')}
