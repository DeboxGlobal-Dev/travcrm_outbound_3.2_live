<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$masterid=$_REQUEST['id'];
$clientType=$_REQUEST['type'];
$select='*';
$where='companyId='.$masterid.' and clientType='.$clientType.' order by id desc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$tripName=$querydata['subject'];
$displayid=makeQueryId($querydata['id']);

$invoicePdfLink = "".$fullurl."/load_remittance_invoice.php?id=".$querydata['id']."&download=0";
 
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