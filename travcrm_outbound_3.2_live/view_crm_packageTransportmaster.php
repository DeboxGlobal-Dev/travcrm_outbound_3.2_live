<?php 
if($_REQUEST['transferid']!=''){  
	$aaaaaa=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.decode($_REQUEST['transferid']).'"'); 
	$transferData=mysqli_fetch_array($aaaaaa);

	$whereDest='';
	if($transferData['destinationId']>0){
		$whereDest=' and FIND_IN_SET("'.$transferData['destinationId'].'", destinationId) ';
	}
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

<script type="text/javascript">
$(document).ready(function() {  
	$('#toDate').Zebra_DatePicker({ 
	  format: 'd-m-Y',  
	}); 

	$('#fromDate').Zebra_DatePicker({ 
	  direction: true,
	  format: 'd-m-Y',  
	  pair: $('#toDate')
	});  
});


function openclose(id){

	if(id==1){
	$('#addnewuserbtn').hide();
	$('#addTriffRoom').show();
	$('#fromDate').focus();
	} else {
	$('#addnewuserbtn').show();
	$('#addTriffRoom').hide();
	}

}
</script>

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
     </td>
    <td width="92%" align=""><?php echo ucfirst($transferData['transferName']); ?></td>
  </tr>
  
</table>
</div>

<div class="topaboxouter">
<div id="addTriffRoom" style="display:nonde; margin-top: -40px;">
<div class="addGreenHeader">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="36%">Add&nbsp;<?php echo ($transferData['transferCategory']=='transportation')?'Transportation':'Transfer';?> Rate</td>
      <td width="61%">&nbsp;</td>
      <!-- <td width="3%" align="right" valign="top"><strong style="cursor:pointer;" onClick="openclose(0);"><i class="fa fa-times"></i></strong></td> -->
    </tr>
  </table>
</div>
<div class="addeditpagebox addtopaboxlist">	
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm"  id="addhotelroomprice"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  	<tr style="background-color: transparent !important;">
 
	<td width="20%" align="left" colspan="2"><div class="griddiv"><label>
		<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
		<select id="TransferSupplierId" name="TransferSupplierId" class="gridfield validate" displayname="Suppliers" autocomplete="off"   > 
			<option value="">Select</option> 
			<?php 
			// supplier master showing active and inactive
			$where=' deletestatus=0 and name!="" and status=1 and transferType=5 '.$whereDest.' order by name asc';  
			$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
			while($resultlists=mysqli_fetch_array($rs)){   ?> 
			<option value="<?php echo strip($resultlists['id']); ?>" ><?php echo strip($resultlists['name']); ?></option> 
			<?php  } ?>
		</select>

		</label>

		</div>
	</td>

		<td width="10%" align="left" colspan="2"><div class="griddiv"><label>

	<div class="gridlable">Destination<span class="redmind"></span></div>

	<select id="rateDestinationId" name="rateDestinationId" class="gridfield validate" displayname="Destination" autocomplete="off"   > 
	 	<option value="all_dest">All</option>
		<?php 
		$whereD=' deletestatus=0 and name!="" and status=1 order by name asc';  
		$rs=GetPageRecord('id,name',_DESTINATION_MASTER_,$whereD);   
		while($resultlistsD=mysqli_fetch_array($rs)){   ?> 
		<option value="<?php echo strip($resultlistsD['id']); ?>" ><?php echo strip($resultlistsD['name']); ?></option> 
		<?php  } ?>
	</select>

	</label>

	</div></td>

		<td width="10%" align="left"><div class="griddiv">
			<label>
			<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
			<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="" style="width: 100% !important;"/>
			</label>
			</div>	
		</td>

		<td width="10%" align="left"><div class="griddiv">
			<label>
			<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
			<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value=""  style="width: 100% !important;" />
			</label>
			</div>	
		</td>
		
		<td width="10%" align="left"><div class="griddiv">
			<label>
			<div class="gridlable">Tarif Type<span class="redmind"></span></div>
			<select id="tarifType" name="tarifType" class="gridfield" displayname="Tarif Type" autocomplete="off" >
				<option value="1">Normal</option>
				<option value="2">Weekend</option>
			</select>
			</label>
			</div>
		</td>
		<td width="10%" align="left">
			<div class="griddiv">
			<label> 
			<div class="gridlable">Currency<span class="redmind"></span></div>
			<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off"  style="width:100%;"  >
			<option value="">Select</option>
			<?php 
			// $requestedCurr = ($_REQUEST['currencyId']!='')?$_REQUEST['currencyId']:1; 
			$select=''; 
			$where=''; 
			$rs='';  
			$select='*';    
			$where=' deletestatus=0 and status=1 order by name asc';  
			$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
			while($resListing=mysqli_fetch_array($rs)){
			?>
			<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['setDefault']==1){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
			<?php } ?>
			</select>
			</label>
			</div>	
		</td>
	    
		<td width="10%" align="left" valign="middle"  >
			<div class="griddiv">
			<label> 
				<div class="gridlable">Status</div>
				<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off"   style="width: 100%;"> 	
					<option value="1">Active</option>
					<option value="0">In Active</option>
				</select>
			</label>
			</div>	
		</td>

		<td width="11%" align="left" colspan="1">
		 	<script>
			function showmaxpax(){
			var vehicleId = $('#vehicleId').val();
			//$('#maxpaxbox').load('loadmaxpaxdmcbox.php?id='+vehicleId);
			}
			</script>
			<div class="griddiv"><label>
			<div class="gridlable">Vehicle&nbsp;Type</div>
			<select id="vehicleType" name="vehicleType" class="gridfield"  autocomplete="off" style="width: 100%;" onchange="getVehicleModel();">
			<?php    
			$rs=GetPageRecord('name,id','vehicleTypeMaster',' 1 order by name asc'); 
			while($resListing=mysqli_fetch_array($rs)){  
			?>
			<option value="<?php echo strip($resListing['id']); ?>"><?php echo strip($resListing['name']); ?></option>
			<?php } ?> 
		 	</select>
			</label>
			</div>	
		</td>
	  	
		<td width="10%" align="left" style="display:none;" >
			<div class="griddiv"><label>
			<div class="gridlable">Vehicle&nbsp;Name</div>
			<select id="vehicleModelId" name="vehicleModelId" class="gridfield"  autocomplete="off" style="width: 100% ;">  
			</select>
			</label>
			</div>	
		</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  	<tr style="background-color: transparent !important;">
		
	    <td width="10%" align="left" ><div class="griddiv">
			<label> 
			<div class="gridlable">Cost Type <span class="redmind"></span></div>

			<select id="transferCostType" name="transferCostType" class="gridfield validate" displayname="Transfer Cost Type" autocomplete="off" style="width: 100% !important;" onchange="costType(this.value);"> 
				<option value="2" <?php if('2'==$_REQUEST['transferCostType']){ ?>selected="selected"<?php } ?>>Package Cost</option>
			 	<option value="1" <?php if('1'==$_REQUEST['transferCostType']){ ?>selected="selected"<?php } ?>>Per Day Cost</option>
			 	<option value="3" <?php if('3'==$_REQUEST['transferCostType']){ ?>selected="selected"<?php } ?>>Per KM</option>
			</select>

			</label>
			</div>
		</td>
	  	<td align="left" ><div class="griddiv"><label>
			<div class="gridlable" id="costTypeLable">Vehicle&nbsp;Cost</div>
			<input name="vehicleCost" type="text" class="gridfield"  id="vehicleCost" onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td> 
	  	
	  	<td align="left" id="distanceBox" style="display:none;"><div class="griddiv"><label>
			<div class="gridlable">Distance(In KM)</div>
			<input name="distance" type="text" class="gridfield" id="distance" onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
	  	<td align="left"><div class="griddiv"><label>
			<div class="gridlable">Parking&nbsp;Fee</div>
			<input name="parkingFee" type="text" class="gridfield"  id="parkingFee" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
	  	
	  	
	  	<td width="10%" align="left"><div class="griddiv"><label>
			<div class="gridlable">Assistance</div>
			<input name="assistance" type="text" class="gridfield"  id="assistance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
		<td align="left" width="70"><div class="griddiv"><label>
			<div class="gridlable">Additional&nbsp;Allowance</div>
			<input name="guideAllowance" type="text" class="gridfield"  id="guideAllowance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
	  	<td align="left" width="70" ><div class="griddiv"><label>
			<div class="gridlable">Inter&nbsp;State&nbsp;Toll </div>
			<input name="interStateAndToll" type="text" class="gridfield"  id="interStateAndToll" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
		<td width="10%" align="left" valign="middle"  ><div class="griddiv"><label>
			<div class="gridlable">Misc Cost</div>
			<input name="miscellaneous" type="text" class="gridfield"  id="miscellaneous" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
		<td align="left" >
	  		<div class="griddiv"><label>
			<div class="gridlable">Rep&nbsp;Entry&nbsp;Fee</div>
			<input name="representativeEntryFee" type="text" class="gridfield"  id="representativeEntryFee" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>

		<td width="10%" align="left" valign="middle"  ><div class="griddiv">
			<label> 
			<div class="gridlable">TAX&nbsp;SLAB(TAX %)<span class="redmind"></span></div>
			
			<select id="gstTax" name="gstTax" class="gridfield " displayname="GST Tax" autocomplete="off" style="width: 100% !important;"> 
			<?php 
			$rs2="";
			$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Transfer" and status=1 order by gstSlabName asc'); 
			while($gstSlabData=mysqli_fetch_array($rs2)){
			?>
			<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
			<?php
			}	
			?>
			</select>
			</label>
			</div>
		</td>
		<td align="left" valign="middle"  style="width: 60px;">
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1">%</option>
                        <option value="2">Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
		<td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td>

			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Remarks</div>
						<input name="dmcRemarks" type="text" class="gridfield"  id="dmcRemarks" maxlength="12" />
					</label>
				</div>
			</td> 
	</tr> 
	<tr>
		<td width="10%" colspan="10" align="left" valign="middle"  >
			<div class="griddiv" >
			<label>
			<div class="gridlable">Remarks </div>
			<input name="detail" type="text" class="gridfield"  id="detail" maxlength="220"   style="width: 100%;"/>
			</label>
			</div>
		</td>
	  	<td align="left" valign="middle"  >
	  		<input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;">
			<!--<input name="TransferSupplierId" type="hidden" id="TransferSupplierId" value="<?php echo $_REQUEST['id']; ?>">-->
			<input name="transferNameId" type="hidden" id="transferNameId" value="<?php echo $transferData['id']; ?>">
			<input name="serviceid" type="hidden" id="serviceid" value="<?php echo decode($_REQUEST['transferid']); ?>">
			<input name="module" type="hidden" id="module" value="<?php echo trim($_REQUEST['module']); ?>">
			<input name="transferType" type="hidden" id="transferType" value="2">
			<input name="action" type="hidden" id="action" value="addTransferPrice">
		</td>
	</tr>
	</table>
</form>
</div>
</div>    
    
    
</div>
<div id="loadhotelmaster"></div>
<script>  

function funloadtransportormaster(transferNameId){ 
$('#loadhotelmaster').load('loadtransportormaster.php?serviceid='+transferNameId); 
}

funloadtransportormaster(<?php echo decode($_REQUEST['transferid']); ?>);

function funloadtransportormasteraddrate(fromDate,toDate,currencyId,sightseeingType){ 
$('#loadhotelmaster').load('loadtransportormaster.php?serviceid=<?php echo decode($_REQUEST['transferid']); ?>&fromDate='+fromDate+'&toDate='+toDate+'&currencyId='+currencyId+'&transferType='+sightseeingType); 
}

window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);

comtabopenclose('linkbox','op2');

$('#importhotel').click(function(){
    $('#importfield').click();
});

$('#importsightseeing').click(function(){
    $('#importfieldsightseeing').click();
});

$('#importtransfer').click(function(){
    $('#importfieldtransfer').click();
});

function submitimportfrom(){
	startloading();
	$('#importfrmhotel').submit(); 
}

function submitimportfrom2(){
	startloading();
	$('#importfrmsightseeing').submit();
}

function submitimportfrom3(){
	startloading();
	$('#importfrmtransfer').submit();
}

function costType(transferCostType){ 
	if(transferCostType == 3){
		$('#distanceBox').show();
		$('#costTypeLable').text('Per KM Cost');
	}else if(transferCostType == 1){
		$('#distanceBox').hide();
		$('#costTypeLable').text('Per Day Cost');
	}else{
		$('#distanceBox').hide();
		$('#costTypeLable').text('Vehical Cost');
	}
}

 
$('#addnewuserbtn').show();
</script>
<script> 
<?php if($_REQUEST['fromDate']!=''){ ?>
openclose(1);
<?php } ?>
function loadHotelRoom(){
funloadhotelmaster('<?php echo $_REQUEST['id']; ?>');
}

$('#addnewuserbtn').show();

function getVehicleModel() {
 var vehicleId = $('#vehicleType').val();  
 $("#vehicleModelId").load('loadvehiclemodel.php?action=loadVehicleModel&vehicleTypeId='+vehicleId);
}
</script>

<?php } ?>