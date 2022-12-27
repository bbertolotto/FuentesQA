<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>

<div id="page-content">

    <div class="content-header">
        <ul class="nav-horizontal text-center">
            <li><a href="/client/search" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-search"></i> Buscar</a></li>
            <li><a href="/client/consolidate" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-crop"></i> Consolidado</a></li>
            <li><a href="/client/information" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-user"></i> Personales</a></li>
            <li><a href="/client/contact" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-phone"></i> Contacto</a></li>
            <li><a href="/client/lasttransaction" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-transfer"></i> Transacciones</a></li>
            <li><a href="/client/lastaccount" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt"></i> Detalle EECC</a></li>
            <li><a href="/client/secure" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-warning_sign"></i> Seguros</a></li>
            <li class="active"><a href="/client/replacecard" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card"></i> Reponer Tarjeta</a></li>
        </ul>
    </div>

    <ul class="breadcrumb breadcrumb-top">
      <li><strong>Centro de servicios</strong></li>
      <li><a href="/client/search"><strong>B&#250;squeda Clientes</strong></a></li>
      <li><strong>Reponer Tarjetas</strong></li>
    </ul>
    <!-- End breadcrumb -->

    <div class="row">
        <div class="col-md-12">

            <div class="block">

                <div class="block-title">
                    <h2><strong>Cliente </strong><?=$this->session->userdata('nombre_cliente').' '.$this->session->userdata('apellido_cliente')?></h2>

                    <div class="block-options pull-right">
                        <h2><strong>Bloqueo y Reposición de Tarjetas</strong></h2>
                    </div>

                </div>

                <table class="table table-striped table-bordered">

                <?php echo $htmlTarjetas?>

                </table>

            </div>


            <div class="block">

                <div class="block-title">
                    <h2><strong>Bloqueo de Tarjeta</strong></h2>
                </div>


                <table class="table table-striped table-bordered">

            <form action="#" method="post" class="form-bordered" onsubmit="return false;">

                <div class="form-group col-xs-6 col-sm-6 col-lg-4">
                    <label for="lockType">Tipo Bloqueo</label>
                        <select id="lockType" name="lockType" class="form-control text-center" onchange="Client.selectLockType(this);" >
                            <?php
                                echo "<option value=''>Seleccionar Tipo Bloqueo</option>";
                                foreach ($lockTypes as $nodo) {
                                    $datajson = '{ "key":"'.$nodo->KEY.'", "codbloqsat":"'.$nodo->CODBLOQSAT.'", "desbloqsat":"'.$nodo->DESBLOQSAT.'","flgbloqsat":"'.$nodo->FLGBLOQSAT.'", "namebloqsat":"'.$nodo->NAME.'" }';
                                    echo "<option value='".$datajson."'>".$nodo->NAME."</option>";
                            }?>
                        </select>
                </div>

                <div class="form-group col-xs-6 col-sm-6 col-lg-6">
                    <label for="commandLock">&nbsp;</label>
                    <div class="input-group">
                    <button type="button" class="btn-accept-lock btn btn-success btn-request" ><i class="fa fa-arrow-right"></i> Aplicar Bloqueo </button>
                    <button type="button" class="btn-accept-save btn btn-success btn-request" ><i class="fa fa-arrow-right"></i> Generar Solicitud de Impresión </button>
                    </div>
                </div>


            </form>

        </table>


            </div>



        </div>
        <!--End col-md-12-->


      </div>
      <!--END row-->

<input type="hidden" id="number_credit_card">
<input type="hidden" id="name_bloq_credit_card">
<input type="hidden" id="code_bloq_credit_card">
<input type="hidden" id="relation_credit_card">
<input type="hidden" id="status_credit_card">

</div>

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script language="javascript">

$(function () {

    $('.btn-accept-lock').on('click', function () {

        var formData = new FormData();
        formData.append('number_credit_card', $("#number_credit_card").val());
        formData.append('name_bloq_credit_card', $("#name_bloq_credit_card").val());
        formData.append('code_bloq_credit_card', $("#code_bloq_credit_card").val());

        var response = Teknodata.call_ajax("/client/put_BlockingCreditCard", formData, false, true, ".btn");

        if(response!=false){

            Alert.showWarning("",response.descRetorno);
        }
        return(false);
    });


    $('.btn-accept-save').on('click', function () {

        var formData = new FormData();
        formData.append('number_credit_card', $("#number_credit_card").val());
        formData.append('name_bloq_credit_card', $("#name_bloq_credit_card").val());
        formData.append('code_bloq_credit_card', $("#code_bloq_credit_card").val());
        formData.append('relation_credit_card', $("#relation_credit_card").val());
        formData.append('status_credit_card', $("#status_credit_card").val());

        var response = Teknodata.call_ajax("/client/put_RequestReprintCreditCard", formData, false, true, ".btn-request");

        if(response!=false){

            Alert.showWarning("",response.descRetorno);
        }

        return(false);
    });


});

var Client = function() {
    return {

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },

        selectLockType: function(e) {

            if($("#datajson").val()=="") {

                toastr.warning("Antes de Seleccionar un Tipo de bloqueo debe seleccionar una Tarjeta","Preste Atención");
                return(false);
            }
            if(e.value==""){
              $(".btn-accept-lock").prop("disabled", true);
              $(".btn-accept-save").prop("disabled", true);
              return(false);
            }
            var response = JSON.parse(e.value);

            if(response.flgbloqsat==0) {
                $(".btn-accept-lock").prop("disabled", false);
                $(".btn-accept-save").prop("disabled", false);
            } else {
                if(response.flgbloqsat==1) {
                    $(".btn-accept-lock").prop("disabled", true);
                    $(".btn-accept-save").prop("disabled", false);
                } else {                
                    $(".btn-accept-lock").prop("disabled", false);
                    $(".btn-accept-save").prop("disabled", true);
                }
            }

            $("#name_bloq_credit_card").val(response.namebloqsat);
            $("#code_bloq_credit_card").val(response.codbloqsat);

            return(false);
        },
        selectReplaceCard: function (e) {
            var tabTD = e.getElementsByTagName("td");
            var idPan = tabTD[2].innerText.substr(15,4);
            idPan += tabTD[6].innerText;
            var idCheck = "sel"+idPan;

            var o = document.getElementById(idCheck);
            o.checked = true;

            $("#lockType").prop("disabled", false);
            $("#number_credit_card").val(o.value);
            $("#relation_credit_card").val(tabTD[6].innerText);
            $("#status_credit_card").val(tabTD[3].innerText);

        },
        init: function() {
            $("#lockType").prop("disabled", true);
            $(".btn-accept-lock").prop("disabled", true);
            $(".btn-accept-save").prop("disabled", true);
        }

    };

}();
$(function(){ Client.init(); });
</script>


<?php if ($dataError['session_empty']): ?>
<script language="javascript">
$('.modal-session').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>

<?php if ($dataError['load_error']): ?>
<script language="javascript">
$("#body-modal-alert").html('<?=$dataError["descRetorno"]?>');
$('.modal-alert').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>

</body>
</html>
