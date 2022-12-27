<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>

<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
        <li><strong><?= $this->lang->line('Capturing Flows');?></strong></li>
        <li><a href="/capturing/search"><strong><?= $this->lang->line('Search');?></strong></a></li>
        <li><a href="/capturing/approved"><strong><?= $this->lang->line('Capturing');?></strong></a></li>
        <li><strong><?= $this->lang->line('Validation');?></strong></li>
    </ul>

    <!-- End breadcrumb -->
    <div class="row">
      <div class="col-md-12">
          <div class="block">
              <div class="block-title">
                  <h2><strong>Validaci&#243;n Solicitud Impresión Plásticos</strong></h2>
              </div>

              <form id="form-valid" method="post" class="form-horizontal form-bordered form-control-borderless">

                <div class="col-sm-12 col-lg-12">
                <div class="block">
                    <div class="block-title">
                        <h2><i class="fa fa-check"></i> Bloqueo / Reposición</h2>
                    </div>
                    <table class="table table-sm table-striped table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                   <strong>Nº de Tarjeta</strong>
                                </td>
                                <td>
                                   <strong>Estado</strong>
                                </td>
                                <td>
                                   <strong>Rut</strong>
                                </td>
                                <td >
                                    <strong>Cliente</strong>
                                </td>
                                <td >
                                    <strong>Descripción</strong>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo "*** *** *** " . substr($dataClient["nrotcv"],15,4); ?></td>
                                <td><?= $dataClient["desclave3"]?></td>
                                <td><?= $dataClient["rut"]?></td>
                                <td><?= $dataClient["nombres"].' '.$dataClient["apellidos"]?></td>
                                <td><?= $dataClient["desclave1"]?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
              </div>


            <div class="form-group text-center">
                <div class="col-xs-12">
                  <button type="button" class="btn-action btn btn-success" data-target="reprint" ><i class="fa fa-check"></i> Aceptar</button>
                  <button type="button" class="btn-action btn btn-danger " data-target="deny"><i class="fa fa-refresh"></i> Rechazar</button>
                  <button type="button" class="btn-cancel btn btn-info " data-target="cancel"><i class="hi hi-remove"></i> Cancelar</button>
                </div>
            </div>

          </div>

        </div>
        </form>
    </div>
    <!--End Block principal-->

<input type="hidden" id="rut" value="<?=$dataClient['rut']?>">
<input type="hidden" id="nombres" value="<?=$dataClient['nombres']?>">
<input type="hidden" id="apellidos" value="<?=$dataClient['apellidos']?>">
<input type="hidden" id="nrotcv" value="<?=$dataClient['nrotcv']?>">
<input type="hidden" id="motivo" value="<?=$dataClient['desclave3']?>">
<input type="hidden" id="numberCapturing" value="<?=$dataClient['autorizador']?>">

</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>

<script>

$(function () {

    $('.btn-action').on('click', function () {

        if($(this).data('target')=="deny"){

          $("#btn-accept-request").val("deny");
          Alert.showRequest("<h3><strong>RECHAZAR REIMPRESI&#211;N TARJETA DE CR&#201DITO<strong></h3>","<strong><h4>Presione Aceptar para confirmar<br></h4></strong><br>");
          return(false);

        }

        if($(this).data('target')=="reprint"){

          $("#btn-accept-request").val("reprint");
          Alert.showRequest("<h3><strong>AUTORIZAR REIMPRESI&#211;N TARJETA DE CR&#201DITO<strong></h3>","<strong><h4>Presione Aceptar para confirmar<br></h4></strong><br>");
          return(false);

        }

    });


    $('.btn-modal-request').on('click', function () {

          if($(this).data("target")=="accept") {

              var formData = new FormData();
              formData.append("numberCapturing", $("#numberCapturing").val());
              formData.append("requestCapturing", $("#btn-accept-request").val());
              var response = Teknodata.call_ajax("/capturing/valid_reprint_credit_card", formData, false, true, ".btn-action");

              if(response!=false){

                  $.redirect("/capturing/search");

              }

          }

          return(false);

    });

    $('.btn-cancel').on('click', function () { $.redirect("/capturing/search") } );

});
</script>
</body>
</html>
