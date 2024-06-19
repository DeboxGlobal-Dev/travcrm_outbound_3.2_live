<?php 
include "inc.php";
$type = $_REQUEST['type'];
$QuotId = $_REQUEST['QuotId'];
$supplierId = $_REQUEST['supplierId'];
$serviceId = $_REQUEST['serviceId'];
$quotationId = $_REQUEST['quotationId']; 
$queryId= $_REQUEST['queryId']; 
 ?>

<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
   <tbody >
    <tr>
      <td width="100%" align="left" valign="top" style="padding:10px !important; "><div style="font-size:15px;padding:0px; margin-bottom:10px; position:relative;">
          <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
            <thead>
              <tr>
                <th width="67%" align="left"  bgcolor="#F4F4F4"><strong>Service Name</strong></th>
                <th width="20%" align="left"  bgcolor="#F4F4F4">Type</th>
                <th width="13%" align="left" bgcolor="#F4F4F4"><div align="center"><strong>Action</strong></div></th>
              </tr>
            </thead>
            <tbody>
              <?php
      $b= "";
    $b=GetPageRecord('*','finalQuote',' quotationId="'.$quotationId.'" and supplierId!=0  order by fromDate asc'); 
    while($finalQuotData=mysqli_fetch_array($b)){ 

        $b1=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'id="'.$finalQuotData['hotelQuotationId'].'"');      
        $hotelQuotData=mysqli_fetch_array($b1);
  
		$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$finalQuotData['hotelId'].'"');   
		$hotelData=mysqli_fetch_array($d); 
 
       if($finalQuotData['supplierId']!='' && $finalQuotData['supplierId']!=0){
        $supplierId = $finalQuotData['supplierId'];
      }
      
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);
	  	  $bbc=GetPageRecord('*','hotelCategoryMaster',' id="'.$hotelData['hotelCategoryId'].'"'); 
      $hcData=mysqli_fetch_array($bbc);
      
      ?>
              <tr id="selectedcon<?php echo $finalQuotData['id']; ?>">
                <td align="left" ><?php echo strip($hotelData['hotelName']);?>&nbsp;(&nbsp;<?php echo $hcity = strip($hotelData['hotelCity']);  ?>&nbsp;)&nbsp;|&nbsp;<?php echo trim($hcData['hotelCategory']).' Star';   ?></td>
                <td align="left" ><strong>Hotel</strong></td>
                <td align="left"> 
				<?php
				$nameDB=$hotelData['hotelName'].' ( '.$hcity = $hotelData['hotelCity'].' )'.' | '.showStarrating($hotelData['hotelCategory']);
				$chHotelq=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDB.'"'); 
				$chHotel=mysqli_num_rows($chHotelq);   
				if($chHotel==0){
				?>
				  <div align="center"><a title="Action" style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=1&hotelid=<?php echo encode($finalQuotData['hotelId']); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				  <?php } ?>
				  </td>
              </tr>
              <?php } ?>
              <?php
  $b= "";
  $b=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationId.'" and supplierId!=0  order by fromDate asc'); 
  while($finalQuotTransfer=mysqli_fetch_array($b)){   
  
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
 <td align="left" ><?php echo strip($transferData['transferName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($transferQuotData['destinationId']);  ?>&nbsp;)</td>
                <td align="left" ><strong>Transfer</strong></td>
                <td align="left" >
				
				<?php
				$nameDBtransfer=$transferData['transferName'].' ( '.$hcity = getDestination($transferQuotData['destinationId']).' )';
				$chTransferq=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBtransfer.'"'); 
				$chTransfer=mysqli_num_rows($chTransferq);   
				if($chTransfer==0){ 
				?>  
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=2&transferid=<?php echo encode($transferQuotData['transferNameId']); ?>&transferQuotationId=<?php echo encode($finalQuotTransfer['transferQuotationId']); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				 
				 <?php } ?>
				
				</td>
              </tr>
              <?php
  } 
  ?>
              <?php 
  $b="";
  $b=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationId.'" and supplierId!=0 order by fromDate asc'); 
  while($finalQuoteEntranceData=mysqli_fetch_array($b)){ 
    $b2=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,'id="'.$finalQuoteEntranceData['entranceQuotationId'].'"  order by fromDate asc'); 
    $entranceQuotData=mysqli_fetch_array($b2);
    $d=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$entranceQuotData['entranceNameId'].'"');   
   $entranceData=mysqli_fetch_array($d); 
       if($finalQuoteEntranceData['supplierId']!='' && $finalQuoteEntranceData['supplierId']!=0){
        $supplierId = $finalQuoteEntranceData['supplierId'];
      } 
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);
    
                            ?>
              <tr id="selectedcon<?php echo $finalQuoteEntranceData['id']; ?>">
                <td align="left"><?php echo strip($entranceData['entranceName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($entranceData['entranceCity']);  ?>&nbsp;)</td>
                <td align="left"><strong>Entrance/Sightseeing</strong></td>
                <td align="left"> 
				
				<?php
				$nameDBentrance=$entranceData['entranceName'].' ( '.$hcity = $entranceData['entranceCity'].' )';
				$chEntranceq=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBentrance.'"'); 
				$chEntrance=mysqli_num_rows($chEntranceq);   
				if($chEntrance==0){ 
				?>  
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=3&entranceNameId=<?php echo encode($entranceQuotData['entranceNameId']); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				<?php } ?>
				
				
				</td>
              </tr>
              <?php }
             ?>
              <?php 
    $b="";
  $b=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationId.'"  and supplierId!=0 order by fromDate asc'); 
  while($finalQuoteActivityData=mysqli_fetch_array($b)){ 
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
                <td align="left"><?php echo strip($activityData['otherActivityName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($activityData['otherActivityCity']);  ?>&nbsp;)</td>
                <td align="left"><strong>Other Activity</strong></td>
                <td align="left" >
				
				<?php
				$nameDBotheractivity=$activityData['otherActivityName'].' ( '.$hcity = $activityData['otherActivityCity'].' )';
				$chOtherActivityq=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBotheractivity.'"'); 
				$chOtherActivity=mysqli_num_rows($chOtherActivityq);   
				if($chOtherActivity==0){ 
				?>  
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=4&activityId=<?php echo encode($finalQuoteActivityData['activityId']); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				<?php } ?>
				
				</td>
              </tr>
              <?php } ?>
              <?php
  $b="";
  $b=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationId.'"  and supplierId!=0 order by fromDate asc');         
  while($finalQuoteTrainData=mysqli_fetch_array($b)){ 

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
                <td align="left" ><?php echo strip($trainData['trainName']);  ?>&nbsp;(&nbsp;<?php echo getDestination($trainQuotData['destinationId']);  ?>&nbsp;) </td>
                <td align="left" ><strong>Train</strong></td>
                <td align="left" >
				<?php
				$nameDBtrain=$trainData['trainName'].' ( '.getDestination($trainQuotData['destinationId']).' )';
				$chTrainq=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBtrain.'"'); 
				$chTrain=mysqli_num_rows($chTrainq);   
				if($chTrain==0){ 
				?>  
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=5&trainId=<?php echo encode($trainQuotData['trainId']); ?>&trainQuotationId=<?php echo encode($finalQuoteTrainData['trainQuotationId']); ?>&quotationId=<?php echo encode($quotationId); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				<?php } ?>
				</td>
              </tr>
              <?php } ?>
              <?php
  ///flightss
$b="";
$b=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationId.'" and  supplierId!=0 order by fromDate asc');
while($finalQuoteFlightData=mysqli_fetch_array($b)){
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
                <td align="left" ><?php echo strip($flightData['flightName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
                <td align="left" ><strong>Flight</strong></td>
                <td align="left" >
				
				<?php
				$nameDBflight=$flightData['flightName'].' ( '.$Ecity.' )';
				$chFlightq=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBflight.'"'); 
				$chFlight=mysqli_num_rows($chFlightq);   
				if($chFlight==0){ 
				?>  
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=6&flightId=<?php echo encode($flightQuotData['flightId']); ?>&destinationId=<?php echo encode($flightQuotData['destinationId']); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				<?php } ?>
				
				</td>
              </tr>
              <?php } ?>
              <?php 
$b="";
$b=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationId.'" and supplierId!=0  order by fromDate asc'); 
while($finalQuoteGuideData=mysqli_fetch_array($b)){ 
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
                <td align="left" ><?php echo strip($guideData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
                <td align="left" ><strong>Guide</strong></td>
                <td align="left" >
				
					<?php
				$nameDBguide=$guideData['name'].' ( '.$Ecity.' )';
				$chGuideQ=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBguide.'"'); 
				$chGuide=mysqli_num_rows($chGuideQ);   
				if($chGuide==0){ 
				?>  
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=7&guideId=<?php echo encode($guideQuotData['guideId']); ?>&destinationId=<?php echo encode($guideQuotData['destinationId']); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				<?php } ?>
				
				</td>
              </tr>
              <?php } ?>
              <?php 
  $b="";
  $b=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationId.'" and supplierId!=0 order by fromDate asc'); 
  while($finalQuoteMealData=mysqli_fetch_array($b)){ 
  
  
  $b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,'id="'.$finalQuoteMealData['mealplanQuotationId'].'" and quotationId="'.$quotationId.'" order by fromDate asc');    
  $mealQuotData=mysqli_fetch_array($b);

       if($finalQuoteMealData['supplierId']!='' && $finalQuoteMealData['supplierId']!=0){
        $supplierId = $finalQuoteMealData['supplierId'];
      }
      
      $bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierId.'"'); 
      $supplierData=mysqli_fetch_array($bb);  
  ?>
              <tr id="selectedcon<?php echo $finalQuoteMealData['id']; ?>">
                <td align="left" ><?php echo strip($mealQuotData['mealPlanName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($mealQuotData['destinationId']);  ?>&nbsp;)</td>
                <td align="left" ><strong>Meal Plan</strong></td>
                <td align="left" >
				
				<?php
				$nameDBmealplan=$mealQuotData['mealPlanName'].' ( '.$hcity = getDestination($mealQuotData['destinationId']).' )';
				$chmealplanQ=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBmealplan.'"'); 
				$chmealplan=mysqli_num_rows($chmealplanQ);   
				if($chmealplan==0){ 
				?>  
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=8&mealplanQuotationId=<?php echo encode($finalQuoteMealData['mealplanQuotationId']); ?>&quotationId=<?php echo encode($quotationId); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				<?php } ?>
				</td>
              </tr>
              <?php } ?>
              <?php 
$b="";
$b=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationId.'" and supplierId!=0 order by fromDate asc'); 
while($finalQuoteAdditionalData=mysqli_fetch_array($b)){
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
                <td align="left" ><?php echo strip($additionalData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
                <td align="left" ><strong>Extra Activity</strong></td>
                <td align="left" >
				
				<?php 
				$nameDBextraactivity=$additionalData['name'].' ( '.$Ecity.' )';
				$chExtraActivityQ=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBextraactivity.'"'); 
				$chExtraActivity=mysqli_num_rows($chExtraActivityQ);   
				if($chExtraActivity==0){ 
				?>   
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=9&additionalId=<?php echo encode($additionalQuotData['additionalId']); ?>&destinationId=<?php echo encode($additionalQuotData['destinationId']); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				<?php } ?>
				
				</td>
              </tr>
              <?php } ?>
              <?php 
  $b="";
  $b=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$quotationId.'" and supplierId!=0  order by fromDate asc'); 
  while($finalQuoteEnrouteData=mysqli_fetch_array($b)){ 
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
                <td align="left" ><?php echo strip($enrouteData['enrouteName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)</td>
                <td align="left" ><strong>Enroute</strong></td>
                <td align="left" >
				
				<?php  
				$nameDBEnroute=$enrouteData['enrouteName'].' ( '.$Ecity.' )';
				$chEnrouteq=GetPageRecord('id','todoListMaster','1 and queryId="'.$queryId.'" and taskTitle="'.$nameDBEnroute.'"'); 
				$chEnroute=mysqli_num_rows($chEnrouteq);   
				if($chEnroute==0){ 
				?> 
				<div align="center"><a style="background-color: #ff9800; color: #fff !important; font-size: 10px; padding: 5px 10px; text-align: left; border-radius: 2px;" title="Action" onclick="alertspopupopen('action=addtodoforquotation&queryId=<?php echo encode($queryId); ?>&type=10&enrouteId=<?php echo encode($enrouteQuotData['enrouteId']); ?>&destinationId=<?php echo encode($enrouteQuotData['destinationId']); ?>','700px','auto');"><strong>+ To Do</strong></a></div>
				<?php } ?> 
				
				</td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div></td>
    </tr>
  </tbody>
</table>
