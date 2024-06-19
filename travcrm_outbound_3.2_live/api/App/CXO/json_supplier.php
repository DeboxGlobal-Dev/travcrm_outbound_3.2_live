<?php
header('Content-type: text/html');
include "../../../inc.php";
// include "../../config/logincheck.php"; 
// supplier list
$json_result = "";
	$supplierSql = "select * from suppliersMaster where 1 and name!='' and deletestatus=0 order by dateAdded desc";
	$supplierQuery=mysqli_query(db(),$supplierSql); 
	while($supplierData=mysqli_fetch_array($supplierQuery)) { 
		// supplier date listing
		$supplr_id = $supplierData['id'];
		if(!empty($supplierData['cityId'])){ 
			$cityId = getCityName($supplierData['cityId']);
		} else {
			$cityId = getcity($supplr_id); 
		}

		if(!empty($supplierData['stateId'])){ 
			$stateId = getStateName($supplierData['stateId']);
		} else{
			$stateId = getstate($supplr_id); 
		}

		if(!empty($supplierData['countryId'])){ 
			$countryId = getCountryName($supplierData['countryId']);
		} else {
			$countryId = getcountry($supplr_id); 
		}

		$json_result.= '{
			"id" : "'.$supplierData['id'].'",
			"name" : "'.$supplierData['name'].'",
			"city" : "'.$cityId.'",
			"state" : "'.$stateId.'",
			"country" : "'.$countryId.'",
			"type" : "'.getsuppliersTypeNameList($supplierData['id']).'",
			"destination" : "'.getDestination($supplierData['destinationId']).'",
			"contactperson" : "'.$supplierData['contactPerson'].'",
			"contactno" : "'.getPrimaryPhone($supplierData['id'],'suppliers').'",
			"emailid" : "'.getPrimaryEmail($supplierData['id'],'suppliers').'"
		},';
	}
// json is here
?>
	{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
	}
