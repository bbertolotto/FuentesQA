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
      <li><a href="/renegotiation/script" onclick="Client.processShow();">Script Cierre Negociaci&oacute;n</a></li>
      <li><strong>Autorizaci&oacute;n</strong></li>
    </ul>

<div class="row">
  <div class="col-md-12">
    <div class="block">
      <div class="block-title">
          <h2><i class="fa fa-file-o"></i><strong>&nbsp;Cliente&nbsp;</strong><?php if(!$session_empty) echo $dataClient["name_client"]." Nº Renegociaci&oacute;n ".$dataClient["number_authorizing"];?></h2>
          <div class="block-options pull-right">
              <h2>Modo:<strong>&nbsp;<?= $this->session->userdata('attention_mode');?></strong>&nbsp;</h2>
          </div>
      </div>

      <table class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th class="text-left" width="50%"><strong>Número de Renegociación</strong></th>
          <th class="text-left" width="50%"><strong><?php if(!$session_empty) echo $number_approval;?></strong></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-left" width="50%"><strong>Monto a Renegociar</strong></td>
          <td class="text-left" width="50%"><strong><?php if(!$session_empty) echo $amount;?></strong></td>
        </tr>
        <tr>
          <td class="text-left" width="50%"><strong>Valor Cuota</strong></td>
          <td class="text-left" width="50%"><strong><?php if(!$session_empty) echo $amount_quotes_value;?></strong></td>
        </tr>
        <tr>
          <td class="text-left" width="50%"><strong>Número de Cuotas</strong></td>
          <td class="text-left" width="50%"><strong><?php if(!$session_empty) echo $number_quotes;?></strong></td>
        </tr>
        <tr>
          <td class="text-left" width="50%"><strong>Meses Diferidos</strong></td>
          <td class="text-left" width="50%"><strong><?php if(!$session_empty) echo $deferred_quotes;?></strong></td>
        </tr>
        <tr>
          <td class="text-left" width="50%"><strong>Fecha Vencimiento</strong></td>
          <td class="text-left" width="50%"><strong><?php if(!$session_empty) echo substr($first_date_expires_quotes,8,2)."-".substr($first_date_expires_quotes,5,2)."-".substr($first_date_expires_quotes,0,4);?></strong></td>
        </tr>
        <tr>
          <td class="text-left" width="50%"><strong>Mensaje</strong></td>
          <td class="text-left" width="50%"><strong><?php if(!$session_empty) echo $message;?></strong></td>
        </tr>

      </tbody>
      </table>

    </div>

    <!--Begin Botones de Control Formulario-->
    <div class="form-group text-center">
      <button type="button" style="width:150px" class="btn-return btn btn-success" ><i class="fa fa-repeat"></i> Volver</button>
    </div>
    <!--End Botones de Control Formulario-->

  </div>
</div>

<input type="hidden" id="attention_mode" value="<?= $this->session->userdata("attention_mode")?>">
<input type="hidden" id="datajson">
<input type="hidden" id="authorizing" value="<?= $number_authorizing?>">
<input type="hidden" id="number_rut_client" value="<?= $number_rut_client?>">
</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/renegotiation/Authorization.js"></script>
<?php if ($session_empty): ?>
<script language="javascript">
var message = "<strong><h4><?php echo $descRetorno;?></h4></strong>";
$("#body-modal-alert").html(message);
$('.modal-alert').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>
</body>
</html>
