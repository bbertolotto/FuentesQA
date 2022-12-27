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
        <li><a href="<?= base_url();?>parameters/holidays"><strong><?= $this->lang->line('Holidays');?></strong></a></li>
        <li><a href="<?= base_url();?>parameters/rejection"><strong><?= $this->lang->line('Reasons Rejection');?></strong></a></li>
        <li><strong><?= $this->lang->line('Deferred Fees');?></strong></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title text-left">
                    <h2><strong><?= $this->lang->line('Config');?> <?= $this->lang->line('Deferred Fees');?></strong></h2>
                </div>
                 <form id="form-validation" action="<?= base_url() ?>parameters/deferred_add" method="post" class="form-horizontal form-bordered">
                    <fieldset>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name_item">Descripci&#243;n Producto <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-4">
                                    <input type="text" id="name_item" name="name_item" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-md-4 control-label" for="value_min">Minimo Cuotas Diferir <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-4">
                                    <input type=text id="value_min" name="value_min" class="form-control" placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="value_max">Maximo Cuotas Diferir <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-4">
                                    <input type="text" id="value_max" name="value_max" class="form-control" placeholder="0">
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
                            <th>Producto</th>
                            <th>M&#237;nimo Cuotas</th>
                            <th>M&#225;ximo Cuotas</th>
                            <th>Botones Disponibles</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
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
            <form id="form-validationedit" action="<?= base_url() ?>parameters/deferred_edit" method="post" class="form-horizontal form-bordered">
                        <fieldset>
                        <legend><i class="fa fa-angle-right"></i><?= $this->lang->line('Deferred Fees');?></legend>

                        <input type="hidden" id="iditems" name="id_item" >

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name_item">Descripci&#243;n Producto <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-4">
                                    <input type="text" id="name_iteme" name="name_iteme" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-md-4 control-label" for="value_min">Minimo Cuotas Diferir <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-4">
                                    <input type=text id="value_mine" name="value_mine" rows="3" class="form-control" placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="value_max">Maximo Cuotas Diferir <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group col-sm-4">
                                    <input type="text" id="value_maxe" name="value_maxe" rows="3" class="form-control" placeholder="0">
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

<?php $this->load->view('ModalAlert'); ?>
</div>
<!-- End page-content-->
<?php $this->load->view('footer'); ?>
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
        url: "<?= base_url() ?>parameters/deferred_search",
        data: { id: recipient },
        dataType: "json",
        beforeSend: function() {                        

        },
        success: function (data) {
            $("#form-validationedit #iditems").val(data[0].id_item);
            $("#form-validationedit #name_iteme").val(data[0].name_item);
            $("#form-validationedit #value_mine").val(data[0].value_min);
            $("#form-validationedit #value_maxe").val(data[0].value_max);
        },
        complete: function() {
        }
        });
})

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
            name_item: { required: true },
            value_min: { required: true, number: true },
            value_max: { requierd: true, number: true }
        },
        messages: {
            name_item: { required: 'Debe ingresar Identificación del Producto'  },
            value_min: { required: 'Debe ingresar Mínimo Cuotas Diferir', number: 'number 1' },
            value_max: { required: 'Debe ingresar Máximo Cuotas Diferir', number: 'number 2' }
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
                    toastr.info("Registro Parámetro Ingresado Ccoreectamente!");
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
                    name_item: { required: true },
                    value_min: { required: true },
                    value_max: { requierd: true }
                },
                messages: {
                    name_item: { required: 'Debe ingresar Identificación del Producto' },
                    value_min: { required: 'Debe ingresar Mínimo Cuotas Diferir' },
                    value_max: { required: 'Debe ingresar Máximo Cuotas Diferir' }
                }
});

var table =  $('.table').DataTable({
ajax: "<?php echo base_url(); ?>parameters/deferred_list"
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
            url:   '<?php echo base_url( "parameters/deferred_delete" ) ?>',
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
