<?php
// include "../../inc.php";
function url_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
if($_REQUEST['packagename']!='' && isset($_REQUEST['packagename'])){
    $packagename = $_REQUEST['packagename'];
}else{
    $packagename = "Elite";
}
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
// custom headers
class MYPDF extends TCPDF {
    //Page header
    public function Footer() {
        // Position at 15 mm from bottom
        // $this->SetY(-20); 
        $image_file = K_PATH_IMAGES.'company-info-footer.jpg';
        // $image_file = $fullurl.'images/company-info-footer.jpg';
        $this->Image($image_file, 0, 277, 210, '', 'jpg', '', 'T', false, 300, false, false, false, false, false, false, false);
    } 

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($packagename);
$pdf->SetTitle($packagename);
$pdf->SetSubject($packagename);
$pdf->SetKeywords($packagename);

// set default header data
// $pdf->SetHeaderData(false);

// remove default header/footer
$pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(0, 10, 0);

// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetHeaderMargin(0);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// $pdf->SetFooterMargin(20);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
// $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
// $pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('P','A4');

// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

 $html = url_get_contents($_GET['pageurl']);
 // $html = '';

// output the HTML content
$pdf->writeHTML($html, false, false, false, false, false);

 

// Print text using writeHTMLCell()
// $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

// ---------------------------------------------------------

// if($_REQUEST['savetoserver']==1){
//     ob_clean();
//     $pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'dev2.0/TravCRMInBound/travcrm-dev/tcpdf/examples/package/example_001.pdf', 'F');
// }

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('package/example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
<!-- <script src="../../js/jquery-1.11.3.min.js"></script>   
<script>
parent.$('#gpdf').html('<a style="padding:10px 20px; background-color:#009900; color:#FFFFFF; display:inline-block;" target="_blank" href="tcpdf/examples/package/example_001.pdf"><strong>Download PDF</strong></a>');
</script>
 -->