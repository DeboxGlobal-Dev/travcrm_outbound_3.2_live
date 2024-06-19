<?php 
include "inc.php";

deleteRecord(_SUPPLIERS_MASTER_,' name=""');
echo $issup1 = mysqli_num_rows(GetPageRecord('*', 'suppliercontactPersonMaster', ' corporateId not in ( select id from '._SUPPLIERS_MASTER_.' where 1 ) '))." Contant person records deleted!!";
deleteRecord('suppliercontactPersonMaster',' corporateId not in ( select id from '._SUPPLIERS_MASTER_.' where 1 )');
	echo "<br>";
	echo "<br>";

$issup1 = "";
$issup1 = GetPageRecord('*', _SUPPLIERS_MASTER_, ' 1 ');
while ($supplierData = mysqli_fetch_array($issup1)) {
	$name =  str_replace("/","",$supplierData['name']);
	echo $supplierData['name'].' => '.$name;
	$update = updatelisting(_SUPPLIERS_MASTER_, ' name="'.$name.'"', 'id="' . $supplierData['id'] . '"');
	echo "<br>";
}

// for early arrival hotels

echo "<h1>Update Early Arrival Hotels with new settings </h1>";
echo "<br>";

$cnt = 1;
$issup2 = "";
$issup2 = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, ' 1 ');
while ($qHd = mysqli_fetch_array($issup2)) {
	$issup3 = "";
	$issup3 = GetPageRecord('*', _QUOTATION_MASTER_, ' 1 and id ="'.$qHd['quotationId'].'" ');
	$quotationD = mysqli_fetch_array($issup3);

	$issup4 = "";
	$issup4 = GetPageRecord('*', _QUERY_MASTER_,  ' 1 and id ="'.$quotationD['queryId'].'" ');
	$queryD = mysqli_fetch_array($issup4);

	if($queryD['earlyCheckin']==1){
		if($quotationD['fromDate'] > $qHd['fromDate']){
			$isEarlyCheckin = 1;
			echo $cnt;
			echo $update = updatelisting(_QUOTATION_HOTEL_MASTER_, ' isEarlyCheckin="'.$isEarlyCheckin.'"', 'id="' . $qHd['id'] . '"');
			echo "<br>";
			$cnt++;
		}
	}
}

// update slab id for activity and guide
$cnt = 1;
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 ');
while($quotationData=mysqli_fetch_array($quotQuery)){
    
    $quotationId = clean($quotationData['id']);
    
    $slabQuery='';
    $slabQuery=GetPageRecord('*','totalPaxSlab',' quotationId ="'.$quotationId.'" and status=1');
    $slabData=mysqli_fetch_array($slabQuery);

    $slabId = clean($slabData['id']);
    $update = updatelisting('quotationGuideMaster','slabId="'.$slabId.'",isGuestType=1',' quotationId="'.$quotationId.'"'); 
    echo $cnt;
    $cnt++;
} 
 

// Updated old hotel to the new system multiple hotel rooms
$qItiQuery1=GetPageRecord('*','quotationItinerary',' 1 and serviceType="hotel" order by startDate asc');
if(mysqli_num_rows($qItiQuery1) >0){ 
    while($qItData=mysqli_fetch_array($qItiQuery1)){
        $cquery='';
        $cquery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$qItData['quotationId'].'" and id="'.$qItData['serviceId'].'" and dayId="'.$qItData['dayId'].'" ');
        while($hotelQuotData=mysqli_fetch_array($cquery)){
            updatelisting('quotationItinerary',' serviceId="'.$hotelQuotData['supplierId'].'"','id="'.$qItData['id'].'" and serviceType="hotel" and quotationId="'.$hotelQuotData['quotationId'].'"');
        }
    }
}

?>