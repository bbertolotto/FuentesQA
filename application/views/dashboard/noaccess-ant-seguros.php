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

    <img src="<?=base_url();?>img/placeholders/headers/widget8_header.jpg" alt="header image" class="animation-pulseSlow">
    </div>
    <!-- END Dashboard Header -->

    <!-- Mini Top Stats Row -->
    <div class="row">

              <div class="col-xs-6 col-sm-4 col-lg-4">
                  <a href="<?= base_url();?>client" class="widget widget-hover-effect1 font-bottom">
                      <div class="widget-simple">
                          <div class="widget-icon pull-left themed-background-autumn animation-fadeIn">
                              <i class="fa fa-users"></i>
                          </div>
                          <h3 class="widget-content text-right animation-pullDown">
                              Centro de <strong>Servicios</strong><br>
                              <small></small>
                          </h3>
                      </div>
                  </a>
                  <!-- END Widget -->
              </div>
              <div class="col-xs-6 col-sm-4 col-lg-4">
                  <!-- Widget -->
                  <a href="<?= base_url();?>advance" class="widget widget-hover-effect1 font-bottom">
                      <div class="widget-simple">
                          <div class="widget-icon pull-left themed-background-spring animation-fadeIn">
                              <i class="gi gi-usd"></i>
                          </div>
                          <h3 class="widget-content text-right animation-pullDown">
                              S&#250;per <strong>Avance</strong><br>
                              <small></small>
                          </h3>
                      </div>
                  </a>
                  <!-- END Widget -->
              </div>
              <div class="col-xs-6 col-sm-4 col-lg-4">

        <?php if($this->session->userdata("id_rol")==USER_ROL_EJECUTIVO_COMERCIAL):?>
                    <a href="<?= base_url();?>capturing" class="widget widget-hover-effect1 font-bottom">
        <?php else:?>
                    <a href="<?= base_url();?>capturing/search" class="widget widget-hover-effect1 font-bottom">
        <?php endif;?>

                      <div class="widget-simple">
                          <div class="widget-icon pull-left themed-background-fire animation-fadeIn">
                              <i class="fa fa-credit-card"></i>
                          </div>
                          <h3 class="widget-content text-right animation-pullDown">
                              <strong>Captación</strong>
                          </h3>
                      </div>
                  </a>
              </div>

<!--
      <div class="col-xs-6 col-sm-4 col-lg-3">
          <a href="/renegotiation" class="widget widget-hover-effect1 font-bottom">
              <div class="widget-simple">
                  <div class="widget-icon pull-left themed-background-amethyst animation-fadeIn">
                      <i class="fa fa-history"></i>
                  </div>
                  <h3 class="widget-content text-right animation-pullDown">
                      <strong>Renegociar</strong>
                  </h3>
              </div>
          </a>
      </div>
    </div>
  -->
    <!-- END Mini Top Stats Row -->

    <!-- Widgets Row -->
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="widget">
                <div class="widget-extra themed-background-dark">
                    <h3 class="widget-content-light">
                        <strong>&#218;ltimos Clientes atendidos</strong>
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


    </div>
</div>
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script language="javascript">
var e = document.getElementById("body-modal-access");
$('.modal-access').modal({show:true,backdrop:'static'});
</script>
</body>
</html>
