<?php
include "inc.php"; 

// echo $_REQUEST['urlString'];

if($_REQUEST['urlString']!='' && $_REQUEST['allVoucher']==''){
	$postArray = explode("_", trim($_REQUEST['urlString']));
	// print_r($postArray);
	$supplierStatusId = $postArray['0'];
	$serviceId = $postArray['1'];
    $serviceType = $postArray['2'];
	$module = $postArray['3'];
	$quotationId = $postArray['4'];
	$voucherDayId = $postArray['5'];
	$aspdf = $postArray['6'];
	
}elseif($_REQUEST['urlString']!='' && $_REQUEST['allVoucher']=='yes'){
    $postArray = explode("_", trim($_REQUEST['urlString']));
    	$quotationId = $postArray['0'];
       
    	$module = $postArray['1']; 
    	$aspdf = $postArray['2'];
    	$fqssQuery = '';
}else{
    $postArray = explode("_", trim($_REQUEST['urlAllString']));
    $quotationId = $postArray['0'];
    $module = $postArray['1']; 
    $aspdf = $postArray['2'];
    $fqssQuery = '';
}


$rs=''; 
$rs=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" and status=1 '); 
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
 
?> 
<!-- style="padding: 40px;background-color: #fff;width: 800px;" -->
<div class="main-container" >
<?php  

	$b="";
	$b=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$supplierStatusData['supplierId'].'"'); 
	$suppData=mysqli_fetch_array($b);  
	if($module=='SupplierVoucher'){
		$b="";
		$b=GetPageRecord('*',_ADDRESS_MASTER_,' addressParent="'.$suppData['id'].'" and addressType="supplier"'); 
		$supplierAddData=mysqli_fetch_array($b);  
	 
		$b="";
		$b=GetPageRecord('*','suppliercontactPersonMaster',' corporateId="'.$supplierStatusData['supplierId'].'" and contactPerson!="" and deletestatus=0 '); 
		$resListing=mysqli_fetch_array($b);


		$agentName = $suppData['name'];
		$contactPerson = $resListing['contactPerson'];
		$suppagentPone = decode($resListing['phone']);
		$suppagentEmail = decode($resListing['email']);
	}
	if ($module=='ClientVoucher'){
		if($resultpage['clientType']!='2'){
			$ad=GetPageRecord('*',_CORPORATE_MASTER_,' id="'.$resultpage['companyId'].'" order by id desc');  
			$suppData=mysqli_fetch_array($ad);

			$rsss=GetPageRecord('*','contactPersonMaster',' corporateId="'.$suppData['id'].'" and contactPerson!="" and deletestatus=0 order by id asc'); 
			$resListing=mysqli_fetch_array($rsss);
			
			$agentName = $suppData['name'];
			$contactPerson = $resListingp['contactPerson'];
			$suppagentPone = decode($resListing['phone']);
			$suppagentEmail = decode($resListing['email']);

			$rssupad=GetPageRecord('*','addressMaster',' addressParent="'.$suppData['id'].'" and addressType="corporate" order by id asc');
			$supplierAddData=mysqli_fetch_array($rssupad);
		}
		if($resultpage['clientType']=='2'){
			$ad=GetPageRecord('*',_CONTACT_MASTER_,' id="'.$resultpage['companyId'].'" order by id desc');  
			$suppData=mysqli_fetch_array($ad);

			$rsss=GetPageRecord('*',_PHONE_MASTER_,' masterId="'.$suppData['id'].'" and sectionType="contacts" '); 
			$resListingp=mysqli_fetch_array($rsss);

			$rssupad=GetPageRecord('*',_EMAIL_MASTER_,' masterId="'.$suppData['id'].'" and sectionType="contacts" '); 
			$emailData=mysqli_fetch_array($rssupad);

			$rssupad3=GetPageRecord('*','nameTitleMaster',' id="'.$suppData['contacttitleId'].'" '); 
			$nameData=mysqli_fetch_array($rssupad3);

			
			$agentName = ucfirst($nameData['name']).' '.ucfirst($suppData['firstName']).' '.ucfirst($suppData['lastName']);
			$contactPerson = $suppData['name'];
			$suppagentPone = $resListingp['phoneNo'];
			$suppagentEmail = $emailData['email'];
			// $supplierAddData['gstn'] = '';
			$supplierAddData['address'] = $suppData['addressInfo'];
		} 
	} 

    // For Hotel Voucher

	// other vouchers 
    if($_REQUEST['allVoucher']=='' && $_REQUEST['urlAllString']==''){
        $daydataid = 'and id="'.$voucherDayId.'"';
    }
    $dayrs = GetPageRecord('*','newQuotationDays','quotationId="'.$quotationId.'" '.$daydataid.'');
    while($dayData = mysqli_fetch_assoc($dayrs)){
	if(($serviceType=='other' && $_REQUEST['urlString']!='') || $_REQUEST['allVoucher']=='yes' || $_REQUEST['urlAllString']!=''){
        // 
		$qIQuery2='';   
        $qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and dayId="'.$dayData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) ) group by startDate order by startDate asc');
        if(mysqli_num_rows($qIQuery2) > 0){
        $cnt=0;
        $parentLoop=0;
    while($finalIt_Data2=mysqli_fetch_array($qIQuery2)){ 
	$voucherDayId = $finalIt_Data2['dayId'];
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
		<div class="sub-container"  width="700"  style="width:700px;font-size: 16px;font-family: sans-serif;<?php if($aspdf ==1){ ?>padding:10px 50px;<?php } ?>" >
        <table width="700" border="2" cellpadding="15" cellspacing="0">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td> 
	<!--logo block-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:790px;height:100px; margin: 0 auto;" /></td></tr>
	</table>
	<br>

	<!--address block-->
	<!-- header for voucher started -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 15px;">
			<tr style="background: #842057;">
				<td><h2 style="font-size: 20px;color: #FFF;padding: 5px 5px 0px 5px;">VOUCHER</h2></td>
			</tr>
			<br><br>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			

			<!-- left side part -->
			<td width="50%" style="border-right-style: ridge;">
				<table>
					<tr>
						<td  align="left" style="font-size: 16px;">
							<strong>Tour No&nbsp;:&nbsp;</strong>
							<?php echo $tourId; ?>
						</td>
					</tr>
					<tr>
						<td align="left" style="font-size: 16px;">
							<strong>Tour Date&nbsp;:&nbsp;</strong>
							<?php echo date('d/m/Y', strtotime($resultpage['fromDate']) ); ?>
						</td>
					</tr>
					<?php
					if ($_REQUEST['module'] == 'SupplierVoucher') { ?>
					<tr>
						<td align="left" style="font-size: 16px;">
							<strong>Agent Name&nbsp;:&nbsp;</strong>
							<?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td align="left" style="font-size: 16px;">
							<strong>No&nbsp;Of&nbsp;Pax&nbsp;:&nbsp;</strong>
							<?php echo $totalPax; ?>
						</td>
					</tr> 
					<tr>
						<td  align="left" style="font-size: 16px;">
							<strong>Booking No:</strong>
							<?php echo $bookingId; ?>
						</td>
					</tr>
				</table>
			</td>

			<!-- right side part  -->
			<td width="50%" >
				<table width="99%" >
					<tr>
						<td  align="right" style="font-size: 16px;">
						<strong>Voucher&nbsp;No: </strong>
						<?php echo $showVocherNum; ?>

						</td>
					</tr>
					<tr>
						<td align="right" style="font-size: 16px;">
							<strong>Voucher&nbsp;Date : </strong>

							<?php if($queryfromDate!='1970-01-01' && $queryfromDate!='0000-00-00' && $queryfromDate!=''){ echo date('d/m/Y', strtotime($queryfromDate)); }else{ echo date('d/m/Y'); } ?>

							
						</td>
					</tr>
					<tr>
						<td align="right" style="font-size: 16px;">
							<strong>Reference&nbsp;No.: </strong>
							<?php echo $resultpage['referanceNumber']; ?>
						
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<!-- <br>  -->

	<!--In favour of:--> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr> 
			<td width="10%" style="font-size: 18px;"><strong>Service To : &nbsp; &nbsp;</strong></td>
			<td width="30%" style="font-size: 18px;">&nbsp; &nbsp;<?php echo $leadPaxName; ?></td>
			<!-- <td width="" style="font-size: 16px;">&nbsp; &nbsp;<?php echo 'Mohd Islam' ?></td> -->
			
		</tr>
		<tr> 
		<td width="10%" style="font-size: 18px;"><strong>Service for : &nbsp;&nbsp;</strong></td>
		<td width="30%" style="font-size: 18px;">&nbsp; &nbsp;<?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; } ?></td>
		</tr>
	</table>
	<br>
					<br>
					<!-- Services Date -->
					<table width="100%" border="0" cellpadding="1" cellspacing="0" >
						<tr> 
							<td width="100%"><strong>Please provide the services as per the following.</strong></td> 
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
                 <td colspan="7">&nbsp;</td>
             </tr>
             <?php } ?>
 
            
             <br>
             <?php
             //serial wise loop
             $qIQuery=''; 
             $qIQuery=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and dayId="'.$voucherDayId.'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and totalPax="'.$slabId.' " and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) ) and startDate="'.$finalIt_Data2['startDate'].'" ');
 
 
             
              while($finalIt_Data=mysqli_fetch_array($qIQuery)){
 
  
                 if($finalIt_Data['serviceType'] == 'transfer' || $finalIt_Data['serviceType'] == 'transportation'){
 
                     
                     $transferQuery='';    
                     $transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" and totalPax="'.$slabId.'" order by fromDate asc ');  
 
                 
                     // $tptloopN = 0;
                     while($finalQuoteTransfer=mysqli_fetch_array($transferQuery)){
                         $transferFlag = 1;
 
                         ++$tptloopN;
 
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
 
                 
                         // geting time
                         $c1=GetPageRecord('*','quotationTransferTimelineDetails','  transferQuoteId="'.$finalQuoteTransfer['transferQuotationId'].'"');
                         $transferTimelineData=mysqli_fetch_array($c1);
                     
     
                         
                         if($transferTimelineData['pickupTime']!='' && $transferTimelineData['pickupTime']!='00:00'){ 
                             $pickupTime = date('H:i',strtotime($transferTimelineData['pickupTime'])); 
                         } 
                     
                         $transferQuery2='';    
                     $transferQuery2=GetPageRecord('min(id) as id','finalQuotetransfer',' quotationId="'.$finalQuoteTransfer['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                     $loopData='';
                     $loopData = mysqli_fetch_assoc($transferQuery2);
                     if($loopData['id']==$finalQuoteTransfer['id']){
                         ?> 
                         
                         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="servicehide" style="margin-top: 30px;">
                         <tr style="background: #842057;color:#FFF">
                             <td colspan="7"><h2 style="color:#FFF !important;background-color: #842057 !important;">TRANSFER/TRANSPORTATION VOUCHER</h2></td>
                         </tr>
                         </table>
                         <?php } ?>
                     
                                 <tr><td colspan="7">
                                 <table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4" style="font-size:13px;"> 
                                     <tr>
                                         <td bgcolor="#F3F3F3" width="25%" style="font-size: 16px;padding: 10px;">
                                             <strong>Destination</strong>
                                         </td>
 
                                         <td bgcolor="#F3F3F3" width="25%" style="font-size: 16px;padding: 10px;">
                                             <strong>Service &nbsp;Name</strong>
                                         </td>
                                      
                                         <td width="25%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                             <strong>Date</strong>
                                         </td>
                                         <td width="25%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                             <strong>Pick-Up time</strong>
                                         </td>
                                     </tr>
                                 <tr> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo getDestination($transferData['destinationId']); ?></td>
                                     
 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo strip($transferData['transferName'])." | ".$vehicleBrandData['name']." | ".$vehicleData['model']; ?></td> 
                                     
                                     <td style="font-size:16px"><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></td>
                                     <td style="font-size:16px"><?php echo date('H:i',strtotime($transferTimelineData['pickupTime'])); ?></td>
 
                                     <!-- <td style="font-size:16px"><?php echo $pickupTime; ?></td> -->
                                 </tr>
 
                                 <tr>
                                     <td bgcolor="#F3F3F3" style="font-size:16px;padding: 10px;"><strong>Confirmation No.&nbsp;</strong></td>
                                     <td colspan="3"style="font-size: 16px;padding: 10px;background: #132b69;color: white;"><strong><?php echo strip($finalQuoteTransfer['confirmationNo']); ?></strong></td>
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
                                     
                                 <?php } ?>
                                 </table>
                                 </td></tr>
                                     <br>
                                     <br>
                        
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
 
                         $ferryQuery2='';    
                     $ferryQuery2=GetPageRecord('min(id) as id','finalQuoteFerry',' quotationId="'.$finalQuoteFerry['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                     $loopData='';
                     $loopData = mysqli_fetch_assoc($ferryQuery2);
                     if($loopData['id']==$finalQuoteFerry['id']){
 
                         ?>
                         
                         <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                         <tr style="background: #842057;color:#FFF; ">
                             <td colspan="7" ><h2 style="color:#FFF !important;background-color: #842057 !important;"> FERRY VOUCHER</h2></td>
                         </tr>
                         </table>
                     <?php 
                     }
                         ?>
                         <tr><td colspan="7">
                         <table width="100%" border="1" borderColor="#ccc" cellpadding="0" cellspacing="0">
                         <tr>
                             
                             <td width="14%" bgcolor="#F3F3F3">
                                 <strong>Destination</strong>
                             </td>
                             <td width="23%" bgcolor="#F3F3F3" >
                                 <strong>Service &nbsp;Name</strong>
                             </td>
                             <td width="23%" bgcolor="#F3F3F3" >
                                 <strong>Seat&nbsp;Type </strong>
                             </td>
                             <td width="20%" bgcolor="#F3F3F3">
                                 <strong>Date</strong>
                             </td>
                             
                             <td width="20%" bgcolor="#F3F3F3"><strong>Arr.&nbsp;Time/Dep.&nbsp;Time</strong></td>
 
                           
                         </tr>
                         <tr>
                             <td><?php echo getDestination($finalQuoteFerry['destinationId']); ?></td> 
 
                             <td>Ferry : <?php echo strip($ferryData['name']); ?></td> 
 
                             <td>Ferry : <?php echo strip($ferryClassname['name']); ?></td> 
 
                             <td><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></td>
 
                             <td><?php echo $TimeData['pickupTime']; ?> <?php echo '/'.$TimeData['dropTime']; ?> </td> 
                             
                             
                         </tr>
 
                         <tr> 
                             <!-- <table width="100%">
                             <tr> -->
                                 <td bgcolor="#F3F3F3"><strong>Confirmation No.</strong></td> 
 
                                 <td colspan="4" style="font-size:16px; padding: 10px;background: #132b69;color: white;"><strong><?php echo strip($finalQuoteFerry['confirmationNo']); ?></strong></td>
                             <!-- </tr>
                             </table>  -->
                         </tr>
                         </table>
                         </td></tr>
                         <br>
                         <br>
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
                         $transferType = ($finalQuoteEntrance['transferType'] == 1)?'SIC | ':'Private | ';
 
 
                     $entranceQuery2='';    
                     $entranceQuery2=GetPageRecord('min(id) as id','finalQuoteEntrance',' quotationId="'.$finalQuoteEntrance['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                     $loopData='';
                     $loopData = mysqli_fetch_assoc($entranceQuery2);
                     if($loopData['id']==$finalQuoteEntrance['id']){
                         ?>
                         <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                         <tr style="background: #842057;color:#FFF;">
                             <td colspan="7"><h2 style="color:#FFF !important;background-color: #842057 !important;"> ENTRANCE VOUCHER</h2></td>
                         </tr>
                         </table>
                     <?php
                     }
                     ?>
                     <tr>
                        <td colspan="7">

                       
                         <table width="100%" border="1" borderColor="#ccc" cellpadding="0" cellspacing="0">
                         <tr>
                             <td bgcolor="#F3F3F3" width="20%" style="font-size: 16px;padding: 10px;">
                                 <strong>Destination</strong>
                             </td>
                             <td bgcolor="#F3F3F3" width="20%" style="font-size: 16px;padding: 10px;">
                                 <strong>Service &nbsp;Name</strong>
                             </td>
                             <td width="20%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Date</strong>
                             </td>
                             <td width="20%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Start&nbsp;Time</strong>
                             </td>
                             <td width="20%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>End&nbsp;Time</strong>
                             </td>
                             
                         </tr>
                         <tr> 
                             <td style="font-size: 16px;padding: 10px;"><?php echo getDestination($finalQuoteEntrance['destinationId']); ?></td> 
                             <td style="font-size: 16px;padding: 10px;"><?php echo strip($entranceData['entranceName']); ?></td>
                             <td style="font-size: 16px;padding: 10px;"><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></td>
                             <td style="font-size: 16px;padding: 10px;"><?php echo $startTime24Set; ?></td> 
                             <td style="font-size: 16px;padding: 10px;"><?php echo $endTime24Set; ?></td> 
                             
                         </tr>
                         <tr> 
                             <!-- <table width="100%">
                                 <tr> -->
                                     <td bgcolor="#F3F3F3" colspan="1" style="font-size: 16px;padding: 10px;" width="20%"><strong>Confirmation No.</strong></td> 
                                     <td colspan="4" style="font-size:16px; padding: 10px;background: #132b69;color: white;" width="50%">
                                     <strong><?php echo strip($finalQuoteEntrance['confirmationNo']); ?></strong></td>
                                 <!-- </tr>
                             </table>  -->
                         </tr>
                         </table>
                         </td>
                     </tr>
                         <br>
                         <br>
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
 
                         
                     $activityQuery2='';    
                     $activityQuery2=GetPageRecord('min(id) as id','finalQuoteActivity',' quotationId="'.$finalQuoteActivity['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                     $loopData='';
                     $loopData = mysqli_fetch_assoc($activityQuery2);
                     if($loopData['id']==$finalQuoteActivity['id']){
                         ?>
                         <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                         <tr style="background: #842057;color:#FFF ;">
                             <td colspan="7"><h2 style="color:#FFF !important;background-color: #842057 !important;"> SIGHTSEEING VOUCHER</h2></td>
                         </tr>
                         </table>
                     <?php
                     }
                     ?>
                     <tr><td colspan="7">
                         <table width="100%" border="1" borderColor="#ccc" cellpadding="0" cellspacing="0">
                         <tr>
                         <td bgcolor="#F3F3F3" width="20%" style="font-size: 16px;padding: 10px;">
                                         <strong>Destination</strong>
                                     </td>
                                     <td bgcolor="#F3F3F3" width="20%" style="font-size: 16px;padding: 10px;">
                                         <strong>Service &nbsp;Name</strong>
                                     </td>
                                     <td bgcolor="#F3F3F3" width="20%" style="font-size: 16px;padding: 10px;">
                                         <strong>Date</strong>
                                     </td>
                                     <td bgcolor="#F3F3F3" width="20%" style="font-size: 16px;padding: 10px;">
                                         <strong>Start&nbsp;Time</strong>
                                     </td>
                                     <td bgcolor="#F3F3F3" width="20%" style="font-size: 16px;padding: 10px;">
                                         <strong>End&nbsp;Time</strong>
                                     </td>
                         </tr>
                         <tr> 
                                 <td style="font-size: 16px;padding: 10px;"><?php echo getDestination($finalQuoteActivity['otherActivityCity']); ?>
                                     </td>
                                     <td style="font-size: 16px;padding: 10px;"><?php echo strip($activityData['otherActivityName']); ?></td> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></td> 
 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $startTime24Set; ?></td> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $endTime24Set; ?>
                                 </td>
                         </tr>
 
                         <tr> 
                         <td bgcolor="#F3F3F3" colspan="1" style="font-size: 16px;padding: 10px;" width="20%"><strong>Confirmation No.</strong></td> 
                                             <td colspan="4" style="font-size:16px; padding: 10px;background: #132b69;color: white;" width="50%">
                                             <strong><?php echo strip($finalQuoteActivity['confirmationNo']); ?></strong></td>
                         </tr>
                         </table>
                         </td></tr>
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
                          
                         $trainQuery2='';    
                     $trainQuery2=GetPageRecord('min(id) as id','finalQuoteTrains',' quotationId="'.$finalQuoteTrains['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                     $loopData='';
                     $loopData = mysqli_fetch_assoc($trainQuery2);
                     if($loopData['id']==$finalQuoteTrains['id']){
                           
                         ?>   
                        <br><br>
                         <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                         <tr style="background: #842057 ;color:#FFF ;">
                             <td colspan="7"><h2 style="color:#FFF !important;background-color: #842057 !important;"> TRAIN VOUCHER</h2></td>
                         </tr>
                         </table>
                     <?php
                     }
                     ?>
                         <tr> 
                             <td  colspan="7">
                                 <?php  
                                 $departureTime = $arrivalTime = $departureDate = $arrivalDate='';
                                 
                                 $aT = GetPageRecord('*','trainTimeLineMaster','quotationId="'.$finalQuoteTrains['quotationId'].'" and trainQuoteId="'.$finalQuoteTrains['trainQuotationId'].'" and trainId="'.$finalQuoteTrains['trainId'].'" and dayId="'.$finalQuoteTrains['dayId'].'"');
                               

                                 if(mysqli_num_rows($aT)>0){
 
                             
                                 $timeData = mysqli_fetch_assoc($aT);
 
                                 if(trim($timeData['departureTime'])=='' && $timeData['departureTime']=='00:00:00'){
                                     $departureTime ='';
                                 }else{
                             
                                     $departureTime = date('H:i',strtotime($timeData['departureTime']));
                                 }
 
                                 if(trim($timeData['arrivalTime'])=='' && trim($timeData['arrivalTime'])=='00:00:00'){
                                     $arrivalTime ='';
                                 }else{
                             
                                     $arrivalTime = date('H:i',strtotime($timeData['arrivalTime']));
                                 }
 
                                 if(trim($timeData['departureDate'])!='0000-00-00'){
                                     $departureDate = date('d-m-Y',strtotime($timeData['departureDate']));
                                 }else{
                                     $departureDate ='';
                                 }
 
                                 if(trim($timeData['arrivalDate'])!='0000-00-00'){
                                     $arrivalDate = date('d-m-Y',strtotime($timeData['arrivalDate']));
                                 }else{
                                     $arrivalDate ='';
                                 } 
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
                                 
                                 <tr bgcolor="#F3F3F3">  
 
                                 <td width="25%" style="font-size: 16px;padding: 10px;">
                                         <strong>Train&nbsp;Name</strong>									
                                     </td>
 
                                     <td width="25%" style="font-size: 16px;padding: 10px;">
                                         <strong>Train&nbsp;Number</strong>									
                                     </td>
                                         <td  width="17%" style="font-size: 16px;padding: 10px;">
                                         <strong>Departure&nbsp;From</strong>									
                                     </td> 
                                     <td width="13%" style="font-size: 16px;padding: 10px;">
                                         <strong>Arrival&nbsp;To</strong>									
                                     </td> 
                                     <td  width="20%" style="font-size: 16px;padding: 10px;">
                                         <strong>Train&nbsp;Class</strong>									
                                     </td>
                                 </tr>
                                 <tr > 
                                     <td style="font-size: 16px;padding: 10px;">
                                         <?php echo strip($trainName); ?>
                                     </td>
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $trainNumber; ?></td> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo strip($departureFrom); ?></td> 

                                     <td style="font-size: 16px;padding: 10px;"><?php echo strip($arrivalTo); ?></td> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $trainClass; ?></td> 
                                 </tr>
                                 <tr bgcolor="#F3F3F3">
                                     <td style="font-size: 16px;padding: 10px;">
                                         <strong>Journey&nbsp;Type</strong>
                                     </td>
                                     <td style="font-size: 16px;padding: 10px;">
                                         <strong>Departure&nbsp;Date</strong>
                                     </td>
                                     <td style="font-size: 16px;padding: 10px;">
                                         <strong>Departure&nbsp;Time</strong>
                                     </td>
                                     <td style="font-size: 16px;padding: 10px;">
                                         <strong>Arrival&nbsp;Date</strong>
                                     </td>
                                     <td style="font-size: 16px;padding: 10px;">
                                         <strong>Arrival&nbsp;Time</strong>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $journeyType; ?></td> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $departureDate; ?></td> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $departureTime; ?></td> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $arrivalDate; ?></td> 
                                     <td style="font-size: 16px;padding: 10px;"><?php echo $arrivalTime; ?></td> 
                                 </tr>
                                 </table>
                                 <!-- started for train reservation request detail -->
                                 <?php 
                                     $rsst = GetPageRecord('*','trainMultiDetailMaster','quotationId="'.$finalQuoteTrains['quotationId'].'" and parentId="'.$finalQuoteTrains['id'].'"');
                                     if(mysqli_num_rows($rsst)>0){
                                         
                                         ?>
                                 <table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="" style="font-size:13px;">
                                     <tbody>
                                         <tr>  
                                             <td width="10%" >
                                                 <strong>Title&nbsp;</strong>									
                                             </td>
                                             <td width="15%" >
                                                 <strong>First&nbsp;Name</strong>									
                                             </td>
                                             <td width="15%" >
                                                 <strong>Middle&nbsp;Name</strong>									
                                             </td>
                                             <td width="15%" >
                                                 <strong>Last&nbsp;Name</strong>									
                                             </td>
                                                 <td  width="15%">
                                                 <strong>Gender</strong>									
                                             </td> 
                                             <td width="15%" >
                                                 <strong>PNR&nbsp;No.</strong>									
                                             </td> 
                                             <td  width="15%">
                                                 <strong>Confirmation&nbsp;No.</strong>									
                                             </td>
                                         </tr>
                                         <?php 
                                         
                                         while($trainmultData = mysqli_fetch_assoc($rsst)){
                                         ?>
                                         <tr>  
                                             <td width="10%" >
                                             <?php echo strip($trainmultData['title']); ?>								
                                             </td>
                                             <td width="15%" >
                                             <?php echo strip($trainmultData['firstName']); ?>									
                                             </td>
                                             <td width="15%" >
                                             <?php echo ($trainmultData['middleName']); ?>									
                                             </td>
                                             <td width="15%" >
                                             <?php echo strip($trainmultData['lastName']); ?>									
                                             </td>
                                                 <td  width="15%">
                                                 <?php echo strip($trainmultData['gender']); ?>			
                                             </td> 
                                             <td width="15%" >
                                             <?php echo strip($trainmultData['pnrNo']); ?>								
                                             </td> 
                                             <td  width="15%">
                                             <?php echo strip($trainmultData['confirmationNo']); ?>								
                                             </td>
                                         </tr>
                                         <?php } ?>
                                     </tbody>
                                 </table>
                                 <?php } ?>
                                 <!--  ended for train reservation request detail -->
 
 
                             
                                
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
                         
                         
                         $departureTime = $arrivalTime = $departureDate = $arrivalDate='';
                         if(strtotime($finalQuoteFlights['arrivalTime'])=='1621036800' && strtotime($finalQuoteFlights['departureTime'])=='1621036800' || strtotime($finalQuoteFlights['arrivalTime']) == ''){
                             $arrivalTime = $departureTime ='';
                         }else{
                             $arrivalTime = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
                             $departureTime = date('H:i',strtotime($finalQuoteFlights['departureTime']));
                         }  
 
                         $flightQuery2='';    
                     $flightQuery2=GetPageRecord('min(id) as id','finalQuoteFlights',' quotationId="'.$finalQuoteFlights['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                     $loopData='';
                     $loopData = mysqli_fetch_assoc($flightQuery2);
                     if($loopData['id']==$finalQuoteFlights['id']){
                         ?>
                         <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                         <tr style="background: #842057 ;color:#FFF;">
                             <td colspan="7"><h2 style="color:#FFF !important;background-color: #842057 !important;"> FLIGHT VOUCHER</h2></td>
                         </tr>
                         </table>
                     <?php
                     }
                     ?>
                         <tr> 
                             <td colspan="7">
                                 <?php  
                                 
                             
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
                                         <td width="20%" style="font-size: 16px;padding: 10px;">
                                                 <strong>Flight&nbsp;Name</strong>									
                                         </td>
                                             <td width="20%" style="font-size: 16px;padding: 10px;">
                                                 <strong>Flight&nbsp;Number</strong>									
                                             </td>
                                             
                                             <td  width="20%" style="font-size: 16px;padding: 10px;">
                                                 <strong>Flight&nbsp;Class</strong>									
                                             </td>
                                             <td  width="20%" style="font-size: 16px;padding: 10px;">
                                                 <strong>From&nbsp;</strong>									
                                             </td>
                                             <td  width="20%" style="font-size: 16px;padding: 10px;">
                                                 <strong>To&nbsp;</strong>									
                                             </td>
                                             
                                             <!-- <td style="font-size: 16px;padding: 10px;">
                                                 <strong>Confirmation&nbsp;No.</strong>
                                             </td> -->
                                         </tr>
                                         <tr> 
                                         <td style="font-size: 16px;padding: 10px;"><?php echo strip($flightData['flightName']); ?></td>  
                                             <td style="font-size: 16px;padding: 10px;"><?php echo $flightNumber; ?></td> 
                                             
                                             <td style="font-size: 16px;padding: 10px;"><?php echo $flightClass; ?></td>
                                             <td style="font-size: 16px;padding: 10px;"><?php echo $departureFrom; ?></td>
                                            <?php $via = $timeData['via']; ?>  
                                             <td style="font-size: 16px;padding: 10px;"><?php echo $arrivalTo.' Via - '.$via; ?></td>
                                             
                                             
 
                                             <!-- <td style="font-size:16px"><strong><em><?php echo strip($finalQuoteFlights['confirmationNo']); ?></em></strong></td> -->
                                         </tr>
 
                                     <tr bgcolor="#F3F3F3">
                                     <?php
                                     // get baggegs
                                 $c122=GetPageRecord('*','quotationAirlinesRateMaster',' serviceId="'.$finalQuoteFlights['flightId'].'" and flightNumber="'.$finalQuoteFlights['flightNumber'].'"');
                                 $timeData222 = mysqli_fetch_assoc($c122);
                                 ?>
                                     <td style="font-size: 15px;padding: 10px;">
                                             <strong>Baggage Allowance&nbsp;</strong>
                                         </td>
                                         <!-- <td style="font-size: 16px;padding: 10px;">
                                             <strong>To&nbsp;</strong>
                                         </td> -->
                                         <td style="font-size: 16px;padding: 10px;">
                                             <strong>Departure&nbsp;Date</strong>
                                         </td>
                                         <td style="font-size: 16px;padding: 10px;">
                                             <strong>Departure&nbsp;Time</strong>
                                         </td>
                                         <td style="font-size: 16px;padding: 10px;">
                                             <strong>Arrival&nbsp;Date</strong>
                                         </td>
                                         <td style="font-size: 16px;padding: 10px;">
                                             <strong>Arrival&nbsp;Time</strong>
                                         </td>
                                         
                                     </tr>
                                     <tr> 
 
                                         <td style="font-size: 16px;padding: 10px;"><?php echo $timeData222['baggageAllowance'].' Kg' ?></td> 
                                         <!-- <td style="font-size: 16px;padding: 10px;"><?php echo $arrivalTo; ?></td>  -->
                                         
                                         <td style="font-size: 16px;padding: 10px;"><?php if($timeData['departureDate']!='' && $timeData['departureDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($timeData['departureDate'])); } ?></td> 
                                         
                                         <td style="font-size: 16px;padding: 10px;"><?php if($timeData['arrivalDate']!='' && $timeData['arrivalDate']!='0000-00-00'){ date('d-m-Y',strtotime($timeData['arrivalDate'])); }  if($timeData['departureTime']!='' && $timeData['departureTime']!='00:00:00'){ echo date('H:i:s',strtotime($timeData['departureTime'])); } ?></td> 
 
                                         <td style="font-size: 16px;padding: 10px;"><?php if($timeData['arrivalDate']!='' && $timeData['arrivalDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($timeData['arrivalDate'])); } if($timeData['departureTime']!='' && $timeData['departureTime']!='00:00:00'){  date('H:i:s',strtotime($timeData['departureTime'])); } ?></td> 
                                         
                                         <td style="font-size: 16px;padding: 10px;"><?php if($timeData['arrivalDate']!='' && $timeData['arrivalDate']!='0000-00-00'){  date('d-m-Y',strtotime($timeData['arrivalDate'])); } if($timeData['arrivalTime']!='' && $timeData['arrivalTime']!='00:00:00'){ echo date('H:i:s',strtotime($timeData['arrivalTime'])); } ?></td>
                                     </tr>
                                 
                                 <?php if($finalQuoteFlights['image']!=''){?>
                                     <tr>
                                         <td width="18%" style="font-size: 16px;padding: 10px;"><strong>Attachment</strong></td>
                                         <td colspan="3" style="font-size: 16px;padding: 10px;">
                                         <a target="_blank" href="<?php echo $fullurl.'upload/'.$finalQuoteFlights['image']; ?>"><?php echo $finalQuoteFlights['image']; ?></a>
                                     </td>
                                     </tr>
                                     <?php } ?>
 
                                     </table>
 
 
                             <!-- started for train reservation request detail -->
                             <?php 
                                             $rss = GetPageRecord('*','flightMultiDetailMaster','quotationId="'.$finalQuoteFlights['quotationId'].'" and parentId="'.$finalQuoteFlights['id'].'"');
                                             if(mysqli_num_rows($rss)>0){
                                         
                                         ?>
                                     <table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="" style="font-size:13px;">
                                         <tbody>
                                             <tr>  
                                                 <td width="10%" >
                                                     <strong>Title&nbsp;</strong>									
                                                 </td>
                                                 <td width="15%" >
                                                     <strong>First&nbsp;Name</strong>									
                                                 </td>
                                                 <td width="15%" >
                                                     <strong>Middle&nbsp;Name</strong>									
                                                 </td>
                                                 <td width="15%" >
                                                     <strong>Last&nbsp;Name</strong>									
                                                 </td>
                                                     <td width="15%">
                                                     <strong>Gender</strong>									
                                                 </td> 
                                                 <td width="15%" >
                                                     <strong>PNR&nbsp;No.</strong>									
                                                 </td> 
                                                 <td  width="15%">
                                                     <strong>Ticket&nbsp;No.</strong>									
                                                 </td>
                                             </tr>
                                             <?php
                                                 while($flightmultData = mysqli_fetch_assoc($rss)){  ?>
                                             <tr>  
                                                 <td width="10%" >
                                                 <?php echo strip($flightmultData['title']); ?>								
                                                 </td>
                                                 <td width="15%" >
                                                 <?php echo strip($flightmultData['firstName']); ?>									
                                                 </td>
                                                 <td width="15%" >
                                                 <?php echo strip($flightmultData['middleName']); ?>									
                                                 </td>
                                                 <td width="15%" >
                                                 <?php echo strip($flightmultData['lastName']); ?>									
                                                 </td>
                                                     <td  width="15%">
                                                     <?php echo strip($flightmultData['gender']); ?>			
                                                 </td> 
                                                 <td width="15%" >
                                                 <?php echo strip($flightmultData['pnrNo']); ?>								
                                                 </td> 
                                                 <td  width="15%">
                                                 <?php echo strip($flightmultData['confirmationNo']); ?>								
                                                 </td>
                                             </tr>
                                             <?php } ?>
                                         </tbody>
                                     </table>
                                     <?php } ?>
                             <!--  ended for train reservation request detail -->
 
                         
 
 
                            
                         </td>
                         </tr>
                         <?php  
                     }  
                 }
 
                  if($finalIt_Data['serviceType'] == 'mealplan'){
                     
                     $mealPlanQuery='';   
                     $mealPlanQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
                     while($finalQuoteMealPlan=mysqli_fetch_array($mealPlanQuery)){	
 
                         $mealPlanQuery2='';    
                         $mealPlanQuery2=GetPageRecord('min(id) as id','finalQuoteMealPlan',' quotationId="'.$finalQuoteMealPlan['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                         $loopData='';
                         $loopData = mysqli_fetch_assoc($mealPlanQuery2);
                         if($loopData['id']==$finalQuoteMealPlan['id']){
                             ?>
                     <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                         <tr style="background: #842057;color:#FFF ;">
                             <td colspan="7"><h2 style="color:#FFF !important;background-color: #842057 !important;"> RESTAURANT VOUCHER</h2></td>
                         </tr>
                         </table>
                     <?php
                         }
                         ?> 
                         <tr><td colspan="7">
                         <table width="100%" border="1" borderColor="#ccc" cellpadding="0" cellspacing="0">
                         <tr>
                             <td width="25%" bgcolor="#F3F3F3"  style="font-size: 16px;padding: 10px;">
                                 <strong>Destination</strong>
                             </td>
                             <td width="25%" bgcolor="#F3F3F3"  style="font-size: 16px;padding: 10px;">
                                 <strong>Service &nbsp;Name</strong>
                             </td>
 
                             <td width="25%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Meal Plan</strong>
                             </td>
 
                             <td width="25%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Date</strong>
                             </td>
                         </tr>
                         <tr> 
                             <td style="font-size: 16px;padding: 10px;">
                                 <?php echo getDestination($finalQuoteMealPlan['destinationId']); ?>
                             </td> 
                             <td style="font-size: 16px;padding: 10px;"><?php echo strip($finalQuoteMealPlan['mealPlanName']); ?></td>
                             
                             <?php 
                                 $resrestmeal = GetPageRecord('*','restaurantsMealPlanMaster','id="'.$finalQuoteMealPlan['mealTypeId'].'"');
                                 $resmealres = mysqli_fetch_assoc($resrestmeal);
                                 
                             ?>
                             <td style="font-size: 16px;padding: 10px;"><?php echo $resmealres['name'] ?></td>
                             <td style="font-size: 16px;padding: 10px;"><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></td>
                         </tr>
 
 
                         <tr> 
                            
                                     <td width="25%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;" width="20%"><strong>Confirmation No.</strong></td> 
                                     <td colspan="3" style="font-size:16px; padding: 10px;background: #132b69;color: white;" width="50%"><strong><?php echo strip($finalQuoteMealPlan['confirmationNo']); ?></strong></td>
                                 </tr>
                             
                         </table>
                         </td></tr>
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
 
                         $additionalQuery2='';    
                         $additionalQuery2=GetPageRecord('min(id) as id','finalQuoteExtra',' quotationId="'.$finalQuoteadditionalD['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                         $loopData='';
                         $loopData = mysqli_fetch_assoc($additionalQuery2);
                         if($loopData['id']==$finalQuoteadditionalD['id']){
                             ?>
                         <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                         <tr style="background: #842057;color:#FFF;">
                             <td colspan="7"><h2 style="color:#FFF !important;background-color: #842057 !important;"> ADDITIONAL SERVICES VOUCHER</h2></td>
                         </tr>
                         </table>
                         <?php
                         }
                         ?>
                         <tr><td colspan="7">
                         <table width="100%" border="1" borderColor="#ccc" cellpadding="0" cellspacing="0">
                         <tr>
                             <td width="30%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Destination</strong>
                             </td>
                             <td width="30%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Service Name</strong>
                             </td>
                         
                             <td width="40%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Date</strong>
                             </td>
                         </tr>
                         <tr> 
                            <td width="30%" style="font-size: 16px;padding: 10px;"><?php echo getDestination($additionalData['destinationId']); ?></td>
                            
                            <td width="30%" style="font-size: 16px;padding: 10px;"><?php echo strip($additionalData['name']); ?></td> 

                             <td width="40%" style="font-size:16px"><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></td>
                         </tr>
                         <tr> 
                            
                                <td width="30%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;"><strong>Confirmation No.</strong></td> 

                                 <td colspan="2" style="font-size:16px; padding: 10px;background: #132b69;color: white;"><strong><?php echo strip($finalQuoteadditionalD['confirmationNo']); ?></strong></td>
                            
                         </tr>
                         </table>
                         </td></tr>
                         <?php
                     }  
                 } 
              
                  if($finalIt_Data['serviceType'] == 'guide'){
                     
                     $guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc ');  
                      while($finalQuoteGuides=mysqli_fetch_array($guideQuery)){
                  
                         $c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuides['guideId'].'"'); 
                         $guideData=mysqli_fetch_array($c);	
                         
                         $guideQuery2='';    
                         $guideQuery2=GetPageRecord('min(id) as id','finalQuoteGuides',' quotationId="'.$finalQuoteGuides['quotationId'].'" and fromDate="'.$finalIt_Data2['startDate'].'" and manualStatus=3 order by fromDate asc'); 
                         $loopData='';
                         $loopData = mysqli_fetch_assoc($guideQuery2);
                         if($loopData['id']==$finalQuoteGuides['id']){
                             ?>
                     <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                         <tr style="background: #842057;color:#FFF;">
                             <td colspan="7"><h2 style="color:#FFF !important;background-color: #842057 !important;"> GUIDE SERVICE VOUCHER</h2></td>
                         </tr>
                         </table>
                     <?php
                         }
                         ?> 
                         <tr>
                            <td colspan="7">

                          
                         <table width="100%" border="1" borderColor="#ccc" cellpadding="0" cellspacing="0">
                         <tr>
                             <td bgcolor="#F3F3F3" width="35%" style="font-size: 16px;padding: 10px;">
                                 <strong>Destination</strong>
                             </td>
                             <td bgcolor="#F3F3F3" width="35%" style="font-size: 16px;padding: 10px;">
                                 <strong><?php if($finalQuoteGuides['serviceType'] ==1){ echo "Service";}else{ echo "Service"; } ?>&nbsp;Name</strong>
                             </td>
                         
                             
                             <td width="30%" bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Date</strong>
                             </td>
                         </tr>
                         <tr> 
                             <td style="font-size: 16px;padding: 10px;"><?php echo getDestination($finalQuoteGuides['destinationId']); ?></td>
                             <td style="font-size: 16px;padding: 10px;"><?php echo strip($guideData['name']); ?></td> 
                             <td style="font-size: 16px;padding: 10px;"><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></td>
                         </tr>
 
                         <tr>
                             <td colspan="1"  bgcolor="#F3F3F3" style="font-size: 16px;padding: 10px;">
                                 <strong>Confirmation&nbsp;No.</strong>
                             </td>
 
                             <td colspan="2" style="font-size: 16px;padding: 10px;background: #132b69;color: white;"><strong><?php echo strip($finalQuoteGuides['confirmationNo']); ?></strong></td>
 
                         </tr>
                         </table>
                         </td>
                         </tr>
                         <?php 
                     }
                 }
                 
             }
             
             $cnt++;
         ?>  
         
         <!-- end of the services loop from final tables -->
     </table>
					<!-- Arrival Departure for hotel and transfer-->
					<style type="text/css">
						@media print
						{    
						    .removeEle{
						        display: none !important;
						    } 
							table{
								border: 0px solid #fff;
								border-collapse: collapse; 

							}
							input[type=text], input[type=date]{
								width:94%;
							}
						    input, textarea{
								border: 0px solid;
	    						border-color: #fff;
								outline: none;		        
						    }
						}
						table{
							border-collapse: collapse; 
						}
						.main-container input[type=text],.main-container input[type=date]{
							width:94%;
						}
						.main-container input, .main-container textarea{
							border: 1px solid;
							border-color: #ccc;
							padding: 3px;
							font-size: 12px;
							outline: none;		        
						}
						.w100{ width: 99%; }
						.hidediv{
					        display: none !important;
					    }
					</style>
					<br>
					<!-- Arrival Departure for hotel and transfer-->
					<?php if ($ADStatus==1) { ?>
					<table  border="0" borderColor="#ccc" cellpadding="2" cellspacing="0"  >
						<tr>
							<td align="left" valign="middle" width="15%">
								<strong>Arrival On&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle"  >
								<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_arrival_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_arrival_on'])); }   ?> 
							</td>
							<td align="left" valign="middle"  >
								<strong>From&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle"  >
								<?php echo strip($voucherDetailData['h_from']); ?>
							</td>
							<td align="left" valign="middle"  >
								<strong>By&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle"  >
								<?php echo strip($voucherDetailData['h_by_from']); ?>
							</td>
							<td align="left" valign="middle"  >
								<strong>At&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle"  >
								<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }  ?>
							</td> 
						</tr>
						<tr>
							<td align="left" valign="middle">
								<strong>Departure On&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle">
								<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_departure_on']!=''){ echo  $voucherDetailData['h_departure_on'] ; }   ?>
							</td>
							<td align="left" valign="middle">
								<strong>To&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle">
								<?php echo strip($voucherDetailData['h_to']); ?>
							</td>
							<td align="left" valign="middle">
								<strong>By&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle">
								<?php echo strip($voucherDetailData['h_by_to']); ?>
							</td>
							<td align="left" valign="middle">
								<strong>At&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle">
								<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }   ?>
							</td>
						</tr>
					</table> 
					<!-- Notes and Billing INstructions --> 
					<br>
					<?php } ?>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<?php //if(!empty($voucherNotes)){ ?>
						<tr align="left" valign="top">
							<td colspan="3">
								<div  class="w100" ><strong>Notes&nbsp;:&nbsp;</strong><?php if(!empty($voucherDetailData['voucherNotes'])){ echo ucfirst(strip($voucherDetailData['voucherNotes'])); }else{ 
										echo $suppvoucherNotes['supplierVoucherNoteText']; 
									} ?></div><br>
								</td>
						</tr>
						<?php //} ?>
						<tr align="left" valign="top"  >
							<td colspan="3">
								<div  class="w100"><strong>Billing&nbsp;Instructions&nbsp;:&nbsp;</strong>
									<?php if(!empty($billingInstructions)){ echo ucfirst(strip($billingInstructions)); }else{ echo $suppvoucherNotes['supplierbillingInstructionText']; } ?></div>
							</td>
							<!-- or $billInstYes==0 -->
						</tr>
					</table>
				</td>
				</tr>
                <tr>
			<td >
			<!-- <div class="end-of-doc-sec"> -->
			<!-- style="border-collapse: collapse;" -->
            <table border="1" class="vaservices-details-tdate" style="width: 100%;border-collapse: collapse;" >
              
                <tr class="trav-dt-ss2" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background:#132b69;position: relative;">
                    <th width="20" style="width: 90px;padding: 10px;">Contact Person</th>
					<th width="20" style="padding: 16px;">Country Code</th>
                    <th width="20" style="padding: 10px;">Mobile Number</th>
                    <th width="20" style="padding: 10px;">Email Id</th>
                    <th width="20" style="padding: 10px;">Available On</th>
                    
                </tr>

				<?php
					$rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
					while($emData = mysqli_fetch_assoc($rsem)){
					
					?>
                <tr style="text-align: center;height: 40px;">
                    <td class="cnt-pro-m" style="padding: 10px;text-align: left;"><?php echo $emData['contactPerson']; ?></td>
					<td class="cnt-pro-m" style="padding: 10px;text-align: left;"><?php echo $emData['countryCode']; ?></td>
                    <td class="cnt-pro-m" style="padding: 10px;text-align: left;"><?php echo $emData['phone']; ?></td>
                    <td class="cnt-pro-m" style="padding: 10px;text-align: left;"><?php echo $emData['email']; ?></td>
                    <td class="cnt-pro-m" style="padding: 10px;text-align: left;"><?php echo $emData['availableOn']; ?></td>
                    
                </tr>
				<?php }?>
                
                
            </table>
        <!-- </div> -->
			</td>
		</tr>
                
			</table>
			</div>  
			<?php 
		} 
	}
    }
}

	// Hotel Voucher
	// for hotel only  
  
	$dateSets = getHotelDateSets($quotationId,$supplierStatusData['supplierId']);
	$dateSetArray = explode('~',$dateSets);
	$cnt1 = 1;

        
	if(strlen($dateSets)>0){ 
		foreach($dateSetArray as $dateSet){

		$suppStatusId_cnt = strip($supplierStatusData['id']."_".$cnt1);
		$supplierStatusId = $supplierStatusData['id'];

		$dateSetData = explode('^',$dateSet);
		$hotelId = $dateSetData[0];
		$fromDate = $dateSetData[1];
		$toDate = $dateSetData[2];
		$FID = $dateSetData[3];
        
		$g="";
		$g=GetPageRecord('*','finalQuote','id="'.$FID.'"'); 
		$finalHotelData=mysqli_fetch_array($g);
        
		if(($serviceType == 'hotel' && $_REQUEST['urlString']!='' && $finalHotelData['manualStatus']==3) || $_REQUEST['allVoucher']=='yes' || $_REQUEST['urlAllString']!=''){ 
			$c="";
			$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"'); 
			$hotelData=mysqli_fetch_array($c); 
			
			$rooms = '';
			if($quotationData['sglRoom'] > 0){ $rooms .= $quotationData['sglRoom']." SGL ,"; }
			if($quotationData['dblRoom'] > 0){ $rooms .= $quotationData['dblRoom']." DBL ,"; }
			if($quotationData['tplRoom'] > 0){ $rooms .= $quotationData['tplRoom']." TPL ,"; }
			if($quotationData['twinRoom'] > 0){ $rooms .= $quotationData['twinRoom']." TWIN ,"; }
			if($quotationData['extraNoofBed'] > 0){ $rooms .= $quotationData['extraNoofBed']." EBed(A) ,"; }
			if($quotationData['childwithNoofBed'] > 0){ $rooms .= $quotationData['childwithNoofBed']." CWBed ,"; }
			if($quotationData['childwithoutNoofBed'] > 0){ $rooms.= $quotationData['childwithoutNoofBed']." CNBed ,"; }
			if($quotationData['sixNoofBedRoom'] > 0){ $rooms .= $quotationData['sixNoofBedRoom']." SixBed, "; }
			if($quotationData['eightNoofBedRoom'] > 0){ $rooms .= $quotationData['eightNoofBedRoom']." EightBed, "; }
			if($quotationData['tenNoofBedRoom'] > 0){ $rooms .= $quotationData['tenNoofBedRoom']." TenBed, "; }
			if($quotationData['quadNoofRoom'] > 0){ $rooms .= $quotationData['quadNoofRoom']." Quad, "; }
			if($quotationData['teenNoofRoom'] > 0){ $rooms .= $quotationData['teenNoofRoom']." Teen, "; }
			
			$noOfRooms = $quotationData['sglRoom']+$quotationData['dblRoom']+$quotationData['tplRoom']+$quotationData['twinRoom']+$quotationData['extraNoofBed']+$quotationData['childwithNoofBed']+$quotationData['childwithoutNoofBed']+$quotationData['sixNoofBedRoom']+$quotationData['eightNoofBedRoom']+$quotationData['tenNoofBedRoom']+$quotationData['quadNoofRoom']+$quotationData['teenNoofRoom'];
			
			$g="";
			$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$finalHotelData['roomType'].'"'); 
			$roomTypeData=mysqli_fetch_array($g);
			$rType=$roomTypeData['name'];
			
			$g="";
			$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$finalHotelData['mealPlanId'].'"'); 
			$mealData=mysqli_fetch_array($g);
			//.'-'.$mealData['subname'] 
			$mealplan = $mealData['name'];
			 
			$CheckIn = date('d/m/Y',strtotime($fromDate));
			$CheckOut = date('d/m/Y',strtotime($toDate));
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
				// get data
				$voucherQuery2=GetPageRecord('*','voucherDetailsMaster','id="'.$voucherId.'" '); 
				$voucherDetailData = mysqli_fetch_array($voucherQuery2);
			} else{
				$voucherDetailData = mysqli_fetch_array($voucherQuery);
				$voucherId  = $voucherDetailData['id'];	
				$voucherDate2  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
			}
			$vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
			$suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);
	   		$isShowSupCont = 0;
			$isShowSupCont = $suppvoucherNotes['supplierStatus']; 
			if($module=='ClientVoucher'){
				$ADStatus = $voucherDetailData['cli_ADStatus'];
			 	$voucherNotes = $voucherDetailData['cli_voucherNotes'];
			 	$billInstYes = $voucherDetailData['cli_billInstYes'];
			 	$billingInstructions = $voucherDetailData['cli_billingInstructions'];
			}else{
				$ADStatus = $voucherDetailData['sup_ADStatus'];
			 	$voucherNotes = $voucherDetailData['sup_voucherNotes'];
			 	$billInstYes = $voucherDetailData['sup_billInstYes'];
			 	$billingInstructions = $voucherDetailData['sup_billingInstructions'];
			}
			
			$showVocherNum = generateVoucherNumber($voucherId,$module,strtotime($fromDate));	
			?>
			<div class="sub-container" style="width:700px;font-size: 16px;font-family: sans-serif; <?php if($aspdf ==1){ ?>padding:10px 50px;<?php } ?>" >
            <table width="700" border="0" cellpadding="0" cellspacing="0">
				<tr><td width="700"> 
				<!--logo block-->
				<table width="85%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td ><img align="center" src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:700px;height:100px;" /></td></tr>
				</table>
				<br>
			
				<!--address block-->
                <!-- header for voucher started -->
                <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr style="background: #842057;">
                                <td><h2 style="font-size: 20px;color: #FFF;padding: 10px 10px 0px 10px;">VOUCHER  / ACCOMMODATION</h2></td>
                            </tr>
                            <br><br>
                </table>
				
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
					
						<td width="280" style="border-right-style: ridge;">
							<table width="100%">
								<tr>
									<td width="" align="left" style="font-size: 14px;">
										<strong>Tour No&nbsp;:&nbsp;</strong>
										<?php echo $tourId; ?>
									</td>
								</tr>
								<tr>
									<td align="left" style="font-size: 14px;">
										<strong>Tour Date&nbsp;:&nbsp;</strong>
										<?php echo date('d/m/Y', strtotime($resultpage['fromDate']) ); ?>
									</td>
								</tr>
								<?php
								if ($_REQUEST['module'] == 'SupplierVoucher') { ?>
								<tr>
									<td align="left" style="font-size: 14px;">
										<strong>Agent Name&nbsp;:&nbsp;</strong>
										<?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td align="left" style="font-size: 14px;">
										<strong>No Of &nbsp;Pax:&nbsp;</strong>
										<?php echo $totalPax; ?>
									</td>
								</tr> 
								<tr>
									<td  align="left" style="font-size: 14px;">
										<strong>Booking No:</strong>
										<?php echo $bookingId; ?>
									</td>
								</tr>
							</table>
						</td>
                        <!-- left side -->
                        <td width="250">
							<table width="100%">
								<tr>
									<td  align="right" style="font-size: 14px;">
										<strong>Voucher&nbsp;No :</strong>
										<?php echo $showVocherNum; ?>
                                          
                                           
									</td>
								</tr>
								<tr>
									<td align="right" style="font-size: 14px;">
										<strong>Voucher&nbsp;Date : </strong>
                                        <?php if($voucherDate2!='1970-01-01 00:00:00' && $voucherDate2!='0000-00-00 00:00:00' && $voucherDate2!=''){ echo date('d/m/Y', strtotime($voucherDate2)); }else{ echo date('d/m/Y',strtotime($fromDate)); } ?>

									</td>
								</tr>
                                <tr>
									<td align="right" style="font-size: 14px;">
										<strong>Reference&nbsp;No.:</strong>
                                        <?php echo $resultpage['referanceNumber']; ?>
									
									</td>
								</tr>
                       


							
							</table>
						</td>
					</tr>
				</table>
			
				<!-- manually voucher no and date -->
				<!--  -->
				<br>
				<br>
				<!--In favour of:--> 
                <table width="100%" border="1" cellpadding="0" cellspacing="0" >
                    <tr> 
                        <td width="130" style="font-size: 14px;"><strong>Guest Name :&nbsp;</strong></td>
                        <td width="400" style="font-size: 14px;">&nbsp;<?php echo $leadPaxName; ?></td>

                        
                    </tr>
                    <tr> 
                    <td width="130" style="font-size: 14px;"><strong>Service for :&nbsp;</strong></td>
                    <td width="400" style="font-size: 14px;">&nbsp;<?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; } ?></td>
                    </tr>
                </table>
				
				<!--In favour of:-->
            <br><br>
				
					<!-- Hotel Information -->
				
                    <table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4"> 
                    <tr> 
                    <td colspan="2" width="530" style="font-size: 16px;"><strong>Services</strong></td>
                 
                </tr>
					<tr><td colspan="2" width="530" style="font-size: 16px;"><strong>
						<?php echo $hotelData['hotelName']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php
						$ppres = GetPageRecord('*','proposalSettingMaster','proposalNum=6');
						$starcolor = mysqli_fetch_assoc($ppres);

						$cres = GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"');
						$catres = mysqli_fetch_assoc($cres);
						$hotelStar = $catres['hotelCategory'];
							 for($i=1; $i<=$hotelStar; $i++ ){
								?>
								<i style="font-size: 26px;vertical-align:bottom; color: #e3e334;;" class="fa fa-star" aria-hidden="true"></i>
								<?php
							 } ?>
							 </strong>
                         </td></tr>
						<tr><td width="130;" style="font-size: 14px;"><strong>Address:</strong></td>
                             <td width="400;"><?php echo $hotelData['hotelAddress']; ?></td>
                        </tr>
                        <tr><td width="130;" style="font-size: 14px;"><strong>Website URL:</strong></td>
                             <td width="400;"><?php echo $hotelData['url']; ?></td>
                        </tr>
                        
						
                    </table>
                     <table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4">
                    <tr ><td width="100;" style="font-size: 14px;"><strong>Telephone:</strong></td>
                             <td width="160;"><?php echo $hotelcpmData['phone']; ?></td>
                             <td width="70;" style="font-size: 14px;"><strong>E-mail:</strong></td>
                             <td width="200"><?php echo $hotelcpmData['email']; ?></td>
                            </tr>
                             </table>
				
				<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4"> 
				 	<tr> 
						<!-- <td bgcolor="#F3F3F3" width="5%" align="center" rowspan="3"><?php echo 1; ?></td>  -->
						<td bgcolor="#F3F3F3" style="font-size: 14px;padding: 10px;" width="200"><b><?php echo strip($hotelData['hotelName']); ?></b></td>  
						<td width="120" bgcolor="#F3F3F3" style="font-size: 14px;padding: 10px;"><?php echo $CheckIn;?></td> 
						<td width="120" bgcolor="#F3F3F3" style="font-size: 14px;padding: 10px;"><?php echo $CheckOut; ?></td>
						<td width="90" bgcolor="#F3F3F3" style="font-size: 14px;padding: 10px;"><?php echo $nights." Nights"; ?></td>  
					</tr>
					<tr> 
                        
					<td bgcolor="#F3F3F3" style="font-size: 14px;padding: 10px;"><b><?php echo "Confirmation No." ?></b></td>
					<td colspan="3" style="font-size: 14px;padding: 10px;background: #132b69;color: white;"><strong><?php echo $confNO; ?></strong></td> 
					</tr></table>
					<?php  
					// group by roomType,mealPlanId 
					$g2="";
					$g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and  hotelId="'.$hotelId.'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" order by fromDate asc'); 
					if(mysqli_num_rows($g2)>0){ 
						while($quotMealData=mysqli_fetch_array($g2)){ 
					?>
							<!-- <tr>
								<td colspan="4"> -->
								<table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size:13px;">
								<tr  bgcolor="#F3F3F3"> 
									<td width="180"  align="center" style="font-size: 16px;padding: 10px;"><strong>Date</strong></td>
									<td width="250" align="center" style="font-size: 16px;padding: 10px;"><strong>Room Type</strong></td>
									<td width="100" align="center" style="font-size: 16px;padding: 10px;"><strong>Meal Plan</strong></td> 
								</tr>
								<tr>
									<td style="font-size: 16px;padding: 10px;"  align="center" width="180"><?php echo date('d M',strtotime($quotMealData['fromDate']))." - ".date('d M Y',strtotime($quotMealData['toDate']) + 86400); ?></td>  

									<td style="font-size: 16px;padding: 10px;" align="center" width="250">&nbsp;&nbsp;<?php echo $rType.'/ '.$rooms ;?></td>

									<td style="font-size: 16px;padding: 10px;" align="center" width="100" ><?php echo $mealplan; if($quotMealData['lunch']>0 && $quotMealData['complimentaryLunch']==1){ echo ", Lunch"; } if($quotMealData['dinner']>0 && $quotMealData['complimentaryDinner']==1){echo ", Dinner"; } if($quotMealData['breakfast']>0 && $quotMealData['complimentaryBreakfast']==1){echo ", Breakfast"; } ?></td>
								</tr>
							</table>
                        <!-- </td></tr>  -->
							<?php
						}
						$rs12='';
						$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$finalHotelData['hotelQuotationId'].'" and quotationId="'.$finalHotelData['quotationId'].'" '); 
                        if(mysqli_num_rows($rs12)>0){
						while ($editresult2=mysqli_fetch_array($rs12)) {
							$rtype  .= $editresult2['name'].', ';
						}
						?>
					
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
							<tr>
								<!-- <td width="20%"><b>Hotel Additionals: </b></td>   -->
								<td width="530"><?php echo rtrim($rtype,', '); ?></td> 
							</tr>
							</table>
                         
						<?php
					}
                }
					?>
					
					<!-- end of the services loop from final tables -->
				
					<br> 
					<style type="text/css">
					
						table{
							border-collapse: collapse; 
						}
						.main-container input[type=text],.main-container input[type=date]{
							width:94%;
						}
						.main-container input, .main-container textarea{
							border: 1px solid;
							border-color: #ccc;
							padding: 3px;
							font-size: 12px;
							outline: none;		        
						}
						.w100{ width: 99%; }
						.hidediv{
					        display: none !important;
					    }

					</style>
				
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<?php //if(!empty($voucherNotes)){ ?>
						<tr align="left" valign="top">
							<td width="530" style="font-size: 12px;">
								<div ><strong>Notes&nbsp;:&nbsp;</strong><?php if(!empty($voucherNotes)){ echo ucfirst(strip($voucherNotes)); }else{ 
										echo $suppvoucherNotes['supplierVoucherNoteText']; 
									} ?></div><br>
								</td>
						</tr>
						<?php //} ?>
						<tr align="left" valign="top">
							<td width="530" style="font-size: 12px;">
								<div><strong>Billing&nbsp;Instructions:&nbsp;</strong><?php if(!empty($billingInstructions)){ echo ucfirst(strip($billingInstructions)); }else{ echo $suppvoucherNotes['supplierbillingInstructionText']; } ?></div>
							</td>
							<!-- or $billInstYes==0 -->
						</tr>
					</table>  
					</td>
					</tr>
				</table>
			</div> 
			<!-- </div>  -->
			<br>
			<?php
			$cnt1++;		 
		}
		}
	} 
// } //endofloop

?>   
</div>
