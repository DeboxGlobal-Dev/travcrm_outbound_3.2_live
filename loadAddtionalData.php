<?php
include "inc.php"; 
if($_REQUEST['action']=="additionalExperiences" && $_REQUEST['quotationId']!=''){
$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$_REQUEST['quotationId'].'" group by serviceType order by id asc'); 
if( mysqli_num_rows($c12) > 0){ ?>
<table width="50%" border="1" cellpadding="3" cellspacing="0" style="margin-left: 6px;" >
<tr>
 <td align="left"><strong>Service&nbsp;Type </strong></td>
<td align="left"><strong>Name</strong></td>
<td align="center"><strong>AdultCost(PP)</strong></td>
<td align="center"><strong>ChildCost(PC)</strong></td>
<td align="center"><strong>infantCost(PC)</strong></td>
<td  align="center"><strong>Action</strong></td>
</tr>
<?php
while($additionalIdData=mysqli_fetch_array($c12)){	

	if($additionalIdData['serviceType']=='Activity'){
	
	$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$_REQUEST['quotationId'].'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
	while($activityData=mysqli_fetch_array($rsAct)){	
	$c121=GetPageRecord('*','packageBuilderotherActivityMaster',' id in ( select otherActivityNameId from dmcotherActivityRate where id="'.$activityData['additionalId'].'" ) order by id asc'); 
	$activityDataName=mysqli_fetch_array($c121);
	?>
	<tr id="addnl<?php echo $activityData['id'];?>">
	 <td width="99" align="left"><?php echo $activityData['serviceType'];?></td>
	<td align="left"><?php echo ucwords($activityDataName['otherActivityName']); ?></td>
	<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$activityData['adultCost'];?></td> 
	<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$activityData['adultCost'];?></td>
	<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$activityData['adultCost'];?></td>
	<td align="center"><div><span style="color: #60ba3b;cursor: pointer; margin: 0px 5px;" onclick="openinboundpop('action=editSupplimentService&id=<?php echo $activityData['id'];?>','600px');" ><i class="fa fa-pencil" aria-hidden="true"></i></span>&nbsp;<span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure you want delete this transfer?')) {
		deleteAdditionalExperience('<?php echo $activityData['id'];?>','deleteAdditionalExperience');
		$('#addnl<?php echo $activityData['id'];?>').remove();
		}" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
	</tr>
	<?php 
	}
	}
	
	
	if($additionalIdData['serviceType']=='Guide'){
	
	$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$_REQUEST['quotationId'].'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
	while($guideData=mysqli_fetch_array($rsAct)){	
	$c121=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id in (select serviceid from dmcGuidePorterRate where id="'.$guideData['serviceId'].'") order by id asc'); 
	$guideDataName=mysqli_fetch_array($c121);
	?>
	<tr id="addnl<?php echo $guideData['id'];?>">
	 <td align="left"><?php echo $guideData['serviceType'];?></td>
	<td align="left"><?php echo ucwords($guideDataName['name']);?> </td>
	<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$guideData['adultCost'];?></td> 
	<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$guideData['adultCost'];?></td>  
	<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$guideData['adultCost'];?></td>  
	<td align="center"><div><span style="color: #60ba3b; cursor: pointer; margin: 0px 5px;" onclick="openinboundpop('action=editSupplimentService&id=<?php echo $guideData['id'];?>','600px');" ><i class="fa fa-pencil" aria-hidden="true"></i></span>&nbsp;<span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure you want delete this transfer?')) { deleteAdditionalExperience('<?php echo $guideData['id'];?>','deleteAdditionalExperience'); $('#addnl<?php echo $guideData['id'];?>').remove(); }" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
	</tr>
	<?php 
	}
	}
	
	
	
	
	if($additionalIdData['serviceType']=='Entrance'){
	
	$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$_REQUEST['quotationId'].'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
	while($entranceData=mysqli_fetch_array($rsAct)){

		if($entranceData['additionalId'] != 0){
			$c121=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id in (select entranceNameId from '._DMC_ENTRANCE_RATE_MASTER_.' where id="'.$entranceData['additionalId'].'") order by id asc'); 
			$entranceDataName=mysqli_fetch_array($c121);
		}else{
			$c121=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$entranceData['serviceId'].'"'); 
			$entranceDataName=mysqli_fetch_array($c121);	
		}

		?>
		<tr id="addnl<?php echo $entranceData['id'];?>">
		 <td width="99" align="left"><?php echo $entranceData['serviceType'];?></td>
		<td width="179" align="left"><?php echo ucwords($entranceDataName['entranceName']);?></td>
		<td width="139" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$entranceData['adultCost'];?></td> 
		<td width="139" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$entranceData['childCost'];?></td> 
		<td width="139" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$entranceData['infantCost'];?></td> 
		<td width="143" align="center"><div><span style="color: #60ba3b; cursor: pointer; margin: 0px 5px;" onclick="openinboundpop('action=editSupplimentService&id=<?php echo $entranceData['id'];?>','800px');" ><i class="fa fa-pencil" aria-hidden="true"></i></span>&nbsp;<span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure you want delete this transfer?')){ deleteAdditionalExperience('<?php echo $entranceData['id'];?>','deleteAdditionalExperience'); $('#addnl<?php echo $entranceData['id'];?>').remove(); }" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
		</tr>
		<?php 
	}
}	

}
?>
</table>
<?php 
}
}

// Visa Rate code starts ===========================================
if($_REQUEST['action']=="visaRequirementAct" && $_REQUEST['quotationId']!=""){

	$quotationId = $_REQUEST['quotationId'];
	$visaRequired = $_REQUEST['visaRequired'];

	$nameValue = 'visaRequired="'.$visaRequired.'"';
	$where = 'id="'.$quotationId.'"';
	updatelisting('quotationMaster',$nameValue,$where);

	$quotQuery = GetPageRecord('visaRequired,id,adult,child,infant,currencyId,queryId',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
	$quotationData = mysqli_fetch_assoc($quotQuery);

	if($quotationData['visaRequired']==2){ ?>
	<style>
		.gridfield1{
			padding: 4px;
			width: 70px;
		}
		.editbtnselect{
		background-color: #75C38D;
	    padding: 6px 10px;
	    font-size: 15px;
	    font-weight: 500;
	    color: #fff;
	    margin-top: 12px;
		cursor: pointer;
		text-align: center;
		border-radius: 3px;
		}
		.gridlable1{
			font-size: 14px;
			
		}
		.valueAdd{
			font-size: 15px;
		}
	</style>
	<div style="background-color: #EAE9EE;padding: 10px;border: 4px solid #fff;">
	<?php 
	$qvrs = GetPageRecord('*','quotationVisaRateMaster','quotationId="'.$quotationId.'"');
	$rateAdded = mysqli_fetch_assoc($qvrs);

	//if($rateAdded['rateAdded']!=1){ ?>
	<table width="60%" cellpadding="5" cellspacing="0" >
	<tr><td><h4 class="valueAdd">Add VISA Rate</h4></td></tr>
		<?php 
		$nums = '';
		$visaQuery = GetPageRecord('*','visaQueryMaster','queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationData['id'].'"');
		if(mysqli_num_rows($visaQuery)>0){
		while($visaQueryData = mysqli_fetch_assoc($visaQuery)){
		?>
			<tr>
			<td >
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="visaSupplier<?php echo $nums; ?>" id="visaSupplier<?php echo $nums; ?>" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 137px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && visaType="11" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>" <?php if($insSuppData['id']==$insuranceQuotData['countryId']){ echo 'selected'; } ?>><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
			<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Date</div>
							<input type="date" name="visaDate<?php echo $nums; ?>" id="visaDate<?php echo $nums; ?>" class="gridfield1" value="<?= date('Y-m-d',strtotime($visaQueryData['fromDate'])); ?>" displayname="Processing Fee" style="width: 130px !important;">
						</label>
					</div>
				</td> 

			<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Country<span class="redmind"></span></div>
						<select name="visaCountryId<?php echo $nums; ?>" id="visaCountryId<?php echo $nums; ?>" class="gridfield1 validate" displayname="Visa Name" style="padding: 6px !important; width: 140px !important;">
						<!-- <option value="0">Select</option> -->
					<?php 

					$rsV = GetPageRecord('id,name',_COUNTRY_MASTER_,'status=1 && deletestatus=0 && name!=""');
					 while($visaCData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $visaCData['id']; ?>" <?php if($visaQueryData['destinationId']==$visaCData['id']){ ?> selected="selected" <?php } ?>><?php echo $visaCData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>

				<td style="width: 100px;display:none;" >
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Visa&nbsp;Name<span class="redmind"></span></div>
						<select name="visaNameId<?php echo $nums; ?>" id="visaNameId<?php echo $nums; ?>" class="gridfield1 validate" displayname="Visa Name" style="padding: 6px !important; width: 109px !important;">
						<!-- <option value="0">Select</option> -->
					<?php 

					$rsV = GetPageRecord('*','visaCostMaster','status=1 && deletestatus=0 && name!=""');
					 while($visaData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $visaData['id']; ?>" <?php if($visaQueryData['visaNameId']==$visaData['id']){ ?> selected="selected" <?php } ?> ><?php echo $visaData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Visa&nbsp;Type<span class="redmind"></span></div>
						
						<select name="visaType<?php echo $nums; ?>" id="visaType<?php echo $nums; ?>" class="gridfield1 validate"  onchange="selectVisaCost(this.value);"  displayname="Visa Type" style="padding: 6px !important; width: 82px !important;">
						<!-- <option value="0">Select</option> -->
					<?php 
					$rsV = GetPageRecord('*','visaTypeMaster','status=1 && deletestatus=0  && name!=""');
					 while($visatypeData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $visatypeData['id']; ?>" <?php if($visaQueryData['visaTypeId']==$visatypeData['id']){ ?> selected="selected" <?php } ?>><?php echo $visatypeData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Validity</div>
							<input type="text" name="visaValidity<?php echo $nums; ?>" id="visaValidity<?php echo $nums; ?>" class="gridfield1" value="<?php echo $visaQueryData['visaValidity']; ?>" displayname="Visa Validity">
						</label>
					</div>
				</td> 
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Entry&nbsp;Type</div>
							<select name="entryType<?php echo $nums; ?>" class="gridfield1" id="entryType<?php echo $nums; ?>" style="padding: 6px !important; width: 81px !important;">

							<option value="1" <?php if($visaQueryData['entryType']==1){ echo 'selected'; } ?> >Single Entry</option>
							<option value="2" <?php if($visaQueryData['entryType']==2){ echo 'selected'; } ?> >Multiple Entry</option>
						
							</select>
						</label>
					</div>
				</td> 
				<td style="width: 10%;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
						
						<select name="vcurrencyId<?php echo $nums; ?>" id="vcurrencyId<?php echo $nums; ?>" class="gridfield1 validate" onchange="getROE(this.value,'vcurrencyValue131');" displayname="Currency" style="padding: 6px !important;width:92px;">
						<option value="">Select</option>
					<?php 

						
						$currencyId = ($quotationData['currencyId']>0)?$quotationData['currencyId']:$baseCurrencyId;
						$currencyValue = ($quotationData['currencyValue']>0)?$quotationData['currencyValue']:getCurrencyVal($currencyId);

						$rsc2='';
						$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
					 	while($currencyData=mysqli_fetch_array($rsc2)){
					
						?>
						<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="vcurrencyValue<?php echo $nums; ?>" id="vcurrencyValue131<?php echo $nums; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value" style="width:87px;">
					</label>
				</div>
				</td>
				<td align="center">
				<div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewVisaToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div></td>
				</tr>
				<tr>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pax<span class="redmind"></span></div>
						<input type="text" name="adultCost<?php echo $nums; ?>" id="adultCost<?php echo $nums; ?>" value="" class="gridfield1" displayname="Adult Cost" style="display: inline-block;">
						<input type="text" class="gridfield1" name="VadultPax<?php echo $nums; ?>" id="VadultPax<?php echo $nums; ?>" value="<?php echo $quotationData['adult'] ?>" style="width: 45px;display: inline-block;">
					</label>
				</div>
				</td>
			
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pax<span class="redmind"></span></div>
						<input type="text" name="childCost<?php echo $nums; ?>" id="childCost<?php echo $nums; ?>" value="" class="gridfield1" displayname="Child Cost" style="display: inline-block;">
						<input type="text" class="gridfield1" name="VchildPax<?php echo $nums; ?>" id="VchildPax<?php echo $nums; ?>" value="<?php echo $quotationData['child'] ?>" style="width: 45px;display: inline-block;">
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pax</div>
						<input type="text" name="infantCost<?php echo $nums; ?>" id="infantCost<?php echo $nums; ?>" value="" class="gridfield1" displayname="Infant Cost" style="display: inline-block;width: 55px;">
						<input type="text" class="gridfield1" name="VinfantPax<?php echo $nums; ?>" id="VinfantPax<?php echo $nums; ?>" value="<?php echo $quotationData['infant'] ?>" style="width: 30px;display: inline-block;">
					</label>
				</div>
				</td>
				
				<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="visaGstTax<?php echo $nums; ?>" name="visaGstTax<?php echo $nums; ?>" class="gridfield" displayname="GST" autocomplete="off" style="width: 109px;padding: 6px !important;">
												<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Train" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>

			<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Markup&nbsp;Type<span class="redmind"></span></div>
							<select name="ProcessingFeeType<?php echo $nums; ?>" id="ProcessingFeeType<?php echo $nums; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 83px !important;">
							<option value="2">Flat</option>
								<option value="1">%</option>
								
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">P.&nbsp;Fee</div>
							<input type="text" name="processingFeev<?php echo $nums; ?>" id="processingFeev<?php echo $nums; ?>" class="gridfield1" displayname="Processing Fee" style="width: 70px !important;">
						</label>
					</div>
				</td> 
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Embassy&nbsp;Fee</div>
							<input type="text" name="embassyFeev<?php echo $nums; ?>" id="embassyFeev<?php echo $nums; ?>" class="gridfield1" displayname="Embassy Fee" style="width: 80px;">
						</label>
					</div>
				</td> 
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">VFS&nbsp;Charges</div>
							<input type="text" name="vfsChargesv<?php echo $nums; ?>" id="vfsChargesv<?php echo $nums; ?>" class="gridfield1" displayname="VFS Charges" style="width:82px;">
						</label>
					</div>
				</td> 
			

				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Tax&nbsp;Applicable</div>
							<select name="taxApplicable<?php echo $nums; ?>" class="gridfield1" id="taxApplicable<?php echo $nums; ?>" style="padding: 6px !important; width: 100px !important;">

							<option value="0" <?php if($visaQueryData['taxApplicable']==0 || $visaQueryData['taxApplicable']==''){ echo 'selected'; } ?> >Yes</option>
							<option value="1" <?php if($visaQueryData['taxApplicable']==1){ echo 'selected'; } ?> >No</option>
						
							</select>
						</label>
					</div>
				</td> 
				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addVisaCostToQuotation('<?php echo $nums; ?>');" >Select</div></td>
				
			</tr>

				<input type="hidden" name="visaRateId<?php echo $nums; ?>" id="visaRateId<?php echo $nums; ?>" value="">
			<?php $nums++; } }else{ ?>

				<!-- when query type not multi services -->
				<td >
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="visaSupplier<?php echo $nums; ?>" id="visaSupplier<?php echo $nums; ?>" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 137px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && visaType="11" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>" <?php if($insSuppData['id']==$insuranceQuotData['countryId']){ echo 'selected'; } ?>><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Date</div>
							<input type="date" name="visaDate<?php echo $nums; ?>" id="visaDate<?php echo $nums; ?>" class="gridfield1" value="<?= date('Y-m-d',strtotime('now')); ?>" displayname="Processing Fee" style="width: 130px !important;">
						</label>
					</div>
				</td> 

			<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Country<span class="redmind"></span></div>
						<select name="visaCountryId<?php echo $nums; ?>" id="visaCountryId<?php echo $nums; ?>" class="gridfield1 validate" displayname="Visa Name" style="padding: 6px !important; width: 140px !important;">
						<!-- <option value="0">Select</option> -->
					<?php 

					$rsV = GetPageRecord('id,name',_COUNTRY_MASTER_,'status=1 && deletestatus=0 && name!=""');
					 while($visaCData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $visaCData['id']; ?>" <?php if($visaQueryData['destinationId']==$visaCData['id']){ ?> selected="selected" <?php } ?>><?php echo $visaCData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>

				<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Visa&nbsp;Name<span class="redmind"></span></div>
						<select name="visaNameId<?php echo $nums; ?>" id="visaNameId<?php echo $nums; ?>" class="gridfield1 validate" displayname="Visa Name" style="padding: 6px !important; width: 109px !important;">
						<!-- <option value="0">Select</option> -->
					<?php 

					$rsV = GetPageRecord('*','visaCostMaster','status=1 && deletestatus=0 && name!=""');
					 while($visaData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $visaData['id']; ?>" <?php if($visaQueryData['visaNameId']==$visaData['id']){ ?> selected="selected" <?php } ?> ><?php echo $visaData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Visa&nbsp;Type<span class="redmind"></span></div>
						
						<select name="visaType<?php echo $nums; ?>" id="visaType<?php echo $nums; ?>" class="gridfield1 validate"  onchange="selectVisaCost(this.value);"  displayname="Visa Type" style="padding: 6px !important; width: 82px !important;">
						<!-- <option value="0">Select</option> -->
					<?php 
					$rsV = GetPageRecord('*','visaTypeMaster','status=1 && deletestatus=0  && name!=""');
					 while($visatypeData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $visatypeData['id']; ?>" <?php if($visaQueryData['visaTypeId']==$visatypeData['id']){ ?> selected="selected" <?php } ?>><?php echo $visatypeData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Validity</div>
							<input type="text" name="visaValidity<?php echo $nums; ?>" id="visaValidity<?php echo $nums; ?>" class="gridfield1" value="<?php echo $visaQueryData['visaValidity']; ?>" displayname="Visa Validity">
						</label>
					</div>
				</td> 
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Entry&nbsp;Type</div>
							<select name="entryType<?php echo $nums; ?>" class="gridfield1" id="entryType<?php echo $nums; ?>" style="padding: 6px !important; width: 81px !important;">

							<option value="1" <?php if($visaQueryData['entryType']==1){ echo 'selected'; } ?> >Single Entry</option>
							<option value="2" <?php if($visaQueryData['entryType']==2){ echo 'selected'; } ?> >Multiple Entry</option>
						
							</select>
						</label>
					</div>
				</td> 
				<td style="width: 10%;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
						
						<select name="vcurrencyId<?php echo $nums; ?>" id="vcurrencyId<?php echo $nums; ?>" class="gridfield1 validate" onchange="getROE(this.value,'vcurrencyValue131');" displayname="Currency" style="padding: 6px !important;width:92px;">
						<option value="">Select</option>
					<?php 

						
						$currencyId = ($quotationData['currencyId']>0)?$quotationData['currencyId']:$baseCurrencyId;
						$currencyValue = ($quotationData['currencyValue']>0)?$quotationData['currencyValue']:getCurrencyVal($currencyId);

						$rsc2='';
						$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
					 	while($currencyData=mysqli_fetch_array($rsc2)){
					
						?>
						<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="vcurrencyValue<?php echo $nums; ?>" id="vcurrencyValue131<?php echo $nums; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value" style="width:87px;">
					</label>
				</div>
				</td>
				<td align="center">
				<div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewVisaToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div></td>
				</tr>
				<tr>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pax<span class="redmind"></span></div>
						<input type="text" name="adultCost<?php echo $nums; ?>" id="adultCost<?php echo $nums; ?>" value="" class="gridfield1" displayname="Adult Cost" style="display: inline-block;">
						<input type="text" class="gridfield1" name="VadultPax<?php echo $nums; ?>" id="VadultPax<?php echo $nums; ?>" value="<?php echo $quotationData['adult'] ?>" style="width: 45px;display: inline-block;">
					</label>
				</div>
				</td>
			
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pax<span class="redmind"></span></div>
						<input type="text" name="childCost<?php echo $nums; ?>" id="childCost<?php echo $nums; ?>" value="" class="gridfield1" displayname="Child Cost" style="display: inline-block;">
						<input type="text" class="gridfield1" name="VchildPax<?php echo $nums; ?>" id="VchildPax<?php echo $nums; ?>" value="<?php echo $quotationData['child'] ?>" style="width: 45px;display: inline-block;">
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pax</div>
						<input type="text" name="infantCost<?php echo $nums; ?>" id="infantCost<?php echo $nums; ?>" value="" class="gridfield1" displayname="Infant Cost" style="display: inline-block;">
						<input type="text" class="gridfield1" name="VinfantPax<?php echo $nums; ?>" id="VinfantPax<?php echo $nums; ?>" value="<?php echo $quotationData['infant'] ?>" style="width: 45px;display: inline-block;">
					</label>
				</div>
				</td>

				<td>
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="visaGstTax<?php echo $nums; ?>" name="visaGstTax<?php echo $nums; ?>" class="gridfield" displayname="GST" autocomplete="off" style="width: 109px; padding: 6px !important;">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>
			
			<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Markup&nbsp;Type<span class="redmind"></span></div>
							<select name="ProcessingFeeType<?php echo $nums; ?>" id="ProcessingFeeType<?php echo $nums; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 83px !important;">
								<option value="1">%</option>
								<option value="2">Flat</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">P.&nbsp;Fee</div>
							<input type="text" name="processingFeev<?php echo $nums; ?>" id="processingFeev<?php echo $nums; ?>" class="gridfield1" displayname="Processing Fee" style="width: 70px !important;">
						</label>
					</div>
				</td> 
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Embassy&nbsp;Fee</div>
							<input type="text" name="embassyFeev<?php echo $nums; ?>" id="embassyFeev<?php echo $nums; ?>" class="gridfield1" displayname="Embassy Fee" style="width: 80px;">
						</label>
					</div>
				</td> 
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">VFS&nbsp;Charges</div>
							<input type="text" name="vfsChargesv<?php echo $nums; ?>" id="vfsChargesv<?php echo $nums; ?>" class="gridfield1" displayname="VFS Charges" style="width:82px;">
						</label>
					</div>
				</td> 
			

				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Tax&nbsp;Applicable</div>
							<select name="taxApplicable<?php echo $nums; ?>" class="gridfield1" id="taxApplicable<?php echo $nums; ?>" style="padding: 6px !important; width: 100px !important;">

							<option value="0" <?php if($visaQueryData['taxApplicable']==0 || $visaQueryData['taxApplicable']==''){ echo 'selected'; } ?> >Yes</option>
							<option value="1" <?php if($visaQueryData['taxApplicable']==1){ echo 'selected'; } ?> >No</option>
						
							</select>
						</label>
					</div>
				</td> 
				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addVisaCostToQuotation('<?php echo $nums; ?>');" >Select</div></td>
				
			</tr>

			<?php } ?>
		</tbody>
	</table>

	<?php 
	$quotrs = GetPageRecord('*','quotationVisaRateMaster','quotationId="'.$quotationId.'"');
	if(mysqli_num_rows($quotrs)>0){ ?>
		<table border="1" width="90%" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
					<tr>
						<th>Date</th>
						<th>Supplier</th>
						<th>Country</th>
						<!-- <th>Visa&nbsp;Name</th> -->
						<th>Visa&nbsp;Type</th>
						<th>Currency[ROE]</th>
						<th>Adult&nbsp;Cost</th>
						<th>Child&nbsp;Cost</th>
						<th>Infant&nbsp;Cost</th>
						<th>Fee&nbsp;Type</th>
						<th>Fee</th>
						<th>Adult</th>
						<th>Child</th>
						<th>Infant</th>
						<th>Embassy<br>Fee</th>
						<th>VFS<br>Charges</th>
						<th>Entry&nbsp;Type</th>
						<th>Visa<br>Validity</th>
						<th>Tax<br>Applicable</th>
						<!-- <th>Infant&nbsp;Pax</th> -->
						<th>#</th>
						<th>#</th>
					</tr>
				<?php 
				while($quotVisaData = mysqli_fetch_assoc($quotrs)){ 

					$vst = GetPageRecord('name,id','visaTypeMaster','id="'.$quotVisaData['visaTypeId'].'"');
					$visType = mysqli_fetch_assoc($vst);
					
					$rs2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'id="'.$quotVisaData['currencyId'].'"'); 
					$editresult2=mysqli_fetch_array($rs2); 
					$newCurrName=clean($editresult2['name']);

					$currencyId = $quotVisaData['currencyId'];
					$currencyValue = ($quotVisaData['currencyValue']>0)?$quotVisaData['currencyValue']:getCurrencyVal($currencyId);
				?>
					<tr>
						<td><div style="width: 70px;"><?php echo date('d-m-Y',strtotime($quotVisaData['visaDate'])); ?></div></td>
						<td><?php echo getSupplierName($quotVisaData['supplierId']); ?></td>
						<td><?php echo getCountryName($quotVisaData['visaCountryId']); ?></td>
						<!-- <td><?php echo $quotVisaData['name']; ?></td> -->
						<td><?php echo $visType['name']; ?></td>
						<td><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
						<td><?php echo ($quotVisaData['adultCost']); ?></td>
						<td><?php echo ($quotVisaData['childCost']); ?></td>
						<td><?php echo ($quotVisaData['infantCost']); ?></td>
						<td><?php echo ($quotVisaData['markupType']==1)?'%':'Flat'; ?></td>
						<td><?php echo ($quotVisaData['processingFee']); ?></td>
						<td align="center"><?php echo ($quotVisaData['adultPax']); ?></td>
						<td align="center"><?php echo ($quotVisaData['childPax']); ?></td>
						<td align="center"><?php echo ($quotVisaData['infantPax']); ?></td>
						<td><?php echo ($quotVisaData['embassyFee']); ?></td>
						<td><?php echo ($quotVisaData['vfsCharges']); ?></td>
						<td align="center"><?php echo ($quotVisaData['entryType']==1)?'Single':'Multiple'; ?></td>
						<td align="center"><?php echo $quotVisaData['visaValidity']; ?></td>
						<td align="center"><?php echo ($quotVisaData['taxApplicable']==1)?'No':'Yes'; ?></td>
						<td align="center">
							<div class="editbtnselect" id="selectthis" style="margin-top: 0px !important;" onclick="openinboundpop('action=editQuotationVisaCost&editId=<?php echo $quotVisaData['id'] ?>&quotationId=<?php echo $quotVisaData['quotationId'] ?>');" >Edit
							</div>
						</td>
						<td width="" align="center"><div><span style="color: #60ba3b; cursor: pointer; margin: 0px 5px;" ></span><span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure! you want to delete this Visa Rate?')){ deleteVisaQuotationRate('<?php echo $quotVisaData['id'] ?>','<?php echo $quotVisaData['quotationId'] ?>','deleteVisaQuotationRate'); $('#addnl<?php echo $quotVisaData['id'];?>').remove(); }" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
					</tr>
					<?php } ?>
		</table>
	<?php } ?>
	</div>

	<div id="selectVisacost"></div>
	<script>
		function selectVisaCost(id){
				var visaNameId=0;
				visaNameId = $("#visaNameId").val();
				if(visaNameId>0){
			$("#selectVisacost").load('searchaction.php?action=selectVisaCost&visaTypeId='+id+'&visaNameId='+visaNameId);
				}else{
					alert("Please Select Visa Name First");
					
				}
		}

		function addVisaCostToQuotation(num){

		var visaRateId = $("#visaRateId"+num).val();
		var adultCost = $("#adultCost"+num).val();
		var childCost = $("#childCost"+num).val();
		var infantCost = $("#infantCost"+num).val();
		var adultPax = $("#VadultPax"+num).val();
		var childPax = $("#VchildPax"+num).val();
		var infantPax = $("#VinfantPax"+num).val();
		var visaType = $("#visaType"+num).val();
		var visaNameId = $("#visaNameId"+num).val();
		var vcurrencyId = $("#vcurrencyId"+num).val();
		var vfsChargesv = $("#vfsChargesv"+num).val();
		var embassyFeev = $("#embassyFeev"+num).val();
		var visaGstTax = $("#visaGstTax"+num).val();
		var processingFeev = $("#processingFeev"+num).val();
		var ProcessingFeeType = $("#ProcessingFeeType"+num).val();
	
		var vcurrencyValue131 = $("#vcurrencyValue131"+num).val();
		var visaCountryId = $("#visaCountryId"+num).val();
		var visaDate = $("#visaDate"+num).val();
		var visaValidity = $("#visaValidity"+num).val();
		var entryType = $("#entryType"+num).val();
		var taxApplicable = $("#taxApplicable"+num).val();
		var visaSupplier = $("#visaSupplier"+num).val();
		
		if(visaType>0 && visaNameId>0){

		$("#selectVisacost").load('loadValueAddedserviceCost.php?action=saveVisaCosttoQuotation&visaRateId='+visaRateId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&visaNameId='+visaNameId+'&visaType='+visaType+'&currencyId='+vcurrencyId+'&currencyValue='+vcurrencyValue131+'&markupType='+ProcessingFeeType+'&markupCost='+processingFeev+'&gstTax='+visaGstTax+'&embassyFeev='+embassyFeev+'&vfsChargesv='+vfsChargesv+'&entryType='+entryType+'&visaValidity='+encodeURI(visaValidity)+'&visaDate='+encodeURI(visaDate)+'&visaCountryId='+visaCountryId+'&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&taxApplicable='+taxApplicable+'&supplierId='+visaSupplier);
		}else{
			alert('Please, Select Visa Name or Type');
		}
	}
	</script>
	<?php
	}
	?>
	<script>
		 parent.loadquotationmainfile();
	</script>
	<?php
}

// Passport Rate code starts ===========================================
if($_REQUEST['action']=="passportRequirementAct" && $_REQUEST['quotationId']!=""){

	$quotationId = $_REQUEST['quotationId'];
	$passportRequired = $_REQUEST['passportRequired'];
	
	$nameValue = 'passportRequired="'.$passportRequired.'"';
	$where = 'id="'.$quotationId.'"';
	updatelisting('quotationMaster',$nameValue,$where);
	
	$rsVV = GetPageRecord('passportRequired,id,adult,child,infant,currencyId',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
	$quotationData = mysqli_fetch_assoc($rsVV);
	
	if($quotationData['passportRequired']==2){
	
	?>
	<style>
		.gridfield1{
			padding: 4px;
			width: 70px;
		}
		.editbtnselect{
		background-color: #75C38D;
		padding: 6px 10px;
		font-size: 15px;
		font-weight: 500;
		color: #fff;
		margin-top: 12px;
		cursor: pointer;
		text-align: center;
		border-radius: 3px;
		}
		.gridlable1{
			font-size: 14px;
			
		}
		.valueAdd{
			font-size: 15px;
		}
	</style>
	<div style="background-color: #EAE9EE;padding: 10px;border: 4px solid #fff;">
	<?php 
	// $qvrs = GetPageRecord('*','quotationPassportRateMaster','quotationId="'.$quotationId.'"');
	// $rateAdded = mysqli_fetch_assoc($qvrs);
	
	//if($rateAdded['rateAdded']!=1){ ?>
	<table width="60%" cellpadding="5" cellspacing="0" >
		<tr><td><h4 class="valueAdd">Add Passport Rate</h4></td></tr>
			<tr>
				<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Passport&nbsp;Name<span class="redmind"></span></div>
						<select name="passportNameId" id="passportNameId" class="gridfield1 validate" displayname="Passport Name" style="padding: 6px !important; width: 136px !important;">
						<option value="0">Select</option>
					<?php 
					$Prs = GetPageRecord('*','passportCostMaster','status=1 && deletestatus=0 && name!=""');
					 while($passData = mysqli_fetch_assoc($Prs)){
						?>
						<option value="<?php echo $passData['id']; ?>"><?php echo $passData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Passport&nbsp;Type<span class="redmind"></span></div>
						
						<select name="passportType" id="passportType" class="gridfield1 validate" displayname="Passport Type" onchange="selectPassportCost(this.value);" style="padding: 6px !important; width: 136px !important;">
						<option value="0">Select</option>
					<?php 
					$rsV = GetPageRecord('*','passportTypeMaster','status=1 && deletestatus=0 && name!=""');
					 while($passtypeData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $passtypeData['id']; ?>"><?php echo $passtypeData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
					
					<select name="pcurrencyId" id="pcurrencyId" class="gridfield1 validate" onchange="getROE(this.value,'pcurrencyValue131');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
				<?php 
			

					$currencyId = ($quotationData['currencyId']>0)?$quotationData['currencyId']:$baseCurrencyId;
					$currencyValue = ($quotationData['currencyValue']>0)?$quotationData['currencyValue']:getCurrencyVal($currencyId);

					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
				
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>
			<td style="padding-right: 0px;">
					<div class="griddiv"><label>
						<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
							<input type="text" name="pcurrencyValue" id="pcurrencyValue131" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
						</label>
					</div>
				</td>
			<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="adultCost" id="passadultCost" value="" class="gridfield1" displayname="Adult Cost">
						<input type="hidden" name="PadultPax" id="PadultPax" value="<?php echo $quotationData['adult'] ?>" >
					</label>
				</div>
				</td>
				<!-- <td  style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">No Of&nbsp;Pax</div>	
						<input type="text" name="PadultPax" id="PadultPax" value="<?php echo $quotationData['adult'] ?>" placeholder="Adult Pax" class="gridfield1" style="width:56px !important; ">
					 </label>
				</div>
				</td> -->

				<td  style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="childCost" id="passchildCost" value="" class="gridfield1" displayname="Child Cost">
						<input type="hidden" name="PchildPax" id="PchildPax" value="<?php echo $quotationData['child'] ?>" >
					</label>
				</div>
				</td>
				<!-- <td  style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">No Of&nbsp;Pax</div>	
						<input type="text" name="PchildPax" id="PchildPax" value="<?php echo $quotationData['child'] ?>" placeholder="Child Pax" class="gridfield1" style="width:56px !important; ">
					 </label>
				</div>
				</td> -->

				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
						<input type="text" name="infantCost" id="passinfantCost" value="" class="gridfield1" displayname="Infant Cost">
						<input type="hidden" name="PinfantPax" id="PinfantPax" value="<?php echo $quotationData['infant'] ?>" >
					</label>
				</div>
				</td>
				<!-- <td style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">No Of&nbsp;Pax</div>	
					<input type="text" name="PinfantPax" id="PinfantPax" value="<?php echo $quotationData['infant'] ?>" placeholder="Infant Pax" class="gridfield1" style="width:56px !important; ">
					</label>
				</div>
				</td> -->
				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addPassportCostToQuotation();" >Select</div>
				</td>
				<td align="center">
			<div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewPassportToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div></td>
			</tr>
		
			
	
				<input type="hidden" name="passRateId" id="passRateId" value="">
			
			<!-- <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp; -->
		</tbody>
	</table>
	<?php 
	//}
	
	$quoTPss = GetPageRecord('*','quotationPassportRateMaster','quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($quoTPss)>0){
	?>
	
	<table border="1" width="80%" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
			<tr>
				<th>Passport Name</th>
				<th>Passport Type</th>
				<th>Currency[ROE]</th>
				<th>Adult Cost</th>
				<th>Child Cost</th>
				<th>Infant Cost</th>
				<!-- <th>Adult Pax</th> -->
				<!-- <th>Child Pax</th> -->
				<!-- <th>Infant Pax</th> -->
				<th>#</th>
				<th>#</th>
			</tr>
			<?php 
			while($quotPassData = mysqli_fetch_assoc($quoTPss)){ 
	
				$pst = GetPageRecord('name,id','passportTypeMaster','id="'.$quotPassData['passportTypeId'].'"');
				$passType = mysqli_fetch_assoc($pst);
	
				$rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$quotPassData['currencyId'].'"'); 
				$editresult2=mysqli_fetch_array($rs2); 
				$cur=clean($editresult2['name']); 
				$currencyId = $quotPassData['currencyId'];
				$currencyValue = ($quotPassData['currencyValue']>0)?$quotPassData['currencyValue']:getCurrencyVal($currencyId);
			?>
			<tr>
				<td><?php echo $quotPassData['name']; ?></td>
				<td><?php echo $passType['name']; ?></td>
				<td><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
				<td><?php echo ($quotPassData['adultCost']); ?></td>
				<td><?php echo ($quotPassData['childCost']); ?></td>
				<td><?php echo ($quotPassData['infantCost']); ?></td>
				<!-- <td align="center"><?php echo $quotPassData['adultPax']; ?></td> -->
				<!-- <td align="center"><?php echo $quotPassData['childPax']; ?></td> -->
				<!-- <td align="center"><?php echo $quotPassData['infantPax']; ?></td> -->
				<td align="center"><div class="editbtnselect" id="selectthis" style="margin-top: 0px !important;" onclick="openinboundpop('action=editQuotationPassCost&editId=<?php echo $quotPassData['id'] ?>&quotationId=<?php echo $quotPassData['quotationId'] ?>');" >Edit
				</div></td>
				<td width="" align="center"><div><span style="color: #60ba3b; cursor: pointer; margin: 0px 5px;" ></span><span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure you want delete this Passport Rate?')){ deletePassQuotationRate('<?php echo $quotPassData['id'] ?>','<?php echo $quotPassData['quotationId'] ?>','deletePassQuotationRate'); $('#addnl<?php echo $quotPassData['id'];?>').remove(); }" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
			</tr>
				<?php } ?>
	</table>
	<?php } ?>
	</div>
	<div id="selectPasscost"></div>
	<script>
		function selectPassportCost(id){
			var passportNameId =0;
			passportNameId = $("#passportNameId").val();
			if(passportNameId>0){
			$("#selectPasscost").load('searchaction.php?action=selectPassCost&passTypeId='+id+'&passportNameId='+passportNameId);
			}else{
				alert("Please Select Passport Name First");
			}
		}
		
		function addPassportCostToQuotation(){
			
			var passRateId = $("#passRateId").val();
			var adultCost = $("#passadultCost").val();
			var childCost = $("#passchildCost").val();
			var infantCost = $("#passinfantCost").val();
			var adultPax = $("#PadultPax").val();
			var childPax = $("#PchildPax").val();
			var infantPax = $("#PinfantPax").val();
			var passportType = $("#passportType").val();
			var passportNameId = $("#passportNameId").val();
			var pcurrencyId = $("#pcurrencyId").val();
			var pcurrencyValue131 = $("#pcurrencyValue131").val();
			if(passportType>0 && passportNameId>0){
				
			$("#selectPasscost").load('loadValueAddedserviceCost.php?action=savePassportCosttoQuotation&passRateId='+passRateId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&passportNameId='+passportNameId+'&passportType='+passportType+'&currencyId='+pcurrencyId+'&currencyValue='+pcurrencyValue131+'&quotationId=<?php echo $quotationId; ?>');
			}else{
				alert('Please, Select Passport Name or Type');
			}
		}
		</script>
		<?php
	}
}
	
// Insurance Rate code starts ===========================================
if($_REQUEST['action']=="insuranceRequirementAct" && $_REQUEST['quotationId']!=""){

	$quotationId = $_REQUEST['quotationId'];
	$insuranceRequired = $_REQUEST['insuranceRequired'];
	
	$nameValue = 'insuranceRequired="'.$insuranceRequired.'"';
	$where = 'id="'.$quotationId.'"';
	updatelisting('quotationMaster',$nameValue,$where);
	
	$rsVV = GetPageRecord('insuranceRequired,id,adult,child,infant,currencyId,queryId',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
	$quotationData = mysqli_fetch_assoc($rsVV);
	
	if($quotationData['insuranceRequired']==2){
	
	?>
	<style>
		.gridfield1{
			padding: 4px;
			width: 70px;
		}
		.editbtnselect{
		background-color: #75C38D;
		padding: 6px 10px;
		font-size: 15px;
		font-weight: 500;
		color: #fff;
		margin-top: 12px;
		cursor: pointer;
		text-align: center;
		border-radius: 3px;
		}
		.gridlable1{
			font-size: 14px;
			
		}
		.valueAdd{
			font-size: 15px;
		}
	</style>
	<div style="background-color: #EAE9EE;padding: 10px;border: 4px solid #fff;">
	<?php 
	$qvrs = GetPageRecord('*','quotationVisaRateMaster','quotationId="'.$quotationId.'"');
	$rateAdded = mysqli_fetch_assoc($qvrs);
	
	//if($rateAdded['rateAdded']!=1){ ?>
	<table width="80%" cellpadding="5" cellspacing="0" >
	<tr><td colspan="5"><h4 class="valueAdd">Add Insurance Rate</h4></td></tr>
			<?php 
			$insNum = '';
			$insQuery = GetPageRecord('*','insuranceQueryMaster','queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'"');
			if(mysqli_num_rows($insQuery)>0){
				while($insuranceQueryData = mysqli_fetch_assoc($insQuery)){

			?>
			<tr>
			<td style="width: 100px" colspan="2">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="insuranceSupplier<?php echo $insNum; ?>" id="insuranceSupplier<?php echo $insNum; ?>" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 137px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && insuranceType="14" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>" <?php if($insSuppData['id']==$insuranceQuotData['countryId']){ echo 'selected'; } ?>><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
			<td style="width: 100px" colspan="2">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Country<span class="redmind"></span></div>
						<select name="travellingcountryId<?php echo $insNum; ?>" id="travellingcountryId<?php echo $insNum; ?>" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 143px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_COUNTRY_MASTER_,'status=1 && deletestatus=0 && name!=""');
					 while($insCountryData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insCountryData['id']; ?>" <?php if($insCountryData['id']==$insuranceQueryData['destinationId']){ echo 'selected'; } ?>><?php echo $insCountryData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>

				<td colspan="2" style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">From&nbsp;Date<span class="redmind"></span></div>
						<input type="text" name="insuranceFromDate<?php echo $insNum; ?>" id="insuranceFromDate<?php echo $insNum; ?>" value="<?php if($insuranceQueryData['fromDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($insuranceQueryData['fromDate'])); } ?>" class="gridfield1" displayname="From Date" style="width:127px;" readonly>
					
					</label>
				</div>
				</td>

				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">To&nbsp;Date<span class="redmind"></span></div>
						<input type="text" name="insuranceToDate<?php echo $insNum; ?>" id="insuranceToDate<?php echo $insNum; ?>" value="<?php if($insuranceQueryData['toDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($insuranceQueryData['toDate'])); } ?>" class="gridfield1" displayname="To Date" style="width: 100px;" readonly>
						
					</label>
				</div>
				</td>

				<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Insurance&nbsp;Name<span class="redmind"></span></div>
						<select name="insuranceNameId<?php echo $insNum; ?>" id="insuranceNameId<?php echo $insNum; ?>" class="gridfield1 validate" displayname="Insurance Name" style="padding: 6px !important; width: 135px !important;">
						<option value="0">Select</option>
					<?php 
					$rsV = GetPageRecord('*','insuranceCostMaster','status=1 && deletestatus=0 && name!=""');
					 while($insuranceData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $insuranceData['id']; ?>" ><?php echo $insuranceData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Insurance&nbsp;Type<span class="redmind"></span></div>
						
						<select name="insuranceType<?php echo $insNum; ?>" id="insuranceType<?php echo $insNum; ?>" class="gridfield1 validate" displayname="Visa Type" onchange="selectInsuranceCost(this.value);" style="padding: 6px !important; width: 110px !important;">
						<option value="0">Select</option>
					<?php 
					$rsV = GetPageRecord('*','InsuranceTypeMaster','status=1 && deletestatus=0 && name!=""');
					 while($insurancetypeData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $insurancetypeData['id']; ?>" <?php if($insurancetypeData['id']==$insuranceQueryData['insuranceTypeId']){ echo 'selected'; } ?>><?php echo $insurancetypeData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
					
					<select name="IcurrencyId<?php echo $insNum; ?>" id="IcurrencyId<?php echo $insNum; ?>" class="gridfield1 validate" onchange="getROE(this.value,'IcurrencyValue131');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
				<?php 

					$currencyId = ($quotationData['currencyId']>0)?$quotationData['currencyId']:$baseCurrencyId;
					$currencyValue = ($quotationData['currencyValue']>0)?$quotationData['currencyValue']:getCurrencyVal($currencyId);
					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
				
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?>><?php echo $currencyData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>
			<td style="padding-right: 0px;">
					<div class="griddiv"><label>
						<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
							<input type="text" name="IcurrencyValue<?php echo $insNum; ?>" id="IcurrencyValue131<?php echo $insNum; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
						</label>
					</div>
				</td>

				
			</tr>
			<tr>
				<td>
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="insadultCost<?php echo $insNum; ?>" id="insadultCost<?php echo $insNum; ?>" value="" class="gridfield1" displayname="Adult Cost">
					
					</label>
				</div>
				</td>
				<td>
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(A)</div>	
						<input type="text" name="inadultPax<?php echo $insNum; ?>" id="inadultPax<?php echo $insNum; ?>" value="<?php echo $quotationData['adult'] ?>" placeholder="Adult Pax" class="gridfield1" style="width:40px !important;">
					 </label>
				</div>
				</td>

				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="inschildCost<?php echo $insNum; ?>" id="inschildCost<?php echo $insNum; ?>" value="" class="gridfield1" displayname="Child Cost">
						
					</label>
				</div>
				</td>
				<td style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(C)</div>	
						<input type="text" name="inchildPax<?php echo $insNum; ?>" id="inchildPax<?php echo $insNum; ?>" value="<?php echo $quotationData['child'] ?>" placeholder="Child Pax" class="gridfield1" style="width:40px !important;" >
					 </label>
				</div>
				</td>

				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
						<input type="text" name="insinfantCost<?php echo $insNum; ?>" id="insinfantCost<?php echo $insNum; ?>" value="" class="gridfield1" displayname="Infant Cost">
					
					</label>
				</div>
				</td>
				<td style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(I)</div>	
					<input type="text" name="ininfantPax<?php echo $insNum; ?>" id="ininfantPax<?php echo $insNum; ?>" value="<?php echo $quotationData['infant'] ?>" placeholder="Infant Pax" class="gridfield1" style="width:40px !important;">	
					</label>
				</div>
				</td>

				<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="insGstTax<?php echo $insNum; ?>" name="insGstTax<?php echo $insNum; ?>" class="gridfield" displayname="GST" autocomplete="off" style="width: 109px;padding: 6px !important;">
												<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Insurance" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Markup&nbsp;Type<span class="redmind"></span></div>
							<select name="iProcessingFeeType<?php echo $insNum; ?>" id="iProcessingFeeType<?php echo $insNum; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1">%</option>
								<option value="2">Flat</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="iprocessingFee<?php echo $insNum; ?>" id="iprocessingFee<?php echo $insNum; ?>" class="gridfield1" displayname="Processing Fee" style="width: 95px !important;">
						</label>
					</div>
				</td> 


				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addInsuranceCostToQuotation('<?php echo $insNum; ?>');" >Select
				</div></td>
				<td align="center">
			<div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewInsuranceToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div></td>
			</tr>
				<input type="hidden" name="insuranceRateId<?php echo $insNum; ?>" id="insuranceRateId<?php echo $insNum; ?>" value="">
		
			<?php $insNum++;	}
			}else{ 	?>

			<!-- when query type not multiple services -->

			<tr>
			<td style="width: 100px" colspan="2">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="insuranceSupplier<?php echo $insNum; ?>" id="insuranceSupplier<?php echo $insNum; ?>" class="gridfield1 validate" displayname="Supplier" style="padding: 6px !important; width: 137px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && insuranceType="14" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>" <?php if($insSuppData['id']==$insuranceQuotData['countryId']){ echo 'selected'; } ?>><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
			<td style="width: 100px" colspan="2">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Country<span class="redmind"></span></div>
						<select name="travellingcountryId<?php echo $insNum; ?>" id="travellingcountryId<?php echo $insNum; ?>" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 143px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_COUNTRY_MASTER_,'status=1 && deletestatus=0 && name!=""');
					 while($insCountryData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insCountryData['id']; ?>" <?php if($insCountryData['id']==$insuranceQueryData['destinationId']){ echo 'selected'; } ?>><?php echo $insCountryData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>

				<td colspan="2" style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">From&nbsp;Date<span class="redmind"></span></div>
						<input type="date" name="insuranceFromDate<?php echo $insNum; ?>" id="insuranceFromDate<?php echo $insNum; ?>" value="<?=date('Y-m-d'); ?>" class="gridfield1" displayname="From Date" style="width:127px;" >
					
					</label>
				</div>
				</td>

				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">To&nbsp;Date<span class="redmind"></span></div>
						<input type="date" name="insuranceToDate<?php echo $insNum; ?>" id="insuranceToDate<?php echo $insNum; ?>" value="<?=date('Y-m-d'); ?>" class="gridfield1" displayname="To Date" style="width:100px;" >
						
					</label>
				</div>
				</td>

				<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Insurance&nbsp;Name<span class="redmind"></span></div>
						<select name="insuranceNameId<?php echo $insNum; ?>" id="insuranceNameId<?php echo $insNum; ?>" class="gridfield1 validate" displayname="Insurance Name" style="padding: 6px !important; width: 135px !important;">
						<option value="0">Select</option>
					<?php 
					$rsV = GetPageRecord('*','insuranceCostMaster','status=1 && deletestatus=0 && name!=""');
					 while($insuranceData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $insuranceData['id']; ?>" ><?php echo $insuranceData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Insurance&nbsp;Type<span class="redmind"></span></div>
						
						<select name="insuranceType<?php echo $insNum; ?>" id="insuranceType<?php echo $insNum; ?>" class="gridfield1 validate" displayname="Visa Type" onchange="selectInsuranceCost(this.value);" style="padding: 6px !important; width: 110px !important;">
						<option value="0">Select</option>
					<?php 
					$rsV = GetPageRecord('*','InsuranceTypeMaster','status=1 && deletestatus=0 && name!=""');
					 while($insurancetypeData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $insurancetypeData['id']; ?>" <?php if($insurancetypeData['id']==$insuranceQueryData['insuranceTypeId']){ echo 'selected'; } ?>><?php echo $insurancetypeData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
				<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
					
					<select name="IcurrencyId<?php echo $insNum; ?>" id="IcurrencyId<?php echo $insNum; ?>" class="gridfield1 validate" onchange="getROE(this.value,'IcurrencyValue131');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
				<?php 

					$currencyId = ($quotationData['currencyId']>0)?$quotationData['currencyId']:$baseCurrencyId;
					$currencyValue = ($quotationData['currencyValue']>0)?$quotationData['currencyValue']:getCurrencyVal($currencyId);
					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
				
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?>><?php echo $currencyData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>
			<td style="padding-right: 0px;">
					<div class="griddiv"><label>
						<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
							<input type="text" name="IcurrencyValue<?php echo $insNum; ?>" id="IcurrencyValue131<?php echo $insNum; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
						</label>
					</div>
				</td>

				
			</tr>
			<tr>
				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="insadultCost<?php echo $insNum; ?>" id="insadultCost<?php echo $insNum; ?>" value="" class="gridfield1" displayname="Adult Cost">
						
					</label>
				</div>
				</td>

				<td>
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(A)</div>	
						<input type="text" name="inadultPax<?php echo $insNum; ?>" id="inadultPax<?php echo $insNum; ?>" value="<?php echo $quotationData['adult'] ?>" placeholder="Adult Pax" class="gridfield1" style="width:40px !important;">
					 </label>
				</div>
				</td>

				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="inschildCost<?php echo $insNum; ?>" id="inschildCost<?php echo $insNum; ?>" value="" class="gridfield1" displayname="Child Cost">
						
					</label>
				</div>
				</td>

				<td style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(C)</div>	
						<input type="text" name="inchildPax<?php echo $insNum; ?>" id="inchildPax<?php echo $insNum; ?>" value="<?php echo $quotationData['child'] ?>" placeholder="Child Pax" class="gridfield1" style="width:40px !important;" >
					 </label>
				</div>
				</td>

				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
						<input type="text" name="insinfantCost<?php echo $insNum; ?>" id="insinfantCost<?php echo $insNum; ?>" value="" class="gridfield1" displayname="Infant Cost">
					</label>
				</div>
				</td>

				<td style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(I)</div>	
					<input type="text" name="ininfantPax<?php echo $insNum; ?>" id="ininfantPax<?php echo $insNum; ?>" value="<?php echo $quotationData['infant'] ?>" placeholder="Infant Pax" class="gridfield1" style="width:40px !important;">	
					</label>
				</div>
				</td>
				<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="insGstTax<?php echo $insNum; ?>" name="insGstTax<?php echo $insNum; ?>" class="gridfield" displayname="GST" autocomplete="off" style="width: 109px;padding: 6px !important;">
												<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>
				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Markup&nbsp;Type<span class="redmind"></span></div>
							<select name="iProcessingFeeType<?php echo $insNum; ?>" id="iProcessingFeeType<?php echo $insNum; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1">%</option>
								<option value="2">Flat</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="iprocessingFee<?php echo $insNum; ?>" id="iprocessingFee<?php echo $insNum; ?>" class="gridfield1" displayname="Processing Fee" style="width: 95px !important;">
						</label>
					</div>
				</td> 

				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addInsuranceCostToQuotation('<?php echo $insNum; ?>');" >Select
				</div></td>
				<td align="center">
			<div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewInsuranceToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div></td>
			</tr>
				<input type="hidden" name="insuranceRateId<?php echo $insNum; ?>" id="insuranceRateId<?php echo $insNum; ?>" value="">
			<?php } ?>
		</tbody>
	</table>
	<?php 
	//}
	
	$Quotrs1 = GetPageRecord('*','quotationInsuranceRateMaster','quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($Quotrs1)>0){
	?>
	
	<table border="1" width="80%" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
			<tr>
				<th>Supplier</th>
				<th>Country</th>
				<th>From&nbsp;Date</th>
				<th>To&nbsp;Date</th>
				<th>Insurance Name</th>
				<th>Insurance Type</th>
				<th>Currency[ROE]</th>
				<th>Processing&nbsp;Type</th>
				<th>Processing&nbsp;Fee</th>
				<th>Adult Cost</th>
				<th>Child Cost</th>
				<th>Infant Cost</th>
				<th>Adult Pax</th>
				<th>Child Pax</th>
				<th>Infant Pax</th>
				<th>#</th>
				<th>#</th>
			</tr>
			<?php 
			while($quotInsuranceData = mysqli_fetch_assoc($Quotrs1)){ 
	
				$inst = GetPageRecord('name,id','InsuranceTypeMaster','id="'.$quotInsuranceData['insuranceTypeId'].'"');
				$insType = mysqli_fetch_assoc($inst);
	
				$rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$quotInsuranceData['currencyId'].'"'); 
				$editresult2=mysqli_fetch_array($rs2); 
				$cur=clean($editresult2['name']); 
				
				$currencyId = $quotInsuranceData['currencyId'];
				$currencyValue = ($quotInsuranceData['currencyValue']>0)?$quotInsuranceData['currencyValue']:getCurrencyVal($currencyId);

			?>
			<tr>
				<td align="center"><?php echo getSupplierName($quotInsuranceData['supplierId']); ?></td>
				<td align="center"><?php echo getCountryName($quotInsuranceData['countryId']); ?></td>
				<td align="center"><div style="width: 80px;"><?php echo date('d-m-Y',strtotime($quotInsuranceData['insuranceStartDate'])); ?></div></td>
				<td align="center"><div style="width: 80px;"><?php echo date('d-m-Y',strtotime($quotInsuranceData['insuranceEndDate'])); ?></div></td>
				<td align="center"><?php echo $quotInsuranceData['name']; ?></td>
				<td align="center"><?php echo $insType['name']; ?></td>
				<td align="center"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
				<td align="center"><?php echo ($quotInsuranceData['markupType']==1)?'%':'Flat'; ?></td>
				<td align="center"><?php echo ($quotInsuranceData['processingFee']); ?></td>
				<td align="center"><?php echo ($quotInsuranceData['adultCost']); ?></td>
				<td align="center"><?php echo ($quotInsuranceData['childCost']); ?></td>
				<td align="center"><?php echo ($quotInsuranceData['infantCost']); ?></td>
				<td align="center"><?php echo $quotInsuranceData['adultPax']; ?></td>
				<td align="center"><?php echo $quotInsuranceData['childPax']; ?></td>
				<td align="center"><?php echo $quotInsuranceData['infantPax']; ?></td>
				<td align="center"><div class="editbtnselect" id="selectthis" style="margin-top: 0px !important;" onclick="openinboundpop('action=editQuotationInsuranceCost&editId=<?php echo $quotInsuranceData['id'] ?>&quotationId=<?php echo $quotInsuranceData['quotationId'] ?>');" >Edit
				</div></td>
				<td width="" align="center"><div><span style="color: #60ba3b; cursor: pointer; margin: 0px 5px;" ></span><span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure you want delete this Insurance Rate?')){ deleteInsuranceQuotationRate('<?php echo $quotInsuranceData['id'] ?>','<?php echo $quotInsuranceData['quotationId'] ?>','deleteInsuranceQuotationRate'); $('#addnl<?php echo $quotInsuranceData['id'];?>').remove(); }" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
			</tr>
				<?php } ?>
	</table>
	<?php } ?>
	</div>
	<div id="selectInsurancecost"></div>
	<script>
		function selectInsuranceCost(id){
			var insuranceNameId=0;
			insuranceNameId = $("#insuranceNameId").val();
			if(insuranceNameId>0){
			$("#selectInsurancecost").load('searchaction.php?action=selectInsuranceCost&insuranceTypeId='+id+'&insuranceNameId='+insuranceNameId);
			}else{
				alert("Please Select Insurance First");
			}
		}
		
		function addInsuranceCostToQuotation(num){
			
			var processingFee = $("#iprocessingFee"+num).val();
			var ProcessingFeeType = $("#iProcessingFeeType"+num).val();
			var insuranceRateId = $("#insuranceRateId"+num).val();
			var adultCost = $("#insadultCost"+num).val();
			var childCost = $("#inschildCost"+num).val();
			var infantCost = $("#insinfantCost"+num).val();
			var adultPax = $("#inadultPax"+num).val();
			var childPax = $("#inchildPax"+num).val();
			var infantPax = $("#ininfantPax"+num).val();
			var insuranceType = $("#insuranceType"+num).val();
			var insuranceNameId = $("#insuranceNameId"+num).val();
			var IcurrencyId = $("#IcurrencyId"+num).val();
			var IcurrencyValue131 = $("#IcurrencyValue131"+num).val();
			var travellingcountryId = $("#travellingcountryId"+num).val();
			var insuranceFromDate = $("#insuranceFromDate"+num).val();
			var insuranceToDate = $("#insuranceToDate"+num).val();
			var insGstTax = $("#insGstTax"+num).val();
			var insuranceSupplier = $("#insuranceSupplier"+num).val();

			
			if(insuranceType>0 && insuranceNameId>0){
	
			$("#selectInsurancecost").load('loadValueAddedserviceCost.php?action=saveInsuranceCosttoQuotation&insuranceRateId='+insuranceRateId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&insuranceNameId='+insuranceNameId+'&insuranceType='+insuranceType+'&currencyId='+IcurrencyId+'&currencyValue='+IcurrencyValue131+'&quotationId=<?php echo $quotationId; ?>&travellingcountryId='+travellingcountryId+'&insuranceFromDate='+encodeURI(insuranceFromDate)+'&insuranceToDate='+encodeURI(insuranceToDate)+'&processingFee='+encodeURI(processingFee)+'&ProcessingFeeType='+encodeURI(ProcessingFeeType)+'&insGstTax='+encodeURI(insGstTax)+'&insuranceSupplier='+encodeURI(insuranceSupplier));
			}else{
				alert('Please, Select Insurance Name or Type');
			}
		}
	</script>
	<?php
	}
	?>
	<script>
		 loadquotationmainfile();
	</script>
	<?php
	}
	
// Flight Rate code starts ===========================================
if($_REQUEST['action']=="flightRequirementAct" && $_REQUEST['quotationId']!=""){

	$quotationId = $_REQUEST['quotationId'];
	$flightRequired = $_REQUEST['flightRequired'];
	
	$nameValue = 'flightRequired="'.$flightRequired.'"';
	$where = 'id="'.$quotationId.'"';
	updatelisting('quotationMaster',$nameValue,$where);
	
	$quQuery = GetPageRecord('flightRequired,id,adult,child,infant,currencyId,queryId',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
	$quotationData = mysqli_fetch_assoc($quQuery);
	
	if($quotationData['flightRequired']==2){
	?>
	<style>
		.gridfield1{
			padding: 4px;
			width: 70px;
		}
		.editbtnselect{
		background-color: #75C38D;
		padding: 6px 10px;
		font-size: 15px;
		font-weight: 500;
		color: #fff;
		margin-top: 12px;
		cursor: pointer;
		text-align: center;
		border-radius: 3px;
		}
		.gridlable1{
			font-size: 14px;
			
		}
		.valueAdd{
			font-size: 15px;
		}
	</style>
	<div style="background-color: #EAE9EE;padding: 10px;border: 4px solid #fff;">
	<table width="60%" cellpadding="5" cellspacing="0" >
	<tr><td colspan="5"><h4 class="valueAdd">Add Flight Rate</h4></td></tr>
				<?php 
				$fNum='';
				$rsF = GetPageRecord('*','flightQueryMaster','queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'"');
				if(mysqli_num_rows($rsF)>0){
					while($flightQueryData = mysqli_fetch_assoc($rsF)){
	
				?>
			<tr>
			<td >
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="flightSupplier<?php echo $fNum; ?>" id="flightSupplier<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 141px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && airlinesType="7" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>"><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
			<td colspan="2">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Flight&nbsp;Date<span class="redmind"></span></div>
						<input type="date" name="fflightDate<?php echo $fNum; ?>" id="fflightDate<?php echo $fNum; ?>" value="<?= date('Y-m-d',strtotime($flightQueryData['fromDate'])); ?>" class="gridfield1" displayname="ROI Value" style="width:110px;">
					</label>
				</div>
				</td>
				<td >
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">From&nbsp;<span class="redmind"></span></div>
						
						<select name="flightFromDestionation<?php echo $fNum; ?>" id="flightFromDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Flight Destination" style="padding: 6px !important; width: 141px !important;">
						<?php 
						$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
						while($fromDestD = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $fromDestD['id']; ?>" <?php if($flightQueryData['fromDestination']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>
	
				<td colspan="2">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">To&nbsp;<span class="redmind"></span></div>
						
						<select name="flightToDestionation<?php echo $fNum; ?>" id="flightToDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Flight Destination" style="padding: 6px !important; width: 120px !important;">
						<?php 
						$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
						while($toDestD = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $toDestD['id']; ?>" <?php if($flightQueryData['toDestination']==$toDestD['id']){ echo 'selected'; } ?> ><?php echo $toDestD['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>
	
				<td>
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Flight&nbsp;Name<span class="redmind"></span></div>
					<select name="flightNameId<?php echo $fNum; ?>" id="flightNameId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Flight Name" style="padding: 6px !important; width: 141px !important;">
						<option value="0">Select</option>
						<?php 
						$rsFQuery = GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' flightName!="" and status=1 order by flightName asc');
						 while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){
	
							?>
							<option value="<?php echo $GuideData5['id']; ?>"><?php echo strip($GuideData5['flightName']); ?></option>
							<?php
						}
						?>
					</select>
					</label>
				</div>
				</td> 
	
				<td colspan="2">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Flight&nbsp;Number<span class="redmind"></span></div>
						<input type="text" name="fflightNumber<?php echo $fNum; ?>" id="fflightNumber<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="ROI Value" style="width:110px;">
					</label>
				</div>
				</td>
	
				<td colspan="2">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Flight&nbsp;Class<span class="redmind"></span></div>
						<select id="fflightClass<?php echo $fNum; ?>" name="fflightClass<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:122px;">
							<option value="First_Class" >First Class</option>
							<option value="Business_Class" >Business Class</option>
							<option value="Economy_Class" >Economy Class</option>
							<option value="Premium_Economy_Class" >Premium Economy Class</option>
						</select> 
					</label>
				</div>
				</td>
	
				<td style="width: 10%;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
					<select name="fcurrencyId<?php echo $fNum; ?>" id="fcurrencyId<?php echo $fNum; ?>" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
						<option value="">Select</option>
						<?php  
						$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
						$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);
	
						$rsc2='';
						$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
						 while($currencyData=mysqli_fetch_array($rsc2)){
						?>
						<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
						<?php
						 }
						?>
					</select>
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="fcurrencyValue<?php echo $fNum; ?>" id="fcurrencyValue132<?php echo $fNum; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
					</label>
				</div>
				</td>
				</tr>
				<tr>
	
			
	
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1" style="text-align:center;">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="fadultCost<?php echo $fNum; ?>" id="fadultCost<?php echo $fNum; ?>" value="" class="gridfield1" oninput="calculateAdultCost<?php echo $fNum; ?>();" placeholder="Base Fare" displayname="Adult Cost" style="width:60px; display:inline-block;">
						
						<input type="text" name="airlineTaxA<?php echo $fNum; ?>" id="airlineTaxA<?php echo $fNum; ?>" value="" class="gridfield1" oninput="calculateAdultCost<?php echo $fNum; ?>();" placeholder="Airline Tax" displayname="Adult Cost" style="width:60px; display:inline-block;">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
						<input type="text" name="totalCostA<?php echo $fNum; ?>" id="totalCostA<?php echo $fNum; ?>" value="<?php echo $visaRq['totalAdultCost'] ?>" class="gridfield1" style="width: 60px !important;">
					 </label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(A)</div>	
						<input type="text" name="flightAdult<?php echo $fNum; ?>" id="flightAdult<?php echo $fNum; ?>" value="<?php echo $quotationData['adult']; ?>" class="gridfield1" style="width: 40px !important;">
					 </label>
				</div>
				</td>
						<script>
							function calculateAdultCost<?php echo $fNum; ?>(){
								var adultCost = Number($("#fadultCost<?php echo $fNum; ?>").val());
								var adultTax = Number($("#airlineTaxA<?php echo $fNum; ?>").val());
	
								var totalCost = adultCost+adultTax;
								$("#totalCostA<?php echo $fNum; ?>").val(totalCost);
							}
						</script>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1" style="text-align: center;">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="fchildCost<?php echo $fNum; ?>" oninput="calculateChildCost<?php echo $fNum; ?>();" id="fchildCost<?php echo $fNum; ?>" value="" class="gridfield1" placeholder="Base Fare" displayname="Child Cost" style="width:60px; display:inline-block;">
	
						<input type="text" name="airlineTaxC<?php echo $fNum; ?>" oninput="calculateChildCost<?php echo $fNum; ?>();" id="airlineTaxC<?php echo $fNum; ?>" value="" class="gridfield1" placeholder="Airline Tax" displayname="Adult Cost" style="width:60px; display:inline-block;">
						
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
						<input type="text" name="totalCostC<?php echo $fNum; ?>" id="totalCostC<?php echo $fNum; ?>" value="<?php echo $visaRq['totalChildCost'] ?>" class="gridfield1" style="width: 60px !important;">
					 </label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(C)</div>	
						<input type="text" name="flightChild<?php echo $fNum; ?>" id="flightChild<?php echo $fNum; ?>" value="<?php echo $quotationData['child']; ?>" class="gridfield1" style="width: 40px !important;">
					 </label>
				</div>
				</td>
	
				<script>
					function calculateChildCost<?php echo $fNum; ?>(){
						var childCost = Number($("#fchildCost<?php echo $fNum; ?>").val());
						var childTax = Number($("#airlineTaxC<?php echo $fNum; ?>").val());
	
						var totalCost = childCost+childTax;
						$("#totalCostC<?php echo $fNum; ?>").val(totalCost);
					}
				</script>
	
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1" style="text-align: center;">Infant&nbsp;Cost</div>
						<input type="text" name="finfantCost<?php echo $fNum; ?>" id="finfantCost<?php echo $fNum; ?>" value="" oninput="calculateInfantCost<?php echo $fNum; ?>();" class="gridfield1" placeholder="Base Fare" displayname="Infant Cost" style="width:60px; display:inline-block;">
						
						<input type="text" name="airlineTaxE<?php echo $fNum; ?>" id="airlineTaxE<?php echo $fNum; ?>" value="" oninput="calculateInfantCost<?php echo $fNum; ?>();" class="gridfield1" placeholder="Airline Tax" displayname="Infant Cost" style="width:60px; display:inline-block;">
					</label>
				</div>
				</td>
	
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
						<input type="text" name="totalCostE<?php echo $fNum; ?>" id="totalCostE<?php echo $fNum; ?>" value="<?php echo $visaRq['totalChildCost'] ?>" class="gridfield1" style="width: 60px !important;">
					 </label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(I)</div>	
						<input type="text" name="flightInfant<?php echo $fNum; ?>" id="flightInfant<?php echo $fNum; ?>" value="<?php echo $quotationData['infant']; ?>" class="gridfield1" style="width: 40px !important;">
					 </label>
				</div>
				</td>
				
				<script>
					function calculateInfantCost<?php echo $fNum; ?>(){
						var infantCost = Number($("#finfantCost<?php echo $fNum; ?>").val());
						var infantTax = Number($("#airlineTaxE<?php echo $fNum; ?>").val());
	
						var totalCost = infantCost+infantTax;
						$("#totalCostE<?php echo $fNum; ?>").val(totalCost);
					}
				</script>
					<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="visaGstTaxId<?php echo $fNum; ?>" name="visaGstTaxId<?php echo $fNum; ?>" class="gridfield" displayname="GST" autocomplete="off" style="width: 120px;padding: 6px !important;">
												<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($visaQuotData['gstTax']==$gstSlabData['id']){ echo 'selected'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>
				<td align="left"  >
						<div class="griddiv">
							<label>
								<div class="gridlable gridlable1">Fee&nbsp;Type<span class="redmind"></span></div>
								<select name="fProcessingFeeType<?php echo $fNum; ?>" id="fProcessingFeeType<?php echo $fNum; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 70px !important;">
									<option value="1">%</option>
									<option value="2">Flat(PP)</option>
								</select>
							</label>
						</div>
					</td> 
	
					<td align="left"  >
						<div class="griddiv">
							<label>
								<div class="gridlable gridlable1">P.&nbsp;Fee</div>
								<input type="text" name="fprocessingFee<?php echo $fNum; ?>" id="fprocessingFee<?php echo $fNum; ?>" class="gridfield1" displayname="Processing Fee" style="width: 60px !important;">
							</label>
						</div>
					</td> 
				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addFlightCostToQuotation('<?php echo $fNum; ?>');" >Select</div></td>
				<td align="center">
				<!-- <div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewFlightToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div> -->
				</td>
			</tr> 
			<?php $fNum++;	}
				}else{ ?> 
				<tr>
				<td >
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="flightSupplier<?php echo $fNum; ?>" id="flightSupplier<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 141px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && airlinesType="7" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>" <?php if($insSuppData['id']==$insuranceQuotData['countryId']){ echo 'selected'; } ?>><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
			<td colspan="2">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Flight&nbsp;Date<span class="redmind"></span></div>
						<input type="date" name="fflightDate<?php echo $fNum; ?>" id="fflightDate<?php echo $fNum; ?>" value="<?= date('Y-m-d'); ?>" class="gridfield1" displayname="ROI Value" style="width:110px;">
					</label>
				</div>
				</td>
				<td >
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">From&nbsp;<span class="redmind"></span></div>
						
						<select name="flightFromDestionation<?php echo $fNum; ?>" id="flightFromDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Flight Destination" style="padding: 6px !important; width: 141px !important;">
						<option value="">Select Destination</option>
						<?php 
						$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
						while($fromDestD = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $fromDestD['id']; ?>" <?php if($flightQueryData['fromDestination']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>
	
				<td colspan="2">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">To&nbsp;<span class="redmind"></span></div>
						
						<select name="flightToDestionation<?php echo $fNum; ?>" id="flightToDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Flight Destination" style="padding: 6px !important; width: 120px !important;">
						<option value="">Select Destination</option>
						<?php 
						$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
						while($toDestD = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $toDestD['id']; ?>" <?php if($flightQueryData['toDestination']==$toDestD['id']){ echo 'selected'; } ?> ><?php echo $toDestD['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>
	
				<td >
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Flight&nbsp;Name<span class="redmind"></span></div>
					<select name="flightNameId<?php echo $fNum; ?>" id="flightNameId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Flight Name" style="padding: 6px !important; width: 141px !important;">
						<option value="0">Select</option>
						<?php 
						$rsFQuery = GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' flightName!="" and status=1 order by flightName asc');
						 while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){
	
							?>
							<option value="<?php echo $GuideData5['id']; ?>"><?php echo strip($GuideData5['flightName']); ?></option>
							<?php
						}
						?>
					</select>
					</label>
				</div>
				</td> 
	
				<td colspan="2">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Flight&nbsp;Number<span class="redmind"></span></div>
						<input type="text" name="fflightNumber<?php echo $fNum; ?>" id="fflightNumber<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="ROI Value" style="width:110px;">
					</label>
				</div>
				</td>
	
				<td >
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Flight&nbsp;Class<span class="redmind"></span></div>
						<select id="fflightClass<?php echo $fNum; ?>" name="fflightClass<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:122px;">
							<option value="First_Class" >First Class</option>
							<option value="Business_Class" >Business Class</option>
							<option value="Economy_Class" >Economy Class</option>
							<option value="Premium_Economy_Class" >Premium Economy Class</option>
						</select> 
					</label>
				</div>
				</td>
	
				<td style="width: 10%;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
					<select name="fcurrencyId<?php echo $fNum; ?>" id="fcurrencyId<?php echo $fNum; ?>" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
						<option value="">Select</option>
						<?php  
						$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
						$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);
	
						$rsc2='';
						$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
						 while($currencyData=mysqli_fetch_array($rsc2)){
						?>
						<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
						<?php
						 }
						?>
					</select>
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="fcurrencyValue<?php echo $fNum; ?>" id="fcurrencyValue132<?php echo $fNum; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
					</label>
				</div>
				</td>
				</tr>
				<tr>
	
			
	
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1" style="text-align:center;">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="fadultCost<?php echo $fNum; ?>" id="fadultCost<?php echo $fNum; ?>" value="" class="gridfield1" oninput="calculateAdultCost<?php echo $fNum; ?>();" placeholder="Base Fare" displayname="Adult Cost" style="width:60px; display:inline-block;">
						
						<input type="text" name="airlineTaxA<?php echo $fNum; ?>" id="airlineTaxA<?php echo $fNum; ?>" value="" class="gridfield1" oninput="calculateAdultCost<?php echo $fNum; ?>();" placeholder="Airline Tax" displayname="Adult Cost" style="width:60px; display:inline-block;">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
						<input type="text" name="totalCostA<?php echo $fNum; ?>" id="totalCostA<?php echo $fNum; ?>" value="<?php echo $visaRq['totalAdultCost'] ?>" class="gridfield1" style="width: 60px !important;">
					 </label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(A)</div>	
						<input type="text" name="flightAdult<?php echo $fNum; ?>" id="flightAdult<?php echo $fNum; ?>" value="<?php echo $quotationData['adult']; ?>" class="gridfield1" style="width: 40px !important;">
					 </label>
				</div>
				</td>
						<script>
							function calculateAdultCost<?php echo $fNum; ?>(){
								var adultCost = Number($("#fadultCost<?php echo $fNum; ?>").val());
								var adultTax = Number($("#airlineTaxA<?php echo $fNum; ?>").val());
	
								var totalCost = adultCost+adultTax;
								$("#totalCostA<?php echo $fNum; ?>").val(totalCost);
							}
						</script>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1" style="text-align: center;">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="fchildCost<?php echo $fNum; ?>" oninput="calculateChildCost<?php echo $fNum; ?>();" id="fchildCost<?php echo $fNum; ?>" value="" class="gridfield1" placeholder="Base Fare" displayname="Child Cost" style="width:60px; display:inline-block;">
	
						<input type="text" name="airlineTaxC<?php echo $fNum; ?>" oninput="calculateChildCost<?php echo $fNum; ?>();" id="airlineTaxC<?php echo $fNum; ?>" value="" class="gridfield1" placeholder="Airline Tax" displayname="Adult Cost" style="width:60px; display:inline-block;">
						
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
						<input type="text" name="totalCostC<?php echo $fNum; ?>" id="totalCostC<?php echo $fNum; ?>" value="<?php echo $visaRq['totalChildCost'] ?>" class="gridfield1" style="width: 60px !important;">
					 </label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(C)</div>	
						<input type="text" name="flightChild<?php echo $fNum; ?>" id="flightChild<?php echo $fNum; ?>" value="<?php echo $quotationData['child']; ?>" class="gridfield1" style="width: 40px !important;">
					 </label>
				</div>
				</td>
	
				<script>
					function calculateChildCost<?php echo $fNum; ?>(){
						var childCost = Number($("#fchildCost<?php echo $fNum; ?>").val());
						var childTax = Number($("#airlineTaxC<?php echo $fNum; ?>").val());
	
						var totalCost = childCost+childTax;
						$("#totalCostC<?php echo $fNum; ?>").val(totalCost);
					}
				</script>
	
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1" style="text-align: center;">Infant&nbsp;Cost</div>
						<input type="text" name="finfantCost<?php echo $fNum; ?>" id="finfantCost<?php echo $fNum; ?>" value="" oninput="calculateInfantCost<?php echo $fNum; ?>();" class="gridfield1" placeholder="Base Fare" displayname="Infant Cost" style="width:60px; display:inline-block;">
						
						<input type="text" name="airlineTaxE<?php echo $fNum; ?>" id="airlineTaxE<?php echo $fNum; ?>" value="" oninput="calculateInfantCost<?php echo $fNum; ?>();" class="gridfield1" placeholder="Airline Tax" displayname="Infant Cost" style="width:60px; display:inline-block;">
					</label>
				</div>
				</td>
	
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
						<input type="text" name="totalCostE<?php echo $fNum; ?>" id="totalCostE<?php echo $fNum; ?>" value="<?php echo $visaRq['totalChildCost'] ?>" class="gridfield1" style="width: 60px !important;">
					 </label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(I)</div>	
						<input type="text" name="flightInfant<?php echo $fNum; ?>" id="flightInfant<?php echo $fNum; ?>" value="<?php echo $quotationData['infant']; ?>" class="gridfield1" style="width: 40px !important;">
					 </label>
				</div>
				</td>
				
				<script>
					function calculateInfantCost<?php echo $fNum; ?>(){
						var infantCost = Number($("#finfantCost<?php echo $fNum; ?>").val());
						var infantTax = Number($("#airlineTaxE<?php echo $fNum; ?>").val());
	
						var totalCost = infantCost+infantTax;
						$("#totalCostE<?php echo $fNum; ?>").val(totalCost);
					}
				</script>
				<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="visaGstTaxId" name="visaGstTaxId" class="gridfield" displayname="GST" autocomplete="off" style="width: 120px;padding: 6px !important;">
												<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($visaQuotData['gstTax']==$gstSlabData['id']){ echo 'selected'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>
				<td align="left"  >
						<div class="griddiv">
							<label>
								<div class="gridlable gridlable1">Fee&nbsp;Type<span class="redmind"></span></div>
								<select name="fProcessingFeeType<?php echo $fNum; ?>" id="fProcessingFeeType<?php echo $fNum; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 70px !important;">
									<option value="1">%</option>
									<option value="2">Flat(PP)</option>
								</select>
							</label>
						</div>
					</td> 
	
					<td align="left"  >
						<div class="griddiv">
							<label>
								<div class="gridlable gridlable1">P.&nbsp;Fee</div>
								<input type="text" name="fprocessingFee<?php echo $fNum; ?>" id="fprocessingFee<?php echo $fNum; ?>" class="gridfield1" displayname="Processing Fee" style="width: 60px !important;">
							</label>
						</div>
					</td> 
				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addFlightCostToQuotation('<?php echo $fNum; ?>');" >Select</div></td>
				<td align="center">
				<!-- <div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewFlightToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div> -->
				</td>
			</tr> 
			
		<?php } ?>
		</tbody>
	</table>
	<?php 
	//}
	
	$qflightQuery = GetPageRecord('*','quotationFlightMaster','quotationId="'.$quotationId.'"');
	if(mysqli_num_rows($qflightQuery)>0){
	?>
	
	<table border="1" width="90%" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
			<tr>
				<th>Date</th>
				<th>Supplier</th>
				<th>From</th>
				<th>To</th>
				<th>Flight Name</th>
				<th>Flight Number</th>
				<th>Flight Class</th>
				<th>Currency[ROE]</th>
				<!-- <th>Fee&nbsp;Type</th> -->
				<th>P.&nbsp;Fee</th>
				<th>Adult</th>
				<th>Child</th>
				<th>Infant</th>
				<th>Adult Cost</th>
				<th>Child Cost</th>
				<th>Infant Cost</th>
				<th>#</th>
				<th>#</th>
				
			</tr>
			<?php 
			while($quotFlightData = mysqli_fetch_assoc($qflightQuery)){ 
	
				$rs5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$quotFlightData['flightId'].'"');
				$flightData=mysqli_fetch_array($rs5);
				$currencyId = $quotFlightData['currencyId'];
				$currencyValue = ($quotFlightData['currencyValue']>0)?$quotFlightData['currencyValue']:getCurrencyVal($currencyId);
				?>
				<tr>
				<td align="center"><div style="width: 80px;"><?php if($quotFlightData['departureDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($quotFlightData['departureDate'])); } ?></div></td>
				<td align="center"><?php echo getSupplierName($quotFlightData['supplierId']); ?></td>
				<td align="center"><?php echo getDestination($quotFlightData['departureFrom']); ?></td>
				<td align="center"><?php echo getDestination($quotFlightData['arrivalTo']); ?></td>
				<td align="center"><?php echo $flightData['flightName']; ?></td>
				<td align="center"><?php echo $quotFlightData['flightNumber']; ?></td>
				<td align="center"><?php echo str_replace("_"," ",$quotFlightData['flightClass']); ?></td>
				<td align="center"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
				<td align="center"><?php echo ($quotFlightData['markupCost']); echo ($quotFlightData['markupType']==1)?'&nbsp;%':'&nbsp;Flat'; ?></td>
				<td align="center"><?php echo ($quotFlightData['adultPax']); ?></td>
				<td align="center"><?php echo ($quotFlightData['childPax']); ?></td>
				<td align="center"><?php echo ($quotFlightData['infantPax']); ?></td>
				<td align="left" width="100">
					<?php echo '<b>Base&nbsp;Fare:</b> '.($quotFlightData['adultCost']); ?>
					<?php echo '<br><b>Airline&nbsp;Tax:</b> '.($quotFlightData['adultTax']); ?>
					<?php echo '<br><b>Total&nbsp;Cost:</b> '.($quotFlightData['totalAdultCost']); ?>
				</td>
				<td align="left" width="100">
					<?php echo '<b>Base&nbsp;Fare:</b> '.($quotFlightData['childCost']); ?>
					<?php echo '<br><b>Airline&nbsp;Tax:</b> '.($quotFlightData['childTax']); ?>
					<?php echo '<br><b>Total&nbsp;Cost:</b> '.($quotFlightData['totalChildCost']); ?>
				</td>
	
	
				<td align="left"  width="100">
					<?php echo '<b>Base&nbsp;Fare:</b> '.($quotFlightData['infantCost']); ?>
					<?php echo '<br><b>Airline&nbsp;Tax:</b> '.($quotFlightData['infantTax']); ?>
					<?php echo '<br><b>Total&nbsp;Cost:</b> '.($quotFlightData['totalInfantCost']); ?>
				</td>
			
				<td align="center"><div class="editbtnselect" id="selectthis" style="margin-top: 0px !important;" onclick="openinboundpop('action=editQuotationFlightCost&editId=<?php echo $quotFlightData['id'] ?>&quotationId=<?php echo $quotFlightData['quotationId'] ?>');" >Edit
				</div></td>
				<td width="" align="center"><div><span style="color: #60ba3b; cursor: pointer; margin: 0px 5px;" ></span><span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure! you want to delete this Flight Rate?')){ deleteFlightQuotationRate('<?php echo $quotFlightData['id'] ?>','<?php echo $quotFlightData['quotationId'] ?>','deleteFlightQuotationRate'); $('#addnl<?php echo $quotFlightData['id'];?>').remove(); }" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
			</tr>
				<?php } ?>
	</table>
	<?php } ?>
	</div>
	<div id="selectFlightcost"></div>
	<script>
		function selectFlightCost(id){
			var flightNameId=0;
			flightNameId = $("#flightNameId").val();
			if(flightNameId>0){
				$("#selectFlightcost").load('searchaction.php?action=selectFlightCost&visaTypeId='+id+'&flightNameId='+flightNameId);
			}else{
				alert("Please Select Flight Name First");
			}
		}
	
		function addFlightCostToQuotation(num){
			
	
			var processingFee = $("#fprocessingFee"+num).val();
			var ProcessingFeeType = $("#fProcessingFeeType"+num).val();
			var fflightDate = $("#fflightDate"+num).val();
			var flightNameId = $("#flightNameId"+num).val();
			var fflightNumber = $("#fflightNumber"+num).val();
			var fflightClass = $("#fflightClass"+num).val();
			var adultCost = $("#fadultCost"+num).val();
			var childCost = $("#fchildCost"+num).val();
			var infantCost = $("#finfantCost"+num).val();
			var adultPax = $("#FadultPax"+num).val();
			var childPax = $("#FchildPax"+num).val();
			var infantPax = $("#FinfantPax"+num).val();
			var currencyId = $("#fcurrencyId"+num).val();
			var currencyValue132 = $("#fcurrencyValue132"+num).val();
			var flightFromDestionation = $("#flightFromDestionation"+num).val();
			var flightToDestionation = $("#flightToDestionation"+num).val();
			var airlineTaxA = $("#airlineTaxA"+num).val();
			var totalCostA = $("#totalCostA"+num).val();
			var airlineTaxC = $("#airlineTaxC"+num).val();
			var totalCostC = $("#totalCostC"+num).val();
			var airlineTaxE = $("#airlineTaxE"+num).val();
			var totalCostE = $("#totalCostE"+num).val();
			var flightAdult = $("#flightAdult"+num).val();
			var flightChild = $("#flightChild"+num).val();
			var flightInfant = $("#flightInfant"+num).val();
			var flightSupplier = $("#flightSupplier"+num).val();
			var visaGstTaxId = $("#visaGstTaxId"+num).val();
			
		
			if(flightNameId>0){
	
			$("#selectFlightcost").load('loadValueAddedserviceCost.php?action=saveFlightCosttoQuotation&flightNameId='+flightNameId+'&flightNumber='+fflightNumber+'&flightClass='+fflightClass+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&currencyId='+currencyId+'&currencyValue='+currencyValue132+'&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&flightFromDestionation='+encodeURI(flightFromDestionation)+'&flightToDestionation='+encodeURI(flightToDestionation)+'&flightDate='+encodeURI(fflightDate)+'&processingFee='+encodeURI(processingFee)+'&ProcessingFeeType='+encodeURI(ProcessingFeeType)+'&airlineTaxA='+airlineTaxA+'&totalCostA='+totalCostA+'&airlineTaxC='+airlineTaxC+'&totalCostC='+totalCostC+'&airlineTaxE='+airlineTaxE+'&totalCostE='+totalCostE+'&adult='+flightAdult+'&child='+flightChild+'&infant='+flightInfant+'&flightSupplier='+flightSupplier+'&visaGstTaxId='+visaGstTaxId);
			}else{
				alert('Please, Select Flight Name');
			}
		}
	</script>
	<?php
	}
	?>
		<script>
			 parent.loadquotationmainfile();
		</script>
		<?php
	}
	
	


// Train Rate code starts ===========================================
if($_REQUEST['action']=="trainRequirementAct" && $_REQUEST['quotationId']!=""){

$quotationId = $_REQUEST['quotationId'];
$trainRequired = $_REQUEST['trainRequired'];

$nameValue = 'trainRequired="'.$trainRequired.'"';
$where = 'id="'.$quotationId.'"';
updatelisting('quotationMaster',$nameValue,$where);

$quQuery = GetPageRecord('trainRequired,id,adult,child,infant,currencyId,queryId',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
$quotationData = mysqli_fetch_assoc($quQuery);

if($quotationData['trainRequired']==2){
?>
<style>
	.gridfield1{
		padding: 4px;
		width: 70px;
	}
	.editbtnselect{
	background-color: #75C38D;
    padding: 6px 10px;
    font-size: 15px;
    font-weight: 500;
    color: #fff;
    margin-top: 12px;
	cursor: pointer;
	text-align: center;
	border-radius: 3px;
	}
	.gridlable1{
		font-size: 14px;
		
	}
	.valueAdd{
		font-size: 15px;
	}
</style>
<div style="background-color: #EAE9EE;padding: 10px;border: 4px solid #fff;">
<table width="60%" cellpadding="5" cellspacing="0" >
<tr><td colspan="5"><h4 class="valueAdd">Add Train Rate</h4></td></tr>
			<?php 
			$fNum='';
			$rsT = GetPageRecord('*','trainQueryMaster','queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'"');
			if(mysqli_num_rows($rsT)>0){
				while($trainQueryData = mysqli_fetch_assoc($rsT)){

			?>
		<tr>
		<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Date<span class="redmind"></span></div>
					<input type="date" name="trainDate<?php echo $fNum; ?>" id="trainDate<?php echo $fNum; ?>" value="<?= date('Y-m-d',strtotime($trainQueryData['fromDate'])); ?>" class="gridfield1" displayname="ROI Value" style="width:105px;">
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">From&nbsp;Destination<span class="redmind"></span></div>
					
					<select name="trainFromDestionation<?php echo $fNum; ?>" id="trainFromDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Train Destination" style="padding: 6px !important; width: 114px !important;">
					<?php 
					$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
					while($fromDestD = mysqli_fetch_assoc($rsFD)){
						?>
						<option value="<?php echo $fromDestD['id']; ?>" <?php if($trainQueryData['fromDestination']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
						<?php
					}
					?>
					</select>
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">To&nbsp;Destination<span class="redmind"></span></div>
					
					<select name="trainToDestionation<?php echo $fNum; ?>" id="trainToDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Train Destination" style="padding: 6px !important; width: 112px !important;">
					<?php 
					$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
					while($toDestD = mysqli_fetch_assoc($rsFD)){
						?>
						<option value="<?php echo $toDestD['id']; ?>" <?php if($trainQueryData['toDestination']==$toDestD['id']){ echo 'selected'; } ?> ><?php echo $toDestD['name']; ?></option>
						<?php
					}
					?>
					</select>
				</label>
			</div>
			</td>

			<td style="width: 100px">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Train&nbsp;Name<span class="redmind"></span></div>
				<select name="trainNameId<?php echo $fNum; ?>" id="trainNameId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Train Name" style="padding: 6px !important; width: 136px !important;">
					<option value="0">Select</option>
					<?php 
					$rsFQuery = GetPageRecord('*','packageBuilderTrainsMaster',' trainName!="" and status=1 order by trainName asc');
				 	while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){

						?>
						<option value="<?php echo $GuideData5['id']; ?>"><?php echo strip($GuideData5['trainName']); ?></option>
						<?php
					}
					?>
				</select>
				</label>
			</div>
			</td> 

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Number<span class="redmind"></span></div>
					<input type="text" name="ftrainNumber<?php echo $fNum; ?>" id="ftrainNumber<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="ROI Value" style="width:100px;">
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Class<span class="redmind"></span></div>
					<select id="ftrainClass<?php echo $fNum; ?>" name="ftrainClass<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:110px;">
						<option value="AC First Class" >AC First Class</option>
						<option value="AC 2-Tier" >AC 2-Tier</option>
						<option value="AC 3-Tier" >AC 3-Tier</option>
						<option value="First Class" >First Class</option>
						<option value="AC Chair Car" >AC Chair Car</option>
						<option value="Second Sitting" >Second Sitting</option>
						<option value="Sleeper" >Sleeper</option>
					</select> 
				</label>
			</div>
			</td>

			<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
				<select name="tcurrencyId<?php echo $fNum; ?>" id="tcurrencyId<?php echo $fNum; ?>" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
					<?php  
					$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
					$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);

					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
					<?php
				 	}
					?>
				</select>
				</label>
			</div>
			</td>
			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input type="text" name="tcurrencyValue<?php echo $fNum; ?>" id="tcurrencyValue<?php echo $fNum; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
				</label>
			</div>
			</td>
			</tr>
			<tr>
			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="tadultCost<?php echo $fNum; ?>" id="tadultCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Adult Cost" style="width:103px;">
					<input type="hidden" name="FadultPax" id="FadultPax" value="<?php echo $quotationData['adult'] ?>" >
				</label>
			</div>
			</td>
		

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="tchildCost<?php echo $fNum; ?>" id="tchildCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Child Cost" style="width:100px;">
					<input type="hidden" name="FchildPax" id="FchildPax" value="<?php echo $quotationData['child'] ?>" >
				</label>
			</div>
			</td>
		

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable">Infant&nbsp;Cost</div>
					<input type="text" name="tinfantCost<?php echo $fNum; ?>" id="tinfantCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Infant Cost" style="width:100px;">
					<input type="hidden" name="FinfantPax" id="FinfantPax" value="<?php echo $quotationData['infant'] ?>" >
				</label>
			</div>
			</td>

			<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee&nbsp;Type<span class="redmind"></span></div>
							<select name="tProcessingFeeType<?php echo $fNum; ?>" id="tProcessingFeeType<?php echo $fNum; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1">%</option>
								<option value="2">Flat(PP)</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="tprocessingFee<?php echo $fNum; ?>" id="tprocessingFee<?php echo $fNum; ?>" class="gridfield1" displayname="Processing Fee" style="width: 104px !important;">
						</label>
					</div>
				</td> 
		
	
			<td align="center">
			<div class="editbtnselect" id="selectthis" onclick="addTrainCostToQuotation('<?php echo $fNum; ?>');" >Select</div></td>
			<td align="center">
			<!-- <div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewFlightToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div> -->
			</td>
		</tr> 
		<?php $fNum++;	}
			}else{ ?>

<tr>
		<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Date<span class="redmind"></span></div>
					<input type="date" name="trainDate<?php echo $fNum; ?>" id="trainDate<?php echo $fNum; ?>" value="<?= date('Y-m-d',strtotime('now')); ?>" class="gridfield1" displayname="ROI Value" style="width:105px;">
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">From&nbsp;Destination<span class="redmind"></span></div>
					
					<select name="trainFromDestionation<?php echo $fNum; ?>" id="trainFromDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Train Destination" style="padding: 6px !important; width: 114px !important;">
					<?php 
					$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
					while($fromDestD = mysqli_fetch_assoc($rsFD)){
						?>
						<option value="<?php echo $fromDestD['id']; ?>" <?php if($trainQueryData['fromDestination']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
						<?php
					}
					?>
					</select>
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">To&nbsp;Destination<span class="redmind"></span></div>
					
					<select name="trainToDestionation<?php echo $fNum; ?>" id="trainToDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Train Destination" style="padding: 6px !important; width: 112px !important;">
					<?php 
					$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
					while($toDestD = mysqli_fetch_assoc($rsFD)){
						?>
						<option value="<?php echo $toDestD['id']; ?>" <?php if($trainQueryData['toDestination']==$toDestD['id']){ echo 'selected'; } ?> ><?php echo $toDestD['name']; ?></option>
						<?php
					}
					?>
					</select>
				</label>
			</div>
			</td>

			<td style="width: 100px">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Train&nbsp;Name<span class="redmind"></span></div>
				<select name="trainNameId<?php echo $fNum; ?>" id="trainNameId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Train Name" style="padding: 6px !important; width: 136px !important;">
					<option value="0">Select</option>
					<?php 
					$rsFQuery = GetPageRecord('*','packageBuilderTrainsMaster',' trainName!="" and status=1 order by trainName asc');
				 	while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){

						?>
						<option value="<?php echo $GuideData5['id']; ?>"><?php echo strip($GuideData5['trainName']); ?></option>
						<?php
					}
					?>
				</select>
				</label>
			</div>
			</td> 

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Number<span class="redmind"></span></div>
					<input type="text" name="ftrainNumber<?php echo $fNum; ?>" id="ftrainNumber<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="ROI Value" style="width:100px;">
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Class<span class="redmind"></span></div>
					<select id="ftrainClass<?php echo $fNum; ?>" name="ftrainClass<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:110px;">
						<option value="AC First Class" >AC First Class</option>
						<option value="AC 2-Tier" >AC 2-Tier</option>
						<option value="AC 3-Tier" >AC 3-Tier</option>
						<option value="First Class" >First Class</option>
						<option value="AC Chair Car" >AC Chair Car</option>
						<option value="Second Sitting" >Second Sitting</option>
						<option value="Sleeper" >Sleeper</option>
					</select> 
				</label>
			</div>
			</td>

			<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
				<select name="tcurrencyId<?php echo $fNum; ?>" id="tcurrencyId<?php echo $fNum; ?>" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
					<?php  
					$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
					$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);

					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
					<?php
				 	}
					?>
				</select>
				</label>
			</div>
			</td>
			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input type="text" name="tcurrencyValue<?php echo $fNum; ?>" id="tcurrencyValue<?php echo $fNum; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
				</label>
			</div>
			</td>
			</tr>
			<tr>
			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="tadultCost<?php echo $fNum; ?>" id="tadultCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Adult Cost" style="width:103px;">
					<input type="hidden" name="FadultPax" id="FadultPax" value="<?php echo $quotationData['adult'] ?>" >
				</label>
			</div>
			</td>
		

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="tchildCost<?php echo $fNum; ?>" id="tchildCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Child Cost" style="width:100px;">
					<input type="hidden" name="FchildPax" id="FchildPax" value="<?php echo $quotationData['child'] ?>" >
				</label>
			</div>
			</td>
		

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable">Infant&nbsp;Cost</div>
					<input type="text" name="tinfantCost<?php echo $fNum; ?>" id="tinfantCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Infant Cost" style="width:100px;">
					<input type="hidden" name="FinfantPax" id="FinfantPax" value="<?php echo $quotationData['infant'] ?>" >
				</label>
			</div>
			</td>
					
			<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee&nbsp;Type<span class="redmind"></span></div>
							<select name="tProcessingFeeType<?php echo $fNum; ?>" id="tProcessingFeeType<?php echo $fNum; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1">%</option>
								<option value="2">Flat(PP)</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="tprocessingFee<?php echo $fNum; ?>" id="tprocessingFee<?php echo $fNum; ?>" class="gridfield1" displayname="Processing Fee" style="width: 104px !important;">
						</label>
					</div>
				</td> 
	
			<td align="center">
			<div class="editbtnselect" id="selectthis" onclick="addTrainCostToQuotation('<?php echo $fNum; ?>');" >Select</div></td>
			<td align="center">
			<!-- <div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewFlightToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div> -->
			</td>
		</tr> 

		<?php } ?>
	</tbody>
</table>
<?php 
//}

$qflightQuery = GetPageRecord('*','quotationTrainsMaster','quotationId="'.$quotationId.'"');
if(mysqli_num_rows($qflightQuery)>0){
?>

<table border="1" width="80%" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
		<tr>
			<th>Date</th>
			<th>Departure&nbsp;From</th>
			<th>Arrival&nbsp;To</th>
			<th>Train Name</th>
			<th>Train Number</th>
			<th>Train Class</th>
			<th>Currency[ROE]</th>
			<th>Adult Cost</th>
			<th>Child Cost</th>
			<th>Infant Cost</th>
			<th>Fee&nbsp;Type</th>
			<th>Fee</th>
			<th>#</th>
			<th>#</th>
		</tr>
		<?php 
		while($quotFlightData = mysqli_fetch_assoc($qflightQuery)){ 

			$rs5=GetPageRecord('*','packageBuilderTrainsMaster','id="'.$quotFlightData['trainId'].'"');
			$flightData=mysqli_fetch_array($rs5);
			$currencyId = $quotFlightData['currencyId'];
			$currencyValue = ($quotFlightData['currencyValue']>0)?$quotFlightData['currencyValue']:getCurrencyVal($currencyId);
			?>
			<tr>
			<td align="center"><?php if($quotFlightData['departureDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($quotFlightData['departureDate'])) ;} ?></td>
			<td align="center"><?php echo getDestination($quotFlightData['departureFrom']); ?></td>
			<td align="center"><?php echo getDestination($quotFlightData['arrivalTo']); ?></td>
			<td align="center"><?php echo $flightData['trainName']; ?></td>
			<td align="center"><?php echo $quotFlightData['trainNumber']; ?></td>
			<td align="center"><?php echo $quotFlightData['trainClass']; ?></td>
			<td align="center"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
			<td align="center"><?php echo ($quotFlightData['adultCost']); ?></td>
			<td align="center"><?php echo ($quotFlightData['childCost']); ?></td>
			<td align="center"><?php echo ($quotFlightData['infantCost']); ?></td>
			<td align="center"><?php echo ($quotFlightData['markupType']==1)?'%':'Flat'; ?></td>
			<td align="center"><?php echo ($quotFlightData['markupCost']); ?></td>

			<td align="center"><div class="editbtnselect" id="selectthis" style="margin-top: 0px !important;" onclick="openinboundpop('action=editQuotationTrainCost&editId=<?php echo $quotFlightData['id'] ?>&quotationId=<?php echo $quotFlightData['quotationId'] ?>');" >Edit
				</div></td>
			<td width="" align="center"><div><span style="color: #60ba3b; cursor: pointer; margin: 0px 5px;" ></span><span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure! you want to delete this Train Rate?')){ deleteTrainQuotationRate('<?php echo $quotFlightData['id'] ?>','<?php echo $quotFlightData['quotationId'] ?>','deleteTrainQuotationRate'); $('#addnl<?php echo $quotFlightData['id'];?>').remove(); }" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
		</tr>
			<?php } ?>
</table>
<?php } ?>
</div>
<div id="selectTraincost"></div>
<script>
	function selectTraincost(id){
		var flightNameId=0;
		flightNameId = $("#flightNameId").val();
		if(flightNameId>0){
			$("#selectTraincost").load('searchaction.php?action=selectTraincost&visaTypeId='+id+'&flightNameId='+flightNameId);
		}else{
			alert("Please Select Train Name First");
		}
	}


	function addTrainCostToQuotation(num){
		var trainDate = $("#trainDate"+num).val();
		var trainNameId = $("#trainNameId"+num).val();
		var ftrainNumber = $("#ftrainNumber"+num).val();
		var ftrainClass = $("#ftrainClass"+num).val();
		var adultCost = $("#tadultCost"+num).val();
		var childCost = $("#tchildCost"+num).val();
		var infantCost = $("#tinfantCost"+num).val();
		var adultPax = $("#FadultPax"+num).val();
		var childPax = $("#FchildPax"+num).val();
		var infantPax = $("#FinfantPax"+num).val();
		var tcurrencyId = $("#tcurrencyId"+num).val();
		var currencyValue132 = $("#tcurrencyValue132"+num).val();
		var tcurrencyValue = $("#tcurrencyValue"+num).val();
		var trainFromDestionation = $("#trainFromDestionation"+num).val();
		var trainToDestionation = $("#trainToDestionation"+num).val();
		var tProcessingFeeType = $("#tProcessingFeeType"+num).val();
		var tprocessingFee = $("#tprocessingFee"+num).val();
	
		if(trainNameId>0){

		$("#selectTraincost").load('loadValueAddedserviceCost.php?action=saveTrainCosttoQuotation&trainNameId='+trainNameId+'&ftrainNumber='+ftrainNumber+'&ftrainClass='+encodeURI(ftrainClass)+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&currencyId='+tcurrencyId+'&currencyValue='+currencyValue132+'&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&trainFromDestionation='+encodeURI(trainFromDestionation)+'&trainToDestionation='+encodeURI(trainToDestionation)+'&trainDate='+encodeURI(trainDate)+'&markupCost='+encodeURI(tprocessingFee)+'&markupType='+encodeURI(tProcessingFeeType));
		}else{
			alert('Please, Select Train Name');
		}
	}
</script>
<?php
}
?>
	<script>
		 parent.loadquotationmainfile();
	</script>
	<?php
}


// Transfer Rate code starts ===========================================
if($_REQUEST['action']=="transferRequirementAct" && $_REQUEST['quotationId']!=""){

	$quotationId = $_REQUEST['quotationId'];
	$transferRequired = $_REQUEST['transferRequired'];
	
	$nameValue = 'transferRequired="'.$transferRequired.'"';
	$where = 'id="'.$quotationId.'"';
	updatelisting('quotationMaster',$nameValue,$where);
	
	$quQuery = GetPageRecord('transferRequired,id,adult,child,infant,currencyId,queryId',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
	$quotationData = mysqli_fetch_assoc($quQuery);
	
	if($quotationData['transferRequired']==2){
	?>
	<style>
		.gridfield1{
			padding: 4px;
			width: 70px;
		}
		.editbtnselect{
		background-color: #75C38D;
		padding: 6px 10px;
		font-size: 15px;
		font-weight: 500;
		color: #fff;
		margin-top: 12px;
		cursor: pointer;
		text-align: center;
		border-radius: 3px;
		}
		.gridlable1{
			font-size: 14px;
			
		}
		.valueAdd{
			font-size: 15px;
		}
	</style>
	<div style="background-color: #EAE9EE;padding: 10px;border: 4px solid #fff;">
	<table width="60%" cellpadding="5" cellspacing="0" >
	<tr><td colspan="5"><h4 class="valueAdd">Add Transfer Rate</h4></td></tr>
				<?php 
				$fNum='';
				$rsT = GetPageRecord('*','transferQueryMaster','queryId="'.$quotationData['queryId'].'" and quotationId="'.$quotationId.'"');
				if(mysqli_num_rows($rsT)>0){
					while($transferQueryData = mysqli_fetch_assoc($rsT)){
	
				?>
			<tr>

			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Date<span class="redmind"></span></div>
						<input type="text" name="ttransferDate<?php echo $fNum; ?>" id="ttransferDate<?php echo $fNum; ?>"  class="gridfield1" value="<?php echo date('d-m-Y',strtotime($transferQueryData['fromDate'])); ?>" readonly displayname="Train Date">
					</label>
				</div>
				</td>
	
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Destination<span class="redmind"></span></div>
						
						<select name="TransferDestionation<?php echo $fNum; ?>" id="TransferDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Train Destination" style="padding: 6px !important; width: 114px !important;">
						<?php 
						$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
						while($fromDestD = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $fromDestD['id']; ?>" <?php if($transferQueryData['destinationId']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>
	
				<td >
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Transfer&nbsp;Type<span class="redmind"></span></div>
						
						<select name="transferType<?php echo $fNum; ?>" id="transferType<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Transfer Type" style="padding: 6px !important; width: 112px !important;">
						<?php 
						$rsFD = GetPageRecord('name,id','transferTypeMaster','name!="" and status=1 and deletestatus=0 order by name asc');
						while($transferType = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $transferType['id']; ?>" <?php if($transferQueryData['transferTypeId']==$transferType['id']){ echo 'selected'; } ?> ><?php echo $transferType['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>
	
				<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Transfer&nbsp;Name<span class="redmind"></span></div>
					<select name="transferNameId<?php echo $fNum; ?>" id="transferNameId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Train Name" style="padding: 6px !important; width: 136px !important;">
						<option value="0">Select</option>
						<?php 
						$rsFQuery = GetPageRecord('*','packageBuilderTransportMaster',' transferName!="" and status=1 order by transferName asc');
						 while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){
	
							?>
							<option value="<?php echo $GuideData5['id']; ?>" <?php if($transferQueryData['transferNameId']==$GuideData5['id']){ echo 'selected'; } ?> ><?php echo strip($GuideData5['transferName']); ?></option>
							<?php
						}
						?>
					</select>
					</label>
				</div>
				</td> 
	
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Type<span class="redmind"></span></div>
						<select name="sicpvtType<?php echo $fNum; ?>" id="sicpvtType<?php echo $fNum; ?>" onchange="selectTransferType<?php echo $fNum; ?>();" style="width:112px;">
						<option value="1">SIC</option>
						<!-- <option value="2">PVT</option> -->
						</select>
					</label>
				</div>
				</td>
	
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Vehicle&nbsp;Type<span class="redmind"></span></div>
						<select id="vehicleTypeId<?php echo $fNum; ?>" name="vehicleTypeId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:100px;padding:6px;">
							<?php 
								$rs = '';
								$rs = GetPageRecord('*','vehicleTypeMaster','name!="" and status=1');
								while($tptTypeData = mysqli_fetch_assoc($rs)){
							?>
							<option value="<?php echo $tptTypeData['id']; ?>" ><?php echo $tptTypeData['name']; ?></option>
							<?php } ?>
						</select> 
					</label>
				</div>
				</td>
	
				<td style="width: 10%;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
					<select name="tfcurrencyId<?php echo $fNum; ?>" id="tfcurrencyId<?php echo $fNum; ?>" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
						<option value="">Select</option>
						<?php  
						$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
						$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);
	
						$rsc2='';
						$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
						 while($currencyData=mysqli_fetch_array($rsc2)){
						?>
						<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
						<?php
						 }
						?>
					</select>
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="tfcurrencyValue<?php echo $fNum; ?>" id="tfcurrencyValue<?php echo $fNum; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Rep&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="repCostt<?php echo $fNum; ?>" id="repCostt<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Rep Cost">
						
					</label>
				</div>
				</td>
				</tr>

				<tr>
				<td style="padding-right: 0px;" class="SICClass<?php echo $fNum; ?>">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="tfadultCost<?php echo $fNum; ?>" id="tfadultCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Adult Cost" >
						<input type="hidden" name="FadultPax" id="FadultPax" value="<?php echo $quotationData['adult'] ?>" >
					</label>
				</div>
				</td>
		
	
				<td style="padding-right: 0px;" class="SICClass<?php echo $fNum; ?>">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="tfchildCost<?php echo $fNum; ?>" id="tfchildCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Child Cost" style="width:100px;">
						<input type="hidden" name="FchildPax" id="FchildPax" value="<?php echo $quotationData['child'] ?>" >
					</label>
				</div>
				</td>
		
	
				<td style="padding-right: 0px;" class="SICClass<?php echo $fNum; ?>">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
						<input type="text" name="tfinfantCost<?php echo $fNum; ?>" id="tfinfantCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Infant Cost" style="width:100px;">
						<input type="hidden" name="FinfantPax" id="FinfantPax" value="<?php echo $quotationData['infant'] ?>" >
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Vehicle&nbsp;Cost</div>
						<input type="text" name="vehicleCost<?php echo $fNum; ?>" id="vehicleCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Vehicle Cost">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Parking&nbsp;Fee</div>
						<input type="text" name="parkingFee<?php echo $fNum; ?>" id="parkingFee<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Parking Fee" style="width:100px;">
					
					</label>
				</div>
				</td>
				
				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Assistance&nbsp;Fee</div>
						<input type="text" name="AssistanceFee<?php echo $fNum; ?>" id="AssistanceFee<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Assistance Fee" style="width:100px;">
					
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Additional&nbsp;Allowance</div>
						<input type="text" name="additionalAllowance<?php echo $fNum; ?>" id="additionalAllowance<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Additional&nbsp;Allowance" style="width:123px;">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Inter&nbsp;State&nbsp;&&nbsp;Toll</div>
						<input type="text" name="interState<?php echo $fNum; ?>" id="interState<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Additional&nbsp;Allowance" style="width:100px;">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Misc&nbsp;Cost</div>
						<input type="text" name="misslaneousCost<?php echo $fNum; ?>" id="misslaneousCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Additional&nbsp;Allowance">
					
					</label>
				</div>
				</td>
			
				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee&nbsp;Type<span class="redmind"></span></div>
							<select name="trProcessingFeeType<?php echo $fNum; ?>" id="trProcessingFeeType<?php echo $fNum; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1">%</option>
								<option value="2">Flat(PP)</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="trprocessingFee<?php echo $fNum; ?>" id="trprocessingFee<?php echo $fNum; ?>" class="gridfield1" displayname="Processing Fee" style="width: 104px !important;">
						</label>
					</div>
				</td> 

				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addTransferCostToQuotation('<?php echo $fNum; ?>');" >Select</div></td>
				<td align="center">
				<!-- <div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewFlightToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div> -->
				</td>
			</tr> 
			<script>
					function selectTransferType<?php echo $fNum; ?>(){
					var type = $("#sicpvtType<?php echo $fNum; ?>").val();
					if(type==1){
						$(".SICClass<?php echo $fNum; ?>").show();
						$(".PVTClass<?php echo $fNum; ?>").hide();
					}
					if(type==2){
						$(".SICClass<?php echo $fNum; ?>").hide();
						$(".PVTClass<?php echo $fNum; ?>").show();
					}
				}
				selectTransferType<?php echo $fNum; ?>();
			</script>
			<?php $fNum++;	}
				}else{ ?>
	
			<tr>

			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Date<span class="redmind"></span></div>
						<input type="date" name="ttransferDate<?php echo $fNum; ?>" id="ttransferDate<?php echo $fNum; ?>"  class="gridfield1" value="<?= date('Y-m-d',strtotime('now')); ?>" displayname="Transfer Date" style="width:100px;">
					</label>
				</div>
				</td>

				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Destination<span class="redmind"></span></div>
						
						<select name="TransferDestionation<?php echo $fNum; ?>" id="TransferDestionation<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Transfer Destination" style="padding: 6px !important; width: 114px !important;">
						<?php 
						$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
						while($fromDestD = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $fromDestD['id']; ?>" <?php if($transferQueryData['destinationId']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>

				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Transfer&nbsp;Type<span class="redmind"></span></div>
						
						<select name="transferType<?php echo $fNum; ?>" id="transferType<?php echo $fNum; ?>" value="0" class="gridfield1" displayname="Transfer Type" style="padding: 6px !important; width: 112px !important;">
						<?php 
						$rsFD = GetPageRecord('name,id','transferTypeMaster','name!="" and status=1 and deletestatus=0 order by name asc');
						while($transferType = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $transferType['id']; ?>" <?php if($transferQueryData['transferTypeId']==$transferType['id']){ echo 'selected'; } ?> ><?php echo $transferType['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>

				<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Transfer&nbsp;Name<span class="redmind"></span></div>
					<select name="transferNameId<?php echo $fNum; ?>" id="transferNameId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Train Name" style="padding: 6px !important; width: 136px !important;">
						<option value="0">Select</option>
						<?php 
						$rsFQuery = GetPageRecord('*','packageBuilderTransportMaster',' transferName!="" and status=1 order by transferName asc');
						while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){

							?>
							<option value="<?php echo $GuideData5['id']; ?>" <?php if($transferQueryData['transferNameId']==$GuideData5['id']){ echo 'selected'; } ?> ><?php echo strip($GuideData5['transferName']); ?></option>
							<?php
						}
						?>
					</select>
					</label>
				</div>
				</td> 

				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Type<span class="redmind"></span></div>
						<select name="sicpvtType<?php echo $fNum; ?>" id="sicpvtType<?php echo $fNum; ?>" onchange="selectTransferType<?php echo $fNum; ?>();" style="width:112px;">
						<option value="1">SIC</option>
						<!-- <option value="2">PVT</option> -->
						</select>
					</label>
				</div>
				</td>

				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Vehicle&nbsp;Type<span class="redmind"></span></div>
						<select id="vehicleTypeId<?php echo $fNum; ?>" name="vehicleTypeId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:100px;padding:6px;">
							<?php 
								$rs = '';
								$rs = GetPageRecord('*','vehicleTypeMaster','name!="" and status=1');
								while($tptTypeData = mysqli_fetch_assoc($rs)){
							?>
							<option value="<?php echo $tptTypeData['id']; ?>" ><?php echo $tptTypeData['name']; ?></option>
							<?php } ?>
						</select> 
					</label>
				</div>
				</td>

				<td style="width: 10%;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
					<select name="tfcurrencyId<?php echo $fNum; ?>" id="tfcurrencyId<?php echo $fNum; ?>" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
						<option value="">Select</option>
						<?php  
						$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
						$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);

						$rsc2='';
						$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
						while($currencyData=mysqli_fetch_array($rsc2)){
						?>
						<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
						<?php
						}
						?>
					</select>
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="tfcurrencyValue<?php echo $fNum; ?>" id="tfcurrencyValue<?php echo $fNum; ?>" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Rep&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="repCostt<?php echo $fNum; ?>" id="repCostt<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Rep Cost">
						
					</label>
				</div>
				</td>
				</tr>

				<tr>
				<td style="padding-right: 0px;" class="SICClass<?php echo $fNum; ?>">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="tfadultCost<?php echo $fNum; ?>" id="tfadultCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Adult Cost" style="width:100px;">
						<input type="hidden" name="FadultPax" id="FadultPax" value="<?php echo $quotationData['adult'] ?>" >
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;" class="SICClass<?php echo $fNum; ?>">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="tfchildCost<?php echo $fNum; ?>" id="tfchildCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Child Cost" style="width:100px;">
						<input type="hidden" name="FchildPax" id="FchildPax" value="<?php echo $quotationData['child'] ?>" >
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;" class="SICClass<?php echo $fNum; ?>">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
						<input type="text" name="tfinfantCost<?php echo $fNum; ?>" id="tfinfantCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Infant Cost" style="width:100px;">
						<input type="hidden" name="FinfantPax" id="FinfantPax" value="<?php echo $quotationData['infant'] ?>" >
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Vehicle&nbsp;Cost</div>
						<input type="text" name="vehicleCost<?php echo $fNum; ?>" id="vehicleCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Vehicle Cost">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Parking&nbsp;Fee</div>
						<input type="text" name="parkingFee<?php echo $fNum; ?>" id="parkingFee<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Parking Fee" style="width:100px;">
					
					</label>
				</div>
				</td>
				
				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Assistance&nbsp;Fee</div>
						<input type="text" name="AssistanceFee<?php echo $fNum; ?>" id="AssistanceFee<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Assistance Fee" style="width:100px;">
					
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Additional&nbsp;Allowance</div>
						<input type="text" name="additionalAllowance<?php echo $fNum; ?>" id="additionalAllowance<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Additional&nbsp;Allowance" style="width:123px;">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Inter&nbsp;State&nbsp;&&nbsp;Toll</div>
						<input type="text" name="interState<?php echo $fNum; ?>" id="interState<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Additional&nbsp;Allowance" style="width:100px;">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass<?php echo $fNum; ?>" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Misc&nbsp;Cost</div>
						<input type="text" name="misslaneousCost<?php echo $fNum; ?>" id="misslaneousCost<?php echo $fNum; ?>" value="" class="gridfield1" displayname="Additional&nbsp;Allowance">
					
					</label>
				</div>
				</td>

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee&nbsp;Type<span class="redmind"></span></div>
							<select name="trProcessingFeeType<?php echo $fNum; ?>" id="trProcessingFeeType<?php echo $fNum; ?>" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1">%</option>
								<option value="2">Flat(PP)</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="trprocessingFee<?php echo $fNum; ?>" id="trprocessingFee<?php echo $fNum; ?>" class="gridfield1" displayname="Processing Fee" style="width: 104px !important;">
						</label>
					</div>
				</td> 

				<td align="center">
				<div class="editbtnselect" id="selectthis" onclick="addTransferCostToQuotation('<?php echo $fNum; ?>');" >Select</div></td>
				<td align="center">
				<!-- <div class="editbtnselect" id="selectthis" style="width:62px;background: #233A49 !important;" onclick="openinboundpop('action=addNewFlightToMaster&quotationId=<?php echo $quotationId; ?>');" >Add New</div> -->
				</td>
			</tr> 
			<script>
					function selectTransferType<?php echo $fNum; ?>(){
					var type = $("#sicpvtType<?php echo $fNum; ?>").val();
					if(type==1){
						$(".SICClass<?php echo $fNum; ?>").show();
						$(".PVTClass<?php echo $fNum; ?>").hide();
					}
					if(type==2){
						$(".SICClass<?php echo $fNum; ?>").hide();
						$(".PVTClass<?php echo $fNum; ?>").show();
					}
				}
				selectTransferType<?php echo $fNum; ?>();
			</script>
	
			<?php } ?>
		</tbody>
	</table>
	<?php 
	//}
	
	$qflightQuery = GetPageRecord('*','quotationTransferMaster','quotationId="'.$quotationId.'" and isTransferTaken="yes" and dayId="0"');
	if(mysqli_num_rows($qflightQuery)>0){

		$qtfQuery = GetPageRecord('*','quotationTransferMaster','quotationId="'.$quotationId.'" and transferType=2 and dayId="0" and isTransferTaken="yes"');
		$quotTransferData = mysqli_fetch_assoc($qtfQuery)
	?>
	
	<table border="1" width="80%" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
			
			<?php 
			while($quotFlightData = mysqli_fetch_assoc($qflightQuery)){ 
	
				$rs5=GetPageRecord('*','packageBuilderTrainsMaster','id="'.$quotFlightData['trainId'].'"');
				$flightData=mysqli_fetch_array($rs5);
				$currencyId = $quotFlightData['currencyId'];
				$currencyValue = ($quotFlightData['currencyValue']>0)?$quotFlightData['currencyValue']:getCurrencyVal($currencyId);
				?>

				<tr>
				<th>Date</th>
				<th>Destination</th>
				<th>Transfer&nbsp;Name</th>
				<th>Vehicle&nbsp;Type</th>
				<th>Transfer&nbsp;Type</th>
				<th>Currency[ROE]</th>
				<th>Rep&nbsp;Cost</th>
				<?php if($quotFlightData['transferType']==1){ ?>
				<th>Adult&nbsp;Cost</th>
				<th>Child&nbsp;Cost</th>
				<th>Infant&nbsp;Cost</th>
				<?php if($quotTransferData['transferType']==2){ ?>
				<th colspan="3">&nbsp;</th>
				<?php } } if($quotFlightData['transferType']==2){?>
				<th>Vehicle&nbsp;Cost</th>
				<th>Parking&nbsp;Fee</th>
				<th>Assistance</th>
				<th>Allowance</th>
				<th>Inter&nbsp;State</th>
				<th>Miscellaneous</th>
				<?php } ?>
				
				<th>Fee&nbsp;Type</th>
				<th>Fee</th>
				<th>#</th>
				<th>#</th>
			</tr>	

				<tr>
				<td align="center"><div style="width: 70px;"><?php echo date('d-m-Y',strtotime($quotFlightData['fromDate'])); ?></div></td>
				<td align="center"><?php echo getDestination($quotFlightData['destinationId']); ?></td>
				<td align="center"><?php echo getDocketServiceName($quotFlightData['transferNameId'],'transfer'); ?></td>
				<td align="center"><?php echo getVehicleTypeName($quotFlightData['vehicleType']); ?></td>
				<td align="center"><?php echo ($quotFlightData['transferType']==2)?'PVT':'SIC'; ?></td>
				<td align="center"><?php echo getCurrencyName($currencyId).'['.clean($currencyValue).']';  ?></td>
				<td align="center"><?php echo $quotFlightData['representativeEntryFee']; ?></td>
				<?php if($quotFlightData['transferType']==1){ ?>
				<td align="center"><?php echo ($quotFlightData['adultCost']); ?></td>
				<td align="center"><?php echo ($quotFlightData['childCost']); ?></td>
				<td align="center"><?php echo ($quotFlightData['infantCost']); ?></td>
				<?php if($quotTransferData['transferType']==2){ ?>
				<td colspan="3"></td>
				<?php } } if($quotFlightData['transferType']==2){?>
				<td align="center"><?php echo $quotFlightData['vehicleCost']; ?></td>
				<td align="center"><?php echo $quotFlightData['parkingFee']; ?></td>
				<td align="center"><?php echo $quotFlightData['assistance']; ?></td>
				<td align="center"><?php echo $quotFlightData['guideAllowance']; ?></td>
				<td align="center"><?php echo $quotFlightData['interStateAndToll']; ?></td>
				<td align="center"><?php echo $quotFlightData['miscellaneous']; ?></td>
				<?php } ?>
				<td align="center"><?php echo ($quotFlightData['markupType']==1)?'%':'Flat'; ?></td>
				<td align="center"><?php echo ($quotFlightData['markupCost']); ?></td>

				<td align="center"><div class="editbtnselect" id="selectthis" style="margin-top: 0px !important;" onclick="openinboundpop('action=editQuotationTransferCost&editId=<?php echo $quotFlightData['id'] ?>&quotationId=<?php echo $quotFlightData['quotationId'] ?>');" >Edit
				</div></td>
				<td width="" align="center"><div><span style="color: #60ba3b; cursor: pointer; margin: 0px 5px;" ></span><span style="color: red;cursor: pointer; margin: 0px 5px;" onclick="if(confirm('Are you sure! you want to delete this Transfer Rate?')){ deleteTransferQuotationRate('<?php echo $quotFlightData['id'] ?>','<?php echo $quotFlightData['quotationId'] ?>','deleteTransferQuotationRate'); $('#addnl<?php echo $quotFlightData['id'];?>').remove(); }" ><i class="fa fa-trash" aria-hidden="true"></i></span></div></td>
			</tr>
				<?php } ?>
	</table>
	<?php } ?>
	</div>
	<div id="selectTraincost"></div>
	<script>

		// function selectTraincost(id){
		// 	var flightNameId=0;
		// 	flightNameId = $("#flightNameId").val();
		// 	if(flightNameId>0){
		// 		$("#selectTraincost").load('searchaction.php?action=selectTraincost&visaTypeId='+id+'&flightNameId='+flightNameId);
		// 	}else{
		// 		alert("Please Select Train Name First");
		// 	}
		// }
	
	
		function addTransferCostToQuotation(num){

			var transferNameId = $("#transferNameId"+num).val();
			var ttransferDate = $("#ttransferDate"+num).val();
			var destinationId = $("#TransferDestionation"+num).val();
			var transferType = $("#transferType"+num).val();
			var sicpvtType = $("#sicpvtType"+num).val();
			var vehicleTypeId = $("#vehicleTypeId"+num).val();
			var repCostt = $("#repCostt"+num).val();
			var adultCost = $("#tfadultCost"+num).val();
			var childCost = $("#tfchildCost"+num).val();
			var infantCost = $("#tfinfantCost"+num).val();
			var vehicleCost = $("#vehicleCost"+num).val();
			var parkingFee = $("#parkingFee"+num).val();
			var AssistanceFee = $("#AssistanceFee"+num).val();
			var additionalAllowance = $("#additionalAllowance"+num).val();
			var interState = $("#interState"+num).val();
			var misslaneousCost = $("#misslaneousCost"+num).val();
			var adultPax = $("#FadultPax"+num).val();
			var childPax = $("#FchildPax"+num).val();
			var infantPax = $("#FinfantPax"+num).val();
			var tfcurrencyId = $("#tfcurrencyId"+num).val();
			var currencyValue132 = $("#tcurrencyValue132"+num).val();
			var tfcurrencyValue = $("#tfcurrencyValue"+num).val();
			var ProcessingFeeType = $("#trProcessingFeeType"+num).val();
			var processingFee = $("#trprocessingFee"+num).val();
	
			if(transferNameId>0){
	
			$("#selectTraincost").load('loadValueAddedserviceCost.php?action=saveTransferCosttoQuotation&transferNameId='+transferNameId+'&transferType='+transferType+'&sicpvtType='+encodeURI(sicpvtType)+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&currencyId='+tfcurrencyId+'&currencyValue='+currencyValue132+'&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&ttransferDate='+encodeURI(ttransferDate)+'&destinationId='+encodeURI(destinationId)+'&vehicleTypeId='+vehicleTypeId+'&repCost='+repCostt+'&vehicleCost='+vehicleCost+'&parkingFee='+parkingFee+'&AssistanceFee='+AssistanceFee+'&additionalAllowance='+additionalAllowance+'&interState='+interState+'&misslaneousCost='+misslaneousCost+'&markupCost='+processingFee+'&markupType='+ProcessingFeeType);
			}else{
				alert('Please, Select Transfer Name');
			}
		}
	</script>
	<?php
	}
	?>
		<script>
			 parent.loadquotationmainfile();
		</script>
		<?php
	}
	
	?>