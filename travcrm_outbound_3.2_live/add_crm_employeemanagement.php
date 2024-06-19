<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}

/*if($_GET['id']==''){
$where=' name="" and  addedBy='.$_SESSION['userid'].''; 
deleteRecord(_EMPLOYEE_MANAGEMENT_MASTER_,$where);

$dateAdded=time();
$namevalue ='name="",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.'';
$lastId = addlistinggetlastid(_EMPLOYEE_MANAGEMENT_MASTER_,$namevalue);
}*/

if($_GET['id']!=''){
$id=clean(decode($_GET['id']));
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_EMPLOYEE_MANAGEMENT_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$lastId = clean($editresult['id']);

$editempId=clean($editresult['empId']);
$editname=clean($editresult['name']); 
$editmobile=clean($editresult['mobile']);
$editemail=clean($editresult['email']);

$editgender=clean($editresult['gender']);
$editmaritalStatus=clean($editresult['maritalStatus']);
$editbirthDate=date("Y-m-d", strtotime($editresult['birthDate']));
$editaddress=clean($editresult['address']); 
$editpermanenetAddress=clean($editresult['permanenetAddress']);
$editdepartmentId=clean($editresult['departmentId']);

$edituan=clean($editresult['uan']);
$editpf=clean($editresult['pf']);
$editaadhar=clean($editresult['aadhar']);
$editcurrentDesignation=$editresult['currentDesignation'];

$editroleId=$editresult['roleId'];
$editprofileId=$editresult['profileId'];

$editpan=clean($editresult['pan']);
$editesi=clean($editresult['esi']);
$editempStatus=clean($editresult['empStatus']);
$editcity=clean($editresult['city']);
$editreportingTo=clean($editresult['reportingTo']);
$editemployeeType=clean($editresult['employeeType']);
$editjoiningDate=date("Y-m-d", strtotime($editresult['joiningDate']));
$editempHireSource=clean($editresult['empHireSource']);
$editemployeeShift=clean($editresult['employeeShift']);
$editempVerification=clean($editresult['empVerification']);

$editaccNumber=clean($editresult['accNumber']);
$editaccHolderName=clean($editresult['accHolderName']);
$editbankName=clean($editresult['bankName']);
$editifscCode=clean($editresult['ifscCode']);

$editcompanyName=clean($editresult['companyName']);
$editdesignation=clean($editresult['designation']);
$editjoiningFrom=date("Y-m-d", strtotime($editresult['joiningFrom']));
$editjoiningTo=date("Y-m-d", strtotime($editresult['joiningTo']));
$editaddedBy=clean($editresult['addedBy']);
$editjobDesc=clean($editresult['jobDesc']);

$editcontactName=clean($editresult['contactName']);
$editcontactNumber=clean($editresult['contactNumber']);
$editcontactRelation=clean($editresult['contactRelation']);
$editcontactBloodG=clean($editresult['contactBloodG']);
$editcontactAddress=clean($editresult['contactAddress']);

$editdateAdded=clean($editresult['dateAdded']);

}

?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add New Employee<?php } ?> </span></div>
	</td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
      </tr>
      
    </table>
	</td>
  </tr>
  
</table>
</div>


<div id="pagelisterouter" style="padding-left:0px;">
<?php if(encode($_GET['id']!='')) { ?>
<div class="tab">
  <a class="tablinks" href="showpage.crm?module=employeemanagement&page=add&id=<?php echo $_GET['id']; ?>"><button>Employee Basic Information</button></a>
 <a class="tablinks" href="showpage.crm?module=employeesalaryinfo&lastId=<?php echo $_GET['id']; ?>"><button>Salary Info</button></a>
</div>
<?php }?>
<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">

<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="addemployee" />
  <!--<input name="savenew" type="hidden" id="savenew" value="0" />-->
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Employee Basic Info</h2>
    </div></td>
    </tr>
  <tr>
    <td width="33%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Employee Id<span class="redmind"></span>  </div>
	<input name="empId" type="text" class="gridfield validate" id="empId" value="<?php echo $editempId; ?>" displayname="Employee Id" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Employee Name<span class="redmind"></span>  </div>
	<input name="name" type="text" class="gridfield " id="name" value="<?php echo $editname; ?>" displayname="Employee Name" maxlength="100" />
	</label>
	</div>
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Mobile</div>
	<input name="mobile" type="text" class="gridfield" id="mobile" value="<?php echo $editmobile; ?>" maxlength="15" />
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Email<?php if($_GET['id']==''){ ?><span class="redmind"></span><?php } ?></div>
	<input name="email" type="email"  class="gridfield " id="email" value="<?php echo $editemail; ?>" displayname="Email" autocomplete="off" />
	</label>
	</div>
	
	</td>
	
	<td width="33%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Gender </div>

	<select id="gender" name="gender" class="gridfield " displayname="Gender" autocomplete="off"   >
		 <option value="">Select</option> 
	<option value="0" <?php if(0==$editgender){ ?>selected="selected"<?php } ?>>Male</option> 
	<option value="1" <?php if(1==$editgender){ ?>selected="selected"<?php } ?>>Female</option> 
	</select>
	</label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Marital Status </div>

	<select id="maritalStatus" name="maritalStatus" class="gridfield " displayname="Marital Status" autocomplete="off"   >
		 <option value="">Select</option> 
	<option value="0" <?php if('0'==$editmaritalStatus){ ?>selected="selected"<?php } ?>>Single</option> 
	<option value="1" <?php if('1'==$editmaritalStatus){ ?>selected="selected"<?php } ?>>Married</option>
	</select>
	</label>
	</div>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
	<script>
 $(document).ready(function() { 
  
$('#birthDate').Zebra_DatePicker({ 
  format: 'd-m-Y', 
}); 

$('#joiningDate').Zebra_DatePicker({ 
  format: 'd-m-Y',
});

$('#joiningFrom').Zebra_DatePicker({ 
  format: 'd-m-Y',
});

$('#joiningTo').Zebra_DatePicker({ 
  format: 'd-m-Y',
});

});

</script>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Birthdate</div>
	<input name="birthDate" type="text" id="birthDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php echo $editbirthDate;?>"  maxlength="500" /></label>
	</div>
	
	</td>
	
    <td width="33%" align="left" valign="top" style="padding-left:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Address<span class="redmind"></span></div>
	<textarea name="address" id="address" style="width:98%;" class="gridfield" ><?php  echo stripslashes($editaddress); ?></textarea>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Permanent Address<span class="redmind"></span></div>
	<textarea name="permanentAddress" id="permanentAddress" style="width:98%;" class="gridfield" ><?php  echo stripslashes($editpermanentAddress); ?></textarea>
	</label>
	</div>
	
 	</td>
		 
  </tr>
</table>


</div>

<div class="addeditpagebox">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Work</h2>
    </div></td>
    </tr>
  <tr>
    <td width="33%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Department <span class="redmind"></span></div>
	<select id="departmentId" name="departmentId" class="gridfield" displayname="Department" autocomplete="off" >
	<option value="">Select Department</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
if($loginuseradmin==1){
$where='status="1" order by id asc'; 
} else { 
$where='status="1" order by id asc'; 
}

$rs=GetPageRecord($select,_DEPARTMENT_MASTER_,$where); 
while($timeformat=mysqli_fetch_array($rs)){  
if($timeformat['deletestatus']!=1){
?>
<option value="<?php echo strip($timeformat['id']); ?>" <?php if($timeformat['id']==$editdepartmentId){ ?>selected="selected"<?php } ?>><?php echo strip($timeformat['name']); ?></option>
<?php }} ?>
</select></label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">UAN<span class="redmind"></span>  </div>
	<input name="uan" type="text" class="gridfield " id="uan" value="<?php echo $edituan; ?>" displayname="UAN" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">PF<span class="redmind"></span>  </div>
	<input name="pf" type="text" class="gridfield " id="pf" value="<?php echo $editpf; ?>" displayname="PF" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Aadhar<span class="redmind"></span>  </div>
	<input name="aadhar" type="text" class="gridfield " id="aadhar" value="<?php echo $editaadhar; ?>" displayname="Aadhar" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">PAN<span class="redmind"></span>  </div>
	<input name="pan" type="text" class="gridfield " id="pan" value="<?php echo $editpan; ?>" displayname="PAN" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv">
	<label>
	<img src="images/userrole.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" />
	<div class="gridlable">Role <span class="redmind"></span></div> 
	<input name="roleidname" type="text" class="gridfield" readonly="true" onclick="alertspopupopen('action=selectrole','600px','auto');" id="roleidname" value="<?php if($editroleId!=''){  $select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id='.$editroleId.' order by name'; 
$rs=GetPageRecord($select,_ROLE_MASTER_,$where); 
while($timeformat=mysqli_fetch_array($rs)){  
echo strip($timeformat['name']);
} }
?>" maxlength="60" displayname="Role Name" autocomplete="off" />
	<input name="roleId" id="roleId" type="hidden" value="<?php echo $editroleId; ?>" />
	 
 
 </label>
	</div>
	
	</td>
    <td width="33%" align="left" valign="top" style="padding-left:20px;">
	
		<div class="griddiv">
	<label>
	<div class="gridlable">Designation <span class="redmind"></span></div>
	<select id="currentDesignation" name="currentDesignation" class="gridfield" displayname="Role Name" autocomplete="off" >
	<option value="">Select Designation</option>

 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
if($loginuseradmin==1){
$where='id="1" or userId="'.$loginusersuperParentId.'" order by id asc'; 
} else { 
$where='userId="'.$loginusersuperParentId.'" order by id asc'; 
}

$rs=GetPageRecord($select,_ROLE_MASTER_,$where); 
while($timeformat=mysqli_fetch_array($rs)){  
if($timeformat['deletestatus']!=1){
?>
<option value="<?php echo strip($timeformat['id']); ?>" <?php if($timeformat['id']==$editcurrentDesignation){ ?>selected="selected"<?php } ?>><?php echo strip($timeformat['name']); ?></option>
<?php }} ?>

</select></label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">ESI<span class="redmind"></span>  </div>
	<input name="esi" type="text" class="gridfield " id="esi" value="<?php echo $editesi; ?>" displayname="ESI" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Status </div>
	<select id="empStatus" name="empStatus" class="gridfield " displayname="Employee Status" autocomplete="off"   >
	<option value="">Select</option> 
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='status=1 order by name';
$rs=GetPageRecord($select,_EMPLOYEE_STATUS_MASTER_,$where);
while($empStatus=mysqli_fetch_array($rs)){ 
?>
	<option value="<?php echo strip($empStatus['id']); ?>" <?php if($editempStatus==$empStatus['id']){ ?>selected="selected"<?php } ?>><?php echo strip($empStatus['name']);?></option>
	<?php } ?>
	</select>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Employee Shift </div>
	<select id="employeeShift" name="employeeShift" class="gridfield">
	<option value="">Select Employee Shift</option>
	
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='deletestatus=0 order by name'; 
$rs=GetPageRecord($select,_EMPLOYEE_SHIFT_,$where);
while($r=mysqli_fetch_array($rs)){ 
?>
<option value="<?php echo strip($r['id']); ?>" <?php if($editemployeeShift==$r['id']){ ?>selected="selected"<?php } ?>><?php echo strip($r['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Source Of Verification</div>
	<select id="empVerification" name="empVerification" class="gridfield">
	<option value="">Select</option>
	
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='deletestatus=0 order by name'; 
$rs=GetPageRecord($select,_EMPLOYEE_VERIFICATION_,$where);
while($r=mysqli_fetch_array($rs)){ 
?>
<option value="<?php echo strip($r['id']); ?>" <?php if($editempVerification==$r['id']){ ?>selected="selected"<?php } ?>><?php echo strip($r['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Profile <span class="redmind"></span></div>
	<select id="profileId" name="profileId" class="gridfield" displayname="Profile" autocomplete="off" >
	<option value="">Select Profile</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
if($loginuseradmin==1){
$where='id="1" or userId="'.$loginusersuperParentId.'" order by id asc'; 
} else { 
$where='userId="'.$loginusersuperParentId.'" order by id asc'; 
}

$rs=GetPageRecord($select,_PROFILE_MASTER_,$where); 
while($timeformat=mysqli_fetch_array($rs)){  
if($timeformat['deletestatus']!=1){
?>
<option value="<?php echo strip($timeformat['id']); ?>" <?php if($timeformat['id']==$editprofileId){ ?>selected="selected"<?php } ?>><?php echo strip($timeformat['profileName']); ?></option>
<?php }} ?>
</select></label>
	</div>
	
	</td>
	
	<td width="33%" align="left" valign="top" style="padding-left:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Work Location </div>
	<select id="city" name="city" class="gridfield">
	<option value="">Select</option>
	<!--
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='deletestatus=0 order by name'; 
$rs=GetPageRecord($select,_CITY_MASTER_,$where); 
while($city=mysqli_fetch_array($rs)){ 
?>
<option value="<?php echo strip($city['id']); ?>" <?php if($editcity==$city['id']){ ?>selected="selected"<?php } ?>><?php echo strip($city['name']); ?></option>
<?php } ?>-->
</select></label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Reporting To<span class="redmind"></span>  </div>
	<input name="reportingTo" type="text" class="gridfield " id="reportingTo" value="<?php echo $editreportingTo; ?>" displayname="Reporting To" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Employee Type </div>
	<select id="employeeType" name="employeeType" class="gridfield">
	<option value="">Select Employee Type</option>
	
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='deletestatus=0 order by name'; 
$rs=GetPageRecord($select,_EMPLOYEE_TYPE_,$where); 
while($employeeType=mysqli_fetch_array($rs)){ 
?>
<option value="<?php echo strip($employeeType['id']); ?>" <?php if($editemployeeType==$employeeType['id']){ ?>selected="selected"<?php } ?>><?php echo strip($employeeType['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Joining Date </div>
	<input name="joiningDate" type="text" id="toDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php  echo $editjoiningDate?>" maxlength="500" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Source Of Hire </div>
	<select id="empHireSource" name="empHireSource" class="gridfield">
	<option value="">Select Option</option>
	
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='deletestatus=0 order by name'; 
$rs=GetPageRecord($select,_EMPLOYEE_HIRE_SOURCE_,$where); 
while($source=mysqli_fetch_array($rs)){ 
?>
<option value="<?php echo strip($source['id']); ?>" <?php if($editempHireSource==$source['id']){ ?>selected="selected"<?php } ?>><?php echo strip($source['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	

	 	 </td>
		
		 
  </tr>
</table>


</div>

<div class="addeditpagebox">
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Bank Details</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Account Number<span class="redmind"></span>  </div>
	<input name="accNumber" type="text" class="gridfield " id="accNumber" value="<?php echo $editaccNumber; ?>" displayname="Account Number" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Account Holder Name<span class="redmind"></span>  </div>
	<input name="accHolderName" type="text" class="gridfield " id="accHolderName" value="<?php echo $editaccHolderName; ?>" displayname="Account Holder Name" maxlength="100" />
	</label>
	</div>
	
	
	
	
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Bank Name<span class="redmind"></span>  </div>
	<input name="bankName" type="text" class="gridfield " id="bankName" value="<?php echo $editbankName; ?>" displayname="Bank Name" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">IFSC Code<span class="redmind"></span>  </div>
	<input name="ifscCode" type="text" class="gridfield " id="ifscCode" value="<?php echo $editifscCode; ?>" displayname="IFSC Code" maxlength="100" />
	</label>
	</div>
	
	 	 </td>
		 
  </tr>
</table>


</div>

<div class="addeditpagebox">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Work Experience</h2>
    </div></td>
    </tr>
  <tr>
    <td width="33%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Company Name<span class="redmind"></span>  </div>
	<input name="companyName" type="text" class="gridfield " id="companyName" value="<?php echo $editcompanyName; ?>" displayname="Company Name" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Designation<span class="redmind"></span>  </div>
	<input name="designation" type="text" class="gridfield " id="designation" value="<?php echo $editdesignation; ?>" displayname="Designation" maxlength="100" />
	</label>
	</div>
	
	</td>
	
	<td width="33%" align="left" valign="top" style="padding-left:20px;">
	<div class="griddiv"><label>
	<div class="gridlable">Joining From </div>
	<input name="joiningFrom" type="text" id="fromDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php  echo $editjoiningFrom?>" maxlength="500" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Joining To </div>
	<input name="joiningTo" type="text" id="joiningTo" class="gridfield calfieldicon"  autocomplete="off" value="<?php  echo $editjoiningTo?>" maxlength="500" />
	</label>
	</div>
	
	
	
	
	<td width="50%" align="left" valign="top" style="padding-left:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Job Description<span class="redmind"></span></div>
	<textarea name="jobDesc" id="jobDesc" style="width:98%;" class="gridfield" ><?php  echo stripslashes($editjobDesc); ?></textarea>
	</label>
	</div>
	
	</td>
		 
  </tr>
</table>


</div>

<div class="addeditpagebox">
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Emergency Contact</h2>
    </div></td>
    </tr>
  <tr>
    <td width="33%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span>  </div>
	<input name="contactName" type="text" class="gridfield " id="contactName" value="<?php echo $editcontactName; ?>" displayname="Emergency Contact Name" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Contact No.<span class="redmind"></span>  </div>
	<input name="contactNumber" type="text" class="gridfield " id="contactNumber" value="<?php echo $editcontactNumber; ?>" displayname="Emergency Contact" maxlength="100" />
	</label>
	</div>
	
	
	
	
	</td>
    <td width="33%" align="left" valign="top" style="padding-left:20px;">
	
	<div class="griddiv"><label>
	<div class="gridlable">Relation<span class="redmind"></span>  </div>
	<input name="contactRelation" type="text" class="gridfield " id="contactRelation" value="<?php echo $editcontactRelation; ?>" displayname="Relation" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Blood Group<span class="redmind"></span>  </div>
	<input name="contactBloodG" type="text" class="gridfield " id="contactBloodG" value="<?php echo $editcontactBloodG; ?>" displayname="Blood Group" maxlength="100" />
	</label>
	</div>
	
	</td>
	
	<td width="33%" align="left" valign="top" style="padding-left:20px;">
	<div class="griddiv"><label>
	<div class="gridlable">Address<span class="redmind"></span></div>
	<textarea name="contactAddress" id="contactAddress" style="width:98%;" class="gridfield" ><?php  echo stripslashes($editcontactAddress); ?></textarea>
	</label>
	</div>
	
	
	</td>	 
  </tr>
</table>


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>
		<!--<input name="editId" type="hidden" id="editId" value="<?php echo encode($lastId); ?>" />-->
			<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
		<?php
		if($_GET['id']!=''){
		?>
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
		<?php } ?>
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>

</div>
<script>  
comtabopenclose('linkbox','op2');
</script>
<style>

body {font-family: Arial;}

 

/* Style the tab */

.tab {

  overflow: hidden;

  border: 1px solid #ccc;

  background-color: #f1f1f1;

}

 

/* Style the buttons inside the tab */

.tab button {

  background-color: inherit;

  float: left;

  border: none;

  outline: none;

  cursor: pointer;

  padding: 14px 16px;

  transition: 0.3s;

  font-size: 17px;

}

 

/* Change background color of buttons on hover */

.tab button:hover {

  background-color: #ddd;

}

 

/* Create an active/current tablink class */

.tab button.active {

  background-color: #ccc;

}

 

/* Style the tab content */

.tabcontent {

  display: none;

  padding: 6px 12px;

  border: 1px solid #ccc;

  border-top: none;

}

.tab{
	 margin-top:-4px;
 }

</style>