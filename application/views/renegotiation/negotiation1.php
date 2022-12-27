<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head', '1'); ?>

<div id="page-content">

  <!--div class="content-header">
      <ul class="nav-horizontal text-center">
          <li><a href="/renegotiation/search" onclick="Client.processShow();"><i class="fa fa-search"></i> Buscar</a></li>
          <li class="active"><a href="/renegotiation/negotiation" onclick="Client.processShow();"><i class="gi gi-calculator"></i> Negociaci&oacute;n</a></li>
          <li><a href="/renegotiation/script" onclick="Client.processShow();"><i class="hi hi-screenshot"></i> Script</a></li>
          <li><a href="/renegotiation/authorization" onclick="Client.processShow();"><i class="hi hi-ok"></i> Autorizaci&oacute;n</a></li>
      </ul>
  </div-->

  <ul class="breadcrumb breadcrumb-top">
    <li><strong>Flujos comerciales</strong></li>
    <li><strong>Renegociar</strong></li>
    <li><a href="/renegotiation/search" onclick="Client.processShow();">Buscar</a></li>
    <li><strong>Negociaci&oacute;n</strong></li>
    <li><a href="/renegotiation/script" onclick="Client.processShow();">Script Cierre Negociaci&oacute;n</a></li>
    <li><a href="/renegotiation/authorization" onclick="Client.processShow();">Autorizaci&oacute;n</a></li>
  </ul>

<div class="row">
  <div class="col-md-12">
    <div class="block">
      <div class="block-title">
          <div class="block-options pull-right">
              <h2>Modo:<strong>&nbsp;<?= $this->session->userdata('attention_mode', '1');?></strong>&nbsp;</h2>
          </div>
          <h2><i class="fa fa-file-o"></i><strong>&nbsp;Identificaci&#243;n</strong> del Cliente</h2>
      </div>

      <div id="alert-message" style="display:none;">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-check-circle"></i> Atenci&#243;n</h4>
            <label id="label_1"></label></br>
            <label id="label_2"></label></br>
            <label id="label_3"></label></br>
            <label id="label_4"></label>
        </div>
      </div>

      <form name="form-client" id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">

      <fieldset>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="rutClient">Nº de Rut</label>
                    <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center" placeholder=""
                    onkeypress="return Teknodata.enter_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this)" ></input>
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="number_phone">N° Tarjeta</label>
                    <input type="text" id="number_pan" name="number_pan" class="form-control text-center" readonly >
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-3">
                    <label for="example-nf-name">Cliente</label>
                    <input type="text" id="label_nameClient" name="label_nameClient" class="form-control text-left" onKeyUp="this.value=this.value.toUpperCase();" readonly >

                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control text-center minusculas" readonly >
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="number_phone">Teléfono</label>
                    <input type="text" id="number_phone" name="number_phone" class="form-control text-left" readonly >
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-4">
                    <label for="number_phone">Dirección</label>
                    <input type="text" id="address" name="address" class="form-control text-left" readonly >
                </div>

                <div class="form-group col-xs-2 col-sm-2 col-lg-2">
                    <label for="amount">Monto a Renegociar</label>
                    <input type="text" id="amount_renegotiate" name="amount_renegotiate" onkeyup="Teknodata.formatMoneda(this);" disabled onchange="Teknodata.formatMoneda(this);" class="form-control text-center" >
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-1">
                    <label for="">&nbsp;</label>
                    <div class="input-group">
                        <button type="reset" class="btn-reset btn btn-warning" ><i class="fa fa-repeat"></i> Limpiar</button>
                    </div>
                </div>

      </fieldset>

      </form>
    </div>
  </div>
</div>


<div class="row">

<div class="col-md-12">

<div class="block">

  <div class="block-title">

    <div class="block-options pull-right">
        <a href="#situation" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
    </div>
    <h2><i class="fa fa-building-o"></i>&nbsp;<strong>Situación</strong> del Cliente</h2>

  </div>

  <div class="collapse" id="situation">

    <fieldset>
    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
          <h2><i class="fa fa-building-o"></i>&nbsp;<strong>Situación</strong></h2>
          <div class="block-options pull-right">
              <a href="#client" class="btn btn-alt btn-sm btn-primary" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
          </div>
        </div>

        <div class="collapse" id="client">

        <fieldset>

            <div class="multi-collapse" id="dataAccount">

              <table class="table table-striped table-bordered" id="tabAccount">
              </table>

            </div>

        </fieldset>
        </div>


      </div>
    </div>

    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
          <div class="block-options pull-right">
              <a href="#payment" class="btn btn-alt btn-sm btn-primary" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
          </div>
          <h2><i class="fa fa-money"></i>&nbsp;<strong>Últimos</strong> Pagos</h2>
        </div>

        <div class="collapse" id="payment">

        <fieldset>


          <div class="multi-collapse" id="dataPayment">

            <table class="table table-striped table-bordered" id="tabPayment">
            </table>

          </div>

        </fieldset>

        </div>

      </div>
    </div>

    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
          <div class="block-options pull-right">
              <a href="#secure" class="btn btn-alt btn-sm btn-primary" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
          </div>
          <h2><i class="fa fa-shield"></i>&nbsp;<strong>Seguros</strong> del Cliente</h2>
        </div>

        <div class="collapse" id="secure">

        <fieldset>

          <div class="multi-collapse" id="dataSecure">

            <table class="table table-striped table-bordered" id="tabSecure">
            </table>

          </div>

        </fieldset>
        </div>

      </div>
    </div>

    </fieldset>

  </div>

</div><!--End block-->

</div><!--End col-md-12-->

</div><!--End row-->


<div class="row">

<div class="col-md-12">

<div class="block">

  <div class="block-title">

    <h2><i class="fa fa-thumbs-o-up"></i>&nbsp;<strong>Negociación</strong> Modalidad de Pago&nbsp;&nbsp;
          <label class="switch switch-success checkbox-inline"><input id="formPay" name="formPay" type="checkbox" checked onclick="Client.formPay(this);"><span></span><h2>
          <label id="lblformPay"><strong>Pago Normal</strong></label></h2></label>
    </h2>

    <div class="block-options pull-right">
        <a href="#formpay" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
    </div>

  </div>

  <div class="collapse" id="formpay">

    <fieldset>

        <div id="winpaynormal" >

          <fieldset>
          <div class="form-group col-xs-4 col-sm-4 col-lg-2">&nbsp;</div>
          <div class="form-group col-xs-4 col-sm-4 col-lg-1">
              <label for="numberQuotesNormal">Cuotas<span class="text-danger">*</span></label>
              <select id="numberQuotesNormal" name="numberQuotesNormal" class="form-control text-center" data-target="" >
                  <?php
                  for ($i = $environment["MINIMO_CUOTAS_REN"]; $i <= $environment["MAXIMO_CUOTAS_REN"]; $i++) {
                    echo "<option value='".$i."'>".$i."</option>";
                  }
                  ?>
              </select>

          </div>

          <div class="form-group col-xs-4 col-sm-4 col-lg-2">
              <label for="dateEndNormal">Primer Vencimiento<span class="text-danger">*</span></label>
              <input type="text" id="dateEndNormal" name="dateEndNormal" disabled class="form-control text-center" >
          </div>

          <div class="form-group col-xs-4 col-sm-4 col-lg-2">
              <label for="amountSecureNormal">Seguro Desgravamen<span class="text-danger">*</span></label>
              <input type="text" id="amountSecureNormal" name="amountSecureNormal" onkeyup="Teknodata.formatMoneda(this);" disabled onchange="Teknodata.formatMoneda(this);" class="form-control text-center" >
          </div>

          <div class="form-group col-xs-4 col-sm-4 col-lg-1">
              <label >&nbsp;</label><br>
              <button type="submit" class="btn-simulate btn btn-danger"><i class="gi gi-calculator"></i> Simular </button>
          </div>

          </fieldset>

        </div>

        <div id="winpaydifer" style="display:none;">

          <fieldset>
          <div class="form-group col-xs-4 col-sm-4 col-lg-2">&nbsp;</div>

          <div class="form-group col-xs-4 col-sm-4 col-lg-1">
              <label for="numberDeferred">Diferido<span class="text-danger">*</span></label>
              <select id="numberDeferred" name="numberDeferred" class="form-control text-center" data-target="" >
                  <?php
                  for ($i = $environment["MINIMO_DIFERIDOS_REN"]; $i <= $environment["MAXIMO_DIFERIDOS_REN"]; $i++) {
                    echo "<option value='".$i."'>".$i."</option>";
                  }
                  ?>
              </select>
          </div>

          <div class="form-group col-xs-4 col-sm-4 col-lg-2">
              <label for="dateEndDifer">Primer Vencimiento<span class="text-danger">*</span></label>
              <input type="text" id="dateEndDifer" name="dateEndDifer" disabled class="form-control text-center" >
          </div>

          <div class="form-group col-xs-4 col-sm-4 col-lg-1">
              <label for="numberQuotesDifer">Cuotas<span class="text-danger">*</span></label>
              <select id="numberQuotesDifer" name="numberQuotesDifer" class="form-control text-center" data-target="" >
                  <?php
                  for ($i = $environment["MINIMO_CUOTAS_REN"]; $i <= $environment["MAXIMO_CUOTAS_REN"]; $i++) {
                    echo "<option value='".$i."'>".$i."</option>";
                  }
                  ?>
              </select>
          </div>

          <div class="form-group col-xs-4 col-sm-4 col-lg-2">
              <label for="amountSecureDifer">Seguro Desgravamen<span class="text-danger">*</span></label>
              <input type="text" id="amountSecureDifer" name="amountSecureDifer" onkeyup="Teknodata.formatMoneda(this);" disabled onchange="Teknodata.formatMoneda(this);" class="form-control text-center" value="$24.000">
          </div>

          <div class="form-group col-xs-4 col-sm-4 col-lg-1">
              <label for="btn">&nbsp;</label><br>
              <button type="submit" class="btn-simulate btn btn-danger"><i class="gi gi-calculator"></i> Simular </button>
          </div>


          </fieldset>

        </div>

    </fieldset>

    <fieldset>
    <div class="form-group col-xs-4 col-sm-4 col-lg-2">&nbsp;</div>
    <div class="form-group col-xs-8 col-sm-8 col-lg-8">

      <table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
      </table>

    </div>
    </fieldset>


  </div>

</div><!--End block-->

<!--Begin Botones de Control Formulario-->
<div class="form-group text-center">
  <button type="button" style="width:150px" class="btn-save btn btn-success" ><i class="fa fa-floppy-o"></i> Grabar </button>
  <button type="button" style="width:150px" class="btn-cancel btn btn-success" ><i class="fa fa-ban"></i> Cancelar</button>
</div>
<!--End Botones de Control Formulario-->

</div><!--End col-md-12-->

</div><!--End row-->

<input type="hidden" id="id_office" value="<?= $this->session->userdata('id_office')?>">
<input type="hidden" id="id_user" value="<?= $this->session->userdata('id_user')?>">
<input type="hidden" id="nroTcv" value="<?= $this->session->userdata('nroTcv')?>">

<input type="hidden" id="amount_admin">
<input type="hidden" id="nameClient">
<input type="hidden" id="lastnameClient">
<input type="hidden" id="days_over">
<input type="hidden" id="lblDireccion">
<input type="hidden" id="flg_flujo">
<input type="hidden" id="flg_type">
<input type="hidden" id="reason">
<input type="hidden" id="nroReneg">

<input type="hidden" id="virtualReason">
<input type="hidden" id="virtualApprover">
<input type="hidden" id="virtualCollection">

<input type="hidden" id="datajson">
<input type="hidden" id="htmlCupos">
<input type="hidden" id="htmlDetalle">
<input type="hidden" id="payment_type">
</div>
<!-- END Page Content -->

<?php $this->load->view('footer', '1'); ?>
<?php $this->load->view('ModalAlert', '1'); ?>
<?php $this->load->view('ModalLink', '1'); ?>
<?php $this->load->view('ModalCreate', '1'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script language="Javascript">
$(function () {

    $('#btn-cancel-request').on('click', function () {
          Client.prepare();
    });
    $('.btn-save').on('click', function () {
        Client.saveRenegotiation();
    });
    $('.btn-return').on('click', function () {
        $.redirect("/renegotiation");
    });

    $('.btn-reset').on('click', function () { Client.prepare(); });

    $(".btn-script-normal").on("click", function () {

        var formData = new FormData();
        formData.append("nroRut", $("#masked_rut_client").val());
        formData.append("datajson", $("#datajson").val());
        formData.append("idscript", 13201);

        var response = Teknodata.call_ajax("/renegotiation/get_script", formData, false, true,  ".btn-script-normal");

        if(response!=false){

            if(response.retorno == 0){

                Alert.showWarning("",response.html, modal_size_lg);

            }else{

                Alert.showWarning("", response.descRetorno, modal_size_md);
           }
        }

    });

    $('.btn-simulate').on('click', function () {

        var formData = new FormData();
        if($('#masked_rut_client').val()==""){toastr.warning("Debe ingresar RUT Cliente para negociar Renegociación..","Presta Mucha Atención ..!"); return(false); }
        if($("#payment_type").val()=="NORMAL"){
            number_quotes = $("#numberQuotesNormal").val(); deferred_quotes = 0;
            if(!$.isNumeric(number_quotes)){toastr.warning("Debe indicar número de cuotas para negociar Renegociación..","Presta Mucha Atención ..!"); return(false); }
        }else{
            number_quotes = $("#numberQuotesDifer").val(); deferred_quotes = $("#numberDeferred").val();
            if(!$.isNumeric(number_quotes)){toastr.warning("Debe indicar número de cuotas para negociar Renegociación..","Presta Mucha Atención ..!"); return(false); }
            if(!$.isNumeric(deferred_quotes)){toastr.warning("Debe indicar número de cuotas a diferir para negociar Renegociación..","Presta Mucha Atención ..!"); return(false); }
        }

        formData.append("number_rut_client", $("#masked_rut_client").val());
        formData.append("amount", $("#amount_renegotiate").val());
        formData.append("nroTcv", $("#nroTcv").val());
        formData.append("number_quotes", number_quotes);
        formData.append("deferred_quotes", deferred_quotes);
        formData.append("flg_flujo", $("#flg_flujo").val());
        formData.append("amount_secure", $("#amountSecureDifer").val());
        formData.append("amount_admin", $("#amount_admin").val());

        var response = Teknodata.call_ajax("/renegotiation/get_simulate", formData, false, true,  ".btn-simulate");

        $("#tabSimulate").html("");
        if(response!=false){

            if(response.retorno == 0){

                Client.initSimulate(response);

           }else{

                Alert.showWarning(response.descRetorno,"","md");

           }
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

        showQuota: function() {

            var title = "Cupos Disponibles"; var messages = $('#htmlCupos').val(); var window_size = "xs";
            Alert.showWarning( title, messages, window_size);
            return(false);

        },
        saveRenegotiation: function() {
            var formData = new FormData();

            var tab = document.getElementById('tabSimulate');
            var $flagSave = false;

            if(!$("#tabSimulate").length){ toastr.warning("No hay detalle de Oferta ..!", "Preste Atención"); return(false); }
            for (var i=1;i < tab.rows.length; i++) {
                /* Selecciona CheckBox con Opción Cliente*/
                sel = document.getElementById("sel"+tab.rows[i].cells[1].innerHTML);
                if(sel.checked){
                    $flagSave = true;
                    var number_quotes=tab.rows[i].cells[1].innerHTML;
                    var amount_quotes_value = tab.rows[i].cells[2].innerHTML;
                    var amount_quotes_taxes = tab.rows[i].cells[3].innerHTML;
                    var amount_quotes_rate = tab.rows[i].cells[4].innerHTML;
                    var amount_cae_rate = tab.rows[i].cells[5].innerHTML;
                    var amount_total_renegotiate = tab.rows[i].cells[6].innerHTML;
                }
            }
            if(!$flagSave){

                var title = "Preste Atención"; var messages = "Revise negociación antes de intentar grabar..!"; var window_size = "sm";
                Alert.showWarning( title, messages, window_size);
                return(false);
            }

            formData.append("nameClient",$("#nameClient").val());
            formData.append("lastnameClient",$("#lastnameClient").val());
            formData.append("amount",amount_renegotiate);
            formData.append("number_rut_client",$("#masked_rut_client").val());
            formData.append("number_phone",$("#number_phone").val());
            formData.append("email",$("#email").val());

            formData.append("virtualReason",$("#virtualReason").val());
            formData.append("virtualApprover",$("#virtualApprover").val());
            formData.append("virtualCollection",$("#virtualCollection").val());

            if($("#payment_type").val()=="NORMAL"){
                formData.append("payment_type",$("#payment_type").val());
                formData.append("first_date_expires_quotes",$("#dateEndNormal").val());
                formData.append("amount_quotes_secure",$("#amountSecureNormal").val());
                formData.append("number_quotes",number_quotes);
                formData.append("deferred_quotes",0);
            }else{
              formData.append("payment_type",$("#payment_type").val());
              formData.append("first_date_expires_quotes",$("#dateEndDifer").val());
              formData.append("amount_quotes_secure",$("#amountSecureDifer").val());
              formData.append("number_quotes",number_quotes);
              formData.append("deferred_quotes",$("#numberDeferred").val());
            }
            formData.append("amount_quotes_value",amount_quotes_value);
            formData.append("amount_quotes_taxes",amount_quotes_taxes);
            formData.append("amount_quotes_rate",amount_quotes_rate);
            formData.append("amount_cae_rate", amount_cae_rate);
            formData.append("amount_total_renegotiate", amount_total_renegotiate);
            formData.append("amount_renegotiate", $("#amount_renegotiate").val());
            formData.append("days_over", $("#days_over").val());
            formData.append("lblDireccion", $("#lblDireccion").val());
            formData.append("flg_flujo", $("#flg_flujo").val());
            formData.append("flg_type", $("#flg_type").val());
            formData.append("reason", $("#reason").val());
            formData.append("nroReneg", $("#nroReneg").val());

            var response = Teknodata.call_ajax("/renegotiation/validate_save_renegotiation", formData, false, true, ".btn-save");
            if(response!=false){

                if(response.retorno==0) {

                    $.redirect("/renegotiation/script", { id: response.autorizador } );

                }else{

                    var title = "Preste Atención"; var messages = response.descRetorno; var window_size = "md";
                    Alert.showWarning(title, messages, window_size);
                    //Alert.showToastrWarning(response);
                }

            }

            return (true);
        },

        loadOffers: function(response) {

            $("#datajson").val(JSON.stringify(response));

            /*Datos de Contacto Cliente*/
            $("#label_nameClient").val(response.completeNameClient);
            $("#email").val(response.email);
            $("#number_phone").val(response.phone);
            $("#nameClient").val(response.nameClient);
            $("#lastnameClient").val(response.lastnameClient);
            $("#sexoClient").val(response.sexoClient);
            $("#address").val(response.lblDireccion);
            $("#number_pan").val(response.offTcv);
            $("#nroTcv").val(response.nroTcv);
            $("#days_over").val(response.diasMora);
            $("#lblDireccion").val(response.lblDireccion);
            $("#flg_flujo").val(response.flg_flujo);
            $("#amount_admin").val(response.amount_admin);

            /*Datos productos del cliente*/
            $('#tabAccount').html(response.dataAccount);
            $('#tabSecure').html(response.dataSecure);
            $('#tabPayment').html(response.dataPayment);
            $("#htmlCupos").val(response.htmlCupos);
            $("#htmlDetalle").val(response.htmlDetalle)

            /*Datos Simulacion*/
            $('#tabSimulate').html(response.dataSimulate);
            $("#"+response.lastLine).prop("checked", true);
            $("#numberQuotesNormal").val(response.lastQuota);
            $("#numberQuotesDifer").val(response.lastQuota);

            $('#amountSecureDifer').val(Teknodata.maskMoney(response.amountSecureDifer));
            $('#dateEndDifer').val(response.dateEndDifer);
            $('#dateEndNormal').val(response.dateEndNormal);
            $('#amountSecureNormal').val(Teknodata.maskMoney(response.amountSecureNormal));
            $('#amount_renegotiate').val(Teknodata.maskMoney(response.amount_renegotiate));

            /*Activa botones de acción*/
            $(".btn-save").prop('disabled', false);
            $(".btn-return").prop('disabled', false);

            /*Inicializa Ventanas Datos Cliente*/
            $("#situation").collapse("show");
            $("#client").collapse("show");
            $("#payment").collapse("show");
            $("#secure").collapse("show");
            $("#renegotiation").collapse("hide");
            $("#formpay").collapse("hide");

            $("#formPay").prop("disabled", false);
            $("#flg_client").val(1);
            $("#flg_type").val("N");
            $("#reason").val(response.warning_reason);
            $("#nroReneg").val(response.nroReneg);

            if(response.warning_message!=""){
                $("#flg_type").val(response.warning_type);
                $("#virtualReason").val(response.warning_reason);
                $("#virtualApprover").val(response.warning_approver);
                $("#virtualCollection").val(response.warning_collection);
                Alert.showRequest(response.warning_title, response.warning_message);
            }

        },
        prepare: function() {

          Client.clearForm("form-client");
          $("#formPay").prop("checked", true);
          var win1 = document.getElementById("winpaynormal"); var win2 = document.getElementById("winpaydifer");
          $("#payment_type").val("NORMAL"); $("#lblformPay").html("Pago Normal"); win1.style.display=""; win2.style.display="none";
          $("#masked_rut_client").prop('disabled', false); $("#emailClient").prop('disabled', true); $("#phoneClient").prop('disabled', true); $("#approbation").click();

          win1 = document.getElementById("alert-message");  win1.style.display = "none";
          $("#label_1").html(""); $("#label_2").html(""); $("#label_3").html(""); $("#label_4").html("");

          /*Desactiva botones de acción*/
          $(".btn-save").prop('disabled', false);
          $(".btn-return").prop('disabled', false);

          $("#numberQuotesNormal").val("0");
          $("#dateEndNormal").val("");
          $("#amountSecureNormal").val("0");

          $("#numberDeferredDifer").val("0");
          $("#numberQuotesDifer").val("0");
          $("#dateEndDifer").val("");
          $("#amountSecureDifer").val("0");

          /*Inicializa Ventanas Datos Cliente*/
          $("#situation").collapse("hide");
          $("#client").collapse("hide");
          $("#payment").collapse("hide");
          $("#secure").collapse("hide");
          $("#renegotiation").collapse("hide");
          $("#formpay").collapse("hide");

          $("#formPay").prop("disabled", true);
          $("#formPay").prop("checked", true);

          $("#flg_client").val(0);
          $("#masked_rut_client").focus();
        },
        clearForm: function(nameForm) {
            var form  = document.getElementById(nameForm);
            for (var i=0;i<form.elements.length;i++) {
                if(form.elements[i].type == "text") form.elements[i].value = "";
            }
        },
        initSimulate: function(response) {

            o = document.getElementById('tabSimulate');
            if(response.lastQuota!=0){

                o.innerHTML = response.dataSimulate;
                $("#"+response.lastLine).prop("checked", true);
                $('#dateEndDifer').val(response.dateEndDifer);
                $('#dateEndNormal').val(response.dateEndNormal);

            }else{

                var title = "Preste Atención"; var messages = response.descRetorno; var window_size = "md";
                Alert.showWarning( title, messages, window_size);
            }

        },

        formPay: function(val) {
          var win1 = document.getElementById("winpaynormal");
          var win2 = document.getElementById("winpaydifer");
          if(val.checked) { $("#payment_type").val("NORMAL"); $("#lblformPay").html("Pago Normal"); win1.style.display=""; win2.style.display="none"; } else { $("#payment_type").val("DIFERIDO"); $("#lblformPay").html("Pago Diferido"); win1.style.display="none"; win2.style.display=""; }
          $("#formpay").collapse("show");
        },

        showDetails: function() {

          var script = $("#htmlDetalle").val();
          Alert.showWarning("Detalle Renegociación",script,"md");

        },
        selectRequest: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idRequest = tabTD[1].innerText;
            var idCheck = "sel"+idRequest;
            document.getElementById(idCheck).checked = true;
        },
/*
        selectOffers: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idRequest = tabTD[1].innerText;
            var idCheck = "sel1";
            document.getElementById(idCheck).checked = true;
        },*/
        get_ClientByRut: function() {
            Client.search();
        },
        search: function() {

            var formData = new FormData();
            var rut = $("#masked_rut_client").val(); Client.prepare(); $("#masked_rut_client").val(rut); $("#masked_rut_client").prop('disabled', true);

            formData.append("nroRut", rut);
            var response = Teknodata.call_ajax("/renegotiation/evaluation_client", formData, false, true, "#masked_rut_client");

            if(response!=false){

                if(response.retorno==0) {

                    Client.loadOffers(response);
                    $("#masked_rut_client").prop('disabled', true);

                } else {

                  Alert.showWarning("Preste Atención",response.descRetorno,"md");
                  $("#masked_rut_client").prop('disabled', false); $("#masked_rut_client").val("");
                  $("#htmlCupos").val("");

                }

            }

        },

        initAuthorization: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPayOne").prop("disabled", true); $("#formPayTwo").prop("disabled", true);
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
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.search();
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
$(function(){ Client.processHide(); });
</script>
</body>
</html>
