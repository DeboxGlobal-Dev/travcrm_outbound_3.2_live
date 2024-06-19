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
	$transferCostType = $dmcroommastermain['transferCostType'];
	$remark = $dmcroommastermain['remark'];
	$gstTax = $dmcroommastermain['gstTax'];
	// $vehicleTypeId = $_REQUEST['vehicleTypeId'];
	$vehicleTypeId = ($dmcroommastermain['vehicleTypeId']);
	$capacity = ($dmcroommastermain['capacity']);
}elseif($_REQUEST['rateId'] > 0 && $_REQUEST['tableN'] == 1){
	$rsat=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$_REQUEST['rateId'].'"'); 
	$dmcroommastermain=mysqli_fetch_array($rsat);
	  
	$vehicleModelId = $dmcroommastermain['vehicleModelId'];
	$TransferSupplierId = $dmcroommastermain['supplierId'];
	$transferId = $dmcroommastermain['transferNameId'];
	$transferType = $dmcroommastermain['transferType'];
	$transferCostType = $_REQUEST['costType'];
	$remark = $dmcroommastermain['remark'];
	$vehicleTypeId = $_REQUEST['vehicleTypeId'];
	$gstTax = $dmcroommastermain['gstTax'];
	$capacity = ($dmcroommastermain['capacity']);

}else{ 
	$vehicleModelId = $_REQUEST['vehicleModelId'];
	$transferId = $_REQUEST['transferId'];
	$transferType = $_REQUEST['sic_pvt'];
	$transferCostType = $_REQUEST['costType'];
	$vehicleTypeId = $_REQUEST['vehicleTypeId'];
	$TransferSupplierId = '';
} 
// Transportation 
$rs2=GetPageRecord('transferName,id',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferId.'"'); 
$transferData1=mysqli_fetch_array($rs2); 

$destinationId = $transferData1['destinationId'];
if($destinationId>0){ 
	$whereDest = ' and FIND_IN_SET("'.$destinationId.'",destinationId) ';
}else{ 
	$whereDest = ' '; 
} 
// '.$whereDest.'

$rsq=GetPageRecord('*','queryMaster','id="'.$newQuotationData['queryId'].'"'); 
$resquery=mysqli_fetch_array($rsq);

$modelQuery=GetPageRecord('name,capacity','vehicleTypeMaster',' id="'.$vehicleTypeId.'"'); 
$modelData=mysqli_fetch_array($modelQuery); 
// $vehicleTypeId = ($modelData['carType']);
$capacity = ($modelData['capacity']);
// getVehicleTypeName 

?>  
<style>
.topaboxouter{margin: 30px;
    margin-top: 160px;}
.topabox{
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 0px #e8e8e8 solid;
    font-size: 18px;
}
	
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
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="88%" align="left"><strong style="font-size: 18px;"><?php echo clean($transferData1['transferName']); ?> </strong></td>
    <td width="12%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#viewinfo').hide();"></i></td>
  </tr> 
</table>

<div class="addeditpagebox addtopaboxlist">	
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm"  id="addhotelroomprice"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  <tbody> 
  	<tr style="background-color: transparent !important;">
  	   <td width="10%"  align="left">
		<div class="griddiv"><label>

		<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>

		<select id="TransferSupplierId" name="TransferSupplierId" class="gridfield validate" displayname="Suppliers" autocomplete="off" style=" width:150px;"  >  
			<?php 
			$where='status=1 and deletestatus=0 and name!="" and transferType=5 '.$whereDest.' order by name asc';  
			$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
			while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
				<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$TransferSupplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
				<?php  } ?>
		</select>

	</label>
	</div>
	   <div class="griddiv" style="display:none;"> 
		<label> 
		<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div> 
		<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
		<?php   
		$rs=GetPageRecord('*','marketMaster',' deletestatus=0 order by name asc');  
		while($resListing=mysqli_fetch_array($rs)){   
		?> 
		<option value="1" <?php if($resListing['id']==$dmcroommastermain['marketType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
		<?php } ?>
		</select></label>  
		</div> 
		<div class="griddiv" style="display:none;">
	<label> 
	<div class="gridlable">Currency<span class="redmind"></span></div>
	<select id="currencyId" name="currencyId" class="gridfield vaidate" displayname="Currency" autocomplete="off"  style="width:100%;"  > 
	<?php 
	$requestedCurr = ($_REQUEST['currencyId']!='')?$_REQUEST['currencyId']:1; 
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';    
	$where=' deletestatus=0 and status=1 order by name asc';  
	$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
	while($resListing=mysqli_fetch_array($rs)){
	?>
	<option value="1" <?php if($resListing['id']==$dmcroommastermain['currencyId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
	<?php } ?>
	</select>
	</label>
	</div><div class="griddiv" style="display:none;">
	<label> 
	<div class="gridlable">Type <span class="redmind"></span></div>
	<select id="transferType" name="transferType" class="gridfield" displayname="Transfer Type" autocomplete="off" style="width: 100% !important;"> 
	<option value="2" <?php if('2'==$_REQUEST['transferType']){ ?>selected="selected"<?php } ?>>Private</option>
	<!-- <option value="1" <?php if('1'==$_REQUEST['transferType']){ ?>selected="selected"<?php } ?>>SIC</option>-->
	</select>
	</label>
	</div><div class="griddiv" style="display:none;">
	<label>
	<div class="gridlable"> Name<span class="redmind"></span></div>
	<select id="transferNameId" name="transferNameId" class="gridfield validate" displayname="Transfer Name" autocomplete="off" style="width: 150px !important;" > 
	<?php 
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';    
	$where=' id="'.$transferId.'" order by transferName asc';  
	$rs=GetPageRecord($select,_PACKAGE_BUILDER_TRANSFER_MASTER,$where); 
	while($editTransferData=mysqli_fetch_array($rs)){  
	?>
	<option value="<?php echo strip($editTransferData['id']); ?>" ><?php echo strip($editTransferData['transferName']); ?></option>
	<?php } ?>
	</select>
	</label>
	</div> 
	<div class="griddiv" style="display:none;">
	<label> 
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off"   style="width: 100%;"> 	
	<option value="1" <?php if(1==$dmcroommastermain['status']){ ?>selected="selected"<?php } ?>>Active</option> 
	</select></label>
	</div></td>    
  	   <td width="100" align="left"><div class="griddiv">
	<label> 
	<div class="gridlable">Type <span class="redmind"></span></div>
	<select id="transferCostType" name="transferCostType" class="gridfield validate" displayname="Transfer Cost Type" autocomplete="off" style="width: 100% !important;" onchange="costType3(this.value);"> 
	<option value="1" <?php if($transferCostType == 1){ ?>selected="selected"<?php } ?>>Per Day Cost</option>
	<option value="2" <?php if($transferCostType == 2){ ?>selected="selected"<?php } ?>>Package Cost</option> 
	<option value="3" <?php if($transferCostType == 3){ ?>selected="selected"<?php } ?>>Per KM Cost</option> 
	</select>
	</label>
	</div></td>
	<td width="100" align="left">
	<div class="griddiv"><label>
	<div class="gridlable">Vehicle&nbsp;Type</div>
	<select id="vehicleTypeId2" name="vehicleType" class="gridfield" style="width: 100%;" onchange="getVehicleModel(this.value);">
	<?php    
	$rs="";
	$rs=GetPageRecord('*','vehicleTypeMaster','1 and name!="" and status=1 and deletestatus=0 order by name asc'); 
	while($editVehicleTypeData=mysqli_fetch_array($rs)){  ?>
	<option value="<?php echo strip($editVehicleTypeData['id']); ?>" <?php if($editVehicleTypeData['id']==$vehicleTypeId){ ?>selected="selected"<?php } ?>><?php echo strip($editVehicleTypeData['name']); ?></option>
	<?php } ?> 
 	</select>
	</label>
	</div></td>

	<td width="85" align="left" class=" "><div class="griddiv"><label>
		<div class="gridlable">Capacity</div>
			<input type="text" class="gridfield" maxlength="6"  value="<?php echo $capacity; ?>" disabled/>
			<input name="capacity" type="hidden" class="gridfield"  id="capacity" value="<?php echo $capacity; ?>"/>
		</label>
		</div>
	</td> 

	<td width="100" align="left"><div class="griddiv">
	<label> 
	<div class="gridlable">Tax <span class="redmind"></span></div>
	<select id="gstTaxttpt" name="gstTaxttpt" class="gridfield" displayname="Tax" autocomplete="off" style="width: 100% !important;"> 
 	<?php  
	$rs2="";
	$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Transfer" and status=1 order by gstSlabName asc'); 
	while($gstSlabData=mysqli_fetch_array($rs2)){
	?>
	<option value="<?php echo $gstSlabData['id']; ?>" <?php if($gstSlabData['id'] == $gstTax){ ?> selected="selected" <?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
	<?php
	}	
	?> 
	</select>
	</label>
	</div></td>

    <td width="100" align="left">
		<div class="griddiv">
			<label>  
			<div class="gridlable">Currency<span class="redmind"></span></div>
			<select name="currencyId3" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'currencyVal121');"    >
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
			<input class="gridfield validate" name="currencyValue3" displayname="ROI Value" id="currencyVal121" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
		</label>
		</div>
	</td>



	</tr>
  	<tr style="background-color: transparent !important;">

  	
	
	<td width="100" align="left"  class="" ><div class="griddiv"><label>
	<div class="gridlable" id="costTypeLable3">Vehicle&nbsp;Cost </div>
	<input name="vehicleCost" type="text" class="gridfield"  id="vehicleCost" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['vehicleCost']; ?>" />
	</label>
	</div></td>


	<td width="85" align="left" id="distanceBox3" style="display:none;">
		<div class="griddiv"><label>
			<div class="gridlable">Distance</div>
			<input name="distance" type="text" class="gridfield"  id="distance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['distance']; ?>" />
			</label>
		</div>
	</td> 
 
 <td align="left"><div class="griddiv"><label>
	<div class="gridlable">Representative&nbsp;Entry&nbsp;Fee</div>
	<input name="representativeEntryFee" type="text" class="gridfield"  id="representativeEntryFee" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['representativeEntryFee']; ?>" />
	</label>
	</div></td>
	<td align="left" class=" "><div class="griddiv"><label>
	<div class="gridlable">Parking&nbsp;Fee</div>
	<input name="parkingFee" type="text" class="gridfield"  id="parkingFee" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['parkingFee']; ?>" />
	</label>
	</div></td> 

  	   <td align="left"><div class="griddiv">
  	    <label>
        <div class="gridlable">Additional&nbsp;Allowance</div>
  	    <input name="guideAllowance" type="text" class="gridfield"  id="guideAllowance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['guideAllowance']; ?>" />
        </label>
      </div></td>
  	  <td align="left"><div class="griddiv">
  	    <label>
        <div class="gridlable">Assistance</div>
  	    <input name="assistance" type="text" class="gridfield"  id="assistance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['assistance']; ?>" />
        </label>
      </div></td>
  	 
  	  <td align="left"><div class="griddiv">
  	    <label>
        <div class="gridlable">Inter&nbsp;State&nbsp;&amp;&nbsp;Toll </div>
  	    <input name="interStateAndToll" type="text" class="gridfield"  id="interStateAndToll" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['interStateAndToll']; ?>" />
        </label>
      </div></td>

	  <td align="left"><div class="griddiv">
  	    <label>
        <div class="gridlable">Misc. Cost</div>
  	    <input name="miscellaneous" type="text" class="gridfield"  id="miscellaneous" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $dmcroommastermain['miscellaneous']; ?>" />
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
  	
  	  <td align="left" width="70" colspan="3"><div class="griddiv" >
  	    <label>
        <div class="gridlable">Remarks </div>
  	    <input name="detail" type="text" class="gridfield"  id="detail" maxlength="220"   style="width: 100%;" value="<?php echo $dmcroommastermain['detail']; ?>"/>
        </label>
      </div></td>
  	  	<td align="left" colspan="7">
		<input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;">
		<input name="fromDatetrn" type="hidden" id="fromDate" value="<?php echo $newQuotationData['srdate']; ?>"> 
		<input name="toDatetrn" type="hidden" id="toDate" value="<?php echo $newQuotationData['srdate']; ?>">  
		<input name="quotationId" type="hidden" id="quotationId" value="<?php echo $newQuotationData['quotationId']; ?>"> 
		<input name="tariffId" type="hidden" id="tariffId" value="<?php echo $dmcroommastermain['id']; ?>">
		<input name="tableN" type="hidden" id="tableN" value="<?php echo $_REQUEST['tableN']; ?>">
		<input name="transferNameId" type="hidden" id="transferNameId" value="<?php echo $transferId; ?>">
		
		<input name="action" type="hidden" id="action" value="addTransPortationPriceforQuotaion">
	</td>
  	  </tr>
	</tbody>
	</table>
</form>
</div>
</div>
  
<div id="vehicleTypeName"></div>
<script>

	function getVehicleModel(vehicleTypeId) {
	 var vehicleTypeId = $('#vehicleTypeId2').val(); 
	 $("#vehicleTypeName").load('searchaction.php?action=loadVehicleModeltyp&vehicleTypeId='+vehicleTypeId);
	}
 

	function costType3(transferCostType){ 
		if(transferCostType == 3){
			$('#distanceBox3').show();
			$('#costTypeLable3').text('Per KM Cost');
		}else if(transferCostType == 1){
			$('#distanceBox3').hide();
			$('#costTypeLable3').text('Per Day Cost');
		}else{
			$('#distanceBox3').hide();
			$('#costTypeLable3').text('Vehical Cost');
		}
	}

	costType3(<?php echo $transferCostType; ?>);
	getVehicleModel1();
	 
	 $(document).on("input", ".numeric", function() {
	    this.value = this.value.replace(/\D/g,'');
	}); 
 </script>
<style>
.SIC{display:none;}
</style>