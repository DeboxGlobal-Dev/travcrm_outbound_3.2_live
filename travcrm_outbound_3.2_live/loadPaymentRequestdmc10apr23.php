<?php
include "inc.php"; 
include "config/logincheck.php"; 

$rs=''; 
$rs=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,'id='.clean(decode($_GET['paymentid'])).''); 
$resultpaymentpage=mysqli_fetch_array($rs); 
 
$queryQuery='';    
$queryQuery=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($_GET['id']).''); 
$queryData=mysqli_fetch_array($queryQuery);  

$quotQuery="";
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$resultpaymentpage['quotationId'].'" and status=1 '); 
$quotationData=mysqli_fetch_array($quotQuery);
$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 


$serviceTCS = $quotationData['tcs']; 
if($quotationData['serviceTax'] > 0){ $serviceTax = $quotationData['serviceTax']; $gstLable = "( with GST )"; }else{ $serviceTax = 0; $gstLable = ""; } 
if($quotationData['markup'] > 0){ $serviceMarkup = $quotationData['markup']; }else{ $serviceMarkup = 0; } 

 
$where1='queryId="'.$queryData['id'].'" and paymentId="'.$resultpaymentpage['id'].'"'; 
$rs1=GetPageRecord('id',_AGENT_PAYMENT_REQUEST_,$where1); 
$hotelduplicate=mysqli_fetch_array($rs1);

if($hotelduplicate['id']=='' || $hotelduplicate['id']=='0'){
    $namevalue ='queryId="'.$queryId.'",quotationId="'.$quotationId.'",paymentId="'.$resultpaymentpage['id'].'"';
    $agentPaymentId = addlistinggetlastid(_AGENT_PAYMENT_REQUEST_,$namevalue); 

    $r2='';
    $r2=GetPageRecord('id','agentSchedulePaymentMaster','agentPaymentId="'.$agentPaymentId.'" and amount!="" and value!=""'); 
    if(mysqli_num_rows($r2) == 0){
      $namevalue ='type=1, value=100, status=1, dueDate="'.date('Y-m-d').'", amount="'.$quotationData['totalQuotCost'].'", agentPaymentId="'.$agentPaymentId.'",quotationId="'.$quotationId.'"';
      $scheduleId = addlistinggetlastid('agentSchedulePaymentMaster',$namevalue); 
    }
}

$where1='queryId="'.$queryData['id'].'" and quotationId="'.$quotationId.'" and paymentId="'.$resultpaymentpage['id'].'"'; 
$rs1=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,$where1); 
$agentPaymentRequestData=mysqli_fetch_array($rs1);
$clientgst=$agentPaymentRequestData['reqclientGst'];
$reqclientTCS=$agentPaymentRequestData['reqclientTCS'];
$clientcgst=$agentPaymentRequestData['reqclientCGst'];
$clientigst=$agentPaymentRequestData['reqclientIGst'];
$clientsgst=$agentPaymentRequestData['reqclientSGst'];
$clientGstType=$agentPaymentRequestData['clientGstType'];
$margingst=$agentPaymentRequestData['reqmarginGst'];
$margincgst=$agentPaymentRequestData['reqmarginCGst'];
$marginigst=$agentPaymentRequestData['reqmarginIGst'];
$marginsgst=$agentPaymentRequestData['reqmarginSGst'];
$marginGstType=$agentPaymentRequestData['marginGstType'];
$allinclusive=$agentPaymentRequestData['allinclusive'];

$totalClientCost=($quotationData['totalQuotCost']);
 
// $totalClientCostfc = $totalClientCost-1;
// $totalServiceTax = $serviceTax+$serviceTCS;
// $totalClientCostWOGST = $totalClientCostfc/(1+$totalServiceTax/100);
// echo $reqclientTcs = round($totalClientCostWOGST*$serviceTCS/100);

// $totalGSTAMT = $totalClientCostWOGST*$serviceTax/100;
// $totalTCSAMT = $totalClientCostWOGST*$serviceTCS/100;
 
?>
<style>
  /*costtoclientbox*/
  .clientcommubox{background-color:transparent; border:1px #b5cae0 solid; display: inline-table; width:30%; margin:0px 10px; text-align:left;height: 464px;}
  .clientcommubox .h{background-color:#f6fafe; color:#6f8ba9; padding:15px; font-weight:500; text-transform:uppercase;border-bottom:1px #b5cae085 solid; }
  .maintoph{background-color:#f6fafe; color:#6f8ba9; padding:15px; font-weight:500; text-transform:uppercase;border-bottom:1px #b5cae085 solid; }
  .clientcommubox .bodycontbox{background-color:#fff; padding:15px; border-bottom:1px #b5cae085 solid; color:#516b88;}
  .clientcommubox .textfieldb{padding:10px; border:1px #b5cae085 solid; width:40px;  }
  .clientcommubox .bodycontboxfooter{padding:15px;  color:#516b88; background-color:#dfebf6;}
  .clientcommubox .buttonbox{background-color:#fff; padding:15px;}
  .costtabsbox {
      float: left;
      text-align: left;
      margin-right: 10px;
      padding: 5px 15px;
      border-radius: 4px;
      box-shadow: 2px 2px 1px #5077994a;
      background-color: #f6fafe;
      padding-top: 10px;
  }
  .paymentboxtable {
         border-bottom: 1px #b5cae085 solid !important; padding:7px;
      background-color: #f6fafe !important; font-weight:500 !important; text-transform:uppercase !important; color:#6f8ba9 !important;
  }
  .paymentboxtablelist {
         border-bottom: 1px #b5cae085 solid !important; padding:7px;
      background-color: #fff !important;
  }
  .whiteColor{
    background-color: #fff;
  }
  .serviceActBtn{
    padding: 4px 6px !important;
    margin: 10px 0px;
    outline: 0px;
    font-size: 14px;
    border-radius: 3px;
    font-weight: 500;
    cursor: pointer;
    background-color: #f6fafe;
    color: #2c343f;
    border: 2px #ffffff85 solid;
    box-shadow: 1px 1px 2px #607D8B;
  }
</style>
<div  style="background-color:#FFFFFF; padding:0px; border-bottom:0px;">
   <!-- agent payment boxs -->
  <div style="text-align:center; margin-top:0px; background-color:#a7bed5;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  
    <tr>
      <td width="100%" align="left" colspan="2">
          <div style="padding:10px 20px; overflow:hidden;text-align:left; margin-top:0px; background-color:#a7bed5;border-bottom:1px solid #fff;">
            <?php 
            $newCurr = $quotationData['currencyId']; // total suppliers cost

            $totalPendingAmt = $totalreceived = 0;
            $r3=GetPageRecord('sum(amount) as totalreceived, spm.*','agentPaymentMaster spm',' agentPaymentId="'.$agentPaymentRequestData['id'].'" and paymentStatus=1'); 
            $agentPaymentData = mysqli_fetch_array($r3);
            $totalreceived = $agentPaymentData['totalreceived'];


            // costing components
            $companyCost = $quotationData['totalCompanyCost']; // total suppliers cost

            $clientCost = $quotationData['totalQuotCost']; // total client cost

            $totalMarkupCost = round($quotationData['totalMarkupCost']);
            $totalISOCost = round($quotationData['totalISOCost']);
            $totalConsortiaCost = round($quotationData['totalConsortiaCost']);
            $totalClientCommCost = round($quotationData['totalClientCommCost']);
            $totalDiscountCost = round($quotationData['totalDiscountCost']);
            $totalServiceTaxCost = round($quotationData['totalServiceTaxCost']);
            $totalTCSCost = round($quotationData['totalTCSCost']);
            $tcsVal = round($quotationData['tcs']);

            $clientCostWOGST = round($clientCost - $totalServiceTaxCost - $totalTCSCost);
            // calcuations
            $totalExpenseCost = $expenseAmount;
            $totalPendingAmt = round($clientCost-$totalreceived);
            ?>

      <!-- <div  class="costtabsbox">
              <div class="costtabamt">Purchase</div>
              <div style="font-size:24px;" id="totalCompanyCost">
                <?php echo round($companyCost); ?>
              </div>
            </div> -->
            
            <div  class="costtabsbox">
              <div class="costtabamt">Currency</div>
              <div style="font-size:24px;" ><?php echo getCurrencyName($baseCurrencyId); ?></div>
            </div>
            <div  class="costtabsbox">
              <div class="costtabamt">Sell Amt</div>
              <div style="font-size:24px;" id="totalClientCost"><?php echo round($clientCost); ?></div>
            </div>

            <div  class="costtabsbox">
              <div class="costtabamt">Received Amt</div>
              <div style="font-size:24px;color:#009900;" id="totalPaidCost"><?php echo round($totalreceived);?></div>
            </div>
            
            <div  class="costtabsbox">
              <div class="costtabamt">Pending Amt</div>
              <div style="font-size:24px; text-align:right;" ><?php 
                if(empty($totalPendingAmt)){  ?>
                <div style="font-size:24px;  color:#009900;" id="totalPending">Paid</div>
                <?php } else { ?>
                <div style="font-size:24px; color:#CC3300;text-align:right;" id="totalPending"><?php echo $totalPendingAmt; ?></div>
                <?php } ?>
              </div>
            </div>

            <div  class="costtabsbox">
              <div class="costtabamt">Tax Amt</div>
              <div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalServiceTaxCost); ?></div>
            </div>

            <div  class="costtabsbox">
              <div class="costtabamt">TCS Amt</div>
              <div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalTCSCost); ?></div>
            </div>

            <div  class="costtabsbox">
              <div class="costtabamt">Discout</div>
              <div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalDiscountCost); ?></div>
            </div>
            <div  class="costtabsbox">
              <div class="costtabamt">Expenses</div>
              <div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalExpenseCost); ?></div>
            </div>
            <!-- 
            <div  class="costtabsbox">
              <div class="costtabamt">
                <span style=" color: #6f6f6f; font-size: 12px; text-transform: uppercase;  font-weight: 500;">Net Margin</span>
              </div>
              <div style="font-size:24px;" id="totalMargin"><?php echo round($totalMarkupCost-$totalExpenseCost-$totalDiscountCost); ?></div>
            </div> -->

            <div  class="costtabsbox" style="float:right;margin-right: 15px;cursor:pointer;" onclick="alertspopupopen('action=dmcSchedulePayment&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $queryData['id']; ?>','1150px','auto');">
              <div style="font-size:12px; text-transform:uppercase; font-weight:500; color: #5f81a3;"><span style=" color: #6f6f6f; text-transform: uppercase;  font-weight: 500;">Agent</span></div>
              <div style="font-size:24px">Payment</div> 
            </div>

          </div>
      </td>

    </tr>
  </table>
  
 
</div>
<div style="background-color:#cadbec; overflow:hidden; height:600px; text-align:left; padding:20px;">
  <!-- left box cost to client -->
<div class="clientcommubox" id="costtoclientbox" style="background-color:none; ">
<div class="h">Cost to client </div>
<div class="bodycontbox">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><span class="header"> Cost</span></td>
    <td width="33%" align="right"><input name="reqclientCost" type="text" class="textfieldb" id="reqclientCost" style="padding-right:0px;border:0px; font-size:24px; width:200px; text-align:right;" value="<?php echo getTwoDecimalNumberFormat($clientCostWOGST); ?>" size="3" maxlength="3" readonly="readonly" /></td>
  </tr>
</table>
</div> 
<div class="bodycontbox gst">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><span class="header">GST Type </span></td>
    <td width="33%" align="right"> 
  <select name="clientGstType" id="clientGstType" onchange="calculateclientPaymentRequest('yes');" class="textfieldb" style="width:145px;"> 
    <option value="1" <?php if($clientGstType==1){ ?>selected="selected"<?php } ?>>Same State GST</option>
    <option value="2" <?php if($clientGstType==2){ ?>selected="selected"<?php } ?>>Other State GST</option> 
  </select></td>
  </tr>
</table>
</div>
<div class="bodycontbox gst">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><span class="header">TAX&nbsp;SLAB (%)</span></td>
    <td width="33%" align="right"> 
  <select name="reqclientGst" id="reqclientGst" onchange="calculateclientPaymentRequest('yes');" class="textfieldb" style="width:145px;" disabled="readonly">
    <?php 
  $rs2="";
  $rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Invoice" and status=1 order by gstValue asc'); 
  while($gstSlabData=mysqli_fetch_array($rs2)){
  ?>
  <option value="<?php echo $gstSlabData['gstValue'];?>" <?php if($serviceTax==$gstSlabData['gstValue']){ echo 'selected="selected"'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
  <?php
  } 
    ?> 
  </select></td>
  </tr>
</table>
</div>
<div class="bodycontbox gst">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><span class="header">CGST % </span></td>
    <td width="33%" align="right"><input name="reqclientCGst" type="number" class="textfieldb" id="reqclientCGst" value="<?php echo $clientcgst; ?>"  onkeyup="calculateclientPaymentRequest('yes');" style="width:58px;" disabled/></td>
  </tr>
</table>
</div>
<div class="bodycontbox gst">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">SGST % </span></td>
      <td width="33%" align="right"><input name="reqclientSGst" type="number" class="textfieldb" id="reqclientSGst" value="<?php echo $clientsgst; ?>" onkeyup="calculateclientPaymentRequest('yes');" style="width:58px;"  disabled/></td>
    </tr>
  </table>
</div>
 <div class="bodycontbox gst">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header"> IGST % </span></td>
      <td width="33%" align="right"><input name="reqclientIGst" type="number" class="textfieldb" id="reqclientIGst" value="<?php echo $clientigst; ?>" onkeyup="calculateclientPaymentRequest('yes');" style="width:58px;"  disabled/></td>
    </tr>
  </table>
</div>
<div class="bodycontbox gst">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header"> TCS % </span></td>
      <td width="33%" align="right">
        <input name="reqclientTCS" onchange="calculateclientPaymentRequest('yes');" type="number" class="textfieldb" id="reqclientTCS" value="<?php echo $tcsVal; ?>" style="width:58px;"  disabled/>
        <input type="hidden" name="reqclientTCSAMt" id="reqclientTCSAMt" value="<?php echo $totalTCSCost; ?>" disabled>
      </td>
    </tr>
  </table>
</div>

 <div class="bodycontboxfooter">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><span class="header">Total Client Cost </span></td>
      <td width="33%" align="right" style="font-size:24px;" id="totalClientCostDiv"><?php echo getTwoDecimalNumberFormat($clientCost); ?></td>
    </tr>
  </table><input name="totalClientCostVal" type="hidden" id="totalClientCostVal" value="<?php echo getTwoDecimalNumberFormat($clientCost); ?>" />
</div>
</div>

<!-- service charge middle box -->
  <div class="clientcommubox" id="costtomarginbox" style="display: none;">
    <div class="h">service charges </div>
    <div class="bodycontbox">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><span class="header">Service Charges </span></td>
        <td width="33%" align="right"><input name="reqmarginCost" type="text" class="textfieldb" id="reqmarginCost" style="border:0px; font-size:24px; width:200px; text-align:right;" value="<?php echo getTwoDecimalNumberFormat($totalServiceTaxCost); ?>" size="3" maxlength="3" readonly="readonly" /></td>
      </tr>
    </table>
    </div>
    <div class="bodycontbox">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><span class="header">GST Type </span></td>
        <td width="33%" align="right"> 
      <select name="marginGstType" id="marginGstType" onchange="calculateclientPaymentRequest('yes');" class="textfieldb" style="width:145px;"> 
        <option value="1" <?php if($marginGstType==1){ ?>selected="selected"<?php } ?>>Same State GST</option>
        <option value="2" <?php if($marginGstType==2){ ?>selected="selected"<?php } ?>>Other State GST</option> 
      </select></td>
      </tr>
    </table>
    </div>
    <div class="bodycontbox">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><span class="header">GST %</span></td>
        <td width="33%" align="right"> 
      <select name="reqmarginGst" id="reqmarginGst" onchange="calculateclientPaymentRequest('yes');" class="textfieldb" style="width:145px;">
    <option value="0" <?php if($serviceTax==0){ ?>selected="selected"<?php } ?>>Tax Inclusive</option>
    <option value="5" <?php if($serviceTax==5){ ?>selected="selected"<?php } ?>>5</option>
    <option value="12" <?php if($serviceTax==12){ ?>selected="selected"<?php } ?>>12</option>
    <option value="18" <?php if($serviceTax==18){ ?>selected="selected"<?php } ?>>18</option> 
      </select>
      </td>
      </tr>
    </table>
    </div>
    <div class="bodycontbox">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><span class="header">CGST % </span></td>
        <td width="33%" align="right"><input name="reqmarginCGst" type="number" class="textfieldb" id="reqmarginCGst"  value="<?php echo $margincgst; ?>"  readonly="readonly" style="width:58px;" /></td>
      </tr>
    </table>
    </div> 
    <div class="bodycontbox">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><span class="header">SGST % </span></td>
          <td width="33%" align="right"><input name="reqmarginSGst" type="number" class="textfieldb" id="reqmarginSGst"  value="<?php echo $marginsgst; ?>"  readonly="readonly" style="width:58px;" /></td>
        </tr>
      </table>
    </div>
     <div class="bodycontbox">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><span class="header">IGST % </span></td>
          <td width="33%" align="right"><input name="reqmarginIGst" type="number" class="textfieldb" id="reqmarginIGst"  value="<?php echo $marginigst; ?>"  readonly="readonly" style="width:58px;" /></td>
        </tr>
      </table>
    </div>
     <div class="bodycontboxfooter">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><span class="header">Total  Charges </span></td>
          <td width="33%" align="right" style="font-size:24px;" id="totalMarginCostDiv"><?php echo getTwoDecimalNumberFormat($totalServiceTaxCost); ?></td>
        </tr>
      </table><input name="totalMarginCostVal" type="hidden" id="totalMarginCostVal" value="<?php echo getTwoDecimalNumberFormat($totalServiceTaxCost); ?>" />
    </div>
  </div>

<script>
function calculateclientPaymentRequest(status){
  var clientCost = finaltotalmargincost = reqclientGstTotal = 0;
  var reqclientCost = Number($('#reqclientCost').val()); //client cost without gst and tcs
  var clientGstType = Number($('#clientGstType').val()); // gst state type

  var reqclientGst = Number($('#reqclientGst').val()); // gst %
  var reqmarginCost = Number($('#reqmarginCost').val()); // total gst amount cost
  
  var reqclientTCS = Number($('#reqclientTCS').val()); // total tcs value 
  var reqclientTCSAMt = Number($('#reqclientTCSAMt').val()); // total tcs amount 

  $('#costtomarginbox').css('pointer-events','all');
  $('#costtomarginbox').css('opacity','1'); 
  $('.bodycontbox.gst').css('pointer-events','all');
  $('.bodycontbox.gst').css('opacity','1'); 
  
  $('#reqclientCGst').val(0);
  $('#reqclientSGst').val(0); 
  $('#reqclientIGst').val(0); 

  $('#reqmarginCGst').val(0);
  $('#reqmarginSGst').val(0); 
  $('#reqmarginIGst').val(0); 

  //----------------- Client GST ------------------------ 
  $('#reqmarginGst').val(0);
  $('#costtomarginbox').css('pointer-events','none');
  $('#costtomarginbox').css('opacity','0.5');
    
  if(reqclientGst!=0){ 
    var reqclientGstTotal = Math.round(reqclientGst*reqclientCost/100); 
  }

  if(clientGstType==1){
    var reqclientIGst= $('#reqclientIGst').val(0);
    var reqclientCGst= $('#reqclientCGst').val(reqclientGst/2);
    var reqclientSGst= $('#reqclientSGst').val(reqclientGst/2); 
  } 
  if(clientGstType==2){ 
    $('#reqclientCGst').val(0);
    $('#reqclientSGst').val(0); 
    $('#reqclientIGst').val($('#reqclientGst').val()); 
  }
  if(reqclientGst==0){ 
    $('#reqclientCGst').val(0);
    $('#reqclientSGst').val(0); 
    $('#reqclientIGst').val(0); 
  }

  var marginGstType = Number($('#marginGstType').val()); // center box gst state type  
  var reqmarginGst = Number($('#reqmarginGst').val());  // center box gst % 
   

  //parseFloat("123.456").toFixed(2);
  //----------------- Total GST ------------------------

  clientCost=Math.round(reqclientTCSAMt+reqclientGstTotal+reqclientCost);
  $('#totalMarginCostDiv').text(parseFloat(reqclientGstTotal).toFixed(2));
  $('#totalMarginCostVal').val(parseFloat(reqclientGstTotal).toFixed(2)); 

  // $('#totalClientCostDiv').text(parseFloat(clientCost).toFixed(2));
  // $('#totalClientCostVal').val(parseFloat(clientCost).toFixed(2)); 

  $('#clientrequesttotalpricediv').val(); 
  $('#totalcosting').load('agent_total_costing.php?paymentid=<?php echo $_REQUEST['paymentid']; ?>&totalClientCost='+encodeURI(clientCost)+'&totalMarginCost='+encodeURI(reqclientGstTotal)+'&reqclientTCS='+encodeURI(reqclientTCS)+'&reqclientTCSAMt='+encodeURI(reqclientTCSAMt)+'&reqclientCGst='+$('#reqclientCGst').val()+'&reqclientSGst='+$('#reqclientSGst').val()+'&reqclientIGst='+$('#reqclientIGst').val()+'&reqmarginCGst='+$('#reqmarginCGst').val()+'&reqmarginSGst='+$('#reqmarginSGst').val()+'&reqmarginIGst='+$('#reqmarginIGst').val()+'&reqclientCost='+encodeURI(reqclientCost)+'&reqmarginCost='+encodeURI(reqmarginCost)+'&clientGstType='+clientGstType+'&reqclientGst='+reqclientGst+'&reqmarginGst='+reqmarginGst+'&marginGstType='+marginGstType+'&queryId=<?php echo $queryData['id']; ?>&status='+status+'&serviceTCS=<?php echo $quotationData['tcs']; ?>');
}
calculateclientPaymentRequest('na');
</script>
  <div class="clientcommubox"> <div class="h">Costing</div> <div id="totalcosting"> </div> </div>
 </div>

