<?php 
include "inc.php"; 
?>
<script src="js/jquery-1.11.3.min.js"></script>
<div id="final_frmaction" style="display:none;"></div>
<?php
//supplier wise 
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"'); 
$quotationData=mysqli_fetch_array($rsp);  

$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$pax = ($quotationData['adult']+$quotationData['child']);

$calculationType = $quotationData['calculationType'];
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

$rs='';   
$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$queryId.'"');  
$resultpage=mysqli_fetch_array($rs); 
 
// if($resultpage['queryType'] == 4 || $quotationData['calculationType'] == 3 ){
// 	$update = updatelisting('finalQuotSupplierStatus','deletestatus=0,isPackage=1','quotationId="'.$quotationId.'"');
//  }else{
	// update all supplier entries disabled first this will be enabled in the below loop
	$update = updatelisting('finalQuotSupplierStatus','deletestatus=1','quotationId="'.$quotationId.'"');   
// }
// update quoation to show payment requeset button
$update = updatelisting(_QUOTATION_MASTER_,'isPaymentRequest=1','id="'.$quotationId.'"');
$isTransferTaken='';
$isFlightTaken='';
if($calculationType==3){
	$isFlightTaken = ' and isFlightTaken="yes"';
	$isTransferTaken = ' and isTransferTaken="yes"';
}
if($calculationType!=3){
	$Typepackage = 'and quotationId in (select id from quotationMaster where calculationType!=3 and id="'.$quotationId.'")';
}

$suppQuery = ' id in ( select supplierId from finalQuote where quotationId="'.$quotationId.'" ) or id in ( select supplierId from finalQuotetransfer where quotationId="'.$quotationId.'" and totalPax in ( select id from totalPaxSlab where status = 1 and quotationId = "' . $quotationId . '" ) ) or id in ( select supplierId from finalQuoteEntrance where quotationId="'.$quotationId.'" ) or id in ( select supplierId from finalQuoteFerry where quotationId="'.$quotationId.'" ) or id in ( select supplierId from finalQuoteCruise where quotationId="'.$quotationId.'" ) or id in ( select supplierId from finalQuoteActivity where quotationId="'.$quotationId.'" ) or id in ( select supplierId from finalQuoteTrains where quotationId="'.$quotationId.'" ) or id in ( select supplierId from finalQuoteGuides where quotationId="'.$quotationId.'" )  or id in ( select supplierId from finalQuoteExtra where quotationId="'.$quotationId.'")  or id in ( select supplierId from finalQuoteMealPlan where quotationId="'.$quotationId.'" )  or id in ( select supplierId from finalQuoteEnroute where quotationId="'.$quotationId.'")  or id in ( select supplierId from finalQuoteFlights where quotationId="'.$quotationId.'" ) or id in ( select supplierId from finalQuoteVisa where quotationId="'.$quotationId.'") or id in ( select supplierId from finalQuotePassport where quotationId="'.$quotationId.'" ) or id in ( select supplierId from finalQuoteInsurance where quotationId="'.$quotationId.'")  or id in ( select supplierId from finalPackWiseRateMaster where quotationId="'.$quotationId.'" ) ';
$suppSql="";
$uniNum = 1;

$suppSql=GetPageRecord('*','suppliersMaster',$suppQuery); 
while($supplierData=mysqli_fetch_array($suppSql)){ 
	$supplier_num = $supplierData['id'].'_'.++$uniNum; 
	
	// add or update final supplier status
	$suppcf="";
	$suppcf=GetPageRecord('*','finalQuotSupplierStatus','supplierId="'.$supplierData['id'].'" and quotationId="'.$quotationId.'"');
	if(mysqli_num_rows($suppcf)<1){  
		$namevalue ='quotationId="'.$quotationId.'",queryId="'.$queryId.'",supplierId="'.$supplierData['id'].'"';
		$supplierStatusId=addlistinggetlastid('finalQuotSupplierStatus',$namevalue);  

		$isCostShow = 1;
	}else{ 
		$supplierStatusData=mysqli_fetch_array($suppcf);
		$supplierStatusId=$supplierStatusData['id'];
		$update = updatelisting('finalQuotSupplierStatus','deletestatus=0','id="'.$supplierStatusData['id'].'"');

		$isCostShow=$supplierStatusData['isCostShow'];
	}   

	// any this supplier have any service both hotel and others then supplier header should show
	$qIQueryCheck1=''; 
	$qIQueryCheck1=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationId.'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" and totalPax in ( select id from totalPaxSlab where status = 1 and quotationId = "' . $quotationId . '" )) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuote where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteCruise where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" )  or serviceId in ( select id from finalPackWiseRateMaster where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" ) )  order by startDate asc');
	// or id in ( select supplierId from finalPackWiseRateMaster where quotationId="'.$quotationId.'" )
	if(mysqli_num_rows($qIQueryCheck1) > 0){  ?>
		<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
		<thead>
			<tr>  
			<th align="left" bgcolor="#ddd"><strong style="font-size: 10px; color: #649d5c;">Supplier:<br></strong><?php echo stripslashes(trim($supplierData['name'])).' - ['.$supplierData['supplierNumber'].']'; ?></th>
			<th align="left" bgcolor="#ddd"><strong style="font-size: 10px; color: #649d5c;">Payment&nbsp;Terms: <br></strong><?php echo ($supplierData['paymentTerm'] == 1)?"CASH":"ON CREDIT";?></th>
			<th align="left" bgcolor="#ddd">
			<?php 
			$chkfqQuery="";
			$chkfqQuery=GetPageRecord('*','finalQuote','supplierId="'.$supplierData['id'].'" and quotationId="'.$quotationId.'"');
			if(mysqli_num_rows($chkfqQuery)>0){  
				?>
				<span style=" top: -4px; position: relative; ">Show/Hide Cost&nbsp;:</span>
				<input type="checkbox" id="isCostShow<?php echo $supplierStatusId; ?>" onchange="showHideCost(<?php echo $supplierStatusId; ?>);" value="<?php echo $isCostShow; ?>" style="position:relative;display:inline-block;width: 18px;height: 18px;" <?php if($isCostShow == 1){ ?> checked <?php } ?>>
			<?php } ?>
			</th>
			<th align="right" bgcolor="#ddd">
				<div style="position:relative;display:block;" >
				<a id="sendSuppConfirmation<?php echo $supplier_num; ?>_removed" style="background-color: #1b81ca; color: #FFFFFF !important; width: fit-content; cursor: pointer; padding: 6px 10px; border-radius: 2PX; box-sizing: border-box; float:right; margin-left: 3px;" href="showpage.crm?module=query&view=yes&supplier=1&supplierId=<?php echo encode($supplierData['id']); ?>&quotationId=<?php echo encode($quotationId); ?>&id=<?php echo encode($resultpage['id']); ?>" target="_blank">SEND&nbsp;RESERVATION&nbsp;REQUEST</a> 
			  	
				</div>
			  </th> 
			</tr>
		</thead>
		<tbody> 
		<?php
	} 

	// other service list

	$qIQuery2=''; 
	$qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationId.'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" and totalPax in ( select id from totalPaxSlab where status = 1 and quotationId = "' . $quotationId . '" ) '.$isTransferTaken.' ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteCruise where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$isFlightTaken.' ) or serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') or serviceId in ( select id from finalPackWiseRateMaster where quotationId="'.$quotationId.'" and supplierId="'.$supplierData['id'].'" '.$Typepackage.') )  order by startDate asc');

	if(mysqli_num_rows($qIQuery2) > 0){ 
	while($finalIt_Data2=mysqli_fetch_array($qIQuery2)){  

		$srntag=""; 
		if($finalIt_Data2['serviceType'] == 'transfer' || $finalIt_Data2['serviceType'] == 'transportation'){
			$b=	"";
			$b=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationId.'" and  id="'.$finalIt_Data2['serviceId'].'" and supplierId = "'.$supplierData['id'].'" and totalPax in ( select id from totalPaxSlab where status = 1 and quotationId = "' . $quotationId . '" ) order by fromDate asc');
			while($finalQuotTransData=mysqli_fetch_array($b)){
			$srntag = ++$uniNum.'_'.$finalQuotTransData['id'];
			// hotel data

			$d="";
			$d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$finalQuotTransData['transferId'].'"');   
			$transferData=mysqli_fetch_array($d); 
	  		
			$transferId = $transferData['id'];
	 		
			$Ecity = '';	  
			$Ecity = getDestination($finalQuotTransData['destinationId']);
			
			$transferDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
			
			//check if supplier is self
			$vehicleName = $vehicleType = $trnsferType = '';
			if($finalQuotTransData['transferType'] == 2){

		        $d=GetPageRecord('*','vehicleMaster','id="'.$finalQuotTransData['vehicleModelId'].'"'); 
		        $vehicleData=mysqli_fetch_array($d);

				$vehicleName = $vehicleData['model']." | ";
				$vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
			}
			$trnsferType = ($finalQuotTransData['transferType'] == 1)?'SIC | ':'Private | ';
			?>
			<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:5px; border:1px solid #ccc;position:relative;background-color: #f4f4f4;">
					<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
						<tbody>
						<tr>
						  <td width="50%"  bgcolor="#F4F4F4">
							<input type="hidden" value="<?php echo $finalQuotTransData['id'];?>" id="transferfinalId<?php echo $finalQuotTransData['id']; ?>">
							<input type="hidden" value="<?php echo $transferData['id'];?>" id="transferId<?php echo $finalQuotTransData['id']; ?>">
						  <?php echo ucfirst($finalIt_Data2['serviceType']); ?>:&nbsp;<?php echo $trnsferType.$vehicleType.$vehicleName.strip($transferData['transferName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
						  <td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $transferDates; ?></span></td>
						  <td width="33%" bgcolor="#F4F4F4">
						  <select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" > 
							<option  value="0" <?php if($finalQuotTransData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
							<option  value="2" <?php if($finalQuotTransData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
							<option  value="3" <?php if($finalQuotTransData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
							<option  value="4" <?php if($finalQuotTransData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
							<option  value="5" <?php if($finalQuotTransData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
						 </select>
						 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
							<script>
							function updateFinalQuotStatus<?php echo $srntag; ?>(){
								var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
								if(manualStatus==3){
									$('.serviceConfirmed<?php echo $srntag; ?>').show();
									$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
									//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
								}else{
									$('.serviceConfirmed<?php echo $srntag; ?>').hide();
									$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
									//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
								}
								$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=transfer&serviceId=<?php echo $finalQuotTransData['id']; ?>&manualStatus='+manualStatus);
							}
							<?php if ($finalQuotTransData['manualStatus']==3) { ?>
							//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
							<?php } ?>
							</script>
						</td>
					  </tr>
					  
						<tr>
						  <td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:97.5%;  padding:8px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuotTransData['specialRequest']; ?>" />
						  <div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
								<script>
								function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
									var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
									$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuotTransData['id']; ?>&tableName=finalQuotetransfer&spacialReq='+spacialReq);
								}
							</script></td>
						  </tr>
						  <tr>
							<td colspan="3">
								<tr width="" style="display: flex;width:200%">
									<td style="padding: 1% 2%;">
										<span>Please Choose 1 </span>
										<input type="file" name="transferFile" id="transferFile" onchange="uploadTransferFile();" style="width:100%;padding: 10px;">
										<input type="hidden" value="<?php echo $finalQuotTransData['id']; ?>" id="transferId">
										<!-- <br> -->
									</td>
									<td style="padding: 1% 2%;">
										<span>Please Choose 2</span>
										<input type="file" name="transferFile2" id="transferFile2" onchange="uploadTransferFile2();" style="width:100%;padding: 10px;">
										<input type="hidden" value="<?php echo $finalQuotTransData['id']; ?>" id="transferId">
										<!-- <br> -->
									</td>
									<td style="padding: 1% 2%;">
										<span>Please Choose 3</span>
										<input type="file" name="transferFile3" id="transferFile3" onchange="uploadTransferFile3();" style="width:93%;padding: 10px;">
										<input type="hidden" value="<?php echo $finalQuotTransData['id']; ?>" id="transferId">
									</td>
								</tr>
							</td>
						  </tr>
						  <tr>
							<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
								
								<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;<?php if(strlen($finalQuotTransData['confirmationNo'])>0 ||$finalQuotTransData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
								<table width="100%" >
									<tr >
										<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuotTransData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
										<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuotTransData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotTransData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuotTransData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
										<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuotTransData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotTransData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuotTransData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
										<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuotTransData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
									   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuotTransData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
									   <td bgcolor="#F4F4F4"><?php if($finalQuotTransData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
										</td>
										<td  bgcolor="#F4F4F4">
									   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
									   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
										</td>
									 </tr>
								</table>
								</div>
								<script>
								function updateSupplierConfirmation<?php echo $srntag; ?>(){
									var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
									var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
									var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
									var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
									var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
									var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
									var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
									var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
									var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
									

									if(confirmationNo != '' && confirmationNo != 'NULL'){
										$('#final_frmaction').load('final_frmaction.php?action=transferConfirmation&id=<?php echo $finalQuotTransData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
									}else{
										if(manualStatus ==3){
										alert('Confirmation number is required');
									}
								}
								}
								if('<?php echo $finalQuotTransData['confirmationNo']; ?>'!='' && '<?php echo $finalQuotTransData['manualStatus'];?>'=='3'){
									$('.confirmstatus<?php echo $srntag; ?>').hide();
									$('.confirmstatusdetails<?php echo $srntag; ?>').show();
								} 
								</script>
								<?php  
								if(strlen($finalQuotTransData['confirmationNo'])>0 && $finalQuotTransData['manualStatus']==3){
								 ?>

									<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
									<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
									  <tr>
										<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuotTransData['confirmationNo']; ?></td>
										<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuotTransData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotTransData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuotTransData['confirmationDate'])); } ?></td>
										<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuotTransData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotTransData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuotTransData['cutOffDate'])); } ?></td>
										<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuotTransData['confirmedBy']; ?></td>
										<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuotTransData['confirmedNote']; ?></td>
										<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
									  </tr>
									</table>
									</div>
									<?php 
								} ?>
							</td>
						</tr>  
						</tbody> 
					  </table>
				</div> 	
	
				</td>
			</tr>
			
			<?php
			}  
		}
		?> 

		<?php  
		if($finalIt_Data2['serviceType'] == 'entrance'){
			$b="";
			$b=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'"  group by entranceId order by fromDate asc'); 
			while($finalQuoteEntranceData=mysqli_fetch_array($b)){ 
	
				$srntag = ++$uniNum.'_'.$finalQuoteEntranceData['id'];
	
				$d="";
				$d=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$finalQuoteEntranceData['entranceId'].'"');   
				$entranceData=mysqli_fetch_array($d);
	
				$supplierId = $finalQuoteEntranceData['supplierId'];
	 
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,' id="'.$finalQuoteEntranceData['entranceQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');  
				// $finalQuoteEntranceData=mysqli_fetch_array($rsh); 
	
				$entranceDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				$Ecity = strip($entranceData['entranceCity']);
				
			 	//check if supplier is self
				$vehicleName = $vehicleType = $trnsferType = '';
				if($finalQuoteEntranceData['transferType'] == 2){

			        $d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteEntranceData['vehicleId'].'"'); 
			        $vehicleData=mysqli_fetch_array($d);

					$vehicleName = $vehicleData['model']." | ";
					$vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
				}
				// $trnsferType = ($finalQuoteEntranceData['transferType'] == 1)?'SIC | ':'Private | ';
				if($finalQuoteEntranceData['transferType'] == 1){ $trnsferType = 'SIC | ';
				}elseif($finalQuoteEntranceData['transferType'] == 2){ $trnsferType = 'Private | ';
				}else{ $trnsferType = 'Ticket Only | '; }
				
				?>
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteEntranceData['id'];?>" id="entrancefinalId<?php echo $finalQuoteEntranceData['id']; ?>">
				<input type="hidden" value="<?php echo $entranceData['id'];?>" id="entranceId<?php echo $finalQuoteEntranceData['id']; ?>">

				Entrance:&nbsp;<?php echo $trnsferType.$vehicleType.$vehicleName.strip($entranceData['entranceName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;position: absolute;"><?php echo $entranceDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4"><select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
						 
							<option  value="0" <?php if($finalQuoteEntranceData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
							<option  value="2" <?php if($finalQuoteEntranceData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
							<option  value="3" <?php if($finalQuoteEntranceData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
							<option  value="4" <?php if($finalQuoteEntranceData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
							<option  value="5" <?php if($finalQuoteEntranceData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
						 </select>
						 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
							<script>
							function updateFinalQuotStatus<?php echo $srntag; ?>(){
								var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
								if(manualStatus==3){
									$('.serviceConfirmed<?php echo $srntag; ?>').show();
									$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
									//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
								}else{
									$('.serviceConfirmed<?php echo $srntag; ?>').hide();
									$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
									//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
								}
								$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=entrance&serviceId=<?php echo $finalQuoteEntranceData['id']; ?>&manualStatus='+manualStatus);
							}
							<?php if ($finalQuoteEntranceData['manualStatus']==3) { ?>
							//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
							<?php } ?>
							</script></td>
				</tr>
				<tr>
				<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteEntranceData['specialRequest']; ?>" />
				<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
				var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
				$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteEntranceData['id']; ?>&tableName=finalQuoteEntrance&spacialReq='+spacialReq);
				}
				</script>
				</td> 
				</tr> 
				<tr>
				<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteEntranceData['confirmationNo'])>0 ||$finalQuoteEntranceData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteEntranceData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteEntranceData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteEntranceData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteEntranceData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteEntranceData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteEntranceData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteEntranceData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteEntranceData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteEntranceData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteEntranceData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						
						if(confirmationNo != '' && confirmationNo != 'NULL'){
							$('#final_frmaction').load('final_frmaction.php?action=entranceConfirmation&id=<?php echo $finalQuoteEntranceData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						}
					}
					}
					if('<?php echo $finalQuoteEntranceData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteEntranceData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					} 
					</script>
					<?php  
						if(strlen($finalQuoteEntranceData['confirmationNo'])>0 && $finalQuoteEntranceData['manualStatus']==3){
							?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteEntranceData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteEntranceData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteEntranceData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteEntranceData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteEntranceData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteEntranceData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteEntranceData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteEntranceData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteEntranceData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
					} ?>
				</td>
				</tr>
				</tbody> 
				</table>
				</div> 
				</td>
				</tr>
				
				<?php
			}  
		}  
		?> 

		<?php  
		if($finalIt_Data2['serviceType'] == 'ferry'){
			$b="";
			$b=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'"  group by ferryId order by fromDate asc'); 
			while($finalQuoteFerryData=mysqli_fetch_array($b)){ 
	
				$srntag = ++$uniNum.'_'.$finalQuoteFerryData['id'];
	
				$d="";
				$d=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$finalQuoteFerryData['ferryId'].'"');   
				$ferryServiceData=mysqli_fetch_array($d);
				
				$supplierId = $finalQuoteFerryData['supplierId'];
				$ferryDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				$Ecity = getDestination($finalQuoteFerryData['destinationId']);
				
			 
				?>
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteFerryData['id'];?>" id="ferryfinalId<?php echo $finalQuoteFerryData['id']; ?>">
				<input type="hidden" value="<?php echo $ferryServiceData['id'];?>" id="ferryId<?php echo $finalQuoteFerryData['id']; ?>">

				Ferry:&nbsp;<?php echo strip($ferryServiceData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;position: absolute;"><?php echo $ferryDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4"><select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
						 
							<option  value="0" <?php if($finalQuoteFerryData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
							<option  value="2" <?php if($finalQuoteFerryData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
							<option  value="3" <?php if($finalQuoteFerryData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
							<option  value="4" <?php if($finalQuoteFerryData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
							<option  value="5" <?php if($finalQuoteFerryData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
						 </select>
						 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
							<script>
							function updateFinalQuotStatus<?php echo $srntag; ?>(){
								var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
								if(manualStatus==3){
									$('.serviceConfirmed<?php echo $srntag; ?>').show();
									$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
									//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
								}else{
									$('.serviceConfirmed<?php echo $srntag; ?>').hide();
									$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
									//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
								}
								$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=ferry&serviceId=<?php echo $finalQuoteFerryData['id']; ?>&manualStatus='+manualStatus);
							}
							<?php if ($finalQuoteFerryData['manualStatus']==3) { ?>
							//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
							<?php } ?>
							</script></td>
				</tr>
				<tr>
				<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteFerryData['specialRequest']; ?>" />
				<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
				var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
				$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteFerryData['id']; ?>&tableName=finalQuoteFerry&spacialReq='+spacialReq);
				}
				</script>
				</td> 
				</tr> 
				<tr>
				<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteFerryData['confirmationNo'])>0 ||$finalQuoteFerryData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">PNR No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteFerryData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteFerryData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteFerryData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteFerryData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteFerryData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteFerryData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteFerryData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteFerryData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteFerryData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteFerryData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						
						if(confirmationNo != '' && confirmationNo != 'NULL'){
							$('#final_frmaction').load('final_frmaction.php?action=ferryConfirmation&id=<?php echo $finalQuoteFerryData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						}
					}
					}
					if('<?php echo $finalQuoteFerryData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteFerryData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					} 
					</script>
					<?php  
						if(strlen($finalQuoteFerryData['confirmationNo'])>0 && $finalQuoteFerryData['manualStatus']==3){
							?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteFerryData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteFerryData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteFerryData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteFerryData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteFerryData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteFerryData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteFerryData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteFerryData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteFerryData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
					} ?>
				</td>
				</tr>
				</tbody> 
				</table>
				</div> 
				</td>
				</tr>
				<?php
			}  
		}  
	

		if($finalIt_Data2['serviceType'] == 'cruise'){
			$b="";
			$b=GetPageRecord('*','finalQuoteCruise',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'"  group by cruisePackageId order by fromDate asc'); 
			while($finalQuoteCruiseData=mysqli_fetch_array($b)){ 
	
				$srntag = ++$uniNum.'_'.$finalQuoteCruiseData['id'];
	
				$d="";
				$d=GetPageRecord('*',_CRUISE_MASTER_,' id="'.$finalQuoteCruiseData['cruisePackageId'].'"');   
				$cruiseData=mysqli_fetch_array($d);
	
				$supplierId = $finalQuoteCruiseData['supplierId'];
	 
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,' id="'.$finalQuoteEntranceData['entranceQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');  
				// $finalQuoteEntranceData=mysqli_fetch_array($rsh); 
	
				$entranceDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				$Ecity = getDestination($cruiseData['destinationId']);
				// $autoconfEntrance = makeConfNumber(++$autoConfNum);
				?>
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<?php if($supplierData['confirmationStatus']==6){
					$finalQuoteCruiseData['manualStatus'] = 3;
					?>
				<input type="checkbox" checked="checked" onchange="autoConfirmEntrance<?php echo $srntag; ?>();" value="" id="AutoconfirmEntrance<?php echo $srntag; ?>" style="display: inline-block;" class="autoConfirm"><span class="autoconfirmsup"> Auto Confirmed </span><br><?php }?>
				<input type="hidden" value="<?php echo $finalQuoteCruiseData['id'];?>" id="entrancefinalId<?php echo $finalQuoteCruiseData['id']; ?>">
				<input type="hidden" value="<?php echo $cruiseData['id'];?>" id="entranceId<?php echo $finalQuoteCruiseData['id']; ?>">

				Cruise:&nbsp;<?php echo strip($cruiseData['cruiseName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;position: absolute;"><?php echo $entranceDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4"><select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width: 124px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
						 
							<option  value="0" <?php if($finalQuoteCruiseData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
							<option  value="1" <?php if($finalQuoteCruiseData['manualStatus'] == 1){ ?> selected="selected" <?php } ?> >CANCELLED</option>
							<option  value="2" <?php if($finalQuoteCruiseData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
							<option  value="3" <?php if($finalQuoteCruiseData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRMED</option>
							<option  value="4" <?php if($finalQuoteCruiseData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
							<option  value="5" <?php if($finalQuoteCruiseData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
						 </select>
						 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
							<script>
							function autoConfirmEntrance<?php echo $srntag; ?>(){
								if (!$('#AutoconfirmEntrance<?php echo $srntag; ?>').is(':checked')) {
									$('#confirmationNo<?php echo $srntag; ?>').val('');
							}else{
								$('#confirmationNo<?php echo $srntag; ?>').val('<?php echo $autoconfEntrance; ?>');
							}
							}
							
							function updateFinalQuotStatus<?php echo $srntag; ?>(){
								var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
								if(manualStatus==3){
									$('.serviceConfirmed<?php echo $srntag; ?>').show();
									$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
									//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
								}else{
									$('.serviceConfirmed<?php echo $srntag; ?>').hide();
									$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
									//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
								}
								$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=cruise&serviceId=<?php echo $finalQuoteCruiseData['id']; ?>&manualStatus='+manualStatus);
							}
							<?php if ($supplierData['confirmationStatus']==6) { ?>
							//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
							updateFinalQuotStatus<?php echo $srntag; ?>();
							<?php } ?>
							</script></td>
				</tr>
				<tr>
				<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteCruiseData['specialRequest']; ?>" />
				<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
				var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
				$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteCruiseData['id']; ?>&tableName=finalQuoteCruise&spacialReq='+spacialReq);
				}
				</script>
				</td> 
				</tr> 
				<tr>
				<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteCruiseData['confirmationNo'])>0 ||$finalQuoteCruiseData['manualStatus']==3 || $supplierData['confirmationStatus']==6){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php if($supplierData['confirmationStatus']==6){echo $autoconfEntrance;}else{echo $finalQuoteCruiseData['confirmationNo'];} ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteCruiseData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteCruiseData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteCruiseData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteCruiseData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteCruiseData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteCruiseData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteCruiseData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteCruiseData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteCruiseData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						
						if(confirmationNo != '' && confirmationNo != 'NULL'){
							$('#final_frmaction').load('final_frmaction.php?action=cruiseConfirmation&id=<?php echo $finalQuoteCruiseData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						}
					}
					}
					if('<?php echo $finalQuoteCruiseData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteCruiseData['manualStatus'];?>'=='3' || '<?php echo $finalQuoteCruiseData['confirmationNo']; ?>'!='' && '<?php echo $supplierData['confirmationStatus'];?>'=='6'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					} 
					</script>
					<?php  
						if(strlen($finalQuoteCruiseData['confirmationNo'])>0 && $finalQuoteCruiseData['manualStatus']==3 || strlen($finalQuoteCruiseData['confirmationNo'])>0 && $supplierData['confirmationStatus']==6){
							?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteCruiseData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteCruiseData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteCruiseData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteCruiseData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteCruiseData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteCruiseData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteCruiseData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteCruiseData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteCruiseData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
					} ?>
				</td>
				</tr>
				</tbody> 
				</table>
				</div> 
				</td>
				</tr>
				<?php
			}  
		}  
		?>
		
		<?php  
		if($finalIt_Data2['serviceType'] == 'activity'){
			$b="";
			$b=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" group by activityId order by fromDate asc'); 
			while($finalQuoteActivityData=mysqli_fetch_array($b)){ 
				$srntag = ++$uniNum.'_'.$finalQuoteActivityData['id'];
	
				$d="";
				$d=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.$finalQuoteActivityData['activityId'].'"');   
				$activityData=mysqli_fetch_array($d);
				$activityId = $activityData['id'];
	
			 	$activityDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				 
				$Ecity = strip($activityData['otherActivityCity']);

				$transferType = '';
				if($finalQuoteActivityData['transferType']==1){
					$transferType = 'SIC';
				  }elseif($finalQuoteActivityData['transferType']==2){
					$transferType = 'PVT';
				  }elseif($finalQuoteActivityData['transferType']==3){
					$transferType = 'VIP';
				  }elseif($finalQuoteActivityData['transferType']==4){
					$transferType = 'Ticket Only';
				  }
				//from to     	 
				?> 
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteActivityData['id'];?>" id="activityfinalId<?php echo $finalQuoteActivityData['id']; ?>">
				<input type="hidden" value="<?php echo $activityData['id'];?>" id="activityId<?php echo $finalQuoteActivityData['id']; ?>">
				Sightseeing:&nbsp;<?php echo $transferType.' | '.  strip($activityData['otherActivityName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;position: absolute;"><?php echo $activityDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
					<option  value="0" <?php if($finalQuoteActivityData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
					<option  value="2" <?php if($finalQuoteActivityData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
					<option  value="3" <?php if($finalQuoteActivityData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
					<option  value="4" <?php if($finalQuoteActivityData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
					<option  value="5" <?php if($finalQuoteActivityData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
				 </select>
				 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
					<script>
					function updateFinalQuotStatus<?php echo $srntag; ?>(){
						var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
						if(manualStatus==3){
							$('.serviceConfirmed<?php echo $srntag; ?>').show();
							$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
							//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
						}else{
							$('.serviceConfirmed<?php echo $srntag; ?>').hide();
							$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
 							//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
						}
						$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=activity&serviceId=<?php echo $finalQuoteActivityData['id']; ?>&manualStatus='+manualStatus);
					}
					<?php if ($finalQuoteActivityData['manualStatus']==3) { ?>
					//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					<?php } ?>
					</script>
				</td>
				</tr> 
				<tr>
				<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteActivityData['specialRequest']; ?>" />
				<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
				var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
				$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteActivityData['id']; ?>&tableName=finalQuoteActivity&spacialReq='+spacialReq);
				}
				</script>
				</td> 
				</tr> 
				<tr>
					<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
						<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteActivityData['confirmationNo'])>0 ||$finalQuoteActivityData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
						<table width="100%" >
							<tr >
								<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteActivityData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
							 
								<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteActivityData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteActivityData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteActivityData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
								<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteActivityData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteActivityData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteActivityData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
								<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteActivityData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
							   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteActivityData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
							   <td  bgcolor="#F4F4F4"><?php if($finalQuoteActivityData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
								</td>
								<td  bgcolor="#F4F4F4">
							   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
							   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
								</td>
							 </tr>
						</table>
						</div>
						<script>
						function updateSupplierConfirmation<?php echo $srntag; ?>(){
							var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
							var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
							var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
							var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
							var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
							var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
							var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
							var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
							var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
							if(confirmationNo != '' && confirmationNo != 'NULL'){
								$('#final_frmaction').load('final_frmaction.php?action=activityConfirmation&id=<?php echo $finalQuoteActivityData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
							}else{
								if(manualStatus ==3){
								alert('Confirmation number is required');
							} }
						}
						if('<?php echo $finalQuoteActivityData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteActivityData['manualStatus'];?>'=='3'){
							$('.confirmstatus<?php echo $srntag; ?>').hide();
							$('.confirmstatusdetails<?php echo $srntag; ?>').show();
						} 
						</script>
						<?php  
							if(strlen($finalQuoteActivityData['confirmationNo'])>0 && $finalQuoteActivityData['manualStatus']==3){
							?> 
							<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
							<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
							  <tr>
								<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteActivityData['confirmationNo']; ?></td>
								<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteActivityData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteActivityData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteActivityData['confirmationDate'])); } ?></td>
								<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteActivityData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteActivityData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteActivityData['cutOffDate'])); } ?></td>
								<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteActivityData['confirmedBy']; ?></td>
								<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteActivityData['confirmedNote']; ?></td>
								<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
							  </tr>
							</table>
							</div>
							<?php 
						} ?>
					</td>
				</tr>
				</tbody> 
				</table>
				</div> 
				</td>
				</tr> 
				<?php 
			} 
		}  
		?>
	
		<?php  
		if($finalIt_Data2['serviceType'] == 'train'){
			$b="";
			$b=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuoteTrainData=mysqli_fetch_array($b)){ 
			$srntag = ++$uniNum.'_'.$finalQuoteTrainData['id'];
			$srnNotId=$finalQuoteTrainData['id'];
			$srnNot=1;
			$d="";
			$d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$finalQuoteTrainData['trainId'].'"');   
			$trainData=mysqli_fetch_array($d);
			$trainId = $trainData['id'];
	
			// $rsh="";
			// $rsh=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' id="'.$finalQuoteTrainData['trainQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');  
			// $finalQuoteTrainData=mysqli_fetch_array($rsh); 
	
			 $trainDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
		 
			$Ecity = getDestination($finalQuoteTrainData['destinationId']);		 
			?> 
			<tr>
			<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
			<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
			<tbody>
			<tr>
			<td width="50%"  bgcolor="#F4F4F4">
			<input type="hidden" value="<?php echo $finalQuoteTrainData['id'];?>" id="trainfinalId<?php echo $finalQuoteTrainData['id']; ?>">
			<input type="hidden" value="<?php echo $trainData['id'];?>" id="trainId<?php echo $finalQuoteTrainData['id']; ?>">
			Train:&nbsp;<?php echo strip($trainData['trainName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
			</td>
			<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $trainDates; ?></span></td>
			<td width="33%" bgcolor="#F4F4F4">
			<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
		 
			<option  value="0" <?php if($finalQuoteTrainData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
			<option  value="2" <?php if($finalQuoteTrainData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
			<option  value="3" <?php if($finalQuoteTrainData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
			<option  value="4" <?php if($finalQuoteTrainData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
			<option  value="5" <?php if($finalQuoteTrainData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
		 </select>
		 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
			<script>
			function updateFinalQuotStatus<?php echo $srntag; ?>(){
				var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
				if(manualStatus==3){
					$('.serviceConfirmed<?php echo $srntag; ?>').show();
					$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
					//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				}else{
					$('.serviceConfirmed<?php echo $srntag; ?>').hide();
					$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
					//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
				}
				$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=train&serviceId=<?php echo $finalQuoteTrainData['id']; ?>&manualStatus='+manualStatus);
			}
			<?php if ($finalQuoteTrainData['manualStatus']==3) { ?>
			//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
			<?php } ?>
			</script>
			</td>
			</tr>
			<tr>
			<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteTrainData['specialRequest']; ?>" />
			<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
			<script>
			function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
			var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
			$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteTrainData['id']; ?>&tableName=finalQuoteTrains&spacialReq='+spacialReq);
			}
			</script>
			</td> 
			</tr> 
			<tr>
				<td colspan="3">
					<tr width="" style="display: flex;width:200%">
						<td style="padding: 1% 2%;">
							<span>Please Choose 1</span>
							<input type="file" accept="image/*" name="trainFile" id="trainFile" onchange="uploadTrainFile();" style="width:100% ;padding: 10px;">
							<input type="hidden" name="trainId" id="trainId" value="<?php echo $finalQuoteTrainData['id']; ?>">
							<br>
						</td>
						<td style="padding: 1% 2%;">
							<span>Please Choose 2</span>
							<input type="file" accept="image/*" name="trainFile2" id="trainFile2" onchange="uploadTrainFile2();" style="width:100%;padding: 10px;">
							<input type="hidden" name="trainId" id="trainId" value="<?php echo $finalQuoteTrainData['id']; ?>">
							<br>
						</td>
						<td style="padding: 1% 2%;">
							<span>Please Choose 3</span>
							<input type="file" accept="image/*" name="trainFile3" id="trainFile3" onchange="uploadTrainFile3();" style="width:93%;padding: 10px;">
							<input type="hidden" name="trainId" id="trainId" value="<?php echo $finalQuoteTrainData['id']; ?>">
						</td>
					</tr>
				</td>
			</tr>
			<tr>
			<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
				<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteTrainData['confirmationNo'])>0 ||$finalQuoteTrainData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
				<table width="100%" id="trainMultiDetails<?php echo $srntag ?>">
					<tr >

						<!--started  train new field adde pnr no. and confirmation no -->

						<td  bgcolor="#F4F4F4"><label for="trTitle<?php echo $srnNot; ?>" style="font-size:12px;">Title</label><input  type="text" class="gridfield" id="trTitle<?php echo $srnNot; ?>"  value="<?php echo $finalQuoteTrainData['trTitle']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trfname<?php echo $srnNot; ?>" style="font-size:12px;">First Name</label><input  type="text" class="gridfield" id="trfname<?php echo $srnNot; ?>"  value="<?php echo $finalQuoteTrainData['trfname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trmname<?php echo $srnNot; ?>" style="font-size:12px;">Middle Name</label><input  type="text" class="gridfield" id="trmname<?php echo $srnNot; ?>"  value="<?php echo $finalQuoteTrainData['trmname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trlname<?php echo $srnNot; ?>" style="font-size:12px;">Last Name</label><input  type="text" class="gridfield" id="trlname<?php echo $srnNot; ?>"  value="<?php echo $finalQuoteTrainData['trlname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>


						<td  bgcolor="#F4F4F4"><label for="trgender<?php echo $srnNot; ?>" style="font-size:12px;">Gender</label><input  type="text" class="gridfield" id="trgender<?php echo $srnNot; ?>"  value="<?php echo $finalQuoteTrainData['trgender']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trpnrno<?php echo $srnNot; ?>" style="font-size:12px;">PNR No.</label><input  type="text" class="gridfield" id="trpnrno<?php echo $srnNot; ?>"  value="<?php echo $finalQuoteTrainData['trpnrno']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<!--ended  train new field adde pnr no. and confirmation no -->

						<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srnNot; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srnNot; ?>"  value="<?php echo $finalQuoteTrainData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

					 	<td><i class="fa fa-plus" onclick="createTrainMultiRow<?php echo $srntag; ?>();" style="margin-top: 15px;padding-left: 6px;cursor:pointer;"></i></td>

						<td style="display: none;" align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteTrainData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteTrainData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteTrainData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
						<td style="display: none;"  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteTrainData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteTrainData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteTrainData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
						<td style="display: none;" align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteTrainData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
					   <td style="display: none;" bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteTrainData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
					   <td  bgcolor="#F4F4F4"><?php if($finalQuoteTrainData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
						</td>
						<td  bgcolor="#F4F4F4">
					   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
					   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
						</td>
					 </tr>
					 <?php 
					  $rsst='';
					 $rsst = GetPageRecord('*','trainMultiDetailMaster','quotationId="'.$finalQuoteTrainData['quotationId'].'" and parentId="'.$finalQuoteTrainData['id'].'" and srn!=1');
					 if(mysqli_num_rows($rsst)>0){
						while($trainmultData = mysqli_fetch_assoc($rsst)){
					 
					 ?>
					 <tr >

						<!--started  train new field adde pnr no. and confirmation no -->

						<td  bgcolor="#F4F4F4"><label for="trTitle<?php echo $srnNot; ?>" style="font-size:12px;">Title</label><input  type="text" class="gridfield" id="trTitle<?php echo $srnNot; ?>"  value="<?php echo $trainmultData['title']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trfname<?php echo $srnNot; ?>" style="font-size:12px;">First Name</label><input  type="text" class="gridfield" id="trfname<?php echo $srnNot; ?>"  value="<?php echo $trainmultData['firstName']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trmname<?php echo $srnNot; ?>" style="font-size:12px;">Middle Name</label><input  type="text" class="gridfield" id="trmname<?php echo $srnNot; ?>"  value="<?php echo $trainmultData['middleName']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trlname<?php echo $srnNot; ?>" style="font-size:12px;">Last Name</label><input  type="text" class="gridfield" id="trlname<?php echo $srnNot; ?>"  value="<?php echo $trainmultData['lastName']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>


						<td  bgcolor="#F4F4F4"><label for="trgender<?php echo $srnNot; ?>" style="font-size:12px;">Gender</label><input  type="text" class="gridfield" id="trgender<?php echo $srnNot; ?>"  value="<?php echo $trainmultData['gender']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trpnrno<?php echo $srnNot; ?>" style="font-size:12px;">PNR No.</label><input  type="text" class="gridfield" id="trpnrno<?php echo $srnNot; ?>"  value="<?php echo $trainmultData['pnrNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<!--ended  train new field adde pnr no. and confirmation no -->

						<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srnNot; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srnNot; ?>"  value="<?php echo $trainmultData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
					</tr>
					<?php } } ?>
				</table>

				<input type="hidden" name="srntagt2" id="srntagt2" value="<?php echo $srnNot+1; ?>">
						<script>
							function createTrainMultiRow<?php echo $srntag; ?>(){
								
								var srntag = $('#srntagt2').val();
								
								srnno = parseInt(srntag)+1;
								$('#srntagt2').val(parseInt(srntag, 10)+1);
								$("#trainMultiDetails<?php echo $srntag ?>").append(`<tr>
						
						<td  bgcolor="#F4F4F4"><label for="trTitle${srntag}" style="font-size:12px;">Title</label><input  type="text" class="gridfield" id="trTitle${srntag}"  value="<?php echo $finalQuoteTrainData['trTitle']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trfname${srntag}" style="font-size:12px;">First Name</label><input  type="text" class="gridfield" id="trfname${srntag}"  value="<?php echo $finalQuoteTrainData['trfname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trmname${srntag}" style="font-size:12px;">Middle Name</label><input  type="text" class="gridfield" id="trmname${srntag}"  value="<?php echo $finalQuoteTrainData['trmname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trlname${srntag}" style="font-size:12px;">Last Name</label><input  type="text" class="gridfield" id="trlname${srntag}"  value="<?php echo $finalQuoteTrainData['trlname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>


						<td  bgcolor="#F4F4F4"><label for="trgender${srntag}" style="font-size:12px;">Gender</label><input  type="text" class="gridfield" id="trgender${srntag}"  value="<?php echo $finalQuoteTrainData['trgender']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<td  bgcolor="#F4F4F4"><label for="trpnrno${srntag}" style="font-size:12px;">PNR No.</label><input  type="text" class="gridfield" id="trpnrno${srntag}"  value="<?php echo $finalQuoteTrainData['trpnrno']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

						<!--ended  train new field adde pnr no. and confirmation no -->

						<td  bgcolor="#F4F4F4"><label for="confirmationNo${srntag}" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo${srntag}"  value="<?php echo $finalQuoteTrainData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td></tr>`);
							
							}
						</script>

				</div>
				<script>
				function updateSupplierConfirmation<?php echo $srntag; ?>(){

					var srn = $("#srntagt2").val();
						for(i=1; i<srn; i++){

					var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
					var confirmationNo = encodeURI($('#confirmationNo'+i).val());

					// train detail
					// trTitle,trfname,trmname,trlname,trgender,trpnrno


					var trTitle = encodeURI($('#trTitle'+i).val());
					var trfname = encodeURI($('#trfname'+i).val());
					var trmname = encodeURI($('#trmname'+i).val());
					var trlname = encodeURI($('#trlname'+i).val());
					var trgender = encodeURI($('#trgender'+i).val());
					var trpnrno = encodeURI($('#trpnrno'+i).val());


					var confirmationDate = encodeURI($('#confirmationDate'+i).val());
					var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
					var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
					var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
					var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
					var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
					var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
					
				
						
					if(confirmationNo != '' && confirmationNo != 'NULL'){ 
						$('#final_frmaction').load('final_frmaction.php?action=trainConfirmation&id=<?php echo $finalQuoteTrainData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&trTitle='+trTitle+'&trfname='+trfname+'&trmname='+trmname+'&trlname='+trlname+'&trgender='+trgender+'&trpnrno='+trpnrno+'&cutOffDate='+cutOffDate+'&msgType='+msgType+'&loopNo='+i+'&quotationId=<?php echo $finalQuoteTrainData['quotationId'] ?>');
					}else{
						if(manualStatus ==3){
						alert('Confirmation number is required');
					} }
				}
			}
				if('<?php echo $finalQuoteTrainData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteTrainData['manualStatus'];?>'=='3'){
					$('.confirmstatus<?php echo $srntag; ?>').hide();
					$('.confirmstatusdetails<?php echo $srntag; ?>').show();
				} 
				</script>
				<?php  
				if(strlen($finalQuoteTrainData['confirmationNo'])>0 && $finalQuoteTrainData['manualStatus']==3){
				?>
					<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
					<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
					  <tr>
						<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteTrainData['confirmationNo']; ?></td>
						<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteTrainData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteTrainData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteTrainData['confirmationDate'])); } ?></td>
						<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteTrainData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteTrainData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteTrainData['cutOffDate'])); } ?></td>
						<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteTrainData['confirmedBy']; ?></td>
						<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteTrainData['confirmedNote']; ?></td>
						<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
					  </tr>
					</table>
					</div>
					<?php 
				} ?>
			</td>
			</tr>
			</tbody> 
			</table>
			</div> 
			</td>
			</tr> 
			<?php
			}  
		}
		?>

		<?php  
		if($finalIt_Data2['serviceType'] == 'guide'){
			$b="";
			$b=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationId.'" and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuoteGuideData=mysqli_fetch_array($b)){ 
				$srntag = ++$uniNum.'_'.$finalQuoteGuideData['id'];
	
				$d="";
				$d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$finalQuoteGuideData['guideId'].'"');   
				$guideData=mysqli_fetch_array($d);
				$guideId = $guideData['id'];
	
	
				 $guideDates = date('d M, Y',strtotime($finalIt_Data2['startDate'])); 
				 
				$Ecity = getDestination($finalQuoteGuideData['destinationId']);
	
				 
				?> 
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteGuideData['id'];?>" id="guidefinalId<?php echo $finalQuoteGuideData['id']; ?>">
				<input type="hidden" value="<?php echo $guideData['id'];?>" id="guideId<?php echo $finalQuoteGuideData['id']; ?>">
				<?php if($finalQuoteGuideData['serviceType'] ==1){ echo "Porter";}else{ echo "Guide"; } ?>:&nbsp;<?php echo strip($guideData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $guideDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
		 
				<option  value="0" <?php if($finalQuoteGuideData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalQuoteGuideData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalQuoteGuideData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalQuoteGuideData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalQuoteGuideData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=guide&serviceId=<?php echo $finalQuoteGuideData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalQuoteGuideData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
				<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteGuideData['specialRequest']; ?>" />
				<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
				var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
				$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteGuideData['id']; ?>&tableName=finalQuoteGuides&spacialReq='+spacialReq);
				}
				</script>
				</td> 
				</tr> 
				<tr>
				<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteGuideData['confirmationNo'])>0 ||$finalQuoteGuideData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteGuideData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteGuideData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteGuideData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteGuideData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteGuideData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteGuideData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteGuideData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteGuideData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteGuideData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4">
								<?php if($finalQuoteGuideData['confirmationNo'] !=''){ ?>
								<input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/>
								<?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
								<input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
								<input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						if(confirmationNo != '' && confirmationNo != 'NULL'){ 
							$('#final_frmaction').load('final_frmaction.php?action=guideConfirmation&id=<?php echo $finalQuoteGuideData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
					if('<?php echo $finalQuoteGuideData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteGuideData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					} 
					</script>
					<?php  
					if(strlen($finalQuoteGuideData['confirmationNo'])>0 && $finalQuoteGuideData['manualStatus']==3){
					?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteGuideData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteGuideData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteGuideData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteGuideData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteGuideData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteGuideData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteGuideData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteGuideData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteGuideData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
					} 
					?>
				</td>
				</tr> 
				</tbody> 
				</table>
				</div> 
				</td>
				</tr>
				<?php
			}  
		}
		?>
	
		<?php
		if($finalIt_Data2['serviceType'] == 'mealplan'){
			$b="";
			$b=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationId.'" and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuoteMealData=mysqli_fetch_array($b)){ 
	
				$srntag = ++$uniNum.'_'.$finalQuoteMealData['id'];
	
				$supplierId = $finalQuoteMealData['supplierId'];
	 
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' id="'.$finalQuoteMealData['mealplanQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');  
				// $finalQuoteMealData=mysqli_fetch_array($rsh); 
	
				$entranceDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
			 
				?>
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteMealData['id'];?>" id="mealfinalId<?php echo $finalQuoteMealData['id']; ?>">
				<input type="hidden" value="<?php echo $finalQuoteMealData['mealPlanName'];?>" id="mealId<?php echo $finalQuoteMealData['id']; ?>">
				Restaurant:&nbsp;<?php echo strip($finalQuoteMealData['mealPlanName']);  ?>			  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $entranceDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
				 
				<option  value="0" <?php if($finalQuoteMealData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalQuoteMealData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalQuoteMealData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalQuoteMealData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalQuoteMealData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=mealPlan&serviceId=<?php echo $finalQuoteMealData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalQuoteMealData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
				<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteMealData['specialRequest']; ?>" />
				<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
				var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
				$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteMealData['id']; ?>&tableName=finalQuoteMealPlan&spacialReq='+spacialReq);
				}
				</script>
				</td> 
				</tr> 
				<tr>
				<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteMealData['confirmationNo'])>0 ||$finalQuoteMealData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteMealData['confirmationNo'];  ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteMealData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteMealData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteMealData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteMealData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteMealData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteMealData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteMealData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteMealData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteMealData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						if(confirmationNo != '' && confirmationNo != 'NULL'){
							$('#final_frmaction').load('final_frmaction.php?action=mealPlanConfirmation&id=<?php echo $finalQuoteMealData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
					if('<?php echo $finalQuoteMealData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteMealData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					} 
					</script>
					<?php  
					if(strlen($finalQuoteMealData['confirmationNo'])>0 && $finalQuoteMealData['manualStatus']==3){
					?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteMealData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteMealData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteMealData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteMealData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteMealData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteMealData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteMealData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteMealData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteMealData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
					} ?>
				</td>
				</tr>
				</tbody> 
				</table>
				</div> 
				</td>
				</tr>
				
				<?php
			}  
		}
		?>
	
		<?php
		if($finalIt_Data2['serviceType'] == 'additional'){ 
			$b="";
			$b=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationId.'" and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuoteAdditionalData=mysqli_fetch_array($b)){ 
	
				$srntag = ++$uniNum.'_'.$finalQuoteAdditionalData['id'];
	
				$d="";
				$d=GetPageRecord('*','extraQuotation',' id="'.$finalQuoteAdditionalData['additionalId'].'"');   
				$additionalData=mysqli_fetch_array($d);
	
				$supplierId = $finalQuoteAdditionalData['supplierId'];
	
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' id="'.$finalQuoteAdditionalData['additionalQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');  
				// $finalQuoteAdditionalData=mysqli_fetch_array($rsh); 
	
				$entranceDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				$Ecity = getDestination($finalQuoteAdditionalData['destinationId']);	
			 
				?>
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteAdditionalData['id'];?>" id="entrancefinalId<?php echo $finalQuoteAdditionalData['id']; ?>">
				<input type="hidden" value="<?php echo $additionalData['id'];?>" id="additionalId<?php echo $finalQuoteAdditionalData['id']; ?>">
				Additional:&nbsp;<?php echo ucfirst($additionalData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $entranceDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
			 
				<option  value="0" <?php if($finalQuoteAdditionalData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalQuoteAdditionalData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalQuoteAdditionalData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalQuoteAdditionalData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalQuoteAdditionalData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=additional&serviceId=<?php echo $finalQuoteAdditionalData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalQuoteAdditionalData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
				<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteAdditionalData['specialRequest']; ?>" />
				<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
				var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
				$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteAdditionalData['id']; ?>&tableName=finalQuoteExtra&spacialReq='+spacialReq);
				}
				</script>
				</td> 
				</tr> 
				<tr>
				<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteAdditionalData['confirmationNo'])>0 ||$finalQuoteAdditionalData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteAdditionalData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteAdditionalData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteAdditionalData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteAdditionalData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteAdditionalData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteAdditionalData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteAdditionalData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteAdditionalData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteAdditionalData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteAdditionalData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						
						if(confirmationNo != '' && confirmationNo != 'NULL'){
							$('#final_frmaction').load('final_frmaction.php?action=additionalConfirmation&id=<?php echo $finalQuoteAdditionalData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
					if('<?php echo $finalQuoteAdditionalData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteAdditionalData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					} 
					</script>
					<?php  
					if(strlen($finalQuoteAdditionalData['confirmationNo'])>0 && $finalQuoteAdditionalData['manualStatus']==3){
					?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteAdditionalData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteAdditionalData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteAdditionalData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteAdditionalData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteAdditionalData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteAdditionalData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteAdditionalData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteAdditionalData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteAdditionalData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
					} ?>
				</td>
				</tr>
				</tbody> 
				</table>
				</div> 
				</td>
				</tr>
				
				<?php
			}  
		}
		?>
		
		<?php
		if($finalIt_Data2['serviceType'] == 'enroute'){  
			$b="";
			$b=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$quotationId.'" and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuoteEnrouteData=mysqli_fetch_array($b)){ 
	
				$srntag = ++$uniNum.'_'.$finalQuoteEnrouteData['id'];
	
				$d="";
				$d=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$finalQuoteEnrouteData['enrouteId'].'"');   
				$enrouteData=mysqli_fetch_array($d);
	
				$supplierId = $finalQuoteEnrouteData['supplierId'];
	
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,' id="'.$finalQuoteEnrouteData['enrouteQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');  
				// $finalQuoteEnrouteData=mysqli_fetch_array($rsh); 
	
				$entranceDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				$Ecity = getDestination($finalQuoteEnrouteData['destinationId']);	
			 
				?>
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteEnrouteData['id'];?>" id="entrancefinalId<?php echo $finalQuoteEnrouteData['id']; ?>">
				<input type="hidden" value="<?php echo $enrouteData['id'];?>" id="enrouteId<?php echo $finalQuoteEnrouteData['id']; ?>">
				Enroute:&nbsp;<?php echo strip($enrouteData['enrouteName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $entranceDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
			 
				<option  value="0" <?php if($finalQuoteEnrouteData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalQuoteEnrouteData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalQuoteEnrouteData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalQuoteEnrouteData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalQuoteEnrouteData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=enroute&serviceId=<?php echo $finalQuoteEnrouteData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalQuoteEnrouteData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
				<td colspan="3"  bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteEnrouteData['specialRequest']; ?>" />
				<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
				var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
				$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteEnrouteData['id']; ?>&tableName=finalQuoteEnroute&spacialReq='+spacialReq);
				}
				</script>
				</td> 
				</tr> 
				<tr>
				<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteEnrouteData['confirmationNo'])>0 ||$finalQuoteEnrouteData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteEnrouteData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteEnrouteData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteEnrouteData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteEnrouteData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteEnrouteData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteEnrouteData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteEnrouteData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteEnrouteData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteEnrouteData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteEnrouteData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						
						if(confirmationNo != '' && confirmationNo != 'NULL'){
							$('#final_frmaction').load('final_frmaction.php?action=enrouteConfirmation&id=<?php echo $finalQuoteEnrouteData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
					if('<?php echo $finalQuoteEnrouteData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteEnrouteData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					} 
					</script>
					<?php  
					if(strlen($finalQuoteEnrouteData['confirmationNo'])>0 && $finalQuoteEnrouteData['manualStatus']==3){
						?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteEnrouteData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteEnrouteData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteEnrouteData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteEnrouteData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteEnrouteData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteEnrouteData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteEnrouteData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteEnrouteData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteEnrouteData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
					} ?>
				</td>
				</tr>
				</tbody> 
				</table>
				</div> 
				</td>
				</tr> 
				<?php
			}   
		}
		?>
	
		<?php
		if($finalIt_Data2['serviceType'] == 'flight'){
			$b="";
			$b=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuoteFlightData=mysqli_fetch_array($b)){
				$srntag = ++$uniNum.'_'.$finalQuoteFlightData['id'];
				$srnNo=1;
				$d="";
				$d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$finalQuoteFlightData['flightId'].'"');
				$flightData=mysqli_fetch_array($d);
				$flightId = $flightData['id'];
	
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' id="'.$finalQuoteFlightData['flightQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');
				// $finalQuoteFlightData=mysqli_fetch_array($rsh); 
	
				 $flightDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				 
				$Ecity = getDestination($finalQuoteFlightData['destinationId']);		 
		 
			?> 
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteFlightData['id'];?>" id="flightfinalId<?php echo $finalQuoteFlightData['id']; ?>">
				<input type="hidden" value="<?php echo $flightData['id'];?>" id="flightId<?php echo $finalQuoteFlightData['id']; ?>">
				Flight:&nbsp;<?php echo strip($flightData['flightName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
				</td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $flightDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
				 
				<option  value="0" <?php if($finalQuoteFlightData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalQuoteFlightData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalQuoteFlightData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalQuoteFlightData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalQuoteFlightData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=flight&serviceId=<?php echo $finalQuoteFlightData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalQuoteFlightData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
					<td colspan="3"  bgcolor="#F4F4F4">
						<input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteFlightData['specialRequest']; ?>" />
						<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
						<script>
						function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
							var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
							$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteFlightData['id']; ?>&tableName=finalQuoteFlights&spacialReq='+spacialReq);
						}
						</script>
					</td> 
				</tr> 
				<tr>
				<td colspan="3">
					<tr width="" style="display: flex;width:200%">
						<td style="padding: 1% 2%;">
							<span>Please Choose 1</span>
							<input type="file" accept="image/*" name="flightFile" id="flightFile" onchange="uploadFlightFile('<?php echo $srntag; ?>');" style="width:100%;padding: 10px;">
							<input type="hidden" name="flightId" id="flightId" value="<?php echo $finalQuoteFlightData['id']; ?>">
							<!-- <br> -->
						</td>
						<td style="padding: 1% 2%;">
							<s<span>Please Choose 2</span>
							<input type="file" accept="image/*" name="flightFile2" id="flightFile2" onchange="uploadFlightFile2('<?php echo $srntag; ?>');" style="width:98%;padding: 10px;">
							<input type="hidden" name="flightId" id="flightId" value="<?php echo $finalQuoteFlightData['id']; ?>">
							<!-- <br> -->
						</td>
						<td style="padding: 1% 2%;">
							<span>Please Choose 3</span>
							<input type="file" accept="image/*" name="flightFile3" id="flightFile3" onchange="uploadFlightFile3('<?php echo $srntag; ?>');" style="width:93%;padding: 10px;">
							<input type="hidden" name="flightId" id="flightId" value="<?php echo $finalQuoteFlightData['id']; ?>">
						</td>
					</tr>
				</td>
				</tr>
				<tr>
					<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteFlightData['confirmationNo'])>0 ||$finalQuoteFlightData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?> serviceConfirmed<?php echo $srntag;?>">

					<table width="100%" id="multiDetails<?php echo $srntag; ?>">
						<tr>
							<!--started  Flight new field adde pnr no. and confirmation no -->
							<td  bgcolor="#F4F4F4"><label for="ftTitle<?php echo $srnNo; ?>" style="font-size:12px;">Title</label><input  type="text" class="gridfield" id="ftTitle<?php echo $srnNo; ?>"  value="<?php echo $finalQuoteFlightData['ftTitle']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftfname<?php echo $srnNo; ?>" style="font-size:12px;">First Name</label><input  type="text" class="gridfield" id="ftfname<?php echo $srnNo; ?>"  value="<?php echo $finalQuoteFlightData['ftfname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftmname<?php echo $srnNo; ?>" style="font-size:12px;">Middle Name</label><input  type="text" class="gridfield" id="ftmname<?php echo $srnNo; ?>"  value="<?php echo $finalQuoteFlightData['ftmname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftlname<?php echo $srnNo; ?>" style="font-size:12px;">Last Name</label><input  type="text" class="gridfield" id="ftlname<?php echo $srnNo; ?>"  value="<?php echo $finalQuoteFlightData['ftlname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>


							<td  bgcolor="#F4F4F4"><label for="ftgender<?php echo $srnNo; ?>" style="font-size:12px;">Gender</label><input  type="text" class="gridfield" id="ftgender<?php echo $srnNo; ?>"  value="<?php echo $finalQuoteFlightData['ftgender']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftpnrno<?php echo $srnNo; ?>" style="font-size:12px;">PNR No.</label><input  type="text" class="gridfield" id="ftpnrno<?php echo $srnNo; ?>"  value="<?php echo $finalQuoteFlightData['ftpnrno']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<!--ended  Flight new field adde pnr no. and confirmation no -->


							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srnNo; ?>" style="font-size:12px;">*Ticket No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srnNo; ?>"  value="<?php echo $finalQuoteFlightData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td><i class="fa fa-plus" onclick="createFlightMultiRow<?php echo $srntag; ?>(srntag);" style="margin-top: 15px;padding-left: 6px;cursor:pointer;"></i></td>
						 
							<td style="display:none;" align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteFlightData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteFlightData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteFlightData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td style="display:none;"  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteFlightData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteFlightData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteFlightData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td style="display:none;" align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteFlightData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td style="display:none;" bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteFlightData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteFlightData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(<?php echo $srnNo; ?>); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					
					<?php 
						$rss='';
						$rss = GetPageRecord('*','flightMultiDetailMaster','quotationId="'.$finalQuoteFlightData['quotationId'].'" and parentId="'.$finalQuoteFlightData['id'].'" and srn!=1');
						if(mysqli_num_rows($rss)>0){
							while( $flightMultiData = mysqli_fetch_assoc($rss)){

							?>
								<tr>
							<!--started  Flight new field adde pnr no. and confirmation no -->
							<td  bgcolor="#F4F4F4"><label for="ftTitle<?php echo $srnNo; ?>" style="font-size:12px;">Title</label><input  type="text" class="gridfield" id="ftTitle<?php echo $srnNo; ?>"  value="<?php echo $flightMultiData['title']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftfname<?php echo $srnNo; ?>" style="font-size:12px;">First Name</label><input  type="text" class="gridfield" id="ftfname<?php echo $srnNo; ?>"  value="<?php echo $flightMultiData['firstName']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftmname<?php echo $srnNo; ?>" style="font-size:12px;">Middle Name</label><input  type="text" class="gridfield" id="ftmname<?php echo $srnNo; ?>"  value="<?php echo $flightMultiData['middleName']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftlname<?php echo $srnNo; ?>" style="font-size:12px;">Last Name</label><input  type="text" class="gridfield" id="ftlname<?php echo $srnNo; ?>"  value="<?php echo $flightMultiData['lastName']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>


							<td  bgcolor="#F4F4F4"><label for="ftgender<?php echo $srnNo; ?>" style="font-size:12px;">Gender</label><input  type="text" class="gridfield" id="ftgender<?php echo $srnNo; ?>"  value="<?php echo $flightMultiData['gender']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftpnrno<?php echo $srnNo; ?>" style="font-size:12px;">PNR No.</label><input  type="text" class="gridfield" id="ftpnrno<?php echo $srnNo; ?>"  value="<?php echo $flightMultiData['pnrNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<!--ended  Flight new field adde pnr no. and confirmation no -->


							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srnNo; ?>" style="font-size:12px;">*Ticket No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srnNo; ?>"  value="<?php echo $flightMultiData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						</tr>
							<?php
							}
						}
					?>
					</table>
					<input type="hidden" name="srntag" id="srntag" value="<?php echo $srnNo+1; ?>">
						<script>
							function createFlightMultiRow<?php echo $srntag; ?>(){
								
								var srntag = $('#srntag').val();
								
								srnno = parseInt(srntag)+1;
								$('#srntag').val(parseInt(srntag, 10)+1);
								$("#multiDetails<?php echo $srntag; ?>").append(`<tr>
						
							<td  bgcolor="#F4F4F4"><label for="ftTitle${srntag}" style="font-size:12px;">Title</label><input  type="text" class="gridfield" id="ftTitle${srntag}"  value="<?php echo $finalQuoteTrainData['ftTitle']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftfname${srntag}" style="font-size:12px;">First Name</label><input  type="text" class="gridfield" id="ftfname${srntag}"  value="<?php echo $finalQuoteTrainData['ftfname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftmname${srntag}" style="font-size:12px;">Middle Name</label><input  type="text" class="gridfield" id="ftmname${srntag}"  value="<?php echo $finalQuoteTrainData['ftmname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftlname${srntag}" style="font-size:12px;">Last Name</label><input  type="text" class="gridfield" id="ftlname${srntag}"  value="<?php echo $finalQuoteTrainData['ftlname']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftgender${srntag}" style="font-size:12px;">Gender</label><input  type="text" class="gridfield" id="ftgender${srntag}"  value="<?php echo $finalQuoteTrainData['ftgender']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="ftpnrno${srntag}" style="font-size:12px;">PNR No.</label><input  type="text" class="gridfield" id="ftpnrno${srntag}"  value="<?php echo $finalQuoteTrainData['ftpnrno']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>

							<td  bgcolor="#F4F4F4"><label for="confirmationNo${srntag}" style="font-size:12px;">*Ticket No:</label><input  type="text" class="gridfield" id="confirmationNo${srntag}"  value="<?php echo $finalQuoteFlightData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td></tr>`);
							
							}
						</script>

					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var srn = $("#srntag").val();
						for(i=1; i<srn; i++){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo'+i).val());
						var confirmationDate = encodeURI($('#confirmationDate'+i).val());

						// train detail
						// ftTitle,ftfname,ftmname,ftlname,ftgender,ftpnrno

						var ftTitle = encodeURI($('#ftTitle'+i).val());
						var ftfname = encodeURI($('#ftfname'+i).val());
						var ftmname = encodeURI($('#ftmname'+i).val());
						var ftlname = encodeURI($('#ftlname'+i).val());
						var ftgender = encodeURI($('#ftgender'+i).val());
						var ftpnrno = encodeURI($('#ftpnrno'+i).val());

						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						if(confirmationNo!= '' && confirmationNo!= 'NULL'){ 
							$('#final_frmaction').load('final_frmaction.php?action=flightConfirmation&id=<?php echo $finalQuoteFlightData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&ftTitle='+ftTitle+'&ftfname='+ftfname+'&ftmname='+ftmname+'&ftlname='+ftlname+'&ftgender='+ftgender+'&ftpnrno='+ftpnrno+'&cutOffDate='+cutOffDate+'&msgType='+msgType+'&loopNo='+i+'&quotationId=<?php echo $finalQuoteFlightData['quotationId'] ?>');
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
				}
					if('<?php echo $finalQuoteFlightData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteFlightData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					}  
					</script>
					<?php  
					if(strlen($finalQuoteFlightData['confirmationNo'])>0 && $finalQuoteFlightData['manualStatus']==3){
					?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Ticket&nbsp;No:</b><br><?php echo $finalQuoteFlightData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteFlightData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteFlightData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteFlightData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteFlightData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteFlightData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteFlightData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteFlightData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteFlightData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
						} ?>
					</td>
				</tr> 
			</tbody> 
			</table>
			</div> 
	
			</td>
			</tr>
			
			<?php
			}  
		}
		?>

		<?php
		if($finalIt_Data2['serviceType'] == 'visa'){
			$b="";
			$b=GetPageRecord('*','finalQuoteVisa',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuoteVisaData=mysqli_fetch_array($b)){
				$srntag = ++$uniNum.'_'.$finalQuoteVisaData['id'];
	
				$d="";
				$d=GetPageRecord('*',_VISA_COST_MASTER_,' id="'.$finalQuoteVisaData['visaNameId'].'"');
				$visaData=mysqli_fetch_array($d);
				$visaId = $visaData['id'];
	
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' id="'.$finalQuoteVisaData['flightQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');
				// $finalQuoteVisaData=mysqli_fetch_array($rsh); 
	
				 $visaDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				 
				$Ecity = getDestination($finalQuoteVisaData['destinationId']);		 
		 
			?> 
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteVisaData['id'];?>" id="visafinalId<?php echo $finalQuoteVisaData['id']; ?>">
				<input type="hidden" value="<?php echo $visaData['id'];?>" id="visaId<?php echo $finalQuoteVisaData['id']; ?>">
				VISA:&nbsp;<?php echo strip($visaData['name']);  ?></td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $visaDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
				 
				<option  value="0" <?php if($finalQuoteVisaData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalQuoteVisaData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalQuoteVisaData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalQuoteVisaData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalQuoteVisaData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=visa&serviceId=<?php echo $finalQuoteVisaData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalQuoteVisaData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
					<td colspan="3"  bgcolor="#F4F4F4">
						<input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteVisaData['specialRequest']; ?>" />
						<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
						<script>
						function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
							var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
							$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteVisaData['id']; ?>&tableName=finalQuoteVisa&spacialReq='+spacialReq);
						}
						</script>
					</td> 
				</tr> 
				<tr>
			<td colspan="3" style="display:none;"><input type="file" accept="image/*" name="visaFile" id="visaFile" onchange="uploadVisaFile('<?php echo $srntag; ?>');" style="width:99%;">
			<input type="hidden" name="visanameId" id="visanameId" value="<?php echo $finalQuoteVisaData['id']; ?>">
			</td>
			</tr>
				<tr>
					<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteVisaData['confirmationNo'])>0 ||$finalQuoteVisaData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?> serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteVisaData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteVisaData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteVisaData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteVisaData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteVisaData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteVisaData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteVisaData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteVisaData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteVisaData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteVisaData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						if(confirmationNo != '' && confirmationNo != 'NULL'){ 
							$('#final_frmaction').load('final_frmaction.php?action=visaConfirmation&id=<?php echo $finalQuoteVisaData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
					if('<?php echo $finalQuoteVisaData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteVisaData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					}  
					</script>
					<?php  
					if(strlen($finalQuoteVisaData['confirmationNo'])>0 && $finalQuoteVisaData['manualStatus']==3){
					?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteVisaData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteVisaData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteVisaData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteVisaData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteVisaData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteVisaData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteVisaData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteVisaData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteVisaData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
						} ?>
					</td>
				</tr> 
			</tbody> 
			</table>
			</div> 
	
			</td>
			</tr>
			
			<?php
			}  
		}
		?>
		
		<?php
		if($finalIt_Data2['serviceType'] == 'passport'){
			$b="";
			$b=GetPageRecord('*','finalQuotePassport',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuotePassData=mysqli_fetch_array($b)){
				$srntag = ++$uniNum.'_'.$finalQuotePassData['id'];
	
				$d="";
				$d=GetPageRecord('*',_PASSPORT_COST_MASTER_,' id="'.$finalQuotePassData['passportNameId'].'"');
				$passData=mysqli_fetch_array($d);
				$passId = $passData['id'];
	
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' id="'.$finalQuotePassData['flightQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');
				// $finalQuotePassData=mysqli_fetch_array($rsh); 
	
				 $passportDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				 
				$Ecity = getDestination($finalQuotePassData['destinationId']);		 
		 
			?> 
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuotePassData['id'];?>" id="passfinalId<?php echo $finalQuotePassData['id']; ?>">
				<input type="hidden" value="<?php echo $passData['id'];?>" id="visaId<?php echo $finalQuotePassData['id']; ?>">
				Passport:&nbsp;<?php echo strip($passData['name']);  ?></td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $passportDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
				 
				<option  value="0" <?php if($finalQuotePassData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalQuotePassData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalQuotePassData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalQuotePassData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalQuotePassData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=passport&serviceId=<?php echo $finalQuotePassData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalQuotePassData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
					<td colspan="3"  bgcolor="#F4F4F4">
						<input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuotePassData['specialRequest']; ?>" />
						<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
						<script>
						function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
							var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
							$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuotePassData['id']; ?>&tableName=finalQuotePassport&spacialReq='+spacialReq);
						}
						</script>
					</td> 
				</tr> 
				<tr>
			<td colspan="3" style="display: none;"><input type="file" accept="image/*" name="passFile" id="passFile" onchange="uploadPassFile('<?php echo $srntag; ?>');" style="width:99%;">
			<input type="hidden" name="passnameId" id="passnameId" value="<?php echo $finalQuotePassData['id']; ?>">
			</td>
			</tr>
				<tr>
					<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuotePassData['confirmationNo'])>0 ||$finalQuotePassData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?> serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuotePassData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuotePassData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotePassData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuotePassData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuotePassData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotePassData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuotePassData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuotePassData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuotePassData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuotePassData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						if(confirmationNo != '' && confirmationNo != 'NULL'){ 
							$('#final_frmaction').load('final_frmaction.php?action=passportConfirmation&id=<?php echo $finalQuotePassData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
					if('<?php echo $finalQuotePassData['confirmationNo']; ?>'!='' && '<?php echo $finalQuotePassData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					}  
					</script>
					<?php  
					if(strlen($finalQuotePassData['confirmationNo'])>0 && $finalQuotePassData['manualStatus']==3){
					?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuotePassData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuotePassData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotePassData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuotePassData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuotePassData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotePassData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuotePassData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuotePassData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuotePassData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
						} ?>
					</td>
				</tr> 
			</tbody> 
			</table>
			</div> 
	
			</td>
			</tr>
			
			<?php
			}  
		}
		?>
		
		<?php
		if($finalIt_Data2['serviceType'] == 'insurance'){
			$b="";
			$b=GetPageRecord('*','finalQuoteInsurance',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by fromDate asc'); 
			while($finalQuoteInsData=mysqli_fetch_array($b)){
				$srntag = ++$uniNum.'_'.$finalQuoteInsData['id'];
	
				$d="";
				$d=GetPageRecord('*',_INSURANCE_COST_MASTER_,' id="'.$finalQuoteInsData['insuranceNameId'].'"');
				$insData=mysqli_fetch_array($d);
				$insuranceId = $insData['id'];
	
				// $rsh="";
				// $rsh=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' id="'.$finalQuoteInsData['flightQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc limit 1');
				// $finalQuoteInsData=mysqli_fetch_array($rsh); 
	
				 $insuranceDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				 
				$Ecity = getDestination($finalQuoteInsData['destinationId']);		 
		 
			?> 
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalQuoteInsData['id'];?>" id="passfinalId<?php echo $finalQuoteInsData['id']; ?>">
				<input type="hidden" value="<?php echo $insData['id'];?>" id="insuranceId<?php echo $finalQuoteInsData['id']; ?>">
				Insurance:&nbsp;<?php echo strip($insData['name']);  ?></td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $insuranceDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
				 
				<option  value="0" <?php if($finalQuoteInsData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalQuoteInsData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalQuoteInsData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalQuoteInsData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalQuoteInsData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=insurance&serviceId=<?php echo $finalQuoteInsData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalQuoteInsData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
					<td colspan="3"  bgcolor="#F4F4F4">
						<input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuoteInsData['specialRequest']; ?>" />
						<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
						<script>
						function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
							var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
							$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuoteInsData['id']; ?>&tableName=finalQuoteInsurance&spacialReq='+spacialReq);
						}
						</script>
					</td> 
				</tr> 
				<tr>
			<td colspan="3" style="display: none;"><input type="file" accept="image/*" name="passFile" id="passFile" onchange="uploadInsFile('<?php echo $srntag; ?>');" style="width:99%;">
			<input type="hidden" name="insnameId" id="insnameId" value="<?php echo $finalQuoteInsData['id']; ?>">
			</td>
			</tr>
				<tr>
					<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuoteInsData['confirmationNo'])>0 ||$finalQuoteInsData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?> serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuoteInsData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteInsData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteInsData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteInsData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuoteInsData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteInsData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuoteInsData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuoteInsData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuoteInsData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalQuoteInsData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						if(confirmationNo != '' && confirmationNo != 'NULL'){ 
							$('#final_frmaction').load('final_frmaction.php?action=insuranceConfirmation&id=<?php echo $finalQuoteInsData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
					if('<?php echo $finalQuoteInsData['confirmationNo']; ?>'!='' && '<?php echo $finalQuoteInsData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					}  
					</script>
					<?php  
					if(strlen($finalQuoteInsData['confirmationNo'])>0 && $finalQuoteInsData['manualStatus']==3){
					?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuoteInsData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuoteInsData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteInsData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteInsData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuoteInsData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuoteInsData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuoteInsData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuoteInsData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuoteInsData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
						} ?>
					</td>
				</tr> 
			</tbody> 
			</table>
			</div> 
	
			</td>
			</tr>
			
			<?php
			}  
		}

		// Complete Package services

		if($finalIt_Data2['serviceType'] == 'package'){
			$b="";
			$b=GetPageRecord('*','finalPackWiseRateMaster',' quotationId="'.$quotationId.'"  and  id="'.$finalIt_Data2['serviceId'].'"  and supplierId = "'.$supplierData['id'].'" order by id asc'); 
			while($finalPackageData=mysqli_fetch_array($b)){
				$srntag = ++$uniNum.'_'.$finalPackageData['id'];
	
				// $d="";
				// $d=GetPageRecord('*',_INSURANCE_COST_MASTER_,' id="'.$finalPackageData['insuranceNameId'].'"');
				// $insData=mysqli_fetch_array($d);
				$insuranceId = $finalPackageData['id'];
	
				 $insuranceDates = date('d M Y',strtotime($finalIt_Data2['startDate'])); 
				 
				$Ecity = getDestination($finalPackageData['destinationId']);		 
		 
			?> 
				<tr>
				<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
	
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				<td width="50%"  bgcolor="#F4F4F4">
				<input type="hidden" value="<?php echo $finalPackageData['id'];?>" id="packagefinalId<?php echo $finalPackageData['id']; ?>">
				<input type="hidden" value="<?php echo $insData['id'];?>" id="packageId<?php echo $finalPackageData['id']; ?>">
				Package:&nbsp;<?php echo strip($finalPackageData['serviceName']);  ?></td>
				<td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:10px; font-size:12px;"><?php echo $insuranceDates; ?></span></td>
				<td width="33%" bgcolor="#F4F4F4">
				<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
				 
				<option  value="0" <?php if($finalPackageData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
				<option  value="2" <?php if($finalPackageData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
				<option  value="3" <?php if($finalPackageData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
				<option  value="4" <?php if($finalPackageData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
				<option  value="5" <?php if($finalPackageData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
			 </select>
			 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
				<script>
				function updateFinalQuotStatus<?php echo $srntag; ?>(){
					var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
					if(manualStatus==3){
						$('.serviceConfirmed<?php echo $srntag; ?>').show();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
					}else{
						$('.serviceConfirmed<?php echo $srntag; ?>').hide();
						$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
						//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
					}
					$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=package&serviceId=<?php echo $finalPackageData['id']; ?>&manualStatus='+manualStatus);
				}
				<?php if ($finalPackageData['manualStatus']==3) { ?>
				//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
				<?php } ?>
				</script>
				</td>
				</tr>
				<tr>
					<td colspan="3"  bgcolor="#F4F4F4">
						<input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:7px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalPackageData['specialRequest']; ?>" />
						<div id="final_frmaction<?php echo $srntag; ?>" style="display:none;"></div>
						<script>
						function updateSupplierSpecialRequest<?php echo $srntag; ?>(){
							var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
							$('#final_frmaction<?php echo $srntag; ?>').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalPackageData['id']; ?>&tableName=finalPackWiseRateMaster&spacialReq='+spacialReq);
						}
						</script>
					</td> 
				</tr> 
				<tr>
			<td colspan="3" style="display: none;"><input type="file" accept="image/*" name="passFile" id="passFile" onchange="uploadInsFile('<?php echo $srntag; ?>');" style="width:99%;">
			<input type="hidden" name="insnameId" id="insnameId" value="<?php echo $finalPackageData['id']; ?>">
			</td>
			</tr>
				<tr>
					<td width="100%" align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
					<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalPackageData['confirmationNo'])>0 ||$finalPackageData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?> serviceConfirmed<?php echo $srntag;?>">
					<table width="100%" >
						<tr >
							<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalPackageData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
						 
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalPackageData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalPackageData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalPackageData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalPackageData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalPackageData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalPackageData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
							<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalPackageData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalPackageData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
						   <td  bgcolor="#F4F4F4"><?php if($finalPackageData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
							</td>
							<td  bgcolor="#F4F4F4">
						   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
						   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
							</td>
						 </tr>
					</table>
					</div>
					<script>
					function updateSupplierConfirmation<?php echo $srntag; ?>(){
						var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
						var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
						var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
						var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
						var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
						var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
						var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
						var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
						var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
						if(confirmationNo != '' && confirmationNo != 'NULL'){ 
							$('#final_frmaction').load('final_frmaction.php?action=completePackageConfirmation&id=<?php echo $finalPackageData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
						}else{
							if(manualStatus ==3){
							alert('Confirmation number is required');
						} }
					}
					if('<?php echo $finalPackageData['confirmationNo']; ?>'!='' && '<?php echo $finalPackageData['manualStatus'];?>'=='3'){
						$('.confirmstatus<?php echo $srntag; ?>').hide();
						$('.confirmstatusdetails<?php echo $srntag; ?>').show();
					}  
					</script>
					<?php  
					if(strlen($finalPackageData['confirmationNo'])>0 && $finalPackageData['manualStatus']==3){
					?>
						<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative;  " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
						<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
						  <tr>
							<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalPackageData['confirmationNo']; ?></td>
							<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalPackageData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalPackageData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalPackageData['confirmationDate'])); } ?></td>
							<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalPackageData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalPackageData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalPackageData['cutOffDate'])); } ?></td>
							<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalPackageData['confirmedBy']; ?></td>
							<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalPackageData['confirmedNote']; ?></td>
							<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
						  </tr>
						</table>
						</div>
						<?php 
						} ?>
					</td>
				</tr> 
			</tbody> 
			</table>
			</div> 
	
			</td>
			</tr>
			
			<?php
			}  
		}
	}
	} 
	
	// hotel list item for same suppliers
	$dateSets = getHotelDateSets($quotationId,$supplierData['id']);
	$dateSetArray = explode('~',$dateSets);
	$cnt = 1;
	if(strlen($dateSets) > 0){ 
		foreach($dateSetArray as $dateSet){ 
			$srntag = strip($supplierData['id']."_".$cnt);
			
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
			$finalQuotData=mysqli_fetch_array($g);
			
			// $g="";
			// $g=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'id="'.$finalQuotData['hotelQuotationId'].'"'); 
			// $quotationHotelData=mysqli_fetch_array($g);
			
			$CheckIn = "CheckIn :".date('d M Y',strtotime($fromDate));
			$CheckOut = " CheckOut :".date('d M Y',strtotime($toDate));
			$date1 = new DateTime($fromDate);
			$date2 = new DateTime($toDate);
			$interval = $date1->diff($date2);
			$nights = $interval->days;  
			 
			$fromDateV = $fromDate;
			$toDateV = $toDate; 

			// if($finalQuotData['isLocalEscort']==1){
			//        $hotelTypeLable = "Local Escort,";
			//    }
			//    if($finalQuotData['isForeignEscort']==1){
			//        $hotelTypeLable = "Foreign Escort,";
			//    }
			//    if($finalQuotData['isGuestType']==1){
			//        $hotelTypeLable = "Guest,";
			//    }

			?> 
			<tr>
			<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
				<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;border: 1px solid #ddd;position:relative;">
					<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
					<tbody>
					<tr>
					  	<td colspan="3" valign="bottom"  bgcolor="#F4F4F4">
						<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="4"> 
						 
						<tr>  
							<td width="30%"><span style="padding:6px 0">Hotel:-<?php //echo rtrim($hotelTypeLable,',')." ";  
							echo strip($hotelData['hotelName']); ?></span></td>  
							<td><span style="padding:6px 0"><?php echo $CheckIn;?></span></td> 
							<td><span style="padding:6px 0"><?php echo $CheckOut; ?></span></td>
							<td><span style="padding:6px 0"><?php echo $nights." Night(s)"; ?></span></td> 
							<td>
								<select class="manualStatus" id="manualStatus<?php echo $srntag; ?>" style="width:110px; padding:7px; float:right; color:#000; <?php echo $colr; ?>" onchange="updateFinalQuotStatus<?php echo $srntag; ?>();" >
								 
								<option  value="0" <?php if($finalQuotData['manualStatus'] == 0){ ?> selected="selected" <?php } ?> >PENDING</option>
								<option  value="2" <?php if($finalQuotData['manualStatus'] == 2){ ?> selected="selected" <?php } ?> >REQUESTED</option>
								<option  value="3" <?php if($finalQuotData['manualStatus'] == 3){ ?> selected="selected" <?php } ?> >CONFIRM</option>
								<option  value="4" <?php if($finalQuotData['manualStatus'] == 4){ ?> selected="selected" <?php } ?> >REJECTED</option>
								<option  value="5" <?php if($finalQuotData['manualStatus'] == 5){ ?> selected="selected" <?php } ?> >WAITLIST</option>
							 </select>
							 <div id="finalQuotSupplierStatus<?php echo $srntag; ?>" style="display:none;"></div>
								<script>
								function updateFinalQuotStatus<?php echo $srntag; ?>(){
									var manualStatus = $('#manualStatus<?php echo $srntag; ?>').val();
									if(manualStatus==3){
										$('.serviceConfirmed<?php echo $srntag; ?>').show();
										$('.serviceConfirmedDetails<?php echo $srntag; ?>').hide();
										//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
									}else{
										$('.serviceConfirmed<?php echo $srntag; ?>').hide();
										$('.serviceConfirmedDetails<?php echo $srntag; ?>').show();
										//$('#sendSuppConfirmation<?php echo $srntag; ?>').show();
									}
									$('#finalQuotSupplierStatus<?php echo $srntag; ?>').load('final_frmaction.php?action=confirm_status&serviceType=hotel&serviceId=<?php echo $FID; ?>&manualStatus='+manualStatus);
								}
								<?php if ($finalQuotData['manualStatus']==3) { ?>
								//$('#sendSuppConfirmation<?php echo $srntag; ?>').hide();
								<?php } ?>
								</script>
							</td> 
						</tr>  

						<?php  
						$g2="";
						$g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and  hotelId="'.$hotelId.'" and  supplierId="'.$supplierData['id'].'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" group by roomType,mealPlanId  order by fromDate asc'); 
						if(mysqli_num_rows($g2)>0){ 
							while($quotMealData=mysqli_fetch_array($g2)){ 
								
								$g="";
								$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotMealData['roomType'].'"'); 
								$roomTypeData=mysqli_fetch_array($g);
								$rType=$roomTypeData['name'];
								
								$g="";
								$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotMealData['mealPlanId'].'"'); 
								$mealData=mysqli_fetch_array($g); 
								//.'-'.$mealData['subname']
								$mealplan = $mealData['name'];
								?>
								<tr> 
									<td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
									<tr>
										<td width="50%"><?php echo date('d M',strtotime($quotMealData['fromDate']))." - ".date('d M Y',strtotime($quotMealData['toDate']) + 86400); ?></td>  
										<td width="20%">&nbsp;&nbsp;<?php echo $rType;?></td> 
										<td>&nbsp;<?php echo $mealplan; ?></td>
									</tr>
								</table></td></tr> 
								<?php
							}
						}
						?>
						<!-- end of the services loop from final tables -->
						</table> 
 					</tr>
					<tr >
						<td colspan="3" bgcolor="#F4F4F4"><input  type="text" class="gridfield"  id="remarks<?php echo $srntag; ?>" style="text-align:left; width:98%;  padding:8px;" placeholder="Special request or remarks" onkeyup="updateSupplierSpecialRequest<?php echo $srntag; ?>();" value="<?php echo $finalQuotData['specialRequest']; ?>" />
						<script>
						function updateSupplierSpecialRequest<?php echo $srntag; ?>(){   
							var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
							$('#final_frmaction').load('final_frmaction.php?action=specialRequest&id=<?php echo $finalQuotData['id']; ?>&tableName=finalQuote&spacialReq='+spacialReq);
						} 
						</script>
						</td>	
						</tr> 
						<tr>
						<td align="left" valign="top" bgcolor="#F4F4F4" colspan="4">
							<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:10px;background-color: #f4f4f4;border: 1px solid #ddd;position:relative;  <?php if(strlen($finalQuotData['confirmationNo'])>0 ||$finalQuotData['manualStatus']==3){ ?> display:block; <?php }else{ ?> display:none; <?php } ?>" class="confirmstatus<?php echo $srntag; ?>  serviceConfirmed<?php echo $srntag;?>">
							<table width="100%" >
								<tr >
									<td  bgcolor="#F4F4F4"><label for="confirmationNo<?php echo $srntag; ?>" style="font-size:12px;">*Confirmation No:</label><input  type="text" class="gridfield" id="confirmationNo<?php echo $srntag; ?>"  value="<?php echo $finalQuotData['confirmationNo']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;"  /></td>
								 
									<td  align="left" bgcolor="#F4F4F4"><label for="confirmationDateTime<?php echo $srntag; ?>" style="font-size:12px;">Confirmation&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="confirmationDate<?php echo $srntag; ?>"  value="<?php if($finalQuotData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotData['confirmationDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuotData['confirmationDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
									<td  align="left" bgcolor="#F4F4F4"><label for="cutOffDate<?php echo $srntag; ?>" style="font-size:12px;">Cut&nbsp;Off&nbsp;Date:</label><input  type="datetime-local" class="gridfield" id="cutOffDate<?php echo $srntag; ?>"  value="<?php if($finalQuotData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotData['cutOffDate']))!='1970-01-01'){ echo date('Y-m-d\TH:i', strtotime($finalQuotData['cutOffDate'])); }else{ echo date('Y-m-d\TH:i'); } ?>" style="text-align:left;width:96%;padding: 3px;border-radius: 2px;" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" /></td>
									<td  align="left" bgcolor="#F4F4F4"><label for="confirmedBy<?php echo $srntag; ?>" style="font-size:12px;">Confirmed By:</label><input  type="text" class="gridfield" id="confirmedBy<?php echo $srntag; ?>"  value="<?php echo $finalQuotData['confirmedBy']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
								   <td  bgcolor="#F4F4F4"><label for="confirmedNote<?php echo $srntag; ?>" style="font-size:12px;">Confirmed Note:</label><input  type="text" class="gridfield" id="confirmedNote<?php echo $srntag; ?>"  value="<?php echo $finalQuotData['confirmedNote']; ?>" style="text-align:left;width:93%;padding: 5px;border-radius: 2px;" /></td>
								   <td  bgcolor="#F4F4F4"><?php if($finalQuotData['confirmationNo'] !=''){ ?><input  type="button" id="" value="Cancel" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').hide();$('.confirmstatusdetails<?php echo $srntag; ?>').show();" style=" margin-top: 14px; background-color: #d90000 !important; "/><?php } ?>
								  </td>
									<td  bgcolor="#F4F4F4">
								   <input  type="button" id="confirmedNote<?php echo $srntag; ?>" value=" Save " class="gridfield followupBtn followupBtnClick"  onclick="updateSupplierConfirmation<?php echo $srntag; ?>(); " style=" margin-top: 14px; "/>
								   <input type="hidden" id="msgType<?php echo $srntag; ?>" value="0" class="followupBtnInputHidden">
									</td>
							  </tr>
							</table>
							</div>
							<script>
							function updateSupplierConfirmation<?php echo $srntag; ?>(){
								var spacialReq = encodeURI($('#remarks<?php echo $srntag; ?>').val());
								var confirmationNo = encodeURI($('#confirmationNo<?php echo $srntag; ?>').val());
								var confirmationDate = encodeURI($('#confirmationDate<?php echo $srntag; ?>').val());
								var cutOffDate = encodeURI($('#cutOffDate<?php echo $srntag; ?>').val());
								var confirmationTime = encodeURI($('#confirmationTime<?php echo $srntag; ?>').val());
								var confirmedBy = encodeURI($('#confirmedBy<?php echo $srntag; ?>').val());
								var confirmedNote = encodeURI($('#confirmedNote<?php echo $srntag; ?>').val());
								var msgType = encodeURI($('#msgType<?php echo $srntag; ?>').val());
								var manualStatus = encodeURI($('#manualStatus<?php echo $srntag; ?>').val());
								if(confirmationNo != '' && confirmationNo != 'NULL'){ 					
									$('#final_frmaction').load('final_frmaction.php?action=hotelConfirmation&id=<?php echo $finalQuotData['id']; ?>&spacialReq='+spacialReq+'&confirmationNo='+confirmationNo+'&confirmationDate='+confirmationDate+'&confirmationTime='+confirmationTime+'&confirmedBy='+confirmedBy+'&confirmedNote='+confirmedNote+'&cutOffDate='+cutOffDate+'&msgType='+msgType);
								}else{
									if(manualStatus ==3){
									alert('Confirmation number is required');
								} }
							}
							var confirmationNo = '<?php echo strlen(trim($finalQuotData['confirmationNo'])); ?>';
							var manualStatus = <?php echo trim($finalQuotData['manualStatus']); ?>;
							if(confirmationNo>0 && manualStatus==3){
								$('.confirmstatus<?php echo $srntag; ?>').hide();
								$('.confirmstatusdetails<?php echo $srntag; ?>').show();
							} 
							</script>
							<?php 
							if(strlen($finalQuotData['confirmationNo'])>0 && $finalQuotData['manualStatus']==3){
							?> 
								<div style="font-size:11px; font-weight:500; padding:0px; background-color: #ffffff; border: 1px solid #ddd; position:relative; " class="confirmstatusdetails<?php echo $srntag; ?>  serviceConfirmedDetails<?php echo $srntag;?>" >
								<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ddd">
								  <tr>
									<td><b>Confirmation&nbsp;No:</b><br><?php echo $finalQuotData['confirmationNo']; ?></td>
									<td><b>Confirmation&nbsp;Date:</b><br><?php if($finalQuotData['confirmationDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotData['confirmationDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuotData['confirmationDate'])); } ?></td>
									<td><b>Cut&nbsp;Off&nbsp;Date:</b><br><?php if($finalQuotData['cutOffDate']!='0000-00-00 00:00:00' && date('Y-m-d', strtotime($finalQuotData['cutOffDate']))!='1970-01-01'){ echo date('d-m-Y H:i a', strtotime($finalQuotData['cutOffDate'])); } ?></td>
									<td><b>Confirmed&nbsp;By:</b><br><?php echo $finalQuotData['confirmedBy']; ?></td>
									<td><b>Confirmed&nbsp;Note:</b><br><?php echo $finalQuotData['confirmedNote']; ?></td>
									<td><input  type="button" value="Edit" class="gridfield followupBtn"  onclick="$('.confirmstatus<?php echo $srntag; ?>').show();$('.confirmstatusdetails<?php echo $srntag; ?>').hide();" style=" margin-top: 14px; "/></td>
								  </tr>
								</table>
								</div>
								<?php 
							} ?>
						</td>
						</tr>
					</tbody> 
					</table> 
				</div>	 
			</td> 
			</tr>  
			<?php 	 
			$cnt++;
		}
	}
	?> 
	</tbody>
	</table> 
	<?php   
}
	 
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="display: none;margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd">Service Type : Forex&nbsp;Insurance</th>
		</tr>
	</thead>
	<tbody >
	
	
		<tr>
		<td width="100%" align="left" valign="top" style="padding:10px !important; ">
			<form method="post" enctype="multipart/form-data">
			<div style="font-size:15px; font-weight:500; padding:10px; margin-bottom:0px; position:relative;background-color: #f4f4f4;">
			<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td width="33%" bgcolor="#F4F4F4"><div style="font-size:12px;">Insurance Voucher</div>
				  <input type="file" name="insurenceVoucher" id="insurenceVoucher" class="gridfield" style="text-align:center; width:90%;display:inline-block;padding:8px;" />	
				  </td>
				  <input type="hidden" name="quotationId" id="quotationId" value="<?php echo $quotationId; ?>" />
				  <input type="hidden" name="queryId" id="queryId" value="<?php echo $resultpage['id']; ?>" />
				  <td width="13%"  align="left" bgcolor="#F4F4F4">&nbsp;<br><div id="insurence_Voucher" style="background-color: #009900; color: #FFFFFF; cursor: pointer; padding: 7px 10px; border-radius: 2PX;   box-sizing: border-box; display:inline" >Save</div>
				  </td>
				  </tr> 
				</tbody> 
			  </table>
		  </div>
		  </form>
		</td>
		</tr>
	</tbody>
</table> 
<style>
.followupBtn{
	background-color: #009900;
	color: #FFFFFF;
	cursor: pointer;
	padding: 6px 10px;
	margin-top: 14px;
	border-radius: 2PX;
	border: 1px solid #090;
	box-sizing: border-box;
	display: inline;
	float: left;
}
.confirmManual<?php echo $finalQuotData['id']; ?>{ display:none;}
.followupDateTime{
	text-align:left;width:95%;padding: 5px;border-radius: 2px;
}
</style>
 

<script type="text/javascript">

	$(document).on("input", ".numeric", function() {
		this.value = this.value.replace(/\D/g,'');
	}); 
// transfer savefinalqtInsurance
	$(document).ready(function(){
		$("#insurence_Voucher").click(function() {
			var fd = new FormData(); 
			var files = $('#insurenceVoucher')[0].files[0]; 
			fd.append('insurenceVoucher', files); 
			var quotationId = $('#quotationId').val();
			fd.append('quotationId', quotationId);
			var queryId = $('#queryId').val();
			fd.append('queryId', queryId); 
   
			$.ajax({ 
				url: 'finalInsurenceVoucher.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					   alert('file uploaded'); 
					} 
				}, 
			}); 
		}); 
	});     
	function savefinalQuote(){
		$('.followupBtnInputHidden').val(1);
		$('#savefinalQuote').load('final_frmaction.php?action=savefinalQuote');
		$('.followupBtnClick').click();
	}

	function showHideCost(supplierStatusId){
		var isCostShow = 0;
		if($('#isCostShow'+supplierStatusId).prop('checked') !== false ){
			var isCostShow = 1;
		}
		$('#savefinalQuote').load('final_frmaction.php?action=saveShowHideCost&supplierStatusId='+supplierStatusId+'&isCostShow='+isCostShow);
	}


// started train files uploaded
	function uploadTrainFile(){
			var fd = new FormData(); 
			var files = $('#trainFile')[0].files[0]; 
			fd.append('trainFile', files); 
			var trainId = $('#trainId').val();
			fd.append('trainId', trainId);
			fd.append('action', 'trainFileUploaded');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Train file 1 uploaded'); 
					} 
				}, 
			}); 
	}


	function uploadTrainFile2(){
			var fd = new FormData(); 
			var files = $('#trainFile2')[0].files[0]; 
			fd.append('trainFile2', files); 
			var trainId = $('#trainId').val();
			fd.append('trainId', trainId);
			fd.append('action', 'trainFileUploaded2');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Train file 2 uploaded'); 
					} 
				}, 
			}); 
	}
	function uploadTrainFile3(){
			var fd = new FormData(); 
			var files = $('#trainFile3')[0].files[0]; 
			fd.append('trainFile3', files); 
			var trainId = $('#trainId').val();
			fd.append('trainId', trainId);
			fd.append('action', 'trainFileUploaded3');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Train file 3 uploaded'); 
					} 
				}, 
			}); 
	}
// ended train files uploaded



// started transfer and transport files uploaded
	function uploadTransferFile(){
			var fd = new FormData(); 
			var files = $('#transferFile')[0].files[0]; 
			fd.append('transferFile', files); 
			var transferId = $('#transferId').val();
			fd.append('transferId', transferId);
			fd.append('action', 'transferFileUploaded');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Transfer file 1 uploaded'); 
					} 
				}, 
			}); 
	}
	function uploadTransferFile2(){
			var fd = new FormData(); 
			var files2 = $('#transferFile2')[0].files[0]; 
			fd.append('transferFile2', files2); 
			var transferId = $('#transferId').val();
			fd.append('transferId', transferId);
			fd.append('action', 'transferFileUploaded2');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Transfer file 2 uploaded '); 
					} 
				}, 
			}); 
	}
	function uploadTransferFile3(){
			var fd = new FormData(); 
			var files3 = $('#transferFile3')[0].files[0]; 
			fd.append('transferFile3', files3); 
			var transferId = $('#transferId').val();
			fd.append('transferId', transferId);
			fd.append('action', 'transferFileUploaded3');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Transfer file 3 uploaded'); 
					} 
				}, 
			}); 
	}
// ended transfer and transport files uploaded


	// started flight files uploaded

	function uploadFlightFile(){
			var fd = new FormData(); 
			var files = $('#flightFile')[0].files[0]; 
			fd.append('flightFile', files); 
			var flightId = $('#flightId').val();
			fd.append('flightId', flightId);
			fd.append('action', 'flightFileUploaded');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Flight file 1 uploaded'); 
					} 
				}, 
			}); 
	}

	function uploadFlightFile2(){
			var fd = new FormData(); 
			var files = $('#flightFile2')[0].files[0]; 
			fd.append('flightFile2', files); 
			var flightId = $('#flightId').val();
			fd.append('flightId', flightId);
			fd.append('action', 'flightFileUploaded2');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Flight file 2 uploaded'); 
					} 
				}, 
			}); 
	}
	function uploadFlightFile3(){
			var fd = new FormData(); 
			var files = $('#flightFile3')[0].files[0]; 
			fd.append('flightFile3', files); 
			var flightId = $('#flightId').val();
			fd.append('flightId', flightId);
			fd.append('action', 'flightFileUploaded3');
   
			$.ajax({ 
				url: 'final_frmaction.php', 
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response!=''){ 
					//    alert('Flight file 3 uploaded'); 
					} 
				}, 
			}); 
	}

	// ended flight files uploaded

</script>

<div id="savefinalQuote"></div>
<div style="overflow:hidden; margin-top:20px;">
	 <table border="0" align="right" cellpadding="5" cellspacing="0">
	  	<tbody>
	  		<tr>
		    	<td>
				     <input type="button" class="bluembutton submitbtn" value="Save" onclick="savefinalQuote();">
				     <input type="button" class="whitembutton" value="Close" onclick="alertspopupopenClose();window.location.reload();">
				</td>
		  	</tr>
		</tbody>
	</table>
</div>
