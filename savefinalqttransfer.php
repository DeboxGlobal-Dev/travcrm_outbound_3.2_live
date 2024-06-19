<?php 
include "inc.php";

if($_REQUEST['transferQuotationId']>0 && $_REQUEST['quotationId']!=''){

$transferfinalId=$_REQUEST['transferfinalId'];
$transferQuotationId=$_REQUEST['transferQuotationId'];
$quotationId=$_REQUEST['quotationId'];
$transferId=$_REQUEST['transferId'];
 $manualStatus=$_REQUEST['manualStatus'];
$followupDate=$_REQUEST['followupDate'];
$followupTime=$_REQUEST['followupTime'];
 $followupDateTime = date('Y-m-d H:i:s', strtotime("$followupDate $followupTime"));

$vehicleCost=$_REQUEST['vehicleCost']; 
 $remarks=$_REQUEST['remarks'];

	$namevalue ='shareQuoteStatus="'.$manualStatus.'",followupDate="'.date('Y-m-d H:i:s', strtotime($followupDateTime)).'",vehicleCost="'.$vehicleCost.'",remarks="'.$remarks.'"';  
	$where='id="'.$transferfinalId.'" and transferQuotationId="'.$transferQuotationId.'" and quotationId="'.$quotationId.'" and transferId="'.$transferId.'" ';  
	$update = updatelisting('finalQuotetransfer',$namevalue,$where); 
	
	$where1='serviceId="'.$quotationId.'" and taskId = "'.$transferfinalId.'" and serviceType="transfer_supp_conf"'; 
	$rs1=GetPageRecord('*',_TO_DO_TIMELINE_,$where1);
	if(mysqli_num_rows($rs1) > 0){
		$wherex='serviceId='.$quotationId.' and taskId = "'.$transferfinalId.'" and serviceType="transfer_supp_conf"';
		$re ='followupDate="'.$followupDateTime.'"';   
		$update = updatelisting(_TO_DO_TIMELINE_,$re,$wherex);
		
	}else{
 		$re ='serviceId="'.$quotationId.'",taskId="'.$transferfinalId.'",serviceType="transfer_supp_conf",followupDate="'.$followupDateTime.'"'; 
		addlistinggetlastid(_TO_DO_TIMELINE_,$re);
	}
}



if($_REQUEST['id']!='' && $_REQUEST['action']=='sendquoatetosupplier'){


$rsh=GetPageRecord('*','finalQuotetransfer','id='.$_REQUEST['id'].'');  
$listingyes2=mysqli_fetch_array($rsh); 

	$shareDate = date('Y-m-d H:i:s');
	
	echo $namevalue2 ='transferQuotationId="'.$listingyes2['transferQuotationId'].'",transferId="'.$listingyes2['transferId'].'",vehicleCost="'.$listingyes2['vehicleCost'].'",supplierId="'.$listingyes2['supplierId'].'",quotationId="'.$listingyes2['quotationId'].'",shareQuoteStatus=1,shareDate="'.$shareDate.'"';  
	$lastId = addlistinggetlastid('finalQuotetransfer',$namevalue2); 	



$d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$listingyes2['transferId'].'"');   
$transferData=mysqli_fetch_array($d);
$remarks = $listingyes2['remarks'];
// $email = getPrimaryEmail($listingyes2['supplierId'],'suppliers');
$email='samay.dbox@gmail.com';

$mailsubject='Transfer Quotation - '.$transferData['transferName'].'';



$thead0='';
$tbody1='';
$thead2='';

//$thead0
if($listingyes2['adultCost']!=0){
	$thead0.= '<th align="center" bgcolor="#F4F4F4">Adult&nbsp;Cost</th>';
} 



//$tbody1
if($listingyes2['vehicleCost']!=0){
$tbody1.='<td align="center">'.$listingyes2['vehicleCost'].'</td>';
} 



$maildescription='<table width="80%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<thead style="font-weight:500;">
 			   		<tr>
			     		<th colspan="5" align="left" bgcolor="#F4F4F4">'.$transferData['transferName'].'</th>
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
							<a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes2['id']).'&st=2&action=transfer"><input type="submit" name="Submit" value="Accept" style=" background-color:#009900; color:#FFFFFF; padding:8px 20px; border:0px;"></a> <a href="'.$fullurl.'savefinalquote.php?id='.encode($listingyes2['id']).'&st=3"><input type="submit" name="Submit" value="Reject" style=" background-color:#CC0000; color:#FFFFFF; padding:8px 20px; border:0px;"></a>
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