<?php
include "inc.php";
include "config/logincheck.php";

	if($_REQUEST['otherActivityId']!='' && $_REQUEST['action'] == 'loadotherActivityCost'){
		$select1='*';
		$where1='id="'.$_REQUEST['otherActivityId'].'"';
		$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$where1);
		$otherActivityData1=mysqli_fetch_array($rs1);
		$searhqueryId = $_REQUEST['searhqueryId'];
		$otherActivityName=addslashes($otherActivityData1['otherActivityName']);
		$adultCost=addslashes($otherActivityData1['adultCost']);
		$childCost=addslashes($otherActivityData1['childCost']);
		$infantCost=addslashes($otherActivityData1['infantCost']);
		$dateotherActivity=date('Y-m-d',strtotime($_REQUEST['dateotherActivity']));
		?>
		<script type="text/javascript">
			parent.$('#activityadultCost').val(<?php echo $adultCost; ?>);
			parent.$('#activitychildCost').val(<?php echo $childCost; ?>);
			parent.$('#activityinfantCost').val(<?php echo $infantCost; ?>);
		</script>
		<?php
	}
	if($_REQUEST['otherActivityId']!='' && $_REQUEST['action'] == 'loadotherActivityCost2'){
		$select1='*';
		$where1='id="'.$_REQUEST['otherActivityId'].'"';
		$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$where1);
		$otherActivityData1=mysqli_fetch_array($rs1);
		$searhqueryId = $_REQUEST['searhqueryId'];
		$otherActivityName=addslashes($otherActivityData1['otherActivityName']);
		$adultCost=addslashes($otherActivityData1['adultCost']);
		$childCost=addslashes($otherActivityData1['childCost']);
		$infantCost=addslashes($otherActivityData1['infantCost']);
		$dateotherActivity=date('Y-m-d',strtotime($_REQUEST['dateotherActivity']));
		?>
		<script type="text/javascript">
			parent.$('#actadultCost').val(<?php echo $adultCost; ?>);
			parent.$('#actchildCost').val(<?php echo $childCost; ?>);
			parent.$('#actinfantCost').val(<?php echo $infantCost; ?>);
		</script>
		<?php
	}
	// load meal plans and addedit
	if($_REQUEST['action'] =='addedit_QuotationotherActivity'){
		if($_REQUEST['deleteid']!=''){
			deleteRecord(_QUOTATION_OTHER_ACTIVITY_MASTER_,' id = "'.$_REQUEST['deleteid'].'"');
			deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['deleteid'].'" and serviceType="activity" and quotationId="'.$_REQUEST['searhqueryId'].'"');
			?>
			<script>
			warningalert('Activity Deleted..!');
			loadquotationmainfile();
		</script>
			<?php
		}
		// addedit quotation mealplans
		if($_REQUEST['add']=='yes'){
			
	$startDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['startDayId'].'" ');  
	$startDayData=mysqli_fetch_array($startDayQuery);
	
	$endDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['endDayId'].'" ');  
	$endDayData=mysqli_fetch_array($endDayQuery);


	$startDayDate = $startDayData['srdate'];
    $endDayDate = $endDayData['srdate'];

			
	
			$where11=' id="'.$_REQUEST['dmcActivity'].'" order by id asc';
			$rs11=GetPageRecord('*','dmcotherActivityRate',$where11);
			$dmcData=mysqli_fetch_array($rs11);
	
			$select1='*';
			$where1='id="'.$dmcData['otherActivityNameId'].'"';
			$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$where1);
			$otherActivityData=mysqli_fetch_array($rs1);
	
			$otherActivityName=addslashes($otherActivityData['otherActivityName']);
			$activityCost=addslashes($_REQUEST['activityCost']);
			$maxpax=addslashes($_REQUEST['maxpax']);
			$perPaxCost=addslashes($_REQUEST['perPaxCost']);
	
	
	
			$dayQuery=GetPageRecord('*','newQuotationDays','quotationId="'.$_REQUEST['quotationId'].'" and srdate >= "'.$startDayDate.'" and  srdate <= "'.$endDayDate.'" order by srdate asc'); 
			while($dayData=mysqli_fetch_array($dayQuery)){
			// print_r($dayData);
	
			$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$dayData['quotationId'].'"');
			$quotationData = mysqli_fetch_array($rs1);
	
	
			$queryId = $quotationData['queryId'];
			$quotationId = $dayData['quotationId'];
			$dayId = $dayData['id'];
			$startDate = date("Y-m-d",strtotime($dayData['srdate']));
			$cityId=$dayData['cityId'];

			// $destinationId = getDestination($destinationstart);
	
	
			$otherActivityCity=addslashes($_REQUEST['otherActivityCity']);
			$dateotherActivity=date('Y-m-d',strtotime($_REQUEST['dateotherActivity']));
			$currencyId=$_REQUEST['currencyId'];
	
			$rs121=GetPageRecord('id',_QUOTATION_OTHER_ACTIVITY_MASTER_,'otherActivityName="'.$dmcData['otherActivityNameId'].'" and quotationId="'.$quotationId.'"');
			$isAlreadyAdded=mysqli_num_rows($rs121);
	
	
			$namevalue ='activityCost="'.$activityCost.'",maxpax="'.$maxpax.'",supplierId="'.$dmcData['supplierId'].'",remark="'.$dmcData['remarks'].'",tariffId="'.$dmcData['id'].'",quotationId="'.$quotationId.'",fromDate="'.$startDate.'",toDate="'.$startDate.'",perPaxCost="'.$perPaxCost.'",otherActivityName="'.$dmcData['otherActivityNameId'].'",otherActivityCity="'.$cityId.'",queryId="'.$queryId.'",dateotherActivity="'.$startDate.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'",startDayDate="'.$startDayDate.'",endDayDate="'.$endDayDate.'"';
			$lastid = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue);
	
	
			$namevalue1 ='serviceId="'.$lastid.'",serviceType="activity", dayId="'.$dayId.'",startDate="'.$startDate.'",endDate="'.$startDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
			addlisting('quotationItinerary',$namevalue1);
	
			 
			?>
			<script>
				//closeinbound();
				loadquotationmainfile();
			</script>
			<?php

		} }  
	}
 
	if($_REQUEST['action'] =='addedit_QuotationotherActivityNullAmt'){

		$startDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['startDayId'].'" ');  
	$startDayData=mysqli_fetch_array($startDayQuery);
	
	$endDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['endDayId'].'" ');  
	$endDayData=mysqli_fetch_array($endDayQuery);

	$startDayDate = $startDayData['srdate'];
    $endDayDate = $endDayData['srdate'];


	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);

		$marketTypeId = getQueryMaketType($queryId);
		if($marketTypeId < 1){
			$marketTypeId = 1;
		}

		$startDate = date('Y-m-d',strtotime($dayData['srdate']));

		// $namevalue ='supplierId="'.$_REQUEST['supplierId'].'",activityCost="'.$_REQUEST['activityCost'].'",perPaxCost="'.$_REQUEST['perPaxCost'].'",maxpax="'.$_REQUEST['maxPax'].'",fromDate="'.$startDate.'",toDate="'.$startDate.'",marketType="'.$marketTypeId.'",otherActivityNameId="'.$_REQUEST['activityId'].'",status="1",addBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",currencyId="1",serviceid="'.$_REQUEST['activityId'].'"';
		// $tariffId = addlistinggetlastid('dmcotherActivityRate',$namevalue);

	// addedit quotation mealplans
	if($_REQUEST['add']=='yes'){

		$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'id="'.$_REQUEST['activityId'].'"');
		$otherActivityData=mysqli_fetch_array($rs1);

		$otherActivityName=addslashes($otherActivityData['otherActivityName']);

		$quotationId = $_REQUEST['quotationId'];
		$activityCost = $_REQUEST['activityCost'];
		$maxPax = $_REQUEST['maxPax'];
		$perPaxCost = $_REQUEST['perPaxCost'];
		// $dayId = $_REQUEST['dayId'];
		$supplierId = $_REQUEST['supplierId'];

		$destinationId = $dayData['cityId'];
		$startDate = date('Y-m-d',strtotime($dayData['srdate']));


		// $destinationId = getDestination($destinationstart);

		$dayQuery=GetPageRecord('*','newQuotationDays','quotationId="'.$_REQUEST['quotationId'].'" and srdate >= "'.$startDayDate.'" and  srdate <= "'.$endDayDate.'" order by srdate asc'); 
			while($dayData=mysqli_fetch_array($dayQuery)){

				$dayId = $dayData['id'];
				$dayDate = $dayData['srdate'];

		$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
		$quotationData = mysqli_fetch_array($rs1);
		$queryId = $quotationData['queryId'];


		$namevalue ='activityCost="'.$activityCost.'",maxpax="'.$maxPax.'",quotationId="'.$quotationId.'",fromDate="'.$dayDate.'",toDate="'.$dayDate.'",perPaxCost="'.$perPaxCost.'",tariffId="'.$tariffId.'",otherActivityCity="'.$destinationId.'",queryId="'.$queryId.'",supplierId="'.$supplierId.'",dateotherActivity="'.$startDate.'",currencyId="1",otherActivityName="'.$_REQUEST['activityId'].'",dayId="'.$dayId.'",startDayDate="'.$startDayDate.'",endDayDate="'.$endDayDate.'"';
			$lastid = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue);


			$namevalue1 ='serviceId="'.$lastid.'",serviceType="activity", dayId="'.$dayId.'",startDate="'.$dayDate.'",endDate="'.$dayDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
			addlisting('quotationItinerary',$namevalue1);


			?>
			<script>
				//closeinbound();
				loadquotationmainfile();
			</script>
			<?php

		}  
	}

}






























		 ?>
