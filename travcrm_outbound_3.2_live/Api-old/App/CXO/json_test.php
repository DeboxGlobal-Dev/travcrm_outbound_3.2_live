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
				$January = (int)$targetData['January'];
			}
			if ($targetData['February']!='') {
				$February = (int)$targetData['February'];
			}
			if ($targetData['March']!='') {
				$March = (int)$targetData['March'];
			}
			if ($targetData['April']!='') {
				$April = (int)$targetData['April'];
			}
			if ($targetData['May']!='') {
				$May = (int)$targetData['May'];
			}
			if ($targetData['June']!='') {
				$June = (int)$targetData['June'];
			}
			if ($targetData['July']!='') {
				$July = (int)$targetData['July'];
			}			
			if ($targetData['August']!='') {
				$August = (int)$targetData['August'];
			}
			if ($targetData['September']!='') {
				$September = (int)$targetData['September'];
			}
			if ($targetData['October']!='') {
				$October = (int)$targetData['October'];
			}
			if ($targetData['November']!='') {
				$November = (int)$targetData['November'];
			}						
			if ($targetData['December']!='') {
				$December = (int)$targetData['December'];
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
					"Year" : "'.$year.'",

					"TJanuary" : "'.$January.'",
					"TFebruary" : "'.$February.'",
					"TMarch" : "'.$March.'",
					"TApril" : "'.$April.'",
					"TMay" : "'.$May.'",
					"TJune" : "'.$June.'",
					"TJuly" : "'.$July.'",
					"TAugust" : "'.$August.'",
					"TSeptember" : "'.$September.'",
					"TOctober" : "'.$October.'",
					"TNovember" : "'.$November.'",
					"TDecember" : "'.$December.'",


					"Target": "'.$totalTarget.'", 
					"TargetAchived" : "'.$AchivedSales.'", 
					"TotalQuery" : "'.$totalQueryCount.'",
					"TotalConfirmQuery" : "'.$countQueryConfirm.'"
				},';

		}	
	}
	?>
