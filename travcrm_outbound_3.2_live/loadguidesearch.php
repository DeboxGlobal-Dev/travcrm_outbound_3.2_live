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


$guideQuoteId = $_REQUEST['guideQuoteId'];
$isSupplement = $_REQUEST['isSupplement'];

$serviceType = $_REQUEST['serviceType'];
$defaultWise = trim($_REQUEST['defaultWise']);

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

if($_REQUEST['paxRange'] != '' && isset($_REQUEST['serviceType'])){
	$paxRangequery = ' and paxRange = "'.$_REQUEST['paxRange'].'"';
}else{
	$paxRangequery = ' ';
}

if($serviceType !='' ){
	$guideIdquery = ' and serviceType = "'.$serviceType.'"';
}else{
	$guideIdquery = ' ';
}

$isDefault = '';
if($defaultWise == 1){
	$isDefault = ' and isDefault=1';
}
 
$whereDateQuery = '';
if($guideQuoteId>0 && $isSupplement==1){
	$rs12=GetPageRecord(' * ',_QUOTATION_GUIDE_MASTER_,'id="'.$guideQuoteId.'"'); 
	$guideQuoteData = mysqli_fetch_array($rs12); 

	$tariffId = $guideQuoteData['tariffId'];
	$whereDateQuery .= ' and id!="'.$tariffId.'" ';
}
// $whereDateQuery .= ' and fromDate<="'.$fromDate.'" and toDate>="'.$toDate.'" ';
$whereDateQuery .= ' and "'.$fromDate.'" BETWEEN fromDate and toDate ';
$whereGuideDestQuery = "";
$whereGuideDestQuery = " and (destinationId = '".$destinationId."' or destinationId=0) ";

$guideKeyword = $_REQUEST['guideKeyword'];
$guideNameFilter='';
if($guideKeyword!=''){
	$guideNameFilter = 'and name LIKE "%'.$_REQUEST['guideKeyword'].'%"';
}

?>
<table cellpadding="3" cellspacing="0" border="0" class="">	
	<tr>
		<td width="20px">&nbsp;</td>
		<td width="85%">
		</td>
		<td width="200px" align="center">
			<div class="addBtn"  style=" padding: 8px 13px !important width: 50px;color: #fff; font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="openinboundpop('action=addguidetomaster&dayId=<?php echo $dayId; ?>&cityId=<?php echo $cityId; ?>','800px');">+&nbsp;Add New</div>
			
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
		</td>
	</tr>
</table>
<div style="padding:10px; border:1px #e3e3e3 solid; background-color: #fff; margin-bottom:10px;" id="sicbox">
<div class="topaboxlist"  style="max-height: 300px; overflow: auto;">
	<div id="loadguideprice" class="viewInfo" style="background-image: url('images/bgpop.png'); background-repeat: repeat;margin-top: 55px;"><div class="guidepricepoup"></div>
	</div>
	<?php
	// echo ' 1 and status=1 and deletestatus=0 '.$whereGuideDestQuery.' '.$guideIdquery.' '.$isDefault.'';
	$whereServQuery = '';
	$whereServQuery=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' 1 and status=1 and deletestatus=0 '.$whereGuideDestQuery.' '.$guideIdquery.' '.$isDefault.' '.$guideNameFilter.' order by name ASC');
	$totalguideR = mysqli_num_rows($whereServQuery);
	if($totalguideR > 0 ){
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable"  id="guidesicTable">
		<thead>
			<tr>
				<th align="left" style="width: 20%;"><?php if($_REQUEST['serviceType'] == 1){ echo "Porter"; }else{ echo "Guide"; } ?>&nbsp;Service</th>
				<th width="10%" align="left" >Day Type</th>
				<?php if($_REQUEST['serviceType'] == 0){ ?>
				<th width="10%" align="left" >Pax&nbsp;Range</th>
				<?php } ?>
				<th width="10%" align="left" >Pax&nbsp;Slab</th>
				<?php if($calculationType!=3){ ?>
				<th width="10%" align="right" >Guide&nbsp;Cost</th>
				<th width="10%" align="right" >L.&nbsp;Allowance</th>
				<th width="10%" align="right" >Other&nbsp;Cost</th>
				<?php } ?>
				<th width="5%" align="left" colspan="2" >&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$c1 = 1;
		while($dmcguideData=mysqli_fetch_array($whereServQuery) ){
			if($calculationType!=3){
				$whereMainQuery=' supplierId in ( select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and guideType=2 ) and serviceid="'.$dmcguideData['id'].'" '.$whereDateQuery.' '.$paxRangequery.' and status=1 order by id desc ';
				$mainRateQuery=GetPageRecord('*','dmcGuidePorterRate',$whereMainQuery);
				if(mysqli_num_rows($mainRateQuery)>0){
					while($dmcroommastermain = mysqli_fetch_assoc($mainRateQuery)){
						// $editprice = 1;
						$rsa2s=GetPageRecord('*','quotationGuideRateMaster','guiderateId="'.$dmcroommastermain['id'].'" and quotationId="'.$quotationId.'"');  
						if(mysqli_num_rows($rsa2s)>0 ){
							
							$dmcroommastermain='';
							$dmcroommastermain=mysqli_fetch_array($rsa2s);
							$tableN = 2;
							$gstValue=getGstValueById($dmcroommastermain['guideGST']); 

							$guideCost = $langAlloCost = $otherCost = 0;

							$guideCost = strip($dmcroommastermain['price']);
							$langAlloCost = strip($dmcroommastermain['languageAllowance']);
							$otherCost = strip($dmcroommastermain['otherCost']);
							
							$guideMarkup =  getMarkupCost($guideCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
							$langMarkup =  getMarkupCost($langAlloCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
							$otherMarkup =  getMarkupCost($otherCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

							$guideCost = $guideCost+$guideMarkup;
							$langAlloCost = $langAlloCost+$langMarkup;
							$otherCost = $otherCost+$otherMarkup;

							$guideCost= round(($guideCost*$gstValue/100)+($guideCost)); 
							$langAlloCost= round(($langAlloCost*$gstValue/100)+($langAlloCost)); 
							$otherCost= round(($otherCost*$gstValue/100)+($otherCost)); 
						
							if(trim($dmcroommastermain['dayType']) == 'halfday'){
								$dayType = "Half Day";
							}else{
								$dayType = "Full Day";
							}
							$paxRange = $dmcroommastermain['paxRange'];
							$guiderateId = $dmcroommastermain['guiderateId'];
							$quotationrateid = $dmcroommastermain['id'];


						}else{
							$tableN = 1;
							$gstValue=getGstValueById($dmcroommastermain['guideGST']); 

							$guideCost = $langAlloCost = $otherCost = 0;

							$guideCost = strip($dmcroommastermain['price']);
							$langAlloCost = strip($dmcroommastermain['languageAllowance']);
							$otherCost = strip($dmcroommastermain['otherCost']);
							 
							$guideMarkup =  getMarkupCost($guideCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
							$langMarkup =  getMarkupCost($langAlloCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
							$otherMarkup =  getMarkupCost($otherCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

							$guideCost = $guideCost+$guideMarkup;
							$langAlloCost = $langAlloCost+$langMarkup;
							$otherCost = $otherCost+$otherMarkup;

							$guideCost= round(($guideCost*$gstValue/100)+($guideCost)); 
							$langAlloCost= round(($langAlloCost*$gstValue/100)+($langAlloCost)); 
							$otherCost= round(($otherCost*$gstValue/100)+($otherCost)); 



							if(trim($dmcroommastermain['dayType']) == 'halfday'){
								$dayType = "Half Day";
							}else{
								$dayType = "Full Day";
							}
							$paxRange = $dmcroommastermain['paxRange'];
							$guiderateId = $dmcroommastermain['id'];
							$serviceid = $dmcroommastermain['serviceid'];
						
						}
						$aaaaaa='';
						$aaaaaa=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$dmcroommastermain['serviceid'].'"');
						$subCatData=mysqli_fetch_array($aaaaaa);
						?>
						<tr>
							<td align="left"><?php   echo clean($subCatData['name']);  ?></td>
							<td align="left"><?php   echo ($dayType);  ?></td>
							<?php if($_REQUEST['serviceType'] == 0){ ?>
							<td align="left"><?php if($paxRange == 0){ echo 'All'; }else{ echo str_replace('_',' to ',$paxRange); } ?></td>
							<?php } ?>
							<td align="left">
								<select name="slabId3<?php echo $dmcroommastermain['id']; ?>" id="slabId3<?php echo $dmcroommastermain['id']; ?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
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
							<td align="right"><?php   echo getCurrencyName($dmcroommastermain['currencyId']).' '.clean($guideCost);  ?></td>
							<td align="right"><?php   echo getCurrencyName($dmcroommastermain['currencyId']).' '.clean($langAlloCost);  ?></td>
							<td align="right"><?php   echo getCurrencyName($dmcroommastermain['currencyId']).' '.clean($otherCost);  ?></td>

							<td align="center">
							<?php 
							if($dmcroommastermain['price']>0){ ?>
								<div  id="selectBtnE<?php echo $dmcroommastermain['id']; ?><?php echo $tableN ; ?>" class="editbtnselect fa fa-hand-pointer-o"		onclick="addguidetoquotations('<?php echo $dmcroommastermain['id']; ?>','<?php echo $dayId; ?>','<?php echo $destinationId; ?>','<?php echo $totalDays; ?>','<?php echo $tableN ; ?>');">&nbsp;Select</div>

								<?php 
							} 
							?>
							</td>
							<td> 
								<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff;font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addeditguideprice('addeditguideprice','<?php echo $guiderateId ; ?>','<?php echo $quotationrateid; ?>','<?php echo $_REQUEST['queryId']; ?>','<?php echo $tableN ; ?>','1000px');"> + Edit Price</div>
							</td>
						</tr>
						<?php
					} 
				}else{ 

					$whereQuotRateSql=' supplierId in ( select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and guideType=2 ) and serviceid="'.$dmcguideData['id'].'" '.$whereDateQuery.' '.$paxRangequery.' and status=1 order by id desc ';
					$whereQuotRateQuery=GetPageRecord('*','quotationGuideRateMaster',$whereQuotRateSql);
					if(mysqli_num_rows($whereQuotRateQuery)>0){
						while($guideQoutationRateD = mysqli_fetch_assoc($whereQuotRateQuery)){
							$tableN = 2;
							$gstValue=getGstValueById($guideQoutationRateD['guideGST']); 

							$guideCost = $langAlloCost = $otherCost = 0;

							$guideCost = strip($guideQoutationRateD['price']);
							$langAlloCost = strip($guideQoutationRateD['languageAllowance']);
							$otherCost = strip($guideQoutationRateD['otherCost']);
							 
							$guideMarkup =  getMarkupCost($guideCost,$guideQoutationRateD['markupCost'],$guideQoutationRateD['markupType']);
							$langMarkup =  getMarkupCost($langAlloCost,$guideQoutationRateD['markupCost'],$guideQoutationRateD['markupType']);
							$otherMarkup =  getMarkupCost($otherCost,$guideQoutationRateD['markupCost'],$guideQoutationRateD['markupType']);
							$guideCost = $guideCost+$guideMarkup;
							$langAlloCost = $langAlloCost+$langMarkup;
							$otherCost = $otherCost+$otherMarkup;

							$guideCost= round(($guideCost*$gstValue/100)+($guideCost)); 
							$langAlloCost= round(($langAlloCost*$gstValue/100)+($langAlloCost)); 
							$otherCost= round(($otherCost*$gstValue/100)+($otherCost)); 

							if(trim($guideQoutationRateD['dayType']) == 'halfday'){
								$dayType = "Half Day";
							}else{
								$dayType = "Full Day";
							} 
							?>
							<tr>
								<td align="left"><?php echo clean($dmcguideData['name']);  ?></td>
								<td align="left"><?php echo ($dayType);  ?></td>
								<?php if($_REQUEST['serviceType'] == 0){ ?>
								<td align="left"><?php if($guideQoutationRateD['paxRange'] == 0){ echo 'All'; }else{ echo str_replace('_',' to ',$guideQoutationRateD['paxRange']); } ?></td>
								<?php } ?>
								<td align="left">
									<select name="slabId3<?php echo $guideQoutationRateD['id']; ?>" id="slabId3<?php echo $guideQoutationRateD['id']; ?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
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

								<td align="right"><?php   echo getCurrencyName($guideQoutationRateD['currencyId']).' '.clean($guideCost);  ?></td>
								<td align="right"><?php   echo getCurrencyName($guideQoutationRateD['currencyId']).' '.clean($langAlloCost);  ?></td>
								<td align="right"><?php   echo getCurrencyName($guideQoutationRateD['currencyId']).' '.clean($otherCost);  ?></td>

								<td align="center">
									<?php if($guideQoutationRateD['price']>0){ ?>
										<div  id="selectBtnE<?php echo $guideQoutationRateD['id']; ?><?php echo $tableN ; ?>" class="editbtnselect fa fa-hand-pointer-o" onclick="addguidetoquotations('<?php echo $guideQoutationRateD['id']; ?>','<?php echo $dayId; ?>','<?php echo $destinationId; ?>','<?php echo $totalDays; ?>','<?php echo $tableN ; ?>');">&nbsp;Select</div>
									<?php } ?>
								</td>
								<td> 
									<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff;font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addeditguideprice('addeditguideprice','<?php echo $guideQoutationRateD['guiderateId']; ?>','<?php echo $guideQoutationRateD['id']; ?>','<?php echo $_REQUEST['queryId']; ?>','<?php echo $tableN ; ?>','1000px');"> + Edit Price</div>
								</td>
							</tr>
							<?php  
						}
					}else{ 

						$tableN = 3;
						?>
						<tr>
							<td align="left"><?php echo clean($dmcguideData['name']);  ?></td>
							<td align="left">NA</td>
							<?php if($_REQUEST['serviceType'] == 0){ ?>
							<td align="left">All</td>
							<?php } ?>
							<td align="left">
								<select name="slabId3" id="slabId3" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
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
							<td align="right">0</td>
							<td align="right">0</td>
							<td align="right">0</td> 
							<td align="center"></td>
							<td> 
								<div style=" padding: 8px 13px !important; background-color:#589fa6; width: 67px;color: #fff;font-size: 13px;border-radius: 3px; cursor:pointer;" onclick="addeditguideprice('addeditguideprice','<?php echo $dmcguideData['id']; ?>','<?php echo $dmcguideData['id']; ?>','<?php echo $_REQUEST['queryId']; ?>','<?php echo $tableN ; ?>','1000px');" > + Edit Price</div>
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

				$dayType = "Full Day";
 
				?>
				<tr>
					<td align="left"><?php echo clean($dmcguideData['name']);  ?></td>
					<td align="left"><?php echo ($dayType);  ?></td>
					<?php if($_REQUEST['serviceType'] == 0){ ?>
					<td align="left">All</td>
					<?php } ?>
					<td align="left">
						<select name="slabId3<?php echo $dmcguideData['id']; ?>" id="slabId3<?php echo $dmcguideData['id']; ?>" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
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
					<?php if($calculationType!=3){ ?>
					<td align="right">0</td>
					<td align="right">0</td>
					<td align="right">0</td>
					<?php } ?>
					<td align="center">
						<div  id="selectBtnE<?php echo $dmcguideData['id']; ?><?php echo $tableN ; ?>" class="editbtnselect fa fa-hand-pointer-o" onclick="addguidetoquotations('<?php echo $dmcguideData['id']; ?>','<?php echo $dayId; ?>','<?php echo $destinationId; ?>','<?php echo $totalDays; ?>','<?php echo $tableN ; ?>');">&nbsp;Select</div>
					</td> 
				</tr>
				<?php 
			}
			$c1++;
		} ?>
		</tbody>
	</table> 
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
<!-- loadaddeditguideprice.php -->

<script>
 	function addeditguideprice(action,rateId,quotationrateid,queryId,tableN,poupwidth){
		$("#loadguideprice").show();
		$(".guidepricepoup").load('loadaddeditguideprice.php?action='+action+'&rateid='+rateId+'&quoterateId='+quotationrateid+'&queryId='+queryId+'&tableN='+tableN+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
		$('.guidepricepoup').css('width', poupwidth);


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
 
#loadguideprice {
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
#loadguideprice .guidepricepoup {
background-color: #FFFFFF;
max-width: 1000px;
margin: auto;
margin-top: 20px;
}
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
width: 100% !important;
}
	 
</style>
