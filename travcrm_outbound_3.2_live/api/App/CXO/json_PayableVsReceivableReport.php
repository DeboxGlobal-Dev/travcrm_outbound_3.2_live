<?php
header('Content-type: text/html');
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";

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


		$json_result.='{
	 		"summary" : "'.$colsLable.'",
	 		"receivable" : "'.$receivableAmount.'",
	 		"payable" : "'.$payableAmount.'",
	 		"balance" : "'.$balanceAmount.'"
	 	},';

	}

?>

	{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
	}   