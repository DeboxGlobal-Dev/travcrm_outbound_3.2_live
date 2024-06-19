<?php
include "../inc.php";
header("Content-Type: application/json");
if(isset($_REQUEST)){
        echo"sourav";
    $query=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferQuotId.'"');  
    $transfertimeline=mysqli_fetch_assoc($query);
    while($transfertimeline){
        
    
    $pickupAddress[]=strip($transfertimeline['pickupAddress']);
    $dropAddress[]=strip($transfertimeline['dropAddress']);
    
    }     
        echo json_encode([
            "status"=>"true",
            "result"=>[[
            "service"=>"",
            "pickupaddress"=> "$pickupAddress",
            "dropaddress"=> "$dropAddress",
            "roundtrip"=> "",
            "triptitle"=> "" ]]
            ]);

}

?>