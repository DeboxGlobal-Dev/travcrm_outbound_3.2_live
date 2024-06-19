<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$experience = $_REQUEST['experience'];
$refid = $_REQUEST['refid'];

$select='*';
$where='referanceNumber="'.$refId.'" order by id desc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$queryId=$querydata['id'];

if(strlen($experience)>0){
    $namevalue = 'queryId="'.$queryId.'",RefId="'.$refid.'",clientexperience="'.$experience.'",sectionType="TripFeedback"';
    $lasId = addlistinggetlastid('clientfeedbackmaster',$namevalue);

    $message = 'Thank You For Sharing Your Experience';

    if($lasId>0){

        $json_result = '{
            "refid" : "'.$refId.'",
            "expfeedback" : "'.$experience.'",
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