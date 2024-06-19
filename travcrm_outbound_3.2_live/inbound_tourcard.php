<?php 
include "inc.php";  

$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$resultInvoiceSetting=mysqli_fetch_array($rs);

$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_GET['id']).'" '); 
$quotationData=mysqli_fetch_array($rs2); 
$quotword = ($quotationData['status'] == 1)? "Itinerary" : "Proposal"; // itinerary proposal
$rs3=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" '); 
$queryData=mysqli_fetch_array($rs3); 
// print_r($queryData);
$moduleType=$queryData['moduleType'];
$gitQuo=$queryData['queryType'];
$earlyCheckin = $queryData['earlyCheckin'];
//queryId="'.$queryData['id'].'" and status=1 
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_GET['id']).'"');  
$resultpageQuotation=mysqli_fetch_array($rsp); 

$queryId = $resultpageQuotation['queryId'];
$quotationId = $resultpageQuotation['id'];
$totalPackageCost = 0;
$noofpax = ($resultpageQuotation['adult']+$resultpageQuotation['child']);
$quotationId=$quotationData['id'];
$startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($quotationData['fromDate'])));     
$hotelNotinclude = 0;
$day=1;
$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" order by id asc');
if($queryData['clientType']=='1'){
	$select4='*';  
	$where4='id='.$queryData['companyId'].''; 
	$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 
	$resultCompany=mysqli_fetch_array($rs4);
	$agentnamev =  $resultCompany['name'];
	$mobilemailtype='corporate';
}

if($queryData['clientType']=='2'){
	$select4='*';  
	$where4='id='.$queryData['companyId'].''; 
	$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4); 
	$resultCompany=mysqli_fetch_array($rs4); 

	$agentnamev =  $resultCompany['firstName'].' '.$resultCompany['lastName'];

	$mobilemailtype='contacts';

}
?>

<table width="745" border="0" cellpadding="10" cellspacing="0" bordercolor="#000000">
  	 
 	<tr>
    	<td colspan="2" align="center" valign="top"><strong style="font-size:20px"><?php echo $resultInvoiceSetting['companyname'];?></strong></td>
  	</tr>
	<tr>
    	<td colspan="2" align="center" valign="top"><strong style="font-size:18px">Normal&nbsp;Tour&nbsp;Card</strong></td>
  	</tr>
  	<tr>
      <td colspan="2">
	  <table width="100%" border="0" align="left" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="15%">Refrence&nbsp;No</td>
			<td width="27%">:&nbsp;<?php echo $queryData['referanceNumber']; ?></td>
			<td width="31%">&nbsp;</td>
			<td width="14%">Arrival&nbsp;Date</td>
			<td width="31%">:&nbsp;<span style="color:#000;"><?php echo date('d/m/Y',strtotime($queryData['fromDate']));?></span></td>
		  </tr>
		  <tr>
			<td width="15%">Tour&nbsp;Id</td>
			<td width="27%">:&nbsp;<?php echo makeQueryTourId($queryData['id']); ?></td>
			<td width="31%">&nbsp;</td>
			<td width="14%">&nbsp;</td>
			<td width="31%">&nbsp;</td>
		  </tr>
		  <tr>
			<td><?php if($moduleType==1 && $gitQuo == 4){	echo 'Fix&nbsp;Departure&nbsp;Name'; }else{ echo 'Tour&nbsp;Name'; } ?></td>
			<td>:&nbsp;<?php echo $queryData['subject']; ?></td>
			<td>&nbsp;</td>
			<td>Departure&nbsp;Date</td>
			<td>:&nbsp;<span style="color:#000;"><?php echo date('d/m/Y',strtotime($queryData['toDate']));?></span></td>
		  </tr>
		  <tr>
		  	<td>
			<?php if($moduleType==1 ){	echo 'Agent&nbsp;Name'; }else{ echo 'Agent&nbsp;Reference'; } ?></td>
			<td>:&nbsp;<?php
			 echo $agentnamev;
			?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>No of Pax </td>
			<td>:&nbsp;<?php echo $noofpax; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="5">&nbsp;</td>
		  </tr>
		</table> 
	  </td>
  	</tr> 
	<tr>	 
		<td colspan="2" align="center" width="98%" > 
			<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  <tr>
			<td width="10%" rowspan="2" align="center" valign="middle" ><p><strong>Date</strong></p>
		    <p><strong>Day</strong></p></td>
			<td colspan="3" width="30%" valign="middle" align="center" ><strong>Transfer</strong></td>
			<td colspan="7" width="60%" align="center" valign="middle" ><strong>Hotel/City/Room type</strong></td>
		  </tr>
		  <tr>
			<td width="10%" valign="middle" align="center" ><strong>From/To</strong></td>
			<td width="11%" align="left" valign="middle" ><strong>By/Schedule</strong></td>
			<td width="9%" align="center" valign="middle" ><strong>Status</strong></td>
			<td width="19%" align="left" valign="middle" ><strong>Hotel / City/Room type</strong></td>
			<td width="5%" align="center" valign="middle" ><strong>Sgl</strong></td>
			<td width="5%" align="center" valign="middle" ><strong>Dbl</strong></td>
			<td width="5%" align="center" valign="middle" ><strong>Twn</strong></td>
			<td width="4%" align="center" valign="middle" ><strong>Tpl</strong></td>
			<td width="6%" align="center" valign="middle" ><strong>EBed(C)</strong></td>
			<td width="9%" align="center" valign="middle" ><strong>Status</strong></td>
 		  </tr>
		  <!-- <tr>
			  <td colspan="12" align="left" valign="middle" >Tour Id. <?php echo makeQueryId($queryData['id']); ?>&nbsp;<?php echo $queryData['subject']; ?></td>
		  </tr>
				 -->  
		<?php
		while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
			// print_r($QueryDaysData);
 		  $dayDate = date('Y-m-d', strtotime('+'.$day.' day', strtotime($startdatevar)));
		 
			$destname = getDestination($QueryDaysData['cityId']);
			
		  ?>
		  <tr>
			<td valign="middle" >Day&nbsp;<?php echo $day; ?><?php if($queryData['dayWise']==1){ ?><br><?php echo date('d-m-Y', strtotime($dayDate)); } ?></td>
			<td  valign="middle" ><?php echo $destname; ?></td>
			<td  valign="middle" >
			<?php 
			 $b1t=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'"  order by srn asc,id desc');
			 if(mysqli_num_rows( $b1t) > 0){	
				while($sorting11=mysqli_fetch_array($b1t)){
					
				  if($sorting11['serviceType']=='transportation'){
          // quotation hotel data   
					$ct=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting11['serviceId'].'"  order by id desc'); 
					$hotelQuotDatat=mysqli_fetch_array($ct);
			
					$select21='name,maxpax';  
					$where21='id="'.$hotelQuotDatat['vehicleId'].'"'; 
					$rs21=GetPageRecord($select21,_VEHICLE_MASTER_MASTER_,$where21); 
					$editresult21=mysqli_fetch_array($rs21); 
				
					// hotel data
					$d12=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$hotelQuotDatat['transferNameId'].'"');   
					$tansferDatat=mysqli_fetch_array($d12);
			
				    // echo $tansferData['transferName']. '<br><br>' .$editresult2['name'];
			
					$tan4sferData = clean($tansferDatat['transferName']).'<br><br><br>'.clean($editresult21['name']);
			
						echo 'Surface'.'<br>';
				  }
				 if($sorting11['serviceType']=='transfer'){
				 	// quotation hotel data  
        $c=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting11['serviceId'].'"  order by id desc'); 
        $hotelQuotData=mysqli_fetch_array($c);

        $select2='name,maxpax';  
    $where2='id="'.$hotelQuotData['vehicleId'].'"'; 
    $rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
    $editresult2=mysqli_fetch_array($rs2); 
    

        // hotel data
        $d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$hotelQuotData['transferId'].'"');   
        $tansferData=mysqli_fetch_array($d);

          // echo $tansferData['transferName']. '<br><br>' .$editresult2['name'];

        $tan4sferData = clean($tansferData['transferName']).'<br><br><br>'.clean($editresult2['name']);

        echo ltrim($tan4sferData,"<br>");
				 } 

				 if($sorting11['serviceType']=='train'){
				 	$ctrain=GetPageRecord('*',' finalQuoteTrains',' quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting11['serviceId'].'"  order by id desc'); 
				   ;
					$trainQuotData=mysqli_fetch_array($ctrain);
						
					// hotel data
					$d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$trainQuotData['trainId'].'"');   
					$trainData=mysqli_fetch_array($d);
			
			
					echo  $trainQuotData['trainNumber'].'<br><br>'.$trainData['trainName'];
				 } 

				 if($sorting11['serviceType']=='flight'){
				 	// quotation hotel data 
			
				   
					$cflight=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting11['serviceId'].'"  order by id desc'); 
				   
					$flightQuotData=mysqli_fetch_array($cflight);
						
					// hotel data
					$d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$flightQuotData['flightId'].'"');   
					$flightData=mysqli_fetch_array($d);
			
			
					// print_r($flightData);
			
					echo $flightData['flightNo'].'<br><br>'.$flightData['flightName'];
				 } 	
	


				}
			 }
			?>
			</td>
			<td  valign="middle" >	<?php 
			 $b1ts=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'"  order by srn asc,id desc');
			 if(mysqli_num_rows( $b1ts) > 0){	
				while($sortings=mysqli_fetch_array($b1ts)){
					
				  if($sortings['serviceType']=='transportation'){
                      // quotation hotel data   
					$ct=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sortings['serviceId'].'"  order by id desc'); 
					$hotelQuotDatat=mysqli_fetch_array($ct);
			 
					if($hotelQuotDatat['manualStatus']=='0'){
						echo 'Pending';
					}
					if($hotelQuotDatat['manualStatus']=='1'){
						echo 'Sent';
					}
					if($hotelQuotDatat['manualStatus']=='2'){
						echo 'Requested';
					}
					if($hotelQuotDatat['manualStatus']=='3'){
						echo 'Confirm';
					}
					if($hotelQuotDatat['manualStatus']=='4'){
						echo 'Rejected';
					}
				  }
				 if($sortings['serviceType']=='transfer'){
				 	// quotation hotel data  
                   $c=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sortings['serviceId'].'"  order by id desc'); 
                   $hotelQuotData=mysqli_fetch_array($c);
 
					if($hotelQuotDatat['manualStatus']=='0'){
						echo 'Pending';
					}
					if($hotelQuotDatat['manualStatus']=='1'){
						echo 'Sent';
					}
					if($hotelQuotDatat['manualStatus']=='2'){
						echo 'Requested';
					}
					if($hotelQuotDatat['manualStatus']=='3'){
						echo 'Confirm';
					}
					if($hotelQuotDatat['manualStatus']=='4'){
						echo 'Rejected';
					}
				 } 

				 if($sortings['serviceType']=='train'){
				 	$ctrain=GetPageRecord('*',' finalQuoteTrains',' quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sortings['serviceId'].'"  order by id desc'); 
				   ;
					$trainQuotData=mysqli_fetch_array($ctrain);
						 
					if($trainQuotData['manualStatus']=='0'){
						echo 'Pending';
					}
					if($trainQuotData['manualStatus']=='1'){
						echo 'Sent';
					}
					if($trainQuotData['manualStatus']=='2'){
						echo 'Requested';
					}
					if($trainQuotData['manualStatus']=='3'){
						echo 'Confirm';
					}
					if($trainQuotData['manualStatus']=='4'){
						echo 'Rejected';
					}	
				 } 

				 if($sortings['serviceType']=='flight'){
				 	// quotation hotel data 
			
				   
					$cflight=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sortings['serviceId'].'"  order by id desc'); 
				   
					$flightQuotData=mysqli_fetch_array($cflight);
 
					if($flightQuotData['manualStatus']=='0'){
						echo 'Pending';
					}
					if($flightQuotData['manualStatus']=='1'){
						echo 'Sent';
					}
					if($flightQuotData['manualStatus']=='2'){
						echo 'Requested';
					}
					if($flightQuotData['manualStatus']=='3'){
						echo 'Confirm';
					}
					if($flightQuotData['manualStatus']=='4'){
						echo 'Rejected';
					}	
					
				 } 	
	


				}
			 }
			?></td>
			<td align="left" valign="middle" ><?php 
        	$b1=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'" and serviceType="hotel" order by srn asc,id desc'); 
        	while($sorting1=mysqli_fetch_array($b1)){
          		if(mysqli_num_rows($b1) > 0){
        			
						$cfroom	=GetPageRecord('*', 'finalQuote',' quotationId="'.$sorting1['quotationId'].'" and id="'.$sorting1['serviceId'].'"   order by id desc'); 
			
						while($hotelQuotDataf=mysqli_fetch_array($cfroom)){

								$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotDataf['hotelId'].'"');   
								$hotelData=mysqli_fetch_array($d);
						
								$select12='*';  
								$where12='id="'.$hotelQuotDataf['roomType'].'"'; 
								$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12);
								$editresult2=mysqli_fetch_array($rs12);
								echo $hotelName = $hotelData['hotelName'].'<br>('.$editresult2['name'].')<br><br>'.$destname;
							        
						}
					 }
         	}
		 	?></td>
			<td align="center"  valign="middle" ><?php 
          	$broom=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'" and serviceType="hotel" order by srn asc,id desc'); 
        	while($sortingroom=mysqli_fetch_array($broom)){
          if(mysqli_num_rows($broom) > 0){

						$cfroom=GetPageRecord('*', 'finalQuote',' quotationId="'.$sortingroom['quotationId'].'" and id="'.$sortingroom['serviceId'].'"  order by id desc'); 
						$hotelQuotDataf=mysqli_fetch_array($cfroom);

						echo $hotelQuotDataf['roomSingle']; 

        

         }

         }?></td>
			<td align="center"  valign="middle" ><?php

				$broom=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'" and serviceType="hotel" order by srn asc,id desc'); 
				while($sortingroom=mysqli_fetch_array($broom)){
					if(mysqli_num_rows($broom) > 0){

						$cfroom=GetPageRecord('*', 'finalQuote',' quotationId="'.$sortingroom['quotationId'].'" and id="'.$sortingroom['serviceId'].'"  order by id desc'); 
						$hotelQuotDataf=mysqli_fetch_array($cfroom);
						echo $hotelQuotDataf['roomDouble']; 
					}	
				}
			?></td>
			<td align="center"  valign="middle" ><?php

              $broom=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'" and serviceType="hotel" order by srn asc,id desc'); 
        	while($sortingroom=mysqli_fetch_array($broom)){
				if(mysqli_num_rows($broom) > 0){
				
					$cfroom=GetPageRecord('*', 'finalQuote',' quotationId="'.$sortingroom['quotationId'].'" and id="'.$sortingroom['serviceId'].'"  order by id desc'); 
					$hotelQuotDataf=mysqli_fetch_array($cfroom);
					echo $hotelQuotDataf['roomTwin']; 
				}	
			}
			?></td>
			<td align="center"  valign="middle" ><?php 
 			$broom=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'" and serviceType="hotel" order by srn asc,id desc'); 
        while($sortingroom=mysqli_fetch_array($broom)){
          if(mysqli_num_rows($broom) > 0){
						$cfroom=GetPageRecord('*', 'finalQuote',' quotationId="'.$sortingroom['quotationId'].'"  and id="'.$sortingroom['serviceId'].'" order by id desc'); 
						$hotelQuotDataf=mysqli_fetch_array($cfroom);
						echo $hotelQuotDataf['roomTriple']; 
         }

         } ?></td>
			<td align="center"  valign="middle" >
		<?php 

		$broom=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'" and serviceType="hotel" order by srn asc,id desc'); 
        while($sortingroom=mysqli_fetch_array($broom)){
          if(mysqli_num_rows($broom) > 0){
		        	// quotation hotel data
		        	$croom=GetPageRecord('*','finalQuote',' quotationId="'.$sortingroom['quotationId'].'" and id="'.$sortingroom['serviceId'].'"  order by id desc');
		        	$hotelQuotDatar=mysqli_fetch_array($croom);
							echo $hotelQuotDatar['roomEBedC']; 
				  }
        } 
		 ?></td>
			<td  valign="middle" ><?php 

				$broom=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$QueryDaysData['id'].'" and serviceType="hotel" order by srn asc,id desc'); 
		        while($sortingroom=mysqli_fetch_array($broom)){
		          if(mysqli_num_rows($broom) > 0){
		        	// quotation hotel data 	
		        	$croom=GetPageRecord('*','finalQuote',' quotationId="'.$sortingroom['quotationId'].'" and id="'.$sortingroom['serviceId'].'"  order by id desc');
		        	$hotelQuotDatar=mysqli_fetch_array($croom); 
					if($hotelQuotDatar['manualStatus']=='0'){
					   echo 'Pending';
					}
					if($hotelQuotDatar['manualStatus']=='1'){
					   echo 'Sent';
					}
					if($hotelQuotDatar['manualStatus']=='2'){
					   echo 'Requested';
					}
					if($hotelQuotDatar['manualStatus']=='3'){
					   echo 'Confirm';
					}
					if($hotelQuotDatar['manualStatus']=='4'){
					   echo 'Rejected';
					}
				  }
        } 
		 ?></td>
 		  </tr>
		  <?php $day++;}  ?> 
		  </table>
		</td>
		<td colspan="2" align="center" width="2%" ></td>
	</tr>
	
	<tr style="page-break-inside:avoid">	 
		<td colspan="2" align="center" > 
		<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		 <tr>
			<td colspan="4" valign="middle" align="left"><strong>File&nbsp;Notes</strong></td>
		  </tr>  
		  <tr>
 			<td width="28%" valign="left" ><strong>Description</strong></td>
			<td width="27%" align="left" valign="middle" ><strong>Action&nbsp;Date</strong></td>
 			<td width="27%" align="left" valign="middle" ><strong>Actioned&nbsp;Date</strong></td>
			<td width="18%" align="left" valign="middle" ><strong>Status</strong></td>
 		  </tr>
		<?php 
		//echo ' queryId="'.$queryData['id'].'" order by id asc';
		$todo=GetPageRecord('*',_CHECK_TODOLIST_MASTER_,' queryId="'.$queryData['id'].'" order by id asc'); 
		while ($todolist=mysqli_fetch_array($todo)) {
		$task=GetPageRecord('*',_TASK_MASTER_,' id="'.$todolist['taskId'].'" order by id asc');
		$taskName=mysqli_fetch_array($task);
		?> 
		<tr>
			<td align="left"><?php echo $taskName['taskName']; ?></td>
			<td align="left"><?php echo date('l j F Y',strtotime($todolist['actionDate'])); ?></td>
			<td align="left"><?php echo date('l j F Y',strtotime($todolist['completionDate'])); ?></td>
			<td align="left"><?php 
    		if ($todolist['statusId']==1){ 		  
			  echo "Pending";
			}
			if ($todolist['statusId']==2) {
			  echo "In Process";
			}
			if ($todolist['statusId']==3) {
			  echo "Done";
			}
			?>
			</td>
  		</tr> 
		<?php } ?> 
		  </table>
		</td>
	</tr>
	<tr>
	  	<td colspan="2" align="center">&nbsp; </td>
  	</tr>
	<!-- <tr>
    	<td colspan="2" align="center" valign="top">
			<div style="font-size:12px;">
			<a href="http://www.deboxglobal.com/travcrm.html" target="_blank" style="color:#666666;">Genrated by TravCRM</a> 
			</div> 
		</td>
    </tr> -->
    <tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>


	