<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js">
<!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
      <li><strong>Flujos comerciales</strong></li>
      <li><strong>Renegociar</strong></li>
      <li>Buscar</li>
      <li><a href="/renegotiation/negotiation" onclick="Client.processShow();">Negociaci&oacute;n</a></li>
      <li><a href="/renegotiation/script" onclick="Client.processShow();">Script Cierre Negociaci&oacute;n</a></li>
      <li><a href="/renegotiation/authorization" onclick="Client.processShow();">Autorizaci&oacute;n</a></li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong><?= $this->lang->line('Renegotiate');?></strong></h2>
                      <i class="fa fa-angle-right"></i> Seleccione atributos para busqueda
                </div>
                <form id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">

                  <fieldset>

<?php if($this->session->userdata("id_rol")!=USER_ROL_SUPERVISOR_CALIDAD and $this->session->userdata("id_rol")!=USER_ROL_SUPERVISOR_EXCEPCIONES):?>
                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">&nbsp;</div>
<?php endif;?>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="masked_rut_client">N&#250;mero RUT Cliente</label>
                        <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center col-sm-12" onchange="Teknodata.masked_nroRut(this);" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this);">
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                          <label for="status">Estado Renegociación</label>
                          <select id="status" name="status" class="form-control text-center" >
                              <?php
                                foreach ($status as $nodo) {
                                    echo '<option value="'.$nodo->ST.'">'.$nodo->NAME.'</option>';
                                }
                                ?>
                            </select>
                    </div>
<?php if($this->session->userdata("id_rol")==USER_ROL_SUPERVISOR_CALIDAD or $this->session->userdata("id_rol")==USER_ROL_SUPERVISOR_EXCEPCIONES):?>
                    <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                          <label for="username">Usuario Creador</label>
                          <input type="text" id="username" name="username" maxlength="50" class="form-control text-center col-sm-12" >
                    </div>
<?php else:?>
                    <input type="hidden" name="username" id="username" value="">
<?php endif;?>
                    <input type="hidden" id="id_rol" value="<?=$this->session->userdata("id_rol")?>">
                    <input type="hidden" id="id_upd" value="">

                    <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                        <label for="dateBegin">Fecha Desde</label>
                        <div class="input-group">
                          <input type="text" id="dateBegin" name="dateBegin" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?= $environment['dateBegin']?>">
                          <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                      </div>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                        <label for="dateEnd">Fecha Hasta</label>
                        <div class="input-group">
                          <input type="text" id="dateEnd" name="dateEnd" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?= $environment['dateEnd']?>">
                          <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                      </div>
                    </div>

                    <input type="hidden" name="number_phone" id="number_phone" value="">

                  </fieldset>

                    <fieldset>

                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                      <button type="button" class="btn btn-warning" onclick="Client.clearInput();"><i class="gi gi-refresh"></i> Limpiar</button>
                      <button type="button" class="btn btn-danger" onclick="Client.createRenegotiation();"><i class="gi gi-circle_plus"></i> Crear Renegociaci&oacute;n</button>
                    </div>
                  </fieldset>

                </form>

            </div>
        </div>
        <!--End col-md-6-->
    </div>

    <div class="row" id="client-details" >

      <div class="col-md-12">
      <div class="block">
          <div class="block-title">
              <h2><strong>Detalle</strong><span id="nombrecliente"></span> <strong> Renegociaciones en Proceso</strong></h2>
          </div>

          <table id="tabRenegotiation" class="table table-striped table-bordered" style="width:100%">
          </table>

      </div>
      </div>

    </div>

    <!--END row-->
<input type="hidden" id="idRefinanciamiento" name="idRefinanciamiento">
</div>
<!-- End page-content-->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/renegotiation/Search.js"></script>
<script language="javascript">

$(".btn-modal-request").on("click", function () {

    if($("#id_upd").val()=="denyscript"){

        if($(this).data('target')=="accept") {

            var formData = new FormData();
            formData.append("id", $("#idRefinanciamiento").val());
            formData.append("reasonDeny", $("#reasonDeny").val());
            var response = Teknodata.call_ajax("/renegotiation/denyScriptRenegotiation", formData, false, true, ".btn-script");
            if(response){
                Alert.showAlert(response.descRetorno);
                if(response.retorno==0){ $(".btn-success").click(); }
            }
        }
    }

});

var Script = function() {
    return {

        accept: function($id) {

          var formData = new FormData();
          formData.append("id", $id);
          var response = Teknodata.call_ajax("/renegotiation/passScriptRenegotiation", formData, false, true, ".btn-script");
          if(response){
              Alert.showAlert(response.descRetorno);
              if(response.retorno==0){ $(".btn-success").click(); }
          }

        },
        cancel: function($id) {

          $(".close").click();
          $("#idRefinanciamiento").val($id);
          $("#id_upd").val("denyscript");
          $htmlDeny = '<fieldset><center>';
          $htmlDeny+= '<h4><strong>Rechazar Script para Renegociación N°'+$id+'</strong></h4></br>';
          $htmlDeny+= '<label for="status">Motivo Rechazo</label>';
          $htmlDeny+= '<select id="reasonDeny" name="reasonDeny" class="form-control text-center" style="width:300px;">';
          $htmlDeny+= '    <option value="No cumplimiento de script">No cumplimiento de script</option>';
          $htmlDeny+= '    <option value="Audio con problemas">Audio con problemas</option>';
          $htmlDeny+= '    <option value="No Cumple Abono">No Cumple Abono</option>';
          $htmlDeny+= '</select></fieldset></center></br>';
          Alert.showRequest($htmlDeny,"");

        }

    };
}();

</script>
</body>
</html>
