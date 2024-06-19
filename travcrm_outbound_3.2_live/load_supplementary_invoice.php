<?php 
ob_start();
include "inc.php";  

 

if($_GET['id']!=''){  

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean($_REQUEST['id']); 
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


$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='queryId='.$_REQUEST['id'].''; 
$rs=GetPageRecord($select,_SUP_PAYMENT_REQUEST_,$where); 
$dmcpaymentrequest=mysqli_fetch_array($rs);   
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
?>




<div style="padding:20px;">

<div style="padding:10px; border:1px #CCCCCC solid; width:900px; margin:auto; font-size:13px; background-color:#FFFFFF;">
<div style="padding-bottom:10px; margin-bottom:10px; border-bottom:2px solid #ccc;  text-align:left;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="left" valign="top"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSetting['logo']; ?>" height="70" /></td>
      <td width="57%" align="center" valign="middle"><table border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td>Invoice Date: </td>
          <td>:</td>
          <td><?php echo date("d-m-Y", strtotime($dmcpaymentrequest['invoiceGenerateDate'])); ?></td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td>Invoice No. </td>
          <td>:</td>
          <td><?php echo str_pad($_REQUEST['id'], 6, '0', STR_PAD_LEFT); ?></td>
        </tr>
        
      </table></td>
    </tr>
  </table>
</div>
 
 

 <div style="padding-bottom:10px; margin-bottom:10px; text-align:center; font-size:22px; padding-top:10px; text-align:left; text-align:center;">INVOICE</div>

 <div style="padding-bottom:10px; margin-bottom:10px;   padding-top:10px; text-align:left;  "><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:10px;"><div style="margin-bottom:6px; font-size:12px;"><strong>Client Details</strong></div>
	<div style="    padding: 10px;
    border: 1px #CCCCCC solid;
    height: 150px;
    line-height: 21px;
    font-size: 12px;">To,<br />
	  <strong><?php if($resultQuery['clientType']==1){ echo strip($resultCompany['name']); } if($resultQuery['clientType']==2){ echo strip($resultCompany['firstName'].' '.$resultCompany['lastName']); }  ?></strong><br /><br />
Phone: <?php echo getPrimaryPhone($resultCompany['id'],''.$mobilemailtype.''); ?>
	  <br />
	  Email: <?php echo getPrimaryEmail($resultCompany['id'],''.$mobilemailtype.''); ?><br />
	  Address:  <?php echo $resultCompany['address1']; ?> <?php echo $resultCompany['pinCode']; ?><br />
	</div>
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:10px;"><div style="margin-bottom:6px; font-size:12px;"><strong>Booking Office/Agency</strong></div>
      <div style="    padding: 10px;
    border: 1px #CCCCCC solid;
    height: 150px;
    line-height: 21px;
    font-size: 12px;"><strong><?php echo stripslashes($resultInvoiceSetting['companyname']); ?></strong>  <br />
        <br />
Phone: <?php echo stripslashes($resultInvoiceSetting['phone']); ?>
	  <br />
	  Email: <?php echo stripslashes($resultInvoiceSetting['email']); ?><br />
	  Address:  <?php echo stripslashes($resultInvoiceSetting['address']); ?><br />
	</div></td>
  </tr>
  
</table>
</div>
 
 <div style="padding-bottom:10px; margin-bottom:10px;   padding-top:10px; text-align:left;  ">
 
 
 
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" style="padding-right:0px;"><div style="margin-bottom:6px; font-size:12px;"><strong>Tour Details</strong></div>
	<div style="    padding: 10px;
    border: 1px #CCCCCC solid; 
    line-height: 21px;
    font-size: 12px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top">
<table border="0" cellpadding="8" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top"><strong>Tour Name</strong></td>
    <td align="left" valign="top"><?php echo ($resultQuery['subject']); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><strong>Departure Date </strong></td>
    <td align="left" valign="top"><?php echo date("d-m-Y", strtotime($resultQuery['fromDate'])); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><strong>Destination</strong></td>
    <td align="left" valign="top"><?php echo getDestination($resultQuery['destinationId']); ?></td>
  </tr>
</table>


</td>
    <td width="50%" valign="top"><table border="0" cellpadding="8" cellspacing="0">
  <tr>
    <td align="left" valign="top"><strong>Booking Date </strong></td>
    <td align="left" valign="top"><?php echo date("d-m-Y", ($resultQuery['dateAdded'])); ?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Booking No</strong></td>
    <td align="left" valign="top">#<?php echo str_pad($_REQUEST['id'], 6, '0', STR_PAD_LEFT); ?></td>
  </tr>
</table></td>
  </tr>
  
</table>
</div>

<div style="     padding: 10px;
    border: 1px #CCCCCC solid; 
    line-height: 21px;
    font-size: 12px; margin-top:10px;">
	
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tablesorter gridtable" style="margin-bottom:10px;">

   <thead>

   <tr>
      <th align="left" class="header" style="border-bottom: 2px #e8e8e8 solid;">Sr.No</th>
      <th align="left" class="header" style="border-bottom: 2px #e8e8e8 solid;">Particulars</th>
      <th align="center" class="header" style="border-bottom: 2px #e8e8e8 solid;">PAX. Qty</th>
      <th align="left" class="header" style="border-bottom: 2px #e8e8e8 solid;">Pax Type </th>
      <th align="center" class="header" style="border-bottom: 2px #e8e8e8 solid;">Currency</th>
      <th align="right" class="header" style="border-bottom: 2px #e8e8e8 solid;">GST</th>
      <th align="right" class="header" style="border-bottom: 2px #e8e8e8 solid;">Rate</th>
      <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$id.'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_SUP_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){


$select3='*';  
$where3='id='.$resListing['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3); 
   $curvalue=$curname['currencyValue']; 
?>
      <?php } ?>
	  <th align="right" class="header" style="border-bottom: 2px #e8e8e8 solid;">Sub&nbsp;Total</th>
      </tr>
   </thead>

 


 

  <tbody>
<?php
$s=1;
$select1=''; 
$wher1=''; 
$rs1='';  
$select1='*';    
$where1='  queryId="'.$id.'"  order by id asc';  
$rs1=GetPageRecord($select1,_SUP_PAYMENT_REQUEST_,$where1); 
while($dmcroommastermain=mysqli_fetch_array($rs1)){   
?>
  <tr>
    <td align="left"style="style="border-bottom: 1px #e8e8e8 solid;""><?php echo $s; ?></td>
    <td align="left"style="style="border-bottom: 1px #e8e8e8 solid;""><strong><?php 
 
$select='*';    
$where=' id='.$dmcroommastermain['tourType'].'';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

echo  $resListing['name'];

 } ?></strong><br />
<?php  echo  nl2br($dmcroommastermain['description']); ?></td>
    <td align="center"style="style="border-bottom: 1px #e8e8e8 solid;""><?php  echo  ($dmcroommastermain['pax']); ?></td>
    <td align="left"style="style="border-bottom: 1px #e8e8e8 solid;""><?php  if($dmcroommastermain['paxType']==1){ echo 'Adult'; } if($dmcroommastermain['paxType']==2){ echo 'Child'; } ?></td>
    <td align="center"style="style="border-bottom: 1px #e8e8e8 solid;""><?php 
 
$select='*';    
$where=' id='.$dmcroommastermain['currencyId'].'';  
$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

  $resListing['name'];
echo 'INR';
 } ?></td>
    <td align="right"style="style="border-bottom: 1px #e8e8e8 solid;""><?php  echo  ($dmcroommastermain['gst'])*$curvalue; ?>
      %</td>
    <td align="right"style="style="border-bottom: 1px #e8e8e8 solid;""><?php  echo  ($dmcroommastermain['rate'])*$curvalue; ?></td>
    <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$id.'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_SUP_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){ 

$select4='*';  
$where4='currencyId='.$resListing['currencyId'].' and queryId="'.$id.'" and id='.$dmcroommastermain['id'].' '; 
$rs4=GetPageRecord($select4,_SUP_PAYMENT_REQUEST_,$where4); 
$curnameval=mysqli_fetch_array($rs4);   
?>
    <?php  } ?>
    <td align="right" style="style="border-bottom: 1px #e8e8e8 solid;""><?php $totalsub=$dmcroommastermain['rate']*$dmcroommastermain['pax']; $totalsubgst=$totalsub*$dmcroommastermain['gst']/100; echo  ($totalsub+$totalsubgst)*$curvalue; ?></td>
    </tr>	<?php  $s++; } ?>
</tbody></table>


	<table width="100%" border="0" cellpadding="6" cellspacing="0">
  <tr>
    <td><div style="margin-bottom:6px; font-size:12px;"><strong>Amount in Words:</strong></div></td>
    <td width="16%" align="right"><div style="margin-bottom:6px; font-size:12px;"><strong>Grand Total</strong></div></td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$_REQUEST['id'].'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_SUP_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){ 

$select3='*';  
$where3='id='.$resListing['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3);

?>
  <tr>
    <td style="    text-transform: capitalize;">INR<?php  //echo ($curname['name']); ?>&nbsp;&nbsp;<em>
      <?php 
$t=0;
$select4=''; 
$where4=''; 
$rs4='';  
$select4='sum(subtotal) as TotaladultCost';    
$where4='currencyId='.$resListing['currencyId'].' and queryId="'.$_REQUEST['id'].'"';  
$rs4=GetPageRecord($select4,_SUP_PAYMENT_REQUEST_,$where4); 
while($adultcostSightseeingcost=mysqli_fetch_array($rs4)){   
 $t = $adultcostSightseeingcost['TotaladultCost'];
} ?>

      <?php
  /**
   * Created by PhpStorm.
   * User: sakthikarthi
   * Date: 9/22/14
   * Time: 11:26 AM
   * Converting Currency Numbers to words currency format
   */
$number = $t*$curvalue;
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
 ?>
    </em></td>
    <td align="right">&nbsp;</td>
    <td width="10%" align="left" bgcolor="#F2F2F2" style="font-family:Verdana, Arial, Helvetica, sans-serif;"><strong>&nbsp;&nbsp;
      <?php  //echo ($curname['name']); ?>INR
      &nbsp;</strong></td>
    <td width="11%" align="right" bgcolor="#F2F2F2" style="font-family:Verdana, Arial, Helvetica, sans-serif;"><strong><?php echo $t*$curvalue; ?>&nbsp;&nbsp;
      
    </strong></td>
  </tr>
  <?php } ?>
</table>

	</div> </td>
    </tr>
  
</table>
</div>
 <div style="padding-bottom:10px; margin-bottom:10px;   padding-top:10px; text-align:left;  ">
 
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
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
</table>

 </div>
 </div>

</div>








<script>

parent.$('#pageloading').hide();
parent.$('#pageloader').hide();
</script>