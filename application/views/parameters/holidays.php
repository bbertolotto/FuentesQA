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
        <li><strong><?= $this->lang->line('Holidays');?></strong></li>
        <li><a href="<?= base_url();?>parameters/rejection"><strong><?= $this->lang->line('Reasons Rejection');?></strong></a></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title text-left">
                    <h2><strong><?= $this->lang->line('Config');?> <?= $this->lang->line('Holidays');?></strong></h2>
                </div>
                 <form id="form-validation" action="<?= base_url() ?>parameters/holidays_add" method="post" class="form-horizontal form-bordered">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">Descripci&#243;n del Feriado <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Ingrese Descripci&#243;n del d&#237;a Feriado">
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                           <label class="col-md-4 control-label" for="val_username">Fecha del Feriado<span class="text-danger">*</span></label>
                           <div class="col-md-6">
                               <div class="input-group col-sm-6">
                                   <input type="text" id="fecha" name="fecha" class="form-control input-datepicker" placeholder="Fecha D&#237;a Feriado">
                                   <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                               </div>
                           </div>
                       </div>


                    <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">D&#237;a H&#225;bil Anterior <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="text" id="fechaanterior" name="fechaanterior" class="form-control input-datepicker" placeholder="Fecha D&#237;a H&#225;bil Anterior">
                                    <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-4 control-label" for="val_username">D&#237;a H&#225;bil Siguiente <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-6">
                                    <input type="text" id="fechasiguiente" name="fechasiguiente" class="form-control input-datepicker" placeholder="Fecha D&#237;a H&#225;bil Siguiente">
                                    <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
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
                                                <th>Descripci&#243;n del Feriado</th>
                                                <th>A&#241o</th>
                                                <th>Fecha Feriado</th>
                                                <th>D&#237;a H&#225;bil Anterior</th>
                                                <th>D&#237;a H&#225;bil Siguiente</th>
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
        <h4 class="modal-title">Edici&#243;n Registro Par&#225;metros</h4>
      </div>
      <div class="modal-body">
            <form id="form-validationedit" action="<?= base_url() ?>feriado/editferiado" method="post" class="form-horizontal form-bordered">
                                        <fieldset>
                                            <legend><i class="fa fa-angle-right"></i><?= $this->lang->line('Holidays');?></legend>
                                          
<input type="hidden" id="iditems" name="iditems" >

                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Descripci&#243;n del Feriado <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group col-sm-8">
                                                        <input type="text" id="nameedit" name="nameedit" class="form-control" placeholder="Ingrese Nombre">
                                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                    </div>
                                                </div>
                                            </div>


                                             <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Fecha del Feriado <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group col-sm-8">
                                                        <input type="text" id="fechaedit" name="fechaedit" class="form-control input-datepicker" placeholder="Ingrese Fecha">
                                                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                           


                                              <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">D&#237;a H&#225;bil Anterior <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group col-sm-8">
                                                        <input type="text" id="fechaanterioredit" name="fechaanterioredit" class="form-control input-datepicker" placeholder="Ingrese Fecha anterior">
                                                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">D&#237;a H&#225;bil Siguiente <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group col-sm-8">
                                                        <input type="text" id="fechasiguienteedit" name="fechasiguienteedit" class="form-control input-datepicker" placeholder="Ingrese Fecha siguiente">
                                                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
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
        url: "<?= base_url() ?>parameters/holidays_search",
        data: { id: recipient },
        dataType: "json",
        beforeSend: function() {                        

        },
        success: function (data) {
            $("#form-validationedit #iditems").val(data[0].id_item);
            $("#form-validationedit #nameedit").val(data[0].nombre);
            $("#form-validationedit #fechaedit").val(data[0].fecha);
            $("#form-validationedit #fechaanterioredit").val(data[0].fechanterior);
            $("#form-validationedit #fechasiguienteedit").val(data[0].fechasiguiente);
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
                data: form.serialize(),
                beforeSend: function() {                        
                    /*  $(".almacenarconsulta").prop("disabled",true);
                      console.log("deabilidanto");*/
                },
                success: function (data) {
                    toastr.info("Registro Parámetro Ingresado Correctamente!")
                    console.log(data);
                    var table = $('.table').DataTable(); 
                    table.ajax.reload( null, false );
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
                beforeSend: function() {                        
                    /*  $(".almacenarconsulta").prop("disabled",true);
                      console.log("deabilidanto");*/
                },
                success: function (data) {
                    toastr.info("Regiostro Parámetro Ingresado Ccoreectamente!");
                    console.log(data);
                    var table = $('.table').DataTable(); 
                    table.ajax.reload( null, false );
                    $("#myModaledit").modal('hide');//ocultamos el modal
                    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
                    return false;
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
            ajax: "<?php echo base_url(); ?>parameters/holidays_list"
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
        var idfound =  $tr.find("td:eq(5)").find(".deletes").attr("data-id");
        console.log(idfound);
        $.ajax({    
            url:   '<?php echo base_url( "parameters/holidays_delete" ) ?>',
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
