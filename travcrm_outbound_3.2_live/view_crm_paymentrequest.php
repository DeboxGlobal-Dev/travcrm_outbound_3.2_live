<?php
if($viewpermission!=1 && $_REQUEST['id']!=''){
	header('location:'.$fullurl.'');
}
  
if($_REQUEST['id']!=''){

	// new code
	$paymentRequestId=clean(decode($_REQUEST['id'])); 
	$rs='';   
	$rs=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,'id="'.$paymentRequestId.'"'); 
	$prmData=mysqli_fetch_array($rs);  

	// $select=''; 
	// $where=''; 
	// $rs='';   
	// $select='*'; 
	// $id=clean($prmData['queryid']); 
	// $where='id="'.$id.'"'; 
	// $rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
	// $resultpage=mysqli_fetch_array($rs);

	$rs='';   
	$rs=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$prmData['quotationId'].'"'); 
	$quotationData=mysqli_fetch_array($rs);

	$rs='';   
	$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'"'); 
	$resultpage=mysqli_fetch_array($rs);

	// quotation Data
	$quotationId = $quotationData['id'];
	$queryId = $quotationData['queryId'];

	// $dayroe = $quotationData['dayroe'];
	// // GST DATA 
	// $serviceTax = 0;
	// if ($quotationData['serviceTax']>0) {
	//     $serviceTax = $quotationData['serviceTax'];
	// }

	// // Commission DATA
	// $commissionType = $quotationData['commissionType'];
	// $ISOCommission = $quotationData['ISOCommission'];
	// $ConsortiaCommission = $quotationData['ConsortiaCommission'];
	// $ClientCommission = $quotationData['ClientCommission'];
	// $tcs = $quotationData['tcs'];

	// // DISCOUNT DATA
	// $discountType = $quotationData['discountType'];
	// $discount = $quotationData['discount'];

	// MARKUP DAta
	// $c12 = GetPageRecord('*', 'quotationServiceMarkup', ' quotationId="' . $quotationId . '"');
	// $serviceMarkuD = mysqli_fetch_array($c12);

	// $serviceMarkup = $markupType = 0;
	// if($quotationData['isUni_Mark'] == 1){
	//     $serviceMarkup = $quotationData['markupCost'];
	//     $markupType = $quotationData['markupType'];
	// } 

	$displayId = makeQuotationId($quotationId);
	 
	// $select=''; 
	// $where=''; 
	// $rs='';   
	// $select='email';  
	// $where='id='.$resultpage['assignTo'].''; 
	// $rs=GetPageRecord($select,_USER_MASTER_,$where); 
	// $resultpageassignemail=mysqli_fetch_array($rs);

	// $select=''; 
	// $where=''; 
	// $rs='';   
	// $select='*';  
	// $where='id=1'; 
	// $rs=GetPageRecord($select,_QUERY_MAILS_SECTION_MASTER_,$where); 
	// $resultpageemail=mysqli_fetch_array($rs);  


	// if($resultpage['clientType']!=2){

	// $select=''; 
	// $where=''; 
	// $rs='';   
	// $select='*'; 
	// $id=clean($resultpage['companyId']); 
	// $where='id='.$id.''; 
	// $rs=GetPageRecord($select,_CORPORATE_MASTER_,$where); 
	// $resultcompany=mysqli_fetch_array($rs);  

	// $mobilemailtype='corporate';
	// } 
	// if($resultpage['clientType']==2){

	// $select=''; 
	// $where=''; 
	// $rs='';   
	// $select='*'; 
	// $id=clean($resultpage['companyId']); 
	// $where='id='.$id.''; 
	// $rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 
	// $resultcompany=mysqli_fetch_array($rs);  

	// $mobilemailtype='contacts';
	// } 

	
	?>
<!-- <script src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">

    tinymce.init({

        selector: "#description",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script>
 -->
<style>
.maintoph{background-color:#f6fafe; color:#6f8ba9; padding:15px; font-weight:500; text-transform:uppercase;border-bottom:1px #b5cae085 solid; }
body{background-color:#eae9ee !IMPORTANT;}
.costtabsbox {
    float: left;
    text-align: left;
    margin-right: 10px;
    padding: 5px 15px;
    border-radius: 4px;
    box-shadow: 2px 2px 1px #5077994a;
    background-color: #f6fafe;
    padding-top: 10px;
}
</style>
<div style="display:none">
	<?php 
	// update cost to quotationMaster if not updated  
    $rs211=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationData['id'].'" '); 
    $resultpageQuotation=mysqli_fetch_array($rs211);
    
    $rs12 = GetPageRecord('*', _QUERY_MASTER_, 'id='.($resultpageQuotation['queryId']).'');
    $resultpage = mysqli_fetch_array($rs12);
	
	// quotation Data
	$quotationId = $resultpageQuotation['id'];
	$queryId = $resultpageQuotation['queryId'];
	$_REQUEST['finalcategory'] = 0;
    if(empty($prmData['totalClientCost']) || empty($prmData['totalCompanyCost'])){
        if($resultpage['queryType']==13){
			include_once("loadMultiServicesCostSheet.php");
		}else{
        if($resultpage['travelType']==2){
    		include_once("loadCostSheet_domestic.php");
    	}elseif($quotationData['calculationType']==2){
			include_once("loadPackageWiseCostSheet.php");
	    }elseif($quotationData['calculationType']==3){  
			include_once("loadCompletePackageCostSheet.php");
	    }else{
			include_once("loadCostSheet.php");
		}
	}
		// *update open costsheet and udpate quotation master with cost then move costing to quotation to prm table
		$nquotQuery='';
		$nquotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" '); 
    	$nQuotationData=mysqli_fetch_array($nquotQuery);

		$totalCompanyCost3 = $nQuotationData['totalCompanyCost'];
		$nonTaxableAMT3 = $nQuotationData['nonTaxableAMT'];
		$totalClientCost3 = $nQuotationData['totalQuotCost'];
		$totalClientCostWithMarkup3 = trim($nQuotationData['totalCompanyCost']+$nQuotationData['totalMarkupCost']);
		$totalMarkupCost3 = $nQuotationData['totalMarkupCost'];
		$totalISOCost3 = $nQuotationData['totalISOCost'];
		$totalConsortiaCost3 = $nQuotationData['totalConsortiaCost'];
		$totalClientCommCost3 = $nQuotationData['totalClientCommCost'];
		$totalDiscountCost3 = $nQuotationData['totalDiscountCost'];
		$totalServiceTaxCost3 = $nQuotationData['totalServiceTaxCost'];
		$totalTCSCost3 = $nQuotationData['totalTCSCost'];
		$sglBasisCost3 = $nQuotationData['sglBasisCost'];
		$dblBasisCost3 = $nQuotationData['dblBasisCost'];
		$twinCost3 = $nQuotationData['twinCost'];
		$tplBasisCost3 = $nQuotationData['tplBasisCost'];
		$extraAdultCost3 = $nQuotationData['extraAdultCost'];
		$CWBCost3 = $nQuotationData['CWBCost'];
		$CNBCost3 = $nQuotationData['CNBCost'];

		$currencyId3 = $nQuotationData['currencyId'];
		$serviceTax3 = $nQuotationData['serviceTax'];
		$gstType3 = $nQuotationData['gstType'];
		$tcsTax3 = $nQuotationData['tcs'];
		$commissionType3 = $nQuotationData['commissionType'];
		$ISOCommission3 = $nQuotationData['ISOCommission'];
		$ConsortiaCommission3 = $nQuotationData['ConsortiaCommission'];
		$ClientCommission3 = $nQuotationData['ClientCommission'];
		$discountType3 = $nQuotationData['discountType'];
		$discount3 = $nQuotationData['discount']; 

		// Original cost store into this table after final 
		$namevalue ='totalCompanyCost = "'.$totalCompanyCost3.'", totalClientCost = "'.$totalClientCost3.'", totalClientCostWithMarkup = "'.$totalClientCostWithMarkup3.'", totalMarkupCost = "'.$totalMarkupCost3.'", totalISOCost = "'.$totalISOCost3.'", totalConsortiaCost = "'.$totalConsortiaCost3.'", totalClientCommCost = "'.$totalClientCommCost3.'", totalDiscountCost = "'.$totalDiscountCost3.'", totalServiceTaxCost = "'.$totalServiceTaxCost3.'", totalTCSCost = "'.$totalTCSCost3.'", sglBasisCost = "'.$sglBasisCost3.'", dblBasisCost = "'.$dblBasisCost3.'", twinCost = "'.$twinCost3.'", tplBasisCost = "'.$tplBasisCost3.'", extraAdultCost = "'.$extraAdultCost3.'", CWBCost = "'.$CWBCost3.'", CNBCost = "'.$CNBCost3.'", currencyId = "'.$currencyId3.'", serviceTax = "'.$serviceTax3.'",gstType = "'.$gstType3.'", tcsTax = "'.$tcsTax3.'", commissionType = "'.$commissionType3.'", ISOCommission = "'.$ISOCommission3.'", ConsortiaCommission = "'.$ConsortiaCommission3.'", ClientCommission = "'.$ClientCommission3.'", discountType = "'.$discountType3.'", discount = "'.$discount3.'", queryid="'.trim($nQuotationData['queryId']).'", quotationId="'.$quotationId.'", deletestatus=0,addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'",nonTaxableAMT="'.$nonTaxableAMT3.'"';

		 $where = 'id="'.$prmData['id'].'"';
		 $lastid = updatelisting(_PAYMENT_REQUEST_MASTER_,$namevalue,$where);
		// exit;

		if(!isset($_SESSION['page_refreshed'])){
        	// execute the header refresh
			header('Refresh: 2');
			// die();
			// set the session variable to stop refresh again and again
			$_SESSION['page_refreshed'] = true;
		}
	}
	?>
</div>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  	<!-- start left sidebar -->
  	<?php if ($resultpage['moduleType'] == '1') { ?>
	<td width="10%" align="left" valign="top" class="queryleft">
		<div class="innerdiv">
			<div class="contentbox" style="background-color: rgba(0,0,0,0.2);">
				<div class="lables">
					<?php echo date('j F Y', $resultpage['dateAdded']); ?> &nbsp;<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('h:i A', $resultpage['dateAdded']); ?> <?php if ($resultpage['queryPriority'] == 2) { ?><div class="mediampire" style="float: right;padding: 5px 5px;top: 4px;">Medium</div><?php } ?><?php if ($resultpage['queryPriority'] == 3) { ?><div class="highpire" style="float: right;padding: 5px 5px;">High</div><?php } ?></div>
					<br>
					<div style="font-size:24px;" class="statustbs">
						<div style="font-size:16px!important;padding:0!important;left: 15px!important;" class="statustbs">Query Id</div>
						<div><?php echo makeQueryId($resultpage['id']); ?></div>
					</div>
					<?php if ($resultpage['queryStatus'] == 3 && $resultpage['queryConfirmingDate']!='NULL' || $resultpage['queryStatus'] == 20 && $resultpage['queryConfirmingDate']!='NULL') { ?><div style="font-size:16px;" class="statustbs">Tour Id - <?php echo makeQueryTourId($resultpage['id']); ?></div>
					<div style="font-size:16px;" class="statustbs">Reference No - <?php echo ($resultpage['referanceNumber']); ?> </div><?php } ?>
					<br>
				</div>
				<div class="contentbox">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:none;">
						<tr>
							<td colspan="2">
								<div class="lables">Check In</div>
								<?php echo showdate($resultpage['fromDate']); ?>
							</td>
							<td>
								<div class="lables">Check Out</div>
								<?php echo showdate($resultpage['toDate']); ?>
							</td>
						</tr>
					</table>
				</div>
				<div class="contentbox" style=" background-color:#cccccc1a;">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td align="left" valign="top"><i class="fa fa-user-circle-o" aria-hidden="true" style="font-size: 28px;color: #ffffff73; margin-top:2px;"></i></td>
							<td width="85%" align="left" valign="top" style="padding-left:5px;">
								<div style="margin-bottom:2px; font-size:12px;"><?php echo showClientTypeUserName($resultpage['clientType'], $resultpage['companyId']); ?></div>
								<div style="margin-bottom:2px; font-size:12px;"><?php echo $resultpage['guest1phone']; ?></div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="left" valign="top">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" align="left" valign="top"><?php if ($getphone != '') { ?>
								<div style="margin-bottom:2px; font-size:12px;"><a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=&source=&data=" target="_blank"><img src="images/whatsapp-button.png" width="107" border="0" /></a></div>
								<?php } ?>
							</td>
						</tr>
					</table>
				</div>
				<div class="contentbox" style="padding:5px; background-color:#232a32;">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="2">
								<div class="lables">From</div> <?php
								$myArray = explode(',', $resultpage['fromdestinationId']);
								foreach ($myArray as $did) {
									if ($did != '') {
								// 		$select4 = 'name';
								// 		$where4 = 'id="' . $did . '"';
								// 		$rs4 = GetPageRecord($select4, _DESTINATION_MASTER_, $where4);
								// 		$cityname = mysqli_fetch_array($rs4);
										$cityNameVal .= getDestination($did) . ', ';
									}
								}
								echo rtrim($cityNameVal, ', '); ?>
							</td>
							<td align="center">
								<div class="lables">
								&nbsp;</div><i class="fa fa-long-arrow-right" aria-hidden="true" style="    color: #ffffff94;
								font-size: 18px;"></i>
							</td>
							<td align="right">
								<div class="lables">
								To </div>
								<?php
								if ($resultpage['destinationId'] != '' && $resultpage['destinationId'] != '0') {
    								$myArray = explode(',', $resultpage['destinationId']);
    								foreach ($myArray as $my_Array) {
        								if ($my_Array != '') {
        								    $tode = $my_Array;
        								}
    								}
    								if ($tode != '') {
        								// $select4 = 'name';
        								// $where4 = 'id="' . $tode . '"';
        								// $rs4 = GetPageRecord($select4, _DESTINATION_MASTER_, $where4);
        								// $cityname = mysqli_fetch_array($rs4);
        								echo getDestination($tode);
    								}
								}
								?>
							</td>
						</tr>
					</table>
				</div>
				<div class="contentbox" style="padding:5px;">
					<table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#a4afb9" class="boxc" style="font-size:11px;">
						<tr>
							<td width="8%" align="center" valign="top" class="he">Duration&nbsp;</td>
							<td width="30%" align="left" valign="top" class="he">Destination</td>
							<?php if ($resultpage['dayWise'] != 2) { ?><td width="31%" align="left" valign="top" class="he">Date</td><?php } ?>
						</tr>
						<?php
						$n = 1;
						/*$todatem='';
						$destinationnameid='';
						$fnights='0';
						$nights='0';
						$select='';
						$where='';
						$rs='';
						$select='*'; */
						$rs1 = "";
						//echo 'queryId="'.$resultpage['id'].'" order by srdate asc';
						$rs1 = GetPageRecord('*', 'packageQueryDays', 'queryId="' . $resultpage['id'] . '" order by srdate asc');
						while ($packageQueryData = mysqli_fetch_array($rs1)) {
						//resListing
						?>
						<tr>
							<td align="center" valign="top">Day&nbsp;<?php echo $n; ?></td>
							<td align="left" valign="top"><?php echo getDestination($packageQueryData['cityId']); ?></td>
							<?php if ($resultpage['dayWise'] != 2) { ?> <td align="left" valign="top"><?php echo date('d-m-Y', strtotime($packageQueryData['srdate'])); ?></td><?php } ?>
						</tr>
						<?php $n++;
						}  ?>
					</table>
				</div>
				<div class="contentbox" style="padding:0px;">
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Nights</div><?php echo $resultpage['night']; ?>
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Adult</div><?php echo $resultpage['adult']; ?>
									<input type="hidden" id="adult" name="adult" value="<?php echo $resultpage['adult']; ?>" />
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px;padding:4px;">
									<div class="lables">Child</div><?php echo $resultpage['child']; ?> <input type="hidden" id="child" name="child" value="<?php echo $resultpage['child']; ?>" />
								</div>
							</td>
						</tr>
					</table>
				</div> 
				<?php
				if ($resultpage['childrensage'] != '') {
				?>
				<div class="contentbox" style="padding:5px;">
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td align="left">
								<?php
								$string = preg_replace('/\.$/', '', $resultpage['childrensage']);
								$chi = 1;
								$array = explode(',', $string);
								foreach ($array as $value) {
								if ($value != '') {
								?>
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Child <?php echo $chi; ?>: <span style="color:#FFF;"><?php echo $value; ?></span> Years </div>
								</div>
								<?php
								$chi++;
								}
								}
								?>
							</td>
						</tr>
					</table>
				</div>
				<?php } ?>
				<hr />
				<div class="contentbox" style="padding:0px;">
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="33%" align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">SGL</div><?php echo $resultpage['sglRoom']; ?>
								</div>
							</td>
							<td width="33%" colspan="2" align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">DBL</div><?php echo $resultpage['dblRoom']; ?>
								</div>
							</td>
							<td width="33%" align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">TPL</div><?php echo $resultpage['tplRoom']; ?>
								</div>
							</td>
						</tr>
						<tr>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">TWIN</div><?php echo $resultpage['twinRoom']; ?>
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">CWB</div><?php echo $resultpage['cwbRoom']; ?>
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">CNB</div><?php echo $resultpage['cnbRoom']; ?>
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">E.Bed</div><?php echo $resultpage['extraNoofBed']; ?>
								</div>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="33%" align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables"> Budget</div>
									<?php if ($resultpage['expectedSales'] == '' || $resultpage['expectedSales'] == 0) {
										echo "-";
									} else {
										echo ($resultpage['expectedSales']);
									} ?>
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px;padding:4px;">
									<div class="lables">&nbsp;</div>
								</div>
							</td>
						</tr>
					</table>
					</div>
				<div class="contentbox">
					<div class="lables">Room Preference</div>
					<?php echo $resultpage['twin']; ?>
				</div>
				<div class="contentbox" style="padding:0px;"></div>
				<?php if ($resultpage['clientType'] == 222) { ?>
				<div class="contentbox">
					<div class="lables">Meal Preference</div> <?php
						$select = '*';
						$where = ' id="' . $contantnamemain['mealPreference'] . '"  ';
						$rs = GetPageRecord($select, 'mealPreference', $where);
						while ($resListing = mysqli_fetch_array($rs)) {
							echo $resListing['name'];
						}
						if ($contantnamemain['name'] == '0') {
							echo 'NA';
					} ?>
					<br />
					<br />
					<div class="lables">Physical Condition</div> <?php
							$select = '*';
							$where = ' id="' . $contantnamemain['physicalCondition'] . '"  ';
							$rs = GetPageRecord($select, 'physicalCondition', $where);
							while ($resListing = mysqli_fetch_array($rs)) {
								echo $resListing['name'];
							}
							if ($contantnamemain['name'] == '0') {
								echo 'NA';
					} ?>
					<br />
					<br />
					<div class="lables">Seat Preference</div> <?php echo $contantnamemain['seatPreference'];
						if ($contantnamemain['seatPreference'] == '') {
							echo 'NA';
					} ?>
				</div>
				<?php } ?>
				<?php if ($resultpage['tourType'] == '' || $resultpage['tourType'] == '0') {
				} else { ?>
				<div class="contentbox">
					<div class="lables">Tour Type</div> <?php
					$select = '*';
					$where = ' id="' . $resultpage['tourType'] . '"  ';
					$rs = GetPageRecord($select, _TOUR_TYPE_MASTER_, $where);
					while ($resListing = mysqli_fetch_array($rs)) {
					echo $resListing['name'];
					} ?>
				</div>
				<?php } ?>
				<?php if ($resultpage['assignTo'] != '') { ?>
				<div class="contentbox">
					<div class="lables">Operation Person</div> <?php
						$selectu = '*';
						$whereu = ' id="' . $resultpage['assignTo'] . '"  ';
						$rsu = GetPageRecord($selectu, _USER_MASTER_, $whereu);
						while ($resListingu = mysqli_fetch_array($rsu)) {
							echo $resListingu['firstName'] . ' ' . $resListingu['lastName'];
					} ?>
				</div>
				<?php } ?>
				<?php if (trim($resultpage['additionalInfo']) != '') { ?>
				<div class="contentbox">
					<div class="lables">Additional Info</div>
					<?php echo  stripslashes($resultpage['additionalInfo']); ?>
				</div>
				<?php } ?>
				<?php if (trim($resultpage['vehicleId']) > 0) {
				$rss = GetPageRecord('*', _VEHICLE_MASTER_MASTER_, ' 1 and id="' . $resultpage['vehicleId'] . '" order by id asc');
				$resListingv = mysqli_fetch_array($rss);
				?>
				<div class="contentbox">
					<div class="lables">Vehicle Prefrence</div>
					<?php echo  stripslashes($resListingv['model']); ?>
				</div>
				<?php } ?>
			</div>
</td>
<?php } ?>
    <td width="15%" align="left" valign="top" class="queryleft" style="display:none;">
    	<div class="innerdiv" style="width:100% !important;">
	
		<div class="contentbox" style="background-color: rgba(0,0,0,0.2);"><div class="lables">Query ID</div> 
		<div style="font-size:24px;"><?php echo $displayId; ?></div>
		</div>
		
		<div class="contentbox">
		  <div class="lables">Query Date</div> 
		  <?php echo showdate($quotationData['fromDate']); ?>	</div>
		
		<div class="contentbox">
		  <div class="lables">Check In</div> 
		  <?php echo showdate($quotationData['fromDate']); ?>	</div>
		
		<div class="contentbox">
		  <div class="lables">Check Out</div> 
		  <?php echo showdate($quotationData['toDate']); ?>	</div>
		
		 
		<div class="contentbox">
		  <div class="lables">Destination&nbsp;</div><?php
		$cityIdQuery=$ctn="";
		$cityIdQuery=GetPageRecord('cityId','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'"  and addstatus=0 group by cityId');
		while($cityIdData=mysqli_fetch_array($cityIdQuery)){
			$ctn .= getDestination($cityIdData['cityId']).", ";
		} echo rtrim($ctn,', ');
		?></div>
		 
		<div class="contentbox">
		  <table width="100%" border="0" cellpadding="2" cellspacing="0">
	          <tr>
	            <td align="center"><div style="background-color:#232a32; margin-right:2px; padding:4px;"><div class="lables">Adult</div><?php echo $quotationData['adult']; ?></div></td>
	            <td align="center" ><div style="background-color:#232a32; margin-right:2px;padding:4px;"><div class="lables">Child</div><?php echo $quotationData['child']; ?></div></td>
	            </tr>
	        </table>   
		</div>
	
		<div class="contentbox">
		  <table width="100%" border="0" cellpadding="2" cellspacing="0">
	          <tr>
	            <td align="center" ><div style="background-color:#232a32; margin-right:2px;padding:4px;"><div class="lables">Nights</div><?php echo $quotationData['night']; ?></div></td>
	            <td align="center" ><div style="background-color:#232a32;padding:4px;font-size: 10px;">
	              <div class="lables">Rooms</div>
	              <?php 
				  $sglR = "";
				  if($quotationData['sglRoom']>0){ $sglR .= "SGL ".$quotationData['sglRoom'].", "; }
				  if($quotationData['dblRoom']>0){ $sglR .= "DBL ".$quotationData['dblRoom'].", "; }
				  if($quotationData['twinRoom']>0){ $sglR .= "TWIN ".$quotationData['twinRoom'].", "; }
				  if($quotationData['tplRoom']>0){ $sglR .= "TPL ".$quotationData['tplRoom'].", "; }
				  echo rtrim($sglR,", ");  ?></div></td>
	          </tr>
	        </table>   
		</div>
		  
		<?php if($resultpage['guest1']!=''){ ?>
		<div class="contentbox">
		  <div class="lables">Guest 1</div> 
		  <?php echo ($resultpage['guest1']); ?>	</div>
		<?php } ?>
		<?php if($resultpage['guest1phone']!=''){ ?>
		<div class="contentbox">
		  <div class="lables">Guest 1 Phone</div> 
		  <?php echo ($resultpage['guest1phone']); ?>	</div>
		<?php } ?>
		<?php if($resultpage['guest1email']!=''){ ?>
		<div class="contentbox">
		  <div class="lables">Guest 1 Email</div> 
		  <?php echo ($resultpage['guest1email']); ?>	</div>
		<?php } ?>
		<div class="contentbox">
		  <div class="lables">Payment Mode</div> 
		  <?php if($resultpage['paymentMode']==1){ echo 'BTC'; } else { echo 'Direct Payment'; } ?>
		</div>
		<?php if($resultpage['guest2']!=''){ ?>
		<div class="contentbox">
		  <div class="lables">Guest 2</div> 
		  <?php echo ($resultpage['guest2']); ?>	</div>
		<?php } ?>
		 <div class="contentbox" ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>" style="color:#fff;  font-size:12px;" target="_blank">View Full Details</a> </div>
		
		 
	</div>
	</td>
	<!-- end of the left sidebar -->

	<!-- start of the right panel -->

    <td width="85%" align="left" valign="top" class="queryright">
	
		<div class="contentboxaddagent">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody><tr>
			<td><div class="headingm" style="margin-left:20px;">Payment Request</div></td> 
			<td width="10%"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId);?>&b2bquotation=1">
				<input type="button" name="Submit22" value="Back" class="whitembutton"></a></td> 
		</tr>
		</tbody>
		</table>
		</div>
		<style>
			.activey{padding:10px 20px; float:left;  font-size:15px;background-color:#ffc115 !important; color:#fff !important; margin-left:5px;  border:1px solid #fff; font-weight:bold;}
			.activewhite{background-color:#fff; color:#000; border:1px solid #fff;padding:10px 20px; float:left;  font-size:15px;}
			 
			.clientcommubox{background-color:#fff; border:1px #b5cae0 solid; display: inline-table; width:30%; margin:0px 10px; text-align:left;height: 464px;}
			.clientcommubox .h{background-color:#f6fafe; color:#6f8ba9; padding:15px; font-weight:500; text-transform:uppercase;border-bottom:1px #b5cae085 solid; }
			.maintoph{background-color:#f6fafe; color:#6f8ba9; padding:15px; font-weight:500; text-transform:uppercase;border-bottom:1px #b5cae085 solid; }
			.clientcommubox .bodycontbox{padding:15px; border-bottom:1px #b5cae085 solid; color:#516b88;}
			.clientcommubox .textfieldb{padding:10px; border:1px #b5cae085 solid; width:40px;  }
			.clientcommubox .bodycontboxfooter{padding:15px;  color:#516b88; background-color:#dfebf6;}
			.clientcommubox .buttonbox{padding:15px;}

			.costtabsbox {
			    float: left;
			    text-align: right;
			    margin-right: 10px;
			    padding: 5px 15px;
			    border-radius: 4px;
			    box-shadow: 2px 2px 1px #5077994a;
			    background-color: #f6fafe;
			    padding-top: 10px;
			}

			.paymentboxtable {
			       border-bottom: 1px #b5cae085 solid !important; padding:7px;
			    background-color: #fff !important; font-weight:500 !important;  color:#6f8ba9 !important; font-weight:normal !important;
			}

			.paymentboxtablelist {
			       border-bottom: 1px #b5cae085 solid !important; padding:7px;
			    background-color: #fff !important;
			}
			.costtabamt{
				font-size:12px; text-transform:uppercase;text-align: right; margin-bottom: 4px;font-weight:500; color: #5f81a3;
			}
		</style>
		<div style="overflow:hidden; border-bottom:2px #ffc115 solid; height:43px;">
			<a  href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo $_REQUEST['id']; ?>"  class="activewhite<?php if($_REQUEST['dmc']!=1 && $_REQUEST['rem']!=1 && $_REQUEST['sup']!=1){ ?> activey<?php } ?>">Supplier Payment Request</a>

				
			
				<a  href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo $_REQUEST['id']; ?>&dmc=1" class="activewhite<?php if($_REQUEST['dmc']==1){ ?> activey<?php } ?>">Agent Payment Request</a>
		</div>

	<!-- start agent / client payment code -->
	<?php 
	// dmc - client payment request box
	if($_REQUEST['dmc']==1){
		if($_REQUEST['alert']==1){ ?>
			<script>
			alert('Please cancel the invoice to cancel the query');	
			</script>	
			<?php 
		}
		?>	
		<div  style="padding: 10px 18px; background-color:#FBFBFB; display:none;border-bottom: 2px #ccc solid;" id="invoicetop">
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
			  <tr>
			    <td colspan="2" align="left" style="font-size:20px;"><strong>Invoice</strong></td>
			    <td align="right"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&invoice=1" target="_blank"><input name="addnewuserbtn" type="button" class="greenmbutton3 submitbtn" id="addnewuserbtn" value="Send Invoice"   style="margin-right:0px;"></a><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Back" onclick="loadPaymentRequestdmc('','');$('#invoicetop').hide();" style="margin-right:0px;"></td>
			  </tr>
			</table>
		</div>

		<!-- load agent/client complete page here -->
		<div id="loadPaymentRequestdmc"></div>
		<script type="text/javascript">
			function loadPaymentRequestdmc(deleteid,savereqeust){
				$('#loadPaymentRequestdmc').load('loadPaymentRequestdmc.php?id=<?php echo ($queryId); ?>&paymentid=<?php echo $_REQUEST['id']; ?>&deleteId='+deleteid+'&savereqeust='+savereqeust)
			}
			loadPaymentRequestdmc('','');
			function invoicedmc(){ 
				$('#loadPaymentRequestdmc').load('loaddmcinvoice.php?id=<?php echo ($queryId); ?>');
			}
		</script>
		<?php 
	} 
	
	if($_REQUEST['dmc']!=1){ ?>

	 	<!-- supplier paid payment listing -->
	 	<div class="paymentboxmain" style="background-color:#ffffff;border-bottom:0px;padding: 7px;">

			<table width="100%" border="0" cellpadding="0" cellspacing="0" style=" border-bottom: 0px;">
			<tr>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Supplier Name</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Payment Type</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Amount</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Attachement</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Payment By</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Remarks</th>
				<th style="background-color: #eae9ee !important;text-align: left;" class="paymentboxtable">Added By</th>
			</tr>
			<?php
			// $totalpaid=0;
			$s=1;  
			$rs2=GetPageRecord('*','supplierPaymentMaster','1 and quotationId="'.$quotationId.'" and paymentStatus=1 order by supplierStatusId,dateAdded ASC'); 
			while($supplierPaidData=mysqli_fetch_array($rs2)){ 
				?>
				  <tr>
				    <td class="paymentboxtable">
					<?php
					if($supplierPaidData['supplierStatusId']!='0'){
						$rs1="";  
						$rs1=GetPageRecord('supplierId','finalQuotSupplierStatus',' id="'.$supplierPaidData['supplierStatusId'].'"'); 
						$supplierStatusD=mysqli_fetch_array($rs1);

						$rs21="";  
	 					$rs21=GetPageRecord("*",_SUPPLIERS_MASTER_,'id="'.$supplierStatusD['supplierId'].'"'); 
						$editresultname=mysqli_fetch_array($rs21);
						?><?php echo clean($editresultname['name']);
					}else{ echo 'All Supplier'; }
				 	?>	
				 	</td>
				    <td class="paymentboxtable"><?php if($supplierPaidData['paymentType'] == 1){ echo "On Credit"; }elseif($supplierPaidData['paymentType'] == 2){ echo "Advanced";  }elseif($supplierPaidData['paymentType'] == 3){ echo "Direct&nbsp;Payment";  }else{ echo "Full Payment"; } ?></td>

				    <td class="paymentboxtable"><?php echo $supplierPaidData['amount']; $totalpaid=$supplierPaidData['amount']+$totalpaid; ?></td>
					
				    <td class="paymentboxtable"><?php if($supplierPaidData['fileUpload']!=''){ ?><a href="<?php echo $fullurl; ?>download/<?php echo $supplierPaidData['fileUpload']; ?>" target="_blank">Attachment</a><?php } ?></td>
					<td class="paymentboxtable"><?php echo clean($supplierPaidData['paymentBy']); ?></td>
					
				    <td class="paymentboxtable"><?php echo clean($supplierPaidData['details']); ?></td>
				    <td class="paymentboxtable">
				    	<div><?php 
						$select=''; 
						$where=''; 
						$rs='';  
						$select='firstName,lastName';   
						$where='id="'.$supplierPaidData['addedBy'].'"'; 
						$rs=GetPageRecord($select,_USER_MASTER_,$where); 
						while($userss=mysqli_fetch_array($rs)){  

							echo $userss['firstName'].' '.$userss['lastName'];

						}
						?></div>
						<div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($supplierPaidData['dateAdded'],$loginusertimeFormat);?></div>
					</td>
				    </tr>
					<?php $s++; 
			} ?>
			</table>
			<?php if($s==1){ ?>
			<div style="text-align:center;display:nones;" class="paymentboxtable">No Payment History -  </div>
			<?php } ?>
		</div>
		
		<!-- supplierPendingamount -->
		<?php 
		$exrs = GetPageRecord('*','quotationExpensesMaster',' queryId="'.$queryId.'"');
		while($expenseData = mysqli_fetch_assoc($exrs)){
			$expenseAmount = $expenseAmount + $expenseData['expenseAmount'];
		}

		// costing components
		$companyCost = $prmData['totalCompanyCost'];
		$clientCost = $prmData['totalClientCost'];
		$currencyId = $prmData['currencyId'];

		$totalMarkupCost = $prmData['totalMarkupCost'];
		$totalISOCost = $prmData['totalISOCost'];
		$totalConsortiaCost = $prmData['totalConsortiaCost'];
		$totalClientCommCost = $prmData['totalClientCommCost'];
		$totalDiscountCost = $prmData['totalDiscountCost'];
		$totalServiceTaxCost = $prmData['totalServiceTaxCost'];
		$totalTCSCost = $prmData['totalTCSCost'];

		// calcuations
		$totalExpenseCost = $expenseAmount;
		$totalPendingAmt = $companyCost-$totalpaid;
		?>
	 	<div style="padding:10px 20px; overflow:hidden;text-align:left; margin-top:0px; background-color:#a7bed5;border-bottom: 1px solid #fff;">
		 <div class="costtabsbox" style="float:right; margin-right: 0px;cursor:pointer;" 
				<?php 
				  if($quotationData['queryType']==13){ ?>
					onclick="alertspopupopen('action=addCostSheet_MultiServices&quotationId=<?php echo $quotationId; ?>','1300px','auto');" 
					<?php
				}else{
				if($quotationData['calculationType']==2){ ?>
				onclick="alertspopupopen('action=addCostSheet_packagewise&quotationId=<?php echo $quotationId; ?>','1300px','auto');" 
				<?php }elseif($quotationData['calculationType']==3){ ?>
				onclick="alertspopupopen('action=addCostSheet_completepackage&quotationId=<?php echo $quotationId; ?>','1100px','auto');"
				<?php }else{ ?>
				onclick="<?php if($quotationData['quotationType'] == 2 && $quotationData['status']!=1){ ?>alertspopupopen('action=selectCostSheet&quotationId=<?php echo $quotationId; ?>','400px','auto');<?php } else{ ?>alertspopupopen('action=addCostSheet&quotationId=<?php echo $quotationId; ?>','1300px','auto');<?php } ?>"
				<?php } } ?> >
				<div style="font-size:12px; text-transform:uppercase; font-weight:500; color: #5f81a3;"><span style=" color: #6f6f6f; text-transform: uppercase;  font-weight: 500;">Suppliers</span></div>
				<div style="font-size:24px">Cost Sheet</div> 
		 	</div>
		</div>
	 	<div style="padding:10px 20px; overflow:hidden;text-align:left; margin-top:0px; background-color:#a7bed5;border-bottom: 1px solid #fff;">
		 <div  class="costtabsbox">
				<div class="costtabamt">Currency</div>
				<div style="font-size:24px;text-align:left;" id="totalCompanyCost">
					<?php echo getCurrencyName($currencyId); ?>
				</div>
			</div>

			<div  class="costtabsbox">
				<div class="costtabamt">Purchase</div>
				<div style="font-size:24px;" id="totalCompanyCost">
					<?php
				
					if($quotationData['isSer_Mark']==1 && $quotationData['isUni_Mark']==0 && $quotationData['calculationType']!=3){
						$companyCost = $companyCost-$totalMarkupCost;
					}
				
					echo round($companyCost); ?>
				</div>
			</div>

			<div  class="costtabsbox">
				<div class="costtabamt">Paid Amt</div>
				<div style="font-size:24px;color:#009900;" id="totalCompanyCost"><?php echo round($totalpaid);?></div>
			</div>

		 	<div  class="costtabsbox">
				<div class="costtabamt">Pending Amt</div>
				<div style="font-size:24px; text-align:right;" ><?php 
					if(empty($totalPendingAmt)){  ?>
					<div style="font-size:24px;  color:#009900;" id="totalPending">Paid</div>
					<?php } else { ?>
					<div style="font-size:24px; color:#CC3300;text-align:right;" id="totalPending"><?php echo $totalPendingAmt; ?></div>
					<?php } ?>
				</div>
			</div>
			<div  class="costtabsbox">
				<div class="costtabamt">Sell Amt</div>
				<div style="font-size:24px;" id="totalClientCost"><?php echo round($clientCost); ?></div>
			</div>

			<div  class="costtabsbox">
				<div class="costtabamt">Tax Amt</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalServiceTaxCost); ?></div>
			</div>

			<div  class="costtabsbox">
				<div class="costtabamt">TCS Amt</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalTCSCost); ?></div>
			</div>
			<!-- <div  class="costtabsbox">
				<div class="costtabamt">Commission*</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalISOCost+$totalConsortiaCost+$totalClientCommCost); ?></div>
			</div> -->
			<div  class="costtabsbox">
				<div class="costtabamt">Discount</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalDiscountCost); ?></div>
			</div>
			<div  class="costtabsbox">
				<div class="costtabamt">Expenses</div>
				<div style="font-size:24px;" id="totalTaxAmount"><?php echo round($totalExpenseCost); ?></div>
			</div>
			<div  class="costtabsbox">
				<div class="costtabamt">
					<span style=" color: #6f6f6f; font-size: 12px; text-transform: uppercase;  font-weight: 500;">Net Margin</span>
				</div>
				<div style="font-size:24px;" id="totalMargin"><?php echo round($totalMarkupCost-$totalExpenseCost-$totalDiscountCost); ?></div>
		 	</div>

				
		</div>
		<?php 	
		$namevalue ='supplierPendingamount="'.$totalPendingAmt.'",queryId="'.$queryId.'"';   
		$where='id="'.clean($prmData['id']).'"';  
		$voucherlastid = updatelisting(_PAYMENT_REQUEST_MASTER_,$namevalue,$where);  
		?>
	 	<!-- load supplier payment page  -->
     	<div id="loadpaymentsupplierlist"></div>
		<script>
		function loadsupplistmain(){
		$('#loadpaymentsupplierlist').load('loadpaymentsupplierlist.php?paymentId=<?php echo $prmData['id']; ?>&queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>');
		}
		loadsupplistmain();
		</script>
		<?php 
	} 
?>
</td>
</tr>
</table>

<div style="display:none;" id="changequerystatusdiv"></div>

<script>  
function changequerystatus(id){  
$('#changequerystatusdiv').load('frmaction.php?action=changequerymailstatus&id='+id);  
}


function showcontenttab(id){
$('.displaytab').hide();
$('.querymaillisting').show();
$('#maintab'+id).hide();
$('#displaymaintab'+id).show();
}
function hidecontenttab(id){
$('#maintab'+id).show();
$('#displaymaintab'+id).hide();
}
$('#replymainbox').hide();
comtabopenclose('linkbox','op2');
</script>

<?php } ?>