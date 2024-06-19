<?php
include "inc.php";  

if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!='' && $_REQUEST['supplierId']!='')
{
$namevalue ='voucherid="'.$_REQUEST['voucherid'].'",supplierId="'.$_REQUEST['supplierId'].'",fromDate="'.date('Y-m-d',strtotime($_REQUEST['fromDate'])).'",toDate="'.date('Y-m-d',strtotime($_REQUEST['toDate'])).'" ';
$add = addlisting(_VOUCHER_SUPPLIER_DATA_,$namevalue); 
}

if($_REQUEST['voucherid']!='' && $_REQUEST['vids']!='' && $_REQUEST['action']=='delete')
{
 mysqli_query(db(),"delete from "._VOUCHER_SUPPLIER_DATA_." where id=".$_REQUEST['vids']." and voucherid=".$_REQUEST['voucherid']." ");
}


$select152='queryId';  
$where12='voucherId='.$_REQUEST['voucherid']; 
$rs12=GetPageRecord($select152,_VOUCHER_LIST_MASTER_,$where12); 
$getqueryId=mysqli_fetch_array($rs12);

$userQueryId=$getqueryId['queryId'];



$select67='*';
$where67='voucherid='.$_REQUEST['voucherid'].'  order by fromDate asc';

$rs67=GetPageRecord($select67,_VOUCHER_SUPPLIER_DATA_,$where67); 
while($getdatasup=mysqli_fetch_array($rs67))
{


$id=$getdatasup['supplierId'];
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editassignTo=clean($editresult['assignTo']); 
$editname=clean($editresult['name']); 
$editcontactPerson=clean($editresult['contactPerson']);
$editcompanyTypeId=clean($editresult['companyTypeId']);
$editcountryId=clean($editresult['countryId']);
$editstateId=clean($editresult['stateId']); 
$editcityId=clean($editresult['cityId']); 
$edittitle=clean($editresult['title']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']); 
$editaddress1=clean($editresult['address1']);  
$editaddress2=clean($editresult['address2']);  
$editaddress3=clean($editresult['address3']);  
$editpinCode=clean($editresult['pinCode']);
$editgstn=clean($editresult['gstn']);
$editagreement=clean($editresult['agreement']);
$editid=clean($editresult['id']);
$companyTypeId=clean($listofsuppliers['companyTypeId']);
$suppliername=clean($listofsuppliers['suppliername']);
$compsuppliername=clean($listofsuppliers['compsuppliername']);
$supplierMainType=clean($editresult['supplierMainType']);



?>

<div style="padding:10px; background-color:#FFFFFF; margin-bottom:10px;">
<table border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
 <?php
 if($getdatasup['supplierId']!='' && $getdatasup['supplierId']!=0)
 {
 ?> <tr>
    <td align="left" valign="top" class="lightgraytextm">Services Type </td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top">
	<?php  
	if($getdatasup['companyTypeId']!=0){
	$select1='*';  
$where1='id='.$getdatasup['companyTypeId']; 
$rs1=GetPageRecord($select1,_SUPPLIERS_TYPE_MASTER_,$where1); 
$getroom=mysqli_fetch_array($rs1);
echo strip($getroom['name']);}  ?>	</td>
    <td align="left" valign="top">&nbsp;&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm"><span class="gridlable">Supplier</span></td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td colspan="5" align="left" valign="top"><?php echo $editname; ?>&nbsp;&nbsp;&nbsp;</td>
    </tr>
  <tr>
    <td align="left" valign="top" class="lightgraytextm">Contact No.</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><span class="lightgraytextm"><?php echo getPrimaryPhone($editid,'suppliers'); ?></span></td>
    <td align="left" valign="top">&nbsp;&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">Address</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td colspan="5" align="left" valign="top"><?php  
	if($listofsuppliers['supplierstateId']!=0){
	$select1='*';  
$where1='stateId='.$listofsuppliers['supplierstateId'].' and addressParent='.$editid.' and addressType="supplier"'; 
$rs1=GetPageRecord($select1,_ADDRESS_MASTER_,$where1); 
$addressSup=mysqli_fetch_array($rs1);  ?>
      <?php echo $addressSup['address']; ?>, <?php echo getCityName($addressSup['cityId']); ?>, <?php echo getStateName($addressSup['stateId']); ?>, <?php echo $addressSup['pinCode']; ?> <?php echo getCountryName($addressSup['countryId']); 
 
 } else { ?> <?php echo $editaddress1; ?>
      <?php } ?></td>
    </tr>
  <?php }?>
   <?php
 if($getdatasup['companyTypeId']==1)
 {
 ?>
  <tr>
    <td align="left" valign="top" class="lightgraytextm">Check In </td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php echo $getdatasup['fromDate']; ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">Check Out </td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td colspan="5" align="left" valign="top"><?php echo $getdatasup['toDate']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="top" class="lightgraytextm">Room Type</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php  
	if($getdatasup['roomType']!=0){
	$select1='*';  
$where1='id='.$getdatasup['roomType']; 
$rs1=GetPageRecord($select1,_ROOM_TYPE_MASTER_,$where1); 
$getroom=mysqli_fetch_array($rs1);
echo strip($getroom['name']);}  ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">SUP Confirmation No.</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td colspan="5" align="left" valign="top"><?php echo $getdatasup['supConfirmationNo']; ?>&nbsp;</td>
    </tr>
  <tr>
    <td align="left" valign="top" class="lightgraytextm">Inclision</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php  
	
	
	
	$string = preg_replace('/\.$/', '', $getdatasup['amenitiesList']);
	
	 $array = explode(',', $string); 
	  foreach($array as $value)
	   { 
	   if($value!=''){
		$select1='*';  
$where1='id='.$value; 
$rs1=GetPageRecord($select1,_AMENITIES_MASTER_,$where1); 
$getroom=mysqli_fetch_array($rs1); ?>
<div style="background-color:#F2F2F2; border:1px #CCCCCC solid; padding:5px 10px; margin-right:5px; float:left; margin-bottom:5px; ">
<?php echo strip($getroom['name']); ?></div>
<?php 		
		}
		
		}
	
	
	
	 ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">Special Request.</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td colspan="5" align="left" valign="top"><?php echo $getdatasup['specialrequest']; ?>&nbsp;</td>
    </tr>
  <?php }?>
   <?php
 if($getdatasup['companyTypeId']==2)
 {
 ?>
  <tr>
    <td align="left" valign="top" class="lightgraytextm">Flight Name</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php echo $getdatasup['flightName']; ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">Flight No.</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php echo $getdatasup['flightNumber']; ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">Flight Date</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php echo $getdatasup['flightDate']; ?></td>
  </tr>
  
  <?php }?>
  <?php
 if($getdatasup['companyTypeId']==10)
 {
 ?>
  <tr>
    <td align="left" valign="top" class="lightgraytextm">Transfer Type</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php  
	if($getdatasup['transferId']!=0){
	$select1='*';  
$where1='id='.$getdatasup['transferId']; 
$rs1=GetPageRecord($select1,_TRANSFER_MASTER_,$where1); 
$getroom=mysqli_fetch_array($rs1);
echo strip($getroom['name']);}  ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">Transfer Date</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php echo $getdatasup['transferDate']; ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  
  <?php }?>
  <?php
 if($getdatasup['companyTypeId']==11)
 {
 ?>
  <tr>
    <td align="left" valign="top" class="lightgraytextm">Sightseeing&nbsp;Type</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td align="left" valign="top"><?php  
	if($getdatasup['sightseeingId']!=0){
	$select1='*';  
$where1='id='.$getdatasup['sightseeingId']; 
$rs1=GetPageRecord($select1,_SIGHTSEEING_MASTER_MASTER_,$where1); 
$getroom=mysqli_fetch_array($rs1);
echo strip($getroom['name']);}  ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="lightgraytextm">Sightseeing Date</td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td colspan="5" align="left" valign="top"><?php echo $getdatasup['sightseeingDate']; ?>&nbsp;<?php echo $getdatasup['sightSeeingTime']; ?></td>
    </tr>
  
  <?php }?>
</table>
<input type="hidden" name="dmcHotel<?php echo clean($_REQUEST['voucherid']); ?>" id="dmcHotel<?php echo clean($_REQUEST['voucherid']); ?>" value="<?php echo $editid; ?>">

<div style="text-align:center; margin-top:10px; margin-bottom:10px;"><a href="#" style="text-align:center; padding:10px; border:1px #CC0000 dashed; display:block; color:#CC0000; text-decoration:none; font-size:13px;" onclick="$('#dmchotel<?php echo $_REQUEST['voucherid']; ?><?php echo $_REQUEST['mainsupplierId']; ?>').load('loaddmchotel.php?voucherid=<?php echo $_REQUEST['voucherid']; ?>&vids=<?php echo $getdatasup['id']; ?>&action=delete&mainsupplierId=<?php echo $_REQUEST['mainsupplierId']; ?>');" >Remove</a></div></div>
<?php 
}
 ?>


<div style="text-align:center;"><input name="addnewuserbtn2" type="button" class="greenbuttonx2" id="addnewuserbtn2" value="Add Services" style="margin-right:10px;"  onclick="$('#dmchotel<?php echo $_REQUEST['voucherid']; ?><?php echo $_REQUEST['mainsupplierId']; ?>').load('loadalertbox.php?action=selectSupplier&voucherid=<?php echo clean($_REQUEST['voucherid']); ?>&userQueryId=<?php echo $userQueryId; ?>&night=1&suppliermainhotel=1&mainsupplierId=<?php echo $_REQUEST['mainsupplierId']; ?>');"></div>
