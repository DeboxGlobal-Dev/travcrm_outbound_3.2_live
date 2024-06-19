<?php 

if($loginuserID!=''){
 $id=$loginuserID;

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editUserId=clean($editresult['id']);
$editComapnyanme=clean($editresult['company']);
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
$loginuserprofilePhoto=clean($editresult['profilePhoto']);
$editcurrency=clean($editresult['currency']);
$edittimeZone=clean($editresult['timeZone']);
}



 
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Personal Settings</td>
  </tr>
  
</table>
</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="setupbox('setupsetting.crm?module=editpersonalsettings');" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
 <div class="addeditpagebox vieweditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" > 
	<div style="margin-bottom:30px; position:relative;">
	<div style=" position:absolute;position:absolute; right: 114px;"><input type="button" name="Submit2" value="Change Password" class="whitembutton" onclick="alertspopupopen('action=changepassword','450px','auto');" ></div>
	<?php 
 if($_SESSION['userid']==37){ 
	 ?>
	<div style="position:absolute;position:absolute; right:0px;"><input type="button" name="Submit2" value="Change PIN" class="whitembutton" onclick="alertspopupopen('action=changePIN','450px','auto');" ></div><?php } ?>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="9%" align="center" valign="top" style="position:relative;">
		  <form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post" enctype="multipart/form-data" onsubmit="startloading();">
		  <input name="changeprofilepic[]" type="file" id="changeprofilepic" accept="image/x-png,image/gif,image/jpeg" onchange="$('#addeditfrm').submit();" style="width:100%; height:100%; position:absolute; left:0px; top:0px;opacity: 0; filter: alpha(opacity=0); cursor:pointer; "/><input name="action" type="hidden" id="action" value="profilepic" />
		  <div style="width:100px; height:100px; overflow:hidden;border-radius: 100%;"><img src="<?php if($loginuserprofilePhoto!=''){ ?>profilepic/<?php echo $loginuserprofilePhoto; ?><?php } else { ?>images/user.png<?php } ?>" width="100%" /></div><div style="text-align:center; font-size:11px; margin-top:2px;"><a  >Change</a></div>
		  
		  </form>
		  </td>
          <td width="91%" align="left" valign="top" style="padding-left:15px;">
		  <div style="margin-bottom:10px; margin-top:20px; font-size:18px;"><?php echo $editfullname; ?> <span style="padding:2px 10px; margin-left:10px; border:1px #CCCCCC solid; font-size:12px;border-radius: 3px;"><?php 
$select='profileName';  
$where='id="'.$editprofileId.'"'; 
$rs=GetPageRecord($select,_PROFILE_MASTER_,$where); 
$res=mysqli_fetch_array($rs);
echo strip($res['profileName']); 
?></span></div>
		  <!-- <div style="margin-bottom:10px; font-size:13px;"><?php 
$select='name';  
$where='id="'.$editroleId.'"'; 
$rs=GetPageRecord($select,_ROLE_MASTER_,$where); 
$res=mysqli_fetch_array($rs);
echo strip($res['name']); 
?> at <?php echo $Logintimeuserzone['company']; ?></div> -->
		  </td>
        </tr>
      </table>
	</div>
	</td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	 
	
	 
	<div class="griddiv"><label><div class="gridlable">Email</div>
	<div class="gridtext"><?php echo $editEmail; ?></div>
	 
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
<?php if($loginuseradmin==1){ ?>	<div class="griddiv"><div class="gridlable">Currency </div><div class="gridtext"> 
	
<?php 
$select='name';  
$where='id="'.$editcurrency.'"'; 
$rs=GetPageRecord($select,_CURRENCY_MASTER_,$where); 
$res=mysqli_fetch_array($rs);
echo strip($res['name']); 
?></div>
	 </label>
	</div>
	
	
	 <div class="griddiv"><div class="gridlable">Time Zone </div><div class="gridtext"> 
	
<?php 
$select='name';  
$where='id="'.$edittimeZone.'"'; 
$rs=GetPageRecord($select,_TIMEZONE_MASTER_,$where); 
$res=mysqli_fetch_array($rs);
echo strip($res['name']); 
?></div>
	 </label>
	</div><?php } ?>
	
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
	<div class="gridlable">Street</div>
		<div class="gridtext"><?php echo $editStreet; ?></div>
	</label>
	</div>
	 
	 
	 <div class="griddiv"><label>
	<div class="gridlable">City</div>
	<div class="gridtext"><?php 
		$where=' id= "'.$editCity.'" order by name asc';  
		$rs=GetPageRecord($select,_CITY_MASTER_,$where); 
		$resListing=mysqli_fetch_array($rs);
		echo $resListing['name']; 
	?></div> 
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">State</div>
	<div class="gridtext"><?php 
		$where=' id= "'.$editState.'" order by name asc';  
		$rs=GetPageRecord($select,_STATE_MASTER_,$where); 
		$resListing=mysqli_fetch_array($rs);
		echo $resListing['name']; 
		?></div>  
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Zip</div>
	<div class="gridtext"><?php echo $editZip; ?></div> 
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Country</div>
	<div class="gridtext"> <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id="'.$editCountry.'" order by name'; 
$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
$country=mysqli_fetch_array($rs);

echo  strip($country['name']);
 ?>
 </div>
	 </label>
	</div>	 
	
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> 
	
	
	
	
	 	
 	 </td>
  </tr>
</table>


</div>

  
 
</div>
<script>  
comtabopenclose('linkbox','op1');
</script>
