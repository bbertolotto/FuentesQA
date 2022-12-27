<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>  


<div id="page-content" style="min-height: 1733px;">
                        <!-- Inbox Header -->
                        <div class="content-header">
                            <div class="header-section">
                                <h1><i class="gi gi-envelope"></i> Inbox<br><small>Your Message Center</small></h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Pages</li>
                            <li>Message Center</li>
                            <li><a href="">Inbox</a></li>
                        </ul>
                        <!-- END Inbox Header -->

                        <!-- Inbox Content -->
                        <div class="row">
                            <!-- Inbox Menu -->
                            <div class="col-sm-4 col-lg-3">
                                <!-- Menu Block -->
                                <div class="block full">
                                    <!-- Menu Title -->
                                    <div class="block-title clearfix">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="" data-original-title="Refresh"><i class="fa fa-refresh"></i></a>
                                        </div>
                                        <div class="block-options pull-left">
                                            <a href="#" class="btn btn-alt btn-sm btn-default compose"><i class="fa fa-pencil"></i> Compose Message</a>
                                        </div>
                                    </div>
                                    <!-- END Menu Title -->

                                    <!-- Menu Content -->
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="active">
                                            <a href="#" data-id="INBOX" class="typedata">
                                                <span class="badge pull-right cantidadinbox">0</span>
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Inbox</strong>
                                            </a>
                                        </li>
                                       
                                        <li>
                                            <a href="#" data-id="INBOX.Sent" class="typedata">
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Sent</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-id="INBOX.Drafts" class="typedata">
                                                <span class="badge pull-right">2</span>
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Drafts</strong>
                                            </a>
                                        </li>
                                        
                                       
                                        <li>
                                            <a href="#" data-id="INBOX.Trash" class="typedata">
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Trash</strong>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- END Menu Content -->
                                </div>
                                <!-- END Menu Block -->

                                <!-- Tags Block -->
                                <div class="block full">
                                    <!-- Tags Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="" data-original-title="Add Tag"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <h2> <i class="fa fa-tags"></i> User <strong>Tags</strong></h2>
                                    </div>
                                    <!-- END Tags Title -->

                                    <!-- Tags Content -->
                                    <ul class="nav nav-pills nav-stacked">
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">1680</span>
                                                <i class="fa fa-tag fa-fw text-success"></i> <strong>Work</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">350</span>
                                                <i class="fa fa-tag fa-fw text-warning"></i> <strong>Friends</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">651</span>
                                                <i class="fa fa-tag fa-fw text-danger"></i> <strong>Projects</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">156</span>
                                                <i class="fa fa-tag fa-fw text-info"></i> <strong>For Later</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">296</span>
                                                <i class="fa fa-tag fa-fw text-muted"></i> <strong>Sites</strong>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- END Tags Content -->
                                </div>
                                <!-- END Tags Block -->

                                <!-- Account Stats Block -->
                                <div class="block">
                                    <!-- Account Status Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <span class="label label-warning">70%</span>
                                        </div>
                                        <h2><i class="fa fa-user"></i> Account <strong>Status</strong></h2>
                                    </div>
                                    <!-- END Account Status Title -->

                                    <!-- Account Stats Content -->
                                    <div class="row block-section text-center">
                                        <div class="col-xs-12">
                                            <div class="pie-chart block-section easyPieChart" data-percent="70" data-line-width="2" data-bar-color="#e67e22" data-track-color="#ffffff" style="width: 80px; height: 80px; line-height: 80px;">
                                                <img src="img/placeholders/avatars/avatar11.jpg" alt="avatar" class="pie-avatar img-circle">
                                            <canvas width="80" height="80"></canvas></div>
                                        </div>
                                    </div>
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            <tr>
                                                <td class="text-right" style="width: 50%;"><strong>Active Plan</strong></td>
                                                <td>Business <a href="page_ready_pricing_tables.html" data-toggle="tooltip" title="" data-original-title="Upgrade to VIP"><i class="fa fa-arrow-up"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Plan Valid</strong></td>
                                                <td><span class="text-danger"><strong>5</strong> days left</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Storage Usage</strong></td>
                                                <td class="text-warning"><strong>21</strong> of <strong>30</strong> GB</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Account Status Content -->
                                </div>
                                <!-- END Account Status Block -->

                                <!-- Online Users Block -->
                                <div class="block">
                                    <!-- Online Users Title -->
                                    <div class="block-title">
                                        <h2><i class="fa fa-circle text-success"></i> Online <strong>Users</strong></h2>
                                    </div>
                                    <!-- END Online Users Title -->

                                    <!-- Online Users Content -->
                                    <div class="row text-center">
                                        <div class="col-xs-6 block-section">
                                            <a href="page_ready_user_profile.html">
                                                <img src="img/placeholders/avatars/avatar3.jpg" alt="avatar" class="img-circle" data-toggle="tooltip" title="" data-original-title="Username">
                                            </a>
                                        </div>
                                        <div class="col-xs-6 block-section">
                                            <a href="page_ready_user_profile.html">
                                                <img src="img/placeholders/avatars/avatar15.jpg" alt="avatar" class="img-circle" data-toggle="tooltip" title="" data-original-title="Username">
                                            </a>
                                        </div>
                                        <div class="col-xs-6 block-section">
                                            <a href="page_ready_user_profile.html">
                                                <img src="img/placeholders/avatars/avatar3.jpg" alt="avatar" class="img-circle" data-toggle="tooltip" title="" data-original-title="Username">
                                            </a>
                                        </div>
                                        <div class="col-xs-6 block-section">
                                            <a href="page_ready_user_profile.html">
                                                <img src="img/placeholders/avatars/avatar14.jpg" alt="avatar" class="img-circle" data-toggle="tooltip" title="" data-original-title="Username">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END Online Users Content -->
                                </div>
                                <!-- END Online Users Block -->
                            </div>
                            <!-- END Inbox Menu -->

                            <!-- Messages List -->
                            <div class="col-sm-8 col-lg-9 listacorreo">
                                <!-- Messages List Block -->
                                <div class="block">
                                    <!-- Messages List Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="" data-original-title="Settings"><i class="fa fa-cog"></i></a>
                                        </div>
                                        <h2 class="tituloinbox">Inbox</h2>
                                    </div>
                                    <!-- END Messages List Title -->

                                    <!-- Messages List Content -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" id="checkbox-all" name="checkbox-all">
                                                    </td>
                                                    <td colspan="3">
                                                        <div class="btn-group btn-group-sm">
                                                            <!--<a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="" data-original-title="Archive Selected"><i class="fa fa-briefcase"></i></a>-->
                                                            <!--<a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="" data-original-title="Star Selected"><i class="fa fa-star"></i></a>-->
                                                            <a href="javascript:void(0)" class="btn btn-default deletemensaje" data-toggle="tooltip" title="" data-original-title="Delete Selected"><i class="fa fa-times"></i></a>
                                                        </div>
                                                    </td>
                                                    <!--<td class="text-right" colspan="3">
                                                        <strong>1-30</strong> from <strong>5250</strong>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i></a>
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-default"><i class="fa fa-angle-right"></i></a>
                                                        </div>
                                                    </td>-->
                                                </tr>
                                            </thead>
                                            <tbody id="inbox">
                                                <!-- Use the first row as a prototype for your column widths -->
                                                <tr>
                                                    <td class="text-center" style="width: 30px;">
                                                        <input type="checkbox" id="checkbox1" name="checkbox1">
                                                    </td>
                                                    <td class="text-center" style="width: 30px;">
                                                        <a href="javascript:void(0)" class="text-muted msg-fav-btn"><i class="fa fa-star-o"></i></a>
                                                    </td>
                                                    <td class="text-center" style="width: 30px;">
                                                        <a href="javascript:void(0)" class="text-success msg-read-btn"><i class="fa fa-circle"></i></a>
                                                    </td>
                                                    <td style="width: 20%;">Debra Stanley</td>
                                                    <td>
                                                        <a href="page_ready_inbox_message.html"><strong>New Follower</strong></a>
                                                        <span class="text-muted">Hey, just wanted to let you know..</span>
                                                    </td>
                                                    <td class="text-center" style="width: 30px;">
                                                        <i class="fa fa-paperclip"></i>
                                                    </td>
                                                    <td class="text-right" style="width: 90px;"><em>just now</em></td>
                                                </tr>
                                               
                                               
                                              
                                             
                                              
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- END Messages List Content -->
                                </div>
                                <!-- END Messages List Block -->
                            </div>

                            <div class="col-sm-8 col-lg-9 composermensaje">
                                <!-- Compose Message Block -->
                                <div class="block">
                                    <!-- Compose Message Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" id="cc-input-btn" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="" data-original-title="Show Cc field" style="display: none;"><i class="fa fa-plus"></i> Cc</a>
                                            <a href="javascript:void(0)" id="bcc-input-btn" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="" data-original-title="Show Bcc field" style="display: none;"><i class="fa fa-plus"></i> Bcc</a>
                                        </div>
                                        <h2>Compose <strong>Message</strong></h2>
                                    </div>
                                    <!-- END Compose Message Title -->

                                    <!-- Compose Message Content -->
                                    <form  method="post" class="form-horizontal form-bordered" id="enviaemail">
                                        <div class="form-group">
                                            <label class="col-md-3 col-lg-2 control-label" for="compose-to">To</label>
                                            <div class="col-md-9 col-lg-10">
                                                <input type="email" id="compose-to" name="compose-to" class="form-control form-control-borderless" placeholder="Where to?">
                                            </div>
                                        </div>
                                       
                                       
                                        <div class="form-group">
                                            <label class="col-md-3 col-lg-2 control-label" for="compose-subject">Subject</label>
                                            <div class="col-md-9 col-lg-10">
                                                <input type="text" id="compose-subject" name="compose-subject" class="form-control form-control-borderless" placeholder="Your subject..">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-lg-2 control-label" for="compose-message">Message</label>
                                            <div class="col-md-9 col-lg-10">
                                                <textarea id="compose-message" name="compose-message" rows="20" class="form-control" placeholder="Your message.."></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3 col-lg-10 col-lg-offset-2">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-share"></i> Send</button>
                                                <!--<button type="button" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i> Save Draft</button>-->
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Compose Message Content -->
                                </div>
                                <!-- END Compose Message Block -->
                            </div>


                            <div class="col-sm-8 col-lg-9 correolectura">
                                <!-- View Message Block -->
                                <div class="block full">
                                    <!-- View Message Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="" data-original-title="Print"><i class="fa fa-print"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-times"></i></a>
                                        </div>
                                        <h2><strong>The project is live!</strong> <small><span class="label label-success">Work</span></small></h2>
                                    </div>
                                    <!-- END View Message Title -->

                                    <!-- Message Meta -->
                                    <table class="table table-borderless table-vcenter remove-margin">
                                        <tbody>
                                            <tr>
                                                <td class="text-center" style="width: 80px;">
                                                    <a href="page_ready_user_profile.html" class="pull-left">
                                                        <img src="img/placeholders/avatars/avatar9.jpg" alt="Avatar" class="img-circle">
                                                    </a>
                                                </td>
                                                <td class="hidden-xs">
                                                    <a href="page_ready_user_profile.html"><strong>Explorer</strong></a> to <a href="page_ready_user_profile.html"><strong>Me</strong></a>
                                                </td>
                                                <td class="text-right fecha"><strong>June 5, 2014 - 09:10 am</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <!-- END Message Meta -->

                                    <!-- Message Body -->
                                    <div id="lectura">
                                    </div>
                                    <hr>
                                    <!-- END Message Body -->

                                    <!-- Attachments Row -->
                                    <div class="row block-section attachments">
                                       <!-- <div class="col-xs-4 col-sm-2 text-center">
                                            <a href="img/placeholders/photos/photo1.jpg" data-toggle="lightbox-image">
                                                <img src="img/placeholders/photos/photo1.jpg" alt="photo" class="img-responsive push-bit">
                                            </a>
                                            <span class="text-muted">IMG0001.JPG</span>
                                        </div>
                                        -->
                                       
                                    </div>
                                    <!-- END Attachments Row -->

                                    <!-- Quick Reply Form -->
                                    <form action="page_ready_inbox_message.html" method="post" onsubmit="return false;">
                                        <textarea id="message-quick-reply" name="message-quick-reply" rows="5" class="form-control push-bit" placeholder="Your message.."></textarea>
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-share"></i> Quick Reply</button>
                                    </form>
                                    <!-- END Quick Reply Form -->
                                </div>
                                <!-- END View Message Block -->
                            </div>
                            <!-- END Messages List -->
                        </div>
                        <!-- END Inbox Content -->
                    </div>

<?php $this->load->view('footer'); ?>


<!-- Javascript exclusivos para esta página -->
<script src="<?= base_url();?>js/pages/formsValidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script>$(function(){



$('.deletemensaje').click(function(event) {   
    
        // Iterate each checkbox
        $('.checkbox1').each(function() {
           if( $(this).is(':checked') ){
                    // Hacer algo si el checkbox ha sido seleccionado
                   
                      var bandejaselect = $(this).data('id');
                      var bandejaasignada = $(this).data('correo');
                      console.log(bandejaselect);
                       $(this).parents(1).eq(1).remove();
        $.ajax({
              url: "<?= base_url() ?>correos/mover",
              type: 'post',
              dataType: 'json',
              data: { uid : bandejaselect, inbox : bandejaasignada },
                beforeSend(){
                  
                },
                success: function(data) {
                             
                        console.log(data);
                }
         });
                       
                }                      
        });

       

      //      $("#inbox").hide().fadeIn('fast');

    
});

$('#checkbox-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $('.checkbox1').each(function() {
            this.checked = true;                        
        });
    } else {
        $('.checkbox1').each(function() {
            this.checked = false;                       
        });
    }
});

$('#checkbox-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $('.checkbox1').each(function() {
            this.checked = true;                        
        });
    } else {
        $('.checkbox1').each(function() {
            this.checked = false;                       
        });
    }
});

    $( "#enviaemail" ).submit(function( event ) {
      //console.log("hola");
        //M.AutoInit();
        if( $("#compose-to").val() == ""){
                        Swal.fire({
                                icon: 'error',
                                title: 'Mensaje',
                                text: 'Coloque destinatario',
                        })     
                return false;
        }else if($("#compose-subject").val() == ""){
             Swal.fire({
                                icon: 'error',
                                title: 'Mensaje',
                                text: 'Escriba el asunto del mensaje',
                        })     
                return false;

        }else if($("#compose-message").val() == ""){

             Swal.fire({
                                icon: 'error',
                                title: 'Mensaje',
                                text: 'Escriba en el cuerpo del mensaje',
                        })     
                return false;
            
        }
      event.preventDefault();
      var actionurl = event.currentTarget.action;
         $.ajax({
              url: "<?= base_url() ?>correos/emailsend",
              type: 'post',
              dataType: 'json',
              data: $(this).serialize(),
                beforeSend(){
                  
                },
                success: function(data) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Mensaje',
                                text: 'Mensaje enviado',
                        })      
                        $("#compose-to").val("");         
                        $("#compose-subject").val("");
                        $("#compose-message").val("");
                }
         });
        //
    });

    $('.composermensaje').hide("fast");
    $('.correolectura').hide("fast");
    

     $('.nav li').click(function(){
        $('.nav li').removeClass('active');        
        $(this).addClass('active');
    });    
    var json;
    
//  $.LoadingOverlay("show");

    $.ajax({
        type: "POST",
        url: "<?= base_url() ?>correos/inbox",
        data: {
            inbox: ""
        },
        dataType: 'json'
    }).done(function(d) {
        if(d.status === "success"){
            var tbody = "";
            json = d.data;
            $.each(json, function(i, a) {
                tbody += '<tr><td class="text-center" style="width: 30px;"><input type="checkbox" class="checkbox1" name="checkbox1" data-id="' + a.uid + '" data-correo="INBOX"></td>';
                tbody += '<td class="text-center" style="width: 30px;"><a href="javascript:void(0)" class="text-muted msg-fav-btn"><i class="fa fa-star-o"></i></a></td>';
                tbody +=  '<td class="text-center" style="width: 30px;"><a href="javascript:void(0)" class="text-success msg-read-btn"><i class="fa fa-circle"></i></a></td>';
                tbody += ' <td style="width: 20%;">' + (a.from.name === "" ? "[empty]" : a.from.name) + '</td>';

                tbody += ' <td><a href="#" class="leer" data-id="' + i + '"><strong>'+ a.subject.substring(0, 20)+'</strong></a></td>';

                tbody += '  <td class="text-center" style="width: 30px;"><i class="fa fa-paperclip"></i></td><td class="text-right" style="width: 90px;"><em>' + a.date + '</em></td></tr>';

             /*   tbody += '<td>' + (a.from.name === "" ? "[empty]" : a.from.name) + '</td>';
                tbody += '<td><a href="mailto:' + a.from.address + '?subject=Re:' + a.subject + '">' + a.from.address + '</a></td>';
                tbody += '<td>' + a.date + '</td></tr>';*/
            });
            $('#inbox').html(tbody);
         //   $('#myTable').DataTable();
            //$.LoadingOverlay("hide");
        }else{
            alert(d.message);
        }
    });

$('body').on('click', '.compose', function () {
      $('.composermensaje').show("slow");
    $('.listacorreo').hide("fast");
         $('.correolectura').hide("fast");


});

$('body').on('click', '.typedata', function () {

    $('.listacorreo').show("slow");
    $('.composermensaje').hide("fast");
     $('.correolectura').hide("fast");
        //$.LoadingOverlay("show");
        var bandeja = $(this).data('id');
        console.log(bandeja);
        if(bandeja == "INBOX"){
            $(".tituloinbox").html("Inbox");
        }else if(bandeja == "INBOX.Sent"){
            $(".tituloinbox").html("Sents");
        }else if(bandeja == "INBOX.Drafts"){
            $(".tituloinbox").html("Drafts");
        }else if(bandeja == "INBOX.Trash"){
            $(".tituloinbox").html("Trash");
        }

         $.ajax({
        type: "POST",
        url: "<?= base_url() ?>correos/inbox",
        data: {
            inbox: bandeja
        },
        dataType: 'json'
    }).done(function(d) {
        if(d.status === "success"){
            var tbody = "";
            json = d.data;
            
            $.each(json, function(i, a) {
                tbody += '<tr><td class="text-center" style="width: 30px;"><input type="checkbox" class="checkbox1" name="checkbox1" data-id="' + a.uid + '" data-correo="'+bandeja+'"></td>';
                tbody += '<td class="text-center" style="width: 30px;"><a href="javascript:void(0)" class="text-muted msg-fav-btn"><i class="fa fa-star-o"></i></a></td>';
                tbody +=  '<td class="text-center" style="width: 30px;"><a href="javascript:void(0)" class="text-success msg-read-btn"><i class="fa fa-circle"></i></a></td>';

                if(bandeja == "INBOX.Sent"){
 tbody += ' <td style="width: 20%;">' + (a.to.address === "" ? "[empty]" : a.to.address) + '</td>';
                }else{
                tbody += ' <td style="width: 20%;">' + (a.from.name === "" ? "[empty]" : a.from.name) + '</td>';
                }
                tbody += ' <td><a href="#" class="leer" data-id="' + i + '"><strong>'+ a.subject.substring(0, 20)+'</strong></a></td>';

                tbody += '  <td class="text-center" style="width: 30px;"><i class="fa fa-paperclip"></i></td><td class="text-right" style="width: 90px;"><em>' + a.date + '</em></td></tr>';

             /*   tbody += '<td>' + (a.from.name === "" ? "[empty]" : a.from.name) + '</td>';
                tbody += '<td><a href="mailto:' + a.from.address + '?subject=Re:' + a.subject + '">' + a.from.address + '</a></td>';
                tbody += '<td>' + a.date + '</td></tr>';*/
            });
            $('#inbox').html(tbody);
         //   $('#myTable').DataTable();
            //$.LoadingOverlay("hide");
        }else{
            alert(d.message);
        }
    });



       
 });    

 $('body').on('click', '.leer', function () {
        var id = $(this).data('id'); 

        console.log(id);
         var message = json[id].message;
           $("#lectura").html(message);
            $(".fecha").html(json[id].date);

        var attachments = json[id].attachments;
        var attachment = '';
        if(attachments.length > 0){
            $.each(attachments, function(i, a) {
                console.log(a);
                var file = json[id].uid + ',' + a.part + ',' + a.file + ',' + a.encoding;
               /* attachment += '<br><a href="#" class="file" data-file="' + file + '">' + a.file + '</a>';*/

                attachment += '<div class="col-xs-4 col-sm-2 text-center"><a href="#" data-toggle="lightbox-image" class="file" data-file="'+file+'"">View</a><span class="text-muted">'+a.file+'</span></div>';
            });
            $(".attachments").html(attachment);
        }

      $('.composermensaje').hide("slow");
      $('.listacorreo').hide("slow");
          $('.correolectura').show("fast");


});


 FormsValidation.init(); 
$( "#form-validation" ).submit(function( event ) {
  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})
  event.preventDefault();
});

});</script>
</body>
</html>
          