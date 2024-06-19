<?php

include "inc.php";  

//include "config/logincheck.php";  







  

function dateDiffInDays($date1, $date2){ 

	// Calulating the difference in timestamps 

	$diff = strtotime($date2) - strtotime($date1); 

	// 1 day = 24 hours 

	// 24 * 60 * 60 = 86400 seconds 

	return abs(round($diff / 86400)); 

}





$queryId='';

if($_GET['queryId']!=''){

    $queryId .=$_GET['queryId'];

}

$qid='';

if($_GET['qid']!=''){

    $qid .=$_GET['qid'];

}



$select='*';

$where='id='.$queryId.'';

$rs=GetPageRecord($select,_QUERY_MASTER_,$where);   

$resultpage=mysqli_fetch_array($rs);



$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$resultpage['id'].'"');  

$quotationData=mysqli_fetch_array($rs1);



$rs22=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationData['id'].'"');

while($hotellisting=mysqli_fetch_array($rs22)){

    $hotellistId=$hotellisting['id'];    
    if($hotellisting['fromDate']!=''){ $fromDate=date('j',strtotime($hotellisting['fromDate'])); }
    if($hotellisting['toDate']!=''){ $toDate=date('j F-Y',strtotime($hotellisting['toDate'])); }

    $rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
    $hoteldetail=mysqli_fetch_array($rs1ee);

    $rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
    $mealplan=mysqli_fetch_array($rssda24); 
    //.'-'.$mealplan['subname']
    $mealplan=$mealplan['name'];
    $a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" order by srdate asc'); 
    $newQuoteData3=mysqli_fetch_array($a);
    $startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($newQuoteData3['srdate']))); 

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

</style>

<div style="padding:10px;" class="vlist2">

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">

<div id="printableArea<?php echo strip($quotationData['id']); ?>">

<div style="padding:10px; background-color:#FFFFFF; border:2px dashed #ccc;   position:relative; margin:10px;" >

<div style="padding:10px;">

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <!--<tr>

    <td width="100%" align="center"><img src="images/welcomelogo.jpg" height="100" style="margin-bottom:5px;" /></td>

  </tr>-->

  <tr>

   <td align="center" valign="top" style="font-size:15px;">DeBox Global Pvt. Ltd.</td>

  </tr>

  <tr>

   <td align="center" valign="top" style="font-size:15px;">&nbsp;</td>

  </tr>

  <tr>

  <td align="center" valign="top" style="font-size:13px;"><span style="color:black;">BRIFEING SHEET FOR AIRPORT REPRESENTATIVE</span></td>

  </tr>

  <tr>

   <td align="center" valign="top" style="font-size:15px;">&nbsp;</td>

  </tr>

</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

   <td align="left" valign="top" style="font-size:13px;"><span style="color:black;">Date:</span> <?php if($resultpage['fromDate']!=''){ echo date('j-F-Y',strtotime($resultpage['fromDate'])); }?></td>

   <td align="right" valign="top" style="font-size:13px;"><span style="color:black;">File Code:</span> <?php echo $hotellisting['confirmation'];?></td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">Name of Group/FIT:</span> <?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?></td>

   <td align="right" valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">No of Pax:</span> <?php echo $totalPax=$quotationData['adult']+$quotationData['child']+$quotationData['infant'];?></td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">Name of Foreign Agent:</span> Rajan C J</td>

   <td align="right" valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">Name of Tour Leader:</span></td>

  </tr>

</table><br>

<table width="100%" border="0" cellpadding="0" cellspacing="0">

   <tr>

   <td align="left" valign="top" style="font-size:15px;"><span style="color:black;">Travel Documents</span></td>

  </tr>

   <tr>

   <td valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">Any Mail:</span> Yes/No</td>

   <td valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">Itinerary:</span> Yes/No</td>

   <td valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">Vouchers:</span> Yes/No</td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">Flight tickets:</span> Yes/No</td>

   <td valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">Train tickets:</span> Yes/No</td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">To deliver/to collect the Foreign Agent Voucher:</span> Yes/No</td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">To collect any payment ( amount ) USD</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:black;">net towards the sightseeing of</span></td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;"><span style="color:black;">To collect Flight tickets/photocopy of the flight tickets for reconfirmation:</span> Yes/No</td>

  </tr>

   <tr>

   <td align="left" valign="top" style="font-size:15px;padding-top: 8px;"><span style="color:black;">Accommodation</span></td>

  </tr>

   <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Hotel: <?php echo strip($hoteldetail['hotelName']);?></td>

   <td valign="top" style="font-size:13px;">No of Rooms/Room Catagory: <?php echo $hotellisting['noofrooms']; ?></td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Check - in: Day <?php echo dateDiffInDays($hotellisting['fromDate'], $startdatevar); ?></td>

   <td valign="top" style="font-size:13px;">Check -out: Day <?php $daycheakout = dateDiffInDays($hotellisting['toDate'], $startdatevar); echo ($daycheakout >= 1)?$daycheakout+1:$daycheakout;?></td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Hotel reconfirmed by</td>

   <td valign="top" style="font-size:13px;padding-top: 8px;">on(Date)</td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Meal Plan : <?php echo $mealplan; ?></td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:15px;padding-top: 8px;"><span style="color:black;">Sightseeing</span></td>

  </tr>

   <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">BY ( specify the mode of transport )</td>

   <td valign="top" style="font-size:13px;padding-top: 8px;">No of Vehicle</td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">A.&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="padding-left: 90px;">Time</span></td>

   <td valign="top" style="font-size:13px;padding-top: 8px;">B.&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="padding-left: 90px;">Time</span></td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Name of Guide / Escort </td>

   <td valign="top" style="font-size:13px;padding-top: 8px;">Mobile Number </td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Pick up time from the Hotel</td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Whether Airport Tax Payable on departure by us: Yes/ No</td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Any  other  instructions / remarks </td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Kindly hand over all the travel documents and brief the itinerary</td>

  </tr>

</table>

 <hr><br><hr>

 <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

   <td align="left" valign="top" style="font-size:13px;">Print&nbsp;Date: 21/12/2020</td>

   <td valign="top" style="font-size:13px;">File Handler&nbsp;&nbsp;Dhanya Benny</td>

  </tr>

   <tr>

   <td align="left" valign="top" style="font-size:13px;padding-top: 8px;">Name of  the Transfer Representative</td>

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

    <td width="50%" align="right"><input type="button" name="Submit" value="Print"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="printDiv('printableArea<?php echo strip($quotationData['id']); ?>')" class="a" /></td>

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