<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>
<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
        <li><strong><?= $this->lang->line('Manage');?></strong></li>
        <li><strong><?= $this->lang->line('Users');?></strong></li>
        <li><a href="/users/users"><strong><?= $this->lang->line('Username');?></strong></a></li>
        <li><a href="/users/activity"><strong><?= $this->lang->line('Activity');?></strong></a></li>
        <li><strong><?= $this->lang->line('Event Log');?></strong></li>
    </ul>
    <!-- End breadcrumb -->


    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title text-left">
                    <h2><strong><?= $this->lang->line('Inspect Event Log');?></strong></h2>
                </div>

                <form id="form-client" action="/users/list_log" method="post" class="form-horizontal form-bordered form-control-borderless">

                  <fieldset>

                    <div class="form-group col-xs-2 col-sm-2 col-lg-1">&nbsp;</div>

                    <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                            <label>Usuario</label>
                            <select id="username" name="username" class="select-chosen" data-placeholder="Seleccionar Usuario.." 
                            style="width: 250px;">
                                <option value="">[TODOS]</option>
                                <?php 
                                foreach ($users as $key) {
                                        echo '<option value="' .$key->username . '">' . $key->username . '</option>';
                                    }
                                ?>
                            </select>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                        <label for="dateBegin">Fecha Desde</label>
                        <div class="input-group">
                          <input type="text" id="dateBegin" name="dateBegin" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?= $date_begin?>">
                          <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                      </div>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4 col-lg-2">
                        <label for="dateEnd">Fecha Hasta</label>
                        <div class="input-group">
                          <input type="text" id="dateEnd" name="dateEnd" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?= $date_end?>">
                          <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                      </div>
                    </div>

                    <div class="form-group col-xs-4 col-sm-4 col-lg-2">
                        <label>Resultado Transacción</label>
                        <select name="result" id="result" class="form-control text-center">
                            <?php echo $result;?>
                        </select>
                    </div>

                  </fieldset>

                    <fieldset>

                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-search btn-success" data-target="search"><i class="fa fa-search"></i> Buscar</button>
                      <button type="button" class="btn btn-warning" onclick="Client.clearInput();"><i class="gi gi-refresh"></i> Limpiar</button>
                    </div>
                  </fieldset>

                </form>

            </div>
        </div>
        <!--End col-md-6-->
    </div>

    <div class="row" id="client-details" >

    <div class="col-md-12">
      <div class="block">
          <div class="block-title">
              <h2><strong>Detalle</strong><span id="nombrecliente"></span> <strong> Transacciones Procesadas</strong></h2>
          </div>

          <table id="response" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                        <th width="5%">Inicio</th>
                        <th class="text-center">Duración</th>
                        <th width="10%">Username</th>
                        <th width="10%">WebServices</th>
                        <th width="30%">Request</th>
                        <th width="30%">Response</th>
                        <th width="10%" align="center">Resultado</th>
                      </tr>
                  </thead>
                  <tbody>
            </table>

        </div>

    </div>
    </div>


</div>
<!-- End page-content-->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>

<script language="javascript">


    $('.btn-search').on('click', function () {


        dataCard = $("#form-client").serialize();

        var response = Teknodata.call_ajax("/users/list_log", dataCard, false, false, ".btn-search");
        if(response!=false){

            var t = $('#response').DataTable();
            t .clear() .draw();

            if(response["dataResult"].retorno==0) {

                if(response["dataResponse"].length>0) {
                    for(i=0;i<response["dataResponse"].length;i++){
                        t.row.add( [
                            response["dataResponse"][i].dateBegin,
                            response["dataResponse"][i].time,
                            response["dataResponse"][i].username,
                            response["dataResponse"][i].endPoint,
                            response["dataResponse"][i].request,
                            response["dataResponse"][i].response,
                            response["dataResponse"][i].result,
                        ] ).draw( false );
                    }
                }
                //Client.restore();

            } else {

                Alert.showAlert(response["dataResult"].descRetorno);
            }


        }

        return(false);
    });


$(document).ready(function() {
    var table = $('#response').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );

</script>

</body>
</html>
