<?php

if(trim($_POST['action'])=='add_crm_drivermaster'){ 

 $datef=time();
$birthDate=date("Y-m-d", strtotime($_POST['birthDate']));
$joiningDate=date("Y-m-d", strtotime($_POST['joiningDate']));
$name=clean($_POST['name']);
$mobile=clean($_POST['mobile']); 
$alternateMobile=clean($_POST['alternateMobile']);
$address=clean($_POST['address']);
$panNo=clean($_POST['panNo']);
$aadharNo=clean($_POST['aadharNo']);
$licenseNo=clean($_POST['licenseNo']);
$countryId=clean($_POST['countryId']);
$passportNo=clean($_POST['passportNo']);
$status=clean($_POST['status']);
$whatsappNo=clean($_POST['whatsappNo']);
$vehcileName=clean($_POST['vehcileName']);
$vehcileCapacity=clean($_POST['vehcileCapacity']);

$validUpto=date("Y-m-d", strtotime($_POST['validUpto'])); 

if($_FILES['fileAttachment']['name']!=''){ 
$file_name=$_FILES['fileAttachment']['name']; 
$ext=$file_name;
$ext=str_replace(' ', '_',$file_name);
$file_name=$datef.$ext;
copy($_FILES['fileAttachment']['tmp_name'],"dirfiles/".$file_name);

$fileAttachment=$file_name;

} else {
$fileAttachment=$_REQUEST['fileAttachment'];
}
if($_FILES['driverImage']['name']!=''){ 
$file_name=$_FILES['driverImage']['name']; 
$ext=$file_name;
$ext=str_replace(' ', '_',$file_name);
$file_name=$datef.$ext;
copy($_FILES['driverImage']['tmp_name'],"dirfiles/".$file_name);

$driverImage=$file_name;

} else {
$driverImage=$_REQUEST['driverImage'];
}
	
$status=0;
$editId=clean($_POST['editId']); 
$status=clean($_POST['status']);
$addBy=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
//$id=clean(decode($_GET['id']));
$addDate=time();

// duplicate added code 
$rsr=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'name="'.$name.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('Driver Master Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		
    }
    else{
		
		$namevalue ='name="'.$name.'",mobile="'.$mobile.'",alternateMobile="'.$alternateMobile.'",birthDate="'.$birthDate.'",joiningDate="'.$joiningDate.'",address="'.$address.'",panNo="'.$panNo.'",aadharNo="'.$aadharNo.'",licenseNo="'.$licenseNo.'",validUpto="'.$validUpto.'",fileAttachment="'.$fileAttachment.'",status="'.$status.'",addDate="'.$addDate.'",addBy="'.$addBy.'",countryId="'.$countryId.'",passportNo="'.$passportNo.'",whatsappNo="'.$whatsappNo.'",vehcileName="'.$vehcileName.'",vehcileCapacity="'.$vehcileCapacity.'",driverImage="'.$driverImage.'"';  

		//$adds = addlisting(_DRIVER_MASTER_MASTER_,$namevalue); 

		$where='id='.$_POST['editId'].''; 
		if($_POST['editId']!=''){
		$update = updatelisting(_DRIVER_MASTER_MASTER_,$namevalue,$where); 
		}else{
		$adds = addlisting(_DRIVER_MASTER_MASTER_,$namevalue);
		}
		?>
		<script>
		parent.setupbox('showpage.crm?module=drivermaster&alt=<?php if($editId!=''){echo '2'.'&status='.$status;}else {echo '1';}?>');
		</script> 
		<?php
	}
 }

if($_GET['id']!=''){
$id=clean(decode($_GET['id']));
//$id=clean(decode($_GET['id']));


$select='*';  
$where='id='.$id.''; 
$rs=GetPageRecord($select,_DRIVER_MASTER_MASTER_,$where); 
$editresult=mysqli_fetch_array($rs);

$name=clean($editresult['name']); 
$mobile=clean($editresult['mobile']); 
$alternateMobile=clean($editresult['alternateMobile']);
$birthDate=clean(date("d-m-Y", strtotime($editresult['birthDate'])));
$joiningDate=clean(date("d-m-Y", strtotime($editresult['joiningDate'])));
$address=clean($editresult['address']);
$panNo=clean($editresult['panNo']);
$aadharNo=clean($editresult['aadharNo']);
$licenseNo=clean($editresult['licenseNo']);
$validUpto=clean($editresult['validUpto']);
$status=clean($editresult['status']);   
$fileAttachment=clean($editresult['fileAttachment']);
$driverImage=clean($editresult['driverImage']);
}

?>
<style>
.Zebra_DatePicker_Icon_Wrapper {display:unset !important;}
</style>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="addeditfrm" target="actoinfrm" id="addeditfrm" enctype="multipart/form-data">
<div class="rightsectionheader">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>

    <td width="7%">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a>    
     </td>
    <td align="left">
    	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tr>
	        <td><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> <?php echo $pageName; ?> </span> </td>
	        <td align="right"><input type="button" name="Submit" value="Save" id="addnewuserbtn" onclick="formValidation('addeditfrm','submitbtn','0');" class="bluembutton submitbtn"/></td>
	        <td></td>
	        <td style="padding-right:20px;"><!--<input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />--></td>
	      </tr>
	      
    </table></td>
  </tr>
  
</table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
</div>

	 
<div class="addeditpagebox" id="loadDriverData">

  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Driver Information</h2>
    </div></td>
    </tr>
	
  <tr>
  
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv" ><label>
	<div class="gridlable">Country <?php //echo $editresult['countryId']; ?><span class="redmind"></span></div>
	
	<select id="countryId" name="countryId" class="gridfield validate" displayname="Country" autocomplete="off" onchange="selctCountry();" >
      <option value="">Select</option>
		<?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' deletestatus=0 and status=1  order by name asc';  
		$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
      <option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresult['countryId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
      <?php } ?>
    </select>
	</label>
    </div>
	<script>
function selctCountry(){
var id = $('#countryId :selected').val();
if(id==250){
$('#locat').hide();
$('#licensename').text('EMIRATEES ID');
}else{
$('#locat').show();
$('#licensename').text('License Number');
}
}
</script>

	
	
	
	
	
	<div class="griddiv" ><label>
	<div class="gridlable">Driver Name <span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" displayname="Name" id="name" value="<?php echo $name; ?>" maxlength="500" />
	</label>
	</div>

	

	<div class="griddiv" ><label>
	<div class="gridlable">Alternate Mobile number </div>
	<input name="alternateMobile" type="text" class="gridfield" id="alternateMobile" value="<?php echo $alternateMobile; ?>" maxlength="500" />
	</label>
	</div>






<div class="griddiv" style="display:none;" id="locat" >
	<label>
	<div class="gridlable">Birthdate</div>
	<input name="birthDate" type="text" id="birthDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php echo $birthDate;?>"  maxlength="500" /></label>
	</div>

	
	<div class="griddiv" style="display:none;" id="locat" ><label>
	<div class="gridlable">Joining date </div>
	<input name="joiningDate" type="text" id="fromDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php  echo $joiningDate?>" maxlength="500" />
	</label>
	</div>
	
	<div class="griddiv" id="locat" style="border-bottom:0px !important; display:none;"><label>
	<div class="gridlable">Aadhar Card Number </div>
	<input name="aadharNo" type="text" class="gridfield" id="aadharNo" value="<?php echo $aadharNo; ?>" maxlength="500" />
	</label>
	</div>
	
	
	<div class="griddiv" style="border-bottom:0px !important;"><label>
	<div class="gridlable">PASSPORT NO </div>
	<input name="passportNo" type="text" class="gridfield" id="passportNo" value="<?php echo $editresult['passportNo']; ?>" maxlength="500" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Address<span class="redmind"></span></div>
	<textarea name="address" id="address" style="width:98%;" class="gridfield" ><?php  echo stripslashes($address); ?></textarea>
	</label>
	</div>
	
	<div class="griddiv gridlable">
	<label> 
	<div  class="gridlable">status</div>
	<!-- <select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>"  style="width: 100%;"> 	 -->
	<select id="status" type="text" name="status" class="gridfield" displayname="Status" autocomplete="off" value="<?php echo $status; ?>"  style="width: 100%;"> 	

	<option value="1"  <?php if($status=='1'){ ?>selected="selected"<?php } ?>>Active</option>
	<option value="0"  <?php if($status=='0'){ ?>selected="selected"<?php } ?>>In Active</option>
	</select></label>
	</div>
	
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
 <div class="griddiv">
<label id="dest"> 
<div class="griddiv" ><label>
<div class="gridlable">Mobile Number  <span class="redmind"></span></div>
<input name="mobile" type="text" class="gridfield validate" id="mobile" displayname="Mobile Number" value="<?php echo $mobile; ?>" maxlength="500" />
</label>
</div>

<div class="griddiv" ><label>
<div class="gridlable">Whatsapp Number  <span class="redmind"></span></div>
<input name="whatsappNo" type="text" class="gridfield validate" id="whatsappNo" displayname="Whatsapp Number" value="<?php echo $editresult['whatsappNo']; ?>" maxlength="500" />
</label>
</div>



<div class="griddiv" id="locat" style="display:none;"><label>
<div class="gridlable">PAN Card Number </div>
<input name="panNo" type="text" class="gridfield" id="panNo" value="<?php echo $panNo; ?>" maxlength="500" />
</label>
</div> 

	
	
<div class="griddiv" style="border-bottom:0px !important;"><label>
<div class="gridlable" id="licensename">EMIRATEES  ID / License Number </div>
<input name="licenseNo" type="text" class="gridfield" id="licenseNo" value="<?php echo $licenseNo; ?>" maxlength="500" />
</label>
</div>

<!-- <div class="griddiv" style="border-bottom:0px !important;"><label>
<div class="gridlable" id="licensename">Vehcile Name</div>
<input name="vehcileName" type="text" class="gridfield" id="vehcileName" value="<?php echo $editresult['vehcileName']; ?>" maxlength="500" />
</label>
</div> 

<div class="griddiv" style="border-bottom:0px !important;"><label>
<div class="gridlable" id="licensename">Vehcile Capacity</div>
<input name="vehcileCapacity" type="text" class="gridfield" id="vehcileCapacity" value="<?php echo $editresult['vehcileCapacity']; ?>" maxlength="500" />
</label>
</div> -->

	
<div class="griddiv" style="border-bottom:0px !important;"><label>
	<div class="gridlable">Valid Upto</div>
	<input name="validUpto" type="text" id="validUpto" class="gridfield calfieldicon"  autocomplete="off" value="<?php if($validUpto==''){ echo date("d-m-Y"); }else{ echo date("d-m-Y", strtotime($validUpto)); } ?>" maxlength="500" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Upload License</div>
	<input name="fileAttachment" type="file" class="gridfield" id="fileAttachment" accept="image/x-png,image/gif,image/jpeg"/>
		 <?php if($fileAttachment!=''){ ?>
	 <a href="dirfiles/<?php echo $fileAttachment; ?>" target="_blank"><div class="commattachedbox"><strong>Download Attachment</strong>
	   <input name="fileAttachment" type="hidden" id="fileAttachment" value="<?php echo $fileAttachment;?>" />
	 </div>
	 </a>
	 <?php } ?>
	
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Image</div>
	<input name="driverImage" type="file" class="gridfield" id="driverImage" accept="image/x-png,image/gif,image/jpeg"/>
	</label>
	</div>
	</div>	 	 </td>
  </tr>
</table>
  
</div>


<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right">
	<table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="<?php echo encode($lastId); ?>" />
		<?php
		if($_GET['id']!=''){
		?>
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
		<?php } ?>
		</td>
        <td></td>
        <td><input type="button" name="Submit" value="Save" id="addnewuserbtn" onclick="formValidation('addeditfrm','submitbtn','0');" class="bluembutton submitbtn"/></td>
        <td style="padding-right:20px;"></td>
      </tr>
	  </table>
	  </td>
  </tr>
  
</table>
</div>
 <input name="action" type="hidden" id="action" value="add_crm_drivermaster" />
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
</form>
 
<style>
.addeditpagebox .griddiv {
    border-bottom: 0px #eee solid;
}
</style>
<script>  
comtabopenclose('linkbox','op2');
</script>
<script>
 $(document).ready(function() { 
  
$('#validUpto').Zebra_DatePicker({ 
  format: 'd-m-Y', 
}); 
  
  });
selctCountry();
</script>
