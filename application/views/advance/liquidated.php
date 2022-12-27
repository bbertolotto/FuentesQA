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

                              <td >
                                  <strong>Cuotas</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['plazoDeCuota']) ? $dataRequest['plazoDeCuota'] : MSG_FIELD_EMPTY); ?></td>
                              <td>
                                  <strong>Diferido</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['mesesDiferidos']) ? $dataRequest['mesesDiferidos'] : MSG_FIELD_EMPTY); ?></td>
                          </tr>
                          <tr>
                              <td>
                                  <strong>Primer Vencimiento</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['fechaPrimerVencimiento']) ? $dataRequest['fechaPrimerVencimiento'] : MSG_FIELD_EMPTY); ?></td>

                              <td>
                                  <strong>Forma de Pago</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['glosaModoEntrega']) ? $dataRequest['glosaModoEntrega'] : MSG_FIELD_EMPTY); ?></td>
                              <td >
                                  <strong>Banco</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['banco']) ? $dataRequest['banco'] : MSG_FIELD_EMPTY); ?></td>
                              <td >
                                  <strong>Tipo Cuenta</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['tipoCuenta']) ? $dataRequest['tipoCuenta'] : MSG_FIELD_EMPTY); ?></td>
                              <td >
                                  <strong>N&#250;mero</strong>
                              </td>
                              <td><?php echo (isset($dataRequest['numeroCuenta']) ? $dataRequest['numeroCuenta'] : MSG_FIELD_EMPTY); ?></td>
                          </tr>
                      </tbody>
                  </table>

              </div>
            </div>

            <div class="col-sm-12 col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="gi gi-charts"></i> Detalle Operaci&#243;n</h2>
                </div>
                <table class="table table-sm table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td >
                                <strong>Cuotas</strong>
                            </td>
                            <td><?php echo (isset($dataRequest['plazoDeCuota']) ? $dataRequest['plazoDeCuota'] : MSG_FIELD_EMPTY); ?></td>
                            <td >
                                <strong>Meses de Gracia</strong>
                            </td>
                            <td><?php echo (isset($dataRequest['mesesDiferidos']) ? $dataRequest['mesesDiferidos'] : MSG_FIELD_EMPTY); ?></td>
                            <td >
                                <strong>Primer Vencimiento</strong>
                            </td>
                            <td><?php echo (isset($dataRequest['fechaPrimerVencimiento']) ? $dataRequest['fechaPrimerVencimiento'] : MSG_FIELD_EMPTY); ?></td>
                            <td>
                                <strong>Valor Cuota</strong>
                            </td>
                            <td>$<?php echo (isset($dataRequest['valorDeCuota']) ? $dataRequest['valorDeCuota'] : MSG_FIELD_EMPTY); ?></td>
                            <td>
                                <strong>Costo Total</strong>
                            </td>
                            <td>$<?php echo (isset($dataRequest['costoTotalDelCredito']) ? $dataRequest['costoTotalDelCredito'] : MSG_FIELD_EMPTY); ?></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tasa</strong>
                            </td>
                            <td><?php echo (isset($dataRequest['tasaDeInteresMensual']) ? $dataRequest['tasaDeInteresMensual'] : MSG_FIELD_EMPTY); ?></td>
                            <td >
                                <strong>Impuestos</strong>
                            </td>
                            <td>$<?php echo (isset($dataRequest['impuestos']) ? $dataRequest['impuestos'] : MSG_FIELD_EMPTY); ?></td>
                            <td >
                                <strong>Comisi&#243;n</strong>
                            </td>
                            <td>$<?php echo (isset($dataRequest['comision']) ? $dataRequest['comision'] : MSG_FIELD_EMPTY); ?></td>
                            <td >
                                <strong>CAE</strong>
                            </td>
                            <td><?php echo (isset($dataRequest['cargaAnualEquivalente']) ? $dataRequest['cargaAnualEquivalente'] : MSG_FIELD_EMPTY); ?></td>
                            <td colspan=2></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Protecci&#243;n Vida</strong>
                            </td>
                            <td>$<?php echo (isset($dataRequest['costoTotalSeguro1']) ? $dataRequest['costoTotalSeguro1'] : MSG_FIELD_EMPTY); ?></td>
                            <td>
                                <strong>Desgravamen</strong>
                            </td>
                            <td>$<?php echo (isset($dataRequest['costoTotalSeguro2']) ? $dataRequest['costoTotalSeguro2'] : MSG_FIELD_EMPTY); ?></td>
                            <td colspan=8></td>
                        </tr>
                    </tbody>
                </table>

            </div>
          </div>

          <div class="form-group text-center">
              <div class="col-xs-12">
<?php if($this->session->userdata["owner"]==1):?>
        <button type="button" class="btn-action btn btn-success" data-target="liquid" data-action="/remote/valid"><i class="fa fa-check"></i> Liquidar</button>
        <button type="button" class="btn-action btn btn-danger" data-target="denied" data-action="/remote/valid"><i class="gi gi-remove_2"></i> Rechazar</button>
<?php else:?>
        <button type="button" class="btn-action btn btn-success" data-target="liquid" disabled><i class="fa fa-check"></i> Liquidar</button>
        <button type="button" class="btn-action btn btn-danger" data-target="denied" disabled ><i class="gi gi-remove_2"></i> Rechazar</button>
<?php endif;?>
              </div>
          </div>

          </div>

        </div>
        </form>
    </div>
    <!--End Block principal-->
</div>
<!-- END Page Content -->
<?php $this->load->view('ModalAlert'); ?>

<?php $this->load->view('footer'); ?>
<!-- Javascript exclusivos para esta página -->

<script src="<?= base_url();?>js/pages/Alert.js"></script>
<script src="<?= base_url();?>js/remote/Valid.js"></script>
</body>
</html>
