<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">
    <div class="content-header">
        <ul class="nav-horizontal text-center">
            <li class="active"><a href="/client/search" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-search"></i> Buscar</a></li>
            <li><a href="/client/consolidate" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-crop"></i> Consolidado</a></li>
            <li><a href="/client/information" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-user"></i> Personales</a></li>
            <li><a href="/client/contact" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-phone"></i> Contacto</a></li>
            <li><a href="/client/lasttransaction" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-transfer"></i> Transacciones</a></li>
            <li><a href="/client/lastaccount" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt"></i> Detalle EECC</a></li>
            <li><a href="/client/secure" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-warning_sign"></i> Seguros</a></li>
            <li><a href="/client/replacecard" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card"></i> Reponer Tarjeta</a></li>
        </ul>
    </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><strong>Centro de servicios</strong></li>
        <li><strong>B&#250;squeda Cliente</strong></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title text-center">
                    <h2><strong> Centro de Servicios Tarjeta Cruz Verde</strong></h2>
                </div>
                <form id="form-client" method="post" action="" class="form-horizontal form-bordered form-control-borderless">
                    <div class="form-group">

                        <div class="col-md-5">
                            <label for="masked_rut_client"><strong>N&#250;mero RUT Cliente</strong></label>
                            <div class="input-group col-sm-6">
                                <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center" placeholder="" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this)"></input>
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="masked_credit_card">N&#250;mero Tarjeta Cr&#233;dito</label>
                            <div class="input-group col-sm-6">
                                <input type="text" id="masked_credit_card" name="masked_credit_card" data-inputmask="'alias': 'nroTcv'" class="form-control text-center" placeholder="">
                                <span class="input-group-addon"><i class="gi gi-credit_card"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                            <button type="reset" class="btn btn-warning" onclick="Client.set_session();"><i class="fa fa-repeat"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row" id="client-details" style="display:none;" >

        <div class="col-md-12">
            <div class="block">
              <div class="block-title">
                <h2><strong>Ofertas del Cliente</strong></h2>
              </div>
              <div id="client_offers">
              </div>

            </div>
        </div>

        <div class="col-md-12">
            <div class="block">

              <div class="block-title">
                  <h2><strong>Productos del Cliente</strong></h2>
              </div>
              <div id="product_client">
              </div>
            </div>
        </div>

    </div>
    <!--END row-->

<input type="hidden" id="preaprobada" value="">
<input type="hidden" id="id_office" value="">
<input type="hidden" id="nroRut" value="<?=$this->session->userdata('nroRut');?>">
<input type="hidden" id="expired_customer" value="">

</div>
<!-- End page-content-->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>

<!-- Javascript exclusivos para esta página -->
<script> 

$(function () {

    $('.btn-modal-action').on('click', function () {

        if($(this).attr('data-target')=="accept_client"){

            if($("#expired_customer").val()=="S"){
                $.redirect("/client/lastaccount", { nroRut: $("#masked_rut_client").val(), expired_customer: $("#expired_customer").val() } );
                return(false);
            }

            if($("#preaprobada").val()=="1") {
                Client.set_session();
                $.redirect("/capturing/approved", { nroRut: $("#masked_rut_client").val() } );
                return(false);
            }

            if($("#reasonSkill").val()==115999 && $("#reasonDetail").val()==""){
                toastr.success('Al seleccionar Otro Motivo, Debe ingresar detalle para el motivo de Atención!', 'Transacción Rechazada');
                return(false);
            }

            $(".close").click();

            var formData = new FormData();
            formData.append("reasonSkill", $("#reasonSkill").val());
            formData.append("reasonDetail", $("#reasonDetail").val());
            formData.append("nroRut", $("#nroRut").val());

            var response = Teknodata.call_ajax("/CallWSSolventa/get_client", formData, false, true, "");
            if(response!=false){

                if(response.retorno==0) {
                    e = document.getElementById('client_offers');
                    e.innerHTML = response.htmlOffers;
                    e = document.getElementById('product_client');
                    e.innerHTML = response.htmlProduct;
                    Client.restore();
                    if(response.htmlOffersPopup!=""){
                        Alert.initaccept_noclient();Alert.showSearch("",response.htmlOffersPopup);
                        return(false);
                    }

                } else {

                    Alert.showWarning("",response.descRetorno,modal_size_md);
                }

            }
            return(true);
        }

        if($(this).attr('data-target')=="cancel_client"){

            Client.set_session();
            return(true);
        }

        if($(this).attr('data-target')=="cancel_noclient"){

            return(true);
        }

        if($(this).attr('data-target')=="accept_noclient"){

            Client.set_session();
            $.redirect("/capturing/approved", { nroRut: $("#masked_rut_client").val() } );
            return(true);
        }



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
          if($("#masked_rut_client").val()=="" && $("#masked_credit_card").val()=="") { Alert.showAlert("Ingrese N&#250;mero RUT o N&#250;mero Tarjeta Cr&#233;dito"); return(false); } else { return(true); }
        },
        prepare: function() {
          e = document.getElementById("client-details");e.style.display="none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display="";
        },
        set_offer: function(offerType) {
            Client.set_session();
            $.redirect("/capturing/approved", { nroRut: $("#masked_rut_client").val() } );
            return(false);
        },
        search: function() {

            Client.prepare();

            if($("#masked_rut_client").val()!="") { var ourl="/CallWSSolventa/search_client_by_rut"; } else {if($("#masked_credit_card").val()!="") { var ourl="/CallWSSolventa/search_client_by_target"; } }

            var formData = new FormData();
            formData.append("nroTcv", $("#masked_credit_card").val());
            formData.append("nroRut", $("#masked_rut_client").val());

            var response = Teknodata.call_ajax(ourl, formData, false, true, ".btn");
            if(response!=false){

                if(response.retorno==0){

                    $("#preaprobada").val(response.preaprobada);
                    $("#id_office").val(response.id_office);
                    $("#nroRut").val(response.nroRut);
                    $("#expired_customer").val(response.expired_customer);
                    Alert.initaccept_client();Alert.showSearch("",response.html);

                }else{

                    Alert.init();Alert.showSearch("",response.html);Client.set_session();

                }

            }
            return(false);
        },
        get_session: function() {

            var response = Teknodata.call_ajax("/CallWSSolventa/get_session_client", "", false, true, "");
            if(response!=false){

                if(response.retorno==0) {
                    e = document.getElementById('client_offers');
                    e.innerHTML = response['htmlOffers'];
                    e = document.getElementById('product_client');
                    e.innerHTML = response['htmlProduct'];
                    if(response.htmlOffersPopup!=""){
                        Alert.initaccept_noclient();Alert.showSearch("",response.htmlOffersPopup);
                    }
                    Client.restore();
                }

            }
            return(false);
        },
        set_session: function(){

            $("#nroRut").val("");
            var response = Teknodata.call_ajax("/CallWSSolventa/set_session_client", "", false, true, ".btn");
            Client.prepare();
            return(false);
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
            $('#masked_credit_card').mask('9999-9999-9999-9999');
        }
    };
}();

$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
if($("#nroRut").val()!=""){
    $("#masked_rut_client").val($("#nroRut").val());
    $(function(){ Client.get_session(); });
}
</script>

</body>
</html>
