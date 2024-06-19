<?php
ob_start();
ob_clean();
ob_end_clean();
error_reporting(0);
include "inc.php";
if($_GET['id']!='' && is_numeric(decode($_GET['id']))){
	
	$select='';
	$where='';
	$rs='';
	$select='*';
	$id=clean(decode($_GET['id']));
	$where='id='.$id.'';
	$rs=GetPageRecord($select,_INVOICE_MASTER_,$where);
	$resultInvoice=mysqli_fetch_array($rs);
		
	if($resultInvoice['quotationId'] == 0){
	$quotationDataq = '0';
	}
	else{
	$quotationDataq = trim($resultInvoice['quotationId']);
	}
	$totaltaxamount11 = $resultInvoice['stg']+$resultInvoice['cgst']+$resultInvoice['tcs'];
	$totaligsttcsAMT = $resultInvoice['igst']+$resultInvoice['tcs'];
	
	
	$select1='*';
	$where1='id='.$resultInvoice['queryId'].'';
	$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1);
	$resultQuery=mysqli_fetch_array($rs1);
	
	
	$quotQuery="";
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$resultQuery['id'].'" and id="'.$quotationDataq.'" and status=1 ');
	$quotationData=mysqli_fetch_array($quotQuery);
	$quotationId = $quotationData['id'];
	$queryId = $quotationData['queryId'];
	$noofpax = $quotationData['adult']+$quotationData['child'];
	$subject = ($quotationData['subject']!='')?$quotationData['subject']:$resultQuery['subject'];
	$costType = $quotationData['costType'];
	$discountType= $quotationData['discountType'];
	$discount = $quotationData['discount'];
	if($quotationData['currencyId'] == '' && $quotationData['currencyId'] == 0 ){
		$newCurr = $baseCurrencyId;
	}else{
		$newCurr = $quotationData['currencyId'];
	}



	function convertNumberToWordsForIndia($number){
		//A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
		$words = array(
		'0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
		'6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
		'11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
		'16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
		'30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
		'80' => 'eighty','90' => 'ninty');
		
		//First find the length of the number
		$number_length = strlen($number);
		//Initialize an empty array
		$number_array = array(0,0,0,0,0,0,0,0,0);
		$received_number_array = array();
		
		//Store all received numbers into an array
		for($i=0;$i<$number_length;$i++){
			$received_number_array[$i] = substr($number,$i,1);
		}
	
		//Populate the empty array with the numbers received - most critical operation
		for($i=9-$number_length,$j=0;$i<9;$i++,$j++){
			$number_array[$i] = $received_number_array[$j];
		}
	
		$number_to_words_string = "";
		//Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
		for($i=0,$j=1;$i<9;$i++,$j++){
			// "01,23,45,6,78"
			// "00,10,06,7,42"
			// "00,01,90,0,00"
			if($i==0 || $i==2 || $i==4 || $i==7){
				if($number_array[$j]==0 || $number_array[$i] == "1"){
					$number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
					$number_array[$i] = 0;
				}
				
			}
		}
	
		$value = "";
		for($i=0;$i<9;$i++){
			if($i==0 || $i==2 || $i==4 || $i==7){
				$value = $number_array[$i]*10;
			}
			else{
				$value = $number_array[$i];
			}
			if($value!=0)         {    $number_to_words_string.= $words["$value"]." "; }
			if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
			if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
			if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
			if($i==6 && $value!=0){    $number_to_words_string.= "Hundred "; }
	
		}
		if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
		return strtoupper(strtolower($number_to_words_string)." Only.");
	}
	$select='';
	$where='';
	$rs='';
	$select='*';
	$where='queryId="'.$resultInvoice['queryId'].'" and quotationId="'.$quotationDataq.'" order by id desc';
	$rs=GetPageRecord($select,_AGENT_PAYMENT_REQUEST_,$where);
	$requesetdata=mysqli_fetch_array($rs);
	
	$reqclientGst=$requesetdata['reqclientGst'];
	$reqmarginGst=$requesetdata['reqmarginGst'];

	$reqclientTCS=$requesetdata['reqclientTCS'];
	if($reqclientTCS!=0){
		$reqclientTCS=$requesetdata['reqclientTCS'];
		$finalCost = $requesetdata['finalCost'];
	}	
	
	if($reqclientGst!=0){
	$GST=$requesetdata['reqclientGst'];
	$Cgst=$requesetdata['reqclientCGst'];
	$Sgst=$requesetdata['reqclientSGst'];
	$Igst=$requesetdata['reqclientIGst'];
	$finalReqCost=$requesetdata['reqclientCost'];
	$finalCost = $requesetdata['finalCost'];
	}

	if($reqmarginGst!=0){
	$GST=$requesetdata['reqmarginGst'];
	$Cgst=$requesetdata['reqmarginCGst'];
	$Sgst=$requesetdata['reqmarginSGst'];
	$Igst=$requesetdata['reqmarginIGst'];
	$finalReqCost=$requesetdata['reqmarginCost'];
	}
	
	//------------------------------------------Get Address------ ------------------------------------
	
	$totaltaxamount='';
	$select='';
	$where='';
	$rs='';
	$select='*';
	$where='id=1';
	$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where);
	$resultInvoiceSetting=mysqli_fetch_array($rs);
}

if($resultQuery['clientType']=='1'){
	$select4='*';
	$where4='id='.$resultQuery['companyId'].'';
	$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4);
	$resultCompany=mysqli_fetch_array($rs4);
	$mobilemailtype='corporate';

	$select4='*';  
	$where4='addressType="'.$mobilemailtype.'" and addressParent="'.$resultCompany['id'].'" order by primaryAddress desc'; 
	$rs4=GetPageRecord($select4,_ADDRESS_MASTER_,$where4); 
	$addressD=mysqli_fetch_array($rs4); 

	$addressPr = $addressD['address'];

}
if($resultQuery['clientType']=='2'){
	$select4='*';
	$where4='id='.$resultQuery['companyId'].'';
	$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4);
	$resultCompany=mysqli_fetch_array($rs4);
	$mobilemailtype='contacts';

	$addressPr = $resultCompany['address1'];

}

$wherest = 'id="'.$resultCompany['stateId'].'"';
$getstate = GetPageRecord('*','stateMaster',$wherest);
$stresult = mysqli_fetch_assoc($getstate);

$wherecot = 'id="'.$resultCompany['countryId'].'"';
$getcountry = GetPageRecord('*','countryMaster',$wherecot);
$ctresult = mysqli_fetch_assoc($getcountry);


$wheresetting = 'panInformation!="" ';
$compnysetting = GetPageRecord('*','companySettingsMaster',$wheresetting);
$companyPAN = mysqli_fetch_assoc($compnysetting);

$select5='*';  
$where5='addressType="invoicesetting" and addressParent="1" '; 
$rs5=GetPageRecord($select5,_ADDRESS_MASTER_,$where5); 
$address5 =mysqli_fetch_array($rs5); 

?> 
	<div style="color:#353940;">
	<!-- First Table start -->
	<!-- <table width="100%" style="max-height:50px;" >
		<tbody>
			<tr>
				<td style=" font-size:22px; line-height:1.5;" align="center" ><span class="style3" >
					<?php if($resultInvoice['invoiceType']=='1'){ echo 'TAX INVOICE'; } else { echo 'PROFORMA INVOICE tamplate 2'; } ?>
				</span></td>
			</tr>
		</tbody>
	</table> -->

	<table width="100%" border="0" style="border:0px solid #355e91; border-bottom: 1px solid #dae5f0;">
		<tbody>
			<tr>
			<td height="65" width="30%">
					<?php 
					$logopath = 'dirfiles/'.$resultInvoiceSetting['logo']; 
					
					if($resultInvoiceSetting['logo']!='' && file_exists($logopath)){ ?>
					<img src="<?php echo $fullurl; ?>dirfiles/<?php echo $resultInvoiceSetting['logo']; ?>" width="140" height="60" >
					<?php } ?>
				</td>
				
				
                <td width= "70%" style="font-size: 11px; color:#000;">
				<strong style="font-size: 25px;"><?php if($resultInvoice['invoiceType']=='1'){ echo 'TAX INVOICE'; } else { echo 'PROFORMA INVOICE'; } ?></strong>
                <br>
                <strong><?php echo $resultInvoiceSetting['companyname']; ?></strong> <br><strong>Address:</strong> <?php echo $resultInvoiceSetting['address']; ?> <br><strong>Contact:</strong> <?php echo $resultInvoiceSetting['phone']; ?><br> <strong>Email: </strong> <?php echo $resultInvoiceSetting['email']; ?>&nbsp;&nbsp;&nbsp; <strong>Website: </strong> <?php echo $resultInvoiceSetting['website']; ?> 

                <!-- <br><strong>GSTIN/UIN:</strong> <?php echo$address5['gstn'] ?> &nbsp;&nbsp;&nbsp;&nbsp;<strong>PAN:</strong> <?php echo $companyPAN['panInformation']; ?><br><strong>CIN:</strong> <?php echo $companyPAN['CINnumber']; ?> -->
            </td>
			</tr>
		</tbody>
	</table>
	<!-- Second Table start -->
	<table  width="100%" border="" bordercolor="#dae5f0" cellpadding="2" style="border-bottom: 1px solid #dae5f0;">
		<tbody>
			<tr style="font-size: 12px;">
				<td width="" rowspan="6" style="font-size: 14px; border-right: groove;"  >
				    <span style="color:#000;">	
                    <div style="color:black;"><strong>Bill To:<strong></div>
					<?php echo showClientTypeUserName($resultQuery['clientType'],$resultQuery['companyId']); ?><br>
                    </span>
                    <span style="color:#000;"><strong style="color:black;">Address: </strong>
					<?php echo $addressPr.'&nbsp;&nbsp;'.$resultCompany['pinCode'] ; ?><br></span>

					<span style="color:#000;"><strong style="color:black;">Phone: </strong><?php echo $resultQuery['guest1phone']; ?><br></span>

					<span style="color:#000;"><strong style="color:black;">Email: </strong><?php echo $resultQuery['guest1email']; ?><br></span>
					<!-- <strong>GSTIN/UIN: </strong> <?php echo $resultCompany['gstn'] ?><br>
					<strong>PAN: </strong><?php echo $resultCompany['panInformation']; ?><br>
					<strong>State / Country Name: </strong><?php if($stresult['name']!=''){ echo $stresult['name'].' '.'/'; } ?> <?php echo $ctresult['name']; ?> -->
					
				</td>

                <tr>
				    <td width="" style="height: 15px; font-size: 14px;border: none;">
                    <span style="color:#000;"><strong>Invoice No: </strong><?php if($resultInvoice['invoiceType']=='2'){ echo $companyPAN['proformaInvoiceNoSequence'].'/'; } else { echo $companyPAN['taxInvoiceNoSequence'].'/'; } ?><?php echo makeInvoiceId($resultInvoice['id']); ?></span>
                    </td>
                </tr>
                <tr>
				    <td width="" style="height: 15px; font-size: 14px;border: none;">
                    <span style="color:#000;"><strong>Date: </strong><?php echo date("j F Y", strtotime($resultInvoice['invoicedate'])); ?></span>
                    </td>
                </tr>
                <tr>
				    <td style="height: 15px; font-size: 14px; color:#000;border: none;"><strong>Reference No: </strong><?php echo $resultInvoice['referNo']; ?></td>
                </tr>
                <!-- <tr>
				    <td style="height: 25px; font-size: 14px;color:#000;">File No.:
            	    <strong><?php if($resultInvoice['fileNo']!=''){ echo $resultInvoice['fileNo']; }  ?></strong>
          		    </td>
                </tr> -->
			

			<tr>
				<td style="height: 15px; font-size: 14px; color:#000;border: none;"><strong>Tour Id: </strong><?php if($resultInvoice['fileNo']!=''){ echo $resultInvoice['tourId']; } ?>
          		</span></td>
            </tr>
            <tr>
				<td style="height: 15px; font-size: 14px; color:#000;border: none;"><strong>Due Date: </strong><?php echo date("d-m-Y", strtotime($resultInvoice['dueDate']));?></td>
			
			</tr>
        </tr>
			
		</tbody>	
	</table>
    <br>
	<!-- third Table start -->
	<table width="99%" border="1" cellpadding="2" bordercolor="#dae5f0">
		<tbody>
			<tr style="height: 25px;">
				<td colspan="1" width="10%" style="font-size: 15px; text-align:center;color:black;"><strong>SN</strong></td>
				<td colspan="2" width="49%" style="font-size: 15px;text-align:center;color:black;"><strong>Service Details</strong></td>
				
				<!-- <td width="17%" style="font-size: 13px;text-align:center;"><strong>HSN/SAC</strong></td> -->
				<td  colspan="1" width="10%" style="font-size: 15px;text-align:center;color:black;"><strong>GST</strong></td>
				<td colspan="1" width="30%" style="font-size: 15px;text-align:center;color:black;"><strong>Amount&nbsp;<span style="
				font-size:10px;">(<?php echo getCurrencyName($baseCurrencyId); ?>)</span></strong></td>		
			</tr>

			<tr height="50">
				<td colspan="1" width="10%" style="text-align: center;color:black;">1</td>
			
				<td colspan="2" width="49%" valign="top" style="font-size: 12px; text-align:left;">
				<table><tr><td width="10%" style="color:#000;"><?php echo $resultInvoice['particularsubject']; ?></td>
			
			
				<td width="17%">
		  		<p style="text-align: right; font-weight:500; font-size:13px;">&nbsp;&nbsp;
     			<?php if($Cgst>0){ echo 'CGST'.' ' .'<br>'; } ?> <?php if($Sgst>0){ echo 'SGST'. ' '.'<br>'; } ?><?php if($Igst>0){ echo '<br>'.'IGST'.' '.'<br>'; } ?><?php if($reqclientGst=='0'){echo '<br>'; } if($reqclientTCS>0){ echo 'TCS'.' '.'<br>'; }?> </p>
				 </td> </tr></table>
				</td>
				<!-- <td width="17%" valign="top" style="text-align:center;"> <?php echo $resultInvoice['hsnCode'] ?></td> -->
				<td colspan="1"  align="center" valign="top" width="10%" style="font-size: 12px;color:black;"> <?php if($Igst>0){ ?> <br><br><br><br><strong> <?php echo $Igst .'%'.'<br>' ; ?> </strong> <?php }else{ ?> <br><br><br><br><strong><?php if($Cgst=='' || $Cgst=='0' && $Sgst=='' || $Sgst=='0'){ }else{ echo $Cgst.'%'.'<br>'; echo $Sgst.'%'.'<br>'; } ?></strong><?php } ?>
				<strong><?php  if($reqclientTCS>0){ echo $reqclientTCS.'%'.'<br>'; } ?></strong>
				</td>
				
				<td  colspan="1" width="30%" style="color:black;text-align: center; font-size:15px; height: 70px;"><strong><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$requesetdata['reqclientCost'])).' '.' <br> ' ; ?> <br> <?php 
					if($resultInvoice['cgst']!=''){ echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['cgst'])).'<br>' ; }
					if($resultInvoice['stg']!=''){ echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['stg'])).'<br>' ; }
					if($resultInvoice['igst']!=''){ echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['igst'])).'<br>' ; } 
					if($resultInvoice['tcs']>0){ echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['tcs'])).'<br>' ; }else{ echo '<br><br>'; } ?>
					 </strong> </td>
			</tr>
			
			<tr style="height: 15px;">
				<td colspan="1" width="10%" style="font-size: 14px;"></td>
				<td colspan="2"  width="49%" style="font-size: 14px;"></td>
				<!-- <td width="17%" style="font-size: 14px;"></td> -->
				<td colspan="1" width="10%" style="font-size: 15px;text-align:center;color:black;"><strong>Total</strong></td>
				<td colspan="1" width="30%" style="font-size: 14px; text-align: center;color:black;"><strong><?php if($finalCost =='' || $finalCost =='0'){ echo $BaseCost = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$requesetdata['reqclientCost'])); }else{ echo $finaleCost = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$finalCost)); }?>
				</strong></td>		
			</tr>
			
			<tr style="color:#000">
			
					<?php if($finalCost =='' || $finalCost =='0'){ ?> 
						<td colspan="5" style="font-size: 15px; height:20px; line-height:1.5;"><strong>Amount&nbsp;Chargeble(<?php echo getCurrencyName($baseCurrencyId); ?>) &nbsp;:&nbsp;<?php  
					echo convertNumberToWordsForIndia(round($BaseCost)); ?></strong></td>	
						
						<?php }else{ ?>
					<td colspan="5" style="font-size: 16px; height:20px; line-height:1.5;color:black;"><strong>Amount&nbsp;Chargeble(In&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>) &nbsp;:&nbsp;<?php  
					echo convertNumberToWordsForIndia(round($finaleCost)); ?></strong></td>
					<?php } ?>
					
			</tr>

		</tbody>
	</table>
	<!-- Fourth Table start -->
	<!-- <?php
	 if($resultInvoice['cgst']!='' && $resultInvoice['stg']!=''){ ?>
	<table width="100%" border="1" bordercolor="#dae5f0" cellpadding="2">
	<thead> -->
				<!-- Include TCS Tax -->
			<!-- <tr>
				<th rowspan="2" width="22%" valign="center" style="font-size: 12px; text-align: center;">HSN/SAC</th>
				<th rowspan="2" width="10%" style="font-size: 12px; text-align: center;">Taxable Value </th>
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
		<tbody> -->
				<!-- Include TCS Tax -->
			<!-- <tr>
				<td width="22%" valign="center" style="font-size: 12px; text-align: center;"><?php if($resultInvoice['hsnCodeId']!=0){ echo $hsnCodetotalinv;}else{ echo $hsnCode; }  ?></td>
				<td width="10%" style="font-size: 12px; text-align: right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$requesetdata['reqclientCost'])); ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $Cgst.'%'; ?></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['cgst'])); ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $Sgst.'%'; ?></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['stg'])); ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $reqclientTCS.'%'; ?></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['tcs'])); ?></td>
				
				<td width="14%" style="font-size: 12px; text-align: right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totaltaxamount11)); ?> </td>
			</tr> -->
			<!-- <tr>
				<td width="22%" valign="center" style="font-size: 12px; text-align: center;"></td>
				<td width="10%" style="font-size: 12px; text-align: right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$requesetdata['reqclientCost'])); ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align: right;"></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['cgst'])); ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:center;"></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['stg'])); ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:center;"></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['tcs'])); ?></td>
				<td width="14%" style="font-size: 12px; text-align: right;"><?php echo $totalTaxinword = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totaltaxamount11)); ?> </td>
			</tr> -->
			<!-- <tr>
			<td colspan="9" style="font-size: 12px; text-align: left; line-height:1.5;">Total Tax Amount in words : (In&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>) <?php echo convertNumberToWordsForIndia(round($totalTaxinword)); ?></td>
			</tr>
				
		</tbody>
	</table>
	<?php }elseif($resultInvoice['igst']>0){ ?>
	<table width="100%" border="1" bordercolor="#dae5f0" cellpadding="2">
		<thead>
		<tr>
				<th rowspan="2" width="30%" valign="center" style="font-size: 12px; text-align: center;">HSN/SAC</th>
				<th rowspan="2" width="14%" style="font-size: 12px; line-height:2; text-align: center;">Taxable&nbsp;Value </th>
				Integrated -->

				<!--<th colspan="2" width="20%" valign="middle" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">Integrated Tax</th>
				<th colspan="2" width="20%" valign="middle" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">TCS</th>
				
				<th rowspan="2" width="16%" style="font-size: 12px;text-align: center;">Total Tax Amount</th>
			</tr>
			<tr>
				<th width="9%" style="font-size: 12px; height: 25px;text-align:right;">Rate</th>
				<th width="11%" style="font-size: 12px; height: 25px;text-align:right;">Amount</th>
				<th width="9%" style="font-size: 12px; height: 25px;text-align:right;">Rate</th>
				<th width="11%" style="font-size: 12px; height: 25px;text-align:right;">Amount</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="30%" valign="center" style="font-size: 12px; text-align: center;"><?php if($resultInvoice['hsnCodeId']!=0){ echo $hsnCodetotalinv;}else{ echo $hsnCode; } ?></td>
				<td width="14%" style="font-size: 12px; text-align: right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$requesetdata['reqclientCost'])); ?></td>
				<td width="9%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $Igst.'%'; ?></td>
				<td width="11%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['igst'])); ?></td>

				<td width="9%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $reqclientTCS.'%'; ?></td>
				<td width="11%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$resultInvoice['tcs'])); ?></td>

				<td width="16%" style="font-size: 12px; text-align: right;"><?php echo $totaligst = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totaligsttcsAMT)); ?></td>
			</tr>
			
			<tr>
			<td colspan="7" style="font-size: 12px; text-align: left; line-height:1.5;">Total Amount in words : (In&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>) <?php
			$totaltaxamount12 = $resultInvoice['igst'];
  			echo convertNumberToWordsForIndia(round($totaligst)); ?></td>
			</tr>
		</tbody>
	</table>
		<?php }else{ ?>
			
			
			<table width="100%" border="1" bordercolor="#dae5f0" cellpadding="2">
		<thead>
			<tr>
				<th rowspan="2" width="22%" valign="center" style="font-size: 12px; text-align: center;">HSN/SAC</th>
				<th rowspan="2" width="10%" style="font-size: 12px; text-align: center;">Taxable Value </th>
				<th colspan="2" width="18%" valign="middle" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">Central Tax</th>
				<th colspan="2" width="18%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">State Tax</th>
				<th colspan="2" width="18%" style="font-size: 12px; line-height:2; height: 20px; text-align: center;">TCS</th>
				<th rowspan="2" width="14%" style="font-size: 12px; text-align: center;">Total Tax Amount</th>
			</tr>
			<tr>
				<th width="8%" style="font-size: 12px; height: 25px; text-align:right;">Rate</th>
				<th width="10%" style="font-size: 12px; height: 25px;text-align:right;">Amount</th>
				<th width="8%" style="font-size: 12px; height: 25px;text-align:right;">Rate</th>
				<th width="10%" style="font-size: 12px; height: 25px;text-align:right;">Amount</th>
				<th width="8%" style="font-size: 12px; height: 25px;text-align:right;">Rate</th>
				<th width="10%" style="font-size: 12px; height: 25px;text-align:right;">Amount</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="22%" valign="center" style="font-size: 12px; text-align: center;"><?php if($resultInvoice['hsnCodeId']!=0){ echo $hsnCodetotalinv;}else{ echo $hsnCode; } ?></td>
				<td width="10%" style="font-size: 12px; text-align: center;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$requesetdata['reqclientCost'])); ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $Cgst; ?></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $resultInvoice['cgst'] ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $Sgst; ?></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $resultInvoice['stg'] ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:right;"><?php if($reqclientTCS>0){echo $reqclientTCS.'%';} ?></td>
				<td width="10%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $resultInvoice['tcs'] ?></td>
				<td width="14%" style="font-size: 12px; text-align: right;"><?php echo $totaltaxamount11; ?> </td>
			</tr> -->
			<!-- <tr>
				<td width="33%" valign="center" style="font-size: 12px; text-align: center;"></td>
				<td width="12%" style="font-size: 12px; text-align: right;"><?php echo round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$requesetdata['reqclientCost'])); ?></td>
				<td width="9%" style="font-size: 12px; height: 20px;text-align: right;"></td>
				<td width="11%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $resultInvoice['cgst'] ?></td>
				<td width="8%" style="font-size: 12px; height: 20px;text-align:center;"></td>
				<td width="11%" style="font-size: 12px; height: 20px;text-align:right;"><?php echo $resultInvoice['stg'] ?></td>
				<td width="16%" style="font-size: 12px; text-align: right;"><?php echo $totaltaxamount11; ?> </td>
			</tr> -->
			<!-- <tr>
			<td colspan="9" style="font-size: 12px; text-align: left; line-height:1.5;">Total Tax Amount in words : (In&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>) <?php echo convertNumberToWordsForIndia(round($totaltaxamount11)); ?></td>
			</tr>
		</tbody>
	</table>
			
			
			
			<?php } ?>

		<table width="100%">
		<tr>
			<td width="100%" align="center" style="font-size: 12px; text-align: center; line-height:4;"><br>Kindly make payments of in favour of <b><?php echo $resultInvoiceSetting['companyname']; ?></b></td>
		</tr>
		</table> -->
        <!--  end of fourth table-->
<br><br>
		<table width="100%" border="1" cellpadding="5">
	<thead>
	<tr style="background-color: #ccc; color: #000;">
		<th width="18%" height="25" style="font-size: 12px; text-align:left;"><b>Bank Name</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Beneficiary Name</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Account Number</b></th>
		<th width="12%" height="25" style="font-size: 12px; text-align:left;"><b>Account Type</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Branch Address</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Branch IFSC</b></th>
		<th width="14%" height="25" style="font-size: 12px; text-align:left;"><b>Branch SWIFT Code</b></th>
	</tr>
	</thead>
	  <?php $getbank = GetPageRecord('*','bankMaster', 'deletestatus=0 and id="'.$resultInvoice['bankName'].'"');
	 	$bankName = mysqli_fetch_array($getbank );
	 ?>
	 <tbody>
	<tr>
		<td width="18%" height="20" style="font-size: 12px;padding-left:5px;"><?php echo $bankName['bankName']; ?> </td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $resultInvoice['beneficiaryName']; ?></td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $resultInvoice['accountNumber']; ?></td>
		<td width="12%" height="20" style="font-size: 12px; text-align:left;"><?php echo $resultInvoice['accountType']; ?></td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $resultInvoice['branchAddress']; ?></td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $resultInvoice['branchIfsc']; ?></td>
		<td width="14%" height="20" style="font-size: 12px; text-align:left;"><?php echo $resultInvoice['branchSwiftCode']; ?></td>
	</tr>
	</tbody>
</table>

<table width="100%" style="margin-left: 30px;">
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
		<td style="font-size: 12px;color:black;"><b>Remarks</b></td>
	</tr>

	<tr>
		<td style="font-size: 12px;"><?php if($resultInvoice['invoiceNotes']!=''){ 
			echo nl2br(stripslashes($resultInvoice['invoiceNotes'])); 
		} ?></td>
	</tr>

	<!-- <tr>
		<td style="font-size: 10px;"><?php if($resultInvoice['terms']!=''){ 
			echo nl2br(stripslashes($resultInvoice['terms']));
			} ?></td>
	</tr>

	<tr>
		<td style="font-size: 10px;"><?php if($resultInvoice['payment']!=''){ 
			echo nl2br(stripslashes($resultInvoice['payment']));
			} ?></td>
	</tr> -->
	</tbody>
</table>

	<table width="100%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#dae5f0" >
	<tbody>
	<tr>
		<td width="50%"></td>
		<td width="50%" align="right"  style="  font-size: 14px;color:black;"><b>For <?php echo $resultInvoiceSetting['companyname']; ?></b><br><br>Authorised Signature</td>
	</tr>

	<tr>
		<td>&nbsp;</td>
	</tr>
	</tbody>

	</table>


		<!--this is container div  -->
</div>


<style type="style"> 
            table {
        border-collapse: collapse;
      }
</style>









