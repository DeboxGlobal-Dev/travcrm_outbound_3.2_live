<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$guestId = $_GET['guestId'];

if($_GET['guestId']!=''){
	// $id=clean(decode($_GET['guestId']));
	$id=$_GET['guestId'];
	
	$select1='*';  
	$where1='id='.$id.''; 
	$rs1=GetPageRecord($select1,_CONTACT_MASTER_,$where1); 
	$editresult=mysqli_fetch_array($rs1);

	$editid=clean($editresult['id']); 
	$editassignTo=clean($editresult['assignTo']); 
	$tourType=clean($editresult['tourType']); 
	$queryId=clean($editresult['queryId2']);
	$contactType=clean($editresult['contactType']);
	$nationality=clean($editresult['nationality']); 
	$referenceNo=clean($editresult['referenceNo']);
	$referenceNo=clean($editresult['referenceNo']); 
	$editcontacttitleId=clean($editresult['contacttitleId']); 
	$editfirstName=clean($editresult['firstName']);
	$editlastName=clean($editresult['lastName']);
	$editdesignationId=clean($editresult['designationId']);
	$editbirthDate=clean($editresult['birthDate']);
	$editanniversaryDate=clean($editresult['anniversaryDate']);

	$otp=1010; 


	$res3 = GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$queryId.'" order by id asc');
	$quotationData = mysqli_fetch_assoc($res3);

	if($editfirstName!='' && $editbirthDate!='')
	{		
	
	$json_result = '{
		"username" : "'.$editfirstName.' '.$editlastName.'",
		"dob" : "'.$editbirthDate.'"
	},';
	}else{
	   $json_result.= '{
		"error" : "UserName And Dob Does Not Exits"
	},'; 
	}


	}else{
      $json_result.= '{
		"error" : "This Guest Id Does Not Match"
	},';
	}

	?>


{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}

	

