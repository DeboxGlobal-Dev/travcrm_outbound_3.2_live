<?php 
include "inc.php";   
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['id']).'"');  
$resultpageQuotation=mysqli_fetch_array($rsp);  

$select='*';  
$where='id="'.$resultpageQuotation['queryId'].'"';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs); 

$totalPax = $resultpageQuotation['adult']+$resultpageQuotation['child'];
	$quotationId = $resultpageQuotation['id'];  
$queryId = $resultpage['id']; 	

$overviewText=$highlightsText=$inclusion=$exclusion=$tncText=$specialText='';
if($resultpageQuotation['overviewText']!='' || $resultpageQuotation['overviewText']!='undefined'){
	 $overviewText=preg_replace('/\\\\/', '',clean($resultpageQuotation['overviewText'])); 
}
if($resultpageQuotation['highlightsText']!='' || $resultpageQuotation['highlightsText']!='undefined'){
	$highlightsText=preg_replace('/\\\\/', '',clean($resultpageQuotation['highlightsText']));
}
if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
	$inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
}
if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
	$exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));  
}
if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
	$tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));  
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
<div style="display:none;display:none;visibility: hidden;height: 0;width: 0;position: fixed;left: 0;top: 0;" class="calcostsheet" >
<?php 
if($resultpageQuotation['quotationType']==2){ 

	if($resultpage['travelType']==2){
		include_once("loadGITCostSheet_domestic.php"); 
	}else{
		include_once("loadGITCostSheet.php"); 
	}

}else{
	if($resultpage['travelType']==2){
		include_once("loadFITCostSheet_domestic.php"); 
	}else{
		include_once("loadFITCostSheet.php"); 
	}
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
<div class="main-container" style="background-color: #fff;width: 100%;margin: auto;font-family: 'Open Sans', sans-serif; font-weight: 300;border: 0px solid #ffffff;color: #383737;"><?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="6" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
	if($resListing3['fileId']!='' && file_exists($proposalPhoto3)==true){ ?><table  width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #ccc;">
			<tbody>
				<tr>
					<td align="center" valign="top">
						<img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" width="620" height="80" >
					</td>
				</tr>
			</tbody>
		</table><?php
	}
	?><table  width="100%" border="0" cellpadding="15" cellspacing="0" >
	<tr>
	<td><table width="100%" border="0" cellpadding="0" cellspacing="0" ><tr><td align="center"><?php 
				 
				$rsb03='';
				$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="6" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x750" order by id desc ) order by id desc');
				$resListingb3=mysqli_fetch_array($rsb03);
				$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
				if($resListingb3['fileId']!='' && file_exists($proposalPhotob3)==true){ 
					echo '<img src="'.$fullurl.str_replace(' ', '%20',$proposalPhotob3).'" width="640" height="550" >';
				}
				 
				?>
				</td>
			</tr> 
		</table><table  width="100%" border="0" cellpadding="5" cellspacing="0" style="background-color: #fff;">
		<tr>
				<td colspan="1" width="30%" align="center"><h3>Vivid Proposal</h3></td>
				
				<td colspan="2" align="right" style="font-size: 15px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Query Id:</strong></td>
			<td style="font-size: 15px;" align="left"><?php echo makeQueryId($resultpage['id']);  ?></td>
			</tr>
			<tr>
				<td align="center"  colspan="4" width="97.5%">
					<strong style="line-height:40px;font-size: 23px;color:#133f6d;text-align: center;">&nbsp;<?php echo substr($quotationSubject, 0, 300); ?>&nbsp;</strong>
				</td>
			</tr>
			<tr><td align="center"  colspan="4">
				<strong style="font-size: 20px;background-color: #ea7031;color: #fff;">&nbsp;<?php 
				echo $resultpageQuotation['night'].' Nights / '.($resultpageQuotation['night']+1).' Days'; 
				?>&nbsp;&nbsp;&nbsp;</strong>
				</td>
			</tr>
			<tr>
				<td align="center"  colspan="4" valign="middle" ><strong style="font-size: 20px;background-color: #ea7031;color: #fff;">&nbsp;&nbsp;&nbsp;<?php  
					$rootMapQuery=GetPageRecord('cityId','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
					$numRoots = mysqli_num_rows($rootMapQuery); 
					$cnt = 1; 
					while($rootMapData=mysqli_fetch_array($rootMapQuery)){ 
						echo getDestination($rootMapData['cityId']); 
						if($numRoots > $cnt){ ?> - <?php } 
						$cnt++;
					}
					?>&nbsp;&nbsp;&nbsp;</strong>
				</td>
			</tr>
		</table>
	</td>
	</tr>
	</table>
	<br />
	<!-- <div  > -->
		<?php
	if($highlightsText!=''){ ?>
	<div style="line-height: 35px;font-size: 16px;font-weight: bold;text-align: center;page-break-before: never;background-color: #133f6d; color:#fff; page-break-inside:avoid;">Tour&nbsp;Highlights</div>
	<table width="95%" cellpadding="8" cellspacing="0" bordercolor="#ccc">
		<tr>
			<td>
				<?php
				$highlightsText = str_replace('<p>&nbsp;</p>', '', $highlightsText);
				$highlightsText = str_replace('<p>', '<span>', $highlightsText);
				echo $highlightsText = str_replace('</p>', '</span>', $highlightsText);
			?></td>
		</tr>
	</table><?php 
	} ?>
	<!-- </div> -->
		<br>
	<div class="dayTitle" style="line-height: 32px;font-size: 16px;color: white;text-align: left;background-color: #133f6d; page-break-before: never;page-break-inside: avoid;vertical-align: middle !important;">&nbsp;&nbsp;&nbsp;&nbsp;Proposal <?php if( $resultpage['leadPaxName']!=''){ echo "for ".$resultpage['leadPaxName']; }  ?> At a Glance </div>
	<?php 
	if(($resultpageQuotation['hotCategory']!=0 || $resultpageQuotation['hotCategory']!='') && ($resultpageQuotation['quotationType']==2)) {
		$hotelwidth = 40;
		$citywidth = 20;
	 }else{
		$hotelwidth = 50;
		$citywidth = 30;
	 } ?><table  width="100%" border="0" cellpadding="15" cellspacing="0" >
		<tr>
		<td><table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#ccc" >
			<tr>
				<th width="20%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Day</strong></th>
				<th width="<?php echo $citywidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>City</strong></th>
				<?php 
				if(($resultpageQuotation['hotCategory']!=0 || $resultpageQuotation['hotCategory']!='') && ($resultpageQuotation['quotationType']==2)) { 
					
					$cateid = $resultpageQuotation['hotCategory'];
					$hotelcat = explode(',', $cateid);
					$cols = count($hotelcat);
					$colwidth = 60;

					$starwidth = $colwidth/$cols;
		
				foreach($hotelcat as $hotelcategoryid){

					if( $hotelcategoryid == '1'){
						
					?> 

					<th width="<?php echo $starwidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>3-Star</strong></th>
					<?php } if( $hotelcategoryid == '3'){ ?>
				
					<th width="<?php echo $starwidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>4-Star</strong></th>
							<?php } if( $hotelcategoryid == '2'){ ?>
					<th width="<?php echo $starwidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>5-Star</strong></th>
								<?php } ?>
					<?php } }else{ ?> 
					<th width="<?php echo $hotelwidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Hotel</strong></th>
				<?php }  ?>
			
			</tr><?php
			$quotationId=$resultpageQuotation['id'];
			$queryId=$resultpageQuotation['queryId']; 
			    
			$day=1;
			$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
			while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
				$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
				$dayId = $QueryDaysData['id']; 
				 
				?><tr style="page-break-inside:avoid">
				<td valign="middle"><span style="text-align:justify"><strong><?php echo "Day ".$day; if($resultpage['dayWise'] == 1){ ?>  <?php echo date('D', strtotime($dayDate))."<br>"; echo date('j M Y', strtotime($dayDate)); } ?></strong> </span></td>

				<td valign="middle"><?php echo getDestination($QueryDaysData['cityId']); $destn = getDestination($QueryDaysData['cityId']); ?></td>
				<?php 

				if(($resultpageQuotation['hotCategory']!=0 || $resultpageQuotation['hotCategory']!='') && ($resultpageQuotation['quotationType']==2)) { 	
					$cateidintd = $resultpageQuotation['hotCategory'];
					$hotelcatintd = explode(',',$cateidintd);
					// {"$city_".$destn = 0}
		
				foreach($hotelcatintd as $hotelStarid){
				if( $hotelStarid == '1'){
						?><td>
				<?php
				// 3 Star hotel
				$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
				$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
				while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
				
					if($itineryDayData['serviceType'] == 'hotel' ){
						$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
						while($sorting1=mysqli_fetch_array($b1)){ 
							 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$sorting1['serviceId'].'" and categoryId in ( select id from hotelCategoryMaster where hotelCategory=3)';   
							$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
							if(mysqli_num_rows($rs22) > 0){
								
								while($hotellisting=mysqli_fetch_array($rs22)){ 
									$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'" ');  
									$hotelData=mysqli_fetch_array($rs1ee);   
									//hotel details
									
									if($hotellisting['escortHotelStatus'] == 1){ echo "Escort Hotel:"; } echo $hotelData['hotelName'];
									$rs2='';  
									$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
									$editresult2=mysqli_fetch_array($rs2);
									?><br><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"/>
									<?php
									if($editresult2['subname']!=''){
										echo " <strong>Meal -</strong> ".clean($editresult2['subname']);
									}else{
										echo " <strong>Meal -</strong> ".clean($editresult2['name']);
									}
								}
								echo '<br>';
							}
						}
					} 
					
				}
				?>		
				</td>
				<?php }  if( $hotelStarid == '3'){
					?>
				<td>
				<?php
					// 4 Star hotel
				$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
				$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
				while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
				
					if($itineryDayData['serviceType'] == 'hotel' ){
						$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
						while($sorting1=mysqli_fetch_array($b1)){ 
							 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$sorting1['serviceId'].'" and categoryId in ( select id from hotelCategoryMaster where hotelCategory=4 )';   
							$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
							if(mysqli_num_rows($rs22) > 0){
								
								while($hotellisting=mysqli_fetch_array($rs22)){ 
									$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'" ');  
									$hotelData=mysqli_fetch_array($rs1ee);   
									//hotel details
									
									if($hotellisting['escortHotelStatus'] == 1){ echo "Escort Hotel:"; } echo $hotelData['hotelName'];
									$rs2='';  
									$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
									$editresult2=mysqli_fetch_array($rs2);
									?><br><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"/>
									<?php
									if($editresult2['subname']!=''){
										echo " Meal - ".clean($editresult2['subname']);
									}else{
										echo " Meal - ".clean($editresult2['name']);
									}
								}
								echo '<br>';
							}
						}
					} 
					
				}
				?>		
				</td>
				<?php } if( $hotelStarid == '2'){ ?> 
				<td>
				<?php
					// 5 Star hotel
				$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
				$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
				while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
				
					if($itineryDayData['serviceType'] == 'hotel' ){
						$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
						while($sorting1=mysqli_fetch_array($b1)){ 
							 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$sorting1['serviceId'].'" and categoryId in ( select id from hotelCategoryMaster where hotelCategory=5)';   
							$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
							if(mysqli_num_rows($rs22) > 0){
								
								while($hotellisting=mysqli_fetch_array($rs22)){ 
									$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'" ');  
									$hotelData=mysqli_fetch_array($rs1ee);   
									//hotel details
									
									if($hotellisting['escortHotelStatus'] == 1){ echo "Escort Hotel:"; } echo $hotelData['hotelName'];
									$rs2='';  
									$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
									$editresult2=mysqli_fetch_array($rs2);
									?><br><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"/>
									<?php
									if($editresult2['subname']!=''){
										echo " Meal - ".clean($editresult2['subname']);
									}else{
										echo " Meal - ".clean($editresult2['name']);
									}
								}
								echo '<br>';
							}
						}
					} 
					
				}
				?>		
				</td>
				<?php } } }else{ ?> 
				<td valign="middle"><?php 
				// services list
				$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
				$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
				while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
				
					if($itineryDayData['serviceType'] == 'hotel' ){
						$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
						while($sorting1=mysqli_fetch_array($b1)){ 
							 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$sorting1['serviceId'].'"';   
							$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
							if(mysqli_num_rows($rs22) > 0){
								
								while($hotellisting=mysqli_fetch_array($rs22)){ 
									$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
									$hotelData=mysqli_fetch_array($rs1ee);   
									//hotel details
									if($hotellisting['escortHotelStatus'] == 1){ echo "Escort Hotel:"; } echo $hotelData['hotelName'];
									$rs2='';  
									$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
									$editresult2=mysqli_fetch_array($rs2);
									?><br><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"/>
									<?php
									if($hotellisting['lunch']>0){
										$lunch = "Lunch";
									}else{
										$lunch = '';
									}
									if($hotellisting['dinner']>0){
										$dinner = "Dinner";
									}else{
										$dinner = '';
									}
									if($editresult2['subname']!=''){
										echo " Meal - ".clean($editresult2['subname'].' '.$lunch.' '.$dinner);
									}else{
										echo " Meal - ".clean($editresult2['name'].' '.$lunch.' '.$dinner);
									}
								}
								// echo '<br>';
							}
						}
					} 
					
				}
				?>			
				</td>
				<?php } ?>

				</tr>
			  	<?php $day++; } ?>
			<!-- <tr> 
			<td align="center" colspan="5">*************</td>
			 </tr> -->
		</table>
		</td>
	</tr>
	</table><br />
	<div style="page-break-inside:avoid; line-height: 35px;font-size: 25px;font-weight: bold;text-align: center; background-color: #133f6d;color: #ffffff;">Tour&nbsp;Program</div>
	<br />
	<?php		
	//------------------------------
	$day=1;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
					
		$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		$dayId = $QueryDaysData['id']; 
		$cityId = $QueryDaysData['cityId']; 

		$a22=GetPageRecord('*','destinationMaster','id="'.$QueryDaysData['cityId'].'" ');
        $destData22=mysqli_fetch_array($a22);

        $destinationImage = '';
        $rs5='';
        $rs5=GetPageRecord('*','imageGallery',' parentId = "'.$destData22['id'].'" and galleryType="destination" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="1080x300" ) order by id desc');
        $resListing5=mysqli_fetch_array($rs5);
        if($resListing5['fileId']!=''){
            $destinationImage2 = geDocFileSrc($resListing5['fileId']);
            if(file_exists($destinationImage2)==true){
             $destinationImage =  '<tr><td  align="center"><img src="'.$fullurl.str_replace(' ', '%20',$destinationImage2).'" width="620" height="170" /></td></tr>';
            }
        }
		?><div class="dayTitle" style="line-height: 30px;font-size: 16px;text-align: left; page-break-inside:avoid;">&nbsp;&nbsp;<img src="<?php echo $fullurl.'images/icon-map-pointer.png'; ?>" width="20" height="20"/>&nbsp;Day&nbsp;<?php echo $day;?>&nbsp;<?php echo trim($destData22['name']); if($day==1){ echo "&nbsp;Arrival"; } ?> 
		<?php if($destinationImage!=''){ ?><br/>
		<table width="100%" border="0" cellpadding="15" cellspacing="0">
		<?php echo $destinationImage;  ?>
		</table>
		<?php } ?>
		</div>
		<table  width="100%" border="0" cellpadding="15" cellspacing="0" ><tr><td><div class="serviceDesc" style="text-align: justify;page-break-inside: auto;"><?php
			if(strlen($QueryDaysData['title'])>1) {
				echo "<strong>".trim(urldecode(strip($QueryDaysData['title'])))." - </strong><br>";
				// echo "<br />";
			}

			$html = trim(urldecode(strip($QueryDaysData['description'])));
			if($html!=''){
			
				$html = str_replace('<ul>','<p>', $html);
				$html = str_replace('</ul>','</p>', $html);
				$html = str_replace('<li>','<p>', $html);
				$html = str_replace('</li>','</p>', $html);
				$html = str_replace('<p>&nbsp;</p>', '', $html);
				$html = str_replace('<p>', '<span>', $html);
				$html = str_replace('</p>', '</span>', $html);

				echo $html.'<br><br>';
			}

			// destination INformation
			if(${"destination".trim($destData22['id'])} != 1){
				${"destination".trim($destData22['id'])}=1;

				$destInfo = strip_tags(stripslashes($destData22['description']));
				if($destInfo!=''){
					// echo "<br>";
					echo "<strong>".trim($destData22['name'])." - </strong> ";
					echo strip_tags(strip($destInfo));
					// $destInfo = str_replace('<p>&nbsp;</p>', '', $destInfo);
					// $destInfo = str_replace('<p>', '<span>', $destInfo);
					// echo $destInfo = str_replace('</p>', '</span>', $destInfo);

					// echo "</p>";
				}
			} 

			// services list
			$cnt1 = 1;
			// services list
			$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc,id desc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){
			
				if($itineryDayData['serviceType'] == 'hotel' ){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$itineryDayData['serviceId'].'"';   
					$rs22='';
					$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
					if(mysqli_num_rows($rs22) > 0){
					
						while($hotellisting=mysqli_fetch_array($rs22)){ 
							if($hotellisting['complimentaryLunch']=='1'){
								$lunchmeal = " Lunch";
							}
							if($hotellisting['complimentaryDinner']=='1'){
								$dinnermeal = ' Dinner';
							}
							if($hotellisting['complimentaryBreakfast']=='1'){
								$breakFastmeal = " BreakFast";
							}
							
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
						$hotelData=mysqli_fetch_array($rs1ee);   
							//hotel details
							$catres = GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"');
							$starRes = mysqli_fetch_assoc($catres);
							$rs2='';  
							$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
							$editresult2=mysqli_fetch_array($rs2);
							echo "<p>";
							?><img src="<?php echo $fullurl.'images/icon-home.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;
							<?php
							echo "<strong>Overnight stay&nbsp;at&nbsp;Hotel&nbsp;".$hotelData['hotelName'].' '.$starRes['hotelCategory'].' Star'." in ".trim($destData22['name'])." Mealplan - (".clean($editresult2['name']).''.$lunchmeal.' '.$dinnermeal.' '.$breakFastmeal.")";
							echo "</p></strong>";

							if($hotelData['hotelDetail']!=''){
								echo strip(trim($hotelData['hotelDetail']))."<br>";					
							}
							// echo "</p>";
							$halists='';
							$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$hotellisting['id'].'" and quotationId="'.$hotellisting['quotationId'].'" '); 
							if(mysqli_num_rows($rs12)>0){
								echo "<p>";
								while ($editresult2=mysqli_fetch_array($rs12)) {
									$halists  .= $editresult2['name'].', ';
								}
							?><img src="<?php echo $fullurl.'images/blogcmsicon.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;
							<?php 
							echo rtrim($halists,', ');
							echo "</p>";
							}
						}
					}
						 
				}
				if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
					$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc');  
					if(mysqli_num_rows($rs22dd) > 0){
						while($transferlisting=mysqli_fetch_array($rs22dd)){  
						$rs2ss=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
						$transfergdetail=mysqli_fetch_array($rs2ss);   
						//transfer detail
							echo "<p>";
							?><img src="<?php echo $fullurl.'images/icon-transfer.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;<?php
							echo "<strong>".ucfirst($transfergdetail['transferName'])."</strong></p>";	
							if($transfergdetail['transferDetail']!=''){
								echo "<p>".strip(trim($transfergdetail['transferDetail']))."</p>";					
							}	
						}  
					} 
				}  
				if($itineryDayData['serviceType'] == 'entrance'){  
					$wherent='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc'; 
					$rsent=GetPageRecord('*','quotationEntranceMaster',$wherent);  
					if(mysqli_num_rows($rsent) > 0){
						while($entrancelisting=mysqli_fetch_array($rsent)){  
							$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entrancelisting['entranceNameId'].'"');  
							$entranceData=mysqli_fetch_array($rsentn);    
							echo "<p>";
							echo "<b>".ucfirst($entranceData['entranceName'])." - </b>";
							if($resultpageQuotation['languageId'] != "0"){
							 	$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');  
								$checkrow = mysqli_num_rows($rs2);
								$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
								if($checkrow > 0){
						        	if(strlen(trim($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
						        		echo strip(trim($entranceData['entranceDetail']));
						        	}else{
						        		echo strip(trim($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']])); 
						        	}
						        } else{
									echo strip(trim($entranceData['entranceDetail']));
							    } 
							} else {
								echo strip(trim($entranceData['entranceDetail']));
						    } 
						    echo "</p>";
							//etnrance details here	
						}  
					} 
				}  

				// ferry
				if($itineryDayData['serviceType'] == 'ferry'){  
					$wherent='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc'; 
					$resferry=GetPageRecord('*','quotationFerryMaster',$wherent);  
					if(mysqli_num_rows($resferry) > 0){
						while($ferrylisting=mysqli_fetch_array($resferry)){  
							$rsferr=GetPageRecord('*','ferryPriceMaster','id="'.$ferrylisting['serviceid'].'"');  
							$ferryData=mysqli_fetch_array($rsferr);
							echo "<p>";
							?>
							<img src="<?php echo $fullurl.'images/ferry-default.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;
							<?php
							echo "<strong>".ucfirst(strip($ferryData['name']))." - </strong>".strip($ferryData['information']);
						
							echo "</p>";

						}  
					} 
				}  


				if($itineryDayData['serviceType'] == 'additional'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'"';						
					$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$additionalQuotData=mysqli_fetch_array($b);
						$rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
						$extraData=mysqli_fetch_array($rs1); 
						echo "<p>";?>
						<img src="<?php echo $fullurl.'images/additionalimage.jpg'; ?>" width="20" height="20"/>&nbsp;&nbsp;
						<?php 
						echo  "<b>".strip(ucfirst($additionalQuotData['name'])).' - '."</b>".strip($additionalQuotData['information']);
						echo "</p>";

					}
				}

				if($itineryDayData['serviceType'] == 'mealplan'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'"';						
					$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$mealplanQuotData=mysqli_fetch_array($b);
						echo "<p>";
						?><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;<?php
						echo "<b>".strip(ucfirst($mealplanQuotData['mealPlanName']))."</b>"; 
						echo "</p>";
					}
				} 
				if($itineryDayData['serviceType'] == 'guide'){  
					$b=$where2="";		
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'" ';	
					$b=GetPageRecord('*','quotationGuideMaster',$where2); 
					if(mysqli_num_rows($b) > 0){
						$guideQuotData=mysqli_fetch_array($b);
					 	
						$rs5="";  
						$rs5=GetPageRecord('*','tbl_guidesubcatmaster','id="'.$guideQuotData['guideId'].'"'); 
						$guideData=mysqli_fetch_array($rs5); 
						echo "<p>";
						echo "<b>".strip(ucfirst($guideData['name']))."</b>";
						echo "</p>";
					}
				} 
				if($itineryDayData['serviceType'] == 'activity'){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc';   
					$rs22=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where22);  
					if(mysqli_num_rows($rs22) > 0){   
						while($activitylisting=mysqli_fetch_array($rs22)){   
							$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id = "'.$activitylisting['otherActivityName'].'" and  status=1');  
							$quotationotherActivityData=mysqli_fetch_array($rs1);   
							echo "<p>";
							echo "<b>".ucfirst($quotationotherActivityData['otherActivityName'])."</b> - ";
							if($resultpageQuotation['languageId'] != '0'){
							 	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"'); 
								$checkrow = mysqli_num_rows($rs2);
								$quotationotherActivityLanData=mysqli_fetch_array($rs2);
								if($checkrow > 0){
						        	if(strlen(trim($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
						        		echo trim(strip($quotationotherActivityData['otherActivityDetail']))."";
						        	}else{
						        		echo trim(strip($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']])).""; 
						        	}
						        } else{
									echo trim(strip($quotationotherActivityData['otherActivityDetail']))."";
							    } 
							} 
						    else{
								echo trim(strip($quotationotherActivityData['otherActivityDetail']))."";
						    }
						    echo "</p>";
							//actvity detail
						}
					} 
				}  
				if($itineryDayData['serviceType'] == 'flight'){
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$rs22=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22);  
					if(mysqli_num_rows($rs22) > 0){
						$flightQuoteData=mysqli_fetch_array($rs22); 
							$select1='*';   
							$where1='id="'.$flightQuoteData['flightId'].'"';  
							$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_FLIGHT_MASTER_,$where1);  
							$flightData=mysqli_fetch_array($rs1);  
							
							if(date('H:i',strtotime($flightQuoteData['departureTime'])) <> '05:30'){
								$departureTime = "at ".date('Hi',strtotime($flightQuoteData['departureTime']))."/";
							}else{
								$departureTime ='';
							}	
							if(date('H:i',strtotime($flightQuoteData['arrivalTime'])) <> '05:30'){
								$arrivalTime = date('Hi',strtotime($flightQuoteData['arrivalTime'])).'Hrs';
							}else{
								$arrivalTime ='';
							}		 
							 
							$jfrom = getDestination($flightQuoteData['departureFrom']);
							$jto= getDestination($flightQuoteData['arrivalTo']);
							echo "<p>";
							?><img src="<?php echo $fullurl.'images/flight-icon.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;<?php
							echo strip(ucfirst($flightData['flightName'])).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass']);
							echo "</p>"; 
							// flight dettail
						 
					} 
				}  
				if($itineryDayData['serviceType'] == 'train'){
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
					if(mysqli_num_rows($rs22) > 0){
						while($trainQuoteData=mysqli_fetch_array($rs22)){  

							$where1='id="'.$trainQuoteData['trainId'].'"';  
							$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,$where1);  
							$trainData=mysqli_fetch_array($rs1);   
							//train details
							
							if(date('H:i',strtotime($trainQuoteData['departureTime'])) <> '05:30'){
								$dptTime = " at ".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
							}else{
								$dptTime ='';
							}	
							if(date('H:i',strtotime($trainQuoteData['arrivalTime'])) <> '05:30'){
								$avrTime = date('Hi',strtotime($trainQuoteData['arrivalTime']))."Hrs";
							}else{
								$avrTime ='';
							}		
							$journeyType="";
							$jfrom = getDestination($trainQuoteData['departureFrom']);
							$jto= getDestination($trainQuoteData['arrivalTo']);
							if($trainQuoteData['journeyType']=='overnight_journey'){ $journeyType = "(Overnight)"; }else{ $journeyType = "(Day)"; }
							echo "<p>";
							?>
							<img src="<?php echo $fullurl.'images/train-icon.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;<?php
							echo strip(ucfirst($trainData['trainName'])).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/ '.str_replace('_',' ',$trainQuoteData['trainClass']);
							echo "</p>"; 
						} 
					} 
				}
				// echo "<br />";
			}
			?>  

		</div>
	</td>
	</tr>
	</table>
		<?php 	 
		$day++; 
	} ?>		
	<br />
<table width="100%"  border="0" cellpadding="15" cellspacing="0" borderColor="#ccc">
<tr>
<td align="center" valign="top">
	<br>
	<!-- start Costing table -->
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" align="center"><strong>End of the tour</strong></td>
		</tr>
		<tr style="font-size:12px;page-break-before:always;">
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<div class="dayTitle" style="line-height: 28px;font-size: 16px;color: white;text-align: left;background-color: #133f6d;">&nbsp;&nbsp;&nbsp;&nbsp;Cost/ Term &amp; Conditions</div></td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="font-size:12px;">
			<?php if($resultpageQuotation['quotationType']==2){  ?>
				<table width="100%" border="1" cellspacing="0" cellpadding="6" bordercolor="#ccc">
					<?php
					if($resultpage['seasonType'] == 3){
						$colm = 2;
					}else{
						$colm = 1;
					}
					$hotCategory2 = explode(',',$resultpageQuotation['hotCategory']);
					// echo $resultpageQuotation['id'];
					$widttth = count($hotCategory2);
					$widths = 100/($colm*$widttth+1);
					$widths2 = $widths*$widttth;
					$colm1 = ($colm*$widttth+1);
					?>
					<!-- multiple category related prices -->
					<tr bgcolor="#F4F4F4">
						<td colspan="<?php echo $colm1; ?>" align="center" ><strong>Price based on selected room basis (In <?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>)</strong></td>
					</tr>
					<tr bgcolor="#F4F4F4">
						<td width="<?php echo $widths; ?>%" rowspan="2"  align="center" >
							<strong>No. of Pax</strong>
						</td>
						<?php
						for ($i = 1; $i <= $colm; $i++) { 
							if($resultpage['seasonType'] == 1 && $i == 1){ $seasonPeriod = "01 Apr - 30 Sept";  }
							if($resultpage['seasonType'] == 2 && $i == 1){ $seasonPeriod = "01 Oct - 31 March"; }
							if($resultpage['seasonType'] == 3 && $i == 1){ $seasonPeriod = "01 Apr - 30 Sept";  }
							else { $seasonPeriod = date('j M ',strtotime($resultpage['fromDate']))." - ".date('j M Y',strtotime($resultpage['toDate'])); }
							?>
							<td width="<?php echo $widths2; ?>%" colspan="<?php echo count($hotCategory2);?>" align="center"><strong>Tour&nbsp;Date&nbsp;[&nbsp;<?php echo $seasonPeriod; ?>]</strong></td>
							<?php
						}
						?>
					</tr>
					<tr bgcolor="#F4F4F4"> 
						<?php
						for ($i = 1; $i <= $colm; $i++) {
							foreach($hotCategory2 as $val2){
							$rsname1=GetPageRecord('*','hotelCategoryMaster','id="'.$val2.'"');
							$hotelCatData1=mysqli_fetch_array($rsname1);
							$hotelCategory = $hotelCatData1['hotelCategory'].' Star';
							?>
							<td width="<?php echo $widths; ?>%"  align="right"><strong><?php echo $hotelCategory; ?></strong></td>
							<?php
							}
						}
						?>
					</tr>
					<?php
					$rsn=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and country!=0 and status=1 and setDefault= 1');
					$resListingnn=mysqli_fetch_array($rsn);
					if($resListingnn['id'] == '' || $resListingnn['id'] == 0){
						$defaultCurr = 1;
					}else{
						$defaultCurr = $resListingnn['id'];
					}
					if($resultpageQuotation['currencyId'] == '' && $resultpageQuotation['currencyId'] == 0 ){
						$newCurr = $defaultCurr;
					}else{
						$newCurr = $resultpageQuotation['currencyId'];
					}
					
					$slabSql=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
					if(mysqli_num_rows($slabSql) > 0){
					while($slabsData=mysqli_fetch_array($slabSql)){
						$slabId = $slabsData['id'];
						if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['fromRange']==0 || $slabsData['toRange']==0){
							$paxrange2 = $slabsData['fromRange'];
						}else{
							$paxrange2 = $slabsData['fromRange']."-".$slabsData['toRange'];
						}
						${"final_cost".$slabId} = 0;
						?>
						<tr>
							<td width="<?php echo $widths; ?>%" align="center" ><strong><?php echo $paxrange2; ?>&nbsp;Pax</strong></td>
							<?php
							for ($i = 1; $i <= $colm; $i++) {
								foreach($hotCategory2 as $val2){
									$slabId11 = $slabId.'C'.$val2;
									${"proposalCost".$slabId11} = (${"proposalCost".$slabId11}+$resultpageQuotation['otherLocationCost']);
									?>
									<td width="<?php echo $widths; ?>%" align="right"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,${"proposalCost".$slabId11}); ?></td>
									<?php 
								}
							} ?>
						</tr>
						<?php
					}
					}
					?>
					<?php if($resultpageQuotation['isSupp_TRR'] == 1){ ?>
					<tr>
						<td width="<?php echo $widths; ?>%" align="center" ><strong>Single&nbsp;Suppliment</strong></td>
						<?php
						for ($i = 1; $i <= $colm; $i++) {
						foreach($hotCategory2 as $val2){
						$val2 = $val2.$i;
						${"singleSuppliment" . $val2} = 0;
						$singleSuppliment = ${"singleSuppliment" . $val2};
						?>
						<td width="<?php echo $widths; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$singleSuppliment); ?>&nbsp;<strong><?php echo getCurrencyName($resultpageQuotation['currencyId']); ?></strong></td>
						<?php } } ?>
					</tr>
					<tr>
						<td width="<?php echo $widths; ?>%" align="center" ><strong>Tripple&nbsp;Reduction</strong></td>
						<?php
						for ($i = 1; $i <= $colm; $i++) {
						foreach($hotCategory2 as $val2){
						$val2 = $val2.$i;
						$tripleRateReduction = ${"tripleRateReduction" . $val2};
						?>
						<td width="<?php echo $widths; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$tripleRateReduction); ?>&nbsp;<strong><?php echo getCurrencyName($resultpageQuotation['currencyId']); ?></strong></td>
						<?php } } ?>
					</tr>
					<?php } ?>
				</table>
			<?php }else{

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
									<th width="20%" align="right" <?php if($conspan>0){ ?> rowspan="2" <?php } ?> valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Total&nbsp;Cost<br>(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></th>
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
				<br /> 
				<br /> 
				<?php 
				} 
			?>
			</td>
		</tr>
		<!-- <tr>
			<td width="100%"  >
				<table width="100%" align="center">
				<tr>
					<td align="center" style="font-size:10px; color:#999999;"> The taxes and fees component includes - All government taxes
						
						levied for your bookings. Our service fee for booking
						
						and concierge support. All currency conversion charges
						
					wherever applicable </td>
				</tr>

			</table>
		</td>
		</tr> -->
	</table>
	<!-- end Costing table -->
</td>
</tr> 	
</table>
	
	<?php 

	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
	?> 
	<div class="dayTitle" style="line-height: 28px;font-size: 16px;color: white;text-align: left;background-color: #133f6d;">&nbsp;&nbsp;&nbsp;&nbsp;AIR FARE SUPPLEMENT</div>
	<table border="0" cellpadding="15" cellspacing="0" borderColor="#ccc" width="100%">
	<tr>
	<td>
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
			<tr>
				<th width="20%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Date</strong></th>
				<th width="18%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: right;"><strong>Sector</strong></th>
				<th width="25%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: right;"><strong>Flight/Timings</strong></th>
				<th width="18%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: right;"><strong>Class</strong></th>
				<th width="19%" align="right" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: right;"><strong>Fare</strong></th>
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
					echo date('l, dS F, Y',strtotime($flightQuotData['fromDate']));  
					?></strong></td>
					<td valign="middle" align="right"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
					<td valign="middle"><?php echo strip($flightQuotData['flightNumber']);  
					if(!empty($flightQuotData['departureTime']) || !empty($flightQuotData['arrivalTime'])){ echo " at ".date('Hi',strtotime($flightQuotData['departureTime']))."/".date('Hi',strtotime($flightQuotData['arrivalTime']))." Hrs"; }   ?></td>		
					<td valign="middle" align="right"><?php echo str_replace('_',' ',$flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
					<td valign="middle" align="right"><?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>&nbsp;<?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?>
				       </td>
	 			</tr>
			  <?php 
			} ?>
		  <tr>
		  	<td colspan="5" align="left"><strong>Note:</strong> This is the present airfare and is subject to change and we cannot guarantee the airfare before issuing the flight tickets.</td>
		  </tr>
		</table>
	</td>
	</tr>
	</table> 
	<br />
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
		<br />	
		<?php 
	}
	
	// $overviewText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $overviewText));
	// $highlightsText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $highlightsText));
	// $inclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $inclusion));
	// $exclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $exclusion));
	// $tncText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $tncText));
	// $specialText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $specialText));
	?>
	
	

	<br />

	<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px">
		
		<tr>
			
			<td style="padding-bottom: 5px !important;">
			<?php if($overviewText!=''){ ?> 
			<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Tour Overview
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($overviewText); ?>
		
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