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
        <td><input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="edit('<?php echo $_GET['id']; ?>');" /></td>
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
	  <div class="gridlable">Brand Name</div> 
	<div class="gridtext">
	<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$name.'';  
$rs=GetPageRecord($select,_VEHICLE_BRAND_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Model Number</div> 
		<div class="gridtext"><?php echo $modelNo; ?></div>
	</div>

	<!--<div class="griddiv">
		<div class="gridlable">Vehicle Number</div> 
		<div class="gridtext"><?php echo $vehicleNo; ?></div>
	</div>-->

	<div class="griddiv">
		<div class="gridlable">Colour</div> 
		<div class="gridtext"><?php echo $colour; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">Fuel Type</div> 
		<div class="gridtext">
			<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$fuelType.'';  
$rs=GetPageRecord($select,_VEHICLE_FUEL_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
		</div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Seating Capacity (including driver)</div> 
		<div class="gridtext"><?php echo $seatingCapacity; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Assigned Driver</div> 
		<div class="gridtext">
			<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$assignedDriver.'';  
$rs=GetPageRecord($select,_DRIVER_MASTER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
		</div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Category - Vehicle Group</div> 
		<div class="gridtext"><?php echo $vehicleGroup; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Registration Number</div> 
		<div class="gridtext"><?php echo $vehicleNo; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">Registered Owner Name</div> 
		<div class="gridtext"><?php echo $ownerName; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Registration Date</div> 
		<div class="gridtext"><?php if($registrationDate!=''){ echo date("d-m-Y", strtotime($registrationDate)); } ?></div>
	</div>

	
	<h3>Parts   </h3>
	<style>
	.vehiclebg{background-color: #f9f9f9; padding: 10px; border: 1px #ececec solid; margin-bottom:8px; position:relative;}
	.griddiv .gridtextinner{background-color: #f9f9f9!important; border-bottom:0px;}
	</style>
<div class="vehiclebg">
	<div class="griddiv">
		<div class="gridlable">Chassis Number</div> 
		<div class="gridtext gridtextinner"><?php echo $chassisNo; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable" >Engine Number</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $engineNo; ?></div>
	</div>
</div>
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
	<h3>Insurance   </h3>
<div style="background-color: #f9f9f9; padding: 10px; border: 1px #ececec solid; margin-bottom:8px; position:relative; ">
	<div class="griddiv">
		<div class="gridlable">Company Name</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $cName; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable" >Policy Number</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $policyNo; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable" >Issue Date</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php if($issueDate!=''){ echo date("d-m-Y", strtotime($issueDate)); } ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable" >Premium Amount</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $premiumAmount; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable" >Cover Amount</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $coverAmount; ?></div>
	</div>
</div>


<h3>RTO</h3>
<div style="background-color: #f9f9f9; padding: 10px; border: 1px #ececec solid; margin-bottom:8px; position:relative; ">
	<div class="griddiv">
		<div class="gridlable">Address</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $address; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Tax Efficiency</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $taxEfficiency; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Expiry Date</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php if($rtoExpiryDate!=''){ echo date("d-m-Y", strtotime($rtoExpiryDate)); } ?></div>
	</div>
	
</div>


	
<h3>Permits</h3>

<div style="background-color: #f9f9f9; padding: 10px; border: 1px #ececec solid; margin-bottom:8px; position:relative; ">

	<div class="griddiv">
		<div class="gridlable">Type</div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php echo $type; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Expiry Date </div> 
		<div class="gridtext" style="background-color: #f9f9f9; border-bottom:0px;"><?php if($expiryDate!=''){ echo date("d-m-Y", strtotime($expiryDate)); } ?></div>
	</div>
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
        <td><input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="edit('<?php echo $_GET['id']; ?>');" /></td>
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
