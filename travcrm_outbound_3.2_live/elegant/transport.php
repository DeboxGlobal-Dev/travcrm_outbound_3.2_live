<?php 
$page='transport';
include "header.php"; 
?>


<style>
    @media only screen and (max-width: 600px) {
        .t-head{
            width: 100%;
        }
        .t-body1{
            /* width: 71%; */
        }
        .t-body2{
            /* width: 54%; */
        }
        .custom_caption{
            font-size: 11px;
            line-height: 12px;
        }
    }
        
</style>
<div class="page-content">
    <div class="content-block transport-content custom_border_colour primary">
        <table class="custom_border_colour primary table">
        <tbody>
    <?php
    if($quotationStatus == 1){
        $b1='';
        $b1=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationId.'" and serviceType in ( "train","flight","transfer","transportation" ) group by serviceType order by serviceType ASC'); 
        while($finalQuoteSortingD=mysqli_fetch_array($b1)){ 

            if($finalQuoteSortingD['serviceType']=='transfer' || $finalQuoteSortingD['serviceType']=='transportation'){
                echo '<tr class="heading"><th colspan="9"><div class="custom_title-bar custom_border_colour primary full"><h2>Transfers</h2></div></th></tr>';
                $b='';
                $b=GetPageRecord('*','finalQuotetransfer','quotationId="'.$quotationId.'" order by fromDate asc');
                if(mysqli_num_rows($b)){
                    ?>
                    <tr class="t-head">
                        <th class="t-body1"><span class="custom_caption">Date</span></th>
                        <th class="t-body2">
                            <span class="custom_caption">Transfer Name</span>
                        </th>
                        <th class="t-body3"><span class="custom_caption">Pick Up</span>  </th>
                        <!-- <th class="t-body4"></th> -->
                        <th class="t-body5"><span class="custom_caption">Drop Off</span></th>
                        <!-- <th class="t-body6"></th> -->
                    </tr>
                    <?php
                    while($fQTransferData=mysqli_fetch_array($b)){
                    echo $transferId = $fQTransferData['transferId'];
                    echo $dayDate = $fQTransferData['fromDate'];

                    $d='';
                    $d=GetPageRecord('*','quotationTransferTimelineDetails','  transferQuoteId="'.$fQTransferData['transferQuotationId'].'"');   
                    $qTransferTimeD=mysqli_fetch_array($d); 

                    $d='';
                    $d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'  id="'.$transferId.'"');   
                    $transferData=mysqli_fetch_array($d);
                    $transferName = $transferData['transferName'];
                    ?> 
                    
                    <tr>
                        <td><p><?php echo date('j M Y',strtotime($dayDate));  ?></p> </td>
                        <td><p><?php echo $transferName; ?></p></td>
                        <td><p><?php echo $qTransferTimeD['arrivalFrom']; ?></p></td>
                        <!-- <td><p></p></td> -->
                        <td><p><?php echo $qTransferTimeD['dropAddress']; ?></p></td>
                        <!-- <td><p></p></td> -->
                    </tr>
                    <?php  
                }
                }
            } 
            if($finalQuoteSortingD['serviceType']=='train'){
                echo '<tr class="heading"><th colspan="9"><div class="custom_title-bar custom_border_colour primary full"><h2>Trains</h2></div></th></tr>';
                $b='';
                $b=GetPageRecord('*','finalQuotetrains','quotationId="'.$quotationId.'" order by fromDate asc');
                if(mysqli_num_rows($b)){
                    ?>
                    <tr>
                        <th><span class="custom_caption">Date</span></th>
                        <th>
                            <span class="custom_caption">Train Name</span>
                        </th>
                        <th><span class="custom_caption">Pick Up</span>  </th>
                        <!-- <th></th> -->
                        <th><span class="custom_caption">Drop Off</span></th>
                        <!-- <th></th> -->
                    </tr>
                    <?php
                    while($fQTrainData=mysqli_fetch_array($b)){
                    $trainId = $fQTrainData['trainId'];
                    $dayDate = $fQTrainData['fromDate'];

                    $jfrom = getDestination($fQTrainData['departureFrom']);
                    $jto= getDestination($fQTrainData['arrivalTo']); 

                    $d='';
                    $d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'  id="'.$trainId.'"');   
                    $trainData=mysqli_fetch_array($d);
                    $trainName = $trainData['trainName'];
                    ?>
                    
                    <tr>
                        <td><p><?php echo date('j M Y',strtotime($dayDate));  ?></p> </td>
                        <td><p><?php echo $trainName; ?></p></td>
                        <td><p><?php echo $jfrom; ?></p></td>
                        <!-- <td><p></p></td> -->
                        <td><p><?php echo $jto; ?></p></td>
                        <!-- <td><p></p></td> -->
                    </tr>
                    <?php  
                }
                }
            } 
            if($finalQuoteSortingD['serviceType']=='flight'){
                echo '<tr class="heading"><th colspan="9"><div class="custom_title-bar custom_border_colour primary full"><h2>Flights</h2></div></th></tr>';
                $b='';
                $b=GetPageRecord('*','finalQuoteflights','quotationId="'.$quotationId.'" order by fromDate asc');
                if(mysqli_num_rows($b)){
                    ?>
                    <tr>
                        <th><span class="custom_caption">Date</span></th>
                        <th>
                            <span class="custom_caption">Flight Name</span>
                        </th>
                        <th><span class="custom_caption">Pick Up</span></th>
                        <!-- <th></th> -->
                        <th><span class="custom_caption">Drop Off</span></th>
                        <!-- <th></th> -->
                    </tr>
                    <?php
                    
                    while($fQFlightData=mysqli_fetch_array($b)){
                    $flightId = $fQFlightData['flightId'];
                    $dayDate = $fQFlightData['fromDate'];

                    $jfrom = getDestination($fQFlightData['departureFrom']);
                    $jto= getDestination($fQFlightData['arrivalTo']); 

                    $d='';
                    $d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'  id="'.$flightId.'"');   
                    $flightData=mysqli_fetch_array($d);
                    $flightName = $flightData['flightName'];



                    ?>
                    
                    <tr>
                        <td><p><?php echo date('j M Y',strtotime($dayDate));  ?></p> </td>
                        <td><p><?php echo $flightName; ?></p></td>
                        <td><p><?php echo $jfrom; ?></p></td>
                        <!-- <td><p></p></td> -->
                        <td><p><?php echo $jto; ?></p></td>
                        <!-- <td><p></p></td> -->
                    </tr>
                    <?php  
                }
                }
            } 
        } 
    }

    if($quotationStatus != 1){
        $b1='';
        $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and serviceType in ( "train","flight","transfer","transportation","ferry" ) group by serviceType order by serviceType ASC'); 
        while($QuoteSortingD=mysqli_fetch_array($b1)){ 

            if($QuoteSortingD['serviceType']=='transfer' || $QuoteSortingD['serviceType']=='transportation'){
                echo '<tr class="heading"><th colspan="9"><div class="custom_title-bar custom_border_colour primary full"><h2>Transfers</h2></div></th></tr>';
                $b='';
                $b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" order by fromDate asc');
                if(mysqli_num_rows($b)){
                    ?>
                    <tr>
                        <th><span class="custom_caption">Date</span></th>
                        <th>
                            <span class="custom_caption">Transfer Name</span>
                        </th>
                        <th><span class="custom_caption">Pick Up</span>  </th>
                        <!-- <th></th> -->
                        <th><span class="custom_caption">Drop Off</span></th>
                        <!-- <th></th> -->
                    </tr>
                    <?php
                    while($QTransferData=mysqli_fetch_array($b)){
                    $transferId = $QTransferData['transferNameId'];
                    $dayDate = $QTransferData['fromDate'];

                    $d='';
                    $d=GetPageRecord('*','quotationTransferTimelineDetails','  transferQuoteId="'.$QTransferData['id'].'"');   
                    $qTransferTimeD=mysqli_fetch_array($d); 

                    $d='';
                    $d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'  id="'.$transferId.'"');   
                    $transferData=mysqli_fetch_array($d);
                    echo $transferName = $transferData['transferName'];
                    ?> 
                    
                    <tr>
                        <td><p><?php echo date('j M Y',strtotime($dayDate));  ?></p> </td>
                        <td><p><?php echo $transferName; ?></p></td>
                        <td><p><?php echo $qTransferTimeD['arrivalFrom']; ?></p></td>
                        <!-- <td><p></p></td> -->
                        <td><p><?php echo $qTransferTimeD['dropAddress']; ?></p></td>
                        <!-- <td><p></p></td> -->
                    </tr>
                    <?php  
                }
                }
            } 
            if($QuoteSortingD['serviceType']=='train'){
                echo '<tr class="heading"><th colspan="9"><div class="custom_title-bar custom_border_colour primary full"><h2>Trains</h2></div></th></tr>';
                $b='';
                $b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'quotationId="'.$quotationId.'" order by fromDate asc');
                if(mysqli_num_rows($b)){
                    ?>
                    <tr>
                        <th><span class="custom_caption">Date</span></th>
                        <th>
                            <span class="custom_caption">Train Name</span>
                        </th>
                        <th><span class="custom_caption">Pick Up</span>  </th>
                        <!-- <th></th> -->
                        <th><span class="custom_caption">Drop Off</span></th>
                        <!-- <th></th> -->
                    </tr>
                    <?php
                    while($QTrainData=mysqli_fetch_array($b)){
                    $trainId = $QTrainData['trainId'];
                    $dayDate = $QTrainData['fromDate'];

                    $jfrom = getDestination($QTrainData['departureFrom']);
                    $jto= getDestination($QTrainData['arrivalTo']); 

                    $d='';
                    $d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'  id="'.$trainId.'"');   
                    $trainData=mysqli_fetch_array($d);
                    $trainName = $trainData['trainName'];
                    ?>
                    
                    <tr>
                        <td><p><?php echo date('j M Y',strtotime($dayDate));  ?></p> </td>
                        <td><p><?php echo $trainName; ?></p></td>
                        <td><p><?php echo $jfrom; ?></p></td>
                        <!-- <td><p></p></td> -->
                        <td><p><?php echo $jto; ?></p></td>
                        <!-- <td><p></p></td> -->
                    </tr>
                    <?php  
                }
                }
            } 
            if($QuoteSortingD['serviceType']=='flight'){
                echo '<tr class="heading"><th colspan="9"><div class="custom_title-bar custom_border_colour primary full"><h2>Flights</h2></div></th></tr>';
                $b='';
                $b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'quotationId="'.$quotationId.'" order by fromDate asc');
                if(mysqli_num_rows($b)){
                    ?>
                    <tr>
                        <th><span class="custom_caption">Date</span></th>
                        <th>
                            <span class="custom_caption">Flight Name</span>
                        </th>
                        <th><span class="custom_caption">Pick Up</span></th>
                        <!-- <th></th> -->
                        <th><span class="custom_caption">Drop Off</span></th>
                        <!-- <th></th> -->
                    </tr>
                    <?php
                    
                    while($QFlightData=mysqli_fetch_array($b)){
                    $flightId = $QFlightData['flightId'];
                    $dayDate = $QFlightData['fromDate'];

                    $jfrom = getDestination($QFlightData['departureFrom']);
                    $jto= getDestination($QFlightData['arrivalTo']); 

                    $d='';
                    $d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'  id="'.$flightId.'"');   
                    $flightData=mysqli_fetch_array($d);
                    $flightName = $flightData['flightName'];
                    ?>
                    
                    <tr>
                        <td><p><?php echo date('j M Y',strtotime($dayDate));  ?></p> </td>
                        <td><p><?php echo $flightName; ?></p></td>
                        <td><p><?php echo $jfrom; ?></p></td>
                        <!-- <td><p></p></td> -->
                        <td><p><?php echo $jto; ?></p></td>
                        <!-- <td><p></p></td> -->
                    </tr>
                    <?php  
                }
                }
            } 

            if($QuoteSortingD['serviceType']=='ferry'){
                echo '<tr class="heading"><th colspan="9"><div class="custom_title-bar custom_border_colour primary full"><h2>Ferry</h2></div></th></tr>';
                $b='';
                $b=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,'quotationId="'.$quotationId.'" order by fromDate asc');
                if(mysqli_num_rows($b)){
                    ?>
                    <tr>
                        <th><span class="custom_caption">Date</span></th>
                        <th>
                            <span class="custom_caption">Train Name</span>
                        </th>
                        <th><span class="custom_caption">Arrival Time</span>  </th>
                        <!-- <th></th> -->
                        <th><span class="custom_caption">Departure Time</span></th>
                        <!-- <th></th> -->
                    </tr>
                    <?php
                    while($QFerryData=mysqli_fetch_array($b)){
                    $ferryserid = $QFerryData['serviceid'];
                    $pickupTime = $QFerryData['pickupTime'];
                    $dropTime = $QFerryData['dropTime'];
                    $dayDate = $QFerryData['fromDate'];

                    $d='';
                    $d=GetPageRecord('*','ferryPriceMaster','  id="'.$ferryserid.'"');   
                    $ferryTransname=mysqli_fetch_array($d);
                    $ferrytrans = $ferryTransname['name'];
                    ?>
                    
                    <tr>
                        <td><p><?php echo date('j M Y',strtotime($dayDate));  ?></p> </td>
                        <td><p><?php echo $ferrytrans; ?></p></td>
                        <td><p><?php echo $pickupTime; ?></p></td>
                        <!-- <td><p></p></td> -->
                        <td><p><?php echo $dropTime; ?></p></td>
                        <!-- <td><p></p></td> -->
                    </tr>
                    <?php  
                }
                }
            } 






        }
    }
    ?>
        </tbody>
        </table>
    </div>
</div> 
<?php 
include "footer.php"; 
?>