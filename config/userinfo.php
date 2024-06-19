<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*'; 
$where='id="'.$_SESSION['userid'].'" and email="'.$_SESSION['username'].'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$LoginUserDetails=mysqli_fetch_array($rs); 

$fullloginusername=$LoginUserDetails['firstName'].' '.$LoginUserDetails['lastName'];
$loginuseraccountId=$LoginUserDetails['accountId'];
$loginuserprofilePhoto=$LoginUserDetails['profilePhoto'];
$loginuserID=$LoginUserDetails['id'];
$loginusersuperParentId=$LoginUserDetails['superParentId'];
$loginuserprofileId=$LoginUserDetails['profileId'];
$loginuserparentId=$LoginUserDetails['parentId'];
$loginuseradmin=$LoginUserDetails['admin'];
$loginuserstatus=$LoginUserDetails['status'];
$loginusertimeFormat=$LoginUserDetails['timeFormat'];
$loginusercurrency=$LoginUserDetails['currency'];
$loginusertimeZone=$LoginUserDetails['timeZone']; 
$emailsignature=$LoginUserDetails['emailsignature']; 
$usercompanyId=$LoginUserDetails['companyId'];

$loginUserType=$LoginUserDetails['userType'];
$loginUserScope=$LoginUserDetails['userLoginType'];

$uSession=$LoginUserDetails['uSession'];

 
$select='timeZone,status,expiryDate,company,noofusers'; 
$where='id="'.$loginusersuperParentId.'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$Logintimeuserzone=mysqli_fetch_array($rs); 

$LoginUserProfileQuery='';
$LoginUserProfileQuery=GetPageRecord('*',_PROFILE_MASTER_," 1 and id='".$loginuserprofileId."'");
$LoginUserProfileData=mysqli_fetch_array($LoginUserProfileQuery);


$select='zonetxt'; 
$where='id="'.$Logintimeuserzone['timeZone'].'"'; 
$rs=GetPageRecord($select,_TIMEZONE_MASTER_,$where); 
$LoginTimezone=mysqli_fetch_array($rs); 

date_default_timezone_set($LoginTimezone['zonetxt']);


if($loginuserstatus!=1){
header('location:logout.crm');
exit();
}


if($_SESSION['uSession']!=$uSession){
?>
<!--<script>
alert('Your session has timed out.');
window.location.href="logout.crm";
</script>
-->

<?php
 
//exit();
}


  
if($Logintimeuserzone['status']!=1){
	header('location:logout.crm');
	exit();
}

$loginexpirydateuser=$Logintimeuserzone['expiryDate'];


 

$now = time(); 
$your_date = strtotime($Logintimeuserzone['expiryDate']);
$datediff = $now - $your_date; 
$userRemainingDays = floor($datediff / (60 * 60 * 24));
$userRemainingDays = str_replace("-","",$userRemainingDays);

if($loginexpirydateuser<date('Y-m-d')){
header('location:expired.crm');
exit();
}




function showdate($datestring){ 
if($datestring!='0000-00-00'){
return date("d-m-Y", strtotime($datestring));  
} else {
return '-';
}
}
 

function showdatetimenormal($datestring,$timefor){ 
if($timefor==1){
return date("d-m-Y H:i A", $datestring); 
} 

if($timefor==2){
return date("d-m-Y H:i:s", $datestring); 
} 
}

function showdatenormal($datestring){  
return date("d-m-Y", $datestring);   
}
 
function showdatetime($datestring,$timefor){
if($timefor==1){
return date("j F, Y - h:i:s A", $datestring); 
}
}
function showdatetimeYMD($datestring,$timefor){
if($timefor==1){
return date("d-m-Y", $datestring); 
}
}

if($timefor==2){
return date("j F, Y - H:i:s", $datestring); 
}




// $select333='name'; 
// $where333='id="'.$loginusersuperParentId.'"'; 
// $rs333=GetPageRecord($select333,_CURRENCY_MASTER_,$where333); 
// $courrencyNameIcon=mysqli_fetch_array($rs333);



$select=''; 
$where=''; 
$rs='';  
$select='sessionTime'; 
$where='id="'.$loginusersuperParentId.'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$sessionTimeName=mysqli_fetch_array($rs);  





?>
 