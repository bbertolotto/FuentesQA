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
        <li><strong>Orden de Embozado</strong></li>
    </ul>

    <!-- End breadcrumb -->
    <div class="row">
      <div class="col-md-12">
          <div class="block">
              <div class="block-title">
                  <h2><strong><?php echo $dataClient["source_description"]?></strong></h2>
              </div>

              <form id="form-valid" method="post" class="form-horizontal form-bordered form-control-borderless">
                <div class="col-sm-12 col-lg-12">
                <div class="block">
                    <div class="block-title">
                        <h2><i class="fa fa-check"></i> Datos Captación</h2>
                    </div>
                    <table class="table table-sm table-striped table-bordered">
                        <tbody>
                            <tr>
                                <td >
                                    <strong>Nombres</strong>
                                </td>
                                <td><?= $dataClient["nombres"]?></td>
                                <td >
                                    <strong>Apellidos</strong>
                                </td>

                                <td><?= $dataClient["apellidos"]?></td>

                                <td >
                                    <strong>Rut</strong>
                                </td>
                                <td><?= $dataClient["rut"]?></td>
                                <td >
                                    <strong>Serie CI</strong>
                                </td>
                                <td><?= $dataClient["serienumdocci"]?></td>
                            </tr>
                            <tr>
                                <td>
                                  <strong>Fecha Nacimiento</strong>
                                </td>
                                <td><?= $dataClient["fechanac"]?></td>
                                <td>
                                  <strong>Estado Civil</strong>
                                </td>
                                <td><?= $dataClient["indestciv"]?></td>
                                <td>
                                  <strong>Nacionalidad</strong>
                                </td>
                                <td><?= $dataClient["codpaisnac"]?></td>
                                <td>
                                    <strong>País de Residencia</strong>
                                </td>
                                <td><?= $dataClient["codpaisres"]?></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Direcci&#243;n</strong>
                                </td>
                                <td><?= $dataClient["direccion"]?></td>
                                <td>
                                  <strong>Comuna</strong>
                                </td>
                                <td><?= $dataClient["codprov"]?></td>
                                <td>
                                 <strong>M&oacute;vil 1</strong>
                                </td>
                                <td><?= $dataClient["telefono3"]?></td>
                                <td>
                                  <strong>M&oacute;vil 2</strong>
                                </td>
                                <td><?= $dataClient["telefono4"]?></td>
                            </tr>
                            <tr>
                                <td>
                                  <strong>Tel&eacute;fono 1</strong>
                                </td>
                                <td><?= $dataClient["telefono1"]?></td>
                                <td>
                                  <strong>Tel&eacute;fono 2</strong>
                                </td>
                                <td><?= $dataClient["telefono2"]?></td>
                                <td>
                                  <strong>Email 1</strong>
                                </td>
                                <td><?= $dataClient["email1"]?></td>
                                <td>
                                  <strong>Email 2</strong>
                                </td>
                                <td><?= $dataClient["email2"]?></td>
                            </tr>
                            <tr>
                                <td>
                                 <strong>Nº de Tarjeta</strong>
                                </td>
                                <td><?php $pan = substr_replace($dataClient["nrotcv"], "****-****-****", 0, 14 ); echo $pan?></td>
                                <td>
                                  <strong>Cupo Tarjeta</strong>
                                </td>
                                <td><?= $dataClient["cupo"]?></td>
                                <td>
                                  <strong>Contrato Seguro Desgravamen</strong>
                                </td>
                                <td><?= $dataClient["indsegdes"]?></td>
                                <td>
                                 <strong>Días Pago</strong>
                                </td>
                                <td><?= $dataClient["grupocuo"]?></td>
                            </tr>
                            <tr>
                                <td>
                                  <strong>Institución Previsión Social</strong>
                                </td>
                                <td><?= $dataClient["inssaludprev"]?></td>
                                <td>
                                  <strong>Número Captación</strong>
                                </td>
                                <td><?= $dataClient["autorizador"]?></td>
                                <td>
                                  <strong>¿Despacho EECC Email?</strong>
                                </td>
                                <td><?= $dataClient["eeccemail"]?></td>
                                <td>
                                  <strong>Origen</strong>
                                </td>
                                <td><?= $dataClient["origen"]?></td>
                                <input type="hidden" id="numberCapturing" value="<?= $dataClient["autorizador"]?>">
                                <input type="hidden" id="statusCapturing" value="">
                            </tr>

                        </tbody>
                    </table>

                </div>
              </div>


            <div class="form-group text-center">
                <div class="col-xs-12">
                  <button type="button" class="btn-action btn btn-success" data-target="accept" ><i class="fa fa-check"></i> Aceptar</button>
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
<input type="hidden" id="nrotcv" value="<?=$dataClient["masknrotcv"]?>">
<input type="hidden" id="cupo" value="<?=$dataClient['cupo']?>">

</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>
<?php $this->load->view('ModalValid'); ?>
<!-- Javascript exclusivos para esta página -->

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script language="javascript">

$(function () {

    $('.btn-action').on('click', function () {

        if($(this).data('target')=="accept"){

          $("#btn-accept-request").val("accept");
          Alert.showRequest("<h3><strong>ENVIAR A EMBOZAR TARJETA CLIENTE<strong></h3>","<strong><h4>Presione Aceptar para confirmar<br></h4></strong><br>");
  
        }

        if($(this).data('target')=="deny"){

          $("#btn-accept-request").val("deny");
          Alert.showRequest("<h3><strong>RECHAZAR EMBOZADO TARJETA CLIENTE<strong></h3>","<strong><h4>Presione Aceptar para confirmar<br></h4></strong><br>");

        }

    });

    $('.btn-modal-request').on('click', function () {

      if($(this).data('target')=="accept"){

          if( $("#btn-accept-request").val()=="deny" || $("#btn-accept-request").val()=="accept" ) {

            var formData = new FormData();
            formData.append("numberCapturing", $("#numberCapturing").val());
            formData.append("statusCapturing", $("#btn-accept-request").val());

            var response = Teknodata.call_ajax("/capturing/formalize", formData, false, true, ".btn-accept");
            if(response!=false){

                if(response.retorno == 0){

                    $.redirect("/capturing/search");

                }else{

                    Alert.showWarning("", response.descRetorno, "");
                }
            }

            return(true);

          }

      }
        

    });

    $('.btn-cancel').on('click', function () { $.redirect("/capturing/search") } );

});

</script>
</body>
</html>
