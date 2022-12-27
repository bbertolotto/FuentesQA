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
            <li><a href="/client/consolidate" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-crop"></i> Consolidado</a></li>
            <li><a href="/client/information" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-user"></i> Personales</a></li>
            <li><a href="/client/contact" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-phone"></i> Contacto</a></li>
            <li class="active"><a href="/client/lasttransaction" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-transfer"></i> Transacciones</a></li>
            <li><a href="/client/lastaccount" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt"></i> Detalle EECC</a></li>
            <li><a href="/client/secure" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-warning_sign"></i> Seguros</a></li>
            <li><a href="/client/replacecard" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card"></i> Reponer Tarjeta</a></li>
        </ul>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><strong>Centro de servicios</strong></li>
        <li><a href="<?= base_url();?>client/search"><strong>B&#250;squeda Clientes</strong></a></li>
        <li><strong>&#218;ltimas Transacciones</strong></li>
    </ul>
    <!-- End breadcrumb -->

    <div class="row">

        <div class="col-md-12">

            <div class="row">
                <div class="block">
                    <div class="block-title">
                        <h2><strong>&#218;ltimas Transacciones Cliente </strong><?=$this->session->userdata('nombre_cliente').' '.$this->session->userdata('apellido_cliente')?></h2>

                    </div>

                    <form id="form-client" class="form-horizontal form-bordered" method="post">

                        <div class="form-group">

                        <div class="col-sm-3">
                            <label class="control-label" for="val_skill">Tipo Transacción</label>
                            <div class="input-group col-xs-12">
                                <select id="typeSkill" name="typeSkill" class="form-control">
                                    <option value="001">Ventas</option>
                                    <!--option value="777">Cuotas</option-->
                                    <option value="005">Pagos</option>
                                    <option value="009">Avance</option>
                                    <option value="999">Cargos</option>
                                    <option value="888">Devolución</option>
                                    <option value="102">Convenios</option>
                                    <option value="014">S&#250;per Avance</option>
                                    <option value="102">Renegociaci&#243;n</option>
                                    <option value="000" selected>Todos</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="control-label" for="example-daterange1">Rango Fecha </label>
                            <div class="input-group col-xs-12">
                                    <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                        <input type="text" id="dateBegin" name="dateBegin" value="<?php if(isset($dataRange['dateBegin'])){ echo $dataRange['dateBegin'];} ?>" class="form-control text-center" placeholder="Desde">
                                        <span class="input-group-addon"><i class="fa fa-angle-right"></i></span>
                                        <input type="text" id="dateEnd" name="dateEnd" value="<?php if(isset($dataRange['dateEnd'])){ echo $dataRange['dateEnd'];} ?>" class="form-control text-center" placeholder="Hasta">
                                    </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label class="control-label" >&nbsp;</label>
                            <div class="input-group col-xs-12">
                            <button type="button" class="btn-get-action btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                            <button type="reset" class="btn btn-danger" onclick="Client.init();"><i class="fa fa-refresh"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>

                    </form>

                </div>
            </div>


            <div class="row" id="viewVentas" style="display:none;">
                <div class="block">
                    <div class="block-title">
                        <h2><strong>Detalle de Ventas: Avance, S&#250;per Avance y Renegociaciones</strong></h2>
                         <div class="block-options pull-right">
                            <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default exporxlsdataVentas" data-toggle="tooltip" title="Exportar XLS"><i class="fi fi-xls "></i>Exportar XLS</a>
                        </div>
                    </div>

                    <div id="dataVentas" class="table-responsive">

                    </div>
                </div>
            </div>

            <div class="row" id="viewCargos" style="display:none;">
                <div class="block">
                    <div class="block-title">
                        <h2><strong>Detalle de Cargos</strong></h2>
                         <div class="block-options pull-right">
                            <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default exporxlsdataCargos" data-toggle="tooltip" title="Exportar XLS"><i class="fi fi-xls "></i>Exportar XLS</a>
                        </div>
                    </div>

                    <div id="dataCargos" class="table-responsive">
                    </div>
                </div>
            </div>

            <div class="row" id="viewPagos" style="display:none;">
                <div class="block">
                    <div class="block-title">
                        <h2><strong>Detalle de Pagos</strong></h2>
                         <div class="block-options pull-right">
                            <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default exporxlsdataPagos" data-toggle="tooltip" title="Exportar XLS"><i class="fi fi-xls "></i>Exportar XLS</a>
                        </div>
                    </div>

                    <div id="dataPagos" class="table-responsive">


                    </div>
                </div>
            </div>

            <div class="row" id="viewDevolucion" style="display:none;">
                <div class="block">
                    <div class="block-title">
                        <h2><strong>Detalle de Devoluci&#243;n y Descuentos</strong></h2>
                         <div class="block-options pull-right">
                            <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default exporxlsdataDevolucion" data-toggle="tooltip" title="Exportar XLS"><i class="fi fi-xls "></i>Exportar XLS</a>
                        </div>
                    </div>

                    <div id="dataDevolucion" class="table-responsive">
                    </div>
                </div>
            </div>

            <!--div class="row" id="viewCuotas" style="display:none;">
                <div class="block">
                    <div class="block-title">
                        <h2><strong>Detalle de Cuotas: Ventas, Avance, S&#250;per Avance y Cargos</strong></h2>
                         <div class="block-options pull-right">
                            <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default exporxlsdataCuotas" data-toggle="tooltip" title="Exportar XLS"><i class="fi fi-xls "></i>Exportar XLS</a>
                        </div>
                    </div>

                    <div id="dataCuotas" class="table-responsive">

                    </div>
                </div>
            </div-->

            <div class="row">
                <div class="block">
                    <div class="block-title">
                        <h2><strong>Autorizaciones</strong></h2>
                         <div class="block-options pull-right">
                            <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default exporxlsdataAUT" data-toggle="tooltip" title="Exportar XLS"><i class="fi fi-xls "></i>Exportar XLS</a>
                        </div>
                    </div>

                    <div id="dataAUT" class="table-responsive">
                        <table class="table table-striped table-bordered" border="0" id="tabAutoriza">
                        <thead>
                            <tr data-toggle="tooltip" data-placement="top" title="Posiciona el Mouse sobre la columna que desea orderar y CLICK para ordenar">
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(0,1)"><strong>Comercio</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(1,1)"><strong>Local</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(2,1)"><strong>Fecha Hora</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(3,1)"><strong>Descripci&#243;n</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(4,1)"><strong>C&#243;digo Autorizaci&#243;n</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(5,1)"><strong>N&#250;mero de Cuotas</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(6,1)"><strong>Contado</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(7,1)"><strong>Cr&#233;dito</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(8,1)"><strong>Terminal</strong></td>
                                <td scope="col" class="text-center" onclick="Teknodata.sortTable(9,1)"><strong>Estado</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataAUT as $recordTRX) { ?>
                                   <tr>
                                        <td scope="col" class="text-center"><?= $recordTRX["comercio"]; ?></td>
                                        <td scope="col" class="text-center"><?= $recordTRX["local"]; ?></td>
                                        <td scope="col" class="text-center" nowrap><?= $recordTRX["fechahora"]; ?></td>
                                        <td scope="col" class="text-center"><?= $recordTRX["descripcion"]; ?></td>
                                        <td scope="col" class="text-center"><?= $recordTRX["codigoautorizacion"]; ?></td>
                                        <td scope="col" class="text-center"><?= $recordTRX["cantidadDeCuotas"]; ?></td>
                                        <td scope="col" class="text-right"><strong>$<?= number_format((float)$recordTRX["Monto_Contado"],0,',','.'); ?></strong></td>
                                        <td scope="col" class="text-right"><strong>$<?= number_format((float)$recordTRX["Monto_Credito"],0,',','.'); ?></strong></td>
                                        <td scope="col" class="text-center"><?= $recordTRX["terminal"]; ?></td>
                                        <td scope="col" class="text-center"><?= $recordTRX["estadoTrx"]; ?></td>
                                   </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--END col-md-7-->
    </div>
    <!--END row-->
</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="<?= base_url();?>js/client/lasttransaction.js"></script>
<script src="<?= base_url();?>js/TeknodataSystems.js"></script>

<?php if ($dataError['session_empty']): ?>
<script language="javascript">
var e = document.getElementById("body-modal-session");
$('.modal-session').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>

</body>
</html>
