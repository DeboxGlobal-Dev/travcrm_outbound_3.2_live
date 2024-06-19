<?php 
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

if($_REQUEST['register']=='submit'){

    $firstname=$_POST['firstName'];
	$lastname=$_POST['lastName'];
	$email=$_POST['email'];
	$phone=$_POST['phoneNo'];
	$sectionType='contacts';
	$type=1;
	$primaryvalue=1;
	$notapproved=1;
	$dateAdded=time();
	$mobilePin='5888';

    $res_e=GetPageRecord('*',_EMAIL_MASTER_,' email="'.$email.'"');
    $res_p=GetPageRecord('*',_PHONE_MASTER_,' phoneNo="'.$phone.'"');
    if (mysqli_num_rows($res_e) > 0) {
  	   $message="Email id exists";
  	}else if(mysqli_num_rows($res_p) > 0){
  	   $message="Mobile number exists";  
  	}else{
    $namevalue1 ='firstName="'.$firstname.'",lastName="'.$lastname.'",appRegStatus="'.$notapproved.'",dateAdded="'.$dateAdded.'",mobilePin="'.$mobilePin.'"'; 
    $lastid1 = addlistinggetlastid(_CONTACT_MASTER_,$namevalue1);
      
    $namevalue2 ='email="'.$email.'",sectionType="'.$sectionType.'",primaryvalue="'.$primaryvalue.'",masterId="'.$lastid1.'"'; 
    $lastid2 = addlistinggetlastid(_EMAIL_MASTER_,$namevalue2);
      
    $namevalue3 ='phoneNo="'.$phone.'",phoneType="'.$type.'",primaryvalue="'.$primaryvalue.'",sectionType="'.$sectionType.'",masterId="'.$lastid1.'"'; 
    $lastid3 = addlistinggetlastid(_PHONE_MASTER_,$namevalue3);
    
    $mailBodyContent='';
    $mailBodyContent.='<div style="width:100%; font-size:14px; background:#eeeeee; padding:20px 0px;">
    <div style="background-color:#fff; padding:20px 20px; width:685px; margin:20px auto; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;">
    <div style="font-size:14px;color:#4c4c4c;margin-top:20px; line-height:24px; font-family:Arial, Helvetica, sans-serif;">
    <div style="line-height: 20px; border: 1px solid #ccc; padding: 10px 14px; margin: 10px 0px 20px 0px; font-size:12px;">
    <strong>Name:</strong> '.strip($firstname).' '.strip($lastname).'<br />
    <strong>Email: </strong> '.$email.'<br />
    <strong>Phone: </strong>'.$phone.'<br />';    
    
    if($lastid1!='' && $lastid2!='' && $lastid3!=''){
    

    $rs='';
    $rs=GetPageRecord('*',_EMAIL_SETTING_MASTER_,' 1 and isDefault=1');
    $emailSettingData=mysqli_fetch_array($rs);

    $email=$emailSettingData['email']; 
    $companyName='TravCrm Mobile';
    $headers = 'From: '.$companyName.'<no_reply@deboxglobal.co.in>' . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $issueSubject="";
    $issueSubject="".$companyName."";
    $mailSent=@mail($email,stripslashes($issueSubject),$mailBodyContent,$headers);
    
      $message="Thank you registering with us, we will get back you shortly"; 
      } else {
      $message="Try Again"; 
    }
 }  	
 $json_msg = '{
		"message" : "'.$message.'"
	}'; echo $json_msg;
}
?>