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
<div class="calcostsheet"  style="display:none;display:none;visibility: hidden;height: 0;width: 0;position: fixed;left: 0;top: 0;" >
<?php  
if($resultpage['travelType']==2){
	include_once("loadFITCostSheet_domestic.php"); 
}else{
	include_once("loadFITCostSheet.php"); 
}
?>
</div>
<style type="text/css">
div,p,span,table,td,tr,li,ul,body{
font-family: 'Open Sans', sans-serif;
}
div,p,span,li,ul,body{
font-size: 12px;
color: #323030; 
}
</style>
<div class="main-container" style="font-family: Open Sans, sans-serif!important; font-weight: 300;border: 0px solid #ffffff; width: 100%;"><?php
// proposal header image ===========
$rs03='';
$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="4" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
$resListing3=mysqli_fetch_array($rs03);
$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
if($resListing3['fileId']!='' && file_exists($proposalPhoto3)==true){ ?> 
	<br>
	<table  width="100%" border="0" cellpadding="10" cellspacing="0">
	
			<tr>
				<td align="center">
					<img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" width="620" height="80" >
				</td>
			</tr>
		
	</table>
	<br>
	<br>
	<?php
}
?>
<table width="100%" class="travellerInfo" border="0" cellpadding="0" cellspacing="5" style="background-color: #ecf0f4;"> 
	<!--===== elite proposal banner image =======-->
	<tr><td align="center" ><?php 
			$imagepath = 'dirfiles/'.$resultpageQuotation['image'];
			if($resultpageQuotation['image']!='' && file_exists($imagepath)==true){
				?>
				<img src="<?php echo $fullurl.str_replace(' ','%20',$imagepath); ?>" alt="" width="620" height="240">
				<?php
			}else{
				$rsb03='';
				$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="4" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x300" order by id desc) order by id desc');
				$resListingb3=mysqli_fetch_array($rsb03);
				$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
				if($resListingb3['fileId']!='' && file_exists($proposalPhotob3)==true){ ?>
					<img src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>" width="640" height="240">
					<?php
				}

			}
		?>
		</td>
	</tr>
</table>
<br>

<table width="100%" class="travellerInfo"  border="0" cellpadding="5" cellspacing="5" style="font-size: 12px;font-weight: 500; background-color: #ecf0f4;">
	<tr><td align="center" colspan="4" ><h3>Elite Proposal</h3><br></td></tr>
	<tr>
		<td colspan="4" align="center"><div class="bannerText colorSize1" style="font-size: 16px;font-weight: 500; color: #133f6d;"><?php if($resultpageQuotation['quotationSubject']!=''){ echo $resultpageQuotation['quotationSubject']; }else{ echo $resultpage['subject']; } ?><?php //echo strip($quotationSubject); ?></div></td>
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
		<td colspan="4" align="center">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="colorSize3" >
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

<?php if(strlen($overviewText)!=''){ ?>
<div class="serviceTitle" style="font-size: 20px; background-color: #133f6d; color:#fff; font-weight: 700;line-height: 30px;">
	&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tour Overview</strong></div>
<table width="100%" border="0" cellpadding="15" cellspacing="0" class="overviewBox colorSize3" style="padding: 20px;padding-bottom: 10px;display: block; " >
	<tr>
		<td align="justify" valign="middle" >
			<?php 	$overviewText = str_replace('<p>&nbsp;</p>', '', $overviewText);
				$overviewText = str_replace('<p>', '<span>', $overviewText);
				echo $overviewText = str_replace('</p>', '</span>', $overviewText);
				// echo strip_tags(substr($overviewText, 0 ,840));
				  ?>
 		</td>
	</tr>
</table> 
<br>
<?php } ?>
<?php  
// DAY LOOP START
$day=1;
$queryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
while($queryDaysData=mysqli_fetch_array($queryDaysQuery)){  
	$dayDate = date('Y-m-d',strtotime($queryDaysData['srdate']));
	$dayId = $queryDaysData['id']; 

	$aDDD=GetPageRecord('*','destinationMaster','id="'.$queryDaysData['cityId'].'" ');
    $destDataddd=mysqli_fetch_assoc($aDDD);
 	$destDataddd['description'];
 	$destDataddd['name'];
	?>  
	<div class="dayTitle w60 " style="width: 60%;background-color: #133f6d;color: #fff;font-weight: bold;font-size: 20px;position: relative;display: inline-block;line-height: 30px; page-break-inside:avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Day <?php echo $day; ?> - <?php echo getDestination($queryDaysData['cityId']); $destn = getDestination($queryDaysData['cityId']); ?><?php if($resultpage['dayWise'] == 1){ ?> | <?php echo date('l d-m-Y', strtotime($dayDate)); } 	?>
	</div>
	<table width="100%" border="0" cellpadding="20" cellspacing="0" class="dayItineraryInfo " style="color: #424244;font-weight: 400;" ><tr><td>
	<?php 
	
	if(strlen(trim($queryDaysData['title']))>1 && strlen(trim($queryDaysData['description']))>1){ ?>
	<!-- <table width="100%" border="0" cellpadding="5" cellspacing="0" class=" colorSize3" >
		<tr >
			<td>  -->
			<div style="text-align: justify;page-break-inside: auto; font-size: 12px;color: #424244;font-weight: 400; " ><?php
			if(strlen($queryDaysData['title'])>1) { 
				echo "<strong>".urldecode(strip($queryDaysData['title']))."</strong><br>";  
			} 
			if($queryDaysData['description']!=''){ 
				// echo "<p>";
				$html = urldecode(strip($queryDaysData['description']));
				$html = str_replace('<ul>','<p>', $html);
				$html = str_replace('</ul>','</p>', $html);
				$html = str_replace('<li>','<p>', $html);
				$html = str_replace('</li>','</p>', $html);
				$html = str_replace('<p>&nbsp;</p>', '', $html);
				$html = str_replace('<p>', '<span>', $html);
				$html = str_replace('</p>', '</span>', $html);
				echo $html;
				// echo "</p>";
			}
			?>
			</div> 
			<!-- </td>
		</tr>
		
	</table> -->
	<!-- <br /> -->
	<?php
	}
	?>
	<div style="text-align: justify;page-break-inside: auto; font-size: 12px;color: #424244;font-weight: 400; " > 
		<?php
		if(${"destination".trim($destDataddd['id'])} != 1){
			${"destination".trim($destDataddd['id'])}=1;

			$destInfo = strip_tags(stripslashes($destDataddd['description']));
			if($destInfo!=''){
				// echo "<p>";
				echo "<strong>".trim($destDataddd['name'])." - </strong> ";
				$destInfo = str_replace('<p>&nbsp;</p>', '', $destInfo);
				$destInfo = str_replace('<p>', '<div>', $destInfo);
				echo $destInfo = str_replace('</p>', '</div>', $destInfo);
				// echo "</p>";
			}
		}  
		?>
	</div>
	<br />
	<?php
		$itiQuery=' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc';
		$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
		while($itineryDayData = mysqli_fetch_array($itineryDay)){
			if($itineryDayData['serviceType'] == 'hotels' ){
				$where1='quotationId="'.$queryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$itineryDayData['serviceId'].'"';   
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
				?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service hotel"style="border-bottom:1px solid #ccc;font-size: 12px;font-weight: normal;page-break-inside: avoid; ">
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
									<td colspan="3"><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php  echo "Hotel | "; echo strip($hoteldetail['hotelName']);  ?></strong></td>
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
									 	echo $hotelCatNam['hotelCategory'].' Star';
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
				</table><br><?php 
				}
			}
		}

		// SERVICE LOOP START
		$itiQuery=' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc';
		$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
		while($itineryDayData = mysqli_fetch_array($itineryDay)){

			if($itineryDayData['serviceType'] == 'hotel' ){
				$where1='quotationId="'.$queryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$itineryDayData['serviceId'].'"';   
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
				?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service hotel" style="border-bottom:1px solid #ccc;font-size: 12px;font-weight: normal;page-break-inside: avoid; ">
					<tbody><tr class="row-service">
					<td width="30%" align="left" valign="middle"><?php 
			            $rs2='';
			            $rs2=GetPageRecord('*','imageGallery',' parentId = "'.$hoteldetail['id'].'" and galleryType="hotel" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) order by id desc');
			            $resListing2=mysqli_fetch_array($rs2);
		            	
			            	$hotelImage = geDocFileSrc($resListing2['fileId']);
			            	if($resListing2['fileId']!='' && file_exists($hotelImage)==true){
			            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$hotelImage).'" width="200" height="130">';
			            	}else{
			            		echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
			            	}
					?></td>
					<td width="70%" align="left" valign="middle" >
						<table border="0" cellpadding="5" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td colspan="3"><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php  echo "Hotel | "; echo strip($hoteldetail['hotelName']);  ?></strong></td>
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
									 	echo trim($hotelCatNam['hotelCategory']).' Star';
									 	?></td>
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
				</table><br><?php 
				}
			}
			// Transfer type
			if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
				$rs12=GetPageRecord('*','quotationTransferMaster','quotationId="'.$queryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'" ');   
				if(mysqli_num_rows($rs12) > 0){
					$transferlisting=mysqli_fetch_array($rs12); 
					$rs123=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
					$transfergdetail=mysqli_fetch_array($rs123);

					$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');  
					$vename=mysqli_fetch_array($rs1aa);
					?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service transfer" style="border-bottom:1px solid #ccc;font-size: 12px;font-weight: normal;page-break-inside: avoid; ">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle"><?php   
							$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');
							$vename=mysqli_fetch_array($rs1aa);
							$vehicleimagepath = 'packageimages/'.$vename['image']; 
							?>
							
							<?php if($vename['image']!='' && file_exists($vehicleimagepath)==true){ ?>

						<img src="<?php echo $fullurl; ?>packageimages/<?php echo str_replace(' ', '%20',$vename['image']); ?>" width="200" height="130" /> 
						<?php }else{ ?>
						<img src="<?php echo $fullurl; ?>images/icon-transfer.png" width="200" height="130" />
							<?php } ?>
						</td>
						<td width="70%" align="left" valign="middle" >
						   <table width="100%" border="0" cellpadding="5" cellspacing="0" >
							 	<tr><td colspan="3" align="left" ><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php echo ucfirst(trim($transfergdetail['transferName'])); ?></strong>
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
								<table cellpadding="4" border="1" cellspacing="0"  class="borderedTable"  style="  font-size: 12px;font-weight: normal;width: 100%;">
						 	  	<tr>
						 	  	 	<th valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight Name';}if($transferTimelineData['mode']=='train'){ echo 'Train Name';} ?></th> 
						 	  	 	<th valign="center" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight No';}if($transferTimelineData['mode']=='train'){ echo 'Train No';} ?></th>
							 	  	<?php if($transferTimelineData['mode']=='flight'){?>
							 	  	<th valign="center" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;">Airport Name</th>
							 	     <?php } ?>
							 	    <th valign="center" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;">Arrival From</th> 
							 	  	<th valign="center" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;">Arrival Time</th>
							 	  	<th valign="center" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;">PickUp Time</th>
							 	  	<th valign="center" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;">Drop Time</th>
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
					</table><br><?php 

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
					?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service" style="border-bottom:1px solid #ccc;font-size: 12px;font-weight: normal;page-break-inside: avoid; ">
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
			            		echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">'; 
			            	}
			            }else{ 
			              echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">'; 
			            } 
			          	?></td>
						<td width="70%" align="left" valign="middle" >
							<table width="100%" border="0" cellpadding="5" cellspacing="0" >
								<tbody>
									<tr>
										<td ><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php echo strip($entranceData['entranceName']);  ?></strong></td>
									</tr>
									<tr>
										<td ><div class="serviceDesc" style="text-align: justify;page-break-inside: auto;font-size: 12px;padding-bottom: 5px;line-height: 18px;"><?php 
											if($resultpageQuotation['languageId']!= "0"){
												$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');
												$checkrow = mysqli_num_rows($rs2);
												$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
												if($checkrow > 0){
													echo strip($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]);
												} else{
													echo "Detail not available in this language";
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
					</table><br><?php  
				}
			}
			if($itineryDayData['serviceType'] == 'ferry'){   
				$where3='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc'; 
				$rs3=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,$where3);  
				if(mysqli_num_rows($rs3) > 0){
					$ferrylisting=mysqli_fetch_array($rs3);
					$rsentn=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$ferrylisting['serviceid'].'"');  
					$ferryData=mysqli_fetch_array($rsentn); 


					// code here
					?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service" style="border-bottom:1px solid #ccc; page-break-inside:avoid;">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle"><?php    
			            $rs4='';
			            $rs4=GetPageRecord('*','ferryNameMaster',' id = "'.$ferrylisting['ferryNameId'].'" and deleteStatus=0 ');
			            $resListing4=mysqli_fetch_array($rs4);
						$ferryimagepath = 'packageimages/'.$resListing4['image']; 
		            	if($resListing4['image']!='' && file_exists($ferryimagepath)==true){ 
			            	echo '<img src="'.$fullurl.'packageimages/'.str_replace(' ', '%20',$resListing4['image']).'" width="200" height="130">';
			            }else{ 
			              echo '<img src="'.$fullurl.'images/ferrydefault.png" width="200" height="130">'; 
			            } 
			          	?></td>
						<td width="70%" align="left" valign="middle" >
							<table width="100%" border="0" cellpadding="5" cellspacing="0" >
							<tbody>
								<tr>
									<td  colspan="3"><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php echo strip($resListing4['name']);  ?></strong></td>
								</tr>
								<tr>								
									<td width="34%" ><strong class="subHeading">Seat</strong></td>  
									<td width="33%" ><strong class="subHeading">Arr Time.</strong></td> 
									<td width="33%" ><strong class="subHeading">Dep Time.</strong></td>  
								</tr> 
								<tr>
									<td><?php echo getFerryClassName($ferrylisting['ferryClass']); ?></td>
									<td>
										<?php echo $ferrylisting['pickupTime']	?>
									</td>
									<td>
								<?php echo $ferrylisting['dropTime']	?>

									</td>
								</tr>
								<tr>
									<td colspan="3" align="left"><hr><br><?php echo strip($ferryData['information']); ?></td>
								</tr>

							</tbody>
							</table>
						</td>
						</tr>
						</tbody>
					</table><br><?php  
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
					?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service" style="border-bottom:1px solid #ccc;font-size: 12px;font-weight: normal;page-break-inside: auto; ">
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
				            		echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">';   
				            	}
				            }else{ 
				              echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">'; 
				            } 
				            ?></td>
						<td width="70%" align="left" valign="middle" >
							<table width="100%" border="0" cellpadding="5" cellspacing="0" >
								<tbody>
									<tr>
										<td ><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php echo strip($activityData['otherActivityName']);  ?></strong></td>
									</tr>
									<tr>
										<td ><div class="serviceDesc" style="text-align: justify;page-break-inside: auto;font-size: 12px;padding-bottom: 5px;line-height: 18px;"><?php 
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
					</table><br><?php  
				}
			}

			if($itineryDayData['serviceType'] == 'mealplan'){  
				$whereresM='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc';   
				$resRest=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$whereresM);  
				if(mysqli_num_rows($resRest) > 0){  
				 	$restaurantQuotData=mysqli_fetch_array($resRest); 
					$restaurantQuotData['mealPlanNameId'];
					$restmaster=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,' id="'.$restaurantQuotData['mealPlanNameId'].'" ');  
					$restmasterData=mysqli_fetch_array($restmaster); 

					$resmealtype=GetPageRecord('*','restaurantsMealPlanMaster',' id="'.$restaurantQuotData['mealType'].'" ');  
					$mealtypeData=mysqli_fetch_array($resmealtype); 
					// code here
					?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service" style="border-bottom:1px solid #ccc; font-size: 12px;font-weight: normal;page-break-inside: avoid; ">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle">
						    <?php  
			            	$mealplanpath = 'packageimages/'.$restmasterData['mealPlanImage'];
			            	if($restmasterData['mealPlanImage']!='' && file_exists($mealplanpath)==true){ 
				            	echo '<img src="'.$fullurl.'packageimages/'.str_replace(' ', '%20',$restmasterData['mealPlanImage']).'" width="200" height="130">'; 
				            }else{ 
				                echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            } 
				            ?>
				        </td>

						<td width="70%" align="left" valign="middle" >
							<table width="100%" border="0" cellpadding="0" cellspacing="5" >
								<tbody>
									<tr>
										<td ><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php echo "Restaurant | ".$restaurantQuotData['mealPlanName'];  ?></strong></td>
									</tr>
								
									<tr>
										<td class="serviceTitle" style="font-size: 12px;font-weight: 500;">&nbsp;&nbsp;<strong >Meal Type</strong></td>
										
									</tr>
									
									<tr>
									<td class="serviceTitle" style="font-size: 12px;">&nbsp;&nbsp;<?php echo strip($mealtypeData['name']);  ?></td>
									</tr>
									
								</tbody>
							</table>
						</td>
						</tr>
						</tbody>
					</table><br><?php 

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
					?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service" style="border-bottom:1px solid #ccc; font-size: 12px;font-weight: normal;page-break-inside: avoid; ">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle">
						    <?php  
							$additionalimgpath = 'packageimages/'.$extraData['file_extra'];
			            	if($extraData['file_extra']!='' && file_exists($additionalimgpath)==true){  
				            	echo '<img src="'.$fullurl.'packageimages/'.str_replace(' ', '%20',$extraData['file_extra']).'" width="200" height="130">'; 
				            }else{ 
				                echo '<img src="'.$fullurl.'images/additionalimg.png" width="200" height="130">'; 
				            } 
				            ?>
				        </td>
						<td width="70%" align="left" valign="middle" >
							<table width="100%" border="0" cellpadding="0" cellspacing="0" >
								<tbody>
									<tr>
										<td ><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php echo strip($extraData['name']);  ?></strong></td>
									</tr>
									<tr>
										<td>
											<?php echo $additionalQuotData['information']; ?>
										</td>
									</tr>
									<!--<tr>-->
									<!--	<td ><div class="serviceDesc" style="text-align: justify;page-break-inside: auto;font-size: 12px;padding-bottom: 5px;line-height: 18px;">Additional the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions..</div>-->
									<!--	</td>-->
									<!--</tr>-->
								</tbody>
							</table>
						</td>
						</tr>
						</tbody>
					</table><br><?php 

				}
			}
			// Train Image and train service
			if($itineryDayData['serviceType'] == 'train' ){ 
				$quotTrainSql='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
				$quotTrainQuery=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$quotTrainSql);  
				if(mysqli_num_rows($quotTrainQuery) > 0){
					$trainQuoteData=mysqli_fetch_array($quotTrainQuery); 
					$trainTypeLable ='';
					if($trainQuoteData['isLocalEscort']==1){
				        $trainTypeLable .= "Local Escort, ";
				    }
				    if($trainQuoteData['isForeignEscort']==1){
				        $trainTypeLable .= "Foreign Escort, ";
				    }
				    if($trainQuoteData['isGuestType']==1){
				        // $trainTypeLable .= "Guest,";
				    } 
					$trainQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');  
					$trainData=mysqli_fetch_array($trainQuery);  

					$jfrom = getDestination($trainQuoteData['departureFrom']);
					$jto= getDestination($trainQuoteData['arrivalTo']); 

					if(date('Hi',strtotime($trainQuoteData['departureTime'])) <> '0530'){
						$dptTime = " at ".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
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
					?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service train" style="border-bottom:1px solid #ccc; font-size: 12px;font-weight: normal;page-break-inside: avoid;">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle">

						<?php
						
						$trainimagepath = 'packageimages/'.$trainData['trainImage'];

						if($trainData['trainImage']!='' && file_exists($trainimagepath)){ ?>
						<img src="<?php echo $fullurl.str_replace(' ','%20',$trainimagepath); ?>" alt="">
						<?php }else{ ?>
							
							<img src="<?php echo $fullurl; ?>images/train.jpg" width="200" height="130" />
							<?php } ?>
							
						</td>
						<td width="70%" align="left" valign="middle" >
							<table width="100%" border="0" cellpadding="5" cellspacing="0" > 
								<tr>
									<td colspan="5" ><div class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><strong><?php  echo rtrim($trainTypeLable,',')."Train "; echo strip($trainData['trainName']);  ?></strong></div></td>
								</tr>
								<!--<tr>  
									 
									<td width="15%" ><strong>Journey&nbsp;Type</strong></td> 
									<td width="20%" ><strong>TrainNumber</strong></td> 
									<td width="15%" ><strong>TrainClass</strong></td> 
									<td width="25%" ><strong>Dept-Arr</strong></td> 
									<td width="25%" ><strong>Dept-Arr&nbsp;Time</strong></td>  
								</tr> -->
								<tr> 
									<td width="100%" colspan="5" >
										<?php 
										echo "<strong>Train:</strong> ".strip($trainData['trainName']).' '.$journeyType .' from '.ucfirst($jfrom).' to '.ucfirst($jto)." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/ '.str_replace('_',' ',$trainQuoteData['trainClass']); 
										 ?></td> 
								</tr>
							</table>	
						</td>
						</tr>
						</tbody>
					</table><br><?php 

				}
			}

			if($itineryDayData['serviceType'] == 'flight' ){ 
				$quotFlightSql='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
				$quotFlightQuery=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$quotFlightSql);  
				if(mysqli_num_rows($quotFlightQuery) > 0){
					$flightQuoteData=mysqli_fetch_array($quotFlightQuery); 
					$flightTypeLable ='';
					if($flightQuoteData['isLocalEscort']==1){
				        $flightTypeLable .= "Local Escort, ";
				    }
				    if($flightQuoteData['isForeignEscort']==1){
				        $flightTypeLable .= "Foreign Escort, ";
				    }
				    if($flightQuoteData['isGuestType']==1){
				        // $flightTypeLable .= "Guest,";
				    } 
					$flightQuery=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteData['flightId'].'"');  
					$flightData=mysqli_fetch_array($flightQuery);  

					$jfrom = getDestination($flightQuoteData['departureFrom']);
					$jto= getDestination($flightQuoteData['arrivalTo']); 

					if(date('Hi',strtotime($flightQuoteData['departureTime'])) <> '0530'){
						$dptTime = " at ".date('Hi',strtotime($flightQuoteData['departureTime']));
					}else{
						$dptTime ='';
					}	
					if(date('Hi',strtotime($flightQuoteData['arrivalTime'])) <> '0530'){
						$avrTime = date('Hi',strtotime($flightQuoteData['arrivalTime']))." Hrs";
					}else{
						$avrTime ='';
					}	
					// code here
					?><table width="100%" border="0" cellpadding="5" cellspacing="0" class="table-service flight" style="border-bottom:1px solid #ccc; font-size: 12px;font-weight: normal;page-break-inside: avoid;">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle">
							<?php 
							// flight image code here
						$flightimagepath = 'packageimages/'.$flightData['flightImage'];

						if($flightData['flightImage']!='' && file_exists($flightimagepath)){ ?>
						<img src="<?php echo $fullurl.str_replace(' ','%20',$flightimagepath); ?>" alt="">
						<?php }else{ ?>
						<img src="<?php echo $fullurl; ?>images/airlinethumbpackage.png" width="200" height="130" />
						<?php } ?>

							
						</td>
						<td width="70%" align="left" valign="middle" >
							<table width="100%" border="0" cellpadding="5" cellspacing="0" > 
								<tr>
									<td colspan="4" ><strong class="serviceTitle" style="font-size: 18px;line-height: 20px;color: #133f6d;font-weight: 700;"><?php  echo rtrim($flightTypeLable,',')."Flight ";  echo str_replace('_',' ',$flightData['flightName']);  ?></strong></td>
								</tr><!--
								<tr>  
									 <td width="20%"><strong>FlightNumber</strong></td> 
									<td width="20%"><strong>FlightClass</strong></td> 
									<td width="30%"><strong>Departure-Arrival</strong></td> 
									<td width="30%"><strong>Departure-Arrival Time</strong></td>  
								</tr> -->
								<tr> 
									<td width="100%"><?php 
									echo "<strong>Flight:</strong> ".strip($flightData['flightName']).' from '.ucfirst($jfrom).' to '.ucfirst($jto)." by ".strip($flightQuoteData['flightNumber']).' '.$dptTime.$avrTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass']); 
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
					</table><br><?php  
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
<!-- <br />	 -->
<!-- service seprator img -->
<table width="100%" cellpadding="25" cellspacing="0" border="0" ><tr>
<td align="left">
	<div style="display: block;position: relative;">
	<img src="<?php echo $fullurl; ?>images/end-of-tour.png" style="width:600px;height:30px" width="600" height="30" />
	</div>
</td></tr></table>
<!-- <br /> 
<br /> -->

	<span class="table-service pd30" style="font-size: 12px;font-weight: normal; page-break-after: never;"> 
	<div class="docTitle w60"  style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;HOTEL PROPOSED</div><br />
	<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable table-service"  style="  font-size: 12px;font-weight: normal;width: 100%;page-break-after: never;">
		 	<tr>
				<th width="20%" align="left" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Dates</strong></th>
				<th width="15%" align="left" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>City</strong></th>
				<th width="25%" align="left" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Hotel</strong></th>
				<th width="15%" align="left" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Room Type</strong></th>
	 			<th width="25%" align="left" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Additionals</strong></th>
			</tr>
			<?php 
			$totalHotel = 0;
			$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
			while($sorting3=mysqli_fetch_array($b1)){  
			
				$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$sorting3['serviceId'].'" and isHotelSupplement!=1');  
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
			        // $hotelTypeLable .= "Guest,";
			    }

					$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
					$hotelData=mysqli_fetch_array($d);
					
					$start = strtotime($hotelQuotData['fromDate']);
					$end = strtotime($hotelQuotData['toDate']);
					$days_between='';
					$days_between = ceil(abs($end - $start) / 86400);
					?> 
		  		<tr>
					<td valign="middle"><strong>
					<?php 
					echo date('j M Y',strtotime($sorting3['startDate']));  
					?></strong>
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
					<td valign="middle">
					<?php 
					$rtype='';
					$select121='*';  
					 $where121='hotelQuotId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'" '; 
					$rs12=GetPageRecord($select121,'quotationHotelAdditionalMaster',$where121); 
					while ($editresult2=mysqli_fetch_array($rs12)) {
						$rtype  .= $editresult2['name'].', ';
					}
					echo rtrim($rtype,', ');
					?>
					</td>
			  	</tr>
			  	<?php 
			  } 
			} ?>
		</table>
	</td>
	</tr>
	</table>
		</span>
<!-- <br />
<br />  -->

<!-- Total Tour Cost and per person basis costs details -->
<span class="table-service pd30" style="font-size: 12px;font-weight: normal;page-break-after: never;"> 
	<!-- <br /> -->
	<?php
	$singleRoom = $resultpageQuotation['sglRoom'];
	$doubleRoom = $resultpageQuotation['dblRoom'];
	$tripleRoom = $resultpageQuotation['tplRoom'];
	$twinRoom   = $resultpageQuotation['twinRoom'];
	$EBedAdult = $resultpageQuotation['extraNoofBed'];
	$EBedChild = $resultpageQuotation['childwithNoofBed'];
	$NBedChild = $resultpageQuotation['childwithoutNoofBed'];

	$conspan = 0;
	if($singleRoom>0){ $conspan=$conspan+1; }
	if($doubleRoom>0 || $tripleRoom>0){ $conspan=$conspan+1; }
	if($tripleRoom>0){ $conspan=$conspan+1; }
	if($EBedAdult>0){ $conspan=$conspan+1; }
	if($EBedChild>0){ $conspan=$conspan+1; }
	if($NBedChild>0){ $conspan=$conspan+1; }
	$colsWidth = 80/$conspan;
	?> 
	<table width="100%"  border="0" cellpadding="15" cellspacing="0" borderColor="#ccc">
		<tr>
			<td>
				<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable table-service" style="page-break-after: auto;page-break-before: auto;width: 100%;">
				<tr>
					<td style="background-color: #133f6d;color: #ffffff;text-align: left; page-break-inside: avoid;"  colspan="<?php echo $conspan+1; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<strong>QUOTATION</strong>  </td>
				</tr>
					<tr>
						<th width="20%" align="left" <?php if($conspan>0){ ?> rowspan="2" <?php } ?> valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Total&nbsp;Cost<br>(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></th>
						<?php if($conspan>0){ ?>
						<th width="80%" colspan="<?php echo $conspan; ?>" align="right" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Per Person Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></th>
						<?php } ?>
					</tr>
					<?php if($conspan>0){ ?>
					<tr>
						<?php if($singleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Single Basis</strong></th>
						<?php } if($doubleRoom>0 || $tripleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Double Basis</strong></th>
						<?php } if($tripleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Triple Basis</strong></th>
						<?php } if($EBedAdult>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>E.Bed(Adult) Basis</strong></th>
						<?php } if($EBedChild>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>CWB Basis</strong></th>
						<?php } if($NBedChild>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>CNB Basis</strong></th>
						<?php } ?>
					</tr>
					<?php } ?>
					<tr>
						<td valign="middle">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
						</td>
						<?php if($singleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
						</td>
						<?php } if($doubleRoom>0 || $tripleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
						</td>
						<?php } if($tripleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnTripleBasis)); ?>
						</td>
						<?php } if($EBedAdult>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedABasis)); ?>
						</td>
						<?php } if($EBedChild>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?>
						</td>
						<?php } if($NBedChild>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraNBedCBasis)); ?>
						</td>
						<?php } ?>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- <br /> 
	<br /> -->
</span> 
<?php  

$totalFlight= 0;
$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
?>
<span class="table-service pd30" style="font-size: 12px;font-weight: normal;page-break-inside: avoid;"> 
	<div class="docTitle" style="background-color: #133f6d;color: #ffffff;text-align: left; line-height:28px; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>AIR FARE SUPPLEMENT</strong></div>
	<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc" width="100%">
	<tr>
		<td>
			<table border="1" cellpadding="5" cellspacing="0" class="borderedTable table-service"  style="  font-size: 12px;font-weight: normal;width: 100%;">
				<tr>
					<th width="18%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Date</strong></th>
					<th width="17%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Sector</strong></th>
					<th width="30%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Flight/Timings</strong></th>
					<th width="21%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Class/Baggage</strong></th>
					<th width="15%" align="right" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Fare</strong></th>
				</tr>
				<?php 
				while($flightQuotData=mysqli_fetch_array($betet)){ 
		           
					$d5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuotData['flightId'].'"');  
					$flightData=mysqli_fetch_array($d5); 

					$departurefrom = getDestination($flightQuotData['departureFrom']);
					$arrivalTo = getDestination($flightQuotData['arrivalTo']);
					?> 
				  <tr>
						<td valign="middle"><strong>
						<?php 
						echo date('j M Y',strtotime($flightQuotData['fromDate']));  
						?></strong></td>
						<td valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
						<td valign="middle"><?php echo strip($flightQuotData['flightNumber']);  
						if(!empty($flightQuotData['departureTime']) || !empty($flightQuotData['arrivalTime'])){ echo " at ".date('Hi',strtotime($flightQuotData['departureTime']))."/".date('Hi',strtotime($flightQuotData['arrivalTime']))." Hrs"; }   ?></td>		
						<td valign="middle"><?php echo str_replace('_',' ',$flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
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
</span>
<!-- <br />	
<br />	 -->
<?php 
}  

$suppRoomQuery="";
$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$resultpageQuotation['id'].'" ');

$checkSuppHQuery="";
$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$resultpageQuotation['id'].'" and isHotelSupplement=1 ');
if(mysqli_num_rows($checkSuppHQuery) > 0 ||  mysqli_num_rows($suppRoomQuery) > 0){
	?>
	<div class="dayTitle" style="line-height: 28px;font-size: 16px;color: white;text-align: left;background-color: #133f6d;">&nbsp;&nbsp;&nbsp;&nbsp;Hotel/Room Supplement</div>
	<table border="0" cellpadding="15" cellspacing="0" borderColor="#ccc">
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
	<!-- <br />	 -->
	<?php 
}

// $overviewText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $overviewText));
// $highlightsText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $highlightsText));
// $inclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $inclusion));
// $exclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $exclusion));
// $tncText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $tncText));
// $specialText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $specialText));
?>



<!-- <br /> -->

<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px">
		
		<tr>
			
		<td style="padding-bottom: 5px !important;">
			
		<?php if($highlightsText){ ?> 
		<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Tour Highlights
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($highlightsText); ?>
			</td>
		</tr>
	</table>
	<br><br>

		<?php } if($inclusion!=''){ ?> 
		<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>; page-break-inside: avoid;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Inclusions
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($inclusion);  ?>
			</td>
		</tr>
	</table>
	<br><br>
	<?php } if($exclusion!=''){ ?>

		<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>; page-break-inside: avoid;line-height:1;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Exclusions
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($exclusion); ?>
			</td>
		</tr>
	</table>
	<br><br>
	<?php } if($tncText!=''){ ?>
			<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Terms & Conditions
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($tncText); ?>
			</td>
		</tr>
	</table>
	<br><br>
	<?php }  if($specialText!=''){ ?>
			<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Cancellation Policies
			</td>
		</tr>
		<tr>
		<td>
			<?php echo strip($specialText); ?>
			</td>
		</tr>
	</table>
	<?php } ?>
			</td>
		</tr>
	</table>
<?php 
$selectF= 'footerstatus, footertext';
$resfooter = GetPageRecord($selectF,'companySettingsMaster','id="1"');
$resultf = mysqli_fetch_assoc($resfooter);
if($resultf['footerstatus']==1){ ?> 
<table width="100%" cellpadding="25" cellspacing="0" border="0" ><tr>
<td align="center"><a style="color:green;" href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" ><?php if($resultf['footertext']!=''){ echo $resultf['footertext']; }else{ ?> Generated by TravCRM <?php } ?> </a></td></tr></table>
<?php } ?>
</div> 