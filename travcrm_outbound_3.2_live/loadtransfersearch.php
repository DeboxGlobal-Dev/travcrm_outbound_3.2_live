<?php
include "inc.php";     

if($_REQUEST['transferCategory'] == 'transportation'){
	$transferCategory = 'transportation';
}else{
	$transferCategory = 'transfer';
}

if($transferCategory=='transportation'){

	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['startDay'].'" and addstatus= 0 '); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 

	$queryId = $newQuotationData['queryId'];
	$quotationId = $newQuotationData['quotationId'];
	$dayId = $newQuotationData['id'];
	$dayDate = $newQuotationData['srdate']; 
	$fromDate=date("Y-m-d", strtotime($dayDate));
	$cityId = $_REQUEST['cityId'];
	$enddayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['endDay'].'"  and addstatus= 0 '); 
	$endDayData=mysqli_fetch_array($enddayQuery);  
	$toDate=date("Y-m-d", strtotime($endDayData['srdate'])); 

	$noOfDays = mysqli_num_rows(GetPageRecord('id','newQuotationDays',' 1 and srdate between "'.$fromDate.'" and "'.$toDate.'" and addstatus= 0 and quotationId="'.$quotationId.'"'));
	if($noOfDays < 1){ $noOfDays = 1; }


	if($fromDate!=''){
 		$dateQuery.=' and status=1 and fromDate<="'.$fromDate.'" and toDate>="'.$toDate.'" ';
	}
 
}else{

	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 

	$queryId = $newQuotationData['queryId'];
	$quotationId = $newQuotationData['quotationId'];
	$dayId = $newQuotationData['id'];
	$dayDate = $newQuotationData['srdate'];
	 
	$fromDate=date("Y-m-d", strtotime($dayDate));
	$toDate=date("Y-m-d", strtotime($dayDate)); 
//    destination wise search 
	$cityId = $_REQUEST['cityId'];

	if($fromDate!=''){
		$dateQuery=' and status=1 and "'.$fromDate.'" BETWEEN fromDate AND toDate ';
 	}
}

	$quotQurey='';
	$quotQurey=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" ');  
	$quotationData=mysqli_fetch_array($quotQurey);

	$calculationType = $quotationData['calculationType'];

	// this for master transfer
	$transferQuery = '';	
	$transferType = $_REQUEST['transferType'];
	if($transferType>0){
		$transferQuery = ' and transferType="'.$transferType.'"';
	}

	// this for rate transferType
	$sicQuery = '';	
	if($_REQUEST['sic_pvt']>0){
		$sicQuery = ' and transferType="'.$_REQUEST['sic_pvt'].'"';
	}

	$vehicleModelId=$_REQUEST['vehicleModelId'];
	$vehicleTypeId=$_REQUEST['vehicleTypeId'];
	$transferId=$_REQUEST['transferId'];

	$cityQuery='';

	$supplierQuery=' and supplierId in ( select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and transferType=5  )  ';

	$vehicleQuery='';  
	if($vehicleModelId>0 ){
		$vehicleQuery.=' and vehicleModelId="'.$vehicleModelId.'" ';
	}else{
		$vehicleQuery ;
	}

	$vehicleTypeQuery='';  
	if($vehicleTypeId>0 ){
		$vehicleTypeQuery.=' and vehicleTypeId="'.$vehicleTypeId.'" ';
	}else{
		$vehicleTypeQuery ;
	}
?>
<div id="viewinfo" style="display:none;position: absolute; z-index: 9999999999; border: 1px solid #ccc; width: 100%; height: 1000px; top: 0px; left: 0px; background-color: #0d0f14c7;"><div id="loadvechileinfo" style="margin: auto; width: 70%; margin-top: 100px;"></div></div>
<?php
//TPT
if($transferCategory=='transportation'){ 
?>
<div style="font-size:16px; padding:6px;position:relative;text-align: right;"  >
	<button class="addBtn" onclick="openinboundpop('action=addtransfertomaster&dayId=<?php echo $dayId; ?>&tc=3&cityId=<?php echo $cityId; ?>','800px');" >+&nbsp;Add New</button>
</div>

<style>
	.addBtn{
		background: #7a96ff;
		font-size: 16px !important;
		color: #ffffff;
		cursor: pointer;
		padding: 5px 7px;
		border: 1px solid #fff;
		box-shadow: 0px 3px 5px -1px black;
	}
</style>
<div style="padding:10px; border:1px #e3e3e3 solid;background-color: #fff; margin-bottom:10px;" id="trabox">   
<div class="topaboxlist" id="trabox2">
<div style="margin-bottom:5px; font-size:15px;"><table border="0" cellpadding="0" cellspacing="0">
  <tbody><tr><td style="padding-right:15px;"><img src="images/dmccaricon.png" ></td>
	<td colspan="2">&nbsp;</td>
  </tr> 
</tbody></table>
</div>

<?php 
$rsty=""; 
	$rsty=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' 1 and (FIND_IN_SET("'.$cityId.'",destinationId) or destinationId=0) and transferCategory="transportation" and id="'.$transferId.'" '.$transferQuery.' and status=1 order by id desc'); 								    
if(mysqli_num_rows($rsty)>0){ 
	?>
	<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
	   <thead> 
	   <tr>
		 <th width="25%" align="left" bgcolor="#DDDDDD" >TPT&nbsp;NAME</th>  
		 <th width="12%" align="left" bgcolor="#DDDDDD" >Vehicle&nbsp;Type</th>
		 <?php if($calculationType != 3){  ?> 
		 <th width="10%" align="right" bgcolor="#DDDDDD">Currency[ROE]</th>
		 <th width="5%" align="left" bgcolor="#DDDDDD"  >Pax&nbsp;Capacity</th>
		 <th width="10%" align="center" bgcolor="#DDDDDD"><?php echo transferCostType($_REQUEST['costType']);  ?></th> 
		 <?php if($_REQUEST['costType']==1){ ?>
		 <th width="5%" align="center" bgcolor="#DDDDDD" >Days</th>
		 <th width="5%" align="center" bgcolor="#DDDDDD" >Total&nbsp;Cost</th>
		 <?php }elseif($_REQUEST['costType']==3){ ?>
		 <th width="5%" align="center" bgcolor="#DDDDDD" >Distance</th>
		 <th width="5%" align="center" bgcolor="#DDDDDD" >Total&nbsp;Cost</th>
		 <?php } ?>
		 <th width="10%" align="center" bgcolor="#DDDDDD" >No.&nbsp;of&nbsp;Vehicle</th> 
		 <?php } ?>
		 <th width="10%" align="center" bgcolor="#DDDDDD">Pax&nbsp;Slab</th>  
		 <th width="15%" colspan="2" align="center" bgcolor="#DDDDDD">&nbsp;</th>
	   </tr>
	   </thead> 
	  <tbody>
	<?php
	while($restrans=mysqli_fetch_array($rsty)){ 
		
		if($calculationType != 3){ 
			$c2=1;
			$select22=''; 
			$wher22=''; 
			$rs22='';  
			$select22='*';    
			$where22='transferNameId="'.$restrans['id'].'" and (rateDestinationId="'.$cityId.'" or rateDestinationId=0 ) and transferCostType = "'.$_REQUEST['costType'].'" '.$vehicleTypeQuery.' '.$supplierQuery.' '.$dateQuery.' and status=1 order by id asc';  
			$rs22=GetPageRecord($select22,_DMC_TRANSFER_RATE_MASTER_,$where22); 
			if(mysqli_num_rows($rs22)>0){
				while($dmcroommastermain=mysqli_fetch_array($rs22)){

				 	$rsa2s=GetPageRecord('*','quotationTransferRateMaster','tariffId="'.$dmcroommastermain['id'].'" and transferCostType = "'.$_REQUEST['costType'].'" and quotationId="'.$quotationId.'"  and serviceType="transportation" ');  
					if(mysqli_num_rows($rsa2s)>0){ 
						$dmcroommastermain=mysqli_fetch_array($rsa2s);
				 		$vechileCost = 0;
						$vechileCost = strip($dmcroommastermain['vehicleCost'])+strip($dmcroommastermain['parkingFee'])+strip($dmcroommastermain['representativeEntryFee'])+strip($dmcroommastermain['assistance'])+strip($dmcroommastermain['guideAllowance'])+strip($dmcroommastermain['interStateAndToll'])+strip($dmcroommastermain['miscellaneous']);

						$markupCostV =  getMarkupCost($vechileCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
						$gstValueTransfer=getGstValueById($dmcroommastermain['gstTax']); 
						$vechileCost = ($vechileCost+$markupCostV);
						$vechileCost= (($vechileCost*$gstValueTransfer/100)+$vechileCost); 
						$tableN=2;
					}else{
						$tableN=1;
						$vechileCost = 0;
						$vechileCost = strip($dmcroommastermain['vehicleCost'])+strip($dmcroommastermain['parkingFee'])+strip($dmcroommastermain['representativeEntryFee'])+strip($dmcroommastermain['assistance'])+strip($dmcroommastermain['guideAllowance'])+strip($dmcroommastermain['interStateAndToll'])+strip($dmcroommastermain['miscellaneous']); 
						$vehicleModelId2 = $dmcroommastermain['vehicleModelId'];
						 
						$markupCostV =  getMarkupCost($vechileCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
						$gstValueTransfer=getGstValueById($dmcroommastermain['gstTax']); 
						$vechileCost = ($vechileCost+$markupCostV);
						$vechileCost= (($vechileCost*$gstValueTransfer/100)+$vechileCost); 
					}

					$currencyId = $dmcroommastermain['currencyId'];
					$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
					// $currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:0;
					$cur=getCurrencyName($currencyId); 

					if($_REQUEST['vehicleTypeId']==0){
						$vehicleTypeId = $dmcroommastermain['vehicleTypeId'];
					}else{
						$vehicleTypeId = $_REQUEST['vehicleTypeId'];
					}
					?>
				  <tr>
					<td align="left"><?php  echo clean($restrans['transferName']);?></td>
					<?php  
					$rs2=GetPageRecord('*','vehicleTypeMaster',' id="'.$vehicleTypeId.'"'); 
					$editresult24=mysqli_fetch_array($rs2); ?>

					<td align="left"> <?php  echo ($editresult24['name'].' ('.$editresult24['capacity']).' Pax)'; ?></td>
					<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
				  <td align="left"><?php if($editresult24['capacity'] >0){ echo $editresult24['capacity']; }else{ echo $dmcroommastermain['capacity']; } ?></td>
					<td align="center"><?php echo $cur.' '.round($vechileCost,2); ?></td>
					<?php if($_REQUEST['costType']==1){ ?>
					<td align="center" >
						<input name="noOfDays2<?php echo $dmcroommastermain['id']; ?>" id="noOfDays2<?php echo $dmcroommastermain['id']; ?>" type="text" class="numeric" value="<?php echo $noOfDays; ?>" style="width: 70px; text-align: center; padding: 3px; border: 1px solid #ccc; border-radius: 3px;" onkeyup="calculatecost<?php echo $dmcroommastermain['id'];?>();" />
					</td> 
					<td align="center" >
						<strong><span id="totalcost2<?php echo $dmcroommastermain['id'];?>"></span></strong>
					</td>
		 			<?php }elseif($_REQUEST['costType']==3){ ?>
					<td align="center" ><?php echo $dmcroommastermain['distance'];?> KM</td>
					<td align="center" ><?php echo $cur.' '.round(($vechileCost*$dmcroommastermain['distance']),2);?></td>
					<?php } ?>
					<td align="center">
						<input type="number" name="noOfVehicles2<?php echo $dmcroommastermain['id']; ?>" id="noOfVehicles2<?php echo $dmcroommastermain['id']; ?>" value="1" style="width: 50px; border: 1px solid #ccc; padding: 5px 10px;" />
					</td>
					<td align="center">
						<select name="totalPax2<?php echo $dmcroommastermain['id']; ?>" id="totalPax2<?php echo $dmcroommastermain['id']; ?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
						<?php
						$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
						while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
							if($totalPaxData['fromRange']==$totalPaxData['toRange']){
								$paxName=$totalPaxData['fromRange'].' Pax';
							}else{
								$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
							} 
							?> 
							<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
							<?php 
						} ?>
						</select>
					</td>
				  <td align="center"><div style="width: 60px!important" class="editbtnselect" <?php if($currencyValue>0){ ?> onclick="addtransfertoquotations('<?php echo $dmcroommastermain['id'];?>','<?php echo $dmcroommastermain['supplierId'];?>','<?php echo getVehiclePaxCapacity($vehicleTypeId); ?>','<?php echo $tableN;?>');" <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?>   ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div> 
				  </td>
				  <td align="center">  
				  	<div style="width: 80px!important"  class="editbtnselect" onclick="addtransportationCostfun('<?php echo $restrans['id']; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tableN;?>');" ><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Edit&nbsp;Cost</div>
					</td> 
				  </tr> 
					<script>
					function calculatecost<?php echo $dmcroommastermain['id'];?>(){
						var vehicleCost = Number('<?php echo $vechileCost; ?>');
						var days = $('#noOfDays2<?php echo $dmcroommastermain['id']; ?>').val();
						$('#totalcost<?php echo $dmcroommastermain['id'];?>').text(vehicleCost*days);
					}
					calculatecost<?php echo $dmcroommastermain['id'];?>();
					</script>
					<?php  $c2++; $n++;}
			}else{

				 	$where22='transferNameId="'.$_REQUEST['transferId'].'"  and transferCostType = "'.$_REQUEST['costType'].'" and serviceType="transportation" and quotationId="'.$quotationId.'" '.$vehicleTypeQuery.'  order by id desc';  
					$rs22=GetPageRecord('*','quotationTransferRateMaster',$where22); 
					if(mysqli_num_rows($rs22)>0){
						while($dmcroommastermain=mysqli_fetch_array($rs22)){  
							$tableN = 2;
		 
							$vechileCost = 0;
							$vechileCost = strip($dmcroommastermain['vehicleCost'])+strip($dmcroommastermain['parkingFee'])+strip($dmcroommastermain['representativeEntryFee'])+strip($dmcroommastermain['assistance'])+strip($dmcroommastermain['guideAllowance'])+strip($dmcroommastermain['interStateAndToll'])+strip($dmcroommastermain['miscellaneous']); 
							 
							$markupCostV =  getMarkupCost($vechileCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
							$gstValueTransfer=getGstValueById($dmcroommastermain['gstTax']); 
							$vechileCost = $vechileCost+$markupCostV;
							$vechileCost= (($vechileCost/100*$gstValueTransfer)+$vechileCost); 

							$currencyId = $dmcroommastermain['currencyId'];
							$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
							// $currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:0;
							$cur=getCurrencyName($currencyId); 
							?>
							<tr>
								<td align="left"><?php  echo clean($restrans['transferName']);?></td>
								<?php
								if($_REQUEST['vehicleTypeId']==0){
      						$vehicleTypeId = $dmcroommastermain['vehicleTypeId'];
      					}else{
      						$vehicleTypeId = $_REQUEST['vehicleTypeId'];
      					}
								$rs2=GetPageRecord('*','vehicleTypeMaster',' id="'.$vehicleTypeId.'"'); 
								$editresult25=mysqli_fetch_array($rs2);
								 ?> 
								<td align="left"> <?php  echo ($editresult25['name']); ?></td>
							  <td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
							  <td align="left"><?php if($dmcroommastermain['capacity'] == '0' ){ echo $editresult24['capacity'] ; }else{ echo $dmcroommastermain['capacity']; } ?></td>
								<td align="center"><?php echo $cur.' '.$vechileCost; ?></td> 
								<td align="center" <?php if($_REQUEST['costType']==2 || $_REQUEST['costType']==3){ ?> style="display:none;" <?php } ?>>		<input name="noOfDays2" id="noOfDays2<?php echo $dmcroommastermain['id']; ?>" type="text" class="numeric" value="<?php echo $noOfDays; ?>" style="width: 70px; text-align: center; padding: 3px; border: 1px solid #ccc; border-radius: 3px;" onkeyup="calculatecost<?php echo $dmcroommastermain['id'];?>();" />
								</td> 

								<td align="center" <?php if($_REQUEST['costType']!=3){ ?> style="display:none;" <?php } ?>><?php echo $dmcroommastermain['distance'];?> KM</td>

								<td align="center" <?php if($_REQUEST['costType']==2 || $_REQUEST['costType']==3){ ?> style="display:none;" <?php } ?>><strong><span id="totalcost2<?php echo $dmcroommastermain['id'];?>">0</span></strong></td>

								<td align="center" <?php if($_REQUEST['costType']!=3){ ?> style="display:none;" <?php } ?>><?php echo round(($vechileCost*$dmcroommastermain['distance']),2);?></td>
								
								<td align="center">
									<input type="number" name="noOfVehicles2<?php echo $dmcroommastermain['id'];?>" id="noOfVehicles2<?php echo $dmcroommastermain['id'];?>" value="1" style="width: 50px; border: 1px solid #ccc; padding: 5px 10px;" />
								</td>
				
								<td align="center">
									<select name="totalPax2<?php echo $dmcroommastermain['id'];?>" id="totalPax2<?php echo $dmcroommastermain['id'];?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
									<?php
									$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
									while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
									if($totalPaxData['fromRange']==$totalPaxData['toRange']){
									$paxName=$totalPaxData['fromRange'].' Pax';
									} else{
									$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
									} 
									?> 
									<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
									<?php } ?>
									</select>
									 </td>
				 
							    <td align="center"><div style="width: 60px!important" class="editbtnselect" <?php if($currencyValue>0){ ?>  onclick="addtransfertoquotations('<?php echo $dmcroommastermain['id'];?>','<?php echo $dmcroommastermain['supplierId'];?>','<?php echo getVehiclePaxCapacity($vehicleTypeId) ?>','<?php echo $tableN;?>');"  <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?> ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div> </td> 
								
								 <td align="center"> <div style="width: 80px!important"  class="editbtnselect" onclick="addtransportationCostfun('<?php echo $restrans['id']; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tableN;?>');" ><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Edit&nbsp;Cost</div>
								 </td>
		    				</tr>
							  <script>
								function calculatecost<?php echo $dmcroommastermain['id'];?>(){
									var vehicleCost = Number('<?php echo $vechileCost; ?>');
									var days = $('#noOfDays2<?php echo $dmcroommastermain['id']; ?>').val();
									$('#totalcost2<?php echo $dmcroommastermain['id'];?>').text(vehicleCost*days);
								}
								calculatecost<?php echo $dmcroommastermain['id'];?>(); 
						 
								</script>
							<?php
							
						}
					}else{ 
						if($_REQUEST['vehicleTypeId']==0){
  						$vehicleTypeId = $dmcroommastermain['vehicleTypeId'];
  					}else{
  						$vehicleTypeId = $_REQUEST['vehicleTypeId'];
  					} 
    					 
						$rs2=GetPageRecord('*','vehicleTypeMaster',' id="'.$vehicleTypeId.'"'); 
						$editresult24=mysqli_fetch_array($rs2); ?>
					
						<tr>
						<td align="left"><?php echo ucfirst($restrans['transferName']); ?></td> 
						<td align="left"><?php 
							if($editresult24['name']!=''){	echo $editresult24['name']; ?> | MaxPax(<?php echo getVehiclePaxCapacity($vehicleTypeId); ?>) <?php } ?> 
						</td>
						<td align="right"><?php echo getCurrencyName($baseCurrencyId).'['.clean($baseCurrencyVal).']';  ?></td>   
						<td align="right">NA</td>   
						<td align="right">NA</td>   
						<td align="right">NA</td>   
						<td align="right">NA</td>   

						<td align="right" <?php if($_REQUEST['costType']==2){ ?> style="display: none;" <?php } ?>>NA</td>   
						<td align="right" <?php if($_REQUEST['costType']==2){ ?> style="display: none;" <?php } ?>>NA</td>    
						<td align="center"><div style="width:80px!important;" class="editbtnselect" onclick="addtransportationCostfun('<?php echo $restrans['id']; ?>','','3');" ><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Edit&nbsp;Cost</div></td> 
					  </tr>
					   <?php 
					} 

			}  
		}else{
 
				// complete package costing
				$checkPackageRateQuery="";
				$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
				if(mysqli_num_rows($checkPackageRateQuery) > 0){
		 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

				    $currencyId = $getPackageRateData['currencyId'];
				    $currencyValue = getCurrencyVal($currencyId);
				    $supplierId = $getPackageRateData['supplierId'];
				}
		 
				$select2='capacity,carType,model';  
				$where2=' id="'.$vehicleModelId.'"'; 
				$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
				$editresult2412=mysqli_fetch_array($rs2);
				?>
				<tr>
				<td align="left"><?php echo ucfirst($restrans['transferName']); ?></td> 
				<td align="left"><?php 
						if($editresult2412['model']!=''){	echo $editresult2412['model']; ?> | MaxPax(<?php echo $editresult2412['capacity'];  ?>)<?php } ?> 
					</td>
				<?php if($calculationType != 3){  ?>
				<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
				<td align="center">&nbsp; </td> 
				<td align="center" <?php if($_REQUEST['costType']==2){ ?> style="display:none;" <?php } ?>>&nbsp;</td>
				<td align="center" <?php if($_REQUEST['costType']==2){ ?> style="display:none;" <?php } ?>>&nbsp;</td>
				<td align="center"></td>
				<?php } ?>
				<td align="center">
					<select name="totalPax2<?php echo $dmcroommastermain['id'];?>" id="totalPax2<?php echo $dmcroommastermain['id'];?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
						<?php
						$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
						while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
						if($totalPaxData['fromRange']==$totalPaxData['toRange']){
						$paxName=$totalPaxData['fromRange'].' Pax';
						} else{
						$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
						} 
						?> 
						<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
						<?php } ?>
					</select>
				</td> 
				<td align="center"><div class="editbtnselect" onclick="addtransfertoquotations('<?php echo $restrans['id'];?>','0','<?php echo getVehiclePaxCapacity($vehicleTypeId); ?>','2');"  id="selectthis2<?php echo $restrans['id'];?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>
				
			  </tr>
			   <?php 
			} 
		} 
		?> 
		<script>
		function addtransportationCostfun(transferId,rateId,tableN){
			$('#viewinfo').show();
			$('#loadvechileinfo').load('addtransportationCost.php?transferId='+transferId+'&tableN='+tableN+'&dayId=<?php echo $dayId; ?>&vehicleModelId=<?php echo urlencode($_REQUEST['vehicleModelId']); ?>&costType=<?php echo urlencode($_REQUEST['costType']); ?>&rateId='+rateId+'&vehicleTypeId=<?php echo $vehicleTypeId; ?>');
		}
		</script>
	</tbody>
	</table>
	<?php 
} ?>
</div> 

<?php if($c1==1 && $c2==1){ } ?> 		
</div>
<script>
	function selectthis(ele){
		$(ele).html('Selected');
		$(ele).removeAttr('onclick');
		$(ele).css('background-color','#d88319');
	}
</script>
<?php 
}


// for Tranfer block
if($transferCategory=='transfer'){

$costType = 1;
?> 
<div style="font-size:16px; padding:5px 7px;position:relative;text-align: right;"  >
<div class="addBtn" onclick="openinboundpop('action=addtransfertomaster&dayId=<?php echo $dayId; ?>&tc=1&cityId=<?php echo $cityId; ?>','800px');" style=" right: 14px; top: 8px; display: inline-block;">+&nbsp;Add New</div>


<style>
.addBtn{
	background: #7a96ff;
	font-size: 16px !important;
	color: #ffffff;
	cursor: pointer;
	padding: 5px 7px;
	border: 1px solid #fff;
	box-shadow: 0px 3px 5px -1px black;
}
</style>
</div>

<div style="padding:10px; border:1px #e3e3e3 solid;background-color: #fff; margin-bottom:10px;" id="trabox">   
	<div class="topaboxlist" id="trabox2">
 
		<?php  
		$rsty="";
		$rsty=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' 1 and (FIND_IN_SET("'.$cityId.'",destinationId) or destinationId=0 ) and transferCategory="transfer" and id="'.$transferId.'" '.$transferQuery.' and status=1 order by id desc'); 
		if(mysqli_num_rows($rsty)>0){  ?>
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
		<thead> 
		<tr>
		<th align="left" bgcolor="#DDDDDD" >Transfer&nbsp;Name</th> 
		<th align="left" bgcolor="#DDDDDD">Transfer&nbsp;Type</th>
		<th align="left" bgcolor="#DDDDDD">Vehicle Type</th>
		<?php if($calculationType != 3){  ?>  
			<th width="10%" align="right" bgcolor="#DDDDDD">Currency[ROE]</th>
			<?php if($_REQUEST['sic_pvt']==1){ ?>
			<th align="center" bgcolor="#DDDDDD">Adult Cost</th>
			<th align="center" bgcolor="#DDDDDD">Child Cost</th>
			<th align="center" bgcolor="#DDDDDD">Infant Cost</th>
			<?php }else{ ?>
			<th align="center" bgcolor="#DDDDDD">Vehicle Cost</th>
			<th align="center" bgcolor="#DDDDDD">No. of Vehicle</th>
			<?php } ?>
		<?php } ?>
		<th align="center" bgcolor="#DDDDDD">Pax Range</th> 
		<th align="center" colspan="2" bgcolor="#DDDDDD">&nbsp;</th>
		</tr>
		</thead> 
		<tbody>
		<?php 
		while($restrans=mysqli_fetch_array($rsty)){  
			
			if($calculationType !=3 ){ 
				$c2=1;
				$select22=''; 
				$wher22=''; 
				$rs22='';  
				$select22='*';    
				$where22=' 1 and (rateDestinationId="'.$cityId.'" or rateDestinationId=0 ) and transferNameId="'.$restrans['id'].'" '.$sicQuery.' '.$vehicleTypeQuery.' '.$supplierQuery.' '.$dateQuery.' and status=1 order by id asc';
				$rs22=GetPageRecord($select22,_DMC_TRANSFER_RATE_MASTER_,$where22); 
				if(mysqli_num_rows($rs22)>0){
					while($dmcroommastermain=mysqli_fetch_array($rs22)){
					    
						$rsa2s=GetPageRecord('*','quotationTransferRateMaster','tariffId="'.$dmcroommastermain['id'].'" and quotationId="'.$quotationId.'" ');  
						if(mysqli_num_rows($rsa2s)>0){
							$dmcroommastermain=mysqli_fetch_array($rsa2s);
							$vechileCost = $adultCost = $childCost = 0;
							$gstValueTransfer=getGstValueById($dmcroommastermain['gstTax']); 
                            // echo $dmcroommastermain['id'].'ssd';
							if($dmcroommastermain['transferType']==1){ 
								// SIC
								$adultCost = $dmcroommastermain['adultCost'];
								$childCost = $dmcroommastermain['childCost'];
								$infantCost = $dmcroommastermain['infantCost'];
							

								$adultCost = strip($adultCost)+strip($dmcroommastermain['representativeEntryFee']); 
								$childCost = strip($childCost)+strip($dmcroommastermain['representativeEntryFee']); 

								$markupCostA =  getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
								$markupCostC =  getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
								$markupCostE =  getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
								$adultCost = $adultCost+$markupCostA;
								$childCost = $childCost+$markupCostC;
								$infantCost = $infantCost+$markupCostE;
								
								$adultCost= (($adultCost*$gstValueTransfer/100)+$adultCost); 
								$childCost= (($childCost*$gstValueTransfer/100)+$childCost); 
								$infantCost= (($infantCost*$gstValueTransfer/100)+$infantCost); 

							}

							if($dmcroommastermain['transferType']==2){
								//PVT
								$vechileCost = $dmcroommastermain['vehicleCost'];
								
								$vechileCost = strip($vechileCost)+strip($dmcroommastermain['parkingFee'])+strip($dmcroommastermain['representativeEntryFee'])+strip($dmcroommastermain['assistance'])+strip($dmcroommastermain['guideAllowance'])+strip($dmcroommastermain['interStateAndToll'])+strip($dmcroommastermain['miscellaneous']); 
								$markupCostV =  getMarkupCost($vechileCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
								$vechileCost = $vechileCost+$markupCostV;
								$vechileCost= (($vechileCost*$gstValueTransfer/100)+$vechileCost); 
							} 
							$tableN = 2;
						}else{
							$vechileCost = $adultCost = $childCost = $infantCost = 0;
							$gstValueTransfer=getGstValueById($dmcroommastermain['gstTax']); 
							if($dmcroommastermain['transferType']==1){ 
								// SIC
								$adultCost = $dmcroommastermain['adultCost'];
								$childCost = $dmcroommastermain['childCost'];
								$infantCost = $dmcroommastermain['infantCost'];

								$adultCost = strip($adultCost)+strip($dmcroommastermain['representativeEntryFee']); 
								$childCost = strip($childCost)+strip($dmcroommastermain['representativeEntryFee']); 
								$infantCost = strip($infantCost)+strip($dmcroommastermain['representativeEntryFee']); 

								$markupCostA =  getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
								$markupCostC =  getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
								$markupCostE =  getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
								$adultCost = $adultCost+$markupCostA;
								$childCost = $childCost+$markupCostC;
								$infantCost = $infantCost+$markupCostE;
								
								$adultCost= (($adultCost*$gstValueTransfer/100)+$adultCost); 
								$childCost= (($childCost*$gstValueTransfer/100)+$childCost); 
								$infantCost= (($infantCost*$gstValueTransfer/100)+$infantCost); 

							} 
							if($dmcroommastermain['transferType']==2){
								//PVT
								$vechileCost = $dmcroommastermain['vehicleCost'];
								
								$vechileCost = strip($vechileCost)+strip($dmcroommastermain['parkingFee'])+strip($dmcroommastermain['representativeEntryFee'])+strip($dmcroommastermain['assistance'])+strip($dmcroommastermain['guideAllowance'])+strip($dmcroommastermain['interStateAndToll'])+strip($dmcroommastermain['miscellaneous']); 
								$markupCostV =  getMarkupCost($vechileCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
								$vechileCost = $vechileCost+$markupCostV;
								$vechileCost= (($vechileCost*$gstValueTransfer/100)+$vechileCost); 
							} 
							$tableN = 1;
						}


						$currencyId = $dmcroommastermain['currencyId'];
						$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
						// $currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:0;
						$cur=getCurrencyName($currencyId); 



						?>
					  <tr>
						<td align="left"><?php  echo ucfirst($restrans['transferName']); ?></td>
						<?php  
						// $rs2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,' id="'.$dmcroommastermain['vehicleModelId'].'"');
					 
						if($_REQUEST['vehicleTypeId']==0){
    						$vehicleTypeId = $dmcroommastermain['vehicleTypeId'];
    					}else{
    						$vehicleTypeId = $_REQUEST['vehicleTypeId'];
    					}

						$rs2=GetPageRecord('*','vehicleTypeMaster',' id="'.$vehicleTypeId.'"'); 
						$editresult24=mysqli_fetch_array($rs2);
						
						?>
						<td align="left"><?php echo getTransferType($restrans['transferType']);  ?></td>
						<td align="left"><?php 
							if($dmcroommastermain['transferType']==1){ echo 'SIC  '; } if($dmcroommastermain['transferType']==2){ echo 'PVT | '; } 
							if($editresult24['name']!=''){	
								if($_REQUEST['sic_pvt']==2){
								echo $editresult24['name'].' ('.$editresult24['capacity'].' '.'Pax )'; ?> 
								<?php } ?>
							 <?php } ?>
						</td> 
						<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
						<?php if($_REQUEST['sic_pvt']==1){  ?>
					  <td align="center"><?php echo round($adultCost,2); ?></td>
					  <td align="center"><?php echo round($childCost,2); ?></td>
					  <td align="center"><?php echo round($infantCost,2); ?></td>
						<?php }else{  ?>
					  <td align="center"><?php echo round($vechileCost,2); ?></td>
						<td align="center">
							<input type="number" name="noOfVehicles2<?php echo $dmcroommastermain['id'];?>" id="noOfVehicles2<?php echo $dmcroommastermain['id'];?>" value="1" style="width: 50px; border: 1px solid #ccc; padding: 5px 10px;" />
						</td>
						<?php } ?>
						<td align="center">
							<select name="totalPax2<?php echo $dmcroommastermain['id'];?>" id="totalPax2<?php echo $dmcroommastermain['id'];?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
							<?php
							$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
							while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
							if($totalPaxData['fromRange']==$totalPaxData['toRange']){
							$paxName=$totalPaxData['fromRange'].' Pax';
							} else{
							$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
							} 
							?> 
							<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
							<?php } ?>
							</select>				 
						</td> 
						<td align="center"><div class="editbtnselect" <?php if($currencyValue>0){ ?>  onclick="addtransfertoquotations('<?php echo $dmcroommastermain['id'];?>','<?php echo $dmcroommastermain['supplierId'];?>','<?php echo getVehiclePaxCapacity($vehicleTypeId); ?>','<?php echo $tableN;?>');"  <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?> id="selectthis2<?php echo $dmcroommastermain['id'];?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>
						<td align="center"> 
					  	<div style="width: 80px!important"  class="editbtnselect" onclick="addtransfCostfun('<?php echo $restrans['id']; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tableN; ?>');" ><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Edit&nbsp;Cost</div>
						</td> 
						 
						</tr>  
						<?php  
						$c2++; 
						$n++; 
					} 
				}else{
						$where22='transferNameId="'.$_REQUEST['transferId'].'" '.$sicQuery.' and serviceType="transfer"  and quotationId="'.$quotationId.'" '.$vehicleTypeQuery.' order by id desc';   
						$rs22=GetPageRecord('*','quotationTransferRateMaster',$where22); 
						if(mysqli_num_rows($rs22)>0){
							while($dmcroommastermain=mysqli_fetch_array($rs22)){  
								$tableN = 2;
								$currencyId = $dmcroommastermain['currencyId'];
								$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
								// $currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:0;
 								
								$vechileCost = $adultCost = $childCost = 0;
								$gstValueTransfer=getGstValueById($dmcroommastermain['gstTax']); 
								if($dmcroommastermain['transferType']==1){ 
									// SIC
									$adultCost = $dmcroommastermain['adultCost'];
									$childCost = $dmcroommastermain['childCost'];
									$infantCost = $dmcroommastermain['infantCost'];

									$adultCost = strip($adultCost)+strip($dmcroommastermain['representativeEntryFee']); 
									$childCost = strip($childCost)+strip($dmcroommastermain['representativeEntryFee']); 
									$infantCost = strip($infantCost)+strip($dmcroommastermain['representativeEntryFee']); 
									
									$markupCostA =  getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
									$markupCostC =  getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
									$markupCostE =  getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
									$adultCost = $adultCost+$markupCostA;
									$childCost = $childCost+$markupCostC;
									$infantCost = $infantCost+$markupCostE;

									$adultCost= (($adultCost*$gstValueTransfer/100)+$adultCost); 
									$childCost= (($childCost*$gstValueTransfer/100)+$childCost); 
									$infantCost= (($infantCost*$gstValueTransfer/100)+$infantCost); 

								} 
								if($dmcroommastermain['transferType']==2){
									//PVT
									$vechileCost = $dmcroommastermain['vehicleCost'];
									$vechileCost = strip($vechileCost)+strip($dmcroommastermain['parkingFee'])+strip($dmcroommastermain['representativeEntryFee'])+strip($dmcroommastermain['assistance'])+strip($dmcroommastermain['guideAllowance'])+strip($dmcroommastermain['interStateAndToll'])+strip($dmcroommastermain['miscellaneous']); 

									$markupCostV =  getMarkupCost($vechileCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
									$vechileCost = $vechileCost+$markupCostV;
									$vechileCost= (($vechileCost*$gstValueTransfer/100)+$vechileCost); 
								} 
                                
                                if($_REQUEST['vehicleTypeId']==0){
              						$vehicleTypeId = $dmcroommastermain['vehicleTypeId'];
              					}else{
              						$vehicleTypeId = $_REQUEST['vehicleTypeId'];
              					}
    					 
								$rs2=GetPageRecord('*','vehicleTypeMaster',' id="'.$vehicleTypeId.'"'); 
								$editresult25=mysqli_fetch_array($rs2);
								?>
								<tr>
								<td align="left"><?php  echo ucfirst($restrans['transferName']); ?></td>
								<td align="left"><?php echo getTransferType($restrans['transferType']);  ?></td>
								<td align="left"><?php 
									if($dmcroommastermain['transferType']==1){ echo 'SIC  '; } if($dmcroommastermain['transferType']==2){ echo 'PVT | '; } 
									
								if($editresult25['name']!=''){
									
									if($_REQUEST['sic_pvt']==2){

									echo $editresult25['name']; ?> | MaxPax(<?php echo getVehiclePaxCapacity($vehicleTypeId); ?>)
									
									<?php } ?>

								<?php } ?> 
								</td>
								<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
						    <?php if($_REQUEST['sic_pvt']==1){  ?>
							  <td align="center"><?php echo  round($adultCost,2); ?></td>
							  <td align="center"><?php echo  round($childCost,2); ?></td>
							  <td align="center"><?php echo  round($infantCost,2); ?></td>
								<?php }else{  ?>
							  <td align="center"><?php echo  round($vechileCost,2); ?></td>
								<td align="center">
									<input type="number" name="noOfVehicles2<?php echo $dmcroommastermain['id'];?>" id="noOfVehicles2<?php echo $dmcroommastermain['id'];?>" value="1" style="width: 50px; border: 1px solid #ccc; padding: 5px 10px;" />				
								</td>
								<?php } ?>

								<td align="center">
									<select name="totalPax2<?php echo $dmcroommastermain['id'];?>" id="totalPax2<?php echo $dmcroommastermain['id'];?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
										<?php
										$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'"  and status=1 order by fromRange asc');
										while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
											if($totalPaxData['fromRange']==$totalPaxData['toRange']){
												$paxName=$totalPaxData['fromRange'].' Pax';
											}else{
												$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
											} 
											?> 
											<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
											<?php 
										} ?>
									</select>				 
								</td>
								
								<td align="center">
									<div class="editbtnselect" <?php if($currencyValue>0){ ?>  onclick="addtransfertoquotations('<?php echo $dmcroommastermain['id'];?>','<?php echo $dmcroommastermain['supplierId'];?>','<?php echo getVehiclePaxCapacity($vehicleTypeId); ?>','<?php echo $tableN;?>');"  <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?>  id="selectthis2<?php echo $dmcroommastermain['id'];?>" >
										<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select
									</div>							
								</td>
							    <td align="center">
							    	<div class="editbtnselect" onclick="addtransfCostfun('<?php echo $restrans['id']; ?>','<?php echo $dmcroommastermain['id']; ?>',2);" >+&nbsp;Edit&nbsp;Cost</div>						     
							    </td>
							  </tr>
							  <?php
							}  
						}else{ 
							if($_REQUEST['vehicleTypeId']==0){
    						$vehicleTypeId = $dmcroommastermain['vehicleTypeId'];
    					}else{
    						$vehicleTypeId = $_REQUEST['vehicleTypeId'];
    					}
        					
							$rs2=GetPageRecord('*','vehicleTypeMaster',' id="'.$vehicleTypeId.'"'); 
							$editresult25=mysqli_fetch_array($rs2);

							?>
							<tr>
								<td align="left"><?php  echo ucfirst($restrans['transferName']); ?></td>
								<td align="left"><?php echo getTransferType($restrans['transferType']);  ?></td>
								<td align="left"><?php 
									if($_REQUEST['sic_pvt']==1){ echo 'SIC  '; } if($_REQUEST['sic_pvt']==2){ echo 'PVT | '; } 
									if($editresult25['name']!=''){

										if($_REQUEST['sic_pvt']==2){ 
										echo $editresult25['name']; ?> | MaxPax(<?php echo $editresult25['capacity']; ?>) <?php } ?>

									<?php } ?> 
								</td>
								<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
								<?php if($_REQUEST['sic_pvt']==1){  ?>
								<td align="center">&nbsp;</td>  
								<td align="center">&nbsp;</td>  
								<td align="center">&nbsp;</td>  
									<?php }else{ ?>
								<td align="center">&nbsp;</td>  
								<td align="center">
									<input type="number" name="noOfVehicles2<?php echo $dmcroommastermain['id'];?>" id="noOfVehicles2<?php echo $dmcroommastermain['id'];?>" value="1" style="width: 50px; border: 1px solid #ccc; padding: 5px 10px;" />
								</td>
									
								<?php }  ?>	
								<td align="center">
									<select name="totalPax2<?php echo $dmcroommastermain['id'];?>" id="totalPax2<?php echo $dmcroommastermain['id'];?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
									<?php
									$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1  and quotationId="'.$quotationId.'"  and status=1 order by fromRange asc');
									while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
									if($totalPaxData['fromRange']==$totalPaxData['toRange']){
									$paxName=$totalPaxData['fromRange'].' Pax';
									} else{
									$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
									} 
									?> 
									<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
									<?php } ?>
									</select>				 
								</td>
							<td align="center">
								<div class="editbtnselect" onclick="addtransfCostfun('<?php echo $restrans['id']; ?>','',3);" >+&nbsp;Edit&nbsp;Cost</div>
							</td>
					  	</tr>
							<?php
						} 
				} 
			}else{

				// complete package costing
				$checkPackageRateQuery="";
				$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
				if(mysqli_num_rows($checkPackageRateQuery) > 0){
		 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

			    $currencyId = $getPackageRateData['currencyId'];
			    $currencyValue = getCurrencyVal($currencyId);
			    $supplierId = $getPackageRateData['supplierId'];
				} 

				$select2='name,id';  
				$where2=' id="'.$transferType.'"'; 
				$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
				$editresult2412=mysqli_fetch_array($rs2);


				$select2='capacity,carType,model';  
				$where2=' id="'.$vehicleModelId.'"'; 
				$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
				$editresult2412=mysqli_fetch_array($rs2);
				?>
				<tr>
				<td align="left"><?php echo ucfirst($restrans['transferName']); ?></td> 
				<td align="center">&nbsp; </td> 
				<td align="left"><?php 
					if($editresult2412['model']!=''){
						echo $editresult2412['model']; ?> | MaxPax(<?php echo $editresult2412['capacity'];  ?>)<?php 
					} ?> 
				</td>
				<?php if($calculationType != 3){  ?>
				<td align="center" <?php if($_REQUEST['costType']==2){ ?> style="display:none;" <?php } ?>>&nbsp;</td>
				<td align="center" <?php if($_REQUEST['costType']==2){ ?> style="display:none;" <?php } ?>>&nbsp;</td>
				<td align="center"></td>
				<td align="center"></td> 
				<td align="center"></td> 
				<?php } ?>
				<td align="center">
					<select name="totalPax2<?php echo $restrans['id'];?>" id="totalPax2<?php echo $restrans['id'];?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
						<?php
						$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
						while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
						if($totalPaxData['fromRange']==$totalPaxData['toRange']){
							$paxName=$totalPaxData['fromRange'].' Pax';
						} else{
							$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
						} 
						?> 
						<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
						<?php } ?>
					</select>
				</td> 
				<td align="center"><div class="editbtnselect"  onclick="addtransfertoquotations('<?php echo $restrans['id'];?>','0','<?php echo getVehiclePaxCapacity($vehicleTypeId); ?>','2');" id="selectthis2<?php echo $restrans['id'];?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td> 
			  </tr>
			   <?php 
			} 
		}  
		?> 
		</tbody>
		</table> 
		<?php 
		} else{
			?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
				<tr>
					<td align="" valign="top" style="text-align: center;"><strong style="font-size: 15px;color:#f02121;">Please select Transfer Name!</strong></td>
				</tr>
		  </table>
			<?php 
		} ?>
	</div> 
 	<script>
 	function addtransfCostfun(transferId,rateId,tableN){
	 	$('#viewinfo').show();
	 	$('#loadvechileinfo').load('addtransfCost.php?transferId='+transferId+'&tableN='+tableN+'&sic_pvt=<?php echo trim($_REQUEST['sic_pvt']); ?>&dayId=<?php echo $dayId; ?>&vehicleModelId=<?php echo urlencode($_REQUEST['vehicleModelId']); ?>&rateId='+rateId+'&vehicleTypeId=<?php echo $vehicleTypeId; ?>');
	}
 	</script>		
 	<script>
	function selectthis2(ele){
		$(ele).html('Selected');
		$(ele).removeAttr('onclick');
		$(ele).css('background-color','#d88319');
	}
	</script>
	</div>
<?php 
} ?>

<script>
$(document).on("input", ".numeric", function() {
this.value = this.value.replace(/\D/g,'');
});
</script>


