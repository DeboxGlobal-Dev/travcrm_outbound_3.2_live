<?php
include "inc.php"; 
if($_REQUEST['serviceid']!=''){
	$aaaaaa=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$_REQUEST['serviceid'].'"'); 
	$subCatData=mysqli_fetch_array($aaaaaa); 
	
	$whereDest='';
	if($subCatData['destinationId']>0){
		$whereDest=' and FIND_IN_SET("'.$subCatData['destinationId'].'", destinationId) ';
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
	<div class="addGreenHeader">Add&nbsp;Guide/Porter&nbsp;Price</div>
	<div class="addeditpagebox addtopaboxlist"> 
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm"  id="addhotelroomprice"> 
			<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width:100%;">
		
		  <tbody> 
		  <tr style="background-color: transparent !important;">
		    <!-- <td width="100" align="left"><div class="griddiv"> 
	<label> 
	<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div> 
	<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
 <?php   
$rs=GetPageRecord('*','marketMaster',' deletestatus=0 order by name desc');  
while($resListing=mysqli_fetch_array($rs)){   
?> 
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
<?php } ?>
</select></label>  
	</div></td> -->
		  	<td width="100" align="left"><div class="griddiv" >
				<label> 
				<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
				<select id="supplierId" name="supplierId"  displayname="Supplier Name" class="validate gridfield" autocomplete="off" > 
				<?php   
				$rs='';   
				$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" and status=1 and guideType=2  '.$whereDest.' order by name asc'); 
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
			<?php if($subCatData['serviceType'] == "0"){ ?>
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Pax&nbsp;Range<span class="redmind"></span></div>
						<select id="paxRange" name="paxRange" class="gridfield " autocomplete="off" >
							<option value="0">All</option> 
							<option value="1_5" >1-5 Pax</option> 
							<option value="6_14" >6-14 Pax</option> 
							<option value="15_40" >15-40 Pax</option> 
						</select> 
					</label>
				</div>			</td>
			<?php } ?>
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Day&nbsp;Type<span class="redmind"></span></div>
						<select id="dayType" name="dayType" class="gridfield " displayname="Day Type" autocomplete="off" >  
							<option value="halfday" >Half Day</option>  
							<option value="fullday" >Full Day</option> 
						</select>
					</label>
				</div>			</td> 
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Universal&nbsp;Cost<span class="redmind"></span></div>
						<select id="universalCost" name="universalCost" class="gridfield " autocomplete="off" onchange="showGuide(this.value);"  >
							<option value="0">Yes</option>
							<option value="1">No</option> 						
						</select> 
					</label>
				</div>			</td>
			<td width="100" align="left" id="guidePorterDiv" style="display:none;">
				<div class="griddiv">
					<label>
						<div class="gridlable">Select&nbsp;Guide/Porter<span class="redmind"></span></div>
						<select id="guidePorterId" name="guidePorterId" class="gridfield " autocomplete="off"   >
							<option value="">None</option>
							<?php
							$rs2=GetPageRecord('*',_GUIDE_MASTER_,' 1 and serviceType = "'.trim($subCatData['serviceType']).'" order by name asc'); 
							while($guideData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $guideData['id']; ?>"><?php echo $guideData['name'];?></option> 
							<?php } ?>
						</select> 
					</label>
				</div>			</td>  
			<td width="100" align="left"><div class="griddiv"><label>
			<div class="gridlable">Cost</div>
			<input name="price" type="text" class="gridfield"  id="price" maxlength="12" onkeyup="numericFilter(this);" />
			</label>
			</div></td> 
			
			<td width="100" align="left" valign="middle"  >
				<div class="griddiv">
					<label>  
						<div class="gridlable">Status</div>
						<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off" >  
							<option value="1">Active</option>
							<option value="0">In Active</option>
						</select>
					</label>
				</div>			</td>
			<td width="100" align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');"> 
			  <input name="action" type="hidden" id="action" value="addGuidePorterPrice">
			  <input name="serviceType" type="hidden" id="serviceType" value="<?php echo $subCatData['serviceType']; ?>">
			  <input name="serviceid" type="hidden" id="serviceid" value="<?php echo $subCatData['id']; ?>"></td>
			</tr> 
		</tbody></table>
		</form>
	</div>
</div> 




	 <?php  
	$rs222=GetPageRecord('*','dmcGuidePorterRate','serviceid="'.$subCatData['id'].'" order by fromDate asc'); 
	if(mysqli_num_rows($rs222) > 0){  
	?>
	
<div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;   position:relative; background-color:#FFFFFF;">   	
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable"> 
			<thead> 
			<tr>
			
			  <th width="16%" align="left" bgcolor="#ddd" >Validity </th>
				<!-- <th width="12%" align="left" bgcolor="#ddd">Market Type</th> -->
				<th width="12%" align="left" bgcolor="#ddd">Supplier</th>
				<th width="9%" align="left" bgcolor="#ddd">Day Type </th>
				<?php  if($dmcGuidSubCatRateData['universalCost'] == 1 ){ ?>
				<th width="9%" align="left" bgcolor="#ddd">Guide/Porter</th>
				<?php } 
				if($subCatData['serviceType'] == "0"){ ?> 
				<th width="9%" align="left" bgcolor="#ddd">Pax&nbsp;Range </th> 
				<?php } ?>
				<th width="9%" align="left" bgcolor="#ddd">Cost</th> 
				<th width="9%" align="left" bgcolor="#ddd" >Status</th>
				<th width="12%" align="left" bgcolor="#ddd">&nbsp;</th>
			</tr>
			</thead> 
			<tbody> 
			<?php while($dmcGuidSubCatRateData=mysqli_fetch_array($rs222)){  ?>
			<tr>
			

			  <td align="left"><strong><?php echo date('d-m-Y',strtotime($dmcGuidSubCatRateData['fromDate'])); ?> - <?php echo date('d-m-Y',strtotime($dmcGuidSubCatRateData['toDate'])); ?></strong></td> 
			  
			  <td align="left"><?php echo getSupplierName($dmcGuidSubCatRateData['supplierId']); ?></td>
				
				<td align="left"><?php if($dmcGuidSubCatRateData['dayType'] == 'halfday'){ echo 'Half Day'; }else{ echo 'Full Day';};?></td>
				<?php  if($dmcGuidSubCatRateData['universalCost'] == 1 ){ ?>
				<td align="left"><?php 
					$rs23=GetPageRecord('*',_GUIDE_MASTER_,' 1 and id = "'.trim($dmcGuidSubCatRateData['guidePorterId']).'"'); 
					$guideData=mysqli_fetch_array($rs23);
					echo $guideData['name'];
				?></td>
				<?php } 
				if($subCatData['serviceType'] == "0"){ ?>
				<td align="left">
					<?php if($dmcGuidSubCatRateData['paxRange'] == 0){ echo "All"; }else{ echo str_replace('_',' to ',$dmcGuidSubCatRateData['paxRange']); } ?>				</td> 
				<?php } ?>
				<td align="left">
					<?php  
					$rs2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id="'.$dmcGuidSubCatRateData['currencyId'].'"'); 
					$editresult2=mysqli_fetch_array($rs2); 
					$cur=clean($editresult2['name']);  
					echo $cur.' '.strip($dmcGuidSubCatRateData['price']); 
					?>				</td> 
				  
				<td align="left"><?php if($dmcGuidSubCatRateData['status']==1){echo 'Active'; } else { echo 'Inactive'; }  ?></td>
				
				<td align="center"><a onClick="alertspopupopen('action=editGuidePorterPrice&tariffId=<?php echo $dmcGuidSubCatRateData['id']; ?>&suppid=<?php echo $dmcGuidSubCatRateData['supplierId']; ?>','400px','auto');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px;"></i></a></td>
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
	 
	function deleteEntrancecost(id){
		if(confirm('sure you want to delete?')){
	//	$('#loadfrmaction').load('frmaction.php?action=deleteEntranceCost&id='+id);
		}
	}

</script> 
<script>
function showGuide(id){
	if(id == 1){
		$('#guidePorterDiv').show();
	}else{
		$('#guidePorterId').val('');
		$('#guidePorterDiv').hide();
	}
}
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
<style>
.SIC{display:none;}
.PVT{display:none;}
.griddiv{
	    margin-bottom: 0px;
}
</style>