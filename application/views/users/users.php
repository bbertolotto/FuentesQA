<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
        <li><strong><?= $this->lang->line('Manage');?></strong></li>
        <li><strong><?= $this->lang->line('Username');?></strong></li>
        <li><a href="/users/records_users"><strong><?= $this->lang->line('Activity');?></strong></a></li>
        <li><a href="/users/log_users"><strong><?= $this->lang->line('Event Log');?></strong></a></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title text-left">
                    <h2><strong><?= $this->lang->line('Manage');?> <?= $this->lang->line('Users');?></strong></h2>
                </div>

        <form id="form-validation" action="/create_users" method="post" class="form-horizontal form-bordered">
            <input type="hidden" id="id_user" name="id_user" class="form-control text-center" >
                <fieldset>
                    <div class="form-group col-sm-1">&nbsp;</div>
                    <div class="form-group col-sm-2">
                        <label for="masked_rut_users">Rut del Usuario</label>
                        <input type="text" id="masked_rut_users" name="masked_rut_users" maxlength="12" class="form-control text-center" placeholder="" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this)"></input>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="nameUsers">Nombres</label>
                        <input type="text" id="nameUsers" name="nameUsers" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" maxlength="50" >

                    </div>
                    <div class="form-group col-sm-2">
                        <label for="lastnameUsers">Apellidos</label>
                        <input type="text" id="lastnameUsers" name="lastnameUsers" class="form-control text-center" onKeyUp="this.value=this.value.toUpperCase();" maxlength="50" >

                    </div>
                    <div class="form-group col-sm-2">
                        <label for="emailUsers">Email Acceso Sistema</label>
                        <input type="text" id="emailUsers" name="emailUsers" maxlength="100" class="form-control text-center minusculas" placeholder="" ></input>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="usernameUsers">Identifiaci&oacute;n de Usuario</label>
                        <input type="text" id="usernameUsers" name="usernameUsers" maxlength="50" class="form-control text-center" placeholder="NOMBRE.APELLIDO" onKeyUp="this.value=this.value.toUpperCase();" ></input>
                    </div>
                    <div class="form-group col-sm-1">&nbsp;</div>

                </fieldset>

                <fieldset>

                    <div class="form-group col-sm-1">&nbsp;</div>
                    <div class="form-group col-sm-2">
                        <label for="officeUsers">Detalle su Oficina</label>
                        <select id="officeUsers" name="officeUsers" class="form-control text-center">
                            <option value=""></option>
                            <?php foreach ($office as $field):?>
                                <option value="<?= $field->id_office ?>"><?= $field->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="rolUsers">Detalle su ROL</label>
                        <select id="rolUsers" name="rolUsers" class="form-control text-center">
                            <option value=""></option>
                            <?php foreach ($roles as $field):?>
                                <option value="<?= $field->id_rol ?>"><?= $field->descripcion ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="channelUsers">Detalle su CANAL</label>
                        <select id="channelUsers" name="channelUsers" class="form-control text-center">
                            <?php foreach ($channel as $field):?>
                                <option value="<?= $field->channel ?>"><?= $field->channel ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="ismanagerUsers">¿Es Supervisor?</label>
                        <select id="ismanagerUsers" name="ismanagerUsers" class="form-control text-center" >
                            <option value="0" selected>NO</option>
                            <option value="1">SI</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="isbossUsers">¿Es Jefe ?</label>
                        <select id="isbossUsers" name="isbossUsers" class="form-control text-center">
                            <option value="0" selected>NO</option>
                            <option value="1">SI</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-1">&nbsp;</div>

                </fieldset>

                <fieldset>

                    <div class="form-group col-sm-1">&nbsp;</div>
                    <div class="form-group col-sm-2">
                        <label for="bossUsers">Detalle su Jefe!</label>
                        <select id="bossUsers" name="bossUsers" class="form-control text-center">
                            <option value="0">NO</option>
                            <?php foreach ($boss as $field):?>
                                <option value="<?= $field->id_user?>"><?= $field->username ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="phoneUsers">Nº Tel&eacute;fono Celular</label>
                        <input type="text" id="phoneUsers" name="phoneUsers" class="form-control text-center" placeholder="569-9999-9999" >

                    </div>
                    <div class="form-group col-sm-2">
                        <label for="passwordUsers">Password</label>
                        <input type="text" id="passwordUsers" name="passwordUsers" class="form-control text-center" >
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="attention_mode">Modo de Atenci&oacute;n</label>
                        <select name="attention_mode" id="attention_mode" class="form-control">
                            <option value="PRESENCIAL">PRESENCIAL</option>
                            <option value="REMOTO">REMOTO</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="example">&nbsp;</label><br>
                        <button type="submit" class="btn-update btn btn-primary"><i class="fa fa-arrow-right"></i> Crear</button>
                        <button type="reset" class="btn-cancel btn btn-warning"><i class="fa fa-repeat"></i> Cancelar</button>
                    </div>
                    <div class="form-group col-sm-1">&nbsp;</div>

                </fieldset>

        </form>
<div class="table-responsive">

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rut</th>
                    <th>Usuario</th>
                    <th>Nombres</th>
                    <th>Sucursal</th>
                    <th>Canal</th>
                    <th>Acci&oacute;n</th>
                </tr>
            </thead>
            <tbody> </tbody>
        </table>
</div>

            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="/js/pages/Alert.js"></script>

<script language="javascript">

$(".btn-cancel").click(function(){
  $("#form-validation").attr('action', 'create_users');
  $(".btn-update").html("<i class='fa fa-arrow-right'></i>Crear");
});
$(".btn-create").click(function(){
   $("#form-validation").attr('action', '/create_users');
});


$(".btn-update").click(function(){

//   $("#form-validation").attr('action', '/users/edit_users');

});

$('.table tbody').on('click', '.edit', function () {
    $("#form-validation").attr('action', 'edit_users');
    $(".btn-update").html("<i class='fa fa-arrow-right'></i>Modificar");

    $tr = $(this).closest('tr');
    var $id_user =  $tr.find("td:eq(6)").find(".edit").attr("data-id");

    var formData = new FormData();
    formData.append("id",$id_user);
    var response = Teknodata.call_ajax("/search_users", formData, false, true, "");
    if(response!=false){

        if(response[0].retorno!=0){
            Teknodata.swal_title_message("", response[0].descRetorno, "error");
        }else{

            $("#form-validation #masked_rut_users").val(response[0].rut_user);
            $("#form-validation #nameUsers").val(response[0].name);
            $("#form-validation #lastnameUsers").val(response[0].last_name);
            $("#form-validation #emailUsers").val(response[0].email);
            $("#form-validation #usernameUsers").val(response[0].username);
            $("#form-validation #officeUsers").val(response[0].id_office);
            $("#form-validation #rolUsers").val(response[0].id_rol);
            $("#form-validation #channelUsers").val(response[0].name_channel);
            $("#form-validation #ismanagerUsers").val(response[0].id_manager);
            $("#form-validation #isbossUsers").val(response[0].id_boss);
            $("#form-validation #bossUsers").val(response[0].id_user_boss);
            $("#form-validation #phoneUsers").val(response[0].number_phone);
            $("#form-validation #passwordUsers").val("");
            $("#form-validation #id_user").val(response[0].id_user);
            $("#form-validation #attention_mode").val(response[0].attention_mode);
        }
    }
return false;
});


$('#form-validation').validate({
        errorClass: 'help-block animation-slideDown',
        errorElement: 'div',
        errorPlacement: function(error, e) {
            e.parents('.form-group > div').append(error);
        },
        highlight: function(e) {
            $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        submitHandler: function(form) {

            var form= $("#form-validation");
            $.ajax({ type: "post", url: form.attr('action'), dataType: "json", data: form.serialize(),
                beforeSend: function() { },
                success: function (response, status, xhr) {

                    if(response.retorno==0) {
                        var table = $('.table').DataTable();
                        table.ajax.reload( null, false );
                        Alert.showAlert(response.descRetorno);
                        $(".btn-reset").click();
                    } else {
                        toastr.info(response.descRetorno);
                    }
                    return false;
                },
                complete: function() {
                    $(".almacenarconsulta").prop("disabled",false);
                }
            });
        },
        success: function(e) {
            // You can use the following if you would like to highlight with green color the input after successful validation!
            e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
            e.closest('.help-block').remove();
        },
        rules: {
            masked_rut_users: { required: true },
            nameUsers: { required: true},
            lastnameUsers: { required: true},
            emailUsers: { required: true},
            usernameUsers: { required: true},
            officeUsers: { required: true},
            rolUsers: { required: true},
            channelUsers: { required: true},
            ismanagerUsers: { required: true},
            phoneUsers: { required: true},
            /*passwordUsers: { required: true},*/
        },

});

var table =  $('.table').DataTable({
ajax: "<?php echo base_url(); ?>details_users",
"language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
});

$('.table tbody').on('click', '.deletes', function () {

    Swal.fire({
        title: '¿Confirma eliminación usuario?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Confirmar!',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                var btn = this;
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                table.row($(btn).parents('tr')).remove().draw(false);
                var $id_user =  $tr.find("td:eq(6)").find(".deletes").attr("data-id");
                var formData = new FormData();
                formData.append("id",$id_user);
                var response = Teknodata.call_ajax("/remove_users", formData, false, true, "");
                if(response!=false){
                    Teknodata.swal_title_message("Resultado Transacción", response["descRetorno"], "info");
                }

            }
        });

return false;
});

$('.table tbody').on('click', '.lock', function () {

    Swal.fire({
        title: '¿Confirma bloqueo de usuario?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Confirmar!',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                var $id_user =  $tr.find("td:eq(6)").find(".lock").attr("data-id");
                var formData = new FormData();
                formData.append("id",$id_user);
                var response = Teknodata.call_ajax("/locked_users", formData, false, true, "");
                if(response!=false){
                    Teknodata.swal_title_message("Resultado Transacción", response["descRetorno"], "info");
                }

            }
        });

return false;
});

$('.table tbody').on('click', '.unlock', function () {

    Swal.fire({
        title: '¿Confirma desbloqueo de usuario?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Confirmar!',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                var $id_user =  $tr.find("td:eq(6)").find(".unlock").attr("data-id");
                var formData = new FormData();
                formData.append("id",$id_user);
                var response = Teknodata.call_ajax("/unlock_users", formData, false, true, "");
                if(response!=false){
                    Teknodata.swal_title_message("Resultado Transacción", response["descRetorno"], "info");
                }

            }
        });

return false;
});



</script>

</body>
</html>
