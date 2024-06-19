<?php
include "inc.php"; 
include "config/logincheck.php"; 

	if($_REQUEST['supplierId']!=''){

		$id=clean($_REQUEST['supplierId']);
		$select1='*';  
		$where1='id='.$id.''; 
		$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
		$editresult=mysqli_fetch_array($rs1); 
		$name=clean($editresult['name']);
		
	} 
	$hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$_REQUEST['serviceid'].'"'); 
	$hotelData = mysqli_fetch_array($hotelQuery);

?> 
<div class="topaboxlist"> 
<?php 
	$select2=''; 
	$where2=''; 
	$rs2='';  
	$select2='*';    
	// roomType='.$resListing['roomTypeId'].' and  supplierId="'.$_REQUEST['id'].'" and 
	$where2='serviceid="'.$_REQUEST['serviceid'].'" group by fromDate,toDate order by fromDate asc';  
	$rs2=GetPageRecord($select2,_DMC_ROOM_TARIFF_MASTER_,$where2); 
	while($PriceresListing=mysqli_fetch_array($rs2)){  
		$tariftype=$PriceresListing['tarifType'];
		
		$select1=''; 
		$wher1=''; 
		$rs1='';  
		$select1='*';    
		$where1=' fromDate="'.$PriceresListing['fromDate'].'" and toDate="'.$PriceresListing['toDate'].'"  and serviceid="'.$_REQUEST['serviceid'].'" order by id asc';  //and supplierId="'.$_REQUEST['id'].'" 
		$rs1=GetPageRecord($select1,_DMC_ROOM_TARIFF_MASTER_,$where1); 
		if( mysqli_num_rows($rs1) > 0){

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
	<div class="roompricelistmain" style="margin-top:0px;overflow: auto;">
 	 
		<div class="headermainprice">
			<span style="color: #909090;">Hotel Validity Date:</span> <?php echo showdate($PriceresListing['fromDate']); ?> - <?php echo showdate($PriceresListing['toDate']); ?><?php if($PriceresListing['seasonType']!= 3){ ?>&nbsp;|&nbsp;<span style="color: #909090;">Season Type:</span> <?php echo showdate($PriceresListing['sfromDate']); ?> - <?php echo showdate($PriceresListing['stoDate']); ?>(&nbsp;<?php if($PriceresListing['seasonType'] == 1 ){ echo "Summer";}else{ echo "Winter"; } ?>&nbsp;)<?php } ?>
		</div> 
	 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
	<thead>
	<tr>
		<th align="left" class="header" >SupplierBookingCode</th>
		<th align="left" class="header" >Season</th>
		<th align="left" class="header" >Validity</th>
		<th align="left" class="header" >PaxType</th>
	  	<th align="left" class="header" >Market Type</th>
		<th align="left" class="header" >Supplier</th>
		<th align="left" class="header" >Tarif Type </th>
		<th align="left" class="header" >Room Type </th>
		<th align="left" class="header" >Meal Plan</th>
		<th align="center" class="header">Single</th>
		<th align="center" class="header">Double</th>
		
		<th align="center" class="header">Extra&nbsp;Bed(Adult)</th>
		<!-- // singleroom, doubleroom, twinroom, tripleroom, quadroom, sixbedroom, eightbedroom, tenbedroom, teenbed, extrabedadult, extrabedchild, childnobed -->
		<?php if(isRoomActive('quadroom')==true){ ?>
		<th align="center" class="header">Quad&nbsp;Room</th>
		<?php } if(isRoomActive('sixbedroom')==true){ ?>
		<th align="center" class="header">Six&nbsp;Bed&nbsp;Room</th>
		<?php } if(isRoomActive('eightbedroom')==true){ ?>
		<th align="center" class="header">Eight&nbsp;Bed&nbsp;Room</th>
		<?php } if(isRoomActive('tenbedroom')==true){ ?>
		<th align="center" class="header">Ten&nbsp;Bed&nbsp;Room</th>
		<?php } if(isRoomActive('teenbed')==true){ ?>
		<th align="center" class="header">Teen&nbsp;Room</th>
		<?php } ?>
		<th align="center" class="header">Extra&nbsp;Bed(Child)</th>
		<th align="center" class="header">Child&nbsp;Without&nbsp;Bed</th>
		<th align="center" class="header">Room&nbsp;TAX&nbsp;Slab</th>
		<th align="center" class="header">Meal&nbsp;TAX&nbsp;Slab</th>
		<th align="center" class="header">TAC</th>
		<th align="center" class="header">Markup</th>
		<th align="center" class="header">Breakfast(A)</th>
		<th align="center" class="header">Lunch(A)</th>
		<th align="center" class="header">Dinner(A)</th>
		<th align="center" class="header">Breakfast(C)</th>
		<th align="center" class="header">Lunch(C)</th>
		<th align="center" class="header">Dinner(C)</th>
		<th align="center" class="header">Status</th>
		<th align="center" class="header">#</th>
	</tr>
	</thead>
	<tbody>
		<?php
		while($dmcroommastermain=mysqli_fetch_array($rs1)){  
		
			$seasonName='';
		if($dmcroommastermain['seasonType']=='1'){ 
			$seasonName = 'Summer'." - ".date('Y', strtotime($dmcroommastermain['fromDate']));
		}
		if($dmcroommastermain['seasonType']=='2'){
			$seasonName = 'Winter'." - ".date('Y', strtotime($dmcroommastermain['fromDate']));
		} 
		if($dmcroommastermain['seasonType']=='3'){
			$seasonName = 'All'." - ".date('Y', strtotime($dmcroommastermain['fromDate']));
		}
		$cur=getCurrencyName($dmcroommastermain['currencyId']);  
		?>
		<tr>
		<td align="left"><?php echo trim($dmcroommastermain['suppBookCode']);?></td> 

		<td align="left"><div style="width:100px;"><?php echo $seasonName;?></div></td>
		<td align="left"><div style="width:100px;"><?php echo showdate($dmcroommastermain['fromDate']); ?> TO <br /><?php echo showdate($dmcroommastermain['toDate']); ?></div></td>
		<td align="left"><?php if($dmcroommastermain['paxType']==1){ echo 'GIT'; }elseif($dmcroommastermain['paxType']==2){ echo 'FIT'; }else{ echo '--'; } ?></td> 
		<td align="left"><?php if($dmcroommastermain['marketType']>0){ echo getMarketType($dmcroommastermain['marketType']); }else{ echo '-'; } ?></td> 
		<td align="left">
		<?php  
			$rs=GetPageRecord('*',_SUPPLIERS_MASTER_,' id="'.$dmcroommastermain['supplierId'].'"'); 
			$supplierData=mysqli_fetch_array($rs); 
			echo addslashes($supplierData['name']);	
		?></td>
		<td align="left">
		<?php echo  getTariffType($dmcroommastermain['tarifType']); ?></td>
		<td align="left">
		<?php 
		$select13='*';  
		$where13='id='.$dmcroommastermain['roomType'].''; 
		$rs13=GetPageRecord($select13,_ROOM_TYPE_MASTER_,$where13); 
		$editresult=mysqli_fetch_array($rs13);
		echo $editresult['name'];
		?></td>
		<td align="left">
		<?php 
		$select21='name';  
		$where21='id="'.$dmcroommastermain['mealPlan'].'"'; 
		$rs21=GetPageRecord($select21,_MEAL_PLAN_MASTER_,$where21); 
		$editresult21=mysqli_fetch_array($rs21); 
		echo clean($editresult21['name']);  
		?>	</td>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['singleoccupancy']); ?>	</td>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['doubleoccupancy']); ?></td>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['extraBed']); ?></td>
		<?php if(isRoomActive('quadroom')==true){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['quadRoom']); ?></td>
		<?php } if(isRoomActive('sixbedroom')==true){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['sixBedRoom']); ?></td>
		<?php } if(isRoomActive('eightbedroom')==true){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['eightBedRoom']); ?></td>
		<?php } if(isRoomActive('tenbedroom')==true){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['tenBedRoom']); ?></td>
		<?php } if(isRoomActive('teenbed')==true){ ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['teenRoom']); ?></td>
		<?php } ?>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['childwithbed']); ?></td>
		<td align="center"><?php echo $cur.' '.($dmcroommastermain['childwithoutbed']); ?></td>
		<td align="center"><?php echo getGstSlabById($dmcroommastermain['roomGST']); ?></td>
		<td align="center"><?php echo getGstSlabById($dmcroommastermain['mealGST']); ?></td>
		<td align="center"><?php echo ($dmcroommastermain['TACType']==1)? 'FLAT&nbsp;'.$dmcroommastermain['roomTAC']:$dmcroommastermain['roomTAC'].'&nbsp;%';?></td>
		<td align="center"><?php echo ($dmcroommastermain['markupType']==1)? $dmcroommastermain['markupCost'].'%' : 'FLAT'.$dmcroommastermain['markupCost']; ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['breakfast']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['lunch']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['dinner']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['childBreakfast']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['childLunch']); ?></td>
		<td align="center"><?php echo  $cur.' '.($dmcroommastermain['childDinner']); ?></td>
		<td align="center"><?php if($dmcroommastermain['status']==1){echo 'Active'; } else { echo 'In Active'; }  ?></td>
		<td align="center"><a onClick="alertspopupopen('action=editdmcroomtariff&tarifId=<?php echo $dmcroommastermain['id']; ?>&suppid=<?php echo $dmcroommastermain['supplierId']; ?>','800px','auto');">Edit</a> </td> 
		</tr> 
		<tr>
			<td align="left" colspan="21">
				<?php 
				$selectha2 = '*';
				$whereha2 = '';
				$rs222 = '';
				 $whereha2='hotelId="'.$_REQUEST['serviceid'].'" and rateId = "'.$dmcroommastermain['id'].'" and isQuoteRate=0 ';  
				$rs222=GetPageRecord($selectha2,'dmcAdditionalHotelRate',$whereha2); 
				if(mysqli_num_rows($rs222)>0){
					?>
					<table width="40%" border="1" bordercolor="#ccc" cellpadding="6" cellspacing="0" style="margin-bottom: 10px; margin-top:10px; position:sticky; left:0px;">
						<thead >
						<tr>
							<th align="left" >Additional</th>
							<th align="left" >TAX Slab</th>
						  	<th align="left" >Type</th>
							<th align="left" >Cost</th>
						</tr>
						</thead>
						<?php while($AdditionalListing=mysqli_fetch_array($rs222)){ ?>
						<tbody>
							<tr class="tbdata">
								<td><?php 
									$additionalName = GetPageRecord('*','additionalHotelMaster', 'id="'.$AdditionalListing['additionalName'].'" and status=1 and deletestatus=0');
									$getadditionalName = mysqli_fetch_assoc($additionalName);
									echo $getadditionalName['name'];
									?>
									</td>
									<td><?php  echo getGstSlabById($AdditionalListing['gsttax']); ?></td>
									<td><?php  if($AdditionalListing['personWise']=='1'){ echo "Per Person Cost"; } 
										if($AdditionalListing['personWise']=='2'){ echo "Group Cost"; }
									
									?></td>
									<td><?php echo $AdditionalListing['additionalCost']; ?></td>
							</tr>
						</tbody>
						<?php } ?>
					</table>
					<?php
				}
				?>
			</td>
		</tr>
	<?php  } ?>
	</tbody>
	</table> 
	</div>
	<?php
	} 
} ?>
 
 
</div>
<?php //} ?>



<script>
<?php if($_REQUEST['fromDate']!=''){ ?>
openclose(1);
<?php } ?>
function loadHotelRoom(){
funloadhotelmaster();
}

function tarifTypeAction(tarifType){
	if(tarifType == 5 || tarifType == 6){
	$('.rateValidation').hide();
	$('.rateValidation input').removeClass('validate');
	
	$('.suplimentPriceBox').hide();
	$('.suplimentPriceBox input').removeClass('validate');
	
	}else if(tarifType == 4){
		$('.suplimentPriceBox').show();
		$('.suplimentPriceBox input').addClass('validate');
	}
	else{
		$('.suplimentPriceBox').hide();
		$('.suplimentPriceBox input').removeClass('validate');
		
		$('.rateValidation').show();
		$('.rateValidation input').addClass('validate');
	}
}
</script>