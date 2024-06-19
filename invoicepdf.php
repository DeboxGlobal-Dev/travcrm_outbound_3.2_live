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
<div style="color:#000000;font-family: 'Roboto', sans-serif!important"><table width="100%" border="0" style="max-height:50px;border-collapse: collapse;" ><tbody>
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
				<td width="45%" rowspan="6" style="font-size: 12px;">
					<strong>&nbsp;Bill To:&nbsp;&nbsp;<?php echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']); ?></strong><br>
					<strong>&nbsp;Address:&nbsp;</strong><?php echo $resultCompany['address1'].' '.$resultCompany['pinCode'] ; ?><br>
					<strong>&nbsp;Phone:&nbsp;</strong><?php echo $queryData['guest1phone']; ?><br>
					<strong>&nbsp;Email:&nbsp;</strong><?php echo $queryData['guest1email']; ?><br>
					<strong>&nbsp;GSTIN/UIN:&nbsp;</strong><?php echo $resultCompany['gstn'] ?><br>
					<strong>&nbsp;PAN:&nbsp;</strong><?php echo $resultCompany['panInformation']; ?><br>
					<strong>&nbsp;State&nbsp;/&nbsp;Country&nbsp;Name:&nbsp;</strong><?php if($resultCompany['stateId']!=''){ echo getStateName($resultCompany['stateId']).' '.'/'; } ?> <?php echo getCountryName($resultCompany['countryId']); ?>
				</td> 
				<td width="31%"><strong>&nbsp;</strong>Invoice No:<strong>&nbsp;<?php echo makeInvoiceId($invmData['id']); ?></strong></td>
				<td width="24%"><strong>&nbsp;</strong>Date:<strong>&nbsp;<?php echo date("j M Y", strtotime($invmData['invoicedate'])); ?></strong></td>
			</tr>
			<tr> 
				<td><strong>&nbsp;</strong>Reference No:<strong>&nbsp;<?php echo $invmData['referNo']; ?></strong></td>
				<td><strong>&nbsp;</strong>Due Date:<strong>&nbsp;<?php echo date("d-m-Y", strtotime($invmData['dueDate']));?></strong></td>
			</tr>
			<tr>
				<td><strong>&nbsp;</strong>Tour Id:<strong>&nbsp;<?php if($invmData['fileNo']!=''){ echo $invmData['tourId']; } ?></strong></td>
				<td><strong>&nbsp;</strong>Currency:<strong>&nbsp;<?php echo getCurrencyName($currencyId); ?></strong></td>
			</tr> 
			<tr>
				<td><strong>&nbsp;</strong>Guest Name:<strong>&nbsp;<?php echo $leadPaxNam; ?></strong></td>
				<td><strong>&nbsp;</strong>Total Pax:<strong>&nbsp;<?php echo clean($noofpax);?></strong></td>
			</tr> 
			<tr> 
			    <td colspan="2"><strong>&nbsp;</strong>File No.:<strong>&nbsp;<?php if($invmData['referNo']!=''){ echo $invmData['fileNo']; }  ?></strong> </td>
				  <!-- <td>Total Pax:<strong> <?php echo clean($noofpax);?></strong></td> -->
			</tr>
			<tr>
				<td colspan="2" style="height: 45px; font-size: 14px; "><strong>&nbsp;</strong>Place of Delivery :<strong>&nbsp;<?php echo getStateName($invmData['deliveryPlace']); ?></strong></td>
			</tr>
		</tbody>	
	</table>
	<table width="100%" border="1" cellpadding="3" bordercolor="#000000" style="border-collapse: collapse; border-top: 0px solid #fff;">
		<tbody>
			<tr style="height: 25px;">
				<td width="6%" style="font-size: 13px; text-align:center;"><strong>SN</strong></td>
				<td width="39%" style="font-size: 13px;text-align:center;"><strong>Particulars</strong></td>
				
				<td width="17%" style="font-size: 13px;text-align:center;"><strong>HSN/SAC</strong></td>
				<td width="15%" style="font-size: 13px;text-align:center;"><strong>GST RATE</strong></td>
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
				<td width="15%" colspan="4" style="font-size: 13px;text-align:center;"><strong>Total</strong></td>
				<td width="23%" style="font-size: 13px; text-align: right;"><strong><?php echo $totalClientCost= round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCost));?></strong></td>		
			</tr> 
			<tr>
				<td colspan="5" style="font-size: 12px; height:20px; line-height:1.5;">
					<strong>Amount&nbsp;Chargeble(In&nbsp;<?php echo getCurrencyName($currencyId); ?>) &nbsp;:&nbsp;<?php
					echo convertNumberToWordsForIndia(round($totalClientCost)); 
					?></strong>
				</td>	
			</tr>

		</tbody>
	</table>
	<!-- Fourth Table start -->
	<?php
	// echo $invmData['invoiceType']
 	if($gstType==1 && $serviceTax > 0){ ?>
 		<table width="100%" border="1" bordercolor="#000000" cellpadding="2" style="border-collapse: collapse;border-top: 0px solid #fff;">
			<thead>
				<tr>
					<th rowspan="2" width="22%" valign="center" style="font-size: 12px; text-align: center;">HSN/SAC</th>
					<th rowspan="2" width="10%" style="font-size: 12px; text-align: center;">Taxable<br>Value </th>
					<th colspan="2" width="18%" valign="middle" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">Central Tax</th>
					<th colspan="2" width="18%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">State Tax</th>
					<th colspan="2" width="18%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">TCS</th>
					<th rowspan="2" width="14%" style="font-size: 12px; text-align: center;">Total&nbsp;Tax Amount</th>
				</tr>
				<tr>
					<th width="8%" style="font-size: 12px; height: 25px; text-align:center;">Rate</th>
					<th width="10%" style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
					<th width="8%" style="font-size: 12px; height: 25px;text-align:center;">Rate</th>
					<th width="10%" style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
					<th width="8%" style="font-size: 12px; height: 25px;text-align:center;">Rate</th>
					<th width="10%" style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
				</tr>
				
			</thead>
			<tbody>
					<!-- Include TCS Tax -->
				<tr>
					<td width="22%" valign="center" style="font-size: 12px; text-align: center;"><?php echo $hsnCodetotalinv; ?></td>
					<td width="10%" style="font-size: 12px; text-align: center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCostWithMarkup)); ?></td>
					<td width="8%" style="font-size: 12px; height: 20px;text-align:center;"><?php echo round($serviceTax/2,2).'%'; ?></td>
					<td width="10%" style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,round($totalServiceTaxCost/2))); ?></td>
					<td width="8%" style="font-size: 12px; height: 20px;text-align:center;"><?php echo round($serviceTax/2,2).'%'; ?></td>
					<td width="10%" style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,round($totalServiceTaxCost/2))); ?></td>
					<td width="8%" style="font-size: 12px; height: 20px;text-align:center;"><?php echo $tcsTax.'%'; ?></td>
					<td width="10%" style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalTCSCost)); ?></td>
					
					<td width="14%" style="font-size: 12px; text-align: center;"><?php echo $totalServiceTaxAndTCS = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,round($totalTCSCost+$totalServiceTaxCost))); ?> </td>
				</tr>
				<tr>
				<td colspan="9" style="font-size: 12px; text-align: left; line-height:1.5;">Total Tax Amount in words : (In&nbsp;<?php echo getCurrencyName($currencyId); ?>) <?php if(round($totalServiceTaxAndTCS)>0) { echo convertNumberToWordsForIndia(round($totalServiceTaxAndTCS)); }else{ echo 'NULL'; } ?></td>
				</tr>
			</tbody>
		</table>
		<?php 
	}elseif($gstType==2 && $serviceTax > 0){ ?><table width="100%" border="1" bordercolor="#000000" cellpadding="2" style="border-collapse: collapse;border-top: 0px solid #fff;">
			<thead>
				<tr>
					<th rowspan="2" width="30%" valign="center" style="font-size: 12px; text-align: center;">HSN/SAC</th>
					<th rowspan="2" width="15%" style="font-size: 12px; text-align: center;">Taxable<br>Value </th>
					<th colspan="2" width="20%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">Integrated Tax</th>
					<th colspan="2" width="20%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">TCS</th>
					<th rowspan="2" style="font-size: 12px; text-align: center;">Total&nbsp;Tax Amount</th>
				</tr>
				<tr>
					<th style="font-size: 12px; height: 25px; text-align:center;">Rate</th>
					<th style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
					<th style="font-size: 12px; height: 25px;text-align:center;">Rate</th>
					<th style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td valign="center" style="font-size: 12px; text-align: center;"><?php echo $hsnCodetotalinv; ?></td>
					<td style="font-size: 12px; text-align: center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCostWithMarkup)); ?></td>
					<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo $serviceTax.'%'; ?></td>
					<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalServiceTaxCost)); ?></td>
					<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo $tcsTax.'%'; ?></td>
					<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalTCSCost)); ?></td>
					
					<td style="font-size: 12px; text-align: center;"><?php echo $totalServiceTaxAndTCS = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,round($totalTCSCost+$totalServiceTaxCost))); ?> </td>
				</tr>
				<tr>
				<td colspan="7" style="font-size: 12px; text-align: left; line-height:1.5;">Total Tax Amount in words : (In&nbsp;<?php echo getCurrencyName($currencyId); ?>) <?php if(round($totalServiceTaxAndTCS)>0) { echo convertNumberToWordsForIndia(round($totalServiceTaxAndTCS)); }else{ echo 'NULL'; } ?></td>
				</tr>
			</tbody>
		</table>
		<?php 
	}elseif($gstType==3 && $serviceTax > 0){ ?><table width="100%" border="1" bordercolor="#000000" cellpadding="2" style="border-collapse: collapse;border-top: 0px solid #fff;">
		<thead>
			<tr>
				<th rowspan="2" width="30%" valign="center" style="font-size: 12px; text-align: center;">HSN/SAC</th>
				<th rowspan="2" width="15%" style="font-size: 12px; text-align: center;">Taxable<br>Value </th>
				<th colspan="2" width="20%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">GST Tax</th>
				<th colspan="2" width="20%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">TCS</th>
				<th rowspan="2" style="font-size: 12px; text-align: center;">Total&nbsp;Tax Amount</th>
			</tr>
			<tr>
				<th style="font-size: 12px; height: 25px; text-align:center;">Rate</th>
				<th style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
				<th style="font-size: 12px; height: 25px;text-align:center;">Rate</th>
				<th style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="center" style="font-size: 12px; text-align: center;"><?php echo $hsnCodetotalinv; ?></td>
				<td style="font-size: 12px; text-align: center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCostWithMarkup)); ?></td>
				<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo $serviceTax.'%'; ?></td>
				<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalServiceTaxCost)); ?></td>
				<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo $tcsTax.'%'; ?></td>
				<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalTCSCost)); ?></td>
				
				<td style="font-size: 12px; text-align: center;"><?php echo $totalServiceTaxAndTCS = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,round($totalTCSCost+$totalServiceTaxCost))); ?> </td>
			</tr>
			<tr>
			<td colspan="7" style="font-size: 12px; text-align: left; line-height:1.5;">Total Tax Amount in words : (In&nbsp;<?php echo getCurrencyName($currencyId); ?>) <?php if(round($totalServiceTaxAndTCS)>0) { echo convertNumberToWordsForIndia(round($totalServiceTaxAndTCS)); }else{ echo 'NULL'; } ?></td>
			</tr>
		</tbody>
	</table>
	<?php 
	}else{ ?><table width="100%" border="1" bordercolor="#000000" cellpadding="2" style="border-collapse:collapse;border-top: 0px solid #fff;">
			<thead>
				<tr>
					<th rowspan="2" width="30%" valign="center" style="font-size: 12px; text-align: center;">HSN/SAC</th>
					<th rowspan="2" width="15%" style="font-size: 12px; text-align: center;">Taxable<br>Value </th>
					<th colspan="2" width="20%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">Integrated Tax</th>
					<th colspan="2" width="20%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">TCS</th>
					<th rowspan="2" style="font-size: 12px; text-align: center;">Total&nbsp;Tax Amount</th>
				</tr>
				<tr>
					<th style="font-size: 12px; height: 25px; text-align:center;">Rate</th>
					<th style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
					<th style="font-size: 12px; height: 25px;text-align:center;">Rate</th>
					<th style="font-size: 12px; height: 25px;text-align:center;">Amount</th>
				</tr>
			</thead>
			<tbody>
					<!-- Include TCS Tax -->
				<tr>
					<td valign="center" style="font-size: 12px; text-align: center;"><?php echo $hsnCodetotalinv; ?></td>
					<td style="font-size: 12px; text-align: center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCostWithMarkup)); ?></td>
					<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo $serviceTax.'%'; ?></td>
					<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalServiceTaxCost)); ?></td>
					<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo $tcsTax.'%'; ?></td>
					<td style="font-size: 12px; height: 20px;text-align:center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalTCSCost)); ?></td>
					
					<td style="font-size: 12px; text-align: center;"><?php echo $totalServiceTaxAndTCS = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,round($totalTCSCost+$totalServiceTaxCost))); ?> </td>
				</tr>
				<tr>
				<td colspan="7" style="font-size: 12px; text-align: left; line-height:1.5;">Total Tax Amount in words : (In&nbsp;<?php echo getCurrencyName($currencyId); ?>) <?php if(round($totalServiceTaxAndTCS)>0) { echo convertNumberToWordsForIndia(round($totalServiceTaxAndTCS)); }else{ echo 'NULL'; } ?></td>
				</tr>
			</tbody>
		</table><?php 
	}?>
	<table width="100%" style="border-collapse: collapse;">
	<tr>
		<td width="100%" align="center" style="font-size: 12px; text-align: center;"><br>Kindly make payments of in favour of <b><?php echo $resultInvoiceSetting['companyname']; ?></b></td>
	</tr>
	</table>
	<table width="100%" border="1" cellpadding="5" style="border-collapse: collapse;"> 
	<?php 
	
	$getbank = GetPageRecord('*','bankMaster', 'deletestatus=0 and id="'.$invmData['bankName'].'"');
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
	<tr>
		<td align="center" style="line-height: 0px;">Terms & Conditions</td>
	</tr>

	<tr>
		<td style="font-size: 12px;"><b>Declaration</b></td>
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

 