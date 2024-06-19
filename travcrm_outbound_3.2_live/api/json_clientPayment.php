<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$masterid=$_REQUEST['id'];
$type=$_REQUEST['type'];

$select='*';
$where='companyId="'.$masterid.'" and clientType="'.$type.'" order by id';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
while($queryList=mysqli_fetch_array($rs)){
$queryId=makeQueryId($queryList['id']);
$select1='*';
$where1='queryId="'.$queryList['id'].'"';
$rs1=GetPageRecord($select1,_AGENT_PAYMENT_REQUEST_,$where1);
$requesetdata=mysqli_fetch_array($rs1);
$pendingamount=$requesetdata['pendingCost'];

$finalReqCost=$queryList['totalQueryCost'];
$Cgst=$requesetdata['reqclientCGst'];
$cgst=round($finalReqCost*$Cgst/100);
$Sgst=$requesetdata['reqclientSGst'];
$sgst=round($finalReqCost*$Sgst/100);
$Igst=$requesetdata['reqclientIGst'];
$igstval=round($finalReqCost*$Igst/100);

$finalCost=round($finalReqCost+$cgst+$sgst+$igstval+$requesetdata['extraCost']);

/*if($requesetdata['totalClientCost']==0){
$totalClientCost=$queryList['totalQueryCost'];
} else {
$totalClientCost=$requesetdata['totalClientCost'];
}
*/
$totalpendingamount=0;
$select2='*';
$where2='queryId='.$queryList['id'].''; 
$rs2=GetPageRecord($select2,_DMC_PAYMENT_LIST_MASTER_,$where2); 
while($listofpayment=mysqli_fetch_array($rs2)){
$totalpendingamount=$totalpendingamount+$listofpayment['amount'];
$pendingCost=$finalCost-$totalpendingamount;
} 

}
    $json_result = '{
        "tripId" : "'.$queryId.'",
        "totalClientCost" : "'.$finalCost.'",
		"received" : "'.$totalpendingamount.'",
		"pendingCost" : "'.$pendingCost.'"
	}';
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}