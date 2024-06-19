<?php

$json = "";

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch='';
$useractiveinactiveuser='';
$limit=clean($_GET['records']);
if($useractiveinactiveuser==''){
 $useractiveinactiveuser=1;
 echo "okk";
exit;
}

if($_GET['useractiveinactiveuser']!=''){ 
$useractiveinactiveuser=$_GET['useractiveinactiveuser'];
}
if($useractiveinactiveuser==0 || $useractiveinactiveuser==1){
$wheresearch=' and status='.$useractiveinactiveuser.'';
}

if($useractiveinactiveuser==2){
$wheresearch=' and deletestatus=1';
}

 else {
$wheresearch=' and status=1';
}


 
$where='where admin!=1 and superParentId='.$loginusersuperParentId.' and id!='.$loginuserID.' '.$wheresearch.'   order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'setupsetting.crm?module=users&records='.$limit.'&useractiveinactiveuser='.$useractiveinactiveuser.'&'; 
$rs=GetRecordList($select,_USER_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2];
 
while($resultlists=mysqli_fetch_array($rs[0])){ 
    $fullName = $resultlists['firstName'].' '.$resultlists['lastName'];
	$email=$resultlists['email'];
	 
	$select1='name';  
	$where1='id="'.$resultlists['roleId'].'"'; 
	$rs1=GetPageRecord($select1,_ROLE_MASTER_,$where1); 
	$res=mysqli_fetch_array($rs1);
	$role = strip($res['name']); 

	$select1='profileName';  
	$where1='id="'.$resultlists['profileId'].'"'; 
	$rs1=GetPageRecord($select1,_PROFILE_MASTER_,$where1); 
	$res=mysqli_fetch_array($rs1);
	$profilename = strip($res['profileName']); 
	
	if($resultlists['status']==1){
		$status = "Active";
	}else{
		$status = "Inactive";
	}
	// json encode
	$json.= '{
		"fullName":"'.$fullName.'",
		"email":"'.$email.'",
		"role":"'.$role.'",
		"profilename":"'.$profilename.'",
		"status":"'.$status.'"
},';}  

?>{"status":"ok","totalResults":10,"articles":[<?php echo trim($json, ',')?>]}				

