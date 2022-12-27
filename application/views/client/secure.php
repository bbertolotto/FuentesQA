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
            <li><a href="/client/lasttransaction" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-transfer"></i> Transacciones</a></li>
            <li><a href="/client/lastaccount" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt"></i> Detalle EECC</a></li>
            <li class="active"><a href="/client/secure" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-warning_sign"></i> Seguros</a></li>
            <li><a href="/client/replacecard" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card"></i> Reponer Tarjeta</a></li>
        </ul>
    </div>

    <ul class="breadcrumb breadcrumb-top">
      <li><strong>Centro de servicios</strong></li>
      <li><a href="<?= base_url();?>client/search"><strong>B&#250;squeda Clientes</strong></a></li>
      <li><strong>Seguros</strong></li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="row">
                <div class="block">

                    <div class="block-title">
                        <h2><strong>Seguros Contratados</strong></h2>

                    </div>

                    <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><strong>Compa&#241;ia</strong></th>
                            <th scope="col"><strong>Nombre Seguro</strong></th>
                            <th scope="col"><strong>Estado</strong></th>
                            <th scope="col"><strong>Fecha Contrataci&#243;n</strong></th>
                            <th scope="col"><strong>Monto Prima</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($dataSEG)):?>

                            <?php foreach ($dataSEG as $record) { ?>
                                <tr >
                                    <td scope="col"> <?= $record["empresaAseguradora"]; ?></td>
                                    <td scope="col"> <?= $record["nombreSeguro"]; ?></td>
                                    <td scope="col"> <?= $record["estadoSeguro"]; ?></td>
                                    <td scope="col"> <?= substr($record["fechaAltaBaja"],0,10); ?></td>
                                    <td scope="col"> <?php echo $record["valorPrima"].' '.MASCARA_MONEDA_UF; ?> </td>
                                </tr>

                            <?php } ?>

                        <?php endif;?>

                    </tbody>
                    </table>

                </div>
            </div>

            <div class="row">
                <div class="block">
                    <div class="block-title">
                        <h2><strong>Seguros NO Contratados</strong></h2>
                    </div>

                    <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><strong>Compa&#241;ia</strong></th>
                            <th scope="col"><strong>Nombre Seguro</strong></th>
                            <th scope="col"><strong>Monto Prima</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($dataNOSEG)):?>

                            <?php foreach ($dataNOSEG as $record) { ?>
                                <tr >
                                    <td scope="col"> <?= $record["empresaAseguradora"]; ?></td>
                                    <td scope="col"> <?= $record["nombreSeguro"]; ?></td>
                                    <td scope="col"> <?php echo $record["montoPrima"].' '.MASCARA_MONEDA_UF; ?></td>
                                </tr>

                            <?php } ?>

                        <?php endif;?>

                    </tbody>
                    </table>
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

<?php if ($dataError['session_empty']): ?>
<script language="javascript">
var e = document.getElementById("body-modal-session");
$('.modal-session').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>


</body>
</html>
