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
              <h2>Modo: <strong><?= $this->session->userdata('attention_mode');?></strong></h2>
          </div>
          <h2><strong>Identificaci&#243;n</strong> Cliente</h2>
      </div>

      <form name="form-client" id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless form-inline">

        <div class="form-group">
          <label>Rut Cliente <span class="text-danger">*</span></label>
          <div class="input-group">
             <input type="text" style="width:120px" id="masked_rut_client" readonly value="<?= $dataLoad['nroRut']."-".$dataLoad['dgvRut'] ?>" name="masked_rut_client" maxlength="12" class="form-control text-center" onkeyup="masked_nroRut(this);">
          </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <button type="submit" class="btn btn-success" disabled><i class="fa fa-search"></i> Buscar</button>
                <button type="reset" class="btn btn-warning" diabled><i class="fa fa-repeat"></i> Limpiar</button>
            </div>
        </div>

        <div class="form-group">
          <label>&nbsp;&nbsp;Cliente </label>
          <div class="input-group">
            <input type="text" style="width:300px" id="label_nameClient" value="<?= $dataLoad['nameClient']?>" name="label_nameClient" class="form-control" readonly></input>
          </div>
        </div>

      </form>
      <br>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="block">
      <div class="block-title">
          <div class="block-options pull-right">
              <!--a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Settings"><i class="gi gi-calculator"></i></a-->
          </div>
          <h2><strong>Condiciones Negociaci&#243;n</strong></h2>
      </div>

      <form name="form-simulate" id="form-simulate" method="post" class="form-inline" >

          <div class="form-group">
          <label>Aprobado <span class="text-danger">*</span></label>
          <?php if($dataLoad["tipoOferta"]=="AP"):?>
            <div class="input-group">
               <span class="input-group-addon"><input type="checkbox" id="checkAmountApproved" disabled checked></i></span>
               <input type="text" id="amountApproved" style="width:100px" name="amountApproved" value="<?= $dataLoad['montoLiquido']?>" readonly class="form-control text-center" data-toggle="tooltip" data-placement="bottom">
            </div>
          <?php else:?>
            <div class="input-group">
               <span class="input-group-addon"><input type="checkbox" id="checkAmountApproved" disabled></i></span>
               <input type="text" id="amountApproved" style="width:100px" name="amountApproved" value="$0" readonly class="form-control text-center" data-toggle="tooltip" data-placement="bottom">
            </div>
          <?php endif;?>
          </div>

          <div class="form-group">
          <label>&nbsp;&nbsp;Pre-Aprobado <span class="text-danger">*</span></label>
          <?php if($dataLoad["tipoOferta"]=="AP"):?>
            <div class="input-group">
               <span class="input-group-addon"><input type="checkbox" id="checkAmountPreApproved" disabled></i></span>
              <input type="text" id="amountPreApproved" style="width:100px" name="amountPreApproved" value="$0" class="form-control text-center" readonly>
            </div>
         <?php else:?>
            <div class="input-group">
               <span class="input-group-addon"><input type="checkbox" id="checkAmountPreApproved" checked disabled></i></span>
              <input type="text" id="amountPreApproved" style="width:100px" name="amountPreApproved" value="<?= $dataLoad['montoLiquido']?>" readonly onkeyup="Teknodata.formatMoneda(0);" onchange="Teknodata.formatMoneda(this);" class="form-control text-center" disabled>
            </div>
         <?php endif;?>

          </div>
          <div class="form-group">
            <label>&nbsp;&nbsp;Nº Cuotas <span class="text-danger">*</span></label>
            <div class="input-group">
                <input id="numberQuotas" style="width:80px" value="<?= $dataLoad['plazoDeCuota']?>" readonly class="form-control text-center">
            </div>

          </div>
          <div class="form-group">

            <label>&nbsp;&nbsp;Nº Diferidos <span class="text-danger">*</span></label>
            <div class="input-group">
              <input id="deferredQuotas" style="width:80px" value="<?= $dataLoad['mesesDiferidos']?>" readonly class="form-control text-center">
            </div>

          </div>


          <div class="form-group">

            <label>&nbsp;&nbsp;Tasa</label>
            <div class="input-group">
              <input type="text" id="interesRate" style="width:60px" name="interesRate" class="form-control text-center" value="<?=$dataLoad['tasaDeInteresMensual']?>" readonly >
            </div>

            <label>&nbsp;&nbsp;Vencimiento</label>
            <div class="input-group">
              <input type="text" id="dateFirstExpiration" style="width:90px" name="dateFirstExpiration" value="<?=$dataLoad['fechaPrimerVencimiento']?>" class="form-control text-center" readonly >
            </div>

            <label>&nbsp;&nbsp;&nbsp;</label>
            <button type="submit" class="btn-simulate btn btn-danger" disabled><i class="gi gi-calculator"></i> Simular </button>
          </div>
      </form>
      <br>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="block">
      <div class="block-title">
        <?php if($dataLoad['flagSeguro1']=="CON SEGURO"):?>
          <label class="switch switch-success checkbox-inline"><input name="success" type="checkbox" checked disabled><span></span>
          <h2><strong><?= $dataLoad['nameSeguro1']?>&nbsp;<label id="labelsecureOne">[ACEPTADO]</label></strong></h2> </label>
        <?php else:?>
          <label class="switch switch-success checkbox-inline"><input name="success" type="checkbox" disabled><span></span>
          <h2><strong>&nbsp;<label id="labelsecureOne">HOSPITALIZACIÓN [RECHAZADO]</label></strong></h2> </label>
        <?php endif;?>

          <div class="block-options pull-right">
              <a href="#secure1" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
          </div>
      </div>

      <div class="collapse multi-collapse" id="secure1">

        <div class="form-group">
          <medium>Autorizo que toda comunicaci&#243;n y notificaci&#243;n que tenga realaci&#243;n con el presente seguro me sea enviado al correo electr&#243;nico se&#241;alado en esta solicitud de incorporaci&#243;n</medium>
          <ul class="fa-ul list-li-push">
              <li>
                <?php if($dataLoad["useEmail1"]==1):?>
                  <label class="checkbox-inline"><input type="checkbox" id="yesEmailSecureOne" checked disabled> Sí</label>
                  <label class="checkbox-inline"><input type="checkbox" id="noEmailSecureOne" disabled> No</label>
                <?php else: ?>
                  <label class="checkbox-inline"><input type="checkbox" id="yesEmailSecureOne" disabled> Sí</label>
                  <label class="checkbox-inline"><input type="checkbox" id="noEmailSecureOne" checked disabled> No</label>
                <?php endif; ?>
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
        <?php if($dataLoad['flagSeguro2']=="CON SEGURO"):?>
          <label class="switch switch-success checkbox-inline"><input name="success" type="checkbox" checked disabled><span></span>
          <h2><strong><?= $dataLoad['nameSeguro2']?>&nbsp;<label id="labelsecureTwo">[ACEPTADO]</label></strong></h2> </label>
        <?php else:?>
          <label class="switch switch-success checkbox-inline"><input name="success" type="checkbox" disabled><span></span>
          <h2><strong>&nbsp;<label id="labelsecureOne">DESGRAVAMEN [RECHAZADO]</label></strong></h2> </label>
        <?php endif;?>

        <div class="block-options pull-right">
            <a id="sel_secure_2" href="#secure2" class="btn btn-alt btn-sm btn-primary" name="success" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
        </div>
      </div>

      <div class="collapse multi-collapse" id="secure2">

        <p>Autorizo que toda comunicaci&#243;n y notificaci&#243;n que tenga realaci&#243;n con el presente seguro me sea enviado al correo electr&#243;nico se&#241;alado en esta solicitud de incorporaci&#243;n</p>
        <ul class="fa-ul list-li-push">
            <li>
            <?php if($dataLoad["useEmail2"]==1): ?>
                <label class="checkbox-inline"><input type="checkbox" id="yesEmailSecureTwo" checked disabled> Sí</label>
                <label class="checkbox-inline"><input type="checkbox" id="noEmailSecureTwo"  disabled> No</label>
            <?php else: ?>
                <label class="checkbox-inline"><input type="checkbox" id="yesEmailSecureTwo" disabled> Sí</label>
                <label class="checkbox-inline"><input type="checkbox" id="noEmailSecureTwo" checked disabled> No</label>
            <?php endif; ?>
            </li>
        </ul>

      </div>

    </div>
  </div><!--End col-md-6-->

</div>

<div class="row">
  <div class="col-md-12">
    <div class="block">
      <div class="block-title"><h2><strong>Detalle Ofertas</strong></h2>
        <div class="block-options pull-right">
            <a href="#simulate" class="btn btn-alt btn-sm btn-primary" data-toggle="collapse"><i class="fa fa-arrows-v text-success"></i></a>
        </div>
      </div>

      <div class="multi-collapse" id="simulate">

          <table class="table table-sm table-striped table-bordered" style="width:100%" id="tabSimulate">
          <?php echo $dataLoad['htmlSimulate']?>
          </table>
      </div>
  </div>
</div>
</div>

<div class="row">

    <div class="col-md-12">

          <div class="block">
            <div class="block-title">
                <h2><strong>Forma de Pago</strong></h2>
           <?php if ($dataLoad['modoEntrega'] == "TEF"):?>
                <label class="switch switch-success checkbox-inline"><input id="formPayOne" type="checkbox"  checked disabled><span></span><h2><strong>Trasferencia</strong></h2></label>
                <label class="switch switch-success checkbox-inline"><input id="formPayTwo" type="checkbox" disabled><span></span><h2><strong>Efectivo </strong></h2></label>
           <?php else:?>
                <label class="switch switch-success checkbox-inline"><input id="formPayOne" type="checkbox"  disabled><span></span><h2><strong>Trasferencia</strong></h2></label>
                <label class="switch switch-success checkbox-inline"><input id="formPayTwo" type="checkbox" checked disabled><span></span><h2><strong>Efectivo </strong></h2></label>
           <?php endif;?>
            </div>

            <!--Begin Section Forma de Pago-->
            <div class="multi-collapse" id="payment">

              <table class="table">

                <div id="transfer" class="col-sm-12">


                    <div class="col-md-4">
                        <label for="bank">Banco <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <select name="bank" id="bank" style="width:200px" disabled class="form-control">
                              <option value="">[Seleccione Banco]</option>
                              <?php foreach (listBancos() as $key) { ?>
                                  <option style="width:200px" value="<?= $key->ID ?>"><?= $key->NAME ?></option>
                              <?php } ?>
                          </select>
<script>
document.getElementById("bank").value="<?=$dataLoad['banco']?>";
</script>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="account">Tipo de Cuenta <span class="text-danger">*</span></label>
                        <div class="input-group">

                          <select name="typeAccount" id="typeAccount" style="width:200px" disabled class="form-control">
                              <option value="">[Tipo Cuenta]</option>
                              <?php foreach (listTipoCuentas() as $key) { ?>
                                  <option style="width:200px" value="<?= $key->ID ?>"><?= $key->NAME ?></option>
                              <?php } ?>
                          </select>
<script>
document.getElementById("typeAccount").value="<?=$dataLoad['tipoCuenta']?>";
</script>

                        </div>
                    </div>

                    <div class="col-md-4">
                      <label for="accountNumber">N&#250;mero de Cuenta <span class="text-danger">*</span></label>
                        <div class="input-group  col-sm-9">
                            <input id="numberAccount" class="form-control" disabled value="<?= $dataLoad['numeroCuenta']?>" ></input>
                        </div>
                    </div>

                  </div>
              </table>

            </div>
            <!--End Section Forma de Pago-->

          </div>
    </div>

    <!--Begin Botones de Control Formulario-->
    <div class="form-group text-center">
      <button type="button" style="width:150px" class="btn-save btn btn-success" disabled><i class="fa fa-floppy-o"></i> Grabar </button>
      <button type="button" style="width:150px" class="btn-linked btn btn-success" disabled><i class="gi gi-link"></i> Enlazar </button>
<?php if($this->session->userdata["owner"]==1):?>
      <button type="button" style="width:150px" class="btn-confirm btn btn-success" ><i class="gi gi-hand_right"></i> Confirmar </button>
      <button type="button" style="width:150px" class="btn-print btn btn-success" ><i class="gi gi-print"></i> Imprimir </button>
<?php else:?>
      <button type="button" style="width:150px" class="btn-confirm btn btn-success" disabled><i class="gi gi-hand_right"></i> Confirmar </button>
      <button type="button" style="width:150px" class="btn-print btn btn-success" disabled><i class="gi gi-print"></i> Imprimir </button>
<?php endif;?>
      <button type="button" style="width:150px" class="btn-send btn btn-success" disabled><i class="gi gi-send"></i> Enviar por Email</button>
    </div>
    <!--End Botones de Control Formulario-->




</div>

<input type="hidden" id="idDocument" value="<?= $dataLoad['idDocument']?>">
<input type="hidden" id="idEstado" value="<?= $dataLoad['estado']?>">
<input type="hidden" id="tasaMaxima" value="<?= $dataLoad['tasaMaxima']?>">
<input type="hidden" id="tasaRequest" value="<?= $dataLoad['tasaRequest']?>">
<input type="text" id="modeLoad" value="<?= $modeLoad?>">
</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/advance/CreateAssign.js"></script>
</body>
</html>
