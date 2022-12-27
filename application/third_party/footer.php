<footer class="clearfix">
  <div class="pull-right">
      Hecho a mano por TeknoData Systems - Santiago - Chile
  </div>
  <div class="pull-left">
      <span id="year-copy"></span> &copy; <a href="https://www.teknodata.cl" target="_blank">TeknodataSystems</a>
  </div>
</footer>
<!-- END Footer -->
</div>
<!-- END Page Container -->
</div>
<!-- END Page Wrapper -->
</div>

        <!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
        <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

        <!-- User Settings, modal which opens from Settings link (found in top right user menu) and the Cog link (found in sidebar user info) -->
        <div id="modal-user-settings" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> <?= $this->lang->line('settings');?></h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <form action="#"  id="perfiles"  method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <fieldset>
                                <legend><?= $this->lang->line('Vital Info');?></legend>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?= $this->lang->line('Username');?></label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"><?= $this->session->userdata('username') ?></p>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-email"><?= $this->lang->line('Email');?></label>
                                    <div class="col-md-8">
                                        <input type="email" id="user-settings-email" name="user-settings-email" class="form-control" value="<?= $this->session->userdata('email_system') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-notifications"><?= $this->lang->line('Email Notifications');?></label>
                                    <div class="col-md-8">
                                        <label class="switch switch-primary">
                                            <input type="checkbox" id="user-settings-notifications" name="user-settings-notifications" value="<?= $this->session->userdata('email_notifications') ?>" >
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend><?= $this->lang->line('Password Update');?></legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-password"><?= $this->lang->line('New Password');?></label>
                                    <div class="col-md-8">
                                        <input type="password" id="user-settings-password" name="user-settings-password" class="form-control" placeholder="<?= $this->lang->line('Please choose a complex one..');?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-repassword"><?= $this->lang->line('Confirm New Password');?></label>
                                    <div class="col-md-8">
                                        <input type="password" id="user-settings-repassword" name="user-settings-repassword2" class="form-control" placeholder="<?= $this->lang->line('..and confirm it!');?>">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?= $this->lang->line('Close');?></button>
                                    <button type="submit" class="btn btn-sm btn-primary"><?= $this->lang->line('Save Changes');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <!-- END User Settings -->

        <!-- Remember to include excanvas for IE8 chart support -->
        <!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

<!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->

<script language="javascript">
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//esta linea es necesaria para chrome
window.onhashchange=function(){window.location.hash="no-back-button";}
</script>

<script src="<?=base_url();?>js/vendor/jquery-1.12.0.min.js"></script>
<script src="<?=base_url();?>js/vendor/bootstrap.min.js"></script>
<script src="<?=base_url();?>js/plugins.js"></script>
<script src="<?=base_url();?>js/app.js"></script>

<!-- Google Maps API + Gmaps Plugin, must be loaded in the page you would like to use maps -->
<!-- Load and execute javascript code used only in this page -->
<script src="<?=base_url();?>js/chatkit.js"></script>
<!-- Compiled and minified JavaScript -->
<script src="<?=base_url();?>js/ajax/toastr.min.js"></script>

<script>

$(function(){
          /*  Index.init(); */
          var idleTime = 0;
          //Increment the idle time counter every minute.
          var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
          //Zero the idle timer on mouse movement.
          $(this).mousemove(function (e) {
            idleTime = 0;
          });
          $(this).keypress(function (e) {
            idleTime = 0;
          });

          function timerIncrement() {
              idleTime = idleTime + 1;
              console.log(idleTime);
              if (idleTime > 1) { // 20 minutes
             //     window.location.reload();
                window.location.replace("<?php echo base_url(); ?>dashboard/lock");
              }
          }

$('#modal-user-settings').on('show.bs.modal', function (event) {
     $.ajax({
            url: "<?php echo base_url(); ?>dashboard/perfilgeneral",
            type: 'post',
            dataType: 'json',
            data: {id : "<?= $this->session->userdata('id') ?>" },
            success: function(json) {
                  $("#user-settings-email").val(json.email);
                  if(json.notificacion == 1){
                    $( "#user-settings-notifications" ).prop({
                      checked: true
                    });
                  }else{
                    $( "#user-settings-notifications" ).prop({
                      checked: false
                    });
                  }
                 }
         });
})

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "400",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut",
  "target": "body"
}
        var chatUsers       = $('.chat-users');
        var chatTalk        = $('.chat-talk');
        var chatMessages    = $('.chat-talk-messages');
        var chatInput       = $('#sidebar-chat-message');
        var chatMsg         = '';

        $('.chat-talk-messages').slimScroll({ height: 210, color: '#fff', size: '3px', position: 'left', touchScrollStep: 100 });

         const tokenProvider = new Chatkit.TokenProvider({
                    url: "<?= base_url();?>Welcome/autenticar"
            });



            const chatManager = new Chatkit.ChatManager({
              instanceLocator: "<?php echo $this->config->item('instancia') ?>",
              userId: "<?= $this->session->userdata('username') ?>",
              tokenProvider: tokenProvider
            });

var arreglo = "";
$(".chat-users .chatusuario").click(function(){
    console.log("click");
     chatMessages.empty();
     $("#idsala").val('');
            var salanumber = $(this).attr("data-id");
             var usuario = $(this).attr("data-unido");
             $(".nombre").html(usuario);
            $("#idsala").val(salanumber);
           var usernameactual = "<?= $this->session->userdata('username') ?>";

            chatManager
              .connect()
              .then(currentUser=> {
                console.log('conectado', currentUser);
                arreglo = currentUser;
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
                            console.log(date1);
                             chatMessages.append('<li class="text-center"><small>'+date1+'</small></li>');
                            if(`${message.senderId}` === usernameactual){
                              chatMessages.append('<li class="chat-talk-msg chat-talk-msg-highlight themed-border animation-slideLeft">' + $('<div />').text(`${message.parts[0].payload.content}`).html() + '</li>');
                            }else{
                                chatMessages.append('<li class="chat-talk-msg animation-slideRight">' + $('<div />').text(`${message.parts[0].payload.content}`).html() + '</li>');
                            }
                               chatMessages.animate({ scrollTop: chatMessages[0].scrollHeight}, 500);


                            }
                          }

                        });



              })
              .catch(error => {
                console.log('error', error);
             });

           chatUsers.slideUp();
            chatTalk.slideDown();
            chatInput.focus();

            return false;
        });
          /*  const form = document.getElementById("sidebar-chat-form");
          form.addEventListener("submit", e => {

            var salanumero =  $("#idsala").val();
            console.log("sala numero "+salanumero);
            e.preventDefault();
            const input = document.getElementById("sidebar-chat-message");
            currentUser.sendMessage({
              text: input.value,
              roomId: salanumero
            });
            input.value = "";
          });*/

$('#sidebar-chat-form').submit(function(e){
            // Get text from message input
            chatMsg = chatInput.val();

            // If the user typed a message
            if (chatMsg) {
                chatManager
              .connect()
              .then(currentUser=> {
                console.log('conectado', currentUser);
            var salanumero =  $("#idsala").val();
            console.log("sala numero "+salanumero);
            const input = document.getElementById("sidebar-chat-message");
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

  $('#chat-talk-close-btn').click(function(){
       var someRoomID =  $("#idsala").val();

       console.log(arreglo);
         arreglo.roomSubscriptions[someRoomID].cancel();
         /* chatManager
              .connect()
              .then(currentUser=> {
                console.log('conectado', currentUser);



                currentUser.subscribeToRoomMultipart({
                          roomId: someRoomID,


                        });

                    currentUser.roomSubscriptions[someRoomID].cancel();

              })
              .catch(error => {
                console.log('error', error);
             });*/


            chatTalk.slideUp();
            chatUsers.slideDown();

            return false;
        });

$( "#perfiles" ).submit(function( event ) {
      event.preventDefault();
      var actionurl = event.currentTarget.action;
      var formData = new FormData(document.getElementById("perfiles"));

         $.ajax({
              url: "<?php echo base_url(); ?>welcome/perfil",
              type: 'post',
              dataType: 'json',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
              if(data["error"]){
                  toastr.info(data["mensaje"])
              }else{
                   toastr.info(data["mensaje"])
              }
           }
         });


    $("#modal-user-settings").modal('hide');//ocultamos el modal
    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
        //
    });
        });
</script>


<script>
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
$.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
$("#fecha").datepicker();
});
</script>
