<?php
include "inc.php";   

				$roomrs = GetPageRecord('*','roomMaster','roomName="quadroom"');
				$roomQuad = mysqli_fetch_assoc($roomrs);

				$roomrs1 = GetPageRecord('*','roomMaster','roomName="sixbedroom"');
				$roomSix = mysqli_fetch_assoc($roomrs1);

				$roomrs2 = GetPageRecord('*','roomMaster','roomName="eightbedroom"');
				$roomEight = mysqli_fetch_assoc($roomrs2);

				$roomrs3 = GetPageRecord('*','roomMaster','roomName="tenbedroom"');
				$roomTen = mysqli_fetch_assoc($roomrs3);

				$roomrs4 = GetPageRecord('*','roomMaster','roomName="teenbed"');
				$roomTeen = mysqli_fetch_assoc($roomrs4);

?> 

<div>
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC"> 
	<tr>
	<td align="left" valign="middle" bgcolor="#DDDDDD"><strong>Market Type</strong></td>
	<td align="left" valign="middle" bgcolor="#DDDDDD"><strong>Season Type</strong></td>
	<td align="left" valign="middle" bgcolor="#DDDDDD"><strong>Season Year</strong></td>
	<td align="left" valign="middle" bgcolor="#DDDDDD"><strong>Supplier</strong></td>
	<td align="left" valign="middle" bgcolor="#DDDDDD"><strong>Meal&nbsp;</strong></td>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Single</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Double</th>
	<?php if($roomQuad['status']==1){ ?>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Quad</th>
	<?php } ?>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Extra Bed(Adult)</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Extra Bed(Child)</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Child W/B</th>
	<?php if($roomSix['status']==1){ ?>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Six Bed Room</th>
	<?php } if($roomEight['status']==1){ ?>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Eight Bed Room</th>
	<?php } if($roomTen['status']==1){ ?>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Ten Bed Room</th>
	<?php } if($roomTeen['status']==1){ ?>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Teen Room</th>
	<?php } ?>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Breakfast(A)</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Lunch(A)</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Dinner(A)</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Breakfast(C)</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Lunch(C)</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD">Dinner(C)</th>

	<th align="center" valign="middle" bgcolor="#DDDDDD">TAC(%)</th>
	<th align="center" valign="middle" bgcolor="#DDDDDD"><strong>Action</strong></th> 
	</tr>
	<?php 
	$select1=''; 
	$wher1=''; 
	$rs1='';  
	$select1='*';
	 
	if($_REQUEST['marketType']!=""){
		$marketTypeQuery=' and marketType="'.$_REQUEST['marketType'].'"';
	}	

	if($_REQUEST['seasonType']!=""){
		$seasonTypeQuery=' and seasonType="'.$_REQUEST['seasonType'].'"';
	}

	if($_REQUEST['seasonYear']!=""){
		$seasonYearQuery=' and seasonYear="'.$_REQUEST['seasonYear'].'"';
	}
     
	$where1=' 1 and serviceid="'.$_REQUEST['serviceid'].'" '.$marketTypeQuery.' '.$seasonTypeQuery.' '.$seasonYearQuery.' order by id asc';
	$rs1=GetPageRecord($select1,_DMC_ROOM_TARIFF_MASTER_,$where1); 
	if( mysqli_num_rows($rs1) > 0){
	?>
	<tr> 
		<?php
		while($dmcroommastermain=mysqli_fetch_array($rs1)){  
		?>
		<tr>
		<td align="left"><?php if($dmcroommastermain['marketType']>0){ echo getMarketType($dmcroommastermain['marketType']); }else{ echo 'All'; } ?></td>
		<td align="left"><?php if($dmcroommastermain['seasonType']==1){ echo 'Summer'; } if($dmcroommastermain['seasonType']==2){ echo 'Winter'; } ?> </td>
		<td align="left"><?php echo $dmcroommastermain['seasonYear']; ?></td>
		<td align="left">
		<?php  
			$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' id="'.$dmcroommastermain['supplierId'].'"'); 
			$supplierData=mysqli_fetch_array($rs); 
			echo addslashes($supplierData['name']);	
		?></td>
		<td align="left"><?php echo getMealPlanName($dmcroommastermain['mealPlan']) ?></td>
		<td align="center"><?php 
		$select22='name';  
		$where22='id='.$dmcroommastermain['currencyId'].''; 
		$rs22=GetPageRecord($select22,_QUERY_CURRENCY_MASTER_,$where22); 
		$editresult22=mysqli_fetch_array($rs22); 
		$cur=clean($editresult22['name']);  
		?><?php echo $cur.' '.($dmcroommastermain['singleoccupancy']); ?>	</td>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['doubleoccupancy']); ?></td>
		<?php if($roomQuad['status']==1){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['quadRoom']); ?></td>
		<?php } ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['extraBed']); ?></td>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['childwithbed']); ?></td>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['childwithoutbed']); ?></td> 
		<?php if($roomSix['status']==1){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['sixBedRoom']); ?></td> 
		<?php } if($roomEight['status']==1){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['eightBedRoom']); ?></td> 
		<?php } if($roomTen['status']==1){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['tenBedRoom']); ?></td> 
		<?php } if($roomTeen['status']==1){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['teenRoom']); ?></td> 
		<?php } ?>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['breakfast']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['lunch']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['dinner']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['childBreakfast']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['childLunch']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['childDinner']); ?></td>
		<td align="center"><?php echo ($dmcroommastermain['roomTAC']); ?></td> 
		 <td align="center" valign="middle">  
		 <div onclick="fillusingreferencerate<?php echo $dmcroommastermain['id']; ?>();" style="color: #233ab2; font-weight: 600; cursor: pointer;">+ Select</div>
		 </td>
		 
		</tr>  
		<script>
		function fillusingreferencerate<?php echo $dmcroommastermain['id']; ?>(){
		alert("Filling rates in manual rate tab.");
		$('#singleoccupancy').val(<?php echo $dmcroommastermain['singleoccupancy']; ?>);
		$('#doubleoccupancy').val(<?php echo $dmcroommastermain['doubleoccupancy']; ?>);
		<?php if($roomQuad['status']==1){ ?>
		$('#quadRoom').val(<?php echo $dmcroommastermain['quadRoom']; ?>);
		<?php } ?>
		$('#extraBed').val(<?php echo $dmcroommastermain['extraBed']; ?>);
		$('#childwithbed').val(<?php echo $dmcroommastermain['childwithbed']; ?>);
		$('#childwithoutbed').val(<?php echo $dmcroommastermain['childwithoutbed']; ?>);
		<?php if($roomSix['status']==1){ ?>
		$('#sixBedRoom').val(<?php echo $dmcroommastermain['sixBedRoom']; ?>);
		<?php } if($roomEight['status']==1){ ?>
		$('#eightBedRoom').val(<?php echo $dmcroommastermain['eightBedRoom']; ?>);
		<?php } if($roomTen['status']==1){ ?>
		$('#tenBedRoom').val(<?php echo $dmcroommastermain['tenBedRoom']; ?>);
		<?php } if($roomTeen['status']==1){ ?>
		$('#teenRoom').val(<?php echo $dmcroommastermain['teenRoom']; ?>);
		<?php } ?>
		$('#breakfast').val(<?php echo $dmcroommastermain['breakfast']; ?>);
		$('#lunch').val(<?php echo $dmcroommastermain['lunch']; ?>);
		$('#dinner').val(<?php echo $dmcroommastermain['dinner']; ?>);
		$('#breakfastChild').val(<?php echo $dmcroommastermain['childBreakfast']; ?>);
		$('#lunchChild').val(<?php echo $dmcroommastermain['childLunch']; ?>);
		$('#dinnerChild').val(<?php echo $dmcroommastermain['childDinner']; ?>);
		$('#roomTAC').val(<?php echo $dmcroommastermain['roomTAC']; ?>);
		
		$('#remarks').val('<?php echo $dmcroommastermain['remarks']; ?>');
		
		$('#roomSupplierId').val(<?php echo $dmcroommastermain['supplierId']; ?>);
		$('#tarifType').val(<?php echo $dmcroommastermain['tarifType']; ?>);
		$('#roomType').val(<?php echo $dmcroommastermain['roomType']; ?>);
		
		$('#mealPlan').val(<?php echo $dmcroommastermain['mealPlan']; ?>);
		$('#roomGST').val(<?php echo $dmcroommastermain['roomGST']; ?>);
		$('#mealGST').val(<?php echo $dmcroommastermain['mealGST']; ?>);
		}
		</script> 
	<?php  } ?> 
</tr>
<?php } else{ ?>
<tr>
<td colspan="21" align="center">No Data Found.</td>
</tr>
<?php } ?>	
	
	
</table>
 
</div>