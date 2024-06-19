<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}

if($_GET['id']==''){ 
$where=' firstName="" and  addedBy='.$_SESSION['userid'].''; 
deleteRecord(_CONTACT_MASTER_,$where);

$dateAdded=time();
$namevalue ='firstName="",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.''; 
$lastId = addlistinggetlastid(_CONTACT_MASTER_,$namevalue); 
}


if(trim($_POST['action'])=='add_crm_vehiclemaster'){ 

$birthDate=date("Y-m-d", strtotime($_POST['birthDate']));
$joiningDate=date("Y-m-d", strtotime($_POST['joiningDate']));



$name=clean($_POST['name']);
$modelNo=clean($_POST['modelNo']); 
$vehicleNo=clean($_POST['vehicleNo']); 
$colour=clean($_POST['colour']); 
$fuelType=clean($_POST['fuelType']); 
$seatingCapacity=clean($_POST['seatingCapacity']); 
$assignedDriver=clean($_POST['assignedDriver']); 
$vehicleGroup=clean($_POST['vehicleGroup']); 
$ownerName=clean($_POST['ownerName']); 
$registrationDate=date("Y-m-d", strtotime(clean($_POST['registrationDate']))); 
$chassisNo=clean($_POST['chassisNo']); 
$engineNo=clean($_POST['engineNo']); 
$cName=clean($_POST['cName']); 
$policyNo=clean($_POST['policyNo']); 
$issueDate=date("Y-m-d", strtotime(clean($_POST['issueDate']))); 
$dueDate=date("Y-m-d", strtotime(clean($_POST['dueDate']))); 
$premiumAmount=clean($_POST['premiumAmount']); 
$coverAmount=clean($_POST['coverAmount']); 
$address=clean($_POST['address']); 
$taxEfficiency=clean($_POST['taxEfficiency']); 
$rtoExpiryDate=date("Y-m-d", strtotime(clean($_POST['rtoExpiryDate']))); 
$type=clean($_POST['type']); 
$expiryDate=date("Y-m-d", strtotime(clean($_POST['expiryDate']))); 

$deletestatus=clean($_POST['deletestatus']); 
$addedBy=$_SESSION['userid']; 
$dateAdded=time(); 
$modifyBy='0';
$modifyDate='0'; 

if($editedityes=='1'){
$modifyBy=$_SESSION['userid'];
$modifyDate=time(); 
$addedBy=clean($_POST['addedBy']); 
$dateAdded=clean($_POST['dateAdded']); 
}

$namevalue ='name="'.$name.'",modelNo="'.$modelNo.'",vehicleNo="'.$vehicleNo.'",colour="'.$colour.'",fuelType="'.$fuelType.'",seatingCapacity="'.$seatingCapacity.'",assignedDriver="'.$assignedDriver.'",vehicleGroup="'.$vehicleGroup.'",ownerName="'.$ownerName.'",registrationDate="'.$registrationDate.'",chassisNo="'.$chassisNo.'",engineNo="'.$engineNo.'",cName="'.$cName.'",policyNo="'.$policyNo.'",issueDate="'.$issueDate.'",dueDate="'.$dueDate.'",premiumAmount="'.$premiumAmount.'",coverAmount="'.$coverAmount.'",address="'.$address.'",taxEfficiency="'.$taxEfficiency.'",rtoExpiryDate="'.$rtoExpiryDate.'",type="'.$type.'",expiryDate="'.$expiryDate.'",addedBy="'.$addedBy.'",dateAdded="'.$dateAdded.'",modifyBy="'.$modifyBy.'"'; 
///,dateAdded="'.$dateAdded.'"

$editId=$_POST['editId'];
$where='id='.$editId.''; 
if($editId!='')
{ 
$update = updatelisting(_VEHICLE_INFORMATION_MASTER_,$namevalue,$where); echo $where;}else
{$adds = addlisting(_VEHICLE_INFORMATION_MASTER_,$namevalue);}
?>
<script>
parent.setupbox('showpage.crm?module=vehiclemaster&alt=<?php if($editId!=''){echo '2';}else {echo '1';}?>');
</script> 
<?php }



if($_GET['id']!=''){
$id=clean(decode($_GET['id']));
//$id=clean($_GET['id']);

$select='*';  
$where='id='.$id.''; 
$rs=GetPageRecord($select,_VEHICLE_INFORMATION_MASTER_,$where); 
$editresult=mysqli_fetch_array($rs);

$name=clean($editresult['name']);
$modelNo=clean($editresult['modelNo']); 
$vehicleNo=clean($editresult['vehicleNo']); 
$colour=clean($editresult['colour']); 
$fuelType=clean($editresult['fuelType']); 
$seatingCapacity=clean($editresult['seatingCapacity']); 
$assignedDriver=clean($editresult['assignedDriver']); 
$vehicleGroup=clean($editresult['vehicleGroup']); 
$ownerName=clean($editresult['ownerName']); 
$registrationDate=date("Y-m-d", strtotime(clean($editresult['registrationDate']))); 
$chassisNo=clean($editresult['chassisNo']); 
$engineNo=clean($editresult['engineNo']); 
$cName=clean($editresult['cName']); 
$policyNo=clean($editresult['policyNo']); 
$issueDate=date("Y-m-d", strtotime(clean($editresult['issueDate']))); 
$dueDate=date("Y-m-d", strtotime(clean($editresult['dueDate']))); 
$premiumAmount=clean($editresult['premiumAmount']); 
$coverAmount=clean($editresult['coverAmount']); 
$address=clean($editresult['address']); 
$taxEfficiency=clean($editresult['taxEfficiency']); 
$rtoExpiryDate=date("Y-m-d", strtotime(clean($editresult['rtoExpiryDate']))); 
$type=clean($editresult['type']); 
$expiryDate=date("Y-m-d", strtotime(clean($editresult['expiryDate'])));

$id=$editresult['id'];
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="addeditfrm" target="actoinfrm" id="addeditfrm" enctype="multipart/form-data">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:20px;"><a href="showpage.crm?module=vehiclemaster"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> <?php echo $pageName; ?> </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td></td>
        <td style="padding-right:20px;"><!--<input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />--></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">

 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="editcontacts" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Vehicle Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv">
	<label>
	<div class="gridlable">Brand Name<span class="redmind"></span></div>
	<select id="name" name="name" class="gridfield " displayname="Title" autocomplete="off" >
	<option value="">None</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by id asc';  
$rs=GetPageRecord($select,_VEHICLE_BRAND_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$name){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Model Number<span class="redmind"></span></div>
	<input name="modelNo" type="text" class="gridfield " id="modelNo" value="<?php echo $modelNo; ?>" displayname="First Name" maxlength="100" />
	</label>
	</div>
	
	

	<div class="griddiv"><label>
	<div class="gridlable">Colour   </div>
	<input name="colour" type="text" class="gridfield " id="colour" value="<?php echo $colour; ?>" displayname="Last Name" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Fuel Type   </div>
	<select id="fuelType" name="fuelType" class="gridfield " displayname="Title" autocomplete="off" >
	<option value="">None</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by id asc';  
$rs=GetPageRecord($select,_VEHICLE_FUEL_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$fuelType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Seating Capacity (including driver)   </div>
	<input name="seatingCapacity" type="text" class="gridfield " id="seatingCapacity" value="<?php echo $seatingCapacity; ?>" displayname="Last Name" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Assigned Driver   </div>

	<select id="assignedDriver" name="assignedDriver" class="gridfield " autocomplete="off" >
	<option value="">None</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=0 and name!="" order by id asc';  
$rs=GetPageRecord($select,_DRIVER_MASTER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$assignedDriver){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Category - Vehicle Group   </div>
	<input name="vehicleGroup" type="text" class="gridfield " id="vehicleGroup" value="<?php echo $vehicleGroup; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Registration Number   </div>
	<input name="vehicleNo" type="text" class="gridfield " id="vehicleNo" value="<?php echo $vehicleNo; ?>" displayname="vehicleNo" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Registered Owner Name   </div>
	<input name="ownerName" type="text" class="gridfield " id="ownerName" value="<?php echo $ownerName; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Registration Date   </div>
	<input name="registrationDate" type="text" id="registrationDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php if($registrationDate!=''){ echo date("d-m-Y", strtotime($registrationDate)); } ?>" />
	</label>
	</div>
	
	
	<h3>Parts   </h3>
	

	<div class="griddiv"><label>
	<div class="gridlable">Chassis Number   </div>
	<input name="chassisNo" type="text" class="gridfield " id="chassisNo" value="<?php echo $chassisNo; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Engine Number   </div>
	<input name="engineNo" type="text" class="gridfield " id="engineNo" value="<?php echo $engineNo; ?>" maxlength="100" />
	</label>
	</div>

	

	


	
	
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	<h3>Insurance</h3>
	
	<div class="griddiv"><label>
	<div class="gridlable">Company Name   </div>
	<input name="cName" type="text" class="gridfield " id="cName" value="<?php echo $cName; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Policy Number   </div>
	<input name="policyNo" type="text" class="gridfield " id="policyNo" value="<?php echo $policyNo; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Issue Date  </div>
	<input name="issueDate" type="text" id="issueDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php if($issueDate!=''){ echo date("d-m-Y", strtotime($issueDate)); } ?>" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Due Date   </div>
	<input name="dueDate" type="text" id="dueDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php if($dueDate!=''){ echo date("d-m-Y", strtotime($dueDate)); } ?>" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Premium Amount   </div>
	<input name="premiumAmount" type="text" class="gridfield " id="premiumAmount" value="<?php echo $premiumAmount; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Cover Amount   </div>
	<input name="coverAmount" type="text" class="gridfield " id="coverAmount" value="<?php echo $coverAmount; ?>" maxlength="100" />
	</label>
	</div>

<h3>RTO</h3>

	<div class="griddiv"><label>
	<div class="gridlable">Address   </div>
	<input name="address" type="text" class="gridfield " id="address" value="<?php echo $address; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Tax Efficiency   </div>
	<input name="taxEfficiency" type="text" class="gridfield " id="taxEfficiency" value="<?php echo $taxEfficiency; ?>" displayname="Last Name" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Expiry Date   </div>
	<input name="rtoExpiryDate" type="text" id="rtoExpiryDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php if($rtoExpiryDate!=''){ echo date("d-m-Y", strtotime($rtoExpiryDate)); } ?>" />
	</label>
	</div>
	
<h3>Permits</h3>

	<div class="griddiv"><label>
	<div class="gridlable">Type   </div>
	<input name="type" type="text" class="gridfield " id="type" value="<?php echo $type; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Expiry Date   </div>
	<input name="expiryDate" type="text" id="expiryDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php if($expiryDate!=''){ echo date("d-m-Y", strtotime($expiryDate)); } ?>" />
	
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
		
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td></td>
        <td style="padding-right:20px;"><!--<input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" />--></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 

 <input name="action" type="hidden" id="action" value="add_crm_vehiclemaster" />
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

 
</div>
</form>
<script>  
comtabopenclose('linkbox','op2');
</script>
  	<script>
 $(document).ready(function() { 
  
$('#issueDate').Zebra_DatePicker({ 
  format: 'd-m-Y', 
}); 
  
$('#registrationDate').Zebra_DatePicker({ 
  format: 'd-m-Y', 
}); 
$('#dueDate').Zebra_DatePicker({ 
  format: 'd-m-Y', 
});
 
$('#expiryDate').Zebra_DatePicker({ 
  format: 'd-m-Y', 
}); 

$('#rtoExpiryDate').Zebra_DatePicker({ 
  format: 'd-m-Y', 
}); 

  });

</script>
<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
