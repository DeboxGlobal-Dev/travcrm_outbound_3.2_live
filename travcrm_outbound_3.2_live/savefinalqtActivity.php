<?php 
include "inc.php";

if($_REQUEST['activityQuotationId']>0 && $_REQUEST['quotationId']!=''){

$activityfinalId=$_REQUEST['activityfinalId'];
$activityQuotationId=$_REQUEST['activityQuotationId'];
$quotationId=$_REQUEST['quotationId'];
$activityId=$_REQUEST['activityId'];
$supplierId=$_REQUEST['supplierId'];

$manualStatus=$_REQUEST['manualStatus'];
$followupDate=$_REQUEST['followupDate'];
$followupTime=$_REQUEST['followupTime'];
echo $followupDateTime = date('Y-m-d H:i:s', strtotime("$followupDate $followupTime"));

$activityCost=$_REQUEST['activityCost']; 
$maxpax=$_REQUEST['maxpax'];
$perPaxCost=$_REQUEST['perPaxCost'];
 

$remarks=$_REQUEST['remarks'];

	$namevalue ='supplierId="'.$supplierId.'",shareQuoteStatus="'.$manualStatus.'",followupDate="'.date('Y-m-d H:i:s', strtotime($followupDateTime)).'",activityCost="'.$activityCost.'",maxpax="'.$maxpax.'",perPaxCost="'.$perPaxCost.'",remarks="'.$remarks.'"';  
	
	$where='id="'.$activityfinalId.'" and activityQuotationId="'.$activityQuotationId.'" and quotationId="'.$quotationId.'" and activityId="'.$activityId.'" ';  
	$update = updatelisting('finalQuoteActivity',$namevalue,$where); 

	$where1='serviceId="'.$quotationId.'" and taskId = "'.$activityfinalId.'" and serviceType="activity_supp_conf"'; 
	$rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	if(mysqli_num_rows($rs1) > 0){
		$wherex='serviceId='.$quotationId.' and taskId = "'.$activityfinalId.'" and serviceType="activity_supp_conf"';
		$re ='followupDate="'.$followupDateTime.'"';    
		$update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);
		
	}else{
 		$re ='serviceId="'.$quotationId.'",taskId="'.$activityfinalId.'",serviceType="activity_supp_conf",followupDate="'.$followupDateTime.'"'; 
		addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	}
}



if($_REQUEST['id']!='' && $_REQUEST['action']=='sendquoatetosupplier'){


$rsh=GetPageRecord('*','finalQuoteActivity','id='.$_REQUEST['id'].'');  
$listingyes2=mysqli_fetch_array($rsh); 

	$shareDate = date('Y-m-d H:i:s');
	
	echo $namevalue2 ='activityQuotationId="'.$listingyes2['activityQuotationId'].'",activityId="'.$listingyes2['activityId'].'",activityCost="'.$listingyes2['activityCost'].'",maxpax="'.$listingyes2['maxpax'].'",perPaxCost="'.$listingyes2['perPaxCost'].'",supplierId="'.$listingyes2['supplierId'].'",quotationId="'.$listingyes2['quotationId'].'",shareQuoteStatus=1,shareDate="'.$shareDate.'"';  
	$lastId = addlistinggetlastid('finalQuoteActivity',$namevalue2); 	



$d=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.$listingyes2['activityId'].'"');   
$activityData=mysqli_fetch_array($d);
$remarks = $listingyes2['remarks'];
$email = getPrimaryEmail($listingyes2['supplierId'],'suppliers');
//$email='samay.dbox@gmail.com';

$mailsubject='Activity Quotation - '.$activityData['otherActivityName'].'';



$thead0='';
$tbody1='';
$thead2='';

//$thead0
if($listingyes2['adultCost']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Adult&nbsp;Cost</th>';
} 
if($listingyes2['childCost']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Child Cost</th>';
}
if($listingyes2['infantCost']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Infant Cost</th>';
}



//$tbody1
if($listingyes2['activityCost']!=0){
$tbody1.='<td align="center">'.$listingyes2['activityCost'].'</td>';
} if($listingyes2['maxpax']!=0){
$tbody1.='<td align="center"> '.$listingyes2['maxpax'].'	</td>';
} if($listingyes2['perPaxCost']!=0){
$tbody1.='<td align="center"> '.$listingyes2['perPaxCost'].'	</td>';
} 	



$maildescription='<table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
 			   		<tr>
			     		<th colspan="5" align="left" bgcolor="#F4F4F4">'.$activityData['activityName'].'</th>
			   		</tr>
			   	 	<tr>
			    	 	<th colspan="5" align="left">'.$remarks.'</th>
			     	</tr>
			   		<tr> '.$thead0.' </tr>
			   	</thead> 
				<tbody class="ui-sortable">
					<tr> '.$tbody1.' </tr>
				  	<tr>
					  <td colspan="5" align="center">&nbsp;</td>
				   	</tr>
				   	<tr>
				   		<td colspan="5" align="center"> 
							<a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes2['id']).'&st=2&action=activity"><input type="submit" name="Submit" value="Accept" style=" background-color:#009900; color:#FFFFFF; padding:8px 20px; border:0px;"></a> <a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes2['id']).'&st=3"><input type="submit" name="Submit" value="Reject" style=" background-color:#CC0000; color:#FFFFFF; padding:8px 20px; border:0px;"></a>
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
alertspopupopen('action=finalquote&queryId=<?php echo encode($_REQUEST['queryId']); ?>&quotationId=<?php echo $listingyes2['quotationId']; ?>','900px','auto');
</script>

<?php
}
?>