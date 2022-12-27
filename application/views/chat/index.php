<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
<?php $this->load->view('head'); ?>  
 <div id="page-content">
                        <!-- Chat Header -->
                        <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-comments"></i>Chat<br><small>Your Social Center</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Pages</li>
                            <li><a href="">Chat</a></li>
                        </ul>
                        <!-- END Chat Header -->

                        <!-- Chat Block -->
                        <div class="block">
                            <!-- Title -->
                            <div class="block-title">
                                <div class="block-options pull-right">
                                    <div class="btn-group btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default dropdown-toggle enable-tooltip" data-toggle="dropdown" title="Status"><i class="fa fa-cog"></i></a>
                                        <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                            <li class="active">
                                                <a href="javascript:void(0)"><i class="fa fa-check pull-right"></i>Online</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="javascript:void(0)"><i class="fa fa-circle pull-right"></i>Away</a>
                                                <a href="javascript:void(0)"><i class="fa fa-circle pull-right"></i>Busy</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="javascript:void(0)"><i class="fa fa-power-off pull-right text-muted"></i>Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <h2><i class="fa fa-pencil animation-pulse"></i><span id="nombreperfil"></span> </h2>
                            </div>
                            <!-- END Title -->

                            <!-- Content -->
                            <div class="chatui-container block-content-full">
                                <!-- People -->
                                <div class="chatui-people themed-background-dark">
                                    <div class="chatui-people-scroll">
                                        <!-- Online -->
                                        <h2 class="chatui-header"><i class="fa fa-circle text-success pull-right"></i><strong>Online</strong></h2>
                                        <div class="list-group">

                                       <?php foreach ($this->session->userdata('usernamelistado') as $keylistado) {
                                     
                               ?>
                                <?php 
    if($this->session->userdata('usuariosusername')[$keylistado->unido]["email"] == $this->session->userdata('email')){
                $nombreperfil = $this->session->userdata('usuariosusername')[$keylistado->creado]['name']." ".$this->session->userdata('usuariosusername')[$keylistado->creado]['last_name'];
                $avatar = $this->session->userdata('usuariosusername')[$keylistado->creado]['avatar'];
                $avatarid = $this->session->userdata('usuariosusername')[$keylistado->creado]['id_user'];
        }else{
             $nombreperfil = $this->session->userdata('usuariosusername')[$keylistado->unido]['name']." ".$this->session->userdata('usuariosusername')[$keylistado->unido]['last_name'];
             $avatar = $this->session->userdata('usuariosusername')[$keylistado->unido]['avatar'];
             $avatarid = $this->session->userdata('usuariosusername')[$keylistado->unido]['id_user'];
        }
                                    ?>
            <a href="javascript:void(0)" class="list-group-item  chatuserlistado" data-id="<?= $keylistado->number_sala ?>" data-nombre="<?=$nombreperfil?>">
                                                <!--<span class="badge">2</span>-->
                                                <img src="img/placeholders/avatars/avatar6.jpg" alt="Avatar" class="img-circle">
                            <h5 class="list-group-item-heading"><?php echo $nombreperfil ?></h5>
                                            </a>
                                          
                                          
                                      
                                    <?php  } ?>
                                      </div>
                                        <!-- END Online -->

                                        <!-- Away -->
                                       <!-- <hr>
                                        <h2 class="chatui-header"><i class="fa fa-circle text-warning pull-right"></i><strong>Away</strong></h2>
                                        <div class="list-group">
                                            <a href="javascript:void(0)" class="list-group-item">
                                                <img src="img/placeholders/avatars/avatar4.jpg" alt="Avatar" class="img-circle">
                                                <h5 class="list-group-item-heading"><strong>John</strong> West</h5>
                                            </a>
                                            <a href="javascript:void(0)" class="list-group-item">
                                                <img src="img/placeholders/avatars/avatar16.jpg" alt="Avatar" class="img-circle">
                                                <h5 class="list-group-item-heading"><strong>Matteo</strong> Galli</h5>
                                            </a>
                                            <a href="javascript:void(0)" class="list-group-item">
                                                <span class="badge">6</span>
                                                <img src="img/placeholders/avatars/avatar8.jpg" alt="Avatar" class="img-circle">
                                                <h5 class="list-group-item-heading"><strong>Dimitri</strong> Robin</h5>
                                            </a>
                                        </div>-->
                                        <!-- END Away -->

                                        <!-- Busy -->
                                        <!--<hr>
                                        <h2 class="chatui-header"><i class="fa fa-circle text-danger pull-right"></i><strong>Busy</strong></h2>
                                        <div class="list-group">
                                            <a href="javascript:void(0)" class="list-group-item">
                                                <img src="img/placeholders/avatars/avatar5.jpg" alt="Avatar" class="img-circle">
                                                <h5 class="list-group-item-heading"><strong>Louis</strong> Peters</h5>
                                            </a>
                                            <a href="javascript:void(0)" class="list-group-item">
                                                <span class="badge">4</span>
                                                <img src="img/placeholders/avatars/avatar12.jpg" alt="Avatar" class="img-circle">
                                                <h5 class="list-group-item-heading"><strong>Julia</strong> Warren</h5>
                                            </a>
                                        </div>-->
                                        <!-- END Busy -->
                                    </div>
                                </div>
                                <!-- END People -->

                                <!-- Talk -->
                                <div class="chatui-talk">
                                    <div class="chatui-talk-scroll">
                                        <ul>
                                            <li class="text-center"><small>yesterday, 23:10</small></li>
                                            <li class="chatui-talk-msg">
                                                <img src="img/placeholders/avatars/avatar6.jpg" alt="Avatar" class="img-circle chatui-talk-msg-avatar"> Hey admin?
                                            </li>
                                            <li class="chatui-talk-msg">
                                                <img src="img/placeholders/avatars/avatar6.jpg" alt="Avatar" class="img-circle chatui-talk-msg-avatar"> How are you?
                                            </li>
                                            <li class="text-center"><small>just now</small></li>
                                            <li class="chatui-talk-msg chatui-talk-msg-highlight themed-border">
                                                <img src="img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle chatui-talk-msg-avatar"> I'm fine, thanks!
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- END Talk -->

                                <!-- Input -->
                                <div class="chatui-input">
                                    <form action="page_ready_chat.html" method="post" class="form-horizontal form-control-borderless remove-margin" id="accionesmensaje">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-angle-right"></i></span>
                                            <input type="text" id="chatui-message" name="chatui-message" class="form-control input-lg" placeholder="Type a message and hit enter..">

                                        </div>
                                          
                                    </form>
                                </div>
                                <!-- END Input -->
                            </div>
                            <!-- END Content -->
                        </div>
                        <!-- END Chat Block -->
                        <input type="hidden" name="idsalanew" id="idsalanew" value="">
                    </div>

<?php $this->load->view('footer'); ?>
<script type="text/javascript" src="<?= base_url();?>js/pages/readyChat.js"></script>
<script>
$(function(){ 


ReadyChat.init(); 


var arreglo2 = "";
 var chatHeight          = 600; // Default chat container height in large screens
    var chatHeightSmall     = 300; // Default chat components (talk & people) height in small screens

    /* Cache some often used variables */
    var chatCon             = $('.chatui-container');
    var chatTalk            = $('.chatui-talk ul li');
    var chatTalkScroll      = $('.chatui-talk-scroll');

    var chatPeople          = $('.chatui-people');
    var chatPeopleScroll    = $('.chatui-people-scroll');

    var chatInput           = $('.chatui-input');
    var chatMsg             = '';
  chatTalk.remove();
  const tokenProvider2 = new Chatkit.TokenProvider({
                    url: "<?= base_url();?>Welcome/autenticar"
            });



            const chatManager2 = new Chatkit.ChatManager({
              instanceLocator: "<?php echo $this->config->item('instancia') ?>",
              userId: "<?= $this->session->userdata('username') ?>",
              tokenProvider: tokenProvider2
            });




$(".chatuserlistado").click(function(){
    console.log("click");
     $('.chatui-talk ul li').remove();

     if($("#idsalanew").val() == ""){

     }else{
      var someRoomID =  $("#idsalanew").val();
      console.log(arreglo2);
         arreglo2.roomSubscriptions[someRoomID].cancel();
    }

     $("#idsalanew").val('');
            var salanumber = $(this).attr("data-id");
            var nombreperfiles = $(this).attr("data-nombre");

   
   $("#nombreperfil").html(nombreperfiles);
            $("#idsalanew").val(salanumber);
           var usernameactual = "<?= $this->session->userdata('username') ?>";

            chatManager2
              .connect()
              .then(currentUser=> {
                console.log('conectado', currentUser);
                arreglo2 = currentUser;
                   currentUser.subscribeToRoomMultipart({
                          roomId: salanumber,
                          hooks: {
                            onMessage: message => {
                              console.log("received message", message)

                              var date = new Date(message.createdAt);
                            date1 = date.toLocaleString(undefined, {
                                      day: 'numeric',
                                      month: 'short',
                                      year: 'numeric',
                                     
                              });
                            console.log(`${message.parts[0].payload.content}`);
                          
                        if(`${message.senderId}` === usernameactual){
                           $('.chatui-talk')
                            .find('ul')
                            .append('<li class="chatui-talk-msg">'
                                    + '<img src="img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle chatui-talk-msg-avatar">'
                                    + $('<div />').text(`${message.parts[0].payload.content}`).html()
                                    + '</li>');
                        }else{
                            $('.chatui-talk')
                            .find('ul')
                            .append('<li class="chatui-talk-msg chatui-talk-msg-highlight themed-border animation-expandUp">'
                                    + '<img src="img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle chatui-talk-msg-avatar">'
                                    + $('<div />').text(`${message.parts[0].payload.content}`).html()
                                    + '</li>'); 
                        }
                            

                            }
                          }
                        
                        });

 

              })
              .catch(error => {
                console.log('error', error);
             });




            return false;
        });


$("#accionesmensaje").submit(function(e){
                    // Get text from message input
                   
                    chatMsg = $('#chatui-message').val();

                    // If the user typed a message
                    if (chatMsg) {
                        // Add it to the message list
                      /*  $('.chatui-talk').find('ul')
                            .append('<li class="chatui-talk-msg chatui-talk-msg-highlight themed-border animation-expandUp">'
                                    + '<img src="img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="img-circle chatui-talk-msg-avatar">'
                                    + $('<div />').text(chatMsg).html()
                                    + '</li>');*/

                        // Scroll the message list to the bottom
                        chatTalkScroll
                            .animate({ scrollTop: chatTalkScroll[0].scrollHeight },150);

                        // Reset the message input
                       
            chatManager2
              .connect()
              .then(currentUser=> {
                console.log('conectado', currentUser);
            var salanumero =  $("#idsalanew").val(); 
            console.log("sala numero "+salanumero);               
            const input = document.getElementById("chatui-message");
            currentUser.sendSimpleMessage({
              text: input.value,
              roomId: salanumero
            });
            input.value = "";
          


              })
              .catch(error => {
                console.log('error', error);
             });
        
      


                    }

                    // Don't submit the message form
                    e.preventDefault();
                });


});</script>
  </body>
</html>
          