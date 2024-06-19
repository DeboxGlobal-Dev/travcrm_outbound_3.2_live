<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');   
header("Content-Type: application/json");

$Id = $_GET['Id'];
if($_GET['Id']!=''){
	// $id=clean(decode($_GET['guestId']));
	$id=$_GET['Id'];

	$select1='*';  
	$where1='id='.$id.''; 
	$rs1=GetPageRecord($select1,CORPORATE_MASTER,$where1); 
	$editresult=mysqli_fetch_array($rs1);
// 	print_r($editresult);
// 	exit;
    $queryId=clean($editresult['queryId2']);
    $editassignTo=clean($editresult['assignTo']);
	$editOpsAssignTo=clean($editresult['OpsAssignTo']);
	$editname=clean($editresult['name']);
	$editcompanyEmail=decode($editresult['companyEmail']);
	$editcompanyPhone=decode($editresult['companyPhone']);
	$editwebsiteURL=clean($editresult['websiteURL']);
	$editdetails=clean($editresult['details']);
	$editcontactPerson=clean($editresult['contactPerson']);
	$editcompanyTypeId=clean($editresult['companyTypeId']);
	$bussinessTypeId=clean($editresult['bussinessType']);
	$editcountryId=clean($editresult['countryId']);
	$editstateId=clean($editresult['stateId']);
	$editcityId=clean($editresult['cityId']);
	$edittitle=clean($editresult['title']);
	$addedBy=clean($editresult['addedBy']);
	$dateAdded=clean($editresult['dateAdded']);

	// $editcompanyTypeId=clean($editresult['companyTypeId']);
	// $editcountryId=clean($editresult['countryId']);
	// $editstateId=clean($editresult['stateId']); 
	// $editcityId=clean($editresult['cityId']); 
	// $edittitle=clean($editresult['title']); 
	// $addedBy=clean($editresult['addedBy']);
	// $dateAdded=clean($editresult['dateAdded']);
	// $modifyBy=clean($editresult['modifyBy']);
	// $modifyDate=clean($editresult['modifyDate']);
	// $editsupId=clean($editresult['id']);
	// $editaddress1=clean($editresult['address1']);  
	// $editaddress2=clean($editresult['address2']);  
	// $editaddress3=clean($editresult['address3']);  
	// $addressInfo=clean($editresult['addressInfo']);  
	// $editremark1=clean($editresult['remark1']);  
	// $editremark2=clean($editresult['remark2']);  
	// $editremark3=clean($editresult['remark3']);  
	// $editpinCode=clean($editresult['pinCode']);
	// $editfacebook=clean($editresult['facebook']);
	// $edittwitter=clean($editresult['twitter']);
	// $editlinkedIn=clean($editresult['linkedIn']);
	$otp=1010; 

	$res3 = GetPageRecord('*',QUOTATION_MASTER,'queryId="'.$queryId.'" order by id asc');
	$quotationData = mysqli_fetch_assoc($res3);

			
	
	$json_result = '{
		"Id" : "'.$Id.'",
		"companyEmail" : "'.$companyEmail.'",
		"dob" : "'.$editbirthDate.'",
		"type" : "'.$contactType.'",
		"otp" : "'.$otp.'",
		"quotationId" : "'.encode($quotationData['id']).'"
	},';


	}else{
      $json_result.= '{
		"error" : "This Reference Id Does Not Match"
	},';
	}

	?>


{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}