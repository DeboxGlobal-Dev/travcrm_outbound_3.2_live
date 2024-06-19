<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$masterid=$_REQUEST['id'];
$type=$_REQUEST['type'];

if ($masterid!='' && $type!='') {

 $select='*';
 $where='companyId="'.$masterid.'" and clientType="'.$type.'" and deletestatus=0 ';
 $rs=GetPageRecord($select,_QUERY_MASTER_,$where);

 while ($resListing=mysqli_fetch_array($rs)) {

  if ($resListing['clientType']==1) {
        $clientType='corporate';
     }

  if ($resListing['clientType']==2) {
        $clientType='contacts';
     }   

    $selectcb2c='*';
    $wherecb2c=' masterId="'.$resListing['companyId'].'" and sectionType="'.$clientType.'"  and primaryvalue=1';
    $rscb2c=GetPageRecord($selectcb2c,_PHONE_MASTER_,$wherecb2c);
    $resListingcb2c=mysqli_fetch_array($rscb2c);
    $phoneNo=$resListingcb2c['phoneNo'];

    $selectDest='*';    
    $whereDest='queryId='.$resListing['id'].' order by srdate asc';   
    $rsDest=GetPageRecord($selectDest,'packageQueryDays',$whereDest); 
    $resListingDest=mysqli_fetch_array($rsDest);
    $destination=getDestination($resListingDest['cityId']); 

  $qid='#'.makeQueryId($resListing['id']).' - '.$destination.' - '.date('j F Y',$resListing['dateAdded']);

  $select1='*';
  $where1='queryId="'.$resListing['id'].'"';
  $rs1=GetPageRecord($select1,_VOUCHER_MASTER_,$where1);
  while ($voucherdetails=mysqli_fetch_array($rs1)) {

      $selectdisplay='*'; 
      $wheredisplay='id="'.$voucherdetails['queryId'].'"'; 
      $displayId=GetPageRecord($selectdisplay,_QUERY_MASTER_,$wheredisplay); 
      $display=mysqli_fetch_array($displayId);
      $quotationYes = $display['quotationYes'];
      
      //==================download voucher============//
      $where11='queryId='.$voucherdetails['queryId'].' and status=1 order by id desc'; 
      $voucherData=GetPageRecord('*',voucherDetailsMaster,$where11); 
      while($voucherlist=mysqli_fetch_array($voucherData)){
      if($voucherlist['serviceType']=='hotel'){
       $downloadpdf="".$fullurl."upload/".$voucherlist['serviceVoucher']."";
      }
      if($voucherlist['serviceType']=='flight'){
       $flightVoucher="".$fullurl."upload/".$voucherlist['serviceVoucher']."";
      }
      }
      //==============================================//
      //$downloadPdfLink = "".$fullurl."tcpdf/examples/getpdf.php?pageurl=".$fullurl."download-agentvoucher.php?id=".encode($voucherdetails['id'])."&download=0";

      //$downloadvoucher = "".$fullurl."tcpdf/examples/getpdf.php?pageurl=".$fullurl."download-agentvoucher.php?id=".encode($voucherdetails['id'])."&download=1";
 
      if($display['quotationYes']==0){ $quotationYes= 'Itinerary'; } 
      if($display['quotationYes']==1){ $quotationYes= 'B2C Quotation'; } 
      if($display['quotationYes']==2){ $quotationYes= 'B2B Quotation'; }

      $json_result.= '{
			"id" : "'.makeQueryId($voucherdetails['id']).'",
			"bookingcode" : "'.'IND'.$voucherdetails['docId'].'",
			"hotelVoucher" : "'.$downloadpdf.'",
			"flightVoucher" : "'.$flightVoucher.'",
			"mobilenumber" : "'.$phoneNo.'",
			"qid" : "'.$qid.'",
			"voucherdate" : "'.date('j F Y',$voucherdetails['dateAdded']).'",
			"packagevoucher" : "'.$quotationYes.'",
			"vouchertype" : "'.'Agent Voucher'.'"
		},';

}}}

 ?>
	{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
	}