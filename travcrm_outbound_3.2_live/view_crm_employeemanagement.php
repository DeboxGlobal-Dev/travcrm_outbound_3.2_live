<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}

if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_EMPLOYEE_MANAGEMENT_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

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
$editdateAdded=clean($editresult['dateAdded']);

$editcontactName=clean($editresult['contactName']);
$editcontactNumber=clean($editresult['contactNumber']);
$editcontactRelation=clean($editresult['contactRelation']);
$editcontactBloodG=clean($editresult['contactBloodG']);
$editcontactAddress=clean($editresult['contactAddress']);

}

if($editassignTo!=''){ 

$select1='firstName,lastName,id';  
$where1='id='.$editassignTo.''; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$editOwnerresult=mysqli_fetch_array($rs1);

$assignfullName=strip($editOwnerresult['firstName'].' '.$editOwnerresult['lastName']); 
$assignfullId=encode($editOwnerresult['id']); 

}  
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:20px;"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td><?php echo $editname; ?></td>
  </tr>
  
</table>
</div></td>
    <td align="right"><?php if($editpermission==1){ ?><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="edit('<?php echo $_GET['id']; ?>');" /></td>
      </tr>
      
    </table><?php } ?></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">

 <div class="addeditpagebox vieweditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox"><h2>Employee Information</h2></div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv"><label><div class="gridlable">Employee Id</div>
	<div class="gridtext"><?php echo $editempId; ?></div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Name</div>
	<div class="gridtext"><?php echo $editname; ?></div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Email</div>
	<div class="gridtext"><?php echo $editemail; ?></div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Mobile</div>
	<div class="gridtext"><?php echo $editmobile; ?></div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">D.O.B.</div>
	<div class="gridtext"><?php echo $editbirthDate; ?></div>
	 
	</label>
	</div>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> 
	<div style="margin-bottom:10px; font-size:13px; color:#8a8a8a; position:relative;">Address </div>
	<div id="loadaddress" style="margin-bottom:20px;"></div>
	<div class="gridtext"><?php echo $editaddress; ?></div>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Gender</div>
	<div class="gridtext"><?php if($editgender == '0'){ echo 'Male';}else{ echo 'Female';} ?></div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Marital Status</div>
	<div class="gridtext"><?php if($editmaritalStatus == '0'){ echo 'Single';}else{ echo 'Married';} ?></div>
	 
	</label>
	</div>
	</td>
	</tr>
</table>
</div>
<div class="addeditpagebox vieweditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox"><h2>Work Information</h2></div></td>
    </tr>
  <tr>
    <td width="33%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv"><label><div class="gridlable">Department</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editdepartmentId.'';  
$rs=GetPageRecord($select,_DEPARTMENT_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	
	 </div>
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Designation</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editcurrentDesignation.'';  
$rs=GetPageRecord($select,_ROLE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?></div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Work Location</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editcity.'';  
$rs=GetPageRecord($select,_CITY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?></div>
</div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">UAN</div>
	<div class="gridtext"><?php echo $edituan; ?></div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">PAN</div>
	<div class="gridtext"><?php echo $editpan; ?></div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Reporting To</div>
	<div class="gridtext"><?php echo $editreportingTo; ?></div>
	 
	</label>
	</div>
	</td>
	
    <td width="33%" align="left" valign="top" style="padding-left:20px;"> 
	
	<div class="griddiv"><label><div class="gridlable">PF</div>
	<div class="gridtext"><?php echo $editpf; ?></div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">ESI</div>
	<div class="gridtext"><?php echo $editesi; ?></div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Employee Type</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editemployeeType.'';  
$rs=GetPageRecord($select,_EMPLOYEE_TYPE_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	</div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Aadhar</div>
	<div class="gridtext"><?php echo $editaadhar; ?></div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Status</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editempStatus.'';  
$rs=GetPageRecord($select,_EMPLOYEE_STATUS_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	</div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Joinging Date</div>
	<div class="gridtext"><?php echo $editjoiningDate; ?></div>
	 
	</label>
	</div>
	
	</td>
	<td width="33%" align="left" valign="top" style="padding-left:20px;"> 
	
	<div class="griddiv"><label><div class="gridlable">Source Of Hire</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editempHireSource.'';  
$rs=GetPageRecord($select,_EMPLOYEE_HIRE_SOURCE_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	</div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Employee Shift</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editemployeeShift.'';  
$rs=GetPageRecord($select,_EMPLOYEE_SHIFT_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	</div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Source Of Verification</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editempVerification.'';  
$rs=GetPageRecord($select,_EMPLOYEE_VERIFICATION_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	</div>
	 
	</label>
	</div>
	
	</td>
	</tr>
	
</table>
</div>

<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="editcontacts" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Work Experience</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv">
	  <div class="gridlable">Company Name</div> 
	<div class="gridtext">
	<?php echo $editcompanyName; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Designation</div> 
		<div class="gridtext"><?php echo $editdesignation; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Joining From</div> 
		<div class="gridtext"><?php echo $editjoiningFrom; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">Joining To</div> 
		<div class="gridtext">
			<?php echo $editjoiningTo; ?>
		</div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Job Description</div> 
		<div class="gridtext">
			<?php echo $editjobDesc; ?>
		</div>
	</div>
	
	<h3>Emergency Contact   </h3>
	<style>
	.emergencybg{background-color: #f9f9f9; padding: 10px; border: 1px #ececec solid; margin-bottom:8px; position:relative;}
	.griddiv .gridtextinner{background-color: #f9f9f9!important; border-bottom:0px;}
	</style>
<div class="emergencybg">
	<div class="griddiv">
		<div class="gridlable">Name</div> 
		<div class="gridtext gridtextinner"><?php echo $editcontactName; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable" >Contact No.</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $editcontactNumber; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">Relation</div> 
		<div class="gridtext gridtextinner"><?php echo $editcontactRelation; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">Blood Group</div> 
		<div class="gridtext gridtextinner"><?php echo $editcontactBloodG; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">Address</div> 
		<div class="gridtext gridtextinner"><?php echo $editcontactAddress; ?></div>
	</div>
</div>
	
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
	<h3>Bank Details</h3>
<div style="background-color: #f9f9f9; padding: 10px; border: 1px #ececec solid; margin-bottom:8px; position:relative; ">
	<div class="griddiv">
		<div class="gridlable">Account Number</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $editaccNumber; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable" >Account Holder Name</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $editaccHolderName; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable" >Bank Name</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $editbankName; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable" >IFSC Code</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $editifscCode; ?></div>
	</div>
</div>


	 	 </td>
  </tr>
</table>


</div>
</div>


<script>  
comtabopenclose('linkbox','op2');
</script>
