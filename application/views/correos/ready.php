
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>  

<div id="page-content">
                        <!-- Inbox Header -->
                        <div class="content-header">
                            <div class="header-section">
                                <h1><i class="fa fa-eye"></i> View Message<br><small>Your Message Center</small></h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Pages</li>
                            <li>Message Center</li>
                            <li><a href="">View Message</a></li>
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
                                            <a href="page_ready_inbox_compose.html" class="btn btn-alt btn-sm btn-default"><i class="fa fa-pencil"></i> Compose Message</a>
                                        </div>
                                    </div>
                                    <!-- END Menu Title -->

                                    <!-- Menu Content -->
                                    <ul class="nav nav-pills nav-stacked">
                                        <li>
                                            <a href="page_ready_inbox.html">
                                                <span class="badge pull-right">5</span>
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Inbox</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">10</span>
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Starred</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Sent</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">2</span>
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Drafts</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Archive</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-angle-right fa-fw"></i> <strong>Spam</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
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
                                                <img src="img/placeholders/avatars/avatar14.jpg" alt="avatar" class="pie-avatar img-circle">
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
                                                <img src="img/placeholders/avatars/avatar11.jpg" alt="avatar" class="img-circle" data-toggle="tooltip" title="" data-original-title="Username">
                                            </a>
                                        </div>
                                        <div class="col-xs-6 block-section">
                                            <a href="page_ready_user_profile.html">
                                                <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="img-circle" data-toggle="tooltip" title="" data-original-title="Username">
                                            </a>
                                        </div>
                                        <div class="col-xs-6 block-section">
                                            <a href="page_ready_user_profile.html">
                                                <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="img-circle" data-toggle="tooltip" title="" data-original-title="Username">
                                            </a>
                                        </div>
                                        <div class="col-xs-6 block-section">
                                            <a href="page_ready_user_profile.html">
                                                <img src="img/placeholders/avatars/avatar11.jpg" alt="avatar" class="img-circle" data-toggle="tooltip" title="" data-original-title="Username">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END Online Users Content -->
                                </div>
                                <!-- END Online Users Block -->
                            </div>
                            <!-- END Inbox Menu -->

                            <!-- View Message -->
                            <div class="col-sm-8 col-lg-9">
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
                            <!-- END View Message -->
                        </div>
                        <!-- END Inbox Content -->
                    </div>

<?php $this->load->view('footer'); ?>


<!-- Javascript exclusivos para esta página -->
<script src="<?= base_url();?>js/pages/formsValidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script>$(function(){
    var json;
    
//  $.LoadingOverlay("show");
var number = <?= $idpost; ?>;

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
            var message = json[number].message;
            console.log(message);
            $("#lectura").html(message);
            $(".fecha").html(json[number].date);
         //  $('#inbox').html(tbody);
         //   $('#myTable').DataTable();
            //$.LoadingOverlay("hide");
            var attachments = json[number].attachments;
        var attachment = '';
        if(attachments.length > 0){
            $.each(attachments, function(i, a) {
                console.log(a);
                var file = json[number].uid + ',' + a.part + ',' + a.file + ',' + a.encoding;
               /* attachment += '<br><a href="#" class="file" data-file="' + file + '">' + a.file + '</a>';*/

                attachment += '<div class="col-xs-4 col-sm-2 text-center"><a href="#" data-toggle="lightbox-image" class="file" data-file="'+file+'"">View</a><span class="text-muted">'+a.file+'</span></div>';
            });
            $(".attachments").html(attachment);
        }
        }else{
            alert(d.message);
        }
    });


    $('body').on('click', '.file', function () {
        //$.LoadingOverlay("show");
        var file = $(this).data('file').split(",");
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>correos/inbox",
            data: {
                uid: file[0],
                part: file[1],
                file: file[2],
                encoding: file[3]
            },
            dataType: 'json'
        }).done(function(d) {
            if(d.status === "success"){
                //$.LoadingOverlay("hide");

                var archivo = file[2].replace(/ /g, "");
                window.open("<?= base_url() ?>attachments/"+archivo, '_blank');
            }else{
                alert(d.message);
            }
        });
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
          