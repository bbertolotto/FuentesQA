<div id="modal-link" class="modal-link modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

      <div id="body-modal-link" class="modal-body text-center">
          <p><strong>Si desea esta acci&#243;n enviara SAV a sucursal que seleccione a continuaci&#243;n.</br>
          Debe seleccionar fecha de compromiso para control y gestión</strong></p>

        <form id="form-link" method="post" class="form-horizontal form-bordered">

        <div class="form-group">
          <label class="col-md-4 control-label" for="example-clickable-bio">Fecha Compromiso</label>
            <div class="col-md-4 ">
                <input type="text" id="dateLinked" class="form-control input-datepicker-close text-center" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="example-clickable-bio">Sucursal</label>
            <div class="col-md-4">
                <select id="officeLinked" class="form-control">
                    <?php echo $officeLinked["optionOfficeLinked"] ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
              <button type="button" class="btn-accept-link btn btn-danger"  data-dismiss="modal"><i class="fa fa-share-alt"></i> Grabar</button>
              <button type="button" class="btn-return-link btn btn-success" data-dismiss="modal"><i class="fa fa-reset"></i> Volver</button>
            </div>
        </div>

        </form>
        <div class="modal-footer text-center">
        </div>
    </div>
  </div>
</div>
</div>


<div id="modal-link-approbation" class="modal-link-approbation modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

      <div id="body-modal-link-approbation" class="modal-body text-center">
          <p><strong><h4>Cotización con solicitud de enlace Pendiente</h4></strong></p>

        <form id="form-link-approbation" method="post" class="form-horizontal form-bordered">

        <div class="form-group">
            <label class="col-md-4 control-label" >Número Cotización</label>
            <div class="col-md-4">
              <input type="text" id="idDocument" class="form-control text-center">
            </div>

        </div>


        <div class="form-group">
            <label class="col-md-4 control-label" >Fecha Solicitud</label>
            <div class="col-md-4">
              <input type="text" id="fechaSolicitud" class="form-control text-center">
            </div>

        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" >Sucursal Origen</label>
            <div class="col-md-4">
              <input type="text" id="nameSucursalOrigen" class="form-control text-center">
            </div>

        </div>

        <div class="form-group">

            <label class="col-md-4 control-label" >Sucursal Destino</label>
            <div class="col-md-4">
              <input type="text" id="nameSucursalDestino" class="form-control text-center">
            </div>

        </div>

        <div class="form-group">
            <div class="col-xs-12">
              <button type="button" class="btn-action-link btn btn-danger"  data-action="accept" data-dismiss="modal"><i class="fa fa-share-alt"></i> Autorizar</button>
              <button type="button" class="btn-action-link btn btn-danger"  data-action="deny" data-dismiss="modal"><i class="fa fa-share-alt"></i> Rechazar</button>
              <button type="button" class="btn-action-link btn btn-success" data-action="cancel" data-dismiss="modal"><i class="fa fa-reset"></i> Salir</button>
            </div>
        </div>

        </form>
        <div class="modal-footer text-center">
        </div>
    </div>
  </div>
</div>
</div>
