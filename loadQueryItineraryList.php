<?php include "inc.php";   
if($_REQUEST['final']==1 && $_REQUEST['id']!='' && $_REQUEST['id']>0 && $_REQUEST['queryId']!='' && $_REQUEST['queryId']>0){

$wherex='queryId='.$_REQUEST['queryId'].' ';   
$re ='paymentStatus="0"';   
$update = updatelisting(_PACKAGE_QUERY_ITINERARY_QUOTATION_,$re,$wherex);

$wherex='id='.$_REQUEST['id'].' ';   
$re ='paymentStatus="1",status="1"';   
$update = updatelisting(_PACKAGE_QUERY_ITINERARY_QUOTATION_,$re,$wherex);



$selectq1='*';  
$whereq1='id='.$_REQUEST['id'].''; 
$rsq1=GetPageRecord($selectq1,'packageQueryItineraryQuotation',$whereq1); 
$getcostdetail=mysqli_fetch_array($rsq1); 
 
$namevalue ='totalQueryCost="'.round($getcostdetail['totalQueryCost']).'",packagetax="'.round($getcostdetail['packagetax']).'",totalQueryCostwithoutpercent="'.round($getcostdetail['totalQueryCostwithoutpercent']).'",currencyId="'.$getcostdetail['currencyId'].'",serviceTax="'.$getcostdetail['serviceTax'].'"';  
$where='id='.$_REQUEST['queryId'].''; 
$update = updatelisting(_QUERY_MASTER_,$namevalue,$where); 
 


?>

<script>
parent.funloadQueryPackagelist('<?php echo $_REQUEST['queryId']; ?>'); 
</script>

<?php
}
$widthpop ='';
$rs1ddd=GetPageRecord('dayWise',_QUERY_MASTER_,'id="'.$_GET['id'].'"'); 
$editrsssesult=mysqli_fetch_array($rs1ddd);  
 if($editrsssesult['dayWise']==1){  $widthpop ='650px'; }
 if($editrsssesult['dayWise']==2){  $widthpop ='500px'; }
?>

<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="424c5a"> 
  <tr style="font-size:16px; font-weight:600; color:#fff; background-color:#424c5a ;">
    <td  >Sr.</td>
    <td  >Itinerary&nbsp;Id </td>
    <td   align="center">Action</td>
    <td   align="center"><div onclick="alertspopupopen('action=addnewititnery&queryId=<?php echo $_REQUEST['id']; ?>','<?php echo $widthpop; ?>','auto');" style="cursor:pointer; float: right; margin-right: 7px;">+ Add Itinerary</div></td>
  </tr>
  <style>
  .downloaditi{   
    border: 1px solid #4caf50;
    padding: 5px;
    border-radius: 3px; 
    background-color: #4CAF50;
    color: #FFFFFF !important;
    margin: 0px 3px;
	float:left;
    display: block; cursor:pointer;}
  </style>
  <?php 

$sr=0;
$selectiti='*';  
$id=trim($_GET['id']);  
$whereiti='queryId='.$id.' and status="1" and id in (select packageId from packageQueryHotelCity where cityId!="")';  
$rsiti=GetPageRecord($selectiti,_PACKAGE_QUERY_ITINERARY_QUOTATION_,$whereiti);  
$countiti=mysqli_num_rows($rsiti); 
if($countiti>0){
while($resultpageiti=mysqli_fetch_array($rsiti)){
  $sr++;
  
$selectq1='*';  
$whereq1='packageId='.$resultpageiti['id'].''; 
$rsq1=GetPageRecord($selectq1,'packageItineraryQuotationPrice',$whereq1); 
$getcostdetail=mysqli_fetch_array($rsq1);

$selecttotal='*'; 
$wheretotal='packageId='.$resultpageiti['id'].' and priceType in (select displayPrice from '._PACKAGE_QUERY_ITINERARY_QUOTATION_.' where id="'.$resultpageiti['id'].'")'; 
$rstotal=GetPageRecord($selecttotal,'packageItineraryQuotationPrice',$wheretotal); 
$getcosttotal=mysqli_fetch_array($rstotal);
   ?> 
  <tr <?php if($resultpageiti['paymentStatus']==1){ ?> style="background:#ccc;"<?php } ?>>
    <td><span style="color:#424c5a;"><strong><?php echo $sr; ?></strong>.</span></td>
    <td><span style="color:#424c5a; cursor:pointer;" onclick="makeitinerary('<?php echo $resultpageiti['id']; ?>');"><?php echo makeQueryId($resultpageiti['id']); ?></span></td>
    <td colspan="2" align="center"><a onclick="alertspopupopen('action=sendmailItineraryQuotation&ItineraryQuotationId=<?php echo $resultpageiti['id']; ?>&queryId=<?php echo $resultpageiti['queryId']; ?>','600px','auto');" class="downloaditi" style="border: 1px solid #eb8a11; background-color: #eb8a11;" ><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Mail</a> &nbsp;&nbsp;<!--<a class="downloaditi" href="<?php echo $fullurl; ?>tcpdf/examples/genrateitinerarypdf.php?pageurl=<?php echo $fullurl; ?>packageQueryhtml.php?itineraryId=<?php echo encode($resultpageiti['id']); ?>&download=1" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Download Itinerary</a>-->&nbsp;&nbsp;<!--<a class="downloaditi" style="background-color: #424c5a !important;" href="<?php echo $fullurl; ?>/tcpdf/examples/genratequotation.php?pageurl=<?php echo $fullurl; ?>/download-quotationpdf.php?itineraryId=<?php echo encode($resultpageiti['id']); ?>&download=0" target="_blank"><i class="fa fa-quote-left" aria-hidden="true"></i>&nbsp;Generate Quotation</a>-->&nbsp;&nbsp;<?php if($resultpageiti['paymentStatus']==0){ ?><span class="downloaditi" onclick="funmakefinal('<?php echo $resultpageiti['id']; ?>');" style="background-color:#13a173 !important;"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;Make Final</span><?php }else{ ?><img style="width: 30px !important; float: left;" src="<?php echo $fullurl; ?>images/finalitinerary.png" /><?php }  ?><a class="downloaditi" href="<?php echo $fullurl; ?>packageQueryhtmlnew.php?itineraryId=<?php echo encode($resultpageiti['id']); ?>&download=0&m=<?php echo encode(1); ?>" target="_blank" style="background-color:#61b4c6 !important; border:1px solid #61b4c6 !important;"><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;Preview</a> </td>
  </tr>
  <?php   } } if($sr==0){ ?> 
  <tr style="height: 65px;">
    <td colspan="4" align="center"><strong>No Itinerary Found.. </strong></td>
  </tr>
  <?php } ?>
</table>
