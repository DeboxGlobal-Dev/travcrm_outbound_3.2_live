<?php
include "inc.php";   
if($_REQUEST['action']=='updatePartialAmount'){ 
	$type = $_REQUEST['type'];
	$paymentType = $_REQUEST['paymentType'];
	$value = $_REQUEST['value'];
	$amount = $_REQUEST['amount'];
	$quotationId = $_REQUEST['quotationId'];
	$currencyId = $_REQUEST['currencyId'];
	// $currencyVal = getCurrencyVal($currencyId);
	// $amount=convert_to_base($currencyVal,$baseCurrencyVal,$amount);
	$dueDate = $_REQUEST['dueDate'];
	$dueTime = $_REQUEST['dueTime'];
	$remark = $_REQUEST['remark']; 
	// finalQuote
	$prmQuery=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,' id="'.$_REQUEST['paymentId'].'" ');
	$prmData=mysqli_fetch_array($prmQuery); 
	// scheduletalbe
	$totalCost = $prmData['totalClientCost']; 
	$paymentId = $prmData['id'];

	$r2='';
	$r2=GetPageRecord('sum(amount) as totalAmount,ssp.*','agentSchedulePaymentMaster ssp','paymentId="'.$paymentId.'" and amount>0 and id!='.$_REQUEST['scheduleId'].' and value>0 and status=1');
 	$schedulePaymentData = mysqli_fetch_array($r2);
	$remainAmount = $totalCost-$schedulePaymentData['totalAmount'];	
	if($type == 2){ 
		$remainValue = $remainAmount; 
	}else{
		$remainValue = round(($remainAmount/$totalCost*100),2);
	}


 	if($remainValue >= $value){
		$namevalue = 'type="'.$type.'",paymentType="'.$paymentType.'",value="'.$value.'",amount="'.$amount.'",dueDate="'.$dueDate.'",status="1",scheduleStatus="1",dueTime="'.$dueTime.'",remarks="'.$remark.'"';
		$where='id="'.$_REQUEST['scheduleId'].'"';  
		$update = updatelisting('agentSchedulePaymentMaster',$namevalue,$where); 

		$sql_del="delete from agentSchedulePaymentMaster  where status=0 and paymentId='".$paymentId."'";
			mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
	}else{
		$namevalue = 'type="'.$type.'",paymentType="'.$paymentType.'",value="'.$remainValue.'",amount="'.$remainAmount.'",dueDate="'.$dueDate.'",status="1",scheduleStatus="1",dueTime="'.$dueTime.'",remarks="'.$remark.'"';
		$where='id="'.$_REQUEST['scheduleId'].'"';  
		$update = updatelisting('agentSchedulePaymentMaster',$namevalue,$where); 

		$sql_del="delete from agentSchedulePaymentMaster  where status=0 and paymentId='".$paymentId."'";
			mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
	}
	////////////////////////===========================TO DO LIST FOR AGENT PAYMENT. 
$toDoDate=date('Y-m-d',strtotime($dueDate));
$toDotime=date('h:i A',strtotime($dueTime)); 
$newdatetime=strtotime($toDoDate.' '.strtoupper($toDotime)); 
$newdatetime=date('Y-m-d H:i:s',$newdatetime); 
$queryId=$_REQUEST['queryId']; 
$reeh ='serviceId="'.$queryId.'",serviceType="Agent Payment Request Follow-up",toDoDate="'.$toDoDate.'",toDotime="'.$toDotime.'",dateTime="'.$newdatetime.'",remarks="'.$remark.'",paymentType="'.$paymentType.'",agentPaymentStatus="1"';
$lastide = addlistinggetlastid(_TO_DO_TIMELINE_,$reeh); 
////////////////////////============================//////////////////////////////	
 		
?> 

<script> 
loadPaymentRequestdmc('','');
// loadDmcPaymentSchedule(); 
</script>
<?php
}

if($_REQUEST['action']=='agentUpdatePayment' && $_REQUEST['scheduleId']!=''){	
	
	$r21=GetPageRecord('*','agentSchedulePaymentMaster','id="'.$_REQUEST['scheduleId'].'"'); 
	$scheduleData = mysqli_fetch_array($r21);
		
	$paymentType = $_REQUEST['paymentType'];
	$amount = $scheduleData['amount'];
	$paymentBy = $_REQUEST['paymentBy'];
	$transactionId = $_REQUEST['transactionId'];
	$bankId = $_REQUEST['bankName1'];
	$accountNo = $_REQUEST['accountNo'];
	$bankName = $_REQUEST['bankName'];
	$remark = $_REQUEST['details'];
	$queryId = $_REQUEST['queryId'];
	$receiptDate = date('y-m-d');
	
	$namevalue = 'paymentType="'.$paymentType.'",bankName="'.$bankName.'",receiptDate="'.$receiptDate.'",chequeNo="'.$transactionId.'",scheduleId="'.$scheduleData['id'].'",amount="'.$amount.'",paymentBy="'.$paymentBy.'",paymentId="'.$scheduleData['paymentId'].'",bankId="'.$bankId.'",accountNo="'.$accountNo.'",agentPaymentId="'.$scheduleData['agentPaymentId'].'",quotationId="'.$scheduleData['quotationId'].'",paymentStatus="1",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",remark="'.addslashes($remark).'"';  
 	$up = addlistinggetlastid('agentPaymentMaster',$namevalue); 

	 if($up>0){
		updatelisting('agentSchedulePaymentMaster','scheduleStatus="0",paymentStatus=1','id="'.$_REQUEST['scheduleId'].'"');
	}
	
 	?> 
	<script> 
	parent.masters_alertspopupopenClose();
	parent.window.location.reload();
	parent.$('#pageloading').hide();
	parent.$('#pageloader').hide();
	
	// parent.alertspopupopen('action=dmcSchedulePayment&quotationId=<?php echo $scheduleData['quotationId']; ?>','900px','auto');
	
	
	</script>
	<?php
}
 
?>