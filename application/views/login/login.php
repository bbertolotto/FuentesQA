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

        <div id="login-container" class="animation-fadeIn">

            <div class="login-title text-center">
                <h1><i class="gi gi-keys"></i>&nbsp;<?php echo $parameters->login_message_welcome_client;?></h1>
            </div>

            <div class="block push-bit">

                <?php
                    echo form_open(
                        base_url( 'welcome/validar' ), [
                            'id' => 'form-login',
                            'class' => 'form-horizontal form-bordered form-control-borderless'
                    ]);
                ?>
                <fieldset>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <?php echo form_input([
                                    'type' => 'email',
                                    'id' => 'login-username',
                                    'name' => 'login-username',
                                    'class' => 'form-control input-lg',
                                    'placeholder' => 'Email',
                                ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                <?php echo form_password([
                                    'id' => 'login-password',
                                    'name' => 'login-password',
                                    'class' => 'form-control input-lg',
                                    'placeholder' => 'Clave',
                                ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <?php echo form_button([
                                'type' => 'submit',
                                'class' => 'btn btn-md btn-primary',
                                'content' => "<i class='fa fa-angle-right'></i> Validar para ingresar",
                            ]); ?>
                        </div>
                    </div>
                </fieldset>
                <?php echo form_close(); ?>

            </div>

            <footer class="text-muted text-center">
                <small><span id="year-copy"></span> &copy; <a href="<?php echo base_url();?>" target=""><?php echo $parameters->sys_name_system;?></a></small> &amp; <small><a href="<?php echo $parameters->sys_url_business;?>" target="_blank"><?php echo $parameters->sys_name_business;?></a></small>
            </footer>
        </div>

<script src="/js/jquery-1.12.4.min.js"></script>
<script src="/js/sweetalert.js"></script>

<script>
$(function(){

    $('#form-login').on('submit', function(event) {

        $("#login-password").val( btoa($("#login-password").val()) );
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

