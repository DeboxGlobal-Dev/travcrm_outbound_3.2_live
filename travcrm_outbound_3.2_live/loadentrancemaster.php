<?php
include "inc.php";
include "config/logincheck.php";
if($_REQUEST['serviceid']!=''){
	$serviceid=clean($_REQUEST['serviceid']);
	$select1='*';
	$where1='id="'.$serviceid.'"';
	$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_ENTRANCE_MASTER_,$where1);
	$entranceData=mysqli_fetch_array($rs1);
	$entranceName=clean($entranceData['entranceName']);
	$tptType=clean($entranceData['tptType']);


	$rs1=GetPageRecord('*',_DESTINATION_MASTER_,' UPPER(name)="'.strtoupper($entranceData['entranceCity']).'" ');
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
</style>
<div class="topaboxouter">
	<div id="addTriffRoom" style="display:nxone;">
		<div class="addGreenHeader">Add Rate for - <?php echo $entranceName; ?></div>
		<div class="addeditpagebox addtopaboxlist">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm"  id="addhotelroomprice">
				<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width:100%;">
				<tbody>
					<tr style="background-color: transparent !important;">
						<!-- <td width="10%"  align="left"><div class="griddiv">
							<label>
								<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div>
								<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >
									<?php
									$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by id asc');
									while($resListing=mysqli_fetch_array($rs)){
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
								</select></label>
						</div></td> -->
							<td width="100" align="left"><div class="griddiv" >
								<label>
									<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
									<select id="supplierId" name="supplierId" class="gridfield " displayname="Supplier" autocomplete="off" >
									<option value="" >Select Supplier</option>
										<?php
										$rs='';
										$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" and status=1 and ( entranceType=4 or entranceType=1 ) '.$whereDest.' order by name asc');
										
										while($supplierData=mysqli_fetch_array($rs)){
										?>
										<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
										<?php } ?>
									</select></label>
								</div>
							</td>
						<td width="100" align="left"><div class="griddiv">
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
									$('#currencyId').load('loadCurrencyEntrance.php?nationalityType='+nationalityType);
								}
								getCurrencyfun();
							</script>
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
						<td width="100" align="left"><div class="griddiv">
							<label>
								<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
								<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php echo $_REQUEST['fromDate']; ?>"  style="width: 100%;" />
								</label>
							</div>
						</td>
						<td width="100" align="left"><div class="griddiv">
							<label>
								<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
								<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php echo $_REQUEST['toDate']; ?>" style="width: 100%;"/>
								</label>
							</div>
						</td>
						<td width="100" align="left"><div class="griddiv">
							<label>
								<div class="gridlable">Transfer Type<span class="redmind"></span></div>
								<select id="transferType" name="transferType" class="gridfield" displayname="Transfer Type" onchange="selectTransferType();" >
									<?php if($tptType==3 || $tptType==0){ ?>
									<option value="3">Ticket Only</option>
									<?php }if($tptType==1 || $tptType==0){ ?>
									<option value="1" >SIC</option>
									<?php }if($tptType==2 || $tptType==0){ ?>
									<option value="2">PVT</option>
									<?php } ?>
								</select>
							</label>
							</div>
						</td>
						<td width="100" align="left" style="display:none"><div class="griddiv">
							<label>
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="currencyId" name="currencyId" class="gridfield" displayname="Currency" >
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
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['setDefault']==1){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
								</select>
								</label>
							</div>
						</td> 
							
						<td width="100" align="left"><div class="griddiv">
								<label>
									
									<div class="gridlable">Currency<span class="redmind"></span></div>
									<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off"    >
										<option value="">Select</option>
										<?php
										$select='';
										$where='';
										$rs='';
										$select='*';
										$where='deletestatus=0 and status=1 order by name asc';
										$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where);
										while($resListing=mysqli_fetch_array($rs)){
										?>
										<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['setDefault']==1){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
										<?php } ?>
									</select>
								</label>
							</div></td>
						<td width="100" align="left"><div class="griddiv"><label>
							<div class="gridlable">Adult Ticket Cost</div>
								<input name="ticketAdultCost" type="text" class="gridfield"  id="ticketAdultCost" maxlength="6" onkeyup="numericFilter(this);" />
							</label>
							</div>
						</td>
						
						<td width="100" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Child Ticket Cost</div>
									<input name="ticketchildCost" type="text" class="gridfield"  id="ticketchildCost" maxlength="6" onkeyup="numericFilter(this);" />
								</label>
							</div>
						</td>

						<td width="100" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Infant Ticket Cost</div>
									<input name="ticketinfantCost" type="text" class="gridfield"  id="ticketinfantCost" maxlength="6" onkeyup="numericFilter(this);" />
								</label>
							</div>
						</td>

						<td width="100" align="left" valign="middle"  >
							<div class="griddiv">
								<label>
									<div class="gridlable">Status</div>
									<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off" >
										<option value="1">Active</option>
										<option value="0">In Active</option>
									</select>
								</label>
							</div>			
						</td>

					</tr>
					<tr>
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
											$rs2=GetPageRecord('*','vehicleTypeMaster',' 1 and name!="" and status=1 and deletestatus=0 order by name asc ');
											while($vehicleData=mysqli_fetch_array($rs2)){
											?>
											<option value="<?php echo $vehicleData['id'];?>"><?php echo ($vehicleData['name']); ?></option>
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
												$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Entrance" and status=1'); 
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
						</table>
						<table border="0" cellpadding="5" cellspacing="0"> 
							<tr>
								<td width="20%">
									<div class="griddiv">
										<label>
											<div class="gridlable">Policy</div>
											<input name="policy" type="text" class="gridfield" id="policy" style="width: 99%;">
										</label>
									</div>
								</td>
								<td width="20%">
									<div class="griddiv">
										<label>
											<div class="gridlable">T&C</div>
											<input name="termAndCondition" type="text" class="gridfield" id="termAndCondition" style="width: 99%;">
										</label>
									</div>
								</td>
								<td  >
									<div class="griddiv">
										<label>
											<div class="gridlable">Remarks</div>
											<input name="detail" type="text" class="gridfield" id="detail" style="width: 99%;">
										</label>
									</div>
								</td>
								<td width="10%"><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;">
								<input name="action" type="hidden" id="action" value="addEntrancePrice">
								<input name="serviceid" type="hidden" id="serviceid" value="<?php echo $_GET['serviceid']; ?>">
								<input name="entranceNameId" type="hidden" id="entranceNameId" value="<?php echo $_GET['serviceid']; ?>"></td>
							</tr>
						</table>
					</tr>
				</tbody></table>
			</form>
		</div>
	</div>
	<?php
	$rs1=GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,'entranceNameId="'.$_REQUEST['serviceid'].'"  order by fromDate asc');
	if(mysqli_num_rows($rs1)){
	?>
	<div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;   position:relative; background-color:#FFFFFF;">
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
			<thead>
				<tr>
					<th width="16%" align="left" bgcolor="#ddd" >SupplierBookingCode</th>
					<th width="16%" align="left" bgcolor="#ddd" >Validity </th>
					<th width="16%" align="left" bgcolor="#ddd">Type</th>
					<th width="12%" align="left" bgcolor="#ddd">Supplier</th>
					<th width="15%" align="left" bgcolor="#ddd">Adult Cost</th>
					<th width="15%" align="left" bgcolor="#ddd">Child Cost</th>
					<th width="15%" align="left" bgcolor="#ddd">Infant Cost</th>
					<th width="8%" align="left" bgcolor="#ddd">VehicleCost</th>
					<th width="8%" align="left" bgcolor="#ddd">GST SLAB</th>
					<th width="6%" align="left" bgcolor="#ddd">Markup</th>
					<th width="7%" align="left" bgcolor="#ddd">Status</th>
					<th width="12%" align="left" bgcolor="#ddd">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($dmcEntranceRateData=mysqli_fetch_array($rs1)){   ?>
				<tr>
					<td align="left"><?php echo trim($dmcEntranceRateData['suppBookCode']);?></td> 
					<td align="left"><strong><?php echo showdate($dmcEntranceRateData['fromDate']); ?> - <?php echo showdate($dmcEntranceRateData['toDate']); ?></strong></td>
					<td align="left">
						<?php 
						if($dmcEntranceRateData['marketType']>0){ echo "<b>MarketType: </b>".getMarketType($dmcEntranceRateData['marketType']); }else{ echo '_'; } echo "<br>";
						if($dmcEntranceRateData['nationalityType']==2){ echo "<b>NationalityType: </b>Foreign"; }else{ echo "<b>NationalityType: </b>Local"; } echo "<br>";
						if($dmcEntranceRateData['tarifType']==2){ echo "<b>TarifType: </b>Weekend"; }else{ echo "<b>TarifType: </b>Normal"; } echo "<br>";
						if($dmcEntranceRateData['transferType']==2){ echo "<b>TransferType: </b>Private"; }elseif($dmcEntranceRateData['transferType']==1){ echo "<b>TransferType: </b>SIC"; }elseif($dmcEntranceRateData['transferType']==3){  echo "<b>TransferType: </b>Ticket Only"; } ?>
					</td>
					<td align="left"><?php
						$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' id="'.$dmcEntranceRateData['supplierId'].'"');
						$supplierData=mysqli_fetch_array($rs);
						echo addslashes($supplierData['name']);
						?>
					</td>
					<td align="left"><?php
						if($dmcEntranceRateData['ticketAdultCost']>0){ echo "<b>Entrance&nbsp;Ticket: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['ticketAdultCost']); }else{ echo "<b>Entrance&nbsp;Ticket: </b> 0"; } echo "<br>";
						if($dmcEntranceRateData['adultCost']>0){ echo "<b>Transfer&nbsp;Ticket: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['adultCost']); }else{ echo "<b>Transfer&nbsp;Ticket: </b> 0"; } echo "<br>";
						if($dmcEntranceRateData['repCost']>0){ echo "<b>Rep. Cost: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['repCost']); }else{ echo "<b>Rep. Cost: </b> 0"; } echo "<br>";
						?>
					</td>
					<td align="left"><?php
						if($dmcEntranceRateData['ticketchildCost']>0){ echo "<b>Entrance&nbsp;Ticket: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['ticketchildCost']); }else{ echo "<b>Entrance&nbsp;Ticket: </b> 0"; } echo "<br>";
						if($dmcEntranceRateData['childCost']>0){ echo "<b>Transfer&nbsp;Ticket: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['childCost']); }else{ echo "<b>Transfer&nbsp;Ticket: </b> 0"; } echo "<br>";
						if($dmcEntranceRateData['repCost']>0){ echo "<b>Rep. Cost: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['repCost']); }else{ echo "<b>Rep. Cost: </b> 0"; } echo "<br>";
						?>
					</td>
					<td align="left"><?php
						if($dmcEntranceRateData['ticketinfantCost']>0){ echo "<b>Entrance&nbsp;Ticket: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['ticketinfantCost']); }else{ echo "<b>Entrance&nbsp;Ticket:&nbsp;</b>&nbsp;0"; } echo "<br>";
						if($dmcEntranceRateData['infantCost']>0){ echo "<b>Transfer&nbsp;Ticket: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['infantCost']); }else{ echo "<b>Transfer&nbsp;Ticket:&nbsp;</b>&nbsp;0"; } echo "<br>";
						if($dmcEntranceRateData['repCost']>0){ echo "<b>Rep. Cost: </b>".getCurrencyName($dmcEntranceRateData['currencyId']).' '.strip($dmcEntranceRateData['repCost']); }else{ echo "<b>Rep. Cost:&nbsp;</b>&nbsp;0"; } echo "<br>";
						?>
					</td>
					<td align="left"><?php 
						if($dmcEntranceRateData['transferType']==2){
							echo "<b>Cost:"; 
							echo getCurrencyName($dmcEntranceRateData['currencyId']).'&nbsp;'.strip($dmcEntranceRateData['vehicleCost']); 
							echo "</b><br><br>";

							$rs2="";
							$rs2=GetPageRecord('*','vehicleTypeMaster',' 1 and id="'.$dmcEntranceRateData['vehicleId'].'"'); 
							$vehicleData=mysqli_fetch_array($rs2);
							// getVehicleTypeName($vehicleData['carType']) . "( " . 
							echo ucfirst($vehicleData['name']);
						
						}else{ 
							echo "__"; 
						} 
						?>
					</td>
					<td align="center"><?php echo getGstSlabById($dmcEntranceRateData['gstTax']); ?></td>
					<td align="center"><?php echo ($dmcEntranceRateData['markupType']==1)? $dmcEntranceRateData['markupCost'].'%' : 'FLAT'.$dmcEntranceRateData['markupCost']; ?></td>
					<td align="left"><?php if($dmcEntranceRateData['status']==1){echo 'Active'; } else { echo 'Inactive'; }  ?></td>
					<td align="center"><a onClick="alertspopupopen('action=editDmcEntranceRate&sectionId=<?php echo $dmcEntranceRateData['id']; ?>&suppid=<?php echo $_GET['supplierId']; ?>','1000px','auto');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px;"></i></a>&nbsp;&nbsp;&nbsp;<!--<i class="fa fa-trash" aria-hidden="true" style=" margin-left:10px; font-size: 20px; color: #f00; cursor: pointer;" onclick="deleteEntrancecost('<?php echo $dmcEntranceRateData['id']; ?>');"></i>--></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php
	}else{ ?>
	<?php } ?>
</div>
<div id="loadfrmaction" style="display:none;"></div>
<script>
	
	function deleteEntrancecost(id){
		if(confirm('sure you want to delete?')){
		$('#loadfrmaction').load('frmaction.php?action=deleteEntranceCost&id='+id);
		}
	}
</script>
<script>
$(document).ready(function() {
	$('#toDate').Zebra_DatePicker({
		format: 'd-m-Y',
		direction: true // add this line
	});
	
	$('#fromDate').Zebra_DatePicker({
		format: 'd-m-Y',
		direction: true, // add this line
		pair: $('#toDate')
	});
}); 

function openclose(id){
	
}

function selectTransferType(ele){
	var transferType = $("#transferType").val();
	if(transferType == 1){
		$('.SIC').css('display','table-cell');
		$('.ticketOnly').css('display','table-cell');
		$('.PVT').css('display','none');
	}else if(transferType == 2){
		$('.PVT').css('display','table-cell');
		$('.ticketOnly').css('display','table-cell');
		$('.SIC').css('display','none');
	}else{
		$('.PVT').css('display','none');
		$('.SIC').css('display','none');
		$('.ticketOnly').css('display','none');
	}
}
<?php if($tptType==2){ ?>
selectTransferType()
<?php } ?>
<?php if($tptType==3){ ?>
selectTransferType()
<?php } ?>


</script>
<style>
.griddiv{
	margin-bottom: 0px;
}
</style>