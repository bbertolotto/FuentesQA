<footer class="clearfix">
  <div class="pull-right">
      Hecho a mano por TeknoData Systems - Santiago - Chile
  </div>
  <div class="pull-left">
      <span id="year-copy"></span> &copy; <a href="https://www.teknodata.cl" target="_blank">TeknodataSystems</a>
  </div>
</footer>
<!-- END Footer -->
</div>
<!-- END Page Container -->
</div>
<!-- END Page Wrapper -->
</div>

        <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

        <div id="modal-user-settings" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> <?= $this->lang->line('settings');?></h2>
                    </div>

                    <div class="modal-body">

                        <form action="#"  id="perfiles"  method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <fieldset>

                                <legend><?= $this->lang->line('Vital Info');?></legend>
                                <div class="form-group">

                                    <label class="col-md-4 control-label">Nombre Usuario</label>
                                    <div class="col-md-6">
                                        <input type="text" readonly class="form-control" value="<?= $this->session->userdata('nombre')?>"></input>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Email de Acceso</label>
                                    <div class="col-md-6">
                                        <input type="text" id="user-settings-email" name="user-settings-email" readonly class="form-control" value="<?= $this->session->userdata('email')?>"></input>
                                    </div>

                                </div>
                                <div class="form-group">

                                    <label class="col-md-4 control-label">Identificaci&oacute;n Usuario</label>
                                    <div class="col-md-6">
                                        <input type="text" readonly class="form-control" value="<?= $this->session->userdata('username')?>"></input>
                                    </div>

                                </div>

                                <legend><?= $this->lang->line('Environment Info');?></legend>
                                <div class="form-group">

                                    <label class="col-md-4 control-label">Imagen Perfil Usuario</label>
                                    <div class="col-md-6">
                                        <input type="file" name="imagen" class="form-control">
                                    </div>
                                </div>

<?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):?>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-email">Modo Atenci&oacute;n</label>
                                    <div class="col-md-6">
                                        <select id="user-settings-attention" name="user-settings-attention" class="
                                        form-control text-center" readonly>
                                            <option value="PRESENCIAL">PRESENCIAL</option>
                                            <option value="REMOTO">REMOTO</option>
                                        </select>
                                    </div>
                                </div>
<?php else:?>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-email">Modo Atenci&oacute;n</label>
                                    <div class="col-md-6">
                                        <input id="user-settings-attention" name="user-settings-attention" class="
                                        form-control text-center" readonly value="<?=$this->session->userdata('attention_mode')?>">
                                    </div>
                                </div>
<?php endif;?>

                                <div class="form-group">

                                    <label class="col-md-4 control-label" for="user-settings-email"><?= $this->lang->line('LockTime');?></label>
                                    <div class="col-md-6">
                                        <input type="text" id="user-settings-locktime" name="user-settings-locktime" class="form-control text-center" value="<?= $this->session->userdata('lock') ?>" maxlength="2" >
                                    </div>

                                </div>

                             </fieldset>
                            <fieldset>
                                <legend><?= $this->lang->line('Password Update');?></legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-password"><?= $this->lang->line('New Password');?></label>
                                    <div class="col-md-8">
                                        <input type="password" id="user-settings-password" name="user-settings-password" class="form-control" placeholder="<?= $this->lang->line('Please choose a complex one..');?>" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-repassword"><?= $this->lang->line('Confirm New Password');?></label>
                                    <div class="col-md-8">
                                        <input type="password" id="user-settings-repassword" name="user-settings-repassword" class="form-control" placeholder="<?= $this->lang->line('..and confirm it!');?>" value="">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?= $this->lang->line('Close');?></button>
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $this->lang->line('Save Changes');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<input type="hidden" id="id_user" name="id_user" value="<?= $this->session->userdata('id')?>">
<script src="/js/jquery-1.12.4.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins.js"></script>
<script src="/js/app.js"></script>
<script src="/js/ajax/toastr.min.js"></script>
<script src="/js/sweetalert.js"></script>
<script src="/js/TeknodataSystems.js"></script>

<script>

$(function(){

var idleTime = 0;
var idleInterval = setInterval(timerIncrement, 60000); 
$(this).mousemove(function (e) {
idleTime = 0;
});
$(this).keypress(function (e) {
idleTime = 0;
});
function timerIncrement() {
    idleTime = idleTime + 1;
    <?php if($this->session->userdata('lock') > 0): ?>
        var valortime = <?= $this->session->userdata('lock')?>;
        if (idleTime > valortime) {
            window.location.replace("<?php echo base_url(); ?>dashboard/lock");
        }
    <?php endif; ?>
}

$('#modal-user-settings').on('show.bs.modal', function (event) {

    var formData = new FormData();
    formData.append("id",$('#id_user').val());
    var response = Teknodata.call_ajax("/config_user", formData, false, true, "");

    if(response!=false){

        if(response.retorno != 0){

            Teknodata.swal_title_message("Error!", response.descRetorno, "question");
            return(false);
       }

    }

})

$("#perfiles" ).submit(function( event ) {

    var formData = new FormData(document.getElementById("perfiles"));
    formData.append("id",$('#id_user').val());
    var response = Teknodata.call_ajax("/config_password", formData, false, true, "");

    if(response!=false){

        if(response.retorno != 0){

            Teknodata.swal_title_message("Error!", response.descRetorno, "error");
            return(false);

       }else{
            Teknodata.swal_title_message("Atención", response.descRetorno, "success");
       }

    }


    $('#user-settings-password').val("");
    $('#user-settings-repassword').val("");
    $("#modal-user-settings").modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();

});


});
</script>
