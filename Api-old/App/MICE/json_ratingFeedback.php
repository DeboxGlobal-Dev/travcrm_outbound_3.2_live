<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$tripFeedback = $_REQUEST['tripFeedback'];
$refId = $_REQUEST['refId'];

$select='*';
$where='referanceNumber="'.$refId.'" order by id desc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$queryId=$querydata['id'];

if($tripFeedback>0){
    $namevalue = 'queryId="'.$queryId.'",RefId="'.$refId.'",clientrating="'.$tripFeedback.'",sectionType="TripFeedback"';
    $lasId = addlistinggetlastid('clientfeedbackmaster',$namevalue);

    if($tripFeedback==1){
        $tripFeedback = 'Poor';
    }elseif($tripFeedback==2){
        $tripFeedback = 'Average';
    }elseif($tripFeedback==3){
        $tripFeedback = 'Good';
    }elseif($tripFeedback==4){
        $tripFeedback = 'Very Good';
    }elseif($tripFeedback==5){
        $tripFeedback = 'Excellent';
    }

    $message = 'Thank You For FeedBack';

    if($lasId>0){

        $json_result = '{
            "refId" : "'.$refId.'",
            "tripfeedback" : "'.$tripFeedback.'",
            "msg" : "'.$message.'"
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