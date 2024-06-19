<?php
include "inc.php";    

if($_REQUEST['action']=='editAdditionalPrice'){

	$dayId = $_REQUEST['dayId'];
	$quotationId = $_REQUEST['quotationId'];
	$cityId = $_REQUEST['cityId'];
	$queryId = $_REQUEST['queryId'];
	$rateId = $_REQUEST['rateId'];

	//Query data

	$rs1='';
	$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
	$quotationData = mysqli_fetch_array($rs1);


	if($_REQUEST['rateId']> 0 && $_REQUEST['tableN']==2){
		$rsat=GetPageRecord('*','quotationAdditionalRateMaster','rateId="'.$_REQUEST['rateId'].'" && id="'.$_REQUEST['additionalId'].'"'); 
		$additionalData=mysqli_fetch_array($rsat);

        $additionalId = $additionalData['additionalId'];

        $currencyId = $additionalData['currencyId'];
        $currencyValue = $additionalData['currencyValue'];
        $costType = $additionalData['costType'];
        $isMarkupApply = $additionalData['isMarkupApply'];

        $groupCost = $additionalData['groupCost'];
        $adultCost = $additionalData['adultCost'];
        $childCost = $additionalData['childCost'];
        $infantCost = $additionalData['infantCost'];

        $rateId = $additionalData['id'];
		$tableN=2;
		
		$adultPax = $additionalData['adultPax'];
		$childPax = $additionalData['childPax'];
		$infantPax = $additionalData['infantPax']; 

	}elseif($_REQUEST['additionalId']>0 && $_REQUEST['tableN'] == 1){
		$rsat=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,'id="'.$_REQUEST['additionalId'].'"'); 
		$additionalData=mysqli_fetch_array($rsat);
        $additionalId = $additionalData['id'];
        
        $currencyId = $additionalData['currencyId'];
        $currencyValue = $additionalData['currencyValue'];
        $costType = $additionalData['costType'];
        $isMarkupApply = $additionalData['isMarkupApply'];

        $groupCost = $additionalData['groupCost'];

        $adultCost = $additionalData['adultCost'];
        $childCost = $additionalData['childCost'];
        $infantCost = $additionalData['infantCost'];

        $rateId = $additionalData['id'];
		$tableN=1;

		$adultPax = $quotationData['adult'];
		$childPax = $quotationData['child'];
		$infantPax = $quotationData['infant']; 
		
	}

	?>  

	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $additionalData['name']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="parent.$('#viewinfo').hide();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="300" colspan="6" >
							<div class="griddiv">
								<label>
									<div class="gridlable">Additional Service Name</div>
									<input name="ad_additionalName" type="text" class="gridfield validate" id="ad_additionalName" value="<?php echo clean($additionalData['name']) ; ?>">
								</label>
							</div>  
						</td>
					</tr>
					<tr>
						<td width="100" colspan="2">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="ad_supplierId" name="ad_supplierId" class="gridfield validate" displayname="Suppliers"  >  
									<?php
									$where=' deletestatus=0 and name!="" and ( otherType=13 or otherType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$additionalData['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div> 
						</td>
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="ad_currencyId" name="ad_currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'ad_currencyValue');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($currencyId>0)?$currencyId:$baseCurrencyId;
									$currencyValue = ($currencyValue>0)?$currencyValue:getCurrencyVal($currencyId);
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
						<td width="100" align="left" colspan="2">
								<div class="griddiv">
								<label> 
									<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
									<input class="gridfield validate" type="text" name="ad_currencyValue" displayname="ROI Value"  id="ad_currencyValue" value="<?php echo trim($currencyValue); ?>" >
								</label>
								</div>
						</td> 
					</tr>
					<tr>
						<td width="100"  align="left" colspan="2">
							<div class="griddiv" >
								<label>
									<div class="gridlable">Markup&nbsp;Apply</div>
									<select id="ad_isMarkupApply" type="text" class="gridfield" name="ad_isMarkupApply" autocomplete="off" style="width: 100%;" onchange="markupApplyStatus2(this.value)">
										<option value="0" <?php if ($isMarkupApply=='0'){ ?>selected="selected"<?php } ?>>Yes</option>
										<option value="1" <?php if ($isMarkupApply=='1'){ ?>selected="selected"<?php } ?>>No</option>
									</select>
								</label> 
							</div>
						</td> 
						<td width="100"  align="left" colspan="2">
							<div class="griddiv">
							<label>
								<div class="gridlable">Cost&nbsp;Type</div>
								<select id="ad_costType" type="text" class="gridfield" name="ad_costType" onchange="selectcost2(this.value);">
									<option value="1" <?php if($costType==1){ ?> selected="selected" <?php } ?>>Per Person</option>
									<option value="2" <?php if($costType==2){ ?> selected="selected" <?php } ?> >Group Cost</option>
								</select>
							</label>
							</div>
							<script type="text/javascript">
								function selectcost2(costType) {
									if (costType == 1 || costType == 0) {
										$('.pp').show();
										$('.tot').hide(); 
									}
									if (costType == 2) {
										$('.pp').hide();
										$('.tot').show(); 
									}
								}
								selectcost2(<?php echo ($costType>0) ? $costType : 1; ?>);

								function markupApplyStatus2(selectedValue) {
								    if (selectedValue == 1) {
								        console.log("The selected value is "+selectedValue+". Passing value 2 to the function.");
								        selectcost2(2);
								        $('#ad_costType').val(2)
								    } else {
								        console.log("The selected value is "+selectedValue+". Passing the original value to the function.");
								    }
								}
							</script>
						</td>
						<td width="100"  align="left" colspan="2">
							<div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="ad_gstTax" name="ad_gstTax" class="gridfield" displayname="Tax Slab" ><?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Other"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($additionalData['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>
					</tr>
					<tr>
						<td align="left" colspan="6" class="tot">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; "  bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td align="center">Cost Type</td></tr>  
										<tr><td align="center">Group Cost</td></tr> 
										<tr>
											<td>
												<input name="ad_groupCost" type="text" class="gridfield"  id="ad_groupCost" value="<?php echo round($groupCost) ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td> 
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td align="left" class="pp" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; width: 210px;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ad_adultCost" type="text" class="gridfield"  id="ad_adultCost" value="<?php echo round($adultCost) ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ad_adultPax" type="text" class="gridfield"  id="ad_adultPax" value="<?php echo round($adultPax); ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td align="left" class="pp" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; width: 210px;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ad_childCost" type="text" class="gridfield"  id="ad_childCost" value="<?php echo round($childCost) ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ad_childPax" type="text" class="gridfield"  id="ad_childPax" value="<?php echo round($childPax); ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
						<td align="left" class="pp" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; width: 210px;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ad_infantCost" type="text" class="gridfield"  id="ad_infantCost" value="<?php echo round($infantCost) ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ad_infantPax" type="text" class="gridfield"  id="ad_infantPax" value="<?php echo round($infantPax); ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
					<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($additionalData['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($additionalData['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $additionalData['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td>
						<td width="300" align="left" colspan="6">
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="ad_remark" type="text" class="gridfield" id="ad_remark" value="<?php echo $additionalData['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
							<input name="action" type="hidden" id="action" value="addQuotationAdditionalPrice"> 
							<input name="ad_quotationId" type="hidden" id="ad_quotationId" value="<?php echo $quotationId ; ?>">
							<input name="ad_dayId" type="hidden" id="ad_dayId" value="<?php echo $_REQUEST['dayId'] ; ?>">
							<input name="ad_rateid" type="hidden" id="ad_rateid" value="<?php echo $rateId ; ?>">
							<input name="ad_tableN" type="hidden" id="ad_tableN" value="<?php echo $tableN; ?>">
							<input name="ad_cityId" type="hidden" id="ad_cityId" value="<?php echo $cityId ; ?>">
							<input name="ad_queryId" type="hidden" id="ad_queryId" value="<?php echo $queryId ; ?>">
							<input id="ad_additionalNameId" type="hidden" name="ad_additionalNameId" value="<?php echo $additionalId ; ?>">
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
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="parent.$('#viewinfo').hide();" /></td>
				</tr>
			</table> 
		</div>
	</div>
	<?php 
} 
?>