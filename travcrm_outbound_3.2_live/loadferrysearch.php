<?php
include "inc.php";  
$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
$newQuotationData=mysqli_fetch_array($dayQuery); 

$queryId = $newQuotationData['queryId'];
$quotationId = $newQuotationData['quotationId'];
$dayId = $newQuotationData['id'];
$dayDate = $newQuotationData['srdate'];
 
$fromDate=date("Y-m-d", strtotime($dayDate));
$toDate=date("Y-m-d", strtotime($dayDate)); 
$arrivalTo = trim($_REQUEST['todestination']);

if($_REQUEST['destWise'] == 2 ){
	$cityId = $_REQUEST['cityId'];
}else{
	$cityId = $newQuotationData['cityId'];
} 

if($fromDate!=''){
	$dateQuery=' and status=1 and "'.$fromDate.'" BETWEEN fromDate AND toDate ';
	// $dateQuery=' and status=1 BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ';
}

$ferrySeatQuery = '';	

if($_REQUEST['ferrySeatId']>0){
	$ferrySeatQuery = ' and ferryClass="'.$_REQUEST['ferrySeatId'].'"';
}
$ferryServiceId=$_REQUEST['ferryServiceId'];
$supplierQuery=' and supplierId in ( select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and ferryType=10  )  ';
?>
<div id="viewinfo" style="display:none;position: absolute; z-index: 9999999999; border: 1px solid #ccc; width: 100%; height: 1000px; top: 0px; left: 0px; background-color: #0d0f14c7;">
	<div id="loadvechileinfo" style="margin: auto; width: 60%; margin-top: 100px;"></div>
</div>


<div style="position: relative;float: right; "  >
<div class="addBtn" onclick="openinboundpop('action=addferrytomaster&dayId=<?php echo $dayId; ?>&cityId=<?php echo $cityId; ?>','800px');" style=" padding: 6px 10px !important;margin: 6px;width: 80px;color: #fff;font-size: 13px;border-radius: 3px;cursor: pointer; ">+&nbsp;Add New</div>
</div>

<style>
	.addBtn{
		background: #7a96ff;
		font-size: 16px !important;
		color: #ffffff;
		cursor: pointer;
		padding: 5px 7px;
		border: 1px solid #fff;
		box-shadow: 0px 3px 5px -1px black;
	}
</style>

<div style="padding:10px; border:1px #e3e3e3 solid;background-color: #fff; margin-bottom:10px;" id="trabox">   
	<div class="topaboxlist" id="trabox2">
	<div style="margin-bottom:5px; font-size:15px;">
<!-- 	<table border="0" cellpadding="0" cellspacing="0">
	  <tbody><tr><td style="padding-right:15px;"><img src="images/dmccaricon.png" ></td>
		<td colspan="2">&nbsp;</td> 
	  </tr> 
		</tbody>
	</table> -->
	</div>
	
<?php  
$rsty="";
$rsty=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' 1 and FIND_IN_SET("'.$cityId.'",destinationId) and id="'.$ferryServiceId.'" and status=1 order by id desc'); 
if(mysqli_num_rows($rsty)>0){ 
	?>
	<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
    <thead> 
    <tr>
	 <th align="left" bgcolor="#DDDDDD">Ferry&nbsp;Service</th> 
	 <th align="left" bgcolor="#DDDDDD">Ferry&nbsp;Name</th> 
	 <!-- <th align="left" bgcolor="#DDDDDD">Ferry&nbsp;Company</th> -->
	 <th align="left" bgcolor="#DDDDDD">Pax&nbsp;Seat Type</th> 
	 <th align="left" bgcolor="#DDDDDD">Arrival&nbsp;Time</th> 
	 <th align="left" bgcolor="#DDDDDD">Departure&nbsp;Time</th> 
	 <th align="center" bgcolor="#DDDDDD">Adult&nbsp;Cost</th>
	 <th align="center" bgcolor="#DDDDDD">Child&nbsp;Cost</th>
	 <th align="center" bgcolor="#DDDDDD">Infant&nbsp;Cost</th>
	 <th align="center" colspan="2" bgcolor="#DDDDDD">&nbsp;</th>
   </tr>
   </thead> 
  <tbody>
	<?php 
	// echo $_REQUEST['ferryTimeId'];
	$whereTime = ' id="'.$_REQUEST['ferryTimeId'].'"';
	$timeres111=GetPageRecord('*','ferryServiceTiming',$whereTime); 
	$ferryTimeressss=mysqli_fetch_array($timeres111);


	
	while($ferryServiceData=mysqli_fetch_array($rsty)){
	$c2=1;
	$select22=''; 
	$wher22=''; 
	$rs22='';
	$select22='*'; 
	$where22=' 1 and serviceid="'.$ferryServiceData['id'].'" '.$ferrySeatQuery.' '.$supplierQuery.' '.$dateQuery.' and status=1 order by id asc';
	$rs22=GetPageRecord($select22,_DMC_FERRY_RATE_MASTER_,$where22); 
	if(mysqli_num_rows($rs22)>0){
		while($dmcroommastermain=mysqli_fetch_array($rs22)){
			
			$rsa2s=GetPageRecord('*',_QUOTATION_FERRY_RATE_MASTER_,' rateId="'.$dmcroommastermain['id'].'" and quotationId="'.$quotationId.'" ');  
			if(mysqli_num_rows($rsa2s)>0){
				$dmcroommastermain=mysqli_fetch_array($rsa2s);
				$tableN = 2;
			
				$adultCost = 0;
				$childCost = 0;
				$infantCost = 0;
				// $processingfee = strip($dmcroommastermain['processingfee']); 
				$miscCost = strip($dmcroommastermain['miscCost']); 

				$adultCost = strip(($dmcroommastermain['adultCost']+$miscCost)); 
				$childCost = strip(($dmcroommastermain['childCost']+$miscCost)); 
				$infantCost = strip(($dmcroommastermain['infantCost']+$miscCost)); 

				$markupcostA = getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$markupcostC = getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$markupcostE = getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$adultCost = $adultCost+$markupcostA;
				$childCost = $childCost+$markupcostC;
				$infantCost = $infantCost+$markupcostE;
				$gstValueFerry=getGstValueById($dmcroommastermain['gstTax']); 
				$adultCost= round(($adultCost*$gstValueFerry/100)+$adultCost); 
				$childCost= round(($childCost*$gstValueFerry/100)+$childCost); 
				$infantCost= round(($infantCost*$gstValueFerry/100)+$infantCost); 

			}else{
				$tableN = 1;

				$adultCost = 0;
				$childCost = 0;
				$infantCost = 0;
				// $processingfee = strip($dmcroommastermain['processingfee']); 
				$miscCost = strip($dmcroommastermain['miscCost']); 
				$adultCost = strip(($dmcroommastermain['adultCost']+$miscCost)); 
				$childCost = strip(($dmcroommastermain['childCost']+$miscCost)); 
				$infantCost = strip(($dmcroommastermain['infantCost']+$miscCost)); 

				$markupcostA = getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$markupcostC = getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$markupcostE = getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$adultCost = $adultCost+$markupcostA;
				$childCost = $childCost+$markupcostC;
				$infantCost = $infantCost+$markupcostE;

				$gstValueFerry=getGstValueById($dmcroommastermain['gstTax']); 
				$adultCost= round(($adultCost*$gstValueFerry/100)+$adultCost); 
				$childCost= round(($childCost*$gstValueFerry/100)+$childCost); 
				$infantCost= round(($infantCost*$gstValueFerry/100)+$infantCost); 
			}
			

			$rsa2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id='.$dmcroommastermain['currencyId'].''); 
			$editresult2=mysqli_fetch_array($rsa2); 
			$cur=clean($editresult2['name']); 

			$ferryNamQuery=GetPageRecord('*',_FERRY_NAME_MASTER_,' id="'.$dmcroommastermain['ferryNameId'].'"'); 
			$ferryNamD=mysqli_fetch_array($ferryNamQuery); 
				
			?>
		  	<tr>
			<td align="left"><?php  echo clean($ferryServiceData['name']); ?></td>
			<td align="left"><?php echo trim($ferryNamD['name']);  ?></td>

			<td align="left"><?php echo getFerryClassName($dmcroommastermain['ferryClass']);  ?></td>

			<td><?php echo $ferryTimeressss['pickupTime'] ; ?></td>

			<td><?php echo $ferryTimeressss['dropTime'] ; ?></td>

			<td align="center"><?php echo $cur.' '.$adultCost; ?></td>
			<td align="center"><?php echo $cur.' '.$childCost; ?></td>
			<td align="center"><?php echo $cur.' '.$infantCost; ?></td>

			<td align="center"><div class="editbtnselect" onclick="addferrytoquotations('<?php echo $dmcroommastermain['id'];?>','<?php echo $tableN;?>','<?php echo $ferryServiceId; ?>');" id="selectthis<?php echo $dmcroommastermain['id'];?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>

			<td align="center"><div class="editbtnselect" onclick="addferryCostfun('<?php echo $ferryServiceId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tableN;?>');" >+&nbsp;Edit&nbsp;Cost</div>	</td>
			</tr> 
			<?php  
			$c2++; 
			$n++; 
		} 
	}else{

		$where222='serviceid="'.$ferryServiceId.'" and quotationId="'.$quotationId.'" '.$ferrySeatQuery.' order by id desc';   
		$rs222=GetPageRecord('*',_QUOTATION_FERRY_RATE_MASTER_,$where222); 
		if(mysqli_num_rows($rs222)>0){
			while($dmcroommastermain=mysqli_fetch_array($rs222)){  

				$tableN = 2;
		
				$adultCost = 0;
				$childCost = 0;
				$infantCost = 0;
				// $processingfee = strip($dmcroommastermain['processingfee']); 
				$miscCost = strip($dmcroommastermain['miscCost']); 
				$adultCost = strip(($dmcroommastermain['adultCost']+$miscCost)); 
				$childCost = strip(($dmcroommastermain['childCost']+$miscCost)); 
				$infantCost = strip(($dmcroommastermain['infantCost']+$miscCost));
				
				$markupcostA = getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$markupcostC = getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$markupcostE = getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
				$adultCost = $adultCost+$markupcostA;
				$childCost = $childCost+$markupcostC;
				$infantCost = $infantCost+$markupcostE;

				$gstValueFerry=getGstValueById($dmcroommastermain['gstTax']); 
				$adultCost= round(($adultCost*$gstValueFerry/100)+$adultCost); 
				$childCost= round(($childCost*$gstValueFerry/100)+$childCost);
				$infantCost= round(($infantCost*$gstValueFerry/100)+$infantCost);

				$rsa2=GetPageRecord('name',_QUERY_CURRENCY_MASTER_,'id='.$dmcroommastermain['currencyId'].''); 
				$editresult2=mysqli_fetch_array($rsa2); 
				$cur=clean($editresult2['name']); 

				$ferryNamQuery=GetPageRecord('*',_FERRY_NAME_MASTER_,' id="'.$dmcroommastermain['ferryNameId'].'"'); 
				$ferryNamD=mysqli_fetch_array($ferryNamQuery); 

				?>
				<tr>
				<td align="left"><?php echo clean($ferryServiceData['name']); ?></td>
				<td align="left"><?php echo trim($ferryNamD['name']);  ?></td>

				<td align="left"><?php echo getFerryClassName($dmcroommastermain['ferryClass']);  ?></td>

				<td><?php echo $ferryTimeressss['pickupTime'] ; ?></td>

				<td><?php echo $ferryTimeressss['dropTime'] ; ?></td>


				<td align="center"><?php echo $cur.' '.$adultCost; ?></td>
				<td align="center"><?php echo $cur.' '.$childCost; ?></td>
				<td align="center"><?php echo $cur.' '.$infantCost; ?></td>

				<td align="center"><div class="editbtnselect" onclick="addferrytoquotations('<?php echo $dmcroommastermain['id'];?>','<?php echo $tableN;?>','<?php echo $ferryServiceId; ?>');" id="selectthis<?php echo $dmcroommastermain['id'];?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>

				<td align="center">
				<div class="editbtnselect" onclick="addferryCostfun('<?php echo $ferryServiceId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tableN;?>');" >+&nbsp;Edit&nbsp;Cost</div>						     
				</td>
				</tr>
			  <?php
			}  
		}else{
			?>
			<tr>
				<td align="left"><?php echo clean($ferryServiceData['name']); ?></td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td> 
		    	<td align="center">
			    	<div class="editbtnselect" onclick="addferryCostfun('<?php echo $ferryServiceId; ?>','','2');" >+&nbsp;Edit&nbsp;Cost</div>
			    </td>
		  	</tr>
			<?php
		} 
	} 
	}
	?> 
	</tbody>
	</table> 
	</div> 
 <script>
 	function addferryCostfun(ferryServiceId,rateId,tableN){
	 $('#viewinfo').show();
	 $('#loadvechileinfo').load('editferryCost.php?ferryServiceId='+ferryServiceId+'&tableN='+tableN+'&dayId=<?php echo $dayId; ?>&rateId='+rateId+'&ferrytimeId=<?php echo $_REQUEST['ferryTimeId']; ?>');
	 }
 </script>		
 <script>
	function selectthis(ele){
		$(ele).html('Selected');
		$(ele).removeAttr('onclick');
		$(ele).css('background-color','#d88319');
	}
	</script>
	 
	</div>
 
	<?php 
}else{
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
		<tr style="text-align: center;color:red;">
			<td align="" valign="top"><strong style="font-size: 15px;">Please select ferry service!</strong></td>
		</tr>
  </table>
	<?php 
} ?>

<script>
$(document).on("input", ".numeric", function() {
this.value = this.value.replace(/\D/g,'');
});
</script>


