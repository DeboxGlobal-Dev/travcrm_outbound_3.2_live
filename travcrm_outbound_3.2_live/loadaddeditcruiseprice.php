<?php
include "inc.php";    
$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
$newQuotationData=mysqli_fetch_array($dayQuery); 

$cruiseServiceId = $_REQUEST['cruiseServiceId'];
$quotationId = $newQuotationData['quotationId'];

//Query data
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$quotationId.'"');
$quotationData=mysqli_fetch_array($quotQuery);

$adultPax2 = $quotationData['adult'];
$childPax2 = $quotationData['child'];
$infantPax2 = $quotationData['infant'];

if($_REQUEST['rateId'] > 0 && $_REQUEST['tableN'] == 2){
	$rsat=GetPageRecord('*',_QUOTATION_CRUISE_RATE_MASTER_,'id="'.$_REQUEST['rateId'].'"'); 
	$dmcroommastermain=mysqli_fetch_array($rsat);

	$cruiseNameId = $dmcroommastermain['cruiseNameId'];
	$cabinTypeId = $dmcroommastermain['cabinTypeId'];
	$cruiseSupplierId = $dmcroommastermain['supplierId'];

	$adultPax2 = $dmcroommastermain['adultPax'];
	$childPax2 = $dmcroommastermain['childPax'];
	$infantPax2 = $dmcroommastermain['infantPax'];
	
}elseif($_REQUEST['rateId'] > 0 && $_REQUEST['tableN'] == 1){
	$rsat=GetPageRecord('*',_DMC_CRUISE_RATE_MASTER_,'id="'.$_REQUEST['rateId'].'"'); 
	$dmcroommastermain=mysqli_fetch_array($rsat);

	$cruiseNameId = $dmcroommastermain['cruiseNameId'];
	$cabinTypeId = $dmcroommastermain['cabinTypeId'];
	$cruiseSupplierId = $dmcroommastermain['supplierId'];

}else{ 
	
	$cruiseSupplierId = ''; 
	$cruiseNameId = $_REQUEST['cruiseNameId'];
	$cabinTypeId = $_REQUEST['cabinTypeId'];
}

$rsq=GetPageRecord('*','queryMaster','id="'.$newQuotationData['queryId'].'"'); 
$resquery=mysqli_fetch_array($rsq);

$cruiseQuery = GetPageRecord('*',_CRUISE_MASTER_,'id="'.$cruiseServiceId.'" and cruiseName!="" and status=1');
$cruseServiceData = mysqli_fetch_assoc($cruiseQuery)
?>  
<style type="text/css" >

		.topaboxouter{margin: 30px;
		    margin-top: 160px;}
		.topabox{
		    margin-bottom: 20px;
		    padding-bottom: 10px;
		    border-bottom: 0px #e8e8e8 solid;
		    font-size: 18px;}
			
		.topaboxlist {
		    border: 1px #e8e8e8 solid;
		    padding: 10px;
		    margin-bottom: 30px;
		    box-sizing: border-box;
		    background: #fbfbfb;
		}

		.gridtable td { 
		    border-bottom: #f1f1f1 0px solid !important; padding-bottom: 10px !important;
		}
		.labletext {
		    font-size: 11px;
		    color: #909090;
		    margin-bottom: 5px;
		    text-transform: uppercase;
		}
		.addeditpagebox .griddiv .gridlable {
		    color: #8a8a8a;
		    width: 100%;
		    display: inline-block;
		    padding-bottom: 0px;
		    font-size: 11px;text-transform: uppercase;
		}

		.addTriffRoom .addeditpagebox .griddiv { 
		    border-bottom: 0px #eee solid !important;
		    overflow: hidden !important;
		    position: relative !important; 
		}

		.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
		    width: 100% !important;
		}

		.addtopaboxlist {
		        border: 2px rgba(186, 228, 193, 0.75) solid;
		    padding: 10px;
		    margin-bottom: 30px;
		    box-sizing: border-box;
		    background: #f2fff7;
		}

		.addGreenHeader{    background: rgba(186, 228, 193, 0.75);
		    padding: 10px;
		    font-size: 15px;
		    font-weight: bold;
		    padding-left: 23px;}
			
		.addtopaboxlist .gridtable td {
		    padding: 12px 4px;
		    border-bottom: #f1f1f1 0px solid !important;
		    position: relative;
		}
		.roompricelistmain {
		    padding: 0px;
		    border: 1px #eeeeee solid;
		    background-color: #fff;
		    margin-top: 20px;
		}
		.roompricelistmain .headermainprice {
		    padding: 10px;
		    border-bottom: solid 1px #CCCCCC;
		    font-size: 13px;
		    font-weight: bold;
		}
		input[name='addnewuserbtn']{
			display:none;
		}

</style>
<div class="topaboxlist"  style="background-color: #ffffff; border-radius: 3px; padding: 3px; box-shadow: 0px 10px 35px;"> 
<table width="100%" border="0" cellspacing="0" cellpadding="8">
  <tr>

    <td width="88%" align="left"><strong style="font-size: 18px;"><?php echo clean($cruseServiceData['cruiseName']); ?> </strong></td>
    <td width="12%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="$('#loadprice').hide();"></i></td>
  </tr> 
</table>

<div class="addeditpagebox addtopaboxlist">	
<form action="frm_action.crm" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
		<tbody> 
		<tr>
			<td width="180" align="left" colspan="2">
				<div class="griddiv"><label>
					<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
					<select id="cr_supplierId2" name="cr_supplierId2" class="gridfield validate" displayname="Suppliers"  >  
						<?php 
						$where=' deletestatus=0 and name!="" and ( cruiseType=15 or cruiseType=1 ) and status=1 order by name asc';  
						$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
						while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
							<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$dmcroommastermain['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
						<?php } ?>
					</select> 
					</label>
				</div>
			</td>  

			<td width="180" align="left" colspan="2">
				<div class="griddiv">
					<label>
					<div class="gridlable">Cruise Name <span class="redmind"></span></div>
					<select name="cr_cruiseNameId2" class="gridfield validate" displayname="Cruise Name" id="cr_cruiseNameId2">
						<option value="">Select Cruise Name</option>
						<?php
						$rescr = GetPageRecord('name,id',_CRUISE_NAME_MASTER_,'deletestatus=0 and status=1');
						while($resultcruise = mysqli_fetch_assoc($rescr)){
						?>
						<option value="<?php echo $resultcruise['id']; ?>" <?php if($resultcruise['id']==$cruiseNameId){ echo 'selected'; } ?> ><?php echo $resultcruise['name']; ?></option>
						<?php
						}
						
						?>
					</select>
					</label>
				</div>
			</td> 
			
			<td width="90" align="left">
				<div class="griddiv"><label>
					<div class="gridlable">Cabin&nbsp;Type</div>
					<select id="cr_cabinType2" name="cr_cabinType2" class="gridfield" displayname="Cabin Type"  autocomplete="off" >
						<option value="">Select Cabin Type</option>
						<?php
						$resseat = GetPageRecord('*',_CABIN_TYPE_,'name!="" and status=1');
						while($cabinTypeData = mysqli_fetch_assoc($resseat)){
						?>
						<option value="<?php echo $cabinTypeData['id']; ?>" <?php if($cabinTypeData['id']==$cabinTypeId){ echo "selected"; } ?> > <?php echo $cabinTypeData['name']; ?></option>
						<?php
						}
						?>
					</select>
					</label>
				</div>
			</td>
			
			<td width="90" align="left">
				<div class="griddiv">
				<label>
				<div class="gridlable">Tariff&nbsp;Type<span class="redmind"></span></div>
					<select id="cr_tariffType2" name="cr_tariffType2" class="gridfield " displayname="Tariff Type" autocomplete="off" >
						<option value="1" <?php if($dmcroommastermain['tariffTypeId'] == 1){ ?>selected="selected"<?php } ?>>Normal</option>
						<option value="2" <?php if($dmcroommastermain['tariffTypeId'] == 2){ ?>selected="selected"<?php } ?>>Weekend</option>
					</select>
           		</label>
				</div>
			</td> 

			<td width="90" align="left" >
				<div class="griddiv">
				<label>
					<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div>
					<select id="cr_marketType2" name="cr_marketType2" class="gridfield" displayname="Market Type" autocomplete="off">
						<?php
						$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by id asc');
						while($marketD=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo strip($marketD['id']); ?>" <?php if($marketD['id']==$dmcroommastermain['marketType']){ ?>selected="selected"<?php } ?>><?php echo strip($marketD['name']); ?></option>
						<?php } ?>
					</select>
				</label>
				</div>
			</td> 

			<td width="90" align="left"><div class="griddiv"><label>
				<div class="gridlable">TAX&nbsp;SLAB(%)</div>
				<select id="cr_gstTax2" name="cr_gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
					<?php
					$rs2 = "";
					$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Cruise"');
					while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
						<option value="<?php echo $gstSlabData['id']; ?>" <?php if($dmcroommastermain['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
						<?php
					} ?>
				</select>
				</label>
				</div>
			</td>  
		</tr> 
		<tr>
			<td width="90" align="left">
				<div class="griddiv">
					<label>  
					<div class="gridlable">Currency<span class="redmind"></span></div>
					<select id="cr_currencyId2" name="cr_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'cr_currencyValue2');"    >
						<option value="">Select</option>
						<?php 
						$currencyId = ($dmcroommastermain['currencyId']>0)?$dmcroommastermain['currencyId']:$baseCurrencyId;
						$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
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
			<td width="90"  align="left"><div class="griddiv">
				<label> 
					<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input class="gridfield validate" type="text" name="cr_currencyValue2" displayname="ROI Value"  id="cr_currencyValue2" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
				</label>
				</div>
			</td>

			<td width="180" align="left" colspan="2">
				<div class="griddiv" style="width:190px">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
							<tr><td colspan="2" align="center">Adult Cost</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input name="cr_adultCost2" type="text" class="gridfield"  id="cr_adultCost2" value="<?php echo $dmcroommastermain['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
								</td>
								<td>
									<input name="cr_adultPax2" type="text" class="gridfield"  id="cr_adultPax2" value="<?php echo $adultPax2 ?>" maxlength="6" onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td>
			<td width="180" align="left" colspan="2">
				<div class="griddiv"  style="width:190px">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
							<tr><td colspan="2" align="center">Child Cost</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input name="cr_childCost2" type="text" class="gridfield"  id="cr_childCost2" value="<?php echo $dmcroommastermain['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
								</td>
								<td>
									<input name="cr_childPax2" type="text" class="gridfield"  id="cr_childPax2" value="<?php echo $childPax2 ?>" maxlength="6" onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td>

			<td width="180" align="left" colspan="2">
				<div class="griddiv"  style="width:190px">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
							<tr><td colspan="2" align="center">Infant Cost</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input name="cr_infantCost2" type="text" class="gridfield"  id="cr_infantCost2" value="<?php echo $dmcroommastermain['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
								</td>
								<td>
									<input name="cr_infantPax2" type="text" class="gridfield"  id="cr_infantPax2" value="<?php echo $infantPax2 ?>" maxlength="6" onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td> 
		</tr> 					
		<tr> 
			<td width="630" colspan="7" >
				<div class="griddiv">
					<label>
						<div class="gridlable">REMARKS</div>
						<input name="cr_remark2" type="text" class="gridfield" id="cr_remark2" value="<?php echo $dmcroommastermain['remark'] ?>" style="width: 99%;">
					</label>
				</div> 
			</td>
			<td width="90" align="left" valign="middle" >

				<input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('editServiceForm','saveflight','0');">
				<input name="cr_fromDatevalidity2" type="hidden" id="cr_fromDatevalidity2" value="<?php echo $newQuotationData['srdate']; ?>"> 
				<input name="cr_toDatevalidity2" type="hidden" id="cr_toDatevalidity2" value="<?php echo $newQuotationData['srdate']; ?>"> 

				<input name="cr_quotationId2" type="hidden" id="cr_quotationId2" value="<?php echo $newQuotationData['quotationId']; ?>"> 
				<input name="cr_queryId2" type="hidden" id="cr_queryId2" value="<?php echo $newQuotationData['queryId']; ?>"> 
				<input name="cr_destinationId2" type="hidden" id="cr_destinationId2" value="<?php echo $_REQUEST['destinationId']; ?>"> 
				<input name="cr_cruiseServiceId2" type="hidden" id="cr_cruiseServiceId2" value="<?php echo $cruiseServiceId ?>"> 

				<input name="cr_dayId2" type="hidden" id="cr_dayId2" value="<?php echo $_REQUEST['dayId']; ?>">
				<!-- <input name="cr_masterRateId2" type="hidden" id="cr_masterRateId2" value="<?php echo $masterRateId; ?>"> -->
				<!-- <input name="cr_quotationRateId2" type="hidden" id="cr_quotationRateId2" value="<?php echo $quotationRateId; ?>"> -->
				<!-- <input name="cr_tableN2" type="hidden" id="cr_tableN2" value="<?php echo $_REQUEST['tableN']; ?>"> -->

				<input name="cr_rateid2" type="hidden" id="cr_rateid2" value="<?php echo $_REQUEST['rateId'] ; ?>">
				<input name="cr_tableN2" type="hidden" id="cr_tableN2" value="<?php echo $_REQUEST['tableN'] ; ?>">


				<input name="action" type="hidden" id="action" value="addCruisePriceforQuotaion">

       		</td>
		</tr> 
		</tbody>
	</table>  
</form> 
</div>
</div>  