<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>

<div id="page-content">

  <ul class="breadcrumb breadcrumb-top">
    <li><strong>Flujos comerciales</strong></li>
    <li><strong>Renegociar</strong></li>
    <li><a href="/renegotiation/search" onclick="Client.processShow();">Buscar</a></li>
    <li><a href="/renegotiation/negotiation" onclick="Client.processShow();">Negociaci&oacute;n</a></li>
    <li><strong>Script Cierre Negociaci&oacute;n</strong></li>
    <li><a href="/renegotiation/authorization" onclick="Client.processShow();">Autorizaci&oacute;n</a></li>
  </ul>

<div class="row">
  <div class="col-md-12">
    <div class="block">
      <div class="block-title">
          <h2><i class="fa fa-file-o"></i><strong>&nbsp;Cliente&nbsp;</strong><?php if(!$session_empty) echo $environment["nameClient"]." Nº Renegociaci&oacute;n ".$environment["number_authorizing"];?></h2>
          <div class="block-options pull-right">
              <h2>Modo:<strong>&nbsp;<?= $this->session->userdata('attention_mode');?></strong>&nbsp;</h2>
          </div>


      </div>

      <form name="form-client" id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">

        <div id="script">

          <?php if($viewhtml=="ready"):?>

              <?php if(!$session_empty) echo $html;?>


          <?php else:?>

              <table class="table table-sm table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center" width="3%"><strong>#</strong></th>
                  <th class="text-center" width="50%"><strong>Pregunta debe realizar Ejecutivo</strong></th>
                  <th class="text-center" width="40%"><strong>Respuesta Esperada Cliente</strong></th>
                  <th class="text-center" width="7%"><strong>Confirmación</strong></th>
                </tr>
              </thead>
              <tbody>

              <?php if(!$session_empty) echo $html;?>

              </tbody>
              </table>

          <?php endif;?>

        </div>

      </form>

    </div>

    <!--Begin Botones de Control Formulario-->
    <div class="form-group text-center">
      <?php if(!$session_empty):?>
          <?php if($viewhtml=="noready"):?>
              <button type="button" style="width:150px" class="btn-save btn btn-success" ><i class="fa fa-check"></i> Aceptar </button>
          <?php endif;?>
      <?php endif;?>
      <button type="button" style="width:150px" class="btn-return btn btn-success" ><i class="fa fa-repeat"></i> Volver</button>
    </div>
    <!--End Botones de Control Formulario-->

  </div>
</div>

<input type="hidden" id="attention_mode" value="<?= $this->session->userdata("attention_mode")?>">
<input type="hidden" id="authorizing" value="<?= $environment["number_authorizing"]?>">
<input type="hidden" id="id_client" value="<?= $environment["number_rut_client"]?>">

</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>


<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/renegotiation/Script.js"></script>

<?php if ($session_empty): ?>
<script language="javascript">
$("#body-modal-session").html("<p><strong><h4>Antes de Revisar un Script debe seleccionar un cliente....</br></br> Puede buscar utilizando número de RUT o Tarjeta</br></h4></strong></p>");
$('.modal-session').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>
</body>
</html>
