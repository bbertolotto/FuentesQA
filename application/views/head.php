<title><?php echo $this->lang->line('text_title_header'); ?></title>
<meta name="description" content="MaximoERP es una plataforma comercial financiera y administracion centralizada.">
<meta name="author" content="TeknodataSystems">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
<link rel="shortcut icon" href="/img/favicon.png">
<link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
<link rel="apple-touch-icon" href="/img/icon72.png" sizes="72x72">
<link rel="apple-touch-icon" href="/img/icon76.png" sizes="76x76">
<link rel="apple-touch-icon" href="/img/icon114.png" sizes="114x114">
<link rel="apple-touch-icon" href="/img/icon120.png" sizes="120x120">
<link rel="apple-touch-icon" href="/img/icon144.png" sizes="144x144">
<link rel="apple-touch-icon" href="/img/icon152.png" sizes="152x152">
<link rel="apple-touch-icon" href="/img/icon180.png" sizes="180x180">
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/plugins.css">
<link rel="stylesheet" href="/css/main.css">
<link rel="stylesheet" href="/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/css/jquery-confirm.min.css">
<link rel="stylesheet" type="text/css" href="/css/toastr.min.css">
<script src="/js/vendor/modernizr-respond.min.js"></script>
<script src="/js/nobackbutton.js"></script>
</head>
<body onload="nobackbutton();">
    <div id="page-wrapper">

        <div class="preloader themed-background">
            <h1 class="push-top-bottom text-light text-center"><strong>Prooooo</strong>UI</h1>
            <div class="inner">
                <h3 class="text-light visible-lt-ie9 visible-lt-ie10"><strong>Loading..</strong></h3>
                <div class="preloader-spinner hidden-lt-ie9 hidden-lt-ie10"></div>
            </div>
        </div>

        <div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">

            <div id="sidebar-alt">
                <div id="sidebar-alt-scroll">
                    <div class="sidebar-content">
                        <a href="/chat" class="sidebar-title">
                            <i class="gi gi-comments pull-right"></i> <strong>Chat </strong>comercial</a>
                        <ul class="chat-users clearfix">
                        <?php foreach ($this->session->userdata('usernamelistado') as $key) {?>
                        <li>
                    <?php if($this->session->userdata('usuariosusername')[$key->unido]["email"] == $this->session->userdata('email')){
                            $nombreperfil = $this->session->userdata('usuariosusername')[$key->creado]['name']." ".$this->session->userdata('usuariosusername')[$key->creado]['last_name'];
                            $avatar = $this->session->userdata('usuariosusername')[$key->creado]['avatar'];
                            $avatarid = $this->session->userdata('usuariosusername')[$key->creado]['id_user'];
                          }else{
                            $nombreperfil = $this->session->userdata('usuariosusername')[$key->unido]['name']." ".$this->session->userdata('usuariosusername')[$key->unido]['last_name'];
                            $avatar = $this->session->userdata('usuariosusername')[$key->unido]['avatar'];
                            $avatarid = $this->session->userdata('usuariosusername')[$key->unido]['id_user'];
                            }?>
                      <a href="javascript:void(0)" class="chat-user-online chatusuario" data-id="<?=$key->number_sala?>" data-unido="<?=$nombreperfil?>">
                    <span></span>
                    <?php if($avatar): ?>
                          <img src="/welcome/imagen_prev/<?=$avatarid ?>" alt="avatar" class="img-circle">
                          <?php else: ?>
                               <img src="/img/placeholders/avatars/avatar12.jpg" alt="avatar" class="img-circle">
                          <?php endif; ?>
                      </a>
                      </li>
                      <?php }?>
                    </ul>
                    <div class="chat-talk display-none">
                            <input type="text" id="idsala">
                            <div class="chat-talk-info sidebar-section">
                                <button id="chat-talk-close-btn" class="btn btn-xs btn-default pull-right">
                                    <i class="fa fa-times"></i>
                                </button>
                                <img src="<?=base_url();?>img/placeholders/avatars/avatar5.jpg" alt="avatar" class="img-circle pull-left">
                                <span class="nombre"><strong>John</strong> Doe</span>
                            </div>
                            <ul class="chat-talk-messages">
                                <li class="text-center"><small>Yesterday, 18:35</small></li>
                                <li class="chat-talk-msg animation-slideRight">Hey admin?</li>
                                <li class="chat-talk-msg animation-slideRight">How are you?</li>
                                <li class="text-center"><small>Today, 7:10</small></li>
                                <li class="chat-talk-msg chat-talk-msg-highlight themed-border animation-slideLeft">I'm fine, thanks!</li>
                            </ul>
                            <form action="#" method="post" id="sidebar-chat-form" class="chat-form">
                                <input type="text" id="sidebar-chat-message" name="sidebar-chat-message" class="form-control form-control-borderless" placeholder="Type a message..">
                            </form>
                        </div>
                        <a href="javascript:void(0)" class="sidebar-title">
                            <i class="fa fa-globe pull-right"></i> <strong><?php echo $this->lang->line('Activity'); ?></strong>
                        </a>
                        <div class="sidebar-section">
                            <div class="alert alert-danger alert-alt">
                                <small>just now</small><br>
                                <i class="fa fa-thumbs-up fa-fw"></i> Upgraded to Pro plan
                            </div>
                            <div class="alert alert-info alert-alt">
                                <small>2 hours ago</small><br>
                                <i class="gi gi-coins fa-fw"></i> You had a new sale!
                            </div>
                            <div class="alert alert-success alert-alt">
                                <small>3 hours ago</small><br>
                                <i class="fa fa-plus fa-fw"></i> <a href="page_ready_user_profile.html"><strong>John Doe</strong></a> would like to become friends!<br>
                                <a href="javascript:void(0)" class="btn btn-xs btn-primary"><i class="fa fa-check"></i> Accept</a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-default"><i class="fa fa-times"></i> Ignore</a>
                            </div>
                            <div class="alert alert-warning alert-alt">
                                <small>2 days ago</small><br>
                                Running low on space<br><strong>18GB in use</strong> 2GB left<br>
                                <a href="page_ready_pricing_tables.html" class="btn btn-xs btn-primary"><i class="fa fa-arrow-up"></i> Upgrade Plan</a>
                            </div>
                        </div>

                        <a href="page_ready_inbox.html" class="sidebar-title">
                            <i class="fa fa-envelope pull-right"></i> <strong><?php echo $this->lang->line('Messages'); ?></strong>
                        </a>
                        <div class="sidebar-section">
                            <div class="alert alert-alt">
                                Debra Stanley<small class="pull-right">just now</small><br>
                                <a href="page_ready_inbox_message.html"><strong>New Follower</strong></a>
                            </div>
                            <div class="alert alert-alt">
                                Sarah Cole<small class="pull-right">2 min ago</small><br>
                                <a href="page_ready_inbox_message.html"><strong>Your subscription was updated</strong></a>
                            </div>
                            <div class="alert alert-alt">
                                Bryan Porter<small class="pull-right">10 min ago</small><br>
                                <a href="page_ready_inbox_message.html"><strong>A great opportunity</strong></a>
                            </div>
                            <div class="alert alert-alt">
                                Jose Duncan<small class="pull-right">30 min ago</small><br>
                                <a href="page_ready_inbox_message.html"><strong>Account Activation</strong></a>
                            </div>
                            <div class="alert alert-alt">
                                Henry Ellis<small class="pull-right">40 min ago</small><br>
                                <a href="page_ready_inbox_message.html"><strong>You reached 10.000 Followers!</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="sidebar">
                <div id="sidebar-scroll">
                    <div class="sidebar-content">
                        <div class="sidebar-brand text-center">
                            <span class="sidebar-nav-mini-hide">
                                 <strong><?php echo $this->lang->line('text_name_system'); ?></strong>
                            </span>
                        </div>
                        <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                            <div class="sidebar-user-avatar">
                                <!--a href="/dashboard/profile"-->
                                    <img src="/welcome/imagen_prev/<?= $this->session->userdata('id') ?>" alt="avatar">
                                <!--/a-->
                            </div>
                            <div class="sidebar-user-name"><?= $this->session->userdata('nombre') ?></div>
                            <div class="sidebar-user-links">
                                <!--a href="/dashboard/profile" data-toggle="tooltip" data-placement="bottom" title="<?= $this->lang->line('Profile');?>"><i class="gi gi-user"></i></a-->
                                <!--a href="page_ready_inbox.html" data-toggle="tooltip" data-placement="bottom" title="<?= $this->lang->line('Messages');?>"><i class="gi gi-envelope"></i></a-->
                                <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                                <a href="javascript:void(0)" class="enable-tooltip" data-placement="bottom" title="<?= $this->lang->line('Settings');?>" onclick="$('#modal-user-settings').modal('show');"><i class="gi gi-cogwheel"></i></a>
                                <a href="/dashboard/lock" data-toggle="tooltip" data-placement="bottom" title="<?= $this->lang->line('Lock');?>"><i class="gi gi-lock"></i></a>
                                <a href="/welcome/signout" data-toggle="tooltip" data-placement="bottom" title="<?= $this->lang->line('Logout');?>"><i class="gi gi-exit"></i></a>
                            </div>
                        </div>
                        <ul class="sidebar-nav">

                            <li>
                                <a href="/dashboard" <?php if($this->session->userdata('selector')=='1.0.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-dashboard sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Dashboard');?></span></a>
                            </li>
                            <li>
                                <a href="/dashboard/mydashboard" <?php if($this->session->userdata('selector')=='2.0.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('My Dashboard');?></span></a>
                            </li>
                            <li <?php if(substr($this->session->userdata('selector'),0,1)=='3'){echo 'class="active"';}?>>
                                <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-users sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Centro Servicios</span></a>
                                <ul>
                                    <li>
                                        <a href="/client" <?php if($this->session->userdata('selector')=='3.0.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-search sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Search');?></span></a>
                                    </li>
                                    <li <?php if(substr($this->session->userdata('selector'),0,3)=='3.1'){echo 'class="active"';}?>>
                                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide" ></i><i class="hi hi-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Clientes</span></a>
                                        <ul>
                                            <li>
                                                <a href="/client/information" <?php if($this->session->userdata('selector')=='3.1.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-address_book sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Datos Personales</span></a>
                                            </li>
                                            <li>
                                                <a href="/client/contact" <?php if($this->session->userdata('selector')=='3.1.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-phone_alt sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Datos Contacto</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li <?php if(substr($this->session->userdata('selector'),0,3)=='3.2'){echo 'class="active"';}?>>
                                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="hi hi-credit_card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Productos</span></a>
                                        <ul>
                                            <li>
                                                <a href="/client/consolidate" <?php if($this->session->userdata('selector')=='3.2.1'){echo 'class="active"';}?>><i class="hi hi-compressed sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Consolidado</span></a>
                                            </li>
                                            <li>
                                                <a href="/client/lasttransaction" <?php if($this->session->userdata('selector')=='3.2.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-warning-sign sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">&#218;ltimas Transacciones</span></a>
                                            </li>
                                            <li>
                                                <a href="/client/lastaccount" <?php if($this->session->userdata('selector')=='3.2.3'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">&#218;ltimos EECC</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="/client/secure" <?php if($this->session->userdata('selector')=='3.3.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-beach_umbrella sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Seguros</span></a>
                                    </li>

                                    <li>
                                        <a href="/client/replacecard" <?php if($this->session->userdata('selector')=='3.4.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Reponer Tarjeta</span></a>
                                    </li>

                                </ul>
                            </li>

                            <li <?php if(substr($this->session->userdata('selector'),0,1)=='6'){echo 'class="active"';}?>>
                                <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-credit-card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Capturing Flows');?></span></a>
                                <ul>

                                  <li>
                                      <a href="/capturing/search" <?php if($this->session->userdata('selector')=='6.1.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-search sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Search');?></span></a>
                                  </li>

                                  <li>
                                      <a href="/capturing/preapproved" <?php if($this->session->userdata('selector')=='6.1.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-user-plus sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Capturing');?></span></a>
                                  </li>

                                  <li>
                                      <a href="/capturing/documents" <?php if($this->session->userdata('selector')=='6.1.3'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-print sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Documents');?></span></a>
                                  </li>

                                <li>
                                    <a href="/capturing/pinpadBridgeStatus" <?php if($this->session->userdata('selector')=='6.1.4'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-cc-visa sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Activar Tarjeta</span></a>
                                </li>

                                </ul>
                            </li>

                            <li <?php if(substr($this->session->userdata('selector'),0,1)=='4'){echo 'class="active"';}?>>
                               <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-calculator sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Commercial flows');?></span></a>
                                <ul>
                                    <li <?php if(substr($this->session->userdata('selector'),0,3)=='4.1'){echo 'class="active"';}?>>
                                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="hi hi-credit_card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Super Advanced');?></span></a>
                                        <ul>
                                            <li>
                                              <a href="/advance/search" <?php if($this->session->userdata('selector')=='4.1.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-search sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Search');?></span></a>
                                            </li>
                                            <li>
                                                <a href="/advance/simulate" <?php if($this->session->userdata('selector')=='4.1.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-adjust_alt sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Simulate');?></span></a>
                                            </li>
<?php if($this->session->userdata("id_rol") == USER_ROL_EJECUTIVO_COMERCIAL):?>
                                            <li>
                                                <a href="/advance/create" <?php if($this->session->userdata('selector')=='4.1.3'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-circle_plus sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Create');?></span></a>
                                            </li>
<?php endif; ?>
<?php if($this->session->userdata("id_rol") == USER_ROL_EJECUTIVO_TELEMARKETING):?>
                                            <li>
                                                <a href="/advance/remote" <?php if($this->session->userdata('selector')=='4.1.4'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-circle_plus sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Create');?></span></a>
                                            </li>
<?php endif; ?>
                                            <li>
                                                <a href="/client/documents" <?php if($this->session->userdata('selector')=='4.1.7'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-print sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Documentos</span></a>
                                            </li>
                                            <li>
                                                <a href="/advance/statustransfer" <?php if($this->session->userdata('selector')=='4.1.8'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-check sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Estado Transferencia</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li <?php if(substr($this->session->userdata('selector'),0,3)=='4.2'){echo 'class="active"';}?>>
                                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="hi hi-credit_card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Renegotiate');?></span></a>
                                        <ul>
                                            <li>
                                              <a href="/renegotiation/search" <?php if($this->session->userdata('selector')=='4.2.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-search sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Search');?></span></a>
                                            </li>
                                            <li>
                                              <a href="/renegotiation/negotiation" <?php if($this->session->userdata('selector')=='4.2.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-calculator sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Create');?></span></a>
                                            </li>


                                            <li <?php if(substr($this->session->userdata('selector'),0,5)=='4.2.3'){echo 'class="active"';}?>>
                                                <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-link sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Collection');?></span></a>
                                                <ul>
                                                    <li>
                                                      <a href="/collection/search" <?php if($this->session->userdata('selector')=='4.2.3.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-th-list sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Buscar Derivaciones</span></a>
                                                    </li>

                                                    <li>
                                                        <a href="/collection/create" <?php if($this->session->userdata('selector')=='4.2.3.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-chain-broken sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Derivar RENE Normal</span></a>
                                                    </li>

                                                </ul>
                                            </li>

                                            <li <?php if(substr($this->session->userdata('selector'),0,5)=='4.2.4'){echo 'class="active"';}?>>
                                                <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cogs sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Procesos</span></a>
                                                <ul>
                                                    <li>
                                                      <a href="/renegotiation/monitor" <?php if($this->session->userdata('selector')=='4.2.4.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-gear sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Monitor</span></a>
                                                    </li>

                                                    <li>
                                                        <a href="/renegotiation/schedule" <?php if($this->session->userdata('selector')=='4.2.4.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-clock-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Agendar</span></a>
                                                    </li>

                                                </ul>
                                            </li>


                                            <li>
                                                <a href="/renegotiation/documents" <?php if($this->session->userdata('selector')=='4.2.5'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-print sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Documents');?></span></a>
                                            </li>

                                        </ul>
                                    </li>

                                    <!--li <?php if(substr($this->session->userdata('selector'),0,3)=='4.3'){echo 'class="active"';}?>>
                                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-refresh sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Refinance');?></span></a>
                                        <ul>
                                            <li>
                                              <a href="/refinance/search" <?php if($this->session->userdata('selector')=='4.3.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-search sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Search');?></span></a>
                                            </li>
                                            <li>
                                              <a href="/refinance/simulate" <?php if($this->session->userdata('selector')=='4.3.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-adjust_alt sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Simulate');?></span></a>
                                            </li>
                                            <li>
                                              <a href="/refinance/create" <?php if($this->session->userdata('selector')=='4.3.3'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-circle_plus sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Create');?></span></a>
                                            </li>

                                            <li>
                                                <a href="/refinance/documents" <?php if($this->session->userdata('selector')=='4.3.4'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-print sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Documents');?></span></a>
                                            </li>
                                        </ul>

                                    </li-->

                                  </ul>
                            </li>

<?php if($this->session->userdata("id_rol") == USER_ROL_SUPER_ADMIN OR
         $this->session->userdata("id_rol") == USER_ROL_ADMIN):?>

    <li <?php if(substr($this->session->userdata('selector'),0,1)=='5'){echo 'class="active"';}?>>

    <a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-settings sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Manage');?></span></a>
    <ul>
        <li <?php if(substr($this->session->userdata('selector'),0,3)=='5.1'){echo 'class="active"';}?>>
            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cog sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Settings');?></span></a>
            <ul>
                <li <?php if(substr($this->session->userdata('selector'),0,5)=='5.1.1'){echo 'class="active"';}?>>
                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="hi hi-credit_card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Productos</span></a>
                    <ul>
                        <li><!--vi__tipoProductos-->
                            <a href="#"><i class="gi gi-coins sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Tipos</span></a>
                        </li>
                        <li><!--vi__tasaProductos-->
                            <a href="#"><i class="gi gi-compass sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Tasas</span></a>
                        </li>

                        <li><!--vi__cuotaDiferirProductos-->
                          <a href="/parameters/deferred" <?php if($this->session->userdata('selector')=='5.1.1.3'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-magnet sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Meses Diferidos</span></a>
                        </li>
                    </ul>
                </li>

                <li <?php if(substr($this->session->userdata('selector'),0,5)=='5.1.2'){echo 'class="active"';}?>>
                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-electrical_plug sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Par&aacute;metros</span></a>
                    <ul>
                        <li <?php if(substr($this->session->userdata('selector'),0,7)=='5.1.2.1'){echo 'class="active"';}?>>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="hi hi-credit_card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Solventa</span></a>
                            <ul>
                                <li>
                                    <a href="/parameters/parameters" <?php if($this->session->userdata('selector')=='5.1.2.1.1'){echo 'class="active"';}?>><i class="gi gi-wrench sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Parámetros</span></a>
                                </li>
                                <li>
                                    <a href="/parameters/exceptions" <?php if($this->session->userdata('selector')=='5.1.2.1.2'){echo 'class="active"';}?>><i class="fa fa-exchange sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Excepciones</span></a>
                                </li>
                                <li>
                                    <a href="/parameters/exclusions" <?php if($this->session->userdata('selector')=='5.1.2.1.3'){echo 'class="active"';}?>><i class="fa fa-exclamation-triangle sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Exclusiones</span></a>
                                </li>
                            </ul>
                        </li>

                        <li <?php if(substr($this->session->userdata('selector'),0,7)=='5.1.2.2'){echo 'class="active"';}?>>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="hi hi-credit_card sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Flujos Comerciales</span></a>
                            <ul>
                                <li><!--vi__feriados-->
                                  <a href="/parameters/holidays" <?php if($this->session->userdata('selector')=='5.1.2.2.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-beach_umbrella sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Feriados</span></a>
                                </li>

                                <li><!--vi__motivo_rechazo-->
                                  <a href="/parameters/rejection" <?php if($this->session->userdata('selector')=='5.1.2.2.2'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-ban sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Motivos Rechazo</span></a>
                                </li>

                            </ul>
                        </li>

                    </ul>

                </li>

            </ul>
        </li>


        <li <?php if(substr($this->session->userdata('selector'),0,3)=='5.2'){echo 'class="active"';}?>>
            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-group sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Users');?></span></a>
            <ul>
                <li><!--ta_users-->
                  <a href="/users/users" <?php if($this->session->userdata('selector')=='5.2.1.1'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Username');?></span></a>
                </li>

                 <li><!--ta_journal_log_event-->
                  <a href="/users/eventlog" <?php if($this->session->userdata('selector')=='5.2.1.3'){echo 'class="active"';}?> onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-thumb-tack sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?= $this->lang->line('Event Log');?></span></a>
                </li>

            </ul>
        </li>

    </ul>


<?php endif;?>





                    </div>
                </div>
            </div>

            <div id="main-container">
                <!-- Header -->
                <!-- In the PHP version you can set the following options from inc/config file -->
                <!--
                    Available header.navbar classes:
                    'navbar-default'            for the default light header
                    'navbar-inverse'            for an alternative dark header

                    'navbar-fixed-top'          for a top fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                    'header-fixed-top'          has to be added on #page-container only if the class 'navbar-fixed-top' was added

                    'navbar-fixed-bottom'       for a bottom fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                    'header-fixed-bottom'       has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
                -->

              <header class="navbar navbar-default"><meta http-equiv="Content-Type" content="text/html; charset=big5">
                    <!-- Left Header Navigation -->

                    <ul class="nav navbar-nav-custom">
                        <!-- Main Sidebar Toggle Button -->
                        <li>
                            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                                <i class="fa fa-bars fa-fw"></i>
                            </a>
                        </li>
                        <li style="font-weight: bold; margin-top: 0px; font-size: 16px;">
                            &nbsp;Sucursal:<strong>&nbsp;<?= $this->session->userdata('nombreoficina')?></strong>
                            | Rol: <strong><?= $this->session->userdata('nombreroles') ?></strong> | Modo: <strong><?= $this->session->userdata('attention_mode') ?></strong>
                        </li>

                        <!-- END Main Sidebar Toggle Button -->

                        <!-- Template Options -->
                        <!-- Change Options functionality can be found in js/app.js - templateOptions() -->
                        <!--li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="gi gi-settings"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-custom dropdown-options">
                                <li class="dropdown-header text-center"><?= $this->lang->line('Header Style');?></li>
                                <li>
                                    <div class="btn-group btn-group-justified btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-header-default"><?= $this->lang->line('Light');?></a>
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-header-inverse"><?= $this->lang->line('Dark');?></a>
                                    </div>
                                </li>
                                <li class="dropdown-header text-center"><?= $this->lang->line('Page Style');?></li>
                                <li>
                                    <div class="btn-group btn-group-justified btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style"><?= $this->lang->line('Default');?></a>
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style-alt"><?= $this->lang->line('Alternative');?></a>
                                    </div>
                                </li>
                            </ul>
                        </li-->
                        <!-- END Template Options -->
                    </ul>

                    <ul class="nav navbar-nav-custom pull-right">
                        <li id="processing" style="display:none;">
                            <br/>
                            <img src="<?=base_url();?>img/ajax-loader.gif" width="100%">
                        </li>
                    </ul>
                </header>
