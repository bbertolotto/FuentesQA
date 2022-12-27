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
        <li>Autorizaci&#243;n</li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
      <div class="col-md-12">
          <div class="block">
              <div class="block-title">
                  <h2><strong>Autorizaci&#243;n Remota</strong></h2>
              </div>

              <form id="form-valid" method="post" class="form-horizontal form-bordered form-control-borderless">

                <fieldset><legend><i class="fa fa-angle-right"></i><strong>Identificaci&#243;n Cliente</strong></legend></fieldset>
                <div class="form-group">
                    <label class="col-md-2 control-label">N&#250;mero RUT</label>
                    <div class="col-md-2 text-right">
                        <div class="input-group">
                            <label class="control-label"><?php echo (isset($dataCliente['nroRut']) ? $dataCliente['nroRut'] : MSG_FIELD_EMPTY); ?></label>
                        </div>
                    </div>
                    <label class="col-md-2 control-label ">Nombre</label>
                    <div class="col-md-4">
                        <div class="input-group col-xs-8">
                            <label class="control-label"><?php echo (isset($dataCliente['nombreCliente']) ? $dataCliente['nombreCliente'] : MSG_FIELD_EMPTY); ?></label>
                        </div>
                    </div>
                    <label class="col-md-1 control-label ">Nº</label>
                    <div class="col-md-1">
                        <div class="input-group col-xs-8">
                            <label class="control-label"><?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : MSG_FIELD_EMPTY); ?></label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-12">
                <div class="block">
                    <div class="block-title">
                        <h2><i class="gi gi-charts"></i> Negociaci&#243;n con Cliente</h2>
                    </div>
                    <table class="table table-sm table-striped table-bordered">
                        <tbody>
                            <tr>
                                <td >
                                    <strong>N&#250;mero Cuotas</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['numeroCuotas']) ? $dataRequest['numeroCuotas'] : MSG_FIELD_EMPTY); ?></td>
                                <td >
                                    <strong>Cuotas Diferidas</strong>
                                </td>
  
                                <td><?php echo (isset($dataRequest['diferidas']) ? $dataRequest['diferidas'] : MSG_FIELD_EMPTY); ?></td>

                                <td >
                                    <strong>Primer Vencimiento</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['fechaPrimerVencimiento']) ? $dataRequest['fechaPrimerVencimiento'] : MSG_FIELD_EMPTY); ?></td>
                                <td >
                                    <strong>Tasa</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['tasaDeInteresMensual']) ? $dataRequest['tasaDeInteresMensual'] : MSG_FIELD_EMPTY); ?></td>
                            </tr>
                            <tr>
                                <td>
                                  <strong>Valor Cuota</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['valorCuota']) ? $dataRequest['valorCuota'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Monto Bruto</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['montoBruto']) ? $dataRequest['montoBruto'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Monto L&#237;quido</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['montoLiquido']) ? $dataRequest['montoLiquido'] : MSG_FIELD_EMPTY); ?></td>
                                <td colspan=2></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Costo Total</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['costoTotal']) ? $dataRequest['costoTotal'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Impuesto</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['impuesto']) ? $dataRequest['impuesto'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Comisi&#243;n</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['comision']) ? $dataRequest['comision'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>CAE</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['cae']) ? $dataRequest['cae'] : MSG_FIELD_EMPTY); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Enfermedades Graves</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['seguroEnfermedadesCostoTotal']) ? $dataRequest['seguroEnfermedadesCostoTotal'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Desgravamen</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['seguroVidaCostoTotal']) ? $dataRequest['seguroVidaCostoTotal'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Forma de Pago</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['formaDePago']) ? $dataRequest['formaDePago'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Oficina Pago</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['oficinaDePago']) ? $dataRequest['oficinaDePago'] : MSG_FIELD_EMPTY); ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
              </div>


              <div class="col-sm-12 col-lg-12">
              <div class="block">
                  <div class="block-title">
                      <h2><i class="fa fa-check"></i> Validaci&#243;n Respuestas Cliente</h2>
                  </div>
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
                                    <i class="fa fa-check"></i>Resultado Consulta cedula de identidad (confirme n&#250;mero de serie)</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesSerie" type="checkbox" checked onclick="other=document.getElementById('noSerie');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noSerie" type="checkbox" onclick="other=document.getElementById('yesSerie');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label"><h5><strong><?php echo (isset($dataCliente['nroSerie']) ? $dataCliente['nroSerie'] : MSG_FIELD_EMPTY); ?></strong></h5></label>
                              </td>

                          </tr>

                          <tr>
                              <td class="text-right" nowrap>
                                  <strong>
                                    <i class="fa fa-check"></i>Resultado Validaci&#243;n Nombre Completo</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesNameClient"  type="checkbox" checked onclick="other=document.getElementById('noNameClient');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noNameClient" type="checkbox" onclick="other=document.getElementById('yesNameClient');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label"><h5><strong><?php echo (isset($dataCliente['nombreCliente']) ? $dataCliente['nombreCliente'] : MSG_FIELD_EMPTY); ?></strong></h5></label>
                              </td>

                          </tr>

                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="fa fa-check"></i>Resultado Validaci&#243;n Fecha Nacimiento</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesFechaNacimiento" type="checkbox" checked onclick="other=document.getElementById('noFechaNacimiento');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noFechaNacimiento" type="checkbox" onclick="other=document.getElementById('yesFechaNacimiento');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label"><h5><strong><?php echo (isset($dataCliente['fechaNacimiento']) ? $dataCliente['fechaNacimiento'] : MSG_FIELD_EMPTY); ?></strong></h5></label>
                              </td>

                          </tr>

                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="fa fa-check"></i>Usted tiene tarjeta Adicional en su tarjeta Cruz Verde</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesTarjetaAdic" type="checkbox" checked onclick="other=document.getElementById('noTarjetaAdic');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noTarjetaAdic"  type="checkbox" onclick="other=document.getElementById('yesTarjetaAdic');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label"><h5><strong><?php echo (isset($dataADI['numeroAdi']) ? "Registra ". $dataADI['numeroAdi'] ." adicionales " : MSG_FIELD_EMPTY); ?></strong></h5></label>
                              </td>

                          </tr>

                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="fa fa-check"></i><?php echo (isset($dataCuenta['tipoDespacho']) ? $dataCuenta['glosaDespacho'] : MSG_FIELD_EMPTY); ?></strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesDispatch" type="checkbox" checked onclick="other=document.getElementById('noDispatch');let result = this.checked ? other.checked = false: other.checked = true; document.getElementById('optional').style.display='none';"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noDispatch" type="checkbox" onclick="other=document.getElementById('yesDispatch');let result = this.checked ? other.checked = false: other.checked = true; document.getElementById('optional').style.display=''; "><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label"><h5>
                                <strong>
                                <?php if($dataCuenta["tipoDespacho"]=="EMAIL"):?>   
                                <?php echo "correo@solventa.cl"; ?>
                                <?php else: echo (isset($dataDireccion["direccionHome"]) ? $dataDireccion["direccionHome"]: $dataDireccion["direccionWork"]); endif;?>
                                </strong></h5></label>
                              </td>

                          </tr>
                        </tbody>   
                       </table>

                  <table class="table table-striped table-borderless table-vcenter" id="optional" style="display:none;">
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
                                    <i class="gi gi-warning_sign"></i> Fecha de su &#250;ltima compra?</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesFechaUltCompra" type="checkbox" checked onclick="other=document.getElementById('noFechaUltCompra');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noFechaUltCompra" type="checkbox" onclick="other=document.getElementById('yesFechaUltCompra');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label"><h5>
                                <strong>
                                <label class="control-label"><h5><strong><?php echo (isset($dataUltTRX['ultimaTRXCargo']) ? $dataUltTRX['ultimaTRXCargo'] : MSG_FIELD_EMPTY); ?></strong></h5></label>
                                </strong></h5></label>
                              </td>
                          </tr>

                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="gi gi-warning_sign"></i> Indiqueme d&#237;a de vencimiento del estado de cuenta mensual de su Tarjeta Cruz Verde</strong>
                              </td>
                              <td class="text-center">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesDiaVencimiento" type="checkbox" checked onclick="other=document.getElementById('noDiaVencimiento');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="noDiaVencimiento" type="checkbox" onclick="other=document.getElementById('yesDiaVencimiento');let result = this.checked ? other.checked = false: other.checked = true;"><span></span></label>
                              </td>
                              <td class="text-left">
                                <label class="control-label"><h5>
                                <strong>
                                <label class="control-label"><h5><strong><?php echo (isset($dataEECC['fechaVencimiento']) ? substr($dataEECC['fechaVencimiento'],0,2) : MSG_FIELD_EMPTY); ?></strong></h5></label>
                                </strong></h5></label>
                              </td>
                          </tr>


                      </tbody>
                  </table>
              </div>
            </div>

            <div class="form-group text-center">
                <div class="col-xs-12">
                  <button type="button" class="btn-accept btn btn-danger"  ><i class="fa fa-check"></i> Confirma Aprobaci&#243;n</button>
                  <button type="button" class="btn-reset btn btn-info " ><i class="fa fa-refresh"></i> Cancelar</button>
                </div>
            </div>

          </div>

        </div>
        </form>
    </div>
    <!--End Block principal-->
<input type="hidden" id="idDocument" value="<?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : '0'); ?>">
</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>
<!-- Javascript exclusivos para esta página -->

<script src="/js/pages/Alert.js"></script>
<script src="/js/advance/Approbation.js"></script>
</body>
</html>
