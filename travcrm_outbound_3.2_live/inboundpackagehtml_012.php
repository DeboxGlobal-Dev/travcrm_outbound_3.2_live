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
	<style type="text/css"> 
		@font-face { 
			font-family: 'Roboto', sans-serif;
			src: url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap') format('truetype'); 
		} 
		body{ font-family: 'Roboto', sans-serif; font-weight: 300;  }
		strong{ font-family: 'Roboto', sans-serif; font-weight: 500; } 
     	@page {
            margin: 0cm 0cm;
        }
        body {
            margin-top: 1cm;
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 1cm;
        }
     	/* 
     	header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;

            background-color: #ffc20f;
            color: white;
            text-align: center;
            line-height: 25px;
        }
       	*/
       	footer {
            position: fixed; 
            bottom: 0cm; 
            left: 0cm; 
            right: 0cm;
            height: 1cm;
            /*background-color: #414143;*/
            color: #000;
            /*border-top: 1px solid #414143;*/
            font-size: 10px;
            text-align: center;
            line-height: 25px;
        }
        footer a{
        	text-decoration: none;
            color: #000;


        }
        /*end teseting*/

        
        /*@page { margin: 40px 20px; }*/
	    .firstpage { 
	      	margin-top: -20px!important;
	    } 
	    
		.main-container{
			display: block;
			/*width: 700px;*/
			/*comment above line to generate pdf*/
			margin: 0px auto;
			position: relative; 
			font-size: 14px;
			border: 0px solid #ccc;
			background-color: #fff;
			color: #3c3a3a;
			font-weight: 400;

		} 
		.blank_line{
			margin: 5px 0;
			height: 0;
			width: 0;
		}
		.hr_line{
			margin: 10px 0px;
			height: 0;
			border-top: 1px solid #ddd;
		}
		ul {
			list-style-type: circle;
			color: #383636;
			list-style-position: outside;
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
		    line-height: 20px;
		    font-size:25px;
		    margin-bottom:10px; 
		    text-align:left;
	    }
	    .serviceTitle{
	      	font-size: 16px;
		    padding-bottom: 5px;
		    line-height: 20px;
		    color: rgb(28, 126, 214);
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
	    img{
	    	margin-top: 2px;
	    }
	    .table-service img{
	    	margin-top: 8px;
	    }
	    .table-service.transfer img,
	    .table-service.hotel img,
	    .table-service.train img,
	    .table-service.flight img{
	    	margin-top: 12px;
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
	    .bannerDetails{

	    }
	   .text-center{
	    	text-align: center!important;
	    }
	</style>
</head>
<body >
<div class="calcostsheet">
<?php include_once("loadFITCostSheet.php"); ?>
</div>
    <footer><a href="http://www.deboxglobal.com/travcrm.html" target="_blank" >TravCRM - Copyright &copy; <?php echo date("Y");?></a>
    </footer>
<div class="main-container">
	<table class="firstpage" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
		<tr>
			<td align="center" valign="top"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo str_replace(' ', '%20',$masterProposalLogo);?>" width="100%" ><div class="hr_line"></div></td>
		</tr>
		<tr>
			<td align="center" style="padding: 20px 0;font-size:22px;text-align:center;">
				<strong><?php echo strip($quotationSubject); ?></strong> 
			</td>
		</tr>
		</tbody>
	</table>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
		<tr>
			<td align="center"><?php 
			if($resultpageQuotation['image']!=''){
				$proposalImg = 'dirfiles/'.str_replace(' ', '%20',$resultpageQuotation['image']);
				if(file_exists($proposalImg)==true){
					$proposalPhoto = $fullurl.$proposalImg;
				}else{
					$proposalPhoto = $fullurl.'images/sample-proposal.jpg';
				}
			}else{
				$proposalPhoto = $fullurl.'images/sample-proposal.jpg';
			}
			?><img src="<?php echo $proposalPhoto; ?>" width="100%" height="600" style="width: 100%;">
			<div class="bannerDetails">
			<table width="100%" border="0" cellpadding="10" cellspacing="0" >
				<tbody>
					<tr>
						<td align="right" valign="top">
							<strong>Classic North India</strong>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top">
							<span style="margin-right:10px">Delhi</span>  
							<img src="<?php echo $fullurl; ?>images/right-location.png" height="14" width="14">  
							<span style="margin-right:10px">Agra</span>  
							<img src="<?php echo $fullurl; ?>images/right-location.png" height="14" width="14">
							<span style="margin-right:10px">Jaipur</span>  
						</td>
					</tr>
					<tr>
						<td align="right" valign="top">
							<strong>1 Nights / 2 Days </strong>
						</td>
					</tr>
				</tbody>
			</table>
			</div>
			</td>
		</tr> 
		</tbody>
	</table>
	<br />
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;page-break-before: always;">
		<tbody>
			<tr >
				<td  align="center" valign="top"><strong style="font-size: 30px;">Tour Program</strong></td>
			</tr>		
		</tbody>
	</table>
<?php  
// DAY LOOP START
$day=1;
$queryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
while($queryDaysData=mysqli_fetch_array($queryDaysQuery)){  
	$dayDate = date('Y-m-d',strtotime($queryDaysData['srdate']));
	$dayId = $queryDaysData['id']; 
	?> 
	<!--day num ,  title and description -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="page-break-inside:avoid;" >
		<tbody>
			<tr >
				<td align="left" valign="top">
					<br />
					<div class="dayTitle">Day <?php echo $day; ?> - <?php echo getDestination($queryDaysData['cityId']); ?></div> 
					<div class="hr_line"></div>
				</td>
			</tr>
			<tr >
				<td align="left" valign="top"><?php 
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
				?><img src="<?php echo $proposalPhoto; ?>" width="100%" height="500" style="width: 100%;">
				</td>
			</tr> 
			<tr class="row-titleDesc">
				<td align="left" valign="top"><br />
					<strong class="serviceTitle"><?php 
     				if($queryDaysData['title']!=''){ 
     					echo urldecode(strip($queryDaysData['title']));
     				}
     				?></strong>
     				<br />
     				<br />
				</td>
			</tr> 
		</tbody>
	</table>
	
	<div class="serviceDesc"><?php 
	if($queryDaysData['description']!=''){ 
		$html = urldecode(strip($queryDaysData['description']));
		$html = str_replace('<p>&nbsp;</p>', '<br />', $html);
		$html = str_replace('<p>', '<div>', $html);
		echo $html = str_replace('</p>', '</div>', $html);
	}
	?></div>
	<br />
	<?php 
	// SERVICE LOOP START
	$itiQuery=' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc';
	$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
	while($itineryDayData = mysqli_fetch_array($itineryDay)){

		if($itineryDayData['serviceType'] == 'hotel' ){
			$where1='quotationId="'.$queryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$itineryDayData['serviceId'].'"';   
			$rs1=GetPageRecord('*','quotationHotelMaster',$where1);  
			if(mysqli_num_rows($rs1) > 0){
				$hotellisting=mysqli_fetch_array($rs1); 
				$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
				$hotelData=mysqli_fetch_array($rs1ee);   
				echo "<div class='serviceDesc'>
						<img src='".$fullurl."images/icon-home.png' height='20' width='20'>  Overnight stay at ".ucfirst($hotelData['hotelName'])."</div><br />";
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
				echo "<div class='serviceDesc'>
						<img src='".$fullurl."images/icon-transfer.png' height='20' width='20'>  Overnihgt stay at ".ucfirst($transfergdetail['transferName'])."</div><br />";
					if(strlen($transfergdetail['transferDetail']) > 0){  
						echo '<div class="serviceDesc">'.clean($transfergdetail['transferDetail']).'</div><br />';
				 	} 
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
				<div class="hr_line"></div>
				<strong class="serviceTitle"><?php echo ucfirst($enrouteData['enrouteCity']);  ?> | <?php echo strip($enrouteData['enrouteName']);  ?></strong>
				<div class="serviceDesc"><?php echo strip_tags($enrouteData['enrouteDetail']); ?></div><br />
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
				<div class="hr_line"></div>
				<strong class="serviceTitle"><?php echo strip($entranceData['entranceName']);  ?></strong>
				<div class="serviceDesc"><?php 
				if($resultpageQuotation['languageId'] != "0"){
					$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');
					$checkrow = mysqli_num_rows($rs2);
					$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
					if($checkrow > 0){
						echo strip($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]);
					}
				}
				else{
					echo strip($entranceData['entranceDetail']);
				}
				?></div><br /><?php  
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
				<div class="hr_line"></div> 
				<strong class="serviceTitle"><?php echo strip($activityData['otherActivityName']);  ?></strong>
				<div class="serviceDesc"><?php 
			 	if($resultpageQuotation['languageId'] != "0"){
				 	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"');  
				 	$checkrow = mysqli_num_rows($rs2);
					$activityLanData=mysqli_fetch_array($rs2);
					if($checkrow > 0){
						echo strip_tags($activityLanData['lang_0'.$resultpageQuotation['languageId']]); 
			        }
			  	} else {
					echo strip_tags($activityData['otherActivityDetail']); 
		    	} ?></div><br />
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
				<div class="hr_line"></div>
				<strong class="serviceTitle"><?php echo strip($extraData['name']);  ?></strong>
				<div class="serviceDesc">Additional the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions..</div><br />
				<?php  
			}
		}

		if($itineryDayData['serviceType'] == 'flight'){

			$where22='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
			$rs22=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22);  
			if(mysqli_num_rows($rs22) > 0){
				$flightQuoteData=mysqli_fetch_array($rs22); 
				$select1='*';   
				$where1='id="'.$flightQuoteData['flightId'].'"';  
				$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_FLIGHT_MASTER_,$where1);  
				$flightData=mysqli_fetch_array($rs1);  
				
				if(date('H:i',strtotime($flightQuoteData['departureTime'])) <> '05:30'){
					$departureTime = "/@".date('Hi',strtotime($flightQuoteData['departureTime']))."/";
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
				echo "<div class='serviceDesc'><img src='".$fullurl."images/icon-train-flight.png' height='20' width='20'>  ".strip(ucfirst($flightData['flightName'])).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/'.strip($flightQuoteData['flightClass']).'</div><br />'; 
				// flight dettail
				 
			} 
		}  
 
		if($itineryDayData['serviceType'] == 'train'){
			$where22='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
			$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
			if(mysqli_num_rows($rs22) > 0){
				$trainQuoteData=mysqli_fetch_array($rs22);  

				$where1='id="'.$trainQuoteData['trainId'].'"';  
				$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,$where1);  
				$trainData=mysqli_fetch_array($rs1);   
				//train details
				
				if(date('H:i',strtotime($trainQuoteData['departureTime'])) <> '05:30'){
					$dptTime = "/@".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
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
				echo"<div class='serviceDesc'><div class='serviceDesc'><img src='".$fullurl."images/icon-train-flight.png' height='20' width='20'>  ".strip(ucfirst($trainData['trainName'])).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/'.strip($trainQuoteData['trainClass']).'</div><br />'; 
			} 
		}
		// END OF SERVICES
	}
$n++; 
$day++;
}

?>
<br />	
	<br />	
	<div class="serviceTitle text-center" >END OF THE TOUR</div><br /><br />
	<div class="serviceTitle">Hotels Proposed</div>
	<table width="100%" border="1" align="left" cellpadding="5" cellspacing="0" bordercolor="#ddd" class="table-service">
	 	<tr>
			<td width="20%" align="left" valign="middle" bgcolor="#c6efc8"><strong>Dates</strong></td>
			<td width="12%" align="left" valign="middle" bgcolor="#c6efc8"><strong>City</strong></td>
			<td width="27%" align="left" valign="middle" bgcolor="#c6efc8"><strong>Hotel</strong></td>
			<td width="16%" align="left" valign="middle" bgcolor="#c6efc8"><strong>Room Type</strong></td>
 			<td width="25%" align="left" valign="middle" bgcolor="#c6efc8"><strong>Remarks</strong></td>
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
	<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" >
		<tr>
			<?php
			$conspan = 0;
			if($ppCostONSingleBasis>0){ $conspan=$conspan+1; }
			if($ppCostONDoubleBasis>0){ $conspan=$conspan+1; }
			if($pcCostOnExtraBedABasis>0){ $conspan=$conspan+1; }
			if($pcCostOnExtraBedCBasis>0){ $conspan=$conspan+1; }
			$colsWidth = 80/$conspan;
			?>
			<td width="20%" align="right" rowspan="2" bgcolor="#c6efc8" valign="middle"><strong>Total Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></td>
			<?php if($conspan>0){ ?>
			<td width="80%" colspan="<?php echo $conspan; ?>" align="center" valign="middle" bgcolor="#c6efc8"><strong>Per Person Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></td>
			<?php } ?>
		</tr>
		<tr>
			<?php if($ppCostONSingleBasis>0){ ?>
			<td width="<?php echo $colsWidth; ?>%" valign="middle" bgcolor="#c6efc8"><div align="right"><strong>Single Basis</strong></div></td>
			<?php } if($ppCostONDoubleBasis>0){ ?>
			<td width="<?php echo $colsWidth; ?>%" valign="middle" bgcolor="#c6efc8"><div align="right"><strong>Double Basis</strong></div></td>
			<?php } if($pcCostOnExtraBedABasis>0){ ?>
			<td width="<?php echo $colsWidth; ?>%" valign="middle" bgcolor="#c6efc8"><div align="right"><strong>ExtraBed(Adult) Basis</strong></div></td>
			<?php } if($pcCostOnExtraBedCBasis>0){ ?>
			<td width="<?php echo $colsWidth; ?>%" valign="middle" bgcolor="#c6efc8"><div align="right"><strong>ExtraBed(child) Basis</strong></div></td>
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
	<br />
	<?php 
	if($resultpageQuotation['flightCostType'] == 1){  ?> 
	<div class="serviceTitle">AIR FARE SUPPLEMENT</div>
	<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" >
		<tr>
			<td width="12%" valign="middle" bgcolor="#c6efc8"><strong>Date</strong></td>
			<td width="19%" valign="middle" bgcolor="#c6efc8"><strong>Sector</strong></td>
			<td width="30%" valign="middle" bgcolor="#c6efc8"><strong>Flight/Timings</strong></td>
			<td width="28%" valign="middle" bgcolor="#c6efc8"><strong>Class/Baggage</strong></td>
			<td width="11%" align="right" valign="middle" bgcolor="#c6efc8"><strong>Fare</strong></td>
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
				<td valign="middle"><div align="right"><strong><?php echo getCurrencyName($newCurr); ?> <?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?>
			       </strong></div></td>
 			</tr>
		  <?php 
		} ?>
	  <tr>
	  	<td colspan="5" align="center">Air fares are subject to change at the time of booking</td>
	  </tr>
	</table>
	<br />
	<?php 
	}  


	$checkSuppHQuery="";
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$resultpageQuotation['id'].'" and isHotelSupplement=1 ');
	if(mysqli_num_rows($checkSuppHQuery) > 0){
		?>

		<div style="font-size:15px;">Hotel/Room Supplement</div>
		<?php  
		$queryId = $resultpageQuotation['queryId'];
		$quotationId= $resultpageQuotation['id'];
		include('quotationSupplementHoteltable.php');
		?>
		<br />	
		<?php 
	} ?>
	<table border="0" cellpadding="4" cellspacing="0"  width="100%" style="font-size:12px" >
	  <tr >
			<td align="left" valign="middle" ><div class="serviceTitle"><u>INCLUSIONS</u></div><?php echo strip($inclusion); ?></td>
		</tr>
		<tr >
			<td align="left" valign="middle" ><div class="serviceTitle"><u>EXCLUSIONS:</u></div><?php echo strip($exclusion); ?></td>
		</tr>
		<tr >
			<td align="left" valign="middle" ><div class="serviceTitle"><u>GENERAL CONDITIONS:</u></div><?php echo strip($highlightsText); ?></td>
		</tr>
		<tr >
			<td align="left" valign="middle" ><div class="serviceTitle"><u>LEGEND:</u></div><?php echo strip($tncText); ?></td>
		</tr>
		<tr >
			<td align="left" valign="middle" ><div class="serviceTitle"><u>OPERATIONAL RESTRICTIONS:</u></div><?php echo strip($specialText); ?></td>
		</tr>
	</table>
 
</div>
<div style="position: absolute;bottom: 0;left: 0; right: 0;height: 656;width:100%;page-break-before: always;"  ><img width="100%" alt="Thank You" src="<?php echo $fullurl; ?>/images/thanksyou-debox.jpeg" /></div>
</body>
</html
