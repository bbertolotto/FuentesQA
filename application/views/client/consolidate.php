<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>

<div id="page-content">

    <div class="content-header">
        <ul class="nav-horizontal text-center">
            <li><a href="/client/search" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-search"></i> Buscar</a></li>
            <li class="active"><a href="/client/consolidate" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-crop"></i> Consolidado</a></li>
            <li><a href="/client/information" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-user"></i> Personales</a></li>
            <li><a href="/client/contact" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-phone"></i> Contacto</a></li>
            <li><a href="/client/lasttransaction" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-transfer"></i> Transacciones</a></li>
            <li><a href="/client/lastaccount" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt"></i> Detalle EECC</a></li>
            <li><a href="/client/secure" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-warning_sign"></i> Seguros</a></li>
            <li><a href="/client/replacecard" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card"></i> Reponer Tarjeta</a></li>
        </ul>
    </div>

    <ul class="breadcrumb breadcrumb-top">
      <li><strong>Centro de servicios</strong></li>
      <li><a href="<?= base_url();?>client/search"><strong>B&#250;squeda Clientes</strong></a></li>
      <li><strong>Consolidado</strong></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Cliente </strong><?=$this->session->userdata('nombre_cliente').' '.$this->session->userdata('apellido_cliente')?></h2>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-left"><strong>Marca</strong></th>
                            <th class="text-left"><strong>Nº de Cuenta</strong></th>
                            <th class="text-left"><strong>Segmento</strong></th>
                            <th class="text-left"><strong>Tipo Despacho EECC</strong></th>
                            <!--th class="text-left"><strong>Estado Embozado</strong></th-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left"><?php if (isset($dataCuenta['descripcionMarca'])): ?> <?php echo $dataCuenta['descripcionMarca'] ?> <?php else: ?> <span class="label label-danger"><?=MSG_SIN_RESPUESTA_SERVICIOS_CLIENTE?></span> <?php endif; ?> </td>
                            <td class="text-left"><?php if (isset($dataDatosCuenta['contrato'])): ?> <?php echo $dataDatosCuenta['contrato'] ?> <?php else: ?> <span class="label label-danger"><?=MSG_SIN_RESPUESTA_SERVICIOS_CLIENTE?></span><?php endif; ?> </td>
                            <td class="text-left"><?php if (isset($dataSegmentos['descSegmento'])): ?> <?php echo $dataSegmentos['descSegmento'] ?> <?php else: ?> <span class="label label-danger"><?=MSG_SIN_RESPUESTA_SERVICIOS_CLIENTE?></span> <?php endif; ?> </td>
                            <td class="text-left"><?php if (isset($dataCuenta['envioCorrespondecia'])): ?> <?php echo $dataCuenta['envioCorrespondecia'] ?> <?php else: ?> <span class="label label-danger"><?=MSG_SIN_RESPUESTA_SERVICIOS_CLIENTE?></span> <?php endif; ?> </td>
                            <!--td class="text-left"><span class="label label-warning"><?=MSG_ATRIBUTO_PENDIENTE?></span></td-->
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
      </div>
        <!--End col-md-12-->
        <div class="row">
            <div class="col-md-12">

            <div class="block">
                <div class="block-title">
                    <h2><strong>Cupos Aprobados</strong></h2>
                </div>
                <table class="table table-striped table-bordered">

                    <?php
                    if(isset($dataCupos)){?>
                            <thead>
                                <tr>
                                    <th class="text-center"><strong>Tipo</strong></th>
                                    <th class="text-center"><strong>Cupo</strong></th>
                                    <th class="text-center"><strong>Utilizado</strong></th>
                                    <th class="text-center"><strong>Disponible</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dataCupos as $record) { ?>
                            <tr>
                                        <td class="text-center"><?= $record["descCodigolinea"]; ?></td>
                                        <td class="text-center">$<?= number_format((float)$record["cupo"], 0, ",", ".") ; ?></td>
                                        <td class="text-center">$<?= number_format((float)$record["utilizado"], 0, ",", ".") ; ?></td>
                                        <td class="text-center">$<?= number_format((float)$record["disponible"], 0, ",", ".") ; ?></td>
                            </tr>
                    <?php }?>
                            </tbody>
                    <?php }else{?>
                            <thead>
                                <tr>
                                    <th class="text-left"><strong><?=MSG_SIN_CUPOS?></strong></th>
                                </tr>
                            </thead>
                    <?php } ?>
                </table>

            </div>
        </div>
        <!--End col-md-5-->

    </div>
    <!--END row-->

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Situaci&#243;n de la Cuenta</strong></h2>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><strong>Producto</strong></th>
                            <th class="text-center"><strong>Renegociado</strong></th>
                            <th class="text-center"><strong>Estado</strong></th>
                            <th class="text-right"><strong>Monto Mora</strong></th>
                            <th class="text-center"><strong>D&#237;as Mora</strong></th>
                            <th class="text-center"><strong>Fecha Vencimiento</strong></th>
                            <th class="text-center"><strong>Fecha Pr&#243;ximo Vencimiento</strong></th>
                            <th class="text-right"><strong>Pago Mes</strong></th>
                            <th class="text-right"><strong>Monto M&#237;nimo</strong></th>
                            <th class="text-right"><strong>Deuda Actual</strong></th>
                            <th class="text-center"><strong>Nº Avances al d&#237;a</strong></th>
                            <th class="text-center"><strong>Origen</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?php if (isset($dataCuenta['descripcionTarjeta'])): ?> <?php echo $dataCuenta['descripcionTarjeta'] ?> <?php else: ?> Atributo vacio <?php endif; ?> </td>
                            <td class="text-center"><?php if (isset($dataEstadoBloqueos['codigoRenegociacion'])): ?> <?php echo $dataEstadoBloqueos['codigoRenegociacion'] ?> <?php endif; ?> </td>
                            <td class="text-center"><?php if (isset($dataEstadoBloqueos['estadoBloqueo'])): ?> <?php echo $dataEstadoBloqueos['estadoBloqueo'] ?> <?php endif; ?> </td>
                            <td class="text-right"><?php if (isset($dataDeudaCliente['montoEnMora'])): ?> $<?php echo number_format((float)$dataDeudaCliente['montoEnMora'], 0, ",", ".") ?> <?php else: ?> Atributo vacio <?php endif; ?> </td>
                            <td class="text-center"><?php if (isset($dataEstadoBloqueos['diasMora'])): ?> <?php echo $dataEstadoBloqueos['diasMora'] ?> <?php endif; ?> </td>
                            <td class="text-center"><?php if (isset($dataEECC['fechaVencimiento'])): ?> <?php echo $dataEECC['fechaVencimiento'] ?> <?php endif; ?> </td>
                            <td class="text-center"><?php if (isset($dataEECC['fechaProximoVencimiento'])): ?> <?php echo $dataEECC['fechaProximoVencimiento'] ?> <?php endif; ?> </td>
                            <td class="text-right"><?php if (isset($dataDeudaCliente['pagoDelMesFacturado'])): ?> <?php echo number_format((float)$dataDeudaCliente['pagoDelMesFacturado'], 0, ',', '.') ?> <?php endif; ?> </td>
                            <td class="text-right"><?php if (isset($dataDeudaCliente['pagoMinimo'])): ?> <?php echo number_format((float)$dataDeudaCliente['pagoMinimo'], 0, ',', '.') ?> <?php endif; ?> </td>
                            <td class="text-right"><?php if (isset($dataDeudaCliente['deudaActual'])): ?> <?php echo number_format((float)$dataDeudaCliente['deudaActual'], 0, ',', '.') ?> <?php endif; ?> </td>
                            <td class="text-center"><?php if (isset($dataEECC['numAvancesDelDia'])): ?> <?php echo $dataEECC['numAvancesDelDia'] ?> <?php endif; ?> </td>
                            <td class="text-center"><?php echo $this->session->userdata('origen'); ?> </td>

                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
        <!--End col-md-12-->
    </div>
    <!--END row-->
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Consolidado Tarjetas</strong></h2>
                </div>

                <table class="table table-striped table-bordered">
                <?php
                if(isset($dataTarjeta)){?>
                    <thead>
                        <tr><th class="text-center"><strong>Comercio</strong></th>
                            <th class="text-center"><strong>Producto</strong></th>
                            <th class="text-center"><strong>Nº Tarjeta</strong></th >
                            <th class="text-center"><strong>Situaci&#243;n</strong></th>
                            <th class="text-center"><strong>Estado Bloqueo</strong></th>
                            <th class="text-center"><strong>Fecha Expiraci&#243;n</strong></th>
                            <th ><strong>Cliente</strong></th>
                            <th class="text-center"><strong>Descripci&#243;n</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataTarjeta as $record) { ?>
                    <tr>
                        <td class="text-center"><?= $record["descripcionComercio"]; ?></td>
                        <td class="text-center"><?= $record["descripcionMarca"]; ?></td>
                        <td class="text-center">****-****-****-<?= substr($record["pan"],12,4); ?></td>
                        <td class="text-center"><?= $record["descripcion"]; ?></td>
                        <td class="text-center"><?= $record["descripcionbloqueo"]; ?></td>
                        <td class="text-center"><?= $record["fechaExpiracion"]; ?></td>
                        <td class="text-center"><?= $record["cliente"]; ?></td>
                        <td class="text-center"><?= $record["relacion"]; ?></td>
                    </tr>
                <?php }?>
                        </tbody>
                <?php }else{?>
                    <thead>
                        <tr>
                            <th class="text-left"><strong><?=MSG_SIN_TARJETAS?></strong></th>
                        </tr>
                    </thead>
                <?php } ?>

                </table>

            </div>
        </div>
        <!--End col-md-12-->
    </div>
    <!--END row-->

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Cartera Vencida</strong></h2>
                </div>
                <?php if (isset($dataCarteraVencida)): ?>

                    <?php if ($dataCarteraVencida['retorno']!=0): ?>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr><th><strong><?=$dataCarteraVencida['descRetorno']?></strong></th>
                            </thead>
                        </table>

                    <?php else: ?>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr><th><strong>M&#225;s</strong></th><th class="text-center"><strong>Fecha Ingreso Vencida</strong></th>
                                    <th class="text-right"><strong>Capital Vencido</strong></th>
                                    <th class="text-right"><strong>Capital Vigente</strong></th>
                                    <th class="text-right"><strong>Inter&#233;s Vencido Capitalizado</strong></th>
                                    <th class="text-right"><strong>Gastos por ingreso cuenta vencida</strong></th></tr>
                            </thead>
                            <tbody>
                                <tr class="clickable" data-toggle="collapse" data-target="#cartera-vencida-rows-1" aria-expanded="false" aria-controls="cartera-vencida-rows-1">
                                    <td><i class="fa fa-plus" aria-hidden="true"></i></td>
                                    <td class="text-right"><?php if(isset($dataCarteraVencida['fechaIngresoCartVenc'])):?><?php echo substr($dataCarteraVencida['fechaIngresoCartVenc'],0,10) ?><?php endif;?></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['capitalVencido'],0 ,'.',',')?></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['capitalVigente'],0 ,'.',',')?></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['interesVencidoCapitalizado'],0 ,'.',',')?></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['gastosIngresosCartVenc'],0 ,'.',',')?></td>
                                </tr>
                            </tbody>
                            <tbody id="cartera-vencida-rows-1" class="collapse">
                                <tr>
                                    <td class="text-right"><strong>Inter&#233;s devengado a la fecha</strong></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['interesDevengadoALaFecha'] ,0 ,'.',',')?></td>
                                    <td class="text-right"><strong>Costas judiciales</strong></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['costasJudiciales'] ,0 ,'.',',')?></td>
                                    <td class="text-right"><strong>Cargo Cobranza Externa</strong></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['cargosCobranzaExterna'] ,0 ,'.',',')?></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>Fecha Mora</strong></td>
                                    <td class="text-right"><?php if(isset($dataCarteraVencida['fechaMora'])):?><?php echo substr($dataCarteraVencida['fechaMora'],0,10) ?><?php endif;?></td>
                                    <td class="text-right"><strong>Empresa Cobranza Judicial</strong></td>
                                    <td class="text-right"><?=$dataCarteraVencida['empresaCobranzaJudicial']?></td>
                                    <td class="text-right"><strong>Fecha elimina DICOM</strong></td>
                                    <td class="text-right"><?php if(isset($dataCarteraVencida['fechaEliminacionDicom'])):?><?php echo substr($dataCarteraVencida['fechaEliminacionDicom'],0,10) ?><?php endif;?></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>Total monto abonado</strong></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['totalMontoAbonado'] ,0 ,'.',',')?></td>
                                    <td class="text-right"><strong>Fecha &#250;ltimo abono</strong></td>
                                    <td class="text-right"><?=substr($dataCarteraVencida['fechaUltimoAbono'],0,10)?></td>
                                    <td class="text-right"><strong>Monto &#250;ltimo abono</strong></td>
                                    <td class="text-right">$<?=number_format((float)$dataCarteraVencida['montoUltimoAbono'] ,0 ,'.',',')?></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>Deuda Vencida a la fecha</strong></td>
                                    <td class="text-left" colspan="5">$<?=number_format((float)$dataCarteraVencida['deudaVencidaALaFecha'] ,0 ,',' ,'.')?></td>
                                </tr>
                            </tbody>
                        </table>

                    <?php endif; ?>

                <?php endif; ?>


            </div>
        </div>
        <!--End col-md-12-->
    </div>
    <!--END row-->
</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<?php if ($dataError['session_empty']): ?>
<script language="javascript">
var e = document.getElementById("body-modal-session");
$('.modal-session').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>
</body>
</html>
