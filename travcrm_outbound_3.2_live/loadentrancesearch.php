<?php
include "inc.php";
$startDayQuery='';
$startDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['startDayId'].'" ');  
$startDayData=mysqli_fetch_array($startDayQuery);

$endDayQuery='';
$endDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['endDayId'].'" ');  
$endDayData=mysqli_fetch_array($endDayQuery);

$checkQurey='';
$checkQurey=GetPageRecord('*',_QUERY_MASTER_,' id="'.$startDayData['queryId'].'" ');  
$queryData=mysqli_fetch_array($checkQurey);

$quotQurey='';
$quotQurey=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$startDayData['quotationId'].'" ');  
$quotationData=mysqli_fetch_array($quotQurey);

$calculationType = $quotationData['calculationType'];

$nation=GetPageRecord('*','nationalityMaster','id ="'.$queryData['nationality'].'"');
$nationData=mysqli_fetch_array($nation);
$counNation = mysqli_num_rows($nation);

$whereNationalityType = '';
if($nationData['countryId'] == $defaultCountryId || ($nationData['countryId'] == 0 && $nationData['name'] == 'Local')){
	$whereNationalityType = ' and nationalityType=1';
}else if($nationData['countryId'] != $defaultCountryId || ($nationData['countryId'] == 0 && $nationData['name'] == 'Foreign')){
	$whereNationalityType = ' and nationalityType=2';
}else{
	$whereNationalityType = ' and nationalityType=1';
}
$whereNationalityType = '';
$startDayDate = $startDayData['srdate'];
$endDayDate = $endDayData['srdate'];
 
if($_REQUEST['destWise'] == 2 && isset($_REQUEST['destWise'])){
	$cityId= $_REQUEST['destinationId'];
}else{
	$cityId= $startDayData['cityId'];
}  

$entranceName = trim($_REQUEST['entranceName']);
$defaultWise = trim($_REQUEST['defaultWise']);
$transferType = trim($_REQUEST['transferType']);
$destinationId = getDestination(trim($cityId));
//get dest name above

$queryId = $startDayData['queryId'];
$quotationId = $startDayData['quotationId'];
$dayId=$startDayData['id'];

$fromDate=date("Y-m-d", strtotime($startDayDate));
$fromYear=date("Y", strtotime($fromDate));
$toDate=date("Y-m-d", strtotime($endDayDate));
$toYear=date("Y", strtotime($toDate));

$isDefault = '';
if($defaultWise == 1){
	$isDefault = ' and isDefault=1';
}
   
$whereDate = ' and "'.$fromDate.'" BETWEEN fromDate and toDate and "'.$toDate.'" BETWEEN fromDate and toDate ';

// this for rate transferType
$transferType = $_REQUEST['transferType'];
$tptQuery = '';	
if($_REQUEST['transferType']>0){
	$tptQuery = ' and (transferType="'.$_REQUEST['transferType'].'" || transferType=0 )';
}

$whereDEST = ' and entranceNameId in ( select id from '._PACKAGE_BUILDER_ENTRANCE_MASTER_.' where entranceCity="'.$destinationId.'"  and status=1  and deletestatus=0 ) ';
$whereSupp = ' and supplierId in ( select id from suppliersMaster where 1 and ( entranceType=4 or entranceType=1 ) and deletestatus=0 ) ';

?>
<table cellpadding="3" cellspacing="0" border="0" class="">	
		<tr>
			<td width="20px">&nbsp;</td>
			<td width="85%">
				<span id="entrancecounding"> 0 Monument Found </span>
			</td>
			<td width="200px" align="center">
				<div class="addBtn" style=" padding: 6px 13px !important;  width: 80px;color: #fff; font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="openinboundpop('action=addentrancetomaster&dayId=<?php echo $dayId; ?>&cityId=<?php echo $cityId; ?>','800px');">+&nbsp;Add New</div>
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
<div style="padding:10px; border:1px #ddd solid; background-color: #fff; margin-bottom:10px;" id="sicbox">
	<div class="topaboxlist"  style="max-height: 300px; overflow: auto;">
	<table width="100%" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;border-color:#ccc;" >
	<thead>
		<tr>
			<th align="left"  >Monument&nbsp;Name</th>
			<th align="left">Supplier Name </th>
			<?php if($calculationType!=3){  ?>
			<th align="right">Currency[ROE]</th>
			<th align="right">Adult&nbsp;Cost</th>
			<th align="right">Child&nbsp;Cost</th>
			<th align="right">Infant&nbsp;Cost</th>
			<?php if($transferType == 2){  ?>
			<th align="left">Vehicle&nbsp;Type</th>
			<th align="right">Vehicle&nbsp;Cost</th>
			<th align="right">No.&nbsp;Of&nbsp;Vehicle</th>
			<!-- <th align="right">Infant&nbsp;Transfer</th> -->
 			<?php } ?>
			<!-- <th align="left">Vehicle&nbsp;Name</th> -->
			<!-- <th align="right">Vehicle&nbsp;Cost</th> -->
			<?php //} ?>
			<!-- <th align="right">Rep.&nbsp;Cost</th> -->
			<?php } ?>
 			<th align="right" colspan="2" width="20%">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$c1=1;
	$where1=$rs1='';
	$where1='entranceCity="'.$destinationId.'" '.$isDefault.' '.$tptQuery.' and entranceName LIKE "%'.$entranceName.'%"  and status=1  and deletestatus=0  order by entranceName asc';
	$rs1=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,$where1);
	while($entranceData=mysqli_fetch_array($rs1)){

		$serviceId=$entranceData['id'];
		$entranceName=$entranceData['entranceName'];
		$tptType=$entranceData['transferType'];

		$sicQuery = '';	
		if($_REQUEST['transferType']>0){
			$sicQuery = ' and transferType="'.$_REQUEST['transferType'].'"';
		}

		$isClosed=0;
		$rs2xs=GetPageRecord('id',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id='.$entranceData['id'].' and FIND_IN_SET("'.date("l", strtotime($fromDate)).'", closeDaysname)');
		if(mysqli_num_rows($rs2xs)>0){
			$isClosed=1;
		}
		if($calculationType!=3){

			$rs221='';
			$rs221=GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,' status=1 and entranceNameId = "'.$serviceId.'" and supplierId>0  '.$sicQuery.'  '.$whereDate.' '.$whereSupp.' '.$whereNationalityType.'  order by fromDate asc'); 
			if(mysqli_num_rows($rs221)>0){
				while ($dmcRateD=mysqli_fetch_array($rs221)) {

					$rs221=GetPageRecord('*','quotationEntranceRateMaster','dmcId="'.$dmcRateD['id'].'" and quotationId="'.$quotationId.'"');  
					if(mysqli_num_rows($rs221)>0 ){
						$dmcRateD='';
						$dmcRateD=mysqli_fetch_array($rs221);

						$tableN = 2;
						$dmcId = $dmcRateD['id'];
					}else{
						$tableN = 1;
						$dmcId = $dmcRateD['id'];
					}
					if($dmcRateD['transferType']!=2){
						$markupCostEnt = $dmcRateD['markupCost'];
						$markupTypeEnt = $dmcRateD['markupType'];
					}
					
					$ticketAdultCost = getCostWithGSTID_Markup($dmcRateD['ticketAdultCost'],$dmcRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
					$ticketchildCost = getCostWithGSTID_Markup($dmcRateD['ticketchildCost'],$dmcRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
					$ticketinfantCost = getCostWithGSTID_Markup($dmcRateD['ticketinfantCost'],$dmcRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
					$adultCost = getCostWithGSTID_Markup($dmcRateD['adultCost'],$dmcRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
					$childCost = getCostWithGSTID_Markup($dmcRateD['childCost'],$dmcRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
					$infantCost = getCostWithGSTID_Markup($dmcRateD['infantCost'],$dmcRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
					$vehicleCost = getCostWithGSTID_Markup($dmcRateD['vehicleCost'],$dmcRateD['gstTax'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					$repCost = getCostWithGSTID_Markup($dmcRateD['repCost'],$dmcRateD['gstTax'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
 
					$currencyId = $dmcRateD['currencyId'];
					$currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:getCurrencyVal($currencyId);
					// $currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:0;

					$rs2="";
					$rs2=GetPageRecord('*','vehicleTypeMaster',' 1 and id="'.$dmcRateD['vehicleId'].'" '); 
					$vehicleData=mysqli_fetch_array($rs2);
					?>	
					<tr>
					<td align="left"> <?php echo clean($entranceName); ?></td> 
					<td align="left"><?php echo getsupplierCompany($dmcRateD['supplierId']); ?> </td>
					<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
					
					<td align="right"><?php	echo !empty(($ticketAdultCost+$adultCost)) ? strip($ticketAdultCost+$adultCost) : '0'; ?></td>
					<td align="right"><?php	echo !empty(($ticketchildCost+$childCost))?strip($ticketchildCost+$childCost):0; ?></td>
					<td align="right"><?php	echo !empty(($ticketinfantCost+$infantCost))?strip($ticketinfantCost+$infantCost):0; ?></td>
					<?php if($transferType == 2){  ?>
						<td align="left"><?php echo ucfirst($vehicleData['name']);?>(<?php echo $vehicleData['capacity'];?>)</td>
						<td align="right"><?php	echo !empty($vehicleCost)?strip($vehicleCost):0; ?></td>
						<td align="center"><input type="number" name="noOfVehicle<?php echo $dmcId; ?>" id="noOfVehicle<?php echo $dmcId; ?>" value="1" style="width: 55px;"></td>
						<!-- <td align="right"><?php	echo !empty($infantCost)?strip($infantCost):0; ?></td> -->
					<?php } ?>
						
						<!-- <td align="right"><?php	echo !empty($vehicleCost)?strip($vehicleCost):0; ?></td> -->
				
					<!-- <td align="right"><?php	echo !empty($repCost)?strip($repCost):0; ?></td> -->
					<td align="right" valign="middle">
					<?php
					$rs21=GetPageRecord('*','hoteloperationRestriction',' entranceId="'.$serviceId.'"  and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" ) ');
					$msgOpr = '';
					if(mysqli_num_rows($rs21) > 0){
						$oprResData=mysqli_fetch_array($rs21);
						$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
						?> 
						<div style="width: fit-content !important;" class="editbtnselect2" onclick="confirm('<?php echo strip($entranceName); ?> - Monument restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>');" id="selectthis<?php echo $dmcId; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
						<?php 
					} else { ?>
						<div style="width: fit-content !important;" class="editbtnselect2"  <?php if($currencyValue>0){ ?>  onclick="addentrancetoquotations('<?php echo $serviceId; ?>','<?php echo $dmcId; ?>','<?php echo $tableN; ?>','<?php echo $cityId; ?>','<?php echo $isClosed; ?>');" <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?> id="selectthis<?php echo $dmcId; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
					<?php  } ?> 
					</td>
					<td align="right">
						<div style=" padding: 8px 13px !important; width: 67px;color: #fff; background-color: #7a96ff; font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addeditentranceprice('addeditentranceprice','<?php echo $dmcId; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>
					</td>
					</tr>
					<?php 
				}
			}else{ 

				$whereQuotRateSql = ' 1 and serviceId="'.$serviceId.'" '.$sicQuery.'  '.$whereDate.' '.$whereSupp.' '.$whereNationalityType.'  and quotationId="'.$quotationId.'" order by id desc ';
				$whereQuotRateQuery=GetPageRecord('*','quotationEntranceRateMaster',$whereQuotRateSql);
				if(mysqli_num_rows($whereQuotRateQuery)>0){
					while($entQoutRateD = mysqli_fetch_assoc($whereQuotRateQuery)){

						$tableN = 2;
						$dmcId = $entQoutRateD['id'];
						if($entQoutRateD['transferType']!=2){
							$markupCostEnt = $entQoutRateD['markupCost'];
							$markupTypeEnt = $entQoutRateD['markupType'];
						}
						$ticketAdultCost = getCostWithGSTID_Markup($entQoutRateD['ticketAdultCost'],$entQoutRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
						$ticketchildCost = getCostWithGSTID_Markup($entQoutRateD['ticketchildCost'],$entQoutRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
						$ticketinfantCost = getCostWithGSTID_Markup($entQoutRateD['ticketinfantCost'],$entQoutRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
						$adultCost = getCostWithGSTID_Markup($entQoutRateD['adultCost'],$entQoutRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
						$childCost = getCostWithGSTID_Markup($entQoutRateD['childCost'],$entQoutRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
						$infantCost = getCostWithGSTID_Markup($entQoutRateD['infantCost'],$entQoutRateD['gstTax'],$markupCostEnt,$markupTypeEnt);
						$vehicleCost = getCostWithGSTID_Markup($entQoutRateD['vehicleCost'],$entQoutRateD['gstTax'],$entQoutRateD['markupCost'],$entQoutRateD['markupType']);
						$repCost = getCostWithGSTID_Markup($entQoutRateD['repCost'],$entQoutRateD['gstTax'],$entQoutRateD['markupCost'],$entQoutRateD['markupType']);
	 
						$currencyId = $entQoutRateD['currencyId'];
						$currencyValue = ($entQoutRateD['currencyValue']>0)?$entQoutRateD['currencyValue']:getCurrencyVal($currencyId);
						// $currencyValue = ($entQoutRateD['currencyValue']>0)?$entQoutRateD['currencyValue']:0;

						$rs2="";
						$rs2=GetPageRecord('*','vehicleTypeMaster',' 1 and id="'.$entQoutRateD['vehicleId'].'" '); 
						$vehicleData=mysqli_fetch_array($rs2);
						?>	
						<tr>
						<td align="left"> <?php echo clean($entranceName); ?></td> 
						<td align="left"><?php echo getsupplierCompany($entQoutRateD['supplierId']); ?> </td>
						<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
						<td align="right"><?php	echo !empty(($ticketAdultCost+$adultCost))?strip($ticketAdultCost+$adultCost):0; ?></td>
						<td align="right"><?php	echo !empty(($ticketchildCost+$childCost))?strip($ticketchildCost+$childCost):0; ?></td>
						<td align="right"><?php	echo !empty(($ticketinfantCost+$infantCost))?strip($ticketinfantCost+$infantCost):0; ?></td>
						<?php if($transferType == 2){  ?>
							<td align="left"><?php echo ucfirst($vehicleData['name']);?>(<?php echo $vehicleData['capacity'];?>)</td>
						<td align="right"><?php	echo !empty($vehicleCost)?strip($vehicleCost):0; ?></td>
						<td align="center"><input type="number" name="noOfVehicle<?php echo $dmcId; ?>" id="noOfVehicle<?php echo $dmcId; ?>" value="1" style="width: 55px;"></td>
							<!-- <td align="right"><?php	echo !empty($infantCost)?strip($infantCost):0; ?></td> -->
						<?php }else{ ?>
							<!-- <td align="left"><?php echo getVehicleTypeName($vehicleData['carType'])."(".ucfirst($vehicleData['model']).')';?></td> -->
							<!-- <td align="right"><?php	echo !empty($vehicleCost)?strip($vehicleCost):0; ?></td> -->
						<?php } ?>
						<!-- <td align="right"><?php	echo !empty($repCost)?strip($repCost):0; ?></td> -->
						<td align="right" valign="middle">
						<?php
						$rs21=GetPageRecord('*','hoteloperationRestriction',' entranceId="'.$serviceId.'"  and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" ) ');
						$msgOpr = '';
						if(mysqli_num_rows($rs21) > 0){
							$oprResData=mysqli_fetch_array($rs21);
							$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
							?> 
							<div style="width: fit-content !important;" class="editbtnselect2" onclick="confirm('<?php echo strip($entranceName); ?> - Monument restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>');" id="selectthis<?php echo $dmcId; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
							<?php 
						} else { ?>
							<div style="width: fit-content !important;" class="editbtnselect2"  <?php if($currencyValue>0){ ?>  onclick="addentrancetoquotations('<?php echo $serviceId; ?>','<?php echo $dmcId; ?>','<?php echo $tableN; ?>','<?php echo $cityId; ?>','<?php echo $isClosed; ?>');" <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?> id="selectthis<?php echo $dmcId; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
						<?php } ?> 
						</td>
						<td align="right">
							<div style=" padding: 8px 13px !important; width: 67px;color: #fff; background-color: #7a96ff;font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addeditentranceprice('addeditentranceprice','<?php echo $dmcId; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>
						</td>
						</tr>
						<?php  
					}
				}else{
					$tableN = 3;
					?>	
					<tr>
					<td align="left"> <?php echo clean($entranceName); ?></td> 
					<td align="left">NA</td>
					<td align="right">NA</td>
					<td align="right">0</td>
					<td align="right">0</td>
					<td align="right">0</td>
					<?php if($transferType == 2){  ?>
						<td align="left">NA</td>
						<td align="right">0</td>
						<td align="center"><input type="number" name="noOfVehicle<?php echo $dmcId; ?>" id="noOfVehicle<?php echo $dmcId; ?>" value="1" style="width: 55px;"></td>
						<!-- <td align="right">0</td> -->
						<!-- <td align="right">0</td> -->
					<?php } ?>
						<!-- <td align="left">NA</td> -->
						<!-- <td align="right">0</td> -->
					
					<!-- <td align="right">0</td> -->
					<td align="right" valign="middle" colspan="2">
					<?php
					$rs21=GetPageRecord('*','hoteloperationRestriction',' entranceId="'.$serviceId.'"  and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" ) ');
					$msgOpr = '';
					if(mysqli_num_rows($rs21) > 0){
						$oprResData=mysqli_fetch_array($rs21);
						$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
						?> 
						<div style="width: fit-content !important;" class="editbtnselect2" onclick="confirm('<?php echo strip($entranceName); ?> - Monument restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>');" id="selectthis<?php echo $dmcId; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
						<?php 
					} else { ?>
						<div style=" padding: 8px 13px !important; width: 67px;color: #fff; font-size: 13px;border-radius: 3px; cursor:pointer;background-color: #7a96ff;" onclick="addeditentranceprice('addeditentranceprice','<?php echo $serviceId; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>

					<?php  } ?> 
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
			$supname = getsupplierCompany($supplierId);
			?>	
			<tr>
			<td align="left"><?php echo clean($entranceName); ?></td> 
			<td align="left"><?php echo clean($supname); ?></td> 
			<td align="right" valign="middle" colspan="2">
			<?php
			$rs21=GetPageRecord('*','hoteloperationRestriction',' entranceId="'.$serviceId.'"  and ( "'.$fromDate.'" BETWEEN startDate and endDate or startDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" ) ');
			$msgOpr = '';
			if(mysqli_num_rows($rs21) > 0){
				$oprResData=mysqli_fetch_array($rs21);
				$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
				?> 
				<div style="width: fit-content !important;" class="editbtnselect2" onclick="confirm('<?php echo strip($entranceName); ?> - Monument restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>');" id="selectthis<?php echo $c1; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
				<?php 
			} else { ?>
				<div style="width: fit-content !important; width: 67px;color: #fff; " class="editbtnselect2" onclick="addentrancetoquotations('<?php echo $serviceId; ?>','<?php echo $c1; ?>','<?php echo $tableN; ?>','<?php echo $cityId; ?>','<?php echo $isClosed; ?>');" id="selectthis<?php echo $c1; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
			<?php  } ?> 
			</td>
			</tr>
			<?php 
		}
		$c1++; 
		$n++;
	}
	?>
	</tbody>
	</table>
	<script>
	function selectthis(ele){
		$(ele).html('Selected');
		$(ele).removeAttr('onclick');
		$(ele).css('background-color','orange');
	}
	</script>
</div>
<?php if($c1==1){ ?>
<script>
$('#sicbox').hide();
</script>
<?php } ?>

<?php if($c1==1 ){ ?>
<script>
$('#sicbox').append('<div style="text-align:center;">No Monument Found</div>');
</script>
<?php } ?>
</div>
<td> 

 <div style="text-align:end;">   
 	<!-- onClick="window.location.reload();" -->
 	<button style="cursor: pointer;font-weight: 700;padding: 5px 10px" onclick="closeinbound();">close</button>
 </div>

 </td>
<div id="loadprice" class="viewInfo" style="background-image: url('images/bgpop.png'); background-repeat: repeat;">
	<div class="pricepoup" style="margin-top: 70px;margin-bottom: 10px;"></div>
</div>
<!-- loadaddeditentranceprice.php -->
<script type="text/javascript">
	$('#entrancecounding').text('<?php echo $c1-1;?> Monument Found');
	function addeditentranceprice(action,rateId,tableN,poupwidth){
		$("#loadprice").show();
		$(".pricepoup").load('loadaddeditentranceprice.php?action='+action+'&rateid='+rateId+'&quotationId=<?php echo $quotationId; ?>&tableN='+tableN+'&dayId=<?php echo $dayId; ?>&transferType=<?php echo $_REQUEST['transferType']; ?>');
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
