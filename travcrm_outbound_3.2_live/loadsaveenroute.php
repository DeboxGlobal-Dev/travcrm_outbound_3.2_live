<?php
include "inc.php";  

if($_REQUEST['add']=='yes'){

$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
$dayData = mysqli_fetch_array($dayQuery);


$quotationId= $dayData['quotationId']; 
$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
$quotationData = mysqli_fetch_array($rs1); 
$queryId = $quotationData['queryId'];

$dayId= $dayData['id']; 
$startDate= $dayData['srdate']; 
$destinationId= $_REQUEST['destinationId']; 

$enrouteId = $_REQUEST['enrouteId'];  

$select1 = '*';  
$where1= 'id="'.$enrouteId.'"'; 
$rs1 = GetPageRecord($select1,_PACKAGE_BUILDER_ENROUTE_MASTER_,$where1); 
$enrouteData = mysqli_fetch_array($rs1); 
 
	$startDate=date('Y-m-d',strtotime($startDate));  
 
 $select2='id';  
$where2='setDefault=1'; 
$rs2=GetPageRecord($select2,_QUERY_CURRENCY_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
$cur=clean($editresult2['id']);  

$adultCost=addslashes($enrouteData['adultCost']);   
$childCost=addslashes($enrouteData['childCost']);           
$infantCost=addslashes($enrouteData['infantCost']);           

$namevalue ='fromDate="'.$startDate.'",toDate="'.$startDate.'",destinationId="'.$destinationId.'",enrouteId="'.$enrouteId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",currencyId="'.$cur.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",dayId="'.$dayId.'"';
$lastid = addlistinggetlastid(_QUOTATION_ENROUTE_MASTER_,$namevalue); 
// loop for hotel query inserting number of date 
	 
	$namevalue1 ='serviceId="'.$lastid.'",serviceType="enroute", dayId="'.$dayId.'",startDate="'.$startDate.'",endDate="'.$startDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 
  
?> 
<script> 
	//closeinbound();
	 loadquotationmainfile(); 
</script>
<?php
} 