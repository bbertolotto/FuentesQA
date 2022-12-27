<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

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

		$this->load->view('chat/index');
	}

	public function email_view(){
		 // IMAP CONFIG VARS
      
        $address = "patricio@smstd.cl";
        $password = "patricio2019";

       // $mail = imap_open('{mail.smstd.cl::993/novalidate-cert/pop3/ssl}', 'patricio@smstd.cl', 'patricio2019');
    $mbox = @imap_open("{mail.smstd.cl:993/imap/ssl/novalidate-cert}", $address, $password);
    echo "<h1>Mailboxes</h1>\n";
$folders = imap_listmailbox($mbox, "{mail.smstd.cl:993/imap/ssl/novalidate-cert}", "*");



echo "<pre>\n\n";
print_r(imap_fetchstructure($mbox, 3));
echo "\n\n</pre>";
$mensaje = imap_fetchstructure($mbox, 3);
$partes = count($mensaje->parts);
$partesreales = $partes-1;
if(!$partes) {
echo "El Mensaje No Tiene Archivos Adjuntos<br>";
exit;
}
echo "$partes<br>";
echo "El Mensaje Tiene $partesreales Archivos Adjunto(s)!<br>";
echo "Detalles del Archivo Adjunto #1<br>";
$analisar = $mensaje->parts[1];

echo "Este es un Array : $analisar->parameters<br>"; //Array
$seguimos = $analisar->dparameters[0];
echo "Nombre Del Archivo Adjunto: $seguimos->value<br>"; //nuevo.gif
$final = $mensaje->parts[1]->dparameters[0]->value;
$final = trim($final, "=,?"); //Elimina ? y = del inicio o final del nombre.
echo "Nombre Del Archivo Adjunto: $final<br>";
$tamano = $mensaje->parts[1]->bytes;
$tipo = $mensaje->parts[1]->subtype;
echo "El Archivo Adjunto Tiene $tamano bytes!<br>";
echo "El Archivo Adjunto es un Archivo $tipo<br>";
exit;
$emails = imap_search($mbox,'ALL');
$number = 3;
	$info = imap_fetchstructure($mbox, $number, 0);
 	if($info->encoding == 3){
            $message = base64_decode(imap_fetchbody($mbox, $number, 1));
        }
        elseif($info->encoding == 4){
            $message = imap_qprint(imap_fetchbody($mbox, $number, 1));
        }
        else
        {
            $message = imap_fetchbody($mbox, $number, 1);
        }
        //$message = imap_fetchbody($this -> connection, $number, 2);
        echo $message;
        exit;

/* if emails are returned, cycle through each... */
if($emails) {

  /* begin output var */
  $output = '';

  /* put the newest emails on top */
  rsort($emails);

  /* for every email... */
  foreach($emails as $email_number) {
    //$email_number=$emails[0];
//print_r($emails);
    /* get information specific to this email */
    $overview = imap_fetch_overview($mbox,$email_number,0);
    $message = imap_fetchbody($mbox,$email_number,1.2);

    /* output the email header information */
    $output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
    $output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
    $output.= '<span class="from">'.$overview[0]->from.'</span>';
    $output.= '<span class="date">on '.$overview[0]->date.'</span>';
    $output.= '</div>';

    /* output the email body */
    $output.= '<div class="body">'.$message.'</div>';
  }

  echo $output;
}
exit;

if ($folders == false) {
    echo "Call failed<br />\n";
} else {
    foreach ($folders as $val) {
        echo $val . "<br />\n";
    }
}

echo "<h1>Headers in INBOX</h1>\n";
$headers = imap_headers($mbox);

if ($headers == false) {
    echo "Call failed<br />\n";
} else {

    foreach ($headers as $val) {
        echo $val . "<br />\n";
    }

$mbox = @imap_open("{mail.smstd.cl:993/imap/ssl/novalidate-cert}"."INBOX", $address, $password);
    $mail_header = imap_header($mbox, 2);
        
    $mail_body = imap_body($mbox, 2);
        $message = imap_fetchbody($mbox,3,2);

//echo $message;       
        foreach($mail_header as $mail_head)
        {
            $mail[] = $mail_head;
        }
        
        $mail['body'] = $mail_body;
       // echo $mail["body"];
}

imap_close($mbox);    

        exit;
      // $this->load->view('mail');
	}

	function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function newfilteremail(){

	    $config['username'] = "patricio@smstd.cl";
	    $config['password'] = "patricio2019";
	    $config['host'] =  "mail.smstd.cl";
	    $config['port'] =  "993";
	    $config['encrypto'] = "imap/ssl/novalidate-cert";
	     
	     $config['cache'] = [
	'active'     => false,
	'adapter'    => 'file',
	'backup'     => 'file',
	'key_prefix' => 'imap:',
	'ttl'        => 60,
];

	  $imap = $this->load->library('Imap'); // Load the IMAP Library
	  $this->imap->connect($config);
		  
		    foreach ($this->imap->get_folders() as $key) {
		    	echo $key."<br>";
		    }

			    echo "<pre>";
		       print_r($this->imap->get_message(1)["body"]["html"]);
			   echo "<pre>"; 
		     echo  base64_decode($this->imap->get_message(3)["attachments"][0]["content"]);
			  
			  
}


function newfilteremailleer(){



	  $imap = $this->load->library('Leerimap'); // Load the IMAP Library
	 
		$email = new Leerimap();

		if($email->connect('{mail.smstd.cl:993/imap/ssl/novalidate-cert}INBOX','patricio@smstd.cl','patricio2019')){
				$inbox = $email->getMessages('html');
		}

		echo "<pre>";
			print_r($inbox);
		echo "</pre>";
			  
}


public function jsonimap(){

$imap = $this->load->library('Leerimap'); // Load the IMAP Library
	 
$email = new Leerimap();

$connect =  $email->connect('{mail.smstd.cl:993/imap/ssl/novalidate-cert}INBOX','patricio@smstd.cl','patricio2019');

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

public function listadoimap () {
/*$attachments_dir = FCPATH.'attachments';
echo $attachments_dir;
exit;*/


		$this->load->view('chat/listado');

}

	
               
	
}
