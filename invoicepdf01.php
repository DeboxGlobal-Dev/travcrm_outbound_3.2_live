<?php

ob_start();
ob_clean();
ob_end_clean();
error_reporting(0);
include "inc.php";

$select='*'; 
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$resultInvoiceSetting=mysqli_fetch_array($rs); 

$select5='*';  
$where5='addressType="invoicesetting" and addressParent="1" '; 
$rs5=GetPageRecord($select5,_ADDRESS_MASTER_,$where5); 
$address5 =mysqli_fetch_array($rs5); 

$compnysetting = '';
$compnysetting = GetPageRecord('*','companySettingsMaster','id="1" ');
$companyPAN = mysqli_fetch_assoc($compnysetting);

 $invoiceId=decode($_GET['id']);
if($invoiceId!='' && is_numeric($invoiceId)){
	 
	$rs='';   
	$rs=GetPageRecord('*',_INVOICE_MASTER_,'id='.$invoiceId); 
	$invmData=mysqli_fetch_array($rs); 
	
	$invoiceNotes=$invmData['invoiceNotes']; 
	$quotationId=$invmData['quotationId']; 
	$invmData['invoiceType']; 


	$rshsn = GetPageRecord('*','sacCodeMaster','id="'.$invmData['hsnCode'].'"');
	$hsnData = mysqli_fetch_assoc($rshsn);
	$hsnCodetotalinv = $hsnData['sacCode'];

  $rs=''; 
  $rs=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,'quotationId="'.$quotationId.'"'); 
  $prmData=mysqli_fetch_array($rs); 
  $paymentId = $prmData['id'];

  $totalCompanyCost = $prmData['totalCompanyCost'];
  $totalClientCost = round($prmData['totalClientCost'],2);
  $totalISOCost = $prmData['totalISOCost'];
  $totalConsortiaCost = $prmData['totalConsortiaCost'];
  $totalClientCommCost = $prmData['totalClientCommCost'];

  $totalClientCostWithMarkup = round($prmData['totalClientCostWithMarkup']+$totalISOCost+$totalConsortiaCost+$totalClientCommCost);

  $totalMarkupCost = $prmData['totalMarkupCost'];
  $totalServiceTaxCost = $prmData['totalServiceTaxCost'];
  $totalTCSCost = $prmData['totalTCSCost'];
  $totalDiscountCost = $prmData['totalDiscountCost'];

  $sglBasisCost = $prmData['sglBasisCost'];
  $dblBasisCost = $prmData['dblBasisCost'];
  $twinBasisCost = $prmData['twinCost'];
  $tplBasisCost = $prmData['tplBasisCost'];
  $extraAdultBasisCost = $prmData['extraAdultCost'];
  $CWBBasisCost = $prmData['CWBCost'];
  $CNBBasisCost = $prmData['CNBCost'];

  $currencyId = $prmData['currencyId'];
  
  $gstType = $prmData['gstType'];
  $serviceTax = $prmData['serviceTax'];

  $tcsTax = $prmData['tcsTax'];
  $commissionType = $prmData['commissionType'];
  $ISOCommission = $prmData['ISOCommission'];
  $ConsortiaCommission = $prmData['ConsortiaCommission'];
  $ClientCommission = $prmData['ClientCommission'];
  $discountType = $prmData['discountType'];
  $discount = $prmData['discount']; 

  $currencyId = ($currencyId>0)?$currencyId:$baseCurrencyId;

  $quotQuery="";
  $quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" and status=1 '); 
  $quotationData=mysqli_fetch_array($quotQuery);

  $totalPax = $quotationData['adult']+$quotationData['child']+$quotationData['infant'];
  $totalAdult = $quotationData['adult'];
  $totalChild = $quotationData['child'];
  $totalInfant = $quotationData['infant'];

	$noofpax = $quotationData['adult']+$quotationData['child'];
	$costType = $quotationData['costType'];
	$dayroe = $quotationData['dayroe'];
	$queryId=$quotationData['queryId']; 

  $qrQuery='';   
  $qrQuery=GetPageRecord('*',_QUERY_MASTER_,'id='.$queryId); 
  $queryData=mysqli_fetch_array($qrQuery); 

  $leadPaxNam = $queryData['leadPaxName'];
	$subject = ($quotationData['subject']!='')?$quotationData['subject']:$queryData['subject'];

	if($queryData['clientType']=='1'){
		$select4='*';
		$where4='id='.$queryData['companyId'].'';
		$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4);
		$resultCompany=mysqli_fetch_array($rs4);
		$mobilemailtype='corporate';
	}
	if($queryData['clientType']=='2'){
		$select4='*';
		$where4='id='.$queryData['companyId'].'';
		$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4);
		$resultCompany=mysqli_fetch_array($rs4);
		$mobilemailtype='contacts';
	}
	$operationPerson = getUserName($queryData['assignTo']);
	$salesPerson = getUserName($resultCompany['assignTo']);

	$select4='*';  
	$where4='addressType="'.$mobilemailtype.'" and addressParent="'.$editresult['companyId'].'"'; 
	$rs4=GetPageRecord($select4,_ADDRESS_MASTER_,$where4); 
	$address=mysqli_fetch_array($rs4); 

}

if($_GET['id']!='' && is_numeric(decode($_GET['id']))){
	
	// $select='';
	// $where='';
	// $rs='';
	// $select='*';
	// $id=clean(decode($_GET['id']));
	// $where='id='.$id.'';
	// $rs=GetPageRecord($select,_INVOICE_MASTER_,$where);
	// $resultInvoice=mysqli_fetch_array($rs);
	// $hsnCode = $invmData['hsnCode'];
	// if($invmData['quotationId'] == 0){
	// $quotationDataq = '0';
	// }
	// else{
	// $quotationDataq = trim($invmData['quotationId']);
	// }
	// $totaltaxamount11 = $invmData['stg']+$invmData['cgst']+$invmData['tcs'];
	// $totaligsttcsAMT = $invmData['igst']+$invmData['tcs'];
	
	
	// $select1='*';
	// $where1='id='.$invmData['queryId'].'';
	// $rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1);
	// $queryData=mysqli_fetch_array($rs1);
	
	
	
	// $quotQuery="";
	// $quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$queryData['id'].'" and id="'.$quotationDataq.'" and status=1 ');
	// $quotationData=mysqli_fetch_array($quotQuery);
	// $quotationId = $quotationData['id'];


 
	// $select='';
	// $where='';
	// $rs='';
	// $select='*';
	// $where='queryId="'.$invmData['queryId'].'" and quotationId="'.$quotationDataq.'" order by id desc';
	// $rs=GetPageRecord($select,_AGENT_PAYMENT_REQUEST_,$where);
	// $requesetdata=mysqli_fetch_array($rs);
	
	// $reqclientGst=$requesetdata['reqclientGst'];
	// $reqmarginGst=$requesetdata['reqmarginGst'];
	// $reqclientTCS=$requesetdata['reqclientTCS'];
	// if($reqclientTCS!=0){
	// 	$reqclientTCS=$requesetdata['reqclientTCS'];
	// 	$finalCost = $requesetdata['finalCost'];
	// }	
	
	// if($reqclientGst!=0){
	// $GST=$requesetdata['reqclientGst'];
	// $Cgst=$requesetdata['reqclientCGst'];
	// $Sgst=$requesetdata['reqclientSGst'];
	// $Igst=$requesetdata['reqclientIGst'];
	// $finalReqCost=$requesetdata['reqclientCost'];
	// $finalCost = $requesetdata['finalCost'];
	// }

	// if($reqmarginGst!=0){
	// $GST=$requesetdata['reqmarginGst'];
	// $Cgst=$requesetdata['reqmarginCGst'];
	// $Sgst=$requesetdata['reqmarginSGst'];
	// $Igst=$requesetdata['reqmarginIGst'];
	// $finalReqCost=$requesetdata['reqmarginCost'];
	// }
	
	//-------------------------------------------------------------Get Address------ ------------------------------------
	
	// $totaltaxamount='';
	// $select='';
	// $where='';
	// $rs='';
	// $select='*';
	// $where='id=1';
	// $rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where);
	// $resultInvoiceSetting=mysqli_fetch_array($rs);
}


// $whereops='id="'.$queryData['assignTo'].'"';  
// $rsop=GetPageRecord('*',_USER_MASTER_,$whereops); 
// $resListingops=mysqli_fetch_array($rsop);
// $operationPerson=$resListingops['firstName'].' '.$resListingops['lastName'];

// $whereSale='id="'.$resultCompany['assignTo'].'"';  
// $rsSal=GetPageRecord('*',_USER_MASTER_,$whereSale); 
// $resListingSales=mysqli_fetch_array($rsSal);
// $resListingSales['firstName'].' '.$resListingSales['lastName'];
?>
<html doctype='html'>
<body> 
<?php
$logoPath1 = "dirfiles/".$masterProposalLogo;
if($masterProposalLogo!='' && file_exists($logoPath1)==true){ ?>
<!-- <footer>
    <img src="<?php echo $fullurl.$logoPath1; ?>" width="700" height="80" style="margin:auto" />
</footer> -->
<style type="text/css"> 
    footer{
        position: fixed;
        bottom: -20px;
        height: 80px;
        /*background-color: #ff0000;*/
        color: #000;
        width:100%;
        /*border:1px solid green;*/
        text-align: center; 
    }
</style>
<?php } ?>
<div style="color:#000000;font-family: 'Roboto', sans-serif!important">
<table width="100%" border="0" style="max-height:50px;border-collapse: collapse;" ><tbody>
    <tr><td style=" font-size:22px; line-height:1;" align="center" >
        <span class="style3" ><?php if($invmData['invoiceType']=='1'){ echo 'TAX INVOICE'; } else { echo 'PROFORMA INVOICE'; } ?></span>
        </td></tr>
		</tbody>
	</table>
	<br> 
	<style type="text/css">
	    @page {
            margin: 20px 60px !important;
            padding: 0 !important;
        } 
	</style>
	<table width="100%" border="1" style="border:1px solid #000000; border-bottom: 0px solid #000000;border-collapse: collapse;" cellpadding="0" celspacing="0">
		<tbody>
			<tr>
				<td align="center" valign="middle" height="65" width="30%">
					<?php $logoPath = "dirfiles/".$resultInvoiceSetting['logo'];
					if($resultInvoiceSetting['logo']!='' && file_exists($logoPath)==true){
					?>
					<img align="center" src="<?php echo $fullurl.$logoPath; ?>" width="140" height="60" >
				<?php } ?>
				</td>
				<td width= "70%" style="font-size: 11px; ">
				    <strong>&nbsp;<?php echo $resultInvoiceSetting['companyname']; ?></strong><br>
				    <strong>&nbsp;Address:</strong>&nbsp;<?php echo $resultInvoiceSetting['address']; ?><br>
				    <strong>&nbsp;Contact:</strong>&nbsp;<?php echo $resultInvoiceSetting['phone']; ?><br> 
				    <strong>&nbsp;Email: </strong>&nbsp;<?php echo $resultInvoiceSetting['email']; ?>
				    <strong>&nbsp;Website: </strong>&nbsp;<?php echo $resultInvoiceSetting['website']; ?><br>
				    <strong>&nbsp;GSTIN/UIN:</strong>&nbsp;<?php echo$companyPAN['gst'] ?>
				    <strong>&nbsp;PAN:</strong>&nbsp;<?php echo $companyPAN['panInformation']; ?><br>
				    <strong>&nbsp;CIN:</strong>&nbsp;<?php echo $companyPAN['CINnumber']; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- Second Table start -->
	
	<table  width="100%" border="1" bordercolor="#000000" cellpadding="0" style="font-size: 13px;border-collapse: collapse; border-top: 0px solid #fff;">
		<tbody>
			<tr>
				<td width="45%" rowspan="5" style="font-size: 12px;">
					<strong>&nbsp;Bill To:&nbsp;&nbsp;<?php echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></strong><br>
					<strong>&nbsp;Address:&nbsp;</strong><?php echo $resultCompany['address1'].' '.$resultCompany['pinCode'] ; ?><br>
					<strong>&nbsp;Phone:&nbsp;</strong><?php echo $queryData['guest1phone']; ?><br>
					<strong>&nbsp;Email:&nbsp;</strong><?php echo $queryData['guest1email']; ?><br>
					<strong>&nbsp;GSTIN/UIN:&nbsp;</strong><?php echo $resultCompany['gstn'] ?><br>
					<strong>&nbsp;PAN:&nbsp;</strong><?php echo $resultCompany['panInformation']; ?><br>
					<strong>&nbsp;State&nbsp;/&nbsp;Country&nbsp;Name:&nbsp;</strong><?php if($resultCompany['stateId']!=''){ echo getStateName($resultCompany['stateId']).' '.'/'; } ?> <?php echo getCountryName($resultCompany['countryId']); ?>
				</td> 
				<td width="25%"><strong>&nbsp;</strong>Invoice No:<strong>&nbsp;<?php echo makeInvoiceId($invmData['id']); ?></strong></td>
				<td width="30%"><strong>&nbsp;</strong>Date:<strong>&nbsp;<?php echo date("j M Y", strtotime($invmData['invoicedate'])); ?></strong></td>
			</tr>
			<tr> 
				<td><strong>&nbsp;</strong>Reference No:<strong>&nbsp;<?php echo $invmData['referNo']; ?></strong></td>
			    <td><strong>&nbsp;</strong>File No.:<strong>&nbsp;<?php if($invmData['referNo']!=''){ echo $invmData['fileNo']; }  ?></strong> </td>
			</tr>
			<tr>
				<td><strong>&nbsp;</strong>Tour Id:<strong>&nbsp;<?php if($invmData['fileNo']!=''){ echo $invmData['tourId']; } ?></strong></td>
				<td><strong>&nbsp;</strong>Due Date:<strong>&nbsp;<?php echo date("d-m-Y", strtotime($invmData['dueDate']));?></strong></td>
			</tr>
      <tr>
				<td><strong>&nbsp;</strong>Currency:<strong>&nbsp;<?php echo getCurrencyName($currencyId); ?></strong></td>
				<td><strong>&nbsp;</strong>Guest:<strong>&nbsp;<?php echo $invmData['guestName'];?></strong></td>
			</tr>
			<tr>
				<td colspan="2" style="height: 45px; font-size: 14px; "><strong>&nbsp;</strong>Place of Delivery :<strong>&nbsp;<?php echo ($invmData['deliveryPlace']); ?></strong></td>
			</tr>
		</tbody>	
	</table>

	<?php if($invmData['invoiceFormat']==1){ ?>
	<table width="100%" border="1" cellpadding="3" bordercolor="#000000" style="border-collapse: collapse; border-top: 0px solid #fff;">
		<tbody>
			<tr style="height: 25px;">
				<td width="6%" style="font-size: 13px; text-align:center;"><strong>SN</strong></td>
				<td width="39%" style="font-size: 13px;text-align:center;"><strong>Particulars</strong></td>
				
				<td width="17%" style="font-size: 13px;text-align:center;"><strong>HSN/SAC</strong></td>
				<td width="15%" style="font-size: 13px;text-align:center;"><strong>GST RATE</strong></td>
				<td width="15%" style="font-size: 13px;text-align:center;"><strong>PAX</strong></td>
				<td width="23%" style="font-size: 13px;text-align:right;"><strong>Amount&nbsp;<span style="
				font-size:10px;">(In<strong>&nbsp;</strong><?php echo getCurrencyName($currencyId); ?>)</span></strong></td>		
			</tr>

			<tr height="80">
				<td width="6%" style="text-align: center;">1</td>
				<td width="39%" valign="middle" style="font-size: 13px; text-align:left;">
					<?php echo $invmData['particularsubject']; ?>
				</td>
				<td width="17%" valign="middle" style="text-align:center;"> <?php echo $hsnCodetotalinv; ?></td>
				<td align="center" valign="middle" width="15%" style="font-size: 13px;"> 
					<strong><br><?php 
					if($serviceTax>0 && $gstType==1){ echo 'CGST '.round($serviceTax/2,2).'%' .'<br>'; }else{ echo '<br>'; }
					if($serviceTax>0 && $gstType==1){ echo 'SGST '.round($serviceTax/2,2). '%'.'<br>'; }else{ echo '<br>'; }
					if($serviceTax>0 && $gstType==2){ echo '<br>IGST '.round($serviceTax).'%'.'<br>'; }else{ echo '<br>'; }
					if($serviceTax>0 && $gstType==3){ echo '<br>GST '.round($serviceTax).'%'.'<br>'; }else{ echo '<br>'; }
					if($tcsTax>0 || $totalTCSCost>0){ echo 'TCS '.$tcsTax.'% '.'<br>'; } 
					?></strong>
				</td>
				<td width="10%" valign="middle" style="text-align:center;"> <?php echo $noofpax; ?></td>
				<td width="32%" align="right" valign="middle" width="15%" style="font-size: 13px;" ><strong><?php 
					echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCostWithMarkup)); ?><br><?php 
					if($totalServiceTaxCost>0 && $gstType==1){  echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,($totalServiceTaxCost/2)).'<br>' ; }else{ echo '<br>'; }
					if($totalServiceTaxCost>0 && $gstType==1){  echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,($totalServiceTaxCost/2)).'<br>' ; }else{ echo '<br>'; }
					if($totalServiceTaxCost>0 && $gstType==2){ echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalServiceTaxCost).'<br>' ; } else{ echo '<br>'; }
					if($totalServiceTaxCost>0 && $gstType==3){ echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalServiceTaxCost).'<br>' ; } else{ echo '<br>'; }
					if($tcsTax>0 || $totalTCSCost>0){ echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalTCSCost).'<br>' ; }  ?>
					 </strong> </td>
			</tr>
			
			<tr style="height: 15px;"> 
				<td width="15%" colspan="5" style="font-size: 13px;text-align:center;"><strong>Total</strong></td>
				<td width="23%" style="font-size: 13px; text-align: right;"><strong><?php echo $totalClientCostInWord = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCost));?></strong></td>		
			</tr> 
			<tr>
				<td colspan="6" style="font-size: 12px; height:20px; line-height:1.5;">
					<strong>Amount&nbsp;Chargeble(In&nbsp;<?php echo getCurrencyName($currencyId); ?>) &nbsp;:&nbsp;<?php
					echo convertNumberToWordsForIndia(round($totalClientCostInWord)); 
					?></strong>
				</td>	
			</tr>

		</tbody>
	</table> 
	<?php }elseif($invmData['invoiceFormat']==2){ ?>
		
		<style>
			.itemwisecls tr td{
				font-size: 13px;
			}
		</style>
		<table width="100%" border="1" cellpadding="3" bordercolor="#000" class="itemwisecls" style="border-collapse: collapse; border-top: 0px solid #fff;">
        <tr style="color: #fff;background: #000;">
         
          <td width="45%" style="font-size: 14px; text-align:center;">Particulars</td>
          <td style="font-size: 14px; text-align:center;">HSN/SAC</td>
          <td align="center" width="10%" style="font-size: 14px; text-align:center;">PP&nbsp;Cost</td>
          <td width="10%" align="center" style="font-size: 14px; text-align:center;">No.&nbsp;Of&nbsp;Pax</td>
          
          <td width="10%" align="right" style="font-size: 13px; text-align:center;">Total&nbsp;Amount</td>
        </tr>
        <?php 

              $c12 = GetPageRecord('*', 'quotationServiceMarkup', ' quotationId="'.$quotationId.'"');
              $serviceMarkuD = mysqli_fetch_array($c12);

              $isUni_Mark = $quotationData['isUni_Mark'];
              $isSer_Mark = $quotationData['isSer_Mark'];
              if($isSer_Mark == 1 && $isUni_Mark == 0){
                $hotel = $serviceMarkuD['hotel'];
                $hotelMarkupType = $serviceMarkuD['hotelMarkupType'];
                $transfer = $serviceMarkuD['transfer'];
                $transferMarkupType = $serviceMarkuD['transferMarkupType'];
                $ferry = $serviceMarkuD['ferry'];
                $ferryMarkupType = $serviceMarkuD['ferryMarkupType'];
                $train = $serviceMarkuD['train'];
                $trainMarkupType = $serviceMarkuD['trainMarkupType'];
                $flight = $serviceMarkuD['flight'];
                $flightMarkupType = $serviceMarkuD['flightMarkupType'];
                $guide = $serviceMarkuD['guide'];
                $guideMarkupType = $serviceMarkuD['guideMarkupType'];
                $activity = $serviceMarkuD['activity'];
                $activityMarkupType = $serviceMarkuD['activityMarkupType'];
                $entrance = $serviceMarkuD['entrance'];
                $entranceMarkupType = $serviceMarkuD['entranceMarkupType'];
                $restaurant = $serviceMarkuD['restaurant'];
                $restaurantMarkupType = $serviceMarkuD['restaurantMarkupType'];
                $visa = $serviceMarkuD['visa'];
                $visaMarkupType = $serviceMarkuD['visaMarkupType'];
                $passport = $serviceMarkuD['passport'];
                $passportMarkupType = $serviceMarkuD['passportMarkupType'];
                $insurance = $serviceMarkuD['insurance'];
                $insuranceMarkupType = $serviceMarkuD['insuranceMarkupType'];
                $other = $serviceMarkuD['other']; 
                $otherMarkupType = $serviceMarkuD['otherMarkupType']; 
                // $markupType = $serviceMarkuD['hotelMarkupType'];
              }else{
                $serviceMarkup = $serviceMarkuD['hotel'];
                $markupType = $serviceMarkuD['hotelMarkupType'];
              }
        $hsn = 0;
        // $rs1 = GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and manualStatus="3" group by hotelId order by fromDate asc');
        // if(mysqli_num_rows($rs1)>0){
        //   $hsn = 1;
        // while($finalQuoteHotel = mysqli_fetch_array($rs1)){
          
        $rs1 = GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and manualStatus="3" group by hotelId order by fromDate asc');
        if(mysqli_num_rows($rs1)>0){
          $hsn = 1;
        while($finalQuoteHotelRate = mysqli_fetch_array($rs1)){

            $rs2 = GetPageRecord('*','packageBuilderHotelMaster','id="'.$finalQuoteHotelRate['hotelId'].'"');
            $hotelData = mysqli_fetch_assoc($rs2);

            $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$hsn.'" and serviceType="hotel"');
            $invoiceDetail = mysqli_fetch_assoc($invD);

            $rs22 = GetPageRecord('*','roomTypeMaster','id="'.$finalQuoteHotelRate['roomType'].'"');
            $roomTypeD = mysqli_fetch_assoc($rs22);

            $totalsingle = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomSingleCost'])*$finalQuoteHotelRate['roomSingle']);
              

            $totaldouble = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomDoubleCost'])*$finalQuoteHotelRate['roomDouble']);

            $tatalTriple = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomTripleCost'])*$finalQuoteHotelRate['roomTriple']);
          
            
            $tatalTwin = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomTwinCost'])*$finalQuoteHotelRate['roomTwin']);

            $tatalEBedC = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomEBedCCost'])*$finalQuoteHotelRate['roomEBedC']);

            $tatalENBedC = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomENBedCCost'])*$finalQuoteHotelRate['roomENBedC']);
            
            $tatalEBedA = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['roomEBedACost'])*$finalQuoteHotelRate['roomEBedA']);

            $totalquadRoom = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['quadRoomCost'])*$finalQuoteHotelRate['quadNoofRoom']);

            $totalteenRoom = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['teenRoomCost'])*$finalQuoteHotelRate['teenNoofRoom'];

            $totalsixBedRoom = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['sixBedRoomCost'])*$finalQuoteHotelRate['sixNoofBedRoom']);

            $totaleightBedRoom = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['eightBedRoomCost'])*$finalQuoteHotelRate['eightNoofBedRoom']);

            $totaltenBedRoom = (convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tenBedRoomCost'])*$finalQuoteHotelRate['tenNoofBedRoom']);
            
            if($finalQuoteHotelRate['complimentaryBreakfast'] == 1){
              $BreakfastCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['BreakfastCost']);
            }
            if($finalQuoteHotelRate['complimentaryLunch'] == 1){
              $LunchCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['LunchCost']);
            }
            if($finalQuoteHotelRate['complimentaryDinner'] == 1){
              $DinnerCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['DinnerCost']); 
            }
            if($finalQuoteHotelRate['isChildDinner'] == 1){
              $childDinnerCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childDinnerCost']); 
            }
            if($finalQuoteHotelRate['isChildLunch'] == 1){
              $childLunchCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childLunchCost']); 
            }
            if($finalQuoteHotelRate['isChildBreakfast'] == 1){
              $childBreakfastCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childBreakfastCost']); 
            }

            $totalComplimentaryA = $LunchCost+$DinnerCost+$BreakfastCost;
            $totalComplimentaryC = $childDinnerCost+$childLunchCost+$childBreakfastCost;
            // Get Markup 
            
            
            if($isSer_Mark == 1 && $isUni_Mark == 0){
              $complemetaryMarkupC = getMarkupCost($totalComplimentaryC, $hotel, $hotelMarkupType);
              $complemetaryMarkupA = getMarkupCost($totalComplimentaryA, $hotel, $hotelMarkupType);
              $singleMarkup = getMarkupCost($totalsingle, $hotel, $hotelMarkupType);
              $doubleMarkup = getMarkupCost($totaldouble, $hotel, $hotelMarkupType);
              $tripleMarkup = getMarkupCost($tatalTriple, $hotel, $hotelMarkupType);
              $twinMarkup = getMarkupCost($tatalTwin, $hotel, $hotelMarkupType);
              $eBEDCMarkup = getMarkupCost($tatalEBedC, $hotel, $hotelMarkupType);
              $eBEDAMarkup = getMarkupCost($tatalEBedA, $hotel, $hotelMarkupType);
              $eNBEDCMarkup = getMarkupCost($tatalENBedC, $hotel, $hotelMarkupType);
              $quadMarkup = getMarkupCost($totalquadRoom, $hotel, $hotelMarkupType);
              $teenMarkup = getMarkupCost($totalteenRoom, $hotel, $hotelMarkupType);
              $sixMarkup = getMarkupCost($totalsixBedRoom, $hotel, $hotelMarkupType);
              $eightMarkup = getMarkupCost($totaleightBedRoom, $hotel, $hotelMarkupType);
              $tenMarkup = getMarkupCost($totaltenBedRoom, $hotel, $hotelMarkupType);
              }else{
              $complemetaryMarkupA = getMarkupCost($totalComplimentaryA, $serviceMarkup, $markupType);
              $complemetaryMarkupC = getMarkupCost($totalComplimentaryC, $serviceMarkup, $markupType);
              $twinMarkup = getMarkupCost($tatalTwin, $serviceMarkup, $markupType);
              $eBEDAMarkup = getMarkupCost($tatalEBedA, $serviceMarkup, $markupType);
              $eNBEDCMarkup = getMarkupCost($tatalENBedC, $serviceMarkup, $markupType);
              $eBEDCMarkup = getMarkupCost($tatalEBedC, $serviceMarkup, $markupType);
              $singleMarkup = getMarkupCost($totalsingle, $serviceMarkup, $markupType);
              $doubleMarkup = getMarkupCost($totaldouble, $serviceMarkup, $markupType);
              $tripleMarkup = getMarkupCost($tatalTriple, $serviceMarkup, $markupType);
              $quadMarkup = getMarkupCost($totalquadRoom, $serviceMarkup, $markupType);
              $teenMarkup = getMarkupCost($totalteenRoom, $serviceMarkup, $markupType);
              $sixMarkup = getMarkupCost($totalsixBedRoom, $serviceMarkup, $markupType);
              $eightMarkup = getMarkupCost($totaleightBedRoom, $serviceMarkup, $markupType);
              $tenMarkup = getMarkupCost($totaltenBedRoom, $serviceMarkup, $markupType);
             }

             $totalComplimentaryCostA = $complemetaryMarkupA+$totalComplimentaryA;
             $totalComplimentaryCostC = $complemetaryMarkupC+$totalComplimentaryC;
             $tatalSingleCost = $singleMarkup+$totalsingle;
             $tatalDoubleCost = $doubleMarkup+$totaldouble;
             $tatalTripleCost = $tripleMarkup+$tatalTriple;
             $tatalTwinCost = $twinMarkup+$tatalTwin;
             $tatalENBedCCost = $eNBEDCMarkup+$tatalENBedC;
             $tatalEBedACost = $eBEDAMarkup+$tatalEBedA;
             $tatalEBedCCost = $eBEDCMarkup+$tatalEBedC;
             $totalquadRoomCost = $quadMarkup+$totalquadRoom;
             $totalteenRoomCost = $teenMarkup+$totalteenRoom;
             $totalsixBedRoomCost = $sixMarkup+$totalsixBedRoom;
             $totaleightBedRoom = $eightMarkup+$totaleightBedRoom;
             $totaltenBedRoomCost = $tenMarkup+$totaltenBedRoom;

                $roomSingleCostA = $tatalSingleCost + $totalComplimentaryCostA;
                $roomDoubleCostA= $tatalDoubleCost+$totalComplimentaryCostA;
                $roomTripleCostA= $tatalTripleCost+$totalComplimentaryCostA;
                $roomTwinCostA= $tatalTwinCost+$totalComplimentaryCostA;
                $roomEBedACostA= $tatalEBedACost+$totalComplimentaryCostA;
                $roomEBedCCostC= $tatalEBedCCost+$totalComplimentaryCostC;
                $roomEBedNCostC= $tatalENBedCCost+$totalComplimentaryCostC;
                $roomquadRoomCost= $totalquadRoomCost+$totalComplimentaryCostA;
                $sixBedRoomCost= $totalsixBedRoomCost+$totalComplimentaryCostA;
                $eightBedRoomCost= $totaleightBedRoomCost+$totalComplimentaryCostA;
                $tenBedRoomCost= $totaltenBedRoomCost+$totalComplimentaryCostA;
                
                
                
                $hperPersonCost = $totalServiceCost/$totalPax;
                

                if($invoiceDetail['sglParticular']!=''){
                  $sglParticular = $invoiceDetail['sglParticular'];
                }else{
                  $sglParticular = $hotelData['hotelName'].'/'.$roomTypeD['name'].'/SGL';
                }

                if($invoiceDetail['sglhsnId']!=''){
                  $sglhsnId = $invoiceDetail['sglhsnId'];
                }else{
                  $sglhsnId = '';
                }

                if($invoiceDetail['dblhsnId']!=''){
                  $dblhsnId = $invoiceDetail['dblhsnId'];
                }else{
                  $dblhsnId = '';
                }

                if($invoiceDetail['tplhsnId']!=''){
                  $tplhsnId = $invoiceDetail['tplhsnId'];
                }else{
                  $tplhsnId = '';
                }

                if($invoiceDetail['dblParticular']!=''){
                  $dblParticular = $invoiceDetail['dblParticular'];
                }else{
                  $dblParticular = $hotelData['hotelName'].'/'.$roomTypeD['name'].'/DBL';
                }

                if($invoiceDetail['tplParticular']!=''){
                  $tplParticular = $invoiceDetail['tplParticular'];
                }else{
                  $tplParticular = $hotelData['hotelName'].'/'.$roomTypeD['name'].'/TPL';
                }

                if($invoiceDetail['twinParticular']!=''){
                  $twinParticular = $invoiceDetail['twinParticular'];
                }else{
                  $twinParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/TWIN';
                }

                if($invoiceDetail['twinhsnId']!=''){
                  $twinhsnId = $invoiceDetail['twinhsnId'];
                }else{
                  $twinhsnId =  '';
                }

                if($invoiceDetail['EBAParticular']!=''){
                  $EBAParticular = $invoiceDetail['EBAParticular'];
                }else{
                  $EBAParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/EBedA';
                }

                if($invoiceDetail['EBAhsnId']!=''){
                  $EBAhsnId = $invoiceDetail['EBAhsnId'];
                }else{
                  $EBAhsnId =  '';
                }

                if($invoiceDetail['EBCParticular']!=''){
                  $EBCParticular = $invoiceDetail['EBCParticular'];
                }else{
                  $EBCParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/EBedC';
                }

                if($invoiceDetail['EBChsnId']!=''){
                  $EBChsnId = $invoiceDetail['EBChsnId'];
                }else{
                  $EBChsnId =  '';
                }

                if($invoiceDetail['EBNParticular']!=''){
                  $EBNParticular = $invoiceDetail['EBNParticular'];
                }else{
                  $EBNParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/ENBedC';
                }

                if($invoiceDetail['EBNhsnId']!=''){
                  $EBNhsnId = $invoiceDetail['EBNhsnId'];
                }else{
                  $EBNhsnId =  '';
                }

                if($invoiceDetail['quadParticular']!=''){
                  $quadParticular = $invoiceDetail['quadParticular'];
                }else{
                  $quadParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/QUAD';
                }

                if($invoiceDetail['quadhsnId']!=''){
                  $quadhsnId = $invoiceDetail['quadhsnId'];
                }else{
                  $quadhsnId =  '';
                }

                if($invoiceDetail['sixParticular']!=''){
                  $sixParticular = $invoiceDetail['sixParticular'];
                }else{
                  $sixParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/SIX';
                }

                if($invoiceDetail['sixhsnId']!=''){
                  $sixhsnId = $invoiceDetail['sixhsnId'];
                }else{
                  $sixhsnId =  '';
                }

                if($invoiceDetail['eightParticular']!=''){
                  $eightParticular = $invoiceDetail['eightParticular'];
                }else{
                  $eightParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/EIGHT';
                }

                if($invoiceDetail['eighthsnId']!=''){
                  $eighthsnId = $invoiceDetail['eighthsnId'];
                }else{
                  $eighthsnId =  '';
                }

                if($invoiceDetail['tenParticular']!=''){
                  $tenParticular = $invoiceDetail['tenParticular'];
                }else{
                  $tenParticular =  $hotelData['hotelName'].'/'.$roomTypeD['name'].'/TEN';
                }

                if($invoiceDetail['tenhsnId']!=''){
                  $tenhsnId = $invoiceDetail['tenhsnId'];
                }else{
                  $tenhsnId =  '';
                }
                
                if($finalQuoteHotelRate['roomSingle']>0 && $roomSingleCostA>0){

        ?>

        <tr>
          <td><?php echo $sglParticular; ?></td>

          <td><?php echo GetHSNCode($sglhsnId); ?>
          </td>

          <td align="right"><?php echo $sglPPCost = round($roomSingleCostA/$finalQuoteHotelRate['roomSingle'],2); ?></td>
          <td align="center"><?php echo $finalQuoteHotelRate['roomSingle']; ?></td>
          <td align="right"><?php echo $serviceCostsgl = $roomSingleCostA; ?></td>
        </tr>
       <?php
      //  $totalServiceCost = $totalServiceCost+$serviceCostsgl;
      
        } 

        if($finalQuoteHotelRate['roomDouble']>0 && $roomDoubleCostA>0){

          ?>

          <tr>
            <td><?php echo $dblParticular; ?></td>

            <td><?php echo GetHSNCode($dblhsnId); ?></td>

            <?php $doublA = $finalQuoteHotelRate['roomDouble']*2; ?>
            <td align="right"><?php echo $dblPPcost = round($roomDoubleCostA/$doublA,2); ?></td>
            <td align="center"><?php echo $doublA; ?></td>
            <td align="right"><?php echo $serviceCostdbl = $roomDoubleCostA; ?></td>
          </tr>
        <?php 
        
        // echo $totalServiceCost = $totalServiceCost+$serviceCostdbl;
          
      } 
       
      if($finalQuoteHotelRate['roomTriple']>0 && $roomTripleCostA>0){

        ?>

        <tr>
          <td><?php echo $tplParticular ; ?></td>

          <td><?php echo GetHSNCode($tplhsnId); ?></td>

          <?php $tripleA = $finalQuoteHotelRate['roomTriple']*3; ?>
          <td align="right"><?php echo $tplPPCost = round($roomTripleCostA/$tripleA,2); ?></td>
          <td align="center"><?php echo $tripleA; ?></td>
          <td align="right"><?php echo $serviceCosttpl = $roomTripleCostA; ?></td>
        </tr>
      <?php 
    } 

    if($finalQuoteHotelRate['roomTwin']>0 && $roomTwinCostA>0){

      ?>

      <tr>
        <td><?php echo $twinParticular; ?></td>

        <td><?php echo GetHSNCode($twinhsnId); ?></td>

        <?php $twinA = $finalQuoteHotelRate['roomTwin']*2; ?>
        <td align="right"><?php echo $twinPPCost = round($roomTwinCostA/$twinA,2); ?></td>
        <td align="center"><?php echo $twinA; ?></td>
        <td align="right"><?php echo $serviceCosttwin = $roomTwinCostA; ?></td>
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['roomEBedA']>0 && $roomEBedACostA>0){

      ?>

 
      <tr>
        <td><?php echo $EBAParticular;  ?></td>

        <td><?php echo GetHSNCode($EBAhsnId); ?></td>

        <?php $EBedA = $finalQuoteHotelRate['roomEBedA']; ?>
        <td align="right"><?php echo $EBAPPCost = round($roomEBedACostA/$EBedA,2); ?></td>
        <td align="center"><?php echo $EBedA ?></td>
        <td align="right"><?php echo $serviceCosteBedA = $roomEBedACostA; ?></td>
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['roomEBedC']>0 && $roomEBedCCostC>0){

      ?>
      <tr>
        <td><?php echo $EBCParticular; ?></td>

        <td><?php echo GetHSNCode($EBChsnId); ?></td>

        <?php $EBedC = $finalQuoteHotelRate['roomEBedC']; ?>
        <td align="right"><?php echo $EBCPPCost = round($roomEBedCCostC/$EBedC,2); ?></td>
        <td align="center"><?php echo $EBedC; ?></td>
        <td align="right"><?php echo $serviceCosteBedC = $roomEBedCCostC; ?></td>
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['roomENBedC']>0 && $roomEBedNCostC>0){

      ?>
      

      <tr>
        <td><?php echo $EBNParticular; ?></td>

        <td><?php echo GetHSNCode($EBNhsnId); ?></td>

        <?php $ENBedC = $finalQuoteHotelRate['roomENBedC']; ?>
        <td align="right"><?php echo $ENBCPPCost = round($roomEBedNCostC/$ENBedC,2); ?></td>
        <td align="center"><?php echo $ENBedC; ?></td>
        <td align="right"><?php echo $serviceCosteNBedC = $roomEBedNCostC; ?></td>
      </tr>
    <?php 
    } 

 

    if($finalQuoteHotelRate['quadNoofRoom']>0 && $roomquadRoomCost>0){

      ?>
     

      <tr>
        <td><?php echo $quadParticular;  ?></td>

        <td><?php echo GetHSNCode($quadhsnId); ?></td>

        <?php $quadNoof = ($finalQuoteHotelRate['quadNoofRoom']*4); ?>
        <td align="right"><?php echo $quadPPCost = round($roomquadRoomCost/$quadNoof,2); ?></td>
        <td align="center"><?php echo $quadNoof; ?></td>
        <td align="right"><?php echo $serviceCosteQuad = $roomquadRoomCost; ?></td>
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['sixNoofBedRoom']>0 && $sixBedRoomCost>0){

      ?>
    
      <tr>
        <td><?php echo $sixParticular; ?></td>

        <td><?php echo GetHSNCode($sixhsnId); ?></td>

        <?php $sixNoof = ($finalQuoteHotelRate['sixNoofBedRoom']*6); ?>
        <td align="right"><?php echo $sixPPCost= round($sixBedRoomCost/$sixNoof); ?></td>
        <td align="center"><?php echo $sixNoof; ?></td>
        <td align="right"><?php echo $serviceCosteSix = $sixBedRoomCost; ?></td>
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['eightNoofBedRoom']>0 && $eightBedRoomCost>0){

      ?>
  
      <tr>
        <td><?php echo $eightParticular; ?></td>

        <td><?php echo GetHSNCode($eighthsnId); ?></td>

        <?php $eightNoof = ($finalQuoteHotelRate['eightNoofBedRoom']*8); ?>
        <td align="right"><?php echo $eightPPCost = round($eightBedRoomCost/$eightNoof,2); ?></td>
        <td align="center"><?php echo $eightNoof; ?></td>
        <td align="right"><?php echo $serviceCosteEight = $eightBedRoomCost; ?></td>
      </tr>
    <?php 
    } 

    if($finalQuoteHotelRate['tenNoofBedRoom']>0 && $tenBedRoomCost>0){

      ?>
      
      <tr>
        <td><?php echo $tenParticular ; ?></td>

        <td><?php echo GetHSNCode($tenhsnId); ?></td>

        <?php $tenNoof = ($finalQuoteHotelRate['tenNoofBedRoom']*10); ?>
        <td align="right"><?php echo $tenPPCost = ($tenBedRoomCost/$tenNoof); ?></td>
        <td align="center"><?php echo $tenNoof; ?></td>
        <td align="right"><?php echo $serviceCosteTen = $tenBedRoomCost; ?></td>
      </tr>
      
    <?php 
    } 
        $totalHotelServiceCost = $serviceCostsgl+$serviceCostdbl+$serviceCosttpl+$serviceCosttwin+$serviceCosteBedA+$serviceCosteBedC+$serviceCosteNBedC+$serviceCosteQuad+$serviceCosteSix+$serviceCosteEight+$serviceCosteTen;

        $grandHotelServiceCost=$grandHotelServiceCost+$totalHotelServiceCost;

    $hsn++;
   } 
  }
 
  // }
    $tpt = 0;
    $rt1 = GetPageRecord('*','finalQuotetransfer','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="transfer") order by fromDate asc');
    if(mysqli_num_rows($rt1)>0){
      $tpt = 1;
      while($finalQuotetransfer = mysqli_fetch_assoc($rt1)){

        $rt2 = GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuotetransfer['transferId'].'"');
        $transferData = mysqli_fetch_assoc($rt2);

        $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$tpt.'" and serviceType="transfer"');
        $invoiceDetail = mysqli_fetch_assoc($invD);

        if($finalQuotetransfer['transferType']=='1'){

          if($invoiceDetail['adultParticular']!=''){
            $adultParticular = $invoiceDetail['adultParticular'];
          }else{
            $adultParticular = $transferData['transferName'].'/SIC/Transfer';
          }
  
          if($invoiceDetail['adulthsnId']!=''){
            $adulthsnId = $invoiceDetail['adulthsnId'];
          }else{
            $adulthsnId = '';
          }

          if($invoiceDetail['childParticular']!=''){
            $childParticular = $invoiceDetail['childParticular'];
          }else{
            $childParticular = $transferData['transferName'].'/SIC/Child/Transfer';
          }
  
          if($invoiceDetail['childhsnId']!=''){
            $childhsnId = $invoiceDetail['childhsnId'];
          }else{
            $childhsnId = '';
          }
  
          if($invoiceDetail['infantParticular']!=''){
            $infantParticular = $invoiceDetail['infantParticular'];
          }else{
            $infantParticular = $transferData['transferName'].'/SIC/Infant/Transfer';
          }
  
          if($invoiceDetail['infanthsnId']!=''){
            $infanthsnId = $invoiceDetail['infanthsnId'];
          }else{
            $infanthsnId = $invoiceDetail['infanthsnId'];
          }

        $repCost = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['repCost']);
        $adultCostTPTNM = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['adultCost'])+$repCost;
        $childCostTPTNM = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['childCost'])+$repCost;
        $infantCostTPTNM = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['infantCost'])+$repCost;
        }else{

          $vehicleCostNM = convert_to_base($finalQuotetransfer['currencyValue'],$baseCurrencyVal,$finalQuotetransfer['vehicleCost'])*$finalQuotetransfer['noOfVehicles'];

          if($invoiceDetail['adultParticular']!=''){
            $adultParticular = $invoiceDetail['adultParticular'];
          }else{
            $adultParticular = $transferData['transferName'].'/PVT/Transfer';
          }
  
          if($invoiceDetail['adulthsnId']!=''){
            $adulthsnId = $invoiceDetail['adulthsnId'];
          }else{
            $adulthsnId = '';
          }

        }

        if($isSer_Mark == 1 && $isUni_Mark == 0){
          $tadultMarkup = getMarkupCost($adultCostTPTNM, $transfer, $transferMarkupType);
          $tchildMarkup = getMarkupCost($childCostTPTNM, $transfer, $transferMarkupType);
          $tinfantMarkup = getMarkupCost($infantCostTPTNM, $transfer, $transferMarkupType);
          $tvehicleMarkup = getMarkupCost($vehicleCostNM, $transfer, $transferMarkupType);
          }else{
          $tadultMarkup = getMarkupCost($adultCostTPTNM, $serviceMarkup, $markupType);
          $tchildMarkup = getMarkupCost($childCostTPTNM, $serviceMarkup, $markupType);
          $tinfantMarkup = getMarkupCost($infantCostTPTNM, $serviceMarkup, $markupType);
          $tvehicleMarkup = getMarkupCost($vehicleCostNM, $serviceMarkup, $markupType);
         }

         $adultCostTPT = $tadultMarkup+$adultCostTPTNM;
         $childCostTPT = $tchildMarkup+$childCostTPTNM;
         $infantCostTPT = $tinfantMarkup+$infantCostTPTNM;
         $vehicleCost = $tvehicleMarkup+$vehicleCostNM;



        if($finalQuotetransfer['transferType']=='1'){

        if($totalAdult>0 && $adultCostTPT>0){
        ?>
        
         <tr>
        <td><?php echo $adultParticular; ?></td>

        <td><?php echo GetHSNCode($adulthsnId); ?></td>

        <td align="right"><?php echo $adultCostTPT; ?></td>
        <td align="center"><?php echo $totalAdult; ?></td>
        <td align="right"><?php echo $serviceCosteTPTA = $adultCostTPT*$totalAdult; ?></td>
      </tr>
        <?php
        }

        if($totalChild>0 && $childCostTPT>0){
          ?>
           <tr>
          <td><?php echo $childParticular; ?></td>
  
          <td><?php echo GetHSNCode($childhsnId); ?></td>
  
          <td align="right"><?php echo $childCostTPT; ?></td>
          <td align="center"><?php echo $totalChild; ?></td>
          <td align="right"><?php echo $serviceCosteTPTC = $childCostTPT*$totalChild; ?></td>
        </tr>
          <?php
          }

          if($totalInfant>0 && $infantCostTPT>0){
            ?>
            
             <tr>
            <td><?php echo $infantParticular; ?></td>
    
            <td><?php echo GetHSNCode($infanthsnId); ?></td>
    
            <td align="right"><?php echo $infantCostTPT; ?></td>
            <td align="center"><?php echo $totalInfant; ?></td>
            <td align="right"><?php echo $serviceCosteTPTI = $infantCostTPT*$totalInfant; ?></td>
          </tr>
            <?php
            }
          }else{
            if($totalPax>0 && $vehicleCost>0){
              ?>
               <tr>
              <td><?php echo $adultParticular; ?></td>
      
              <td><?php echo GetHSNCode($adulthsnId); ?></td>
      
              <td align="right"><?php echo $vehiclePPCost = round($vehicleCost/$totalPax,2); ?></td>
              <td align="center"><?php echo $totalPax; ?></td>
              <td align="right"><?php echo $serviceCosteTPTP = $vehicleCost; ?></td>
            </tr>
            
              <?php
              }
            }

            $totalTransferServiceCost = $serviceCosteTPTA+$serviceCosteTPTC+$serviceCosteTPTI+$serviceCosteTPTP;
           $grandTransferServiceCost = $grandTransferServiceCost+$totalTransferServiceCost;
      $tpt++; 
    
    }
  }

    $tptt = 0;
    $rt11 = GetPageRecord('*','finalQuotetransfer','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="transportation")');
    if(mysqli_num_rows($rt11)>0){
      $tptt = 1;
      while($finalQuotetransportation = mysqli_fetch_assoc($rt11)){

        $rt22 = GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuotetransportation['transferId'].'"');
        $transportData = mysqli_fetch_assoc($rt22);

        $tptvehicleCostNM = convert_to_base($finalQuotetransportation['currencyValue'],$baseCurrencyVal,$finalQuotetransportation['vehicleCost'])*$finalQuotetransportation['noOfVehicles'];

        if($isSer_Mark == 1 && $isUni_Mark == 0){
          $transMarkup = getMarkupCost($tptvehicleCostNM, $transfer, $transferMarkupType);
          }else{
          $transMarkup = getMarkupCost($tptvehicleCostNM, $serviceMarkup, $markupType);
         
         }

         $tptvehicleCost = $transMarkup+$tptvehicleCostNM;

        $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$tptt.'" and serviceType="transportation"');
        $invoiceDetail = mysqli_fetch_assoc($invD);

          if($invoiceDetail['adultParticular']!=''){
            $adultParticular = $invoiceDetail['adultParticular'];
          }else{
            $adultParticular = $transportData['transferName'].'/Transportation';
          }
  
          if($invoiceDetail['adulthsnId']!=''){
            $adulthsnId = $invoiceDetail['adulthsnId'];
          }else{
            $adulthsnId = '';
          }

          if($totalPax>0 && $tptvehicleCost>0){
              ?>
               <tr>
              <td><?php echo $adultParticular; ?></td>
      
              <td><?php echo GetHSNCode($adulthsnId); ?></td>
      
              <td align="right"><?php echo $vehiclePPCost = round($tptvehicleCost/$totalPax,2); ?></td>
              <td align="center"><?php echo $totalPax; ?></td>
              <td align="right"><?php echo $serviceCosteTPT = $tptvehicleCost; ?></td>
            </tr>
            
              <?php
              }

                $totalTransport = $totalTransport+$serviceCosteTPT;
              
              $tptt++; }
            }
              // Entrance Services
         $esn = 0;
         $re1 = GetPageRecord('*','finalQuoteEntrance','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="entrance")');
         if(mysqli_num_rows($re1)>0){
          $esn = 1;
        while($finalQuoteEntrance = mysqli_fetch_assoc($re1)){
          $transfertype = $finalQuoteEntrance['transferType'];
          $re22 = GetPageRecord('*','packageBuilderEntranceMaster','id="'.$finalQuoteEntrance['entranceId'].'"');
         $entranceData = mysqli_fetch_assoc($re22);
        
         if($transfertype == 1){
          $entCostANM = ($finalQuoteEntrance['ticketAdultCost']+$finalQuoteEntrance['adultCost']+$finalQuoteEntrance['repCost']);  
          $entCostCNM = ($finalQuoteEntrance['ticketchildCost']+$finalQuoteEntrance['childCost']+$finalQuoteEntrance['repCost']);            
          $entCostENM = ($finalQuoteEntrance['ticketinfantCost']+$finalQuoteEntrance['infantCost']+$finalQuoteEntrance['repCost']);            
          $tptType = "SIC";
      }elseif($transfertype == 2){
          $entCostANM = ($finalQuoteEntrance['ticketAdultCost']+$finalQuoteEntrance['vehicleCost']/$totalPax)+$finalQuoteEntrance['repCost'];
          $entCostCNM = ($finalQuoteEntrance['ticketchildCost']+$finalQuoteEntrance['vehicleCost']/$totalPax)+$finalQuoteEntrance['repCost'];
          $entCostENM = ($finalQuoteEntrance['ticketinfantCost']+$finalQuoteEntrance['vehicleCost']/$totalPax)+$finalQuoteEntrance['repCost'];
          $tptType = "PVT";

      }elseif($transfertype == 3){
          $entCostANM = ($finalQuoteEntrance['ticketAdultCost']);  
          $entCostCNM = ($finalQuoteEntrance['ticketchildCost']);            
          $entCostENM = ($finalQuoteEntrance['ticketinfantCost']);  
          $tptType = "Ticket Only";
      }

      $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$esn.'" and serviceType="entrance"');
      $invoiceDetail = mysqli_fetch_assoc($invD);

      if($invoiceDetail['adultParticular']!=''){
        $adultParticular = $invoiceDetail['adultParticular'];
      }else{
        $adultParticular = $entranceData['entranceName'].'/Adult/Monument/'.$tptType;
      }

      if($invoiceDetail['adulthsnId']!=''){
        $adulthsnId = $invoiceDetail['adulthsnId'];
      }else{
        $adulthsnId = '';
      }
      
      if($invoiceDetail['childParticular']!=''){
        $childParticular = $invoiceDetail['childParticular'];
      }else{
        $childParticular =  $entranceData['entranceName'].'/Child/Monument/'.$tptType;
      }

      if($invoiceDetail['childhsnId']!=''){
        $childhsnId = $invoiceDetail['childhsnId'];
      }else{
        $childhsnId = '';
      }

      if($invoiceDetail['infantParticular']!=''){
        $infantParticular = $invoiceDetail['infantParticular'];
      }else{
        $infantParticular =  $entranceData['entranceName'].'/Infant/Monument/'.$tptType;
      }

      if($invoiceDetail['infanthsnId']!=''){
        $infanthsnId = $invoiceDetail['infanthsnId'];
      }else{
        $infanthsnId = '';
      }
       

      $totalEntCostANM = (convert_to_base($finalQuoteEntrance['currencyValue'],$baseCurrencyVal,$entCostANM));
      $totalEntCostCNM = (convert_to_base($finalQuoteEntrance['currencyValue'],$baseCurrencyVal,$entCostCNM));
      $totalEntCostENM = (convert_to_base($finalQuoteEntrance['currencyValue'],$baseCurrencyVal,$entCostENM));

      if($isSer_Mark == 1 && $isUni_Mark == 0){
        $entMarkupA = getMarkupCost($totalEntCostANM, $entrance, $entranceMarkupType);
        $entMarkupC = getMarkupCost($totalEntCostCNM, $entrance, $entranceMarkupType);
        $entMarkupE = getMarkupCost($totalEntCostENM, $entrance, $entranceMarkupType);
      
        }else{
        $entMarkupA = getMarkupCost($totalEntCostANM, $serviceMarkup, $markupType);
        $entMarkupC = getMarkupCost($totalEntCostCNM, $serviceMarkup, $markupType);
        $entMarkupE = getMarkupCost($totalEntCostENM, $serviceMarkup, $markupType);
       }
       
       $totalEntCostA = $entMarkupA+$totalEntCostANM;
       $totalEntCostC = $entMarkupC+$totalEntCostCNM;
       $totalEntCostE = $entMarkupE+$totalEntCostENM;


          if($totalAdult>0 && $totalEntCostA>0){
              ?>
               <tr>
              <td><?php echo $adultParticular; ?></td>
      
              <td><?php echo GetHSNCode($adulthsnId); ?></td>
      
              <td align="right"><?php echo round($totalEntCostA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCosteEntA = round($totalEntCostA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalEntCostC>0){
                ?>
               
                 <tr>
                <td><?php echo $childParticular; ?></td>
        
                <td><?php echo GetHSNCode($childhsnId); ?></td>
        
                <td align="right"><?php echo round($totalEntCostC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteEntC = round($totalEntCostC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalEntCostE>0){
                  ?>
                    

                   <tr>
                  <td><?php echo $infantParticular; ?></td>
          
                  <td><?php echo GetHSNCode($infanthsnId); ?></td>
          
                  <td align="right"><?php echo round($totalEntCostE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteEntE = round($totalEntCostE*$totalInfant,2); ?></td>
                </tr>
                
                  <?php
                  }

                   $totalEntranceCost = $serviceCosteEntA+$serviceCosteEntC+$serviceCosteEntE;
                    $grandtotalEntranceCost = $grandtotalEntranceCost+$totalEntranceCost;
              $esn++; }
                }

                // Activity Services
         $asn = 0;
         $ra1 = GetPageRecord('*','finalQuoteActivity','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="activity")');
         if(mysqli_num_rows($ra1)>0){
          $asn = 1;
        while($finalQuoteActivity = mysqli_fetch_assoc($ra1)){
          $transfertype = $finalQuoteActivity['transferType'];
          $ra22 = GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$finalQuoteActivity['activityId'].'"');
         $activityData = mysqli_fetch_assoc($ra22);
        
         if($transfertype == 1){
            $actCostA = ($finalQuoteActivity['ticketAdultCost']+$finalQuoteActivity['adultCost']+$finalQuoteActivity['repCost']);  
            $actCostC = ($finalQuoteActivity['ticketchildCost']+$finalQuoteActivity['childCost']+$finalQuoteActivity['repCost']);            
            $actCostE = ($finalQuoteActivity['ticketinfantCost']+$finalQuoteActivity['infantCost']+$finalQuoteActivity['repCost']);                   
          $tptType = "SIC";
      }elseif($transfertype == 2){
          $actCostA = ($finalQuoteActivity['ticketAdultCost']+$finalQuoteActivity['vehicleCost']/$totalPax)+$finalQuoteActivity['repCost'];
          $actCostC = ($finalQuoteActivity['ticketchildCost']+$activityInfo['vehicleCost']/$totalPax)+$finalQuoteActivity['repCost'];
          $actCostE = ($finalQuoteActivity['ticketinfantCost']+$finalQuoteActivity['vehicleCost']/$totalPax)+$finalQuoteActivity['repCost'];
          $tptType = "PVT";

      }elseif($transfertype == 3){
          $actCostA = ($finalQuoteActivity['ticketAdultCost']);  
          $actCostC = ($finalQuoteActivity['ticketchildCost']);            
          $actCostE = ($finalQuoteActivity['ticketinfantCost']);    
          $tptType = "Ticket Only";
      }

      $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$asn.'" and serviceType="activity"');
      $invoiceDetail = mysqli_fetch_assoc($invD);

      if($invoiceDetail['adultParticular']!=''){
        $adultParticular = $invoiceDetail['adultParticular'];
      }else{
        $adultParticular = $entranceData['entranceName'].'/Adult/Monument/'.$tptType;
      }

      if($invoiceDetail['adulthsnId']!=''){
        $adulthsnId = $invoiceDetail['adulthsnId'];
      }else{
        $adulthsnId = '';
      }
      
      if($invoiceDetail['childParticular']!=''){
        $childParticular = $invoiceDetail['childParticular'];
      }else{
        $childParticular =  $activityData['otherActivityName'].'/Child/Sightseeing/'.$tptType;
      }

      if($invoiceDetail['childhsnId']!=''){
        $childhsnId = $invoiceDetail['childhsnId'];
      }else{
        $childhsnId = '';
      }

      if($invoiceDetail['infantParticular']!=''){
        $infantParticular = $invoiceDetail['infantParticular'];
      }else{
        $infantParticular =  $activityData['otherActivityName'].'/Infant/Sightseeing/'.$tptType;
      }

      if($invoiceDetail['infanthsnId']!=''){
        $infanthsnId = $invoiceDetail['infanthsnId'];
      }else{
        $infanthsnId = '';
      }

      

      $totalActCostANM = (convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$actCostA));
      $totalActCostCNM = (convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$actCostC));
      $totalActCostENM = (convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$actCostE));

      if($isSer_Mark == 1 && $isUni_Mark == 0){
        $actMarkupA = getMarkupCost($totalActCostANM, $activity, $activityMarkupType);
        $actMarkupC = getMarkupCost($totalActCostCNM, $activity, $activityMarkupType);
        $actMarkupE = getMarkupCost($totalActCostENM, $activity, $activityMarkupType);
      
        }else{
        $actMarkupA = getMarkupCost($totalActCostANM, $serviceMarkup, $markupType);
        $actMarkupC = getMarkupCost($totalActCostCNM, $serviceMarkup, $markupType);
        $actMarkupE = getMarkupCost($totalActCostENM, $serviceMarkup, $markupType);
       }
       
       $totalActCostA = $actMarkupA+$totalActCostANM;
       $totalActCostC = $actMarkupC+$totalActCostCNM;
       $totalActCostE = $actMarkupE+$totalActCostENM;


          if($totalAdult>0 && $totalActCostA>0){
              ?>
              
               <tr>
              <td><?php echo $adultParticular; ?></td>
      
              <td><?php echo GetHSNCode($adulthsnId); ?></td>
      
              <td align="right"><?php echo round($totalActCostA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCosteActA = round($totalActCostA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalActCostC>0){
                ?>
               
                 <tr>
                <td><?php echo $childParticular; ?></td>
        
                <td><?php echo GetHSNCode($childhsnId); ?></td>
        
                <td align="right"><?php echo round($totalActCostC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteActC = round($totalActCostC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalActCostE>0){
                  ?>
                   <tr>
                  <td><?php echo  $infantParticular; ?></td>
          
                  <td><?php echo GetHSNCode($infanthsnId); ?></td>
          
                  <td align="right"><?php echo round($totalActCostE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteActE = round($totalActCostE*$totalInfant,2); ?></td>
                </tr>
                
                  <?php
                  }

                  $totalActivityCost = $serviceCosteActA+$serviceCosteActC+$serviceCosteActE;
                  $grandTotalActivity = $grandTotalActivity+$totalActivityCost;
              $asn++; }
                }


                $frsn = 0;
                $fra1 = GetPageRecord('*','finalQuoteFerry','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="ferry")');
                if(mysqli_num_rows($fra1)>0){
                 $frsn = 1;
               while($finalQuoteFerry = mysqli_fetch_assoc($fra1)){
                
                 $ra22 = GetPageRecord('*','ferryPriceMaster','id="'.$finalQuoteFerry['ferryId'].'"');
                 $ferryData = mysqli_fetch_assoc($ra22);
               
                $totalFerryA = convert_to_base($finalQuoteFerry['currencyValue'],$baseCurrencyVal,trim($finalQuoteFerry['adultCost']+$finalQuoteFerry['processingfee']+$finalQuoteFerry['miscCost']));
       
               $totalFerryC = $totalFerrySameDayC + convert_to_base($finalQuoteFerry['currencyValue'],$baseCurrencyVal,trim($finalQuoteFerry['childCost']+$finalQuoteFerry['processingfee']+$finalQuoteFerry['miscCost']));
       
               $totalFerryE = $totalFerrySameDayE + convert_to_base($finalQuoteFerry['currencyValue'],$baseCurrencyVal,trim($finalQuoteFerry['infantCost']+$finalQuoteFerry['processingfee']+$finalQuoteFerry['miscCost']));
       
             $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$frsn.'" and serviceType="ferry"');
             $invoiceDetail = mysqli_fetch_assoc($invD);
       
             if($invoiceDetail['adultParticular']!=''){
               $adultParticular = $invoiceDetail['adultParticular'];
             }else{
               $adultParticular = $ferryData['name'].'/Adult/Ferry/'.$tptType;
             }
       
             if($invoiceDetail['adulthsnId']!=''){
               $adulthsnId = $invoiceDetail['adulthsnId'];
             }else{
               $adulthsnId = '';
             }
             
             if($invoiceDetail['childParticular']!=''){
               $childParticular = $invoiceDetail['childParticular'];
             }else{
               $childParticular =  $ferryData['name'].'/Child/Ferry/'.$tptType;
             }
       
             if($invoiceDetail['childhsnId']!=''){
               $childhsnId = $invoiceDetail['childhsnId'];
             }else{
               $childhsnId = '';
             }
       
             if($invoiceDetail['infantParticular']!=''){
               $infantParticular = $invoiceDetail['infantParticular'];
             }else{
               $infantParticular =  $ferryData['name'].'/Infant/Ferry/'.$tptType;
             }
       
             if($invoiceDetail['infanthsnId']!=''){
               $infanthsnId = $invoiceDetail['infanthsnId'];
             }else{
               $infanthsnId = '';
             }
       
           
                 if($isSer_Mark == 1 && $isUni_Mark == 0){
                   $ferryMarkupA = getMarkupCost($totalFerryA, $ferry, $ferryMarkupType);
                   $ferryMarkupC = getMarkupCost($totalFerryC, $ferry, $ferryMarkupType);
                   $ferryMarkupE = getMarkupCost($totalFerryE, $ferry, $ferryMarkupType);
                 
                   }else{
                   $ferryMarkupA = getMarkupCost($totalFerryA, $serviceMarkup, $markupType);
                   $ferryMarkupC = getMarkupCost($totalFerryC, $serviceMarkup, $markupType);
                   $ferryMarkupE = getMarkupCost($totalFerryE, $serviceMarkup, $markupType);
                  }
                  
                  $totalFerryCostA = $ferryMarkupA+$totalFerryA;
                  $totalFerryCostC = $ferryMarkupC+$totalFerryC;
                  $totalFerryCostE = $ferryMarkupE+$totalFerryE;
       
                 if($totalAdult>0 && $totalFerryCostA>0){
                     ?>
                     
                      <tr>
                     <td><?php echo $adultParticular; ?></td>
             
                     <td><?php echo GetHSNCode($adulthsnId); ?></td>
             
                     <td align="right"><?php echo round($totalFerryCostA,2); ?></td>
                     <td align="center"><?php echo $totalAdult; ?></td>
                     <td align="right"><?php echo $serviceCosteFerryA = round($totalFerryCostA*$totalAdult,2); ?></td>
                   </tr>
                     <?php
                     }
       
                     if($totalChild>0 && $totalFerryCostC>0){
                       ?>
                      
                        <tr>
                       <td><?php echo $childParticular; ?></td>
               
                       <td><?php echo GetHSNCode($childhsnId); ?></td>
               
                       <td align="right"><?php echo round($totalFerryCostC,2); ?></td>
                       <td align="center"><?php echo $totalChild; ?></td>
                       <td align="right"><?php echo $serviceCosteActC = round($totalFerryCostC*$totalChild,2); ?></td>
                     </tr>
                       <?php
                       }
       
       
                       if($totalInfant>0 && $totalFerryCostE>0){
                         ?>
                          <tr>
                         <td><?php echo  $infantParticular; ?></td>
                 
                         <td><?php echo GetHSNCode($infanthsnId); ?></td>
                 
                         <td align="right"><?php echo round($totalFerryCostE,2); ?></td>
                         <td align="center"><?php echo $totalInfant; ?></td>
                         <td align="right"><?php echo $serviceCosteActE = round($totalFerryCostE*$totalInfant,2); ?></td>
                       </tr>
                       
                         <?php
                         }
       
                         
                     $frsn++; }
                       }
                   // Restaurant Services
                   $mpsn = 0;
                   $rmp1 = GetPageRecord('*','finalQuoteMealPlan','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="mealplan")');
                   if(mysqli_num_rows($rmp1)>0){
                    $mpsn = 1;
                  while($finalQuoteMealPlan = mysqli_fetch_assoc($rmp1)){
     
                  
                    $totalMealANM = convert_to_base($finalQuoteMealPlan['currencyValue'], $baseCurrencyVal, $finalQuoteMealPlan['adultCost']);

                  
           
                    if($isSer_Mark == 1 && $isUni_Mark == 0){
                      $restMarkupA = getMarkupCost($totalMealANM, $restaurant, $restaurantMarkupType);
                    
                      }else{
                      $restMarkupA = getMarkupCost($totalMealANM, $serviceMarkup, $markupType);
                     }
                     
                     $totalMealA = $$restMarkupA+$totalMealANM;
     
                    //  $totalMealC = convert_to_base($finalQuoteMealPlan['currencyValue'], $baseCurrencyVal, $finalQuoteMealPlan['childCost2']);
     
                    //  $totalMealI = convert_to_base($finalQuoteMealPlan['currencyValue'], $baseCurrencyVal, $finalQuoteMealPlan['infantCost2']);

                    $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$mpsn.'" and serviceType="restaurant"');
                    $invoiceDetail = mysqli_fetch_assoc($invD);
              
                    if($invoiceDetail['adultParticular']!=''){
                      $adultParticular = $invoiceDetail['adultParticular'];
                    }else{
                      $adultParticular = $finalQuoteMealPlan['mealPlanName'].'/Per Person/Restaurant';
                    }
              
                    if($invoiceDetail['adulthsnId']!=''){
                      $adulthsnId = $invoiceDetail['adulthsnId'];
                    }else{
                      $adulthsnId = '';
                    }
                    
                    if($invoiceDetail['childParticular']!=''){
                      $childParticular = $invoiceDetail['childParticular'];
                    }else{
                      $childParticular =  $finalQuoteMealPlan['mealPlanName'].'/Child/Restaurant';
                    }
              
                    if($invoiceDetail['childhsnId']!=''){
                      $childhsnId = $invoiceDetail['childhsnId'];
                    }else{
                      $childhsnId = '';
                    }
              
                    if($invoiceDetail['infantParticular']!=''){
                      $infantParticular = $invoiceDetail['infantParticular'];
                    }else{
                      $infantParticular =  $finalQuoteMealPlan['mealPlanName'].'/Infant/Restaurant';
                    }
              
                    if($invoiceDetail['infanthsnId']!=''){
                      $infanthsnId = $invoiceDetail['infanthsnId'];
                    }else{
                      $infanthsnId = '';
                    }
                    
     
                  
                      if($totalAdult>0 && $totalMealA>0){
                   ?>
                    <tr>
                   <td><?php echo $adultParticular; ?></td>
           
                   <td><?php echo GetHSNCode($adulthsnId); ?></td>
           
                   <td align="right"><?php echo round($totalMealA,2); ?></td>
                   <td align="center"><?php echo ($totalAdult+$totalChild); ?></td>
                   <td align="right"><?php echo $serviceCosteMapA = round($totalMealA*($totalAdult+$totalChild),2); ?></td>
                 </tr>
                   <?php
                   }
     
                   if($totalChildmap>0 && $totalMealC>0){
                     ?>
                     
                     
                      <tr>
                     <td><?php echo $childParticular; ?></td>
             
                     <td><?php echo GetHSNCode($childhsnId); ?></td>
             
                     <td align="right"><?php echo round($totalMealC,2); ?></td>
                     <td align="center"><?php echo $totalChild; ?></td>
                     <td align="right"><?php echo $serviceCosteMapC = round($totalMealC*$totalChild,2); ?></td>
                   </tr>
                     <?php
                     }
     
                     
                
                     if($totalInfantmap>0 && $totalMealI>0){
                       ?>
                        <tr>
                       <td><?php echo $infantParticular ; ?></td>
               
                       <td><?php echo GetHSNCode($infanthsnId); ?></td>
               
                       <td align="right"><?php echo round($totalMealI,2); ?></td>
                       <td align="center"><?php echo $totalInfant; ?></td>
                       <td align="right"><?php echo $serviceCosteMapE = round($totalMealI*$totalInfant,2); ?></td>
                     </tr>
                     
                       <?php
                       }
                       $totalMealPlanCost = $serviceCosteMapA+$serviceCosteMapC+$serviceCosteMapE;
                       $grandTotalmealPlan = $grandTotalmealPlan+$totalMealPlanCost;


                       $mpsn++; }
                      }
                 

                  // Additional Services
              $exsn = 0;
              $rex1 = GetPageRecord('*','finalQuoteExtra','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="additional")');
              if(mysqli_num_rows($rex1)>0){
                $exsn = 1;
             while($finalQuoteExtra = mysqli_fetch_assoc($rex1)){
               
               $rex22 = GetPageRecord('*','extraQuotation','id="'.$finalQuoteExtra['additionalId'].'"');
              $additionalData = mysqli_fetch_assoc($rex22);

            //   if($finalQuoteExtra['costType']==2){
            //     $totalExtraA = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['groupCost']/$totalPax);

            //     $totalExtraC = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['groupCost']/$totalPax);

            //     $totalExtraI = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['groupCost']/$totalPax);
            // }else{
            //     $totalExtraA = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['adultCost']);

            //     $totalExtraC = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['childCost']);

            //     $totalExtraI = convert_to_base($finalQuoteExtra['currencyValue'], $baseCurrencyVal, $finalQuoteExtra['infantCost']);
                
            // }
            if($finalQuoteExtra['groupCost'] > 0 ){
							$totalExtraANM = $finalQuoteExtra['groupCost']/($totalPax+$paxAdultLE+$paxAdultFE);
						}else{
							$totalExtraANM = $finalQuoteExtra['adultCost'];
						}
          
            if($isSer_Mark == 1 && $isUni_Mark == 0){
              $otherMarkupA = getMarkupCost($totalExtraANM, $other, $otherMarkupType);
              }else{
              $otherMarkupA = getMarkupCost($totalExtraANM, $serviceMarkup, $markupType);
            
             }
             
             $totalExtraA = $otherMarkupA+$totalExtraANM;

            $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$exsn.'" and serviceType="additional"');
            $invoiceDetail = mysqli_fetch_assoc($invD);
      
            if($invoiceDetail['adultParticular']!=''){
              $adultParticular = $invoiceDetail['adultParticular'];
            }else{
              $adultParticular = $additionalData['name'].'/Per Pax/Additional';
            }

            if($invoiceDetail['adulthsnId']!=''){
              $adulthsnId = $invoiceDetail['adulthsnId'];
            }else{
              $adulthsnId = '';
            }
            // $totalExtraA+$totalExtraC+$totalExtraI;
             
                 if($totalAdult>0 && $totalExtraA>0){
              ?>
               <tr>
              <td><?php echo $adultParticular; ?></td>
      
              <td><?php echo GetHSNCode($adulthsnId); ?></td>
      
              <td align="right"><?php echo round($totalExtraA,2); ?></td>
              <td align="center"><?php echo $totalPax; ?></td>
              <td align="right"><?php echo $serviceCosteExtA = round($totalExtraA*$totalPax,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalExtraC>0){
                ?>
                 <tr>
                <td><?php echo $additionalData['name'].'/Child/Additional'; ?></td>
        
                <td><?php echo GetHSNCode($adulthsnId); ?></td>
        
                <td align="right"><?php echo round($totalExtraC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteExtC = round($totalExtraC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalExtraI>0){
                  ?>
                   <tr>
                  <td><?php echo $additionalData['name'].'/Infant/Additional'; ?></td>
          
                  <td><?php echo GetHSNCode($adulthsnId); ?></td>
          
                  <td align="right"><?php echo round($totalExtraI,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteExtE = round($totalExtraI*$totalInfant,2); ?></td>
                </tr>
                
                  <?php
                  }
                  $totalExtraCost = $serviceCosteExtA+$serviceCosteExtC+$serviceCosteExtE;
                  $grandTotalExtraCost = $grandTotalExtraCost+$totalExtraCost;

                  $exsn++; }
                }

                         // flight Services
              $flsn = 0;
              $rf1 = GetPageRecord('*','finalQuoteFlights','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="flight")');
         
             while($finalQuoteFlights = mysqli_fetch_assoc($rf1)){
              if(mysqli_num_rows($rf1)>0){
                $flsn = 1;
               $rf22 = GetPageRecord('*','packageBuilderAirlinesMaster','id="'.$finalQuoteFlights['flightId'].'"');
              $flightData = mysqli_fetch_assoc($rf22);

              $totalflightANM = (convert_to_base($finalQuoteFlights['currencyValue'],  $baseCurrencyVal, $finalQuoteFlights['adultCost']));
              $totalflightCNM = (convert_to_base($finalQuoteFlights['currencyValue'], $baseCurrencyVal, $finalQuoteFlights['childCost']));
              $totalflightENM = (convert_to_base($finalQuoteFlights['currencyValue'], $baseCurrencyVal, $finalQuoteFlights['infantCost']));
    
              if($isSer_Mark == 1 && $isUni_Mark == 0){
                $flightMarkupA = getMarkupCost($totalflightANM, $flight, $flightMarkupType);
                $flightMarkupC = getMarkupCost($totalflightCNM, $flight, $flightMarkupType);
                $flightMarkupE = getMarkupCost($totalflightENM, $flight, $flightMarkupType);
                }else{
                $flightMarkupA = getMarkupCost($totalflightANM, $serviceMarkup, $markupType);
                $flightMarkupC = getMarkupCost($totalflightCNM, $serviceMarkup, $markupType);
                $flightMarkupE = getMarkupCost($totalflightENM, $serviceMarkup, $markupType);
               }
               
               $totalflightA = $flightMarkupA+$totalflightANM;
               $totalflightC = $flightMarkupC+$totalflightCNM;
               $totalflightE = $flightMarkupE+$totalflightENM;

               $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$flsn.'" and serviceType="flight"');
               $invoiceDetail = mysqli_fetch_assoc($invD);
         
               if($invoiceDetail['adultParticular']!=''){
                 $adultParticular = $invoiceDetail['adultParticular'];
               }else{
                 $adultParticular =  $flightData['flightName'].'/Adult/Flight';
               }
         
               if($invoiceDetail['adulthsnId']!=''){
                 $adulthsnId = $invoiceDetail['adulthsnId'];
               }else{
                 $adulthsnId = '';
               }
               
               if($invoiceDetail['childParticular']!=''){
                 $childParticular = $invoiceDetail['childParticular'];
               }else{
                 $childParticular =  $flightData['flightName'].'/Child/Flight';
               }
         
               if($invoiceDetail['childhsnId']!=''){
                 $childhsnId = $invoiceDetail['childhsnId'];
               }else{
                 $childhsnId = '';
               }
         
               if($invoiceDetail['infantParticular']!=''){
                 $infantParticular = $invoiceDetail['infantParticular'];
               }else{
                 $infantParticular =  $flightData['flightName'].'/Infant/Flight';
               }
         
               if($invoiceDetail['infanthsnId']!=''){
                 $infanthsnId = $invoiceDetail['infanthsnId'];
               }else{
                 $infanthsnId = '';
               }

              
                 if($totalAdult>0 && $totalflightA>0){
              ?>
              
              
               <tr>
              <td><?php echo $adultParticular ; ?></td>
      
              <td><?php echo GetHSNCode($adulthsnId); ?></td>
      
              <td align="right"><?php echo round($totalflightA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCosteflA = round($totalflightA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totalflightC>0){
                ?>
                
                
                 <tr>
                <td><?php echo $childParticular; ?></td>
        
                <td><?php echo GetHSNCode($childhsnId); ?></td>
        
                <td align="right"><?php echo round($totalflightC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCosteflC = round($totalflightC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totalflightE>0){
                  ?>
                  
                   <tr>
                  <td><?php echo $infantParticular; ?></td>
          
                  <td><?php echo GetHSNCode($infanthsnId); ?></td>
          
                  <td align="right"><?php echo round($totalflightE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCosteflE = round($totalflightE*$totalInfant,2); ?></td>
                </tr>

                
                  <?php
                  }
                  $totalFlightCost = $serviceCosteflA+$serviceCosteflC+$serviceCosteflE;
                  $grandtotalFlightCost = $grandtotalFlightCost+$totalFlightCost;
                  $flsn++; }
                }
                  
                         // Train Services
               $trsn = 0;
              $rt1 = GetPageRecord('*','finalQuoteTrains','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="train")');
                if(mysqli_num_rows($rt1)>0){
                  $trsn = 1;
             while($finalQuoteTrains = mysqli_fetch_assoc($rt1)){
               
               $rt22 = GetPageRecord('*','packageBuilderTrainsMaster','id="'.$finalQuoteTrains['trainId'].'"');
              $trainData = mysqli_fetch_assoc($rt22);

              $totaltrainANM = (convert_to_base($finalQuoteTrains['currencyValue'], $baseCurrencyVal, $finalQuoteTrains['adultCost']));
              $totaltrainCNM = (convert_to_base($finalQuoteTrains['currencyValue'], $baseCurrencyVal, $finalQuoteTrains['childCost']));
              $totaltrainENM = (convert_to_base($finalQuoteTrains['currencyValue'], $baseCurrencyVal, $finalQuoteTrains['infantCost']));

              if($isSer_Mark == 1 && $isUni_Mark == 0){
               $trainMarkupA = getMarkupCost($totaltrainANM, $train, $trainMarkupType);
               $trainMarkupC = getMarkupCost($totaltrainCNM, $train, $trainMarkupType);
               $trainMarkupE = getMarkupCost($totaltrainENM, $train, $trainMarkupType);
               }else{
               $trainMarkupA = getMarkupCost($totaltrainANM, $serviceMarkup, $markupType);
               $trainMarkupC = getMarkupCost($totaltrainCNM, $serviceMarkup, $markupType);
               $trainMarkupE = getMarkupCost($totaltrainENM, $serviceMarkup, $markupType);
              }
              
              $totaltrainA = $trainMarkupA+$totaltrainANM;
              $totaltrainC = $trainMarkupC+$totaltrainCNM;
              $totaltrainE = $trainMarkupE+$totaltrainENM;

               $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$trsn.'" and serviceType="train"');
               $invoiceDetail = mysqli_fetch_assoc($invD);
         
               if($invoiceDetail['adultParticular']!=''){
                 $adultParticular = $invoiceDetail['adultParticular'];
               }else{
                 $adultParticular =  $trainData['trainName'].'/Adult/Train';
               }
         
               if($invoiceDetail['adulthsnId']!=''){
                 $adulthsnId = $invoiceDetail['adulthsnId'];
               }else{
                 $adulthsnId = '';
               }
               
               if($invoiceDetail['childParticular']!=''){
                 $childParticular = $invoiceDetail['childParticular'];
               }else{
                 $childParticular =  $trainData['trainName'].'/Child/Train';
               }
         
               if($invoiceDetail['childhsnId']!=''){
                 $childhsnId = $invoiceDetail['childhsnId'];
               }else{
                 $childhsnId = '';
               }
         
               if($invoiceDetail['infantParticular']!=''){
                 $infantParticular = $invoiceDetail['infantParticular'];
               }else{
                 $infantParticular =  $trainData['trainName'].'/Infant/Train';
               }
         
               if($invoiceDetail['infanthsnId']!=''){
                 $infanthsnId = $invoiceDetail['infanthsnId'];
               }else{
                 $infanthsnId = '';
               }

               
               
               
                 if($totalAdult>0 && $totaltrainA>0){
              ?>
              
               <tr>
              <td><?php echo $adultParticular; ?></td>
      
              <td><?php echo GetHSNCode($adulthsnId); ?></td>
      
              <td align="right"><?php echo round($totaltrainA,2); ?></td>
              <td align="center"><?php echo $totalAdult; ?></td>
              <td align="right"><?php echo $serviceCostetrA = round($totaltrainA*$totalAdult,2); ?></td>
            </tr>
              <?php
              }

              if($totalChild>0 && $totaltrainC>0){
                ?>
                
                
                 <tr>
                <td><?php echo $childParticular; ?></td>
        
                <td><?php echo GetHSNCode($childhsnId); ?></td>
        
                <td align="right"><?php echo round($totaltrainC,2); ?></td>
                <td align="center"><?php echo $totalChild; ?></td>
                <td align="right"><?php echo $serviceCostetrC = round($totaltrainC*$totalChild,2); ?></td>
              </tr>
                <?php
                }


                if($totalInfant>0 && $totaltrainE>0){
                  ?>
                  
                   <tr>
                  <td><?php echo $infantParticular; ?></td>
          
                  <td><?php echo GetHSNCode($infanthsnId); ?></td>
          
                  <td align="right"><?php echo round($totaltrainE,2); ?></td>
                  <td align="center"><?php echo $totalInfant; ?></td>
                  <td align="right"><?php echo $serviceCostetrE = round($totaltrainE*$totalInfant,2); ?></td>
                </tr>
               
                  <?php
                  }
                  $totalTrainCost = $serviceCostetrA+$serviceCostetrC+$serviceCostetrE;
                  $grandTotalTrinCost = $grandTotalTrinCost+$totalTrainCost;
                
                  $trsn++; }
                }

                  $gsn = 0;
                  $rg1 = GetPageRecord('*','finalQuoteGuides','quotationId="'.$quotationId.'" and manualStatus=3 and id in (select serviceId from finalquotationItinerary where serviceType="guide")');
                  $gsn = 1;
                 while($finalQuoteGuides = mysqli_fetch_assoc($rg1)){
                   
                   $rg22 = GetPageRecord('*','tbl_guidesubcatmaster','id="'.$finalQuoteGuides['guideId'].'"');
                  $guideData = mysqli_fetch_assoc($rg22);

                  $totalGuideCostNM=convert_to_base($finalQuoteGuides['currencyValue'],$baseCurrencyVal,$finalQuoteGuides['adultCost']);
                    $allPax = $totalAdult+$totalChild;

                    if($isSer_Mark == 1 && $isUni_Mark == 0){
                      $guideMarkupA = getMarkupCost($totalGuideCostNM, $guide, $guideMarkupType);
                     
                      }else{
                      $guideMarkupA = getMarkupCost($totalGuideCostNM, $serviceMarkup, $markupType);
                      
                     }
                     
                     $totalGuideCost = $guideMarkupA+$totalGuideCostNM;

                    $invD = GetPageRecord('*','invoiceOtherDetailMaster','quotationId="'.$quotationId.'" and invoiceId="'.$invoiceId.'" and serialNo="'.$trsn.'" and serviceType="train"');
                    $invoiceDetail = mysqli_fetch_assoc($invD);
              
                    if($invoiceDetail['adultParticular']!=''){
                      $adultParticular = $invoiceDetail['adultParticular'];
                    }else{
                      $adultParticular =  $guideData['name'].'/Guide';
                    }
              
                    if($invoiceDetail['adulthsnId']!=''){
                      $adulthsnId = $invoiceDetail['adulthsnId'];
                    }else{
                      $adulthsnId = '';
                    }

                if($totalPax>0 && $totalGuideCost>0){
                  ?>
                   <tr>
                  <td><?php echo $adultParticular; ?></td>
          
                  <td><?php echo GetHSNCode($adulthsnId); ?></td>
          
                  <td align="right"><?php echo $perGuideCost = round($totalGuideCost/$allPax,2); ?></td>
                  <td align="center"><?php echo $allPax; ?></td>
                  <td align="right"><?php echo $serviceCostegd = round($perGuideCost*$allPax,2); ?></td>
                </tr>
                
                  <?php
                  }
                    $GrandtotalGuideCost = $GrandtotalGuideCost+$serviceCostegd;
                
                  $gsn++; }
            ?>
            <tr>
              <td align="right" colspan="2">Total</td>
              <td colspan="2"></td>
              <td align="right"><strong><?php echo $prmData['totalClientCostWithMarkup']; ?></strong></td>
            </tr>

            <?php if($gstType==1){ ?>  
          <tr>
            <td align="right" colspan="2" style="padding:8px;">CGST <?php echo ($serviceTax/2); ?>% </td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $cgstCost=round($totalServiceTaxCost/2); ?></strong>
            
            </td>
            </tr>
        <?php } ?>
        <?php if($gstType==1){ ?>  
          <tr>
            <td align="right" colspan="2" style="padding:8px;">SGST <?php echo ($serviceTax/2); ?>% </td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $sgstCost=round($totalServiceTaxCost/2); ?></strong>
             
            </td>
          </tr>
        <?php } ?>
        <?php if($gstType==2){ ?>
          <tr>
            <td align="right" colspan="2" style="padding:8px;"><span class="header">IGST <?php echo $serviceTax; ?>% </span></td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $igstCost=round($totalServiceTaxCost); ?></strong>
              
            </td>
          </tr>
        <?php } ?> 
        <?php if($gstType==3){ ?>
          <tr>
            <td align="right" colspan="2" style="padding:8px;"><span class="header">GST <?php echo $serviceTax; ?>% </span></td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $gstCost=round($totalServiceTaxCost); ?></strong>
              
            </td>
          </tr>
        <?php } ?> 
        <?php if($totalTCSCost!=0){  ?>
         <tr>
            <td align="right" colspan="2" style="padding:8px;"><span class="header">TCS <?php if($tcsTax>0){ echo $tcsTax.'%'; } ?> </span></td>
            <td colspan="2"></td>
              <td align="right" style="padding:8px;"><strong><?php echo $tcsCost=round($totalTCSCost); ?></strong>
              
            </td>
          </tr>
        <?php } ?>
        
        <tr>
          <td align="right" colspan="2" style="padding:8px;">Total&nbsp;Cost&nbsp;In&nbsp;(<?php echo getCurrencyName($currencyId); ?>) </td>
          <td colspan="2"></td>
          <td align="right" style="padding:8px;"><strong><?php echo getChangeCurrencyValue_New($currencyId,$quotationId,$totalClientCost); ?></strong></td>
        </tr> 

        <?php if($currencyId <> $baseCurrencyId){ ?>
        <tr>
          <td align="right" style="padding:8px;">Total&nbsp;Cost&nbsp;In&nbsp;(<?php echo getCurrencyName($currencyId); ?>) </td>
          <td align="right" style="padding:8px;">
            <strong><?php echo getChangeCurrencyValue_New($currencyId,$quotationId,$totalClientCost);  ?>
              
            </strong>
          </td>
        </tr>
        <?php } ?>
    </table>
		
	<?php } ?>

	<table width="100%" style="border-collapse: collapse;">
	<!-- <tr>
		<td width="100%" align="center" style="font-size: 12px; text-align: center;"><br>Kindly make payments of in favour of <b><?php echo $resultInvoiceSetting['companyname']; ?></b></td>
	</tr> -->
	</table>
	<table width="100%" border="1" cellpadding="5" style="border-collapse: collapse;"> 
  <?php $getbank = GetPageRecord('*','bankMaster', 'deletestatus=0 and id="'.$invmData['bankName'].'"');
	 	$bankName = mysqli_fetch_array($getbank );

     if($bankName['title']!=''){
			$title = $bankName['title'];
		 }else{
			$title = 'Branch&nbsp;IFSC';
		 }
     
	 ?>
	<thead>
	<tr style="background-color: #ccc; color: #000;">
		<th width="18%" height="25" style="font-size: 12px; text-align:left;"><b>Bank Name</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Beneficiary Name</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Account Number</b></th>
		<th width="12%" height="25" style="font-size: 12px; text-align:left;"><b>Account Type</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Branch Address</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b><?php echo $title; ?></b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Branch SWIFT Code</b></th>
	</tr>
	</thead>
	 
	 <tbody>
	<tr>
		<td width="18%" height="20" style="font-size: 12px;padding-left:5px;"><?php echo $bankName['bankName']; ?> </td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $invmData['beneficiaryName']; ?></td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $invmData['accountNumber']; ?></td>
		<td width="12%" height="20" style="font-size: 12px; text-align:left;"><?php echo $invmData['accountType']; ?></td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $invmData['branchAddress']; ?></td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $invmData['branchIfsc']; ?></td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $invmData['branchSwiftCode']; ?></td>
	</tr>
	</tbody>
</table>

<table width="100%" style="margin-left: 30px;border-collapse: collapse;">
	<tr>
		<!-- <td width="20%">Company's PAN</td> -->
		<td width="20%">&nbsp; </td>
		<td width="60%"></td>
	</tr>
</table>
<table width="100%">
	<tbody>
	<!-- <tr>
		<td align="center" style="line-height: 0px;">Terms & Conditions</td>
	</tr> -->

	<tr>
		<td style="font-size: 12px;"><b>Remarks</b></td>
	</tr>

	<tr>
		<td style="font-size: 12px;"><?php if($invmData['invoiceNotes']!=''){ 
			echo nl2br(stripslashes($invmData['invoiceNotes'])); 
		} ?></td>
	</tr>

	<tr>
		<td style="font-size: 10px;"><?php if($invmData['terms']!=''){ 
			echo nl2br(stripslashes($invmData['terms']));
			} ?></td>
	</tr>

	<tr>
		<td style="font-size: 10px;"><?php if($invmData['payment']!=''){ 
			echo nl2br(stripslashes($invmData['payment']));
			} ?></td>
	</tr>
	</tbody>
</table>

<table width="100%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" >
	<tbody>
	<tr>
		<td width="50%">
			<?php if($resultInvoiceSetting['showOpsPerson']==1){
				if($operationPerson!=''){ echo '<strong>Operation Person:-</strong> '.$operationPerson.'<br>';}  if($salesPerson!=''){ echo '<strong>Sales Person:-</strong> '.$salesPerson; };
			} ?>
		</td>
		<td width="50%" align="right"  style=" font-size: 14px;"><b>For <?php echo $resultInvoiceSetting['companyname']; ?></b><br><br>Authorised Signature</td>
	</tr>

	<tr>
		<td>&nbsp;</td>
	</tr>
	</tbody>

	</table>
		<!--this is container div  -->
</div>
</body>
</html>   

 