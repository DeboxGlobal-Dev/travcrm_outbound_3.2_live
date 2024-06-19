<?php
//check dublicate entry
function checkduplicatedata($tablename,$where){
$result =mysqli_query (db(),"select * from ".$tablename." where ".$where."")  or die(mysqli_error(db()));
$number =mysqli_num_rows($result);
if($number>0)
{
return 'yes';
} else {
return 'no';
}
}

//get page records
function GetPageRecords($select,$tablename,$where){
$sql="select ".$select." from ".$tablename." where ".$where."";
$rs=mysqli_query(db(),$sql) or die(mysqli_error(db()));
return $rs;
}

//================================================================================================================

function driverLogin($mobileNumber,$roleId){

$checkCoderef = checkduplicatedata('driverMaster','mobile="'.$mobileNumber.'"');    
if($checkCoderef=='yes'){
if($roleId==2){
$role="Driver"; 
}  
mysqli_query(db(),"UPDATE driverMaster SET onlineStatus = '1' WHERE mobile = $mobileNumber");
$driverDataq=GetPageRecords('*','driverMaster','mobile="'.$mobileNumber.'" and deletestatus=0');  
$driverData=mysqli_fetch_array($driverDataq);
$driverrows=mysqli_num_rows($driverDataq);
$driverId=$driverData['id'];
$mobile=$driverData['mobile'];
if($driverData['onlineStatus']==1){
$onlineStatus='On Duty';	
}else{
$onlineStatus='Off Duty';	
}
if($driverrows>0){
$json_driverLogin.= '{
		"userid" : "'.$driverId.'",
		"role" : "'.$role.'",
		"mobileNumber" : "'.$mobile.'",
		"onlineStatus" : "'.$onlineStatus.'"
	},';    
}else{
$json_driverLogin.= '{
		"message" : "login not allowed"
	},';      
}
}else{
$json_driverLogin.= '{
		"message" : "login not allowed"
	},';       
} 
$driverLogin=trim($json_driverLogin, ',');
$jsonmain.='{ 
    "status" : "true",
	"comment" : "JSON",
	"policy" : ['.$driverLogin.']
	
}';
echo $jsonmain;   
}

function guideLogin($mobileNumber,$roleId){
$checkCoderef = checkduplicatedata(' tbl_guidemaster','phone="'.$mobileNumber.'"');    
if($checkCoderef=='yes'){
if($roleId==3){
   $role="Guide"; 
}
mysqli_query(db(),"UPDATE tbl_guidemaster SET onlineStatus = '1' WHERE phone = $mobileNumber");    
$guideDataq=GetPageRecords('*',' tbl_guidemaster','phone="'.$mobileNumber.'" and deletestatus=0');  
$guideData=mysqli_fetch_array($guideDataq);
$guiderows=mysqli_num_rows($guideDataq);
$guideId=$guideData['id'];
$mobile=$guideData['phone'];
if($guideData['onlineStatus']==1){
$onlineStatus='On Duty';	
}else{
$onlineStatus='Off Duty';	
}
if($guiderows>0){
$json_guideLogin.= '{
		"userid" : "'.$guideId.'",
		"role" : "'.$role.'",
		"mobileNumber" : "'.$mobile.'",
		"onlineStatus" : "'.$onlineStatus.'"
	},';    
}else{
$json_guideLogin.= '{
		"message" : "login not allowed"
	},';      
}
}else{
$json_guideLogin.= '{
		"message" : "login not allowed"
	},';      
} 
$guideLogin=trim($json_guideLogin, ',');
$jsonmain.='{ 
    "status" : "true",
	"comment" : "JSON",
	"policy" : ['.$guideLogin.']
	
}';
echo $jsonmain;  
}

function tourManagerLogin($mobileNumber,$roleId){
$checkCoderef = checkduplicatedata(' tbl_guidemaster','phone="'.$mobileNumber.'" and serviceType=2');    
if($checkCoderef=='yes'){
if($roleId==1){
   $role="Tour Manager"; 
}
mysqli_query(db(),"UPDATE tbl_guidemaster SET onlineStatus = '1' WHERE phone = $mobileNumber and serviceType=2");    
$guideDataq=GetPageRecords('*',' tbl_guidemaster','phone="'.$mobileNumber.'" and deletestatus=0 and serviceType=2');  
$guideData=mysqli_fetch_array($guideDataq);
$guiderows=mysqli_num_rows($guideDataq);
$guideId=$guideData['id'];
$mobile=$guideData['phone'];
if($guideData['onlineStatus']==1){
$onlineStatus='On Duty';	
}else{
$onlineStatus='Off Duty';	
}
if($guiderows>0){
$json_guideLogin.= '{
		"userid" : "'.$guideId.'",
		"role" : "'.$role.'",
		"mobileNumber" : "'.$mobile.'",
		"onlineStatus" : "'.$onlineStatus.'"
	},';    
}else{
$json_guideLogin.= '{
		"message" : "login not allowed"
	},';      
}
}else{
$json_guideLogin.= '{
		"message" : "login not allowed"
	},';      
} 
$guideLogin=trim($json_guideLogin, ',');
$jsonmain.='{ 
    "status" : "true",
	"comment" : "JSON",
	"policy" : ['.$guideLogin.']
	
}';
echo $jsonmain;  
}
?>