<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>

<div id="page-content">

  <div class="content-header">
      <div class="header-section">
          <h1>
              <i class="gi gi-file"></i><?= $this->lang->line('Campaign');?><br><small><?= $this->lang->line('Upload File');?></small>
          </h1>
      </div>
  </div>
  <ul class="breadcrumb breadcrumb-top">
      <li><?= $this->lang->line('Config');?></li>
      <li><?= $this->lang->line('Campaign');?></li>
      <li><?= $this->lang->line('Upload File');?></li>
      <li><a href="<?=base_url()?>config/downloadcampaign"><?= $this->lang->line('Download File');?></a></li>
      <li><a href="<?=base_url()?>config/monitorcampaign"><?= $this->lang->line('Monitoring');?></a></li>
  </ul>
  <!-- END Files Header -->

  <!-- Main Row -->
  <div class="row">
      <div class="col-md-4 col-lg-3">
          <!-- Navigation Block -->
          <div class="block full">
              <!-- Navigation Title -->
              <div class="block-title">
                  <div class="block-options pull-right">
                      <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Settings"><i class="fa fa-cog"></i></a>
                  </div>
                  <h2><i class="fa fa-compass"></i> Archivos <strong>Disponibles</strong></h2>
              </div>
              <!-- END Navigation Title -->

              <!-- Filter by Type links -->
              <!-- Custom files functionality is initialized in js/pages/readyFiles.js -->
              <!-- Add the category value you want each link in .media-filter to filter out in its data-category attribute. Add the value 'all' to show all items -->
              <ul class="nav nav-pills nav-stacked nav-icons media-filter">
                  <li class="active">
                      <a href="javascript:void(0)" data-category="all">
                          <i class="fa fa-fw fa-folder-open themed-color-dark icon-push"></i> <strong>Todos</strong>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:void(0)" data-category="pending">
                          <i class="gi gi-fw gi-disk_import text-danger icon-push"></i> <strong>Pendientes</strong>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:void(0)" data-category="inprocess">
                          <i class="gi gi-fw gi-refresh text-success icon-push"></i> <strong>En Proceso</strong>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:void(0)" data-category="process">
                          <i class="gi gi-fw gi-file_import text-info icon-push"></i> <strong>Procesados</strong>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:void(0)" data-category="recycle">
                          <i class="gi gi-fw gi-bin text-warning icon-push"></i> <strong>Papelera</strong>
                      </a>
                  </li>
              </ul>
              <!-- END Filter by Type links -->
          </div>
          <!-- END Navigation Block -->

          <!-- Upload Block -->
          <div class="block full hidden-xs">
              <!-- Upload Title -->
              <div class="block-title">
                  <div class="block-options pull-right">
                      <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Settings"><i class="fa fa-cog"></i></a>
                  </div>
                  <h2><i class="fa fa-cloud-upload"></i> Subir <strong>Archivos</strong></h2>
              </div>
              <!-- END Upload Title -->

              <!-- Upload Content -->
              <form action="page_ready_files.html" class="dropzone"></form>
              <!-- END Upload Content -->
          </div>
          <!-- END Upload Block -->
      </div>
      <div class="col-md-8 col-lg-9">
          <!-- Files Block -->
          <div class="block">
              <!-- Files Content -->
              <!-- Add the category value for each item in its data-category attribute (for the filter functionality to work) -->
              <div class="row media-filter-items">
                  <div class="col-sm-6 col-lg-4">
                      <div class="media-items animation-fadeInQuickInv" data-category="pending">
                          <div class="media-items-options text-left">
                              <a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                          </div>
                          <div class="media-items-content">
                              <i class="fi fi-csv fa-5x text-warning"></i>
                          </div>
                          <h4>
                              <strong>savnov2019</strong>.csv<br>
                              <small>Hoy 14:30 | 7.3MB</small>
                          </h4>
                      </div>
                  </div>
                  <div class="col-sm-6 col-lg-4">
                      <div class="media-items animation-fadeInQuickInv" data-category="pending">
                          <div class="media-items-options text-left">
                              <a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                          </div>
                          <div class="media-items-content">
                              <i class="fi fi-csv fa-5x text-warning"></i>
                          </div>
                          <h4>
                              <strong>savespnov</strong>.csv<br>
                              <small>Mañana 03:00 AM </small>
                          </h4>
                      </div>
                  </div>
                  <div class="col-sm-6 col-lg-4">
                      <div class="media-items animation-fadeInQuickInv" data-category="process">
                          <div class="media-items-options text-left">
                              <a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                              <a href="img/placeholders/photos/photo2.jpg" class="btn btn-xs btn-danger" data-toggle="lightbox-image"><i class="fa fa-search"></i></a>
                          </div>
                          <div class="media-items-content">
                              <i class="fi fi-csv fa-5x text-success"></i>
                          </div>
                          <h4>
                              <strong>savnov2019</strong>.csv<br>
                              <small>09-10-2019<br>inicio 13:30 | fin 14:45 | 12.000 reg</small>
                          </h4>
                      </div>
                  </div>
                  <div class="col-sm-6 col-lg-4">
                      <div class="media-items animation-fadeInQuickInv" data-category="process">
                          <div class="media-items-options text-left">
                              <a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                              <a href="img/placeholders/photos/photo1.jpg" class="btn btn-xs btn-danger" data-toggle="lightbox-image"><i class="fa fa-search"></i></a>
                          </div>
                          <div class="media-items-content">
                              <i class="fi fi-csv fa-5x text-success"></i>
                          </div>
                          <h4>
                              <strong>savnov2019</strong>.csv<br>
                              <small>09-11-2019<br>inicio 13:30 | fin 14:45 | 23.000 reg</small>
                          </h4>
                      </div>
                  </div>
                  <div class="col-sm-6 col-lg-4">
                      <div class="media-items animation-fadeInQuickInv" data-category="inprocess">
                          <div class="media-items-options text-left">
                              <a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                          </div>
                          <div class="media-items-content">
                              <i class="fi fi-csv fa-5x text-info"></i>
                          </div>
                          <h4>
                              <strong>savsep2019</strong>.csv<br>
                              <small>Hoy inicio 10:00 | 1.345 reg</small>
                          </h4>
                      </div>
                  </div>
                  <div class="col-sm-6 col-lg-4">
                      <div class="media-items animation-fadeInQuickInv" data-category="recycle">
                          <div class="media-items-options text-left">
                              <a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                          </div>
                          <div class="media-items-content">
                              <i class="fi fi-csv fa-5x text-danger"></i>
                          </div>
                          <h4>
                              <strong>savago2019</strong>.csv<br>
                              <small>75 min | 0.5GB</small>
                          </h4>
                      </div>
                  </div>
                  <div class="col-sm-6 col-lg-4">
                      <div class="media-items animation-fadeInQuickInv" data-category="recycle">
                          <div class="media-items-options text-left">
                              <a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                          </div>
                          <div class="media-items-content">
                              <i class="fi fi-csv fa-5x text-danger"></i>
                          </div>
                          <h4>
                              <strong>savjul2019</strong>.csv<br>
                              <small>180 min | 1.2GB</small>
                          </h4>
                      </div>
                  </div>
              </div>
              <!-- END Files Content -->
          </div>
          <!-- END Files Block -->
      </div>
  </div>
  <!-- END Main Row -->

</div>
<!-- End page-content-->
<?php $this->load->view('footer'); ?>

<!-- Javascript exclusivos para esta página -->
<script src="<?=base_url()?>js/pages/readyFiles.js"></script>
<script>$(function(){ ReadyFiles.init(); });</script>

</body>
</html>
