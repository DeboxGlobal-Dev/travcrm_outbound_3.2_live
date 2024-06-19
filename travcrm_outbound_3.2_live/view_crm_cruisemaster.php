
<?php 

if($_REQUEST['cruiseMasterKey']!=''){  
	$aaaaaa=GetPageRecord('*',_CRUISE_MASTER_, 'id="'.decode($_REQUEST['cruiseMasterKey']).'"'); 
	$cruiseResult=mysqli_fetch_array($aaaaaa);  

	$cruiseDepartureDate = date('d-m-Y',strtotime($cruiseResult['departureDate']));
	$cruiseToDate = date('d-m-Y',strtotime($cruiseResult['toDate']));

	$supplierId=clean($_REQUEST['supplierId']);
	$select1='*';
	$where1='id="'.$supplierId.'"';
	$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1);
	$editresult=mysqli_fetch_array($rs1);
	$name=clean($editresult['name']);
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
.addTriffFerry .addeditpagebox .griddiv {
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

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
<td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>  
     </td>
        <td width="95%" align="left"><?php echo $cruiseResult['cruiseName']; ?></td>
  </tr>
  
</table>
</div>

<div class="topaboxouter">
<div id="addTriffFerry" style="display:nxone;">
		<div class="addGreenHeader">Add Cruise Package Rate</div>
		<div class="addeditpagebox addtopaboxlist">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addFerryprice" target="actoinfrm"  id="addFerryprice">
				<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width:100%;">
					
				<tbody>
				<tr style="background-color: transparent !important;">
					<!-- <td width="10%"  align="left"><div class="griddiv">
						<label>
							<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div>
							<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off">
								<?php
								$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by id asc');
								while($resListing=mysqli_fetch_array($rs)){
								?>
								<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
								<?php } ?>
							</select>
						</label>
						</div>
					</td> -->
					<td width="100" align="left"><div class="griddiv" >
						<label>
							<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
							<select id="supplierId" name="supplierId" class="gridfield " displayname="Supplier" autocomplete="off" >
								<?php
								$rs='';
								$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and status=1 and cruiseType=15 and name!="" order by name asc');
								while($supplierData=mysqli_fetch_array($rs)){
								?>
								<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
								<?php } ?>
							</select></label>
						</div>
					</td>

                    <td width="100" align="left"><div class="griddiv"><label>
						<div class="gridlable">Cruise Name <span class="redmind"></span></div>
						<select name="cruiseNameId" class="gridfield validate" displayname="Cruise Name" id="cruiseNameId">
							<option value="">Select Cruise Name</option>
							<?php
							$rescr = GetPageRecord('name,id','cruiseNameMaster','deletestatus=0 and status=1');
							while($resultcruise = mysqli_fetch_assoc($rescr)){
							?>
							<option value="<?php echo $resultcruise['id']; ?>"><?php echo $resultcruise['name']; ?></option>
							<?php
							}
							
							?>
						</select>
						</label>
						</div>
					</td>

					<td width="100" align="left"><div class="griddiv" >
						<label>
							<div class="gridlable">Duration&nbsp;<span class="redmind"></span></div>
						
							<input type="text" readonly id="cruiseDuration" name="cruiseDuration" class="gridfield " value="<?php echo $cruiseResult['duration']; ?>" displayname="Cruise Duration" autocomplete="off">
                        </label>
						</div>
					</td>
					
					<td width="100" align="left"><div class="griddiv">
						<label>
							<div class="gridlable">Departure&nbsp;Date<span class="redmind"></span></div>
							<input name="fromDate" readonly type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From" autocomplete="off" value="<?php echo $cruiseDepartureDate; ?>"  style="width: 100%;" />
						</label>
					</div></td>
					<td width="100" align="left"><div class="griddiv">
						<label>
							<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
							<input name="toDate" readonly type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php echo $cruiseToDate;  ?>" style="width: 100%;"/>
						</label>
					</div></td>
					<td width="100" align="left"><div class="griddiv"><label>
						<div class="gridlable">TAX SLAB(TAX%)</div>
						<select name="gstTax" id="gstTax"  class="gridfield" displayname="GST">
							<option value="">Select GST</option>
							<?php
							
							$rs34="";
							$rs34=GetPageRecord('*','gstMaster',' 1 and serviceType="Cruise" and status=1 order by gstSlabName asc');
							while($gstSlabData=mysqli_fetch_array($rs34)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
								}
							?>
							
						</select>
							</label>
						</div>
					</td> 
					
				
					
			
					
			
				</tr>
				<tr> 
			
					<table width="100%">
						<tr>
						<td width="100" align="left"><div class="griddiv"><label>
						<div class="gridlable">Cabin Type<span class="redmind"></span></div>
						<select name="cabinType" class="gridfield validate" displayname="Cabin Type" id="cabinType">
							<option value="">Select Cabin Type</option>
							<?php
							$resseat = GetPageRecord('*','cabinTypeMaster','name!="" and status=1');
							while($resultseat = mysqli_fetch_assoc($resseat)){
							?>
							<option value="<?php echo $resultseat['id']; ?>" > <?php echo $resultseat['name']; ?></option>
							<?php
							}
							
							?>
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
										$where=' deletestatus=0 and status=1 order by name asc';
										$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where);
										while($resListing=mysqli_fetch_array($rs)){
										?>
										<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['setDefault']==1){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
										<?php } ?>
									</select>
								</label>
							</div></td>
							<td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Adult Cost <span class="redmind"></span></div>
								<input name="ticketAdultCost" type="text" class="gridfield validate"  id="ticketAdultCost" displayname="Adult Cost" maxlength="12" onkeyup="numericFilter(this);" />
								</label>
								</div>
							</td>
						
							<td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Child Cost</div>
								<input name="ticketchildCost" type="text" displayname="Child Cost" class="gridfield"  id="ticketchildCost" maxlength="12" onkeyup="numericFilter(this);" />
								</label>
								</div>
							</td>
							<td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Infant Cost </div>
								<input name="ticketinfantCost" type="text" displayname="Infant Cost" class="gridfield"  id="ticketinfantCost" maxlength="12" onkeyup="numericFilter(this);" />
								</label>
								</div>
							</td>
							<!-- <td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Margin(pp)</div>
                                <select name="markupType" type="text" class="gridfield"  id="markupType" maxlength="12" onkeyup="numericFilter(this);">
                                    <option value="1">%</option>
                                    <option value="2">Flat</option>
                                </select>
						
									</label>
								</div>
							</td>
							
							<td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Value</div>
								<input name="markupCost" type="text" class="gridfield"  id="markupCost" />
									</label>
								</div>
							</td> -->
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
							<td width="40%">
								<div class="griddiv">
									<label>
										<div class="gridlable">Remarks</div>
										<input name="remarks" type="text" class="gridfield" id="remarks" style="width: 99%;">
									</label>
								</div>
							</td>
							<td width="10%"><input type="button" name="Submit" value="Save" class="bluembutton"  onclick="formValidation('addFerryprice','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;">
								<input name="action" type="hidden" id="action" value="addCruisePriceFromMaster">
								<input name="serviceId" type="hidden" id="serviceId" value="<?php echo $_GET['cruiseMasterKey']; ?>">
							</td>
						</tr>
					</table>
				</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>


    <div id="loadCruiseRates">Loading...</div>
</div>




<!-- cruise form end -->


<script>  

function funloadCruisemaster(){ 
$('#loadCruiseRates').load('loadCruiseRates.php?serviceId=<?php echo decode($_REQUEST['cruiseMasterKey']); ?>'); 
}

funloadCruisemaster();

$('#addnewuserbtn').show();


</script>

<script>
$(document).ready(function() {
	// $('#toDate').Zebra_DatePicker({
	// 	format: 'd-m-Y',
	// });
	
	// $('#fromDate').Zebra_DatePicker({
	// 	format: 'd-m-Y',
	// 	pair: $('#toDate')
	// });
});
function openclose(id){
	
}
</script>

<style>
.SIC{display:none;}
.PVT{display:none;}
.griddiv{
	margin-bottom: 0px;
}
</style>