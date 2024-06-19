<?php
include "inc.php";    

if($_REQUEST['action']=='addedittrainprice' && $_REQUEST['rateid']!=''){

	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 
	$quotationId = $newQuotationData['quotationId'];

	$quoteQuery='';
	$quoteQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData=mysqli_fetch_array($quoteQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$newQuotationData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);
 
	if($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 2){
		$rsat=GetPageRecord('*',_QUOTATION_TRAIN_RATE_MASTER_,'id="'.$_REQUEST['rateid'].'"'); 
		$dmcTrainData=mysqli_fetch_array($rsat);

		$serviceId = $dmcTrainData['serviceId'];
		$supplierId = $dmcTrainData['supplierId'];

		$adultPax = $dmcTrainData['adultPax'];
		$childPax = $dmcTrainData['childPax'];
		$infantPax = $dmcTrainData['infantPax']; 

	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 1){
		$rsat=GetPageRecord('*',_DMC_TRAIN_RATE_MASTER_,'id="'.$_REQUEST['rateid'].'"'); 
		$dmcTrainData=mysqli_fetch_array($rsat);
		$serviceId = $dmcTrainData['serviceId'];
		$supplierId = $dmcTrainData['supplierId'];

		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant']; 

	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 3){ 
		$serviceId = $_REQUEST['rateid']; 
		
		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant']; 
	}

	$rsq=GetPageRecord('*','queryMaster','id="'.$newQuotationData['queryId'].'"'); 
	$resquery=mysqli_fetch_array($rsq);

	$rs2=GetPageRecord('trainName,id',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$serviceId.'"'); 
	$trainData=mysqli_fetch_array($rs2); 
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $trainData['trainName']; ?> Add/Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="parent.$('#loadprice').hide();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100"  align="left" colspan="2">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="tr_supplierId" name="tr_supplierId" class="gridfield validate" displayname="Suppliers"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( trainType=8 or trainType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$dmcTrainData['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 
						
						<td width="50" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Train&nbsp;Number<span class="redmind"></span></div>
							<input type="text" class="gridfield validate" name="tr_trainNumber" displayname="Train Number"  id="tr_trainNumber" value="<?php echo trim($dmcTrainData['trainNumber']); ?>"  >
							</label>
							</div>
						</td> 
						
						<td width="50" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Train&nbsp;Class</div>
								<select id="tr_trainClass" name="tr_trainClass" class="gridfield" displayname="Train Class"  autocomplete="off" >
									<option value="AC First Class"  <?php if($dmcTrainData['trainClass']=='AC First Class'){ ?>selected="selected"<?php } ?>>AC First Class</option>
									<option value="AC 2-Tier"  <?php if($dmcTrainData['trainClass']=='AC 2-Tier'){ ?>selected="selected"<?php } ?>>AC 2-Tier</option>
									<option value="AC 3-Tier"  <?php if($dmcTrainData['trainClass']=='AC 3-Tier'){ ?>selected="selected"<?php } ?>>AC 3-Tier	</option>
									<option value="First Class"  <?php if($dmcTrainData['trainClass']=='First Class'){ ?>selected="selected"<?php } ?>>First Class	</option>
									<option value="AC Chair Car"  <?php if($dmcTrainData['trainClass']=='AC Chair Car'){ ?>selected="selected"<?php } ?>>AC Chair Car</option>
									<option value="Second Sitting"  <?php if($dmcTrainData['trainClass']=='Second Sitting'){ ?>selected="selected"<?php } ?>>Second Sitting</option>
									<option value="Sleeper"  <?php if($dmcTrainData['trainClass']=='Sleeper'){ ?>selected="selected"<?php } ?>>Sleeper</option>
								</select></label>
							</div>
						</td>
						
						<td width="50" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Journey&nbsp;Type</div>
							<select id="tr_journeyType" name="tr_journeyType" class="gridfield validate" displayname="Journey Type" autocomplete="off" >
 								<option value="day_journey"  <?php if($dmcTrainData['journeyType']=='day_journey'){ ?>selected="selected"<?php } ?>>day_journey</option>
								<option value="overnight_journey"  <?php if($dmcTrainData['journeyType']=='overnight_journey'){ ?>selected="selected"<?php } ?>>overnight_journey</option>
							</select>
							</label>
							</div>
						</td>
						
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="tr_gstTax" name="tr_gstTax" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Train"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($dmcTrainData['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>

					</tr>
					<tr> 
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_adultCost" type="text" class="gridfield"  id="tr_adultCost" value="<?php echo $dmcTrainData['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_adultPax" type="text" class="gridfield"  id="tr_adultPax" value="<?php echo $adultPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_childCost" type="text" class="gridfield"  id="tr_childCost" value="<?php echo $dmcTrainData['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_childPax" type="text" class="gridfield"  id="tr_childPax" value="<?php echo $childPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_infantCost" type="text" class="gridfield"  id="tr_infantCost" value="<?php echo $dmcTrainData['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_infantPax" type="text" class="gridfield"  id="tr_infantPax" value="<?php echo $infantPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="200" align="left" >
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="tr_currencyId" name="tr_currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'tr_currencyValue');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($dmcTrainData['currencyId']>0)?$dmcTrainData['currencyId']:$baseCurrencyId;
									$currencyValue = ($dmcTrainData['currencyValue']>0)?$dmcTrainData['currencyValue']:getCurrencyVal($currencyId);
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
						<td width="200"  align="left" colspan="2" >
							<div class="griddiv">
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="tr_currencyValue" displayname="ROI Value"  id="tr_currencyValue" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($dmcTrainData['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($dmcTrainData['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $dmcTrainData['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td>
						<td width="200"  align="left" colspan="2" >
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="tr_remark" type="text" class="gridfield" id="tr_remark" value="<?php echo $dmcTrainData['remark'] ?>" >
								</label>
							</div> 
							<input name="action" type="hidden" id="action" value="addQuotationTrainPrice"> 
						  	<input name="tr_tarifType" type="hidden" id="tr_tarifType" value="1">
						  	<input name="tr_serviceId" type="hidden" id="tr_serviceId" value="<?php echo $serviceId; ?>">
						  	<input name="tr_quotationId" type="hidden" id="tr_quotationId" value="<?php echo $quotationId ; ?>">
						  	<input name="tr_dayId" type="hidden" id="tr_dayId" value="<?php echo $_REQUEST['dayId'] ; ?>">
						  	<input name="tr_rateid" type="hidden" id="tr_rateid" value="<?php echo $_REQUEST['rateid'] ; ?>">
						 	<input name="tr_tableN" type="hidden" id="tr_tableN" value="<?php echo $_REQUEST['tableN'] ; ?>">
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
} 
?>