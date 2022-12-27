/**
 *  Document   : js\advance\Beneficiary.js
 *  Author     : TeknodataSystems
**/

$(function () {


    $('#saveBeneficiary').on('click', function () {

        var sum = Contact.sumPercentage();
        if(sum>100) {
            toastr.warning("Suma de Porcentajes no puede superar 100");
            return(false);
        }
        $("#masked_rut_beneficiary").val("");$("#nameBeneficiary").val("");$("#lastMotherBeneficiary").val("");$("#lastFatherBeneficiary").val("");$("#percentBeneficiary").val("");
        return(true);
    });

    $('#addBeneficiary').on('click', function () {

        if($("#masked_rut_beneficiary").val()=="") {
            toastr.warning("Debe ingresar Rut Beneficiario");
            return(false);
        }

        if(Contact.existsBeneficiary()) {
            toastr.warning("Rut ya fue ingresado a lista Beneficiarios");
            return(false);
        }
        var sum = Contact.sumPercentage();
        var count = Contact.countBeneficiaries();

        sum = Number(sum) + Number($("#percentBeneficiary").val());
        if(sum>100) {
            toastr.warning("Suma de Porcentajes no puede superar 100");
            return(false);
        }

        if (count==4) {
            toastr.warning("No puede ingresar más de 4 beneficiarios");
            return(false);
        }

        $data = $("#form-beneficiary").serialize();
        var response = Teknodata.call_ajax($("#addBeneficiary").data("url"), $data, false, false, "#addBeneficiary");

        if(response!=false){

            if(response.retorno == 0){

                Contact.addBeneficiary();

            }else{
               Alert.showToastrWarning(response);
           }
        }

        return(false);
    });

});

var Contact = function() {
    return {

        addBeneficiary: function(){

            var htmlTags = '<tr>';
            htmlTags += '<td class="text-center">'+$("#masked_rut_beneficiary").val()+'</td>';
            htmlTags += '<td class="text-center">'+$("#nameBeneficiary").val()+'</td>';
            htmlTags += '<td class="text-center">'+$("#lastFatherBeneficiary").val()+'</td>';
            htmlTags += '<td class="text-center">'+$("#lastMotherBeneficiary").val()+'</td>';
            htmlTags += '<td class="text-center">'+$("#relationBeneficiary").val()+'</td>';
            htmlTags += '<td class="text-center">'+$("#percentBeneficiary").val()+'</td>';
            htmlTags += '<td class="text-center">'+$("#contactBeneficiary").val()+'</td>';
            htmlTags += '<td class="text-center"><button type="button" class="btn-xs btn-danger" onclick="Contact.deleteBeneficiary(this);"><i class="hi hi-trash" title="Eliminar"></i></button></td></tr>';
                    $('#dataBeneficiary tbody').append(htmlTags);
            return(true);
        },
        deleteBeneficiary: function(row) {
            var d = row.parentNode.parentNode.rowIndex;
            document.getElementById('dataBeneficiary').deleteRow(d);
        },
        existsBeneficiary: function() {
            var e = $("#masked_rut_beneficiary").val();
            var tab = document.getElementById("dataBeneficiary");
            var tabTD = tab.getElementsByTagName("td");
            for (var i=0; i<tabTD.length; i++){
                if(tabTD[i].innerText==$("#masked_rut_beneficiary").val()){
                    return(true);
                }
            }
            return(false);
        },
        sumPercentage: function() {
            var tab = document.getElementById("dataBeneficiary");
            var sum = 0;
            var tabTR = tab.getElementsByTagName("tr");
            for (var i=0; i<tabTR.length; i++){
                var tabTD = tabTR[i].getElementsByTagName("td");
                if(tabTD.length>1) {

                    sum = sum + Number(tabTD[5].innerText);

                }
            }
            return(Number(sum));
        },
        countBeneficiaries: function() {
            var tab = document.getElementById("dataBeneficiary");

            var tabTR = tab.getElementsByTagName("tr");

            return(tabTR.length - 1);

        }

    };
}();
