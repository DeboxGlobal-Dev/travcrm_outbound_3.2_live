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
	// $id=$_GET['guestId'];
	
		$select1='*';  
		$where1='displayId="'.$guestId.'"'; 
		$rs1=GetPageRecord($select1,'mice_guestListMaster',$where1); 
		$editresult=mysqli_fetch_array($rs1);
		$editid=clean($editresult['id']); 
		$editguestid=clean($editresult['displayId']);
		$editfirstName=clean($editresult['guest_first_name']);
		$editmiddle_name=clean($editresult['middle_name']);
		$editlast_name=clean($editresult['last_name']);
		$editcontactType=clean($editresult['contactType']);
		$editdesignationId=clean($editresult['designationId']);
		$editbirthDate=clean($editresult['date_of_birth']);
		$editanniversaryDate=clean($editresult['anniversaryDate']);
		$queryId=clean($editresult['queryId']);
		$Refid=clean($editresult['Refrence_no']);


		$otp=1010; 


		$res3 = GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$queryId.'" order by id asc');
		$quotationData = mysqli_fetch_assoc($res3);


			if($editfirstName!='' && $editbirthDate!='')
			{		
			
			$json_result = '{
		
				"username" : "'.$editfirstName.' '.$editmiddle_name.' '.$editlast_name.'",
				"dob" : "'.$editbirthDate.'"
			},';
			}else{
			$json_result.= '{
				"error" : "FirstName And Dob Does Not Exits"
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


