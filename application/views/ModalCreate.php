<div id="modal-request" class="modal-request modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

      <div id="body-modal-request" class="modal-body text-center">
        <p><div id="titleRequest"></div></p>

        <div id="htmlRequest">
        </div>

        <div class="form-group">
            <div class="col-xs-12">
              <button type="button" id="btn-accept-request" class="btn-modal-request btn btn-danger"  data-target="accept" data-dismiss="modal"><i class="fa fa-share-alt"></i> Aceptar </button>
              <button type="button" id="btn-cancel-request" class="btn-modal-request btn btn-warning" data-target="cancel" data-dismiss="modal"><i class="fa fa-reset"></i> Cancelar</button>
            </div>
        </div>

        <div class="modal-footer text-center">
        </div>
    </div>
  </div>
</div>
</div>

<div id="modal-beneficiary" class="modal-beneficiary modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><strong><?php echo $this->lang->line('text_title_header'); ?></strong></h4>
      </div>

      <div id="body-modal-beneficiary" class="modal-body text-center">

        <div id="beneficiary">
          <div class="block">
            <div class="block-title">
              <div class="block-options pull-right">
                  <!--a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Settings"><i class="gi gi-cogwheel"></i></a-->
              </div>
              <h2><strong>Beneficiarios Seguro Vida y Desgravamen</strong> Cliente</h2>
            </div>

          <form name="form-beneficiary" id="form-beneficiary" method="post" class="form-horizontal form-bordered form-control-borderless">
          <div class="form-group text-center">
              <div class="col-md-4 text-left">
                  <label for="masked_rut_beneficiary">Rut <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" id="masked_rut_beneficiary" name="masked_rut_beneficiary" class="form-control text-center" onkeypress="return Teknodata.masked_onlyRut(event);" onkeyup="Teknodata.masked_nroRut(this);">
                  </div>
              </div>
              <div class="col-md-4 text-left">
                  <label for="nameBeneficiary">Nombres <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" id="nameBeneficiary" name="nameBeneficiary" class="form-control text-left" onKeyUp="this.value=this.value.toUpperCase();" maxlength="30" data-toggle="tooltip" data-placement="top" title="Nombre Beneficiario">
                  </div>
              </div>
              <div class="col-md-4 text-left">
                  <label for="lastFatherBeneficiary">Apellido Paterno <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" id="lastFatherBeneficiary" name="lastFatherBeneficiary" class="form-control text-left" onKeyUp="this.value=this.value.toUpperCase();" maxlength="40" data-toggle="tooltip" data-placement="top" title="Apellido Beneficiario">
                  </div>
              </div>
              <div class="col-md-4 text-left">
                  <label for="lastMotherBeneficiary">Apellido Materno <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" id="lastMotherBeneficiary" name="lastMotherBeneficiary" class="form-control text-left" onKeyUp="this.value=this.value.toUpperCase();" maxlength="40" data-toggle="tooltip" data-placement="top" title="Apellido Beneficiario">
                  </div>
              </div>
              <div class="col-md-4 text-left">
                  <label for="relationBeneficiary">Parentesco <span class="text-danger">*</span></label>
                  <select name="relationBeneficiary" id="relationBeneficiary" class="form-control" style="width:160px;">
                      <?php foreach (listBeneficiaries() as $key) { ?>
                          <option style="width:150px" value="<?= $key->NAME ?>"><?= $key->NAME ?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="col-md-4 text-left">
                  <label for="percentBeneficiary">Porcentaje <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" id="percentBeneficiary" name="percentBeneficiary" class="form-control text-center" maxlength="3" onfocus="this.value = this.value.replace(/[.-]/g, '').replace(/[^0-9\.]/g, '');" onblur="this.value = this.value.replace(/[.-]/g, '').replace(/[^0-9\.]/g, ''); this.value = new Intl.NumberFormat('de-DE').format(this.value);" data-toggle="tooltip" data-placement="top" title="Porcentaje Asignaci&#243;n">
                  </div>
              </div>

              <div class="col-md-4 text-left">
                  <label for="percentBeneficiary">Contacto <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" id="contactBeneficiary" name="contactBeneficiary" class="form-control text-center" maxlength="9" data-toggle="tooltip" data-placement="top" title="Teléfono Contacto">
                  </div>
              </div>

              <div class="col-md-4 ">
                  <label for="addBeneficiary">&nbsp;</label>
                  <div class="input-group">
                    <button type="button" id="addBeneficiary" name="addBeneficiary" data-method="POST" data-type="JSON" data-url="/advance/put_Beneficiary" class="btn btn-success">Agregar</button>
                  </div>
              </div>
          </div>

          <table id="dataBeneficiary" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>RUT</th>
                <th>Nombres</th>
                <th>Paterno</th>
                <th>Materno</th>
                <th>Parentesco</th>
                <th>Porcentaje</th>
                <th>Contacto</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody>
              <tr>
              </tr>
            </tbody>
          </table>

          <div class="form-group">
              <div class="col-xs-12">
                <button type="button" id="saveBeneficiary" class="btn-modal-request btn btn-warning" data-target="cancel" data-dismiss="modal"><i class="fa fa-reset"></i> Confirmar Beneficiarios</button>
              </div>
          </div>

        </form>

         <br>
        </div>
       </div>

    </div>
  </div>
</div>
</div>
