<?php
ob_start();
include "inc.php";
?>
<table class="servicetable">
<thead>
	<tr>
		<td align="center">SRN</td>
		<td align="center">City</td>
		<td align="left">Service Type</td>
		<td align="left">Service Name</td>
		<td align="left">RoomType</td>
		<td align="left">Meals</td>
		<td align="center">Check/In</td>
		<td align="center">Check/Out</td>
		<td align="right">Rate Sheet</td>
		<td align="left">TAC</td>
	</tr>
</thead>
<tbody>
	<?php 
   	$rs='';   
   	$cnt = 1; 
   	$totalServiceCost = 0;
	$rs=GetPageRecord('*','docketServiceItinerary',' 1 and queryId="'.$_REQUEST['queryId'].'" '); 	  
	while($docketServiceData=mysqli_fetch_array($rs)){
		$mealPlanName = $roomTypeName = '';
		if($docketServiceData['serviceType']=='hotel'){ 
			$rs232='';
	  		$rs232=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$docketServiceData['mealPlanId'].'"'); 
	    	$mealplanD=mysqli_fetch_array($rs232);
	    	$mealPlanName = ($mealplanD['name']=='')?'EP':$mealplanD['name'];

	    	$rs21='';
	  		$rs21=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$docketServiceData['roomTypeId'].'"'); 
	    	$roomTypeD=mysqli_fetch_array($rs21);
	    	$roomTypeName = $roomTypeD['name'];
	    }

	?>
	<tr>
		<td align="center"><?php echo $cnt; ?></td>
		<td align="center"><?php echo getDestination($docketServiceData['cityId']); ?></td>
		<td><?php echo ucfirst($docketServiceData['serviceType']); ?></td>
		<td><?php echo getDocketServiceName($docketServiceData['serviceId'],$docketServiceData['serviceType']); ?></td>

		<td><?php echo ucfirst($roomTypeName); ?></td>
		<td><?php echo ucfirst($mealPlanName); ?></td>
		<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['startDate'])); ?></td>
		<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['endDate'])); ?></td>		
		<td align="right">
			<?php 
			echo $serviceCost = getTwoDecimalNumberFormat($docketServiceData['serviceCost']); 
			$totalServiceCost = $totalServiceCost+$serviceCost; 
			?></td>
		<td><?php echo tnc; ?></td>
	</tr>
	<?php 
	$cnt++;
	} 
	?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

	<tr style=" height: 60px; ">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="right">Total Cost with Gst(INR)</td>
		<td align="right"><b><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></b></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td  colspan="8" align="right">Total Cost (INR)</td>
		<td align="right"><b><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></b></td>
		<td>&nbsp;</td>
	</tr>
</tbody>
</table>

<?php
