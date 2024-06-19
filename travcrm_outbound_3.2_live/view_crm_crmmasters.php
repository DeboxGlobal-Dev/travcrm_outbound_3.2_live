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

}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td><?php echo $editComapnyanme; ?></td>
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
    <td width="50%" align="left" valign="top" style="padding-right:20px;"><div class="innerbox"><h2>CRM Account Information</h2></div>
	<div class="griddiv">
	  <div class="gridlable">User Id</div> 
	<div class="gridtext"><?php echo $accountId; ?></div>
	</label>
	</div>
	
	<div class="griddiv">
	<label><div class="gridlable">Company Name</div> 
	<div class="gridtext"><?php echo $editComapnyanme; ?></div>
	</label>
	</div>
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
	
	<div class="griddiv"><label>
	<div class="gridlable">Street</div>
		<div class="gridtext"><?php echo $editStreet; ?></div>
	</label>
	</div>
	 
	 
	 <div class="griddiv"><label>
	<div class="gridlable">City</div>
	<div class="gridtext"><?php echo $editCity; ?></div> 
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">State</div>
	<div class="gridtext"><?php echo $editState; ?></div>  
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
while($country=mysqli_fetch_array($rs)){  
?>
 <?php echo strip($country['name']); ?>
<?php } ?> </div>
	 </label>
	</div>	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"><div class="innerbox">
      <h2>Users / Account Validity  Information </h2>
    </div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Users Limit </div>
	<div class="gridtext"><?php echo $editNoofusers; ?></div>
		</label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Server Space (MB)</div>
	<div class="gridtext"><?php echo $editServerspace; ?></div>
		</label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Expiry Date</div>
	<div class="gridtext"><?php if($editExpireDate!=''){ echo date("d-m-Y", strtotime($editExpireDate)); } ?><?php if($editExpireDate<date('Y-m-d') || $editExpireDate==date('Y-m-d')){ ?><div class="statusdeactive" style="position:absolute; right:0px; font-size:12px; top:0px;">Expired</div><?php }  ?></div> </label>
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
	<div class="griddiv">
	  <div class="gridlable">Currency </div> 
	<div class="gridtext"><?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id="'.$editCurrency.'" order by name'; 
$rs=GetPageRecord($select,_CURRENCY_MASTER_,$where); 
while($currency=mysqli_fetch_array($rs)){  
?>
<?php echo strip($currency['name']); ?>
<?php } ?></div>
	 
	</label>
	</div>
	<div class="griddiv">
	<label><div class="gridlable">Time Zone </div>
	<div class="gridtext">
	<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id="'.$editTimezone.'" order by name'; 
$rs=GetPageRecord($select,_TIMEZONE_MASTER_,$where); 
while($timezone=mysqli_fetch_array($rs)){  
?>
<?php echo strip($timezone['name']); ?> 
<?php } ?>
	</div> </label>
	</div>
	
	
 	
	
	<div class="griddiv"><label>
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
	<?php } ?>	 </td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Administrator Permissions</h2>
	
	  <div class="addboxmid" <?php if($editpermission==1){ ?> onclick="permissions('<?php echo $_GET['id']; ?>');"<?php } ?>>

<?php
$select='*';
$where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$editUserId.' and status=1) order by sr asc'; 
$rs=GetPageRecord($select,_MODULE_MASTER_,$where); 
while($modulelists=mysqli_fetch_array($rs)){
?>
	<div class="pbox"><?php echo $modulelists['moduleName']; ?></div>
	<?php } ?>
	   </div>
	</div></td>
    </tr>
</table>


</div>

  
 
</div>
<script>  
comtabopenclose('linkbox','op4');
</script>
