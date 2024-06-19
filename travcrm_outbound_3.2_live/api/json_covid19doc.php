<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


$select='*';
$where='name="Covid-19 Guidlines"';
$rs=GetPageRecord($select,_DOCUMENT_FOLDER_MASTER_,$where);
$folderdata=mysqli_fetch_array($rs);

$where1='folderId='.$folderdata['id'].''; 
$rs1=GetPageRecord('*',_DOCUMENT_SUBFOLDER_MASTER_,$where1); 
while($subfolderData=mysqli_fetch_array($rs1)){

$where2='subfolderId='.$subfolderData['id'].''; 
$rs2=GetPageRecord('*',_DOCUMENT_FILES_MASTER_,$where2); 
$covid19Data=mysqli_fetch_array($rs2);

$covid19pdf="".$fullurl."dirfiles/".$covid19Data['uploadFile']."";
$json_covid19 = '{
		"id" : "'.$covid19Data['id'].'",
		"name" : "'.$subfolderData['name'].'",
		"folderId" : "'.$covid19Data['folderId'].'",
		"subfolderId" : "'.$covid19Data['subfolderId'].'",
		"covid19pdf" : "'.$covid19pdf.'"
	}'; echo $json_covid19;
}
//==============================================//
//$downloadPdfLink = "".$fullurl."tcpdf/examples/getpdf.php?pageurl=".$fullurl."download-agentvoucher.php?id=".encode($voucherdetails['id'])."&download=0";

//$downloadvoucher = "".$fullurl."tcpdf/examples/getpdf.php?pageurl=".$fullurl."download-agentvoucher.php?id=".encode($voucherdetails['id'])."&download=1";
?>