<?php 
include "inc.php";
if(trim($_POST['action'])=='add_crm_drivermaster'){ 

 $datef=time();
$birthDate=($_POST['birthDate']);
$joiningDate=($_POST['joiningDate']);
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
?>

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
	
	
	
	<div class="griddiv" id="locat"><label>
	<div class="gridlable">Driver Name <span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" displayname="Name" id="name" value="<?php echo $name; ?>" maxlength="500" />
	</label>
	</div>

	

	<div class="griddiv" id="locat"><label>
	<div class="gridlable">Alternate Mobile number </div>
	<input name="alternateMobile" type="text" class="gridfield" id="alternateMobile" value="<?php echo $alternateMobile; ?>" maxlength="500" />
	</label>
	</div>






<div class="griddiv">
	<label>
	<div class="gridlable">VEHCILES NAME </div>
	<input name="birthDate" type="text" id="birthDate" class="gridfield " value="<?php echo $birthDate;?>"  maxlength="500" /></label>
	</div>

	
	<div class="griddiv"><label>
	<div class="gridlable">SEATING CAPACITY   </div>
	<input name="joiningDate" type="text" id="fromDate" class="gridfield "  autocomplete="off" value="<?php  echo $joiningDate?>" maxlength="500" />
	</label>
	</div>
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Address<span class="redmind"></span></div>
	<textarea name="address" id="address" style="width:98%;" class="gridfield" ><?php  echo stripslashes($address); ?></textarea>
	</label>
	</div>
	

	
 
		
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
	 <div class="griddiv">
	<label id="dest">
	

				<div class="griddiv" id="locat"><label>
				<div class="gridlable">Mobile Number  <span class="redmind"></span></div>
				<input name="mobile" type="text" class="gridfield validate" id="mobile" displayname="Mobile Number" value="<?php echo $mobile; ?>" maxlength="500" />
				</label>
				</div>
	
	
	
				<div class="griddiv" id="locat"><label>
				<div class="gridlable">WHAT'S UP NO</div>
				<input name="panNo" type="text" class="gridfield" id="panNo" value="<?php echo $panNo; ?>" maxlength="500" />
				</label>
				</div>
				
				

	<div class="griddiv" id="locat" style="border-bottom:0px !important;"><label>
	<div class="gridlable">PASSPORT NO </div>
	<input name="aadharNo" type="text" class="gridfield" id="aadharNo" value="<?php echo $aadharNo; ?>" maxlength="500" />
	</label>
	</div>
	
<div class="griddiv" id="locat" style="border-bottom:0px !important;"><label>
	<div class="gridlable">EMIRATEES  ID</div>
	<input name="licenseNo" type="text" class="gridfield" id="licenseNo" value="<?php echo $licenseNo; ?>" maxlength="500" />
	</label>
	</div>
	

	
	

	</div> 
	

	
	
	
	 	 </td>
  </tr>
</table>
</div>