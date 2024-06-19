<?php 
//include "../inc.php";
// include "../../travcrm-dev/inc.php";
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

// $masterid=$_REQUEST['id'];
// $clientType=$_REQUEST['type'];
$refId=$_REQUEST['Refid'];
$select='*';
 $where='referanceNumber="'.$refId.'" order by id desc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$tripName=$querydata['subject'];
// $idas=$querydata['id'];
 $queryId=makeQueryId($querydata['id']);
// $displayid=makeQueryId($querydata['id']);

$queryId='#'.makeQueryId($queryList['displayId']).' - '.$destination.' - '.date('j F Y',$queryList['dateAdded']);  
$where1='queryId="'.$querydata['id'].'" and status = 1';
$rs1=GetPageRecord('*','quotationMaster',$where1);
$quotationList=mysqli_fetch_array($rs1);

// $select2 = "*";
$where2='quotationId="'.$quotationList['id'].'" and queryId="'.$quotationList['queryId'].'"';
$rs2=GetPageRecord('*','invoiceMaster',$where2);
$invoicedata=mysqli_fetch_array($rs2);
$invoiceVoucher = $invoicedata['id'];
// $invoicePdfLink = "".$fullurl."/load_remittance_invoice.php?id=".$querydata['id']."&download=0";
$invoicePdfLink = "".$fullurl.'tcpdf/examples/getpdf.php?pageurl='.$fullurl.'invoicehtml.php?id='.encode($invoicedata['id'])."&download=0";

/*$a=GetPageRecord('*','queryDateDestination',' queryId="'.$queryId.'" order by id asc'); 
$destinationDay=mysqli_fetch_array($a);*/
// print_r($where2);
	
$json_result ='{
        "tripName" : "'.$tripName.'",
        "queryId" : "'.$displayid.'",
        "invoicePdfLink" : "'.$invoicePdfLink.'"
	}';
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}