<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$guestId = $_REQUEST['guestId'];

if($guestId!=""){
   
    $json_result = array();
    
    $res1 = GetPageRecord('*','mice_guestListMaster','id="'.$guestId.'" order by id asc');
		$fetchData1 =mysqli_fetch_assoc($res1);
		$queryId =$fetchData1['queryId'];
		$name =$fetchData1['guest_first_name'].' '.$fetchData1['last_name'];

		
		 $selectQuery = 'SELECT * FROM assignFlightGuestMaster WHERE guestid="' .$guestId. '" and queryId ="'.$queryId.'" ';
        $fetch = mysqli_query(db(), $selectQuery);
        $emailRes1 = mysqli_fetch_assoc($fetch);
        $flightId =$emailRes1['flight_FQId'];
        $arrivalToStr =$emailRes1['arrivalToStr'];
        $departureFromStr =$emailRes1['departureFromStr'];
        $arrivalDate =$emailRes1['arrivalDate'];
        $flightName =$emailRes1['flightName'];
        $flightNumber =$emailRes1['flightNumber'];
        $newArrivelDateFormat =date('d-m-Y',strtotime($arrivalDate));
        $newArrivelTimeFormat = date('h:i:A', strtotime($arrivalDate));
        // $newDateTimeFormat1 = $newArrivelDateFormat. ' ' .$newArrivelTimeFormat;
        
        $departureDate =$emailRes1['departureDate'];
        $newDateFormat =date('d-m-Y',strtotime($departureDate));
        $newTimeFormat = date('h:i:A', strtotime($departureDate));
        // $newDateTimeFormat2 = $newDateFormat . ' ' . $newTimeFormat;


        // print_r($newDateTimeFormat1);exit();
		
		 $res2 = GetPageRecord('*','packageBuilderAirlinesMaster','id="'.$flightId.'" order by id asc');
		$fetchData2 =mysqli_fetch_assoc($res2);
// 		$flightName =$fetchData2['flightName'];
		
    
   
                $json_result[] = array(
                    "queryid" => $queryId,
                    "guestid" => $guestId,
                    "name" => $name,
                    "flightimage" => "",
                    "flightname" => $flightName,
                    "flightNumber" => $flightNumber,
                    "arrivalTo" =>$arrivalToStr,
                    "departureFrom" =>$departureFromStr, 
                    "arrivalDate" => $newArrivelDateFormat,
                    "arrivalTime" => $newArrivelTimeFormat,
                    "departureDate" => $newDateFormat,
                    "departureTime" => $newTimeFormat
                );
           }else {
        $json_result[] = array(
            "error" => "Please insert guest Id",
        );
    }
echo json_encode(array(
    "status" => "true",
    "result" => $json_result
));


?>
