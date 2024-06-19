<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$guestId = $_GET['guestId'];
$img1 = $_FILES['img1']['name'];


    if(!empty($_FILES['img1']['name'])){
    $uploadimg1='../../../dirfiles/'.time().str_replace(' ','',$_FILES['img1']['name']);
    copy($_FILES['img1']['tmp_name'],$uploadimg1);
    }else{
    $uploadimg1 = $_POST['userImageOld'];
    }
    
        if($guestId!=''){
    $namevalue = 'Image1="'.$uploadimg1.'"';
    $lasId = addlistinggetlastid('contactsMaster',$namevalue);
}
if($_GET['guestId']!=''){
	// $id=clean(decode($_GET['guestId']));
	$id=$_GET['guestId'];
	
	$select1='*';  
	$where1='id='.$id.''; 
	$rs1=GetPageRecord($select1,contactsMaster,$where1); 
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
$img=clean($editresult['image1']);

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

	if($editfirstName!='' && $editbirthDate!='')
	{		
	
	$json_result = '{
		"id" : "'.$editid.'",
		"guestId" : "'.$guestId.'",
		"username" : "'.$editfirstName.' '.$editlastName.'",
		"dob" : "'.$editbirthDate.'",
		"type" : "'.$contactType.'",
		"otp" : "'.$otp.'",
		"img": "'.$img.'";
		"quotationId" : "'.encode($quotationData['id']).'"
	},';
	}else{
	   $json_result.= '{
		"error" : "FirstName And Dob Does Not Exits"
	},'; 
	}


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

	

