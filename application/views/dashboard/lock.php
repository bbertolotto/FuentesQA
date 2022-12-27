<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> 
<html class="no-js"><!--<![endif]-->
    <head>
        <meta charset="<?php echo $parameters->meta_charset;?>">
        <title><?php echo $parameters->meta_title; ?></title>

        <meta name="description" content="<?php echo $parameters->meta_description;?>">
        <meta name="author" content="<?php echo $parameters->meta_author;?>">
        <meta name="robots" content="<?php echo $parameters->meta_robots;?>">
        <meta name="viewport" content="<?php echo $parameters->meta_viewport;?>">

        <link rel="shortcut icon" href="<?= base_url();?>img/favicon.png">
        <link rel="apple-touch-icon" href="<?= base_url();?>img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?= base_url();?>img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?= base_url();?>img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?= base_url();?>img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?= base_url();?>img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?= base_url();?>img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?= base_url();?>img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?= base_url();?>img/icon180.png" sizes="180x180">

        <link rel="stylesheet" href="<?= base_url();?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url();?>css/plugins.css">
        <link rel="stylesheet" href="<?= base_url();?>css/main.css">
        <link rel="stylesheet" href="<?= base_url();?>css/themes.css">

        <script src="<?= base_url();?>js/vendor/modernizr-respond.min.js"></script>

</head>
<body>
    <div id="login-background">
    <img src="<?= base_url();?>img/placeholders/headers/widget11_header.jpg" alt="Login Background" class="animation-pulseSlow">
    </div>

    <div id="login-container" class="animation-slideDown">
        <div class="login-title text-right">
            <h1>
            <?php if($this->session->userdata('avatar')): ?>
                    <img src="<?= base_url();?>welcome/imagen_prev/<?=$this->session->userdata('id') ?>" alt="avatar" class="img-circle pull-left" width="20%">
                    <?php else: ?>
                        <img src="<?= base_url();?>img/placeholders/avatars/avatar2.jpg" alt="avatar" class="img-circle pull-left">
                    <?php endif; ?>


                    <strong><?= $this->session->userdata('nombre') ?></strong><br>
                    <small>
                        <a href="#" class="btn btn-xs btn-success cantidadinbox" data-toggle="tooltip" data-placement="bottom" ><i class="fa fa-envelope"></i> 0</a>
                    </small>
                </h1>
            </div>

            <div class="block">
                <?php
                  echo form_open(
                    base_url( 'welcome/unlock' ), [
                      'id' => 'form-login',
                      'class' => 'form-horizontal push'
                      ]);
                   ?>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php echo form_hidden('email', $this->session->userdata('email') ); ?>
                                <?php echo form_password([
                                    'id' => 'lock-password',
                                    'name' => 'lock-password',
                                    'class' => 'form-control',
                                    'placeholder' => 'Contraseña',
                                ]); ?>
                                <div class="input-group-btn">
                                  <?php echo form_button([
                                      'type' => 'submit',
                                      'class' => 'btn btn-primary',
                                      'content' => "<i class='fa fa-unlock-alt'></i>Desbloquear",
                                  ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
                <p class="text-center">
                    <a href="<?= base_url();?>welcome/signout"><?= $this->lang->line('text_name_lock');?> <?= $this->session->userdata('nombre') ?></a>
                </p>
            </div>
        </div>


<script src="/js/jquery-1.12.4.min.js"></script>
<script src="/js/sweetalert.js"></script>

<script>
$(function(){

    $('#form-login').on('submit', function(event) {

        $("#lock-password").val( btoa($("#lock-password").val()) );
    });


});
</script>

<?php
if($this->session->userdata("login")=="invalid"){?>
<script type="text/javascript">

    Swal.fire(
      '<?php echo $this->session->userdata("login-error-title");?>',
      '<?php echo $this->session->userdata("login-error-message");?>',
      'error'
    );

</script>
<?php
}?>
</body>
</html>