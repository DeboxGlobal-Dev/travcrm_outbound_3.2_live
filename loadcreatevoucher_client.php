<?php
include "inc.php";
//quotation data
$unconfirmedTable='yes';
$showHide=0;
$in=0;
$in2=0;
$rs=''; 
$rs=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'" and status=1 '); 
$quotationData=mysqli_fetch_array($rs);
$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$totalPax = ($quotationData['adult']+$quotationData['child']+$quotationData['infant']);

$costType = $quotationData['costType'];
$discountType= $quotationData['discountType'];
$discountTax = $quotationData['discount'];

//slab Date

$slabSql="";
$slabSql=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'"  and status=1'); 
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
	<!-- Unconfirmed Services -->
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
    		 	?>
    			
    			<tr>
    				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
    				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
    				<td><?php echo $transferType.$vehicleType.$vehicleName.$entranceDData['entranceName']; ?></td>
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

			if($finalQuoteActivity['transferType'] == 1){
				$transferType = 'SIC';
			 }elseif($finalQuoteActivity['transferType'] == 2){
				$transferType = 'PVT';
			 }if($finalQuoteActivity['transferType'] == 3){
				$transferType = 'VIP';
			 }

			?>
			
			<tr>
				<td><?php echo date('d-m-Y',strtotime($unConfirmedD['startDate'])); ?></td>
				<td><?php echo ucfirst($unConfirmedD['serviceType']); ?></td>
				<td><?php echo $transferType.' | '. $activityDData['otherActivityName']; ?></td>
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
				<td><?php echo $transferType.$vehicleType.$vehicleName.$transferData['transferName']; ?></td>
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
<!-- Unconfirm Services End -->


<div class="main-container" style="padding: 40px;background-color: #fff;width: 800px;">
<?php  
if ($_REQUEST['module']=='ClientVoucher'){
	$dq=GetPageRecord('*',_QUERY_MASTER_,' id="'.$resultpage['id'].'" order by id desc');  
	$queryData=mysqli_fetch_array($dq);

	if($queryData['clientType']=='1'){
		$ad=GetPageRecord('*',_CORPORATE_MASTER_,' id="'.$queryData['companyId'].'" order by id desc');  
		$suppData=mysqli_fetch_array($ad);

		$rsss=GetPageRecord('*','contactPersonMaster',' corporateId="'.$suppData['id'].'" and contactPerson!="" and deletestatus=0 order by id asc'); 
		$resListing=mysqli_fetch_array($rsss);
		$suppagentPone = decode($resListing['phone']);
		$suppagentEmail = decode($resListing['email']);

		$rssupad=GetPageRecord('*','addressMaster',' addressParent="'.$suppData['id'].'" and addressType="corporate" order by id asc'); 
		$supplierAddData=mysqli_fetch_array($rssupad);
	}
	if($queryData['clientType']=='2'){
		$ad=GetPageRecord('*',_CONTACT_MASTER_,' id="'.$queryData['companyId'].'" order by id desc');  
		$suppData=mysqli_fetch_array($ad);
		$suppData['name'] = ($suppData['firstName'].' '.$suppData['lastName']);
		$supplierAddData['address'] = $suppData['addressInfo'];
		$resListing['contactPerson'] = $suppData['name'];
		$rsss=GetPageRecord('*',_PHONE_MASTER_,' masterId="'.$suppData['id'].'" and sectionType="contacts" '); 
		$resListingp=mysqli_fetch_array($rsss);
		
		$suppagentPone = $resListingp['phoneNo'];

		$rssupad=GetPageRecord('*',_EMAIL_MASTER_,' masterId="'.$suppData['id'].'" and sectionType="contacts" '); 
		$emailData=mysqli_fetch_array($rssupad);
		$suppagentEmail = $emailData['email'];
		$supplierAddData['gstn'] = '';
	} 
} 
// for hotel only  
$dateSets = getHotelDateSets($quotationId,0);
$dateSetArray = explode('~',$dateSets);
//print_r($dateSetArray); 
$cnt1 = 1;
if(strlen($dateSets) > 0){ 
	foreach($dateSetArray as $dateSet){
		
		
		$dateSetData = explode('^',$dateSet);
		$hotelId = $dateSetData[0];
		$fromDate = $dateSetData[1];
		$toDate = $dateSetData[2];
		$FID = $dateSetData[3];

		$supplierStatusId = $FID; // IMP TO REMEMBER
		$clientVoucher_cnt = strip($supplierStatusId."_".$cnt1);
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
			$g=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'id="'.$finalHotelData['hotelQuotationId'].'"'); 
			$quotationHotelData=mysqli_fetch_array($g);	
			
			$g="";
			$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotationHotelData['roomType'].'"'); 
			$roomTypeData=mysqli_fetch_array($g);
			$rType=$roomTypeData['name'];
			
			$g="";
			$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotationHotelData['mealPlan'].'"'); 
			$mealData=mysqli_fetch_array($g); 
			//.'-'.$mealData['subname']
			$mealplan = $mealData['name'];

			$hotcpm = GetPageRecord('*','hotelContactPersonMaster','corporateId="'.$hotelData['id'].'" and division=3');
			$hotelcpmData=mysqli_fetch_assoc($hotcpm);

			 
			$CheckIn = "CheckIn :".date('d M Y',strtotime($fromDate));
			$CheckOut = " CheckOut :".date('d M Y',strtotime($toDate));
			$date1 = new DateTime($fromDate);
			$date2 = new DateTime($toDate);
			$interval = $date1->diff($date2);
			$nights = $interval->days;   
			
			$confNO  = $finalHotelData['confirmationNo'];
			// add or update voucher details
			$voucherQuery="";
			$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusId.'" and serviceType="hotel" and serviceId="'.$FID.'" and quotationId="'.$quotationId.'"'); 
			if(mysqli_num_rows($voucherQuery)<1){
				$namevalue ='quotationId="'.$quotationId.'",supplierStatusId="'.$supplierStatusId.'",serviceType="hotel",serviceId="'.$FID.'"';
				$voucherId = addlistinggetlastid('voucherDetailsMaster',$namevalue);
			} else{
				$voucherDetailData = mysqli_fetch_array($voucherQuery);
				$voucherId  = $voucherDetailData['id'];	
				$supplierStatusId  = $voucherDetailData['supplierStatusId'];	
				$voucherDate2  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
			} 
			$showVocherNum = generateVoucherNumber($voucherId,$_REQUEST['module'],strtotime($fromDate));
			$vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
			$suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);
			$isShowClientCont = 0;
			$isShowClientCont = $suppvoucherNotes['clientStatus'];

			$clientVoucherNoteText = $suppvoucherNotes['clientVoucherNoteText'];
			$clientbillingInstructionText = $suppvoucherNotes['clientbillingInstructionText'];	
			
			?>
			<div class="sub-container" style="border:1px dashed #ddd;padding:10px;max-width: 800px;"  id="mailSectionArea<?php echo $clientVoucher_cnt;?>">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td> 
				<!--logo block-->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px; margin: 0 auto;" /></td></tr>
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
										<a href="">
											<strong>
												<?php echo strip($suppData['name'] ); ?>
											</strong>
										</a>
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Address&nbsp;:&nbsp;</strong>
										<?php echo strip($supplierAddData['address']); ?>
									</td>
								</tr>
								<?php if($isShowClientCont == 1){ ?>
								<tr>
									<td align="left">
										<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong>
										<?php echo strip($resListing['contactPerson']); ?> </td>
								</tr>
								<tr>
									<td align="left">
										<strong>Phone&nbsp;:&nbsp;</strong>
										<?php echo $suppagentPone ; ?>
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Email&nbsp;:&nbsp;</strong>
										<?php echo $suppagentEmail ; ?> </td>
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
										<strong>Agent Name&nbsp;:&nbsp;</strong>
										<?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td align="left">
										<strong>Total&nbsp;Pax:&nbsp;</strong>
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
						<td width="34%">
							<strong>Voucher&nbsp;No. </strong>
						</td>
						<td width="33%">
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
						<td>
						<input type="text" id="voucherNumber<?php echo $clientVoucher_cnt;?>" placeholder="Voucher No" onchange="savevoucherDetails<?php echo $clientVoucher_cnt;?>();" value="<?php echo $showVocherNum; ?>" style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" />
						</td> 
						<td>
							<input  id="voucherDate<?php echo $clientVoucher_cnt;?>" type="date" class="gridfield calfieldicon"  placeholder="Voucher Date " value="<?php if($voucherDate2!='1970-01-01 00:00:00' && $voucherDate2!='0000-00-00 00:00:00' && $voucherDate2!=''){ echo date('Y-m-d', strtotime($voucherDate2)); }else{ echo date('Y-m-d',strtotime($fromDate)); } ?>" style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" /> 
						</td> 
						<td>
							<input 
							name="voucherReferanceNumber" 
							type="text" 
							id="voucherReferanceNumber<?php echo $clientVoucher_cnt;?>" 
							onchange="savevoucherDetails<?php echo $clientVoucher_cnt;?>();"  
							placeholder="Reference No " 
							value="<?php echo $resultpage['referanceNumber']; ?>" 
							style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" /> 
						</td> 
						 
						<div id="savevoucherDetails<?php echo $clientVoucher_cnt;?>"  style=" display:none;" >
						</div>
					</tr>
				</table>
				<br>
				<!--In favour of:--> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr> 
						<td width="34%"><strong>In favour of:</strong></td>
						<td width="33%"><?php echo $leadPaxName; ?></td>
						<td ><?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; }if($quotationData['infant']>0){ echo ', '.$quotationData['infant']." Infant(s)"; } ?></td>
					</tr>
				</table>
				
				<!--In favour of:-->
				<!-- <table width="100%" border="0" cellpadding="0" cellspacing="0" >
				   <tr>
					  <td width="34%"><strong>Lead&nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</strong></td>
					  <td width="33%"><input name="guest<?php echo $clientVoucher_cnt;?>" type="text" id="guest<?php echo $clientVoucher_cnt;?>" placeholder="Lead Pax Name" value="<?php echo strip($resultpage['leadPaxName']);  ?>" style="width:140px; border:1px solid #fff; padding:3px; font-size:12px;" /></td>
					  <td >&nbsp;</td>
				   </tr>
				</table> -->
				<br>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="removeEle" id="otherPaxId">
				   <tr>
					  <!-- <td width="34%"><strong>Other Pax Details </strong>:</td> -->
					  <td width="20%"><input name="otherGuestName" type="text" id="otherGuestName<?php echo $clientVoucher_cnt;?>" placeholder="Pax Name" value="" style="width:140px; border:1px solid #ccc; padding:3px; font-size:12px;" /></td>
					  <td>
						 <div style="width: fit-content;cursor: pointer;padding: 3px 10px;background-color: #009e67;color: #fff;font-size: 13px;" onclick="addotherGuest('<?php echo $clientVoucher_cnt;?>');">+ Add Other Pax</div>
					  </td>
				   </tr>
				</table>
				<div id="addotherGuest<?php echo $clientVoucher_cnt;?>">&nbsp;</div>
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
					
					loadotherGuest('<?php echo $clientVoucher_cnt;?>');
				</script>
				<br>
				
					<!-- Hotel Information -->
					<div style="width: 100%;">
					<div style="padding-bottom:5px;"><strong>
						<?php echo $hotelData['hotelName']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php
						$ppres = GetPageRecord('*','proposalSettingMaster','proposalNum=6');
						$starcolor = mysqli_fetch_assoc($ppres);

						$cres = GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"');
						$catres = mysqli_fetch_assoc($cres);
						$hotelStar = $catres['hotelCategory'];
							 for($i=1; $i<=$hotelStar; $i++ ){
								?>
								<i style="font-size: 16px;vertical-align:bottom; color:<?php if($starcolor['proposalColor']!=''){ echo $starcolor['proposalColor']; }else{ echo '#dcff2e'; } ?>;" class="fa fa-star" aria-hidden="true"></i>
								<?php
							 } ?>
							 </strong>
						</div>
						
						<div style="width:8%; display:inline-block;padding-bottom:5px;"><strong>Address:</strong></div>
							<div style="width:91%; display:inline-block;"><?php echo $hotelData['hotelAddress']; ?></div>
							<div style="width:11%; display:inline-block;padding-bottom:5px;"><strong> Website URL:</strong></div>
							<div style="width:88%; display:inline-block;"><?php echo $hotelData['url']; ?></div>
						
							<div style="width:13%; display:inline-block;padding-bottom:10px;"><strong> Contact Person:</strong></div>
							<div style="width:28%; display:inline-block;"><?php echo $hotelcpmData['contactPerson']; ?></div>
							<div style="width:6%; display:inline-block;"><strong>Phone:</strong></div>
							<div style="width:16%; display:inline-block;"><?php echo $hotelcpmData['phone']; ?></div>
							<div style="width:6%; display:inline-block;"><strong>E-mail:</strong></div>
							<div style="width:28%; display:inline-block;"><?php echo $hotelcpmData['email']; ?></div>
					</div>
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
						<td bgcolor="#F3F3F3" width="5%" align="center" rowspan="3"><?php echo 1; ?></td> 
						<td bgcolor="#F3F3F3" width="29%"><b><?php echo strip($hotelData['hotelName']); ?></b></td>  
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
					$g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and  hotelId="'.$hotelId.'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" order by fromDate asc'); 
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
									<th  align="center" style="min-width:400px;"><strong>Room Type</strong></th>
									<th  align="center"><strong>Meal Plan</strong></th> 
								</tr>
								<tr>
									<td  align="center" width="30%"><?php echo date('d M',strtotime($quotMealData['fromDate']))." - ".date('d M Y',strtotime($quotMealData['toDate']) + 86400); ?></td>  
									<td  align="center" width="29%">&nbsp;&nbsp;<?php echo $rType.'/ '.$rooms ;?></td>
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
					@media print{    
					    .removeEle{
					        display: none !important;
					    }
						#notetexT{
							display: none !important;
						}
						#printNotText{
							display: block !important;
						}
						#billingIntructId{
							display: block !important;
						}
						#billingIntructtextId{
							display: block !important;
						}
					
					}
				</style>
				<!-- Arrival Departure for hotel and transfer--> 
				<button onclick="showHideArrDepBox('<?php echo $voucherId ?>','<?php echo $voucherDetailData['ArrivalDepartureStatus'] ?>','<?php echo $clientVoucher_cnt; ?>')" class="removeEle" id="showADtime2"><?php if ($voucherDetailData['ArrivalDepartureStatus']==1) { echo 'Show'; }else{ echo "Hide";} ?> Arrival/Departure Time</button>
				<table  border="1" borderColor="#ccc" cellpadding="4" cellspacing="0" id="ArrivalDepartureDiv<?php echo $clientVoucher_cnt; ?>" class="showhidArr<?php echo $clientVoucher_cnt; ?> <?php if ($voucherDetailData['ArrivalDepartureStatus']==1){ echo 'hideArrival'; } ?>" >
					<tr>
						<td align="left" valign="middle" width="15%">
							<strong>Arrival On </strong>
						</td>
						<td align="left" valign="middle"  >
							<input id="h_arrival_on<?php echo $clientVoucher_cnt;?>" type="date" class="calfieldicon" style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00' && $voucherDetailData['h_arrival_on']!=''){ echo date('Y-m-d',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("Y-m-d", strtotime($fromDate)); }   ?>" placeholder="Arrival On"/> 
						</td>
						<td align="left" valign="middle"  >&nbsp;</td>
						<td align="left" valign="middle"  >
							<strong>From</strong>
						</td>
						<td align="left" valign="middle"  >
							<input type="text" id="h_from<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_from']); ?>" placeholder="City"/> 
						</td>
						<td align="left" valign="middle"  >&nbsp;</td>
						<td align="left" valign="middle"  >
							<strong>By </strong>
						</td>
						<td align="left" valign="middle"  >
							<input type="text" id="h_by_from<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_by_from']); ?>" placeholder="Number"//> 
						</td>
						<td align="left" valign="middle"  >&nbsp;</td>
						<td align="left" valign="middle"  >
							<strong>At </strong>
						</td>
						<td align="left" valign="middle"  >
							<input type="text" id="h_at_from<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>" class="timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="15" data-min-time="12:00" data-max-time="11:59" data-show-2400="true"/> 
						</td> 
					</tr>
					<tr>
						<td align="left" valign="middle">
							<strong>Departure On </strong>
						</td>
						<td align="left" valign="middle">
							<input type="date" id="h_departure_on<?php echo $clientVoucher_cnt;?>" class="calfieldicon"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00' && $voucherDetailData['h_departure_on']!=''){ echo date('Y-m-d',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("Y-m-d", strtotime($toDate));}   ?>" placeholder="Departure On"/> 
						</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">
							<strong>To </strong>
						</td>
						<td align="left" valign="middle">
							<input type="text" id="h_to<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_to']); ?>" placeholder="City"//> 
						</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">
							<strong>By </strong>
						</td>
						<td align="left" valign="middle">
							<input type="text" id="h_by_to<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_by_to']); ?>" placeholder="Number"//> 
						</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">
							<strong>At </strong>
						</td>
						<td align="left" valign="middle">
							<input type="text" id="h_at_to<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>" class="timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="15" data-min-time="12:00" data-max-time="11:59" data-show-2400="true"/> 
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
									<strong>Notes</strong>
									<textarea id="voucherNotes<?php echo $clientVoucher_cnt;?>" style="width:100%;border: 1px solid #ccc;"  class="gridfield" ><?php if(!empty($voucherDetailData['voucherNotes'])){ echo strip($voucherDetailData['voucherNotes']); }else{ 
											echo $clientVoucherNoteText; 
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
									<strong>Billing Instructions&nbsp;&nbsp;<span  class="removeEle"><input type="checkbox" value="0" onclick="billInstYes('<?php echo $clientVoucher_cnt;?>')" id="billInstYes<?php echo $clientVoucher_cnt;?>" style="display: inline-block;" <?php if($voucherDetailData['billInstYes']==0){ ?> checked<?php } ?> >&nbsp;Clear&nbsp;TextArea</strong></span>
									<textarea id="billingInstructions<?php echo $clientVoucher_cnt;?>" style="width:100%;border: 1px solid #ccc;" class="gridfield"><?php if(!empty($voucherDetailData['billingInstructions']) or $voucherDetailData['billInstYes']==0){ echo strip($voucherDetailData['billingInstructions']); }else{ echo $clientbillingInstructionText; } ?></textarea>
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
			<?php if($_REQUEST['apiurl']=='1'){ }else{ ?>
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
					<tr>
						<td colspan="2" align="left">
							<input type="button" value="Save Changes" style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="saveChanges('<?php echo $clientVoucher_cnt; ?>')"  />  
							<input type="hidden" id="quotationId<?php echo $clientVoucher_cnt;?>" value="<?php echo $quotationId; ?>" />
							<input type="hidden" id="supplierStatusId<?php echo $clientVoucher_cnt;?>" value="<?php echo $supplierStatusId; ?>" /> 
							<input type="hidden" id="voucherDetailId<?php echo $clientVoucher_cnt;?>" value="<?php echo strip($voucherId); ?>" /> 
						</td>
						<td width="50%" align="right">
							<?php 
							$voucherString=trim($supplierStatusId).'_'.$FID.'_hotel_'.trim($_REQUEST['module']).'_'.trim($quotationId).'_1'; 
							?>
							<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&voucherString=<?php echo $voucherString; ?>" target="_blank" style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF!important;border-radius: 2px;">Send</a>
							&nbsp;&nbsp; 
							<input type="button"value="Print"  style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF;border-radius: 2px;" onclick="printDiv('mailSectionArea<?php echo $clientVoucher_cnt; ?>')" class="a" /> 
						
						</td> 
					</tr>
			</table>
			<?php } ?>
			<br>
			<?php
			$cnt1++;		 
		}
	}
}

// Value Added services block

$clientVoucher_cnt=1;
$qIvpi=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) ');
if(mysqli_num_rows($qIvpi)>0){
	
		$vipData = mysqli_fetch_assoc($qIvpi);
		$voucherQuery="";
		$voucherQuery=GetPageRecord('*','voucherDetailsMaster',' serviceType="VIP" and quotationId="'.$quotationData['id'].'"'); 
		if(mysqli_num_rows($voucherQuery)<1){
			$namevalue ='quotationId="'.$quotationId.'",serviceType="VIP",serviceId="'.$vipData['serviceId'].'"';
			$voucherId = addlistinggetlastid('voucherDetailsMaster',$namevalue);
		} else{
			$voucherDetailData = mysqli_fetch_array($voucherQuery);
			$voucherId  = $voucherDetailData['id'];	
			$supplierStatusId  = $voucherDetailData['id'];	
			$voucherDate2  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
		} 
		$showVocherNum = generateVoucherNumber($voucherId,$_REQUEST['module'],strtotime($queryfromDate));
		$vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
		$suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);
		$isShowClientCont = 0;
		$isShowClientCont = $suppvoucherNotes['clientStatus'];

		$clientVoucherNoteText = $suppvoucherNotes['clientVoucherNoteText'];
		$clientbillingInstructionText = $suppvoucherNotes['clientbillingInstructionText'];	
?>

<div class="sub-container" style="border:1px dashed #ddd;padding:10px;max-width: 800px;"  id="mailSectionAreaV<?php echo strip($clientVoucher_cnt);?>">

<style type="text/css">
					@media print{    
					    .removeEle{
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

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td> 
	<!--logo block-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px; margin: 0 auto;" /></td></tr>
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
							<a href=""><strong><?php echo strip($suppData['name'] ); ?></strong></a>
						</td>
					</tr>
					<tr>
						<td align="left">
							<strong>Address&nbsp;:&nbsp;</strong>
							<?php echo strip($supplierAddData['address']); ?>
						</td>
					</tr>
					<?php if($isShowClientCont == 1){ ?>
					<tr>
						<td align="left">
							<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong>
							<?php echo strip($resListing['contactPerson']); ?> </td>
					</tr>
					<tr>
						<td align="left">
							<strong>Phone&nbsp;:&nbsp;</strong>
							<?php echo decode($resListing['phone']); ?>
						</td>
					</tr>
					<tr>
						<td align="left">
							<strong>Email&nbsp;:&nbsp;</strong>
							<?php echo decode($resListing['email']); ?> </td>
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
							<strong>Agent Name&nbsp;:&nbsp;</strong>
							<?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?>
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
			<input type="text" id="voucherNumbervip" placeholder="Voucher No" onchange="savevoucherDetails<?php echo $supplierStatusId; ?>();" value="<?php echo $showVocherNum; ?>" style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" />
			</td>
			<td>
				<input id="voucherDatevip" type="date" class="gridfield calfieldicon"  placeholder="Voucher Date" value="<?php if($queryfromDate!='1970-01-01' && $queryfromDate!='0000-00-00' && $queryfromDate!=''){ echo date('Y-m-d', strtotime($queryfromDate)); }else{ echo date('Y-m-d'); } ?>" style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" /> 
			</td>
			<td>
				<input 
				name="voucherReferanceNumbervip" 
				type="text" 
				id="voucherReferanceNumbervip" 
				onchange="savevoucherDetails<?php echo $supplierStatusId; ?>();"  
				placeholder="Reference No " 
				value="<?php echo $resultpage['referanceNumber']; ?>" 
				style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" /> 
			</td> 
			
			<div id="savevoucherDetails<?php echo $supplierStatusId; ?>"  style=" display:none;" >
			</div>
		</tr>
	</table>
	<br>
	<!--In favour of:--> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr> 
			<td width="35%"><strong>In favour of:</strong></td>
			<td width="33%"><?php echo $leadPaxName; ?></td>
			<td ><?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; }if($quotationData['infant']>0){ echo ', '.$quotationData['infant']." Infant(s)"; } ?></td>
		</tr>
	</table>
	<br>

	<br>  
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="removeEle" >
	   <tr>
		
		  <td width="20%"><input name="otherGuestName" type="text" id="otherGuestName<?php echo $clientVoucher_cnt;?>" placeholder="Pax Name" style="width:140px; border:1px solid #ccc; padding:3px; font-size:12px;" /></td>
		  <td>
			 <div style="width: fit-content;cursor: pointer;padding: 3px 10px;background-color: #009e67;color: #fff;font-size: 13px;" onclick="addotherGuest('<?php echo $clientVoucher_cnt;?>');">+ Add Other Pax</div>
		  </td>
	   </tr>
	</table>
	<div id="addotherGuest<?php echo $clientVoucher_cnt;?>">&nbsp;</div>
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
		
		loadotherGuest('<?php echo $clientVoucher_cnt;?>');
	</script>
	<br>


	<!-- Services Date -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr> 
			<td width="35%"><strong>Services:</strong></td>
			<td width="85%"><strong>Please provide the services as per the following.</strong></td> 
		</tr>
	</table> 

</td>
	</tr>
</table>
<br>

<?php
$qIV='';
$qIV=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationData['id'].'" and manualStatus=3 )');

		if(mysqli_num_rows($qIV)>0){
			
					 $VBRC = GetPageRecord('*','finalQuoteVisa','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
					 if(mysqli_num_rows($VBRC)>0){
					 ?>
					<div><strong>VISA Details</strong></div>
					<table width="100%" border="1" cellpadding="5" cellspacing="0">
						<tr>
						<th width="30%">Visa Name</th>
						<th width="30%">Visa Type</th>
						<th>Adult(Pax)</th>
						<th>Child(Pax)</th>
						<th>Infant(Pax)</th>
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
				<?php
			}
		
			?>

					<?php
					$PRS = GetPageRecord('*','finalQuotePassport','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
					if(mysqli_num_rows($PRS)>0){
					?>
					<br>
					<div><strong>Passport Details</strong></div>
					<table width="100%" border="1" cellpadding="5" cellspacing="0">
						<tr>
						<th width="30%">Passport Name</th>
						<th width="30%">Passport Type</th>
						<th>Adult(Pax)</th>
						<th>Child(Pax)</th>
						<th>Infant(Pax)</th>
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
				<?php
			}
			?>

			<?php
					$PRS = GetPageRecord('*','finalQuoteInsurance','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
					if(mysqli_num_rows($PRS)>0){
					?>
					<br>
					<div><strong>Insurance Details</strong></div>
					<table width="100%" border="1" cellpadding="5" cellspacing="0">
						<tr>
						<th width="30%">Insurance Name</th>
						<th width="30%">Insurance Type</th>
						<th>Adult(Pax)</th>
						<th>Child(Pax)</th>
						<th>Infant(Pax)</th>
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
				<?php
			}
		
			
}
?>
<br>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
					<tr align="left" valign="top">
						<td colspan="3">
							<div class="griddiv" id="notetexT">
								<label>
									<strong>Notes</strong>
									<textarea id="voucherNotesvip" style="width:100%;border: 1px solid #ccc;"  class="gridfield" ><?php if(!empty($voucherDetailData['voucherNotes'])){ echo strip($voucherDetailData['voucherNotes']); }else{ 
											echo $clientVoucherNoteText; 
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
									<strong>Billing Instructions&nbsp;&nbsp;<span  class="removeEle"><input type="checkbox" value="0" onclick="billInstYesVIP()" id="billInstYesvip" style="display: inline-block;" <?php if($voucherDetailData['billInstYes']==0){ ?> checked<?php } ?> >&nbsp;Clear&nbsp;TextArea</strong></span>
									<textarea id="billingInstructionsvip" style="width:100%;border: 1px solid #ccc;" class="gridfield"><?php if(!empty($voucherDetailData['billingInstructions'])){ echo strip($voucherDetailData['billingInstructions']); }else{ echo $clientbillingInstructionText; } ?></textarea>
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
			<?php if($_REQUEST['apiurl']!='1'){ ?>
			<table width="100%" border="0" cellpadding="5" cellspacing="0" id="vipprintId">
					<tr >
						<td colspan="2" align="left">
							<input type="button" value="Save Changes" style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="saveChangesVIP()"  />  
							<input type="hidden" id="quotationIdvip" value="<?php echo $quotationId; ?>" />
							<input type="hidden" id="supplierStatusIdvip" value="<?php echo $supplierStatusId; ?>" /> 
							<input type="hidden" id="voucherDetailIdvip" value="<?php echo strip($voucherId); ?>" /> 
						</td>
						<td width="50%" align="right">
							<?php 
							$voucherString=trim($supplierStatusId).'_'.$FID.'VIP'.trim($_REQUEST['module']).'_'.trim($quotationId).'_1'; 
							?>
							<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&voucherString=<?php echo $voucherString; ?>" target="_blank" style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF!important;border-radius: 2px;">Send</a>
							&nbsp;&nbsp; 
							<input type="button"value="Print" style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF;border-radius: 2px;" onclick="printDiv('mailSectionAreaV<?php echo $clientVoucher_cnt; ?>')" class="a" /> 
						
						</td> 
					</tr>
			</table>
			<?php } ?>
			<div id="loadVIPVoucher"></div>

	<script>
		function saveChangesVIP(){
			let quotationId = $("#quotationIdvip").val();
			let supplierStatusId = $("#supplierStatusIdvip").val();
			let voucherDetailId = $("#voucherDetailIdvip").val();
			let voucherNotesvip = $("#voucherNotesvip").val();
			let billingInstructionsvip = $("#billingInstructionsvip").val();
			let voucherNumbervip = $("#voucherNumbervip").val();
			let voucherDatevip = $("#voucherDatevip").val();
			let voucherReferanceNumbervip = $("#voucherReferanceNumbervip").val();
			var checkBox = $('#billInstYesvip').is(":checked");
			if (checkBox==true){
		    billInstYes = 0;
		} else {
		    billInstYes = 1;
		}
			
			$('#loadVIPVoucher').load('final_frmaction.php?action=saveVIPVoucher_client&quotationIdvip='+encodeURI(quotationId)+'&supplierStatusId=' + encodeURI(supplierStatusId)+'&voucherDetailId=' + encodeURI(voucherDetailId)+'&voucherNotesvip='+encodeURI(voucherNotesvip)+'&billingInstructionsvip='+encodeURI(billingInstructionsvip)+'&voucherNumbervip='+encodeURI(voucherNumbervip)+'&voucherDatevip='+encodeURI(voucherDatevip)+'&billInstYes='+billInstYes+'&voucherReferanceNumbervip='+encodeURI(voucherReferanceNumbervip)+'&quotationId=<?php echo $quotationId; ?>'); 

		}

		function billInstYesVIP(){
		var checkBox = $('#billInstYesvip').is(":checked"); 
		if (checkBox== true){
		    $('#billingInstructionsvip').val('');
		    $('#billingInstructionsvip').html('');
		} else {
		    $('#billingInstructionsvip').val('Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.');
		    $('#billingInstructionsvip').html('Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.');
		}
	}

	</script>
<br>
<?php
}

// Value Added service block end

$qIQuery2='';   
$qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) ) group by startDate order by startDate asc');
if(mysqli_num_rows($qIQuery2) > 0){
$cnt=0;
while($finalIt_Data2=mysqli_fetch_array($qIQuery2)){ 

	// add or update voucher details
	$supplierStatusId = $finalIt_Data2['id'];
	$voucherQuery="";
	$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusId.'" and serviceType="other" and serviceId=0 and quotationId="'.$quotationId.'"'); 
	if(mysqli_num_rows($voucherQuery)<1){
		$namevalue = 'quotationId="'.$quotationId.'",supplierStatusId="'.$supplierStatusId.'",serviceType="other",serviceId=0';
		$voucherId = addlistinggetlastid('voucherDetailsMaster',$namevalue);
	}else{
		$voucherDetailData = mysqli_fetch_array($voucherQuery);
		$voucherId  = $voucherDetailData['id'];	
		$supplierStatusId = $voucherDetailData['supplierStatusId'];	
		$queryfromDate  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
	}
	$showVocherNum = generateVoucherNumber($voucherId,$_REQUEST['module'],strtotime($queryfromDate));	
 	$clientVoucher_cnt = $supplierStatusId;
	 $vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
	 $suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);
	 $isShowClientCont = 0;
	 $isShowClientCont = $suppvoucherNotes['clientStatus'];
 
	 $clientVoucherNoteText = $suppvoucherNotes['clientVoucherNoteText'];
	 $clientbillingInstructionText = $suppvoucherNotes['clientbillingInstructionText'];
?>
<!--All services vouchers lists except hotel-->
<div class="sub-container" style="border:1px dashed #ddd;padding:10px;max-width: 800px;"  id="mailSectionArea<?php echo strip($clientVoucher_cnt);?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td> 
	<!--logo block-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px; margin: 0 auto;" /></td></tr>
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
							<a href=""><strong><?php echo strip($suppData['name'] ); ?></strong></a>
						</td>
					</tr>
					<tr>
						<td align="left">
							<strong>Address&nbsp;:&nbsp;</strong>
							<?php echo strip($supplierAddData['address']); ?>
						</td>
					</tr>
					<?php if($isShowClientCont == 1){ ?>
					<tr>
						<td align="left">
							<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong>
							<?php echo strip($resListing['contactPerson']); ?> </td>
					</tr>
					<tr>
						<td align="left">
							<strong>Phone&nbsp;:&nbsp;</strong>
							<?php echo decode($resListing['phone']); ?>
						</td>
					</tr>
					<tr>
						<td align="left">
							<strong>Email&nbsp;:&nbsp;</strong>
							<?php echo decode($resListing['email']); ?> </td>
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
							<strong>Agent Name&nbsp;:&nbsp;</strong>
							<?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?>
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
			<input type="text" id="voucherNumber<?php echo $supplierStatusId; ?>" placeholder="Voucher No" onchange="savevoucherDetails<?php echo $supplierStatusId; ?>();" value="<?php echo $showVocherNum; ?>" style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" />
			</td>
			<td>
				<input id="voucherDate<?php echo strip($supplierStatusId); ?>" type="date" class="gridfield calfieldicon"  placeholder="Voucher Date" value="<?php if($queryfromDate!='1970-01-01' && $queryfromDate!='0000-00-00' && $queryfromDate!=''){ echo date('Y-m-d', strtotime($queryfromDate)); }else{ echo date('Y-m-d'); } ?>" style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" /> 
			</td>
			<td>
				<input 
				name="voucherReferanceNumber" 
				type="text" 
				id="voucherReferanceNumber<?php echo $supplierStatusId; ?>" 
				onchange="savevoucherDetails<?php echo $supplierStatusId; ?>();"  
				placeholder="Reference No " 
				value="<?php echo $resultpage['referanceNumber']; ?>" 
				style="width:97%; border:1px solid #fff; padding:3px; font-size:12px;" /> 
			</td> 
			<!-- <td>
				<input name="confirmationNo" type="text" id="confirmationNo<?php echo $supplierStatusId; ?>" onchange="savevoucherDetails<?php echo $supplierStatusId; ?>();"  placeholder="Confirmation No " value="<?php echo $supplierStatusData['confirmationNo']; ?>" style="width:183px; border:1px solid #ccc; padding:3px; font-size:12px;" /> 
			</td> -->
			<div id="savevoucherDetails<?php echo $supplierStatusId; ?>"  style=" display:none;" >
			</div>
		</tr>
	</table>
	<br>
	<!--In favour of:--> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr> 
			<td width="35%"><strong>In favour of:</strong></td>
			<td width="33%"><?php echo $leadPaxName; ?></td>
			<td ><?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; }if($quotationData['infant']>0){ echo ', '.$quotationData['infant']." Infant(s)"; } ?></td>
		</tr>
	</table>
	<br>
	<!--In favour of:--> 
	<!-- <table width="100%" border="0" cellpadding="0" cellspacing="0" >
	   <tr>
		  <td width="35%"><strong>Lead&nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</strong></td>
 		  <td width="50%"><input name="guest<?php echo strip($supplierStatusId);?>" type="text" id="guest<?php echo strip($supplierStatusId);?>" placeholder="Lead Pax Name" value="<?php echo strip($resultpage['leadPaxName']);  ?>" style="width:140px; border:1px solid #fff; padding:3px; font-size:12px;" /></td>
		  <td width="15%">&nbsp;</td>
	   </tr>
	</table> -->
	<br>  
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="removeEle" >
	   <tr>
		  <!-- <td width="35%"><strong>Other Pax Details </strong>:</td> -->
		  <td width="20%"><input name="otherGuestName" type="text" id="otherGuestName<?php echo $clientVoucher_cnt;?>" placeholder="Pax Name" style="width:140px; border:1px solid #ccc; padding:3px; font-size:12px;" /></td>
		  <td>
			 <div style="width: fit-content;cursor: pointer;padding: 3px 10px;background-color: #009e67;color: #fff;font-size: 13px;" onclick="addotherGuest('<?php echo $clientVoucher_cnt;?>');">+ Add Other Pax</div>
		  </td>
	   </tr>
	</table>
	<div id="addotherGuest<?php echo $clientVoucher_cnt;?>">&nbsp;</div>
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
		
		loadotherGuest('<?php echo $clientVoucher_cnt;?>');
	</script>
	<br>


	<!-- Services Date -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr> 
			<td width="35%"><strong>Services:</strong></td>
			<td width="85%"><strong>Please provide the services as per the following.</strong></td> 
		</tr>
	</table> 
					

	<!-- Service date wise list -->
	
	<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;"> 
		 
		<!-- services loop without hotel-->
		<?php  
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
				<td colspan="4"><strong style="font-size: 14px;"><em><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></em></strong></td>
			</tr>
			<br>
			<?php
			//serial wise loop
			$qIQuery=''; 
			$qIQuery=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and totalPax="'.$slabId.' " and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) ) and startDate="'.$finalIt_Data2['startDate'].'" order by srn asc');
		 	while($finalIt_Data=mysqli_fetch_array($qIQuery)){

 
				if($finalIt_Data['serviceType'] == 'transfer' || $finalIt_Data['serviceType'] == 'transportation'){ 

					$transferQuery='';    
					$transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" and totalPax="'.$slabId.'" order by fromDate asc ');  
					while($finalQuoteTransfer=mysqli_fetch_array($transferQuery)){
						$transferFlag = 1;
					 	
						$c="";  
						$c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuoteTransfer['transferId'].'"'); 
						$transferData=mysqli_fetch_array($c);
						
						$d=GetPageRecord('*','quotationTransferMaster','id="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
						$transferQuoteData=mysqli_fetch_array($d);
						 
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
							<td  colspan="4">
								
								<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;"> 
									<tr>
										<td bgcolor="#F3F3F3" width="35%" colspan="4">
											<strong>Transport&nbsp;Name</strong>
										</td>
									 
										<td bgcolor="#F3F3F3">
											<strong>Confirmation&nbsp;No.</strong>
										</td>
									</tr>
								<tr> 
									<td colspan="4"><?php echo $transferType.$vehicleType.$vehicleName.ucfirst($transferData['transferName']); ?></td> 
									<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteTransfer['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
								$startTime24Set = $endTime24Set = $pickupTime24Set = $arrivalFrom = $pickupAddress = $dropAddress = $airportName =$byMode =  $modeName = $modeNumber = '';


								$c="";
								$c=GetPageRecord('*','quotationTransferTimelineDetails','  transferQuoteId="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
								if(mysqli_num_rows($c)>0){
									$TimeData=mysqli_fetch_array($c);	
									if(trim($TimeData['dropTime'])=='' || trim($TimeData['arrivalTime'])==''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($TimeData['arrivalTime']));
										$endTime24Set = date('H:i',strtotime($TimeData['dropTime']));
									}
									if(trim($TimeData['pickupTime'])!=''){
										$pickupTime24Set = date('H:i',strtotime($TimeData['pickupTime']));
									} 
									
									$arrivalFrom = $TimeData['arrivalFrom'];
									$pickupAddress = $TimeData['pickupAddress'];
									$dropAddress = $TimeData['dropAddress'];
									$airportName = $TimeData['airportName'];
									$byMode = $TimeData['mode'];
									if($TimeData['mode'] == 'flight'){
										$modeName = $TimeData['flightName'];
										$modeNumber = $TimeData['flightNumber']; 
									}else{
										$modeName = $TimeData['trainName'];
										$modeNumber = $TimeData['trainNumber']; 
									} 
									?>
									<tr>
										<td bgcolor="#F3F3F3" width="17%">
											<strong>Arrival&nbsp;From</strong>									
										</td>
										<td width="13%" bgcolor="#F3F3F3">
											<strong>By&nbsp;Mode</strong>									
										</td>
										<td width="22%" bgcolor="#F3F3F3">
											<strong><?php if($byMode =='flight'){ echo "Flight"; } else{ echo "Train"; } ?>&nbsp;Name</strong>									</td>
										<td width="18%" bgcolor="#F3F3F3">
											<strong><?php if($byMode =='flight'){ echo "Flight"; } else{ echo "Train"; } ?>&nbsp;Number</strong>									</td>
										<td bgcolor="#F3F3F3" width="30%">
											<strong>Arv/Dpt&nbsp;Time</strong>									
										</td>
									</tr>
									<tr>
										<td><?php echo strip($arrivalFrom); ?></td> 
										<td><?php echo ucfirst($byMode); ?></td> 
										<td><?php echo strip($modeName); ?></td> 
										<td><?php echo $modeNumber; ?></td> 
										<td><?php echo $startTime24Set; ?></td> 
									</tr>
									<tr>
										<td bgcolor="#F3F3F3" width="17%">
											<strong>Pickup&nbsp;Time</strong>									
										</td>
										<td bgcolor="#F3F3F3">
											<strong>Drop Time</strong>
										</td>
										<td bgcolor="#F3F3F3">
											<strong>Airport&nbsp;Name</strong>
										</td>
										<td bgcolor="#F3F3F3">
											<strong>Pickup&nbsp;Address</strong>
										</td>
										<td bgcolor="#F3F3F3">
											<strong>Drop&nbsp;Address</strong>
										</td>
									</tr>
									<tr>
										<td><?php echo $pickupTime24Set; ?></td> 
										<td><?php echo $endTime24Set; ?></td> 
										<td><?php echo strip($airportName); ?></td> 
										<td><?php echo strip($pickupAddress); ?></td> 
										<td><?php echo strip($dropAddress); ?></td> 
									</tr>
								<?php } ?>
								</table>
								
							</td> 
						</tr>
						<?php
					}
				}   

				// Ferry Voucher start

				if($finalIt_Data['serviceType'] == 'ferry'){ 
					$ferryQuery='';   
					$ferryQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
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
								<strong>Ferry&nbsp;Name</strong>
							</td>
							<td bgcolor="#F3F3F3" width="35%">
								<strong>Seat&nbsp;Type </strong>
							</td>
							
							<td bgcolor="#F3F3F3" bgcolor="#133f6d" ><strong>Arrival&nbsp;Time/Departure&nbsp;Time</strong></td>
						
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

					// Ferry Voucher end here

				if($finalIt_Data['serviceType'] == 'entrance'){ 
					$entranceQuery='';   
					$entranceQuery=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
					while($finalQuoteEntrance=mysqli_fetch_array($entranceQuery)){
						 
						//quotationId = "'.$quotationData['id'].'" and
						$c="";
 						$c=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$finalQuoteEntrance['entranceQuotationId'].'"'); 
						$TimeData=mysqli_fetch_array($c);	
						if(strtotime($TimeData['startTime'])=='1621036800' && strtotime($TimeData['endTime'])=='1621036800' || strtotime($TimeData['startTime']) == ''){
							$startTime24Set = $endTime24Set ='';
						}else{
							$startTime24Set = date('H:i',strtotime($TimeData['startTime']));
							$endTime24Set = date('H:i',strtotime($TimeData['endTime']));
						} 

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
						if($finalQuoteEntrance['transferType'] == 1){ $transferType = 'SIC | ';}elseif($finalQuoteEntrance['transferType'] == 2){ $transferType = 'Private | '; }else{
							$transferType = 'Ticket Only | ';
						}
						//	
						?>  
						<tr>
							<td bgcolor="#F3F3F3" width="35%">
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
							<td><?php echo $transferType.$vehicleType.$vehicleName.ucfirst($entranceData['entranceName']); ?></td> 
							<td><?php echo $startTime24Set; ?></td> 
							<td><?php echo $endTime24Set; ?></td> 
							<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteEntrance['confirmationNo']); ?></em></strong></td>
						</tr>
				 		<?php 
					 }  
				}
			 	
			 	if($finalIt_Data['serviceType'] == 'activity'){
				
					$activityQuery='';   
					$activityQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
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
							<td><?php echo $transferType.' | '.strip($activityData['otherActivityName']); ?></td> 
							<td><?php echo $startTime24Set; ?></td> 
							<td><?php echo $endTime24Set; ?></td> 
							<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteActivity['confirmationNo']); ?></em></strong></td>
						</tr>
						<?php 
						$cnt++;
					}   
				}
			 
				if($finalIt_Data['serviceType'] == 'train'){ 
					$trainFlag=1;
					$trainQuery='';   
					$trainQuery=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
					while($finalQuoteTrains=mysqli_fetch_array($trainQuery)){
					 
						$c=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$finalQuoteTrains['trainId'].'"'); 
						$trainData=mysqli_fetch_array($c);	 
 						
						// $c=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'id="'.$finalQuoteTrains['trainQuotationId'].'"'); 
						// $trainQuoteData=mysqli_fetch_array($c);	
						  
						?>   
						<tr> 
							<td  colspan="4">
								<?php  
								$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
								if(trim($finalQuoteTrains['departureTime'])=='' || trim($finalQuoteTrains['arrivalTime'])==''){
									$departureTime = $arrivalTime ='';
								}else{
									$departureTime = date('H:i',strtotime($finalQuoteTrains['arrivalTime']));
									$arrivalTime = date('H:i',strtotime($finalQuoteTrains['departureTime']));
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
									<td bgcolor="#F3F3F3" colspan="6" width="35%">
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

								<!-- started for train reservation request detail -->
								<tr>
									
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
											<!-- <td width="18%" >
												<strong>Middle&nbsp;Name</strong>									
											</td> -->
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
											<?php echo strip($trainmultData['firstName'].' '.$finalQuoteTrains['middleName']); ?>									
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

								</table>
							</td> 
						</tr>
						<?php 
					} 
				}  
			 	
			 	if($finalIt_Data['serviceType'] == 'flight'){ 
			 		$flightFlag=1;
					$flightQuery='';   
					$flightQuery=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
				 	 
					while($finalQuoteFlights=mysqli_fetch_array($flightQuery)){
					 
						$c=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightId'].'"'); 
						$flightData=mysqli_fetch_array($c);	 
						
						// $c="";
						// $c=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightQuotationId'].'"'); 
						// $flightQuoteData=mysqli_fetch_array($c);
						$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
						if(strtotime($finalQuoteFlights['arrivalTime'])=='1621036800' && strtotime($finalQuoteFlights['departureTime'])=='1621036800' || strtotime($finalQuoteFlights['arrivalTime']) == ''){
							$arrivalTime = $departureTime ='';
						}else{
							$arrivalTime = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
							$departureTime = date('H:i',strtotime($finalQuoteFlights['departureTime']));
						}  
						?> 
						
						<tr> 
							<td  colspan="4">
								<?php  
								
								// if(trim($finalQuoteFlights['departureTime'])=='' || trim($finalQuoteFlights['arrivalTime'])==''){
								// 	$departureTime = $arrivalTime ='';
								// }else{
								// 	$departureTime = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
								// 	$arrivalTime = date('H:i',strtotime($finalQuoteFlights['dropTime']));
								// }
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
											<!-- <td style="font-size:16px"><strong><em><?php echo strip($finalQuoteFlights['confirmationNo']); ?></em></strong></td>
										 -->
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
											<td><?php echo $arrivalTo; ?></td> 
											
											<td><?php if($timeData['departureDate']!='' && $timeData['departureDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($timeData['departureDate'])).' / '; } if($timeData['departureTime']!='' && $timeData['departureTime']!='00:00:00'){ echo date('H:i:s',strtotime($timeData['departureTime'])); } ?></td> 
											
											<td><?php if($timeData['arrivalDate']!='' && $timeData['arrivalDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($timeData['arrivalDate'])).' / '; } if($timeData['arrivalTime']!='' && $timeData['arrivalTime']!='00:00:00'){ echo date('H:i:s',strtotime($timeData['arrivalTime'])); } ?></td> 
										</tr>

										<!-- started for train reservation request detail -->
								<tr>
									
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
												<?php echo strip($flightmultData['firstName'].' '.$flightmultData['middleName']); ?>									
												</td>
												<td width="18%" >
												<?php echo strip($flightmultData['lastName']); ?>									
												</td>
													<td  width="17%">
													<?php echo strip($flightmultData['gemder']); ?>			
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
									<td width="18%"><strong>Attachment</strong></td>
									<td colspan="3">
										<a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteFlights['image']; ?>"><?php echo $finalQuoteFlights['image']; ?></a>
									</td>
								</tr>
								</table>
							</td>
						</tr>
						<?php  
					}  
				}

			 	if($finalIt_Data['serviceType'] == 'mealplan'){
					$mealPlanQuery='';   
					$mealPlanQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
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
					$additionalQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
			 	 
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
			 
			 	if($finalIt_Data['serviceType'] == 'guide'){
				 
					$guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc ');  
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
	<!-- Arrival Departure for hotel and transfer--> 
	<!-- <button onclick="showHideArrDepBox('<?php echo $voucherId; ?>','<?php echo $voucherDetailData['ArrivalDepartureStatus']; ?>','<?php echo $clientVoucher_cnt; ?>')" class="removeEle" id="showADtime"><?php if ($voucherDetailData['ArrivalDepartureStatus']==1) { echo 'Show'; }else{ echo "Hide";} ?>  Arrival/Departure Time </button> -->
	<!-- <table  border="1" borderColor="#ccc" cellpadding="4" cellspacing="0" id="ArrivalDepartureDiv<?php echo $clientVoucher_cnt; ?>" class="showhidArr<?php echo $clientVoucher_cnt; ?> <?php if ($voucherDetailData['ArrivalDepartureStatus']==1){ echo 'hideArrival'; } ?>" >
		<tr>
			<td align="left" valign="middle" >
				<strong>Arrival On </strong>			
			</td>
			<td align="left" valigfServicesn="middle"  >
				<input id="h_arrival_on<?php echo $clientVoucher_cnt;?>" type="date" class="calfieldicon" style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00' && $voucherDetailData['h_arrival_on']!=''){ echo date('Y-m-d',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("Y-m-d");}   ?>" placeholder="Arrival On"/>			
			</td>
 			<td align="left" valign="middle"  >
				<strong>From</strong>			
			</td>
			<td align="left" valign="middle"  >
				<input type="text" id="h_from<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_from']); ?>" placeholder="City"/>			
			</td>
 			<td align="left" valign="middle"  >
				<strong>By </strong>			
			</td>
			<td align="left" valign="middle"  >
				<input type="text" id="h_by_from<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_by_from']); ?>" placeholder="Number"//>			
			</td>
 			<td align="left" valign="middle"  >
				<strong>At </strong>			
			</td>
			<td align="left" valign="middle"  >
				<input type="text" id="h_at_from<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>" class="timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="15" data-min-time="12:00" data-max-time="11:59" data-show-2400="true"/>			</td>  
			 
				<input type="hidden" id="quotationId<?php echo $supplierStatusId;?>" value="<?php echo $quotationId; ?>" />
				<input type="hidden" id="supplierStatusId<?php echo $supplierStatusId;?>" value="<?php echo $supplierStatusId; ?>" /> 
 				<input type="hidden" id="voucherDetailId<?php echo $supplierStatusId;?>" value="<?php echo strip($voucherId); ?>" /> 
 		</tr>
		<tr>
			<td align="left" valign="middle">
				<strong>Departure On </strong>			
			</td>
			<td align="left" valign="middle"><input name="h_departure_on<?php echo $clientVoucher_cnt;?>" type="date" class="calfieldicon" id="h_departure_on<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00' && $voucherDetailData['h_departure_on']!=''){ echo date('Y-m-d',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("Y-m-d");}   ?>" placeholder="Departure On"/>
			</td>
 			<td align="left" valign="middle">
				<strong>To </strong>			
			</td>
			<td align="left" valign="middle">
				<input type="text" id="h_to<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_to']); ?>" placeholder="City"//>			
			</td>
 			<td align="left" valign="middle">
				<strong>By </strong>			
			</td>
			<td align="left" valign="middle">
				<input type="text" id="h_by_to<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php echo strip($voucherDetailData['h_by_to']); ?>" placeholder="Number"//>			
			</td>
 			<td align="left" valign="middle">
				<strong>At </strong>			
			</td>
			<td align="left" valign="middle">
				<input type="text" id="h_at_to<?php echo $clientVoucher_cnt;?>"  style="width:94%; border:1px solid #ccc; padding:3px; font-size:12px;" value="<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>" class="timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="15" data-min-time="12:00" data-max-time="11:59" data-show-2400="true"/>			
			</td>
		</tr> 
	</table>    -->

	<!-- Notes and Billing INstructions --> 
	<table border="0" cellpadding="4" cellspacing="0" width="100%">
		<tr align="left" valign="top">
			<td colspan="3">
				<div class="griddiv" id="NotesTextOther">
					<label>
						<strong>Notes</strong>
						<textarea id="voucherNotes<?php echo $clientVoucher_cnt;?>" style="width:100%;border: 1px solid #ccc;"  class="gridfield" ><?php if(!empty($voucherDetailData['voucherNotes'])){ echo strip($voucherDetailData['voucherNotes']); }else{ 
								echo $clientVoucherNoteText; 
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
						<strong>Billing Instructions&nbsp;&nbsp;<span class="removeEle"><input type="checkbox" value="0" onclick="billInstYes('<?php echo $clientVoucher_cnt;?>')" id="billInstYes<?php echo $clientVoucher_cnt;?>" style="display: inline-block;" <?php if($voucherDetailData['billInstYes']==0){ ?> checked<?php } ?> >&nbsp;Clear&nbsp;TextArea</strong></span>
						<textarea id="billingInstructions<?php echo $clientVoucher_cnt;?>" style="width:100%;border: 1px solid #ccc;" class="gridfield"><?php if(!empty($voucherDetailData['billingInstructions']) or $voucherDetailData['billInstYes']==0){ echo strip($voucherDetailData['billingInstructions']); }else{ echo $clientbillingInstructionText; } ?></textarea>
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
	<td colspan="2" align="center"><a href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" style="color:#666666;">
 Generated by TravCRM</a><br><br></td>
	</tr> -->
</table>
</div>
<?php if($_REQUEST['apiurl']=='1'){ }else{ ?>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
	<tr>
		<td colspan="2" align="left">
			<input type="button" value="Save Changes" style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" class="a"  onclick="saveChanges('<?php echo $supplierStatusId; ?>')"  />  
			<!-- mainid = quotationId -->
			<input type="hidden"   id="quotationId<?php echo strip($supplierStatusId);?>" name="quotationId<?php echo strip($supplierStatusId);?>" value="<?php echo $_REQUEST['quotationId']; ?>" />
			<input type="hidden"   id="action<?php echo strip($supplierStatusId);?>" name="action<?php echo strip($supplierStatusId);?>" value="saveSupplierVoucher" /> 			
		</td>
		<td width="50%" align="right"> 
			<?php 
			$voucherString=trim($supplierStatusId).'_0_other_'.trim($_REQUEST['module']).'_'.trim($quotationId).'_1'; 
			?>
			<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&voucherString=<?php echo $voucherString; ?>" target="_blank" style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF!important;border-radius: 2px;">Send</a>&nbsp;&nbsp; 
			<input type="button" name="Submit" value="Print"  style="border:1px solid #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF;border-radius: 2px;" onclick="printDiv('mailSectionArea<?php echo strip($clientVoucher_cnt); ?>')" class="a" />			
		</td> 
	</tr>
</table>
<?php } ?>
<br>
<?php } ?>
<!--Hotel Voucher-->
<?php
} //endofloop



?>  
<!-- end of the all blocks -->
<script>
	function showHideArrDepBox(Vid,ArrivalDepartureStatus,sr){
		if (ArrivalDepartureStatus != '') {
			$('#actionBox').load('final_frmaction.php?action=visibleArrivalDepartureTime&voucherId='+Vid+'&ArrivalDepartureStatus='+ArrivalDepartureStatus);
		}

		var hsclass =  $("#ArrivalDepartureDiv"+sr).hasClass("hideArrival");
		if(hsclass==true){
			$(".showhidArr"+sr).removeClass('hideArrival');
		}else{
			$(".showhidArr"+sr).addClass('hideArrival');
		}
	}

	function billInstYes(ID) {
		var checkBox = document.getElementById('billInstYes'+ID); 
		if (checkBox.checked == true){
		    $('#billingInstructions'+ID).val('');
		    $('#billingInstructions'+ID).html('');
		} else {
		    $('#billingInstructions'+ID).val('Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.');
		    $('#billingInstructions'+ID).html('Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.');
		}
	}


	// function printDiv(divName) { 
	//     var printContents = document.getElementById(divName).innerHTML;
	//     var originalContents = document.body.innerHTML;
	//     document.body.innerHTML = printContents;
	//     window.print();
	//     document.body.innerHTML = originalContents;
	//     parent.location.reload();
	//     return false;
	// }
	function printDiv(divName) {
	    var printContents = document.getElementById(divName).cloneNode(true);

	    // Remove "row" attribute from all textareas and set height to "auto"
	    var textareas = printContents.getElementsByTagName('textarea');
	    for (var i = 0; i < textareas.length; i++) {
	        textareas[i].removeAttribute('rows');
	        textareas[i].style.height = 'auto';
	    }

	    // Create a new window
	    var printWindow = window.open('', '_blank');

	    // Add styles with white background and 20px margin to the printed content
	    var style = '<style media="print">body { background-color: white; margin: 30px; } input, textarea {font-family: "Roboto", sans-serif;} table{border-collapse: collapse; }.main-container input[type=text],.main-container input[type=date]{width:88%;}.main-container input[type=text],.main-container input[type=date], .main-container textarea{border: 1px solid;border-color: #ccc;padding: 6px;font-size: 13px;outline: none;}.w100{ width: 97% !important; }.hidediv{display: none !important;}.saveBtn{display: inline-block;font-size: 14px!important;cursor: pointer;padding: 5px 7px;border: 1px solid #c5c0c0;border-radius: 1px;}.blueBtn{color: #ffffff!important;background-color: #007bff!important;}.whiteBtn{color: #212529!important;background-color: #f8f9fa!important;}.grnBtn{color: #ffffff!important;background-color: #28a745!important;}.blackBtn{color: #fff!important;background-color: #343a40!important;border-color: #343a40!important;}.bill_cls{height: 50px !important;}</style>';

	    // Set the content of the new window with the styles and the modified content
	    printWindow.document.write(style);
	    printWindow.document.body.appendChild(printContents);

	    // Close the document stream to ensure proper rendering
	    printWindow.document.close();

	    // Print the content
	    printWindow.print();

	    // Close the new window after printing
	    printWindow.close();
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