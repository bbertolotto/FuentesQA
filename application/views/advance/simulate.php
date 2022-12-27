<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>

<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
        <li>Flujos comerciales</li>
        <li>S&#250;per Avances</li>
        <li>Simulaci&#243;n</a></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">

      <div class="col-md-12">

          <div class="block">
              <div class="block-title">
                  <div class="block-options pull-right">
                      <h2>Modo: <strong><?= $this->session->userdata('attention_mode');?></strong></h2>
                  </div>
                  <h2><strong>Simulaci&#243;n de Súper Avances</strong></h2>
              </div>

<div class="row">
<div class="col-sm-12">

<div class="block">

<div class="block-title">
  <h2><strong>Buscar Cliente</strong></h2>
</div>

  <form id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless" border="1">

      <div class="form-group">
          <div class="col-sm-3">
              <label for="masked_rut_client">Rut</label>
              <div class="input-group">
                <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this);">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success"><i class="gi gi-search"></i> Buscar</button>
                </span>
                <span class="input-group-btn">
                    <button type="reset" class="btn btn-warning" onclick="Client.prepare();"><i class="gi gi-refresh"></i> Limpiar</button>
                </span>
              </div>
          </div>
          <div class="col-sm-3">
              <div class="input-group col-sm-8">
                  <label for="label_name_client">Cliente</label>
                  <input type="text" id="label_nameClient" name="label_nameClient" class="form-control" placeholder="" readonly></input>
              </div>
          </div>

          <div class="col-sm-3">
              <div class="input-group">
                  <label for="email">Email</label>
                  <input type="text" id="emailCuenta" name="emailCuenta" class="form-control" placeholder="" readonly></input>
              </div>
          </div>

          <div class="col-sm-3">
              <div class="input-group">
                  <label for="phone">Teléfono</label>
                  <input type="text" id="telefonoCuenta" name="telefonoCuenta" class="form-control" placeholder="" readonly></input>
              </div>
          </div>



      </div>

  </form>

</div><!--End Block-->

</div><!--End col-md-12-->
</div><!--End row-->

            <div class="row">

              <div class="col-sm-12">

                <div class="block">

                  <div class="block-title">
                    <h2><strong>Condiciones Negociaci&#243;n</strong></h2>
                  </div>

                  <form id="form-simulate" method="post" target="_blank" class="form-horizontal form-bordered form-control-borderless">

                    <div class="form-group">

                      <div class="col-sm-2">
                            <label for="amountSimulate">Monto a Simular <span class="text-danger">*</span></label>
                            <input type="text" onkeyup="Teknodata.formatMoneda(this);" onchange="Teknodata.formatMoneda(this);" id="amountSimulate" data-target="<?=$dataLoad['minAmount']?>" class="form-control text-center" data-toggle="tooltip" data-placement="top" title="<?= $dataLoad['titleAmountSimulate'] ?>">
                      </div>

                      <div class="col-md-2">
                          <label for="numberQuotas">N&#237;mero Cuotas<span class="text-danger">*</span></label>
                          <div class="input-group col-xs-8">
                            <select id="numberQuotas" name="numberQuotas" class="form-control text-center" data-target="<?=$dataLoad['maxNumberQuotas']?>" data-toggle="tooltip" data-placement="top" title="<?= $dataLoad['titleNumberQuotas'] ?>">
                              <?php 
                              for ($i = $dataLoad['minNumberQuotas']; $i <= $dataLoad['maxNumberQuotas']; $i++) {
                                  echo "<option value=".$i.">".$i."</option>";
                              }
                              ?>
                            </select>
                          </div>
                      </div>
                        
                      <div class="col-md-2">
                          <label for="deferredQuotas">Meses Diferidos<span class="text-danger">*</span></label>
                          <div class="input-group col-xs-8">
                            <select id="deferredQuotas" name="deferredQuotas" class="form-control text-center" data-target="<?=$dataLoad['minDeferredQuotas']?>" data-toggle="tooltip" data-placement="top" title="<?= $dataLoad['titleDeferredQuotas'] ?>">
                              <?php 
                              for ($i = $dataLoad['minDeferredQuotas']; $i <= $dataLoad['maxDeferredQuotas']; $i++) {
                                  echo "<option value=".$i.">".$i."</option>";
                              }
                              ?>
                            </select>
                          </div>
                      </div>  

                      <div class="col-sm-2">
                          <label for="interesRate">Tasa</label>
                          <div class="input-group">
                            <input type="text" style="width:100px" id="interesRate" name="interesRate" class="form-control text-center" value="<?=$dataLoad['interesRate']?>" readonly  data-toggle="tooltip" data-placement="top" title="<?= $dataLoad['titleInteresRate']?>">
                          </div>
                      </div>

                      <div class="col-sm-3">
                          <label for="dateFirstExpiration">Primer Vencimiento</label>
                          <div class="input-group">
                              <input type="text" id="dateFirstExpiration" name="dateFirstExpiration" value="<?=$dataLoad['dateFirstExpiration']?>" class="form-control text-center" readonly data-toggle="tooltip" data-placement="top" title="<?= $dataLoad['titleDateFirstExpiration']?>">
                          </div>
                      </div>

                  </div>  

                  <div class="form-group">

                      <div class="col-sm-6">
                          <label for="maskedSecure">Seguros <span class="text-danger">*</span></label>
                          <div class="input-group">

                          <?php    
                          if(isset($dataSecure)){

                            foreach ($dataSecure as $nodo) {
                              echo "<label class='checkbox-inline' for='".$nodo->htmlName."'>";
                              echo "<input type='checkbox' id='".$nodo->htmlName."' name='".$nodo->htmlName."' value='".$nodo->codSecure."' onclick='Client.checkSecure(this);' data-cod='".$nodo->codSecure."' data-pol='".$nodo->idPoliza."' data-target='".$nodo->htmlModal."' checked>&nbsp;".$nodo->descrip;
                              echo "</label>";
                            }
                          } ?>
                          </div>
                      </div>  
                      <div class="col-sm-2">
                          <label for="btn">&nbsp;</label>
                          <div class="input-group">
                            <button type="submit" style="width:250px" class="btn-simulate btn btn-danger"><i class="gi gi-calculator"></i> <?=htmlSIMULACION?></button>
                          </div>  
                      </div>
    

                  </div>


            <div class="col-sm-12">
              <div class="block">
                <div class="block-title">
                  <h2><strong>Detalle Simulaciones</strong></h2>
                  <div class="block-options pull-right">
                      <a href="#simulate" class="btn btn-alt btn-sm btn-primary" data-toggle="collapse"><i class="fa fa-arrows-v"></i></a>
                  </div>
                </div>

                <div class="multi-collapse" id="simulate">

                  <table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
                  </table>

                </div>

                </div>
                <!--End Block-->
              </div>
              <!--End col-md-12-->

            <div class="form-group text-center">
                <button type="button" style="width:250px" class="btn-save btn btn-danger"><i class="fa fa-floppy-o"></i> Grabar <?=htmlSIMULACION?></button>
                <button type="button" style="width:250px" class="btn-print btn btn-success" ><i class="gi gi-print"></i> Imprimir <?=htmlSIMULACION?></button>
                <button type="button" style="width:250px" class="btn-send btn btn-warning" disabled><i class="gi gi-send"></i> Enviar <?=htmlSIMULACION?> por Email</button>
                <input type="hidden" id="idDocument" name="idDocument">
                <input type="hidden" id="flg_print" name="flg_print">
                <input type="hidden" id="estadoTEF" value="simula">
            </div>

            </form>

            </div>
            <!--End Block principal-->

          </div>
          <!--End col-md-12-->

            </div>

          </div>  
          <!--End Block-->
      </div>
      <!--End col-md-12-->
    </div> 
    <!--End row-->
</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script>

$(function () {

    $('.btn-simulate').on('click', function () {
        
        if($("#masked_rut_client").val()==""){
            toastr.warning("Antes de Simular, debe ingresar RUT Cliente ..","Presta Mucha Atención ..!");
            return(false);
        }

        var formData = new FormData();
        formData.append("nroRut", $("#masked_rut_client").val());
        formData.append("offerRequest", $("#amountSimulate").val());
        formData.append("offerAmount", $("#amountSimulate").val());
        formData.append("numberQuotas", $("#numberQuotas").val());
        formData.append("deferredQuotas", $("#deferredQuotas").val());
        formData.append("amountLimit", 0);
        formData.append("amountType", 0);
        formData.append("offerType", "AP");
        if(document.getElementById('secureOne').checked){formData.append("secureOne", $("#secureOne").val());}else{formData.append("secureOne", "");}
        if(document.getElementById('secureTwo').checked){formData.append("secureTwo", $("#secureTwo").val());}else{formData.append("secureTwo", "");}

        o = document.getElementById('simulate');o.innerHTML = "";
        var response = Teknodata.call_ajax("/advance/get_simulate", formData, false, true, ".btn-simulate");

        if(response!=false){

            switch (response.retorno) {

            /* Cliente con Oferta Vigente*/
            case 0:
                o.innerHTML = response.htmlSimulate;
                $("#simulate").click();
                $("#dateFirstExpiration").val(response.dateFirstExpiration);
                $("#interesRate").val(response.interesRate+"%");
            break;

            case 11:
                Alert.init();Alert.showWarning("",response.descRetorno);
            break;

            default:
                Alert.showMessage("Preste Atención..!", "fa fa-warning", "orange", response.descRetorno);
            break;
            }

        }

        return(false);
    });

    $('.btn-reset').on('click', function () {

        Client.prepare();
    });


    $('.btn-send').on('click', function () {

        data = $("#form-simulate, #form-client").serialize();
        var response = Teknodata.call_ajax("/advance/send_Simulate", data, false, false, ".btn-send");

        if(response!=false){

            if(response.retorno==0){ 

                Alert.showAlert("Simulación enviada con éxito");

            }else{

                Alert.showMessage("Preste Atención..!", "fa fa-warning", "orange", response.descRetorno);
            }
        }

    });


    $('.btn-print').on('click', function () {

        var formData = new FormData();
        formData.append("id", $("#idDocument").val());
        formData.append("type", "SIM");
        formData.append("status", "I");

        var response = Teknodata.call_ajax("/advance/generaPDF", formData, false, true, ".btn-print");

        if(response!=false){

          if(response.retorno==0){

              $("#flg_print").val("print");
              window.open("/advance/readPDF", '_blank');

          }else{

              Alert.showMessage("Preste Atenci&#243;n..!", "fa fa-warning", "orange", response.descRetorno);
          }

        }

        return(false);

    });


    $('.btn-save').on('click', function () {

        if($('#masked_rut_client').val()==""){
            toastr.warning("Debe ingresar RUT Cliente y simular, antes de Grabar Simulación..","Presta Mucha Atención ..!");
            return(false);
        }

        var secureOne = document.getElementById('secureOne');
        var secureTwo = document.getElementById('secureTwo');

        var tab = document.getElementById('tabSimulate');
        for (var i=1;i < tab.rows.length; i++){

        /* Selecciona CheckBox con Opción Cliente*/
        sel = document.getElementById("sel"+tab.rows[i].cells[1].innerHTML);
        if(sel.checked){

            $data ="numeroCuotas="+tab.rows[i].cells[1].innerHTML;$data+="&tipoSolicitud=S";$data+="&mesesDiferido="+tab.rows[i].cells[2].innerHTML;$data+="&valorCuota="+tab.rows[i].cells[3].innerHTML;$data+="&montoBruto="+tab.rows[i].cells[4].innerHTML;$data+="&montoSolicitado="+tab.rows[i].cells[5].innerHTML;$data+="&costoTotal="+tab.rows[i].cells[6].innerHTML;$data+="&tasaInteres="+tab.rows[i].cells[7].innerHTML;$data+="&impuestos="+tab.rows[i].cells[8].innerHTML;$data+="&comision="+tab.rows[i].cells[9].innerHTML;$data+="&cae="+tab.rows[i].cells[10].innerHTML;$data+="&costoTotalSeguro1="+tab.rows[i].cells[11].innerHTML;$data+="&costoTotalSeguro2="+tab.rows[i].cells[12].innerHTML;$data+="&nroRut="+$('#masked_rut_client').val();$data+="&vencimientoCuota="+$('#dateFirstExpiration').val();
            if(secureOne.checked){
                $data+="&codSeguro1="+$(secureOne).data('cod');
                $data+="&idPolizaSeguro1="+$(secureOne).data('pol');
            }
            if(secureTwo.checked){
                $data+="&codSeguro2="+$(secureTwo).data('cod');
                $data+="&idPolizaSeguro2="+$(secureTwo).data('pol');
            }

            $data+="&bank=&typeAccount=&numberAccount=&estadoEnlace=&sucursalDestino&offerType=&fechaCompromisoEnlace=&emailClientNew=";

            $.ajax( {
                url: "/advance/put_simulate", type: "POST", dataType: "json",
                data : $data,
                success: function(response, status, xhr){

                    if(response.retorno==0) {

                        $("#idDocument").val(response.idDocument);
                        Client.processHide();
                        toastr.success(response.descRetorno, "Preste Atención ..");
                        Client.initPrint();

                    }else{

                        Client.processHide();
                        Alert.showToastrWarning(response);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Alert.showToastrErrorXHR(jqXHR, textStatus);
                }

            });

        } //End checked
        } //End for

    Client.processHide();
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
            var o = document.getElementById("amountSimulate"); Teknodata.formatMoneda(o);
            o = document.getElementById('simulate');
            o.innerHTML = ""; $('#simulate').click();
            Client.clearForm("form-client");
            Client.clearForm("form-simulate");
            $(".btn-save").prop('disabled', false);
            $(".btn-print").prop('disabled', true);
            $(".btn-send").prop('disabled', true);
            $(".btn-simulate").prop('disabled', false);
            $("#secureOne").prop('disabled', false);
            $("#secureTwo").prop('disabled', false);
        },
        clearForm: function(nameForm) {
            var form  = document.getElementById(nameForm);
            for (var i=0;i<form.elements.length;i++) {
                if(form.elements[i].type === "text") form.elements[i].value = "";
            }
        },
        checkSecure: function(obj) {

            if(document.getElementById('masked_rut_client').value==""){
                let result = obj.checked ? obj.checked = false : obj.checked = true;
                return(false);
            }
            if(!obj.checked){ Alert.showWarning('Advertencia',$(obj).data('target')); }
            $('.btn-simulate').click();
        },

        initPrint: function () {

            $("#secureOne").prop('disabled', true);
            $("#secureTwo").prop('disabled', true);
            $(".btn-simulate").prop('disabled', true);
            $(".btn-save").prop('disabled', true);
            $(".btn-print").prop('disabled', false);
            $(".btn-send").prop('disabled', false);

        },
        changeColor: function (e) {

            var tabTD = e.getElementsByTagName("td");
            var numberQuota = tabTD[1].innerText;
            var idCheck = "sel"+numberQuota;
            document.getElementById(idCheck).checked = true;
            document.getElementById("interesRate").value = tabTD[7].innerText;

        },
        get_ClientByRut: function() {
            Client.search();
        },
        search: function() {

            data = $("#form-client").serialize();
            var response = Teknodata.call_ajax("/advance/get_client", data, false, false, ".btn-success");

            if(response!=false){

              switch (response.retorno) {

                case 10:
                    Client.initConOferta(response);
                    $('.btn-simulate').click();
                    Client.processHide();
                break;

                case 11:
                    Alert.init();Alert.showSearch("",response.descRetorno);
                break;

                /* Cliente sin Oferta Vigente*/
                case 12:
                    Client.initSinOferta(response);
                    Alert.init();Alert.showWarning(response.descTitle,response.descRetorno);
                break;

                default:
                    Alert.showMessage("Preste Atención..!", "fa fa-warning", "orange", response.descRetorno);
                break;
                }

            }

          return (false);

        },
        initConOferta: function(response) {
            $("#label_nameClient").val(response.nameClient+" "+response.last_nameClient);
            $("#emailCuenta").val(response.email);
            $("#telefonoCuenta").val(response.phone);

            document.getElementById('amountSimulate').value = Teknodata.maskMoney(response.amountSimulate);
            document.getElementById('numberQuotas').value = response.numberQuotas;
            var o = document.getElementById('deferredQuotas');
            o.value = $(o).data('target');
        },
        initSinOferta: function(response) {
            $("#label_nameClient").val(response.nameClient+" "+response.last_nameClient);
            $("#emailCuenta").val(response.email);
            $("#telefonoCuenta").val(response.phone);

            var o = document.getElementById('amountSimulate');
            o.value = Teknodata.maskMoney(0);
            var o = document.getElementById('numberQuotas');
            o.value = $(o).data('target');
            var o = document.getElementById('deferredQuotas');
            o.value = $(o).data('target');

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
</script>


</body>
</html>
