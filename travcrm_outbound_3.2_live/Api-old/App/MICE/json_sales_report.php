<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');   
header("Content-Type: application/json");

 $guestId = $_GET['guestId'];
if($guestId!=''){
	// $id=clean(decode($_GET['guestId']));
	

	$select1='*';  
	$where1='id='.$guestId.''; 
	$rs1=GetPageRecord($select1,'userMaster',$where1); 
	$editresult=mysqli_fetch_array($rs1);
// 	print_r($editresult);
// 	exit;
    $queryId=clean($editresult['queryId2']);
    
	$res3 = GetPageRecord('*','target','userid="'.$editresult['id'].'"');
	$quotationData = mysqli_fetch_assoc($res3);

	$year=clean($quotationData['year']);		
	
	$json_result = '{
		"Id" : "'.$guestId.'",
        "year" : "'.$year.'"
	},';


	}else{
      $json_result.= '{
		"error" : "Please Enter Reference Id";
	},';
	}

	?>


{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}