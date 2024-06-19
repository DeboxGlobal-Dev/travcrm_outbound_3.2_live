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

<body style="background-color:#FFFFFF;">
<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-family:Arial, Helvetica, sans-serif;">
  <tr>
    <td colspan="3"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="3" align="left" valign="top" style="background-image:url(<?php echo $fullurl; ?>images/invoicerighttopimg.png); background-repeat:no-repeat; background-position:right top;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2" style="padding:10px;"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSettingLogo['logo']; ?>" height="45" /></td>
            <td width="50%" align="right" style="color:#000; font-size:30px; padding:10px;"><strong>Voucher</strong></td>
          </tr>
          
        </table></td>
        </tr>
      <tr>
        <td colspan="3" align="left" valign="top" style=" border-top:2px #ccc solid; height:0px;"></td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top">
		  <?php
$thisid='1';
$tpaybill='0'; 
$select2='*';
$where2='voucherId='.clean($resultInvoice['id']).' order by id desc'; 
$rs2=GetPageRecord($select2,_VOUCHER_LIST_MASTER_,$where2); 
while($listofsuppliers=mysqli_fetch_array($rs2)){




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
		 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top"><table width="230" border="0" cellpadding="4" cellspacing="0" style="font-size:13px; padding:10px;">
      <tr>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Booking ID: </td>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo makeQueryId($resultInvoice['queryId']); ?></strong></td>
      </tr>
      <tr>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Hotel:</td>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo ($editname); ?></strong></td>
      </tr>
      <tr>
        <td valign="top" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Phone: </td>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo getContactPersonPhone($resultQuery['contactPId'],'suppliers'); ?></strong></td>
      </tr>
      <tr>
        <td valign="top" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Adddress: </td>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong>
          <?php  
	if($listofsuppliers['supplierstateId']!=0){
	$select1='*';  
 $where1='stateId='.$listofsuppliers['supplierstateId'].' and addressParent='.$editid.' and addressType="supplier"'; 
$rs1=GetPageRecord($select1,_ADDRESS_MASTER_,$where1); 
$addressSup=mysqli_fetch_array($rs1);  ?>
          <?php echo $addressSup['address']; ?>, <?php echo getCityName($addressSup['cityId']); ?>, <?php echo getStateName($addressSup['stateId']); ?>, <?php echo $addressSup['pinCode']; ?> <?php echo getCountryName($addressSup['countryId']); 
 
 } else { ?> <?php echo $editaddress1; ?>
          <?php } ?>
        </strong></td>
      </tr>
      <tr>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Check In: </td>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo date('d-m-Y',strtotime($listofsuppliers['fromDate'])); ?></strong></td>
      </tr>
      <tr>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Check Out:</td>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo date('d-m-Y',strtotime($listofsuppliers['toDate'])); ?></strong></td>
      </tr>
      <?php if($editresult['locationMap']!=''){ ?>
      <tr>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Location (MAP):</td>
        <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><a href="<?php echo $editresult['locationMap']; ?>" target="_blank"><strong>View Location </strong></a></td>
      </tr>
      <?php } ?>
    </table></td>
    <td width="50%"><table width="230" border="0" cellpadding="4" cellspacing="0" style="font-size:13px; padding:10px;">
              <tr>
                <td bgcolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Room Type: </td>
                <td bgcolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><?php echo getRoomType($editidroomType); ?></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Rooms: </td>
                <td bgcolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers['suppliernorooms']; ?></strong></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">No. of Nights:</td>
                <td bgcolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers['suppliernonight']; ?></strong></td>
              </tr>
             
              <?php if($listofsuppliers['showCost']==1){  $showcostdiv=1;?>    <tr>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Per Night Cost:</td>
                <td align="right" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers['supplierpernight']; ?></strong></td>
              </tr>
              <tr>
              <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Cost:</td>
              <td align="right" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers['suppliertotalcost']; ?></strong></td>
            </tr>
             <tr>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Tax CGST:</td>
                <td align="right" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers['suppliercgst']; ?>%</strong></td>
              </tr>
              <tr>
                <td bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">SGST: </td>
                <td align="right" bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong>
                  <?php echo $listofsuppliers['suppliersgst']; ?>%</strong></td>
              </tr>
        
            <tr>
              <td bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">IGST:</td>
              <td align="right" bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers['supplierigst']; ?>%</strong></td>
            </tr>
            <tr>
                <td bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong>Amount Payable:</strong></td>
                <td align="right" bordercolor="#FFFFFF" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $listofsuppliers['suppliertoalcost']; $tpaybill = $tpaybill+$listofsuppliers['suppliertoalcost']; ?> INR</strong></td>
              </tr> <?php } ?>
              
            </table></td>
  </tr>
</table>

		<?php } ?>		</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top"><?php echo strip($resultvouchersetting['policies']); ?></td>
    <td width="50%" align="right" valign="top" style="font-size:12px;"><strong><?php echo stripslashes($resultInvoiceSetting['companyname']); ?></strong><br />
      Call our Customer Service Center 24/7:<br />      <?php echo stripslashes($resultInvoiceSetting['phone']); ?></td>
  </tr>
  
</table></td>
      </tr>
	
      <tr>
        <td colspan="3" align="left" valign="top">
		<table width="100%" border="1" cellpadding="6" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td colspan="3"><strong>Notes:</strong>
<?php echo $resultvouchersetting['pointsRememberText']; ?></td>
    </tr>
</table>		</td>
      </tr>
      <tr>
        <td colspan="3" align="right" valign="top" style="font-size:11px; color:#666666;">Generated from travCRM&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>






<style>

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
