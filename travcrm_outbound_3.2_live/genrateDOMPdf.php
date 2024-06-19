<?php  
include_once('inc.php');
include_once('dompdf/autoload.inc.php'); 

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;
if(isset($_REQUEST['packagename'])){
	$pName = $_REQUEST['packagename'];
}else{
	$pName = "Genrate PDF";
}
if(isset($_REQUEST['download']) && $_REQUEST['download']==1){
	$download = false;
}else{
	$download = false;
}
$purl = $_REQUEST['pageurl'];
$html = url_get_contents($purl);
// $_SERVER['DOCUMENT_ROOT'].'/travcrm-dev/phpwkhtmltopdf/proposals/'.$pName;

// instantiate and use the dompdf class
$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$options->set('isPhpEnabled', TRUE);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream(trim($pName), array('Attachment' => $download ));