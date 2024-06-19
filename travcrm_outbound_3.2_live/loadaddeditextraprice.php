<?php
include "inc.php";    

if($_REQUEST['rateid']!=''){
	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 
	$dayId = $newQuotationData['dayId'];
	$cityId = $newQuotationData['cityId'];
	$dayDate = $newQuotationData['srdate'];
	$quotationId = $newQuotationData['quotationId'];


	$rsat=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,'id="'.$_REQUEST['rateid'].'"'); 
	$dmcEntranceData=mysqli_fetch_array($rsat);
	$serviceId = $dmcEntranceData['serviceId'];
	$currencyId = $dmcEntranceData['currencyId'];
	$currencyValue = $dmcEntranceData['currencyValue'];
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
		 
		input[name='addnewuserbtn']{
			display:none;
		}

	</style>
	<div class="topaboxlist"  style="background-color: #ffffff; border-radius: 3px; padding: 3px; box-shadow: 0px 10px 35px;"> 
	<table width="100%" border="0" cellspacing="0" cellpadding="8">
	  <tr> 
	    <td width="100%" align="left"><strong style="font-size: 18px;"><?php echo clean($dmcEntranceData['name']); ?> </strong></td>
	    <td width="12%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#loadprice').hide();"></i></td>
	  </tr> 
	</table>

	<div class="addeditpagebox addtopaboxlist">	
	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addrate" target="actoinfrm"  id="addrate"> 
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
	  		<tbody> 
		  	<tr >
				<td width="100"  align="left">
				   	<div class="griddiv"><label>
						<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
						<select id="supplierId2" name="supplierId2" class="gridfield validate" displayname="Suppliers" autocomplete="off" style=" width:150px;"  >  
						 	<?php 
							$where=' deletestatus=0 and name!="" and  ( otherType=13 or otherType=1 ) and status=1 order by name asc';  
							$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
							while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
								<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$supplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
							<?php  } ?>
						</select>

						</label>
					</div>
				</td>   
				
				<td width="100" align="left">
					<div class="griddiv">
						<label>  
						<div class="gridlable">Currency<span class="redmind"></span></div>
						<select id="currencyId2" name="currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'currencyVal126');"    >
						 <option value="">Select</option>
							<?php 
							$currencyId = ($dmcEntranceData['currencyId']>0)?$dmcEntranceData['currencyId']:$baseCurrencyId;
							$currencyValue = ($dmcEntranceData['currencyValue']>0)?$dmcEntranceData['currencyValue']:getCurrencyVal($currencyId);
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
				<td width="100"  align="left"><div class="griddiv">
					<label> 
					<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input class="gridfield validate" name="currencyValue2" displayname="ROI Value"  id="currencyVal126" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
					</label>
					</div>
				</td>
			</tr> 
			<tr>
				<td width="100" align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable">Cost Type<span class="redmind"></span></div>
							<select id="costType2" type="text" class="gridfield" name="costType2" autocomplete="off" style="width: 100%;" onchange="selectcost();">
								<option value="0">Select Cost Type</option>
								<option value="1" selected="selected">Per Person</option>
								<option value="2">Group Cost</option>
							</select>
						</label>
						<script>
							function selectcost() {
								var costType = $('#costType2').val();
								if (costType == 0) {
									$('.pp').hide();
									$('.tot').hide();
									$('#adultCost2').val('');
									$('#childCost2').val('');
									$('#groupCost2').val('');
								}
								if (costType == 1) {
									$('.pp').show();
									$('.tot').hide();
									$('#groupCost2').val('');
								}
								if (costType == 2) {
									$('.pp').hide();
									$('.tot').show();
									$('#adultCost2').val('');
									$('#childCost2').val('');
								}
							}
							selectcost();
						</script>
					</div> 
				</td> 

				<td width="100" align="left" class="pp">
					<div class="griddiv" >
					<label>
						<div class="gridlable" style="width:100%">Per Pax Cost</div>
						<input name="adultCost2" type="number" class="gridfield" id="adultCost2" displayname="Per Pax Cost" value="<?php echo $dmcEntranceData['adultCost']; ?>" maxlength="6">
					</label>
					</div>
				</td>
				<td width="100" align="left" class="tot" style="display: none;">
					<div class="griddiv " >
						<label>
							<div class="gridlable">Group Cost</div>
							<input name="groupCost2" type="number" class="gridfield" id="groupCost2" displayname="Group Cost" value="<?php echo $dmcEntranceData['groupCost']; ?>" maxlength="6">
						</label>
					</div>
				</td>
				<!-- <td width="100"  >
					<div class="griddiv">
						<label>
							<div class="gridlable">REMARKS</div>
							<input name="remark2" type="text" class="gridfield" id="remark2" value="<?php echo $dmcEntranceData['remark'] ?>" style="width: 99%;">
						</label>
					</div>
				</td> -->
				<td width="100" align="left"><div class="griddiv"><label>
					<div class="gridlable">GST&nbsp;SLAB(%)</div>
					<select id="gstTax2" name="gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
				      <?php
				      $rs2 = "";
				       $rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Activity"');
				      while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
				      	<option value="<?php echo $gstSlabData['id']; ?>" <?php if($dmcEntranceData['gstTax']==$gstSlabData['id']){ ?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
				       <?php
				      } ?>
				      </select>
					</label>
					</div>
				</td> 
				<td width="100" align="left" valign="middle"  ><input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addrate','saveflight','0');"> 
				  <input name="action" type="hidden" id="action" value="addQuotationExtraPrice">  
				  <input name="quotationId2" type="hidden" id="quotationId2" value="<?php echo $quotationId ; ?>">
				  <input name="dayId2" type="hidden" id="dayId2" value="<?php echo $dayId ; ?>">
				  <input name="cityId2" type="hidden" id="cityId2" value="<?php echo $cityId ; ?>">
				  <input name="quotationId2" type="hidden" id="quotationId2" value="<?php echo $quotationId ; ?>">
				  <input name="dayDate2" type="hidden" id="dayDate2" value="<?php echo $dayDate ; ?>">
				  <input name="serviceId2" type="hidden" id="serviceId2" value="<?php echo $_REQUEST['rateid'] ; ?>">
				  <input name="rateid2" type="hidden" id="rateid2" value="<?php echo $_REQUEST['rateid'] ; ?>">
	       		</td>
				</tr> 
			</tbody>
		</table>
	</form>
	</div>
	</div>

	<script type="text/javascript">
		function selectTransferType2(ele){
			if(ele.value == 1){
				$('.SIC').css('display','table-cell');
				$('.PVT').css('display','none');
			}else{
				$('.PVT').css('display','table-cell');
				$('.SIC').css('display','none');
			}
		}
	</script>
	<?php 
} 
?>