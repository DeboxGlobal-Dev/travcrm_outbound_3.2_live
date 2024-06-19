<?php include "inc.php";  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
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
          /* height: 100px; */
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
    width: 281px;
    height: 59px;
    padding-left: 2px;
    padding-top: -14px;
    border-bottom-left-radius: 60px;
    color: white;
    position: absolute;
    margin-left: 61%;
    margin-left: 59%!important;
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
input[type="radio"] {
    display: block!important;
}
.pos_rel{
  position: relative;
}
.pos_abs{
  position: absolute;
    top: 16px;
    left: 60px;
}
.feed_sub_cl{
  width: 70%;
  background: #233a49;
    color: #fff;
    padding: 3px 10px;
    display: inline-block;
    line-height: 0px;

}

.container{
    background: #fff;
    width: 915px;
    margin: 20px auto 50px auto;
    padding: 20px 5px;
}
</style>
<body style="background-color: #ccc;">
    <div class="container">
    <?php

// include "config/logincheck.php";  
$overallfeedbackId = decode($_REQUEST['overallfeedbackId']);
$fdREs = GetPageRecord('*','onlineFeedbackMaster','id="'.$overallfeedbackId.'"');
$overallfddata = mysqli_fetch_assoc($fdREs);


$queryId='';

if($_GET['queryId']!=''){

    $queryId = $_GET['queryId'];

}



$select='*';

$where='id="'.$queryId.'"';

$rs=GetPageRecord($select,_QUERY_MASTER_,$where);    
$resultpage=mysqli_fetch_array($rs);

$clientType= $resultpage['clientType'];
$companyId= $resultpage['companyId'];

$select1='*';   
$where1='id=1'; 
$rs1=GetPageRecord($select1,'lettersettings',$where1); 
$editresult=mysqli_fetch_array($rs1);

$rs22=GetPageRecord('*','companySettingsMaster','id=1');
$resultCompany=mysqli_fetch_array($rs22);

$rsinv=GetPageRecord('logo',_INVOICE_SETTING_MASTER_,'id=1');
$resultinvlogo=mysqli_fetch_array($rsinv);

$selectu='*';    

$whereu=' id="'.$resultpage['assignTo'].'"  ';  
$rsu=GetPageRecord($selectu,_USER_MASTER_,$whereu); 

while($resListingu=mysqli_fetch_array($rsu)){ 

  $operationPerson=$resListingu['firstName'].' '.$resListingu['lastName'];
  $phone=$resListingu['phone'];


  $rs122=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$resultpage['id'].'" and status=1 order by id desc');  
  $quotationData=mysqli_fetch_array($rs122);
  $quotationId = $quotationData['id'];

  $rs22=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationData['id'].'"');
  $hotellisting=mysqli_fetch_array($rs22);

}

?>

<div style="margin-bottom:10px;">
<!-- <link href="css/main.css" rel="stylesheet" type="text/css" /> -->

<div style="padding:20px;" class="vlist2">	

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">

<div id="printableArea">
<table width="100%" style="margin-bottom: 30px;">

	<tr>

    <td width="100%" align="center"><img id="online-fff" src="<?php echo $fullurl; ?>dirfiles/<?php echo clean($resultCompany['proposalLogo']); ?>"/></td>

    </tr>

</table>

<div>
  <!-- <h4 style="text-align: center">FEEDBACK FORM</h4> feedback form -->

<div class="row" style="width: 100%;display: flex;">

  <div class="col-6" style="width: 50%;margin-left: 10px;">
  <h4 style="margin-left: 10px;">Dear <?php echo $resultpage['leadPaxName']; ?></h4>
  <h4 style="line-height: 26px;text-align: justify;">
 We hope your holiday was enjoyable. In order to help us improve our services, we would appreciate, if you could spare
 a few minutes of your time to fill up this questionnaire to assess our delivery standards and products.
</h4>
  </div>
  <div class="col-6"  style="width: 36%;margin-left: 10%;">
    <a><img src="images/feedback-form-phones.png" style="width: 100%; height: 200px;"></a>
</div>
  </div>
</div>

<br>
<div class="feed_sub_cl"><h3>FEEDBACK | TOUR ID: <?php echo makeQueryTourId($resultpage['id']); ?> | TOUR DATE: <?php echo date('d-m-Y', strtotime($resultpage['fromDate'])); ?></h3></div>
<h4 style="line-height: 26px;text-align: center;"><b>Please tick as applicable</b></h4>

<table width="100%" class=" " border="0 " cellpadding="5" cellspacing="0" >
  <?php 
 
    $hotelcnt=1;
  $resH = GetPageRecord('*','finalQuote','quotationId="'.$quotationData['id'].'" and manualStatus=3');
  if(mysqli_num_rows($resH)>0){
  ?>
  <tr style="border-bottom:0px!important;">

<td align="left" class="pos_rel"><img class="icons-right" src="images/feedback-form-Hotel.png" alt="icon hotel"><b class="pos_abs">Hotel</b></td>
<td align="left"><b>Destination</b></td>
<td ><b>Excellent</b></td>
<td><b>Very Good</b></td>
<td><b>Good</b></td>
<td><b>Average</b></td>
<td><b>Poor</b></td>


  
</td>

</tr> 
<?php
while($finalQuoteHotel = mysqli_fetch_assoc($resH)){
    $serviceId = $finalQuoteHotel['id'];
    $hotelId = $finalQuoteHotel['hotelId']; 
    $destinationId = $finalQuoteHotel['destinationId'];

    $res3 = GetPageRecord('*','packageBuilderHotelMaster','id="'.$hotelId.'"');
    $hotelData = mysqli_fetch_assoc($res3);

    $resD = GetPageRecord('*','destinationMaster','id="'.$destinationId.'"');
    $destinationData = mysqli_fetch_assoc($resD);

    $rerating = GetPageRecord('*','onlineFeedbackMaster','quotationId="'.$quotationId.'" and serviceType="hotel" and serviceTypeId="'.$hotelData['id'].'" and serviceId="'.$serviceId.'"');
    $reratingData = mysqli_fetch_assoc($rerating);

    ?>

<tr>

<td style="border-bottom:0px!important; " align="left"><h4 style="margin-left: 40px;width: 170px; display: inline-block; padding-right:10px;vertical-align: top;"><?php echo $hotelData['hotelName']; ?></h4>
<input type="hidden" name="hotelId<?php echo $hotelcnt; ?>" id="hotelId<?php echo $hotelcnt; ?>" value="<?php echo $hotelData['id']; ?>">
</td>
<td style="border-bottom:0px!important; " align="left">
  <h4  ><?php echo $destinationData['name']; ?></h4></td>

                <td style="border-bottom:0px!important;"> 
                  <input  class="circle-size " type="radio"  name="hotel<?php echo $hotelcnt; ?>" id="hotel<?php echo $hotelcnt; ?>" onclick="updateFeedback('hotel','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $hotelData['id'];?>','5');" <?php if($reratingData['rating']=='5'){?> checked="checked"  <?php }  ?> >
                </td>

                <td style="border-bottom:0px!important;">
                 
                  <input onclick="updateFeedback('hotel','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $hotelData['id'];?>','4');" style="" class="circle-size " type="radio" aria-label="Radio button for following text input" name="hotel<?php echo $hotelcnt; ?>" id="hotel<?php echo $hotelcnt; ?>" <?php if($reratingData['rating']=='4'){?> checked="checked" <?php } ?>>
                </td>

                <td style="border-bottom:0px!important;">
                
                <input onclick="updateFeedback('hotel','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $hotelData['id'];?>','3');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="hotel<?php echo $hotelcnt; ?>" id="hotel<?php echo $hotelcnt; ?>" <?php if($reratingData['rating']=='3'){?> checked="checked" <?php } ?>>
                </td>

                <td style="border-bottom:0px!important;">
                
                <input onclick="updateFeedback('hotel','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $hotelData['id'];?>','2');" style=" "  class=" circle-size" type="radio" aria-label="Radio button for following text input" name="hotel<?php echo $hotelcnt; ?>" id="hotel<?php echo $hotelcnt; ?>" <?php if($reratingData['rating']=='2'){?> checked="checked" <?php } ?>>
                </td>

                <td style="border-bottom:0px!important;">
               
                <input onclick="updateFeedback('hotel','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $hotelData['id'];?>','1');" style="    "  class=" circle-size" type="radio" aria-label="Radio button for following text input" name="hotel<?php echo $hotelcnt; ?>" id="hotel<?php echo $hotelcnt; ?>" <?php if($reratingData['rating']=='1'){?> checked="checked" <?php } ?> >
                </td>

</tr>
<?php 
$hotelcnt++;
} 
}
?>

<!-- Restaurant services -->

  <?php 
$mealcnt =1;
  $resR = GetPageRecord('*','finalQuoteMealPlan','quotationId="'.$quotationData['id'].'" and manualStatus=3');
  if(mysqli_num_rows($resR)>0){
  ?>
  <tr>
<td colspan="6" class="pos_rel"><img class="icons-right" src="images/feedback-form-restaurant.png" alt="icon hotel">
<b class="pos_abs">Restaurant</b></td>
</tr>
  <?php
  
  while($finalQuoteRest = mysqli_fetch_assoc($resR)){
    $serviceId = $finalQuoteRest['id'];
    // $destinationId = $finalQuoteHotel['destinationId'];
    
  $mealPlanName = $finalQuoteRest['mealPlanName'];
  $destinationId = $finalQuoteRest['destinationId'];

   $restD = GetPageRecord('*','destinationMaster','id="'.$destinationId.'"');
   $destinationDataRest = mysqli_fetch_assoc($restD);

   $reratingm = GetPageRecord('*','onlineFeedbackMaster','quotationId="'.$quotationId.'" and serviceType="meal" and serviceTypeId="'.$finalQuoteRest['id'].'" and serviceId="'.$serviceId.'"');
   $reratingDataM = mysqli_fetch_assoc($reratingm);
?>

<tr>

  <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px;width: 170px; display: inline-block; padding-right:10px;vertical-align: top;"><?php echo $mealPlanName; ?></h4>
  <input type="hidden" name="mealId<?php echo $mealcnt; ?>" id="mealId<?php echo $mealcnt; ?>" value="<?php echo $finalQuoteRest['id']; ?>"></td>
  <td style="border-bottom:0px!important; " align="left">
  <h4 style=""><?php echo $destinationDataRest['name']; ?></h4></td>

                              <td style="border-bottom:0px!important;">

                                <input onclick="updateFeedback('meal','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteRest['id'];?>','5');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="meal<?php echo $mealcnt; ?>" id="meal<?php echo $mealcnt; ?>" <?php if($reratingDataM['rating']=='5'){?> checked="checked" <?php } ?>>
                              </td>
                              <td style="border-bottom:0px!important;">
                               
                                <input onclick="updateFeedback('meal','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteRest['id'];?>','4');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="meal<?php echo $mealcnt; ?>" id="meal<?php echo $mealcnt; ?>" <?php if($reratingDataM['rating']=='4'){?> checked="checked" <?php } ?>>
                              </td>

                              <td style="border-bottom:0px!important;">
                               
                                <input onclick="updateFeedback('meal','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteRest['id'];?>','3');" style=" " class=" circle-size" type="radio" aria-label="Radio button for following text input" name="meal<?php echo $mealcnt; ?>" id="meal<?php echo $mealcnt; ?>" <?php if($reratingDataM['rating']=='3'){?> checked="checked" <?php } ?> > </td>
                              <td style="border-bottom:0px!important;" >
                                
                                <input onclick="updateFeedback('meal','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteRest['id'];?>','2');" style="  " class=" circle-size" type="radio" aria-label="Radio button for following text input" name="meal<?php echo $mealcnt; ?>" id="meal<?php echo $mealcnt; ?>" <?php if($reratingDataM['rating']=='2'){?> checked="checked" <?php } ?>>
                              </td>
                              <td style="border-bottom:0px!important;">
                               
                                <input onclick="updateFeedback('meal','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteRest['id'];?>','1');" style="   " class=" circle-size" type="radio" aria-label="Radio button for following text input" name="meal<?php echo $mealcnt; ?>" id="meal<?php echo $mealcnt; ?>" <?php if($reratingDataM['rating']=='1'){?> checked="checked" <?php } ?> >
                              </td>

</tr>
<?php 
$mealcnt++;
} 
}
?>
 <!-- Trasport or trasfer -->
<?php
  $transfercnt=1;
  $resTPT = GetPageRecord('*','finalQuotetransfer','quotationId="'.$quotationData['id'].'" and manualStatus=3');
  if(mysqli_num_rows($resTPT)>0){
  ?>
   <tr>

<td colspan="6" class="pos_rel"><img class="icons-right" src="images/feedback-form-transport.png" alt="icon hotel"><b class="pos_abs">Transport</b></td>
</tr>
  <?php
    while( $finalQuoteTPT = mysqli_fetch_assoc($resTPT)){

      $serviceId = $finalQuoteTPT['id'];
   
    // $destinationId = $finalQuoteHotel['destinationId'];

    $transferId = $finalQuoteTPT['transferId'];
    $destinationId = $finalQuoteTPT['destinationId'];

    $resTPT3 = GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferId.'"');
   $transferData = mysqli_fetch_assoc($resTPT3);

   $resTPTD = GetPageRecord('*','destinationMaster','id="'.$destinationId.'"');
   $TPTdestinationData = mysqli_fetch_assoc($resTPTD);
  
   $reratingm = GetPageRecord('*','onlineFeedbackMaster','quotationId="'.$quotationId.'" and serviceType="transfer" and serviceTypeId="'.$finalQuoteTPT['tranferId'].'" and serviceId="'.$serviceId.'"');
   $reratingDataM = mysqli_fetch_assoc($reratingm);

?>

  <tr class="">

    <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px; width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $transferData['transferName']; ?> </h4>
    <input type="hidden" name="transferId<?php echo $transfercnt; ?>" id="transferId<?php echo $transfercnt; ?>" value="<?php echo $finalQuoteTPT['tranferId']; ?>">
  </td>
    <td style="border-bottom:0px!important;">
    <h4 style=""><?php echo $TPTdestinationData['name']; ?></h4></td>

                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('transfer','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteTPT['tranferId']; ?>','5');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="transfer<?php echo $transfercnt; ?>" id="transfer<?php echo $transfercnt; ?>" <?php if($reratingDataM['rating']=='5'){?> checked="checked" <?php } ?>>
                                    </td>

                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('transfer','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteTPT['tranferId']; ?>','4');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="transfer<?php echo $transfercnt; ?>" id="transfer<?php echo $transfercnt; ?>" <?php if($reratingDataM['rating']=='4'){?> checked="checked" <?php } ?>>
                                    </td>

                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('transfer','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteTPT['tranferId']; ?>','3');"  style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" 
                                    name="transfer<?php echo $transfercnt; ?>" id="transfer<?php echo $transfercnt; ?>" <?php if($reratingDataM['rating']=='3'){?> checked="checked" <?php } ?> ></td>
                                    <td style="">
                                      <input onclick="updateFeedback('transfer','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteTPT['tranferId']; ?>','2');"  style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="transfer<?php echo $transfercnt; ?>" id="transfer<?php echo $transfercnt; ?>" <?php if($reratingDataM['rating']=='2'){?> checked="checked" <?php } ?> ></td>
                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('transfer','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $finalQuoteTPT['tranferId']; ?>','1');"  style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="transfer<?php echo $transfercnt; ?>" id="transfer<?php echo $transfercnt; ?>" <?php if($reratingDataM['rating']=='1'){?> checked="checked" <?php } ?> ></td>
  </tr>
  <?php
  $transfercnt++; 
}
}

?>
<!-- Guide services -->

<?php
$guidecnt=1;
    $resguide = GetPageRecord('*','finalQuoteGuides','quotationId="'.$quotationData['id'].'" and manualStatus=3');
    if(mysqli_num_rows($resguide)>0){
    ?>
    <tr>
    <td colspan="6" class="pos_rel"><img class="icons-right" src="images/feedback-form-transport.png"><b class="pos_abs">Guide</b></td>

    </tr>
    <?php 
    while( $finalQuoteGuide = mysqli_fetch_assoc($resguide)){

      $serviceId = $finalQuoteGuide['id'];
      // $destinationId = $finalQuoteHotel['destinationId'];


    $guideId = $finalQuoteGuide['guideId'];
    $destinationId = $finalQuoteGuide['destinationId'];

    $resG = GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$guideId.'"');
   $GuideData = mysqli_fetch_assoc($resG);

   $resGuide = GetPageRecord('*','destinationMaster','id="'.$destinationId.'"');
   $guidedestinationData = mysqli_fetch_assoc($resGuide);

   $reratingm = GetPageRecord('*','onlineFeedbackMaster','quotationId="'.$quotationId.'" and serviceType="guide" and serviceTypeId="'.$guideId.'" and serviceId="'.$serviceId.'"');
   $reratingDataM = mysqli_fetch_assoc($reratingm);
  //  echo $transferData['transferName'];
?>

  <tr class="">

    <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px; width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $GuideData['name']; ?> </h4>
    <input type="hidden" name="guideId<?php echo $guidecnt; ?>" id="guideId<?php echo $guidecnt; ?>" value="<?php echo $finalQuoteGuide['id']; ?>"></td>
    <td style="border-bottom:0px!important;">
    <h4 style=""><?php echo $guidedestinationData['name']; ?></h4></td>

                                  <td style="border-bottom:0px!important;">
                                <input onclick="updateFeedback('guide','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $guideId; ?>','5');" style="" class=" circle-size"  type="radio" aria-label="Radio button for following text input" name="guide<?php echo $guidecnt; ?>" id="guide<?php echo $guidecnt; ?>" <?php if($reratingDataM['rating']=='5'){?> checked="checked" <?php } ?> >
                                </td>
                                    <td  style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('guide','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $guideId; ?>','4');" style="" class="circle-size" type="radio" aria-label="Radio button for following text input" name="guide<?php echo $guidecnt; ?>" id="guide<?php echo $guidecnt; ?>" <?php if($reratingDataM['rating']=='4'){?> checked="checked" <?php } ?> >
                                  </td>
                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('guide','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $guideId; ?>','3');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="guide<?php echo $guidecnt; ?>" id="guide<?php echo $guidecnt; ?>" <?php if($reratingDataM['rating']=='3'){?> checked="checked" <?php } ?> >
                                  </td>
                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('guide','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $guideId; ?>','2');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="guide<?php echo $guidecnt; ?>" id="guide<?php echo $guidecnt; ?>" <?php if($reratingDataM['rating']=='2'){?> checked="checked" <?php } ?> >
                                  </td>
                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('guide','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $guideId; ?>','1');" style="    "  class="circle-size" type="radio" aria-label="Radio button for following text input" name="guide<?php echo $guidecnt; ?>" id="guide<?php echo $guidecnt; ?>" <?php if($reratingDataM['rating']=='1'){?> checked="checked" <?php } ?> >
                                  </td>
  </tr>
  <?php 
  $guidecnt++;
}
    }

?>
<!-- Tour Manager services -->

<?php
$tourcnt=1;
    $resT = GetPageRecord('tourManager','queryMaster','id="'.$resultpage['id'].'" and tourManager>0 ');
    if(mysqli_num_rows($resT)>0){
    ?>
    <tr>
    <td colspan="6" class="pos_rel"> <img class="icons-right" src="images/feedback-form-transport.png" alt="icon hotel"><b class="pos_abs">Tour Manager</h4></td>

    </tr>
    <?php
    while( $queryData = mysqli_fetch_assoc($resT)){
      $serviceId = $queryData['id'];
    
      // $destinationId = $finalQuoteHotel['destinationId'];

    $tourManagerId = $queryData['tourManager'];

    $destinationId = $queryData['destinationId'];

    $resTM = GetPageRecord('*',_GUIDE_MASTER_,'id="'.$tourManagerId.'"');
   $tourMData = mysqli_fetch_assoc($resTM);

   $rest2 = GetPageRecord('*','destinationMaster','id="'.$destinationId.'"');
   $tourdestinationData = mysqli_fetch_assoc($rest2);
   
   $reratingm = GetPageRecord('*','onlineFeedbackMaster','quotationId="'.$quotationId.'" and serviceType="tour" and serviceTypeId="'.$tourManagerId.'" and serviceId="'.$serviceId.'"');
   $reratingDataM = mysqli_fetch_assoc($reratingm);
?>

  <tr>

    <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px; width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $tourMData['name']; ?> </h4>
    <input type="hidden" name="tourId<?php echo $tourcnt; ?>" id="tourId<?php echo $tourcnt; ?>" value="<?php echo $queryData['id']; ?>"></td>
    <td style="border-bottom:0px!important;">
    <h4 style="width: 80px; display: inline-block; vertical-align: top; margin-left: 108%;
    margin-top: -39px;"><?php echo $tourdestinationData['name']; ?></h4></td>

                                <td style="border-bottom:0px!important;">
                                  <input onclick="updateFeedback('tour','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $tourManagerId; ?>','5');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="tour<?php echo $tourcnt; ?>" id="tour<?php echo $tourcnt; ?>" <?php if($reratingDataM['rating']=='5'){?> checked="checked" <?php } ?> >
                                </td>
                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('tour','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $tourManagerId; ?>','4');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="tour<?php echo $tourcnt; ?>" id="tour<?php echo $tourcnt; ?>" <?php if($reratingDataM['rating']=='4'){?> checked="checked" <?php } ?> >
                                  </td>
                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('tour','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $tourManagerId; ?>','3');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="tour<?php echo $tourcnt; ?>" id="tour<?php echo $tourcnt; ?>" <?php if($reratingDataM['rating']=='3'){?> checked="checked" <?php } ?> >
                                  </td>
                                  <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('tour','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $tourManagerId; ?>','2');"  style=""class=" circle-size" type="radio" aria-label="Radio button for following text input" name="tour<?php echo $tourcnt; ?>" id="tour<?php echo $tourcnt; ?>" <?php if($reratingDataM['rating']=='2'){?> checked="checked" <?php } ?> >
                                  </td>
                                    <td style="border-bottom:0px!important;">
                                    <input onclick="updateFeedback('tour','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $tourManagerId; ?>','1');" style=" " class=" circle-size" type="radio" aria-label="Radio button for following text input" name="tour<?php echo $tourcnt; ?>" id="tour<?php echo $tourcnt; ?>" <?php if($reratingDataM['rating']=='1'){?> checked="checked" <?php } ?> >
                                  </td>
  </tr>
  <?php 
  $tourcnt++;
}

    }
?>

<?php
$drivercnt=1;
    $resDriver = GetPageRecord('*','driverAllocationDetails','queryId="'.$resultpage['id'].'" and quotationId="'.$quotationData['id'].'"');
    if(mysqli_num_rows($resDriver)>0){
    ?>
    <tr>
    <td colspan="6" class="pos_rel"><img class="icons-right" src="images/feedback-form-transport.png"><b class="pos_abs">
    Driver</b></td>

    </tr>
    <?php
    while( $driverData = mysqli_fetch_assoc($resDriver)){

      $serviceId = $driverData['id'];
      // $hotelId = $driverData['hotelId']; 
      // $destinationId = $finalQuoteHotel['destinationId'];


    $driverId = $driverData['driverId'];

    $destinationId = $driverData['destinationId'];

    $resDr = GetPageRecord('*',_DRIVER_MASTER_MASTER_,'id="'.$driverId.'"');
   $driverData = mysqli_fetch_assoc($resDr);

   $rest2 = GetPageRecord('*','destinationMaster','id="'.$destinationId.'"');
   $tourdestinationData = mysqli_fetch_assoc($rest2);

   $reratingm = GetPageRecord('*','onlineFeedbackMaster','quotationId="'.$quotationId.'" and serviceType="driver" and serviceTypeId="'.$driverId.'" ');
   $reratingDataM = mysqli_fetch_assoc($reratingm);
?>

  <tr>

    <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px;width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $driverData['name']; ?> </h4>
    <input type="hidden" name="driverId<?php echo $drivercnt; ?>" id="driverId<?php echo $drivercnt; ?>" value="<?php echo $driverData['id']; ?>"></td>
    <td style="border-bottom:0px!important;">
    
    <h4 style="width: 80px; display: inline-block; vertical-align: top; margin-left: 108%;
    margin-top: -39px;"><?php echo $tourdestinationData['name']; ?></h4></td>

                                  <td>
                                  <input onclick="updateFeedback('driver','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $driverId; ?>','5');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="driver<?php echo $drivercnt; ?>" id="driver<?php echo $drivercnt; ?>" <?php if($reratingDataM['rating']=='5'){?> checked="checked" <?php } ?>>
                                </td>
                                    <td><input onclick="updateFeedback('driver','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $driverId; ?>','4');" style=" " class=" circle-size" type="radio" aria-label="Radio button for following text input" name="driver<?php echo $drivercnt; ?>" id="driver<?php echo $drivercnt; ?>" <?php if($reratingDataM['rating']=='4'){?> checked="checked" <?php } ?>>
                                  </td>
                                    <td><input onclick="updateFeedback('driver','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $driverId; ?>','3');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="driver<?php echo $drivercnt; ?>" id="driver<?php echo $drivercnt; ?>" <?php if($reratingDataM['rating']=='3'){?> checked="checked" <?php } ?>>
                                  </td>
                                    <td>
                                      <input onclick="updateFeedback('driver','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $driverId; ?>','2');" style="" class=" circle-size" type="radio" aria-label="Radio button for following text input" name="driver<?php echo $drivercnt; ?>" id="driver<?php echo $drivercnt; ?>" <?php if($reratingDataM['rating']=='2'){?> checked="checked" <?php } ?>>
                                    </td>
                                    <td>
                                      <input onclick="updateFeedback('driver','<?php echo $serviceId;?>','<?php echo $destinationId;?>','<?php echo $driverId; ?>','1');" style="   " class="circle-size" type="radio" aria-label="Radio button for following text input" name="driver<?php echo $drivercnt; ?>" id="driver<?php echo $drivercnt; ?>" <?php if($reratingDataM['rating']=='1'){?> checked="checked" <?php } ?>></td>
  </tr>
  <?php 
  $drivercnt++;
}
    }

?>
<tr>
<td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;">

</h4>
  
</td>

</tr>
<tr>

<td style="border-bottom:0px!important; width: 258px;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><strong style="margin-left: 44px;">

<!-- <img class="icons-right" src="images/feedback-form-transport.png" alt="icon hotel"> -->
Overall Rating</strong></h4></td>



<td class="" style="border-bottom:0px!important">
                                    </td>


                              <td class="" style="border-bottom:0px!important">
                              <input style="" class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="overallRating" id="overallRating" value="5" <?php if($overallfddata['rating']=='5'){ ?> checked="checked" <?php } ?> ></td>
                              <td style="border-bottom:0px!important">
                              <input style="" class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="overallRating" id="overallRating" value="4" <?php if($overallfddata['rating']=='4'){ ?> checked="checked" <?php } ?> ></td>
                              <td style="border-bottom:0px!important">
                              <input style="" class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="overallRating" id="overallRating" value="3" <?php if($overallfddata['rating']=='3'){ ?> checked="checked" <?php } ?> ></td>
                              <td style="border-bottom:0px!important">
                              <input  style="" class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="overallRating" id="overallRating" value="2" <?php if($overallfddata['rating']=='2'){ ?> checked="checked" <?php } ?>></td>
                              <td style="border-bottom:0px!important">
                              <input style=""class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="overallRating" id="overallRating" value="1" <?php if($overallfddata['rating']=='1'){ ?> checked="checked" <?php } ?> ></td>
</tr>

</table>

<br>

<h4 style="line-height: 30px;">

<h4 style="line-height: 26px;     margin-left: 35px;">
<!-- <li> -->
  <input style="position: absolute;
    margin-left: -19px;
    margin-top: 5px;" type="radio" aria-label="Radio button for following text input" name="Would1" checked>Would you use <?php echo $resultCompany['companyName']; ?> again for your future travel plan?
    <span style="float: right;display: inline-flex;"> Yes <input style=""class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="isfuturerecommend" value="1" <?php if($overallfddata['isfuturerecommend']=='1'){ ?> checked <?php } ?> >&nbsp;No<input style=""class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="isfuturerecommend" value="0" <?php if($overallfddata['isfuturerecommend']=='0'){ ?> checked <?php } ?> ></span>
<!-- </li> -->
</h4>

<h4 style="line-height: 26px;margin-left: 35px;">
<!-- <li> -->
<input style="position: absolute;
    margin-left: -19px;
    margin-top: 5px;" type="radio" aria-label="Radio button for following text input" name="Would" checked >Would you recommend <?php echo $resultCompany['companyName']; ?> to relatives and acquaintances?<span style="float: right;display: inline-flex;"> Yes<input style=""class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="isfamily" value="1" <?php if($overallfddata['isfamily']=='1'){ ?> checked <?php } ?> >&nbsp;No<input style=""class="allcheck circle-size" type="radio" aria-label="Radio button for following text input" name="isfamily" value="0" <?php if($overallfddata['isfamily']=='0'){ ?> checked <?php } ?> ></span>
<!-- </li> -->
</h4>



<h4 style="line-height: 26px;    margin-left: 16px;">

	COMMENTS / SUGGESTIONS<br>
  <div style=" height: 70px; margin-right: 10px;margin-left: 10px;">
  <div class="form-group">
  <textarea name="feedbackcomment" class="allcheck form-control" id="feedbackcomment" rows="4"  style="width: 100%;height: 65px;" placeholder=""><?php echo $overallfddata['comment'];?></textarea>
  </div>

  </div>

</h4>

<br>

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

<div style="background-color: #F7F7F7; padding: 6px; border: 1px solid #e5e5e5; margin:17px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>
  <input type="hidden" name="action" id="action" value="addeditfeedbackformfromclient">
 
  </tr>


  
  <tr>

    <td><input style="float: right;" name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Submit" onclick="updateallrating();" /></td>

<td style="padding-right:20px; display:none"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="masters_alertspopupopenClose();" /></td>

</tr>

</tr>
</table>

</div>

</form>
<script src="js/jquery-3.5.0.min.js"></script> 
<div id="updatefeedback" style="display:none;"></div>

<script src="js/jquery-1.11.3.min.js?id=1658824772" type="text/javascript"></script>
<script type="text/javascript">

function updateFeedback(serviceType,serviceId,destId,serviceTypeId,ratingId){
  // alert(ratingId);
  $('#updatefeedback').load('final_frmaction.php?action=updateFeedBackRating&serviceType='+serviceType+'&serviceId='+serviceId+'&destinationId='+destId+'&ratingId='+ratingId+'&serviceTypeId='+serviceTypeId+'&queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>&clientType=<?php echo $clientType; ?>&companyId=<?php echo $companyId; ?>');
}
 
function updateallrating(){ 
  
  var isfuturerecommend = $('input[name="isfuturerecommend"]:checked').val(); 
  var isfamily = $('input[name="isfamily"]:checked').val();
  var rating = $('input[name="overallRating"]:checked').val();
  var comment = $('#feedbackcomment').val();

  $('#updatefeedback').load('final_frmaction.php?action=updateFeedBackAllRating&isfuturerecommend='+isfuturerecommend+'&isfamily='+isfamily+'&clientratings='+rating+'&comment='+encodeURI(comment)+'&queryId=<?php echo $queryId; ?>&quotationId=<?php echo $quotationId; ?>&clientType=<?php echo $clientType; ?>&companyId=<?php echo $companyId; ?>&fromDate=<?php echo $resultpage['fromDate'] ?>');
 
}
</script>

</div>

</body>
</html>