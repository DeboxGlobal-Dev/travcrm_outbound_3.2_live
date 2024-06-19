<?php 



if($loginuserID!=''){

  $id=$loginuserID;



$select1='*';  

$where1='id='.$id.''; 

$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 

$editresult=mysqli_fetch_array($rs1);



$editfirstName=clean($editresult['firstName']);

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

$editcompany=clean($editresult['company']);

$editcurrency=clean($editresult['currency']);

$edittimeZone=clean($editresult['timeZone']);

$emailsignature=stripslashes($editresult['emailsignature']);

$sessionTime=clean($editresult['sessionTime']);

}

?>



<script src="tinymce/tinymce.min.js"></script>



<script type="text/javascript">



    tinymce.init({
        selector: "#emailsignature",
        themes: "modern",   
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen" ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });



    </script>

<link href="css/main.css" rel="stylesheet" type="text/css" />

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td><div class="headingm"><span id="topheadingmain">Update Personal Settings</span></div></td>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td>        </td>

        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>

         <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton"  onclick="setupbox('setupsetting.crm?module=personalsettings');"  /></td>

      </tr>

      

    </table></td>

  </tr>

  

</table>

</div>



<div id="pagelisterouter">

<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post">

<div class="addeditpagebox">

  <input name="action" type="hidden" id="action" value="savepersonalsetting" />

   

   

  <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td colspan="2" align="left" valign="top" ></td>

    </tr>

  <tr>

    <td width="50%" align="left" valign="top" style="padding-right:20px;">

	<?php if($loginuseradmin==1){ ?>

	<div class="griddiv">

	<label>

	<div class="gridlable">Company Name<span class="redmind"></span>  </div>

	<input name="company" type="text" class="gridfield validate" id="company" value="<?php echo $editcompany; ?>" maxlength="60" displayname="Company" autocomplete="off" />

	</label>

	</div>

	

	

	<?php } ?>

	

	

	<div class="griddiv">

	<label>

	<div class="gridlable">First Name<span class="redmind"></span></div>

	<input name="firstName" type="text" class="gridfield validate" id="firstName" value="<?php echo $editfirstName; ?>" maxlength="60" displayname="First Name" autocomplete="off" />

	</label>

	</div>

	

	<div class="griddiv">

	<label>

	<div class="gridlable">Last Name</div>

	<input name="lastName" type="text" class="gridfield" id="lastName" value="<?php echo $editlastName; ?>" maxlength="60" displayname="Last Name" autocomplete="off" />

	</label>

	</div>

	<div class="griddiv"><label><div class="gridlable">Email</div>

	<input name="email" type="email"  class="gridfield validate" id="email" value="<?php echo $editEmail; ?>" displayname="Email" autocomplete="off" disabled="disabled" />

	</label>

	</div>

	

	  

	<div class="griddiv">

	<label>

	 

	<div class="gridlable">Role  </div> 

	<input name="roleidname" type="text" class="gridfield validate"  disabled="disabled" readonly="true"  id="roleidname" value="<?php if($editroleId!=''){  $select=''; 

$where=''; 

$rs='';  

$select='*';   

$where='id='.$editroleId.' order by name'; 

$rs=GetPageRecord($select,_ROLE_MASTER_,$where); 

while($timeformat=mysqli_fetch_array($rs)){  

echo strip($timeformat['name']);

} }

?>" maxlength="60" displayname="Role Name" autocomplete="off" />

	 

	 

 

 </label>

	</div>

	

	

	<div class="griddiv">

	<label>

	<div class="gridlable">Profile  </div>

	<select id="profileId" name="profileId" class="gridfield" displayname="Profile" autocomplete="off"  disabled="disabled" >

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



?>

<option value="<?php echo strip($timeformat['id']); ?>" <?php if($timeformat['id']==$editprofileId){ ?>selected="selected"<?php } ?>><?php echo strip($timeformat['profileName']); ?></option>

<?php } ?>

</select></label>

	</div>

	<div class="griddiv"><label>

	<div class="gridlable">Phone</div>

	<input name="phone" type="text" class="gridfield" id="phone" value="<?php echo $editPhone; ?>" maxlength="15" />

	</label>

	</div>

	<div class="griddiv"><label>

	<div class="gridlable">Mobile</div>

	<input name="mobile" type="text" class="gridfield" id="mobile" value="<?php echo $editMobile; ?>" maxlength="15" />

	</label>

	</div>	</td>

    <td width="50%" align="left" valign="top" style="padding-left:20px;">

	

	<?php if($loginuseradmin==1){ ?>

	<div class="griddiv">

	<label>

	<div class="gridlable">Currency </div> 

	<select id="currency" name="currency" class="gridfield">

 <?php 

$select=''; 

$where=''; 

$rs='';  

$select='*';   

$where='id!="" order by name'; 

$rs=GetPageRecord($select,_CURRENCY_MASTER_,$where); 

while($currency=mysqli_fetch_array($rs)){  

?>

<option value="<?php echo strip($currency['id']); ?>" <?php if($currency==$editcurrency){ ?>selected="selected"<?php } ?>><?php echo strip($currency['name']); ?></option>

<?php } ?>

</select>

	</label>

	</div>

	<div class="griddiv">

	<label>

	<div class="gridlable">Time Zone </div>

	<select id="timezone" name="timezone" class="gridfield">

 <?php 

$select=''; 

$where=''; 

$rs='';  

$select='*';   

$where='id!="" order by name'; 

$rs=GetPageRecord($select,_TIMEZONE_MASTER_,$where); 

while($timezone=mysqli_fetch_array($rs)){  

?>

<option value="<?php echo strip($timezone['id']); ?>" <?php if($timezone==$edittimeZone){ ?>selected="selected"<?php } ?>><?php echo strip($timezone['name']); ?></option>

<?php } ?>

</select></label>

	</div>

	<?php }  ?>

	

	

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

	<div class="griddiv"><label>

	<div class="gridlable">Street</div>

	<input name="street" type="text" class="gridfield" id="street" value="<?php echo $editStreet; ?>" maxlength="60" />

	</label>

	</div>

	 
	<!--<div class="griddiv"><label>

	<div class="gridlable">Country</div>

	<select id="country" name="country" class="gridfield">

	<option value="">Select</option>

 <?php 

$select=''; 

$where=''; 

$rs='';  

$select='*';   

$where='id!="" order by name'; 

$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 

while($country=mysqli_fetch_array($rs)){  

?>

<option value="<?php echo strip($country['id']); ?>" <?php if($editCountry==$country['id']){ ?>selected="selected"<?php } ?>><?php echo strip($country['name']); ?></option>

<?php } ?>

</select></label>

	</div>-->
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
	
	 
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*'; 
	if($editState!=''){
	$stateId=' and stateId="'.$editState.'" ';
	}   
	echo $where=' deletestatus=0 and status=1 '.$stateId.' order by name asc';  
	$rs=GetPageRecord($select,_CITY_MASTER_,$where); 
	while($resListing=mysqli_fetch_array($rs)){  
	
	?>
	<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editCity){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
	<?php } ?>
	</select>
	<!--<input name="city" type="text" class="gridfield" id="city" value="<?php echo $editCity; ?>" maxlength="100" />
	<input name="state" type="text" class="gridfield" id="state" value="<?php echo $editState; ?>" maxlength="60" />-->
	</label>
	</div>
	
    <!--<div class="griddiv"><label>

	<div class="gridlable">City</div>

	<input name="city" type="text" class="gridfield" id="city" value="<?php echo $editCity; ?>" maxlength="100" />

	</label>

	</div>-->

	
<!--
	<div class="griddiv"><label>

	<div class="gridlable">State</div>

	<input name="state" type="text" class="gridfield" id="state" value="<?php echo $editState; ?>" maxlength="60" />

	</label>

	</div>-->

	

	<div class="griddiv"><label>

	<div class="gridlable">Zip</div>

	<input name="zip" type="text" class="gridfield" id="zip" value="<?php echo $editZip; ?>" maxlength="15" />

	</label>

	</div>

	

		

	

	<input name="idautoil" type="hidden" id="idautoil" value="<?php echo $editEmail; ?>" />	

	

	

	<?php if($loginuseradmin==1){ ?>

	<div class="griddiv">

	<label>

	<div class="gridlable">Session Time (Min.)<span class="redmind"></span>  </div>

	<input name="sessionTime" type="text" class="gridfield validate" id="sessionTime" value="<?php echo $sessionTime; ?>" maxlength="60" displayname="Session Time" autocomplete="off" />

	</label>

	</div>

	

	

	<?php } ?>

	 </td>

  </tr>

  <tr>

    <td align="left" valign="top" style="padding-right:20px; padding-bottom:10px;">Email Signature</td>

    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="2" align="left" valign="top"  ><textarea name="emailsignature" rows="10"  id="emailsignature"><?php echo $emailsignature; ?></textarea></td>

    </tr>

</table>





</div>



<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td>        </td>

        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>

         <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton"  onclick="setupbox('setupsetting.crm?module=personalsettings');"  /></td>

      </tr>

      

    </table></td>

  </tr>

  

</table>

</div>

</form>

 

</div>

<script>  

comtabopenclose('linkbox','op1');

</script>

