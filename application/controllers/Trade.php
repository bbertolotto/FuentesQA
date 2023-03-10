<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade  extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
        parent::__construct();

        $this->load->model("Usuario_model","user");
        $this->load->model("Motivosrechazo_model","rechazo");
        $this->load->library("session");
        $this->load->library('form_validation');
        $this->load->library('Pdf');
        $this->load->library('Cartas');


        $site_lang = $this->session->userdata('site_lang');
        if ($site_lang) {$this->lang->load('header',$this->session->userdata('site_lang'));
        } else {$this->lang->load('header','spanish'); }

    }
	public function index()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
				$this->session->set_userdata('selector', '4.1.1');
				$this->load->view('trade/search');
	}

	public function search()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
				$this->session->set_userdata('selector', '4.1.1');
				$this->load->view('trade/search');
	}

	public function simulate()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
				$this->session->set_userdata('selector', '4.1.1');
				$this->load->view('trade/simulate');
	}

	public function create()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
				$this->session->set_userdata('selector', '4.1.1');
				$this->load->view('trade/create');
	}
	public function accept()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
				$this->session->set_userdata('selector', '4.1.1');
				$this->load->view('trade/accept');
	}

	public function documents()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }

        $data["motivos"] =  $this->rechazo->getall();

      //  $motivos = $this->rechazo->getall();
   
				$this->session->set_userdata('selector', '4.1.1');
				$this->load->view('trade/documents' , $data);
	}


	public function rechazo()
	{


		$descripcion = $this->rechazo->getall_motivo($_POST["val_reason_deny"]);

		$cartas = new Cartas();
		$datos = $cartas->soap_rechazo("10526746");
		
$rut_param = 10526746;

  $parte1 = substr($rut_param, 0,2); //12
    $parte2 = substr($rut_param, 2,3); //345
    $parte3 = substr($rut_param, 5,3); //456
    $parte4 = substr($rut_param, 8);   //todo despues del caracter 8 

    $rutvalidar =  $parte1.".".$parte2.".".$parte3."-".$parte4;



        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Carta de rechazo');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

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



$html = '<img src="img/solventa_logo.png" alt="test alt attribute" width="200" height="50" border="0"/>
<p align="right">Santiago, '.date('d').' de '.$mes.' de '. date('Y').' </p><p>Se??or(a)</p>
<p>Nombre: '.$datos["nombre"]." ".$datos["apellidop"]." ".$datos["apellidom"].'</p>
<p>RUT: '.$rutvalidar.'K</p>
<p><b>Presente</b></p><br><br><br>
<p>Estimado se??or(a):</p>
<p align="justify"><br>En relaci??n a su solicitud de otorgamiento de un S??per Avance asociado a su Tarjeta de
Cr??dito Cruz Verde, le informamos que realizada su evaluaci??n crediticia, ??sta ha sido
rechazada debido a que a la fecha de la presente, '.$descripcion->name_item.'</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output(FCPATH.'rechazo.pdf', 'F');
//$pdf->Output(FCPATH.'prueba.pdf', 'I');



$input = FCPATH.'rechazo.pdf'; //temporary name that PHP gave to the uploaded file

	$fp = fopen($input, 'r+b');
	$data = fread($fp, filesize($input));
	fclose($fp);
    $data = mysqli_real_escape_string($this->get_mysqli(),$data);

 /*$sqlcall = $this->db->query("INSERT INTO  documento (documento,rut,tipodoc) VALUES ('".$data."','10.526.746-0','1');");*/

 $fecha = date("Y-m-d H:i:s");

  $sqlcall = $this->db->query("INSERT INTO  ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,name_client) VALUES ('".$fecha."',1,1,1,'Hoja de Rechazo','".$data."','105267460','Patricio Cruz');");


header('Content-type:application/pdf');
header('Content-disposition: inline; filename="rechazo.pdf"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
readfile($input);



	}



	   function get_mysqli() { 
$db = (array)get_instance()->db;
return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}



public function contrato()
	{


		//$descripcion = $this->rechazo->getall_motivo($_POST["val_reason_deny"]);

		//$cartas = new Cartas();
		//$datos = $cartas->soap_rechazo("10526746");
		
$rut_param = 10526746;

  $parte1 = substr($rut_param, 0,2); //12
    $parte2 = substr($rut_param, 2,3); //345
    $parte3 = substr($rut_param, 5,3); //456
    $parte4 = substr($rut_param, 8);   //todo despues del caracter 8 

    $rutvalidar =  $parte1.".".$parte2.".".$parte3."-".$parte4;



        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Contrato super avance');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true,10);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(10, 10, 10);

$pdf->AddPage();

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

$fecha = date('d-m-Y');

$html = <<<EOF


         <h2>CONTRATO S??PER AVANCE - TARJETA DE CR??DITO CRUZ VERDE </h2>
		<table border="1" cellpadding="10" cellspacing="0">
		<tr>
		<td>NOMBRE CLIENTE(A) (TITULAR TARJETA)</td>
		<td style=" text-align: right;"></td>
		</tr>
		<tr>
		<td>RUT</td>
		<td style=" text-align: right;"></td>
		</tr>

		<tr>
		<td>TARJETA DE CR??DITO CRUZ VERDE N?? </td>
		<td style=" text-align: right;"></td>
		</tr>

		<tr>
		<td>CORREO ELECTR??NICO  </td>
		<td style=" text-align: right;"></td>
		</tr>


		<tr>
		<td>DOMICILIO </td>
		<td style=" text-align: right;"></td>
		</tr>
		</table>
		
		<p style="text-align:justify"><b>1.- </b>El (la) CLIENTE(A) individualizado(a) precedentemente, contrata con Solventa Tarjetas S.A.,
RUT N?? ____________, con domicilio en ____________________, un "S??PER
AVANCE" asociado a su Tarjeta de Cr??dito Cruz Verde de acuerdo a las condiciones siguientes: </p>

<table border="1"  cellpadding="2">
	<tr>
		<td width="430px">FECHA Y HORA OTORGAMIENTO </td>
		<td width="100px" style=" text-align: right;">  </td>
	</tr>
	<tr>
		<td>MONTO BRUTO S??PER AVANCE  </td>
		<td style=" text-align: right;">  </td>
	</tr>
	<tr>
		<td>MONTO L??QUIDO S??PER AVANCE   </td>
		<td style=" text-align: right;"> </td>
	</tr>
	<tr>
		<td>N??MERO DE CUOTAS    </td>
		<td style=" text-align: right;">  </td>
	</tr>
	<tr>
		<td>VALOR CUOTA    </td>
		<td style=" text-align: right;">  </td>
	</tr>
	<tr>
		<td>FECHA PRIMER VENCIMIENTO     </td>
		<td style=" text-align: right;">  </td>
	</tr>

	<tr>
		<td>TASA DE INTER??S MENSUAL <br>(Se encuentra incorporada en el VALOR CUOTA).     </td>
		<td style=" text-align: right;"> </td>
	</tr>
	<tr>
		<td>PER??ODO DE GRACIA  <br>(Se aplican intereses por este per??odo ya incorporados en el VALOR     </td>
		<td style=" text-align: right;"> 0 </td>
	</tr>
	<tr>
		<td>IMPUESTO TIMBRE Y ESTAMPILLA </td>
		<td style=" text-align: right;"> </td>
	</tr>
	<tr>
		<td>COMISI??N DE S??PER AVANCE <br>(Se cobra separadamente y se refleja en el Estado de Cuenta)  </td>
		<td style=" text-align: right;"></td>
	</tr>
	<tr>
		<td>SEGURO DE VIDA Y DESGRAVAMEN  <br>(Contrataci??n voluntaria. Valor total prima se encuentra incorporado
en monto S??PER AVANCE)  </td>
		<td style=" text-align: right;"> </td>
	</tr>
	<tr>
		<td>SEGURO DE ENFERMEDADES GRAVES   <br>(Contrataci??n voluntaria. Valor total prima se encuentra incorporado en monto S??PER AVANCE)   </td>
		<td style=" text-align: right;"> </td>
	</tr>
	<tr>
		<td>CAE   </td>
		<td style=" text-align: right;"> </td>
	</tr>
	<tr>
		<td>COSTO TOTAL   </td>
		<td style=" text-align: right;"> </td>
	</tr>
</table>
<p style="text-align:justify" >Se deja expresa constancia que a solicitud de el (la) CLIENTE(A), la entrega material del monto
l??quido del S??PER AVANCE, se efectuar?? en la forma siguiente: </p>
<table border="1">
	<tr>
		<th style="text-align:center"><B>MODO ENTREGA</B></th>
		<th style="text-align:center"><B>TIPO CUENTA</B></th>
		<th style="text-align:center"><B>N??MERO CUENTA</B></th>
		<th style="text-align:center"><B>BANCO</B></th>
		<th style="text-align:center"><B>MONTO</B></th>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="text-align:right"></td>
	</tr>
</table>
<br>
<br>
<br>
<table border="1">
	<tr>
		<td style="text-align:center"><b>MODO ENTREGA</b></td>
		<td width="200px" style="text-align:center"><b>LUGAR ENTREGA</b></td>
		<td style="text-align:center"><b>MONTO</b></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>

<p style="text-align:justify"><b>2.- </b>En el evento que el (la) CLIENTE(A) hubiere optado por la modalidad de transferencia bancaria,
??sta se efectuar?? ??nica y exclusivamente en la cuenta de la cual sea titular, no pudiendo
realizarse en cuentas de terceros. Se deja constancia que la transferencia se verificar?? dentro de
las 48 horas h??biles siguientes a la fecha de este instrumento. De este modo, el cliente declara
que los datos que entreg?? relativos a la cuenta son fidedignos y que ??l es el titular de la misma.
En consecuencia libera a Solventa Tarjetas S.A. de toda responsabilidad que pudiere generarse
ante cualquier error o perjuicio directo o indirecto que afecte al cliente con motivo de la referida
transferencia bancaria.  </p>


<p style="text-align:justify"><b>3.- </b> Se deja constancia que el S??PER AVANCE constituye una l??nea de cr??dito extraordinaria y
adicional a la l??nea de cr??dito que ya posee en su Tarjeta de Cr??dito Cruz Verde. En atenci??n a
ello, el (la) CLIENTE(A), acepta el otorgamiento de la referida l??nea de cr??dito extraordinaria, para
efecto de cursar el S??PER AVANCE y autorizar que las cuotas sean cobradas en los respectivos
estados de cuenta.   </p>
<p style="text-align:justify"><b>4.- </b> El otorgamiento del S??PER AVANCE no modifica las estipulaciones del CONTRATO
AFILIACI??N SISTEMA TARJETA CR??DITO CRUZ VERDE Y APERTURA L??NEA DE CR??DITO
las cuales rigen ??ntegramente. En consecuencia, ante el incumplimiento en el pago ??ntegro y
oportuno de una cualquiera de las cuotas pactadas, Solventa Tarjetas S.A. podr?? ejercer una
cualquiera o todas las acciones que el citado Contrato le faculta, entre otras, hacer exigible
anticipadamente el pago de todo lo adeudado, como si fuera de plazo vencido, m??s intereses,
reajustes, gastos de cobranza, costas y dem??s conceptos que adeude el (la) CLIENTE(A) conforme
lo establece la normativa vigente.   </p>
<p style="text-align:justify"><b>5.- </b> El (la) CLIENTE(A) reconoce y acepta que fue previamente informado en forma clara y
detallada todas y cada una de las condiciones del S??PER AVANCE, las cuales adem??s se
detallan en Hoja Resumen/Cotizaci??n que antecede y que este documento es fiel reflejo de lo
aceptado por ??l. Un ejemplar del presente instrumento es entregado en este acto a el (la)
CLIENTE(A), en el evento que lo hubiere contratado en forma presencial o en su defecto, enviado
al correo electr??nico que se indica al principio, si el S??PER AVANCE hubiere sido contratado por
cualquier modo a distancia o v??a remota. Se deja constancia que, en el caso que el S??PER
AVANCE hubiere sido convenido a trav??s de alg??n medio remoto o a distancia, el (la) CLIENTE(A)
no tiene derecho a retracto. El presente instrumento no adhiere al sello voluntario SERNAC
establecido en la Ley 19.496.   </p>
<p style="text-align:justify">Inf??rmese sobre las entidades autorizadas para emitir Tarjetas de Pago en el pa??s, quienes se
encuentran inscritas en los Registros de Emisores de Tarjetas que lleva la SBIF, en www.sbif.cl  </p>

EOF;


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output(FCPATH.'contrato.pdf', 'F');
//$pdf->Output(FCPATH.'prueba.pdf', 'I');



$input = FCPATH.'contrato.pdf'; //temporary name that PHP gave to the uploaded file

	$fp = fopen($input, 'r+b');
	$data = fread($fp, filesize($input));
	fclose($fp);
    $data = mysqli_real_escape_string($this->get_mysqli(),$data);

/* $sqlcall = $this->db->query("INSERT INTO  documento (documento,rut,tipodoc) VALUES ('".$data."','10.526.746-0','2');");*/

 $fecha = date("Y-m-d H:i:s");

  $sqlcall = $this->db->query("INSERT INTO  ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,name_client) VALUES ('".$fecha."',1,1,2,'Hoja de contrato','".$data."','105267460','Patricio Cruz');");


header('Content-type:application/pdf');
header('Content-disposition: inline; filename="contrato.pdf"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
readfile($input);


	}



	public function resumen()
	{


		//$descripcion = $this->rechazo->getall_motivo($_POST["val_reason_deny"]);

		//$cartas = new Cartas();
		//$datos = $cartas->soap_rechazo("10526746");
		
$rut_param = 10526746;

  $parte1 = substr($rut_param, 0,2); //12
    $parte2 = substr($rut_param, 2,3); //345
    $parte3 = substr($rut_param, 5,3); //456
    $parte4 = substr($rut_param, 8);   //todo despues del caracter 8 

    $rutvalidar =  $parte1.".".$parte2.".".$parte3."-".$parte4;



        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Contrato super avance');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);

$pdf->setFooterMargin(80);
$pdf->SetAutoPageBreak(true,90);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->SetMargins(10, 10, 10);

$pdf->AddPage();



$fecha = date('d-m-Y');

$html = <<<EOF

 <style>
             
                .first {
                    width:50px;
                      border-top:1px solid black;
                    border-right:1px solid black;
                     border-left:1px solid black;
                       border-bottom:1px solid black;
                }
                  .second {
                    width:50px;
                      border-top:2px solid black;
                    border-right:1px solid black;
                     border-left:1px solid black;
                       border-bottom:2px solid black;
                       font-size:14px;
                      
                       color:White;
                       background-color:gray;

                }
               
                </style>

                <h1 style="text-align:center">HOJA RESUMEN/COTIZACI??N S??PER AVANCE - TARJETA DE
CR??DITO CRUZ VERDE </h1>
               			<table>
               				<tr>
               					<td width="100"><b>N??mero</b></td>
               					<td width="250">___</td>
               					<td style="font-size:25px">CAE:____% </td>
               				</tr>
               			</table>
                        <div class="first">
                        	<table cellpadding="2">
                        		<tr>
                        			<td>Nombre Titular</td>
                        			<td> </td>
                        		</tr>
                        		<tr>
                        			<td>RUT</td>
                        			<td> </td>
                        		</tr>
                        		<tr>
                        			<td>Fecha</td>
                        			<td>$fecha </td>
                        		</tr>
                        		<tr>
                        			<td>Plazo de vigencia cotizaci??n </td>
                        			<td>7 d??as H??biles </td>
                        		</tr>
                        	</table>
                        	<div class="second">I. Producto Principal</div>

                        	<table cellpadding="2" >
                        		<tr>
                        			<td>Monto Bruto S??per Avance </td>
                        			<td> </td>
                        		</tr>
                        		<tr>
                        			<td>Monto L??quido S??per Avance</td>
                        			<td> </td>
                        		</tr>
                        		<tr>
                        			<td>Plazo S??per Avance </td>
                        			<td> </td>
                        		</tr>
                        		<tr>
                        			<td>Valor de Cuota S??per Avance </td>
                        			<td>  </td>
                        		</tr>
                        		<tr>
                        			<td>Tasa de inter??s mensual </td>
                        			<td> </td>
                        		</tr>
                        		<tr>
                        			<td>Fecha primer Vencimiento </td>
                        			<td> </td>
                        		</tr>
                        		<tr>
                        			<td><b>Costo Total del Cr??dito</b></td>
                        			<td> </td>
                        		</tr>
                        		<tr>
                        			<td><b>Carga Anual Equivalente (CAE) </b></td>
                        			<td> </td>
                        		</tr>
                        		
                        	</table>

                        		<div class="second" style="font-size:10px">II. Gastos o Cargos Propios del S??per Avance</div>


                        		<table cellpadding="2" style="font-size:10px">
                        			<tr>
                        				<td>Gastos Notariales </td><td></td>
                        			</tr>
                        			<tr>
                        				<td>Impuestos </td><td></td>
                        			</tr>
                        			<tr>
                        				<td>Comisi??n S??per Avance  </td><td></td>
                        			</tr>
                        			<tr>
                        				<td>Garant??as Asociadas   </td><td></td>
                        			</tr>
                        		</table>

<div class="second" style="font-size:10px">III. Gastos o Cargos por Productos o Servicios Voluntariamente Contratados
</div>


                        		<table cellpadding="2" style="font-size:10px">
                        			<tr>
                        				<td>Seguro de Vida  </td><td> </td>
                        			</tr>
                        			<tr>
                        				<td>Costo Mensual (pesos)  </td><td>-</td>
                        			</tr>
                        			<tr>
                        				<td>Costo Total (pesos)  </td><td> </td>
                        			</tr>
                        			<tr>
                        				<td>Cobertura   </td><td>
</td>
                        			</tr>
                        			<tr>
                        				<td>Nombre proveedor del servicio asociado    </td><td>BCI</td>
                        			</tr>
                        			
                        			</table>
</div>
<br>
<br><br>
<div class="first">
<table cellpadding="2" style="font-size:10px">                       			

<tr>
                        				<td>Seguro Enfermedades Graves</td><td>CON SEGURO
</td>
                        			</tr>
                        			<tr>
                        				<td>Costo Mensual (pesos) </td><td>-</td>
                        			</tr>
                        			<tr>
                        				<td>Costo Total (pesos) </td><td> </td>
                        			</tr>
                        			<tr>
                        				<td>Cobertura</td><td>  </td>
                        			</tr>
                        			<tr>
                        				<td>Nombre proveedor del servicio asociado </td><td>BCI </td>
                        			</tr>
                        		</table>

                        		<div class="second" style="font-size:10px">IV. Condiciones de Prepago</div>

                        		<table cellpadding="2" style="font-size:10px">     
                        			<tr>
                        				<td>Cargo Prepago </td><td>1 mes de inter??s calculado sobre capital de prepago </td>
                        			</tr>
                        			<tr>
                        				<td>Plazo de Aviso Prepago  </td><td>No aplica  </td>
                        			</tr>
                        		</table>


                        		<div class="second" style="font-size:10px">V. Costos por Atraso</div>

                        		<table cellpadding="2" style="font-size:10px">     
                        			<tr>
                        				<td>Inter??s Moratorio  </td><td></td><td style="text-align:right"></td>
                        			</tr>
                        			<tr>
                        				<td>Gastos de Cobranza</td><td>Deuda hasta 10 UF</td><td style="text-align:right"> </td>
                        			</tr>
                        			<tr>
                        				<td></td><td>Por lo que exceda a 10 UF y hasta 50 UF </td><td style="text-align:right"></td>
                        			</tr>
                        			<tr>
                        				<td></td><td>Por lo que exceda a 50 UF </td><td style="text-align:right"></td>
                        			</tr>
                        		</table>


                        		<div class="second" style="font-size:10px">VI. Cierre Voluntario</div>
                        		<br>
                        		<span style="font-size:10px;">El derecho a pagar anticipadamente o prepagar es un derecho irrenunciable, de conformidad al art??culo 10 de la Ley N??18.010 </span>
<br>
                        		<div class="second" style="font-size:10px">Advertencia</div>
<br>
                        		<span style="font-size:10px;text-aling:justify">EL CR??DITO DE S??PER AVANCE DE QUE DA CUENTA ESTA HOJA RESUMEN/COTIZACI??N REQUIERE DEL CONSUMIDOR
CONTRATANTE LEONARDO FABRICIO SOTO ALVAREZ PATRIMONIO O INGRESOS FUTUROS SUFICIENTES PARA PAGAR SU
COSTO TOTAL DE ______ CUYA CUOTA MENSUAL ES DE _______, DURANTE TODO EL PER??ODO DEL CR??DITO.</span>
<br>
<br>
<span style="font-size:10px;text-aling:justify">EN CASO QUE EL S??PER AVANCE CONSIDERE PER??ODOS DE GRACIA O POSTERGACI??N DE CUOTAS, SE APLICAR??N LOS
INTERESES CORRESPONDIENTES A DICHO PER??ODO.</span>
<br>
<br>
<span style="font-size:10px;text-aling:justify">
INF??RMESE SOBRE LAS ENTIDADES AUTORIZADAS PARA EMITIR TARJETAS DE PAGO EN EL PA??S, QUIENES SE
ENCUENTRAN INSCRITAS EN LOS REGISTROS DE EMISORES DE TARJETAS QUE LLEVA LA SBIF, EN WWW.SBIF.CL 
</span>
<br>




                        </div>
<div style="text-align:center">_________________<br>Firma Cliente</div>

<b style="text-align:center">DEFINICIONES HOJA RESUMEN/COTIZACI??N S??PER AVANCE DE TARJETA DE
CR??DITO CRUZ VERDE</b>
<div class="first" style="font-size:8px">
	<span style="font-size:8px;text-align:justify">
<b>Hoja Resumen:</b> La Hoja inicial que antecede a los contratos de adhesi??n de Cr??ditos de Consumo, que contiene un resumen
estandarizado de sus principales cl??usulas y que los Proveedores deben incluir en sus cotizaciones para facilitar su comparaci??n por
los Consumidores.</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Gastos o Cargos Propios del Cr??dito: </b>Todas aquellas obligaciones en dinero, cualquiera sea su naturaleza o denominaci??n,
derivadas de la contrataci??n de un Cr??dito de Consumo y devengadas a favor del Proveedor o de un tercero, que no correspondan a
tasa de inter??s ni a capital y que deban pagarse por el Consumidor. Tendr??n este car??cter los impuestos y gastos notariales, adem??s
de los que sean definidos como tales por una disposici??n legal o reglamentaria.
</span>
<br>
<span style="font-size:8px;text-align:justify">

<b>Valor de la Cuota:</b> El monto que se obliga a pagar un Consumidor al contratar un Cr??dito de Consumo en forma peri??dica, que
considera todos los intereses, amortizaciones, Gastos o Cargos Propios del Cr??dito y Gastos o Cargos por Productos o Servicios
Voluntariamente Contratados.</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Monto L??quido:</b> El monto total que efectivamente recibe el Consumidor para satisfacer el objeto del contrato en el periodo inicial.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Monto Bruto:</b> El monto L??quido del Cr??dito m??s los Gastos o Cargos Propios del Cr??dito y Gastos o Cargos por Productos o
Servicios Voluntariamente Contratados que se efect??an en el per??odo inicial.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Costo Total del Cr??dito:</b> El monto total que debe asumir el Consumidor, y que corresponde a la suma de todos los pagos peri??dicos
definidos como Valor de la Cuota en funci??n del plazo acordado, incluyendo cualquier pago en el per??odo inicial.
</span>
<br>
<span style="font-size:8px;text-align:justify">

<b>Plazo del Cr??dito:</b> El periodo establecido para el pago total del Cr??dito de Consumo. Si un Cr??dito de Consumo tiene periodo de
gracia, postergaci??n de una o m??s cuotas, meses sin pago de una o m??s cuotas o cualquier otra modalidad que extienda la fecha de
extinci??n del cr??dito, el Proveedor deber?? informar al Consumidor la diferencia en la tasa de inter??s y en cualquier otro costo que est??
considerado en la modalidad respectiva. Adem??s, el Plazo del Cr??dito incluir?? los meses adicionales en que la obligaci??n se
mantendr?? vigente si se verifican todos los eventos previstos en la modalidad respectiva que extiendan la fecha de extinci??n del
cr??dito.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Costos por impuestos:</b> Las obligaciones tributarias que el Emisor debe cobrar al consumidor a consecuencia de un impuesto que se
haya devengado por un producto o servicio que se encuentre afecto a ??l.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Costos de administraci??n, operaci??n y/o mantenci??n de la Tarjeta de Cr??dito:</b> Todas las sumas de dinero que mensual,
semestral o anualmente deba pagar el consumidor por el valor de los servicios necesarios para la mantenci??n operativa de una
Tarjeta de Cr??dito en sus distintas modalidades de uso.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Carga anual equivalente o 'CAE':</b> Indicador que, expresado en forma de porcentaje, revela el costo del cr??dito en un periodo anual,
cualquiera sea el plazo pactado para el pago de la obligaci??n. La carga anual equivalente incluye el capital, tasa de inter??s, plazo,
costos de apertura, comisiones y cargos, costos de administraci??n, operaci??n y/o mantenci??n de la Tarjeta de Cr??dito, y los gastos o
cargos por productos o servicios voluntariamente contratados.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Gastos o cargos por productos o servicios voluntariamente contratados: </b>Todas las obligaciones en dinero, cualquiera sea su
naturaleza o denominaci??n, por productos o servicios proporcionados por el Emisor o por un tercero contratado por intermedio del
Emisor, respecto de las cuales el consumidor puede prescindir al contratar una Tarjeta de Cr??dito.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Inter??s moratorio:</b> Tasa de inter??s que se aplica por no haber sido pagada total e ??ntegramente una obligaci??n a la fecha de su
vencimiento. Se calcula desde la fecha de la mora o simple retardo en el pago, hasta la fecha del pago total e ??ntegro de todo lo
adeudado.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Gastos de cobranza:</b> Monto correspondiente al costo de la cobranza extrajudicial de una obligaci??n vencida y no pagada en la fecha
establecida en el contrato, traspasado por el Emisor al consumidor, y que s??lo se puede cobrar si han transcurrido veinte d??as
corridos desde el atraso, seg??n lo dispuesto en el art??culo 37 de la Ley de Protecci??n al Consumidor.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Comisi??n por Pago Anticipado o Prepago:</b> El valor extraordinario y voluntario que asume el Consumidor al pagar en forma
anticipada el Cr??dito de Consumo, sea en forma total o parcial, esto es, antes del plazo establecido para ello. Este cargo se rige por
el Art??culo 10 de la Ley N??18.010.
</span>
<br>
<span style="font-size:8px;text-align:justify">
<b>Costo Total del Pago Anticipado o Prepago:</b> El monto total a pagar por el Consumidor, para extinguir la obligaci??n
anticipadamente, incluida la Comisi??n por Pago Anticipado o Prepago. 
</span>


</div>
<div style="text-align:center">_________________<br>Firma Cliente</div>

                      

EOF;


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output(FCPATH.'resumen.pdf', 'F');
//$pdf->Output(FCPATH.'prueba.pdf', 'I');



$input = FCPATH.'resumen.pdf'; //temporary name that PHP gave to the uploaded file

	$fp = fopen($input, 'r+b');
	$data = fread($fp, filesize($input));
	fclose($fp);
    $data = mysqli_real_escape_string($this->get_mysqli(),$data);

 /*$sqlcall = $this->db->query("INSERT INTO  documento (documento,rut,tipodoc) VALUES ('".$data."','10.526.746-0','3');");*/
 $fecha = date("Y-m-d H:i:s");

  $sqlcall = $this->db->query("INSERT INTO  ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,name_client) VALUES ('".$fecha."',1,1,3,'Hoja de Resumen','".$data."','105267460','Patricio Cruz');");



header('Content-type:application/pdf');
header('Content-disposition: inline; filename="resumen.pdf"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
readfile($input);

	}


	


	 public function proteccion(){

 $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $fontname = TCPDF_FONTS::addTTFfont(FCPATH.'fuente/arial_narrow_7.ttf', 'narrow','',14);

        $pdf->SetFont($fontname,'',9,'',false);

$pdf->SetTitle('Proteccion de vida');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(15, 8, 15);
$pdf->AddPage();
$fecha = date('d-m-Y');
  $data = array();   
  $html = $this->load->view('pdf/proteccion', $data,TRUE); 

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output(FCPATH.'proteccion.pdf', 'F');
//$pdf->Output(FCPATH.'prueba.pdf', 'I');



$input = FCPATH.'proteccion.pdf'; //temporary name that PHP gave to the uploaded file

	$fp = fopen($input, 'r+b');
	$data = fread($fp, filesize($input));
	fclose($fp);
    $data = mysqli_real_escape_string($this->get_mysqli(),$data);

/* $sqlcall = $this->db->query("INSERT INTO  documento (documento,rut,tipodoc) VALUES ('".$data."','10.526.746-0','4');");*/

  $fecha = date("Y-m-d H:i:s");

  $sqlcall = $this->db->query("INSERT INTO  ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,name_client) VALUES ('".$fecha."',1,1,4,'Proteccion','".$data."','105267460','Patricio Cruz');");




header('Content-type:application/pdf');
header('Content-disposition: inline; filename="proteccion.pdf"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
readfile($input);


    
   }



	 public function desgravamen(){

 $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $fontname = TCPDF_FONTS::addTTFfont(FCPATH.'fuente/arial_narrow_7.ttf', 'narrow','',14);

        $pdf->SetFont($fontname,'',9,'',false);

$pdf->SetTitle('Proteccion de vida');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(15, 8, 15);
$pdf->AddPage();
$fecha = date('d-m-Y');
  $data = array();   
  $html = $this->load->view('pdf/desgravamen', $data,TRUE); 

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output(FCPATH.'desgravamen.pdf', 'F');
//$pdf->Output(FCPATH.'prueba.pdf', 'I');



$input = FCPATH.'desgravamen.pdf'; //temporary name that PHP gave to the uploaded file

	$fp = fopen($input, 'r+b');
	$data = fread($fp, filesize($input));
	fclose($fp);
    $data = mysqli_real_escape_string($this->get_mysqli(),$data);

 /*$sqlcall = $this->db->query("INSERT INTO  documento (documento,rut,tipodoc) VALUES ('".$data."','10.526.746-0','5');");*/


  $fecha = date("Y-m-d H:i:s");

  $sqlcall = $this->db->query("INSERT INTO  ta_documents (stamp,id_user,id_office,type,name,image,number_rut_client,name_client) VALUES ('".$fecha."',1,1,5,'Desgravamen','".$data."','105267460','Patricio Cruz');");




header('Content-type:application/pdf');
header('Content-disposition: inline; filename="desgravamen.pdf"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
readfile($input);

    
   }


   public function doc($id){

    
          $usuario  = $this->rechazo->documentos($id);
          $type =  'application/pdf';
        $imagen =  $usuario->documento;
  //  header("Content-type:". $type);
   // header ("Pragma: no-cache");

        $this->output
        ->set_content_type($type)
         ->set_output($imagen);

      

}




}
