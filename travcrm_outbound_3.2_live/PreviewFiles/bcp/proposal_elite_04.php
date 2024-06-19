<?php 
include "inc.php";  
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['id']).'"');  
$resultpageQuotation=mysqli_fetch_array($rsp);  

$select='*';  
$where='id='.$resultpageQuotation['queryId'].'';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs);  

$totalPax = $resultpageQuotation['adult']+$resultpageQuotation['child'];
$queryId = $resultpageQuotation['queryId'];
$quotationId= $resultpageQuotation['id'];

if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
	$inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
}
if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
	$exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));  
}


if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
	$tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));  
}
if($resultpageQuotation['overviewText']!='' || $resultpageQuotation['overviewText']!='undefined'){
	$overviewText=preg_replace('/\\\\/', '',clean($resultpageQuotation['overviewText'])); 
}
if($resultpageQuotation['highlightsText']!='' || $resultpageQuotation['highlightsText']!='undefined'){
	$highlightsText=preg_replace('/\\\\/', '',clean($resultpageQuotation['highlightsText']));
}
if($resultpageQuotation['specialText']!='' || $resultpageQuotation['specialText']!='undefined'){
	$specialText=preg_replace('/\\\\/', '',clean($resultpageQuotation['specialText']));
}
if($resultpageQuotation['quotationSubject']!=''){
	$quotationSubject = preg_replace('/\\\\/', '',clean($resultpageQuotation['quotationSubject']));
}else{
	$quotationSubject = strtoupper(strip($resultpage['subject']));
}
?>  
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $quotationSubject; ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;0,900;1,600;1,700;1,900&display=swap" rel="stylesheet">
	<style type="text/css">
		body{
			margin: 0;
			font-size: 14px;
			color: #3c3a3a;
			font-weight: 400;
			font-family: 'Source Sans Pro', sans-serif;
		}
		.main-container{
			margin: auto;
			width: 800px;
		}
		.docTitle{
			background-color: #133f6d;
			padding: 5px 20px;
			color: #fff;
			font-weight: bold;
			font-size: 20px;
			position: relative;
			display: inline-block;
			height: 35px;
			line-height: 30px;
		}
		.proposalHeader{
			padding: 5px 0;
			background-color: #ecf0f4;
		}
		.travellerInfo{
			font-size: 12px;
			font-weight: 500;
			background-color: #ecf0f4;
		}
		.bannerText{
			font-size: 16px;
			font-weight: 500;
		}
		.colorSize1{
			color: #133f6d;
		}
		.serviceDesc {
			text-align: justify;
			page-break-inside: auto;
			font-size: 14px;
			padding-bottom: 5px;
			line-height: 18px;
		}
		.incl{
			font-size: 12px;
		}
		.overviewBox {
			padding: 60px;
			padding-bottom: 10px;
			display: block;
			page-break-after: always;
		}
		.overviewBox .serviceDesc {
			padding-bottom: 10px;
			font-size: 16px;
			color: #424244;
			font-weight: 400;
			font-family: 'Source Sans Pro', sans-serif; 
		}
		.PGBRBF{
			page-break-before: always;
		}
		.PGBRAF{
			page-break-after: always;
		}
		.PGBRINAV{
			page-break-inside: avoid;
		}
		.table-service{
			page-break-inside: avoid;
		}
		.serviceTitle {
			font-size: 18px;
			line-height: 20px;
			color: #133f6d;
			font-weight: 700;
		}
		.dayItineraryInfo {
			font-size: 14px;
			color: #424244;
			font-weight: 400;
			font-family: 'Source Sans Pro', sans-serif;
		}
		.dayTitle{
			background-color: #133f6d;
			color: #fff;
			font-weight: bold;
			font-size: 20px;
			position: relative;
			display: inline-block;
			line-height: 30px;
		}
		.w60{
			width: 60%;
		}
		.imgbox {
			width: 200px;
			height: 130px;
			border-radius: 10px;
			overflow: hidden;
			border: 1px solid #bebaba;
			box-shadow: 3px 3px 7px 0px rgb(185 185 185);
		}
		.borderedTable{
			font-size: 12px;
			font-weight: normal;
		}
	</style>
</head>
<body >
	<div class="calcostsheet"  style="display:none;">
	<?php include("loadFITCostSheet.php"); ?>
	</div>
	<div class="main-container" style="width: 800px;">
	<table class="firstpage proposalHeader" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="middle">
				<br /><div class="docTitle">&nbsp;&nbsp;&nbsp;Itinerary or Proposal
					
				</div>
			</td>
			<td align="right" valign="middle"><br /><br /><img src="<?php echo $fullurl; ?>images/logo_debox_tagline-w.png" width="60px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
	<table width="100%" border="0" class="travellerInfo" cellpadding="0" cellspacing="0" >
		<tr><td align="center" ><?php 
			if($resultpageQuotation['image']!=''){
				$proposalImg = 'dirfiles/'.$resultpageQuotation['image'];
				if(file_exists($proposalImg)==true){
					$proposalPhoto = $fullurl.$proposalImg;
				}else{
					$proposalPhoto = $fullurl.'images/sample-proposal.jpg';
				}
			}else{
				$proposalPhoto = $fullurl.'images/sample-proposal.jpg';
			}
			?><img src="<?php echo $proposalPhoto; ?>" width="800" height="300"></td>
		</tr>
	</table>
	<table width="100%" class="travellerInfo"  border="0" cellpadding="10" cellspacing="0" >
		<tr>
			<td colspan="4" align="center"><div class="bannerText colorSize1">GOLDEN TRIANGLE<?php //echo strip($quotationSubject); ?></div></td>
		</tr>
		<tr>
		<td width="5%"></td>
		<td width="40%">DESTINATION COVERED<br><strong><?php 
			$locationQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
				while($locationCoverD=mysqli_fetch_array($locationQuery)){
				$locationCovered.= stripslashes(getDestination($locationCoverD['cityId'])).', ';
			}
			echo rtrim($locationCovered,', ');
			?></strong>
		</td>
		<td width="30%">DURATION<br>
			<strong><?php 
				echo $resultpageQuotation['night'].' Nights / '.($resultpageQuotation['night']+1).' Days'; 
			?></strong>
		</td>
		<td width="25%">TRAVELLERS<br>
			<strong><?php echo ($resultpageQuotation['adult']+$resultpageQuotation['child']); ?> Adults</strong>
		</td>
		</tr> 
		<tr>
			<td colspan="4" align="center"><table width="100%" border="0" cellpadding="10" cellspacing="0" class="colorSize3" >
				<tr>
					<td align="center" colspan="4" valign="middle" ><?php  
						$rootMapQuery=GetPageRecord('cityId','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
						$numRoots = mysqli_num_rows($rootMapQuery); 
						$cnt = 1; 
						$cityId = 0;
						while($rootMapData=mysqli_fetch_array($rootMapQuery)){ 
							if($rootMapData['cityId'] != $cityId ){
								?><strong><?php echo getDestination($rootMapData['cityId']); ?></strong>
					          <?php if($numRoots > $cnt){ ?>
					          <img src="<?php echo $fullurl; ?>images/location-pin.png" height="30" width="30" />
					          <?php } 
								$cityId = $rootMapData['cityId'];
								$cnt++;
							}
						}
					?></td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	<br />
	<?php if(strlen($overviewText)){ ?>
	<table width="100%" border="0" cellpadding="5" cellspacing="0" class="overviewBox colorSize3" >
		<tr>
			<td align="left" valign="middle" width="8%" ></td>
			<td align="justify" valign="middle" width="84%" >
				<strong class="serviceTitle">TOUR Overview</strong>
				<div class="serviceDesc"><?php  
					echo strip_tags(substr($overviewText, 0 ,840)); 
	 			?></div>
	 		</td>
		</tr>
	</table> 
	<?php } ?>
    <?php  
	// DAY LOOP START
	$day=1;
	$queryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($queryDaysData=mysqli_fetch_array($queryDaysQuery)){  
		$dayDate = date('Y-m-d',strtotime($queryDaysData['srdate']));
		$dayId = $queryDaysData['id']; 
		?>  
		<div class="dayTitle w60 ">&nbsp;&nbsp;&nbsp;&nbsp;Day <?php echo $day; ?> - <?php echo getDestination($queryDaysData['cityId']); $destn = getDestination($queryDaysData['cityId']); ?><?php if($resultpage['dayWise'] == 1){ ?> | <?php echo date('l d-m-Y', strtotime($dayDate)); } 	?>
		</div>
		<table width="100%" border="0" cellpadding="20" cellspacing="0" class="dayItineraryInfo " ><tr><td>
		<?php 
		if(strlen(trim($queryDaysData['title']))>1 && strlen(trim($queryDaysData['description']))>1){ ?>
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class=" colorSize3" >
			<?php 
			if($queryDaysData['title']!=''){ ?>
			<tr>
				<td>
					<div class="itineraryTitle"><?php
					echo strip(urldecode($queryDaysData['title']));
					?></div>
				</td>
			</tr>
			<?php
			}
			if($queryDaysData['description']!=''){ 
			?>
			<tr>
				<td>
				<div class="itineraryDesc"><?php
					$html = urldecode(strip($queryDaysData['description']));
					$html = str_replace('<p>&nbsp;</p>', '<br />', $html);
					$html = str_replace('<p>', '<div>', $html);
					echo $html = str_replace('</p>', '</div>', $html);
					?>
					</div> 
				</td>
			</tr>
			<?php
			}
			?>
		</table>
		<br />
		<?php
		}
		?>
		<br />
		<?php
			$itiQuery=' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){
				if($itineryDayData['serviceType'] == 'hotel' ){
					$where1='quotationId="'.$queryDaysData['quotationId'].'" and supplementHotelStatus!=1 and id="'.$itineryDayData['serviceId'].'"';   
					$rs1=GetPageRecord('*','quotationHotelMaster',$where1);  
					if(mysqli_num_rows($rs1) > 0){
						$hotellisting=mysqli_fetch_array($rs1); 
						$hotelTypeLable ='';
						if($hotellisting['isLocalEscort']==1){
					        $hotelTypeLable .= "Local Escort,";
					   }elseif($hotellisting['isForeignEscort']==1){
					        $hotelTypeLable .= "Foreign Escort,";
					   }else{
					        $hotelTypeLable .= "Guest,";
					   } 
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
						$hoteldetail=mysqli_fetch_array($rs1ee);   
					?>
					<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service hotel">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle"><?php 
				            $rs2='';
				            $rs2=GetPageRecord('*','imageGallery',' parentId = "'.$hoteldetail['id'].'" and galleryType="hotel" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
				            $resListing2=mysqli_fetch_array($rs2);
			            	if($resListing2['fileId']!=''){ 
				            	$hotelImage = geDocFileSrc($resListing2['fileId']);
				            	if(file_exists($hotelImage)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$hotelImage).'" width="200" height="130">';
				            	}else{
				            		echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            	}
				            }else{
				              echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            }
						?></td>
						<td width="70%" align="left" valign="middle" >
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<tbody>
									<tr>
										<td colspan="3"><strong class="serviceTitle"><?php  echo rtrim($hotelTypeLable,',')." Hotel | "; echo strip($hoteldetail['hotelName']);  ?></strong></td>
									</tr>
									<tr> 
										<td width="30%" ><strong class="subHeading">Category</strong></td> 
										<td width="40%" ><strong class="subHeading">Room Type</strong></td> 
										<td width="30%" ><strong class="subHeading">Meal Plan</strong></td> 
									</tr> 
									<tr> 
										<td  valign="bottom" ><?php 
										 	$rs231er=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail['hotelCategoryId'].'"');  
										 	$hotelCatNam=mysqli_fetch_array($rs231er);  
										 	echo '<img src="'.$fullurl.'images/starh'.$hotelCatNam['hotelCategory'].'.png" height="15">';
										 	?>
										</td>
										<td ><?php 
											$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting['roomType'].'"');  
											$roomtype=mysqli_fetch_array($rs23qwe);  
											echo $roomtype['name'];   
											?></td> 
									 	<td ><?php
										$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$hotellisting['mealPlan'].'"'); 
										$mealplan=mysqli_fetch_array($rssda24); 
										echo $mealplan['name'];
										//.'-'.$mealplan['subname']
										?></td>  
							  		</tr>
								</tbody>
							</table>
						</td>
						</tr>
						</tbody>
					</table>
					<!-- service seprator img -->
					<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php 	echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
					<?php 
					}
				}
			}

			// SERVICE LOOP START
			$itiQuery=' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){

				if($itineryDayData['serviceType'] == 'hotel' ){
					$where1='quotationId="'.$queryDaysData['quotationId'].'" and supplementHotelStatus!=1 and id="'.$itineryDayData['serviceId'].'"';   
					$rs1=GetPageRecord('*','quotationHotelMaster',$where1);  
					if(mysqli_num_rows($rs1) > 0){
						$hotellisting=mysqli_fetch_array($rs1); 
						$hotelTypeLable ='';
						if($hotellisting['isLocalEscort']==1){
					        $hotelTypeLable .= "Local Escort,";
					   }elseif($hotellisting['isForeignEscort']==1){
					        $hotelTypeLable .= "Foreign Escort,";
					   }else{
					        $hotelTypeLable .= "Guest,";
					   } 
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
						$hoteldetail=mysqli_fetch_array($rs1ee);   
					?>
					<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service hotel">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle"><?php 
				            $rs2='';
				            $rs2=GetPageRecord('*','imageGallery',' parentId = "'.$hoteldetail['id'].'" and galleryType="hotel" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
				            $resListing2=mysqli_fetch_array($rs2);
			            	if($resListing2['fileId']!=''){ 
				            	$hotelImage = geDocFileSrc($resListing2['fileId']);
				            	if(file_exists($hotelImage)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$hotelImage).'" width="200" height="130">';
				            	}else{
				            		echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            	}
				            }else{
				              echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            }
						?></td>
						<td width="70%" align="left" valign="middle" >
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<tbody>
									<tr>
										<td colspan="3"><strong class="serviceTitle"><?php  echo rtrim($hotelTypeLable,',')." Hotel | "; echo strip($hoteldetail['hotelName']);  ?></strong></td>
									</tr>
									<tr> 
										<td width="30%" ><strong class="subHeading">Category</strong></td> 
										<td width="40%" ><strong class="subHeading">Room Type</strong></td> 
										<td width="30%" ><strong class="subHeading">Meal Plan</strong></td> 
									</tr> 
									<tr> 
										<td  valign="bottom" ><?php 
										 	$rs231er=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail['hotelCategoryId'].'"');  
										 	$hotelCatNam=mysqli_fetch_array($rs231er);  
										 	echo '<img src="'.$fullurl.'images/starh'.$hotelCatNam['hotelCategory'].'.png" height="15">';
										 	?>
										</td>
										<td ><?php 
											$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting['roomType'].'"');  
											$roomtype=mysqli_fetch_array($rs23qwe);  
											echo $roomtype['name'];   
											?></td> 
									 	<td ><?php
										$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$hotellisting['mealPlan'].'"'); 
										$mealplan=mysqli_fetch_array($rssda24); 
										echo $mealplan['name'];
										//.'-'.$mealplan['subname']
										?></td>  
							  		</tr>
								</tbody>
							</table>
						</td>
						</tr>
						</tbody>
					</table>
					<!-- service seprator img -->
					<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php 	echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
					<?php 
					}
				}

				if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
					$rs12=GetPageRecord('*','quotationTransferMaster','quotationId="'.$queryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'" ');   
					if(mysqli_num_rows($rs12) > 0){
						$transferlisting=mysqli_fetch_array($rs12); 
						$rs123=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
						$transfergdetail=mysqli_fetch_array($rs123);

						$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');  
						$vename=mysqli_fetch_array($rs1aa);
						?>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service transfer">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><?php   
								$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');
								$vename=mysqli_fetch_array($rs1aa); 
								?><img src="<?php echo $fullurl; ?>images/transfer.jpeg" width="200" height="130" />
							</td>
							<td width="70%" align="left" valign="middle" >
							   <table width="100%" border="0" cellpadding="5" cellspacing="0" >
								 	<tr><td colspan="3" align="left" ><strong class="serviceTitle"><?php echo ucfirst(trim($transfergdetail['transferName'])); ?></strong>
								 		</td>
							     	</tr> 
								  	<tr>
									 	<td align="left" width="25%" ><strong class="subHeading">Type</strong></td>
									 	<td align="left" width="30%" ><strong class="subHeading">VehicleName</strong></td>
									 	<td align="left" width="30%" ><strong class="subHeading">VehicleType</strong></td> 
								  	</tr>
								  	<tr>
									 	<td align="left">Private</td>
									 	<td align="left" ><?php echo  $vename['model']; ?> </td>
									 	<td align="left"><?php  echo getVehicleTypeName($vename['carType']);?></td> 
								  	</tr> 
							   </table>								   
							</td>
							</tr>
							<?php 
						  	$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferlisting['id'].'" and quotationId="'.$transferlisting['quotationId'].'"');
							$transferTimelineData=mysqli_fetch_array($c1);
							if(mysqli_num_rows($c1)>0){
							?>
							<tr class="row-service">
								<td colspan="2" align="left" valign="top" width="100%">
									<table cellpadding="4" border="1" cellspacing="0"  class="borderedTable">
							 	  	<tr>
							 	  	 	<th valign="middle" bgcolor="#133f6d"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight Name';}if($transferTimelineData['mode']=='train'){ echo 'Train Name';} ?></th> 
							 	  	 	<th valign="center" bgcolor="#133f6d"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight No';}if($transferTimelineData['mode']=='train'){ echo 'Train No';} ?></th>
								 	  	<?php if($transferTimelineData['mode']=='flight'){?>
								 	  	<th valign="center" bgcolor="#133f6d">Airport Name</th>
								 	     <?php } ?>
								 	    <th valign="center" bgcolor="#133f6d">Arrival From</th> 
								 	  	<th valign="center" bgcolor="#133f6d">Arrival Time</th>
								 	  	<th valign="center" bgcolor="#133f6d">PickUp Time</th>
								 	  	<th valign="center" bgcolor="#133f6d">Drop Time</th>
								 	</tr>
								 	<tr>
							 	  	 	<td><?php if($transferTimelineData['mode']=='flight'){ echo $transferTimelineData['flightName']; }if($transferTimelineData['mode']=='train'){ echo $transferTimelineData['trainName']; } ?></td>
							 	  	 	<td><?php if($transferTimelineData['mode']=='flight'){ echo $transferTimelineData['flightNumber']; }if($transferTimelineData['mode']=='train'){ echo $transferTimelineData['trainNumber']; } ?></td>
		            					<?php if($transferTimelineData['mode']=='flight'){ ?>
								 	  	<td><?php echo $transferTimelineData['airportName']; ?></td>
		          						<?php } ?> 
		           						<td><?php echo $transferTimelineData['arrivalFrom']; ?></td>
								 	  	<td><?php if(date('Hi',strtotime($transferTimelineData['arrivalTime'])) <> '0530' ){ echo date('Hi',strtotime($transferTimelineData['arrivalTime']))." Hrs"; } ?></td>
									 	<td><?php if(date('Hi',strtotime($transferTimelineData['dropTime'])) <> '0530' ){ echo date('Hi',strtotime($transferTimelineData['dropTime']))." Hrs"; }  ?></td> 
								 	  	<td><?php if(date('Hi',strtotime($transferTimelineData['pickupTime'])) <> '0530' ){ echo date('Hi',strtotime($transferTimelineData['pickupTime']))." Hrs"; } ?></td>
								 	</tr>
								 	<?php if($transferTimelineData['pickupAddress']!=''){?>
								 	<tr>
								 	  	<td colspan="6"><strong>PickUp Address:</strong><br><?php echo $transferTimelineData['pickupAddress']; ?></td>
								 	</tr>
								 	<?php } 
								 	if($transferTimelineData['dropAddress']!=''){ ?>
								 	  <tr>
								 	  	<td colspan="6"><strong>Drop Address:</strong><br><?php echo $transferTimelineData['dropAddress']; ?></td>
								 	  </tr>
								 	<?php } ?>
								 	</table>
								</td>
							</tr>
							<?php } ?>
							<?php 
							if(strlen($transfergdetail['transferDetail']) > 0){  ?>
						 	<tr>
						 		<td colspan="2" align="left"><?php echo clean($transfergdetail['transferDetail']); ?></td>
						 	</tr>
						 	<?php } ?>
							</tbody>
						</table>
						<!-- service seprator img -->
						<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php 	echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
						<?php 

					}
				}

				if($itineryDayData['serviceType'] == 'enroute'){   
					$where2='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$rs2=GetPageRecord('*','quotationEnrouteMaster',$where2);  
					if(mysqli_num_rows($rs2) > 0){
					 	$enroutelisting=mysqli_fetch_array($rs2);
						$rs1=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id='.$enroutelisting['enrouteId'].'');  
						$enrouteData=mysqli_fetch_array($rs1);    
						// code here
						?> 
						<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><?php 
				            $rs3='';
				            $rs3=GetPageRecord('*','imageGallery',' parentId = "'.$enrouteData['id'].'" and galleryType="enroute" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
				            $resListing3=mysqli_fetch_array($rs3);
			            	if($resListing3['fileId']!=''){ 
				            	$enrouteImage = geDocFileSrc($resListing3['fileId']);
				            	if(file_exists($enrouteImage)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ','%20',$enrouteImage).'" width="200" height="130">';
				            	}else{
				            		echo '<img src="'.$fullurl.'images/activity.jpeg" width="200" height="130">'; 
				            	}
				            }else{ 
				              echo '<img src="'.$fullurl.'images/activity.jpeg" width="200" height="130">'; 
				            } 
				          	?></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr>
											<td ><strong class="serviceTitle"><?php echo ucfirst($enrouteData['enrouteCity']);  ?> | <?php echo ucfirst(strip($enrouteData['enrouteName']));  ?></strong></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc"><?php echo strip_tags($enrouteData['enrouteDetail']); ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<!-- service seprator img -->
						<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php 	echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
						<?php 
					}
				}

				if($itineryDayData['serviceType'] == 'entrance'){   
					$where3='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc'; 
					$rs3=GetPageRecord('*','quotationEntranceMaster',$where3);  
					if(mysqli_num_rows($rs3) > 0){
						$entrancelisting=mysqli_fetch_array($rs3);
						$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entrancelisting['entranceNameId'].'"');  
						$entranceData=mysqli_fetch_array($rsentn); 
						// code here
						?> 
						<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><?php 
				            $rs4='';
				            $rs4=GetPageRecord('*','imageGallery',' parentId = "'.$entranceData['id'].'" and galleryType="entrance" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
				            $resListing4=mysqli_fetch_array($rs4);
			            	if($resListing4['fileId']!=''){ 
				            	$entranceImage = geDocFileSrc($resListing4['fileId']);
				            	if(file_exists($entranceImage)==true){ 
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$entranceImage).'" width="200" height="130">';
				            	}else{
				            		echo '<img src="'.$fullurl.'images/entrance.jpeg" width="200" height="130">'; 
				            	}
				            }else{ 
				              echo '<img src="'.$fullurl.'images/entrance.jpeg" width="200" height="130">'; 
				            } 
				          	?></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr>
											<td ><strong class="serviceTitle"><?php echo strip($entranceData['entranceName']);  ?></strong></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc"><?php 
												if($resultpageQuotation['languageId'] != "0"){
													$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');
													$checkrow = mysqli_num_rows($rs2);
													$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
													if($checkrow > 0){
														echo strip($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]);
													} else{
														echo "";
													}
												}
												else{
													echo strip($entranceData['entranceDetail']);
												}
											 ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<!-- service seprator img -->
						<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php 	echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
						<?php  
					}
				}

				if($itineryDayData['serviceType'] == 'activity'){  
					$where4='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc';   
					$rs4=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where4);  
					if(mysqli_num_rows($rs4) > 0){  
						$activitylisting=mysqli_fetch_array($rs4);    
						$rs41=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id="'.$activitylisting['otherActivityName'].'" and  status=1');  
						$activityData=mysqli_fetch_array($rs41);  
						// code here
						?> 
						<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><?php 
					            $rs5='';
					            $rs5=GetPageRecord('*','imageGallery',' parentId = "'.$activityData['id'].'" and galleryType="activity" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
					            $resListing5=mysqli_fetch_array($rs5);
				            	if($resListing5['fileId']!=''){ 
					            	$activityImage = geDocFileSrc($resListing5['fileId']);
					            	if(file_exists($activityImage)==true){
					            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$activityImage).'" width="200" height="130">';  
					            	}else{
					            		echo '<img src="'.$fullurl.'images/activity.jpeg" width="200" height="130">';   
					            	}
					            }else{ 
					              echo '<img src="'.$fullurl.'images/activity.jpeg" width="200" height="130">'; 
					            } 
					            ?></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr>
											<td ><strong class="serviceTitle"><?php echo strip($activityData['otherActivityName']);  ?></strong></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc"><?php 
											 	if($resultpageQuotation['languageId'] != "0"){
												 	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"');  
												 	$checkrow = mysqli_num_rows($rs2);
													$activityLanData=mysqli_fetch_array($rs2);
													if($checkrow > 0){
														echo strip_tags($activityLanData['lang_0'.$resultpageQuotation['languageId']]); 
											        } else{
														echo ""; 
											    	} 
											  	} else {
													echo strip_tags($activityData['otherActivityDetail']); 
										    	} ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<!-- service seprator img -->
						<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php 	echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
						<?php  
					}
				}

				if($itineryDayData['serviceType'] == 'additional'){  
					$where5='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc';   
					$rs5=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where5);  
					if(mysqli_num_rows($rs5) > 0){  
					 	$additionalQuotData=mysqli_fetch_array($rs5);  
						$rs51=GetPageRecord('*','extraQuotation',' id="'.$additionalQuotData['additionalId'].'" ');  
						$extraData=mysqli_fetch_array($rs51);   
						// code here
						?> 
						<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><img src="<?php echo $fullurl; ?>images/activity.jpeg" width="200" height="130"></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="0" cellspacing="0" >
									<tbody>
										<tr>
											<td ><strong class="serviceTitle"><?php echo strip($extraData['name']);  ?></strong></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc">Additional the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions..</div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<!-- service seprator img -->
						<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php 	echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
						<?php 

					}
				}

				if($itineryDayData['serviceType'] == 'train' ){ 
					$quotTrainSql='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$quotTrainQuery=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$quotTrainSql);  
					if(mysqli_num_rows($quotTrainQuery) > 0){
						$trainQuoteData=mysqli_fetch_array($quotTrainQuery); 
						$trainTypeLable ='';
						if($trainQuoteData['isLocalEscort']==1){
					        $trainTypeLable .= "Local Escort,";
					    }
					    if($trainQuoteData['isForeignEscort']==1){
					        $trainTypeLable .= "Foreign Escort,";
					    }
					    if($trainQuoteData['isGuestType']==1){
					        $trainTypeLable .= "Guest,";
					    } 
						$trainQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');  
						$trainData=mysqli_fetch_array($trainQuery);  

						$jfrom = getDestination($trainQuoteData['departureFrom']);
						$jto= getDestination($trainQuoteData['arrivalTo']); 

						if(date('Hi',strtotime($trainQuoteData['departureTime'])) <> '0530'){
							$dptTime = "@".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
						}else{
							$dptTime ='';
						}	
						if(date('Hi',strtotime($trainQuoteData['arrivalTime'])) <> '0530'){
							$avrTime = date('Hi',strtotime($trainQuoteData['arrivalTime']))." Hrs";
						}else{
							$avrTime ='';
						}														
						$journeyType="";
						if($trainQuoteData['journeyType']=='overnight_journey'){ 
							$journeyType = "Overnight"; 
						}else{ 
							$journeyType = "Day"; 
						} 
						// code here
						?> 
						<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service train">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><img src="<?php echo $fullurl; ?>images/train.jpg" width="200" height="130" /></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" > 
									<tr>
										<td colspan="5" ><div class="serviceTitle"><?php  echo rtrim($trainTypeLable,',')." Train ";  echo strip($trainData['trainName']);  ?></div></td>
									</tr>
									<tr> 
										<td width="100%" colspan="5" ><strong>Train Information</strong></td> 
										<!-- 
										<td width="15%" ><strong>Journey&nbsp;Type</strong></td> 
										<td width="20%" ><strong>TrainNumber</strong></td> 
										<td width="15%" ><strong>TrainClass</strong></td> 
										<td width="25%" ><strong>Dept-Arr</strong></td> 
										<td width="25%" ><strong>Dept-Arr&nbsp;Time</strong></td>  -->
									</tr> 
									<tr> 
										<td width="100%" colspan="5" >
											<?php 
											echo "Train: ".strip($trainData['trainName']).' '.$journeyType .' from '.ucfirst($jfrom).' to '.ucfirst($jto)." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/'.strip($trainQuoteData['trainClass']); 
											 ?></td> 
									</tr>
								</table>	
							</td>
							</tr>
							</tbody>
						</table>
						<!-- service seprator img -->
						<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php 	echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
						<?php 

					}
				}

				if($itineryDayData['serviceType'] == 'flight' ){ 
					$quotFlightSql='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$quotFlightQuery=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$quotFlightSql);  
					if(mysqli_num_rows($quotFlightQuery) > 0){
						$flightQuoteData=mysqli_fetch_array($quotFlightQuery); 
						$flightTypeLable ='';
						if($flightQuoteData['isLocalEscort']==1){
					        $flightTypeLable .= "Local Escort,";
					    }
					    if($flightQuoteData['isForeignEscort']==1){
					        $flightTypeLable .= "Foreign Escort,";
					    }
					    if($flightQuoteData['isGuestType']==1){
					        $flightTypeLable .= "Guest,";
					    } 
						$flightQuery=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteData['flightId'].'"');  
						$flightData=mysqli_fetch_array($flightQuery);  

						$jfrom = getDestination($flightQuoteData['departureFrom']);
						$jto= getDestination($flightQuoteData['arrivalTo']); 

						if(date('Hi',strtotime($flightQuoteData['departureTime'])) <> '0530'){
							$dptTime = "@".date('Hi',strtotime($flightQuoteData['departureTime']));
						}else{
							$dptTime ='';
						}	
						if(date('Hi',strtotime($flightQuoteData['arrivalTime'])) <> '0530'){
							$avrTime = date('Hi',strtotime($flightQuoteData['arrivalTime']))." Hrs";
						}else{
							$avrTime ='';
						}	
						// code here
						?> 
						<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service flight">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle">
								<img src="<?php echo $fullurl; ?>images/flight.jpg" width="200" height="130" />
							</td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" > 
									<tr>
										<td colspan="4" ><strong class="serviceTitle"><?php  echo rtrim($flightTypeLable,',')." Flight ";  echo strip($flightData['flightName']);  ?></strong></td>
									</tr>
									<tr> 
										<td width="100%" colspan="5" ><strong>Flight Information</strong></td> 
										<!-- <td width="20%"><strong>FlightNumber</strong></td> 
										<td width="20%"><strong>FlightClass</strong></td> 
										<td width="30%"><strong>Departure-Arrival</strong></td> 
										<td width="30%"><strong>Departure-Arrival Time</strong></td>  -->
									</tr> 
									<tr> 
										<td width="20%"><?php 
										echo "Flight: ".strip($flightData['flightName']).' from '.ucfirst($jfrom).' to '.ucfirst($jto)." by ".strip($flightQuoteData['flightNumber']).' '.$dptTime.$avrTime.'/'.strip($flightQuoteData['flightClass']); 
										?></td>
										<!-- <td width="20%"><?php echo strip($flightQuoteData['flightNumber']); ?></td> 
										<td width="20%"><?php echo strip($flightQuoteData['flightClass']); ?></td> 
										<td width="30%"><?php echo ucfirst($jfrom).'-'.ucfirst($jto); ?></td> 
										<td width="30%"><?php echo trim($dptTime).'-'.trim($avrTime); ?></td>  -->
									</tr>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<!-- service seprator img -->
						<table width="100%" cellpadding="10" cellspacing="0" border="0" align="center"><tr>
						<td><img src="<?php echo $fullurl; ?>images/seperator.png" width="790" /></td></tr></table>
						<?php  
					}
				}
				// END OF SERVICES
			}
			?>
		</td>
		</tr>
		</table>

		<?php
	$n++; 
	$day++;
	}
	?>
	<br />	
	<!-- service seprator img -->
	<table width="100%" cellpadding="25" cellspacing="0" border="0" ><tr>
	<td align="left"><img src="<?php 	echo $fullurl; ?>images/end-of-tour.png" width="760" /></td></tr></table>
	<br /> 
	<br />

	<div class="table-service pd30" > 
		<div class="docTitle w60">&nbsp;&nbsp;&nbsp;&nbsp;HOTEL PROPOSED</div><br />
		<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable table-service">
			 	<tr>
					<th width="20%" align="left" valign="middle" ><strong>Dates</strong></th>
					<th width="12%" align="left" valign="middle" ><strong>City</strong></th>
					<th width="27%" align="left" valign="middle" ><strong>Hotel</strong></th>
					<th width="16%" align="left" valign="middle" ><strong>Room Type</strong></th>
		 			<th width="25%" align="left" valign="middle" ><strong>Remarks</strong></th>
				</tr>
				<?php 
				$totalHotel = 0;
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
				while($sorting3=mysqli_fetch_array($b1)){  
				
					$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$sorting3['serviceId'].'" and supplementHotelStatus!=1');  
					if(mysqli_num_rows($b) > 0){
						$hotelQuotData=mysqli_fetch_array($b);
						$hotelTypeLable = '';
						if($hotelQuotData['isLocalEscort']==1){
				        $hotelTypeLable .= "Local Escort,";
				    }
				    if($hotelQuotData['isForeignEscort']==1){
				        $hotelTypeLable .= "Foreign Escort,";
				    }
				    if($hotelQuotData['isGuestType']==1){
				        $hotelTypeLable .= "Guest,";
				    }

						$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
						$hotelData=mysqli_fetch_array($d);
						
						$start = strtotime($hotelQuotData['fromDate']);
						$end = strtotime($hotelQuotData['toDate']);
						$days_between='';
						$days_between = ceil(abs($end - $start) / 86400);
						?> 
			  		<tr>
						<td valign="middle">
						<?php 
						echo date('j M Y',strtotime($sorting3['startDate']));  
						?>
						</td>
						<td valign="middle"><?php echo getDestination($hotelQuotData['destinationId']); ?></td>
						<td valign="middle"><?php echo rtrim($hotelTypeLable,',')." Hotel- ".strip($hotelData['hotelName']);  ?></td>
						<td valign="middle"><?php 
						$select12='*';  
						$where12='id="'.$hotelQuotData['roomType'].'"'; 
						$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
						$editresult2=mysqli_fetch_array($rs12);
						echo $rtype=$editresult2['name'];
						?></td>
						<td valign="middle"></td>
				  	</tr>
				  	<?php 
				  } 
				} ?>
			</table>
		</td>
		</tr>
		</table>
	</div>
	<br />
	<br /> 

	<!-- Total Tour Cost and per person basis costs details -->
	<?php
	$singleRoom = $resultpageQuotation['sglRoom'];
	$doubleRoom = $resultpageQuotation['dblRoom'];
	$tripleRoom = $resultpageQuotation['tplRoom'];
	$twinRoom   = $resultpageQuotation['twinRoom'];
	$extraBedChild = $resultpageQuotation['childwithNoofBed'];

	$conspan = 0;
	if($singleRoom>0){ $conspan=$conspan+1; }
	if($doubleRoom>0){ $conspan=$conspan+1; }
	if($tripleRoom>0){ $conspan=$conspan+1; }
	if($extraBedChild>0){ $conspan=$conspan+1; }
	$colsWidth = 80/$conspan;
	if($conspan>0){ ?>
	<div class="table-service pd30" > 
		<div class="docTitle">&nbsp;&nbsp;&nbsp;&nbsp;QUOTATION</div><br />
		<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
			<tr>
				<td>
					<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable table-service" >
						<tr>
							<th width="20%" align="right" rowspan="2" valign="middle"><strong>Total&nbsp;Cost<br>(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></th>
							<?php if($conspan>0){ ?>
							<th width="80%" colspan="<?php echo $conspan; ?>" align="center" valign="middle"><strong>Per Person Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></th>
							<?php } ?>
						</tr>
						<tr>
							<?php if($singleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><div align="right"><strong>Single Basis</strong></div></th>
							<?php } if($doubleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><div align="right"><strong>Double Basis</strong></div></th>
							<?php } if($tripleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><div align="right"><strong>ExtraBed(Adult) Basis</strong></div></th>
							<?php } if($extraBedChild>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><div align="right"><strong>ExtraBed(child) Basis</strong></div></th>
							<?php } ?>
						</tr>
						
						<tr>
							<td valign="middle"><div align="right">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
							</div></td>
							<?php if($singleRoom>0){ ?>
							<td valign="middle">
								<div align="right">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
								</div>
							</td>
							<?php } if($doubleRoom>0){ ?>
							<td valign="middle">
								<div align="right">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
								</div>
							</td>
							<?php } if($tripleRoom>0){ ?>
							<td valign="middle">
								<div align="right">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedABasis)); ?>
								</div>
							</td>
							<?php } if($extraBedChild>0){ ?>
							<td valign="middle">
								<div align="right">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?>
								</div>
							</td>
							<?php } ?>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<br /> 
	<br /> 
	<?php } 

	if($resultpageQuotation['flightCostType'] == 1){  ?>
	<div class="table-service pd30" > 
		<div class="docTitle">&nbsp;&nbsp;&nbsp;&nbsp;AIR FARE SUPPLEMENT</div><br />
		<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
			<td>
				<table border="1" cellpadding="5" cellspacing="0" class="borderedTable table-service">
					<tr>
						<th width="12%" valign="middle" bgcolor="#133f6d"><strong>Date</strong></th>
						<th width="19%" valign="middle" bgcolor="#133f6d"><strong>Sector</strong></th>
						<th width="30%" valign="middle" bgcolor="#133f6d"><strong>Flight/Timings</strong></th>
						<th width="28%" valign="middle" bgcolor="#133f6d"><strong>Class/Baggage</strong></th>
						<th width="11%" align="right" valign="middle" bgcolor="#133f6d"><strong>Fare</strong></th>
					</tr>
					<?php 
					$totalFlight= 0;
					$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
					while($flightQuotData=mysqli_fetch_array($betet)){ 
			           
						$d5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuotData['flightId'].'"');  
						$flightData=mysqli_fetch_array($d5); 

						$departurefrom = getDestination($flightQuotData['departureFrom']);
						$arrivalTo = getDestination($flightQuotData['arrivalTo']);
						?> 
					  <tr>
							<td valign="middle">
							<?php 
							echo date('j M Y',strtotime($flightQuotData['fromDate']));  
							?></td>
							<td valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
							<td valign="middle"><?php echo strip($flightQuotData['flightNumber']);  
							if(!empty($flightQuotData['departureTime']) || !empty($flightQuotData['arrivalTime'])){ echo "/@".date('Hi',strtotime($flightQuotData['departureTime']))."/".date('Hi',strtotime($flightQuotData['arrivalTime']))." Hrs"; }   ?></td>		
							<td valign="middle"><?php echo strip($flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
							<td valign="middle"><div><?php echo getCurrencyName($newCurr); ?>&nbsp;<?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?></div></td>
			 			</tr>
					  <?php 
					} ?>
				  <tr>
				  	<td colspan="5" align="center">Air fares are subject to change at the time of booking</td>
				  </tr>
				</table>
			</td>
		</tr>
		</table>
	</div>
	<br />	
	<br />	
	<?php 
	}  

	$checkSuppHQuery="";
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$resultpageQuotation['id'].'" and supplementHotelStatus=1 ');
	if(mysqli_num_rows($checkSuppHQuery) > 0){
		?>
		<div class="table-service pd30" > 
			<div class="docTitle">&nbsp;&nbsp;&nbsp;&nbsp;HOTEL/ROOM SUPPLEMENT</div><br />
			<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
			<tr>
				<td>
					<?php  
					$queryId = $resultpageQuotation['queryId'];
					$quotationId= $resultpageQuotation['id'];
					include('quotationSupplementHoteltable.php');
					?>
				</td>
			</tr>
			</table>
		</div>
		<br />	
		<br />	
		<?php 
	} 
	// $inclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $inclusion));
	// $exclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $exclusion));
	?>
	<div class="docTitle w60">&nbsp;&nbsp;&nbsp;&nbsp;INCLUSIONS</div>
	<div class="serviceDesc  incl"><?php echo strip($inclusion);  ?></div>
	<br />

	<div class="docTitle w60">&nbsp;&nbsp;&nbsp;&nbsp;EXCLUSIONS</div>
	<div class="serviceDesc  incl"><?php echo strip($exclusion); ?></div>
	<!-- service seprator img -->
	<table width="100%" cellpadding="25" cellspacing="0" border="0" ><tr>
	<td align="left"><img src="<?php echo $fullurl; ?>images/generated-by-TRAVCRM.png" width="760" /></td></tr></table>
</div>
</body>
</html
