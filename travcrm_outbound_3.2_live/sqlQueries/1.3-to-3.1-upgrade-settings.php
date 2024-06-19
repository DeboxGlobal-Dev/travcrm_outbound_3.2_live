<?php
include "inc.php";    

// REMOVE CONTACTPERSON ENTRY WHICH SUPPLIER DOES NOT EXISTS
deleteRecord(_SUPPLIERS_MASTER_,' name=""');
echo $issup1 = mysqli_num_rows(GetPageRecord('*', 'suppliercontactPersonMaster', ' corporateId not in ( select id from '._SUPPLIERS_MASTER_.' where 1 ) '))." Contant person records deleted!!";
deleteRecord('suppliercontactPersonMaster',' corporateId not in ( select id from '._SUPPLIERS_MASTER_.' where 1 )');
    echo "<br>";
    echo "<br>";

// SUPPLIER NAME UPDATE REMOVE SLASHES
$issup1 = "";
$issup1 = GetPageRecord('*', _SUPPLIERS_MASTER_, ' 1 ');
while ($supplierData = mysqli_fetch_array($issup1)) {
    $name =  str_replace("/","",$supplierData['name']);
    echo $supplierData['name'].' => '.$name;
    $update = updatelisting(_SUPPLIERS_MASTER_, ' name="'.$name.'"', 'id="' . $supplierData['id'] . '"');
    echo "<br>";
}

// FOR EARLY ARRIVAL HOTELS
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
    }else{
        echo 'No date found';
    }
}


// UPDATE QUERY WITH THE RIGHT FINANCIAL YEAR 
$quotQuery='';
$quotQuery=GetPageRecord('id,queryDate','queryMaster',' 1 and displayId > 0 order by displayId asc');
while($queryData=mysqli_fetch_array($quotQuery)){

    $queryId = clean($queryData['id']);
    $fy = getFinancialYear($queryData['queryDate']);
    
    echo$namevalue = 'financeYear="'.$fy.'"'; 
    // echo $update = updatelisting('queryMaster',$namevalue,' id="'.$queryId.'"'); 
}



// UPDATE CALCULATION TYPE 
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and calculationType=0');
while($quotationData=mysqli_fetch_array($quotQuery)){

  $namevalue = 'calculationType=1';
  $update = updatelisting(_QUOTATION_MASTER_,$namevalue,' id="'.$quotationData['id'].'"'); 

}

// UPDATE DAY WISE IN QUOTATIONS
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and dayWise=0');
while($quotationData=mysqli_fetch_array($quotQuery)){

    $namevalue = 'dayWise=1';
    $update = updatelisting(_QUOTATION_MASTER_,$namevalue,' id="'.$quotationData['id'].'"'); 

}
// UPDATE TRAVEL TYPE IN QUOTATIONS
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and travelType=0');
while($quotationData=mysqli_fetch_array($quotQuery)){

    $namevalue = 'travelType=1';
    $update = updatelisting(_QUOTATION_MASTER_,$namevalue,' id="'.$quotationData['id'].'"'); 

}

// need to make migration setting for following
// 1.3 Entrance adult and child cost comes from columns adultCost and childCost
// 3.1 Enrance adult and child cost comes from ticketAdultCost and ticketChildcost
// ( need to move 2.1 adultcost and childcost column cost to 2.2 ticketAdultCost and ticketChildcost columns respectively )
// ************************************************ // 

$entrance2Query='';
$entrance2Query=GetPageRecord('*','quotationEntranceMaster',' 1 ');
while($entrance2Data=mysqli_fetch_array($entrance2Query)){
    $adultCost = 0;
    $adultCost = trim($entrance2Data['adultCost']);
    $childCost = 0;
    $childCost = trim($entrance2Data['childCost']);

    echo 'entrance2Updated<br>';
    updatelisting('quotationEntranceMaster', 'ticketAdultCost="'.$adultCost.'",ticketchildCost="'.$childCost.'"', ' id="'.$entrance2Data['id'].'"'); 

}
die();
$f_entrance2Query='';
$f_entrance2Query=GetPageRecord('*','finalQuoteEntrance',' 1 ');
while($f_entrance2Data=mysqli_fetch_array($f_entrance2Query)){
    
    $adultCost = trim($f_entrance2Data['adultCost']);
    $childCost = trim($f_entrance2Data['childCost']);

    $adultCost2 = trim($f_entrance2Data['adultCost2']);
    $childCost2 = trim($f_entrance2Data['childCost2']);


    echo 'f_entrance2Updated<br>';
    updatelisting('finalQuoteEntrance', 'ticketAdultCost="'.$adultCost.'",ticketchildCost="'.$childCost.'",ticketAdultCost2="'.$adultCost2.'",ticketchildCost2="'.$childCost2.'"', ' id="'.$f_entrance2Data['id'].'"'); 
}


// CASE - 4 : Tour Id sequence should be default month wise
$cmpQuery='';
$cmpQuery=GetPageRecord('*','companySettingsMaster',' 1 ');
while($cmpEntData=mysqli_fetch_array($cmpQuery)){
     
    echo 'TourId sequence - monthwise<br>';
    updatelisting('companySettingsMaster', 'tourIdSequence=1,internationalQuery=1,defaultQueryType=1,domesticQuery=0', ' 1 and id="'.$cmpEntData['id'].'"'); 
}

// CASE - 5 : Pax Type - default FIT for hotel
$dmcHotelQuery='';
$dmcHotelQuery=GetPageRecord('*','dmcroomTariff',' 1 and paxType=1');
while($cmpHotData=mysqli_fetch_array($dmcHotelQuery)){
    
    echo 'Pax Type - default FIT <br>';
    updatelisting('dmcroomTariff', ' paxType=2 ', ' 1 and id="'.$cmpHotData['id'].'" '); 
}

// check id last id before run
$update = updatelisting('nationalityMaster', 'id = 164','id = 2');
$update = updatelisting('nationalityMaster', 'id = 162','id = 3');
// $update = updatelisting('nationalityMaster', 'id = 163','id = 4');
$update = updatelisting('nationalityMaster', 'id = 3','id = 1');

$add = addlisting('nationalityMaster', 'id=1,countryId = 0,sortName ="LC",name = "Local",type = 1');
$add = addlisting('nationalityMaster', 'id=2,countryId = 0,sortName ="FR",name = "Foriegn",type = 1');
// $add = addlisting('nationalityMaster', 'id=3,countryId = 0,sortName ="BM",name = "Bimstec",type = 1');
// $update = updatelisting('nationalityMaster', 'setDefault = 1','name = "Foreign"');

 
// CASE - 6 : financy default entries update finance master as file code work
    // TRUNCATE TABLE `financeYearMaster`;
    // INSERT INTO `financeYearMaster` (`id`, `financeYear`, `daterange`, `fromDate`, `toDate`, `status`, `deletestatus`, `addedBy`, `dateAdded`, `modifyDate`, `modifyBy`) 
    // VALUES (NULL, '22-23', '', '2022-04-01', '2023-03-31', '1', '0', '0', '0', '0', '0'), 
    // (NULL, '23-24', '', '2023-04-01', '2024-03-31', '1', '0', '0', '0', '0', '0'),
    // (NULL, '24-25', '', '2024-04-01', '2025-03-31', '1', '0', '0', '0', '0', '0'),
    // (NULL, '25-26', '', '2025-04-01', '2026-03-31', '1', '0', '0', '0', '0', '0'),
    // (NULL, '26-27', '', '2026-04-01', '2027-03-31', '1', '0', '0', '0', '0', '0');
    
    // INSERT INTO `suppliersTypeMaster` (`id`, `name`, `status`, `modifyBy`, `addedBy`, `dateAdded`, `modifyDate`, `deletestatus`) VALUES (NULL, 'TCS', '1', '', '', '', '', '0');

    // UPDATE `invoiceMaster` SET `invoiceFormat`='1' WHERE `id`!='0';


// UPDATE TOTAL PAX SLAB TABLE WITH ROOMS
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and deletestatus=0');
while($quotationData=mysqli_fetch_array($quotQuery)){

    $quotationId = clean($quotationData['id']);
    
    $adult = clean($quotationData['adult']);
    $child = clean($quotationData['child']);
    $infant = clean($quotationData['infant']);
    $sglRoom = clean($quotationData['sglRoom']);
    $dblRoom = clean($quotationData['dblRoom']);
    $twinRoom = clean($quotationData['twinRoom']);
    $tplRoom = clean($quotationData['tplRoom']);
    $quadNoofRoom = clean($quotationData['quadNoofRoom']);
    $sixNoofBedRoom = clean($quotationData['sixNoofBedRoom']);
    $eightNoofBedRoom = clean($quotationData['eightNoofBedRoom']);
    $tenNoofBedRoom = clean($quotationData['tenNoofBedRoom']);
    $teenNoofRoom = clean($quotationData['teenNoofRoom']);
    $ebedA = clean($quotationData['extraNoofBed']);
    $cwb = clean($quotationData['childwithNoofBed']);
    $cnb = clean($quotationData['childwithoutNoofBed']);

    $namevalue = 'adult="'.$adult.'",child="'.$child.'",infant="'.$infant.'",sglRoom="'.$sglRoom.'",dblRoom="'.$dblRoom.'",tplRoom="'.$tplRoom.'",twinRoom="'.$twinRoom.'",quadNoofRoom="'.$quadNoofRoom.'",sixNoofBedRoom="'.$sixNoofBedRoom.'",eightNoofBedRoom="'.$eightNoofBedRoom.'",tenNoofBedRoom="'.$tenNoofBedRoom.'",teenNoofRoom="'.$teenNoofRoom.'",extraNoofBed="'.$ebedA.'",childwithNoofBed="'.$cwb.'",childwithoutNoofBed="'.$cnb.'"';

    $where=' quotationId="'.$quotationId.'"';
    $update = updatelisting('totalPaxSlab',$namevalue,$where); 

}

// CASE - 7 : update invoice number to blank to set
// UPDATE `invoiceMaster` SET `proformaInvSq`=`id`,`taxInvSq`=`id` WHERE `proformaInvSq`= 0 and `taxInvSq`= 0;


// CASE - 8 : FLIGHT ISSUE
// 1.3 Existing flights all are showing as supplement flights and no of pax for new coding showing blank cols (totalAdult and totalChild)
// 1.3 Exsiting flights should be shown as package and no of pax should be updated with migrataion for cols (totalAdult and totalChild)
$quotM2Query='';
$quotM2Query=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and deletestatus=0');
while($quotM2Data=mysqli_fetch_array($quotM2Query)){

    $quotationId = clean($quotM2Data['id']);
    $adult = clean($quotM2Data['adult']);
    $child = clean($quotM2Data['child']);
    $infant = clean($quotM2Data['infant']);

    $namevalue = 'adult="'.$adult.'",child="'.$child.'",infant="'.$infant.'",totalAdult="'.$adult.'",totalChild="'.$child.'"';
    $where=' quotationId="'.$quotationId.'"';
    echo $update = updatelisting('quotationFlightMaster',$namevalue,$where); 
}

// update slab for services
$cnt = 1;
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 ');
while($quotationData=mysqli_fetch_array($quotQuery)){
    
    $quotationId = clean($quotationData['id']);
    
    $slabQuery='';
    $slabQuery=GetPageRecord('*','totalPaxSlab',' quotationId ="'.$quotationId.'" and status=1');
    $slabData=mysqli_fetch_array($slabQuery);
    $slabId = clean($slabData['id']);

    // guide
    if($quotationData['status']<>1){
        $update = updatelisting('quotationGuideMaster','slabId="'.$slabId.'"',' slabId=0 and quotationId="'.$quotationId.'"'); 
    }
    $update = updatelisting('quotationGuideMaster','isGuestType=1',' isGuestType=0 and quotationId="'.$quotationId.'"'); 

    // activity
    $update = updatelisting('quotationOtherActivitymaster','slabId="'.$slabId.'"',' slabId=0 and quotationId="'.$quotationId.'"'); 
    $update = updatelisting('finalQuoteActivity','slabId="'.$slabId.'"',' slabId=0 and quotationId="'.$quotationId.'"'); 
    // activity
    $update = updatelisting('quotationTransferMaster','isGuestType=1',' isGuestType=0 and quotationId="'.$quotationId.'"'); 
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

// COMMNON SCRIPT FROM INBOUND ***************************************************
// 2.1 to 2.2 remain issues 
// in quotation costsheet amount showing wronge enven payment request cost is right 
// 2. if quotation having multiple selected final slab than slabAndRoomType=1 and if single final slab then type is 2
$tpsQuery='';
$tpsQuery=GetPageRecord('*','totalPaxSlab',' 1 and status=1 group by quotationId order by id asc');
while($tpsData=mysqli_fetch_array($tpsQuery)){
    if(mysqli_num_rows($tpsQuery)>1){
        $slabAndRoomType=1; // multi slab
    }else{
        $slabAndRoomType=2; // single slab
    }
    $quotationId = clean($tpsData['quotationId']);

    echo 'slabAndRoomType="'.$slabAndRoomType.'"';
    echo $update = updatelisting(_QUOTATION_MASTER_,'slabAndRoomType="'.$slabAndRoomType.'"',' slabAndRoomType=0 and id="'.$quotationId.'"'); 

}


// 3. when migrate service wise markup Type showing 0 should be 1(%) or 2(flat)
$update = updatelisting('quotationServiceMarkup','hotelMarkupType=1',' hotelMarkupType=0');
$update = updatelisting('quotationServiceMarkup','guideMarkupType=1',' guideMarkupType=0');
$update = updatelisting('quotationServiceMarkup','activityMarkupType=1',' activityMarkupType=0');
$update = updatelisting('quotationServiceMarkup','entranceMarkupType=1',' entranceMarkupType=0');
$update = updatelisting('quotationServiceMarkup','transferMarkupType=1',' transferMarkupType=0');
$update = updatelisting('quotationServiceMarkup','trainMarkupType=1',' trainMarkupType=0');
$update = updatelisting('quotationServiceMarkup','flightMarkupType=1',' flightMarkupType=0');
$update = updatelisting('quotationServiceMarkup','restaurantMarkupType=1',' restaurantMarkupType=0');
$update = updatelisting('quotationServiceMarkup','otherMarkupType=1',' otherMarkupType=0');
$update = updatelisting('quotationServiceMarkup','ferryMarkupType=1',' ferryMarkupType=0');
$update = updatelisting('quotationServiceMarkup','visaMarkupType=1',' visaMarkupType=0');
$update = updatelisting('quotationServiceMarkup','passportMarkupType=1',' passportMarkupType=0');
$update = updatelisting('quotationServiceMarkup','insuranceMarkupType=1',' insuranceMarkupType=0');

 

// QUOTATION LEVEL NEED TO UPDATE CURRENCY VALUE ROE TO ALL SERVICES
$hotelQuery='';
$hotelQuery=GetPageRecord('*','quotationHotelMaster',' 1 and currencyValue=0');
while($hotelData=mysqli_fetch_array($hotelQuery)){
    if(!empty($hotelData['currencyId']) && $hotelData['currencyId']!=0 ){
        $currencyId = trim($hotelData['currencyId']);
        $currencyValue = getCurrencyVal($hotelData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($hotelData['currencyValue']==0 && $currencyValue>0){
        echo 'hotelData<br>';
        updatelisting('quotationHotelMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$hotelData['id'].'"'); 
    }
}

$flightQuery='';
$flightQuery=GetPageRecord('*','quotationFlightMaster',' 1 and currencyValue=0');
while($flightData=mysqli_fetch_array($flightQuery)){
    if(!empty($flightData['currencyId']) && $flightData['currencyId']!=0 ){
        $currencyId = trim($flightData['currencyId']);
        $currencyValue = getCurrencyVal($flightData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($flightData['currencyValue']==0 && $currencyValue>0){
        echo 'flightData<br>';
        updatelisting('quotationFlightMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$flightData['id'].'"'); 
    }

}

$trainQuery='';
$trainQuery=GetPageRecord('*','quotationTrainsMaster',' 1 and currencyValue=0');
while($trainData=mysqli_fetch_array($trainQuery)){
    if(!empty($trainData['currencyId']) && $trainData['currencyId']!=0 ){
        $currencyId = trim($trainData['currencyId']);
        $currencyValue = getCurrencyVal($trainData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($trainData['currencyValue']==0 && $currencyValue>0){
        echo 'trainData<br>';
        updatelisting('quotationTrainsMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$trainData['id'].'"'); 
    }

}

$transferQuery='';
$transferQuery=GetPageRecord('*','quotationTransferMaster',' 1 and currencyValue=0');
while($transferData=mysqli_fetch_array($transferQuery)){
    if(!empty($transferData['currencyId']) && $transferData['currencyId']!=0 ){
        $currencyId = trim($transferData['currencyId']);
        $currencyValue = getCurrencyVal($transferData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($transferData['currencyValue']==0 && $currencyValue>0){
        echo 'transferData<br>';
        updatelisting('quotationTransferMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$transferData['id'].'"'); 
    }
}

$ferryQuery='';
$ferryQuery=GetPageRecord('*','quotationFerryMaster',' 1 and currencyValue=0');
while($ferryData=mysqli_fetch_array($ferryQuery)){
    if(!empty($ferryData['currencyId']) && $ferryData['currencyId']!=0 ){
        $currencyId = trim($ferryData['currencyId']);
        $currencyValue = getCurrencyVal($ferryData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($ferryData['currencyValue']==0 && $currencyValue>0){
        echo 'ferryData<br>';
        updatelisting('quotationFerryMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$ferryData['id'].'"'); 
    }
}

$actiQuery='';
$actiQuery=GetPageRecord('*','quotationOtherActivitymaster',' 1 and currencyValue=0');
while($actiData=mysqli_fetch_array($actiQuery)){
    if(!empty($actiData['currencyId']) && $actiData['currencyId']!=0 ){
        $currencyId = trim($actiData['currencyId']);
        $currencyValue = getCurrencyVal($actiData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($actiData['currencyValue']==0 && $currencyValue>0){
        echo 'actiData<br>';
        updatelisting('quotationOtherActivitymaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$actiData['id'].'"'); 
    }

}

$guideQuery='';
$guideQuery=GetPageRecord('*','quotationGuideMaster',' 1 and currencyValue=0');
while($guideData=mysqli_fetch_array($guideQuery)){
    if(!empty($guideData['currencyId']) && $guideData['currencyId']!=0 ){
        $currencyId = trim($guideData['currencyId']);
        $currencyValue = getCurrencyVal($guideData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($guideData['currencyValue']==0 && $currencyValue>0){
        echo 'guideData<br>';
        updatelisting('quotationGuideMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$guideData['id'].'"'); 
    }
}

// costType
$extraQuery='';
$extraQuery=GetPageRecord('*','quotationExtraMaster',' 1 and currencyValue=0');
while($extraData=mysqli_fetch_array($extraQuery)){
    if(!empty($extraData['currencyId']) && $extraData['currencyId']!=0 ){
        $currencyId = trim($extraData['currencyId']);
        $currencyValue = getCurrencyVal($extraData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($extraData['currencyValue']==0 && $currencyValue>0){
        echo 'extraData<br>';
        updatelisting('quotationExtraMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$extraData['id'].'"'); 
    }
} 

$mealQuery='';
$mealQuery=GetPageRecord('*','quotationInboundmealplanmaster',' 1 and currencyValue=0');
while($mealData=mysqli_fetch_array($mealQuery)){
    if(!empty($mealData['currencyId']) && $mealData['currencyId']!=0 ){
        $currencyId = trim($mealData['currencyId']);
        $currencyValue = getCurrencyVal($mealData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($mealData['currencyValue']==0 && $currencyValue>0){
        echo 'mealData<br>';
        updatelisting('quotationInboundmealplanmaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$mealData['id'].'"'); 
    }
}

$entranceQuery='';
$entranceQuery=GetPageRecord('*','quotationEntranceMaster',' 1 and currencyValue=0');
while($entranceData=mysqli_fetch_array($entranceQuery)){
    if(!empty($entranceData['currencyId']) && $entranceData['currencyId']!=0 ){
        $currencyId = trim($entranceData['currencyId']);
        $currencyValue = getCurrencyVal($entranceData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($entranceData['currencyValue']==0 && $currencyValue>0){
        echo 'entranceData<br>';
        updatelisting('quotationEntranceMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$entranceData['id'].'"'); 
    }
}

$enrtQuery='';
$enrtQuery=GetPageRecord('*','quotationEnrouteMaster',' 1 and currencyValue=0');
while($enrtData=mysqli_fetch_array($enrtQuery)){
    if(!empty($enrtData['currencyId']) && $enrtData['currencyId']!=0 ){
        $currencyId = trim($enrtData['currencyId']);
        $currencyValue = getCurrencyVal($enrtData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($enrtData['currencyValue']==0 && $currencyValue>0){
        echo 'enrtData<br>';
        updatelisting('quotationEnrouteMaster', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$enrtData['id'].'"'); 
    }

}


$f_hotelQuery='';
$f_hotelQuery=GetPageRecord('*','finalQuote',' 1 and currencyValue=0');
while($f_hotelData=mysqli_fetch_array($f_hotelQuery)){
    if(!empty($f_hotelData['currencyId']) && $f_hotelData['currencyId']!=0 ){
        $currencyId = trim($f_hotelData['currencyId']);
        $currencyValue = getCurrencyVal($f_hotelData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_hotelData['currencyValue']==0 && $currencyValue>0){
        echo 'f_hotelData<br>';
        updatelisting('finalQuote', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_hotelData['id'].'"'); 
    }
}

$f_flightQuery='';
$f_flightQuery=GetPageRecord('*','finalQuoteFlights',' 1 and currencyValue=0');
while($f_flightData=mysqli_fetch_array($f_flightQuery)){
    if(!empty($f_flightData['currencyId']) && $f_flightData['currencyId']!=0 ){
        $currencyId = trim($f_flightData['currencyId']);
        $currencyValue = getCurrencyVal($f_flightData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_flightData['currencyValue']==0 && $currencyValue>0){
        echo 'f_flightData<br>';
        updatelisting('finalQuoteFlights', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_flightData['id'].'"'); 
    }
}

$f_trainQuery='';
$f_trainQuery=GetPageRecord('*','finalQuoteTrains',' 1 and currencyValue=0');
while($f_trainData=mysqli_fetch_array($f_trainQuery)){
    if(!empty($f_trainData['currencyId']) && $f_trainData['currencyId']!=0 ){
        $currencyId = trim($f_trainData['currencyId']);
        $currencyValue = getCurrencyVal($f_trainData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_trainData['currencyValue']==0 && $currencyValue>0){
        echo 'f_trainData<br>';
        updatelisting('finalQuoteTrains', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_trainData['id'].'"'); 
    }
}

$f_transferQuery='';
$f_transferQuery=GetPageRecord('*','finalQuotetransfer',' 1 and currencyValue=0');
while($f_transferData=mysqli_fetch_array($f_transferQuery)){
    if(!empty($f_transferData['currencyId']) && $f_transferData['currencyId']!=0 ){
        $currencyId = trim($f_transferData['currencyId']);
        $currencyValue = getCurrencyVal($f_transferData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_transferData['currencyValue']==0 && $currencyValue>0){
        echo 'f_transferData<br>';
        updatelisting('finalQuotetransfer', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_transferData['id'].'"'); 
    }
}

$f_ferryQuery='';
$f_ferryQuery=GetPageRecord('*','finalQuoteFerry',' 1 and currencyValue=0');
while($f_ferryData=mysqli_fetch_array($f_ferryQuery)){
    if(!empty($f_ferryData['currencyId']) && $f_ferryData['currencyId']!=0 ){
        $currencyId = trim($f_ferryData['currencyId']);
        $currencyValue = getCurrencyVal($f_ferryData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_ferryData['currencyValue']==0 && $currencyValue>0){
        echo 'f_ferryData<br>';
        updatelisting('finalQuoteFerry', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_ferryData['id'].'"'); 
    }
}

$f_mealQuery='';
$f_mealQuery=GetPageRecord('*','finalQuoteMealPlan',' 1 and currencyValue=0');
while($f_mealData=mysqli_fetch_array($f_mealQuery)){
    if(!empty($f_mealData['currencyId']) && $f_mealData['currencyId']!=0 ){
        $currencyId = trim($f_mealData['currencyId']);
        $currencyValue = getCurrencyVal($f_mealData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_mealData['currencyValue']==0 && $currencyValue>0){
        echo 'f_mealData<br>';
        updatelisting('finalQuoteMealPlan', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_mealData['id'].'"'); 
    }
}

$f_guideQuery='';
$f_guideQuery=GetPageRecord('*','finalQuoteGuides',' 1 and currencyValue=0');
while($f_guideData=mysqli_fetch_array($f_guideQuery)){
    if(!empty($f_guideData['currencyId']) && $f_guideData['currencyId']!=0 ){
        $currencyId = trim($f_guideData['currencyId']);
        $currencyValue = getCurrencyVal($f_guideData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_guideData['currencyValue']==0 && $currencyValue>0){
        echo 'f_guideData<br>';
        updatelisting('finalQuoteGuides', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_guideData['id'].'"'); 
    }
}

$f_activityQuery='';
$f_activityQuery=GetPageRecord('*','finalQuoteActivity',' 1 and currencyValue=0');
while($f_activityData=mysqli_fetch_array($f_activityQuery)){
    if(!empty($f_activityData['currencyId']) && $f_activityData['currencyId']!=0 ){
        $currencyId = trim($f_activityData['currencyId']);
        $currencyValue = getCurrencyVal($f_activityData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_activityData['currencyValue']==0 && $currencyValue>0){
        echo 'f_activityData<br>';
        updatelisting('finalQuoteActivity', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_activityData['id'].'"'); 
    }
}

$f_enrtQuery='';
$f_enrtQuery=GetPageRecord('*','finalQuoteEnroute',' 1 and currencyValue=0');
while($f_enrtData=mysqli_fetch_array($f_enrtQuery)){
    if(!empty($f_enrtData['currencyId']) && $f_enrtData['currencyId']!=0 ){
        $currencyId = trim($f_enrtData['currencyId']);
        $currencyValue = getCurrencyVal($f_enrtData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_enrtData['currencyValue']==0 && $currencyValue>0){
        echo 'f_enrtData<br>';
        updatelisting('finalQuoteEnroute', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_enrtData['id'].'"'); 
    }
}

$f_entranceQuery='';
$f_entranceQuery=GetPageRecord('*','finalQuoteEntrance',' 1 and currencyValue=0');
while($f_entranceData=mysqli_fetch_array($f_entranceQuery)){
    if(!empty($f_entranceData['currencyId']) && $f_entranceData['currencyId']!=0 ){
        $currencyId = trim($f_entranceData['currencyId']);
        $currencyValue = getCurrencyVal($f_entranceData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_entranceData['currencyValue']==0 && $currencyValue>0){
        echo 'f_entranceData<br>';
        updatelisting('finalQuoteEntrance', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_entranceData['id'].'"'); 
    }
}

$f_extraQuery='';
$f_extraQuery=GetPageRecord('*','finalQuoteExtra',' 1 and currencyValue=0');
while($f_extraData=mysqli_fetch_array($f_extraQuery)){
    if(!empty($f_extraData['currencyId']) && $f_extraData['currencyId']!=0 ){
        $currencyId = trim($f_extraData['currencyId']);
        $currencyValue = getCurrencyVal($f_extraData['currencyId']);
    }else{
        $currencyId = $baseCurrencyId;
        $currencyValue = $baseCurrencyVal;
    }
    if($f_extraData['currencyValue']==0 && $currencyValue>0){
        echo 'f_extraData<br>';
        updatelisting('finalQuoteExtra', 'currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'"', ' id="'.$f_extraData['id'].'"'); 
    }
}

die();
// new finance upgrade and migrate data from old finance system to new one.
$quotQuery='';
$quotQuery=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,' quotationId in ( select id from quotationMaster where 1 and status=1 ) and deletestatus=0 order by id asc');
while($prmData=mysqli_fetch_array($quotQuery)){

    $quotationId = trim($prmData['quotationId']);
    $queryId = trim($prmData['queryid']);

    // agent payments
    $aprSql='quotationId="'.$quotationId.'" and paymentId="'.$prmData['id'].'"'; 
    $aprQuery=GetPageRecord('*',_AGENT_PAYMENT_REQUEST_,$aprSql); 
    $aprData=mysqli_fetch_array($aprQuery);

    $namevalue1 ='paymentId="'.$prmData['id'].'"';   
    updatelisting('agentSchedulePaymentMaster',$namevalue1,'agentPaymentId="'.clean($aprData['id']).'"');  

    $namevalue2 ='paymentId="'.$prmData['id'].'"';   
    updatelisting('agentPaymentMaster',$namevalue2,'agentPaymentId="'.clean($aprData['id']).'"');  


    //  quotation
    $quotationQuery='';   
    $quotationQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
    $quotationData=mysqli_fetch_array($quotationQuery); 

    $rs='';   
    $rs=GetPageRecord('*',_INVOICE_MASTER_,' quotationId="'.$quotationId.'" and fileNo!=""'); 
    $invmData=mysqli_fetch_array($rs); 


    $dateAdded=time();
    $totalCompanyCost = $quotationData['totalCompanyCost'];
     
    $totalMarkupCost = $quotationData['totalMarkupCost'];
    $totalISOCost = $quotationData['totalISOCost'];
    $totalConsortiaCost = $quotationData['totalConsortiaCost'];
    $totalClientCommCost = $quotationData['totalClientCommCost'];
    $totalDiscountCost = $quotationData['totalDiscountCost'];
    
    // without tcs and gst cost client
    $totalClientCostWithMarkup2 = trim($quotationData['totalCompanyCost']+$quotationData['totalMarkupCost']);
    $totalClientCostWithMarkup = ($aprData['reqclientCost']>0)?$aprData['reqclientCost']:$totalClientCostWithMarkup2; 
    
    // total client cost 
    $totalClientCost2 = ($aprData['finalCost']>0)?$aprData['finalCost']:$invmData['amount'];
    $totalClientCost = ($totalClientCost2>0)?$totalClientCost2:$quotationData['totalQuotCost'];
      
    // serviceTax and cost
    if($invmData['igst']>0){
        echo $totalServiceTaxCost2 = $invmData['igst']; 
    }else{
        $totalServiceTaxCost2 = round($invmData['cgst']+$invmData['stg']); 
    } 
    $totalServiceTaxCost = ($totalServiceTaxCost2>0)?$totalServiceTaxCost2:$quotationData['totalServiceTaxCost'];  
    $serviceTax = ($aprData['reqclientGst']>0)?$aprData['reqclientGst']:$quotationData['serviceTax'];
    if($serviceTax == 0){
        $totalServiceTaxCost = 0;
    }
    
    // tcs and cost
    $totalTCSCost = ($invmData['tcs']>0)?$invmData['tcs']:$quotationData['totalTCSCost'];  
    $tcsTax = ($aprData['reqclientTCS']>0)?$aprData['reqclientTCS']:$quotationData['tcsTax'];
    if($tcsTax == 0){
        $totalTCSCost = 0;
    }
    
    $sglBasisCost = $quotationData['sglBasisCost'];
    $dblBasisCost = $quotationData['dblBasisCost'];
    $twinCost = $quotationData['twinCost'];
    $tplBasisCost = $quotationData['tplBasisCost'];
    $extraAdultCost = $quotationData['extraAdultCost'];
    $CWBCost = $quotationData['CWBCost'];
    $CNBCost = $quotationData['CNBCost'];

    $currencyId = $quotationData['currencyId'];
    $commissionType = $quotationData['commissionType'];
    $ISOCommission = $quotationData['ISOCommission'];
    $ConsortiaCommission = $quotationData['ConsortiaCommission'];
    $ClientCommission = $quotationData['ClientCommission'];
    $discountType = $quotationData['discountType'];
    $discount = $quotationData['discount'];

    // Original cost store into this table after final 
    $namevalue3='totalCompanyCost = "'.$totalCompanyCost.'", totalClientCost = "'.$totalClientCost.'", totalClientCostWithMarkup = "'.$totalClientCostWithMarkup.'", totalMarkupCost = "'.$totalMarkupCost.'", totalISOCost = "'.$totalISOCost.'", totalConsortiaCost = "'.$totalConsortiaCost.'", totalClientCommCost = "'.$totalClientCommCost.'", totalDiscountCost = "'.$totalDiscountCost.'", totalServiceTaxCost = "'.$totalServiceTaxCost.'", totalTCSCost = "'.$totalTCSCost.'", sglBasisCost = "'.$sglBasisCost.'", dblBasisCost = "'.$dblBasisCost.'", twinCost = "'.$twinCost.'", tplBasisCost = "'.$tplBasisCost.'", extraAdultCost = "'.$extraAdultCost.'", CWBCost = "'.$CWBCost.'", CNBCost = "'.$CNBCost.'", currencyId = "'.$currencyId.'", serviceTax = "'.$serviceTax.'", tcsTax = "'.$tcsTax.'", commissionType = "'.$commissionType.'", ISOCommission = "'.$ISOCommission.'", ConsortiaCommission = "'.$ConsortiaCommission.'", ClientCommission = "'.$ClientCommission.'", discountType = "'.$discountType.'", discount = "'.$discount.'"';
    echo updatelisting(_PAYMENT_REQUEST_MASTER_,$namevalue3,'id="'.clean($prmData['id']).'"');  
    echo '<br>';
} 
die();
 
// rates default values


// CASE - 1 : All existing rate of transfer/TPT should show in PVT tansfer type
$tptQuery='';
$tptQuery=GetPageRecord('*','dmctransferRate',' 1 and transferType=0');
while($dmcTransferData=mysqli_fetch_array($tptQuery)){
     
    if($dmcTransferData['transferType']==0){
        echo 'dmcTransferData<br>';
        updatelisting('dmctransferRate', 'transferType=2', ' transferType=0 and id="'.$dmcTransferData['id'].'"'); 
    }
}

// CASE - 2 : All existing rate of monument should show in Ticket only
$entQuery='';
$entQuery=GetPageRecord('*','dmcentranceRate',' 1 ');
while($dmcEntData=mysqli_fetch_array($entQuery)){
     
    echo 'dmcEntData - Ticket Only<br>';
    updatelisting('dmcentranceRate', 'transferType=3', ' id="'.$dmcEntData['id'].'"'); 
}

// CASE - 3 : All existing rate of activity should show in Ticket only
$actQuery='';
$actQuery=GetPageRecord('*','dmcotherActivityRate',' 1 ');
while($dmcActData=mysqli_fetch_array($actQuery)){
     
    echo 'dmcActData - Ticket Only<br>';
    updatelisting('dmcotherActivityRate', 'transferType=4', ' transferType=0 and id="'.$dmcActData['id'].'"'); 
}  
     


// CASEE - 11 : Update all entrance services packageBuilderEntranceMaster tptType=3 ticketOnly
updatelisting('packageBuilderEntranceMaster', 'tptType=3', ' tptType=0'); 
updatelisting('quotationEntranceMaster', 'transferType=3', ' 1 '); 
updatelisting('finalQuoteEntrance', 'transferType=3', ' 1 '); 

// CASEE - 12 : Update all activity services packageBuilderotherActivityMaster transferType=4 ticketOnly
updatelisting('packageBuilderotherActivityMaster', 'transferType=4', ' transferType=0'); 


// costType
// CASEE - 12 : Update all additional costType=2 if group cost
// udate child cost too beacuase prevousel we have only adultcost as a perperson
$extraQuery='';
$extraQuery=GetPageRecord('*','quotationExtraMaster',' 1 ');
while($extraData=mysqli_fetch_array($extraQuery)){
    if(!empty($extraData['groupCost']) && $extraData['groupCost']!='undefined' ){
        $adultCost = $childCost = 0;
        $groupCost = $extraData['groupCost'];
        $costType = 2;
    }else{
        $groupCost = 0;
        $adultCost = $childCost = $extraData['adultCost'];
        $costType = 1;
    } 
    echo 'extraData<br>';
    updatelisting('quotationExtraMaster', 'costType="'.$costType.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",groupCost="'.$groupCost.'"', ' id="'.$extraData['id'].'"'); 
    
}   

// CASEE - 14 : AS we make all the prevoius cost in ticketOnly then move perPaxCost to ticketAdultCsot ,child, and infantticketcost
updatelisting('quotationOtherActivitymaster', 'transferType=4', ' 1 '); 
updatelisting('finalQuoteActivity', 'transferType=4', ' 1 '); 

$actQuery='';
$actQuery=GetPageRecord('*','quotationOtherActivitymaster',' 1 and perPaxCost>0 and transferType=4');
while($actData=mysqli_fetch_array($actQuery)){
    
    $rsp='';
    $rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$actData['quotationId'].'"');
    $quotationData=mysqli_fetch_array($rsp);
    
    $totalPax = 0;
     
    $totalPax = ($quotationData['adult'] + $quotationData['child']);
    if($totalPax == 0){
        $totalPax =  2;
    }
    
    if ($actData['maxpax']>=$totalPax) { 
        $perPaxCost = round($actData['activityCost'] / $totalPax);
    } else {
        $perPaxCost = $actData['perPaxCost'];
    }
     
    $ticketAdultCost = $ticketchildCost = $ticketinfantCost = $perPaxCost;
    
    // echo 'actData<br>';
    updatelisting('quotationOtherActivitymaster', 'ticketAdultCost="'.$ticketAdultCost.'",ticketchildCost="'.$ticketchildCost.'",ticketinfantCost="'.$ticketinfantCost.'"', ' id="'.$actData['id'].'"'); 
    
} 
 
// CASEE - 10 : Update all transfer destination in rateDestination if rateDestintion is empty
$transfQuery='';
$transfQuery=GetPageRecord('*','packageBuilderTransportMaster',' 1 ');
while($transferData=mysqli_fetch_array($transfQuery)){
    $rateDestinationId = 0;
    if(!empty($transferData['destinationId'])){
        $rateDestinationId = $transferData['destinationId'];
    }else{
        $destQuery='';
        $destQuery=GetPageRecord('*',_DESTINATION_MASTER_,' 1 and name="'.$transferData['transferCity'].'" ');
        $destData=mysqli_fetch_array($destQuery);
        $rateDestinationId = $destData['id'];
    }
    if($rateDestinationId>0){
        updatelisting('dmctransferRate', 'rateDestinationId="'.$rateDestinationId.'"', ' transferNameId="'.$transferData['id'].'" and rateDestinationId=0'); 
    }
}
//  14 UPDATE ALL DAY FRM TO DAY TO VALUE WHERE NOT FILLED

$ab=GetPageRecord('*','quotationTransferMaster',' 1 and id in ( select serviceId from quotationItinerary where serviceType="transportation" ) and startDay=0  ORDER BY `id` DESC limit 0, 2000');
while($tptData=mysqli_fetch_array($ab)){  
    
    $starDay=1;
    $a=GetPageRecord('*','newQuotationDays',' quotationId="'.$tptData['quotationId'].'"  and addstatus=0 order by id asc');
    while($QueryDaysData=mysqli_fetch_array($a)){
        if($QueryDaysData['srdate'] == $tptData['fromDate']){
            
            break;
        }
        $starDay++;
    } 
    
    $endDay=1;
    $a=GetPageRecord('*','newQuotationDays',' quotationId="'.$tptData['quotationId'].'"  and addstatus=0 order by id asc');
    while($QueryDaysData=mysqli_fetch_array($a)){
        if($QueryDaysData['srdate'] == $tptData['toDate']){
            
            break;
        }
        $endDay++;
    }
    
    // noOfDays
    // startDate
    // endDate
    // update
    echo updatelisting('quotationTransferMaster', 'startDay="'.$starDay.'",endDay="'.$endDay.'"', ' id="'.$tptData['id'].'"'); 
    // updatelisting('quotationTransferMaster', 'startDay="'.$starDay.'",endDay="'.$endDay.'"', ' id=17926'); 
 
}



// CASEE 3 
// update costsheet 
$invQuery='';   
$invQuery=GetPageRecord('*',_INVOICE_MASTER_,' fileNo!="" group by quotationId order by id asc limit 500, 100'); 
echo mysqli_num_rows($invQuery);
while($invmData=mysqli_fetch_array($invQuery)){ 
    $quotationId = clean($invmData['quotationId']);
    ?>
    <a target="_blank" href="loadCostSheet.php?quotationId=<?php echo $quotationId; ?>&finalcategory=0">View Costsheet</a><br>
    <?php
}  
?> 
<script type='text/javascript'>
    function prepareLinks() {
        var links = document.getElementsByTagName('a');
        for(var i=0; i<links.length; i++) {
            var thisLink = links[i]; 
            window.open(thisLink.href, '_blank');
        }
    }
    window.onload = function(){
        prepareLinks();
    }
</script>
<?php
echo 'done';
die();

 
die();
// UPDATE CALCULATION TYPE  
$quotQuery='';
$quotQuery=GetPageRecord('*','quotationMaster2',' 1  ');
while($quotationData=mysqli_fetch_array($quotQuery)){
    echo $quotationData['id'];
  $namevalue = 'inclusion="'.addslashes($quotationData['inclusion']).'",exclusion="'.addslashes($quotationData['exclusion']).'",overviewText="'.addslashes($quotationData['overviewText']).'",highlightsText="'.addslashes($quotationData['highlightsText']).'",tncText="'.addslashes($quotationData['tncText']).'",specialText="'.addslashes($quotationData['specialText']).'"';
  echo $update = updatelisting(_QUOTATION_MASTER_,$namevalue,' id="'.$quotationData['id'].'"'); 

}
 
 
die();
// UPDATE CALCULATION TYPE  
$quotQuery='';
$quotQuery=GetPageRecord('*','newQuotationDays2',' 1 and id>30000 and id<=35000');
while($quotationData=mysqli_fetch_array($quotQuery)){ 
  $namevalue = 'title="'.addslashes($quotationData['title']).'",description="'.addslashes($quotationData['description']).'"';
  echo $update = updatelisting('newQuotationDays',$namevalue,' id="'.$quotationData['id'].'"'); 

}
 