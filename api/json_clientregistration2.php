<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

if(isset($_POST['submit'])){

    $firstname=$_POST['firstName'];
	$lastname=$_POST['lastName'];
	$address1=$_POST['address1'];
	$dob=$_POST['birthDate'];
	$email=$_POST['email'];
	$phone=$_POST['phoneNo'];
	$sectionType='contacts';
	$type=1;
	$primaryvalue=1;
	
	
$namevalue1 ='firstName="'.$firstname.'",lastName="'.$lastname.'",address1="'.$address1.'",birthDate="'.$dob.'"'; 
$lastid1 = addlistinggetlastid(_CONTACT_MASTER_,$namevalue1);
  
$namevalue2 ='email="'.$email.'",sectionType="'.$sectionType.'",primaryvalue="'.$primaryvalue.'"'; 
$lastid2 = addlistinggetlastid(_EMAIL_MASTER_,$namevalue2);
  
$namevalue3 ='phoneNo="'.$phone.'",phoneType="'.$type.'",primaryvalue="'.$primaryvalue.'",sectionType="'.$sectionType.'"'; 
$lastid3 = addlistinggetlastid(_PHONE_MASTER_,$namevalue3);
  
if($lastid1!='' && $lastid2!='' && $lastid3!=''){ 
 echo json_encode("New record created successfully");
  } else {
    echo json_encode("Some error!Try Again");
}  
}

?>