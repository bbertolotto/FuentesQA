<div id="modal-transfer" class="modal-transfer modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

      <div id="body-modal-beneficiary" class="modal-body text-center">

        <div id="beneficiary">
          <div class="block">
            <div class="block-title">
              <div class="block-options pull-right">
                  <!--a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Settings"><i class="gi gi-cogwheel"></i></a-->
              </div>
              <h2>Liquidaci&#243;n S&#250;per Avance con <strong>Transferencia Electr&#243;nica</strong></h2>
            </div>

          <form name="form-transfer" id="form-transfer" method="post" class="form-horizontal form-bordered form-control-borderless">

            <div class="form-group col-xs-6 col-sm-2">
                <label for="masked_rut_transfer">Rut</label>
                <input type="text" id="masked_rut_transfer" name="masked_rut_transfer" class="form-control text-center" readonly>
            </div>
            <div class="form-group col-xs-6 col-sm-4">
                <label for="nameClient" >Nombres</label>
                <input type="text" id="nameClient" style="width:330px" name="nameClient" class="form-control text-center" readonly>
            </div>

            <div class="form-group col-xs-6 col-sm-3">
                <label for="nameBanco">Banco <span class="text-danger">*</span></label>
                <select name="bank" id="bank" class="form-control" disabled>
                      <option value="">[Bancos Disponibles]</option>
                      <?php foreach (listBancos() as $key) { ?>
                          <option value="<?= $key->ID ?>"><?= $key->NAME ?></option>
                      <?php } ?>
                </select>
            </div>

            <div class="form-group col-xs-6 col-sm-3">
                <label for="glosaCuenta">Tipo de Cuenta <span class="text-danger">*</span></label>
                <select name="typeAccount" id="typeAccount" class="form-control" disabled>
                    <option value="">[Tipo Cuenta]</option>
                    <?php foreach (listTipoCuentas() as $key) { ?>
                        <option value="<?= $key->ID ?>"><?= $key->NAME ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-xs-6 col-sm-3">
                <label for="numeroCuenta">N&#250;mero de Cuenta <span class="text-danger">*</span></label>
                <input type="text" id="numeroCuenta" name="numeroCuenta" class="form-control text-center" disabled>
                <input type="hidden" id="numeroCuentaBack">
            </div>

            <div class="form-group col-xs-6 col-sm-2">
                <label for="montoLiquido">Monto L&#237;quido</label>
                <input type="text" id="montoLiquido" name="montoLiquido" class="form-control text-center" readonly>
            </div>

            <div class="form-group col-xs-6 col-sm-4">
                <label for="emailCuenta">Correo Electr&#243;nico</label>
                <input type="text" id="emailCuenta" name="emailCuenta" class="form-control text-center" readonly>
            </div>

            <div class="form-group col-xs-6 col-sm-2">
                <label for="telefonoCuenta">Tel&#233;fono Celular</label>
                <input type="text" id="telefonoCuenta" name="telefonoCuenta" class="form-control text-center" readonly>
            </div>

          <table id="trackingTransfer" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th class="text-center">Proceso</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Resultado</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>

          <div class="form-group">
              <div class="col-xs-12">
                <button type="button" id="saveTransfer" class="btn-modal-request btn btn-danger" data-target="transfer" data-dismiss="modal"><i class="gi gi-money"></i> Confirmar Transferencia</button>
                <button type="button" id="exitTransfer" class="btn-modal-request btn btn-danger" data-target="cancel" data-dismiss="modal"><i class="gi gi-exit"></i> Salir</button>
              </div>
          </div>

        </form>

         <br>
        </div>
       </div>

    </div>
  </div>
</div>

<input type="hidden" id="codigoBanco" value="">
<input type="hidden" id="tipoCuenta" value="">
<input type="hidden" id="plazoDeCuota" value="">

</div>
