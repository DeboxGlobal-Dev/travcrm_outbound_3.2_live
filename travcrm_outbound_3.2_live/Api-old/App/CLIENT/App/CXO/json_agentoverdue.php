<?php
header('Content-type: text/html');
header('Content-Type: application/json');
include "../../../inc.php";
//  include "../../../travcrm-dev/inc.php";

 
    $agentpending = "SELECT * FROM agentSchedulePaymentMaster WHERE status= '1'";
    $sqliquery = mysqli_query(db(),$agentpending);
     if($countres = mysqli_num_rows($sqliquery)>0){
    while($agentoverduepmt = mysqli_fetch_assoc($sqliquery)){
     $overagentamount = (int)$agentoverduepmt['amount'];
     if($agentoverduepmt['dueDate']!='0000-00-00' && $agentoverduepmt['dueDate']!=''){
        $paymentduedate = date("d-m-Y", strtotime($agentoverduepmt['dueDate']));

        $fromDate=date("Y-m-d");
        $toDate=date("Y-m-d", strtotime($agentoverduepmt['dueDate']));
        $objec=date_diff(date_create($fromDate),date_create($toDate));
        $agingStr = $objec->format("%r%a").' days'; 

      if($objec->format("%a") > 0){
			
			$an2ss=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$agentoverduepmt['quotationId'].'" ');
			$quotationData=mysqli_fetch_array($an2ss);
			if($quotationData['fromDate']==''){  

      } else {
          $traveldate = date("d-m-Y", strtotime($quotationData['fromDate'])); }
			$an2ss2=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'" ');
			$queryData=mysqli_fetch_array($an2ss2);
			$agentName = showClientTypeUserName($queryData['clientType'],$queryData['companyId']);
      $tourId = makeQueryTourId($queryData['id']);
			if($quotationData['isTourEx'] == 1){
			$makeQueryId = makeExtensionId($queryData['displayId']);
			}else{
			$makeQueryId = makeQueryId($queryData['displayId']);

      if($queryData['clientType']==1){     
        $contactnumber = getContactPersonPhone($queryData['companyId'],'corporate'); 
     }
      if($queryData['clientType']==2){ 
        $contactnumber = getContactPersonPhone($queryData['companyId'],'contacts'); 
      } 

			}
    }
  }

      $select13=''; 
      $where13=''; 
      $rs13='';   
      $select13='*';  
      if($queryData['clientType']==1){   
        $rsc=GetPageRecord('contactPerson','contactPersonMaster',' corporateId="'.$queryData['companyId'].'" and deletestatus=0 order by id asc');
        $resListingc=mysqli_fetch_array($rsc);
        $contactperson = $resListingc['contactPerson'];
      }

      if($queryData['clientType']==2){
        $where13="id='".$queryData['companyId']."'";
        $rs13=GetPageRecord($select13,_CONTACT_MASTER_,$where13); 
        $editresultcorporate=mysqli_fetch_array($rs13);
        $contactperson = $editresultcorporate['firstName'].' '.$editresultcorporate['lastName'];
      }


     $r2='';  
     $r2=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,'id="'.$agentoverduepmt['agentPaymentId'].'" ');
        $num = mysqli_num_rows($r2);
       $agentPaymentData = mysqli_fetch_array($r2); 
       $finalCost = $agentPaymentData['finalCost'];


     $json_result.= '{
        "tourid" : "'.$tourId.'",
        "traveldate" : "'.$traveldate.'",
        "agentname" : "'.$agentName.'",
        "contactperson" : "'.$contactperson.'",
        "contactnumber" : "'.$contactnumber.'",
        "agenttotalamount" : "'.$finalCost.'",
        "paymentduedate" : "'.$paymentduedate.'",
        "overdueamount" : "'.$overagentamount.'",
        "aging" : "'.$agingStr.'"
      },';
    }
  }
    ?>
    
    {
        "status":"true",
        "json_result":[<?php echo trim($json_result, ',');?>]
        }

