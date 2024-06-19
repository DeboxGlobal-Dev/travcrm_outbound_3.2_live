<?php
include "../inc.php";
header("Content-Type: application/json");

$roleId=$_REQUEST['roleId'];

$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($roleId==1){
$driverDataq=GetPageRecord('*','tbl_guidemaster','id="'.$_REQUEST['driverId'].'" and status=1 and serviceType=2 order by id desc'); 
if(mysqli_num_rows($driverDataq)>0){
$driverData=mysqli_fetch_array($driverDataq);
$id=$driverData['id'];
$name=$driverData['name'];
if($driverData['phone']!=''){
$mobile=$driverData['phone'];
}else{
$mobile=$driverData['alternatephone'];    
}
if($driverData['panNo']!=''){
$documents=$driverData['panNo'];    
}else{
$documents=$driverData['aadharNo'];        
}
if($driverData['guideLicence']!=''){
$licenseNo=$driverData['guideLicence'];    
}
if($driverData['licenceExpiry']!=0 && $driverData['licenceExpiry']!=''){
$expirydate=date('d M Y',strtotime($driverData['licenceExpiry']));
}
$guideImage='';
if($driverData['image']!=''){
$guideImage="".$fullurl."packageimages/".$driverData['image'];
}
/*if(strtotime($expirydate)<=strtotime('-1 month')){
$expiryDate='Your License will expire in 1 month!';
}*/
$userprofile.= '{
        "id" : "'.$id.'",
		"fullName" : "'.$name.'",
		"mobile" : "'.$mobile.'",
		"document" : "'.$documents.'",
		"license" : "'.$licenseNo.'",
		"expiryDate" : "'.$expirydate.'",
		"driverImage" : "'.$guideImage.'"
},'; 
}
$profile=trim($userprofile, ',');      
}elseif($roleId==2){
    
$driverDataq=GetPageRecord('*','driverMaster','id="'.$_REQUEST['driverId'].'" and status=1 order by id desc'); 
if(mysqli_num_rows($driverDataq)>0){
$driverData=mysqli_fetch_array($driverDataq);
$id=$driverData['id'];
$name=$driverData['name'];
if($driverData['mobile']!=''){
$mobile=$driverData['mobile'];
}else{
$mobile=$driverData['alternateMobile'];    
}
if($driverData['panNo']!=''){
$documents=$driverData['panNo'];    
}else{
$documents=$driverData['aadharNo'];        
}
if($driverData['licenseNo']!=''){
$licenseNo=$driverData['licenseNo'];    
}
if($driverData['validUpto']!=0 && $driverData['validUpto']!=''){
$expirydate=date('d M Y',strtotime($driverData['validUpto']));
}
$driverImage='';
if($driverData['driverImage']!=''){
$driverImage="".$fullurl."dirfiles/".$driverData['driverImage'];
}
/*if(strtotime($expirydate)<=strtotime('-1 month')){
$expiryDate='Your License will expire in 1 month!';
}*/
$userprofile.= '{
        "id" : "'.$id.'",
		"fullName" : "'.$name.'",
		"mobile" : "'.$mobile.'",
		"document" : "'.$documents.'",
		"license" : "'.$licenseNo.'",
		"expiryDate" : "'.$expirydate.'",
		"driverImage" : "'.$driverImage.'"
},'; 
}
$profile=trim($userprofile, ',');
}elseif($roleId==3){
$driverDataq=GetPageRecord('*','tbl_guidemaster','id="'.$_REQUEST['driverId'].'" and status=1 order by id desc'); 
if(mysqli_num_rows($driverDataq)>0){
$driverData=mysqli_fetch_array($driverDataq);
$id=$driverData['id'];
$name=$driverData['name'];
if($driverData['phone']!=''){
$mobile=$driverData['phone'];
}else{
$mobile=$driverData['alternatephone'];    
}
if($driverData['panNo']!=''){
$documents=$driverData['panNo'];    
}else{
$documents=$driverData['aadharNo'];        
}
if($driverData['guideLicence']!=''){
$licenseNo=$driverData['guideLicence'];    
}
if($driverData['licenceExpiry']!=0 && $driverData['licenceExpiry']!=''){
$expirydate=date('d M Y',strtotime($driverData['licenceExpiry']));
}
$guideImage='';
if($driverData['image']!=''){
$guideImage="".$fullurl."packageimages/".$driverData['image'];
}
/*if(strtotime($expirydate)<=strtotime('-1 month')){
$expiryDate='Your License will expire in 1 month!';
}*/
$userprofile.= '{
        "id" : "'.$id.'",
		"fullName" : "'.$name.'",
		"mobile" : "'.$mobile.'",
		"document" : "'.$documents.'",
		"license" : "'.$licenseNo.'",
		"expiryDate" : "'.$expirydate.'",
		"driverImage" : "'.$guideImage.'"
},'; 
}
$profile=trim($userprofile, ',');
}

$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$profile.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>
{
		"status":"true",
		"profileData":[<?php echo trim($profile, ',');?>]
}