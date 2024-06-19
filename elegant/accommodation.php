<?php 
$page='accommodation';
include "header.php"; 
?>

<style>
    .acco-bac-containt{
        margin-top: 10px!important;
    }
    .block-container{
        background: white;
    }
    @media only screen and (max-width: 600px) {
        .h-n-d-mob{
            font-size: 15px!important;
        }
        .paragraphs p{
            text-align: justify;
        }
        .nested{
            background: gainsboro;
        }
        .side-mob{
            width: 100%!important;
            margin-right: 0px!important;

        }
        .your-stay-mob{
            width: 100%!important;
        }
    }

</style>


<div class="page-content">
    <?php 
    $dayNo = 1;
    $where2='quotationId="'.$quotationId.'" group by hotelId order by fromDate asc';
    $b=GetPageRecord('*','finalQuote',$where2);
    if(mysqli_num_rows($b) >0 && $quotationStatus == 1){
        while($finalQuotData=mysqli_fetch_array($b)){ 
      
            $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'  id="'.$finalQuotData['hotelId'].'"');   
            $hotelData=mysqli_fetch_array($d);
            $cityDetails = $hotelData['hoteldetail'];

            $dayDate = $finalQuotData['fromDate'];
            $cityId = $finalQuotData['destinationId'];
            $destName = getDestination($cityId);

            $docQuery = $cityImageTag= '';
            $docQuery=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$finalQuotData['hotelId'].'" and galleryType="hotel" and deletestatus=0 ) limit 3 ');
            while($destImageD=mysqli_fetch_array($docQuery)){
                $cityImageTag .= '<img title="City"  class="destination-image" src="'.$fullurl.str_replace(' ','%20',$destImageD['uploadfile']).'" />';
            }
            ?>
            <div class="content-block custom_border_colour primary acco-bac-containt">
                <div class="nav-target" id="destination-2"></div>
                <div class="custom_title-bar custom_border_colour primary">
                    <h2 class="h-n-d-mob"><?php echo ucfirst($hotelData['hotelName']).' | '.ucfirst($destName);?> </h2>
                    <h4 class="date"><?php echo date('j M Y',strtotime($dayDate));  ?></h4>
                </div>
                <div class="block-container">
                    <div class="body">
                        <div class="paragraphs content-body ">
                            <p><?php echo $cityDetails; ?></p>
                            <div class="activity-image-block">
                                <?php
                                echo $cityImageTag; //destination Image
                                ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="side-blocks nested">
                        <div class="side-block custom_border_colour secondary side-mob">
                            <div class="custom_title-bar custom_border_colour secondary">
                                <h3>YOUR STAY</h3>
                            </div>
                            <div>
                                <?php 
                                $finalHotelQuery='';
                                $finalHotelQuery=GetPageRecord('*','finalQuote',' quotationId="'.$quotationId.'" and hotelId="'.$finalQuotData['hotelId'].'"');
                                $nofnights = mysqli_num_rows($finalHotelQuery);
                                if($nofnights>0){
                                    $finalQuotData=mysqli_fetch_array($finalHotelQuery);
                                    $select2='name';  
                                    $where2='id="'.$finalQuotData['mealPlanId'].'"'; 
                                    $rs2=GetPageRecord($select2,_MEAL_PLAN_MASTER_,$where2); 
                                    $editresult2=mysqli_fetch_array($rs2); 
                                     
                                    
                                     ?>
                                    <div><p>Nights : <?php echo trim($nofnights); ?> </p></div>
                                    <div><p>Meal Plan : <?php  echo getRoomType($finalQuotData['roomType'])."/".clean($editresult2['name']); ?> Basis</p></div>

                                    <?php 
                                    $halists='';
                                    $rs12=GetPageRecord('*','finalQuoteHotelAdditional','finalQuotId="'.$finalQuotData['id'].'" and quotationId="'.$finalQuotData['quotationId'].'" '); 
                                    if(mysqli_num_rows($rs12)>0){
                                        while ($editresult2=mysqli_fetch_array($rs12)) {
                                            $halists  .= $editresult2['name'].', ';
                                        }
                                    ?>
                                    <div><p>Additionals : <?php  echo rtrim($halists,', '); ?> </p></div>
                                    <?php 
                                    }

                                } 
                                $rooms='';
                                if($quotationData['sglRoom']>0){ $rooms .= $quotationData['sglRoom'].' SGL Room<br>'; }
                                if($quotationData['dblRoom']>0){ $rooms .= $quotationData['dblRoom'].' DBL Room<br>'; }
                                if($quotationData['tplRoom']>0){ $rooms .= $quotationData['tplRoom'].' TPL Room<br>'; }
                                if($quotationData['twinRoom']>0){ $rooms .= $quotationData['twinRoom'].' TWIN Room<br>'; }
                                if($quotationData['childwithNoofBed']>0){ $rooms .= $quotationData['childwithNoofBed'].' ExtraBed(Child) Room<br>'; }
                                ?>
                            </div>
                        </div>
                        <div class="side-block custom_border_colour secondary side-mob">
                            <div class="custom_title-bar custom_border_colour secondary"><h3>Your Rooms</h3></div>
                            <span><p><?php echo $rooms;?></p></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        } 
    } 
    ?>
    <?php 
    $dayNo = 1;
    $where2='quotationId="'.$quotationId.'" group by supplierId order by fromDate asc';
    $b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,$where2);
    if(mysqli_num_rows($b) >0 && $quotationStatus != 1){
        while($hotelQuotData=mysqli_fetch_array($b)){ 
      
            $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'  id="'.$hotelQuotData['supplierId'].'"');   
            $hotelData=mysqli_fetch_array($d);
            $cityDetails = $hotelData['hoteldetail'];
            $termsandcoditions = $hotelData['termAndCondition'];

            $dayDate = $hotelQuotData['fromDate'];
            $cityId = $hotelQuotData['destinationId'];
            $destName = getDestination($cityId);

            $docQuery = $cityImageTag= '';
            $docQuery=GetPageRecord('uploadfile','documentFiles',' fileDimension="380x246" and id in ( select fileId from '._IMAGE_GALLERY_MASTER_.' where  parentId="'.$hotelQuotData['supplierId'].'" and galleryType="hotel" and deletestatus=0 ) limit 3 ');
            while($destImageD=mysqli_fetch_array($docQuery)){
                $cityImageTag .= '<img title="City"  class="destination-image" src="'.$fullurl.str_replace(' ','%20',$destImageD['uploadfile']).'" />';
            }
            ?>
            <div class="content-block custom_border_colour primary ">
                <div class="nav-target" id="destination-2"></div>
                <div class="custom_title-bar custom_border_colour primary">
                    <h2><?php echo ucfirst($hotelData['hotelName']).' | '.ucfirst($destName);?> </h2>
                    <h4 class="date"><?php echo date('j M Y',strtotime($dayDate));  ?></h4>
                </div>
                <div class="block-container">
                    <div class="body">
                        <div class="paragraphs content-body ">
                            <?php if($cityDetails!=''){ ?> 
                            <h3>Hotel Information</h3>
                            <p><?php echo $cityDetails; ?></p>
                            <?php } ?>
                            <div class="activity-image-block">
                                <?php
                                echo $cityImageTag; //destination Image
                                ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div>
                        <?php if($termsandcoditions!=''){ ?> 
                            <h3>Terms and Conditions</h3>
                            <p><?php echo $termsandcoditions; ?></p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="side-blocks nested">
                        <div class="side-block custom_border_colour secondary your-stay-mob">
                            <div class="custom_title-bar custom_border_colour secondary">
                                <h3>YOUR STAY</h3>
                            </div>
                            <div>
                                <?php 
                                $finalHotelQuery='';
                                $finalHotelQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and supplierId="'.$hotelQuotData['supplierId'].'"');
                                $nofnights = mysqli_num_rows($finalHotelQuery);
                                if($nofnights>0){
                                    $hotelQuotData=mysqli_fetch_array($finalHotelQuery);
                                    $select2='name';  
                                    $where2='id="'.$hotelQuotData['mealPlanId'].'"'; 
                                    $rs2=GetPageRecord($select2,_MEAL_PLAN_MASTER_,$where2); 
                                    $editresult2=mysqli_fetch_array($rs2); 
                                     

                                     ?>
                                    <div><p><?php echo trim($nofnights); ?> Nights</p></div>
                                    <div><p>Meal Plan : <?php  echo getRoomType($finalQuotData['roomType'])."/".clean($editresult2['name']); ?> Basis</p></div>
                                    <?php 
                                    $halists='';
                                    $rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'" '); 
                                    if(mysqli_num_rows($rs12)>0){
                                        while ($editresult2=mysqli_fetch_array($rs12)) {
                                            $halists  .= $editresult2['name'].', ';
                                        }
                                            
                                        ?>
                                        <div><p>Additionals : <?php  echo rtrim($halists,', '); ?> </p></div>
                                        <?php 
                                    }
                                } 
                                $rooms='';
                                if($quotationData['sglRoom']>0){ $rooms .= $quotationData['sglRoom'].' SGL Room<br>'; }
                                if($quotationData['dblRoom']>0){ $rooms .= $quotationData['dblRoom'].' DBL Room<br>'; }
                                if($quotationData['tplRoom']>0){ $rooms .= $quotationData['tplRoom'].' TPL Room<br>'; }
                                if($quotationData['twinRoom']>0){ $rooms .= $quotationData['twinRoom'].' TWIN Room<br>'; }
                                if($quotationData['childwithNoofBed']>0){ $rooms .= $quotationData['childwithNoofBed'].' ExtraBed(Child) Room<br>'; }
                                ?>
                            </div>
                        </div>
                        <div class="side-block custom_border_colour secondary your-stay-mob">
                            <div class="custom_title-bar custom_border_colour secondary"><h3>Your Rooms</h3></div>
                            <span><p><?php echo $rooms;?></p></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        } 
    }
   
    ?>
</div>
<?php 
include "footer.php"; 
?>