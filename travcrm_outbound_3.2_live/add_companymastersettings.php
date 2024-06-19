<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}



if($_GET['id']!=''){
 $id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editfirstName=clean($editresult['firstName']);
$usercode=clean($editresult['usercode']);
$editlastName=clean($editresult['lastName']);
$editEmail=clean($editresult['email']);
$editPhone=clean($editresult['phone']);
$editPassword=clean($editresult['password']);
$editMobile=clean($editresult['mobile']);
$editStreet=clean($editresult['street']);
$editCity=clean($editresult['city']);
$editState=clean($editresult['state']);
$editZip=clean($editresult['zip']);
$editCountry=clean($editresult['country']);
$editNoofusers=clean($editresult['noofusers']);
$editServerspace=clean($editresult['serverspace']);
$editExpireDate=$editresult['expiryDate']; 
$editCurrency=clean($editresult['currency']);
$editTimezone=clean($editresult['timeZone']);
$editTimeformat=clean($editresult['timeFormat']);
$editroleId=clean($editresult['roleId']);
$editprofileId=clean($editresult['profileId']);
$edituserType=clean($editresult['userType']);
$editdestinationList=clean($editresult['destinationList']);
$userLoginType=clean($editresult['userLoginType']);
$editlanguageList=clean($editresult['languagelist']);
$editpin=clean($editresult['pin']);
$companyId=clean($editresult['companyId']);
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="plugins/select2/select2.min.js"></script>
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> Users </span></div></td>
    <td align="right"><?php 
$ccc="select id from "._USER_MASTER_." where  superParentId=".$loginusersuperParentId."  and status=1 ";
$ddd = mysqli_query(db(),$ccc);
$totaluserscreated=mysqli_num_rows($ddd);


if($Logintimeuserzone['noofusers']>$totaluserscreated || $Logintimeuserzone['noofusers']==$totaluserscreated){ } else {?><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
      </tr>
      
    </table><?php } ?></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post" enctype="multipart/form-data">
<?php 
$ccc="select id from "._USER_MASTER_." where  superParentId=".$loginusersuperParentId." and status=1 ";
$ddd = mysqli_query(db(),$ccc);
 $totaluserscreated=mysqli_num_rows($ddd);
 
 
if($Logintimeuserzone['noofusers']<=$totaluserscreated && $_GET['id']==''){ ?>
<div class="rightfootersectionheader" style="margin:0px; background-color:transparent; border-top:0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><strong>Account's user limit is exceeded</strong><br />
      <br />
      <input type="button" name="Submit22" value="     Ok     " class="whitembutton" onclick="cancel();" /> </td>
  </tr>
  
</table>
</div>
<?php }  else { ?>
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="addcrmusers" />
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox"><h2>Account Information</h2></div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv">
	<label>
	<div class="gridlable">User Code<span class="redmind"></span></div>
	<input name="usercode" type="text" class="gridfield validate" id="usercode" value="<?php echo $usercode; ?>" maxlength="60" displayname="FIrst Name" autocomplete="off" />
	</label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">FIrst Name<span class="redmind"></span></div>
	<input name="firstName" type="text" class="gridfield validate" id="firstName" value="<?php echo $editfirstName; ?>" maxlength="60" displayname="FIrst Name" autocomplete="off" />
	</label>
	</div>
	
	<div class="griddiv">
	<label>
	
	<div class="gridlable">Last Name</div>
	<input name="lastName" type="text" class="gridfield" id="lastName" value="<?php echo $editlastName; ?>" maxlength="60" displayname="Last Name" autocomplete="off" />
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Email<?php if($_GET['id']==''){ ?><span class="redmind"></span><?php } ?></div>
	<input name="email" type="email"  class="gridfield validate" id="email" value="<?php echo $editEmail; ?>" displayname="Email" autocomplete="off" />
	</label>
	</div>
	
	 <div class="griddiv"><label>
	<div class="gridlable">Password<?php if($_GET['id']==''){ ?><span class="redmind"></span><?php } ?></div>
	<input name="password" type="password" class="gridfield validate" id="password" value="<?php echo $editPassword; ?>" maxlength="15" displayname="Password" />
	<input name="oldpassword" id="oldpassword" type="hidden" value="<?php echo $editPassword; ?>"/>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">PIN</div>
	<input name="pin" type="number" class="gridfield" id="pin" value="<?php echo $editpin; ?>" maxlength="15" displayname="Password" /> 
	</label>
	</div>
	<div class="griddiv">
	<label>
	<img src="images/userrole.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" />
	<div class="gridlable">Role <span class="redmind"></span></div> 
	<input name="roleidname" type="text" class="gridfield validate" readonly="true" onclick="alertspopupopen('action=selectrole','600px','auto');" id="roleidname" value="<?php if($editroleId!=''){  $select=''; 
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
	
	
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Reporting Manager <span class="redmind"></span></div>
	<select id="reportingManager" name="reportingManager" class="gridfield" displayname="Profile" autocomplete="off" >
	<option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id!="'.$editresult['id'].'" and status=1  order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($reportingmanagerlist=mysqli_fetch_array($rs)){   
 
?>
<option value="<?php echo strip($reportingmanagerlist['id']); ?>" <?php if($reportingmanagerlist['id']==$editresult['reportingManager']){ ?>selected="selected"<?php } ?>><?php echo $reportingmanagerlist['firstName'].' '.$reportingmanagerlist['lastName']; ?></option>
<?php }  ?>
</select></label>
	</div>
	
	
	
	<div class="griddiv">
		<label>
			<div class="gridlable">User Type  </div>
			<select id="userType" name="userType" class="gridfield">	 
				<option value="0" <?php if('0'==$edituserType){ ?>selected="selected"<?php } ?>>Sales Person</option>
				<option value="1" <?php if('1'==$edituserType){ ?>selected="selected"<?php } ?>>Operations Person</option>
				<option value="2" <?php if('2'==$edituserType){ ?>selected="selected"<?php } ?>>Account Manager</option> 
				<option value="3" <?php if('3'==$edituserType){ ?>selected="selected"<?php } ?>>Contracting Person</option> 
				<option value="4" <?php if('4'==$edituserType){ ?>selected="selected"<?php } ?>>Reservation</option> 
			</select>
		</label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">User Login Type </div>
	<select id="userLoginType" name="userLoginType" class="gridfield" onchange="showcompanyname()">
 
<option value="0" <?php if('0'==$userLoginType){ ?>selected="selected"<?php } ?>>Internal User</option>
<option value="1" <?php if('1'==$userLoginType){ ?>selected="selected"<?php } ?>>External User</option> 
</select></label>
	</div>
	
	
	<script>
	function showcompanyname(){
	var userLoginType = $('#userLoginType').val();
	if(userLoginType=='0'){
	$('#companyname').hide();
	} else { 
	$('#companyname').show();
	}
	}
	</script>
	<div class="griddiv" style="display:none;" id="companyname">
	<label>
	<div class="gridlable">Company</div>
	<select id="companyId" name="companyId" class="gridfield">
 <?php 
$select=''; 
$where='deletestatus=0 and name!="" order by name'; 
$rs='';  
$select='*'; 
$rs=GetPageRecord($select,'corporateMaster',$where); 
while($companyname=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo $companyname['id']; ?>" <?php if($companyId==$companyname['id']){ ?>selected="selected"<?php } ?>><?php echo $companyname['name']; ?></option> 
<?php } ?>
</select></label>
	</div>
	
	
	<?php if($_REQUEST['id']!=''){ ?>
	<script>
	showcompanyname();
	</script>
	<?php } ?>	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	<div class="griddiv"><label>
	<div class="gridlable">Phone</div>
	<input name="phone" type="text" class="gridfield" id="phone" value="<?php echo $editPhone; ?>" maxlength="15" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Mobile</div>
	<input name="mobile" type="text" class="gridfield" id="mobile" value="<?php echo $editMobile; ?>" maxlength="15" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Street</div>
	<input name="street" type="text" class="gridfield" id="street" value="<?php echo $editStreet; ?>" maxlength="60" />
	</label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Time Format </div>
	<select id="timeformat" name="timeformat" class="gridfield">
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id!="" order by name'; 
$rs=GetPageRecord($select,_TIMEFORMAT_MASTER_,$where); 
while($timeformat=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($timeformat['id']); ?>" <?php if($timeformat['id']==$editTimeformat){ ?>selected="selected"<?php } ?>><?php echo strip($timeformat['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	<div class="griddiv"> 
	<label> <div class="gridlable">Language&nbsp;Known  </div>
	<select name="languageKnown[]" multiple="multiple" class="gridfield  js-example-basic-multiple" id="languageKnown"   displayname="Language" autocomplete="off"> 
	<option value="">Select</option> 
	<?php  
	$select='*';   
	$where='deletestatus="0" order by name'; 
	$rs=GetPageRecord($select,'tbl_languagemaster',$where); 
	while($languagelist=mysqli_fetch_array($rs)){   		
	$commaseparatedlist = explode(',',$editlanguageList); 
	
	?> 
	<option value="<?php echo strip($languagelist['id']); ?>" <?php foreach($commaseparatedlist as $key => $value){ if($languagelist['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($languagelist['name']); ?></option> 
	<?php } ?> 
	</select> 
	</label> 
	</div>
	
	
	<!-- 
	 <div class="griddiv"><label>
	<div class="gridlable">Country </div>
	<select id="country" name="country" class="gridfield" onchange="selectState();">
	<option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='deletestatus=0 order by name'; 
$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
while($country=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($country['id']); ?>" <?php if($editCountry==$country['id']){ ?>selected="selected"<?php } ?>><?php echo strip($country['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	<script>
	
	function selectState(){
	var countryId = $('#country').val();  
	if(countryId==''){
	var countryId = '<?php echo $editCountry; ?>'; 
	}
	$('#state').load('loadstate.php?id='+countryId+'&selectId='<?php echo $editState; ?>);
	}
	
	function selectCity(){
	var stateId = $('#state').val();
	$('#city').load('loadcity.php?id='+stateId+'&selectId='<?php echo $editCity; ?>);
	}
	
 
	
	</script>
	
	<div class="griddiv"><label>
	<div class="gridlable">State</div> 
	<select id="state" name="state" class="gridfield" onchange="selectCity();">
	 
	 <option value="">Select</option>
		<?php
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		
		if($countryId!=''){
		$countryId=' and countryId="'.$editCountry.'" ';
		}
		
		$where=' deletestatus=0 and status=1 '.$countryId.' order by name asc';  
		$rs=GetPageRecord($select,_STATE_MASTER_,$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		
		?>
		<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editState){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
		<?php } ?>
	</select>
	</label>
	</div>
	
	 <div class="griddiv"><label>
	<div class="gridlable">City</div>
	<select id="city" name="city" class="gridfield" >
	 <option value="">Select</option>
	 <?php
	
	 
	/*$select=''; 
	$where=''; 
	$rs='';  
	$select='*'; 
	if($editState!=''){
	$stateId=' and stateId="'.$editState.'" ';
	}   
	echo $where=' deletestatus=0 and status=1 '.$stateId.' order by name asc';  
	$rs=GetPageRecord($select,_CITY_MASTER_,$where); 
	while($resListing=mysqli_fetch_array($rs)){ */ 
	
	?>
	<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editCity){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
	<?php /* }*/ ?>
	</select>
	<!--<input name="city" type="text" class="gridfield" id="city" value="<?php echo $editCity; ?>" maxlength="100" />
	<input name="state" type="text" class="gridfield" id="state" value="<?php echo $editState; ?>" maxlength="60" />
	</label>
	</div>
	
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Zip</div>
	<input name="zip" type="text" class="gridfield" id="zip" value="<?php echo $editZip; ?>" maxlength="15" />
	</label>
	</div>-->
	
		
	<div class="griddiv"> 
	<div class="gridlable">Destinations</div>
	<div style="padding:10px; overflow:auto; height:120px; border:1px #ccc solid;">
	  <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td colspan="2" align="center" style="border-bottom:1px #ccc solid;"> 
            <input name="select_all" type="checkbox" id="select_all" style="display: block;" value="checkbox" />         </td>
          <td width="94%" align="left" style="border-bottom:1px #ccc solid;">All Destinations</td>
        </tr>
     <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='deletestatus="0" and status=1 order by name'; 
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($destinationlist=mysqli_fetch_array($rs)){   
 
 $commaseparatedlist = explode(',',$editdestinationList);
?>
	    <tr>
          <td colspan="2" align="center" style="border-bottom:1px #ccc solid;"><input name="destinationList[]" type="checkbox" id="destinationListId"  class="checkBoxClass" style="display: block;" value="<?php echo $destinationlist['id']; ?>" <?php if (in_array($destinationlist['id'], $commaseparatedlist)) {  ?>checked="checked"<?php } ?> /></td>
          <td align="left" style="border-bottom:1px #ccc solid;"><?php echo $destinationlist['name']; ?></td>
        </tr>
		<?php } ?>
      </table>
	</div>
	</div>
	 
	
	<input name="idautoil" type="hidden" id="idautoil" value="<?php echo $editEmail; ?>" />	 </td>
  </tr>
</table>
<script> 
 
 
 <?php if($_GET['id']==''){ ?> 
	$(".checkBoxClass").prop('checked', true);
 <?php  } ?>


$('#select_all').click(function(event) {
  if(this.checked) {
      // Iterate each checkbox
      $(':checkbox').each(function() {
          this.checked = true;
      });
  }
  else {
    $(':checkbox').each(function() {
          this.checked = false;
      });
  }
});
</script>

</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="passwordvalidation();" /></td>
        <td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="passwordvalidation();"/></td>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
  <script>
  
  
  function passwordvalidation(){ 
  pass = document.getElementById("password").value;
  oldpass = document.getElementById("oldpassword").value;
  if(oldpass!='' && pass!=oldpass){
  
  regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#@$!%*?&])[A-Za-z\d#@$!%*?&]{8,}$/;
  if (regex.exec(pass) == null) {
    var msg='Password must be alphanumeric, uppercase letter, special character(@$!%*?&) and greater than 8 characters...!';
	var header='System Alert!';
	alertbox(header,msg);
	$("#password").focus(); 
    return false; 
  }
  else {
    formValidation('addeditfrm','submitbtn','1');
  }
  }else{
  formValidation('addeditfrm','submitbtn','1');
  }
 	
	
	
	if(oldpass==''){
  
  regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/; 
  if (regex.exec(pass) == null) {
    var msg='Password must be alphanumeric, uppercase letter, special character(@$!%*?&) and greater than 8 characters...!';
	var header='System Alert!';
	alertbox(header,msg);
	$("#password").focus(); 
    return false; 
  }
  else {
    formValidation('addeditfrm','submitbtn','1');
  }
  }else{
  formValidation('addeditfrm','submitbtn','1');
  }
   
  
 
   }
  
  </script>
</table>
</div>

<?php }   ?>
</form>
 
</div>
<script>  
comtabopenclose('linkbox','op2');
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
