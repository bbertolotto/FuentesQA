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
      <li>Liquidaci&#243;n</li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
      <div class="col-md-12">
          <div class="block">
              <div class="block-title">
                  <div class="block-options pull-right">
                      <h2>Modo: <strong><?= $this->session->userdata('attention_mode');?></strong></h2>
                  </div>
                  <h2>Confirmaci&#243;n Operaci&#243;n S&uacute;per Avance Cliente <strong><?= $dataCliente["nombreCliente"] ?></strong></h2>
              </div>
            </br>

            <form id="form-valid" method="post" class="form-horizontal form-bordered form-control-borderless">

              <div class="col-sm-12 col-lg-12">
              <div class="block">
                  <div class="block-title">
                      <h2><i class="fa fa-check"></i> Aceptaci&oacute;n de las condiciones</h2>
                  </div>
                  <?php echo $dataScript?>

              </div>
              </div>

        <div class="form-group text-center">
            <div class="col-xs-12">
                <button type="button" class="btn-cancel btn btn-danger btn-md" data-target="cancel" ><i class="gi gi-exit"></i> Salir</button>
            </div>
        </div>

          </div>

        </div>
        </form>
    </div>
    <!--End Block principal-->

<input type="hidden" id="idDocument" value="<?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : 0); ?>">
<input type="hidden" id="nroRut" value="<?php echo (isset($dataRequest['nroRut']) ? $dataRequest['nroRut']."-".$dataRequest['dgvRut'] : 0); ?>">
<input type="hidden" id="formaDePago" value="<?php echo (isset($dataRequest['glosaModoEntrega']) ? $dataRequest['glosaModoEntrega'] : "-"); ?>">
<input type="hidden" id="tasaMaxima" value="<?= $dataRequest['tasaMaxima']?>">
<input type="hidden" id="tasaRequest" value="<?= $dataRequest['tasaRequest']?>">
<input type="hidden" id="dataScript" value='<?= $dataScript ?>'>
</div>

<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>
<?php $this->load->view('ModalValid'); ?>
<?php $this->load->view('/advance/ModalTransfer'); ?>
<!-- Javascript exclusivos para esta página -->

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/advance/Valid.js"></script>
<script src="/js/vendor/jquery.cookie.js"></script>
</body>
</html>
