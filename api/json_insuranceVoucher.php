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
$where='companyId="'.$masterid.'" and clientType="'.$type.'" and queryStatus=3 order by id';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
while($queryList=mysqli_fetch_array($rs)){
    
	$qid='#'.makeQueryId($queryList['id']).' - '.$destination.' - '.date('j F Y',$queryList['dateAdded']);  
	
	$where1='queryId="'.$queryList['id'].'" and status=1';
	$rs1=GetPageRecord('*','quotationMaster',$where1);
	$quotationList=mysqli_fetch_array($rs1);

	$where2='quotationId="'.$quotationList['id'].'"';
	$rs2=GetPageRecord('*','finalQuoteInsurence',$where2);
	$insurenceList=mysqli_fetch_array($rs2);
	$insuranceVoucher="".$fullurl."upload/".$insurenceList['insurenceVoucher'].""; 

}
$json_result.= '{
	"qid" : "'.$qid.'",
	"insuranceVoucher" : "'.$insuranceVoucher.'"
},';
?>

{
	"status":"true",
	"results":[<?php echo trim($json_result, ',');?>]
}