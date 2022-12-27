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
    <li><strong>Negociaci&oacute;n</strong></li>
    <li><a href="/renegotiation/script" onclick="Client.processShow();">Script Cierre Negociaci&oacute;n</a></li>
    <li><a href="/renegotiation/authorization" onclick="Client.processShow();">Autorizaci&oacute;n</a></li>
  </ul>

<div class="row">
  <div class="col-md-12">
    <div class="block">
      <div class="block-title">
          <div class="block-options pull-right">
              <h2>Modo:<strong>&nbsp;<?= $this->session->userdata('attention_mode');?></strong>&nbsp;</h2>
          </div>
          <h2><i class="fa fa-file-o"></i><strong>&nbsp;Identificaci&#243;n</strong> del Cliente</h2>
      </div>

      <form name="form-client" id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">


      <fieldset>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="rutClient">Nº de Rut</label>
                    <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center" value="<?php if(!$session_empty) echo $dataClient["masked_rut_client"];?>"
                    readonly></input>
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="number_phone">N° Tarjeta</label>
                    <input type="text" id="number_pan" name="number_pan" class="form-control text-center" readonly value="<?php if(!$session_empty) echo $nroTcv;?>">
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-3">
                    <label for="example-nf-name">Cliente</label>
                    <input type="text" id="label_nameClient" name="label_nameClient" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" readonly value="<?php if(!$session_empty) echo $dataClient["name_client"];?>" >

                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-4">
                    <label for="number_phone">Dirección</label>
                    <input type="text" id="address" name="address" class="form-control text-center" readonly value="<?php if(!$session_empty) echo $lblDireccion;?>">
                </div>

      </fieldset>

      <fieldset>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control text-center minusculas" readonly value="<?php if(!$session_empty) echo $email;?>">
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="phoneClient">Teléfono</label>
                    <input type="text" id="phoneClient" name="phoneClient" class="form-control text-center" readonly value="<?php if(!$session_empty) echo $phone;?>">
                </div>

                <div class="form-group col-xs-2 col-sm-2 col-lg-2">
                    <label for="amount">Monto a Renegociar</label>
                    <input type="text" id="amount" name="amount" readonly  class="form-control text-center" >
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
    <h2><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;<strong>Situación</strong> del Cliente</h2>

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

            <?php if(!$session_empty) echo $dataAccount;?>

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

            <?php if(!$session_empty) echo $dataPayment;?>

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

            <?php if(!$session_empty) echo $dataSecure;?>

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

      <?php if(!$session_empty):?>

        <?php if($payment_type=="NORMAL"):?>

          <label class="switch switch-success checkbox-inline"><input id="formPay" name="formPay" type="checkbox" checked disabled><span></span><h2>
          <label id="lblformPay"><strong>Pago Normal</strong></label></h2></label>

        <?php else:?>

          <label class="switch switch-success checkbox-inline"><input id="formPay" name="formPay" type="checkbox" disabled><span></span><h2>
          <label id="lblformPay"><strong>Pago Diferido</strong></label></h2></label>

        <?php endif;?>

      <?php endif;?>

    </h2>

    <div class="block-options pull-right">
        <a href="#formpay" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
    </div>

  </div>

  <div class="collapse" id="formpay">

    <fieldset>

        <?php if(!$session_empty):?>

          <?php if($payment_type=="NORMAL"):?>

            <fieldset>
            <div class="form-group col-xs-4 col-sm-4 col-lg-2">&nbsp;</div>
            <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                <label for="numberQuotesNormal">Número de Cuotas<span class="text-danger">*</span></label>
                <input type="text" id="numberQuotesNormal" name="numberQuotesNormal" readonly class="form-control text-center" value="<?php echo $number_quotes?>">
            </div>
            <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                <label for="dateEndNormal">Primer Vencimiento<span class="text-danger">*</span></label>
                <input type="text" id="dateEndNormal" name="dateEndNormal" class="form-control text-center" readonly value="<?php echo $first_date_expires_quotes?>" >
            </div>
            <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                <label for="amountSecureNormal">Seguro Desgravamen<span class="text-danger">*</span></label>
                <input type="text" id="amountSecureNormal" name="amountSecureNormal" readonly class="form-control text-center" value="<?php echo $amount_quotes_secure?>">
            </div>
            </fieldset>

          <?php else:?>

            <fieldset>
            <div class="form-group col-xs-4 col-sm-4 col-lg-2">&nbsp;</div>

            <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                <label for="numberDeferredDifer">Diferido<span class="text-danger">*</span></label>
                <input type="text" id="numberDeferredDifer" name="numberDeferredDifer" readonly class="form-control text-center" value="<?php echo $deferred_quotes?>">
            </div>

            <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                <label for="dateEndDifer">Primer Vencimiento<span class="text-danger">*</span></label>
                <input type="text" id="dateEndDifer" name="dateEndDifer" readonly class="form-control text-center" value="<?php echo $first_date_expires_quotes?>" >
            </div>

            <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                <label for="numberQuotesDifer">Número de Cuotas<span class="text-danger">*</span></label>
                <input type="text" id="numberQuotesDifer" name="numberQuotesDifer" readonly class="form-control text-center" value="<?php echo $number_quotes?>">
            </div>

            <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                <label for="amountSecureDifer">Seguro Desgravamen<span class="text-danger">*</span></label>
                <input type="text" id="amountSecureDifer" name="amountSecureDifer" readonly class="form-control text-center" value="<?php echo $amount_quotes_secure?>">
            </div>
            </fieldset>

          <?php endif;?>

        <?php endif;?>

    </fieldset>

    <fieldset>
    <div class="form-group col-xs-4 col-sm-4 col-lg-2">&nbsp;</div>
    <div class="form-group col-xs-8 col-sm-8 col-lg-8">

        <table class="table table-sm table-striped table-bordered" style="width:100%">

          <?php if(!$session_empty) echo $tabSimulate?>

        </table>

    </div>
    </fieldset>


  </div>

</div><!--End block-->



<div class="block">

  <div class="block-title">

    <h2><i class="fa fa-history"></i>&nbsp;<strong>Historial</strong> de Acciones</h2>

    <div class="block-options pull-right">
        <a href="#histpay" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
    </div>

  </div>

  <div class="collapse" id="histpay">

    <fieldset>
    <div class="form-group col-xs-4 col-sm-4 col-lg-2">&nbsp;</div>
    <div class="form-group col-xs-8 col-sm-8 col-lg-8">
      <table class="table table-sm table-striped table-bordered" style="width:100%" id="tabhistpay">
          <thead>
            <tr>
              <th class="text-center">Acci&#243;n</th>
              <th class="text-center">Usuario</th>
              <th class="text-center">Fecha</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td scope="col" class="text-center"><?=$ca_status?></td>
                <td scope="col" class="text-center"><?=$ca_username?></td>
                <td scope="col" class="text-center"><?=$ca_date?></td>
              </tr>
              <tr>
                <td scope="col" class="text-center"><?=$co_status?></td>
                <td scope="col" class="text-center"><?=$co_username?></td>
                <td scope="col" class="text-center"><?=$co_date?></td>
              </tr>
              <tr>
                <td scope="col" class="text-center"><?=$ex_status?></td>
                <td scope="col" class="text-center"><?=$ex_username?></td>
                <td scope="col" class="text-center"><?=$ex_date?></td>
              </tr>
              <tr>
                <td scope="col" class="text-center"><?=$au_status?></td>
                <td scope="col" class="text-center"><?=$au_username?></td>
                <td scope="col" class="text-center"><?=$au_date?></td>
              </tr>
          </tbody>
      </table>
    </div>
    </fieldset>


  </div>

</div><!--End block-->

<!--Begin Botones de Control Formulario-->
<div class="form-group text-center">
  <button type="button" style="width:150px" class="btn-return btn btn-success" ><i class="fa fa-repeat"></i> Volver</button>
</div>
<!--End Botones de Control Formulario-->

</div><!--End col-md-12-->

</div><!--End row-->

<input type="hidden" id="attention_mode" value="<?= $this->session->userdata('attention_mode')?>">
<input type="hidden" id="htmlCupos" value='<?php if(!$session_empty) echo $htmlCupos;?>'>
<input type="hidden" id="htmlDetalle" value="<?php if(!$session_empty) echo $htmlDetalle;?>">

</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/renegotiation/AuditNegotiation.js"></script>
</body>
</html>
