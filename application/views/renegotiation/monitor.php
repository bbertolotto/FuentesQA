<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js">
<!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head');?>
<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
      <li><strong>Flujos comerciales</strong></li>
      <li><strong>Renegociar</strong></li>
      <li><strong>Procesos Automáticos</strong></li>
      <li>Monitor</li>
      <li><a href="/renegotiation/shedule" onclick="Client.processShow();">Agendar</a></li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Monitor</strong></h2>
                      <i class="fa fa-angle-right"></i> Seleccione atributos para busqueda
                </div>
                <form id="form-client" method="post" class="form-horizontal form-bordered form-control-borderless">

                  <fieldset>

<?php if ($this->session->userdata("id_rol") != USER_ROL_SUPERVISOR_CALIDAD and $this->session->userdata("id_rol") != USER_ROL_SUPERVISOR_EXCEPCIONES): ?>
                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">&nbsp;</div>
<?php endif;?>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                        <label for="masked_rut_client">N&#250;mero RUT Cliente</label>
                        <input type="text" id="masked_rut_client" name="masked_rut_client" maxlength="12" class="form-control text-center col-sm-12" onchange="Teknodata.masked_nroRut(this);" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this);">
                    </div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                          <label for="status">Estado Renegociación</label>
                          <select id="status" name="status" class="form-control text-center" >
                              <?php
foreach ($status as $nodo) {
    echo '<option value="' . $nodo->ID . '">' . $nodo->NAME . '</option>';
}?>
                            </select>
                    </div>
<?php if ($this->session->userdata("id_rol") == USER_ROL_SUPERVISOR_CALIDAD or $this->session->userdata("id_rol") == USER_ROL_SUPERVISOR_EXCEPCIONES): ?>
                    <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                          <label for="username">Usuario Creador</label>
                          <input type="text" id="username" name="username" maxlength="50" class="form-control text-center col-sm-12">
                    </div>
<?php else: ?>
                    <input type="hidden" name="username" id="username" value="">
<?php endif;?>
                    <input type="hidden" id="id_rol" value="<?=$this->session->userdata("id_rol")?>">

                    <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                        <label for="dateBegin">Fecha Desde</label>
                        <div class="input-group">
                          <input type="text" id="dateBegin" name="dateBegin" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?=$environment['dateBegin']?>">
                          <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                      </div>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                        <label for="dateEnd">Fecha Hasta</label>
                        <div class="input-group">
                          <input type="text" id="dateEnd" name="dateEnd" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?=$environment['dateEnd']?>">
                          <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                      </div>
                    </div>

                  </fieldset>

                  <fieldset>

                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                      <button type="reset" class="btn btn-reset btn-warning"><i class="gi gi-refresh"></i> Limpiar</button>
                    </div>

                  </fieldset>

                </form>

            </div>
        </div>
        <!--End col-md-12-->
    </div>

    <div class="row" id="client-details" >
      <div class="col-md-12">

      <div class="block">
          <div class="block-title">
              <h2><strong>Detalle</strong><span id="nombrecliente"></span> <strong> Renegociaciones en Proceso</strong></h2>
          </div>

          <div class="table-responsive ">
              <table class="table table-vcenter dataview">
                  <thead>
                      <tr>
                          <th class="text-left">ID</i></th>
                          <th class="text-left">RUT</i></th>
                          <th class="text-left">Cliente</i></th>
                          <th class="text-left">Fecha Creaci&oacute;n</th>
                          <th class="text-left">Detalle</th>
                          <th class="text-center">TPD</th>
                          <th class="text-center">ACL</th>
                          <th class="text-center">REN</th>
                          <th class="text-center">BLQ</th>
                          <th class="text-center">COM</th>
                          <th class="text-center">AVA</th>
                          <th class="text-center">ACT</th>
                          <th class="text-center">NVG</th>
<?php if($this->session->userdata("id_rol")==USER_ROL_JEFE_COBRANZA):?>
                          <th class="text-center">Acci&oacute;n</th>
<?php endif;?>
                          <th class="text-left">Estado</th>
                      </tr>
                  </thead>
              </table>
              <label class="">TPD=Pago Deuda / ACL=Aceleración deuda /  REN=Crea Renegociación / BLQ=Bloqueo Cuenta / COM=Act. Cupo Compras / AVA=Act. Cupo Avance / ACT=Act. Estado REN / NVG=Act. REN No Vigentes</label>
          </div>

      </div>

      </div>

    </div>

    <!--END row-->
<input type="hidden" id="idRefinanciamiento" name="idRefinanciamiento">
<input type="hidden" id="todayDate" value="<?=$environment['dateBegin']?>">

</div>
<!-- End page-content-->
<?php $this->load->view('footer');?>
<?php $this->load->view('ModalAlert');?>
<?php $this->load->view('ModalCreate');?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>

<script language="javascript">

var dataview = $(".dataview").DataTable({
    "language": {
        "url": "/vendor/datatables/Spanish.json"
    },
    responsive: true,
    dom: "Bfrtip",
    searching: true,
    ajax: {
      url: "/renegotiation/list_process_renegotiation",
      type: "POST",
      "data":function(d){
          d.masked_rut_client = $("#masked_rut_client").val();
          d.dateBegin = $("#dateBegin").val();
          d.dateEnd = $("#dateEnd").val();
          d.status = $("#status").val();
          }
    },
    drawCallback: function () {
        $('[data-toggle="tooltip"]').tooltip();
     },
});


$("#form-client").submit(function( event ) {
    event.preventDefault();
    $data = $('#form-client').serialize();
    dataview.clear().draw();
    dataview.ajax.reload( null, false );
    return(false);
});

$(".btn-reset").click(function () {
    $("#dateBegin").val($("#todayDate").val());
    $("#dateEnd").val($("#todayDate").val());
});

var Client = function() {
    return {
        cancelRenegotiation: function($id) {

            var formData = new FormData();
            formData.append("id", $id);
            var response = Teknodata.call_ajax("/renegotiation/cancelRenegotiation", formData, false, true, ".btn-success");
            if(response){
                Alert.showAlert(response.descRetorno);
                $data = $('#form-client').serialize();
                dataview.clear().draw();
                dataview.ajax.reload( null, false );

//                if(response.retorno==0){ $(".btn-success").click(); }
            }

        }
    };
}();


</script>

</body>
</html>





