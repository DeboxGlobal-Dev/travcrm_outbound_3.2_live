	<?php
  	header('Content-type: text/html');
  	include "../../../inc.php";
	// include "../../../travcrm-dev/inc.php";
	$json_result = '';
	$searchField=clean($_REQUEST['searchField']);
	$invoiceid=clean($_REQUEST['invoiceid']);
	$fromDate=$_REQUEST['fromDate'];
	$toDate=$_REQUEST['toDate'];
	if ($_REQUEST['fromDate'] == '' || $_REQUEST['toDate'] == '') {
		$fromDate=date('d-m-Y', strtotime($_REQUEST['fromDate']));
		$toDate=date('d-m-Y', strtotime($_REQUEST['toDate']));
	}else{
		$fromDate = date('Y-m-d', strtotime( $fromDate ));
		$toDate = date('Y-m-d', strtotime( $toDate ));
	}
	
	$assignto=$_REQUEST['assignto'];
	$destinationId=$_REQUEST['destinationId'];
	$categoryId=$_REQUEST['categoryId'];
	$tourType=$_REQUEST['tourType'];
	$clientType=$_REQUEST['clientType'];
	$clients=$_REQUEST['Clients'];
	?>

	<?php 
	// OPS user wise report and report = 1
	if($_REQUEST['report'] == '1'){

		$dateCon='';
		$agent='';
		if($_REQUEST['user']!='')
		{
		$agent = ' and id='.$_REQUEST['user'];
		}

		if($fromDate!='' && $toDate!=''){
			$strWhere=' fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
			$dateCon = ' and queryMaster.fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and queryMaster.deletestatus=0 ';
		}else{
			$dateCon = ' and queryMaster.fromDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and queryMaster.deletestatus=0 ';
		}

		if($fromDate == '01-01-1970' && $toDate == '01-01-1970'){
			$companyQuery=GetPageRecord('id,firstName,lastName',_USER_MASTER_,' deletestatus=0'.$agent.'');
		}elseif($fromDate!='' && $toDate!=''){
		$companyQuery=GetPageRecord('id,firstName,lastName',_USER_MASTER_,' deletestatus=0 '.$agent.' and id in (select assignTo from queryMaster where deletestatus=0 '.$dateCon.')');
		}else{
			$companyQuery=GetPageRecord('id,firstName,lastName',_USER_MASTER_,' deletestatus=0'.$agent.'');
		}


		while($companyResult=mysqli_fetch_array($companyQuery)){

		$totalQuery=0;
		$totalCreated=0;
		$totalConfirm =0;
		$totalReverted=0;
		$totalAssigned=0;
		$totalSent=0;
		$totalFellowUp=0;
		$totalCancelled=0;
		$totalLost=0;
		$matprecent=0;
		$totalSales = 0;
		$totalMargin=0;
		$totalPax=0;
		$totalNight=0;

		$queryStatus=[3,2,1,6,7,20,4];

		$name = $companyResult['firstName']." ".$companyResult['lastName'];

		if($fromDate == '01-01-1970' && $toDate == '01-01-1970'){

		$Query=GetPageRecord('id , queryStatus',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' ');

		}elseif($fromDate!='' && $toDate!=''){
			$Query=GetPageRecord('id , queryStatus',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' '.$dateCon);
		}else{
			$Query=GetPageRecord('id , queryStatus',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' ');
		}
		// // $queryResult=mysqli_fetch_array($Query);
		$queryResultTotalQ=mysqli_num_rows($Query);

		foreach($queryStatus as $val)
		{


		if($fromDate == '01-01-1970' && $toDate == '01-01-1970'){
			$Query=GetPageRecord('id',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' and queryStatus="'.$val.'" ');
		}elseif($fromDate!='' && $toDate!=''){
			$Query=GetPageRecord('id',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' and queryStatus="'.$val.'" '.$dateCon);
		}else{
			$Query=GetPageRecord('id',_QUERY_MASTER_,' assignTo='.$companyResult['id'].' and queryStatus="'.$val.'" ');
		}


		// $queryResult=mysqli_fetch_array($Query);
		$queryResultCount=mysqli_num_rows($Query);
			if($val==3)
			$totalConfirm +=$queryResultCount;
			if($val==2)
			$totalReverted +=$queryResultCount;
			if($val==1)
			$totalAssigned +=$queryResultCount;
			if($val==6)
			$totalSent +=$queryResultCount;
			if($val==7)
			$totalFellowUp +=$queryResultCount;
			if($val==20)
			$totalCancelled +=$queryResultCount;
			if($val==4)
			$totalLost +=$queryResultCount;
			}

			$totalSalesSum = 0;
			$margin=0;

			$queryMasterId = "select id from "._QUERY_MASTER_." where assignTo=".$companyResult['id']." and queryStatus=3";
			$qrResult = mysqli_query(db(),$queryMasterId);
			//$queryId = mysqli_fetch_assoc($qrResult);

			while ($queryId = mysqli_fetch_array($qrResult)) {
			    
			    $joinCorporateAndQueryMaster="select totalMargin,totalQuotCost from "._QUOTATION_MASTER_." where queryId=".$queryId['id'];
			    $qryQuotationMaster = mysqli_query(db(),$joinCorporateAndQueryMaster);

			    while ($toSum = mysqli_fetch_array($qryQuotationMaster)) {
			        $totalSalesSum = ceil((int)$toSum['totalQuotCost'] + $totalSalesSum);
			        $margin = ceil((int)$toSum['totalMargin'] + $margin);
					
			    }

			}

			$pax=0;
			$Query=GetPageRecord('SUM(adult) as adultCount,SUM(child) as childCount',_QUERY_MASTER_,' assignTo="'.$companyResult['id'].'" '.$dateCon);
			$queryResult=mysqli_fetch_array($Query);
			$pax=$queryResult['adultCount']+$queryResult['childCount'];

			$nightCount=0;
			$Query=GetPageRecord('SUM(night) as nightCount ',_QUERY_MASTER_,' assignTo="'.$companyResult['id'].'" '.$dateCon);
			$queryResult=mysqli_fetch_array($Query);
			$nightCount=$queryResult['nightCount'];

			// mat percent code
			$matper=GetPageRecord('id',_QUERY_MASTER_,' assignTo="'.$companyResult['id'].'" and queryStatus=3 '.$dateCon);

             $matperCount=mysqli_num_rows($matper);
            
            $MatPersantage =ceil(($matperCount/$queryResultTotalQ)*100);
            
            // $MatPersantage1 = ceil(($totalConfirm/$totalQuery)*100);
            // $matprecent+=$MatPersantage;
            // $matprecent2.=$MatPersantage;

		// get the json 
		$json_result.= '{
			"id" : "'.$companyResult['id'].'",
			"name" : "'.$name.'",
			"queries" : "'.$queryResultTotalQ.'",
			"confirmed" : "'.$totalConfirm.'",
			"reverted" : "'.$totalReverted.'",
			"assigned" : "'.$totalAssigned.'",
			"sent" : "'.$totalSent.'",
			"followup" : "'.$totalFellowUp.'",
			"lost" : "'.$totalLost.'",
			"sales" : "'.$totalSalesSum.'",
			"mat" : "'.$MatPersantage.'",
			"grossmargin " : "'.$margin.'",
			"totalpax" : "'.$pax.'",
			"noofnights " : "'.$nightCount.'"
		},';
		}

		}
	?>



	<?php 
	if($_REQUEST['report'] == '5'){ 

		$payment_ID = "";
		$query_ID = ""; 
		$Supplier_Name = ""; 
		$Contact_Person = ""; 
		$Contact_Number = "";
		$Client_Pending_Amt = "";
		$Travel_Date = "";

		$searchField=clean($_REQUEST['searchField']);
		$paymentid=clean($_REQUEST['paymentid']);
		$paymentstatus=clean($_REQUEST['paymentstatus']);

		$no=1; 
		$select='*'; 
		$where=''; 
		$rs='';  
		$wheresearch=''; 
		$limit=clean($_REQUEST['records']);
		$searchField=clean(trim(ltrim($_REQUEST['searchField'], '0')));
		$mainwhere='';
		if($searchField!=''){
			$mainwhere=' and  queryId='.$searchField.'';
		}
		if($fromDate!='' && $toDate!=''){
			$fromDate=date('Y-m-d', strtotime('+1 days', strtotime($fromDate)));
			$toDate=date('Y-m-d', strtotime('+1 days', strtotime($toDate)));
			$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
		}
		$paymentid=clean(trim(ltrim($_REQUEST['paymentid'], '0')));
		 
		if($paymentid!=''){
			$paymentid=' and  id='.$paymentid.'';
		}
		     
		if($paymentstatus!=''){
			$paymentstatus=' and  status='.$paymentstatus.'';
		}	
		 
		$where='where deletestatus=0 and queryid in (select id from '._QUERY_MASTER_.' where id!="" '.$whereFromDate.') '.$mainwhere.' '.$paymentid.' '.$paymentstatus.' order by id desc'; 
		$page=$_REQUEST['page'];
		$targetpage=$fullurl.'showpage.crm?module=reports&report=5&fromDate='.$_REQUEST["fromDate"].'&toDate='.$_REQUEST["toDate"].'&paymentstatus=0&records='.$limit.'&searchField='.$searchField.'&';
		$rs=GetRecordList($select,_PAYMENT_REQUEST_SECTION_MASTER_,$where,$limit,$page,$targetpage); 
		$totalentry=$rs[1]; 
		$paging=$rs[2]; 
		while($resultlists=mysqli_fetch_array($rs[0])){ 

			$select2='*';
			$where2='paymentId='.clean($resultlists['id']).' and companyTypeId!=0 order by id desc limit 0,1'; 
			$rs2=GetPageRecord($select2,_PAYMENT_SUPPLIER_LIST_MASTER_,$where2);  
			while($listofsuppliers=mysqli_fetch_array($rs2)){
				$paymentdate = $listofsuppliers['paymentdate'];
				$paymentreminderdate = $listofsuppliers['paymentreminderdate'];
			}

			$tatalpayment=0;
			$select22='*';
			$where22='paymentRequestId='.$resultlists['id'].' order by id ASC'; 
			$rs22=GetPageRecord($select22,_PAYMENT_LIST_MASTER_,$where22); 
			while($listofpayment=mysqli_fetch_array($rs22)){
				$tatalpayment=$tatalpayment+$listofpayment['amount'];
			}
			

			$totalpaymentpending=0;
			$select222='*';
			$where222='paymentId='.$resultlists['id'].' order by id desc'; 
			$rs222=GetPageRecord($select222,_PAYMENT_SUPPLIER_LIST_MASTER_,$where222); 
			while($listofsuppliers=mysqli_fetch_array($rs222)){
				$totalpaymentpending=$totalpaymentpending+$listofsuppliers['companytoalcost'];
			} 

			////start payment difference/////////
			$qid = $resultlists['queryid'];
			$selectpc='*';
			$wherepc='queryId="'.$qid.'" ';
			$rspc=GetPageRecord($selectpc,_DMC_PAYMENT_REQUEST_,$wherepc);
			while($resListingpc=mysqli_fetch_array($rspc)){
				$curid=$resListingpc['currencyId'];
				$t=0;
				$select4='';
				$where4='';
				$rs4='';
				$select4='sum(subtotal) as TotaladultCost';
				$where4='queryId="'.$qid.'" ';
				$rs4=GetPageRecord($select4,_DMC_PAYMENT_REQUEST_,$where4);
				while($adultcostSightseeingcost=mysqli_fetch_array($rs4)){
					$t=$adultcostSightseeingcost['TotaladultCost'];
					$select3='sum(amount) as TotaladultCost';
					$where3='queryId='.$qid.'';
					$rs3=GetPageRecord($select3,_DMC_PAYMENT_LIST_MASTER_,$where3);
					while($curname=mysqli_fetch_array($rs3)){
						$reciveAmount = $curname['TotaladultCost'];
					}
					$diffrence = $t-$reciveAmount;
				}
			}
			////end payment difference/////////
	        if ($diffrence > 0) {

	        	// Payment id
	        	$payment_ID = makePaymentId($resultlists['id']);
				
				// query id 
	        	$query_ID  = makeQueryId($resultlists['queryid']);

	        	// Supplier_Name
		     	$selectp='*';
				$idp=clean($resultlists['id']);
				$wherep='id='.$idp.'';
				$rsp=GetPageRecord($selectp,_PAYMENT_REQUEST_SECTION_MASTER_,$wherep);
				while($resultpaymentpagep=mysqli_fetch_array($rsp)){
					$totalpaymentpendingt=0;
					$select2r='*';
					$where2r='paymentId='.$resultpaymentpagep['id'].' order by id desc';
					$rs2r=GetPageRecord($select2r,_PAYMENT_SUPPLIER_LIST_MASTER_,$where2r);
					while($listofsupplierss=mysqli_fetch_array($rs2r)){
						$suppid=$listofsupplierss['supplierId'];
					}
				}
				$Supplier_Name = getsupplierCompany($suppid);

				// Contact_Person
				$selectaa='*';
				$whereaa='id="'.$suppid.'"';
				$rsaa=GetPageRecord($selectaa,_SUPPLIERS_MASTER_,$whereaa);
				while($getContact=mysqli_fetch_array($rsaa)){
					$Contact_Person = $getContact['contactPerson'];
				}

				// Contact_Number 
				$Contact_Number = getContactPersonPhone($suppid,'suppliers');

				// Client_Pending_Amt
				if ($diffrence > 0) {
				 	$Client_Pending_Amt = $diffrence;
				}else{
					$Client_Pending_Amt = "Paid";
				}

				// Travel_Date
				$selectaa='*';
				$whereaa='id="'.$resultlists['queryid'].'"';
				$rsaa=GetPageRecord($selectaa,_QUERY_MASTER_,$whereaa);
				while($getFromdate=mysqli_fetch_array($rsaa)){
					$Travel_Date = $getFromdate['fromDate'];
				}

	        	// json results
				$json_result.= '{
					"paymentid" : "'.$payment_ID.'",
					"queryid" : "'.$query_ID.'", 
					"suppliername" : "'.$Supplier_Name.'", 
					"contactperson" : "'.$Contact_Person.'", 
					"contactnumber" : "'.$Contact_Number.'",
					"totalamount" : "'.$Client_totalamount.'",
					"traveldate" : "'.$Travel_Date.'"
				},';
			}
		}
	}
	?>


	<?php
	// ghjkl;sdfghjkl;'dfghjk'
	if($_REQUEST['report'] == '6'){
		$payment_ID = "";
 		$query_ID  = "";
 		$Supplier_Name  = "";
 		$Contact_Person = "";
 		$Contact_Number  = "";
 		$Supplier_Pending_Amt = "";
 		$Travel_Date = "";

		$searchField=clean($_REQUEST['searchField']);
		$paymentid=clean($_REQUEST['paymentid']);
		$paymentstatus=clean($_REQUEST['paymentstatus']);
		
		$no=1;
		$select='*';
		$where='';
		$rs='';
		$wheresearch='';
		$limit=clean($_REQUEST['records']);
		$searchField=clean(trim(ltrim($_REQUEST['searchField'], '0')));
		$mainwhere='';

		if($searchField!=''){
			$mainwhere.=' and  queryId='.$searchField.'';
		}

		if($fromDate!='' && $toDate!=''){
			$mainwhere.=' and  id in (select paymentId  from '._PAYMENT_SUPPLIER_LIST_MASTER_.' where paymentdate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'") ';
		}
		   
		$paymentid=clean(trim(ltrim($_REQUEST['paymentid'], '0')));
		if($paymentid!=''){
			$paymentid=' and  id='.$paymentid.'';
		}
		     
		if($paymentstatus!=''){
			$paymentstatus=' and  status='.$paymentstatus.'';
		}

		if($fromDate!='' && $toDate!=''){

			$fromDate=date('Y-m-d', strtotime('+1 days', strtotime($fromDate)));
			$toDate=date('Y-m-d', strtotime('+1 days', strtotime($toDate)));
			$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
		}

		$where='where deletestatus=0 and queryid in ( select id from '._QUERY_MASTER_.' where id!="" '.$whereFromDate.' ) '.$mainwhere.' '.$paymentid.' '.$paymentstatus.' order by id desc';    
		$page=$_REQUEST['page'];
		$targetpage=$fullurl.'showpage.crm?module=reports&report=6&fromDate='.$_REQUEST["fromDate"].'&toDate='.$_REQUEST["toDate"].'&paymentstatus=0&records='.$limit.'&searchField='.$searchField.'&';
		$rs=GetRecordList($select,_PAYMENT_REQUEST_SECTION_MASTER_,$where,$limit,$page,$targetpage);    
		$totalentry=$rs[1]; 
		$paging=$rs[2]; 
		while($resultlists=mysqli_fetch_array($rs[0])){
			$select2='*';
			$where2='paymentId='.clean($resultlists['id']).' and companyTypeId!=0 order by id desc limit 0,1'; 
			$rs2=GetPageRecord($select2,_PAYMENT_SUPPLIER_LIST_MASTER_,$where2);  
			while($listofsuppliers=mysqli_fetch_array($rs2)){
				$paymentdate = $listofsuppliers['paymentdate'];
				$paymentreminderdate = $listofsuppliers['paymentreminderdate'];
			}
			  
			$tatalpayment=0;
			$select22='*';
			$where22='paymentRequestId='.$resultlists['id'].' order by id ASC'; 
			$rs22=GetPageRecord($select22,_PAYMENT_LIST_MASTER_,$where22); 
			while($listofpayment=mysqli_fetch_array($rs22)){
				$tatalpayment=$tatalpayment+$listofpayment['amount'];
			}
			
			$totalpaymentpending=0;
			$select222='*';
			$where222='paymentId='.$resultlists['id'].' order by id desc'; 
			$rs222=GetPageRecord($select222,_PAYMENT_SUPPLIER_LIST_MASTER_,$where222); 
			while($listofsuppliers=mysqli_fetch_array($rs222)){
				$totalpaymentpending=$totalpaymentpending+$listofsuppliers['companytoalcost'];
			}

			// payment_ID
			$payment_ID = makePaymentId($resultlists['id']);

			// query_ID
	 		$query_ID  = makeQueryId($resultlists['queryid']);

	 		// Supplier_Name
	 		$selectp='*'; 
		    $idp=clean($resultlists['id']); 
		    $wherep='id='.$idp.''; 
		    $rsp=GetPageRecord($selectp,_PAYMENT_REQUEST_SECTION_MASTER_,$wherep); 
		    while($resultpaymentpagep=mysqli_fetch_array($rsp)){
		      	$totalpaymentpendingt=0;
		        $select2r='*';
		        $where2r='paymentId='.$resultpaymentpagep['id'].' order by id desc'; 
		        $rs2r=GetPageRecord($select2r,_PAYMENT_SUPPLIER_LIST_MASTER_,$where2r); 
		        while($listofsupplierss=mysqli_fetch_array($rs2r)){
					$suppid=$listofsupplierss['supplierId'];
		        } 
			}
			$Supplier_Name = getsupplierCompany($suppid);
	 		
	 		// Contact_Person
	 		$selectaa='*';   
			$whereaa='id="'.$suppid.'"'; 
			$rsaa=GetPageRecord($selectaa,_SUPPLIERS_MASTER_,$whereaa); 
			while($getContact=mysqli_fetch_array($rsaa)){  
				$Contact_Person = $getContact['contactPerson'];
			}
	 		
	 		// Contact_Number
	 		$Contact_Number  = getContactPersonPhone($suppid,'suppliers');

	 		// Supplier_Pending_Amt
	 		$selectp='*'; 
			$idp=clean($resultlists['id']); 
			$wherep='id='.$idp.''; 
			$rsp=GetPageRecord($selectp,_PAYMENT_REQUEST_SECTION_MASTER_,$wherep); 
			while($resultpaymentpagep=mysqli_fetch_array($rsp)){
				$totalpaymentpendingt=0;
				$select2r='*';
				$where2r='paymentId='.$resultpaymentpagep['id'].' order by id desc'; 
				$rs2r=GetPageRecord($select2r,_PAYMENT_SUPPLIER_LIST_MASTER_,$where2r); 
				while($listofsupplierss=mysqli_fetch_array($rs2r)){
					$totalpaymentpendingt=$totalpaymentpendingt+$listofsupplierss['companytoalcost'];
					$totalGrossMargin=$listofsupplierss['companytotalcost']-$listofsupplierss['suppliertotalcost'];
				}
				$Supplier_totalamount = $totalpaymentpendingt;
				$select2c='*';
				$where2c='paymentRequestId='.$resultpaymentpagep['id'].' order by id desc'; 
				$rs2c=GetPageRecord($select2c,_PAYMENT_LIST_MASTER_,$where2c); 
				while($listofsupplierssc=mysqli_fetch_array($rs2c)){
					$totalpaymentpendingt=$totalpaymentpendingt-$listofsupplierssc['amount'];
				} 
				if($totalpaymentpendingt > 0){
					$Supplier_Pending_Amt = $totalpaymentpendingt;
				}
				else{
					$Supplier_Pending_Amt = "Paid";
				}
			}


			// destination name
			$destination = ""; 
	 		

	 		// Travel_Date
	 		$selectaa='*';   
			$whereaa='id="'.$resultlists['queryid'].'"'; 
			$rsaa=GetPageRecord($selectaa,_QUERY_MASTER_,$whereaa); 
			while($getFromdate=mysqli_fetch_array($rsaa)){  
				$Travel_Date =  $getFromdate['fromDate'];
			}


			// json results
			$json_result.= '{
				"paymentid" : "'.$payment_ID.'",
				"queryid" : "'.$query_ID.'", 
				"suppliername" : "'.$Supplier_Name.'", 
				"contactperson" : "'.$Contact_Person.'", 
				"contactnumber" : "'.$Contact_Number.'",
				"clientpendingamt" : "'.$Supplier_Pending_Amt.'",
				"totalamount" : "'.$Supplier_totalamount.'",
				"destination" : "'.$destination.'",
				"traveldate" : "'.$Travel_Date.'"
			},';
		}
	}
	?>


	<?php
	if($_REQUEST['report'] == '7'){

	$assignTo = '';
	if ($_REQUEST['userid']!=''){
		$assignTo = ' and id="'.$_REQUEST['userid'].'"';
	}

	if ($_REQUEST['year']!= ''){
		$year = $_REQUEST['year'];			
	}else{
		$year = date('Y');		
	}		

		$agentIdQuery=GetPageRecord('id,firstName as name','userMaster',' deletestatus=0 '.$assignTo.' group by name order by name');

		while ($agentId=mysqli_fetch_array($agentIdQuery)) {
			$totalTarget = 0;
			
			$targetResult = GetPageRecord('*','target','assign_to='.$agentId['id'].' and year='.$year.'');
			$targetData=mysqli_fetch_array($targetResult);

			if ($targetData['January']!='') {
				$totalTarget = (int)$targetData['January'] + $totalTarget;
			}
			if ($targetData['February']!='') {
				$totalTarget = (int)$targetData['February'] + $totalTarget;
			}
			if ($targetData['March']!='') {
				$totalTarget = (int)$targetData['March'] + $totalTarget;
			}
			if ($targetData['April']!='') {
				$totalTarget = (int)$targetData['April'] + $totalTarget;
			}
			if ($targetData['May']!='') {
				$totalTarget = (int)$targetData['May'] + $totalTarget;
			}
			if ($targetData['June']!='') {
				$totalTarget = (int)$targetData['June'] + $totalTarget;
			}
			if ($targetData['July']!='') {
				$totalTarget = (int)$targetData['July'] + $totalTarget;
			}			
			if ($targetData['August']!='') {
				$totalTarget = (int)$targetData['August'] + $totalTarget;
			}
			if ($targetData['September']!='') {
				$totalTarget = (int)$targetData['September'] + $totalTarget;
			}
			if ($targetData['October']!='') {
				$totalTarget = (int)$targetData['October'] + $totalTarget;
			}
			if ($targetData['November']!='') {
				$totalTarget = (int)$targetData['November'] + $totalTarget;
			}						
			if ($targetData['December']!='') {
				$totalTarget = (int)$targetData['December'] + $totalTarget;
			}

		    $getQryIds = GetPageRecord('id',_QUERY_MASTER_,'assignTo ='.$agentId['id'].' and year(queryDate)='.$year);
		    $AchivedSales=0;

		    while ($qryId = mysqli_fetch_array($getQryIds)) {
		        $QuotCosts = GetPageRecord('totalQuotCost',_QUOTATION_MASTER_,'queryId='.$qryId['id']);
		        while ($QuotCost = mysqli_fetch_array($QuotCosts)) {
		           $AchivedSales = (int)$QuotCost['totalQuotCost'] + $AchivedSales;
		        }
		    }

		    $totalQueryCount = 0;
		    $queryResultQuery=GetPageRecord('id',_QUERY_MASTER_,'assignTo ='.$agentId['id'].' and year(queryDate)='.$year);
		    $totalQueryCount=mysqli_num_rows($queryResultQuery);

		    $countQueryConfirm =0;

		    while($queryResult=mysqli_fetch_array($queryResultQuery)){
		    	$rsagent=GetPageRecord('id',_AGENT_PAYMENT_REQUEST_,'queryId="'.$queryResult['id'].'"');
				$countQueryConfirm += mysqli_num_rows($rsagent); 
			}	


				// json results
				$json_result.= '{
					"id": "'.$agentId['id'].'",
					"Name": "'.$agentId['name'].'",
					"Target": "'.$totalTarget.'", 
					"TargetAchived" : "'.$AchivedSales.'", 
					"TotalQuery" : "'.$totalQueryCount.'",
					"TotalConfirmQuery" : "'.$countQueryConfirm.'"
				},';

		}	
	}
	?>


	<?php 
	// todays travel report and report = 8
	if($_REQUEST['report'] == '8'){

		$searchField=clean($_REQUEST['queryId']);
		$invoiceid=clean($_REQUEST['invoiceid']);
		$search=clean($_REQUEST['search']);
		
		$no=1;  
		$where=''; 
		$rs='';  
		$wheresearch=''; 
		$limit=50;	
		$destination='';
		
		if($_REQUEST['destination']!=''){
			$destination=' and	destinationId='.clean($_REQUEST['destination']).'';
		} 
		 
		$queryId='';
		if($_REQUEST['queryId']!=''){
			$queryId=' and	id='.$_REQUEST['queryId'].'';
		}
		
		$sightseeingDate='';					
		if($_REQUEST['daterange']!=''){
		
			$myString = $_REQUEST['daterange'];
			$myArray = explode(' - ', $myString);
		
			$sightseeingDateval=$_REQUEST['daterange'];
		    $sightseeingDate=' and toDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
		}
		
		$check='';
		if(!empty($_REQUEST['check_list'])) {
		    $count = count($_REQUEST['check_list']);
			foreach($_REQUEST['check_list'] as $check2) {
				 $checkvalsightseeingmulti.="'".$check2."',";
			}
			$checkvalsightseeing = rtrim($checkvalsightseeingmulti,',');
			$check=' and  tourType IN ('.$checkvalsightseeing.') ';
			
		}
		 
		$queryAdult='';
		if($_REQUEST['queryAdult']!=''){
			$queryAdult=' and adult='.$_REQUEST['queryAdult'].' ';
		}

		$address='';
		if($_REQUEST['address']!=''){
			$address=' and pickupAddress like "%'.$_REQUEST['address'].'%"';
		}
		$queryChild='';
		if($_REQUEST['queryChild']!=''){
			$queryChild=' and  child='.$_REQUEST['queryChild'].' ';
		}

		$queryInfant='';
		if($_REQUEST['queryInfant']!=''){
			$queryInfant=' and   infant='.$_REQUEST['queryInfant'].' ';
		}
		
		$queryPax='';
		if($_REQUEST['pax']!=''){
			//$queryPax=' or   infant='.$_REQUEST['pax'].' or child='.$_REQUEST['pax'].' or adult='.$_REQUEST['pax'].' ';
			$select = ' *, ( adult + child + infant) AS pax ';
			$pax = ' and adult = '.$_REQUEST['pax'].' ';
		}else{					
			$select='*';
		}

		$adult='';
		if($_REQUEST['adult']!=''){
			$adult=' and   adult = '.$_REQUEST['adult'].' ';
		}
		
		$child='';
		if($_REQUEST['child']!=''){
			$child=' and  child = '.$_REQUEST['child'].' ';
		}
		$infant='';
		if($_REQUEST['infant']!=''){
			$infant=' and  infant = '.$_REQUEST['infant'].' ';
		}
		
		$assignTo='';
		if($_REQUEST['assignTo']!=''){
			$assignTo=' and  assignTo in ( select id from '._USER_MASTER_.' where firstName like "%'.$_REQUEST['assignTo'].'%" or lastName like "%'.$_REQUEST['assignTo'].'%" ) ';
		}

		$guestName='';
		if($_REQUEST['guestName']!=''){
			if($clientType==2){
			$guestName=' and  companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_REQUEST['guestName'].'%" or lastName like "%'.$_REQUEST['guestName'].'%"  or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="contacts" and phoneNo like "%'.$_REQUEST['guestName'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="contacts" and email like "%'.$_REQUEST['guestName'].'%" ) )  ';
			}
			else{
				$guestName=' and  companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_REQUEST['guestName'].'%" or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="corporate" and phoneNo like "%'.$_REQUEST['guestName'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="corporate" and email like "%'.$_REQUEST['guestName'].'%" ) )  ';
			}
		}
		
		$guestPhone='';
		if($_REQUEST['guestPhone']!=''){
			if($clientType==2){
				$guestPhone=' and  companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_REQUEST['guestPhone'].'%" lastName like "%'.$_REQUEST['guestPhone'].'%"  or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="contacts" and phoneNo like "%'.$_REQUEST['guestPhone'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="contacts" and email like "%'.$_REQUEST['guestPhone'].'%" ) )  ';
			}
			else{
				$guestPhone=' and  companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_REQUEST['guestPhone'].'%" or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="corporate" and phoneNo like "%'.$_REQUEST['guestPhone'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="corporate" and email like "%'.$_REQUEST['guestPhone'].'%" ) )  ';
			}
		}
		
		$guestEmail='';
		if($_REQUEST['guestEmail']!=''){
			if($clientType==2){
			$guestEmail=' and  companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_REQUEST['guestEmail'].'%" or lastName like "%'.$_REQUEST['guestEmail'].'%"  or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="contacts" and phoneNo like "%'.$_REQUEST['guestEmail'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="contacts" and email like "%'.$_REQUEST['guestEmail'].'%" ) )  ';
			}
			else{
				$guestEmail=' and  companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_REQUEST['guestEmail'].'%" or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="corporate" and phoneNo like "%'.$_REQUEST['guestEmail'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="corporate" and email like "%'.$_REQUEST['guestEmail'].'%" ) )  ';
			}
		}

		if( $_REQUEST['fromDate'] != '' && $_REQUEST['toDate'] != '' ){
			$fromDate=date('Y-m-d', strtotime($fromDate));
			$toDate=date('Y-m-d', strtotime($toDate));
			$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
		}

	 	$wheresearch='1 '.$guestName.' '.$guestEmail.'  '.$guestPhone.'   '.$assignTo.' '; 
	 	$where='where '.$wheresearch.'  '.$queryId.' '.$pax.'  '.$check.'  '.$whereFromDate.'  '.$sightseeingDate.'  and  deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';  
		$page=$_REQUEST['page'];
		$targetpage=$fullurl.'showpage.crm?module=travelbooking&records='.$limit.'&searchField='.$searchField.'&'; 
		$rs=GetRecordList($select,_QUERY_MASTER_,$where,$limit,$page,$targetpage); 
		$totalentry=$rs[1]; 
		$paging=$rs[2]; 
		while($resultlists=mysqli_fetch_array($rs[0])){

			// query id 
			$QueryId = makeQueryId($resultlists['id']);

			// tour date
			$tourDate = $resultlists['fromDate'];

			// TOUR NAME	
			$sic = $resultlists['tourType'];
			$selectsic='*'; 
			$wheresic='';
			$wheresic='id="'.$sic.'" ';
			$sicr=GetPageRecord($selectsic,_TOUR_TYPE_MASTER_,$wheresic);             
			while($resultsic=mysqli_fetch_array($sicr)) {
				$tourname = $resultsic['name'].",";
			}

			// pax
			$totalpax = '';
			if($resultlists['adult']!=''){
				$adult = (int)$resultlists['adult'];
			}else{
				$adult = 0;
			}
			
			// child
			if ($resultlists['child']!='') {
				$child = (int)$resultlists['child'];
			}else{
				$child =0;
			}
			
			// infant
			if ($resultlists['infant']!='') {
				$infant = (int)$resultlists['infant'];
			}else{
				$infant =0;
			}
			
			$totalpax = $adult+$child+$infant;



			//echo $totalpax;
			$clientType = $resultlists['clientType'];
			if($clientType==2){
				$select22='*';  
				$where22='id='.$resultlists['companyId'].''; 
				$rs22=GetPageRecord($select22,_CONTACT_MASTER_,$where22); 
				$contantnamemain2=mysqli_fetch_array($rs22);
				// fullname
			   	$fullname = $contantnamemain2['firstName'].' '.$contantnamemain2['lastName'];
				// mobile
			   	$mobile =  getContactPersonPhone($contantnamemain2['id'],'contacts');
				// email
			   	$email =  getContactPersonEmail($contantnamemain2['id'],'contacts'); 
			}
			else{
			  	$select22='*';  
			  	$where22='id='.$resultlists['companyId'].''; 
			  	$rs22=GetPageRecord($select22,_CORPORATE_MASTER_,$where22); 
			  	$contantnamemain2=mysqli_fetch_array($rs22);
				// fullname
			   	$fullname = $contantnamemain2['name'];
				// mobile
			   	$mobile =  getContactPersonPhone($contantnamemain2['id'],'corporate');
				// email
			   	$email =  getContactPersonEmail($contantnamemain2['id'],'corporate');
			}

			// operationalPerson 
			$OperationPerson = getUserName($resultlists['assignTo']);

			// json results
			$json_result.= '{
				"queryid" : "'.$QueryId.'",
				"tourdate" : "'.$tourDate.'", 
				"tourname" : "'.$tourname.'", 
				"pax" : "'.$totalpax.'", 
				"fullname" : "'.$fullname.'",
				"contactno" : "'.$mobile.'",
				"email" : "'.$email.'",
				"operationperson" : "'.$OperationPerson.'"
			},';
		}
	}
	?>
    <?php
//movement chart reports
if($_REQUEST['report']==21){

	if($fromDate == '01-01-1970' && $toDate == '01-01-1970'){
		$strWhere = '';
		$dateCon = '';
	}elseif($fromDate!='' && $toDate!=''){
		// $strWhere=' and  Q.fromDate BETWEEN \"".$fromDate."\" and \"".$toDate."\" and Q.deletestatus=0 ';
		//$dateCon = ' and queryMaster.queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and queryMaster.deletestatus=0 ';
// 		$dateCon = ' and Q.fromDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and Q.deletestatus=0 ';
		
		$dateCon = 'AND Q.fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" AND "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" AND Q.deletestatus = 0';
// 		print_r($dateCon);die();
	}else{
		$dateCon = ' AND Q.fromDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" AND "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" AND Q.deletestatus=0 ';
	}


$DataQuery = "";
$DataQuery .= "SELECT ServiceType, StartDate, ServiceName, ClientType, Companyid, LeadpaxName, Adult, AssignTo, Destination, QueryId FROM ";
$DataQuery .= " ( ";
$DataQuery.="SELECT QI.serviceType AS ServiceType, 
    QI.startDate AS StartDate, 
    PBTM.trainName AS ServiceName, 
    Q.clientType AS ClientType, 
    Q.companyId AS Companyid, 
    Q.leadPaxName AS LeadpaxName, 
    Q.adult AS Adult, 
    Q.assignTo AS AssignTo, 
    Q.id AS queryId,
    DM.name AS Destination 
    FROM quotationItinerary QI
    INNER JOIN quotationMaster QM ON QI.quotationId = QM.id AND QM.status = 1 
    INNER JOIN queryMaster Q ON QM.queryId = Q.id  AND Q.fromDate BETWEEN '2024-03-01' AND '2024-03-22'
    INNER JOIN quotationTrainsMaster QOAM ON QI.serviceId = QOAM.id 
    INNER JOIN packageBuilderTrainsMaster PBTM ON PBTM.id = QOAM.trainId 
    INNER JOIN destinationMaster DM ON QOAM.destinationId = DM.id 
    WHERE QI.serviceType = 'train'";
    
    $DataQuery .= " UNION ";    
$DataQuery .= "SELECT QI.serviceType AS ServiceType, 
    QI.startDate AS StartDate, 
    PBTM.transferName AS ServiceName, 
    Q.clientType AS ClientType, 
    Q.companyId AS Companyid, 
    Q.leadPaxName AS LeadpaxName, 
    Q.adult AS Adult, 
    Q.assignTo AS AssignTo, 
    DM.name AS Destination, 
    Q.id AS QueryId
    FROM quotationItinerary QI 
    INNER JOIN quotationTransferMaster QTM ON QTM.id = QI.serviceId AND QTM.quotationId = QI.quotationId 
    INNER JOIN quotationMaster QM ON QI.quotationId = QM.id AND QM.status = 1 
    INNER JOIN queryMaster Q ON QM.queryId = Q.id ".$dateCon." 
    INNER JOIN vehicleMaster VM ON QTM.vehicleModelId = VM.id 
    INNER JOIN packageBuilderTransportMaster PBTM ON QTM.transferNameId = PBTM.id 
    INNER JOIN destinationMaster DM ON QTM.destinationId = DM.id 
    WHERE QI.serviceType IN ('transfer', 'transportation')";
    
    $DataQuery .= " UNION ";    
    $DataQuery .= "SELECT QI.serviceType AS ServiceType, 
    QI.startDate AS StartDate, 
    PBHM.hotelName AS ServiceName, 
    Q.clientType AS ClientType, 
    Q.companyId AS Companyid, 
    Q.leadPaxName AS LeadpaxName, 
    Q.adult AS Adult, 
    Q.assignTo AS AssignTo, 
    Q.id AS queryId,
    DM.name AS Destination
    FROM quotationItinerary QI
    INNER JOIN quotationMaster QM ON QI.quotationId = QM.id AND QM.status = 1 
    INNER JOIN queryMaster Q ON QM.queryId = Q.id  AND Q.fromDate BETWEEN '2024-03-01' AND '2024-03-22'
   inner join quotationHotelMaster QHM on QI.dayId = QHM.dayId 
   inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId 
    INNER JOIN destinationMaster DM ON QHM.destinationId = DM.id
    WHERE QI.serviceType = 'hotel'";
     
   $DataQuery .= " UNION ";   
   $DataQuery.="SELECT QI.serviceType AS ServiceType, 
    QI.startDate AS StartDate, 
    PBFM.flightName AS ServiceName, 
    Q.clientType AS ClientType, 
    Q.companyId AS Companyid, 
    Q.leadPaxName AS LeadpaxName, 
    Q.adult AS Adult, 
    Q.assignTo AS AssignTo, 
    Q.id AS queryId ,
    DM.name AS Destination 
    FROM quotationItinerary QI
    INNER JOIN quotationMaster QM ON QI.quotationId = QM.id AND QM.status = 1 
    INNER JOIN queryMaster Q ON QM.queryId = Q.id ".$dateCon."
    inner JOIN quotationFlightMaster QFM on QI.serviceId=QFM.id 
    inner join packageBuilderAirlinesMaster PBFM on QFM.flightId=PBFM.id 
     INNER JOIN destinationMaster DM ON QFM.destinationId = DM.id 
    WHERE QI.serviceType = 'flight'";
    
    $DataQuery .= " UNION "; 
    $DataQuery.="SELECT QI.serviceType AS ServiceType, 
    QI.startDate AS StartDate, 
    PBOAM.otherActivityName AS ServiceName, 
    Q.clientType AS ClientType, 
    Q.companyId AS Companyid, 
    Q.leadPaxName AS LeadpaxName, 
    Q.adult AS Adult, 
    Q.assignTo AS AssignTo, 
    Q.id AS queryId,
    DM.name AS Destination
    FROM quotationItinerary QI
    INNER JOIN quotationMaster QM ON QI.quotationId = QM.id AND QM.status = 1 
    INNER JOIN queryMaster Q ON QM.queryId = Q.id ".$dateCon."
    inner JOIN quotationOtherActivitymaster QOAM on QI.serviceId = QOAM.id 
    inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.otherActivityName 
    INNER JOIN destinationMaster DM ON Q.destinationId = DM.id
    WHERE QI.serviceType = 'activity'";
    
    $DataQuery .= " UNION "; 
    $DataQuery.="SELECT QI.serviceType AS ServiceType, 
    QI.startDate AS StartDate, 
    PBEM.entranceName AS ServiceName, 
    Q.clientType AS ClientType, 
    Q.companyId AS Companyid, 
    Q.leadPaxName AS LeadpaxName, 
    Q.adult AS Adult, 
    Q.assignTo AS AssignTo, 
    Q.id AS queryId,
    DM.name AS Destination
    FROM quotationItinerary QI
    INNER JOIN quotationMaster QM ON QI.quotationId = QM.id AND QM.status = 1 
    INNER JOIN queryMaster Q ON QM.queryId = Q.id ".$dateCon."
    inner JOIN quotationEntranceMaster QEM on QI.serviceId = QEM.id 
   inner join packageBuilderEntranceMaster PBEM on QEM.entranceNameId = PBEM.id
    INNER JOIN destinationMaster DM ON Q.destinationId = DM.id
    WHERE QI.serviceType = 'entrance'";
    
    $DataQuery .= " UNION "; 
    $DataQuery.="SELECT replace(QI.serviceType,'mealplan','restaurant') AS ServiceType, 
    QI.startDate AS StartDate, 
    QIMP.mealPlanName AS ServiceName, 
    Q.clientType AS ClientType, 
    Q.companyId AS Companyid, 
    Q.leadPaxName AS LeadpaxName, 
    Q.adult AS Adult, 
    Q.assignTo AS AssignTo, 
    Q.id AS queryId,
    DM.name AS Destination
    FROM quotationItinerary QI
    INNER JOIN quotationMaster QM ON QI.quotationId = QM.id AND QM.status = 1 
    INNER JOIN queryMaster Q ON QM.queryId = Q.id ".$dateCon."
    inner join quotationInboundmealplanmaster QIMP on QI.serviceId = QIMP.id
    INNER JOIN destinationMaster DM ON Q.destinationId = DM.id
    WHERE QI.serviceType = 'mealplan'";
    
    $DataQuery .= " UNION "; 
    $DataQuery.="SELECT QI.serviceType AS ServiceType, 
    QI.startDate AS StartDate, 
    tbGuid.name AS ServiceName, 
    Q.clientType AS ClientType, 
    Q.companyId AS Companyid, 
    Q.leadPaxName AS LeadpaxName, 
    Q.adult AS Adult, 
    Q.assignTo AS AssignTo, 
    Q.id AS queryId,
    DM.name AS Destination
    FROM quotationItinerary QI
    INNER JOIN quotationMaster QM ON QI.quotationId = QM.id AND QM.status = 1 
    INNER JOIN queryMaster Q ON QM.queryId = Q.id  ".$dateCon."
   inner JOIN quotationGuideMaster QOAM on  QI.serviceId = QOAM.id 
   inner join tbl_guidemaster tbGuid  on QOAM.guideId  =tbGuid.id
    INNER JOIN destinationMaster DM ON Q.destinationId = DM.id
    WHERE QI.serviceType = 'guide'";
    
$DataQuery .= " ) MyTable ORDER BY StartDate ASC";

$DayWiseDataq=mysqli_query(db(),$DataQuery) or die(mysqli_error(db()));
   
while($DayWiseData=mysqli_fetch_array($DayWiseDataq)){
$json_result .= '{
    "tourid" : "'.makeQueryTourId($DayWiseData['QueryId']).'",
	"serviceType" : "'.$DayWiseData['ServiceType'].'",
	"tourdate" : "'.date('d-m-Y',strtotime($DayWiseData['StartDate'])).'", 
	"serviceName" : "'.$DayWiseData['ServiceName'].'",
	"agentName" : "'.showClientTypeUserName($DayWiseData['ClientType'],$DayWiseData['Companyid']).'",
	"leadpaxName" : "'.$DayWiseData['LeadpaxName'].'",
	"pax" : "'.$DayWiseData['Adult'].'",
	"tourManager" : "'.getUserName($DayWiseData['AssignTo']).'",
	"city" : "'.$DayWiseData['Destination'].'"
},';
}   
}
//driver duties
if($_REQUEST['report']==22){

	if($fromDate == '01-01-1970' && $toDate == '01-01-1970'){
		$strWhere = '';
		$dateCon = '';
	}elseif($fromDate!='' && $toDate!=''){
		$strWhere=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
		//$dateCon = ' and queryMaster.queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and queryMaster.deletestatus=0 ';
		$dateCon = ' and queryMaster.queryDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and queryMaster.deletestatus=0 ';
	}else{
		$dateCon = ' and queryMaster.queryDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and queryMaster.deletestatus=0 ';
	}
    
    $rsquery1="select * from queryMaster where queryStatus=3.$dateCon"; 
$rsquery2 =mysqli_query(db(),$rsquery1);
$queryData1=mysqli_fetch_array($rsquery2);

$rs=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'queryId="'.$queryData1['id'].'" order by id asc '); 

while($resultlists=mysqli_fetch_array($rs)){ 
// print_r($resultlists);
    
if($resultlists['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ $fromDate=date('d-m-Y',strtotime($resultlists['fromDate'])); }else{ $fromDate=date('d-m-Y',strtotime($resultlists['fromDate'])); }    

++$no;

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'"  order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('id,displayId,adult,child,infant,leadPaxName,destinationId','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery);
$tourId=makeQueryTourId($queryData['id']);
$leadPaxName=$queryData['leadPaxName'];
//$leadPaxName="hello";

$selveh='id,carType,model,registrationNo';  

$whereveh='id="'.$resultlists['vehicleModelId'].'"'; 

$rsveh=GetPageRecord($selveh,_VEHICLE_MASTER_MASTER_,$whereveh); 

$vehicalname=mysqli_fetch_array($rsveh);
$vehicleName=$vehicalname['model'];
// print_r($vehicleName);

$rstranfer=GetPageRecord('transferName,transferCategory',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$resultlists['transferNameId'].'" order by id asc '); 

$tranferData=mysqli_fetch_array($rstranfer);
$transferCategory=$tranferData['transferCategory'];

$sele='*';

$whereDest=' id="'.$resultlists['destinationId'].'" ';   

$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);

$ddest=mysqli_fetch_array($rsDest);
$destination=$ddest['name'];

$selecttime='*';

$wheretime=' quotationId="'.$resultlists['quotationId'].'" and transferQuoteId="'.$resultlists['id'].'" and supplierId="'.$resultlists['supplierId'].'" ';   

$rstimet=GetPageRecord($selecttime,'quotationTransferTimelineDetails',$wheretime);

$dtime=mysqli_fetch_array($rstimet);
$pickupTime=$dtime['pickupTime'];
$dropTime=$dtime['dropTime'];
print_r($dropTime);

$sel='*';
$wherev='transferQuotId = "'.$resultlists['id'].'" order by id desc';
$rsv=GetPageRecord($sel,'driverAllocationDetails',$wherev);
$driverAllocate=mysqli_fetch_array($rsv);

$driverStatus = '';

if ($driverAllocate['allocationStatus']==1) {
	$driverStatus = 'Assigned';	
}elseif ($driverAllocate['allocationStatus']==0) {
	$driverStatus = 'Pending';
}elseif ($driverAllocate['allocationStatus']==2) {
	$driverStatus = 'Rejected';
}elseif ($driverAllocate['allocationStatus']==3) {
	$driverStatus = 'Completed';
}else{
	$driverStatus = 'Not Assigned';
}

$name = '';

	$rsDv=GetPageRecord('*','driverMaster','1 and id="'.$driverAllocate['driverId'].'"  order by name'); 
	$driverData=mysqli_fetch_array($rsDv);

	if($driverAllocate['driverId']!='0'){	
	    $name = $driverData['name'];
	    $phone = $driverData['mobile'];
	}else{
	   $name = $driverAllocate['name'];
	   $phone = $driverAllocate['mobileNo'];	
	}

$sel='*';
$wherev='transferQuotId = "'.$resultlists['id'].'" and  allocatedStatus=1 order by id desc';
$rsv=GetPageRecord($sel,'quotVhicleDetails',$wherev);
$allocatevahicle=mysqli_fetch_array($rsv);

$json_result .= '{
				"tourid" : "'.$tourId.'",
				"tourdate" : "'.$fromDate.'",
				"drivername" : "'.$name.'",
				"driverstatus" : "'.$driverStatus.'", 
				"destination" : "'.$destination.'", 
				"leadPax" : "'.$leadPaxName.'",
				"pickuptime" : "'.$pickupTime.'",
				"droptime" : "'.$dropTime.'",
				"mode" : "'.$transferCategory.'",
				"vehicleName" : "'.$vehicleName.'"
			},';    

}

}
//guid duties
if($_REQUEST['report']==23){

	if($fromDate == '01-01-1970' && $toDate == '01-01-1970'){
		$strWhere = '';
		$dateCon = '';
		$dateFandT = '';
	}elseif($fromDate!='' && $toDate!=''){
		$strWhere=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
		//$dateCon = ' and queryMaster.queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and queryMaster.deletestatus=0 ';
		$dateCon = ' queryMaster.queryDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and queryMaster.deletestatus=0 ';
		$dateFandT = 'and queryId in (select id from queryMaster where '.$dateCon.')';
	}else{
		$dateCon = ' queryMaster.queryDate BETWEEN "'.date('Y-m-d', strtotime( $_REQUEST['fromDate'] )).'" and "'.date('Y-m-d', strtotime( $_REQUEST['toDate'] )).'" and queryMaster.deletestatus=0 ';
		$dateFandT = 'and queryId in (select id from queryMaster where '.$dateCon.')';
	}



$rs=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' isSelectedFinal=1 and tariffId!=0 '.$dateFandT.' order by quotationId desc '); 
while($resultlists=mysqli_fetch_array($rs)){

if($resultlists['fromDate']=='' || $resultlists['fromDate']=='1970-01-01'){ 
$fromDate=date('d-m-Y',strtotime($resultlists['fromDate'])); }else{ 
$fromDate=date('d-m-Y',strtotime($resultlists['fromDate'])); }
    
$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'"  and status=1 order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);

$sele='*';
$whereDest=' id="'.$resultlists['destinationId'].'" ';   
$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
$ddest=mysqli_fetch_array($rsDest);

$selectd = '*';   
$whered= 'id="'.$resultlists['tariffId'].'"'; 
$rsd = GetPageRecord($selectd,'dmcGuidePorterRate',$whered); 
$guideDate = mysqli_fetch_array($rsd);

$rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$resultlists['guideId'].'"'); 
$guideCat = mysqli_fetch_array($rs11); 

$rsi = GetPageRecord('*','guideAllocation',' guideQuoteId = "'.$resultlists['id'].'"'); 
$guideid = mysqli_fetch_array($rsi); 

$guideStatus = '';

if ($guideid['allocationStatus']==1) {
	$guideStatus = 'Assigned';	
}elseif ($guideid['allocationStatus']==0) {
	$guideStatus = 'Pending';
}elseif ($guideid['allocationStatus']==2) {
	$guideStatus = 'Rejected';
}elseif ($guideid['allocationStatus']==3) {
	$guideStatus = 'Completed';
}else{
	$guideStatus = 'Not Assigned';
}

$name='';

if($guideid['GuideId']!='0'){
$rsg = GetPageRecord('*',_GUIDE_MASTER_,' id = "'.$guideid['GuideId'].'"'); 
$guidedata = mysqli_fetch_array($rsg);
$name = $guidedata['name'];
$phone = $guidedata['phone'];
}else{
$name = $guideid['name'];
$phone = $guideid['mobileNo'];
}
$json_result.= '{
				"tourid" : "'.makeQueryTourId($queryData['id']).'",
				"guidename" : "'.$name.'",
				"guidestatus" : "'.$guideStatus.'",
				"tourdate" : "'.$fromDate.'", 
				"destination" : "'.$ddest['name'].'", 
				"agentName" : "'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'",
				"leadPax" : "'.$queryData['leadPaxName'].'",
				"guide" : "'.$name.'",
				"service" : "'.$guideCat['name'].'",
				"dayType" : "'.$guideDate['dayType'].'"
			},';    
}
}
?>

	{
		"status":true,
		"articles":[<?php echo trim($json_result, ',');?>]
	}
