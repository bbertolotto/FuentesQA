<div id="modal-reprint" class="modal-reprint modal fade" role="dialog" aria-hidden="true">
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
              <h2>Confirmar Impresi&#243;n Tarjeta <strong>Tarjeta Cruz Verde</strong></h2>
            </div>

          <form name="form-transfer" id="form-transfer" method="post" class="form-horizontal form-bordered form-control-borderless">

            <div class="form-group col-xs-6 col-sm-6">
                <label for="masked_rut_transfer">Rut</label>
                <input type="text" id="rut_reprint" name="rut_reprint" class="form-control text-center" readonly>
            </div>
            <div class="form-group col-xs-6 col-sm-6">
                <label for="nameClient" >Nombres</label>
                <input type="text" id="nameClient_reprint" style="width:330px" name="nameClient_reprint" class="form-control text-center" readonly>
            </div>

            <div class="form-group col-xs-6 col-sm-6">
                <label for="numeroCuenta">N&#250;mero de Tarjeta</label>
                <input type="text" id="numeroCuenta_reprint" name="numeroCuenta_reprint" class="form-control text-center" readonly >
            </div>

            <div class="form-group col-xs-6 col-sm-6">
                <label for="numeroCuenta">Motivo Reimpresión</label>
                <input type="text" id="motivo_reprint" name="motivo_reprint" class="form-control text-center" readonly >
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
                <button type="button" id="btn-accept-request" class="btn-modal-request btn btn-danger" data-target="reprint" data-dismiss="modal"><i class="fa fa-check"></i> Confirmar Impresión</button>
                <button type="button" class="btn-modal-request btn-exit-reprint btn btn-danger" data-target="cancel" data-dismiss="modal"><i class="gi gi-exit"></i> Salir</button>
              </div>
          </div>

        </form>

         <br>
        </div>
       </div>

    </div>
  </div>
</div>

</div>

<div id="modal-request" class="modal-request modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

      <div id="body-modal-request" class="modal-body text-center">
        <p><div id="titleRequest"></div></p>

        <div id="htmlRequest">
        </div>

        <div class="form-group">
            <div class="col-xs-12">
              <button type="button" id="btn-accept-request" class="btn-modal-request btn btn-danger"  data-target="accept" data-dismiss="modal"><i class="fa fa-share-alt"></i> Aceptar </button>
              <button type="button" id="exitRequest" class="btn-modal-request btn btn-warning" data-target="cancel" data-dismiss="modal"><i class="fa fa-reset"></i> Cancelar</button>
            </div>
        </div>

        <div class="modal-footer text-center">
        </div>
    </div>
  </div>
</div>
</div>
