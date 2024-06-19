<?php 

include "../../../inc.php";

//include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");
 
$refId=$_REQUEST['Refid'];

$select='*';
$where='referanceNumber="'.$refId.'" and queryStatus=3 order by fromDate DESC';
// $where='companyId="'.$masterid.'" and clientType="'.$type.'" and queryStatus=3 order by fromDate DESC';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
while($queryList=mysqli_fetch_array($rs)){
 
$where1='queryId="'.$queryList['id'].'" and status = 1';
$rs1=GetPageRecord('*','quotationMaster',$where1);
$quotationList=mysqli_fetch_array($rs1);
 
$apiurl = 1;
$voucher =$fullurl.'loadcreatevoucher_client.php?module=ClientVoucher&quotationId='.($quotationList['id']).'&apiurl='.$apiurl;

// http://localhost/easytravcrm/TravCRMInBound/travcrm-dev/loadcreatevoucher_client.php?quotationId=1646&module=ClientVoucher
$json_result.= '{
        	"qid" : "'.$queryId.'",
        	"clientVoucher" : "'.$voucher.'"
},';
}

 ?>
	{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
	}