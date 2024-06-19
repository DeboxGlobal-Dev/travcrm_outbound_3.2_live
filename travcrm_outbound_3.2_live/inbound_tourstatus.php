
	<?php 
   	include "inc.php";  
	
	$select=''; 
	$where=''; 
	$rs='';   
	$select='*';  
	$where='id=1'; 
	$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
	$resultInvoiceSetting=mysqli_fetch_array($rs); 
	if($_REQUEST['id']!=''){
		$select1='*';
		$where1='id="'.decode($_REQUEST['id']).'"';
		$rs1=GetPageRecord($select1,_QUOTATION_MASTER_,$where1);
		$editresult=mysqli_fetch_array($rs1);
		
		$a=GetPageRecord($select1,_QUERY_MASTER_,'id='.$editresult['queryId'].'');
		$querydata=mysqli_fetch_array($a); 

    $ac=GetPageRecord('*','newQuotationDays',' quotationId="'.$editresult['id'].'" order by id asc'); 
    $QueryDaysDataac=mysqli_fetch_array($ac);

    $acd=GetPageRecord('*',_DESTINATION_MASTER_,' id="'.$QueryDaysDataac['cityId'].'"'); 
    $arrivalCity=mysqli_fetch_array($acd);

    $dc=GetPageRecord('*','newQuotationDays',' quotationId="'.$editresult['id'].'" order by id desc'); 
    $QueryDaysDatadc=mysqli_fetch_array($dc);

    $dcd=GetPageRecord('*',_DESTINATION_MASTER_,' id="'.$QueryDaysDatadc['cityId'].'"'); 
    $dipartureCity=mysqli_fetch_array($dcd);
   
	} 
	
	$select='*';  
	$where='id="'.$querydata['id'].'"';  
	$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
	$resultpage=mysqli_fetch_array($rs); 
	
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['id']).'"');  
	$resultpageQuotation=mysqli_fetch_array($rsp);  

	$queryId = $resultpageQuotation['queryId'];
	$quotationId = $resultpageQuotation['id'];
	$moduleType = $resultpage['moduleType'];
	$queryType = $resultpage['queryType'];
	    
	$totalPackageCost = 0;
	?> 


<table width="745" border="0" cellpadding="10" cellspacing="0" bordercolor="#000000">
  	<tr>
    	<td colspan="2" align="center" valign="top"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSetting['logo']; ?>" width="160" /></td>
  	</tr>
 	<tr>
    	<td colspan="2" align="center" valign="top"><strong style="font-size:20px"><?php echo $resultInvoiceSetting['companyname'];?></strong></td>
  	</tr>
	<tr>
    	<td colspan="2" align="center" valign="top"><strong style="font-size:18px">Tour&nbsp;Status</strong></td>
  	</tr>
    <!-- <tr>
      <td colspan="2" align="center" valign="top"><strong style="font-size:18px">&nbsp;</strong></td>
    </tr> -->
  	<tr>
      <td colspan="2">
	  <table width="100%" border="0" align="left" cellspacing="0" cellpadding="2">
		 
		  <tr>
			<td>Client&nbsp;Name</td>
			<td>:&nbsp;<?php echo strip($querydata['leadPaxName']); ?></td>
      <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
      <td>&nbsp;</td>
			<td colspan="2">As&nbsp;on:<span style="color:#000;"><?php echo date('d/m/Y');?></span></td>
		  </tr>
		  <tr>
			<td>No of Pax </td>
			<td><span style="color:#000;border-left:1px solid #ddd;">:&nbsp;<?php echo ($querydata['adult']+$querydata['child']+$querydata['infant']); ?></span></td>
      <td>&nbsp;</td>
			<td>Agent&nbsp;Reference&nbsp;Id</td>
			<td>:&nbsp;<?php echo $querydata['referanceNumber']; ?></td>
      <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Agent&nbsp;Name</td>
			<td>:&nbsp;<?php
			 echo  showClientTypeUserName($querydata['clientType'],$querydata['companyId'])
			?></td>
      <td>&nbsp;</td>
			<td>Arrival Date</td>
			<td>:&nbsp;<?php echo date('d-m-Y',strtotime($querydata['fromDate'])); ?></td>
      <td>&nbsp;</td>
			<td>Departure Date</td>
			<td>:&nbsp;<?php echo date('d-m-Y',strtotime($querydata['toDate'])); ?></td>
		  </tr>
		  <tr>
			<td>File Code:</td>
			<td>:&nbsp;<?php echo makeQueryTourId($querydata['id']); ?></td>
      <td>&nbsp;</td>
			<td>Arrival City</td>
			<td>:&nbsp;<?php echo $arrivalCity['name']; ?></td>
      <td>&nbsp;</td>
			<td>Departure City</td>
			<td>:&nbsp;<?php echo $dipartureCity['name']; ?></td>
		  </tr>
		  <tr>
			<td colspan="6">&nbsp;</td>
		  </tr>
		</table> 
	  </td>
  	</tr> 
<?php 
$hc=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate ASC'); 
$counthotel = mysqli_num_rows($hc);
if($counthotel>0){
 ?>  	
	<tr>	 
		<td colspan="2" align="center" width="98%" > 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
			<tr>
				<td colspan="8" valign="middle" align="left"><strong>Hotels Accommodation Status:</strong></td>
		  </tr>  
		  <tr>
			<td colspan="2" align="center"  valign="middle" bgcolor="#F4F4F4" width="25%"><strong>Dates</strong></td>
			<td rowspan="2" valign="middle" bgcolor="#F4F4F4" width="10%"><strong>Place</strong></td>
			<td rowspan="2" align="center" valign="middle" bgcolor="#F4F4F4" width="20%"><strong>Hotel&nbsp;Name</strong></td>
			<td rowspan="2" align="center" valign="middle" bgcolor="#F4F4F4" width="25%"><strong>Accommodation&nbsp;in<br>Rooms</strong></td>
			<td rowspan="2" align="center" valign="middle" bgcolor="#F4F4F4" width="10%"><strong>Room&nbsp;Type</strong></td>
			<td rowspan="2" align="center" valign="middle" bgcolor="#F4F4F4" width="10%"><strong>Meal&nbsp;Plan</strong></td>
			<td rowspan="2" align="center" valign="middle" bgcolor="#F4F4F4" width="10%"><strong>Status</strong></td>
 		  </tr>
		  <tr>
			<td colspan="2" align="left"  valign="middle" bgcolor="#F4F4F4"><table width="100%"><tr><td width="50%"><strong> In</strong></td><td width="50%"><strong>Out</strong></td></tr></table></td>
		  </tr>
			<?php 
			$totalHotel = 0;
			// echo ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate ASC';
			$b1=GetPageRecord('*','finalquotationItinerary','quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate ASC'); 
			while($sorting2=mysqli_fetch_array($b1)){ 
				$where2='1 and quotationId="'.$quotationId.'" and id="'.$sorting2['serviceId'].'"';						
				$b=GetPageRecord('*','finalQuote',$where2); 
				if(mysqli_num_rows($b) > 0){
					$hotelQuotData=mysqli_fetch_array($b);

					$cq=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$hotelQuotData['quotationId'].'" and id="'.$hotelQuotData['hotelQuotationId'].'" order by id desc'); 
				    $hotelQuotDataq=mysqli_fetch_array($cq);
				
					$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['hotelId'].'"');   
					$hotelData=mysqli_fetch_array($d);
					
					$start = strtotime($hotelQuotData['fromDate']);
					$end = strtotime($hotelQuotData['toDate']);
					$days_between='';
					$days_between = ceil(abs($end - $start) / 86400);
 
					if($hotelQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($hotelQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($hotelQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($hotelQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($hotelQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}
					?> 
		  		<tr>
			
			<td  colspan="2" valign="middle" align="left">
     <table width="100%"><tr><td width="50%" align="left"> <?php 
      if($querydata['dayWise'] == 1){ 
        //$dayDates = date('Y-m-d', strtotime('+1 day', strtotime($hotelQuotData['toDate'])));
          echo date('d/m/Y',strtotime($sorting2['startDate']));  
      } else{
        echo $days_between+1; ?> N 
      <?php
      }
      ?></td><td width="50%" align="left"><?php 
      if($querydata['dayWise'] == 1){ 
        //$dayDates = date('Y-m-d', strtotime('+1 day', strtotime($hotelQuotData['toDate'])));
          // echo date('d/m/Y',strtotime('+1 day',$sorting2['startDate']));  
            echo date('d/m/Y', strtotime('+1 day', strtotime($sorting2['startDate'])));
      } else{
        echo $days_between+1; ?> N 
      <?php
      }
      ?></td></tr></table>   
      </td>
			<td valign="middle"><?php echo getDestination($hotelQuotDataq['destinationId']); ?></td>
			<td valign="middle"><?php echo strip($hotelData['hotelName']);  ?></td>
			
			<td valign="middle">
				<?php 
				echo ($hotelQuotData['roomSingle']>0)?$hotelQuotData['roomSingle'].'SGL,':'';
				echo ($hotelQuotData['roomDouble']>0)?$hotelQuotData['roomDouble'].'DBL,':'';
				echo ($hotelQuotData['roomTriple']>0)?$hotelQuotData['roomTriple'].'TWN,':'';
				echo ($hotelQuotData['roomTwin']>0)?$hotelQuotData['roomTwin'].'TPL,':'';
				echo ($hotelQuotData['roomEBedC']>0)?$hotelQuotData['roomEBedC'].'EBEd(C),':'';
				?>
			</td>
			<td valign="middle">
			<?php 
			$select12='*';  
			$where12='id="'.$hotelQuotData['roomType'].'"'; 
			$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
			$editresult2=mysqli_fetch_array($rs12);
			echo $rtype=$editresult2['name'];
			?></td> 			
			
			<td align="center" valign="middle"><?php 
			$select2='name';  
			$where2='id="'.$hotelQuotDataq['mealPlan'].'"'; 
			$rs2=GetPageRecord($select2,_MEAL_PLAN_MASTER_,$where2); 
			$editresult2=mysqli_fetch_array($rs2); 
			echo clean($editresult2['name']);  
			?></td>		
			<td align="center" valign="middle"><?php echo $status; ?></td>					
			</tr>
		  	<?php } 
			} 
			?>
		  </table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>	

<?php 
$fc=GetPageRecord('*','finalQuoteFlights',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
$countflight = mysqli_num_rows($fc);
if($countflight>0){
 ?>  	
	<tr style="">	
		<td colspan="2" align="left" width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="6"  valign="middle" ><strong>Flight&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%" valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Flights&nbsp;No.</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Timings<br>
			  Dep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arr</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Class</strong></td>
			<td  width="10%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td width="20%" colspan="2" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$totalFlight= 0;	
			$b=GetPageRecord('*','finalQuoteFlights',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($flightQuotData=mysqli_fetch_array($b)){ 
          $d51=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'id="'.$flightQuotData['flightQuotationId'].'"');  
					$flight1Data=mysqli_fetch_array($d51);

					$d5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuotData['flightId'].'"');  
					$flightData=mysqli_fetch_array($d5);
					if($flightQuotData['manualStatus']=='0'){
					$status='Pending';
					}
					if($flightQuotData['manualStatus']=='1'){
					$status='Sent';
					}
					if($flightQuotData['manualStatus']=='2'){
					$status='Requested';
					}
					if($flightQuotData['manualStatus']=='3'){
					$status='Confirm';
					}
					if($flightQuotData['manualStatus']=='4'){
					$status='Rejected';
					}   
				?> 
			  <tr>
				<td  valign="middle" align="center">
				<?php 
				if($flightQuotData['fromDate']!='' && $flightQuotData['fromDate']!='0000-00-00' ){
					echo date('d/m/Y',strtotime($flightQuotData['fromDate']));  
				}else{
					echo date('d/m/Y',strtotime($flight1Data['fromDate']));
				}
				?>
			</td>
			<td valign="middle" align="center">
				<?php 
				$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$flight1Data['departureFrom'].'"'); 
				$DF=mysqli_fetch_array($rs51); 
				echo strip($DF['name']);   
				?>-<?php 
				$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$flight1Data['arrivalTo'].'"'); 
				$AT=mysqli_fetch_array($rs51); 
				echo strip($AT['name']);  
				?></td>
			<td valign="middle" align="center"><?php echo strip($flight1Data['flightNumber']);  ?></td>		
			<td valign="middle" align="center"><?php echo strip($flight1Data['departureTime']);  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strip($flight1Data['arrivalTime']);  ?></td>	
			<td valign="middle" align="center"><?php echo strip($flight1Data['flightClass']);  ?></td>				
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		  	
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>	
<tr>	
	  <td colspan="2" align="left">&nbsp;</td>
	</tr>
<?php 
 $ts=GetPageRecord('*','finalQuoteTrains',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
 $counttrain = mysqli_num_rows($ts);
 if($counttrain>0){
 ?>
	<tr>	
		<td colspan="2" align="left" width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="6"  valign="middle" ><strong>Train&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%"  valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Train&nbsp;No.</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Timings<br>
			  Dep&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arr</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Class</strong></td>
			<td  width="10%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td  colspan="2" width="20%" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$totalTrain= 0;	
			$b=GetPageRecord('*','finalQuoteTrains',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($trainQuotData=mysqli_fetch_array($b)){ 
			
			$d5=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuotData['trainId'].'"');  
			$trainData=mysqli_fetch_array($d5);  

			$d5t=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'id="'.$trainQuotData['trainQuotationId'].'"');  
			$train1Data=mysqli_fetch_array($d5t); 
 
					if($trainQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($trainQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($trainQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($trainQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($trainQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}   
								
			?> 
		  	<tr>
			<td    valign="middle" align="center">
			<?php 
			if($trainQuotData['fromDate']!='' && $trainQuotData['fromDate']!='0000-00-00' ){
				echo date('d/m/Y',strtotime($trainQuotData['fromDate']));  
			}else{
				echo date('d/m/Y',strtotime($train1Data['fromDate']));
			}  
			?>
			</td>
			<td valign="middle" align="center">
				<?php 
				$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$train1Data['departureFrom'].'"'); 
				$DF=mysqli_fetch_array($rs51); 
				echo strip($DF['name']);   
				?>-<?php 
				$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$train1Data['arrivalTo'].'"'); 
				$AT=mysqli_fetch_array($rs51); 
				echo strip($AT['name']);  
				?></td>
			<td valign="middle" align="center"><?php echo strip($train1Data['trainNumber']);  ?></td>		
			<td valign="middle" align="center"><?php echo strip($train1Data['departureTime']);  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strip($train1Data['arrivalTime']);  ?></td>	
			<td valign="middle" align="center"><?php echo strip($train1Data['trainClass']);  ?></td>				
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>


<?php 
$tc=GetPageRecord('*','finalQuotetransfer',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
$counttransfer = mysqli_num_rows($tc); 
if($counttransfer > 0){
?>
	<tr>	
		<td colspan="2" align="left" width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="6"  valign="middle" ><strong>Transfer/Transportation&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%"  valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Transfer&nbsp;Name</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Vehicle&nbsp;Name</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Timings<br>
			  PickUp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Drop</strong></td>
			<td  width="10%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td  colspan="2" width="20%" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$b = '';	
			$b=GetPageRecord('*','finalQuotetransfer',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($transferQuotData=mysqli_fetch_array($b)){ 
			
			$d5=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferId'].'"');  
			$transferData=mysqli_fetch_array($d5);  

			$d5t=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'id="'.$transferQuotData['transferQuotationId'].'"');  
			$transfer1Data=mysqli_fetch_array($d5t); 

			$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferQuotData['transferQuotationId'].'" and quotationId="'.$transferQuotData['quotationId'].'"');
            $transferTimelineData=mysqli_fetch_array($c1);
 
					if($transferQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($transferQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($transferQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($transferQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($transferQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}

					$select2='carType,model';  
					$where2='id="'.$transfer1Data['vehicleModelId'].'"'; 
					$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
					$editresult2=mysqli_fetch_array($rs2);   
								
			?> 
		  	<tr>
			<td    valign="middle" align="center">
			<?php 
			if($transferQuotData['fromDate']!='' && $transferQuotData['fromDate']!='0000-00-00' ){
				echo date('d/m/Y',strtotime($transferQuotData['fromDate']));  
			}else{
				echo date('d/m/Y',strtotime($transfer1Data['fromDate']));
			}  
			?>
			</td>
			<td valign="middle" align="center">
				<?php 
				$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$transfer1Data['destinationId'].'"'); 
				$DF=mysqli_fetch_array($rs51); 
				echo strip($DF['name']);   
				?>-<?php 
				$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$transfer1Data['destinationId'].'"'); 
				$AT=mysqli_fetch_array($rs51); 
				echo strip($AT['name']);  
				?></td>
			<td valign="middle" align="center"><?php echo strip($transferData['transferName']);  ?></td>		
			<td valign="middle" align="center"><?php echo $editresult2['model']; ?></td>	
			<td valign="middle" align="center"><?php echo date('h:i A', strtotime($transferTimelineData['pickupTime']));  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('h:i A', strtotime($transferTimelineData['dropTime']));  ?></td>				
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>

<?php 
$gc=GetPageRecord('*','finalQuoteGuides',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
$countguide = mysqli_num_rows($gc); 
if($countguide > 0){
?>
	<tr>	
		<td colspan="2" align="left"  width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="6"  valign="middle" ><strong>Guide&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%"  valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Guide&nbsp;Service</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Day&nbsp;Type</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Pax&nbsp;Range</strong></td>
			<td  width="10%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td  colspan="2" width="20%" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$b = '';	
			$b=GetPageRecord('*','finalQuoteGuides',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($guideQuotData=mysqli_fetch_array($b)){ 

                $bq=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' id="'.$guideQuotData['guideQuotationId'].'" and quotationId="'.$guideQuotData['quotationId'].'"'); 
			    $quotResult=mysqli_fetch_array($bq);

			    $where11= 'id="'.$quotResult['tariffId'].'"'; 
				$rs11 = GetPageRecord('*','dmcGuidePorterRate',$where11); 
				$dmcroommastermaina = mysqli_fetch_array($rs11);

				if(trim($dmcroommastermaina['dayType']) == 'fullday'){
					$dayType = "Full Day";
				}else{
					$dayType = "Half Day";
				}

				$select5='*';  
				$where5='id="'.$guideQuotData['guideId'].'"'; 
				$rs5=GetPageRecord($select5,_GUIDE_SUB_CAT_MASTER_,$where5); 
				$GuideData5=mysqli_fetch_array($rs5); 
			 
					if($guideQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($guideQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($guideQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($guideQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($guideQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}

				    $rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$quotResult['destinationId'].'"'); 
				    $DF=mysqli_fetch_array($rs51); 
				
								
			?> 
		  	<tr>
			<td    valign="middle" align="center">
			<?php 
			if($guideQuotData['fromDate']!='' && $guideQuotData['fromDate']!='0000-00-00' ){
				echo date('d/m/Y',strtotime($guideQuotData['fromDate']));  
			}else{
				echo date('d/m/Y',strtotime($quotResult['fromDate']));
			}    
			?>
			</td>
			<td valign="middle" align="center"><?php echo strip($DF['name']); ?></td>
			<td valign="middle" align="center"><?php echo strip($GuideData5['name']);  ?></td>		
			<td valign="middle" align="center"><?php echo $dayType; ?></td>	
			<td valign="middle" align="center"><?php if (strip($dmcroommastermaina['paxRange'])==0){ echo "All"; }else{ echo str_replace('_',' to ',$dmcroommastermaina['paxRange']);  };  ?></td>				
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>	

<?php 
$ac=GetPageRecord('*','finalQuoteActivity',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
$countactivity = mysqli_num_rows($ac); 
if($countactivity > 0){
?>
	<tr>	
		<td colspan="2" align="left"  width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="6"  valign="middle" ><strong>Activity&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%"  valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Activity&nbsp;Name</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Start&nbsp;Time</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>End&nbsp;Time</strong></td>
			<td  width="10%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td  colspan="2" width="20%" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$b = '';	
			$b=GetPageRecord('*','finalQuoteActivity',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($activityQuotData=mysqli_fetch_array($b)){ 

			   $qr=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' id ="'.$activityQuotData['activityQuotationId'].'" '); 
			   $quotResult=mysqli_fetch_array($qr);

			   $a11=GetPageRecord('*','newQuotationDays',' quotationId="'.$activityQuotData['id'].'" and addstatus=0 order by id'); 
			   $QueryDaysData1=mysqli_fetch_array($a11);
	

               $otherActivitySql=GetPageRecord('*','packageBuilderotherActivityMaster',' id ="'.$activityQuotData['activityId'].'" '); 
			   $ActivityData=mysqli_fetch_array($otherActivitySql);

			   $c1=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$activityQuotData['activityQuotationId'].'" and quotationId="'.$activityQuotData['quotationId'].'"');
               $timelineresult=mysqli_fetch_array($c1);
 
					if($activityQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($activityQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($activityQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($activityQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($activityQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}

				    $rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$QueryDaysData1['cityId'].'"'); 
				    $DF=mysqli_fetch_array($rs51); 
				
								
			?> 
		  	<tr>
			<td    valign="middle" align="center">
			<?php 
			if($activityQuotData['fromDate']!='' && $activityQuotData['fromDate']!='0000-00-00' ){
				echo date('d/m/Y',strtotime($activityQuotData['fromDate']));  
			}else{
				echo date('d/m/Y',strtotime($quotResult['fromDate']));
			}   
 			?>
			</td>
			<td valign="middle" align="center"><?php echo strip($DF['name']); ?></td>
			<td valign="middle" align="center"><?php echo strip($ActivityData['otherActivityName']);  ?></td>		
			<td valign="middle" align="center"><?php if($timelineresult['startTime']!=''){ echo date('h:i A', strtotime($timelineresult['startTime'])); } ?></td>	
			<td valign="middle" align="center"><?php if($timelineresult['endTime']!='') { echo date('h:i A', strtotime($timelineresult['endTime'])); } ?></td>				
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>	

<?php 
$ec=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
$countentrance = mysqli_num_rows($ec); 
if($countentrance > 0){
?>
	<tr>	
		<td colspan="2" align="left"  width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="6"  valign="middle" ><strong>Entrance&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%"  valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Entrance&nbsp;Name</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Start&nbsp;Time</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>End&nbsp;Time</strong></td>
			<td  width="10%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td  colspan="2" width="20%" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$b = '';	
			$b=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($entranceQuotData=mysqli_fetch_array($b)){ 

			   $qr=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,' id ="'.$entranceQuotData['entranceQuotationId'].'" '); 
			   $quotResult=mysqli_fetch_array($qr);

               $where2=' id="'.$entranceQuotData['entranceId'].'"';  
			   $rs2=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,$where2); 
			   $editresult2 = mysqli_fetch_array($rs2);

			   $c1=GetPageRecord('*','quotationEntranceTimelineDetails',' hotelQuoteId="'.$entranceQuotData['entranceQuotationId'].'" and quotationId="'.$entranceQuotData['quotationId'].'"');
			   $timelineresult = mysqli_fetch_array($c1);

			    
					if($entranceQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($entranceQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($entranceQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($entranceQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($entranceQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}

				    $rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$quotResult['destinationId'].'"'); 
				    $DF=mysqli_fetch_array($rs51); 
				
								
			?> 
		  	<tr>
			<td    valign="middle" align="center">
			<?php 
			if($entranceQuotData['fromDate']!='' && $entranceQuotData['fromDate']!='0000-00-00' ){
				echo date('d/m/Y',strtotime($entranceQuotData['fromDate']));  
			}else{
				echo date('d/m/Y',strtotime($quotResult['fromDate']));
			}   
 			?>
			</td>
			<td valign="middle" align="center"><?php echo strip($DF['name']); ?></td>
			<td valign="middle" align="center"><?php echo clean($editresult2['entranceName']);  ?></td>		
			<td valign="middle" align="center"><?php if($timelineresult['startTime']!=''){ echo date('h:i A', strtotime($timelineresult['startTime'])); } ?></td>	
			<td valign="middle" align="center"><?php if($timelineresult['endTime']!='') { echo date('h:i A', strtotime($timelineresult['endTime'])); } ?></td>				
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>

<?php 
$mc=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
$countmeal = mysqli_num_rows($mc); 
if($countmeal > 0){
?>
	<tr>	
		<td colspan="2" align="left"  width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="5"  valign="middle" ><strong>Meal&nbsp;Plan&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%"  valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From</strong></td>
			<td  width="25%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Restaurant&nbsp;Name</strong></td>
			<td  width="25%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Meal&nbsp;Type</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td  colspan="2" width="20%" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$b = '';	
			$b=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($mealQuotData=mysqli_fetch_array($b)){ 

			   $qr=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' id ="'.$mealQuotData['mealplanQuotationId'].'" '); 
			   $quotResult=mysqli_fetch_array($qr);
 	
					if($mealQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($mealQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($mealQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($mealQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($mealQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}

				    $rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$quotResult['destinationId'].'"'); 
				    $DF=mysqli_fetch_array($rs51); 
				
								
			?> 
		  	<tr>
			<td    valign="middle" align="center">
			<?php 
			if($mealQuotData['fromDate']!='' && $mealQuotData['fromDate']!='0000-00-00' ){
				echo date('d/m/Y',strtotime($mealQuotData['fromDate']));  
			}else{
				echo date('d/m/Y',strtotime($quotResult['fromDate']));
			}   
 			?>
			</td>
			<td valign="middle" align="center"><?php echo strip($DF['name']); ?></td>
			<td valign="middle" align="center"><?php echo clean($mealQuotData['mealPlanName']);  ?></td>		
			<td valign="middle" align="center"><?php echo ($quotResult['mealType'] == 1)?'Lunch':'Dinner'; ?></td>	
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>

<?php 
$acc=GetPageRecord('*','finalQuoteExtra',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
$countadditinal = mysqli_num_rows($acc); 
if($countadditinal > 0){
?>
	<tr>	
		<td colspan="2" align="left"  width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="4"  valign="middle" ><strong>Addition&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%"  valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From</strong></td>
			<td  width="50%" align="left" valign="middle" bgcolor="#F4F4F4"><strong>Additional&nbsp;Name</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td  colspan="2" width="20%" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$b = '';	
			$b=GetPageRecord('*','finalQuoteExtra',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($additionalQuotData=mysqli_fetch_array($b)){ 

			   $qr=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' id ="'.$additionalQuotData['additionalQuotationId'].'" and quotationId ="'.$additionalQuotData['quotationId'].'" '); 
			   $quotResult=mysqli_fetch_array($qr);

			   $rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
 			   $extraData=mysqli_fetch_array($rs1); 
 
					if($additionalQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($additionalQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($additionalQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($additionalQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($additionalQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}

				    $rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$quotResult['destinationId'].'"'); 
				    $DF=mysqli_fetch_array($rs51); 
				
								
			?> 
		  	<tr>
			<td    valign="middle" align="center">
			<?php 
			if($additionalQuotData['fromDate']!='' && $additionalQuotData['fromDate']!='0000-00-00' ){
				echo date('d/m/Y',strtotime($additionalQuotData['fromDate']));  
			}else{
				echo date('d/m/Y',strtotime($quotResult['fromDate']));
			}    
			?>
			</td>
			<td valign="middle" align="center"><?php echo strip($DF['name']); ?></td>
			<td valign="middle" align="left"><?php echo clean($extraData['name']); ?></td>	
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>

<?php 
$erc=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
$countenrout = mysqli_num_rows($erc); 
if($countenrout > 0){
?>
	<tr>	
		<td colspan="2" align="left"  width="98%"> 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr>
			<td colspan="4"  valign="middle" ><strong>Enroute&nbsp;Status:</strong></td>
			</tr>
			<tr>
			<td  width="15%"  valign="middle" align="center" bgcolor="#F4F4F4"><strong>Date</strong></td>
			<td  width="15%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>From</strong></td>
			<td  width="50%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Enroute&nbsp;Name</strong></td>
			<td  width="20%" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Status</strong></td>
			</tr>
			<!-- <tr>
			<td  colspan="2" width="20%" valign="middle" align="center" bgcolor="#F4F4F4">&nbsp;</td>
			</tr> -->
			<?php 
			$b = '';	
			$b=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.decode($_REQUEST['id']).'"  order by fromDate asc'); 
			while($enrouteQuotData=mysqli_fetch_array($b)){ 

			   $qr=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,' id ="'.$enrouteQuotData['enrouteQuotationId'].'" and quotationId ="'.$enrouteQuotData['quotationId'].'" '); 
			   $quotResult=mysqli_fetch_array($qr);

			   $enrouteSql=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$enrouteQuotData['enrouteId'].'" and status=1'); 
			   $enrouteData=mysqli_fetch_array($enrouteSql);
 
					if($enrouteQuotData['manualStatus']=='0'){
                       $status='Pending';
					}
					if($enrouteQuotData['manualStatus']=='1'){
                       $status='Sent';
					}
					if($enrouteQuotData['manualStatus']=='2'){
                       $status='Requested';
					}
					if($enrouteQuotData['manualStatus']=='3'){
                       $status='Confirm';
					}
					if($enrouteQuotData['manualStatus']=='4'){
                       $status='Rejected';
					}

				    $rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$quotResult['destinationId'].'"'); 
				    $DF=mysqli_fetch_array($rs51); 
				
								
			?> 
		  	<tr>
			<td    valign="middle" align="center">
			<?php 
			if($enrouteQuotData['fromDate']!='' && $enrouteQuotData['fromDate']!='0000-00-00' ){
				echo date('d/m/Y',strtotime($enrouteQuotData['fromDate']));  
			}else{
				echo date('d/m/Y',strtotime($quotResult['fromDate']));
			}    
			?>
			</td>
			<td valign="middle" align="center"><?php echo strip($DF['name']); ?></td>
			<td valign="middle" align="center"><?php echo strip($enrouteData['enrouteName']); ?></td>	
			<td valign="middle" align="center"><?php echo $status; ?></td>
 			</tr>
		  	<?php } ?>
		</table>
		</td>
		<td width="2%"></td>
	</tr>
<?php } ?>
	<tr>	
	  <td colspan="2" align="left">&nbsp;</td>
	</tr>
	
    <tr>
    	<td colspan="2" align="center" valign="top">
			<div style="font-size:12px;">
			<a href="http://www.deboxglobal.com/travcrm.html" target="_blank" style="color:#666666;">Genrated by TravCRM</a> 
			</div> 
		</td>
    </tr>
    <tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>


	