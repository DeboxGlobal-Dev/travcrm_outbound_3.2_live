<?php
include "inc.php";    

$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
$newQuotationData=mysqli_fetch_array($dayQuery); 

 
if($_REQUEST['rateId'] > 0 && $_REQUEST['tableN'] == 2){
	$rsat=GetPageRecord('*','quotationTransferRateMaster','id="'.$_REQUEST['rateId'].'"'); 
	$dmcroommastermain=mysqli_fetch_array($rsat);
	  
	$vehicleModelId = $dmcroommastermain['vehicleModelId'];
	$TransferSupplierId = $dmcroommastermain['supplierId'];
	$transferId = $dmcroommastermain['transferNameId'];
	$transferType = $dmcroommastermain['transferType'];
	$adultCost = $dmcroommastermain['adultCost'];
	$childCost = $dmcroommastermain['childCost'];
	$infantCost = $dmcroommastermain['infantCost'];
	$remark = $dmcroommastermain['remark'];
	$vehicleTypeId = $_REQUEST['vehicleTypeId'];
}
elseif($_REQUEST['rateId'] > 0 && $_REQUEST['tableN'] == 1){
	$rsat=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$_REQUEST['rateId'].'"'); 
	$dmcroommastermain=mysqli_fetch_array($rsat);
	  
	$vehicleModelId = $dmcroommastermain['vehicleModelId'];
	$TransferSupplierId = $dmcroommastermain['supplierId'];
	$transferId = $dmcroommastermain['transferNameId'];
	$transferType = $dmcroommastermain['transferType'];
	$adultCost = $dmcroommastermain['adultCost'];
	$childCost = $dmcroommastermain['childCost'];
	$infantCost = $dmcroommastermain['infantCost'];
	$remark = $dmcroommastermain['remark'];
	$vehicleTypeId = $_REQUEST['vehicleTypeId'];
}else{ 
	$vehicleModelId = $_REQUEST['vehicleModelId'];
	$transferId = $_REQUEST['transferId'];
	$transferType = $_REQUEST['sic_pvt'];
	$vehicleTypeId = $_REQUEST['vehicleTypeId'];
	$TransferSupplierId = '';
	
}

$rs2=GetPageRecord('transferName,id',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferId.'"'); 
$transferData1=mysqli_fetch_array($rs2); 

$destinationId = $transferData1['destinationId'];
if($destinationId!=0){ 
	$whereDest = ' and FIND_IN_SET("'.$destinationId.'",destinationId) ';
}else{ 
	$whereDest = ' '; 
} 
// '.$whereDest.'

$rsq=GetPageRecord('*','queryMaster','id="'.$newQuotationData['queryId'].'"'); 
$resquery=mysqli_fetch_array($rsq);

$modelQuery=GetPageRecord('carType,model,capacity',_VEHICLE_MASTER_MASTER_,' id="'.$vehicleModelId.'"'); 
$modelData=mysqli_fetch_array($modelQuery); 
// $vehicleTypeId = ($modelData['carType']);

if($dmcroommastermain['capacity']>0){
	$capacity = ($dmcroommastermain['capacity']);
}else{
	$capacity = ($modelData['capacity']);
}


$marketId = getQueryMaketType($newQuotationData['queryId']); 
if($marketId<1){
	$marketId = 1;
}

// getVehicleTypeName 
?>  
<style>
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
    border-bottom: #f1f1f1 0px solid !important;     padding-bottom: 10px !important;
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
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="88%" align="center"><strong style="font-size: 18px;"><?php echo clean($transferData1['transferName']); ?> </strong></td>
    <td width="12%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#viewinfo').hide();"></i></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div class="addeditpagebox addtopaboxlist">	
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice2222" target="actoinfrm"  id="addhotelroomprice2222"> 
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  	<tr style="background-color: transparent !important;">
		<td width="150"  align="left">
		<div class="griddiv" style="border-bottom: 0px #eee solid;"><label>

				<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
				<select id="TransferSupplierId" name="TransferSupplierId3" class="gridfield validate" displayname="Suppliers" autocomplete="off" style=" width:150px;"  >  
				<?php 
				$where='status=1 and deletestatus=0 and name!="" and transferType=5 '.$whereDest.' order by name asc';  
				$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
				while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
				<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$TransferSupplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
				<?php  } ?>
				</select>

				</label>
				</div>  
		</td>    
<?php 
if($transferType==2){
?>
  	<td width="150" align="left">
  		<script>
			function showmaxpax(){
			var vehicleId = $('#vehicleId').val();
			//$('#maxpaxbox').load('loadmaxpaxdmcbox.php?id='+vehicleId);
			}
		</script>
		<div class="griddiv"><label>
			<div class="gridlable">Vehicle&nbsp;Type</div>
			<select id="vehicleTypeId2" name="vehicleType3" class="gridfield"  autocomplete="off" style="width: 100%;" onchange="getVehicleModel(this.value);">
			<?php    
			
			$rs=GetPageRecord('*','vehicleTypeMaster','status=1 and deletestatus=0 order by name asc'); 
			while($editVehicleTypeData=mysqli_fetch_array($rs)){  
			?>
			<option value="<?php echo strip($editVehicleTypeData['id']); ?>" <?php if($editVehicleTypeData['id']==$vehicleTypeId){ ?>selected="selected"<?php } ?>><?php echo strip($editVehicleTypeData['name']); ?></option>
			<?php } ?> 
		 	</select>
			</label>
		</div>
	</td>
<?php } ?>

	<!-- <td width="150" align="left" >
	<script type="text/javascript">
	// getVehicleModel(<?php echo $vehicleTypeId; ?>);
	function getVehicleModel(vehicleTypeId) {
		$("#vehicleModelId2").load('loadvehiclemodel.php?action=loadVehicleModel&vehicleTypeId='+vehicleTypeId);
	}
	</script>
	<div class="griddiv"><label>
	<div class="gridlable">Vehicle&nbsp;Name</div>
	<select id="vehicleModelId2" name="vehicleModelId3" class="gridfield"  autocomplete="off" style="width: 100% ;">  
	<?php 
	$select='*';    
	 $where=' 1 and status=1 and deletestatus=0 order by name asc';  
	$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
	while($editVehicleMData=mysqli_fetch_array($rs)){  
	?>
	<option value="<?php echo $editVehicleMData['id']; ?>" <?php if($editVehicleMData['id']==$vehicleModelId){ ?>selected="selected"<?php } ?>><?php echo $editVehicleMData['model']; ?></option>
	<?php } ?>
	</select>
	</label>
	</div></td> -->


	<td width="100" align="left"><div class="griddiv">
		<label> 
		<div class="gridlable">TAX&nbsp;SLAB (%)<span class="redmind"></span></div>
		
		<select id="gstTax" name="gstTax3" class="gridfield " displayname="GST Tax" autocomplete="off" style="width: 100% !important;"> 
		<?php 
		$rs2="";
		$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Transfer" and status=1 order by gstSlabName asc'); 
		while($gstSlabData=mysqli_fetch_array($rs2)){
		?>
		<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id']==$dmcroommastermain['gstTax']){ ?>selected="selected"<?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
		<?php
		}	
		?>
		</select>
		</label>
		</div>
	</td>

	<td width="100" align="left"><div class="griddiv">
		<label>
		<div class="gridlable">Tarif&nbsp;Type<span class="redmind"></span></div>
		<select id="tarifType" name="tarifType3" class="gridfield" displayname="Tarif Type" autocomplete="off" >
			<option value="1" <?php if('1'==$dmcroommastermain['tarifType']){ ?>selected="selected"<?php } ?>>Normal</option>
			<option value="2" <?php if('2'==$dmcroommastermain['tarifType']){ ?>selected="selected"<?php } ?>>Weekend</option>
		</select>
		</label>
		</div>
	</td>
	<td width="100" align="left" >
		<div class="griddiv">
		<label> 
		<div class="gridlable">Type<span class="redmind"></span></div>
		<select id="transferType" name="transferType3" class="gridfield validate" displayname="Transfer Type" onchange="selectTransferType3(this.value);"> 
		 <option value="1" <?php if($transferType=='1'){ ?>selected="selected"<?php } ?>>SIC</option>
		<option value="2" <?php if($transferType=='2'){ ?>selected="selected"<?php } ?>>PVT</option>
		</select>
		</label>
		</div>	
	</td>
	<td width="100" align="left">
		<div class="griddiv">
			<label>  
			<div class="gridlable">Currency<span class="redmind"></span></div>
			<select name="currencyId3" class="gridfield validate" displayname="Currency" autocomplete="off"  onchange="getROE(this.value,'currencyVal122');"    >
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
	<td width="100"  align="left">
		<div class="griddiv" >
		<label> 
			<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
			<input class="gridfield validate" name="currencyValue3" displayname="ROI Value"  id="currencyVal122" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
		</label>
		</div>
	</td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
<tr style="background-color: transparent !important;">
	<td width="100" align="left"  class="PVT3" ><div class="griddiv"><label>
		<div class="gridlable">Vehicle&nbsp;Cost </div>
		<input name="vehicleCost3" type="text" class="gridfield"  id="vehicleCost" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['vehicleCost']; ?>" />
		</label>
		</div>
	</td>
	<td align="left" width="100"><div class="griddiv"><label>
		<div class="gridlable">Rep.&nbsp;Cost</div>
		<input name="representativeEntryFee3" type="text" class="gridfield"  id="representativeEntryFee" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['representativeEntryFee']; ?>" />
		</label>
		</div>
	</td>
	  	
	<td width="70" align="left" class="SIC3"><div class="griddiv"><label>
		<div class="gridlable">Adult&nbsp;Cost</div>
		<input name="adultCost3" type="text" class="gridfield"  id="adultCost" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $adultCost; ?>" />
		</label>
		</div>
	</td> 
  	<td width="70" align="left" class="SIC3"><div class="griddiv"><label>
		<div class="gridlable">Child&nbsp;Cost</div>
		<input name="childCost3" type="text" class="gridfield"  id="childCost" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $childCost; ?>" />
		</label>
		</div>
	</td>  
  	<td width="70" align="left" class="SIC3"><div class="griddiv"><label>
		<div class="gridlable">Infant&nbsp;Cost</div>
		<input name="infantCost3" type="text" class="gridfield"  id="infantCost" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $infantCost; ?>" />
		</label>
		</div>
	</td> 
  
	<td width="70" align="left" class="PVT3"><div class="griddiv"><label>
		<div class="gridlable">Parking&nbsp;Fee</div>
		<input name="parkingFee3" type="text" class="gridfield"  id="parkingFee" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['parkingFee']; ?>" />
		</label>
		</div>
	</td> 
  	  <td align="left" class="PVT3"><div class="griddiv"><label>
	<div class="gridlable">Assistance</div>
	<input name="assistance3" type="text" class="gridfield"  id="assistance" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['assistance']; ?>" />
	</label>
	</div></td>
  	  <td align="left" class="PVT3"><div class="griddiv"><label>
	<div class="gridlable">Additional&nbsp;Allowance</div>
	<input name="guideAllowance3" type="text" class="gridfield"  id="guideAllowance" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['guideAllowance']; ?>" />
	</label>
	</div></td>
  	  <td align="left" class="PVT3"><div class="griddiv"><label>
	<div class="gridlable">Inter&nbsp;State&nbsp;&&nbsp;Toll </div>
	<input name="interStateAndToll3" type="text" class="gridfield"  id="interStateAndToll" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['interStateAndToll']; ?>" />
	</label>
	</div></td>
  	  <td align="left" width="70" class="PVT3"><div class="griddiv"><label>
	<div class="gridlable">Misc. Cost</div>
	<input name="miscellaneous3" type="text" class="gridfield"  id="miscellaneous" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['miscellaneous']; ?>" />
	</label>
	</div></td>
	</tr>
	<tr>
	<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($dmcroommastermain['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($dmcroommastermain['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $dmcroommastermain['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td> 
  	  <td align="left" width="70" colspan="10" ><div class="griddiv" ><label>
	<div class="gridlable">Remarks </div>
	<input name="detail3" type="text" class="gridfield"  id="detail" maxlength="220"   style="width: 100%;" value="<?php echo $dmcroommastermain['detail']; ?>"/>
	</label>
	</div></td>
	 <td align="left" ><input type="button" name="Submit" value=" Save " class="bluembutton"  onclick="formValidation('addhotelroomprice2222','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;">
		<input name="fromDatetrn3" type="hidden" id="fromDate" value="<?php echo $newQuotationData['srdate']; ?>"> 
		<input name="toDatetrn3" type="hidden" id="toDate" value="<?php echo $newQuotationData['srdate']; ?>"> 
		<input name="quotationId3" type="hidden" id="quotationId" value="<?php echo $newQuotationData['quotationId']; ?>"> 
		<input name="queryId3" type="hidden" id="queryId" value="<?php echo $newQuotationData['queryId']; ?>"> 
		<input name="transferNameId3" type="hidden" id="transferNameId" value="<?php echo $transferId; ?>"> 
		<input name="tariffId3" type="hidden" id="tariffId" value="<?php echo $dmcroommastermain['id']; ?>">
		<input name="tableN3" type="hidden" id="tableN" value="<?php echo $_REQUEST['tableN']; ?>">
		<input name="action" type="hidden" id="action" value="addTransferPriceforQuotaion"></td>
		<!-- <input type="hidden" name="transferType" id="transferType" value="2"> -->
		<input type="hidden" id="status" name="status3"  value="1">
		<input type="hidden" id="marketType" name="marketType3"  value="<?php echo $marketId; ?>">
		<input type="hidden" id="capacity" name="capacity3"  value="<?php echo $capacity; ?>">
		<input type="hidden" id="status" name="status3"  value="1">
  	  </tr>
  	
	</tbody>
	</table>
</form>
</div>
</div>
 
 <script>
 $(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/\D/g,'');
}); 
	function selectTransferType3(transferType){
		if(transferType == 1){
			$('.SIC3').css('display','table-cell');
			$('.PVT3').css('display','none');
		}else{
			$('.PVT3').css('display','table-cell');
			$('.SIC3').css('display','none');
		}
	}
selectTransferType3(<?php echo trim($transferType); ?>);
</script>
<style>
.SIC3{display:none;}
.PVT3{display:none;}
</style>