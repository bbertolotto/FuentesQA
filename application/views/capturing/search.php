<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">
    <ul class="breadcrumb breadcrumb-top">
        <li><strong><?= $this->lang->line('Capturing Flows');?></strong></li>
        <li><strong><?= $this->lang->line('Search');?></strong></li>
        <li><a href="/capturing/preapproved"><strong><?= $this->lang->line('Capturing');?></strong></a></li>
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
              <h2><strong><?= $this->lang->line('Capturing Flows');?> Tarjeta Cruz Verde</strong> </h2>
          </div>
          <!-- END Typeahead Title -->

                <form id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">

                    <fieldset>

                        <div class="form-group col-sm-2">
                            <label for="nroRut">N&#250;mero RUT Cliente</label>
                            <input type="text" id="nroRut" name="nroRut" maxlength="12" class="form-control text-center" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this)" ></input>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="numberRequest">N&#250;mero Captaci&oacute;n</label>
                            <input type="text" id="numberRequest" name="numberRequest" maxlength="10" class="form-control text-center" placeholder="" onkeypress="return Teknodata.masked_onlyNumber(event);" ></input>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="officeSkill">Sucursal</label>
<?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):?>
                            <select id="officeSkill" name="officeSkill" class="form-control text-center" disabled>
                                <option value="" selected>TODAS</option>
                                <?php echo $dataOffice["optionOffice"] ?>
                            </select>
<?php else:?>
                            <select id="officeSkill" name="officeSkill" class="form-control text-center">
                                <option value="" selected>TODAS</option>
                                <?php echo $dataOffice["optionOffice"] ?>
                            </select>
<?php endif;?>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="typeRequestSkill">Estado Captaci&oacute;n </label>
                            <select id="typeRequestSkill" name="typeRequestSkill" class="form-control text-center">
                                <option value="">TODOS</option>
                                <option value="PE">PENDIENTES</option>
                                <option value="AC">APROBADAS</option>
                                <option value="EM">EMBOZADAS</option>
                                <option value="RE">RECHAZADA</option>
                                <option value="AC">ACTIVADAS</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="">Fecha Desde</label>
                            <div class="input-group">
                                <input type="text" id="dateBegin" name="dateBegin" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y")?>">
                                <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="">Fecha Hasta</label>
                            <div class="input-group">
                                <input type="text" id="dateEnd" name="dateEnd" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y");?>">
                                <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                            </div>
                        </div>

                    </fieldset>

                  <div class="form-group text-center">
                      <button type="submit" class="btn-search btn btn-success" data-target="search"><i class="fa fa-search"></i> Buscar</button>
                      <button type="button" class="btn btn-warning" onclick="Client.clearInput();"><i class="gi gi-refresh"></i> Limpiar</button>
                  </div>

                </form>
          <!-- END Typeahead Content -->
      </div>
      <!-- END Typeahead Block -->
    </div>

    <div class="row" id="client-details" >

      <div class="block">
          <div class="block-title">
              <h2><strong>Detalle</strong><span id="nombrecliente"></span> <strong> Captaciones en Proceso</strong></h2>
          </div>
          <table id="response" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                        <th class="text-left">N&uacute;mero</th>
                        <th class="text-center">Origen</th>
                        <th class="text-center">Rut</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Ejecutivo</th>
                        <th class="text-center">Fecha Creaci&#243;n</th>
                        <th class="text-center">Sucursal</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Situaci&#243;n</th>
                        <th class="text-center">Acci&#243;n</th>
                        <th class="text-center">Resultado</th>
                      </tr>
                  </thead>
                  <tbody>
                </table>
      </div>
</div>
<!--END row-->
</div>
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalValid'); ?>
<!-- End page-content-->

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/capturing/Search.js"></script>
</body>
</html>
