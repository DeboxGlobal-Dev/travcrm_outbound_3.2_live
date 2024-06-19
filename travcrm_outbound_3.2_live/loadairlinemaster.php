<?php
include "inc.php"; 
if($_REQUEST['serviceid']!=''){
	$flightQuery=GetPageRecord('*',_PACKAGE_BUILDER_AIRLINES_MASTER_,' id="'.$_REQUEST['serviceid'].'"'); 
	$flightData=mysqli_fetch_array($flightQuery); 
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
	<div class="addGreenHeader">Add&nbsp;Flight&nbsp;Rates</div>
	<div class="addeditpagebox addtopaboxlist"> 
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addFormDmcAirline" target="actoinfrm"  id="addFormDmcAirline"> 
			<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width:100%;">
	  		<tbody> 
			<tr style="background-color: transparent !important;">
			<td width="40" align="left"><div class="griddiv" >
				<label>
					<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
						<select id="supplierId" name="supplierId" class="gridfield " displayname="Supplier" autocomplete="off" >
							<option value="" >Select Supplier</option>
							<?php
							$rs='';
							$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" and status=1 and airlinesType=7 order by name asc');
										
							while($supplierData=mysqli_fetch_array($rs)){
							?>
							<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
							<?php } ?>
						</select>
					</label></div>
				</td>
				<td  align="left"  width="135">
				<div class="griddiv">
					<label>
						<div class="gridlable">Flight&nbsp;Name<span class="redmind"></span></div>
						<input name="flightName" type="text" readonly class="gridfield" value="<?php echo $flightData['flightName']; ?>"  id="flightName" displayname="Flight Number" />
					</label>
				</div>
			</td>
				<td  align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Flight&nbsp;Number<span class="redmind"></span></div>
						<input name="dmcFlightNumber" type="text" class="gridfield validate"  id="dmcFlightNumber" displayname="Flight Number" />
					</label>
				</div>
			</td>
			<td width="135" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Flight&nbsp;Class<span class="redmind"></span></div>
						<select id="dmcFlightClass" name="dmcFlightClass" class="gridfield validate" displayname="Flight Class" autocomplete="off">
							<option value="Economy_Class" >Economy Class</option>
							<option value="First_Class" >First Class</option>
							<option value="Business_Class" >Business Class</option>
							<option value="Premium_Economy_Class" >Premium Economy Class</option>
							<option value="E" >E</option>
							<option value="F" >F</option>
							<option value="G" >G</option>
							<option value="Y" >Y</option>
							<option value="N" >N</option>
							<option value="E1" >E1</option>
							<option value="H" >H</option>
							<option value="S" >S</option>

						</select>
					</label>
				</div>
			</td>

			<td >
			<div class="griddiv">
					<label>
						<div class="gridlable">From&nbsp;Destination<span class="redmind"></span></div>
						<select id="fromDestination" name="fromDestination" class="gridfield validate" displayname="Flight Class" autocomplete="off">
						<OPTION value="">Select Destination</OPTION>
							<?php 
							$rs1 = GetPageRecord('id,name','destinationMaster','name!="" and status=1');
							while($destData = mysqli_fetch_assoc($rs1)){
								?>
								<option value="<?php echo $destData['id']; ?>" ><?php echo $destData['name']; ?></option>
								<?php
							}
							?>
							
						</select>
					</label>
				</div>
			</td>

			<td width="135">
			<div class="griddiv">
					<label>
						<div class="gridlable">To&nbsp;Destination<span class="redmind"></span></div>
						<select id="toDestination" name="toDestination" class="gridfield validate" displayname="Flight Class" autocomplete="off">
							<OPTION value="">Select Destination</OPTION>
							<?php 
							$rs1 = GetPageRecord('id,name','destinationMaster','name!="" and status=1');
							while($destData = mysqli_fetch_assoc($rs1)){
								?>
								<option value="<?php echo $destData['id']; ?>" ><?php echo $destData['name']; ?></option>
								<?php
							}
							?>
							
						</select>
					</label>
				</div>
			</td>

			<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="dmcGstTax" name="dmcGstTax" class="gridfield" displayname="GST" autocomplete="off" >
												<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Airlines" and status=1'); 
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
			 
			</tr>
  			<tr style="background-color: transparent !important;">
			  <td align="left">
				<div class="griddiv">
					<label>  
					<div class="gridlable">Currency<span class="redmind"></span></div>
					<select id="dmcCurrencyId" name="dmcCurrencyId" class="gridfield validate" displayname="Currency" autocomplete="off"    >
					 <option value="">Select</option>
						<?php 
						$requestedCurr = ($_REQUEST['currencyId']!='') ? $_REQUEST['currencyId']:1; 
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
			<td align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width: 100%;text-align:center;">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input name="dmcAdultCost" type="text" class="gridfield" displayname="Base Fare" id="dmcAdultCost" placeholder="Base Fare" oninput="calculateAdultFair();" maxlength="12" onkeyup="numericFilter(this);" style="display: inline-block; width:85px;" />
						<input name="airlaineTaxA" type="text" class="gridfield" displayname="Airline Tax" id="airlaineTaxA" placeholder="Airline Tax" oninput="calculateAdultFair();" maxlength="12" onkeyup="numericFilter(this);" style="display: inline-block; width:85px;" />
					</label>
				</div>
			</td>
			<td width="60" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Total&nbsp;Cost</div>
						<input name="totalCostA" type="text" class="gridfield validate"  id="totalCostA" maxlength="12" onkeyup="numericFilter(this);" displayname="Adult Total Cost" />
					</label>
				</div>
			</td>
			<script>

			function calculateAdultFair(){
					var adultCost = Number($("#dmcAdultCost").val());
					var adultTax = Number($("#airlaineTaxA").val());
					var totalCost = adultCost+adultTax;
					$("#totalCostA").val(totalCost);
			}

			</script>
			<td align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width: 100%;text-align:center;">Child&nbsp;Cost</div>
						<input name="dmcChildCost" oninput="calculateChildFair();" placeholder="Base Fare" type="text" class="gridfield"  id="dmcChildCost" maxlength="12" onkeyup="numericFilter(this);" style="display: inline-block; width:85px;" />
						<input name="airlaineTaxC" type="text" oninput="calculateChildFair();" class="gridfield"  id="airlaineTaxC" maxlength="12" onkeyup="numericFilter(this);" placeholder="Airline Tax" style="display: inline-block; width:85px;" />
					</label>
				</div>
			</td>
			<td width="60" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Total&nbsp;Cost</div>
						<input name="totalCostC" type="text" class="gridfield"  id="totalCostC" maxlength="12" onkeyup="numericFilter(this);" />
						
					</label>
				</div>
			</td>

			<script>

				function calculateChildFair(){
						var childCost = Number($("#dmcChildCost").val());
						var childTax = Number($("#airlaineTaxC").val());
						var totalCost = childCost+childTax;
						$("#totalCostC").val(totalCost);
				}

			</script>

			<td align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width: 100%;text-align:center;">Infant&nbsp;Cost</div>
						<input name="dmcInfantCost" type="text" oninput="calculateInfantFair();" class="gridfield"  id="dmcInfantCost" maxlength="12" onkeyup="numericFilter(this);" placeholder="Base Fare" style="display: inline-block; width:85px;"/>

						<input name="airlaineTaxE" type="text" oninput="calculateInfantFair();" class="gridfield"  id="airlaineTaxE" maxlength="12" onkeyup="numericFilter(this);" placeholder="Airline Tax" style="display: inline-block; width:85px;" />
					</label>
				</div>
			</td>
			<td width="60" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Total&nbsp;Cost</div>
						<input name="totalCostE" type="text" class="gridfield"  id="totalCostE" maxlength="12" onkeyup="numericFilter(this);" />
						
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

			<script>

				function calculateInfantFair(){
						var infantCost = Number($("#dmcInfantCost").val());
						var infantTax = Number($("#airlaineTaxE").val());
						var totalCost = infantCost+infantTax;
						$("#totalCostE").val(totalCost);
				}

			</script>
		</tr>
			<tr>
				
			<td align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">BaggageAllowance(KG)</div>
						<input name="dmcBaggageAllowance" type="text" class="gridfield"  id="dmcBaggageAllowance" maxlength="12"   />
					</label>
				</div>
			</td> 

			<td colspan="3" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Cancellation&nbsp;Policy</div>
						<input name="cancellation" type="text" class="gridfield"  id="cancellation"/>
					</label>
				</div>
			</td> 

			<td colspan="3"  align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Remarks</div>
						<input name="dmcRemarks" type="text" class="gridfield"  id="dmcRemarks" maxlength="12"  />
					</label>
				</div>
			</td> 
			
		 
			<td width="100" align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addFormDmcAirline','saveflight','0');"> 
			  <input name="action" type="hidden" id="action" value="addDmcAirlineRate">
			  <input name="dmcServiceId" type="hidden" id="dmcServiceId" value="<?php echo $flightData['id']; ?>"></td>
			</tr> 
		</tbody></table>
		</form>
	</div>
</div> 

<?php  
$rs222=GetPageRecord('*','dmcAirlineMasterRate','serviceid="'.$flightData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($rs222) > 0){  
?>
	<div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;   position:relative; background-color:#FFFFFF;">   	
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable"> 
			<thead> 
				<tr><th colspan="14" align="left" style="font-size: 17px;" ><?php echo $flightData['flightName']; ?></th></tr>
			<tr>
				<th width="15%" align="left" bgcolor="#ddd">Supplier&nbsp;Name</th>
				<th width="15%" align="left" bgcolor="#ddd">Flight&nbsp;Number</th>
				<th width="15%" align="left" bgcolor="#ddd">Flight&nbsp;Class</th>
				<th width="12%" align="left" bgcolor="#ddd">From</th>
				<th width="12%" align="left" bgcolor="#ddd">To</th>
				<th width="13%" align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
				<th width="13%" align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
				<th width="13%" align="left" bgcolor="#ddd">Infant&nbsp;Cost</th> 
				<th width="13%" align="left" bgcolor="#ddd">Tax&nbsp;Slab</th> 
				<th width="13%" align="left" bgcolor="#ddd">Markup</th> 
				<th width="10%" align="left" bgcolor="#ddd">Baggage&nbsp;Allowance</th>
				<th width="13%" align="left" bgcolor="#ddd">Cancellation&nbsp;Policy</th>  
				<th width="20%" align="left" bgcolor="#ddd" >Remarks</th>
				<th width="6%" align="left" bgcolor="#ddd" >Status</th>
				
				<th width="5%" align="left" bgcolor="#ddd">&nbsp;</th>
			</tr>
			</thead> 
			<tbody> 
			<?php while($dmcAirlineRateData=mysqli_fetch_array($rs222)){  ?>
			<tr>
				<td align="left">
					<?php  
					echo getSupplierName($dmcAirlineRateData['supplierId']);  
					?>				
				</td> 
				<td align="left">
					<?php  
					echo ($dmcAirlineRateData['flightNumber']);  
					?>				
				</td> 
				<td align="left">
					<?php  
					echo ($dmcAirlineRateData['flightClass']);  
					?>				
				</td> 
				<td align="left">
					<?php  
					echo getDestination($dmcAirlineRateData['fromDestination']);  
					?>				
				</td> 
				<td align="left">
					<?php  
					echo getDestination($dmcAirlineRateData['toDestination']);  
					?>				
				</td>
				<td align="left">
				<?php  
					$cur=getCurrencyName($dmcAirlineRateData['currencyId']);  
					echo "<b>Base&nbsp;Fare</b> ".$cur.' '.strip($dmcAirlineRateData['adultCost']); 
					echo "<b><br>Airline&nbsp;Tax</b> ".$cur.' '.strip($dmcAirlineRateData['adultTax']); 
					echo "<b><br>Total&nbsp;Cost</b> ".$cur.' '.strip($dmcAirlineRateData['totalAdultCost']); 
					?>			
				</td> 
				<td align="left">
				<?php  
					echo "<b>Base&nbsp;Fare</b> ".$cur.' '.strip($dmcAirlineRateData['childCost']); 
					echo "<b><br>Airline&nbsp;Tax</b> ".$cur.' '.strip($dmcAirlineRateData['childTax']); 
					echo "<b><br>Total&nbsp;Cost</b> ".$cur.' '.strip($dmcAirlineRateData['totalChildCost']); 
					?>				
				</td> 
				<td align="left">
				<?php  
					echo "<b>Base&nbsp;Fare</b> ".$cur.' '.strip($dmcAirlineRateData['infantCost']); 
					echo "<b><br>Airline&nbsp;Tax</b> ".$cur.' '.strip($dmcAirlineRateData['infantTax']); 
					echo "<b><br>Total&nbsp;Cost</b> ".$cur.' '.strip($dmcAirlineRateData['totalInfantCost']); 
					?>				
				</td>
				<td align="center"><?php echo getGstSlabById($dmcAirlineRateData['gstTax']); ?></td>  
				<td align="center"><?php echo $dmcAirlineRateData['markupCost']; echo ($dmcAirlineRateData['markupType']==1)?'%':'Flat'; ?></td>  
				<td align="left">
					<?php  
					echo strip($dmcAirlineRateData['baggageAllowance']); 
					?>				
				</td> 
				<td align="left">
					<?php  
					echo strip($dmcAirlineRateData['cancellationPolicy']); 
					?>				
				</td> 
				<td align="left"><?php if($dmcAirlineRateData['remarks']!=''){ echo $dmcAirlineRateData['remarks']; } ?></td>
				<td align="left"><?php if($dmcAirlineRateData['status']==1){echo 'Active'; } else { echo 'Inactive'; }  ?></td>
				
				<td align="center"><a onClick="alertspopupopen('action=editDmcAirlineRate&tariffId=<?php echo $dmcAirlineRateData['id']; ?>','800px','auto');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px;"></i></a></td>
			</tr>  
			 <?php } ?>
		</tbody>
	  </table> 
  </div>
<?php  
}else{  
  echo "No Tariff found";
} ?>
</div> 
<div id="loadfrmaction" style="display:none;"></div> 
<script> 
// $(document).ready(function() {  
// 	$('#toDate').Zebra_DatePicker({ 
// 	  	format: 'd-m-Y',  
// 	}); 
	
// 	$('#fromDate').Zebra_DatePicker({ 
// 	  	format: 'd-m-Y',  
// 		pair: $('#toDate')
// 	});  
// }); 
</script> 