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
$rs=GetPageRecord($select,_INVOICE_MASTER_,$where); 
$resultInvoice=mysqli_fetch_array($rs); 

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
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$resultInvoiceSetting=mysqli_fetch_array($rs);  
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



$select1='id';  
$where1='queryid='.$resultInvoice['queryId'].' order by id desc'; 
$rs1=GetPageRecord($select1,_PAYMENT_REQUEST_MASTER_,$where1); 
$finalpaymentId=mysqli_fetch_array($rs1);

$select1='*';  
$where1='paymentId='.$finalpaymentId['id'].' order by id asc'; 
$rs1=GetPageRecord($select1,_PAYMENT_SUPPLIER_LIST_MASTER_,$where1); 
$finalPymentList=mysqli_fetch_array($rs1);
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
<div style="padding:10px; border:2px #000 solid; width:830px; margin:auto; font-size:16px; background-color:#FFFFFF;">
<div style="padding-bottom:5px; text-align:left;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="left" valign="top"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSetting['logo']; ?>" height="70" /></td>
      <td width="57%" align="center" valign="middle"><table border="0" align="right" cellpadding="4" cellspacing="0">
        <tr>
          <td><strong>Invoice Date</strong></td>
          <td>:</td>
          <td><?php echo date("j F Y", strtotime($resultInvoice['invoicedate'])); ?></td>
        </tr>
        <tr>
          <td><strong>Invoice No. </strong></td>
          <td>:</td>
          <td><?php if($resultInvoice['invoiceType']=='1'){ echo 'INV'; } else { echo 'PER'; } ?><?php echo str_pad($resultInvoice['id'], 6, '0', STR_PAD_LEFT); ?></td>
        </tr>
        
      </table></td>
    </tr>
  </table>
</div>
 
 

 <div style="padding-bottom:10px; margin-bottom:10px; text-align:center; font-size:22px; padding-top:10px; text-align:left; text-align:center;"><strong><?php if($resultInvoice['invoiceType']=='1'){ echo ''; } else { echo 'PERFORMA'; } ?> INVOICE</strong></div>

 <div style="padding-bottom:10px;  padding-top:0px; text-align:left;  "><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:10px;"><div style="margin-bottom:6px; font-size:14px;"><strong>Client Details</strong></div>
	<div style="    padding: 10px;
    border: 1px #CCCCCC solid;
    height: 150px;
    line-height: 21px;
    font-size: 14px;">
	 To,<br />
	      <strong>
	        <?php if($resultQuery['clientType']==1){ echo strip($resultCompany['name']); } if($resultQuery['clientType']==2){ echo strip($resultCompany['firstName'].' '.$resultCompany['lastName']); }  ?>
	        </strong><br /> 
	    Phone: <?php echo getPrimaryPhone($resultCompany['id'],''.$mobilemailtype.''); ?>
	    <br />
	    Email: <?php echo getPrimaryEmail($resultCompany['id'],''.$mobilemailtype.''); ?><br />
	    Address:  <?php echo $resultCompany['address1']; ?> - <?php echo $resultCompany['pinCode']; ?><br />
	   <?php if($resultQuery['clientType']==1){ ?> GSTN: <?php echo $resultCompany['gstn']; ?><br /><?php } ?>
	      </p>
	  </div>	</td>
    <td width="50%" align="left" valign="top" style="padding-left:10px;"><div style="margin-bottom:6px; font-size:14px;"><strong><strong>Booking Company </strong></strong></div>
      <div style="    padding: 10px;
    border: 1px #CCCCCC solid;
    height: 150px;
    line-height: 21px;
    font-size: 14px;"><strong><?php echo stripslashes($resultInvoiceSetting['companyname']); ?></strong><br />
Phone: <?php echo stripslashes($resultInvoiceSetting['phone']); ?>
	  <br />
	  Email: <?php echo stripslashes($resultInvoiceSetting['email']); ?><br />
	  Address:  <?php echo stripslashes($resultInvoiceSetting['address']); ?><br />
	</div></td>
  </tr>
  
</table>
</div>
 
 <div style="padding-bottom:10px; margin-bottom:10px;   padding-top:0px; text-align:left;  ">
 
 
 
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" style="padding-right:0px;"><div style="margin-bottom:6px; font-size:14px;"><strong>Travel Details</strong></div>
	  <div style="    padding: 10px;
    border: 1px #CCCCCC solid; 
    line-height: 21px;
    font-size: 14px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><strong>Guest Name: </strong></td>
    <td align="left" valign="top"><?php echo ($resultQuery['guest1']); ?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Check In: </strong></td>
    <td align="left" valign="top"><?php echo date("d-m-Y", strtotime($resultQuery['fromDate'])); ?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Check Out: </strong></td>
    <td align="left" valign="top"><?php echo date("d-m-Y", strtotime($resultQuery['toDate'])); ?></td>
  </tr>
</table>


</td>
    <td width="50%" valign="top"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Booking Date: </strong></td>
    <td align="left" valign="top">&nbsp;<?php echo date("d-m-Y", strtotime($resultQuery['queryCloseDate'])); ?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Booking No:</strong></td>
    <td align="left" valign="top">&nbsp;#<?php echo str_pad($resultQuery['id'], 6, '0', STR_PAD_LEFT); ?></td>
  </tr>
</table></td>
  </tr>
  
</table>
</div>

<div style="     padding: 0px; 
    line-height: 21px;
    font-size: 12px; margin-top:10px;">
	
	 


	<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#ecedf1" class="table" style="font-size:12px;">
      <tbody>
        <tr>
          <td width="80%" align="right" bgcolor="#FFFFFF"  style="font-size:14px;"><strong>Description</strong></td>
          <td width="15%" align="right" bgcolor="#FFFFFF"  style="font-size:14px;"><strong>Amount</strong></td>
          </tr>
        <tr>
          <td width="80%" align="right" valign="top" bgcolor="#FFFFFF" class="td">
		  
		   

		  
		  Room Charge</td>
          <td width="15%" align="right" valign="top" bgcolor="#FFFFFF" class="td"><?php echo number_format($resultInvoice['amount'], 2); ?></td>
          </tr>
        <?php if($resultInvoice['igst']!='') { if($resultInvoice['igst']!='0'){ ?><tr>
          <td width="80%" align="right" bgcolor="#FFFFFF" class="td">IGST (<?php echo $resultInvoice['igst']; ?>%)</td>
          <td width="15%" align="right" valign="top" bgcolor="#FFFFFF" class="td"><?php echo number_format(($resultInvoice['igst'] / 100) * $resultInvoice['amount'], 2); ?></td>
          </tr><?php } } ?>
       <?php if($resultInvoice['cgst']!='') { if($resultInvoice['cgst']!='0'){ ?> <tr>
          <td width="80%" align="right" bgcolor="#FFFFFF" class="td">CGST (<?php echo $resultInvoice['cgst']; ?>%)</td>
          <td width="15%" align="right" valign="top" bgcolor="#FFFFFF" class="td"><?php echo number_format(($resultInvoice['cgst'] / 100) * $resultInvoice['amount'], 2);   ?></td>
          </tr><?php } } ?>
       <?php if($resultInvoice['stg']!=''){ if($resultInvoice['stg']!='0'){ ?> <tr>
          <td align="right" bgcolor="#FFFFFF" class="td">SGST (<?php echo $resultInvoice['stg']; ?>%)</td>
          <td align="right" valign="top" bgcolor="#FFFFFF" class="td"><?php echo  number_format(($resultInvoice['stg'] / 100) * $resultInvoice['amount'], 2); ?></td>
        </tr><?php } } ?>
        <tr>
          <td width="80%" align="right" bgcolor="#FFFFFF" class="td">Gross Amount </td>
          <td width="15%" align="right" valign="top" bgcolor="#FFFFFF" class="td"><?php echo number_format($resultInvoice['totalamount'], 2); ?></td>
          </tr>
        <tr>
          <td align="right" bgcolor="#FFFFFF" class="td" style="text-transform:uppercase;"> Indian Rupees - <?php
  /**
   * Created by PhpStorm.
   * User: sakthikarthi
   * Date: 9/22/14
   * Time: 11:26 AM
   * Converting Currency Numbers to words currency format
   */
$number = $resultInvoice['totalamount'];
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  echo $result . "  " . $points . "";
 ?>  only</td>
          <td align="right" bgcolor="#FFFFFF" class="td">INR&nbsp;&nbsp;&nbsp;<?php echo number_format($resultInvoice['totalamount'], 2); ?></td>
          </tr>
      </tbody>
    </table>

	</div> </td>
    </tr>
  
</table>
</div>
 <div style="padding-bottom:10px; margin-bottom:10px;   padding-top:10px; text-align:left;  ">
 
 <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px;">

  <tr>
    <td bgcolor="#FFFFFF" colspan="3"><strong><em>This is a system generated, doesn't need any signature</em><br /><br />

    </strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" colspan="3"><strong>E. &amp; O.E.&nbsp;</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" colspan="3"><strong>TERMS &amp; CONDITIONS OF TRANSACTION UNDER THIS BILL</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo stripslashes($resultInvoiceSetting['termscondition']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"> </td>
  </tr>
</table>

 </div>
 <div style="text-align:right; color:#999999; font-size:12px;">Genrated by travCRM</div>
</div><style>

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
