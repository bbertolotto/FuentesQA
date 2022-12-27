<style>
    {
        font-family:Arial;
    }
</style>
<page>
    <table style="font-size: 16px; width: 100%;">
        <tr style="width: 100%; ">
            <td style="padding-top: 10px; width: 100%; text-align: center; font-family:Arial;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;">HOJA RESUMEN/COTIZACIÓN SÚPER AVANCE - TARJETA DE</td>
        </tr>
        <tr style="width: 100%;">
            <td style="padding-bottom: 10px; width: 100%; text-align: center; font-family:Arial;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;">CRÉDITO CRUZ VERDE</td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 15%; "><table style="padding-top: 10px;"><tr><td><b>Número</b></td></tr></table></td>
            <td style="width: 15%; text-align: left; "><table style="padding-top: 10px;"><tr><td><?= $id ?></td></tr></table></td>
            <td style="padding-bottom: 10px; width: 70%; text-align: right; font-size: 28px; font-family:Arial;color:rgb(0,0,0);font-style:normal;text-decoration: none;">CAE:&nbsp;&nbsp;<?= str_replace(".",",", $datos["cargaAnualEquivalente"]) ?></td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%; border: 1px solid black; padding-top:6px;" cellpadding="5px">
        <tr style="width: 100%; ">
            <td style="width: 40%; padding-left: 30px; padding-top: 10px;">Nombre Titular</td>
            <td style="width: 60%; padding-top: 10px;"><?= $datos["nameClient"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 40%; padding-left: 30px; ">RUT</td>
            <td style="width: 60%; padding-top: 10px; "><?= $datos["nroRut"] ."-". $datos["dgvRut"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 40%; padding-left: 30px; ">Fecha</td>
            <td style="width: 60%; padding-top: 10px; "><?= date("d/m/Y", strtotime($datos["fecha"])) ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 40%; padding-left: 30px; ">Plazo de vigencia cotización</td>
            <td style="width: 60%; padding-top: 10px; "><?= $datos["diasDeVigenciaCotizacion"] ?> días Hábiles</td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%; border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%;">
            <td style="background-color: #666666; width: 100%; color: #FFFFFF; font-weight: bold; font-size: 12px;" colspan="2">I. Producto Principal</td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%;  border: 1px solid black; padding-top: 3px; padding-left: 7px;">
        <tr style="width: 100%; ">
            <td style="width: 50%; text-align: left;">Monto Bruto S&uacute;per Avance</td>
            <td style="width: 50%; text-align: left;">$<?= $datos["montoBruto"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Monto Líquido Súper Avance</td>
            <td style="width: 50%; ">$<?= $datos["montoLiquido"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Plazo S&uacute;per Avance</td>
            <td style="width: 50%; "><?= $datos["plazoDeCuota"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Valor de Cuota Súper Avance</td>
            <td style="width: 50%; ">$<?= $datos["valorDeCuota"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Tasa de Inter&eacute;s Mensual</td>
            <td style="width: 50%; "><?= str_replace(".",",",$datos["tasaDeInteresMensual"]) ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Fecha Primer Vencimiento</td>
            <td style="width: 50%; "><?= str_replace("-","/",$datos["fechaPrimerVencimiento"]); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; font-weight: bold;">Costo Total del Cr&eacute;dito</td>
            <td style="width: 50%; ">$<?= $datos["costoTotalDelCredito"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; font-weight: bold; padding-bottom: 10px;">Carga Anual Equivalente (CAE)</td>
            <td style="width: 50%; "><?= str_replace(".",",", $datos["cargaAnualEquivalente"]) ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td colspan=2>&nbsp;</td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%; border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 9px;" colspan="2">II. Gastos o Cargos propios del S&uacute;per Avance</td>
        </tr>
    </table>
    <table style="font-size: 9px; width: 100%;  border: 1px solid black;" cellspacing="8px">
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Gastos Notariales</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["gastosNotariales"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Impuestos</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["impuestos"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Comisi&oacute;n S&uacute;per Avance</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["comision"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;">Garant&iacute;as Asociadas</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px; padding-bottom: 10px;"><?= $datos["garantiasAsociadas"] ?></td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%; border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 9px;" colspan="2">III. Gastos o Cargos por Productos o Servicios Voluntariamente Contratados</td>
        </tr>
    </table>
    <table style="font-size: 9px; width: 100%;  border: 1px solid black; " cellspacing="8px">
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Desgravamen</td>
            <td style="width: 50%; "><?php echo (isset($datos['flagSeguro2']) ? $datos['flagSeguro2'] : $datos['flagSeguro2'] ); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Costo Mensual (pesos)</td>
            <td style="width: 50%; ">$ <?php echo (isset($datos['costoMensualSeguro2']) ? $datos['costoMensualSeguro2'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Costo Total (pesos)</td>
            <td style="width: 50%; ">$ <?php echo (isset($datos['costoTotalSeguro2']) ? $datos['costoTotalSeguro2'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Cobertura</td>
            <td style="width: 50%; "><?php echo (isset($datos['coberturaSeguro2']) ? $datos['coberturaSeguro2'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Nombre proveedor del servicio asociado</td>
            <td style="width: 50%; "><?php echo (isset($datos['nameCompany2']) ? $datos['nameCompany2'] : ""); ?></td>
        </tr>
    </table>
<br pagebreak="true"/>
</page>
<page>
    <table style="font-size: 9px; width: 100%;  border: 1px solid black; " cellspacing="8px">
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Hospitalización por accidentes</td>
            <td style="width: 50%; "><?php echo (isset($datos['flagSeguro1']) ? $datos['flagSeguro1'] : $datos['flagSeguro1'] ); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Costo Mensual (pesos)</td>
            <td style="width: 50%; ">$ <?php echo (isset($datos['costoMensualSeguro1']) ? $datos['costoMensualSeguro1'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Costo Total (pesos)</td>
            <td style="width: 50%; ">$ <?php echo (isset($datos['costoTotalSeguro1']) ? $datos['costoTotalSeguro1'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Cobertura</td>
            <td style="width: 50%; "><?php echo (isset($datos['coberturaSeguro1']) ? $datos['coberturaSeguro1'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Nombre proveedor del servicio asociado</td>
            <td style="width: 50%; "><?php echo (isset($datos['nameCompany1']) ? $datos['nameCompany1'] : ""); ?></td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%; border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 9px;" colspan="2">IV. Condiciones de Prepago</td>
        </tr>
    </table>
    <table style="font-size: 9px; width: 100%;  border: 1px solid black;" cellspacing="4px">
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Cargo Prepago</td>
            <td style="width: 50%; "><?= $datos["cargoPrepago"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; ">Plazo de Aviso Prepago</td>
            <td style="width: 50%; "><?= $datos["plazoAvisoPrepago"] ?><br></td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%; border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 9px;" colspan="3">V. Costos por atraso</td>
        </tr>
    </table>
    <table style="font-size: 9px; width: 100%;  border: 1px solid black; " >
        <tr style="width: 100%; ">
            <td style="width: 20%; ">Inter&eacute;s Moratorio</td>
            <td style="width: 50%; "></td>
            <td style="width: 30%; text-align: right;"><?= str_replace(".",",", $datos["tasaInteresMoratorio"])?>%<br></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 20%; ">Gastos de Cobranza</td>
            <td style="width: 50%; ">Deuda hasta 10 UF</td>
            <td style="width: 30%; text-align: right;"><?= str_replace(".",",",$datos["gastosCobranza1"])?>%</td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 20%; "></td>
            <td style="width: 50%; vertical-align: top;">Por lo que exceda a 10 UF y hasta 50 UF</td>
            <td style="width: 30%; vertical-align: top; text-align: right;"><?= str_replace(".",",",$datos["gastosCobranza2"])?>%</td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 20%; "></td>
            <td style="width: 50%; vertical-align: top;">Por lo que exceda a 50 UF</td>
            <td style="width: 30%; vertical-align: top; text-align: right;"><?= str_replace(".",",",$datos["gastosCobranza3"]) ?>%<br></td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%; border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 9px;" >VI. Cierre Voluntario</td>
        </tr>
    </table>
    <table style="font-size: 9px; width: 100%;  border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 8px; font-size: 9px; padding: 15px;">El derecho a pagar anticipadamente o prepagar es un derecho irrenunciable, de conformidad al artículo 10 de la Ley N°18.010</td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%; border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 9px;" >Advertencia</td>
        </tr>
    </table>
    <table style="font-size: 9px; width: 100%;  border: 1px solid black; padding-top:6px; padding-bottom: 6px;">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 8px; font-size: 9px; padding: 15px; text-align: justify;"><p>EL CRÉDITO DE SÚPER AVANCE DE QUE DA CUENTA ESTA HOJA RESUMEN/COTIZACIÓN REQUIERE DEL CONSUMIDOR CONTRATANTE <?= $datos["nameClient"] ?> PATRIMONIO O INGRESOS FUTUROS SUFICIENTES PARA PAGAR SU COSTO TOTAL DE $<?=$datos["costoTotalDelCredito"]?> CUYA CUOTA MENSUAL ES DE $<?= $datos["valorDeCuota"]?>, DURANTE TODO EL PERÍODO DEL CRÉDITO.</p>
            <p>EN CASO DE QUE EL SÚPER AVANCE CONSIDERE PERÍODOS DE GRACIA O  POSTERGACIÓN DE CUOTAS, SE APLICARÁN LOS INTERESES CORRESPONDIENTES A DICHO PERÍODO.</p>
            <p>INFÓRMESE  SOBRE  LAS  ENTIDADES  AUTORIZADAS  PARA  EMITIR  TARJETAS  DE  PAGO  EN  EL  PAÍS,  QUIENES  SE ENCUENTRAN INSCRITAS EN LOS REGISTROS DE EMISORES DE TARJETAS QUE LLEVA LA COMISIÓN PARA EL MERCADO FINANCIERO - CMF, en WWW.CMFCHILE.CL</p>
            </td>
        </tr>
    </table>
    <br><br><br><br><br>
    <table style="font-size: 12px; width: 100%; border-collapse: collapse;">
        <tr >
            <td style="width: 100%; text-align: center;"><span>_________________</span></td>
        </tr>
        <tr>
            <td  style="width: 100%; text-align: center;"><span>Firma Cliente</span></td>
        </tr>
    </table>
<br pagebreak="true"/>
</page>
<page>
    <table style="font-size: 12px; width: 100%;">
        <tr style="width: 100%; ">
            <td style="padding-top: 10px; width: 100%; text-align: center; font-family:Arial;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;">DEFINICIONES HOJA RESUMEN/COTIZACIÓN SÚPER AVANCE - TARJETA DE</td>
        </tr>
        <tr style="width: 100%;">
            <td style="padding-bottom: 10px; width: 100%; text-align: center; font-family:Arial;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;">CRÉDITO CRUZ VERDE<br></td>
        </tr>
    </table>
    <table style="font-size: 9px; width: 100%;  border: 1px solid black; padding-right: 4px; padding-left:4px; padding-top: 5px; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="width: 100%; font-size: 9px; text-align: justify;"><p><b>Hoja Resumen:</b> La Hoja inicial que antecede a los contratos de adhesión de Créditos de Consumo, que contiene un resumen estandarizado de sus principales cláusulas y que los Proveedores deben incluir en sus cotizaciones para facilitar su comparación por los Consumidores.<br><b>Gastos o Cargos Propios del Crédito: </b>Todas aquellas obligaciones en dinero, cualquiera sea su naturaleza o denominación, derivadas de la contratación de un Crédito de Consumo y devengadas a favor del Proveedor o de un tercero, que no correspondan a tasa de interés ni a capital y que deban pagarse por el Consumidor. Tendrán este carácter los impuestos y gastos notariales, además de los que sean definidos como tales por una disposición legal o reglamentaria.<br><b>Valor de la Cuota:</b> El monto que se obliga a pagar un Consumidor al contratar un Crédito de Consumo en forma periódica, que considera todos los intereses, amortizaciones, Gastos o Cargos Propios del Crédito y Gastos o Cargos por Productos o Servicios Voluntariamente Contratados.<br><b>Monto Líquido:</b> El monto total que efectivamente recibe el Consumidor para satisfacer el objeto del contrato en el periodo inicial.<br><b>Monto Bruto:</b> El monto Líquido del Crédito más los Gastos o Cargos Propios del Crédito y Gastos o Cargos por Productos o Servicios Voluntariamente Contratados que se efectúan en el período inicial.<br><b>Costo Total del Crédito:</b> El monto total que debe asumir el Consumidor, y que corresponde a la suma de todos los pagos periódicos definidos como Valor de la Cuota en función del plazo acordado, incluyendo cualquier pago en el período inicial.<br><b>Plazo del Crédito:</b> El periodo establecido para el pago total del Crédito de Consumo. Si un Crédito de Consumo tiene periodo de gracia, postergación de una o más cuotas, meses sin pago de una o más cuotas o cualquier otra modalidad que extienda la fecha de extinción del crédito, el Proveedor deberá informar al Consumidor la diferencia en la tasa de interés y en cualquier otro costo que esté considerado en la modalidad respectiva. Además, el Plazo del Crédito incluirá los meses adicionales en que la obligación se mantendrá vigente si se verifican todos los eventos previstos en la modalidad respectiva que extiendan la fecha de extinción del crédito.<br><b>Costos por impuestos:</b> Las obligaciones tributarias que el Emisor debe cobrar al consumidor a consecuencia de un impuesto que se haya devengado por un producto o servicio que se encuentre afecto a él.<br><b>Costos de administración, operación y/o mantención de la Tarjeta de Crédito:</b> Todas las sumas de dinero que mensual, semestral o anualmente deba pagar el consumidor por el valor de los servicios necesarios para la mantención operativa de una Tarjeta de Crédito en sus distintas modalidades de uso.<br><b>Carga anual equivalente o 'CAE':</b> Indicador que, expresado en forma de porcentaje, revela el costo del crédito en un periodo anual, cualquiera sea el plazo pactado para el pago de la obligación. La carga anual equivalente incluye el capital, tasa de interés, plazo, costos de apertura, comisiones y cargos, costos de administración, operación y/o mantención de la Tarjeta de Crédito, y los gastos o cargos por productos o servicios voluntariamente contratados.<br><b>Gastos o cargos por productos o servicios voluntariamente contratados: </b>Todas las obligaciones en dinero, cualquiera sea su naturaleza o denominación, por productos o servicios proporcionados por el Emisor o por un tercero contratado por intermedio del Emisor, respecto de las cuales el consumidor puede prescindir al contratar una Tarjeta de Crédito.<br><b>Interés moratorio:</b> Tasa de interés que se aplica por no haber sido pagada total e íntegramente una obligación a la fecha de su vencimiento. Se calcula desde la fecha de la mora o simple retardo en el pago, hasta la fecha del pago total e íntegro de todo lo adeudado.<br><b>Gastos de cobranza:</b> Monto correspondiente al costo de la cobranza extrajudicial de una obligación vencida y no pagada en la fecha establecida en el contrato, traspasado por el Emisor al consumidor, y que sólo se puede cobrar si han transcurrido veinte días corridos desde el atraso, según lo dispuesto en el artículo 37 de la Ley de Protección al Consumidor.<br><b>Comisión por Pago Anticipado o Prepago:</b> El valor extraordinario y voluntario que asume el Consumidor al pagar en forma anticipada el Crédito de Consumo, sea en forma total o parcial, esto es, antes del plazo establecido para ello. Este cargo se rige por el Artículo 10 de la Ley N°18.010.<br><b>Costo Total del Pago Anticipado o Prepago:</b> El monto total a pagar por el Consumidor, para extinguir la obligación anticipadamente, incluida la Comisión por Pago Anticipado o Prepago.</p>
            </td>
        </tr>
    </table>
    <br><br>
    <table style="font-size: 12px; width: 100%; border-collapse: collapse; padding-top: 5px;">
        <tr >
            <td style="width: 100%; text-align: center;"><span>_________________</span></td>
        </tr>
        <tr>
            <td  style="width: 100%; text-align: center;"><span>Firma Cliente</span></td>
        </tr>
    </table>
    <!--page_footer><span style="margin-left: 600px; text-align: right; font-size: 15px;">P&aacute;gina [[page_cu]] de [[page_nb]]</span></page_footer-->
</page>
