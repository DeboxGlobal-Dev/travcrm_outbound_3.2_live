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

   <td align="center" valign="top" style="font-size:13px;">Contact Details for</td>

  </tr>

  <tr>

  <td align="center" valign="top" style="font-size:13px;padding-top: 9px;"><?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?> </td>

  </tr>

  <tr>

    <td align="left" valign="top" style="font-size:15px;padding-top: 10px;">Please note all telephone numbers include Country Code-Area Code-Telephone Numbers</td>

  </tr>

  <tr>

    <td align="left" valign="top" style="font-size:15px;">-While dialing from out of India, dial the entire number</td>

  </tr>

  <tr>

    <td align="left" valign="top" style="font-size:15px;">-While dialing from within India but to outstation, dial -0- then Area Code and Number</td>

  </tr>

  <tr>

    <td align="left" valign="top" style="font-size:15px;">-While dialing from within the city, just dial the number</td>

  </tr>

  <tr>

    <td align="left" valign="top" style="font-size:15px;">-While dialing mobile from within India but to outstation, dial -0- before the Mobile Number</td>

  </tr>

  <tr>

    <td align="left" valign="top" style="font-size:15px;">-While dialing mobile within the city, just dial the number</td>

  </tr>

  <tr>

  <td colspan="2" style="font-size:15px;padding-top: 10px;">

  <table width="100%" border="1" cellpadding="0" cellspacing="0">

      <tr>

        <th width="9%" align="left" valign="top"><strong>Dates/City</strong></th>

        <th width="9%" align="left" valign="top">Hotel</th>

        <th width="9%" align="left" valign="top">Local&nbsp;Contact</th>

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

        <td align="left" valign="top"><?php echo $fromDate.'-'.$toDate; ?><br><?php echo ($hoteldetail['hotelCity']);?></td>

        <td align="left" valign="top"><?php echo strip($hoteldetail['hotelName']);?><br><?php echo $hoteldetail['hotelCity'];?>,&nbsp;<?php echo $hoteldetail['hotelCountry']; ?><br><br><?php echo $hoteldetail['supplierPhone']; ?></td>

        <td align="left" valign="top">
          <select name="localContact" id="localContact">
            <option value="">Select Local Supplier</option>
            <?php 
            $supres = GetPageRecord('*','suppliersMaster','status=1 and deletestatus=0');
            while($datares = mysqli_fetch_assoc($supres)>0){
              ?>
              <option value="<?php echo $datares['id']; ?>"><?php echo $datares['name']; ?></option>
              <?php
            }
            ?>
          </select>
        
        
       </td>

      </tr>

      <?php } ?>

     </tbody>

    </table>

  </td>

  </tr>

  <tr>

    <td align="center" valign="top" style="font-size:15px;padding-top: 11px;">While you are on Tour in India for any assistance, please do get in touch with one of the following</td>

  </tr>

   <tr>

    <td align="left" valign="top" style="font-size:15px;padding-top: 12px;">Operation teams:</td>

  </tr>

    <?php 

    $selectu='*';    

    $whereu=' id="'.$resultpage['assignTo'].'"  ';  

    $rsu=GetPageRecord($selectu,_USER_MASTER_,$whereu); 

    while($resListingu=mysqli_fetch_array($rsu)){ 

    

    $operationPerson=$resListingu['firstName'].' '.$resListingu['lastName'];

    $phone=$resListingu['phone'];

    ?>

  <tr>

    <td align="left" valign="top" style="font-size:15px;padding-top: 8px;"><?php echo $operationPerson.' - '.$phone; ?></td>

  </tr>

  <?php } ?>

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