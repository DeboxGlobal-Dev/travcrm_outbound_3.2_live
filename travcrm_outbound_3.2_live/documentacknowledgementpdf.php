<?php 
include "inc.php";  
include "config/logincheck.php";  
?>
<?php 
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Welcome</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style type="text/css">
  h4{
    font-weight: 400
      }
      .tabd{
      	border: 1px solid black;
      	border-spacing: 0px!important;
      	text-align: center;
      }
      .tabd td{
      	border: 1px solid black;
      }
</style>
<section>
<form action="#" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">
<div id="printableArea<?php echo strip($quotationData['id']); ?>">        
<h4 style="text-align: center">DOCUMENT ACKNOWLEDGEMENT SHEET</h4>
<br>
<table width="100%">
	<tr>
		<td style="text-align:right;" colspan="2">
			<h4></h4>
		</td>
	</tr>
	<tr>
		<td>
		<h4><?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?></h4>
		</td>
		<td style="text-align: right;">
			<h4>Date : <?php if($resultpage['fromDate']!=''){ echo date('j-F-Y',strtotime($resultpage['fromDate'])); }?></h4>
		</td>
	</tr>

</table>
<h4 style="line-height: 26px;">Dear Sir, <br>We are pleased to deliver you the following travel documents which are necessary for your trip.</h4>
<h4>( A ) Itinerary :    Yes / No</h4>
<h4>( B ) Hotel Vouchers :</h4>
<table width="100%" class="tabd">
	<tr>
		<td><h4>Date</h4></td>
		<td><h4>Hotel Name</h4></td>
		<td><h4>Exchange Order No.</h4></td>
		<td><h4>Category</h4></td>
		<td><h4>Plan</h4></td>
		<td><h4>Rooms</h4></td>
	</tr>
	<?php 
    $rs22=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationData['id'].'"');
    while($hotellisting=mysqli_fetch_array($rs22)){
    $hotellistId=$hotellisting['id'];    
    if($hotellisting['fromDate']!=''){ $fromDate=date('j',strtotime($hotellisting['fromDate'])); }
    if($hotellisting['toDate']!=''){ $toDate=date('j F',strtotime($hotellisting['toDate'])); }
    
	$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
    $hoteldetail=mysqli_fetch_array($rs1ee);
        
    $rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
 	$mealplan=mysqli_fetch_array($rssda24); 
 	$mealplan=$mealplan['name'].'-'.$mealplan['subname'];
	?>
	<tr>
		<td><h4><?php echo $fromDate.'-'.$toDate; ?></h4></td>
		<td><h4><?php echo strip($hoteldetail['hotelName']);?></h4></td>
		<td><h4>118051</h4></td>
		<td><h4><?php echo $hoteldetail['hotelCategory']; ?></h4></td>
		<td><h4><?php echo $mealplan; ?></h4></td>
		<td><h4><?php echo $hotellisting['noofrooms']; ?></h4></td>
	</tr>
	<?php } ?>
</table>
<h4>( C ) Transporters Agent Vouchers  :</h4>
<h4>( D ) Hotel Vouchers :</h4>
<h4>( E ) Flight Tickets :</h4>
<h4>( F ) Train Tickets :</h4>
<h4>( G ) Guide Name :</h4>
<h4>( H ) Agent / Hotels List  :</h4> 
<h4>( I ) Confidential Report  :</h4>
<br>
 <h4 style="line-height: 26px">Kindly acknowledge receipt on the duplicate copy of the above mentioned travel documentsfrom the representative of our organisation.<br><br>
Wish you a successful & a memorable stay.</h4>
<br>
<br>

<table width="100%">
	<tr>
		<td>
			<h4> ( Signature of the Representative)</h4>
		</td>
         <td style="text-align: right;">
			<h4> ( Signature of the Guests)</h4>
		</td>

	</tr>
	<tr>
		<td>
		<h4></h4>
		</td>
		<td style="text-align: right;">
			<h4><?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?></h4>
		</td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td>
			<h4>CC</h4>
		</td>
         <td>
			<h4></h4>
		</td>

	</tr>
	<tr>
		<td>
		<h4>1. CLIENT COPY</h4>
		</td>
		<td>
			<h4></h4>
		</td>
	</tr>
	<tr>
		<td>
			<h4>2. GR COPY</h4>
		</td>
         <td style="text-align: right;">
			<h4> ( Sign of the File Handler )</h4>
		</td>

	</tr>
	<tr>
		<td>
			<h4>3. FILE COPY</h4>
		</td>
         <td style="text-align: right;">
			<h4></h4>
		</td>

	</tr>
	<tr>
		<td>
			<h4>4. QUALITY CONTROL COPY</h4>
		</td>
         <td>
			<h4></h4>
		</td>

	</tr>
	<tr>
		<td>
			<h4>5. ACCOUNT COPY</h4>
		</td>
         <td>
			<h4></h4>
		</td>

	</tr>
</table>
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
</div><br>	 
<div style="background-color: #F7F7F7; padding: 5px; border: 1px solid #e5e5e5; margin-bottom:10px; margin:10px; margin-top:0px; margin-bottom:20px;    margin-top: -10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <!--<td colspan="2" align="left"><input type="Submit" name="Submit" value="Save Changes"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" class="a" /></td-->
    
    <!--<td width="50%" align="right"><input type="button" name="Submit" value="Print"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="printDiv('printableArea<?php echo strip($quotationData['id']); ?>')" class="a"  /></td>-->
  <td><a style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding-left:5px; padding-right:5px;" href="genrateDOMPdf.php?pageurl=http://travcrm.in/travcrm-latestinbound-dev/documentacknowledgement.php">print</a></td>
  
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
</section>




