<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js">
<!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">
    <ul class="breadcrumb breadcrumb-top">
        <li>Flujos comerciales</li>
        <li>S&#250;per Avances</li>
        <li>Buscar</a></li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                  <div class="block-options pull-right">
                      <h2>Modo: <strong><?= $this->session->userdata('attention_mode');?></strong></h2>
                  </div>
                  <h2><strong><?= $this->lang->line('Super Advance');?></strong></h2>
                    <i class="fa fa-angle-right"></i> Seleccione atributos para busqueda
                </div>
                <form id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">

                  <div class="form-group">


                      <div class="col-md-2">
                        <label for="masked_rut_client">N&#250;mero RUT Cliente</label>
                        <div class="input-group">
                          <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center col-sm-12" onchange="Teknodata.masked_nroRut(this);" onkeypress="return Teknodata.masked_onlyRut(event);"
                          onkeyup="Teknodata.masked_nroRut(this);">
                        </div>
                      </div>

                      <div class="col-md-2">
                          <label for="numberRequest">C&#243;digo SAV</label>
                          <div class="input-group">
                            <input type="text" id="numberRequest" name="numberRequest" class="form-control text-center col-sm-12" maxlength="6" data-toggle="tooltip" data-placement="top" title="Número SAV" onkeypress="return Teknodata.masked_onlyNumber(event);">
                          </div>
                      </div>

                      <div class="col-md-2">
                          <label for="officeSkill">Sucursal</label>
                          <div class="input-group">

<?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL OR $this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING):?>

              <select id="officeSkill" name="officeSkill" class="form-control col-sm-12" disabled>
                <?php echo $dataOffice["optionOffice"] ?>
              </select>

<?php else:?>

              <select id="officeSkill" name="officeSkill" class="form-control col-sm-12" >
                <?php echo $dataOffice["optionOffice"] ?>
              </select>

<?php endif;?>

                          </div>
                      </div>

                      <div class="col-md-2">
                          <label for="typeRequestSkill">Estado SAV</label>
                          <div class="input-group">

                            <select id="typeRequestSkill" name="typeRequestSkill" class="form-control col-sm-12" >
                              <?php

                                echo '<option value="">TODOS</option>';

                                foreach ($dataRequestStatus as $nodo) {
                                    echo '<option value="'.$nodo->ID.'">'.$nodo->NAME.'</option>';
                                }?>
                            </select>

                          </div>
                      </div>

                      <div class="col-md-2">
                          <label for="dateBegin">Fecha Inicio</label>
                          <div class="input-group">
                              <input type="text" id="dateBegin" name="dateBegin" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?php echo '01-' . date('m-Y'); ?>">
                              <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                          </div>

                      </div>

                      <div class="col-md-2">
                          <label for="dateEnd">Fecha Termino</label>
                          <div class="input-group">
                              <input type="text" id="dateEnd" name="dateEnd" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>">
                              <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                          </div>

                      </div>

                  </div>

                  <div class="form-group text-center">
                      <button type="submit" class="btn btn-success" data-target="search"><i class="fa fa-search"></i> Buscar</button>
                      <button type="button" class="btn btn-warning" onclick="Client.clearInput();"><i class="gi gi-refresh"></i> Limpiar</button>
<?php if($this->session->userdata("id_rol")<5):?>
                      <button type="button" class="btn-action btn btn-danger" data-target="simulate" data-action="/advance/simulate"><i class="gi gi-adjust_alt"></i> Simular SAV</button>
          <?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_TELEMARKETING):?>
              <button type="button" class="btn-action btn btn-danger" data-target="create" data-action="/advance/remote"><i class="gi gi-circle_plus"></i> Crear SAV</button>
          <?php else:?>
              <button type="button" class="btn-action btn btn-danger" data-target="create" data-action="/advance/create"><i class="gi gi-circle_plus"></i> Crear SAV</button>
          <?php endif;?>
<?php endif;?>

                  </div>

                </form>


            </div>
        </div>
        <!--End col-md-6-->
    </div>

    <div class="row" id="client-details" style="display:none;">

        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2>Detalle S&#250;per <strong>Avances</strong></h2>
                </div>

                <div id="client-request">

                </div>

            </div>
        </div>
    </div>
    <!--END row-->
<input type="hidden" id="id_office" value="<?= $this->session->userdata('id_office');?>">
<input type="hidden" id="yesidStatus" >
<input type="hidden" id="noidStatus" >
<input type="hidden" id="attention_mode" value="<?= $this->session->userdata("attention_mode");?>">
</div>
<!-- End page-content-->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalLink'); ?>
<?php $this->load->view('ModalAlert'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script language="Javascript">
$(function () {
    $('.btn-action').on('click', function () {
        if($(this).data("target")=="simulate") { $.redirect( $(this).data("action") ); }
        if($(this).data("target")=="create") { $.redirect( $(this).data("action") ); }
    });
    $('.btn-action-link').on('click', function () {
        if($(this).data("action")=="cancel") { return(true); }
        if($(this).data("action")=="accept") { idStatus = $("#yesidStatus").val(); }
        if($(this).data("action")=="deny") { idStatus = $("#noidStatus").val(); }

        var formData = new FormData();
        formData.append("idDocument", $("#idDocument").val());
        formData.append("idStatus", idStatus);

        var response = Teknodata.call_ajax("/advance/changeLinked", formData, false, true, ".btn-action-link");
        if(response!=false){

            if(response.retorno == 0){
                toastr.warning("Estado Enlace actualizado!", "Preste Atenci&#243;n");
                $(".close").click();
            }else{
                Alert.showToastrWarning(response);
            }
        }
    });
});

var Client = function() {
    return {
        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },
        evaluate: function() {
            var aa = document.getElementById('masked_rut_client');
            var ae = document.getElementById('numberRequest');
            var ai  = document.getElementById('typeRequestSkill');
            var ao  = document.getElementById('dateBegin');
            var au  = document.getElementById('dateEnd');
            if(aa.value==""&&ae.value==""&&ao.value==""&&au.value==""){
                toastr.warning("Para realizar una busqueda debe ingresar al menos un dato ..","Preste Atencíón..");
            }else{return(true);}
        },
        showAssign: function(idDocument, nroRut) {

            nroRut = nroRut;
            var formData = new FormData();
            formData.append("idDocument", idDocument);

            var response = Teknodata.call_ajax("/advance/getRequestLinked", formData, false, true, "");
            if(response!=false){

                if(response.retorno!=0){
                    Alert.showToastrWarning(response);
                    return(false); }

                $.redirect("/advance/assignRequest", { idDocument: idDocument, idEstado: response.tipoEstado, nroRut: nroRut } );
            }
            return(false);
        },
        showLinked: function(idDocument) {

            var formData = new FormData();
            formData.append("idDocument", idDocument);

            var response = Teknodata.call_ajax("/advance/getRequestLinked", formData, false, true, "");
            if(response!=false){

                if(response.retorno!=0){
                    Alert.showToastrWarning(response);
                    return(false); }
                if(response.estadoEnlace=="") {
                    Alert.showWarning("Preste Atenci&#243;n","Cotizaci&#243;n no registra solicitud de Enlace !","md");
                    return (false);}
                if(response.sucursalOrigen==""||response.sucursalDestino==""||response.sucursalOrigen=="-"||response.sucursalDestino=="-"){
                      Alert.showWarning("Preste Atenci&#243;n","Solicitud de Enlace no registra Sucursal Origen->Destino ","md");
                      return(false); }
                if(id_office==response.sucursalOrigen&&response.estadoEnlace!="ENL") {
                    Alert.showWarning("Preste Atenci&#243;n","Autorización Oficina Origen no esta disponible !","md");
                    return(false);
                }else{
                    if(id_office==response.sucursalDestino&&response.estadoEnlace!="AUO") {
                        Alert.showWarning("Preste Atenci&#243;n","Autorización Oficina Destino no disponible !","md");
                        return(false);
                    }
                }

                Client.restore();
                $("#idDocument").val(idDocument);
                $("#fechaSolicitud").val(response.fechaSolicitud);
                $("#fechaVigencia").val(response.fechaVigencia);
                $("#nameSucursalOrigen").val(response.nameSucursalOrigen);
                $("#nameSucursalDestino").val(response.nameSucursalDestino);
                if(id_office==response.sucursalOrigen) { $("#yesidStatus").val("AUO"); $("#noidStatus").val("REO"); }
                if(id_office==response.sucursalDestino) { $("#yesidStatus").val("AUD"); $("#noidStatus").val("RED"); }
                if($("#yesidStatus").val()==""||$("#noidStatus").val()==""){
                    Alert.showWarning("Preste Atenci&#243;n..","No puede modificar, no hay asignaci&#243;n de Estado !","md");
                    return(false); }

                $('.modal-link-approbation').modal({show:true,backdrop:'static'});
            }
            return(false);
        },
        prepare: function() {
          document.getElementById("client-details").style.display = "none";
        },
        restore: function() {
          e = document.getElementById("client-details");e.style.display = "";
        },
        clearInput: function () {
            document.getElementById("masked_rut_client").value="";
            document.getElementById("numberRequest").value="";
            document.getElementById("dateBegin").value="";
            document.getElementById("dateEnd").value="";
            document.getElementById('typeRequestSkill').value="";
        },
        search: function() {

            if($("#dateBegin").val()!="" && $("#dateEnd").val()=="") { $("#dateEnd").val($("#dateBegin").val() ); }
            if($("#dateEnd").val()!="" && $("#dateBegin").val()=="") { $("#dateBegin").val($("#dateEnd").val() ); }

            var formData = new FormData();
            formData.append("nroRut", $("#masked_rut_client").val());
            formData.append("numberRequest", $("#numberRequest").val());
            formData.append("typeRequestSkill", $("#typeRequestSkill").val());
            formData.append("dateBegin", $("#dateBegin").val());
            formData.append("dateEnd", $("#dateEnd").val());
            formData.append("officeSkill", $("#officeSkill").val());

            var response = Teknodata.call_ajax("/advance/get_request_for_quote", formData, false, true, "");
            if(response!=false){

                if(response.retorno == 0){

                    e = document.getElementById('client-request');
                    e.innerHTML = response['htmlRequest'];
                    Client.restore();

                }else{

                    Alert.showWarning("Preste Atención", response.descRetorno);
                }
            }

        },
        init: function() {
            $.validator.addMethod("evalrut", function( value, element ) {
            return this.optional( element ) || Teknodata.validateRut( value );
            });
            $('#form-client').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                unhighlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                submitHandler: function(form) {
                  Client.prepare();Client.search();
                },
                rules: {
                    masked_rut_client: {required: false, evalrut: true, minlength: 5, maxlength: 12},
                },
                messages: {
                    masked_rut_client: {required:'Ingrese número RUT', evalrut:'Ingrese RUT valido!'},
                }
            });
            $('#dateBegin').mask('99-99-9999');
            $('#dateEnd').mask('99-99-9999');
        }
    };
}();
$(function(){ Client.init(); });
$(function(){ Client.prepare();});
</script>

</body>
</html>
