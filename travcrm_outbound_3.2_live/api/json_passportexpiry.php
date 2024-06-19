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

	if ($type==1) {
		
		$clienttype='corporate';

	}
	if ($type==2) {
		
		$clienttype='contacts';

	}


 $select='*';
 $where=' masterId="'.$masterid.'" and sectionType="'.$clienttype.'"';
 $rs=GetPageRecord($select,_DOCUMENT_DETAILS_MASTER_,$where);
 while ($resListing=mysqli_fetch_array($rs)) {
       
	   $Clienttype = $resListing['sectionType'];

 	if ($resListing['docType']==1) {
 		
 		$documentType='PASSPORT';
 	}

 	 $country=getCountryName($resListing['countryId']);
     $clientName='';
	 if($resListing['sectionType']=='contacts'){
	 $rs1=GetPageRecord('*',contactsMaster,' id="'.$resListing['masterId'].'" ');
	 $contactPersonName=mysqli_fetch_array($rs1);
	 $clientName=$contactPersonName['firstName'].' '.$contactPersonName['lastName'];
     }
	 if($resListing['sectionType']=='corporate'){ 
	 $rs2=GetPageRecord('*',corporateMaster,' id="'.$resListing['masterId'].'" ');
	 $corporatePersonName=mysqli_fetch_array($rs2);
	 $clientName=$corporatePersonName['contactPerson']; 
	 } 
	if($resListing['docType']==1){
 	$json_result.= '{
			"id" : "'.$resListing['id'].'",
			"clientName" : "'.$clientName.'",
			"documentType" : "'.$documentType.'",
			"documentNo" : "'.$resListing['documentNo'].'",
			"country" : "'.$country.'",
			"issueDate" : "'.date('j F Y', strtotime($resListing['issueDate'])).'",
			"expiryDate" : "'.date('j F Y', strtotime($resListing['expiryDate'])).'"
			
			

		},';

       }

}}
?>

{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}