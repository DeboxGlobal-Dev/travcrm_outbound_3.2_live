<?php 
include "inc.php";

if($_REQUEST['action']=="saveguestlist" && $_REQUEST['queryId']>0 && $_REQUEST['quotationId']!=''){

$queryId=$_REQUEST['queryId'];
$quotationId=$_REQUEST['quotationId'];
$hotelId=$_REQUEST['hotelId'];
$roomType=$_REQUEST['roomType'];
$roomNo=$_REQUEST['roomNo'];
$guest1Gender=$_REQUEST['guest1Gender'];
$guest1Id=$_REQUEST['guest1Id'];
$guest2Gender=$_REQUEST['guest2Gender'];
$guest2Id=$_REQUEST['guest2Id'];
$guest3Gender=$_REQUEST['guest3Gender'];
$guest3Id=$_REQUEST['guest3Id'];
$guest4Gender=$_REQUEST['guest4Gender'];
$guest4Id=$_REQUEST['guest4Id'];
$guest5Gender=$_REQUEST['guest5Gender'];
$guest5Id=$_REQUEST['guest5Id'];
$guest6Gender=$_REQUEST['guest6Gender'];
$guest6Id=$_REQUEST['guest6Id'];
$guest7Gender=$_REQUEST['guest7Gender'];
$guest7Id=$_REQUEST['guest7Id'];
$guest8Gender=$_REQUEST['guest8Gender'];
$guest8Id=$_REQUEST['guest8Id'];
$guest9Gender=$_REQUEST['guest9Gender'];
$guest9Id=$_REQUEST['guest9Id'];
$guest10Gender=$_REQUEST['guest10Gender'];
$guest10Id=$_REQUEST['guest10Id'];
$pax=$_REQUEST['pax']; 
$roomTypeName=$_REQUEST['roomTypeName']; 

if($pax==1){ 
$namevalue ='guest1Gender="'.$guest1Gender.'",guest1Id="'.$guest1Id.'",roomTypeName="'.$roomTypeName.'"';
}  


if($pax==2){ 
$namevalue ='guest2Gender="'.$guest2Gender.'",guest2Id="'.$guest2Id.'",roomTypeName="'.$roomTypeName.'"';
}  

if($pax==3){ 
$namevalue ='guest3Gender="'.$guest3Gender.'",guest3Id="'.$guest3Id.'",roomTypeName="'.$roomTypeName.'"';
}  


if($pax==4){ 
$namevalue ='guest4Gender="'.$guest4Gender.'",guest4Id="'.$guest4Id.'",roomTypeName="'.$roomTypeName.'"';
}  

if($pax==5){ 
	$namevalue ='guest5Gender="'.$guest5Gender.'",guest5Id="'.$guest5Id.'",roomTypeName="'.$roomTypeName.'"';
	}  

if($pax==6){ 
	$namevalue ='guest6Gender="'.$guest6Gender.'",guest6Id="'.$guest6Id.'",roomTypeName="'.$roomTypeName.'"';
} 
if($pax==7){ 
	$namevalue ='guest7Gender="'.$guest7Gender.'",guest7Id="'.$guest7Id.'",roomTypeName="'.$roomTypeName.'"';
}  
if($pax==8){ 
	$namevalue ='guest8Gender="'.$guest8Gender.'",guest8Id="'.$guest8Id.'",roomTypeName="'.$roomTypeName.'"';
}  
if($pax==9){ 
	$namevalue ='guest9Gender="'.$guest9Gender.'",guest9Id="'.$guest9Id.'",roomTypeName="'.$roomTypeName.'"';
}  
if($pax==10){ 
	$namevalue ='guest10Gender="'.$guest10Gender.'",guest10Id="'.$guest10Id.'",roomTypeName="'.$roomTypeName.'"';
}  


 

$where='queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and hotelId="'.$hotelId.'" and roomType="'.$roomType.'" and roomNo="'.$roomNo.'"';  
$update = updatelisting('roomingList',$namevalue,$where); 

}


// form remark

if($_REQUEST['action']=="updateguestRemark" && $_REQUEST['queryId']>0 && $_REQUEST['quotationId']!=''){

	$queryId=$_REQUEST['queryId'];
	$quotationId=$_REQUEST['quotationId'];
	$hotelId=$_REQUEST['hotelId'];
	$roomType=$_REQUEST['roomType'];
	$roomNo=$_REQUEST['roomNo'];
	$guestremark1=$_REQUEST['guestremark1'];
	$pax=$_REQUEST['pax']; 
	
	if($pax==1){ 
	$namevalue ='guest1remark="'.$guestremark1.'"';
	}  
	
	
	if($pax==2){ 
	$namevalue ='guest2remark="'.$guestremark1.'"';
	}  
	
	if($pax==3){ 
	$namevalue ='guest3remark="'.$guestremark1.'"';
	}  
	
	
	if($pax==4){ 
	$namevalue ='guest4remark="'.$guestremark1.'"';
	}  
	if($pax==5){ 
		$namevalue ='guest5remark="'.$guestremark1.'"';
	}  
	if($pax==6){ 
		$namevalue ='guest6remark="'.$guestremark1.'"';
	}  
	if($pax==7){ 
		$namevalue ='guest7remark="'.$guestremark1.'"';
	}  
	if($pax==8){ 
		$namevalue ='guest8remark="'.$guestremark1.'"';
	}  
	if($pax==9){ 
		$namevalue ='guest9remark="'.$guestremark1.'"';
	}  
	if($pax==10){ 
		$namevalue ='guest10remark="'.$guestremark1.'"';
	}  
	
	$where='queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and hotelId="'.$hotelId.'" and roomType="'.$roomType.'" and roomNo="'.$roomNo.'"';  
	$update = updatelisting('roomingList',$namevalue,$where); 
	
	}



if($_REQUEST['id']!='' && $_REQUEST['action']=='sendquoatetosupplier'){


$rsh=GetPageRecord('*','finalQuote','id='.$_REQUEST['id'].'');  
$listingyes=mysqli_fetch_array($rsh); 


$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$listingyes['hotelId'].'"');   
$hotelData=mysqli_fetch_array($d);

$d1=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,' id="'.$hotelData['hotelCategoryId'].'"');   
$hotelCData=mysqli_fetch_array($d1);

$email = getPrimaryEmail($listingyes['supplierId'],'suppliers');

$mailsubject='Hotel Quotation - '.$hotelData['hotelName'].'';
$maildescription='<table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
			
			   <tr>
			     <th colspan="5" align="left" bgcolor="#F4F4F4">'.$hotelData['hotelName'].' '.$hotelCData['hotelCategory'].' Star | Room Type: '.$_REQUEST['rtype'].' | Night(s): '.$_REQUEST['nightstay'].'</th>
			     </tr>
			   <tr>
			     <th colspan="5" align="left">&nbsp;</th>
			     </tr>
			   <tr>
				  <th align="center" bgcolor="#F4F4F4">Single</th>
				  <th align="center" bgcolor="#F4F4F4">Double</th>
				  <th align="center" bgcolor="#F4F4F4">Triple</th>
				  <th align="center" bgcolor="#F4F4F4">Twin</th>
				  <th align="center" bgcolor="#F4F4F4">Extra Adult</th>
				  </tr>
			   </thead> 
				<tbody class="ui-sortable">
										<tr>
							<td align="center">
								'.$listingyes['roomSingleCost'].'								  							</td>
							<td align="center">
								'.$listingyes['roomDoubleCost'].'								  							</td>
							<td align="center">
								'.$listingyes['roomTripleCost'].'								  							</td> 
							<td align="center">
								'.$listingyes['roomTwinCost'].'								  							</td> 
							<td align="center">
								'.$listingyes['roomExtraCost'].'							  							</td>  
					    </tr>
										<tr>
										  <td align="center">'.$listingyes['roomSingle'].'</td>
										  <td align="center">'.$listingyes['roomDouble'].'</td>
										  <td align="center">'.$listingyes['roomTriple'].'</td>
										  <td align="center">'.$listingyes['roomTwin'].'</td>
										  <td align="center">'.$listingyes['roomExtra'].'</td>
                  </tr>
										<tr>
										  <td colspan="5" align="center">&nbsp;</td>
				  </tr>
										<tr>
										  <td colspan="5" align="center"> 
										    <a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes['id']).'&st=2"><input type="submit" name="Submit" value="Accept" style=" background-color:#009900; color:#FFFFFF; padding:8px 20px; border:0px;"></a> <a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes['id']).'&st=3"><input type="submit" name="Submit" value="Reject" style=" background-color:#CC0000; color:#FFFFFF; padding:8px 20px; border:0px;"></a>
								 </td>
				  </tr> 
										</tbody>
				</table>';
$ccmail='';

include "config/mail.php"; 

$exeMailresult=send_template_mail('',$email,$mailsubject,$maildescription,$ccmail);


$where='id="'.$listingyes['id'].'"'; 
$namevalue='shareQuoteStatus=1,shareDate="'.date('Y-m-d H:i:s').'"'; 
$update = updatelisting('finalQuote',$namevalue,$where); 

?>
<script>
alertspopupopen('action=finalquote&queryId=<?php echo encode($_REQUEST['queryId']); ?>&quotationId=<?php echo $listingyes['quotationId']; ?>','1200px','auto');
</script>

<?php
}

?>