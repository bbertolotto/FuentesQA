<div id="modal-access" class="modal-access modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

        <div id="body-modal-access" class="modal-body text-center">
            <p><strong><h4>¡Ooops! No tienes permiso para esta funcionalidad !</br></br>
                        Presiona Cerrar para continuar</br></h4></strong></p>
        </div>
        <div class="form-group">
            <center>
            <div class="col-xs-12">
              <button type="button" class="btn btn-danger" data-dismiss="modal" > <i class="gi gi-hand_right"></i> Cerrar </button>
            </div>
                </center>
        </div>

        <div class="modal-footer text-center">
        </div>
    </div>
  </div>
</div>
</div>


<div id="modal-session" class="modal-session modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

        <div id="body-modal-session" class="modal-body text-center">
            <p><strong><h4>Antes de Revisar datos en Detalle debe buscar y seleccionar un Cliente....</br></br>
                        Puede buscar utilizando número de RUT o Tarjeta</br></h4></strong></p>
        </div>
        <div class="form-group">
            <center>
            <div class="col-xs-12">
              <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="window.location = 'index';"> <i class="gi gi-hand_right"></i> Continuar </button>
            </div>
                </center>
        </div>

        <div class="modal-footer text-center">
        </div>
    </div>
  </div>
</div>
</div>

<div id="modal-capturing" class="modal-capturing modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

        <div id="body-modal-capturing" class="modal-body text-center">
            <p><strong><h4>No fue posible recuperar información del cliente....</br></br>
                        Intente continuar ingresando número de RUT </br></h4></strong></p>
        </div>
        <div class="form-group">
            <center>
            <div class="col-xs-12">
              <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="window.location = 'index';"> <i class="gi gi-hand_right"></i> Continuar </button>
            </div>
                </center>
        </div>

        <div class="modal-footer text-center">
        </div>
    </div>
  </div>
</div>
</div>

<div class="modal-alert modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>
      <div id="body-modal-alert" class="modal-body text-center">
      </div>
      <div class="modal-footer">
        <div class="form-group col-xs-12 text-center">
            <button type="button" class="btn-cancel btn btn-sm btn-warning" data-dismiss="modal"><i class="hi hi-log_out"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal-search modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>
<form id="reason-form" method="POST" >
        <div id="body-modal-search" class="modal-body text-center" dataurl="<?= base_url();?>client/consolidate">

        </div>

        <div id="footer-modal-search-client" class="modal-footer">
        <div class="col-md-12 text-center">
            <button type="button" id="btn-modal-accept_client" class="btn-modal-action btn btn-info " data-dismiss="modal" data-target="accept_client"><i class="gi gi-ok_2"></i> Aceptar</button>
            <button type="reset" id="btn-modal-cancel_client" class="btn-modal-action btn btn-danger " data-dismiss="modal" data-target="cancel_client"><i class="gi gi-remove_2"></i> Cancelar</button>
            <button type="button" id="btn-modal-accept_noclient" class="btn-modal-action btn btn-success " data-dismiss="modal" data-target="accept_noclient"><i class="gi gi-ok_2"></i> Aceptar</button>
            <button type="reset" id="btn-modal-cancel_noclient" class="btn-modal-action btn btn-success " data-dismiss="modal" data-target="cancel_noclient"><i class="gi gi-remove_2"></i> Cancelar</button>
            <button type="button" id="btn-modal-error" class="btn-modal-action btn btn-danger " data-dismiss="modal" data-target="error"><i class="gi gi-hand_right"></i> Aceptar</button>
        </div>
</form>
      </div>
    </div>
  </div>
</div>

<div class="modal-advance modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>
      <div id="body-modal-advance" class="modal-body text-center" dataurl="<?= base_url();?>client/consolidate">
      </div>
      <div id="footer-modal-search-client" class="modal-footer text-center">

        <div class="col-md-12">

            <fieldset>
              <div class="form-group col-xs-6 " >
                  <button type="button" class="btn-accept-offer btn btn-sm btn-info btn-block" data-dismiss="modal" data-action="#" data-target="accept_offer"><i class="gi gi-ok_2"></i> Aceptar</button>
              </div>
              <div class="form-group col-xs-6 ">
                  <button type="reset" class="btn-new-offer btn btn-sm btn-danger btn-block" data-dismiss="modal" data-target="new_offer"><i class="gi gi-up_arrow"></i> Crear nueva cotizaci&#243;n</button>
              </div>
            </fieldset>

        </div>
      </div>
    </div>
  </div>
</div>
