<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require dirname(__FILE__) . '/htmlpdf2/autoload.php';
//require APPPATH . 'third_party/htmlpdf/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class Html2pdflibreria {			  
	  function __construct($params = null) {
	    
	 
	  }


	  function reporte($html){
	  	   $html2pdf = new Html2Pdf();
	  	       $html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->pdf->SetProtection(array('print','copy'));

		   $html2pdf->writeHTML($html);
		   $html2pdf->output('forms.pdf');
	  }
}