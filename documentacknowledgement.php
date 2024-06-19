<?php

include "inc.php";  

include "config/logincheck.php";  







  

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


$select1='*';   
$where1='id=1'; 
$rs1=GetPageRecord($select1,'lettersettings',$where1); 
$editresult=mysqli_fetch_array($rs1);


$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$resultpage['id'].'"');  

$quotationData=mysqli_fetch_array($rs1);

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

  <tr>

   <td width="100%" align="center"><img src="<?php echo $fullurl; ?>download/<?php echo $editresult['logo']; ?>" width="153" style="width:415px;"/></td>

  </tr>

  <tr>

   <td align="left" valign="top" style="font-size:13px;"><?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?></td>

   <td width="20%" align="left" valign="top" style="font-size:13px;float: right;position: absolute;margin-left: -125px;">Date: <?php if($resultpage['fromDate']!=''){ echo date('j-F-Y',strtotime($resultpage['fromDate'])); }?></td>

  </tr>

  <tr>

    <td style="font-size:15px;"><br />Dear Sir,</td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />We are pleased to deliver yoou the following travel documents which are necessary for your trip.</td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />( A ) Itinerary : &nbsp;&nbsp;&nbsp;Yes / No</td>

  </tr>

  <tr>

   <td style="font-size:15px;"><br />( B ) Hotel Vouchers :</td>

  </tr>

  <tr>

  <td colspan="2" style="font-size:15px;">

  <table width="100%" border="1" cellpadding="0" cellspacing="0">

      <tr>

        <th width="10%" align="left" valign="top"><strong>Date</strong></th>

        <th width="25%" align="left" valign="top">Hotel&nbsp;Name</th>

        <th width="2%" align="left" valign="top">Exchange&nbsp;Order&nbsp;No</th>

        <th width="2%" align="left" valign="top">Category</th>

		<th width="9%" align="left" valign="top">Plan</th>

		<th width="1%" align="left" valign="top">Rooms</th>

      </tr>

	  <tbody>

	  <?php 

        $rs22=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationData['id'].'"');

        while($hotellisting=mysqli_fetch_array($rs22)){

        $hotellistId=$hotellisting['id'];    

        if($hotellisting['fromDate']!=''){ $fromDate=date('j',strtotime($hotellisting['fromDate'])); }

        if($hotellisting['toDate']!=''){ $toDate=date('j F-Y',strtotime($hotellisting['toDate'])); }

        

    	$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  

        $hoteldetail=mysqli_fetch_array($rs1ee);

            

        $rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 

     	$mealplan=mysqli_fetch_array($rssda24); 

     	$mealplan=$mealplan['name'].'-'.$mealplan['subname'];

    	?>    

      <tr>

        <td align="left" valign="top"><?php echo $fromDate.'-'.$toDate; ?></td>

        <td align="left" valign="top"><?php echo strip($hoteldetail['hotelName']);?></td>

        <td align="center" valign="top"><?php echo $hotellisting['confirmation'];?></td>

		<td align="center" valign="top"><?php echo $hoteldetail['hotelCategory']; ?></td>

		<td align="left" valign="top"><?php echo $mealplan; ?></td>

		<td align="center" valign="top"><?php echo $hotellisting['noofrooms']; ?></td>

      </tr>

      <?php } ?>

     </tbody>

    </table>

  </td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />( C ) Transporters Agent Vouchers  : </td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />( D ) Restaurant / Meals Vouchers : </td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />( E ) Flight Tickets : </td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />( F ) Train Tickets : </td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />( G ) Guide Name : </td>

  </tr>

  <tr>

    <td style="font-size:15px;">&nbsp;</td>

  </tr>

  <tr>

    <td style="font-size:15px;">&nbsp;</td>

  </tr>

  <tr>

    <td style="font-size:15px;">&nbsp;</td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />( H ) Agent / Hotels List: </td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />( I ) Confidential Report: </td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />Kindly acknowledge receipt on the duplicate copy of the above mentioned travel documentsfrom the representative of our organisation.</td>

  </tr>

  <tr>

  <td style="font-size:15px;"><br />Wish you a successful & a memorable stay.</td>

  </tr>

   <tr>

    <td style="font-size:15px;">&nbsp;</td>

  </tr>

   <tr>

    <td style="font-size:15px;">&nbsp;</td>

   </tr>

  <tr>

  <td colspan="2" style="font-size:15px;">

  <table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>

	   <td width="45%" align="left" valign="top"><img src="<?php echo $fullurl; ?>images/abc.PNG" height="80"></td>

	   <td width="45%" align="right" valign="top"><img src="<?php echo $fullurl; ?>images/xyz.PNG" height="80"></td>

	  </tr>

	  <tr>

       <td width="10%" align="left" valign="top" >( Signature of the Representative )</td>

       <td width="10%" align="right" valign="top" >( Signature of the Guests )</td>

      </tr>

	   <tr>

       <td style="font-size:15px;">&nbsp;</td>

       <td width="10%" align="right" valign="top"><?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?></td> 

       </tr>

	   <tr>

        <td style="font-size:15px;">&nbsp;</td>

       </tr>

	   <tr>

        <td style="font-size:15px;">&nbsp;</td>

       </tr>

       <tr align="left" valign="top">

        <td width="10%"><strong>CC:</strong></td>

      </tr>

	  <tr>

        <td style="font-size:15px;"><br />1 ) CLIENT'S COPY </td>

      </tr>

	  <tr>

        <td style="font-size:15px;"><br />2 ) GR COPY</td>

      </tr>

	  <tr>

        <td style="font-size:15px;"><br />3 ) FILE COPY </td>

		<td width="20%" align="right" valign="top"><img src="<?php echo $fullurl; ?>images/abc.PNG" height="80"></td>

      </tr>

	   <tr>

        <td style="font-size:15px;"><br />4 ) QUALITY CONTROL COPY </td>

		<td style="font-size:15px;" align="right" valign="top"><br /> ( Sign of the File Handler )</td>

      </tr>

	   <tr>

        <td style="font-size:15px;"><br />5 ) ACCOUNT'S COPY </td>

      </tr>

    </table>

  </td>

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