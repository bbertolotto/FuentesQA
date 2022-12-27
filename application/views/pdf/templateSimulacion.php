<style>
    {
        font-family:Arial,serif;
    }

</style>
<page>
    <table style="background-color: #999999; font-size: 16px; width: 100%; border: 1px solid black;">
        <tr style="width: 100%; ">
            <td style="padding-top: 10px; width: 100%; text-align: center; font-family:Arial,serif;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;">SIMULACI&Oacute;N S&Uacute;PER AVANCE -  TARJETA DE CR&Eacute;DITO</td>
        </tr>
        <tr style="width: 100%;">
            <td style="padding-bottom: 10px; width: 100%; text-align: center; font-family:Arial,serif;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;">CRUZ VERDE</td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%; border: 1px solid black;">
        <tr style="width: 100%; ">
            <td style="font-weight: bold; width: 25%; padding-left: 30px; padding-top: 10px;">NOMBRE</td>
            <td style="width: 75%; padding-top: 10px;" colspan="3"><?= $datos["nameClient"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 25%;"><table style="padding-left: 0px; padding-top: 10px;"><tr><td><b>RUT</b></td></tr></table></td>
            <td style="width: 75%;" colspan="3"><table style="padding-left: 0px; padding-top: 10px;"><tr><td><?= $datos["nroRut"] ."-". $datos["dgvRut"] ?></td></tr></table></td>
        </tr>
        <tr style="width: 100%; padding-bottom: 10px;">
            <td style="width: 25%; padding-left: 30px;"><table style="padding-left: 0px; padding-top: 10px;"><tr><td><b>FECHA</b></td></tr></table></td>
            <td style="width: 25%; "><table style="padding-left: 0px; padding-top: 10px;"><tr><td><?= str_replace("-","/",$datos["fecha"]) ?></td></tr></table></td>
            <td style="width: 25%; font-size: 28px; font-weight: bold; text-align: right;">CAE:</td>
            <td style="width: 25%; font-size: 28px; padding-left: 10px;"><?= str_replace(".",",",$datos["cargaAnualEquivalente"]) ?></td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%;  border: 1px solid black; padding-top: 5px; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; " colspan="2">I. Producto Principal</td>
        </tr>
    </table>
    <table style="font-size: 14px; width: 100%;  border: 1px solid black; padding-top: 6px;">
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Monto Bruto S&uacute;per Avance</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["montoBruto"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Monto L&iacute;quido S&uacute;per Avance</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["montoLiquido"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Plazo S&uacute;per Avance</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?= $datos["plazoDeCuota"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Valor de Cuota</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["valorDeCuota"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Tasa de Inter&eacute;s Mensual</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?= str_replace(".",",",$datos["tasaDeInteresMensual"]) ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Fecha Primer Vencimiento</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?= str_replace("-","/",$datos["fechaPrimerVencimiento"]); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; font-weight: bold;">Costo Total del Cr&eacute;dito</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["costoTotalDelCredito"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; font-weight: bold; padding-bottom: 10px;">Carga Anual Equivalente (CAE)</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px; padding-bottom: 10px;"><?= str_replace(".",",",$datos["cargaAnualEquivalente"]) ?></td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-top: 5px; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 12px;" colspan="2">II. Gastos o Cargos propios del S&uacute;per Avance</td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-top: 6px;">
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Impuestos</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["impuestos"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Gastos Notariales</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?= $datos["gastosNotariales"] ?></td>
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
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-top: 5px; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 9px;" colspan="2">III. Gastos o Cargos por Productos o Servicios Voluntariamente Contratados</td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-top: 6px;">
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Seguro Desgravamen</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?php echo (isset($datos['flagSeguro2']) ? $datos['flagSeguro1'] : $datos['flagSeguro2'] ); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Costo Mensual (pesos)</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?php echo (isset($datos['costoMensualSeguro2']) ? $datos['costoMensualSeguro2'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Costo Total (pesos)</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?php echo (isset($datos['costoTotalSeguro2']) ? $datos['costoTotalSeguro2'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Cobertura</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?php echo (isset($datos['coberturaSeguro2']) ? $datos['coberturaSeguro2'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Nombre proveedor del servicio asociado</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?php echo (isset($datos['nameCompany2']) ? $datos['nameCompany2'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;"></td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Seguro de Hospitalización</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?php echo (isset($datos['flagSeguro1']) ? $datos['flagSeguro1'] : $datos['flagSeguro1'] ); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Costo Mensual (pesos)</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?php echo (isset($datos['costoMensualSeguro1']) ? $datos['costoMensualSeguro1'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Costo Total (pesos)</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;">$<?php echo (isset($datos['costoTotalSeguro1']) ? $datos['costoTotalSeguro1'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Cobertura</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?php echo (isset($datos['coberturaSeguro1']) ? $datos['coberturaSeguro1'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;">Nombre proveedor del servicio asociado</td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"><?php echo (isset($datos['nameCompany1']) ? $datos['nameCompany1'] : ""); ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px;"></td>
            <td style="width: 50%; padding-left: 70px; padding-top: 10px;"></td>
        </tr>
    </table>
    <!--page_footer><span style="margin-left: 600px; text-align: right; font-size: 15px;">P&aacute;gina [[page_cu]] de [[page_nb]]</span></page_footer-->
</page>
<br><br><br>
<page>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-top: 5px; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 12px;" colspan="2">IV. Condiciones de Prepago</td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; ">
        <tr style="width: 100%; ">
            <td style="width: 30%; padding-left: 30px; ">Cargo Prepago</td>
            <td style="width: 70%; padding-left: 70px; "><?= $datos["cargoPrepago"] ?><br></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 30%; padding-left: 30px; ">Plazo de Aviso Prepago</td>
            <td style="width: 70%; padding-left: 70px; "><?= $datos["plazoAvisoPrepago"] ?><br></td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-top: 5px; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 12px;" colspan="3">V. Costos por atraso</td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black;">
        <tr style="width: 100%; ">
            <td style="width: 25%; padding-left: 30px; ">Inter&eacute;s Moratorio</td>
            <td style="width: 45%; padding-left: 70px; "></td>
            <td style="width: 30%; padding-left: 70px; text-align: right;"><?= $datos["tasaInteresMoratorio"]?>%<br></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 25%; padding-left: 30px; ">Gastos de Cobranza</td>
            <td style="width: 45%; padding-left: 70px; ">Deuda hasta 10 UF</td>
            <td style="width: 30%; padding-left: 70px; text-align: right;"><?= $datos["gastosCobranza1"]?>%</td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 25%; padding-left: 30px; "></td>
            <td style="width: 45%; padding-left: 70px; vertical-align: top;">Por lo que exceda a 10 UF y hasta 50 UF</td>
            <td style="width: 30%; padding-left: 70px; vertical-align: top; text-align: right;"><?= $datos["gastosCobranza2"]?>%</td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 25%; padding-left: 30px; "></td>
            <td style="width: 45%; padding-left: 70px; vertical-align: top;">Por lo que exceda a 50 UF</td>
            <td style="width: 30%; padding-left: 70px; vertical-align: top; text-align: right; "><?= $datos["gastosCobranza3"] ?>%<br></td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-top: 5px; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 12px;" >VI. Cierre Voluntario</td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 10px; font-size: 12px; padding: 15px; text-align: justify;">El derecho a pagar anticipadamente o prepagar es un derecho irrenunciable, de conformidad al artículo 10 de la Ley N°18.010<br></td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black; padding-top: 5px; padding-bottom: 5px;">
        <tr style="width: 100%; ">
            <td style="background-color: #666666; width: 100%; padding: 8px; color: #FFFFFF; font-weight: bold; font-size: 12px;" >Advertencia</td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%;  border: 1px solid black;" cellpadding="5px">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 10px; font-size: 12px; text-align: justify;"><p>EL PRESENTE DOCUMENTO ES &Uacute;NICAMENTE UNA SIMULACIÓN DE UN S&Uacute;PER AVANCE ASOCIADO A LA TARJETA DE CRÉDITO CRUZ VERDE Y NO IMPLICA EL OTORGAMIENTO DEL MISMO. LAS CONDICIONES COMERCIALES SIMULADAS SON LAS VIGENTES A LA FECHA DE SU EMISI&Oacute;N, EN CONSECUENCIA LAS EFECTIVAMENTE APLICABLES AL S&Uacute;PER AVANCE SERÁN LAS VIGENTES AL MOMENTO DE SU CONTRATACIÓN POR PARTE DEL CLIENTE. EL OTORGAMIENTO DEL SÚPER AVANCE REQUIERE LA APROBACIÓN PREVIA DEL CLIENTE CONFORME A LAS POLÍTICAS DE CRÉDITO DE SOLVENTA TARJETAS S.A.</p>
            <p>EN CASO DE QUE EL SÚPER AVANCE CONSIDERE PERÍODOS DE GRACIA O POSTERGACIÓN DE CUOTAS, SE APLICARÁN LOS INTERESES CORRESPONDIENTES A DICHO PERÍODO.</p>
            <p>INFORMESE SOBRE LAS ENTIDADES AUTORIZADAS PARA EMITIR TARJETAS DE PAGO EN EL PAÍS, QUIENES SE ENCUENTRAN INSCRITAS EN LOS REGISTROS DE EMISORES DE TARJETAS QUE LLEVA LA COMISIÓN PARA EL MERCADOFINANCIERO - CMF, en WWW.CMFCHILE.CL</p>
            </td>
        </tr>
    </table>
    <br><br><br><br>
    <table style="font-size: 14px; width: 100%; padding-top: 10px;" cellspacing="0px">
        <tr >
            <td style="width: 100%; text-align: center;"><span>_________________</span></td>
        </tr>
        <tr>
            <td  style="width: 100%; text-align: center;"><span>Firma Cliente</span></td>
        </tr>
    </table>
    <!--page_footer><span style="margin-left: 600px; text-align: right; font-size: 15px;">P&aacute;gina [[page_cu]] de [[page_nb]]</span></page_footer-->
</page>
