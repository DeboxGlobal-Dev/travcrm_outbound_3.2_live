<?php
ob_start();
include "inc.php";
?>
<table class="servicetable" border="1"  >
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
		<td align="right">Service&nbsp;Cost</td>
		<td align="right">GST</td>
		<td align="right">Markup</td>
		<td align="right">TAC</td>
		<td align="right"><strong>Total&nbsp;Cost</strong></td>
	</tr>
</thead>
<tbody>
	<?php  
   	$rs='';   
   	$cnt = 1; 
   	$grandTotalServiceCost = $grandServiceCost = 0;
	$rs=GetPageRecord('*','docketServiceItinerary',' 1 and queryId="'.$_REQUEST['queryId'].'" '); 	  
	while($docketServiceData=mysqli_fetch_array($rs)){
		$mealPlanName = $roomTypeName = '';
		if($docketServiceData['serviceType']=='hotel'){ 

			$hotelMealCostWOGST = $GST = $hotelCost = $mealCost = $hotelMealCostWOGST = $mealGST = $roomTAC = $roomTACValue = $hotelCostWithGST = $mealCostWithGST = $hotelMealCostWithGST = $serviceMarkup = $serviceGSTValue = $totalServiceCost = 0;

			$rs232='';
	  		$rs232=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$docketServiceData['mealPlanId'].'"'); 
	    	$mealplanD=mysqli_fetch_array($rs232);
	    	$mealPlanName = ($mealplanD['name']=='')?'EP':$mealplanD['name'];

		    	$rs21='';
		  		$rs21=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$docketServiceData['roomTypeId'].'"'); 
		    	$roomTypeD=mysqli_fetch_array($rs21);
		    	$roomTypeName = $roomTypeD['name'];
		    	
		    	$markupCost = ($docketServiceData['markupCost']); 
		    	$markupType = ($docketServiceData['markupType']); 

		    	$hotelCost = ($docketServiceData['serviceCost']); 
		    	$mealCost = ($docketServiceData['mealCost']); 

		    	$hotelMealCostWOGST = getTwoDecimalNumberFormat($hotelCost+$mealCost); 
		    $grandServiceCost = $grandServiceCost+$hotelMealCostWOGST; // grand service without gst markup and tac Value container

		    	$GST = getGstValueById($docketServiceData['GST']);
		    	$mealGST = getGstValueById($docketServiceData['mealGST']);
		    	$roomTAC = $docketServiceData['roomTAC'];


		    	$hotelCostWithGST = getCostWithGST($hotelCost,$GST,$roomTAC);
		    	$mealCostWithGST = getCostWithGST($mealCost,$mealGST,0);
		    	
		    	$roomTACValue = getMarkupCost($hotelCost,$roomTAC,1);
		    $grandTACValue = $grandTACValue+$roomTACValue; // grand service TAC Value container

		    	$hotelMealCostWithGST = getTwoDecimalNumberFormat($hotelCostWithGST+$mealCostWithGST);

		    	$serviceMarkup = getMarkupCost($hotelMealCostWithGST,$markupCost,$markupType);
		    $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup; // grand service markup Value container

		    	$totalServiceCost = $hotelMealCostWithGST+$serviceMarkup;
		    $grandTotalServiceCost = $grandTotalServiceCost+$totalServiceCost; // grand service with gst markup and tac Value container


		    	$serviceGSTValue = (getMarkupCost($hotelCost,$GST,1)+getMarkupCost($mealCost,$mealGST,1));
		    $grandGSTValue = $grandGSTValue+$serviceGSTValue;  // grand gst Value container

		     ?>
			<tr>
				<td align="center"><?php echo $cnt; ?></td>
				<td align="center"><?php echo getDestination($docketServiceData['cityId']); ?></td>
				<td><?php echo ucfirst($docketServiceData['serviceType']); ?>
					<a class="dltBtn" onclick="docket_alertbox('action=deleteService&id=<?php echo $docketServiceData['id']; ?>','400px','auto');"><i class="fa fa-remove"></i></a>
				</td>
				<td><?php echo getDocketServiceName($docketServiceData['serviceId'],$docketServiceData['serviceType']); ?></td>
				<td><?php echo $roomTypeName; ?></td>
				<td><?php echo $mealPlanName; ?></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['startDate'])); ?></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['endDate'])); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($hotelMealCostWOGST); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceGSTValue); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceMarkup); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($roomTACValue); ?></td>
				<td align="right"><strong><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></strong></td>
			</tr>
			<?php 
			$cnt++;
		} 
	    if($docketServiceData['serviceType']=='transportation'){ 
	    	
			$serviceMarkup = $serviceGSTValue = $totalServiceCost = 0;
		    	
		    	$markupCost = ($docketServiceData['markupCost']); 
		    	$markupType = ($docketServiceData['markupType']); 
		    	$GST = getGstValueById($docketServiceData['GST']);

		    	$serviceCost = ($docketServiceData['serviceCost']); 
		    	$grandServiceCost = $grandServiceCost+$serviceCost; // grand service without gst markup and tac Value container

		    	$roomTACValue = 0;

		    	$serviceCostWithGST = getCostWithGST($serviceCost,$GST,0); 

		    	$serviceMarkup = getMarkupCost($serviceCostWithGST,$markupCost,$markupType);
		    $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup; // grand service markup Value container

		    	$totalServiceCost = $serviceCostWithGST+$serviceMarkup;
		    $grandTotalServiceCost = $grandTotalServiceCost+$totalServiceCost; // grand service with gst markup and tac Value container

		    	$serviceGSTValue = getMarkupCost($serviceCost,$GST,1);
		    $grandGSTValue = $grandGSTValue+$serviceGSTValue;  // grand gst Value container

		    ?>
			<tr>
				<td align="center"><?php echo $cnt; ?></td>
				<td align="center"><?php echo getDestination($docketServiceData['cityId']); ?></td>
				<td><?php echo ucfirst($docketServiceData['serviceType']); ?>
					<a class="dltBtn" onclick="docket_alertbox('action=deleteService&id=<?php echo $docketServiceData['id']; ?>','400px','auto');"><i class="fa fa-remove"></i></a>
				</td>
				<td><?php echo getDocketServiceName($docketServiceData['serviceId'],$docketServiceData['serviceType']); ?></td>
				<td></td>
				<td></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['startDate'])); ?></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['endDate'])); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceGSTValue); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceMarkup); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($roomTACValue); ?></td>
				<td align="right"><strong><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></strong></td>
			</tr>
			<?php 
			$cnt++;
	    }
	    if($docketServiceData['serviceType']=='activity'){ 
	    	
				$serviceMarkup = $serviceGSTValue = $totalServiceCost = 0;
		    	
		    	$markupCost = ($docketServiceData['markupCost']); 
		    	$markupType = ($docketServiceData['markupType']); 
		    	$GST = getGstValueById($docketServiceData['GST']);

		    	$serviceCost = ($docketServiceData['serviceCost']); 
		    	$grandServiceCost = $grandServiceCost+$serviceCost; // grand service without gst markup and tac Value container

		    	$roomTACValue = 0;

		    	$serviceCostWithGST = getCostWithGST($serviceCost,$GST,0); 

		    	$serviceMarkup = getMarkupCost($serviceCostWithGST,$markupCost,$markupType);
		    $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup; // grand service markup Value container

		    	$totalServiceCost = $serviceCostWithGST+$serviceMarkup;
		    $grandTotalServiceCost = $grandTotalServiceCost+$totalServiceCost; // grand service with gst markup and tac Value container

		    	$serviceGSTValue = getMarkupCost($serviceCost,$GST,1);
		    $grandGSTValue = $grandGSTValue+$serviceGSTValue;  // grand gst Value container

		    ?>
			<tr>
				<td align="center"><?php echo $cnt; ?></td>
				<td align="center"><?php echo getDestination($docketServiceData['cityId']); ?></td>
				<td><?php echo ucfirst($docketServiceData['serviceType']); ?>
					<a class="dltBtn" onclick="docket_alertbox('action=deleteService&id=<?php echo $docketServiceData['id']; ?>','400px','auto');"><i class="fa fa-remove"></i></a>
				</td>
				<td><?php echo getDocketServiceName($docketServiceData['serviceId'],$docketServiceData['serviceType']); ?></td>
				<td></td>
				<td></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['startDate'])); ?></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['endDate'])); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceGSTValue); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceMarkup); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($roomTACValue); ?></td>
				<td align="right"><strong><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></strong></td>
			</tr>
			<?php 
			$cnt++;
		} 
		if($docketServiceData['serviceType']=='entrance'){ 
	    	
				$serviceMarkup = $serviceGSTValue = $totalServiceCost = 0;
		    	
		    	$markupCost = ($docketServiceData['markupCost']); 
		    	$markupType = ($docketServiceData['markupType']); 
		    	$GST = getGstValueById($docketServiceData['GST']);

		    	$serviceCost = ($docketServiceData['serviceCost']); 
		    	$grandServiceCost = $grandServiceCost+$serviceCost; // grand service without gst markup and tac Value container

		    	$roomTACValue = 0;

		    	$serviceCostWithGST = getCostWithGST($serviceCost,$GST,0); 

		    	$serviceMarkup = getMarkupCost($serviceCostWithGST,$markupCost,$markupType);
		    $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup; // grand service markup Value container

		    	$totalServiceCost = $serviceCostWithGST+$serviceMarkup;
		    $grandTotalServiceCost = $grandTotalServiceCost+$totalServiceCost; // grand service with gst markup and tac Value container

		    	$serviceGSTValue = getMarkupCost($serviceCost,$GST,1);
		    $grandGSTValue = $grandGSTValue+$serviceGSTValue;  // grand gst Value container

		    ?>
			<tr>
				<td align="center"><?php echo $cnt; ?></td>
				<td align="center"><?php echo getDestination($docketServiceData['cityId']); ?></td>
				<td><?php echo ucfirst($docketServiceData['serviceType']); ?>
					<a class="dltBtn" onclick="docket_alertbox('action=deleteService&id=<?php echo $docketServiceData['id']; ?>','400px','auto');"><i class="fa fa-remove"></i></a>
				</td>
				<td><?php echo getDocketServiceName($docketServiceData['serviceId'],$docketServiceData['serviceType']); ?></td>
				<td></td>
				<td></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['startDate'])); ?></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['endDate'])); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceGSTValue); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceMarkup); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($roomTACValue); ?></td>
				<td align="right"><strong><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></strong></td>
			</tr>
			<?php 
			$cnt++;
		}
		if($docketServiceData['serviceType']=='restaurant'){ 
	    	
				$serviceMarkup = $serviceGSTValue = $totalServiceCost = 0;
		    	
		    	$markupCost = ($docketServiceData['markupCost']); 
		    	$markupType = ($docketServiceData['markupType']); 
		    	$GST = getGstValueById($docketServiceData['GST']);

		    	$serviceCost = ($docketServiceData['serviceCost']); 
		    	$grandServiceCost = $grandServiceCost+$serviceCost; // grand service without gst markup and tac Value container

		    	$roomTACValue = 0;

		    	$serviceCostWithGST = getCostWithGST($serviceCost,$GST,0); 

		    	$serviceMarkup = getMarkupCost($serviceCostWithGST,$markupCost,$markupType);
		    $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup; // grand service markup Value container

		    	$totalServiceCost = $serviceCostWithGST+$serviceMarkup;
		    $grandTotalServiceCost = $grandTotalServiceCost+$totalServiceCost; // grand service with gst markup and tac Value container

		    	$serviceGSTValue = getMarkupCost($serviceCost,$GST,1);
		    $grandGSTValue = $grandGSTValue+$serviceGSTValue;  // grand gst Value container

		    ?>
			<tr>
				<td align="center"><?php echo $cnt; ?></td>
				<td align="center"><?php echo getDestination($docketServiceData['cityId']); ?></td>
				<td><?php echo ucfirst($docketServiceData['serviceType']); ?>
					<a class="dltBtn" onclick="docket_alertbox('action=deleteService&id=<?php echo $docketServiceData['id']; ?>','400px','auto');"><i class="fa fa-remove"></i></a>
				</td>
				<td><?php echo getDocketServiceName($docketServiceData['serviceId'],$docketServiceData['serviceType']); ?></td>
				<td></td>
				<td></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['startDate'])); ?></td>
				<td align="center"><?php echo date('d-m-Y',strtotime($docketServiceData['endDate'])); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceGSTValue); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($serviceMarkup); ?></td>
				<td align="right"><?php echo getTwoDecimalNumberFormat($roomTACValue); ?></td>
				<td align="right"><strong><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></strong></td>
			</tr>
			<?php 
			$cnt++;
		}
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
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="8" align="right"><b>Total Cost (INR)</b></td>
		<td align="right"><b><?php echo getTwoDecimalNumberFormat($grandServiceCost); ?></b></td>
		<td align="right"><b><?php echo getTwoDecimalNumberFormat($grandGSTValue); ?></b></td>
		<td align="right"><b><?php echo getTwoDecimalNumberFormat($grandServiceMarkup); ?></b></td>
		<td align="right"><b><?php echo getTwoDecimalNumberFormat($grandTACValue); ?></b></td>
		<td align="right"><b><?php echo getTwoDecimalNumberFormat($grandTotalServiceCost); ?></b></td>
	</tr>
	<tr>
		<td  colspan="12" align="right"><b>Total Client Cost (INR)</b></td>
		<td align="right"><b><?php echo getTwoDecimalNumberFormat($grandTotalServiceCost); ?></b></td>
	</tr>
</tbody>
</table>

<?php
