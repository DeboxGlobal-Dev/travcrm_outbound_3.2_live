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
$select4='name,id';  
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
<div <?php if($_GET['send']==1){ ?>style="margin:0px; border:5px #ccc solid; padding:20px;"<?php } ?>>
 
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td> </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#ecedf1">
      <tbody>
        <tr>
          <td bgcolor="#FFFFFF" align="center"><table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#ecedf1" align="center">
            <tbody>
			<?php if($resultInvoiceSetting['logo']!=''){ ?>
              <tr>
                <td align="center" bgcolor="#FFFFFF" style="padding-bottom:20px; font-size:25px;"><?php if($resultInvoice['invoiceType']=='1'){ echo 'Tax Invoice'; } else { echo 'Performa'; } ?></td>
              </tr>
              <tr>
                <td width="100%" align="center" bgcolor="#FFFFFF"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSetting['logo']; ?>" /></td>
              </tr>
			  <?php } ?>
              <tr>
                <td bgcolor="#FFFFFF" height="5"></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF" align="center"><?php echo stripslashes($resultInvoiceSetting['address']); ?><br />
                  Tel.: <?php echo stripslashes($resultInvoiceSetting['phone']); ?><br />
                  E-mail:&nbsp;<a href="mailto:<?php echo stripslashes($resultInvoiceSetting['email']); ?>" target="_blank"><?php echo stripslashes($resultInvoiceSetting['email']); ?></a><br />
                  Website :&nbsp;<a href="http://<?php echo stripslashes($resultInvoiceSetting['website']); ?>" target="_blank"><?php echo stripslashes($resultInvoiceSetting['website']); ?></a></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </tbody>
          </table></td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#ecedf1">
      <tbody>
        <tr>
          <td width="50%" bgcolor="#FFFFFF"><strong><?php if($resultQuery['clientType']==1){ echo strip($resultCompany['name']); } if($resultQuery['clientType']==2){ echo strip($resultCompany['firstName'].' '.$resultCompany['lastName']); }  ?></strong></td>
          <td width="50%" align="right" bgcolor="#FFFFFF">Invoice No. : &nbsp;&nbsp;&nbsp;<?php if($resultInvoice['invoiceType']=='1'){ echo 'INV'; } else { echo 'PER'; } ?><?php echo str_pad($resultInvoice['id'], 6, '0', STR_PAD_LEFT); ?></td>
        </tr>  <tr>
          <td bgcolor="#FFFFFF">Phone : <?php echo getPrimaryPhone($resultCompany['id'],''.$mobilemailtype.''); ?></td>
          <td align="right" bgcolor="#FFFFFF">Invoice Date :&nbsp;&nbsp; <?php echo date("F j, Y", strtotime($resultInvoice['invoicedate'])); ?></td>
        </tr>
		 
        <tr>
          <td bgcolor="#FFFFFF">Email: <?php echo getPrimaryEmail($resultCompany['id'],''.$mobilemailtype.''); ?></td>
          <td align="right" bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp; </td>
          <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div id="invoicearea"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#ecedf1" class="table">
      <tbody>
        <tr>
          <td width="80%" align="left" bgcolor="#e5e5e5" class="td"><strong>Description</strong></td>
          <td width="15%" align="right" bgcolor="#e5e5e5" class="td"><strong>Amount</strong></td>
          </tr>
        <tr>
          <td width="80%" align="left" valign="top" bgcolor="#FFFFFF" class="td"><?php echo stripslashes($string = preg_replace('/^\s*(?:<br\s*\/?>\s*)*/i', '', $resultInvoice['queryDetails'])); ?></td>
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
          <td align="right" bgcolor="#FFFFFF" class="td">STG (<?php echo $resultInvoice['stg']; ?>%)</td>
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
    </table></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" colspan="3">&nbsp;&nbsp;</td>
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
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ecedf1">
      <tbody>
        <tr bgcolor="#FFFFFF">
          <td height="15px" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="70%" bgcolor="#FFFFFF"><strong>Received</strong></td>
          <td width="30%" align="right" bgcolor="#FFFFFF"><strong>For <?php echo stripslashes($resultInvoiceSetting['companyname']); ?></strong></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><strong>For</strong></td>
          <td align="right" bgcolor="#FFFFFF"><strong>Authorized Signatory</strong></td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <br />
</table>
<div style="text-align:center; font-size:12px; padding-top:10px;">Generated from travCRM</div>
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
