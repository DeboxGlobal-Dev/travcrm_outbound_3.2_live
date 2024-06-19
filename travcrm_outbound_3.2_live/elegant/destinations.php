<?php 
$page='destinations';
include "header.php"; 
?>
<style>
    .dest-inf-des{
        background: white;
        margin-top: 10px;
    }

@media only screen and (max-width: 600px) {
            .paragraphs{
                text-align: justify;
             }
             .dest-name-mob{
                /* color: red; */
             }
             .side-1-mob{
                width: 100%!important;
                margin-right: 0px!important;

             }
             .side-mob{
                text-align: center;
                background: gainsboro;
             }
             /* .side-2-mob{
                width: 100%!important;
                margin-right: 0px!important;
             } */
             .hotel-name-mob{
                text-align: left;
             }
        }
</style>
<div class="page-content">
    <?php 
    $dayNo2 = 1;
    // _DOCUMENT_FILES_MASTER_
    $dayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" and addstatus=0 and deletestatus=0 group by cityId order by srdate asc');
    while($daysData=mysqli_fetch_array($dayQuery)){
        $dayDate = $daysData['srdate'];
        $cityId = $daysData['cityId'];
        $dayId = $daysData['id'];
        $destName = getDestination($cityId);

        $cityQuery=GetPageRecord('*','destinationMaster',' id="'.$cityId.'" ');
        $cityData=mysqli_fetch_array($cityQuery);
        $cityDetails = $cityData['description'];
         
        $docQuery = $cityImageTag= '';
        $docQuery=GetPageRecord('*','documentFiles',' fileDimension="380x246" and id in (select fileId from imageGallery where  parentId="'.$cityId.'" and galleryType="destination" and deletestatus=0) order by id desc LIMIT 3');
        while($destImageD=mysqli_fetch_array($docQuery)){
          
           $cityImageTag .= '<img class="destination-image" src="'.$fullurl.str_replace(' ','%20',$destImageD['uploadFile']).'" title="City" />';
        //    echo $destImageD['uploadFile'];
          
        }
        
        ?>
        <div class="content-block custom_border_colour primary dest-inf-des">
            <div class="nav-target" id="destination-2"></div>
            <div class="custom_title-bar custom_border_colour primary">
                <h2 class="dest-name-mob"><?php echo ucfirst($destName);?></h2>
                <h4 class="date"><?php echo date('j M Y',strtotime($dayDate));  ?></h4>
            </div>
            <div class="block-container">
                <div class="body">
                    <div class="paragraphs content-body ">
                        <p class="pr-mob"><?php echo $cityDetails; ?></p>
                        <div class="activity-image-block">

                            <?php
                            		
                            echo $cityImageTag; //destination Image
                            ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="side-blocks nested side-mob">
                    <div class="side-block custom_border_colour secondary side-1-mob">
                        <div class="custom_title-bar custom_border_colour secondary">
                            <h3>Accommodation</h3>
                        </div>
                        <div class="hotel-name-mob">
                        <?php
                        if($quotationStatus == 1){ 
                            $finalHotelQuery='';
                            $finalHotelQuery=GetPageRecord('*','finalQuote','quotationId="'.$quotationId.'" and destinationId="'.$cityId.'" group by hotelId');
                            if(mysqli_num_rows($finalHotelQuery)){
                                while($finalQuotData=mysqli_fetch_array($finalHotelQuery)){
                                    $hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'  id="'.$finalQuotData['hotelId'].'"');   
                                    $hotelData=mysqli_fetch_array($hotelQuery);
                                    ?>
                                    <a href="<?php echo trim($hotelData['url']); ?>"><?php echo trim($hotelData['hotelName']); ?></a>
                                    <?php 
                                }
                            } 
                        }
                        ?>
                        <?php
                        if($quotationStatus != 1){ 
                            $finalHotelQuery='';
                            $finalHotelQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and destinationId="'.$cityId.'" group by supplierId');
                            if(mysqli_num_rows($finalHotelQuery)){
                                while($finalQuotData=mysqli_fetch_array($finalHotelQuery)){
                                    $hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'  id="'.$finalQuotData['supplierId'].'"');   
                                    $hotelData=mysqli_fetch_array($hotelQuery);
                                    ?>
                                    <a href="<?php echo trim($hotelData['url']); ?>"><?php echo trim($hotelData['hotelName']); ?></a>
                                    <?php 
                                }
                            } 
                        }
                        ?>
                        </div>
                    </div>
                    <div class="side-block custom_border_colour secondary side-1-mob">
                        <div class="custom_title-bar custom_border_colour secondary"><h3>More Information</h3></div>
                        <span><a class="lightbox-content hotel-name-mob" href="https://www.google.com/search?q=<?php echo ucfirst($destName);?>"><?php echo ucfirst($destName);?></a></span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php 
include "footer.php"; 
?>