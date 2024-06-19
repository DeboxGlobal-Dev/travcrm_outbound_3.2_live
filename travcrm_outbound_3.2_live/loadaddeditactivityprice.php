<?php
include "inc.php";    

if($_REQUEST['action']=='addeditactivityprice' && $_REQUEST['rateid']!=''){

	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 
	$quotationId = $newQuotationData['quotationId'];
	$destinationId = $_REQUEST['destinationId'];

	$quoteQuery='';
	$quoteQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData=mysqli_fetch_array($quoteQuery);

	if($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 2){
		$rsat=GetPageRecord('*','quotationActivityRateMaster','id="'.$_REQUEST['rateid'].'"'); 
		$dmcActivityData=mysqli_fetch_array($rsat);
		$serviceId = $dmcActivityData['serviceId'];
		$activitySupplierId = $dmcActivityData['supplierId'];
		$transferType = $dmcActivityData['transferType'];
		
		$adultPax = $dmcActivityData['adultPax'];
		$childPax = $dmcActivityData['childPax'];
		$infantPax = $dmcActivityData['infantPax'];

	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 1){
		$rsat=GetPageRecord('*','dmcotherActivityRate','id="'.$_REQUEST['rateid'].'"'); 
		$dmcActivityData=mysqli_fetch_array($rsat);
		$serviceId = $dmcActivityData['serviceid'];
		$activitySupplierId = $dmcActivityData['supplierId'];
		$transferType = $dmcActivityData['transferType'];
		
		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant'];
	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 3){ 
		$serviceId = $_REQUEST['rateid']; 
		$transferType = $_REQUEST['transferType'];
		
		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant'];
	}

	$rsq=GetPageRecord('*','queryMaster','id="'.$newQuotationData['queryId'].'"'); 
	$resquery=mysqli_fetch_array($rsq);

	$rs2=GetPageRecord('otherActivityName,id',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'id="'.$serviceId.'"'); 
	$activityData=mysqli_fetch_array($rs2); 
	?>   

	<div class="contentdiv " style="margin-top: 60px;">
			<h1 class="contentheader" ><?php echo $activityData['otherActivityName']; ?> Add/Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="parent.$('#loadprice').hide();"></i></h1>
			<div class="contentbody "> 
				<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
					<form action="frm_action.crm" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
						<tbody> 
					<tr>
						<td width="100"  align="left" >
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="act_supplierId" name="act_supplierId" class="gridfield validate" displayname="Suppliers" autocomplete="off"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( activityType=3 or activityType=1 ) and status=1 and FIND_IN_SET("'.$destinationId.'",destinationId) order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$dmcActivityData['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 

						<td width="100" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Tarif Type<span class="redmind"></span></div>
							<select id="act_tarifType" name="act_tarifType" class="gridfield" displayname="Tarif Type" autocomplete="off">
								<option value="1" <?php if(1==$dmcActivityData['tarifType']){ ?>selected="selected"<?php } ?>>Normal</option>
								<option value="2" <?php if(2==$dmcActivityData['tarifType']){ ?>selected="selected"<?php } ?>>Weekend</option>
							</select>
							</label>
							</div>
						</td>
						 
						<td width="100"  align="left">
							<div class="griddiv">
							<label>
								<div class="gridlable">Cost&nbsp;Type</div>
								<select id="act_transferType" name="act_transferType" class="gridfield " autocomplete="off" onchange="selectQuotActTPType(this.value);">
									<option value="1" <?php if($transferType==1){ ?> selected="selected" <?php } ?>>SIC</option>
									<option value="2" <?php if($transferType==2){ ?> selected="selected" <?php } ?>>PVT</option>
									<option value="3" <?php if($transferType==3){ ?> selected="selected" <?php } ?>>VIP</option>
									<option value="4" <?php if($transferType==4){ ?> selected="selected" <?php } ?> >Ticket Only</option>
								</select>
							</label>
							</div>
							<script type="text/javascript">
								function selectQuotActTPType(transType) {
									if(transType == 1 || transType == 0){
										$('.sic').show();
										$('.rep').show();
										$('.pvt').hide(); 
									}
									if(transType == 2 || transType == 3) {
										$('.sic').hide();
										$('.pvt').show(); 
										$('.rep').show(); 
									}
									if(transType == 4) {
										$('.sic').hide();
										$('.pvt').hide(); 
										$('.rep').hide(); 
									}
								}
								selectQuotActTPType(<?php echo $transferType; ?>);
							</script>
						</td>
					</tr>
					<tr>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="act_ticketAdultCost" type="text" class="gridfield"  id="act_ticketAdultCost" value="<?php echo round($dmcActivityData['ticketAdultCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="act_adultPax" type="text" class="gridfield"  id="act_adultPax" value="<?php echo $adultPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="act_ticketchildCost" type="text" class="gridfield"  id="act_ticketchildCost" value="<?php echo round($dmcActivityData['ticketchildCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="act_childPax" type="text" class="gridfield"  id="act_childPax" value="<?php echo $childPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="act_ticketinfantCost" type="text" class="gridfield"  id="act_ticketinfantCost" value="<?php echo round($dmcActivityData['ticketinfantCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="act_infantPax" type="text" class="gridfield"  id="act_infantPax" value="<?php echo $infantPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="50" align="left">
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="act_currencyId" name="act_currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'act_currencyVal127');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($dmcActivityData['currencyId']>0)?$dmcActivityData['currencyId']:$baseCurrencyId;
									$currencyValue = ($dmcActivityData['currencyValue']>0)?$dmcActivityData['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="50" align="left">
							<div class="griddiv">
							<label> 
							<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
							<input class="gridfield validate" name="act_currencyValue" displayname="ROI Value"  id="act_currencyVal12" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="100" align="left" class="rep" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Rep. Cost</div>
									<input class="gridfield " name="act_repCost" displayname="Representative Cost"  id="act_repCost" value="<?php echo round($dmcActivityData['repCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Adult Transfer</div>
									<input class="gridfield " name="act_transferAdultCost" displayname="Adult Transfer"  id="act_transferAdultCost" value="<?php echo round($dmcActivityData['adultCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Child Transfer</div>
									<input class="gridfield " name="act_transferChildCost" displayname="Child Transfer"  id="act_transferChildCost" value="<?php echo round($dmcActivityData['childCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Infant Transfer</div>
									<input class="gridfield " name="act_transferInfantCost" displayname="Infant Transfer"  id="act_transferInfantCost" value="<?php echo round($dmcActivityData['infantCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td> 

						<!-- PVT -->
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Vehicle Type</div>
									<select id="act_vehicleType" name="act_vehicleType" class="gridfield " displayname="Vehicle Type" autocomplete="off" width="100%" >
										<?php 
										$rs = '';
										$rs = GetPageRecord('*','vehicleTypeMaster','name!="" and status=1');
										while($tptTypeData = mysqli_fetch_assoc($rs)){
										?>
										<option value="<?php echo $tptTypeData['id']; ?>" <?php if($dmcActivityData['vehicleId']==$tptTypeData['id']){ echo 'selected'; } ?>><?php echo $tptTypeData['name']; ?></option>
										<?php } ?>
									</select> 
								</label>
							</div>
						</td>
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Vehicle Cost</div>
									<input class="gridfield " name="act_vehicleCost" displayname="Vehicle Cost "  id="act_vehicleCost" value="<?php echo round($dmcActivityData['vehicleCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">No of Vehicles</div>
									<input class="gridfield " name="act_noOfVehicles" displayname="noOfVehicles"  id="act_noOfVehicles" value="<?php echo trim($dmcActivityData['noOfVehicles']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
					</tr>			
					<tr> 	
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">Markup&nbsp;Type</div>
							<select name="act_markupType" id="act_markupType" class="gridfield " displayname="Markup Type" autocomplete="off" style="width: 100%;">
							 	<option value="1" <?php if($dmcActivityData['markupType'] == 1){ ?> selected="selected" <?php } ?>>%</option>
							 	<option value="2" <?php if($dmcActivityData['markupType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
							</select>
							</label>
							</div>
						</td>
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">Markup&nbsp;Cost</div>
							<input name="act_markupCost" type="text" class="gridfield"  id="act_markupCost" maxlength="6" onkeyup="numericFilter(this);" value="<?php echo $dmcActivityData['markupCost']; ?>" />
							</label>
							</div>
						</td>
						<td width="50" align="left"><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="act_gstTax" name="act_gstTax" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="activity"');
								while($gstSlabData = mysqli_fetch_array($rs2)) { 
									if($dmcActivityData['gstTax']!=''){
										$getcurrentgst = $dmcActivityData['gstTax'] == $gstSlabData['id'];
									 }else{
										$getcurrentgst = $gstSlabData['setDefault']=='1';
									 }
									
									?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($getcurrentgst){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								}
								?>
							</select>
							</label>
							</div>
						</td>  
					</tr>
					<tr> 
						<td width="100" colspan="3">
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="act_remark" type="text" class="gridfield" id="act_remark" value="<?php echo $dmcActivityData['remarks'] ?>" style="width: 99%;">
								</label>
							</div> 
							<input name="action" type="hidden" id="action" value="addQuotationActivityPrice">
							<input name="act_serviceId" type="hidden" id="serviceId" value="<?php echo $serviceId; ?>">
							<input name="act_quotationId" type="hidden" id="quotationId" value="<?php echo $quotationId ; ?>">
							<input name="act_dayId" type="hidden" id="dayId" value="<?php echo $_REQUEST['dayId'] ; ?>">
							<input name="act_rateid" type="hidden" id="rateid" value="<?php echo $_REQUEST['rateid'] ; ?>">
							<input name="act_tableN" type="hidden" id="tableN" value="<?php echo $_REQUEST['tableN'] ; ?>">
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
						<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="parent.$('#loadprice').hide();" /></td>
					</tr>
				</table> 
		</div>
	</div>
<?php 
} ?>