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
		body{ font-family: 'Source Sans Pro', sans-serif; font-weight: 400;  }
		strong{ font-family: 'Source Sans Pro', sans-serif; font-weight: 600; } 
     	@page {
            margin: 0;
            margin-bottom: 80px;
            margin-top: 50px;
        }
        body{
			font-size: 14px;
			color: #3c3a3a;
			font-weight: 400;
			font-family: 'Source Sans Pro', sans-serif;
        }
	   	footer {
            position: fixed; 
            bottom: -80px; 
            left: 0cm; 
			/*background-color: #ff0000;*/
            right: 0cm; 
            height: 80px; 
        }   
        /*end teseting*/
	    
		.main-container{
			display: block;
			margin: 0px auto;
			position: relative; 
			border: 0px solid #ccc;
			background-color: #fff;
		} 
		.blank_line{
			margin: 5px 0;
			height: 0;
			width: 0;
		}
		.hr_line{
			margin: 40px 0px; 
		} 
		ul {
			list-style: none;
			color: #424244;
			list-style-position: outside;
			padding: 0;
    		margin: 0;
		}
		ul li{
		    margin-bottom: 10px;
		}
		
	    .table-service{
			page-break-inside: avoid;
			page-break-after: auto;
			page-break-before: auto;
	    }
	    .row-service{
	    	page-break-inside: avoid;
	    	page-break-after: auto;
	    	page-break-before: auto;
	    }
	    .row-titleDesc{ 
	    	page-break-inside: auto;
	    	page-break-after: auto;
	    	page-break-before: auto;
	    }
	    .dayTitle{
	        line-height: 22px;
		    font-size: 25px;
		    padding: 5px;
		    color: white;
		    padding-bottom: 8px;
		    margin-bottom: 10px;
		    text-align: center;
		    background-color: #133f6d;
	    }
	    .serviceTitle{
	      	font-size: 18px;
		    line-height: 20px;
		    color: #133f6d;
		    font-weight: 700;
	    }
	    .subHeading{
	      	font-size: 15px;
		    line-height: 20px;
		    color: #133f6d;
		    font-weight: 700;
	    }
	    .serviceDesc{
	    	text-align: justify;
	    	page-break-inside: auto;
	    	font-size: 14px;
		    padding-bottom: 5px;
		    line-height: 18px;
	    }
	    table{
	    	border-collapse: collapse;
	    }
	    table.borderedTable{
	    	width: 100%;
	    }
	    table.borderedTable th{
	    	background-color: #133f6d;
	    	color: #ffffff;
	    	text-align: left;
	    }
	    .calcostsheet{
	    	display:none;
	    	visibility: hidden;
	    	height: 0;
	    	width: 0;
	    	position: fixed;
	    	left: 0;
	    	top: 0;
	    }
	    .docTitle{
			background-color: #133f6d;
		    padding: 4px 29px;
		    color: #fff;
		    font-weight: bold;
		    font-size: 20px;
		    position: relative;
		    display: inline-block;
		    height: 33px;
		    line-height: 20px;
		}
		.docTitleArrow{
		    position: absolute;
		    right: -33px;
		    top: 0px;
		    height: 0;
		    width: 0;
		    border-left: 0px solid #133f6d00;
		    border-bottom: 41px solid #133f6d;
		    border-right: 33px solid #fff0;
		    border-top: 0px solid #133f6d;
		}
		.proposalHeader{
			margin-top: -50px;
			padding: 20px 0px 15px 0px;
			background-color: #fde9e3;
		}
		.proposalHeader img{
			margin-right: 30px;
		}
		/*docBanner*/
		.docBanner{
			position: relative;
		}
		.bannerText{
		    position: absolute;
		    top: 30px;
		    left: 30px;
		    right: 30px;
		    text-align: left;
		    display: block; 
		}
		.bannerText strong{
			font-weight: 600;
		}
		.colorSize1{
		    color: #fff;
		    font-size: 27px;
		}
		.colorSize2{
		    font-size: 16px;
		}
		.colorSize3 strong{
			font-size: 22px;
			padding: 0px 10px;
		}
		.text1{
		    font-weight: 600;
		    display: block;
		}
		.text2{
			font-weight: 700;
			display: block;
		}
		.overviewBox{
			padding: 60px;
			padding-bottom: 10px;
			display: block;
			page-break-after: always;
		}
		.overviewBox .serviceTitle{
			padding-bottom: 10px; 
			display: block;
			color: #424244;
		}
		.overviewBox .serviceDesc{
			padding-bottom: 10px;
		    font-size: 16px;
			color: #424244;
			font-weight: 400;
			font-family: 'Source Sans Pro', sans-serif;
		}
		.dayItineraryInfo{
			padding: 30px;
			padding-bottom: 10px;
		    /*background-color: #ccc;*/
		    display: block;
		    position: relative;
		    font-size: 16px;
			color: #424244;
			font-weight: 400;
		    font-family: 'Source Sans Pro', sans-serif;
		}
		.itineraryTitle{
			text-align: justify;
		    page-break-inside: auto;
		    padding-bottom: 20px;
		}
		.itineraryDesc{
			text-align: justify;
		    page-break-inside: auto;
		    padding-bottom: 20px;
		}
	    .text-center{
	    	text-align: center!important;
	    }
	    .valignBottom{

	    }
	    .pd30{
	    	padding: 30px;
	    }
	    .w60{
	    	width: 60%;
	    }
		.imgbox{
			width: 200px;
			height: 130px;
			border-radius: 10px;
			overflow: hidden;
		    border: 1px solid #bebaba;
		    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
		}
		.imgbox img{ 
			object-fit: cover;
		}
	</style>
</head>
<body >
<footer >
	<img src="<?php echo $fullurl; ?>images/company-info-footer.png"  width="100%" />
</footer>
<div class="calcostsheet">
<?php include_once("loadFITCostSheet.php"); ?>
</div>
    
<div class="main-container" style="width: 800px;">
   
	<table class="firstpage proposalHeader" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="middle">
				<div class="docTitle">Itinerary or Proposal
					<span class="docTitleArrow"></span>
				</div>
			</td>
			<td align="right" valign="middle">
				<img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterLogo;?>" width="80px" >
			</td>
		</tr>
	</table>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="center" valign="top">
				<div class="docBanner"><?php 
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
					?><img src="<?php echo $proposalPhoto; ?>" width="100%" height="300">
					<div class="bannerText colorSize1">
						<span class="text1"><?php echo ($resultpageQuotation['night']+1).' DAYS'; ?></span>
						<span class="text2">GOLDEN TRIANGLE<?php //echo strip($quotationSubject); ?></span> 
					</div>
				</div>
			</td>
		</tr>
	</table>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="center">
				<div class="docBanner">
					<img src="<?php echo $fullurl.'images/banner-bottom-img.jpg'; ?>" width="100%" height="210">
					<div class="bannerText colorSize2">
						<table width="100%" border="0" cellpadding="10" cellspacing="0" >
						<tr>
						<td width="10%"></td>
						<td>DESTINATION COVERED<br><strong><?php 
							$locationQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
								while($locationCoverD=mysqli_fetch_array($locationQuery)){
								$locationCovered.= stripslashes(getDestination($locationCoverD['cityId'])).', ';
							}
							echo rtrim($locationCovered,', ');
							?></strong>
						</td>
						<td>DURATION<br>
							<strong><?php 
								echo $resultpageQuotation['night'].' Nights / '.($resultpageQuotation['night']+1).' Days'; 
							?></strong>
						</td>
						<td>TRAVELLERS<br>
							<strong><?php echo ($resultpageQuotation['adult']+$resultpageQuotation['child']); ?> Adults</strong>
						</td>
						<td width="5%"></td>
						</tr> 
						</table>
						<br />
						<br />
						<table width="100%" border="0" cellpadding="10" cellspacing="0" class="colorSize3" >
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
					</div>
				</div>
			</td>
		</tr>
	</table>
    <div class="overviewBox">
    	<strong class="serviceTitle">TOUR Overview</strong>
		<div class="serviceDesc"><?php  
					echo strip_tags("Golden Triangle Tour Package is the best bet of Indian tourism. Every year thousands of travellers visit explore the beautiful cities of Delhi-Agra-Jaipur. These three cities of Golden Triangle tour are a blend of awe inspiring culture and age old history of India. The main attractions of Golden Triangle trip are obviously th symbolises eternal love of an emperor for his beloved wife, the capital city of Delhi showcasing beautiful contrast of old an civilization, the dashing Amer Fort standing high atop Aravali hills in Jaipur, walled town of Fatehpur Sikri and many other historic and cultural sites. De Box Holidays has made it convenient for the travel Golden Triangle tours with group of like-minded people who join the handpicked to make the journey an everlasting experience for the travellers. Choose from any of the available dates. De Box Holidays has made it convenient for the travel Golden Triangle tours with group of like-minded people who join the handpicked to make the journey an everlasting experience for the travellers. Choose from any of the available dates. "); 
	 ?></div>
	</div>
    <?php  
	// DAY LOOP START
	$day=1;
	$queryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($queryDaysData=mysqli_fetch_array($queryDaysQuery)){  
		$dayDate = date('Y-m-d',strtotime($queryDaysData['srdate']));
		$dayId = $queryDaysData['id']; 
		?>  
		<div class="docTitle w60">Day <?php echo $day; ?> - <?php echo getDestination($queryDaysData['cityId']); $destn = getDestination($queryDaysData['cityId']); ?><?php if($resultpage['dayWise'] == 1){ ?> | <?php echo date('l d-m-Y', strtotime($dayDate)); } 	?><span class="docTitleArrow"></span>
		</div>
		<div class="dayItineraryInfo"><?php 
			if($queryDaysData['title']!=''){ 
				?>
				<div class="itineraryTitle">
					<?php
				echo strip(urldecode($queryDaysData['title']));
				?>
				</div>
				<?php
			}
			if($queryDaysData['description']!=''){ 
			?>
			<div class="itineraryDesc">
				<?php
				$html = urldecode(strip($queryDaysData['description']));
				$html = str_replace('<p>&nbsp;</p>', '<br />', $html);
				$html = str_replace('<p>', '<div>', $html);
				echo $html = str_replace('</p>', '</div>', $html);
				?>
				</div>
				<br />
				<br />
			<?php
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
					    }
					    if($hotellisting['isForeignEscort']==1){
					        $hotelTypeLable .= "Foreign Escort,";
					    }
					    if($hotellisting['isGuestType']==1){
					        $hotelTypeLable .= "Guest,";
					    } 
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
						$hoteldetail=mysqli_fetch_array($rs1ee);   
					?>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service hotel">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
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
						?></div></td>
						<td width="70%" align="left" valign="middle" >
							<table border="0" cellpadding="5" cellspacing="0" >
								<tbody>
									<tr>
										<td colspan="3"><strong class="serviceTitle"><?php  echo rtrim($hotelTypeLable,',')." Hotel | "; echo strip($hoteldetail['hotelName']);  ?></strong></td>
									</tr>
									<tr> 
										<td width="15%" ><strong class="subHeading">Category</strong></td> 
										<td width="20%" ><strong class="subHeading">Room Type</strong></td> 
										<td width="30%" ><strong class="subHeading">Meal Plan</strong></td> 
									</tr> 
									<tr> 
										<td width="15%" valign="bottom" ><?php 
										 	$rs231er=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail['hotelCategoryId'].'"');  
										 	$hotelCatNam=mysqli_fetch_array($rs231er);  
										 	echo '<img src="'.$fullurl.'images/starh'.$hotelCatNam['hotelCategory'].'.png" height="20">';
										 	?>
										</td>
										<td width="20%"><?php 
											$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting['roomType'].'"');  
											$roomtype=mysqli_fetch_array($rs23qwe);  
											echo $roomtype['name'];   
											?></td> 
									 	<td width="30%"><?php
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
					<div class="hr_line">
						<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
					</div>
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
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service transfer">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><?php   
								$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');
								$vename=mysqli_fetch_array($rs1aa); 
								?><div class="imgbox"><img src="<?php echo $fullurl; ?>images/transfer.jpeg" width="200" height="130" /></div>
							</td>
							<td width="70%" align="left" valign="middle" >
							   <table width="100%" border="0" cellpadding="5" cellspacing="0" >
								 	<tr>
								 		<td colspan="3" align="left" >
								 			<strong class="serviceTitle"><?php echo ucfirst($transfergdetail['transferName']); ?></strong>
								 		</td>
							     	</tr> 
								  	<tr>
									 	<td align="left" width="15%" ><strong class="subHeading">Type</strong></td>
									 	<td align="left" width="20%" ><strong class="subHeading">VehicleName</strong></td>
									 	<td align="left" width="25%" ><strong class="subHeading">VehicleType</strong></td> 
								  	</tr>
								  	<tr>
									 	<td align="left" width="15%" >Private</td>
									 	<td align="left" width="20%" ><?php echo  $vename['model']; ?> </td>
									 	<td align="left" width="25%" ><?php  echo getVehicleTypeName($vename['carType']);?></td> 
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
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
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
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
				            $rs3='';
				            $rs3=GetPageRecord('*','imageGallery',' parentId = "'.$enrouteData['id'].'" and galleryType="enroute" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
				            $resListing3=mysqli_fetch_array($rs3);
			            	if($resListing3['fileId']!=''){ 
				            	$enrouteImage = geDocFileSrc($resListing3['fileId']);
				            	if(file_exists($enrouteImage)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ','%20',$enrouteImage).'" width="200" height="130">';
				            	}else{
				            		echo '<img src="'.$fullurl.'images/activity.jpg" width="200" height="130">'; 
				            	}
				            }else{ 
				              echo '<img src="'.$fullurl.'images/activity.jpg" width="200" height="130">'; 
				            } 
				          	?></div></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr>
											<td ><strong class="serviceTitle"><?php echo ucfirst($enrouteData['enrouteCity']);  ?> | <?php echo strip($enrouteData['enrouteName']);  ?></strong></td>
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
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
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
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
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
				          	?></div></td>
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
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
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
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
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
					            ?></div>
					        </td>
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
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
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
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><img src="<?php echo $fullurl; ?>docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="200" height="130"></div>
							</td>
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
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
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
							$dptTime = "/@".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
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
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service train">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><img src="<?php echo $fullurl; ?>images/train.jpg" width="200" height="130" /></div>
							</td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" > 
									<tr>
										<td colspan="5" ><div class="serviceTitle"><?php  echo rtrim($trainTypeLable,',')." Train ";  echo strip($trainData['trainName']);  ?></div></td>
									</tr>
									<tr> 
										<td width="15%" ><strong>Journey&nbsp;Type</strong></td> 
										<td width="20%" ><strong>TrainNumber</strong></td> 
										<td width="15%" ><strong>TrainClass</strong></td> 
										<td width="25%" ><strong>Dept-Arr</strong></td> 
										<td width="25%" ><strong>Dept-Arr&nbsp;Time</strong></td> 
									</tr> 
									<tr> 
										<td width="15%" ><?php echo $journeyType; ?></td> 
										<td width="20%" ><?php echo strip($trainQuoteData['trainNumber']); ?></td> 
										<td width="15%" ><?php echo strip($trainQuoteData['trainClass']); ?></td> 
										<td width="25%" ><?php echo ucfirst($jfrom).'-'.ucfirst($jto); ?></td> 
										<td width="25%" ><?php echo trim($dptTime).'-'.trim($avrTime); ?></td> 
									</tr>
								</table>	
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
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
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service flight">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox">
								<img src="<?php echo $fullurl; ?>images/flight.jpg" width="200" height="130" />
							</div>
							</td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" > 
									<tr>
										<td colspan="4" ><strong class="serviceTitle"><?php  echo rtrim($flightTypeLable,',')." Flight ";  echo strip($flightData['flightName']);  ?></strong></td>
									</tr>
									<tr> 
										<td width="20%"><strong>FlightNumber</strong></td> 
										<td width="20%"><strong>FlightClass</strong></td> 
										<td width="30%"><strong>Departure-Arrival</strong></td> 
										<td width="30%"><strong>Departure-Arrival Time</strong></td> 
									</tr> 
									<tr> 
										<td width="20%"><?php echo strip($flightQuoteData['flightNumber']); ?></td> 
										<td width="20%"><?php echo strip($flightQuoteData['flightClass']); ?></td> 
										<td width="30%"><?php echo ucfirst($jfrom).'-'.ucfirst($jto); ?></td> 
										<td width="30%"><?php echo trim($dptTime).'-'.trim($avrTime); ?></td> 
									</tr>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php 
						
					}
				}
				// END OF SERVICES
			}
			?>
		</div>

		<?php
	$n++; 
	$day++;
	}
	?>
	<br />	
	<br />	
	<div class="dayItineraryInfo ">
		<img src="<?php echo $fullurl; ?>images/end-of-tour.png" width="100%" />
	</div>
	<br />
	<br /> 
	<div class="docTitle w60">HOTEL PROPOSED<span class="docTitleArrow"></span></div>
	<br />
	<br /> 
	<div class="table-service pd30" >
		<div class="serviceTitle">Hotels Proposed</div>
		<table border="1" cellpadding="8" cellspacing="0" borderColor="#ccc" class="borderedTable table-service">
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
		<!-- Total Tour Cost and per person basis costs details -->
		<br />
		<br /> 
		<div class="serviceTitle">QUOTATION</div>
		<table border="1" cellpadding="8" cellspacing="0" borderColor="#ccc" class="borderedTable table-service" >
			<tr>
				<?php
				$conspan = 0;
				if($ppCostONSingleBasis>0){ $conspan=$conspan+1; }
				if($ppCostONDoubleBasis>0){ $conspan=$conspan+1; }
				if($pcCostOnExtraBedABasis>0){ $conspan=$conspan+1; }
				if($pcCostOnExtraBedCBasis>0){ $conspan=$conspan+1; }
				$colsWidth = 80/$conspan;
				?>
				<th width="20%" align="right" rowspan="2" valign="middle"><strong>Total Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></th>
				<?php if($conspan>0){ ?>
				<th width="80%" colspan="<?php echo $conspan; ?>" align="center" valign="middle"><strong>Per Person Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></th>
				<?php } ?>
			</tr>
			<tr>
				<?php if($ppCostONSingleBasis>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><div align="right"><strong>Single Basis</strong></div></th>
				<?php } if($ppCostONDoubleBasis>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><div align="right"><strong>Double Basis</strong></div></th>
				<?php } if($pcCostOnExtraBedABasis>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><div align="right"><strong>ExtraBed(Adult) Basis</strong></div></th>
				<?php } if($pcCostOnExtraBedCBasis>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><div align="right"><strong>ExtraBed(child) Basis</strong></div></th>
				<?php } ?>
			</tr>
			
			<tr>
				<td valign="middle"><div align="right">
					<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
				</div></td>
				<?php if($ppCostONSingleBasis>0){ ?>
				<td valign="middle">
					<div align="right">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
					</div>
				</td>
				<?php } if($ppCostONDoubleBasis>0){ ?>
				<td valign="middle">
					<div align="right">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
					</div>
				</td>
				<?php } if($pcCostOnExtraBedABasis>0){ ?>
				<td valign="middle">
					<div align="right">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedABasis)); ?>
					</div>
				</td>
				<?php } if($pcCostOnExtraBedCBasis>0){ ?>
				<td valign="middle">
					<div align="right">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?>
					</div>
				</td>
				<?php } ?>
			</tr>
		</table>
	</div>
	<br /> 
	<?php 
	if($resultpageQuotation['flightCostType'] == 1){  ?>
	<div class="docTitle w60">AIR FARE SUPPLEMEN<span class="docTitleArrow"></span></div>  
	<div class="table-service pd30" > 
		<div class="serviceTitle">Air Fare Supplement</div>
		<table border="1" cellpadding="8" cellspacing="0" class="borderedTable table-service">
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
	</div>
	<?php 
	}  

	$checkSuppHQuery="";
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$resultpageQuotation['id'].'" and supplementHotelStatus=1 ');
	if(mysqli_num_rows($checkSuppHQuery) > 0){
		?>
		<div class="docTitle w60">HOTEL/ROOM SUPPLEMENT<span class="docTitleArrow"></span></div>
		<br />
		<br />
		<div class="table-service pd30" > 
			<div class="serviceTitle">Hotel/Room Supplement</div>
			<?php  
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			include('quotationSupplementHoteltable.php');
			?>
		</div>
		<br />	
		<?php 
	} ?> 
	<div class="docTitle w60">INCLUSIONS<span class="docTitleArrow"></span></div>
	<div class="serviceDesc pd30"><?php echo strip($inclusion); ?></div>

	<div class="docTitle w60">EXCLUSIONS<span class="docTitleArrow"></span></div>
	<div class="serviceDesc pd30"><?php echo strip($exclusion); ?></div>
	<br />	
	<br />	
	<div class="dayItineraryInfo ">
		<img src="<?php echo $fullurl; ?>images/generated-by-TRAVCRM.png" width="100%" />
	</div> 
</div>

</body>
</html
