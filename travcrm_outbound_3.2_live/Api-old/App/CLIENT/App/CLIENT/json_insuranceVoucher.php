<?php 
// include "../../travcrm-dev/inc.php";
//include "../inc.php";
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

// $masterid=$_REQUEST['id'];
// $type=$_REQUEST['type'];
// $refId=$_REQUEST['Refid'];
$refId=$_REQUEST['Refid'];

$select='*';
$where='referanceNumber="'.$refId.'" and queryStatus=3 order by fromDate DESC';
// $where='companyId="'.$masterid.'" and clientType="'.$type.'" and queryStatus=3 order by fromDate DESC';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
while($queryList=mysqli_fetch_array($rs)){

// $queryId='#'.makeQueryId($queryList['displayId']).' - '.$destination.' - '.date('j F Y',$queryList['dateAdded']);/  
$queryId='#'.makeQueryId($queryList['displayId']).' - '.$destination.' - '.date('j F Y',$queryList['dateAdded']);  
$where1='queryId="'.$queryList['id'].'" and status = 1';
$rs1=GetPageRecord('*','quotationMaster',$where1);
$quotationList=mysqli_fetch_array($rs1);

// echo $where2='quotationId="'.$quotationList['id'].'"';
$rs2=GetPageRecord('*','finalQuoteInsurence','quotationId="'.$quotationList['id'].'" ORDER BY id DESC');
$insurenceList=mysqli_fetch_array($rs2);
if($insurenceList['insurenceVoucher']!=""){
	$insuranceVoucher= $fullurl.'upload/'.$insurenceList['insurenceVoucher']."";
}else{
	$insuranceVoucher= "";
}


$json_result.= '{
        	"qid" : "'.$queryId.'",
        	"insuranceVoucher" : "'.$insuranceVoucher.'"
},';
}

 ?>
	{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
	}