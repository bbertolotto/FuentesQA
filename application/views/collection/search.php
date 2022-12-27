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
      <li><strong>Cobranza</strong></li>
      <li>Buscar</li>
      <li><a href="/collection/create" onclick="Client.processShow();">Create</a></li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong><?= $this->lang->line('Collection');?></strong></h2>
                      <i class="fa fa-angle-right"></i> Seleccione atributos para busqueda
                </div>
                <form id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">

                  <fieldset>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">&nbsp;</div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="masked_rut_client">N&#250;mero RUT Cliente</label>
                        <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center col-sm-12" onchange="Teknodata.masked_nroRut(this);" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this);">
                    </div>

                    <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                        <label for="reasonSelector">Motivo<span class="text-danger">*</span></label>
                        <select id="reasonSelector" name="reasonSelector" class="form-control text-center" data-target="" >
                          <?php echo $environment["reasonSelector"]?>
                        </select>
                    </div>

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

                  </fieldset>

                    <fieldset>

                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                      <button type="button" class="btn btn-warning" onclick="Client.clearInput();"><i class="gi gi-refresh"></i> Limpiar</button>
<?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COBRANZA):?>
                      <button type="button" class="btn btn-danger" onclick="Client.createRenegotiation();"><i class="gi gi-circle_plus"></i> Crear Cobranza</button>
<?php endif;?>
                    </div>
                  </fieldset>

                </form>

            </div>
        </div>
        <!--End col-md-6-->
    </div>

    <div class="row" id="client-details" >

      <div class="block">
          <div class="block-title">
              <h2><strong>Detalle</strong><span id="nombrecliente"></span> <strong> Clientes con Mora Virtual</strong></h2>
          </div>

          <table id="tabCollection" class="table table-striped table-bordered" style="width:100%">
          </table>

      </div>
    </div>

    <!--END row-->


</div>
<!-- End page-content-->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/collection/Search.js"></script>
</body>
</html>
