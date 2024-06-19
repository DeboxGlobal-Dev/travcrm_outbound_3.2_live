<?php 
	ob_start();
	include "inc.php"; 
	include "config/logincheck.php"; 



	if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ 
		$begin = new DateTime(date('Y-m-d')); 
		$end   = new DateTime(date('Y-m-d', strtotime('+7 days')));
		$intervalType = 'day';
	}
	if($_REQUEST['filterId']==2){ 
		$begin = new DateTime(date('Y-m-d'));
		$end   = new DateTime(date('Y-m-d', strtotime('+15 days')));
		$intervalType = 'day';
	}
	if($_REQUEST['filterId']==3){ 
		$begin = new DateTime(date('Y-m-01'));
		$end   = new DateTime(date('Y-m-t'));
			$intervalType = 'month';
	}
	if($_REQUEST['filterId']==4){ 
		$begin = new DateTime(date('Y-m-01',strtotime('+1 month')));
		$end   = new DateTime(date('Y-m-t', strtotime('+1 month')));
		$intervalType = 'month';
	}
	if($_REQUEST['filterId']==5){  
		$begin = new DateTime(date('Y-m-01',strtotime('+1 month')));
		$end   = new DateTime(date('Y-m-t', strtotime('+3 month')));
		$intervalType = 'month';
	}
	if($_REQUEST['filterId']==6){  
		$begin = new DateTime(date('Y-m-01',strtotime('+1 month')));
		$end   = new DateTime(date('Y-m-t', strtotime('+6 month')));
		$intervalType = 'month';
	}
	if($_REQUEST['filterId']==7){  
		$begin = new DateTime(date('Y-m-01',strtotime('+1 month')));
		$end   = new DateTime(date('Y-m-t', strtotime('+12 month')));
		$intervalType = 'month';
	}  
?>
<!-- <h3 class="cms_title">Payable Vs Receivable Report</h3>  -->
<style>
	.reportfilter{
	border-right:1px solid #e6e6e6; cursor:pointer;
	}
</style>
<div style="padding: 0 15px;">
<table border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
  <tr>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getPayableVsReceivablefun(1);">Next 7 Days</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==2){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getPayableVsReceivablefun(2);">Next 15 Days</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==3){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getPayableVsReceivablefun(3);">This Month</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==4){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getPayableVsReceivablefun(4);">Next Month</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==5){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getPayableVsReceivablefun(5);">Next 3 Months</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==6){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getPayableVsReceivablefun(6);">Next 6 Months</td>
	<td class="reportfilter" <?php if($_REQUEST['filterId']==7){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getPayableVsReceivablefun(7);">Next 12 Months</td>
  </tr>
</table>
</div>
<div style="padding: 15px;text-align: left;display: block;position: relative;">
 
Graph Area
 
</div>

<div style="border: 1px solid #ccc; padding: 10px;overflow-x: auto; height: 342px;">
<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#e6e6e6">
  <tr>
    <td align="left"><div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;">Receivable Report : <?php 
    echo $begin->format('Y-m-d').' to '.$end->format('Y-m-d');  ?></div></td>
  </tr>
<tr>
<td>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
<?php
// Period loop
$cols=1;
$periodCols='';
$totalPax=$totalNight=$totalClientCost=$totalSupplierCost=$totalProfitCost=$totalPayable=$totalRecievable=$totalProfit=0; 
$interval = DateInterval::createFromDateString('1 '.$intervalType);
$period = new DatePeriod($begin, $interval, $end); 
foreach ($period as $dt){

	if($intervalType == 'day'){
		$dueDateQuery = ' and dueDate = "'.$dt->format("Y-m-d").'" ';
		$colsLable = $dt->format("j-M");
	}
	if($intervalType == 'month'){
		$dueDateQuery = ' and dueDate BETWEEN "'.$dt->format("Y-m-d").'" and "'.$dt->format("Y-m-t").'"';
		$colsLable = $dt->format("M-Y");
	}

	$suppScheduleQuery=' status=1 '.$dueDateQuery.' and id not in ( select scheduleId from supplierPaymentMaster where 1 and paymentStatus=1 ) and quotationId>0 ';
	$suppScheduleQuery2=GetPageRecord('sum(amount) as totalAmount ','supplierSchedulePaymentMaster',$suppScheduleQuery);  
	$suppPaymentScheduleData=mysqli_fetch_array($suppScheduleQuery2);
	$payableAmount = round($suppPaymentScheduleData['totalAmount']);

	$agentScheduleQuery=' status=1 '.$dueDateQuery.' and id not in ( select scheduleId from agentPaymentMaster where 1 and paymentStatus=1 ) and quotationId>0 ';
	$agentScheduleQuery2=GetPageRecord('sum(amount) as totalAmount ','agentSchedulePaymentMaster',$agentScheduleQuery);  
	$agentPaymentScheduleData=mysqli_fetch_array($agentScheduleQuery2);
	$receivableAmount = round($agentPaymentScheduleData['totalAmount']);

	$balanceAmount = round($receivableAmount-$payableAmount);

	$periodCols .= '<th class="payableborder" align="left" bgcolor="#e6e6e6">'.$colsLable.'</th>';
	$receivableCols .= '<td class="payableborder" align="left">'.$receivableAmount.'</td>';
	$payableCols .= '<td class="payableborder" align="left">'.$payableAmount.'</td>';
	$balanceCols .= '<td class="payableborder" align="left" style="	border-bottom:2px solid #ccc !important;">'.$balanceAmount.'</td>';

}
?>
<tr>
	<th class="payableborder" align="left" bgcolor="#e6e6e6">Summary</th>
	<?php echo $periodCols; ?> 
</tr>
<tr>
	<td class="payableborder" align="left">Receivable</td>
	<?php echo $receivableCols; ?>
</tr>
<tr>
	<td class="payableborder" align="left">Payable</td>
	<?php echo $payableCols; ?>
</tr>
<tr>
	<td class="payableborder" align="left" style="	border-bottom:2px solid #ccc !important;">Balance</td>
	<?php echo $balanceCols; ?>
</tr>

<script>
$('#totalQuery').text('<?php echo ($no-1); ?>');
$('#totalPax').text('<?php echo $totalPax; ?>');
$('#totalPayable').text('<?php echo round($totalPayable); ?>');
$('#totalRecievable').text('<?php echo round($totalRecievable); ?>');
$('#totalBalance').text('<?php echo round($totalProfit); ?>');
$('#totalNight').text('<?php echo $totalNight; ?>');
</script>
</table>
</td>
  </tr>
</table>
</div>
			
<style>
.cmsouter .iconbox {
width:13% !important;
}
.payableborder{
	border: 2px solid #ccc;
	border-bottom: none;
	border-right: none;
}
.payableborder:last-child{
	border-right:2px solid #ccc;
}
.saleperson1{
    display: none;
}
</style>