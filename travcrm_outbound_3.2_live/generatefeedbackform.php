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


$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$resultpage['id'].'" order by id desc');  

$quotationData=mysqli_fetch_array($rs1);
// echo $quotationData['id'];

$rs22=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationData['id'].'"');

$hotellisting=mysqli_fetch_array($rs22);

}

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<div style="margin-bottom:10px;">

<style>

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



</style>

<div style="padding:10px;" class="vlist2">	

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">

<div id="printableArea<?php echo strip($resultpage['id']); ?>">

<div style="padding:10px; background-color:#FFFFFF; border:2px dashed #ccc;   position:relative; margin:10px;" >

<table width="100%">

	<tr>

    <!-- <td width="100%" align="center"><img src="<?php //echo $fullurl; ?>dirfiles/<?php //echo clean($resultCompany['proposalLogo']); ?>" style="max-height: 130px; max-width: 500px;" /></td> -->

    </tr>

</table>

<div>
  <!-- <h4 style="text-align: center">FEEDBACK FORM </h4> feedback form-->

<table width="100%">

  <tr>

    <td style="width:50%;">

    <h4>Dear <?php echo $resultpage['leadPaxName']; ?></h4>

    </td>

    <td style="width: 50%; text-align: right;">

      <h4>Tour Ref No. : <?php echo $resultpage['referanceNumber'];?></h4>

    </td>

  </tr>

</table>

<br>

<h4 style="line-height: 26px;text-align: justify;">
 We hope your holiday was enjoyable. In order to help us improve our services, we would appreciate, if you could spare <br>
 a few minutes of your time to fill up this questionnaire to assess our delivery standards and products.
 
</h4>

<br>

<h4 style="line-height: 26px;text-align: center;"><b>Please tick as applicable</b>

</h4>

<table width="100%" class="tabd">
  <?php 
  //  $resfinaleq = GetPageRecord('*','finalquotationItinerary','quotationId="'.$quotationData['id'].'" and queryId="'.$resultpage['id'].'"');
  //   while($finalQuoteres = mysqli_fetch_array($resfinaleq)){

  $resH = GetPageRecord('*','finalQuote','quotationId="'.$quotationData['id'].'" and manualStatus=3');
  if(mysqli_num_rows($resH)>0){
  ?>
  <tr>

  <td colspan="6" ><h4 style=" width: 170px; display: inline-block; padding-right:10px; "><b>Hotel</b></h4><h4 style="width: 80px; display: inline-block;"><b>Destination</b></h4></td>


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

  <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block; padding-right:10px;vertical-align: top;"><?php echo $hotelData['hotelName']; ?></h4><h4 style="width: 80px; display: inline-block; vertical-align: top;"><?php echo $destinationData['name']; ?></h4></td>

  <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Excellent</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp;Very Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Average</h4></td>
    <td  style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Poor</h4></td>

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
<td colspan="6" ><h4 style=" width: 170px; display: inline-block; padding-right:10px; "><b>Restaurant</b></h4><h4 style="width: 80px; display: inline-block;"><b>Destination</b></h4></td>
</tr>
  <?php
  while($finalQuoteRest = mysqli_fetch_assoc($resR)){
  $mealPlanName = $finalQuoteRest['mealPlanName'];
  $ResdestinationId = $finalQuoteRest['destinationId'];

   $restD = GetPageRecord('*','destinationMaster','id="'.$ResdestinationId.'"');
   $destinationDataRest = mysqli_fetch_assoc($restD);
?>

<tr>

  <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block; padding-right:10px;vertical-align: top;"><?php echo $mealPlanName; ?></h4><h4 style="width: 80px; display: inline-block; vertical-align: top;"><?php echo $destinationDataRest['name']; ?></h4></td>

  <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Excellent</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp;Very Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Average</h4></td>
    <td  style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Poor</h4></td>

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

<td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b>Transport</h4><h4 style="width: 80px; display: inline-block;"><b>Destination</h4></td>

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

    <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $transferData['transferName']; ?> </h4><h4 style="width: 80px; display: inline-block; vertical-align: top;"><?php echo $TPTdestinationData['name']; ?></h4></td>

    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Excellent</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp;Very Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Average</h4></td>
    <td  style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Poor</h4></td>
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
    <td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b>Guide</h4><h4 style="width: 80px; display: inline-block;"><b>Destination</h4></td>

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

    <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $GuideData['name']; ?> </h4><h4 style="width: 80px; display: inline-block; vertical-align: top;"><?php echo $guidedestinationData['name']; ?></h4></td>

    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Excellent</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp;Very Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Average</h4></td>
    <td  style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Poor</h4></td>
  </tr>
  <?php 
}
    }

?>
<!-- Tour Manager services -->

<?php
    $resT = GetPageRecord('tourManager','queryMaster','id="'.$resultpage['id'].'" and tourManager>0');
    if(mysqli_num_rows($resT)>0){
    ?>
    <tr>
    <td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b>Tour Manager</h4><h4 style="width: 80px; display: inline-block;"><b>Destination</h4></td>

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

    <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $tourMData['name']; ?> </h4><h4 style="width: 80px; display: inline-block; vertical-align: top;"><?php echo $tourdestinationData['name']; ?></h4></td>

    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Excellent</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp;Very Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Average</h4></td>
    <td  style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Poor</h4></td>
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
    <td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b>Driver</h4><h4 style="width: 80px; display: inline-block;"><b>Destination</h4></td>

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

    <td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><?php echo $driverData['name']; ?> </h4><h4 style="width: 80px; display: inline-block; vertical-align: top;"><?php echo $tourdestinationData['name']; ?></h4></td>

    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Excellent</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp;Very Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Good</h4></td>
    <td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Average</h4></td>
    <td  style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Poor</h4></td>
  </tr>
  <?php 
}
    }

?>
<tr>
<td colspan="6"><h4 style="width: 170px; display: inline-block;padding-right:10px;"><b></h4></td>

</tr>
<tr>

<td style="border-bottom:0px!important;"><h4 style="width: 170px; display: inline-block;padding-right:10px; vertical-align: top;"><strong>Overall Rating</strong></h4></td>

<td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Excellent</h4></td>
<td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp;Very Good</h4></td>
<td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Good</h4></td>
<td style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Average</h4></td>
<td  style="border-bottom:0px!important;"><h4 style="display:flex;"><div style="border:1px solid black;height:15px;width:15px;"></div>&nbsp;&nbsp; Poor</h4></td>
</tr>

</table>

<br>

<h4 style="line-height: 30px;">

<h4 style="line-height: 26px;"><li>Would you use <?php echo $resultCompany['companyName']; ?> again for your future travel plan?<span style="float: right;"> Yes&nbsp;/No&nbsp;&nbsp;&nbsp;</span></li></h4>

<h4 style="line-height: 26px;"><li>Would you recommend <?php echo $resultCompany['companyName']; ?> to relatives and acquaintances?<span style="float: right;"> Yes&nbsp;/No&nbsp;&nbsp;&nbsp;</span></li></h4>



<h4 style="line-height: 26px;">

	COMMENTS / SUGGESTIONS<br>
  <div style="border: 1px solid grey; height: 70px;"></div>

</h4>

<br>

<table  width="100%">



	<tr>

		<td style="text-align: left;"><h4>Signature:____________________________________________________________________________________________________________</h4></td>

	</tr>
<tr><td> </td></tr>
	<tr>

		<td style="text-align: left;"><h4>Name:________________________________________________________________________________________________________________</h4></td> 

	</tr>

	</table>

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

    <td width="50%" align="right"><input type="button" name="Submit" value="Print"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="printDiv('printableArea<?php echo strip($resultpage['id']); ?>')" class="a" /></td>

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