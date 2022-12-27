<style>
    {
        font-family:Arial;
    }

</style>
<page>
    <table style="width: 100%;">
        <tr style="width: 100%; ">
            <td style="width: 100%; text-align: left;"><img src="img/solventa_logo.png" width="200" height="50" border="0"/></td>
        </tr>
    </table>
    <br><br><br>
    <table style="font-size: 12px; width: 100%; padding-bottom: 14px;">
        <tr style="width: 100%; ">
            <td style="padding-top: 10px; width: 100%; text-align: center; font-family:Arial;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;">RENEGOCIACIÓN - CONVENIO DE PAGO DE DEUDA<br>TARJETA DE CRÉDITO CRUZ VERDE REFUNDIDO</td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%; padding-top:5px; ">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;">El presente instrumento confirma y deja constancia del Convenio de Pago Telefónico, que fue celebrado el <?=$date_stamp?>, entre el(la)
              Sr.(a) <?= $name_client?>, cédula de identidad y Rut Nº <?= $number_rut_client."-".$digit_rut_client?>, teléfono <?= $number_phone?>, correo electrónico o domicilio <?= $data_contacto?>, en adelante indistintamente
              el "USUARIO", el "DEUDOR" y/o el "CLIENTE", en su calidad de titular  y deudor de la tarjeta de Crédito Cruz Verde, en adelante la "Tarjeta" y la sociedad Solventa Tarjetas S.A., RUT Nº 96.776.000-5, en calidad de
              emisora y acreedora de la citada Tarjeta, cuyas estipulaciones convenidas y aceptadas por las partes, son la siguientes:
            </td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>PRIMERO:</b>&nbsp; EL USUARIO declara ser titular de la Tarjeta de Crédito Cruz Verde Nº <?php $pan = str_replace("-","",$number_credit_card); $pan = substr_replace($pan, "************", 0, 12 ); echo $pan;?> en adelate la "Tarjeta", en virtud del
              contrato de Afiliación al Sistema de Tarjeta de Crédito Cruz Verde y Apertura de Línea de Crédito que suscribio con Solventa Tarjetas S.A. y que se encuentra actualmente vigente.
            </td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>SEGUNDO:</b>&nbsp; En tal calidad, el USUARIO declara, acepta, y reconoce adeudar la suma de <?= $amount?> a Solventa Tarjetas S.A., con motivo del uso de la Tarjeta.
            </td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>TERCERO:</b>&nbsp; EL USUARIO declara y reconoce que siendo previa y debidamente informado acerca del monto y estado moroso de la deuda que reconoce, acepta la celebración del
              presente Convenio de Pago, obligandose a pagarla, en la forma siguiente:
            </td>
        </tr>
    </table><br><br>
    <table style="font-size: 12px; width: 100%; border: 1px solid black; padding-top:6px;" cellpadding="5px">
        <tr style="width: 100%;">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">MONTO DEUDA</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;"><?= $minimum_payment ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">MODALIDA DE PAGO</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;">CUOTAS MENSUALES</td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">N° CUOTAS</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;"><?= $nroCuotas ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">VALOR CUOTA</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;"><?= $montoCuota ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">FECHA PRIMER VENCIMIENTO</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;"><?= $first_expiration_date ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">TASA INTERÉS PREFERENCIAL APLICADA</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;"><?= $interest_rate ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">MONTO COMISIÓN ADMINISTRACIÓN - MANTENCIÓN</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;"><?= $maintenance_cost ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">MONTO SEGUROS</td>
            <td style="width: 50%; padding-top: 10px;  border: 1px solid black; text-align: center;"><?= $amount_quotes_secure ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">CAE CRÉDITO (*)</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;"><?= $cae ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 50%; padding-left: 30px; padding-top: 10px; border: 1px solid black;">COSTO TOTAL CRÉDITO</td>
            <td style="width: 50%; padding-top: 10px; border: 1px solid black; text-align: center;"><?= $total_cost ?></td>
        </tr>
    </table>
    <table style="font-size: 12px; width: 100%; padding-top:5px; ">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;">* Toda CAE se calcula sobre un supuesto gasto mensual de 20UF y pagadero en 12 cuotas.
            </td>
        </tr>
    </table><br>
    <table style="font-size: 12px; width: 100%; padding-top:5px; ">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>CUARTO:</b>&nbsp; Conjuntamente con la aceptación del presente Convenio de Pago, el USUARIO solicita y acepta expresamente que se proceda a la rebaja del Cupo Total para Compras de su tarjeta, a la suma de $100.000 y que el Cupo Total para efectuar Avances en Efectivo, quede reducido a la suma de $0.- , circunstancia esta que es condición esencial para la celebración del convenio, la cual fue puesta en conocimiento del deudor y que éste aceptó expresamente.
            </td>
        </tr>
    </table>
<br pagebreak="true"/>
</page>
<page>
    <table style="font-size: 12px; width: 100%; padding-top:5px; ">
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;">Se deja constancia al USUARIO que el monto autorizado de la línea de crédito para avances y compras, que se informa en los estados de cuenta, eventualmente puede ser menor al monto utilizado de dicha línea. Lo anterior, con motivo de la capitalización de intereses y gastos con motivo de su situación de mora.
            </td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>QUINTO:</b>&nbsp; El convenio de Pago se reflejará en respectivo Estado de Cuenta mensual, bajo la glosa "RENEGOCIACION-CONVENIO".
            </td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>SEXTO:</b>&nbsp; Se deja constancia que al presente Convenio de Pago se aplicará todas las estipulaciones contenidas en el Contrato de Afiliación al Sistema de Tarjeta de Crédito Cruz Verde y Apertura de Línea de Crédito, suscrito por el Usuario y que se encuentra vigente entre las partes.<br>
            De este modo, en el evento de incumplimiento por parte del Usuario en el pago integro y oportuno de su deuda, esta se podrá hacer exigible en la forma establecida en el citado Contrato, aplicándose los intereses, cargos, costos de cobranza y demás estipulaciones contenidas en dicho instrumento.<br>
            Asimismo, se deja constancia que la celebración de este Convenio de Pago, no modifica ni altera en forma alguna el plazo establecido en el Contrato, manteniendose en consecuencia lo pactado respecto a la Vigencia y sus renovaciones, según corresponda en la forma señalada en el ya referido contrato. 
            </td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>SEPTIMO:</b>&nbsp; EL USUARIO expresa que fue informado del estado de su deuda y de todas las condiciones y caracteristicas del Convenio de Pago, declarando que su aceptación es tomada en forma libre y voluntaria. 
            </td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; padding-left: 30px; text-align: justify;"><b>OCTAVO:</b>&nbsp; Un ejemplar de este instrumento se envia al domicilio o correo electrónico del USUARIO, para constancia de lo aceptado por él, conjuntamente con el respectivo Estado de Cuenta.
            </td>
        </tr>
    </table><br><br><br><br><br>
    <table style="font-size: 11px; width: 100%;">
        <tr >
             <td style="width: 100%; text-align: center; vertical-align: baseline;" colspan=3><img src="/img/firms.documents/firm-renegociacion.png" ></td>
        </tr>
        <tr >
             <td style="width: 100%; text-align: center; ">p.p. SOLVENTA TARJETAS S.A.</td>
        </tr>
    </table>
</page>
