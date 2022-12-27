<style>
.table .thead-light th {
  color: #000000;
  background-color: #EEEEDD;
  border-color: #000000;
}
.table .thead-light tr {
  color: #000000;
  background-color: #C0C0C0;
  border-color: #000000;
}
</style>

<div class="modal-tooltip-modalidad modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div id="body-modal-alert" class="modal-body text-center">
          
          <table class="table table-bordered">
            <thead class="thead-light">
              <tr>
                  <th class="text-center">MODALIDAD</th>
              </tr>
            </thead>
            <tbody class="thead-light">
                <?php foreach ($dataParamAdquiriente as $key) { ?>
                  <tr>
                    <td class="text-center"><?= trim($key["desModalidad"])?></td>
                  </tr>
                <?php } ?>
            </tbody>

          </table>
      </div>
    </div>
  </div>
</div>

