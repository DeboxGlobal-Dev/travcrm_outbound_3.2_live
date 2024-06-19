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

}


$select4='*';  
$where4='id='.$resultQuery['companyId'].''; 
$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 
$resultCompany=mysqli_fetch_array($rs4); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice - INV-<?php echo str_pad($resultInvoice['id'], 6, '0', STR_PAD_LEFT); ?></title>
 <link rel="stylesheet" href="css/default.css" type="text/css"> 
 <link rel="stylesheet" href="css/main.css" type="text/css">
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" style="font-size:20px;">Booking ID: <?php echo makeQueryId($resultInvoice['queryId']); ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table cellpadding="20" cellspacing="0" border="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td width="49%" align="left" style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom:2px;"><strong>YOUR HOTEL DETAILS</strong></td>
                                                                                    <td width="49%" align="left" style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom:2px"><strong>RATE DETAILS (in INR)</strong></td>
                                                                                </tr>
                                                                      <?php
$thisid='0';
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




?>      <tr>
                                                                                    <td width="49%" align="left" valign="top" bgcolor="#FFFFFF">
                                                                                        <table border="0" cellpadding="4" cellspacing="0" style="background: #ffffff; color: #fff">
                                                                                                                      <tbody>
                                                                                                                        <tr>
                                                                                                                          <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top"><strong><?php echo ($editname); ?></strong></td>
                                                                                                                        </tr>
                                                                                                                         
                                                                                                                        <?php if($editaddress1!=''){ ?>
                                                                                                                        <tr>
                                                                                                                          <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666"><?php echo ($editaddress1); ?></td>
                                                                                                                        </tr>
                                                                                                                        <?php } ?>
                                                                                                                        <?php if($editaddress2!=''){ ?>
                                                                                                                        <tr>
                                                                                                                          <td align="left" ><?php echo ($editaddress2); ?></td>
                                                                                                                          <?php if($editaddress3!=''){ ?>
                                                                                                                        </tr>
                                                                                                                        <?php } ?>
                                                                                                                        <tr>
                                                                                                                          <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666"><?php echo getCityName($editcountryId); ?>, <?php echo getStateName($editstateId); ?>, <?php echo $editpinCode; ?> <?php echo getCountryName($editcountryId); ?></td>
                                                                                                                        </tr>
                                                                                                                        <?php } ?>
                                                                                                                        <tr>
                                                                                                                          <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Phone: <?php echo getPrimaryPhone($editid,'suppliers'); ?></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                          <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Email: <?php echo getPrimaryEmail($editid,'suppliers'); ?></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                          <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Room Type: <strong><?php echo getRoomType($editidroomType); ?></strong></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                          <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Check In: <strong><?php echo date('d-m-Y',strtotime($listofsuppliers['fromDate'])); ?></strong></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                          <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Check Out: <strong><?php echo date('d-m-Y',strtotime($listofsuppliers['toDate'])); ?></strong></td>
                                                                                                                        </tr>
                                                                                                                      </tbody>
                                                                        </table>                                                                              </td>
                                                                                    <td width="49%" align="left" valign="top" bgcolor="#FFFFFF">
                                                                                        <table width="100%" cellpadding="4" cellspacing="0"  >
                        <tbody>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">No. of Nights</td>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="right"><?php echo $listofsuppliers['suppliernonight']; ?></td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">Per Night Cost</td>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="right"><?php echo $listofsuppliers['supplierpernight']; ?></td>
                            </tr>
                            <tr>
                                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">Cost</td>
                                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="right"><?php echo $listofsuppliers['suppliertotalcost']; ?></td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">Tax CGST </td>
                              <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color: #666666; padding: 5px 0 5px 0; border-bottom: 1px solid #ebebf0" align="right"><?php echo $listofsuppliers['suppliercgst']; ?>%</td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">SGST </td>
                              <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color: #666666; padding: 5px 0 5px 0; border-bottom: 1px solid #ebebf0" align="right"><?php echo $listofsuppliers['suppliersgst']; ?>%</td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">IGST </td>
                              <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color: #666666; padding: 5px 0 5px 0; border-bottom: 1px solid #ebebf0" align="right"><?php echo $listofsuppliers['supplierigst']; ?>%</td>
                            </tr>
                            <tr>
                                <td style="font: normal 12px Arial,Helvetica,sans-serif; font-weight: bold; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 0px #ebebf0; border-top: solid 2px #c7c7c7" valign="top" class="auto-style1">Amount Payable</td>
                                <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color: #666666; padding: 5px 0 5px 0; border-bottom: 0px solid #ebebf0; border-top: solid 2px #c7c7c7" align="right"><strong><?php echo $listofsuppliers['suppliertoalcost']; $tpaybill = $tpaybill+$listofsuppliers['suppliertoalcost']; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>                                                                                    </td>
                                                                                </tr> <?php } ?>    
                                                                      <tr>
                                                                        <td width="49%" height="20" align="left"style="padding-bottom:2px;"><strong>YOUR BOOKING DETAILS</strong></td>
                                                                        <td width="49%" height="20" align="left" style="padding-bottom:2px;"><strong>AMENITIES</strong></td>
                                                                      </tr>
                                                                      <tr>
                                                                                    <td width="49%" height="20" valign="top"><table cellspacing="0" cellpadding="4" style="margin:5px;">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Guest Name</td>
                                                                                                                    <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="left"><span style="text-transform: capitalize"><?php echo $resultCompany['name']; ?></span></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Email</td>
                                                                                                                    <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="left"><?php echo getPrimaryEmail($resultCompany['id'],'corporate'); ?></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                  <td align="left"  style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Contact Number</td>
                                                                                                                  <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><?php echo getPrimaryPhone($resultCompany['id'],'corporate'); ?></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                  <td align="left"  style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Booking Date</td>
                                                                                                                  <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><?php echo date('m-d-Y',$resultInvoice['dateAdded']);?></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                  <td align="left"  style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><strong>Total Payable </strong></td>
                                                                                                                  <td align="left" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><strong><?php echo $tpaybill; ?> INR</strong></td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                        </table></td>
                                                                                    <td width="49%" height="20" align="left" valign="top"><table width="100%" cellspacing="0" cellpadding="4" style="margin:5px;">
                                                                                                            <tbody>
                                                                                                           
<?php
$string = $resultInvoice['amenitiesList'];
$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
$array = explode(',', $string); //split string into array seperated by ', '
foreach($array as $value) //loop over values
{
if($value!=''){ 

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=1; 
$where='id='.$value.''; 
$rs=GetPageRecord($select,_AMENITIES_MASTER_,$where); 
$emvalname=mysqli_fetch_array($rs); 
?>
 <tr>
<td align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><?php echo $emvalname['name']; ?><span style="text-transform: capitalize"> </span></td>
                                                                                                              </tr>
	<?php } }  ?>																											
                                                                                                            </tbody>
                                                                        </table></td>
                                                                      </tr>
                     <tr>
                       <td height="20" colspan="2" align="left"><span style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px"><strong>RATE INCLUSION AND POLICIES</strong></span></td>
                       </tr>
                     <tr>
                       <td height="20" colspan="2" align="left"><?php echo strip_tags($resultvouchersetting['policies']); ?></td>
                       </tr>
                     <tr>
                       <td height="20" colspan="2" align="left"><span style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px"><strong>POINTS TO REMEMBER</strong></span></td>
                       </tr>
                     <tr>
                       <td height="20" colspan="2" align="left"><?php echo strip_tags($resultvouchersetting['pointsRememberText']); ?></td>
                       </tr>
                     <tr>
                       <td height="20" colspan="2" align="left"><span style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px"><strong>24/7 One Clikk Hotels Helpdesk</strong></span></td>
                       </tr>
                     <tr>
                       <td height="20" colspan="2" align="left"><table cellspacing="0" cellpadding="5" border="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left"><strong>Phone: </strong><?php echo $resultvouchersetting['phone']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td  align="left" valign="middle"  ><strong>Email:</strong> <?php echo $resultvouchersetting['email']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td  align="left" valign="middle"  ><strong>Website:</strong> <?php echo $resultvouchersetting['website']; ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table></td>
                       </tr>  
                                                                         
                                                                            </tbody>
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
<?php } ?>
</body>
</html>
