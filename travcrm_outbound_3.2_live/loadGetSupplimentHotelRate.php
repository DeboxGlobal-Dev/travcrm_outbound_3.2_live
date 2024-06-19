<?php
include "inc.php";   
// hotel data
if($_REQUEST['action']=='getSelectedHotelRate' && $_REQUEST['selectedHotelId']>0 && $_REQUEST['hotelQuoteId']>0){
	 
	$selectedHotelId =$_REQUEST['selectedHotelId']; 
	$selectedHQuery=GetPageRecord('*','quotationHotelMaster',' id="'.$selectedHotelId.'"');  
	$selectedHotelData=mysqli_fetch_array($selectedHQuery);
	$singleCost=0;
	$doubleCost=0;
	if($selectedHotelData['singleNoofRoom']>0){
		$singleCost=getCurrencyName($selectedHotelData['currencyId']).' '.strip($selectedHotelData['singleoccupancy']+$selectedHotelData['supplementCost']).' <small>Per Rm/Nt'; 
		?>
		<script>
		parent.$('#loadSingleRoomCost<?php echo $_REQUEST['hotelQuoteId']; ?>').html('<?php echo $singleCost; ?>');
		</script>
		<?php 
	}
	if($selectedHotelData['doubleNoofRoom']>0){
		$doubleCost=getCurrencyName($selectedHotelData['currencyId']).' '.strip($selectedHotelData['doubleoccupancy']+$selectedHotelData['supplementCost']).' <small>Per Rm/Nt'; 
		?>
		<script>
		parent.$('#loadDoubleRoomCost<?php echo $_REQUEST['hotelQuoteId']; ?>').html('<?php echo $doubleCost; ?>');
		</script>
		<?php 
	}
}
if($_REQUEST['action']=='updateSelectedHotel' && $_REQUEST['isSelectedType'] && $_REQUEST['selectedHotelId']>0 && $_REQUEST['hotelQuoteId']>0){

	$finalcategoryQuery = '';
	if(decode($_REQUEST['finalcategoryQuery'])!='' && strlen(decode($_REQUEST['finalcategoryQuery']))>5){
		echo $finalcategoryQuery = decode($_REQUEST['finalcategoryQuery']);
	}

	$hotelTypeQuery = '';
	if(decode($_REQUEST['hotelTypeQuery'])!='' && strlen(decode($_REQUEST['hotelTypeQuery']))>5){
		echo $hotelTypeQuery = decode($_REQUEST['hotelTypeQuery']);
	}

	$normalHotelQuery=GetPageRecord('*','quotationHotelMaster',' id="'.$_REQUEST['hotelQuoteId'].'"');
	if(mysqli_num_rows($normalHotelQuery)>0){
		$normalHotelSuppD=mysqli_fetch_array($normalHotelQuery);

		$hotelAllQuery="";  
		$hotelAllQuery=GetPageRecord('*','quotationHotelMaster',' quotationId="'.$normalHotelSuppD['quotationId'].'" '.$finalcategoryQuery.' '.$hotelTypeQuery.' and dayId="'.$normalHotelSuppD['dayId'].'" and ( hotelQuoteId="'.$normalHotelSuppD['id'].'" or id="'.$normalHotelSuppD['id'].'" ) and ( isGuestType=1 or isLocalEscort=1 or isForeignEscort=1 or isHotelSupplement=1 or isRoomSupplement=1 ) order by id asc');
		while($normalSuppHRD=mysqli_fetch_array($hotelAllQuery)){

			updatelisting('quotationHotelMaster','isSelectedFinal=0,isSelectedType=""','id="'.$normalSuppHRD['id'].'"');

		}

	}

	updatelisting('quotationHotelMaster','isSelectedFinal=1,isSelectedType="'.$_REQUEST['isSelectedType'].'"','id="'.$_REQUEST['selectedHotelId'].'"');
}

// GUIDE DATA
if($_REQUEST['action']=='getSelectedGuideRate' && $_REQUEST['selectedGuideId']>0 && $_REQUEST['guideQuoteId']>0){
	 
	$selectedGuideId =$_REQUEST['selectedGuideId']; 
	$selectedGQuery=GetPageRecord('*','quotationGuideMaster',' id="'.$selectedGuideId.'"');  
	$selectedGuideData=mysqli_fetch_array($selectedGQuery);
	$serviceCost=0;
	$serviceCost=getCurrencyName($selectedGuideData['currencyId']).' '.strip($selectedGuideData['price']).' <small>Per Rm/Nt'; 
	?>
	<script>
	parent.$('#loadGuideCost<?php echo $_REQUEST['guideQuoteId']; ?>').html('<?php echo $serviceCost; ?>');
	</script>
	<?php 
	
}
if($_REQUEST['action']=='updateSelectedGuide' && $_REQUEST['selectedGuideId']>0 && $_REQUEST['guideQuoteId']>0){

	$normalGuideQuery=GetPageRecord('*','quotationGuideMaster',' id="'.$_REQUEST['guideQuoteId'].'"');
	if(mysqli_num_rows($normalGuideQuery)>0){
		$normalGuideSuppD=mysqli_fetch_array($normalGuideQuery);

		$guideAllQuery="";   
		$guideAllQuery=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$normalGuideSuppD['quotationId'].'" and dayId="'.$normalGuideSuppD['dayId'].'" and ( guideQuoteId="'.$normalGuideSuppD['id'].'" or id="'.$normalGuideSuppD['id'].'" ) and ( isGuestType=1 or isSupplement=1 ) order by id asc');
		while($normalSuppHRD=mysqli_fetch_array($guideAllQuery)){

			updatelisting('quotationGuideMaster','isSelectedFinal=0','id="'.$normalSuppHRD['id'].'"');

		}

	}
	updatelisting('quotationGuideMaster','isSelectedFinal=1','id="'.$_REQUEST['selectedGuideId'].'"');


}
// loadGuideCost
?>

 