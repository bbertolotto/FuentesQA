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

<div class="modal-tooltip-tasa modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div id="body-modal-alert" class="modal-body text-center">
          
          <table class="table table-bordered">
            <thead class="thead-light">
              <tr>
                  <th class="text-center" colspan="2">COBROS VIGENTES</th>
              </tr>
            </thead>
            <tbody class="thead-light">
                <?php foreach ($dataParamTasa as $key=>$valor) { 
                        if($key=="tasaCompraMenor90"){ 
                            print_r('<tr><td class="text-center">Mensual Compra < 90 D&#237as</td><td class="text-center">'.$valor.'%</td></tr>');
                       }
                        if($key=="tasaCompraMayor90"){ 
                            print_r('<tr><td class="text-center">Mensual Compra >= 90 D&#237as</td><td class="text-center">'.$valor.'%</td></tr>');
                       }
                        if($key=="tasaAvanceMenor90"){ 
                            print_r('<tr><td class="text-center">Mensual Avance < 90 D&#237as</td><td class="text-center">'.$valor.'%</td></tr>');
                       }
                        if($key=="tasaAvanceMayor90"){ 
                            print_r('<tr><td class="text-center">Mensual Avance >= 90 D&#237as</td><td class="text-center">'.$valor.'%</td></tr>');
                       }
                        if($key=="tasaInteresMora"){ 
                            print_r('<tr><td class="text-center">Inter&#233;s Mora</td><td class="text-center">'.$valor.'%</td></tr>');
                       }
                        if($key=="impuestos"){ 
                            print_r('<tr><td class="text-center">Impuestos</td><td class="text-center">'.$valor.'</td></tr>');
                       }
                        if($key=="mantencionMensual"){ 
                            print_r('<tr><td class="text-center">Mantenci&#243;n Mensual</td><td class="text-center">'.$valor.'</td></tr>');
                       }

                ?>
                <?php } ?>
            </tbody>

          </table>
      </div>
    </div>
  </div>
</div>

