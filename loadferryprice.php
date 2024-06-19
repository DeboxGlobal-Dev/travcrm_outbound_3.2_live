<?php
include "inc.php";
include "config/logincheck.php";
if($_REQUEST['id']!=''){
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
<div class="topaboxouter">
	
	<div id="addTriffFerry" style="display:nxone;">
		<div class="addGreenHeader">Add Ferry Transfer Rate</div>
		<div class="addeditpagebox addtopaboxlist">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addFerryprice" target="actoinfrm"  id="addFerryprice">
				<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width:100%;">
					
				<tbody>
				<tr style="background-color: transparent !important;">
					<td width="10%"  align="left"><div class="griddiv">
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
					</td>
					<td width="100" align="left"><div class="griddiv" >
						<label>
							<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
							<select id="supplierId" name="supplierId" class="gridfield " displayname="Supplier" autocomplete="off" >
								<?php
								$rs='';
								$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and status=1 and( ferryType=10 or ferryType=1 ) and name!="" order by name asc');
								while($supplierData=mysqli_fetch_array($rs)){
								?>
								<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
								<?php } ?>
							</select></label>
						</div>
					</td>
					
					<td width="100" align="left"><div class="griddiv">
						<label>
							<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
							<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php echo $_REQUEST['fromDate']; ?>"  style="width: 100%;" />
						</label>
					</div></td>
					<td width="100" align="left"><div class="griddiv">
						<label>
							<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
							<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php echo $_REQUEST['toDate']; ?>" style="width: 100%;"/>
						</label>
					</div></td>
					
					<td width="100" align="left"><div class="griddiv"><label>
						<div class="gridlable">Ferry Name <span class="redmind"></span></div>
						<select name="ferryNameId" class="gridfield validate" displayname="Ferry Name" id="ferryNameid">
							<option value="">Select Ferry Name</option>
							<?php
							$resferry = GetPageRecord('name,id','ferryNameMaster','deletestatus=0 and status=1');
							while($resultferry = mysqli_fetch_assoc($resferry)){
							?>
							<option value="<?php echo $resultferry['id']; ?>"><?php echo $resultferry['name']; ?></option>
							<?php
							}
							
							?>
						</select>
						</label>
						</div>
					</td>
					<td width="100" align="left"><div class="griddiv"><label>
						<div class="gridlable">Ferry Seat <span class="redmind"></span></div>
						<select name="ferrySeat" class="gridfield validate" displayname="Ferry Seat" id="ferrySeat">
							<option value="">Select Ferry Seat</option>
							<?php
							$resseat = GetPageRecord('*','ferryClassMaster','deletestatus=0 and status=1');
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
								<div class="gridlable">Adult Cost <span class="redmind"></span></div>
								<input name="ticketAdultCost" type="text" class="gridfield validate"  id="ticketAdultCost" displayname="Adult Cost" maxlength="12" onkeyup="numericFilter(this);" />
								</label>
								</div>
							</td>
						
							<td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Child Cost <span class=""></span></div>
								<input name="ticketchildCost" type="text" displayname="Child Cost" class="gridfield"  id="ticketchildCost" maxlength="12" onkeyup="numericFilter(this);" />
								</label>
								</div>
							</td>
							<td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Infant Cost <span class=""></span></div>
								<input name="ticketinfantCost" type="text" displayname="Infant Cost" class="gridfield"  id="ticketinfantCost" maxlength="12" onkeyup="numericFilter(this);" />
								</label>
								</div>
							</td>
							<!-- <td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Processing Fee(pp)</div>
								<input name="processingfee" type="text" class="gridfield"  id="processingfee" maxlength="12" onkeyup="numericFilter(this);" />
									</label>
								</div>
							</td> -->
							
							<td width="100" align="left"><div class="griddiv"><label>
								<div class="gridlable">Misc. Cost(pp)</div>
								<input name="misslaniouscost" type="text" class="gridfield"  id="misslaniouscost" maxlength="12" onkeyup="numericFilter(this);" />
									</label>
								</div>
							</td>
							<td width="100" align="left"><div class="griddiv"><label>
						<div class="gridlable">TAX SLAB(TAX%) <span class="redmind"></span></div>
						<select name="gstTax" id="gstTax"  class="gridfield validate" displayname="GST">
							<option value="">Select GST</option>
							<?php
							
							$rs34="";
							$rs34=GetPageRecord('*','gstMaster',' 1 and serviceType="Ferry" and status=1 order by gstSlabName asc');
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
							<td width="100">
								<div class="griddiv">
									<label>
										<div class="gridlable">Remarks</div>
										<input name="remarks" type="text" class="gridfield" id="remarks" style="width: 99%;">
									</label>
								</div>
							</td>
							<td width="10%"><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addFerryprice','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;">
								<input name="action" type="hidden" id="action" value="addFerryPrice">
								<input name="serviceid" type="hidden" id="serviceid" value="<?php echo $_GET['serviceid']; ?>">
							</td>
						</tr>
					</table>
				</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
<?php
$rsel1=GetPageRecord('*','ferryRate','serviceid="'.$_REQUEST['serviceid'].'"  order by id desc');
if(mysqli_num_rows($rsel1)>0){
?>
<div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;   position:relative; background-color:#FFFFFF;">
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
<thead>
<tr>
<th width="14%" align="left" bgcolor="#ddd" >Validity </th>
<th width="" align="left" bgcolor="#ddd" >Ferry&nbsp;Name</th>
<th width="" align="left" bgcolor="#ddd" >Ferry&nbsp;Seat</th>
<th width="" align="left" bgcolor="#ddd">Supplier</th>
<th width="10%" align="left" bgcolor="#ddd">Market&nbsp;Type</th>
<!-- <th width="10%" align="left" bgcolor="#ddd">Nationality</th> -->
<th width="" align="left" bgcolor="#ddd" >GST</th>
<th width="" align="left" bgcolor="#ddd">Adult&nbsp;Cost</th>
<th width="" align="left" bgcolor="#ddd" >Child&nbsp;Cost</th>
<th width="" align="left" bgcolor="#ddd" >Infant&nbsp;Cost</th>
<th width="" align="left" bgcolor="#ddd" >Misc.&nbsp;Cost(pp)</th>
<th width="" align="left" bgcolor="#ddd" >Markup</th>
<th width="" align="left" bgcolor="#ddd" >Remarks&nbsp;</th>
<th style="min-width:50px;" align="left" bgcolor="#ddd" >&nbsp;</th>
</tr>
</thead>
<tbody>
<?php 
while($dmcferryRate = mysqli_fetch_assoc($rsel1)){  ?>
<tr>
<td align="left"><strong><?php echo showdate($dmcferryRate['fromDate']); ?> - <?php echo showdate($dmcferryRate['toDate']); ?></strong></td>
<td align="left">
	<?php
	$FerryName=GetPageRecord('*','ferryNameMaster', 'id="'.$dmcferryRate['ferryNameId'].'"');
	$FerryNamessss=mysqli_fetch_array($FerryName);
	echo $FerryNamessss['name'];
	?>
</td>
<td align="left">
	<?php
	$FerryClassN=GetPageRecord('*','ferryClassMaster', 'id="'.$dmcferryRate['ferryClass'].'"');
	$ferryClassName=mysqli_fetch_array($FerryClassN);
	echo $ferryClassName['name'];
	?>
</td>
<td align="left"><?php
	$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' id="'.$dmcferryRate['supplierId'].'"');
	$supplierData=mysqli_fetch_array($rs);
	echo addslashes($supplierData['name']);
?></td>
<td align="left"><?php if($dmcferryRate['marketType']>0){ echo getMarketType($dmcferryRate['marketType']); }else{ echo '_'; } ?></td>

<td align="left"><?php echo getGstValueById($dmcferryRate['gstTax']).'%'; ?></td>
<td align="left"><?php echo $cur.' '.strip($dmcferryRate['adultCost']); ?></td>
<td align="left"><?php echo $cur.' '.strip($dmcferryRate['childCost']); ?></td>
<td align="left"><?php echo $cur.' '.strip($dmcferryRate['infantCost']); ?></td>
<td align="left"><?php echo $cur.' '.strip($dmcferryRate['miscCost']); ?></td>
<td align="left"><?php echo $cur.' '.$dmcferryRate['markupCost']; echo ($dmcferryRate['markupType']==1)?'%':'Flat'; ?></td> 
<td align="left"><?php echo strip($dmcferryRate['remark']); ?></td>
<td align="center" style="min-width:50px;"><a onClick="alertspopupopen('action=editDmcFerryRate&sectionId=<?php echo $dmcferryRate['id']; ?>&serviceId=<?php echo $_REQUEST['serviceid']; ?>','400px','auto');"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px;"></i></a>&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true" style=" margin-left:10px; font-size: 20px; color: #f00; cursor: pointer;" onclick="deleteFerrycost('<?php echo $dmcferryRate['id']; ?>');"></i></td>
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
	
	function deleteFerrycost(id){
		if(confirm('sure you want to delete?')){
		$('#loadfrmaction').load('frmaction.php?action=deleteFerrycost&id='+id);
		}
	}
</script>
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
<style>
.SIC{display:none;}
.PVT{display:none;}
.griddiv{
	margin-bottom: 0px;
}
</style>