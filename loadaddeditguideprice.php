<?php
include "inc.php";    
if($_REQUEST['action']=='addeditguideprice' && $_REQUEST['rateid']!=''){

$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
$newQuotationData=mysqli_fetch_array($dayQuery); 
$quotationId = $newQuotationData['quotationId'];
$dayDate = $newQuotationData['srdate'];
$guideservieid = $_REQUEST['serviceid'];
// $ferryTimeId = $_REQUEST['ferrytimeId'];
if($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 2){
	$rsat=GetPageRecord('*','quotationGuideRateMaster','id="'.$_REQUEST['quoterateId'].'"'); 
	$dmcroommastermain=mysqli_fetch_array($rsat);
	$guideserviceid = $dmcroommastermain['serviceid'];
	$guidecurrency = $dmcroommastermain['currencyId'];
	$guideSupplierId = $dmcroommastermain['supplierId'];
	$editId = $_REQUEST['quoterateId'];
}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 1){
	$rsat=GetPageRecord('*','dmcGuidePorterRate','id="'.$_REQUEST['rateid'].'"'); 
	$dmcroommastermain=mysqli_fetch_array($rsat);
	$guideserviceid = $dmcroommastermain['serviceid'];
	$guidecurrency = $dmcroommastermain['currencyId'];
	$guideSupplierId = $dmcroommastermain['supplierId'];
}elseif($_REQUEST['rateid'] > 0 && $_REQUEST['tableN'] == 3){ 
	$guideserviceid = $_REQUEST['rateid']; 
	$guidecurrency = '';
	// $guideserviceid = '';
}
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$newQuotationData['quotationId'].'"');
$quotationData=mysqli_fetch_array($quotQuery);
$pax = $quotationData['adult']+$quotationData['child'];

$rsq=GetPageRecord('*','queryMaster','id="'.$newQuotationData['queryId'].'"'); 
$resquery=mysqli_fetch_array($rsq);

$rs2=GetPageRecord('name,id',_GUIDE_SUB_CAT_MASTER_,'id="'.$guideserviceid.'"'); 
$guideServiceName=mysqli_fetch_array($rs2); 
 
?>  
<script src="js/zebra_datepicker.js"></script>
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
    .addeditpagebox .griddiv{
        margin-bottom: 0px !important;
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
<div class="topaboxlist"  style="background-color: #ffffff; border-radius: 3px; padding: 3px; box-shadow: 0px 10px 35px;"> 
<table width="100%" border="0" cellspacing="0" cellpadding="8">
  <tr>

    <td width="100%" align="left"><strong style="font-size: 18px;"><?php echo clean($guideServiceName['name']); ?> </strong></td>
    <td width="12%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#loadguideprice').hide();"></i></td>
  </tr> 
</table>

<div class="addeditpagebox addtopaboxlist">	
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addguiderate" target="actoinfrm"  id="addguiderate"> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  		<tbody> 
	  	<tr >
				<td width="10%"  align="left">
					<div class="griddiv"><label>
						<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
						<select id="guideSupplierId" name="guideSupplierId" class="gridfield validate" displayname="Suppliers" autocomplete="off" style=" width:150px;"  >  
							<?php 
							$where='status=1 and deletestatus=0 and name!="" and guideType=2 order by name asc';  
							$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
							while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
								<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$guideSupplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
							<?php  } ?>
						</select>

						</label>
					</div>
				</td>    
		  	<td width="170" align="left" style="min-width:95px; display:none;">
				<div class="griddiv"><label>
				<div class="gridlable">Guide Name</div>
				<select id="guideNameId" name="guideNameId" class="gridfield"  autocomplete="off" style="width: 100%;" >
				<?php    
				$rs=GetPageRecord('name,id',_GUIDE_SUB_CAT_MASTER_,' 1  order by name asc'); 
				while($guideCmpData=mysqli_fetch_array($rs)){  
				?>
				<option value="<?php echo strip($guideCmpData['id']); ?>" <?php if($guideCmpData['id']==$ferryNameId){ ?>selected="selected"<?php } ?>><?php echo strip($guideCmpData['name']); ?></option>
				<?php } ?> 
			 	</select>
				</label>
				</div>
			</td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>
					<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
					<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php if($dmcroommastermain['fromDate']!=''){ echo date('d-m-Y',strtotime($dmcroommastermain['fromDate'])); }else{ echo date('d-m-Y',strtotime($dayDate));} ?>"  style="width: 100%;" />
					</label>
				</div>
			</td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>
					<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
					<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php if($dmcroommastermain['toDate']!=''){ echo date('d-m-Y',strtotime($dmcroommastermain['toDate'])); }else{ echo date('d-m-Y',strtotime($dayDate)); }?>" style="width: 100%;"/>
					</label>
				</div>
			</td> 

			<?php //if($subCatData['serviceType'] == "0"){ ?>
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Pax&nbsp;Range<span class="redmind"></span></div>
						<select id="paxRange" name="paxRange" class="gridfield " autocomplete="off" >
							<option value="0" >All Pax</option>
							<option value="1_5" <?php if($dmcroommastermain['paxRange'] == '1_5'){ echo 'selected="selected"'; }elseif($pax >= 1 && $pax <= 5){ ?>selected="selected"<?php } ?>>1-5 Pax</option>
							<option value="6_14" <?php if($dmcroommastermain['paxRange'] == '6_14'){ echo 'selected="selected"'; }elseif($pax >= 6 && $pax <= 14){ ?>selected="selected"<?php } ?>>6-14 Pax</option>
							<option value="15_40" <?php if($dmcroommastermain['paxRange'] == '15_40'){ echo 'selected="selected"'; }elseif($pax >= 15 && $pax <= 40){ ?>selected="selected"<?php } ?>>15-40 Pax</option>
						</select>
					</label>
				</div>			</td>
			<?php //} ?>
			<td width="100" align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable">Day&nbsp;Type<span class="redmind"></span></div>
						<select id="dayType" name="dayType" class="gridfield " displayname="Day Type" autocomplete="off" >  
							<option value="halfday" <?php if($dmcroommastermain['dayType']==='halfday'){ ?> selected="selected" <?php } ?> >Half Day</option>  
							<option value="fullday" <?php if($dmcroommastermain['dayType']==='fullday'){ ?> selected="selected" <?php } ?> >Full Day</option> 
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
				</div>			
			</td> 
      
		</tr> 
		<tr>
			<td width="100" align="left">
				<div class="griddiv">
					<label>  
					<div class="gridlable">Currency<span class="redmind"></span></div>
					<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off"  onchange="getROE(this.value,'currencyVal124');"    >
					 <option value="">Select</option>
						<?php 
						$currencyId = ($dmcroommastermain['currencyId']>0)?$dmcroommastermain['currencyId']:$baseCurrencyId;
						$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
						$select=''; 
						$where=''; 
						$rs='';  
						$select='*';    
						$where=' deletestatus=0 and status=1 order by name asc';  
						$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
						while($resListing=mysqli_fetch_array($rs)){   
						?>
						<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
						<?php } ?>
						</select>
					</label>
				</div>			
			</td> 
	 
			<td width="100"  align="left">
				<div class="griddiv" >
				<label> 
					<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input class="gridfield validate" name="currencyValue" displayname="ROI Value"  id="currencyVal124" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
				</label>
				</div>
			</td>

			<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">Guide Cost</div>
				<input name="price" type="text" class="gridfield"  id="price" value="<?php echo $dmcroommastermain['price'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td>
			<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">L.A.</div>
				<input name="languageAllowance" type="text" class="gridfield"  id="languageAllowance" value="<?php echo $dmcroommastermain['languageAllowance'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td>
			<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">Other Cost</div>
				<input name="otherCost" type="text" class="gridfield"  id="otherCost" value="<?php echo $dmcroommastermain['otherCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td> 
			
			<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">GST&nbsp;SLAB(%)</div>
				<select id="guideGST" name="guideGST" class="gridfield" displayname="Restaurant GST" autocomplete="off" style="width: 100%;">
	      <?php
	      $rs2 = "";
	       $rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Guide"');
	      while ($gstSlabData = mysqli_fetch_array($rs2)) {
	                          ?>
	      <option value="<?php echo $gstSlabData['id']; ?>" <?php if($dmcroommastermain['guideGST']==$gstSlabData['id']){ ?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
	       <?php
	      }
	       ?>
	      </select>
				</label>
				</div>
			</td> 
			</tr>
			<tr>
			<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($dmcroommastermain['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($dmcroommastermain['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $dmcroommastermain['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td> 
                                   
			
			<td width="100" align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addguiderate','saveflight','0');"> 
			  <input name="action" type="hidden" id="action" value="addQuotationGuidePrice">
			  <input name="serviceType" type="hidden" id="serviceType" value="<?php echo $subCatData['serviceType']; ?>">
			  <input name="serviceid" type="hidden" id="serviceid" value="<?php echo $guideserviceid; ?>">
			  <input name="editId" type="hidden" id="editId" value="<?php echo $editId ; ?>">
			  <input name="quotationId" type="hidden" id="quotationId" value="<?php echo $quotationId ; ?>">
			  <input name="rateId" type="hidden" id="rateId" value="<?php echo $_REQUEST['rateid'] ; ?>">
       </td>
			</tr> 
		</tbody>
	</table>
</form>
</div>
</div>




<?php } ?>
<style>
.SIC{display:none;}
</style>

<script type="text/javascript">
	$(function() {
		$('#toDate').Zebra_DatePicker({ 
	  	format: 'd-m-Y', 
	});
 	});

	 $(function() {
	 $('#fromDate').Zebra_DatePicker({ 
	  	format: 'd-m-Y',  
		pair: $('#toDate'),
	});
 	});

	 comtabopenclose('linkbox', 'op2');
</script>