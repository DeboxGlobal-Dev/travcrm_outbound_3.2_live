<?php
header('Content-type: text/html');
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";

	if($_REQUEST['yearCode']!='' && $_REQUEST['monthCode']!=''){ 
		$filterFromDate  = date($_REQUEST['yearCode'].'-'.$_REQUEST['monthCode'].'-01');
		$filterToDate  = date($_REQUEST['yearCode'].'-'.$_REQUEST['monthCode'].'-t');
		//echo date('M, Y',strtotime($filterFromDate)); 
	}else{
		$filterFromDate  = date('Y-m-01');
		$filterToDate  = date('Y-m-t');
		//echo date('M, Y',strtotime($filterFromDate)); 
	} 


$totalClientBalance=0;
$totalPayable=0; 
$totalPax=0; 
$totalNight=0; 
$totalQuery=0; 
$no=1;
	
	$datefilterQuery='';
	$datefilterQuery=' and fromDate between "'.$filterFromDate.'" and "'.$filterToDate.'"'; 

	$totalPax=$totalNight=$totalClientCost=$totalSupplierCost=$totalProfitCost=$totalPayable=$totalClientBalance=$totalProfit=0;
	 // '.$datefilterQuery.'
	$where=' 1 and status=1 and queryId in ( select id from queryMaster where queryStatus=3 ) '.$datefilterQuery.' ';    
	$rs=GetPageRecord('*',_QUOTATION_MASTER_,$where); 

	while($quotationData=mysqli_fetch_array($rs)){ 
		$an2ss2='';
		$an2ss2=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'" ');
		$queryData=mysqli_fetch_array($an2ss2);
		$getClientName=showClientTypeUserName($queryData['clientType'],$queryData['companyId']);

		if($quotationData['isTourEx'] == 1){
			$makeQueryId = makeExtensionId($queryData['displayId']);
		}else{
			$makeQueryId = makeQueryTourId($queryData['id']);
		}
		
		$totalPax=$totalPax+($quotationData['adult']+$quotationData['child']);
		$totalNight=$totalNight+($quotationData['night']);
		
		$totalClientCost = $quotationData['totalQuotCost'];
		$totalSupplierCost = $quotationData['totalCompanyCost'];
		$totalProfitCost = $totalClientCost-$totalSupplierCost;
		
		$totalPayable = $totalPayable+$totalSupplierCost;
		$totalClientBalance = $totalClientBalance+$totalClientCost;
		$totalProfit = $totalProfit+$totalProfitCost;

		$json_result_data.= '{
			"tourid" : "'.$makeQueryId.'",
			"agentname" : "'.strip($getClientName).'",
			"traveldate" : "'.date("d-m-Y", strtotime($quotationData['fromDate'])).'",
			"salesperson" : "'.strip($queryData['salesassignTo']).'",
			"opsperson" : "'.getUserName($queryData['assignTo']).'",
			"suppliercost" : "'.round($totalSupplierCost,2).'",
			"clientcost" : "'.round($totalClientCost,2).'",									
			"profit" : "'.round($totalProfitCost,2).'"
		},';
		$no++;
 	}

 	$json_result='{
 		"totalsuppliercost" : "'.round($totalPayable,2).'",
 		"totalclientcost" : "'.round($totalClientBalance,2).'",
 		"totalprofit" : "'.round($totalProfit,2).'",
 		"totalnight" : "'.$totalNight.'",
 		"totalpax" : "'.$totalPax.'",
 		"jsonresultdata" : ['.trim($json_result_data,',').']
 	}';

?>

	{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
	}


