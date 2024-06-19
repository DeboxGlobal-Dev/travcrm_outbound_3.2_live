<?php

include "inc.php";  

// include "config/logincheck.php";  


function dateDiffInDays($date1, $date2){ 

	// Calulating the difference in timestamps 

	$diff = strtotime($date2) - strtotime($date1); 

	// 1 day = 24 hours 

	// 24 * 60 * 60 = 86400 seconds 

	return abs(round($diff / 86400)); 

}

$queryId='';

if($_GET['queryId']!=''){

    $queryId = $_GET['queryId'];

}




$select='*';

$where='id="'.$queryId.'"';

$rs=GetPageRecord($select,_QUERY_MASTER_,$where);   

$resultpage=mysqli_fetch_array($rs);


$select1='*';   
$where1='id=1'; 
$rs1=GetPageRecord($select1,'lettersettings',$where1); 
$editresult=mysqli_fetch_array($rs1);

$rs22=GetPageRecord('*','companySettingsMaster','id=1');
$resultCompany=mysqli_fetch_array($rs22);

$selectu='*';    

$whereu=' id="'.$resultpage['assignTo'].'"  ';  
$rsu=GetPageRecord($selectu,_USER_MASTER_,$whereu); 

while($resListingu=mysqli_fetch_array($rsu)){ 



  $operationPerson=$resListingu['firstName'].' '.$resListingu['lastName'];
  $phone=$resListingu['phone'];

 
 
  $rs1=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$resultpage['id'].'" and status=1 order by id desc');  
  $quotationData=mysqli_fetch_array($rs1);
  // echo $quotationData['id'];

  // echo $queryId."Mohd Islam";
  // exit;
  

  $rs22=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationData['id'].'"');
  $hotellisting=mysqli_fetch_array($rs22);

}

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/v4-shims.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

<div style="margin-bottom:10px;">

<style>
  .icon-s{
            font-size: 31px;
            background: blue;
            border-radius: 50%;
        }
        .comp-details{
            font-family: sans-serif;
            font-size: 15px;
            font-weight: bold;
            text-align: justify;
     }
        .comp-re{
            font-family: sans-serif;
            font-size: 18px;
            font-weight: bold;
        }
        .cmp-header-img img{
          width: 100%;
          height: 100px;
          display: inline-block;
          /* position: relative; */
          background-attachment: fixed;
          z-index: -1;
        }
        .feedback-dubai-tour{
          float: right;
          margin-top: -12%!important;
          z-index: 1;
          margin-right: 0px;
          background: #5a5ab0;
          width: 254px;
          height: 59px;
          padding-left: 2px;
          padding-top: -14px;
          border-bottom-left-radius: 60px;
          color: white;
          position: absolute;
          margin-left: 61%;
          padding-left: 67px!important;
      }
        .top-img-se{
            position: inherit;
        }
        .service-name{
            padding-left: 77px;
            margin-top: -29px;
            margin-bottom: 0px;
        }
        .table tr td input{
            margin-left: 12px;
            width: 17px;
            height: 18px;
        }
        .icons-right{
            width: 40px;
            height: 40px;
        }
        /* .bottum-sec-text{
            background:clip-path:polygon(49% 59%, 75% 54%, 100% 60%, 100% 100%, 0 100%, 0% 60%, 21% 54%);
        } */
        .bottum-sec-text{
            margin-top: 50px;
        }

.vlist a{ 

    display: block;

    font-size: 15px;

    color: #006633;

    background-color: #F5FFE8;

    border: 1px solid #a7e7c1;

    padding: 10px;

    text-decoration: none;

    border-radius: 3PX;

    font-size: 15px;

}



  h4{

    font-weight: 400

      }

      .tabd{

      	/*border: 1px solid black;*/

      	border-spacing: 20px!important;

      	/*text-align: center;*/

      }

      .tabd td{

      	border-bottom: 1px solid black!important;

      }
      input[type="radio"] {
    display: block;
}
.reting{
  border: none;
}

.circle-size{
  width: 54px;
    height: 18px;
}
.sendbtn{
  display: block!important;
}
.tdate{
  margin-right: 7px;
    float: right;
}

.chedatetade{
  margin-left: 44%!important;
}
.feedbtn-mail{
  background: #f34f4f;
    color: #fff;
    padding: 10px 20px;
    display: inline-block;
    border-radius: 3px;
    text-decoration: none;
    margin-top: 20px;
    font-size: 12px;
    line-height: 16px;
    margin-left: 0px!important;
}
.cmp-logo{
  max-height: 130px;
    max-width: 500px;
    /* margin-top: -8%; */
    margin-left: -49%;
    position: absolute;
    width: 150px;
    height: 62px;
    margin-top: -1%!important;
}
.check-out{
  margin-right: 111px;
    font-weight: bold;
    width: 217px;
    margin-left: 61%;
}
.pex-name{
  margin-left: 8px;
    position: absolute;
    top: 38%;
}

</style>

<div style="padding:10px;" class="vlist2">	



<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">

<div id="printableArea<?php echo strip($resultpage['id']); ?>">

<div style="padding-top:3px; background-color:#FFFFFF; border:2px dashed #ccc;   position:relative; margin:10px;" >
<div class="top-img-sec" style="display: none;">
                    <div class="header-img">
                        <!-- <div class="cmp-log"><img src="img/debox logo.png" alt=""></div> -->
                        <!-- <div class="cmp-header-img" ><img src="img/feedback-form-header.jpg" alt="" width="730" height="100"></div> -->
                        
                        <h2 class="feedback-dubai-tour"
                          style=" float: right;
                                  margin-top: -14%;
                                  z-index: 1;
                                  margin-right: 0px;
                                  background: #5a5ab0;
                                  width: 254px;
                                  height: 59px;
                                  padding-left: 2px;
                                  padding-top: -14px;
                                  border-bottom-left-radius: 60px;
                                  color: white;
                                  position: absolute;
                                  margin-left: 61%;
                                  padding-left: 30px;";
                        >FEEDBACK - <?php echo $resultpage['subject'];?></h2>
                        
                        <!-- <h2 class="feedback-dubai-tour">FEEDBACK - DUBAI TOURS</h2> -->
                    </div>
                </div>&nbsp;&nbsp;&nbsp;
<table width="100%">

	<tr>

    <td width="100%" align="center"><img class="cmp-logo" src="<?php echo $fullurl; ?>dirfiles/<?php echo clean($resultCompany['proposalLogo']); ?>" style="max-height: 130px;
    max-width: 500px;
    margin-top: 2%;
    margin-left: -48%;
    position: absolute;
    width: 150px;
    height: 60px;" /></td>

    </tr>

</table>

<div>
  <!-- <h4 style="text-align: center">FEEDBACK FORM</h4> feedback form -->

<table width="100%">
<tr>

<!-- <td width="100%" align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo clean($resultCompany['proposalLogo']); ?>" style="    max-height: 130px;
    max-width: 500px;
    margin-top: 5%!important;
    margin-left: -47%;
    position: absolute;
    width: 107px;" /></td> -->

</tr>

  <tr>

    <td style="width:50%;">

    <h4 class="pex-name" style="margin-left: 8px;
    position: absolute;
    top: 40%;">Dear <?php echo $resultpage['leadPaxName']; ?>,</h4>

    </td>

    <td style="width: 50%; text-align: right;">

      <!-- <h4 style="margin-right: 10px;">Tour Ref No. : <?php echo $resultpage['referanceNumber'];?></h4> -->
      <h4 class="chedatetade check-out" style="margin-right: 111px;
    font-weight: bold;
    width: 217px;
    margin-left: 38%;">CHECKOUT DATE</h4>
      <h4 style="margin-right: 10px;" class="tdate"> <?php echo date('d-m-Y',strtotime($resultpage['toDate']));?></h4>

    </td>
    <tr>
      <td colspan="3" valign="top" align="left">&nbsp;</td>
    </tr>


  </tr>
  <tr>
      <td colspan="3" style="background-color: #4caf50; color: #ffffff" valign="top" align="left">
	  <div style="padding: 10px; text-align: center; font-size: 14px; text-transform: uppercase; font-weight: 600">SHARE YOUR EXPERIENCE</div>	  </td>
    </tr>


</table>

<br>

<div class="row" style="width: 100%;
    display: flex;
    margin-top: 102px;">
  <div class="col-6" style="width: 50%;margin-left: 10px;">
  <h4 style="line-height: 26px;text-align: justify;">
  Hope you had a pleasant trip.
</h4>

<h4 style="line-height: 26px;margin-left: 35px;">
<!-- <li> -->
<h4 style="width: 200%;
    margin-top: 6px;">We at <?php echo $resultCompany['companyName']; ?>  are constantly trying to improve your travel experience. To help us do that, please spare a few minutes for a brief survey about your trip.</h4>
    <h4 style="    margin-top: 25px;">Your feedback is important to us.</h4>
    
    

    
    <td colspan="3" valign="top" align="left"><a class="feedbtn-mail" href="sendFeedbackOnline.php?queryId=<?php echo $_GET['queryId']; ?>" style=" background: #f34f4f;color: #fff;padding: 10px 20px;display: inline-block;border-radius: 3px;text-decoration: none;margin-top: 20px;font-size: 12px;line-height: 16px;margin-left: -35px;" target="_blank" rel="noreferrer">Submit your Feedback</a></td>
<!-- </li> -->
</h4>
<h4>
<br>
<br>
Best Regards <br>
<?php echo $resultCompany['companyName']; ?>
</h4>
  </div>
  <div class="col-6"  style="width: 36%;margin-left: 10%;">
    <!-- <a><img src="img/feedback-form-phones.png" style="width: 100%; height: 200px;"></a> -->
</div>
  </div>
</div>



<br>

<!-- <h4 style="line-height: 26px;text-align: center;"><b>Please tick as applicable</b> -->

</h4>

<table width="100%" class="tabd" style="display: none;">
  <?php 
  //  $resfinaleq = GetPageRecord('*','finalquotationItinerary','quotationId="'.$quotationData['id'].'" and queryId="'.$resultpage['id'].'"');
  //   while($finalQuoteres = mysqli_fetch_array($resfinaleq)){

  $resH = GetPageRecord('*','finalQuote','quotationId="'.$quotationData['id'].'" and manualStatus=3');
  if(mysqli_num_rows($resH)>0){
  ?>
  <tr style="border-bottom:0px!important;">
<td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;">
<div class="retings">
<span style="position: absolute;left: 38%; margin-top: 3%;"><b>Excellent</b></span>
<span style="position: absolute;left: 50%;margin-top: 3%;"><b>Very Good</b></span>
<span style="position: absolute;left: 65%;margin-top: 3%;"><b>Good</b></span>
<span style="position: absolute;left: 76%;margin-top: 3%;"><b>Average</b></span>
<span style="position: absolute;left: 90%;margin-top: 3%;"><b>Poor</b></span>
</div>
</h4>
  
</td>

</tr>
  <tr>

  <td colspan="6" ><h4 style=" width: 170px; display: inline-block; padding-right:10px; "><b style="margin-left: 44px;">
    <img class="icons-right" src="img/feedback-form-Hotel.png" alt="icon hotel" style="    position: absolute;
    left: 10px;
    margin-top: -8px;
    width: 30px">
    Hotel</b></h4><h4 style="width: 80px; display: inline-block;"><b>Destination</b></h4></td>


</tr>
  <?php
  while($finalQuoteHotel = mysqli_fetch_assoc($resH)){
  $hotelId = $finalQuoteHotel['hotelId'];
  $destinationId = $finalQuoteHotel['destinationId'];

  $res3 = GetPageRecord('*','packageBuilderHotelMaster','id="'.$hotelId.'"');
   $hotelData = mysqli_fetch_assoc($res3);

   $resD = GetPageRecord('*','destinationMaster','id="'.$destinationId.'"');
   $destinationData = mysqli_fetch_assoc($resD);
?>

<tr>

  <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block; padding-right:10px;vertical-align: top;"><?php echo $hotelData['hotelName']; ?></h4><h4 style="width: 80px;
    display: inline-block;
    vertical-align: top;
    margin-left: 70%;
    margin-top: -18px;"><?php echo $destinationData['name']; ?></h4></td>

                                <td style="border-bottom:0px!important;">
                                  <input class="circle-size" type="radio" aria-label="Radio button for following text input" name="hotel1"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="hotel1"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="hotel1"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="hotel1"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="hotel1"></td>

</tr>
<?php 

} 
}
?>

<!-- Restaurant services -->

  <?php 

  $resR = GetPageRecord('*','finalQuoteMealPlan','quotationId="'.$quotationData['id'].'" and manualStatus=3');
  if(mysqli_num_rows($resR)>0){
  ?>
  <tr>
<td colspan="6" ><h4 style=" width: 170px; display: inline-block; padding-right:10px; ">
<b style="margin-left: 44px;">
<img class="icons-right" src="img/feedback-form-restaurant.png" alt="icon hotel" style="    position: absolute;
    left: 10px;
    margin-top: -8px;
    width: 30px">  
Restaurant</b></h4><h4 style="width: 80px; display: inline-block;"><b>Destination</b></h4></td>
</tr>
  <?php
  while($finalQuoteRest = mysqli_fetch_assoc($resR)){
  $mealPlanName = $finalQuoteRest['mealPlanName'];
  $ResdestinationId = $finalQuoteRest['destinationId'];

   $restD = GetPageRecord('*','destinationMaster','id="'.$ResdestinationId.'"');
   $destinationDataRest = mysqli_fetch_assoc($restD);
?>

<tr>

  <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block; padding-right:10px;vertical-align: top;"><?php echo $mealPlanName; ?></h4><h4 style="width: 80px; display: inline-block; vertical-align: top;margin-left: 70%;
    margin-top: -18px;"><?php echo $destinationDataRest['name']; ?></h4></td>

                                <td style="border-bottom:0px!important;">
                                  <input class="circle-size" type="radio" aria-label="Radio button for following text input" name="restr1"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="restr1"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="restr1"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="restr1"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="restr1"></td>

</tr>
<?php 

} 
}
?>
 <!-- Trasport or trasfer -->
<?php
  $resTPT = GetPageRecord('*','finalQuotetransfer','quotationId="'.$quotationData['id'].'" and manualStatus=3');
  if(mysqli_num_rows($resTPT)>0){
  ?>
   <tr>

<td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b style="margin-left: 44px;">
<img class="icons-right" src="img/feedback-form-transport.png" alt="icon hotel" style="    position: absolute;
    left: 10px;
    margin-top: -8px;
    width: 30px">

Transport</h4><h4 style="width: 80px; display: inline-block;"><b>Destination</h4></td>

</tr>
  <?php
    while( $finalQuoteTPT = mysqli_fetch_assoc($resTPT)){
    $transferId = $finalQuoteTPT['transferId'];
    $destinationIdTPT = $finalQuoteTPT['destinationId'];

    $resTPT3 = GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferId.'"');
   $transferData = mysqli_fetch_assoc($resTPT3);

   $resTPTD = GetPageRecord('*','destinationMaster','id="'.$destinationIdTPT.'"');
   $TPTdestinationData = mysqli_fetch_assoc($resTPTD);
  //  echo $transferData['transferName'];
?>

  <tr class="">

    <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $transferData['transferName']; ?> </h4><h4 style="width: 80px; display: inline-block; vertical-align: top; margin-left: 70%;
    margin-top: -18px;"><?php echo $TPTdestinationData['name']; ?></h4></td>

                                  <td style="border-bottom:0px!important;">
                                  <input type="radio" aria-label="Radio button for following text input" name="trasport "></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="trasport"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="trasport"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="trasport"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="trasport"></td>
  </tr>
  <?php 
}
}

?>
<!-- Guide services -->

<?php
    $resguide = GetPageRecord('*','finalQuoteGuides','quotationId="'.$quotationData['id'].'" and manualStatus=3');
    if(mysqli_num_rows($resguide)>0){
    ?>
    <tr>
    <td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b style="margin-left: 44px;">
      
    <img class="icons-right" src="img/feedback-form-transport.png" alt="icon hotel" style="    position: absolute;
    left: 10px;
    margin-top: -8px;
    width: 30px;">
    Guide</b></h4>
    <h4 style="width: 80px; display: inline-block;"><b style="">Destination</b></h4></td>

    </tr>
    <?php 
    while( $finalQuoteGuide = mysqli_fetch_assoc($resguide)){
    $guideId = $finalQuoteGuide['guideId'];
    $destinationIdguide = $finalQuoteGuide['destinationId'];

    $resG = GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$guideId.'"');
   $GuideData = mysqli_fetch_assoc($resG);

   $resGuide = GetPageRecord('*','destinationMaster','id="'.$destinationIdguide.'"');
   $guidedestinationData = mysqli_fetch_assoc($resGuide);
  //  echo $transferData['transferName'];
?>

  <tr class="">

    <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $GuideData['name']; ?> </h4><h4 style="width: 80px; display: inline-block; vertical-align: top; margin-left: 70%;
    margin-top: -18px;"><?php echo $guidedestinationData['name']; ?></h4></td>

                                  <td style="border-bottom:0px!important;">
                                  <input class="circle-size"  type="radio" aria-label="Radio button for following text input" name="guide"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="guide"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="guide"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="guide"></td>
                                    <td style="border-bottom:0px!important;"><input  class="circle-size" type="radio" aria-label="Radio button for following text input" name="guide"></td>
  </tr>
  <?php 
}
    }

?>
<!-- Tour Manager services -->

<?php
    $resT = GetPageRecord('tourManager','queryMaster','id="'.$resultpage['id'].'" and tourManager>0 ');
    if(mysqli_num_rows($resT)>0){
    ?>
    <tr>
    <td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b style="margin-left: 44px;">
    
    <img class="icons-right" src="img/feedback-form-transport.png" alt="icon hotel" style="    position: absolute;
    left: 10px;
    margin-top: -8px;
    width: 30px">
    Tour Manager</h4><h4 style="width: 80px; display: inline-block;"><b>Destination</h4></td>

    </tr>
    <?php
    while( $queryData = mysqli_fetch_assoc($resT)){
    $tourManagerId = $queryData['tourManager'];

    $destinationIdtourM = $queryData['destinationId'];

    $resTM = GetPageRecord('*',_GUIDE_MASTER_,'id="'.$tourManagerId.'"');
   $tourMData = mysqli_fetch_assoc($resTM);

   $rest2 = GetPageRecord('*','destinationMaster','id="'.$destinationIdtourM.'"');
   $tourdestinationData = mysqli_fetch_assoc($rest2);
  //  echo $transferData['transferName'];
?>

  <tr>

    <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $tourMData['name']; ?> </h4><h4 style="width: 80px; display: inline-block; vertical-align: top; margin-left: 70%;
    margin-top: -18px;"><?php echo $tourdestinationData['name']; ?></h4></td>

                                <td style="border-bottom:0px!important;">
                                  <input class="circle-size" type="radio" aria-label="Radio button for following text input" name="manager"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="manager"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="manager"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="manager"></td>
                                    <td style="border-bottom:0px!important;"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="manager"></td>
  </tr>
  <?php 
}

    }
?>

<?php
    $resDriver = GetPageRecord('*','driverAllocationDetails','queryId="'.$resultpage['id'].'" and quotationId="'.$quotationData['id'].'"');
    if(mysqli_num_rows($resDriver)>0){
    ?>
    <tr>
    <td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b style="margin-left: 44px;">
    <img class="icons-right" src="img/feedback-form-transport.png" alt="icon hotel" style="position: absolute;
    left: 11px;
    margin-top: -5px;">
    
    Driver</h4><h4 style="width: 80px; display: inline-block;"><b>Destination</h4></td>

    </tr>
    <?php
    while( $driverData = mysqli_fetch_assoc($resDriver)){
    $driverId = $driverData['driverId'];

    $destinationIdtourM = $driverData['destinationId'];

    $resDr = GetPageRecord('*',_DRIVER_MASTER_MASTER_,'id="'.$driverId.'"');
   $driverData = mysqli_fetch_assoc($resDr);

   $rest2 = GetPageRecord('*','destinationMaster','id="'.$destinationIdtourM.'"');
   $tourdestinationData = mysqli_fetch_assoc($rest2);
  //  echo $transferData['transferName'];
?>

  <tr>

    <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $driverData['name']; ?> </h4><h4 style="width: 80px; display: inline-block; vertical-align: top; margin-left: 70%;
    margin-top: -18px;"><?php echo $tourdestinationData['name']; ?></h4></td>

                                  <td>
                                  <input class="circle-size" type="radio" aria-label="Radio button for following text input" name="transfer1"></td>
                                    <td><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="transfer1"></td>
                                    <td><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="transfer1"></td>
                                    <td><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="transfer1"></td>
                                    <td><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="transfer1"></td>
  </tr>
  <?php 
}
    }

?>
<tr>
<td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;">
<!-- <div class="retings">
<span style="position: absolute;left: 33%;margin-top: -2%;">Excellent</span>
<span style="position: absolute;left: 47%;margin-top: -2%;">Very Good</span>
<span style="position: absolute;left: 60%;margin-top: -2%;">Good</span>
<span style="position: absolute;left: 73%;margin-top: -2%;">Average</span>
<span style="position: absolute;left: 86%;margin-top: -2%;">Poor</span>
</div> -->
</h4>
  
</td>

</tr>
<tr>

<td style="border-bottom:0px!important; width: 258px;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><strong style="margin-left: 44px;">

<img class="icons-right" src="img/feedback-form-transport.png" alt="icon hotel" style="    position: absolute;
    left: 10px;
    margin-top: -8px;
    width: 30px;">
Overall Rating</strong></h4></td>

                                    <td class="" style="border-bottom:0px!important">
                                    <input class="circle-size" type="radio" aria-label="Radio button for following text input" name="aratin"></td>
                                    <td style="border-bottom:0px!important"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="aratin"></td>
                                    <td style="border-bottom:0px!important"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="aratin"></td>
                                    <td style="border-bottom:0px!important"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="aratin"></td>
                                    <td style="border-bottom:0px!important"><input class="circle-size" type="radio" aria-label="Radio button for following text input" name="aratin"></td>
</tr>

</table>



<!-- <table  width="100%">
	<tr>

		<td style="text-align: left;">
    <h4 style="margin-left: 10px;">Name:________________________________________________________________________________________________________________</h4>
  </td> 

	</tr>

	</table> -->

</div>

<style>

	@media print

{    

    button

    {

        display: none !important;
        
    }
    footer {page-break-after: avoid;}


}

	@page {
  
    size: auto;  

    margin: 0; 
}

	 </style>

</div>

</div>

<div style="background-color: #F7F7F7; padding: 5px; border: 1px solid #e5e5e5; margin-bottom:10px; margin:10px; margin-top:0px; margin-bottom:20px;    margin-top: -10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <!--<td colspan="2" align="left"><input type="Submit" name="Submit" value="Save Changes"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" class="a" /></td>-->

    <td width="50%" align="right">
      
    <a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($resultpage['id']); ?>&quotationId=<?php echo
encode($quotationData['id']); ?>&sendfeedbackform=1" >
        <input class="sendbtn" type="button" name="Submit" value="Send"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding-left:5px; padding-right:5px; display: none;"  class="a" />
    </a>
  </td>

  </tr>
</table>

</div>

</form>



<script>

function printDiv(divName) {

     var printContents = document.getElementById(divName).innerHTML;

     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;

}

</script>

</div>

</div>