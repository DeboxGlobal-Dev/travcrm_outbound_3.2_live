<?php
include "inc.php";  
if($_REQUEST['add']=='yes' && $_REQUEST['roomTariffId']!=''){
	$roomTariffId = $_REQUEST['roomTariffId'];
	$destinationId = $_REQUEST['cityId'];  
		  
 	
	$startDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['startDayId'].'" ');  
	$startDayData=mysqli_fetch_array($startDayQuery);
	
	$endDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['endDayId'].'" ');  
	$endDayData=mysqli_fetch_array($endDayQuery);
	
 	$quotationId = $startDayData['quotationId'];
	$queryId = $startDayData['queryId'];
	
	//niu
	$startDayId = $_REQUEST['startDayId'];
	$endDayId = $_REQUEST['endDayId'];	
	$supplementId = $_REQUEST['supplementId'];    
 	
	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
	$queryData = mysqli_fetch_array($rs1q);

 
	//daywise loop  
 	$supplementCostAdded = 0;   
	$alertTariff = 1;  
	$rsa2sNormal=$rsa2sNormal2="";
	$rsa2sNormal=GetPageRecord('*','quotationHotelRateMaster','id="'.$roomTariffId.'"');  
	 
	//normal rate apply from select rate 
	if(mysqli_num_rows($rsa2sNormal)>0 && $_REQUEST['tblNum'] == 2){ 
		$dmcroommastermain=mysqli_fetch_array($rsa2sNormal);
	}else{ 
		$rsa2sNormal2=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$roomTariffId.'"');
		if(mysqli_num_rows($rsa2sNormal2)>0){ 
			$dmcroommastermain=mysqli_fetch_array($rsa2sNormal2);
		} 
	} 
	
 		
	$mealPlan = '';
	if($dmcroommastermain['mealPlan']!='' && $dmcroommastermain['mealPlan']!=0){
		$mealPlan = 'and mealPlan="'.$dmcroommastermain['mealPlan'].'"'; 
	} 
	   
	$marketId = getQueryMaketType($queryId);
	$whereMarket = '';
	if($marketId>0){
		$whereMarket = ' and marketType="'.$marketId.'"';
	}
	
	$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and companyTypeId=1 ) and supplierId> 0 '; 


	$roomTypeQuery = '';
	if($dmcroommastermain['roomType']!='' && $dmcroommastermain['roomType']!=0){
		$roomTypeQuery = ' and roomType="'.$dmcroommastermain['roomType'].'" '; 
	}
			
	//hotel data
	$rsh="";
	$rsh=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$dmcroommastermain['serviceid'].'" '); 
	$resListingh=mysqli_fetch_array($rsh); 
	 
	if($_REQUEST['earlyCheckin'] == 1){
		$fromDate = $startDayData['srdate'];
		$toDate = $startDayData['srdate']; 
	}else{
		$fromDate = $startDayData['srdate'];
		$toDate = $endDayData['srdate']; 
	}	
	 	
 	$dayCnt = 0;  
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'"  and srdate >= "'.$fromDate.'" and  srdate <= "'.$toDate.'" order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){   
	
		if($_REQUEST['earlyCheckin'] == 1){
			$dayDate = date('Y-m-d',(strtotime('-1 day', strtotime($QueryDaysData['srdate'])))); 
		}else{
			$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		}
		$dayId = $QueryDaysData['id']; 
		$destinationId = $QueryDaysData['cityId'];

		$seasonQuery = ""; 
		if($queryData['dayWise'] == 2){
			if($queryData['seasonType']!= 3 ){
				$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
			}else{
				$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and YEAR(fromDate) = '".$queryData['seasonYear']."'";
			}
		}else{
			 $seasonQuery = " and DATE(fromDate)<='".$dayDate."' and  DATE(toDate)>='".$dayDate."'";
		}	
		
		 
		//data from dmc   
		//for normal each day
		$dmcrate=0;
		$tariffQuery=""; 
		$normalCheckQuery = ""; 
		$normalCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'   '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="1" ');
		 
		//for special
		$specialCheckQuery = ""; 
		$specialCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'   '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="3" ');
		
		 //for weekend 
		$weekendCheckQuery = ""; 
		$weekendCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'   '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="2" and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($dayDate)).'", daysName) ) ) ');
		 
		if(mysqli_num_rows($specialCheckQuery)>0){ 
			//if have special
			$dmcrate=1;
			$dmcroommastermain=mysqli_fetch_array($specialCheckQuery);
		}elseif(mysqli_num_rows($weekendCheckQuery)>0  && $queryData['dayWise'] != 2){
			//if have weekend 
			$dmcrate=1;
			$dmcroommastermain=mysqli_fetch_array($weekendCheckQuery);
		}elseif(mysqli_num_rows($normalCheckQuery)>0){
			// if have normal
			$dmcrate=1;
			$dmcroommastermain=mysqli_fetch_array($normalCheckQuery);
		} else{ 	
			$dmcrate=0;
		}
		 
		  
		$rssup1 = ""; 
		$rssup1=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'   '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="4" '); 
			
		if(mysqli_num_rows($rssup1) > 0 && $dmcrate==1  ){
			$supplementCost=mysqli_fetch_array($rssup1);
			$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0);
			$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0);
			$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0);
			 
			$supplementCostAdded = 1; 
		}else{
			$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0);
			$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0);
			$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0);
			  
			$supplementCostAdded = 0; 
		
		} 
	 
	 
	 	//for normal each day
		$qoutrate=0; 
		$tariffQuery=""; 
		$normalCheckQuery = ""; 
		$normalCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'   '.$whereMarket.' '.$suppliersQuery.' and status=1 and quotationId="'.$quotationId.'"  and tarifType="1" ');
		 
		//for special
		$specialCheckQuery = ""; 
		$specialCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'   '.$whereMarket.' '.$suppliersQuery.' and status=1 and quotationId="'.$quotationId.'"  and tarifType="3" ');
		
		 //for weekend 
		$weekendCheckQuery = ""; 
		$weekendCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'   '.$whereMarket.' '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 and tarifType="2" and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($dayDate)).'", daysName) ) ) ');
		 
		if(mysqli_num_rows($specialCheckQuery)>0){ 
			//if have special
			$qoutrate=1; 
			$dmcroommastermain=mysqli_fetch_array($specialCheckQuery);
		}elseif(mysqli_num_rows($weekendCheckQuery)>0){
			//if have weekend 
			$qoutrate=1; 
			$dmcroommastermain=mysqli_fetch_array($weekendCheckQuery);
		}elseif(mysqli_num_rows($normalCheckQuery)>0){
			// if have normal
			$qoutrate=1; 
			$dmcroommastermain=mysqli_fetch_array($normalCheckQuery);
		} else{
			$qoutrate=0;
		}
		  
		$rssup1 = ""; 
		$rssup1=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'   '.$whereMarket.' '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 and tarifType="4"'); 
			
		if(mysqli_num_rows($rssup1) > 0 && $qoutrate==1  ){
			$supplementCost=mysqli_fetch_array($rssup1);
			$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0);
			$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0);
			$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0);
			 
			$supplementCostAdded = 1; 
		}else{
			$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0);
			$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0);
			$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0);
			  
			$supplementCostAdded = 0; 
		
		} 
		 
		if($qoutrate==1 || $dmcrate==1){   
			//check for duplicate
			$wheresup5="";
			$rs5="";
			$wheresup5='quotationId="'.$quotationId.'" and queryId="'.$queryId.'"  and dayId="'.$dayId.'" and supplierId="'.$resListingh['id'].'"';
			$rs5=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,$wheresup5); 
			if(mysqli_num_rows($rs5) < 1 ){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$resListingh['hotelCategoryId'].'",quotationId="'.$quotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$dayDate.'",toDate="'.$dayDate.'",supplierId="'.$resListingh['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",twinoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",isHotelSupplement=1,isRoomSupplement=1,status="1"';  
				$lastid=addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);
				   
				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$dayDate.'",endDate="'.$dayDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
				addlisting('quotationItinerary',$namevalue1); 
				?>
				<script> 
				closeinbound(); 
				loadquotationmainfile();
				</script>
				<?php							
			}else{
				?> 
				<script> 
				closeinbound(); 
				parent.alert("Hotel already exist.");
				</script>
				<?php
			}  
		}else{
			?> 
			<script> 
			closeinbound(); 
			parent.alert("No tariff found for <?php echo date('d-m-Y',strtotime($dayDate)); ?>.");
			</script>
			<?php
		}  
		
		$dayCnt++;
	}  
}
?>
   