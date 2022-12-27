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
            <li class="active"><a href="/client/information" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-user"></i> Personales</a></li>
            <li><a href="/client/contact" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-phone"></i> Contacto</a></li>
            <li><a href="/client/lasttransaction" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-transfer"></i> Transacciones</a></li>
            <li><a href="/client/lastaccount" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt"></i> Detalle EECC</a></li>
            <li><a href="/client/secure" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-warning_sign"></i> Seguros</a></li>
            <li><a href="/client/replacecard" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card"></i> Reponer Tarjeta</a></li>
        </ul>
    </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><strong>Centro de servicios</strong></li>
        <li><a href="<?= base_url();?>client/search"><strong>B&#250;squeda Clientes</strong></a></li>
        <li><strong>Datos Personales</strong></li>
    </ul>



<div class="block full">
  <div class="block-title" id="divNameClient">
      <h2><strong>Cliente </strong><?php if ($dataCliente): ?> <?php echo $dataCliente['nombre_cliente'].' '.$dataCliente['apellido_cliente'] ?> <?php else: ?> Atributo vacio <?php endif; ?> </td></h2>
  </div>

  <div class="block">
      <div class="block-title">
          <ul class="nav nav-tabs" data-toggle="tabs">
              <li class="active"><a href="#tabs-personal1"><h2><i class="gi gi-user"></i> Personales</h2></a></li>
              <li><a href="#tabs-additional1"><h2><i class="gi gi-parents"></i> Adicionales</h2></a></li>
          </ul>
      </div>

      <div class="tab-content">

        <div class="tab-pane active " id="tabs-personal1">
        <form id="form-client" class="form-horizontal form-bordered" method="post">

          <table class="table">
            <div class="form-group">
              <div class="col-sm-3">
                <label for="masked_rut_client">N&#250;mero RUT</label>
                <div class="input-group">
                    <input type="hidden" id="rutClient" name="rutClient" value="<?=$this->session->userdata('nroRut')?>">
                    <input type="text" id="masked_rut_client" name="masked_rut_client" class="form-control text-center col-sm-5" value="<?=$this->session->userdata('nroRut')?>" readonly>
                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                </div>
              </div>

              <div class="col-sm-3">
                <label for="masked_name_client">Nombres</label>
                <div class="input-group col-xs-12">
                    <input type="text" id="nameClient" name="nameClient" class="form-control" onKeyUp="this.value=this.value.toUpperCase();" value="<?php if ($dataCliente): ?> <?php echo $dataCliente['nombres'] ?> <?php else: ?> Atributo vacio <?php endif; ?>" >
                    <input type="hidden" id="nameClientH">
                </div>

              </div>
              <div class="col-sm-3">
                  <label for="last_father_client">Apellido Paterno</label>
                  <div class="input-group col-xs-12">
                      <input type="text" id="lastFatherClient" name="lastFatherClient" class="form-control" onKeyUp="this.value=this.value.toUpperCase();" value="<?php if ($dataCliente): ?> <?php echo $dataCliente['apellidoPaterno'] ?> <?php else: ?> Atributo vacio <?php endif; ?>">
                      <input type="hidden" id="lastFatherClientH">
                  </div>
              </div>
              <div class="col-sm-3">
                  <label for="last_mother_client">Apellido Materno</label>
                  <div class="input-group col-xs-12">
                      <input type="text" id="lastMotherClient" name="lastMotherClient" class="form-control" onKeyUp="this.value=this.value.toUpperCase();" value="<?php if ($dataCliente): ?> <?php echo $dataCliente['apellidoMaterno'] ?> <?php else: ?> Atributo vacio <?php endif; ?>">
                      <input type="hidden" id="lastMotherClientH">
                  </div>
              </div>

              <div class="col-sm-3">
                <label for="birth_date_client">Fecha Nacimiento</label>
                <div class="input-group">
                    <input type="text" id="birthDateClient" name="birthDateClient" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy" value="<?php if ($dataCliente): ?> <?php echo $dataCliente['fechaNacimiento'] ?> <?php else: ?> Atributo vacio <?php endif; ?>">
                    <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                     <input type="hidden" id="birthDateClientH">
                </div>
              </div>

              <div class="col-sm-3">
                <label for="gender_skill">Sexo <span class="text-danger">*</span></label>
                <div class="input-group col-xs-12">
                  <select id="genderSkill" name="genderSkill" class="form-control">
                    <?php if (ltrim(rtrim($dataCliente['sexo']))=='FEM'): ?> <option value="FEM" selected > <?php else: ?> <option value="FEM" > <?php endif; ?> Femenino</option>
                    <?php if (ltrim(rtrim($dataCliente['sexo']))=='MAS'): ?> <option value="MAS" selected > <?php else: ?> <option value="MAS" > <?php endif; ?> Masculino</option>
                  </select>
                </div>
              </div>

              <div class="col-sm-3">
                  <label for="activity_client">Actividad</label>
                  <div class="input-group col-xs-12" >
                      <select id="activityClientSkill" name="activityClientSkill" class="select-chosen" data-placeholder="Buscar Actividad Economica .." >
                        <?php if(isset($dataAcreditaciones['codActividad'])){
                                foreach ($dataActivity as $nodo) {
                                    if($nodo->KEY==$dataAcreditaciones['codActividad']){
                                        echo '<option value="'.$nodo->KEY.'" selected>'.$nodo->NAME.'</option>';
                                    }else{
                                        echo '<option value="'.$nodo->KEY.'">'.$nodo->NAME.'</option>';
                                        }
                                }
                            }else {
                                foreach ($dataActivity as $nodo) {
                                    echo '<option value="'.$nodo->KEY.'">'.$nodo->NAME.'</option>';
                                }
                            }?>
                      </select>
                  </div>
              </div>
              <div class="col-sm-2">
                  <label for="salary_client">Renta</label>
                  <div class="input-group col-xs-9">
                      <input type="text" id="salaryClient" name="salaryClient" class="form-control text-center" maxlength="10" onfocus="this.value = this.value.replace(/[.-]/g, '').replace(/[^0-9\.]/g, '');" onblur="this.value = this.value.replace(/[.-]/g, '').replace(/[^0-9\.]/g, ''); this.value = new Intl.NumberFormat('de-DE').format(this.value);" value="<?php if (isset($dataAcreditaciones['renta'])): ?> <?php echo number_format((float)$dataAcreditaciones['renta'], 0, ',', '.') ?> <?php endif; ?>">
                  </div>
              </div>

              <div class="col-sm-3">
                  <label for="company_client">Empresa</label>
                  <div class="input-group col-xs-12">
                      <input type="text" id="companyClient" name="companyClient" class="form-control" onKeyUp="this.value=this.value.toUpperCase();" value="<?php if (isset($dataAcreditaciones['empresa'])): ?> <?php echo $dataAcreditaciones['empresa'] ?> <?php endif; ?>">
                  </div>
              </div>

            </div>

            <div class="form-group text-center">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success btn-update-client" ><i class="hi hi-saved"></i> Grabar</button>
                    <button type="reset" class="btn btn-warning" onclick="Cliente.reset();" ><i class="gi gi-restart"></i> Cancelar</button>
                </div>
            </div>

          </table>
          </form>

          </div>


          <div class="tab-pane " id="tabs-additional1">
            <form id="form-additional" class="form-horizontal form-bordered" method="post">
            <table class="table">

            <div class="form-group">
              <div class="col-sm-3">
                <label for="masked_rut_client">N&#250;mero RUT</label>
                <div class="input-group">
                    <input type="hidden" id="rutAdditional" name="rutAdditional" >
                    <input type="text" id="masked_rut_additional" name="masked_rut_additional" class="form-control text-center col-sm-5" readonly>
                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                </div>
              </div>

              <div class="col-sm-3">
                <label for="masked_name_client">Nombres</label>
                <div class="input-group col-xs-12">
                    <input type="text" id="nameAddi" name="nameAddi" onKeyUp="this.value=this.value.toUpperCase();" class="form-control">
                    <input type="hidden" id="nameClientH">
                </div>

              </div>
              <div class="col-sm-3">
                  <label for="last_father_client">Apellido Paterno</label>
                  <div class="input-group col-xs-12">
                      <input type="text" id="lastFatherAddi" name="lastFatherAddi" onKeyUp="this.value=this.value.toUpperCase();" class="form-control" >
                       <input type="hidden" id="lastFatherClientH">
                  </div>
              </div>
              <div class="col-sm-3">
                  <label for="last_mother_client">Apellido Materno</label>
                  <div class="input-group col-xs-12">
                      <input type="text" id="lastMotherAddi" name="lastMotherAddi" onKeyUp="this.value=this.value.toUpperCase();" class="form-control" >
                       <input type="hidden" id="lastMotherClientH">
                  </div>
              </div>

                <!--div class="col-sm-3">
                    <label for="masked_credit_card">Nº de Tarjeta</label>
                    <div class="input-group">
                        <input type="text" id="masked_credit_card" name="masked_credit_card" class="form-control text-center col-sm-3" placeholder="9999-9999-9999-9999" readonly value="<?php $nroTcv = $this->session->userdata('nroTcv'); echo substr($nroTcv,0,4).'-'.substr($nroTcv,4,4).'-'.substr($nroTcv,8,4).'-'.substr($nroTcv,12,4);?>">
                        <span class="input-group-addon"><i class="gi gi-credit_card"></i></span>
                    </div>
                </div-->
                <input type="hidden" id="masked_credit_card" name="masked_credit_card" class="form-control text-center col-sm-3" placeholder="9999-9999-9999-9999" readonly value="<?php $nroTcv = $this->session->userdata('nroTcv'); echo substr($nroTcv,0,4).'-'.substr($nroTcv,4,4).'-'.substr($nroTcv,8,4).'-'.substr($nroTcv,12,4);?>">



                <div class="col-sm-3">
                  <label for="birth_date_addi">Fecha Nacimiento</label>
                  <div class="input-group">
                      <input type="text" id="birthDateAddi" name="birthDateAddi" class="form-control input-datepicker text-center" data-date-format="dd-mm-yyyy">
                      <span class="input-group-addon"><i class="gi gi-calendar"></i></span>
                       <input type="hidden" id="birthDateClientH">
                  </div>
                </div>



              <div class="col-sm-3">
                <label for="gender_skill">Sexo <span class="text-danger">*</span></label>
                <div class="input-group col-xs-6">
                  <select id="genderSkillAddi" name="genderSkillAddi" class="form-control">
                            <option value="F">FEMENINO</option>
                            <option value="M">MASCULINO</option>
                  </select>
                </div>
              </div>

                <div class="col-sm-3">
                    <label for="val_skill">Parentesco<span class="text-danger">*</span></label>
                    <div class="input-group col-xs-6">
                        <select id="relationSkillAddi" name="relationSkillAddi" class="form-control">
                            <option value="CO">CONYUGE</option>
                            <option value="HE">HERMANO(A)</option>
                            <option value="HI">HIJO(A)</option>
                            <option value="OT">OTRO</option>
                        </select>
                    </div>
                </div>


            </div>

                <div class="form-group text-center">
                <div class="col-sm-12">
                      <button type="submit" class="btn-update-addi btn btn-success"><i class="hi hi-saved"></i> Modificar </button>
                      <button type="reset" class="btn btn-warning"><i class="hi hi-remove"></i> Limpiar</button>
                </div>
                </div>


            </table>
          </form>

            <table class="table table-striped table-bordered" id="dataAdditional">
                <thead>
                    <tr>
                        <th class="text-left"><strong>RUT Adicional</strong></th>
                        <!--th class="text-left"><strong>Nº de Tarjeta</strong></th-->
                        <th class="text-left"><strong>Nombre </strong></th>
                        <th class="text-left"><strong>Apellido Paterno </strong></th>
                        <th class="text-left"><strong>Apellido Paterno </strong></th>
                        <th class="text-left"><strong>Fecha Nacimiento</strong></th>
                        <th class="text-left"><strong>Sexo</strong></th>
                        <th class="text-left"><strong>Parentesco</strong></th>
                        <th class="text-center"><strong>Modificar</strong></th>
                    </tr>
                </thead>


            <?php if (!$dataAdicionales): ?>
                <tbody>
                    <tr><td colspan="8"><strong>No registra datos clientes adicionales</strong></td>
                </tbody>

            <?php else: ?>

                <tbody>
                <?php $k = 0;
                    foreach ($dataAdicionales as $record) { ?>
                    <tr>
                    <td class="text-left"><?= $record['nroRutAdi'] ?> </td>
                    <td class="text-left"><?= $record['nombresAdi']?> </td>
                    <td class="text-left"><?= $record['apellidoPaternoAdi']?> </td>
                    <td class="text-left"><?= $record['apellidoMaternoAdi']?> </td>
                    <td class="text-left"><?= $record['fechaNacimientoAdi']?></td>
                    <td class="text-left"><?= $record['descSexoAdi']?></td>
                    <td class="text-left"><?= $record['descRelacion']?></td>
                    <td class="text-center"><button type="button" class="btn-sel-addi btn btn-xs btn-warning" data-relation="<?=$record['relacion']?>" data-gender="<?=$record['sexoAdi']?>"><i class="gi gi-upload" title="Modificar"></i></button></td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php endif; ?>
                </table>

          </div>

      </div>
  </div>

  <div class="row">
      <div class="col-md-12">
          <div class="block">
              <div class="block-title">
                  <h2><strong>Resumen crediticio</strong></h2>
              </div>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><strong>Fecha Creaci&#243;n</strong></th>
                            <th class="text-center"><strong>Fecha Vencimiento</strong></th>
                            <th class="text-center"><strong>Sobregiros autorizados</strong></th>
                            <th class="text-center"><strong>Modalidad Venta</strong></th>
                            <th class="text-center"><strong>Cobros Vigentes</strong></th>
                            <th class="text-right"><strong>&#218;ltima TRX de Venta</strong></th>
                            <th class="text-right"><strong>&#218;ltima TRX de Avance</strong></th>
                            <th class="text-right"><strong>&#218;ltima TRX de Pago</strong></th>
                            <th class="text-right"><strong>&#218;ltima TRX de Cargo</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?php if (isset($dataCuenta['fechaCreacion'])): ?> <?php echo substr($dataCuenta['fechaCreacion'],0,10) ?> <?php endif; ?></td>
                            <td class="text-center"><?php if (isset($dataUltimasTransacciones['fechaVencimiento'])): ?> <?php echo $dataUltimasTransacciones['fechaVencimiento'] ?> <?php endif; ?></td>
                            <td class="text-center"><button type="button" class="btn btn-xs btn-success" onclick="$('.modal-tooltip-sobregiro').modal({show:true});"><i class="gi gi-zoom_in" title="Ver Detalle"></i></button>
                            </td>
                            <td class="text-center"><button type="button" class="btn btn-xs btn-success" onclick="$('.modal-tooltip-modalidad').modal({show:true});"><i class="gi gi-zoom_in" title="Ver Detalle"></i></button>
                            </td>
                            <td class="text-center"><button type="button" class="btn btn-xs btn-success" onclick="$('.modal-tooltip-tasa').modal({show:true});"><i class="gi gi-zoom_in" title="Ver Detalle"></i></button>
                            </td>
                            <td class="text-right">$<?php if (isset($dataUltimasTransacciones['ultimaTRXVenta'])): ?> <?php echo number_format((float)$dataUltimasTransacciones['ultimaTRXVenta'],0 ,',' ,'.') ?> <?php endif; ?></td>
                            <td class="text-right">$<?php if (isset($dataUltimasTransacciones['ultimaTRXAvance'])): ?> <?php echo number_format((float)$dataUltimasTransacciones['ultimaTRXAvance'],0 ,',' ,'.') ?> <?php endif; ?></td>
                            <td class="text-right">$<?php if (isset($dataUltimasTransacciones['ultimaTRXPago'])): ?> <?php echo number_format((float)$dataUltimasTransacciones['ultimaTRXPago'],0 ,',' ,'.') ?> <?php endif; ?></td>
                            <td class="text-right">$<?php if (isset($dataUltimasTransacciones['ultimaTRXCargo'])): ?> <?php echo number_format((float)$dataUltimasTransacciones['ultimaTRXCargo'],0 ,',' ,'.') ?> <?php endif; ?></td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
        <!--End col-md-12-->
    </div>
    <!--END row-->


</div>
<!--End block-full-->

</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalTooltipModalidad', $dataParamAdquiriente); ?>
<?php $this->load->view('ModalTooltipTasa', $dataParamTasa); ?>
<?php $this->load->view('ModalTooltipSobregiro', $dataParamSobregiro); ?>

<script src="<?= base_url();?>js/client/information.js"></script>
<script src="<?= base_url();?>js/pages/Alert.js"></script>

<?php if ($dataError['session_empty']): ?>
<script language="javascript">
var e = document.getElementById("body-modal-session");
$('.modal-session').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>
</body>
</html>
