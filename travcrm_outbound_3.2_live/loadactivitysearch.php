<?php
include "inc.php";
$startDayIdArray=explode(',',$_REQUEST['startDayId']);
$startDate=$startDayIdArray[1];

$endDayIdArray=explode(',',$_REQUEST['endDayId']);
$endDate=$endDayIdArray[1];

//get dest name above
$dayId = $_REQUEST['dayId'];

// destinationId

$destinationId = $_REQUEST['destinationId'];

$activityName='';
if($_REQUEST['activityName']!=''){
	$activityName = $_REQUEST['activityName'];
}
$serviceType = $_REQUEST['serviceType'];
$defaultWise = trim($_REQUEST['defaultWise']);
$transferType = trim($_REQUEST['transferType']);
if($transferType>0){
	$transferFilter= 'and transferType="'.$transferType.'"';
}
$quotationId= $_REQUEST['quotationId']; 
$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
$quotationData = mysqli_fetch_array($rs1); 
$queryId = $quotationData['queryId'];
$calculationType = $quotationData['calculationType'];

$fromDate=date("Y-m-d", strtotime($startDate));
$fromYear=date("Y", strtotime($startDate));

$toDate=date("Y-m-d", strtotime($endDate));
$toYear=date("Y", strtotime($endDate));

$totalDays = (strtotime($toDate) - strtotime($fromDate)) / (60 * 60 * 24)+1;
 
 
$isDefault = '';
if($defaultWise == 1){
	$isDefault = ' and isDefault=1';
}

$whereDateQuery = '';
$whereDateQuery .= ' and "'.$fromDate.'" BETWEEN fromDate and toDate ';
$whereSuppQuery = " and supplierId in ( select id from suppliersMaster where 1 and ( activityType=3 or activityType=1 ) and deletestatus=0 )";

?>
<table cellpadding="3" cellspacing="0" border="0" class="">	
	<tr>
		<td width="20px">&nbsp;</td>
		<td width="85%">
		</td>
		<td width="200px" align="center">
			<div class="addBtn" style=" padding: 6px 13px !important; width: 80px;color: #fff; font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="openinboundpop('action=addactivitytomaster&dayId=<?php echo $dayId; ?>&cityId=<?php echo $cityId; ?>','800px');">+&nbsp;Add New</div>
		</td>

		<style>
		.addBtn{
				margin-left: 46px;
				background: #7a96ff;
				font-size: 16px !important;
				color: #ffffff;
				cursor: pointer;
				padding: 5px 7px;
				border: 1px solid #fff;
				box-shadow: 0px 3px 5px -1px black;
			}
	</style>
	</tr>
</table>
<div style="padding:10px; border:1px #e3e3e3 solid; background-color: #fff; margin-bottom:10px;" id="sicbox">
<div class="topaboxlist"  style="max-height: 300px; overflow: auto;">
 
	<?php 
	$whereServQuery = '';
	$whereServQuery=' otherActivityCity = "'.getDestination($destinationId).'" '.$isDefault.' and otherActivityName LIKE "%'.$activityName.'%" and status=1 order by id desc'; 
	$whereServQuery=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$whereServQuery);
	if(mysqli_num_rows($whereServQuery) > 0 ){
	?>
	<table width="100%" border="1" cellpadding="4" cellspacing="0" class=" gridtable" >
		<thead>
			<tr>
				<th align="left" >Sightseeing&nbsp;Service</th>
				<th width="15%" align="left" >Supplier</th>
				<!-- <th width="10%" align="center" >Pax&nbsp;Slab</th> -->
				<?php if($calculationType!=3){ ?>
				<th width="10%" align="center" >Currency[ROE]</th>
				<th align="right">Adult&nbsp;Cost</th>
				<th align="right">Child&nbsp;Cost</th>
				<th align="right">Infant&nbsp;Cost</th>
				<?php } if($transferType==2){ ?>
				<th align="right">Vehicle&nbsp;Type</th>
				<th align="right">Vehicle&nbsp;Cost</th>
				<th align="right">No.&nbsp;Of&nbsp;Vehicle</th>
				<?php } ?>
				<th width="5%" align="right" colspan="2" >&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($activityData=mysqli_fetch_array($whereServQuery)){
			if($calculationType!=3){
				$c1=1; 
				$whereMainQuery=' 1 and serviceid="'.$activityData['id'].'" '.$whereSuppQuery.' '.$whereDateQuery.' '.$transferFilter.' and status=1 order by id desc ';
				$mainRateQuery=GetPageRecord('*','dmcotherActivityRate',$whereMainQuery);
				if(mysqli_num_rows($mainRateQuery)>0){
					while($dmcRateD = mysqli_fetch_assoc($mainRateQuery)){
						
						$rsa2s=GetPageRecord('*','quotationActivityRateMaster','dmcId="'.$dmcRateD['id'].'" and quotationId="'.$quotationId.'"');  
						if(mysqli_num_rows($rsa2s)>0 ){
							$dmcRateD='';
							$dmcRateD=mysqli_fetch_array($rsa2s);

							$tableN = 2;
							$dmcId = $dmcRateD['id'];
						}else{
							$tableN = 1;
							$dmcId = $dmcRateD['id'];
						}
						$activityCostPP = 0;
						$gstValue=getGstValueById($dmcRateD['gstTax']); 
						$activityCostPP = strip($dmcRateD['perPaxCost']);
						$activityCostPP= round(($activityCostPP*$gstValue/100)+$activityCostPP); 

						$serviceId = $activityData['id'];
						$currencyId = $dmcRateD['currencyId'];
						// $currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:0;
					if($dmcRateD['transferType']!=2 && $dmcRateD['transferType']!=3){
					$ticketAdultCostMC =  getMarkupCost($dmcRateD['ticketAdultCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					$ticketchildCostMC =  getMarkupCost($dmcRateD['ticketchildCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					$ticketinfantCostMC =  getMarkupCost($dmcRateD['ticketinfantCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					}
					$ticketAdultCost = getCostWithGST(($dmcRateD['ticketAdultCost']+$ticketAdultCostMC),getGstValueById($dmcRateD['gstTax']),0);
					$ticketchildCost = getCostWithGST(($dmcRateD['ticketchildCost']+$ticketchildCostMC),getGstValueById($dmcRateD['gstTax']),0);
					$ticketinfantCost = getCostWithGST(($dmcRateD['ticketinfantCost']+$ticketinfantCostMC),getGstValueById($dmcRateD['gstTax']),0);
					if($dmcRateD['transferType']!=2 && $dmcRateD['transferType']!=3){
					$adultCostMC =  getMarkupCost($dmcRateD['adultCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					$childCostMC =  getMarkupCost($dmcRateD['childCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					$infantCostMC =  getMarkupCost($dmcRateD['infantCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					}
					$adultCost = getCostWithGST(($dmcRateD['adultCost']+$adultCostMC),getGstValueById($dmcRateD['gstTax']),0);
					$childCost = getCostWithGST(($dmcRateD['childCost']+$childCostMC),getGstValueById($dmcRateD['gstTax']),0);
					$infantCost = getCostWithGST(($dmcRateD['infantCost']+$infantCostMC),getGstValueById($dmcRateD['gstTax']),0);

					$vehicleCostMC =  getMarkupCost($dmcRateD['vehicleCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);

					$vehicleCost = getCostWithGST(($dmcRateD['vehicleCost']+$vehicleCostMC),getGstValueById($dmcRateD['gstTax']),0);
					$repCost = getCostWithGST($dmcRateD['repCost'],getGstValueById($dmcRateD['gstTax']),0);


						$currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:getCurrencyVal($currencyId);

						$rsv = GetPageRecord('name,capacity','vehicleTypeMaster','id="'.$dmcRateD['vehicleId'].'"');
							$vehicleType = mysqli_fetch_assoc($rsv);
							$capacity ='('.$vehicleType['capacity'].')';
						// $currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:0;
						?>
						<tr>
							<td align="left"><?php echo clean($activityData['otherActivityName']);  ?></td>
							<td align="left"><?php echo getsupplierCompany($dmcRateD['supplierId']);  ?></td>
							

					<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
					<td align="right"><?php	echo !empty(($ticketAdultCost+$adultCost)) ? strip($ticketAdultCost+$adultCost) : '0'; ?></td>
					<td align="right"><?php	echo !empty(($ticketchildCost+$childCost))?strip($ticketchildCost+$childCost):0; ?></td>
					<td align="right"><?php	echo !empty(($ticketinfantCost+$infantCost))?strip($ticketinfantCost+$infantCost):0; ?></td>
					<?php if($transferType==2){ ?>
						<td><?php echo $vehicleType['name'].$capacity; ?></td>
						<td><?php echo $vehicleCost; ?></td>
						<td align="center"><input type="number" name="noOfVehicles<?php echo $dmcId; ?>" id="noOfVehicles<?php echo $dmcId; ?>" value="1" style="width:50px"></td>
					<?php } ?>
					<td align="center">


					<?php
						$rs21=GetPageRecord('*','hoteloperationRestriction',' otheractivityId="'.$serviceId.'"  and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" ) ');
						$msgOpr = '';
						if(mysqli_num_rows($rs21) > 0){
							$oprResData=mysqli_fetch_array($rs21);
							$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
							?> 
							<div style="width:55px!important;" class="editbtnselect2" onclick="confirm('<?php echo strip($entranceName); ?> - Sightseeing restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>');" id="selectthis<?php echo $c1; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
						<?php 
					} else { ?>



						<div  id="selectBtnE<?php echo $dmcRateD['id']; ?><?php echo $tableN ; ?>" class="editbtnselect fa fa-hand-pointer-o" <?php if($currencyValue>0){ ?> onclick="addguidetoquotations('<?php echo $dmcId; ?>','<?php echo $serviceId; ?>','<?php echo $totalDays; ?>','<?php echo $tableN ; ?>');" <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?>>&nbsp;Select</div>

					<?php } ?>

					</td>
					<td> 
						<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff;font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addeditactivityprice('addeditactivityprice','<?php echo $dmcId ; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>
					</td>
					</tr>
						<?php
					} 
				}else{ 
					$whereQuotRateSql = ' 1 and serviceId="'.$activityData['id'].'" '.$whereSuppQuery.' '.$whereDateQuery.' '.$transferFilter.' and quotationId="'.$quotationId.'" order by id desc ';
					$whereQuotRateQuery=GetPageRecord('*','quotationActivityRateMaster',$whereQuotRateSql);
					if(mysqli_num_rows($whereQuotRateQuery)>0){
						while($actQoutRateD = mysqli_fetch_assoc($whereQuotRateQuery)){

								$tableN = 2;
								$dmcId = $actQoutRateD['id'];
								
								$activityCostPP = 0;
								$gstValue=getGstValueById($actQoutRateD['gstTax']); 
								if($actQoutRateD['transferType']!=2 && $actQoutRateD['transferType']!=3){
									$ticketAdultCostMC =  getMarkupCost($actQoutRateD['ticketAdultCost'],$actQoutRateD['markupCost'],$actQoutRateD['markupType']);
									$ticketchildCostMC =  getMarkupCost($actQoutRateD['ticketchildCost'],$actQoutRateD['markupCost'],$actQoutRateD['markupType']);
									$ticketinfantCostMC =  getMarkupCost($actQoutRateD['ticketinfantCost'],$actQoutRateD['markupCost'],$actQoutRateD['markupType']);
	
									$adultCostMC =  getMarkupCost($actQoutRateD['adultCost'],$actQoutRateD['markupCost'],$actQoutRateD['markupType']);
									$childCostMC =  getMarkupCost($actQoutRateD['childCost'],$actQoutRateD['markupCost'],$actQoutRateD['markupType']);
									$infantCostMC =  getMarkupCost($actQoutRateD['infantCost'],$actQoutRateD['markupCost'],$actQoutRateD['markupType']);
								}
							
								$vehicleCostMC =  getMarkupCost($actQoutRateD['vehicleCost'],$actQoutRateD['markupCost'],$actQoutRateD['markupType']);

								$ticketAdultCost = getCostWithGST(($actQoutRateD['ticketAdultCost']+$ticketAdultCostMC),getGstValueById($actQoutRateD['gstTax']),0);
								$ticketchildCost = getCostWithGST(($actQoutRateD['ticketchildCost']+$ticketchildCostMC),getGstValueById($actQoutRateD['gstTax']),0);
								$ticketinfantCost = getCostWithGST(($actQoutRateD['ticketinfantCost']+$ticketinfantCostMC),getGstValueById($actQoutRateD['gstTax']),0);

								$adultCost = getCostWithGST(($actQoutRateD['adultCost']+$adultCostMC),getGstValueById($actQoutRateD['gstTax']),0);
								$childCost = getCostWithGST(($actQoutRateD['childCost']+$childCostMC),getGstValueById($actQoutRateD['gstTax']),0);
								$infantCost = getCostWithGST(($actQoutRateD['infantCost']+$infantCostMC),getGstValueById($actQoutRateD['gstTax']),0);
								$vehicleCost = getCostWithGST(($actQoutRateD['vehicleCost']+$vehicleCostMC),getGstValueById($actQoutRateD['gstTax']),0);
								$repCost = getCostWithGST($actQoutRateD['repCost'],getGstValueById($actQoutRateD['gstTax']),0);

								$serviceId = $activityData['id'];
								$currencyId = $actQoutRateD['currencyId'];
								$currencyValue = ($actQoutRateD['currencyValue']>0)?$actQoutRateD['currencyValue']:getCurrencyVal($currencyId);
								// $currencyValue = ($actQoutRateD['currencyValue']>0)?$actQoutRateD['currencyValue']:0;

								$rsv = GetPageRecord('name,capacity','vehicleTypeMaster','id="'.$actQoutRateD['vehicleId'].'"');
								$vehicleType = mysqli_fetch_assoc($rsv);
								$capacity ='('.$vehicleType['capacity'].')';
								?>
							<tr>
								<td align="left"><?php echo clean($activityData['otherActivityName']);  ?></td>
								<td align="left"><?php echo getsupplierCompany($actQoutRateD['supplierId']);  ?></td>
								

								<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
						<td align="right"><?php	echo !empty(($ticketAdultCost+$adultCost))?strip($ticketAdultCost+$adultCost):0; ?></td>
						<td align="right"><?php	echo !empty(($ticketchildCost+$childCost))?strip($ticketchildCost+$childCost):0; ?></td>
						<td align="right"><?php	echo !empty(($ticketinfantCost+$infantCost))?strip($ticketinfantCost+$infantCost):0; ?></td>
						<?php if($transferType==2){ ?>
						<td><?php echo $vehicleType['name'].$capacity; ?></td>
						<td><?php echo $vehicleCost; ?></td>
						<td align="center"><input type="number" name="noOfVehicles<?php echo $dmcId; ?>" id="noOfVehicles<?php echo $dmcId; ?>" value="1" style="width:50px"></td>
						<?php } ?>		
						<td align="center">

						<?php
						$rs21=GetPageRecord('*','hoteloperationRestriction',' otheractivityId="'.$serviceId.'"  and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" ) ');
						$msgOpr = '';
						if(mysqli_num_rows($rs21) > 0){
							$oprResData=mysqli_fetch_array($rs21);
							$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
							?> 
							<div style="width:55px!important;" class="editbtnselect2" onclick="confirm('<?php echo strip($entranceName); ?> - Sightseeing restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>');" id="selectthis<?php echo $c1; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
							<?php 
						} else { ?>
							<div style=" background-color:#589fa6;" id="selectBtnE<?php echo $actQoutRateD['id']; ?><?php echo $tableN ; ?>" class="editbtnselect fa fa-hand-pointer-o" <?php if($currencyValue>0){ ?> onclick="addguidetoquotations('<?php echo $dmcId; ?>','<?php echo $serviceId; ?>','<?php echo $totalDays; ?>','<?php echo $tableN ; ?>');" <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?>>&nbsp;Select</div>
						<?php  } ?> 





									<!-- <div style=" background-color:#589fa6;" id="selectBtnE<?php echo $actQoutRateD['id']; ?><?php echo $tableN ; ?>" class="editbtnselect fa fa-hand-pointer-o" <?php if($currencyValue>0){ ?> onclick="addguidetoquotations('<?php echo $dmcId; ?>','<?php echo $serviceId; ?>','<?php echo $totalDays; ?>','<?php echo $tableN ; ?>');" <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?>>&nbsp;444Select</div> -->




								</td>
								<td> 
									<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff;font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addeditactivityprice('addeditactivityprice','<?php echo $dmcId; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>
								</td>
							</tr>
							<?php  
						}
					}else{
						$tableN = 3;
						?>
						<tr>
							<td align="left"><?php echo clean($activityData['otherActivityName']);  ?></td>
							<td align="left">NA</td>
							<td align="right">
							<?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?>
								<!-- <select name="slabId3<?php echo $activityData['id']; ?>" id="slabId3<?php echo $activityData['id']; ?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
								<?php
								// $totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
								// while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
								// 	if($totalPaxData['fromRange']==$totalPaxData['toRange']){
								// 		$paxName=$totalPaxData['fromRange'].' Pax';
								// 	}else{
								// 		$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
								// 	} 
									?> 
									<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
									<?php 
								//} ?>
								</select> -->
							</td>
							<td align="right">NA</td>
							<td align="right">NA</td>
							<td align="center">NA</td> 
							<?php if($transferType==2){ ?>
							<td>NA</td>
							<td>NA</td>
							<td align="center"><input type="number" name="noOfVehicles" id="noOfVehicles" value="1" style="width:50px"></td>
							<?php } ?>
							<td align="center">&nbsp;</td> 
							<td align="center">
								<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff;font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addeditactivityprice('addeditactivityprice','<?php echo $activityData['id']; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>
							</td>
						</tr>
						<?php 
					}
				}

			}else{
				$tableN = 3;
				// complete package costing
				$checkPackageRateQuery="";
				$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
				if(mysqli_num_rows($checkPackageRateQuery) > 0){
					$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

					$currencyId = $getPackageRateData['currencyId'];
					$currencyVal = getCurrencyVal($currencyId);
					$supplierId = $getPackageRateData['supplierId'];
				} 
				?>
				<tr>
					<td align="left"><?php echo clean($activityData['otherActivityName']);  ?></td>
					<td align="left"><?php echo getsupplierCompany($supplierId);  ?></td>
					<td align="left">
						<!-- <select name="slabId3<?php echo $activityData['id']; ?>" id="slabId3<?php echo $activityData['id']; ?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
						<?php
						// $totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
						// while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
						// 	if($totalPaxData['fromRange']==$totalPaxData['toRange']){
						// 		$paxName=$totalPaxData['fromRange'].' Pax';
						// 	}else{
						// 		$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
						// 	} 
							?> 
							<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
							<?php 
						//} 
						?>
						</select> -->
					</td> 
					<td align="center">

					<?php
						$rs21=GetPageRecord('*','hoteloperationRestriction',' otheractivityId="'.$serviceId.'"  and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" ) ');
						$msgOpr = '';
						if(mysqli_num_rows($rs21) > 0){
							$oprResData=mysqli_fetch_array($rs21);
							$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
							?> 
							<div style="width:55px!important;" class="editbtnselect2" onclick="confirm('<?php echo strip($entranceName); ?> - Sightseeing restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>');" id="selectthis<?php echo $c1; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
							<?php 
						} else { ?>


						<div  id="selectBtnE<?php echo $activityData['id']; ?><?php echo $tableN ; ?>" class="editbtnselect fa fa-hand-pointer-o" onclick="addguidetoquotations('','<?php echo $activityData['id']; ?>','<?php echo $totalDays; ?>','<?php echo $tableN ; ?>');">&nbsp;Select</div>

						<?php } ?>

					</td> 
				</tr>
				<?php 

			}
			$c1++;
		} ?>
		</tbody>
	</table> 

	<div id="loadprice" class="viewInfo" style="background-image: url('images/bgpop.png'); background-repeat: repeat;">
		<div class="pricepoup"></div>
	</div>
	<!-- loadaddeditactivityprice.php -->
	<script type="text/javascript">
		$('#entrancecounding').text('<?php echo $c1-1;?> Monument Found');
		function addeditactivityprice(action,rateId,tableN,poupwidth){
			$("#loadprice").show();
			$(".pricepoup").load('loadaddeditactivityprice.php?action='+action+'&rateid='+rateId+'&quotationId=<?php echo $quotationId; ?>&destinationId=<?php echo $destinationId; ?>&tableN='+tableN+'&dayId=<?php echo $dayId; ?>&transferType=<?php echo $transferType; ?>&destinationId=<?php echo $_REQUEST['destinationId'] ?>');
			$('.pricepoup').css('width', poupwidth);
		}
	</script>
	<style>
		.editbtnselect{
		border: 1px solid;
		padding: 8px 15px;
		text-align: center;
		font-size: 13px;
		border-radius: 3px;
		background-color: #4caf50;
		cursor: pointer;
		color: #fff;
		}
		 
		#loadprice {
		background-color: #00000094;
		background-color: rgba(50, 61, 76, 0.91);
		width: 100%;
		height: 100%;
		position: fixed;
		left: 0px;
		top: 0px;
		overflow: auto;
		display: none;
		z-index: 9999;
		}
		#loadprice .pricepoup {
		background-color: #FFFFFF;
		max-width: 800px;
		margin: auto;
		margin-top: 20px;
		}
		.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
		width: 100% !important;
		} 
		.editbtnselect2{   
			border: 1px solid;
		    padding: 8px 15px;
		    text-align: center;
		    font-size: 13px;
		    border-radius: 3px;
		    background-color: #4caf50;
		    cursor: pointer;
		    color: #fff;
		}
		.newbox{
			    height: 20px;
		    width: 60px;
		    border: 1px solid;
		    border-color: #ccc;
		    border-radius: 2px;
		}
		.newbox_select{
			height: 30px;
			width: 140px;
		}
	</style>

	<?php }else{ ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable"  id="guidesicTable">
		<thead>
			<tr>
				<th align="center" >No Result Found</th>
			</tr>
		</thead>
	</table>
	<?php } ?>
</div>
</div>

