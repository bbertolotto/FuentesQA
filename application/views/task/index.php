<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>  
<div id="page-content" style="min-height: 1637px;">
                        <!-- Tasks Header -->
                        <div class="content-header">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-tasks"></i>Tasks<br><small>Manage your to-dos!</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Pages</li>
                            <li><a href="">Tasks</a></li>
                        </ul>
                        <!-- END Tasks Header -->

                        <!-- Tasks Row -->
                        <div class="row">
                            <div class="col-sm-4 col-lg-3">
                                <!-- Task Lists Block -->
                                <div class="block full">
                                    <!-- Task Lists Title -->
                                    <div class="block-title clearfix">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="" data-original-title="Settings"><i class="fa fa-cog"></i></a>
                                        </div>
                                        <h2><i class="fa fa-tasks"></i> Tasks <strong>List</strong></h2>
                                    </div>
                                    <!-- END Task Lists Title -->

                                    <!-- Task Lists Content -->
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="active">
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">7</span>
                                                <i class="fa fa-briefcase fa-fw"></i> <strong>Work</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">4</span>
                                                <i class="fa fa-lock fa-fw"></i> <strong>Personal</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">3</span>
                                                <i class="fa fa-plane fa-fw"></i> <strong>Vacation</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">5</span>
                                                <i class="fa fa-users fa-fw"></i> <strong>Friends</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="badge pull-right">1</span>
                                                <i class="fa fa-building fa-fw"></i> <strong>University</strong>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- END Task Lists Content -->
                                </div>
                                <!-- END Task Lists Block -->

                                <!-- Account Stats Block -->
                                <div class="block">
                                    <!-- Account Status Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <span class="label label-danger">85%</span>
                                        </div>
                                        <h2><i class="fa fa-user"></i> Account <strong>Status</strong></h2>
                                    </div>
                                    <!-- END Account Status Title -->

                                    <!-- Account Stats Content -->
                                    <div class="row block-section text-center">
                                        <div class="col-xs-12">
                                            <div class="pie-chart block-section easyPieChart" data-percent="85" data-line-width="2" data-bar-color="#e74c3c" data-track-color="#ffffff" style="width: 80px; height: 80px; line-height: 80px;">
                                                <img src="img/placeholders/avatars/avatar12.jpg" alt="avatar" class="pie-avatar img-circle">
                                            <canvas width="80" height="80"></canvas></div>
                                        </div>
                                    </div>
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            <tr>
                                                <td class="text-right" style="width: 50%;"><strong>Active Plan</strong></td>
                                                <td>VIP <a href="page_ready_pricing_tables.html" data-toggle="tooltip" title="" data-original-title="Upgrade to Pro"><i class="fa fa-arrow-up"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Tasks Storage</strong></td>
                                                <td class="text-danger"><strong>85</strong> of <strong>100</strong> MB</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>Plan Valid</strong></td>
                                                <td><span class="text-success"><strong>5</strong> months left</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Account Status Content -->
                                </div>
                                <!-- END Account Status Block -->
                            </div>
                            <div class="col-sm-8 col-lg-9">
                                <!-- Add new task functionality (initialized in js/pages/readyTasks.js) -->
                                <form id="add-task-form" class="push">
                                    <div class="input-group input-group-lg">
                                        <input type="text" id="add-task" name="add-task" class="form-control" placeholder="Add New Task..">
                                         
                                        <div class="input-group-btn">
                                            <button type="submit" id="add-task-btn" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Task List -->
                                <ul class="task-list">

                                    <?php foreach ($selectnews as $key) { ?>
                                      
                                    <?php if($key->detail != "" and $key->stamp_begin != NULL): ?>
                                    <li>
                                        <a href="javascript:void(0)" class="task-close"><i class="fa fa-times"></i></a>
                                        <label class="checkbox-inline">
                                            <input type="checkbox"> <?= $key->detail ?>
                                        </label>
                                    </li>
                                <?php endif; ?>
                                  <?php } ?>
                                    
                                </ul>
                                <!-- END Task List -->
                            </div>
                        </div>
                        <!-- END Tasks Row -->
                    </div>


<?php $this->load->view('footer'); ?>
 
        <script>
            $(function(){ 


     var taskList        = $('.task-list');
            var taskInput       = $('#add-task');
            var taskInputVal    = '';

            /* On page load, check the checkbox if the class 'task-done' was added to a task */
        //    $('.task-done input:checkbox').prop('checked', true);

            /* Toggle task state */
            taskList.on('click', 'input:checkbox', function(){

                $(this).parents('li').toggleClass('task-done');
            });

            /* Remove a task from the list */
            taskList.on('click', '.task-close', function(){
                   console.log("tachado");
                $(this).parents('li').slideUp();
            });

            /* Add a new task to the list */
            $('#add-task-form').on('submit', function(){
                // Get input value
                taskInputVal = taskInput.prop('value');

                // Check if the user entered something
                if ( taskInputVal ) {
                    // Add it to the task list
                    

        $.ajax({
            url: "<?php echo base_url(); ?>task/savetask",
            type: 'post',
            dataType: 'json',
            data: {value : taskInputVal },
            success: function(json) {
                        
                        taskList.prepend('<li class="animation-slideUp">' +
                            '<a href="javascript:void(0)" class="task-close"><i class="fa fa-times"></i></a>' +
                            '<label class="checkbox-inline">' +
                            '<input type="checkbox">' +
                            $('<span />').text(taskInputVal).html() +
                            '</label>' +
                            '</li>');
                 }
        });

                    // Clear input field
                    taskInput.prop('value', '').focus();
                }

                // Don't let the form submit
                return false;
            });


    });
</script>
</body>
</html>
          