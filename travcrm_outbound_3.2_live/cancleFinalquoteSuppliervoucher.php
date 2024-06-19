<?php 
include "inc.php";

$type = $_REQUEST['type'];
$QuotId = $_REQUEST['QuotId'];
$supplierId = $_REQUEST['supplierId'];
$serviceId = $_REQUEST['serviceId'];
$quotationId = $_REQUEST['quotationId'];
if($type=='hotel'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and hotelId="'.$serviceId.'"';
  $update = updatelisting('finalQuote',$namevalue,$where);
  }
if($type=='transfer'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and transferId="'.$serviceId.'"';
  $update = updatelisting('finalQuotetransfer',$namevalue,$where);
    }

if($type=='entrance'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and entranceId="'.$serviceId.'"';
  $update = updatelisting('finalQuoteEntrance',$namevalue,$where);
   
}
if($type=='activity'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and activityId="'.$serviceId.'"';
  $update = updatelisting('finalQuoteActivity',$namevalue,$where);
  
}
if($type=='train'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and trainId="'.$serviceId.'"';
  $update = updatelisting('finalQuoteTrains',$namevalue,$where);
   
}
if($type=='flight'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and flightId="'.$serviceId.'"';
  $update = updatelisting('finalQuoteFlights',$namevalue,$where);
   
}
if($type=='guide'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and guideId="'.$serviceId.'"';
  $update = updatelisting('finalQuoteGuides',$namevalue,$where);
   
}
if($type=='meal'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and mealplanQuotationId="'.$serviceId.'"';
  $update = updatelisting('finalQuoteMealPlan',$namevalue,$where);
   
}
if($type=='additional'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and additionalId="'.$serviceId.'"';
  $update = updatelisting('finalQuoteExtra',$namevalue,$where);
   
}
if($type=='enrout'){
  $namevalue ='supplierId="'.$supplierId.'"';
  $where='id="'.$QuotId.'" and enrouteId="'.$serviceId.'"';
  $update = updatelisting('finalQuoteEnroute',$namevalue,$where);
   
}
 ?>

<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
  <thead>
    <tr>  
      <th align="left" bgcolor="#ddd">Assigned Services</th>
      </tr>
  </thead>
  <tbody > 
      <tr>
      <td width="100%" align="left" valign="top" style="padding:10px !important; "><div style="font-size:15px;padding:0px; margin-bottom:10px; position:relative;">
	       <form id="listform" name="listform" method="get">
            <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
              <thead>
          <tr>
          <th width="23%" align="left"  bgcolor="#F4F4F4"><strong>Service Name</strong></th>
		  <th width="16%" align="left"  bgcolor="#F4F4F4"><strong>Supplier Name</strong></th>
          <th width="16%"  bgcolor="#F4F4F4"><strong>Action</strong></th>
          </tr> 
        </thead>
        <tbody>
    <?php
    $b= "";
    $b=GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and supplierId!=0  order by fromDate asc'); 
    while($finalQuotData=mysqli_fetch_array($b)){ 
		
		$cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuotData['quotationId'].'" and serviceId="'.$finalQuotData['id'].'"  order by id asc'); 
		$finalQuoteItinerary=mysqli_fetch_array($cItinerary);
		
        $b1=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'id="'.$finalQuotData['hotelQuotationId'].'"');      
        $hotelQuotData=mysqli_fetch_array($b1);
  
    $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$finalQuotData['hotelId'].'"');   
    $hotelData=mysqli_fetch_array($d); 


       if($finalQuotData['supplierId']!='' && $finalQuotData['supplierId']!=0){
        $supplierId = $finalQuotData['supplierId'];
      }
      
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'" and deletestatus=0 and status=1 and name!="" and companyTypeId=1 order by name'); 
      $supplierData=mysqli_fetch_array($bb);
	  
    //check if supplier is self 
      
      ?>  
          <tr id="selectedcon<?php echo $finalQuotData['id']; ?>">
            <td align="left" ><strong>Hotel:&nbsp;</strong><?php echo strip($hotelData['hotelName']);?>&nbsp;(&nbsp;<?php echo $hcity = strip($hotelData['hotelCity']);  ?>&nbsp;)&nbsp;|&nbsp;<?php echo showStarrating($hotelData['hotelCategory']);   ?></td>
			<td align="left" ><?php echo $supplierData['name']; ?></td>
			<?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
             <td  align="center" style="color:red;">Cancelled</td> <?php } ?>
          </tr>
      <?php } ?>
	<?php
	$bit=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationId.'"  order by startDate asc'); 
    while($itineraryDetail=mysqli_fetch_array($bit)){ 

    if($itineraryDetail['serviceType']=='transportation'){ 
  $btr=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$itineraryDetail['quotationId'].'" and id="'.$itineraryDetail['serviceId'].'" and supplierId!=0  order by fromDate asc'); 
  while($finalQuotTransfer=mysqli_fetch_array($btr)){   
  
    $c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' id="'.$finalQuotTransfer['transferQuotationId'].'"  order by fromDate asc'); 
  $transferQuotData=mysqli_fetch_array($c);

    // hotel data
    $d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$transferQuotData['transferNameId'].'"');   
    $transferData=mysqli_fetch_array($d);
    
    $d=GetPageRecord('*','vehicleMaster','id="'.$transferQuotData['vehicleModelId'].'"'); 
    $vehicleData=mysqli_fetch_array($d);
    
    $e=GetPageRecord('*','vehicleBrand','id="'.$vehicleData['brand'].'"'); 
    $vehicleBrandData=mysqli_fetch_array($e); 

       if($finalQuotTransfer['supplierId']!='' && $finalQuotTransfer['supplierId']!=0){
        $supplierId = $finalQuotTransfer['supplierId'];
      }
      
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);
    //check if supplier is self 
    
    ?>
          <tr id="selectedcon<?php echo $finalQuotTransfer['id']; ?>">
             <td align="left" ><strong>Transportation:&nbsp;</strong><?php echo strip($transferData['transferName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($transferQuotData['destinationId']);  ?>&nbsp;)</td>
			 <td align="left" ><?php echo $supplierData['name']; ?></td>
			 <?php if($itineraryDetail['cancelVoucher']==1){ ?><td  align="center" style="color:red;">Cancelled</td><?php } ?>
          </tr>
    <?php
  }}if($itineraryDetail['serviceType']=='transfer'){ 
  $btran=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$itineraryDetail['quotationId'].'" and id="'.$itineraryDetail['serviceId'].'" and supplierId!=0  order by fromDate asc'); 
  while($finalQuotTransfer=mysqli_fetch_array($btran)){   
  
    $c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' id="'.$finalQuotTransfer['transferQuotationId'].'"  order by fromDate asc'); 
  $transferQuotData=mysqli_fetch_array($c);

    // hotel data
    $d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$transferQuotData['transferNameId'].'"');   
    $transferData=mysqli_fetch_array($d);
    
    $d=GetPageRecord('*','vehicleMaster','id="'.$transferQuotData['vehicleModelId'].'"'); 
    $vehicleData=mysqli_fetch_array($d);
    
    $e=GetPageRecord('*','vehicleBrand','id="'.$vehicleData['brand'].'"'); 
    $vehicleBrandData=mysqli_fetch_array($e); 

       if($finalQuotTransfer['supplierId']!='' && $finalQuotTransfer['supplierId']!=0){
        $supplierId = $finalQuotTransfer['supplierId'];
      }
      
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);
    //check if supplier is self 
    
    ?>
          <tr id="selectedcon<?php echo $finalQuotTransfer['id']; ?>">
             <td align="left" ><strong>Transfer:&nbsp;</strong><?php echo strip($transferData['transferName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($transferQuotData['destinationId']);  ?>&nbsp;)</td>
			 <td align="left" ><?php echo $supplierData['name']; ?></td>
              <?php if($itineraryDetail['cancelVoucher']==1){ ?>
             <td  align="center" style="color:red;">Cancelled</td> <?php } ?>
          </tr>
    <?php
  }}} 
    ?>  
    <?php 
  //for entrance
	$b="";
	$b=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationId.'" and supplierId!=0 order by fromDate asc'); 
	while($finalQuoteEntranceData=mysqli_fetch_array($b)){ 
	
	$cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuoteEntranceData['quotationId'].'" and serviceId="'.$finalQuoteEntranceData['id'].'"  order by id asc'); 
	$finalQuoteItinerary=mysqli_fetch_array($cItinerary);
	
	$b2=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,'id="'.$finalQuoteEntranceData['entranceQuotationId'].'"  order by fromDate asc'); 
	$entranceQuotData=mysqli_fetch_array($b2);
	$d=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$entranceQuotData['entranceNameId'].'"');   
	$entranceData=mysqli_fetch_array($d);
					
	
	if($finalQuoteEntranceData['supplierId']!='' && $finalQuoteEntranceData['supplierId']!=0){
	$supplierId = $finalQuoteEntranceData['supplierId'];
	}
	
	$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
	$supplierData=mysqli_fetch_array($bb);
	//check if supplier is self 
						?>
	  <tr id="selectedcon<?php echo $finalQuoteEntranceData['id']; ?>">
		
					   <td align="left"><strong>Entrance:&nbsp;</strong><?php echo strip($entranceData['entranceName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($entranceData['entranceCity']);  ?>&nbsp;)</td>
					   <td align="left" ><?php echo $supplierData['name']; ?></td>
					<?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
			<td  align="center" style="color:red;">Cancelled</td> <?php } ?>
					  
	  </tr>
	   <?php }   
    ?>
	<?php
	//for activity 
	$b="";
    $b=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationId.'"  and supplierId!=0 order by fromDate asc'); 
    while($finalQuoteActivityData=mysqli_fetch_array($b)){ 
	    
	$cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuoteActivityData['quotationId'].'" and serviceId="'.$finalQuoteActivityData['id'].'"  order by id asc'); 
	$finalQuoteItinerary=mysqli_fetch_array($cItinerary);
	
	$dsssss=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' id="'.$finalQuoteActivityData['activityQuotationId'].'" and quotationId="'.$quotationId.'"  order by fromDate asc');    
	$activityQuotData=mysqli_fetch_array($dsssss);
	
	$d=GetPageRecord('*','dmcotherActivityRate',' otherActivityNameId="'.$activityQuotData['otherActivityName'].'"');   
	$dmcActivityData=mysqli_fetch_array($d);
	
	$d12=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.$finalQuoteActivityData['activityId'].'"');
	$activityData=mysqli_fetch_array($d12);
	
	if($finalQuoteActivityData['supplierId']!='' && $finalQuoteActivityData['supplierId']!=0){
	$supplierId = $finalQuoteActivityData['supplierId'];
	}
	
	$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
	$supplierData=mysqli_fetch_array($bb);
     

                    ?>  
          <tr id="selectedcon<?php echo $finalQuoteActivityData['id']; ?>">
            <td align="left"><strong>Activity:&nbsp;</strong><?php echo strip($activityData['otherActivityName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($activityData['otherActivityCity']);  ?>&nbsp;)</td>
			<td align="left" ><?php echo $supplierData['name']; ?></td> 
             <?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
			<td  align="center" style="color:red;">Cancelled</td> <?php } ?>
          </tr>
           <?php }
	?>
	<?php 
	//for train
	$b="";
  $b=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationId.'"  and supplierId!=0 order by fromDate asc');         
  while($finalQuoteTrainData=mysqli_fetch_array($b)){ 
   
   $cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuoteTrainData['quotationId'].'" and serviceId="'.$finalQuoteTrainData['id'].'"  order by id asc'); 
	$finalQuoteItinerary=mysqli_fetch_array($cItinerary);
   
    $e=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'id="'.$finalQuoteTrainData['trainQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc'); 
  $trainQuotData=mysqli_fetch_array($e);
  
  $d23=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuotData['trainId'].'"');   
  $trainData=mysqli_fetch_array($d23);


       if($finalQuoteTrainData['supplierId']!='' && $finalQuoteTrainData['supplierId']!=0){
        $supplierId = $finalQuoteTrainData['supplierId'];
      }
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);

    ?>
          <tr id="selectedcon<?php echo $finalQuoteTrainData['id']; ?>">
            <td align="left" ><strong>Train:&nbsp;</strong><?php echo strip($trainData['trainName']);  ?>&nbsp;(&nbsp;<?php echo getDestination($trainQuotData['destinationId']);  ?>&nbsp;) </td>
			<td align="left" ><?php echo $supplierData['name']; ?></td>
             <?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
			<td  align="center" style="color:red;">Cancelled</td><?php } ?>			 
          </tr>
          <?php }
	?>
	<?php 
	//for flight
	$b="";
   $b=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationId.'" and  supplierId!=0 order by fromDate asc');
   while($finalQuoteFlightData=mysqli_fetch_array($b)){
   
    $cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuoteFlightData['quotationId'].'" and serviceId="'.$finalQuoteFlightData['id'].'"  order by id asc'); 
	$finalQuoteItinerary=mysqli_fetch_array($cItinerary);
   
   $f=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'id="'.$finalQuoteFlightData['flightQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc');
   $flightQuotData=mysqli_fetch_array($f);
  
    $d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuotData['flightId'].'"');   
    $flightData=mysqli_fetch_array($d);
    
      $Ecity = getDestination($flightQuotData['destinationId']);

       if($finalQuoteFlightData['supplierId']!='' && $finalQuoteFlightData['supplierId']!=0){
        $supplierId = $finalQuoteFlightData['supplierId'];
      }
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);

       
    ?>  
          <tr id="selectedcon<?php echo $finalQuoteFlightData['id']; ?>">
             <td align="left" ><strong>Flight:&nbsp;</strong><?php echo strip($flightData['flightName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
			 <td align="left" ><?php echo $supplierData['name']; ?></td>
            <?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
			<td  align="center" style="color:red;">Cancelled</td> <?php } ?>			 
          </tr>
        <?php }
	?>
	<?php 
	//for guide
	$b="";
$b=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationId.'" and supplierId!=0  order by fromDate asc'); 
while($finalQuoteGuideData=mysqli_fetch_array($b)){ 

$cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuoteGuideData['quotationId'].'" and serviceId="'.$finalQuoteGuideData['id'].'"  order by id asc'); 
	$finalQuoteItinerary=mysqli_fetch_array($cItinerary);

$g=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' id="'.$finalQuoteGuideData['guideQuotationId'].'" and quotationId="'.$quotationId.'" order by id desc'); 
$guideQuotData=mysqli_fetch_array($g);
  
    $d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$guideQuotData['guideId'].'"');   
    $guideData=mysqli_fetch_array($d);
    
        $Ecity = getDestination($guideQuotData['destinationId']);  

    

       if($finalQuoteGuideData['supplierId']!='' && $finalQuoteGuideData['supplierId']!=0){
        $supplierId = $finalQuoteGuideData['supplierId'];
      }
      
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);
    ?>
          <tr id="selectedcon<?php echo $finalQuoteGuideData['id']; ?>">
             <td align="left" ><strong>Guide:&nbsp;</strong><?php echo strip($guideData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
			 <td align="left" ><?php echo $supplierData['name']; ?></td>
             <?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
			<td  align="center" style="color:red;">Cancelled</td> <?php } ?>		
          </tr>
      <?php }
	?>
	<?php 
	//for mealplan
	$bm=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationId.'" and supplierId!=0 order by fromDate asc'); 
    while($finalQuoteMealData=mysqli_fetch_array($bm)){
	 
	$cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuoteMealData['quotationId'].'" and serviceId="'.$finalQuoteMealData['id'].'"  order by id asc'); 
	$finalQuoteItinerary=mysqli_fetch_array($cItinerary);
	
    $b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,'id="'.$finalQuoteMealData['mealplanQuotationId'].'" and quotationId="'.$quotationId.'" order by fromDate asc');    
  $mealQuotData=mysqli_fetch_array($b);

       if($finalQuoteMealData['supplierId']!='' && $finalQuoteMealData['supplierId']!=0){
        $supplierId = $finalQuoteMealData['supplierId'];
      }
      
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);  
  ?>  
          <tr id="selectedcon<?php echo $finalQuoteMealData['id']; ?>">
             <td align="left" ><strong>Restaurant:&nbsp;</strong><?php echo strip($mealQuotData['mealPlanName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($mealQuotData['destinationId']);  ?>&nbsp;)</td>
			 <td align="left" ><?php echo $supplierData['name']; ?></td>
            <?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
			<td  align="center" style="color:red;">Cancelled</td> <?php } ?>		
          </tr>
        <?php }
    ?>
	<?php 
	//for additional
	$b="";
	$b=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationId.'" and supplierId!=0 order by fromDate asc'); 
	while($finalQuoteAdditionalData=mysqli_fetch_array($b)){
	
	$cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuoteAdditionalData['quotationId'].'" and serviceId="'.$finalQuoteAdditionalData['id'].'"  order by id asc');
	$finalQuoteItinerary=mysqli_fetch_array($cItinerary);
	
	$b3=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' id="'.$finalQuoteAdditionalData['additionalQuotationId'].'" and quotationId="'.$quotationId.'" order by fromDate asc'); 
	$additionalQuotData=mysqli_fetch_array($b3);
	  $d=GetPageRecord('*','extraQuotation',' id="'.$additionalQuotData['additionalId'].'"');   
		$additionalData=mysqli_fetch_array($d);
		$Ecity = getDestination($additionalQuotData['destinationId']);
	
	
		   if($finalQuoteAdditionalData['supplierId']!='' && $finalQuoteAdditionalData['supplierId']!=0){
			$supplierId = $finalQuoteAdditionalData['supplierId'];
		  }
		  
		  $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
		  $supplierData=mysqli_fetch_array($bb);  
	
		?>  
			  <tr id="selectedcon<?php echo $finalQuoteAdditionalData['id']; ?>">
				 <td align="left" ><strong>Additional:&nbsp;</strong><?php echo strip($additionalData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
				 <td align="left" ><?php echo $supplierData['name']; ?></td>
				  <?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
			<td  align="center" style="color:red;">Cancelled</td> <?php } ?>		
			  </tr>
			<?php }
	?>
    <?php
	//for enroute
	$b="";
  $b=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$quotationId.'" and supplierId!=0  order by fromDate asc'); 
  while($finalQuoteEnrouteData=mysqli_fetch_array($b)){ 
  
  $cItinerary=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$finalQuoteEnrouteData['quotationId'].'" and serviceId="'.$finalQuoteEnrouteData['id'].'"  order by id asc');
	$finalQuoteItinerary=mysqli_fetch_array($cItinerary);
	
$b4=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,' id="'.$finalQuoteEnrouteData['enrouteQuotationId'].'" and quotationId="'.$quotationId.'"  order by fromDate asc'); 
  $enrouteQuotData=mysqli_fetch_array($b4);
  $d=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$enrouteQuotData['enrouteId'].'"');   
    $enrouteData=mysqli_fetch_array($d);
    
    $Ecity = getDestination($enrouteQuotData['destinationId']);

       if($finalQuoteEnrouteData['supplierId']!='' && $finalQuoteEnrouteData['supplierId']!=0){
        $supplierId = $finalQuoteEnrouteData['supplierId'];
      }
      
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);  
  
    ?>  
          <tr id="selectedcon<?php echo $finalQuoteEnrouteData['id']; ?>">
            <td align="left" ><strong>Enroute:&nbsp;</strong><?php echo strip($enrouteData['enrouteName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
			<td align="left" ><?php echo $supplierData['name']; ?></td>
             <?php if($finalQuoteItinerary['cancelVoucher']==1){ ?>
			<td  align="center" style="color:red;">Cancelled</td> <?php } ?>		
          </tr>
        <?php } 
	?>
	
        </tbody>
            </table>         
        </form>    
        </div>
            
          </td>
      </tr>
      
  </tbody>
</table>
