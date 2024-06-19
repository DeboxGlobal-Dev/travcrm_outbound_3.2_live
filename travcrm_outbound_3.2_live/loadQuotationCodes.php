<?php
include "inc.php"; 
if(trim($_REQUEST['action'])=='editHotelPrice' && trim($_REQUEST['serviceid'])!='' && trim($_REQUEST['roomTypeId'])!=''){	

	$rs=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid='.$_REQUEST['serviceid'].' and ( fromDate BETWEEN "'.date('Y-m-d',$_REQUEST['fromDate']).'" and "'.date('Y-m-d',$_REQUEST['toDate']).'" OR "'.date('Y-m-d',$_REQUEST['fromDate']).'" BETWEEN fromDate and toDate ) and  roomType="'.$_REQUEST['roomTypeId'].'" '); 

	if( mysqli_num_rows($rs) > 0){ 

		$priceData=mysqli_fetch_array($rs);
        echo json_encode(array(
        	"singleoccupancy" => round($priceData['singleoccupancy'],2),
			"doubleoccupancy" => round($priceData['doubleoccupancy'],2),
			"quadRoom" => round($priceData['quadRoom'],2),
			"extraBed" => round($priceData['extraBed'],2),
			"childwithbed" => round($priceData['childwithbed'],2),
			"childwithoutbed" => round($priceData['childwithoutbed'],2),
			"sixBedRoom" => round($priceData['sixBedRoom'],2),
			"eightBedRoom" => round($priceData['eightBedRoom'],2),
			"tenBedRoom" => round($priceData['tenBedRoom'],2),
			"teenRoom" => round($priceData['teenRoom'],2),
			"sixBedRoom" => round($priceData['sixBedRoom'],2),
			"sixBedRoom" => round($priceData['sixBedRoom'],2),

			"breakfast" => round($priceData['breakfast'],2),
			"lunch" => round($priceData['lunch'],2),
			"dinner" => round($priceData['dinner'],2),

			"breakfastChild" => round($priceData['childBreakfast'],2),
			"lunchChild" => round($priceData['childLunch'],2),
			"dinnerChild" => round($priceData['childDinner'],2),

			"remarks" => round($priceData['remarks'],2)
		));

	}else{
        echo json_encode(array("singleoccupancy" => 0,
			"doubleoccupancy" => 0,
			"quadRoom" => 0,
			"extraBed" => 0,
			"childwithbed" => 0,
			"childwithoutbed" => 0,
			"sixBedRoom" => 0,
			"eightBedRoom" => 0,
			"tenBedRoom" => 0,
			"teenRoom" => 0,
			"sixBedRoom" => 0,
			"sixBedRoom" => 0,

			"breakfast" => 0,
			"lunch" => 0,
			"dinner" => 0,

			"breakfastChild" => 0,
			"lunchChild" => 0,
			"dinnerChild" => 0,

			"remarks" => 0
		)); 
	}  
	
} 

if(trim($_REQUEST['action'])=='editHotelAdditionalprice' && trim($_REQUEST['serviceid'])!=''){	

	$wherePrice1='serviceid="'.$_REQUEST['serviceid'].'"'; 
	$rsPrice1=GetPageRecord('*','dmcAdditionalHotelRate',$wherePrice1); 
	
	$wherePrice2='id="'.$$rsPrice1['additionalName'].'"'; 
	$rsPrice22=GetPageRecord('*','additionalHotelMaster',$wherePrice2); 
	// $rsPrice22['name'];
	if( mysqli_num_rows($rsPrice1) > 0){ 
		$priceData1=mysqli_fetch_array($rsPrice1);
        echo json_encode(array(
	 	"additionalCost" => round($priceData1['additionalCost'],2),
		)); 
	}else{
         echo json_encode(array(
		 	"additionalCost" => 0,
		)); 
	}  
	
} 
