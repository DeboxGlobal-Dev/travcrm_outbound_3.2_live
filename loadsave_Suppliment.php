<?php
include "inc.php";  
if(trim($_REQUEST['action'])=='add_RoomSupplement' && trim($_REQUEST['hotelQuoteId'])!=''){

	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"'); 
	$hotelQuotData=mysqli_fetch_array($c);

	// hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
	$resListingh=mysqli_fetch_array($d);  
	
	$quotationId = trim($hotelQuotData['quotationId']);    
	
	$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$hotelQuotData['queryId'].'"'); 
	$queryData = mysqli_fetch_array($rs1);
	  
	$roomTariffId = $_REQUEST['roomTariffId'];
	$destinationId = $hotelQuotData['destinationId'];  
	$quotationId = $_REQUEST['quotationId']; 
	$supplementId = $_REQUEST['supplementId'];  
	
	$fromDate=date("Y-m-d", strtotime($hotelQuotData['fromDate'])); 
	$toDate=date("Y-m-d", strtotime($hotelQuotData['toDate'])); 
	
	$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData = mysqli_fetch_array($rs1); 
	$queryId = $quotationData['queryId'];
  
	// quotationHotelRateMaster
	$supplementCostAdded = 0; 
	$alertTariff = 1; 
	$rsa2s="";
	$rsa2s=GetPageRecord('*','quotationHotelRateMaster','id="'.$roomTariffId.'" and quotationId="'.$quotationId.'"');   
	//normal rate apply
	if(mysqli_num_rows($rsa2s)>0 && $_REQUEST['tblNum'] == 2){ 
		$dmcroommastermain=mysqli_fetch_array($rsa2s);
		
		$rssup1 = "";
		$rssup1=GetPageRecord('*','quotationHotelRateMaster','id="'.$_REQUEST['supplementId'].'"'); 
	 
		if(mysqli_num_rows($rssup1) > 0 && mysqli_num_rows($rsa2s) > 0 && $_REQUEST['supplementId']!=0){
			$supplementCost=mysqli_fetch_array($rssup1);
			$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$teenRoomCost =  getCostWithGST($dmcroommastermain['teenRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['teenRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$quadRoomCost =  getCostWithGST($dmcroommastermain['quadRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['quadRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$sixBedRoomCost =  getCostWithGST($dmcroommastermain['sixBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['sixBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$eightBedRoomCost =  getCostWithGST($dmcroommastermain['eightBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['eightBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$tenBedRoomCost =  getCostWithGST($dmcroommastermain['tenBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['tenBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$childBreakfast =  getCostWithGST($dmcroommastermain['childBreakfast'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['childBreakfast'],$supplementCost['mealGST'],0);

			$childLunch =  getCostWithGST($dmcroommastermain['childLunch'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['childLunch'],$supplementCost['mealGST'],0);

			$childDinner =  getCostWithGST($dmcroommastermain['childDinner'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['childDinner'],$supplementCost['mealGST'],0);

			$lunch =  getCostWithGST($dmcroommastermain['lunch'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['lunch'],$supplementCost['mealGST'],0);

			$dinner =  getCostWithGST($dmcroommastermain['dinner'],$dmcroommastermain['mealGST'],0)+ getCostWithGST($supplementCost['dinner'],$supplementCost['mealGST'],0);

			$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['breakfast'],$supplementCost['mealGST'],0);
			 
			$supplementCostAdded = 1; 
		}else{
			$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
				
			$teenRoomCost =  getCostWithGST($dmcroommastermain['teenRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$quadRoomCost =  getCostWithGST($dmcroommastermain['quadRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$sixBedRoomCost =  getCostWithGST($dmcroommastermain['sixBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$eightBedRoomCost =  getCostWithGST($dmcroommastermain['eightBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$tenBedRoomCost =  getCostWithGST($dmcroommastermain['tenBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$childBreakfast =  getCostWithGST($dmcroommastermain['childBreakfast'],$dmcroommastermain['mealGST'],0);

			$childLunch =  getCostWithGST($dmcroommastermain['childLunch'],$dmcroommastermain['mealGST'],0);

			$childDinner =  getCostWithGST($dmcroommastermain['childDinner'],$dmcroommastermain['mealGST'],0);

			$lunch =  getCostWithGST($dmcroommastermain['lunch'],$dmcroommastermain['mealGST'],0);

			$dinner =  getCostWithGST($dmcroommastermain['dinner'],$dmcroommastermain['mealGST'],0);
			$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],$dmcroommastermain['mealGST'],0);
			  
			$supplementCostAdded = 0; 
		
		} 
		
		  
			
	}
	else{ 
		$rsa2s="";
		$rsa2s=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$roomTariffId.'"');
		if(mysqli_num_rows($rsa2s)>0){ 
			$dmcroommastermain=mysqli_fetch_array($rsa2s);
			// echo $dmcroommastermain['id'];
		}
	 
		$rssup2 = ""; 
		$rssup2=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$_REQUEST['supplementId'].'"'); 
	 
		if(mysqli_num_rows($rssup2) > 0 && mysqli_num_rows($rsa2s) > 0 && $_REQUEST['supplementId']>0){
			$supplementCost=mysqli_fetch_array($rssup2);
			$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
			$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$teenRoomCost =  getCostWithGST($dmcroommastermain['teenRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['teenRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$quadRoomCost =  getCostWithGST($dmcroommastermain['quadRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['quadRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$sixBedRoomCost =  getCostWithGST($dmcroommastermain['sixBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['sixBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$eightBedRoomCost =  getCostWithGST($dmcroommastermain['eightBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['eightBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$tenBedRoomCost =  getCostWithGST($dmcroommastermain['tenBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['tenBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

			$childBreakfast =  getCostWithGST($dmcroommastermain['childBreakfast'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['childBreakfast'],$supplementCost['mealGST'],0);

			$childLunch =  getCostWithGST($dmcroommastermain['childLunch'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['childLunch'],$supplementCost['mealGST'],0);

			$childDinner =  getCostWithGST($dmcroommastermain['childDinner'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['childDinner'],$supplementCost['mealGST'],0);

			$lunch =  getCostWithGST($dmcroommastermain['lunch'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['lunch'],$supplementCost['mealGST'],0);

			$dinner =  getCostWithGST($dmcroommastermain['dinner'],$dmcroommastermain['mealGST'],0)+ getCostWithGST($supplementCost['dinner'],$supplementCost['mealGST'],0);

			$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],$dmcroommastermain['mealGST'],0) + getCostWithGST($supplementCost['breakfast'],$supplementCost['mealGST'],0);
			 
			$supplementCostAdded = 1; 
		}else{
			$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
			$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$teenRoomCost =  getCostWithGST($dmcroommastermain['teenRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$quadRoomCost =  getCostWithGST($dmcroommastermain['quadRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$sixBedRoomCost =  getCostWithGST($dmcroommastermain['sixBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$eightBedRoomCost =  getCostWithGST($dmcroommastermain['eightBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$tenBedRoomCost =  getCostWithGST($dmcroommastermain['tenBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

			$childBreakfast =  getCostWithGST($dmcroommastermain['childBreakfast'],$dmcroommastermain['mealGST'],0);

			$childLunch =  getCostWithGST($dmcroommastermain['childLunch'],$dmcroommastermain['mealGST'],0);

			$childDinner =  getCostWithGST($dmcroommastermain['childDinner'],$dmcroommastermain['mealGST'],0);

			$lunch =  getCostWithGST($dmcroommastermain['lunch'],$dmcroommastermain['mealGST'],0);

			$dinner =  getCostWithGST($dmcroommastermain['dinner'],$dmcroommastermain['mealGST'],0);

			$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],$dmcroommastermain['mealGST'],0);
			  
			$supplementCostAdded = 0; 
		}
	}  

	// set the no of rooms
	$sglRoom = $hotelQuotData['sglRoom'];
	$dblRoom = $hotelQuotData['dblRoom'];
	$tplRoom = $hotelQuotData['tplRoom'];
	$twinRoom = $hotelQuotData['twinRoom'];
	$quadNoofRoom = $hotelQuotData['quadNoofRoom'];
	$sixNoofBedRoom = $hotelQuotData['sixNoofBedRoom'];
	$eightNoofBedRoom = $hotelQuotData['eightNoofBedRoom'];
	$tenNoofBedRoom = $hotelQuotData['tenNoofBedRoom'];
	$teenNoofRoom = $hotelQuotData['teenNoofRoom'];
	$childwithNoofBed = $hotelQuotData['childwithNoofBed'];
	$childwithoutNoofBed = $hotelQuotData['childwithoutNoofBed'];
	$extraNoofBed = $hotelQuotData['extraNoofBed'];
	// other info
	$sglRoom = $hotelQuotData['sglRoom'];


	$wheresup5="";
	$rs5="";
	$wheresup5='quotationId="'.$quotationId.'" and roomType="'.$dmcroommastermain['roomType'].'" and queryId="'.$queryId.'" and hotelQuoteId="'.$hotelQuotData['id'].'"'; 
	$rs5=GetPageRecord('*','quotationRoomSupplimentMaster',$wheresup5); 
	if(mysqli_num_rows($rs5) > 0 ){
		?> 
		<script> 
		// closeinbound(); 
		alert("Room Supplement already exist.");
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
		</script>
		<?php
		exit();
	}else{

		$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",dayId="'.$_REQUEST['dayId'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelQuotData['categoryId'].'",quotationId="'.$quotationId.'",roomType="'.$dmcroommastermain['roomType'].'" ,queryId="'.$queryId.'",supplierId="'.$hotelQuotData['supplierId'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",childBreakfast="'.$childBreakfast.'",childLunch="'.$childLunch.'",childDinner="'.$childDinner.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1", hotelQuoteId="'.$hotelQuotData['id'].'",roomGST="'.getGstValueById($dmcroommastermain['roomGST']).'",mealGST="'.$dmcroommastermain['mealGST'].'",TAC="'.$dmcroommastermain['TAC'].'",singleNoofRoom="'.$hotelQuotData['singleNoofRoom'].'",doubleNoofRoom="'.$hotelQuotData['doubleNoofRoom'].'",twinNoofRoom="'.$hotelQuotData['twinNoofRoom'].'",tripleNoofRoom="'.$hotelQuotData['tripleNoofRoom'].'",extraNoofBed="'.$hotelQuotData['extraNoofBed'].'",childwithNoofBed="'.$hotelQuotData['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelQuotData['childwithoutNoofBed'].'",sixNoofBedRoom="'.$hotelQuotData['sixNoofBedRoom'].'",eightNoofBedRoom="'.$hotelQuotData['eightNoofBedRoom'].'",tenNoofBedRoom="'.$hotelQuotData['tenNoofBedRoom'].'",quadNoofRoom="'.$hotelQuotData['quadNoofRoom'].'",teenNoofRoom="'.$hotelQuotData['teenNoofRoom'].'",isGuestType="'.$hotelQuotData['isGuestType'].'",isLocalEscort="'.$hotelQuotData['isLocalEscort'].'",isForeignEscort="'.$hotelQuotData['isForeignEscort'].'",teenRoom="'.$teenRoomCost.'",quadRoom="'.$quadRoomCost.'",sixBedRoom="'.$sixBedRoomCost.'",eightBedRoom="'.$eightBedRoomCost.'",tenBedRoom="'.$tenBedRoomCost.'"';  

		$lastid=addlistinggetlastid('quotationRoomSupplimentMaster',$namevalue);

	}
	$dayId++; 	
	?> 
	<script> 
		parent.closeinbound();
		parent.loadquotationmainfile();  
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script> 
	<?php
}

?>
   
  