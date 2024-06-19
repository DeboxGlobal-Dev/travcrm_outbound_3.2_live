<?php
header('Content-type: text/html');
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
	// include "../../config/logincheck.php"; 
	// supplier list
	$json_result = "";
	$supplierSql = "select * from salesQueryMaster where 1 and closerDate!='0000-00-00' and deletestatus=0 order by id desc";
	$supplierQuery=mysqli_query(db(),$supplierSql); 
	while($salesData=mysqli_fetch_array($supplierQuery)) { 


		// company master 
		if($salesData['clientType'] == 1){ 
		  $contactno = getPrimaryPhone($salesData['companyId'],'corporate');
		}
		if($salesData['clientType'] == 2){ 
		  $contactno = getPrimaryPhone($salesData['companyId'],'contacts');
		}


		// supplier date listing
		$supplr_id = $salesData['id'];
		if(!empty($salesData['cityId'])){ 
			$cityId = getCityName($salesData['cityId']);
		}
		else {
			$cityId = getcity($supplr_id); 
		}

		if(!empty($salesData['stateId'])){ 
			$stateId = getStateName($salesData['stateId']);
		}
		else{
			$stateId = getstate($supplr_id); 
		}

		if(!empty($salesData['countryId'])){ 
			$countryId = getCountryName($salesData['countryId']);
		}
		else {
			$countryId = getcountry($supplr_id); 
		}

        $salesStageSql = "select * from salesStageMaster where 1 and  id=".$salesData['salesStage']."";
		$salesStageQuery=mysqli_query(db(),$salesStageSql); 
		$salesStageData=mysqli_fetch_array($salesStageQuery);
        $statustext = $salesStageData['name'];
        $statusper = $salesStageData['probability'].'%';

		$json_result.= '{
			"id" : "'.$salesData['id'].'",
			"leadid" : "'.makeQueryId($salesData['id']).'",
			"subject" : "'.$salesData['subject']	.'",
			"type" : "'.showClientType($salesData['clientType']).'",
			"client" : "'.showClientTypeUserName($salesData['clientType'],$salesData['companyId']).'",
			"destination" : "'.getDestination($salesData['destinationId']).'",
			"salesamount" : "'.$salesData['expectedSales']	.'",
			"closerdate" : "'.$salesData['closerDate'].'",
			"createdon" : "'.$salesData['queryDate'].'",
			"contactno" : "'.$contactno.'",
			"salesperson" : "'.getUserName($salesData['assignTo']).'",
			"statustext" : "'.$statustext.'",
			"statusper" : "'.$statusper.'"
		},';
	}

	// json is here
	?>

	{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
	}