<?php
include "inc.php";  
if($_REQUEST['action'] == 'searchRoomSupplement' && trim($_REQUEST['hotelQuoteId'])!=''){
	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"'); 
	$hotelQuotData=mysqli_fetch_array($c);
	// hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
	$hotelData=mysqli_fetch_array($d);  

	$rs232='';
	$rs232=GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"'); 
	$hotelCatD=mysqli_fetch_array($rs232);

	$quores=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$hotelQuotData['quotationId'].'" ');  
	$quotationData=mysqli_fetch_array($quores);
 
	$singleRoom = $quotationData['sglRoom'];
	$doubleRoom = $quotationData['dblRoom'];
	$twinRoom   = $quotationData['twinRoom'];
	$tplRoom = $quotationData['tplRoom']; 
	$sixNoofBedRoom = $quotationData['sixNoofBedRoom'];
	$eightNoofBedRoom = $quotationData['eightNoofBedRoom'];
	$tenNoofBedRoom = $quotationData['tenNoofBedRoom'];
	$quadNoofRoom = $quotationData['quadNoofRoom'];
	$teenNoofRoom = $quotationData['teenNoofRoom'];
	
	$EBedCRoom = $quotationData['childwithNoofBed'];
	$childwithoutNoofBed = $quotationData['childwithoutNoofBed'];
	$EBedA = $quotationData['extraNoofBed'];


	$quotationId = trim($hotelQuotData['quotationId']);    
	$queryId = trim($hotelQuotData['queryId']); 

	$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$hotelQuotData['queryId'].'"'); 
	$queryData = mysqli_fetch_array($rs1);

 	$fit_gitQuery = ""; 
	if($queryData['paxType']==1 || $queryData['paxType']==2){
		$fit_gitQuery = " and paxType='".$queryData['paxType']."' ";
	}else{
		$fit_gitQuery = " and paxType=2 ";
	}
	// echo $fit_gitQuery;
	if($queryData['dayWise'] == 2){
		if($queryData['seasonType']!= 3 ){
			$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
		}else{
			$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and YEAR(fromDate) = '".$queryData['seasonYear']."'";
		}
	}else{
		$seasonQuery = " and DATE(fromDate)<='".$hotelQuotData['fromDate']."' and  DATE(toDate)>='".$hotelQuotData['toDate']."'";
	}	
 
	$marketId = getQueryMaketType($queryData['id']);
	$whereMarket = '';
	if($marketId>0){
		$whereMarket = ' and marketType="'.$marketId.'"';
	}
		 
	?> 
	<div id="viewinfo" style="position: absolute;z-index: 2147483647;border: 1px solid rgb(35 58 73);width: 100%;height: 100%;top: 0px;left: 0px;bottom: 0;background-color: rgb(13 15 20 / 78%);display:none;"><div id="loadhotelInfo" style="margin: auto; width: 94%; margin-top: 100px;"></div></div>

	<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
		<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
		<tr>
		  <td width="9%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Room&nbsp;Type </strong></td>
		  <td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Meal&nbsp;Type </strong></td>
		<td width="14%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Rate&nbsp;Validate</strong></td>
		<?php if($singleRoom>0){ ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Single</strong></td>
		<?php } ?>
		<?php if($doubleRoom>0 || $twinRoom>0 || $tplRoom>0){ ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Double</strong></td>
		<?php } ?>
		<?php if($EBedARoom>0 || $tplRoom>0){ ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Extra&nbsp;Bed</strong></td>
		<?php } ?>
		<?php if($EBedCRoom>0){ ?>
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>CWBed(C)</strong></td>	
		<?php } ?>
		<?php if($childwithoutNoofBed>0){ ?>
		<td width="5%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>CNBed(C)</strong></td>	
		<?php } ?>
		<?php if($teenNoofRoom>0){ ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Teen&nbsp;BR</strong></td>	
		<?php } ?>
		<?php if($quadNoofRoom>0){ ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Quad&nbsp;BR</strong></td>	
		<?php } ?>
		<?php if($sixNoofBedRoom>0){ ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Six&nbsp;BR</strong></td>	
		<?php } ?>
		<?php if($eightNoofBedRoom>0){ ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Eight&nbsp;BR</strong></td>	
		<?php } ?>
		<?php if($tenNoofBedRoom>0){ ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD" ><strong>Ten&nbsp;BR</strong></td>	
		<?php } ?>
		<td width="7%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Tariff&nbsp;Type</strong></td>
		<td width="10%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>Action</strong></td>
		<td width="14%" align="center" valign="middle" bgcolor="#DDDDDD"><strong>&nbsp;</strong></td>
		</tr>
		<?php  
		$n=1;
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';     
	    $where=' 1 and id = "'.$hotelQuotData['supplierId'].'" order by hotelName asc';  
		$rs=GetPageRecord($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where); 	 
		while($resListing=mysqli_fetch_array($rs)){  
	 		
			  $where1dmc = ' serviceid="'.$resListing['id'].'" and id!="'.$hotelQuotData['roomTariffId'].'" and id not in ( select tariffId from quotationHotelRateMaster where 1  and quotationId="'.$quotationId.'" ) and tarifType="'.$hotelQuotData['tariffType'].'" '.$seasonQuery.' '.$fit_gitQuery.' '.$whereMarket.' and id not in ( select roomTariffId from quotationRoomSupplimentMaster where 1  and quotationId="'.$quotationId.'" and supplierId = "'.$hotelQuotData['supplierId'].'" ) and status=1 and supplierId > 0 order by doubleoccupancy asc';  
			$rs1dmc=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$where1dmc); 
			if(mysqli_num_rows($rs1dmc) > 0){
				while($dmcroommastermain2=mysqli_fetch_array($rs1dmc)){  
					$supname='';   
					$doubleoccupancy=$singleoccupancy=$extraBedA=0;
					$tblNumber = 0;
	 			
					//get from dmc normal rate
					$rsa2s="";
					$rsa2s=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$dmcroommastermain2['id'].'"');  
					$dmcroommastermain=mysqli_fetch_array($rsa2s);
					 
					//check dmc haveing supplement cost
					$rssup1 = ""; 
					$rssup1=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'serviceid="'.$resListing['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.' '.$fit_gitQuery.'  '.$whereMarket.'   and status=1 and supplierId>0 and tarifType="4"'); 
					 
					if(mysqli_num_rows($rssup1) > 0 && mysqli_num_rows($rsa2s) > 0){
						$supplementCost=mysqli_fetch_array($rssup1);
						
						$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$extraBedA =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$teenRoomCost =  getCostWithGST($dmcroommastermain['teenRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['teenRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$quadRoomCost =  getCostWithGST($dmcroommastermain['quadRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['quadRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$sixBedRoomCost =  getCostWithGST($dmcroommastermain['sixBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['sixBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$eightBedRoomCost =  getCostWithGST($dmcroommastermain['eightBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['eightBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$tenBedRoomCost =  getCostWithGST($dmcroommastermain['tenBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['tenBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

						$childBreakfast =  getCostWithGST($dmcroommastermain['childBreakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['childBreakfast'],getGstValueById($supplementCost['mealGST']),0);

						$childLunch =  getCostWithGST($dmcroommastermain['childLunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['childLunch'],getGstValueById($supplementCost['mealGST']),0);

						$childDinner =  getCostWithGST($dmcroommastermain['childDinner'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['childDinner'],getGstValueById($supplementCost['mealGST']),0);

						$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0);
						$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0);
						$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0);
						
						 
						$supplementCostAdded = 1;
						$supplementId = $supplementCost['id'];
					} 
					
					//both table not giving any supplement cost 
					if(mysqli_num_rows($rssup1) == 0){
						$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$extraBedA =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$extraBedA =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

						$teenRoomCost =  getCostWithGST($dmcroommastermain['teenRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

						$quadRoomCost =  getCostWithGST($dmcroommastermain['quadRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

						$sixBedRoomCost =  getCostWithGST($dmcroommastermain['sixBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

						$eightBedRoomCost =  getCostWithGST($dmcroommastermain['eightBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

						$tenBedRoomCost =  getCostWithGST($dmcroommastermain['tenBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
						  
						$supplementCostAdded = 0;
						$supplementId = 0;
					}
					
					//final variable from selected table 
	 				$rs12ss=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id="'.$dmcroommastermain['mealPlan'].'"'); 
					$editresult2ss=mysqli_fetch_array($rs12ss); 
					 
					$rs12sss=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id="'.$dmcroommastermain['roomType'].'"'); 
					$editresult2sss=mysqli_fetch_array($rs12sss);
					
					$supname = getsupplierCompany($dmcroommastermain['supplierId']);
					
					// if we have a triple room and extra bed price 0 then it should make an alert
					$extraBedAlert = 0;
					$tblNumber = 1;
					if($queryData['tplRoom'] > 0 && $dmcroommastermain['extraBed'] < 1){ 
						$extraBedAlert = 1;		 
					} 
					  
					?> 
					<tr style="border-bottom:1px solid #ccc;<?php echo $extraBedAlert;?>">
					  <td align="center" valign="middle"><?php 
					$rs12sss=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id="'.$dmcroommastermain['roomType'].'"'); 
					$editresult2sss=mysqli_fetch_array($rs12sss);
					echo $editresult2sss['name']; 
					?></td>
					  <td align="center" valign="middle"><?php 
					$rs12ss=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id="'.$dmcroommastermain['mealPlan'].'"'); 
					$editresult2ss=mysqli_fetch_array($rs12ss);
					echo $editresult2ss['name']; 
					?></td>
				  	<td align="center" valign="middle"><?php  echo date('d-m-Y',strtotime($dmcroommastermain['fromDate'])).'&nbsp;/&nbsp;'.date('d-m-Y',strtotime($dmcroommastermain['toDate'])); ?></td>
				  	<?php if($singleRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$singleoccupancy; ?>  </td>
					<?php } if($doubleRoom>0 || $twinRoom>0 || $tplRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$doubleoccupancy; ?></td>
					<?php } if($EBedARoom>0 || $tplRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$extraBedA; ?></td>
					<?php } if($EBedCRoom>0 || $tplRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$childwithbed; ?></td>
					<?php } if($childwithoutNoofBed>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$childwithoutbed; ?></td>
					<?php } if($teenNoofRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$teenRoomCost; ?></td>
					<?php } if($quadNoofRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$quadRoomCost; ?></td>
					<?php } if($sixNoofBedRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$sixBedRoomCost; ?></td>
					<?php } if($eightNoofBedRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$eightBedRoomCost; ?></td>
					<?php } if($tenNoofBedRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$tenBedRoomCost; ?></td>
					<?php } ?>
					<?php //} ?>
					<td align="center" valign="middle"><?php echo getTariffType($dmcroommastermain['tarifType']);?> <?php if($supplementCostAdded == 1) { ?> <span class="fa fa-info-circle" title="Supplement Cost Applied." style=" color: red; margin-left: 10px; "></span><?php } ?></td> 
					<td align="center" valign="middle"> 
					<?php   
					$rs21=GetPageRecord('*','hoteloperationRestriction','hotelId="'.$dmcroommastermain['serviceid'].'" and DATE(startDate)<="'.$hotelQuotData['fromDate'].'" and DATE(startDate)>="'.$hotelQuotData['fromDate'].'"'); 
					 
					$msgOpr = '';
					if(mysqli_num_rows($rs21) > 0){ 
					$oprResData=mysqli_fetch_array($rs21);
					$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));
					?> 
					<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="if(confirm('<?php echo strip($resListing['hotelName']); ?> - Operation restriction! \nReason:&nbsp;<?php echo strip($oprResData['reason']); ?> \nPeriod:<?php echo strip($period); ?>')) <?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php } else{ ?>addSupplementRoom('<?php echo $quotationId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>');<?php } ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
					
					<?php } else { ?> 
					
					<div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="<?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php } else{ ?>addSupplementRoom('<?php echo $quotationId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>');<?php } ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>
				 
					<?php  } ?>				
				</td>
				<td align="center" valign="middle"> 
					<?php if($extraBedAlert == 1){ ?>
					<div class="editbtnselect" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#589fa6;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Edit_Price</div>
					<?php } else{ ?>
					<div class="editbtnselect" onclick="getinfo('<?php echo $dmcroommastermain['id']; ?>');"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Break-up&nbsp;Cost</div>
					<?php } ?>
				</td>
		  		</tr>  
		  		<?php 
					$n++; 
				} 
			}
			  
			// check for normal from temp. rates table
			$tblNumber=2;
			$dmcroommastermain ='';
	 		$rsa2s="";
	  		$rsa2s=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'" and id!="'.$hotelQuotData['roomTariffId'].'" and tarifType="'.$hotelQuotData['tariffType'].'" '.$seasonQuery.' '.$fit_gitQuery.' '.$whereMarket.'  and id not in ( select roomTariffId from quotationRoomSupplimentMaster where 1  and quotationId="'.$quotationId.'" and supplierId = "'.$hotelQuotData['supplierId'].'" )  and quotationId="'.$quotationId.'" and status=1 and supplierId>0 order by id desc');  
			if(mysqli_num_rows($rsa2s)>0){ 
	 			$singleoccupancy=$doubleoccupancy=$extraBedA=0;
				$dmcroommastermain = mysqli_fetch_array($rsa2s); 
			
				 
				// supplement cost check and calculated
				$rssup2 = ""; 
				$rssup2=GetPageRecord('*','quotationHotelRateMaster','serviceid="'.$resListing['id'].'"  '.$seasonQuery.' '.$fit_gitQuery.'  '.$whereMarket.'  and quotationId="'.$quotationId.'" and status=1 and supplierId>0 and tarifType="4" and tarifType in (select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName))'); 
				
				if(mysqli_num_rows($rssup2) > 0 && mysqli_num_rows($rsa2s) > 0){
					$supplementCost=mysqli_fetch_array($rssup2);
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);
					$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

					$extraBedA =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

					$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

					$teenRoomCost =  getCostWithGST($dmcroommastermain['teenRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['teenRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

					$quadRoomCost =  getCostWithGST($dmcroommastermain['quadRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['quadRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

					$sixBedRoomCost =  getCostWithGST($dmcroommastermain['sixBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['sixBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

					$eightBedRoomCost =  getCostWithGST($dmcroommastermain['eightBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['eightBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

					$tenBedRoomCost =  getCostWithGST($dmcroommastermain['tenBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']) + getCostWithGST($supplementCost['tenBedRoom'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC']);

					$childBreakfast =  getCostWithGST($dmcroommastermain['childBreakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['childBreakfast'],getGstValueById($supplementCost['mealGST']),0);

					$childLunch =  getCostWithGST($dmcroommastermain['childLunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['childLunch'],getGstValueById($supplementCost['mealGST']),0);

					$childDinner =  getCostWithGST($dmcroommastermain['childDinner'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['childDinner'],getGstValueById($supplementCost['mealGST']),0);

					$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0);
					$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0);
					$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0);
					 
					$supplementCostAdded = 1;
					$supplementId = $supplementCost['id'];
				} 
				
				// table not giving any supplement cost 
				if(mysqli_num_rows($rssup2) == 0){
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					$extraBedA =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

					$teenRoomCost =  getCostWithGST($dmcroommastermain['teenRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

					$quadRoomCost =  getCostWithGST($dmcroommastermain['quadRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

					$sixBedRoomCost =  getCostWithGST($dmcroommastermain['sixBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

					$eightBedRoomCost =  getCostWithGST($dmcroommastermain['eightBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);

					$tenBedRoomCost =  getCostWithGST($dmcroommastermain['tenBedRoom'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC']);
					
					$supplementCostAdded = 0;
					$supplementId = 0;
				}
				
	 			$rs12ss=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id="'.$dmcroommastermain['mealPlan'].'"'); 
				$editresult2sss=mysqli_fetch_array($rs12ss); 
				 
				$rs12sss=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id="'.$dmcroommastermain['roomType'].'"'); 
				$editresult2ss=mysqli_fetch_array($rs12sss);
				
				$supname = getsupplierCompany($dmcroommastermain['supplierId']);
				
				// if we have a triple room and extra bed price 0 then it should make an alert
				$extraBedAlert = 0;
				if($queryData['tplRoom'] > 0 && $dmcroommastermain['extraBed'] < 1){ 
					$extraBedAlert = 1;		 
				} 
				
				?> 
				<tr style="border-bottom:1px solid #ccc;"> 
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo $editresult2ss['name']; } ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo $editresult2sss['name']; }  ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){  echo date('d-m-Y',strtotime($dmcroommastermain['fromDate'])).'&nbsp;/&nbsp;'.date('d-m-Y',strtotime($dmcroommastermain['toDate'])); } ?></td>					
					<?php if($singleRoom>0){ ?>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$singleoccupancy; } ?></td>
					<?php } if($doubleRoom>0 || $twinRoom>0 || $tplRoom>0){ ?>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$doubleoccupancy; } ?></td>
					<?php } if($EBedARoom>0 || $tplRoom>0){ ?>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$extraBedA; } ?></td>
					<?php } if($EBedCRoom>0){ ?>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$childwithbed; } ?></td>
					<?php } if($childwithoutNoofBed>0){ ?>
					<td align="center" valign="middle"><?php if(mysqli_num_rows($rsa2s)>0){ echo getCurrencyName($dmcroommastermain['currencyId']).' '.$childwithoutbed; } ?></td>
					<?php } if($teenNoofRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$teenRoomCost; ?></td>
					<?php } if($quadNoofRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$quadRoomCost; ?></td>
					<?php } if($sixNoofBedRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$sixBedRoomCost; ?></td>
					<?php } if($eightNoofBedRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$eightBedRoomCost; ?></td>
					<?php } if($tenNoofBedRoom>0){ ?>
					<td align="center" valign="middle"><?php echo getCurrencyName($dmcroommastermain['currencyId']).' '.$tenBedRoomCost; ?></td>
					<?php } ?>

					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ echo getTariffType($dmcroommastermain['tarifType']); if($supplementCostAdded == 1) { ?> <span class="fa fa-info-circle" title="Supplement Cost Applied." style=" color: red; margin-left: 10px; "></span><?php } } ?></td> 

					<td align="center" valign="middle" bgcolor="#F7FCFD"><?php if(mysqli_num_rows($rsa2s)>0){ ?> <div style="width: fit-content !important; padding: 8px !important;" class="editbtnselect" onclick="<?php if($extraBedAlert == 1){ ?>alert('Extra bed cost cannot be zero.'); <?php } else{ ?>addSupplementRoom('<?php echo $quotationId; ?>','<?php echo $dmcroommastermain['id']; ?>','<?php echo $tblNumber; ?>','<?php echo $supplementId; ?>'); <?php } ?>" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div><?php } ?></td>
					<td align="center" valign="middle" bgcolor="#F7FCFD"> 
				  <div class="editbtnselect" onclick="addnewRates('<?php echo $resListing['id']; ?>','<?php echo $dmcroommastermain['id']; ?>');" style=" padding: 8px 23px !important; background-color:#589fa6;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;<?php if(mysqli_num_rows($rsa2s)>0){ ?>Edit<?php }else{ ?>Add<?php } ?>&nbsp;Price</div>				</td>
				</tr>  
				<?php 
				$n++; 
			}				
		} 
		?>
		</table> 
		<script>  
		function getinfo(tariffId){
			$('#viewinfo').show();
			$('#loadhotelInfo').load('loadhotelInfo.php?quotationId=<?php echo $quotationId;?>&hotelQuoteId=<?php echo $hotelQuotData['id'];?>&tariffId='+tariffId);
		} 
		function addnewRates(serviceid,tariffId){
			$('#viewinfo').show(); 
			$('#loadhotelInfo').load('loadhotelNewRates.php?serviceid='+serviceid+'&tariffId='+tariffId+'&isRoomSupp=1&hotelQuoteId=<?php echo $hotelQuotData['id'];?>&quotationId=<?php echo $quotationId;?>');
		}  
		</script>
	</div> 
	<?php if(mysqli_num_rows($rs1dmc) < 1 && mysqli_num_rows($rsa2s)<1){ ?>
	<div style="text-align:center; font-size:13px;  color:#FF0000; padding:12px;position:relative;"><span>No Supplement Tariff Found</span> </div>
	<?php } ?>
	<style > 

		.editbtnselect, .addBtn{    
			border: 1px solid;
			padding: 8px 15px;
			text-align: center;
			font-size: 13px;
			border-radius: 3px;
			background-color: #4caf50;
			cursor: pointer;
			color: #fff;
		}
		.addBtn{
			width: fit-content !important;
			position: absolute;
			right: 30px;
			top: 2px;
			padding: 8px 12px !important;
			background-color: #7a96ff;
		}
	</style>
	<?php 
} ?>