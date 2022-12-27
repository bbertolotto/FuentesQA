<div id="modal-valid" class="modal-valid modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

      <div id="body-modal-valid" class="modal-body text-center"> </div>
        <form id="form-valid" method="post" class="form-horizontal form-bordered">
            <div class="form-group text-center">
                <div class="col-xs-12">
                  <button type="button" class="btn-valid btn btn-success" data-dismiss="modal" data-target="accept"><i class="hi hi-ok"></i> Aceptar </button>
                </div>
            </div>
        </form>
        <div class="modal-footer text-center"> </div>
    </div>
  </div>
</div>

<div id="modal-deny" class="modal-deny modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

      <div id="body-modal-deny" class="modal-body text-center"> </div>
      <form id="form-deny" method="post" class="form-horizontal form-bordered">

            <div class="form-group">
                <label class="col-md-4 control-label" for="val_reason_deny">Motivo Rechazo <span class="text-danger">*</span></label>
                <div class="col-md-6">

                    <div class="input-group">

                        <select name="reasonDeny" class="form-control" id="reasonDeny">

<?php if($this->session->userdata("showDeny")=="valid" OR $this->session->userdata("showDeny")=="approbation"):?>

                        <?php if($this->session->userdata("showDeny")=="valid"):?>

                  <?php foreach (listRechazaLiquida() as $key) { ?>

                      <?php if($this->session->userdata("id_rol")==$key->ID_ROL):?>
                                <option style="width:200px" value="<?= $key->MOTIVO ?>"><?= $key->MOTIVO ?></option>
                      <?php endif;?>                                
 
                  <?php } ?>

                        <?php else:?>

                  <?php foreach (listRechazaAutoriza() as $key) { ?>

                      <?php if($this->session->userdata("id_rol")==$key->ID_ROL):?>
                                <option style="width:200px" value="<?= $key->MOTIVO ?>"><?= $key->MOTIVO ?></option>
                      <?php endif;?>                                

                  <?php } ?>    

                      <?php endif; ?>

<?php else:?>

                        <?php foreach (motivosrechazo() as $key) { ?>
                            <option style="width:200px" value="<?= $key->KEY ?>"><?= $key->TABLA ?></option>
                        <?php } ?>

<?php endif;?>

                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-xs-12">
                  <button type="button" class="btn-valid btn btn-success btn-print" data-dismiss="modal " data-target="CRC"  ><i class="hi hi-ok"></i> Aceptar </button>
                  <button type="button" class="btn-valid btn btn-danger" data-dismiss="modal" data-target="cancel"><i class="hi hi-remove"></i> Cancelar </button>
                </div>
            </div>
        </form>
        <div class="modal-footer text-center"> </div>
    </div>
  </div>
</div>
