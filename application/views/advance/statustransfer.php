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
              <h2><strong>Centro de Servicios Tarjeta Cruz Verde</strong> Revisar Estado Transferencia por Súper Avances</h2>
          </div>
          <!-- END Typeahead Title -->

          <form name="form-client" id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="rutClient">Nº de Rut</label>
                        <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center" placeholder=""
                        onkeypress="return Teknodata.enter_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this)" data-target="" data-toggle="tooltip" data-placement="top" title="Digite Número Rut y Presione Enter para buscar .."></input>
                    </div>
                    <div class="form-group col-xs-6 col-sm-4 col-lg-3">
                        <label for="example-nf-name">Cliente</label>
                        <input type="text" id="label_nameClient" name="label_nameClient" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" readonly >

                    </div>
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <div class="input-group">
                            <button type="reset" class="btn-reset btn btn-warning" ><i class="fa fa-repeat"></i> Limpiar</button>
                        </div>
                    </div>
          </form>
          <!-- END Typeahead Content -->
      </div>
      <!-- END Typeahead Block -->
    </div>

    <form id="form-valid" method="post">

    </form>


    <div class="row" id="client-details" >

      <div class="block">
          <div class="block-title">
              <h2><strong>Detalle Estado Transferencia</strong></h2>
          </div>

          <div id="dataTransfer">

          </div>

      </div>
  </div>
    <!--END row-->
</div>
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<!-- End page-content-->

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/advance/Statustransfer.js"></script>
</body>
</html>
