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
    }
}

// UPDATE CALCULATION TYPE 
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and calculationType=0');
while($quotationData=mysqli_fetch_array($quotQuery)){

  $namevalue = 'calculationType=1';
  $update = updatelisting(_QUOTATION_MASTER_,$namevalue,' quotationId="'.$quotationData['id'].'"'); 

}

// UPDATE DAY WISE IN QUOTATIONS
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and dayWise=0');
while($quotationData=mysqli_fetch_array($quotQuery)){

    $namevalue = 'dayWise=1';
    $update = updatelisting(_QUOTATION_MASTER_,$namevalue,' quotationId="'.$quotationData['id'].'"'); 

}
// UPDATE TRAVEL TYPE IN QUOTATIONS
$quotQuery='';
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and travelType=0');
while($quotationData=mysqli_fetch_array($quotQuery)){

    $namevalue = 'travelType=1';
    $update = updatelisting(_QUOTATION_MASTER_,$namevalue,' quotationId="'.$quotationData['id'].'"'); 

}
// Migration to new currency conversion method


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

// need to uppdate roe in all service tooked in quotation 
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



// new finance upgrade and migrate data from old finance system to new one.
$quotQuery='';
$quotQuery=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,' quotationId in ( select id from quotationMaster where 1 and status=1 ) and deletestatus=0 order by id asc');
while($prmData=mysqli_fetch_array($quotQuery)){

    $quotationId = trim($prmData['quotationId']);
    $queryId = trim($prmData['queryid']);

    // agent payments
    $aprSql='queryId="'.$queryData['id'].'" and paymentId="'.$prmData['id'].'"'; 
    $aprQuery=GetPageRecord('id',_AGENT_PAYMENT_REQUEST_,$aprSql); 
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
    $rs=GetPageRecord('*',_INVOICE_MASTER_,' quotationId="'.$quotationId.'"'); 
    $invmData=mysqli_fetch_array($rs); 


    $dateAdded=time();
    $totalCompanyCost = $quotationData['totalCompanyCost'];
    $totalClientCost = ($invmData['totalamount']>0)?$invmData['totalamount']:$quotationData['totalQuotCost'];
    $totalClientCostWithMarkup2 = trim($quotationData['totalCompanyCost']+$quotationData['totalMarkupCost']);

    $totalClientCostWithMarkup = ($invmData['amount']>0)?$invmData['amount']:$totalClientCostWithMarkup2;

    $totalMarkupCost = $quotationData['totalMarkupCost'];
    $totalISOCost = $quotationData['totalISOCost'];
    $totalConsortiaCost = $quotationData['totalConsortiaCost'];
    $totalClientCommCost = $quotationData['totalClientCommCost'];
    $totalDiscountCost = $quotationData['totalDiscountCost'];

    if($invmData['igst']>0){
        $totalServiceTaxCost2 = $invmData['igst']; 
    }else{
        $totalServiceTaxCost2 = round($invmData['cgst']+$invmData['stg']); 
    }
    $totalServiceTaxCost = ($totalServiceTaxCost2>0)?$totalServiceTaxCost2:$quotationData['totalServiceTaxCost'];

    $totalTCSCost = ($invmData['tcs']>0)?$invmData['tcs']:$quotationData['totalTCSCost'];
    // $totalTCSCost = $quotationData['totalTCSCost'];

    $sglBasisCost = $quotationData['sglBasisCost'];
    $dblBasisCost = $quotationData['dblBasisCost'];
    $twinCost = $quotationData['twinCost'];
    $tplBasisCost = $quotationData['tplBasisCost'];
    $extraAdultCost = $quotationData['extraAdultCost'];
    $CWBCost = $quotationData['CWBCost'];
    $CNBCost = $quotationData['CNBCost'];

    $currencyId = $quotationData['currencyId'];
    $serviceTax = $quotationData['serviceTax'];
    $tcsTax = $quotationData['tcsTax'];
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

