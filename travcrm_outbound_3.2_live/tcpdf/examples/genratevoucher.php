<?php  
ob_clean();
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
function url_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
if(isset($_REQUEST['packagename'])!='' && isset($_REQUEST['packagename'])){
    $packagename = $_REQUEST['packagename'];
}else{
    $packagename = "Invoice";
}
// Include the main TCPDF library (search for installation path).

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Voucher');
$pdf->SetTitle('Voucher');
$pdf->SetSubject('Voucher');
$pdf->SetKeywords('Voucher');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins('5', '10', '5');

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$tagvs = array(
    'p' => array(0 => array('h' => 0, 'n' => 0.1), 1 => array('h' => 0, 'n' => 0.1)), 
    'div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)), 
    'ul' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)), 
    'h6' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)), 
    'h3' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0))
);

$pdf->setHtmlVSpace($tagvs);
$pdf->setListIndentWidth(4);
// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 9);

// add a page
// $pdf->AddPage();
$pdf->AddPage('P','A4');
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
 
$html = url_get_contents($_GET['pageurl']);

// output the HTML content
$pdf->writeHTML($html, false, false, false, false, false);

 

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
//$pdf->lastPage();

// ---------------------------------------------------------
ob_clean();
//Close and output PDF document
// if(!isset($_REQUEST['download']) && !isset($_REQUEST['savetoserver'])){
// $pdf->Output('Voucher.pdf', 'I');
// } 

// if($_REQUEST['download']==1){
// header("Content-Type: application/octet-stream");
// $pdf->Output('Voucher.pdf','D');
// }

// if($_REQUEST['downloadonserver']==1){
// $pdf->Output('Voucher.pdf', 'F');
// }
$pdf->Output('package/example_002.pdf', 'I');
 

// if($_REQUEST['savetoserver']==1){
// ob_clean();
// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'tcpdf/examples/invoice/'.$_REQUEST['invoicenumber'].'-Voucher.pdf', 'F'); 
// }



//============================================================+
// END OF FILE
//============================================================+
