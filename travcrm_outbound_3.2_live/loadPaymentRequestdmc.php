<?php
include "inc.php"; 
include "config/logincheck.php"; 

$rs=''; 
$rs=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,'id='.clean(decode($_GET['paymentid'])).''); 
$prmData=mysqli_fetch_array($rs); 
$paymentId = $prmData['id'];


$queryQuery='';    
$queryQuery=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($_GET['id']).''); 
$queryData=mysqli_fetch_array($queryQuery);  

$companyName = showClientTypeUserName($queryData['clientType'],$queryData['companyId']);


$quotQuery="";
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$prmData['quotationId'].'" and status=1 '); 
$quotationData=mysqli_fetch_array($quotQuery);
$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
 
$currencyId = ($quotationData['currencyId'])>0 ? $quotationData['currencyId']:$baseCurrencyId;

// $where1='queryId="'.$queryData['id'].'" and paymentId="'.$prmData['id'].'"'; 
// $rs1=GetPageRecord('id',_AGENT_PAYMENT_REQUEST_,$where1); 
// $hotelduplicate=mysqli_fetch_array($rs1);

// if($hotelduplicate['id']=='' || $hotelduplicate['id']=='0'){
//   $namevalue ='queryId="'.$queryId.'",quotationId="'.$quotationId.'",paymentId="'.$prmData['id'].'"';
//   $paymentId = addlistinggetlastid(_AGENT_PAYMENT_REQUEST_,$namevalue); 

// }
// $where1='queryId="'.$queryData['id'].'" and quotationId="'.$quotationId.'" and paymentId="'.$prmData['id'].'"'; 
// $rs1=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,$where1); 
// $agentPaymentRequestData=mysqli_fetch_array($rs1);
// $clientgst=$agentPaymentRequestData['reqclientGst'];
// $reqclientTCS=$agentPaymentRequestData['reqclientTCS'];
// $clientcgst=$agentPaymentRequestData['reqclientCGst'];
// $clientigst=$agentPaymentRequestData['reqclientIGst'];
// $clientsgst=$agentPaymentRequestData['reqclientSGst'];
// $clientGstType=$agentPaymentRequestData['clientGstType'];
// $margingst=$agentPaymentRequestData['reqmarginGst'];
// $margincgst=$agentPaymentRequestData['reqmarginCGst'];
// $marginigst=$agentPaymentRequestData['reqmarginIGst'];
// $marginsgst=$agentPaymentRequestData['reqmarginSGst'];
// $marginGstType=$agentPaymentRequestData['marginGstType'];
// $allinclusive=$agentPaymentRequestData['allinclusive'];

// $totalClientCost=($quotationData['totalQuotCost']);
 
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
  .paidList{
      padding: 10px 20px;
      overflow: hidden;
      text-align: left;
      padding-top: 20px;
      background-color: #ddd;
      border-bottom: 1px solid #fff;
  }
  .heading2{
    line-height: 26px;
    font-size: 13px;
    text-transform: uppercase;
    background-color: #eae9ee ;

  }
  .heading3{
    line-height: 25px;
    font-size: 13px;
    text-transform: uppercase;

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
              $newCurr = $prmData['currencyId']; // total suppliers cost

              $totalPendingAmt = $totalreceived = 0;
              $r3=GetPageRecord('sum(amount) as totalreceived, spm.*','agentPaymentMaster spm',' paymentId="'.$paymentId.'" and paymentStatus=1'); 
              $agentPaymentData = mysqli_fetch_array($r3);
              $totalreceived = $agentPaymentData['totalreceived'];

              // costing components
              $companyCost = round($prmData['totalCompanyCost']); // total suppliers cost

              $clientCost = round($prmData['totalClientCost']); // total client cost

              $totalMarkupCost = round($prmData['totalMarkupCost']);
              $totalISOCost = round($prmData['totalISOCost']);
              $totalConsortiaCost = round($prmData['totalConsortiaCost']);
              $totalClientCommCost = round($prmData['totalClientCommCost']);
              $totalDiscountCost = round($prmData['totalDiscountCost']);
              $totalServiceTaxCost = round($prmData['totalServiceTaxCost']);
              $totalTCSCost = round($prmData['totalTCSCost']);
              $tcsVal = round($prmData['tcsTax']);
              
              $clientCostWOGST = round($clientCost - $totalServiceTaxCost - $totalTCSCost);
              // calcuations
              $totalExpenseCost = $expenseAmount;
              $totalPendingAmt = round($clientCost-$totalreceived);



              // $r2='';
              // $r2=GetPageRecord('id','agentSchedulePaymentMaster','paymentId="'.$paymentId.'" and amount!="" and value!=""'); 
              // if(mysqli_num_rows($r2) == 0){
              //   $namevalue ='type=1, value=100, status=1, dueDate="'.date('Y-m-d').'", amount="'.$prmData['totalClientCost'].'", paymentId="'.$paymentId.'",quotationId="'.$quotationId.'"';
              //   $scheduleId = addlistinggetlastid('agentSchedulePaymentMaster',$namevalue); 
              // }


              $r2='';
              $r2=GetPageRecord('sum(amount) as totalAmount,ssp.*','agentSchedulePaymentMaster ssp','paymentId="'.$paymentId.'" and amount>0 and value>0');
              if( mysqli_num_rows($r2) > 0){
                $schedulePaymentData = mysqli_fetch_array($r2);
                $remainAmount = $clientCost-$schedulePaymentData['totalAmount']; 
                
                $r3=GetPageRecord('sum(amount) as totalpaid, spm.*','agentPaymentMaster spm',' paymentId="'.$paymentId.'" and paymentStatus=1'); 
                $agentPaymentData = mysqli_fetch_array($r3);
                $paid = ($agentPaymentData['totalpaid']==0)?0:$agentPaymentData['totalpaid'];
                
                $remainValue = round(($remainAmount/$clientCost*100),2);
                if($schedulePaymentData['totalAmount'] < $clientCost  && $remainAmount > 0){
                  $namevalue1 ='type=1,status=1,dueDate="'.date('Y-m-d').'",value="'.$remainValue.'",amount="'.$remainAmount.'",paymentId="'.$paymentId.'",quotationId="'.$quotationId.'"';
                  $scheduleId2 = addlistinggetlastid('agentSchedulePaymentMaster',$namevalue1); 
                } 
              }else{
                $namevalue ='type=1, value=100, status=1, dueDate="'.date('Y-m-d').'", amount="'.$clientCost.'", paymentId="'.$paymentId.'",quotationId="'.$quotationId.'"';
                $scheduleId = addlistinggetlastid('agentSchedulePaymentMaster',$namevalue); 
              }
              $totalPending = $clientCost-$paid;  
              ?>

              <div  class="costtabsbox">
                <div class="costtabamt">Currency</div>
                <div style="font-size:24px;" ><?php echo getCurrencyName($newCurr); ?></div>
              </div>
              <div  class="costtabsbox">
                <div class="costtabamt">Sell Amt</div>
                <div style="font-size:24px;" id="totalClientCost"><?php echo  getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$clientCost); //round($clientCost); ?></div>
              </div>
             
              <div  class="costtabsbox">
                <div class="costtabamt">Received Amt</div>
                <div style="font-size:24px;color:#009900;" id="totalPaidCost"><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalreceived); //round($totalreceived);?></div>
              </div>
              
              <div  class="costtabsbox">
                <div class="costtabamt">Pending Amt</div>
                <div style="font-size:24px; text-align:right;" ><?php 
                  if(empty($totalPendingAmt)){  ?>
                  <div style="font-size:24px;  color:#009900;" id="totalPending">Paid</div>
                  <?php } else { ?>
                  <div style="font-size:24px; color:#CC3300;text-align:right;" id="totalPending"><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalPendingAmt); //$totalPendingAmt; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div  class="costtabsbox">
                <div class="costtabamt">Tax Amt</div>
                <div style="font-size:24px;" id="totalTaxAmount"><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalServiceTaxCost); //round($totalServiceTaxCost); ?></div>
              </div>

              <div  class="costtabsbox">
                <div class="costtabamt">TCS Amt</div>
                <div style="font-size:24px;" id="totalTaxAmount"><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalTCSCost); //round($totalTCSCost); ?></div>
              </div>

              <div  class="costtabsbox">
                <div class="costtabamt">Discount</div>
                <div style="font-size:24px;" id="totalTaxAmount"><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalDiscountCost); //round($totalDiscountCost); ?></div>
              </div>
              <div  class="costtabsbox">
                <div class="costtabamt">Expenses</div>
                <div style="font-size:24px;" id="totalTaxAmount"><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalExpenseCost); //round($totalExpenseCost); ?></div>
              </div>
              <!-- 
              <div  class="costtabsbox">
                <div class="costtabamt">
                  <span style=" color: #6f6f6f; font-size: 12px; text-transform: uppercase;  font-weight: 500;">Net Margin</span>
                </div>
                <div style="font-size:24px;" id="totalMargin"><?php echo round($totalMarkupCost-$totalExpenseCost-$totalDiscountCost); ?></div>
              </div> -->

              <div  class="costtabsbox" style="float:right;margin-right: 15px;cursor:pointer;display: none;" onclick="alertspopupopen('action=dmcSchedulePayment&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $queryData['id']; ?>','1150px','auto');">
                <div style="font-size:12px; text-transform:uppercase; font-weight:500; color: #5f81a3;"><span style=" color: #6f6f6f; text-transform: uppercase;  font-weight: 500;">Agent</span></div>
                <div style="font-size:24px">Payment</div> 
              </div>

            </div>
        </td>

      </tr>
    </table>
  </div>
<?php 
$cnt2=1;
$r31=="";
// echo 'scheduleId in ( select id from agentSchedulePaymentMaster where 1 and paymentId="'.$paymentId.'"  ) and paymentStatus=1';
$r31=GetPageRecord('*','agentPaymentMaster',' scheduleId in ( select id from agentSchedulePaymentMaster where 1 and paymentId="'.$paymentId.'"  ) and paymentStatus=1'); 
if(mysqli_num_rows($r31) > 0){ ?>
  <div class="paidList">
    <table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-color: #ddd;background-color: #fff;font-size: 13px;" class="table-strip ">
      <thead> 
      <tr>
      <th class="heading2"><strong >SR.&nbsp;NO.</strong></th>
      <th class="heading2"><strong >Payment Type</strong></th>
      <th class="heading2"><strong >Amount</strong></th>
      <th class="heading2"><strong >Payment&nbsp;Through</strong></th>
      <th class="heading2"><strong >Payment&nbsp;Name</strong></th>
      <th class="heading2"><strong >Transaction Id/Cheque No.</strong></th>
      <th class="heading2"><strong >Remarks</strong></th>
      <th class="heading2"><strong >Status</strong></th>
      <th class="heading2"><strong >Action</strong></th>
      </tr>
      </thead>
      <tbody>
      <?php 
      while($agentPaymentDataList = mysqli_fetch_array($r31)){
        $r212=GetPageRecord('*','agentSchedulePaymentMaster','id="'.$agentPaymentDataList['scheduleId'].'"'); 
        $agentSchedulePayData2 = mysqli_fetch_array($r212);
      ?>
      <tr>
      <td><?php echo $cnt2; ?></td>
      <td><?php if($agentPaymentDataList['paymentType'] == 1){ echo "On Credit"; }elseif($agentPaymentDataList['paymentType'] == 2){ echo "Advanced";  }elseif($agentPaymentDataList['paymentType'] == 3){ echo "Direct&nbsp;Payment";  }else{ echo "Full Payment"; } ?></td>
      <td><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$agentPaymentDataList['amount']) ;?></td>
      <!-- added by agent payment Through  -->
      <td>
        <?php 
        $rsMkt2=GetPageRecord('name','paymentTypeMaster',' id="'.$agentPaymentDataList['paymentBy'].'"');
          $resMarkt2=mysqli_fetch_array($rsMkt2);
        echo$resMarkt2['name'];   ?>
      </td>
      <td>
      <?php 
        if($agentPaymentDataList['bankName']!=''){
          echo $agentPaymentDataList['bankName'];
        }else{
            $rsMkt2=GetPageRecord('bankName','bankMaster',' id="'.$agentPaymentDataList['bankId'].'"');
            $resMarkt2=mysqli_fetch_array($rsMkt2);
            echo $resMarkt2['bankName'];
        }
          ?>
      </td>
      <td><?php echo $agentPaymentDataList['chequeNo'];?></td>
      <td><?php echo $agentPaymentDataList['remark'];?></td>
      <td><?php if($agentPaymentDataList['paymentStatus'] == 1){ echo "Paid"; }else{ echo "....";} ?></td>
      <td><input type="button" value="Payment Receipt" onclick="openPaymentReceipt('openpaymentreceipt','850px','<?php echo $agentSchedulePayData2['quotationId']; ?>','<?php echo $agentSchedulePayData2['id']; ?>','<?php echo $queryData['id']; ?>');" style="cursor: pointer;"></td>
      </tr>
      <?php
      $cnt2++;
      }
      ?>
      </tbody> 
    </table>
  </div>
  <?php
}
?>
<div class="paidList" style="background-color:#fcfcfc">
  <div class="totalCost" style="display:none;">
    <div style="width: 68px;" class="tm"><strong>Total&nbsp;Amount<br><?php echo $clientCost; ?></strong></div>
    <div style="width: 38px;" class="tm"><strong>Paid<br><?php echo $paid; ?></strong></div>
    <div style="width: 48px;" class="tm"><strong>Pending<br><?php echo $totalPending; ?></strong></div>
    <!-- <div style="width: 80px; margin-left: 10px; float: right; background-color: #b7b7b7; color: #233a49;" class="tm"><strong>Payment&nbsp;Terms<br><?php echo $paymentTerms; ?></strong></div> -->
    <div style="width: 260px;margin-left: 10px;float: right;background-color: #b7b7b7;color: #233a49;padding: 0 10px;border: 0;" class="tm">
    
    
    <div style="width: 260px;margin-left: 10px;float: right;background-color: #b7b7b7;color: #233a49;padding: 0 10px;border: 0;" class="tm">
    <div style="width: 260px;margin-left: 10px;float: right;background-color: #b7b7b7;color: #233a49;padding: 3px 10px;border: 0;" class="tm">
    <?php 
    $a=GetPageRecord('*','agentSchedulePaymentMaster',' paymentId="'.$paymentId.'" and quotationId = "'.$quotationId.'" and scheduleStatus=1 order by id asc'); 
    if(mysqli_num_rows($a)>0){
    $SchedulePayData = mysqli_fetch_array($a);
    ?>
    <a target="_blank" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>&quotationId=<?php echo encode($quotationId); ?>&scheduledAmount=yes&paymentId=<?php echo encode($SchedulePayData['paymentId']); ?>"><input type="button" value="Send&nbsp;Scheduled&nbsp;Payment" class="updatePaymentBtn" style="display:inline;" /></a>
      <?php } ?>
    </div>
    </div>
    </div>
  </div> 
  <div id="loadDmcPayment" style="display:none;"></div>
  <div class="schedulebox" >

    <div style="padding:10px 20px; overflow:hidden;text-align:left; margin-top:0px; background-color:#ffffff;border: 1px solid #ddd5d5;"> 
        <table width="100%" cellpadding="0" celspacing="0" border="0" ><tbody><tr>
          <td align="left" valign="middle"> <strong style="font-size: 16px;color: #2c343f;width: 100%;">AGENT - <?php echo strtoupper($companyName); ?></strong></td>
          <td align="right" valign="middle" width="300px"><div class="serviceActioinBox">
            <?php 
            $a=GetPageRecord('*','agentSchedulePaymentMaster',' paymentId="'.$paymentId.'" and quotationId = "'.$quotationId.'" and scheduleStatus=1 order by id asc'); 
            if(mysqli_num_rows($a)>0){
            $SchedulePayData = mysqli_fetch_array($a);
            ?>
            <a target="_blank" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>&quotationId=<?php echo encode($quotationId); ?>&scheduledAmount=yes&paymentId=<?php echo encode($SchedulePayData['paymentId']); ?>"><input type="button" value="Send&nbsp;Scheduled&nbsp;Payment" class="updatePaymentBtn" style="display:inline;" /></a>
            <?php } ?> 
            </div>
          </td>
         
          </tr>
        </tbody></table> 
      </div>

    <table   width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd5d5" style="border-collapse: collapse;">
      <thead>
      <tr>
        <td width="2%" class="heading3" ><strong>#</strong></td> 
        <td width="10%" class="heading3" ><strong>Payment Type</strong></td>
        <td width="5%" class="heading3" ><strong>Type</strong></td>
        <td width="10%" class="heading3" align="right"><strong>Value</strong></td>
        <td width="10%" class="heading3" align="right"><strong>Amount</strong></td>
        <td width="10%" class="heading3" ><strong>Due&nbsp;Date</strong></td>
        <td width="10%" class="heading3" ><strong>Due&nbsp;Time</strong></td>
        <td class="heading3" ><strong>Remark</strong></td>
        <td width="15%" colspan="3" class="heading3" ><strong id="updateMsg" style="color:#006600;">&nbsp;</strong></td>
      </tr>
      </thead>
      <tbody> 
      <?php 
      $cnt = 1;
      $r21="";
      
      $r21=GetPageRecord('*','agentSchedulePaymentMaster',' paymentId="'.$paymentId.'" and quotationId = "'.$quotationId.'" and id not in ( select scheduleId from agentPaymentMaster where paymentId="'.$paymentId.'" and paymentStatus=1 ) and value>0 and amount>0 order by id asc'); 
      while($agentSchedulePayData = mysqli_fetch_array($r21)){

        if($agentSchedulePayData['dueDate'] == "0000-00-00"){ $dueDate = date("Y-m-d"); }else{ $dueDate = date('Y-m-d',strtotime($agentSchedulePayData['dueDate'])); }
        if($agentSchedulePayData['dueTime'] == "00:00:00"){ $dueTime = date('H:i'); }else{ $dueTime = date('H:i',strtotime($agentSchedulePayData['dueTime'])); }
        //echo $dueDate;
      ?>
      <tr>
        <td><strong><?php echo $cnt; ?></strong></td> 
        <td align="right">
          <select id="paymentType<?php echo $agentSchedulePayData['id']; ?>" name="paymentType<?php echo $agentSchedulePayData['id']; ?>" class="paycl inputText" >  
            <option value="1" <?php if($agentSchedulePayData['paymentType'] == 1){ ?> selected="selected" <?php } ?>>On Credit</option>
            <option value="2" <?php if($agentSchedulePayData['paymentType'] == 2){ ?> selected="selected" <?php } ?> selected >Advanced Payment</option>
            <option value="3" <?php if($agentSchedulePayData['paymentType'] == 3){ ?> selected="selected" <?php } ?>>Direct&nbsp;Payment</option>
            <option value="4" <?php if($agentSchedulePayData['paymentType'] == 4){ ?> selected="selected" <?php } ?>>Full Payment</option>
          </select>
        </td>
        <td align="center">
          <select id="type<?php echo $agentSchedulePayData['id']; ?>" onchange="calculateAmtPer<?php echo $agentSchedulePayData['id']; ?>(1);" name="type<?php echo $agentSchedulePayData['id']; ?>" class="paycl gstInput inputText" autocomplete="off" >  
            <option value="1" <?php if($agentSchedulePayData['type'] == 1){ ?> selected="selected" <?php } ?>>%</option>  
            <option value="2" <?php if($agentSchedulePayData['type'] == 2){ ?> selected="selected" <?php } ?>>Flat</option> 
          </select>
        </td>
        <td align="center">
          <input type="text" class="paycl inputText" name="value<?php echo $agentSchedulePayData['id']; ?>" id="value<?php echo $agentSchedulePayData['id']; ?>" value="<?php echo ($agentSchedulePayData['value']);  ?>" maxlength="20" displayname="Amount Value" onKeyUp="calculateAmtPer<?php echo $agentSchedulePayData['id']; ?>(2);" autocomplete="off" style="text-align:right;width:95%!important;">

        </td>

        <td align="center">
          
        <input  type="text" class="paycl inputText" name="amount<?php echo $agentSchedulePayData['id']; ?>" id="amount<?php echo $agentSchedulePayData['id']; ?>" value="<?php echo $agentSchedulePayData['amount']; //getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$agentSchedulePayData['amount']); ?>" maxlength="20" autocomplete="off" disabled style="text-align:right;width:95%!important;border: none;">

        </td>
        
        <td align="center"> <input type="date" class="gridfield inputText" id="dueDate<?php echo $agentSchedulePayData['id']; ?>" name="dueDate<?php echo $agentSchedulePayData['id']; ?>" value="<?php echo $dueDate;?>" style="text-align:left;width:95%;padding: 3px;border-radius: 2px;" ></td>
        
        <td align="center"><input type="time" name="dueTime<?php echo $agentSchedulePayData['id']; ?>" id="dueTime<?php echo $agentSchedulePayData['id']; ?>" class="inputText" value="<?php echo $dueTime; ?>" min="10:00" max="18:00" style="text-align:left;width:90%;padding: 3px;border-radius: 2px;"></td>
        
        <td align="center"><textarea name="remarks<?php echo $agentSchedulePayData['id']; ?>" class="paycl inputText" id="remarks<?php echo $agentSchedulePayData['id']; ?>" style="height: 16px;width: 95%"><?php echo $agentSchedulePayData['remarks']; ?></textarea></td>
        <td align="left"> 
          <input name="button" type="button" class="updatePaymentBtn" onclick="savePartial<?php echo $agentSchedulePayData['id']; ?>();" value="<?php if($agentSchedulePayData['paymentType']>0) echo 'Saved'; else echo 'Save'; ?>" style="display:inline; background-color: #233a49;" />   
        </td>
        <td align="left"> 
			 <?php if($agentSchedulePayData['status'] == 1){ ?> 
				<a target="_blank" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>=&paymentscheduleId=<?php echo encode($agentSchedulePayData['id']); ?>&quotationId=<?php echo encode($quotationId); ?>&agentpaymentrequestLink=1"><input type="button" value="Payment&nbsp;Request&nbsp;Link" class="updatePaymentBtn" style="display:inline;" /> <?php } ?></a>
				
			</td>
        <td align="left"> 
         <?php if($agentSchedulePayData['status'] == 1){ ?> 
          <input type="button" value="Update&nbsp;Payment" class="updatePaymentBtn" onclick="updatePartialPayment<?php echo $agentSchedulePayData['id']; ?>();" style="display:inline;" /> <?php  } ?>
        </td>
        
        <script type="text/javascript"> 
          calculateAmtPer<?php echo $agentSchedulePayData['id']; ?>();  
          function calculateAmtPer<?php echo $agentSchedulePayData['id']; ?>(actionTo){
            var totalAmt = Number('<?php echo $clientCost; //getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$clientCost); ?>');
            // var totalAmt = Number('<?php echo $clientCost; ?>');
            var amount = Number($('#amount<?php echo $agentSchedulePayData['id']; ?>').val());
            var value = Number($('#value<?php echo $agentSchedulePayData['id']; ?>').val());
            var type = Number($('#type<?php echo $agentSchedulePayData['id']; ?> :selected').val());
            if(type==2 && actionTo == 2){
              $('#amount<?php echo $agentSchedulePayData['id']; ?>').val(Number(value));
            }
            if(type==1 && actionTo == 2){
              $('#amount<?php echo $agentSchedulePayData['id']; ?>').val(Number(value/100*totalAmt));
            }
            if(type==2 && actionTo == 1){
              $('#value<?php echo $agentSchedulePayData['id']; ?>').val(Number(amount));
            }
            if(type==1 && actionTo == 1){
              $('#value<?php echo $agentSchedulePayData['id']; ?>').val(Number(amount/totalAmt*100));
            }
          }
          
          function savePartial<?php echo $agentSchedulePayData['id']; ?>(){
            var type = $("#type<?php echo $agentSchedulePayData['id']; ?>").val();
            var paymentType = $("#paymentType<?php echo $agentSchedulePayData['id']; ?>").val();
            var value = $("#value<?php echo $agentSchedulePayData['id']; ?>").val();
            var amount = $("#amount<?php echo $agentSchedulePayData['id']; ?>").val();
            var dueDate = $("#dueDate<?php echo $agentSchedulePayData['id']; ?>").val();
            var dueTime = $("#dueTime<?php echo $agentSchedulePayData['id']; ?>").val();
            var remark = $("#remarks<?php echo $agentSchedulePayData['id']; ?>").val();
            $("#updateMsg").text('Saved Successfull.');
            $("#loadDmcPayment").load("loadSave_DmcPayment.php?action=updatePartialAmount&paymentId=<?php echo $paymentId; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&scheduleId=<?php echo $agentSchedulePayData['id']; ?>&quotationId=<?php echo $quotationId; ?>&paymentType="+encodeURI(paymentType)+"&type="+encodeURI(type)+"&value="+encodeURI(value)+"&amount="+encodeURI(amount)+"&dueDate="+encodeURI(dueDate)+"&dueTime="+encodeURI(dueTime)+"&remark="+encodeURI(remark)+'&currencyId=<?php echo $currencyId; ?>');
          } 
          function updatePartialPayment<?php echo $agentSchedulePayData['id']; ?>(){
            var value = $("#value<?php echo $agentSchedulePayData['id']; ?>").val();
            var amount = $("#amount<?php echo $agentSchedulePayData['id']; ?>").val();
            alertspopupopen('action=agentUpdatePayment&scheduleId=<?php echo $agentSchedulePayData['id'];?>','800px','auto'); 
          }
           
          
          // for Showing amount currency wise
          // calculateAmtPerShow<?php echo $agentSchedulePayData['id']; ?>();  
          // function calculateAmtPerShow<?php echo $agentSchedulePayData['id']; ?>(actionTos){
          //   var totalAmt = Number('<?php echo getChangeCurrencyValue_New($currencyId,$quotationId,$clientCost); ?>');
          //   // var totalAmt = Number('<?php echo $clientCost; ?>');
          //   var amountShow = Number($('#amountShow<?php echo $agentSchedulePayData['id']; ?>').val());
          //   var valueShow = Number($('#valueShow<?php echo $agentSchedulePayData['id']; ?>').val());
          //   var type = Number($('#type<?php echo $agentSchedulePayData['id']; ?> :selected').val());
          //   if(type==2 && actionTos == 2){
          //     $('#amountShow<?php echo $agentSchedulePayData['id']; ?>').val(Number(valueShow));
          //   }
          //   if(type==1 && actionTos == 2){
          //     $('#amountShow<?php echo $agentSchedulePayData['id']; ?>').val(Number(valueShow/100*totalAmt));
          //   }
          //   if(type==2 && actionTos == 1){
          //     $('#valueShow<?php echo $agentSchedulePayData['id']; ?>').val(Number(amountShow));
          //   }
          //   if(type==1 && actionTos == 1){
          //     $('#valueShow<?php echo $agentSchedulePayData['id']; ?>').val(Number(amountShow/totalAmt*100));
          //   }
          // }
        </script>
      </tr>
      <?php $cnt++; } ?> 
      </tbody>
    </table>  
  </div>
</div> 

<style type="text/css">
  .table-strip tr:nth-child(even),.table-strip thead{
    background-color: #efeaea;
  }
  .closeBtn{
    position: absolute;
      right: 15px;
      color: #ffffff;
  }
  .tm{
    text-align: right;
    display: inline-block;
    padding: 5px;
    border-radius: 5px;
    background-color: white;
    border: 1px solid;
    font-size: 11px;
  }
  .totalCost{
      background-color: #b7b7b7;
    padding: 5px;
    overflow: auto;
    text-align: left;
    margin-bottom: 0px;
  }
  .gstInput{
    width: 80px;
    color: black;
    text-align: center;
    padding: 7px 9px 6px 6px!important;
  }
  .schedulebox .inputText{
    text-align: center;
    border-radius: 2px;
    padding: 6px 2px;
    border: 1px solid #ddd5d5;
  }
  .updatePaymentBtn{
    padding: 5px 10px 5px 10px!important;
      border-radius: 3px;
      background-color: #43a426;
      color: white;
      border: 2px solid #838a81!important;
      cursor: pointer;
      font-size: 12px;
  }
  #loapaymentreceipt{ 
    background-color: #00000094;
    background-color: rgba(50, 61, 76, 0.91);
    width: 100%;
    height: 100%;
    position: fixed;
    left: 0px;
    top: 0px;
    overflow: auto;
    display: none;
    z-index: 9999;

  }
  #loapaymentreceipt .payemntreceipt {
    background-color: #FFFFFF;
    max-width: 850px;
    margin: auto;
    margin-top: 60px;
    margin-bottom: 40px;
  }
  .container--flex {
    display: inline-flex;
    border: 1px solid #ddd;
    
  }
  .flex-child {
      flex: 1;
      border-radius: 4px;
      min-width: 200px;
      line-height: 50px;
      margin: 10px;
      text-align: center;
      vertical-align: unset;
      background-color: #F06292;
  }
</style>

<div id="loapaymentreceipt" style="background-image: url('images/bgpop.png'); background-repeat: repeat;display:none;">
  <div class="payemntreceipt"></div>
</div>

<script type="text/javascript">
  function openPaymentReceipt(url,popwidth,quotationId,scheduleId,queryId){
    $("#loapaymentreceipt").show();
    $(".payemntreceipt").load('paymentReceipt.php?action='+url+'&quotationId='+quotationId+'&scheduleId='+scheduleId+'&queryId='+queryId);
    $(".payemntreceipt").css('width',popwidth);
  }
  function receiptalertClose(){
    $("#loapaymentreceipt").hide();
    window.location.reload();
    parent.$('#pageloading').hide();
    parent.$('#pageloader').hide();
    parent.masters_alertspopupopenClose();
  }
</script>

<!-- generate invoice code here -->
<?php 

$rs = '';
$invQuery1 = '';
$invQuery1 = GetPageRecord('*', _INVOICE_MASTER_,'quotationId="'.$quotationId .'" and deletestatus=0');
?>
<!-- <div class="paidList" style=" background-color:#ffffff;">
  <hr style="background-color:#ffffff;">
</div> -->
  <div style="overflow:hidden;text-align:left;margin: 30px 0;padding: 0 10px;background-color:#cadbec;border-bottom: 1px solid #8f8b8b;">
  <div class="container--flex">
    <?php 
    if (mysqli_num_rows($invQuery1) == 0){  ?>
      <a class="flex-child" style="background-color: #43a426;" target="actoinfrm" href="<?php echo $fullurl; ?>frmaction.php?quotationId=<?php echo $quotationId; ?>&addinvoice=1&invoiceType=1">
        <div style="color:#fff;font-size: 16px;">Generate Invoice</div> 
      </a>
      <?php  
    }else{
      $invoicedata = mysqli_fetch_array($invQuery1); ?>
      <a class="flex-child" style="background-color: #2196F3;" href="<?php echo $fullurl; ?>showpage.crm?module=invoice&add=yes&id=<?php echo encode($invoicedata['id']); ?>">
        <div style="color:#fff;font-size: 16px;">View Invoice</div> 
      </a>

      <div class="flex-child" style="background-color: #b30303;" onclick="alertspopupopen('action=cancelfinalquotInvoice&queryId=<?php echo encode($invoicedata['queryId']); ?>','600px','auto');">
        <div style="color:#fff;font-size: 16px;">Cancel Invoice</div> 
      </div> 
      <?php
    } 
    ?>
  </div>
  </div>
