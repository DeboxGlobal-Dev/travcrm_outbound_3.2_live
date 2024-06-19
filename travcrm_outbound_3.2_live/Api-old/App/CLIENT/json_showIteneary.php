<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$refid = $_REQUEST['Refid'];
$json_result = array();

if($refid!=""){
   
        $selectQuery = 'SELECT * FROM queryMaster WHERE referanceNumber="'.$refid .'" ';
        $fetch = mysqli_query(db(), $selectQuery);
        $queryId =mysqli_fetch_assoc($fetch);
        
         $selectQuery1 = 'SELECT * FROM quotationHotelMaster WHERE queryId="'.$queryId['id'] .'"';
        $fetch1 = mysqli_query(db(), $selectQuery1);
        $quotationId=[];
        $a=1;
       while ($queryId1 = mysqli_fetch_assoc($fetch1)) {
        $quotationId=$queryId1['quotationId'];
        $roomtypeId =$queryId1['roomType'];
        $mealPlan =$queryId1['mealPlan'];
        $apiurl=1;
        $voucher = $fullurl.'loadcreatevoucher_client.php?module=ClientVoucher&quotationId='.($queryId1['quotationId']).'&apiurl='.$apiurl;
        
        $selectQuery2 = 'SELECT * FROM packageBuilderHotelMaster WHERE id="'.$queryId1['supplierId'] .'"';
        $fetch2 = mysqli_query(db(), $selectQuery2);
            while ($queryId2 = mysqli_fetch_assoc($fetch2)) {
                $hotelCategoryId =$queryId2['hotelCategoryId'];
                 
            
                 $selectQuery3 = 'SELECT * FROM hotelCategoryMaster WHERE id="'.$hotelCategoryId .'" ';
                    $fetch3 = mysqli_query(db(), $selectQuery3);
                    $queryId3 =mysqli_fetch_assoc($fetch3);
                    
                     $selectQuery4 = 'SELECT * FROM roomTypeMaster WHERE id="'.$roomtypeId .'" ';
                    $fetch4 = mysqli_query(db(), $selectQuery4);
                    $queryId4 =mysqli_fetch_assoc($fetch4);
                    
                    
                     $selectQuery5 = 'SELECT * FROM mealPlanMaster WHERE id="'.$mealPlan .'" ';
                    $fetch5 = mysqli_query(db(), $selectQuery5);
                    $queryId5 =mysqli_fetch_assoc($fetch5);
                    
                    $selectQuery6 = 'SELECT * FROM clientfeedbackmaster WHERE id="'.$queryId1['queryId'] .'" ';
                    $fetch6 = mysqli_query(db(), $selectQuery6);
                    $queryId6 =mysqli_fetch_assoc($fetch6);
                    
                    if($queryId6['clientrating']==""){
                        $clientrating='0';
                    }else{
                        $clientrating=$queryId6['clientrating'];
                    }
                    
                    
        
                $json_result[] = array(
                        "DayNumber" => $a++,
                        "DayId" => $queryId1['dayId'],
                        "QuotationId" => $quotationId,
                        "Date" => $queryId1['fromDate'],
                        "Services" => [[
                            "ID"=>"",
                            "ServiceTypeId" =>"Accommodation",
                            "ServiceID" =>"",
                            "ServiceTypeName" => $queryId2['hotelName'],
                            "ServiceCategory" => $queryId3['hotelCategory'],
                            "ServiceDetails" => "Room Type:".$queryId4['name'],
                            "ServiceDetails_01" => "Meal Plan :".$queryId5['name'],
                            "StartDate" => $queryId1['fromDate'],
                            "EndDate" => $queryId1['toDate'],
                            "StartTime" => $queryId2['checkInTime'],
                            "EndTime" => $queryId2['checkOutTime'],
                            "Feedback" => $clientrating,
                            "VoucherURL" => $voucher
                            
                        ]]
                );
                    
                
           
            }
            
            
         }
    
    
}else {
        $json_result[] = array(
            "error" => "Please insert refrence Id"
        );
    }
echo json_encode(array(
    "status" => "true",
    "QuotationId" => $quotationId,
    "QuotationRefNo" => $queryId['referanceNumber'],
    "DisplayId" => $queryId['displayId'],
    "Days" => $json_result
));


?>
