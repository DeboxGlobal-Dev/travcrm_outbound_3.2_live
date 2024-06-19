<?php
	header('Content-type: text/html');
	include "../../../inc.php";
	// include "../../../travcrm-dev/inc.php";
	// include "../../config/logincheck.php"; 


			//Agent Pending Payment 
			$pendPaymentClientAmount = 0;
			$pendPaymentClientSql="SELECT * FROM agentSchedulePaymentMaster WHERE amount !='' AND dueDate='".date('Y-m-d')."'";
			$pendPaymentClientQuery=mysqli_query(db(),$pendPaymentClientSql);
			if($numberss = mysqli_num_rows($pendPaymentClientQuery)){
			while($pendPaymentClientData=mysqli_fetch_array($pendPaymentClientQuery)){
			$AgentScheduleAmount = round($pendPaymentClientData['amount']);
			$agentPaymentId = $pendPaymentClientData['agentPaymentId'];
			$dueDate = $pendPaymentClientData['dueDate'];
			if($dueDate!= 0000-00-00 && $dueDate != ""){
				$dueDateToday = $dueDate;
			}

				// Agent Pending Amount
				$pendingclientamountSql = "SELECT * FROM agentPaymentRequest WHERE id= '{$agentPaymentId}'";
				$pendingclientamountQuery = mysqli_query(db(),$pendingclientamountSql);
				$pendingclientamountData = mysqli_fetch_assoc($pendingclientamountQuery);
				$client_final_amount = round($pendingclientamountData['finalCost']);
				$queryId = $pendingclientamountData['queryId'];
				 	

		  //Quotation Master Data
		  $select_11 = '*';
		  $where_22 = 'id="'.$pendPaymentClientData['quotationId'].'"';
		  $quotationMasterData=GetPageRecord($select_11,'quotationMaster',$where_22); 
		  $quotationMaster=mysqli_fetch_array($quotationMasterData);
		  $fromDate = $quotationMaster['fromDate'];
		  $toDate = $quotationMaster['toDate'];
		  if($quotationMaster['fromDate']==''){

		  } else { 
			$travelDate = date("d-m-Y", strtotime($quotationMaster['fromDate']));
			 } 
		// Query Master Data
		  $an2ss2=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationMaster['queryId'].'" ');
		  $queryData=mysqli_fetch_array($an2ss2);
		  $queryId = $queryData['id'];
		  	$displayId = $queryData['displayId'];
		  	$adults = $queryData['adult'];	
		  	$childs = $queryData['child'];
			  $tourId = makeQueryTourId($queryData['id']);
		  if($quotationMaster['isTourEx'] == 1){
			  $makeQueryId = makeExtensionId($queryData['displayId']);
		  }else{
			  $makeQueryId = makeQueryId($queryData['displayId']);
		  }
		  //Get Agent name here
		 $agentname = showClientTypeUserName($queryData['clientType'],$queryData['companyId']);
		  
		 $select13=''; 
			$where13=''; 
			$rs13='';   
			$select13='*';  
		
			if($queryData['clientType']==2){
				$where13="id='".$queryData['companyId']."'";
				$rs13=GetPageRecord($select13,_CONTACT_MASTER_,$where13); 
				$editresultcorporate=mysqli_fetch_array($rs13);
				$contactPerson = $editresultcorporate['firstName'].' '.$editresultcorporate['lastName'];
			}
			// }else{
				if($queryData['clientType']==1){   
					$rsc=GetPageRecord('contactPerson','contactPersonMaster',' corporateId="'.$queryData['companyId'].'" and deletestatus=0 order by id asc');
					$resListingc=mysqli_fetch_array($rsc);
					$contactPerson = ($resListingc['contactPerson']);
				}
			// }
				
			if($queryData['clientType']==1){     
				$contactNumber = getContactPersonPhone($queryData['companyId'],'corporate'); 
			  }
			 if($queryData['clientType']==2){ 
				$contactNumber = getContactPersonPhone($queryData['companyId'],'contacts'); 
			 } 

			 $r3=GetPageRecord('*','agentPaymentMaster spm',' scheduleId="'.$pendPaymentClientData['id'].'" and paymentStatus=1'); 
			$agentPaymentData = mysqli_fetch_array($r3);
			$paid = $agentPaymentData['amount']; 
			$totalPending = $pendPaymentClientData['amount']-$paid;  
			if($totalPending==0){
				$payment_status = "Paid";
			}else{
				$payment_status = "Pending";
			}
		
			
		// json format start
		$json_result.= '{
			"tourid" : "'.$tourId.'",
			"traveldate" : "'.$travelDate.'",
			"agentname" : "'.$agentname.'",
			"contactperson" : "'.$contactPerson.'",
			"contactnumber" : "'.$contactNumber.'",
			"totalclientamount" : "'.$client_final_amount.'",
			"paymentscheduledate" : "'.$dueDateToday.'",
			"clientpendingamount" : "'.$AgentScheduleAmount.'",
			"paymentid" : "'.$agentPaymentId.'",
			"queryid" : "'.$queryId.'",
			"adults" : "'.$adults.'",
			"childs" : "'.$childs.'",
			"paymentstatus" : "'.$payment_status.'"
		},';
	
		}
	}

?>
	{
		"status":"true",
		"Number of results":[<?php echo trim($numberss, ',');?>],
		"results":[<?php echo trim($json_result, ',');?>]
	}
