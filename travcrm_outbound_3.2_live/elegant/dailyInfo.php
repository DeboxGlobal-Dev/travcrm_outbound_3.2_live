<?php 
$page='dailyInfo';
include "header.php"; 
?>
<style>
    .daily-cont-des{
        background: white;
    }
    @media only screen and (max-width: 600px) {
        .paragraphs p{
            text-align: justify;
        }
        .light-mob{
            /* font-size: 11px; */
            /* font-weight: 600; */
        }
        .light-mob{
            /* font-size: 12px; */
        }
    }
        
</style>
<div class="page-content">
    <?php 
    $dayNo2 = 1; 
    $dayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" and addstatus=0 and deletestatus=0 order by srdate asc');
    $totalDays  = mysqli_num_rows($dayQuery);
    while($daysData=mysqli_fetch_array($dayQuery)){
        $dayDate = $daysData['srdate'];
        $cityId = $daysData['cityId'];
        $dayId = $daysData['id'];
        $destName = getDestination($cityId);
        ?>
        <div class="content-block custom_border_colour primary daily-cont-des ">
            <div class="custom_title-bar custom_border_colour primary">
                <h2>
                <span class="light-mob">Day <?php echo $dayNo2; ?>:</span>
                <!-- <span class="light light-mob"><?php echo $destName; if($dayNo2 == $totalDays){ echo ' | END OF ITINERARY'; } ?></span> -->
                <span class="light light-mob"><?php echo $destName; if($dayNo2 == $totalDays){ echo '  '; } ?></span>
                
                </h2>
                
                <h4 class="date light-mob"><?php echo date('F. j M Y',strtotime($dayDate));  ?></h4>
                
            </div>


            <?php

            if($quotationStatus == 1){
                echo '<div class="activity-image-block">';
                $b1='';
                $b1=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationId.'" and  startDate="'.$dayDate.'" and serviceType in ( "hotel","entrance","activity","enroute","train","flight","transfer","transportation" ) order by srn ASC'); 
                while($finalQuoteSortingD=mysqli_fetch_array($b1)){ 
                    if($finalQuoteSortingD['serviceType']=='hotel'){
                        $b='';
                        $b=GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and id="'.$finalQuoteSortingD['serviceId'].'"');
                        if(mysqli_num_rows($b)){
                            $finalQuotData=mysqli_fetch_array($b);
                            $hotelId = $finalQuotData['hotelId'];

                            $d='';
                            $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'  id="'.$finalQuotData['hotelId'].'"');   
                            $hotelData=mysqli_fetch_array($d);

                            $description = $hotelData['hoteldetail'];
                            $hotelName = $hotelData['hotelName'];

                            $cityImageTag = '';
                            $docQuery2 = '';
                            $docQuery2=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$hotelId.'" and galleryType="hotel" and deletestatus=0 ) limit 3 ');
                            while($hotelImageD=mysqli_fetch_array($docQuery2)){
                                $cityImageTag .= '<img title="hotel" src="'.$fullurl.$hotelImageD['uploadfile'].'" />';
                            } 
                            ?>
                            <div class="block-container">
                                <div class="body">
                                    <div class="content-body">
                                        <h3><strong><?php echo $hotelName; ?></strong></h3>
                                        <div class="paragraphs"><p><?php echo $description; ?></p></div>
                                        <div class="activity-image-block">
                                           <?php echo $cityImageTag; ?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="side-blocks">
                                    <div class="side-block-empty"></div>
                                </div>
                            </div>
                            <?php  
                        }
                    }

                    if($finalQuoteSortingD['serviceType']=='entrance'){
                        $b='';
                        $b=GetPageRecord('*','finalQuoteEntrance','quotationId="'.$quotationId.'" and id="'.$finalQuoteSortingD['serviceId'].'"');
                        if(mysqli_num_rows($b)){
                            $finalQuotEntData=mysqli_fetch_array($b);
                            $entranceId = $finalQuotEntData['entranceId'];

                            $d='';
                            $d=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'  id="'.$entranceId.'"');   
                            $entranceData=mysqli_fetch_array($d);

                            $description = $entranceData['entranceDetail'];
                            $entranceName = $entranceData['entranceName'];


                            $docQuery3 = $entPhotos= '';
                            $docQuery3=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$entranceId.'" and galleryType="entrance" and deletestatus=0 ) limit 3 ');
                            while($entranceImageD=mysqli_fetch_array($docQuery3)){
                                $entPhotos .= '<img title="entrance" src="'.$fullurl.$entranceImageD['uploadfile'].'" />';
                            }
                            ?>
                            <div class="block-container">
                                <div class="body">
                                    <div class="content-body">
                                        <h3><strong><?php echo $entranceName; ?></strong></h3>
                                        <div class="paragraphs"><p><?php echo $description; ?></p></div>
                                        <div class="activity-image-block">
                                           <?php echo $entPhotos; ?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="side-blocks">
                                    <div class="side-block-empty"></div>
                                </div>
                            </div>
                            <?php  
                        }
                    }

                    if($finalQuoteSortingD['serviceType']=='activity'){
                        $b='';
                        $b=GetPageRecord('*','finalQuoteActivity','quotationId="'.$quotationId.'" and id="'.$finalQuoteSortingD['serviceId'].'"');
                        if(mysqli_num_rows($b)){
                            $finalQuotActData=mysqli_fetch_array($b);
                            $activityId = $finalQuotActData['activityId'];

                            $d='';
                            $d=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'  id="'.$activityId.'"');   
                            $activityData=mysqli_fetch_array($d);

                            $description = $activityData['otherActivityDetail'];
                            $otherActivityName = $activityData['otherActivityName'];

                            $docQuery4 = $actPhotos= '';
                            $docQuery4=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$activityId.'" and galleryType="activity" and deletestatus=0 ) limit 3 ');
                            while($activityImageD=mysqli_fetch_array($docQuery4)){
                                $actPhotos .= '<img title="activity" src="'.$fullurl.$activityImageD['uploadfile'].'" />';
                            }

                            ?>
                            <div class="block-container">
                                <div class="body">
                                    <div class="content-body">
                                        <h3><strong><?php echo $otherActivityName; ?></strong></h3>
                                        <div class="paragraphs"><p><?php echo $description; ?></p></div>
                                        <div class="activity-image-block">
                                           <?php echo $actPhotos; ?>
                                        </div>
                                        <div class="clear">

                                        </div>
                                    </div>
                                </div>
                                <div class="side-blocks">
                                    <div class="side-block-empty"></div>
                                </div>
                            </div>
                            <?php 
                        }
                    }

                    if($finalQuoteSortingD['serviceType']=='transfer' || $finalQuoteSortingD['serviceType']=='transportation'){
                        $b='';
                        $b=GetPageRecord('*','finalQuotetransfer','quotationId="'.$quotationId.'" and id="'.$finalQuoteSortingD['serviceId'].'"');
                        if(mysqli_num_rows($b)){
                            while($fQMealPlanData=mysqli_fetch_array($b)){
                                $transferId = $fQMealPlanData['transferNameId'];

                                $d='';
                                $d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'  id="'.$transferId.'"');   
                                $transferData=mysqli_fetch_array($d);
                                $transferName = $transferData['transferName'];
                                $transferDetail = $transferData['transferDetail'];

                                ?>
                                <div class="block-container">
                                    <div class="body">
                                        <div class="content-body">
                                            <h3><strong><?php echo $transferName; ?></strong></h3>
                                            <div class="paragraphs"><p><?php echo $transferDetail; ?></p></div>
                                            <div class="activity-image-block">
                                               <?php //echo $actPhotos; ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="side-blocks">
                                        <div class="side-block-empty"></div>
                                    </div>
                                </div>
                                <?php 
                            }
                        } 
                    }
                }
            }
            ?>
            

            <?php
            if($quotationStatus != 1){
                echo '<div class="activity-image-block">';
                $b1='';
                $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and  startDate="'.$dayDate.'" and serviceType in ( "hotel","entrance","activity","additional","mealPlan","enroute","train","flight","transfer","transportation" ) order by srn ASC'); 
                while($quotSortingD=mysqli_fetch_array($b1)){ 
                    if($quotSortingD['serviceType']=='hotel'){
                        $b='';
                        $b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and id="'.$quotSortingD['serviceId'].'"');
                        if(mysqli_num_rows($b)){
                            $finalQuotData=mysqli_fetch_array($b);
                            $hotelId = $finalQuotData['supplierId'];

                            $d='';
                            $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'  id="'.$finalQuotData['supplierId'].'"');   
                            $hotelData=mysqli_fetch_array($d);

                            $description = $hotelData['hoteldetail'];
                            $hotelName = $hotelData['hotelName'];

                            $cityImageTag = '';
                            $docQuery2 = '';
                            $docQuery2=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$hotelId.'" and galleryType="hotel" and deletestatus=0 ) limit 3 ');
                            while($hotelImageD=mysqli_fetch_array($docQuery2)){
                                $cityImageTag .= '<img title="hotel" src="'.$fullurl.$hotelImageD['uploadfile'].'" />';
                            } 
                            ?>
                            <div class="block-container">
                                <div class="body">
                                    <div class="content-body">
                                        <h3><strong><?php echo $hotelName; ?></strong></h3>
                                        <div class="paragraphs"><p><?php echo $description; ?></p></div>
                                        <div class="activity-image-block">
                                           <?php echo $cityImageTag; ?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="side-blocks">
                                    <div class="side-block-empty"></div>
                                </div>
                            </div>
                            <?php  
                        }
                    }

                    if($quotSortingD['serviceType']=='entrance'){
                        $b='';
                        $b=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,'quotationId="'.$quotationId.'" and id="'.$quotSortingD['serviceId'].'"');
                        if(mysqli_num_rows($b)){
                            $finalQuotEntData=mysqli_fetch_array($b);
                            $entranceId = $finalQuotEntData['entranceNameId'];

                            $d='';
                            $d=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'  id="'.$entranceId.'"');   
                            $entranceData=mysqli_fetch_array($d);

                            $description = $entranceData['entranceDetail'];
                            $entranceName = $entranceData['entranceName'];


                            $docQuery3 = $entPhotos= '';
                            $docQuery3=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$entranceId.'" and galleryType="entrance" and deletestatus=0 ) limit 3 ');
                            while($entranceImageD=mysqli_fetch_array($docQuery3)){
                                $entPhotos .= '<img title="entrance" src="'.$fullurl.$entranceImageD['uploadfile'].'" />';
                            }
                            ?>
                            <div class="block-container">
                                <div class="body">
                                    <div class="content-body">
                                        <h3><strong><?php echo $entranceName; ?></strong></h3>
                                        <div class="paragraphs"><p><?php echo $description; ?></p></div>
                                        <div class="activity-image-block">
                                           <?php echo $entPhotos; ?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="side-blocks">
                                    <div class="side-block-empty"></div>
                                </div>
                            </div>
                            <?php  
                        }
                    }

                    
                    // Additional Requirements services 
                    if($quotSortingD['serviceType'] == 'additional'){ 
                        $where2='quotationId="'.$quotationId.'" and id="'.$quotSortingD['serviceId'].'"';						
                       $bccc=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
                       if(mysqli_num_rows($bccc) > 0){
                           $additionalQuotData=mysqli_fetch_array($bccc);
                           $additionalQuotData['additionalId'];
                          
                        $rs111=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
                        $extraData=mysqli_fetch_array($rs111); 
                        $extraData['id'];
                        // echo $additionalQuotData['name'];
                           ?>
                           <div class="block-container">
                               <div class="body">
                                   <div>
                                       <h3 style="display: block !important;"><?php echo '<strong>Additional - '.'<span style="display: inline-block; color: #6c2e2e; font-size: 15px;">'.ucfirst($additionalQuotData['name']).'</span></strong>'; ?></h3>
                                       <div class="paragraphs"><p style="font-size: 14px !important;"><?php echo $additionalQuotData['information']; ?></p></div>
                                       <div class="activity-image-block">
                                          <?php //echo $actPhotos; ?>
                                       </div>
                                       <div class="clear">

                                       </div>
                                   </div>
                               </div>
                               <div class="side-blocks">
                                   <div class="side-block-empty"></div>
                               </div>
                           </div>
                                     
                           <?php
                       }
                   }  

                   if($quotSortingD['serviceType'] == 'mealplan'){ 
                       $where2='quotationId="'.$quotationId.'" and id="'.$quotSortingD['serviceId'].'"';						
                       $b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
                       if(mysqli_num_rows($b) > 0){
                           $mealplanQuotData=mysqli_fetch_array($b);
                           ?>
                           <div class="block-container">
                               <div class="body">
                                   <div class="content-body">
                                       <h3> <?php echo  "<strong>Restaurant -</strong> ".strip(ucfirst($mealplanQuotData['mealPlanName'])); ?></h3>
                                       <div class="paragraphs"><p><?php //echo $description; ?></p></div>
                                       <div class="activity-image-block">
                                          <?php //echo $actPhotos; ?>
                                       </div>
                                       <div class="clear">

                                       </div>
                                   </div>
                               </div>
                               <div class="side-blocks">
                                   <div class="side-block-empty"></div>
                               </div>
                           </div>
                                     
                           <?php
                    
                       }
                   } 

                    if($quotSortingD['serviceType']=='activity'){
                        $b='';
                        $b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,'quotationId="'.$quotationId.'" and id="'.$quotSortingD['serviceId'].'"');
                        if(mysqli_num_rows($b)){
                            $finalQuotActData=mysqli_fetch_array($b);
                            $activityId = $finalQuotActData['otherActivityName'];

                            $d='';
                            $d=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'  id="'.$activityId.'"');   
                            $activityData=mysqli_fetch_array($d);

                            $description = $activityData['otherActivityDetail'];
                            $otherActivityName = $activityData['otherActivityName'];

                            $docQuery4 = $actPhotos= '';
                            $docQuery4=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$activityId.'" and galleryType="activity" and deletestatus=0 ) limit 3 ');
                            while($activityImageD=mysqli_fetch_array($docQuery4)){
                                $actPhotos .= '<img title="activity" src="'.$fullurl.$activityImageD['uploadfile'].'" />';
                            }

                            ?>
                            <div class="block-container">
                                <div class="body">
                                    <div class="content-body">
                                        <h3><strong><?php echo $otherActivityName; ?></strong></h3>
                                        <div class="paragraphs"><p><?php echo $description; ?></p></div>
                                        <div class="activity-image-block">
                                           <?php echo $actPhotos; ?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="side-blocks">
                                    <div class="side-block-empty"></div>
                                </div>
                            </div>
                            <?php 
                        }
                    }

                }
            }
            ?>
        </div> 
        <?php 
        $dayNo2++;
    } 
    ?> 
</div> 
<!-- test end of itenary -->
<div class="custom_title-bar custom_border_colour primary">
                <h2> 
                    <span class="light light-mob">END OF ITINERARY </span>       
                </h2> 
            </div>
            <!-- test end of itenary -->
<?php 
include "footer.php"; 
?>