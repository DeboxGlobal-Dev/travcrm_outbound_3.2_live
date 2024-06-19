<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$mobile=$_REQUEST['mobile'];

$select='*';
$where='phoneNo="'.$mobile.'" and primaryvalue=1 order by id desc';
$rs=GetPageRecord($select,_PHONE_MASTER_,$where);
$number= mysqli_num_rows($rs);
$resListing=mysqli_fetch_array($rs);

if ($resListing['sectionType']=='contacts'){
	$clienttype='2';
	$phoneNo=$resListing['phoneNo'];
    $masterId=$resListing['masterId'];

}
if ($resListing['sectionType']=='corporate'){
	$clienttype='1';
	$phoneNo=$resListing['phoneNo'];
    $masterId=$resListing['masterId'];
}

//get mobile pin code
$select='*';
$where='id="'.$masterId.'"';
$rs=GetPageRecord($select,_CONTACT_MASTER_,$where);
$mobilePin=mysqli_fetch_array($rs);
$otp=$mobilePin['mobilePin'];

 if($number>0){
 if($phoneNo!=''){
  $json_result.= '{
		"mobile" : "'.$phoneNo.'",
		"id" : "'.$masterId.'",
		"type" : "'.$clienttype.'",
		"otp" : "'.$otp.'"
	},';
 }}else{
      $json_result.= '{
		"error" : "Mobile number doesn’t exists"
	},';
     
 }  

?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}