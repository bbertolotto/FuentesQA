<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Correos extends CI_Controller {

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
        //llamamos al constructor de la clase padre
        parent::__construct();
         
                  $this->load->model("Usuario_model","user");

        $this->load->library("session");
        $this->load->library('form_validation');

          //  $this->lang->load('header',$this->session->userdata('site_lang'));    
  $site_lang = $this->session->userdata('site_lang');

        if ($site_lang) {
            $this->lang->load('header',$this->session->userdata('site_lang'));
        } else {
            $this->lang->load('header','english');
        }


    }
	public function index()
	{

       if ($this->session->userdata('lock') === NULL) {
            //bila session user kosong balik ke 'Login'
             redirect(base_url());
        }
        if( $this->session->userdata('lock') == "0"){ 
            
             redirect(base_url("Dashboard/lock"));
        }

		$this->load->view('correos/index');
	}

	public function ready($idpost)
	{

       if ($this->session->userdata('lock') === NULL) {
            //bila session user kosong balik ke 'Login'
             redirect(base_url());
        }
        if( $this->session->userdata('lock') == "0"){ 
            
             redirect(base_url("Dashboard/lock"));
        }
        $datos = array();
        $datos["idpost"] = $idpost;

		$this->load->view('correos/ready',$datos);
	}


	public function inbox(){

$imap = $this->load->library('Leerimap'); // Load the IMAP Library
	 
$email = new Leerimap();

if($_POST['inbox'] == ""){
$connect =  $email->connect('{mail.smstd.cl:993/imap/ssl/novalidate-cert}INBOX','patricio@smstd.cl','patricio2019');
}else{
	$connect =  $email->connect('{mail.smstd.cl:993/imap/ssl/novalidate-cert}'.$_POST['inbox'],'patricio@smstd.cl','patricio2019');
}
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
if($connect){
	if(isset($_POST['inbox'])){
		// inbox array
		$inbox = $email->getMessages('html');
		echo json_encode($inbox, JSON_PRETTY_PRINT);
	}else if(!empty($_POST['uid']) && !empty($_POST['part']) && !empty($_POST['file']) && !empty($_POST['encoding'])){
		// attachments
		        $_POST['file'] = str_replace(' ', '', $_POST['file']); 

		$inbox = $email->getFiles($_POST);
		echo json_encode($inbox, JSON_PRETTY_PRINT);
	}else {
		echo json_encode(array("status" => "error", "message" => "Not connect."), JSON_PRETTY_PRINT);
	}
}else{
	echo json_encode(array("status" => "error", "message" => "Not connect."), JSON_PRETTY_PRINT);
}
}


public function emailsend(){



$to = $_POST["compose-to"];
$subject = $_POST["compose-subject"];
$body = $_POST["compose-message"];
$headers = "MIME-Version: 1.0;\r\nContent-type: text/html; charset=iso-8859-1;\r\nContent-Transfer-Encoding: 8bit;\r\n"
                        . "From: patricio@smstd.cl \r\n" . "Reply-To:  patricio@smstd.cl\r\n";
$return_path = "";
$cc = "";
$bcc = "";


$dmy=date("Y-m-d H:i:s");

$is_sent = imap_mail($to, $subject, $body, $headers, $cc, $bcc, $return_path);

$stream = imap_open("{mail.smstd.cl:993/imap/ssl/novalidate-cert}INBOX.Sent", "patricio@smstd.cl", "patricio2019");

$check = imap_check($stream);
//echo "Msg Count before append: ". $check->Nmsgs . "\n";

imap_append($stream, "{mail.smstd.cl:993/imap/ssl/novalidate-cert}INBOX.Sent"
                   , "From: patricio@smstd.cl\r\n"
                   . "To: ".$to."\r\n"
                   . "Date: $dmy\r\n"
                   . "Subject: ".$subject."\r\n"
                   . "Content-Type: text/html;\r\n\tcharset=\"utf-8\"\r\n"
                   . "Content-Transfer-Encoding: 8bit \r\n"
                   . "\r\n\r\n"
                   . html_entity_decode($body)
                   );

$check = imap_check($stream);
//echo "Msg Count after append : ". $check->Nmsgs . "\n";

imap_close($stream);

echo json_encode( $check->Nmsgs);

}


public function emailsendvv(){

$file = FCPATH."template.pdf";

 $archivo = file_get_contents($file);
    $archivo = chunk_split(base64_encode($archivo));

$nombrearchivo = "Planilla.pdf";
$to = "elgranjm3000@gmail.com";
$subject = "Planilla";
$CuerpoMensaje  = "Buenos dias <br> Reciba un cordial saludo <br> el siguiente correo es con respecto a una transferencia que van hacer pago la nomina";
/*$headers = "MIME-Version: 1.0;\r\nContent-type: text/html; charset=iso-8859-1;\r\nContent-Transfer-Encoding: 8bit;\r\n"
                        . "From: fbriceno@bima.com.ve\r\n" . "Reply-To:  fbriceno@bima.com.ve\r\n";*/
 $fp =    @fopen($file,"rb");
        $data =  @fread($fp,filesize($file));                        


$email_from = "jocenteno@menpet.gob.ve";

  $headers = "From: <jocenteno@menpet.gob.ve> Jose Centeno <" . $email_from . ">\r\n";
    //$header .= "Reply-To: " . $replyto . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"=A=G=R=O=\"\r\n\r\n";
    
    
    //armando mensaje del email
    $body = "--=A=G=R=O=\r\n";
    $body .= "Content-type:text/html; charset=utf-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $CuerpoMensaje . "\r\n\r\n";
    
    //archivo adjunto  para email    
    $body .= "--=A=G=R=O=\r\n";
    $body .= "Content-Type: application/octet-stream; name=\"" . $nombrearchivo . "\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"" . $nombrearchivo . "\"\r\n\r\n";
    $body .= $archivo . "\r\n\r\n";
    $body .= "--=A=G=R=O=--";

   

$return_path = "";
$cc = "";
$bcc = "";


$dmy=date("Y-m-d H:i:s");

$is_sent = imap_mail($to, $subject, $body, $headers, $cc, $bcc, $return_path);

/*$stream = imap_open("{mail.smstd.cl:993/imap/ssl/novalidate-cert}INBOX.Sent", "patricio@smstd.cl", "patricio2019");

$check = imap_check($stream);
//echo "Msg Count before append: ". $check->Nmsgs . "\n";

/*imap_append($stream, "{mail.smstd.cl:993/imap/ssl/novalidate-cert}INBOX.Sent"
                   , "From: patricio@smstd.cl\r\n"
                   . "To: ".$to."\r\n"
                   . "Date: $dmy\r\n"
                   . "Subject: ".$subject."\r\n"
                   . "Content-Type: text/html;\r\n\tcharset=\"utf-8\"\r\n"
                   . "Content-Transfer-Encoding: 8bit \r\n"
                   . "\r\n\r\n"
                   . html_entity_decode($body)
                   );*/

//$check = imap_check($stream);
//echo "Msg Count after append : ". $check->Nmsgs . "\n";

//imap_close($stream);

//echo json_encode( $check->Nmsgs);

}

public function mover(){

$numberuid = $_POST["uid"];
$mbox = imap_open("{mail.smstd.cl:993/imap/ssl/novalidate-cert}".$_POST['inbox'], "patricio@smstd.cl", "patricio2019");
    //move the email to our saved folder

if($_POST['inbox'] == 'INBOX.Trash'){
	if(imap_delete($mbox, $numberuid, FT_UID )){

		 imap_close($mbox,CL_EXPUNGE);
		echo json_encode($numberuid);

		exit;
	}
 imap_close($mbox,CL_EXPUNGE);
}else{
    $imapresult=imap_mail_move($mbox,$numberuid,'INBOX.Trash',CP_UID);   
	//imap_delete($mbox, $numberuid, FT_UID );
    imap_close($mbox,CL_EXPUNGE);
}
    echo json_encode("eliminados");


}

public function contarimap(){
	$username = 'patricio@smstd.cl';
$password = 'patricio2019';

$hostname = '{mail.smstd.cl:993/imap/ssl/novalidate-cert}INBOX';
$inbox = imap_open($hostname,$username,$password);
$num = imap_num_msg($inbox);


 echo json_encode(array("cantidad"=>$num));
}

	
               
	
}
