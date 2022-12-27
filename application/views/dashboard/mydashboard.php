<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
<?php $this->load->view('head'); ?>
<!-- Page content -->
<div id="page-content">
    <!-- Dashboard Header -->
    <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
    <div class="content-header content-header-media">

<!--
        <div class="header-section">
            <div class="row">

                <div class="col-md-8 col-lg-8 hidden-xs hidden-sm">
                    <h1><strong><?=$this->lang->line('Welcome');?>&nbsp;<?=$this->session->userdata('nombre')?></strong><br>
                <small>
                    <?php if(isset($office->nombreoficina)): ?>
                    <?php echo 'Oficina: '.$office->nombreoficina ?>
                     &amp;
                    <?php echo ' / '.$office->nombregrupo ?>
                      <?php endif; ?>
                    </small></h1>
                </div>
-->

                <!-- Top Stats -->
                <!--div class="col-md-8 col-lg-8">
                    <div class="row text-center">
                        <div class="col-xs-4 col-sm-3">
                            <h2 class="animation-hatch">
                                $<strong>32.5M</strong><br>
                                <small><i class="gi gi-thumbs_up"></i> S&#250;per Avances</small>
                            </h2>
                        </div>
                        <div class="col-xs-4 col-sm-3">
                            <h2 class="animation-hatch">
                                $<strong>2.3M</strong><br>
                                <small><i class="gi gi-hand_up"></i> Renegociaciones</small>
                            </h2>
                        </div>
                        <div class="col-xs-4 col-sm-3">
                            <h2 class="animation-hatch">
                                $<strong>12M</strong><br>
                                <small><i class="gi gi-thumbs_down"></i> Refinanciamiento</small>
                            </h2>
                        </div>
                        <!-- We hide the last stat to fit the other 3 on small devices -->
                        <!--div class="col-sm-3 hidden-xs">
                            <h2 class="animation-hatch">
                                <strong>12</strong><br>
                                <small><i class="gi gi-thumbs_down"></i> Seguros</small>
                            </h2>
                        </div>
                    </div>
                </div-->
                <!-- END Top Stats -->
<!--
            </div>
        </div>
-->
    <img src="<?=base_url();?>img/placeholders/headers/widget8_header.jpg" alt="header image" class="animation-pulseSlow">
    </div>
    <!-- END Dashboard Header -->

    <!-- Mini Top Stats Row -->
    <div class="row">

        <div class="col-xs-12 col-sm-6 col-lg-3">
            <a href="<?= base_url();?>client" class="widget widget-hover-effect1 font-bottom">
                <div class="widget-simple">
                    <div class="widget-icon pull-left themed-background-autumn animation-fadeIn">
                        <i class="fa fa-users fa-center"></i>
                    </div>
                    <h3 class="widget-content text-center animation-pullDown">
                        Centro de <strong>Servicios</strong><br>
                        <!--small>Clientes/Estado de Cuentas/Bloqueos</small-->
                    </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-3">
            <!-- Widget -->
            <a href="<?= base_url();?>advance" class="widget widget-hover-effect1 font-bottom">
                <div class="widget-simple">
                    <div class="widget-icon pull-left themed-background-spring animation-fadeIn">
                        <i class="gi gi-usd"></i>
                    </div>
                    <h3 class="widget-content text-center animation-pullDown">
                        S&#250;per <strong>Avance</strong><br>
                        <!--small>Simular/Crear/Estado Transferencias</small-->
                    </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-3">
<?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):?>
            <a href="<?= base_url();?>capturing" class="widget widget-hover-effect1 font-bottom">
<?php else:?>
            <a href="<?= base_url();?>capturing/search" class="widget widget-hover-effect1 font-bottom">
<?php endif;?>
                <div class="widget-simple">
                    <div class="widget-icon pull-left themed-background-fire animation-fadeIn">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <h3 class="widget-content text-center animation-pullDown">
                        <strong>Captación</strong><br>
                        <!--small>Tarjetas Cruz Verde Pre Aprobas</small-->
                    </h3>
                </div>
            </a>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-3">
<?php if($this->session->userdata("id_rol")==12):?>
            <a href="<?= base_url();?>collection/search" class="widget widget-hover-effect1 font-bottom">
<?php else:?>
            <a href="<?= base_url();?>renegotiation/search" class="widget widget-hover-effect1 font-bottom">
<?php endif;?>
                <div class="widget-simple">
                    <div class="widget-icon pull-left themed-background-autumn animation-fadeIn">
                        <i class="fa fa-compass"></i>
                    </div>
                    <h3 class="widget-content text-center animation-pullDown">
                        <strong>Renegociación</strong><br>
                        <!--small>Negociación/Autorizaciones/Script</small-->
                    </h3>
                </div>
            </a>
        </div>
    </div>
    <!-- END Mini Top Stats Row -->

    <!-- Widgets Row -->
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="widget">
                <div class="widget-extra themed-background-dark">
                    <!--div class="widget-options">
                        <div class="btn-group btn-group-xs">
                            <a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="Edit Widget"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="Quick Settings"><i class="fa fa-cog"></i></a>
                        </div>
                    </div-->
                    <h3 class="widget-content-light">
                        <strong>&#218;ltimos Clientes atendidos</strong>
                        <!--small><a href="page_ready_timeline.html"><strong>Ver Más..</strong></a></small-->
                    </h3>
                </div>
                <div class="widget-extra">

                <table class="table table-borderless table-striped table-vcenter table-hover">
                    <thead>
                       <tr>
                            <td class="text-center"><strong>RUT</strong></td>
                            <td class="text-left"><strong>Cliente</strong></td>
<?php if($this->session->userdata('id_manager')==1):?>
                            <td class="text-center"><strong>Usuario</strong></td>
<?php endif;?>
                            <td class="text-center"><strong>Oficina</strong></td>
                            <td class="text-center"><strong>Motivo</strong></td>
                            <td class="text-center"><strong>Fecha</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($journal as $key) : ?>
                        <tr>
                            <td class="text-center" style="width: 100px;"><strong><?= $key["rut"] ?></strong></td>
                            <td class="text-left"><?= $key["name_client"] ?></td>
<?php if($this->session->userdata('id_manager')==1):?>
                            <td class="text-center"><?= $key["username"] ?></td>
<?php endif;?>
                            <td class="text-center"><?= $key["office"] ?></td>
                            <td class="text-center"><?= $key["reasonDetail"] ?></td>
                            <td class="text-center"><?= $key["stamp"] ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <!--
        <div class="col-md-6">
            <div class="widget">
                <div class="widget-extra themed-background-dark">
                    <div class="widget-options">
                        <div class="btn-group btn-group-xs">
                            <a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="Edit Widget"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="Quick Settings"><i class="fa fa-cog"></i></a>
                        </div>
                    </div>
                    <h3 class="widget-content-light">
                        <strong>&#218;ltimos Llamados </strong>
                        <small><a href="page_ready_pricing_tables.html"><strong>Ver Más..</strong></a></small>
                    </h3>
                </div>
                <div class="widget-extra-full">

                    <table class="table table-borderless table-striped table-vcenter table-hover">
                        <thead>
                            <tr>
                                <td class="text-left"><strong>RUT</strong></td>
                                <td class="text-left"><strong>Producto</strong></td>
                                <td class="text-left"><strong>Montos</strong></td>
                                <td class="text-left"><strong>Motivo</strong></td>
                                <td class="text-left"><strong>Fecha Hora</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left"><strong>23.236.256-5</strong></td>
                                <td class="text-left"><stong>Súper Avance</strong></td>
                                <td class="text-center"><strong>$1.500.000</strong></td>
                                <td class="text-left"><strong>No contesta</strong></td>
                                <td class="text-left">21-10-2019 10:00 AM</td>
                            </tr>

                            <tr>
                                <td class="text-left"><strong>12.479.692-K</strong></td>
                                <td class="text-left"><stong>Súper Avance</strong></td>
                                <td class="text-center"><strong>$750.000</strong></td>
                                <td class="text-left"><strong>Acepta</strong></td>
                                <td class="text-left">21-10-2019 11:23 AM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>-->

    </div>

    <!-- Pie and Stacked Chart -->
    <!--<div class="row">
        <div class="col-sm-6">
            <div class="block full">
                <div class="block-title">
                    <h2><strong>Pie</strong> Chart</h2>
                </div>

                <div id="chart-pie" class="chart"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="block full">
                <div class="block-title">
                    <h2><strong>Stacked</strong> Chart</h2>
                </div>

                <div id="chart-stacked" class="chart"></div>
            </div>
        </div>
    </div>-->

</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>

</body>
<!-- Load and execute javascript code used only in this page -->
<!--script src="<?= base_url();?>js/pages/compCharts.js"></script>
<script>$(function(){ CompCharts.init(); });</script-->
</html>
