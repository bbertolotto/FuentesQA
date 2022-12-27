<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head', '1'); ?>

<div id="page-content">

  <ul class="breadcrumb breadcrumb-top">
    <li><strong>Flujos comerciales</strong></li>
    <li><strong>Renegociar</strong></li>
    <li><strong>Cobranza</strong></li>
    <li><a href="/collection/search" onclick="Client.processShow();">Buscar</a></li>
    <li><strong>Crear</strong></li>
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
                    <input type="text" id="label_nameClient" name="label_nameClient" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" readonly >

                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-4">
                    <label for="number_phone">Dirección</label>
                    <input type="text" id="address" name="address" class="form-control text-center" readonly >
                </div>

      </fieldset>

      <fieldset>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control text-center minusculas" readonly >
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="number_phone">Teléfono</label>
                    <input type="text" id="number_phone" name="number_phone" class="form-control text-center" readonly >
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

      <form name="form-virtual" id="form-virtual" method="post" class="form-horizontal form-bordered form-control-borderless">

                <div class="form-group col-xs-4 col-sm-4 col-lg-4">&nbsp;</div>

                <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                    <label for="reasonSelector">Motivo<span class="text-danger">*</span></label>
                    <select id="reasonSelector" name="reasonSelector" class="form-control text-center" data-target="" >
                      <?php echo $environment["reasonSelector"]?>
                    </select>
                </div>

                <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                    <label for="dateEnd">Fecha Hasta</label>
                    <div class="input-group">
                      <input type="text" id="dateEnd" name="dateEnd" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="">
                      <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                  </div>
                </div>

      </form>


    </div>

    </fieldset>

  </div>

</div><!--End block-->

</div><!--End col-md-12-->

</div><!--End row-->


<!--Begin Botones de Control Formulario-->
<div class="form-group text-center">
  <button type="button" style="width:150px" class="btn-save btn btn-success" ><i class="fa fa-floppy-o"></i> Grabar </button>
  <button type="button" style="width:150px" class="btn-reset btn btn-success" ><i class="fa fa-ban"></i> Cancelar</button>
</div>
<!--End Botones de Control Formulario-->

</div><!--End col-md-12-->

</div><!--End row-->

<input type="hidden" id="id_office" value="<?= $this->session->userdata('id_office')?>">
<input type="hidden" id="id_user" value="<?= $this->session->userdata('id_user')?>">
<input type="hidden" id="nroTcv" value="<?= $this->session->userdata('nroTcv')?>">
<input type="hidden" id="nameClient">
<input type="hidden" id="lastnameClient">
<input type="hidden" id="days_over">
<input type="hidden" id="lblDireccion">
<input type="hidden" id="flg_flujo">
<input type="hidden" id="flg_type">


<input type="hidden" id="datajson">
<input type="hidden" id="htmlCupos">
<input type="hidden" id="htmlDetalle">
<input type="hidden" id="payment_type">
</div>
<!-- END Page Content -->

<?php $this->load->view('footer', '1'); ?>
<?php $this->load->view('ModalAlert', '1'); ?>
<?php $this->load->view('ModalCreate', '1'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/collection/Create.js"></script>
</body>
</html>
