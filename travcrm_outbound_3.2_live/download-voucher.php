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
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="font-family:Arial, Helvetica, sans-serif; <?php if($_REQUEST['download']==1){ ?>    width: 100%; border: 0px;  border-color: #fff;<?php } ?>">
  <tr>
    <td colspan="3"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3" align="left" valign="top" ><br />
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2" style="padding:5px;"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSettingLogo['logo']; ?>" height="45" /></td>
            <td align="right" style="color:#000; font-size:20px; margin-right:12px; padding:5px;">Booking ID: <?php echo makeQueryId($resultInvoice['queryId']); ?></td>
            </tr>
        </table></td>
        </tr>
      <tr>      </tr>
	  
	  <tr>
        <td colspan="3" align="left" valign="top">
   
		<div style="margin-bottom:0px;  margin-left:0px; margin-right:0px; margin-top:0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
        
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
            <td colspan="2" align="left" valign="top" style="background-color:#ececec;">			</td>
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

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bordercolor="#fdfdfd"></td>
    <td width="50%" valign="top"></td>
  </tr>
</table>				</td>
            </tr> 
		  <?php } ?>
		  
		  <tr>      </tr>
	  
 
	   
        </table>
		</div>		  </td>
      </tr>
	  
	  <tr>
        <td colspan="3" align="left" valign="top"> 
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style=" font-size:12px;">
            <tbody>
              <?php if($resultQuery['clientType']==1){?>
              <tr>
                <td width="23%" align="left" valign="top" >Company:</td>
                <td width="77%" align="left" ><strong><?php echo showClientTypeUserName($resultQuery['clientType'],$resultQuery['companyId']); ?></strong></td>
              </tr>
              <?php } ?>
              <!--<tr>
                <td align="left" valign="top" >Guest Name:</td>
                <td  align="left"><span style="text-transform: capitalize"><strong>
                  <?php if($resultQuery['clientType']==1){ echo $resultQuery['guest1']; } else { echo showClientTypeUserName($resultQuery['clientType'],$resultQuery['companyId']); } ?>
                </strong></span></td>
              </tr>-->
              <tr>
                <td align="left" valign="top" >Email:</td>
                <td  align="left"><strong><?php echo getPrimaryEmail($resultCompany['id'],''.$mobilemailtype.''); ?></strong></td>
              </tr>
              <tr>
                <td  >Contact Number:</td>
                <td ><strong><?php echo getPrimaryPhone($resultCompany['id'],''.$mobilemailtype.''); ?></strong></td>
              </tr>
              <tr>
                <td  >Booking Date:</td>
                <td ><strong><?php echo date('d-m-Y',$resultInvoice['dateAdded']);?></strong></td>
              </tr>
          
            </tbody>
          </table> </td>
      </tr>
      
       
      <tr>
        <td colspan="3" align="left" valign="top"><table width="830" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;"> 


<?php 
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean($resultInvoice['queryId']); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$editresult=mysqli_fetch_array($rs);  
if($editresult['quotationYes']==1){
	
	
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' id='.$editresult['quotationId'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_DETAIL_MASTER_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
 $select='*';    
$where='packageId='.$editresult['quotationId'].' order by id asc';  
$rs=GetPageRecord($select,'packageBuilderHotel',$where); 
$hoteldetail=mysqli_fetch_array($rs); 

$select1='*';   
$where1='id='.$hoteldetail['categoryId'].'';  
$rs1=GetPageRecord($select1,'hotelCategoryMaster',$where1);  
$data=mysqli_fetch_array($rs1); 	 

if($daylisting['includeHotel']!='1'){   
?> 
<tr><td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="border:1px  solid #ccc; padding:5px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;"><tr>
    <td colspan="3" style="color:#666666; font-size:12px;"><strong><?php echo strip($hoteldetail['hotelName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Hotel </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:12px;">Category</td>
   <td width="20%" style="color:#666666; font-size:12px;">Room Type</td>
    <td width="20%" style="color:#666666; font-size:12px;">City</td>
    </tr>
	  <tr>
    <td width="20%" valign="top"><img src="<?php echo $fullurl; ?>images/<?php echo packageshowStarrating(substr($data['name'],0,5)); ?>" height="15" /></td>
    <td width="20%" valign="top"><strong><?php
	$select23='*';  
$where23='id='.$hoteldetail['roomType'].''; 
$rs23=GetPageRecord($select23,_ROOM_TYPE_MASTER_,$where23); 
$roomtype=mysqli_fetch_array($rs23);
echo $roomtype['name']; 
?>
    </strong></td>
    <td width="20%" valign="top"><strong><?php echo strip($hoteldetail['cityName']); ?></strong></td></tr></table>
</div></td></tr><?php } } ?>



		<?php  
		
$select='*';    
$where=' id='.$editresult['quotationId'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_DETAIL_MASTER_,$where); 
$daylisting=mysqli_fetch_array($rs);
	
$selects='*';    
$wheres=' packageId='.$editresult['quotationId'].' order by id asc';  
$rss=GetPageRecord($selects,'packageBuilderSightseeing',$wheres); 
while($resListingSight=mysqli_fetch_array($rss)){
 if($daylisting['includeSightseeing']!='1'){   
?>   <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="border:1px  solid #ccc; padding:5px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">

  <tr>
    <td colspan="3" style="color:#666666; font-size:12px;"><strong><?php echo strip($resListingSight['sightseeingName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Sightseeing </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:12px;">Type</td>
   <td width="20%" style="color:#666666; font-size:12px;">Duration</td>
    <td width="20%" style="color:#666666; font-size:12px;">&nbsp;</td>
    </tr>
	  <tr>
    <td width="20%" valign="top"><span class="style1">
       <?php  if($resListingSight['sightseeingType']==1){ echo 'SIC'; } if($resListingSight['sightseeingType']==2){ echo 'Private'; } ?>
    </span></td>
    <td width="20%" valign="top"><?php echo $resListingSight['duration']; ?></td>
    <td width="20%" valign="top">&nbsp;</td>
    </tr>
</table>
</div></td>
      </tr> 
		<?php } } ?>
		
		
<?php   
if($daylisting['cabNotInclude']!='1'){   
?>   <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="border:1px  solid #ccc; padding:5px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">

  <tr>
    <td style="color:#666666; font-size:12px;"><strong>Cab </strong></td>
    </tr>
  <tr>
    <td style="color:#666666; font-size:12px;"><?php echo strip($daylisting['cabDetail']); ?></td>
   </tr>
</table>
</div></td>
      </tr> 
<?php }  ?>

<?php   
if($daylisting['flightNotInclude']!='1'){   
?>   <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="border:1px  solid #ccc; padding:5px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">

  <tr>
    <td style="color:#666666; font-size:12px;"><strong>Flight </strong></td>
    </tr>
  <tr>
    <td style="color:#666666; font-size:12px;"><?php echo strip($daylisting['flightDetail']); ?></td>
   </tr>
</table>
</div></td>
      </tr> 
<?php } }  ?>
		
 



<?php 
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean($resultInvoice['queryId']); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$editresult=mysqli_fetch_array($rs);  
	
	
	
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	 
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].'  order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_HOTEL_,$where22); 
while($hotellisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$hotellisting['hotelId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_HOTEL_MASTER_,$where1); 
$hoteldetail=mysqli_fetch_array($rs1);    
?> 
<tr><td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="border:1px  solid #ccc; padding:5px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;"><tr>
    <td colspan="3" style="color:#666666; font-size:12px;"><strong><?php echo strip($hoteldetail['hotelName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Hotel </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:12px;">Category</td>
   <td width="20%" style="color:#666666; font-size:12px;">Room Type</td>
    <td width="20%" style="color:#666666; font-size:12px;">Meal Plan</td>
    </tr>
	  <tr>
    <td width="20%" valign="top"><img src="<?php echo $fullurl; ?>images/<?php echo packageshowStarrating($hoteldetail['hotelCategory']); ?>" height="15" /></td>
    <td width="20%" valign="top"><strong><?php
	$select23='*';  
$where23='id='.$hotellisting['roomType'].''; 
$rs23=GetPageRecord($select23,_ROOM_TYPE_MASTER_,$where23); 
$roomtype=mysqli_fetch_array($rs23);
echo $roomtype['name']; 
?>
    </strong></td>
    <td width="20%" valign="top"><strong><?php
	$select24='*';  
$where24='id='.$hotellisting['mealPlan'].''; 
$rs24=GetPageRecord($select24,_MEAL_PLAN_MASTER_,$where24); 
$mealplan=mysqli_fetch_array($rs24);
echo $mealplan['name']; 
?></strong></td></tr></table>
</div></td></tr><?php }  $n++; $daydatae++; }  ?>




<?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_AIRLINES_,$where22); 
while($transferlisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$transferlisting['airlineId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_AIRLINES_MASTER_,$where1); 
$transfergdetail=mysqli_fetch_array($rs1);    
?>   
<tr><td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="border:1px  solid #ccc; padding:5px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">

  <tr>
    <td colspan="3" style="color:#666666; font-size:12px;"><strong><?php echo strip($transfergdetail['flightName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Airline </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:12px;">Flight Number</td>
   <td width="20%" style="color:#666666; font-size:12px;">Time</td>
    <td width="20%" style="color:#666666; font-size:12px;">&nbsp;</td>
    </tr>
	  <tr>
    <td width="20%" valign="top"><span class="style1">
      <?php if($transfergdetail['flightNo']!=''){ echo $transfergdetail['flightNo']; } ?>
    </span></td>
    <td width="20%" valign="top"><?php if($transferlisting['startTime']!=0){ echo date('h:i a',$transferlisting['startTime']); } ?></td>
    <td width="20%" valign="top">&nbsp;</td>
    </tr>
	   
</table>
</div></td></tr><?php }  $n++; $daydatae++; }  ?>

<?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	
	
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_TRANSFER_,$where22); 
while($transferlisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$transferlisting['transferId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_TRANSFER_MASTER,$where1); 
$transfergdetail=mysqli_fetch_array($rs1);

$select1='*';  
$where1='transferNameId='.$transferlisting['transferId'].' and transferType='.$transferlisting['transferType'].''; 
$rs1=GetPageRecord($select1,_DMC_TRANSFER_RATE_MASTER_,$where1); 
$transferprice=mysqli_fetch_array($rs1);      
?>   <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="border:1px  solid #ccc; padding:5px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">

  <tr>
    <td colspan="3" style="color:#666666; font-size:12px;"><strong><?php echo strip($transfergdetail['transferName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Transfer </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:12px;">Type</td>
   <td width="20%" style="color:#666666; font-size:12px;"><?php if($transferlisting['transferType']!=1){ ?>Vehicle<?php } ?></td>
    <td width="20%" style="color:#666666; font-size:12px;"><?php if($transferlisting['sightseeingType']!=1){ ?>Time<?php } ?></td>
    </tr>
	  <tr>
    <td width="20%" valign="top"><span class="style1">
      <?php if($transfergdetail['transferType']=='1'){ echo 'SIC'; } else { echo 'Private'; } ?>
    </span></td>
    <td width="20%" valign="top"><?php if($transfergdetail['transferType']!=1){  
	$select1='*';  
$where1='id='.$transferlisting['vehicleId'].' '; 
$rs1=GetPageRecord($select1,_VEHICLE_MASTER_MASTER_,$where1); 
$vename=mysqli_fetch_array($rs1);
?><?php echo $vename['name']; } ?></td>
    <td width="20%" valign="top"><?php if($transferlisting['sightseeingType']!=1){ ?> <?php if($transferlisting['startTime']!=0){ echo date('h:i a',$transferlisting['startTime']); } ?> - <?php if($transferlisting['endTime']!=0){ echo date('h:i a',$transferlisting['endTime']); } } ?></td>
    </tr>
	   
</table>
</div></td>
      </tr>
      
		
		<?php }  $n++; $daydatae++; }  ?>
		
		<?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	
	
$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_SIGHTSEEING_,$where22); 
while($sightseeinglisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$sightseeinglisting['sightseeingId'].''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where1); 
$sightseeingdetail=mysqli_fetch_array($rs1);   


$select1='*';  
$where1='sightseeingNameId='.$sightseeinglisting['sightseeingId'].' and sightseeingType='.$sightseeinglisting['sightseeingType'].''; 
$rs1=GetPageRecord($select1,_DMC_SIGHTSEEING_RATE_MASTER_,$where1); 
$sightseeingprice=mysqli_fetch_array($rs1);      
?>   <tr>
        <td width="85%" align="left" valign="top"  style="padding:0px;" > 
<div style="border:1px  solid #ccc; padding:5px;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">

  <tr>
    <td colspan="3" style="color:#666666; font-size:12px;"><strong><?php echo strip($sightseeingdetail['sightseeingName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Sightseeing </strong></td>
    </tr>
  <tr>
    <td width="20%" style="color:#666666; font-size:12px;">Type</td>
   <td width="20%" style="color:#666666; font-size:12px;"><?php if($sightseeinglisting['sightseeingType']!=1){ ?>Vehicle<?php } ?></td>
    <td width="20%" style="color:#666666; font-size:12px;"><?php if($sightseeinglisting['sightseeingType']!=1){ ?>Time<?php } ?></td>
    </tr>
	  <tr>
    <td width="20%" valign="top"><span class="style1">
      <?php if($sightseeingdetail['sightseeingType']=='1'){ echo 'SIC'; } else { echo 'Private'; } ?>
    </span></td>
    <td width="20%" valign="top"><?php
	$select1='*';  
$where1='id='.$sightseeinglisting['vehicleId'].' '; 
$rs1=GetPageRecord($select1,_VEHICLE_MASTER_MASTER_,$where1); 
$vename=mysqli_fetch_array($rs1);
?><?php echo $vename['name'];?></td>
    <td width="20%" valign="top"><?php if($sightseeinglisting['sightseeingType']!=1){ ?> <?php if($sightseeinglisting['startTime']!=0){ echo date('h:i a',$sightseeinglisting['startTime']); } ?> - <?php if($sightseeinglisting['endTime']!=0){ echo date('h:i a',$sightseeinglisting['endTime']); } } ?></td>
    </tr>
</table>
</div></td>
      </tr>
      
		
		<?php }  $n++; $daydatae++; }  ?>
		
<?php 
$daydatae=1;
$n=1;
$daysfrom=1;
$totalday=0;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' packageId='.$editresult['id'].' order by id asc';  
$rs=GetPageRecord($select,_PACKAGE_QUERY_DAYS_,$where); 
while($daylisting=mysqli_fetch_array($rs)){  
$f=$n-1; 
	
	$daysfrom=1;
$totalday=0;
$select22=''; 
$where22=''; 
$rs22='';  
$select22='*';    
$where22=' packageId='.$editresult['id'].' and dayId='.$daylisting['id'].' order by id desc';  
$rs22=GetPageRecord($select,_PACKAGE_QUERY_CRUISE_,$where22); 
while($transferlisting=mysqli_fetch_array($rs22)){


$select1='*';  
$where1='id='.$transferlisting['cruiseId'].''; 
$rs1=GetPageRecord($select1,_CRUISE_MASTER_,$where1); 
$transfergdetail=mysqli_fetch_array($rs1);        
?>   
<tr><td width="85%" align="left" valign="top" style="padding:0px;"> 
<div style="border:1px  solid #ccc; padding:5px;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;"><tr>
    <td colspan="2" style="color:#666666; font-size:12px;"><strong><?php echo strip($transfergdetail['cruiseName']);  ?> - <?php if($daydatae==1){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } else { echo date('d-m-Y', strtotime($editresult['fromDate']. ' + '.$f.' days')); } ?> - Cruise </strong></td>
    </tr>
  <tr>
    <td width="10%" style="color:#666666; font-size:12px;">Cabin No.</td>
    <td width="90%" style="color:#666666; font-size:12px;">Detail</td>
    </tr>
	  <tr>
    <td width="10%" valign="top"><span class="style1">
      <?php if($transfergdetail['cabinNumber']!=''){ echo $transfergdetail['cabinNumber']; } ?>
    </span></td>
    <td width="90%" valign="top"><?php
	$select1='*';  
$where1='id='.$transferlisting['cruiseCompany'].''; 
$rs1=GetPageRecord($select1,_CRUISE_COMPANY_,$where1); 
$editresult=mysqli_fetch_array($rs1);
echo $editresult['name']; 
?>, <?php
	$select1='*';  
$where1='id='.$transferlisting['cruiseType'].''; 
$rs1=GetPageRecord($select1,_CRUISE_TYPE_,$where1); 
$editresult=mysqli_fetch_array($rs1);
echo $editresult['name']; 
?>, <?php
	$select1='*';  
$where1='id='.$transferlisting['cabinCategory'].''; 
$rs1=GetPageRecord($select1,_CABIN_CATEGORY_,$where1); 
$editresult=mysqli_fetch_array($rs1);
echo $editresult['name']; 
?>, <?php
	$select1='*';  
$where1='id='.$transferlisting['cabinType'].''; 
$rs1=GetPageRecord($select1,_CABIN_TYPE_,$where1); 
$editresult=mysqli_fetch_array($rs1);
echo $editresult['name']; 
?> </td>
    </tr>
</table>
</div></td>
      </tr>
      
		
		<?php }  $n++; $daydatae++; }  ?>
</table></td>
      </tr>
      
       
      <tr>
        <td colspan="3" align="left" valign="top">
<div ><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top"><?php echo strip($resultvouchersetting['policies']); ?></td>
    <td align="right" valign="top" style="font-size:12px;"><strong><?php echo stripslashes($resultInvoiceSetting['companyname']); ?></strong><br />
      Call Us:      <?php echo stripslashes($resultInvoiceSetting['phone']); ?></td>
  </tr>
  
</table></div></td>
      </tr>
	
      <tr>
        <td colspan="3" align="left" valign="top" style="padding-top:0px; padding-bottom:0px;"> 

<div style="padding:5px; border-top:1px #ccc solid;">Notes: <?php echo $resultvouchersetting['pointsRememberText']; ?></div> 	</td>
      </tr>
      <tr>
        <td colspan="3" align="right" valign="top" style="font-size:11px; color:#666666; padding-right:10px;">Generated from travCRM&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>
 
 
</body>
</html>
