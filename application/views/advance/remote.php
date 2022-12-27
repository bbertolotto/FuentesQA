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

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="rutClient">Nº de Rut</label>
                    <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center" placeholder=""
                    onkeypress="return Teknodata.enter_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this)" data-target="" data-toggle="tooltip" data-placement="top" title="Digite Número Rut y Presione Enter para buscar .."></input>
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-3">
                    <label for="example-nf-name">Cliente</label>
                    <input type="text" id="label_nameClient" name="label_nameClient" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" readonly >

                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="emailClient">Email</label>
                    <input type="text" id="emailClient" name="emailClient" class="form-control text-center minusculas" readonly >
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
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

            <a href="#approbation" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>

        </div>
        <h2><i class="fa fa-file-text-o"></i><strong>&nbsp;Autenticaci&oacute;n</strong> del Cliente</h2>
      </div>

      <div class="collapse" id="approbation">

                  <table class="table table-striped table-borderless table-vcenter">
                    <thead>
                      <tr>
                      <th class="text-right" width="30%"><strong>PREGUNTA</strong></th>
                      <th class="text-center" width="30%"><strong>VALIDACI&#211;N</strong></th>
                      <th class="text-left" width="30%"><strong>RESPUESTA</strong></th>
                    </tr>
                    </thead>
                      <tbody>
                          <tr>
                              <td class="text-right" nowrap>
                                  <strong>
                                    <i class="fa fa-check"></i>Indíqueme su cedula de identidad y número de documento</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesSerie" type="checkbox" onclick="other=document.getElementById('noSerie');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noSerie" type="checkbox" checked onclick="other=document.getElementById('yesSerie');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">

                              <div class="input-group">
                                  <label class="control-label" id="lblnroserie"><h5><strong></strong></h5></label>
                                  <input type="file" class="custom-file-input" id="fileCI" name="fileci" lang="es">
                              </div>

                              </td>
                          </tr>

                          <tr>
                              <td class="text-right" nowrap>
                                  <strong>
                                    <i class="fa fa-check"></i>Indíqueme su Nombre Completo</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesNameClient"  type="checkbox" onclick="other=document.getElementById('noNameClient');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noNameClient" type="checkbox" checked onclick="other=document.getElementById('yesNameClient');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label" id="lblnameClient"><h5><strong></strong></h5></label>
                              </td>

                          </tr>

                          <tr>
                              <td class="text-right" >
                                <strong>
                                <i class="fa fa-check"></i>Indíquime los 4 &uacute;ltimos n&uacute;meros de su tarjeta
                                </strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesnroTarjeta" type="checkbox" onclick="other=document.getElementById('nonroTarjeta');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="nonroTarjeta" type="checkbox" checked onclick="other=document.getElementById('yesnroTarjeta');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label" id="lblnroTarjeta"><h5><strong></strong></h5></label>
                              </td>

                          </tr>

                          <tr>
                              <td class="text-right">
                              <strong>
                              <i class="fa fa-check"></i>Usted tiene tarjeta Adicional en su tarjeta Cruz Verde</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesTarjetaAdic" type="checkbox" onclick="other=document.getElementById('noTarjetaAdic');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noTarjetaAdic"  type="checkbox" checked onclick="other=document.getElementById('yesTarjetaAdic');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label" id="lblAdicionales"><h5><strong></strong></h5></label>
                              </td>

                          </tr>

                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="fa fa-check"></i>Indíqueme donde recibe su estado de cuenta</strong>
                                    <input type="hidden" class="control-label" id="lblglosaDespacho">
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesDispatch" type="checkbox" onclick="other=document.getElementById('noDispatch');let result = this.checked ? other.checked = false: other.checked = true; if(document.getElementById('noDispatch').checked) { document.getElementById('optional').style.display=''; } else { document.getElementById('optional').style.display='none'; } "><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noDispatch" type="checkbox" checked onclick="other=document.getElementById('yesDispatch');let result = this.checked ? other.checked = false: other.checked = true; if(document.getElementById('noDispatch').checked) { document.getElementById('optional').style.display=''; } else { document.getElementById('optional').style.display='none'; }"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label" id="lblDireccion"><h5><strong></strong></h5></label>
                              </td>

                          </tr>

                        </tbody>
                       </table>

                  <table class="table table-striped table-borderless table-vcenter" id="optional" >
                    <thead>
                      <tr>
                      <th class="text-right" width="30%"><strong>PREGUNTA</strong></th>
                      <th class="text-center" width="30%"><strong>VALIDACI&#211;N</strong></th>
                      <th class="text-left" width="30%"><strong>RESPUESTA</strong></th>
                    </tr>
                    </thead>

                    <tbody>
                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="gi gi-warning_sign"></i>Indíqueme la fecha de su última compra?</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesFechaUltCompra" type="checkbox" onclick="other=document.getElementById('noFechaUltCompra');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noFechaUltCompra" type="checkbox" checked onclick="other=document.getElementById('yesFechaUltCompra');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label" id="lblfechaUltCompra"><h5><strong></strong></h5></label>
                              </td>
                          </tr>

                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="gi gi-warning_sign"></i>Indíqueme d&#237;a de vencimiento del estado de cuenta mensual de su Tarjeta Cruz Verde</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesDiaVencimiento" type="checkbox" onclick="other=document.getElementById('noDiaVencimiento');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noDiaVencimiento" type="checkbox" checked onclick="other=document.getElementById('yesDiaVencimiento');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label" id="lbldiaVencimiento"><h5><strong></strong></h5></label>
                              </td>
                          </tr>

                      </tbody>
                  </table>

      </div>

    </div>

  </div><!--End col-md-6-->

</div>


<div class="row">

<div class="col-md-12">

<div class="block">

  <div class="block-title">

    <div class="block-options pull-right">

      <!--
        <div class="btn-group btn-group-sm">
            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default dropdown-toggle enable-tooltip" data-toggle="dropdown" title="Opciones"><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                <li>
                    <a href="javascript:void(0)"><i class="fa fa-floppy-o pull-right"></i>Limpiar Negociación</a>
                    <a href="javascript:void(0)"><i class="gi gi-hand_right pull-right"></i>Revisar Seguros</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="javascript:void(0)"><i class="gi gi-send fa-fw pull-right"></i>Revisar Script</a>
                </li>
            </ul>
        </div>
    -->
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
          <label for="offerRequest">Solicitado <span class="text-danger">*</span></label>
          <input type="text" id="offerRequest" name="offerRequest" onkeyup="Teknodata.formatMoneda(this);" onchange="Teknodata.formatMoneda(this);" class="form-control text-center" maxlength="11" >
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-lg-2">
          <label>&nbsp;&nbsp;Cuotas <span class="text-danger">*</span></label>
          <select id="numberQuotas" name="numberQuotas" class="form-control text-center" data-target="<?=$dataLoad['maxNumberQuotas']?>" >
            <?php
            for ($i = $dataLoad['minNumberQuotas']; $i <= $dataLoad['maxNumberQuotas']; $i++) {
                echo "<option value='".$i."'>".$i."</option>";
            }
            ?>
          </select>
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-lg-2">
          <label>&nbsp;&nbsp;Diferidos <span class="text-danger">*</span></label>
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
                  <label class="radio-inline" for="example-inline-radio1">
                      <input type="radio" id="yesEmailSecureOne" onclick="if(this.checked){$('#noEmailSecureOne').prop('checked', false); }"> Sí
                  </label>
                  <label class="radio-inline" for="example-inline-radio2">
                      <input type="radio" id="noEmailSecureOne" onclick="if(this.checked){$('#yesEmailSecureOne').prop('checked', false); }"> No
                  </label>
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
                    <input type="radio" id="yesdps-1-secure-one" onclick="if(this.checked){$('#nodps-1-secure-one').prop('checked', false); Client.cancelSecureOne(this);}"> Sí
                </label>
                <label class="radio-inline" for="example-inline-radio2">
                    <input type="radio" id="nodps-1-secure-one" onclick="if(this.checked){$('#yesdps-1-secure-one').prop('checked', false); Client.cancelSecureOne(this);}"> No
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
                  <input type="radio" id="yesdps-2-secure-one" onclick="if(this.checked){$('#nodps-2-secure-one').prop('checked', false); Client.cancelSecureOne(this);}"> Sí
              </label>
              <label class="radio-inline" for="example-inline-radio2">
                  <input type="radio" id="nodps-2-secure-one" onclick="if(this.checked){$('#yesdps-2-secure-one').prop('checked', false); Client.cancelSecureOne(this);}"> No
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
                <input type="radio" id="yesdps-3-secure-one" onclick="if(this.checked){$('#nodps-3-secure-one').prop('checked', false); Client.cancelSecureOne(this);}"> Sí
            </label>
            <label class="radio-inline" for="example-inline-radio2">
                <input type="radio" id="nodps-3-secure-one" onclick="if(this.checked){$('#yesdps-3-secure-one').prop('checked', false); Client.cancelSecureOne(this);}"> No
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
                  <label class="radio-inline" for="example-inline-radio1">
                      <input type="radio" id="yesEmailSecureTwo" onclick="if(this.checked){$('#noEmailSecureTwo').prop('checked', false); }"> Sí
                  </label>
                  <label class="radio-inline" for="example-inline-radio2">
                      <input type="radio" id="noEmailSecureTwo" onclick="if(this.checked){$('#yesEmailSecureTwo').prop('checked', false); }"> No
                  </label>
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

          <div class="block-options pull-right">
              <a href="#payment" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
          </div>
          <h2><i class="fa fa-money"></i>&nbsp;<strong>Datos Banco</strong> y Confirmación Súper Avance</h2>
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
        <button type="button" style="width:150px" class="btn-save btn btn-success" ><i class="fa fa-floppy-o"></i> Grabar </button>
        <button type="button" style="width:150px" class="btn-confirm btn btn-success" ><i class="gi gi-hand_right"></i> Confirmar </button>
        <button type="button" style="width:150px" class="btn-print btn btn-success" ><i class="gi gi-print"></i> Imprimir </button>
        <button type="button" style="width:150px" class="btn-send btn btn-success" ><i class="gi gi-send"></i> Enviar por Email</button>
      </div>
      <!--End Botones de Control Formulario-->

</div>

<input type="hidden" id="idDocument">
<input type="hidden" id="idEstado">
<input type="hidden" id="montoOferta">
<input type="hidden" id="montoPreaprobado">
<input type="hidden" id="id_rol">
<input type="hidden" id="id_office" value="<?= $this->session->userdata('id_office')?>">
<input type="hidden" id="flg_print">
<input type="hidden" id="flg_client">
<input type="hidden" id="nameClient">
<input type="hidden" id="sexoClient">
<input type="hidden" id="datajson">
<input type="hidden" id="dataajax">
<input type="hidden" id="dataload" value='<?= $dataLoad["dataload"]?>'>
</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalLink'); ?>
<?php $this->load->view('ModalCreate'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<!-- Javascript exclusivos para esta página -->
<script language="javascript">

var response = "";

$(function () {

    $('.btn-modal-request').on('click', function () {

        var target = $(this).data('target');

        if(target=="accept"){

            var tab = document.getElementById('tabRequest');
            for (var i=1;i < tab.rows.length; i++){
                /* Selecciona CheckBox con Opción Cliente*/
                sel = document.getElementById("sel"+tab.rows[i].cells[1].innerHTML);
                if(sel.checked){

                    $data = "id="+tab.rows[i].cells[1].innerHTML;
                    $.ajax( {
                        url: "/advance/get_requestById", type: "POST", dataType: "json", data : $data,
                        beforeSend: function () { Client.processShow(); }, complete: function () { Client.processHide(); },
                        success: function(response, status, xhr){

                            if(response.retorno == 0){
                                Client.loadRequest(response);
                            }else{
                                Alert.showWarning(response.descRetorno,"");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Alert.showToastrErrorXHR(jqXHR, textStatus);
                            Client.processHide();
                        }
                   });
                   return(true);
                }
            }

            toastr.warning("Debe Seleccionar una COTIZACI&#211;N para continuar..","Preste Atenci&#243;n.");
            return(false);
        }

        if(target=="cancel"){

            var response = JSON.parse($("#datajson").val());
            Client.loadOffers(response); $("#approbation").collapse('show');
            return(true);
        }

    });

    $('.btn-reset').on('click', function () { $("#dataload").val('{ "source": "evaluation" }'); Client.prepare(); });

    $(".btn-save").on("click", function () {

        $("#dateLinked").val(""); $("#officeLinked").val("");
        if($("#emailCuenta").val()=="" && $('#formPayOne').is(":checked")) { toastr.warning("Debe solicitar un correo Electrónico al cliente","Preste Atención"); return false; }
        Client.saveRequest();

    });


    $('.btn-confirm').on('click', function () {

        if(!Client.checkValidationClient()){
            Alert.showWarning("Preste Atenci&oacute;n", "Antes de Intentar Confirmar SAV, debe revisar Preguntas de Autenticaci&oacute;n..");
            return(false);
        }

        $(".btn-confirm").prop('disabled', true); $data = "idDocument="+$("#idDocument").val()+"&nroRut="+$("#masked_rut_client").val();
        $.redirect("/advance/confirmRequest", { idDocument: $("#idDocument").val(), nroRut: $("#masked_rut_client").val() } );

    });

    $('.btn-simulate').on('click', function () {

        if(!Client.checkValidationClient()){
            Alert.showWarning("Preste Atenci&oacute;n", "Antes de Intentar Confirmar SAV, debe revisar Preguntas de Autenticaci&oacute;n..");
            return(false);
        }

        if($("#masked_rut_client").val()==""){ toastr.warning("Antes de Cambiar Atributos, debe ingresar RUT Cliente y buscar Ofertas ..","Presta Mucha Atenci&#243;n ..!"); return(false); }

        var formData = new FormData();
            formData.append("nroRut",$("#masked_rut_client").val());
            formData.append("offerRequest",$("#offerRequest").val());
            formData.append("offerAmount",$("#offerAmount").val());
            formData.append("offerType",$("#offerType").val());
            formData.append("numberQuotas",$("#numberQuotas").val());
            formData.append("deferredQuotas",$("#deferredQuotas").val());

        if(document.getElementById('secureOne').checked){
            formData.append("secureOne",$("#secureOne").val());
        }else{
            formData.append("secureOne","");
        }

        if(document.getElementById('secureTwo').checked){
            formData.append("secureTwo",$("#secureTwo").val());
        }else{
            formData.append("secureTwo","");
        }

        $("#simulate").html("");
        var response = Teknodata.call_ajax("/advance/get_simulate", formData, false, true,  ".btn-simulate");

        if(response!=false){

            if(response.retorno == 0){

                    Client.initSimulate(response);

            }else{

                    Alert.showWarning("",response.descRetorno);
            }
        }

    return(false);
    });


    $('.btn-send').on('click', function () {

        if($("#flg_print").val()!="print") { toastr.warning("Debe Imprimir Cotización Antes de Enviar Por Mail","Preste Atención"); return(false); }
        $data = "idDocument="+$("#idDocument").val()+"&emailCuenta="+$("#emailClient").val()+"&nombreCliente="+$("#label_nameClient").val()+"&estadoTEF=cotiza";

        var response = Teknodata.call_ajax("/advance/send_Simulate", $data, false, true,  ".btn-send");

        if(response!=false){

            if(response.retorno == 0){

                    toastr.success("Cotización Enviada por correo con éxito","Preste Atención");

            }else{

                    Alert.showToastrWarning(response);
            }
        }

    });


    $('.btn-print').on('click', function () {

        Client.processShow();
        $data = "id="+$("#idDocument").val()+"&type=COT";

        var response = Teknodata.call_ajax("/advance/generaPDF", $data, false, false,  ".btn-print");

        if(response!=false){

            if(response.retorno == 0){

                    $("#flg_print").val("print");
                    toastr.success("Cotizaci&#243;n marcada como "+response.glosaEstado, "Preste Atenci#243;n !");
                    window.open("/advance/readPDF", '_blank');

            }else{

                    Alert.showToastrError(response);
            }
        }

        Client.initSend();
        return(false);

    });


});

var Client = function() {
    return {

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },
        saveRequest: function() {


        var formData = new FormData();

            if($('#masked_rut_client').val()==""){toastr.warning("Debe ingresar RUT Cliente y simular, antes de Grabar Cotización..","Presta Mucha Atención ..!"); return(false); }

            if(!Client.checkValidationClient()){
                Alert.showWarning("Preste Atenci&oacute;n", "Antes de Intentar Confirmar SAV, debe revisar Preguntas de Autenticaci&oacute;n..");
                return(false);
            }

            var secureOne = document.getElementById('secureOne');
            var secureTwo = document.getElementById('secureTwo');

            var tab = document.getElementById('tabSimulate');
            var $flagSave = false;

            if(!$("#tabSimulate").length){ toastr.warning("No hay detalle de Oferta ..!", "Preste Atención"); return(false); }

            for (var i=1;i < tab.rows.length; i++) {

            /* Selecciona CheckBox con Opción Cliente*/
            sel = document.getElementById("sel"+tab.rows[i].cells[1].innerHTML);
            if(sel.checked){

                $data = "";
                $flagSave = true;

                formData.append("numeroCuotas",tab.rows[i].cells[1].innerHTML);
                formData.append("tipoSolicitud","C");
                formData.append("mesesDiferido",tab.rows[i].cells[2].innerHTML);
                formData.append("valorCuota",tab.rows[i].cells[3].innerHTML);
                formData.append("montoSolicitado",tab.rows[i].cells[5].innerHTML);
                formData.append("costoTotal",tab.rows[i].cells[6].innerHTML);
                formData.append("tasaInteres",tab.rows[i].cells[7].innerHTML);
                formData.append("impuestos",tab.rows[i].cells[8].innerHTML);
                formData.append("comision",tab.rows[i].cells[9].innerHTML);
                formData.append("cae",tab.rows[i].cells[10].innerHTML);
                formData.append("montoBruto",tab.rows[i].cells[4].innerHTML);
                formData.append("costoTotalSeguro1",tab.rows[i].cells[11].innerHTML);
                formData.append("costoTotalSeguro2",tab.rows[i].cells[12].innerHTML);
                formData.append("nroRut",$('#masked_rut_client').val());
                formData.append("vencimientoCuota",$('#dateFirstExpiration').val());

                if(secureOne.checked){
                  formData.append("codSeguro1",$(secureOne).data("cod"));
                  formData.append("idPolizaSeguro1",$(secureOne).data("pol"));

                  if( (!$('#yesEmailSecureOne').is(":checked"))&&(!$('#noEmailSecureOne').is(":checked")) ) {
                      toastr.warning("Seguro "+$(secureOne).data('descrip')+"</br>Requiere completar autorizaci&#243;n Email!","Preste Atenci&#243;n");
                      return(false);
                  }
                  if( ((!$('#yesdps-1-secure-one').is(":checked"))&&(!$('#nodps-1-secure-one').is(":checked")))||
                      ((!$('#yesdps-2-secure-one').is(":checked"))&&(!$('#nodps-2-secure-one').is(":checked")))||
                      ((!$('#yesdps-3-secure-one').is(":checked"))&&(!$('#nodps-3-secure-one').is(":checked"))) ) {
                      toastr.warning("Seguro "+$(secureOne).data('descrip')+"</br>Requiere completar DPS!","Preste Atenci&#243;n");
                      return(false);
                  }
                  if($('#yesdps-1-secure-one').is(":checked")||$('#yesdps-2-secure-one').is(":checked")||$('#yesdps-3-secure-one').is(":checked")){
                      toastr.warning("No puede vender seguro "+$("#secureOne").data("descrip")+"</br>Por declaración de Salud cliente</br>Desactive el seguro.","Presta Atenci&#243;n");
                      return(false);
                  }
                  if($('#yesEmailSecureOne').is(":checked")) { formData.append("useEmail1","1"); } else { formData.append("useEmail1","0"); }
                  if($('#yesdps-1-secure-one').is(":checked")&&$('#yesdps-2-secure-one').is(":checked")&&$('#yesdps-3-secure-one').is(":checked")) {
                      formData.append("declareDps", 1);
                  }else{
                      formData.append("declareDps", 0);
                  }

                  if($('#yesdpsSecureOne').is(":checked")) { formData.append("declareDps","1"); } else { formData.append("declareDps","0");  }
                }
                if(secureTwo.checked){

                  formData.append("codSeguro2",$(secureTwo).data('cod'));
                  formData.append("idPolizaSeguro2",$(secureTwo).data('pol'));

                  if( (!$('#yesEmailSecureTwo').is(":checked")) &&
                      (!$('#noEmailSecureTwo').is(":checked")) ) {
                      toastr.warning("Debe atender informaci&#243;n Seguro Vida!","Requiere completar Informaci&#243;n Autorizaci&#243;n Email");
                      return(false);
                  }

                  if($('#yesEmailSecureTwo').is(":checked")) { formData.append("useEmail2","1"); } else { formData.append("useEmail2","0"); }
                  formData.append("typeBeneficiaries","legal");

                }
                /*Valid Datos para transferencia Bancaria*/
                if($('#bank').val()==""||$('#typeAccount').val()==""||$('#numberAccount').val()=="") {
                    toastr.warning("Debe Completar Datos Bancarios cliente para transferencia","Preste Atenci&#243;n..");
                    return(false);
                }
                formData.append("bank",$('#bank').val());
                formData.append("typeAccount",$('#typeAccount').val());
                formData.append("numberAccount",$('#numberAccount').val());

                if($("#dateLinked").val()=="") { formData.append("estadoEnlace",""); formData.append("sucursalDestino",""); formData.append("fechaCompromisoEnlace",""); } else {  formData.append("estadoEnlace","ENL"); formData.append("sucursalDestino",$("#officeLinked").val()); formData.append("fechaCompromisoEnlace",$("#dateLinked").val()); }

                if($("#offerType").val()!="AP") {
                    toastr.warning("En modalidad REMOTA no puede ofrecer Ofertas PRE APROBADAS","Preste Atenci&#243;n..");
                    return(false);
                }

                formData.append("offerType",$("#offerType").val());
                formData.append("emailCuenta",$("#emailClient").val());
                formData.append("telefonoCuenta",$("#phoneClient").val());
                formData.append("emailClientNew",$("#emailClientNew").val());
                formData.append("fileCI", fileCI.files[0]);

                if($("#emailClient").val()==""&&$("#emailClientNew").val()=="") {
                    Alert.showWarning("Preste Atenci&oacute;n..", "Debe ingresar Email del Cliente...");
                    return(false);
                }

                var response = Teknodata.call_ajax("/advance/put_simulate", formData, false, true,  ".btn-save");

                if(response!=false){

                    if(response.retorno == 0){

                            $('#idDocument').val(response.idDocument);
                            toastr.success(response.descRetorno, "Preste Atención..");
                            Client.initAuthorization();

                    }else{

                            Alert.showToastrWarning(response);
                    }
                }

            } //End checked
            } //End for

            if(!$flagSave){
                toastr.warning("Revise negociación Antes de Grabar ..", "Preste Atención"); return(false);
            }

            return (true);
        },

        checkValidationClient: function () {

          var requireOK = 0;
          var yes = document.getElementById("yesSerie"); if(yes.checked) { requireOK += 1; }
          var yes = document.getElementById("yesNameClient"); if(yes.checked) { requireOK += 1; }
          var yes = document.getElementById("yesnroTarjeta"); if(yes.checked) { requireOK += 1; }
          var yes = document.getElementById("yesTarjetaAdic"); if(yes.checked) { requireOK += 1; }

          if(requireOK<4){
              return(false);
          }

          var yes = document.getElementById("yesDispatch");
          if(!yes.checked) {
              var requireNOOK = 0;
              var yes = document.getElementById("yesFechaUltCompra"); if(yes.checked) { requireNOOK += 1; }
              var yes = document.getElementById("yesDiaVencimiento"); if(yes.checked) { requireNOOK += 1; }

              if(requireOK=4&&requireNOOK<1){
                  return(false);
              }
          }

          return(true);
        },
        selectOffer: function(obj) {

            if(obj.value=="UP"){ Alert.showWarning("Alerta Comercial","Cliente tiene un monto pre-aprobado.<br/>Derivar a sucursal para evaluación de la oferta",""); return(false);}
            $("#numberQuotas").prop('disabled', false);
            $("#deferredQuotas").prop('disabled', false);

                var response = JSON.parse($("#datajson").val());
                for(i=0;i<response.offerDetail.length;i++){

                    if(response.offerDetail[i].offerCode==obj.value){

                        $("#offerType").val(obj.value);
                        $("#offerAmount").val(Teknodata.maskMoney(response.offerDetail[i].offerAmount));
                        $("#offerRequest").val(Teknodata.maskMoney(response.offerDetail[i].offerAmount));
                        $("#numberQuotas").val(response.offerDetail[i].offerQuotas)
                        $("#deferredQuotas").val(response.offerDetail[i].offerDeferred)

                        if(response.offerDetail[i].flagQuotas){
                            $("#numberQuotas").prop('disabled', true);
                        }
                        if(response.offerDetail[i].flagDeferred){
                            $("#deferredQuotas").prop('disabled', true);
                        }

                    }
                }

            return(true);
        },
        loadOffers: function(response) {
            /*Datos de Contacto Cliente*/
            $("#label_nameClient").val(response.completeNameClient);
            $("#emailClient").val(response.email);
            $("#phoneClient").val(response.phone);
            $("#nameClient").val(response.nameClient);
            $("#sexoClient").val(response.sexoClient);

            /*Datos Verificación Cliente*/
            document.getElementById('lblnameClient').innerHTML = response.completeNameClient;
            document.getElementById('lblnroserie').innerHTML = response.nroserie;
            document.getElementById('lblnroTarjeta').innerHTML = response.nroTcv;
            document.getElementById('lblAdicionales').innerHTML = response.lblAdicionales;
            document.getElementById('lblglosaDespacho').innerHTML = response.lblglosaDespacho;
            document.getElementById('lblfechaUltCompra').innerHTML = response.lblfechaUltCompra;
            document.getElementById('lbldiaVencimiento').innerHTML = response.lbldiaVencimiento;

            if(response.lbltipoDespacho=="EMAIL"){
              document.getElementById('lblDireccion').innerHTML = response.email;
            }else{
              document.getElementById('lblDireccion').innerHTML = response.lblDireccion;
            }

            /*Datos Negociación con Cliente*/
            $("#amountApproved").val(Teknodata.maskMoney(response.montoOferta));
            $("#amountPreApproved").val(Teknodata.maskMoney(response.montoPreaprobado));
            $("#numberQuotas").val(response.plazoMaximoOferta);
            $("#amountApproved").prop('disabled', false);
            $("#amountPreApproved").prop('disabled', true);
            $("#id_rol").val(response.id_rol);
            $("#montoOferta").val(response.montoOferta);
            $("#montoPreaprobado").val(response.montoPreaprobado);

            /*Clear Validacion Cliente */
            yes = document.getElementById("yesSerie"); no = document.getElementById("noSerie");
            yes.disabled = false; yes.checked = false; no.disabled = false; no.checked = true;
            yes = document.getElementById("yesNameClient"); no = document.getElementById("noNameClient");
            yes.disabled = false; yes.checked = false; no.disabled = false; no.checked = true;
            yes = document.getElementById("yesnroTarjeta"); no = document.getElementById("nonroTarjeta");
            yes.disabled = false; yes.checked = false; no.disabled = false; no.checked = true;
            yes = document.getElementById("yesTarjetaAdic"); no = document.getElementById("noTarjetaAdic");
            yes.disabled = false; yes.checked = false; no.disabled = false; no.checked = true;
            yes = document.getElementById("yesDispatch"); no = document.getElementById("noDispatch");
            yes.disabled = false; yes.checked = false; no.disabled = false; no.checked = true;
            yes = document.getElementById("yesFechaUltCompra"); no = document.getElementById("noFechaUltCompra");
            yes.disabled = false; yes.checked = false; no.disabled = false; no.checked = true;
            yes = document.getElementById("yesDiaVencimiento"); no = document.getElementById("noDiaVencimiento");
            yes.disabled = false; yes.checked = false; no.disabled = false; no.checked = true;

            /*Datos Negociación con Cliente*/
            $("#id_rol").val(response.id_rol);
            $("#flg_client").val(1);
            o = document.getElementById('offerSelector');
            o.innerHTML = response.offerSelector;
            $("#negotiation").collapse('show');

            $("#flg_client").val(1);
        },
        loadRequest: function(response) {

            var rut = $('#masked_rut_client').val();

            var tasaMaxima = String(response.tasaMaxima);
            var tasaRequest = String(response.tasaRequest);

            if(Number(tasaMaxima) < Number(tasaRequest)) {
                Alert.showWarning("Cotización vigente excede Tasa Máxima..<br>Crear nueva Cotización!!","",modal_size_md);
                $("#dataload").val('{ "source": "evaluation" }')
                Client.prepare();
                return(false);
            }

            if(response.modoEntrega!="TEF"){
              Alert.showWarning("Cotización con forma de pago EFECTIVO..<br>Debe ser procesada en modalidad de Atención PRESENCIAL","Preste Atención",modal_size_md);
              Client.prepare();
              return(false);
            }

            var datajson = JSON.parse($("#datajson").val()); Client.loadOffers(datajson);

            $(".btn-simulate").prop('disabled', true);
            $("#amountApproved").prop('disabled', true);

            $('#amountApproved').val(response.montoLiquido);
            $('#numberQuotas').val(response.plazoDeCuota);
            $('#numberQuotas').prop('disabled', true);
            $('#deferredQuotas').prop('disabled', true);
            $('#interesRate').val(response.tasaDeInteresMensual);
            $('#dateFirstExpiration').val(response.fechaPrimerVencimiento);
            $("#emailClient").val(response.email);
            if(response.fonoMovil!=""){ $("#phoneClient").val(response.fonoMovil); } else { $("#phoneClient").val(response.fonoFijo); }

//            $("#yesEmailSecureOne").prop("disabled", true);
//            $("#noEmailSecureOne").prop("disabled", true);
            $("#yesdpsSecureOne").prop("disabled", true);
            $("#nodpsSecureOne").prop("disabled", true);

//            $("#noEmailSecureTwo").prop("disabled", true);
//            $("#yesEmailSecureTwo").prop("disabled", true);

            if(response.modoEntrega=="TEF"){
                $("#formPayOne").attr("checked", true);
                $('#formPayOne').prop('disabled', true);
                $("#formPayTwo").attr("checked", false);
                $('#formPayTwo').prop('disabled', true);
                $('#bank').val(response.banco);
                $('#bank').prop('disabled', true);
                $('#typeAccount').val(response.tipoCuenta);
                $('#typeAccount').prop('disabled', true);
                $('#numberAccount').val(response.numeroCuenta);
                $('#numberAccount').prop('disabled', true);
            }else {
                $("#formPayOne").attr("checked", false);
                $('#formPayOne').prop('disabled', true);
                $("#formPayTwo").attr("checked", true);
                $('#formPayTwo').prop('disabled', true);
                $('#bank').val("");
                $('#bank').prop('disabled', true);
                $('#typeAccount').val("");
                $('#typeAccount').prop('disabled', true);
                $('#numberAccount').val("");
                $('#numberAccount').prop('disabled', true);
            }

            if(response.flagSeguro1=="CON SEGURO"){

                var obj = document.getElementById("label"+response.htmlName1);
                obj.innerHTML=" [ACEPTADO]";
                obj = document.getElementById(response.htmlName1);
                obj.checked=true;
                obj.disabled=true;

            }else{

                var obj = document.getElementById("label"+response.htmlName1);
                obj.innerHTML=" [RECHAZADO]";
                obj = document.getElementById(response.htmlName1);
                obj.checked=false;
                obj.disabled=true;
            }

            if(response.flagSeguro2=="CON SEGURO"){

                var obj = document.getElementById("label"+response.htmlName2);
                obj.innerHTML=" [ACEPTADO]";
                obj = document.getElementById(response.htmlName2);
                obj.checked=true;
                obj.disabled=true;

            }else{

                var obj = document.getElementById("label"+response.htmlName2);
                obj.innerHTML="[RECHAZADO]";
                obj = document.getElementById(response.htmlName2);
                obj.checked=false;
                obj.disabled=true;
            }

            o = document.getElementById('simulate');
            o.innerHTML = response.htmlSimulate; $('#simulate').click();

            if(response.estado=="I"||response.estado=="PE"||response.estado=="CO"){
                $('#idDocument').val(response.idDocument);
                $('#idEstado').val(response.estado);
                Client.initAuthorization();
            }
            if(response.estado=="PA"||response.estado=="AU"){
                $('#idDocument').val(response.idDocument);
                $('#idEstado').val(response.estado);
                Client.initExecutive();
            }
            $("#approbation").collapse('show');
            $("#negotiation").collapse('hide');
            $("#payment").collapse('hide');

        },
        prepare: function() {

          Client.clearForm("form-client");
          Client.clearForm("form-negotiation");

          $("#masked_rut_client").prop('disabled', false); $("#emailClient").prop('disabled', true); $("#phoneClient").prop('disabled', true); $("#approbation").click();

          /*clear datos Verificación Cliente*/
          document.getElementById('lblnroserie').innerHTML = "";
          document.getElementById('lblnameClient').innerHTML = "";
          document.getElementById('lblnroTarjeta').innerHTML = "";
          document.getElementById('lblAdicionales').innerHTML = "";
          document.getElementById('lblglosaDespacho').innerHTML = "";
          document.getElementById('lblfechaUltCompra').innerHTML = "";
          document.getElementById('lbldiaVencimiento').innerHTML = "";
          document.getElementById('lblDireccion').innerHTML = "";

          /*clear datos forma de pago*/
          $("#bank").val(""); $("#typeAccount").val(""); $("#numberAccount").val("");
          $("#bank").prop("disabled", false); $("#typeAccount").prop("disabled", false); $("#numberAccount").prop("disabled", false);
          $("#emailClientNew").val("");

          /*clear datos negociacion y seguros*/
          document.getElementById('simulate').innerHTML = "";
          $("#tabSimulate tbody").empty();
          $(".btn-simulate").prop('disabled', false);
          $(".btn-save").prop('disabled', false);
          $(".btn-confirm").prop('disabled', true);
          $(".btn-print").prop('disabled', true);
          $(".btn-send").prop('disabled', true);
          $("#numberQuotas").prop("disabled", false);
          $("#deferredQuotas").prop("disabled", false);

//          $("#yesEmailSecureOne").attr("checked", false);
//          $("#noEmailSecureOne").attr("checked", false);
          $("#yesdpsSecureOne").attr("checked", false);
          $("#nodpsSecureOne").attr("checked", false);
//          $("#yesEmailSecureTwo").attr("checked", false);
//          $("#noEmailSecureTwo").attr("checked", false);

//          $("#yesEmailSecureOne").prop("disabled", false);
//          $("#noEmailSecureOne").prop("disabled", false);
          $("#yesdpsSecureOne").prop("disabled", false);
          $("#nodpsSecureOne").prop("disabled", false);
//          $("#yesEmailSecureTwo").prop("disabled", false);
//          $("#noEmailSecureTwo").prop("disabled", false);

          $("#deferredQuotas").val("0");
          $("#numberQuotas").val("0");

          /*close ventanas opcionales*/
          $("#approbation").collapse('hide');
          $("#negotiation").collapse('hide');
          $("#secure1").collapse('hide');
          $("#secure2").collapse('hide');
          $("#payment").collapse('hide');

          /*Clear Validacion Cliente */
          yes = document.getElementById("yesSerie"); no = document.getElementById("noSerie");
          yes.disabled = true; yes.checked = false; no.disabled = true; no.checked = true;
          yes = document.getElementById("yesNameClient"); no = document.getElementById("noNameClient");
          yes.disabled = true; yes.checked = false; no.disabled = true; no.checked = true;
          yes = document.getElementById("yesnroTarjeta"); no = document.getElementById("nonroTarjeta");
          yes.disabled = true; yes.checked = false; no.disabled = true; no.checked = true;
          yes = document.getElementById("yesTarjetaAdic"); no = document.getElementById("noTarjetaAdic");
          yes.disabled = true; yes.checked = false; no.disabled = true; no.checked = true;
          yes = document.getElementById("yesDispatch"); no = document.getElementById("noDispatch");
          yes.disabled = true; yes.checked = false; no.disabled = true; no.checked = true;
          yes = document.getElementById("yesFechaUltCompra"); no = document.getElementById("noFechaUltCompra");
          yes.disabled = true; yes.checked = false; no.disabled = true; no.checked = true;
          yes = document.getElementById("yesDiaVencimiento"); no = document.getElementById("noDiaVencimiento");
          yes.disabled = true; yes.checked = false; no.disabled = true; no.checked = true;

          var response = JSON.parse($("#dataload").val());
          if(response.source=="valid") { Client.search(); Teknodata.masked_nroRut(document.getElementById("masked_rut_client")); $("#masked_rut_client").prop("readonly", true); } else { Client.processHide(); }

          $("#flg_client").val(0);
          $("#masked_rut_client").focus();

        },
        clearForm: function(nameForm) {
            var form  = document.getElementById(nameForm);
            for (var i=0;i<form.elements.length;i++) {
                if(form.elements[i].type == "text") form.elements[i].value = "";
            }
        },
        initSimulate: function(response) {
            o = document.getElementById('simulate');
            o.innerHTML = response.htmlSimulate;
            $('#simulate').click();
            $("#dateFirstExpiration").val(response.dateFirstExpiration);
            $("#interesRate").val(response.interesRate+"%");
//            document.getElementById(response.lastLine).checked = true;
            $("#secureOne").prop("disabled", false);$("#secureTwo").prop("disabled", false);
            $("#formPayOne").prop("disabled", false); $("#formPayTwo").prop("disabled", false);
        },


        initOffers: function(response) {
            $("#label_nameClient").val(response.nameClient);
            $("#label_birthDate").val(response.birthDate);
            $("#label_diffYear").val(response.diffYear);

            $("#amountApproved").val(Teknodata.maskMoney(0));
            $("#amountPreApproved").val(Teknodata.maskMoney(0));

            $("#amountApproved").prop('disabled', false);
            $("#amountPreApproved").prop('disabled', true);
//            $("#checkAmountApproved").attr("checked", true);
//            $("#checkAmountPreApproved").attr("checked", false);
//            $("#checkAmountApproved").prop('disabled', true);
//            $("#checkAmountPreApproved").prop('disabled', true);

        },
        checkAmount: function(obj) {

            if(document.getElementById('masked_rut_client').value==""){

                let result = obj.checked ? obj.checked = false : obj.checked = true;
                return(false);
            }

            if(obj.id=="checkAmountApproved"){
                other = document.getElementById('checkAmountPreApproved');
                amountOne = document.getElementById('amountApproved');
                amountTwo = document.getElementById('amountPreApproved');
            }else{
                other = document.getElementById('checkAmountApproved');
                amountOne = document.getElementById('amountPreApproved');
                amountTwo = document.getElementById('amountApproved');
            }
            if(obj.checked){ other.checked = false; amountOne.disabled = false; amountTwo.disabled = true; }
            else{ other.checked = true; amountOne.disabled = true; amountTwo.disabled = false; }
            $(".btn-simulate").click();
        },

        checkFormPay: function(obj) {

            if($("#masked_rut_client").val()==""){
                let result = obj.checked ? obj.checked = false : obj.checked = true;
                return(false);
            }
            var o = document.getElementById('transfer');
            if(obj.id=="formPayOne"){
                other = document.getElementById('formPayTwo');
                let result = obj.checked ? o.style.display = "" : o.style.display = "none";
            }else{
                other = document.getElementById('formPayOne');
                let result = obj.checked ? o.style.display = "none" : o.style.display = "";
            }
            let result = obj.checked ? other.checked = false : other.checked = true;
        },

        checkSecure: function(obj) {
            if($('#masked_rut_client').val()==""){
                let result = obj.checked ? obj.checked = false : obj.checked = true;
                return(false);
            }
            var label = "label"+obj.id;
            if(obj.checked){ document.getElementById(label).innerHTML = "[ACEPTADO]";
                $("#yesdpsSecureOne").attr("checked", false);
                $("#nodpsSecureOne").attr("checked", false);
                }
            else{ document.getElementById(label).innerHTML = "[RECHAZADO]";
                Alert.showWarning('Advertencia',$(obj).data('target'),"md"); }
            $('.btn-simulate').click();
        },
        showScriptSecure: function(secure) {

          if($("#flg_client").val()==1){

            var obj = document.getElementById(secure); var script = $(obj).data('script');
            if($("#sexoClient").val()=="FEM"){
              attention = "Sra./Srta.: "+$("#nameClient").val();
            }else{
              attention = "Don: "+$("#nameClient").val();
            }
            if(secure=="secureOne"){ $("#secure1").collapse("hide"); } else { $("#secure2").collapse("hide"); }

            var re = /#attention/g; script = script.replace(re, attention);
            Alert.showWarning("",script,"lg");

          }

        },
        cancelSecureOne: function(obj) {
            if($('#masked_rut_client').val()==""){
                let result = obj.checked ? obj.checked = false : obj.checked = true;
                return(false);
            }
            if(obj.id=="yesdpsSecureOne"&&obj.checked){
                $("#secureOne").attr("checked", false);
                var label = "labelsecureOne";
                document.getElementById(label).innerHTML = "[DESACTIVADO POR DPS]";
                $('.btn-simulate').click();
            }
            if(obj.id=="nodpsSecureOne"&&obj.checked){
                $("#secureOne").attr("checked", true);
                var label = "labelsecureOne";
                document.getElementById(label).innerHTML = "[ACEPTADO]";
                $('.btn-simulate').click();
            }
        },
        yesDPS: function() {
          $("#yesdpsSecureOne").prop("checked", true);
          $("#nodpsSecureOne").prop("checked", false);
          $("#secureOne").prop("checked", false);
          var label = "labelsecureOne";
          document.getElementById(label).innerHTML = "[DESACTIVADO POR DPS]";
          $(".btn-simulate").click();
        },
        noDPS: function() {
          $("#yesdpsSecureOne").prop("checked", false);
          $("#nodpsSecureOne").prop("checked", true);
          $("#secureOne").prop("checked", true);
          var label = "labelsecureOne";
          document.getElementById(label).innerHTML = "[ACEPTADO]";
          $(".btn-simulate").click();
        },
        yesVIDA: function() {
          $("#secureTwo").prop("checked", true);
          var label = "labelsecureTwo";
          document.getElementById(label).innerHTML = "[ACEPTADO]";
          $(".btn-simulate").click();
        },
        noVIDA: function() {
          $("#secureTwo").prop("checked", false);
          var label = "labelsecureTwo";
          document.getElementById(label).innerHTML = "[RECHAZADO]";
          $(".btn-simulate").click();
        },
        selectRequest: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idRequest = tabTD[1].innerText;
            var idCheck = "sel"+idRequest;
            document.getElementById(idCheck).checked = true;
        },
        selectOffers: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idRequest = tabTD[1].innerText;
            var idCheck = "sel1";
            document.getElementById(idCheck).checked = true;
        },
        get_ClientByRut: function() {
            Client.search();
        },
        search: function() {

            var rut = $("#masked_rut_client").val();
            var evaluation = JSON.parse($("#dataload").val());
            if(evaluation.source=="valid"){ rut = evaluation.nroRut; } else { Client.prepare(); }

            $("#masked_rut_client").val(rut); $("#masked_rut_client").prop('disabled', true); $("#flg_client").val(0);

            var formData = new FormData();
            formData.append("nroRut",rut);

            var response = Teknodata.call_ajax("/advance/evaluation_client", formData, false, true,  "#masked_rut_client");

            if(response!=false){

                $("#datajson").val(JSON.stringify(response));

                switch (response.retorno) {
                case 0:

                    if(evaluation.source=="valid") {

                        var formData = new FormData();
                        formData.append("id",evaluation.idDocument);

                        var response = Teknodata.call_ajax("/advance/get_requestById", formData, false, true,  "");

                        if(response!=false){

                            if(response.retorno == 0){

                                Client.loadRequest(response);

                            }else{

                                Alert.showWarning(response.descRetorno, "");

                            }
                        }

                    } else {

                        Client.loadOffers(response);
                    }
                    $("#approbation").collapse('show');

                break;

                case 9:

                  /*Cliente Sin Ofertas Vigentes no puede Continuar*/
                  Alert.showWarning("Preste Atención","Cliente no registra Oferta","sm");
                  Client.prepare();

                break;

                case 10:

                  /*Condicion Invalidante para Continuar*/
                  Alert.init();Alert.showSearch("",response.descRetorno);

                break;

                case 11:

                  if(evaluation.source=="valid") {

                        var formData = new FormData();
                        formData.append("id",evaluation.idDocument);

                        var response = Teknodata.call_ajax("/advance/get_requestById", formData, false, true,  "");

                        if(response!=false){

                            if(response.retorno == 0){

                                    Client.loadRequest(response);
                            }else{

                                    Alert.showWarning(response.descRetorno, "");
                            }
                        }
                        $("#approbation").collapse('show');

                  } else {

                        Alert.init();Alert.showRequest(response.titleRequest,response.htmlRequest);
                  }

                break;

                default:

                        Alert.showToastrError(response);

                break;
                }

            }

        },

        initAuthorization: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPayOne").prop("disabled", true); $("#formPayTwo").prop("disabled", true);
        },
        initExecutive: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-print").prop('disabled', true);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', true);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPayOne").prop("disabled", true); $("#formPayTwo").prop("disabled", true);
        },
        initPrint: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPayOne").prop("disabled", true); $("#formPayTwo").prop("disabled", true);
        },
        initSend: function () {
            $(".btn-simulate").prop('disabled', true);$(".btn-save").prop('disabled', true);$(".btn-print").prop('disabled', false);$(".btn-confirm").prop('disabled', false);$(".btn-send").prop('disabled', false);$("#secureOne").prop("disabled", true);$("#secureTwo").prop("disabled", true); $("#formPayOne").prop("disabled", true); $("#formPayTwo").prop("disabled", true);
        },
        init: function() {
            $.validator.addMethod("evalrut", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRut( value );
            });
            $('#form-client').validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                unhighlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.search();
                },
                rules: {
                    masked_rut_client: {required: false, evalrut: true, minlength: 5, maxlength: 12},
                },
                messages: {
                    masked_rut_client: {required:'Ingrese número RUT', evalrut:'Ingrese RUT valido!'},
                }
            });
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare(); });
</script>
</body>
</html>
