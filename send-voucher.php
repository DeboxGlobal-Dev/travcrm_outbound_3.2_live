<?php 
ob_start();
include "inc.php";   

 

if($_GET['id']!='' && is_numeric(decode($_GET['id']))){ 

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean(decode($_GET['id'])); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_VOUCHER_MASTER_,$where); 
$resultInvoice=mysqli_fetch_array($rs); 

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=1; 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_VOUCHER_SETTING_MASTER_,$where); 
$resultvouchersetting=mysqli_fetch_array($rs); 



$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean($resultInvoice['queryId']); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultQuery=mysqli_fetch_array($rs);  


$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,_VOUCHER_LIST_MASTER_,$where); 
$resultInvoiceSetting=mysqli_fetch_array($rs);  



$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$resultInvoiceSettingLogo=mysqli_fetch_array($rs); 

}

if($resultQuery['clientType']==1){
$select4='*';  
$where4='id='.$resultQuery['companyId'].''; 
$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 
$resultCompany=mysqli_fetch_array($rs4); 
$mobilemailtype='corporate';
}

if($resultQuery['clientType']==2){
$select4='*';  
$where4='id='.$resultQuery['companyId'].''; 
$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4); 
$resultCompany=mysqli_fetch_array($rs4); 
$mobilemailtype='contacts';
}


$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$resultInvoiceSetting=mysqli_fetch_array($rs);  
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice - INV-<?php echo str_pad($resultInvoice['id'], 6, '0', STR_PAD_LEFT); ?></title> 
 <style>
 #invoicearea .table {
    border: solid #ccc !important;
    border-width:1px !important;
}
#invoicearea .td {
    border: solid #ccc !important;
    border-width:1px !important;
}
 </style>
</head>

<body style="background-color:#FFFFFF; <?php if($_REQUEST['download']==1){ ?>padding: 0px; margin: 0px;<?php } ?>">
<table width="850" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#202630" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif; <?php if($_REQUEST['download']==1){ ?>    width: 100%; border: 0px;  border-color: #fff;<?php } ?>">
  <tr>
    <td colspan="3"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="3" align="left" valign="top" style="background-image:url(<?php echo $fullurl; ?>images/invoicerighttopimg.png); background-repeat:no-repeat; background-position:right top;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2" style="padding:10px;"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSettingLogo['logo']; ?>" height="45" /></td>
            <td width="43%" align="left" style="color:#000; font-size:20px; margin-right:12px; padding:10px;">Booking ID: <?php echo makeQueryId($resultInvoice['queryId']); ?></td>
            <td width="44%" align="right" style="color:#000; font-size:20px; margin-right:12px; padding:10px;"><strong>Voucher</strong></td>
          </tr>
          
        </table></td>
        </tr>
      <tr> 
      </tr>
	  
	  <tr>
        <td colspan="3" align="left" valign="top">
   
		<div style="margin-bottom:10px; border:0px #CCCCCC solid; margin-left:5px; margin-right:5px; margin-top:0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
        
		<?php
$thisid='1';
$tpaybill='0'; 
$select2='*';
$where2='voucherId='.clean($resultInvoice['id']).' group by supplierId order by companyTypeId'; 
$rs2=GetPageRecord($select2,_VOUCHER_LIST_MASTER_,$where2); 
while($listofsuppliers=mysqli_fetch_array($rs2)){


$dmcHotel=$listofsuppliers['dmcHotel'];
$isHotel=$listofsuppliers['companyTypeId'];

if($listofsuppliers['supplierId']!=''){
$id=$listofsuppliers['supplierId'];

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
$editidroomType=clean($listofsuppliers['roomType']);
}




?>
		<?php if($isHotel==1){
		if($dmcHotel!=0){
$select1='*';  
$where1='id='.$dmcHotel.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

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
$editid=clean($editresult['id']);
}
		 ?>  
		<tr>
            <td colspan="2" align="left" valign="top" style="background-color:#ececec;">
			
			 
			
			
			</td>
            </tr>
			
			<?php } ?>
          <tr>
            <td colspan="2" align="left" valign="top">
		<?php
		$thisid='1';
$tpaybill2='0'; 
$select22='*';
$where22='voucherId='.clean($resultInvoice['id']).' and supplierId='.$listofsuppliers['supplierId'].' order by id desc'; 
$rs22=GetPageRecord($select22,_VOUCHER_LIST_MASTER_,$where22); 
while($listofsuppliers2=mysqli_fetch_array($rs22)){


$id2=$listofsuppliers2['supplierId'];

$select12='*';  
$where12='id='.$id.''; 
$rs12=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where12); 
$editresult2=mysqli_fetch_array($rs12);

$editassignTo=clean($editresult2['assignTo']); 
$editname=clean($editresult2['name']); 
$editcontactPerson=clean($editresult2['contactPerson']);
$editcompanyTypeId=clean($editresult2['companyTypeId']);
$editcountryId=clean($editresult2['countryId']);
$editstateId=clean($editresult2['stateId']); 
$editcityId=clean($editresult2['cityId']); 
$edittitle=clean($editresult2['title']); 
$addedBy=clean($editresult2['addedBy']);
$dateAdded=clean($editresult2['dateAdded']);
$modifyBy=clean($editresult2['modifyBy']);
$modifyDate=clean($editresult2['modifyDate']); 
$editaddress1=clean($editresult2['address1']);  
$editaddress2=clean($editresult2['address2']);  
$editaddress3=clean($editresult2['address3']);  
$editpinCode=clean($editresult2['pinCode']);
$editgstn=clean($editresult2['gstn']);
$editagreement=clean($editresult2['agreement']);
$editid=clean($editresult2['id']);
$editidroomType2=clean($listofsuppliers2['roomType']);
 $companyTypeId=$listofsuppliers2['companyTypeId'];
 $suppliername=$listofsuppliers2['suppliername']; 
?>
		
					
			
			<?php } ?>
			
			
				</td>
            </tr> 
		  <?php } ?>
		  
		  <tr>      </tr>
	  
 
	   
        </table>
		</div>
				</td>
      </tr>
	  
	  <tr>
        <td colspan="3" align="left" valign="top" style="padding-top:0px; padding-bottom:0px;"><div style="background-color:#ececec; padding:10px; margin-bottom:10px; ">
			<table width="100%" border="0" cellpadding="10" cellspacing="0">
 
  <tr>
    <td colspan="2" align="left" valign="top" bgcolor="#fdfdfd"><table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:13px; padding:10px; ">
      <tr>
        <td width="68%" style="padding-bottom:5px; padding-top:5px; padding-right:5px; font-size:15px;"><strong>Booking Details </strong></td>
      </tr>
      <tr>
        <td valign="top" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong>
          <table width="100%" border="0" cellpadding="4" cellspacing="0" style="margin:5px;">
            <tbody>
              <?php if($resultQuery['clientType']==1){?>
              <tr>
                <td align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Company:</td>
                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="left"><strong><?php echo showClientTypeUserName($resultQuery['clientType'],$resultQuery['companyId']); ?></strong></td>
              </tr>
              <?php } ?>
              <tr>
                <td align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Guest Name:</td>
                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="left"><span style="text-transform: capitalize"><strong>
                  <?php if($resultQuery['clientType']==1){ echo $resultQuery['guest1']; } else { echo showClientTypeUserName($resultQuery['clientType'],$resultQuery['companyId']); } ?>
                </strong></span></td>
              </tr>
              <tr>
                <td align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Email:</td>
                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="left"><strong><?php echo getPrimaryEmail($resultCompany['id'],''.$mobilemailtype.''); ?></strong></td>
              </tr>
              <tr>
                <td  style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Contact Number:</td>
                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><strong><?php echo getPrimaryPhone($resultCompany['id'],''.$mobilemailtype.''); ?></strong></td>
              </tr>
              <tr>
                <td  style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Booking Date:</td>
                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><strong><?php echo date('d-m-Y',$resultInvoice['dateAdded']);?></strong></td>
              </tr>
              <?php if($showcostdiv==1){ ?>
              <?php } ?>
            </tbody>
          </table>
        </strong></td>
      </tr>
      <?php if($editresult['locationMap']!=''){ ?>
      <?php } ?>
    </table></td>
    <td width="49%" align="left" valign="top" bgcolor="#FFFFFF" style="display:none;"><table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:13px; padding:10px;">
               
             <tr>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><?php if($companyTypeId==1){ ?>No. of Nights<?php } else { ?>No of Pax<?php } ?>:	</td>
                  <td align="right" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers2['suppliernonight']; ?></strong></td>
                </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><?php if($companyTypeId==1){ ?>Per Night Cost<?php } else { ?>Per Pax Cost<?php } ?>:	     </td>
                  <td width="68%" align="right" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo round($listofsuppliers2['supplierpernight']); ?></strong></td>
                </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Cost:</td>
                <td align="right" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo round($listofsuppliers2['suppliertotalcost']); ?></strong></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Tax CGST:</td>
                  <td align="right" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers2['suppliercgst']; ?>%</strong></td>
                </tr>
              <tr>
                <td bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">SGST: </td>
                  <td align="right" bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong>
                    <?php echo $listofsuppliers2['suppliersgst']; ?>%</strong></td>
                </tr>
              
              <tr>
                <td bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">IGST:</td>
                <td align="right" bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers2['supplierigst']; ?>%</strong></td>
              </tr>
              <tr>
                <td bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong>Amount Payable:</strong></td>
                  <td align="right" bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo round($listofsuppliers2['suppliertoalcost']); $tpaybill = $tpaybill+$listofsuppliers2['suppliertoalcost']; ?> INR</strong></td>
                </tr>  
              
            </table></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bordercolor="#fdfdfd"></td>
    <td width="50%" valign="top"></td>
  </tr>
</table>
			</div>
		
<?php

$select152='voucherId,queryId';  
$where12='queryId='.$resultInvoice['queryId']; 
$rs12=GetPageRecord($select152,_VOUCHER_LIST_MASTER_,$where12); 
$getqueryId=mysqli_fetch_array($rs12);

$voucherId=$getqueryId['voucherId'];
$voucherQueryId=$getqueryId['queryId'];

$select67='*';
$where67='voucherid='.$voucherId.' order by fromDate asc';  
$rs67=GetPageRecord($select67,_VOUCHER_SUPPLIER_DATA_,$where67); 
while($getdatasup=mysqli_fetch_array($rs67))
{

if($getdatasup['supplierId']!=''){
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
}


?>
		<div style="margin-bottom:0px; border:2px #CCCCCC solid; margin-left:5px; margin-right:5px; margin-top:10px; margin-bottom:7px;"><table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:13px;"><tr>
   <td colspan="11" align="left" valign="top" bgcolor="#F3F3F3" class="lightgraytextm" style="font-size:18px;"><strong><?php  
	if($getdatasup['companyTypeId']!=0){
	$select1='*';  
$where1='id='.$getdatasup['companyTypeId']; 
$rs1=GetPageRecord($select1,_SUPPLIERS_TYPE_MASTER_,$where1); 
$getroom=mysqli_fetch_array($rs1);
echo strip($getroom['name']);}  ?></strong></td>
   </tr>
 <?php
 if($getdatasup['supplierId']!='' && $getdatasup['supplierId']!=0)
 {
 ?> 
 
 <tr>
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

    <?php
    $select152q='*';  
    $where12q='id='.$voucherQueryId; 
    $rs12q=GetPageRecord($select152q,_QUERY_MASTER_,$where12q); 
    while($getqueryIdq=mysqli_fetch_array($rs12q)){
     if($getqueryIdq['supplierType']==1 && $getdatasup['companyTypeId']==1){ ?>
    <td align="left" valign="top" class="lightgraytextm"><span class="gridlable">Supplier</span></td>
    <td align="left" valign="top" class="lightgraytextm">:</td>
    <td colspan="5" align="left" valign="top"><?php  echo $editname; ?>&nbsp;&nbsp;&nbsp;</td>
  <?php } } ?>
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
</div>
<?php 
}
 ?>
</td>
      </tr>
      
    
      
       
      <tr>
        <td colspan="3" align="left" valign="top" style="padding-top:0px; padding-bottom:0px;"><div style="margin-bottom:10px; border:2px #CCCCCC solid; margin-left:5px; margin-right:5px; margin-top:5px;"><table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top"><?php echo strip($resultvouchersetting['policies']); ?></td>
    <td width="50%" align="right" valign="top" style="font-size:12px;"><strong><?php echo stripslashes($resultInvoiceSetting['companyname']); ?></strong><br />
      Call our Customer Service Center 24/7:<br />      <?php echo stripslashes($resultInvoiceSetting['phone']); ?></td>
  </tr>
  
</table></div></td>
      </tr>
	
      <tr>
        <td colspan="3" align="left" valign="top" style="padding-top:0px; padding-bottom:0px;">
		<div style="margin-bottom:10px; border:2px #CCCCCC solid; margin-left:5px; margin-right:5px; margin-top:5px;"><table width="100%" border="0" cellpadding="6" cellspacing="0"   style="font-size:12px;">
  <tr>
    <td colspan="3"><strong>Notes:</strong>
<?php echo $resultvouchersetting['pointsRememberText']; ?></td>
    </tr>
</table></div>		</td>
      </tr>
      <tr>
        <td colspan="3" align="right" valign="top" style="font-size:11px; color:#666666; padding-right:10px;">Generated from travCRM&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>






<style>
body{background-color:#202630 !important;}
@media print 
{
  @page { margin: 0; }
  body  { margin:0cm; }
}
</style>
<?php if($_GET['print']==1){ ?>

<script>
window.print();
</script>
<?php }
if($_REQUEST['save']==1){ 
$fileName=''.makeQueryId($resultInvoice['queryId']).'-voucher.doc';
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
}
 ?>
</body>
</html>
