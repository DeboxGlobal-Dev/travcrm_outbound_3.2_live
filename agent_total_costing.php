<?php
include "inc.php";
include "config/logincheck.php";

 
$rs = '';
$rs = GetPageRecord('*', _PAYMENT_REQUEST_MASTER_,'id=' . clean(decode($_GET['paymentid'])) . '');
$resultpaymentpage = mysqli_fetch_array($rs);


$quotationId = clean($resultpaymentpage['quotationId']);

$totalClientCost = $_REQUEST['totalClientCost'];
$totalMarginCost = $_REQUEST['totalMarginCost'];
$reqclientCGst = $_REQUEST['reqclientCGst'];
$reqclientSGst = $_REQUEST['reqclientSGst'];
$reqclientIGst = $_REQUEST['reqclientIGst'];
$reqmarginCGst = $_REQUEST['reqmarginCGst'];
$reqmarginSGst = $_REQUEST['reqmarginSGst'];
$reqmarginIGst = $_REQUEST['reqmarginIGst'];
$reqclientCost = $_REQUEST['reqclientCost'];
$reqmarginCost = $_REQUEST['reqmarginCost'];
$clientGstType = $_REQUEST['clientGstType'];
$marginGstType = $_REQUEST['marginGstType'];
$reqclientGst = $_REQUEST['reqclientGst'];
$reqmarginGst = $_REQUEST['reqmarginGst'];
$allinclusive = $_REQUEST['allinclusive'];
$serviceTCS = $_REQUEST['serviceTCS'];
 
// if ($_REQUEST['status'] != 'na'){
  $namevalue = 'totalClientCost="' . $totalClientCost . '",totalMarginCost="' . $totalMarginCost . '",reqclientCGst="' . $reqclientCGst . '",reqclientSGst="' . $reqclientSGst . '",reqclientIGst="' . $reqclientIGst . '",reqmarginCGst="' . $reqmarginCGst . '",reqmarginSGst="' . $reqmarginSGst . '",reqmarginIGst="' . $reqmarginIGst . '",reqclientCost="' . $reqclientCost . '",reqmarginCost="' . $reqmarginCost . '",clientGstType="' . $clientGstType . '",marginGstType="' . $marginGstType . '",lastUpdateDate="' . time() . '",reqclientGst="' . $reqclientGst . '",reqmarginGst="' . $reqmarginGst . '",quotationId="' .$quotationId. '",allinclusive="' . $_REQUEST['allinclusive'] . '",reqclientTCS="'.$serviceTCS.'"';
  $where = 'paymentId="'.decode($_GET['paymentid']).'"';
  updatelisting(_AGENT_PAYMENT_REQUEST_, $namevalue, $where);
// }

$rs = ''; 
$rs = GetPageRecord('*', _QUOTATION_MASTER_, 'id=' . $quotationId . '');
$quotationData = mysqli_fetch_array($rs);
 

$isUni_Mark = $quotationData['isUni_Mark'];
$isSer_Mark = $quotationData['isSer_Mark'];

$rs = '';
$rs = GetPageRecord('*', _AGENT_PAYMENT_REQUEST_, 'paymentId="' . $resultpaymentpage['id'] . '"');
$agentPaymentRequestData = mysqli_fetch_array($rs);

$reqclientGst = $agentPaymentRequestData['reqclientGst'];
$reqmarginGst = $agentPaymentRequestData['reqmarginGst'];
$allinclusive = $agentPaymentRequestData['allinclusive'];
$TCS = $agentPaymentRequestData['reqclientTCS'];

$tcsVal=0;
if($TCS>0){
 $tcsVal = $reqclientCost * $TCS / 100;
}

if ($reqclientGst != 0){
  $GST = $agentPaymentRequestData['reqclientGst'];
  $Cgst = $agentPaymentRequestData['reqclientCGst'];
  $Sgst = $agentPaymentRequestData['reqclientSGst'];
  $Igst = $agentPaymentRequestData['reqclientIGst'];
  
  $finalReqCost = $reqclientCost;
}
// if ($reqmarginGst != 0){
//   $GST = $agentPaymentRequestData['reqmarginGst'];
//   $Cgst = $agentPaymentRequestData['reqmarginCGst'];
//   $Sgst = $agentPaymentRequestData['reqmarginSGst'];
//   $Igst = $agentPaymentRequestData['reqmarginIGst'];
 
//   $finalReqCost = $reqmarginCost;
//   $extraCost = $agentPaymentRequestData['extraCost'];
// }

$s = 1; 
$totalPending = $totalPaid = 0;
$r3=GetPageRecord('sum(amount) as totalpaid, spm.*','agentPaymentMaster spm',' agentPaymentId="'.$agentPaymentRequestData['id'].'" and paymentStatus=1'); 
$agentPaymentData = mysqli_fetch_array($r3);
$totalPaid = $agentPaymentData['totalpaid'];
 
?>
<script>
var allinclusive = '<?php echo $allinclusive; ?>';
if(allinclusive==0){
  parent.$('#agentPaymentupdatebutton').hide();
}
if(allinclusive>0){
  parent.$('#agentPaymentupdatebutton').show();
}
</script>
<div class="bodycontbox">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">Package Cost </span></td>
      <td width="33%" align="right" style="font-size:24px; font-weight:500;"><?php echo getTwoDecimalNumberFormat($reqclientCost); ?></td>
    </tr>
  </table>
</div>
<?php if ($reqmarginGst != 0) { ?>
<div class="bodycontbox" style="background-color:#ecf8ff;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">Service Charges</span></td>
      <td width="33%" align="right" style="font-size:18px;"><?php echo getTwoDecimalNumberFormat($reqmarginCost); ?></td>
    </tr>
  </table>
</div>
<?php
}

// if($isSer_Mark == 1 && $isUni_Mark == 0 ){
  $cgstAmt = getTwoDecimalNumberFormat($quotationData['totalServiceTaxCost'] / 2);
  $sgstAmt = getTwoDecimalNumberFormat($quotationData['totalServiceTaxCost'] / 2);
// }else{
//   $cgstAmt = getTwoDecimalNumberFormat($finalReqCost * $Cgst / 100);
//   $sgstAmt = getTwoDecimalNumberFormat($finalReqCost * $Sgst / 100);
// }
if($clientGstType == 2){
  $cgstAmt = $sgstAmt = 0;
  $igstAmt = $quotationData['totalServiceTaxCost'];
}elseif($Cgst == 0 && $Sgst == 0 && $Igst>0 ){
  $igstAmt = getTwoDecimalNumberFormat($finalReqCost * $Igst / 100);
}else{
  $igstAmt = 0;
} 

?>
<div class="bodycontbox">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">CGST <?php echo $Cgst; ?>% </span></td>
      <td width="33%" align="right"><input   type="number" class="textfieldb"  value="<?php echo $cgstAmt; ?>"  readonly="readonly" style="width:80px; text-align:right;" /></td>
    </tr>
  </table>
</div>
<div class="bodycontbox">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">SGST <?php echo $Sgst; ?>% </span></td>
      <td width="33%" align="right"><input   type="number" class="textfieldb"   value="<?php echo $sgstAmt; ?>"  readonly="readonly" style="width:80px; text-align:right;" /></td>
    </tr>
  </table>
</div>
<div class="bodycontbox">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">IGST <?php echo $Igst; ?>% </span></td>
      <td width="33%" align="right"><input  type="number" class="textfieldb"  value="<?php echo $igstAmt; ?>"  readonly="readonly" style="width:80px; text-align:right;" /></td>
    </tr>
  </table>
</div>

<div class="bodycontbox">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">TCS <?php echo $TCS; ?>% </span></td>
      <td width="33%" align="right"><input  type="number" class="textfieldb"  value="<?php echo round($tcsVal); ?>"  readonly="readonly" style="width:80px; text-align:right;" /></td>
    </tr>
  </table>
</div>

 <div class="bodycontbox">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">&nbsp;</span></td>
      <td width="33%" align="right" style="position:relative;">&nbsp;</td>
      </tr>
    </table>
  </div>  
  <div class="bodycontbox" style="background-color:#61c6cf;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><span class="header" style="color:#fff; font-size:14px;">Invoice Amount</span></td>
        <td width="33%" align="right" style="font-size:24px; color:#fff;"><?php echo $finalCost = getTwoDecimalNumberFormat($quotationData['totalQuotCost']); ?></td>
      </tr>
    </table>
  </div>
  <script>
  $('#totalamounttop').text('<?php echo getTwoDecimalNumberFormat($finalCost); ?>');
  $('#receivedamounttop').text('<?php echo getTwoDecimalNumberFormat($totalPaid); ?>');
  $('#pendingamounttop').text('<?php echo $totalPending = getTwoDecimalNumberFormat($finalCost - $totalPaid); ?>');
  <?php 
  if ($finalCost - $totalPaid <= 0) { ?>
    // $('#updatebuttonpayment').hide();
    <?php
  } ?>
  </script>
  <?php
  $namevalue = 'finalCost="'.$finalCost.'",pendingCost='.$totalPending.'';
  $where = 'paymentId="' . decode($_GET['paymentid']) . '"';
  updatelisting(_AGENT_PAYMENT_REQUEST_, $namevalue, $where);
  $select = '';
  $where = '';
  $rs = '';
  $select = '*';
  $quotationId = clean($resultpaymentpage['quotationId']);
  $where = 'quotationId=' . $quotationId . ' and  deletestatus=0';
  $rs = GetPageRecord($select, _INVOICE_MASTER_, $where);
  $invoicedetails = mysqli_fetch_array($rs);
  ?>
  <div class="buttonbox" style="overflow:hidden;">
  <?php 
  if ($invoicedetails['id'] == ''){ 
  ?>
    <a target="actoinfrm" href="<?php echo $fullurl; ?>frmaction.php?quotationId=<?php echo ($quotationId); ?>&addinvoice=1"><input name="addnewuserbtn" type="button" class="greenmbutton3 submitbtn" id="updatebuttonpayment" value="Generate Invoice" style=" width: 100%; border-radius: 3px; padding: 15px !important;margin: 13px 0px;"></a>
    <?php
  }
  else{
    $select = '*';
    $quotationId = $quotationData['id'];
    $where = 'quotationId=' . $quotationId . '';
    $rs = GetPageRecord($select,_INVOICE_MASTER_, $where);
    $invoicedata = mysqli_fetch_array($rs);
    ?>
    <!-- <div style=" float:left; width:48%;"><a target="_blank" href="showpage.crm?module=invoice&add=yes&id=<?php echo encode($invoicedata['id']); ?>"><input name="addnewuserbtn" type="button" class="greenmbutton3 submitbtn" id="updatebuttonpayment" value="Edit Invoice" style=" width: 100%; border-radius: 3px; padding: 15px !important;margin: 13px 0px;"></a></div> -->
    
    <?php
    // view invoice template select open geting template value
    $rs = GetPageRecord('setDefaultTemplate','invoiceSettingMaster','id=1');
    $invoiceTempvoucherData = mysqli_fetch_assoc($rs);
    $setDefaultTemplate = $invoiceTempvoucherData['setDefaultTemplate']; 

    ?>

  
    <div style=" float:right; width:48%;"><a target="_blank" href="<?php echo $fullurl; ?>/genrateDOMPdf.php?pageurl=<?php echo $fullurl; ?>invoicepdf<?php if($setDefaultTemplate == 1){ echo '01'; }elseif($setDefaultTemplate == 3){ echo '02';}elseif($setDefaultTemplate == 4){ echo '03';} ?>.php?id=<?php echo encode($invoicedetails['id']); ?>"><input name="addnewuserbtn" type="button" class="greenmbutton3 submitbtn" id="updatebuttonpayment" value="View Invoice" style=" background-color:#2390c4; width: 100%; border-radius: 3px; padding: 15px !important;margin: 13px 0px;"></a></div>
     
    <div style=" float:left; width:48%;"><a href="javascript:void(0)" onclick="alertspopupopen('action=cancelfinalquotInvoice&queryId=<?php echo encode($invoicedetails['queryId']); ?>','600px','auto');">
      <input name="addnewuserbtn" type="button" class="rediingmbutton submitbtn" id="" value="Cancel Invoice" style="width: 100%; border-radius: 3px; padding: 15px !important;margin: 13px 0px;"></a>
    </div>
    <?php
    } ?>
  </div>