<?php 
	if($_REQUEST['transferid']!=''){  
		$aaaaaa=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.decode($_REQUEST['transferid']).'"'); 
		$transferData=mysqli_fetch_array($aaaaaa);

		$destinationId = $transferData['destinationId'];
		if($destinationId!=0){ 
			$whereDest = ' and FIND_IN_SET("'.$destinationId.'",destinationId) ';
		}else{ 
			$whereDest = ' '; 
		} 
		// '.$whereDest.'

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

	<script>
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
	  <tbody> 
	  	<tr style="background-color: transparent !important;">
	  	<!--    <td width="10%"  align="left"><div class="griddiv"> 
				<label> 
				<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div> 
				<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
				<?php   
				$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by id asc');  
				while($resListingm=mysqli_fetch_array($rs)){   
				?> 
				<option value="<?php echo strip($resListingm['id']); ?>" <?php if($resListingm['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListingm['name']); ?></option> 
				<?php } ?>
				</select></label>  
				</div>
			</td>  -->   
		<td width="10%" align="left" colspan="2"><div class="griddiv"><label>
		<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
		<select id="TransferSupplierId" name="TransferSupplierId" class="gridfield validate" displayname="Suppliers" autocomplete="off"   > 
			<option value="">Select</option> 
			<?php 
			// supplier master showing active and inactive
			// $where=' deletestatus=0 and name!="" and status=1 and transferType=5  '.$whereDest.' order by name asc';  
			$where=' deletestatus=0 and name!="" and status=1 and transferType=5  '.$whereDest.'  order by name asc';  
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
	    
		<td width="100" align="left"><div class="griddiv">
			<label>
			<div class="gridlable">Tarif Type<span class="redmind"></span></div>
			<select id="tarifType" name="tarifType" class="gridfield" displayname="Tarif Type" autocomplete="off" >
				<option value="1">Normal</option>
				<option value="2">Weekend</option>
			</select>
			</label>
			</div>
		</td>
		<td width="10%" align="left" >
			<div class="griddiv">
			<label> 
			<div class="gridlable">Type <span class="redmind"></span></div>
			<select id="transferType" name="transferType" class="gridfield validate" displayname="Transfer Type" onchange="selectTransferType(this);"> 
			 <option value="1" <?php if('1'==$_REQUEST['transferType']){ ?>selected="selected"<?php } ?>>SIC</option>
			<option value="2" <?php if('2'==$_REQUEST['transferType']){ ?>selected="selected"<?php } ?>>PVT</option>
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
			</select></label>
			</div>	
		</td>
		</tr>
	  	<tr style="background-color: transparent !important;">
		<td width="15%" align="left" colspan="1" class="PVT">
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
			$rs=GetPageRecord('name,id','vehicleTypeMaster',' status=1 and deletestatus=0 order by name asc'); 
			while($resListing=mysqli_fetch_array($rs)){  
			?>
			<option value="<?php echo strip($resListing['id']); ?>"><?php echo strip($resListing['name']); ?></option>
			<?php } ?> 
		 	</select>
			</label>
			</div>	
		</td>
	  	
		<!-- <td width="0%" align="left"  class="PVT"     style="" >
			<div class="griddiv"><label>
			<div class="gridlable">Vehicle&nbsp;Name</div>
			<select id="vehicleModelId" name="vehicleModelId" class="gridfield"  autocomplete="off" style="width: 100% ;">  
			</select>
			</label>
			</div>	
		</td> -->
		
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
	  	<td align="left" class="PVT"><div class="griddiv"><label>
			<div class="gridlable">Vehicle&nbsp;Cost </div>
			<input name="vehicleCost" type="text" class="gridfield"  id="vehicleCost" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
		<td width="10%" align="left" class="SIC">
			<div class="griddiv"><label>
			<div class="gridlable">Adult Cost</div>
			<input name="adultCost" type="text" class="gridfield"  id="adultCost" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100% ;"/>
			</label>
			</div>	
		</td>
	    
		<td width="10%" align="left" class="SIC"><div class="griddiv"><label>
			<div class="gridlable">Child Cost</div>
			<input name="childCost" type="text" class="gridfield"  id="childCost" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
			</label>
			</div>	
		</td>
		
		<td width="10%" align="left"  class="SIC" >
			<div class="griddiv"><label>
			<div class="gridlable">Infant Cost</div>
			<input name="infantCost" type="text" class="gridfield"  id="infantCost" maxlength="6" onkeyup="numericFilter(this);"  style="width: 100%;"/>
			</label>
			</div>	
		</td>
	  	<td align="left" class="SIC">
	  		<div class="griddiv"><label>
			<div class="gridlable">Rep&nbsp;Entry&nbsp;Fee</div>
			<input name="representativeEntryFee" type="text" class="gridfield"  id="representativeEntryFee" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
	  	<td align="left" class="PVT"><div class="griddiv"><label>
			<div class="gridlable">Parking&nbsp;Fee</div>
			<input name="parkingFee" type="text" class="gridfield"  id="parkingFee" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
	  	
	  	
	  	<td width="10%" align="left" class="PVT"><div class="griddiv"><label>
			<div class="gridlable">Assistance</div>
			<input name="assistance" type="text" class="gridfield"  id="assistance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
		<td align="left" width="70" class="PVT"><div class="griddiv"><label>
			<div class="gridlable">Additional&nbsp;Allowance</div>
			<input name="guideAllowance" type="text" class="gridfield"  id="guideAllowance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
	  	<td align="left" width="70"  class="PVT"><div class="griddiv"><label>
			<div class="gridlable">Inter&nbsp;State&nbsp;Toll </div>
			<input name="interStateAndToll" type="text" class="gridfield"  id="interStateAndToll" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
			</label>
			</div>
		</td>
		<td width="10%" align="left" valign="middle"  class="PVT" ><div class="griddiv"><label>
			<div class="gridlable">Misc Cost</div>
			<input name="miscellaneous" type="text" class="gridfield"  id="miscellaneous" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" />
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
			<input name="action" type="hidden" id="action" value="addTransferPrice">
		</td>
		</tr>
		</tbody>
		</table>
	</form>
	</div>
	</div>    
	    
	    
	</div>
	<div id="loadhotelmaster"></div>

	<style type="text/css">
		.PVT{
			display: none;
		}
		.SIC{
			display: table-cell;
		}
	</style>

	<script>  
	function funloadtransportormaster(transferNameId){ 
	$('#loadhotelmaster').load('loadtransfermaster.php?serviceid='+transferNameId); 
	}

	funloadtransportormaster(<?php echo decode($_REQUEST['transferid']); ?>);

	function funloadtransportormasteraddrate(fromDate,toDate,currencyId,sightseeingType){ 
	$('#loadhotelmaster').load('loadtransfermaster.php?serviceid=<?php echo decode($_REQUEST['transferid']); ?>&fromDate='+fromDate+'&toDate='+toDate+'&currencyId='+currencyId+'&transferType='+sightseeingType); 
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

	 
	$('#addnewuserbtn').show();
	</script>
	<script> 
	function selectTransferType(ele){
		if(ele.value == 1){
			$('.SIC').css('display','table-cell');
			$('.PVT').css('display','none');
		}else{
			$('.PVT').css('display','table-cell');
			$('.SIC').css('display','none');
		}
	}
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