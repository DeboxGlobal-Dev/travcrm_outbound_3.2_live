<?php 
//include "../inc.php";
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

if($_REQUEST['refer']=='submit'){
        
    $referralName=$_POST['referralName'];
	$relation=$_POST['relation'];
	$city=$_POST['city'];
	$phone=$_POST['phoneNo'];
	$merritalStatus=$_POST['merritalStatus'];
	$profession=$_POST['profession'];
	$email=$_POST['email'];
        
    $mailBodyContent='';
    $mailBodyContent.='<div style="width:100%; font-size:14px; background:#eeeeee; padding:20px 0px;">
    <div style="background-color:#fff; padding:20px 20px; width:685px; margin:20px auto; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;">
    <div style="font-size:14px;color:#4c4c4c;margin-top:20px; line-height:24px; font-family:Arial, Helvetica, sans-serif;">
    <div style="line-height: 20px; border: 1px solid #ccc; padding: 10px 14px; margin: 10px 0px 20px 0px; font-size:12px;">
    <strong>Referral Name:</strong> '.strip($referralName).'<br />
    <strong>Relation: </strong> '.$relation.'<br />
    <strong>Phone: </strong>'.$phone.'<br />
    <strong>Email: </strong> '.$email.'<br />
    <strong>City: </strong> '.$profession.'<br />
    <strong>Profession: </strong> '.$city.'<br />';    
     $rs='';
    $rs=GetPageRecord('*',_EMAIL_SETTING_MASTER_,' 1 and isDefault=1');
    $emailSettingData=mysqli_fetch_array($rs);
    $email=$emailSettingData['email']; 

    $companyName='TravCrm Mobile'; 
    $headers = 'From: '.$companyName.'<info@travcrm.in>' . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $issueSubject="";
    $issueSubject="Refer and Earn";
    $mailSent=@mail($email,stripslashes($issueSubject),$mailBodyContent,$headers);
    $message='success';
}else{
    $message='some error! please try again';
}
$json_msg = '{
		"message" : "'.$message.'"
	}'; echo $json_msg;
?>