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
            <td style="width: 85%; font-size: 12px; text-align: left;"><?= $datos["nroRut"] ?></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; text-decoration: underline; font-weight: bold; font-size: 11px; text-align: left;">Presente<br><br><br><br></td>
        </tr>
        <tr style="width: 100%; ">
            <td style="width: 100%; font-size: 12px; text-align: justify;">Estimado Señor(a):<br><br>En relaci&#243;n a su solicitud de otorgamiento de un S&#250;per Avance asociado a su Tarjeta de Cr&#233;dito Cruz Verde, le informamos que realizada su evaluaci&#243;n crediticia, &#233;sta ha sido rechazada debido a que a la fecha de la presente, <?= $reasonDeny->name_item ?><br><br>Sin otro particular, le saluda cordialmente.
            </td>
        </tr>
    </table>
    <br><br><br><br><br><br><br><br><br>
    <table style="width: 100%; border-collapse: collapse;">
        <tr >
            <td style="width: 100%; text-align: center;"><img src="/img/firms.documents/firm1-rechazo.png" style="width:162px;height:57px;"></td>
        </tr>
    </table>
</page>


