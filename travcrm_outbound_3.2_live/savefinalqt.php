<?php 
include "inc.php";

if($_REQUEST['hotelQuotationId']>0 && $_REQUEST['quotationId']!=''){

$hotelfinalId=$_REQUEST['hotelfinalId']; 
$quotationId=$_REQUEST['quotationId']; 

$manualStatus=$_REQUEST['manualStatus'];
$followupDate=$_REQUEST['followupDate'];
$followupTime=$_REQUEST['followupTime'];

echo $followupDateTime = date('Y-m-d H:i:s', strtotime("$followupDate $followupTime"));

$roomsinglecost=$_REQUEST['roomsinglecost'];
$roomdoublecost=$_REQUEST['roomdoublecost'];
$roomtriplecost=$_REQUEST['roomtriplecost'];
$roomquadcost=$_REQUEST['roomquadcost'];
$roomextracost=$_REQUEST['roomextracost'];

$roomsingle=$_REQUEST['roomsingle'];
$roomdouble=$_REQUEST['roomdouble'];
$roomtriple=$_REQUEST['roomtriple'];
$roomextra=$_REQUEST['roomextra']; 
$roomquad=$_REQUEST['roomquad'];

$remarks=$_REQUEST['remarks'];
$childWBedCost=$_REQUEST['childWBedCost'];
$childWOBedCost=$_REQUEST['childWOBedCost'];
$childWBed=$_REQUEST['childWBed'];
$childWOBed=$_REQUEST['childWOBed'];

	$namevalue ='supplierId="'.$supplierId.'",shareQuoteStatus="'.$manualStatus.'",followupDate="'.date('Y-m-d H:i:s', strtotime($followupDateTime)).'",roomSingleCost="'.$roomsinglecost.'",roomDoubleCost="'.$roomdoublecost.'",roomTripleCost="'.$roomtriplecost.'",roomQuadCost="'.$roomquadcost.'",roomExtraCost="'.$roomextracost.'",roomSingle="'.$roomsingle.'",roomDouble="'.$roomdouble.'",roomTriple="'.$roomtriple.'",remarks="'.$remarks.'",roomExtra="'.$roomextra.'",childWBedCost="'.$childWBedCost.'",childWOBedCost="'.$childWOBedCost.'",childWBed="'.$childWBed.'",childWOBed="'.$childWOBed.'"';  

	$where='id="'.$hotelfinalId.'"  ';  
	$update = updatelisting('finalQuote',$namevalue,$where); 

	$where1='serviceId="'.$quotationId.'" and taskId = "'.$hotelfinalId.'" and serviceType="hotel_supp_conf"'; 
	$rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	if(mysqli_num_rows($rs1) > 0){
		$wherex='serviceId='.$quotationId.' and taskId = "'.$hotelfinalId.'" and serviceType="hotel_supp_conf"';
		$re ='followupDate="'.$followupDateTime.'"';  
		$update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);
		
	}else{
 		$re ='serviceId="'.$quotationId.'",taskId="'.$hotelfinalId.'",serviceType="hotel_supp_conf",followupDate="'.$followupDateTime.'"'; 
		addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	}
}



if($_REQUEST['id']!='' && $_REQUEST['action']=='sendquoatetosupplier'){


$rsh=GetPageRecord('*','finalQuote','id='.$_REQUEST['id'].'');  
$listingyes=mysqli_fetch_array($rsh); 

	$shareDate = date('Y-m-d H:i:s');
	
	echo $namevalue ='hotelQuotationId="'.$listingyes['hotelQuotationId'].'",hotelId="'.$listingyes['hotelId'].'",supplierId="'.$listingyes['supplierId'].'",quotationId="'.$listingyes['quotationId'].'",roomSingleCost="'.$listingyes['roomSingleCost'].'",roomDoubleCost="'.$listingyes['roomDoubleCost'].'",roomTripleCost="'.$listingyes['roomTripleCost'].'",roomQuadCost="'.$listingyes['roomQuadCost'].'",roomExtraCost="'.$listingyes['roomExtraCost'].'",roomSingle="'.$listingyes['roomSingle'].'",roomDouble="'.$listingyes['roomDouble'].'",roomTriple="'.$listingyes['roomTriple'].'",roomQuad="'.$listingyes['roomQuad'].'",roomExtra="'.$listingyes['roomExtra'].'",shareQuoteStatus=1,shareDate="'.$shareDate.'",roomSingleCost2="'.$listingyes['roomSingleCost2'].'",roomDoubleCost2="'.$listingyes['roomDoubleCost2'].'",roomTripleCost2="'.$listingyes['roomTripleCost2'].'",roomQuadCost2="'.$listingyes['roomQuadCost2'].'",roomExtraCost2="'.$listingyes['roomExtraCost2'].'",roomSingle2="'.$listingyes['roomSingle2'].'",roomDouble2="'.$listingyes['roomDouble2'].'",roomTriple2="'.$listingyes['roomTriple2'].'",roomExtra2="'.$listingyes['roomExtra2'].'",childWBedCost="'.$listingyes['childWBedCost'].'",childWOBedCost="'.$listingyes['childWOBedCost'].'",childWBed="'.$listingyes['childWBed'].'",childWOBed="'.$listingyes['childWOBed'].'"';  
	$lastId = addlistinggetlastid('finalQuote',$namevalue); 	



$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$listingyes['hotelId'].'"');   
$hotelData=mysqli_fetch_array($d);
$remarks = $listingyes['remarks'];
$email = getPrimaryEmail($listingyes['supplierId'],'suppliers');
//$email='samay.dbox@gmail.com';

$mailsubject='Hotel Quotation - '.$hotelData['hotelName'].'';



$thead0='';
$tbody1='';
$thead2='';

//$thead0
if($listingyes['roomSingleCost']!=0 && $listingyes['roomSingle']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Single</th>';
} if($listingyes['roomDoubleCost']!=0 && $listingyes['roomDouble']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Double</th>';
} if($listingyes['roomTripleCost']!=0 && $listingyes['roomTriple']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Triple</th>';
}
if($listingyes['childWBedCost']!=0 && $listingyes['childWBed']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Child With Bed</th>';
}
if($listingyes['childWOBedCost']!=0 && $listingyes['childWOBed']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Child W/O Bed</th>';
}
if($listingyes['roomExtraCost']!=0 && $listingyes['roomExtra']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Extra Adult</th>';
}
 
//$tbody1
if($listingyes['roomSingleCost']!=0 && $listingyes['roomSingle']!=0){
$tbody1.='<td align="center">'.$listingyes['roomSingleCost'].'</td>';
} if($listingyes['roomDoubleCost']!=0 && $listingyes['roomDouble']!=0){
$tbody1.='<td align="center"> '.$listingyes['roomDoubleCost'].'	</td>';
} if($listingyes['roomTripleCost']!=0 && $listingyes['roomTriple']!=0){
$tbody1.='<td align="center"> '.$listingyes['roomTripleCost'].' </td>';
} 
if($listingyes['childWBedCost']!=0 && $listingyes['childWBed']!=0){
$tbody1.='<td align="center"> '.$listingyes['childWBedCost'].' </td>';
} 
if($listingyes['childWOBedCost']!=0 && $listingyes['childWOBed']!=0){
$tbody1.='<td align="center"> '.$listingyes['childWOBedCost'].' </td>';
} 
if($listingyes['roomExtraCost']!=0 && $listingyes['roomExtra']!=0){
$tbody1.='<td align="center"> '.$listingyes['roomExtraCost'].' </td>';
}	

//$thead2
if($listingyes['roomSingleCost']!=0 && $listingyes['roomSingle']!=0){
$tbody2.='<td align="center">'.$listingyes['roomSingle'].'</td>';
} if($listingyes['roomDoubleCost']!=0 && $listingyes['roomDouble']!=0){
$tbody2.='<td align="center"> '.$listingyes['roomDouble'].'	</td>';
} if($listingyes['roomTripleCost']!=0 && $listingyes['roomTriple']!=0){
$tbody2.='<td align="center"> '.$listingyes['roomTriple'].' </td>';
} 
if($listingyes['childWBedCost']!=0 && $listingyes['childWBed']!=0){
$tbody2.='<td align="center"> '.$listingyes['childWBed'].' </td>';
}
if($listingyes['childWOBedCost']!=0 && $listingyes['childWOBed']!=0){
$tbody2.='<td align="center"> '.$listingyes['childWOBed'].' </td>';
}
if($listingyes['roomExtra']!=0 && $listingyes['roomExtra']!=0){
$tbody2.='<td align="center"> '.$listingyes['roomExtra'].' </td>';
}	
 

$maildescription='<table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
 			   		<tr>
			     		<th colspan="6" align="left" bgcolor="#F4F4F4">'.$hotelData['hotelName'].' <img src="'.$fullurl.'images/'.packageshowStarrating($hotelData['hotelCategory']).'" height="15" /> Room Type: '.$_REQUEST['rtype'].' | Night(s): '.$_REQUEST['nightstay'].'</th>
			   		</tr>
			   	 	<tr>
			    	 	<th colspan="6" align="left">'.$remarks.'</th>
			     	</tr>
			   		<tr> '.$thead0.' </tr>
			   	</thead> 
				<tbody class="ui-sortable">
					<tr> '.$tbody1.' </tr>
					<tr> '.$tbody2.' </tr>
				  	<tr>
					  <td colspan="6" align="center">&nbsp;</td>
				   	</tr>
				   	<tr>
				   		<td colspan="6" align="center"> 
							<a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes['id']).'&st=2&action=hotel"><input type="submit" name="Submit" value="Accept" style=" background-color:#009900; color:#FFFFFF; padding:8px 20px; border:0px;"></a> <a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes['id']).'&st=3"><input type="submit" name="Submit" value="Reject" style=" background-color:#CC0000; color:#FFFFFF; padding:8px 20px; border:0px;"></a>
						</td>
				   </tr> 
				</tbody>
			</table>';
$ccmail='';
//echo $maildescription;
include "config/mail.php"; 

$exeMailresult=send_template_mail('',$email,$mailsubject,$maildescription,$ccmail);
/*
$where='id="'.$listingyes['id'].'"'; 
$namevalue='shareQuoteStatus=1,shareDate="'.date('Y-m-d H:i:s').'"'; 
$update = updatelisting('finalQuote',$namevalue,$where); 
*/
?>
<script>
alertspopupopen('action=finalquote&queryId=<?php echo encode($_REQUEST['queryId']); ?>&quotationId=<?php echo $listingyes['quotationId']; ?>','1000px','auto');
</script>

<?php
}
?>