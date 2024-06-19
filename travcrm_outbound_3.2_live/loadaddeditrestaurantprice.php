<?php
include "inc.php";    

if($_REQUEST['action']=='addeditrestaurantprice' && $_REQUEST['rateid']!=''){

	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 
	$quotationId = $newQuotationData['quotationId'];

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$newQuotationData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	$quoteQuery='';
	$quoteQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData=mysqli_fetch_array($quoteQuery);

 
	if($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 2){
		$rsat=GetPageRecord('*',_QUOTATION_RESTAURANT_RATE_MASTER_,'id="'.$_REQUEST['rateid'].'"'); 
		$dmcRestaurantData=mysqli_fetch_array($rsat);

		$serviceId = $dmcRestaurantData['serviceId'];
		$supplierId = $dmcRestaurantData['supplierId'];

		$adultPax = $dmcRestaurantData['adultPax'];
		$childPax = $dmcRestaurantData['childPax'];
		$infantPax = $dmcRestaurantData['infantPax']; 

	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 1){
		$rsat=GetPageRecord('*',_DMC_RESTAURANT_RATE_MASTER_,'id="'.$_REQUEST['rateid'].'"'); 
		$dmcRestaurantData=mysqli_fetch_array($rsat);
		$serviceId = $dmcRestaurantData['serviceId'];
		$supplierId = $dmcRestaurantData['supplierId'];

		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant']; 

	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 3){ 
		$serviceId = $_REQUEST['rateid']; 

		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant']; 

	}

	$rs2=GetPageRecord('mealPlanName,id',_INBOUND_MEALPLAN_MASTER_,'id="'.$serviceId.'"'); 
	$activityData=mysqli_fetch_array($rs2); 
	?>  

	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo  $activityData['mealPlanName']; ?> Add/Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="parent.$('#loadprice').hide();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100"  align="left" >
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="re_supplierId" name="re_supplierId" class="gridfield validate" displayname="Suppliers" style="width:170px;" >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( mealType=6 or mealType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$dmcRestaurantData['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 
						 
						<td align="left"  ><div class="griddiv">
							<label>
							<div class="gridlable">Meal&nbsp;Type</div>
							<select id="re_mealPlanType" name="re_mealPlanType" class="gridfield validate" displayname="Meal Type" autocomplete="off" >
 								<option value="">Select</option>
								<?php 
								$rs='';    
								$rs=GetPageRecord('*',_PACKAGE_BUILDER_RESTAURANT_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
								while($mealTypeD=mysqli_fetch_array($rs)){   
								?>
								<option value="<?php echo $mealTypeD['id']; ?>"  <?php if($mealTypeD['id']==$dmcRestaurantData['mealPlanType']){ ?>selected="selected"<?php } ?>><?php echo $mealTypeD['name']; ?></option>
								<?php } ?>
							</select>
							</label>
							</div>
						</td>
						
						<td align="left"  ><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="re_gstTax" name="re_gstTax" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Restaurant"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($dmcRestaurantData['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>

					</tr>
					<tr>  
						<td align="left" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; " width="100%;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="re_adultCost" type="text" class="gridfield"  id="re_adultCost" value="<?php echo $dmcRestaurantData['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="re_adultPax" type="text" class="gridfield"  id="re_adultPax" value="<?php echo $adultPax; ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td align="left" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" width="100%;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="re_childCost" type="text" class="gridfield"  id="re_childCost" value="<?php echo $dmcRestaurantData['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="re_childPax" type="text" class="gridfield"  id="re_childPax" value="<?php echo $childPax; ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
						<td align="left" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" width="100%;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="re_infantCost" type="text" class="gridfield"  id="re_infantCost" value="<?php echo $dmcRestaurantData['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="re_infantPax" type="text" class="gridfield"  id="re_infantPax" value="<?php echo $infantPax; ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 	
					</tbody> 
					</table>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 				
					<tr> 
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="re_currencyId" name="re_currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'re_currencyValue');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($dmcRestaurantData['currencyId']>0)?$dmcRestaurantData['currencyId']:$baseCurrencyId;
									$currencyValue = ($dmcRestaurantData['currencyValue']>0)?$dmcRestaurantData['currencyValue']:getCurrencyVal($currencyId);
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
						<td width="100"  align="left">
							<div class="griddiv">
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="re_currencyValue" displayname="ROI Value"  id="re_currencyValue" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>

					<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($dmcRestaurantData['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($dmcRestaurantData['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $dmcRestaurantData['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td>
			</tr>
			<tr>
						<td width="100" colspan="4">
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="re_remark" type="text" class="gridfield" id="re_remark" value="<?php echo $dmcRestaurantData['remark'] ?>" style="width: 99%;">
								</label>
							</div>
							<input name="action" type="hidden" id="action" value="addQuotationRestaurantPrice"> 
							<input name="re_serviceId" type="hidden" id="re_serviceId" value="<?php echo $serviceId; ?>">
							<input name="re_quotationId" type="hidden" id="re_quotationId" value="<?php echo $quotationId ; ?>">
							<input name="re_dayId" type="hidden" id="re_dayId" value="<?php echo $_REQUEST['dayId'] ; ?>">
							<input name="re_rateid" type="hidden" id="re_rateid" value="<?php echo $_REQUEST['rateid'] ; ?>">
							<input name="re_tableN" type="hidden" id="re_tableN" value="<?php echo $_REQUEST['tableN'] ; ?>">
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