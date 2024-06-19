<?php
include "inc.php";    

if($_REQUEST['action']=='addeditflightprice' && $_REQUEST['rateid']!=''){

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
		$rsat=GetPageRecord('*',_QUOTATION_FLIGHT_RATE_MASTER_,'id="'.$_REQUEST['rateid'].'"'); 
		$dmcFlightData=mysqli_fetch_array($rsat);

		$serviceId = $dmcFlightData['serviceId'];
		$supplierId = $dmcFlightData['supplierId'];
		// $flightHub = $dmcFlightData['hubId'];

		$adultPax = $dmcFlightData['adultPax'];
		$childPax = $dmcFlightData['childPax'];
		$infantPax = $dmcFlightData['infantPax']; 

	}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 1){
		$rsat=GetPageRecord('*',_DMC_FLIGHT_RATE_MASTER_,'id="'.$_REQUEST['rateid'].'"'); 
		$dmcFlightData=mysqli_fetch_array($rsat);
		$serviceId = $dmcFlightData['serviceId'];
		$supplierId = $dmcFlightData['supplierId']; 

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

	$rs2=GetPageRecord('flightName,id',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$serviceId.'"'); 
	$fltData=mysqli_fetch_array($rs2); 

	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $fltData['flightName']; ?> Add/Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="parent.$('#loadprice').hide();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100" colspan="2" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="ft_supplierId" name="ft_supplierId" class="gridfield validate" displayname="Suppliers"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( airlinesType=7 or airlinesType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$dmcFlightData['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 

						<td width="50" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Flight&nbsp;Number<span class="redmind"></span></div>
							<input type="text" class="gridfield validate" name="ft_flightNumber" displayname="Flight Number"  id="ft_flightNumber" value="<?php echo trim($dmcFlightData['flightNumber']); ?>"  >
							</label>
							</div>
						</td> 
						
						<td width="50" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Flight&nbsp;Class</div>
								<select id="ft_flightClass" name="ft_flightClass" class="gridfield" displayname="Flight Class"  autocomplete="off" >
									<option value="First_Class" <?php if($dmcFlightData['flightClass']=='First_Class'){ ?>selected="selected"<?php } ?>>First Class</option>
									<option value="Business_Class" <?php if($dmcFlightData['flightClass']=='Business_Class'){ ?>selected="selected"<?php } ?>>Business Class</option>
									<option value="Economy_Class" <?php if($dmcFlightData['flightClass']=='Economy_Class'){ ?>selected="selected"<?php } ?>>Economy Class</option>
									<option value="Premium_Economy_Class" <?php if($dmcFlightData['flightClass']=='Premium_Economy_Class'){ ?>selected="selected"<?php } ?>>Premium Economy Class</option>


									<option value="E" <?php if($dmcFlightData['flightClass'] == 'E'){?> selected="selected" <?php } ?>>E</option>
									<option value="F" <?php if($dmcFlightData['flightClass'] == 'F'){?> selected="selected" <?php } ?>>F</option>
									<option value="G" <?php if($dmcFlightData['flightClass'] == 'G'){?> selected="selected" <?php } ?>>G</option>
									<option value="Y" <?php if($dmcFlightData['flightClass'] == 'Y'){?> selected="selected" <?php } ?>>Y</option>
									<option value="N" <?php if($dmcFlightData['flightClass'] == 'N'){?> selected="selected" <?php } ?>>N</option>
									<option value="E1" <?php if($dmcFlightData['flightClass'] == 'E1'){?> selected="selected" <?php } ?>>E1</option>
									<option value="H" <?php if($dmcFlightData['flightClass'] == 'H'){?> selected="selected" <?php } ?>>H</option>
									<option value="S" <?php if($dmcFlightData['flightClass'] == 'S'){?> selected="selected" <?php } ?>>S</option>


								</select></label>
							</div>
						</td>

						<td width="50" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Bagg.&nbsp;Allowance</div>
							<input type="text" class="gridfield" name="ft_baggageAllowance" displayname="Baggage Allowance" id="ft_baggageAllowance" value="<?php echo trim($dmcFlightData['baggageAllowance']); ?>">
							</label>
							</div>
						</td>
						
						<td width="50" align="left"><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="ft_gstTax" name="ft_gstTax" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Airlines"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($dmcFlightData['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>  
					</tr> 
					<tr>
						<td width="100" align="left"  colspan="2" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ft_adultCost" type="text" class="gridfield"  id="ft_adultCost" value="<?php echo $dmcFlightData['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ft_adultPax" type="text" class="gridfield"  id="ft_adultPax" value="<?php echo $adultPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left" colspan="2"  >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ft_childCost" type="text" class="gridfield"  id="ft_childCost" value="<?php echo $dmcFlightData['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ft_childPax" type="text" class="gridfield"  id="ft_childPax" value="<?php echo $childPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
						<td width="100" align="left"  colspan="2" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ft_infantCost" type="text" class="gridfield"  id="ft_infantCost" value="<?php echo $dmcFlightData['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ft_infantPax" type="text" class="gridfield"  id="ft_infantPax" value="<?php echo $infantPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="100" align="left" >
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="ft_currencyId" name="ft_currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'ft_currencyValue');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($dmcFlightData['currencyId']>0)?$dmcFlightData['currencyId']:$baseCurrencyId;
									$currencyValue = ($dmcFlightData['currencyValue']>0)?$dmcFlightData['currencyValue']:getCurrencyVal($currencyId);
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
						<td width="100"  align="left" colspan="2" >
							<div class="griddiv"  >
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="ft_currencyValue" displayname="ROI Value"  id="ft_currencyValue" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($dmcFlightData['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($dmcFlightData['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $dmcFlightData['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td>
						<td width="100"  colspan="2" >
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="ft_remark" type="text" class="gridfield" id="ft_remark" value="<?php echo $dmcFlightData['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
							<input name="action" type="hidden" id="action" value="addQuotationFlightPrice"> 
							<input name="ft_tarifType" type="hidden" id="ft_tarifType" value="1">
							<input name="ft_serviceId" type="hidden" id="ft_serviceId" value="<?php echo $serviceId; ?>">
							<input name="ft_quotationId" type="hidden" id="ft_quotationId" value="<?php echo $quotationId ; ?>">
							<input name="ft_dayId" type="hidden" id="ft_dayId" value="<?php echo $_REQUEST['dayId'] ; ?>">
							<input name="ft_rateid" type="hidden" id="ft_rateid" value="<?php echo $_REQUEST['rateid'] ; ?>">
							<input name="ft_tableN" type="hidden" id="ft_tableN" value="<?php echo $_REQUEST['tableN'] ; ?>">
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