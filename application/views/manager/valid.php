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
      <li>Liquidaci&#243;n</li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
      <div class="col-md-12">
          <div class="block">
              <div class="block-title">
                  <h2><strong>Liquidaci&#243;n</strong></h2>
              </div>
            </br>

            <form id="form-valid" method="post" class="form-horizontal form-bordered form-control-borderless">


              <div class="col-sm-12 col-lg-12">
              <div class="block">
                  <div class="block-title">
                      <h2><i class="fa fa-check"></i> Verifica Datos para el Pago</h2>
                  </div>
                  <table class="table table-sm table-striped table-bordered">
                      <tbody>
                          <tr>
                              <td >
                                  <strong>RUT</strong>
                              </td>
                              <td><?php echo (isset($dataCliente['nroRut']) ? $dataCliente['nroRut'] : MSG_FIELD_EMPTY); ?></td>
                              <td >
                                  <strong>Nombre</strong>
                              </td>
                              <td><?php echo (isset($dataCliente['nombreCliente']) ? $dataCliente['nombreCliente'] : MSG_FIELD_EMPTY); ?></td>
                              <td >
                                  <strong>Nº Cotizaci&#243;n</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : MSG_FIELD_EMPTY); ?></td>
                              <td colspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                              <td>
                                  <strong>Forma de Pago</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['glosaModoEntrega']) ? $dataRequest['glosaModoEntrega'] : "-"); ?></td>
                              <td >
                                  <strong>Banco</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['glosaBanco']) ? $dataRequest['glosaBanco'] : "-"); ?></td>
                              <td >
                                  <strong>Tipo Cuenta</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['glosaCuenta']) ? $dataRequest['glosaCuenta'] : "-"); ?></td>
                              <td >
                                  <strong>N&#250;mero</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['numeroCuenta']) ? $dataRequest['numeroCuenta'] : "-"); ?></td>
                          </tr>
                      </tbody>
                  </table>

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
                                <td colspan=2></td>
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

                            <tr>
                                <td>
                                    <strong>Solicitud Enlace</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['estadoEnlace']) ? $dataRequest['estadoEnlace'] : "-"); ?></td>
                                <td>
                                  <strong>Estado Enlace</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['glosaEnlace']) ? $dataRequest['glosaEnlace'] : "-"); ?></td>
                                <td>
                                  <strong>Oficina Origen</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['sucursalOrigen']) ? $dataRequest['sucursalOrigen'] : "-"); ?></td>
                                <td>
                                  <strong>Oficina Destino</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['sucursalDestino']) ? $dataRequest['sucursalDestino'] : "-"); ?></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
              </div>

        <div class="form-group text-center">
            <div class="col-xs-12">
        <button type="button" class="btn-action btn btn-success" data-target="liquid" ><i class="fa fa-check"></i> Liquidar</button>
        <button type="button" class="btn-action btn btn-danger" data-target="deny" ><i class="gi gi-remove_2"></i> Rechazar</button>
        <button type="button" class="btn-cancel btn btn-danger" data-target="cancel" ><i class="gi gi-exit"></i> Salir</button>
           </div>
          </div>

          </div>

        </div>
        </form>
    </div>
    <!--End Block principal-->
<input type="hidden" id="idDocument" value="<?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : 0); ?>">
<input type="hidden" id="nroRut" value="<?php echo (isset($dataRequest['nroRut']) ? $dataRequest['nroRut']."-".$dataRequest['dgvRut'] : 0); ?>">
<input type="hidden" id="formaDePago" value="<?php echo (isset($dataRequest['glosaModoEntrega']) ? $dataRequest['glosaModoEntrega'] : "-"); ?>">
<input type="hidden" id="tasaMaxima" value="<?= $dataRequest['tasaMaxima']?>">
<input type="hidden" id="tasaRequest" value="<?= $dataRequest['tasaRequest']?>">
</div>

<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>
<?php $this->load->view('ModalValid'); ?>
<?php $this->load->view('/manager/ModalTransfer'); ?>
<!-- Javascript exclusivos para esta página -->

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/manager/Valid.js"></script>
</body>
</html>
