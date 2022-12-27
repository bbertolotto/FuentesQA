<style>
    {
        font-family:Arial;
    }

</style>
<page>
    <table style="font-size: 16px; width: 100%; padding-bottom: 15px;">
        <tr style="width: 100%; ">
            <td style="padding-top: 10px; width: 100%; text-align: center; font-family:Arial;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;">CONTRATO SÚPER AVANCE - TARJETA DE CRÉDITO CRUZ VERDE</td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%; border: 1px solid black; padding-top: 4px; padding-bottom: 4px;" border="1">
        <tr style="width: 100%; ">
            <td style="width: 50%; ">NOMBRE CLIENTE(A) (TITULAR TARJETA)</td>
            <td style="width: 50%; text-align: right;"><?= $datos["nameClient"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">RUT</td>
            <td style="width: 50%; text-align: right;" ><?= $datos["nroRut"] ."-". $datos["dgvRut"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">TARJETA DE CRÉDITO CRUZ VERDE N°</td>
            <td style="width: 50%; text-align: right;" ><?php
            $pan = str_replace("-","",$datos["pan"]); $pan = substr_replace($pan, "************", 0, 12 ); echo $pan;?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">CORREO ELECTRÓNICO</td>
            <td style="width: 50%; text-align: right;" ><?= $datos["email"]?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; "><table style="padding-top:5px;"><tr><td>DOMICILIO</td></tr></table></td>
            <td style=" width: 50%; text-align: right;" ><?= $datos["domicilio"]?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">SUCURSAL OTORGAMIENTO</td>
            <td style=" width: 50%; text-align: right;" ><?= $datos["glosaCodLocal"]?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%;">MODALIDAD DE VENTA</td>
            <td style=" width: 50%; text-align: right;" ><?= $datos["modalidadVenta"]?></td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  padding-top: 10px; padding-bottom: 10px;">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; padding-top: 10px; text-align: justify;"><b>1.- </b><span>El (la) CLIENTE(A) individualizado(a) precedentemente, contrata con Solventa Tarjetas S.A.,
RUT N° 96.776.000-5, con domicilio en Av. El Salto 4875, piso 5, Huechuraba, un "SÚPER
AVANCE" asociado a su Tarjeta de Crédito Cruz Verde de acuerdo a las condiciones siguientes:</span></td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%; vertical-align: middle; padding-top: 4px; padding-bottom: 4px;" border="1">
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">FECHA Y HORA OTORGAMIENTO</td>
            <td style="width: 20%; text-align: right;"><?= $datos["fechahora"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">MONTO BRUTO SÚPER AVANCE</td>
            <td style="width: 20%; text-align: right;">$<?= $datos["montoBruto"]?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">MONTO LÍQUIDO SÚPER AVANCE</td>
            <td style="width: 20%; text-align: right;">$<?=  $datos["montoLiquido"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">NÚMERO DE CUOTAS</td>
            <td style="width: 20%; text-align: right;"><?= $datos["plazoDeCuota"]?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">VALOR CUOTA</td>
            <td style="width: 20%; text-align: right;">$<?= $datos["valorDeCuota"]?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">FECHA PRIMER VENCIMIENTO</td>
            <td style="width: 20%; text-align: right;"><?= $datos["fechaPrimerVencimiento"]?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">TASA DE INTERÉS MENSUAL <br>(Se encuentra incorporada en el VALOR CUOTA).</td>
            <td style="width: 20%; text-align: right;"><table style="padding-top:7px; padding-right: 0px;"><tr><td style="text-align: right;"><?= str_replace(".",",",$datos["tasaDeInteresMensual"])?></td></tr></table></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">PERÍODO DE GRACIA  <br>(Se aplican intereses por este período ya incorporados en el VALOR CUOTA).</td>
            <td style="width: 20%; text-align: right;"><table style="padding-top:7px; padding-right: 0px;"><tr><td style="text-align: right;"><?= $datos["mesesDiferidos"]?></td></tr></table></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">IMPUESTO TIMBRE Y ESTAMPILLA</td>
            <td style="width: 20%; text-align: right;"><table><tr><td style="text-align: right;">$<?=$datos["impuestos"]?></td></tr></table></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">COMISIÓN DE SÚPER AVANCE <br>(Se cobra separadamente y se refleja en el Estado de Cuenta)</td>
            <td style="width: 20%; text-align: right;"><table style="padding-top:11px; padding-right: 0px;"><tr><td style="text-align: right;">$<?= $datos["comision"]?></td></tr></table></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">DESGRAVAMEN  <br>(Contratación voluntaria. Valor total prima se encuentra incorporado
en monto SÚPER AVANCE)</td>
            <td style="width: 20%; text-align: right;"><table style="padding-top:11px; padding-right: 0px; "><tr><td style="text-align: right;">$<?= $datos["costoTotalSeguro2"]?></td></tr></table></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">HOSPITALIZACIÓN POR ACCIDENTES  <br>(Contratación voluntaria. Valor total prima se encuentra incorporado en monto SÚPER AVANCE)</td>
            <td style="width: 20%; text-align: right;"><table style="padding-top:11px; padding-right: 0px; "><tr><td style="text-align: right;">$<?= $datos["costoTotalSeguro1"]?></td></tr></table></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">CAE</td>
            <td style="width: 20%; text-align: right;"><?= str_replace(".",",",$datos["cargaAnualEquivalente"])?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 80%; text-align: left;">COSTO TOTAL</td>
            <td style="width: 20%; text-align: right;">$<?= $datos["costoTotalDelCredito"]?></td>
        </tr>
    </table>
    <br pagebreak="true"/>
</page>
<page>
    <table style="font-size: 12px; width: 100%; padding-top: 10px; padding-bottom: 10px;">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; padding-top: 10px; text-align: justify;"><span>Se deja expresa constancia que a solicitud de el (la) CLIENTE(A), la entrega material del monto líquido del SÚPER AVANCE, se efectuará en la forma siguiente:</span></td>
        </tr>
    </table>
<?php if($datos["modoEntrega"]=="TEF"):?>
    <table style="font-size: 12px; width: 100%;  padding-bottom: 5px;" border="1">
        <tr style="width: 100%; ">
            <td width="22%" style="padding-left: 30px; padding-top: 10px; text-align: center;" ><b>MODO ENTREGA</b></td>
            <td width="20%" style="padding-left: 30px; padding-top: 10px; text-align: center;" ><b>TIPO CUENTA</b></td>
            <td width="22%" style="padding-left: 30px; padding-top: 10px; text-align: center;" ><b>NÚMERO CUENTA</b></td>
            <td width="19%" style="padding-left: 30px; padding-top: 10px; text-align: center;" ><b>BANCO</b></td>
            <td width="17%" style="padding-left: 30px; padding-top: 10px; text-align: center;" ><b>MONTO</b></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><?= $datos["glosaModoEntrega"] ?></td>
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><?= $datos["glosaCuenta"] ?></td>
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><?= $datos["numeroCuenta"] ?></td>
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><?= $datos["glosaBanco"] ?></td>
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;">$<?= $datos["montoLiquido"] ?></td>
        </tr>
    </table>
<?php else:?>
    <table style="font-size: 12px; width: 100%; padding-bottom: 5px;" border="1">
        <tr style="width: 100%; ">
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><b>MODO ENTREGA</b></td>
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><b>LUGAR ENTREGA</b></td>
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><b>MONTO</b></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><?= $datos["glosaModoEntrega"] ?></td>
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;"><?= $datos["glosaCodLocal"] ?></td>
            <td style="padding-left: 30px; padding-top: 10px; text-align: center;">$<?= $datos["montoLiquido"] ?></td>
        </tr>
    </table>
<?php endif;?>
    <table style="font-size: 12px; width: 100%; padding-top:5px; ">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>2.- </b>En el evento que el (la) CLIENTE(A) hubiere optado por la modalidad de transferencia bancaria, ésta se efectuará única y exclusivamente en la cuenta de la cual sea titular, no pudiendo realizarse en cuentas de terceros. Se deja constancia que la transferencia se verificará dentro de las 48 horas hábiles siguientes a la fecha de este instrumento. De este modo, el cliente declara que los datos que entregó relativos a la cuenta son fidedignos y que él es el titular de la misma. En consecuencia libera a Solventa Tarjetas S.A. de toda responsabilidad que pudiere generarse ante cualquier error o perjuicio directo o indirecto que afecte al cliente con motivo de la referida transferencia bancaria.</td></tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>3.- </b>Se deja constancia que el SÚPER AVANCE constituye una línea de crédito extraordinaria y adicional a la línea de crédito que ya posee en su Tarjeta de Crédito Cruz Verde. En atención a ello, el (la) CLIENTE(A), acepta el otorgamiento de la referida línea de crédito extraordinaria, para efecto de cursar el SÚPER AVANCE y autorizar que las cuotas sean cobradas en los respectivos estados de cuenta.</td></tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>4.- </b>El otorgamiento del SÚPER AVANCE no modifica las estipulaciones del CONTRATO AFILIACIÓN SISTEMA TARJETA CRÉDITO CRUZ VERDE Y APERTURA LÍNEA DE CRÉDITO las cuales rigen íntegramente. En consecuencia, ante el incumplimiento en el pago íntegro y oportuno de una cualquiera de las cuotas pactadas, Solventa Tarjetas S.A. podrá ejercer una cualquiera o todas las acciones que el citado Contrato le faculta, entre otras, hacer exigible anticipadamente el pago de todo lo adeudado, como si fuera de plazo vencido, más intereses, reajustes, gastos de cobranza, costas y demás conceptos que adeude el (la) CLIENTE(A) conforme lo establece la normativa vigente.</td></tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>5.- </b>El (la) CLIENTE(A) reconoce y acepta que fue previamente informado en forma clara y detallada todas y cada una de las condiciones del SÚPER AVANCE, las cuales además se detallan en Hoja Resumen/Cotización que antecede y que este documento es fiel reflejo de lo aceptado por él. Un ejemplar del presente instrumento es entregado en este acto a el (la) CLIENTE(A), en el evento que lo hubiere contratado en forma presencial o en su defecto, enviado al correo electrónico que se indica al principio, si el SÚPER AVANCE hubiere sido contratado por cualquier modo a distancia o vía remota. Se deja constancia que, en el caso que el SÚPER AVANCE hubiere sido convenido a través de algún medio remoto o a distancia, el (la) CLIENTE(A) no tiene derecho a retracto. El presente instrumento no adhiere al sello voluntario SERNAC establecido en la Ley 19.496.</td></tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;">Infórmese sobre las entidades autorizadas para emitir Tarjetas de Pago en el país, quienes se encuentran inscritas en los Registros de Emisores de Tarjetas que lleva la Comisión para el Mercado Financiero - CMF, en www.cmfchile.cl</td></tr>
    </table><br><br>
    <table style="font-size: 11px; width: 100%;">
        <tr >
             <td style="width: 100%; text-align: center; vertical-align: baseline;" colspan=3><img src="/img/firms.documents/firm-contrato.png" ></td>
        </tr>
        <tr >
             <td style="width: 66%; text-align: center; ">AMBOS PP SOLVENTA TARJETAS S.A.</td>
             <td style="width: 33%; text-align: center; ">CLIENTE</td>
        </tr>
        <tr >
             <td style="width: 66%; text-align: center; ">Emisora Tarjeta de Crédito Cruz Verde</td>
             <td style="width: 33%; text-align: center; ">&nbsp;</td>
        </tr>
    </table>
    <!--page_footer><span style="margin-left: 600px; text-align: right; font-size: 15px;">P&aacute;gina [[page_cu]] de [[page_nb]]</span></page_footer-->
</page>
