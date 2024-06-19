<?php
include "inc.php";    
$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
$newQuotationData=mysqli_fetch_array($dayQuery); 

$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$newQuotationData['quotationId'].'"'); 
$quotationData=mysqli_fetch_array($quotQuery); 


$ferryServiceId = $_REQUEST['ferryServiceId'];
$ferryTimeId = $_REQUEST['ferrytimeId'];
if($_REQUEST['rateId'] > 0 && $_REQUEST['tableN'] == 2){
	$rsat=GetPageRecord('*',_QUOTATION_FERRY_RATE_MASTER_,'id="'.$_REQUEST['rateId'].'"'); 
	$dmcFerryData2=mysqli_fetch_array($rsat);
	$ferryNameId = $dmcFerryData2['ferryNameId'];
	$ferryClassId = $dmcFerryData2['ferryClass'];
	$ferrySupplierId = $dmcFerryData2['supplierId'];

	$adultPax = $dmcFerryData2['adultPax'];
	$childPax = $dmcFerryData2['childPax'];
	$infantPax = $dmcFerryData2['infantPax'];


}elseif($_REQUEST['rateId'] > 0 && $_REQUEST['tableN'] == 1){
	$rsat=GetPageRecord('*',_DMC_FERRY_RATE_MASTER_,'id="'.$_REQUEST['rateId'].'"'); 
	$dmcFerryData2=mysqli_fetch_array($rsat);
	$ferryNameId = $dmcFerryData2['ferryNameId'];
	$ferryClassId = $dmcFerryData2['ferryClass'];
	$ferrySupplierId = $dmcFerryData2['supplierId'];

	$adultPax = $quotationData['adult'];
	$childPax = $quotationData['child'];
	$infantPax = $quotationData['infant'];


}else{ 
	$ferrySupplierId = ''; 
	$ferryNameId = '';
	$ferryClassId = '';

	$adultPax = $quotationData['adult'];
	$childPax = $quotationData['child'];
	$infantPax = $quotationData['infant'];
}

$rsq=GetPageRecord('*','queryMaster','id="'.$newQuotationData['queryId'].'"'); 
$resquery=mysqli_fetch_array($rsq);
 
$res3=GetPageRecord('*','ferryServiceTiming','id="'.$ferryTimeId.'"'); 
$ferryServicetimeData=mysqli_fetch_array($res3); 

$rs2=GetPageRecord('name,id',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$ferryServiceId.'"'); 
$ferryServiceData=mysqli_fetch_array($rs2); 

if($dmcFerryData2['capacity']>0){
	$capacity = ($dmcFerryData2['capacity']);
}else{
	$capacity = ($ferryNamD['capacity']);
} 
?>   
<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $ferryServiceData['name']; ?> | Add/Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="$('#viewinfo').hide();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="fr_supplierId" name="fr_supplierId" class="gridfield validate" displayname="Suppliers"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( ferryType=10 or ferryType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$ferrySupplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 
						<td width="100" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Ferry&nbsp;Name<span class="redmind"></span></div>
								<select id="fr_ferryNameId" name="fr_ferryNameId" class="gridfield" autocomplete="off" style="width: 100%;" >
								<?php    
								$rs=GetPageRecord('name,id',_FERRY_NAME_MASTER_,' 1  order by name asc'); 
								while($ferryCnpData=mysqli_fetch_array($rs)){  
								?>
								<option value="<?php echo strip($ferryCnpData['id']); ?>" <?php if($ferryCnpData['id']==$ferryNameId){ ?>selected="selected"<?php } ?>><?php echo strip($ferryCnpData['name']); ?></option>
								<?php } ?> 
							 	</select>
								</label>
							</div>
						</td> 
						<td width="100" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Ferry&nbsp;Seat<span class="redmind"></span></div>
								<select id="fr_ferryClass" name="fr_ferryClass" class="gridfield"  autocomplete="off" style="width: 100%;" >
								<?php    
								$rs=GetPageRecord('name,id',_FERRY_CLASS_MASTER_,' 1  order by name asc'); 
								while($ferryClmData=mysqli_fetch_array($rs)){  
								?>
								<option value="<?php echo strip($ferryClmData['id']); ?>" <?php if($ferryClmData['id']==$ferryClassId){ ?>selected="selected"<?php } ?>><?php echo strip($ferryClmData['name']); ?></option>
								<?php } ?> 
							 	</select>
								</label>
							</div>
						</td>    
					</tr> 
					<tr>
						<td width="100" align="left" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="fr_adultCost" type="text" class="gridfield"  id="fr_adultCost" value="<?php echo $dmcFerryData2['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="fr_adultPax" type="text" class="gridfield"  id="fr_adultPax" value="<?php echo $adultPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left"  >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="fr_childCost" type="text" class="gridfield"  id="fr_childCost" value="<?php echo $dmcFerryData2['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="fr_childPax" type="text" class="gridfield"  id="fr_childPax" value="<?php echo $childPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
						<td width="100" align="left"  >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="fr_infantCost" type="text" class="gridfield"  id="fr_infantCost" value="<?php echo $dmcFerryData2['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="fr_infantPax" type="text" class="gridfield"  id="fr_infantPax" value="<?php echo $infantPax ?>" maxlength="6" onkeyup="numericFilter(this);" />
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
						<!-- <td width="50" align="left">
							<div class="griddiv">
							<label>
							<div class="gridlable">Processing&nbsp;Fee</div>
							<input type="text" class="gridfield" name="fr_processingfee" displayname="Processing fee" id="fr_processingfee" value="<?php echo trim($dmcFerryData2['processingfee']); ?>">
							</label>
							</div>
						</td> -->

						<td width="50" align="left">
							<div class="griddiv">
							<label>
							<div class="gridlable">Misc&nbsp;Cost</div>
							<input type="text" class="gridfield" name="fr_miscCost" displayname="Misc Cost" id="fr_miscCost" value="<?php echo trim($dmcFerryData2['miscCost']); ?>">
							</label>
							</div>
						</td>
						
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="fr_gstTax" name="fr_gstTax" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;"><?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Ferry"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($dmcFerryData2['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td> 
						<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($dmcFerryData2['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($dmcFerryData2['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $dmcFerryData2['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td> 
					</tr> 
					<tr> 
						<td width="100" align="left" >
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="fr_currencyId" name="fr_currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'fr_currencyValue');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($dmcFerryData2['currencyId']>0)?$dmcFerryData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($dmcFerryData2['currencyValue']>0)?$dmcFerryData2['currencyValue']:getCurrencyVal($currencyId);
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
							<div class="griddiv"  >
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="fr_currencyValue" displayname="ROI Value"  id="fr_currencyValue" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="100" colspan="3">
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="fr_remark" type="text" class="gridfield" id="fr_remark" value="<?php echo $dmcFerryData2['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
							<input name="fr_fromDate" type="hidden"  value="<?php echo $newQuotationData['srdate']; ?>"> 
							<input name="fr_toDate" type="hidden"  value="<?php echo $newQuotationData['srdate']; ?>"> 
							<input name="fr_quotationId" type="hidden"  value="<?php echo $newQuotationData['quotationId']; ?>"> 
							<input name="fr_ferryServiceId" type="hidden"  value="<?php echo $ferryServiceId ?>"> 
							<input name="fr_ferrypickupTime" type="hidden" value="<?php echo $ferryServicetimeData['pickupTime']; ?>"> 
							<input name="fr_ferrydropTime" type="hidden"  value="<?php echo $ferryServicetimeData['dropTime']; ?>"> 
 							<input name="fr_rateId" type="hidden"  value="<?php echo $dmcFerryData2['id']; ?>">
							<input name="fr_tableN" type="hidden"  value="<?php echo $_REQUEST['tableN']; ?>">
							<input name="action" type="hidden" id="action" value="addFerryPriceforQuotaion">
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
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="$('#viewinfo').hide();" /></td>
				</tr>
			</table> 
		</div>
	</div>
	<?php exit; ?> 