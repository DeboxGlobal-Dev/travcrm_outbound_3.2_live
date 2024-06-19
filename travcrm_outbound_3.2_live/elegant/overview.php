<?php 
$page='overview';
include "header.php"; 
?>
<style>
.tab-head-des{
    margin-top: 10px;
}
.table-head-des{
    margin-top: 10px;
}
@media only screen and (max-width: 600px) {
    /* .{
        text-align: justify;
    } */
    .side-mob{
        padding-left: 0!important;
        width: 100%!important;
    }
    .block-container .side-blocks {
        padding-left: 0px;
    }
    .scroll-mob{
        /* overflow: scroll; */
    }
    .over-head-mob{
        font-size: 11px!important;
    }
    .over-mob{
        font-size: 13px!important;
    }

}


</style>
<div class="page-content">
    <div class="block-container">
        <div class="body">
            <div class=" table-head-des content-block custom_border_colour primary  scroll-mob tab-head-des">
                <table border="0" class="overview-table table-responsive">
                    <thead class="custom_border_colour primary">
                        <tr class="heading custom_title-bar table " >
                            <th class="arrive-desktop"><div class="custom_title-bar custom_border_colour primary"><h2 class="over-head-mob">Date</h2></div></th>
                            <!-- <th class="day-tablet"><div class="custom_title-bar custom_border_colour primary"><h2>Day</h2></div></th> -->
                            <th><div class="custom_title-bar custom_border_colour primary"><h2 class="over-head-mob">Accommodation</h2></div></th>
                            <th><div class="custom_title-bar custom_border_colour primary"><h2 class="over-head-mob">Destination</h2></div></th>
                            <th><div class="custom_title-bar custom_border_colour primary"><h2 class="over-head-mob">Duration</h2></div></th>
                            <th class="basis-desktop"><div class="custom_title-bar custom_border_colour primary"><h2 class="over-head-mob">Basis</h2></div></th>
                            <th class="basis-desktop"><div class="custom_title-bar custom_border_colour primary"><h2 class="over-head-mob">Additionals</h2></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if($quotationStatus == 1){
                        // echo "samaydin";
                        $dayNo = 1;
                        $b1=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationId.'" and serviceType="hotel" order by startDate ASC'); 
                        while($finalQuoteSortingD=mysqli_fetch_array($b1)){ 
                            $where2='quotationId="'.$quotationId.'" and id="'.$finalQuoteSortingD['serviceId'].'"';
                            $b=GetPageRecord('*','finalQuote',$where2);
                            if(mysqli_num_rows($b)){
                                while($finalQuotData=mysqli_fetch_array($b)){ 
                                     $hotelTypeLable='';
                                    if($finalQuotData['isLocalEscort']==1){
                                        $hotelTypeLable .= "Local Escort,";
                                    }
                                    if($finalQuotData['isForeignEscort']==1){
                                        $hotelTypeLable .= "Foreign Escort,";
                                    }
                                    if($finalQuotData['isGuestType']==1){
                                        $hotelTypeLable .= "Guest,";
                                    }
                                
                                    $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'  id="'.$finalQuotData['hotelId'].'"');   
                                    $hotelData=mysqli_fetch_array($d);
                                    $days_between='1';
                              
                                ?>
                                <tr class="odd ">
                                    <td class="arrive-desktop ">
                                        <p class="over-head-mob over-mob"><?php echo date('j M Y',strtotime($finalQuoteSortingD['startDate']));  ?></p>
                                    </td>
                                    <!-- <td class="day-tablet"> -->
                                        <!-- <p><?php echo $dayNo;  ?></p> -->
                                    <!--</td> -->
                                    <td>
                                        <p class="over-head-mob"><?php echo trim($hotelData['hotelName']); ?></p>
                                    </td>
                                    <td>
                                        <p class="over-head-mob"><?php echo getDestination($finalQuotData['destinationId']); ?></p>
                                    </td>
                                    <td>
                                        <p class="over-head-mob"><?php echo $days_between;?> night</p>
                                    </td>
                                    
                                    <td class="basis-desktop">
                                        <p><?php 
                                            $select2='name';  
                                            $where2='id='.$finalQuotData['mealPlanId'].''; 
                                            $rs2=GetPageRecord($select2,_MEAL_PLAN_MASTER_,$where2); 
                                            $editresult2=mysqli_fetch_array($rs2); 
                                            // echo $finalQuotData['roomType'];
                                            echo getRoomType($finalQuotData['roomType'])."/".clean($editresult2['name']);  
                                        ?></p>
                                    </td>
                                    <td>
                                        <p class="over-head-mob"><?php
                                            $halists='';
                                            $rs12=GetPageRecord('*','finalQuoteHotelAdditional','finalQuotId="'.$finalQuotData['id'].'" and quotationId="'.$finalQuotData['quotationId'].'" '); 
                                            if(mysqli_num_rows($rs12)>0){
                                                while ($editresult2=mysqli_fetch_array($rs12)) {
                                                    $halists  .= $editresult2['name'].', ';
                                                }
                                                echo rtrim($halists,', ');
                                            }
                                            ?>   
                                        </p>
                                    </td>
                                </tr>
                                <?php 
                            }
                            }
                            $dayNo++;
                        }
                    }
                    ?>
                    <?php 
                    if($quotationStatus != 1){
                        // echo "samaydin";
                        $dayNo = 1;
                        $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and serviceType="hotel" order by startDate ASC'); 
                        while($QuoteSortingD=mysqli_fetch_array($b1)){ 
                            $where2='quotationId="'.$quotationId.'" and id="'.$QuoteSortingD['serviceId'].'"';
                            $b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,$where2);
                            if(mysqli_num_rows($b)){
                                while($QuotData=mysqli_fetch_array($b)){ 
                                     $hotelTypeLable='';
                                    if($QuotData['isLocalEscort']==1){
                                        $hotelTypeLable .= "Local Escort,";
                                    }
                                    if($QuotData['isForeignEscort']==1){
                                        $hotelTypeLable .= "Foreign Escort,";
                                    }
                                    if($QuotData['isGuestType']==1){
                                        $hotelTypeLable .= "Guest,";
                                    }
                                
                                    $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'  id="'.$QuotData['supplierId'].'"');   
                                    $hotelData=mysqli_fetch_array($d);
                                    $days_between='1';
                              
                                ?>
                                <tr class="odd ">
                                    <td class="arrive-desktop">
                                        <p><?php echo date('j M Y',strtotime($QuoteSortingD['startDate']));  ?></p>
                                    </td>
                                    <!-- <td class="day-tablet">
                                        <p><?php echo $dayNo;  ?></p>
                                    </td> -->
                                    <td>
                                        <p><?php echo trim($hotelData['hotelName']); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo getDestination($QuotData['destinationId']); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $days_between;?> night</p>
                                    </td>
                                    

                                    <td class="basis-desktop">
                                        <p><?php 
                                            $select2='name';  
                                            $where2='id='.$QuotData['mealPlan'].''; 
                                            $rs2=GetPageRecord($select2,_MEAL_PLAN_MASTER_,$where2); 
                                            $editresult2=mysqli_fetch_array($rs2); 
                                            echo getRoomType($QuotData['roomType'])."/".clean($editresult2['name']);  
                                        ?></p>
                                    </td>
                                    <td>
                                        <p class="over-head-mob"><?php
                                            $halists='';
                                            $rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$QuotData['id'].'" and quotationId="'.$QuotData['quotationId'].'" '); 
                                            if(mysqli_num_rows($rs12)>0){
                                                while ($editresult2=mysqli_fetch_array($rs12)) {
                                                    $halists  .= $editresult2['name'].', ';
                                                }
                                                echo rtrim($halists,', ');
                                            }
                                            ?>   
                                        </p>
                                    </td>
                                </tr>
                                <?php 
                            }
                            }
                            $dayNo++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="content-block custom_border_colour primary scroll-mob ">
                <table border="0" class="overview-table key table-head-des">
                    <thead class="custom_border_colour primary">
                        <tr class="heading custom_title-bar table">
                            <th colspan="2"><div class="custom_title-bar custom_border_colour primary"><h2>Key</h2></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            <?php
                            if($quotationStatus == 1){
                                $b='';
                                $b=GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" group by mealPlanId order by fromDate asc');
                                if(mysqli_num_rows($b)){
                                    while($finalQuotData=mysqli_fetch_array($b)){

                                    $select2='name,subname';  
                                    $where2='id="'.$finalQuotData['mealPlanId'].'"'; 
                                    $rs2=GetPageRecord($select2,_MEAL_PLAN_MASTER_,$where2); 
                                    $editresult2=mysqli_fetch_array($rs2); 
                                     
                                     ?>
                                     <p><span><?php  echo clean($editresult2['name']); ?>:</span> <?php  echo clean($editresult2['subname']); ?></p>
                                    <?php 
                                    }
                                }
                            } 
                            if($quotationStatus != 1){
                                $b='';
                                $b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" group by mealPlan order by fromDate asc');
                                if(mysqli_num_rows($b)){
                                    while($finalQuotData=mysqli_fetch_array($b)){

                                    $select2='name,subname';  
                                    $where2='id="'.$finalQuotData['mealPlan'].'"'; 
                                    $rs2=GetPageRecord($select2,_MEAL_PLAN_MASTER_,$where2); 
                                    $editresult2=mysqli_fetch_array($rs2); 
                                     
                                     ?>
                                     <p><span><?php  echo clean($editresult2['name']); ?>:</span> <?php  echo clean($editresult2['subname']); ?></p>
                                    <?php 
                                    }
                                }
                            }
                            ?>
                                
                            </td>
                            <td>
                                <p>&nbsp;</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="image-sections">
            <?php 
            $dayNo2 = 1;
            // _DOCUMENT_FILES_MASTER_
            $dayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" and addstatus=0 and deletestatus=0 order by srdate asc');
            while($daysData=mysqli_fetch_array($dayQuery)){
                $dayDate = $daysData['srdate'];
                $cityId = $daysData['cityId'];
                $dayId = $daysData['id'];
                $destName = getDestination($cityId);
                $docQuery = '';
                $docQuery=GetPageRecord('uploadfile','documentFiles',' fileDimension="992x248" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$cityId.'" and galleryType="destination" and deletestatus=0 ) order by id desc limit 1 ');
                while($destImageD=mysqli_fetch_array($docQuery)){
                    $cityImageTag = '<img title="City"  class="destination-image" src="'.$fullurl.$destImageD['uploadfile'].'" />';
                }
                ?>
                <div class="content-block custom_border_colour primary table-head-des ">
                    <div class="custom_title-bar custom_border_colour primary"><h2><span><?php echo $destName;?></span></h2></div>
                    <div class="content-body images custom_border_colour primary">
                    <?php
                    if($quotationStatus == 1){
                        echo $cityImageTag; //destination Image
                        echo '<div class="activity-image-block">';
                        $b1='';
                        $b1=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationId.'" and  startDate="'.$dayDate.'" and serviceType in ( "hotel","entrance","activity","enroute" ) order by srn ASC'); 
                        while($finalQuoteSortingD=mysqli_fetch_array($b1)){ 
                            if($finalQuoteSortingD['serviceType']=='hotel'){ 
                                $b='';
                                $b=GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and id="'.$finalQuoteSortingD['serviceId'].'"');
                                if(mysqli_num_rows($b)){
                                    $finalQuotData=mysqli_fetch_array($b);
                                    $hotelId = $finalQuotData['hotelId'];

                                    $docQuery2 = '';
                                    $docQuery2=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$hotelId.'" and galleryType="hotel" and deletestatus=0 ) limit 3 ');
                                    while($hotelImageD=mysqli_fetch_array($docQuery2)){
                                        echo $cityImageTag = '<img title="hotel" src="'.$fullurl.$hotelImageD['uploadfile'].'" />';
                                    }
                                }
                            }
                            if($finalQuoteSortingD['serviceType']=='entrance'){
                                $b='';
                                $b=GetPageRecord('*','finalQuoteEntrance','quotationId="'.$quotationId.'" and id="'.$finalQuoteSortingD['serviceId'].'"');
                                if(mysqli_num_rows($b)){
                                    $finalQuotEntData=mysqli_fetch_array($b);
                                    $entranceId = $finalQuotEntData['entranceId'];
                                    $docQuery3 = '';
                                    $docQuery3=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$entranceId.'" and galleryType="entrance" and deletestatus=0 ) limit 3 ');
                                    // echo '<div class="activity-image-block">';
                                    while($entranceImageD=mysqli_fetch_array($docQuery3)){
                                        echo $cityImageTag = '<img title="entrance" src="'.$fullurl.$entranceImageD['uploadfile'].'" />';
                                    }
                                    // echo '</div>';
                                }
                            }
                            if($finalQuoteSortingD['serviceType']=='activity'){
                                $b='';
                                $b=GetPageRecord('*','finalQuoteActivity','quotationId="'.$quotationId.'" and id="'.$finalQuoteSortingD['serviceId'].'"');
                                if(mysqli_num_rows($b)){
                                    $finalQuotActData=mysqli_fetch_array($b);
                                    $activityId = $finalQuotActData['activityId'];
                                    $docQuery4 = '';
                                    $docQuery4=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$activityId.'" and galleryType="activity" and deletestatus=0 ) limit 3 ');
                                    // echo '<div class="activity-image-block">';
                                    while($activityImageD=mysqli_fetch_array($docQuery4)){
                                        echo $cityImageTag = '<img title="activity" src="'.$fullurl.$activityImageD['uploadfile'].'" />';
                                    }
                                }
                            }
                        }
                            echo '</div>';
                        $dayNo2++;
                    }     
                    ?>
                    <?php
                    if($quotationStatus != 1){ 
                        echo $cityImageTag; //destination Image
                        echo '<div class="activity-image-block">';
                        $b1='';
                        $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and  startDate="'.$dayDate.'" and serviceType in ( "hotel","entrance","activity","enroute" ) order by srn ASC'); 
                        while($QuoteSortingD=mysqli_fetch_array($b1)){ 
                            // echo $QuoteSortingD['serviceType'];
                            if($QuoteSortingD['serviceType']=='hotel'){ 

                                $b='';
                                $b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and id="'.$QuoteSortingD['serviceId'].'"');
                                if(mysqli_num_rows($b)){
                                    $finalQuotData=mysqli_fetch_array($b);
                                    $hotelId = $finalQuotData['supplierId'];

                                    $docQuery2 = '';
                                    $docQuery2=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$hotelId.'" and galleryType="hotel" and deletestatus=0 ) limit 3 ');
                                    while($hotelImageD=mysqli_fetch_array($docQuery2)){
                                        echo $cityImageTag = '<img title="hotel" src="'.$fullurl.$hotelImageD['uploadfile'].'" />';
                                    }
                                    // echo '</div>';
                                }
                            }
                            if($QuoteSortingD['serviceType']=='entrance'){
                                $b='';
                                $b=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,'quotationId="'.$quotationId.'" and id="'.$QuoteSortingD['serviceId'].'"');
                                if(mysqli_num_rows($b)){
                                    $finalQuotEntData=mysqli_fetch_array($b);
                                    $entranceId = $finalQuotEntData['entranceNameId'];
                                    $docQuery3 = '';
                                    $docQuery3=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$entranceId.'" and galleryType="entrance" and deletestatus=0 ) limit 3 ');
                                    // echo '<div class="activity-image-block">';
                                    while($entranceImageD=mysqli_fetch_array($docQuery3)){
                                        echo $cityImageTag = '<img title="entrance" src="'.$fullurl.$entranceImageD['uploadfile'].'" />';
                                    }
                                    // echo '</div>';
                                }
                            }
                            if($QuoteSortingD['serviceType']=='activity'){
                                $b='';
                                $b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,'quotationId="'.$quotationId.'" and id="'.$QuoteSortingD['serviceId'].'"');
                                if(mysqli_num_rows($b)){
                                    $finalQuotActData=mysqli_fetch_array($b);
                                    $activityId = $finalQuotActData['otherActivityName'];
                                    $docQuery4 = '';
                                    $docQuery4=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$activityId.'" and galleryType="activity" and deletestatus=0 ) limit 3 ');
                                    // echo '<div class="activity-image-block">';
                                    while($activityImageD=mysqli_fetch_array($docQuery4)){
                                        echo $cityImageTag = '<img title="activity" src="'.$fullurl.$activityImageD['uploadfile'].'" />';
                                    }
                                }
                            }
                        }
                            echo '</div>';
                        $dayNo2++;
                    }
                    ?>
                        <div class="clear"></div>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
        </div>
        <div class="side-blocks">
            <div class="side-block custom_border_colour secondary side-mob">
                <div class="custom_title-bar custom_border_colour secondary"><h3>Fast Facts</h3></div>
                
                <p><strong><?php echo $quotationData['night']+1; ?> Days / <?php echo $quotationData['night']; ?> Nights</strong></p>
                <p class="wrap"><strong>Reference Number: </strong><?php echo $querydata['referanceNumber']; ?></p>
                <!-- <p><strong><?php echo $quotationData['adult']+$quotationData['child']; ?> guests</strong></p> -->
            </div>
            <div class="side-block custom_border_colour secondary side-mob">
                <div class="custom_title-bar custom_border_colour secondary">
                    <h3>Travellers( <?php echo $quotationData['adult']+$quotationData['child']; ?> Guests )</h3>
                </div>
                <?php 
                // 
                $b='';
                $b=GetPageRecord('*','guestList','queryId="'.$queryId.'" order by fname asc');
                if(mysqli_num_rows($b)){
                    while($guestListD=mysqli_fetch_array($b)){
                        echo '<p>'.ucfirst($guestListD['fname']).' '.ucfirst($guestListD['lname']).'</p>';
                    }
                } 
                ?>
            </div>
        </div> 
    </div>
</div> 
<?php 
include "footer.php"; 
?>

