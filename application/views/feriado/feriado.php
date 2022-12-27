<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">
    <ul class="breadcrumb breadcrumb-top">
        <li><strong>Feriados</strong></li>
       
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title text-left">
                    <h2><strong> Control de feriados</strong></h2>
                </div>
                 <form id="form-validation" action="<?= base_url() ?>feriado/addferiado" method="post" class="form-horizontal form-bordered">
                                        <fieldset>
                                            <legend><i class="fa fa-angle-right"></i>Informacion de feriados</legend>
                                          


                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Nombre <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="name" name="name" class="form-control" placeholder="Ingrese Nombre">
                                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                    </div>
                                                </div>
                                            </div>


                                             <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Fecha <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="fecha" name="fecha" class="form-control input-datepicker" placeholder="Ingrese Fecha">
                                                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            


                                        <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Dia habil anterior <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="fechaanterior" name="fechaanterior" class="form-control input-datepicker" placeholder="Ingrese Fecha anterior">
                                                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Dia habil siguiente <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="fechasiguiente" name="fechasiguiente" class="form-control input-datepicker" placeholder="Ingrese Fecha siguiente">
                                                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                      
                                        </fieldset>
                                      
                                        
                                        <div class="form-group form-actions">
                                            <div class="col-md-8 col-md-offset-4">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Submit</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre del dia feriado</th>
                                                <th>Periodo</th>
                                                <th>Fecha</th>
                                                <th>Dia habil anterior</th>
                                                <th>Dia habil siguiente</th>
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
        <h4 class="modal-title">Editar consulta</h4>
      </div>
      <div class="modal-body">
            <form id="form-validationedit" action="<?= base_url() ?>feriado/editferiado" method="post" class="form-horizontal form-bordered">
                                        <fieldset>
                                            <legend><i class="fa fa-angle-right"></i>Informacion de feriados</legend>
                                          
<input type="hidden" id="iditems" name="iditems" >

                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Nombre <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="nameedit" name="nameedit" class="form-control" placeholder="Ingrese Nombre">
                                                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                                    </div>
                                                </div>
                                            </div>


                                             <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Fecha <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="fechaedit" name="fechaedit" class="form-control input-datepicker" placeholder="Ingrese Fecha">
                                                        <span class="input-group-addon"><i class="gi gi-date"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                           


                                              <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Dia habil anterior <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="fechaanterioredit" name="fechaanterioredit" class="form-control input-datepicker" placeholder="Ingrese Fecha anterior">
                                                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-md-4 control-label" for="val_username">Dia habil siguiente <span class="text-danger">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="fechasiguienteedit" name="fechasiguienteedit" class="form-control input-datepicker" placeholder="Ingrese Fecha siguiente">
                                                        <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                      
                                        </fieldset>
                                      
                                        
                                        <div class="form-group form-actions">
                                            <div class="col-md-8 col-md-offset-4">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Submit</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
            </div>
        </div>
    </div>

  


  
    <!--END row-->

<?php $this->load->view('ModalAlert'); ?>
</div>
<!-- End page-content-->

<?php $this->load->view('footer'); ?>
<!-- Javascript exclusivos para esta página -->
<script src="<?= base_url();?>js/pages/Alert.js"></script>
<script src="<?= base_url();?>js/TeknodataSystems.js"></script>
<script src="<?= base_url();?>js/client/Documents.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script type="text/javascript">



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
                            url: "<?= base_url() ?>feriado/buscar",
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



  
        $('.input-datepicker').datepicker({weekStart: 1});



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

                                 toastr.info("Datos ingresados")
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

                                 toastr.info("Datos ingresados")
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
                        required: true,
                      
                    },
                    fechaedit: {
                        required: true
                    
                    }
                },
                messages: {
                   
                    nameedit: {
                        required: 'Nombre del dia feriado',
                      
                    },
                     fechaedit: {
                        required: 'Fecha del dia feriado',
                      
                    }
                    
                }
            });


  var table =  $('.table').DataTable({
        ajax: "<?php echo base_url(); ?>feriado/listado",

    });


    $('.table tbody').on('click', '.deletes', function () {   
     console.log("eliminar");  

Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {

 var btn = this;
                        $tr = $(this).closest('tr');
                        var data = table.row($tr).data();          
                        table.row($(btn).parents('tr')).remove().draw(false);
                        var idfound =  $tr.find("td:eq(5)").find(".deletes").attr("data-id");
                        console.log(idfound);
                         $.ajax({    
                            url:   '<?php echo base_url( "feriado/delete" ) ?>',
                             type: "GET",
                              data: { id : idfound },    
                              beforeSend: function () {
                              },
                              success:  function (response) {
                                        console.log(response);
                                     toastr.info("Datos eliminado")
                              }
                            }); 




    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})


return false;
           
                        
                   
              



      });

</script>
</body>

</html>
