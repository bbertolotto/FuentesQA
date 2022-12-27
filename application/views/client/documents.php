<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">
    <ul class="breadcrumb breadcrumb-top">
        <li><strong>Centro de servicios</strong></li>
        <li><strong>Documentos Clientes</strong></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">

      <!-- Typeahead Block -->
      <div class="block">
          <!-- Typeahead Title -->
          <div class="block-title">
              <div class="block-options pull-right">
                  <h2>Modo: <strong><?= $this->session->userdata('attention_mode');?></strong></h2>
              </div>
              <h2><strong>Centro de Servicios Tarjeta Cruz Verde</strong> Documentos Cliente</h2>
          </div>
          <!-- END Typeahead Title -->

          <!-- Typeahead Content -->
          <form id="form-client" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
              <div class="form-group">
                  <label class="col-md-3 control-label" for="example-typeahead">N&#250;mero Rut Cliente</label>
                  <div class="col-md-4">
                      <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this)">
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-3 control-label" for="example-typeahead">Nombre Cliente</label>
                  <div class="col-md-4">
                      <input type="text" id="label_nameClient" name="label_nameClient" class="form-control" readonly></input>                  </div>
              </div>

              <div class="form-group form-actions">
                  <div class="col-md-9 col-md-offset-3">
                      <button type="button" class="btn-search btn btn-success"><i class="fa fa-search"></i> Buscar Documentos</button>
<?php if($this->session->userdata("selector")=="4.1.7"):?>
                      <button type="button" class="btn-deny btn btn-success" data-target="CRC"><i class="gi gi-print"></i> Carta Rechazo</button>
<?php endif;?>

                      <button type="reset" class="btn btn-warning" onclick="Client.prepare();"><i class="fa fa-repeat"></i> Limpiar</button>
                  </div>
              </div>
          </form>
          <!-- END Typeahead Content -->
      </div>
      <!-- END Typeahead Block -->
    </div>

    <form id="form-valid" method="post">

    </form>


    <div class="row" id="client-details" style="display:block;" >

      <div class="block">
          <div class="block-title">
              <h2><strong>Cliente </strong><span id="nombrecliente"></span> <strong>Detalle Historico Documentos</strong></h2>
          </div>
          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                        <th class="text-left">Documento</th>
                        <th class="text-center">Fecha Creaci&#243;n</th>
                        <th class="text-center">Usuario Creaci&#243;n</th>
                        <th class="text-center">Sucursal Creaci&#243;n</th>
                        <th class="text-center">Fecha &#218;ltima Revisi&#243;n</th>
                        <th class="text-center">Usuario &#218;ltima Revisi&#243;n</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center" width="50px">Revisar</th>
                        <th class="text-center" width="50px">Adjuntos</th>
                        <th class="text-center">Nº Documento</th>
                      </tr>
                  </thead>
                  <tbody>
                </table>
      </div>
  </div>
    <!--END row-->
</div>
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalValid'); ?>

<!-- End page-content-->

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/client/Documents.js"></script>
</body>
</html>
