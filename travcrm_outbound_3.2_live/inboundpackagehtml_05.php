<?php 
include "inc.php";  

 
$rsp = "";
$rsp = GetPageRecord('*', _QUOTATION_MASTER_, 'id="'.decode($_REQUEST['id']).'"');
$resultpageQuotation = mysqli_fetch_array($rsp);

$rs = '';
$rs = GetPageRecord('*', _QUERY_MASTER_, 'id="'.($resultpageQuotation['queryId']).'"');
$querydata = mysqli_fetch_array($rs);

$quotationId = $resultpageQuotation['id'];
$queryId = $querydata['id'];

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

// echo '<table cellpadding="10" cellspacing="0" bordercolor="#000000" > <tr> <td colspan="2" style="border: 5px solid #dfdfdf;display:none;">';
// include('loadGITCostSheet.php');
// echo '</td></tr></table>';
?>
<div class="calcostsheet"  style="display:none;">
	<?php  
	if($resultpage['travelType']==2){
		include_once("loadGITCostSheet_domestic.php"); 
	}else{
		include_once("loadGITCostSheet.php"); 
	}
	?>
	</div>
<div>
  <table width="725" align="center" border="0" cellpadding="10" cellspacing="0" bordercolor="#000000" style="border: 5px solid #dfdfdf;">
    <tr>
      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #ddd;">
          <tr>
            <td colspan="2" align="center" valign="top"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo;?>" width="600" height="93" /></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2" align="center" style="font-size:18px; font-weight:600;"><?php echo strip($querydata['subject']); ?></td>
    </tr>
    <tr>
		<?php 
		if($resultpageQuotation['image']!=''){
			$proposalImg = $fullurl.'dirfiles/'.str_replace(' ', '%20',$resultpageQuotation['image']);
			if(file_exists($proposalImg)==true){
				$proposalPhoto = $proposalImg;
			}else{
				$proposalPhoto = $fullurl.'images/sample-proposal.jpg';
			}
		}else{
			$proposalPhoto = $fullurl.'images/sample-proposal.jpg';
		}
		?>
		<td colspan="2"><img src="<?php echo $proposalPhoto; ?>" width="720" height="300"/></td>
	</tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#000000" style="font-size:12px;">
          <tr>
            <td width="50%" align="right"  style="color:#FF9900;"><div align="right"><strong>DESTINATION COVERED&nbsp;&nbsp;&nbsp;&nbsp;</strong></div></td>
            <td width="50%" align="left" style="color:#000; border-left:1px solid #ddd;"><strong>
              <?php 
				$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
				while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
					$tdestination.= stripslashes(getDestination($QueryDaysData['cityId'])).', ';
				}
				
				echo rtrim($tdestination,', ');
				?>
              </strong></td>
          </tr>
          <tr>
            <td width="50%" align="right"  style="color:#FF9900;"><div align="right"><strong>DURATION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div></td>
            <td width="50%" align="left"  style="color:#000;border-left:1px solid #ddd;"><strong> <?php echo $querydata['night']; ?> Nights/ <?php echo $querydata['night']+1; ?> Days </strong></td>
          </tr>
          <tr>
            <td width="50%" align="right"  style="color:#FF9900;"><div align="right"><strong>TRAVELLERS&nbsp;&nbsp;</strong></div></td>
            <td width="50%" align="left"  style="color:#000;border-left:1px solid #ddd;"><strong> <?php echo ($querydata['adult']+$querydata['child']+$querydata['infant']); ?> Adults</strong></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><img src="https://deboxglobal.co.in/travcrm/dirfiles/location-package.png" width="52" height="52" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:12px;">
          <tr>
            <td align="right" valign="top" ><table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                <tr>
                  <td align="center" valign="top" style="font-size:14px;"><?php  
					$QueryDaysQuery=GetPageRecord('cityId','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
					$numdest = mysqli_num_rows($QueryDaysQuery); 
					$cnt = 1; 
					$cityId = 0;
					while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){ 
						if($QueryDaysData['cityId'] != $cityId ){
							?>
		                    <span><?php echo getDestination($QueryDaysData['cityId']); ?></span>&nbsp;&nbsp;
		                    <?php if($numdest > $cnt){ ?>
		                    <img src="<?php echo $fullurl; ?>images/right-location.png" height="13" width="13" />&nbsp;&nbsp;
		                    <?php } 
							$cityId = $QueryDaysData['cityId'];
						$cnt++;
						}
					}
				?>
                  </td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;page-break-before:always;">
          <tr>
            <td width="98%" align="center" valign="top" ><strong style="    font-size: 30px;">Itinerary</strong></td>
          </tr>
          <?php  
			//------------------------------
			$quotationId=$resultpageQuotation['id'];
			$queryId=$resultpageQuotation['queryId'];    
			$day=1;
			$chkLast=0;  
			$startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($quotationData['fromDate'])));    
			$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus=0 order by srdate asc'); 
			while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
				$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate'])); 
				$dayId = $QueryDaysData['id'];
				$cityId = $QueryDaysData['cityId'];  
			?>
          <tr>
            <td align="center" valign="top" style="font-size:18px;" ><span style="line-height:10px;"> Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']); $destn = getDestination($cityId); ?>
              <?php if($querydata['dayWise'] == 1){ ?>
              - <?php echo date('l d-m-Y', strtotime($dayDate)); } ?> </span></td>
          </tr>
          <?php if($QueryDaysData['title']!='' || $QueryDaysData['description']!=''){ ?>
          <tr>
            <td align="left" valign="top" style=" text-align:center;"><span style="font-size: 14px; text-align:center;"><strong>
              <?php  echo urldecode(strip($QueryDaysData['title']));  ?>
              </strong></span><br />
              <br />
              <span style="text-align:justify;"><?php echo urldecode(strip($QueryDaysData['description']));?></span><br /></td>
          </tr>
          <?php } ?>
          <?php if(++$chkLast==mysqli_num_rows($QueryDaysQuery)){  ?>
          <tr>
            <td ><p style="text-align:center;font-size:16px;">
                <?php  echo "Standard checkout Time 12:00pm - Departure"; ?>
              </p></td>
          </tr>
		          <?php
		}	
		?>
          <tr>
            <td align="left" valign="top" ><?php  

			$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$startdatevar.'" and serviceType="hotel" order by srn asc,id desc'); 
			$sorting1=mysqli_fetch_array($b1);

			$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"';   
			$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
			if(mysqli_num_rows($rs22) > 0){
			?>
			<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;margin-bottom:10px;display:nones;">
			<?php while($hotellisting=mysqli_fetch_array($rs22)){  
			$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
			$hoteldetail=mysqli_fetch_array($rs1ee);   
			?>
			<tr>
			  <td width="15%" align="left" valign="top" style="font-size:12px;border-bottom: 1px solid #e8e8e8;"><img src="<?php echo $fullurl; ?><?php if($hoteldetail['hotelImage']!=''){ ?>packageimages/<?php echo str_replace(' ','%20',$hoteldetail['hotelImage']); ?><?php }else{ echo "images/hotelthumbpackage.png"; }  ?>" width="134" height="93"   /></td>
			  <td width="85%" align="left" valign="top" style="font-size:12px;border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
			      <tr>
			        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;"><strong><?php echo strip($hoteldetail['hotelName']);  ?>&nbsp;|&nbsp;
			          <?php 
			 $rs231er=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail['hotelCategoryId'].'"');  
			 $hotelCatNam=mysqli_fetch_array($rs231er);  
			 echo $hotelCatNam['hotelCategory']; ?> Star
			          </strong></td>
			      </tr>
			      <tr>
			        <td width="25%" style="color:#666666; font-size:13px;padding-left:0px;">Check-In</td>
			        <td width="25%" style="color:#666666; font-size:13px;">Room Type</td>
			        <td width="25%" style="color:#666666; font-size:13px;">Meal Plan</td>
			      </tr>
			      <tr>
			        <td width="25%" style=" padding-left:0px;"><strong>Address:</strong> <?php echo $hotelData['hotelAddress']; 
			 if($hotelQuotData['checkin'] != '' ){ ?>&nbsp;|&nbsp;Check-In : <?php echo urldecode($hotelQuotData['checkin']); ?>&nbsp;
			          <?php 
			}
			if($hotelQuotData['mealPlan'] ==3){ echo "Lunch,&nbsp;Dinner";} 
			else if($hotelQuotData['mealPlan'] ==9){ echo "Lunch";} 
			else{ } 
			?>
			        </td>
			        <td width="25%"><strong>
			          <?php 
				$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting['roomType'].'"');  
				$roomtype=mysqli_fetch_array($rs23qwe);  
				echo $roomtype['name'];   
				?>
			          </strong></td>
			        <td width="25%"><strong>
			          <?php
				$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$hotellisting['mealPlan'].'"'); 
				$mealplan=mysqli_fetch_array($rssda24); 
				echo $mealplan['name'];
				//.'-'.$mealplan['subname']
				?>
			          </strong></td>
			      </tr>
			    </table></td>
			</tr>
			<?php 
    } ?>
	</table>
	<?php 
	}	
	
	$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
	$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
	while($itineryDayData = mysqli_fetch_array($itineryDay)){  
	
		if($itineryDayData['serviceType'] == 'hotel' ){
			$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
			while($sorting1=mysqli_fetch_array($b1)){ 
				 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"';   
				$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
				if(mysqli_num_rows($rs22) > 0){
				?>
              <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;margin-bottom:10px;display:none;">
                <?php while($hotellisting=mysqli_fetch_array($rs22)){  
					//echo 'id="'.$hotellisting['supplierId'].'"';
					$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
					$hoteldetail=mysqli_fetch_array($rs1ee);   
					?>
                <tr>
                  <td width="15%" align="left" valign="top" style="font-size:12px;border-bottom: 1px solid #e8e8e8;"><img src="<?php echo $fullurl; ?><?php if($hoteldetail['hotelImage']!=''){ ?>packageimages/<?php echo str_replace(' ','%20',$hoteldetail['hotelImage']); ?><?php }else{ echo "images/hotelthumbpackage.png"; }  ?>" width="134" height="93"   /></td>
                  <td width="85%" align="left" valign="top" style="font-size:12px;border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;"><strong><?php echo strip($hoteldetail['hotelName']);  ?></strong></td>
                      </tr>
                      <tr>
                        <td width="25%" style="color:#666666; font-size:13px;padding-left:0px;">Category</td>
                        <td width="25%" style="color:#666666; font-size:13px;">Room Type</td>
                        <td width="25%" style="color:#666666; font-size:13px;">Meal Plan</td>
                      </tr>
                      <tr>
                        <td width="25%" style=" padding-left:0px;"><strong>
                          <?php 
							 $rs231er=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail['hotelCategoryId'].'"');  
							 $hotelCatNam=mysqli_fetch_array($rs231er);  
							 echo $hotelCatNam['hotelCategory']; ?> Star
                          </strong></td>
                        <td width="25%"><strong>
                          <?php 
								$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting['roomType'].'"');  
								$roomtype=mysqli_fetch_array($rs23qwe);  
								echo $roomtype['name'];   
								?>
                          </strong></td>
                        <td width="25%"><strong>
                          <?php
								$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$hotellisting['mealPlan'].'"'); 
								$mealplan=mysqli_fetch_array($rssda24); 
								echo $mealplan['name'].'-'.$mealplan['subname'];
								?>
                          </strong></td>
                      </tr>
                    </table></td>
                </tr>
                <?php } ?>
              </table>
              <?php 
				}
			}
		}
	
		if($itineryDayData['serviceType'] == 'transfer_remove' || $itineryDayData['serviceType'] == 'transportation_remove'){ 
			$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc');  
			if(mysqli_num_rows($rs22dd) > 0){
			?>
              <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;margin-bottom:10px;">
                <?php while($transferlisting=mysqli_fetch_array($rs22dd)){  
				$rs2ss=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
				$transfergdetail=mysqli_fetch_array($rs2ss);   

				?>
                <tr>
                  <td width="15%" align="left" valign="top" style="font-size:12px;border-bottom: 1px solid #e8e8e8;"><?php   
					$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleId'].'"');  
					$vename=mysqli_fetch_array($rs1aa);
					?>
                    <img src="<?php echo $fullurl; ?><?php if($vename['image']!=''){ ?>packageimages/<?php echo str_replace(' ','%20',$vename['image']); ?><?php }else{echo "images/transferthumbpackage.png";}  ?>" width="134" height="93"   /> </td>
                  <td width="85%" align="left" valign="top" style="font-size:12px; border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
                      <?php //if($itineryDayData['serviceType'] == 'transfer'){ ?>
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;"><strong><?php echo $transfergdetail['transferName']; ?></strong></td>
                      </tr>
                      <?php //} ?>
                      <tr>
                        <td colspan="4" style="padding-left:0px; font-size:12px;">Type:<strong> <?php echo 'Private';  ?> </strong> </td>
                      </tr>
                      <tr>
                        <td colspan="4" style="font-size:12px; padding-left:0px;">Vehicle: <?php echo $vename['name'];?> (Maxpax&nbsp;<?php echo $vename['maxpax'];?>)
                          <?php if($transferlisting['startTime']!=0){ echo  "-".date('h:i a',$transferlisting['startTime']).' - '; } ?>
                          <?php if($transferlisting['endTime']!=0){ echo date('h:i a',$transferlisting['endTime']); } ?></td>
                      </tr>
                      <tr>
                        <td colspan="4" style="font-size:12px; padding-left:0px;"><?php echo strip_tags($transfergdetail['transferDetail']); ?></td>
                      </tr>
                    </table></td>
                </tr>
                <?php }  ?>
              </table>
              <?php } 
		} 
		
		if($itineryDayData['serviceType'] == 'enroutes'){ 
			$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
			$rs22=GetPageRecord('*','quotationEnrouteMaster',$where22);  
			if(mysqli_num_rows($rs22) > 0){
			?>
              <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;font-size:12px;margin-bottom:10px;">
                <?php  
				while($enroutelisting=mysqli_fetch_array($rs22)){  
				$rs1=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id='.$enroutelisting['enrouteId'].'');  
				$enrouteData=mysqli_fetch_array($rs1);    
				?>
                <tr>
                  <td width="15%" align="left" valign="top" style="font-size:12px;border-bottom: 1px solid #e8e8e8;"><img src="<?php echo $fullurl; ?><?php if($enrouteData['enrouteImage']!=''){ ?>packageimages/<?php echo str_replace(' ','%20',$enrouteData['enrouteImage']); ?><?php }else{ echo "images/sightseeingthumbpackage.png";} ?>" width="134" height="93"   /> </td>
                  <td width="85%" align="left" valign="top" style="font-size:12px; border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;"  width="100%"><strong><?php echo strip($enrouteData['enrouteName']);  ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-left:0px; font-size:12px;" width="100%"><?php echo strip_tags($enrouteData['enrouteDetail']); ?></td>
                      </tr>
                    </table></td>
                </tr>
                <?php 
				}  
				?>
              </table>
              <?php 
			} 
		}  
		
		if($itineryDayData['serviceType'] == 'entrance'){  
			$wherent='quotationId="'.$QueryDaysData['quotationId'].'" and fromDate="'.$dayDate.'" order by id desc'; 
			$rsent=GetPageRecord('*','quotationEntranceMaster',$wherent);  
			if(mysqli_num_rows($rsent) > 0){
			?>
              <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;font-size:12px;margin-bottom:10px;">
                <?php  
				while($entrancelisting=mysqli_fetch_array($rsent)){  
				$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entrancelisting['entranceNameId'].'"');  
				$entranceData=mysqli_fetch_array($rsentn);    
				?>
                <tr>
                  <td width="15%" align="left" valign="top" style="font-size:12px;border-bottom: 1px solid #e8e8e8;"><img src="<?php echo $fullurl; ?><?php if($entranceData['entranceImage']!=''){ ?>packageimages/<?php echo str_replace(' ','%20',$entranceData['entranceImage']); ?><?php }else{ echo "images/sightseeingthumbpackage.png";} ?>" width="134" height="93"   /> </td>
                  <td width="85%" align="left" valign="top" style="font-size:12px; border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;"  width="100%"><strong><?php echo strip($entranceData['entranceName']);  ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-left:0px; font-size:12px;" width="100%"><?php echo strip_tags($entranceData['entranceDetail']); ?></td>
                      </tr>
                    </table></td>
                </tr>
                <?php 
				}  
				?>
              </table>
              <?php 
			} 
		}  
		
		if($itineryDayData['serviceType'] == 'activity'){ 
			$where22='quotationId="'.$QueryDaysData['quotationId'].'" and fromDate<="'.$dayDate.'" and toDate>="'.$dayDate.'" order by id desc';   
			$rs22=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where22);  
			if(mysqli_num_rows($rs22) > 0){   
			?>
              <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;margin-bottom:10px;">
                <?php while($activitylisting=mysqli_fetch_array($rs22)){   
			//echo ' otherActivityName="'.$activitylisting['otherActivityName'].'" and  status=1';
			$rs1a=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id="'.$activitylisting['otherActivityName'].'" and  status=1');  
			$quotationotherActivityData=mysqli_fetch_array($rs1a);   
			?>
                <tr>
                  <td width="15%" align="left" valign="top" style="font-size:12px;border-bottom: 1px solid #e8e8e8;"><img src="<?php echo $fullurl; ?><?php if($quotationotherActivityData['otherActivityImage']!=''){ ?>packageimages/<?php echo str_replace(' ','%20',$quotationotherActivityData['otherActivityImage']); ?><?php }else{ echo "images/sightseeingthumbpackage.png";} ?>" width="134" height="93"   /> </td>
                  <td width="85%" align="left" valign="top" style="font-size:12px; border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;"  width="100%"><strong><?php echo strip($quotationotherActivityData['otherActivityName']);  ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="4" style="padding-left:0px; font-size:12px;" width="100%"><?php echo strip_tags($quotationotherActivityData['otherActivityDetail']); ?></td>
                      </tr>
                    </table></td>
                </tr>
                <?php } ?>
              </table>
              <?php 
			} 
		}  
		
		if($itineryDayData['serviceType'] == 'additional'){ 
			$where22='quotationId="'.$QueryDaysData['quotationId'].'" and fromDate<="'.$dayDate.'" and toDate>="'.$dayDate.'" order by id desc';   
			$rs22=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where22);  
			if(mysqli_num_rows($rs22) > 0){   
			?>
              <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;font-size:12px;margin-bottom:10px;">
                <tr>
                  <td width="85%" align="left" valign="top" style="font-size:12px; border-bottom: 0px solid #e8e8e8;">&nbsp;</td>
                </tr>
                <tr>
                  <td width="85%" align="left" valign="top" style="font-size:13px;"><strong>ADDITIONAL&nbsp;REQUIREMENT</strong></td>
                </tr>
                <?php while($activitylisting=mysqli_fetch_array($rs22)){ ?>
                <tr>
                  <td width="85%" align="left" valign="top" style="font-size:12px; border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;"  width="100%"><strong><?php echo strip($activitylisting['name']);  ?></strong></td>
                      </tr>
                    </table></td>
                </tr>
                <?php } ?>
                <tr>
                  <td width="85%" align="left" valign="top" style="font-size:12px;">&nbsp;</td>
                </tr>
              </table>
              <?php 
			} 
		} 

		if($itineryDayData['serviceType'] == 'flight'){

			$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
			$rs22=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22);  
			if(mysqli_num_rows($rs22) > 0){
		?>
              <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;font-size:12px;margin-bottom:10px;">
                <?php while($activitylisting=mysqli_fetch_array($rs22)){  
			$select1='*';   
			$where1='id="'.$activitylisting['flightId'].'"';  
			$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_FLIGHT_MASTER_,$where1);  
			$activitydetail=mysqli_fetch_array($rs1);   
	   
		?>
                <tr>
                  <td width="85%" align="left" valign="top" style="font-size:12px; border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;" width="100%"><strong><?php echo strip($activitydetail['flightName']);  ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;" width="100%"><strong>Departure&nbsp;Time:</strong><?php echo date('H:i',strtotime($activitylisting['departureTime']));  ?></td>
                      </tr>
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;" width="100%"><strong>Departure: </strong>
                          <?php 
				$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['departureFrom'].'"'); 
				$GuideData51=mysqli_fetch_array($rs51); 
				echo strip($GuideData51['name']);   
				?>
                          | <strong>Arrival: </strong>
                          <?php 
				$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['arrivalTo'].'"'); 
				$GuideData51=mysqli_fetch_array($rs51); 
				echo strip($GuideData51['name']);  
				?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-left:0px; font-size:12px;"  width="100%"><strong>Flight Number: </strong><?php echo strip_tags($activitylisting['flightNumber']); ?> | <strong>Flight Class: </strong><?php echo strip_tags($activitylisting['flightClass']); ?></td>
                      </tr>
                    </table></td>
                </tr>
                <?php } ?>
              </table>
              <?php } 
		}  
 
		if($itineryDayData['serviceType'] == 'train'){
			$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
			$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
			if(mysqli_num_rows($rs22) > 0){
				?>
              <table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;font-size:12px;margin-bottom:10px;">
                <?php 
				while($activitylisting=mysqli_fetch_array($rs22)){  

					$where1='id="'.$activitylisting['trainId'].'"';  
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,$where1);  
					$activitydetail=mysqli_fetch_array($rs1);   
			   
					?>
                <tr>
                  <td width="85%" align="left" valign="top" style="font-size:12px; border-bottom: 1px solid #e8e8e8;"><table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;" width="100%"><strong><?php echo strip($activitydetail['trainName']);  ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;" width="100%"><strong>Journey Type: </strong>
                          <?php 
								if($activitylisting['journeyType'] == 'overnight_journey'){  echo "Overnight"; }
								else{  echo "Day"; }  
								?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4" style="color:#666666; font-size:13px;padding-left:0px;" width="100%"><strong>Departure&nbsp;Time:</strong><?php echo date('H:i',strtotime($activitylisting['departureTime']));  ?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-left:0px; font-size:12px;"  width="100%"><strong> Train Number: </strong><?php echo strip_tags($activitylisting['trainNumber']); ?> | <strong>Train Class: </strong><?php echo strip_tags($activitylisting['trainClass']); ?> </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-left:0px; font-size:12px;"  width="100%"><strong>Departure: </strong>
                          <?php 
								$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['departureFrom'].'"'); 
								$GuideData51=mysqli_fetch_array($rs51); 
								echo strip($GuideData51['name']);  
								?>
                          | <strong>Arrival: </strong>
                          <?php 
								$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['arrivalTo'].'"'); 
								$GuideData51=mysqli_fetch_array($rs51); 
								echo strip($GuideData51['name']);  
								?>
                        </td>
                      </tr>
                    </table></td>
                </tr>
                <?php } ?>
              </table>
              <?php 
			} 
		}  
		
	 }
	?></td>
          </tr>
          <tr>
            <td align="left" valign="top" >&nbsp;</td>
          </tr>
          <?php 
$n++; 
$day++;
}  
?>
          <tr>
            <td align="center" valign="top">

            <table width="100%" border="1" cellpadding="7" cellspacing="0" bordercolor="#ccc" >
                <tr style="font-size:13px;">
                  <td valign="middle" bgcolor="#F4F4F4"><strong>City</strong></td>
                  <td align="center" bgcolor="#F4F4F4" valign="middle" ><strong>Night</strong></td>
                  <?php if($querydata['dayWise'] == 1){ ?>
                  <td valign="middle" bgcolor="#F4F4F4"><strong>Date</strong></td>
                  <?php } ?>
				  <?php if($moduleType == 2){ ?>
				  <td valign="middle"  bgcolor="#F4F4F4"><strong>Escort&nbsp;Hotel</strong></td>
                  <?php } ?>
				  <?php
					$hotCategory = explode(',',$resultpageQuotation['hotCategory']);				
					foreach($hotCategory as $val){ 
						$rsname=GetPageRecord('hotelCategory','hotelCategoryMaster','id='.$val.'');  
						$hotelCatData=mysqli_fetch_array($rsname);
					  	?>
					  	<td valign="middle"  bgcolor="#F4F4F4"><strong>Hotel&nbsp;[<?php echo $hotelCatData['hotelCategory'];?>*]</strong></td>
					  	<?php 
					} 	
					?>
                </tr>
                <?php 
				$b=""; 
 				$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'"  group by fromDate order by fromDate asc');
				while($hotelQuotData=mysqli_fetch_array($b)){
					 
					$isEarlyCheckIn = "";
					if($hotelQuotData['fromDate'] < $quotationData['fromDate']){
						$isEarlyCheckIn = "&nbsp;|&nbsp;Early&nbsp;CheckIn";
					}
					$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
					$hotelData=mysqli_fetch_array($d);
					
					$start = strtotime($hotelQuotData['fromDate']);
					$end = strtotime($hotelQuotData['toDate']);
					$days_between='';
					$days_between = ceil(abs($end - $start) / 86400);
					?>
					<tr style="font-size:12px;">
					<td valign="middle"><?php echo getDestination($hotelQuotData['destinationId']).$isEarlyCheckIn; ?></td>
					<td align="center" valign="middle"><?php echo $days_between+1; ?> N</td>
					<?php if($querydata['dayWise'] == 1){ 
					$dayDates = date('Y-m-d', strtotime('+1 day', strtotime($hotelQuotData['toDate'])));
					//01 – 03 Oct’2020
					?>
					<td valign="middle"><?php echo date('d',strtotime($hotelQuotData['fromDate']));  ?>&nbsp;-&nbsp;<?php echo date("d M\'Y",strtotime($dayDates));  ?></td>
					<?php } ?>
					<?php 
					if($moduleType == 2){ 
					$whereHot="";
					$whereHot=GetPageRecord('supplierId,categoryId','quotationHotelMaster','quotationId="'.$quotationId.'" and fromDate="'.$hotelQuotData['fromDate'].'" and toDate="'.$hotelQuotData['toDate'].'" and escortHotelStatus=1 order by id asc');  
					$day = 1;
					if(mysqli_num_rows($whereHot) > 0){
						while($resHotel=mysqli_fetch_array($whereHot)){
						
							$rsname="";
							$rsname=GetPageRecord('hotelCategory','hotelCategoryMaster','id="'.$resHotel['categoryId'].'"');  
							$hotelCatData=mysqli_fetch_array($rsname);
						
							$rsname=GetPageRecord('hotelName,hotelCategoryId',_PACKAGE_BUILDER_HOTEL_MASTER_,'id='.$resHotel['supplierId'].'');  
							$hotelname=mysqli_fetch_array($rsname);
							?>
							<td valign="middle" ><?php echo $hotelCatData['hotelCategory']." Star - ".$hotelname['hotelName'];?></td>
							<?php 
							$day++;
						}
					}	 
					else{
						?>
						<td valign="middle" bgcolor="#F4F4F4"><strong>&nbsp;</strong></td>
						<?php 
					}
				}
				 
				?>
				<?php
				$hotCategory = explode(',',$resultpageQuotation['hotCategory']);				
				foreach($hotCategory as $val){
					$whereHot="";
					$whereHot=GetPageRecord('supplierId,categoryId','quotationHotelMaster','quotationId="'.decode($_REQUEST['id']).'" and fromDate="'.$hotelQuotData['fromDate'].'" and toDate="'.$hotelQuotData['toDate'].'" and categoryId="'.$val.'" group by categoryId order by id asc');  
					$day = 1;
					if(mysqli_num_rows($whereHot) > 0){
						while($resHotel=mysqli_fetch_array($whereHot)){
							
							$rsname=GetPageRecord('hotelName,hotelCategoryId',_PACKAGE_BUILDER_HOTEL_MASTER_,'id='.$resHotel['supplierId'].'');  
							$hotelname=mysqli_fetch_array($rsname);
							?>
							<td valign="middle" ><?php echo $hotelname['hotelName'];?></td>
							<?php 
							$day++;
						}
					}	 
					else{
						?>
						<td valign="middle" bgcolor="#F4F4F4"><strong>&nbsp;</strong></td>
						<?php 
					}
				} 	
				?>
				</tr>
				<?php } ?>
            </table></td>
          </tr>
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
							<td colspan="2" align="center"><strong>Cost/ Term &amp; Conditions</strong></td>
						</tr>
						<tr>
							<td colspan="2" align="center" style="border-bottom:1px #ccc solid;" >&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" align="center">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" align="center" style="font-size:12px;">
								<table width="100%" border="1" cellspacing="0" cellpadding="6" bordercolor="#ccc">
									<?php
									
									if($querydata['seasonType'] == 3){
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
									<tr bgcolor="#F4F4F4">
										<td colspan="<?php echo $colm1; ?>%" align="center" ><strong>Price based on selected room basis</strong></td>
									</tr>
									<tr bgcolor="#F4F4F4">
										<td width="<?php echo $widths; ?>%" rowspan="2"  align="center" ><strong>No. of Pax</strong></td>
										<?php
											for ($i = 1; $i <= $colm; $i++) {
												if($querydata['seasonType'] == 1 && $i == 1){ $seasonPeriod = "01 Apr - 30 Sept";  }
												if($querydata['seasonType'] == 2 && $i == 1){ $seasonPeriod = "01 Oct - 31 March"; }
												if($querydata['seasonType'] == 3 && $i == 1){ $seasonPeriod = "01 Apr - 30 Sept";  }
												else { $seasonPeriod = "01 Oct - 31 March"; }
										?>
										<td width="<?php echo $widths2; ?>%" colspan="<?php echo count($hotCategory2);?>" align="center"><strong>Validity&nbsp;[&nbsp;<?php echo $seasonPeriod; ?>]</strong></td>
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
									if($quotationData['currencyId'] == '' && $quotationData['currencyId'] == 0 ){
									$newCurr = $defaultCurr;
									}else{
									$newCurr = $quotationData['currencyId'];
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
										${"proposalCost".$slabId11} = (${"proposalCost".$slabId11}+$quotationData['otherLocationCost']);
										?>
										<td width="<?php echo $widths; ?>%" align="right"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,${"proposalCost".$slabId11}); ?></td>
										<?php }
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
										<td width="<?php echo $widths; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$singleSuppliment); ?>&nbsp;<strong><?php echo getCurrencyName($quotationData['currencyId']); ?></strong></td>
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
										<td width="<?php echo $widths; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$tripleRateReduction); ?>&nbsp;<strong><?php echo getCurrencyName($quotationData['currencyId']); ?></strong></td>
										<?php } } ?>
									</tr>
									<?php } ?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center" style="font-size:12px;">&nbsp;</td>
						</tr>
						<tr>
							<td width="100%"  ><table width="100%" align="center">
								<tr>
									<td align="center" style="font-size:10px; color:#999999;"> The taxes and fees component includes - All government taxes
										
										levied for your bookings. Our service fee for booking
										
										and concierge support. All currency conversion charges
										
									wherever applicable </td>
								</tr>
							</table></td>
						</tr>
					</table>
					<!-- end Costing table -->
					</td>
          </tr> 
          <tr>
            <td align="left" valign="top" style="font-size:12px;color:#333333;" ><strong style="font-size:15px;">Inclusion</strong><?php echo (str_replace('&nbsp;',' ',(stripslashes($inclusion)))); ?></td>
          </tr>
          <tr>
            <td align="left" valign="top" style="font-size:12px;color:#333333;" ><strong style="font-size:15px;">Exclusion</strong><?php echo (str_replace('&nbsp;',' ',(stripslashes($exclusion)))); ?></td>
          </tr>
          <tr>
            <td align="center" valign="top"><div style="font-size:12px;"> <a href="http://www.deboxglobal.com/travcrm.html" target="_blank" style="color:#666666;">Generated by TravCRM</a></div></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</div>
