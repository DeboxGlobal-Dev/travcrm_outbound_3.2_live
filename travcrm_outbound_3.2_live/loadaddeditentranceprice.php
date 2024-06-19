<?php
include "inc.php";    

if($_REQUEST['action']=='addeditentranceprice' && $_REQUEST['rateid']!=''){

	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 
	$quotationId = $newQuotationData['quotationId'];

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$newQuotationData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	
	$quoteQuery='';
	$quoteQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData=mysqli_fetch_array($quoteQuery);


	$nation=GetPageRecord('*','nationalityMaster','id ="'.$queryData['nationality'].'"');
	$nationData=mysqli_fetch_array($nation);
	
	if($nationData['countryId'] == 0 && $nationData['name'] == 'Foreign'){
		$nationType = 'Foreign';	
		$nationalityType = 2;
	}else{
		$nationalityType = 1;
		$nationType = 'Local';
	}


	if($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 2){
		$rsat=GetPageRecord('*','quotationEntranceRateMaster','id="'.$_REQUEST['rateid'].'"'); 
		$dmcEntranceData=mysqli_fetch_array($rsat);

		$serviceId = $dmcEntranceData['serviceId'];
		$supplierId = $dmcEntranceData['supplierId'];

		$adultPax = $dmcEntranceData['adultPax'];
		$childPax = $dmcEntranceData['childPax'];
		$infantPax = $dmcEntranceData['infantPax']; 

	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 1){
		$rsat=GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,'id="'.$_REQUEST['rateid'].'"'); 
		$dmcEntranceData=mysqli_fetch_array($rsat);
		$serviceId = $dmcEntranceData['serviceid'];
		$serviceId = $dmcEntranceData['entranceNameId'];
		$supplierId = $dmcEntranceData['supplierId']; 

		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant'];  

	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 3){ 
		$serviceId = $_REQUEST['rateid']; 

		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant'];
	}

	$transferType = $_REQUEST['transferType'];

	$rsq=GetPageRecord('*','queryMaster','id="'.$newQuotationData['queryId'].'"'); 
	$resquery=mysqli_fetch_array($rsq);

	$rs2=GetPageRecord('entranceName,id',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$serviceId.'"'); 
	$entranceData=mysqli_fetch_array($rs2); 
	?> 

	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $entranceData['entranceName']; ?> Add/Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="parent.$('#loadprice').hide();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100"  align="left" >
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="ent_supplierId" name="ent_supplierId" class="gridfield validate" displayname="Suppliers" autocomplete="off"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( entranceType=4 or entranceType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$dmcEntranceData['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 

						<td width="100" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Tarif Type<span class="redmind"></span></div>
							<select id="ent_tarifType" name="ent_tarifType" class="gridfield" displayname="Tarif Type" autocomplete="off">
								<option value="1" <?php if(1==$dmcEntranceData['tarifType']){ ?>selected="selected"<?php } ?>>Normal</option>
								<option value="2" <?php if(2==$dmcEntranceData['tarifType']){ ?>selected="selected"<?php } ?>>Weekend</option>
							</select>
							</label>
							</div>
						</td>
						 
						<td width="100"  align="left">
							<div class="griddiv">
							<label>
								<div class="gridlable">Cost&nbsp;Type</div>
								<select id="ent_transferType" name="ent_transferType" class="gridfield " autocomplete="off" onchange="selectQuotActTPType(this.value);">
									<option value="1" <?php if($transferType==1){ ?> selected="selected" <?php } ?>>SIC</option>
									<option value="2" <?php if($transferType==2){ ?> selected="selected" <?php } ?>>PVT</option>
									<option value="3" <?php if($transferType==3){ ?> selected="selected" <?php } ?> >Ticket Only</option>
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
									if(transType == 2) {
										$('.sic').hide();
										$('.pvt').show(); 
										$('.rep').show(); 
									}
									if(transType == 3) {
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
												<input name="ent_ticketAdultCost" type="text" class="gridfield"  id="ent_ticketAdultCost" value="<?php echo round($dmcEntranceData['ticketAdultCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ent_adultPax" type="text" class="gridfield"  id="ent_adultPax" value="<?php echo $adultPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
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
												<input name="ent_ticketchildCost" type="text" class="gridfield"  id="ent_ticketchildCost" value="<?php echo round($dmcEntranceData['ticketchildCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ent_childPax" type="text" class="gridfield"  id="ent_childPax" value="<?php echo $childPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
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
												<input name="ent_ticketinfantCost" type="text" class="gridfield"  id="ent_ticketinfantCost" value="<?php echo round($dmcEntranceData['ticketinfantCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ent_infantPax" type="text" class="gridfield"  id="ent_infantPax" value="<?php echo $infantPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
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
								<select id="ent_currencyId" name="ent_currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'ent_currencyVal12');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($dmcEntranceData['currencyId']>0)?$dmcEntranceData['currencyId']:$baseCurrencyId;
									$currencyValue = ($dmcEntranceData['currencyValue']>0)?$dmcEntranceData['currencyValue']:getCurrencyVal($currencyId);
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
							<input class="gridfield validate" name="ent_currencyValue" displayname="ROI Value"  id="ent_currencyVal12" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="100" align="left" class="rep" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Rep. Cost</div>
									<input class="gridfield " name="ent_repCost" displayname="Representative Cost"  id="ent_repCost" value="<?php echo trim($dmcEntranceData['repCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
					</tr> 		
					<tr>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Adult Transfer</div>
									<input class="gridfield " name="ent_transferAdultCost" displayname="Adult Transfer"  id="ent_transferAdultCost" value="<?php echo trim($dmcEntranceData['adultCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Child Transfer</div>
									<input class="gridfield " name="ent_transferChildCost" displayname="Child Transfer"  id="ent_transferChildCost" value="<?php echo trim($dmcEntranceData['childCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Infant Transfer</div>
									<input class="gridfield " name="ent_transferInfantCost" displayname="Infant Transfer"  id="ent_transferInfantCost" value="<?php echo trim($dmcEntranceData['infantCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>  
						<!-- PVT -->
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Vehicle Type</div>
									<select id="ent_vehicleType" name="ent_vehicleType" class="gridfield " displayname="Vehicle Type" autocomplete="off" width="100%" >
										<?php 
										$rs = '';
										$rs = GetPageRecord('*','vehicleTypeMaster','name!="" and status=1');
										while($tptTypeData = mysqli_fetch_assoc($rs)){
										?>
										<option value="<?php echo $tptTypeData['id']; ?>" <?php if($dmcEntranceData['vehicleType']==$tptTypeData['id']){ echo 'selected'; } ?>><?php echo $tptTypeData['name']; ?></option>
										<?php } ?>
									</select> 
								</label>
							</div>
						</td>
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Vehicle Cost</div>
									<input class="gridfield " name="ent_vehicleCost" displayname="Vehicle Cost "  id="ent_vehicleCost" value="<?php echo trim($dmcEntranceData['vehicleCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">No of Vehicles</div>
									<input class="gridfield " name="ent_noOfVehicles" displayname="noOfVehicles "  id="ent_noOfVehicles" value="<?php echo trim($dmcEntranceData['noOfVehicles']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
					</tr>			
					<tr> 	
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">Markup&nbsp;Type</div>
							<select name="ent_markupType" id="ent_markupType" class="gridfield " displayname="Markup Type" autocomplete="off" style="width: 100%;">
							 	<option value="1" <?php if($dmcEntranceData['markupType'] == 1){ ?> selected="selected" <?php } ?>>%</option>
							 	<option value="2" <?php if($dmcEntranceData['markupType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
							</select>
							</label>
							</div>
						</td>
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">Markup&nbsp;Cost</div>
							<input name="ent_markupCost" type="text" class="gridfield"  id="ent_markupCost" maxlength="6" onkeyup="numericFilter(this);" value="<?php echo $dmcEntranceData['markupCost']; ?>" />
							</label>
							</div>
						</td>
						<td width="50" align="left"><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="ent_gstTax" name="ent_gstTax" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Entrance"');
								while($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($dmcEntranceData['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
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
									<input name="ent_remark" type="text" class="gridfield" id="ent_remark" value="<?php echo $dmcEntranceData['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
							<input name="action" type="hidden" id="action" value="addQuotationEntrancePrice"> 
							<input name="ent_serviceId" type="hidden" id="serviceId" value="<?php echo $serviceId; ?>">
							<input name="ent_nationalityType" type="hidden" id="nationalityType" value="<?php echo $nationalityType; ?>">
							<input name="ent_quotationId" type="hidden" id="quotationId" value="<?php echo $quotationId ; ?>">
							<input name="ent_dayId" type="hidden" id="dayId" value="<?php echo $_REQUEST['dayId'] ; ?>">
							<input name="ent_rateid" type="hidden" id="rateid" value="<?php echo $_REQUEST['rateid'] ; ?>">
							<input name="ent_tableN" type="hidden" id="tableN" value="<?php echo $_REQUEST['tableN'] ; ?>">
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
	<?php exit; ?>  

	<?php 
} 
?>