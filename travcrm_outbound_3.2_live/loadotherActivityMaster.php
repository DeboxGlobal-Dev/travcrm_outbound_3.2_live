<?php
include "inc.php"; 

if($_REQUEST['serviceid']!=''){
	$serviceid=clean($_REQUEST['serviceid']);
	$select1='*';
	$where1='id="'.$serviceid.'"';
	$rs1=GetPageRecord($select1,'packageBuilderotherActivityMaster',$where1);
	$otherActivityData=mysqli_fetch_array($rs1);
	$otherActivityName=clean($otherActivityData['otherActivityName']);
	$transferType=clean($otherActivityData['transferType']);


	$rs1=GetPageRecord('*',_DESTINATION_MASTER_,' UPPER(name)="'.strtoupper($otherActivityData['otherActivityCity']).'" ');
	$destinationData=mysqli_fetch_array($rs1);
	
	$whereDest='';
	if($destinationData['id']>0){
		$whereDest=' and FIND_IN_SET("'.$destinationData['id'].'", destinationId) ';
	}
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
	    padding-left: 45px;}
		
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
	 
	.style1 {font-weight: bold}
</style>

<script>
 $(document).ready(function() {  
$('#toDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
}); 

$('#fromDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
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

<div class="topaboxouter">
 
<div id="addTriffRoom" style="display:nxone;">
<div class="addGreenHeader">Add Sightseeing</div>
<div class="addeditpagebox addtopaboxlist"> 
	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm"  id="addhotelroomprice"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  <tbody> 
  <tr style=" background-color: transparent !important;">
  <!--   <td width="10%"  align="left"><div class="griddiv"> 
		<label> 
		<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div> 
		<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
		<?php   
		$rs11=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by id asc');  
		while($resListing=mysqli_fetch_array($rs11)){   
		?> 
		<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
		<?php } ?>
		</select></label>  
		</div></td>   -->
  	<td width="11%"  align="left"><div class="griddiv" >
	<label> 
	<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
	<select id="activitySupplierId" name="activitySupplierId" class="gridfield " displayname="Supplier" autocomplete="off"   style="width: 100%;"> 
	<?php   
	$rs='';   
	$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" '.$whereDest.' and status=1 and activityType=3 group by name order by name asc'); 
	while($supplierData=mysqli_fetch_array($rs)){   
	?>
	<option value="<?php echo strip($supplierData['id']); ?>" <?php if($supplierData['id']==$_REQUEST['id']){ ?>selected="selected"<?php } ?> ><?php echo strip($supplierData['name']); ?></option>
	<?php } ?>
	</select></label>
	</div></td>

	<td width="8%" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Nationality<span class="redmind"></span></div>
							<select id="nationalityType" name="nationalityType" class="gridfield" displayname="Nationality" autocomplete="off" onchange="getCurrencyfun();">
								<option value="1">Local</option>
								<option value="2">Foreign</option>
							</select>
							</label>
							</div>
							<script>
								function getCurrencyfun(){
									var nationalityType = $('#nationalityType').val();
									$('#currencyIdr').load('loadCurrencyEntrance.php?nationalityType='+nationalityType);
								}
								getCurrencyfun();
							</script>
						</td>
						<td width="8%" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Tarif Type<span class="redmind"></span></div>
							<select id="tarifType" name="tarifType" class="gridfield" displayname="Tarif Type" autocomplete="off" >
								<option value="1">Normal</option>
								<option value="2">Weekend</option>
							</select>
							</label>
							</div>
						</td>

	<td width="10%" align="left"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php echo $_REQUEST['fromDate']; ?>"  style="width: 100%;" />
	</label>
	</div></td>

	<td width="10%" align="left"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
	<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php echo $_REQUEST['toDate']; ?>" style="width: 100%;"/>
	</label>
	</div></td>
    <td width="7%" align="left"><div class="griddiv">
	<label>  
	<div class="gridlable">Currency<span class="redmind"></span></div>
	<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off"    >
	<option value="">Select</option>
	 <?php 
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
	</select></label>
		</div></td>
	 
    <!-- <td width="3%" align="center" ><div style="float:left; text-align: center; width: fit-content;"><strong>Upto</strong>&nbsp;</div></td>
    <td width="5%" align="left" ><div class="griddiv"><label>
	<div class="gridlable">Pax&nbsp;Range</div>
	<input name="maxpax" type="text" class="gridfield"  id="maxpax" maxlength="6" onkeyup="numericFilter(this);getPerPaxCost();"  />
	</label>
	</div></td>
    <td width="3%" align="center" ><div style="float:left; width: fit-content;">&nbsp;<strong>Pax</strong></div></td>
    <td width="7%" align="left" ><div class="griddiv"><label>
	<div class="gridlable">Total&nbsp;Cost</div>
	<input name="activityCost" type="text" class="gridfield"  id="activityCost" maxlength="6" onkeyup="numericFilter(this);getPerPaxCost();" style="width: 100px; text-align: center;" />
	</label>
	</div></td>

    <td width="6%" align="left" ><div class="griddiv"><label>
	<div class="gridlable">Per&nbsp;Pax&nbsp;Cost</div>
	<input name="perPaxCost" type="text" class="gridfield" readonly="" id="perPaxCost" maxlength="6" onkeyup="numericFilter(this);" style="width: 100px; text-align: center;" />
	</label>
	</div></td>  -->

	<td width="8%">
		<div class="griddiv"><label>

			<div class="gridlable">Transfer&nbsp;Type</div>

			<select id="ActransferType" name="ActransferType" class="gridfield " autocomplete="off" onchange="selectTransferType(this);"  onclick="selectTransferType(this);">
				<?php if($transferType==0 || $transferType==4){ ?>
				<option value="4" <?php if ($editresult['transferType'] == '4') { ?> selected="selected" <?php } ?>>Ticket Only</option>
				<?php } if($transferType==0 || $transferType==1){ ?>
				<option value="1" <?php if ($editresult['transferType'] == '1') { ?> selected="selected" <?php } ?>>SIC</option>
				<?php } if($transferType==0 || $transferType==2){ ?>
				<option value="2" <?php if ($editresult['transferType'] == '2') { ?> selected="selected" <?php } ?>>PVT</option>
				<?php } if($transferType==0 || $transferType==3){ ?>
				<option value="3" <?php if ($editresult['transferType'] == '3') { ?> selected="selected" <?php } ?>>VIP</option>
				<?php } ?>
			</select>

			</label>

		</div>
	</td>

	<td width="10%" align="left"><div class="griddiv"><label>
		<div class="gridlable">Adult Ticket Cost</div>
			<input name="ticketAdultCost" type="text" class="gridfield"  id="ticketAdultCost" maxlength="6" onkeyup="numericFilter(this);" />
			</label>
		</div>
	</td>
						
	<td width="10%" align="left">
		<div class="griddiv"><label>
			<div class="gridlable">Child Ticket Cost</div>
				<input name="ticketchildCost" type="text" class="gridfield"  id="ticketchildCost" maxlength="6" onkeyup="numericFilter(this);" />
			</label>
		</div>
	</td>

	<td width="10%" align="left">
		<div class="griddiv"><label>
			<div class="gridlable">Infant Ticket Cost</div>
				<input name="ticketinfantCost" type="text" class="gridfield"  id="ticketinfantCost" maxlength="6" onkeyup="numericFilter(this);" />
			</label>
		</div>
	</td>

  
    
	<td width="8%" align="left" valign="middle"  ><div class="griddiv">
	<label>  
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off" >  
		<option value="1">Active</option>
		<option value="0">In Active</option>
		</select></label>
	</div></td>
	</tr>

	<table width="100%">
							<tr>
								<!-- PRIVATE TRANSFER TPE -->
								<td width="10%" class="PVT" style="display:none;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Vehicle&nbsp;Type</div>
											<select id="vehicleId" name="vehicleId" class="gridfield" displayname="Vehicle Name" autocomplete="off" >
											<?php 
											$rs2="";
											$rs2=GetPageRecord('*','vehicleTypeMaster',' 1 and name!="" and status="1" order by name asc ');
											while($vehicleData=mysqli_fetch_array($rs2)){
											?>
											<option value="<?php echo $vehicleData['id'];?>"><?php echo $vehicleData['name']; ?> </option>
											<?php
											}
											?>
											</select>
										</label>
									</div>
								</td>
								<td width="10%" class="PVT" style="display:none;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Vehicle Cost</div>
											<input name="vehicleCost" type="text" class="gridfield" id="vehicleCost" style="width: 99%;">
										</label>
									</div>
								</td>
								<!-- SIC TYPE -->
								<td width="10%" class="SIC" style="display:table-cell;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Adult Transfer Cost</div>
											<input name="adultCost" type="text" class="gridfield" id="adultCost" style="width: 99%;">
										</label>
									</div>
								</td>
								<td width="10%" class="SIC" style="display:table-cell;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Child Transfer Cost</div>
											<input name="childCost" type="text" class="gridfield" id="childCost" style="width: 99%;">
										</label>
									</div>
								</td>
								<td width="10%" class="SIC" style="display:table-cell;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Infant Transfer Cost</div>
											<input name="infantCost" type="text" class="gridfield" id="infantCost" style="width: 99%;">
										</label>
									</div>
								</td>

								<td width="10%" class="ticketOnly">
									<div class="griddiv">
										<label>
											<div class="gridlable">Rep.&nbsp;Cost</div>
											<input name="repCost" type="text" class="gridfield" id="repCost" style="width: 99%;">
										</label>
									</div>
								</td>
								<td width="10%">
									<div class="griddiv">
										<label>
											<div class="gridlable">TAX&nbsp;SLAB(%)</div>
											<select id="gstTax" name="gstTax" class="gridfield" displayname="GST" autocomplete="off" >
												<?php 
												$rs2="";
												$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Activity" and status=1'); 
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
								<td width="10%">
									<div class="griddiv">
										<label>
											<div class="gridlable">Markup Type</div>
											<select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
											 	<option value="1">%</option>
											 	<option value="2">Flat</option>
											</select>
										</label>
									</div>
								</td>
								<td width="10%">
									<div class="griddiv">
										<label>
											<div class="gridlable">Markup Cost</div>
											<input name="markupCost" type="text" class="gridfield" id="markupCost" style="width: 99%;">
										</label>
									</div>
								</td>
								
							</tr>
							<tr>

			<td colspan="5" align="left"  ><div class="griddiv"><label>
			<div class="gridlable">Remarks</div>
			<input name="remarks" type="text" class="gridfield"  id="remarks" maxlength="220" />
			</label>
			</div></td>

			<td width="13%" align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');">
			<input name="action" type="hidden" id="action" value="addotherActivityPrice">
			<input name="serviceid" type="hidden" id="serviceid" value="<?php echo $_GET['serviceid']; ?>"></td>
			<input name="otherActivityNameId" type="hidden" id="otherActivityNameId" value="<?php echo $_GET['serviceid']; ?>">
	</td>
    </tr> 
						</table>


</tbody></table>
</form>
</div>
</div> 
<?php 
$select23=''; 
$where23=''; 
$rs23='';  
$select23='*';    
$where23=' otherActivityNameId="'.$_REQUEST['serviceid'].'" group by fromDate,toDate order by fromDate asc';  
$rs23=GetPageRecord($select23,'dmcotherActivityRate',$where23); 
while($PriceresListing=mysqli_fetch_array($rs23)){  
?>
 <div class="" style=" font-size:13px;">   
 
<div class="roompricelistmain topaboxlist" style="width: 98%; float: left;  margin: 10px; border: 1px solid #0F788E;">   
<table width="100%" border="1" cellpadding="12" cellspacing="0" bordercolor="#F2F2F2">
   <tr>
     <td colspan="13" align="left" bgcolor="#0F788E" class=""><strong style="color:#FFFFFF;">Validity - <?php if($PriceresListing['fromDate'] && $PriceresListing['toDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($PriceresListing['fromDate'])); ?> - <?php echo date('d-m-Y',strtotime($PriceresListing['toDate'])); } ?></strong></td>
   </tr>
   <tr>
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>SupplierBookingCode</strong></span></td>  
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Supplier</strong></span></td>  
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Sightseeing</strong></span></td>
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Transfer&nbsp;Type</strong></span></td>
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Adult&nbsp;Cost</strong></span></td>
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Child&nbsp;Cost</strong></span></td>
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Infant&nbsp;Cost</strong></span></td>
	 <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Vehicle&nbsp;Cost</strong></span></td>
	 <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Markup</strong></span></td>
	 <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>TAX </strong></span></td>
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Remarks</strong></span></td>
     <td align="left" bgcolor="#f1f1f1" class=""><span class="header"><strong>Status</strong></span></td>
     <td align="left" bgcolor="#f1f1f1"><strong>Action</strong></td>
    </tr>
	
	<?php 
	$wher1=''; 
	$rs1='';    
	$where1='fromDate="'.$PriceresListing['fromDate'].'" and toDate="'.$PriceresListing['toDate'].'" and otherActivityNameId="'.$PriceresListing['otherActivityNameId'].'" order by fromDate asc,status desc';  
	$rs1=GetPageRecord('*','dmcotherActivityRate',$where1); 
	while($dmcroommastermain=mysqli_fetch_array($rs1)){   
		$rs2="";
		$rs2=GetPageRecord('*',_SUPPLIERS_MASTER_,' id="'.$dmcroommastermain['supplierId'].'"'); 
		$supplierData=mysqli_fetch_array($rs2);
		
		$rs3="";
		$rs3=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,' id="'.$dmcroommastermain['currencyId'].'"'); 
		$currencyId=mysqli_fetch_array($rs3); 
		$cur = $currencyId['name'];

		$rs3=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,' 1 and model!="" and id="'.$dmcroommastermain['vehicleId'].'" order by model asc ');
		$vehicleData=mysqli_fetch_array($rs3);


		$rs34="";
		$rs34=GetPageRecord('*','gstMaster','id="'.$dmcroommastermain['gstTax'].'"');
		$GstTextDetails=mysqli_fetch_array($rs34);
		
		$gstTaxS = $GstTextDetails['gstValue'].'%';
		

		if($dmcroommastermain['markupType']==1){
			$markupCost = $dmcroommastermain['markupCost'].'%';
		}else{
			$markupCost = $dmcroommastermain['markupCost'].'Flat';
		}
		
	?>
   <tr>
	   <td align="left"><?php echo trim($dmcroommastermain['suppBookCode']);?></td> 
    <td align="left"><?php echo addslashes($supplierData['name']);?></td> 
   	<td align="left"><?php 
		$rs4=GetPageRecord('otherActivityName','packageBuilderotherActivityMaster','id='.$dmcroommastermain['otherActivityNameId'].''); 
		$otherActivityData=mysqli_fetch_array($rs4);   
		echo strip($otherActivityData['otherActivityName']);  ?>
	</td>

     <td align="left"><?php if($dmcroommastermain['transferType']==0){echo "All"; }elseif($dmcroommastermain['transferType']==1){ echo "SIC"; }elseif($dmcroommastermain['transferType']==2){ echo "PVT"; }elseif($dmcroommastermain['transferType']==3){ echo "VIP"; }elseif($dmcroommastermain['transferType']==4){ echo "Ticket Only"; } ?></td>

     <td align="left"><?php echo 'Ticket Cost:- '.$cur.' '.strip($dmcroommastermain['ticketAdultCost']).'<br> Transfer Cost:- '.$cur.' '.strip($dmcroommastermain['adultCost']).'<br> Rep Cost:- '.$cur.' '.strip($dmcroommastermain['repCost']); ?></td>

	 <td align="left"><?php echo 'Ticket Cost:- '.$cur.' '.strip($dmcroommastermain['ticketchildCost']).'<br> Transfer Cost:- '.$cur.' '.strip($dmcroommastermain['childCost']).'<br> Rep Cost:- '.$cur.' '.strip($dmcroommastermain['repCost']); ?></td>

	 <td align="left"><?php echo 'Ticket Cost:- '.$cur.' '.strip($dmcroommastermain['ticketinfantCost']).'<br> Transfer Cost:- '.$cur.' '.strip($dmcroommastermain['infantCost']).'<br> Rep Cost:- '.$cur.' '.strip($dmcroommastermain['repCost']); ?></td>
   
     <td align="left"><?php echo 'Cost:- '.$cur.' '.strip($dmcroommastermain['vehicleCost']).'<br> Rep Cost:- '.$cur.' '.strip($dmcroommastermain['repCost']); ?></td>
    
	 <td align="left"><?php echo strip($markupCost); ?></td>
	 <td align="left"><?php echo strip($gstTaxS); ?></td> 
	 <td align="left"><?php echo strip($dmcroommastermain['remarks']); ?></td> 
     <td align="left"><?php if($dmcroommastermain['status']==1){echo 'Active'; } else { echo 'In Active'; }  ?></td>
     <td align="left"><a onClick="alertspopupopen('action=editdmcotherActivityRate&sectionId=<?php echo $dmcroommastermain['id']; ?>&suppid=<?php echo $_GET['id']; ?>','400px','auto');">Edit</a></td>
   </tr>
   <?php } ?>
 </table>
 </div>  

</div><?php } ?>
<div id="calprice"></div>
<script>
//getPerPaxCost();
function getPerPaxCost(){
	var activityCost = $('#activityCost').val();
	var maxpax = $('#maxpax').val();
	var activitySupplierId = $('#activitySupplierId').val();
	var currencyId = $('#currencyId').val(); 
	var ppCost = Math.round(activityCost/maxpax);
	if(maxpax>5){ 
		$('#calprice').load('loadotherActivityCost.php?activityId=<?php echo $_REQUEST['serviceid']; ?>&activityCost='+activityCost+'&maxpax='+maxpax+'&activitySupplierId='+activitySupplierId+'&currencyId='+currencyId);
	}else{
		if(ppCost == 'NaN' || ppCost== Infinity){
			$('#perPaxCost').val(activityCost);
		}else{
			$('#perPaxCost').val(ppCost);
		}
	}
}

<?php if($_REQUEST['fromDate']!=''){ ?>
openclose(1);
<?php } ?>
function loadHotelRoom(){
funloadhotelmaster('<?php echo $_GET['id']; ?>');
}



function selectTransferType(){
	var ActransferType = $("#ActransferType").val();
	if(ActransferType == 1){
		$('.SIC').css('display','table-cell');
		$('.ticketOnly').css('display','table-cell');
		$('.PVT').css('display','none');
	}else if(ActransferType == 2 || ActransferType==3){
		$('.PVT').css('display','table-cell');
		$('.ticketOnly').css('display','table-cell');
		$('.SIC').css('display','none');
	}else{
		$('.PVT').css('display','none');
		$('.SIC').css('display','none');
		$('.ticketOnly').css('display','none');
	}
}

selectTransferType()

</script> 


