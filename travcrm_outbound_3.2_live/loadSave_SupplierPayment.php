<?php
include "inc.php";  

if($_REQUEST['action']=='updatePartialAmount'){
		
	$type = $_REQUEST['type'];
	$paymentType = $_REQUEST['paymentType'];
	$value = $_REQUEST['value'];
	$amount = $_REQUEST['amount'];
	$dueDate = $_REQUEST['dueDate'];
	$dueTime = $_REQUEST['dueTime'];
	$remark = $_REQUEST['remark'];	
	

	
	$fianlSuppQuery=GetPageRecord('*','finalQuotSupplierStatus',' id="'.$_REQUEST['supplierStatusId'].'" '); 
	$supplierStatusData=mysqli_fetch_array($fianlSuppQuery);

	// scheduletalbe
	$totalCost = $supplierStatusData['totalSupplierCost'];

	$r2='';
	$r2=GetPageRecord('sum(amount) as totalAmount,ssp.*','supplierSchedulePaymentMaster ssp','supplierStatusId="'.$_REQUEST['supplierStatusId'].'" and amount!="" and id!='.$_REQUEST['scheduleId'].' and value!="" and status=1');
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
		$update = updatelisting('supplierSchedulePaymentMaster',$namevalue,$where); 

		$sql_del="delete from supplierSchedulePaymentMaster  where status=0 and supplierStatusId='".$_REQUEST['supplierStatusId']."'";
		mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
	}else{
		$namevalue = 'type="'.$type.'",paymentType="'.$paymentType.'",value="'.$remainValue.'",amount="'.$remainAmount.'",dueDate="'.$dueDate.'",status="1",scheduleStatus="1",dueTime="'.$dueTime.'",remarks="'.$remark.'"';
		$where='id="'.$_REQUEST['scheduleId'].'"';  
		$update = updatelisting('supplierSchedulePaymentMaster',$namevalue,$where); 

		$sql_del="delete from supplierSchedulePaymentMaster  where status=0 and supplierStatusId='".$_REQUEST['supplierStatusId']."'";
		mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
	} 
	
	////////////////////////===========================TO DO LIST FOR SUPPLIER PAYMENT. 
$toDoDate=date('Y-m-d',strtotime($dueDate));
$toDotime=date('h:i A',strtotime($dueTime)); 
$newdatetime=strtotime($toDoDate.' '.strtoupper($toDotime)); 
$newdatetime=date('Y-m-d H:i:s',$newdatetime);  
$queryId=$_REQUEST['queryId']; 
$reeh ='serviceId="'.$queryId.'",serviceType="Supplier Payment Request Follow-up",toDoDate="'.$toDoDate.'",toDotime="'.$toDotime.'",dateTime="'.$newdatetime.'",remarks="'.$remark.'",paymentType="'.$paymentType.'",supplierPaymentStatus="1"';
$lastide = addlistinggetlastid(_TO_DO_TIMELINE_,$reeh); 
////////////////////////============================//////////////////////////////	

		
	?> 

	<script> 
	loadSupplierPaymentSchedule(); 
	</script>
	<?php
}

if($_REQUEST['action']=='serviceUpdatePayment' && $_REQUEST['scheduleId']!=''){	
	
	$r21=GetPageRecord('*','supplierSchedulePaymentMaster','id="'.$_REQUEST['scheduleId'].'"'); 
	$scheduleData = mysqli_fetch_array($r21);
	
	// finalQuote
	$rsh=GetPageRecord('*','finalQuotSupplierStatus','id="'.$scheduleData['supplierStatusId'].'"'); 
	$finalQuoteData = mysqli_fetch_array($rsh);
	
	$b=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$finalQuoteData['supplierId'].'"'); 
	$suppData=mysqli_fetch_array($b);
		
	$paymentType = $_REQUEST['paymentType'];
	$amount = $_REQUEST['amount'];
		
		$paymentBy = $_REQUEST['paymentBy'];
		$remark = $_REQUEST['details'];
		$bankId = $_REQUEST['bankName1'];
		$accountNo = $_REQUEST['accountNo'];
		$paidBy = $_REQUEST['paidBy'];


	$amountDiff = $_REQUEST['amount']-$scheduleData['amount'];
	$remainAmount = $_REQUEST['lastscheduleamount']-$amountDiff;

	$paymentDate = date('Y-m-d',strtotime($_REQUEST['paymentDate']));
 	$fileUpload='';
	if($_FILES['fileUpload']['name']!=''){
 		$fileUpload= strtolower(str_replace(' ','-',$_FILES['fileUpload']['name']));  
		$fileUpload=time().'-'.$fileUpload; 
		copy($_FILES['fileUpload']['tmp_name'],"dirfiles/".$fileUpload);
	}
	
	$namevalue = 'paymentType="'.$paymentType.'",scheduleId="'.$scheduleData['id'].'",amount="'.$amount.'",paymentBy="'.$paymentBy.'",supplierStatusId="'.$finalQuoteData['id'].'",quotationId="'.$finalQuoteData['quotationId'].'",paymentStatus="1",addedBy="'.$_SESSION['userid'].'",bankId="'.$bankId.'",accountNo="'.$accountNo.'",dateAdded="'.time().'",paidBy="'.$paidBy.'",fileUpload="'.$fileUpload.'",remark="'.addslashes($remark).'",paymentDate="'.$paymentDate.'"';  
 	$up = addlistinggetlastid('supplierPaymentMaster',$namevalue); 
	// update supplier payment
	$namevalueSd = 'amount="'.$amount.'",paymentStatus="1",scheduleStatus="0"';
	$where = 'id="'.$_REQUEST['scheduleId'].'"';
	$update = updatelisting('supplierSchedulePaymentMaster',$namevalueSd,$where); 

	$namevalue1 = 'amount="'.$remainAmount.'",scheduleStatus="0"';
	$wherel = 'id="'.$_REQUEST['lastscheduleId'].'"';
	$update = updatelisting('supplierSchedulePaymentMaster',$namevalue1,$wherel); 


 	?> 
	<script> 
	parent.$('#pageloading').hide();
	parent.$('#pageloader').hide();
	parent.masters_alertspopupopenClose();
	parent.alertspopupopen('action=serviceSchedulePayment&supplierStatusId=<?php echo $scheduleData['supplierStatusId']; ?>&quotationId=<?php echo $scheduleData['quotationId']; ?>','1012px','auto');
	//loadSupplierPaymentSchedule(); 
	</script>
	<?php
}

if($_POST['action']=='serviceUploadDocument' && $_POST['supplierStatusId']!='' ){ 
 	if(isset( $_FILES["documentFile"] ) && !empty( $_FILES["documentFile"]["name"] ) ){
		$supplierStatusId=clean($_POST['supplierStatusId']);
		$docType=clean($_POST['docType']);
		$docTitle=clean($_POST['docTitle']);
		$quotationId=clean($_POST['quotationId']);
		$serviceType=clean($_POST['serviceType']);
		$documentFile='';
		if($_FILES['documentFile']['name']!=''){
			$documentFile=$_FILES['documentFile']['name'];  
			$documentFile=time().'-'.$documentFile; 
			copy($_FILES['documentFile']['tmp_name'],"dirfiles/".$documentFile);
		}
	
		$dateAdded=time();
		$namevalue ='supplierStatusId="'.$supplierStatusId.'",quotationId="'.$quotationId.'",docType="'.$docType.'",documentFile="'.$documentFile.'",docTitle="'.$docTitle.'",dateAdded="'.time().'",addedBy="'.$_SESSION['userid'].'"';  
		$lastid = addlistinggetlastid('supplierDocumentMaster',$namevalue);
		?>
		<script>
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
		parent.masters_alertspopupopenClose();
		parent.location.reload();
		</script>
		<?php
		}else{
		?>
			<script>
			parent.alert("file is empty!");
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
			</script>
		<?php
		}
	exit();
}

?>