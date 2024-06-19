<?php
include "inc.php";
if($_REQUEST['add']=='yes'){
	$isSelectedFinal = $isSelectedType = 0;
	if($_REQUEST['stype'] == 'roomSupplement' && isset($_REQUEST['hotelQuoteId']) ){
		// quotation hotel data
		$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"'); 
		$hotelQuotData=mysqli_fetch_array($c);
		// hotel data
		$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
		$hotelData=mysqli_fetch_array($d);

		$rs232='';
		$rs232=GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"'); 
		$hotelCatD=mysqli_fetch_array($rs232);
 
        $quores=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$hotelQuotData['quotationId'].'" ');  
    	$quotationData=mysqli_fetch_array($quores); 
    	
    	$calculationType = $quotationData['calculationType'];
    	$quotationId = $quotationData['id'];
    	
    	$qsQuery=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');  
    	$queryData=mysqli_fetch_array($qsQuery);
    
    	$roomTariffId = 0;
        
        $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
        $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
        if (mysqli_num_rows($groupSlabPPSql)>0 && $queryData['moduleType'] == 4) {         
            $groupSlabPPD = mysqli_fetch_array($groupSlabPPSql);
              
            $singleRoom = $groupSlabPPD['sglRoom'];
        	$doubleRoom = $groupSlabPPD['dblRoom'];
        	$twinRoom   = $groupSlabPPD['twinRoom'];
        	$tplRoom = $groupSlabPPD['tplRoom']; 
        	$sixNoofBedRoom = $groupSlabPPD['sixNoofBedRoom'];
        	$eightNoofBedRoom = $groupSlabPPD['eightNoofBedRoom'];
        	$tenNoofBedRoom = $groupSlabPPD['tenNoofBedRoom'];
        	$quadNoofRoom = $groupSlabPPD['quadNoofRoom'];
        	$teenNoofRoom = $groupSlabPPD['teenNoofRoom'];
        	
        	$EBedCRoom = $groupSlabPPD['childwithNoofBed'];
        	$childwithoutNoofBed = $groupSlabPPD['childwithoutNoofBed'];
        	$EBedA = $groupSlabPPD['extraNoofBed'];
        	
        }else{
            $singleRoom = $quotationData['sglRoom'];
        	$doubleRoom = $quotationData['dblRoom'];
        	$twinRoom   = $quotationData['twinRoom'];
        	$tplRoom = $quotationData['tplRoom']; 
        	$sixNoofBedRoom = $quotationData['sixNoofBedRoom'];
        	$eightNoofBedRoom = $quotationData['eightNoofBedRoom'];
        	$tenNoofBedRoom = $quotationData['tenNoofBedRoom'];
        	$quadNoofRoom = $quotationData['quadNoofRoom'];
        	$teenNoofRoom = $quotationData['teenNoofRoom'];
        	
        	$EBedCRoom = $quotationData['childwithNoofBed'];
        	$childwithoutNoofBed = $quotationData['childwithoutNoofBed'];
        	$EBedA = $quotationData['extraNoofBed'];
        }
        
        
        
		if($quotationData['isTourEx']==1){
			$isSelectedFinal = 1;
			$isSelectedType = 'isGuestType';
		}

		$startDayId = $hotelQuotData['dayId'];
		$endDayId = $hotelQuotData['dayId'];

		$fromDate = $hotelQuotData['fromDate'];
		$toDate = $hotelQuotData['fromDate'];

		$fromYear=date("Y", strtotime($fromDate));
		$toYear=date("Y", strtotime($toDate));
 		
		$endDayId = $hotelQuotData['dayId'];
		$destinationId=$hotelQuotData['destinationId']; 
		$cityName = getDestination($destinationId);

		$queryId = trim($quotationData['queryId']);
		$quotationId = trim($quotationData['id']);  

		// if($_REQUEST['earlyCheckin'] == 1){
		// 	$fromDate = date("Y-m-d", strtotime("-1 days", strtotime($fromDate)));
		// }
		$supplementId = $_REQUEST['supplementId'];    

 		$rs1='';
		$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
		$queryData = mysqli_fetch_array($rs1);
	 	
	 	// search hotel queyr not in use in save file
		// $whereSTR="";
		// $whereSTR.=' and id = "'.$hotelQuotData['supplierId'].'"'; 

		// $suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and companyTypeId=1 ) and supplierId> 0 '; 

	}else{
		$startDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['startDayId'].'" ');   
		$startDayData=mysqli_fetch_array($startDayQuery); 

		$endDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['endDayId'].'" ');   
		$endDayData=mysqli_fetch_array($endDayQuery); 

		$fromDate=date("Y-m-d", strtotime($startDayData['srdate'])); 
		$toDate=date("Y-m-d", strtotime($endDayData['srdate'])); 

		$fromYear=date("Y", strtotime($fromDate));
		$toYear=date("Y", strtotime($toDate));


		$startDayId = $startDayData['id'];
		$endDayId = $endDayData['id'];	 
        
        $quores=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'" ');  
    	$quotationData=mysqli_fetch_array($quores); 
    	
    	$calculationType = $quotationData['calculationType'];
    	$quotationId = $quotationData['id'];
    	
    	$qsQuery=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');  
    	$queryData=mysqli_fetch_array($qsQuery);
    
    	$roomTariffId = 0;
        
        $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
        $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
        if (mysqli_num_rows($groupSlabPPSql)>0 && $queryData['moduleType'] == 4) {         
            $groupSlabPPD = mysqli_fetch_array($groupSlabPPSql);
              
            $singleRoom2 = $groupSlabPPD['sglRoom'];
        	$doubleRoom2 = $groupSlabPPD['dblRoom'];
        	$twinRoom   = $groupSlabPPD['twinRoom'];
        	$tplRoom = $groupSlabPPD['tplRoom']; 
        	$sixNoofBedRoom = $groupSlabPPD['sixNoofBedRoom'];
        	$eightNoofBedRoom = $groupSlabPPD['eightNoofBedRoom'];
        	$tenNoofBedRoom = $groupSlabPPD['tenNoofBedRoom'];
        	$quadNoofRoom = $groupSlabPPD['quadNoofRoom'];
        	$teenNoofRoom = $groupSlabPPD['teenNoofRoom'];
        	
        	$EBedCRoom = $groupSlabPPD['childwithNoofBed'];
        	$childwithoutNoofBed = $groupSlabPPD['childwithoutNoofBed'];
        	$EBedA = $groupSlabPPD['extraNoofBed'];
        	
        }else{
            $singleRoom2 = $quotationData['sglRoom'];
        	$doubleRoom2 = $quotationData['dblRoom'];
        	$twinRoom   = $quotationData['twinRoom'];
        	$tplRoom = $quotationData['tplRoom']; 
        	$sixNoofBedRoom = $quotationData['sixNoofBedRoom'];
        	$eightNoofBedRoom = $quotationData['eightNoofBedRoom'];
        	$tenNoofBedRoom = $quotationData['tenNoofBedRoom'];
        	$quadNoofRoom = $quotationData['quadNoofRoom'];
        	$teenNoofRoom = $quotationData['teenNoofRoom'];
        	
        	$EBedCRoom = $quotationData['childwithNoofBed'];
        	$childwithoutNoofBed = $quotationData['childwithoutNoofBed'];
        	$EBedA = $quotationData['extraNoofBed'];
        }
        
        
		if($quotationData['isTourEx']==1){
			$isSelectedFinal = 1;
			$isSelectedType = 'isGuestType';
		}

		$destWise=$_REQUEST['destWise']; 
		if($destWise!=2){
			$destinationId=$startDayData['cityId']; 
		}else{
			$destinationId = $_REQUEST['cityId'];
		}

		$cityName = getDestination($destinationId);
		$categoryId = trim($_REQUEST['categoryId']); 
		$hotelTypeId = trim($_REQUEST['hotelTypeId']);  
		$hotelName = preg_replace('!\s+!', ' ', trim($_REQUEST['Hotel']));
		$queryId = trim($quotationData['queryId']);
		$quotationId = trim($quotationData['id']);  
		
		$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
		$queryData = mysqli_fetch_array($rs1);
	  		
		// $suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and companyTypeId=1 ) and supplierId> 0 '; 

		if($quotationData['quotationType'] == 1){	
			$checkQuery = $warningMsg = " ";
			$warningError = 0;
			if($_REQUEST['isGuestType']==1 && $_REQUEST['isHotelSupplement']==0){
				$checkQuery = " and isGuestType=1 ";
				$rsq='';   
				$countHotel = 0;
				$rsq=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" '.$checkQuery.' and fromDate="'.$fromDate.'"');  
				$countHotel = mysqli_num_rows($rsq);
				if($countHotel > 0){
					// msg
					// $warningError = 1;
					$warningMsg .= 'Guest Hotel ,';
				}
			}
			// && $_REQUEST['earlyCheckin']!=1  
			// && $_REQUEST['earlyCheckin']!=1  
			
			if($_REQUEST['isLocalEscort']==1 && $_REQUEST['isHotelSupplement']==0){
				$checkQuery = "  and isLocalEscort=1 ";
				$rsq=''; 
				$countHotel = 0;  
				$rsq=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" '.$checkQuery.' and fromDate="'.$fromDate.'"');  
				$countHotel = mysqli_num_rows($rsq);
				if($countHotel > 0){
					// msg
					// $warningError = 1;
					$warningMsg .= 'Local Escort Hotel ,';
				}
			}
			

			if($_REQUEST['isForeignEscort']==1 && $_REQUEST['isHotelSupplement']==0){
				$checkQuery = "  and isForeignEscort=1  ";
				$rsq='';   
				$countHotel = 0;
				$rsq=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" '.$checkQuery.' and fromDate="'.$fromDate.'"');  
				$countHotel = mysqli_num_rows($rsq);
				if($countHotel > 0){
					// msg
					// $warningError = 1;
					$warningMsg .= 'Foreign Escort Hotel ,';
				}
			}
			

			if($_REQUEST['isHotelSupplement']==1){
				$checkQuery = "  and isHotelSupplement=1 ";
				$rsq='';   
				$countHotel = 0;
				$rsq=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" '.$checkQuery.' and fromDate="'.$fromDate.'"');
				$countHotel = mysqli_num_rows($rsq);
				if($countHotel > 0){
					// msg
					// $warningError = 1;
					$warningMsg .= 'Guest/Supplement Hotel ,';
				}
			}
			// echo $warningError.$warningMsg;
	 
		} 
	}

	// common 
 	$supplementCostAdded = 0;   
	$supplementId = $_REQUEST['supplementId'];    
	$escortHotel = $_REQUEST['escortHotel'];
	$roomTariffId = $_REQUEST['roomTariffId'];
	$tblNum = $_REQUEST['tblNum'];


	$marketId = getQueryMaketType($queryId);
	$whereMarket = '  and marketType=1';
	if($marketId>0){
		$whereMarket = ' and marketType="'.$marketId.'"';
	}

	//daywise loop  
	$rsa2sNormal=$rsa2sNormal2="";
	// echo 'id="'.$roomTariffId.'"';
	$rsa2sNormal=GetPageRecord('*','quotationHotelRateMaster','id="'.$roomTariffId.'"');  
	//normal rate apply from select rate 
	if(mysqli_num_rows($rsa2sNormal)>0 && $tblNum == 2){ 
		$dmcroommastermain=mysqli_fetch_array($rsa2sNormal);
	}else{ 
		$rsa2sNormal2=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$roomTariffId.'"');
		if(mysqli_num_rows($rsa2sNormal2)>0){ 
			$dmcroommastermain=mysqli_fetch_array($rsa2sNormal2);
		} 
	} 

	//hotel data
	if($calculationType != 3){
		$rsa2sNormal=$rsa2sNormal2="";
		// echo 'id="'.$roomTariffId.'"';
		$rsa2sNormal=GetPageRecord('*','quotationHotelRateMaster','id="'.$roomTariffId.'"');  
		//normal rate apply from select rate 
		if(mysqli_num_rows($rsa2sNormal)>0 && $tblNum == 2){ 
			$dmcroommastermain=mysqli_fetch_array($rsa2sNormal);
		}else{ 
			$rsa2sNormal2=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$roomTariffId.'"');
			if(mysqli_num_rows($rsa2sNormal2)>0){ 
				$dmcroommastermain=mysqli_fetch_array($rsa2sNormal2);
			} 
		} 

		$rsh="";
		$rsh=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$dmcroommastermain['serviceid'].'" '); 
		$resListingh=mysqli_fetch_array($rsh); 
	}else{
		$rsh="";
		$rsh=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$_REQUEST['serviceId'].'" '); 
		$resListingh=mysqli_fetch_array($rsh); 
	}

	$mealPlanQuery = '';
	if($dmcroommastermain['mealPlan']!='' && $dmcroommastermain['mealPlan']!=0){
		$mealPlanQuery = 'and mealPlan="'.$dmcroommastermain['mealPlan'].'"'; 
	} 

	$roomTypeQuery = '';
	if($dmcroommastermain['roomType']!='' && $dmcroommastermain['roomType']!=0){
		$roomTypeQuery = ' and roomType="'.$dmcroommastermain['roomType'].'" ';
	}
	
	$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and companyTypeId=1 ) and supplierId> 0 '; 


    if($_REQUEST['earlyCheckin'] == 1){
		$toDate=$fromDate;
	}

	// loop for hotel query inserting number of date .
 	$dayCnt = 0;  
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'"  and srdate >= "'.$fromDate.'" and  srdate <= "'.$toDate.'" order by srdate asc');  
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){   
		if($_REQUEST['earlyCheckin'] == 1){
			$dayDate = date('Y-m-d',(strtotime('-1 day', strtotime($QueryDaysData['srdate'])))); 
		}else{
			$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		}
		$dayId = $QueryDaysData['id']; 
		// $destinationId = $QueryDaysData['cityId'];  
		
	 	$fit_gitQuery = ""; 
		if($queryData['paxType']==1 || $queryData['paxType']==2){
			$fit_gitQuery = " and paxType='".$queryData['paxType']."' ";
		}else{
			$fit_gitQuery = " and paxType=2 ";
		}

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
		$normalCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="1" ');
		
		//for special
		$specialCheckQuery = ""; 
		$specialCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="3" ');
		
		 //for weekend 
		$weekendCheckQuery = ""; 
		$weekendCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="2" and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($dayDate)).'", daysName) ) ) ');
		 
		if(mysqli_num_rows($specialCheckQuery)>0 && $queryData['dayWise'] != 2){ 
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
		$rssup1=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and tarifType="4" ');
		if($dmcrate==1 ){	
			if(mysqli_num_rows($rssup1) > 0 && $dmcrate==1  ){
				$supplementCost=mysqli_fetch_array($rssup1);

				$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['singleoccupancy'],0,0,1,0,0);

				$doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['singleoccupancy'],0,0,1,0,0);

				$childwithbed =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childwithbed'],0,0,1,0,0);

				$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['extraBed'],0,0,1,0,0);

				$childwithoutbed =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childwithoutbed'],0,0,1,0,0);

				$sixBedRoom =  getCostWithGSTID_Markup($dmcroommastermain['sixBedRoom'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['sixBedRoom'],0,0,1,0,0);

				$eightBedRoom =  getCostWithGSTID_Markup($dmcroommastermain['eightBedRoom'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['eightBedRoom'],0,0,1,0,0);

				$tenBedRoom =  getCostWithGSTID_Markup($dmcroommastermain['tenBedRoom'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['tenBedRoom'],0,0,1,0,0);

				$quadRoom =  getCostWithGSTID_Markup($dmcroommastermain['quadRoom'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['quadRoom'],0,0,1,0,0);

				$teenRoom =  getCostWithGSTID_Markup($dmcroommastermain['teenRoom'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['teenRoom'],0,0,1,0,0);

				$childBreakfast =  getCostWithGSTID_Markup($dmcroommastermain['childBreakfast'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childBreakfast'],0,0,1,0,0);

				$childLunch =  getCostWithGSTID_Markup($dmcroommastermain['childLunch'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childLunch'],0,0,1,0,0);

				$childDinner =  getCostWithGSTID_Markup($dmcroommastermain['childDinner'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childDinner'],0,0,1,0,0);

				$lunch =  getCostWithGSTID_Markup($dmcroommastermain['lunch'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['lunch'],0,0,1,0,0);

				$dinner =  getCostWithGSTID_Markup($dmcroommastermain['dinner'],0,0,1,0,0)+ getCostWithGSTID_Markup($supplementCost['dinner'],0,0,1,0,0);

				$breakfast =  getCostWithGSTID_Markup($dmcroommastermain['breakfast'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['breakfast'],0,0,1,0,0);
				 
				$supplementCostAdded = 1; 
			}else{
				$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],0,0,0,0,0);

				$doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],0,0,0,0,0);

				$childwithbed =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],0,0,0,0,0);

				$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],0,0,0,0,0);

				$childwithoutbed =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],0,0,0,0,0);

				$sixBedRoom =  $dmcroommastermain['sixBedRoom'];

				$eightBedRoom = $dmcroommastermain['eightBedRoom'];

				$tenBedRoom =  $dmcroommastermain['tenBedRoom'];

				$quadRoom =  $dmcroommastermain['quadRoom'];

				$teenRoom =  $dmcroommastermain['teenRoom'];

				$childBreakfast =  getCostWithGSTID_Markup($dmcroommastermain['childBreakfast'],0,0,1,0,0);

				$childLunch =  getCostWithGSTID_Markup($dmcroommastermain['childLunch'],0,0,1,0,0);

				$childDinner =  getCostWithGSTID_Markup($dmcroommastermain['childDinner'],0,0,1,0,0);

				$lunch =  getCostWithGSTID_Markup($dmcroommastermain['lunch'],0,0,1,0,0);
				$dinner =  getCostWithGSTID_Markup($dmcroommastermain['dinner'],0,0,1,0,0);
				$breakfast =  getCostWithGSTID_Markup($dmcroommastermain['breakfast'],0,0,1,0,0);
				  
				$supplementCostAdded = 0;
			
			} 
		}
	 
	 
	 	//for normal each day
		$qoutrate=0; 
		$tariffQuery=""; 
		$normalCheckQuery = ""; 
		$normalCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and quotationId="'.$quotationId.'" and tarifType="1" ');
		 
		//for special
		$specialCheckQuery = ""; 
		$specialCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and status=1 and quotationId="'.$quotationId.'"  and tarifType="3" ');
		
		 //for weekend 
		$weekendCheckQuery = ""; 
		$weekendCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 and tarifType="2" and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($dayDate)).'", daysName) ) ) ');
		 
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
		$rssup1=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$resListingh['id'].'" '.$roomTypeQuery.' '.$mealPlanQuery.' '.$seasonQuery.'  '.$fit_gitQuery.'  '.$whereMarket.' '.$suppliersQuery.' and quotationId="'.$quotationId.'" and status=1 and tarifType="4"'); 

		if($qoutrate==1 ){

			if(mysqli_num_rows($rssup1) > 0 ){

				$supplementCost=mysqli_fetch_array($rssup1);
				$singleoccupancy = $dmcroommastermain['singleoccupancy'] + $supplementCost['singleoccupancy'];

				$doubleoccupancy = $dmcroommastermain['doubleoccupancy'] + $supplementCost['singleoccupancy'];

				$childwithbed =  $dmcroommastermain['childwithbed'] + $supplementCost['childwithbed'];

				$extraBed =  $dmcroommastermain['extraBed'] + $supplementCost['extraBed'];

				$childwithoutbed =  $dmcroommastermain['childwithoutbed'] + $supplementCost['childwithoutbed'];

				$sixBedRoom =  $dmcroommastermain['sixBedRoom'] + ($supplementCost['sixBedRoom']);

				$eightBedRoom =  ($dmcroommastermain['eightBedRoom']) + ($supplementCost['eightBedRoom']);

				$tenBedRoom =  ($dmcroommastermain['tenBedRoom']) + ($supplementCost['tenBedRoom']);

				$quadRoom =  ($dmcroommastermain['quadRoom']) + ($supplementCost['quadRoom']);

				$teenRoom =  ($dmcroommastermain['teenRoom']) + ($supplementCost['teenRoom']);

				$childBreakfast =  getCostWithGSTID_Markup($dmcroommastermain['childBreakfast'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childBreakfast'],0,0,1,0,0);

				$childLunch =  getCostWithGSTID_Markup($dmcroommastermain['childLunch'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childLunch'],0,0,1,0,0);

				$childDinner =  getCostWithGSTID_Markup($dmcroommastermain['childDinner'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['childDinner'],0,0,1,0,0);

				$lunch =  getCostWithGSTID_Markup($dmcroommastermain['lunch'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['lunch'],0,0,1,0,0);

				$dinner =  getCostWithGSTID_Markup($dmcroommastermain['dinner'],0,0,1,0,0)+ getCostWithGSTID_Markup($supplementCost['dinner'],0,0,1,0,0);

				$breakfast =  getCostWithGSTID_Markup($dmcroommastermain['breakfast'],0,0,1,0,0) + getCostWithGSTID_Markup($supplementCost['breakfast'],0,0,1,0,0);
				 
				$supplementCostAdded = 1; 

			}else{

				$singleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['singleoccupancy'],0,0,0,0,0);

				 $doubleoccupancy = getCostWithGSTID_Markup($dmcroommastermain['doubleoccupancy'],0,0,0,0,0);

				$childwithbed =  getCostWithGSTID_Markup($dmcroommastermain['childwithbed'],0,0,0,0,0);

				$extraBed =  getCostWithGSTID_Markup($dmcroommastermain['extraBed'],0,0,0,0,0);

				$childwithoutbed =  getCostWithGSTID_Markup($dmcroommastermain['childwithoutbed'],0,0,0,0,0);

				$sixBedRoom =  getCostWithGSTID_Markup($dmcroommastermain['sixBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

				$eightBedRoom =  getCostWithGSTID_Markup($dmcroommastermain['eightBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

				$tenBedRoom =  getCostWithGSTID_Markup($dmcroommastermain['tenBedRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

				$quadRoom =  getCostWithGSTID_Markup($dmcroommastermain['quadRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

				$teenRoom =  getCostWithGSTID_Markup($dmcroommastermain['teenRoom'],$dmcroommastermain['roomGST'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'],$dmcroommastermain['roomTAC'],$dmcroommastermain['TACType']);

				$childBreakfast =  getCostWithGSTID_Markup($dmcroommastermain['childBreakfast'],$dmcroommastermain['mealGST'],0,1,0,0);

				$childLunch =  getCostWithGSTID_Markup($dmcroommastermain['childLunch'],$dmcroommastermain['mealGST'],0,1,0,0);

				$childDinner =  getCostWithGSTID_Markup($dmcroommastermain['childDinner'],$dmcroommastermain['mealGST'],0,1,0,0);

				$lunch =  getCostWithGSTID_Markup($dmcroommastermain['lunch'],$dmcroommastermain['mealGST'],0,1,0,0);
				$dinner =  getCostWithGSTID_Markup($dmcroommastermain['dinner'],$dmcroommastermain['mealGST'],0,1,0,0);
				$breakfast =  getCostWithGSTID_Markup($dmcroommastermain['breakfast'],$dmcroommastermain['mealGST'],0,1,0,0);
				  
				$supplementCostAdded = 0; 
			
			} 
		}
		if($qoutrate==1 || $dmcrate==1 || $calculationType==3 ){    
			//check for duplicat
			if($_REQUEST['stype'] == 'roomSupplement' && isset($_REQUEST['hotelQuoteId']) ){
				// quotation hotel data
				$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"'); 
				$hotelQuotData=mysqli_fetch_array($c);
				
				$isHotelSupplement=$isGuestType=0;
				$isRoomSupplement=1;

				$hotelQuoteId = $_REQUEST['hotelQuoteId'];

				$isEarlyCheckin=$hotelQuotData['isEarlyCheckin'];
				$isLocalEscort=$hotelQuotData['isLocalEscort'];
				$isForeignEscort=$hotelQuotData['isForeignEscort'];

				$sglRoom=$hotelQuotData['singleNoofRoom'];
				$dblRoom=$hotelQuotData['doubleNoofRoom'];
				$twinRoom=$hotelQuotData['twinNoofRoom'];
				$tplRoom=$hotelQuotData['tripleNoofRoom'];
				$quadNoofRoom=$hotelQuotData['quadNoofRoom'];
				$sixNoofBedRoom=$hotelQuotData['sixNoofBedRoom'];
				$eightNoofBedRoom=$hotelQuotData['eightNoofBedRoom'];
				$tenNoofBedRoom=$hotelQuotData['tenNoofBedRoom'];
				$teenNoofRoom=$hotelQuotData['teenNoofRoom'];
				$extraNoofBed=$hotelQuotData['extraNoofBed'];
				$childwithNoofBed=$hotelQuotData['childwithNoofBed'];
				$childwithoutNoofBed=$hotelQuotData['childwithoutNoofBed'];

				$rand_color = $hotelQuotData['rand_color'];

			}elseif($_REQUEST['stype'] == 'hotelSupplement' && isset($_REQUEST['hotelQuoteId']) ){
				// quotation hotel data
				$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"'); 
				$hotelQuotData=mysqli_fetch_array($c);

				$hotelQuoteId = $_REQUEST['hotelQuoteId'];

				$isHotelSupplement=1;
				$isGuestType=$isRoomSupplement=$isEarlyCheckin=$isLocalEscort=$isForeignEscort=0;

				$sglRoom=$hotelQuotData['singleNoofRoom'];
				$dblRoom=$hotelQuotData['doubleNoofRoom'];
				$twinRoom=$hotelQuotData['twinNoofRoom'];
				$tplRoom=$hotelQuotData['tripleNoofRoom'];
				$quadNoofRoom=$hotelQuotData['quadNoofRoom'];
				$sixNoofBedRoom=$hotelQuotData['sixNoofBedRoom'];
				$eightNoofBedRoom=$hotelQuotData['eightNoofBedRoom'];
				$tenNoofBedRoom=$hotelQuotData['tenNoofBedRoom'];
				$teenNoofRoom=$hotelQuotData['teenNoofRoom'];
				$extraNoofBed=$hotelQuotData['extraNoofBed'];
				$childwithNoofBed=$hotelQuotData['childwithNoofBed'];
				$childwithoutNoofBed=$hotelQuotData['childwithoutNoofBed'];


				$rand_color = $hotelQuotData['rand_color'];

			}else{
                
                $quoresf='';
                $quoresf=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" ');  
            	$quotationData=mysqli_fetch_array($quoresf); 
            	
				// get the all local escort and foreign escor with room and type
				$defaultSlabSql = "";
				$defaultSlabSql = GetPageRecord('*', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and status=1 ');
				if(mysqli_num_rows($defaultSlabSql)>0) {
				    $defaultSlabData = mysqli_fetch_array($defaultSlabSql);
				    $slabId = $defaultSlabData['id'];
				    $paxAdultLE = $defaultSlabData['localEscort'];
				    $paxAdultFE = $defaultSlabData['foreignEscort'];
				    $esQLE = "";
				    // echo ' 1 and slabId="'.$slabId.'" and focType="LE" and quotationId="'.$quotationId.'"';
				    $esQLE = GetPageRecord('*', 'quotationFOCRates',' 1 and slabId="'.$slabId.'" and focType="LE" and quotationId="'.$quotationId.'"');
				    if (mysqli_num_rows($esQLE)>0 && $paxAdultLE>0) {
				        $escortDataLE = mysqli_fetch_array($esQLE);
				        $sglRoomLE = $escortDataLE['sglNORoom'];
				        $dblRoomLE = $escortDataLE['dblNORoom'];
				    }
				    $esQFE = "";
				    $esQFE = GetPageRecord('*', 'quotationFOCRates', ' 1 and slabId="'.$slabId.'" and focType="FE" and quotationId="'.$quotationId.'"');
				    if (mysqli_num_rows($esQFE)>0 && $paxAdultFE>0) {
				        $escortDataFE = mysqli_fetch_array($esQFE);
				        $sglRoomFE = $escortDataFE['sglNORoom'];
				        $dblRoomFE = $escortDataFE['dblNORoom'];
				    }

				    if ($defaultSlabData['fromRange'] == $defaultSlabData['toRange'] || $defaultSlabData['toRange'] == 0) {
				        $paxrange = $defaultSlabData['fromRange'];
				    } else {
				        $paxrange = $defaultSlabData['fromRange'] . '-' . $defaultSlabData['toRange'];
				    }
				}
				
				$alertMsg = $escortQuery = '';
				$sglRoom = $dblRoom = 0;
				$isHotelSupplement=$isRoomSupplement=$isLocalEscort=$isForeignEscort=$isGuestType=0;
				if($_REQUEST['isLocalEscort']==1){
					$isLocalEscort=1;
					$sglRoom = $sglRoom + $sglRoomLE;
					$dblRoom = $dblRoom + $dblRoomLE;

					// check for local escort hotel exist 
					$rsLE="";
	 				$rsLE=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and queryId="'.$queryId.'"  and isLocalEscort="'.$isLocalEscort.'"  and fromDate="'.$dayDate.'" and supplierId="'.$resListingh['id'].'"'); 
	 				if(mysqli_num_rows($rsLE) > 0 ){ 
	 					$isLocalEscort=0;
	 					$alertMsg .= ' Local Escort,';
	 				}else{
						$escortQuery .= " and  isLocalEscort=".$isLocalEscort." ";
	 				}
				}
				if($_REQUEST['isForeignEscort']==1){
					$isForeignEscort=1;
					$sglRoom = $sglRoom + $sglRoomFE;
					$dblRoom = $dblRoom + $dblRoomFE;

					// check for Foreign Escort hotel exist 
					$rsFE="";
	 				$rsFE=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and queryId="'.$queryId.'"  and isForeignEscort="'.$isForeignEscort.'"  and fromDate="'.$dayDate.'" and supplierId="'.$resListingh['id'].'"'); 
	 				if(mysqli_num_rows($rsFE) > 0 ){ 
	 					$isForeignEscort=0;
	 					$alertMsg .= ' Foreign Escort,';
	 				}else{
						$escortQuery .= " and  isForeignEscort=".$isForeignEscort." ";
	 				}
				} 
				 
				$qsQuery2='';
				$qsQuery2=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" ');  
            	$queryData=mysqli_fetch_array($qsQuery2);
                
				// set the no of rooms
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if(mysqli_num_rows($groupSlabPPSql)>0 && $queryData['moduleType'] == 4) {         
                    $groupSlabPPD = mysqli_fetch_array($groupSlabPPSql);
                      
                    $singleRoom2 = $groupSlabPPD['sglRoom'];
                	$doubleRoom2 = $groupSlabPPD['dblRoom'];
                	$twinRoom   = $groupSlabPPD['twinRoom'];
                	$tplRoom = $groupSlabPPD['tplRoom']; 
                	$sixNoofBedRoom = $groupSlabPPD['sixNoofBedRoom'];
                	$eightNoofBedRoom = $groupSlabPPD['eightNoofBedRoom'];
                	$tenNoofBedRoom = $groupSlabPPD['tenNoofBedRoom'];
                	$quadNoofRoom = $groupSlabPPD['quadNoofRoom'];
                	$teenNoofRoom = $groupSlabPPD['teenNoofRoom'];
                	
                	$childwithNoofBed = $groupSlabPPD['childwithNoofBed'];
                	$childwithoutNoofBed = $groupSlabPPD['childwithoutNoofBed'];
                	$extraNoofBed = $groupSlabPPD['extraNoofBed'];
                	
                }else{
                    $singleRoom2 = $quotationData['sglRoom'];
                	$doubleRoom2 = $quotationData['dblRoom'];
                	$twinRoom   = $quotationData['twinRoom'];
                	$tplRoom = $quotationData['tplRoom']; 
                	$sixNoofBedRoom = $quotationData['sixNoofBedRoom'];
                	$eightNoofBedRoom = $quotationData['eightNoofBedRoom'];
                	$tenNoofBedRoom = $quotationData['tenNoofBedRoom'];
                	$quadNoofRoom = $quotationData['quadNoofRoom'];
                	$teenNoofRoom = $quotationData['teenNoofRoom'];
                	
                	$childwithNoofBed = $quotationData['childwithNoofBed'];
                	$childwithoutNoofBed = $quotationData['childwithoutNoofBed'];
                	$extraNoofBed = $quotationData['extraNoofBed'];
                } 
                
				if($_REQUEST['isGuestType']==1 || $_REQUEST['earlyCheckin']==1){
					$isGuestType=1;
					$isEarlyCheckin = 0;
					if($_REQUEST['earlyCheckin']==1){
						$isEarlyCheckin = 1;
					}
					
					$sglRoom = $sglRoom + $singleRoom2;
					$dblRoom = $dblRoom + $doubleRoom2;
 
				} 
				
				
				$hotelQuoteId = 0;    

				// make random color for normal rates
				$allColorArr = array('#FF6347', '#3cb44b', '#ffe119', '#7FFF00', '#f58231', '#911eb4', '#46f0f0', '#f032e6', '#bcf60c', '#fabebe', '#008080', '#e6beff', '#9a6324', '#fffac8', '#A52A2A', '#aaffc3', '#808000', '#ffd8b1', '#4169E1', '#808080', '#F0E68C', '#C0C0C0');

				$usedColorQuery="";
				$usedColorArr = array();
				// echo 'quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and dayId="'.$dayId.'" and fromDate="'.$dayDate.'"';
 				$usedColorQuery=GetPageRecord('rand_color',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and dayId="'.$dayId.'" and fromDate="'.$dayDate.'"'); 
				$cnt = 0;
				while($usedColorArrD = mysqli_fetch_array($usedColorQuery)){
					$usedColorArr[$cnt] = $usedColorArrD['rand_color'];
					$cnt++;
				}
				// echo '<pre>';
				// var_dump($usedColorArr);
				$remColorArray = array_diff($allColorArr, $usedColorArr);
				
				// get the random color from remaing colors
				$rand_color = $remColorArray[array_rand($remColorArray)];

			}	 

			if($calculationType == 3){
				$checkPackageRateQuery="";
				$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
				if(mysqli_num_rows($checkPackageRateQuery) > 0){
		 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	
				    
				    $currencyId = $getPackageRateData['currencyId'];
				    $currencyValue = getCurrencyVal($currencyId);
				    $supplierId = $getPackageRateData['supplierId'];
				} 
 
				$tarifType = 1;
				$roomType = 0;
				$whereCheck = ' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and fromDate="'.$dayDate.'" and supplierId="'.$resListingh['id'].'"';
			}else{
				$roomType = $dmcroommastermain['roomType'];
				$tarifType = $dmcroommastermain['tarifType'];
				$currencyId = $dmcroommastermain['currencyId'];
				$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
				$supplierId = $dmcroommastermain['supplierId'];

				$whereCheck = ' quotationId="'.$quotationId.'" and mealPlan="'.$dmcroommastermain['mealPlan'].'"  and roomType="'.$dmcroommastermain['roomType'].'" and dayId="'.$dayId.'" and fromDate="'.$dayDate.'" and supplierId="'.$resListingh['id'].'"'.$escortQuery.'';
			}

			$rs5="";
  			$rs5=GetPageRecord('id',_QUOTATION_HOTEL_MASTER_,$whereCheck); 
			if(mysqli_num_rows($rs5) < 1 ){
				//roomTariffId
				// hotelTypeId

				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$resListingh['hotelCategoryId'].'",hotelTypeId="'.$resListingh['hotelTypeId'].'",quotationId="'.$quotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$dayDate.'",toDate="'.$dayDate.'",startDayDate="'.$fromDate.'",endDayDate="'.$toDate.'",supplierId="'.$resListingh['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",roomGST="'.$dmcroommastermain['roomGST'].'",mealGST="'.$dmcroommastermain['mealGST'].'",markupType="'.$dmcroommastermain['markupType'].'",markupCost="'.$dmcroommastermain['markupCost'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",twinoccupancy="'.$doubleoccupancy.'",tripleoccupancy="'.($doubleoccupancy+$extraBed).'",extraBed="'.$extraBed.'",childwithbed="'.$childwithbed.'",childwithoutbed="'.$childwithoutbed.'",sixBedRoom="'.$sixBedRoom.'",eightBedRoom="'.$eightBedRoom.'",tenBedRoom="'.$tenBedRoom.'",quadRoom="'.$quadRoom.'",teenRoom="'.$teenRoom.'",singleNoofRoom="'.$sglRoom.'",doubleNoofRoom="'.$dblRoom.'",twinNoofRoom="'.$twinRoom.'",tripleNoofRoom="'.$tplRoom.'",extraNoofBed="'.$extraNoofBed.'",childwithNoofBed="'.$childwithNoofBed.'",childwithoutNoofBed="'.$childwithoutNoofBed.'",sixNoofBedRoom="'.$sixNoofBedRoom.'",eightNoofBedRoom="'.$eightNoofBedRoom.'",tenNoofBedRoom="'.$tenNoofBedRoom.'",quadNoofRoom="'.$quadNoofRoom.'",teenNoofRoom="'.$teenNoofRoom.'",childBreakfast="'.$childBreakfast.'",childLunch="'.$childLunch.'",childDinner="'.$childDinner.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",supplierMasterId="'.$supplierId.'",roomTariffId="'.$roomTariffId.'",escortHotelStatus="'.$escortHotel.'",isHotelSupplement="'.$isHotelSupplement.'",isRoomSupplement="'.$isRoomSupplement.'",escortType="'.$escortType.'",isGuestType="'.$isGuestType.'",isLocalEscort="'.$isLocalEscort.'",isForeignEscort="'.$isForeignEscort.'",isEarlyCheckin="'.$isEarlyCheckin.'",remark="'.$dmcroommastermain['remarks'].'",hotelQuoteId="'.$hotelQuoteId.'",rand_color="'.$rand_color.'",roomTAC="'.$dmcroommastermain['roomTAC'].'",TACType="'.$dmcroommastermain['TACType'].'",status="1"';  
				
				$lastid=addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);
				
				$rs5="";
	  			$rs5=GetPageRecord('*','quotationItinerary','quotationId="'.$quotationId.'" and serviceType="hotel" and dayId="'.$dayId.'" and startDate="'.$dayDate.'" and serviceId="'.$resListingh['id'].'"'); 
				if(mysqli_num_rows($rs5) < 1 ){ 
				
					$namevalue1 ='serviceId="'.$resListingh['id'].'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$dayDate.'",endDate="'.$dayDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
					addlisting('quotationItinerary',$namevalue1); 
				}
				?>
				<script> 
				closeinbound(); 
				loadquotationmainfile();
				</script>
				<?php							
			}
			else{
				?> 
				<script> 
				closeinbound(); 
				parent.alert("<?php echo rtrim($alertMsg,','); ?> Rate already exist.");
				</script>
				<?php
			} 

		}else{
			?> 
			<script> 
			// closeinbound(); 
			parent.alert("No tariff found for <?php echo date('d-m-Y',strtotime($dayDate)); ?>.");
			</script>
			<?php
		}  
		
		$dayCnt++;
	}  
}
?> 