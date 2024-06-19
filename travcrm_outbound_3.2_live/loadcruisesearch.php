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

if($_REQUEST['destWise'] == 2 ){
	$cityId = $_REQUEST['destinationId'];
}else{
	$cityId = $newQuotationData['cityId'];
} 

if($fromDate!=''){
	$dateQuery=' and status=1 and "'.$fromDate.'" BETWEEN fromDate AND toDate ';
}

$cruiseNameId='';
if($_REQUEST['cruiseNameId']!=''){
    $cruiseNameId = 'and cruiseNameId="'.$_REQUEST['cruiseNameId'].'"';
}

$cabinTypeId = '';	
if($_REQUEST['cabinTypeId']>0){
	$cabinTypeId = ' and cabinTypeId="'.$_REQUEST['cabinTypeId'].'"';
}

$cruiseServiceId=$_REQUEST['cruiseServiceId'];
$supplierQuery=' and supplierId in ( select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and cruiseType=15  )  ';

?>
<div style="font-size:16px; padding:0px;position:relative;"  >
<!-- <div class="addBtn" onclick="openinboundpop('action=addferrytomaster&dayId=<?php echo $dayId; ?>&cityId=<?php echo $cityId; ?>','800px');" style=" right: 14px; top: 8px; ">+&nbsp;Add New</div> -->
</div>

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
$rsty=GetPageRecord('*',_CRUISE_MASTER_,' 1 and FIND_IN_SET("'.$cityId.'",destination) and id="'.$cruiseServiceId.'" and status=1 order by id desc'); 
if(mysqli_num_rows($rsty)>0){ 
	?>
	<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
    <thead> 
    <tr>
	 <th align="left" bgcolor="#DDDDDD">Cruise&nbsp;Package&nbsp;Name</th> 
	 <th align="left" bgcolor="#DDDDDD">Cruise&nbsp;Name</th> 
	 <th align="left" bgcolor="#DDDDDD">Cabin&nbsp;Type</th> 
	 <th align="center" bgcolor="#DDDDDD">Adult&nbsp;Cost</th> 
	 <th align="center" bgcolor="#DDDDDD">Child&nbsp;Cost</th> 
	 <th align="center" bgcolor="#DDDDDD">Infant&nbsp;Cost</th> 
	 <th align="center" colspan="2" bgcolor="#DDDDDD">Action</th>
   </tr>
   </thead> 
  <tbody>
	<?php 
	// echo $_REQUEST['ferryTimeId'];

	while($cruiseServiceData=mysqli_fetch_array($rsty)){
	$c2=1;
	$select22=''; 
	$wher22=''; 
	$rs22='';
	$select22='*'; 
    
	$where22=' 1 and serviceId="'.$cruiseServiceData['id'].'" '.$cruiseNameId.' '.$cabinTypeId.' '.$supplierQuery.' '.$dateQuery.' and status=1 order by id asc';
	$rs22=GetPageRecord($select22,_DMC_CRUISE_RATE_MASTER_,$where22); 
	if(mysqli_num_rows($rs22)>0){
		while($dmcroommastermain=mysqli_fetch_array($rs22)){
			
			$rsa2s=GetPageRecord('*',_QUOTATION_CRUISE_RATE_MASTER_,' rateId="'.$dmcroommastermain['id'].'" and quotationId="'.$quotationId.'" ');  
			if(mysqli_num_rows($rsa2s)>0){
				$dmcroommastermain=mysqli_fetch_array($rsa2s);
				$tableN = 2;
			
				$adultCost = 0;
				$childCost = 0;
				$infantCost = 0;
				
				$adultCost = strip($dmcroommastermain['adultCost']); 
				$childCost = strip($dmcroommastermain['childCost']); 
				$infantCost = strip($dmcroommastermain['infantCost']); 

				$adultCost = getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$adultCost;
                $childCost = getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$childCost;
                $infantCost = getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$infantCost;

				$gstValueFerry=getGstValueById($dmcroommastermain['gstTax']); 
				$adultCost= round(($adultCost*$gstValueFerry/100)+$adultCost); 
				$childCost= round(($childCost*$gstValueFerry/100)+$childCost); 
				$infantCost= round(($infantCost*$gstValueFerry/100)+$infantCost); 

			}else{
				$tableN = 1;

				$adultCost = 0;
				$childCost = 0;
				$infantCost = 0;
			
				$adultCost = strip($dmcroommastermain['adultCost']); 
				$childCost = strip($dmcroommastermain['childCost']); 
				$infantCost = strip($dmcroommastermain['infantCost']); 
             
                $adultCost = getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$adultCost;
                $childCost = getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$childCost;
                $infantCost = getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$infantCost;
			
				$gstValueCruise=getGstValueById($dmcroommastermain['gstTax']); 
				$adultCost= round(($adultCost*$gstValueCruise/100)+$adultCost); 
				$childCost= round(($childCost*$gstValueCruise/100)+$childCost); 
				$infantCost= round(($infantCost*$gstValueFerry/100)+$infantCost); 
			}
			

			$cur=getCurrencyName($dmcroommastermain['currencyId']); 

			$cruiseNamQuery=GetPageRecord('*',_CRUISE_NAME_MASTER_,' id="'.$dmcroommastermain['cruiseNameId'].'"'); 
			$cruiseNamD=mysqli_fetch_array($cruiseNamQuery); 

            $cabinTypeQuery=GetPageRecord('*',_CABIN_TYPE_,' id="'.$dmcroommastermain['cabinTypeId'].'"'); 
			$cabinNamD=mysqli_fetch_array($cabinTypeQuery); 
				
			?>
		  	<tr>
			<td align="left"><?php  echo clean($cruiseServiceData['cruiseName']); ?></td>
			<td align="left"><?php echo trim($cruiseNamD['name']);  ?></td>

			<td align="left"><?php echo $cabinNamD['name'];  ?></td>

			<td align="center"><?php echo $cur.' '.$adultCost; ?></td>
			<td align="center"><?php echo $cur.' '.$childCost; ?></td>
			<td align="center"><?php echo $cur.' '.$infantCost; ?></td>

			<td align="center"><div class="editbtnselect" onclick="addCruiseToQuotation('<?php echo $dmcroommastermain['id'];?>','<?php echo $tableN;?>','<?php echo $cruiseServiceId; ?>');" id="selectthis<?php echo $dmcroommastermain['id'];?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>

			<td align="center"><div class="editbtnselect" onclick="editCruiseCostfun('<?php echo $cruiseServiceId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tableN;?>');" >+&nbsp;Edit&nbsp;Cost</div>	</td>
			</tr> 
			<?php  
			$c2++; 
			$n++; 
		} 
	}else{

		$where222='serviceId="'.$cruiseServiceId.'" and quotationId="'.$quotationId.'" '.$cruiseNameId.' '.$cabinTypeId.' order by id desc';   
		$rs222=GetPageRecord('*',_QUOTATION_CRUISE_RATE_MASTER_,$where222); 
		if(mysqli_num_rows($rs222)>0){
			while($dmcroommastermain=mysqli_fetch_array($rs222)){  

				$tableN = 2;
		
				$adultCost = 0;
				$childCost = 0;
				$infantCost = 0;
				 
				$adultCost = strip($dmcroommastermain['adultCost']); 
				$childCost = strip($dmcroommastermain['childCost']); 
				$infantCost = strip($dmcroommastermain['infantCost']); 

                $adultCost = getMarkupCost($adultCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$adultCost;
                $childCost = getMarkupCost($childCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$childCost;
                $infantCost = getMarkupCost($infantCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType'])+$infantCost;

				$gstValueFerry=getGstValueById($dmcroommastermain['gstTax']); 
				$adultCost= round(($adultCost*$gstValueFerry/100)+$adultCost); 
				$childCost= round(($childCost*$gstValueFerry/100)+$childCost);
				$infantCost= round(($infantCost*$gstValueFerry/100)+$infantCost);

				$cur=getCurrencyName($dmcroommastermain['currencyId']); 

                $cruiseNamQuery=GetPageRecord('*','cruiseNameMaster',' id="'.$dmcroommastermain['cruiseNameId'].'"'); 
                $cruiseNamD=mysqli_fetch_array($cruiseNamQuery); 
    
                $cabinTypeQuery=GetPageRecord('*',_CABIN_TYPE_,' id="'.$dmcroommastermain['cabinTypeId'].'"'); 
                $cabinNamD=mysqli_fetch_array($cabinTypeQuery); 

				?>
				<tr>
				<td align="left"><?php  echo clean($cruiseServiceData['cruiseName']); ?></td>
			    <td align="left"><?php echo trim($cruiseNamD['name']);  ?></td>

			    <td align="left"><?php echo $cabinNamD['name'];  ?></td>

				<td align="center"><?php echo $cur.' '.$adultCost; ?></td>
				<td align="center"><?php echo $cur.' '.$childCost; ?></td>
				<td align="center"><?php echo $cur.' '.$infantCost; ?></td>

				<td align="center"><div class="editbtnselect" onclick="addCruiseToQuotation('<?php echo $dmcroommastermain['id'];?>','<?php echo $tableN;?>','<?php echo $cruiseServiceId; ?>');" id="selectthis<?php echo $dmcroommastermain['id'];?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>

				<td align="center">
				<div class="editbtnselect" onclick="editCruiseCostfun('<?php echo $cruiseServiceId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tableN;?>');" >+&nbsp;Edit&nbsp;Cost</div>						     
				</td>
				</tr>
			  <?php
			}  
		}else{ 

			$cruiseNamQuery=GetPageRecord('*','cruiseNameMaster',' id="'.$_REQUEST['cruiseNameId'].'"'); 
            $cruiseNamD=mysqli_fetch_array($cruiseNamQuery); 

            $cabinTypeQuery=GetPageRecord('*',_CABIN_TYPE_,' id="'.$_REQUEST['cabinTypeId'].'"'); 
            $cabinNamD=mysqli_fetch_array($cabinTypeQuery); 
			?>
			<tr>
				<td align="left"><?php echo clean($cruiseServiceData['cruiseName']); ?></td>
			    <td align="left"><?php echo trim($cruiseNamD['name']);  ?></td>
			    <td align="left"><?php echo $cabinNamD['name'];  ?></td>
				<td align="center">NA</td>
				<td align="center">NA</td>
				<td align="center">NA</td>
		    	<td align="center">
			    	<div class="editbtnselect" onclick="editCruiseCostfun('<?php echo $cruiseServiceId; ?>','','3');" >+&nbsp;Edit&nbsp;Cost</div>
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

<div id="loadprice" class="viewInfo" style="background-image: url('images/bgpop.png'); background-repeat: repeat;margin-top: 55px;">
	<div class="pricepoup"></div>
</div>

<style type="text/css">
	

	#loadprice {
	background-color: #00000094;
	background-color: rgba(50, 61, 76, 0.91);
	width: 100%;
	height: 100%;
	position: fixed;
	left: 0px;
	top: 0px;
	overflow: auto;
	display: none;
	z-index: 9999;
	}
	#loadprice .pricepoup {
	background-color: #FFFFFF;
	max-width: 800px;
	margin: auto;
	margin-top: 20px;
	}

</style>
 <script>
 	function editCruiseCostfun(cruiseServiceId,rateId,tableN){
	 $('#loadprice').show();
	 $('.pricepoup').load(`loadaddeditcruiseprice.php?cruiseServiceId=${cruiseServiceId}&tableN=${tableN}&dayId=<?php echo $dayId; ?>&rateId=${rateId}&cruiseNameId=<?php echo $_REQUEST['cruiseNameId']; ?>&cabinTypeId=<?php echo $_REQUEST['cabinTypeId']; ?>&destinationId=<?php echo $cityId; ?>`);
		// $('.pricepoup').css('width', poupwidth);
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
		<tr>
			<td align="" valign="top"><strong style="font-size: 15px;">Please select Cruise Package service!</strong></td>
		</tr>
  </table>
	<?php 
} ?>

<script>
$(document).on("input", ".numeric", function(){
this.value = this.value.replace(/\D/g,'');
});
</script>


