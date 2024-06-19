<?php
ob_start();
include "inc.php";
include "config/logincheck.php";
ini_set('post_max_size', '10M');
ini_set('upload_max_filesize', '10M');




$flightQuery=GetPageRecord('*','finalQuoteFlights',' 1 '); 
while($finalQuoteFlights=mysqli_fetch_array($flightQuery)){
	$c="";
	$c=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightQuotationId'].'"'); 
	$flightQuoteData=mysqli_fetch_array($c);

	 $namevalue ='departureFrom="'.$flightQuoteData['departureFrom'].'",arrivalTo="'.$flightQuoteData['arrivalTo'].'",flightNumber="'.$flightQuoteData['flightNumber'].'",flightClass="'.$flightQuoteData['flightClass'].'",departureTime="'.$flightQuoteData['departureTime'].'",arrivalTime="'.$flightQuoteData['arrivalTime'].'",departureDate="'.$flightQuoteData['departureDate'].'",arrivalDate="'.$flightQuoteData['arrivalDate'].'"';

	 $where='id="'.$finalQuoteFlights['id'].'"';
	$update = updatelisting('finalQuoteFlights',$namevalue,$where);


}


$trainQuery=GetPageRecord('*','finalQuoteTrains',' 1 '); 
while($finalQuoteTrain=mysqli_fetch_array($trainQuery)){
	
	$c="";
	$c=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'id="'.$finalQuoteTrain['trainQuotationId'].'"'); 
	$trainQuotData=mysqli_fetch_array($c);

	$namevalue ='departureFrom="'.$trainQuotData['departureFrom'].'",arrivalTo="'.$trainQuotData['arrivalTo'].'",trainNumber="'.$trainQuotData['trainNumber'].'",trainClass="'.$trainQuotData['trainClass'].'",departureTime="'.$trainQuotData['departureTime'].'",arrivalTime="'.$trainQuotData['arrivalTime'].'",journeyType="'.$trainQuotData['journeyType'].'",departureDate="'.$trainQuotData['departureDate'].'",arrivalDate="'.$trainQuotData['arrivalDate'].'"';

	$where='id="'.$finalQuoteTrain['id'].'"';
	$update = updatelisting('finalQuoteTrains',$namevalue,$where);

}
echo "updated";