<?php 

include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


$feedback = $_REQUEST['feedback'];
$serviceType = $_REQUEST['serviceType'];
$serviceId = $_REQUEST['serviceId'];
$quotationId = $_REQUEST['quotationId'];

if($feedback>0){
    $namevalue = 'quotationId="'.$quotationId.'",serviceId="'.$serviceId.'",serviceType="'.$serviceType.'",clientrating="'.$feedback.'",sectionType="Itinerary"';
    $lasId = addlistinggetlastid('clientfeedbackmaster',$namevalue);

    if($feedback==1){
        $feedback = 'Poor';
    }elseif($feedback==2){
        $feedback = 'Average';
    }elseif($feedback==3){
        $feedback = 'Good';
    }elseif($feedback==4){
        $feedback = 'Very Good';
    }elseif($feedback==5){
        $feedback = 'Excellent';
    }

    $message = 'Thank You For FeedBack';

    if($lasId>0){

        $json_result = '{
            "feed" : "'.$feedback.'",
            "msg" : "'.$message.'",
            "serviceType" : "'.$serviceType.'",
            "quotationId" : "'.$quotationId.'",
            "serviceId" : "'.$serviceId.'"
        }';
    }
    ?>
    {
    "status":"true",
    "result":[<?php echo $json_result; ?>]
    }
    <?php
}

?>
