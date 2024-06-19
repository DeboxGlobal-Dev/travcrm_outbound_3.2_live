<?php
include "inc.php"; 
if($_REQUEST['serviceid']!=''){
	$trainQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$_REQUEST['serviceid'].'"'); 
	$trainData=mysqli_fetch_array($trainQuery); 
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
	<div class="addGreenHeader">Add&nbsp;Train&nbsp;Rates</div>
	<div class="addeditpagebox addtopaboxlist"> 
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addFormDmcTrain" target="actoinfrm"  id="addFormDmcTrain"> 
			<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width:100%;">
	  		<tbody> 
  			<tr style="background-color: transparent !important;">
    		<td width="100" align="left" style="display:none;" >
    			<div class="griddiv"> 
				<!-- <label>  -->
				<!-- <div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div>  -->
				<!-- <select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >   -->
				<?php   
				// $rs=GetPageRecord('*','marketMaster',' deletestatus=0 order by name desc');  
				// while($resListing=mysqli_fetch_array($rs)){   
				?> 
				<!-- <option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>  -->
				<?php //} ?>
				<!-- </select></label>   -->
				</div>
			</td>
		  	<td width="100" align="left" style="display:none;">
		  		<div class="griddiv" >
				<!-- <label>  -->
				<!-- <div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div> -->
				<!-- <select id="supplierId" name="supplierId"  displayname="Supplier Name" class="validate gridfield" autocomplete="off" >  -->
				<?php   
				// $rs='';   
				// $rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" and status=1 and guideType=2  order by name asc'); 
				// while($supplierData=mysqli_fetch_array($rs)){   
				?>
				<!-- <option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option> -->
				<?php //} ?>
				<!-- </select></label> -->
				</div>			
			</td> 
			<td width="100" align="left" style="display:none;">
				<div class="griddiv">
				<!-- <label> -->
				<!-- <div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div> -->
				<!-- <input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off"  style="width: 100%;" /> -->
				<!-- </label> -->
				</div>
			</td>
			<td width="100" align="left" style="display:none;">
				<div class="griddiv">
				<!-- <label> -->
				<!-- <div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div> -->
				<!-- <input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" style="width: 100%;"/> -->
				<!-- </label> -->
				</div>
			</td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Train&nbsp;Number<span class="redmind"></span></div>
						<input name="dmcTrainNumber" type="text" class="gridfield validate"  id="dmcTrainNumber" displayname="Train Number" />
					</label>
				</div>
			</td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Journey&nbsp;Type<span class="redmind"></span></div>
						<select id="dmcJourneyType" name="dmcJourneyType" class="gridfield validate" displayname="Journey Type" >  
							<option value="day_journey">day_journey</option>
							<option value="overnight_journey">overnight_journey</option>
						</select>
					</label>
				</div>
			</td>

			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">Train&nbsp;Classes</div>
						<select id="dmcTrainClass" name="dmcTrainClass" class="gridfield validate" displayname="Train Class" autocomplete="off">
							<option value="AC First Class" >AC First Class</option>
							<option value="AC 2-Tier"  >AC 2-Tier</option>
							<option value="AC 3-Tier"  >AC 3-Tier	</option>
							<option value="First Class"  >First Class	</option>
							<option value="AC Chair Car"  >AC Chair Car</option>
							<option value="Second Sitting" >Second Sitting</option>
							<option value="Sleeper" >Sleeper</option>
						</select>
					</label> 
				</div>
			</td>
			
			<td width="100" align="left">
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
			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input name="dmcAdultCost" type="text" class="gridfield validate" displayname="Adult Cost" id="dmcAdultCost" maxlength="12" onkeyup="numericFilter(this);" />
					</label>
				</div>
			</td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Child&nbsp;Cost</div>
						<input name="dmcChildCost" type="text" class="gridfield"  id="dmcChildCost" maxlength="12" onkeyup="numericFilter(this);" />
					</label>
				</div>
			</td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Infant&nbsp;Cost</div>
						<input name="dmcInfantCost" type="text" class="gridfield"  id="dmcInfantCost" maxlength="12" onkeyup="numericFilter(this);" />
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
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Train" and status=1'); 
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
			 
			<td width="100" align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addFormDmcTrain','savetrain','0');"> 
			  <input name="action" type="hidden" id="action" value="addDmcTrainRate">
			  <input name="dmcServiceId" type="hidden" id="dmcServiceId" value="<?php echo $trainData['id']; ?>"></td>
			</tr> 
		</tbody></table>
		</form>
	</div>
</div> 

<?php  
$rs222=GetPageRecord('*','dmcTrainMasterRate','serviceid="'.$trainData['id'].'" order by fromDate asc'); 
if(mysqli_num_rows($rs222) > 0){  
?>
	<div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;   position:relative; background-color:#FFFFFF;">   	
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable"> 
			<thead> 
			<tr>
				<th width="15%" align="left" bgcolor="#ddd">Train&nbsp;Number</th>
				<th width="12%" align="left" bgcolor="#ddd">Train&nbsp;Class</th>
				<th width="12%" align="left" bgcolor="#ddd">Journey&nbsp;Type</th>
				<th width="12%" align="left" bgcolor="#ddd">Currency</th>
				<th width="10%" align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
				<th width="10%" align="left" bgcolor="#ddd">Child&nbsp;Cost</th>
				<th width="10%" align="left" bgcolor="#ddd">Infant&nbsp;Cost</th> 
				<th width="10%" align="left" bgcolor="#ddd">Tax&nbsp;Slab</th> 
				<th width="10%" align="left" bgcolor="#ddd">Markup</th> 
				<th width="10%" align="left" bgcolor="#ddd">Remarks</th> 
				<th width="10%" align="left" bgcolor="#ddd" >Status</th>
				<!-- <th width="20%" align="left" bgcolor="#ddd" >Remarks</th> -->
				<th width="5%" align="left" bgcolor="#ddd">&nbsp;</th>
			</tr>
			</thead> 
			<tbody> 
			<?php while($dmcTrainRateData=mysqli_fetch_array($rs222)){  ?>
			<tr>
				<td align="left">
					<?php  
					echo ($dmcTrainRateData['trainNumber']);  
					?>				
				</td> 
				<td align="left">
					<?php  
					echo ($dmcTrainRateData['trainClass']);  
					?>				
				</td> 	
				<td align="left">
					<?php  
					echo ($dmcTrainRateData['journeyType']);  
					?>				
				</td> 	
				<td align="left">
					<?php  
					$cur=getCurrencyName($dmcTrainRateData['currencyId']);  
					echo $cur;  
					?>				
				</td> 
				<td align="left">
					<?php  
					
					echo strip($dmcTrainRateData['adultCost']); 
					?>				
				</td> 
				<td align="left">
					<?php  
					echo strip($dmcTrainRateData['childCost']); 
					?>				
				</td> 
				<td align="left">
					<?php  
					echo strip($dmcTrainRateData['infantCost']); 
					?>				
				</td>
				<td align="left"><?php echo getGstSlabById($dmcTrainRateData['gstTax']); ?></td>  
				<td align="left"><?php echo $dmcTrainRateData['markupCost']; echo ($dmcTrainRateData['markupType']==1)?'%':'Flat'; ?></td>  
				<td align="left">
					<?php  
					echo strip($dmcTrainRateData['remarks']); 
					?>				
				</td> 
				<td align="left"><?php if($dmcTrainRateData['status']==1){echo 'Active'; } else { echo 'Inactive'; }  ?></td>
				<!-- <td align="left"><?php if($dmcTrainRateData['remarks']!=''){ echo $dmcTrainRateData['remarks']; } ?></td> -->
				<td align="center"><a onClick="alertspopupopen('action=editDmcTrainRate&tariffId=<?php echo $dmcTrainRateData['id']; ?>','400px','auto');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px;"></i></a></td>
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