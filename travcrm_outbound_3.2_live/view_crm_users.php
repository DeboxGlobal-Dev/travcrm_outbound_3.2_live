<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}



if($_GET['id']!=''){
 $id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editUserId=clean($editresult['id']);
$editComapnyanme=clean($editresult['company']);
$usercode=clean($editresult['usercode']);
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
$timeFormat=clean($editresult['timeFormat']);
$editCurrency=clean($editresult['currency']);
$editTimezone=clean($editresult['timeZone']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']);
$dateAdded=clean($editresult['dateAdded']);
$addedBy=clean($editresult['addedBy']);
$accountId=clean($editresult['accountId']);
$editfirstName=clean($editresult['firstName']);
$editlastName=clean($editresult['lastName']);
$editfullname=$editfirstName.' '.$editlastName;
$accountId=clean($editresult['accountId']);
$editroleId=clean($editresult['roleId']);
$editprofileId=clean($editresult['profileId']);
$edituserType=clean($editresult['userType']);
$editlanguageList=clean($editresult['languagelist']);
$editdestinationList=clean($editresult['destinationList']);
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td><?php echo $editfullname; ?></td>
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

<div id="pagelisterouter">
 <div class="addeditpagebox vieweditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox"><h2>CRM Account Information</h2></div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv">
	  <div class="gridlable">User Code</div> 
	<div class="gridtext"><?php echo $usercode; ?></div>
	</label>
	</div>
	
	<div class="griddiv">
	  <div class="gridlable">Full Name</div> 
	<div class="gridtext"><?php echo $editfullname; ?></div>
	</label>
	</div>
	
	 
	<div class="griddiv"><label><div class="gridlable">Email</div>
	<div class="gridtext"><?php echo $editEmail; ?></div>
	 
	</label>
	</div>
	
	  <div class="griddiv"><div class="gridlable">Role </div><div class="gridtext"> 
	
<?php 
$select='name';  
$where='id="'.$editroleId.'"'; 
$rs=GetPageRecord($select,_ROLE_MASTER_,$where); 
$res=mysqli_fetch_array($rs);
echo strip($res['name']); 
?></div>
	 </label>
	</div>
	
	<div class="griddiv">
	  <div class="gridlable">Profile </div>
	  <div class="gridtext"> 
	
<?php 
$select='profileName';  
$where='id="'.$editprofileId.'"'; 
$rs=GetPageRecord($select,_PROFILE_MASTER_,$where); 
$res=mysqli_fetch_array($rs);
echo strip($res['profileName']); 
?></div>
	 </label>
	</div>
	
	<div class="griddiv">
	  <div class="gridlable">Reporting Manager </div>
	  <div class="gridtext"> 
	
<?php 
$select='*';  
$where='id="'.$editresult['reportingManager'].'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$res=mysqli_fetch_array($rs);
echo strip($res['firstName'].' '.$res['lastName']); 
?></div>
	 </label>
	</div>
	
	
	<div class="griddiv"><div class="gridlable">Time Format </div><div class="gridtext"> 
	
<?php 
$select='name';  
$where='id="'.$timeFormat.'"'; 
$rs=GetPageRecord($select,_TIMEFORMAT_MASTER_,$where); 
$res=mysqli_fetch_array($rs);
echo strip($res['name']); 
?></div>
	 </label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Phone</div>
	<div class="gridtext"><?php echo $editPhone; ?></div> 
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Mobile</div>
	<div class="gridtext"><?php echo $editMobile; ?></div>  
	</label>
	</div>
	
		<div class="griddiv"><label>
		<div class="gridlable">User Type </div>
		<div class="gridtext"><?php if($edituserType=='0' || $edituserType==''){ echo 'Sales Person'; } if($edituserType=='1'){ echo 'Operations Person'; }  if($edituserType=='2'){ echo 'Account Manager'; }
		if($edituserType=='5'){ echo 'Finance'; }
		?></div>  
		</label>
		</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Destinations </div>
	<div class="gridtext">
	
	<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='deletestatus="0" and status=1 order by name'; 
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($destinationlist=mysqli_fetch_array($rs)){   
 
 $commaseparatedlist = explode(',',$editdestinationList);
  if (in_array($destinationlist['id'], $commaseparatedlist)) { echo $destinationlist['name'].', '; } 
   } ?>
	</div>  
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Language&nbsp;Known</div>
	<div class="gridtext">
	
	<?php 
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';   
	$where='deletestatus="0" order by name'; 
	$rs=GetPageRecord($select,'tbl_languagemaster',$where); 
	while($languagelist=mysqli_fetch_array($rs)){   
	
	$commaseparatedlist = explode(',',$editlanguageList);
	if (in_array($languagelist['id'], $commaseparatedlist)) { 
		echo $languagelist['name'].', '; } 
	} 
	?>
	</div>  
	</label>
	</div>
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> 
	
	
	<!--<div class="griddiv"><label>
	<div class="gridlable">Street</div>
		<div class="gridtext"><?php echo $editStreet; ?></div>
	</label>
	</div>
	 
	 
	 <div class="griddiv"><label>
	<div class="gridlable">City</div>
	<div class="gridtext"><?php echo getCityName($editCity); ?></div> 
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">State</div>
	<div class="gridtext"><?php echo getStateName($editState); ?></div>  
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Zip</div>
	<div class="gridtext"><?php echo $editZip; ?></div> 
	</label>
	</div>-->
	
	<div class="griddiv"><label>
	<div class="gridlable">Country</div>
	<div class="gridtext"> <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id="'.$editCountry.'" order by name'; 
$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
while($country=mysqli_fetch_array($rs)){  
?>
 <?php echo strip($country['name']); ?>
<?php } ?> </div>
	 </label>
	</div>	<div class="griddiv"><label>
	<div class="gridlable">Created By </div>
		<div class="gridtext"><?php 
$select=''; 
$where=''; 
$rs='';  
$select='firstName,lastName';   
$where='id="'.$addedBy.'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($userss=mysqli_fetch_array($rs)){  

echo $userss['firstName'].' '.$userss['lastName'];

}
?><div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($dateAdded,$loginusertimeFormat);?></div>
</div>
	</label>
	</div>
	
	 	
	<?php if($modifyDate!='0'){ ?>
	<div class="griddiv"><label>
	<div class="gridlable">Modified By </div>
		<div class="gridtext"><?php 
$select=''; 
$where=''; 
$rs='';  
$select='firstName,lastName';   
$where='id="'.$modifyBy.'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($userss=mysqli_fetch_array($rs)){  

echo $userss['firstName'].' '.$userss['lastName'];

}
?>
<div style="font-size:12px; margin-top:2px; color:#999999;"><?php if($modifyDate!='0'){ echo showdatetime($modifyDate,$loginusertimeFormat); } ?></div>
</div>
	</label>
	</div>
	<?php } ?>		 </td>
  </tr>
</table>


</div>

  
 
</div>
<script>  
comtabopenclose('linkbox','op2');
</script>
