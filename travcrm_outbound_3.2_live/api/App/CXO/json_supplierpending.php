<?php
header('Content-type: text/html');
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
// include "../../config/logincheck.php"; 


			//Agent Pending Payment 
			$pendPaymentClientAmount = 0;
			$pendPaymentClientSql="SELECT * FROM supplierSchedulePaymentMaster WHERE amount !='' AND dueDate='".date('Y-m-d')."'";
			$pendPaymentClientQuery=mysqli_query(db(),$pendPaymentClientSql);
			if($numberss = mysqli_num_rows($pendPaymentClientQuery)){
			while($pendPaymentClientData=mysqli_fetch_array($pendPaymentClientQuery)){
			$AgentScheduleAmount = $pendPaymentClientData['amount'];
			$agentPaymentId = $pendPaymentClientData['supplierStatusId'];
			$dueDate = $pendPaymentClientData['dueDate'];
			if($pendPaymentClientData['dueDate']!='0000-00-00' && $pendPaymentClientData['dueDate']!=''){
                $dueDateToday= date("d-m-Y", strtotime($pendPaymentClientData['dueDate']));
                 }

				// Supplier Total Amount
                $finalQuery='';
		$finalQuery=GetPageRecord('*','finalQuotSupplierStatus','id="'.$pendPaymentClientData['supplierStatusId'].'" ');
		$finasupplierStatusData=mysqli_fetch_array($finalQuery);
        $supplier_final_amount = $finasupplierStatusData['totalSupplierCost'];

		//Supplier Name
		$suppQuery='';
		$suppQuery=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$finasupplierStatusData['supplierId'].'" ');
		$suppSupData=mysqli_fetch_array($suppQuery);
		$supplierName = $suppSupData['name'].' ['.$suppSupData['supplierNumber'].']'; 	
        //Supplier Contact Person
        $suppConQuery='';
		$suppConQuery=GetPageRecord('*','suppliercontactPersonMaster','id="'.$suppSupData['id'].'" ');
		$suppConQSupData=mysqli_fetch_array($suppConQuery);
        $contactPerson = $suppConQSupData['contactPerson'];
        $contactNumber = decode($suppConQSupData['phone']);

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
		 

          $r3='';
          $r3=GetPageRecord('sum(amount) as totalpaid, spm.*','supplierPaymentMaster spm',' scheduleId in ( select id from supplierSchedulePaymentMaster where 1 and  supplierStatusId="'.$finasupplierStatusData['id'].'" ) and paymentStatus=1');
          $supplierPaymentData = mysqli_fetch_array($r3);
          $totalpaid = ($supplierPaymentData['totalpaid']==0)?0:$supplierPaymentData['totalpaid'];
          $totalPending = $supplier_final_amount-$totalpaid;
          if($totalPending==0){
            $payment_status = "Paid";
        }else{
            $payment_status = "Pending";
        }
			
		
			
		// json format start
		$json_result.= '{
			"tourid" : "'.$tourId.'",
			"traveldate" : "'.$travelDate.'",
			"suppliername" : "'.$supplierName.'",
			"contactperson" : "'.$contactPerson.'",
			"contactnumber" : "'.$contactNumber.'",
			"totalsupplieramount" : "'.$supplier_final_amount.'",
			"paymentscheduledate" : "'.$dueDateToday.'",
			"supplierpendingamount" : "'.$AgentScheduleAmount.'",
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
