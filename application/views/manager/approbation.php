<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<?php $this->load->view('head'); ?>

<div id="page-content">

    <ul class="breadcrumb breadcrumb-top">
        <li>Flujos comerciales</li>
        <li>S&#250;per Avances</li>
        <li>Jefe de Oficina</li>
        <li><a href="<?=base_url()?>manager/search">Buscar</a></li>
        <li><a href="<?=base_url()?>manager/documents">Documentos</a></li>
        <li>Autorizaci&#243;n</li>
        <li><a href="<?=base_url()?>manager/valid">Liquidaci&#243;n</a></li>
    </ul>
    <!-- End breadcrumb -->
    <div class="row" id="areaPrint">
      <div class="col-md-12">
          <div class="block">
              <div class="block-title">
                  <h2><strong>Autorizaci&#243;n Oficina</strong></h2>
              </div>

              <form id="form-valid" method="post" class="form-horizontal form-bordered form-control-borderless">

                <fieldset><legend><i class="fa fa-angle-right"></i><strong>Identificaci&#243;n Cliente</strong></legend></fieldset>
                <div class="form-group hidden-print">
                    <label class="col-md-2 col-lg-2 control-label">N&#250;mero RUT</label>
                    <div class="col-md-2 col-lg-2 text-right">
                        <div class="input-group">
                            <label class="control-label"><?php echo (isset($dataRequest['nroRut']) ? $dataRequest['nroRut']."-".$dataRequest['dgvRut'] : MSG_FIELD_EMPTY); ?></label>
                        </div>
                    </div>
                    <label class="col-md-2 control-label ">Nombre</label>
                    <div class="col-md-4">
                        <div class="input-group col-xs-8">
                            <label class="control-label"><?php echo (isset($dataRequest['nameClient']) ? $dataRequest['nameClient'] : MSG_FIELD_EMPTY); ?></label>
                        </div>
                    </div>
                    <label class="col-md-1 control-label ">Nº</label>
                    <div class="col-md-1">
                        <div class="input-group col-xs-8">
                            <label class="control-label"><?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : MSG_FIELD_EMPTY); ?></label>
                            <input type="hidden" id="idDocument" value="<?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : 0); ?>">
                        </div>
                    </div>
                </div>

                <table class="table visible-print-block">
                    <tr>
                        <td>N&#250;mero RUT</td>
                        <td><?php echo (isset($dataRequest['nroRut']) ? $dataRequest['nroRut']."-".$dataRequest['dgvRut'] : MSG_FIELD_EMPTY); ?></td>
                        <td>Nombre</td>
                        <td><?php echo (isset($dataRequest['nameClient']) ? $dataRequest['nameClient'] : MSG_FIELD_EMPTY); ?></td>
                        <td>Nº</td>
                        <td><?php echo (isset($dataRequest['idDocument']) ? $dataRequest['idDocument'] : MSG_FIELD_EMPTY); ?></td>
                    </tr>
                </table>

                <div class="col-sm-12 col-lg-12">
                <div class="block">
                    <div class="block-title">
                        <h2><i class="gi gi-charts"></i> Negociaci&#243;n con Cliente</h2>
                    </div>
                    <table class="table table-sm table-striped table-bordered">
                        <tbody>
                            <tr>
                                <td >
                                    <strong>N&#250;mero Cuotas</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['plazoDeCuota']) ? $dataRequest['plazoDeCuota'] : MSG_FIELD_EMPTY); ?></td>
                                <td >
                                    <strong>Cuotas Diferidas</strong>
                                </td>

                                <td><?php echo (isset($dataRequest['mesesDiferidos']) ? $dataRequest['mesesDiferidos'] : MSG_FIELD_EMPTY); ?></td>

                                <td >
                                    <strong>Primer Vencimiento</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['fechaPrimerVencimiento']) ? $dataRequest['fechaPrimerVencimiento'] : MSG_FIELD_EMPTY); ?></td>
                                <td >
                                    <strong>Tasa</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['tasaDeInteresMensual']) ? $dataRequest['tasaDeInteresMensual'] : MSG_FIELD_EMPTY); ?></td>
                            </tr>
                            <tr>
                                <td>
                                  <strong>Valor Cuota</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['valorDeCuota']) ? $dataRequest['valorDeCuota'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Monto Bruto</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['montoBruto']) ? $dataRequest['montoBruto'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Monto L&#237;quido</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['montoLiquido']) ? $dataRequest['montoLiquido'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                    <strong>Costo Total</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['costoTotalDelCredito']) ? $dataRequest['costoTotalDelCredito'] : MSG_FIELD_EMPTY); ?></td>
                            </tr>
                            <tr>
                                <td>
                                  <strong>Impuesto</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['impuestos']) ? $dataRequest['impuestos'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Comisi&#243;n</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['comision']) ? $dataRequest['comision'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>CAE</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['cargaAnualEquivalente']) ? $dataRequest['cargaAnualEquivalente'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Oferta</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['glosatipoOferta']) ? $dataRequest['glosatipoOferta'] : MSG_FIELD_EMPTY); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Hospitalización</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['costoTotalSeguro1']) ? $dataRequest['costoTotalSeguro1'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Desgravamen</strong>
                                </td>
                                <td>$<?php echo (isset($dataRequest['costoTotalSeguro2']) ? $dataRequest['costoTotalSeguro2'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Forma de Pago</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['glosaModoEntrega']) ? $dataRequest['glosaModoEntrega'] : MSG_FIELD_EMPTY); ?></td>
                                <td>
                                  <strong>Modo Atenci&oacute;n</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['modalidadVenta']) ? $dataRequest['modalidadVenta'] : MSG_FIELD_EMPTY); ?></td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>Estado Cotizaci&#243;n</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['glosaEstado']) ? $dataRequest['glosaEstado'] : "-"); ?></td>
                                <td>
                                  <strong>Estado Enlace</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['glosaEnlace']) ? $dataRequest['glosaEnlace'] : "-"); ?></td>
                                <td>
                                  <strong>Oficina Origen</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['sucursalOrigen']) ? $dataRequest['sucursalOrigen'] : "-"); ?></td>
                                <td>
                                  <strong>Oficina Destino</strong>
                                </td>
                                <td><?php echo (isset($dataRequest['sucursalDestino']) ? $dataRequest['sucursalDestino'] : "-"); ?></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
              </div>


              <div class="col-sm-12 col-lg-12">
              <div class="block">
                  <div class="block-title">
                      <h2><i class="fa fa-check"></i> Antecedentes de Documentos</h2>
                  </div>
                  <table class="table table-striped table-borderless table-vcenter">
                      <tbody>
                          <tr>
                              <td class="text-right " >
                                  <strong>
                                    <i class="fa fa-check"></i>Fotocopia CI con huella dactilar y firma cliente</strong>
                              </td>
                              <td class="visible-print-block yesnoRutvalue">SI</td>
                              <td class="text-left hidden-print">
                                  <label>Si</label>
                                  <label class="switch switch-success hidden-print"><input id="yesnoRut" name="yesnoRut" type="radio" class="yesnoRut" value="1"><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success hidden-print"><input id="yesnoRut" name="yesnoRut" type="radio" class="yesnoRut" checked value="0"><span></span></label>
                              </td>
                              <td class="text-right" >
                                  <strong>
                                    <i class="fa fa-check"></i>Contrato de Súper Avance firma y huella dactilar</strong>
                              </td>
                              <td class="visible-print-block yesnoContractvalue">SI</td>
                              <td class="text-left hidden-print">
                                  <label>Si</label>
                                  <label class="switch switch-success hidden-print"><input id="yesnoContract" name="yesnoContract" type="radio" class="hidden-print" value="1" ><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success hidden-print"><input id="yesnoContract" name="yesnoContract" type="radio" checked class="hidden-print" value="0"><span></span></label>
                              </td>
                          </tr>
                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="fa fa-check"></i>Hoja de Resumen, con huella dactilar y firma de Cliente.</strong>
                              </td>
                              <td class="visible-print-block yesnoResumvalue">SI</td>
                              <td class="text-left hidden-print">
                                  <label>Si</label>
                                  <label class="switch switch-success hidden-print"><input id="yesnoResum" name="yesnoResum" type="radio" value="1" ><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success hidden-print"><input id="yesnoResum" name="yesnoResum" type="radio" checked value="0"><span></span></label>
                              </td>
                              <td class="text-right" >
                                  <strong>
                                    <i class="fa fa-check"></i>Comprobante Domicilio (solo el cambio direcci&#243;n)</strong>
                              </td>
                              <td class="visible-print-block yesnoAddresvalue">SI</td>
                              <td class="text-left hidden-print">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesnoAddres" name="yesnoAddres" type="radio" value="1" ><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="yesnoAddres" name="yesnoAddres" type="radio" value="0" checked><span></span></label>
                              </td>
                          </tr>
                          <tr>
                              <td class="text-right" >
                                  <strong>
                                    <i class="fa fa-check"></i>Propuesta SEGUROS, con huella dactilar y firma de cliente (ACEPTA 1 o más)</strong>
                              </td>
                              <td class="visible-print-block yesnoSecure1value">SI</td>
                              <td class="text-left hidden-print">
                                  <label>Si</label>
                                  <label class="switch switch-success"><input id="yesnoSecure1" name="yesnoSecure1" type="radio" value="1" ><span></span></label>
                                  <label>No</label>
                                  <label class="switch switch-success"><input id="yesnoSecure1" name="yesnoSecure1" type="radio"  value="0" checked><span></span></label>
                              </td>
                              <td colspan=2></td>
                          </tr>

                      </tbody>
                  </table>
              </div>
            </div>

            <div class="col-sm-12 col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-check"></i> Proceso An&#225;lisis y curse Operaci&#243;n de S&#250;per Avance</h2>
                </div>
                <table class="table table-striped table-borderless table-vcenter">
                    <tbody>
                        <tr>
                            <td class="text-right" style="width:30%" >
                                <strong>
                                  <i class="fa fa-check"></i>Validaci&#243;n de firma en CI vs documento S&#250;per Avance</strong>
                            </td>
                            <td class="visible-print-block yesnoFirmavalue">SI</td>
                            <td class="text-left hidden-print" style="width:20%">
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoFirma" name="yesnoFirma" type="radio" value="1" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoFirma" name="yesnoFirma" type="radio" value="0" checked><span></span></label>
                            </td>
                            <td class="text-right" style="width:30%">
                                <strong>
                                  <i class="fa fa-check"></i>Print identificaci&#243;n huella dactilar Autentia</strong>
                            </td>
                            <td class="visible-print-block yesnoAutentiavalue">SI</td>
                            <td class="text-left hidden-print" style="width:20%">
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoAutentia" name="yesnoAutentia" type="radio" value="1" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoAutentia" name="yesnoAutentia" type="radio" value="0" checked><span></span></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" >
                                <strong>
                                  <i class="fa fa-check"></i>Validar direcci&#243;n del cliente (print si se mantiene)</strong>
                            </td>
                            <td class="visible-print-block yesnoDirect1value">SI</td>
                            <td class="text-left hidden-print">
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoDirect1" name="yesnoDirect1" type="radio" value="1" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoDirect1" name="yesnoDirect1" type="radio" value="0" checked><span></span></label>
                            </td>
                            <td class="text-right" >
                                <strong>
                                  <i class="fa fa-check"></i>Validar direcci&#243;n del cliente (solicitar Comprobante de Domicilio y realizar cambio en plataforma)</strong>
                            </td>
                            <td class="visible-print-block yesnoDirect2value">SI</td>
                            <td class="text-left hidden-print">
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoDirect2" name="yesnoDirect2" type="radio" value="1" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoDirect2" name="yesnoDirect2" type="radio" value="0" checked><span></span></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" >
                                <strong>
                                  <i class="fa fa-check"></i>Actualizar email y tel&#233;fono de contacto (print de pantalla)</strong>
                            </td>
                            <td class="visible-print-block yesnoEmailvalue">SI</td>
                            <td class="text-left hidden-print">
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoEmail" name="yesnoEmail" type="radio" value="1" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoEmail" name="yesnoEmail" type="radio" value="0" checked><span></span></label>
                            </td>
                            <td class="text-right" >
                                <strong>
                                  <i class="fa fa-check"></i>Acreditaci&#243;n de domicilio seg&#250;n politica de cr&#233;dito (documento autorizado por politica de Verificaciones)</strong>
                            </td>
                            <td class="visible-print-block yesnoDirect3value">SI</td>
                            <td class="text-left hidden-print" nowrap>
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoDirect3" name="yesnoDirect3" type="radio" value="1" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoDirect3" name="yesnoDirect3" type="radio" value="0" checked><span></span></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" >
                                <strong>
                                  <i class="fa fa-check"></i>Validaci&#243;n tasa de inter&#233;s sea la misma publicada por pizarras, seg&#250;n tramo de otorgamiento</strong>
                            </td>
                            <td class="visible-print-block yesnoTasavalue">SI</td>
                            <td class="text-left hidden-print" nowrap>
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoTasa" name="yesnoTasa" type="radio" value="1" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoTasa" name="yesnoTasa" type="radio" value="0" checked><span></span></label>
                            </td>
                            <td class="text-right" >
                                <strong>
                                  <i class="fa fa-check"></i>Validar si el curse es con pago diferido la informaci&#243;n contenida en contrato, hoja de resumen y voucher debe coincidir</strong>
                            </td>
                            <td class="visible-print-block yesnoDiferidovalue">SI</td>
                            <td class="text-left hidden-print">
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoDiferido" name="yesnoDiferido" value="1" type="radio" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoDiferido" name="yesnoDiferido" value="0" type="radio" checked><span></span></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" >
                                <strong>
                                  <i class="fa fa-check"></i>Propuesta SEGUROS SAV, verificar ingreso de datos</strong>
                            </td>
                            <td class="visible-print-block yesnoSecure2value">SI</td>
                            <td class="text-left hidden-print" nowrap>
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoSecure2" name="yesnoSecure2" value="1" type="radio" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoSecure2" name="yesnoSecure2" value="0" type="radio" checked><span></span></label>
                            </td>
<?php if($dataRequest['tipoOferta']=="PA"):?>
                            <td class="text-right" >
                                <strong>
                                  <i class="fa fa-check"></i>Acreditaci&#243;n de empleabilidad</strong>
                            </td>
                            <td class="visible-print-block yesnoEmpleovalue">SI</td>
                            <td class="text-left hidden-print">
                                <label>Si</label>
                                <label class="switch switch-success"><input id="yesnoEmpleo" name="yesnoEmpleo" type="radio" value="1" ><span></span></label>
                                <label>No</label>
                                <label class="switch switch-success"><input id="yesnoEmpleo" name="yesnoEmpleo" type="radio" value="0" checked><span></span></label>
                            </td>
<?php else:?>
                            <td colspan="2"> </td>
                            <input id="yesnoEmpleo" name="yesnoEmpleo" type="hidden" value="1" >
                            <input id="yesnoEmpleo" name="yesnoEmpleo" type="hidden" value="0">
<?php endif;?>
                        </tr>

                    </tbody>
                </table>
            </div>
          </div>

          <div class="form-group text-center" id="buttonHide">
              <div class="col-xs-12">
                <button type="button" class="btn-action btn btn-success" data-target="save" ><i class="fa fa-check"></i> Autorizar SAV</button>
                <button style="display:none;" type="button" class="btn-action btn btn-success" data-target="linked" ><i class="fa fa-check"></i> Autorizar Enlace</button>
                <button style="display:none;" type="button" class="btn-action btn btn-info" data-target="pending" ><i class="fa fa-refresh"></i> Pendiente</button>
                <button type="button" class="btn-action btn btn-danger" data-target="deny" ><i class="fa fa-times"></i> Rechazar</button>
                <button type="button" class="btn-action btn btn-info " data-target="print" ><i class="fa fa-print"></i> Imprimir</button>
                <button type="button" class="btn-action btn btn-info " data-target="cancel" ><i class="fa fa-bolt"></i> Cancelar</button>
              </div>
          </div>

          </div>

        </div>
        </form>
    </div>
    <!--End Block principal-->
<input type="hidden" id="typeAction" value="">
<input type="hidden" id="estadoEnlace" value="<?php echo (isset($dataRequest['estadoEnlace']) ? $dataRequest['estadoEnlace'] : ""); ?>">
<input type="hidden" id="nroRut" value="<?= $dataRequest['nroRut'].'-'.$dataRequest['dgvRut'] ?>">
</div>
<!-- END Page Content -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('ModalAlert'); ?>
<?php $this->load->view('ModalCreate'); ?>
<?php $this->load->view('ModalValid'); ?>

<script src="/js/pages/Alert.js"></script>
<script src="/js/TeknodataSystems.js"></script>
<script src="/js/manager/Approbation.js"></script>
<script type="text/javascript">


    $(document).ready(function()
    {



$("input[name=yesnoRut]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoRutvalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoRutvalue").html("NO");
      }
});

$("input[name=yesnoContract]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoContractvalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoContractvalue").html("NO");
      }
});


$("input[name=yesnoResum]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoResumvalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoResumvalue").html("NO");
      }
});

$("input[name=yesnoAddres]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoAddresvalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoAddresvalue").html("NO");
      }
});


$("input[name=yesnoSecure1]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoSecure1value").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoSecure1value").hmtl("NO");
      }
});


$("input[name=yesnoFirma]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoFirmavalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoFirmavalue").html("NO");
      }
});


$("input[name=yesnoDirect1]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoDirect1value").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoDirect1value").html("NO");
      }
});


$("input[name=yesnoEmail]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoEmailvalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoEmailvalue").html("NO");
      }
});


$("input[name=yesnoEmpleo]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoEmpleovalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoEmpleovalue").html("NO");
      }
});

$("input[name=yesnoDiferido]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoDiferidovalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoDiferidovalue").html("NO");
      }
});


$("input[name=yesnoAutentia]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoAutentiavalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoAutentiavalue").html("NO");
      }
});


$("input[name=yesnoDirect2]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoDirect2value").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoDirect2value").html("NO");
      }
});


$("input[name=yesnoDirect3]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoDirect3value").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoDirect3value").html("NO");
      }
});

$("input[name=yesnoTasa]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoTasavalue").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoTasavalue").html("NO");
      }
});

$("input[name=yesnoSecure2]:radio").click(function() {
      if($(this).attr("value")=="1") {
          $(".yesnoSecure2value").html("SI");
      }
      if($(this).attr("value")=="0") {
         $(".yesnoSecure2value").html("NO");
      }
});


if($("[name='yesnoSecure2'][checked]").attr("value")=="1"){
    $(".yesnoSecure2value").html("SI");
}
if($("[name='yesnoSecure2'][checked]").attr("value")=="0"){
    $(".yesnoSecure2value").html("NO");
}

if($("[name='yesnoTasa'][checked]").attr("value")=="1"){
    $(".yesnoTasavalue").html("SI");
}
if($("[name='yesnoTasa'][checked]").attr("value")=="0"){
    $(".yesnoTasavalue").html("NO");
}

if($("[name='yesnoDirect2'][checked]").attr("value")=="1"){
    $(".yesnoDirect2value").html("SI");
}
if($("[name='yesnoDirect2'][checked]").attr("value")=="0"){
    $(".yesnoDirect2value").html("NO");
}

if($("[name='yesnoDirect2'][checked]").attr("value")=="1"){
    $(".yesnoDirect2value").html("SI");
}
if($("[name='yesnoDirect2'][checked]").attr("value")=="0"){
    $(".yesnoDirect2value").html("NO");
}

if($("[name='yesnoDirect3'][checked]").attr("value")=="1"){
    $(".yesnoDirect3value").html("SI");
}
if($("[name='yesnoDirect3'][checked]").attr("value")=="0"){
    $(".yesnoDirect3value").html("NO");
}


if($("[name='yesnoAutentia'][checked]").attr("value")=="1"){
    $(".yesnoAutentiavalue").html("SI");
}
if($("[name='yesnoAutentia'][checked]").attr("value")=="0"){
    $(".yesnoAutentiavalue").html("NO");
}


if($("[name='yesnoDiferido'][checked]").attr("value")=="1"){
    $(".yesnoDiferidovalue").html("SI");
}
if($("[name='yesnoDiferido'][checked]").attr("value")=="0"){
    $(".yesnoDiferidovalue").html("NO");
}


if($("[name='yesnoEmpleo'][checked]").attr("value")=="1"){
    $(".yesnoEmpleovalue").html("SI");
}
if($("[name='yesnoEmpleo'][checked]").attr("value")=="0"){
    $(".yesnoEmpleovalue").html("NO");
}


if($("[name='yesnoEmail'][checked]").attr("value")=="1"){
    $(".yesnoEmailvalue").html("SI");
}
if($("[name='yesnoEmail'][checked]").attr("value")=="0"){
    $(".yesnoEmailvalue").html("NO");
}

if($("[name='yesnoDirect1'][checked]").attr("value")=="1"){
    $(".yesnoDirect1value").html("SI");
}
if($("[name='yesnoDirect1'][checked]").attr("value")=="0"){
    $(".yesnoDirect1value").html("NO");
}

if($("[name='yesnoFirma'][checked]").attr("value")=="1"){
    $(".yesnoFirmavalue").html("SI");
}
if($("[name='yesnoFirma'][checked]").attr("value")=="0"){
    $(".yesnoFirmavalue").html("NO");
}

if($("[name='yesnoFirma'][checked]").attr("value")=="1"){
    $(".yesnoFirmavalue").html("SI");
}
if($("[name='yesnoFirma'][checked]").attr("value")=="0"){
    $(".yesnoFirmavalue").html("NO");
}

if($("[name='yesnoSecure1'][checked]").attr("value")=="1"){
    $(".yesnoSecure1value").html("SI");
}
if($("[name='yesnoSecure1'][checked]").attr("value")=="0"){
    $(".yesnoSecure1value").html("NO");
}

if($("[name='yesnoAddres'][checked]").attr("value")=="1"){
    $(".yesnoAddresvalue").html("SI");
}
if($("[name='yesnoAddres'][checked]").attr("value")=="0"){
    $(".yesnoAddresvalue").html("NO");
}

if($("[name='yesnoRut'][checked]").attr("value")=="1"){
    $(".yesnoRutvalue").html("SI");
}
if($("[name='yesnoRut'][checked]").attr("value")=="0"){
    $(".yesnoRutvalue").html("NO");
}

if($("[name='yesnoContract'][checked]").attr("value")=="1"){
    $(".yesnoContractvalue").html("SI");
}
if($("[name='yesnoContract'][checked]").attr("value")=="0"){
    $(".yesnoContractvalue").html("NO");
}

if($("[name='yesnoResum'][checked]").attr("value")=="1"){
    $(".yesnoResumvalue").html("SI");
}
if($("[name='yesnoResum'][checked]").attr("value")=="0"){
    $(".yesnoResumvalue").html("NO");
}


     });
</script>
</body>
</html>
