<?php
include "inc.php";

$checkQurey='';
$checkQurey=GetPageRecord('*',_QUERY_MASTER_,' id="'.$_REQUEST['queryId'].'" ');  
$queryData=mysqli_fetch_array($checkQurey);

// $flightNameId = trim($_REQUEST['flightNameId']);
$arrivalTo = trim($_REQUEST['arrivalTo']);
$departureFrom = trim($_REQUEST['departureFrom']);

$queryId = $startDayData['queryId'];
$quotationId = $startDayData['quotationId'];
$dayId=$startDayData['id'];

$whereSearch = '';
if($_REQUEST['flightSearch'] != ''){
	$flightSearch = trim($_REQUEST['flightSearch']);
	$whereSearch = ' and flightName LIKE "%'.$flightSearch.'%" or id in ( select serviceid from dmcAirlineMasterRate where flightNumber = "%'.$flightSearch.'%" ) ';
}
?>
<div style="font-size:16px; padding:10px;position:relative" >
	<span id="entrancecounding"> 0 Flight Found </span>
	<!-- <div class="addBtn1" onclick="openinboundpop('action=addentrancetomaster&dayId=<?php echo $dayId; ?>&cityId=<?php echo $cityId; ?>','800px');">+&nbsp;Add New</div> -->
</div> 
<div style="padding:10px; border:1px #ddd solid; background-color: #fff; margin-bottom:10px;" id="rsBox">
	<div class="topaboxlist"  style="max-height: 300px; overflow: auto;">
	<table width="100%" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;border-color:#ccc;" id="entrancesicTable">
	<thead>
		<tr>
		<th align="left">Flight&nbsp;Name</th>
		<th align="left">Flight&nbsp;Number</th>
		<th align="left">Supplier&nbsp;Name</th>
		<th align="left">Flight&nbsp;Class</th>
		<th align="right">Adult&nbsp;Cost</th>
		<th align="right">Child&nbsp;Cost</th>
		<th align="right">Infant&nbsp;Cost</th>
		<th align="right" >&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$c1=1;
	$whereFlightSql=$flightQuery='';
	$whereFlightSql=' 1 '.$whereSearch.' and status=1  and deletestatus=0  order by flightName asc';
	$flightQuery=GetPageRecord('*',_PACKAGE_BUILDER_AIRLINES_MASTER_,$whereFlightSql);
	while($flightData=mysqli_fetch_array($flightQuery)){

		$flightId=$flightData['id'];
		$flightName=$flightData['flightName'];

		$dmcAirlineQuery='';
		$dmcAirlineQuery=GetPageRecord('*','dmcAirlineMasterRate',' status=1 and serviceid = "'.$flightId.'" order by flightNumber asc'); 
		if(mysqli_num_rows($dmcAirlineQuery)>0){

			while ($dmcAirlineData=mysqli_fetch_array($dmcAirlineQuery)) {

				$adultCost = getCostWithGST($dmcAirlineData['adultCost'],getGstValueById($dmcAirlineData['gstTax']),0);
				$childCost = getCostWithGST($dmcAirlineData['childCost'],getGstValueById($dmcAirlineData['gstTax']),0);
				$infantCost = getCostWithGST($dmcAirlineData['infantCost'],getGstValueById($dmcAirlineData['gstTax']),0);

				if(!empty($dmcAirlineData['currencyId'])){
					$cur=getCurrencyName($dmcAirlineData['currencyId']);
				}else{
					$cur=getCurrencyName($baseCurrencyId);
				}
				?>	
				<tr>
				<td align="left"> <?php echo clean($flightName); ?></td>
				<td align="left">
					<?php echo $dmcAirlineData['flightNumber']; ?>
				</td> 
				<td align="left">
					<?php //echo getsupplierCompany($dmcAirlineData['supplierId']);  ?> 
					<select id="supplierId_s<?php echo $dmcAirlineData['id']; ?>" name="supplierId_s" class="newbox_select" displayname="Supplier" > 
						<option value="">Select Supplier</option>
						<?php     
						// trainsType=8
						$rs1a=GetPageRecord('*',_SUPPLIERS_MASTER_,' status=1 and deletestatus=0 and name!="" and ( airlinesType=7 or  airlinesType=1 ) order by name asc'); 
						while($supplierData=mysqli_fetch_array($rs1a)){   
						?>
						<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
						<?php } ?>
					</select>
				</td>
				<td align="left">
					<div class="input-label">
					   	<select id="flightClass_s<?php echo $dmcAirlineData['id']; ?>" name="flightClass_s<?php echo $dmcAirlineData['id']; ?>" class="gridfield validate" displayname="Flight Class" >
							<option value="First_Class">First Class</option>
							<option value="Business_Class">Business Class</option>
							<option value="Economy_Class">Economy Class</option>
							<option value="Premium_Economy_Class">Premium Economy Class</option>
						</select>
					</div>
				</td>
				<td align="right"><?php
				if(!empty($adultCost)){ 
					echo $cur.' '.strip($adultCost); 
				}else{ 
					echo $cur.' '.'0';
				} ?>
				</td>
				<td align="right"><?php
				if(!empty($childCost)){ 
					echo $cur.' '.strip($childCost); 
				}else{ 
					echo $cur.' '.'0';
				} ?>
				</td>
				<td align="right"><?php
				if(!empty($infantCost)){ 
					echo $cur.' '.strip($infantCost); 
				}else{ 
					echo $cur.' '.'0';
				} ?>
				</td>
				<td align="right" valign="middle">
					<div style="width: fit-content !important; padding: 5px  !important;" class="editbtnselect2" onclick="addflighttoquotations('<?php echo $dmcAirlineData['serviceid']; ?>','<?php echo $dmcAirlineData['id']; ?>');" id="selectthis<?php echo $dmcAirlineData['id']; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
				</td>
				</tr>
				<?php 
			}

		}else{ 
			$cur = getCurrencyName($baseCurrencyId);
			?>
		  	<tr>
			<td align="left" width="200"><?php echo ucfirst($flightName);	?></td>
			<td align="left">
				<div class="input-label">
				   	<input type="text" class="newbox numeric " id="flightNumber_s<?php echo $flightData['id']; ?>" value="0"  />
				</div>
			</td>
			<td align="left">
				<select id="supplierId_s<?php echo $flightData['id']; ?>" class="newbox_select" displayname="Supplier" > 
					<option value="">Select Supplier</option>
					<?php     
					// $rs1a=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" and ( airlinesType=8 or  airlinesType=1 ) order by name asc'); 
					$rs1a=GetPageRecord('*',_SUPPLIERS_MASTER_,' status=1 and deletestatus=0 and name!="" and ( airlinesType=7 or  airlinesType=1 ) order by name asc'); 
					while($supplierData=mysqli_fetch_array($rs1a)){   
					?>
					<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
					<?php } ?>
				</select>
			</td>
			<td align="left">
				<div class="input-label">
				   	<select id="flightClass_s<?php echo $flightData['id']; ?>" class="gridfield validate" displayname="Flight Class" >
						<option value="First_Class">First Class</option>
						<option value="Business_Class">Business Class</option>
						<option value="Economy_Class">Economy Class</option>
						<option value="Premium_Economy_Class">Premium Economy Class</option>
					</select>
				</div>
			</td>
			<td align="right">
				<div class="input-label">
					<span><?php echo $cur; ?></span>
				   	<input type="text" class="newbox numeric " id="adultCost_s<?php echo $flightData['id']; ?>" value="0"  />
				</div>
			</td>
			<td align="right">
				<div class="input-label">
					<span><?php echo $cur; ?></span>
				   	<input type="text" class="newbox numeric " id="childCost_s<?php echo $flightData['id']; ?>" value="0"  />
				</div>
			</td> 
			<td align="right">
				<div class="input-label">
					<span><?php echo $cur; ?></span>
				   	<input type="text" class="newbox numeric " id="infantCost_s<?php echo $flightData['id']; ?>" value="0"  />
				</div>
			</td> 
			<td align="right" valign="middle">
				
				<div style="width: fit-content !important; padding: 5px  !important;" class="editbtnselect2" onclick="addflighttoquotationsNull('<?php echo $flightData['id']; ?>');" id="selectthis<?php echo $flightData['id']; ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
			</td>
		  </tr>
			<?php 
		}
		$c1++; 
	}
	?>
	</tbody>
	</table>
	<script>
	function selectthis(ele){
		$(ele).html('Selected');
		$(ele).removeAttr('onclick');
		$(ele).css('background-color','orange');
	}
	</script>
</div>
<?php if($c1==1){ ?>
<script>
$('#rsBox').append('<div style="text-align:center;">No Flight Found</div>');
</script>
<?php } ?>
</div>
<td> 

 <div style="text-align:end;">   
 	<button style="cursor: pointer;font-weight: 700;padding: 5px 10px" onclick="closeinbound();">close</button>
 </div>

 </td>
<script>
$('#entrancecounding').text('<?php echo $c1-1;?> Flight Found');
</script>

 <style>
	.editbtnselect2{   
		border: 1px solid;
	    padding: 8px 15px;
	    text-align: center;
	    font-size: 13px;
	    border-radius: 3px;
	    background-color: #4caf50;
	    cursor: pointer;
	    color: #fff;
	}
	.newbox{
		    height: 20px;
	    width: 60px;
	    border: 1px solid;
	    border-color: #ccc;
	    border-radius: 2px;
	}
	.newbox_select{
		height: 30px;
		width: 140px;
	}
</style>
