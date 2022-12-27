<?php
if(date('m') == "01"){
    $mes = "Enero";
}elseif(date('m') == "02"){
    $mes = "Febrero";
}elseif(date('m') == "03"){
    $mes = "Marzo";
}elseif(date('m') == "04"){
    $mes = "Abril";
}elseif(date('m') == "05"){
    $mes = "Mayo";
}elseif(date('m') == "06"){
    $mes = "Junio";
}elseif(date('m') == "07"){
    $mes = "Julio";
}elseif(date('m') == "08"){
    $mes = "Agosto";
}elseif(date('m') == "09"){
    $mes = "Septiembre";
}elseif(date('m') == "10"){
    $mes = "Octubre";
}elseif(date('m') == "11"){
    $mes = "Noviembre";
}elseif(date('m') == "12"){
    $mes = "Diciembre";
}

?>
<style>
    {
        font-family:Arial,serif;
    }

</style>
<page>
    <table style="width: 100%;">
        <tr style="width: 100%; ">
            <td style="width: 100%; text-align: left;"><img src="img/solventa_logo.png" width="200" height="50" border="0"/></td>
        </tr>
    </table>
    <br><br><br><br>
    <table style="width: 100%;">
        <tr style="width: 100%; ">
            <td style="width: 100%; font-size: 12px; text-align: right;">Santiago,&nbsp;<?= date('d') ?> de <?= $mes ?> de <?= date('Y') ?>.<br><br></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; font-size: 12px; text-align: left;">Señor(a)</td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 15%; font-size: 12px; text-align: left;">NOMBRE:</td>
            <td style="width: 85%; font-size: 12px; text-align: left;"><?= $datos["nameClient"]?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 15%; font-size: 12px; text-align: left;">RUT:</td>
            <td style="width: 85%; font-size: 12px; text-align: left;"><?= $datos["nroRut"]."-".$datos["dgvRut"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; text-decoration: underline; font-weight: bold; font-size: 11px; text-align: left;">Presente<br><br><br><br></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; font-size: 12px; text-align: justify;">COMPROBANTE DE ENTREGA TARJETA DE CREDITO CRUZ VERDE, HE RECIBIDO POR PARTE DE CRUZ VERDE LA TARJETA DE CREDITO DETALLADA A CONTINUACION<br><br><br>
            TARJETA NUMERO <?php $pan = str_replace("-","",$datos["numero_tarjeta"]); $pan = substr_replace($pan, "************", 0, 12 ); echo $pan;?><br><br>
            <br><br><br><br><br><br>
            FIRMA Y RUT DEL TITULAR
            <br><br><br><br><br><br>
            FIRMA, NOMBRE Y RUT DEL FUNCIONARIO<br>
            QUE ENTREGA LA TARJETA DE CREDITO<br>
            </td>
        </tr>
    </table>
</page>


