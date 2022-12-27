<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title></title>
<link rel="stylesheet" href="img/bootstrap.min.css">
<style type="text/css">
@page { margin-left: .27cm; margin-right: 1.27cm; margin-top: 1.25cm; margin-bottom: 1.25cm }
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
<body>
<div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 10px;">
	<tr>
		<td colspan="2" width="100%" valign="top" align="center">
			<b>SOLICITUD DE INCORPORACIÓN Y CERTIFICADO DE COBERTURA</b><br/>
      <b>SEGURO DE HOSPITALIZACIÓN POR ACCIDENTE + ITP 2/3</b>
		</td>
	</tr>
  <tr>
		<td width="50%" valign="top" align="left" >
			<b>Fecha <?=date("d")?>/<?=date("m")?>/<?=date("Y")?></b>
		</td>
    <td width="50%" valign="top" align="right">
			<b>Nro. <?= $datos["coberturaSeguro1"]?></b>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="3" cellspacing="0" style="font-size: 9px;">
	<tr>
		<td colspan="6" width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center><b>Certificado de Cobertura – De Hospitalización Por Accidente +ITP 2/3 <?= $datos["canalVenta"]?> </b></center>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p><b>Identificación del Asegurado Titular</b></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p style="margin-left: 15px">Nombre: <?= $datos["nameClient"]?></p>
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
			<p>Dirección: <?= $datos["calle"] ?> </p>
		</td>
		<td colspan="2" width="25%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>N°: <?= $datos["numCalle"] ?> </p>
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
				<p style='margin-left: 20px;'>Sexo: M [X]     F [ ]</p>
		<?php else: ?>
				<p style='margin-left: 20px;'>Sexo: M [ ]     F [X]</p>
		<?php endif; ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2" width="30%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Correo Electrónico:</p>
			<p><?= $datos["email"] ?></p>
		</td>
		<td colspan="4" width="70%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify" style="margin-bottom: 0cm">Autorizo que toda comunicación y notificación que diga relación
			con el presente seguro me sea enviada al correo electrónico señalado en esta Solicitud de Incorporación.</p>
			<p>SI [X]   NO[ ]</p>
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
			<p><strong>Antecedentes del Contratante</strong></p>
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
		<td colspan="6" width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
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
			<p>Prima Única del Seguro: $<?= $datos["costoTotalSeguro1"]?></p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Asegurados</b>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify">Personas naturales, tarjetahabientes de Tarjeta de Crédito Cruz Verde que soliciten un Súper Avance, que cumplan los requisitos de asegurabilidad.</p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p align="justify"><strong>IMPORTANTE</strong>: Usted está solicitando su incorporación como asegurado a una póliza o contrato de seguro colectivo cuyas condiciones han sido convenidas por Solventa
			Tarjetas S.A., directamente con la compañía de seguros.</p>
		</td>
	</tr>
	<tr>
		<td colspan="6" width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Detalle de Coberturas</b>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4" width="50%" height="6" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center><b>Coberturas</b></center>
		</td>
		<td colspan="2" width="50%" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center><b>Código C.M.F.</b></center>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>Renta Diaria por Hospitalización por Accidente</p>
		</td>
		<td colspan="2" width="50%" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center style="margin-left: 1.25cm; text-indent: -1.25cm">
			POL 3 2013 0085, Alt. I</center>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4" width="50%" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p>ITP 2/3 por Accidente o Enfermedad</p>
		</td>
		<td colspan="2" width="50%" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center style="margin-left: 1.25cm; text-indent: -1.25cm">
			POL 3 2017 0081</center>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 9px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<p style="margin-bottom: 0cm"><strong>DECLARACIÓN PERSONAL DE SALUD</strong></p>
			<p style="margin-bottom: 0cm"><br/>

			</p>
			<p style="margin-bottom: 0cm">Se le ha diagnosticado, se encuentra en estudio por un hallazgo médico, se encuentra en tratamiento o
			tiene conocimiento de padecer o haber padecido: Diabetes Mellitus tipo 1 o 2, Cáncer en todos sus estados (incluye leucemia,
			linfomas y melanoma maligno), Enfermedades cardiacas, by-pass coronario, enfermedades a las coronarias, soplos cardiacos,
			arritmias, Insuficiencia renal aguda y/o crónica , Obesidad (Índice de masa corporal superior a 30%), Enfermedades
			neurológicas: accidente vascular cerebral, esclerosis múltiple, aneurismas, Trasplantado de corazón, pulmón, riñón, hígado,
			páncreas y médula ósea, Enfermedades respiratorias : Enfermedad pulmonar obstructiva crónicas (EPOC), fibrosis quística,
			bronquitis obstructiva crónica, asma, secuelas de COVID-19; Enfermedades gástricas: Daño hepático crónico, hepatitis (B o C), Cirrosis hepática.
			</p>
			<p style="margin-bottom: 0cm"><b>SI: [ ] NO: [X]</b></p>
			<p style="margin-bottom: 0cm"><br/>

			</p>
			<p style="margin-bottom: 0cm">Usted ha sido dictaminado o se le ha otorgado o se encuentra tramitando su Invalidez por alguna
			Comisión Médica (AFP/Compin/Mutuales/Capredena) a causa de una enfermedad o accidente.</p>
			<p style="margin-bottom: 0cm"><b>SI: [ ] NO: [X]</b></p>
			<p style="margin-bottom: 0cm"><br/>
			</p>
			<p style="margin-bottom: 0cm"><br/>
			</p>
		</td>
	</tr>
	</table>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
<col width="100%">
<tr>
	<td width="100%" valign="top" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
		<p style="margin-bottom: 0cm">¿Hace uso de moto de cilindrada
		mayor a 250 cc?. ¿Es piloto de o pasajero de vuelos no regulares?</p>
		<p style="margin-bottom: 0cm"><b>SI: [ ] NO: [X]</b></p>
		<p style="margin-bottom: 0cm"><br/>

		</p>
		<p style="margin-bottom: 0cm">Frente a respuesta afirmativa (SI)
		no se puede emitir la póliza de seguro</p>
		<p style="margin-bottom: 0cm"><br/>

		</p>
		<p style="margin-bottom: 0cm">Confirmo la veracidad y exactitud de las declaraciones que he formulado
		precedentemente, manifestando que nada he ocultado, omitido o
		alterado y me doy por enterado que dichas declaraciones
		constituyen para la Compañía aseguradora información
		determinante del riesgo que se le propone asegurar y en
		consecuencia, si hubiere incurrido en un inexcusable error,
		reticencia o inexactitud, el asegurador tendrá derecho para
		rescindir el contrato, de acuerdo a lo dispuesto en el artículo
		525 del Código de Comercio.<br/>
    El asegurado deberá informar al asegurador los hechos o circunstancias que agraven sustancialmente el riesgo declarado y
		sobrevengan con posterioridad a la celebración del contrato, de acuerdo a lo dispuesto en el artículo 526 del Código de Comercio.<br/>
    Declaro estar dispuesto a someterme voluntariamente a exámenes y pruebas
		médicas, si la Compañía así lo requiere, con ocasión de la evaluación y/o suscripción del riesgo por su parte, y asimismo,
		para el caso de siniestro. Adicionalmente, autorizo expresamente a
		cualquier médico, profesional de la salud, institución de salud
		pública o privada, tribunales de justicia, jueces árbitros y a
		cualquier otra persona natural o jurídica, pública o privada,
		incluidas las Superintendencias de la Salud, de Isapres y de
		Valores y Seguros, que cuente con datos, información o
		antecedentes relativos a mi estado de salud física y psíquica;
		tales como fichas clínicas, antecedentes clínicos, informes
		médicos y análisis o exámenes de laboratorio clínicos, para
		entregar dichos datos, información o antecedentes a la Compañía,
		cuando esta lo solicite, para lo cual otorgo mi expreso
		consentimiento conforme lo dispone la Ley Nº19.628 y el artículo
		127 del Código Sanitario. Además autorizo a la Compañía a
		realizar el tratamiento de la información antes señalada, todo
		ello conforme lo dispone la Ley 19.628. El consentimiento y
		autorizaciones precedentes se otorgan en forma irrevocable y por
		toda la vigencia del seguro, incluyendo la etapa de evaluación y
		durante el procedimiento de liquidación de cualquier siniestro,
		autorizaciones que no se extinguirán en caso de muerte, conforme
		lo establece el artículo 2169 del Código Civil. Por otra parte
		la Compañía se obliga a guardar absoluta reserva y
		confidencialidad respecto de la información recibida.
		</p>
		<p style="margin-bottom: 0cm"><br/>

		</p>
		<p>Declaro recibir conforme en este acto una copia del presente instrumento</p>
	</td>
</tr>
</table>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><br/>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Solicitud
de Incorporación, Mandato y Autorización de Cargo en Súper Avance.</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Mediante
la presente Solicitud de Incorporación y Certificado de Cobertura
solicito ser incorporado a esta póliza colectiva cuyos términos,
naturaleza, condiciones de asegurabilidad, cobertura, vigencia,
exclusiones, comisiones y demás características declaro conocer a
cabalidad por haberme sido explicadas y por haber tenido a la vista,
previo a mi firma, el certificado de cobertura y, las condiciones
particulares y generales que se detallan suficientemente. Declaro
además, que contrato voluntario e informadamente este seguro.
Asimismo otorgo mandato y faculto a Solventa Tarjetas S.A. para
incorporarme en calidad de asegurado, a la póliza colectiva:<b>
</b><?= $datos["nroPoliza1"]?> y agregar el valor de la prima única, al monto del Súper
Avance que me ha sido otorgado por Solventa Tarjetas S.A. El
mandatario rendirá cuenta de su mandato entregándole al asegurado
al momento de contratar el avance una liquidación del Súper Avance,
en donde se indique el cargo de la prima correspondiente. El cliente
asegurable autoriza a Solventa Tarjetas S.A y a la Compañía
Aseguradora, para que los datos suministrados sean utilizados para la
administración y auditoría del seguro contratado, el ofrecimiento
de otros seguros u otros avances en los que pudiere estar interesado.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Mediante la siguiente firma, acepto la contratación de este seguro.</p>


<p style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
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

</p>

<p class="new-page"></p>

<div title="header">
<img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br>
</div>

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
	<col width="100">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center><b>Descripción de Coberturas y Condiciones de Asegurabilidad</b></center>
		</td>
	</tr>
</table>
<p style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Materia y Monto
Asegurado</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">La
cobertura de Beneficio diario por hospitalización por accidente
pagará al asegurado por cada 15 días de hospitalización a causa de
un accidente el valor de una cuota del crédito, de acuerdo a lo
siguiente:</p>
<ul style="font-size: 10px;">
	<li> Desde 1 y 15 días de hospitalización: 1ra cuota</li>
	<li> Desde 16 y 30 días de hospitalización: 2da cuota</li>
	<li> Desde 31 y 45 días de hospitalización: 3ra cuota</li>
	<li> Desde 46 y 60 días de hospitalización: 4ta cuota</li>
	<li> Desde 61 y 75 días de hospitalización: 5ta cuota</li>
	<li> Desde 76 y 90 días de hospitalización: 6ta cuota</li>
</ul>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Lo
anterior es independiente del gasto real en que haya incurrido el
asegurado.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">El
tope máximo de días a pagar es de 90 días.</p>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Además,
en el evento que el Asegurado resulte con una Invalidez Total y
Permanente 2/3, como consecuencia de un accidente o una enfermedad
ocurrido durante la vigencia de esta póliza, la Compañía
Aseguradora pagará el Capital Asegurado, correspondiente al Saldo
Insoluto de la deuda, que será pagado a Solventa.</p>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Se
define la cobertura de ITP 2/3 como la pérdida o disminución de las
fuerzas físicas o intelectuales que sufra el asegurado y que
ocasione un menoscabo irreversible de, al menos, 2/3 (dos tercios) de
su capacidad de trabajo, evaluado conforme a las &quot;Normas para la
evaluación y calificación del grado de invalidez de los
trabajadores afiliados al nuevo sistema de pensiones&quot;, regulado
por el D.L. Nº 3.500 de 1980</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">En
todo caso, para efectos de esta póliza, siempre se considerará como
Invalidez Total y Permanente 2/3 los siguientes casos: La pérdida
total de:
</p>
<ul style="font-size: 10px;">
	<li> la visión de ambos ojos, o</li>
	<li> ambos brazos, o</li>
	<li> ambas manos, o</li>
	<li> ambas piernas, o</li>
	<li> ambos pies, o</li>
	<li> una mano y un pie.</li>
</ul>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Se
establece un tope de indemnización igual a UF 180 en caso de la
cobertura de ITP 2/3, y en el caso de la cobertura de hospitalización
el tope es igual a UF 60, considerando la suma de todas las cuotas, y
el tope a pagar por cuota es de UF 10.
</p>
<p style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Requisitos de Asegurabilidad</b><br/><br/>Límites de edad Titular</p>
<ul style="font-size: 10px;">
<li>Edad mínima de ingreso: 18 años</li>
<li>Edad máxima de ingreso: 74 años y 364 días </li>
<li>Edad máxima de permanencia: 79 años y 364 días </li>
<li>Todo asegurado deberá llenar una DPS/DPA al contratar el seguro.</li>
</ul>

<p style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Beneficiarios</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
Mientras el Súper Avance se encuentre vigente, el beneficiario será Solventa Tarjetas S.A.
</p>

<p style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Renta Diaria por Hospitalización por Accidente (POL 3 2013 0085, Alt. I)</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
En virtud de esta cobertura, la compañía aseguradora pagará si el Asegurado se encuentra hospitalizado por más de 24 horas continuas
en un Establecimiento Hospitalario a causa de accidente cubierto por esta póliza, se pagará la renta diaria que se indica en las Condiciones Particulares, independientemente del gasto real.
</p>
<p style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">&nbsp;</p>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>
</br>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
<b>ITP 2/3 por Accidente o Enfermedad (POL 3 2017 0081, Artículo 3)</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Mediante el presente contrato de seguros, la Compañía Aseguradora se
compromete a indemnizar, de acuerdo a los términos, condiciones y exclusiones de esta póliza. Se podrá contratar una cualquiera de
las siguientes secciones de cobertura, la que deberá estar expresamente consignada en las Condiciones Particulares:
<br>
a) Cobertura de Invalidez Total Permanente 2/3 por accidente En el
evento que el Asegurado resulte con una Invalidez Total y Permanente
2/3, como consecuencia de un accidente ocurrido durante la vigencia
especificada en las Condiciones Particulares de la póliza, la
Compañía Aseguradora pagará el Capital Asegurado estipulado en
dichas Condiciones Particulares. <br>
b) Cobertura de Invalidez Total Permanente 2/3 por accidente o
enfermedad En el evento que el Asegurado resulte con una Invalidez
Total y Permanente 2/3, como consecuencia de un accidente o una
enfermedad ocurrido durante la vigencia especificada en las
Condiciones Particulares de ésta póliza, la Compañía Aseguradora
pagará el Capital Asegurado estipulado en dichas Condiciones
Particulares.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
<b>Prima del Seguro</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">La
prima será única, y se calculará multiplicando la tasa bruta
15,47% por el monto inicial del súper avance.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Se considera una prima tope igual a $238.000.</p>

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Exclusiones</b>
		</td>
	</tr>
</table>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Exclusiones
Cobertura Renta Diaria por Hospitalización por Accidente (POL 3 2013 0085, Artículo 4)</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">No
se pagará el monto asegurado para esta póliza cada cobertura
asociada a esta póliza cuando el fallecimiento, lesiones, cirugías
u hospitalizaciones por accidente, A consecuencia de:
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">a)
Efectos de guerra, declarada o no declarada, invasión, acción de un
enemigo extranjero, hostilidades u operaciones bélicas, ya sea con o
sin declaración de guerra, así como tampoco ningún ejercicio o
práctica de guerra.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">b)
Peleas o riñas, salvo en aquellos casos en que se establezca
judicialmente que se ha tratado de legítima defensa.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">c)
Comisión de actos que puedan ser calificados como delito, así como
la participación activa en rebelión, revolución, sublevación,
asonadas, motín, conmoción civil, subversión y terrorismo.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">d)
Suicidio, intento de suicidio, o heridas auto infringidas, ya sea que
el asegurado haya estado en su pleno juicio o enajenado mentalmente.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">e)
Prestación de servicios del asegurado en las Fuerzas Armadas o
funciones policiales de cualquier tipo. Para todos los efectos de
esta póliza las funciones de policía incluyen además las funciones
de policía civil y gendarmería.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">f)
Participación en carreras, apuestas, competencias y desafíos que
sean remunerados o sean la ocupación principal del asegurado.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">g)
Intoxicación o encontrarse el asegurado bajo los efectos de
cualquier narcótico o droga a menos que hubiese sido administrado
por prescripción médica. Dicha circunstancia se acreditará
mediante la documentación expedida por los organismos
correspondientes.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">h)
La conducción de cualquier vehículo por parte del asegurado,
encontrándose éste en estado de ebriedad, conforme a los límites
establecidos en la normativa vigente a la fecha del siniestro. Dicha
circunstancia se acreditará mediante la documentación expedida por
los organismos correspondientes.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">i)
Negligencia o imprudencia o culpa grave del asegurado.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">j)
Realización o participación en una actividad o deporte riesgoso,
considerándose como tales aquellos que objetivamente constituyan una
flagrante agravación del riesgo o se requiera de medidas de
protección o seguridad para realizarlos. A vía de ejemplo y sin que
la enumeración sea taxativa o restrictiva sino que meramente
enunciativa, se considera actividad o deporte riesgoso el manejo de
explosivos, minería subterránea, trabajos en altura o líneas de
alta tensión, inmersión submarina, piloto civil, paracaidismo,
montañismo, alas delta, benji, parapente, carreras de auto y moto,
entre otros.
</p>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">&nbsp;</p>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div></br>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">k)
Realización de una actividad o deporte que las partes hayan acordado
excluir de la cobertura, al no aceptar el asegurado un recargo en las
primas y el correspondiente aumento de los costos de cobertura
asociados. De dicha exclusión deberá dejarse constancia detallada
en las condiciones particulares de la póliza.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">l)
Desempeñarse el asegurado como piloto o tripulante de aviones
comerciales a menos que expresa y específicamente se prevea y acepte
su cobertura por la compañía aseguradora.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">m)
Riesgos nucleares o atómicos.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">n)
Movimientos sísmicos desde el grado 8 inclusive en la escala de
Mercalli, determinado por el Servicio Sismológico del Departamento
de Centro Sismológico Nacional o del servicio que en el futuro lo
reemplace.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">o)
Viaje o vuelo en vehículo aéreo de cualquier clase, excepto como
pasajero en uno sujeto a itinerario, operado por una empresa de
transporte aéreo comercial, sobre una ruta establecida para el
transporte de pasajeros.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">p)
Quemaduras resultantes de la exposición al sol o del uso de lámparas
o de rayos ultravioletas para fines estéticos.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">q)
Fractura de Huesos producida como consecuencia directa e inmediata de
osteoporosis</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><br/>

</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Exclusiones Cobertura ITP 2/3 por Accidente o Enfermedad</b><b> (POL 3 2017 0081,
Articulo 4)</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">No
se efectuará el pago de las cantidades establecidas en las
condiciones particulares de la póliza cuando la Invalidez Total y
Permanente 2/3 se produzca a consecuencia, directa o indirecta, de:
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">a)
Peleas o riñas, salvo en aquellos casos en que se establezca
judicialmente que se ha tratado de legítima defensa.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">b)
Comisión de actos calificados como delito por la ley.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">c)
Hechos deliberados que cometa el Asegurado, tales como los intentos
de suicidio, lesiones autoinferidas, abortos provocados, ya sea
estando en su pleno juicio o enajenado mentalmente.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">d)
Participación activa del Asegurado en rebelión, revolución, poder
militar, terrorismo, sabotaje, tumulto o conmoción contra el orden
público, dentro o fuera del país.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">e)
Guerra civil o internacional, sea o no declarada, invasión, acción
de un enemigo extranjero, hostilidades u operaciones bélicas, ya
sean con o sin declaración de guerra.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">f)
Prestación de servicios del Asegurado en las Fuerzas Armadas o
funciones policiales de cualquier tipo, a menos que expresa y
específicamente se prevea y acepte su cobertura por el Asegurador en
las Condiciones Particulares de la póliza.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">g)
La participación del Asegurado en actos temerarios o en cualquier
maniobra, experimento, exhibición o desafío, entendiendo por tales
aquellas donde se pone en grave peligro la vida e integridad física
de las personas.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">h)
Participación en carreras, apuestas, competencias y desafíos que
sean remunerados o sean la ocupación principal del Asegurado.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">i)
Intoxicación o encontrarse el Asegurado en estado de ebriedad, o
bajo los efectos de cualquier narcótico a menos que hubiese sido
administrado por prescripción médica. Estos estados deberán ser
calificados por la autoridad competente.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">j)
Desempeñarse el Asegurado como piloto o tripulante de aviones
civiles o comerciales, a menos que expresa y específicamente se
prevea y acepte su cobertura por el Asegurador en las Condiciones
Particulares de la póliza.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">k)
Riesgos nucleares o atómicos.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">l)
Movimientos sísmicos desde el grado 8 inclusive de la escala
modificada de Mercalli, determinado por el Servicio Sismológico del
Departamento de Geofísica de la Universidad de Chile, o del servicio
que en el futuro lo reemplace.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">m) Anomalías congénitas, y los trastornos que sobrevengan por tales anomalías o se relacionen con ellas.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">n) Infecciones bacterianas, excepto las infecciones piogénicas que sean
consecuencia de una herida, cortadura o amputación accidental.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">p) Tratamientos médicos o quirúrgicos distintos de los necesarios a
consecuencia de lesiones, accidente o enfermedad cubiertas por esta póliza.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">q) Embarazo, parto, aborto provocado o cualquier enfermedad relacionada
a los órganos de reproducción femeninos.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">s) Vuelo aéreo no regular.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">t) Una infección oportunística, o un neoplasma maligno, si al momento de la enfermedad el Asegurado sufría del Síndrome de
Inmunodeficiencia Adquirida. Con tal propósito, se entenderá por:</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">1- &quot;Síndrome de Inmunodeficiencia Adquirida&quot;, lo definido para tal efecto por la Organización Mundial de la Salud.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">2- Infección Oportunística incluye, pero no debe limitarse a Neumonía causada por Pneumocystis Carinii, Organismo de Enteritis Crónica, Infección Vírica o Infección Micobacteriana Diseminada.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">3- Neoplasma Maligno incluye, pero no debe limitarse al Sarcoma de Kaposi, al Linfoma del Sistema Nervioso Central o a otras afecciones malignas ya conocidas o que puedan conocerse como causas inmediatas de muerte en presencia de una inmunodeficiencia adquirida.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">4- Síndrome de Inmunodeficiencia Adquirida debe incluir Encefalopatía
(demencia) de V.I.H. (Virus de Inmunodeficiencia Humano) y Síndrome de Desgaste por V.I.H. (Virus de Inmunodeficiencia Humano).</p>

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Procedimiento de Denuncia de Siniestro</b>
		</td>
	</tr>
</table>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">A
continuación, se detallan los antecedentes mínimos y necesarios
para la liquidación del siniestro, por cada cobertura reclamada. Es
importante señalar que usted o el beneficiario de la póliza tiene
60 días de plazo, contados desde la ocurrencia del evento para
denunciar el mismo a BCI Seguros Vida S.A.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Importante:
En caso de no cumplir en el plazo señalado en la entrega de
antecedentes solicitados, usted podrá solicitar prorroga antes del
cumplimiento del plazo estipulado en el párrafo anterior, mediante
una carta o certificados emitido por la Institución informado la
tramitación del caso y fecha de entrega de documentación. Carta que
deberá ser despachada a BCI Seguros Vida S.A. para la ampliación
del plazo, el cual tendrá como plazo máximo 15 días.</p>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Requisitos Presentación de Siniestros</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Cobertura Renta Diaria por Hospitalización por Accidente</b></p>
<ul style="font-size: 10px;">
	<li>Formulario denuncio de siniestros</li>
	<li>Dato de atención de urgencia (D.A.U) en caso de hospitalización de urgencia</li>
	<li>Pre-factura con detalle de hospitalización</li>
	<li>Parte policial</li>
	<li>Copia de cédula de identidad del asegurado</li>
	<li>Epicrisis - carnet de alta</li>
	<li>Certificado del médico tratante (la cual debe contener diagnóstico,
	tratamiento, y fecha del accidente)</li>
</ul>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Cobertura ITP 2/3 por accidente o enfermedad </b></p>
<ul style="font-size: 10px;">
	<li>Formulario denuncio de siniestros</li>
	<li>Fotocopia de la Cédula nacional de identidad ambos lados</li>
	<li>Dictamen ejecutoriado en conformidad a las “Normas para la
	evaluación y calificación del grado de invalidez de los
	trabajadores afiliados al nuevo sistema de pensiones”.  Para las
	personas afiliadas al antiguo sistema previsional deberá presentarse
	el dictamen definitivo de invalidez otorgado por el COMPIN.  En caso
	de trabajadores independientes no cotizantes se deberá acreditar la
	invalidez a través de informes y antecedentes médicos emitidos por
	el o los profesionales que dictaminaron su incapacidad</li>
	<li>Informes médicos completos presentados a la Comisión Médica al
	momento de solicitar la invalidez</li>
	<li>Certificado de saldo de la deuda, emitido por la entidad contratante
	a la fecha del siniestro</li>
</ul>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">&nbsp;</p>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Otros
antecedentes que se estimen necesario y conveniente para la correcta
evaluación del siniestro reclamado.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Plazo de Pago de Siniestros</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">El período de liquidación y pago de siniestro, a contar de la fecha de
recepción conforme a todos los antecedentes indicados en la póliza, no podrá exceder de 10 días hábiles. Tratándose de siniestros que
no vengan acompañados de la documentación pertinente o en que se requiera de un mayor análisis, la Compañía se reserva el derecho
de contabilizar este plazo desde que se reciban tales antecedentes o los exigidos en forma excepcional. En este último evento, la
Compañía deberá informar al Corredor a más tardar dentro de los 5 días hábiles siguientes a la presentación del siniestro.</p>

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center><b>Notas Importantes</b></center>
		</td>
	</tr>
</table>
<ol>
	<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
	El asegurado declara estar en conocimiento de; a) El asegurado
	declara conocer, haber sido previa y completamente informado y
	aceptar las condiciones señaladas en esta Solicitud de
	Incorporación y Certificado de Cobertura que suscribe en
	manifestación de su voluntad de contratar el seguro.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
	b) El asegurado ha tomado conocimiento del derecho a decidir sobre la
	contratación voluntaria del seguro y la libre elección de la compañía aseguradora. c) El contratante colectivo de la Póliza N° <?= $datos["nroPoliza1"]?> será Solventa Tarjetas S.A. d) Las coberturas tendrán vigencia desde la firma del asegurado. En este caso la presente
	solicitud hará las veces de certificado de cobertura conforme a la circular N° 2123 de la Comisión Para el Mercado Financiero.</p>
	<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
	La presente Solicitud de Incorporación y Certificado de Cobertura
	es un resumen con la descripción general del seguro, sus coberturas
	y el procedimiento a seguir en caso de siniestro. El resumen de los
	seguros es parcial y no reemplaza a las condiciones particulares ni generales de las respectivas pólizas y sólo tienen un carácter
	informativo. En caso de requerir una copia de las Condiciones generales y particulares del seguro, el cliente debe solicitarlas a
	BCI Seguros Vida S.A.</p>
	<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
	Vigencia de la Póliza Colectiva: La póliza colectiva tendrá
	vigencia desde las 00:00 horas del día 01 de Septiembre de 2021
	hasta las 24:00 horas del día 31 de Agosto de 2022 y se renovará
	tácita y sucesivamente en los mismos términos, por periodos de 1
	año cada uno, salvo voluntad en contrario dada por el contratante o
	la aseguradora, según corresponda, por medio de carta certificada
	notarial enviado al domicilio de la parte correspondiente.</p>
	<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
	Vigencia de la Póliza Individual: Para aquellas personas que
	cumplan con los requisitos de asegurabilidad, la cobertura comenzará
	a regir a partir de la fecha de firma de la Solicitud de
	Incorporación y se mantendrá vigente hasta la extinción del Súper
	Avance que le fue otorgado por Solventa Tarjetas S.A.</p>
	<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
	Ante cualquier consulta y/o reclamo puede llamar al Servicio al
	Cliente de BCI Seguros desde teléfono fijo al 600 6000 292 o desde
	celulares al 02 2679 9700 de Lunes a Jueves de 08:30 horas a 19:00
	horas, y Viernes de 08:30 horas a 17:00 horas.</p>
	<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
	Obligación de Informar: La contratación de estos seguros es de
	carácter voluntario. Usted puede retractarse si la contratación la
	efectuó por un medio a distancia. Además, usted puede terminar los
	seguros voluntarios anticipadamente en cualquier momento,
	independiente del medio utilizado para su contratación.”</p>
</ol>
<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<center><b>Disposiciones Finales</b></center>
		</td>
	</tr>
</table>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Código
de Autorregulación</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">BCI
Seguros se encuentra adherida al Código de Autorregulación de las
Compañías de Seguros y está sujeta al Compendio de Buenas
Prácticas Corporativas, que contiene un conjunto de normas
destinadas a promover una adecuada relación de las compañías de
seguros con sus clientes. Copia de este Compendio se encuentra en la
página web www.aach.cl.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Asimismo,
ha aceptado la intervención del Defensor del Asegurado cuando los
clientes le presenten reclamos en relación a los contratos
celebrados con ella. Los clientes pueden presentar sus reclamos ante
el Defensor del Asegurado utilizando los formularios disponibles en
las oficinas de BCI Seguros o a través de la página web
www.ddachile.cl</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><br/>
</p>

<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Información
sobre atención de clientes y presentación de consultas y reclamos</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">En
virtud de la circular nro. 2.131 de 28 de noviembre de 2013, las
compañías de seguros, corredores de seguros y liquidadores de
siniestros, deberán recibir, registrar y responder todas las
presentaciones, consultas o reclamos que se les presenten
directamente por el contratante, asegurado, beneficiarios o legítimos
interesados o sus mandatarios.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Las
presentaciones pueden ser efectuadas en todas las oficinas de las
entidades que se atienda público, presencialmente, por correo
postal, medios electrónicos, o telefónicamente, sin formalidades,
en el horario normal de atención.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Recibida
una presentación, consulta o reclamo, ésa deberá ser respondida en
el plazo más breve posible, el que no podrá exceder de 20 días
hábiles contados desde su recepción.</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Interesado,
en caso de disconformidad respecto de lo informado, o bien cuando
exista demora injustificada de la respuesta, podrá recurrir a la
Comisión Para el Mercado Financiero, área de protección al
inversionista y asegurado, cuyas oficinas se encuentran ubicadas en
avda. <span lang="pt-BR">Libertador Bernardo O’Higgins 1449 piso 1,
Santiago, o a través del sitio web <a href="http://www.cmfchile.cl/">www.cmfchile.cl</a>.</span></p>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">&nbsp;</p>
<p class="new-page"></p><div title="header"><img src="img/logo_bci_seguros.png" border="0" style='margin-left: -50px;'/><br></div>

<table width="100%" cellpadding="7" cellspacing="0" style="font-size: 10px;">
	<col width="100%">
	<tr>
		<td width="100%" valign="top" align="center" style="border: 1px solid #00000a; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.2cm; padding-right: 0.19cm">
			<b>Tabla de Diversificación de Producción</b>
		</td>
	</tr>
</table>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Infórmese
en la Comisión Para el Mercado Financiero sobre la Garantía
mediante boleta bancaria o póliza que, conforme a la Ley, deben
constituir los corredores de seguros.</p>

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">La
información sobre la diversificación de los negocios de esta
corredora y de las entidades aseguradoras con que haya trabajado, así
como la información de las pólizas de seguros contratadas para
responder del cumplimiento de sus obligaciones como intermediaria y
en cumplimiento a la ley y a las instrucciones impartidas por la
Comisión Para el Mercado Financiero, informamos que durante el año
calendario anterior intermediamos contratos de seguros con las
compañías que se indican en la FECU 2020 de Arthur J. Gallagher
Corredores de Seguros S.A. (Art. 57 DFL 251) son las siguientes:</p>

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

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">&nbsp;</p>

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

<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">De acuerdo a lo instruido en la circular N° 2123  de fecha de 22 de
Octubre de 2013 de la Comisión Para el Mercado Financiero (CMF), le informamos que las comisiones pagadas por BCI Seguros Vida S.A.,
respecto de la prima pagada por usted son las siguientes:</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Comisión de Intermediación</b><br/>
Arthur J. Gallagher Corredores de Seguros S.A.<br/>
RUT: 77.682.370-8<br/>
Comisión: 5% + IVA sobre la prima neta recaudada.<br/>
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Comisión de Recaudación</b><br/>
Solventa Tarjetas S.A.<br/>
RUT: 96.776.000-5<br/>
Comisión: 57,45% (exenta de IVA), sobre la prima neta recaudada.<br/>
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>Comisión Uso de Canal</b><br/>
Solventa Tarjetas S.A.<br/>
RUT: 96.776.000-5<br/>
Comisión: 17,55% + IVA, sobre la prima neta recaudada.<br/>
</p>

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
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>OBJETO DE LA LIQUIDACIÓN </b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">La liquidación tiene por fin establecer la ocurrencia de un siniestro,
determinar si el siniestro está cubierto en la póliza contratada en una compañía de seguros determinada, y cuantificar el monto de la
pérdida y de la indemnización a pagar.<br/>El procedimiento de liquidación está sometido a los principios de celeridad y economía procedimental, de objetividad y carácter técnico y de transparencia y acceso.</p>
</ol>

<ol start="2">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>FORMA DE EFECTUAR LA LIQUIDACIÓN </b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">La
liquidación puede efectuarla directamente la Compañía o
encomendarla a un Liquidador de Seguros. La decisión debe
comunicarse al Asegurado dentro del plazo de tres días hábiles
contados desde la fecha de la denuncia del siniestro.
</p>
</ol>
<ol start="3">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>DERECHO DE OPOSICIÓN A LA LIQUIDACIÓN DIRECTA </b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">En
caso de liquidación directa por la compañía, el Asegurado o
beneficiario puede oponerse a ella, solicitándole por escrito que
designe un Liquidador de Seguros, dentro del plazo de cinco días
hábiles contados desde la notificación de la comunicación de la
Compañía. La Compañía deberá designar al Liquidador en el plazo
de dos días hábiles contados desde dicha oposición.</p>
</ol>
<ol start="4">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>INFORMACIÓN AL ASEGURADO DE GESTIONES A REALIZAR Y PETICION DE ANTECEDENTES</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">El
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
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>PRE-INFORME DE LIQUIDACIÓN</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">En
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
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>PLAZO DE LIQUIDACIÓN </b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><u>Dentro
del más breve plazo</u>, no pudiendo exceder de <u><b>45 días</b></u>
corridos desde fecha denuncio, a excepción de;</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">a)
Siniestros que correspondan a seguros individuales sobre riesgos del
Primer Grupo cuya prima anual sea superior a 100 UF: <u><b>90 días</b></u>
corridos desde fecha denuncio;
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">b)
Siniestros marítimos que afecten a los cascos o en caso de Avería
Gruesa: <u><b>180 días</b></u> corridos desde fecha denuncio.</p>
</ol>
<ol start="7">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>PRORROGA DEL PLAZO DE LIQUIDACIÓN</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Los
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
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>INFORME FINAL DE LIQUIDACIÓN</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">El
informe final de liquidación deberá remitirse al Asegurado y
simultáneamente al Asegurador, cuando corresponda, y deberá
contener necesariamente la transcripción íntegra de los artículos
26 y 27 del Reglamento de Auxiliares del Comercio de Seguros (D.S. de
Hacienda Nº 1.055, de 2012, Diario Oficial de 29 de diciembre de
2012).</p>
</ol>
<ol start="9">
<li/>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;"><b>IMPUGNACION INFORME DE LIQUIDACIÓN</b></p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">Recibido el informe de Liquidación, la Compañía y el Asegurado dispondrán de un plazo de diez días hábiles para impugnarla. En caso de
liquidación directa por la Compañía, este derecho sólo lo tendrá el Asegurado.
</p>
<p align="justify" style="margin-bottom: 0cm; line-height: 100%; font-size:10px;">
Impugnado el informe, el Liquidador o la compañía dispondrá de un plazo de 6
días hábiles para responder la impugnación.</p>
</ol>
</body>
</html>
