<?php
include "inc.php";   
$dmc_tariffId = $_REQUEST['tariffId'];
$tableN = $_REQUEST['tableN'];
$quotationId = $_REQUEST['quotationId']; 
 
$rsa2s=GetPageRecord('*','quotationTransferRateMaster','id="'.$dmc_tariffId.'" and quotationId="'.$quotationId.'"');  
if(mysqli_num_rows($rsa2s)< 1 && $tableN == 1){

	$rs=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$dmc_tariffId.'"'); 
	$dmcTransfer=mysqli_fetch_array($rs);  
	 
	$rs2=GetPageRecord('transferCategory',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$dmcTransfer['transferNameId'].'"'); 
	$transferData1=mysqli_fetch_array($rs2); 

	$namevalue ='tariffId="'.$dmcTransfer['id'].'",fromDate="'.$dmcTransfer['fromDate'].'",toDate="'.$dmcTransfer['toDate'].'",transferType="'.$dmcTransfer['transferType'].'",transferFromId="'.$dmcTransfer['transferFromId'].'",transferToId="'.$dmcTransfer['transferToId'].'",transferNameId="'.$dmcTransfer['transferNameId'].'",adultCost="'.$dmcTransfer['adultCost'].'",childCost="'.$dmcTransfer['childCost'].'",infantCost="'.$dmcTransfer['infantCost'].'",detail="'.$dmcTransfer['detail'].'",vehicleTypeId="'.$dmcTransfer['vehicleTypeId'].'",vehicleModelId="'.$dmcTransfer['vehicleModelId'].'",vehicleCost="'.$dmcTransfer['vehicleCost'].'",currencyId="'.$dmcTransfer['currencyId'].'",status="'.$dmcTransfer['status'].'",supplierId="'.$dmcTransfer['supplierId'].'",serviceid="'.$dmcTransfer['serviceid'].'",parkingFee="'.$dmcTransfer['parkingFee'].'",representativeEntryFee="'.$dmcTransfer['representativeEntryFee'].'",assistance="'.$dmcTransfer['assistance'].'",guideAllowance="'.$dmcTransfer['guideAllowance'].'",interStateAndToll="'.$dmcTransfer['interStateAndToll'].'",miscellaneous="'.$dmcTransfer['miscellaneous'].'",capacity="'.$dmcTransfer['capacity'].'",gstTax="'.$dmcTransfer['gstTax'].'",quotationId="'.$quotationId.'",transferCostType="'.$dmcTransfer['transferCostType'].'",serviceType="'.$transferData1['transferCategory'].'"'; 
	$lastid = addlistinggetlastid('quotationTransferRateMaster',$namevalue);
	$where='id="'.$lastid.'"';
}else{
	$where='id="'.$dmc_tariffId.'"';
}

$rsa2s=GetPageRecord('*','quotationTransferRateMaster',$where); 
$dmcroommastermain=mysqli_fetch_array($rsa2s);
 

$rsa2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$dmcroommastermain['currencyId'].'"'); 
$editresult2=mysqli_fetch_array($rsa2); 
$cur=clean($editresult2['name']);

$rs2=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$dmcroommastermain['transferNameId'].'"'); 
$editresult2=mysqli_fetch_array($rs2);  
?>  
<style>
.topaboxlist .griddiv .gridfield {
	<?php if($dmcroommastermain['transferType']==2){ ?>
	max-width: 60px;
	<?php } ?>
	text-align: center;
	padding: 5px;
	border-radius: 3px;
	border: 1px solid;
	display: inline-block;
}
</style>
<div class="topaboxlist"  style="background-color: #ffffff; border-radius: 3px; padding: 3px; box-shadow: 0px 10px 35px;"> 
<div class="inboundheader">
  <strong style="font-size: 18px;"><?php echo ucfirst(clean($editresult2['transferName'])); ?> - Price <?php echo $cur; ?></strong><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#viewinfo').hide();"></i>
</div>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm"  id="addhotelroomprice">
 <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#DDD" class="tablesorter gridtable" style="margin-top:0px; margin-bottom:20px;">
   <thead>
   <tr>
		<th align="center" bgcolor="#DDD" ><strong>GST</strong></th>
		<?php if($dmcroommastermain['transferType']==1){ ?>
		<th align="center" bgcolor="#DDD" ><strong>Adult Cost</strong></th>
		<th align="center" bgcolor="#DDD" ><strong>Child Cost</strong></th>
		<th align="center" bgcolor="#DDD" ><strong>Infant Cost</strong></th>
		<?php }else{ ?>
		<th align="center" bgcolor="#DDD" ><strong>Vehicle Cost</strong></th>
		<th align="center" bgcolor="#DDD" ><strong>Parking</strong></th>
		<th align="center" bgcolor="#DDD"><strong>Assistance</strong></th>
		<th align="center" bgcolor="#DDD"><strong>Ad. Allowance</strong></th>
		<th align="center" bgcolor="#DDD"><strong>Inter State &amp; Toll</strong></th>
		<th align="center" bgcolor="#DDD"><strong>Miscellaneous</strong></th>
		<th align="center" bgcolor="#DDD"><strong>Capacity</strong></th> 
		<?php } ?>
		<th align="center" bgcolor="#DDD"><strong>Rep. Fee</strong></th> 
    </tr>
   </thead> 
  <tbody> 
  <tr>
		<td align="center"><div class="griddiv">
		<label>  
		<select id="gstTax" name="gstTax" class="gridfield" displayname="GST Tax" autocomplete="off" style="width: 100px !important; padding: 5px; border-radius: 3px;"> 
		<?php 
		$rs2="";
		$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Transfer" and status=1 order by gstValue asc'); 
		while($gstSlabData=mysqli_fetch_array($rs2)){
		?>
		<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id'] == $dmcroommastermain['gstTax']){ ?> selected="selected" <?php } ?>><?php echo $gstSlabData['gstSlabName'];?></option>
		<?php
		}	
		?> 
		</select>
		</label>
		</div></td>
		<?php if($dmcroommastermain['transferType']==1){ ?>
			<td align="center"><div class="griddiv"><label> 
		<input name="adultCost" type="text" class="gridfield numeric"  id="adultCost" maxlength="12"  value="<?php echo strip($dmcroommastermain['adultCost']); ?>" />
		</label>
		</div></td> 
		<td align="center"><div class="griddiv"><label> 
		<input name="childCost" type="text" class="gridfield numeric"  id="childCost" maxlength="12"  value="<?php echo strip($dmcroommastermain['childCost']); ?>" />
		</label>
		</div></td> 
		<td align="center"><div class="griddiv"><label> 
		<input name="infantCost" type="text" class="gridfield numeric"  id="infantCost" maxlength="12"  value="<?php echo strip($dmcroommastermain['infantCost']); ?>" />
		</label>
		</div></td> 
		<?php }else{ ?>
		<td align="center"><div class="griddiv"><label> 
		<input name="vehicleCost" type="text" class="gridfield numeric"  id="vehicleCost" maxlength="12"  value="<?php echo strip($dmcroommastermain['vehicleCost']); ?>" />
		</label>
		</div></td> 
		<td align="center"><div class="griddiv"><label> 
		<input name="parkingFee" type="text" class="gridfield numeric"  id="parkingFee" maxlength="12" style="width: 60px !important;" value="<?php echo strip($dmcroommastermain['parkingFee']); ?>" />
		</label>
		</div></td> 
		<td align="center"> <div class="griddiv"><label> 
		<input name="assistance" type="text" class="gridfield numeric"  id="assistance" maxlength="12" value="<?php echo strip($dmcroommastermain['assistance']); ?>" />
		</label>
		</div></td>
		<td align="center"> <div class="griddiv"><label> 
		<input name="guideAllowance" type="text" class="gridfield numeric"  id="guideAllowance" maxlength="12"  value="<?php echo strip($dmcroommastermain['guideAllowance']); ?>" />
		</label>
		</div></td>
		<td align="center">
			<div class="griddiv"><label> 
			<input name="interStateAndToll" type="text" class="gridfield numeric"  id="interStateAndToll" maxlength="12"  value="<?php echo strip($dmcroommastermain['interStateAndToll']); ?>" />
			</label>
			</div>
		</td>
		<td align="center"> 
			<div class="griddiv"><label> 
			<input name="miscellaneous" type="text" class="gridfield numeric"  id="miscellaneous" maxlength="12" value="<?php echo strip($dmcroommastermain['miscellaneous']); ?>" />
			</label>
			</div>
		</td>
		<td align="center"> 
			<div class="griddiv"><label> 
			<input name="capacity" type="text" class="gridfield numeric"  id="capacity" maxlength="5" value="<?php echo strip($dmcroommastermain['capacity']); ?>" />
			</label>
			</div>
		</td>  
		<?php } ?>
			<td align="center"> <div class="griddiv"><label> 
				<input name="representativeEntryFee" type="text" class="gridfield numeric"  id="representativeEntryFee" maxlength="12" value="<?php echo strip($dmcroommastermain['representativeEntryFee']); ?>" />
				</label>
				</div>
			</td>
    </tr>  
	<tr>
	<td><strong>Remarks</strong></td>
	<td colspan="7"><?php echo strip(stripslashes($dmcroommastermain['remark'])); ?></td>
	</tr> 
</tbody></table> 
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="right" valign="middle"><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important; background-color: #84bed9!important; border-bottom:0px;"></td>
  </tr>
</table>
<input name="action" type="hidden" id="action" value="transportationSaveCost">
<input name="transferRateId" type="hidden" id="transferRateId" value="<?php echo encode($dmcroommastermain['id']); ?>">
</form>
</div>
 
 <script>
 $(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/\D/g,'');
}); 
 </script>