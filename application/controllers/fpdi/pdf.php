<?php

include_once './vendor/autoload.php';

use setasign\FpdiProtection;

function pdfEncrypt ($origFile, $password
        ){

    $fOri = sys_get_temp_dir() . '/'. uniqid();
    $fDest = sys_get_temp_dir() . '/'. uniqid();
    
    $file = fopen($fOri, 'w');
    fwrite($file, base64_decode($origFile));
    fseek($file, 0);
    
    $pdf = new \setasign\FpdiProtection\FpdiProtection();
    // set the format of the destinaton file, in our case 6×9 inch
//    $pdf->FPDF('P', 'in', array('6','9'));

    //calculate the number of pages from the original document
    $pagecount = $pdf->setSourceFile($fOri);

    // copy all pages from the old unprotected pdf in the new one
    for ($loop = 1; $loop <= $pagecount; $loop++) {
        $tplidx = $pdf->importPage($loop);
        $pdf->addPage();
        $pdf->useTemplate($tplidx);
    }

    // protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
    $pdf->SetProtection(array(),$password);
    $pdf->Output($fDest, 'F');
    
    $c = file_get_contents($fDest);
    
    unlink($fOri);
    unlink($fDest);

    return base64_encode($c);
}

$bs64 = base64_encode(file_get_contents('/home/jair/Escritorio/Propuesta_Comercial_ALIADOS.pdf'));

$s = pdfEncrypt($bs64, '123456');

echo $s;
