<?php
include "inc.php";
$dayQuery='';
$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'" ');  
$dayData=mysqli_fetch_array($dayQuery);
$dayDate = $dayData['srdate'];
 
$checkQurey='';
$checkQurey=GetPageRecord('*',_QUERY_MASTER_,' id="'.$dayData['queryId'].'" ');  
$queryData=mysqli_fetch_array($checkQurey);

$quotQurey='';
$quotQurey=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$dayData['quotationId'].'" ');  
$quotationData=mysqli_fetch_array($quotQurey);

$calculationType = $quotationData['calculationType'];
  
if($_REQUEST['destWise'] == 2 && isset($_REQUEST['destWise'])){
	$cityId= $_REQUEST['departureFrom'];
}else{
	$cityId= $dayData['cityId'];
}  

$trainName = trim($_REQUEST['trainName']);
$defaultWise = trim($_REQUEST['defaultWise']);
$transferType = trim($_REQUEST['transferType']);
$destinationId = getDestination(trim($cityId));
//get dest name above

$queryId = $dayData['queryId'];
$quotationId = $dayData['quotationId'];
$dayId=$dayData['id'];

?>
<table cellpadding="3" cellspacing="0" border="0" class="">	
		<tr>
			<td width="20px">&nbsp;</td>
			<td width="85%">
				<span id="traincounding"> 0 Train Found </span>
			</td>
			<td width="200px" align="center">
				<div  class="addBtn" style=" padding: 6px 13px !important; width: 80px;color: #fff; font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="openinboundpop('action=addtraintomaster&dayId=<?php echo $dayId; ?>&cityId=<?php echo $cityId; ?>','800px');">+&nbsp;Add New</div>
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
	<table width="100%" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;border-color:#ccc;">
	<thead>
		<tr>
			<th width="20%" align="left">Train&nbsp;Name</th>
			<th width="16%" align="left">Supplier Name </th>
			<th width="6%" align="left">Train Number </th>
			<th width="6%" align="left">Train Class </th>
			<?php if($calculationType!=3){  ?>
			<th width="10%" align="right">Currency[ROE]</th>
			<th width="8%" align="right">Adult&nbsp;Cost</th>
			<th width="8%" align="right">Child&nbsp;Cost</th>
			<th width="8%" align="right">Infant&nbsp;Cost</th>
			<?php } ?>
 			<th width="20%" align="right" colspan="2" width="20%">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$c1=1;
	$where1=$rs1='';
	$where1=' trainName LIKE "%'.$trainName.'%"  and status=1  and deletestatus=0  order by trainName asc';
	$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,$where1);
	while($trainData=mysqli_fetch_array($rs1)){

		$serviceId=$trainData['id'];
		$trainName=$trainData['trainName']; 
 
		if($calculationType!=3){
 
			$rs221='';
			$rs221=GetPageRecord('*',_DMC_TRAIN_RATE_MASTER_,' status=1 and serviceid = "'.$serviceId.'" order by id asc'); 
			if(mysqli_num_rows($rs221)>0){
				while ($dmcRateD=mysqli_fetch_array($rs221)) {

					$rs221=GetPageRecord('*',_QUOTATION_TRAIN_RATE_MASTER_,'dmcId="'.$dmcRateD['id'].'" and quotationId="'.$quotationId.'"');  
					if(mysqli_num_rows($rs221)>0 ){
						$dmcRateD='';
						$dmcRateD=mysqli_fetch_array($rs221);

						$tableN = 2;
						$dmcId = $dmcRateD['id'];
					}else{
						$tableN = 1;
						$dmcId = $dmcRateD['id'];
					}
					$markupCostA =  getMarkupCost($dmcRateD['adultCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					$markupCostC =  getMarkupCost($dmcRateD['childCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
					$markupCostE =  getMarkupCost($dmcRateD['infantCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);

					$adultCost = getCostWithGST(($dmcRateD['adultCost']+$markupCostA),getGstValueById($dmcRateD['gstTax']),0);
					$childCost = getCostWithGST(($dmcRateD['childCost']+$markupCostC),getGstValueById($dmcRateD['gstTax']),0);
					$infantCost = getCostWithGST(($dmcRateD['infantCost']+$markupCostE),getGstValueById($dmcRateD['gstTax']),0);
					$baggageAllowance = getCostWithGST($dmcRateD['baggageAllowance'],getGstValueById($dmcRateD['gstTax']),0);
 
					$currencyId = $dmcRateD['currencyId'];
					// $currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:0;
					$currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:getCurrencyVal($currencyId);

					$rs2="";
					$rs2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,' 1 and id="'.$dmcRateD['vehicleId'].'" '); 
					$vehicleData=mysqli_fetch_array($rs2);
					?>	
					<tr>
						<td align="left"> <?php echo clean($trainName); ?></td> 
						<td align="left"><?php echo getsupplierCompany($dmcRateD['supplierId']); ?> </td>
						<td align="left"><?php echo ($dmcRateD['trainNumber']!='')?$dmcRateD['trainNumber']:'NA'; ?> </td>
						<td align="left"><?php echo ($dmcRateD['trainClass']!='')?$dmcRateD['trainClass']:'NA'; ?> </td>
						<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
						<td align="right"><?php	echo !empty($adultCost) ? strip($adultCost) : '0'; ?></td>
						<td align="right"><?php	echo !empty($childCost)?strip($childCost):0; ?></td>
						<td align="right"><?php	echo !empty($infantCost)?strip($infantCost):0; ?></td>
						<td align="right" valign="middle">
							<div style="width: fit-content !important;" class="editbtnselect2"  <?php if($currencyValue>0){ ?>  onclick="addtraintoquotations('<?php echo $serviceId; ?>','<?php echo $dmcId; ?>','<?php echo $tableN; ?>','<?php echo $cityId; ?>');" <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?> id="selectthis<?php echo $dmcId; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
						</td>
						<td align="right">
							<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff; font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addedittrainprice('addedittrainprice','<?php echo $dmcId; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>
						</td>
					</tr>
					<?php 
				}
			}else{ 

				$whereQuotRateSql = ' 1 and serviceId="'.$serviceId.'" and quotationId="'.$quotationId.'" order by id desc ';
				$whereQuotRateQuery=GetPageRecord('*',_QUOTATION_TRAIN_RATE_MASTER_,$whereQuotRateSql);
				if(mysqli_num_rows($whereQuotRateQuery)>0){
					while($entQoutRateD = mysqli_fetch_assoc($whereQuotRateQuery)){

						$tableN = 2;
						$dmcId = $entQoutRateD['id'];
						$markupCostA =  getMarkupCost($entQoutRateD['adultCost'],$entQoutRateD['markupCost'],$entQoutRateD['markupType']);
						$markupCostC =  getMarkupCost($entQoutRateD['childCost'],$entQoutRateD['markupCost'],$entQoutRateD['markupType']);
						$markupCostE =  getMarkupCost($entQoutRateD['infantCost'],$entQoutRateD['markupCost'],$entQoutRateD['markupType']);

						$adultCost = getCostWithGST(($entQoutRateD['adultCost']+$markupCostA),getGstValueById($entQoutRateD['gstTax']),0);
						$childCost = getCostWithGST(($entQoutRateD['childCost']+$markupCostC),getGstValueById($entQoutRateD['gstTax']),0);
						$infantCost = getCostWithGST(($entQoutRateD['infantCost']+$markupCostE),getGstValueById($entQoutRateD['gstTax']),0);
						$baggageAllowance = getCostWithGST($entQoutRateD['baggageAllowance'],getGstValueById($entQoutRateD['gstTax']),0);
	 
						$currencyId = $entQoutRateD['currencyId'];
						// $currencyValue = ($entQoutRateD['currencyValue']>0)?$entQoutRateD['currencyValue']:0;
						$currencyValue = ($entQoutRateD['currencyValue']>0)?$entQoutRateD['currencyValue']:getCurrencyVal($currencyId);

						$rs2="";
						$rs2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,' 1 and id="'.$entQoutRateD['vehicleId'].'" '); 
						$vehicleData=mysqli_fetch_array($rs2);
						?>	
						<tr>
							<td align="left"> <?php echo clean($trainName); ?></td> 
							<td align="left"><?php echo getsupplierCompany($entQoutRateD['supplierId']); ?> </td>
							<td align="left"><?php echo ($entQoutRateD['trainNumber']!='')?$entQoutRateD['trainNumber']:'NA'; ?> </td>
							<td align="left"><?php echo ($entQoutRateD['trainClass']!='')?$entQoutRateD['trainClass']:'NA'; ?> </td>
							<td align="right"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
							<td align="right"><?php	echo !empty($adultCost)?strip($adultCost):0; ?></td>
							<td align="right"><?php	echo !empty($childCost)?strip($childCost):0; ?></td>
							<td align="right"><?php	echo !empty($infantCost)?strip($infantCost):0; ?></td>
							<td align="right" valign="middle">
								<div style="width: fit-content !important;" class="editbtnselect2"  <?php if($currencyValue>0){ ?>  onclick="addtraintoquotations('<?php echo $serviceId; ?>','<?php echo $dmcId; ?>','<?php echo $tableN; ?>','<?php echo $cityId; ?>');" <?php }else{ ?> onclick="alert('Currency ROE is mendatory!')" <?php } ?> id="selectthis<?php echo $dmcId; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
							
							</td>
							<td align="right">
								<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff; font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addedittrainprice('addedittrainprice','<?php echo $dmcId; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>
							</td>
						</tr>
						<?php  
					}
				}else{
					$tableN = 3;
					?>	
					<tr>
						<td align="left"> <?php echo clean($trainName); ?></td> 
						<td align="left">NA</td>
						<td align="left">NA</td>
						<td align="left">NA</td>
						<td align="right">NA</td>
						<td align="right">NA</td>
						<td align="right">0</td>
						<td align="right">0</td>
						<td align="right" valign="middle" colspan="2">
							<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff; font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addedittrainprice('addedittrainprice','<?php echo $serviceId; ?>','<?php echo $tableN ; ?>','700px');"> + Edit Price</div>
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
			    $currencyVal = getCurrencyVal($currencyId);
			    $supplierId = $getPackageRateData['supplierId'];
			}
			$supname = getsupplierCompany($supplierId);
			?>	
			<tr>
			<td align="left"><?php echo clean($trainName); ?></td> 
			<td align="left"><?php echo clean($supname); ?></td> 
			<td align="left"></td> 
			<td align="left"></td> 
			<td align="left"></td> 
			<td align="right" valign="middle" colspan="2">
				<div style="width: fit-content !important; width: 67px;color: #fff; " class="editbtnselect2" onclick="addtraintoquotations('<?php echo $serviceId; ?>','<?php echo $c1; ?>','<?php echo $tableN; ?>','<?php echo $cityId; ?>');" id="selectthis<?php echo $c1; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
			 
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
$('#sicbox').append('<div style="text-align:center;">No Train Found</div>');
</script>
<?php } ?>
</div>
<td> 
<br>
<br>
<br> 
 </td>
<div id="loadprice" class="viewInfo" style="background-image: url('images/bgpop.png'); background-repeat: repeat;margin-top: 55px;">
	<div class="pricepoup"></div>
</div>
<!-- loadaddedittrainprice.php -->
<script type="text/javascript">
	$('#traincounding').text('<?php echo $c1-1;?> Train Found');
	function addedittrainprice(action,rateId,tableN,poupwidth){
		$("#loadprice").show();
		$(".pricepoup").load('loadaddedittrainprice.php?action='+action+'&rateid='+rateId+'&quotationId=<?php echo $quotationId; ?>&tableN='+tableN+'&dayId=<?php echo $dayId; ?>');
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
	max-width: 700px;
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
