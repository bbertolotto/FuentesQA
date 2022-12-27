<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view('head'); ?>

<div id="page-content">
  <div class="content-header">
      <ul class="nav-horizontal text-center">
          <li><a href="/client/search" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-search"></i> Buscar</a></li>
          <li><a href="/client/consolidate" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-crop"></i> Consolidado</a></li>
          <li><a href="/client/information" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-user"></i> Personales</a></li>
          <li class="active"><a href="/client/contact" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="fa fa-phone"></i> Contacto</a></li>
          <li><a href="/client/lasttransaction" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-transfer"></i> Transacciones</a></li>
          <li><a href="/client/lastaccount" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-list-alt"></i> Detalle EECC</a></li>
          <li><a href="/client/secure" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="gi gi-warning_sign"></i> Seguros</a></li>
          <li><a href="/client/replacecard" onclick="p = document.getElementById('processing'); p.style.display='';"><i class="hi hi-credit_card"></i> Reponer Tarjeta</a></li>
      </ul>
  </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><strong>Centro de servicios</strong></li>
        <li><a href="<?= base_url();?>client/search"><strong>B&#250;squeda Clientes</strong></a></li>
        <li><strong>Datos Contacto</strong></li>
    </ul>

<div class="block full">
      <div class="block-title">
          <h2><strong>Cliente </strong><?php if ($dataCliente): ?> <?php echo $dataCliente['name_client'].' '.$dataCliente['last_name_client'] ?> <?php else: ?> NO INFORMADO <?php endif; ?></h2>
      </div>

      <div class="block">
          <!-- Block Tabs Title -->
          <div class="block-title">
              <ul class="nav nav-tabs" data-toggle="tabs">
                  <li class="active"><a href="#tabs-contact"><h2><i class="gi gi-address_book"></i> Datos Contacto</h2></a></li>
                  <li><a href="#tabs-phones"><h2><i class="fa fa-phone"></i> Tel&#233;fonos</h2></a></li>
                  <li><a href="#tabs-emails"><h2><i class="fa fa-send"></i> Correos Electr&#243;nicos</h2></a></li>
              </ul>
          </div>

          <div class="tab-content">

              <div class="tab-pane active " id="tabs-contact">
                <form id="form-contact" class="form-horizontal form-bordered" action="index.html" method="post">
                  <table class="table">

                    <div class="form-group">

                      <div class="col-sm-3">
                          <label for="val_skill">Tipo Direcci&#243;n <span class="text-danger">*</span></label>
                          <div class="input-group col-xs-6">
<?php if($this->session->userdata("flg_flujo")=="001"):?>
                              <select id="typeAddressSkill" name="typeAddressSkill" class="form-control">
                                <option value="DH">PARTICULAR</option>
                              </select>
<?php else:?>
                              <select id="typeAddressSkill" name="typeAddressSkill" class="form-control">
                                <option value="HOME">PARTICULAR</option>
                                <option value="WORKS_AT">LABORAL</option>
                              </select>
<?php endif;?>
                          </div>
                      </div>

                      <div class="col-sm-3">
                          <label for="example-chosen">Regi&#243;n<span class="text-danger">*</span></label>
                          <div class="input-group col-xs-9">
                              <select id="typeRegionSkill" name="typeRegionSkill" class="form-control">
                                <option value="" selected>SELECCIONE REGI&#211;N</option>
                                <?php  foreach($regions as $key): ?>
                                       <option value="<?= $key["CODIGO_REGION"] ?>"><?= $key["NOMBRE_REGION"] ?> </option>
                                <?php endforeach; ?>
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-3">
                          <label for="example-chosen">Ciudad<span class="text-danger">*</span></label>
                          <div class="input-group col-xs-9">
                            <select id="typeCitySkill" name="typeCitySkill" class="form-control">
                            </select>
                          </div>
                      </div>

                      <div class="col-sm-3">
                          <label for="example-chosen">Comuna<span class="text-danger">*</span></label>
                          <div class="input-group col-xs-9">
                              <select id="typeCommuneSkill" name="typeCommuneSkill" class="form-control">
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-3">
                          <label for="val_skill">Direcci&#243;n <span class="text-danger">*</span></label>
                          <div class="input-group col-xs-12">
                              <input type="text" id="address" name="address" class="form-control"  onKeyUp="this.value=this.value.toUpperCase();" placeholder="">
                          </div>
                      </div>

                      <div class="col-sm-3">
                          <label for="val_skill">N&#250;mero <span class="text-danger">*</span></label>
                          <div class="input-group col-xs-6">
                                <input type="text" id="numberAddress" maxlength="5" name="numberAddress" class="form-control" placeholder="Número">
                          </div>
                      </div>

                        <div class="col-sm-3">
                            <label for="val_skill">Departamento</label>
                            <div class="input-group col-xs-6">
                              <input type="text" id="numberDepart" maxlength="5" name="numberDepart" class="form-control" placeholder="">
                            </div>
                        </div>

                      <div class="col-sm-3">
                          <label for="val_skill">Block</label>
                          <div class="input-group col-xs-6">
                            <input type="text" id="numberBlock" maxlength="5" name="numberBlock" class="form-control" placeholder="">
                          </div>
                      </div>

                        <div class="col-sm-3">
                        <label for="val_skill">Complemento</label>
                        <div class="input-group col-xs-12">
                            <input type="text" id="complement" name="complement" class="form-control" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Complemento.." title="Utilice para detallar Población, Villa, Condominio, Sector, Cerro..">
                        </div>
                      </div>

                      <div class="col-md-9">
                          <label for="val_skill">&nbsp;</label>
                          <div class="input-group text-center">
                            <button type="submit" class="btn-update-address btn btn-success" id="btn-update-addres"><i class="fa fa-exchange"></i> Modificar</button>
                            <button type="reset" class="btn-reset-address btn btn-danger"><i class="fa fa-repeat"></i> Cancelar</button>
                          </div>
                      </div>

                    </div>

                  </table>
                </form>

                <table class="table table-striped table-bordered" id="dataAddress">
                <thead>
                    <tr>
                        <th scope="col"><strong>Tipo</strong></th>
                        <th scope="col"><strong>Calle</strong></th>
                        <th scope="col"><strong>N&#250;mero</strong></th>
                        <th scope="col"><strong>Departamento</strong></th>
                        <th scope="col"><strong>Block</strong></th>
                        <th scope="col"><strong>Complemento</strong></th>
                        <th scope="col"><strong>Comuna</strong></th>
                        <th scope="col"><strong>Ciudad</strong></th>
                        <th scope="col"><strong>Regi&#243;n</strong></th>
                        <th scope="col"><strong>Modificar</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        foreach ($dataDirecciones as $field) { ?>
                               <tr>
                                    <td scope="col"><?= $field->descTipoDireccion; ?></td>
                                    <td scope="col"><?= $field->calle?></td>
                                    <td scope="col"><?= $field->numeroCalle?></td>
                                    <td scope="col"><?= $field->depto?></td>
                                    <td scope="col"><?= $field->block?></td>
                                    <td scope="col"><?= $field->poblacion?></td>
                                    <td scope="col"><?= $field->comuna?></td>
                                    <td scope="col"><?= $field->ciudad?></td>
                                    <td scope="col"><?= $field->region?></td>
                                    <td scope="col"><button type="button" class="btn-sel-address btn btn-xs btn-warning" data-type-address="<?=$field->tipoDireccion?>" data-type-region="<?=$field->codRegion?>" data-type-ciudad="<?=$field->codCiudad?>" data-type-comuna="<?=$field->codComuna?>" ><i class="gi gi-upload" title="Modificar"></i></button></td>
                               </tr>
                        <?php } ?>

                    </tr>

                </tbody>
                </table>

              </div>

              <div class="tab-pane" id="tabs-phones">
                <form id="form-phones" class="form-horizontal form-bordered" method="post">
                  <table class="table">

                    <div class="form-group">

                        <div class="col-md-2">
                          <label for="typePhoneSkill">Tipo Tel&#233;fono</label>
                          <div class="input-group col-xs-9">
                            <select id="typePhoneSkill" name="typePhoneSkill" class="form-control">
                                <option value="MOVIL">MOVIL</option>
                                <option value="FIJO">FIJO</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-2">
                          <label for="usePhoneSkill">Uso Tel&#233;fono</label>
                          <div class="input-group col-xs-9">
                            <select id="usePhoneSkill" name="usePhoneSkill" class="form-control">
                                <option value="CLUB">CLUB</option>
                                <option value="CMC">CMC</option>
                                <option value="COBRANZA">COBRANZA</option>
                                <option value="LABORAL">LABORAL</option>
                                <option value="PARTICULAR">PARTICULAR</option>
                                <option value="RECADO">RECADO</option>
                                <option value="TELEFONO">TELEFONO</option>
                                <option value="MOVIL">MOVIL</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <label for="numberPhone">N&#250;mero Tel&#233;fono<span class="text-danger">*</span></label>
                          <div class="input-group col-xs-6">
                              <input type="text" id="numberPhone" name="numberPhone" class="form-control" placeholder="Número Teléfono.." maxlength="9">
                              <input type="hidden" id="hnumberPhone" >
                              <input type="hidden" id="typePhone" >
                              <input type="hidden" id="usePhone" >
                          </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="val_skill">&nbsp;</label>
                          <div class="input-group text-left">
                                <button type="submit" class="btn-update-phones btn btn-success"><i class="fa fa-arrow-right"></i> Modificar</button>
                                <button type="reset" class="btn btn-warning" onclick="Contact.addPhone();"><i class="fa fa-repeat"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>

                  </table>
                </form>

                <table class="table table-striped table-bordered" id="dataPhone">
                <thead>
                    <tr>
                        <th class="text-left"><strong>Tipo</strong></th>
                        <th class="text-left"><strong>Uso</strong></th>
                        <th class="text-left"><strong>N&#250;mero Tel&#233;fono</strong></th>
                        <th class="text-center"><strong>Estado</strong></th>
                        <th class="text-center"><strong>Modificar</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataTelefonos as $record) { ?>
                           <tr>
                                <td class="text-left"><?= $record["descTipoFono"]; ?></td>
                                <td class="text-left"><?= $record["descUso"]; ?></td>
                                <td class="text-left"><?= $record["puntoContacto"]; ?></td>
                                <td class="text-center"><?= $record["vigencia"] ; ?></td>
                                <td class="text-center"><button type="button" class="btn-sel-phones btn-xs btn-warning" data-type="<?=$record["tipoFono"];?>" data-use="<?=$record["uso"];?>"><i class="gi gi-upload" title="Modificar"></i></button></td>
                           </tr>
                    <?php } ?>
                </tbody>
                </table>


              </div>

              <div class="tab-pane" id="tabs-emails">
                <form id="form-emails" class="form-horizontal form-bordered" method="post">
                  <table class="table">
                    <div class="form-group">

                      <div class="col-sm-2">
                          <label for="typeEmailSkill">Tipo</label>
                          <div class="input-group col-xs-12">
                              <select id="typeEmailSkill" name="typeEmailSkill" class="form-control">
                                    <option value="LABORAL">LABORAL</option>
                                    <option value="PARTICULAR">PARTICULAR</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-4">
                        <label for="mailbox">Correo Electr&#243;nico<span class="text-danger">*</span></label>
                        <div class="input-group col-xs-12">
       <input type="text" id="mailbox" name="mailbox" class="form-control minusculas" placeholder="" maxlength="100">
                              <input type="hidden" id="hmailbox" >
                              <input type="hidden" id="typeEmail" >
                              <input type="hidden" id="useEmail" >
                              <input type="hidden" id="hsendMailboxSkill">
                        </div>
                      </div>

                      <div class="col-md-2">
                        <label for="sendMailboxSkill">Tipo Despacho</label>
                        <div class="input-group col-xs-12">
                          <select id="sendMailboxSkill" name="sendMailboxSkill" onchage="document.getElementById('hsendMailboxSkill').text=document.getElementById('sendMailboxSkill').value;" class="form-control">
                              <option value="">SELECCIONE TIPO DESPACHO</option>
                              <option value="FÍSICO">FÍSICO</option>
                              <option value="EMAIL">EMAIL</option>
                          </select>
                        </div>
                      </div>

                     <div class="col-sm-4 text-center">
                         <label for="commandEmail">&nbsp;</label>
                          <div class="input-group col-xs-12">
                              <button type="submit" class="btn-update-emails btn btn-success"> <i class="fa fa-arrow-right"></i> Modificar</button>
                              <button type="reset" class="btn btn-warning" onclick="Contact.initEmails();"><i class="fa fa-repeat"></i> Limpiar</button>
                          </div>
                      </div>

                    </div>

                  </table>
                </form>

                <div id="viewEmail">
                    <table class="table table-striped table-bordered" id="dataEmail">
                    <thead>
                        <tr>
                            <th class="text-center"><strong>Tipo</strong></th>
                            <th class="text-left"><strong>Correo Electr&#243;nico</strong></th>
                            <th class="text-center"><strong>Enviar EECC por Email</strong></th>
                            <th class="text-center"><strong>Estado</strong></th>
                            <th class="text-center"><strong>Modificar</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataEmails as $record) { ?>
                               <tr>
                                    <td class="text-center"><?= $record["descTipoFono"]; ?></td>
                                    <td class="text-left"><?= $record["puntoContacto"]; ?></td>
                                    <td class="text-center"><?= $record["eecc"] ; ?></td>
                                    <td class="text-center"><span class="label label-success"><?= $record["vigencia"] ; ?></span></td>
                                    <td class="text-center"><button type="button" class="btn-sel-emails btn btn-xs btn-warning" data-eecc="<?=$record["eecc"];?>" data-type="<?=$record["tipoFono"];?>" data-use="<?=$record["uso"];?>"><i class="gi gi-upload" title="Modificar"></i></button></td>
                               </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>

              </div>

          </div>

    </div>

</div>

</div>
<!-- END Page Content -->

<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/client/contact.js"></script>
<?php if ($dataError['session_empty']): ?>
<script language="javascript">
var e = document.getElementById("body-modal-session");
$('.modal-session').modal({show:true,backdrop:'static'});
</script>
<?php endif; ?>

</body>
</html>
