<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>
  <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map-canvas {
        height: 400px;
      }
      /* Optional: Makes the sample page fill the window. */
     
      .controls {
        background-color: #fff;
        border-radius: 2px;
        border: 1px solid transparent;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        box-sizing: border-box;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        height: 29px;
        margin-left: 17px;
        margin-top: 10px;
        outline: none;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      .controls:focus {
        border-color: #4d90fe;
      }
      .title {
        font-weight: bold;
      }
      #infowindow-content {
        display: none;
      }
      #map #infowindow-content {
        display: inline;
      }

      .pac-container {
    z-index: 1051 !important;
}
 .map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }

    </style>
<div id="page-content">
                    <!-- User Profile Header -->
                    <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
    <div class="content-header content-header-media">
        <div class="header-section">
          <!--<img src="<?= base_url();?>img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">-->
          <h1><?=$this->session->userdata('nombre')?><br><small>
              <?php if(isset($office->nombreoficina)): ?>  
                        <?= $office->nombreoficina ?>&amp;<?= $office->nombregrupo ?><?php endif;?>
                  </small></h1>
        </div>
                            <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
                            <img src="<?= base_url();?>img/placeholders/headers/widget1_header.jpg" alt="header image" class="animation-pulseSlow">
                        </div>
                        <!-- END User Profile Header -->

                        <!-- User Profile Content -->
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-6 col-lg-5">
                                <!-- Updates Block -->
                                <div class="block">
                                    <!-- Updates Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" data-toggle="tooltip" title="Configuración privada"><i class="fa fa-cog"></i></a>
                                        </div>
                                        <h2><strong>Comparte</strong> algo..</h2>
                                    </div>
                                    <!-- END Updates Title -->

                                    <!-- Update Status Form -->
                                    <form action="" method="post" class="block-content-full block-content-mini-padding" id="task_new">
                                        <textarea id="default-textarea" name="default-textarea" rows="2" class="form-control push-bit" placeholder="¿Que estas pensando?"></textarea>
                                        <div class="clearfix">
                                            <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-pencil"></i> Enviar</button>
                                            <a href="javascript:void(0)" class="btn btn-link btn-icon" data-toggle="modal" data-target="#ubicacion" title="Añade una ubicación"><i class="fa fa-location-arrow" ></i></a>
                                            <a href="javascript:void(0)" class="btn btn-link btn-icon"  data-placement="bottom" title="Añade mensaje de voz" data-toggle="modal" data-target="#grabacion"><i class="fa fa-microphone"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-link btn-icon" data-placement="bottom" title="Añade una foto" data-toggle="modal" data-target="#fotomodal"><i class="fa fa-camera"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-link btn-icon" data-toggle="modal" data-placement="bottom" title="Añade un archivo" data-target="#archivomodal"><i class="fa fa-file"></i></a>
                                        </div>
                                    </form>
                                    <!-- END Update Status Form -->
                                </div>
                                <!-- END Updates Block -->

                                <!-- Newsfeed Block -->
                                <div class="block">
                                    <!-- Newsfeed Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="label label-danger animation-pulse">Transmisión en vivo</a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" data-toggle="tooltip" title="Configuración"><i class="fa fa-pencil"></i></a>
                                        </div>
                                        <h2><strong>Noticias</strong></h2>
                                    </div>
                                    <!-- END Newsfeed Title -->

                                    <!-- Newsfeed Content -->
                                    <div class="block-content-full">
                                        <!-- You can remove the class .media-feed-hover if you don't want each event to be highlighted on mouse hover -->
                                        <ul class="media-list media-feed media-feed-hover">
                                            <!-- Photos Uploaded -->
                                            <!-- Example effect of the following update showing up in Newsfeed (initialized in js/pages/readyProfile.js) -->

                                            <?php foreach ($selectnews as $key) { $idcorrel = $key->correl ?>

                                <?php if ($key->type_name == "Noticias"): ?>
                                                                                            
                                            <li class="media">
                                                <a href="page_ready_user_profile.html" class="pull-left">
                                                    <img src="<?= base_url();?>img/placeholders/avatars/avatar6.jpg" alt="Avatar" class="img-circle">
                                                </a>
                                                 <div class="media-body">
                                                        <p class="push-bit">
                                                        <span class="text-muted pull-right">
                                                            <small><?= $key->stamp ?></small>
                                                            <span class="text-danger" data-toggle="tooltip" title="Desde la Web"><i class="fa fa-globe"></i></span>
                                                        </span>
                                                        <strong><a href="page_ready_user_profile.html"> Publicado por <?= $key->name ?> <?= $key->last_name ?> </a>.</strong>
                                                    </p>
                                                    <?php if($key->detail != NULL and $key->stamp_begin == NULL): ?>
                                                        <p>

                                                            <?=$key->detail?>
                                                        </p>
                                                    <?php endif; ?>
                                                     <?php if($key->location != NULL): ?>
                                                        <p>
                                                             <div id="map<?= $key->correl ?>" class="map"></div>   
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if($key->voice != NULL): ?>
                                                        <p>

                                                            <audio src="<?= base_url() ?>welcome/audio/<?= $key->correl ?>" controls></audio>
                                                        </p>
                                                    <?php endif; ?>

                                                     <?php if($key->type_file == 'image/png' or $key->type_file == 'image/jpeg' or $key->type_file == 'image/gif'): ?>
                                                        <p>

                                                           <img src="<?= base_url() ?>news/imagen_prev/<?=$key->correl?>" width="80%" id="imgSalida">   
                                                        </p>
                                                    <?php endif; ?>

                                                    <?php
                                                        $cadena_de_texto = $key->type_file;
                                                        $cadena_buscada   = 'application';
                                                        $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                                                        if($posicion_coincidencia === false):
                                                        else:
                                                    ?>
                                                     <p>
                                                           <a href="<?= base_url() ?>news/imagen_prev/<?=$key->correl?>" download>Descargar archivo</a>   
                                                        </p>
                                                    <?php endif; ?>
                                        <ul class="media-list push">
                                                        <li class="media">
                                                         
                                                        </li>
                                                        <li class="media">
                                                         
                                                        </li>
                                                        <?php foreach ($comentarios as $keycomentarios) { ?>
                                                            <?php if($idcorrel == $keycomentarios->comments_correl): ?>
                                                            <li class="media">
                                                                 <a href="page_ready_user_profile.html" class="pull-left">
                                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar11.jpg" alt="Avatar" class="img-circle">
                                                            </a>
                                                            <div class="media-body">
                                                                <a href="page_ready_user_profile.html"><strong><?php echo usuariobuscar($keycomentarios->id_user) ?></strong></a>
                                                                <span class="text-muted"><small><em>Hace 29 min</em></small></span>
                                                        <p><?= $keycomentarios->comments ?></p>
                                                            </div>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php } ?>
                                                      
                                                        <li class="media">
                                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                                <img src="https://desarrollo.solventa.maximoerp.com/img/placeholders/avatars/avatar.jpg" alt="Avatar" class="img-circle">
                                                            </a>
                                                            <div class="media-body">
                                <form action="page_ready_user_profile.html" method="post" class="publicarcomentario">
                                    <input type="hidden" name="keyid" value="<?= $key->correl ?>">
                                     <input type="hidden" name="typepublicacion" value="1">
                                    <textarea id="profile-newsfeed-comment<?= $key->correl ?>" name="profile-newsfeed-comment" class="form-control" rows="2" placeholder="Tu comentario.." data-id="<?= $key->correl ?>"></textarea>
                                    <button type="submit" class="btn btn-xs btn-primary" ><i class="fa fa-pencil"></i> Publicar comentario</button>
                                </form>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </li>
                                <?php endif; ?>
                                            <?php } ?>

                                            <li id="newsfeed-update-example" class="media display-none" style="display: none">
                                                <a href="page_ready_user_profile.html" class="pull-left">
                                                    <img src="<?= base_url();?>img/placeholders/avatars/avatar13.jpg" alt="Avatar" class="img-circle">
                                                </a>
                                                <div class="media-body">
                                                    <p class="push-bit">
                                                        <span class="text-muted pull-right">
                                                            <small>Justo ahora</small>
                                                            <span class="text-success" data-toggle="tooltip" title="Desde la Web"><i class="fa fa-globe"></i></span>
                                                        </span>
                                                        <strong><a href="page_ready_user_profile.html">Usuario</a> subío 2 nuevas fotos</strong>
                                                    </p>
                                                    <div class="row push">
                                                        <div class="col-sm-6 col-md-4">
                                                            <a href="img/placeholders/photos/photo13.jpg" data-toggle="lightbox-image">
                                                                <img src="<?= base_url();?>img/placeholders/photos/photo13.jpg" alt="image">
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4">
                                                            <a href="img/placeholders/photos/photo23.jpg" data-toggle="lightbox-image">
                                                                <img src="<?= base_url();?>img/placeholders/photos/photo23.jpg" alt="image">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <p>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-thumbs-o-up"></i> Me gusta</a>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-comments-o"></i> Comentar</a>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-share-square-o"></i> Compartir</a>
                                                    </p>
                                                </div>
                                            </li>
                                            <!-- END Photos Uploaded -->

                                            <!-- Story Published -->
                                            <li class="media" style="display: none">
                                                <a href="page_ready_user_profile.html" class="pull-left">
                                                    <img src="<?= base_url();?>img/placeholders/avatars/avatar6.jpg" alt="Avatar" class="img-circle">
                                                </a>
                                                <div class="media-body">
                                                    <p class="push-bit">
                                                        <span class="text-muted pull-right">
                                                            <small>Hace 45 min</small>
                                                            <span class="text-danger" data-toggle="tooltip" title="Desde la Web"><i class="fa fa-globe"></i></span>
                                                        </span>
                                                        <strong><a href="page_ready_user_profile.html">Explorador</a> publicó nueva historia.</strong>
                                                    </p>
                                                    <h5><a href="page_ready_article.html"><strong>El viaje a la montaña</strong> &bull; Experiencia de una vez en la vida</a></h5>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Etiam egestas fringilla enim, id convallis lectus laoreet at. Fusce purus nisi, gravida sed consectetur ut, interdum quis nisi. Quisque egestas nisl id lectus facilisis scelerisque? Proin rhoncus dui at ligula vestibulum ut facilisis ante sodales! Suspendisse potenti..</p>
                                                    
                                                    <p>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-success"><i class="fa fa-thumbs-up"></i> Te gusta</a>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-share-square-o"></i> Compartir</a>
                                                    </p>

                                                    <!-- Comments -->
                                                    <ul class="media-list push">
                                                        <li class="media">
                                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar11.jpg" alt="Avatar" class="img-circle">
                                                            </a>
                                                            <div class="media-body">
                                                                <a href="page_ready_user_profile.html"><strong>User 1</strong></a>
                                                                <span class="text-muted"><small><em>Hace 29 min</em></small></span>
                                                                <p>Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum.</p>
                                                            </div>
                                                        </li>
                                                        <li class="media">
                                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle">
                                                            </a>
                                                            <div class="media-body">
                                                                <a href="page_ready_user_profile.html"><strong>User 2</strong></a>
                                                                <span class="text-muted"><small><em>18 min ago</em></small></span>
                                                                <p>In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend</p>
                                                            </div>
                                                        </li>
                                                        <li class="media">
                                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar.jpg" alt="Avatar" class="img-circle">
                                                            </a>
                                                            <div class="media-body">
                                                                <form action="page_ready_user_profile.html" method="post" onsubmit="return false;">
                                                                    <textarea id="profile-newsfeed-comment1" name="profile-newsfeed-comment1" class="form-control" rows="2" placeholder="Tu comentario.."></textarea>
                                                                    <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Publicar comentario</button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <!-- END Comments -->
                                                </div>
                                            </li>
                                            <!-- END Story Published -->

                                            <!-- Check in -->
                                            <li class="media" style="display: none">
                                                <a href="page_ready_user_profile.html" class="pull-left">
                                                    <img src="<?= base_url();?>img/placeholders/avatars/avatar13.jpg" alt="Avatar" class="img-circle">
                                                </a>
                                                <div class="media-body">
                                                    <p class="push-bit">
                                                        <span class="text-muted pull-right">
                                                            <small>1 hour ago</small>
                                                            <span class="text-success" data-toggle="tooltip" title="From Mobile"><i class="fa fa-mobile"></i></span>
                                                        </span>
                                                        <strong><a href="page_ready_user_profile.html">Aventurero</a> registrado en <a href="javascript:void(0)">Cafe-Bar</a>.</strong>
                                                    </p>
                                                    <div id="gmap-checkin" class="gmap push"></div>
                                                    <p>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-thumbs-o-up"></i> Me gusta</a>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-comments-o"></i> Comentar</a>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-share-square-o"></i> Compartir</a>
                                                    </p>
                                                </div>
                                            </li>
                                            <!-- END Check in -->

                                            <!-- Status Updated -->
                                            <li class="media" style="display: none">
                                                <a href="page_ready_user_profile.html" class="pull-left">
                                                    <img src="<?= base_url();?>img/placeholders/avatars/avatar10.jpg" alt="Avatar" class="img-circle">
                                                </a>
                                                <div class="media-body">
                                                    <p class="push-bit">
                                                        <span class="text-muted pull-right">
                                                            <small>5 hours ago</small>
                                                            <span class="text-info" data-toggle="tooltip" title="From Custom App"><i class="fa fa-wrench"></i></span>
                                                        </span>
                                                        <strong><a href="page_ready_user_profile.html">User 2</a> actualizo su estado.</strong>
                                                    </p>
                                                    <p>Primera publicación de la nueva aplicación.</p>
                                                    <p>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-thumbs-o-up"></i> Me gusta</a>
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-share-square-o"></i> Compartir</a>
                                                    </p>
                                                    <!-- Comments -->
                                                    <ul class="media-list push">
                                                        <li class="media">
                                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar16.jpg" alt="Avatar" class="img-circle">
                                                            </a>
                                                            <div class="media-body">
                                                                <a href="page_ready_user_profile.html"><strong>User 4</strong></a>
                                                                <span class="text-muted"><small><em>1 hour ago</em></small></span>
                                                                <p>Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum.</p>
                                                            </div>
                                                        </li>
                                                        <li class="media">
                                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar.jpg" alt="Avatar" class="img-circle">
                                                            </a>
                                                            <div class="media-body">
                                                                <form action="page_ready_user_profile.html" method="post" onsubmit="return false;">
                                                                    <textarea id="profile-newsfeed-comment" name="profile-newsfeed-comment" class="form-control" rows="2" placeholder="Tu comentario.."></textarea>
                                                                    <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Publicar comentario</button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <!-- END Comments -->
                                                </div>
                                            </li>
                                            <li class="media text-center">
                                                <a href="javascript:void(0)" class="btn btn-xs btn-default push">Ver más..</a>
                                            </li>
                                            <!-- END Status Updated -->
                                        </ul>
                                    </div>
                                    <!-- END Newsfeed Content -->
                                </div>
                                <!-- END Newsfeed Block -->
                            </div>
                            <!-- END First Column -->

                            <!-- Second Column -->
                            <div class="col-md-6 col-lg-7">
                                <!-- Info Block -->
                                <div class="block">
                                    <!-- Info Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Solicitudes de amistad"><i class="fa fa-plus"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Saludos"><i class="fa fa-briefcase"></i></a>
                                        </div>
                                        <h2>Acerca de <strong>Usuario conectado</strong> <small>&bull; <i class="fa fa-file-text text-primary"></i> <a href="javascript:void(0)" data-toggle="tooltip" title="Descargar bio en PDF">Biografia</a></small></h2>
                                    </div>
                                    <!-- END Info Title -->

                                    <!-- Info Content -->
<form id="profileperfil">
                                    <table class="table table-borderless table-striped">
                                        <tbody>
                                            <tr>
                                                <td style="width: 20%;"><strong>Apodo</strong></td>
                                                <td>
                                               <div class="col-sm-6">
                                                <input type="type"  class="form-control input-sm" value=" <?= trim($usuario->username) ?>" name="username">
                                              </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Información</strong></td>
                                                <td>Breve resumen de la personalidad, cargo y roles.</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Compañia</strong></td>
                                                <td>
                                                  <select class="form-control" name="company" id="company">
                                                    <option value="">Seleccione compañia</option>
                                                    <?php  $idoficina = $usuario->id_office; ?>
                                                      <?php foreach ($selectoffice as $key) {?>

                                                       <option value="<?=$key->id_office ?>"><?=$key->selectoficce ?> </option>

                                                    <?php  } ?>
                                                  </select>

                                              </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Eduacación</strong></td>
                                                <td><a href="javascript:void(0)">Detalle estudios y titulos</a></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Proyectos</strong></td>
                                                <td><a href="javascript:void(0)" class="label label-danger">Detalle proyectos en curso</a></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mejores habilidades</strong></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="label label-info">Ventas</a>
                                                    <a href="javascript:void(0)" class="label label-info">Administración</a>
                                                    <a href="javascript:void(0)" class="label label-info">Call Center</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email Plataforma</strong></td>
                                                <td>
                                            <div class="col-sm-6">
                                                <input type="type"  class="form-control" value=" <?= trim($usuario->email_system) ?>" name="email_system">
                                                </td>
                                              </div>
                                            </tr>
                                            <tr>
                                                <td><strong>Número RUT</strong></td>
                                                <td>
  <div class="col-sm-2">
<input type="text" name="rut_number" id="rut_number" class="form-control" value="<?= $usuario->rut_number ?>">
</div>
<div class="col-sm-6">
<input type="text" name="rut_validation" id="rut_validation" class="form-control" value="<?= $usuario->rut_validation ?>">
</div>


                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Id Jefe Directo</strong></td>
                                                <td>
                                                <select class="form-control" name="idboss" id="idboss">
                                                    <option value="">Seleccione Id Jefe Directo</option>
                                                </select>

                                                </td>


                                            </tr>
                                            <tr>
                                                <td><strong>Número Whatsapp</strong></td>
                                                <td>
<div class="col-sm-6">
 <input type="text"  class="form-control input-sm" value=" <?= trim($usuario->number_whatsapp) ?>" name="number_whatsapp">
</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Número Teléfono</strong></td>
                                                <td>
 <div class="col-sm-6">
 <input type="text"  class="form-control input-sm" value=" <?= trim($usuario->number_phone) ?>" name="number_phone">
</div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Imagen perfil</strong></td>
                                                <td>
 <a href="javascript:void(0)" class="btn btn-link btn-icon iconocamara" data-toggle="tooltip" data-placement="bottom" title="Add Photo"><i class="fa fa-camera"></i></a>

                                            <input type="file" name="imagen" id="file" style="display: none">

                                             <?php if ($this->session->userdata('avatar')): ?>
                                    <img src="<?= base_url();?>welcome/imagen_prev/<?= $this->session->userdata('id') ?>" width="80%" id="imgSalida">
                                <?php else: ?>
                                    <img src="<?= base_url();?>img/placeholders/avatars/avatar12.jpg" width="80%" id="imgSalida">
                                <?php endif; ?>

                                                </td>
                                            </tr>
                                            <tr>
                                            <td colspan=2>
                                            <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-upload"></i> Grabar</button></td>
</tr>
                                        </tbody>
                                    </table>
  </form>
                                    <!-- END Info Content -->
                                </div>
                                <!-- END Info Block -->

                                <!-- Friends Block -->
                                <div class="block">
                                    <!-- Friends Title -->
                                    <div class="block-title">
                                        <h2>Mis compañeros<strong> de trabajo.</strong>
                                    </div>
                                    <!-- END Friends Title -->

                                    <!-- Friends Content -->
                                    <div class="row text-center">

                                        <?php
                                        $usuarioswork = $usuario->id_work;
                                        foreach ($amigos as $key) { ?>



                                        <?php
                                        if($usuarioswork === $key->id_work){
                                                 $stylo = "style='border:solid; border-color:#008000'";
                                        }else{

                                                 $stylo = "style='border:solid;'";
                                        }

                                        if ($key->username) {
                                            $titleuser = $key->username;
                                        }else{
                                            $titleuser = $key->email;
                                        } ?>
                                        <div class="col-xs-4 col-sm-3 col-lg-2 block-section">
                                            <a href="javascript:void(0)">
                <img src="<?= base_url();?>img/placeholders/avatars/avatar7.jpg" alt="image" class="img-circle" data-toggle="tooltip" title="<?= $titleuser ?>" <?= $stylo ?> >
                                            </a>
                                        </div>

                                        <?php } ?>


                                    </div>
                                    <!-- END Friends Content -->
                                </div>
                                <!-- END Friends Block -->

                                <!-- Twitter Block -->
                                <div class="block full">
                                    <!-- Twitter Title -->
                                    <div class="block-title">
                                        <h2>Últimas <strong>Tareas</strong></h2>
                                    </div>
                                    <!-- END Twitter Title -->

                                    <!-- Twitter Content -->
                                    <div class="block-top block-content-mini-padding">
                                        <form action="page_ready_user_profile.html" method="post" onsubmit="return false;">
                                            <textarea id="profile-tweet" name="profile-tweet" class="form-control push-bit" rows="3" placeholder="Comparte algo con tu grupo de trabajo.."></textarea>
                                            <div class="clearfix">
                                                <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-send"></i> Enviar</button>
                                                <a href="javascript:void(0)" class="btn btn-link btn-icon" data-toggle="tooltip" data-placement="bottom" title="Agregar ubicación"><i class="fa fa-location-arrow"></i></a>
                                                <a href="javascript:void(0)" class="btn btn-link btn-icon" data-toggle="tooltip" data-placement="bottom" title="Agregar Foto"><i class="fa fa-camera"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                    <ul class="media-list">
                                        <li class="media">
                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle">
                                            </a>
                                            <div class="media-body">
                                                <span class="text-muted pull-right"><small><em>30 min ago</em></small></span>
                                                <a href="page_ready_user_profile.html"><strong>User 1</strong></a>
                                                <p>Recuerden <a href="javascript:void(0)">revisar</a> documento con actividades a realizar diariamente por campaña retención clientes<a href="javascript:void(0)" class="text-danger"></a></p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle">
                                            </a>
                                            <div class="media-body">
                                                <span class="text-muted pull-right"><small><em>3 hours ago</em></small></span>
                                                <a href="page_ready_user_profile.html"><strong>John Doe</strong></a>
                                                <p>Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula elit. Aliquam at orci ac neque semper dictum.</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle">
                                            </a>
                                            <div class="media-body">
                                                <span class="text-muted pull-right"><small><em>yesterday</em></small></span>
                                                <a href="page_ready_user_profile.html"><strong>John Doe</strong></a>
                                                <p>In hac habitasse platea dictumst. Proin ac nibh rutrum <a href="javascript:void(0)">lectus</a> rhoncus eleifend <a href="javascript:void(0)" class="text-danger"><strong>#design</strong></a></p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle">
                                            </a>
                                            <div class="media-body">
                                                <span class="text-muted pull-right"><small><em>2 days ago</em></small></span>
                                                <a href="page_ready_user_profile.html"><strong>John Doe</strong></a>
                                                <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend.</p>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <a href="page_ready_user_profile.html" class="pull-left">
                                                <img src="<?= base_url();?>img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle">
                                            </a>
                                            <div class="media-body">
                                                <span class="text-muted pull-right"><small><em>3 days ago</em></small></span>
                                                <a href="page_ready_user_profile.html"><strong>John Doe</strong></a>
                                                <p>In hac habitasse platea dictumst. Proin ac nibh rutrum lectus rhoncus eleifend.</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <!-- END Twitter Content -->
                                </div>
                                <!-- END Twitter Block -->


                                <!-- Photos Block -->
                                <div class="block">
                                    <!-- Photos Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        </div>
                                        <h2>Mejores <strong>Fotografías</strong> <small>&bull; <a href="javascript:void(0)">25 Albunes</a></small></h2>
                                    </div>
                                    <!-- END Photos Title -->

                                    <!-- Photos Content -->
                                    <div class="gallery" data-toggle="lightbox-gallery">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo12.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo12.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo15.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo15.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo3.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo3.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo4.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo4.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo5.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo5.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo6.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo6.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo20.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo20.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo17.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo17.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo14.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo14.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo9.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo9.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo11.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo11.jpg" alt="image">
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-3">
                                                <a href="<?= base_url();?>img/placeholders/photos/photo10.jpg" class="gallery-link" title="Image Info">
                                                    <img src="<?= base_url();?>img/placeholders/photos/photo10.jpg" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Photos Content -->
                                </div>
                                <!-- END Photos Block -->





                            </div>
                            <!-- END Second Column -->
                        </div>
                        <!-- END User Profile Content -->

                            <input type="hidden" name="idboss" id="idbossid" value="<?php if($usuario->id_user_boss){  echo $usuario->id_user_boss; }else{ echo 0; } ?>">


    <input type="hidden" name="idoficina" id="idoficina" value="<?php if($usuario->id_office){  echo $usuario->id_office; }else{ echo 0; } ?>" >
                    </div>
                    <!-- END Page Content -->

<div id="ubicacion" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ubicacion</h4>
      </div>
      <div class="modal-body">
        <input type="text" id="location-text-box" />
 <div id="map-canvas"></div>
        <form id="formubicacion">
                
                <input type="hidden" name="latitud" id="latitud">
                <input type="hidden" name="longitud" id="longitud">
               
                <input type="submit" name="guardar" class="btn btn-success compartirbutton" value="Compartir Ubicacion">
                <i class="fa fa-spinner fa-spin fa-3x fa-fw loadingcompartir" style="display: none"></i>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>


<div id="grabacion" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Grabar</h4>
      </div>
      <div class="modal-body">
     

        <form id="forgrabar">
                
            <div id="controls">
     <span id="recordButton" class="btn btn-danger"><i class="fa fa-microphone"></i>Record</span>
     <span id="pauseButton" class="btn btn-success" disabled><i class="fa fa-pause"></i>Pause</span>
     <span id="stopButton" class="btn btn-default" disabled><i class="fa fa-stop"></i>Stop</span>
    </div>
     <div id="formats">Format: start recording to see sample rate</div>
    <h3>Recordings</h3>
    <ol id="recordingsList"></ol>
    <br/>
               
                 <span class="loadinggrabacion" style="display: none"><i class="fa fa-spinner fa-spin fa-3x fa-fw" ></i>La grabacion se esta almacenando</span>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="fotomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar foto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form id="formmodalfile">
                        <div class="form-group">
                            <input type="file" name="filemodal" id="filemodal" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary savepicture">Save picture</button>

                </form>
      <div class="modal-footer">
         <span class="loadingimagen" style="display: none"><i class="fa fa-spinner fa-spin fa-3x fa-fw" ></i>Espere un momento</span>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="archivomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar archivos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form id="formmodalarchivo">
                        <div class="form-group">
                            <input type="file" name="archivomodaltext" id="archivomodaltext" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary botonfile">Save file</button>

                </form>
      <div class="modal-footer">
         <span class="loadingdoc" style="display: none"><i class="fa fa-spinner fa-spin fa-3x fa-fw" ></i>Espere un momento</span>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>

<?php $this->load->view('footer'); ?>
<script src="<?= base_url() ?>js/rec.js"></script>
    <script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
<script type="text/javascript">
        var map;
var marker;





function initialize() {


    <?php foreach ($selectnews as $key) {
        if($key->location != NULL):
        $posiciones = explode("|", $key->location );
    ?>
var uluru = {lat: <?= $posiciones[0] ?>, lng: <?= $posiciones[1] ?>};
  // The map, centered at Uluru
  var map = new google.maps.Map(document.getElementById('map<?=$key->correl?>'), {zoom: 10, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
 <?php 

    endif;
    } 

 ?>

  var mapOptions = {
    zoom: 12
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  // Get GEOLOCATION
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
        position.coords.longitude);

      map.setCenter(pos);
      marker = new google.maps.Marker({
        position: pos,
        map: map,
        draggable: true
      });

      //console.log(pos.lat());
      $("#latitud").val(pos.lat());
      $("#longitud").val(pos.lng());

      console.log();
google.maps.event.addListener(marker,'dragend', function (event)
      {
       
         $("#latitud").val(this.getPosition().lat());
         $("#longitud").val(this.getPosition().lng());

      });

    }, function() {
      handleNoGeolocation(true);
    });


    
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }

  function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
      var content = 'Error: The Geolocation service failed.';
    } else {
      var content = 'Error: Your browser doesn\'t support geolocation.';
    }

    var options = {
      map: map,
      position: new google.maps.LatLng(60, 105),
      content: content
    };

    map.setCenter(options.position);
     marker = new google.maps.Marker({
      position: options.position,
      map: map,
      draggable: true
    });

 google.maps.event.addListener(marker,'dragend', function (event)
      {
          $("#latitud").val(this.getPosition().lat());
         $("#longitud").val(this.getPosition().lng());

      });

  }




  // get places auto-complete when user type in location-text-box
  var input = /** @type {HTMLInputElement} */
    (
      document.getElementById('location-text-box'));


  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

  var infowindow = new google.maps.InfoWindow();
  marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29),
    draggable: true,
    
  });

   
     


  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17); // Why 17? Because it looks good.
    }
    marker.setIcon( /** @type {google.maps.Icon} */ ({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
   

       $("#latitud").val(place.geometry.location.lat());
    $("#longitud").val(place.geometry.location.lng());

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''), (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

  });


}


    

</script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaznzv0sICn4A8bWY0AmH_muSuYfxp3iw&libraries=places&callback=initialize"
        async defer></script>

    
    
<script type="text/javascript">

$('#company option[value="' + $("#idoficina").val() +'"]').prop("selected", true);

$(function(){
formmodalarchivo


$( "#formmodalarchivo" ).submit(function( event ) {
        //M.AutoInit();

      event.preventDefault();
      var actionurl = event.currentTarget.action;
                  var formData = new FormData(document.getElementById("formmodalarchivo"));

         $.ajax({
              url: "<?php echo base_url(); ?>News/formmodalarchivo",
              type: 'post',
              dataType: 'json',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
                  beforeSend: function() {
                
                    $(".botonfile").hide();
                    $(".loadingdoc").show();
            },
                success: function(data) {
                      if(data["error"]){
                           toastr.info(data["mensaje"])
                           //alert(data["mensaje"]);

                      }else{

                         toastr.info(data["mensaje"])
                            //alert(data["mensaje"]);


                      }
                 },
             complete: function() {
                location.reload();
            }
         });
    
});

$( "#formmodalfile" ).submit(function( event ) {
        //M.AutoInit();

      event.preventDefault();
      var actionurl = event.currentTarget.action;
                  var formData = new FormData(document.getElementById("formmodalfile"));

         $.ajax({
              url: "<?php echo base_url(); ?>News/compartirfile",
              type: 'post',
              dataType: 'json',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              beforeSend: function() {
                
                    $(".savepicture").hide();
                    $(".loadingimagen").show();
            },
                success: function(data) {
                      if(data["error"]){
                           toastr.info(data["mensaje"])
                           //alert(data["mensaje"]);

                      }else{

                         toastr.info(data["mensaje"])
                            //alert(data["mensaje"]);


                      }
                 },
             complete: function() {
                location.reload();
            }
         });
    
});

var idboss = $("#idbossid").val();
      $.ajax({
              url: "<?php echo base_url(); ?>dashboard/boss",
              type: 'post',
              dataType: 'json',
              data: { id: $( "#company" ).val() },
                success: function(data) {



                          for(i=0;i<data.length;i++){
                            if(idboss == data[i].id){
                          $("#idboss").append("<option selected value='"+data[i].id+"'>"+data[i].name+"</option>");
                            }else{
                            $("#idboss").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                            }
                          }

                 }
         });



$('#rut_number').mask('99');
$('#rut_validation').mask('999.999-K');

$( ".iconocamara" ).click(function() {
  $( "#file" ).click();
});


$('#file').change(function(e) {
      addImage(e);
     });

     function addImage(e){
      var file = e.target.files[0],
      imageType = /image.*/;

      if (!file.type.match(imageType))
       return;

      var reader = new FileReader();
      reader.onload = fileOnload;
      reader.readAsDataURL(file);
     }

     function fileOnload(e) {
      var result=e.target.result;
      $('#imgSalida').attr("src",result);
     }


$( "#company" ).change(function( event ) {
  $('#idboss').find('option:not(:first)').remove();

  var seleccion  = $(this).val();
          $.ajax({
              url: "<?php echo base_url(); ?>dashboard/boss",
              type: 'post',
              dataType: 'json',
              data: { id:seleccion},
                success: function(data) {
                  console.log(data);
                      if(data["error"]){
                           toastr.info(data["mensaje"])


                      }else{

                          for(i=0;i<data.length;i++){
                            console.log(data[i].id);
                            $("#idboss").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                          }
                      }
                 }
         });


});
$( "#profileperfil" ).submit(function( event ) {
        //M.AutoInit();

      event.preventDefault();
      var actionurl = event.currentTarget.action;
                  var formData = new FormData(document.getElementById("profileperfil"));

         $.ajax({
              url: "<?php echo base_url(); ?>dashboard/perfil",
              type: 'post',
              dataType: 'json',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
                success: function(data) {
                      if(data["error"]){
                           toastr.info(data["mensaje"])
                           //alert(data["mensaje"]);

                      }else{

                         toastr.info(data["mensaje"])
                            //alert(data["mensaje"]);


                      }
                 }
         });
    
});


$( "#task_new" ).submit(function( event ) {
        //M.AutoInit();

      event.preventDefault();
      var actionurl = event.currentTarget.action;
        var formData = new FormData(document.getElementById("task_new"));
        console.log("nueva noticia");
        $(".media-feed-hover").prepend("<li class='media'>"+$("#default-textarea").val()+"</li>");
     $.ajax({
              url: "<?php echo base_url(); ?>News/newsnew",
              type: 'post',
              dataType: 'json',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
                success: function(data) {
                      if(data["error"]){
                           toastr.info(data["mensaje"])
                           //alert(data["mensaje"]);

                      }else{

                         toastr.info(data["mensaje"])
                            //alert(data["mensaje"]);


                      }
                 }
         });
        //
    });


$( "#formubicacion" ).submit(function( event ) {
        //M.AutoInit();

      event.preventDefault();
      var actionurl = event.currentTarget.action;
        var formData = new FormData(document.getElementById("formubicacion"));
        console.log("nueva noticia");
      /*  $(".media-feed-hover").prepend("<li class='media'>"+$("#default-textarea").val()+"</li>");*/
     $.ajax({
              url: "<?php echo base_url(); ?>News/newsnewubicacion",
              type: 'post',
              dataType: 'json',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
               beforeSend: function() {
                
                    $(".compartirbutton").hide();
                    $(".loadingcompartir").show();
            },
                success: function(data) {
                      if(data["error"]){
                           toastr.info(data["mensaje"])
                           //alert(data["mensaje"]);

                      }else{

                         toastr.info(data["mensaje"])
                            //alert(data["mensaje"]);


                      }
                 },
                 
            complete: function() {
                location.reload();
            }
         });
        //
    });

$( ".publicarcomentario" ).submit(function( event ) {
        //M.AutoInit();

      event.preventDefault();
      var actionurl = event.currentTarget.action;
       // var formData = new FormData(document.getElementById("formubicacion"));
        var dataString = $(this).serialize();
      var texto = '';
        //return false;
      /*  $(".media-feed-hover").prepend("<li class='media'>"+$("#default-textarea").val()+"</li>");*/
     let  tr = $(this).closest('ul'); //.find('li:nth-last-child(2)');
var form = $(this);
     $.ajax({
              url: "<?php echo base_url(); ?>News/comentarios",
              type: 'post',
              dataType: 'json',
              data: dataString,            
                success: function(data) {
                      if(data["error"]){
                           toastr.info(data["mensaje"])
                           //alert(data["mensaje"]);
                        console.log(data);
                            texto = data['texto'];
                            var usuario = data['usuario'];

                      var cantidad = tr.find('li').length-2;  
                      console.log(cantidad);    
                    tr.find('li:eq('+cantidad+')').append('<li class="media"><a href="page_ready_user_profile.html" class="pull-left"><img src="https://desarrollo.solventa.maximoerp.com/img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle"></a><div class="media-body"><a href="page_ready_user_profile.html"><strong>'+usuario+'</strong></a><span class="text-muted"><small><em>18 min ago</em></small></span><p>'+texto+'</p></div></li>');
  form[0].reset();
                      }else{

                         toastr.info(data["mensaje"])
                            //alert(data["mensaje"]);
                      
                   
                      }
                 },
                 complete: function(data){
                    
                 }
         });


                     
      /*  var li = $tr.find('li').length - 1; 
        console.log(li);          */
   




    });




        });
</script>

  </body>
</html>
