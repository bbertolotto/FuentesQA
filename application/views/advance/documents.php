<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>

<div id="page-content">
    <ul class="breadcrumb breadcrumb-top">
        <li>Flujos Comerciales</li>
        <li>S&#250;per Avances</li>
        <li>Documentos</a></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
      <div class="col-md-12">

          <div class="block">
              <div class="block-title">
                  <div class="block-options pull-right">
                      <h2>Modo: <strong><?= $this->session->userdata('attention_mode');?></strong></h2>
                  </div>
                  <h2><strong>Impresi&#243;n Documentos S&#250;per Avance</strong></h2>
              </div>

              <form id="form-valid" method="post" class="form-horizontal form-bordered form-control-borderless">

                <fieldset><legend><i class="fa fa-angle-right"></i><strong>Identificaci&#243;n Cliente</strong></legend></fieldset>
                <div class="form-group">
                    <label class="col-md-2 control-label">N&#250;mero RUT</label>
                    <div class="col-md-2 text-right">
                        <div class="input-group">
                            <label class="control-label"><?php echo (isset($dataRequest['nroRut']) ? $dataRequest['nroRut']."-".$dataRequest['dgvRut'] : MSG_FIELD_EMPTY); ?></label>
                        </div>

                    </div>
                    <label class="col-md-2 control-label ">Nombre</label>
                    <div class="col-md-4">
                        <div class="input-group col-xs-8">
                            <label class="control-label"><?php echo (isset($dataRequest['nameClient']) ? $dataRequest['nameClient'] : MSG_FIELD_EMPTY); ?></label>
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
                                <td><?php echo (isset($dataRequest['plazoDeCuota']) ? $dataRequest['plazoDeCuota'] : MSG_FIELD_EMPTY); ?></td>
                                <td >
                                    <strong>Cuotas Diferidas</strong>
                                </td>

                                <td><?php echo (isset($dataRequest['mesesDiferidos']) ? $dataRequest['mesesDiferidos'] : MSG_FIELD_EMPTY); ?></td>

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
                                <td>$<?php echo (isset($dataRequest['valorDeCuota']) ? $dataRequest['valorDeCuota'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Monto Bruto</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['montoBruto']) ? $dataRequest['montoBruto'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Monto L&#237;quido</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['montoLiquido']) ? $dataRequest['montoLiquido'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                    <strong>Costo Total</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['costoTotalDelCredito']) ? $dataRequest['costoTotalDelCredito'] : MSG_FIELD_EMPTY); ?></td>
                            </tr>
                            <tr>
                                <td>
                                  <strong>Impuesto</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['impuestos']) ? $dataRequest['impuestos'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Comisi&#243;n</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['comision']) ? $dataRequest['comision'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>CAE</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['cargaAnualEquivalente']) ? $dataRequest['cargaAnualEquivalente'] : MSG_FIELD_EMPTY); ?></td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Hospitalización</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['costoTotalSeguro1']) ? $dataRequest['costoTotalSeguro1'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Desgravamen</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['costoTotalSeguro2']) ? $dataRequest['costoTotalSeguro2'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Forma de Pago</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['glosaModoEntrega']) ? $dataRequest['glosaModoEntrega'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Modo Atenci&oacute;n</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['modalidadVenta']) ? $dataRequest['modalidadVenta'] : MSG_FIELD_EMPTY); ?></td>

                            </tr>
                        </tbody>
                    </table>

                </div>
              </div>


              <div class="col-sm-12 col-lg-12">
              <div class="block">
                  <div class="block-title">
                      <h2><i class="gi gi-print"></i> Documentos</h2>
                  </div>

                  <div class="col-md-6">
                      <div class="block-section">
                          <h4 class="sub-header">Legales</h4>
                      </div>

                      <div class="col-sm-6 col-lg-6">
                          <div class="media-items animation-fadeInQuickInv" data-category="photo">
                              <div class="media-items-options text-left">
                                  <!--href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a-->
                                  <a href="/advance/get_PDF/<?=$dataRequest['idDocument']?>/CON" target="_blank" class="btn btn-xs btn-danger" ><i class="fa fa-search"></i></a>
                              </div>
                              <div class="media-items-content">
                                  <i class="fi fi-pdf fa-5x text-success"></i>
                              </div>
                              <h4>
                                  <strong>Contrato</strong>.pdf<br>
                              </h4>
                          </div>
                      </div>

                      <div class="col-sm-6 col-lg-6">
                          <div class="media-items animation-fadeInQuickInv" data-category="photo" >
                              <div class="media-items-options text-left">
                                  <!--a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a-->
                                  <a href="/advance/get_PDF/<?=$dataRequest['idDocument']?>/COT" target="_blank" class="btn btn-xs btn-danger" ><i class="fa fa-search"></i></a>
                              </div>
                              <div class="media-items-content">
                                  <i class="fi fi-pdf fa-5x text-success"></i>
                              </div>
                              <h4>
                                  <strong>Hoja Resumen</strong>.pdf<br>
                              </h4>
                          </div>
                      </div>

                  </div>


                  <div class="col-md-6">
                      <div class="block-section">
                          <h4 class="sub-header">Seguros</h4>
                      </div>
<?php if($dataRequest['flagSeguro1']=="CON SEGURO"):?>
                      <div class="col-sm-6 col-lg-6">
                          <div class="media-items animation-fadeInQuickInv" data-category="photo">
                              <div class="media-items-options text-left">
                                  <!--a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a-->
                                  <a href="/advance/get_PDF/<?=$dataRequest['idDocument']?>/PRO" target="_blank" class="btn btn-xs btn-danger" ><i class="fa fa-search"></i></a>
                              </div>
                              <div class="media-items-content">
                                  <i class="fi fi-pdf fa-5x text-success"></i>
                              </div>
                              <h4>
                                  <strong>Hospitalización por Accidente (ex Enfermedades Graves)</strong>.pdf<br>
                              </h4>
                          </div>
                      </div>
<?php endif;?>

<?php if($dataRequest['flagSeguro2']=="CON SEGURO"):?>
                      <div class="col-sm-6 col-lg-6">
                          <div class="media-items animation-fadeInQuickInv" data-category="photo" >
                              <div class="media-items-options text-left">
                                  <!--a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a-->
                                  <a href="/advance/get_PDF/<?=$dataRequest['idDocument']?>/DES" target="_blank" class="btn btn-xs btn-danger" ><i class="fa fa-search"></i></a>
                              </div>
                              <div class="media-items-content">
                                  <i class="fi fi-pdf fa-5x text-success"></i>
                              </div>
                              <h4>
                                  <strong>Desgravamen (ex Vida y desgravamen)</strong>.pdf<br>
                              </h4>
                          </div>
                      </div>
<?php endif;?>

                  </div>

                  <div class="form-group">


                </div>

              </div>
            </div>

            <div class="form-group text-center">
                <div class="col-xs-12">
<?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):?>
        <button type="button" class="btn-action btn btn-success" data-target="accept"><i class="fa fa-check"></i> Aceptar</button>
        <button type="button" class="btn-action btn btn-danger" data-target="deny" ><i class="fa fa-times"></i> Marcar Pendiente</button>
<?php else:?>
        <button type="button" class="btn-action btn btn-success" data-target="accept" disabled><i class="fa fa-check"></i> Aceptar</button>
        <button type="button" class="btn-action btn btn-danger" data-target="deny" disabled><i class="fa fa-times"></i> Marcar Pendiente</button>
<?php endif;?>
              <button type="button" class="btn-action btn btn-info" data-target="return" data-action="<?=base_url()?>trade/create"><i class="fa fa-refresh"></i> Volver</button>

              </div>
            </div>

            </form>

            </div>
            <!--End Block principal-->


        </div>
        <!--End col-md-12-->
      </div>
      <!--End row-->
<input type="hidden" id="idDocument" value="<?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : 0); ?>">
<input type="hidden" id="nroRut" value="<?php echo (isset($dataRequest['nroRut']) ? $dataRequest['nroRut']."-".$dataRequest['dgvRut'] : 0); ?>">
<input type="hidden" id="tipoEstado" value="<?php echo (isset($dataRequest['tipoEstado']) ? $dataRequest['tipoEstado'] : ""); ?>">
</div>
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalValid'); ?>
<?php $this->load->view('ModalCreate'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/advance/Documents.js"></script>
</body>
</html>
