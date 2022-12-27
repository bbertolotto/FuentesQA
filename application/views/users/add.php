<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="<?= base_url();?>client/search"><strong><?= $this->lang->line('Offices');?></strong></a></li>
        <li><strong><?= $this->lang->line('adduser');?></strong></li>
        
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title text-left">
                    <h2><strong><?= $this->lang->line('Config');?> <?= $this->lang->line('adduser');?></strong></h2>
                </div>
                 <form id="form-validation" action="<?= base_url() ?>users/add" method="post" class="form-horizontal form-bordered">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Nombres <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese nombre">
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                           <label class="col-md-4 control-label" for="val_username">Apellido<span class="text-danger">*</span></label>
                           <div class="col-md-6">
                               <div class="input-group col-sm-6">
                                   <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Ingrese apellido">
                                   <span class="input-group-addon"><i class="gi gi-user"></i></span>
                               </div>
                           </div>
                       </div>


                    <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Email<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                </div>
                            </div>
                        </div>


                    <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Seleccione su rol<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                   <select class="form-control" name="rolesadd">
                                       <?php foreach ($roles as $key) { ?>
                                           <option value="<?= $key['id_rol'] ?>"><?= $key['descripcion'] ?></option>
                                       <?php } ?>
                                   </select>
                                </div>
                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Clave<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese su password">
                                    <span class="input-group-addon"><i class="gi gi-lock"></i></span>
                                </div>
                            </div>
                        </div>

                                      
                        </fieldset>
                                      
                                        
                        <div class="form-group form-actions">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Grabar</button>
                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Email</th>
                                                <th>Rol</th>       
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                    </table>


                                    <div id="myModaledit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edici&#243;n Registro usuarios</h4>
      </div>
      <div class="modal-body">
            <form id="form-validationedit" action="<?= base_url() ?>users/edit" method="post" class="form-horizontal form-bordered">
                                        <fieldset>
                                            <legend><i class="fa fa-angle-right"></i><?= $this->lang->line('adduser');?></legend>
                                                <input type="hidden" id="iditems" name="iditems" >

                                      <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Nombres <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="text" id="nombreedit" name="nombreedit" class="form-control" placeholder="Ingrese nombre">
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                           <label class="col-md-4 control-label" for="val_username">Apellido<span class="text-danger">*</span></label>
                           <div class="col-md-6">
                               <div class="input-group col-sm-6">
                                   <input type="text" id="apellidoedit" name="apellidoedit" class="form-control" placeholder="Ingrese apellido">
                                   <span class="input-group-addon"><i class="gi gi-user"></i></span>
                               </div>
                           </div>
                       </div>


                    <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Email<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="text" id="emailedit" name="emailedit" class="form-control" placeholder="Email">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                </div>
                            </div>
                        </div>


                    <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Seleccione su rol<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                   <select class="form-control" name="rolesaddedit" id="rolesaddedit">
                                       <?php foreach ($roles as $key) { ?>
                                           <option value="<?= $key['id_rol'] ?>"><?= $key['descripcion'] ?></option>
                                       <?php } ?>
                                   </select>
                                </div>
                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Clave<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="password" id="passwordedit" name="passwordedit" class="form-control" placeholder="Ingrese su password">
                                    <span class="input-group-addon"><i class="gi gi-lock"></i></span>
                                </div>
                            </div>
                        </div>

                                           


                                      
                                        </fieldset>
                                      
                                        
                                        <div class="form-group form-actions">
                                            <div class="col-md-8 col-md-offset-4">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Grabar</button>
                                                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Salir sin Grabar</button-->
                                            </div>
                                        </div>
                                    </form>
      </div>
    </div>

  </div>
</div>
            </div>
        </div>
    </div>
<!--END row-->

</div>
<!-- End page-content-->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="<?= base_url();?>js/pages/Alert.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script language="javascript">
  
    
 $('#myModaledit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
 /* modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)*/
  console.log(recipient);
        $.ajax({
        type: "post",
        url: "<?= base_url() ?>users/user_search",
        data: { id: recipient },
        dataType: "json",
        beforeSend: function() {                        

        },
        success: function (data) {
            $("#form-validationedit #iditems").val(data[0].id_user);
            $("#form-validationedit #nombreedit").val(data[0].name);
            $("#form-validationedit #apellidoedit").val(data[0].last_name);
            $("#form-validationedit #emailedit").val(data[0].email);
            $("#form-validationedit #rolesaddedit").val(data[0].roles);
            
        },
        complete: function() {
        }
        });
})

$('.input-datepicker').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 2,
        language: "es",
        daysOfWeekDisabled: "0,6",
        daysOfWeekHighlighted: "1,3,5",
        calendarWeeks: true,
        autoclose: true
    });

$('#form-validation').validate({
        errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
        errorElement: 'div',
        errorPlacement: function(error, e) {
            e.parents('.form-group > div').append(error);
        },
        highlight: function(e) {
            $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        submitHandler: function(form) {
//                    form.submit();
            var form= $("#form-validation");
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                 dataType: "json",
                data: form.serialize(),
                beforeSend: function() {                        
                    /*  $(".almacenarconsulta").prop("disabled",true);
                      console.log("deabilidanto");*/
                },
                success: function (data) {
                    console.log(data.error);
                    if(data.error == true){
                        toastr.error(data.mensaje)
                        return false;
                    }else{
                    toastr.info("Registro Parámetro Ingresado Correctamente!")
                    console.log(data);
                    var table = $('.table').DataTable(); 
                    table.ajax.reload( null, false );
                    return false;
                    }
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
            name: {
                required: true,
            },
            fecha: {
                required: true
            }
        },
        messages: {
            name: {
                required: 'Nombre del dia feriado',
            },
             fecha: {
                required: 'Fecha del dia feriado',
            }
        }
        });

$('#form-validationedit').validate({
        errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
        errorElement: 'div',
        errorPlacement: function(error, e) {
            e.parents('.form-group > div').append(error);
        },
        highlight: function(e) {
            $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        submitHandler: function(form) {
//                    form.submit();
            var form= $("#form-validationedit");
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                dataType: "json",
                beforeSend: function() {                        
                    /*  $(".almacenarconsulta").prop("disabled",true);
                      console.log("deabilidanto");*/
                },
                success: function (data) {


                    console.log(data.error);
                    if(data.error == true){
                        toastr.error(data.mensaje)
                        return false;
                    }else{
                 
                    toastr.info("Regiostro Parámetro Ingresado Ccoreectamente!");
                    console.log(data);
                    var table = $('.table').DataTable(); 
                    table.ajax.reload( null, false );
                    $("#myModaledit").modal('hide');//ocultamos el modal
                    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
                    return false;
                    }
                },
                complete: function() {
                  }
                        });
                  },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    nameedit: {
                        required: true
                    },
                    fechaedit: {
                        required: true
                    }
                },
                messages: {
                    nameedit: {
                        required: 'Nombre del dia feriado'
                    },
                     fechaedit: {
                        required: 'Fecha del dia feriado'
                    }
                }
            });
            var table =  $('.table').DataTable({
            ajax: "<?php echo base_url(); ?>users/list"
        });

$('.table tbody').on('click', '.deletes', function () {   
    console.log("eliminar");  
    Swal.fire({
        title: 'Seguro de Eliminar?',
        text: "Está acción no puede ser revertida!",
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
        var idfound =  $tr.find("td:eq(4)").find(".deletes").attr("data-id");
        console.log(idfound);
        $.ajax({    
            url:   '<?php echo base_url( "users/delete" ) ?>',
            type: "GET",
            data: { id : idfound },    
            beforeSend: function () {
            },
            success:  function (response) {
                console.log(response);
                toastr.info("Registro Parámetro Eliminado!");
            }
        }); 
//        Swal.fire(
//            'Resultado!',
//            'Registro Eliminado.',
//            'success' )
    }
})
return false;
});
</script>


</body>
</html>
