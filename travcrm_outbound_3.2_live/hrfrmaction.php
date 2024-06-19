<?php
ob_start();
 
include "inc.php";
include "config/logincheck.php";  
ini_set('post_max_size', '10M');
ini_set('upload_max_filesize', '10M');
if(trim($_REQUEST['action'])!='profilepermission'){
?> 
 <script src="js/jquery-1.11.3.min.js"></script>   
<?php
}

/*==============================================================================Add Employee  Management=========================================================================================*/
if(trim($_POST['action'])=='addemployee' && trim($_POST['editId'])=='' && trim($_POST['name'])!=''){

$empId=clean($_POST['empId']);
$name=clean($_POST['name']);
$email=clean($_POST['email']);

$rand = md5(rand('123456', '888888'));
$rand_password = $rand;
$password  =  $_POST['password'];
$password = $rand_password;

$mobile=clean($_POST['mobile']);
$gender=clean($_POST['gender']);
$maritalStatus=clean($_POST['maritalStatus']);
$birthDate=date("Y-m-d", strtotime($_POST['birthDate']));
$address=clean($_POST['address']);
$permanentAddress=clean($_POST['permanentAddress']);
$departmentId=clean($_POST['departmentId']);
$uan=clean($_POST['uan']); 
$pf=clean($_POST['pf']); 
$aadhar=clean($_POST['aadhar']); 
$currentDesignation=clean($_POST['currentDesignation']);
$roleId=clean($_POST['roleId']);
$profileId=clean($_POST['profileId']);
$pan=clean($_POST['pan']); 
$esi=clean($_POST['esi']); 
$empStatus=clean($_POST['empStatus']); 
$city=clean($_POST['city']); 
$reportingTo=clean($_POST['reportingTo']); 
$employeeType=clean($_POST['employeeType']); 
$joiningDate=date("Y-m-d", strtotime($_POST['joiningDate']));
$empHireSource=clean($_POST['empHireSource']); 
$employeeShift=clean($_POST['employeeShift']); 
$empVerification=clean($_POST['empVerification']); 

$accNumber=clean($_POST['accNumber']); 
$accHolderName=clean($_POST['accHolderName']); 
$bankName=clean($_POST['bankName']); 
$ifscCode=clean($_POST['ifscCode']); 
$companyName=clean($_POST['companyName']); 
$designation=clean($_POST['designation']); 
$joiningFrom=date("Y-m-d", strtotime($_POST['joiningFrom']));
$joiningTo=date("Y-m-d", strtotime($_POST['joiningTo']));
$jobDesc=clean($_POST['jobDesc']); 

$contactName=clean($_POST['contactName']);
$contactNumber=clean($_POST['contactNumber']);
$contactRelation=clean($_POST['contactRelation']);
$contactBloodG=clean($_POST['contactBloodG']);
$contactAddress=clean($_POST['contactAddress']);

$dateAdded=time();

$namevalue ='empId="'.$empId.'",name="'.$name.'",email="'.$email.'",password="'.$password.'",mobile="'.$mobile.'",gender="'.$gender.'",maritalStatus="'.$maritalStatus.'",birthDate="'.$birthDate.'",address="'.$address.'",permanentAddress="'.$permanentAddress.'",departmentId="'.$departmentId.'",uan="'.$uan.'",pf="'.$pf.'",aadhar="'.$aadhar.'",currentDesignation="'.$currentDesignation.'",roleId="'.$roleId.'",profileId="'.$profileId.'",pan="'.$pan.'",esi="'.$esi.'",empStatus="'.$empStatus.'",city="'.$city.'",reportingTo="'.$reportingTo.'",employeeType="'.$employeeType.'",joiningDate="'.$joiningDate.'",empHireSource="'.$empHireSource.'",employeeShift="'.$employeeShift.'",empVerification="'.$empVerification.'",accNumber="'.$accNumber.'",accHolderName="'.$accHolderName.'",bankName="'.$bankName.'",ifscCode="'.$ifscCode.'",companyName="'.$companyName.'",designation="'.$designation.'",joiningFrom="'.$joiningFrom.'",joiningTo="'.$joiningTo.'",jobDesc="'.$jobDesc.'",contactName="'.$contactName.'",contactNumber="'.$contactNumber.'",contactRelation="'.$contactRelation.'",contactBloodG="'.$contactBloodG.'",contactAddress="'.$contactAddress.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';

/*$namevalue ='firstName="'.$name.'",email="'.$email.'",password="'.$password.'",mobile="'.$mobile.'",roleId="'.$roleId.'",profileId="'.$profileId.'",city="'.$city.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'",empId="'.$lastid.'"';
$lastid = addlistinggetlastid(_USER_MASTER_,$namevalue);*/
	
//$adds = addlisting(_EMPLOYEE_MANAGEMENT_MASTER_,$namevalue);
$adds = addlistinggetlastid(_EMPLOYEE_MANAGEMENT_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=employeesalaryinfo&lastId=<?php echo encode($adds); ?>');
</script> 
<?php
}
if(trim($_POST['action'])=='addemployee' && trim($_POST['editId'])!='' && trim($_POST['name'])!=''){

$empId=clean($_POST['empId']);
$name=clean($_POST['name']);
$email=clean($_POST['email']);

$rand = md5(rand('123456', '888888'));
$rand_password = $rand;
$password  =  $_POST['password'];
$password = $rand_password;

$mobile=clean($_POST['mobile']);
$gender=clean($_POST['gender']);
$maritalStatus=clean($_POST['maritalStatus']);
$birthDate=date("Y-m-d", strtotime($_POST['birthDate']));
$address=clean($_POST['address']);
$permanentAddress=clean($_POST['permanentAddress']);
$departmentId=clean($_POST['departmentId']);
$uan=clean($_POST['uan']); 
$pf=clean($_POST['pf']); 
$aadhar=clean($_POST['aadhar']); 
$currentDesignation=clean($_POST['currentDesignation']);
$roleId=clean($_POST['roleId']);
$profileId=clean($_POST['profileId']);
$pan=clean($_POST['pan']); 
$esi=clean($_POST['esi']); 
$empStatus=clean($_POST['empStatus']); 
$city=clean($_POST['city']); 
$reportingTo=clean($_POST['reportingTo']); 
$employeeType=clean($_POST['employeeType']); 
$joiningDate=date("Y-m-d", strtotime($_POST['joiningDate']));
$empHireSource=clean($_POST['empHireSource']); 
$employeeShift=clean($_POST['employeeShift']); 
$empVerification=clean($_POST['empVerification']); 

$accNumber=clean($_POST['accNumber']); 
$accHolderName=clean($_POST['accHolderName']); 
$bankName=clean($_POST['bankName']); 
$ifscCode=clean($_POST['ifscCode']); 
$companyName=clean($_POST['companyName']); 
$designation=clean($_POST['designation']); 
$joiningFrom=date("Y-m-d", strtotime($_POST['joiningFrom']));
$joiningTo=date("Y-m-d", strtotime($_POST['joiningTo']));
$jobDesc=clean($_POST['jobDesc']); 

$contactName=clean($_POST['contactName']);
$contactNumber=clean($_POST['contactNumber']);
$contactRelation=clean($_POST['contactRelation']);
$contactBloodG=clean($_POST['contactBloodG']);
$contactAddress=clean($_POST['contactAddress']);

$dateAdded=time();
$editId=clean($_POST['editId']); 

$namevalue ='empId="'.$empId.'",name="'.$name.'",email="'.$email.'",password="'.$password.'",mobile="'.$mobile.'",gender="'.$gender.'",maritalStatus="'.$maritalStatus.'",birthDate="'.$birthDate.'",address="'.$address.'",permanentAddress="'.$permanentAddress.'",departmentId="'.$departmentId.'",uan="'.$uan.'",pf="'.$pf.'",aadhar="'.$aadhar.'",currentDesignation="'.$currentDesignation.'",roleId="'.$roleId.'",profileId="'.$profileId.'",pan="'.$pan.'",esi="'.$esi.'",empStatus="'.$empStatus.'",city="'.$city.'",reportingTo="'.$reportingTo.'",employeeType="'.$employeeType.'",joiningDate="'.$joiningDate.'",empHireSource="'.$empHireSource.'",employeeShift="'.$employeeShift.'",empVerification="'.$empVerification.'",accNumber="'.$accNumber.'",accHolderName="'.$accHolderName.'",bankName="'.$bankName.'",ifscCode="'.$ifscCode.'",companyName="'.$companyName.'",designation="'.$designation.'",joiningFrom="'.$joiningFrom.'",joiningTo="'.$joiningTo.'",jobDesc="'.$jobDesc.'",contactName="'.$contactName.'",contactNumber="'.$contactNumber.'",contactRelation="'.$contactRelation.'",contactBloodG="'.$contactBloodG.'",contactAddress="'.$contactAddress.'",addedBy="'.$_SESSION['userid'].'"';

$where='id='.$_POST['editId'].'';
$update = updatelisting(_EMPLOYEE_MANAGEMENT_MASTER_,$namevalue,$where);

?>
<script>
parent.setupbox('showpage.crm?module=employeemanagement&alt=2');
</script> 
<?php 
 }	
if(trim($_POST['action'])=='addedit_leaveconfiguration' && trim($_POST['editId'])=='' && trim($_POST['name'])!=''){

$name=clean($_POST['name']);
$leaveSelected=clean($_POST['leaveSelected']);
$city=clean($_POST['city']); 
$departmentId=clean($_POST['departmentId']);
$designation=clean($_POST['designation']); 
$paybale=clean($_POST['paybale']);
$emailNotify=clean($_POST['emailNotify']);
$type=clean($_POST['type']);
$maxTime=clean($_POST['maxTime']);
$minTime=clean($_POST['minTime']);
$count=clean($_POST['count']);
$carryForword=clean($_POST['carryForword']);
$carryUpto=clean($_POST['carryUpto']);

$dateAdded=time();

$namevalue ='name="'.$name.'",leaveSelected="'.$leaveSelected.'",departmentId="'.$departmentId.'",city="'.$city.'",designation="'.$designation.'",paybale="'.$paybale.'",emailNotify="'.$emailNotify.'",type="'.$type.'",maxTime="'.$maxTime.'",minTime="'.$minTime.'",count="'.$count.'",carryForword="'.$carryForword.'",carryUpto="'.$carryUpto.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"'; 

$adds = addlisting(_LEAVE_CONFIGURATION_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=leaveconfiguration&alt=1');
</script> 
<?php
}

if(trim($_POST['action'])=='addedit_leaveconfiguration' && trim($_POST['editId'])!='' && trim($_POST['name'])!=''){

$name=clean($_POST['name']);
$leaveSelected=clean($_POST['leaveSelected']);
$city=clean($_POST['city']); 
$departmentId=clean($_POST['departmentId']);
$designation=clean($_POST['designation']); 
$paybale=clean($_POST['paybale']);
$emailNotify=clean($_POST['emailNotify']);
$type=clean($_POST['type']);
$maxTime=clean($_POST['maxTime']);
$minTime=clean($_POST['minTime']);
$count=clean($_POST['count']);
$carryForword=clean($_POST['carryForword']);
$carryUpto=clean($_POST['carryUpto']);

$dateAdded=time();

$editId=clean($_POST['editId']); 

$namevalue ='name="'.$name.'",leaveSelected="'.$leaveSelected.'",departmentId="'.$departmentId.'",city="'.$city.'",designation="'.$designation.'",paybale="'.$paybale.'",emailNotify="'.$emailNotify.'",type="'.$type.'",maxTime="'.$maxTime.'",minTime="'.$minTime.'",count="'.$count.'",carryForword="'.$carryForword.'",carryUpto="'.$carryUpto.'",addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"'; 

$where='id='.$_POST['editId'].''; 
$update = updatelisting(_LEAVE_CONFIGURATION_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=leaveconfiguration&alt=2');
</script> 
<?php }

if(trim($_POST['action'])=='addedit_holidayconfiguration' && trim($_POST['editId'])=='' && trim($_POST['name'])!=''){

$name=clean($_POST['name']);
$holidaySelected=clean($_POST['holidaySelected']);
$city=clean($_POST['city']); 
$departmentId=clean($_POST['departmentId']);
$designation=clean($_POST['designation']); 
$emailNotify=clean($_POST['emailNotify']);
$holidayType=clean($_POST['holidayType']);
$holidayDate=date("Y-m-d", strtotime($_POST['holidayDate']));
$holidayYear=clean($_POST['holidayYear']);

$dateAdded=time();

$namevalue ='name="'.$name.'",holidaySelected="'.$holidaySelected.'",departmentId="'.$departmentId.'",city="'.$city.'",designation="'.$designation.'",emailNotify="'.$emailNotify.'",holidayType="'.$holidayType.'",holidayDate="'.$holidayDate.'",holidayYear="'.$holidayYear.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"'; 

$adds = addlisting(_HOLIDAY_CONFIGURATION_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=holidayconfiguration&alt=1');
</script> 
<?php
}

if(trim($_POST['action'])=='addedit_holidayconfiguration' && trim($_POST['editId'])!='' && trim($_POST['name'])!=''){

$name=clean($_POST['name']);
$holidaySelected=clean($_POST['holidaySelected']);
$city=clean($_POST['city']); 
$departmentId=clean($_POST['departmentId']);
$designation=clean($_POST['designation']); 
$emailNotify=clean($_POST['emailNotify']);
$holidayType=clean($_POST['holidayType']);
$holidayDate=date("Y-m-d", strtotime($_POST['holidayDate']));
$holidayYear=clean($_POST['holidayYear']);

$dateAdded=time();

$editId=clean($_POST['editId']); 

$namevalue ='name="'.$name.'",holidaySelected="'.$holidaySelected.'",departmentId="'.$departmentId.'",city="'.$city.'",designation="'.$designation.'",emailNotify="'.$emailNotify.'",holidayType="'.$holidayType.'",holidayDate="'.$holidayDate.'",holidayYear="'.$holidayYear.'",addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';

$where='id='.$_POST['editId'].''; 
$update = updatelisting(_HOLIDAY_CONFIGURATION_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=holidayconfiguration&alt=2');
</script> 
<?php }

if(trim($_POST['action'])=='addedit_assetcategorymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$namevalue ='name="'.$name.'"';
$adds = addlisting(_ASSET_CATEGORY_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_assetcategorymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'"';  
$update = updatelisting(_ASSET_CATEGORY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }


if(trim($_POST['action'])=='addedit_assettypemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$namevalue ='name="'.$name.'"';
$adds = addlisting(_ASSET_TYPE_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_assettypemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'"';  
$update = updatelisting(_ASSET_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }


if(trim($_POST['action'])=='addedit_assetmanagement' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$assetId=clean($_POST['assetId']);  
$assetCategory=clean($_POST['assetCategory']);  
$assetType=clean($_POST['assetType']);  
$city=clean($_POST['city']); 
$departmentId=clean($_POST['departmentId']);
$assetStatus=clean($_POST['assetStatus']);
$discription=clean($_POST['discription']);
 
$dateAdded=time();

$namevalue ='name="'.$name.'",assetId="'.$assetId.'",assetCategory="'.$assetCategory.'",assetType="'.$assetType.'",city="'.$city.'",departmentId="'.$departmentId.'",assetStatus="'.$assetStatus.'",discription="'.$discription.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
$adds = addlisting(_ASSET_MANAGEMENT_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_assetmanagement' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 

$name=clean($_POST['name']); 
$assetId=clean($_POST['assetId']);  
$assetCategory=clean($_POST['assetCategory']);  
$assetType=clean($_POST['assetType']);  
$city=clean($_POST['city']); 
$departmentId=clean($_POST['departmentId']);
$assetStatus=clean($_POST['assetStatus']);
$discription=clean($_POST['discription']);
$dateAdded=time();
$editId=clean($_POST['editId']); 

$where='id='.$_POST['editId'].''; 

$namevalue ='name="'.$name.'",assetId="'.$assetId.'",assetCategory="'.$assetCategory.'",assetType="'.$assetType.'",city="'.$city.'",departmentId="'.$departmentId.'",assetStatus="'.$assetStatus.'",discription="'.$discription.'",addedBy="'.$_SESSION['userid'].'"';
 
$update = updatelisting(_ASSET_MANAGEMENT_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }


if(trim($_POST['action'])=='addedit_assetreport' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$departmentId=clean($_POST['departmentId']);
$designation=clean($_POST['designation']);
$city=clean($_POST['city']); 
$assetCategory=clean($_POST['assetCategory']);  
$assetStatus=clean($_POST['assetStatus']);
$dateFrom=date("Y-m-d", strtotime($_POST['dateFrom']));
$dateTo=date("Y-m-d", strtotime($_POST['dateTo']));
 
$dateAdded=time();

$namevalue ='name="'.$name.'",departmentId="'.$departmentId.'",designation="'.$designation.'",city="'.$city.'",assetCategory="'.$assetCategory.'",assetStatus="'.$assetStatus.'",dateFrom="'.$dateFrom.'",dateTo="'.$dateTo.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
$adds = addlisting(_ASSET_CONFIGURE_REPORT_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_assetreport' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 

$name=clean($_POST['name']);  
$departmentId=clean($_POST['departmentId']);
$designation=clean($_POST['designation']);
$city=clean($_POST['city']); 
$assetCategory=clean($_POST['assetCategory']);  
$assetStatus=clean($_POST['assetStatus']);
$dateFrom=date("Y-m-d", strtotime($_POST['dateFrom']));
$dateTo=date("Y-m-d", strtotime($_POST['dateTo']));
$editId=clean($_POST['editId']); 

$dateAdded=time();

$where='id='.$_POST['editId'].''; 

$namevalue ='name="'.$name.'",departmentId="'.$departmentId.'",designation="'.$designation.'",city="'.$city.'",assetCategory="'.$assetCategory.'",assetStatus="'.$assetStatus.'",dateFrom="'.$dateFrom.'",dateTo="'.$dateTo.'",addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';
 
$update = updatelisting(_ASSET_CONFIGURE_REPORT_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }


if(trim($_POST['action'])=='addedit_hrmsdocumentcategory' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$namevalue ='name="'.$name.'"';
$adds = addlisting(_DOCUMENT_CATEGORY_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_hrmsdocumentcategory' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'"';  
$update = updatelisting(_DOCUMENT_CATEGORY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }

if($_POST['action']=='uploaddocument' && $_POST['parentId']!=''){
$parentId=$_REQUEST['parentId'];
$time=time();

if(!empty($_FILES['documentname']['name'])){  
$file_name=$time.'-'.$_FILES['documentname']['name'];  
copy($_FILES['documentname']['tmp_name'],"dirfiles/hrms_files/".$file_name); 

$namevalue ='name="'.$file_name.'",parentId="'.$parentId.'"'; 
$add = addlisting(_HRMS_DOCUMENT_MASTER_,$namevalue);

}
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&view=yes&id=<?php echo encode($parentId); ?>');
</script>
<?php
}

if($_REQUEST['action']=='removepicture' && $_REQUEST['did']!='' && $_REQUEST['parentId']!='' ){   
$parentId=$_REQUEST['parentId'];
$module = $_REQUEST['module'];
$did=$_REQUEST['did'];  
$sql_del="delete from "._HRMS_DOCUMENT_MASTER_."  where parentId='".$parentId."' and id='".$did."' "; 
mysqli_query($sql_del) or die(mysqli_error(db()));
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $module; ?>&view=yes&id=<?php echo encode($parentId); ?>');
</script>
<?php

}

if(trim($_POST['action'])=='addedit_hrmscompanyfile' && trim($_POST['editId'])=='' && trim($_POST['documentCategory'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$documentCategory=clean($_POST['documentCategory']);  
$departmentId=clean($_POST['departmentId']);
$city=clean($_POST['city']); 
$discription=clean($_POST['discription']); 
$validUntill=date("Y-m-d", strtotime($_POST['validUntill']));
$fileType = clean($_POST['fileType']); 
 
$dateAdded=time();

$namevalue ='name="'.$name.'",documentCategory="'.$documentCategory.'",departmentId="'.$departmentId.'",city="'.$city.'",validUntill="'.$validUntill.'",discription="'.$discription.'",fileType="'.$fileType.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
$adds = addlisting(_HRMS_FILE_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_hrmscompanyfile' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$documentCategory=clean($_POST['documentCategory']);  
$departmentId=clean($_POST['departmentId']);
$city=clean($_POST['city']); 
$discription=clean($_POST['discription']); 
$validUntill=date("Y-m-d", strtotime($_POST['validUntill']));
$city=clean($_POST['city']); 
$fileType = clean($_POST['fileType']);

$dateAdded=time();

$where='id='.$_POST['editId'].''; 

$namevalue ='name="'.$name.'",documentCategory="'.$documentCategory.'",departmentId="'.$departmentId.'",city="'.$city.'",validUntill="'.$validUntill.'",discription="'.$discription.'",fileType="'.$fileType.'",addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';
 
$update = updatelisting(_HRMS_FILE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }


if(trim($_POST['action'])=='addedit_hrmsemployeefile' && trim($_POST['editId'])=='' && trim($_POST['documentCategory'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$empName=clean($_POST['empName']); 
$documentCategory=clean($_POST['documentCategory']);  
$discription=clean($_POST['discription']);
$fileType = clean($_POST['fileType']); 
 
$dateAdded=time();

$namevalue ='name="'.$name.'",empName="'.$empName.'",documentCategory="'.$documentCategory.'",discription="'.$discription.'",fileType="'.$fileType.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
$adds = addlisting(_HRMS_FILE_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_hrmsemployeefile' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$empName=clean($_POST['empName']); 
$documentCategory=clean($_POST['documentCategory']);  
$discription=clean($_POST['discription']);
$fileType = clean($_POST['fileType']); 

$dateAdded=time();

$where='id='.$_POST['editId'].''; 

$namevalue ='name="'.$name.'",empName="'.$empName.'",documentCategory="'.$documentCategory.'",discription="'.$discription.'",fileType="'.$fileType.'",addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';
 
$update = updatelisting(_HRMS_FILE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_hrmsfilereport' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$departmentId=clean($_POST['departmentId']);
$city=clean($_POST['city']); 
$documentCategory=clean($_POST['documentCategory']);  
$fileType = clean($_POST['fileType']); 
$dateFrom=date("Y-m-d", strtotime($_POST['dateFrom']));
$validUntill=date("Y-m-d", strtotime($_POST['validUntill']));
 
$dateAdded=time();

$namevalue ='name="'.$name.'",departmentId="'.$departmentId.'",documentCategory="'.$documentCategory.'",city="'.$city.'",fileType="'.$fileType.'",dateFrom="'.$dateFrom.'",validUntill="'.$validUntill.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
$adds = addlisting(_HRMS_FILE_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_hrmsfilereport' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 

$name=clean($_POST['name']);  
$departmentId=clean($_POST['departmentId']);
$city=clean($_POST['city']); 
$documentCategory=clean($_POST['documentCategory']);  
$fileType = clean($_POST['fileType']); 
$dateFrom=date("Y-m-d", strtotime($_POST['dateFrom']));
$validUntill=date("Y-m-d", strtotime($_POST['validUntill']));

$editId=clean($_POST['editId']); 
$dateAdded=time();

$where='id='.$_POST['editId'].''; 

$namevalue ='name="'.$name.'",departmentId="'.$departmentId.'",documentCategory="'.$documentCategory.'",city="'.$city.'",fileType="'.$fileType.'",dateFrom="'.$dateFrom.'",validUntill="'.$validUntill.'",addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';
 
$update = updatelisting(_HRMS_FILE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_hrmshrfile' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$documentCategory=clean($_POST['documentCategory']);  
$fileType = clean($_POST['fileType']); 
$permissionView = clean($_POST['permissionView']); 
$employee=clean($_POST['employee']);
$designation=clean($_POST['designation']);
$discription=clean($_POST['discription']); 
$shareManager=clean($_POST['shareManager']); 
 
$dateAdded=time();

$namevalue ='name="'.$name.'",documentCategory="'.$documentCategory.'",fileType="'.$fileType.'",dateFrom="'.$dateFrom.'",permissionView="'.$permissionView.'",employee="'.$employee.'",shareManager="'.$shareManager.'",designation="'.$designation.'",discription="'.$discription.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
$adds = addlisting(_HRMS_FILE_MASTER_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_hrmshrfile' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 

$name=clean($_POST['name']);  
$documentCategory=clean($_POST['documentCategory']);  
$fileType = clean($_POST['fileType']); 
$permissionView = clean($_POST['permissionView']); 
$employee=clean($_POST['employee']);
$designation=clean($_POST['designation']);
$discription=clean($_POST['discription']); 
$shareManager=clean($_POST['shareManager']); 

$editId=clean($_POST['editId']); 
$dateAdded=time();

$where='id='.$_POST['editId'].''; 

$namevalue ='name="'.$name.'",documentCategory="'.$documentCategory.'",fileType="'.$fileType.'",dateFrom="'.$dateFrom.'",permissionView="'.$permissionView.'",employee="'.$employee.'",shareManager="'.$shareManager.'",designation="'.$designation.'",discription="'.$discription.'",addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';
 
$update = updatelisting(_HRMS_FILE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }

if($_FILES['importfield']['name']!='' && trim($_POST['importsupplierexcel'])=='Y'){
require_once 'reader.php';
$importpackagesightseeingModule = $_REQUEST['importpackagesightseeingModule'];   ///// GET MODULE -------------------------------------
$duplicaterecored.='';
if(!empty($_FILES['importfield']['name'])){
$file_name=$_FILES['importfield']['name'];
copy($_FILES['importfield']['tmp_name'],"dirfiles/hrms_files/".$file_name); 
$line=1;
$errorReport='';
$errorCount=1;
$errorReportHeader='<div><strong>Line No.</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Error Report</strong></div><br>';    ///// GET ERROR -------------------------------------
 
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');
$path="dirfiles/hrms_files/".$file_name; 
$data->read($path);
for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
$showErrorName.='';
$showErrorType='';   ///// EMPTY VARIABLE  -------------------------------------
$empId = trim($data->sheets[0]["cells"][$x][1]);
$currentDate = trim($data->sheets[0]["cells"][$x][2]);
$timeFrom = trim($data->sheets[0]["cells"][$x][3]);
$timeTo = trim($data->sheets[0]["cells"][$x][4]);
$dateAdded=time();	


$currentDate=date("Y-m-d", strtotime($currentDate));
$where='currentDate="'.$currentDate.'" and empId="'.$empId.'" and deletestatus=0';
$addnewyes = checkduplicate(_ATTANDANCE_MASTER_,$where);
///// VALIDATE -------------------------------------
if($addnewyes=='yes' || $currentDate==''){ 
	if($addnewyes=='yes'){ $showErrorName.= $currentDate.' is Already Exists,'; }
	
$duplicaterecored.='<div>'.$line.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error in&nbsp;'.$showErrorName.'&nbsp;&nbsp;&nbsp;'.$showErrorType.'</div>'; 
$errorCount++;
}$line++;
 
if($currentDate!='' && $addnewyes=='no'){  

/*$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
$array = explode(',', $string); //split string into array seperated by ', '
foreach($array as $value) //loop over values
{
$myArray=$value;  
}*/

$namevalue ='empId="'.$empId.'",currentDate="'.$currentDate.'",timeFrom="'.$timeFrom.'",timeTo="'.$timeTo.'",dateAdded="'.$dateAdded.'"';
$lastid = addlistinggetlastid(_ATTANDANCE_MASTER_,$namevalue);	
}
 ///// COUNT LINE -------------------------------------
}
	
}
 ?>
<script>
parent.$('#importfield').remove();
parent.$('#filefieldhere').append('<input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" />');
<?php if($duplicaterecored!=''){ ?>
parent.alertspopupopen('action=foundduplicaterecored&pagename=attendanceregularize&moduleName=<?php echo $importpackagesightseeingModule; ?>&errorCount=<?php echo $errorCount; ?>','600px','auto'); 
setTimeout( function(){ 
parent.$('#dupplicaterecoreddlist').html('<?php echo $errorReportHeader.$duplicaterecored; ?>');
  }  , 1000 );
<?php } else {?>
parent.alertspopupopen('action=foundduplicaterecored&done=1&pagename=attendanceregularize&moduleName=<?php echo $importpackagesightseeingModule; ?>&errorCount=<?php echo $errorCount; ?>','600px','auto'); 
<?php } ?>
//parent.setupbox('showpage.crm?module=corporate');
parent.$('#pageloading').hide();
parent.$('#pageloader').hide();
</script>
<?php
}


if(trim($_POST['action'])=='addedit_salarycomponent' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$abbreviation=clean($_POST['abbreviation']);
$effectiveDate=date("Y-m-d", strtotime($_POST['effectiveDate']));
$paidComponent=clean($_POST['paidComponent']);
$payType=clean($_POST['payType']);
$taxStatus=clean($_POST['taxStatus']);
$chkTaxable=clean($_POST['chkTaxable']);
$calculationType=clean($_POST['calculationType']);
$jvCode=clean($_POST['jvCode']);
$mapTo=clean($_POST['mapTo']);
$chkFbp=clean($_POST['chkFbp']);
$chkAttandance=clean($_POST['chkAttandance']);
$chkCtc=clean($_POST['chkCtc']);
$chkComponenet=clean($_POST['chkComponenet']);
$chkActive=clean($_POST['chkActive']);
$valueFormula=clean($_POST['valueFormula']);
$chkFfs=clean($_POST['chkFfs']);

 
$dateAdded=time();

$namevalue ='name="'.$name.'",abbreviation="'.$abbreviation.'",effectiveDate="'.$effectiveDate.'",paidComponent="'.$paidComponent.'",
payType="'.$payType.'",taxStatus="'.$taxStatus.'",chkTaxable="'.$chkTaxable.'",calculationType="'.$calculationType.'",
jvCode="'.$jvCode.'",mapTo="'.$mapTo.'",chkFbp="'.$chkFbp.'",chkAttandance="'.$chkAttandance.'",chkCtc="'.$chkCtc.'",
chkComponenet="'.$chkComponenet.'",chkActive="'.$chkActive.'",chkFfs="'.$chkFfs.'",valueFormula="'.$valueFormula.'",
addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';

$adds = addlisting(_SALARY_COMPONENT_,$namevalue);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php }

if(trim($_POST['action'])=='addedit_salarycomponent' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 

$name=clean($_POST['name']);
$abbreviation=clean($_POST['abbreviation']);
$effectiveDate=date("Y-m-d", strtotime($_POST['effectiveDate']));
$paidComponent=clean($_POST['paidComponent']);
$payType=clean($_POST['payType']);
$taxStatus=clean($_POST['taxStatus']);
$chkTaxable=clean($_POST['chkTaxable']);
$calculationType=clean($_POST['calculationType']);
$jvCode=clean($_POST['jvCode']);
$mapTo=clean($_POST['mapTo']);
$chkFbp=clean($_POST['chkFbp']);
$chkAttandance=clean($_POST['chkAttandance']);
$chkCtc=clean($_POST['chkCtc']);
$chkComponenet=clean($_POST['chkComponenet']);
$chkActive=clean($_POST['chkActive']);
$valueFormula=clean($_POST['valueFormula']);
$chkFfs=clean($_POST['chkFfs']);

$dateAdded=time();
$editId=clean($_POST['editId']); 

$where='id='.$_POST['editId'].''; 

$namevalue ='name="'.$name.'",abbreviation="'.$abbreviation.'",effectiveDate="'.$effectiveDate.'",paidComponent="'.$paidComponent.'",
payType="'.$payType.'",taxStatus="'.$taxStatus.'",chkTaxable="'.$chkTaxable.'",calculationType="'.$calculationType.'",
jvCode="'.$jvCode.'",mapTo="'.$mapTo.'",chkFbp="'.$chkFbp.'",chkAttandance="'.$chkAttandance.'",chkCtc="'.$chkCtc.'",
chkComponenet="'.$chkComponenet.'",chkActive="'.$chkActive.'",chkFfs="'.$chkFfs.'",valueFormula="'.$valueFormula.'",
addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';
 
$update = updatelisting(_SALARY_COMPONENT_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }

 ?> 
 
 
 
<script>
parent.$('#pageloading').hide();
parent.$('#pageloader').hide();
</script>