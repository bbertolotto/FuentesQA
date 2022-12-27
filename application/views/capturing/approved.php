<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>

<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
      <li><strong><?= $this->lang->line('Capturing Flows');?></strong></li>
    </ul>

<?php if(isset($dataClient["nombres"])):?>

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Datos Personales</strong></h2>
                </div>

                <table class="table table-striped table-bordered">

            <form id="form-client" action="#" method="post" class="form-bordered" onsubmit="return false;">

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="rutClient">Nº de Rut</label>
                    <input type="text" id="rutClient" name="rutClient" maxlength="12" class="form-control text-center" placeholder="" onkeypress="return Teknodata.enter_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this)" value="<?= $dataClient['numdoc']?>" readonly></input>
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="example-nf-name">Nombres</label>
                    <input type="text" id="nameClient" name="nameClient" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $dataClient['nombres']?>" readonly >

                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="example-nf-lastnameFather">Apellido Paterno</label>
                      <input type="text" id="lastFatherClient" name="lastFatherClient" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $dataClient['apaterno']?>" readonly >
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="example-nf-lastnameMother">Apellido Materno</label>
                      <input type="text" id="lastMotherClient" name="lastMotherClient" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $dataClient['amaterno']?>" readonly >
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="rutClientSerie">Serie de CI <span class="text-danger">*</span></label>
                    <input type="text" id="rutClientSerie" name="rutClientSerie" class="form-control text-center"
                    onkeypress="return Teknodata.serial_onlyRut(event);" onKeyUp="this.value=this.value.toUpperCase();" maxlength="11">
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="">Fecha Nacimiento <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" id="birthDateClient" name="birthDateClient" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?= $dataClient['fechanac']?>">
                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                    </div>
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="sexClient">Sexo</label>
                    <select id="sexClient" name="sexClient" class="form-control text-center">
                        <option value="FEM">FEMENINO</option>
                        <option value="MAS" selected>MASCULINO</option>
                    </select>
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="civilClient">Estado Civil</label>
                    <select id="civilClient" name="civilClient" class="form-control text-center">
                        <option value="1">SOLTERO(A)</option>
                        <option value="2">CASADO(A)</option>
                        <option value="3">VIUDO(A)</option>
                        <option value="4">DIVORCIADO(A)</option>
                        <option value="5">SEPARADO(A)</option>
                        <option value="6">CONVIVENCIA</option>
                    </select>
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-1">
                    <label for="typeClient">Tipo</label>
                    <input type="text" id="typeClient" name="typeClient" class="form-control text-center" value="<?= $dataClient['tipopan']?>" readonly >
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-1">
                    <label for="scoreClient">Score</label>
                    <input type="text" id="scoreClient" name="scoreClient" class="form-control text-center" value="<?= $dataClient['score']?>" readonly >
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="nationality">Nacionalidad</label>
                    <select id="nationality" name="nationality" class="form-control text-center" onchange="Contact.checkNationality();">
                        <option value="CL">CHILENA</option>
                        <option value="OT">EXTRANJERO</option>
                    </select>
                </div>
                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="countryByOrigin">Pais de Origen</label>
                        <select id="countryByOrigin" name="countryByOrigin" class="form-control text-center"  >
                            <?php
                                echo '<option value=""></option>';
                                foreach ($countries as $nodo) {
                                    echo '<option value="'.$nodo->KEY.'">'.$nodo->NAME.'</option>';
                            }?>
                        </select>
                </div>

                <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                    <label for="countryResidence">Pais de Residencia</label>

                        <select id="countryResidence" name="countryResidence" class="form-control text-center" >
                            <?php
                                echo '<option value=""></option>';
                                foreach ($countries as $nodo) {
                                    echo '<option value="'.$nodo->KEY.'">'.$nodo->NAME.'</option>';
                            }?>
                        </select>

                </div>

            </form>

        </table>

        </div>
      </div>

  </div>

        <!--End col-md-12-->
        <div class="row">
            <div class="col-md-12">

            <div class="block">
                <div class="block-title">
                    <h2><strong>Direcciones</strong></h2>
                </div>


                <table class="table table-striped table-bordered">

                <form id="form-address" class="form-horizontal form-bordered" method="post" onsubmit="return false;">

                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="viaAddress">Tipo <span class="text-danger">*</span></label>
                        <select id="viaAddress" name="viaAddress" class="form-control text-center">
                            <?php
                                foreach ($viaAddress as $nodo) {
                                    echo '<option value="'.$nodo->KEY.'">'.$nodo->NAME.'</option>';
                            }?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="address">Direcci&#243;n <span class="text-danger">*</span></label>
                            <input type="text" id="address" name="address" class="form-control text-center"  onKeyUp="this.value=this.value.toUpperCase();" maxlength="40" >
                    </div>

                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="numberAddress">N&#250;mero <span class="text-danger">*</span></label>
                            <input type="text" id="numberAddress" maxlength="6" name="numberAddress" class="form-control text-center" placeholder="Número">
                    </div>

                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="numberFloor">Piso </label>
                            <input type="text" id="numberFloor" maxlength="4" name="numberFloor" class="form-control text-center" placeholder="Piso">
                    </div>


                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="numberDepart">Departamento</label>
                            <input type="text" id="numberDepart" maxlength="4" name="numberDepart" class="form-control text-center" placeholder="Departamento">
                    </div>

                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="numberBlock">Block</label>
                            <input type="text" id="numberBlock" maxlength="4" name="numberBlock" class="form-control text-center" placeholder="Block">
                    </div>

                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="address">Villa/Población/Otro <span class="text-danger">*</span></label>
                            <input type="text" id="complement" name="complement" class="form-control text-center"  onKeyUp="this.value=this.value.toUpperCase();" maxlength="30" >
                    </div>

                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="communeCode">Comuna <span class="text-danger">*</span></label>
                        <select id="communeCode" name="communeCode" class="form-control text-center">
                            <?php
                                echo '<option value=""></option>';
                                foreach ($communes as $nodo) {
                                    echo '<option value="'.$nodo->NAME.'">'.$nodo->NAME.'</option>';
                            }?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        <label for="postalCode">Código Postal</label>
                        <input type="text" id="postalCode" name="postalCode" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Código Postal" >
                    </div>

                </form>

                </table>

            </div>
        </div>
        <!--End col-md-5-->

    </div>
    <!--END row-->

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Datos de Contacto</strong></h2>
                </div>


                <table class="table table-striped table-bordered">

                <form id="form-phones" class="form-bordered" method="post" onsubmit="return false;">

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="numberPhone">Tel&#233;fono M&oacute;vil 1 <span class="text-danger">*</span></label>
                        <input type="text" id="numberPhone1" name="numberPhone1" class="form-control text-center" placeholder="Teléfono Móvil" maxlength="9">
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="numberPhone">Tel&#233;fono M&oacute;vil 2</label>
                        <input type="text" id="numberPhone2" name="numberPhone2" class="form-control text-center" placeholder=" Teléfono Móvil" maxlength="9">
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="numberPhone">Tel&#233;fono Particular 1</label>
                        <input type="text" id="numberPhone3" name="numberPhone3" class="form-control text-center" placeholder="Número Teléfono.." maxlength="9">
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="numberPhone">Tel&#233;fono Particular 2</label>
                        <input type="text" id="numberPhone4" name="numberPhone4" class="form-control text-center" placeholder="Número Teléfono.." maxlength="9">
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="clientEmail">Correo Electr&#243;nico 1 <span class="text-danger">*</span></label>
                        <input type="text" id="clientEmail1" name="clientEmail1" class="form-control minusculas text-center" placeholder="Correo Electrónico" maxlength="100">
                    </div>

                    <!--div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="clientEmail">Correo Electr&#243;nico 2</label>
                    </div-->
                    <input type="hidden" id="clientEmail2" name="clientEmail2" value="" class="form-control minusculas text-center" placeholder="Correo Electrónico" maxlength="100">

                  </table>

                </form>


            </div>
        </div>
        <!--End col-md-12-->
    </div>
    <!--END row-->

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Datos Tarjeta</strong></h2>
                </div>

                <table class="table table-striped table-bordered">

                <form id="form-card" class="form-bordered" method="post" onsubmit="return false;">

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="name_credit_card">Tipo Tarjeta </label>
                        <input type="text" id="name_credit_card" name="name_credit_card" class="form-control text-center" placeholder="Tipo Tarjeta" value="<?= $dataClient['desprod']?>" readonly >
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="number_credit_card">N&#250;mero Tarjeta </label>
                        <input type="text" id="masked_credit_card" name="masked_credit_card" class="form-control text-center" placeholder="Número Tarjeta" value="<?= "****-****-****-".substr($dataClient["pan"], -4);?>" readonly>
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="amount_credit_card">Cupo Asignado </label>
                        <input type="text" id="amount_credit_card" name="amount_credit_card" class="form-control text-center" placeholder="Cupo Tarjeta" value="<?= $dataClient['cupo']?>"readonly>
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="payment_day_credit_card">Día de Pago <span class="text-danger">*</span></label>
                        <select id="payment_day_credit_card" name="payment_day_credit_card" class="form-control text-center">
                            <?php
                                foreach ($diaspago as $nodo) {
                                    echo '<option value="'.$nodo->value.'">'.$nodo->name.'</option>';
                            }?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="contract_number_credit_card">Número de Contrato <span class="text-danger">*</span></label>
                        <input type="text" id="contract_number_credit_card" name="contract_number_credit_card" class="form-control text-center" maxlength="10" >
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="health_credit_card">Institución de Salud</label>
                        <select id="health_credit_card" name="health_credit_card" class="form-control text-center">
                            <?php
                                foreach ($isapres as $nodo) {
                                    echo '<option value="'.$nodo->KEY.'">'.$nodo->NAME.'</option>';
                            }?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="eeccEmail">Suscribe EECC por Email?<span class="text-danger">*</span></label>
                        <select id="eeccEmail" name="eeccEmail" class="form-control text-center">
                              <option value="">Seleccionar</option>
                              <option value="S">SI</option>
                              <option value="N">NO</option>
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="secure_credit_card">Seguro Desgravamen? <span class="text-danger">*</span></label>
                        <select id="secure_credit_card" name="secure_credit_card" class="form-control text-center">
                            <option value="">Seleccionar</option>
                            <option value="S">SI</option>
                            <option value="N">NO</option>
                        </select>
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-4">
                        <label for="remarks_credit_card">Observaci&oacute;n</label>
                        <input type="text" id="remarks_credit_card" name="remarks_credit_card" class="form-control" placeholder="Observaciones especiales del cliente" onKeyUp="this.value=this.value.toUpperCase();" maxlength="100">
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-4">
                        <label for="commandEmail">&nbsp;</label>
                        <div class="input-group">
                        <button type="button" class="btn-save btn btn-success"><i class="fa fa-arrow-right"></i> Grabar </button>
                        <button type="reset" class="btn-cancel btn btn-danger"><i class="fa fa-repeat"></i> Cancelar </button>
                        </div>
                    </div>

<input type="hidden" id="campaign_number" name="campaign_number" value="<?= $dataClient['numcam']?>">
<input type="hidden" id="payment_form_credit_card" name="payment_form_credit_card" value="03">
<input type="hidden" id="number_credit_card" name="number_credit_card" value="<?= $dataClient['pan']?>">
<input type="hidden" id="type_credit_card" name="type_credit_card" value="T<?= $dataClient['cod_producto']?>">
<input type="hidden" id="descam" name="descam" value="<?= $dataClient['descam']?>">
<input type="hidden" id="tipcam" name="tipcam" value="<?= $dataClient['tipcam']?>">


                </form>

                </table>

            </div>
        </div>
        <!--End col-md-12-->
    </div>
    <!--END row-->

<?php endif;?>
</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/capturing/approved.js"></script>

<?php if(!isset($dataClient["nombres"])): ?>
<script language="javascript">
var e = document.getElementById("body-modal-capturing");
$('.modal-capturing').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>

</body>
</html>
