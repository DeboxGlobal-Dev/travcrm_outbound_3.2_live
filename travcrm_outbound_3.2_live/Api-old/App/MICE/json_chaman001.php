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
	$rs1=GetPageRecord($select1,_CORPORATE_MASTER_,$where1); 
	$editresult=mysqli_fetch_array($rs1);
// 	print_r($editresult);
// 	exit;
    $queryId=clean($editresult['queryId2']);
    $Id=clean($editresult['id']);
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
	$editconsortiaName=showClientTypeUserName('1',$editresult['cosortiaId']);
	
	
	if($bussinessTypeId!=''){
		$rs='';
		$rs=GetPageRecord('*','businessTypeMaster','id='.$bussinessTypeId.'');
		$resListing21=mysqli_fetch_array($rs);
		$bt = strip($resListing21['name']);
	}

    $n=1;
    $rs=''; 
    $rs=GetPageRecord('*','contactPersonMaster',' corporateId='.$Id.' order by primaryvalue asc'); 
    $contactPD=mysqli_fetch_array($rs);
    $fname = trim($contactPD['firstName']);
    $lname = trim($contactPD['lastName']);
    $desig = trim($contactPD['designation']);
    $phone = decode($contactPD['phone']);
    $email = decode($contactPD['email']);
    
    
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

	$res3 = GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$queryId.'" order by id asc');
	$quotationData = mysqli_fetch_assoc($res3);

			
	
	$json_result = '{
		"Id" : "'.$Id.'",
		"name" : "'.$editname.'",
		"companyEmail" : "'.$editcompanyEmail.'",
		"companyphone" : "'.$editcompanyPhone.'",
		"bussinessTypeId" : "'.$bt.'",
		"contactPerson" : "'.$fname.' '.$lname.'",
		"designation" : "'.$desig.'"
		"Phone" : "'.$phone.'"
		"Email" : "'.$email.'"
		
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