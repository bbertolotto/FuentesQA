<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>

<div id="page-content">
    <div class="content-header">
        <ul class="nav-horizontal text-center">
            <li><a href="/client/search" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-search"></i> Buscar</a></li>
            <li><a href="/client/consolidate" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-crop"></i> Consolidado</a></li>
            <li><a href="/client/information" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-user"></i> Personales</a></li>
            <li><a href="/client/contact" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-phone"></i> Contacto</a></li>
            <li><a href="/client/lasttransaction" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-transfer"></i> Transacciones</a></li>
            <li class="active"><a href="/client/lastaccount" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt"></i> Detalle EECC</a></li>
            <li><a href="/client/secure" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-warning_sign"></i> Seguros</a></li>
            <li><a href="/client/replacecard" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card"></i> Reponer Tarjeta</a></li>
        </ul>
    </div>

    <ul class="breadcrumb breadcrumb-top">
      <li><strong>Centro de servicios</strong></li>
      <li><a href="<?= base_url();?>client/search"><strong>B&#250;squeda Clientes</strong></a></li>
      <li><strong>&#218;ltimos EECC</strong></li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="row">
                <div class="block">

                    <div class="block-title">
                        <h2><strong>&#218;ltimos EECC Emitidos </strong><?=$this->session->userdata('nombre_cliente').' '.$this->session->userdata('apellido_cliente')?></h2>
                    </div>
                    <div id="divEECC" class="table-responsive">
                        <table class="table table-striped table-bordered " border="0" id="tabEECC">
                            <thead>
                                <tr data-toggle="tooltip" data-placement="top" title="Posiciona el Mouse sobre la columna que desea orderar y CLICK para ordenar">
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(0,7)"><strong>Fecha Emisi&#243;n</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(1,7)"><strong>Fecha Vencimiento</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(2,7)"><strong>Pago M&#237;nimo</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(3,7)"><strong>Estado</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(4,7)"><strong>Pago del Mes</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(5,7)"><strong>Monto Cancelado</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(6,7)"><strong>Monto Cuota</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(7,7)"><strong>Deuda Total &#218;ltimo EECC</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(8,7)"><strong>Monto Avance</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(9,7)"><strong>Monto Revolving</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(10,7)"><strong>Gastos y Cargos</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(11,7)"><strong>Inter&#233;s Corriente</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(12,7)"><strong>Inter&#233;s Mora</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(13,7)"><strong>Total Impuesto</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(14,7)"><strong>Tipo Despacho</strong></th>
                                    <th scope="col" class="text-center" onclick="Teknodata.sortTable(15,7)"><strong>Monto Venta</strong></th>
                                    <!--th scope="col" class="text-center" onclick="Teknodata.sortTable(16,7)"><strong>Ver EECC</strong></th-->
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($dataEECC as $record) { ?>
                                    <tr >
                                        <td scope="col" class="text-center"><?= $record["fechaDeCorte"]; ?></td>
                                        <td scope="col" class="text-center"><?= $record["fechaVencimiento"]; ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["pagoMinimo"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-center"><?= $record["estadoEECC"] ; ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["pagoDelMes"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["montoPagadoEECC"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["montoCuota"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["montoTotalFacturado"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["montoAvance"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["montoRevolving"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["gastosyCargos"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-center"><?= $record["tasaInteresCorriente"]; ?>%</td>
                                        <td scope="col" class="text-center"><?= $record["tasaInteresMoratorio"]; ?>%</td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["totalImpuesto"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-center"><?= $record["envioCorrespondecia"]; ?></td>
                                        <td scope="col" class="text-right">$<?= number_format((float)$record["montoVenta"], 0, ',', '.'); ?></td>
                                        <td scope="col" class="text-center">
<button type="button" class="btn-xs btn-success" onclick="Client.showEECC('<?= $record["fechaDeCorte"]; ?>');" data-pan="<?= $record["fechaDeCorte"];?>"><i class="hi hi-print" title="Revisar EECC"></i></button>
                                            </td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!--END col-md-12-->
    </div>
    <!--END row-->
<input type="hidden" id="pan" value="<?= $dataAccount["nroTcv"]?>">
</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<!-- Javascript exclusivos para esta pagina -->
<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script language="javascript">
var Client = function() {
    return {
        init: function() {
        },
        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },
        showEECC: function(fechaEmision) {

            var formData = new FormData();
            formData.append("fechaEmision", fechaEmision);
            formData.append("numTarjeta", $("#pan").val());

            var response = Teknodata.call_ajax("/utils/showEECC", formData, false, true, "");
            if(response!=false){

              if(response.retorno == 0) {

                  if(response.PDF!=""){

                    var objbuilder = '';
                    objbuilder += ('<object width="100%" height="100%" data="data:application/pdf;base64,');
                    objbuilder += (response.PDF);
                    objbuilder += ('" type="application/pdf" class="internal">');
                    objbuilder += ('<embed src="data:application/pdf;base64,');
                    objbuilder += (response.PDF);
                    objbuilder += ('" type="application/pdf"  />');
                    objbuilder += ('</object>');

                    var win = window.open("#","_blank");
                    win.document.write('<html><title>'+ response.title +'</title><body style="margin-top: 0px; margin-left: 0px; margin-right: 0px; margin-bottom: 0px;">');
                    win.document.write(objbuilder);
                    win.document.write('</body></html>');
                    layer = jQuery(win.document);

                  }else{

                      toastr.warning("Servicio EECC, no retorna información para el periodo seleccionado..!! </br><?php echo ATENTION_HELPDESK?>", "Transacción Rechazada");

                  }


              } else {

                  if(response.retorno==406 || response.retorno==401){

                      toastr.warning("Cliente no tiene EECC para el periodo seleccionado", "Transacción Rechazada");
                  }else{
                      Alert.showToastrWarning(response);
                  }
              }
            }
            return (true);
        }
    };

}();
$(function(){ Client.init(); });
</script>

<?php if ($dataError['session_empty']): ?>
<script language="javascript">
var e = document.getElementById("body-modal-session");
$('.modal-session').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>
</body>
</html>
