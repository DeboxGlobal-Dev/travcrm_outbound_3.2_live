<?php
include "inc.php"; 
//quotation data
$in=0;
$rs=''; 
$rs=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'" and status=1 '); 
$quotationData=mysqli_fetch_array($rs);
$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$totalPax = ($quotationData['adult']+$quotationData['child']+$quotationData['infant']);
$room = ($quotationData['sglRoom']+$quotationData['dblRoom']+$quotationData['tplRoom']);

$costType = $quotationData['costType'];
$discountType= $quotationData['discountType'];
$discountTax = $quotationData['discount'];

//slab Date
$slabSql="";
$slabSql=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1'); 
if(mysqli_num_rows($slabSql) > 0 ){
	$slabsData=mysqli_fetch_array($slabSql);
	$slabId = $slabsData['id']; 
	$dfactor = $slabsData['dividingFactor']; 
}

// query data 
$rs=''; 
$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$queryId.'"'); 
$resultpage=mysqli_fetch_array($rs); 

$tourId  = makeQueryTourId($resultpage['id']);
$leadPaxName  = $resultpage['leadPaxName'];
$bookingId = makeQueryId($resultpage['id']);
$queryfromDate=$resultpage['fromDate']; 
 
$n=1; 

?> 
<div style="position:relative;">  
<?php 
$dateSets0 = getHotelDateSets($quotationId,0);
$dateSetArray0 = explode('~',$dateSets0);
// check above for hotels that non confirmed

// check below for other services non confirmed
$qIQuery1='';   
$qIQuery1=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and totalPax="'.$slabId.'" and manualStatus <> 3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 ) or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and manualStatus <> 3 ) ) order by startDate asc');
if(mysqli_num_rows($qIQuery1) > 0){ 
	
	if($_REQUEST['apiurl']=='1'){ }else{
	?>
	<!-- Unconfirm Services -->

	<div style="padding: 40px;background-color: #fff;width: 800px;">
	<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;" class="removeEle" > 
	<tr>
	<td colspan="5" align="left"><strong style="color: red; font-size:20px;font-weight: 500;">Unconfirm Services</strong></td>
	</tr>
	<tr> 
		<td width="15%" bgcolor="#CCCCCC"><strong>Service Date</strong></td>
		<td width="15%" bgcolor="#CCCCCC"><strong>Type</strong></td>
		<td width="30%" bgcolor="#CCCCCC"><strong>Services</strong></td>
		<td width="25%" bgcolor="#CCCCCC"><strong>Supplier Name</strong></td>
		<td width="15%" bgcolor="#CCCCCC"><strong>Status</strong></td> 
	</tr>
	<?php  
	// for hotel only  
	if(strlen($dateSets0) > 0){ 
		$cnt1 = 1;
		foreach($dateSetArray0 as $dateSet0){
			$dateSetData0 = explode('^',$dateSet0);
			$hotelId = $dateSetData0[0];
			$fromDate = $dateSetData0[1];
			$toDate = $dateSetData0[2];
			$FID = $dateSetData0[3];

			$g="";
			$g=GetPageRecord('*','finalQuote','id="'.$FID.'"'); 
			$finalHotelData=mysqli_fetch_array($g);
			
			$c="";
			$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"'); 
			$hotelData=mysqli_fetch_array($c); 
			 
			if($finalHotelData['manualStatus']<>3){ 
			$g="";
			$g=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$finalHotelData['supplierId'].'"'); 
			$supplierData=mysqli_fetch_array($g);	
            
            
			if ($finalHotelData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($finalHotelData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($finalHotelData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($finalHotelData['manualStatus']=='5') {
				$status='Waiting';
			}else{
			    $status='Pending';
			}	

			?>
			<tr>
				<td><?php echo date('d-m-Y',strtotime($fromDate)); ?></td>
				<td><?php echo 'Hotel'; ?></td>
				<td><?php echo $hotelData['hotelName']; ?></td>
				<td><?php echo $supplierData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
			</tr>
			<?php
			$cnt1++;		 
		}
		}	
	}

	while($unConfirmedD=mysqli_fetch_array($qIQuery1)){ 
		if($unConfirmedD['serviceType'] == 'entrance'){
    		$entranceQQuery='';    
    		$entranceQQuery=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3  and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc '); 
    		while($entrData=mysqli_fetch_array($entranceQQuery)){
     
    
    			$c="";  
    			$c=GetPageRecord('*','packageBuilderEntranceMaster','id="'.$entrData['entranceId'].'"'); 
    			$entranceDData=mysqli_fetch_array($c);		
    
    			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$entrData['supplierId'].'"');
    			$supplierNameData=mysqli_fetch_array($supplierNameRes);
    
    
    			if ($entrData['manualStatus']=='0') {
    				$status='Pending';
    			}elseif ($entrData['manualStatus']=='2') {
    				$status='Requested';
    			}elseif ($entrData['manualStatus']=='4') {
    				$status='Rejected';
    			}elseif ($entrData['manualStatus']=='5') {
    				$status='Waiting';
    			}else{
    			    $status='Pending';
    			}	
    			
    			//check if supplier is self
				$vehicleName = $vehicleType = $transferType = '';
				if($entrData['transferType'] == 2){

			        $d=GetPageRecord('*','vehicleMaster','id="'.$entrData['vehicleId'].'"'); 
			        $vehicleData=mysqli_fetch_array($d);

					$vehicleName = $vehicleData['model']." | ";
					$vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
				}
				$transferType = ($entrData['transferType'] == 1)?'SIC | ':'Private | ';
				//	$transferType.$vehicleType.$vehicleName.


    		 	?>
    			
    			<tr>
    				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
    				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
    				<td><?php echo $transferType.$vehicleType.$vehicleName.ucfirst($entranceDData['entranceName']); ?></td>
    				<td><?php echo $supplierNameData['name']; ?></td>
    				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
    			</tr>
    			
    		<?php	 
    			}
		}			
	
		if($unConfirmedD['serviceType'] == 'activity'){
			$activityQQuery='';    
			$activityQQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3 and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc ');
			while($actiData=mysqli_fetch_array($activityQQuery)){
	 
			$c="";  
			$c=GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$actiData['activityId'].'"'); 
			$activityDData=mysqli_fetch_array($c);		

			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$actiData['supplierId'].'"');
			$supplierNameData=mysqli_fetch_array($supplierNameRes); 

			if ($actiData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($actiData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($actiData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($actiData['manualStatus']=='5') {
				$status='Waiting';
			}



			?>
			
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $activityDData['otherActivityName']; ?></td>
				<td><?php echo $supplierNameData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
			</tr>

		<?php  
		}
		}	

		if($unConfirmedD['serviceType'] == 'train'){
			$trainQQuery='';    
			$trainQQuery=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3 and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc ');
			while($trainEData=mysqli_fetch_array($trainQQuery)){

			 
				
			$c="";  
			$c=GetPageRecord('*','packageBuilderTrainsMaster','id="'.$trainEData['trainId'].'"'); 
			$trainDData=mysqli_fetch_array($c);		

			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$trainEData['supplierId'].'"');
			$supplierNameData=mysqli_fetch_array($supplierNameRes); 

			if ($trainEData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($trainEData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($trainEData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($trainEData['manualStatus']=='5') {
				$status='Waiting';
			}



			?>
				
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $trainDData['trainName']; ?></td>
				<td><?php echo $supplierNameData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
			</tr>
			
			<?php  
			}
		}	
        
		if($unConfirmedD['serviceType'] == 'guide'){
			$guideQQuery='';    
			$guideQQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3 and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc ');
			while($guideEData=mysqli_fetch_array($guideQQuery)){

				
			$c="";  
			$c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$guideEData['guideId'].'"'); 					
			$guideDData=mysqli_fetch_array($c);		

			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$guideEData['supplierId'].'"');
			$supplierNameData=mysqli_fetch_array($supplierNameRes); 

			if ($guideEData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($guideEData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($guideEData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($guideEData['manualStatus']=='5') {
				$status='Waiting';
			} 
			?> 
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $guideDData['name']; ?></td>
				<td><?php echo $supplierNameData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"></a></b><?php echo $status; ?></td>
			</tr> 
			<?php 
			}  
		}	

		if($unConfirmedD['serviceType'] == 'flight'){
			$flightQQuery='';    
			$flightQQuery=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3 and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc ');
			while($flightEData=mysqli_fetch_array($flightQQuery)){
				
			$c="";  
			$c=GetPageRecord('*','packageBuilderAirlinesMaster','id="'.$flightEData['flightId'].'"'); 
			$flightDData=mysqli_fetch_array($c);		

			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$flightEData['supplierId'].'"');
			$supplierNameData=mysqli_fetch_array($supplierNameRes); 

			if ($flightEData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($flightEData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($flightEData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($flightEData['manualStatus']=='5') {
				$status='Waiting';
			} 
			?>
			
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $flightDData['flightName']; ?></td>
				<td><?php echo $supplierNameData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
			</tr>

			<?php 
			}
		}			
		
		if($unConfirmedD['serviceType'] == 'mealplan'){
			$mealQQuery='';    
			$mealQQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3 and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc ');
			while($mealEData=mysqli_fetch_array($mealQQuery)){
 
			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$mealEData['supplierId'].'"');
			$supplierNameData=mysqli_fetch_array($supplierNameRes); 

			if ($mealEData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($mealEData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($mealEData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($mealEData['manualStatus']=='5') {
				$status='Waiting';
			} 

			?>
			
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $mealEData['mealPlanName']; ?></td>
				<td><?php echo $supplierNameData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
			</tr> 
			<?php  
			}
		}	
    
        if($unConfirmedD['serviceType'] == 'ferry'){
			$ferryQQuery='';    
			$ferryQQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3 and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc ');
			while($ferryData=mysqli_fetch_array($ferryQQuery)){

			$c="";  
			$c=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$ferryData['ferryId'].'"'); 
			$trainDData=mysqli_fetch_array($c);		

			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$ferryData['supplierId'].'"');
			$supplierNameData=mysqli_fetch_array($supplierNameRes); 

			if ($ferryData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($ferryData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($ferryData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($ferryData['manualStatus']=='5') {
				$status='Waiting';
			}
 
			?>
				
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $trainDData['name']; ?></td>
				<td><?php echo $supplierNameData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
			</tr>

			<?php  
			}
		}
		
        if($unConfirmedD['serviceType'] == 'additional'){
			$addsQQuery='';    
			$addsQQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3 and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc ');
			while($addsEData=mysqli_fetch_array($addsQQuery)){

			 
				
			$c="";  
			$c=GetPageRecord('*','extraQuotation','id="'.$addsEData['additionalId'].'"'); 
			$addsDData=mysqli_fetch_array($c);		

			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$addsEData['supplierId'].'"');
			$supplierNameData=mysqli_fetch_array($supplierNameRes); 

			if ($addsEData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($addsEData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($addsEData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($addsEData['manualStatus']=='5') {
				$status='Waiting';
			}
 
			?>
				
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $addsDData['name']; ?></td>
				<td><?php echo $supplierNameData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
			</tr>

			<?php  
			}
		}	
		
		if($unConfirmedD['serviceType'] == 'transfer' || $unConfirmedD['serviceType'] == 'transportation'){
		$tptQuery='';    
		$tptQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$unConfirmedD['quotationId'].'" and manualStatus <> 3 and id="'.$unConfirmedD['serviceId'].'"  order by fromDate asc ');
		while($tptData=mysqli_fetch_array($tptQuery)){

			$c="";  
			$c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$tptData['transferId'].'"'); 
			$transferData=mysqli_fetch_array($c);		

			$supplierNameRes=GetPageRecord('name','suppliersMaster','id="'.$tptData['supplierId'].'"');
			$supplierNameData=mysqli_fetch_array($supplierNameRes); 

			if ($tptData['manualStatus']=='0') {
				$status='Pending';
			}elseif ($tptData['manualStatus']=='2') {
				$status='Requested';
			}elseif ($tptData['manualStatus']=='4') {
				$status='Rejected';
			}elseif ($tptData['manualStatus']=='5') {
				$status='Waiting';
			}

			//check if supplier is self
			$vehicleName = $vehicleType = $transferType = '';
			if($tptData['transferType'] == 2){

		        $d=GetPageRecord('*','vehicleMaster','id="'.$tptData['vehicleModelId'].'"'); 
		        $vehicleData=mysqli_fetch_array($d);

				$vehicleName = $vehicleData['model']." | ";
				$vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
			}
			$transferType = ($tptData['transferType'] == 1)?'SIC | ':'Private | ';
			//	$transferType.$vehicleType.$vehicleName.

			?>
			
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $transferType.$vehicleType.$vehicleName.ucfirst($transferData['transferName']); ?></td>
				<td><?php echo $supplierNameData['name']; ?></td>
				<td><b><a style="color: red !important;" onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($queryId); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><?php echo $status; ?></a></b></td>
			</tr>

			<?php
		} 
		}		

	}
}
	// end transfer
	
} 


if(mysqli_num_rows($qIQuery1) > 0 || strlen($dateSets0) > 0){
?>	
</table> 
</div>
<?php } ?>
<!-- Service date wise list -->
<br>

<!-- Unconfirmed Services End -->

<div class="main-container" style="padding: 40px;background-color: #fff;width: 800px;">
<?php  

//supplier wise voucher loop 
// and status=3
$supplierAliasName='';
$fianlSuppQuery="";
$fianlSuppQuery=GetPageRecord('*','finalQuotSupplierStatus',' quotationId="'.$quotationData['id'].'" and deletestatus=0 group by supplierId order by id asc'); 
if(mysqli_num_rows($fianlSuppQuery)>0){
while($supplierStatusData=mysqli_fetch_array($fianlSuppQuery)){

	$b="";
	$b=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$supplierStatusData['supplierId'].'"'); 
	$suppData=mysqli_fetch_array($b); 
	
	if(strlen($suppData['aliasname'])>1){
		$supplierAliasName = $suppData['aliasname'];
	}else{
		$supplierAliasName = $suppData['name'];
	}

	if($_REQUEST['module']=='SupplierVoucher'){
		$b="";
		$b=GetPageRecord('*',_ADDRESS_MASTER_,' addressParent="'.$suppData['id'].'" and addressType="supplier"'); 
		$supplierAddData=mysqli_fetch_array($b);  
	 
		$b="";
		$b=GetPageRecord('*','suppliercontactPersonMaster',' corporateId="'.$supplierStatusData['supplierId'].'" and contactPerson!="" and deletestatus=0 '); 
		$resListing=mysqli_fetch_array($b);
		$vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
		$suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);



		$isShowSupCont = 0;
		$suppVoucherNoteText = $suppvoucherNotes['supplierVoucherNoteText'];
		$suppbillingInstructionText = $suppvoucherNotes['supplierbillingInstructionText'];
		$isShowSupCont = $suppvoucherNotes['supplierStatus'];
	
	} else{ 
	}
   
	$qIQuery2='';  
 	//serviceId in ( select id from finalQuote where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or 
	$qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) ) group by startDate order by startDate asc');

	if(mysqli_num_rows($qIQuery2) > 0){
	 	// add or update voucher details
		$voucherQuery="";
		$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusData['id'].'" and serviceType="other" and serviceId=0 and quotationId="'.$quotationId.'"'); 
		if(mysqli_num_rows($voucherQuery)<1){
			$namevalue ='quotationId="'.$quotationId.'",supplierStatusId="'.$supplierStatusData['id'].'",serviceType="other",serviceId=0';
			$voucherId = addlistinggetlastid('voucherDetailsMaster',$namevalue);
		} else{
			$voucherDetailData = mysqli_fetch_array($voucherQuery);
			$voucherId  = $voucherDetailData['id'];	
			$queryfromDate  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
		} 
		$showVocherNum = generateVoucherNumber($voucherId,$_REQUEST['module'],strtotime($queryfromDate));	
	 	$suppStatusId_cnt = $supplierStatusData['id'];
		?>
		<!--All services vouchers lists except hotel-->
		<div class="sub-container" style="border:1px dashed #ddd;padding:10px;"  id="mailSectionArea<?php echo strip($supplierStatusData['id']);?>">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr><td> 
			<!--logo block-->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr>
					<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height: 85px; margin: 0 auto;" /></td></tr>
			</table>
			<br>

			<!--address block-->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr>
					<td width="40%">
						<table>
							<tr>
								<td  align="left" style="font-size: 16px;">
									<strong>To:&nbsp;</strong>
									<strong><?php echo strip($supplierAliasName); ?></strong>
								</td>
							</tr>
							<tr>
								<td align="left">
									<strong>Address&nbsp;:&nbsp;</strong>
									<?php echo strip($supplierAddData['address']); ?>
								</td>
							</tr>
							<?php if($isShowSupCont == 1){ ?>
							<tr>
								<td align="left">
									<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong>
									<?php echo strip($resListing['contactPerson']); ?> </td>
							</tr>
							<tr>
								<td align="left">
									<strong>Phone&nbsp;:&nbsp;</strong>
									<?php echo decode($resListing['phone']);  ?> 
								</td>
							</tr>
							<tr>
								<td align="left">
									<strong>Email&nbsp;:&nbsp;</strong>
									 <?php  echo decode($resListing['email']); ?></td>
							</tr>
							<?php } ?>
						</table>
					</td>
					<td width="30%">
						<table>
							<tr>
								<td  align="left">
									<strong>Tour No&nbsp;:&nbsp;</strong>
									<?php echo $tourId; ?>
								</td>
							</tr>
							<tr>
								<td align="left">
									<strong>Tour Date&nbsp;:&nbsp;</strong>
									<?php echo date('d/m/Y', strtotime($resultpage['fromDate']) ); ?>
								</td>
							</tr>
							<?php
							if ($_REQUEST['module'] == 'SupplierVoucher') { ?>
							<tr>
								<td align="left">
									<strong>Lead Pax Name&nbsp;:&nbsp;</strong>
									<?php echo strip($resultpage['leadPaxName']); ?>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td align="left">
									<strong>No&nbsp;Of&nbsp;Pax&nbsp;:&nbsp;</strong>
									<?php echo $totalPax; ?>
								</td>
							</tr> 
							<tr>
								<td  align="left">
									<strong>Booking No:</strong>
									<?php echo $bookingId; ?>
								</td>
							</tr>
						</table>
					</td>
				
				</tr>
			</table>
			<br> 

			<!-- manually voucher no and date -->
			<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="2" style="font-size:12px;">
				<tr>
					<td width="33%">
						<strong>Voucher&nbsp;No.</strong>
					</td>
					<td  width="33%">
						<strong>Voucher&nbsp;Date</strong>
					</td>
					<td width="33%">
						<strong>Reference&nbsp;No.</strong>
					</td>
					<!-- <td>
						<strong>Confirmation&nbsp;No.</strong>
					</td> -->
				</tr>
				<tr> 
					<td width="35%">
					<input type="text" id="voucherNumber<?php echo $supplierStatusData['id']; ?>" placeholder="Voucher No" onchange="savevoucherDetails<?php echo $supplierStatusData['id']; ?>();" value="<?php echo $showVocherNum; ?>" style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" />
					</td>
					<td>
						<input id="voucherDate<?php echo strip($supplierStatusData['id']); ?>" type="date" class="gridfield calfieldicon"  placeholder="Voucher Date" value="<?php if($queryfromDate!='1970-01-01 00:00:00' && $queryfromDate!='0000-00-00 00:00:00' && $queryfromDate!=''){ echo date('Y-m-d', strtotime($queryfromDate)); }else{ echo date('Y-m-d',strtotime($queryfromDate)); } ?>" style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" /> 
					</td>
					<td>
						<input 
						name="voucherReferanceNumber" 
						type="text" 
						id="voucherReferanceNumber<?php echo $supplierStatusData['id']; ?>" 
						onchange="savevoucherDetails<?php echo $supplierStatusData['id']; ?>();"  
						placeholder="Reference No " 
						value="<?php echo $resultpage['referanceNumber']; ?>" 
						style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" /> 
					</td> 
					<!-- <td>
						<input name="confirmationNo" type="text" id="confirmationNo<?php echo $supplierStatusData['id']; ?>" onchange="savevoucherDetails<?php echo $supplierStatusData['id']; ?>();"  placeholder="Confirmation No " value="<?php echo $supplierStatusData['confirmationNo']; ?>" style="width:183px; border:1px solid #ccc; padding:3px; font-size:12px;" /> 
					</td> -->
					<div id="savevoucherDetails<?php echo $supplierStatusData['id']; ?>"  style=" display:none;" >
					</div>
				</tr>
			</table>
			<br>
			<!--In favour of:--> 
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr> 
					<td width="35%"><strong>In favour of:</strong></td>
					<td width="33%"><?php echo $leadPaxName; ?></td>
					<td ><?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0){ echo ', '.$quotationData['child']." Child(s)"; }if($quotationData['infant']>0){ echo ', '.$quotationData['infant']." Infant(s)"; } ?></td>
				</tr>
			</table>
			<br>
			<!--In favour of:--> 
			<!-- <table width="100%" border="0" cellpadding="0" cellspacing="0" >
			   <tr>
				  <td width="35%"><strong>Lead&nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</strong></td>
		 		  <td width="50%"><input name="guest<?php echo strip($supplierStatusData['id']);?>" type="text" id="guest<?php echo strip($supplierStatusData['id']);?>" placeholder="Lead Pax Name" value="<?php echo strip($resultpage['leadPaxName']);  ?>" style="width:140px; border:1px solid #fff; padding:3px; font-size:12px;" /></td>
				  <td width="15%">&nbsp;</td>
			   </tr>
			</table> -->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="removeEle">
			   <tr>
				  <!-- <td width="35%"><strong>Other Pax Details </strong>:</td> -->
				  <td width="20%"><input name="otherGuestName" type="text" id="otherGuestName<?php echo $suppStatusId_cnt;?>" placeholder="Pax Name" value="" style="width:140px; border:1px solid #ccc; padding:3px; font-size:12px;" /></td>
				  <td>
					 <div style="width: fit-content;cursor: pointer;padding: 3px 10px;background-color: #009e67;color: #fff;font-size: 13px;" onclick="addotherGuest('<?php echo $suppStatusId_cnt;?>');">+ Add Other Pax</div>
				  </td>
			   </tr>
			</table>
			<div id="addotherGuest<?php echo $suppStatusId_cnt;?>">&nbsp;</div>
			<script type="text/javascript">
				function addotherGuest(id) {
					var otherGuestName = encodeURI($('#otherGuestName' + id).val());
					$('#addotherGuest' + id).load('loadaddotherGuest.php?action=saveotherGuest&otherGuestName=' + otherGuestName + '&quotationId=<?php echo $quotationId; ?>&supplierStatusId=' + id);
					$('#otherGuestName' + id).val('');
				}
				
				
				function loadotherGuest(id) {
					$('#addotherGuest' + id).load('loadaddotherGuest.php?quotationId=<?php echo $quotationId; ?>&supplierStatusId=' + id);
				}
				
				
				function delother(id, supplierStatusId) { 
					$('#addotherGuest' + supplierStatusId).load('loadaddotherGuest.php?action=deleteotherGuest&delId=' + id +'&quotationId=<?php echo $quotationId; ?>&supplierStatusId=' + supplierStatusId);
				
				}
				
				loadotherGuest('<?php echo $suppStatusId_cnt;?>');
			</script>
			<br>
			<!-- Services Date -->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr> 
					<td width="35%"><strong>Services:</strong></td>
					<td width="85%"><strong>Please provide the services as per the following.</strong></td> 
				</tr>
			</table> 

				<!-- Value Added Services Block Starts -->

				</table> 
				
					<br>
					<?php 
					$VBRC = GetPageRecord('*','finalQuoteVisa','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
					if(mysqli_num_rows($VBRC)>0){
					?>
					<div><strong>VISA Details</strong></div>
					<table width="100%" border="1" cellpadding="5" cellspacing="0">
						<tr>
						<th width="30%">Visa Name</th>
						<th width="30%">Visa Type</th>
						<th>Adult</th>
						<th>Child</th>
						<th>Infant</th>
						</tr>
					
					<?php
					
					while($visaQuoteData = mysqli_fetch_array($VBRC)){
	
					 $rsV = GetPageRecord('*',_VISA_TYPE_MASTER_,'id="'.$visaQuoteData['visaTypeId'].'"');
					 $visaType = mysqli_fetch_array($rsV);
					?>
					<tr>
						<td><?php echo $visaQuoteData['name'] ?></td>
						<td><?php echo $visaType['name'] ?></td>
						<td><?php echo $visaQuoteData['adultPax'] ?></td>
						<td><?php echo $visaQuoteData['childPax'] ?></td>
						<td><?php echo $visaQuoteData['infantPax'] ?></td>
					</tr>
					<?php

				}
				?>
				</table>
				<?php }
				
				$PRS = GetPageRecord('*','finalQuotePassport','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
				if(mysqli_num_rows($PRS)>0){
				?>
					<br>
					<div><strong>Passport Details</strong></div>
					<table width="100%" border="1" cellpadding="5" cellspacing="0">
						<tr>
						<th width="30%">Passport Name</th>
						<th width="30%">Passport Type</th>
						<th>Adult</th>
						<th>Child</th>
						<th>Infant</th>
						</tr>
					
					<?php
				
					while($passportQuoteData = mysqli_fetch_array($PRS)){
	
					 $rsP = GetPageRecord('*',_PASSPORT_TYPE_MASTER_,'id="'.$passportQuoteData['passportTypeId'].'"');
					 $passportType = mysqli_fetch_array($rsP);
					?>
					<tr>
						<td><?php echo $passportQuoteData['name'] ?></td>
						<td><?php echo $passportType['name'] ?></td>
						<td><?php echo $passportQuoteData['adultPax'] ?></td>
						<td><?php echo $passportQuoteData['childPax'] ?></td>
						<td><?php echo $passportQuoteData['infantPax'] ?></td>
					</tr>
					<?php

				}
				?>
				</table>
			<?php }
			
			$PRS = GetPageRecord('*','finalQuoteInsurance','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
			if(mysqli_num_rows($PRS)>0){
			?>
					<br>
					<div><strong>Insurance Details</strong></div>
					<table width="100%" border="1" cellpadding="5" cellspacing="0">
						<tr>
						<th width="30%">Insurance Name</th>
						<th width="30%">Insurance Type</th>
						<th>Adult</th>
						<th>Child</th>
						<th>Infant</th>
						</tr>
					
					<?php
					
					while($insuranceQuoteData = mysqli_fetch_array($PRS)){
	
					 $rsI = GetPageRecord('*',_INSURANCE_TYPE_MASTER_,'id="'.$insuranceQuoteData['insuranceTypeId'].'"');
					 $insuranceType = mysqli_fetch_array($rsI);
					?>
					<tr>
						<td><?php echo $insuranceQuoteData['name'] ?></td>
						<td><?php echo $insuranceType['name'] ?></td>
						<td><?php echo $insuranceQuoteData['adultPax'] ?></td>
						<td><?php echo $insuranceQuoteData['childPax'] ?></td>
						<td><?php echo $insuranceQuoteData['infantPax'] ?></td>
					</tr>
					<?php

				}
				?>
				</table>
				<?php } ?>
				<br>
			


				<!-- Value Added Services Block Ends -->


			<!-- Service date wise list -->
			<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;"> 
				
				<!-- services loop without hotel-->
				<?php  
		 		$cnt=0;
				while($finalIt_Data2=mysqli_fetch_array($qIQuery2)){ 
					if($cnt == 0){
						$startDate=$finalIt_Data2['startDate'];
					}
					$endDate = $finalIt_Data2['startDate'];
					if($cnt != 0){
					?>
					<tr> 
						<td colspan="4">&nbsp;</td>
					</tr>
					<?php } ?>
					<tr> 
						<!-- some change -->
						<td colspan="10"><strong style="font-size: 14px;"><em><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></em></strong></td>
					</tr>
					<?php
					//serial wise loop
					$qIQuery=''; 
					$qIQuery=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) ) and startDate="'.$finalIt_Data2['startDate'].'" order by srn asc');

					
				 	while($finalIt_Data=mysqli_fetch_array($qIQuery)){
		 
						if($finalIt_Data['serviceType'] == 'transfer' || $finalIt_Data['serviceType'] == 'transportation'){  
							$transferQuery='';     
							$transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" order by fromDate asc ');  
							while($finalQuoteTransfer=mysqli_fetch_array($transferQuery)){
								
								$transferFlag = 1;
								$c="";  
								$c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuoteTransfer['transferId'].'"'); 
								$transferData=mysqli_fetch_array($c);
								
								$d=GetPageRecord('*','quotationTransferMaster','id="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
								$transferQuoteData=mysqli_fetch_array($d);
								
		 						$c="";
								$c=GetPageRecord('*','quotationTransferTimelineDetails','  transferQuoteId="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
								$TimeData=mysqli_fetch_array($c);	
								if(strtotime($TimeData['arrivalTime'])=='1621036800' && strtotime($TimeData['dropTime'])=='1621036800' || strtotime($TimeData['arrivalTime']) == ''){
									$startTime24Set = $endTime24Set ='';
								}else{
									$startTime24Set = date('H:i',strtotime($TimeData['arrivalTime']));
									$endTime24Set = date('H:i',strtotime($TimeData['dropTime']));
								} 
								 
								$d="";
								$d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteTransfer['vehicleModelId'].'"'); 
								$vehicleData=mysqli_fetch_array($d);
								
								//check if supplier is self
								$vehicleName = $vehicleType = $transferType = '';
								if($finalQuoteTransfer['transferType'] == 2){

							        $d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteTransfer['vehicleModelId'].'"'); 
							        $vehicleData=mysqli_fetch_array($d);

									$vehicleName = $vehicleData['model']." | ";
									$vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
								}
								$transferType = ($finalQuoteTransfer['transferType'] == 1)?'SIC | ':'Private | ';
								//	$transferType.$vehicleType.$vehicleName.

								?> 
								
								<tr> 
									<td colspan="10"> 
									<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;"> 
									<tr>
										<td colspan="4" bgcolor="#F3F3F3" >
											<strong>Transport&nbsp;Name</strong>
										</td> 
										<td bgcolor="#F3F3F3" colspan="2">
											<strong>Confirmation&nbsp;No.</strong>
										</td>
									</tr>
									<tr> 
									<td colspan="4">
										<?php echo $transferType.$vehicleType.$vehicleName.ucfirst($transferData['transferName']); ?>
									</td> 
									<td style="font-size:16px" colspan="2">
										<strong><em><?php echo strip($finalQuoteTransfer['confirmationNo']); ?></em></strong>
									</td>
									</tr>
									</table>
										
										</td> 
									</tr>
									<?php 
								

									$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$finalQuoteTransfer['transferQuotationId'].'" and quotationId="'.$finalQuoteTransfer['quotationId'].'"');

									if(mysqli_num_rows($c1)>0){
									$transferTimelineData=mysqli_fetch_array($c1);
									
									if($transferTimelineData['arrivalTime']!='' && $transferTimelineData['arrivalTime']!='00:00:00'){
										$arrivalTime = date('H:i',strtotime($transferTimelineData['arrivalTime']));
									}else{
										$arrivalTime = '';
									}
							
									if($transferTimelineData['pickupTime']!='' && $transferTimelineData['pickupTime']!='00:00:00'){
										$pickupTime = date('H:i',strtotime($transferTimelineData['pickupTime']));
									}else{
										$pickupTime = '';
									}
							
									if($transferTimelineData['dropTime']!='' && $transferTimelineData['dropTime']!='00:00:00'){
										$dropTime = date('H:i',strtotime($transferTimelineData['dropTime']));
									}else{
										$dropTime = '';
									}
							
									if($transferTimelineData['mode']=='flight'){
										$transfername = $transferTimelineData['flightName'];
									}elseif($transferTimelineData['mode']=='train'){
										$transfername = $transferTimelineData['trainName'];
									}
							
									if($transferTimelineData['mode']=='flight'){
										$transferNumber = $transferTimelineData['flightNumber'];
									}elseif($transferTimelineData['mode']=='train'){
										$transferNumber = $transferTimelineData['trainNumber'];
									}

									if($transferTimelineData['departureDate']!='' && $transferTimelineData['departureDate']!='0000-00-00'){
										$departureDate = date('d-m-Y',strtotime($transferTimelineData['departureDate']));
									}else{
										$departureDate = '';
									}
							
										?>
					<tr style="background:#ddd;">
						<td align="left">Mode</td>
						
						<td align="left">Date</td>
						<td align="left">Pickup&nbsp;Time</td>
						<td align="left">Drop&nbsp;Time</td>
						<td align="left">pickup&nbsp;Address</td>
						<td align="left">Drop&nbsp;Address</td>
						</tr>						
						
					<tr>
						<td><?php echo ucfirst($transferTimelineData['mode']); ?></td>
						
						<td><?php echo $departureDate; ?></td>
						<td><?php echo $pickupTime; ?></td>
						<td><?php echo $dropTime; ?></td>
						<td><?php echo $transferTimelineData['pickupAddress']; ?></td>
						<td><?php echo $transferTimelineData['dropAddress']; ?></td>
					</tr>
					<tr>

					<?php if($transferTimelineData['mode']=='flight' || $transferTimelineData['mode']=='train'){ ?>
					<tr style="background:#ddd;">
						
						<td align="left">Arrival&nbsp;From</td>
						<td align="left">Arrival&nbsp;Time</td>

						<td align="left">
							<?php if($transferTimelineData['mode']=='flight'){ echo 'Flight&nbsp;Name'; }else{ echo 'Train&nbsp;Name'; } ?>
						</td>
				
						<td align="left">
							<?php if($transferTimelineData['mode']=='flight'){ echo 'Flight&nbsp;Number'; }else{ echo 'Train&nbsp;Number'; } ?>
						</td>
					
					
						<td align="left" colspan="2">Airport&nbsp;Name</td>
					
					</tr>
					<tr>
						<td><?php echo $transferTimelineData['arrivalFrom']; ?></td>
						<td><?php echo $arrivalTime; ?></td>
						
						<td><?php echo $transfername; ?></td>
						<td><?php echo $transferNumber; ?></td>
						

						
						
						<td align="left" colspan="2">
							<?php echo $transferTimelineData['airportName']; ?>
						</td>
				

						
					</tr>
					<?php } } ?>
										<?php //} ?>
									
								<tr>
									<td width="24%"><strong>Attachments</strong></td>
									<td>
										<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteTransfer['image']; ?>"><?php echo substr($finalQuoteTransfer['image'],1,20); ?></a>
									</td>
									<!-- <td width="24%"><strong>Attachment 2</strong></td> -->
									<td>
										<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteTransfer['image2']; ?>"><?php echo substr($finalQuoteTransfer['image2'],1,20); ?></a>
									</td>
									<!-- <td width="24%"><strong>Attachment 3</strong></td> -->
									<td colspan="3">
										<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteTransfer['image3']; ?>"><?php echo substr($finalQuoteTransfer['image3'],1,20); ?></a>
									</td>
								</tr>
								<?php
							}
						}   

						// Ferry Voucher start

						if($finalIt_Data['serviceType'] == 'ferry'){ 
							$ferryQuery='';   
							$ferryQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							while($finalQuoteFerry=mysqli_fetch_array($ferryQuery)){
								 
								$ccc="";
								 $ccc=GetPageRecord('*','quotationFerryMaster','  id="'.$finalQuoteFerry['ferryQuotationId'].'"'); 
								$TimeData=mysqli_fetch_array($ccc);	

								$dddd="";
								 $dddd=GetPageRecord('*','ferryClassMaster','  id="'.$TimeData['ferryClass'].'"'); 
								$ferryClassname=mysqli_fetch_array($dddd);	


								$dd="";
								$dd=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$finalQuoteFerry['ferryId'].'"'); 
								$ferryData=mysqli_fetch_array($dd);

								?>  
								<tr>
									<td bgcolor="#F3F3F3" width="35%">
										<strong>Ferry&nbsp;Name </strong>
									</td>
									<td bgcolor="#F3F3F3" width="35%">
										<strong>Seat&nbsp;Type </strong>
									</td>
									<td bgcolor="#F3F3F3">
										<strong>Arrival&nbsp;Time/Departure&nbsp;Time</strong>
									</td>
									<td bgcolor="#F3F3F3">
										<strong>Confirmation&nbsp;No.</strong>
									</td>
								</tr>
								<tr> 
									<td>Ferry : <?php echo strip($ferryData['name']); ?></td> 
									<td>Ferry : <?php echo strip($ferryClassname['name']); ?></td> 
									<td><?php echo $TimeData['pickupTime']; ?>/<?php echo $TimeData['dropTime']; ?></td> 
									<td style="font-size:16px"><strong><em> <?php echo strip($finalQuoteFerry['confirmationNo']); ?></em></strong></td>
								</tr>
								 <?php 
							 }  
						}

						// Ferry Voucher end

						if($finalIt_Data['serviceType'] == 'entrance'){ 
							$entranceQuery='';   
							$entranceQuery=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							while($finalQuoteEntrance=mysqli_fetch_array($entranceQuery)){
								 
								//quotationId = "'.$quotationData['id'].'" and
								$c="";
								$c=GetPageRecord('*','quotationEntranceTimelineDetails',' hotelQuoteId="'.$finalQuoteEntrance['entranceQuotationId'].'" and quotationId="'.$finalQuoteEntrance['quotationId'].'"');
								// if(mysqli_num_rows($c)>0){
									$entranceTimLData=mysqli_fetch_array($c);
									if($entranceTimLData['startTime']!='' && $entranceTimLData['startTime']!='00:00:00'){
										$startTime = date('H:i:s', strtotime($entranceTimLData['startTime']));
									}else{
										$startTime = '';
									}
								
									if($entranceTimLData['endTime']!='' && $entranceTimLData['endTime']!='00:00:00'){
										$endTime = date('H:i:s', strtotime($entranceTimLData['endTime']));
									}else{
										$endTime = '';
									}
		
									if($entranceTimLData['pickupTime']!='' && $entranceTimLData['pickupTime']!='00:00:00'){
										$pickupTime = date('H:i:s', strtotime($entranceTimLData['pickupTime']));
									}else{
										$pickupTime = '';
									}
		
									if($entranceTimLData['dropTime']!='' && $entranceTimLData['dropTime']!='00:00:00'){
										$dropTime = date('H:i:s', strtotime($entranceTimLData['dropTime']));
									}else{
										$dropTime = '';
									}	
									if($entranceTimLData['departureDate']!='' && $entranceTimLData['departureDate']!='00:00:00'){
										$departureDate = date('d-m-Y', strtotime($entranceTimLData['departureDate']));
									}else{
										$departureDate = '';
									}	
									
									// date('d-m-Y',strtotime($entranceTimLData['departureDate']));

								$c="";
								$c=GetPageRecord('*','packageBuilderEntranceMaster','id="'.$finalQuoteEntrance['entranceId'].'"'); 
								$entranceData=mysqli_fetch_array($c);

								//check if supplier is self
								$vehicleName = $vehicleType = $transferType = '';
								if($finalQuoteEntrance['transferType'] == 2){

							        $d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteEntrance['vehicleId'].'"'); 
							        $vehicleData=mysqli_fetch_array($d);

									$vehicleName = $vehicleData['model']." | ";
									$vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
								}
								if($finalQuoteEntrance['transferType'] == 1){ $transferType = 'SIC | '; }elseif($finalQuoteEntrance['transferType'] == 2){ $transferType = 'Private | ';}else{
									$transferType = 'Ticket Only | ';
								}
								//	$transferType.$vehicleType.$vehicleName.
								?>  
								<tr>
								<th bgcolor="#F3F3F3" width="15%">Date</th>
									<td bgcolor="#F3F3F3" width="20%">
										<strong>Entrance&nbsp;Name</strong>
									</td>
									<td bgcolor="#F3F3F3">
										<strong>Start&nbsp;Time</strong>
									</td>
									<td bgcolor="#F3F3F3">
										<strong>End&nbsp;Time</strong>
									</td>
									<td bgcolor="#F3F3F3">
										<strong>Confirmation&nbsp;No.</strong>
									</td>
								</tr>
								
								<tr> 
								<td style="min-width: 60px;"><?php echo $departureDate; ?></td>
								
								<td><?php echo $transferType.$vehicleType.$vehicleName.ucfirst($entranceData['entranceName']); ?></td> 

									
						<td><?php echo $startTime; ?></td>
						<td><?php echo $endTime; ?></td>
						

									<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteEntrance['confirmationNo']); ?></em></strong></td>
								</tr>

								<tr>
								<td align="left" bgcolor="#F3F3F3"><strong>Pickup&nbsp;Time</strong></td>
									<td align="left" bgcolor="#F3F3F3"><strong>Drop&nbsp;Time</strong></td>
									<td align="left" bgcolor="#F3F3F3"><strong>pickup&nbsp;Address</strong></td>
									<td align="left" bgcolor="#F3F3F3"><strong>Drop&nbsp;Address</strong></td>
								</tr>
								<tr>
									<td style="min-width: 60px;padding: 13px;"><?php echo $pickupTime; ?></td>
									<td style="min-width: 60px;padding: 13px;"><?php echo $dropTime; ?></td>
									<td style="min-width: 60px;padding: 13px;"><?php echo $entranceTimLData['pickupAddress']; ?></td>
									<td style="min-width: 60px;padding: 13px;"><?php echo $entranceTimLData['dropAddress']; ?></td>
								</tr>
						 		<?php 
							 }  
						}
					 	
					 	if($finalIt_Data['serviceType'] == 'activity'){
						
							$activityQuery='';   
							$activityQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							while($finalQuoteActivity=mysqli_fetch_array($activityQuery)){

								$c="";
								$c=GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$finalQuoteActivity['activityId'].'"');
								$activityData=mysqli_fetch_array($c);
		 						
								//quotationId = "'.$quotationData['id'].'" and
								$c="";
								$c=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$finalQuoteActivity['activityQuotationId'].'"');
								$TimeData=mysqli_fetch_array($c);
								if(strtotime($TimeData['startTime'])=='1621036800' && strtotime($TimeData['endTime'])=='1621036800' || strtotime($TimeData['startTime']) == ''){
									$startTime24Set = $endTime24Set ='';
								}else{
									$startTime24Set = date('H:i',strtotime($TimeData['startTime']));
									$endTime24Set = date('H:i',strtotime($TimeData['endTime']));
								} 
								
								if($finalQuoteActivity['transferType'] == 1){
									$transferType = 'SIC';
								 }elseif($finalQuoteActivity['transferType'] == 2){
									$transferType = 'PVT';
								 }elseif($finalQuoteActivity['transferType'] == 3){
									$transferType = 'VIP';
								 }elseif($finalQuoteActivity['transferType'] == 4){
									$transferType = 'Ticket Only';
								 }
								
								?>
								<tr>
									<td colspan="12">
									<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;">
								
								
								<tr>
									<td bgcolor="#F3F3F3" width="35%">
										<strong>Activity&nbsp;Name</strong>
									</td>
									<td bgcolor="#F3F3F3">
										<strong>Start&nbsp;Time</strong>
									</td>
									<td bgcolor="#F3F3F3">
										<strong>End&nbsp;Time</strong>
									</td>
									<td bgcolor="#F3F3F3">
										<strong>Confirmation&nbsp;No.</strong>
									</td>
								</tr>
								<tr>
									<td><?php echo $transferType.' | '. strip($activityData['otherActivityName']); ?></td> 
									<td><?php echo $startTime24Set; ?></td> 
									<td><?php echo $endTime24Set; ?></td> 
									<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteActivity['confirmationNo']); ?></em></strong></td>
								</tr>
								</table>
								</td>
								</tr>
								<?php 
								$cnt++;
							}   
						}
					 
						if($finalIt_Data['serviceType'] == 'train'){ 
							$trainFlag=1;
							$trainQuery='';   
							$trainQuery=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							while($finalQuoteTrains=mysqli_fetch_array($trainQuery)){
							 
								$c=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$finalQuoteTrains['trainId'].'"'); 
								$trainData=mysqli_fetch_array($c);	 
		 						 
								  
								?>   
								<tr> 
									<!-- some change multiple upload -->
									<td  colspan="10">
										<?php  
										// echo $finalQuoteTrains['trainQuotationId']."sssssss";
										$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
										if(trim($finalQuoteTrains['departureTime'])=='' || trim($finalQuoteTrains['arrivalTime'])==''){
											$departureTime = $arrivalTime ='';
										}else{
											$departureTime = date('H:i',strtotime($finalQuoteTrains['departureTime']));
											$arrivalTime = date('H:i',strtotime($finalQuoteTrains['arrivalTime']));
										}
										if(trim($finalQuoteTrains['departureDate'])!='0000-00-00'){
											$departureDate = date('j M Y',strtotime($finalQuoteTrains['departureDate']));
										} 
										if(trim($finalQuoteTrains['arrivalDate'])!='0000-00-00'){
											$arrivalDate = date('j M Y',strtotime($finalQuoteTrains['arrivalDate']));
										} 
										 
										$arrivalTo = getDestination($finalQuoteTrains['arrivalTo']);
										$departureFrom = getDestination($finalQuoteTrains['departureFrom']);
										$trainName = $trainData['trainName'];
										$trainNumber = $finalQuoteTrains['trainNumber']; 
										$trainClass = $finalQuoteTrains['trainClass'];
										
										if($finalQuoteTrains['journeyType'] == 'overnight'){
											$journeyType = 'Overnight';
										}else{
											$journeyType = 'Day';
										}
										?>
										<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;"> 
										<tr>
											<td colspan="6" bgcolor="#F3F3F3" width="35%">
												<strong>Train&nbsp;Name</strong>
											</td> 
											<!-- <td bgcolor="#F3F3F3">
												<strong>Confirmation&nbsp;No.</strong>
											</td> -->
										</tr>
										<tr> 
											<td colspan="6"><?php echo strip($trainName); echo "&nbsp;/Journey&nbsp;Type - ".$journeyType; ?></td>  
											<!-- <td style="font-size:16px"><strong><em><?php echo strip($finalQuoteTrains['confirmationNo']); ?></em></strong></td> -->
										</tr>
										<tr>  
											<td width="18%" >
												<strong>Train&nbsp;Number</strong>									
											</td>
												<td  width="17%">
												<strong>Departure&nbsp;From</strong>									
											</td> 
											<td width="13%" >
												<strong>Arrival&nbsp;To</strong>									
											</td> 
											<td  width="30%">
												<strong>Train&nbsp;Class</strong>									
											</td>
										</tr>
										<tr> 
											<td><?php echo $trainNumber; ?></td> 
											<td><?php echo strip($departureFrom); ?></td> 
											<td><?php echo strip($arrivalTo); ?></td> 
											<td><?php echo $trainClass; ?></td> 
										</tr>
										<tr>
											<td >
												<strong>Departure&nbsp;Date</strong>
											</td>
											<td >
												<strong>Departure&nbsp;Time</strong>
											</td>
											<td >
												<strong>Arrival&nbsp;Date</strong>
											</td>
											<td >
												<strong>Arrival&nbsp;Time</strong>
											</td>
										</tr>
										<tr>
											<td><?php echo $departureDate; ?></td> 
											<td><?php echo $departureTime; ?></td> 
											<td><?php echo $arrivalDate; ?></td> 
											<td><?php echo $arrivalTime; ?></td> 
										</tr>
										</table>
									</td> 
								</tr>

									<!-- started for train reservation request detail -->
								
								<?php 
									$rsst = GetPageRecord('*','trainMultiDetailMaster','quotationId="'.$finalQuoteTrains['quotationId'].'" and parentId="'.$finalQuoteTrains['id'].'"');
									if(mysqli_num_rows($rsst)>0){
										
										?>
								<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="" style="font-size:13px;">
									<tbody>
										<tr>  
											<td width="18%" >
												<strong>Title&nbsp;</strong>									
											</td>
											<td width="18%" >
												<strong>First&nbsp;Name</strong>									
											</td>
											<td width="18%" >
												<strong>Middle&nbsp;Name</strong>									
											</td>
											<td width="18%" >
												<strong>Last&nbsp;Name</strong>									
											</td>
												<td  width="17%">
												<strong>Gender</strong>									
											</td> 
											<td width="13%" >
												<strong>PNR&nbsp;No.</strong>									
											</td> 
											<td  width="30%">
												<strong>Confirmation&nbsp;No.</strong>									
											</td>
										</tr>
										<?php 
										
										while($trainmultData = mysqli_fetch_assoc($rsst)){
										?>
										<tr>  
											<td width="18%" >
											<?php echo strip($trainmultData['title']); ?>								
											</td>
											<td width="18%" >
											<?php echo strip($trainmultData['firstName']); ?>									
											</td>
											<td width="18%" >
											<?php echo ($trainmultData['middleName']); ?>									
											</td>
											<td width="18%" >
											<?php echo strip($trainmultData['lastName']); ?>									
											</td>
												<td  width="17%">
												<?php echo strip($trainmultData['gender']); ?>			
											</td> 
											<td width="13%" >
											<?php echo strip($trainmultData['pnrNo']); ?>								
											</td> 
											<td  width="30%">
											<?php echo strip($trainmultData['confirmationNo']); ?>								
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<?php } ?>
								<br>
								</tr>
									<!-- ended for train reservation request detail -->
								<tr width="100%">
									<td width="25%"><strong>Attachments</strong></td>
									<td >
										<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteTrains['image']; ?>"><?php echo substr($finalQuoteTrains['image'],1,20) ?></a>
										
									</td>
										<!-- <td width="25%"><strong>Attachment 2</strong></td> -->
										<td >
											<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteTrains['image2']; ?>"><?php echo substr($finalQuoteTrains['image2'],1,20); ?></a>
										</td>
										<!-- <td width="25%"><strong>Attachment 3</strong></td> -->
										<td >
											<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteTrains['image3']; ?>"><?php echo substr($finalQuoteTrains['image3'],1,20) ?></a>
										</td>
								</tr>



								<?php 
							} 
						} 
					 	
					 	if($finalIt_Data['serviceType'] == 'flight'){ 
					 		$flightFlag=1;
							$flightQuery='';   
							$flightQuery=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
						 	 
							while($finalQuoteFlights=mysqli_fetch_array($flightQuery)){
							 
								$c=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightId'].'"'); 
								$flightData=mysqli_fetch_array($c);	 
								
								if(strtotime($finalQuoteFlights['arrivalTime'])=='1621036800' && strtotime($finalQuoteFlights['departureTime'])=='1621036800' || strtotime($finalQuoteFlights['arrivalTime']) == ''){
									$startTime24Set = $endTime24Set ='';
								}else{
									$startTime24Set = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
									$endTime24Set = date('H:i',strtotime($finalQuoteFlights['departureTime']));
								}  
								?> 
								
								<tr> 
									<td  colspan="10">
										<?php  
										$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
										if(trim($finalQuoteFlights['departureTime'])=='' || trim($finalQuoteFlights['arrivalTime'])==''){
											$departureTime = $arrivalTime ='';
										}else{
											$departureTime = date('H:i',strtotime($finalQuoteFlights['departureTime']));
											$arrivalTime = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
										}
										if(trim($finalQuoteFlights['departureDate'])!='0000-00-00'){
											$departureDate = date('j M Y',strtotime($finalQuoteFlights['departureDate']));
										} 
										if(trim($finalQuoteFlights['arrivalDate'])!='0000-00-00'){
											$arrivalDate = date('j M Y',strtotime($finalQuoteFlights['arrivalDate']));
										} 
										 
										$arrivalTo = getDestination($finalQuoteFlights['arrivalTo']);
										$departureFrom = getDestination($finalQuoteFlights['departureFrom']);
										
										$flightName = $flightData['flightName'];
										$flightNumber = $finalQuoteFlights['flightNumber']; 
										$flightClass = $finalQuoteFlights['flightClass'];

						$c1=GetPageRecord('*','flightTimeLineMaster',' flightQuoteId="'.$finalQuoteFlights['flightQuotationId'].'" and quotationId="'.$finalQuoteFlights['quotationId'].'" and dayId="'.$finalQuoteFlights['dayId'].'"');
						$timeData = mysqli_fetch_assoc($c1);
						$via = $timeData['via'];

						
										 
										?>
										<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;"> 
										
									
										<tr bgcolor="#F3F3F3">
										<td width="18%" >
												<strong>Flight&nbsp;Name</strong>									
										</td>
											<td width="18%" >
												<strong>Flight&nbsp;Number</strong>									
											</td>
											
											<td  width="30%">
												<strong>Flight&nbsp;Class</strong>									
											</td>

											<?php
												// get baggegs
											$c122=GetPageRecord('*','quotationAirlinesRateMaster',' serviceId="'.$finalQuoteFlights['flightId'].'" and flightNumber="'.$finalQuoteFlights['flightNumber'].'"');
											$timeData222 = mysqli_fetch_assoc($c122);
											?>
											
											<td >
												<strong>Baggage&nbsp;Allowance</strong>
											</td>
										</tr>
										<tr> 
										<td><?php echo strip($flightData['flightName']); ?></td>  
											<td><?php echo $flightNumber; ?></td> 
											
											<td><?php echo $flightClass; ?></td> 
											<td style="font-size:16px"><?php echo $timeData222['baggageAllowance'].' Kg'; ?></td>
										</tr>

										<tr bgcolor="#F3F3F3">
										<td >
												<strong>From&nbsp;</strong>
											</td>
											<td >
												<strong>To&nbsp;</strong>
											</td>
											<td >
												<strong>Departure&nbsp;Date/Time</strong>
											</td>
											<td >
												<strong>Arrival&nbsp;Date/Time</strong>
											</td>
											
										</tr>
										<tr> 

											<td><?php echo $departureFrom; ?></td> 
											<td><?php echo $arrivalTo.'  Via - '.$via; ?></td> 
											<td><?php if($timeData['departureDate']!='' && $timeData['departureDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($timeData['departureDate'])).' / '; } if($timeData['departureTime']!='' && $timeData['departureTime']!='00:00:00'){ echo date('H:i:s',strtotime($timeData['departureTime'])); } ?></td> 

											<td><?php if($timeData['arrivalDate']!='' && $timeData['arrivalDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($timeData['arrivalDate'])).' / '; } if($timeData['arrivalTime']!='' && $timeData['arrivalTime']!='00:00:00'){ echo date('H:i:s',strtotime($timeData['arrivalTime'])); } ?></td> 
										</tr>
								
								<!-- started for train reservation request detail -->
						
								<?php 
											$rss = GetPageRecord('*','flightMultiDetailMaster','quotationId="'.$finalQuoteFlights['quotationId'].'" and parentId="'.$finalQuoteFlights['id'].'"');
											if(mysqli_num_rows($rss)>0){
										
										?>
									<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="" style="font-size:13px;">
										<tbody>
											<tr>  
												<td width="18%" >
													<strong>Title&nbsp;</strong>									
												</td>
												<td width="18%" >
													<strong>First&nbsp;Name</strong>									
												</td>
												<td width="18%" >
													<strong>Middle&nbsp;Name</strong>									
												</td>
												<td width="18%" >
													<strong>Last&nbsp;Name</strong>									
												</td>
													<td  width="17%">
													<strong>Gender</strong>									
												</td> 
												<td width="13%" >
													<strong>PNR&nbsp;No.</strong>									
												</td> 
												<td  width="30%">
													<strong>Confirmation&nbsp;No.</strong>									
												</td>
											</tr>
											<?php
												while($flightmultData = mysqli_fetch_assoc($rss)){  ?>
											<tr>  
												<td width="18%" >
												<?php echo strip($flightmultData['title']); ?>								
												</td>
												<td width="18%" >
												<?php echo strip($flightmultData['firstName']); ?>									
												</td>
												<td width="18%" >
												<?php echo strip($flightmultData['middleName']); ?>									
												</td>
												<td width="18%" >
												<?php echo strip($flightmultData['lastName']); ?>									
												</td>
													<td  width="17%">
													<?php echo strip($flightmultData['gender']); ?>			
												</td> 
												<td width="13%" >
												<?php echo strip($flightmultData['pnrNo']); ?>								
												</td> 
												<td  width="30%">
												<?php echo strip($flightmultData['confirmationNo']); ?>								
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php } ?>
									<br>
									</tr>
										<!-- ended for train reservation request detail -->
										<tr>

										<?php if($finalQuoteFlights['image']!=''){?>
										<tr>
											<td width="25%"><strong>Attachments</strong></td>
												<td >
												<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteFlights['image']; ?>"><?php echo substr($finalQuoteFlights['image'],1,20); ?></a>
											</td>
										<!-- <td width="25%"><strong>Attachment 2</strong></td> -->
											<td >
												<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteFlights['image2']; ?>"><?php echo substr($finalQuoteFlights['image2'],1,20); ?></a>
											</td>
										<!-- <td width="25%"><strong>Attachment 3</strong></td> -->
											<td >
												<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteFlights['image3']; ?>"><?php echo substr($finalQuoteFlights['image3'],1,20); ?></a>
											</td>
										</tr>
										<?php } ?>
									
								</tr>
										</table>
									</td>
								</tr>
								
								<?php  
							}  
						}

					 	if($finalIt_Data['serviceType'] == 'mealplan'){
							$mealPlanQuery='';   
							$mealPlanQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							while($finalQuoteMealPlan=mysqli_fetch_array($mealPlanQuery)){		
								 
								?> 
								<tr>
									<td bgcolor="#F3F3F3" colspan="3" width="35%">
										<strong>Restaurant&nbsp;Name</strong>
									</td>
								
									<td bgcolor="#F3F3F3">
										<strong>Confirmation&nbsp;No.</strong>
									</td>
								</tr>
								<tr> 
									<td colspan="3" ><?php echo strip($finalQuoteMealPlan['mealPlanName']); ?></td>  
									<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteMealPlan['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
							}  
						} 
							
						if($finalIt_Data['serviceType'] == 'additional'){
							$additionalQuery='';   
							$additionalQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
					 	 
							while($finalQuoteadditionalD=mysqli_fetch_array($additionalQuery)){
							
		 						$groupCost = $finalQuoteadditionalD['groupCost'];
								$c=GetPageRecord('*','extraQuotation','id="'.$finalQuoteadditionalD['additionalId'].'"'); 
								$additionalData=mysqli_fetch_array($c);	  
								?>
								<tr>
									<td bgcolor="#F3F3F3" colspan="3" width="35%">
										<strong>Additional&nbsp;Name</strong>
									</td>
								
									<td bgcolor="#F3F3F3">
										<strong>Confirmation&nbsp;No.</strong>
									</td>
								</tr>
								<tr> 
									<td colspan="3" ><?php echo strip($additionalData['name']); ?></td>  
									<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteadditionalD['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php
							}  
						} 
					 
					 	if($finalIt_Data['serviceType'] == 'enroute'){
							$enrouteQuery='';   
							$enrouteQuery=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 		
							while($finalQuoteEnroute=mysqli_fetch_array($enrouteQuery)){
							 
								$c=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id="'.$finalQuoteEnroute['enrouteId'].'"'); 
								$enrouteData=mysqli_fetch_array($c);	
		 
								?> 
								<tr>
									<td bgcolor="#F3F3F3" colspan="3" width="35%">
										<strong>Enroute&nbsp;Name</strong>
									</td>
								
									<td bgcolor="#F3F3F3">
										<strong>Confirmation&nbsp;No.</strong>
									</td>
								</tr>
					 			<tr> 
									<td colspan="3" ><?php echo strip($enrouteData['enrouteName']); ?></td> 
									 <td style="font-size:16px"><strong><em><?php echo strip($finalQuoteEnroute['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
							}  
						} 
					 
					 	if($finalIt_Data['serviceType'] == 'guide'){
							 
							$guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc ');  
					 		while($finalQuoteGuides=mysqli_fetch_array($guideQuery)){
						 
								$c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuides['guideId'].'"'); 
								$guideData=mysqli_fetch_array($c);	 
		 
								?> 
								<tr>
									<td bgcolor="#F3F3F3" colspan="3" width="35%">
										<strong><?php if($finalQuoteGuides['serviceType'] ==1){ echo "Porter";}else{ echo "Guide"; } ?>&nbsp;Name</strong>
									</td>
								
									<td bgcolor="#F3F3F3">
										<strong>Confirmation&nbsp;No.</strong>
									</td>
								</tr>
								<tr> 
									<td colspan="3" ><?php echo strip($guideData['name']); ?></td>  
									<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteGuides['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
							}
						}
					}
					$cnt++;
				} 
			
				?>  
				<!-- end of the services loop from final tables -->
			</table>
			<br> 
			<!-- Arrival Departure for hotel and transfer-->
			<style type="text/css">
				
				@media print
				{    
				    .removeEle{
				        display: none !important;
				    }
					#clearTextid{
									display: none !important;
								}
				#clearTextidhotel{
									display: none !important;
								}
					#showADtime2{
									display: none !important;
								}
					#showADtime{
									display: none !important;
								}
								#NotesTextOther{
						display: none !important;
					}
					#printNotTextother{
						display: block !important;
					}
					#billingInstructionOtherid{
						display: none !important;
					}
					#billingIntructOthertextId{
						display: block !important;
						padding-bottom: 20px;
					}
				}
			</style>
			
			<?php $in++; ?>
			<!-- <button onclick="showHideArrDepBox('<?php echo $voucherDetailData['id']; ?>','<?php echo $voucherDetailData['ArrivalDepartureStatus'] ?>','<?php echo $suppStatusId_cnt; ?>')" class="removeEle" id="showADtime"><?php if ($voucherDetailData['ArrivalDepartureStatus']==1){ echo 'Show'; }else{ echo "Hide";} ?>  Arrival/Departure Time </button> -->

			<!-- <table border="1" borderColor="#ccc" cellpadding="4" width="100%" cellspacing="0" id="myDiv<?php echo $suppStatusId_cnt; ?>" class="showhidArr<?php echo $suppStatusId_cnt; ?> <?php if($voucherDetailData['ArrivalDepartureStatus']==1){ echo 'hideArrival'; } ?>" >
				<tr>
					<td align="left" valign="middle" >
						<strong>Arrival On </strong>			
					</td>
					<td align="left" valign="middle"  >
						<input id="h_arrival_on<?php echo $suppStatusId_cnt;?>" type="date" class="calfieldicon" style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00' && $voucherDetailData['h_arrival_on']!=''){ echo date('Y-m-d',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("Y-m-d");}   ?>" placeholder="Arrival On"/>			</td>
		 			<td align="left" valign="middle"  >
						<strong>From</strong>			</td>
					<td align="left" valign="middle"  >
						<input type="text" id="h_from<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_from']); ?>" placeholder="City"/>			</td>
		 			<td align="left" valign="middle"  >
						<strong>By </strong>			</td>
					<td align="left" valign="middle"  >
						<input type="text" id="h_by_from<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_by_from']); ?>" placeholder="Number"//>			</td>
		 			<td align="left" valign="middle"  >
						<strong>At </strong>			</td>
					<td align="left" valign="middle"  >
						<input type="text" id="h_at_from<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>" class="timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="15" data-min-time="12:00" data-max-time="11:59" data-show-2400="true"/>			</td>  
					 
						<input type="hidden" id="quotationId<?php echo $supplierStatusData['id'];?>" value="<?php echo $quotationId; ?>" />
						<input type="hidden" id="supplierStatusId<?php echo $supplierStatusData['id'];?>" value="<?php echo $supplierStatusData['id']; ?>" /> 
		 				<input type="hidden" id="voucherDetailId<?php echo $supplierStatusData['id'];?>" value="<?php echo strip($voucherId); ?>" /> 
		 		</tr>
				<tr>
					<td align="left" valign="middle">
						<strong>Departure On </strong>			</td>
					<td align="left" valign="middle"><input name="h_departure_on<?php echo $suppStatusId_cnt;?>" type="date" class="calfieldicon" id="h_departure_on<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00' && $voucherDetailData['h_departure_on']!=''){ echo date('Y-m-d',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("Y-m-d");}   ?>" placeholder="Departure On"/></td>
		 			<td align="left" valign="middle">
						<strong>To </strong>			</td>
					<td align="left" valign="middle">
						<input type="text" id="h_to<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_to']); ?>" placeholder="City"//>			</td>
		 			<td align="left" valign="middle">
						<strong>By </strong>			</td>
					<td align="left" valign="middle">
						<input type="text" id="h_by_to<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_by_to']); ?>" placeholder="Number"//>			</td>
		 			<td align="left" valign="middle">
						<strong>At </strong>			</td>
					<td align="left" valign="middle">
						<input type="text" id="h_at_to<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>" class="timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="15" data-min-time="12:00" data-max-time="11:59" data-show-2400="true"/>			</td>
				</tr> 
			</table>    -->

			<!-- Notes and Billing INstructions --> 
			<table border="0" cellpadding="4" cellspacing="0" width="100%">
				<tr align="left" valign="top">
					<td colspan="3">
						<div class="griddiv" id="NotesTextOther">
							<label>
								<strong>Notes</strong><br>
								<textarea id="voucherNotes<?php echo $suppStatusId_cnt;?>" style="width:100%;border: 1px solid #ccc;"  class="gridfield" ><?php if(!empty($voucherDetailData['voucherNotes'])){ echo strip($voucherDetailData['voucherNotes']); }else{ 
										echo $suppVoucherNoteText ; 
									} ?></textarea>
							</label>
						</div>
						<div id="printNotTextother" style="display: none;">
							<label for="Notes"><strong>Notes</strong></label><br>
								<?php echo nl2br(strip($voucherDetailData['voucherNotes'])) ?>
											
						</div>
					</td>
				</tr>
				<tr align="left" valign="top">
					<td colspan="3">
						<div class="griddiv" id="billingInstructionOtherid">
							<label>
								<strong>Billing Instructions&nbsp;&nbsp;<span id="clearTextid"><input type="checkbox" value="0" onclick="billInstYes('<?php echo $suppStatusId_cnt;?>')" id="billInstYes<?php echo $suppStatusId_cnt;?>" style="display: inline-block;" <?php if($voucherDetailData['billInstYes']==0){ ?> checked <?php } ?> >&nbsp;Clear&nbsp;TextArea</span></strong><br>
								<textarea id="billingInstructions<?php echo $suppStatusId_cnt;?>" style="width:100%;border: 1px solid #ccc;" class="gridfield"><?php if(!empty($voucherDetailData['billingInstructions'])){ echo strip($voucherDetailData['billingInstructions']); }else{ echo $suppbillingInstructionText ; } ?></textarea>
							</label>
						</div>
						<div id="billingIntructOthertextId" style="display: none;">
								<label for="Notes"><strong>Billing Instructions</strong></label><br>
								<?php echo nl2br(strip($voucherDetailData['billingInstructions'])) ?>	
							</div>
					</td>
				</tr>
			</table>  
			</td>
			</tr>

			
			<!-- <tr>
			<td colspan="2" align="center"><a href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" style="color:#666666;">Generated by TravCRM</a><br><br></td>
			</tr> -->

		</table>
		</div>
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td colspan="2" align="left">
						<input type="button" value="Save Changes" style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" class="a"  onclick="saveChanges('<?php echo $supplierStatusData['id']; ?>')"  />  
						<!-- mainid = quotationId -->
						<input type="hidden"   id="quotationId<?php echo strip($supplierStatusData['id']);?>" name="quotationId<?php echo strip($supplierStatusData['id']);?>" value="<?php echo $_REQUEST['quotationId']; ?>" />
						<input type="hidden"   id="action<?php echo strip($supplierStatusData['id']);?>" name="action<?php echo strip($supplierStatusData['id']);?>" value="saveSupplierVoucher" /> 			</td>
					<td width="50%" align="right">  
						<?php 
						$voucherString=trim($supplierStatusData['id']).'_0_other_'.trim($_REQUEST['module']).'_'.trim($quotationId).'_1'; 
						?>
						<a href="showpage.crm?module=query&view=yes&supplier=1&supplierId=<?php echo encode($supplierStatusData['supplierId']); ?>&quotationId=<?php echo encode($quotationId); ?>&id=<?php echo encode($queryId); ?>&voucherString=<?php echo $voucherString; ?>" target="_blank" style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF!important;border-radius: 2px;">Send</a>&nbsp;&nbsp; 
						<input type="button" name="Submit" value="Print"  style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF;border-radius: 2px;" onclick="printDiv('mailSectionArea<?php echo strip($supplierStatusData['id']); ?>')" class="a" />			</td> 
				</tr>
			</table>
		<br>
		<?php 
	} ?>

	<!-- Hotel Voucher -->
	<?php
	// for hotel only  
	$dateSets = getHotelDateSets($quotationId,$supplierStatusData['supplierId']);
	$dateSetArray = explode('~',$dateSets);
	$cnt1 = 1;
	if(strlen($dateSets) > 0){ 
		foreach($dateSetArray as $dateSet){
			
			$suppStatusId_cnt = strip($supplierStatusData['id']."_".$cnt1);
			
			$dateSetData = explode('^',$dateSet);
			$hotelId = $dateSetData[0];
			$fromDate = $dateSetData[1];
			$toDate = $dateSetData[2];
			$FID = $dateSetData[3];
			 
			$c="";
			$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"'); 
			$hotelData=mysqli_fetch_array($c); 
			 
			$g="";
			$g=GetPageRecord('*','finalQuote','id="'.$FID.'"'); 
			$finalHotelData=mysqli_fetch_array($g);
			if($finalHotelData['manualStatus']==3){

				$rooms = '';
				if($finalHotelData['roomSingle'] > 0){ $rooms .= $finalHotelData['roomSingle']." SGL ,"; }
				if($finalHotelData['roomDouble'] > 0){ $rooms .= $finalHotelData['roomDouble']." DBL ,"; }
				if($finalHotelData['roomTriple'] > 0){ $rooms .= $finalHotelData['roomTriple']." TPL ,"; }
				if($finalHotelData['roomTwin'] > 0){ $rooms .= $finalHotelData['roomTwin']." TWIN ,"; }
				if($finalHotelData['roomEBedA'] > 0){ $rooms .= $finalHotelData['roomEBedA']." EBed(A) ,"; }
				if($finalHotelData['roomEBedC'] > 0){ $rooms .= $quotationData['roomEBedC']." CWBed ,"; }
				if($quotationData['roomENBedC'] > 0){ $rooms.= $finalHotelData['roomENBedC']." CNBed ,"; }
				if($quotationData['sixNoofBedRoom'] > 0){ $rooms .= $finalHotelData['sixNoofBedRoom']." SixBed, "; }
				if($finalHotelData['eightNoofBedRoom'] > 0){ $rooms .= $finalHotelData['eightNoofBedRoom']." EightBed, "; }
				if($finalHotelData['tenNoofBedRoom'] > 0){ $rooms .= $finalHotelData['tenNoofBedRoom']." TenBed, "; }
				if($finalHotelData['quadNoofRoom'] > 0){ $rooms .= $finalHotelData['quadNoofRoom']." Quad, "; }
				if($finalHotelData['teenNoofRoom'] > 0){ $rooms .= $finalHotelData['teenNoofRoom']." Teen, "; }

				$rooms = rtrim($rooms,' ,');
				$noOfRooms = $quotationData['sglRoom']+$quotationData['dblRoom']+$quotationData['tplRoom']+$quotationData['twinRoom'];
				
				$g="";
				$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$finalHotelData['roomType'].'"'); 
				$roomTypeData=mysqli_fetch_array($g);
				$rType=$roomTypeData['name'];
				
				$g="";
				$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$finalHotelData['mealPlanId'].'"'); 
				$mealData=mysqli_fetch_array($g);
				//.'-'.$mealData['subname'] 
				$mealplan = $mealData['name'];
				 
				$CheckIn = "Check In :".date('d M Y',strtotime($fromDate));
				$CheckOut = " Check Out :".date('d M Y',strtotime($toDate));
				$date1 = new DateTime($fromDate);
				$date2 = new DateTime($toDate);
				$interval = $date1->diff($date2);
				$nights = $interval->days;   
				
				$confNO  = $finalHotelData['confirmationNo'];
				
				// add or update voucher details
				$voucherQuery="";
				$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusData['id'].'" and serviceType="hotel" and serviceId="'.$FID.'" and quotationId="'.$quotationId.'"'); 
				if(mysqli_num_rows($voucherQuery)<1){
					$namevalue ='quotationId="'.$quotationId.'",supplierStatusId="'.$supplierStatusData['id'].'",serviceType="hotel",serviceId="'.$FID.'"';
					$voucherId = addlistinggetlastid('voucherDetailsMaster',$namevalue);
				} else{
					$voucherDetailData = mysqli_fetch_array($voucherQuery);
					$voucherId  = $voucherDetailData['id'];	
					$voucherDate2  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
				} 
				$showVocherNum = generateVoucherNumber($voucherId,$_REQUEST['module'],strtotime($fromDate));
				
				$vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
			$suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);



			$isShowSupCont = 0;
			$suppVoucherNoteText = $suppvoucherNotes['supplierVoucherNoteText'];
			$suppbillingInstructionText = $suppvoucherNotes['supplierbillingInstructionText'];
			$isShowSupCont = $suppvoucherNotes['supplierStatus'];
				
	 		?>
			<div class="sub-container" style="border:1px dashed #ddd;padding:10px;font-size: 12px;" id="mailSectionArea<?php echo $suppStatusId_cnt;?>">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td> 
				<!--logo block-->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:700px;height:100px; margin: 0 auto;" /></td></tr>
				</table>
				<br>
			
				<!--address block-->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td width="70%" valign="top"><table>
								<tr>
									<td colspan="3" align="left" style="font-size: 16px;">
										<strong>To:&nbsp;<?php echo strip($supplierAliasName); ?></strong>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="left">
										<strong>Address&nbsp;:&nbsp;</strong><?php echo strip($supplierAddData['address']); ?>
									</td>
								</tr>
								<?php if($isShowSupCont == 1){ ?>
								<tr>
									<td align="left" width="30%;">
										<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo strip($resListing['contactPerson']); ?> 
									</td>
									<td align="left" width="30%;">
										<strong>Phone&nbsp;:&nbsp;</strong><?php  echo decode($resListing['phone']); ?> 
									</td>
									<td align="left" width="40%;">
										<strong>Email&nbsp;:&nbsp;</strong><?php  echo decode($resListing['email']); ?>
									</td>
								</tr>
								<?php } ?>
								<!--In favour of:--> 
								<tr class="removeEle3" >
									<td align="left" width="30%;"><strong>In&nbsp;favour&nbsp;of&nbsp;:&nbsp;</strong></td>
									<td align="left" width="30%;"><input name="otherGuestName" type="text" id="otherGuestName<?php echo $suppStatusId_cnt;?>" placeholder="Pax Name" style="width:140px; border:1px solid #ccc; padding:3px; font-size:12px;" /></td>
									<td align="left" width="40%;"><div style="width: fit-content;cursor: pointer;padding: 3px 10px;background-color: #009e67;color: #fff;font-size: 13px;" onclick="addotherGuest('<?php echo $suppStatusId_cnt;?>');">+ Add Other Pax</div></td>
								</tr>
								<tr>
									<td align="left" width="30%;"><strong>Other&nbsp;Pax&nbsp;Details</strong></td>
									<td colspan="2" align="left" id="addotherGuest<?php echo $suppStatusId_cnt;?>" ></td>
								</tr>
							</table>
							<script type="text/javascript">
								function addotherGuest(id) {
									var otherGuestName = encodeURI($('#otherGuestName' + id).val());
									$('#addotherGuest' + id).load('loadaddotherGuest.php?action=saveotherGuest&otherGuestName=' + otherGuestName + '&quotationId=<?php echo $quotationId; ?>&supplierStatusId=' + id);
									$('#otherGuestName' + id).val('');
								}
								
								
								function loadotherGuest(id) {
									$('#addotherGuest' + id).load('loadaddotherGuest.php?quotationId=<?php echo $quotationId; ?>&supplierStatusId=' + id);
								}
								
								
								function delother(id, supplierStatusId) { 
									$('#addotherGuest' + supplierStatusId).load('loadaddotherGuest.php?action=deleteotherGuest&delId=' + id +'&quotationId=<?php echo $quotationId; ?>&supplierStatusId=' + supplierStatusId);
								
								}
								
								loadotherGuest('<?php echo $suppStatusId_cnt;?>');
							</script>
						</td>
						<td width="30%" valign="top">
							<table>
								<tr>
									<td  align="left">
										<strong>Tour&nbsp;ID&nbsp;:&nbsp;</strong><?php echo $tourId; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;No&nbsp;:&nbsp;</strong><?php echo $showVocherNum; ?>
										<input type="hidden" id="voucherNumber<?php echo $suppStatusId_cnt;?>" placeholder="Voucher No" value="<?php echo $showVocherNum; ?>" />
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;Date&nbsp;:&nbsp;</strong><?php 
										if($voucherDate2!='1970-01-01 00:00:00' && $voucherDate2!='0000-00-00 00:00:00' && $voucherDate2!=''){ 
											echo date('d/m/Y', strtotime($voucherDate2)); 
										}else{ 
											echo date('d/m/Y',strtotime($fromDate)); 
										} ?>
										<input id="voucherDate<?php echo $suppStatusId_cnt;?>" type="hidden" class="gridfield calfieldicon"  placeholder="Voucher Date " value="<?php if($voucherDate2!='1970-01-01 00:00:00' && $voucherDate2!='0000-00-00 00:00:00' && $voucherDate2!=''){ echo date('Y-m-d', strtotime($voucherDate2)); }else{ echo date('Y-m-d',strtotime($fromDate)); } ?>"  /> 
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $totalPax; ?>
									</td>
								</tr> 
								<tr>
									<td  align="left">
										<strong>Booking No&nbsp;:&nbsp;</strong><?php echo $bookingId; ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<br> 
				<!-- Services Date -->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr> 
						<td width="34%"><strong>Services:</strong></td>
						<td width="85%"><strong>Please provide the services as per the following.</strong></td> 
					</tr>
				</table> 
				<!-- Service date wise list -->
				<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4"> 
				 	<tr> 
						<td bgcolor="#F3F3F3" width="5%" align="center" rowspan="5"><?php echo 1; ?></td> 
						<td bgcolor="#F3F3F3" width="29%"><b><?php echo strip($hotelData['hotelName']);  ?></b></td>  
						<td bgcolor="#F3F3F3"><b><?php echo $CheckIn;?></b></td> 
						<td bgcolor="#F3F3F3"><b><?php echo $CheckOut; ?></b></td>
						<td bgcolor="#F3F3F3"><b><?php echo $nights." Night(s)"; ?></b></td>   
					</tr>
					<tr> 
					<td ><?php echo "Confirmation Number" ?></td>
					<td colspan="4"><strong><?php echo $confNO; ?></strong></td> 
					</tr>
					
					<?php  
					// group by roomType,mealPlanId 
					$g2="";
					$g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and  hotelId="'.$hotelId.'" and  supplierId="'.$supplierStatusData['supplierId'].'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" order by fromDate asc'); 
					if(mysqli_num_rows($g2)>0){ 
						while($quotMealData=mysqli_fetch_array($g2)){ 
							
							
							// $g="";
							// $g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotMealData['roomType'].'"'); 
							// $roomTypeData=mysqli_fetch_array($g);
							// $rType=$roomTypeData['name'];
							
							// $g="";
							// $g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotMealData['mealPlanId'].'"'); 
							// $mealData=mysqli_fetch_array($g);
							// //.'-'.$mealData['subname']						
							// $mealplan = $mealData['name'];
							?>
							<tr>
	 							<td colspan="5">
								<table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size:13px;">
								<tr  bgcolor="#cccccc"> 
									<th  align="center"><strong>Date</strong></th>
									<th  align="center" style="min-width:400px;"><strong>Room Type/No.Rooms </strong></th>
									<th  align="center"><strong>Meal Plan</strong></th> 
								</tr>
								<tr>
									<td  align="center" width="30%"><?php echo date('d M',strtotime($quotMealData['fromDate']))." - ".date('d M Y',strtotime($quotMealData['toDate']) + 86400); ?></td>  
									<td align="center" width="29%">&nbsp;&nbsp;<?php echo $rType.'/ '.$rooms ;?></td> 
									<td align="center" ><?php echo $mealplan; if($quotMealData['lunch']>0 && $quotMealData['complimentaryLunch']==1){ echo ", Lunch"; } if($quotMealData['dinner']>0 && $quotMealData['complimentaryDinner']==1){echo ", Dinner"; } if($quotMealData['breakfast']>0 && $quotMealData['complimentaryBreakfast']==1){echo ", Breakfast"; } ?></td>
								</tr>
							</table></td></tr> 
							<?php
						}
						$rs12='';
						$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$finalHotelData['hotelQuotationId'].'" and quotationId="'.$finalHotelData['quotationId'].'" '); 
						while ($editresult2=mysqli_fetch_array($rs12)) {
							$rtype  .= $editresult2['name'].', ';
						}
						?>
						<tr> 
							<td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
							<tr>
								<td width="20%"><b>Hotel Additionals: </b></td>  
								<td width="80%"><?php echo rtrim($rtype,', '); ?></td> 
							</tr>
							</table></td>
						</tr> 
						<?php
					}
					?>
					
					<!-- end of the services loop from final tables -->
				</table>
				<br> 
				<style type="text/css">
					
					@media print
					{    
					    .removeEle{
					        display: none !important;
					    }
						.removeEle3{
							display: none !important;
						}
						#clearTextid{
							display: none !important;
						}
						#clearTextidhotel{
							display: none !important;
						}
						#showADtime2{
							display: none !important;
						}
						#showADtime{
							display: none !important;
						}
						#notetexT{
							display: none !important;
						}
						#printNotText{
							display: block !important;
						}
						#billingIntructId{
							display: none !important;
						}
						#billingIntructtextId{
							display: block !important;
						}
					}
				</style>
				<!-- Arrival Departure for hotel and transfer-->
				<button onclick="showHideArrDepBox('<?php echo $voucherDetailData['id']; ?>','<?php echo $voucherDetailData['ArrivalDepartureStatus'] ?>','<?php echo $suppStatusId_cnt; ?>')" class="removeEle2" id="showADtime2"><?php if ($voucherDetailData['ArrivalDepartureStatus']==1) { echo 'Show'; }else{ echo "Hide";} ?>  Arrival/Departure Time </button>
 
				<table  border="0" borderColor="#ccc" cellpadding="4" cellspacing="0" id="myDiv<?php echo $suppStatusId_cnt; ?>" class="showhidArr<?php echo $suppStatusId_cnt; ?> <?php if ($voucherDetailData['ArrivalDepartureStatus']==1){ echo 'hideArrival'; } ?>" >
					<tr>
						<td align="left" valign="middle" width="15%">
							<strong>Arrival On </strong>
						</td>
						<td align="left" valign="middle"  >
							<input id="h_arrival_on<?php echo $suppStatusId_cnt;?>" type="date" class="calfieldicon" style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00' && $voucherDetailData['h_arrival_on']!=''){ echo date('Y-m-d',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("Y-m-d", strtotime($fromDate)); }   ?>" placeholder="Arrival On"/> 
						</td>
						<td align="left" valign="middle"  >&nbsp;</td>
						<td align="left" valign="middle"  >
							<strong>From</strong>
						</td>
						<td align="left" valign="middle"  >
							<input type="text" id="h_from<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_from']); ?>" placeholder="City"/> 
						</td>
						<td align="left" valign="middle"  >&nbsp;</td>
						<td align="left" valign="middle"  >
							<strong>By </strong>
						</td>
						<td align="left" valign="middle"  >
							<input type="text" id="h_by_from<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_by_from']); ?>" placeholder="Number"//> 
						</td>
						<td align="left" valign="middle"  >&nbsp;</td>
						<td align="left" valign="middle"  >
							<strong>At </strong>
						</td>
						<td align="left" valign="middle"  >
							<input type="text" id="h_at_from<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>" class="timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="15" data-min-time="12:00" data-max-time="11:59" data-show-2400="true"/> 
						</td> 
					</tr>
					<tr>
						<td align="left" valign="middle">
							<strong>Departure On </strong>
						</td>
						<td align="left" valign="middle">
							<input type="date" id="h_departure_on<?php echo $suppStatusId_cnt;?>" class="calfieldicon"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00' && $voucherDetailData['h_departure_on']!=''){ echo date('Y-m-d',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("Y-m-d", strtotime($toDate));}   ?>" placeholder="Departure On"/> 
						</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">
							<strong>To </strong>
						</td>
						<td align="left" valign="middle">
							<input type="text" id="h_to<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_to']); ?>" placeholder="City"//> 
						</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">
							<strong>By </strong>
						</td>
						<td align="left" valign="middle">
							<input type="text" id="h_by_to<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_by_to']); ?>" placeholder="Number"//> 
						</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">
							<strong>At </strong>
						</td>
						<td align="left" valign="middle">
							<input type="text" id="h_at_to<?php echo $suppStatusId_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>" class="timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="15" data-min-time="12:00" data-max-time="11:59" data-show-2400="true"/> 
						</td>
					</tr>
					<tr align="left" valign="top">
						<td colspan="11">&nbsp;</td>
					</tr>
				</table> 
				<!-- Notes and Billing INstructions --> 
				<table border="0" cellpadding="4" cellspacing="0" width="100%">
					<tr align="left" valign="top">
						<td colspan="3">
							<div class="griddiv" id="notetexT">
								<label>
									<strong>Notes</strong><br>
									<textarea id="voucherNotes<?php echo $suppStatusId_cnt;?>" style="width:100%;border: 1px solid #ccc;"  class="gridfield" ><?php if(!empty($voucherDetailData['voucherNotes'])){ echo strip($voucherDetailData['voucherNotes']); }else{ 
											echo $suppVoucherNoteText ; 
										} ?></textarea>
								</label>
							</div>

							<div id="printNotText" style="display: none;">
							<label for="Notes"><strong>Notes</strong></label><br>
								<?php echo nl2br(strip($voucherDetailData['voucherNotes'])) ?>
									
							</div>
						</td>
					</tr>
					<tr align="left" valign="top">
						<td colspan="3">
							<div class="griddiv" id="billingIntructId">
								<label>
									<strong>Billing Instructions&nbsp;&nbsp;<span id="clearTextidhotel"><input type="checkbox" value="0" onclick="billInstYes('<?php echo $suppStatusId_cnt;?>')" id="billInstYes<?php echo $suppStatusId_cnt;?>" style="display: inline-block;" <?php if($voucherDetailData['billInstYes']==0){ ?> checked<?php } ?> >&nbsp;Clear&nbsp;TextArea</span></strong><br>
									<textarea id="billingInstructions<?php echo $suppStatusId_cnt;?>" style="width:100%;border: 1px solid #ccc;" class="gridfield"><?php if(!empty($voucherDetailData['billingInstructions']) or $voucherDetailData['billInstYes']==0){ echo strip($voucherDetailData['billingInstructions']); }else{ echo $suppbillingInstructionText ; } ?></textarea>
								</label>
							</div>

							<div id="billingIntructtextId" style="display: none;">
							<label for="Notes"><strong>Billing Instructions</strong></label><br>
								<?php echo nl2br(strip($voucherDetailData['billingInstructions'])) ?>	
							</div>
						</td>
					</tr>
				</table>  
				</td>
				</tr>
			</table>
			</div>
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
					<tr>
						<td colspan="2" align="left">
							<input type="button" value="Save Changes" style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="saveChanges('<?php echo $suppStatusId_cnt; ?>')"  />  
							<input type="hidden" id="quotationId<?php echo $suppStatusId_cnt;?>" value="<?php echo $quotationId; ?>" />
							<input type="hidden" id="supplierStatusId<?php echo $suppStatusId_cnt;?>" value="<?php echo $supplierStatusData['id']; ?>" /> 
	 						<input type="hidden" id="voucherDetailId<?php echo $suppStatusId_cnt;?>" value="<?php echo strip($voucherId); ?>" /> 
						</td>
						<td width="50%" align="right">
							<?php 
							$voucherString=trim($supplierStatusData['id']).'_'.$FID.'_hotel_'.trim($_REQUEST['module']).'_'.trim($quotationId).'_1'; 
							?>
							<a href="showpage.crm?module=query&view=yes&supplier=1&supplierId=<?php echo encode($supplierStatusData['supplierId']); ?>&quotationId=<?php echo encode($quotationId); ?>&id=<?php echo encode($queryId); ?>&voucherString=<?php echo $voucherString; ?>" target="_blank" style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF!important;border-radius: 2px;">Send</a>&nbsp;&nbsp; 
							<input type="button"value="Print"  style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF;border-radius: 2px;" onclick="printDiv('mailSectionArea<?php echo $suppStatusId_cnt; ?>')" class="a" /> 
						
						</td> 
					</tr>
		</table>
			
			<br>
			<?php
			$cnt1++;		 
			}
		}
	}
	?>  
	<!-- end of the all blocks -->
	<?php
	
} //endofloop
} 
?>   
<script>

function showHideArrDepBox(Vid,ArrivalDepartureStatus,sr){
	if (ArrivalDepartureStatus!= ''){
		$('#actionBox').load('final_frmaction.php?action=visibleArrivalDepartureTime&voucherId='+Vid+'&ArrivalDepartureStatus='+ArrivalDepartureStatus);
	}

	var hsclass =  $("#myDiv"+sr).hasClass("hideArrival");
	if(hsclass==true){
		$(".showhidArr"+sr).removeClass('hideArrival');
	}else{
		$(".showhidArr"+sr).addClass('hideArrival');
	}

}

function billInstYes(ID) {
	var checkBox = document.getElementById('billInstYes'+ID); 
	if(checkBox.checked == true){
	    $('#billingInstructions'+ID).val('');
	    $('#billingInstructions'+ID).html('');
	} else {
	    $('#billingInstructions'+ID).val('Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.');
	    $('#billingInstructions'+ID).html('Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.');
	}
}
 
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    // Create a new window
    var printWindow = window.open('', '_blank');
    // Add styles with white background and 20px margin to the printed content
    var style = '<style media="print">body { background-color: white; margin: 30px; } input, textarea {font-family: "Roboto", sans-serif;}table{border-collapse: collapse; }.main-container input[type=text],.main-container input[type=date]{width:88%;}.main-container input[type=text],.main-container input[type=date], .main-container textarea{border: 1px solid;border-color: #ccc;padding: 6px;font-size: 13px;outline: none;}.w100{ width: 97% !important; }.hidediv{display: none !important;}.saveBtn{display: inline-block;font-size: 14px!important;cursor: pointer;padding: 5px 7px;border: 1px solid #c5c0c0;border-radius: 1px;}.blueBtn{color: #ffffff!important;background-color: #007bff!important;}.whiteBtn{color: #212529!important;background-color: #f8f9fa!important;}.grnBtn{color: #ffffff!important;background-color: #28a745!important;}.blackBtn{color: #fff!important;background-color: #343a40!important;border-color: #343a40!important;}.bill_cls{height: 50px !important;}</style>';

    // Set the content of the new window with the styles and the original content
    printWindow.document.write(style + printContents);
    // Close the document stream to ensure proper rendering
    printWindow.document.close();
    // Print the content
    printWindow.print();
    // Close the new window after printing
    printWindow.close();
    // Reload the parent location
    parent.location.reload();
    // return false;
}
	
function saveChanges(boxId) { 

	var h_arrival_on = document.getElementById('h_arrival_on' + boxId).value;
	var h_from = document.getElementById('h_from' + boxId).value;
	var h_by_from = document.getElementById('h_by_from' + boxId).value;
	var h_at_from = document.getElementById('h_at_from' + boxId).value;
	
	var h_departure_on = document.getElementById('h_departure_on' + boxId).value;
	var h_to = document.getElementById('h_to' + boxId).value;
	var h_by_to = document.getElementById('h_by_to' + boxId).value; 
	var h_at_to = document.getElementById('h_at_to' + boxId).value;
	 
	var supplierStatusId = document.getElementById('supplierStatusId' + boxId).value;
	
	var voucherNo = document.getElementById('voucherNumber' + boxId).value;
	var voucherDate = document.getElementById('voucherDate' + boxId).value;
	var voucherNotes = document.getElementById('voucherNotes' + boxId).value;
	var billingInstructions = document.getElementById('billingInstructions' + boxId).value;
	var billInstYes = document.getElementById('billInstYes' + boxId);
	if (billInstYes.checked == true){
	    billInstYes = 0;
	} else {
	    billInstYes = 1;
	}
	
	var id = document.getElementById('voucherDetailId' + boxId).value;

	$('#actionBox').load('final_frmaction.php?action=saveVoucherArrivalDeparture_client&h_arrival_on=' + encodeURI(h_arrival_on) + '&h_from=' + encodeURI(h_from) + '&h_by_from=' + encodeURI(h_by_from) + '&h_at_from=' + encodeURI(h_at_from) + '&h_departure_on=' + encodeURI(h_departure_on) + '&h_to=' + encodeURI(h_to) + '&h_by_to=' + encodeURI(h_by_to) + '&h_at_to=' + encodeURI(h_at_to) + '&voucherNotes=' + encodeURI(voucherNotes) + '&billingInstructions=' + encodeURI(billingInstructions) + '&billInstYes=' + encodeURI(billInstYes) + '&supplierStatusId=' + encodeURI(supplierStatusId) + '&id=' + encodeURI(id) + '&voucherDate=' + encodeURI(voucherDate) + '&voucherNo=' + encodeURI(voucherNo) + '&quotationId=<?php echo $quotationId; ?>'); 
	
}


    </script>
	<div style="display:none" id="actionBox"></div>
	<script type="text/javascript" src="js/jquery.timepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.timepicker2').timepicker();
		});   
	</script>
	
	<!--only use for check in time-->
</div> 
</div>

<style>
	.hideArrival{
		display: none !important;
	}
</style>