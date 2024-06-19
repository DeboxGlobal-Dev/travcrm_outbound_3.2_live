<?php  
$multiloginuserDataq=GetPageRecord('uSession,email','userMaster','1 and id="'.$_SESSION['userid'].'"'); 
$multiloginuserData=mysqli_fetch_array($multiloginuserDataq); 
if($_SESSION['uSession']!=$multiloginuserData['uSession'] && $_SESSION['username']!=$multiloginuserData['email'] && isset($_SESSION['username'])){  
	$message = "This account has opened in another browser.";
	echo "<script type='text/javascript'>alert('$message');</script>"; 
	unset($_SESSION['sessionid']); 
	unset($_SESSION['username']); 
	unset($_SESSION['otpsession']);
	unset($_SESSION['userid']);
	unset($_SESSION['companymastersettingsId']);
	$_SESSION['sessionid']=''; 
	$_SESSION['username']=''; 
	$_SESSION['otpsession']='';
	$_SESSION['userid']='';
	$_SESSION['companymastersettingsId']='';
	session_destroy();
	echo "<a href='$fullurl' style='width: 20%; color: #ffffff; margin: 3% auto; display: block; text-align: center; background-color: #2196f3; padding: 10px; text-decoration: none; font-size: 15px; font-family: arial; border-radius: 4px;'>Back to login</a>"; 
	exit;  
}  
if($_SESSION['username']=="" || $_SESSION['sessionid']!=session_id() || $_SESSION['userid']=="" || $_SESSION['uSession']=="" || $_SESSION['otpvar']==""){ 
	header("Location:login.crm");
	exit(); 
    
} 
include "config/userinfo.php";
?>