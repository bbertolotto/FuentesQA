<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js">
<!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head');?>
<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
      <li><strong>Flujos comerciales</strong></li>
      <li><strong>Renegociar</strong></li>
      <li><strong>Procesos Automáticos</strong></li>
      <li><a href="/renegotiation/monitor" onclick="Client.processShow();">Monitor</a></li>
      <li><strong>Agendar</strong></li>
    </ul>

    <div class="block">
        <div class="block-title">
            <h2><strong>Registro Eventos</strong> Tareas autom&aacute;ticas</h2>
        </div>

                <div class="table-responsive ">
                    <table class="table table-vcenter schedule">
                        <thead>
                            <tr>
                                <th class="text-left">ID</i></th>
                                <th class="text-left">Usuario</i></th>
                                <th class="text-left">Oficina</i></th>
                                <th class="text-left">Tarea</th>
                                <th class="text-left">Fecha</th>
                                <th class="text-left">Hora Inicio</th>
                                <th class="text-left">Hora Termino</th>
                                <th class="text-left">Estado</th>
                                <th class="text-left">Resultado</th>
                            </tr>
                        </thead>
                    </table>
                </div>
          </div>

</div>
<!-- End page-content-->
<?php $this->load->view('footer');?>
<?php $this->load->view('ModalAlert');?>
<?php $this->load->view('ModalCreate');?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/renegotiation/schedule.js"></script>
</body>
</html>
