<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$mobRefId=$_REQUEST['mobRefId'];
$mobile=$_REQUEST['mobile'];
// print_r($mobile);die();

if($mobile!=""){
  $where1='mobile_number="'.$mobile.'" order by id desc';
$rs1=GetPageRecord('*','mice_guestListMaster',$where1);
$refid1= mysqli_num_rows($rs1);
if($refid1>0){
$resListing1=mysqli_fetch_array($rs1); 


if($mobRefId!='' && strlen($mobRefId)>5){
$where4='referanceNumber="'.$mobRefId.'" and id="'.$resListing1['queryId'].'" order by id desc';
// $where4='id="'.$resListing1['queryId'].'" order by id desc';
$rs4=GetPageRecord('*','queryMaster',$where4);
$refid4= mysqli_num_rows($rs4);
$resListing4=mysqli_fetch_array($rs4); 
$documentType =$resListing4['selectedGuestCols'];
$companyId =$resListing4['companyId'];

 $where2='id="'.$companyId.'" order by id desc';
$rs2=GetPageRecord('*','corporateMaster',$where2);
$resListing2=mysqli_fetch_array($rs2);
$companyLogo =$resListing2['companyLogo'];
$companyName =$resListing2['name'];



$array =explode(',',$documentType);

// print_r($array);die();


if(in_array(43, $array)) {
    $adhaar = "1";
} else {
    $adhaar= "0";
}if(in_array(59, $array)) {
    $pan = "1";
} else {
    $pan= "0";
}if(in_array(39, $array)) {
    $pass = "1";
} else {
    $pass= "0";
}if(in_array(32, $array)) {
    $vacc = "1";
} else {
    $vacc= "0";
}


$res3 = GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$resListing4['id'].'" order by id asc');
$quotationData = mysqli_fetch_assoc($res3);
$otp=1010;   

$json_result = '{
        "mobRefId" : "'.$resListing4['referanceNumber'].'",
        "queryId" : "'.$resListing4['id'].'",
		"id" : "'.$resListing1['id'].'",
		"mobile" : "'.$resListing1['mobile_number'].'",
		"type" : "'.$resListing1['contactType'].'",
		"otp" : "'.$otp.'",
		"adhaar" : "'.$adhaar.'",
		"pan" : "'.$pan.'",
		"pass" : "'.$pass.'",
		"Vacc" : "'.$vacc.'",
		"aadharStatus" : "'.$resListing1['aadhar_status'].'",
		"panStatus" : "'.$resListing1['pan_status'].'",
		"voterStatus" : "'.$resListing1['voter_status'].'",
		"vaccinationStatus" : "'.$resListing1['vaccination_status'].'",
		"passportStatus" : "'.$resListing1['passport_status'].'",
		"quotationId" : "'.encode($quotationData['id']).'",
		"companyName" : "'.$companyName.'",
		"logo" : "https://funnfunholidays.in/live/' . $companyLogo . '"
	},';
}else{
      $json_result.= '{
		"error" : "This Reference Id Does Not Match"
	},';
}


}else{
      $json_result.= '{
		"error" : "This Mobile No Does Not Match"
	},';
}
}else{
$json_result.= '{
		"error" : "Please Enter Mobile No"
	},';    
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
