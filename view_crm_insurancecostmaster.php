<?php 

if($_REQUEST['insuranceId']!=''){  
	$aaaaaa=GetPageRecord('*','insuranceCostMaster',' id="'.decode($_REQUEST['insuranceId']).'"'); 
	$insuranceCostData=mysqli_fetch_array($aaaaaa);
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
</style>


<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>    
     </td>
    <td width="93%" align="left"><?php echo 'Insurance Cost' ?>:&nbsp;<?php echo $insuranceCostData['name']; ?></td>
  </tr>
  
</table>
</div>



<div class="topaboxouter">
 
<div id="addTriffRoom" style="display:nxone;">
	<div class="addGreenHeader">Add Insurance Cost Cost</div>
	<div class="addeditpagebox addtopaboxlist"> 
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addVisaPrice" target="actoinfrm"  id="addVisaPrice"> 
			<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width:100%;">
		
		  <tbody> 
		  <tr style="background-color: transparent !important;">
		    <td width="100" align="left"><div class="griddiv"> 
	<label> 
	<div class="gridlable">Insurance&nbsp;Name<span class="redmind"></span></div> 
		<input type="text" name="insuranceName" id="insuranceName" class="validate gridfield" value="<?php echo $insuranceCostData['name']; ?>">
	</label>  
	</div></td>

	<td width="100" align="left"><div class="griddiv"> 
	<label> 
	<div class="gridlable">Insurance&nbsp;Type<span class="redmind"></span></div> 
		<select id="insuranceTypeId" name="insuranceTypeId" class="gridfield validate" displayname="Insurance Type" > 
				<?php   
				$rs='';   
				$rs1=GetPageRecord('*',_INSURANCE_TYPE_MASTER_,' deletestatus=0 and name!="" and status=1 order by name asc'); 
				while($insuranceType=mysqli_fetch_array($rs1)){   
				?>
				<option value="<?php echo strip($insuranceType['id']); ?>" <?php if($insuranceType['id']==$insuranceCostData['insuranceType']){ ?> selected="selected" <?php }; ?> ><?php echo strip($insuranceType['name']); ?></option>
				<?php } ?>
				</select>
	</label>  
	</div></td>

		  	<td width="100" align="left"><div class="griddiv" >
				<label> 
				<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
				<select id="supplierId" name="supplierId"  displayname="Supplier Name" class="validate gridfield" autocomplete="off" > 
				<?php   
				$rs='';   
				$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" and status=1 and insuranceType=14  order by name asc'); 
				while($supplierData=mysqli_fetch_array($rs)){   
				?>
				<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
				<?php } ?>
				</select></label>
				</div>			</td> 
			<td width="100" align="left"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off"  style="width: 100%;" />
	</label>
	</div></td>
			<td width="100" align="left"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
	<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" style="width: 100%;"/>
	</label>
	</div></td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>  
					<div class="gridlable">Currency<span class="redmind"></span></div>
					<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off"    >
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
			
			<td width="10%">
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="gstTax" name="gstTax" class="gridfield" displayname="GST" autocomplete="off" >
							<?php 
								$rs2="";
								$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="hotel" and status=1'); 
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
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="adultCost" id="adultCost" class="gridfield validate" displayname="Adult Cost">
					</label>
				</div>
			</td>
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Child&nbsp;Cost</div>
						<input type="text" name="childCost" id="childCost" class="gridfield" displayname="Child Cost">
					</label>
				</div>
			</td> 
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Infant&nbsp;Cost</span></div>
						<input type="text" name="infantCost" id="infantCost" class="gridfield" displayname="Infant Cost">
					</label>
				</div>
			</td> 
		  </tr>
		  <tr>
			
		  <td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">MarkUp&nbsp;Type<span class="redmind"></span></div>
						<select name="visaMarkup" id="visaMarkup" class="gridfield validate" >
							<option value="1">%</option>
							<option value="2">Flat</option>
						</select>
					</label>
				</div>
			</td> 
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Processing&nbsp;Fee</div>
						<input type="text" name="processingFee" id="processingFee" class="gridfield" displayname="Processing Fee">
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

			<td width="100" align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addVisaPrice','saveflight','0');"> 
			  <input name="action" type="hidden" id="action" value="addInsuranceRate">
			  <input name="serviceid" type="hidden" id="serviceid" value="<?php echo $insuranceCostData['id']; ?>"></td>
			</tr> 
		</tbody></table>
		</form>
	</div>
</div> 

<script>

$(document).ready(function() {  
	$('#toDate').Zebra_DatePicker({ 
	  	format: 'd-m-Y',  
	}); 
	
	$('#fromDate').Zebra_DatePicker({ 
	  	format: 'd-m-Y',  
		pair: $('#toDate')
	});  
});


function openclose(id){ 
	 
}
</script>

<div id="loadInsurancerate"></div> 

<script>   
function funloadInsuranceRate(){ 
$('#loadInsurancerate').load('loadinsurancerate.php?serviceid=<?php echo decode($_REQUEST['insuranceId']); ?>'); 
} 

funloadInsuranceRate(); 
$('#addnewuserbtn').show();
</script>