<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="img/bootstrap.min.css">
<style type="text/css">
@page { margin-left: .27cm; margin-right: 1.27cm; margin-top: 1.50cm; margin-bottom: 1.50cm }
p { margin-bottom: 0.25cm; direction: ltr; line-height: 100%; text-align: left; orphans: 2; widows: 2 }
a:link { color: #0563c1 } font-family: {Arial}
body {margin-left: 260px; margin-right: 235px;}
@media print {
  .new-page {
    page-break-before: always;
  }
}
</style>
</head>
<body >

<div title="header">
<img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br/>
</div>

<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 10px;">
	<tr>
		<td colspan="2" width="100%" valign="top" align="center">
			SOLICITUD DE INCORPORACIÓN Y CERTIFICADO DE COBERTURA SEGURO DE DESGRAVAMEN
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top" align="left" >
			<b>Fecha <?=date("d")?>/<?=date("m")?>/<?=date("Y")?></b>
		</td>
    <td width="50%" valign="top" align="right">
			<b>Nro. <?= $datos["coberturaSeguro2"]?></b>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 9px;">
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center"><b>Certificado de Cobertura – Desgravamen <?= $datos["canalVenta"]?></b></p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p><b>Identificación del Asegurado Titular</b></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Nombre:  <?= $datos["nameClient"]?></p>
		</td>
		<td colspan="2" width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>RUT: <?= $datos["nroRut"] ."-". $datos["dgvRut"]  ?></p>
		</td>
		<td width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Fecha Nacimiento: <?= $datos["birthDate"] ?></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Dirección: <b><?= $datos["calle"] ?></b>
			</p>
		</td>
		<td colspan="2" width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>N°:  <?= $datos["numCalle"] ?></p>
		</td>
		<td width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Depto/Block: <?= $datos["numDepto"]."/".$datos["block"] ?></p>
		</td>
	</tr>
	<tr valign="top">
		<td width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Ciudad: <?= $datos["ciudad"] ?></p>
		</td>
		<td colspan="2" width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Comuna: <?= $datos["comuna"] ?></p>
		</td>
		<td colspan="2" width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Teléfono: <?= $datos["fonoFijo"] ?></p>
		</td>
		<td width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Celular: <?= $datos["fonoMovil"] ?></p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<?php if($datos["sexo"]=="MAS"):?>
				<p style='margin-left: 20px;'>Sexo: M [X]    F [ ]</p>
			<?php else: ?>
				<p style='margin-left: 20px;'>Sexo: M [ ]    F [X]</p>
			<?php endif; ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2" width="30%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Correo Electrónico:</p>
			<p><?= $datos["email"] ?></p>
		</td>
		<td colspan="4" width="70%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify" style="margin-bottom: 0cm">Autorizo que toda comunicación y notificación que diga relación con el presente
			seguro me sea enviada al correo electrónico señalado en esta Solicitud de Incorporación.</p>
			<p>SI [X]   NO [ ]</p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p><b>Antecedentes de la Compañía Aseguradora</b></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>BCI Seguros Vida S.A.</p>
		</td>
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>RUT: 96.573.600-K</p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p><b>Antecedentes del Contratante</b></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify">Solventa Tarjetas S.A.</p>
		</td>
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify">RUT: 96.776.000-5</p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p><b>Antecedentes del Corredor</b></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify">Arthur J. Gallagher Corredores de Seguros S.A.</p>
		</td>
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify">RUT: 77.682.370-8</p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center"><b>Datos del Seguro</b></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Monto Inicial del Súper Avance: $<?= $datos["montoLiquido"]?></p>
		</td>
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Nro. Operación: <?= $datos["idDocument"]?></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Fecha Inicio del Súper Avance: <?= $datos["fechaPrimerVencimiento"]?></p>
		</td>
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Fecha Fin del Súper Avance: <?= $datos["fechaUltimoVencimiento"]?></p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Prima Única del Seguro: $<?= $datos["costoTotalSeguro2"]?></p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center"><b>Asegurados</b></p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify">Personas naturales, tarjetahabientes de Tarjeta de Crédito Cruz Verde que soliciten un Súper Avance, que cumplan los requisitos de asegurabilidad.</p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify"><b>IMPORTANTE</b>: Usted está solicitando su incorporación como asegurado a una póliza o contrato de seguro
			colectivo cuyas condiciones han sido convenidas por Solventa Tarjetas S.A., directamente con la compañía de seguros.</p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center"><b>Detalle de Coberturas</b></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4" width="50%" height="6" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center"><b>Coberturas</b></p>
		</td>
		<td colspan="2" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center"><b>Código C.M.F.</b></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Cobertura de Desgravamen</p>
		</td>
		<td colspan="2" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center" style="margin-left: 1.25cm; text-indent: -1.25cm">
			POL 2 2013 0095</p>
		</td>
	</tr>
</table>
<br/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 9px;"><b>Solicitud de Incorporación, Mandato y Autorización de Cargo en Súper Avance.</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 9px;">Mediante la presente Solicitud de Incorporación y Certificado de Cobertura
solicito ser incorporado a esta póliza colectiva cuyos términos, naturaleza, condiciones de asegurabilidad, cobertura, vigencia,
exclusiones, comisiones y demás características declaro conocer a cabalidad por haberme sido explicadas y por haber tenido a la vista,
previo a mi firma, el certificado de cobertura y, las condiciones particulares y generales que se detallan suficientemente. Declaro
además, que contrato voluntario e informadamente este seguro. Asimismo otorgo mandato y faculto a Solventa Tarjetas S.A. para incorporarme en calidad de asegurado, a la póliza colectiva:
&nbsp;<b><?= $datos["nroPoliza2"]?></b> y agregar el valor de la prima única, al monto del Súper Avance que me ha sido otorgado por Solventa Tarjetas S.A. El
mandatario rendirá cuenta de su mandato entregándole al asegurado al momento de contratar el avance una liquidación del Súper Avance,
en donde se indique el cargo de la prima correspondiente. El cliente asegurable autoriza a Solventa Tarjetas S.A y a la Compañía
Aseguradora, para que los datos suministrados sean utilizados para la administración y auditoría del seguro contratado, el ofrecimiento
de otros seguros u otros avances en los que pudiere estar interesado.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 9px;">Mediante la siguiente firma, acepto la contratación de este seguro.</p>

<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 9px;">
<col width="100%">
<tr>
	<td width="33%" valign="top" align="center" >
    <img src="img/firma-gallaher-corredores.jpg" border="0" width="142px" height="104px">
	</td>
	<td width="33%" valign="bottom" align="center" >
    <img src="img/firma-asegurado.png" border="0" width="142px" height="104px">
	</td>
	<td width="33%" valign="top" align="center" >
    <img src="img/firma-bci-seguros.png" border="0" width="142px" height="104px">
	</td>
</tr>
</col>
</table>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Descripción de Coberturas y Condiciones de Asegurabilidad</b>
		</td>
	</tr>
</table>
<p style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;"><b>Materia  y Monto Asegurado</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;"><b>Desgravamen</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;">Cubre el saldo insoluto de la deuda del Súper Avance contratado por el asegurado con Solventa Tarjetas S.A., ante el fallecimiento del
asegurado, durante toda la vigencia del Super Avance. La Compañía Aseguradora pagará al beneficiario Solventa Tarjetas S.A., el
capital asegurado una vez acreditado el fallecimiento del asegurado y siempre que se cumplan todas las condiciones estipuladas en las
Condiciones Particulares. El capital asegurado corresponde para efectos de la cobertura de desgravamen, corresponde al saldo insoluto
del Súper Avance, vigente a la fecha de ocurrencia del siniestro, sobre la base de un servicio regular de la deuda. Queda excluido lo
adeudado por mora o simple retardo.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;">En caso de refinanciamiento o renegociaciones del Súper Avance implican
el término de la póliza vigente y para que el asegurado continúe con cobertura, será necesario la contratación voluntaria de una nueva póliza.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;">Se establece un tope de indemnización igual a UF 180, por asegurado, en
el caso de Súper Avance.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;"><b>Interés Asegurable</b></p>
<p align="justify" style="margin-bottom: 0.28cm; line-height: 108%;font-size: 10px;">El interés asegurable por parte del asegurado corresponde a su propia vida. </p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;"><b>Requisitos de Asegurabilidad</b></p>
<ul style="font-size: 10px;">
  <li> Edad mínima de ingreso: 18 años.</li>
  <li> Edad máxima de ingreso: 74 años y 364 días.</li>
  <li> Edad máxima de cobertura: 79 años y 364 días.</li>
</ul>
<p align="justify" style="margin-right: 0.08cm; margin-bottom: 0cm; line-height: 100%; orphans: 0; widows: 0;font-size: 10px;">
La edad de ingreso del asegurado más el plazo del Súper Avance no deben superar la edad de cobertura.</p>
<p align="justify" style="margin-right: 0.08cm; margin-bottom: 0cm; line-height: 100%; orphans: 0; widows: 0;font-size: 10px;">
El plazo de cobertura del seguro de Desgravamen es toda la vigencia del Súper Avance otorgado al asegurado. Dada la naturaleza de este
seguro colectivo, solo se podrá contratar en forma voluntaria y simultánea al curse del Súper Avance, no pudiendo ser contratada
con anterioridad o durante la vigencia del mismo.</p>
<p align="justify" style="margin-right: 0.08cm; margin-bottom: 0cm; line-height: 100%; orphans: 0; widows: 0;font-size: 10px;">
<b>Beneficiarios</b></p>
<p align="justify" style="margin-right: 0.08cm; margin-bottom: 0cm; line-height: 100%; orphans: 0; widows: 0;font-size: 10px;">
Mientras el Súper Avance se encuentre vigente, el beneficiario será Solventa Tarjetas S.A., en su calidad de contratante y acreedor del
avance, por el monto correspondiente al saldo insoluto de la deuda al momento de fallecimiento del asegurado.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;"><b>Cobertura de Desgravamen (POL 2 2013 0095, Artículo N°2)</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;">BCI Seguros Vida S.A., asegura la vida de los deudores del contratante,
que se hayan incorporado a la póliza. De acuerdo a lo anterior, la indemnización correspondiente al capital asegurado de un
Deudor-Asegurado, será pagado por la BCI Seguros Vida S.A., al acreedor beneficiario, inmediatamente después de haberse comprobado
por ésta que el fallecimiento del Asegurado ocurrió durante la vigencia de la cobertura para dicho Asegurado, y que no se produjo
bajo algunas de las exclusiones señaladas en esta póliza. Si el Asegurado sobrevive a la fecha de vencimiento de la cobertura
otorgada por esta póliza, no habrá derecho a indemnización alguna.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;"><b>Plazo de Cobertura</b><br/>Desgravamen: el plazo del Súper Avance</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;">&nbsp;</p>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%;font-size: 10px;"><b>Prima del Seguro</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">La prima se calculará multiplicando la tasa única de cada seguro por
el monto inicial del Súper Avance, más Gastos Notariales y seguros voluntarios. Esto es:</p>

<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 10px;">
	<tr valign="top">
		<td width="33%" height="2" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center">Seguro</p>
		</td>
		<td width="33%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center">Tasa Neta Única</p>
		</td>
		<td width="33%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center">Tasa Bruta Única</p>
		</td>
	</tr>
	<tr valign="top">
		<td width="33%" height="2" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center">Desgravamen</p>
		</td>
		<td width="33%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center">9%</p>
		</td>
		<td width="33%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="center">9%</p>
		</td>
	</tr>
</table>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Se considera una prima tope igual a $238.000.</p>

<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Exclusiones</b>
		</td>
	</tr>
</table>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>Exclusiones Cobertura de Desgravamen (POL 2 2013 0095, Artículo N°3)</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Este seguro no cubre el riesgo de muerte si el fallecimiento del Asegurado fuere causado por:
</p>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">a) Suicidio, automutilación, o autolesión, a menos que de acuerdo al
Nº 8 del artículo 524 del Código de Comercio se acredite que el Asegurado actuó totalmente privado de la razón, correspondiendo, en
todo caso, a la Compañía Aseguradora acreditar el hecho del suicidio. No obstante, la Compañía Aseguradora pagará el capital
asegurado al Beneficiario, si el fallecimiento ocurriera como consecuencia de suicidio, siempre que hubiera transcurrido el plazo
señalado en las Condiciones Particulares de la póliza, el que a falta de estipulación en ellas, será de un (1) año completo e
ininterrumpido, contado desde la fecha de inicio de vigencia de la cobertura del Asegurado indicado en las Condiciones Particulares de
la póliza, desde su rehabilitación, en su caso, o desde el aumento de capital asegurado. En éste último caso, el plazo se considerará
sólo para el pago de la indemnización correspondiente al incremento del capital asegurado.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">b) Pena de muerte o por participación del Asegurado en cualquier acto
delictivo.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">c) Por quien pudiere verse beneficiado por el pago de la cantidad
asegurada, mediante su participación como autor o cómplice en un acto que sea calificado por la ley como delito.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">d) La participación activa del Asegurado en guerra internacional, sea
que Chile tenga o no intervención en ella; en guerra civil, dentro o fuera de Chile; o en motín o conmoción contra el orden público
dentro o fuera del país; o hechos que las leyes califican como delitos contra la seguridad interior del Estado.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">e) La participación activa del Asegurado en acto terrorista, entendiéndose por acto terrorista toda conducta calificada como tal
por la ley, así como el uso de fuerza o violencia o la amenaza de ésta, por parte de cualquier persona o grupo, motivado por causas
políticas, religiosas, ideológicas o similares, con la intención de ejercer influencia sobre cualquier gobierno o de atemorizar a la
población, o a cualquier segmento de la misma.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">f) La participación del Asegurado en actos temerarios o en cualquier
maniobra, experimento, exhibición, desafío o actividad notoriamente peligrosa, entendiendo por tales aquellas en las cuales se pone en
grave peligro la vida e integridad física de las personas. </p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">g) Fisión o fusión nuclear o contaminación radioactiva.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">h) Una infección oportunística, o un neoplasma maligno, si al momento
de la muerte o enfermedad el asegurado sufría del Síndrome de Inmunodeficiencia Adquirida. Con tal propósito, se entenderá por:
&quot;Síndrome de Inmunodeficiencia Adquirida&quot;, lo definido para tal efecto por la Organización Mundial de la Salud. Infección
Oportunística incluye, pero no debe limitarse a Neumonía causada por Pneumocystis Carinii, Organismo de Enteritis Crónica, Infección
Vírica o Infección Microbacteriana Diseminada. Neoplasma Maligno incluye, pero no debe limitarse al Sarcoma de Kaposi, al Linfoma del
Sistema Nervioso Central o a otras afecciones malignas ya conocidas o que puedan conocerse como causas inmediatas de muerte en presencia de
una inmunodeficiencia adquirida. Síndrome de Inmunodeficiencia Adquirida debe incluir Encefalopatía (demencia) de V.I.H. (Virus de
Inmunodeficiencia Humano) y Síndrome de Desgaste por V.I.H. (Virus de Inmunodeficiencia Humano). De ocurrir el fallecimiento del
Asegurado debido a alguno de los hechos o circunstancias antes señaladas, se entenderá que no existe cobertura para el caso en
particular, y producirá el término del seguro para dicho Asegurado, no existiendo obligación de indemnización alguna por parte de la
Compañía Aseguradora. Conforme a lo anterior, y por su naturaleza, la póliza seguirá vigente para todos los efectos con respecto a los
demás Asegurados.</p>

<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Procedimiento de Denuncia de Siniestro</b>
		</td>
	</tr>
</table>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">En caso de consultas, reclamos y denuncias de siniestro, el asegurado se
deberá comunicar al teléfono del Centro de Respuesta Inmediata (CRI) de la Compañía de Seguros 600 6000 292 – desde celular 2
2679 9700  o en cualquiera de las oficinas de BCI Seguros Vida S.A.</p>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

<br><br>
<!-- Salto de Pagina -->
	<p class="new-page"></p>
	<img src="Certificado_html_320eb096569c1a2b.png" name="Imagen 6" width="156" height="40" border="0" style='margin-left: -50px;'/>
	<br><br>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">En todos los casos la compañía se reserva el derecho de pedir mayores
antecedentes para la liquidación del siniestro. En todas las denuncias deberá dejarse constancia del nombre, dirección y
teléfono de la persona denunciante para posteriores contactos que sean necesarios.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>Documentos a Presentar</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Producido el fallecimiento del asegurado, se deberá comunicar por escrito a la
compañía dentro de un plazo de noventa (90) días corridos. El cumplimiento extemporáneo de esta obligación hará perder el
derecho a la indemnización establecida en la presente, salvo en caso de fuerza mayor.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><a name="_Hlk80708355"></a>
En caso de fallecimiento, se deberán presentar a la compañía la siguiente documentación:</p>
<ul style="font-size: 10px;">
  <li>Formulario de denuncia de siniestro completo.</li>
	<li>Fotocopia de la cédula de identidad del asegurado fallecido.</li>
  <li>Certificado de defunción original, con la causa de muerte.</li>
	<li>En caso de muerte presunta, ésta deberá acreditarse de conformidad a la ley.</li>
	<li>En caso de muerte accidental se deberá presentar parte policial, Alcoholemia, Autopsia o Dictamen de la Justicia.</li>
	<li>Certificado de prueba de muerte.</li>
	<li>Solicitud de Incorporación al Seguro debidamente firmado por el asegurado.</li>
	<li>Tabla de desarrollo del Súper Avance que debe indicar el estado del servicio de la deuda emitido por la entidad contratante a la fecha de fallecimiento.</li>
	<li>Otros Antecedentes que se estimen convenientes y necesarios para la evaluación del siniestro.</li>
</ul>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>Plazo de Pago de Siniestros</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">El período de liquidación y pago de siniestro, a contar de la fecha de
recepción conforme a todos los antecedentes indicados en la póliza, no podrá exceder de 10 días hábiles. Tratándose de siniestros que
no vengan acompañados de la documentación pertinente o en que se requiera de un mayor análisis, la Compañía se reserva el derecho
de contabilizar este plazo desde que se reciban tales antecedentes o los exigidos en forma excepcional. En este último evento, la
Compañía deberá informar al Corredor a más tardar dentro de los 5 días hábiles siguientes a la presentación del siniestro.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center><b>Notas Importantes</b></center>
		</td>
	</tr>
</table>
<ol>
	<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">El asegurado declara estar en conocimiento de; a) El asegurado
declara conocer, haber sido previa y completamente informado y aceptar las condiciones señaladas en esta Solicitud de
Incorporación y Certificado de Cobertura que suscribe en manifestación de su voluntad de contratar el seguro. b) El
asegurado ha tomado conocimiento del derecho a decidir sobre la contratación voluntaria del seguro y la libre elección de la
compañía aseguradora. c) El contratante colectivo de la Póliza N° <?= $datos["nroPoliza2"]?> será Solventa Tarjetas S.A. d) Las coberturas tendrán
vigencia desde la firma del asegurado. En este caso la presente solicitud hará las veces de certificado de cobertura conforme a la circular N° 2123 de la Comisión Para el Mercado Financiero.</p>
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">La presente Solicitud de Incorporación y Certificado de Cobertura
es un resumen con la descripción general del seguro, sus coberturas y el procedimiento a seguir en caso de siniestro. El resumen de los
seguros es parcial y no reemplaza a las condiciones particulares ni generales de las respectivas pólizas y sólo tienen un carácter
informativo. En caso de requerir una copia de las Condiciones generales y particulares del seguro, el cliente debe solicitarlas a BCI Seguros Vida S.A.</p>
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Vigencia de la Póliza Colectiva: La póliza colectiva tendrá
vigencia desde las 00:00 horas del día 01 de Septiembre de 2021 hasta las 24:00 horas del día 31 de Agosto de 2022 y se renovará
tácita y sucesivamente en los mismos términos, por periodos de 1 año cada uno, salvo voluntad en contrario dada por el contratante o
la aseguradora, según corresponda, por medio de carta certificada notarial enviado al domicilio de la parte correspondiente.</p>
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Vigencia de la Póliza Individual: Para aquellas personas que
cumplan con los requisitos de asegurabilidad, la cobertura comenzará a regir a partir de la fecha de firma de la Solicitud de
Incorporación y se mantendrá vigente hasta la extinción del Súper Avance que le fue otorgado por Solventa Tarjetas S.A.</p>

<p class="new-page"></p>
<div title="header">
<img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br>
</div>

	<li>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"> 	Ante cualquier consulta y/o reclamo puede llamar al Servicio al
	Cliente de BCI Seguros desde teléfono fijo al 600 6000 292 o desde 	celulares al 02 2679 9700 de Lunes a Jueves de 08:30 horas a 19:00
	horas, y Viernes de 08:30 horas a 17:00 horas.</p>
	<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"> Obligación de Informar: La contratación de estos seguros es de
	carácter voluntario. Usted puede retractarse si la contratación la 	efectuó por un medio a distancia. Además, usted puede terminar los
	seguros voluntarios anticipadamente en cualquier momento, independiente del medio utilizado para su contratación.”</p>
</ol>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center><b>Disposiciones Finales</b></center>
		</td>
	</tr>
</table>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>Código
de Autorregulación</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">BCI
Seguros se encuentra adherida al Código de Autorregulación de las
Compañías de Seguros y está sujeta al Compendio de Buenas
Prácticas Corporativas, que contiene un conjunto de normas
destinadas a promover una adecuada relación de las compañías de
seguros con sus clientes. Copia de este Compendio se encuentra en la
página web www.aach.cl.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Asimismo,
ha aceptado la intervención del Defensor del Asegurado cuando los
clientes le presenten reclamos en relación a los contratos
celebrados con ella. Los clientes pueden presentar sus reclamos ante
el Defensor del Asegurado utilizando los formularios disponibles en
las oficinas de BCI Seguros o a través de la página web
www.ddachile.cl</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>Información sobre atención de clientes y presentación de consultas y reclamos</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">En virtud de la circular nro. 2.131 de 28 de noviembre de 2013, las
compañías de seguros, corredores de seguros y liquidadores de siniestros, deberán recibir, registrar y responder todas las
presentaciones, consultas o reclamos que se les presenten directamente por el contratante, asegurado, beneficiarios o legítimos interesados o sus mandatarios.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Las presentaciones pueden ser efectuadas en todas las oficinas de las
entidades que se atienda público, presencialmente, por correo postal, medios electrónicos, o telefónicamente, sin formalidades,
en el horario normal de atención.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Recibida una presentación, consulta o reclamo, ésa deberá ser respondida en
el plazo más breve posible, el que no podrá exceder de 20 días hábiles contados desde su recepción.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Interesado, en caso de disconformidad respecto de lo informado, o bien cuando
exista demora injustificada de la respuesta, podrá recurrir a la Comisión Para el Mercado Financiero, área de protección al
inversionista y asegurado, cuyas oficinas se encuentran ubicadas en avda. <span lang="pt-BR">Libertador Bernardo O’Higgins 1449 piso 1,
Santiago, o a través del sitio web <a href="http://www.cmfchile.cl/">www.cmfchile.cl</a>.</span></p>
<p lang="pt-BR" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><br/>

</p>
<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Tabla de Diversificación de Producción</b>
		</td>
	</tr>
</table>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Infórmese en la Comisión Para el Mercado Financiero sobre la Garantía mediante boleta bancaria o póliza que, conforme a la Ley, deben constituir los corredores de seguros.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">&nbsp;</p>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">La información sobre la diversificación de los negocios de esta
corredora y de las entidades aseguradoras con que haya trabajado, así como la información de las pólizas de seguros contratadas para
responder del cumplimiento de sus obligaciones como intermediaria y en cumplimiento a la ley y a las instrucciones impartidas por la
Comisión Para el Mercado Financiero, informamos que durante el año calendario anterior intermediamos contratos de seguros con las
compañías que se indican en la FECU 2020 de Arthur J. Gallagher Corredores de Seguros S.A. (Art. 57 DFL 251) son las siguientes:</p>

<table width="100%" cellpadding="3" cellspacing="0" border="1" style="font-size: 9px;">
	<tbody>
		<tr>
			<td colspan="2" width="40%" height="5" bgcolor="#ffffff" align="center" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<b>NOMBRE CÍA DE SEGUROS VIDA</b>
			</td>
			<td colspan="2" width="60%" bgcolor="#ffffff" align="center" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<b>NOMBRE CÍA DE SEGUROS GENERALES</b>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<font color="#000000">BCI SEGUROS DE VIDA S.A.</font>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">52,23%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>MAPFRE COMPAÑIA DE SEGUROS GENERALES DE CHILE S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">17,10%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">CHILENA VIDA </font>
				</p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">14,56%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>SEGUROS GENERALES SURAMERICANA S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">14,05%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">BICE VIDA </font>
				</p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">6,65%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>LIBERTY COMPAÑIA DE SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">12,65%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">VIDA SECURITY</font></p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">5,97%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>CHILENA CONSOLIDADA SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">10,30%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">SURA VIDA </font>
				</p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">5,24%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>CHUBB DE CHILE
				</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">8,36%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">VIDA CAMARA </font>
				</p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">3,95%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>REALE CHILE SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">7,22%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">BUPA VIDA </font>
				</p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">3,19%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>COMPAÑIA DE SEGUROS GENERALES CONTINENTAL S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">6,71%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">CONSORCIO VIDA</font></p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">2,92%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>FID CHILE SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">5,83%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">HDI VIDA</font></p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">2,87%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>BCI SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">3,67%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">COLMENA VIDA </font>
				</p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">0,89%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>RENTA NACIONAL CIA.DE SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">3,02%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">METLIFE VIDA</font></p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">0,85%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>HDI SEGUROS S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">3,00%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">CHUBB VIDA</font></p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">0,61%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>ORION SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">2,81%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">MAPFRE VIDA</font></p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">0,04%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>SOUTHBRIDGE COMPAÑIA DE SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">2,35%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">SAVE BCI VIDA </font>
				</p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">0,01%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>UNNIO SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">1,05%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
      <td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p><font color="#000000">BANCHILE VIDA </font>
				</p>
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><font color="#000000">0,01%</font></p>
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>CONTEMPORA
				</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">0,59%</p>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
      <td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm" >
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: none; solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: none; padding-right: 0.19cm">
				<p>CONSORCIO NACIONAL DE SEGUROS
				</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: none; solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: none; padding-right: 0.19cm">
				<p align="center">0,50%</p>
			</td>
		</tr>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm" >
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>SUAVAL
				</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">0,16%</p>
			</td>
		</tr>
		<tr>
			<td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>ASEGURADORA PORVENIR S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">0,15%</p>
			</td>
		</tr>
		<tr>
      <td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm" >
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>STARR INTERNATIONAL SEGUROS GENERALES S.A.</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">0,15%</p>
			</td>
		</tr>
		<tr>
      <td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm" >
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>SOLUNION</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">0,14%</p>
			</td>
		</tr>
		<tr>
      <td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm" >
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>COFACE</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">0,09%</p>
			</td>
		</tr>
		<tr>
      <td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm" >
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>ORSAN</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center">0,06%</p>
			</td>
		</tr>
		<tr>
      <td width="20%" height="6" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm">
			</td>
			<td width="20%" bgcolor="#ffffff" style="background: #ffffff" style="border-top: none; border-bottom: none; border-left: none; border-right: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0cm; padding-right: 0.19cm" >
			</td>
			<td width="50%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p>AVLA</p>
			</td>
			<td width="10%" bgcolor="#ffffff" style="background: #ffffff" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
				<p align="center"><a name="_Hlk80708109"></a>0,03%</p>
			</td>
		</tr>
	</tbody>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="font-size: 10px;">
<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" valign="top" align="center"><b>Anexo N° 1</b></td>
	</tr>
	<tr>
		<td width="100%" valign="top" align="center"><b>INFORMACIÓN DE LAS COMISIONES CIRCULAR Nº 2123</b></td>
	</tr>
	<tr>
		<td width="100%" valign="top" align="center"><b>(COMISIÓN PARA EL MERCADO FINANCIERO)</b></td>
	</tr>
</col>
</table>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">De acuerdo a lo instruido en la circular N° 2123  de fecha de 22 de
Octubre de 2013 de la Comisión Para el Mercado Financiero (CMF), le informamos que las comisiones pagadas por BCI Seguros Vida S.A.,
respecto de la prima pagada por usted son las siguientes:</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>Comisión de Intermediación</b><br/>
Arthur J. Gallagher Corredores de Seguros S.A.<br/>
RUT: 77.682.370-8<br/>
Comisión: 5% + IVA sobre la prima neta recaudada.<br/><br/>
<b>Comisión de Recaudación</b><br/>
Solventa Tarjetas S.A.<br/>
RUT: 96.776.000-5<br/>
Comisión: 62,73% (exenta de IVA), sobre la prima neta recaudada.<br/><br/>
<b>Comisión Uso de Canal</b><br/>
Solventa Tarjetas S.A.<br/>
RUT: 96.776.000-5<br/>
Comisión: 8,37% + IVA, sobre la prima neta recaudada.<br/>
</p>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<table width="100%" cellpadding="0" cellspacing="0" style="font-size: 10px;">
<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" valign="top" align="center"><b>Anexo N° 2</b></td>
	</tr>
	<tr>
		<td width="100%" valign="top" align="center"><b>(Circular N° 2106 Comisión Para el Mercado Financiero)</b></td>
	</tr>
	<tr>
		<td width="100%" valign="top" align="center"><b>PROCEDIMIENTO DE LIQUIDACIÓN DE SINIESTROS</b></td>
	</tr>
</col>
</table>

<ol>
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>OBJETO DE LA LIQUIDACIÓN </b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">La liquidación tiene por fin establecer la ocurrencia de un siniestro,
determinar si el siniestro está cubierto en la póliza contratada en una compañía de seguros determinada, y cuantificar el monto de la
pérdida y de la indemnización a pagar.<br/>El procedimiento de liquidación está sometido a los principios de celeridad y economía procedimental, de objetividad y carácter técnico y de transparencia y acceso.</p>
</ol>

<ol start="2">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>FORMA DE EFECTUAR LA LIQUIDACIÓN </b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">La
liquidación puede efectuarla directamente la Compañía o
encomendarla a un Liquidador de Seguros. La decisión debe
comunicarse al Asegurado dentro del plazo de tres días hábiles
contados desde la fecha de la denuncia del siniestro.
</p>
</ol>
<ol start="3">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>DERECHO DE OPOSICIÓN A LA LIQUIDACIÓN DIRECTA </b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">En
caso de liquidación directa por la compañía, el Asegurado o
beneficiario puede oponerse a ella, solicitándole por escrito que
designe un Liquidador de Seguros, dentro del plazo de cinco días
hábiles contados desde la notificación de la comunicación de la
Compañía. La Compañía deberá designar al Liquidador en el plazo
de dos días hábiles contados desde dicha oposición.</p>
</ol>
<ol start="4">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>INFORMACIÓN AL ASEGURADO DE GESTIONES A REALIZAR Y PETICION DE ANTECEDENTES</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">El
Liquidador o la Compañía deberá informar al Asegurado, por
escrito, en forma suficiente y oportuna, al correo electrónico
(informado en la denuncia del siniestro) o por carta certificada (al
domicilio señalado en la denuncia de siniestro), de las gestiones
que le corresponde realizar, solicitando de una sola vez, cuando las
circunstancias lo permitan, todos los antecedentes que requiere para
liquidar el siniestro.
</p>
</ol>
<ol start="5">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>PRE-INFORME DE LIQUIDACIÓN</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">En
aquellos siniestros en que surgieren problemas y diferencias de
criterios sobre sus causas, evaluación del riesgo o extensión de la
cobertura, podrá el Liquidador, actuando de oficio o a petición del
Asegurado, emitir un pre-informe de liquidación sobre la cobertura
del siniestro y el monto de los daños producidos, el que deberá
ponerse en conocimiento de los interesados. El asegurado o la
Compañía podrán hacer observaciones por escrito al pre-informe
dentro del plazo de cinco días hábiles desde su conocimiento.</p>
</ol>

<ol start="6">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>PLAZO DE LIQUIDACIÓN </b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><u>Dentro
del más breve plazo</u>, no pudiendo exceder de <u><b>45 días</b></u>
corridos desde fecha denuncio, a excepción de;</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">a)
Siniestros que correspondan a seguros individuales sobre riesgos del
Primer Grupo cuya prima anual sea superior a 100 UF: <u><b>90 días</b></u>
corridos desde fecha denuncio;
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">b)
Siniestros marítimos que afecten a los cascos o en caso de Avería
Gruesa: <u><b>180 días</b></u> corridos desde fecha denuncio.</p>
</ol>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<ol start="7">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>PRORROGA DEL PLAZO DE LIQUIDACIÓN</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Los
plazos antes señalados podrán, excepcionalmente siempre que las
circunstancias lo ameriten, prorrogarse, sucesivamente por iguales
períodos, informando los motivos que la fundamenten e indicando las
gestiones concretas y específicas que se realizarán, lo que deberá
comunicarse al Asegurado y a la Comisión Para el Mercado Financiero,
pudiendo esta última dejar sin efecto la ampliación, en casos
calificados, y fijar un plazo para entrega del Informe de
Liquidación. No podrá ser motivo de prórroga la solicitud de
nuevos antecedentes cuyo requerimiento pudo preverse con
anterioridad, salvo que se indiquen las razones que justifiquen la
falta de requerimiento, ni podrán prorrogarse los siniestros en que
no haya existido gestión alguna del liquidador, registrado o
directo.
</p>
</ol>
<ol start="8">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>INFORME FINAL DE LIQUIDACIÓN</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">El
informe final de liquidación deberá remitirse al Asegurado y
simultáneamente al Asegurador, cuando corresponda, y deberá
contener necesariamente la transcripción íntegra de los artículos
26 y 27 del Reglamento de Auxiliares del Comercio de Seguros (D.S. de
Hacienda Nº 1.055, de 2012, Diario Oficial de 29 de diciembre de
2012).</p>
</ol>
<ol start="9">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;"><b>IMPUGNACION INFORME DE LIQUIDACIÓN</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">Recibido el informe de Liquidación, la Compañía y el Asegurado dispondrán de un plazo de diez días hábiles para impugnarla. En caso de
liquidación directa por la Compañía, este derecho sólo lo tendrá el Asegurado.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size: 10px;">
Impugnado el informe, el Liquidador o la compañía dispondrá de un plazo de 6
días hábiles para responder la impugnación.</p>
</ol>
</body>
</html>
