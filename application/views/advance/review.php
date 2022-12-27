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
  <li>Creaci&#243;n</a></li>
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

                <div class="form-group col-xs-12 col-sm-6 col-lg-2">
                    <label for="rutClient">Nº de Rut</label>
                    <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center" onfocus="return Teknodata.enter_onlyRut(event);" placeholder="" readonly data-target="" data-toggle="tooltip" data-placement="top" title="Digite Número Rut y Presione Enter para buscar .."></input>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-lg-3">
                    <label for="example-nf-name">Cliente</label>
                    <input type="text" id="label_nameClient" name="label_nameClient" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" readonly >

                </div>
                <div class="form-group col-xs-12 col-sm-6 col-lg-2">
                    <label for="emailClient">Email</label>
                    <input type="text" id="emailClient" name="emailClient" class="form-control text-center minusculas" readonly >
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-lg-2">
                    <label for="phoneClient">Teléfono Móvil</label>
                    <input type="text" id="phoneClient" name="phoneClient" class="form-control text-center" readonly >
                </div>
                <div class="form-group">
                    <label for="">&nbsp;</label>
                    <div class="input-group">
                        <button type="reset" class="btn-reset btn btn-warning" ><i class="fa fa-repeat"></i> Limpiar</button>
                    </div>
                </div>
      </form>
    </div>
  </div>
</div>

<div class="row">

<div class="col-md-12">

<div class="block">

  <div class="block-title">

    <div class="block-options pull-right">
        <a href="#negotiation" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
    </div>
    <h2><i class="fa fa-building-o"></i>&nbsp;<strong>Negociaci&#243;n</strong> con Cliente</h2>
  </div>

  <div class="collapse" id="negotiation">

  <form name="form-negotiation" id="form-negotiation" method="post" class="form-horizontal form-bordered form-control-borderless">

  <fieldset>

        <div id="offerSelector"></div>

  </fieldset>

  <fieldset>

    <input type="hidden" id="offerType" name="offerType" >
    <input type="hidden" id="offerAmount" name="offerAmount" >

    <div class="form-group col-xs-12 col-sm-6 col-lg-2">
        <label id="lblTipoOferta" for="offerRequest">Solicitado <span class="text-danger">*</span></label>
        <input type="text" id="offerRequest" name="offerRequest" onkeyup="Teknodata.formatMoneda(this);" onchange="Teknodata.formatMoneda(this);" class="form-control text-center" maxlength="11" >
    </div>

    <div class="form-group col-xs-12 col-sm-6 col-lg-2">
        <label>&nbsp;&nbsp;Nº Cuotas <span class="text-danger">*</span></label>
        <select id="numberQuotas" name="numberQuotas" class="form-control text-center" data-target="<?=$dataLoad['maxNumberQuotas']?>" >
          <?php
          for ($i = $dataLoad['minNumberQuotas']; $i <= $dataLoad['maxNumberQuotas']; $i++) {
              echo "<option value='".$i."'>".$i."</option>";
          }
          ?>
        </select>
    </div>

    <div class="form-group col-xs-12 col-sm-6 col-lg-2">
        <label>&nbsp;&nbsp;Nº Diferidos <span class="text-danger">*</span></label>
        <select id="deferredQuotas" name="deferredQuotas" class="form-control text-center" data-target="<?=$dataLoad['minDeferredQuotas']?>" >
            <?php
            for ($i = $dataLoad['minDeferredQuotas']; $i <= $dataLoad['maxDeferredQuotas']; $i++) {
                echo "<option value='".$i."'>".$i."</option>";
            }
            ?>
          </select>
    </div>

    <div class="form-group col-xs-12 col-sm-6 col-lg-2">
        <label>&nbsp;&nbsp;Tasa</label>
        <input type="text" id="interesRate" name="interesRate" class="form-control text-center" value="<?=$dataLoad['interesRate']?>" readonly >
    </div>

    <div class="form-group col-xs-12 col-sm-6 col-lg-2">
        <label>&nbsp;&nbsp;Vencimiento</label>
        <input type="text" id="dateFirstExpiration" name="dateFirstExpiration" value="<?=$dataLoad['dateFirstExpiration']?>" class="form-control text-center" readonly >
    </div>

    <div class="form-group col-xs-12 col-sm-6 col-lg-2">
        <label for="">&nbsp;</label>
        <div class="input-group">
            <button type="submit" class="btn-simulate btn btn-danger"><i class="gi gi-calculator"></i> Simular </button>
        </div>
    </div>

  </fieldset>

  <fieldset>

    <div class="col-md-6">
      <div class="block">
        <div class="block-title">

          <label class="switch switch-success checkbox-inline">
            <input id="<?= $secureOne['htmlName']?>" name="success" type="checkbox" value="<?= $secureOne['htmlValue']?>" onclick="Client.checkSecure(this);" data-cod="<?= $secureOne['codSecure']?>" data-pol="<?= $secureOne['idPoliza']?>" data-target="<?= $secureOne['htmlModal'] ?>" data-script="<?= $secureOne['htmlScript'] ?>" checked><span></span>
            <h2><strong><?= $secureOne['htmlDescrip']?>&nbsp;<label id="labelsecureOne">[ACEPTADO]</label></strong></h2>
          </label>

          <div class="block-options pull-right">
              <div class="btn-group btn-group-sm">
                  <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default dropdown-toggle enable-tooltip" data-toggle="dropdown" title="Opciones"><span class="caret"></span></a>
                  <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                      <li>
                          <a href="javascript:Client.showScriptSecure('secureOne');"><i class="fa fa-check-square-o pull-right"></i>Revisar Coberturas</a>
                      </li>
                  </ul>
              </div>

              <a href="#secure1" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
          </div>

        </div>

        <div class="collapse" id="secure1">

          <div class="form-group">
            <medium>Autorizo que toda comunicaci&#243;n y notificaci&#243;n que tenga realaci&#243;n con el presente seguro me sea enviado al correo electr&#243;nico se&#241;alado en esta solicitud de incorporaci&#243;n</medium>
            <ul class="fa-ul list-li-push">
                <li>
                  <label class="checkbox-inline"><input type="checkbox" id="yesEmailSecureOne" checked disabled> Sí</label>
                  <label class="checkbox-inline"><input type="checkbox" id="noEmailSecureOne"  disabled> No</label>
                </li>
            </ul>

            <?php if($this->session->userdata('id_rol')==4):?>
                      <medium>Se le ha diagnosticado, se encuentra en estudio por un hallazgo médico, se encuentra en tratamiento o tiene conocimiento de padecer o haber padecido: Diabetes Mellitus tipo 1 o 2, Cáncer en todos sus estados (incluye leucemia, linfomas y melanoma maligno), Enfermedades cardiacas, by-pass coronario, enfermedades a las coronarias, soplos cardiacos, arritmias, Insuficiencia renal aguda y/o crónica , Obesidad (Índice de masa corporal superior a 30%), Enfermedades neurológicas: accidente vascular cerebral, esclerosis múltiple, aneurismas, Trasplantado de corazón, pulmón, riñón, hígado, páncreas y médula ósea, Enfermedades respiratorias : Enfermedad pulmonar obstructiva crónicas (EPOC), fibrosis quística, bronquitis obstructiva crónica, asma, secuelas de COVID-19; Enfermedades gástricas: Daño hepático crónico, hepatitis (B o C), Cirrosis hepática.</medium>
            <?php else:?>
                      <medium>Se le ha diagnosticado, se encuentra en estudio por un hallazgo médico, se encuentra en tratamiento o tiene conocimiento de padecer o haber padecido: Diabetes Mellitus tipo 1 o 2, Cáncer en todos sus estados (incluye leucemia, linfomas y melanoma maligno), Enfermedades cardiacas, by-pass coronario, enfermedades a las coronarias, soplos cardiacos, arritmias, Insuficiencia renal aguda y/o crónica , Obesidad (Índice de masa corporal superior a 30%), Enfermedades neurológicas: accidente vascular cerebral, esclerosis múltiple, aneurismas, Trasplantado de corazón, pulmón, riñón, hígado, páncreas y médula ósea, Enfermedades respiratorias : Enfermedad pulmonar obstructiva crónicas (EPOC), fibrosis quística, bronquitis obstructiva crónica, asma, secuelas de COVID-19; Enfermedades gástricas: Daño hepático crónico, hepatitis (B o C), Cirrosis hepática.</medium>
            <?php endif;?>
                      <ul class="fa-ul list-li-push">
                          <li>
                            <label class="radio-inline" for="example-inline-radio1">
                                <input type="radio" id="yesdps-1-secure-one" disabled> Sí
                            </label>
                            <label class="radio-inline" for="example-inline-radio2">
                                <input type="radio" id="nodps-1-secure-one" checked disabled> No
                            </label>
                          </li>
                      </ul>
            <?php if($this->session->userdata('id_rol')==4):?>
                    <medium>Usted ha sido dictaminado o se le ha otorgado o se encuentra tramitando su Invalidez por alguna Comisión Médica (AFP/Compin/Mutuales/Capredena) a causa de una enfermedad o accidente.</medium>
            <?php else:?>
                    <medium>Usted ha sido dictaminado o se le ha otorgado o se encuentra tramitando su Invalidez por alguna Comisión Médica (AFP/Compin/Mutuales/Capredena) a causa de una enfermedad o accidente.</medium>
            <?php endif;?>
                    <ul class="fa-ul list-li-push">
                        <li>
                          <label class="radio-inline" for="example-inline-radio1">
                              <input type="radio" id="yesdps-2-secure-one" disabled> Sí
                          </label>
                          <label class="radio-inline" for="example-inline-radio2">
                              <input type="radio" id="nodps-2-secure-one" checked disabled> No
                          </label>
                        </li>
                    </ul>

            <?php if($this->session->userdata('id_rol')==4):?>
                    <medium>¿Hace uso de moto de cilindrada mayor a 250 cc?. ¿Es piloto de o pasajero de vuelos no regulares?</medium>
            <?php else:?>
                    <medium>¿Hace uso de moto de cilindrada mayor a 250 cc?. ¿Es piloto de o pasajero de vuelos no regulares?</medium>
            <?php endif;?>
                  <ul class="fa-ul list-li-push">
                      <li>
                        <label class="radio-inline" for="example-inline-radio1">
                            <input type="radio" id="yesdps-3-secure-one" disabled> Sí
                        </label>
                        <label class="radio-inline" for="example-inline-radio2">
                            <input type="radio" id="nodps-3-secure-one" checked disabled> No
                        </label>
                      </li>
                  </ul>

          </div>
        </div>

      </div>

    </div><!--End col-md-6-->

    <!--Begin Secure Two-->
    <div class="col-md-6">
      <div class="block">
        <div class="block-title">
          <!-- Interactive block controls (initialized in js/app.js -> interactiveBlocks()) -->
          <label class="switch switch-success checkbox-inline"><input id="<?= $secureTwo['htmlName']?>" name="success" type="checkbox" value="<?= $secureTwo['htmlValue']?>" onclick="Client.checkSecure(this);" data-cod="<?= $secureTwo['codSecure']?>" data-pol="<?= $secureTwo['idPoliza']?>" data-target="<?= $secureTwo['htmlModal'] ?>" data-script="<?= $secureTwo['htmlScript'] ?>" checked><span></span>
            <h2><strong><?= $secureTwo['htmlDescrip']?>&nbsp;<label id="labelsecureTwo">[ACEPTADO]</label></strong></h2>
          </label>

          <div class="block-options pull-right">
              <div class="btn-group btn-group-sm">
                  <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default dropdown-toggle enable-tooltip" data-toggle="dropdown" title="Opciones"><span class="caret"></span></a>
                  <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                      <li>
                          <a href="javascript:Client.showScriptSecure('secureTwo');"><i class="fa fa-check-square-o pull-right"></i>Revisar Coberturas</a>
                      </li>
                  </ul>
              </div>

              <a id="sel_secure_2" href="#secure2" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
          </div>

        </div>

        <div class="collapse" id="secure2">

          <p>Autorizo que toda comunicaci&#243;n y notificaci&#243;n que tenga realaci&#243;n con el presente seguro me sea enviado al correo electr&#243;nico se&#241;alado en esta solicitud de incorporaci&#243;n</p>
          <ul class="fa-ul list-li-push">
              <li>
                  <label class="checkbox-inline"><input type="checkbox" id="yesEmailSecureTwo" checked disabled> Sí</label>
                  <label class="checkbox-inline"><input type="checkbox" id="noEmailSecureTwo" disabled> No</label>
              </li>
          </ul>
        </div>

      </div>
    </div><!--End col-md-6-->

  </fieldset>

  <fieldset>

    <div class="col-md-12">
      <div class="block">
        <div class="block-title"><h2><strong>Detalle Ofertas</strong></h2>
          <div class="block-options pull-right">
              <a href="#simulate" class="btn btn-alt btn-sm btn-primary" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
          </div>
        </div>

        <div class="multi-collapse table-responsive" id="simulate">
          <div class="table-responsive">

            <table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
            </table>
          </div>
        </div>
    </div>

  </fieldset>

  </form>

  </div>
  <!--End collapse-->

</div>
<!--End Block-->
</div>
<!--End col-md-12-->
</div>
<!--End row-->


<div class="row">

</div>

<div class="row">
  <div class="col-md-12">
    <div class="block">

  <div class="block-title">

    <h2><i class="fa fa-thumbs-o-up"></i>&nbsp;<strong>Negociación</strong> Modalidad de Pago&nbsp;&nbsp;
          <label class="switch switch-success checkbox-inline"><input id="formPay" name="formPay" type="checkbox" onclick="Client.formPay(this);"><span></span><h2>
          <label id="lblformPay"><strong>Efectivo</strong></label></h2></label>
    </h2>

  </div>

        <div class="collapse" id="payment">
            <table class="table">
              <div id="transfer" class="col-sm-12">

                  <div class="col-md-3">
                      <label for="bank">Banco <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <select name="bank" id="bank" style="width:200px" class="form-control">
                            <option value="">[Bancos Disponibles]</option>
                            <?php foreach (listBancos() as $key) { ?>
                                <option style="width:200px" value="<?= $key->ID ?>"><?= $key->NAME ?></option>
                            <?php } ?>
                        </select>

                      </div>
                  </div>

                  <div class="col-md-3">
                      <label for="account">Tipo de Cuenta <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <select name="typeAccount" id="typeAccount" style="width:200px" class="form-control">
                            <option value="">[Tipo Cuenta]</option>
                            <?php foreach (listTipoCuentas() as $key) { ?>
                                <option style="width:200px" value="<?= $key->ID ?>"><?= $key->NAME ?></option>
                            <?php } ?>
                        </select>
                      </div>
                  </div>

                  <div class="col-md-3">
                    <label for="accountNumber">N&#250;mero de Cuenta <span class="text-danger">*</span></label>
                      <div class="input-group  col-sm-9">
                          <input id="numberAccount" class="form-control" value="" maxlength="18" placeholder="N&#250;mero de Cuenta" onkeypress="return Teknodata.masked_onlyNumber(event);"></input>
                      </div>
                  </div>

                  <div class="col-md-3">
                    <label for="emailClient">Email</label>
                    <input type="text" id="emailClientNew" name="emailClientNew" class="form-control text-center minusculas" >
                  </div>

                </div>
            </table>

          </div>
          <!--End Section Forma de Pago-->

    </div>
  </div>
  <!--End Forma de Pago / Banco / Tipo Cuenta / Nº Cuenta-->
</form>

      <!--Begin Botones de Control Formulario-->
      <div class="form-group text-center">
        <button type="button" style="width:150px" class="btn-save btn-ok btn btn-success" ><i class="fa fa-floppy-o"></i> Grabar </button>
<?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):?>
        <button type="button" style="width:150px" class="btn-linked btn-ok btn btn-success" ><i class="gi gi-link"></i> Enlazar </button>
<?php endif;?>
        <button type="button" style="width:150px" class="btn-confirm btn btn-success" ><i class="gi gi-hand_right"></i> Confirmar </button>
        <button type="button" style="width:150px" class="btn-print btn btn-success" ><i class="gi gi-print"></i> Imprimir </button>
        <button type="button" style="width:150px" class="btn-send btn btn-success" ><i class="gi gi-send"></i> Enviar por Email</button>
      </div>
      <!--End Botones de Control Formulario-->

</div>

<input type="hidden" id="nroRut" value="<?= $dataLoad["nroRut"]?>">
<input type="hidden" id="idDocument" value="<?= $dataLoad["idDocument"]?>">
<input type="hidden" id="datajson" >
<input type="hidden" id="message" >
</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/advance/Beneficiary.js"></script>
<script src="/js/advance/Review.js"></script>
</body>
</html>
