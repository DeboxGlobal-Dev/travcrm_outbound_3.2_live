<?php


include "inc.php";  

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
<html>
<body>

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
    padding: 10px;
    margin-bottom: 25px;
}
.radioBox{
    width: 18px;
    height: 18px;
    border: 1px solid grey;
    border-radius: 50px;
    margin: auto;
}
.radioBox2{
  width: 18px;
    height: 18px;
    border: 1px solid grey;
    border-radius: 50px;
    margin: auto;
}
</style>
<!-- <link href="css/main.css" rel="stylesheet" type="text/css" /> -->

<div style="padding:20px;" class="vlist2">	

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">

<div id="printableArea">

<?php if($_REQUEST['plainfeedbackfrom']=='1'){ }else{ ?>
<table width="100%" style="margin-bottom: 30px;">

	<tr>

    <td width="100%" align="center"><img id="online-fff" src="<?php echo $fullurl; ?>dirfiles/<?php echo clean($resultCompany['proposalLogo']); ?>"/></td>

    </tr>

</table>
<?php } ?>
<div>
  <!-- <h4 style="text-align: center">FEEDBACK FORM</h4> feedback form -->
<div class="row" style="width: 100%;display: flex;">
  <div class="col-6" style="width: 50%;margin-left: 10px;">
  <h4 style="margin-left: 2px;">Dear <?php echo $resultpage['leadPaxName']; ?></h4>
  <br>
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
<tr style="border-bottom:0px!important;">

<td align="left" class="pos_rel"><img class="icons-right" src="images/feedback-form-Hotel.png" alt="icon hotel"><b class="pos_abs">Hotel</b></td>
<td align="left"><b>Destination</b></td>
<td align="center"><b>Excellent</b></td>
<td align="center"><b>Very Good</b></td>
<td align="center"><b>Good</b></td>
<td align="center"><b>Average</b></td>
<td align="center"><b>Poor</b></td>
</td>

</tr> 
  <?php 
 
    $hotelcnt=1;
  $resH = GetPageRecord('*','finalQuote','quotationId="'.$quotationData['id'].'" and manualStatus=3');
  if(mysqli_num_rows($resH)>0){
  ?>

<?php
while($finalQuoteHotel = mysqli_fetch_assoc($resH)){
    $serviceId = $finalQuoteHotel['id'];
    $hotelId = $finalQuoteHotel['hotelId']; 
    $destinationId = $finalQuoteHotel['destinationId'];

    $res3 = GetPageRecord('*','packageBuilderHotelMaster','id="'.$hotelId.'"');
    $hotelData = mysqli_fetch_assoc($res3);

    $resD = GetPageRecord('*','destinationMaster','id="'.$destinationId.'"');
    $destinationData = mysqli_fetch_assoc($resD);

    ?>

<tr>

<td style="border-bottom:0px!important; " align="left"><h4 style="margin-left: 40px;width: 170px; display: inline-block; padding-right:10px;vertical-align: top;"><?php echo $hotelData['hotelName']; ?></h4>
<input type="hidden" name="hotelId<?php echo $hotelcnt; ?>" id="hotelId<?php echo $hotelcnt; ?>" value="<?php echo $hotelData['id']; ?>">
</td>
<td style="border-bottom:0px!important; " align="left">
  <h4  ><?php echo $destinationData['name']; ?></h4></td>

                <td style="border-bottom:0px!important;"> 
                <div class="radioBox"></div>
                </td>

                <td style="border-bottom:0px!important;">
                <div class="radioBox"></div>
                </td>

                <td style="border-bottom:0px!important;">
                <div class="radioBox"></div>
                </td>

                <td style="border-bottom:0px!important;">
                <div class="radioBox"></div>
                </td>

                <td style="border-bottom:0px!important;">
                <div class="radioBox"></div>
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

?>

<tr>

  <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px;width: 170px; display: inline-block; padding-right:10px;vertical-align: top;"><?php echo $mealPlanName; ?></h4>
  <input type="hidden" name="mealId<?php echo $mealcnt; ?>" id="mealId<?php echo $mealcnt; ?>" value="<?php echo $finalQuoteRest['id']; ?>"></td>
  <td style="border-bottom:0px!important; " align="left">
  <h4 style=""><?php echo $destinationDataRest['name']; ?></h4></td>

                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>

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

?>

  <tr class="">

    <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px; width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $transferData['transferName']; ?> </h4>
    <input type="hidden" name="transferId<?php echo $transfercnt; ?>" id="transferId<?php echo $transfercnt; ?>" value="<?php echo $finalQuoteTPT['tranferId']; ?>">
  </td>
    <td style="border-bottom:0px!important;">
    <h4 style=""><?php echo $TPTdestinationData['name']; ?></h4></td>

                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
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

?>

  <tr class="">

    <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px; width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $GuideData['name']; ?> </h4>
    <input type="hidden" name="guideId<?php echo $guidecnt; ?>" id="guideId<?php echo $guidecnt; ?>" value="<?php echo $finalQuoteGuide['id']; ?>"></td>
    <td style="border-bottom:0px!important;">
    <h4 style=""><?php echo $guidedestinationData['name']; ?></h4></td>

                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
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
 
?>

  <tr>

    <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px; width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $tourMData['name']; ?> </h4>
    <input type="hidden" name="tourId<?php echo $tourcnt; ?>" id="tourId<?php echo $tourcnt; ?>" value="<?php echo $queryData['id']; ?>"></td>
    <td style="border-bottom:0px!important;">
    <h4 style="width: 80px; display: inline-block; vertical-align: top; margin-left: 108%;
    margin-top: -39px;"><?php echo $tourdestinationData['name']; ?></h4></td>

                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
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
?>

  <tr>

    <td style="border-bottom:0px!important;"><h4 style="margin-left: 40px;width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $driverData['name']; ?> </h4>
    <input type="hidden" name="driverId<?php echo $drivercnt; ?>" id="driverId<?php echo $drivercnt; ?>" value="<?php echo $driverData['id']; ?>"></td>
    <td style="border-bottom:5px!important;">
    <h4 style="width: 80px; display: inline-block; vertical-align: top; margin-left: 108%;
    margin-top: -39px;"><?php echo $tourdestinationData['name']; ?></h4></td>

                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
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

<td style="border-bottom:0px!important; width: 258px;">
<h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><strong style="margin-left: 44px;">
Overall Rating</strong></h4></td>

                              <td class="" style="border-bottom:0px!important"></td>

                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
                              <td style="border-bottom:0px!important;"><div class="radioBox"></div></td>
</tr>

</table>

<br>

<h4 style="line-height: 30px;">

<h4 style="line-height: 26px;display: inline-block;margin-left: 35px;width: 76%;" class="printwi">
    Would you use <?php echo $resultCompany['companyName']; ?> again for your future travel plan?</h4>
    <span style="padding-right: 14px; line-height: 3;"> Yes </span><div class="radioBox2" style="display: inline-block; margin-right: 25px;"></div> &nbsp; <span style="display: inline-block;padding-right: 14px;">No</span><div class="radioBox2" style=" display: inline-block;"></div>


<h4 style="line-height: 26px;display: inline-block;margin-left: 35px;width: 76%;margin-right: 2px;" class="printwi">
  Would you recommend <?php echo $resultCompany['companyName']; ?> to relatives and acquaintances?</h4><span style="padding-right: 14px;"> Yes </span><div class="radioBox2" style="display: inline-block;margin-right: 25px;"></div> &nbsp; <span style="display: inline-block;padding-right: 14px;">No</span><div class="radioBox2" style=" display: inline-block;"></div>

<h4 style="line-height: 26px;margin-left: 35px; margin-top:20px;">
	COMMENTS / SUGGESTIONS<br></h4>
  <div class="form-group" style="padding: 10px 18px !important; margin-left: 16px;">
  <textarea name="feedbackcomment" class="allcheck form-control" id="feedbackcomment" rows="4"  style="width: 99%;height: 65px;" placeholder=""><?php echo $overallfddata['comment'];?></textarea>
  </div>
<br>

<style>

	@media print{    

    button{
        display: none !important;
        }
    footer { page-break-after: avoid; }
    .radioBox{
    width: 18px !important;
    height: 18px !important;
    border: 1px solid grey !important;
    border-radius: 50px !important;
    margin-left: 20px !important;
    margin-bottom: 10px !important;
    display: inline-block !important;
}

.radioBox2{
    width: 18px !important;
    height: 18px !important;
    border: 1px solid grey !important;
    border-radius: 50px !important;
    display: inline-block !important;
}
.printwi{
  width: 74% !important;
}
.pos_rel{
  position: relative !important;
}
.pos_abs{
  position: absolute !important;
    top: 30px !important;
    left: 90px !important;
}
.feed_sub_cl{
    margin-bottom: 25px !important;
}

}

	@page {
  
    size: "A4";  
    margin: 10; 
    margin-bottom: 30px;
} 

	 </style>
</div>

</div>

<div style="background-color: #F7F7F7; padding: 6px; border: 1px solid #e5e5e5; margin:17px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>
  <input type="hidden" name="action" id="action" value="addeditfeedbackformfromclient">
 
  </tr>


  
  <tr>
    <td><input style="float: right;" name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Print" onclick="printFeedback('printableArea');" /></td>

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

    function printFeedback(divName) { 
      $(".radioBox").show();
	    var printContents = document.getElementById(divName).innerHTML;
	    var originalContents = document.body.innerHTML;
	    document.body.innerHTML = printContents;
	    window.print();
	    document.body.innerHTML = originalContents;
	    // parent.location.reload();
	    return false;
	}

</script>

</div>

</div>

</body> 
</html>