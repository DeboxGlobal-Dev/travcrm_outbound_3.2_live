<?php 
include "inc.php";

if($_REQUEST['guideQuotationId']>0 && $_REQUEST['quotationId']!=''){

$guidefinalId=$_REQUEST['guidefinalId'];
$guideQuotationId=$_REQUEST['guideQuotationId'];
$quotationId=$_REQUEST['quotationId'];
$guideId=$_REQUEST['guideId'];
$supplierId=$_REQUEST['supplierId'];

$manualStatus=$_REQUEST['manualStatus'];
$followupDate=$_REQUEST['followupDate'];
$followupTime=$_REQUEST['followupTime'];
echo $followupDateTime = date('Y-m-d H:i:s', strtotime("$followupDate $followupTime"));

$adultCost=$_REQUEST['adultCost']; 
$remarks=$_REQUEST['remarks'];

	$namevalue ='supplierId="'.$supplierId.'",shareQuoteStatus="'.$manualStatus.'",followupDate="'.date('Y-m-d H:i:s', strtotime($followupDateTime)).'",adultCost="'.$adultCost.'",remarks="'.$remarks.'"';  
	
	$where='id="'.$guidefinalId.'" and guideQuotationId="'.$guideQuotationId.'" and quotationId="'.$quotationId.'" and guideId="'.$guideId.'" ';  
	$update = updatelisting('finalQuoteGuides',$namevalue,$where); 

	$where1='serviceId="'.$quotationId.'" and taskId = "'.$guidefinalId.'" and serviceType="guide_supp_conf"'; 
	$rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	if(mysqli_num_rows($rs1) > 0){
		$wherex='serviceId='.$quotationId.' and taskId = "'.$guidefinalId.'" and serviceType="guide_supp_conf"';
		$re ='followupDate="'.$followupDateTime.'"';    
		$update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);
		
	}else{
 		$re ='serviceId="'.$quotationId.'",taskId="'.$guidefinalId.'",serviceType="guide_supp_conf",followupDate="'.$followupDateTime.'"'; 
		addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	}
}



if($_REQUEST['id']!='' && $_REQUEST['action']=='sendquoatetosupplier'){


$rsh=GetPageRecord('*','finalQuoteGuides','id='.$_REQUEST['id'].'');  
$listingyes2=mysqli_fetch_array($rsh); 

	$shareDate = date('Y-m-d H:i:s');
	
	echo $namevalue2 ='guideQuotationId="'.$listingyes2['guideQuotationId'].'",guideId="'.$listingyes2['guideId'].'",adultCost="'.$listingyes2['adultCost'].'",supplierId="'.$listingyes2['supplierId'].'",quotationId="'.$listingyes2['quotationId'].'",shareQuoteStatus=1,shareDate="'.$shareDate.'"';  
	$lastId = addlistinggetlastid('finalQuoteGuides',$namevalue2); 	



$d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$listingyes2['guideId'].'"');   
$guideData=mysqli_fetch_array($d);
$remarks = $listingyes2['remarks'];
$email = getPrimaryEmail($listingyes2['supplierId'],'suppliers');
//$email='samay.dbox@gmail.com';

$mailsubject='Flight Quotation - '.$guideData['name'].'';



$thead0='';
$tbody1='';
$thead2='';

//$thead0
if($listingyes2['adultCost']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Adult&nbsp;Cost</th>';
}  


//$tbody1
if($listingyes2['adultCost']!=0){
$tbody1.='<td align="center">'.$listingyes2['adultCost'].'</td>';
}


$maildescription='<table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
 			   		<tr>
			     		<th colspan="5" align="left" bgcolor="#F4F4F4">'.$guideData['guideName'].'</th>
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
							<a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes2['id']).'&st=2&action=guide"><input type="submit" name="Submit" value="Accept" style=" background-color:#009900; color:#FFFFFF; padding:8px 20px; border:0px;"></a> <a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes2['id']).'&st=3"><input type="submit" name="Submit" value="Reject" style=" background-color:#CC0000; color:#FFFFFF; padding:8px 20px; border:0px;"></a>
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
//echo "samay";
?>
<script>
alertspopupopen('action=finalquote&queryId=<?php echo encode($_REQUEST['queryId']); ?>&quotationId=<?php echo $listingyes2['quotationId']; ?>','900px','auto');
</script>

<?php
}
?>