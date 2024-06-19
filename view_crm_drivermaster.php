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
$validUpto=date("Y-m-d", strtotime($_POST['validUpto']));
//$fileAttachment=clean($_POST['fileAttachment']);

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
	
$status=0;

$editId=clean($_POST['editId']); 
$status=clean($_POST['status']);
$addBy=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
//$id=clean(decode($_GET['id']));
$addDate=time();

$namevalue ='name="'.$name.'",mobile="'.$mobile.'",alternateMobile="'.$alternateMobile.'",birthDate="'.$birthDate.'",joiningDate="'.$joiningDate.'",address="'.$address.'",panNo="'.$panNo.'",aadharNo="'.$aadharNo.'",licenseNo="'.$licenseNo.'",validUpto="'.$validUpto.'",fileAttachment="'.$fileAttachment.'",status="0",addDate="'.$addDate.'",addBy="'.$addBy.'"';  

//$adds = addlisting(_DRIVER_MASTER_MASTER_,$namevalue); 

$where='id='.$_POST['editId'].''; 
if($_POST['editId']!='')
{
$update = updatelisting(_DRIVER_MASTER_MASTER_,$namevalue,$where); }else
{$adds = addlisting(_DRIVER_MASTER_MASTER_,$namevalue);}
?>
<script>
parent.setupbox('showpage.crm?module=drivermaster&alt=<?php if($editId!=''){echo '2';}else {echo '1';}?>');
</script> 
<?php }

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
$fileAttachment=clean($editresult['fileAttachment']);
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
    <td><div class="headingm" style="margin-left:20px;"><a href="showpage.crm?module=drivermaster"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> <?php echo $pageName; ?> </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input type="button" name="Submit" value="Save" id="addnewuserbtn" onclick="formValidation('addeditfrm','submitbtn','0');" class="bluembutton submitbtn"/></td>
        <td></td>
        <td style="padding-right:20px;"><!--<input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />--></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
</div>

 
<div class="addeditpagebox">

  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Driver Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">


	<div class="griddiv">
		<div class="gridlable">Driver Name</div> 
		<div class="gridtext"><?php echo $name; ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">Alternate Mobile number</div> 
		<div class="gridtext"><?php echo $alternateMobile; ?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Birthdate</div> 
		<div class="gridtext"><?php echo $birthDate;?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Joining date</div> 
		<div class="gridtext"><?php echo $joiningDate;?></div>
	</div>

	<div class="griddiv">
		<div class="gridlable">Address</div> 
		<div class="gridtext"><?php  echo stripslashes($address); ?></div>
	</div>
			
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
	 <div class="">
	<label id="dest">
	
	<div class="griddiv">
		<div class="gridlable">Mobile Number</div> 
		<div class="gridtext"><?php  echo stripslashes($mobile); ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">PAN Card Number</div> 
		<div class="gridtext"><?php  echo stripslashes($panNo); ?></div>
	</div>
				
	<div class="griddiv">
		<div class="gridlable">Aadhar Card Number</div> 
		<div class="gridtext"><?php  echo stripslashes($aadharNo); ?></div>
	</div>	

	<div class="griddiv">
		<div class="gridlable">License Number</div> 
		<div class="gridtext"><?php  echo stripslashes($licenseNo); ?></div>
	</div>
	
	<div class="griddiv">
		<div class="gridlable">Valid Upto</div> 
		<div class="gridtext"><?php  echo date("d-m-Y", strtotime($validUpto));?></div>
	</div>
	
	<?php if($fileAttachment!=''){ ?><div class="griddiv">
	<label><div class="gridlable">Driving License</div>
	<div class="gridtext"> <a href="download/<?php echo $fileAttachment; ?>" target="_blank"><div class="commattachedbox" style="    padding-top: 2px;
    padding-bottom: 4px;
    margin-bottom: 5px;"><strong>Download Attachment</strong></div>
	 </a></div></label>
	
	 
	</div> <?php } ?>
	
	
	</label>
	</div>
	

	</div> 
	

	
	
	
	 	 </td>
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
 
<script>  
comtabopenclose('linkbox','op2');
</script>
<script>
 $(document).ready(function() { 
  
$('#validUpto').Zebra_DatePicker({ 
  format: 'd-m-Y', 
}); 
  
  });

</script>
